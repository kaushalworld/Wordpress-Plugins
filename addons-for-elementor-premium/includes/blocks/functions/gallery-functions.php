<?php

use LivemeshAddons\Blocks\LAE_Blocks_Manager;


add_filter('attachment_fields_to_edit', 'lae_attachment_fields_gallery', 10, 2);
add_filter('attachment_fields_to_save', 'lae_attachment_fields_gallery_save', 10, 2);

add_action('wp_ajax_lae_load_gallery_block', 'lae_load_gallery_block_callback');

add_action('wp_ajax_nopriv_lae_load_gallery_block', 'lae_load_gallery_block_callback');


function lae_attachment_fields_gallery($form_fields, $post) {

    $form_fields['lae_grid_width'] = array(
        'label' => esc_html__('Width', 'livemesh-el-addons'),
        'input' => 'html',
        'html' => '
<select name="attachments[' . $post->ID . '][lae_grid_width]" id="attachments-' . $post->ID . '-lae_grid_width">
  <option ' . selected(get_post_meta($post->ID, 'lae_grid_width', true), "lae-default", false) . ' value="lae-default">' . esc_html__('Default', 'livemesh-el-addons') . '</option>
  <option ' . selected(get_post_meta($post->ID, 'lae_grid_width', true), "lae-wide", false) . ' value="lae-wide">' . esc_html__('Wide', 'livemesh-el-addons') . '</option>
</select>',
        'value' => get_post_meta($post->ID, 'lae_grid_width', true),
        'helps' => esc_html__('Width of the image in masonry style gallery grid', 'livemesh-el-addons')
    );

    $form_fields['lae_gallery_item_tags'] = array(
        'label' => esc_html__('Tags', 'livemesh-el-addons'),
        'input' => 'text',
        'value' => get_post_meta($post->ID, 'lae_gallery_item_tags', true),
        'helps' => esc_html__('Comma separated tags for the gallery item', 'livemesh-el-addons')
    );

    return $form_fields;
}

function lae_attachment_fields_gallery_save($post, $attachment) {

    if (isset($attachment['lae_grid_width']))
        update_post_meta($post['ID'], 'lae_grid_width', $attachment['lae_grid_width']);

    if (isset($attachment['lae_gallery_item_tags']))
        update_post_meta($post['ID'], 'lae_gallery_item_tags', $attachment['lae_gallery_item_tags']);

    return $post;
}

function lae_load_gallery_block_callback() {

    check_ajax_referer('lae-block-nonce', '_ajax_nonce-lae-block');

    $ajax_parameters = array(
        'items' => array(),
        'settings' => array(),
        'currentPage' => '',    // the current page of the block
        'blockId' => '',        // block uid
        'blockType' => '',         // the type of the block / block class
        'filterTerm' => '',     // the id for this specific filter type. The filter type is in the query
        'filterTaxonomy' => ''     // the id for this specific filter type. The filter type is in the query
    );


    if (!empty($_POST['blockId'])) {
        $ajax_parameters['blockId'] = $_POST['blockId'];
    }
    if (!empty($_POST['settings'])) {
        $ajax_parameters['settings'] = $_POST['settings']; //current block args
    }
    if (!empty($_POST['taxonomies'])) {
        $ajax_parameters['taxonomies'] = $_POST['taxonomies']; //current block args
    }

    if (!empty($_POST['blockType'])) {
        $ajax_parameters['blockType'] = $_POST['blockType'];
    }
    if (!empty($_POST['currentPage'])) {
        $ajax_parameters['currentPage'] = intval($_POST['currentPage']);
    }
    //read the id for this specific filter type
    if (!empty($_POST['filterTerm'])) {

        $ajax_parameters['filterTerm'] = $_POST['filterTerm']; //the new id filter
    }

    if (!empty($_POST['filterTaxonomy'])) {

        $ajax_parameters['filterTaxonomy'] = $_POST['filterTaxonomy']; //the new id filter
    }

    if (!empty($_POST['items'])) {

        $ajax_parameters['items'] = $_POST['items'];
    }

    if (!empty($_POST['paged'])) {

        $ajax_parameters['paged'] = intval($_POST['paged']);
    }

    if (!empty($ajax_parameters['items']))
        $items = lae_parse_gallery_block_items($ajax_parameters['items']);

    if (!empty($_POST['settings']))
        $settings = lae_parse_gallery_block_settings($ajax_parameters['settings']);

    $block = LAE_Blocks_Manager::get_instance($ajax_parameters['blockType']);

    $output = $block->inner($items, $settings);

    //pagination
    $hidePrev = false;
    $hideNext = false;
    $remaining_posts = 0;

    $max_num_pages = ceil(count($items) / $settings['items_per_page']);

    if ($ajax_parameters['currentPage'] == 1) {
        $hidePrev = true; //hide link on page 1
    }

    if ($ajax_parameters['currentPage'] >= $max_num_pages) {
        $hideNext = true; //hide link on last page
    }
    else {
        $remaining_posts = count($items) - ($ajax_parameters['paged'] * $settings['items_per_page']);
    }


    $outputArray = array(
        'data' => $output,
        'blockId' => $ajax_parameters['blockId'],
        'filterTerm' => $ajax_parameters['filterTerm'],
        'filterTaxonomy' => $ajax_parameters['filterTaxonomy'],
        'paged' => $ajax_parameters['paged'],
        'maxpages' => $max_num_pages,
        'remaining' => $remaining_posts,
        'hidePrev' => $hidePrev,
        'hideNext' => $hideNext
    );

    echo json_encode(apply_filters('lae_gallery_block_ajax_output_array', $outputArray, $ajax_parameters));

    wp_die();

}

