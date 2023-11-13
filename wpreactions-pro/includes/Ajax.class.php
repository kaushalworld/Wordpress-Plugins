<?php

namespace WPRA;

use WPRA\Helpers\AjaxFactory;
use WPRA\Helpers\Notices;
use WPRA\Integrations\WPML;
use WPRA\Helpers\Utils;
use WPRA\Database\Query;
use WPRA\Helpers\Logger;

class Ajax extends AjaxFactory {

    function __construct($prefix) {
        parent::__construct($prefix);
        $this->add('preview', self::READ_ACCESS);
        $this->add('submit_feedback', self::READ_ACCESS);
        $this->add('my_sgc_nav', self::READ_ACCESS);
        $this->add('search_shortcode', self::READ_ACCESS);
        $this->add('get_chart_data', self::READ_ACCESS);
        $this->add('render_emotional_data', self::READ_ACCESS);
        $this->add('render_social_data', self::READ_ACCESS);
        $this->add('analytics_table_navigate', self::READ_ACCESS);
        $this->add('render_analytics_table', self::READ_ACCESS);

        $this->add('save_options', self::EDIT_ACCESS);
        $this->add('reset_global', self::EDIT_ACCESS);
        $this->add('save_shortcode', self::EDIT_ACCESS);
        $this->add('delete_shortcode', self::EDIT_ACCESS);
        $this->add('clone_shortcode', self::EDIT_ACCESS);
        $this->add('edit_shortcode', self::EDIT_ACCESS);
        $this->add('save_settings', self::EDIT_ACCESS);
        $this->add('remove_update_notice', self::EDIT_ACCESS);
        $this->add('reset_reaction_counts', self::EDIT_ACCESS);
        $this->add('take_license_action', self::EDIT_ACCESS);
        $this->add('generate_random_fake_counts', self::EDIT_ACCESS);
        $this->add('dismiss_license_alert', self::EDIT_ACCESS);
        $this->add('dismiss_notice', self::EDIT_ACCESS);
        $this->add('download_logs', self::EDIT_ACCESS);

        $this->add('react', null, true);
        $this->add('register_social_click', null, true);
    }

    static function init($prefix) {
        return new self($prefix);
    }

    function save_options() {
        $options  = json_decode(stripslashes($_POST['options']), true);
        $extra    = json_decode(stripslashes($_POST['extra']), true);
        $received = Utils::explodeTree($options, '-');

        // called when global activation layout switch changes
        if (isset($extra['single']) and $extra['single'] == 1) {
            update_option('wpra_global_activation', $received['activation']);
            update_option('wpra_layout', $received['layout']);
        } else {
            // integrates WPML
            WPML::register_package_actions($received);
            // Sync analytics data
            Analytics\Controller::sync($extra);
            // save global options
            Config::updateLayoutOptions($received['layout'], $received);
        }

        $this->send([
            'status'  => 'success',
            'message' => __('Options updated successfully', 'wpreactions'),
        ]);
    }

    function preview() {
        $sgc_id = isset($_POST['sgc_id']) ? sanitize_text_field($_POST['sgc_id']) : 0;

        if ($sgc_id > 0) {
            $selector          = ".wpra-plugin-container[data-sgc_id=\"$sgc_id\"]";
            $options           = Shortcode::getSgcDataBy('id', $sgc_id, ['options']);
            $options['sgc_id'] = $sgc_id;
        } else {
            $posted            = json_decode(stripslashes($_POST['options']), true);
            $options           = Utils::explodeTree($posted, '-');
            $options['source'] = 'admin_preview';
            $selector          = ".wpra-plugin-container[data-preview_source=\"{$options['custom_data']['preview_source']}\"]";
        }

        $options['bind_id'] = 'preview';

        ob_start();
        Enqueue::printStyle("admin_preview", $selector, $options);
        $style     = ob_get_clean();
        $shortcode = Shortcode::build($options);

        $this->send($style . $shortcode);
    }

    function reset_global() {
        foreach (Config::$layouts as $layout => $config) {
            Config::updateLayoutOptions($layout, $config['defaults']);
        }

        $this->send([
            'status'  => 'success',
            'message' => __('Factory settings have been successfully updated...', 'wpreactions'),
        ]);
    }

