<?php

namespace LivemeshAddons\Modules;

class LAE_Module_5 extends LAE_Module {

    function render() {

        $source = $this->source;

        ob_start();
        ?>

        <article
                class="lae-module-5 <?php echo $this->get_module_classes(); ?> <?php echo join(' ', get_post_class('', $source->post_ID)); ?>">

            <div class="lae-entry-details">

                <?php echo $source->get_title(); ?>

                <div class="lae-module-meta">

                    <?php echo $source->get_author(); ?>

                    <?php echo $source->get_date(); ?>

                    <?php echo $source->get_comments(); ?>

                    <?php echo $source->get_taxonomies_info(); ?>

                </div>

                <div class="lae-excerpt">

                    <?php echo $source->get_excerpt(); ?>

                </div>

                <?php echo $source->get_read_more_link(); ?>

            </div>

        </article>

        <?php $output = ob_get_clean();

        return apply_filters('lae_block_module_5', $output, $source);
    }
}