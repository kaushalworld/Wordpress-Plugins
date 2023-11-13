<?php

use WPRA\Helpers\Utils;
use WPRA\Integrations\WPML;

$params       = $start_counts = [];
$data_atts    = $social_platforms = $already = '';
$total_counts = 0;

if (isset($data)) {
    extract($data);
}

$button_text_val = WPML::getTranslation($params['sgc_id'], 'reveal_button_text', $params['reveal_button']['text']);
$button_text     = '<span>' . $button_text_val . '</span>';
$icon            = '<i class="%s"></i>';
$is_icon_left    = $params['reveal_button']['icon_position'] == 'left';

if ($params['reveal_button']['icon_active'] == 'true') {
    $icon        = sprintf($icon, $params['reveal_button']['icon']);
    $button_text = $is_icon_left ? $icon . $button_text : $button_text . $icon;
}

$button_text_clicked_val = WPML::getTranslation($params['sgc_id'], 'reveal_button_text_clicked', $params['reveal_button']['text_clicked']);
$button_text_clicked     = '<span>' . $button_text_clicked_val . '</span>';

if ($params['reveal_button']['icon_clicked_active'] == 'true') {
    if ($is_icon_left) {
        $icon_clicked        = sprintf($icon, $params['reveal_button']['icon_clicked'], $params['reveal_button']['icon_space'], '0');
        $button_text_clicked = $icon_clicked . $button_text_clicked;
    } else {
        $icon_clicked        = sprintf($icon, $params['reveal_button']['icon_clicked'], '0', $params['reveal_button']['icon_space']);
        $button_text_clicked = $button_text_clicked . $icon_clicked;
    }
}

$popup_header_text = WPML::getTranslation($params['sgc_id'], 'reveal_button_popup_header', $params['reveal_button']['popup_header']);

?>
<div class="wpra-plugin-container wpra-button-reveal" <?php echo $data_atts; ?>>
    <?php if ($params['reveal_button']['popup'] == 'true') { ?>
        <div class="wpra-share-popup-overlay"></div>
        <div class="wpra-share-popup">
            <span class="wpra-share-popup-close">&times;</span>
            <h3><?php echo $popup_header_text; ?></h3>
            <?php echo $social_platforms; ?>
        </div>
    <?php } ?>
    <div class="wpra-button-reveal-wrap">
        <button type="button" class="wpra-reveal-toggle">
            <span class="wpra-button-toggle-text"><?php echo $button_text; ?></span>
            <span class="wpra-button-toggle-text-clicked" style="display: none"><?php echo $button_text_clicked; ?></span>
        </button>
        <div class="wpra-reacted-emoji"></div>
        <?php
        Utils::renderTemplate("view/front/layouts/regular", [
            'params'       => $params,
            'data_atts'    => $data_atts,
            'already'      => $already,
            'total_counts' => $total_counts,
            'start_counts' => $start_counts,
        ]);
        ?>
    </div>
</div>