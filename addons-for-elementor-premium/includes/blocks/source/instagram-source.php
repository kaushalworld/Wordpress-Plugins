<?php

namespace LivemeshAddons\Modules\Source;

class LAE_Instagram_Grid_Source extends LAE_Source {

    public $item;

    function __construct($item, $settings) {

        parent::__construct($settings);

        $this->item = $item;
    }

    function has_post_thumbnail() {

        $thumbnail_exists = isset($this->item['image']) && !empty($this->item['image']['url']);

        return $thumbnail_exists;
    }

    public function get_thumbnail() {

        $output = '';

        if ($thumbnail_exists = !empty($this->item['image'] && !empty($this->item['image']['url']))):

            $output .= '<div class="lae-module-thumb">';

            $output .= $this->get_media();

            $output .= $this->get_lightbox();

            $output .= '</div><!-- .lae-module-thumb -->';

        endif;

        return apply_filters('lae_instagram_post_thumbnail', $output, $size, $this);
    }

    public function get_media() {

        $output = '';

        $image_html = '';

        if (isset($this->item['image']) && !empty($this->item['image']['url'])):

            $image_html = sprintf('<img loading="eager" data-no-lazy="1" src="%s" title="%s" alt="%s" class="lae-image %s"/>', esc_url($this->item['image']['url']), esc_html($this->item['image']['alt']), esc_html($this->item['image']['alt']), lae_disable_lazy_load_classes());

        endif;

        $image_html = apply_filters('lae_instagram_post_thumbnail_html', $image_html, $this->item, $this->settings);

        if (!empty($image_html)) :

            if ($this->settings['image_linkable']):

                $target = $this->settings['post_link_new_window'] ? ' target="_blank"' : '';

                $output = '<a class="lae-post-link" href="' . esc_url($this->item['url']) . '"' . $target . '>' . $image_html . '</a>';

            else:

                $output = $image_html;

            endif;

        endif;

        return apply_filters('lae_instagram_post_media', $output, $this);
    }


    public function get_media_overlay() {

        $output = '<div class="lae-module-image-overlay"></div>';

        return apply_filters('lae_instagram_post_media_overlay', $output, $this);

    }

    public function get_lightbox() {

        $output = '';

        $item = $this->item;

        $settings = $this->settings;

        $anchor_type = ($settings['image_linkable']) ? 'lae-click-icon' : 'lae-click-anywhere';

        if ($item['item_type'] = 'video' && !empty($item['video'])) {

            $video_id = 'lae-video-' . $item['ID']; // will use node id as id for video for now

            $output = '<a class="lae-video-lightbox '
                . $anchor_type
                . '" data-fancybox="' . $settings['block_class']
                . '" href="#' . $video_id . '" title="' . esc_html__('Play Video', 'livemesh-el-addons')
                . '" data-author-link="' . esc_url($item['author']['url']) . '" data-author-name="' . esc_attr($item['author']['name']) . '" data-author-username="@' . esc_attr($item['author']['username'])
                . '" data-post-link="' . esc_url($item['url']) . '" data-post-text="' . htmlspecialchars(wp_kses_post($item['item_description']))
                . '" data-read-more-text="' . esc_html($settings['lightbox_read_more_text']) . '">';

            $output .= '<i class="lae-icon-video-play"></i>';

            $output .= '</a>';

            $output .= '<div id="' . $video_id . '" class="lae-fancybox-video" style="display:none;">';

            $output .= '<video poster="' . $item['image']['video_thumb_url'] . '" src="' . $item['video']['mp4'] . '" preload="metadata" controls controlsList="nodownload">';

            $output .= '<source type="video/mp4" src="' . $item['video']['mp4'] . '">';

            $output .= '</video>';

            $output .= '</div>';

            return apply_filters('lae_gallery_video_html5video_lightbox_link', $output, $item, $settings);
        }

        if (isset($item['image']) && !empty($item['image']['lb_url']) && $settings['enable_lightbox']) :

            if ($settings['lightbox_library'] == 'elementor'):

                $output = '<a class="lae-lightbox-item ' . $anchor_type . ' elementor-clickable" href="' . $item['image']['lb_url'] . '" data-elementor-open-lightbox="yes" data-elementor-lightbox-slideshow="' . esc_attr($settings['block_id']) . '" title="' . esc_html__('Expand Image', 'livemesh-el-addons') . '">';

                $output .= '<i class="lae-icon-full-screen"></i>';

                $output .= '</a>';

                $output = apply_filters('lae_instagram_grid_elementor_lightbox_link', $output, $item, $settings);

            else:

                $output = '<a class="lae-lightbox-item ' . $anchor_type . '" data-fancybox="' . $settings['block_class'] . '" href="' . $item['image']['lb_url'] . '" data-elementor-open-lightbox="no" data-author-link="' . esc_url($item['author']['url']) . '" data-author-name="' . esc_attr($item['author']['name']) . '" data-author-username="@' . esc_attr($item['author']['username']) . '" data-post-link="' . esc_url($item['url']) . '" data-post-text="' . htmlspecialchars(wp_kses_post($item['item_description'])) . '" data-read-more-text="' . esc_html($settings['lightbox_read_more_text']) . '" title="' . esc_html__('Expand Image', 'livemesh-el-addons') . '">';

                $output .= '<i class="lae-icon-full-screen"></i>';

                $output .= '</a>';

                $output = apply_filters('lae_instagram_grid_fancybox_lightbox_link', $output, $item, $settings);

            endif;

            return apply_filters('lae_instagram_grid_image_lightbox_link', $output, $item, $settings);

        endif;

        return apply_filters('lae_instagram_grid_item_lightbox_html', $output, $this);

    }

