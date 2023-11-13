<?php

namespace LivemeshAddons\Blocks\Clients;

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

class LAE_Twitter_Client extends LAE_Social_Client {

    /**
     * Twitter Consumer Key
     */
    private $consumer_key;

    /**
     * Twitter Consumer Secret
     */
    private $consumer_secret;

    /**
     * Twitter Access Token
     */
    private $access_token;

    /**
     * Max ID for the current set of tweets
     */
    private $max_id = null;

    /**
     * Initialize the class and set its properties.
     */
    public function __construct($settings = '', $max_id = null) {

        $this->settings  = $settings;
        $this->max_id = $max_id;

        $this->get_api_key();
        $this->get_transient_expiration();
        $this->get_bearer_token();

    }

    /**
     * Return array of grid settings
     */
    public function get_settings(){

        return $this->settings;

    }
    /**
     * Return the max ID for load more requests
     */
    public function get_max_id(){

        return $this->max_id;

    }

    /**
     * Get Twitter APP Key
     */
    public function get_api_key(){

        $this->consumer_key    = trim(lae_get_option('lae_twitter_consumer_key', ''));
        $this->consumer_secret = trim(lae_get_option('lae_twitter_consumer_secret', ''));

        if (empty($this->consumer_key) || empty($this->consumer_secret)) {

            $error_msg  = __( 'You did not authorize the plugin to', 'livemesh-el-addons' );
            $error_msg .= ' <a style="text-decoration: underline" href="'.admin_url('admin.php?page=livemesh_el_addons').'">';
            $error_msg .= __( 'connect to Twitter.', 'livemesh-el-addons' );
            $error_msg .= '</a>';

            $error_object = new \WP_Error('missing_credentials', $error_msg);

            $this->bail( __('Cannot retrieve tweets', 'livemesh-el-addons'), $error_object);

        }

    }

    /**
     * Get Twitter transient expiration
     */
    public function get_transient_expiration(){

        $this->transient_sec = apply_filters('lae_twitter_cache_expiration', 3600);

    }

    /**
     * Return array of data
     */
    public function get_grid_items() {

        switch ($this->settings['twitter_source']) {
            case 'user_timeline':
                $this->get_response('statuses/user_timeline');
                break;
            case 'search':
                $this->get_response('search/tweets');
                break;
            case 'favorites':
                $this->get_response('favorites/list');
                break;
            case 'list_timeline':
                $this->get_response('lists/statuses');
                break;
            default:
                $error_object = new \WP_Error('invalid_twitter_source', __( 'No Twitter source specified in the options.', 'livemesh-el-addons' ));
                $this->bail( __('Cannot retrieve tweets', 'livemesh-el-addons'), $error_object);

        }

        return $this->items;

    }

    /**
     * Get the token from oauth Twitter API
     */
    public function get_bearer_token() {

        // retrieve access token & consumer data
        $twitter_app = get_option('lae_twitter_bearer_token');

        // if an access token is set return directly (also check if consumer key & secret didn't changed)
        if (isset($twitter_app['consumer_key'])    == $this->consumer_key    &&
            isset($twitter_app['consumer_secret']) == $this->consumer_secret &&
            isset($twitter_app['access_token']) && !empty($twitter_app['access_token'])) {
            $this->access_token = $twitter_app['access_token'];
            return;
        }

        // set header arguments for wp_remote_post
        $args = array(
            'method'      => 'POST',
            'timeout'     => 5,
            'redirection' => 5,
            'httpversion' => '1.0',
            'sslverify'   => false,
            'blocking'    => true,
            'headers'     => array(
                'Authorization' => 'Basic ' . base64_encode($this->consumer_key . ':' . $this->consumer_secret),
                'Content-Type'  => 'application/x-www-form-urlencoded;charset=UTF-8',
            ),
            'body' => array(
                'grant_type' => 'client_credentials'
            ),
            'decompress' => false // prevent gzinflate() error
        );

        // get twitter oauth
        $response = wp_remote_post('https://api.twitter.com/oauth2/token', $args);

        // if an error occurs    
        if (is_wp_error($response) || 200 != $response['response']['code']) {

            $error_msg  = __( 'Cannot obtain Twitter bearer token.', 'livemesh-el-addons' );
            $error_msg .= '<br>';
            $error_msg .= __( 'Please check the credentials in the ', 'livemesh-el-addons' );
            $error_msg .= ' <a style="text-decoration: underline" href="'.admin_url('admin.php?page=livemesh_el_addons').'">';
            $error_msg .= __( 'plugin settings.', 'livemesh-el-addons' );
            $error_msg .= '</a>';

            $this->bail($error_msg, $response);

        }

        // decode body response 
        $result = json_decode($response['body']);

        // if an access token exist then store it
        if (isset($result->access_token) && !empty($result->access_token)) {

            $this->access_token = $result->access_token;

            $twitter_app = array(
                'consumer_key'    => $this->consumer_key,
                'consumer_secret' => $this->consumer_secret,
                'access_token'    => $this->access_token
            );

            update_option('lae_twitter_bearer_token', $twitter_app);

        }

    }

