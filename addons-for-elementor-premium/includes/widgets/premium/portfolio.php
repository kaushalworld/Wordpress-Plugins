<?php

/*
Widget Name: Posts Grid
Description: Display posts or custom post types in a multi-column grid.
Author: LiveMesh
Author URI: https://www.livemeshthemes.com
*/

namespace LivemeshAddons\Widgets;

use LivemeshAddons\Blocks\LAE_Blocks_Manager;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Typography;


if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

/**
 * Class for Posts Grid widget that displays posts or custom post types in a multi-column grid.
 */
class LAE_Portfolio_Widget extends LAE_Widget_Base {

    static public $grid_counter = 0;

    /**
     * Get the name for the widget
     * @return string
     */
    public function get_name() {
        return 'lae-portfolio';
    }

    /**
     * Get the widget title
     * @return string|void
     */
    public function get_title() {
        return __('Posts Grid', 'livemesh-el-addons');
    }

    /**
     * Get the widget icon
     * @return string
     */
    public function get_icon() {
        return 'lae-icon-posts-grid-masonry';
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
        return 'https://livemeshelementor.com/docs/livemesh-addons/core-addons/posts-portfolio-grid/';
    }

    /**
     * Obtain the scripts required for the widget to function
     * @return string[]
     */
    public function get_script_depends() {

        $array = [
            'jquery-fancybox',
            'isotope.pkgd',
            'imagesloaded.pkgd',
            'lae-waypoints',
            'lae-frontend-scripts',
            'lae-blocks-scripts',
            'lae-portfolio-premium-scripts'
        ];

        if (class_exists('WooCommerce')) {
            $array[] = 'lae-wc-quick-view';
            $array[] = 'wc-add-to-cart-variation';
        }
        return $array;
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
                'description' => __('Provide a comma separated list of Post IDs to display in the grid.', 'livemesh-el-addons'),
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
                'min' => 1,
                'max' => 500,
                'step' => 1,
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
                'description' => __('Provide a comma separated list of Post IDs to exclude in the grid.', 'livemesh-el-addons'),
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
            'section_grid_skin',
            [
                'label' => __('Grid Skin', 'livemesh-el-addons'),
            ]
        );

        $this->add_control(
            'grid_class', [
                'type' => Controls_Manager::TEXT,
                "description" => __("Specify an unique identifier used as a custom CSS class name and lightbox group name/slug for the grid element.", "livemesh-el-addons"),
                "label" => __("Grid Class/Identifier", "livemesh-el-addons"),
                'default' => ''
            ]
        );


        $this->add_control(
            'grid_skin',
            [
                'label' => __('Choose Grid Skin', 'livemesh-el-addons'),
                'description' => __('The "Classic Skin" is the built-in styling provided for the grid items. Choose "Custom Skin" if you want to use theme builder template for the grid item. The option "Custom Grid" is the most flexible one that lets you use a theme builder template for the grid layout with choice of custom template for one or more of its items.', 'livemesh-el-addons'),
                'type' => Controls_Manager::SELECT,
                'options' => array(
                    'classic_skin' => __('Classic Skin', 'livemesh-el-addons'),
                    'custom_skin' => __('Custom Skin', 'livemesh-el-addons'),
                    'custom_grid' => __('Custom Grid', 'livemesh-el-addons'),
                ),
                'default' => 'classic_skin',
            ]
        );

        $this->add_control(
            'item_template',
            [
                'label' => __('Select the custom skin template for the grid item', 'livemesh-el-addons'),
                'description' => '<div style="text-align:center;font-style: normal;">'
                    . '<a target="_blank" class="elementor-button elementor-button-default" href="'
                    . esc_url(admin_url('/edit.php?post_type=elementor_library&tabs_group=theme&elementor_library_type=livemesh_item'))
                    . '">'
                    . __('Create/Edit the Item Skin Builder Templates', 'livemesh-el-addons')
                    . '</a>'
                    . '</div>',
                'type' => Controls_Manager::SELECT,
                'label_block' => true,
                'default' => [],
                'options' => $this->get_item_template_options(),
                'condition' => [
                    'grid_skin' => 'custom_skin'
                ],
            ]
        );

