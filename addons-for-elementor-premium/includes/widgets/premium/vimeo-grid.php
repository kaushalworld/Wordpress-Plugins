<?php

/*
Widget Name: Vimeo Grid
Description: Display Vimeo Videos in a multi-column grid.
Author: LiveMesh
Author URI: https://www.livemeshthemes.com
*/


namespace LivemeshAddons\Widgets;

use Elementor\Modules\DynamicTags\Module as TagsModule;
use LivemeshAddons\Blocks\LAE_Blocks_Manager;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

/**
 * Class for Vimeo Grid widget that displays Vimeo Videos in a multi-column grid.
 */
class LAE_Vimeo_Grid_Widget extends LAE_Widget_Base {

    static public $vimeo_grid_counter = 0;

    /**
     * Get the name for the widget
     * @return string
     */
    public function get_name() {
        return 'lae-vimeo-grid';
    }

    /**
     * Get the widget title
     * @return string|void
     */
    public function get_title() {
        return __('Vimeo Grid', 'livemesh-el-addons');
    }

    /**
     * Get the widget icon
     * @return string
     */
    public function get_icon() {
        return 'lae-icon-vimeo-grid';
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
        return 'https://livemeshelementor.com/docs/livemesh-addons/premium-addons/vimeo-grid/';
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
            'lae-vimeo-grid-scripts'
        ];
    }

    /**
     * Register the controls for the widget
     * Adds fields that help configure and customize the widget
     * @return void
     */
    protected function register_controls() {

        $this->start_controls_section(
            'section_vimeo_grid',
            [
                'label' => __('Vimeo Grid', 'livemesh-el-addons'),
            ]
        );

        $this->add_control(
            'vimeo_grid_class', [
                'type' => Controls_Manager::TEXT,
                "description" => __("Specify an unique identifier used as a custom CSS class name and lightbox group name/slug for the grid element.", "livemesh-el-addons"),
                "label" => __("Vimeo Grid Class/Identifier", "livemesh-el-addons"),
                'default' => ''
            ]
        );

        $this->add_control(
            'vimeo_source',
            [
                'type' => Controls_Manager::SELECT,
                'label' => __('Vimeo Source', 'livemesh-el-addons'),
                'description' => __('Specify the Vimeo source to display in the grid. Ensure Vimeo <strong>Personal Access Token</strong> is provided in the Social API tab of the ', 'livemesh-el-addons') . '<a style="text-decoration: underline" href="' . admin_url('admin.php?page=livemesh_el_addons') . '" target="_blank">' . __('admin settings.', 'livemesh-el-addons') . '</a>',
                'options' => array(
                    'users' => __('User', 'livemesh-el-addons'),
                    'albums' => __('Album', 'livemesh-el-addons'),
                    'groups' => __('Group', 'livemesh-el-addons'),
                    'channels' => __('Channel', 'livemesh-el-addons')
                ),
                'default' => 'users',
            ]
        );

        $this->add_control(
            'vimeo_channel',
            [
                'type' => Controls_Manager::TEXT,
                'label' => __('Vimeo Channel', 'livemesh-el-addons'),
                'description' => __('Enter the Vimeo Channel name. The channel name can be found in the URL (e.g.: goprocreative)', 'livemesh-el-addons'),
                'condition' => [
                    'vimeo_source' => ['channels']
                ],
                'dynamic' => [
                    'active' => true,
                    'categories' => [
                        TagsModule::POST_META_CATEGORY,
                    ],
                ],
            ]
        );

        $this->add_control(
            'vimeo_album',
            [
                'type' => Controls_Manager::TEXT,
                'label' => __('Vimeo Album', 'livemesh-el-addons'),
                'description' => __('Enter the Vimeo Album ID found in the URL (e.g.: 1893031)', 'livemesh-el-addons'),
                'condition' => [
                    'vimeo_source' => ['albums']
                ],
                'dynamic' => [
                    'active' => true,
                    'categories' => [
                        TagsModule::POST_META_CATEGORY,
                    ],
                ],
            ]
        );

        $this->add_control(
            'vimeo_group',
            [
                'type' => Controls_Manager::TEXT,
                'label' => __('Vimeo Group', 'livemesh-el-addons'),
                'description' => __('Enter the Vimeo Group ID found in the URL (e.g.: animation)', 'livemesh-el-addons'),
                'condition' => [
                    'vimeo_source' => ['groups']
                ],
                'dynamic' => [
                    'active' => true,
                    'categories' => [
                        TagsModule::POST_META_CATEGORY,
                    ],
                ],
            ]
        );

        $this->add_control(
            'vimeo_user',
            [
                'type' => Controls_Manager::TEXT,
                'label' => __('Vimeo User', 'livemesh-el-addons'),
                'description' => __('Enter the Vimeo User ID found in the URL (e.g.: gopro)', 'livemesh-el-addons'),
                'condition' => [
                    'vimeo_source' => ['users']
                ],
                'dynamic' => [
                    'active' => true,
                    'categories' => [
                        TagsModule::POST_META_CATEGORY,
                    ],
                ],
            ]
        );

        $this->add_control(
            'vimeo_sort',
            [
                'type' => Controls_Manager::SELECT,
                'label' => __('Sort By', 'livemesh-el-addons'),
                'description' => __('Specify the sort order of the videos', 'livemesh-el-addons'),
                'options' => array(
                    '' => __('Default', 'livemesh-el-addons'),
                    'date' => __('Date', 'livemesh-el-addons'),
                    'alphabetical' => __('Alphabetical', 'livemesh-el-addons'),
                    'plays' => __('Number of views', 'livemesh-el-addons'),
                    'likes' => __('Number of likes', 'livemesh-el-addons'),
                    'comments' => __('Number of comments', 'livemesh-el-addons'),
                    'duration' => __('Video duration', 'livemesh-el-addons'),
                    'modified_time' => __('Modified time', 'livemesh-el-addons'),
                    'manual' => __('Manual (Channel/Album only)', 'livemesh-el-addons'),
                    'added' => __('Added (Channel only)', 'livemesh-el-addons')
                ),
                'default' => ''
            ]
        );

        $this->add_control(
            'vimeo_order',
            [
                'type' => Controls_Manager::SELECT,
                'label' => __('Order By', 'livemesh-el-addons'),
                'description' => __('Specify the sort direction of the videos', 'livemesh-el-addons'),
                'options' => array(
                    'desc' => __('Descending', 'livemesh-el-addons'),
                    'asc' => __('Ascending', 'livemesh-el-addons')
                ),
                'default' => 'desc'
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_video_info',
            [
                'label' => __('Video Information', 'livemesh-el-addons'),
            ]
        );

        $this->add_control(
            'display_user_info_header',
            [
                'label' => __('Display user information header?', 'livemesh-el-addons'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'livemesh-el-addons'),
                'label_off' => __('No', 'livemesh-el-addons'),
                'return_value' => 'yes',
                'default' => 'yes',
                'condition' => [
                    'vimeo_source' => 'users'
                ],
            ]
        );

        $this->add_control(
            'display_thumbnail_title',
            [
                'label' => __('Display title for the vimeo video on thumbnail hover?', 'livemesh-el-addons'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'livemesh-el-addons'),
                'label_off' => __('No', 'livemesh-el-addons'),
                'return_value' => 'yes',
                'default' => '',
                'condition' => [
                    'display_video_inline' => ''
                ],
            ]
        );

        $this->add_control(
            'display_item_title',
            [
                'label' => __('Display title for the vimeo video below thumbnail?', 'livemesh-el-addons'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'livemesh-el-addons'),
                'label_off' => __('No', 'livemesh-el-addons'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'display_duration',
            [
                'label' => __('Display duration for the vimeo post?', 'livemesh-el-addons'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'livemesh-el-addons'),
                'label_off' => __('No', 'livemesh-el-addons'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'display_categories',
            [
                'label' => __('Display categories for the vimeo video?', 'livemesh-el-addons'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'livemesh-el-addons'),
                'label_off' => __('No', 'livemesh-el-addons'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'display_excerpt',
            [
                'label' => __('Display excerpt for the vimeo video?', 'livemesh-el-addons'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'livemesh-el-addons'),
                'label_off' => __('No', 'livemesh-el-addons'),
                'return_value' => 'yes',
                'default' => 'yes',
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

        $this->add_control(
            'display_user',
            [
                'label' => __('Display user account information for each vimeo video?', 'livemesh-el-addons'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'livemesh-el-addons'),
                'label_off' => __('No', 'livemesh-el-addons'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'display_date',
            [
                'label' => __('Display posted date for the vimeo video?', 'livemesh-el-addons'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'livemesh-el-addons'),
                'label_off' => __('No', 'livemesh-el-addons'),
                'return_value' => 'yes',
                'default' => 'yes',
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
                'label' => __('Display comments for each vimeo post?', 'livemesh-el-addons'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'livemesh-el-addons'),
                'label_off' => __('No', 'livemesh-el-addons'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'display_views',
            [
                'label' => __('Display views count for the vimeo post?', 'livemesh-el-addons'),
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
                'label' => __('Display likes count for the vimeo post?', 'livemesh-el-addons'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'livemesh-el-addons'),
                'label_off' => __('No', 'livemesh-el-addons'),
                'return_value' => 'yes',
                'default' => 'yes',
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
                    'block_vimeo_grid_1' => __('Vimeo Grid Style 1', 'livemesh-el-addons'),
                    'block_vimeo_grid_2' => __('Vimeo Grid Style 2', 'livemesh-el-addons'),
                ),
                'default' => 'block_vimeo_grid_1',
            ]
        );

        $this->add_responsive_control(
            'per_line',
            [
                'label' => __('Columns', 'livemesh-el-addons'),
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
            'layout_mode',
            [
                'type' => Controls_Manager::SELECT,
                'label' => __('Choose a layout for the Vimeo grid', 'livemesh-el-addons'),
                'options' => array(
                    'masonry' => __('Masonry', 'livemesh-el-addons'),
                    'fitRows' => __('Fit Rows', 'livemesh-el-addons'),
                ),
                'default' => 'masonry',
            ]
        );

        $this->add_control(
            'display_video_inline',
            ['type' => Controls_Manager::SWITCHER,
             'label' => __('Display videos inline?', 'livemesh-el-addons'),
             'label_off' => __('No', 'livemesh-el-addons'),
             'label_on' => __('Yes', 'livemesh-el-addons'),
             'return_value' => 'yes',
             'default' => '',
            ]
        );

        $this->add_control(
            'lightbox_library',
            [
                'type' => Controls_Manager::SELECT,
                'label' => __('Lightbox Library', 'livemesh-el-addons'),
                'description' => __('Choose the preferred library for the lightbox if videos are not chosen to be displayed inline.', 'livemesh-el-addons'),
                'options' => array(
                    'fancybox' => __('Fancybox', 'livemesh-el-addons'),
                    'elementor' => __('Elementor', 'livemesh-el-addons'),
                ),
                'default' => 'fancybox',
                'condition' => [
                    'display_video_inline' => ''
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_pagination',
            [
                'label' => __('Pagination/Posts Per Page', 'livemesh-el-addons'),
                'tab' => Controls_Manager::TAB_SETTINGS,
            ]
        );


        $this->add_control(
            'pagination',
            [
                'type' => Controls_Manager::SELECT,
                'label' => __('Pagination', 'livemesh-el-addons'),
                'description' => __('Choose pagination type or choose None if no pagination is desired. Make sure you enter the items per page value in the option \'Number of items to be displayed on each load more invocation\' field below to control number of items to display per page.', 'livemesh-el-addons'),
                'options' => array(
                    'none' => __('None', 'livemesh-el-addons'),
                    'load_more' => __('Load More', 'livemesh-el-addons'),
                ),
                'default' => 'load_more',
            ]
        );


        $this->add_control(
            'items_per_page',
            [
                'label' => __('Number of videos to be displayed per page and on each load more invocation.', 'livemesh-el-addons'),
                'type' => Controls_Manager::NUMBER,
                'min' => 3,
                'max' => 50,
                'step' => 1,
                'default' => 9,
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
                'label' => __('Desktop', 'livemesh-el-addons'),
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
                'label' => __('Tablet', 'livemesh-el-addons'),
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
                'label' => __('Mobile Phone', 'livemesh-el-addons'),
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
            'section_item_title_styling',
            [
                'label' => __('Video Title', 'livemesh-el-addons'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'item_title_tag',
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
            'item_title_color',
            [
                'label' => __('Title Color', 'livemesh-el-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lae-block-vimeo-grid .lae-module .lae-entry-title, {{WRAPPER}} .lae-block-vimeo-grid .lae-module .lae-entry-title a' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'title_hover_color',
            [
                'label' => __('Title Hover Color', 'livemesh-el-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lae-block-vimeo-grid .lae-module .lae-entry-title a:hover' => 'text-decoration: none; color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'item_title_typography',
                'selector' => '{{WRAPPER}} .lae-block-vimeo-grid .lae-module .lae-entry-title, {{WRAPPER}} .lae-block-vimeo-grid .lae-module .lae-entry-title a',
            ]
        );


        $this->end_controls_section();

        $this->start_controls_section(
            'section_item_categories_styling',
            [
                'label' => __('Video Categories', 'livemesh-el-addons'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'item_category_color',
            [
                'label' => __('Category Color', 'livemesh-el-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lae-block-vimeo-grid .lae-module .lae-terms a, {{WRAPPER}} .lae-block-vimeo-grid .lae-module .lae-terms a:before' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'category_hover_color',
            [
                'label' => __('Category Hover Color', 'livemesh-el-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lae-block-vimeo-grid .lae-module .lae-terms a:hover' => 'text-decoration: none; color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'item_category_typography',
                'selector' => '{{WRAPPER}} .lae-block-vimeo-grid .lae-module .lae-terms a, {{WRAPPER}} .lae-block-vimeo-grid .lae-module .lae-terms a:before',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_item_text_styling',
            [
                'label' => __('Video Excerpt', 'livemesh-el-addons'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'display_excerpt' => ['yes']
                ],
            ]
        );

        $this->add_control(
            'item_text_color',
            [
                'label' => __('Text Color', 'livemesh-el-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lae-block-vimeo-grid .lae-module .lae-entry-summary' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'item_text_link_color',
            [
                'label' => __('Text Link Color', 'livemesh-el-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lae-block-vimeo-grid .lae-module .lae-entry-summary a' => 'color: {{VALUE}};',
                ],
            ]
        );


        $this->add_control(
            'item_text_link_hover_color',
            [
                'label' => __('Text Link Hover Color', 'livemesh-el-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lae-block-vimeo-grid .lae-module .lae-entry-summary a:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'item_text_typography',
                'selector' => '{{WRAPPER}} .lae-block-vimeo-grid .lae-module .lae-entry-summary',
            ]
        );


        $this->end_controls_section();

        $this->start_controls_section(
            'section_entry_channel_name_styling',
            [
                'label' => __('Channel Name', 'livemesh-el-addons'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'channel_name_color',
            [
                'label' => __('Channel Name Color', 'livemesh-el-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lae-block-vimeo-grid .lae-module .lae-vimeo-channel .lae-channel-details .lae-channel-name' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'channel_name_link_hover_color',
            [
                'label' => __('Channel Name Link Hover Color', 'livemesh-el-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lae-block-vimeo-grid .lae-module .lae-vimeo-channel:hover .lae-channel-details .lae-channel-name' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'channel_name_typography',
                'selector' => '{{WRAPPER}} .lae-block-vimeo-grid .lae-module .lae-vimeo-channel .lae-channel-details .lae-channel-name',
            ]
        );


        $this->end_controls_section();

        $this->start_controls_section(
            'section_entry_date_styling',
            [
                'label' => __('Posted Date', 'livemesh-el-addons'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'entry_date_color',
            [
                'label' => __('Posted Date Color', 'livemesh-el-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lae-block-vimeo-grid .lae-module .lae-posted-date .lae-published' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'entry_date_link_hover_color',
            [
                'label' => __('Posted Date Link Hover Color', 'livemesh-el-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lae-block-vimeo-grid .lae-module .lae-posted-date:hover .lae-published' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'entry_date_typography',
                'selector' => '{{WRAPPER}} .lae-block-vimeo-grid .lae-module .lae-posted-date .lae-published',
            ]
        );


        $this->end_controls_section();

        $this->start_controls_section(
            'section_entry_views_styling',
            [
                'label' => __('Views', 'livemesh-el-addons'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );


        $this->add_control(
            'entry_views_icon_size',
            [
                'label' => __('Views Icon size in pixels', 'livemesh-el-addons'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 12,
                        'max' => 96,
                    ],
                ],
                'default' => [
                    'size' => 14,
                ],
                'selectors' => [
                    '{{WRAPPER}} .lae-block-vimeo-grid .lae-module .lae-module-details .lae-entry-views i' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'entry_views_icon_color',
            [
                'label' => __('Views Icon Color', 'livemesh-el-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lae-block-vimeo-grid .lae-module .lae-module-details .lae-entry-views i' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'entry_views_color',
            [
                'label' => __('Views Count Color', 'livemesh-el-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lae-block-vimeo-grid .lae-module .lae-module-details .lae-entry-views' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'entry_views_typography',
                'selector' => '{{WRAPPER}} .lae-block-vimeo-grid .lae-module .lae-module-details .lae-entry-views',
            ]
        );


        $this->end_controls_section();

        $this->start_controls_section(
            'section_entry_likes_styling',
            [
                'label' => __('Likes', 'livemesh-el-addons'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'entry_likes_icon_size',
            [
                'label' => __('Likes Icon size in pixels', 'livemesh-el-addons'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 12,
                        'max' => 96,
                    ],
                ],
                'default' => [
                    'size' => 14,
                ],
                'selectors' => [
                    '{{WRAPPER}} .lae-block-vimeo-grid .lae-module .lae-module-details .lae-entry-likes i' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'entry_likes_icon_color',
            [
                'label' => __('Likes Icon Color', 'livemesh-el-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lae-block-vimeo-grid .lae-module .lae-module-details .lae-entry-likes i' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'entry_likes_color',
            [
                'label' => __('Likes Color', 'livemesh-el-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lae-block-vimeo-grid .lae-module .lae-module-details .lae-entry-likes' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'entry_likes_typography',
                'selector' => '{{WRAPPER}} .lae-block-vimeo-grid .lae-module .lae-module-details .lae-entry-likes',
            ]
        );


        $this->end_controls_section();

        $this->start_controls_section(
            'section_entry_comments_styling',
            [
                'label' => __('Comments', 'livemesh-el-addons'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'entry_comments_icon_size',
            [
                'label' => __('Comments Icon size in pixels', 'livemesh-el-addons'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 12,
                        'max' => 96,
                    ],
                ],
                'default' => [
                    'size' => 14,
                ],
                'selectors' => [
                    '{{WRAPPER}} .lae-block-vimeo-grid .lae-module .lae-module-details .lae-entry-comments i' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'entry_comments_icon_color',
            [
                'label' => __('Comments Icon Color', 'livemesh-el-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lae-block-vimeo-grid .lae-module .lae-module-details .lae-entry-comments i' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'entry_comments_color',
            [
                'label' => __('Comments Color', 'livemesh-el-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lae-block-vimeo-grid .lae-module .lae-module-details .lae-entry-comments' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'entry_comments_typography',
                'selector' => '{{WRAPPER}} .lae-block-vimeo-grid .lae-module .lae-module-details .lae-entry-comments',
            ]
        );


        $this->end_controls_section();

        $this->start_controls_section(
            'section_entry_duration_styling',
            [
                'label' => __('Duration', 'livemesh-el-addons'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'entry_duration_bg_color',
            [
                'label' => __('Duration Background Color', 'livemesh-el-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lae-block-vimeo-grid .lae-module .lae-entry-duration' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'entry_duration_color',
            [
                'label' => __('Duration Color', 'livemesh-el-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lae-block-vimeo-grid .lae-module .lae-entry-duration' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'entry_duration_typography',
                'selector' => '{{WRAPPER}} .lae-block-vimeo-grid .lae-module .lae-entry-duration',
            ]
        );


        $this->end_controls_section();

        $this->start_controls_section(
            'section_load_more_button_styling',
            [
                'label' => __('Load More Button', 'livemesh-el-addons'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'pagination' => 'load_more',
                ],
            ]
        );

        $this->add_control(
            'load_more_button_custom_color',
            [
                'label' => __('Button Color', 'livemesh-el-addons'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .lae-block-vimeo-grid .lae-load-more' => 'background-color: {{VALUE}}; border-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'load_more_button_custom_hover_color',
            [
                'label' => __('Button Hover Color', 'livemesh-el-addons'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .lae-block-vimeo-grid .lae-load-more:hover' => 'background-color: {{VALUE}}; border-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'load_more_button_padding',
            [
                'label' => __('Custom Padding', 'livemesh-el-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .lae-block-vimeo-grid .lae-load-more' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'isLinked' => false
            ]
        );

        $this->add_control(
            'load_more_button_border_radius',
            [
                'label' => __('Custom Border Radius', 'livemesh-el-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .lae-block-vimeo-grid .lae-load-more' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'load_more_button_label_color',
            [
                'label' => __('Label Color', 'livemesh-el-addons'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .lae-block-vimeo-grid .lae-load-more' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'load_more_button_label_hover_color',
            [
                'label' => __('Label Hover Color', 'livemesh-el-addons'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .lae-block .lae-load-more:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'load_more_button_typography',
                'label' => __('Typography', 'livemesh-el-addons'),
                'selector' => '{{WRAPPER}} .lae-block-vimeo-grid .lae-load-more',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_banner_channel_name_styling',
            [
                'label' => __('Banner Channel Name', 'livemesh-el-addons'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'banner_channel_name_color',
            [
                'label' => __('Channel Name Color', 'livemesh-el-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lae-block-vimeo-grid .lae-vimeo-channel-header .lae-vimeo-channel-title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'banner_channel_name_link_hover_color',
            [
                'label' => __('Channel Name Link Hover Color', 'livemesh-el-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lae-block-vimeo-grid .lae-vimeo-channel-header .lae-vimeo-channel-title:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'banner_channel_name_typography',
                'selector' => '{{WRAPPER}} .lae-block-vimeo-grid .lae-vimeo-channel-header .lae-vimeo-channel-title',
            ]
        );


        $this->end_controls_section();

        $this->start_controls_section(
            'section_channel_location_styling',
            [
                'label' => __('Channel Location', 'livemesh-el-addons'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'channel_location_color',
            [
                'label' => __('Text Color', 'livemesh-el-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lae-block-vimeo-grid .lae-vimeo-channel-header .lae-vimeo-channel-location' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'channel_location_typography',
                'selector' => '{{WRAPPER}} .lae-block-vimeo-grid .lae-vimeo-channel-header .lae-vimeo-channel-location',
            ]
        );


        $this->end_controls_section();

        $this->start_controls_section(
            'section_channel_stats_styling',
            [
                'label' => __('Channel Stats', 'livemesh-el-addons'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'channel_stats_color',
            [
                'label' => __('Channel Stats Color', 'livemesh-el-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lae-block-vimeo-grid .lae-vimeo-channel-header .lae-vimeo-channel-stats span, {{WRAPPER}} .lae-block-vimeo-grid .lae-vimeo-channel-header .lae-vimeo-channel-stats span:before' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'channel_stats_typography',
                'selector' => '{{WRAPPER}} .lae-block-vimeo-grid .lae-vimeo-channel-header .lae-vimeo-channel-stats span',
            ]
        );


        $this->end_controls_section();

        $this->start_controls_section(
            'section_channel_desc_styling',
            [
                'label' => __('Channel Description', 'livemesh-el-addons'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'channel_desc_color',
            [
                'label' => __('Text Color', 'livemesh-el-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lae-block-vimeo-grid .lae-vimeo-channel-header .lae-vimeo-channel-desc' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'channel_desc_typography',
                'selector' => '{{WRAPPER}} .lae-block-vimeo-grid .lae-vimeo-channel-header .lae-vimeo-channel-desc',
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

        $settings = apply_filters('lae_vimeo_grid_' . $this->get_id() . '_settings', $settings);

        $settings['block_id'] = $this->get_id();

        $settings['header_template'] = 'block_header_vimeo';

        self::$vimeo_grid_counter++;

        $settings['block_class'] = !empty($settings['vimeo_grid_class']) ? sanitize_title($settings['vimeo_grid_class']) : 'vimeo-grid-' . self::$vimeo_grid_counter;

        $settings = lae_parse_vimeo_block_settings($settings);

        $block = LAE_Blocks_Manager::get_instance($settings['block_type']);

        $output = $block->render($settings);

        echo apply_filters('lae_vimeo_grid_output', $output, $settings);
    }

    /**
     * Render the widget output in the editor.
     * @return void
     */
    protected function content_template() {
    }

}