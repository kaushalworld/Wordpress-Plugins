<?php
/**
 * Content - Slider Template
 *
 * This template can be overridden by copying it to mytheme/addons-for-elementor/premium/addons/slider/content.php
 *
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

?>

<?php if (!empty($slide['slide_content'])): ?>

    <li class="lae-slide">

        <?php echo $widget_instance->parse_text_editor($slide['slide_content']); ?>

    </li>

<?php endif; ?>