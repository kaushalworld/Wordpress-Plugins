<?php

/*
Widget Name: Image Slider
Description: Create a responsive image slider.
Author: LiveMesh
Author URI: https://www.livemeshthemes.com
*/

namespace LivemeshAddons\Widgets;

use Elementor\Repeater;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Utils;
use Elementor\Scheme_Color;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Image_Size;
use Elementor\Scheme_Typography;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

/**
 * Class for Image Slider widget that displays images as a responsive image slider.
 */
class LAE_Image_Slider_Widget extends LAE_Widget_Base {

    /**
     * Get the name for the widget
     * @return string
     */
    public function get_name() {
        return 'lae-image-slider';
    }

    /**
     * Get the widget title
     * @return string|void
     */
    public function get_title() {
        return __('Image Slider', 'livemesh-el-addons');
    }

    /**
     * Get the widget icon
     * @return string
     */
    public function get_icon() {
        return 'lae-icon-slider6';
    }

    /**
     * Retrieve the list of categories the widget belongs to.
     *
     * Used to determine where to display the widget in the editor.
     *
     * @return string[]
     */
    public function get_categories() {
        return array('livemesh-addons');
    }

    /**
     * Get the widget documentation URL
     * @return string
     */
    public function get_custom_help_url() {
        return 'https://livemeshelementor.com/docs/livemesh-addons/premium-addons/image-slider/';
    }

    /**
     * Obtain the scripts required for the widget to function
     * @return string[]
     */
    public function get_script_depends() {
        return [
            'jquery-flexslider',
            'jquery-nivo',
            'lae-jquery-slick',
            'responsiveslides',
            'lae-frontend-scripts',
            'lae-image-slider-scripts'
        ];
    }

