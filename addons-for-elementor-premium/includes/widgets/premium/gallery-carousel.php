<?php

/*
Widget Name: Gallery Carousel
Description: Display images or videos in a responsive carousel.
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
use Elementor\Modules\DynamicTags\Module as TagsModule;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

/**
 * Class for Gallery Carousel widget that displays images or videos in a responsive carousel.
 */
class LAE_Gallery_Carousel_Widget extends LAE_Widget_Base {

    static public $gallery_counter = 0;

    /**
     * Get the name for the widget
     * @return string
     */
    public function get_name() {
        return 'lae-gallery-carousel';
    }

    /**
     * Get the widget title
     * @return string|void
     */
    public function get_title() {
        return __('Gallery Carousel', 'livemesh-el-addons');
    }

    /**
     * Get the widget icon
     * @return string
     */
    public function get_icon() {
        return 'lae-icon-gallery-carousel';
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
        return 'https://livemeshelementor.com/docs/livemesh-addons/premium-addons/image-video-carousel/';
    }

    /**
     * Obtain the scripts required for the widget to function
     * @return string[]
     */
    public function get_script_depends() {
        return [
            'jquery-fancybox',
            'lae-jquery-slick',
            'lae-frontend-scripts',
            'lae-carousel-helper-scripts',
            'lae-gallery-carousel-scripts'
        ];
    }

