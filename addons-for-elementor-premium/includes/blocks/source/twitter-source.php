<?php

namespace LivemeshAddons\Modules\Source;

class LAE_Twitter_Grid_Source extends LAE_Source {

    public $item;

    function __construct($item, $settings) {

        parent::__construct($settings);

        $this->item = $item;
    }

    function has_post_thumbnail() {

        $thumbnail_exists = isset($this->item['image']) && !empty($this->item['image']['url']);

        return $thumbnail_exists;
    }

    public function get_thumbnail($size = 'default') {

        $output = '';

        if ($thumbnail_exists = !empty($this->item['image'])):

            $output .= '<div class="lae-module-thumb">';

            $output .= $this->get_media($size);

            $output .= $this->get_lightbox();

            $output .= '</div><!-- .lae-module-thumb -->';

        endif;

        return apply_filters('lae_twitter_post_thumbnail', $output, $size, $this);
    }

    public function get_media($size = 'default') {

        $output = '';

        $image_html = '';

        if (isset($this->item['image']) && !empty($this->item['image']['url'])):

            $image_html = sprintf('<img loading="eager" data-no-lazy="1" src="%s" title="%s" alt="%s" class="lae-image %s"/>', esc_attr($this->item['image']['url']), esc_html($this->item['image']['alt']), esc_html($this->item['image']['alt']), lae_disable_lazy_load_classes());

        endif;

        $output .= apply_filters('lae_twitter_post_thumbnail_html', $image_html, $this->item, $this->settings);


        return apply_filters('lae_twitter_post_media', $output, $size, $this);
    }

    public function get_media_overlay() {

        $output = '<div class="lae-module-image-overlay"></div>';

        return apply_filters('lae_twitter_post_media_overlay', $output, $this);

    }

    public function get_lightbox() {

        $output = '';

        if (isset($this->item['image']) && !empty($this->item['image']['url']) && $this->settings['enable_lightbox']) :

            $anchor_type = 'lae-click-anywhere';

            if ($this->settings['lightbox_library'] == 'elementor'):

                $output = '<a class="lae-lightbox-item ' . $anchor_type . ' elementor-clickable" href="' . $this->item['image']['url'] . '" data-elementor-open-lightbox="yes" data-elementor-lightbox-slideshow="' . esc_attr($this->settings['block_id']) . '" title="' . esc_html($this->item['image']['alt']) . '">';

                $output .= '<i class="lae-icon-full-screen"></i>';

                $output .= '</a>';

                $output = apply_filters('lae_twitter_grid_elementor_lightbox_link', $output, $this->item, $this->settings);

            else:

                $output = '<a class="lae-lightbox-item ' . $anchor_type . '" data-fancybox="' . $this->settings['block_class'] . '" href="' . $this->item['image']['url'] . '" data-elementor-open-lightbox="no" data-author-link="' . esc_url($this->item['author']['url']) . '" data-author-name="' . esc_attr($this->item['author']['name']) . '" data-author-username="@' . esc_attr($this->item['author']['screen_name']) . '" data-tweet-link="' . esc_url($this->item['post_url']) . '" data-tweet-text="' . htmlspecialchars(wp_kses_post($this->item['text'])) . '" title="' . esc_attr($this->item['author']['name']) . '">';

                $output .= '<i class="lae-icon-full-screen"></i>';

                $output .= '</a>';

                $output = apply_filters('lae_twitter_grid_fancybox_lightbox_link', $output, $this->item, $this->settings);

            endif;

            return apply_filters('lae_twitter_grid_image_lightbox_link', $output, $this->item, $this->settings);

        endif;

        return apply_filters('lae_twitter_grid_item_lightbox_html', $output, $this);

    }

    public function get_excerpt() {

        $output = '';

        if (!empty($this->item['text'])) :

            $output = '<div class="lae-entry-summary">';

            $output .= htmlspecialchars_decode($this->item['text']);

            $output .= '</div><!-- .lae-entry-summary -->';

        endif;

        return apply_filters('lae_twitter_post_text', $output, $this);

    }

    public function get_retweets() {

        $output = '';

        if ($this->settings['display_retweets']) :

            $output = '<div class="lae-entry-retweets">';

            $output .= '<i class="lae-icon-retweet"></i>';

            $output .= $this->item['retweet_count'];

            $output .= '</div>';

        endif;

        return apply_filters('lae_twitter_post_retweets', $output, $this);

    }

    public function get_likes() {

        $output = '';

        if ($this->settings['display_likes']) :

            $output = '<div class="lae-entry-likes">';

            $output .= '<i class="lae-icon-heart"></i>';

            $output .= $this->item['likes_number'];

            $output .= '</div>';

        endif;

        return apply_filters('lae_twitter_post_likes', $output, $this);

    }

    public function get_read_more_link() {

        $output = '';

        if ($this->settings['display_read_more']) {

            $read_more_text = $this->settings['read_more_text'];

            $output .= '<div class="lae-read-more">';

            $output .= '<a href="' . $this->item['post_url'] . '">' . $read_more_text . '</a>';

            $output .= '</div>';

        }

        return apply_filters('lae_twitter_post_read_more_link', $output, $this);

    }

    public function get_author() {

        $output = '';

        if ($this->settings['display_avatar'] || $this->settings['display_name'] || $this->settings['display_username']) :

            $output .= '<a class="lae-twitter-user" href="' . esc_url($this->item['author']['url']) . '" title="' . esc_attr($this->item['author']['name']) . '">';

            if (!empty($this->item['author']['avatar']) && $this->settings['display_avatar']):

                $profile_image = sprintf('<img src="%s" title="%s" alt="%s" class="lae-avatar"/>', esc_attr($this->item['author']['avatar']), esc_html($this->item['author']['name']), esc_html($this->item['author']['name']));

                $output .= '<span class="lae-social-avatar">' . $profile_image . '</span>';

            endif;

            $output .= '<span class="lae-user-details">';

            if ($this->settings['display_name']) :

                $output .= '<span class="lae-twitter-name">' . esc_html($this->item['author']['name']) . '</span>';

            endif;

            if ($this->settings['display_username']) :

                $output .= '<span class="lae-twitter-username">' . '@' . esc_html($this->item['author']['screen_name']) . '</span>';

            endif;

            $output .= '</span>';

            $output .= '</a>';

        endif;

        return apply_filters('lae_twitter_post_author', $output, $this);
    }

    public function get_date() {

        $output = '';

        if ($this->settings['display_date']) :

            $date_format = $this->settings['date_format'];

            $date = $this->item['post_date'];

            if ($date_format === 'standard_date')
                $format = get_option('date_format');
            else if ($date_format === 'standard_date_time')
                $format = get_option('date_format') . ' ' . get_option('time_format');
            else
                $format = 'elapsed_time';

            if ($format == 'elapsed_time') {
                $date = sprintf(_x('%s ago', '%s = human-readable time difference', 'livemesh-el-addons'), human_time_diff($date, date_i18n('U')));
            }
            else {
                $date = date_i18n($format, $date);
            }

            $output .= '<a class="lae-posted-date" href="' . esc_url($this->item['post_url']) . '" title="' . $date . '"><span class="lae-published">' . $date . '</span></a>';;

        endif;

        return apply_filters('lae_twitter_post_date', $output, $this);
    }

    public function get_comments() {

        $output = '';

        if ($this->settings['display_comments']) :

            $output = '<div class="lae-entry-comments">';

            $output .= $this->item['comments_number'];

            $output .= '</div>';

        endif;

        return apply_filters('lae_twitter_post_comments', $output, $this);

    }
}