    /**
     * Register the controls for the widget
     * Adds fields that help configure and customize the widget
     * @return void
     */
    protected function register_controls() {

        $this->start_controls_section(
            'section_image_slider',
            [
                'label' => __('Image Slider', 'livemesh-el-addons'),
            ]
        );


        $this->add_control(

            'class', [
                'type' => Controls_Manager::TEXT,
                "description" => __("Provide a unique CSS class for the slider. (optional).", "livemesh-el-addons"),
                "label" => __("Class", "livemesh-el-addons"),
                'prefix_class' => 'lae-image-slider-',
            ]
        );

        $this->add_control(

            'caption_style', [
                'type' => Controls_Manager::SELECT,
                'label' => __('Caption Style', 'livemesh-el-addons'),
                'default' => 'style1',
                'options' => [
                    'style1' => __('Style 1', 'livemesh-el-addons'),
                    'style2' => __('Style 2', 'livemesh-el-addons'),
                ],
            ]
        );

        $this->add_control(
            'image_slider_heading',
            [
                'label' => __('Image Slides', 'livemesh-el-addons'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'slide_image',
            [

                'label' => __('Slide Image', 'livemesh-el-addons'),
                'type' => Controls_Manager::MEDIA,
                'default' => [
                    'url' => Utils::get_placeholder_image_src(),
                ],
                'label_block' => true,
                'dynamic' => [
                    'active' => true,
                ],
            ]
        );

        $repeater->add_control(
            'slide_url',

            [

                'label' => __('URL to link to by image and caption heading. (optional)', 'livemesh-el-addons'),
                'type' => Controls_Manager::URL,
                'label_block' => true,
                'default' => [
                    'url' => '',
                    'is_external' => 'false',
                ],
                'placeholder' => __('http://your-link.com', 'livemesh-el-addons'),
                'dynamic' => [
                    'active' => true,
                ],
            ]
        );

        $repeater->add_control(
            'heading',

            [

                'label' => __('Caption Heading', 'livemesh-el-addons'),
                'default' => __('My slide caption', 'livemesh-el-addons'),
                'type' => Controls_Manager::TEXT,
                'dynamic' => [
                    'active' => true,
                ],
            ]
        );

        $repeater->add_control(
            'subheading',

            [

                'label' => __('Caption Subheading', 'livemesh-el-addons'),
                'type' => Controls_Manager::TEXT,
                'dynamic' => [
                    'active' => true,
                ],
            ]
        );

        $repeater->add_control(
            'caption_button_heading',

            [

                'label' => __('Caption Button', 'livemesh-el-addons'),
                'type' => Controls_Manager::HEADING,
                'dynamic' => [
                    'active' => true,
                ],
            ]
        );

        $repeater->add_control(
            'button_text',

            [

                'label' => __('Button Text', 'livemesh-el-addons'),
                'type' => Controls_Manager::TEXT,
                'dynamic' => [
                    'active' => true,
                ],
            ]
        );

        $repeater->add_control(
            'button_url',

            [

                'label' => __('Button URL', 'livemesh-el-addons'),
                'type' => Controls_Manager::URL,
                'label_block' => true,
                'default' => [
                    'url' => '',
                    'is_external' => 'true',
                ],
                'placeholder' => __('http://your-link.com', 'livemesh-el-addons'),
                'dynamic' => [
                    'active' => true,
                ],
            ]
        );

        $repeater->add_control(
            "button_color",
            [

                "type" => Controls_Manager::SELECT,
                "label" => __("Button Color", "livemesh-el-addons"),
                "options" => array(
                    "default" => __("Default", "livemesh-el-addons"),
                    "custom" => __("Custom", "livemesh-el-addons"),
                    "black" => __("Black", "livemesh-el-addons"),
                    "blue" => __("Blue", "livemesh-el-addons"),
                    "cyan" => __("Cyan", "livemesh-el-addons"),
                    "green" => __("Green", "livemesh-el-addons"),
                    "orange" => __("Orange", "livemesh-el-addons"),
                    "pink" => __("Pink", "livemesh-el-addons"),
                    "red" => __("Red", "livemesh-el-addons"),
                    "teal" => __("Teal", "livemesh-el-addons"),
                    "trans" => __("Transparent", "livemesh-el-addons"),
                    "semitrans" => __("Semi Transparent", "livemesh-el-addons"),
                ),
                'default' => 'default',
            ]
        );

        $repeater->add_control(
            "button_size",
            [

                "type" => Controls_Manager::SELECT,
                "label" => __("Button Size", "livemesh-el-addons"),
                "options" => array(
                    "medium" => __("Medium", "livemesh-el-addons"),
                    "large" => __("Large", "livemesh-el-addons"),
                    "small" => __("Small", "livemesh-el-addons"),
                ),
                'default' => 'medium',
            ]
        );

        $repeater->add_control(

            "rounded",
            [
                'type' => Controls_Manager::SWITCHER,
                'label' => __('Rounded Button?', 'livemesh-el-addons'),
                'label_off' => __('No', 'livemesh-el-addons'),
                'label_on' => __('Yes', 'livemesh-el-addons'),
                'return_value' => 'yes',
                'default' => 'no',
            ]
        );


        $this->add_control(
            'image_slides',
            [
                'type' => Controls_Manager::REPEATER,
                'default' => [],
                'fields' => $repeater->get_controls(),
                'title_field' => '{{{ heading }}}',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_settings',
            [
                'label' => __('Slider Options', 'livemesh-el-addons'),
                'tab' => Controls_Manager::TAB_SETTINGS
            ]
        );

        $this->add_control(

            'slider_type', [
                'type' => Controls_Manager::SELECT,
                "label" => __("Slider Type", "livemesh-el-addons"),
                'default' => 'flex',
                "options" => [
                    "flex" => __("Flex Slider", "livemesh-el-addons"),
                    "nivo" => __("Nivo Slider", "livemesh-el-addons"),
                    "slick" => __("Slick Slider", "livemesh-el-addons"),
                    "responsive" => __("Responsive Slider", "livemesh-el-addons"),
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
                'name' => 'thumbnail_size',
                'label' => __('Slide Image Size', 'livemesh-el-addons'),
                'default' => 'full',
                'condition' => [
                    'slider_type' => ['flex', 'slick', 'responsive'],
                ],
            ]
        );

        $this->add_control(
            'slide_animation',
            [
                'label' => __('Slider Animation', 'livemesh-el-addons'),
                'type' => Controls_Manager::SELECT,
                'default' => 'slide',
                'options' => [
                    'slide' => __('Slide', 'livemesh-el-addons'),
                    'fade' => __('Fade', 'livemesh-el-addons'),
                ],
                'condition' => [
                    'slider_type' => ['flex'],
                ],
            ]
        );

        $this->add_control(
            'direction',
            [
                'label' => __('Sliding Direction', 'livemesh-el-addons'),
                "description" => __("Select the sliding direction.", "livemesh-el-addons"),
                'type' => Controls_Manager::SELECT,
                'default' => 'horizontal',
                'options' => [
                    'horizontal' => __('Horizontal', 'livemesh-el-addons'),
                    'vertical' => __('Vertical', 'livemesh-el-addons'),
                ],
                'condition' => [
                    'slider_type' => ['flex', 'slick'],
                ],
            ]
        );

        $this->add_control(
            'control_nav',
            [
                'type' => Controls_Manager::SWITCHER,
                'label_off' => __('No', 'livemesh-el-addons'),
                'label_on' => __('Yes', 'livemesh-el-addons'),
                'return_value' => 'yes',
                'separator' => 'before',
                'default' => 'yes',
                "description" => __("Create navigation for paging control of each slide?", "livemesh-el-addons"),
                "label" => __("Control navigation?", "livemesh-el-addons"),
            ]
        );

        $this->add_control(
            'direction_nav',
            [
                'type' => Controls_Manager::SWITCHER,
                'label_off' => __('No', 'livemesh-el-addons'),
                'label_on' => __('Yes', 'livemesh-el-addons'),
                'return_value' => 'yes',
                'default' => 'no',
                "description" => __("Create navigation for previous/next navigation?", "livemesh-el-addons"),
                "label" => __("Direction navigation?", "livemesh-el-addons"),
            ]
        );

        $this->add_control(
            'thumbnail_nav',
            [
                'type' => Controls_Manager::SWITCHER,
                'label_off' => __('No', 'livemesh-el-addons'),
                'label_on' => __('Yes', 'livemesh-el-addons'),
                'return_value' => 'yes',
                'default' => 'no',
                "description" => __("Use thumbnails for Control Nav?", "livemesh-el-addons"),
                "label" => __("Thumbnails Navigation?", "livemesh-el-addons"),
                'condition' => [
                    'slider_type' => ['flex', 'nivo'],
                ],
            ]
        );

        $this->add_control(
            'randomize',
            [
                'type' => Controls_Manager::SWITCHER,
                'label_off' => __('No', 'livemesh-el-addons'),
                'label_on' => __('Yes', 'livemesh-el-addons'),
                'return_value' => 'yes',
                'separator' => 'before',
                'default' => 'no',
                "description" => __("Randomize slide order?", "livemesh-el-addons"),
                "label" => __("Randomize slides?", "livemesh-el-addons"),
                'condition' => [
                    'slider_type' => ['flex', 'responsive'],
                ],
            ]
        );

        $this->add_control(
            'pause_on_hover',
            [
                'type' => Controls_Manager::SWITCHER,
                'label_off' => __('No', 'livemesh-el-addons'),
                'label_on' => __('Yes', 'livemesh-el-addons'),
                'return_value' => 'yes',
                'default' => 'yes',
                "description" => __("Pause the slideshow when hovering over slider, then resume when no longer hovering.", "livemesh-el-addons"),
                "label" => __("Pause on hover?", "livemesh-el-addons"),
            ]
        );

        $this->add_control(
            'pause_on_action',
            [
                'type' => Controls_Manager::SWITCHER,
                'label_off' => __('No', 'livemesh-el-addons'),
                'label_on' => __('Yes', 'livemesh-el-addons'),
                'return_value' => 'yes',
                'default' => 'yes',
                "description" => __("Pause the slideshow when interacting with control elements.", "livemesh-el-addons"),
                "label" => __("Pause on action?", "livemesh-el-addons"),
                'condition' => [
                    'slider_type' => ['flex'],
                ],
            ]
        );

        $this->add_control(
            'loop',
            [
                'type' => Controls_Manager::SWITCHER,
                'label_off' => __('No', 'livemesh-el-addons'),
                'label_on' => __('Yes', 'livemesh-el-addons'),
                'return_value' => 'yes',
                'default' => 'yes',
                "description" => __("Should the animation loop?", "livemesh-el-addons"),
                "label" => __("Loop", "livemesh-el-addons"),
                'condition' => [
                    'slider_type' => ['flex', 'slick'],
                ],
            ]
        );

        $this->add_control(
            'slideshow',
            [
                'type' => Controls_Manager::SWITCHER,
                'label_off' => __('No', 'livemesh-el-addons'),
                'label_on' => __('Yes', 'livemesh-el-addons'),
                'return_value' => 'yes',
                'separator' => 'before',
                'default' => 'yes',
                "description" => __("Animate slider automatically without user intervention?", "livemesh-el-addons"),
                "label" => __("Slideshow", "livemesh-el-addons"),
            ]
        );

        $this->add_control(
            'slideshow_speed',
            [
                "description" => __("Set the speed of the slideshow cycling, in milliseconds", "livemesh-el-addons"),
                "label" => __("Slideshow speed", "livemesh-el-addons"),
                'type' => Controls_Manager::NUMBER,
                'default' => 5000,
            ]
        );


        $this->add_control(
            'animation_speed',
            [
                "description" => __("Set the speed of animations, in milliseconds.", "livemesh-el-addons"),
                "label" => __("Animation speed", "livemesh-el-addons"),
                'type' => Controls_Manager::NUMBER,
                'default' => 600,
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_widget_theme',
            [
                'label' => __('Widget Theme', 'livemesh-el-addons'),
                'tab' => Controls_Manager::TAB_STYLE,
                'show_label' => false,
            ]
        );

        $this->add_control(
            'toggle_dark_mode',
            [
                'label' => __( 'Dark Mode', 'elementor-pro' ),
                'description' => __('Enable dark mode when this widget is placed in those pages or sections/rows within a page that have a dark color (such as black) set as background color. ', 'livemesh-el-addons'),
                'type' => Controls_Manager::SWITCHER,
                'return_value' => 'dark-bg',
                'prefix_class' => 'lae-',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_styling',
            [
                'label' => __('Caption Heading', 'livemesh-el-addons'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'heading_tag',
            [
                'label' => __('Heading HTML Tag', 'livemesh-el-addons'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'h1' => __('H1', 'livemesh-el-addons'),
                    'h2' => __('H2', 'livemesh-el-addons'),
                    'h3' => __('H3', 'livemesh-el-addons'),
                    'h4' => __('H4', 'livemesh-el-addons'),
                    'h5' => __('H5', 'livemesh-el-addons'),
                    'h6' => __('H6', 'livemesh-el-addons'),
                    'div' => __('div', 'livemesh-el-addons'),
                ],
                'default' => 'h3',
            ]
        );

        $this->add_control(
            'heading_color',
            [
                'label' => __('Heading Color', 'livemesh-el-addons'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .lae-image-slider .lae-slide .lae-caption .lae-heading, {{WRAPPER}} .lae-image-slider .lae-slide .lae-caption .lae-heading a' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'heading_hover_color',
            [
                'label' => __('Heading Hover Color', 'livemesh-el-addons'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .lae-image-slider .lae-slide .lae-caption .lae-heading a:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'heading_hover_border_color',
            [
                'label' => __('Heading Hover Border Color', 'livemesh-el-addons'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .lae-image-slider .lae-slide .lae-caption .lae-heading a:hover' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'heading_typography',
                'label' => __('Typography', 'livemesh-el-addons'),
                'selector' => '{{WRAPPER}} .lae-image-slider .lae-slide .lae-caption .lae-heading',
            ]
        );

        $this->end_controls_section();


        $this->start_controls_section(
            'section_subheading',
            [
                'label' => __('Caption Subheading', 'livemesh-el-addons'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'subheading_color',
            [
                'label' => __('Color', 'livemesh-el-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lae-image-slider .lae-slide .lae-caption .lae-subheading' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'subheading_typography',
                'selector' => '{{WRAPPER}} .lae-image-slider .lae-slide .lae-caption .lae-subheading',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_button_styling',
            [
                'label' => __('Caption Button', 'livemesh-el-addons'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'button_padding',
            [
                'label' => __('Button Padding', 'livemesh-el-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .lae-image-slider .lae-slide .lae-caption .lae-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'isLinked' => false,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'button_typography',
                'label' => __('Typography', 'livemesh-el-addons'),
                'selector' => '{{WRAPPER}} .lae-image-slider .lae-slide .lae-caption .lae-button',
            ]
        );

        $this->end_controls_section();

    }

    /**
     * Render HTML widget output on the frontend.
     *
     * Written in PHP and used to generate the final HTML.
     *
     * @return void
     */
    protected function render() {

        $settings = $this->get_settings_for_display();

        $settings = apply_filters('lae_image_slider_' . $this->get_id() . '_settings', $settings);

        $args['settings'] = $settings;

        $args['widget_instance'] = $this;

        lae_get_template_part("premium/addons/image-slider/loop", $args);

    }

    /**
     * Render the widget output in the editor.
     * @return void
     */
    protected function content_template() {
    }

}