    /**
     * Register the controls for the widget
     * Adds fields that help configure and customize the widget
     * @return void
     */
    protected function register_controls() {

        $this->start_controls_section(
            'section_gallery_carousel',
            [
                'label' => __('Gallery Items', 'livemesh-el-addons'),
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
            'item_label',
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
                'description' => __('One or more comma separated tags for the gallery item.', 'livemesh-el-addons'),
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
            'item_description',
            [

                'label' => __('Item description', 'livemesh-el-addons'),
                'type' => Controls_Manager::TEXTAREA,
                'description' => __('Short description for the gallery item displayed in the lightbox gallery.(optional)', 'livemesh-el-addons'),
                'label_block' => true,
                'dynamic' => [
                    'active' => true,
                ],
            ]
        );

        $this->add_control(
            'gallery_items',
            [
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'title_field' => '{{{ item_label }}}',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_general',
            [
                'label' => __('General', 'livemesh-el-addons'),
                'tab' => Controls_Manager::TAB_SETTINGS,
            ]
        );

        $this->add_control(
            'gallery_class', [
                'type' => Controls_Manager::TEXT,
                'description' => __('Specify an unique identifier used as a custom CSS class name and lightbox group name/slug for the gallery carousel element.', 'livemesh-el-addons'),
                'label' => __('Gallery Class/Identifier', 'livemesh-el-addons'),
                'default' => ''
            ]
        );

        $this->add_control(
            'display_item_title',
            [
                'label' => __('Display image/video title?', 'livemesh-el-addons'),
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
                'label' => __('Display image/video tags?', 'livemesh-el-addons'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'livemesh-el-addons'),
                'label_off' => __('No', 'livemesh-el-addons'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
                'name' => 'thumbnail_size',
                'label' => __('Gallery Image Size', 'livemesh-el-addons'),
                'default' => 'large',
                'separator' => 'before',
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
            'section_carousel_options',
            [
                'label' => __('Carousel Options', 'livemesh-el-addons'),
                'tab' => Controls_Manager::TAB_SETTINGS,
            ]
        );

        $this->add_control(
            'arrows',
            [
                'type' => Controls_Manager::SWITCHER,
                'label_off' => __('No', 'livemesh-el-addons'),
                'label_on' => __('Yes', 'livemesh-el-addons'),
                'return_value' => 'yes',
                'separator' => 'before',
                'default' => 'yes',
                'label' => __('Prev/Next Arrows?', 'livemesh-el-addons'),
            ]
        );


        $this->add_control(
            'dots',
            [
                'type' => Controls_Manager::SWITCHER,
                'label_off' => __('No', 'livemesh-el-addons'),
                'label_on' => __('Yes', 'livemesh-el-addons'),
                'return_value' => 'yes',
                'default' => 'no',
                'label' => __('Show dot indicators for navigation?', 'livemesh-el-addons'),
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
            ]
        );

        $this->add_control(
            'autoplay',
            [
                'type' => Controls_Manager::SWITCHER,
                'label_off' => __('No', 'livemesh-el-addons'),
                'label_on' => __('Yes', 'livemesh-el-addons'),
                'separator' => 'before',
                'return_value' => 'yes',
                'default' => 'no',
                'label' => __('Autoplay?', 'livemesh-el-addons'),
                'description' => __('Should the carousel autoplay as in a slideshow.', 'livemesh-el-addons'),
            ]
        );

        $this->add_control(
            'autoplay_speed',
            [
                'label' => __('Autoplay speed in ms', 'livemesh-el-addons'),
                'type' => Controls_Manager::NUMBER,
                'default' => 3000,
            ]
        );


        $this->add_control(
            'animation_speed',
            [
                'label' => __('Autoplay animation speed in ms', 'livemesh-el-addons'),
                'type' => Controls_Manager::NUMBER,
                'default' => 300,
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_responsive',
            [
                'label' => __('Responsive Options', 'livemesh-el-addons'),
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
            'display_columns',
            [
                'label' => __('Columns per row', 'livemesh-el-addons'),
                'type' => Controls_Manager::NUMBER,
                'min' => 1,
                'max' => 5,
                'step' => 1,
                'default' => 3,
            ]
        );


        $this->add_control(
            'scroll_columns',
            [
                'label' => __('Columns to scroll', 'livemesh-el-addons'),
                'type' => Controls_Manager::NUMBER,
                'min' => 1,
                'max' => 5,
                'step' => 1,
                'default' => 3,
            ]
        );


        $this->add_control(
            'gutter',
            [
                'label' => __('Gutter', 'livemesh-el-addons'),
                'description' => __('Space between columns.', 'livemesh-el-addons'),
                'type' => Controls_Manager::NUMBER,
                'default' => 10,
                'selectors' => [
                    '{{WRAPPER}} .lae-gallery-carousel .lae-gallery-carousel-item' => 'padding: {{VALUE}}px;',
                ],
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
            'tablet_display_columns',
            [
                'label' => __('Columns per row', 'livemesh-el-addons'),
                'type' => Controls_Manager::NUMBER,
                'min' => 1,
                'max' => 5,
                'step' => 1,
                'default' => 2,
            ]
        );

        $this->add_control(
            'tablet_scroll_columns',
            [
                'label' => __('Columns to scroll', 'livemesh-el-addons'),
                'type' => Controls_Manager::NUMBER,
                'min' => 1,
                'max' => 5,
                'step' => 1,
                'default' => 2,
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
                    '(tablet-){{WRAPPER}} .lae-gallery-carousel .lae-gallery-carousel-item' => 'padding: {{VALUE}}px;',
                ],
            ]
        );

        $this->add_control(
            'tablet_width',
            [
                'label' => __('Tablet Resolution', 'livemesh-el-addons'),
                'description' => __('The resolution to treat as a tablet resolution.', 'livemesh-el-addons'),
                'type' => Controls_Manager::NUMBER,
                'default' => 800,
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
            'mobile_display_columns',
            [
                'label' => __('Columns per row', 'livemesh-el-addons'),
                'type' => Controls_Manager::NUMBER,
                'min' => 1,
                'max' => 3,
                'step' => 1,
                'default' => 1,
            ]
        );

        $this->add_control(
            'mobile_scroll_columns',
            [
                'label' => __('Columns to scroll', 'livemesh-el-addons'),
                'type' => Controls_Manager::NUMBER,
                'min' => 1,
                'max' => 3,
                'step' => 1,
                'default' => 1,
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
                    '(mobile-){{WRAPPER}} .lae-gallery-carousel .lae-gallery-carousel-item' => 'padding: {{VALUE}}px;',
                ],
            ]
        );

        $this->add_control(
            'mobile_width',
            [
                'label' => __('Tablet Resolution', 'livemesh-el-addons'),
                'description' => __('The resolution to treat as a tablet resolution.', 'livemesh-el-addons'),
                'type' => Controls_Manager::NUMBER,
                'default' => 480,
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
            'section_item_thumbnail_styling',
            [
                'label' => __('Gallery Thumbnail', 'livemesh-el-addons'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );


        $this->add_control(
            'thumbnail_hover_bg_color',
            [
                'label' => __('Thumbnail Hover Background Color', 'livemesh-el-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lae-gallery-carousel .lae-gallery-carousel-item .lae-project-image .lae-image-overlay' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'thumbnail_hover_opacity',
            [
                'label' => __('Thumbnail Hover Opacity (%)', 'livemesh-el-addons'),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 0.5,
                ],
                'range' => [
                    'px' => [
                        'max' => 1,
                        'min' => 0.10,
                        'step' => 0.01,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .lae-gallery-carousel .lae-gallery-carousel-item .lae-project-image:hover .lae-image-overlay' => 'opacity: {{SIZE}};',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_item_title_styling',
            [
                'label' => __('Gallery Item Title', 'livemesh-el-addons'),
                'tab' => Controls_Manager::TAB_STYLE,
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
                'label' => __('Title Color', 'livemesh-el-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lae-gallery-carousel .lae-gallery-carousel-item .lae-project-image .lae-image-info .lae-entry-title a' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'title_hover_border_color',
            [
                'label' => __('Title Hover Border Color', 'livemesh-el-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lae-gallery-carousel .lae-gallery-carousel-item .lae-project-image .lae-image-info .lae-entry-title a:hover' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'selector' => '{{WRAPPER}} .lae-gallery-carousel .lae-gallery-carousel-item .lae-project-image .lae-image-info .lae-entry-title',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_item_tags',
            [
                'label' => __('Gallery Item Tags', 'livemesh-el-addons'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'tags_color',
            [
                'label' => __('Item Tags Color', 'livemesh-el-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lae-gallery-carousel .lae-gallery-carousel-item .lae-project-image .lae-image-info .lae-terms' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'tags_typography',
                'selector' => '{{WRAPPER}} .lae-gallery-carousel .lae-gallery-carousel-item .lae-project-image .lae-image-info .lae-terms',
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

        $settings = apply_filters('lae_gallery_carousel_' . $this->get_id() . '_settings', $settings);

        self::$gallery_counter++;

        $settings['gallery_class'] = !empty($settings['gallery_class']) ? sanitize_title($settings['gallery_class']) : 'gallery-carousel-' . self::$gallery_counter;

        $settings['gallery_id'] = $this->get_id();

        $args['settings'] = $settings;

        $args['widget_instance'] = $this;

        lae_get_template_part("premium/addons/gallery-carousel/loop", $args);


    }

    /**
     * Render the widget output in the editor.
     * @return void
     */
    protected function content_template() {
    }

}