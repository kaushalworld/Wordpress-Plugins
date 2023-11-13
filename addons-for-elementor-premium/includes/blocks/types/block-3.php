<?php

namespace LivemeshAddons\Blocks;

class LAE_Block_3 extends LAE_Posts_Block {

    function inner($posts, $settings) {

        $output = '';

        $post_count = 1;

        $num_of_columns = $settings['per_line1'];

        $block_layout = new LAE_Block_Layout();

        $column_class = $this->get_column_class(intval($num_of_columns));

        if (!empty($posts)) {

            foreach ($posts as $post) {

                $source = new \LivemeshAddons\Modules\Source\LAE_Posts_Source($post, $settings);

                // big posts for posts
                if ($post_count <= 1) {

                    $output .= $block_layout->open_row();

                    $output .= $block_layout->open_column($column_class);

                    $module2 = new \LivemeshAddons\Modules\LAE_Module_1($source);

                    $output .= $module2->render();

                    $output .= $block_layout->close_column($column_class);

                }
                else {

                    $output .= $block_layout->open_column($column_class);

                    $module6 = new \LivemeshAddons\Modules\LAE_Module_3($source);

                    $output .= $module6->render();
                }

                // Help start a 3rd column for 5th post onwards when in 3 column mode
                if ($num_of_columns == 3 && $post_count == 5)
                    $output .= $block_layout->close_column($column_class);

                $post_count++;

            };

            $output .= $block_layout->close_all_tags();

        };

        return $output;

    }

    protected function get_block_class() {

        return 'lae-block-posts lae-block-3';

    }

    protected function get_grid_classes($settings) {

        $grid_classes = ' lae-grid-desktop-' . $settings['per_line1'];

        $grid_classes .= ' lae-grid-tablet-2';

        $grid_classes .= ' lae-grid-mobile-1';

        return $grid_classes;

    }
}