    function submit_feedback() {
        $email   = sanitize_text_field($_POST['email']);
        $message = sanitize_text_field($_POST['message']);
        $rating  = sanitize_text_field($_POST['rating']);

        $resp = wp_remote_post(
            Config::FEEDBACK_API,
            [
                'method' => 'POST',
                'body'   => [
                    'email'   => $email,
                    'message' => $message,
                    'rating'  => $rating,
                    'secure'  => 'daEFZIqbUpouTLibklIVhqyg8XDKHNOW',
                ],
            ]
        );

        $status_code = wp_remote_retrieve_response_code($resp);

        if (is_wp_error($resp) and $status_code != 200) {
            $response['status']  = 'error';
            $response['message'] = __('Something went wrong', 'wpreactions');
        } else {
            $response['status']        = 'success';
            $response['message_title'] = __('Thank you for your Feedback!', 'wpreactions');
            $response['message']       = __('Your message has been received and we are working on it!', 'wpreactions');
        }

        $this->send($response);
    }

    function react() {
        global $wpdb;
        $is_valid_request = check_ajax_referer('wpra-react-action', 'checker', false);

        if (!$is_valid_request) {
            $this->send('Invalid request!');
        }

        $response = [];

        $bind_id    = sanitize_text_field($_POST['bind_id']);
        $emoji_id   = sanitize_text_field($_POST['emoji_id']);
        $source     = sanitize_text_field($_POST['source']);
        $sgc_id     = sanitize_text_field($_POST['sgc_id']);
        $user_id    = get_current_user_id();
        $react_id   = '';
        $is_reacted = false;

        if (Config::$settings['user_reaction_limitation'] == 1 && isset($_COOKIE['react_id'])) {
            $react_id = $_COOKIE['react_id'];

            $is_reacted = Query\Select
                    ::create()
                    ->table(Config::$tbl_reacted_users)
                    ->fields('count(*)')
                    ->where(['bind_id' => $bind_id, 'react_id' => $react_id])
                    ->one()
                    ->run()
                    ->result() > 0;
        }

        if (empty($react_id)) {
            $react_id = uniqid();
            setcookie('react_id', $react_id, time() + (86400 * 365), "/"); // 86400 = 1 day
        }

        $data = [
            'bind_id'      => $bind_id,
            'react_id'     => $react_id,
            'reacted_date' => date('Y-m-d H:i:s'),
            'source'       => $source,
            'emoji_id'     => $emoji_id,
            'user_id'      => $user_id,
            'sgc_id'       => $sgc_id,
            'post_type'    => Utils::get_post_type($bind_id),
        ];

        if ($is_reacted) {
            $status = Query\Update
                ::create()
                ->table(Config::$tbl_reacted_users)
                ->sets($data)
                ->where(['react_id' => $react_id, 'bind_id' => $bind_id])
                ->run()
                ->getAffectedRows() > 0 ? 'success' : 'error';

            $response['action'] = 'update';
            $response['status'] = $status;
        } else {
            $query = Query\Insert
                ::create()
                ->table(Config::$tbl_reacted_users)
                ->values($data)
                ->run();

            $response['action'] = 'insert';
            $response['status'] = $query->isSuccess() ? 'success' : 'error';
        }

        if ($response['status'] == 'error') {
            $response['error_message'] = $wpdb->last_error;
        }

        do_action('wpreactions/user/react', $data, $response);

        $this->send($response);
    } // end of react

    function register_social_click() {
        global $wpdb;
        $is_valid_request = check_ajax_referer('wpra-share-action', 'checker', false);

        if (!$is_valid_request) {
            $this->send('Invalid request!');
        }

        $platform = sanitize_text_field($_POST['platform']);
        $bind_id  = sanitize_text_field($_POST['bind_id']);
        $source   = sanitize_text_field($_POST['source']);
        $sgc_id   = sanitize_text_field($_POST['sgc_id']);
        $user_id  = get_current_user_id();

        // TODO: remove it later, it is for support new sgc_id column, version 2.6.4
        $wpdb->update(
            Config::$tbl_social_stats,
            ['sgc_id' => $sgc_id],
            ['bind_id' => $bind_id]
        );

        $data = [
            'bind_id'    => $bind_id,
            'platform'   => $platform,
            'click_date' => date('Y-m-d H:i:s'),
            'source'     => $source,
            'user_id'    => $user_id,
            'sgc_id'     => $sgc_id,
            'post_type'  => Utils::get_post_type($bind_id),
        ];

        $response           = [];
        $response['status'] = $wpdb->insert(Config::$tbl_social_stats, $data) > 0
            ? 'success' : 'error';

        if ($response['status'] == 'error') {
            $response['error_message'] = $wpdb->last_error;
        }

        do_action('wpreactions/user/socialShare', $data, $response);

        $this->send($response);
    }

