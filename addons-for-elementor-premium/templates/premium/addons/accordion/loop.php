<?php
/**
 * Loop - Accordion Template
 *
 * This template can be overridden by copying it to mytheme/addons-for-elementor/premium/addons/accordion/loop.php
 *
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

?>

<div class="lae-accordion lae-<?php echo $settings['style']; ?>"
     data-toggle="<?php echo($settings['toggle'] == 'yes' ? "true" : "false"); ?>"
     data-expanded="<?php echo($settings['expanded'] == 'yes' ? "true" : "false"); ?>">

    <?php foreach ($settings['panels'] as $panel) : ?>

        <?php $args['panel'] = $panel; ?>

        <?php lae_get_template_part("premium/addons/accordion/content", $args); ?>

    <?php endforeach; ?>

</div><!-- .lae-accordion -->

