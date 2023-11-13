<?php
/**
 * Slider Thumbnail Navigation
 *
 * This template can be overridden by copying it to mytheme/addons-for-elementor/premium/addons/posts-slider/thumb-nav.php
 *
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

?>

<div<?php echo is_rtl() ? ' dir="rtl"' : ''; ?>
        id="lae-thumbnail-slider-<?php echo $settings['slider_id']; ?>"
        class="lae-thumbnail-slider">
    <?php echo $thumbnail_items; ?>
</div>

