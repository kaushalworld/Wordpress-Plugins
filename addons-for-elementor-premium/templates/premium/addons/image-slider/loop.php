<?php
/**
 * Loop - Image Slider Template
 *
 * This template can be overridden by copying it to mytheme/addons-for-elementor/premium/addons/image-slider/loop.php
 *
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

$dir = is_rtl() ? ' dir="rtl"' : '';

$slider_options = [
    'slide_animation' => $settings['slide_animation'],
    'direction' => $settings['direction'],
    'slideshow_speed' => absint($settings['slideshow_speed']),
    'animation_speed' => absint($settings['animation_speed']),
    'randomize' => ('yes' === $settings['randomize']),
    'loop' => ('yes' === $settings['loop']),
    'slideshow' => ('yes' === $settings['slideshow']),
    'control_nav' => ('yes' === $settings['control_nav']),
    'direction_nav' => ('yes' === $settings['direction_nav']),
    'thumbnail_nav' => ('yes' === $settings['thumbnail_nav']),
    'pause_on_hover' => ('yes' === $settings['pause_on_hover']),
    'pause_on_action' => ('yes' === $settings['pause_on_action'])
];
?>

<div <?php echo $dir; ?>
        class="lae-image-slider lae-container lae-caption-<?php echo $settings['caption_style']; ?>"
        data-slider-type="<?php echo $settings['slider_type']; ?>"
        data-settings='<?php echo wp_json_encode($slider_options); ?>'>

    <?php if ($settings['slider_type'] == 'flex'): ?>

        <?php lae_get_template_part("premium/addons/image-slider/flex-slider/loop", $args); ?>

    <?php elseif ($settings['slider_type'] == 'nivo') : ?>

        <?php lae_get_template_part("premium/addons/image-slider/nivo-slider/loop", $args); ?>

    <?php elseif ($settings['slider_type'] == 'slick') : ?>

        <?php lae_get_template_part("premium/addons/image-slider/slick-slider/loop", $args); ?>

    <?php elseif ($settings['slider_type'] == 'responsive') : ?>

        <?php lae_get_template_part("premium/addons/image-slider/responsive-slider/loop", $args); ?>

    <?php endif; ?>

</div>
