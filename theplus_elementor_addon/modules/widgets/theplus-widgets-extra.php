<?php
/* Magic scroll */
$magic_class=$magic_attr=$parallax_scroll="";
if(!empty($settings['magic_scroll']) && $settings['magic_scroll'] == 'yes'){
    if(empty($settings["scroll_option_popover_toggle"])){
        $scroll_offset = 0;
        $scroll_duration = 300;
    }else{
        $scroll_offset = isset($settings['scroll_option_scroll_offset']) ? $settings['scroll_option_scroll_offset'] : 0;
        $scroll_duration = isset($settings['scroll_option_scroll_duration']) ? $settings['scroll_option_scroll_duration'] : 300;
    }

    if(empty($settings["scroll_from_popover_toggle"])){
        $scroll_x_from	= 0;
        $scroll_y_from	= 0;
        $scroll_opacity_from= 1;
        $scroll_scale_from	= 1;
        $scroll_rotate_from	= 0;
    }else{
        $scroll_x_from = isset($settings['scroll_from_scroll_x_from']) ? $settings['scroll_from_scroll_x_from'] : 0;
        $scroll_y_from = isset($settings['scroll_from_scroll_y_from']) ? $settings['scroll_from_scroll_y_from'] : 0;
        $scroll_opacity_from = isset($settings['scroll_from_scroll_opacity_from']) ? $settings['scroll_from_scroll_opacity_from'] : 1;
        $scroll_scale_from 	= isset($settings['scroll_from_scroll_scale_from']) ? $settings['scroll_from_scroll_scale_from'] : 1;
        $scroll_rotate_from = isset($settings['scroll_from_scroll_rotate_from']) ? $settings['scroll_from_scroll_rotate_from'] : 0;
    }

    if(empty($settings["scroll_to_popover_toggle"])){
        $scroll_x_to = 0;
        $scroll_y_to = -50;
        $scroll_opacity_to = 1;
        $scroll_scale_to = 1;
        $scroll_rotate_to = 0;
    }else{
        $scroll_x_to = isset($settings['scroll_to_scroll_x_to']) ? $settings['scroll_to_scroll_x_to'] : 0;
        $scroll_y_to = isset($settings['scroll_to_scroll_y_to']) ? $settings['scroll_to_scroll_y_to'] : -50;
        $scroll_opacity_to = isset($settings['scroll_to_scroll_opacity_to']) ? $settings['scroll_to_scroll_opacity_to'] : 1;
        $scroll_scale_to = isset($settings['scroll_to_scroll_scale_to']) ? $settings['scroll_to_scroll_scale_to'] : 1;
        $scroll_rotate_to = isset($settings['scroll_to_scroll_rotate_to']) ? $settings['scroll_to_scroll_rotate_to'] : 0;
    }
    
    $magic_attr .= ' data-scroll_type="position" ';
    $magic_attr .= ' data-scroll_offset="' . esc_attr($scroll_offset) . '" ';
    $magic_attr .= ' data-scroll_duration="' . esc_attr($scroll_duration) . '" ';
    $magic_attr .= ' data-scroll_x_from="' . esc_attr($scroll_x_from) . '" ';
    $magic_attr .= ' data-scroll_x_to="' . esc_attr($scroll_x_to) . '" ';
    $magic_attr .= ' data-scroll_y_from="' . esc_attr($scroll_y_from) . '" ';
    $magic_attr .= ' data-scroll_y_to="' . esc_attr($scroll_y_to) . '" ';
    $magic_attr .= ' data-scroll_opacity_from="' . esc_attr($scroll_opacity_from) . '" ';
    $magic_attr .= ' data-scroll_opacity_to="' . esc_attr($scroll_opacity_to) . '" ';
    $magic_attr .= ' data-scroll_scale_from="' . esc_attr($scroll_scale_from) . '" ';
    $magic_attr .= ' data-scroll_scale_to="' . esc_attr($scroll_scale_to) . '" ';
    $magic_attr .= ' data-scroll_rotate_from="' . esc_attr($scroll_rotate_from) . '" ';
    $magic_attr .= ' data-scroll_rotate_to="' . esc_attr($scroll_rotate_to) . '" ';
    $parallax_scroll .= ' parallax-scroll ';
    $magic_class .= ' magic-scroll ';
}

