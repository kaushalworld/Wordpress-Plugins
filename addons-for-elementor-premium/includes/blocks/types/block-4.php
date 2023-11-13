<?php

namespace LivemeshAddons\Blocks;

class LAE_Block_4 extends LAE_Posts_Block {

    function inner($posts, $settings) {

        $output = '';

        $post_count = 1;

        $num_of_columns = $settings['per_line2'];

        $block_layout = new LAE_Block_Layout();

        $column_class = $this->get_column_class(intval($num_of_columns));

        if (!empty($posts)) {

            foreach ($posts as $post) {

                $source = new \LivemeshAddons\Modules\Source\LAE_Posts_Source($post, $settings);

                if ($post_count == 1 || $num_of_columns == 1 || ($post_count % $num_of_columns == 1))
                    $output .= $block_layout->open_row();

                $output .= $block_layout->open_column($column_class);

                $module6 = new \LivemeshAddons\Modules\LAE_Module_3($source);

                $output .= $module6->render();

                $output .= $block_layout->close_column($column_class);

                if ($post_count % $num_of_columns == 0)
                    $output .= $block_layout->close_row();

                $post_count++;

            };

            $output .= $block_layout->close_all_tags();

        };

        return $output;

    }

    protected function get_block_class() {

        return 'lae-block-posts lae-block-4';

    }

    protected function get_grid_classes($settings) {

        return $this->get_grid_classes_from_settings_field($settings, 'per_line2');

    }
}