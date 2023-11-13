<?php

use LivemeshAddons\Blocks\LAE_Blocks_Manager;
use LivemeshAddons\Blocks\Clients\LAE_Instagram_Client;

function lae_parse_instagram_block_settings($settings) {

    $s = (array)$settings;

    $s['block_class'] = filter_var($s['block_class'], FILTER_DEFAULT);

    $s['block_id'] = filter_var($s['block_id'], FILTER_DEFAULT);

    $s['instagram_usernames'] = filter_var($s['instagram_usernames'], FILTER_DEFAULT);

    $s['instagram_hashtags'] = filter_var($s['instagram_hashtags'], FILTER_DEFAULT);

    $s['layout_mode'] = isset($s['layout_mode']) ? $s['layout_mode'] : 'fitRows';

    $s['enable_lightbox'] = isset($s['enable_lightbox']) ? filter_var($s['enable_lightbox'], FILTER_VALIDATE_BOOLEAN) : true;

    $s['per_line'] = filter_var($s['per_line'], FILTER_VALIDATE_INT);

    $s['per_line_tablet'] = filter_var($s['per_line_tablet'], FILTER_VALIDATE_INT);

    $s['per_line_mobile'] = filter_var($s['per_line_mobile'], FILTER_VALIDATE_INT);

    $s['items_per_page'] = filter_var($s['items_per_page'], FILTER_VALIDATE_INT);

    $s['display_header'] = isset($s['display_header']) ? filter_var($s['display_header'], FILTER_VALIDATE_BOOLEAN) : false;

    $s['display_avatar'] = isset($s['display_avatar']) ? filter_var($s['display_avatar'], FILTER_VALIDATE_BOOLEAN) : false;

    $s['display_username'] = isset($s['display_username']) ? filter_var($s['display_username'], FILTER_VALIDATE_BOOLEAN) : false;

    $s['display_name'] = isset($s['display_name']) ? filter_var($s['display_name'], FILTER_VALIDATE_BOOLEAN) : false;

    $s['display_date'] = isset($s['display_date']) ? filter_var($s['display_date'], FILTER_VALIDATE_BOOLEAN) : false;

    $s['date_format'] = filter_var($s['date_format'], FILTER_DEFAULT);

    $s['display_comments'] = isset($s['display_comments']) ? filter_var($s['display_comments'], FILTER_VALIDATE_BOOLEAN) : false;

    $s['display_likes'] = isset($s['display_likes']) ? filter_var($s['display_likes'], FILTER_VALIDATE_BOOLEAN) : false;

    $s['display_read_more'] = isset($s['display_read_more']) ? filter_var($s['display_read_more'], FILTER_VALIDATE_BOOLEAN) : false;

    $s['display_excerpt'] = isset($s['display_excerpt']) ? filter_var($s['display_excerpt'], FILTER_VALIDATE_BOOLEAN) : false;

    $s['excerpt_length'] = isset($s['excerpt_length']) ? filter_var($s['excerpt_length'], FILTER_VALIDATE_INT) : 50;

    $s['image_linkable'] = isset($s['image_linkable']) ? filter_var($s['image_linkable'], FILTER_VALIDATE_BOOLEAN) : true;

    $s['post_link_new_window'] = isset($s['post_link_new_window']) ? filter_var($s['post_link_new_window'], FILTER_VALIDATE_BOOLEAN) : false;

    $s['read_more_text'] = isset($s['read_more_text']) ? $s['read_more_text'] : '';

    return apply_filters('lae_instagram_block_parsed_settings', $s);

}