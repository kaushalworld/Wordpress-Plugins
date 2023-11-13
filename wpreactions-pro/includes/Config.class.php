<?php

namespace WPRA;

use WPRA\Helpers\Utils;

class Config {
    static public $tbl_reacted_users;
    static public $tbl_shortcodes;
    static public $tbl_social_stats;
    static public $tbl_emojis;
    static public $tbl_logs;
    static public $global_activation = 'false';
    static public $active_layout = 'regular';
    static public $active_layout_opts;
    static public $settings;
    static public $top_menu_items = [];
    static public $layouts;
    static public $social_platforms;
    static public $builtin_emojis;
    static public $fontawesome_api;
    static public $default_settings;
    const MY_SHORTCODES_PAGE_LIMIT = 10;
    const FEEDBACK_API = 'https://wpreactions.com/api/v1/submit_feedback';
    const LICENSE_VALIDATION_API = 'https://wplicensepro.com/wp-json/api/v1/licenseActions';
    const UPDATE_API = 'https://wplicensepro.com/wp-json/api/v1/checkUpdates';
    const LICENSE_NOTIFY_ADDON_USAGE = 'https://wplicensepro.com/wp-json/api/v1/notifyAddonUsage';
    const MAX_EMOJI_ID = 200;
    const MAX_EMOJIS = 7;

    static function initialize() {
        global $wpdb;
        self::$tbl_reacted_users  = $wpdb->prefix . 'wpreactions_reacted_users';
        self::$tbl_shortcodes     = $wpdb->prefix . 'wpreactions_shortcodes';
        self::$tbl_social_stats   = $wpdb->prefix . 'wpreactions_social_stats';
        self::$tbl_emojis         = $wpdb->prefix . 'wpreactions_emojis';
        self::$tbl_logs           = $wpdb->prefix . 'wpreactions_logs';
        self::$active_layout      = self::get_option('wpra_layout');
        self::$global_activation  = self::get_option('wpra_global_activation');
        self::$settings           = self::get_option('wpra_settings', true);
        self::$active_layout_opts = self::getLayoutOptions(self::$active_layout);
        self::$layouts            = self::init_layout_defaults();
        self::$social_platforms   = self::read_json_config('social-platforms');
        self::$builtin_emojis     = self::read_json_config('builtin-emojis');
        self::$fontawesome_api    = self::read_json_config('fontawesome-api');
        self::$default_settings   = self::read_json_config('settings');
        self::$top_menu_items     = self::init_top_menu_items();
    }

    private static function init_layout_defaults() {
        $layouts        = self::read_json_config('layouts');
        $layouts_common = self::read_json_config('layouts-common');

        foreach ($layouts as $layout => $options) {
            $layouts[$layout]['defaults'] = array_merge($options['defaults'], $layouts_common);
        }

        return $layouts;
    }

    /**
     * Gets layout configuration value
     *
     * @param string $layout - name of layout
     * @param string $name - name of layout option
     * @param mixed $default - default value in case of option does not exist
     *
     * @return mixed
     */

    static function getLayoutValue($layout, $name, $default = '') {
        return isset(self::$layouts[$layout]) ? self::$layouts[$layout][$name] : $default;
    }

    /**
     * Gets layout options from database.
     * If layout is not exist empty array will be returned
     *
     * @param string $layout - name of layout
     *
     * @return array
     */

    static function getLayoutOptions($layout) {
        if (empty($layout)) {
            return [];
        }

        $options = get_option("wpra_options_$layout");

        return empty($options) ? [] : json_decode($options, true);
    }

    static function getLayoutDefaults($layout, $json_encode = false) {
        $defaults = self::getLayoutValue($layout, 'defaults', []);

        return $json_encode ? json_encode($defaults) : $defaults;
    }

    static function getLayoutDefaultOption($layout, $option, $default = '') {
        $defaults = self::getLayoutDefaults($layout);
        return isset($defaults[$option]) ? $defaults[$option] : $default;
    }

    static function read_json_config($name) {
        $json = file_get_contents(WPRA_PLUGIN_PATH . "conf/$name.json");

        return json_decode($json, true);
    }

    /**
     * Update layout options in database
     *
     * @param string $layout - name of layout
     * @param array $options - options to replace with current one
     *
     * @return void
     */

    static function updateLayoutOptions($layout, $options) {
        update_option("wpra_options_$layout", json_encode($options));
    }

    static function updateSettings($settings) {
        update_option('wpra_settings', json_encode($settings));
    }

    static function updateSetting($setting, $value) {
        Config::$settings[$setting] = $value;
        self::updateSettings(Config::$settings);
    }

    static function isGlobalActivated() {
        return self::$global_activation == 'true';
    }

    static function getGlobalDeployments($merged = false) {

        if ($merged) {
            return array_merge(self::$active_layout_opts['post_types_deploy_manual'], self::$active_layout_opts['post_types_deploy_auto']);
        }

        return [
            'auto'   => self::$active_layout_opts['post_types_deploy_auto'],
            'manual' => array_diff(self::$active_layout_opts['post_types_deploy_manual'], self::$active_layout_opts['post_types_deploy_auto']),
        ];
    }

    static function isGloballyDeployed($post_type) {
        return in_array($post_type, self::getGlobalDeployments(true));
    }

    static function getLayoutNames() {
        return array_keys(self::$layouts);
    }

    private static function get_option($option, $json_decode = false) {
        return $json_decode ? json_decode(get_option($option), true) : get_option($option);
    }

    private static function init_top_menu_items() {
        return [
            [
                'name'   => 'Dashboard',
                'link'   => Utils::getAdminPage('dashboard'),
                'icon'   => '<i class="qas qa-tachometer-alt"></i>',
                'target' => '',
            ],
            [
                'name'   => 'Global Activation',
                'link'   => Utils::getAdminPage('global'),
                'icon'   => '<i class="qas qa-globe-americas"></i>',
                'target' => '',
            ],
            [
                'name'   => 'Shortcode Generator',
                'link'   => Utils::getAdminPage('shortcode'),
                'icon'   => '<span class="wpra-icon wpra-icon-sh" style="width: 30px;height: 20px"></span>',
                'target' => '',
            ],
            [
                'name'   => 'My Shortcodes',
                'link'   => Utils::getAdminPage('shortcode-edit'),
                'icon'   => '<i class="qa qa-list"></i>',
                'target' => '',
            ],
            [
                'name'   => 'Woo Reactions',
                'link'   => Utils::getAdminPage('settings', [], '#wpra-woocommerce-content'),
                'icon'   => '<span class="wpra-icon wpra-icon-woo" style="width: 30px;height: 20px"></span>',
                'target' => '',
            ],
            [
                'name'   => 'Analytics',
                'link'   => Utils::getAdminPage('analytics'),
                'icon'   => '<i class="qas qa-chart-bar"></i>',
                'target' => '',
            ],
            [
                'name'   => 'Feedback',
                'link'   => '#toggle-feedback-form',
                'icon'   => '<i class="qar qa-comment-dots"></i>',
                'target' => '',
            ],
            [
                'name'   => 'Tools',
                'link'   => Utils::getAdminPage('tools'),
                'icon'   => '<i class="qas qa-tools"></i>',
                'target' => '',
            ],
            [
                'name'   => 'Settings',
                'link'   => Utils::getAdminPage('settings'),
                'icon'   => '<i class="qa qa-cog"></i>',
                'target' => '',
            ],
        ];
    }

} // end of Configuration class
