<?php
/**
 * Content - Accordion Template
 *
 * This template can be overridden by copying it to mytheme/addons-for-elementor/premium/addons/accordion/content.php
 *
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

if (empty($panel['panel_id']))
    $panel_id = sanitize_title_with_dashes($panel['panel_title']);
else
    $panel_id = $panel['panel_id'];

?>

<div class="lae-panel" id="<?php echo $panel_id; ?>">

    <div class="lae-panel-title"><?php echo esc_html($panel['panel_title']); ?></div>

    <div class="lae-panel-content"><?php echo $widget_instance->parse_text_editor($panel['panel_content']); ?></div>

</div><!-- .lae-panel -->