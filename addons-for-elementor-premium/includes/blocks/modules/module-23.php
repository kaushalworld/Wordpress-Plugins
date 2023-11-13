<?php

namespace LivemeshAddons\Modules;

class LAE_Module_23 extends LAE_Module {

    function render() {

        $source = $this->source;

        $settings = $source->settings;

        ob_start();
        ?>

        <div class="lae-module-23 <?php echo $this->get_module_classes(); ?>">

            <div class="lae-module-image">

                <?php echo $source->get_media(); ?>

                <?php echo $source->get_lightbox(); ?>

                <div class="lae-module-image-info">

                    <div class="lae-module-entry-info">

                        <?php echo $source->get_likes_or_views(); ?>

                        <?php echo $source->get_comments_number(); ?>

                    </div>

                </div>

            </div>

        </div><!-- .gallery-item -->

        <?php $output = ob_get_clean();

        return apply_filters('lae_block_module_23', $output, $source);
    }
}