<?php
/**
 * Loop - Slider Template
 *
 * This template can be overridden by copying it to mytheme/addons-for-elementor/premium/addons/slider/loop.php
 *
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

$dir = is_rtl() ? ' dir="rtl"' : '';

$style = is_rtl() ? ' style="direction:rtl"' : '';

$slider_settings = [
    'slide_animation' => $settings['slide_animation'],
    'direction' => $settings['direction'],
    'control_nav' => ('yes' === $settings['control_nav']),
    'direction_nav' => ('yes' === $settings['direction_nav']),
    'randomize' => ('yes' === $settings['randomize']),
    'loop' => ('yes' === $settings['loop']),
    'pause_on_hover' => ('yes' === $settings['pause_on_hover']),
    'pause_on_action' => ('yes' === $settings['pause_on_action']),
    'slideshow' => ('yes' === $settings['slideshow']),
    'slideshow_speed' => absint($settings['slideshow_speed']),
    'animation_speed' => absint($settings['animation_speed']),
];

?>

<div class="lae-slider lae-container <?php echo esc_attr($settings['class']); ?>"
     data-settings='<?php echo wp_json_encode($slider_settings); ?>'>

    <div<?php echo $dir . $style; ?> class="lae-flexslider">

        <ul class="lae-slides">

            <?php foreach ($settings['slides'] as $slide): ?>

                <?php $args['slide'] = $slide; ?>

                <?php lae_get_template_part("premium/addons/slider/content", $args); ?>

            <?php endforeach; ?>

        </ul><!-- .lae-slides -->

    </div><!-- .lae-flexslider -->

</div><!-- .lae-slider -->