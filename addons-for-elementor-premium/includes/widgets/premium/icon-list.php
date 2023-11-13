<?php

/*
Widget Name: Icon List
Description: Use images or icon fonts to create social icons list, show payment options etc.
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
use Elementor\Scheme_Typography;
use Elementor\Icons_Manager;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

/**
 * Class for Icon List widget that can use images or icon fonts to create social icons list, show payment options etc.
 */
class LAE_Icon_List_Widget extends LAE_Widget_Base {

    /**
     * Get the name for the widget
     * @return string
     */
    public function get_name() {
        return 'lae-icon-list';
    }

    /**
     * Get the widget title
     * @return string|void
     */
    public function get_title() {
        return __('Icon List', 'livemesh-el-addons');
    }

    /**
     * Get the widget icon
     * @return string
     */
    public function get_icon() {
        return 'eicon-form-vertical';
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
        return 'https://livemeshelementor.com/docs/livemesh-addons/premium-addons/icon-list/';
    }

    /**
     * Obtain the scripts required for the widget to function
     * @return string[]
     */
    public function get_script_depends() {
        return [
            'lae-waypoints',
            'jquery-powertip',
            'lae-frontend-scripts',
            'lae-icon-list-scripts'
        ];
    }

    /**
     * Register the controls for the widget
     * Adds fields that help configure and customize the widget
     * @return void
     */
    protected function register_controls() {

        $this->start_controls_section(
            'section_icon_list',
            [
                'label' => __('Icon List', 'livemesh-el-addons'),
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'icon_title',
            [

                'label' => __('Icon Title', 'livemesh-el-addons'),
                'default' => __('My icon title', 'livemesh-el-addons'),
                'type' => Controls_Manager::TEXT,
                'dynamic' => [
                    'active' => true,
                ],
            ]
        );

        $repeater->add_control(
            'icon_type',
            [

                'label' => __('Icon Type', 'livemesh-el-addons'),
                'type' => Controls_Manager::SELECT,
                'default' => 'icon',
                'options' => [
                    'icon' => __('Icon', 'livemesh-el-addons'),
                    'icon_image' => __('Icon Image', 'livemesh-el-addons'),
                ],
            ]
        );

        $repeater->add_control(
            'icon_image',
            [

                'label' => __('Icon Image', 'livemesh-el-addons'),
                'type' => Controls_Manager::MEDIA,
                'default' => [
                    'url' => Utils::get_placeholder_image_src(),
                ],
                'label_block' => true,
                'condition' => [
                    'icon_type' => 'icon_image',
                ],
                'dynamic' => [
                    'active' => true,
                ],
            ]
        );

        $repeater->add_control(
            'selected_icon',

            [

                'label' => __('Icon', 'livemesh-el-addons'),
                'type' => Controls_Manager::ICONS,
                'label_block' => true,
                'default' => [
                    'value' => 'fas fa-home',
                    'library' => 'fa-solid',
                ],
                'condition' => [
                    'icon_type' => 'icon',
                ],
                'fa4compatibility' => 'icon',
            ]
        );

        $repeater->add_control(
            'href',
            [

                'label' => __('Link', 'livemesh-el-addons'),
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

        $this->add_control(
            'icon_list',
            [
                'type' => Controls_Manager::REPEATER,
                'default' => [
                    [
                        'icon_title' => __('Facebook', 'livemesh-el-addons'),
                        'icon_type' => 'icon',
                        'selected_icon' => [
                            'value' => 'fab fa-facebook-f',
                            'library' => 'fa-brands',
                        ],
                        'href' => ['url' => 'http://facebook.com', 'is_external' => true]
                    ],
                    [
                        'icon_title' => __('Twitter', 'livemesh-el-addons'),
                        'icon_type' => 'icon',
                        'selected_icon' => [
                            'value' => 'fab fa-twitter',
                            'library' => 'fa-brands',
                        ],
                        'href' => ['url' => 'http://twitter.com', 'is_external' => true]
                    ],
                    [
                        'icon_title' => __('Linkedin', 'livemesh-el-addons'),
                        'icon_type' => 'icon',
                        'selected_icon' => [
                            'value' => 'fab fa-linkedin-in',
                            'library' => 'fa-brands',
                        ],
                        'href' => ['url' => 'http://linkedin.com', 'is_external' => true]
                    ],
                    [
                        'icon_title' => __('Google Plus', 'livemesh-el-addons'),
                        'icon_type' => 'icon',
                        'selected_icon' => [
                            'value' => 'fab fa-google-plus-g',
                            'library' => 'fa-brands',
                        ],
                        'href' => ['url' => 'http://linkedin.com', 'is_external' => true]
                    ],
                    [
                        'icon_title' => __('Dribbble', 'livemesh-el-addons'),
                        'icon_type' => 'icon',
                        'selected_icon' => [
                            'value' => 'fab fa-dribbble',
                            'library' => 'fa-brands',
                        ],
                        'href' => ['url' => 'http://dribbble.com', 'is_external' => true]
                    ],
                ],
                'fields' => $repeater->get_controls(),
                'title_field' => '{{{ icon_title }}}',
            ]
        );

        $this->add_control(
            'heading_settings',
            [
                'label' => __('Settings', 'livemesh-el-addons'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'align',
            [
                'label' => __('Alignment', 'livemesh-el-addons'),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => __('Left', 'livemesh-el-addons'),
                        'icon' => 'fa fa-align-left',
                    ],
                    'center' => [
                        'title' => __('Center', 'livemesh-el-addons'),
                        'icon' => 'fa fa-align-center',
                    ],
                    'right' => [
                        'title' => __('Right', 'livemesh-el-addons'),
                        'icon' => 'fa fa-align-right',
                    ],
                    'justify' => [
                        'title' => __('Justified', 'livemesh-el-addons'),
                        'icon' => 'fa fa-align-justify',
                    ],
                ],
                'default' => 'center',
                'selectors' => [
                    '{{WRAPPER}} .lae-icon-list' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'widget_animation',
            [
                "type" => Controls_Manager::SELECT,
                "label" => __("Animation Type", "livemesh-el-addons"),
                'options' => lae_get_animation_options(),
                'default' => 'none',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_icon_styling',
            [
                'label' => __('Icons', 'livemesh-el-addons'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'icon_size',
            [
                'label' => __('Icon/Image size in pixels', 'livemesh-el-addons'),
                'type' => Controls_Manager::NUMBER,
                'min' => 1,
                'max' => 128,
                'step' => 1,
                'default' => 32,
                'selectors' => [
                    '{{WRAPPER}} .lae-icon-list-item .lae-image-wrapper img' => 'width: {{VALUE}}px;',
                    '{{WRAPPER}} .lae-icon-list-item .lae-icon-wrapper i' => 'font-size: {{VALUE}}px;',
                ],
            ]
        );

        $this->add_control(
            'icon_spacing',
            [
                'label' => __('Spacing', 'livemesh-el-addons'),
                'description' => __('Space between icons.', 'livemesh-el-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'default' => [
                    'top' => 0,
                    'right' => 15,
                    'bottom' => 0,
                    'left' => 0,
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .lae-icon-list .lae-icon-list-item:not(:first-child)' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'isLinked' => false
            ]
        );

        $this->add_control(
            'icon_color',
            [
                'label' => __('Icon Color', 'livemesh-el-addons'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .lae-icon-list-item .lae-icon-wrapper i' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'hover_color',
            [
                'label' => __('Icon Hover Color', 'livemesh-el-addons'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .lae-icon-list-item .lae-icon-wrapper i:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_tooltip_styling',
            [
                'label' => __('Tooltip', 'livemesh-el-addons'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'tooltip_bg_color',
            [
                'label' => __('Tooltip Background Color', 'livemesh-el-addons'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '#powerTip' => 'background-color: {{VALUE}};',
                    '#powerTip.n:before' => 'border-top-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'tooltip_color',
            [
                'label' => __('Tooltip Color', 'livemesh-el-addons'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '#powerTip' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'tooltip_padding',
            [
                'label' => __('Padding', 'livemesh-el-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'default' => [
                    'top' => 10,
                    'right' => 10,
                    'bottom' => 10,
                    'left' => 10,
                    'unit' => 'px',
                ],
                'selectors' => [
                    '#powerTip' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'isLinked' => true
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'tooltip_typography',
                'label' => __('Typography', 'livemesh-el-addons'),
                'selector' => '#powerTip',
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

        $settings = apply_filters('lae_icon_list_' . $this->get_id() . '_settings', $settings);

        $args['settings'] = $settings;

        $args['widget_instance'] = $this;

        lae_get_template_part("premium/addons/icon-list/loop", $args);
    }

    /**
     * Render the widget output in the editor.
     * @return void
     */
    protected function content_template() {
    }

}