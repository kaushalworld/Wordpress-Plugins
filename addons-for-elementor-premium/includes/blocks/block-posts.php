<?php

namespace LivemeshAddons\Blocks;

abstract class LAE_Posts_Block extends LAE_Block {

    protected $wp_query;

    protected $max_num_pages = 1;

    protected $found_posts = 0;

    protected $query_args = array();

    public function init_block() {

        $this->add_related_posts_params();

        $this->query_args = lae_build_query_args($this->settings);

        $this->query_args = apply_filters('lae_block_' . $this->settings['block_id'] . '_query_args', $this->query_args, $this->settings);

        $this->wp_query = new \WP_Query($this->query_args);

        $this->setup_pagination_for_offset();

        $this->block_items = $this->wp_query->posts;

        $block_filter_terms = $this->get_block_filter_terms();

        $block_header_args = array(
            'settings' => $this->settings,
            'block_uid' => $this->block_uid,
            'block_filter_terms' => $block_filter_terms
        );

        $block_header_class = '\LivemeshAddons\Blocks\Headers\\' . LAE_Blocks_Manager::get_class_name($this->settings['header_template']);

        $this->block_header_obj = new $block_header_class($block_header_args);
    }

    public function get_block_header() {

        $output = $this->block_header_obj->get_block_header();

        return apply_filters('lae_' . $this->settings['header_template'] . '_output', $output, $this->block_header_obj);

    }

    public function get_block_footer() {

        $output = $this->get_block_pagination();

        return apply_filters('lae_posts_block_footer_output', $output);
    }

    // get atts
    protected function get_block_data_atts() {

        $output = '';

        $output .= " data-block-uid='" . $this->block_uid . "'";

        $output .= " data-action='lae_load_posts_block'";

        $output .= " data-query='" . wp_json_encode($this->query_args) . "'";

        $output .= " data-settings='" . wp_json_encode($this->get_settings_data_atts()) . "'";

        $output .= " data-taxonomies='" . wp_json_encode($this->settings['taxonomies']) . "'";

        $output .= " data-total='" . $this->found_posts . "'";

        $output .= " data-current='1'";

        $output .= " data-maxpages='" . $this->max_num_pages . "'";

        // will be populated later when filter links are clicked by user
        $output .= " data-filter-term=''";
        $output .= " data-filter-taxonomy=''";

        return apply_filters('lae_block_data_attributes', $output, $this);

    }

    protected function get_settings_defaults() {

        return array(
            'class' => '',
            'heading' => '',
            'heading_url' => '',
            'block_type' => 'block_1',
            'filterable' => true,
            'taxonomy_chosen' => 'category',
            'current_filter_term' => '',
            'pagination' => 'none',
            'show_remaining' => true,
            'show_related_posts' => false,
            'current_post_id' => '',
        );

    }

    protected function get_settings_data_atts() {

        $data_atts = array();

        /* Block Content */

        $data_atts['block_class'] = $this->settings['block_class'];

        $data_atts['heading'] = $this->settings['heading'];

        $data_atts['heading_url'] = $this->settings['heading_url'];

        $data_atts['taxonomy_chosen'] = $this->settings['taxonomy_chosen'];

        $data_atts['header_template'] = $this->settings['header_template'];

        $data_atts['block_type'] = $this->settings['block_type'];

        $data_atts['grid_skin'] = $this->settings['grid_skin'];

        $data_atts['item_template'] = $this->settings['item_template'];

        $data_atts['grid_template'] = $this->settings['grid_template'];

        /* Post Content */
        $data_atts['display_title_on_thumbnail'] = $this->settings['display_title_on_thumbnail'];

        $data_atts['display_taxonomy_on_thumbnail'] = $this->settings['display_taxonomy_on_thumbnail'];

        $data_atts['display_title'] = $this->settings['display_title'];

        $data_atts['display_summary'] = $this->settings['display_summary'];

        $data_atts['rich_text_excerpt'] = $this->settings['rich_text_excerpt'];

        $data_atts['display_excerpt_lightbox'] = $this->settings['display_excerpt_lightbox'];

        $data_atts['display_read_more'] = $this->settings['display_read_more'];

        $data_atts['read_more_text'] = $this->settings['read_more_text'];

        $data_atts['display_author'] = $this->settings['display_author'];

        $data_atts['display_post_date'] = $this->settings['display_post_date'];

        $data_atts['display_comments'] = $this->settings['display_comments'];

        $data_atts['display_taxonomy'] = $this->settings['display_taxonomy'];

        $data_atts['display_product_quick_view'] = $this->settings['display_product_quick_view'];

        $data_atts['display_product_price'] = $this->settings['display_product_price'];

        $data_atts['display_add_to_cart_button'] = $this->settings['display_add_to_cart_button'];

        $data_atts['display_wish_list_button'] = $this->settings['display_wish_list_button'];

        $data_atts['display_product_rating'] = $this->settings['display_product_rating'];

        /* Block Settings */

        $data_atts['thumbnail_size_size'] = $this->settings['thumbnail_size_size'];

        $data_atts['thumbnail_size_custom_dimension'] = $this->settings['thumbnail_size_custom_dimension'];

        $data_atts['filterable'] = $this->settings['filterable'];

        $data_atts['layout_mode'] = $this->settings['layout_mode'];

        $data_atts['per_line'] = $this->settings['per_line'];

        $data_atts['per_line_tablet'] = $this->settings['per_line_tablet'];

        $data_atts['per_line_mobile'] = $this->settings['per_line_mobile'];

        $data_atts['per_line1'] = $this->settings['per_line1'];

        $data_atts['per_line2'] = $this->settings['per_line2'];

        $data_atts['per_line2_tablet'] = $this->settings['per_line2_tablet'];

        $data_atts['per_line2_mobile'] = $this->settings['per_line2_mobile'];

        $data_atts['image_linkable'] = $this->settings['image_linkable'];

        $data_atts['post_link_new_window'] = $this->settings['post_link_new_window'];

        $data_atts['excerpt_length'] = $this->settings['excerpt_length'];

        $data_atts['enable_lightbox'] = $this->settings['enable_lightbox'];

        /* Pagination */

        $data_atts['pagination'] = $this->settings['pagination'];

        $data_atts['show_remaining'] = $this->settings['show_remaining'];

        /* Block Customization */

        $data_atts['heading_tag'] = $this->settings['heading_tag'];

        $data_atts['title_tag'] = $this->settings['title_tag'];

        $data_atts['entry_title_tag'] = $this->settings['entry_title_tag'];

        /* Derived Attributes */

        $data_atts['taxonomies'] = $this->settings['taxonomies'];

        return apply_filters('lae_block_settings_data_attributes', $data_atts, $this->settings);

    }

