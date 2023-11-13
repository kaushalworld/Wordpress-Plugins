<?php

use LivemeshAddons\Blocks\LAE_Blocks_Manager;
use LivemeshAddons\Blocks\Clients\LAE_Twitter_Client;

add_action('wp_ajax_lae_load_twitter_block', 'lae_load_twitter_block_callback');

add_action('wp_ajax_nopriv_lae_load_twitter_block', 'lae_load_twitter_block_callback');

function lae_load_twitter_block_callback() {

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
        'maxId' => null,     // the max id for twitter posts retrieval
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

    if (!empty($_POST['maxId'])) {
        $ajax_parameters['maxId'] = $_POST['maxId'];
    }

    if (!empty($_POST['paged'])) {

        $ajax_parameters['paged'] = intval($_POST['paged']);
    }

    $settings = lae_parse_twitter_block_settings($ajax_parameters['settings']);

    $block = LAE_Blocks_Manager::get_instance($ajax_parameters['blockType']);

    $twitter_client = new LAE_Twitter_Client($settings, $ajax_parameters['maxId']);

    $items = $twitter_client->get_grid_items();

    $max_id = $twitter_client->get_max_id(); // updated max id post retrieval of new tweets

    $output = $block->inner($items, $settings);

    $outputArray = array(
        'data' => $output,
        'blockId' => $ajax_parameters['blockId'],
        'maxId' => $max_id, // the new max id for twitter posts
    );

    echo json_encode(apply_filters('lae_twitter_block_ajax_output_array', $outputArray, $ajax_parameters));

    wp_die();

}


function lae_parse_twitter_block_settings($settings) {

    $s = (array)$settings;

    $s['block_class'] = filter_var($s['block_class'], FILTER_DEFAULT);

    $s['block_id'] = filter_var($s['block_id'], FILTER_DEFAULT);

    $s['twitter_source'] = filter_var($s['twitter_source'], FILTER_DEFAULT);

    $s['twitter_include'] = filter_var($s['twitter_include'], FILTER_DEFAULT);

    $s['twitter_username'] = filter_var($s['twitter_username'], FILTER_DEFAULT);

    $s['twitter_listname'] = filter_var($s['twitter_listname'], FILTER_DEFAULT);

    $s['twitter_searchkey'] = filter_var($s['twitter_searchkey'], FILTER_DEFAULT);

    $s['layout_mode'] = isset($s['layout_mode']) ? $s['layout_mode'] : 'fitRows';

    $s['enable_lightbox'] = isset($s['enable_lightbox']) ? filter_var($s['enable_lightbox'], FILTER_VALIDATE_BOOLEAN) : true;

    $s['per_line'] = filter_var($s['per_line'], FILTER_VALIDATE_INT);

    $s['per_line_tablet'] = filter_var($s['per_line_tablet'], FILTER_VALIDATE_INT);

    $s['per_line_mobile'] = filter_var($s['per_line_mobile'], FILTER_VALIDATE_INT);

    $s['items_per_page'] = filter_var($s['items_per_page'], FILTER_VALIDATE_INT);

    $s['display_avatar'] = isset($s['display_avatar']) ? filter_var($s['display_avatar'], FILTER_VALIDATE_BOOLEAN) : false;

    $s['display_username'] = isset($s['display_username']) ? filter_var($s['display_username'], FILTER_VALIDATE_BOOLEAN) : false;

    $s['display_name'] = isset($s['display_name']) ? filter_var($s['display_name'], FILTER_VALIDATE_BOOLEAN) : false;

    $s['display_date'] = isset($s['display_date']) ? filter_var($s['display_date'], FILTER_VALIDATE_BOOLEAN) : false;

    $s['date_format'] = filter_var($s['date_format'], FILTER_DEFAULT);

    $s['display_comments'] = isset($s['display_comments']) ? filter_var($s['display_comments'], FILTER_VALIDATE_BOOLEAN) : false;

    $s['display_retweets'] = isset($s['display_retweets']) ? filter_var($s['display_retweets'], FILTER_VALIDATE_BOOLEAN) : false;

    $s['display_likes'] = isset($s['display_likes']) ? filter_var($s['display_likes'], FILTER_VALIDATE_BOOLEAN) : false;

    $s['display_read_more'] = isset($s['display_read_more']) ? filter_var($s['display_read_more'], FILTER_VALIDATE_BOOLEAN) : false;

    $s['read_more_text'] = isset($s['read_more_text']) ? $s['read_more_text'] : '';

    return apply_filters('lae_twitter_block_parsed_settings', $s);

}