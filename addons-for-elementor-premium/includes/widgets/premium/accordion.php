<?php

/*
Widget Name: Accordion
Description: Displays collapsible content panels to help display information when space is limited.
Author: LiveMesh
Author URI: https://www.livemeshthemes.com
*/

namespace LivemeshAddons\Widgets;

use Elementor\Repeater;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Scheme_Color;
use Elementor\Scheme_Typography;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

/**
 * Class for Accordion widget that displays collapsible content panels to help display information when space is limited.
 */
class LAE_Accordion_Widget extends LAE_Widget_Base {

    /**
     * Get the name for the widget
     * @return string
     */
    public function get_name() {
        return 'lae-accordion';
    }

    /**
     * Get the widget title
     * @return string|void
     */
    public function get_title() {
        return __('Accordion', 'livemesh-el-addons');
    }

    /**
     * Get the widget icon
     * @return string
     */
    public function get_icon() {
        return 'eicon-select';
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
            'lae-accordion-scripts',
            'lae-frontend-scripts'
        ];
    }

    /**
     * Register the controls for the widget
     * Adds fields that help configure and customize the widget
     * @return void
     */
    protected function register_controls() {

        $this->start_controls_section(
            'section_accordion',
            [
                'label' => __('Accordion', 'livemesh-el-addons'),
            ]
        );

        $this->add_control(

            'style', [
                'type' => Controls_Manager::SELECT,
                'label' => __('Choose Style', 'livemesh-el-addons'),
                'default' => 'style1',
                'options' => [
                    'style1' => __('Style 1', 'livemesh-el-addons'),
                    'style2' => __('Style 2', 'livemesh-el-addons'),
                    'style3' => __('Style 3', 'livemesh-el-addons'),
                ],
                'prefix_class' => 'lae-accordion-',
            ]
        );

        $this->add_control(

            'toggle', [
                'type' => Controls_Manager::SWITCHER,
                'label_off' => __('No', 'livemesh-el-addons'),
                'label_on' => __('Yes', 'livemesh-el-addons'),
                'label' => __('Allow to function like toggle?', 'livemesh-el-addons'),
            ]
        );


        $this->add_control(

            'expanded', [
                'type' => Controls_Manager::SWITCHER,
                'label_off' => __('No', 'livemesh-el-addons'),
                'label_on' => __('Yes', 'livemesh-el-addons'),
                'label' => __('Start expanded?', 'livemesh-el-addons'),
                'condition' => [
                    'toggle' => 'yes',
                ],
            ]
        );

        $repeater = new Repeater();


        $repeater->add_control(
            'panel_id',
            [

                'label' => __('Panel ID', 'livemesh-el-addons'),
                'description' => __('The Panel ID is required to link to a panel. It must be unique across the page, must begin with a letter and may be followed by any number of letters, digits, hyphens or underscores.', 'livemesh-el-addons'),
                'type' => Controls_Manager::TEXT,
            ]
        );

        $repeater->add_control(
            'panel_title',
            [

                'label' => __('Panel Title & Content', 'livemesh-el-addons'),
                'type' => Controls_Manager::TEXT,
                'default' => __('Accordion Title', 'livemesh-el-addons'),
                'label_block' => true,
                'dynamic' => [
                    'active' => true,
                ],
            ]
        );

        $repeater->add_control(
            'panel_content',
            [

                'label' => __('Panel Content', 'livemesh-el-addons'),
                'type' => Controls_Manager::WYSIWYG,
                'default' => __('Accordion Content', 'livemesh-el-addons'),
                'show_label' => false,
                'dynamic' => [
                    'active' => true,
                ],
            ]
        );

        $this->add_control(
            'panels',
            [
                'label' => __('Accordion Items', 'livemesh-el-addons'),
                'type' => Controls_Manager::REPEATER,
                'separator' => 'before',
                'default' => [
                    [
                        'panel_title' => __('Accordion Panel #1', 'livemesh-el-addons'),
                        'panel_content' => __('I am item content. Click edit button to change this text. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'livemesh-el-addons'),
                    ],
                    [
                        'panel_title' => __('Accordion Panel #2', 'livemesh-el-addons'),
                        'panel_content' => __('I am item content. Click edit button to change this text. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'livemesh-el-addons'),
                    ],
                ],
                'fields' => $repeater->get_controls(),
                'title_field' => '{{{ panel_title }}}',
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
            'section_accordion_style',
            [
                'label' => __('Accordion', 'livemesh-el-addons'),
                'tab' => Controls_Manager::TAB_STYLE,
                'show_label' => false,
            ]
        );


        $this->add_control(
            'heading_title',
            [
                'label' => __('Title', 'livemesh-el-addons'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'after',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'selector' => '{{WRAPPER}} .lae-accordion .lae-panel-title',
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
                    '{{WRAPPER}} .lae-accordion .lae-panel-content' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'content_typography',
                'selector' => '{{WRAPPER}} .lae-accordion .lae-panel-content',
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

        $settings = apply_filters('lae_accordion_' . $this->get_id() . '_settings', $settings);

        $args['settings'] = $settings;

        $args['widget_instance'] = $this;

        lae_get_template_part("premium/addons/accordion/loop", $args);

    }

    /**
     * Render the widget output in the editor.
     * @return void
     */
    protected function content_template() {

    }

}