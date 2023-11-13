<?php

/* https://developers.google.com/apis-explorer/ */

namespace LivemeshAddons\Blocks\Clients;

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

class LAE_YouTube_Client extends LAE_Social_Client {

    /**
     * YouTube API Key
     *
     */
    private $api_key;

    /**
     * YouTube API query results
     *
     */
    private $results = array();

    /**
     * YouTube query meta
     *
     */
    private $query_meta = array();

    /**
     * YouTube parameters
     *
     */
    private $order;
    private $source_type;
    private $playlist_id;
    private $channel_id;
    private $channels;
    private $video_ids = array();

    /**
     * Initialize the class and set its properties.
     *
     */
    public function __construct($settings = '', $query_meta = array()) {

        $this->set_transient_expiration();
        $this->get_API_key();

        $this->settings = $settings;

        // get last media from ajax
        $this->query_meta = $query_meta;
        $this->query_meta['page_token'] = (isset($this->query_meta['page_token'])) ? $this->query_meta['page_token'] : '';
        $this->query_meta['offset'] = (isset($this->query_meta['offset'])) ? (int)$this->query_meta['offset'] : 0;

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
     * Get YouTube API Key
     *
     */
    public function get_API_key() {

        $this->api_key = trim(lae_get_option('lae_youtube_api_key', ''));

        if (empty($this->api_key)) {
            $error_msg = __('You did not authorize the plugin to', 'livemesh-el-addons');
            $error_msg .= ' <a style="text-decoration: underline" href="' . admin_url('admin.php?page=livemesh_el_addons') . '">';
            $error_msg .= __('connect to YouTube.', 'livemesh-el-addons');
            $error_msg .= '</a>';

            $error_object = new \WP_Error('missing_credentials', $error_msg);

            $this->bail(__('Cannot retrieve videos', 'livemesh-el-addons'), $error_object);
        }

    }

    /**
     * Get YouTube transient expiration
     *
     */
    public function set_transient_expiration() {

        $this->transient_sec = apply_filters('lae_youtube_cache_expiration', 3600);

    }

    /**
     * Get YouTube Channel Info
     *
     */
    public function get_channel_info() {

        $this->channel_id = $this->settings['youtube_channel'];

        $response = $this->query('channels', 'id', $this->channel_id, 'id,contentDetails,snippet,brandingSettings,statistics');

        return $response;
    }

    /**
     * Return array of data
     *
     */
    public function get_grid_items() {

        // store YouTube data
        $this->order = $this->settings['youtube_order'];
        $this->source_type = $this->settings['youtube_source'];
        $this->channel_id = $this->settings['youtube_channel'];
        $this->playlist_id = $this->settings['youtube_playlist'];
        $this->video_ids = preg_replace('/\s+/', '', $this->settings['youtube_videos']);
        // Try retrieving min of 10 videos and max of 50 videos at a time
        $this->items_per_page = $this->settings['items_per_page'];
        $this->items_per_page = ($this->items_per_page > 50 || empty($this->items_per_page)) ? 50 : $this->items_per_page;

        // This condition does not arise from the UI since we check this condition beforehand to disable load more button
        if (isset($this->query_meta['total']) && $this->query_meta['offset'] >= $this->query_meta['total']) {
            return '';
        }

        // retrieve YouTube data
        $this->get_videos();

        return $this->items;

    }

    /**
     * Retrieve media data
     *
     */
    public function get_videos() {

        switch ($this->source_type) {
            case 'channel':
                $this->get_channel();
                $this->get_video_ids();
                break;
            case 'playlist':
                $this->get_playlist();
                $this->get_video_ids();
                break;
            case 'videos':
                $videos_array = explode(',', $this->video_ids);
                $this->query_meta['total'] = count($videos_array);
                $videos_array = array_slice($videos_array, $this->query_meta['offset'], $this->items_per_page);
                $this->video_ids = implode(',', $videos_array);
                break;
        }

        if (!empty($this->video_ids)) {

            $response = $this->query('videos', 'id', $this->video_ids, 'snippet,contentDetails,statistics,status');
            $this->get_channels($response);
            $this->items = $this->build_grid_items($response);

        }

        // store the offset for next call to the API client
        $this->query_meta['offset'] = $this->query_meta['offset'] + $this->items_per_page;

    }

    /**
     * Retrieve media data
     *
     */
    public function get_video_ids() {

        $this->video_ids = array();

        if (isset($this->results->items)) {

            // loop through each video details
            foreach ($this->results->items as $item) {

                // get video id (depends if playlist or not)
                if (isset($item->id->videoId)) {
                    array_push($this->video_ids, $item->id->videoId);
                }
                else if (isset($item->snippet->resourceId->videoId)) {
                    array_push($this->video_ids, $item->snippet->resourceId->videoId);
                }

            }

            // prepare video id for videos youtube call
            $this->video_ids = implode(',', $this->video_ids);

        }

    }

    /**
     * Retrieve channel information
     *
     */
    public function get_channels($videos) {

        $this->channels = array();

        $channel_ids = $this->get_channel_ids($videos);

        $response = $this->query('channels', 'id', $channel_ids, 'snippet', 'items(id,snippet(thumbnails/default,title))');

        if (isset($response->items)) {

            // loop through each video details
            foreach ($response->items as $channel) {

                if (isset($channel->snippet->thumbnails->default)) {

                    if (!in_array($channel->id, $this->channels)) {
                        $this->channels[$channel->id] = array(
                            'id' => $channel->id,
                            'title' => $channel->snippet->title,
                            'avatar' => $channel->snippet->thumbnails->default->url);
                    }
                }
            }

        }

    }

    /**
     * Retrieve channel ids
     *
     */
    public function get_channel_ids($videos) {

        $channel_ids = array();

        if (isset($videos->items)) {

            // loop through each video details
            foreach ($videos->items as $item) {

                if (isset($item->snippet->channelId)) {
                    $channel_id = $item->snippet->channelId;

                    if (!in_array($channel_id, $channel_ids)) {
                        array_push($channel_ids, $channel_id);
                    }
                }
            }

            // prepare video id for channels youtube call
            $channel_ids = implode(',', $channel_ids);

        }

        return $channel_ids;

    }

    /**
     * Get YouTube Channel Items
     *
     */
    public function get_channel() {

        if (!empty($this->channel_id)) {
            $call = $this->query('search', 'channelId', $this->channel_id, 'snippet&type=video', 'items/id/videoId', true);

            $this->query_meta['page_token'] = (isset($call->nextPageToken)) ? $call->nextPageToken : '';
            $this->query_meta['total'] = (isset($call->pageInfo->totalResults)) ? $call->pageInfo->totalResults : '';
        }
        else {

            $error_msg = __('Channel Id not specified', 'livemesh-el-addons');

            $error_object = new \WP_Error('invalid_channel_id', $error_msg);

            $this->bail(__('Cannot retrieve videos', 'livemesh-el-addons'), $error_object);
        }

    }

    /**
     * Get YouTube Playlist Items
     *
     */
    public function get_playlist() {

        if (!empty($this->playlist_id)) {

            $call = $this->query('playlistItems', 'playlistId', $this->playlist_id, 'snippet,contentDetails', 'items/snippet/resourceId/videoId', true);
            $this->query_meta['page_token'] = (isset($call->nextPageToken)) ? $call->nextPageToken : '';
            $this->query_meta['total'] = (isset($call->pageInfo->totalResults)) ? $call->pageInfo->totalResults : '';
        }
        else {

            $error_msg = __('Playlist Id not specified', 'livemesh-el-addons');

            $error_object = new \WP_Error('invalid_playlist_id', $error_msg);

            $this->bail(__('Cannot retrieve videos', 'livemesh-el-addons'), $error_object);
        }

    }

    /**
     * YouTube API call
     *
     */
    public function query($type, $id_type, $id, $part, $fields = '', $page = null) {

        // set and retrieve response
        $page = $page ? '&pageToken=' . $this->query_meta['page_token'] : '';
        $order = ($type == 'search') ? '&order=' . $this->order : '';
        $fields = (!empty($fields)) ? '&fields=nextPageToken,pageInfo,' . $fields : '';
        $url = 'https://www.googleapis.com/youtube/v3/' . $type . '?' . $id_type . '=' . $id . '&part=' . $part . $fields . '&maxResults=' . $this->items_per_page . '&key=' . $this->api_key . $page . $order;

        $response = $this->get_response($url);

        if (isset($response) && !empty($response)) {
            $this->results = $response;
            return $response;
        }

    }

    /**
     * Get url response (transient)
     *
     */
    public function get_response($url) {

        global $lae_is_ajax;

        $transient_name = 'lae_grid_' . md5($url);

        if ($this->transient_sec > 0 && ($transient = get_transient($transient_name)) !== false) {

            $response = $transient;

        }
        else {

            $response = json_decode(wp_remote_fopen($url));

            if (isset($response->error->errors[0]->reason)) {

                $error_msg = __('An error occurred when invoking YouTube API:', 'livemesh-el-addons');
                $error_msg .= ' ' . $response->error->errors[0]->reason;

                $error_object = new \WP_Error('youtube_api_error', $error_msg);

                $this->bail(__('YouTube API Error', 'livemesh-el-addons'), $error_object);

            }

            if (isset($response->items) && !empty($response->items)) {
                set_transient($transient_name, $response, $this->transient_sec);
            }
            else if (!$lae_is_ajax) {


                $error_msg = __('No data were found for the current Channel/Playlist/Videos', 'livemesh-el-addons');

                $error_object = new \WP_Error('videos_not_found', $error_msg);

                $this->bail(__('Cannot retrieve videos', 'livemesh-el-addons'), $error_object);
            }

        }

        return $response;

    }

    /**
     * Convert YouTube duration format
     *
     */
    public function convert_time($duration) {

        $duration = new \DateInterval($duration);
        return (intval($duration->format('%h')) != 0) ? $duration->format('%H:%I:%S') : $duration->format('%I:%S');

    }

    /**
     * Build data array for the grid
     *
     */
    public function build_grid_items($response) {

        $videos = array();

        if (isset($response->items)) {

            foreach ($response->items as $data) {

                $videos[] = array(
                    'ID' => $data->id,
                    'item_type' => 'youtube',
                    'date' => (isset($data->snippet->publishedAt)) ? strtotime($data->snippet->publishedAt) : null,
                    'post_type' => null,
                    'format' => 'video',
                    'video_link' => 'https://www.youtube.com/watch?v=' . $data->id,
                    'url_target' => '_blank',
                    'item_name' => (isset($data->snippet->title)) ? $data->snippet->title : null,
                    'item_description' => (isset($data->snippet->description)) ? $data->snippet->description : null,
                    'terms' => null,
                    'author' => array(
                        'ID' => '',
                        'name' => (isset($data->snippet->channelTitle)) ? $data->snippet->channelTitle : null,
                        'url' => (isset($data->snippet->channelId)) ? 'https://www.youtube.com/channel/' . $data->snippet->channelId : null,
                        'avatar' => (isset($data->snippet->channelId) && key_exists($data->snippet->channelId, $this->channels)) ? $this->channels[$data->snippet->channelId]['avatar'] : null,
                    ),
                    'likes_number' => (isset($data->statistics->likeCount)) ? $data->statistics->likeCount : null,
                    'likes_title' => __('Like on YouTube', 'livemesh-el-addons'),
                    'comments_number' => (isset($data->statistics->commentCount)) ? $data->statistics->commentCount : null,
                    'views_number' => (isset($data->statistics->viewCount)) ? $data->statistics->viewCount : null,
                    'image' => array(
                        'alt' => (isset($data->snippet->title)) ? $data->snippet->title : null,
                        'url' => (isset($data->snippet->thumbnails->high->url)) ? $data->snippet->thumbnails->high->url : null,
                        'width' => (isset($data->snippet->thumbnails->high->width)) ? $data->snippet->thumbnails->high->width : null,
                        'height' => (isset($data->snippet->thumbnails->high->height)) ? $data->snippet->thumbnails->high->height : null
                    ),
                    'gallery' => null,
                    'video' => array(
                        'type' => 'youtube',
                        'duration' => (isset($data->contentDetails->duration)) ? $this->convert_time($data->contentDetails->duration) : null,
                        'source' => array(
                            'ID' => $data->id
                        ),
                    ),
                    'audio' => null,
                    'quote' => null,
                    'link' => null,
                    'meta_data' => null
                );

            }

        }

        return $videos;

    }

}