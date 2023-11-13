<?php
/**
 * Slider Thumbnail Navigation Items
 *
 * This template can be overridden by copying it to mytheme/addons-for-elementor/premium/addons/posts-slider/thumbnail-item.php
 *
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

?>

<div class="lae-thumbnail-slider-item">

    <?php if ($thumbnail_exists = has_post_thumbnail() && $settings['display_thumbnail'] == 'yes'): ?>

        <?php $image_src = get_the_post_thumbnail_url($post_id, 'medium'); ?>

        <div class="lae-thumbnail-slider-image-bg" style="background-image: url(<?php echo $image_src; ?>);"></div>

    <?php endif; ?>

</div>