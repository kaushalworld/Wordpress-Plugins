<?php

namespace LivemeshAddons\Blocks;

class LAE_Block_Custom_Grid_2 extends LAE_Posts_Block {

    protected function get_grid_template_content($template_id, $settings) {

        /* Initialize the theme builder templates - Requires elementor pro plugin */
        if (!is_plugin_active('elementor-pro/elementor-pro.php')) {
            $output = lae_template_error(__('Custom skin requires Elementor Pro but the plugin is not installed/active', 'livemesh-el-addons'));
        }
        else {
            $output = lae_get_template_content($template_id, $settings);
        }

        return $output;

    }

    protected function get_item_templates($shortcode_pattern, $grid_template_content) {

        $matches = array();

        preg_match_all($shortcode_pattern, $grid_template_content, $matches);

        $attributes = array_pop($matches); // fetch last array element

        $item_templates = array();

        foreach ($attributes as $attribute) {

            list($key, $val) = explode("=", $attribute);

            $item_templates[] = trim($val, '"');

        }
        return $item_templates;
    }

    function inner($posts, $settings) {

        $output = '';

        $grid_template_id = $settings['grid_template'];

        if (!$grid_template_id) :

            $output .= lae_template_error(__('Choose a custom template for the grid', 'livemesh-el-addons'));

        elseif (empty($posts)) :

            $output .= __('No posts found. Refine your query.', 'livemesh-el-addons');

        else :

            $shortcode_pattern = "/\[livemesh_grid_item (.+?)\]/";

            $grid_template_content = $this->get_grid_template_content($grid_template_id, $settings);

            $item_templates = $this->get_item_templates($shortcode_pattern, $grid_template_content);

            $item_template_walker = array();

            $template_output = '';

            foreach ($posts as $post) :

                $source = new \LivemeshAddons\Modules\Source\LAE_Posts_Source($post, $settings);

                if (empty($item_template_walker)) {
                    $template_output .= $grid_template_content;

                    $item_template_walker = $item_templates;

                }

                $item_template_id = array_shift($item_template_walker);

                $item_template_content = $source->get_item_template_content($item_template_id, $settings);

                // Replace the first element with the grid template content for the item
                $template_output = preg_replace($shortcode_pattern, $item_template_content, $template_output, 1);

            endforeach;

            // Replace the remaining shortcode occurrences in the grid template content with a placeholder string
            $template_output = preg_replace($shortcode_pattern, '', $template_output);

            $output .= apply_filters('lae_posts_block_template_output', $template_output, $posts, $settings);

        endif;

        return $output;

    }

    protected function get_block_class() {

        return 'lae-block-grid lae-block-custom-grid lae-gapless-grid';

    }

    /* Do not add column classes */
    protected function get_grid_classes($settings) {

        return '';

    }
}