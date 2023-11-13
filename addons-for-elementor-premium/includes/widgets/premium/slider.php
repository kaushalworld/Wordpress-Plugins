<?php

/*
Widget Name: Slider
Description: Create a responsive slider of custom HTML content.
Author: LiveMesh
Author URI: https://www.livemeshthemes.com
*/

namespace LivemeshAddons\Widgets;

use Elementor\Repeater;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Scheme_Color;
use Elementor\Group_Control_Typography;
use Elementor\Scheme_Typography;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

/**
 * Class for Slider widget that lets you create a responsive slider of custom HTML content.
 */
class LAE_Slider_Widget extends LAE_Widget_Base {

    /**
     * Get the name for the widget
     * @return string
     */
    public function get_name() {
        return 'lae-slider';
    }

    /**
     * Get the widget title
     * @return string|void
     */
    public function get_title() {
        return __('Slider', 'livemesh-el-addons');
    }

    /**
     * Get the widget icon
     * @return string
     */
    public function get_icon() {
        return 'lae-icon-slider3';
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
        return 'https://livemeshelementor.com/docs/livemesh-addons/';
    }

    /**
     * Obtain the scripts required for the widget to function
     * @return string[]
     */
    public function get_script_depends() {
        return [
            'jquery-flexslider',
            'lae-frontend-scripts',
            'lae-slider-scripts'
        ];
    }

