<?php
/**
 * Thumbnail Slide - Thumbnail Slider Template
 *
 * This template can be overridden by copying it to mytheme/addons-for-elementor/premium/addons/image-slider/flex-slider/thumbnail-slide.php
 *
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

?>
<?php if (!empty($slide['slide_image']) && wp_attachment_is_image($slide['slide_image']['id'])) : ?>

    <li class="lae-slide">

        <?php echo wp_get_attachment_image($slide['slide_image']['id'], 'medium', false, array('class' => 'lae-image medium', 'alt' => $slide['heading'])); ?>

    </li>

<?php endif; ?>