    /**
     * Get url response
     */
    public function get_response($type) {

        global $lae_is_ajax;

        // if ajax request and no max_id then return directly
        if (!$this->max_id && $lae_is_ajax) {
            return;
        }

        $this->get_tweets($type);

        // if there are items and a max_id (if there is no max_id, there are no more tweets to retrieve)
        if (sizeof($this->items) > 0 && $this->max_id) {

            // while the number of item is not reached then query Twitter
            while (sizeof($this->items) < $this->settings['items_per_page'] && $this->max_id) {
                $this->get_tweets($type);
            }

            // if not ajax request and no tweets
        } else if (sizeof($this->items) == 0 && !$lae_is_ajax) {

            $error_msg  = __( 'No tweets were found on Twitter', 'livemesh-el-addons' );

            $error_object = new \WP_Error('tweets_not_found', $error_msg);

            $this->bail( __('Cannot retrieve tweets', 'livemesh-el-addons'), $error_object);

        }

        // if there are items in the result
        if (sizeof($this->items) > 0) {

            // reduce array if number of tweets bigger than the item number requested
            $this->items = sizeof($this->items) > $this->settings['items_per_page'] ? array_slice($this->items, 0, $this->settings['items_per_page']) : $this->items;
            $this->items = array_map('unserialize', array_unique(array_map('serialize', $this->items)));

        }

        // set max_id once the array was reduced and if there are still items to be retrieved. Set null if num of items is less than items per page
        $this->max_id = (sizeof($this->items) < $this->settings['items_per_page']) ? null : $this->items[sizeof($this->items) - 1]['ID'];

    }

    /**
     * Get tweets from Twitter
     */
    public function get_tweets($type) {

        // Query twitter API
        $tweets = $this->query($type);
        // Build item array
        $tweets = (array) $this->build_grid_items($tweets);
        // Store max_id for next query
        $this->max_id = sizeof($tweets) > 0 ? $tweets[sizeof($tweets)-1]['ID'] : null;

    }

    /**
     * Set query args for Twitter query
     */
    public function query_args() {

        $twitter_username  = $this->settings['twitter_source'] != 'list_timeline' ? '&screen_name='. $this->settings['twitter_username'] : '&owner_screen_name='. $this->settings['twitter_username'];
        $twitter_listname  = ($this->settings['twitter_listname'] && $this->settings['twitter_source'] == 'list_timeline') ? 'slug='. $this->settings['twitter_listname'].'&' : null;
        $twitter_searchkey = ($this->settings['twitter_source'] == 'search') ? 'q='.urlencode($this->settings['twitter_searchkey']).'&' : null;
        $include_retweets  = (isset($this->settings['twitter_include']) && in_array('retweets', (array)$this->settings['twitter_include'])) ? 'true' : 'false';
        $exclude_replies   = (isset($this->settings['twitter_include']) && in_array('replies', (array)$this->settings['twitter_include']))  ? 'false' : 'true';
        $twitter_max_id    = $this->max_id ? 'max_id='.$this->max_id.'&' : null;

        return $twitter_max_id.
            $twitter_username.'&'.
            $twitter_listname.
            $twitter_searchkey.
            'count='.($this->settings['items_per_page']+20).
            '&include_entities=true'.
            '&include_rts='.$include_retweets.
            '&exclude_replies='.$exclude_replies.
            '&tweet_mode=extended'.
            '&result_type=mixed';

    }

    /**
     * Query Twitter API
     */
    public function query($type) {

        $query_args = $this->query_args();

        $transient_name = 'lae_grid_' . md5($type.$query_args);

        if (false !== ($tweets = get_transient($transient_name))) {
            return json_decode($tweets);
        }

        $args = array(
            'method'      => 'GET',
            'timeout'     => 5,
            'redirection' => 5,
            'httpversion' => '1.0',
            'blocking'    => true,
            'headers'     => array(
                'Authorization'   => 'Bearer ' . $this->access_token,
            ),
            'body'       => null,
            'cookies'    => array(),
            'decompress' => false // prevent gzinflate() error
        );

        $response = wp_remote_get('https://api.twitter.com/1.1/' . $type . '.json?' . $query_args, $args);

        if (is_wp_error($response) || 200 != $response['response']['code']) {

            $error_msg  = __( 'An error occurred from Twitter.', 'livemesh-el-addons' );
            $error_msg .= '<br>';
            $error_msg .= __( 'Please check the grid options specified and reload the page.', 'livemesh-el-addons' );

            $this->bail($error_msg, $response);

        }

        $tweets = $response['body'];

        set_transient($transient_name, $tweets, $this->transient_sec);

        return json_decode($tweets);

    }

