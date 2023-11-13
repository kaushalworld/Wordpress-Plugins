<?php

namespace LivemeshAddons\Modules;

class LAE_Module_21 extends LAE_Module {

    function render() {

        $source = $this->source;

        $settings = $source->settings;

        ob_start();
        ?>

        <div class="lae-module-21 <?php echo $this->get_module_classes(); ?>">

            <?php if ($source->is_inline_video()): ?>

                <div class="lae-module-video">

                    <?php echo $source->get_inline_video(); ?>

                </div>

            <?php else: ?>

                <div class="lae-module-image">

                    <?php echo $source->get_media(); ?>

                    <?php echo $source->get_duration(); ?>

                    <?php echo $source->get_thumbnail_title(); ?>

                    <div class="lae-module-image-info">

                        <div class="lae-module-entry-info">

                            <?php echo $source->get_video_lightbox(); ?>

                        </div>

                    </div>

                </div>

            <?php endif; ?>

            <div class="lae-module-entry-details">

                <div class="lae-module-meta">

                    <?php echo $source->get_channel(); ?>

                    <?php echo $source->get_date(); ?>

                </div>

                <div class="lae-module-entry-text">

                    <?php echo $source->get_entry_title(); ?>

                    <?php echo $source->get_categories(); ?>

                    <?php echo $source->get_excerpt(); ?>

                </div>

                <div class="lae-module-details">

                    <?php echo $source->get_views(); ?>

                    <?php echo $source->get_likes(); ?>

                    <?php echo $source->get_comments_number(); ?>

                </div>

            </div>

        </div><!-- .gallery-item -->

        <?php $output = ob_get_clean();

        return apply_filters('lae_block_module_21', $output, $source);
    }
}