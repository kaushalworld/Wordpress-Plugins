<?php

namespace LivemeshAddons\Blocks;

abstract class LAE_Gallery_Block extends LAE_Block {

    protected $max_num_pages;

    public function init_block() {

        $this->block_items = $this->get_block_items();

        $this->setup_pagination();

        $block_filter_terms = $this->get_block_filter_terms();

        $block_header_args = array(
            'settings' => $this->settings,
            'block_uid' => $this->block_uid,
            'block_filter_terms' => $block_filter_terms
        );

        $block_header_class = '\LivemeshAddons\Blocks\Headers\\' . LAE_Blocks_Manager::get_class_name($this->settings['header_template']);

        $this->block_header_obj = new $block_header_class($block_header_args);
    }

    public function get_block_items() {

        if ($this->settings['bulk_upload'] == 'yes') {

            $items = array();

            $images = $this->settings['gallery_images'];

            foreach ($images as $image) {

                $item_image = array('id' => $image['id'], 'url' => $image['url']);

                $attachment = get_post($image['id']);

                $image_title = $attachment->post_title;

                $image_description = $attachment->post_excerpt;

                $item_tags = get_post_meta($image['id'], 'lae_gallery_item_tags', true);

                $item = array('item_type' => 'image', 'item_image' => $item_image, 'item_name' => $image_title, 'item_tags' => $item_tags, 'item_link' => '', 'item_description' => $image_description);

                $items[] = $item;
            }

            $block_items = apply_filters('lae_gallery_media_gallery_items', $items, $images, $this->settings);

            unset($this->settings['gallery_images']); // exclude items from settings
        }
        else {

            $block_items = $this->settings['gallery_items'];

            $block_items = lae_parse_gallery_block_items($block_items);

            unset($this->settings['gallery_items']); // exclude items from settings

        }

        return $block_items;
    }

    public function get_block_header() {

        $output = $this->block_header_obj->get_block_header();

        return apply_filters('lae_' . $this->settings['header_template'] . '_output', $output, $this->block_header_obj);

    }

    public function get_block_footer() {

        $output = $this->get_block_pagination();

        return apply_filters('lae_gallery_block_footer_output', $output);
    }

    // get atts
    protected function get_block_data_atts() {

        $output = '';

        $output .= " data-block-uid='" . $this->block_uid . "'";

        $output .= " data-action='lae_load_gallery_block'";

        $output .= " data-items='" . (($this->settings['pagination'] !== 'none') ? json_encode($this->block_items, JSON_HEX_APOS) : '') . "'";

        $output .= " data-settings='" . wp_json_encode($this->get_settings_data_atts()) . "'";

        $output .= " data-total='" . count($this->block_items) . "'";

        $output .= " data-current='1'";

        $output .= " data-maxpages='" . $this->max_num_pages . "'";

        // will be populated later when filter links are clicked by user
        $output .= " data-filter-term=''";
        $output .= " data-filter-taxonomy=''";

        return apply_filters('lae_gallery_block_data_attributes', $output, $this);

    }

    protected function get_settings_defaults() {

        return array(
            'class' => '',
            'heading' => '',
            'heading_url' => '',
            'block_type' => 'block_1',
            'filterable' => true,
            'current_filter_term' => '',
            'pagination' => 'none',
            'show_remaining' => true,
        );

    }

    protected function get_settings_data_atts() {

        $data_atts = array();

        /* Block Content */
        $data_atts['block_class'] = $this->settings['block_class'];

        $data_atts['heading'] = $this->settings['heading'];

        $data_atts['heading_url'] = $this->settings['heading_url'];

        $data_atts['header_template'] = $this->settings['header_template'];

        $data_atts['block_type'] = $this->settings['block_type'];

        /* Gallery Item Content */

        $data_atts['display_item_title'] = $this->settings['display_item_title'];

        $data_atts['display_item_tags'] = $this->settings['display_item_tags'];

        $data_atts['display_description'] = $this->settings['display_description'];

        $data_atts['bulk_upload'] = $this->settings['bulk_upload'];

        $data_atts['filterable'] = $this->settings['filterable'];

        $data_atts['per_line'] = $this->settings['per_line'];

        $data_atts['per_line_tablet'] = $this->settings['per_line_tablet'];

        $data_atts['per_line_mobile'] = $this->settings['per_line_mobile'];

        $data_atts['layout_mode'] = $this->settings['layout_mode'];

        $data_atts['thumbnail_size_size'] = $this->settings['thumbnail_size_size'];

        $data_atts['thumbnail_size_custom_dimension'] = $this->settings['thumbnail_size_custom_dimension'];

        $data_atts['enable_lightbox'] = $this->settings['enable_lightbox'];

        $data_atts['lightbox_library'] = $this->settings['lightbox_library'];

        $data_atts['pagination'] = $this->settings['pagination'];

        $data_atts['show_remaining'] = $this->settings['show_remaining'];

        $data_atts['items_per_page'] = $this->settings['items_per_page'];

        /* Gallery Customization */

        $data_atts['heading_tag'] = $this->settings['heading_tag'];

        $data_atts['item_title_tag'] = $this->settings['item_title_tag'];

        $data_atts['entry_title_tag'] = $this->settings['entry_title_tag'];

        return apply_filters('lae_gallery_block_settings_data_attributes', $data_atts, $this->settings);

    }

