<?php

namespace WPRA\Helpers;

use WPRA\App;

class AjaxFactory {
    private $admin_actions = [];
    private $user_actions = [];

    const EDIT_ACCESS = ['access_wpreactions', 'edit_wpreactions'];
    const READ_ACCESS = ['access_wpreactions'];

    public function __construct($prefix) {
        add_action("wp_ajax_{$prefix}_handle_admin_requests", [$this, 'handle_admin_requests']);
        add_action("wp_ajax_{$prefix}_handle_user_requests", [$this, 'handle_user_requests']);
        add_action("wp_ajax_nopriv_{$prefix}_handle_user_requests", [$this, 'handle_user_requests']);
    }

    function add($name, $caps = null, $nopriv = false) {
        $action = [
            'callback' => [$this, $name],
            'caps'     => $caps,
        ];

        if ($nopriv) {
            $this->user_actions[$name] = $action;
        } else {
            $this->admin_actions[$name] = $action;
        }
    }

    function handle_user_requests() {
        $sub_action_var = isset($_POST['sub_action']) ? $_POST['sub_action'] : $_GET['sub_action'];
        $sub_action = sanitize_text_field($sub_action_var);
        
        if (!array_key_exists($sub_action, $this->user_actions)) {
            wp_die();
        }
        call_user_func($this->user_actions[$sub_action]['callback']);
    }

    function handle_admin_requests() {
        $sub_action_var = isset($_POST['sub_action']) ? $_POST['sub_action'] : $_GET['sub_action'];
        $sub_action = sanitize_text_field($sub_action_var);

        if (!array_key_exists($sub_action, $this->admin_actions)) {
            wp_die();
        }
        if (!App::currentUserCan($this->admin_actions[$sub_action]['caps'])) {
            echo json_encode([
                'status'  => 'error',
                'message' => __('You do not have permission to perform this action', 'wpreactions'),
            ]);
            wp_die();
        }
        call_user_func($this->admin_actions[$sub_action]['callback']);
    }

    function send($resp = null, $code = 200) {
        http_response_code($code);

        if (is_array($resp)) {
            header('Content-Type: application/json; charset=UTF-8');
            echo json_encode($resp);
        } else if (is_string($resp)) {
            echo $resp;
        }
        die();
    }
}