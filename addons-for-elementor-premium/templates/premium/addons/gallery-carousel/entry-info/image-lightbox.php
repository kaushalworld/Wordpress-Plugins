<?php
/**
 * Content - Gallery Carousel Image Lightbox Template
 *
 * This template can be overridden by copying it to mytheme/addons-for-elementor/premium/addons/gallery-carousel/entry-info/image-lightbox.php
 *
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

?>

<?php $anchor_type = (empty($item['item_link']['url']) ? 'lae-click-anywhere' : 'lae-click-icon'); ?>

<?php if ($settings['lightbox_library'] == 'elementor'): ?>

    <a class="lae-lightbox-item <?php echo $anchor_type; ?> elementor-clickable"
       href="<?php echo $item['item_image']['url']; ?>" data-elementor-open-lightbox="yes"
       data-elementor-lightbox-slideshow="<?php echo esc_attr($widget_instance->get_id()); ?>"
       title="<?php echo esc_html($item['item_label']); ?>">

        <i class="lae-icon-full-screen"></i>

    </a>

<?php else: ?>

    <?php $thumbnail_src = wp_get_attachment_image_src($item['item_image']['id']); ?>

    <?php if ($thumbnail_src): ?>
        <?php $thumbnail_src = $thumbnail_src[0]; ?>
    <?php endif; ?>

    <a class="lae-lightbox-item <?php echo $anchor_type; ?>"
       data-fancybox="<?php echo $settings['gallery_class']; ?>"
       data-thumb="<?php echo $thumbnail_src; ?>" href="<?php echo $item['item_image']['url']; ?>"
       data-elementor-open-lightbox="no" title="<?php echo esc_html($item['item_label']); ?>"
       data-description="<?php echo wp_kses_post($item['item_description']); ?>">

        <i class="lae-icon-full-screen"></i>

    </a>

<?php endif; ?>