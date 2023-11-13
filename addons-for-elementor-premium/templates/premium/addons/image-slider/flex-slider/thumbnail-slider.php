<?php
/**
 * Thumbnail Slider - Flex Slider Template
 *
 * This template can be overridden by copying it to mytheme/addons-for-elementor/premium/addons/image-slider/flex-slider/thumbnail-slider.php
 *
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

$style = is_rtl() ? ' style="direction:rtl"' : '';

?>

<div <?php echo $style; ?> id="<?php echo $carousel_id; ?>" class="lae-thumbnailslider">

    <ul class="lae-slides">

        <?php foreach ($settings['image_slides'] as $slide): ?>

            <?php $args['slide'] = $slide; ?>

            <?php lae_get_template_part("premium/addons/image-slider/flex-slider/thumbnail-slide", $args); ?>

        <?php endforeach; ?>

    </ul>

</div>