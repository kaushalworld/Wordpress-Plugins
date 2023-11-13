<?php

namespace LivemeshAddons\Blocks;

abstract class LAE_Block {

    protected $block_uid;

    public $block_header_obj;

    public $block_items;

    public $settings = array();

    /* Force override  */
    abstract function inner($block_items, $settings);

    abstract function get_block_header();

    abstract function get_block_footer();

    abstract function init_block();

    /* Force override  */
    protected abstract function get_block_class();

    protected abstract function get_settings_defaults();

    protected abstract function get_settings_data_atts();

    protected abstract function get_block_items_to_display();

    public function init($settings) {

        $this->block_items = array();

        $defaults = $this->get_settings_defaults();

        $this->settings = wp_parse_args($settings, $defaults);

        $this->block_uid = 'lae-block-uid-' . uniqid();

        $this->add_class($this->block_uid);

        $this->init_block();

    }

    public function render($settings) {

        try {

            $this->init($settings);

            $dir = is_rtl() ? ' dir="rtl"' : '';

            $output = '<div' . $dir . ' id="' . $this->block_uid . '" class="' . $this->get_block_classes() . '" ' . $this->get_block_data_atts() . '>';

            $output .= $this->get_block_header();

            $grid_classes = $this->get_grid_classes($settings);

            $grid_classes = apply_filters('lae_' . $settings['block_type'] . '_grid_classes', $grid_classes, $settings);

            $display_items = $this->get_block_items_to_display();

            // add container class to enable column styling
            $output .= '<div class="lae-block-inner lae-grid-container ' . $grid_classes . '">';

            $block_output = $this->inner($display_items, $this->settings);

            $output .= apply_filters('lae_' . $this->settings['block_type'] . '_inner_output', $block_output, $this);

            $output .= '</div><!-- .block-inner -->';

            $output .= $this->get_block_footer();

            $output .= '</div><!-- .block -->';

        } catch (\Exception $e) {

            // show error message if thrown - applicable for social grids
            $output = $e->getMessage();

        }

        return apply_filters('lae_' . $this->settings['block_type'] . '_output', $output, $this);

    }

    private function add_class($class_name) {

        if (!empty($this->settings['block_class'])) {

            $this->settings['class'] = $this->settings['block_class'] . ' ' . $class_name;
        }
        else {
            $this->settings['class'] = $class_name;
        }
    }

    protected function get_column_class($column_size = 3) {

        // Ignore column size since grid class will determine the column size
        $style_class = 'lae-grid-item';

        return apply_filters('lae_block_column_class', $style_class, $column_size, $this->settings);
    }

    protected function get_grid_classes_from_settings_field($settings, $columns_field) {

        return lae_get_grid_classes($settings, $columns_field);

    }

    protected function get_block_classes($classes_array = array()) {

        $block_classes = array();

        // add container class to enable column styling
        $block_classes[] = 'lae-container';

        // add block wrap
        $block_classes[] = 'lae-block';

        // add block id for styling
        $block_classes[] = apply_filters('lae_' . $this->settings['block_type'] . '_class', $this->get_block_class(), $this);

        // add block header type for styling
        if ($this->block_header_obj)
            $block_classes[] = apply_filters('lae_' . $this->settings['header_template'] . '_class', $this->block_header_obj->get_block_header_class(), $this->block_header_obj);

        //add the classes that we receive via settings and those which are set based on block id
        $class = $this->settings['class'];
        if (!empty($class)) {
            $class_array = explode(' ', $class);
            $block_classes = array_merge(
                $block_classes,
                $class_array
            );
        }

        //marge the additional classes received from blocks code
        if (!empty($classes_array)) {
            $block_classes = array_merge(
                $block_classes,
                $classes_array
            );
        }

        //remove duplicates
        $block_classes = array_unique($block_classes);

        $block_classes = apply_filters('lae_block_classes', $block_classes, $this);

        return implode(' ', $block_classes);
    }

    protected function get_grid_classes($settings) {

        return $this->get_grid_classes_from_settings_field($settings, 'per_line');

    }


}