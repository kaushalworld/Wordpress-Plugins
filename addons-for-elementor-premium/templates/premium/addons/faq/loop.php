<?php
/**
 * Loop - FAQ Template
 *
 * This template can be overridden by copying it to mytheme/addons-for-elementor/premium/addons/faq/loop.php
 *
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

?>

<div class="lae-faq-list lae-uber-grid-container <?php echo lae_get_grid_classes($settings); ?>">

    <?php foreach ($settings['faq_list'] as $faq): ?>

        <?php $args['faq'] = $faq; ?>

        <?php lae_get_template_part("premium/addons/faq/content", $args); ?>
    
    <?php endforeach; ?>

</div><!-- .lae-faq-list -->

<div class="lae-clear"></div>

