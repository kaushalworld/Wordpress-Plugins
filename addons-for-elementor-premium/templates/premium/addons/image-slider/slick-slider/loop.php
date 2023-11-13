<?php
/**
 * Loop - Slick Slider Template
 *
 * This template can be overridden by copying it to mytheme/addons-for-elementor/premium/addons/image-slider/slick-slider/loop.php
 *
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

?>

<div class="lae-slickslider">

    <?php foreach ($settings['image_slides'] as $slide): ?>

        <?php $args['slide'] = $slide; ?>

        <?php lae_get_template_part("premium/addons/image-slider/slick-slider/slide", $args); ?>

    <?php endforeach; ?>

</div>