/* Tooltip */
if(!empty($settings['plus_tooltip']) && $settings['plus_tooltip'] == 'yes'){
    $this->add_render_attribute( '_tooltip', 'data-tippy', '', true );

    if (!empty($settings['plus_tooltip_content_type']) && $settings['plus_tooltip_content_type'] == 'normal_desc') {
        $this->add_render_attribute( '_tooltip', 'title', $settings['plus_tooltip_content_desc'], true );
    }else if (!empty($settings['plus_tooltip_content_type']) && $settings['plus_tooltip_content_type'] == 'content_wysiwyg') {
        $tooltip_content = $settings['plus_tooltip_content_wysiwyg'];
        $this->add_render_attribute( '_tooltip', 'title', $tooltip_content, true );
    }

    $plus_tooltip_position = !empty($settings["tooltip_opt_plus_tooltip_position"]) ? $settings["tooltip_opt_plus_tooltip_position"] : 'top';
    $this->add_render_attribute( '_tooltip', 'data-tippy-placement', $plus_tooltip_position, true );

    $tooltip_interactive = isset($settings["tooltip_opt_plus_tooltip_interactive"]) && $settings["tooltip_opt_plus_tooltip_interactive"] == 'yes' ? 'true' : 'false';
    $this->add_render_attribute( '_tooltip', 'data-tippy-interactive', $tooltip_interactive, true );

    $plus_tooltip_theme = !empty($settings["tooltip_opt_plus_tooltip_theme"]) ? $settings["tooltip_opt_plus_tooltip_theme"] : 'dark';
    $this->add_render_attribute( '_tooltip', 'data-tippy-theme', $plus_tooltip_theme, true );

    $tooltip_arrow = ($settings["tooltip_opt_plus_tooltip_arrow"] != 'none' || empty($settings["tooltip_opt_plus_tooltip_arrow"])) ? 'true' : 'false';
    $this->add_render_attribute( '_tooltip', 'data-tippy-arrow', $tooltip_arrow , true );
				
    $plus_tooltip_arrow = !empty($settings["tooltip_opt_plus_tooltip_arrow"]) ? $settings["tooltip_opt_plus_tooltip_arrow"] : 'sharp';
    $this->add_render_attribute( '_tooltip', 'data-tippy-arrowtype', $plus_tooltip_arrow, true );

    $plus_tooltip_animation = !empty($settings["tooltip_opt_plus_tooltip_animation"]) ? $settings["tooltip_opt_plus_tooltip_animation"] : 'shift-toward';
    $this->add_render_attribute( '_tooltip', 'data-tippy-animation', $plus_tooltip_animation, true );

    $plus_tooltip_x_offset = isset($settings["tooltip_opt_plus_tooltip_x_offset"]) ? $settings["tooltip_opt_plus_tooltip_x_offset"] : 0;
    $plus_tooltip_y_offset = isset($settings["tooltip_opt_plus_tooltip_y_offset"]) ? $settings["tooltip_opt_plus_tooltip_y_offset"] : 0;
    $this->add_render_attribute( '_tooltip', 'data-tippy-offset', $plus_tooltip_x_offset .','. $plus_tooltip_y_offset, true );

    $tooltip_duration_in = isset($settings["tooltip_opt_plus_tooltip_duration_in"]) ? $settings["tooltip_opt_plus_tooltip_duration_in"] : 250;
    $tooltip_duration_out = isset($settings["tooltip_opt_plus_tooltip_duration_out"]) ? $settings["tooltip_opt_plus_tooltip_duration_out"] : 200;
    $tooltip_trigger = !empty($settings["tooltip_opt_plus_tooltip_triggger"]) ? $settings["tooltip_opt_plus_tooltip_triggger"] : 'mouseenter';
    $tooltip_arrowtype = !empty($settings["tooltip_opt_plus_tooltip_arrow"]) ? $settings["tooltip_opt_plus_tooltip_arrow"] : 'sharp';
}

