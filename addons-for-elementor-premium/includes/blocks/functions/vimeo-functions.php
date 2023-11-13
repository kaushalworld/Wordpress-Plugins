<?php

use LivemeshAddons\Blocks\LAE_Blocks_Manager;
use LivemeshAddons\Blocks\Clients\LAE_Vimeo_Client;

add_action('wp_ajax_lae_load_vimeo_block', 'lae_load_vimeo_block_callback');

add_action('wp_ajax_nopriv_lae_load_vimeo_block', 'lae_load_vimeo_block_callback');

function lae_load_vimeo_block_callback() {

    check_ajax_referer('lae-block-nonce', '_ajax_nonce-lae-block');

    global $lae_is_ajax;

    // set ajax mode
    $lae_is_ajax = true;

    $ajax_parameters = array(
        'items' => array(),
        'settings' => array(),
        'currentPage' => '',    // the current page of the block
        'blockId' => '',        // block uid
        'blockType' => '',         // the type of the block / block class
        'queryMeta' => null,     // the page token for vimeo posts retrieval
        'offset' => 0
    );

    if (!empty($_POST['blockId'])) {
        $ajax_parameters['blockId'] = $_POST['blockId'];
    }
    if (!empty($_POST['settings'])) {
        $ajax_parameters['settings'] = $_POST['settings']; //current block args
    }

    if (!empty($_POST['blockType'])) {
        $ajax_parameters['blockType'] = $_POST['blockType'];
    }
    if (!empty($_POST['currentPage'])) {
        $ajax_parameters['currentPage'] = intval($_POST['currentPage']);
    }

    if (!empty($_POST['queryMeta'])) {
        $ajax_parameters['queryMeta'] = $_POST['queryMeta'];
    }

    if (!empty($_POST['total'])) {
        $ajax_parameters['total'] = $_POST['total'];
    }

    if (!empty($_POST['paged'])) {

        $ajax_parameters['paged'] = intval($_POST['paged']);
    }

    $settings = lae_parse_vimeo_block_settings($ajax_parameters['settings']);

    $block = LAE_Blocks_Manager::get_instance($ajax_parameters['blockType']);

    $vimeo_client = new LAE_Vimeo_Client($settings, $ajax_parameters['queryMeta']);

    $items = $vimeo_client->get_grid_items();

    $query_meta = $vimeo_client->get_query_meta();

    $remaining = $vimeo_client->get_remaining();

    $output = $block->inner($items, $settings);

    $outputArray = array(
        'data' => $output,
        'blockId' => $ajax_parameters['blockId'],
        'queryMeta' => $query_meta,
        'remainingItems' => $remaining
    );

    echo json_encode(apply_filters('lae_vimeo_block_ajax_output_array', $outputArray, $ajax_parameters));

    wp_die();

}


function lae_parse_vimeo_block_settings($settings) {

    $s = (array)$settings;

    $s['block_class'] = filter_var($s['block_class'], FILTER_DEFAULT);

    $s['block_id'] = filter_var($s['block_id'], FILTER_DEFAULT);

    $s['vimeo_source'] = filter_var($s['vimeo_source'], FILTER_DEFAULT);

    $s['vimeo_sort'] = filter_var($s['vimeo_sort'], FILTER_DEFAULT);

    $s['vimeo_order'] = filter_var($s['vimeo_order'], FILTER_DEFAULT);

    $s['vimeo_user'] = filter_var($s['vimeo_user'], FILTER_DEFAULT);

    $s['vimeo_album'] = filter_var($s['vimeo_album'], FILTER_DEFAULT);

    $s['vimeo_group'] = filter_var($s['vimeo_group'], FILTER_DEFAULT);

    $s['vimeo_channel'] = filter_var($s['vimeo_channel'], FILTER_DEFAULT);

    $s['layout_mode'] = isset($s['layout_mode']) ? $s['layout_mode'] : 'fitRows';

    $s['display_video_inline'] = isset($s['display_video_inline']) ? filter_var($s['display_video_inline'], FILTER_VALIDATE_BOOLEAN) : true;

    $s['lightbox_library'] = filter_var($s['lightbox_library'], FILTER_DEFAULT);

    $s['per_line'] = filter_var($s['per_line'], FILTER_VALIDATE_INT);

    $s['per_line_tablet'] = filter_var($s['per_line_tablet'], FILTER_VALIDATE_INT);

    $s['per_line_mobile'] = filter_var($s['per_line_mobile'], FILTER_VALIDATE_INT);

    $s['items_per_page'] = filter_var($s['items_per_page'], FILTER_VALIDATE_INT);

    $s['display_thumbnail_title'] = isset($s['display_thumbnail_title']) ? filter_var($s['display_thumbnail_title'], FILTER_VALIDATE_BOOLEAN) : false;

    $s['display_item_title'] = isset($s['display_item_title']) ? filter_var($s['display_item_title'], FILTER_VALIDATE_BOOLEAN) : false;

    $s['display_excerpt'] = isset($s['display_excerpt']) ? filter_var($s['display_excerpt'], FILTER_VALIDATE_BOOLEAN) : false;

    $s['excerpt_length'] = isset($s['excerpt_length']) ? filter_var($s['excerpt_length'], FILTER_VALIDATE_INT) : 50;

    $s['display_name'] = isset($s['display_name']) ? filter_var($s['display_name'], FILTER_VALIDATE_BOOLEAN) : false;

    $s['display_date'] = isset($s['display_date']) ? filter_var($s['display_date'], FILTER_VALIDATE_BOOLEAN) : false;

    $s['date_format'] = filter_var($s['date_format'], FILTER_DEFAULT);

    $s['display_comments'] = isset($s['display_comments']) ? filter_var($s['display_comments'], FILTER_VALIDATE_BOOLEAN) : false;

    $s['display_views'] = isset($s['display_views']) ? filter_var($s['display_views'], FILTER_VALIDATE_BOOLEAN) : false;

    $s['display_duration'] = isset($s['display_duration']) ? filter_var($s['display_duration'], FILTER_VALIDATE_BOOLEAN) : false;

    $s['display_likes'] = isset($s['display_likes']) ? filter_var($s['display_likes'], FILTER_VALIDATE_BOOLEAN) : false;

    $s['display_user'] = isset($s['display_user']) ? filter_var($s['display_user'], FILTER_VALIDATE_BOOLEAN) : false;

    $s['display_categories'] = isset($s['display_categories']) ? filter_var($s['display_categories'], FILTER_VALIDATE_BOOLEAN) : false;

    $s['item_title_tag'] = isset($s['item_title_tag']) ? $s['item_title_tag'] : 'h3';

    return apply_filters('lae_vimeo_block_parsed_settings', $s);

}