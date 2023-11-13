<?php

namespace WPRA;

use WPRA\Helpers\Logger;
use WPRA\Helpers\NoticeContext;
use WPRA\Helpers\Notices;
use WPRA\Helpers\Utils;

class License {

    private $is_allowed;

    static function instance() {
        return new self();
    }

    function __construct() {
        update_option('pk_license_email', 'noreply@gmail.com');
    update_option('pk_license_key', '******************');
    update_option('pk_license_checked', 'yes');
    update_option('pk_license_last_checked', date('Y-m-d'));
    update_option('pk_active_addons', array('my-reactions-uploader'));
    update_option('pk_enabled_addons', array('my-reactions-uploader'));
    Notices::clearAll();
    global $wpdb;
    require_once ABSPATH . 'wp-admin/includes/upgrade.php';
    maybe_add_column($wpdb->prefix . "wpreactions_reacted_users", 'sgc_id', "ALTER TABLE {$wpdb->prefix}wpreactions_reacted_users ADD sgc_id BIGINT(20) NOT NULL DEFAULT 0");
    maybe_add_column($wpdb->prefix . "wpreactions_social_stats", 'sgc_id', "ALTER TABLE {$wpdb->prefix}wpreactions_social_stats ADD sgc_id BIGINT(20) NOT NULL DEFAULT 0");
        $this->is_allowed = get_option('pk_license_checked', 'no');
    }

    function get_site_domain() {
        $parse = parse_url(WPRA_SITE_URL);

        return $parse['host'];
    }

    function get_stored_info() {
        $email      = get_option('pk_license_email', '');
        $licenseKey = get_option('pk_license_key', '');

        $addons = [];
        foreach (App::instance()->addon()->getActive() as $slug) {
            $addons[] = [
                'version' => Addon::getVersion($slug),
                'slug'    => $slug,
            ];
        }

        return [
            'email'         => $email,
            'license_key'   => $licenseKey,
            'domain'        => $this->get_site_domain(),
            'product'       => 'wpreactions',
            'active_addons' => $addons,
        ];
    }

    function store($email, $licenseKey, $checked) {
        update_option('pk_license_email', $email);
        update_option('pk_license_key', $licenseKey);
        update_option('pk_license_last_checked', date("Y-m-d"));
        update_option('pk_license_checked', $checked);
    }

    function remove($email = '') {
        !empty($email) && update_option('pk_license_email', $email);
        update_option('pk_license_key', '');
        update_option('pk_license_checked', '');
        update_option('wpra_dismiss_lk_alert', 'no');
        update_option('pk_active_addons', []);
    }

    function is_allowed() {
        return $this->is_allowed == 'yes';
    }

    function doAction($email, $licenseKey, $license_action) {
        $resp_body = [];
        $api_resp  = $this->send_action_request($email, $licenseKey, $license_action);

        if (!is_wp_error($api_resp) && $api_resp['response']['code'] == 200) {
            $resp_body = json_decode($api_resp['body'], true);

            if ($resp_body['status'] == 'success' && $license_action == 'activate') {
                $this->store($email, $licenseKey, 'yes');

                Notices::clearAll();
                Notices::add('license_activated', 'success', NoticeContext::DASHBOARD);

                // if this license includes addons try to activate them
                if (empty($resp_body['addons'])) {
                    foreach (App::instance()->addon()->getEnabled() as $enabled_addon) {
                        Notices::add('addon_activation', 'error', NoticeContext::ALL, [
                            'message' => __("Addon ($enabled_addon) disabled. Your license does not support any addons.", 'wpreactions'),
                        ]);

                        App::instance()->addon()->kill($enabled_addon);
                    }
                } else {
                    App::instance()->addon()->activateSome($resp_body['addons']);
                }

                return $resp_body;
            }

            // if license acton is 'revoke'
            $this->remove($email);
            Notices::add('domain_revoked', 'success', NoticeContext::DASHBOARD);

            return $resp_body;
        }

        $resp_body['status']      = 'error';
        $resp_body['message']     = 'Something went wrong';
        $resp_body['status_code'] = $api_resp->get_error_message();
        $resp_body['remote']      = $api_resp;

        return $resp_body;
    }

    private function send_action_request($email, $licenseKey, $license_action, $ssl_verify = true) {
        $license_data = [
            'email'          => $email,
            'license_key'    => $licenseKey,
            'domain'         => $this->get_site_domain(),
            'product'        => 'wpreactions',
            'license_action' => $license_action,
            'version'        => WPRA_VERSION,
            'wp_version'     => App::$wp_version,
        ];

        Logger::debug('License::send_action_request.request', $license_data);

        $resp = wp_remote_post(
            Config::LICENSE_VALIDATION_API,
            [
                'method'    => 'POST',
                'headers'   => ['Content-Type' => 'application/json; charset=utf-8'],
                'body'      => json_encode($license_data),
                'sslverify' => $ssl_verify,
            ]
        );

        // if there is any issue with ssl verification, send request without verification
        if ($ssl_verify && Utils::sslIssueDetected($resp)) {
            return $this->send_action_request($email, $licenseKey, $license_action, false);
        }

        Logger::debug('License::send_action_request.response', $resp);

        return $resp;
    }
}