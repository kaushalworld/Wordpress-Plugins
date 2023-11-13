<?php

namespace LivemeshAddons\Modules;

class LAE_Module_25 extends LAE_Module {

    function render() {

        $source = $this->source;

        ob_start();
        ?>

        <article
                class="lae-module-25 <?php echo $this->get_module_classes(); ?> <?php echo join(' ', get_post_class('', $source->post_ID)); ?>">

            <?php if ($thumbnail_exists = has_post_thumbnail($source->post_ID)): ?>

                <div class="lae-module-image">

                    <?php echo $source->get_media(); ?>

                    <?php echo $source->get_product_on_sale(); ?>

                    <?php echo $source->get_product_wishlist(); ?>

                    <?php echo $source->get_product_quick_view(); ?>

                </div>

            <?php endif; ?>

            <div class="lae-module-entry-text">

                <?php echo $source->get_title(); ?>

                <?php echo $source->get_product_rating(); ?>

                <?php echo $source->get_product_full_price(); ?>

                <?php echo $source->get_product_cart_button(); ?>

            </div>

        </article><!-- .hentry -->

        <?php $output = ob_get_clean();

        return apply_filters('lae_block_module_25', $output, $source);
    }
}