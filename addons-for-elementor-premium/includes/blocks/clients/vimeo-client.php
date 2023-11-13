<?php

/* https://developer.vimeo.com/api/reference */

namespace LivemeshAddons\Blocks\Clients;

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

class LAE_Vimeo_Client extends LAE_Social_Client {

    /**
     * Vimeo API Key
     *
     */
    private $access_token;

    /**
     * Vimeo query meta
     *
     */
    private $query_meta = array();

    /**
     * Vimeo parameters
     *
     */
    private $order;
    private $sort;
    private $source_type;
    private $source_id;

    /**
     * Initialize the class and set its properties.
     *
     */
    public function __construct($settings = '', $query_meta = array()) {

        $this->set_transient_expiration();
        // $this->get_access_token(); // using client id and client secret
        $this->get_personal_access_token(); // switched to using authenticated personal access token

        $this->settings = $settings;

        // get last media from ajax
        $this->query_meta = $query_meta;
        $this->query_meta['page'] = (isset($this->query_meta['page'])) ? (int)$this->query_meta['page'] : 1;
        $this->query_meta['offset'] = (isset($this->query_meta['offset'])) ? (int)$this->query_meta['offset'] : 0;
        $this->query_meta['total'] = (isset($this->query_meta['total'])) ? (int)$this->query_meta['total'] : null;

    }

    /**
     * Return array of grid settings
     */
    public function get_settings() {

        return $this->settings;

    }

    /**
     * Return the query meta required for load more requests
     */
    public function get_query_meta() {

        return $this->query_meta;

    }

    /**
     * Set the number of videos remaining to be shown
     */
    public function get_remaining() {

        $remaining = 0;

        if (isset($this->query_meta['total']) && ($this->query_meta['total'] > $this->query_meta['offset']))
            $remaining = $this->query_meta['total'] - $this->query_meta['offset'];

        return $remaining;
    }

    /**
     * Get access token
     */
    public function get_access_token() {

        $client_id = trim(lae_get_option('lae_vimeo_client_id', ''));
        $client_secret = trim(lae_get_option('lae_vimeo_client_secret', ''));

        if (empty($client_id) || empty($client_secret)) {
            $error_msg = __('You did not authorize the plugin to', 'livemesh-el-addons');
            $error_msg .= ' <a style="text-decoration: underline" href="' . admin_url('admin.php?page=livemesh_el_addons') . '">';
            $error_msg .= __('connect to Vimeo.', 'livemesh-el-addons');
            $error_msg .= '</a>';

            $error_object = new \WP_Error('missing_credentials', $error_msg);

            $this->bail(__('Cannot retrieve videos', 'livemesh-el-addons'), $error_object);
        }

        $oauth = 'https://api.vimeo.com/oauth/authorize/client?grant_type=client_credentials&scope=public+private';
        $args = array(
            'headers' => array(
                'Authorization' => 'Basic ' . base64_encode($client_id . ':' . $client_secret),
                'Content-Type' => 'application/json'
            ),
            'timeout' => 30
        );

        $transient_name = 'lae_grid_vimeo_' . md5($client_id . $client_secret);

        if (($transient = get_transient($transient_name)) !== false) {
            $this->access_token = $transient;
        }
        else {

            $response = wp_remote_post($oauth, $args);

            if (is_wp_error($response)) {

                $error_msg = __('An error occurred when invoking Vimeo API:', 'livemesh-el-addons');

                foreach($response->errors as $key => $value) {
                    $error_msg .= '<br/>' . $key . ':' . $value[0];
                }

                $error_object = new \WP_Error('vimeo_access_error', $error_msg);

                $this->bail(__('Cannot invoke Vimeo API', 'livemesh-el-addons'), $error_object);

            }
            else {

                $body = json_decode($response['body']);

                if (isset($body->access_token)) {

                    $this->access_token = $body->access_token;
                    set_transient($transient_name, $this->access_token, 90 * DAY_IN_SECONDS);

                }
                else {

                    $error_msg = sprintf(__('Your Vimeo Client ID and Client Secret are not valid or have expired. Please try to <a href="%s" target="_blank" style="text-decoration: underline">create a new app on Vimeo.</a>', 'livemesh-el-addons'), 'https://developer.vimeo.com/apps/');

                    $error_msg .= '<br/>' . $body->error;

                    $error_object = new \WP_Error('authorization_failed', $error_msg);

                    $this->bail(__('Vimeo Authorization Failed', 'livemesh-el-addons'), $error_object);

                }
            }
        }

    }