    /**
     * Convert tweet text with pretty url
     */
    public function tweet_text($tweet) {

        $reply    = isset( $tweet->in_reply_to_status_id ) && ! empty( $tweet->in_reply_to_status_id );
        $data     = isset( $tweet->retweeted_status ) ? $tweet->retweeted_status : $tweet;
        $text     = isset( $data->display_text_range ) && ! $reply ? mb_substr( $data->full_text, $data->display_text_range[0], $data->display_text_range[1] - $data->display_text_range[0], 'UTF-8' ) : $data->full_text;
        $entities = array();

        if (isset($data->entities->urls) && is_array($data->entities->urls)) {
            foreach($data->entities->urls as $e) {
                array_push($entities, array(
                    'start' => $e->indices[0],
                    'end'   => $e->indices[1],
                    'repl'  => '<a href="'.$e->expanded_url.'" target="_blank" class="lae-social-link">'.$e->display_url.'</a>'
                ));
            }
        }

        if (isset($data->entities->user_mentions) && is_array($data->entities->user_mentions)) {
            foreach($data->entities->user_mentions as $e) {
                array_push($entities, array(
                    'start' => $e->indices[0],
                    'end'   => $e->indices[1],
                    'repl'  => '<a href="https://twitter.com/'.$e->screen_name.'" target="_blank" class="lae-social-link">@'.$e->screen_name.'</a>'
                ));
            }
        }

        if (isset($data->entities->hashtags) && is_array($data->entities->hashtags)) {
            foreach($data->entities->hashtags as $e) {
                array_push($entities, array(
                    'start' => $e->indices[0],
                    'end'   => $e->indices[1],
                    'repl'  => '<a href="https://twitter.com/hashtag/'.$e->text.'?src=hash" target="_blank" class="lae-social-link">#'.$e->text.'</a>'
                ));
            }
        }

        if (isset($data->entities->media) && is_array($data->entities->media)) {
            foreach($data->entities->media as $e) {
                array_push($entities, array(
                    'start' => $e->indices[0],
                    'end'   => $e->indices[1],
                    'repl'  => null
                ));
            }
        }

        usort($entities, function($a,$b){
            return($b['start'] - $a['start']);
        });

        foreach ($entities as $item) {
            $startString = mb_substr($text, 0, $item['start'], 'UTF-8');
            $endString   = mb_substr($text, $item['end'], mb_strlen($text), 'UTF-8');
            $text = $startString . $item['repl'] . $endString;
        }

        if ( isset( $tweet->retweeted_status ) ) {

            foreach( $tweet->entities->user_mentions as $e ) {

                if ( $e->indices[0] === 3 && $e->indices[1] === 14 ) {
                    $replace     = '<a href="https://twitter.com/'.$e->screen_name.'" target="_blank" class="lae-social-link">@'.$e->screen_name.'</a>';
                    $text        = 'RT ' . $replace . ': ' . $text;
                } else {
                    break;
                }

            }

        }

        return $text;

    }

    /**
     * Build grid items
     */
    public function build_grid_items($response) {

        $tweets = array();

        if (isset($response) && !empty($response)) {

            $response = isset($response->statuses) ? $response->statuses : $response;

            foreach ((array) $response as $data) {

                if (isset($data->id_str) && $data->id_str != $this->max_id) {

                    $image = null;

                    if(isset($data->entities->media[0])) {

                        $image = array(
                            'alt'    => null,
                            'url'    => $data->entities->media[0]->media_url_https,
                            'width'  => $data->entities->media[0]->sizes->large->w,
                            'height' => $data->entities->media[0]->sizes->large->h
                        );

                    }

                    $this->items[] = $tweets[] = array(
                        'ID'              => $data->id_str,
                        'post_date'            => isset($data->created_at) ? strtotime($data->created_at) : null,
                        'post_url'        => isset($data->user->screen_name) ? 'https://twitter.com/'.$data->user->screen_name.'/status/'.$data->id_str : null,
                        'url_target'      => '_blank',
                        'text'            => isset($data->full_text) ? $this->tweet_text($data) : null,
                        'author'          => array(
                            'ID'     => isset($data->id_str) ? $data->id_str : null,
                            'name'   => isset($data->user->name) ? $data->user->name : null,
                            'screen_name'   => isset($data->user->screen_name) ? $data->user->screen_name : null,
                            'url'    => isset($data->user->screen_name) ? 'https://twitter.com/'.$data->user->screen_name : null,
                            'avatar' => isset($data->user->profile_image_url_https) ? str_replace('.jpg', '_200x200.jpg', str_replace('_normal', '', (string)$data->user->profile_image_url_https)) : null
                        ),
                        'likes_number'    => (isset($data->favorite_count)) ? $data->favorite_count : null,
                        'likes_title'     => null,
                        'comments_number' => (isset($data->reply_count)) ? $data->reply_count : null,
                        'retweet_count'   => (isset($data->retweet_count)) ? $data->retweet_count : null,
                        'image'           => $image,
                        'video'           => null,
                        'audio'           => null,
                        'meta_data'       => null
                    );

                }
            }
            return $tweets;
        }
    }

}