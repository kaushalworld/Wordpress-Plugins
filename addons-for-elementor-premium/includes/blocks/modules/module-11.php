<?php

namespace LivemeshAddons\Modules;

class LAE_Module_11 extends LAE_Module {

    function render() {

        $source = $this->source;

        ob_start();
        ?>

        <article
                class="lae-module-11 <?php echo $this->get_module_classes(); ?> <?php echo join(' ', get_post_class('', $source->post_ID)); ?>">

            <?php if ($thumbnail_exists = has_post_thumbnail($source->post_ID)): ?>

                <div class="lae-module-image">

                    <?php echo $source->get_media(); ?>

                    <?php echo $source->get_lightbox(); ?>

                    <div class="lae-module-image-info">

                        <div class="lae-module-entry-info">

                            <?php echo $source->get_media_title(); ?>

                            <?php echo $source->get_media_taxonomy(); ?>

                        </div>

                    </div>

                </div>

            <?php endif; ?>

            <div class="lae-module-entry-text">

                <?php echo $source->get_title(); ?>

                <div class="lae-module-meta">
                    <?php echo $source->get_author(); ?>
                    <?php echo $source->get_date(); ?>
                    <?php echo $source->get_taxonomies_info(); ?>
                </div>

                <div class="lae-excerpt">
                    <?php echo $source->get_excerpt(); ?>
                </div>

                <?php echo $source->get_read_more_link(); ?>

            </div>

        </article><!-- .hentry -->

        <?php $output = ob_get_clean();

        return apply_filters('lae_block_module_11', $output, $source);
    }
}