<?php

namespace LivemeshAddons\Blocks\Clients;

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

class LAE_Instagram_Client extends LAE_Social_Client {

    private $hashtags;

    private $usernames;

    private $user_data = array();


    /**
     * Initialize the class and set its properties.
     *
     */
    public function __construct($settings = '') {

        $this->set_transient_expiration();

        $this->settings = $settings;

    }

    /**
     * Return array of grid settings
     */
    public function get_settings() {

        return $this->settings;

    }

    /**
     * Get Instagram transient expiration
     *
     */
    public function set_transient_expiration() {

        $this->transient_sec = apply_filters('lae_instagram_cache_expiration', 3600);

    }


    /**
     * Return array of data
     *
     */
    public function get_grid_items() {

        $this->usernames = preg_replace('/\s+/', '', $this->settings['instagram_usernames']);
        $this->usernames = array_filter(explode(',', $this->usernames));

        $this->hashtags = preg_replace('/\s+/', '', $this->settings['instagram_hashtags']);
        $this->hashtags = str_replace('#', '', $this->hashtags);
        $this->hashtags = array_filter(explode(',', $this->hashtags));
        $this->hashtags = array_map('trim', $this->hashtags);

        if (empty($this->usernames) && empty($this->hashtags)) {
            $error_msg = __('No Username(s)/Hashtag(s) specified', 'livemesh-el-addons');

            $error_object = new \WP_Error('data_not_found', $error_msg);

            $this->bail(__('Cannot retrieve data', 'livemesh-el-addons'), $error_object);
        }

        // Try retrieving min of 10 videos and max of 50 videos at a time
        $this->items_per_page = $this->settings['items_per_page'];
        $this->items_per_page = ($this->items_per_page > 12 || empty($this->items_per_page)) ? 12 : $this->items_per_page;

        // retrieve Instagram data
        $this->get_media();

        return $this->items;

    }

    /**
     * Retrieve user information
     */
    public function get_user_info() {

        $this->usernames = preg_replace('/\s+/', '', $this->settings['instagram_usernames']);

        $this->usernames = array_filter(explode(',', $this->usernames));

        foreach ($this->usernames as $username) {

            $request = 'https://www.instagram.com/' . $username . '/?__a=1';
            $response = $this->get_response($request);

            if (!empty($response->graphql)) {
                return $response->graphql->user; /* Return the first user found */
            }

        }

        return null;
    }

    /**
     * Get user from publicly visible username
     */
    public function get_user_by_name($user_name) {

        $request = 'https://www.instagram.com/web/search/topsearch/?context=blended&query=' . $user_name . '&count=1';
        $response = $this->get_response($request);

        if (empty($response->users)) {
            return false;
        }

        $users = $response->users;

        $user = reset($users);

        if (!empty($user->user)) {

            $user = $user->user;

            $this->user_data[$user->pk] = $user; /* Store the user data to avoid repeat retrieval */

            return $user;
        }

        return false;

    }

    /**
     * Get user from numeric user id
     */
    public function get_user_by_id($user_id) {

        if (isset($this->user_data[$user_id])) {
            return $this->user_data[$user_id];
        }

        $request = 'https://i.instagram.com/api/v1/users/' . $user_id . '/info/';
        $response = $this->get_response($request);

        if (!empty($response->user)) {

            $user = $response->user;

            $this->user_data[$user_id] = $user;

            return $response->user;
        }

        return false;

    }

    /**
     * Retrieve user media
     */
    public function get_user_media() {

        foreach ($this->usernames as $username) {

            if (is_numeric($username)) {
                $user_id = $username;
            }
            else {
                $user = $this->get_user_by_name($username);
                if ($user)
                    $user_id = $user->pk;
                else
                    continue;
            }

            $request = 'https://www.instagram.com/graphql/query/?id=' . $user_id . '&first=' . $this->items_per_page . '&query_hash=f2405b236d85e8296cf30347c9f08c2a';
            $response = $this->get_response($request);

            if (empty($response->data->user->edge_owner_to_timeline_media->edges)) {

                $error_msg = __('No data was found for the User specified.', 'livemesh-el-addons');

                $error_object = new \WP_Error('data_not_found', $error_msg);

                $this->bail(__('Cannot retrieve data', 'livemesh-el-addons'), $error_object);
            }

            $posts = $response->data->user->edge_owner_to_timeline_media->edges;

            $this->build_grid_items($posts, $username, true);

        }
    }

    /**
     * Retrieve hashtag media
     */
    public function get_hashtag_media() {

        foreach ($this->hashtags as $hashtag) {

            $request = 'https://www.instagram.com/graphql/query/?tag_name=' . $hashtag . '&first=' . $this->items_per_page . '&query_hash=f92f56d47dc7a55b606908374b43a314';
            $response = $this->get_response($request);

            if (empty($response->data->hashtag->edge_hashtag_to_media->edges)) {

                $error_msg = __('No data was found for the Hashtag specified', 'livemesh-el-addons');

                $error_object = new \WP_Error('data_not_found', $error_msg);

                $this->bail(__('Cannot retrieve data', 'livemesh-el-addons'), $error_object);
            }

            $posts = $response->data->hashtag->edge_hashtag_to_media->edges;

            $this->build_grid_items($posts, $hashtag);

        }
    }