    /**
     * Get personal access token
     */
    public function get_personal_access_token() {

        $personal_access_token = trim(lae_get_option('lae_vimeo_personal_access_token', ''));

        if (empty($personal_access_token)) {
            $error_msg = __('You did not authorize the plugin to', 'livemesh-el-addons');
            $error_msg .= ' <a style="text-decoration: underline" href="' . admin_url('admin.php?page=livemesh_el_addons') . '">';
            $error_msg .= __('connect to Vimeo.', 'livemesh-el-addons');
            $error_msg .= '</a>';

            $error_object = new \WP_Error('missing_credentials', $error_msg);

            $this->bail(__('Cannot retrieve videos', 'livemesh-el-addons'), $error_object);
        }

        $this->access_token = $personal_access_token;

    }

    /**
     * Get Vimeo transient expiration
     *
     */
    public function set_transient_expiration() {

        $this->transient_sec = apply_filters('lae_vimeo_cache_expiration', 3600);

    }

    /**
     * Get Vimeo user data
     */
    public function get_user_info($user_id) {

        $url = 'https://api.vimeo.com/users/' . $user_id;

        $response = $this->get_response($url);

        if (isset($response) && !empty($response)) {
            return $response;
        }
        else {
            return '';
        }
    }

    /**
     * Return array of data
     *
     */
    public function get_grid_items() {

        $this->order = $this->settings['vimeo_order'];
        $this->sort = $this->settings['vimeo_sort'];
        $this->source_type = $this->settings['vimeo_source'];

        // get right source content from Vimeo
        switch ($this->source_type) {
            case 'users':
                $this->source_id = $this->settings['vimeo_user'];
                break;
            case 'albums':
                $this->source_id = $this->settings['vimeo_album'];
                break;
            case 'groups':
                $this->source_id = $this->settings['vimeo_group'];
                break;
            case 'channels':
                $this->source_id = $this->settings['vimeo_channel'];
                break;
        }

        // Try retrieving min of 10 videos and max of 50 videos at a time
        $this->items_per_page = $this->settings['items_per_page'];
        $this->items_per_page = ($this->items_per_page > 50 || empty($this->items_per_page)) ? 50 : $this->items_per_page;

        // This condition does not arise from the UI since we check this condition beforehand to disable load more button
        if (isset($this->query_meta['total']) && $this->query_meta['offset'] >= $this->query_meta['total']) {
            return '';
        }

        // retrieve Vimeo data
        $this->get_videos();

        return $this->items;

    }

    /**
     * Retrieve Vimeo data
     *
     */
    public function get_videos() {

        if (!empty($this->source_id)) {

            $response = $this->query($this->source_type, $this->source_id, '', $this->query_meta['page']);

            $this->items = $this->build_grid_items($response);

            // store the page and offset for next call to the API client
            $this->query_meta['page'] = isset($response->page) ? $response->page + 1 : $this->query_meta['page'];
            $this->query_meta['offset'] = $this->query_meta['offset'] + $this->items_per_page;

            $this->query_meta['total'] = (isset($response->total)) ? $response->total : -1;

        }
        else {
            $error_msg = __('User/Group/Album/Channel Id not specified', 'livemesh-el-addons');

            $error_object = new \WP_Error('invalid_source_id', $error_msg);

            $this->bail(__('Cannot retrieve videos', 'livemesh-el-addons'), $error_object);
        }

    }

    /**
     * Vimeo API call
     *
     */
    public function query($type, $id, $fields = '', $page = null) {

        // set and retrieve response
        $page = (!empty($page)) ? '&page=' . $page : '';
        $sort = (!empty($this->sort)) ? '&sort=' . $this->sort : '';
        $order = (!empty($this->order)) ? '&direction=' . $this->order : '';
        $fields = (!empty($fields)) ? '&fields=' . $fields : '';
        $url = 'https://api.vimeo.com/' . $type . '/' . $id . '/videos?per_page=' . $this->items_per_page . $page . $fields . $sort . $order;
        $response = $this->get_response($url);

        if (isset($response) && !empty($response)) {
            return $response;
        }
    }


