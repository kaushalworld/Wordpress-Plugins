<?php

namespace LivemeshAddons\Modules;

class LAE_Module_12 extends LAE_Module {

    function render() {

        $source = $this->source;

        ob_start();
        ?>

        <article
                class="lae-module-12 <?php echo $this->get_module_classes(); ?> <?php echo join(' ', get_post_class('', $source->post_ID)); ?>">

            <?php if ($thumbnail_exists = has_post_thumbnail($source->post_ID)): ?>

                <div class="lae-module-image">

                    <?php echo $source->get_media(); ?>

                    <?php echo $source->get_lightbox(); ?>

                    <div class="lae-module-image-info">

                        <div class="lae-module-entry-info">

                            <?php echo $source->get_title(); ?>

                            <?php echo $source->get_taxonomies_info(); ?>

                        </div>

                    </div>

                </div>

            <?php endif; ?>

        </article><!-- .hentry -->

        <?php $output = ob_get_clean();

        return apply_filters('lae_block_module_12', $output, $source);
    }
}