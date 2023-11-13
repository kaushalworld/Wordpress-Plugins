<?php
/**
 * Content - Icon List Template
 *
 * This template can be overridden by copying it to mytheme/addons-for-elementor/premium/addons/icon-list/content.php
 *
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

use Elementor\Icons_Manager;

$migration_allowed = Icons_Manager::is_migration_allowed();

$icon_type = esc_html($icon_item['icon_type']);

$icon_title = esc_html($icon_item['icon_title']);

$icon_url = !empty($icon_item['href']['url']) ? $icon_item['href']['url'] : null;

$target = $icon_item['href']['is_external'] ? 'target="_blank"' : '';

?>

<?php list($animate_class, $animation_attr) = lae_get_animation_atts($settings['widget_animation']); ?>

<div class="lae-icon-list-item <?php echo $animate_class; ?>" <?php echo $animation_attr; ?>
     title="<?php echo $icon_title; ?>">

    <?php if (($icon_type == 'icon_image') && !empty($icon_item['icon_image'])) : ?>

        <?php if (empty($icon_url)) : ?>

            <div class="lae-image-wrapper">

                <?php echo wp_get_attachment_image($icon_item['icon_image']['id'], 'full', false, array('class' => 'lae-image full', 'alt' => $icon_title)); ?>

            </div>

        <?php else : ?>

            <a class="lae-image-wrapper" href="<?php echo $icon_url; ?>" <?php echo $target; ?>>

                <?php echo wp_get_attachment_image($icon_item['icon_image']['id'], 'full', false, array('class' => 'lae-image full', 'alt' => $icon_title)); ?>

            </a>

        <?php endif; ?>

    <?php elseif (!empty($icon_item['icon']) || !empty($icon_item['selected_icon']['value'])) : ?>

        <?php

        $migrated = isset($icon_item['__fa4_migrated']['selected_icon']);
        $is_new = empty($icon_item['icon']) && $migration_allowed;

        if ($is_new || $migrated) :

            ob_start();

            Icons_Manager::render_icon($icon_item['selected_icon'], ['aria-hidden' => 'true']);

            $icon_html = ob_get_contents();

            ob_end_clean();

        else :

            $icon_html = '<i class="' . esc_attr($icon_item['icon']) . '" aria-hidden="true"></i>';

        endif;

        ?>

        <?php if (empty($icon_url)) : ?>

            <div class="lae-icon-wrapper">

                <?php echo $icon_html; ?>

            </div>

        <?php else : ?>

            <a class="lae-icon-wrapper" href="<?php echo $icon_url; ?>" <?php echo $target; ?>>

                <?php echo $icon_html; ?>

            </a>

        <?php endif; ?>

    <?php endif; ?>

</div><!-- .lae-icon-list-item -->