<?php

/*
Widget Name: Tabs
Description: Display tabbed content in variety of styles.
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
use Elementor\Utils;
use Elementor\Icons_Manager;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

/**
 * Class for Tabs widget that displays tabbed content in variety of styles.
 */
class LAE_Tabs_Widget extends LAE_Widget_Base {

    /**
     * Get the name for the widget
     * @return string
     */
    public function get_name() {
        return 'lae-tabs';
    }

    /**
     * Get the widget title
     * @return string|void
     */
    public function get_title() {
        return __('Tabs', 'livemesh-el-addons');
    }

    /**
     * Get the widget icon
     * @return string
     */
    public function get_icon() {
        return 'lae-icon-tabs2';
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
        return 'https://livemeshelementor.com/docs/livemesh-addons/premium-addons/tabs-and-accordions/';
    }

    /**
     * Obtain the scripts required for the widget to function
     * @return string[]
     */
    public function get_script_depends() {
        return [
            'lae-frontend-scripts',
            'lae-tabs-scripts'
        ];
    }

    /**
     * Register the controls for the widget
     * Adds fields that help configure and customize the widget
     * @return void
     */
    protected function register_controls() {

        $this->start_controls_section(
            'section_tabs',
            [
                'label' => __('Tabs', 'livemesh-el-addons'),
            ]
        );

        $this->add_control(

            'style',
            [
                'type' => Controls_Manager::SELECT,
                'label' => __('Choose Style', 'livemesh-el-addons'),
                'default' => 'style1',
                'options' => [
                    'style1' => __('Tab Style 1', 'livemesh-el-addons'),
                    'style2' => __('Tab Style 2', 'livemesh-el-addons'),
                    'style3' => __('Tab Style 3', 'livemesh-el-addons'),
                    'style4' => __('Tab Style 4', 'livemesh-el-addons'),
                    'style5' => __('Tab Style 5', 'livemesh-el-addons'),
                    'style6' => __('Tab Style 6', 'livemesh-el-addons'),
                    'style7' => __('Vertical Tab Style 1', 'livemesh-el-addons'),
                    'style8' => __('Vertical Tab Style 2', 'livemesh-el-addons'),
                    'style9' => __('Vertical Tab Style 3', 'livemesh-el-addons'),
                    'style10' => __('Vertical Tab Style 4', 'livemesh-el-addons'),
                ],
            ]
        );

        $this->add_control(
            'mobile_width',
            [
                'label' => __('Mobile Resolution', 'livemesh-el-addons'),
                'description' => __('The device resolution at which the mobile view takes effect', 'livemesh-el-addons'),
                'type' => Controls_Manager::NUMBER,
                'default' => 767,
                'min' => 400,
                'max' => 1024,
                'step' => 5,
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'tab_id',
            [

                'label' => __('Tab ID', 'livemesh-el-addons'),
                'description' => __('The Tab ID is required to link to a tab. It must be unique across the page, must begin with a letter and may be followed by any number of letters, digits, hyphens or underscores.', 'livemesh-el-addons'),
                'type' => Controls_Manager::TEXT,
            ]
        );

        $repeater->add_control(
            'icon_type',
            [

                'label' => __('Tab Icon Type', 'livemesh-el-addons'),
                'type' => Controls_Manager::SELECT,
                'default' => 'none',
                'options' => [
                    'none' => __('None', 'livemesh-el-addons'),
                    'icon' => __('Icon', 'livemesh-el-addons'),
                    'icon_image' => __('Icon Image', 'livemesh-el-addons'),
                ],
            ]
        );

        $repeater->add_control(
            'icon_image',
            [

                'label' => __('Tab Image', 'livemesh-el-addons'),
                'type' => Controls_Manager::MEDIA,
                'default' => [
                    'url' => Utils::get_placeholder_image_src(),
                ],
                'label_block' => true,
                'condition' => [
                    'icon_type' => 'icon_image',
                ],
            ]
        );

        $repeater->add_control(
            'selected_icon',

            [

                'label' => __('Tab Icon', 'livemesh-el-addons'),
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
            'tab_title',
            [

                'label' => __('Tab Title & Content', 'livemesh-el-addons'),
                'type' => Controls_Manager::TEXT,
                'default' => __('Tab Title', 'livemesh-el-addons'),
                'label_block' => true,
                'dynamic' => [
                    'active' => true,
                ],
            ]
        );

        $repeater->add_control(
            'tab_content',
            [

                'label' => __('Tab Content', 'livemesh-el-addons'),
                'type' => Controls_Manager::WYSIWYG,
                'default' => __('Tabs Content', 'livemesh-el-addons'),
                'show_label' => false,
                'dynamic' => [
                    'active' => true,
                ],
            ]
        );

        $this->add_control(
            'tabs',
            [
                'label' => __('Tab Panes', 'livemesh-el-addons'),
                'type' => Controls_Manager::REPEATER,
                'separator' => 'before',
                'default' => [
                    [
                        'tab_title' => __('Tab #1', 'livemesh-el-addons'),
                        'tab_content' => __('I am tab content. Click edit button to change this text. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'livemesh-el-addons'),
                    ],
                    [
                        'tab_title' => __('Tab #2', 'livemesh-el-addons'),
                        'tab_content' => __('I am tab content. Click edit button to change this text. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'livemesh-el-addons'),
                    ],
                    [
                        'tab_title' => __('Tab #3', 'livemesh-el-addons'),
                        'tab_content' => __('I am tab content. Click edit button to change this text. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'livemesh-el-addons'),
                    ],
                ],
                'fields' => $repeater->get_controls(),
                'title_field' => '{{{ tab_title }}}',
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
            'section_tab_title',
            [
                'label' => __('Tab Title', 'livemesh-el-addons'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label' => __('Tab Title Color', 'livemesh-el-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lae-tabs .lae-tab-nav .lae-tab a' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'active_title_color',
            [
                'label' => __('Active Tab Title Color', 'livemesh-el-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lae-tabs .lae-tab-nav .lae-tab.lae-active a' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'hover_title_color',
            [
                'label' => __('Hover Tab Title Color', 'livemesh-el-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lae-tabs .lae-tab-nav .lae-tab:hover a' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'highlight_color',
            [
                'label' => __('Tab highlight Border color', 'livemesh-el-addons'),
                'type' => Controls_Manager::COLOR,
                'default' => '#f94213',
                'selectors' => [
                    '{{WRAPPER}}.lae-tabs-style4 .lae-tab-nav .lae-tab.lae-active:before' => 'background: {{VALUE}};',
                    '{{WRAPPER}}.lae-tabs-style4.lae-mobile-layout.lae-mobile-open .lae-tab.lae-active' => 'border-left-color: {{VALUE}};',
                    '{{WRAPPER}}.lae-tabs-style4.lae-mobile-layout.lae-mobile-open .lae-tab.lae-active' => 'border-right-color: {{VALUE}};',
                    '{{WRAPPER}}.lae-tabs-style6 .lae-tab-nav .lae-tab.lae-active a' => 'border-color: {{VALUE}};',
                    '{{WRAPPER}}.lae-tabs-style7 .lae-tab-nav .lae-tab.lae-active a' => 'border-color: {{VALUE}};',
                    '{{WRAPPER}}.lae-tabs-style8 .lae-tab-nav .lae-tab.lae-active a' => 'border-left-color: {{VALUE}};',
                ],
                'condition' => [
                    'style' => ['style4', 'style6', 'style7', 'style8'],
                ],
            ]
        );

        $this->add_control(
            'title_spacing',
            [
                'label' => __('Tab Title Padding', 'livemesh-el-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .lae-tabs .lae-tab-nav .lae-tab a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'isLinked' => false
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'selector' => '{{WRAPPER}} .lae-tabs .lae-tab-nav .lae-tab .lae-tab-title',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_tab_content',
            [
                'label' => __('Tab Content', 'livemesh-el-addons'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'content_spacing',
            [
                'label' => __('Tab Content Padding', 'livemesh-el-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .lae-tabs .lae-tab-panes .lae-tab-pane' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'isLinked' => false
            ]
        );
        $this->add_control(
            'content_color',
            [
                'label' => __('Color', 'livemesh-el-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lae-tabs .lae-tab-panes .lae-tab-pane' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'content_typography',
                'selector' => '{{WRAPPER}} .lae-tabs .lae-tab-panes .lae-tab-pane',
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
                'label' => __('Icon or Icon Image size in pixels', 'livemesh-el-addons'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'em'],
                'range' => [
                    'px' => [
                        'min' => 10,
                        'max' => 256,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .lae-tabs .lae-tab-nav .lae-tab .lae-image-wrapper img' => 'width: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .lae-tabs .lae-tab-nav .lae-tab .lae-icon-wrapper i' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'icon_color',
            [
                'label' => __('Icon Color', 'livemesh-el-addons'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .lae-tabs .lae-tab-nav .lae-tab .lae-icon-wrapper i' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'active_icon_color',
            [
                'label' => __('Active Tab Icon Color', 'livemesh-el-addons'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .lae-tabs .lae-tab-nav .lae-tab.lae-active .lae-icon-wrapper i' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'hover_icon_color',
            [
                'label' => __('Hover Tab Icon Color', 'livemesh-el-addons'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .lae-tabs .lae-tab-nav .lae-tab .lae-icon-wrapper:hover i' => 'color: {{VALUE}};',
                ],
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

        $settings = apply_filters('lae_tabs_' . $this->get_id() . '_settings', $settings);

        $args['settings'] = $settings;

        $args['widget_instance'] = $this;

        lae_get_template_part("premium/addons/tabs/loop", $args);

    }

    /**
     * Render the widget output in the editor.
     * @return void
     */
    protected function content_template() {

    }

}