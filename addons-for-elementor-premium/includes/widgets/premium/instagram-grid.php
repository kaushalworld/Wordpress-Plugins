<?php

/*
Widget Name: Instagram Grid
Description: Display Instagram posts in a multi-column grid.
Author: LiveMesh
Author URI: https://www.livemeshthemes.com
*/


namespace LivemeshAddons\Widgets;

use LivemeshAddons\Blocks\LAE_Blocks_Manager;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

/**
 * Class for Instagram widget that displays Instagram posts in a multi-column grid.
 */
class LAE_Instagram_Grid_Widget extends LAE_Widget_Base {

    static public $instagram_grid_counter = 0;

    /**
     * Get the name for the widget
     * @return string
     */
    public function get_name() {
        return 'lae-instagram-grid';
    }

    /**
     * Get the widget title
     * @return string|void
     */
    public function get_title() {
        return __('Instagram Grid', 'livemesh-el-addons');
    }

    /**
     * Get the widget icon
     * @return string
     */
    public function get_icon() {
        return 'lae-icon-instagram-grid';
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
            'isotope.pkgd',
            'imagesloaded.pkgd',
            'jquery-fancybox',
            'lae-frontend-scripts',
            'lae-blocks-scripts',
            'lae-instagram-grid-scripts'
        ];
    }

    /**
     * Register the controls for the widget
     * Adds fields that help configure and customize the widget
     * @return void
     */
    protected function register_controls() {

        $this->start_controls_section(
            'section_instagram_grid',
            [
                'label' => __('Instagram Grid', 'livemesh-el-addons'),
            ]
        );

        $this->add_control(
            'instagram_grid_class', [
                'type' => Controls_Manager::TEXT,
                "description" => __("Specify an unique identifier used as a custom CSS class name and lightbox group name/slug for the grid element.", "livemesh-el-addons"),
                "label" => __("Instagram Grid Class/Identifier", "livemesh-el-addons"),
                'default' => ''
            ]
        );

        $this->add_control(
            'instagram_usernames',
            [
                'type' => Controls_Manager::TEXT,
                'label' => __('Instagram User Name(s)', 'livemesh-el-addons'),
                'description' => __('FFor multiple usernames, please separate them by a comma (e.g.: username1, username2, username3, ...))', 'livemesh-el-addons'),
                'default' => ''
            ]
        );


        $this->add_control(
            'instagram_hashtags',
            [
                'type' => Controls_Manager::TEXT,
                'label' => __('Instagram Hash Tag(s)', 'livemesh-el-addons'),
                'description' => __('For multiple hash tags, please separate them by a comma (e.g.: hashtag1, hashtag2, hashtag3, ...)', 'livemesh-el-addons'),
                'default' => ''
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_settings',
            [
                'label' => __('General', 'livemesh-el-addons'),
                'tab' => Controls_Manager::TAB_SETTINGS,
            ]
        );

        $this->add_control(
            'block_type',
            [
                'type' => Controls_Manager::SELECT,
                'label' => __('Choose Grid Style', 'livemesh-el-addons'),
                'options' => array(
                    'block_instagram_grid_1' => __('Instagram Grid - Default Style', 'livemesh-el-addons'),
                    'block_instagram_grid_2' => __('Instagram Grid - Packed Style', 'livemesh-el-addons'),
                    'block_instagram_grid_3' => __('Instagram Grid - Card Style', 'livemesh-el-addons'),
                ),
                'default' => 'block_instagram_grid_1',
            ]
        );

        $this->add_responsive_control(
            'per_line',
            [
                'label' => __( 'Columns', 'livemesh-el-addons' ),
                'type' => Controls_Manager::SELECT,
                'default' => '3',
                'tablet_default' => '2',
                'mobile_default' => '1',
                'options' => [
                    '1' => '1',
                    '2' => '2',
                    '3' => '3',
                    '4' => '4',
                    '5' => '5',
                    '6' => '6',
                ],
                'frontend_available' => true,
            ]
        );

        $this->add_control(
            'items_per_page',
            [
                'label' => __('Number of posts to be displayed.', 'livemesh-el-addons'),
                'type' => Controls_Manager::NUMBER,
                'min' => 3,
                'max' => 12,
                'step' => 1,
                'default' => 9,
            ]
        );

        $this->add_control(
            'layout_mode',
            [
                'type' => Controls_Manager::SELECT,
                'label' => __('Choose a layout for the Instagram grid', 'livemesh-el-addons'),
                'options' => array(
                    'masonry' => __('Masonry', 'livemesh-el-addons'),
                    'fitRows' => __('Fit Rows', 'livemesh-el-addons'),
                ),
                'default' => 'masonry',
            ]
        );

        $this->add_control(
            'image_linkable',
            [
                'label' => __('Link Images to Posts on Instagram website?', 'livemesh-el-addons'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'livemesh-el-addons'),
                'label_off' => __('No', 'livemesh-el-addons'),
                'return_value' => 'yes',
                'default' => '',
            ]
        );

        $this->add_control(
            'post_link_new_window',
            [
                'label' => __('Open post links in new window?', 'livemesh-el-addons'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'livemesh-el-addons'),
                'label_off' => __('No', 'livemesh-el-addons'),
                'return_value' => 'yes',
                'default' => '',
            ]
        );

        $this->add_control(
            'display_header',
            [
                'label' => __('Display banner header for the Instagram user?', 'livemesh-el-addons'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'livemesh-el-addons'),
                'label_off' => __('No', 'livemesh-el-addons'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_post_data',
            [
                'label' => __('Post Content', 'livemesh-el-addons'),
                'tab' => Controls_Manager::TAB_SETTINGS,
            ]
        );

        $this->add_control(
            'display_avatar',
            [
                'label' => __('Display user avatar for each instagram post?', 'livemesh-el-addons'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'livemesh-el-addons'),
                'label_off' => __('No', 'livemesh-el-addons'),
                'return_value' => 'yes',
                'default' => 'yes',
                'condition' => [
                    'block_type' => ['block_instagram_grid_1', 'block_instagram_grid_3']
                ],
            ]
        );

        $this->add_control(
            'display_username',
            [
                'label' => __('Display username for each instagram post?', 'livemesh-el-addons'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'livemesh-el-addons'),
                'label_off' => __('No', 'livemesh-el-addons'),
                'return_value' => 'yes',
                'default' => 'yes',
                'condition' => [
                    'block_type' => ['block_instagram_grid_1', 'block_instagram_grid_3']
                ],
            ]
        );

        $this->add_control(
            'display_name',
            [
                'label' => __('Display account name for each instagram post?', 'livemesh-el-addons'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'livemesh-el-addons'),
                'label_off' => __('No', 'livemesh-el-addons'),
                'return_value' => 'yes',
                'condition' => [
                    'block_type' => ['block_instagram_grid_1', 'block_instagram_grid_3']
                ],
            ]
        );

        $this->add_control(
            'display_date',
            [
                'label' => __('Display posted date for the instagram post?', 'livemesh-el-addons'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'livemesh-el-addons'),
                'label_off' => __('No', 'livemesh-el-addons'),
                'return_value' => 'yes',
                'default' => 'yes',
                'condition' => [
                    'block_type' => ['block_instagram_grid_1', 'block_instagram_grid_3']
                ],
            ]
        );

        $this->add_control(
            'date_format',
            [
                'type' => Controls_Manager::SELECT,
                'label' => __('Date Format', 'livemesh-el-addons'),
                'description' => __('The Standard format is derived from site-wide format specified in Settings->General.', 'livemesh-el-addons'),
                'options' => array(
                    'elapsed_time' => __('Elapsed Time', 'livemesh-el-addons'),
                    'standard_date' => __('Standard Date', 'livemesh-el-addons'),
                    'standard_date_time' => __('Standard Date and Time', 'livemesh-el-addons'),
                ),
                'default' => 'elapsed_time',
                'condition' => [
                    'display_date' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'display_comments',
            [
                'label' => __('Display comments number for each instagram post?', 'livemesh-el-addons'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'livemesh-el-addons'),
                'label_off' => __('No', 'livemesh-el-addons'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'display_likes',
            [
                'label' => __('Display likes (views for videos) for the instagram post?', 'livemesh-el-addons'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'livemesh-el-addons'),
                'label_off' => __('No', 'livemesh-el-addons'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'display_read_more',
            [
                'label' => __('Display link to the instagram post?', 'livemesh-el-addons'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'livemesh-el-addons'),
                'label_off' => __('No', 'livemesh-el-addons'),
                'return_value' => 'yes',
                'default' => 'yes',
                'condition' => [
                    'block_type' => ['block_instagram_grid_1', 'block_instagram_grid_3']
                ],
            ]
        );

        $this->add_control(
            'read_more_text',
            [
                'label' => __('Read More text', 'livemesh-el-addons'),
                'type' => Controls_Manager::TEXT,
                "description" => __('Specify the text for the read more link/button', 'livemesh-el-addons'),
                'default' => __('Read More', 'livemesh-el-addons'),
                'condition' => [
                    'block_type' => ['block_instagram_grid_1', 'block_instagram_grid_3']
                ],
            ]
        );

        $this->add_control(
            'lightbox_read_more_text',
            [
                'label' => __('Lightbox Read More text', 'livemesh-el-addons'),
                'type' => Controls_Manager::TEXT,
                "description" => __('Specify the text for the read more link in the lightbox popup. Leave blank to not display the link.', 'livemesh-el-addons'),
                'default' => __('Read More', 'livemesh-el-addons'),
            ]
        );


        $this->add_control(
            'display_excerpt',
            [
                'label' => __('Display excerpt for the Instagram post?', 'livemesh-el-addons'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'livemesh-el-addons'),
                'label_off' => __('No', 'livemesh-el-addons'),
                'return_value' => 'yes',
                'default' => 'yes',
                'condition' => [
                    'block_type' => ['block_instagram_grid_1', 'block_instagram_grid_3']
                ],
            ]
        );

        $this->add_control(
            'excerpt_length',
            [
                'label' => __('Excerpt length in number of words.', 'livemesh-el-addons'),
                'type' => Controls_Manager::NUMBER,
                'min' => 5,
                'max' => 250,
                'step' => 1,
                'default' => 50,
                'condition' => [
                    'display_excerpt' => 'yes'
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_lightbox',
            [
                'label' => __('Lightbox', 'livemesh-el-addons'),
                'tab' => Controls_Manager::TAB_SETTINGS,
            ]
        );

        $this->add_control(
            'enable_lightbox',
            [
                'type' => Controls_Manager::SWITCHER,
                'label_off' => __('No', 'livemesh-el-addons'),
                'label_on' => __('Yes', 'livemesh-el-addons'),
                'return_value' => 'yes',
                'default' => 'yes',
                'label' => __('Enable Lightbox Instagram Grid?', 'livemesh-el-addons'),
            ]
        );

        $this->add_control(
            'lightbox_library',
            [
                'type' => Controls_Manager::SELECT,
                'label' => __('Lightbox Library', 'livemesh-el-addons'),
                'description' => __('Choose the preferred library for the lightbox', 'livemesh-el-addons'),
                'options' => array(
                    'fancybox' => __('Fancybox', 'livemesh-el-addons'),
                    'elementor' => __('Elementor', 'livemesh-el-addons'),
                ),
                'default' => 'fancybox',
                'condition' => [
                    'enable_lightbox' => 'yes',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_responsive',
            [
                'label' => __('Gutter Options', 'livemesh-el-addons'),
                'tab' => Controls_Manager::TAB_SETTINGS,
            ]
        );

        $this->add_control(
            'heading_desktop',
            [
                'label' => __( 'Desktop', 'livemesh-el-addons' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'after',
            ]
        );


        $this->add_control(
            'gutter',
            [
                'label' => __('Gutter', 'livemesh-el-addons'),
                'description' => __('Space between columns in the grid.', 'livemesh-el-addons'),
                'type' => Controls_Manager::NUMBER,
                'default' => 20,
                'selectors' => [
                    '{{WRAPPER}} .lae-block .lae-block-inner' => 'margin-left: -{{VALUE}}px; margin-right: -{{VALUE}}px;',
                    '{{WRAPPER}} .lae-block .lae-block-inner .lae-block-column' => 'padding: {{VALUE}}px;',
                ]
            ]
        );

        $this->add_control(
            'heading_tablet',
            [
                'label' => __( 'Tablet', 'livemesh-el-addons' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'after',
            ]
        );


        $this->add_control(
            'tablet_gutter',
            [
                'label' => __('Gutter', 'livemesh-el-addons'),
                'description' => __('Space between columns.', 'livemesh-el-addons'),
                'type' => Controls_Manager::NUMBER,
                'default' => 10,
                'selectors' => [
                    '(tablet-){{WRAPPER}} .lae-block .lae-block-inner' => 'margin-left: -{{VALUE}}px; margin-right: -{{VALUE}}px;',
                    '(tablet-){{WRAPPER}} .lae-block .lae-block-inner .lae-block-column' => 'padding: {{VALUE}}px;',
                ]
            ]
        );

        $this->add_control(
            'heading_mobile',
            [
                'label' => __( 'Mobile Phone', 'livemesh-el-addons' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'after',
            ]
        );

        $this->add_control(
            'mobile_gutter',
            [
                'label' => __('Gutter', 'livemesh-el-addons'),
                'description' => __('Space between columns.', 'livemesh-el-addons'),
                'type' => Controls_Manager::NUMBER,
                'default' => 10,
                'selectors' => [
                    '(mobile-){{WRAPPER}} .lae-block .lae-block-inner' => 'margin-left: -{{VALUE}}px; margin-right: -{{VALUE}}px;',
                    '(mobile-){{WRAPPER}} .lae-block .lae-block-inner .lae-block-column' => 'padding: {{VALUE}}px;',
                ]
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
            'section_entry_author_avatar_styling',
            [
                'label' => __('Post Author Avatar', 'livemesh-el-addons'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'block_type' => ['block_instagram_grid_1', 'block_instagram_grid_3']
                ],
            ]
        );

        $this->add_control(
            'avatar_size',
            [
                'label' => __('Avatar size in pixels', 'livemesh-el-addons'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'range' => [
                    'px' => [
                        'min' => 12,
                        'max' => 128,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .lae-block-instagram-grid .lae-module .lae-social-avatar img' => 'width: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}};'
                ],
            ]
        );

        $this->add_control(
            'avatar_border_radius',
            [
                'label' => __('Avatar Border Radius', 'livemesh-el-addons'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .lae-block-instagram-grid .lae-module .lae-social-avatar img' => 'border-radius: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_entry_author_name_styling',
            [
                'label' => __('Post Author Name', 'livemesh-el-addons'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'block_type' => ['block_instagram_grid_1', 'block_instagram_grid_3']
                ],
            ]
        );

        $this->add_control(
            'author_name_color',
            [
                'label' => __('Author Name Color', 'livemesh-el-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lae-block-instagram-grid .lae-module .lae-instagram-user .lae-user-details .lae-instagram-name' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'author_name_link_hover_color',
            [
                'label' => __('Author Name Link Hover Color', 'livemesh-el-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lae-block-instagram-grid .lae-module .lae-instagram-user:hover .lae-user-details .lae-instagram-name' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'author_name_typography',
                'selector' => '{{WRAPPER}} .lae-block-instagram-grid .lae-module .lae-instagram-user .lae-user-details .lae-instagram-name',
            ]
        );


        $this->end_controls_section();

        $this->start_controls_section(
            'section_entry_author_username_styling',
            [
                'label' => __('Post Author Username', 'livemesh-el-addons'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'block_type' => ['block_instagram_grid_1', 'block_instagram_grid_3']
                ],
            ]
        );

        $this->add_control(
            'author_username_color',
            [
                'label' => __('Username Color', 'livemesh-el-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lae-block-instagram-grid .lae-module .lae-instagram-user .lae-user-details .lae-instagram-username' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'author_username_link_hover_color',
            [
                'label' => __('Username Link Hover Color', 'livemesh-el-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lae-block-instagram-grid .lae-module .lae-instagram-user:hover .lae-user-details .lae-instagram-username' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'author_username_typography',
                'selector' => '{{WRAPPER}} .lae-block-instagram-grid .lae-module .lae-instagram-user .lae-user-details .lae-instagram-username',
            ]
        );

        $this->end_controls_section();


        $this->start_controls_section(
            'section_entry_date_styling',
            [
                'label' => __('Posted Date', 'livemesh-el-addons'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'block_type' => ['block_instagram_grid_1', 'block_instagram_grid_3']
                ],
            ]
        );

        $this->add_control(
            'entry_date_color',
            [
                'label' => __('Posted Date Color', 'livemesh-el-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lae-block-instagram-grid .lae-module .lae-posted-date .lae-published' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'entry_date_link_hover_color',
            [
                'label' => __('Posted Date Link Hover Color', 'livemesh-el-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lae-block-instagram-grid .lae-module .lae-posted-date:hover .lae-published' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'entry_date_typography',
                'selector' => '{{WRAPPER}} .lae-block-instagram-grid .lae-module .lae-posted-date .lae-published',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_entry_likes_styling',
            [
                'label' => __('Likes/Views', 'livemesh-el-addons'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'entry_likes_icon_size',
            [
                'label' => __('Likes/Views Icon size in pixels', 'livemesh-el-addons'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'range' => [
                    'px' => [
                        'min' => 12,
                        'max' => 96,
                    ],
                ],
                'default' => [
                    'size' => 18,
                ],
                'selectors' => [
                    '{{WRAPPER}} .lae-block-instagram-grid .lae-module .lae-module-details .lae-entry-likes i, {{WRAPPER}} .lae-block-instagram-grid .lae-module .lae-module-image .lae-module-image-info .lae-entry-likes i, {{WRAPPER}} .lae-block-instagram-grid .lae-module .lae-module-details .lae-entry-views i, {{WRAPPER}} .lae-block-instagram-grid .lae-module .lae-module-image .lae-module-image-info .lae-entry-views i' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'entry_likes_icon_color',
            [
                'label' => __('Likes Icon Color', 'livemesh-el-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lae-block-instagram-grid .lae-module .lae-module-details .lae-entry-likes i, {{WRAPPER}} .lae-block-instagram-grid .lae-module .lae-module-image .lae-module-image-info .lae-entry-likes i, {{WRAPPER}} .lae-block-instagram-grid .lae-module .lae-module-details .lae-entry-views i, {{WRAPPER}} .lae-block-instagram-grid .lae-module .lae-module-image .lae-module-image-info .lae-entry-views i' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'entry_likes_color',
            [
                'label' => __('Likes Color', 'livemesh-el-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lae-block-instagram-grid .lae-module .lae-module-details .lae-entry-likes, {{WRAPPER}} .lae-block-instagram-grid .lae-module .lae-module-image .lae-module-image-info .lae-entry-likes, {{WRAPPER}} .lae-block-instagram-grid .lae-module .lae-module-details .lae-entry-views, {{WRAPPER}} .lae-block-instagram-grid .lae-module .lae-module-image .lae-module-image-info .lae-entry-views' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'entry_likes_typography',
                'selector' => '{{WRAPPER}} .lae-block-instagram-grid .lae-module .lae-module-details .lae-entry-likes, {{WRAPPER}} .lae-block-instagram-grid .lae-module .lae-module-image .lae-module-image-info .lae-entry-likes, , {{WRAPPER}} .lae-block-instagram-grid .lae-module .lae-module-details .lae-entry-views, {{WRAPPER}} .lae-block-instagram-grid .lae-module .lae-module-image .lae-module-image-info .lae-entry-views',
            ]
        );


        $this->end_controls_section();

        $this->start_controls_section(
            'section_comments_number_styling',
            [
                'label' => __('Comments Number', 'livemesh-el-addons'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'comments_number_icon_size',
            [
                'label' => __('Comments Number Icon size in pixels', 'livemesh-el-addons'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'range' => [
                    'px' => [
                        'min' => 12,
                        'max' => 96,
                    ],
                ],
                'default' => [
                    'size' => 18,
                ],
                'selectors' => [
                    '{{WRAPPER}} .lae-block-instagram-grid .lae-module .lae-module-details .lae-entry-comments i, {{WRAPPER}} .lae-block-instagram-grid .lae-module .lae-module-image .lae-module-image-info .lae-entry-comments i' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'comments_number_icon_color',
            [
                'label' => __('Comments Number Icon Color', 'livemesh-el-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lae-block-instagram-grid .lae-module .lae-module-details .lae-entry-comments i, {{WRAPPER}} .lae-block-instagram-grid .lae-module .lae-module-image .lae-module-image-info .lae-entry-comments i' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'comments_number_color',
            [
                'label' => __('Comments Number Color', 'livemesh-el-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lae-block-instagram-grid .lae-module .lae-module-details .lae-entry-comments, {{WRAPPER}} .lae-block-instagram-grid .lae-module .lae-module-image .lae-module-image-info .lae-entry-comments' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'comments_number_typography',
                'selector' => '{{WRAPPER}} .lae-block-instagram-grid .lae-module .lae-module-details .lae-entry-comments, {{WRAPPER}} .lae-block-instagram-grid .lae-module .lae-module-image .lae-module-image-info .lae-entry-comments',
            ]
        );


        $this->end_controls_section();

        $this->start_controls_section(
            'section_read_more_styling',
            [
                'label' => __('Read More', 'livemesh-el-addons'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'block_type' => ['block_instagram_grid_1', 'block_instagram_grid_3']
                ],
            ]
        );

        $this->add_control(
            'read_more_color',
            [
                'label' => __('Read More Color', 'livemesh-el-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lae-block-instagram-grid .lae-module .lae-read-more, {{WRAPPER}} .lae-block-instagram-grid .lae-module .lae-read-more a' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'read_more_hover_color',
            [
                'label' => __('Read More Hover Color', 'livemesh-el-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lae-block-instagram-grid .lae-module .lae-read-more, {{WRAPPER}} .lae-block-instagram-grid .lae-module .lae-read-more a:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'read_more_typography',
                'selector' => '{{WRAPPER}} .lae-block-instagram-grid .lae-module .lae-read-more, {{WRAPPER}} .lae-block-instagram-grid .lae-module .lae-read-more a',
            ]
        );


        $this->end_controls_section();

        $this->start_controls_section(
            'section_item_text_styling',
            [
                'label' => __('Post Excerpt', 'livemesh-el-addons'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'block_type' => ['block_instagram_grid_1', 'block_instagram_grid_3']
                ],
            ]
        );

        $this->add_control(
            'item_text_color',
            [
                'label' => __('Text Color', 'livemesh-el-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lae-block-instagram-grid .lae-module .lae-entry-summary' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'item_text_link_color',
            [
                'label' => __('Text Link Color', 'livemesh-el-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lae-block-instagram-grid .lae-module .lae-entry-summary a' => 'color: {{VALUE}};',
                ],
            ]
        );


        $this->add_control(
            'item_text_link_hover_color',
            [
                'label' => __('Text Link Hover Color', 'livemesh-el-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lae-block-instagram-grid .lae-module .lae-entry-summary a:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'item_text_typography',
                'selector' => '{{WRAPPER}} .lae-block-instagram-grid .lae-module .lae-entry-summary',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_user_banner_username_styling',
            [
                'label' => __('User Banner Username', 'livemesh-el-addons'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'user_banner_username_color',
            [
                'label' => __('Username Link Color', 'livemesh-el-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lae-block-instagram-grid .lae-instagram-user-header .lae-instagram-username' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'user_banner_username_link_hover_color',
            [
                'label' => __('Username Link Hover Color', 'livemesh-el-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lae-block-instagram-grid .lae-instagram-user-header .lae-instagram-username:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'user_banner_username_typography',
                'selector' => '{{WRAPPER}} .lae-block-instagram-grid .lae-instagram-user-header .lae-instagram-username',
            ]
        );


        $this->end_controls_section();

        $this->start_controls_section(
            'section_user_banner_name_styling',
            [
                'label' => __('User Banner Name', 'livemesh-el-addons'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'user_banner_name_color',
            [
                'label' => __('User Banner Name Color', 'livemesh-el-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lae-block-instagram-grid .lae-instagram-user-header .lae-instagram-user-title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'user_banner_name_link_hover_color',
            [
                'label' => __('User Banner Name Link Hover Color', 'livemesh-el-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lae-block-instagram-grid .lae-instagram-user-header .lae-instagram-user-title:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'user_banner_name_typography',
                'selector' => '{{WRAPPER}} .lae-block-instagram-grid .lae-instagram-user-header .lae-instagram-user-title',
            ]
        );


        $this->end_controls_section();

        $this->start_controls_section(
            'section_user_banner_stats_styling',
            [
                'label' => __('User Banner Stats', 'livemesh-el-addons'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'user_banner_stats_color',
            [
                'label' => __('User Banner Stats Color', 'livemesh-el-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lae-block-instagram-grid .lae-instagram-user-header .lae-instagram-user-stats span, {{WRAPPER}} .lae-block-instagram-grid .lae-instagram-user-header .lae-instagram-user-stats span:before' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'user_banner_stats_typography',
                'selector' => '{{WRAPPER}} .lae-block-instagram-grid .lae-instagram-user-header .lae-instagram-user-stats span',
            ]
        );


        $this->end_controls_section();

        $this->start_controls_section(
            'section_user_banner_desc_styling',
            [
                'label' => __('User Banner Description', 'livemesh-el-addons'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'user_banner_desc_color',
            [
                'label' => __('Text Color', 'livemesh-el-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lae-block-instagram-grid .lae-instagram-user-header .lae-instagram-user-desc' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'user_banner_desc_typography',
                'selector' => '{{WRAPPER}} .lae-block-instagram-grid .lae-instagram-user-header .lae-instagram-user-desc',
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

        $settings = apply_filters('lae_instagram_grid_' . $this->get_id() . '_settings', $settings);

        $settings['block_id'] = $this->get_id();

        $settings['header_template'] = 'block_header_instagram';

        self::$instagram_grid_counter++;

        $settings['block_class'] = !empty($settings['instagram_grid_class']) ? sanitize_title($settings['instagram_grid_class']) : 'instagram-grid-' . self::$instagram_grid_counter;

        $settings = lae_parse_instagram_block_settings($settings);

        $block = LAE_Blocks_Manager::get_instance($settings['block_type']);

        $output = $block->render($settings);

        echo apply_filters('lae_instagram_grid_output', $output, $settings);
    }

    /**
     * Render the widget output in the editor.
     * @return void
     */
    protected function content_template() {
    }

}