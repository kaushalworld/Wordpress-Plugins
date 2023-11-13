<?php

/*
Widget Name: Gallery
Description: Display images or videos in a multi-column grid.
Author: LiveMesh
Author URI: https://www.livemeshthemes.com
*/


namespace LivemeshAddons\Widgets;

use Elementor\Repeater;
use LivemeshAddons\Blocks\LAE_Blocks_Manager;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Utils;
use Elementor\Scheme_Color;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Image_Size;
use Elementor\Scheme_Typography;
use Elementor\Modules\DynamicTags\Module as TagsModule;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

/**
 * Class for Gallery widget that displays images or videos in a multi-column grid.
 */
class LAE_Gallery_Widget extends LAE_Widget_Base {

    static public $gallery_counter = 0;

    /**
     * Get the name for the widget
     * @return string
     */
    public function get_name() {
        return 'lae-gallery';
    }

    /**
     * Get the widget title
     * @return string|void
     */
    public function get_title() {
        return __('Gallery', 'livemesh-el-addons');
    }

    /**
     * Get the widget icon
     * @return string
     */
    public function get_icon() {
        return 'lae-icon-gallery';
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
        return 'https://livemeshelementor.com/docs/livemesh-addons/premium-addons/image-video-gallery/';
    }

    /**
     * Obtain the scripts required for the widget to function
     * @return string[]
     */
    public function get_script_depends() {
        return [
            'jquery-fancybox',
            'isotope.pkgd',
            'imagesloaded.pkgd',
            'lae-waypoints',
            'lae-frontend-scripts',
            'lae-blocks-scripts',
            'lae-gallery-scripts',
        ];
    }

