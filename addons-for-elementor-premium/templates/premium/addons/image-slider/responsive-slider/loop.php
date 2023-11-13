<?php
/**
 * Loop - Responsive Slider Template
 *
 * This template can be overridden by copying it to mytheme/addons-for-elementor/premium/addons/image-slider/responsive-slider/loop.php
 *
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}
?>

<div class="rslides_container">

    <ul class="rslides lae-slide">

        <?php foreach ($settings['image_slides'] as $slide): ?>

            <?php $args['slide'] = $slide; ?>

            <?php lae_get_template_part("premium/addons/image-slider/responsive-slider/slide", $args); ?>

        <?php endforeach; ?>

    </ul>

</div>