        $this->add_control(
            'grid_template',
            [
                'label' => __('Select the custom grid template for the grid item', 'livemesh-el-addons'),
                'description' => '<div style="text-align:center;font-style: normal;">'
                    . '<a target="_blank" class="elementor-button elementor-button-default" href="'
                    . esc_url(admin_url('/edit.php?post_type=elementor_library&tabs_group=theme&elementor_library_type=livemesh_grid'))
                    . '">'
                    . __('Create/Edit the Grid Builder Templates', 'livemesh-el-addons')
                    . '</a>'
                    . '</div>',
                'type' => Controls_Manager::SELECT,
                'label_block' => true,
                'default' => [],
                'options' => $this->get_grid_template_options(),
                'condition' => [
                    'grid_skin' => 'custom_grid'
                ],
            ]
        );

        $this->add_control(
            'block_type',
            [
                'type' => Controls_Manager::SELECT,
                'label' => __('Choose Grid Style', 'livemesh-el-addons'),
                'options' => array(
                    'block_grid_1' => __('Grid Style 1', 'livemesh-el-addons'),
                    'block_grid_2' => __('Grid Style 2', 'livemesh-el-addons'),
                    'block_grid_3' => __('Grid Style 3', 'livemesh-el-addons'),
                    'block_grid_4' => __('Grid Style 4', 'livemesh-el-addons'),
                    'block_grid_5' => __('Grid Style 5', 'livemesh-el-addons'),
                    'block_grid_6' => __('Grid Style 6', 'livemesh-el-addons'),
                    'block_woocommerce_grid_1' => __('WooCommerce Grid 1', 'livemesh-el-addons'),
                    'block_woocommerce_grid_2' => __('WooCommerce Grid 2', 'livemesh-el-addons'),
                ),
                'default' => 'block_grid_1',
                'condition' => [
                    'grid_skin' => 'classic_skin'
                ],
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

        $this->end_controls_section();

        $this->start_controls_section(
            'section_post_content',
            [
                'label' => __('Post Content', 'livemesh-el-addons'),
                'condition' => [
                    'grid_skin' => 'classic_skin'
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
                'name' => 'thumbnail_size',
                'label' => __('Image Size', 'livemesh-el-addons'),
                'default' => 'large',
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
            'display_title_on_thumbnail',
            [
                'label' => __('Display posts title on the post/portfolio thumbnail?', 'livemesh-el-addons'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'livemesh-el-addons'),
                'label_off' => __('No', 'livemesh-el-addons'),
                'return_value' => 'yes',
                'default' => 'yes',
                'condition' => [
                    'block_type' => ['block_grid_1', 'block_grid_6']
                ],
            ]
        );

        $this->add_control(
            'display_taxonomy_on_thumbnail',
            [
                'label' => __('Display taxonomy info on post/project thumbnail?', 'livemesh-el-addons'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'livemesh-el-addons'),
                'label_off' => __('No', 'livemesh-el-addons'),
                'return_value' => 'yes',
                'default' => 'yes',
                'condition' => [
                    'block_type' => ['block_grid_1', 'block_grid_6']
                ],
            ]
        );

        $this->add_control(
            'display_title',
            [
                'label' => __('Display posts title for the post/portfolio item?', 'livemesh-el-addons'),
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
                'label' => __('Display post excerpt/summary for the post/portfolio item?', 'livemesh-el-addons'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'livemesh-el-addons'),
                'label_off' => __('No', 'livemesh-el-addons'),
                'return_value' => 'yes',
                'default' => 'yes',
                'condition' => [
                    'block_type' => ['block_grid_1', 'block_grid_3', 'block_grid_4', 'block_grid_6']
                ],
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
                'condition' => [
                    'block_type' => ['block_grid_1', 'block_grid_3', 'block_grid_4', 'block_grid_6']
                ],
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
                'condition' => [
                    'block_type' => ['block_grid_1', 'block_grid_3', 'block_grid_4', 'block_grid_6']
                ],
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
                    'block_type' => ['block_grid_1', 'block_grid_3', 'block_grid_4', 'block_grid_6']
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
                    'block_type' => ['block_grid_1', 'block_grid_3', 'block_grid_4', 'block_grid_6']
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
                'condition' => [
                    'block_type' => ['block_grid_1', 'block_grid_2', 'block_grid_3', 'block_grid_4', 'block_grid_5', 'block_grid_6']
                ],
            ]
        );

        $this->add_control(
            'display_product_quick_view',
            [
                'label' => __('Display quick view option for product?', 'livemesh-el-addons'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'livemesh-el-addons'),
                'label_off' => __('No', 'livemesh-el-addons'),
                'return_value' => 'yes',
                'default' => 'yes',
                'condition' => [
                    'block_type' => ['block_woocommerce_grid_1', 'block_woocommerce_grid_2']
                ],
            ]
        );

        $this->add_control(
            'display_product_price',
            [
                'label' => __('Display product price?', 'livemesh-el-addons'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'livemesh-el-addons'),
                'label_off' => __('No', 'livemesh-el-addons'),
                'return_value' => 'yes',
                'default' => 'yes',
                'condition' => [
                    'block_type' => ['block_woocommerce_grid_1', 'block_woocommerce_grid_2']
                ],
            ]
        );

        $this->add_control(
            'display_add_to_cart_button',
            [
                'label' => __('Display add to cart button for the product?', 'livemesh-el-addons'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'livemesh-el-addons'),
                'label_off' => __('No', 'livemesh-el-addons'),
                'return_value' => 'yes',
                'default' => 'yes',
                'condition' => [
                    'block_type' => ['block_woocommerce_grid_1', 'block_woocommerce_grid_2']
                ],
            ]
        );

        $this->add_control(
            'display_wish_list_button',
            [
                'label' => __('Display add to wish list button for the product?', 'livemesh-el-addons'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'livemesh-el-addons'),
                'label_off' => __('No', 'livemesh-el-addons'),
                'return_value' => 'yes',
                'default' => 'yes',
                'condition' => [
                    'block_type' => ['block_woocommerce_grid_1', 'block_woocommerce_grid_2']
                ],
            ]
        );

        $this->add_control(
            'display_product_rating',
            [
                'label' => __('Display product rating?', 'livemesh-el-addons'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'livemesh-el-addons'),
                'label_off' => __('No', 'livemesh-el-addons'),
                'return_value' => 'yes',
                'default' => 'yes',
                'condition' => [
                    'block_type' => ['block_woocommerce_grid_1', 'block_woocommerce_grid_2']
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_post_meta',
            [
                'label' => __('Post Meta', 'livemesh-el-addons'),
                'condition' => [
                    'grid_skin' => 'classic_skin'
                ],
            ]
        );

        $this->add_control(
            'display_author',
            [
                'label' => __('Display post author info for the post/portfolio item?', 'livemesh-el-addons'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'livemesh-el-addons'),
                'label_off' => __('No', 'livemesh-el-addons'),
                'return_value' => 'yes',
                'default' => 'yes',
                'condition' => [
                    'block_type' => ['block_grid_1', 'block_grid_2', 'block_grid_3', 'block_grid_4', 'block_grid_6']
                ],
            ]
        );

        $this->add_control(
            'display_post_date',
            [
                'label' => __('Display post date info for the post item?', 'livemesh-el-addons'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'livemesh-el-addons'),
                'label_off' => __('No', 'livemesh-el-addons'),
                'return_value' => 'yes',
                'default' => 'yes',
                'condition' => [
                    'block_type' => ['block_grid_1', 'block_grid_2', 'block_grid_3', 'block_grid_4', 'block_grid_6']
                ],
            ]
        );


        $this->add_control(
            'display_comments',
            [
                'label' => __('Display post comments number for the post item?', 'livemesh-el-addons'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'livemesh-el-addons'),
                'label_off' => __('No', 'livemesh-el-addons'),
                'return_value' => 'yes',
                'default' => 'yes',
                'condition' => [
                    'block_type' => ['block_grid_1', 'block_grid_2', 'block_grid_3', 'block_grid_4', 'block_grid_6']
                ],
            ]
        );


        $this->add_control(
            'display_taxonomy',
            [
                'label' => __('Display taxonomy info below the post item?', 'livemesh-el-addons'),
                'description' => __('Choose the right taxonomy in General section.', 'livemesh-el-addons'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'livemesh-el-addons'),
                'label_off' => __('No', 'livemesh-el-addons'),
                'return_value' => 'yes',
                'default' => 'yes',
                'condition' => [
                    'block_type' => ['block_grid_1', 'block_grid_2', 'block_grid_3', 'block_grid_4', 'block_grid_5', 'block_grid_6']
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_general_settings',
            [
                'label' => __('General', 'livemesh-el-addons'),
                'tab' => Controls_Manager::TAB_SETTINGS,
            ]
        );

        $this->add_control(
            'heading',
            [
                'label' => __('Heading for the grid', 'livemesh-el-addons'),
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
                'label' => __('URL for the heading of the grid', 'livemesh-el-addons'),
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
            'taxonomy_filter',
            [
                'type' => Controls_Manager::SELECT,
                'label' => __('Choose the taxonomy to display and filter on.', 'livemesh-el-addons'),
                'label_block' => true,
                'description' => __('Choose the taxonomy information to display for posts/portfolio and the taxonomy that is used to filter the portfolio/post. Takes effect only if no taxonomy filters are specified when building query.', 'livemesh-el-addons'),
                'options' => lae_get_taxonomies_map(),
                'default' => 'category',
            ]
        );

        $this->add_responsive_control(
            'per_line',
            [
                'label' => __('Columns per row', 'livemesh-el-addons'),
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
                'label' => __('Choose a layout for the grid', 'livemesh-el-addons'),
                'options' => array(
                    'fitRows' => __('Fit Rows', 'livemesh-el-addons'),
                    'masonry' => __('Masonry', 'livemesh-el-addons'),
                ),
                'default' => 'fitRows',
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
                'condition' => [
                    'grid_skin' => 'classic_skin'
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
            'tablet_gutter',
            [
                'label' => __('Gutter', 'livemesh-el-addons'),
                'description' => __('Space between columns.', 'livemesh-el-addons'),
                'type' => Controls_Manager::NUMBER,
                'default' => 10,
                'selectors' => [
                    '(tablet-){{WRAPPER}} .lae-block .lae-block-inner' => 'margin-left: -{{VALUE}}px; margin-right: -{{VALUE}}px;',
                    '(tablet-){{WRAPPER}} .lae-block .lae-block-inner .lae-block-column' => 'padding: {{VALUE}}px;',
                ],
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
            'section_heading_styling',
            [
                'label' => __('Grid Heading', 'livemesh-el-addons'),
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
                    '{{WRAPPER}} .lae-block-grid .lae-heading span, {{WRAPPER}} .lae-block-grid .lae-heading a' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'heading_typography',
                'selector' => '{{WRAPPER}} .lae-block-grid .lae-heading span, {{WRAPPER}} .lae-block-grid .lae-heading a',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_filters_styling',
            [
                'label' => __('Grid Filters', 'livemesh-el-addons'),
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

        $this->start_controls_section(
            'section_entry_thumbnail_styling',
            [
                'label' => __('Entry Thumbnail', 'livemesh-el-addons'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'block_type' => ['block_grid_1', 'block_grid_6']
                ],
            ]
        );

        $this->add_control(
            'heading_thumbnail_info',
            [
                'label' => __('Thumbnail Info Entry Title', 'livemesh-el-addons'),
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
                'label' => __('Title Color', 'livemesh-el-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lae-block-grid .lae-block-inner .lae-module .lae-module-image .lae-module-image-info .lae-post-title a' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'title_hover_color',
            [
                'label' => __('Title Hover Color', 'livemesh-el-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lae-block-grid .lae-block-inner .lae-module .lae-module-image .lae-module-image-info .lae-post-title a:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'selector' => '{{WRAPPER}} .lae-block-grid .lae-block-inner .lae-module .lae-module-image .lae-module-image-info .lae-post-title',
            ]
        );

        $this->add_control(
            'heading_thumbnail_info_taxonomy',
            [
                'label' => __('Thumbnail Info Taxonomy Terms', 'livemesh-el-addons'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'after',
            ]
        );

        $this->add_control(
            'thumbnail_info_tags_color',
            [
                'label' => __('Taxonomy Terms Color', 'livemesh-el-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lae-block-grid .lae-module .lae-module-image .lae-terms a' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'thumbnail_info_tags_hover_color',
            [
                'label' => __('Taxonomy Terms Hover Color', 'livemesh-el-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lae-block-grid .lae-module .lae-module-image .lae-terms a:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'tags_typography',
                'selector' => '{{WRAPPER}} .lae-block-grid .lae-module .lae-module-image .lae-terms a',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_entry_title_styling',
            [
                'label' => __('Entry Title', 'livemesh-el-addons'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'grid_skin' => 'classic_skin'
                ],
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
                    '{{WRAPPER}} .lae-block-grid .lae-module .entry-title a' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'entry_title_hover_color',
            [
                'label' => __('Entry Title Hover Color', 'livemesh-el-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lae-block-grid .lae-module .entry-title a:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'entry_title_typography',
                'selector' => '{{WRAPPER}} .lae-block-grid .lae-module .entry-title a',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_entry_summary_styling',
            [
                'label' => __('Entry Summary', 'livemesh-el-addons'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'block_type' => ['block_grid_1', 'block_grid_3', 'block_grid_4', 'block_grid_6']
                ],
            ]
        );

        $this->add_control(
            'entry_summary_color',
            [
                'label' => __('Entry Summary Color', 'livemesh-el-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lae-block-grid .lae-module .entry-summary' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'entry_summary_typography',
                'selector' => '{{WRAPPER}} .lae-block-grid .lae-module .entry-summary',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_entry_meta_styling',
            [
                'label' => __('Entry Meta', 'livemesh-el-addons'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'block_type' => ['block_grid_1', 'block_grid_2', 'block_grid_3', 'block_grid_4', 'block_grid_6']
                ],
            ]
        );

        $this->add_control(
            'entry_meta_color',
            [
                'label' => __('Entry Meta Color', 'livemesh-el-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lae-block-grid .lae-module .lae-module-meta span' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'entry_meta_link_color',
            [
                'label' => __('Entry Meta Link Color', 'livemesh-el-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lae-block-grid .lae-module .lae-module-meta span a' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'entry_meta_link_hover_color',
            [
                'label' => __('Entry Meta Link Hover Color', 'livemesh-el-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lae-block-grid .lae-module .lae-module-meta span a:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'entry_meta_typography',
                'selector' => '{{WRAPPER}} .lae-block-grid .lae-module .lae-module-meta span, {{WRAPPER}} .lae-block-grid .lae-module .lae-module-meta span a',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_read_more_styling',
            [
                'label' => __('Read More', 'livemesh-el-addons'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'block_type' => ['block_grid_1', 'block_grid_3', 'block_grid_4', 'block_grid_6']
                ],
            ]
        );

        $this->add_control(
            'read_more_color',
            [
                'label' => __('Read More Color', 'livemesh-el-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lae-block-grid .lae-module .lae-read-more, {{WRAPPER}} .lae-block-grid .lae-module .lae-read-more a' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'read_more_hover_color',
            [
                'label' => __('Read More Hover Color', 'livemesh-el-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lae-block-grid .lae-module .lae-read-more, {{WRAPPER}} .lae-block-grid .lae-module .lae-read-more a:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'read_more_typography',
                'selector' => '{{WRAPPER}} .lae-block-grid .lae-module .lae-read-more, {{WRAPPER}} .lae-block-grid .lae-module .lae-read-more a',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_product_quick_view_styling',
            [
                'label' => __('Product Quick View', 'livemesh-el-addons'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'block_type' => ['block_woocommerce_grid_1', 'block_woocommerce_grid_2']
                ],
            ]
        );

        $this->add_control(
            'product_quick_view_button_color',
            [
                'label' => __('Product Quick View Background Color', 'livemesh-el-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lae-block-woocommerce-grid .lae-quick-view' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'product_quick_view_button_hover_color',
            [
                'label' => __('Product Quick View Hover Color', 'livemesh-el-addons'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .lae-block-woocommerce-grid .lae-quick-view:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'product_quick_view_padding',
            [
                'label' => __('Custom Padding', 'livemesh-el-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .lae-block-woocommerce-grid .lae-quick-view' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'isLinked' => false
            ]
        );

        $this->add_control(
            'product_quick_view_icon_color',
            [
                'label' => __('Product Quick View Icon Color', 'livemesh-el-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lae-block-woocommerce-grid .lae-quick-view i' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'product_quick_view_icon_hover_color',
            [
                'label' => __('Product Quick View Hover Icon Color', 'livemesh-el-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lae-block-woocommerce-grid .lae-quick-view:hover i' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'product_quick_view_label_color',
            [
                'label' => __('Product Quick View Label Color', 'livemesh-el-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lae-block-woocommerce-grid .lae-quick-view' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'product_quick_view_hover_label_color',
            [
                'label' => __('Product Quick View Label Hover Color', 'livemesh-el-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lae-block-woocommerce-grid .lae-quick-view:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'product_quick_view_label_typography',
                'selector' => '{{WRAPPER}} .lae-block-woocommerce-grid .lae-quick-view',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_product_price_styling',
            [
                'label' => __('Product Price', 'livemesh-el-addons'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'block_type' => ['block_woocommerce_grid_1', 'block_woocommerce_grid_2']
                ],
            ]
        );

        $this->add_control(
            'product_discounted_price_color',
            [
                'label' => __('Product Discounted Price Color', 'livemesh-el-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lae-block-woocommerce-grid .lae-item-price del, {{WRAPPER}} .lae-block-woocommerce-grid .lae-item-price del .amount' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'label' => __('Product Discounted Price Typography', 'livemesh-el-addons'),
                'name' => 'product_discounted_price_typography',
                'selector' => '{{WRAPPER}} .lae-block-woocommerce-grid .lae-item-price del, {{WRAPPER}} .lae-block-woocommerce-grid .lae-item-price del .amount',
            ]
        );

        $this->add_control(
            'product_price_color',
            [
                'label' => __('Product Price Color', 'livemesh-el-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lae-block-woocommerce-grid .lae-item-price .amount' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'label' => __('Product Price Typography', 'livemesh-el-addons'),
                'name' => 'product_price_typography',
                'selector' => '{{WRAPPER}} .lae-block-woocommerce-grid .lae-item-price .amount',
            ]
        );


        $this->end_controls_section();

        $this->start_controls_section(
            'section_add_to_cart_button_styling',
            [
                'label' => __('Add to Cart Button', 'livemesh-el-addons'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'block_type' => ['block_woocommerce_grid_1', 'block_woocommerce_grid_2']
                ],
            ]
        );

        $this->add_control(
            'add_to_cart_button_custom_color',
            [
                'label' => __('Button Color', 'livemesh-el-addons'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .lae-block-woocommerce-grid .lae-item-cart-button .button' => 'border-color: {{VALUE}}; background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'add_to_cart_button_custom_hover_color',
            [
                'label' => __('Button Hover Color', 'livemesh-el-addons'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .lae-block-woocommerce-grid .lae-item-cart-button .button:hover' => 'border-color: {{VALUE}}; background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'add_to_cart_button_padding',
            [
                'label' => __('Custom Padding', 'livemesh-el-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .lae-block-woocommerce-grid .lae-item-cart-button .button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'isLinked' => false
            ]
        );

        $this->add_control(
            'add_to_cart_button_border_radius',
            [
                'label' => __('Custom Border Radius', 'livemesh-el-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .lae-block-woocommerce-grid .lae-item-cart-button .button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'add_to_cart_button_label_color',
            [
                'label' => __('Label Color', 'livemesh-el-addons'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .lae-block-woocommerce-grid .lae-item-cart-button .button' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'add_to_cart_button_label_hover_color',
            [
                'label' => __('Label Hover Color', 'livemesh-el-addons'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .lae-block-woocommerce-grid .lae-item-cart-button .button:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'add_to_cart_button_typography',
                'label' => __('Typography', 'livemesh-el-addons'),
                'selector' => '{{WRAPPER}} .lae-block-woocommerce-grid .lae-item-cart-button .button',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_on_sale_label_styling',
            [
                'label' => __('On Sale Label', 'livemesh-el-addons'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'block_type' => ['block_woocommerce_grid_1', 'block_woocommerce_grid_2']
                ],
            ]
        );

        $this->add_control(
            'on_sale_label_custom_color',
            [
                'label' => __('Label Color', 'livemesh-el-addons'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .lae-block-woocommerce-grid .lae-item-on-sale span.onsale' => 'border-color: {{VALUE}}; background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'on_sale_label_padding',
            [
                'label' => __('Custom Padding', 'livemesh-el-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .lae-block-woocommerce-grid .lae-item-on-sale span.onsale' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'isLinked' => false
            ]
        );

        $this->add_control(
            'on_sale_label_border_radius',
            [
                'label' => __('Custom Border Radius', 'livemesh-el-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .lae-block-woocommerce-grid .lae-item-on-sale span.onsale' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'on_sale_label_label_color',
            [
                'label' => __('Label Color', 'livemesh-el-addons'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .lae-block-woocommerce-grid .lae-item-on-sale span.onsale' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'on_sale_label_typography',
                'label' => __('Typography', 'livemesh-el-addons'),
                'selector' => '{{WRAPPER}} .lae-block-woocommerce-grid .lae-item-on-sale span.onsale',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_wish_list_icon_styling',
            [
                'label' => __('Product Wish List Icon', 'livemesh-el-addons'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'block_type' => ['block_woocommerce_grid_1', 'block_woocommerce_grid_2']
                ],
            ]
        );

        $this->add_control(
            'product_wish_list_icon_color',
            [
                'label' => __('Product Wish List Icon Color', 'livemesh-el-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .yith-wcwl-add-to-wishlist a, {{WRAPPER}} .yith-wcwl-wishlistaddedbrowse, {{WRAPPER}} .yith-wcwl-wishlistexistsbrowse' => 'color: {{VALUE}};',
                ],
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
                    '{{WRAPPER}} .lae-block-grid .lae-pagination .lae-page-nav' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'pagination_hover_bg_color',
            [
                'label' => __('Hover Background Color', 'livemesh-el-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lae-block-grid .lae-pagination .lae-page-nav:hover, {{WRAPPER}} .lae-block-grid .lae-pagination .lae-page-nav.lae-current-page' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'pagination_nav_icon_color',
            [
                'label' => __('Nav Icon Color', 'livemesh-el-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lae-block-grid .lae-pagination .lae-page-nav i' => 'color: {{VALUE}};',
                ],
            ]
        );


        $this->add_control(
            'pagination_hover_nav_icon_color',
            [
                'label' => __('Hover Nav Icon Color', 'livemesh-el-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lae-block-grid .lae-pagination .lae-page-nav:hover i' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'pagination_disabled_nav_icon_color',
            [
                'label' => __('Disabled Nav Icon Color', 'livemesh-el-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lae-block-grid .lae-pagination .lae-page-nav.lae-disabled i' => 'color: {{VALUE}};',
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
                    '{{WRAPPER}} .lae-block-grid .lae-pagination .lae-page-nav' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'pagination_hover_text_color',
            [
                'label' => __('Hover Nav Text Color', 'livemesh-el-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lae-block-grid .lae-pagination .lae-page-nav:hover, {{WRAPPER}} .lae-block-grid .lae-pagination .lae-page-nav.lae-current-page' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'label' => __('Nav Text Typography', 'livemesh-el-addons'),
                'name' => 'pagination_text_typography',
                'selector' => '{{WRAPPER}} .lae-block-grid .lae-pagination .lae-page-nav',
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
                    '{{WRAPPER}} .lae-block-grid .lae-load-more' => 'background-color: {{VALUE}};',
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
                    '{{WRAPPER}} .lae-block-grid .lae-load-more:hover' => 'background-color: {{VALUE}};',
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
                    '{{WRAPPER}} .lae-block-grid .lae-load-more' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                    '{{WRAPPER}} .lae-block-grid .lae-load-more' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                    '{{WRAPPER}} .lae-block-grid .lae-load-more' => 'color: {{VALUE}};',
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
                'selector' => '{{WRAPPER}} .lae-block-grid .lae-load-more',
            ]
        );

        $this->end_controls_section();


    }

    protected function get_item_template_options() {

        $template_options = array();

        /* Initialize the theme builder templates - Requires elementor pro plugin */
        if (!is_plugin_active('elementor-pro/elementor-pro.php')) {
            $template_options = [0 => __('No templates found. Elementor Pro is not installed/active', 'livemesh-el-addons')];
        }
        else {
            $templates = lae_get_livemesh_item_templates();

            //$template_options = [0 => __('Select a template', 'livemesh-el-addons')];

            foreach ($templates as $template) {
                $template_options[$template->ID] = $template->post_title;
            }
        }

        return $template_options;
    }

    protected function get_grid_template_options() {

        $template_options = array();

        /* Initialize the theme builder templates - Requires elementor pro plugin */
        if (!is_plugin_active('elementor-pro/elementor-pro.php')) {
            $template_options = [0 => __('No templates found. Elementor Pro is not installed/active', 'livemesh-el-addons')];
        }
        else {
            $templates = lae_get_livemesh_grid_templates();

            //$template_options = [0 => __('Select a template', 'livemesh-el-addons')];

            foreach ($templates as $template) {
                $template_options[$template->ID] = $template->post_title;
            }
        }

        return $template_options;
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

        $settings = apply_filters('lae_posts_grid_' . $this->get_id() . '_settings', $settings);

        $settings['block_id'] = $this->get_id();

        self::$grid_counter++;

        $settings['block_class'] = !empty($settings['grid_class']) ? sanitize_title($settings['grid_class']) : 'grid-' . self::$grid_counter;

        if ($settings['grid_skin'] == 'custom_skin') :

            $settings['block_type'] = 'block_custom_grid_1';

        elseif ($settings['grid_skin'] == 'custom_grid') :

            $settings['block_type'] = 'block_custom_grid_2';

        endif;

        $settings = lae_parse_posts_block_settings($settings);

        $block = LAE_Blocks_Manager::get_instance($settings['block_type']);

        $output = $block->render($settings);

        echo apply_filters('lae_posts_grid_output', $output, $settings);
    }

    /**
     * Render the widget output in the editor.
     * @return void
     */
    protected function content_template() {
    }

}