    /**
     * Register the controls for the widget
     * Adds fields that help configure and customize the widget
     * @return void
     */
    protected function register_controls() {

        $this->start_controls_section(
            'section_gallery',
            [
                'label' => __('Gallery', 'livemesh-el-addons'),
            ]
        );

        $this->add_control(
            'gallery_class', [
                'type' => Controls_Manager::TEXT,
                "description" => __("Specify an unique identifier used as a custom CSS class name and lightbox group name/slug for the gallery element.", "livemesh-el-addons"),
                "label" => __("Gallery Class/Identifier", "livemesh-el-addons"),
                'default' => ''
            ]
        );

        $this->add_control(
            'heading',
            [
                'label' => __('Heading for the gallery', 'livemesh-el-addons'),
                'type' => Controls_Manager::TEXT,
                'placeholder' => __('My Gallery', 'livemesh-el-addons'),
                'default' => __('My Gallery', 'livemesh-el-addons'),
                'dynamic' => [
                    'active' => true,
                ],
            ]
        );

        $this->add_control(
            'heading_url',
            [
                'label' => __('URL for the heading of the gallery', 'livemesh-el-addons'),
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
            'gallery_items_heading',
            [
                'label' => __('Gallery Items', 'livemesh-el-addons'),
                'type' => Controls_Manager::HEADING,
            ]
        );


        $this->add_control(
            'bulk_upload',
            [
                'label' => __('Bulk upload images?', 'livemesh-el-addons'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'livemesh-el-addons'),
                'label_off' => __('No', 'livemesh-el-addons'),
                'return_value' => 'yes',
                'default' => '',
            ]
        );

        $this->add_control(
            'gallery_images',
            [
                'label' => __('Add Images', 'livemesh-el-addons'),
                'type' => Controls_Manager::GALLERY,
                'condition' => [
                    'bulk_upload' => ['yes']
                ],
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            "item_type",
            [
                "type" => Controls_Manager::SELECT,

                "label" => __("Item Type", "livemesh-el-addons"),
                'options' => array(
                    'image' => __('Image', 'livemesh-el-addons'),
                    'youtube' => __('YouTube Video', 'livemesh-el-addons'),
                    'vimeo' => __('Vimeo Video', 'livemesh-el-addons'),
                    'html5video' => __('HTML5 Video', 'livemesh-el-addons'),
                ),
                'default' => 'image',
            ]
        );

        $repeater->add_control(
            'item_name',

            [

                'label' => __('Item Label', 'livemesh-el-addons'),
                'type' => Controls_Manager::TEXT,
                'default' => __('My item name', 'livemesh-el-addons'),
                'description' => __('The label or name for the gallery item.', 'livemesh-el-addons'),
                'dynamic' => [
                    'active' => true,
                ],
            ]
        );

        $repeater->add_control(
            'item_image',
            [

                'label' => __('Gallery Image', 'livemesh-el-addons'),
                'description' => __('The image for the gallery item. If item type chosen is YouTube or Vimeo video, the image will be used as a placeholder image for video.', 'livemesh-el-addons'),
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
            'item_tags',
            [

                'label' => __('Item Tag(s)', 'livemesh-el-addons'),
                'type' => Controls_Manager::TEXT,
                'description' => __('One or more comma separated tags for the gallery item. Will be used as filters for the items.', 'livemesh-el-addons'),
                'dynamic' => [
                    'active' => true,
                    'categories' => [
                        TagsModule::POST_META_CATEGORY,
                    ],
                ],
            ]
        );

        $repeater->add_control(
            'item_link',
            [

                'label' => __('Item Link', 'livemesh-el-addons'),
                'description' => __('The URL of the page to which the image gallery item points to (optional).', 'livemesh-el-addons'),
                'type' => Controls_Manager::URL,
                'label_block' => true,
                'default' => [
                    'url' => '',
                    'is_external' => 'false',
                ],
                'placeholder' => __('http://your-link.com', 'livemesh-el-addons'),
                'condition' => [
                    'item_type' => ['image'],
                ],
                'dynamic' => [
                    'active' => true,
                ],
            ]
        );

        $repeater->add_control(
            'video_link',
            [

                'label' => __('Video URL', 'livemesh-el-addons'),
                'description' => __('The URL of the YouTube or Vimeo video.', 'livemesh-el-addons'),
                'type' => Controls_Manager::TEXT,
                'condition' => [
                    'item_type' => ['youtube', 'vimeo'],
                ],
                'dynamic' => [
                    'active' => true,
                    'categories' => [
                        TagsModule::POST_META_CATEGORY,
                    ],
                ],
            ]
        );

        $repeater->add_control(
            'mp4_video_link',
            [

                'label' => __('MP4 Video URL', 'livemesh-el-addons'),
                'description' => __('The URL of the MP4 video.', 'livemesh-el-addons'),
                'type' => Controls_Manager::TEXT,
                'condition' => [
                    'item_type' => ['html5video'],
                ],
                'default' => '',
                'dynamic' => [
                    'active' => true,
                    'categories' => [
                        TagsModule::POST_META_CATEGORY,
                    ],
                ],
            ]
        );

        $repeater->add_control(
            'webm_video_link',
            [

                'label' => __('WebM Video URL', 'livemesh-el-addons'),
                'description' => __('The URL of the WebM video.', 'livemesh-el-addons'),
                'type' => Controls_Manager::TEXT,
                'condition' => [
                    'item_type' => ['html5video'],
                ],
                'default' => '',
                'dynamic' => [
                    'active' => true,
                    'categories' => [
                        TagsModule::POST_META_CATEGORY,
                    ],
                ],
            ]
        );

        $repeater->add_control(
            'aspect_ratio',
            [

                'type' => Controls_Manager::SELECT,
                'label' => __('Video Aspect Ratio', 'livemesh-el-addons'),
                'options' => [
                    '169' => '16:9',
                    '43' => '4:3',
                    '32' => '3:2',
                ],
                'default' => '169',
                'prefix_class' => 'elementor-aspect-ratio-',
                'condition' => [
                    'item_type' => ['youtube', 'vimeo'],
                ],
                'frontend_available' => true,
            ]
        );

        $repeater->add_control(
            'display_video_inline',
            [

                'type' => Controls_Manager::SWITCHER,
                'label' => __('Display video inline?', 'livemesh-el-addons'),
                'label_off' => __('No', 'livemesh-el-addons'),
                'label_on' => __('Yes', 'livemesh-el-addons'),
                'condition' => [
                    'item_type' => ['youtube', 'vimeo', 'html5video'],
                ],
                'return_value' => 'yes',
                'default' => 'no',
            ]
        );

        $repeater->add_control(
            'item_description',
            [

                'label' => __('Item description', 'livemesh-el-addons'),
                'type' => Controls_Manager::TEXTAREA,
                'description' => __('Short description for the gallery item displayed in the lightbox gallery.(optional)', 'livemesh-el-addons'),
                'dynamic' => [
                    'active' => true,
                ],
            ]
        );

        $this->add_control(
            'gallery_items',
            [
                'label' => __('Add items or choose bulk upload option above:', 'livemesh-el-addons'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'title_field' => '{{{ item_name }}}',
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
            'filterable',
            [
                'label' => __('Filterable?', 'livemesh-el-addons'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'livemesh-el-addons'),
                'label_off' => __('No', 'livemesh-el-addons'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'header_template',
            [
                'type' => Controls_Manager::SELECT,
                'label' => __('Choose Header Style', 'livemesh-el-addons'),
                'options' => array(
                    'block_header_1' => __('Header Style 1', 'livemesh-el-addons'),
                    'block_header_2' => __('Header Style 2', 'livemesh-el-addons'),
                    'block_header_3' => __('Header Style 3', 'livemesh-el-addons'),
                    'block_header_4' => __('Header Style 4', 'livemesh-el-addons'),
                    'block_header_5' => __('Header Style 5', 'livemesh-el-addons'),
                    'block_header_6' => __('Header Style 6', 'livemesh-el-addons'),
                    'block_header_7' => __('Header Style 7', 'livemesh-el-addons'),
                ),
                'default' => 'block_header_6',
            ]
        );

        $this->add_control(
            'block_type',
            [
                'type' => Controls_Manager::SELECT,
                'label' => __('Choose Gallery Style', 'livemesh-el-addons'),
                'options' => array(
                    'block_gallery_1' => __('Gallery Style 1', 'livemesh-el-addons'),
                    'block_gallery_2' => __('Gallery Style 2', 'livemesh-el-addons'),
                    'block_gallery_3' => __('Gallery Style 3', 'livemesh-el-addons'),
                ),
                'default' => 'block_gallery_1',
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
                'label' => __('Choose a layout for the gallery grid', 'livemesh-el-addons'),
                'options' => array(
                    'fitRows' => __('Fit Rows', 'livemesh-el-addons'),
                    'masonry' => __('Masonry', 'livemesh-el-addons'),
                ),
                'default' => 'fitRows',
            ]
        );

        $this->add_control(
            'display_item_title',
            [
                'label' => __('Display title for the gallery item?', 'livemesh-el-addons'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'livemesh-el-addons'),
                'label_off' => __('No', 'livemesh-el-addons'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'display_item_tags',
            [
                'label' => __('Display tags for the gallery item?', 'livemesh-el-addons'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'livemesh-el-addons'),
                'label_off' => __('No', 'livemesh-el-addons'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'display_description',
            [
                'label' => __('Display description for the gallery item?', 'livemesh-el-addons'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'livemesh-el-addons'),
                'label_off' => __('No', 'livemesh-el-addons'),
                'return_value' => 'yes',
                'default' => 'yes',
                'condition' => [
                    'block_type' => ['block_gallery_2', 'block_gallery_3']
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_image_size_lightbox',
            [
                'label' => __('Image Size and Lightbox', 'livemesh-el-addons'),
                'tab' => Controls_Manager::TAB_SETTINGS,
            ]
        );

        $this->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
                'name' => 'thumbnail_size',
                'label' => __('Gallery Image Size', 'livemesh-el-addons'),
                'default' => 'large',
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
                'label' => __('Enable Lightbox Gallery?', 'livemesh-el-addons'),
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
            'section_pagination',
            [
                'label' => __('Pagination', 'livemesh-el-addons'),
                'tab' => Controls_Manager::TAB_SETTINGS,
            ]
        );


        $this->add_control(
            'pagination',
            [
                'type' => Controls_Manager::SELECT,
                'label' => __('Pagination', 'livemesh-el-addons'),
                'description' => __('Choose pagination type or choose None if no pagination is desired. Make sure you enter the items per page value in the option \'Number of items to be displayed per page and on each load more invocation\' field below to control number of items to display per page.', 'livemesh-el-addons'),
                'options' => array(
                    'none' => __('None', 'livemesh-el-addons'),
                    'paged' => __('Paged', 'livemesh-el-addons'),
                    'load_more' => __('Load More', 'livemesh-el-addons'),
                    'infinite_scroll' => __('Load On Scroll', 'livemesh-el-addons'),
                ),
                'default' => 'none',
            ]
        );


        $this->add_control(
            'show_remaining',
            [
                'label' => __('Display count of items yet to be loaded with the load more button?', 'livemesh-el-addons'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'livemesh-el-addons'),
                'label_off' => __('No', 'livemesh-el-addons'),
                'return_value' => 'yes',
                'default' => 'yes',
                'condition' => [
                    'pagination' => 'load_more',
                ],
            ]
        );


        $this->add_control(
            'items_per_page',
            [
                'label' => __('Number of items to be displayed per page and on each load more invocation.', 'livemesh-el-addons'),
                'type' => Controls_Manager::NUMBER,
                'default' => 8,
                'condition' => [
                    'pagination' => ['load_more', 'paged', 'infinite_scroll'],
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
            'section_heading_styling',
            [
                'label' => __('Gallery Heading', 'livemesh-el-addons'),
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
                'selectors' => [
                    '{{WRAPPER}} .lae-block-gallery .lae-heading span, {{WRAPPER}} .lae-block-gallery .lae-heading a' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'heading_typography',
                'selector' => '{{WRAPPER}} .lae-block-gallery .lae-heading span, {{WRAPPER}} .lae-block-gallery .lae-heading a',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_filters_styling',
            [
                'label' => __('Gallery Filters', 'livemesh-el-addons'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'filter_color',
            [
                'label' => __('Filter Color', 'livemesh-el-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lae-block .lae-taxonomy-filter .lae-filter-item a, {{WRAPPER}} .lae-block .lae-block-filter .lae-block-filter-item a, {{WRAPPER}} .lae-block .lae-block-filter .lae-block-filter-more span, {{WRAPPER}} .lae-block .lae-block-filter ul.lae-block-filter-dropdown-list li a' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'filter_hover_color',
            [
                'label' => __('Filter Hover Color', 'livemesh-el-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lae-block .lae-taxonomy-filter .lae-filter-item a:hover, {{WRAPPER}} .lae-block-gallery .lae-taxonomy-filter .lae-filter-item.lae-active a, {{WRAPPER}} .lae-block .lae-block-filter .lae-block-filter-item a:hover, {{WRAPPER}} .lae-block .lae-block-filter .lae-block-filter-item.lae-active a' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'filter_typography',
                'selector' => '{{WRAPPER}} .lae-block .lae-taxonomy-filter .lae-filter-item a, {{WRAPPER}} .lae-block .lae-block-filter .lae-block-filter-item a, {{WRAPPER}} .lae-block .lae-block-filter .lae-block-filter-more span, {{WRAPPER}} .lae-block .lae-block-filter ul.lae-block-filter-dropdown-list li a',
            ]
        );

        $this->end_controls_section();

        /* $this->start_controls_section(
            'section_thumbnail_styling',
            [
                'label' => __('Gallery Thumbnail', 'livemesh-el-addons'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'thumbnail_hover_brightness',
            [
                'label' => __( 'Thumbnail Hover Brightness (%)', 'livemesh-el-addons' ),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 50,
                ],
                'range' => [
                    'px' => [
                        'max' => 100,
                        'min' => 0,
                        'step' => 10,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .lae-block-gallery .lae-module .lae-module-image:hover > img' => '-webkit-filter: brightness({{SIZE}}%);filter: brightness({{SIZE}}%)',
                ],
            ]
        );

        $this->end_controls_section(); */

        $this->start_controls_section(
            'section_item_title_styling',
            [
                'label' => __('Gallery Item Title', 'livemesh-el-addons'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'display_item_title' => ['yes']
                ],
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
                    '{{WRAPPER}} .lae-block-gallery .lae-module .lae-entry-title , {{WRAPPER}} .lae-block-gallery .lae-module .lae-module-image .lae-module-image-info .lae-entry-title, {{WRAPPER}} .lae-block-gallery .lae-module .lae-entry-title a, {{WRAPPER}} .lae-block-gallery .lae-module .lae-module-image .lae-module-image-info .lae-entry-title a' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'title_hover_color',
            [
                'label' => __('Title Hover Color', 'livemesh-el-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lae-block-gallery .lae-module .lae-entry-title a:hover, {{WRAPPER}} .lae-block-gallery .lae-module .lae-module-image .lae-module-image-info .lae-entry-title a:hover' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'item_title_typography',
                'selector' => '{{WRAPPER}} .lae-block-gallery .lae-module .lae-entry-title , {{WRAPPER}} .lae-block-gallery .lae-module .lae-module-image .lae-module-image-info .lae-entry-title, {{WRAPPER}} .lae-block-gallery .lae-module .lae-entry-title a, {{WRAPPER}} .lae-block-gallery .lae-module .lae-module-image .lae-module-image-info .lae-entry-title a',
            ]
        );


        $this->end_controls_section();

        $this->start_controls_section(
            'section_item_tags',
            [
                'label' => __('Gallery Item Tags', 'livemesh-el-addons'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'display_item_tags' => ['yes']
                ],
            ]
        );

        $this->add_control(
            'item_tags_color',
            [
                'label' => __('Item Tags Color', 'livemesh-el-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lae-block-gallery .lae-module .lae-module-meta .lae-terms, {{WRAPPER}} .lae-block-gallery .lae-module .lae-module-image .lae-terms, {{WRAPPER}} .lae-block-gallery .lae-module .lae-module-image-info .lae-terms' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'item_tags_typography',
                'selector' => '{{WRAPPER}} .lae-block-gallery .lae-module .lae-module-meta .lae-terms, {{WRAPPER}} .lae-block-gallery .lae-module .lae-module-image .lae-terms, {{WRAPPER}} .lae-block-gallery .lae-module .lae-module-image-info .lae-terms',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_entry_description_styling',
            [
                'label' => __('Gallery Entry Description', 'livemesh-el-addons'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'block_type' => ['block_gallery_2', 'block_gallery_3'],
                    'display_description' => ['yes']
                ],
            ]
        );

        $this->add_control(
            'entry_description_color',
            [
                'label' => __('Description Color', 'livemesh-el-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lae-block-gallery .lae-module .lae-entry-summary' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'entry_description_typography',
                'selector' => '{{WRAPPER}} .lae-block-gallery .lae-module .lae-entry-summary',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_pagination_styling',
            [
                'label' => __('Pagination', 'livemesh-el-addons'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'pagination' => 'paged',
                ],
            ]
        );

        $this->add_control(
            'pagination_border_color',
            [
                'label' => __('Border Color', 'livemesh-el-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lae-block-gallery .lae-pagination .lae-page-nav' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'pagination_hover_bg_color',
            [
                'label' => __('Hover Background Color', 'livemesh-el-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lae-block-gallery .lae-pagination .lae-page-nav:hover, {{WRAPPER}} .lae-block-gallery .lae-pagination .lae-page-nav.lae-current-page' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'pagination_nav_icon_color',
            [
                'label' => __('Nav Icon Color', 'livemesh-el-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lae-block-gallery .lae-pagination .lae-page-nav i' => 'color: {{VALUE}};',
                ],
            ]
        );


        $this->add_control(
            'pagination_hover_nav_icon_color',
            [
                'label' => __('Hover Nav Icon Color', 'livemesh-el-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lae-block-gallery .lae-pagination .lae-page-nav:hover i' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'pagination_disabled_nav_icon_color',
            [
                'label' => __('Disabled Nav Icon Color', 'livemesh-el-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lae-block-gallery .lae-pagination .lae-page-nav.lae-disabled i' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'heading_nav_text',
            [
                'label' => __('Navigation text', 'livemesh-el-addons'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );


        $this->add_control(
            'pagination_text_color',
            [
                'label' => __('Nav Text Color', 'livemesh-el-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lae-block-gallery .lae-pagination .lae-page-nav' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'pagination_hover_text_color',
            [
                'label' => __('Hover Nav Text Color', 'livemesh-el-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lae-block-gallery .lae-pagination .lae-page-nav:hover, {{WRAPPER}} .lae-block-gallery .lae-pagination .lae-page-nav.lae-current-page' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'label' => __('Nav Text Typography', 'livemesh-el-addons'),
                'name' => 'pagination_text_typography',
                'selector' => '{{WRAPPER}} .lae-block-gallery .lae-pagination .lae-page-nav',
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
                    '{{WRAPPER}} .lae-block-gallery .lae-load-more' => 'background-color: {{VALUE}};',
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
                    '{{WRAPPER}} .lae-block-gallery .lae-load-more:hover' => 'background-color: {{VALUE}};',
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
                    '{{WRAPPER}} .lae-block-gallery .lae-load-more' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                    '{{WRAPPER}} .lae-block-gallery .lae-load-more' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                    '{{WRAPPER}} .lae-block-gallery .lae-load-more' => 'color: {{VALUE}};',
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
                'selector' => '{{WRAPPER}} .lae-block-gallery .lae-load-more',
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

        $settings = apply_filters('lae_gallery_block_' . $this->get_id() . '_settings', $settings);

        $settings['block_id'] = $this->get_id();

        self::$gallery_counter++;

        $settings['block_class'] = !empty($settings['gallery_class']) ? sanitize_title($settings['gallery_class']) : 'gallery-' . self::$gallery_counter;

        $settings = lae_parse_gallery_block_settings($settings);

        $block = LAE_Blocks_Manager::get_instance($settings['block_type']);

        $output = $block->render($settings);

        echo apply_filters('lae_gallery_block_output', $output, $settings);
    }

    /**
     * Render the widget output in the editor.
     * @return void
     */
    protected function content_template() {
    }

}