    function save_shortcode() {
        $options      = json_decode(stripslashes($_POST['options']), true);
        $received     = Utils::explodeTree($options, '-');
        $id           = sanitize_text_field($_POST['shortcode_id']);
        $name         = sanitize_text_field($_POST['shortcode_name']);
        $front_render = sanitize_text_field($_POST['front_render']);
        $post_type    = Utils::nullString(sanitize_text_field($_POST['shortcode_post_type']));
        $sgc_id       = Shortcode::saveShortcodeData($received, $id, $name, $post_type, $front_render);

        // register WPML support for the shortcode
        WPML::register_package_actions($received, $sgc_id);

        $shortcode_text = is_null($post_type)
            ? '[wpreactions sgc_id="' . $sgc_id . '"]'
            : '[wpreactions sgc_id="' . $sgc_id . '" bind_to_post="yes"]';

        $this->send([
            'status'    => 'success',
            'message'   => $id == 0 ? __('Your shortcode created successfully') : __('Your shortcode updated successfully'),
            'shortcode' => $shortcode_text,
            'sgc_id'    => $sgc_id,
        ]);
    }

    function delete_shortcode() {
        $sgc_id = sanitize_text_field($_POST['sgc_id']);

        $response = [
            'status'  => 'success',
            'message' => __('Shortcode deleted successfully', 'wpreactions'),
        ];

        if (!Shortcode::deleteShortcode($sgc_id)) {
            $response['status']  = 'error';
            $response['message'] = __('Could not delete shortcode', 'wpreactions');
        }

        $this->send($response);
    }

    function clone_shortcode() {
        $sgc_id = sanitize_text_field($_POST['sgc_id']);

        $response = [
            'status'  => 'success',
            'message' => __('Shortcode cloned successfully', 'wpreactions'),
        ];

        if (!Shortcode::cloneShortcode($sgc_id)) {
            $response['status']  = 'error';
            $response['message'] = __('Could not clone shortcode', 'wpreactions');
        }

        $this->send($response);
    }

    function edit_shortcode() {
        $sgc_id = sanitize_text_field($_POST['sgc_id']);

        $response = [
            'status'  => 'error',
            'message' => __('Could not edit shortcode', 'wpreactions'),
        ];

        $options = Shortcode::getSgcDataBy('id', $sgc_id, ['options']);

        if (!empty($options)) {
            $response['status']       = 'success';
            $response['sgc_edit_url'] = Utils::getAdminPage('shortcode') . "&sgc_action=edit&id=$sgc_id&layout={$options['layout']}";
        }

        $this->send($response);
    }

    function search_shortcode() {
        $needle = sanitize_text_field($_POST['needle']);
        $this->send(Shortcode::listShortcodes($needle));
    }

    function my_sgc_nav() {
        $page = sanitize_text_field($_POST['page']);
        $this->send(Shortcode::listShortcodes($page, true));
    }

    function save_settings() {
        $settings = json_decode(stripslashes($_POST['settings']), true);
        Shortcode::updateShortcodePostType($settings['woo_shortcode_id'], 'product');
        Config::updateSettings($settings);

        $this->send([
            'status'  => 'success',
            'message' => __('Settings saved successfully!'),
        ]);
    }

    function reset_reaction_counts() {
        global $wpdb;
        $global    = sanitize_text_field($_POST['global']);
        $shrotcode = sanitize_text_field($_POST['shortcode']);
        $tbl       = Config::$tbl_reacted_users;

        $sql = "delete r from $tbl as r 
	    left join $wpdb->posts as p 
	    on r.bind_id = CAST(p.ID as CHAR) COLLATE utf8mb4_unicode_520_ci 
	    where p.ID ";

        $message = '';

        if ($global && $wpdb->query($sql . 'is not null') !== false) {
            $message .= __('Global', 'wpreactions');
        }
        if ($shrotcode && $wpdb->query($sql . 'is null') !== false) {
            $amp     = $global ? ' & ' : '';
            $message .= $amp . __('Shortcode', 'wpreactions');
        }

        $this->send([
            'status'  => 'success',
            'message' => $message . ' ' . __('counts reset successfully', 'wpreactions'),
        ]);
    }

    function take_license_action() {
        $license_action = sanitize_text_field($_POST['license_action']);
        $email          = ($license_action == 'revoke') ? get_option('pk_license_email') : sanitize_email($_POST['email']);
        $licenseKey     = ($license_action == 'revoke') ? get_option('pk_license_key') : sanitize_text_field($_POST['license_key']);
        $this->send(App::instance()->license()->doAction($email, $licenseKey, $license_action));
    }