/* MouseMove Parallax */
$move_parallax=$move_parallax_attr=$parallax_move='';
if(!empty($settings['plus_mouse_move_parallax']) && $settings['plus_mouse_move_parallax'] == 'yes'){
    $move_parallax = 'pt-plus-move-parallax';
    $parallax_move = 'parallax-move';
    $parallax_speed_x = isset($settings["plus_mouse_parallax_speed_x"]["size"]) ? $settings["plus_mouse_parallax_speed_x"]["size"] : 30;
    $parallax_speed_y = isset($settings["plus_mouse_parallax_speed_y"]["size"]) ? $settings["plus_mouse_parallax_speed_y"]["size"] : 30;
    $move_parallax_attr .= ' data-move_speed_x="'.esc_attr($parallax_speed_x).'" ';
    $move_parallax_attr .= ' data-move_speed_y="'.esc_attr($parallax_speed_y).'" ';
}

/* Tilt3D Parallax */
$inner_js_tilt=$tilt_hover_class=$tilt_attr="";
if(!empty($settings['plus_tilt_parallax']) && $settings['plus_tilt_parallax'] == 'yes' || (!empty($settings['tilt_parallax']) && $settings['tilt_parallax']=='yes' && $wname==="tpinfobox")){
    $tilt_scale	= isset($settings["plus_tilt_opt_tilt_scale"]["size"]) ? $settings["plus_tilt_opt_tilt_scale"]["size"] : 1.1;
    $tilt_max = isset($settings["plus_tilt_opt_tilt_max"]["size"]) ? $settings["plus_tilt_opt_tilt_max"]["size"] : 20;
    $tilt_perspective = isset($settings["plus_tilt_opt_tilt_perspective"]["size"]) ? $settings["plus_tilt_opt_tilt_perspective"]["size"] : 400;
    $tilt_speed	= isset($settings["plus_tilt_opt_tilt_speed"]["size"]) ? $settings["plus_tilt_opt_tilt_speed"]["size"] : 400;

    $this->add_render_attribute('_tilt_parallax', 'data-tilt', '', true);
    $this->add_render_attribute('_tilt_parallax', 'data-tilt-scale', $tilt_scale, true);
    $this->add_render_attribute('_tilt_parallax', 'data-tilt-max', $tilt_max, true);
    $this->add_render_attribute('_tilt_parallax', 'data-tilt-perspective', $tilt_perspective, true);
    $this->add_render_attribute('_tilt_parallax', 'data-tilt-speed', $tilt_speed, true);

    if(!empty($settings["plus_tilt_opt_tilt_easing"]) && $settings["plus_tilt_opt_tilt_easing"] != 'custom'){
        $easing_tilt = $settings["plus_tilt_opt_tilt_easing"];
    }else if(!empty($settings["plus_tilt_opt_tilt_easing"]) && $settings["plus_tilt_opt_tilt_easing"] == 'custom'){
        $easing_tilt = $settings["plus_tilt_opt_tilt_easing_custom"];
    }else{
        $easing_tilt = 'cubic-bezier(.03,.98,.52,.99)';
    }
    $this->add_render_attribute('_tilt_parallax', 'data-tilt-easing', $easing_tilt, true);
	$inner_js_tilt='js-tilt';
	$tilt_hover_class='tilt-index';
}

/* Overlay Effect */
$reveal_effects=$effect_attr='';
if(!empty($settings["plus_overlay_effect"]) && $settings["plus_overlay_effect"] == 'yes'){
    $effect_rand_no = uniqid('reveal');
    $color_1 = !empty($settings["plus_overlay_spcial_effect_color_1"]) ? $settings["plus_overlay_spcial_effect_color_1"] : '#313131';
    $color_2 = !empty($settings["plus_overlay_spcial_effect_color_2"]) ? $settings["plus_overlay_spcial_effect_color_2"] : '#ff214f';
    $effect_attr .=' data-reveal-id="'.esc_attr($effect_rand_no).'" ';
    $effect_attr .=' data-effect-color-1="'.esc_attr($color_1).'" ';
    $effect_attr .=' data-effect-color-2="'.esc_attr($color_2).'" ';
    $reveal_effects=' pt-plus-reveal '.esc_attr($effect_rand_no).' ';
}

