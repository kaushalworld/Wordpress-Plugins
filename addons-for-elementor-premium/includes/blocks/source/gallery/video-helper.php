<?php

namespace LivemeshAddons\Modules\Source\Gallery;

use Elementor\Embed;

/**
 * Gallery class.
 *
 */
class LAE_Video_Helper {

    /**
     * Holds the class object.
     */
    public static $instance;

    /**
     * Primary class constructor.
     *
     */
    public function __construct() {

    }

    /**
     * Returns the video type given the video URL
     *
     */
    public function get_external_video_info($video_url, $settings) {

        $video_info = false;

        if (preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $video_url, $youtube_matches)) {

            $video_id_temp = $youtube_matches[1];

            // remove additional query string values
            if (strpos($video_id_temp, '?v=') !== false || strpos($video_id_temp, '?vi=') !== false) {
                $video_id = $video_id_temp;
            }
            else {
                $video_id_array = explode("?", $video_id_temp);
                $video_id = $video_id_array[0];
            }

            $type = 'youtube';

            $embed_url = esc_url(add_query_arg($this->get_youtube_video_args($settings), '//youtube.com/embed/' . $youtube_matches[1]));

        }
        elseif (preg_match('#(?:https?:\/\/(?:[\w]+\.)*vimeo\.com(?:[\/\w]*\/videos?)?\/([0-9]+)[^\s]*)#i', $video_url, $vimeo_matches)) {
            $video_id = $vimeo_matches[1];
            $type = 'vimeo';
            $embed_url = esc_url(add_query_arg($this->get_vimeo_video_args($settings), '//player.vimeo.com/video/' . $vimeo_matches[1]));

        }
        elseif (preg_match('/https?:\/\/(.+)?(wistia.com|wi.st)\/.*/i', $video_url, $wistia_matches)) {

            $parts = explode('/', $wistia_matches[0]);
            $video_id = array_pop($parts);
            $type = 'wistia';

            $embed_url = esc_url(add_query_arg($this->get_wistia_args($settings), '//fast.wistia.net/embed/iframe/' . $video_id));

        }

        // If a video type was found, return an array of video attributes
        if (isset($type)) {
            $video_info = array(
                'type' => $type,
                'video_id' => $video_id,
                'embed_url' => $embed_url,
            );
        }