    /**
     * Register the controls for the widget
     * Adds fields that help configure and customize the widget
     * @return void
     */
    protected function register_controls() {

        $this->start_controls_section(
            'section_slider',
            [
                'label' => __('Slider', 'livemesh-el-addons'),
            ]
        );

        $this->add_control(

            'class', [
                'type' => Controls_Manager::TEXT,
                "description" => __("Set a unique CSS class for the slider. (optional).", "livemesh-el-addons"),
                "label" => __("Class", "livemesh-el-addons"),
                'prefix_class' => 'lae-slider-',
            ]
        );

        $this->add_control(
            'slider_heading',
            [
                'label' => __('HTML Slides', 'livemesh-el-addons'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $repeater = new Repeater();


        $repeater->add_control(
            'slide_title',
            [

                'type' => Controls_Manager::TEXT,
                'label' => __('Slide Title & HTML Content', 'livemesh-el-addons'),
                'default' => __('My slide title', 'livemesh-el-addons'),
                'description' => __('The title to identify the HTML slide', 'livemesh-el-addons'),
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'slide_content',
            [

                'label' => __('HTML Slide Content', 'livemesh-el-addons'),
                'type' => Controls_Manager::WYSIWYG,
                'default' => __('The HTML content for the slide', 'livemesh-el-addons'),
                'show_label' => false,
                'dynamic' => [
                    'active' => true,
                ],
            ]
        );

        $this->add_control(
            'slides',
            [
                'type' => Controls_Manager::REPEATER,
                'default' => [
                    [
                        'slide_title' => 'Aliquam lorem ante',
                        'slide_content' => 'Suspendisse potenti. Praesent ac sem eget est egestas volutpat. Fusce neque. In hac habitasse platea dictumst. Morbi nec metus.

Sed magna purus, fermentum eu, tincidunt eu, varius ut, felis. Phasellus leo dolor, tempus non, auctor et, hendrerit quis, nisi. Vestibulum volutpat pretium libero. Nullam accumsan lorem in dui. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas.

In consectetuer turpis ut velit. Phasellus leo dolor, tempus non, auctor et, hendrerit quis, nisi. Vivamus laoreet. Praesent ac massa at ligula laoreet iaculis. Cras non dolor.',
                    ],
                    [
                        'slide_title' => 'Pellentesque commodo eros',
                        'slide_content' => 'In hac habitasse platea dictumst. Ut a nisl id ante tempus hendrerit. Morbi mattis ullamcorper velit. Nullam sagittis. Sed a libero.

Donec mollis hendrerit risus. Curabitur ligula sapien, tincidunt non, euismod vitae, posuere imperdiet, leo. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Praesent egestas neque eu enim. Donec mollis hendrerit risus.

Donec orci lectus, aliquam ut, faucibus non, euismod id, nulla. Aenean imperdiet. Nulla consequat massa quis enim. Aenean imperdiet. Fusce commodo aliquam arcu.',
                    ],
                    [
                        'slide_title' => 'Aenean commodo ligula',
                        'slide_content' => 'Fusce convallis metus id felis luctus adipiscing. Suspendisse faucibus, nunc et pellentesque egestas, lacus ante convallis tellus, vitae iaculis lacus elit id tortor. Sed lectus. Etiam vitae tortor. Praesent adipiscing.

Sed in libero ut nibh placerat accumsan. Pellentesque ut neque. Donec id justo. Phasellus gravida semper nisi. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem.

Vestibulum dapibus nunc ac augue. Nam at tortor in tellus interdum sagittis. Maecenas tempus, tellus eget condimentum rhoncus, sem quam semper libero, sit amet adipiscing sem neque sed ipsum. Sed lectus. Quisque ut nisi.',
                    ],
                ],
                'fields' => $repeater->get_controls(),
                'title_field' => '{{{ slide_title }}}',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_settings',
            [
                'label' => __('Slider Settings', 'livemesh-el-addons'),
                'tab' => Controls_Manager::TAB_SETTINGS
            ]
        );


        $this->add_control(
            'slide_animation',
            [
                'label' => __('Animation', 'livemesh-el-addons'),
                'type' => Controls_Manager::SELECT,
                'default' => 'slide',
                'options' => [
                    'slide' => __('Slide', 'livemesh-el-addons'),
                    'fade' => __('Fade', 'livemesh-el-addons'),
                ],
            ]
        );

        $this->add_control(
            'direction',
            [
                'label' => __('Direction', 'livemesh-el-addons'),
                'type' => Controls_Manager::SELECT,
                'default' => 'horizontal',
                'options' => [
                    'horizontal' => __('Horizontal', 'livemesh-el-addons'),
                    'vertical' => __('Vertical', 'livemesh-el-addons'),
                ],
            ]
        );

        $this->add_control(
            'direction_nav',
            [
                'type' => Controls_Manager::SWITCHER,
                'label_off' => __('No', 'livemesh-el-addons'),
                'label_on' => __('Yes', 'livemesh-el-addons'),
                'return_value' => 'yes',
                'separator' => 'before',
                'default' => 'yes',
                'label' => __('Direction Navigation?', 'livemesh-el-addons'),
                'description' => __('Should the slider have direction navigation?', 'livemesh-el-addons'),
            ]
        );


        $this->add_control(
            'control_nav',
            [
                'type' => Controls_Manager::SWITCHER,
                'label_off' => __('No', 'livemesh-el-addons'),
                'label_on' => __('Yes', 'livemesh-el-addons'),
                'return_value' => 'yes',
                'default' => 'no',
                'label' => __('Navigation Controls?', 'livemesh-el-addons'),
                'description' => __('Should the slider have navigation controls?', 'livemesh-el-addons'),
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
                'label' => __('Pause on Hover?', 'livemesh-el-addons'),
                'description' => __('Should the slider pause on mouse hover over the slider.', 'livemesh-el-addons'),
            ]
        );

        $this->add_control(
            'pause_on_action',
            [
                'type' => Controls_Manager::SWITCHER,
                'label_off' => __('No', 'livemesh-el-addons'),
                'label_on' => __('Yes', 'livemesh-el-addons'),
                'return_value' => 'yes',
                'default' => 'no',
                'label' => __('Pause slider on action?', 'livemesh-el-addons'),
                'description' => __('Should the slideshow pause once user initiates an action using navigation/direction controls.', 'livemesh-el-addons'),
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
                'label' => __('Slideshow Speed', 'livemesh-el-addons'),
                'type' => Controls_Manager::NUMBER,
                'default' => 5000,
            ]
        );


        $this->add_control(
            'animation_speed',
            [
                'label' => __('Animation Speed', 'livemesh-el-addons'),
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
            'section_slider_style',
            [
                'label' => __('Slider', 'livemesh-el-addons'),
                'tab' => Controls_Manager::TAB_STYLE,
                'show_label' => false,
            ]
        );

        $this->add_control(
            'heading_content',
            [
                'label' => __('Content', 'livemesh-el-addons'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'after',
            ]
        );

        $this->add_control(
            'content_color',
            [
                'label' => __('Color', 'livemesh-el-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lae-slider .lae-slide' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'content_bg_color',
            [
                'label' => __('Background Color', 'livemesh-el-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lae-slider .lae-slide' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'content_typography',
                'selector' => '{{WRAPPER}} .lae-slider .lae-slide',
            ]
        );
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

        $settings = apply_filters('lae_slider_' . $this->get_id() . '_settings', $settings);

        $args['settings'] = $settings;

        $args['widget_instance'] = $this;

        lae_get_template_part("premium/addons/slider/loop", $args);

    }

    /**
     * Render the widget output in the editor.
     * @return void
     */
    protected function content_template() {
    }

}