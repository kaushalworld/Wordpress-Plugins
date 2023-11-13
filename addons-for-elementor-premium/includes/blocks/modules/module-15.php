<?php

namespace LivemeshAddons\Modules;

class LAE_Module_15 extends LAE_Module {

    function render() {

        $source = $this->source;

        ob_start();
        ?>

        <div class="lae-module-15 <?php echo $this->get_module_classes(); ?>">

            <?php if ($source->is_inline_video()): ?>

                <div class="lae-module-video">

                    <?php echo $source->get_inline_video(); ?>

                </div>

            <?php else: ?>

                <div class="lae-module-image">

                    <?php echo $source->get_media(); ?>

                    <?php echo $source->get_lightbox(); ?>

                    <?php echo $source->get_video_lightbox(); ?>

                    <?php echo $source->get_taxonomies_info(); ?>

                </div>

            <?php endif; ?>

            <div class="lae-module-entry-text">

                <?php echo $source->get_title(); ?>

                <div class="lae-excerpt">
                    <?php echo $source->get_excerpt(); ?>
                </div>

            </div>

        </div><!-- .gallery-item -->

        <?php $output = ob_get_clean();

        return apply_filters('lae_block_module_15', $output, $source);
    }
}