    public function get_excerpt() {

        $output = '';

        if (!empty($this->item['item_description'] && $this->settings['display_excerpt'])) :

            $output = '<div class="lae-entry-summary">';

            $output .= $this->get_description();

            $output .= '</div><!-- .lae-entry-summary -->';

        endif;

        return apply_filters('lae_instagram_post_text', $output, $this);

    }

    public function get_likes_or_views() {

        $output = '';

        if ($this->settings['display_likes']) :

            if ($this->item['item_type'] = 'video' && !empty($this->item['video'])) {

                $output = '<div class="lae-entry-views">';

                $output .= '<i class="lae-icon-play"></i>';

                $output .= lae_shorten_number_format($this->item['views_number']);

                $output .= '</div>';
            }
            else {
                $output = '<div class="lae-entry-likes">';

                $output .= '<i class="lae-icon-heart"></i>';

                $output .= lae_shorten_number_format($this->item['likes_number']);

                $output .= '</div>';
            }

        endif;

        return apply_filters('lae_instagram_post_likes', $output, $this);

    }

    public function get_read_more_link() {

        $output = '';

        if ($this->settings['display_read_more']) {

            $read_more_text = $this->settings['read_more_text'];

            $output .= '<div class="lae-read-more">';

            $output .= '<a href="' . $this->item['url'] . '">' . $read_more_text . '</a>';

            $output .= '</div>';

        }

        return apply_filters('lae_instagram_post_read_more_link', $output, $this);

    }

    public function get_author() {

        $output = '';

        if ($this->settings['display_avatar'] || $this->settings['display_name'] || $this->settings['display_username']) :

            $output .= '<a class="lae-instagram-user" href="' . esc_url($this->item['author']['url']) . '" title="' . esc_attr($this->item['author']['name']) . '">';

            if (!empty($this->item['author']['avatar']) && $this->settings['display_avatar']):

                $profile_image = sprintf('<img src="%s" title="%s" alt="%s" class="lae-avatar"/>', esc_attr($this->item['author']['avatar']), esc_html($this->item['author']['name']), esc_html($this->item['author']['name']));

                $output .= '<span class="lae-social-avatar">' . $profile_image . '</span>';

            endif;

            $output .= '<span class="lae-user-details">';

            if ($this->settings['display_name']) :

                $output .= '<span class="lae-instagram-name">' . esc_html($this->item['author']['name']) . '</span>';

            endif;

            if ($this->settings['display_username']) :

                $output .= '<span class="lae-instagram-username">' . '@' . esc_html($this->item['author']['username']) . '</span>';

            endif;

            $output .= '</span>';

            $output .= '</a>';

        endif;

        return apply_filters('lae_instagram_post_author', $output, $this);
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

            $output .= '<a class="lae-posted-date" href="' . esc_url($this->item['url']) . '" title="' . $date . '"><span class="lae-published">' . $date . '</span></a>';;

        endif;

        return apply_filters('lae_instagram_post_date', $output, $this);
    }

    public function get_comments_number() {

        $output = '';

        if ($this->settings['display_comments']) :

            $output = '<div class="lae-entry-comments">';

            $output .= '<i class="lae-icon-bubble"></i>';

            $output .= lae_shorten_number_format($this->item['comments_number']);

            $output .= '</div>';

        endif;

        return apply_filters('lae_instagram_post_comments', $output, $this);

    }

    private function get_description() {

        $excerpt = '';

        if (!empty($this->item['item_description'])) :

            $excerpt_count = $this->settings['excerpt_length'];

            $excerpt = $this->item['item_description'];

            $excerpt = wp_trim_words($excerpt, $excerpt_count, '…');

            $excerpt = $excerpt ? preg_replace('~(\#)([^\s!,. /()"\'?]+)~', '<a href="https://www.instagram.com/explore/tags/$2/" target="_blank" class="lae-item-social-link">#$2</a>', $excerpt) : null;
            $excerpt = $excerpt ? preg_replace('~(\@)([^\s!,. /()"\'?]+)~', '<a href="https://www.instagram.com/$2/" target="_blank" class="lae-item-social-link">@$2</a>', $excerpt) : null;

        endif;

        return $excerpt;

    }
}