    protected function get_block_filter_terms() {

        $tags = $terms = array();

        foreach ($this->block_items as $item) {
                if (!empty($item['item_tags']))
                $tags = array_merge($tags, explode(',', $item['item_tags']));
        }

        // trim whitespaces before applying array_unique
        $tags = array_map('trim', $tags);

        $tags = array_values(array_unique($tags));

        if ($this->settings['filterable']) {

            foreach ($tags as $tag) {

                $term = array();

                $term['term_id'] = preg_replace('/\s+/', '-', $tag); // use the unique tag name itself as an id

                $term['name'] = $tag;

                $term['taxonomy'] = 'gallery_tag';

                $terms[] = (object)$term;
            }
        }

        return apply_filters('lae_gallery_block_filter_terms', $terms, $this);

    }


    protected function get_block_pagination() {

        $pagination_type = $this->settings['pagination'];

        // no pagination required if option is not chosen by user or if all posts are already displayed
        if ($pagination_type == 'none' || count($this->block_items) <= $this->settings['items_per_page'])
            return;

        // no pagination required if option is not chosen by user or if all posts are already displayed
        if ($pagination_type == 'none' || $this->max_num_pages == 1)
            return;


        $output = '<div class="lae-pagination ' . 'lae-' . preg_replace('/_/', '-', $pagination_type) . '-nav">';

        switch ($pagination_type) {

            case 'next_prev':

                $output .= '<a class="lae-page-nav lae-disabled" href="#" data-page="prev"><i class="lae-icon-arrow-left3"></i></a>';

                $output .= '<a class="lae-page-nav" href="#" data-page="next"><i class="lae-icon-arrow-right3"></i></a>';

                break;

            case 'load_more':
            case 'infinite_scroll':

                $output .= '<a href="#" class="lae-load-more lae-button">';

                $output .= __('Load More', 'livemesh-el-addons');

                if ($this->settings['show_remaining'])
                    $output .= ' - ' . '<span>' . (count($this->block_items) - $this->settings['items_per_page']) . '</span>';

                $output .= '</a>';

                break;

            case 'paged':

                $page_links = array();

                for ($n = 1; $n <= $this->max_num_pages; $n++) :
                    $page_links[] = '<a class="lae-page-nav lae-numbered' . ($n == 1 ? ' lae-current-page' : '') . '" href="#" data-page="' . $n . '">' . number_format_i18n($n) . '</a>';
                endfor;

                $r = join("\n", $page_links);

                if (!empty($page_links)) {
                    $prev_link = '<a class="lae-page-nav lae-disabled" href="#" data-page="prev"><i class="lae-icon-arrow-left3"></i></a>';
                    $next_link = '<a class="lae-page-nav" href="#" data-page="next"><i class="lae-icon-arrow-right3"></i></a>';

                    $output .= $prev_link . "\n" . $r . "\n" . $next_link;
                }

                break;
        }

        $output .= '<span class="lae-loading"></span>';

        $output .= '</div><!-- .lae-pagination -->';

        return apply_filters('lae_gallery_block_pagination', $output, $this);
    }

    protected function get_grid_classes($settings) {

        $grid_classes = 'lae-' . $settings['layout_mode'];

        $grid_classes .= $this->get_grid_classes_from_settings_field($settings, 'per_line');

        return $grid_classes;

    }

    protected function get_grid_item_classes($item, $settings) {

        $item_class = '';

        if (!empty($item['item_tags'])) {
            $terms = array_map('trim', explode(',', $item['item_tags']));

            foreach ($terms as $term) {
                // Get rid of spaces before adding the term
                $item_class .= ' term-' . preg_replace('/\s+/', '-', $term);
            }
        }

        $item_type = $item['item_type'];

        $item_class .= ' lae-' . $item_type . '-type';

        if (in_array($item_type, array('youtube', 'vimeo', 'html5video')))
            $item_class .= ' lae-video-type';

        $custom_class = get_post_meta($item['item_image']['id'], 'lae_grid_width', true);

        if ($custom_class !== '')
            $item_class .= ' ' . $custom_class;

        return apply_filters('lae_gallery_grid_item_classes', $item_class, $item, $settings);

    }

    protected function get_block_items_to_display() {

        // If pagination option is chosen, filter the items for the first page
        if ($this->settings['pagination'] !== 'none')
            $display_items = array_slice($this->block_items, 0, $this->settings['items_per_page']);
        else
            $display_items = $this->block_items;

        // return all posts since the query itself returns a subset of results based on posts_per_page parameter
        return apply_filters('lae_gallery_display_items', $display_items, $this->block_items, $this->settings);

    }

    private function setup_pagination() {

        $this->max_num_pages = 1;

        if ($this->settings['pagination'] !== 'none')
            $this->max_num_pages = ceil(count($this->block_items) / $this->settings['items_per_page']);

    }


}