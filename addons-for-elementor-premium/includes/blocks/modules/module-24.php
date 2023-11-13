<?php

namespace LivemeshAddons\Modules;

class LAE_Module_24 extends LAE_Module {

    function render() {

        $source = $this->source;

        $settings = $source->settings;

        ob_start();
        ?>

        <div class="lae-module-24 <?php echo $this->get_module_classes(); ?>">
            
            <div class="lae-module-image">

                <?php echo $source->get_media(); ?>

                <?php echo $source->get_lightbox(); ?>

            </div>

            <div class="lae-module-entry-details">

                <div class="lae-module-meta">

                    <?php echo $source->get_author(); ?>

                    <?php echo $source->get_date(); ?>

                </div>

                <div class="lae-module-entry-text">

                    <?php echo $source->get_excerpt(); ?>

                </div>

                <div class="lae-module-details">

                    <?php echo $source->get_likes_or_views(); ?>

                    <?php echo $source->get_comments_number(); ?>

                    <?php echo $source->get_read_more_link(); ?>

                </div>

            </div>

        </div><!-- .gallery-item -->

        <?php $output = ob_get_clean();

        return apply_filters('lae_block_module_24', $output, $source);
    }
}