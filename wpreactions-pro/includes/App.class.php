<?php

namespace WPRA;

use wpdb;
use WPRA\Integrations\Cache;
use WPRA\Integrations\Woo;
use WPRA\Helpers\Utils;
use WPRA\Database\Query;
use WPRA\Helpers\NoticeContext;
use WPRA\Helpers\Notices;
use WPRA\Helpers\Cron;
use WPRA\Helpers\Logger;

class App {

    /** @var wpdb */
    static public $db;
    static public $wp_version;
    private $license;
    private $addon;
    private $ajax;
    private $cron;
    private static $_instance = null;
    const CONTENT_PRIORITY = 9999;

    function __construct() {
        self::$db         = $GLOBALS['wpdb'];
        self::$wp_version = $GLOBALS['wp_version'];

        Config::initialize();
        Migrations::handle();
        Enqueue::init();
        AdminPages::init();
        Metaboxes::render();
        Shortcode::register();
        Woo::init();
        Cache::init();

        $updater = Updater::instance();
        $this->license = License::instance();
        $this->addon   = Addon::instance();
        $this->ajax    = Ajax::init('wpra');

        // init crons
        $this->cron = Cron::instance([
            [
                'hook' => 'wpra_check_updates',
                'schedule' => 'hourly',
                'callback' => [$updater, 'check_update_hourly']
            ],
            [
                'hook' => 'wpra_clear_logs',
                'schedule' => 'weekly',
                'callback' => [Logger::class, 'clear_logs']
            ]
        ]);

        $this->registerHooks();
    }

    /**
     * @return \WPRA\App
     */
    public static function instance() {
        if (is_null(self::$_instance)) {
            self::$_instance = new self();
        }

        return self::$_instance;
    }

    private function registerHooks() {
        $this->handleActivation();
        $this->handleDeactivation();
        $this->handleInitHook();
        $this->excludeFromExcerpt();
        $this->adminFooterTemplates();
        $this->pluginActionLinks();
        $this->handlePostDeletion();
        $this->addAdminBodyClasses();
        add_filter('the_content', [$this, 'addContentToPost'], self::CONTENT_PRIORITY);
    }

    // run necessary actions on plugin activation
    private function handleActivation() {
        register_activation_hook(WPRA_PLUGIN_PATH . 'wpreactions-pro.php', function () {
            // does not support above wp version 4.7
            if (version_compare(self::$wp_version, '4.7', '<')) {
                deactivate_plugins(WPRA_PLUGIN_BASENAME);
                ob_start();
                require_once("view/admin/activation-errors/wp-version.php");
                wp_die(ob_get_clean());
            }

            if (is_plugin_active('wp-reactions-lite/wp-reactions-lite.php')) {
                deactivate_plugins('wp-reactions-lite/wp-reactions-lite.php');
                Notices::add('lite_deactivation', 'error', NoticeContext::ALL);
            }

            Activation::start();
        });
    }

    private function handleDeactivation() {
        register_deactivation_hook(WPRA_PLUGIN_PATH . 'wpreactions-pro.php', function () {
            // unschedule all crons
            $this->cron->unscheduleAll();

            // remove caps for the plugin
            $role = get_role('administrator');
            if ($role !== null) {
                $role->remove_cap('access_wpreactions');
                $role->remove_cap('edit_wpreactions');
            }

            if (is_plugin_active('my-reactions-uploader/my-reactions-uploader.php')) {
                deactivate_plugins('my-reactions-uploader/my-reactions-uploader.php');
            }
        });
    }

    private function handleInitHook() {
        add_action('init', function () {
            load_plugin_textdomain('wpreactions', false, dirname(WPRA_PLUGIN_BASENAME) . '/languages/');
            do_action('wpreactions/plugin/initialized');
        }, 20);
    }

    // purge data on post delete
    private function handlePostDeletion() {
        add_action('deleted_post', function ($post_id) {
            Analytics\Controller::deleteStats(false, $post_id, false);
        });
    }

    private function excludeFromExcerpt() {
        add_filter('get_the_excerpt', function ($content) {
            if (has_filter('the_content', [$this, 'addContentToPost']) !== false) {
                remove_filter('the_content', [$this, 'addContentToPost'], self::CONTENT_PRIORITY);
            }
            return $content;
        }, 9);

        add_filter('get_the_excerpt', function ($content) {
            add_filter('the_content', [$this, 'addContentToPost'], self::CONTENT_PRIORITY);
            return $content;
        }, 11);
    }

    function addContentToPost($content) {
        global $post;

        if (is_feed() || $post->post_type == 'product') {
            return $content;
        }

        $deploys   = Config::getGlobalDeployments();
        $post_type = $post->post_type;

        $allow_emojis = Utils::get_post_meta($post->ID, '_wpra_show_emojis');

        if ($allow_emojis == 'false') {
            return $content;
        }

        // if post_type bound to any sgc, then use it
        $sgc = Shortcode::getSgcDataBy('post_type', $post_type, ['id', 'front_render']);
        if (!is_null($sgc) && $sgc->front_render) {
            $reactions = do_shortcode("[wpreactions sgc_id=$sgc->id bind_to_post='yes']");
            return $content . $reactions;
        }

        // not activated globally
        if (!Config::isGlobalActivated()) {
            return $content;
        }

        // post type is not deployed auto or manually
        if (!Config::isGloballyDeployed($post_type)) {
            return $content;
        }

        if (in_array($post_type, $deploys['manual']) && $allow_emojis != 'true') {
            return $content;
        }

        $before    = $after = '';
        $reactions = Shortcode::handle();

        if (Config::$active_layout_opts['content_position'] == 'before') {
            $before = $reactions;
        } else if (Config::$active_layout_opts['content_position'] == 'after') {
            $after = $reactions;
        } else {
            $before = $after = $reactions;
        }

        return $before . $content . $after;
    }

