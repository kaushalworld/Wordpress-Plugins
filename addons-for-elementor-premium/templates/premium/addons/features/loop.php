<?php
/**
 * Loop - Features Template
 *
 * This template can be overridden by copying it to mytheme/addons-for-elementor/premium/addons/features/loop.php
 *
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

$class = (($settings['tiled'] == 'yes') ? 'lae-tiled ' . $settings['feature_class'] : $settings['feature_class']);

?>

<div class="lae-features lae-container <?php echo esc_attr($class); ?>">

    <?php foreach ($settings['features'] as $index => $feature): ?>

        <?php $args['index'] = $index; ?>

        <?php $args['feature'] = $feature; ?>

        <?php lae_get_template_part("premium/addons/features/content", $args); ?>
        
    <?php endforeach; ?>

</div><!-- .lae-features -->


