<?php

use WPRA\Emojis;
use WPRA\App;
use WPRA\Helpers\Utils;

$params = [];
isset($data) && extract($data);

$layout = $params['layout'];

$already      = App::getUserReactedEmoji($params['bind_id']);
$start_counts = App::getCountsTotal($params['bind_id'], $params['start_counts'], $params['emojis']);
$total_counts = array_sum($start_counts);

$params['emoji_format'] = Emojis::getData($params['emojis'], ['format']);
$params['is_lottie']    = strpos($params['emoji_format'], 'json') !== false;

if (empty($params['source'])) {
    $params['source'] = $params['sgc_id'] == 0 ? 'global' : 'shortcode';
}

if ($layout == 'button_reveal') {
    $params['show_title']           = 'false';
    $params['title_color']          = $params['title_size'] = $params['title_weight'] = $params['title_text'] = '';
    $params['social_style_buttons'] = $params['enable_share_buttons'] = 'false';
    $params['social']               = [
        "border_radius"  => "",
        "border_color"   => "",
        "text_color"     => "",
        "bg_color"       => "",
        "button_type"    => "",
        "hide_titles"    => "",
        "counter"        => "",
        "counter_size"   => "",
        "counter_weight" => "",
        "counter_color"  => "",
    ];
}

$social_platforms = ($params['enable_share_buttons'] != 'false' || ($layout == 'button_reveal' && $params['reveal_button']['popup'] == 'true'))
    ? Utils::getTemplate('view/front/layouts/parts/social-platforms', ['params' => $params]) : '';

if ($layout == 'bimber') {
    $params['show_count'] = 'true';
}

$atts = [
    'ver'              => WPRA_VERSION,
    'layout'           => $params['layout'],
    'bind_id'          => $params['bind_id'],
    'show_count'       => $params['show_count'],
    'count_percentage' => $params['count_percentage'],
    'enable_share'     => $params['enable_share_buttons'],
    'animation'        => $params['animation'],
    'align'            => $params['align'],
    'flying_type'      => $params['flying']['type'],
    'react_secure'     => wp_create_nonce('wpra-react-action'),
    'source'           => $params['source'],
    'sgc_id'           => $params['sgc_id'],
    'format'           => $params['emoji_format'],
];

if (isset($params['custom_data'])) {
    $atts = array_merge($atts, $params['custom_data']);
}

if ($layout == 'button_reveal') {
    $atts['ontop_align'] = $params['reveal_button']['ontop_align'];
    $atts['popup']       = $params['reveal_button']['popup'];
}

$data_atts = Utils::buildDataAttrs($atts);

// remove emojis that have id of -1 from old implementation
$params['emojis'] = Utils::removeArrayElement($params['emojis'], -1);

Utils::renderTemplate("view/front/layouts/$layout", [
    'params'           => $params,
    'social_platforms' => $social_platforms,
    'data_atts'        => $data_atts,
    'already'          => $already,
    'total_counts'     => $total_counts,
    'start_counts'     => $start_counts,
]);