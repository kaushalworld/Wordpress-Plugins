<?php
/**
 * Content - FAQ Template
 *
 * This template can be overridden by copying it to mytheme/addons-for-elementor/premium/addons/faq/content.php
 *
 */

use Elementor\Utils;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

?>

<?php list($animate_class, $animation_attr) = lae_get_animation_atts($faq['widget_animation']); ?>

<div class="lae-grid-item lae-faq-item <?php echo $animate_class; ?>" <?php echo $animation_attr; ?>>

    <<?php echo lae_validate_html_tag($settings['title_tag']); ?> class="lae-faq-question"><?php echo esc_html($faq['question']); ?></<?php echo lae_validate_html_tag($settings['title_tag']); ?>>

    <div class="lae-faq-answer"><?php echo do_shortcode($faq['answer']); ?></div>

</div><!-- .lae-faq-item -->