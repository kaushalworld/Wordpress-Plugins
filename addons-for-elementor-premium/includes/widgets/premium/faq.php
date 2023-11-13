<?php

/*
Widget Name: FAQ
Description: Create a responsive faq of custom HTML content.
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
 * Class for FAQ widget that displays a responsive faq of custom HTML content.
 */
class LAE_FAQ_Widget extends LAE_Widget_Base {

    /**
     * Get the name for the widget
     * @return string
     */
    public function get_name() {
        return 'lae-faq';
    }

    /**
     * Get the widget title
     * @return string|void
     */
    public function get_title() {
        return __('FAQ', 'livemesh-el-addons');
    }

    /**
     * Get the widget icon
     * @return string
     */
    public function get_icon() {
        return 'lae-icon-faq';
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
        return 'https://livemeshelementor.com/docs/livemesh-addons/premium-addons/faq-addon/';
    }

    /**
     * Obtain the scripts required for the widget to function
     * @return string[]
     */
    public function get_script_depends() {
        return [
            'lae-waypoints',
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
            'section_faq',
            [
                'label' => __('FAQ', 'livemesh-el-addons'),
            ]
        );


        $this->add_control(
            'faq_heading',
            [
                'label' => __('FAQ Items', 'livemesh-el-addons'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'question',
            [
                'label' => __('Question & Answer', 'livemesh-el-addons'),
                'default' => __('My question', 'livemesh-el-addons'),
                'type' => Controls_Manager::TEXT,
                'label_block' => true,
                'dynamic' => [
                    'active' => true,
                ],
            ]
        );

        $repeater->add_control(
            'answer',
            [
                'label' => __('Answer', 'livemesh-el-addons'),
                'description' => __('The HTML content as answer for the FAQ item.', 'livemesh-el-addons'),
                'type' => Controls_Manager::WYSIWYG,
                'default' => __('The HTML content as answer for the FAQ item.', 'livemesh-el-addons'),
                'show_label' => false,
                'dynamic' => [
                    'active' => true,
                ],
            ]
        );

        $repeater->add_control(
            "widget_animation",
            [
                "type" => Controls_Manager::SELECT,

                "label" => __("Animation Type", "livemesh-el-addons"),
                'options' => lae_get_animation_options(),
                'default' => 'none',
            ]
        );

        $this->add_control(
            'faq_list',
            [
                'type' => Controls_Manager::REPEATER,
                'default' => [
                    [
                        'question' => 'Nam commodo suscipit quam?',
                        'answer' => 'Curabitur ligula sapien, tincidunt non, euismod vitae, posuere imperdiet, leo. Donec venenatis vulputate lorem. In hac habitasse aliquam.',
                    ],
                    [
                        'question' => 'Morbi mattis ullamcorper velit?',
                        'answer' => 'Suspendisse nisl elit, rhoncus eget, elementum ac, condimentum eget, diam. Phasellus nec sem in justo pellentesque facilisis platea dictumst.',
                    ],
                    [
                        'question' => 'Phasellus leo dolor, tempus non?',
                        'answer' => 'Nunc egestas, augue at pellentesque laoreet, felis eros vehicula leo, at malesuada velit leo quis pede. Etiam ut purus mattis mauris sodales.',
                    ],
                    [
                        'question' => 'Donec quam felis, ultricies nec?',
                        'answer' => 'Proin viverra, ligula sit amet ultrices semper, ligula arcu tristique sapien, a accumsan nisi mauris ac eros. Nullam tincidunt adipiscing enim.',
                    ],
                ],
                'fields' => $repeater->get_controls(),
                'title_field' => '{{{ question }}}',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_grid_settings',
            [
                'label' => __('Grid Settings', 'livemesh-el-addons'),
                'tab' => Controls_Manager::TAB_SETTINGS,
            ]
        );

        $this->add_control(
            'column_layout',
            [
                'label' => __('Column Layout', 'livemesh-el-addons'),
                'type' => Controls_Manager::SELECT,
                'options' => array(
                    'auto' => __('Auto', 'livemesh-el-addons'),
                    'custom' => __('Custom', 'livemesh-el-addons'),
                ),
                'default' => 'auto',
                'description' => __('Set column layout to be <strong>Auto</strong> to let the widget auto calculate number of columns based on minimum column size specified. The option <strong>Custom</strong> lets you explicitly control number of columns based on screen width.', 'livemesh-el-addons'),
            ]
        );

        $this->add_control(
            'min_column_size',
            [
                'label' => __('Minimum Column Size', 'livemesh-el-addons'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'default' => [
                    'size' => 500,
                ],
                'range' => [
                    'px' => [
                        'min' => 50,
                        'max' => 1000,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .lae-uber-grid-container.lae-grid-auto-column-layout' => 'grid-template-columns: repeat(auto-fit, minmax({{SIZE}}{{UNIT}}, 1fr));',
                ],
                'condition' => [
                    'column_layout' => 'auto'
                ]
            ]
        );

        $this->add_responsive_control(
            'per_line',
            [
                'label' => __('Columns per row', 'livemesh-el-addons'),
                'type' => Controls_Manager::SELECT,
                'default' => '2',
                'tablet_default' => '1',
                'mobile_default' => '1',
                'options' => [
                    '1' => '1',
                    '2' => '2',
                    '3' => '3',
                ],
                'frontend_available' => true,
                'condition' => [
                    'column_layout' => 'custom'
                ]
            ]
        );

        $this->add_control(
            'column_gap',
            [
                'label' => __('Column Gap', 'livemesh-el-addons'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'default' => [
                    'size' => 30,
                ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .lae-uber-grid-container' => 'column-gap: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'row_gap',
            [
                'label' => __('Row Gap', 'livemesh-el-addons'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'default' => [
                    'size' => 30,
                ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .lae-uber-grid-container' => 'row-gap: {{SIZE}}{{UNIT}};',
                ],
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
            'section_faq_style',
            [
                'label' => __('FAQ', 'livemesh-el-addons'),
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

        $this->add_control(
            'title_tag',
            [
                'label' => __('Title HTML Tag', 'livemesh-el-addons'),
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
            'title_color',
            [
                'label' => __('Color', 'livemesh-el-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lae-faq-list .lae-faq-item .lae-faq-question' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'selector' => '{{WRAPPER}} .lae-faq-list .lae-faq-item .lae-faq-question',
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
                    '{{WRAPPER}} .lae-faq-list .lae-faq-item .lae-faq-answer' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'content_typography',
                'selector' => '{{WRAPPER}} .lae-faq-list .lae-faq-item .lae-faq-answer',
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

        $settings = apply_filters('lae_faq_' . $this->get_id() . '_settings', $settings);

        $args['settings'] = $settings;

        $args['widget_instance'] = $this;

        lae_get_template_part("premium/addons/faq/loop", $args);

    }

    /**
     * Render the widget output in the editor.
     * @return void
     */
    protected function content_template() {
    }

}