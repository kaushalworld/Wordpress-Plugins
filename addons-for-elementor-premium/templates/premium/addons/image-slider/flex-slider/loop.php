<?php
/**
 * Loop - Flex Slider Template
 *
 * This template can be overridden by copying it to mytheme/addons-for-elementor/premium/addons/image-slider/flex-slider/loop.php
 *
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

$style = is_rtl() ? ' style="direction:rtl"' : '';

$slider_id = null;

?>

<?php if ('yes' == $settings['thumbnail_nav']):

    $carousel_id = uniqid('lae-carousel-');
    $slider_id = uniqid('lae-slider-');

endif; ?>

    <div <?php echo $style; ?> <?php echo(!empty($slider_id) ? 'id="' . $slider_id . '"' : ''); ?>
        <?php echo(!empty($carousel_id) ? 'data-carousel="' . $carousel_id . '"' : ''); ?>
            class="lae-flexslider">

        <ul class="lae-slides">

            <?php foreach ($settings['image_slides'] as $slide): ?>

                <?php $args['slide'] = $slide; ?>

                <?php lae_get_template_part("premium/addons/image-slider/flex-slider/slide", $args); ?>

            <?php endforeach; ?>

        </ul><!-- .lae-slides -->

    </div><!-- .lae-flexslider -->

<?php if (!empty($carousel_id)): ?>

    <?php $args['carousel_id'] = $carousel_id; ?>

    <?php lae_get_template_part("premium/addons/image-slider/flex-slider/thumbnail-slider", $args); ?>

<?php endif; ?>