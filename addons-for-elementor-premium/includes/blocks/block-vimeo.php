<?php

namespace LivemeshAddons\Blocks;

use LivemeshAddons\Blocks\Clients\LAE_Vimeo_Client;

abstract class LAE_Vimeo_Block extends LAE_Block {

    protected $vimeo_client;

    public function init_block() {

        $this->vimeo_client = new LAE_Vimeo_Client($this->settings);

        $this->block_items = $this->get_block_items();

        $block_header_args = array(
            'settings' => $this->settings,
            'block_uid' => $this->block_uid,
            'social_api_client' => $this->vimeo_client
        );

        $block_header_class = '\LivemeshAddons\Blocks\Headers\\' . LAE_Blocks_Manager::get_class_name($this->settings['header_template']);

        $this->block_header_obj = new $block_header_class($block_header_args);
    }

    public function get_block_items() {

        $block_items = $this->vimeo_client->get_grid_items();

        return $block_items;
    }

    public function get_block_header() {

        $output = $this->block_header_obj->get_block_header();

        return apply_filters('lae_vimeo_block_header_output', $output);

    }

    public function get_block_footer() {

        $output = $this->get_block_pagination();

        return apply_filters('lae_vimeo_block_footer_output', $output);
    }

    // get atts
    protected function get_block_data_atts() {

        $output = '';

        $output .= " data-block-uid='" . $this->block_uid . "'";

        $output .= " data-action='lae_load_vimeo_block'";

        $output .= " data-settings='" . wp_json_encode($this->get_settings_data_atts()) . "'";

        $query_meta = $this->vimeo_client->get_query_meta();

        // store page token and other information for vimeo posts for load more function
        $output .= " data-query-meta='" . wp_json_encode($query_meta) . "'";

        $output .= " data-current='1'";

        return apply_filters('lae_vimeo_block_data_attributes', $output, $this);

    }

    protected function get_settings_defaults() {

        return array(
            'class' => '',
            'block_type' => 'block_1',
            'pagination' => 'load_more',
            'ajax_data' => ''
        );

    }

    protected function get_settings_data_atts() {

        $data_atts = array();

        /* Block Content */
        $data_atts['block_class'] = $this->settings['block_class'];

        $data_atts['block_type'] = $this->settings['block_type'];

        $data_atts['block_id'] = $this->settings['block_id'];

        /* Vimeo Item Content */

        $data_atts['vimeo_source'] = $this->settings['vimeo_source'];

        $data_atts['vimeo_sort'] = $this->settings['vimeo_sort'];

        $data_atts['vimeo_order'] = $this->settings['vimeo_order'];

        $data_atts['vimeo_user'] = $this->settings['vimeo_user'];

        $data_atts['vimeo_album'] = $this->settings['vimeo_album'];

        $data_atts['vimeo_group'] = $this->settings['vimeo_group'];

        $data_atts['vimeo_channel'] = $this->settings['vimeo_channel'];

        $data_atts['display_video_inline'] = $this->settings['display_video_inline'];

        $data_atts['display_thumbnail_title'] = $this->settings['display_thumbnail_title'];

        $data_atts['display_item_title'] = $this->settings['display_item_title'];

        $data_atts['display_excerpt'] = $this->settings['display_excerpt'];

        $data_atts['excerpt_length'] = $this->settings['excerpt_length'];

        $data_atts['display_name'] = $this->settings['display_name'];

        $data_atts['display_date'] = $this->settings['display_date'];

        $data_atts['date_format'] = $this->settings['date_format'];

        $data_atts['display_comments'] = $this->settings['display_comments'];

        $data_atts['display_views'] = $this->settings['display_views'];

        $data_atts['display_duration'] = $this->settings['display_duration'];

        $data_atts['display_likes'] = $this->settings['display_likes'];

        $data_atts['display_user'] = $this->settings['display_user'];

        $data_atts['display_categories'] = $this->settings['display_categories'];

        $data_atts['per_line'] = $this->settings['per_line'];

        $data_atts['per_line_tablet'] = $this->settings['per_line_tablet'];

        $data_atts['per_line_mobile'] = $this->settings['per_line_mobile'];

        $data_atts['layout_mode'] = $this->settings['layout_mode'];

        $data_atts['lightbox_library'] = $this->settings['lightbox_library'];

        $data_atts['pagination'] = $this->settings['pagination'];

        $data_atts['items_per_page'] = $this->settings['items_per_page'];

        $data_atts['item_title_tag'] = $this->settings['item_title_tag'];

        return apply_filters('lae_vimeo_block_settings_data_attributes', $data_atts, $this->settings);

    }


    protected function get_block_pagination() {

        $pagination_type = $this->settings['pagination'];

        // no pagination required if option is not chosen by user or if all posts are already displayed
        if ($pagination_type == 'none')
            return;

        $output = '<div class="lae-pagination ' . 'lae-' . preg_replace('/_/', '-', $pagination_type) . '-nav">';

        switch ($pagination_type) {

            case 'next_prev':

                $output .= '<a class="lae-page-nav lae-disabled" href="#" data-page="prev"><i class="lae-icon-arrow-left3"></i></a>';

                $output .= '<a class="lae-page-nav" href="#" data-page="next"><i class="lae-icon-arrow-right3"></i></a>';

                break;

            case 'load_more':

                $output .= '<a href="#" class="lae-load-more lae-button">';

                $output .= __('Load More', 'livemesh-el-addons');

                $output .= '</a>';

                break;

        }

        $output .= '<span class="lae-loading"></span>';

        $output .= '</div><!-- .lae-pagination -->';

        return apply_filters('lae_vimeo_block_pagination', $output, $this);
    }

    protected function get_grid_classes($settings) {

        $grid_classes = 'lae-' . $settings['layout_mode'];

        $grid_classes .= $this->get_grid_classes_from_settings_field($settings, 'per_line');

        return $grid_classes;

    }

    protected function get_grid_item_classes($item, $settings) {

        $item_class = '';

        return apply_filters('lae_vimeo_grid_item_classes', $item_class, $item, $settings);

    }

    protected function get_block_items_to_display() {

        // return all posts since the query itself returns a subset of results based on posts_per_page parameter
        return apply_filters('lae_vimeo_display_items', $this->block_items, $this->settings);

    }


}