    private function add_related_posts_params() {

        if (!empty($this->settings['show_related_posts'])) {

            $this->settings['current_post_id'] = get_queried_object_id();

        }
    }

    private function setup_pagination_for_offset() {

        $offset = isset($this->settings['offset']) ? intval($this->settings['offset']) : 0;

        if ($offset !== 0) {
            $this->found_posts = $this->wp_query->found_posts - $offset;
            $this->max_num_pages = ceil($this->found_posts / $this->query_args['posts_per_page']);
        }
        else {
            $this->found_posts = $this->wp_query->found_posts;
            $this->max_num_pages = $this->wp_query->max_num_pages;
        }

    }

    protected function get_block_filter_terms() {

        $block_filter_terms = array();

        // Check if any taxonomy filter has been applied
        list($chosen_terms, $taxonomies) = lae_get_chosen_terms($this->query_args);

        if (empty($chosen_terms))
            $taxonomies[] = $this->settings['taxonomy_chosen'];

        $this->settings['taxonomies'] = $taxonomies;

        if ($this->settings['filterable']) {

            if (empty($chosen_terms)) {

                global $wp_version;

                if (version_compare($wp_version, '4.5', '>=')) {
                    $terms = get_terms($taxonomies);
                }
                else {
                    $terms = get_terms($taxonomies[0]);
                }
            }
            else {
                $terms = $chosen_terms;
            }

            if (!empty($terms) && !is_wp_error($terms)) {
                $block_filter_terms = $terms;
            }
        }

        return apply_filters('lae_block_filter_terms', $block_filter_terms, $this);

    }


    public function get_block_pagination() {

        $pagination_type = $this->settings['pagination'];

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
                    $output .= ' - ' . '<span>' . (intval($this->found_posts) - $this->query_args['posts_per_page']) . '</span>';

                $output .= '</a>';

                break;

            case 'paged':

                $page_links = array();

                $current = (get_query_var('paged')) ? get_query_var('paged') : 1;

                for ($n = 1; $n <= $this->max_num_pages; $n++) :
                    $page_links[] = '<a class="lae-page-nav lae-numbered' . ($n == $current ? ' lae-current-page' : '') . '" href="#" data-page="' . $n . '">' . number_format_i18n($n) . '</a>';
                endfor;

                $r = join("\n", $page_links);

                if (!empty($page_links)) {
                    $prev_link = '<a class="lae-page-nav' . ($current == 1 ? ' lae-disabled' : '') . '" href="#" data-page="prev"><i class="lae-icon-arrow-left3"></i></a>';
                    $next_link = '<a class="lae-page-nav' . ($current == $this->max_num_pages ? ' lae-disabled' : '') . '" href="#" data-page="next"><i class="lae-icon-arrow-right3"></i></a>';

                    $output .= $prev_link . "\n" . $r . "\n" . $next_link;
                }

                break;
        }

        $output .= '<span class="lae-loading"></span>';

        $output .= '</div><!-- .lae-pagination -->';

        return apply_filters('lae_block_pagination', $output, $this);
    }

    protected function get_grid_item_classes($post, $settings) {

        $item_class = '';

        $taxonomies = $settings['taxonomies'];

        foreach ($taxonomies as $taxonomy) {

            $terms = get_the_terms($post->ID, $taxonomy);

            if (!empty($terms) && !is_wp_error($terms)) {

                foreach ($terms as $term) {
                    $item_class .= ' term-' . $term->term_id;
                }
            }
        }

        $custom_class = get_post_meta($post->ID, 'lae_grid_width', true);

        if ($custom_class !== '')
            $item_class .= ' ' . $custom_class;

        return apply_filters('lae_post_grid_item_classes', $item_class, $post, $settings);

    }

    protected function get_block_items_to_display() {

        // return all posts since the query itself returns a subset of results based on posts_per_page parameter
        return apply_filters('lae_post_grid_display_items', $this->block_items, $this->settings);

    }


}