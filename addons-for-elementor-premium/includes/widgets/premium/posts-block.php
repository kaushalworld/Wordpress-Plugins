<?php

/*
Widget Name: Posts Block
Description: Display your blog posts or custom post types in a filterable block list layout.
Author: LiveMesh
Author URI: https://www.livemeshthemes.com
*/

namespace LivemeshAddons\Widgets;

use LivemeshAddons\Blocks\LAE_Blocks_Manager;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Scheme_Color;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Image_Size;
use Elementor\Scheme_Typography;


if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

/**
 * Class for Posts Block widget that displays your blog posts or custom post types in a filterable block list layout.
 */
class LAE_Posts_Block_Widget extends LAE_Widget_Base {

    static public $block_counter = 0;

    /**
     * Get the name for the widget
     * @return string
     */
    public function get_name() {
        return 'lae-posts-block';
    }

    /**
     * Get the widget title
     * @return string|void
     */
    public function get_title() {
        return __('Posts Block', 'livemesh-el-addons');
    }

    /**
     * Get the widget icon
     * @return string
     */
    public function get_icon() {
        return 'lae-icon-posts-block';
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
        return 'https://livemeshelementor.com/docs/livemesh-addons/premium-addons/posts-block/';
    }

    /**
     * Obtain the scripts required for the widget to function
     * @return string[]
     */
    public function get_script_depends() {
        return [
            'jquery-fancybox',
            'imagesloaded.pkgd',
            'lae-waypoints',
            'lae-frontend-scripts',
            'lae-blocks-scripts',
            'lae-posts-block-scripts'
        ];
    }

