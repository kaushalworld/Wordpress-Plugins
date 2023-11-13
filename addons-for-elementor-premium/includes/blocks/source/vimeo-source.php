<?php

namespace LivemeshAddons\Modules\Source;

use Elementor\Utils;
use LivemeshAddons\Modules\Source\Gallery\LAE_Video_Helper;


class LAE_Vimeo_Grid_Source extends LAE_Source {

    public $item;

    public $item_type;

    public $video_helper;

    function __construct($item, $settings) {

        parent::__construct($settings);

        $this->item = $item;

        $this->item_type = 'vimeo';

        $this->video_helper = LAE_Video_Helper::get_instance();
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

        return apply_filters('lae_vimeo_post_thumbnail', $output, $size, $this);
    }

    function is_inline_video() {

        return $this->settings['display_video_inline'];

    }


    function get_inline_video() {

        return $this->video_helper->get_inline_video($this->item, $this->settings);
    }

    public function get_media($size = 'default') {

        $output = '';

        $image_html = '';

        if (isset($this->item['image']) && !empty($this->item['image']['url'])):

            $image_html = sprintf('<img loading="eager" data-no-lazy="1" src="%s" title="%s" alt="%s" class="lae-image %s"/>', esc_attr($this->item['image']['url']), esc_html($this->item['image']['alt']), esc_html($this->item['image']['alt']), lae_disable_lazy_load_classes());

        endif;

        $output .= apply_filters('lae_vimeo_post_thumbnail_html', $image_html, $this->item, $this->settings);


        return apply_filters('lae_vimeo_post_media', $output, $size, $this);
    }

    public function get_media_overlay() {

        $output = '<div class="lae-module-image-overlay"></div>';

        return apply_filters('lae_vimeo_post_media_overlay', $output, $this);

    }

    public function get_video_lightbox() {

        $output = '';

        $output .= $this->video_helper->get_video_lightbox_link($this->item, $this->settings);

        return apply_filters('lae_vimeo_post_video_lightbox_html', $output, $this);
    }

    function get_entry_title() {

        $output = '';

        if ($this->settings['display_item_title']):

            $output = $this->get_title();

        endif;

        return apply_filters('lae_vimeo_entry_title', $output, $this->item, $this->settings);

    }

    function get_thumbnail_title() {

        $output = '';

        if ($this->settings['display_thumbnail_title']):

            $output = $this->get_title();

        endif;

        return apply_filters('lae_vimeo_thumbnail_title', $output, $this->item, $this->settings);

    }

    function get_title() {

        $output = '<' . lae_validate_html_tag($this->settings['item_title_tag']) . ' class="lae-entry-title">';

        if (!empty($this->item['video_link'])):

            $target = 'target="_blank"';

            $output .= '<a href="' . esc_url($this->item['video_link']) . '" title="' . esc_html($this->item['item_name']) . '"' . $target . '>' . esc_html($this->item['item_name']) . '</a>';

        endif;

        $output .= '</' . lae_validate_html_tag($this->settings['item_title_tag']) . '>';


        return apply_filters('lae_vimeo_post_title', $output, $this->item, $this->settings);

    }

    public function get_excerpt() {

        $output = '';

        if (!empty($this->item['item_description'] && $this->settings['display_excerpt'])) :

            $output = '<div class="lae-entry-summary">';

            $output .= $this->get_description();

            $output .= '</div><!-- .lae-entry-summary -->';

        endif;

        return apply_filters('lae_vimeo_post_text', $output, $this);

    }

    public function get_views() {

        $output = '';

        if ($this->settings['display_views']) :

            $output = '<div class="lae-entry-views">';

            $output .= '<i class="lae-icon-eye"></i>';

            $output .= lae_shorten_number_format($this->item['views_number']);

            $output .= '</div>';

        endif;

        return apply_filters('lae_vimeo_post_views', $output, $this);

    }

    public function get_duration() {

        $output = '';

        if ($this->settings['display_duration']) :

            $output = '<div class="lae-entry-duration">';

            $output .= $this->item['video']['duration'];

            $output .= '</div>';

        endif;

        return apply_filters('lae_vimeo_post_duration', $output, $this);

    }

    public function get_likes() {

        $output = '';

        if ($this->settings['display_likes']) :

            $output = '<div class="lae-entry-likes">';

            $output .= '<i class="lae-icon-heart"></i>';

            $output .= lae_shorten_number_format($this->item['likes_number']);

            $output .= '</div>';

        endif;

        return apply_filters('lae_vimeo_post_likes', $output, $this);

    }

    public function get_channel() {

        $output = '';

        if ($this->settings['display_user']) :

            $output .= '<a class="lae-vimeo-channel" href="' . esc_url($this->item['author']['url']) . '" title="' . esc_attr($this->item['author']['name']) . '">';

            $output .= '<span class="lae-channel-details">';

            if (!empty($this->item['author']['avatar'])):

                $profile_image = sprintf('<img src="%s" title="%s" alt="%s" class="lae-avatar"/>', esc_attr($this->item['author']['avatar']), esc_html($this->item['author']['name']), esc_html($this->item['author']['name']));

                $output .= '<span class="lae-social-avatar">' . $profile_image . '</span>';

            endif;

            $output .= '<span class="lae-channel-name">' . esc_html($this->item['author']['name']) . '</span>';

            $output .= '</span>';

            $output .= '</a>';

        endif;

        return apply_filters('lae_vimeo_post_author', $output, $this);
    }

    public function get_date() {

        $output = '';

        if ($this->settings['display_date']) :

            $date_format = $this->settings['date_format'];

            $date = $this->item['date'];

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

            $output .= '<a class="lae-posted-date" href="' . esc_url($this->item['video_link']) . '" title="' . $date . '"><span class="lae-published">' . $date . '</span></a>';;

        endif;

        return apply_filters('lae_vimeo_post_date', $output, $this);
    }

    public function get_comments_number() {

        $output = '';

        if ($this->settings['display_comments']) :

            $output = '<div class="lae-entry-comments">';

            $output .= '<i class="lae-icon-bubble"></i>';

            $output .= lae_shorten_number_format($this->item['comments_number']);

            $output .= '</div>';

        endif;

        return apply_filters('lae_vimeo_post_comments', $output, $this);

    }

    private function get_description() {

        $excerpt = '';

        if (!empty($this->item['item_description'])) :

            $excerpt_count = $this->settings['excerpt_length'];

            $excerpt = $this->item['item_description'];

            $excerpt = wp_trim_words($excerpt, $excerpt_count, '…');

            $excerpt = preg_replace('/(https?:\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?)/i', '<a href="$1" target="_blank" class="lae-entry-social-link">$1</a>', $excerpt);

        endif;

        return $excerpt;

    }

    function get_categories() {

        $output = '';

        if ($this->settings['display_categories']) :

            $output = '';

            $terms = $this->item['meta_data'];

            if (!empty($terms)) {

                $output .= '<div class="lae-terms">';

                foreach ($terms as $term) {

                    $output .= '<a href="' . $term['link'] . '">' . $term['name'] . '</a>';
                }
                $output .= '</div>';
            }

        endif;

        return apply_filters('lae_vimeo_post_categories', $output, $this);
    }
}