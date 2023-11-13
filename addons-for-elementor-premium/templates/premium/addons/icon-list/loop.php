<?php
/**
 * Loop - Icon List Template
 *
 * This template can be overridden by copying it to mytheme/addons-for-elementor/premium/addons/icon-list/loop.php
 *
 */

use Elementor\Icons_Manager;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

?>

<div class="lae-icon-list lae-align<?php echo $settings['align']; ?>">

    <?php foreach ($settings['icon_list'] as $icon_item): ?>

        <?php $args['icon_item'] = $icon_item; ?>

        <?php lae_get_template_part("premium/addons/icon-list/content", $args); ?>

    <?php endforeach; ?>

</div><!-- .lae-icon-list -->