        // Support other video types or other url match expressions for existing video types
        return apply_filters('lae_gallery_video_info', $video_info, $video_url, $settings); // return false if none found

    }

    public function get_youtube_video_args($settings) {

        $args = array(
            'autoplay' => 1,
            'controls' => 1,
            'enablejsapi' => 1,
            'modestbranding' => 1,
            'origin' => get_home_url(),
            'rel' => 0,
            'showinfo' => 0,
            'version' => 3,
            'wmode' => 'transparent',
        );

        return apply_filters('lae_gallery_youtube_video_args', $args, $settings);

    }

    public function get_vimeo_video_args($settings) {

        $args = array(
            'autoplay' => 1,
            'badge' => 0,
            'byline' => 0,
            'portrait' => 0,
            'title' => 0,
            'api' => 1,
            'wmode' => 'transparent',
            'fullscreen' => 1,
        );

        return apply_filters('lae_gallery_vimeo_video_args', $args, $settings);

    }

    public function get_wistia_args($settings) {

        $args = array(
            'autoPlay' => 'true',
            'chromeless' => 'false', // Controls
            'playbar' => 'true',
            'smallPlayButton' => 'true',
            'videoFoam' => 'true',
            'volumeControl' => 'true',
            'wmode' => 'opaque',
        );

        return apply_filters('lae_gallery_wistia_video_args', $args, $settings);

    }

    public function get_inline_video($item, $settings) {

        $output = '';

        // Enqueue scripts and generate the necessary HTML based on the video type
        switch ($item['item_type']) {

            case 'youtube':
                // Check if the URL is a video and a supported video type
                $video_info = $this->get_external_video_info($item['video_link'], $settings);

                if ($video_info) {

                    wp_enqueue_script('lae-youtube', 'https://www.youtube.com/iframe_api', array(), LAE_VERSION, true);

                    $youtube_output = '<div class="lae-youtube-video">';

                    $youtube_output .= '<iframe src="https://youtube.com/embed/' . $video_info['video_id']
                        . '" frameborder="0" allowfullscreen></iframe>';

                    $youtube_output .= '</div>';

                    $output = apply_filters('lae_gallery_inline_youtube_video', $youtube_output, $video_info, $item, $settings);
                }
                break;

            case 'vimeo':
                // Check if the URL is a video and a supported video type
                $video_info = $this->get_external_video_info($item['video_link'], $settings);

                if ($video_info) {

                    wp_enqueue_script('lae-vimeo', '//secure-a.vimeocdn.com/js/froogaloop2.min.js', array(), LAE_VERSION, true);

                    $vimeo_output = '<div class="lae-vimeo-video">';

                    $vimeo_output .= '<iframe src="//player.vimeo.com/video/' . $video_info['video_id']
                        . '" frameborder="0" allowfullscreen></iframe>';

                    $vimeo_output .= '</div>';

                    $output = apply_filters('lae_gallery_inline_vimeo_video', $vimeo_output, $video_info, $item, $settings);
                }
                break;

            case 'wistia':

                wp_enqueue_script('lae-wistia', '//fast.wistia.net/static/embed_shepherd-v1.js', array(), LAE_VERSION, true);

                break;
            case 'html5video':

                wp_enqueue_script('wp-mediaelement');
                wp_enqueue_style('wp-mediaelement');

                $poster = (!empty($item['item_image']['url'])) ? $item['item_image']['url'] : '';

                $html5_video = '<div class="lae-html5-video">';

                $html5_video .= '<video controls controlslist="nodownload" class="lae-html5video" preload="metadata" poster="' . $poster . '">';

                if (!empty($item['webm_video_link']))
                    $html5_video .= '<source type="video/webm" src="' . $item['webm_video_link'] . '" />';

                if (!empty($item['mp4_video_link']))
                    $html5_video .= '<source type="video/mp4" src="' . $item['mp4_video_link'] . '" />';

                $html5_video .= '</video>';

                $html5_video .= '</div><!-- .lae-html5-video -->';

                $output = apply_filters('lae_gallery_inline_html5_video', $html5_video, $item, $settings);

                break;
        }

        // Allow other inline video types to be supported
        return apply_filters('lae_gallery_inline_video_output', $output, $item, $settings);
    }


    /**
     * Get Youtube/Vimeo/Wistia image if no placeholder image is set
     */
    public function get_video_thumbnail_url($video_url, $settings) {

        $output = '';

        // Check if the URL is a video and a supported video type
        $video_info = $this->get_external_video_info($video_url, $settings);
        if (!$video_info) {
            return $output;
        }

        $thumbnail_url = null;
        $video_type = $video_info['type'];
        $video_id = $video_info['video_id'];

        switch ($video_type) {

            case 'youtube':
                // Determine video URL
                $base_url = 'https://img.youtube.com/vi/' . $video_id . '/';
                $hd_url = $base_url . 'maxresdefault.jpg'; // 1080p or 720p
                $sd_url = $base_url . 'mqdefault.jpg'; // 320x180 - hopefully higher resolution image exists

                $thumbnail_url = $sd_url;

                // Get HD image from YouTube
                $image_data = wp_remote_get($hd_url, array(
                    'timeout' => 10,
                ));

                // Check request worked
                if (!is_wp_error($image_data) && isset($image_data['body'])) {
                    $image_size = getimagesizefromstring($image_data['body']);

                    if (is_array($image_size) && ($image_size[0] !== 120 && $image_size[1] !== 90))
                        $thumbnail_url = $hd_url;
                }

                $thumbnail_url = apply_filters('lae_gallery_youtube_thumbnail_url', $thumbnail_url, $video_info, $settings);
                break;

            case 'vimeo':
                $response = wp_remote_get('https://vimeo.com/api/v2/video/' . esc_attr($video_id) . '.json');
                if (!is_wp_error($response)) {
                    $data = wp_remote_retrieve_body($response);
                    if (!is_wp_error($data)) {
                        $data = json_decode($data);
                        $thumbnail_url = $data[0]->thumbnail_large;
                    }
                }

                $thumbnail_url = apply_filters('lae_gallery_vimeo_thumbnail_url', $thumbnail_url, $video_info, $settings);
                break;

            case 'wistia':
                $response = wp_remote_get('https://fast.wistia.com/oembed?url=http%3A%2F%2Fhome.wistia.com%2Fmedias%2F' . esc_attr($video_id) . '.json');
                if (!is_wp_error($response)) {
                    $data = wp_remote_retrieve_body($response);
                    if (!is_wp_error($data)) {
                        $data = json_decode($data);
                        $thumbnail_url = $data->thumbnail_url;
                    }
                }

                $thumbnail_url = apply_filters('lae_gallery_wistia_thumbnail_url', $thumbnail_url, $video_info, $settings);
                break;
        }

        return apply_filters('lae_gallery_video_thumbnail_url', $thumbnail_url, $video_info, $settings);

    }

    public function get_video_lightbox_link($item, $settings) {

        $item_type = $item['item_type'];

        $output = '';

        if ($item_type == 'youtube' || $item_type == 'vimeo') :

            $video_info = $this->get_external_video_info($item['video_link'], $settings);

            $video_url = $video_info['embed_url'];

            if (!empty($video_url)) :

                if ($settings['lightbox_library'] == 'elementor'):


                    if ($item_type == 'vimeo')
                        $video_options = apply_filters('lae_gallery_vimeo_elementor_lightbox_options', ['loop' => '0', 'title' => '1', 'portrait' => '1', 'byline' => '1']);

                    if ($item_type == 'youtube')
                        $video_options = apply_filters('lae_gallery_youtube_elementor_lightbox_options', ['rel' => '0', 'controls' => '1', 'showinfo' => '1', 'mute' => '0', 'wmode' => 'opaque']);

                    $aspect_ratio = isset($item['aspect_ratio']) ? $item['aspect_ratio'] : 169;

                    $lightbox_options = apply_filters('lae_gallery_video_elementor_lightbox_options', [
                        'type' => 'video',
                        'videoType' => $item_type,
                        'url' => Embed::get_embed_url($item['video_link'], $video_options),
                        'modalOptions' => [
                            'id' => 'elementor-lightbox-' . esc_attr($settings['block_id']),
                            'entranceAnimation' => '',
                            'entranceAnimation_tablet' => '',
                            'entranceAnimation_mobile' => '',
                            'videoAspectRatio' => esc_attr($aspect_ratio),
                        ],
                    ]);

                    $output = '<div class="lae-video-lightbox elementor-clickable"'
                        . ' data-elementor-open-lightbox="yes"'
                        . ' data-elementor-lightbox=\'' . wp_json_encode($lightbox_options)
                        . '\' data-elementor-lightbox-slideshow="' . esc_attr($settings['block_id'])
                        . '" title="' . esc_html($item['item_name']) . '">';

                    $output .= '<i class="lae-icon-video-play"></i>';

                    $output .= '</div>';

                    $output = apply_filters('lae_gallery_video_elementor_lightbox_link', $output, $video_url, $item, $settings);

                else:

                    $output = '<a class="lae-video-lightbox"'
                        . ' data-fancybox="' . $settings['block_class']
                        . '" href="' . $video_url . '" data-elementor-open-lightbox="no" title="' . esc_html($item['item_name'])
                        . '" data-description="' . htmlspecialchars(wp_kses_post($item['item_description'])) . '">';

                    $output .= '<i class="lae-icon-video-play"></i>';

                    $output .= '</a>';

                    $output = apply_filters('lae_gallery_video_fancybox_lightbox_link', $output, $video_url, $item, $settings);

                endif;

            endif;

        elseif ($item_type == 'html5video' && !empty($item['mp4_video_link'])) :

            $video_id = 'lae-video-' . $item['item_image']['id']; // will use thumbnail id as id for video for now

            $output = '<a class="lae-video-lightbox"'
                . ' data-fancybox="' . $settings['block_class']
                . '" href="#' . $video_id . '" title="' . esc_html($item['item_name'])
                . '" data-description="' . htmlspecialchars(wp_kses_post($item['item_description'])) . '">';

            $output .= '<i class="lae-icon-video-play"></i>';

            $output .= '</a>';

            $output .= '<div id="' . $video_id . '" class="lae-fancybox-video" style="display:none;">';

            $output .= '<video poster="' . $item['item_image']['url'] . '" src="' . $item['mp4_video_link'] . '" preload="metadata" controls controlsList="nodownload">';

            $output .= '<source type="video/mp4" src="' . $item['mp4_video_link'] . '">';

            if (!empty($item['webm_video_link'])):

                $output .= '<source type="video/webm" src="' . $item['webm_video_link'] . '">';

            endif;

            $output .= '</video>';

            $output .= '</div>';

            $output = apply_filters('lae_gallery_video_html5video_lightbox_link', $output, $item, $settings);

        endif;

        return apply_filters('lae_gallery_video_lightbox_link', $output, $item, $settings);

    }

    /**
     * Returns the singleton instance of the class.
     *
     */
    public static function get_instance() {

        if (!isset(self::$instance) && !(self::$instance instanceof LAE_Video_Helper)) {
            self::$instance = new LAE_Video_Helper();
        }

        return self::$instance;

    }

}

// Load the metabox class.
$lae_video_helper = LAE_Video_Helper::get_instance();


