<?php

/**
 * Loop - Tabs Template
 *
 * This template can be overridden by copying it to mytheme/addons-for-elementor/premium/addons/tabs/loop.php
 *
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

use Elementor\Icons_Manager;

$migration_allowed = Icons_Manager::is_migration_allowed();

$plain_styles = array('style2', 'style6', 'style7');

$vertical_class = '';

$vertical_styles = array('style7', 'style8', 'style9', 'style10');

if (in_array($settings['style'], $vertical_styles, true)):

    $vertical_class = 'lae-vertical';

endif;

$tab_panes = $tab_elements = array();

foreach ($settings['tabs'] as $tab) :

    if (in_array($settings['style'], $plain_styles, true)):

        $icon_type = 'none'; // do not display icons for plain styles even if chosen by the user

    else :

        $icon_type = $tab['icon_type'];

    endif;

    if (empty($tab['tab_id']))
        $tab_id = sanitize_title_with_dashes($tab['tab_title']);
    else
        $tab_id = $tab['tab_id'];

    $tab_element = '<a class="lae-tab-label" href="#' . $tab_id . '">';

    if ($icon_type == 'icon_image') :

        $tab_element .= '<span class="lae-image-wrapper">';

        $icon_image = $tab['icon_image'];

        $tab_element .= wp_get_attachment_image($icon_image['id'], 'thumbnail', false, array('class' => 'lae-image'));

        $tab_element .= '</span>';

    elseif ($icon_type == 'icon' && (!empty($tab['icon']) || !empty($tab['selected_icon']['value']))) :

        $migrated = isset($tab['__fa4_migrated']['selected_icon']);
        $is_new = empty($tab['icon']) && $migration_allowed;

        $tab_element .= '<span class="lae-icon-wrapper">';

        if ($is_new || $migrated) :

            ob_start();

            Icons_Manager::render_icon($tab['selected_icon'], ['aria-hidden' => 'true']);

            $tab_element .= ob_get_contents();
            ob_end_clean();

        else :

            $tab_element .= '<i class="' . esc_attr($tab['icon']) . '" aria-hidden="true"></i>';

        endif;

        $tab_element .= '</span>';

    endif;

    $tab_element .= '<span class="lae-tab-title">';

    $tab_element .= esc_html($tab['tab_title']);

    $tab_element .= '</span>';

    $tab_element .= '</a>';

    $tab_nav = '<div class="lae-tab">' . $tab_element . '</div>';

    $tab_content = '<div id="' . $tab_id . '" class="lae-tab-pane">' . $widget_instance->parse_text_editor($tab['tab_content']) . '</div>';

    $tab_elements[] = $tab_nav;

    $tab_panes[] = $tab_content;

endforeach;

?>

<div class="lae-tabs <?php echo $vertical_class; ?> lae-tabs-<?php echo esc_attr($settings['style']); ?>"
     data-mobile-width="<?php echo intval($settings['mobile_width']); ?>">

    <a href="#" class="lae-tab-mobile-menu"><i class="lae-icon-menu"></i>&nbsp;</a>

    <div class="lae-tab-nav">

        <?php foreach ($tab_elements as $tab_nav) : ?>

            <?php echo $tab_nav; ?>

        <?php endforeach; ?>

    </div><!-- .lae-tab-nav -->

    <div class="lae-tab-panes">

        <?php foreach ($tab_panes as $tab_pane) : ?>

            <?php echo $tab_pane; ?>

        <?php endforeach; ?>

    </div><!-- .lae-tab-panes -->

</div><!-- .lae-tabs -->