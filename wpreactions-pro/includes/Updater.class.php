<?php

namespace WPRA;

use WP_Error;
use WPRA\Helpers\NoticeContext;
use WPRA\Helpers\Notices;
use WPRA\Helpers\Utils;
use WPRA\Helpers\Logger;

class Updater {

    static function instance() {
        return new self();
    }

    public function __construct() {
        add_filter('pre_set_site_transient_update_plugins', [$this, 'check_update']);
        add_filter('plugins_api', [$this, 'plugins_api'], 10, 3);
        add_action('in_plugin_update_message-' . WPRA_PLUGIN_BASENAME, [$this, 'no_license_message'], 10, 2);
        add_action('admin_notices', [$this, 'printAllNotices']);
    }

    // Take over the update check
    function check_update($transient) {

        if (empty($transient->checked)) return $transient;

        $api_data = $this->get_plugin_info_from_api('check_update');
        
        if (!$api_data) return $transient;

        foreach ($api_data as $slug => $data) {
            $basename = Utils::slug_to_basename($slug);
            unset($transient->response[$basename]);
            $transient->response[$basename] = $data;
        }

        return $transient;
    }

    // Take over the Plugin info screen
    function plugins_api($result, $action, $args) {
        if (!isset($args->slug) || !in_array($args->slug, ['wpreactions-pro', 'my-reactions-uploader'])) {
            return false;
        }

        $api_data = $this->get_plugin_info_from_api($action);
        if ($api_data === false) {
            return new WP_Error('plugins_api_failed', __('An Unexpected HTTP Error occurred during the API request.', 'wpreactions'));
        }

        return $api_data[$args->slug];
    }

    function printAllNotices() {
        $screen = get_current_screen();
        if (strpos($screen->id, 'page_wpra') !== false) {
            return;
        }
        Notices::printAll();
    }

    function get_plugin_info_from_api($action, $ssl_verify = true) {
        $buyer_data = array_merge(
            [
                'action'          => $action,
                'current_version' => WPRA_VERSION, // TODO: remove later
                'version'         => WPRA_VERSION,
                'wp_version'      => App::$wp_version,
            ],
            App::instance()->license()->get_stored_info()
        );

        $request = [
            'body'       => json_encode($buyer_data),
            'user-agent' => 'WordPress/' . WPRA_VERSION . '; ' . get_bloginfo('url'),
            'headers'    => ['Content-Type' => 'application/json; charset=utf-8'],
            'sslverify'  => $ssl_verify,
        ];

        Logger::debug('Updater::get_plugin_info_from_api.request', $request);

        $resp = wp_remote_post(Config::UPDATE_API, $request);

        // if there is any issue with ssl verification, send request without verification
        if ($ssl_verify && Utils::sslIssueDetected($resp)) {
            return $this->get_plugin_info_from_api($action, false);
        }

        if (is_wp_error($resp) || $resp['response']['code'] != 200) return false;

        $api_data = json_decode($resp['body']);

        if (empty($api_data) || json_last_error() != JSON_ERROR_NONE) return false;

        return $this->normalize_api_resp($api_data);
    }

    private function normalize_api_resp($resp) {
        $info = [];
        foreach ($resp as $plugin => $data) {
            $info[$plugin] = new \stdClass();
            foreach ($data as $key => $item) {
                if (is_object($item)) {
                    $item = (array)$item;
                }
                $info[$plugin]->{$key} = $item;
            }
        }

        return $info;
    }

    function no_license_message($plugin_data, $response) {
        if (isset($response->license_status)) {
            Utils::renderTemplate("view/admin/plugin-messages/$response->license_status-license");
        }
        if (isset($response->invalid_domain) && $response->invalid_domain) {
            Utils::renderTemplate("view/admin/plugin-messages/invalid-domain");
        }
    }

    function check_update_hourly() {
        $api_data = $this->get_plugin_info_from_api('check_update_hourly');

        Logger::debug('Updater::check_update_hourly.api_data', $api_data);

        if (!$api_data) return;

        Notices::clearAll();
        $plugin = $api_data['wpreactions-pro'];

        if ($plugin->invalid_domain) {
            Notices::add('invalid_domain', 'error');
            App::instance()->license()->remove();
        }

        if (in_array($plugin->license_status, ['invalid', 'revoked', 'suspended'])) {
            Notices::add($plugin->license_status . '_license', 'error');
            App::instance()->license()->remove();

            return;
        }

        foreach ($plugin->addons as $addon) {
            if ($addon->valid) continue;
            App::instance()->addon()->kill($addon->slug);
            Notices::add('addon_activation', 'error', NoticeContext::ALL, [
                'message' => $addon->error->message,
            ]);
        }

        if ($plugin->license_status == 'expired') {
            Notices::add('expired_license', 'warning');

            return;
        }

        if (version_compare($plugin->new_version, WPRA_VERSION, '>')) {
            Notices::add('check_update', 'warning');
        }
    }

} // end of class