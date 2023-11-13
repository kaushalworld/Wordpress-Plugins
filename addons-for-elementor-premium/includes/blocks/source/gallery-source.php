<?php

namespace LivemeshAddons\Modules\Source;

use Elementor\Utils;
use LivemeshAddons\Modules\Source\Gallery\LAE_Video_Helper;

class LAE_Gallery_Source extends LAE_Source {

    public $item;

    public $item_type;

    public $video_helper;

    function __construct($item, $settings) {

        parent::__construct($settings);

        $this->item = $item;

        $this->item_type = $item['item_type'];

        $this->video_helper = LAE_Video_Helper::get_instance();
    }

    function is_video_item() {

        $item_type = $this->item['item_type'];

        $video_types = apply_filters('lae_gallery_video_types', array('youtube', 'vimeo', 'html5video'));

        return in_array($item_type, $video_types);

    }

    function is_inline_video() {

        if ($this->is_video_item())

            return $this->item['display_video_inline'];

        return false;

    }

    function get_inline_video() {

        return $this->video_helper->get_inline_video($this->item, $this->settings);
    }

    function get_thumbnail($size = 'default') {

        $output = '';

        if ($thumbnail_exists = has_post_thumbnail($this->post_ID)):

            $output .= '<div class="lae-module-thumb">';

            $output .= $this->get_media($size);

            $output .= $this->get_lightbox();

            $output .= '</div><!-- .lae-module-thumb -->';

        endif;

        return apply_filters('lae_post_item_thumbnail', $output, $size, $this);
    }

    function get_media($size = 'default') {

        $output = '';

        if ($this->is_video_item()):

            $image_html = '';

            if (isset($this->item['item_image']) && !empty($this->item['item_image']['id'])):

                $image_html = lae_get_image_html($this->item['item_image'], 'thumbnail_size', $this->settings, true);

            elseif ($this->item_type == 'youtube' || $this->item_type == 'vimeo') :

                $thumbnail_url = $this->video_helper->get_video_thumbnail_url($this->item['video_link'], $this->settings);

                if (!empty($thumbnail_url)):

                    $image_html = sprintf('<img loading="eager" data-no-lazy="1" src="%s" title="%s" alt="%s" class="lae-image %s"/>', esc_attr($thumbnail_url), esc_html($this->item['item_name']), esc_html($this->item['item_name']), lae_disable_lazy_load_classes());

                endif;

            endif;

            $output .= apply_filters('lae_gallery_video_thumbnail_html', $image_html, $this->item, $this->settings);

        else:

            $image_html = lae_get_image_html($this->item['item_image'], 'thumbnail_size', $this->settings, true);

            if ($this->item_type == 'image' && !empty($this->item['item_link']['url'])):

                $image_html = '<a class="lae-post-link" href="' . esc_url($this->item['item_link']['url']) . '" title="' . esc_html($this->item['item_name']) . '">' . $image_html . '</a>';

            endif;

            $output .= apply_filters('lae_gallery_thumbnail_html', $image_html, $this->item, $this->settings);

        endif;

        return apply_filters('lae_post_item_media', $output, $size, $this);
    }

    function get_media_overlay() {

        $output = '<div class="lae-module-image-overlay"></div>';

        return apply_filters('lae_post_item_media_overlay', $output, $this);

    }

    function get_lightbox() {

        $output = '';

        if ($this->item_type == 'image' && !empty($this->item['item_image']) && $this->settings['enable_lightbox']) :

            $anchor_type = (empty($this->item['item_link']['url']) ? 'lae-click-anywhere' : 'lae-click-icon');

            if ($this->settings['lightbox_library'] == 'elementor'):

                $output = '<a class="lae-lightbox-item ' . $anchor_type . ' elementor-clickable" href="' . $this->item['item_image']['url'] . '" data-elementor-open-lightbox="yes" data-elementor-lightbox-slideshow="' . esc_attr($this->settings['block_id']) . '" title="' . esc_html($this->item['item_name']) . '">';

                $output .= '<i class="lae-icon-full-screen"></i>';

                $output .= '</a>';

                $output = apply_filters('lae_gallery_elementor_lightbox_link', $output, $this->item, $this->settings);

            else:

                $thumbnail_src = wp_get_attachment_image_src($this->item['item_image']['id']);

                if ($thumbnail_src)
                    $thumbnail_src = $thumbnail_src[0];

                $output = '<a class="lae-lightbox-item ' . $anchor_type . '" data-fancybox="' . $this->settings['block_class'] . '" data-thumb="' . $thumbnail_src . '" href="' . $this->item['item_image']['url'] . '" data-elementor-open-lightbox="no" title="' . esc_html($this->item['item_name']) . '" data-description="' . htmlspecialchars(wp_kses_post($this->item['item_description'])) . '">';

                $output .= '<i class="lae-icon-full-screen"></i>';

                $output .= '</a>';

                $output = apply_filters('lae_gallery_fancybox_lightbox_link', $output, $this->item, $this->settings);

            endif;

            return apply_filters('lae_gallery_image_lightbox_link', $output, $this->item, $this->settings);

        endif;

        return apply_filters('lae_gallery_item_lightbox_html', $output, $this);

    }

    function get_video_lightbox() {

        $output = '';

        if ($this->is_video_item()):

            $output .= $this->video_helper->get_video_lightbox_link($this->item, $this->settings);

        endif;

        return apply_filters('lae_gallery_item_video_lightbox_html', $output, $this);
    }

    function get_title() {

        $output = '';

        if ($this->settings['display_item_title']):

            $output .= '<' . lae_validate_html_tag($this->settings['item_title_tag']) . ' class="lae-entry-title">';

            if ($this->item_type == 'image' && !empty($this->item['item_link']['url'])):

                $target = $this->item['item_link']['is_external'] ? 'target="_blank"' : '';

                $output .= '<a href="' . esc_url($this->item['item_link']['url']) . '" title="' . esc_html($this->item['item_name']) . '"' . $target . '>' . esc_html($this->item['item_name']) . '</a>';

            else:

                $output .= esc_html($this->item['item_name']);

            endif;

            $output .= '</' . lae_validate_html_tag($this->settings['item_title_tag']) . '>';

        endif;

        return apply_filters('lae_gallery_item_title', $output, $this->item, $this->settings);

    }

    function get_taxonomies_info() {

        $output = '';

        if ($this->settings['display_item_tags']) :

            $output .= apply_filters('lae_gallery_info_tags', '<div class="lae-terms">' . esc_html($this->item['item_tags']) . '</div>', $this->item, $this->settings);

        endif;

        return apply_filters('lae_gallery_item_taxonomies_info', $output, $this);
    }

    function get_excerpt() {

        $output = '';

        if ($this->settings['display_description'] && !empty($this->item['item_description'])) :

            $output = '<div class="lae-entry-summary">';

            $output .= htmlspecialchars_decode($this->item['item_description']);

            $output .= '</div><!-- .lae-entry-summary -->';

        endif;

        return apply_filters('lae_post_item_excerpt', $output, $this);

    }
}