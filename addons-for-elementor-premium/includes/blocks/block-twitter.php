<?php

namespace LivemeshAddons\Blocks;

use LivemeshAddons\Blocks\Clients\LAE_Twitter_Client;

abstract class LAE_Twitter_Block extends LAE_Block {

    protected $twitter_client;

    public function init_block() {

        $this->twitter_client = new LAE_Twitter_Client($this->settings);

        $this->block_items = $this->get_block_items();
    }

    public function get_block_items() {

        $block_items = $this->twitter_client->get_grid_items();

        return $block_items;
    }

    public function get_block_header() {

        $output = '';

        return apply_filters('lae_twitter_block_header_output', $output);

    }

    public function get_block_footer() {

        $output = $this->get_block_pagination();

        return apply_filters('lae_twitter_block_footer_output', $output);
    }

    // get atts
    protected function get_block_data_atts() {

        $output = '';

        $output .= " data-block-uid='" . $this->block_uid . "'";

        $output .= " data-action='lae_load_twitter_block'";

        $output .= " data-settings='" . wp_json_encode($this->get_settings_data_atts()) . "'";

        // store max id for twitter posts for load more function
        $output .= " data-max-id='" . $this->twitter_client->get_max_id() . "'";

        $output .= " data-current='1'";

        return apply_filters('lae_twitter_block_data_attributes', $output, $this);

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

        /* Twitter Item Content */

        $data_atts['twitter_source'] = $this->settings['twitter_source'];

        $data_atts['twitter_include'] = $this->settings['twitter_include'];

        $data_atts['twitter_username'] = $this->settings['twitter_username'];

        $data_atts['twitter_listname'] = $this->settings['twitter_listname'];

        $data_atts['twitter_searchkey'] = $this->settings['twitter_searchkey'];

        $data_atts['display_avatar'] = $this->settings['display_avatar'];

        $data_atts['display_username'] = $this->settings['display_username'];

        $data_atts['display_name'] = $this->settings['display_name'];

        $data_atts['display_date'] = $this->settings['display_date'];

        $data_atts['date_format'] = $this->settings['date_format'];

        $data_atts['display_comments'] = $this->settings['display_comments'];

        $data_atts['display_retweets'] = $this->settings['display_retweets'];

        $data_atts['display_likes'] = $this->settings['display_likes'];

        $data_atts['display_read_more'] = $this->settings['display_read_more'];

        $data_atts['read_more_text'] = $this->settings['read_more_text'];

        $data_atts['per_line'] = $this->settings['per_line'];

        $data_atts['per_line_tablet'] = $this->settings['per_line_tablet'];

        $data_atts['per_line_mobile'] = $this->settings['per_line_mobile'];

        $data_atts['layout_mode'] = $this->settings['layout_mode'];

        $data_atts['enable_lightbox'] = $this->settings['enable_lightbox'];

        $data_atts['lightbox_library'] = $this->settings['lightbox_library'];

        $data_atts['pagination'] = $this->settings['pagination'];

        $data_atts['items_per_page'] = $this->settings['items_per_page'];

        return apply_filters('lae_twitter_block_settings_data_attributes', $data_atts, $this->settings);

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

        return apply_filters('lae_twitter_block_pagination', $output, $this);
    }

    protected function get_grid_classes($settings) {

        $grid_classes = 'lae-' . $settings['layout_mode'];

        $grid_classes .= $this->get_grid_classes_from_settings_field($settings, 'per_line');

        return $grid_classes;

    }

    protected function get_grid_item_classes($item, $settings) {

        $item_class = '';

        return apply_filters('lae_twitter_grid_item_classes', $item_class, $item, $settings);

    }

    protected function get_block_items_to_display() {

        // return all posts since the query itself returns a subset of results based on posts_per_page parameter
        return apply_filters('lae_twitter_display_items', $this->block_items, $this->settings);

    }


}