function lae_parse_gallery_block_items($items) {

    $parsed_items = array();

    foreach ($items as $item):

        // Remove encoded quotes or other characters
        $item['item_name'] = stripslashes($item['item_name']);

        $item['item_description'] = isset($item['item_description']) ? filter_var($item['item_description'], FILTER_DEFAULT) : '';

        $item['video_link'] = isset($item['video_link']) ? filter_var($item['video_link'], FILTER_DEFAULT) : '';

        $item['mp4_video_link'] = isset($item['mp4_video_link']) ? filter_var($item['mp4_video_link'], FILTER_DEFAULT) : '';

        $item['webm_video_link'] = isset($item['webm_video_link']) ? filter_var($item['webm_video_link'], FILTER_DEFAULT) : '';

        $item['display_video_inline'] = isset($item['display_video_inline']) ? filter_var($item['display_video_inline'], FILTER_VALIDATE_BOOLEAN) : false;

        $parsed_items[] = $item;

    endforeach;

    return apply_filters('lae_gallery_block_parsed_items', $parsed_items, $items);
}

function lae_parse_gallery_block_settings($settings) {

    $s = (array)$settings;

    $s['block_class'] = filter_var($s['block_class'], FILTER_DEFAULT);

    $s['block_id'] = filter_var($s['block_id'], FILTER_DEFAULT);

    $s['bulk_upload'] = isset($s['bulk_upload']) ? filter_var($s['bulk_upload'], FILTER_VALIDATE_BOOLEAN) : false;

    $s['filterable'] = isset($s['filterable']) ? filter_var($s['filterable'], FILTER_VALIDATE_BOOLEAN) : true;

    $s['layout_mode'] = isset($s['layout_mode']) ? $s['layout_mode'] : 'fitRows';

    $s['enable_lightbox'] = isset($s['enable_lightbox']) ? filter_var($s['enable_lightbox'], FILTER_VALIDATE_BOOLEAN) : true;

    $s['per_line'] = filter_var($s['per_line'], FILTER_VALIDATE_INT);

    $s['per_line_tablet'] = filter_var($s['per_line_tablet'], FILTER_VALIDATE_INT);

    $s['per_line_mobile'] = filter_var($s['per_line_mobile'], FILTER_VALIDATE_INT);

    $s['show_remaining'] = isset($s['show_remaining']) ? filter_var($s['show_remaining'], FILTER_VALIDATE_BOOLEAN) : true;

    $s['items_per_page'] = filter_var($s['items_per_page'], FILTER_VALIDATE_INT);

    $s['display_item_title'] = isset($s['display_item_title']) ? filter_var($s['display_item_title'], FILTER_VALIDATE_BOOLEAN) : false;

    $s['display_item_tags'] = isset($s['display_item_tags']) ? filter_var($s['display_item_tags'], FILTER_VALIDATE_BOOLEAN) : false;

    $s['display_description'] = isset($s['display_description']) ? filter_var($s['display_description'], FILTER_VALIDATE_BOOLEAN) : false;

    $s['heading_tag'] = isset($s['heading_tag']) ? $s['heading_tag'] : 'h3';

    $s['item_title_tag'] = isset($s['item_title_tag']) ? $s['item_title_tag'] : 'h3';

    $s['entry_title_tag'] = isset($s['entry_title_tag']) ? $s['entry_title_tag'] : 'h3';

    return apply_filters('lae_gallery_block_parsed_settings', $s);

}