    static function getFakeCounts($bind_id) {
        $fake_counts = get_post_meta($bind_id, '_wpra_start_counts', true);
        if (is_array($fake_counts) and !empty($fake_counts)) {
            return array_map('intval', $fake_counts);
        }

        return [];
    }

    static function getCountsTotal($bind_id, $fake_counts, $emojis) {
        if (empty($fake_counts)) {
            $fake_counts = self::getFakeCounts($bind_id);
        }

        $db_counts = self::getReactionCountsPerEmoji($bind_id, $emojis);

        $result = [];
        foreach ($emojis as $emoji_id) {
            $fake_count        = isset($fake_counts[$emoji_id]) ? intval($fake_counts[$emoji_id]) : 0;
            $db_count          = isset($db_counts[$emoji_id]) ? intval($db_counts[$emoji_id]) : 0;
            $result[$emoji_id] = $fake_count + $db_count;
        }

        return $result;
    }

    static function getReactionCountsPerEmoji($bind_id, $emojis) {

        $counts = Query\Select
            ::create()
            ->fields(['emoji_id', 'count(*) as count'])
            ->table(Config::$tbl_reacted_users)
            ->where(['bind_id' => $bind_id, 'emoji_id' => ['in', $emojis]])
            ->groupBy('emoji_id')
            ->output(ARRAY_A)
            ->run()
            ->result();

        return array_column($counts, 'count', 'emoji_id');
    }

    static function getFakeShareCounts($post_id, $default = 0) {
        $fake_share_count = get_post_meta($post_id, '_wpra_fake_share_count', true);

        return $fake_share_count == '' ? $default : intval($fake_share_count);
    }

    static function getUserReactedEmoji($bind_id) {
        $already = '';
        if (Config::$settings['user_reaction_limitation'] == 1 && isset($_COOKIE['react_id'])) {
            $already = Query\Select
                ::create()
                ->fields('emoji_id')
                ->table(Config::$tbl_reacted_users)
                ->where(['bind_id' => $bind_id, 'react_id' => $_COOKIE['react_id']])
                ->one()
                ->run()
                ->result();
        }

        return $already;
    }

    static function getTotalShareCounts($bind_id, $fake_count) {
        $fake_counts = empty($fake_count) ? self::getFakeShareCounts($bind_id) : $fake_count;
        $real_counts = self::getUserShareCounts($bind_id);

        return Utils::formatCount($real_counts + $fake_counts);
    }

    static function getUserShareCounts($bind_id) {
        return Query\Select
            ::create()
            ->fields('count(*)')
            ->table(Config::$tbl_social_stats)
            ->where(['bind_id' => $bind_id])
            ->one()
            ->run()
            ->result();
    }

    static function getSocialSharePerPlatform($bind_id) {
        $data = Query\Select
            ::create()
            ->fields(['platform', 'count(*) as clicks'])
            ->table(Config::$tbl_social_stats)
            ->where(['bind_id' => $bind_id])
            ->groupBy('platform')
            ->run()
            ->result();

        return array_column($data, 'clicks', 'platform');
    }

    private function pluginActionLinks() {
        add_filter('plugin_action_links_' . WPRA_PLUGIN_BASENAME, function ($links) {
            $links[] = '<a href="' . Utils::getAdminPage('dashboard') . '">' . __('Settings', 'wpreactions') . '</a>';
            $links[] = '<a target="_blank" href="https://wpreactions.com/support">' . __('Support', 'wpreactions') . '</a>';

            return $links;
        });
    }

    private function adminFooterTemplates() {
        add_action('admin_footer', function () {
            if (!Utils::isWpraAdmin()) return;

            Utils::renderTemplate('view/admin/components/floating-menu');
            Utils::renderTemplate('view/admin/components/modals/feedback-form');
            Utils::renderTemplate('view/admin/components/modals/reset-emoji-stats');
            Utils::renderTemplate('view/admin/components/modals/revoke-license');
            Utils::renderTemplate('view/admin/components/modals/reset-global-options');
        });
    }

    private function addAdminBodyClasses() {
        add_filter('admin_body_class', function ($cls) {
            return $cls . ' wpreactions-admin ';
        });
    }

    static function currentUserCan($caps) {
        if (empty($caps)) return true;

        $user = wp_get_current_user();
        if (!is_array($caps)) {
            return $user->has_cap($caps);
        }

        foreach ($caps as $cap) {
            if (!$user->has_cap($cap)) {
                return false;
            }
        }

        return true;
    }

    function license() {
        return $this->license;
    }

    function addon() {
        return $this->addon;
    }

    function ajax() {
        return $this->ajax;
    }

    /**
     * @return \WPRA\Helpers\Cron
     */
    function cron() {
        return $this->cron;
    }
} // end of WP Emoji class