    /**
     * Get url response (transient)
     */
    public function get_response($url) {

        global $lae_is_ajax;

        $transient_name = 'lae_grid_' . md5($url);

        if ($this->transient_sec > 0 && ($transient = get_transient($transient_name)) !== false) {
            $response = $transient;
        }
        else {

            $response = wp_remote_get($url, array(
                'headers' => array(
                    'Authorization' => 'Bearer ' . $this->access_token,
                    'Content-Type' => 'application/json'
                ),
                'timeout' => 30
            ));

            if (is_wp_error($response)) {

                $error_msg = __('An error occurred when invoking Vimeo API:', 'livemesh-el-addons');

                foreach($response->errors as $key => $value) {
                    $error_msg .= '<br/>' . $key . ':' . $value[0];
                }

                $error_object = new \WP_Error('vimeo_access_error', $error_msg);

                $this->bail(__('Cannot invoke Vimeo API', 'livemesh-el-addons'), $error_object);

            }
            else {

                $response = json_decode($response['body']);

                if (isset($response->error)) {

                    $error_msg = __('Vimeo API returned an error:', 'livemesh-el-addons');

                    $error_msg .= '<br/>' . $response->error;

                    $error_object = new \WP_Error('vimeo_api_error', $error_msg);

                    $this->bail(__('Vimeo API Error', 'livemesh-el-addons'), $error_object);

                }

                if (!empty($response)) {

                    set_transient($transient_name, $response, $this->transient_sec);

                }
                else if (!$lae_is_ajax) {

                    $error_msg = __('No data were found for the current User/Album/Group/Channel', 'livemesh-el-addons');

                    $error_object = new \WP_Error('videos_not_found', $error_msg);

                    $this->bail(__('Cannot retrieve videos', 'livemesh-el-addons'), $error_object);

                }

            }

        }

        return $response;

    }

    /**
     * Convert Vimeo duration format
     *
     */
    public function convert_time($duration) {

        if ($duration / 3600 >= 1) {
            return gmdate('H:i:s', $duration);
        }
        else {
            return gmdate('i:s', $duration);
        }
    }

    /**
     * Get images
     */
    public function get_images($data) {

        for ($i = 3; $i >= 0; $i--) {

            if (isset($data->pictures->sizes[$i]->link)) {
                $picture = $data->pictures->sizes[$i];
            }
            else {
                continue;
            }

            return array(
                'alt' => null,
                'url' => isset($picture->link) ? $picture->link : null,
                'width' => isset($picture->width) ? $picture->width : null,
                'height' => isset($picture->height) ? $picture->height : null
            );

        }

    }

    /**
     * Get categories
     */
    public function get_categories($data) {

        $categories = array();

        foreach ($data->categories as $elem) {

            $category = array(
                'name' => isset($elem->name) ? $elem->name : null,
                'link' => isset($elem->link) ? $elem->link : null,
            );

            $categories[] = $category;
        }

        return $categories;

    }

    /**
     * Build data array for the grid
     *
     */
    public function build_grid_items($response) {

        $videos = array();

        if (isset($response->data)) {

            foreach ($response->data as $data) {

                $video_id = str_replace('/videos/', '', $data->uri);

                $videos[] = array(
                    'ID' => $video_id,
                    'item_type' => 'vimeo',
                    'date' => (isset($data->created_time)) ? strtotime($data->created_time) : null,
                    'post_type' => null,
                    'format' => 'video',
                    'video_link' => 'https://vimeo.com/' . $video_id,
                    'url_target' => '_blank',
                    'item_name' => (isset($data->name)) ? $data->name : null,
                    'item_description' => (isset($data->description)) ? $data->description : null,
                    'terms' => null,
                    'author' => array(
                        'ID' => '',
                        'name' => (isset($data->user->name)) ? $data->user->name : null,
                        'url' => (isset($data->user->link)) ? $data->user->link : null,
                        'avatar' => (isset($data->user->pictures->sizes[1]->link)) ? $data->user->pictures->sizes[1]->link : null,
                    ),
                    'likes_number' => (isset($data->metadata->connections->likes->total)) ? $data->metadata->connections->likes->total : null,
                    'likes_title' => __('Like on Vimeo', 'livemesh-el-addons'),
                    'comments_number' => (isset($data->metadata->connections->comments->total)) ? $data->metadata->connections->comments->total : null,
                    'views_number' => (isset($data->stats->plays)) ? $data->stats->plays : null,
                    'image' => $this->get_images($data),
                    'gallery' => null,
                    'video' => array(
                        'type' => 'vimeo',
                        'duration' => (isset($data->duration)) ? $this->convert_time($data->duration) : null,
                        'source' => array(
                            'ID' => $video_id
                        ),
                    ),
                    'audio' => null,
                    'quote' => null,
                    'link' => null,
                    'meta_data' => $this->get_categories($data),
                );

            }

        }

        return $videos;

    }

}