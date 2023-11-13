<?php

namespace LivemeshAddons\Modules;

class LAE_Module_17 extends LAE_Module {

    function render() {

        $source = $this->source;

        ob_start();
        ?>

        <div class="lae-module-17 <?php echo $this->get_module_classes(); ?>">

            <div class="lae-module-meta">

                <?php echo $source->get_author(); ?>

                <?php echo $source->get_date(); ?>

            </div>

            <?php if ($thumbnail_exists = $source->has_post_thumbnail()): ?>

                <div class="lae-module-image">

                    <?php echo $source->get_media(); ?>

                    <?php echo $source->get_lightbox(); ?>

                </div>

            <?php endif; ?>

            <?php echo $source->get_excerpt(); ?>

            <div class="lae-module-details">

                <?php echo $source->get_retweets(); ?>

                <?php echo $source->get_likes(); ?>

                <?php echo $source->get_read_more_link(); ?>

            </div>

        </div><!-- .twitter-grid-item -->

        <?php $output = ob_get_clean();

        return apply_filters('lae_block_module_17', $output, $source);
    }
}