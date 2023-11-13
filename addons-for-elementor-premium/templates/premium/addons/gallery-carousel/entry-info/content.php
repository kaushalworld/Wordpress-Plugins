<?php
/**
 * Content - Gallery Carousel Item Content Template
 *
 * This template can be overridden by copying it to mytheme/addons-for-elementor/premium/addons/gallery-carousel/entry-info/content.php
 *
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}


$item_type = $item['item_type'];

?>

<div class="lae-image-info">

    <div class="lae-entry-info">

        <?php lae_get_template_part("premium/addons/gallery-carousel/entry-info/item-title", $args); ?>

        <?php if ($item_type == 'youtube' || $item_type == 'vimeo' || $item_type == 'html5video') : ?>

            <?php lae_get_template_part("premium/addons/gallery-carousel/entry-info/video-lightbox", $args); ?>

        <?php endif; ?>

        <?php if ($settings['display_item_tags'] == 'yes'): ?>

            <span class="lae-terms"><?php echo esc_html($item['item_tags']); ?></span>

        <?php endif; ?>

    </div>

    <?php if ($item_type == 'image' && ($settings['enable_lightbox'] == 'yes')) : ?>

        <?php lae_get_template_part("premium/addons/gallery-carousel/entry-info/image-lightbox", $args); ?>

    <?php endif; ?>

</div><!-- .lae-image-info -->