    /**
     * Register the controls for the widget
     * Adds fields that help configure and customize the widget
     * @return void
     */
    protected function register_controls() {

        $this->start_controls_section(
            'section_query',
            [
                'label' => __('Post Query', 'livemesh-el-addons'),
            ]
        );



        $this->add_control(
            'query_type',
            [
                'label' => __('Source', 'livemesh-el-addons'),
                'type' => Controls_Manager::SELECT,
                'options' => array(
                    'custom_query' => __('Custom Query', 'livemesh-el-addons'),
                    'current_query' => __('Current Query', 'livemesh-el-addons'),
                    'related' => __('Related', 'livemesh-el-addons'),
                ),
                'default' => 'custom_query',
            ]
        );

        $this->add_control(
            'post_types',
            [
                'label' => __('Post Types', 'livemesh-el-addons'),
                'type' => Controls_Manager::SELECT2,
                'default' => 'post',
                'options' => lae_get_all_post_type_options(),
                'multiple' => true,
                'condition' => [
                    'query_type' => 'custom_query'
                ]
            ]
        );

        $this->add_control(
            'taxonomies',
            [
                'type' => Controls_Manager::SELECT2,
                'label' => __('Choose the taxonomies to display related posts.', 'livemesh-el-addons'),
                'label_block' => true,
                'description' => __('Choose the taxonomies to be used for displaying posts related to current post, page or custom post type.', 'livemesh-el-addons'),
                'options' => lae_get_taxonomies_map(),
                'default' => 'category',
                'multiple' => true,
                'condition' => [
                    'query_type' => 'related'
                ]
            ]
        );

        $this->add_control(
            'tax_query',
            [
                'label' => __('Taxonomies', 'livemesh-el-addons'),
                'type' => Controls_Manager::SELECT2,
                'options' => lae_get_all_taxonomy_options(),
                'multiple' => true,
                'label_block' => true,
                'condition' => [
                    'query_type' => 'custom_query'
                ]
            ]
        );

        $this->add_control(
            'post_in',
            [
                'label' => __('Post In', 'livemesh-el-addons'),
                'description' => __('Provide a comma separated list of Post IDs to display in the posts block.', 'livemesh-el-addons'),
                'type' => Controls_Manager::TEXT,
                'label_block' => true,
                'condition' => [
                    'query_type' => 'custom_query'
                ]
            ]
        );

        $this->add_control(
            'posts_per_page',
            [
                'label' => __('Posts Per Page', 'livemesh-el-addons'),
                'type' => Controls_Manager::NUMBER,
                'default' => 6,
                'condition' => [
                    'query_type' => ['custom_query', 'related']
                ]
            ]
        );

        $this->add_control(
            'advanced',
            [
                'label' => __('Advanced', 'livemesh-el-addons'),
                'type' => Controls_Manager::HEADING,
                'condition' => [
                    'query_type' => ['custom_query', 'related']
                ]
            ]
        );

        $this->add_control(
            'orderby',
            [
                'label' => __('Order By', 'livemesh-el-addons'),
                'type' => Controls_Manager::SELECT,
                'options' => array(
                    'none' => __('No order', 'livemesh-el-addons'),
                    'ID' => __('Post ID', 'livemesh-el-addons'),
                    'author' => __('Author', 'livemesh-el-addons'),
                    'title' => __('Title', 'livemesh-el-addons'),
                    'date' => __('Published date', 'livemesh-el-addons'),
                    'modified' => __('Modified date', 'livemesh-el-addons'),
                    'parent' => __('By parent', 'livemesh-el-addons'),
                    'rand' => __('Random order', 'livemesh-el-addons'),
                    'comment_count' => __('Comment count', 'livemesh-el-addons'),
                    'menu_order' => __('Menu order', 'livemesh-el-addons'),
                    'post__in' => __('By include order', 'livemesh-el-addons'),
                ),
                'default' => 'date',
                'condition' => [
                    'query_type' => ['custom_query', 'related']
                ]
            ]
        );

        $this->add_control(
            'order',
            [
                'label' => __('Order', 'livemesh-el-addons'),
                'type' => Controls_Manager::SELECT,
                'options' => array(
                    'ASC' => __('Ascending', 'livemesh-el-addons'),
                    'DESC' => __('Descending', 'livemesh-el-addons'),
                ),
                'default' => 'DESC',
                'condition' => [
                    'query_type' => ['custom_query', 'related']
                ]
            ]
        );

        $this->add_control(
            'exclude_posts',
            [
                'label' => __('Exclude Posts', 'livemesh-el-addons'),
                'description' => __('Provide a comma separated list of Post IDs to exclude in the posts block.', 'livemesh-el-addons'),
                'type' => Controls_Manager::TEXT,
                'condition' => [
                    'query_type' => ['custom_query', 'related']
                ]
            ]
        );

        $this->add_control(
            'offset',
            [
                'label' => __('Offset', 'livemesh-el-addons'),
                'description' => __('Number of posts to skip or pass over.', 'livemesh-el-addons'),
                'type' => Controls_Manager::NUMBER,
                'default' => 0,
                'condition' => [
                    'query_type' => 'custom_query'
                ]
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_post_content',
            [
                'label' => __('Block Heading', 'livemesh-el-addons'),
            ]
        );

        $this->add_control(
            'heading',
            [
                'label' => __('Heading for the block', 'livemesh-el-addons'),
                'type' => Controls_Manager::TEXT,
                'placeholder' => __('My Posts', 'livemesh-el-addons'),
                'default' => __('My Posts', 'livemesh-el-addons'),
                'dynamic' => [
                    'active' => true,
                ],
            ]
        );

        $this->add_control(
            'heading_url',
            [
                'label' => __('URL for the heading of the block', 'livemesh-el-addons'),
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

        $this->end_controls_section();


        $this->start_controls_section(
            'section_settings',
            [
                'label' => __('General', 'livemesh-el-addons'),
                'tab' => Controls_Manager::TAB_SETTINGS,
            ]
        );

        $this->add_control(
            'block_class', [
                'type' => Controls_Manager::TEXT,
                "description" => __("Specify an unique identifier used as a custom CSS class name and lightbox group name/slug for the block element.", "livemesh-el-addons"),
                "label" => __("Block Class/Identifier", "livemesh-el-addons"),
                'default' => ''
            ]
        );

        $this->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
                'name' => 'thumbnail_size',
                'label' => __( 'Image Size', 'livemesh-el-addons' ),
                'default' => 'large',
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
            'taxonomy_chosen',
            [
                'type' => Controls_Manager::SELECT,
                'label' => __('Choose the taxonomy to display and filter on.', 'livemesh-el-addons'),
                'label_block' => true,
                'description' => __('Choose the taxonomy information to display for posts/portfolio and the taxonomy that is used to filter the portfolio/post. Takes effect only if no taxonomy filters are specified when building query.', 'livemesh-el-addons'),
                'options' => lae_get_taxonomies_map(),
                'default' => 'category',
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
                'default' => 'block_header_1',
            ]
        );

        $this->add_control(
            'block_type',
            [
                'type' => Controls_Manager::SELECT,
                'label' => __('Choose Block Style', 'livemesh-el-addons'),
                'options' => array(
                    'block_1' => __('Block Style 1', 'livemesh-el-addons'),
                    'block_2' => __('Block Style 2', 'livemesh-el-addons'),
                    'block_3' => __('Block Style 3', 'livemesh-el-addons'),
                    'block_4' => __('Block Style 4', 'livemesh-el-addons'),
                    'block_5' => __('Block Style 5', 'livemesh-el-addons'),
                    'block_6' => __('Block Style 6', 'livemesh-el-addons'),
                    'block_7' => __('Block Style 7', 'livemesh-el-addons'),
                    'block_8' => __('Block Style 8', 'livemesh-el-addons'),
                    'block_9' => __('Block Style 9', 'livemesh-el-addons'),
                    'block_10' => __('Block Style 10', 'livemesh-el-addons'),
                    'block_11' => __('Block Style 11', 'livemesh-el-addons'),
                    'block_12' => __('Block Style 12', 'livemesh-el-addons'),
                    'block_13' => __('Block Style 13', 'livemesh-el-addons'),
                ),
                'default' => 'block_1',
            ]
        );

        $this->add_control(
            'per_line1',
            [
                'label' => __('Columns per row', 'livemesh-el-addons'),
                'type' => Controls_Manager::SELECT,
                'default' => '2',
                'options' => [
                    '1' => '1',
                    '2' => '2',
                    '3' => '3',
                ],
                'condition' => [
                    'block_type' => ['block_1', 'block_3', 'block_11', 'block_12']
                ]
            ]
        );

        $this->add_responsive_control(
            'per_line2',
            [
                'label' => __( 'Columns per row', 'livemesh-el-addons' ),
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
                'condition' => [
                    'block_type' => ['block_2', 'block_4', 'block_5', 'block_6', 'block_10']
                ],
                'frontend_available' => true,
            ]
        );

        $this->add_control(
            'image_linkable',
            [
                'label' => __('Link Images to Posts?', 'livemesh-el-addons'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'livemesh-el-addons'),
                'label_off' => __('No', 'livemesh-el-addons'),
                'return_value' => 'yes',
                'default' => 'yes',
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
            'enable_lightbox',
            [
                'type' => Controls_Manager::SWITCHER,
                'label_off' => __('No', 'livemesh-el-addons'),
                'label_on' => __('Yes', 'livemesh-el-addons'),
                'return_value' => 'yes',
                'default' => '',
                'label' => __('Enable Lightbox Gallery?', 'livemesh-el-addons'),
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
            'display_title',
            [
                'label' => __('Display posts title below the post item?', 'livemesh-el-addons'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'livemesh-el-addons'),
                'label_off' => __('No', 'livemesh-el-addons'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'display_summary',
            [
                'label' => __('Display post excerpt/summary below the post item?', 'livemesh-el-addons'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'livemesh-el-addons'),
                'label_off' => __('No', 'livemesh-el-addons'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'rich_text_excerpt',
            [
                'label' => __('Preserve shortcodes/HTML tags in excerpt?', 'livemesh-el-addons'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'livemesh-el-addons'),
                'label_off' => __('No', 'livemesh-el-addons'),
                'return_value' => 'yes',
            ]
        );

        $this->add_control(
            'excerpt_length',
            [
                'label' => __('Excerpt length in number of words.', 'livemesh-el-addons'),
                'type' => Controls_Manager::NUMBER,
                'min' => 5,
                'max' => 500,
                'step' => 1,
                'default' => 25,
            ]
        );

        $this->add_control(
            'display_author',
            [
                'label' => __('Display post author info below the post item?', 'livemesh-el-addons'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'livemesh-el-addons'),
                'label_off' => __('No', 'livemesh-el-addons'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );


        $this->add_control(
            'display_post_date',
            [
                'label' => __('Display post date info below the post item?', 'livemesh-el-addons'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'livemesh-el-addons'),
                'label_off' => __('No', 'livemesh-el-addons'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );


        $this->add_control(
            'display_comments',
            [
                'label' => __('Display post comments below the post item?', 'livemesh-el-addons'),
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
                'label' => __('Display read more link to the post/portfolio?', 'livemesh-el-addons'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'livemesh-el-addons'),
                'label_off' => __('No', 'livemesh-el-addons'),
                'return_value' => 'yes',
                'default' => 'no',
                'condition' => [
                    'block_type' => ['block_1', 'block_2', 'block_3', 'block_6', 'block_8', 'block_9', 'block_11', 'block_13']
                ],
            ]
        );

        $this->add_control(
            'read_more_text',
            [
                'label' => __('Read more text', 'livemesh-el-addons'),
                'type' => Controls_Manager::TEXT,
                "description" => __('Specify the text for the read more link/button', 'livemesh-el-addons'),
                'default' => __('Read More', 'livemesh-el-addons'),
                'condition' => [
                    'block_type' => ['block_1', 'block_2', 'block_3', 'block_6', 'block_8', 'block_9', 'block_11', 'block_13']
                ],
            ]
        );

        $this->add_control(
            'display_excerpt_lightbox',
            [
                'label' => __('Display post excerpt/summary in the lightbox?', 'livemesh-el-addons'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'livemesh-el-addons'),
                'label_off' => __('No', 'livemesh-el-addons'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );


        $this->add_control(
            'display_taxonomy',
            [
                'label' => __('Display taxonomy info below the post item? Choose the right taxonomy in Block Content section above.', 'livemesh-el-addons'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'livemesh-el-addons'),
                'label_off' => __('No', 'livemesh-el-addons'),
                'return_value' => 'yes',
                'default' => 'yes',
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
                'description' => __('Choose pagination type or choose None if no pagination is desired. Make sure the \'Post per page\' field value is set in the Build Query window to control number of posts to display per page.', 'livemesh-el-addons'),
                'options' => array(
                    'none' => __('None', 'livemesh-el-addons'),
                    'next_prev' => __('Next Prev', 'livemesh-el-addons'),
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
                'label' => __('Display count of posts yet to be loaded with the load more button?', 'livemesh-el-addons'),
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

        $this->end_controls_section();

        $this->start_controls_section(
            'section_heading_styling',
            [
                'label' => __('Block Heading', 'livemesh-el-addons'),
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
                    '{{WRAPPER}} .lae-block .lae-heading span, {{WRAPPER}} .lae-block .lae-heading a' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'heading_typography',
                'selector' => '{{WRAPPER}} .lae-block .lae-heading span, {{WRAPPER}} .lae-block .lae-heading a',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_filters_styling',
            [
                'label' => __('Block Filters', 'livemesh-el-addons'),
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
                    '{{WRAPPER}} .lae-block .lae-taxonomy-filter .lae-filter-item a:hover, {{WRAPPER}} .lae-block-grid .lae-taxonomy-filter .lae-filter-item.lae-active a, {{WRAPPER}} .lae-block .lae-block-filter .lae-block-filter-item a:hover, {{WRAPPER}} .lae-block .lae-block-filter .lae-block-filter-item.lae-active a' => 'color: {{VALUE}};',
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
            'section_entry_thumbnail_styling',
            [
                'label' => __('Entry Thumbnail', 'livemesh-el-addons'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );


        $this->add_control(
            'thumbnail_hover_bg_color',
            [
                'label' => __( 'Thumbnail Hover Background Color', 'livemesh-el-addons' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lae-block .lae-module .lae-module-image .lae-image-overlay' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'thumbnail_hover_opacity',
            [
                'label' => __( 'Thumbnail Hover Opacity (%)', 'livemesh-el-addons' ),
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
                    '{{WRAPPER}} .lae-block .lae-module .lae-module-image:hover .lae-image-overlay' => 'opacity: {{SIZE}};',
                ],
            ]
        );

        $this->end_controls_section(); */

        $this->start_controls_section(
            'section_entry_taxonomy_term_styling',
            [
                'label' => __('Entry Taxonomy Term', 'livemesh-el-addons'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'entry_terms_color',
            [
                'label' => __('Taxonomy Terms Color', 'livemesh-el-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lae-module .lae-module-image .lae-terms a' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'entry_terms_bg_color',
            [
                'label' => __('Taxonomy Terms Background Color', 'livemesh-el-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lae-module .lae-module-image .lae-terms' => 'background-color: {{VALUE}};',
                ],
            ]
        );


        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'tags_typography',
                'selector' => '{{WRAPPER}} .lae-module .lae-module-image .lae-terms a',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_entry_title_styling',
            [
                'label' => __('Entry Title', 'livemesh-el-addons'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'entry_title_tag',
            [
                'label' => __('Entry Title HTML Tag', 'livemesh-el-addons'),
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
            'entry_title_color',
            [
                'label' => __('Entry Title Color', 'livemesh-el-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lae-block .lae-module .entry-title a' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'entry_title_hover_color',
            [
                'label' => __('Entry Title Hover Color', 'livemesh-el-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lae-block .lae-module .entry-title a:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'entry_title_typography',
                'selector' => '{{WRAPPER}} .lae-block .lae-module .entry-title a',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_entry_summary_styling',
            [
                'label' => __('Entry Summary', 'livemesh-el-addons'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'entry_summary_color',
            [
                'label' => __('Entry Summary Color', 'livemesh-el-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lae-block .lae-module .entry-summary' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'entry_summary_typography',
                'selector' => '{{WRAPPER}} .lae-block .lae-module .entry-summary',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_entry_meta_styling',
            [
                'label' => __('Entry Meta', 'livemesh-el-addons'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'entry_meta_color',
            [
                'label' => __('Entry Meta Color', 'livemesh-el-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lae-block .lae-module .lae-module-meta span' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'entry_meta_link_color',
            [
                'label' => __('Entry Meta Link Color', 'livemesh-el-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lae-block .lae-module .lae-module-meta span a' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'entry_meta_link_hover_color',
            [
                'label' => __('Entry Meta Link Hover Color', 'livemesh-el-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lae-block .lae-module .lae-module-meta span a:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'entry_meta_typography',
                'selector' => '{{WRAPPER}} .lae-block .lae-module .lae-module-meta span, {{WRAPPER}} .lae-block .lae-module .lae-module-meta span a',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_read_more_link_styling',
            [
                'label' => __('Read More Link', 'livemesh-el-addons'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'read_more_link_color',
            [
                'label' => __('Link Color', 'livemesh-el-addons'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .lae-module .lae-read-more a:not(.lae-button)' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'read_more_link_hover_color',
            [
                'label' => __('Link Hover Color', 'livemesh-el-addons'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .lae-module .lae-read-more a:not(.lae-button):hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'read_more_link_typography',
                'label' => __('Typography', 'livemesh-el-addons'),
                'selector' => '{{WRAPPER}} .lae-module .lae-read-more a:not(.lae-button)',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_read_more_button_styling',
            [
                'label' => __('Read More Button', 'livemesh-el-addons'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'read_more_button_custom_color',
            [
                'label' => __('Button Color', 'livemesh-el-addons'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .lae-module .lae-read-more a.lae-button' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'read_more_button_custom_hover_color',
            [
                'label' => __('Button Hover Color', 'livemesh-el-addons'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .lae-module .lae-read-more a.lae-button:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'read_more_button_padding',
            [
                'label' => __('Custom Padding', 'livemesh-el-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .lae-module .lae-read-more a.lae-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'isLinked' => false
            ]
        );

        $this->add_control(
            'read_more_button_border_radius',
            [
                'label' => __('Custom Border Radius', 'livemesh-el-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .lae-module .lae-read-more a.lae-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'read_more_button_label_color',
            [
                'label' => __('Label Color', 'livemesh-el-addons'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .lae-module .lae-read-more a.lae-button' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'read_more_button_label_hover_color',
            [
                'label' => __('Label Hover Color', 'livemesh-el-addons'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .lae-module .lae-read-more a.lae-button:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'read_more_button_typography',
                'label' => __('Typography', 'livemesh-el-addons'),
                'selector' => '{{WRAPPER}} .lae-module .lae-read-more a.lae-button',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_pagination_styling',
            [
                'label' => __('Pagination', 'livemesh-el-addons'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'pagination_border_color',
            [
                'label' => __('Border Color', 'livemesh-el-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lae-block .lae-pagination .lae-page-nav' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'pagination_hover_bg_color',
            [
                'label' => __('Hover Background Color', 'livemesh-el-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lae-block .lae-pagination .lae-page-nav:hover, {{WRAPPER}} .lae-block .lae-pagination .lae-page-nav.lae-current-page' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'pagination_nav_icon_color',
            [
                'label' => __('Nav Icon Color', 'livemesh-el-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lae-block .lae-pagination .lae-page-nav i' => 'color: {{VALUE}};',
                ],
            ]
        );


        $this->add_control(
            'pagination_hover_nav_icon_color',
            [
                'label' => __('Hover Nav Icon Color', 'livemesh-el-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lae-block .lae-pagination .lae-page-nav:hover i' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'pagination_disabled_nav_icon_color',
            [
                'label' => __('Disabled Nav Icon Color', 'livemesh-el-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lae-block .lae-pagination .lae-page-nav.lae-disabled i' => 'color: {{VALUE}};',
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
                    '{{WRAPPER}} .lae-block .lae-pagination .lae-page-nav' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'pagination_hover_text_color',
            [
                'label' => __('Hover Nav Text Color', 'livemesh-el-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lae-block .lae-pagination .lae-page-nav:hover, {{WRAPPER}} .lae-block .lae-pagination .lae-page-nav.lae-current-page' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'label' => __('Nav Text Typography', 'livemesh-el-addons'),
                'name' => 'pagination_text_typography',
                'selector' => '{{WRAPPER}} .lae-block .lae-pagination .lae-page-nav',
            ]
        );


        $this->end_controls_section();

        $this->start_controls_section(
            'section_load_more_button_styling',
            [
                'label' => __('Load More Button', 'livemesh-el-addons'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'load_more_button_custom_color',
            [
                'label' => __('Button Color', 'livemesh-el-addons'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .lae-block .lae-load-more' => 'background-color: {{VALUE}};',
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
                    '{{WRAPPER}} .lae-block .lae-load-more:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'load_more_button_padding',
            [
                'label' => __('Custom Padding', 'livemesh-el-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .lae-block .lae-load-more' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'isLinked' => false
            ]
        );

        $this->add_control(
            'load_more_button_border_radius',
            [
                'label' => __('Custom Border Radius', 'livemesh-el-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .lae-block .lae-load-more' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                    '{{WRAPPER}} .lae-block .lae-load-more' => 'color: {{VALUE}};',
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
                'selector' => '{{WRAPPER}} .lae-block .lae-load-more',
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

        $settings = apply_filters('lae_posts_block_' . $this->get_id() . '_settings', $settings);

        $settings['block_id'] = $this->get_id();

        self::$block_counter++;

        $settings['block_class'] = !empty($settings['block_class']) ? sanitize_title($settings['block_class']) : 'block-' . self::$block_counter;

        $settings = lae_parse_posts_block_settings($settings);

        $block = LAE_Blocks_Manager::get_instance($settings['block_type']);

        $output = $block->render($settings);

        echo apply_filters('lae_posts_block_output', $output, $settings);
    }

    /**
     * Render the widget output in the editor.
     * @return void
     */
    protected function content_template() {
    }

}