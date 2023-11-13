<?php
/**
 * Loop - Gallery Carousel Template
 *
 * This template can be overridden by copying it to mytheme/addons-for-elementor/premium/addons/gallery-carousel/loop.php
 *
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

$dir = is_rtl() ? ' dir="rtl"' : '';

$carousel_settings = [
    'enable_lightbox' => ('yes' === $settings['enable_lightbox']),
    'lightbox_library' => $settings['lightbox_library'],
    'arrows' => ('yes' === $settings['arrows']),
    'dots' => ('yes' === $settings['dots']),
    'autoplay' => ('yes' === $settings['autoplay']),
    'autoplay_speed' => absint($settings['autoplay_speed']),
    'animation_speed' => absint($settings['animation_speed']),
    'pause_on_hover' => ('yes' === $settings['pause_on_hover']),
];

$responsive_settings = [
    'display_columns' => $settings['display_columns'],
    'scroll_columns' => $settings['scroll_columns'],
    'gutter' => $settings['gutter'],
    'tablet_width' => $settings['tablet_width'],
    'tablet_display_columns' => $settings['tablet_display_columns'],
    'tablet_scroll_columns' => $settings['tablet_scroll_columns'],
    'tablet_gutter' => $settings['tablet_gutter'],
    'mobile_width' => $settings['mobile_width'],
    'mobile_display_columns' => $settings['mobile_display_columns'],
    'mobile_scroll_columns' => $settings['mobile_scroll_columns'],
    'mobile_gutter' => $settings['mobile_gutter'],

];

$carousel_settings = array_merge($carousel_settings, $responsive_settings);

?>

<div<?php echo $dir; ?> id="lae-gallery-carousel-<?php echo uniqid(); ?>"
                        class="lae-gallery-carousel lae-container <?php echo $settings['gallery_class']; ?>"
                        data-settings='<?php echo wp_json_encode($carousel_settings); ?>'>

    <?php foreach ($settings['gallery_items'] as $item): ?>

        <?php

        // No need to populate anything if no image is provided for video or for the image
        if (empty($item['item_image']))
            continue;

        ?>

        <?php $args['item'] = $item; ?>

        <?php lae_get_template_part("premium/addons/gallery-carousel/content", $args); ?>

    <?php endforeach; ?>

</div><!-- .lae-gallery-carousel -->