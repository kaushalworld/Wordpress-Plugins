<?php

namespace LivemeshAddons\Blocks;

class LAE_Block_Grid_1 extends LAE_Posts_Block {

    function inner($posts, $settings) {

        $output = '';

        $post_count = 1;

        $num_of_columns = $settings['per_line'];

        $block_layout = new LAE_Block_Layout();

        $column_class = $this->get_column_class(intval($num_of_columns));

        if (!empty($posts)) {

            foreach ($posts as $post) {

                $additional_classes = $this->get_grid_item_classes($post, $settings);

                $source = new \LivemeshAddons\Modules\Source\LAE_Posts_Source($post, $settings);

                $output .= $block_layout->open_column($column_class, $additional_classes);

                $module2 = new \LivemeshAddons\Modules\LAE_Module_11($source);

                $output .= $module2->render();

                $output .= $block_layout->close_column($column_class);

                $post_count++;

            };

            $output .= $block_layout->close_all_tags();

        };

        return $output;

    }

    protected function get_block_class() {

        return 'lae-block-grid lae-block-grid-1 lae-gapless-grid';

    }
}