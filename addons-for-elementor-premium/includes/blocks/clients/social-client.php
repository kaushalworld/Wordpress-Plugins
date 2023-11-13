<?php

namespace LivemeshAddons\Blocks\Clients;

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

abstract class LAE_Social_Client {

    /**
     * YouTube transient
     *
     */
    protected $transient_sec;

    /**
     * YouTube error
     *
     */
    protected $error;

    /**
     * Grid data
     *
     */
    protected $settings;

    /**
     * Items per page
     *
     */
    protected $items_per_page;

    /**
     * Items retrieved
     *
     */
    protected $items = array();


    /**
     * Return array of grid settings
     */
    public function get_settings() {

        return $this->settings;

    }

    /**
     * Return array of data
     *
     */
    public abstract function get_grid_items();

    protected function bail($error_text, $error_object = '') {

        if (is_wp_error($error_object)) {

            $error_text .= ' - Error Encountered: ' . $error_object->get_error_message();
        }
        elseif (!empty($error_object) && isset($error_object['response']['message'])) {

            $error_text .= '<br>';

            $error_text .= __(' ( Error Message: ', 'livemesh-el-addons') . $error_object['response']['message'] . ' )';
            $error_text .= __(' ( Error Code: ', 'livemesh-el-addons') . $error_object['response']['code'] . ' )';

            $result = json_decode($error_object['body']);

            // if an access token exist then store it
            if (isset($result->errors) && is_array($result->errors)) {
                $error_text .= '<br>';
                $error_text .= __(' Further Details: ', 'livemesh-el-addons');
                $error_text .= __(' ( Code: ', 'livemesh-el-addons') . $result->errors[0]->code . ' )';
                $error_text .= __(' ( Message: ', 'livemesh-el-addons') . $result->errors[0]->message . ' )';
            }

        }

        throw new \Exception($error_text);

    }

}