/* Continuous Animation */
$continuous_animation='';
if((isset($settings["plus_continuous_animation"]) && $settings["plus_continuous_animation"] == 'yes') && !empty($settings["plus_animation_effect"])){
    if(isset($settings["plus_animation_hover"]) && $settings["plus_animation_hover"] == 'yes'){
        $animation_class='hover_';
    }else{
        $animation_class='image-';
    }
    $continuous_animation=$animation_class.$settings["plus_animation_effect"];
}

$before_content=$after_content="";
$uid_widget=uniqid("plus");
if((isset($settings['magic_scroll']) && $settings['magic_scroll'] == 'yes') || (isset($settings['plus_tooltip']) && $settings['plus_tooltip'] == 'yes') || (isset($settings['plus_mouse_move_parallax']) && $settings['plus_mouse_move_parallax'] == 'yes') || (isset($settings['plus_tilt_parallax']) && $settings['plus_tilt_parallax'] == 'yes') || (isset($settings['plus_overlay_effect']) && $settings["plus_overlay_effect"] == 'yes') || (isset($settings['plus_continuous_animation']) && $settings["plus_continuous_animation"] == 'yes')){
    $before_content .='<div id="'.esc_attr($uid_widget).'" class="'.esc_attr($PlusExtra_Class).' plus-widget-wrapper '.esc_attr($magic_class).' '.esc_attr($move_parallax).' '.esc_attr($reveal_effects).' '.esc_attr($continuous_animation).'" '.$effect_attr.' '.$this->get_render_attribute_string( '_tooltip' ).'>';
    $before_content .='<div class="plus-widget-inner-wrap '.esc_attr($parallax_scroll).' " '.$magic_attr.'>';

    if( isset($settings['plus_mouse_move_parallax']) && $settings['plus_mouse_move_parallax'] == 'yes' ){
        $before_content .='<div class="plus-widget-inner-parallax '.esc_attr($parallax_move).'" '.$move_parallax_attr.'>';
    }

    if( isset($settings['plus_tilt_parallax']) && $settings['plus_tilt_parallax'] == 'yes' ){
        $before_content .='<div class="plus-widget-inner-tilt js-tilt" '.$this->get_render_attribute_string( '_tilt_parallax' ).'>';
    }

}

if((isset($settings['magic_scroll']) && $settings['magic_scroll'] == 'yes') || (isset($settings['plus_tooltip']) && $settings['plus_tooltip'] == 'yes') || (isset($settings['plus_mouse_move_parallax']) && $settings['plus_mouse_move_parallax'] == 'yes') || (isset($settings['plus_tilt_parallax']) && $settings['plus_tilt_parallax'] == 'yes') || (isset($settings['plus_overlay_effect']) && $settings["plus_overlay_effect"] == 'yes') || (isset($settings['plus_continuous_animation']) && $settings["plus_continuous_animation"] == 'yes')){
    $after_content .='</div>';
    $after_content .='</div>';

    if( isset($settings['plus_mouse_move_parallax']) && $settings['plus_mouse_move_parallax'] == 'yes' ){
        $after_content .='</div>';
    }

    if( isset($settings['plus_tilt_parallax']) && $settings['plus_tilt_parallax'] == 'yes' ){
        $after_content .='</div>';
    }

    $inline_tippy_js='';
    if( isset($settings['plus_tooltip']) && $settings['plus_tooltip'] == 'yes' ){
        $inline_tippy_js ='jQuery( document ).ready(function() {
        "use strict";
            if(typeof tippy === "function"){
                tippy( "#'.esc_attr($uid_widget).'" , {
                    arrowType : "'.esc_attr($tooltip_arrowtype).'",
                    duration : ['.esc_attr($tooltip_duration_in).','.esc_attr($tooltip_duration_out).'],
                    trigger : "'.esc_attr($tooltip_trigger).'",
                    appendTo: document.querySelector("#'.esc_attr($uid_widget).'")
                });
            }
        });';
        $after_content .= wp_print_inline_script_tag($inline_tippy_js);
    }
}