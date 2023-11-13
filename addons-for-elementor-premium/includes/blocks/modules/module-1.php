<?php

namespace LivemeshAddons\Modules;

class LAE_Module_1 extends LAE_Module {

    function render() {
        
        $source = $this->source;
        
        ob_start();
        ?>

        <article
                class="lae-module-1 <?php echo $this->get_module_classes(); ?> <?php echo join(' ', get_post_class('', $source->post_ID)); ?>">

            <div class="lae-module-image">

                <?php echo $source->get_media(); ?>

                <?php echo $source->get_lightbox(); ?>

                <?php echo $source->get_taxonomies_info(); ?>

            </div>

            <?php echo $source->get_title();?>

            <div class="lae-module-meta">

                <?php echo $source->get_author();?>

                <?php echo $source->get_date();?>

                <?php echo $source->get_comments();?>

            </div>

            <div class="lae-excerpt">

                <?php echo $source->get_excerpt();?>

            </div>

            <?php echo $source->get_read_more_link(); ?>

        </article>

        <?php $output = ob_get_clean();

        return apply_filters('lae_block_module_1', $output, $source);
    }
}