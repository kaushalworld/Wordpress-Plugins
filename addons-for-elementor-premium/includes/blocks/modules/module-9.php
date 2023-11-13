<?php

namespace LivemeshAddons\Modules;

class LAE_Module_9 extends LAE_Module {

    function render() {

        $source = $this->source;

        ob_start();
        ?>

        <article
                class="lae-module-9 lae-module-trans1 <?php echo $this->get_module_classes(); ?> <?php echo join(' ', get_post_class('', $source->post_ID)); ?>">

            <div class="lae-module-image">

                <?php echo $source->get_media(); ?>

                <?php echo $source->get_lightbox(); ?>

            </div>

            <div class="lae-entry-details">

                <?php echo $source->get_title();?>

                <div class="lae-module-meta">

                    <?php echo $source->get_author(); ?>

                    <?php echo $source->get_date(); ?>

                    <?php echo $source->get_comments(); ?>

                    <?php echo $source->get_taxonomies_info(); ?>

                </div>

            </div>

        </article>

        <?php $output = ob_get_clean();

        return apply_filters('lae_block_module_9', $output, $source);
    }
}