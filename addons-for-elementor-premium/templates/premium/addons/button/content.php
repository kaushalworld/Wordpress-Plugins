<?php
/**
 * Content - Button Template
 *
 * This template can be overridden by copying it to mytheme/addons-for-elementor/premium/addons/button/content.php
 *
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

use Elementor\Icons_Manager;

list($animate_class, $animation_attr) = lae_get_animation_atts($settings['widget_animation']);

$icon_html = $type = '';

$class = (!empty($settings['button_class'])) ? ' ' . $settings['button_class'] : '';

$color_class = ' lae-' . esc_attr($settings['button_color']);

if (!empty($settings['button_type']))
    $type = ' lae-' . esc_attr($settings['button_type']);

$rounded = ($settings['rounded'] == 'yes') ? ' lae-rounded' : '';

$target = $settings['href']['is_external'] ? 'target="_blank"' : '';

if (!empty($settings['href']['url'])) {
    $link = $settings['href']['url'];
}
else {
    $link = '#';
}

$style = ($settings['button_style']) ? ' style="' . esc_attr($settings['button_style']) . '"' : '';

$icon_html = '';

if ($settings['icon_type'] == 'icon_image') {
    if (!empty($settings['icon_image']))
        $icon_html = wp_get_attachment_image($settings['icon_image']['id'], 'thumbnail', false, array('class' => 'lae-image lae-thumbnail'));
}
elseif ($settings['icon_type'] == 'icon' && (!empty($settings['icon']) || !empty($settings['selected_icon']['value']))) {

    $migrated = isset($icon_item['__fa4_migrated']['selected_icon']);
    $is_new = empty($icon_item['icon']) && Icons_Manager::is_migration_allowed();

    if ($is_new || $migrated) :

        ob_start();

        Icons_Manager::render_icon($settings['selected_icon'], ['aria-hidden' => 'true']);

        $icon_html = ob_get_contents();
        ob_end_clean();

    else :

        $icon_html = '<i class="' . esc_attr($settings['icon']) . '" aria-hidden="true"></i>';

    endif;
}

?>


<div class="lae-button-wrap" style="clear: both; text-align:<?php echo esc_attr($settings['align']); ?>;">

    <a class="lae-button <?php echo ((!empty($icon_html)) ? ' lae-with-icon' : '') . esc_attr($class) . $color_class . $type . $rounded . $animate_class; ?>"<?php echo $style . $animation_attr; ?>
       href="<?php echo esc_url($link); ?>"<?php echo esc_html($target); ?>><?php echo $icon_html . esc_html($settings['button_text']); ?></a>

</div>