    /**
     * Retrieve Instagram data
     *
     */
    public function get_media() {

        // retrieve Instagram data
        $this->get_hashtag_media();
        $this->get_user_media();

        // sort all data by date
        usort($this->items, function ($a, $b) {
            return str_replace('@', '', $b['date']) - str_replace('@', '', $a['date']);
        });

        // return only the number of element set in grid settings
        $this->items = array_slice($this->items, 0, $this->items_per_page);

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

            /* https://stackoverflow.com/questions/38356283/instagram-given-a-user-id-how-do-i-find-the-username */
            $response = wp_remote_get($url, array(
                'timeout' => 30,
                'user-agent' => 'Mozilla/5.0 (iPhone; CPU iPhone OS 10_3_3 like Mac OS X) AppleWebKit/603.3.8 (KHTML, like Gecko) Mobile/14G60 Instagram 12.0.0.16.90 (iPhone9,4; iOS 10_3_3; en_US; en-US; scale=2.61; gamut=wide; 1080x1920)'
            ));

            if (is_wp_error($response)) {

                $error_msg = __('An error occurred when invoking Instagram API:', 'livemesh-el-addons');

                foreach ($response->errors as $key => $value) {
                    $error_msg .= '<br/>' . $key . ':' . $value[0];
                }

                $error_object = new \WP_Error('instagram_access_error', $error_msg);

                $this->bail(__('Cannot invoke Instagram API', 'livemesh-el-addons'), $error_object);

            }
            else {

                $response = json_decode($response['body']);

                if (isset($response->error)) {

                    $error_msg = __('Instagram API returned an error:', 'livemesh-el-addons');

                    $error_msg .= '<br/>' . $response->error;

                    $error_object = new \WP_Error('instagram_api_error', $error_msg);

                    $this->bail(__('Instagram API Error', 'livemesh-el-addons'), $error_object);

                }

                if (!empty($response)) {

                    set_transient($transient_name, $response, $this->transient_sec);

                }
                else if (!$lae_is_ajax) {

                    $error_msg = __('No data was found for the current User/Hashtag', 'livemesh-el-addons');

                    $error_object = new \WP_Error('data_not_found', $error_msg);

                    $this->bail(__('Cannot retrieve data', 'livemesh-el-addons'), $error_object);

                }

            }

        }

        return $response;

    }

    /**
     * Get video
     */
    public function get_video($node) {

        if (!$node->is_video) {
            return;
        }

        $url = 'https://www.instagram.com/p/' . $node->shortcode . '/?__a=1';
        $response = $this->get_response($url);

        if (!isset($response->graphql->shortcode_media->video_url)) {
            return;
        }

        return array(
            'mp4' => $response->graphql->shortcode_media->video_url,
        );

    }

    /**
     * Build data array for the grid
     *
     */
    public function build_grid_items($response, $type, $user = false) {

        foreach ($response as $node) {

            $node = $node->node;

            $user = $this->get_user_by_id($node->owner->id);

            $display_url = isset($node->display_url) ? $node->display_url : null;
            $display_url = !$display_url && isset($node->display_src) ? $node->display_src : $display_url;

            $thumbnail_src = isset($node->thumbnail_src) ? $node->thumbnail_src : null;
            $thumbnail_src = (!$thumbnail_src && isset($node->thumbnail_resources[4]->src)) ? $node->thumbnail_resources[4]->src : $thumbnail_src;

            $video_thumb_src = isset($node->thumbnail_resources[4]->src) ? $node->thumbnail_resources[4]->src : null;
            $video_thumb_src = (!$video_thumb_src && isset($node->thumbnail_src)) ? $node->thumbnail_src : $video_thumb_src;

            $video = $this->get_video($node);

            $this->items [$node->taken_at_timestamp] = array(
                'ID' => $node->id,
                'item_type' => $video ? 'video' : 'image',
                'type' => $type,
                'date' => $node->taken_at_timestamp,
                'post_type' => null,
                'format' => $video ? 'video' : null,
                'url' => 'https://www.instagram.com/p/' . $node->shortcode,
                'url_target' => '_blank',
                'item_name' => null,
                'item_description' => isset($node->edge_media_to_caption->edges[0]->node->text) ? $node->edge_media_to_caption->edges[0]->node->text : null,
                'terms' => null,
                'author' => array(
                    'ID' => isset($user->pk) ? $user->pk : null,
                    'username' => isset($user->username) ? $user->username : '',
                    'name' => isset($user->full_name) ? $user->full_name : '',
                    'url' => isset($user->username) ? 'https://www.instagram.com/' . $user->username . '/' : null,
                    'avatar' => isset($user->profile_pic_url) ? $user->profile_pic_url : null,
                ),
                'likes_number' => isset($node->edge_media_preview_like->count) ? $node->edge_media_preview_like->count : null,
                'likes_title' => __('Like on Instagram', 'livemesh-el-addons'),
                'comments_number' => isset($node->edge_media_to_comment->count) ? $node->edge_media_to_comment->count : null,
                'views_number' => $video ? $node->video_view_count : null,
                'image' => array(
                    'alt' => null,
                    'url' => $thumbnail_src,
                    'lb_url' => $display_url ? $display_url : $thumbnail_src,
                    'video_thumb_url' => $video_thumb_src ? $video_thumb_src : $thumbnail_src,
                    'width' => null,
                    'height' => null,
                ),
                'gallery' => null,
                'video' => $video,
                'audio' => null,
                'quote' => null,
                'link' => null,
                'meta_data' => null
            );

        }

    }

}