    function get_chart_data() {
        $chart_type = sanitize_text_field($_POST['chart_type']);
        $interval   = sanitize_text_field($_POST['interval']);
        $source     = sanitize_text_field($_POST['source']);
        $sgc_id     = sanitize_text_field($_POST['sgc_id']);

        $response = null;

        switch ($chart_type) {
            case 'reactions_line':
                $response = Analytics\Controller::getFor($source, $sgc_id)->reactions_line($interval);
                break;
            case 'social_share_line':
                $response = Analytics\Controller::getFor($source, $sgc_id)->social_share_line($interval);
                break;
            case 'reactions_column':
                $response = Analytics\Controller::getFor($source, $sgc_id)->reactions_counts($interval);
                break;
            case 'social_column':
                $response = Analytics\Controller::getFor($source, $sgc_id)->social_counts($interval);
                break;
        }

        $this->send($response);
    }

    function render_emotional_data() {
        $source = sanitize_text_field($_POST['source']);
        $sgc_id = sanitize_text_field($_POST['sgc_id']);

        $this->send(Analytics\Controller::getFor($source, $sgc_id)->get_emotional_data_view());
    }

    function render_social_data() {
        $source = sanitize_text_field($_POST['source']);
        $sgc_id = sanitize_text_field($_POST['sgc_id']);

        $this->send(Analytics\Controller::getFor($source, $sgc_id)->get_social_data_view());
    }

    function analytics_table_navigate() {
        $source = sanitize_text_field($_POST['source']);
        $sgc_id = sanitize_text_field($_POST['sgc_id']);
        $page   = sanitize_text_field($_POST['page']);
        $table  = sanitize_text_field($_POST['table']);

        $response = null;

        switch ($table) {
            case 'reactions':
                $response = Analytics\Controller::getFor($source, $sgc_id)->get_reactions_table($page);
                break;
            case 'social':
                $response = Analytics\Controller::getFor($source, $sgc_id)->get_social_table($page);
                break;
            case 'reactions-user':
                $response = Analytics\Controller::getFor($source, $sgc_id)->get_reactions_user_table($page);
                break;
            case 'social-user':
                $response = Analytics\Controller::getFor($source, $sgc_id)->get_social_user_table($page);
                break;
        }

        $this->send($response);
    }

    function generate_random_fake_counts() {
        $response = [];

        if (!Config::isGlobalActivated()) {
            $response['status']  = 'error';
            $response['message'] = __('You must first activate plugin globally', 'wpreactions');
            $this->send($response);
        }

        $type = sanitize_text_field($_POST['type']);

        // if button_reveal supports total social counts, then remove this check
        if ($type == 'social' && Config::$active_layout == 'button_reveal') {
            $response['status']  = 'error';
            $response['message'] = __('Global active layout "Reaction button" does\'t support total social counts', 'wpreactions');
            $this->send($response);
        }

        $post_types      = json_decode(stripslashes(sanitize_text_field($_POST['post_types'])), true);
        $reaction_ranges = Config::$active_layout_opts['random_fake_counts_range'];
        $social_range    = Config::$active_layout_opts['social']['random_fake_range'];

        foreach ($post_types as $post_type) {
            $posts = get_posts(['post_type' => $post_type, 'numberposts' => -1]);
            foreach ($posts as $post) {
                if ($type == 'reactions') {
                    $counts = [];
                    foreach ($reaction_ranges as $emoji_id => $reaction_range) {
                        $counts[$emoji_id] = Utils::randomFromRange($reaction_range);
                    }
                    update_post_meta($post->ID, '_wpra_start_counts', $counts);
                }
                if ($type == 'social') {
                    update_post_meta($post->ID, '_wpra_fake_share_count', Utils::randomFromRange($social_range));
                }
            }
        }

        $response['status']  = 'success';
        $response['message'] = __('Random counts generated successfully', 'wpreactions');

        $this->send($response);
    }

    function dismiss_license_alert() {
        update_option('wpra_dismiss_lk_alert', 'yes');
        $this->send(['status' => 'success']);
    }

    function dismiss_notice() {
        $id = sanitize_text_field($_POST['id']);
        Notices::remove($id);
        $this->send(['status' => 'success']);
    }

    function download_logs() {
        $date = date('Y-m-d');

        header( 'Content-Type: text/csv' );
        header( 'Content-Disposition: attachment;filename=wpra_logs_' . $date . '.csv');

        Logger::generate_csv();
    }
}
