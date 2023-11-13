<?php

namespace LivemeshAddons\Blocks;

use LivemeshAddons\Blocks\Clients\LAE_Instagram_Client;

abstract class LAE_Instagram_Block extends LAE_Block {

    protected $instagram_client;

    public function init_block() {

        $this->instagram_client = new LAE_Instagram_Client($this->settings);

        $this->block_items = $this->get_block_items();

        $block_header_args = array(
            'settings' => $this->settings,
            'block_uid' => $this->block_uid,
            'social_api_client' => $this->instagram_client
        );

        $block_header_class = '\LivemeshAddons\Blocks\Headers\\' . LAE_Blocks_Manager::get_class_name($this->settings['header_template']);

        $this->block_header_obj = new $block_header_class($block_header_args);
    }

    public function get_block_items() {

        $block_items = $this->instagram_client->get_grid_items();

        return $block_items;
    }

    public function get_block_header() {

        $output = $this->block_header_obj->get_block_header();

        return apply_filters('lae_instagram_block_header_output', $output);

    }

    public function get_block_footer() {

        $output = '';

        return apply_filters('lae_instagram_block_footer_output', $output);
    }

    // get atts
    protected function get_block_data_atts() {

        $output = '';

        $output .= " data-block-uid='" . $this->block_uid . "'";

        $output .= " data-action='lae_load_instagram_block'";

        $output .= " data-settings='" . wp_json_encode($this->get_settings_data_atts()) . "'";
        
        $output .= " data-current='1'";

        return apply_filters('lae_instagram_block_data_attributes', $output, $this);

    }

    protected function get_settings_defaults() {

        return array(
            'class' => '',
            'block_type' => 'block_1',
            'pagination' => 'none',
            'ajax_data' => ''
        );

    }

    protected function get_settings_data_atts() {

        $data_atts = array();

        /* Block Content */
        $data_atts['block_class'] = $this->settings['block_class'];

        $data_atts['block_type'] = $this->settings['block_type'];

        $data_atts['block_id'] = $this->settings['block_id'];

        /* Instagram Item Content */

        $data_atts['instagram_usernames'] = $this->settings['instagram_usernames'];

        $data_atts['instagram_hashtags'] = $this->settings['instagram_hashtags'];

        $data_atts['display_header'] = $this->settings['display_header'];

        $data_atts['display_avatar'] = $this->settings['display_avatar'];

        $data_atts['display_username'] = $this->settings['display_username'];

        $data_atts['display_name'] = $this->settings['display_name'];

        $data_atts['display_date'] = $this->settings['display_date'];

        $data_atts['date_format'] = $this->settings['date_format'];

        $data_atts['display_comments'] = $this->settings['display_comments'];

        $data_atts['display_likes'] = $this->settings['display_likes'];

        $data_atts['display_read_more'] = $this->settings['display_read_more'];

        $data_atts['read_more_text'] = $this->settings['read_more_text'];

        $data_atts['display_excerpt'] = $this->settings['display_excerpt'];

        $data_atts['excerpt_length'] = $this->settings['excerpt_length'];

        $data_atts['image_linkable'] = $this->settings['image_linkable'];

        $data_atts['post_link_new_window'] = $this->settings['post_link_new_window'];

        $data_atts['per_line'] = $this->settings['per_line'];

        $data_atts['per_line_tablet'] = $this->settings['per_line_tablet'];

        $data_atts['per_line_mobile'] = $this->settings['per_line_mobile'];

        $data_atts['layout_mode'] = $this->settings['layout_mode'];

        $data_atts['enable_lightbox'] = $this->settings['enable_lightbox'];

        $data_atts['lightbox_library'] = $this->settings['lightbox_library'];

        $data_atts['items_per_page'] = $this->settings['items_per_page'];

        return apply_filters('lae_instagram_block_settings_data_attributes', $data_atts, $this->settings);

    }

    protected function get_grid_classes($settings) {

        $grid_classes = 'lae-' . $settings['layout_mode'];

        $grid_classes .= $this->get_grid_classes_from_settings_field($settings, 'per_line');

        return $grid_classes;

    }

    protected function get_grid_item_classes($item, $settings) {

        $item_class = '';

        return apply_filters('lae_instagram_grid_item_classes', $item_class, $item, $settings);

    }

    protected function get_block_items_to_display() {

        // return all posts since the query itself returns a subset of results based on posts_per_page parameter
        return apply_filters('lae_instagram_display_items', $this->block_items, $this->settings);

    }


}