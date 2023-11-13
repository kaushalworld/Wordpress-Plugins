<?php
namespace ExclusiveAddons\Elements;

if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.

use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Image_Size;
use \Elementor\Group_Control_Border;
use \Elementor\Group_Control_Box_Shadow;
use \Elementor\Group_Control_Typography;
use \Elementor\Widget_Base;
use \Elementor\Group_Control_Background;
use \Elementor\Plugin;

class Woo_Products extends Widget_Base {

	public function get_name() {
		return 'exad-woo-products';
	}

	public function get_title() {
		return esc_html__( 'Woo Products', 'exclusive-addons-elementor-pro' );
	}

	public function get_icon() {
		return 'exad exad-logo exad-woo-products';
	}

	public function get_categories() {
		return [ 'exclusive-addons-elementor' ];
	}

    public function get_keywords() {
	    return [ 'woo products', 'product', 'shop', 'products' ];
	}

	public function get_script_depends() {
		return [ 'exad-slick' ];
	}

    private function exad_get_product_categories( $post_type ) {

        $options = array();
        $taxonomy = 'product_cat';

        if ( ! empty( $taxonomy ) ) {
            // Get categories for post type.
            $terms = get_terms(
                array(
                    'taxonomy'   => $taxonomy,
                    'hide_empty' => false,
                )
            );
            if ( ! empty( $terms ) ) {
                $options = ['' => ''];
                foreach ( $terms as $term ) {
                    if ( isset( $term ) ) {
                        if ( isset( $term->term_id ) && isset( $term->name ) ) {
                            $options[ $term->term_id ] = $term->name;
                        }
                    }
                }
            }
        }

        return $options;
    }

    protected function register_controls() {

        $exad_primary_color   = get_option( 'exad_primary_color_option', '#7a56ff' );
		$exad_secondary_color = get_option( 'exad_secondary_color_option', '#00d8d8' );

        if( ! class_exists( 'woocommerce' ) ) {
		    $this->start_controls_section(
			    'exad_panel_notice',
			    [
				    'label' => __('Notice!', 'exclusive-addons-elementor-pro'),
			    ]
		    );

		    $this->add_control(
			    'exad_panel_notice_text',
			    [
				    'type'            => Controls_Manager::RAW_HTML,
				    'raw'             => __('<strong>WooCommerce</strong> is not installed/activated on your site. Please install and activate <a href="plugin-install.php?s=wpcf7&tab=search&type=term" target="_blank">WooCommerce</a> first.',
					    'exclusive-addons-elementor-pro'),
				    'content_classes' => 'exad-panel-notice',
			    ]
		    );

            $this->end_controls_section();
            
		    return;
        }

        $this->start_controls_section(
            'exad_woo_product_content_section',
            [
                'label' => esc_html__( 'Query', 'exclusive-addons-elementor-pro' ),
            ]
        );

        $this->add_responsive_control(
            'exad_woo_product_grid_column_no',
            [
                'label'   => __( 'Number of Columns', 'exclusive-addons-elementor-pro' ),
                'type'    => Controls_Manager::SELECT,
                'default' => '3',
                'options' => [
                    '1' => esc_html__( '1', 'exclusive-addons-elementor-pro' ),
                    '2' => esc_html__( '2', 'exclusive-addons-elementor-pro' ),
                    '3' => esc_html__( '3', 'exclusive-addons-elementor-pro' ),
                    '4' => esc_html__( '4', 'exclusive-addons-elementor-pro' ),
                    '5' => esc_html__( '5', 'exclusive-addons-elementor-pro' ),
                    '6' => esc_html__( '6', 'exclusive-addons-elementor-pro' )
                ],
                'desktop_default' => '3',
				'tablet_default' => '2',
				'mobile_default' => '1',
				'selectors_dictionary' => [
					'1' => 'grid-template-columns: repeat(1, 1fr);',
					'2' => 'grid-template-columns: repeat(2, 1fr);',
					'3' => 'grid-template-columns: repeat(3, 1fr);',
					'4' => 'grid-template-columns: repeat(4, 1fr);',
					'5' => 'grid-template-columns: repeat(5, 1fr);',
					'6' => 'grid-template-columns: repeat(6, 1fr);',
				],
				'selectors' => [
					'{{WRAPPER}} .exad-woo-products' => '{{VALUE}};'
				]
            ]
        );
        
        $this->add_control(
            'exad_woo_product_categories',
            [
                'label'         => esc_html__( 'Product Category', 'exclusive-addons-elementor-pro' ),
                'label_block'   => true,
                'type'          => Controls_Manager::SELECT2,
                'options'       => $this->exad_get_product_categories( 'product' ),
                'multiple'      => true
            ]
        );

        $this->add_control(
            'exad_woo_order_by',
            [
                'type'    => Controls_Manager::SELECT,
                'label'   => esc_html__( 'Order by', 'exclusive-addons-elementor-pro' ),
                'default' => 'name',
                'options' => [
                    'name'          => esc_html__('Name', 'exclusive-addons-elementor-pro' ),
                    'id'            => esc_html__('ID', 'exclusive-addons-elementor-pro' ),
                    'count'         => esc_html__('Count', 'exclusive-addons-elementor-pro' ),
                    'slug'          => esc_html__('Slug', 'exclusive-addons-elementor-pro' ),
                    'term_group'    => esc_html__('Term Group', 'exclusive-addons-elementor-pro' ),
                    'none'          => esc_html__('None', 'exclusive-addons-elementor-pro' )
                ]
            ]
        );

        // order
        $this->add_control(
            'exad_woo_order',
            [
                'type'          => Controls_Manager::SELECT,
                'label'         => esc_html__( 'Order', 'exclusive-addons-elementor-pro' ),
                'default'       => 'DESC',
                'options'       => [
                    'ASC'       => esc_html__( 'Ascending', 'exclusive-addons-elementor-pro' ),
                    'DESC'      => esc_html__( 'Descending', 'exclusive-addons-elementor-pro' )
                ]
            ]
        );

        // number of products
        $this->add_control(
            'product_per_page',
            [
                'label'         => esc_html__('Number of products to show', 'exclusive-addons-elementor-pro'),
                'type'          => Controls_Manager::NUMBER,
                'default'       => 9
            ]
        ); 

        $this->add_control(
			'offset',
			[
				'label' => esc_html__( 'Number of Offset', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::NUMBER,
				'step' => 1,
				'min' => 0,
				'max' => 50,
				'default' => 0,
			]
		);

        // selected id to show post
        $this->add_control(
            'product_in_ids',
            [
                'label'         => esc_html__('Product Include', 'exclusive-addons-elementor-pro' ),
                'description'   => esc_html__('Provide a comma separated list of Product IDs to display spacific Product.', 'exclusive-addons-elementor-pro' ),
                'type'          => Controls_Manager::TEXT
            ]
        );

        // specific id to exclude post
        $this->add_control(
            'product_not_in_ids',
            [   
                'label'         => esc_html__( 'Product Exclude', 'exclusive-addons-elementor-pro' ),
                'type'          => Controls_Manager::TEXT,
                'description'   => esc_html__('Provide a comma separated list of Product IDs to exclude specific Product.', 'exclusive-addons-elementor-pro' )
            ]
        );   

        $this->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
                'name'    => 'image_size',
                'default' => 'full'
            ]
        );

        // show only posts which has feature image?
        $this->add_control(
            'only_post_has_image',
            [
                'label'         => esc_html__( 'Show only Product has featured image.', 'exclusive-addons-elementor-pro' ),
                'type'          => Controls_Manager::SWITCHER,
                'default'       => 'no',
                'return_value'  => 'yes'
            ]
        );

        $this->add_control(
            'exad_woo_product_feature_options.',
            [
                'label'         => esc_html__( 'Features', 'exclusive-addons-elementor-pro' ),
                'type'          => Controls_Manager::HEADING,
                'separator'     => 'before'
            ]
        );

        $this->add_control(
            'exad_woo_product_show_category',
            [
                'label'        => esc_html__( 'Enable Category.', 'exclusive-addons-elementor-pro' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => __( 'Show', 'exclusive-addons-elementor-pro' ),
                'label_off'    => __( 'Hide', 'exclusive-addons-elementor-pro' ),
                'default'      => 'yes',
                'return_value' => 'yes'      
            ]
        );

        $this->add_control(
            'exad_woo_product_show_star_rating',
            [
                'label'        => esc_html__( 'Enable Star Rating.', 'exclusive-addons-elementor-pro' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => __( 'Show', 'exclusive-addons-elementor-pro' ),
                'label_off'    => __( 'Hide', 'exclusive-addons-elementor-pro' ),
                'default'      => 'yes',
                'return_value' => 'yes'      
            ]
        );

        $this->add_control(
            'exad_woo_product_sell_in_percentage_tag_enable',
            [
                'label'        => esc_html__( 'Enable Sale Percentage Tag.', 'exclusive-addons-elementor-pro' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => __( 'Show', 'exclusive-addons-elementor-pro' ),
                'label_off'    => __( 'Hide', 'exclusive-addons-elementor-pro' ),
                'default'      => 'yes',
                'return_value' => 'yes',
                'description'  => __('Show the sales percentage on products which are selling in the offer.', 'exclusive-addons-elementor-pro' )
            ]
        );

        $this->add_control(
            'exad_woo_product_sale_tag_enable',
            [
                'label'        => esc_html__( 'Enable Sale Tag.', 'exclusive-addons-elementor-pro' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => __( 'Show', 'exclusive-addons-elementor-pro' ),
                'label_off'    => __( 'Hide', 'exclusive-addons-elementor-pro' ),
                'default'      => 'yes',
                'return_value' => 'yes',
                'description'  => __('Show "Sale" tag for products which are featured.', 'exclusive-addons-elementor-pro' ),
                'condition'    => [
                    'exad_woo_product_sell_in_percentage_tag_enable!' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'exad_woo_product_sold_out_tag_enable',
            [
                'label'        => esc_html__( 'Enable Out Of Stock Tag.', 'exclusive-addons-elementor-pro' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => __( 'Show', 'exclusive-addons-elementor-pro' ),
                'label_off'    => __( 'Hide', 'exclusive-addons-elementor-pro' ),
                'description'  => __('Show "Sold Out" tag for products which are out of stock.', 'exclusive-addons-elementor-pro' ),
                'default'      => 'yes',
                'return_value' => 'yes'    
            ]
        );

        $this->add_control(
            'exad_woo_product_featured_tag_enable',
            [
                'label'        => esc_html__( 'Enable Featured Tag', 'exclusive-addons-elementor-pro' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => __( 'Show', 'exclusive-addons-elementor-pro' ),
                'label_off'    => __( 'Hide', 'exclusive-addons-elementor-pro' ),
                'description'  => __('Show "Hot" tag for products which are featured.', 'exclusive-addons-elementor-pro' ),
                'default'      => 'yes',
                'return_value' => 'yes'    
            ]
        );

        $this->add_control(
            'exad_woo_product_featured_tag_text',
            [   
                'label'         => esc_html__( 'Featured Tag.', 'exclusive-addons-elementor-pro' ),
                'type'          => Controls_Manager::TEXT,
                'default'       => esc_html__('Hot', 'exclusive-addons-elementor-pro' )
            ]
        );   

        $this->add_control(
            'exad_woo_show_product_excerpt',
            [
                'label'        => esc_html__( 'Enable Excerpt.', 'exclusive-addons-elementor-pro' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => __( 'Show', 'exclusive-addons-elementor-pro' ),
                'label_off'    => __( 'Hide', 'exclusive-addons-elementor-pro' ),
                'default'      => 'yes',
                'return_value' => 'yes'      
            ]
        );

        $this->add_control(
            'exad_woo_product_excerpt_length',
            [
                'label'     => esc_html__('Number of Excerpt Length', 'exclusive-addons-elementor-pro' ),
                'type'      => Controls_Manager::NUMBER,
                'default'   => 10,
                'condition' => [
                    'exad_woo_show_product_excerpt' => 'yes'
                ]
            ]
        ); 
        
        $this->add_control(
            'exad_woo_show_add_to_cart_button',
            [
                'label'        => esc_html__( 'Enable Add to Cart Button', 'exclusive-addons-elementor-pro' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => __( 'Show', 'exclusive-addons-elementor-pro' ),
                'label_off'    => __( 'Hide', 'exclusive-addons-elementor-pro' ),
                'default'      => 'yes',
                'return_value' => 'yes'      
            ]
        );

        $this->add_control(
            'exad_woo_show_add_to_cart_icon_on_hover',
            [
                'label'        => esc_html__( 'Show Cart Icon On Hover', 'exclusive-addons-elementor-pro' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => __( 'Show', 'exclusive-addons-elementor-pro' ),
                'label_off'    => __( 'Hide', 'exclusive-addons-elementor-pro' ),
                'default'      => 'yes',
                'return_value' => 'yes'      
            ]
        );

        $this->end_controls_section();

         //woo load more btn
         $this->start_controls_section(
            'exad_woo_product_pagination_section_style',
            [
                'label'     => __( 'Pagination', 'exclusive-addons-elementor-pro' ),
                'tab'       => Controls_Manager::TAB_CONTENT
            ]
        );

        $this->add_control(
            'exad_woo_product_pagination_switcher',
            [
                'label'        => esc_html__( 'Enable Pagination', 'exclusive-addons-elementor-pro' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'	   => __( 'On', 'exclusive-addons-elementor-pro' ),
				'label_off'    => __( 'Off', 'exclusive-addons-elementor-pro' ),
                'default'      => 'no',
                'return_value' => 'yes'
            ]
        );

        $this->add_control(
			'exad_woo_product_pagination_options',
			[
				'label'       => __( 'Pagination Type', 'exclusive-addons-elementor-pro' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => 'none',
				'label_block' => true,
				'options'     => [
                    'none'              => __( 'None', 'exclusive-addons-elementor-pro' ),
					'load-more-btn'     => __( 'Load More Button', 'exclusive-addons-elementor-pro' ),
					'default-pagination' => __( 'Default Pagintaion', 'exclusive-addons-elementor-pro' ),
                ],
                'selectors'   => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .exad-team-member .exad-team-member-thumb img' => '-webkit-mask-position: {{VALUE}};'
				],
				'condition' 		   => [
					'exad_woo_product_pagination_switcher' => 'yes'
				]
			]
		);

        $this->add_control(
            'exad_woo_product_pagination_content_update',
            [
                'label' => '<div class="elementor-update-preview" style="display: block;"><div class="elementor-update-preview-button-wrapper" style="display:block;"><button class="elementor-update-preview-button elementor-button elementor-button-success" style="background: #d30c5c; margin: 0 auto; display:block;">Apply Changes</button></div><div class="elementor-update-preview-title" style="display:block;text-align:center;margin-top: 10px;">'. __( 'Hit the button to apply changes if it hasn\'t already.', 'exclusive-addons-elementor-pro' ) .'</div></div>',
                'type' => Controls_Manager::RAW_HTML,
				'separator'  => 'before',
            ]
        );

        $this->add_control(
            'exad_woo_product_enable_load_more_btn_text',
            [   
                'label'         => esc_html__( 'Load More Button text', 'exclusive-addons-elementor-pro' ),
                'type'          => Controls_Manager::TEXT,
                'default'       => esc_html__('Load More', 'exclusive-addons-elementor-pro' ),
                'condition'     => [
                    'exad_woo_product_pagination_options' => 'load-more-btn'
                ]
            ]
        );

        $this->end_controls_section();

         //woo pagination
         $this->start_controls_section(
            'exad_woo_product_pagination_section_content',
            [
                'label'     => __( 'Pagination Content', 'exclusive-addons-elementor-pro' ),
                'tab'       => Controls_Manager::TAB_CONTENT,
                'condition'     => [
                    'exad_woo_product_pagination_options' => 'default-pagination'
                ]
            ]
        );

        $this->add_control(
            'exad_woo_product_pagination_prev_text',
            [   
                'label'         => esc_html__( 'Prev', 'exclusive-addons-elementor-pro' ),
                'type'          => Controls_Manager::TEXT,
                'default'       => esc_html__('Prev', 'exclusive-addons-elementor-pro' ),
                'condition'     => [
                    'exad_woo_product_pagination_options' => 'default-pagination'
                ]
            ]
        );

        $this->add_control(
            'exad_woo_product_pagination_next_text',
            [   
                'label'         => esc_html__( 'Next', 'exclusive-addons-elementor-pro' ),
                'type'          => Controls_Manager::TEXT,
                'default'       => esc_html__('Next', 'exclusive-addons-elementor-pro' ),
                'condition'     => [
                    'exad_woo_product_pagination_options' => 'default-pagination'
                ]
            ]
        );

        $this->end_controls_section();

         //woo Quick view btn
         $this->start_controls_section(
            'exad_woo_product_quick_view_content_section_style',
            [
                'label'     => __( 'Quick view', 'exclusive-addons-elementor-pro' ),
                'tab'       => Controls_Manager::TAB_CONTENT
            ]
        );

        $this->add_control(
            'exad_woo_product_quick_view_swithcer',
            [
                'label'        => esc_html__( 'Enable QuicK View', 'exclusive-addons-elementor-pro' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'	   => __( 'On', 'exclusive-addons-elementor-pro' ),
				'label_off'    => __( 'Off', 'exclusive-addons-elementor-pro' ),
                'default'      => 'no',
                'return_value' => 'yes'
            ]
        );

		$this->add_control(
            'exad_woo_product_quick_view_text',
            [   
                'label'         => esc_html__( 'Quick view', 'exclusive-addons-elementor-pro' ),
                'type'          => Controls_Manager::TEXT,
                'default'       => esc_html__('Quick view', 'exclusive-addons-elementor-pro' ),
                'placeholder'   => esc_html__('Quick view', 'exclusive-addons-elementor-pro' ),
                'condition'     => [
                    '.exad_woo_product_quick_view_swithcer' => 'yes'
                ]
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'exad_woo_product_container_style',
            [
                'label'     => __( 'Container', 'exclusive-addons-elementor-pro' ),
                'tab'       => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_responsive_control(
            'exad_woo_product_container_padding',
            [
                'label'         => esc_html__( 'Padding', 'exclusive-addons-elementor-pro' ),
                'type'          => Controls_Manager::DIMENSIONS,            
                'size_units'    => [ 'px', 'em', '%' ],
                'selectors'     => [
                        '{{WRAPPER}} .exad-woo-products.woocommerce .exad-woo-product-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->add_responsive_control(
            'exad_woo_product_container_column_gap',
            [
                'label'         => esc_html__('Column Gap', 'exclusive-addons-elementor-pro' ),
                'type'          => Controls_Manager::SLIDER,
                'default'       => [
                    'size'      => 30,
                    'unit'      => 'px'
                ],  
                'selectors'     => [
                    '{{WRAPPER}} .exad-woo-products.woocommerce' => 'grid-gap: {{SIZE}}{{UNIT}};'
                ],                
                'range'         => [
                    'px'        => [
                        'min'   => 10,
                        'max'   => 100,
                        'step'  => 1
                    ]
                ]
            ]
        );  

        $this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'exad_woo_product_container_background',
				'label' => __( 'Background', 'exclusive-addons-elementor-pro' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .exad-woo-products.woocommerce .exad-woo-product-item',
			]
        ); 

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'      => 'exad_woo_product_container_border',
                'selector'  => '{{WRAPPER}} .exad-woo-products.woocommerce .exad-woo-product-item'
            ]
        );

        $this->add_responsive_control(
            'exad_woo_product_container_border_radius',
            [
                'label'         => esc_html__('Border radius', 'exclusive-addons-elementor-pro' ),
                'type'          => Controls_Manager::DIMENSIONS, 
                'size_units'    => [ 'px', 'em', '%' ],
                'default'       => [
                    'top'       => 0,
                    'right'     => 0,
                    'bottom'    => 0,
                    'left'      => 0,
                    'unit'      => 'px'
                ],
                'selectors'     => [
                        '{{WRAPPER}} .exad-woo-products.woocommerce .exad-woo-product-item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        ); 

        $this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'exad_woo_product_container_shadow',
				'label' => __( 'Box Shadow', 'exclusive-addons-elementor-pro' ),
				'selector' => '{{WRAPPER}} .exad-woo-products.woocommerce .exad-woo-product-item',
			]
		);

        $this->end_controls_section();

        $this->start_controls_section(
            'exad_woo_product_content_box_style',
            [
                'label'     => __( 'Content Box', 'exclusive-addons-elementor-pro' ),
                'tab'       => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_responsive_control(
            'exad_woo_product_content_box_align',
            [
                'label'         => esc_html__( 'Alignment', 'exclusive-addons-elementor-pro' ),
                'type'          => Controls_Manager::CHOOSE,
                'default'       => 'center',
                'toggle'        => false,
                'options'       => [
                    'flex-start' => [
                        'title'  => esc_html__( 'Left', 'exclusive-addons-elementor-pro' ),
                        'icon'   => 'eicon-h-align-left'
                    ],
                    'center'     => [
                        'title'  => esc_html__( 'Center', 'exclusive-addons-elementor-pro' ),
                        'icon'   => 'eicon-h-align-center'
                    ],
                    'flex-end'   => [
                        'title'  => esc_html__( 'Right', 'exclusive-addons-elementor-pro' ),
                        'icon'   => 'eicon-h-align-right'
                    ]
                ],
                'selectors'     => [
                    '{{WRAPPER}} .exad-single-woo-product-content' => 'display: flex; flex-direction: column; align-items: {{VALUE}};'
                ]
            ]
        );

        $this->add_responsive_control(
            'exad_woo_product_content_box_text_align',
            [
                'label'         => esc_html__( 'Text Alignment', 'exclusive-addons-elementor-pro' ),
                'type'          => Controls_Manager::CHOOSE,
                'default'       => 'center',
                'toggle'        => false,
                'options'       => [
                    'left' => [
                        'title'  => esc_html__( 'Left', 'exclusive-addons-elementor-pro' ),
                        'icon'   => 'eicon-text-align-left'
                    ],
                    'center'     => [
                        'title'  => esc_html__( 'Center', 'exclusive-addons-elementor-pro' ),
                        'icon'   => 'eicon-text-align-center'
                    ],
                    'right'   => [
                        'title'  => esc_html__( 'Right', 'exclusive-addons-elementor-pro' ),
                        'icon'   => 'eicon-text-align-right'
                    ]
                ],
                'selectors'     => [
                    '{{WRAPPER}} .exad-single-woo-product-content' => 'text-align: {{VALUE}};'
                ]
            ]
        );

        $this->add_responsive_control(
            'exad_woo_product_content_box_padding',
            [
                'label'         => esc_html__( 'Padding', 'exclusive-addons-elementor-pro' ),
                'type'          => Controls_Manager::DIMENSIONS,            
                'size_units'    => [ 'px', 'em', '%' ],
                'selectors'     => [
                        '{{WRAPPER}} .exad-single-woo-product-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->add_responsive_control(
            'exad_woo_product_content_box_margin',
            [
                'label'         => esc_html__('Margin', 'exclusive-addons-elementor-pro' ),
                'type'          => Controls_Manager::DIMENSIONS, 
                'size_units'    => [ 'px', 'em', '%' ],
                'default'       => [
                    'top'       => 15,
                    'right'     => 0,
                    'bottom'    => 0,
                    'left'      => 0
                ],
                'selectors'     => [
                        '{{WRAPPER}} .exad-single-woo-product-content' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );  

        $this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'exad_woo_product_content_box_background',
				'label' => __( 'Background', 'exclusive-addons-elementor-pro' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .exad-single-woo-product-content',
			]
		);

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'      => 'exad_woo_product_content_box_border',
                'selector'  => '{{WRAPPER}} .exad-single-woo-product-content'
            ]
        );

        $this->add_responsive_control(
            'exad_woo_product_content_box_border_radius',
            [
                'label'         => esc_html__( 'Border Radius', 'exclusive-addons-elementor-pro' ),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => [ 'px', '%' ],
                'selectors'     => [
                    '{{WRAPPER}} .exad-single-woo-product-content' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'      => 'exad_woo_product_content_box_box_shadow',
                'selector'  => '{{WRAPPER}} .exad-single-woo-product-content'        
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'exad_woo_product_image_and_tag_style',
            [
                'label'     => __( 'Image and Tags', 'exclusive-addons-elementor-pro' ),
                'tab'       => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_control(
            'exad_woo_product_image_style',
            [
                'label'         => esc_html__( 'Image', 'exclusive-addons-elementor-pro' ),
                'type'          => Controls_Manager::HEADING
            ]
        );

        $this->add_responsive_control(
            'exad_woo_product_image_height',
            [
                'label'         => esc_html__('Image Height', 'exclusive-addons-elementor-pro' ),
                'type'          => Controls_Manager::SLIDER,
                'selectors'     => [
                    '{{WRAPPER}} .exad-woo-products.woocommerce .exad-woo-product-item .exad-single-woo-product-image' => 'height: {{SIZE}}{{UNIT}};'
                ],                
                'range'         => [
                    'px'        => [
                        'min'   => 0,
                        'max'   => 1000,
                        'step'  => 1
                    ]
                ]
            ]
        );  

        $this->add_responsive_control(
            'exad_woo_product_image_padding',
            [
                'label'         => esc_html__( 'Padding', 'exclusive-addons-elementor-pro' ),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => [ 'px', '%' ],
                'selectors'     => [
                    '{{WRAPPER}} .exad-woo-products.woocommerce .exad-woo-product-item .exad-single-woo-product-image img' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ]
            ]
        );

        $this->add_control(
            'exad_woo_product_image_overlay_color',
            [
                'label'     => esc_html__( 'Overlay', 'exclusive-addons-elementor-pro' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .exad-woo-products.woocommerce .exad-woo-product-item .exad-single-woo-product-image:before' => 'background-color: {{VALUE}};'
                ]
            ]
        );

        $this->add_control(
            'exad_woo_product_image_hover_overlay_color',
            [
                'label'     => esc_html__( 'Hover Overlay', 'exclusive-addons-elementor-pro' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .exad-woo-products.woocommerce .exad-woo-product-item .exad-single-woo-product-image:hover:before' => 'background-color: {{VALUE}};'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'      => 'exad_woo_product_image_border',
                'selector'  => '{{WRAPPER}} .exad-woo-products.woocommerce .exad-woo-product-item .exad-single-woo-product-image img'
            ]
        );

        $this->add_responsive_control(
            'exad_woo_product_image_border_radius',
            [
                'label'         => esc_html__( 'Border Radius', 'exclusive-addons-elementor-pro' ),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => [ 'px', '%' ],
                'selectors'     => [
                    '{{WRAPPER}} .exad-woo-products.woocommerce .exad-woo-product-item .exad-single-woo-product-image img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .exad-woo-products.woocommerce .exad-woo-product-item .exad-single-woo-product-image:before' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->add_control(
            'exad_woo_product_show_gallery_image_on_hover',
            [
                'label'        => esc_html__( 'Enable Gallery Image On Hover?', 'exclusive-addons-elementor-pro' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => __( 'Show', 'exclusive-addons-elementor-pro' ),
                'label_off'    => __( 'Hide', 'exclusive-addons-elementor-pro' ),
                'default'      => 'yes',
                'return_value' => 'yes'      
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'      => 'exad_woo_product_image_box_shadow',
                'selector'  => '{{WRAPPER}} .exad-woo-products.woocommerce .exad-woo-product-item .exad-single-woo-product-image img'        
            ]
        );

        $this->add_control(
            'exad_woo_product_tag_style',
            [
                'label'         => esc_html__( 'Tags', 'exclusive-addons-elementor-pro' ),
                'type'          => Controls_Manager::HEADING,
                'separator'     => 'before'
            ]
        );

        $this->add_responsive_control(
            'exad_woo_product_tag_position',
            [
                'label'         => esc_html__('Position(From Right Side)', 'exclusive-addons-elementor-pro' ),
                'type'          => Controls_Manager::SLIDER,
                'default'       => [
                    'size'      => 20,
                    'unit'      => 'px'
                ],  
                'selectors'     => [
                    '{{WRAPPER}} .exad-woo-products.woocommerce .exad-woo-product-item .exad-single-woo-product-image .exad-woo-product-content-badge' => 'right: {{SIZE}}{{UNIT}};'
                ],                
                'range'         => [
                    'px'        => [
                        'min'   => 0,
                        'max'   => 40,
                        'step'  => 1
                    ]
                ]
            ]
        );  

        $this->add_responsive_control(
            'exad_woo_product_tag_padding',
            [
                'label'         => esc_html__( 'Padding', 'exclusive-addons-elementor-pro' ),
                'type'          => Controls_Manager::DIMENSIONS,            
                'size_units'    => [ 'px', 'em', '%' ],
                'selectors'     => [
                        '{{WRAPPER}} .exad-woo-products.woocommerce .exad-woo-product-item .exad-single-woo-product-image .exad-woo-product-content-badge li' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->add_responsive_control(
            'exad_woo_product_tag_border_radius',
            [
                'label'         => esc_html__( 'Border Radius', 'exclusive-addons-elementor-pro' ),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => [ 'px', '%' ],
                'selectors'     => [
                    '{{WRAPPER}} .exad-woo-products.woocommerce .exad-woo-product-item .exad-single-woo-product-image .exad-woo-product-content-badge li' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->add_control(
            'exad_woo_product_sale_tag_style',
            [
                'label'         => esc_html__( 'Sale Tag', 'exclusive-addons-elementor-pro' ),
                'type'          => Controls_Manager::HEADING
            ]
        );

        $this->add_control(
            'exad_woo_product_sale_tag_color',
            [
                'label'     => esc_html__( 'Color', 'exclusive-addons-elementor-pro' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .exad-woo-products.woocommerce .exad-woo-product-item .exad-single-woo-product-image .exad-woo-product-content-badge li.onsale' => 'color: {{VALUE}};'
                ]
            ]
        );

        $this->add_control(
            'exad_woo_product_sale_tag_bg_color',
            [
                'label'     => esc_html__( 'Background Color', 'exclusive-addons-elementor-pro' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#3BC473',
                'selectors' => [
                    '{{WRAPPER}} .exad-woo-products.woocommerce .exad-woo-product-item .exad-single-woo-product-image .exad-woo-product-content-badge li.onsale' => 'background-color: {{VALUE}};'
                ]
            ]
        );

        $this->add_control(
            'exad_woo_product_sold_out_tag_style',
            [
                'label'         => esc_html__( 'Sold Out Tag', 'exclusive-addons-elementor-pro' ),
                'type'          => Controls_Manager::HEADING
            ]
        );

        $this->add_control(
            'exad_woo_product_sold_out_tag_color',
            [
                'label'     => esc_html__( 'Color', 'exclusive-addons-elementor-pro' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .exad-woo-products.woocommerce .exad-woo-product-item .exad-single-woo-product-image .exad-woo-product-content-badge li.out-of-stock' => 'color: {{VALUE}};'
                ]
            ]
        );

        $this->add_control(
            'exad_woo_product_sold_out_tag_bg_color',
            [
                'label'     => esc_html__( 'Background Color', 'exclusive-addons-elementor-pro' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#3BC473',
                'selectors' => [
                    '{{WRAPPER}} .exad-woo-products.woocommerce .exad-woo-product-item .exad-single-woo-product-image .exad-woo-product-content-badge li.out-of-stock' => 'background-color: {{VALUE}};'
                ]
            ]
        );

        $this->add_control(
            'exad_woo_product_featured_tag_style',
            [
                'label'         => esc_html__( 'Featured Tag', 'exclusive-addons-elementor-pro' ),
                'type'          => Controls_Manager::HEADING
            ]
        );

        $this->add_control(
            'exad_woo_product_featured_tag_color',
            [
                'label'     => esc_html__( 'Color', 'exclusive-addons-elementor-pro' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .exad-woo-products.woocommerce .exad-woo-product-item .exad-single-woo-product-image .exad-woo-product-content-badge li.featured' => 'color: {{VALUE}};'
                ]
            ]
        );

        $this->add_control(
            'exad_woo_product_featured_tag_bg_color',
            [
                'label'     => esc_html__( 'Background Color', 'exclusive-addons-elementor-pro' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#FF7272',
                'selectors' => [
                    '{{WRAPPER}} .exad-woo-products.woocommerce .exad-woo-product-item .exad-single-woo-product-image .exad-woo-product-content-badge li.featured' => 'background-color: {{VALUE}};'
                ]
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'exad_woo_product_cat_style',
            [
                'label'     => __( 'Category', 'exclusive-addons-elementor-pro' ),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'exad_woo_product_show_category' => 'yes'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'exad_woo_product_cat_typography',
                'selector' => '{{WRAPPER}} .exad-woo-products.woocommerce .exad-woo-product-item .exad-single-woo-product-content a.exad-product-cat'
            ]
        );

        $this->add_responsive_control(
            'exad_woo_product_cat_padding',
            [
                'label'         => esc_html__( 'Padding', 'exclusive-addons-elementor-pro' ),
                'type'          => Controls_Manager::DIMENSIONS,            
                'size_units'    => [ 'px', 'em', '%' ],
                'selectors'     => [
                        '{{WRAPPER}} .exad-woo-products.woocommerce .exad-woo-product-item .exad-single-woo-product-content a.exad-product-cat' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->add_responsive_control(
            'exad_woo_product_cat_margin',
            [
                'label'         => esc_html__( 'Margin', 'exclusive-addons-elementor-pro' ),
                'type'          => Controls_Manager::DIMENSIONS,            
                'size_units'    => [ 'px', 'em', '%' ],
                'selectors'     => [
                        '{{WRAPPER}} .exad-woo-products.woocommerce .exad-woo-product-item .exad-single-woo-product-content a.exad-product-cat' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'      => 'exad_woo_product_cat_border',
                'selector'  => '{{WRAPPER}} .exad-woo-products.woocommerce .exad-woo-product-item .exad-single-woo-product-content a.exad-product-cat'
            ]
        );

        $this->add_responsive_control(
            'exad_woo_product_cat_border_radius',
            [
                'label'         => esc_html__( 'Border Radius', 'exclusive-addons-elementor-pro' ),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => [ 'px', '%' ],
                'selectors'     => [
                    '{{WRAPPER}} .exad-woo-products.woocommerce .exad-woo-product-item .exad-single-woo-product-content a.exad-product-cat' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->start_controls_tabs( 'exad_woo_product_cat_tabs' );

            // Normal State Tab
            $this->start_controls_tab( 'exad_woo_product_cat_normal', [ 'label' => esc_html__( 'Normal', 'exclusive-addons-elementor-pro' ) ] );

            $this->add_control(
                'exad_woo_product_cat_normal_color',
                [
                    'label'     => esc_html__( 'Color', 'exclusive-addons-elementor-pro' ),
                    'type'      => Controls_Manager::COLOR,
                    'default'   => '#000000',
                    'selectors' => [
                        '{{WRAPPER}} .exad-woo-products.woocommerce .exad-woo-product-item .exad-single-woo-product-content a.exad-product-cat' => 'color: {{VALUE}};'
                    ]
                ]
            );

            $this->add_control(
                'exad_woo_product_cat_normal_bg_color',
                [
                    'label'     => esc_html__( 'Background Color', 'exclusive-addons-elementor-pro' ),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .exad-woo-products.woocommerce .exad-woo-product-item .exad-single-woo-product-content a.exad-product-cat' => 'background-color: {{VALUE}};'
                    ]
                ]
            );

            $this->add_control(
                'exad_woo_product_cat_normal_border_color',
                [
                    'label'     => esc_html__( 'Border Color', 'exclusive-addons-elementor-pro' ),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .exad-woo-products.woocommerce .exad-woo-product-item .exad-single-woo-product-content a.exad-product-cat' => 'border-color: {{VALUE}};'
                    ]
                ]
            );
            
            $this->end_controls_tab();

            // Hover State Tab
            $this->start_controls_tab( 'exad_woo_product_cat_hover', [ 'label' => esc_html__( 'Hover', 'exclusive-addons-elementor-pro' ) ] );

            $this->add_control(
                'exad_woo_product_cat_hover_color',
                [
                    'label'     => esc_html__( 'Color', 'exclusive-addons-elementor-pro' ),
                    'type'      => Controls_Manager::COLOR,
                    'default'   => '#000000',
                    'selectors' => [
                        '{{WRAPPER}} .exad-woo-products.woocommerce .exad-woo-product-item .exad-single-woo-product-content a.exad-product-cat:hover' => 'color: {{VALUE}};'
                    ]
                ]
            );

            $this->add_control(
                'exad_woo_product_cat_hover_bg_color',
                [
                    'label'     => esc_html__( 'Background Color', 'exclusive-addons-elementor-pro' ),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .exad-woo-products.woocommerce .exad-woo-product-item .exad-single-woo-product-content a.exad-product-cat:hover' => 'background-color: {{VALUE}};'
                    ]
                ]
            );

            $this->add_control(
                'exad_woo_product_cat_hover_border_color',
                [
                    'label'     => esc_html__( 'Border Color', 'exclusive-addons-elementor-pro' ),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .exad-woo-products.woocommerce .exad-woo-product-item .exad-single-woo-product-content a.exad-product-cat:hover' => 'border-color: {{VALUE}};'
                    ]
                ]
            );

            $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();

        $this->start_controls_section(
            'exad_woo_product_title_style',
            [
                'label'     => __( 'Title', 'exclusive-addons-elementor-pro' ),
                'tab'       => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'exad_woo_product_title_typography',
                'selector' => '{{WRAPPER}} .exad-single-woo-product-content h3.exad-woo-product-content-name'
            ]
        );

        $this->add_control(
            'exad_woo_product_title_color',
            [
                'label'     => esc_html__( 'Color', 'exclusive-addons-elementor-pro' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#000000',
                'selectors' => [
                    '{{WRAPPER}} .exad-single-woo-product-content h3.exad-woo-product-content-name' => 'color: {{VALUE}};'
                ]
            ]
        );

        $this->add_responsive_control(
            'exad_woo_product_title_margin',
            [
                'label'         => esc_html__( 'Margin', 'exclusive-addons-elementor-pro' ),
                'type'          => Controls_Manager::DIMENSIONS,            
                'size_units'    => [ 'px', 'em', '%' ],
                'selectors'     => [
                        '{{WRAPPER}} .exad-single-woo-product-content h3.exad-woo-product-content-name' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'exad_woo_product_price_style',
            [
                'label'     => __( 'Price', 'exclusive-addons-elementor-pro' ),
                'tab'       => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'exad_woo_product_price_typography',
                'selector' => '{{WRAPPER}} .exad-woo-products.woocommerce .exad-woo-product-item span.exad-woo-product-content-price'
            ]
        );

        $this->add_control(
            'exad_woo_product_price_color',
            [
                'label'     => esc_html__( 'Color', 'exclusive-addons-elementor-pro' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#000000',
                'selectors' => [
                    '{{WRAPPER}} .exad-woo-products.woocommerce .exad-woo-product-item span.exad-woo-product-content-price' => 'color: {{VALUE}};'
                ]
            ]
        );

        $this->add_responsive_control(
            'exad_woo_product_price_margin',
            [
                'label'         => esc_html__( 'Margin', 'exclusive-addons-elementor-pro' ),
                'type'          => Controls_Manager::DIMENSIONS,            
                'size_units'    => [ 'px', 'em', '%' ],
                'selectors'     => [
                        '{{WRAPPER}} .exad-woo-products.woocommerce .exad-woo-product-item span.exad-woo-product-content-price' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'exad_woo_product_star_rating_style',
            [
                'label'     => __( 'Star Rating', 'exclusive-addons-elementor-pro' ),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'exad_woo_product_show_star_rating' => 'yes'
                ]
            ]
        );

        $this->add_responsive_control(
            'exad_woo_product_star_rating_font_size',
            [
                'label'         => esc_html__('Font Size', 'exclusive-addons-elementor-pro' ),
                'type'          => Controls_Manager::SLIDER,
                'default'       => [
                    'size'      => 18,
                    'unit'      => 'px'
                ],  
                'selectors'     => [
                    '{{WRAPPER}} .exad-woo-products.woocommerce .exad-woo-product-item .exad-woo-product-star-rating' => 'font-size: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};'
                ],                
                'range'         => [
                    'px'        => [
                        'min'   => 8,
                        'max'   => 30,
                        'step'  => 1
                    ]
                ]
            ]
        );  

        $this->add_control(
            'exad_woo_product_star_rating_color',
            [
                'label'         => esc_html__( 'Color', 'exclusive-addons-elementor-pro' ),
                'type'          => Controls_Manager::COLOR, 
                'default'       => '#3BC473',       
                'selectors'     => [
                    '{{WRAPPER}} .exad-woo-products.woocommerce .exad-woo-product-item .exad-woo-product-star-rating:before' => 'color: {{VALUE}};',
                ],               
            ]
        );

        $this->add_responsive_control(
            'exad_woo_product_star_rating_margin',
            [
                'label'         => esc_html__( 'Margin', 'exclusive-addons-elementor-pro' ),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => [ 'px' ],
                'default'       => [
                    'top'       => 10,
                    'right'     => 0,
                    'bottom'    => 10,
                    'left'      => 0
                ],
                'selectors'     => [
                    '{{WRAPPER}} ul.exad-woo-product-content-rating' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'exad_woo_product_excerpt_style',
            [
                'label'     => __( 'Excerpt', 'exclusive-addons-elementor-pro' ),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'exad_woo_show_product_excerpt' => 'yes'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'exad_woo_product_excerpt_typography',
                'selector' => '{{WRAPPER}} .exad-single-woo-product-content p.exad-woo-product-content-description'
            ]
        );

        $this->add_control(
            'exad_woo_product_excerpt_color',
            [
                'label'     => esc_html__( 'Color', 'exclusive-addons-elementor-pro' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#000000',
                'selectors' => [
                    '{{WRAPPER}} .exad-single-woo-product-content p.exad-woo-product-content-description' => 'color: {{VALUE}};'
                ]
            ]
        );

        $this->add_responsive_control(
            'exad_woo_product_excerpt_margin',
            [
                'label'         => esc_html__( 'Margin', 'exclusive-addons-elementor-pro' ),
                'type'          => Controls_Manager::DIMENSIONS,            
                'size_units'    => [ 'px', 'em', '%' ],
                'selectors'     => [
                        '{{WRAPPER}} .exad-single-woo-product-content p.exad-woo-product-content-description' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'exad_woo_product_add_to_cart_btn_style',
            [
                'label'     => __( 'Button', 'exclusive-addons-elementor-pro' ),
                'tab'       => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'exad_woo_product_add_to_cart_btn_typography',
                'selector' => '{{WRAPPER}} .exad-woo-products.woocommerce .exad-woo-product-item .exad-single-woo-product-content a.button, {{WRAPPER}} .exad-woo-products.woocommerce .exad-woo-product-item .exad-single-woo-product-content a.added_to_cart'
            ]
        );

        $this->add_responsive_control(
            'exad_woo_product_add_to_cart_btn_padding',
            [
                'label'         => esc_html__( 'Padding', 'exclusive-addons-elementor-pro' ),
                'type'          => Controls_Manager::DIMENSIONS,            
                'size_units'    => [ 'px', 'em', '%' ],
                'selectors'     => [
                        '{{WRAPPER}} .exad-woo-products.woocommerce .exad-woo-product-item .exad-single-woo-product-content a.button, {{WRAPPER}} .exad-woo-products.woocommerce .exad-woo-product-item .exad-single-woo-product-content a.added_to_cart' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->add_responsive_control(
            'exad_woo_product_add_to_cart_btn_margin',
            [
                'label'         => esc_html__( 'Margin', 'exclusive-addons-elementor-pro' ),
                'type'          => Controls_Manager::DIMENSIONS,            
                'size_units'    => [ 'px', 'em', '%' ],
                'selectors'     => [
                        '{{WRAPPER}} .exad-woo-products.woocommerce .exad-woo-product-item .exad-single-woo-product-content a.button, {{WRAPPER}} .exad-woo-products.woocommerce .exad-woo-product-item .exad-single-woo-product-content a.added_to_cart' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );


        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'      => 'exad_woo_product_add_to_cart_btn_border',
                'selector'  => '{{WRAPPER}} .exad-woo-products.woocommerce .exad-woo-product-item .exad-single-woo-product-content a.button, {{WRAPPER}} .exad-woo-products.woocommerce .exad-woo-product-item .exad-single-woo-product-content a.added_to_cart'
            ]
        );

        $this->add_responsive_control(
            'exad_woo_product_add_to_cart_btn_border_radius',
            [
                'label'         => esc_html__( 'Border Radius', 'exclusive-addons-elementor-pro' ),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => [ 'px', '%' ],
                'selectors'     => [
                    '{{WRAPPER}} .exad-woo-products.woocommerce .exad-woo-product-item .exad-single-woo-product-content a.button, {{WRAPPER}} .exad-woo-products.woocommerce .exad-woo-product-item .exad-single-woo-product-content a.added_to_cart' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->start_controls_tabs( 'exad_woo_product_add_to_cart_btn_tabs' );

            // Normal State Tab
            $this->start_controls_tab( 'exad_woo_product_add_to_cart_btn_normal', [ 'label' => esc_html__( 'Normal', 'exclusive-addons-elementor-pro' ) ] );

            $this->add_control(
                'exad_woo_product_add_to_cart_btn_normal_color',
                [
                    'label'     => esc_html__( 'Color', 'exclusive-addons-elementor-pro' ),
                    'type'      => Controls_Manager::COLOR,
                    'default'   => '#ffffff',
                    'selectors' => [
                        '{{WRAPPER}} .exad-woo-products.woocommerce .exad-woo-product-item .exad-single-woo-product-content a.button, {{WRAPPER}} .exad-woo-products.woocommerce .exad-woo-product-item .exad-single-woo-product-content a.added_to_cart' => 'color: {{VALUE}};'
                    ]
                ]
            );

            $this->add_control(
                'exad_woo_product_add_to_cart_btn_normal_bg_color',
                [
                    'label'     => esc_html__( 'Background Color', 'exclusive-addons-elementor-pro' ),
                    'type'      => Controls_Manager::COLOR,
                    'default'   => '#3BC473',
                    'selectors' => [
                        '{{WRAPPER}} .exad-woo-products.woocommerce .exad-woo-product-item .exad-single-woo-product-content a.button, {{WRAPPER}} .exad-woo-products.woocommerce .exad-woo-product-item .exad-single-woo-product-content a.added_to_cart' => 'background-color: {{VALUE}};'
                    ]
                ]
            );

            $this->add_control(
                'exad_woo_product_add_to_cart_btn_normal_border_color',
                [
                    'label'     => esc_html__( 'Border Color', 'exclusive-addons-elementor-pro' ),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .exad-woo-products.woocommerce .exad-woo-product-item .exad-single-woo-product-content a.button, {{WRAPPER}} .exad-woo-products.woocommerce .exad-woo-product-item .exad-single-woo-product-content a.added_to_cart' => 'border-color: {{VALUE}};'
                    ]
                ]
            );

            $this->add_group_control(
                Group_Control_Box_Shadow::get_type(),
                [
                    'name' => 'exad_woo_product_add_to_cart_btn_normal_shadow',
                    'label' => __( 'Box Shadow', 'exclusive-addons-elementor-pro' ),
                    'selector' => '{{WRAPPER}} .exad-woo-products.woocommerce .exad-woo-product-item .exad-single-woo-product-content a.button, {{WRAPPER}} .exad-woo-products.woocommerce .exad-woo-product-item .exad-single-woo-product-content a.added_to_cart',
                ]
            );
            
            $this->end_controls_tab();

            // Hover State Tab
            $this->start_controls_tab( 'exad_woo_product_add_to_cart_btn_hover', [ 'label' => esc_html__( 'Hover', 'exclusive-addons-elementor-pro' ) ] );

            $this->add_control(
                'exad_woo_product_add_to_cart_btn_hover_color',
                [
                    'label'     => esc_html__( 'Color', 'exclusive-addons-elementor-pro' ),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .exad-woo-products.woocommerce .exad-woo-product-item .exad-single-woo-product-content a.button:hover, {{WRAPPER}} .exad-woo-products.woocommerce .exad-woo-product-item .exad-single-woo-product-content a.added_to_cart:hover' => 'color: {{VALUE}};'
                    ]
                ]
            );

            $this->add_control(
                'exad_woo_product_add_to_cart_btn_hover_bg_color',
                [
                    'label'     => esc_html__( 'Background Color', 'exclusive-addons-elementor-pro' ),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .exad-woo-products.woocommerce .exad-woo-product-item .exad-single-woo-product-content a.button:hover, {{WRAPPER}} .exad-woo-products.woocommerce .exad-woo-product-item .exad-single-woo-product-content a.added_to_cart:hover' => 'background-color: {{VALUE}};'
                    ]
                ]
            );

            $this->add_control(
                'exad_woo_product_add_to_cart_btn_hover_border_color',
                [
                    'label'     => esc_html__( 'Border Color', 'exclusive-addons-elementor-pro' ),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .exad-woo-products.woocommerce .exad-woo-product-item .exad-single-woo-product-content a.button:hover, {{WRAPPER}} .exad-woo-products.woocommerce .exad-woo-product-item .exad-single-woo-product-content a.added_to_cart:hover' => 'border-color: {{VALUE}};'
                    ]
                ]

            );

            $this->add_group_control(
                Group_Control_Box_Shadow::get_type(),
                [
                    'name' => 'exad_woo_product_add_to_cart_btn_hover_shadow',
                    'label' => __( 'Box Shadow', 'exclusive-addons-elementor-pro' ),
                    'selector' => '{{WRAPPER}} .exad-woo-products.woocommerce .exad-woo-product-item .exad-single-woo-product-content a.button:hover, {{WRAPPER}} .exad-woo-products.woocommerce .exad-woo-product-item .exad-single-woo-product-content a.added_to_cart:hover',
                ]
            );

            $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();

               	
		/**
         * -------------------------------------------
         * Load More Button style
         * -------------------------------------------
         */
        $this->start_controls_section(
            'exad_woo_product_style_section',
            [
				'label'     => esc_html__( 'Load More Button', 'exclusive-addons-elementor-pro' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
                    'exad_woo_product_pagination_options' => 'load-more-btn'
                ]
            ]
		);

        $this->add_responsive_control(
            'exad_woo_product_load_more_btn_align',
            [
                'label'         => esc_html__( 'Alignment', 'exclusive-addons-elementor-pro' ),
                'type'          => Controls_Manager::CHOOSE,
                'default'       => 'center',
                'toggle'        => false,
                'options'       => [
                    'flex-start' => [
                        'title'  => esc_html__( 'Left', 'exclusive-addons-elementor-pro' ),
                        'icon'   => 'eicon-h-align-left'
                    ],
                    'center'     => [
                        'title'  => esc_html__( 'Center', 'exclusive-addons-elementor-pro' ),
                        'icon'   => 'eicon-h-align-center'
                    ],
                    'flex-end'   => [
                        'title'  => esc_html__( 'Right', 'exclusive-addons-elementor-pro' ),
                        'icon'   => 'eicon-h-align-right'
                    ]
                ],
                'selectors'     => [
                    '{{WRAPPER}} .exad-woo-product-load-btn' => 'display: flex; flex-direction: column; align-items: {{VALUE}};'
                ]
            ]
        );

		$this->add_responsive_control(
			'exad_woo_product_load_more_btn_padding',
			[
				'label' => __( 'Padding', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'default' => [
					'top' => '10',
					'right' => '30',
					'bottom' => '10',
					'left' => '30',
					'unit' => 'px',
					'isLinked' => false,
				],
				'selectors' => [
					'{{WRAPPER}} .exad-woo-product-paginate-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'exad_woo_product_margin',
			[
				'label' => __( 'Margin', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'default' => [
					'top' => '20',
					'right' => '0',
					'bottom' => '0',
					'left' => '0',
					'unit' => 'px',
					'isLinked' => false,
				],
				'selectors' => [
					'{{WRAPPER}} .exad-woo-product-load-btn' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'exad_woo_product_radius',
			[
				'label' => __( 'Radius', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'default' => [
					'top' => '0',
					'right' => '0',
					'bottom' => '0',
					'left' => '0',
					'unit' => 'px',
					'isLinked' => true,
				],
				'selectors' => [
					'{{WRAPPER}} .exad-woo-product-paginate-btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'exad_woo_product_typography',
				'label' => __( 'Typography', 'exclusive-addons-elementor-pro' ),
				'selector' => '{{WRAPPER}} .exad-woo-product-paginate-btn',
			]
		);

		$this->start_controls_tabs( 'exad_woo_product_tabs' );

            // normal state tab
			$this->start_controls_tab( 'exad_woo_product_normal', [ 'label' => esc_html__( 'Normal', 'exclusive-addons-elementor-pro' ) ] );
			
				$this->add_control(
					'exad_woo_product_normal_bg_color',
					[
						'label'     => esc_html__( 'Background Color', 'exclusive-addons-elementor-pro' ),
						'type'      => Controls_Manager::COLOR,
						'default' 	=> $exad_primary_color,
						'selectors' => [
							'{{WRAPPER}} .exad-woo-product-paginate-btn' => 'background: {{VALUE}};'
						]
					]
				);

				$this->add_control(
					'exad_woo_product_normal_text_color',
					[
						'label'     => esc_html__( 'Text Color', 'exclusive-addons-elementor-pro' ),
						'type'      => Controls_Manager::COLOR,
						'default' 	=> '#ffffff',
						'selectors' => [
							'{{WRAPPER}} .exad-woo-product-paginate-btn' => 'color: {{VALUE}};'
						]
					]
				);

				$this->add_group_control(
					Group_Control_Border::get_type(),
					[
						'name' => 'exad_woo_product_normal_border',
						'label' => __( 'Border', 'exclusive-addons-elementor-pro' ),
						'selector' => '{{WRAPPER}} .exad-woo-product-paginate-btn',
					]
				);

				$this->add_group_control(
					Group_Control_Box_Shadow::get_type(),
					[
						'name' => 'exad_woo_product_normal_box_shadow',
						'label' => __( 'Box Shadow', 'exclusive-addons-elementor-pro' ),
						'selector' => '{{WRAPPER}} .exad-woo-product-paginate-btn',
					]
				);

            $this->end_controls_tab();

            // hover state tab
			$this->start_controls_tab( 'exad_woo_product_Hover', [ 'label' => esc_html__( 'Hover', 'exclusive-addons-elementor-pro' ) ] );
			
				$this->add_control(
					'exad_woo_product_hover_bg_color',
					[
						'label'     => esc_html__( 'Background Color', 'exclusive-addons-elementor-pro' ),
						'type'      => Controls_Manager::COLOR,
						'default' 	=> "#ffffff",
						'selectors' => [
							'{{WRAPPER}} .exad-woo-product-paginate-btn:hover' => 'background: {{VALUE}};'
						]
					]
				);

				$this->add_control(
					'exad_woo_product_hover_text_color',
					[
						'label'     => esc_html__( 'Text Color', 'exclusive-addons-elementor-pro' ),
						'type'      => Controls_Manager::COLOR,
						'default' 	=> $exad_primary_color,
						'selectors' => [
							'{{WRAPPER}} .exad-woo-product-paginate-btn:hover' => 'color: {{VALUE}};'
						]
					]
				);

				$this->add_group_control(
					Group_Control_Border::get_type(),
					[
						'name' => 'exad_woo_product_hover_border',
						'label' => __( 'Border', 'exclusive-addons-elementor-pro' ),
						'selector' => '{{WRAPPER}} .exad-woo-product-paginate-btn:hover',
					]
				);

				$this->add_group_control(
					Group_Control_Box_Shadow::get_type(),
					[
						'name' => 'exad_woo_product_hover_box_shadow',
						'label' => __( 'Box Shadow', 'exclusive-addons-elementor-pro' ),
						'selector' => '{{WRAPPER}} .exad-woo-product-paginate-btn:hover',
					]
				);

            $this->end_controls_tab();

        $this->end_controls_tabs();
		
		$this->end_controls_section();

        /**
         * -------------------------------------------
         * Pagination style
         * -------------------------------------------
         */
        $this->start_controls_section(
            'exad_woo_product_pagination_style_section',
            [
				'label'     => esc_html__( 'Pagination', 'exclusive-addons-elementor-pro' ),
				'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'exad_woo_product_pagination_options' => 'default-pagination'
                ]
            ]
		);
      
        $this->add_responsive_control(
            'exad_woo_product_pagination_align',
            [
                'label'         => esc_html__( 'Alignment', 'exclusive-addons-elementor-pro' ),
                'type'          => Controls_Manager::CHOOSE,
                'default'       => 'center',
                'toggle'        => false,
                'options'       => [
                    'flex-start' => [
                        'title'  => esc_html__( 'Left', 'exclusive-addons-elementor-pro' ),
                        'icon'   => 'eicon-h-align-left'
                    ],
                    'center'     => [
                        'title'  => esc_html__( 'Center', 'exclusive-addons-elementor-pro' ),
                        'icon'   => 'eicon-h-align-center'
                    ],
                    'flex-end'   => [
                        'title'  => esc_html__( 'Right', 'exclusive-addons-elementor-pro' ),
                        'icon'   => 'eicon-h-align-right'
                    ]
                ],
                'selectors'     => [
                    '{{WRAPPER}} .main-product-wrapper .exad-pagination.pagination' => 'display: flex; flex-direction: column; align-items: {{VALUE}};'
                ]
            ]
        );

        $this->add_responsive_control(
            'exad_woo_product_pagination_top_space',
            [
                'label' => __( 'Top Spacing', 'exclusive-addons-elementor-pro' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'range' => [
                    'px' => [
                        'min' => 1,
                        'max' => 100,
                        'step' => 1,
                    ]
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 25,
                ],
                'selectors' => [
                    '{{WRAPPER}} .main-product-wrapper .exad-pagination.pagination' => 'margin-top: {{SIZE}}{{UNIT}};',
                ]
            ]
        );

        $this->add_responsive_control(
            'exad_woo_product_nav_pagination_box_size',
            [
                'label'      => __( 'Number Box Size', 'exclusive-addons-elementor-pro' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range'      => [
                    'px' => [
                        'min' => 0,
                        'max' => 200,
                    ],
                ],
                'default'    => [
                    'unit' => 'px',
                    'size' => 30,
                ],
                'selectors'  => [
                    '{{WRAPPER}} .main-product-wrapper .exad-pagination li .page-numbers' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                    
                ],
            ]
        );

        $this->add_responsive_control(
            'exad_woo_product_nav_pagination_size',
            [
                'label'      => __( 'Icon Size', 'exclusive-addons-elementor-pro' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range'      => [
                    'px' => [
                        'min' => 0,
                        'max' => 50,
                    ],
                ],
                'default'    => [
                    'unit' => 'px',
                    'size' => 16,
                ],
                'selectors'  => [
                    '{{WRAPPER}} .main-product-wrapper .exad-pagination li .page-numbers i' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'exad_woo_product_nav_pagination_icon_space',
            [
                'label'      => __( 'Icon space', 'exclusive-addons-elementor-pro' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range'      => [
                    'px' => [
                        'min' => 0,
                        'max' => 50,
                    ],
                ],
                'default'    => [
                    'unit' => 'px',
                    'size' => 8,
                ],
                'selectors'  => [
                    '{{WRAPPER}} .main-product-wrapper .exad-pagination li .page-numbers.prev i' => 'margin-right: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .main-product-wrapper .exad-pagination li .page-numbers.next i' => 'margin-left: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'exad_woo_product_nav_pagination_typography',
				'label' => __( 'Typography', 'exclusive-addons-elementor-pro' ),
				'selector' => '{{WRAPPER}} .main-product-wrapper .exad-pagination li .page-numbers',
			]
		);

        $this->add_responsive_control(
            'exad_woo_product_nav_pagination_padding',
            [
                'label'         => esc_html__( 'Padding', 'exclusive-addons-elementor-pro' ),
                'type'          => Controls_Manager::DIMENSIONS,            
                'size_units'    => [ 'px', 'em', '%' ],
                'default'    => [
                    'top'      => '5',
                    'right'    => '5',
                    'bottom'   => '5',
                    'left'     => '5',
                    'unit'     => 'px',
                    'isLinked' => true,
                ],
                'selectors'     => [
                        '{{WRAPPER}} .main-product-wrapper .exad-pagination li .page-numbers' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->add_responsive_control(
            'exad_woo_product_nav_pagination_radius',
            [
                'label'      => __( 'Border radius', 'exclusive-addons-elementor-pro' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'default'    => [
                    'top'      => '5',
                    'right'    => '5',
                    'bottom'   => '5',
                    'left'     => '5',
                    'unit'     => 'px',
                    'isLinked' => true,
                ],
                'selectors'  => [
                    '{{WRAPPER}} .main-product-wrapper .exad-pagination li .page-numbers' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs( 'exad_woo_product_nav_pagination_tabs' );

			// normal state rating
			$this->start_controls_tab( 'exad_woo_product_nav_pagination_normal', [ 'label' => esc_html__( 'Normal', 'exclusive-addons-elementor-pro' ) ] );

                $this->add_control(
                    'exad_woo_product_nav_pagination_normal_background',
                    [
                        'label'     => __( 'Background Color', 'exclusive-addons-elementor-pro' ),
                        'type'      => Controls_Manager::COLOR,
                        'default'   => '#f2f4f5',
                        'selectors' => [
                            '{{WRAPPER}} .main-product-wrapper .exad-pagination li .page-numbers' => 'background: {{VALUE}}',
                        ],
                    ]
                );

                $this->add_control(
                    'exad_woo_product_nav_pagination_normal_color',
                    [
                        'label'     => __( 'Icon & Number Color', 'exclusive-addons-elementor-pro' ),
                        'type'      => Controls_Manager::COLOR,
                        'default'   => $exad_primary_color ,
                        'selectors' => [
                            '{{WRAPPER}} .main-product-wrapper .exad-pagination li .page-numbers i' => 'color: {{VALUE}};',
                            '{{WRAPPER}} .main-product-wrapper .exad-pagination li .page-numbers' => 'color: {{VALUE}};',
                        ],
                    ]
                );

                $this->add_group_control(
                    Group_Control_Border::get_type(),
                    [
                        'name'     => 'exad_woo_product_nav_pagination_normal_border',
                        'label'    => __( 'Border', 'exclusive-addons-elementor-pro' ),
                        'fields_options'     => [
                            'border'         => [
                                'default'    => 'solid'
                            ],
                            'width'          => [
                                'default'    => [
                                    'top'    => '1',
                                    'right'  => '1',
                                    'bottom' => '1',
                                    'left'   => '1'
                                ]
                            ],
                            'color'          => [
                                'default'    => $exad_primary_color
                            ]
                        ],
                        'selector' => '{{WRAPPER}} .main-product-wrapper .exad-pagination li .page-numbers',
                    ]
                );

                $this->add_group_control(
                    Group_Control_Box_Shadow::get_type(),
                    [
                        'name'     => 'exad_woo_product_nav_pagination_normal_shadow',
                        'label'    => __( 'Box Shadow', 'exclusive-addons-elementor-pro' ),
                        'selector' => '{{WRAPPER}} .main-product-wrapper .exad-pagination li .page-numbers',
                    ]
                );

			$this->end_controls_tab();

			// hover state rating
			$this->start_controls_tab( 'exad_woo_product_nav_pagination_hover', [ 'label' => esc_html__( 'Hover / Active', 'exclusive-addons-elementor-pro' ) ] );

                $this->add_control(
                    'exad_woo_product_nav_pagination_hover_background',
                    [
                        'label'     => __( 'Background Color', 'exclusive-addons-elementor-pro' ),
                        'type'      => Controls_Manager::COLOR,
                        'default'   => $exad_primary_color,
                        'selectors' => [
                            '{{WRAPPER}} .main-product-wrapper .exad-pagination li .page-numbers:hover' => 'background: {{VALUE}}',
                            '{{WRAPPER}} .main-product-wrapper .exad-pagination ul li .page-numbers.current:hover' => 'background: {{VALUE}}',
                            '{{WRAPPER}} .main-product-wrapper .exad-pagination ul li .page-numbers.current' => 'background: {{VALUE}}',
                        ],
                    ]
                );

                $this->add_control(
                    'exad_woo_product_nav_pagination_hover_color',
                    [
                        'label'     => __( 'Icon & Number Color', 'exclusive-addons-elementor-pro' ),
                        'type'      => Controls_Manager::COLOR,
                        'default'   => '#ffffff',
                        'selectors' => [
                            '{{WRAPPER}} .main-product-wrapper .exad-pagination li .page-numbers:hover i' => 'color: {{VALUE}}',
                            '{{WRAPPER}} .main-product-wrapper .exad-pagination li .page-numbers.current' => 'color: {{VALUE}}',
                            '{{WRAPPER}} .main-product-wrapper .exad-pagination li .page-numbers.current:hover' => 'color: {{VALUE}}',
                            '{{WRAPPER}} .main-product-wrapper .exad-pagination li .page-numbers:hover' => 'color: {{VALUE}}',
                        ],
                    ]
                );

                $this->add_group_control(
                    Group_Control_Border::get_type(),
                    [
                        'name'     => 'exad_woo_product_nav_pagination_hover_border',
                        'label'    => __( 'Border', 'exclusive-addons-elementor-pro' ),
                        'selector' => '{{WRAPPER}} .main-product-wrapper .exad-pagination li .page-numbers:hover, {{WRAPPER}} .main-product-wrapper .exad-pagination li .page-numbers.current:hover,',
                    ]
                );

                $this->add_group_control(
                    Group_Control_Box_Shadow::get_type(),
                    [
                        'name'     => 'exad_woo_product_nav_pagination_hover_shadow',
                        'label'    => __( 'Box Shadow', 'exclusive-addons-elementor-pro' ),
                        'selector' => '{{WRAPPER}} .main-product-wrapper .exad-pagination li .page-numbers:hover, {{WRAPPER}} .main-product-wrapper .exad-pagination li .page-numbers.current:hover,',
                    ]
                );
                
			$this->end_controls_tab();

        $this->end_controls_tabs();


        $this->end_controls_section();


    }


    /**
     * Quick view product content structure.
     */
    private function quick_view_product_content_structure() {

        global $product;

        $post_id = $product->get_id();

        $single_structure = apply_filters(
            'exad_quick_view_product_structure',
            array(
                'title',
                'ratings',
                'price',
                'short_desc',
                'meta',
                'add_cart',
            )
        );

        if ( is_array( $single_structure ) && ! empty( $single_structure ) ) {

            foreach ( $single_structure as $value ) {

                switch ( $value ) {
                    case 'title':
                        /**
                         * Add Product Title on single product page for all products.
                         */
                        do_action( 'exad_quick_view_title_before', $post_id );
                        woocommerce_template_single_title();
                        do_action( 'exad_quick_view_title_after', $post_id );
                        break;
                    case 'price':
                        /**
                         * Add Product Price on single product page for all products.
                         */
                        do_action( 'exad_quick_view_price_before', $post_id );
                        woocommerce_template_single_price();
                        do_action( 'exad_quick_view_price_after', $post_id );
                        break;
                    case 'ratings':
                        /**
                         * Add rating on single product page for all products.
                         */
                        do_action( 'exad_quick_view_rating_before', $post_id );
                        woocommerce_template_single_rating();
                        do_action( 'exad_quick_view_rating_after', $post_id );
                        break;
                    case 'short_desc':
                        do_action( 'exad_quick_view_short_description_before', $post_id );
                        woocommerce_template_single_excerpt();
                        do_action( 'exad_quick_view_short_description_after', $post_id );
                        break;
                    case 'add_cart':
                        do_action( 'exad_quick_view_add_to_cart_before', $post_id );
                        woocommerce_template_single_add_to_cart();
                        do_action( 'exad_quick_view_add_to_cart_after', $post_id );
                        break;
                    case 'meta':
                        do_action( 'exad_quick_view_category_before', $post_id );
                        woocommerce_template_single_meta();
                        do_action( 'exad_quick_view_category_after', $post_id );
                        break;
                    default:
                        break;
                }
            }
        }

    }

    private function exad_woo_product_label() {
        $settings = $this->get_settings_for_display();

        global $product, $post;
        $out_of_stock = false;
        if (!$product->is_in_stock() && !is_product()) {
            $out_of_stock = true;
        }
        ?>

        <ul class="exad-woo-product-content-badge">
        <?php
            /* Sale label */
            if ($product->is_on_sale() && !$out_of_stock) {

                $percentage = '';

                if ($product->get_type() == 'variable') {

                    $available_variations = $product->get_variation_prices();
                    $max_percentage = 0;

                    foreach ($available_variations['regular_price'] as $key => $regular_price) {
                        $sale_price = $available_variations['sale_price'][$key];

                        if ($sale_price < $regular_price) {
                            $percentage = round((($regular_price - $sale_price) / $regular_price) * 100);

                            if ($percentage > $max_percentage) {
                                $max_percentage = $percentage;
                            }
                        }
                    }

                $percentage = $max_percentage;
                } elseif ($product->get_type() == 'simple' || $product->get_type() == 'external') {
                    $percentage = round((($product->get_regular_price() - $product->get_sale_price()) / $product->get_regular_price()) * 100);
                }

                if ( $percentage && ( 'yes' == $settings['exad_woo_product_sell_in_percentage_tag_enable'] )) { 
                    echo '<li class="onsale percent">'.$percentage.'%'.'</li>';
                } else if( $percentage && ( 'yes' != $settings['exad_woo_product_sell_in_percentage_tag_enable'] ) ) {
                    if('yes' == $settings['exad_woo_product_sale_tag_enable']){
                        echo '<li class="onsale">'.apply_filters('exad_product_offer_tag_filter', __('Sale', 'exclusive-addons-elementor-pro') ).'</li>';
                    }
                }

            }

            //Hot label
            if ($product->is_featured() && !$out_of_stock && ( 'yes' == $settings['exad_woo_product_featured_tag_enable'] )) {
                echo '<li class="featured">'.esc_html($settings['exad_woo_product_featured_tag_text']).'</li>';
            }

            // Out of stock
            if ($out_of_stock && ( 'yes' == $settings['exad_woo_product_sold_out_tag_enable'] )) {
                echo '<li class="out-of-stock">'.apply_filters('exad_product_sold_out_filter', __('Sold out', 'exclusive-addons-elementor-pro') ).'</li>';
            }
        ?>
        </ul>
    <?php    
    }

    /**
     * product price
     */
    protected function exad_woo_product_price() {

        if ( ! function_exists( 'wc_get_product' ) ) {
            return null;
        }
        $product  = wc_get_product( get_the_ID() );
        ?>

        <span class="exad-woo-product-content-price">
        <?php
            $price = $product->get_price_html();
            if ( ! empty( $price ) ) {
                echo wp_kses(
                    $price, array(
                        'span' => array(
                            'class' => array()
                        ),
                        'del'  => array()
                    )
                );
            }
        ?>
        </span>
        
    <?php    
    }

    protected function render() {
        if( ! class_exists('woocommerce') ) {
	        return;
        }

        $widget_id = $this->get_id();
        
        if ( Plugin::$instance->documents->get_current() ) {
            $page_id = Plugin::$instance->documents->get_current()->get_main_id();
        }

        $settings           = $this->get_settings_for_display();
        $starRating         = $settings['exad_woo_product_show_star_rating'];
        $orderby            = $settings['exad_woo_order_by'];
        $order              = $settings['exad_woo_order'];
        $product_per_page   = $settings['product_per_page'] ? $settings['product_per_page'] : -1;   
        $product_in_ids     = $settings['product_in_ids'] ? explode( ',', $settings['product_in_ids'] ) : null;
        $product_not_in_ids = $settings['product_not_in_ids'] ? explode( ',', $settings['product_not_in_ids'] ) : null; 

        $this->add_render_attribute( 
            'exad-woo-product-wrapper', 
            [ 
                'class' => [ 'exad-woo-product-wrapper' ]
            ]
        );

         //global $wp_query, $wp_rewrite;
        
         $offset = ! empty( $offset ) ? absint( $offset ) : 0;
       
         global $paged;
         if ( get_query_var('paged') ) {
             $paged = get_query_var('paged');
         }
         elseif ( get_query_var('page') ) {
             $paged = get_query_var('page');
         }
         else {
             $paged = 1;
         }

         $new_offset = (int)$settings['offset'] + ( ( $paged - 1 ) * (int)$product_per_page );

        $args = array(
            'post_type'      => 'product',
            'post_status'    => 'publish',
            'paged'			 => $paged,
            'posts_per_page' => $product_per_page,
            'offset'	     => $new_offset,
            'orderby'        => $orderby,
            'order'          => $order,
            'post__in'       => $product_in_ids,
            'post__not_in'   => $product_not_in_ids
        );

        // show only post has feature image
        if( $settings['only_post_has_image'] == 'yes' ){
            $args['meta_query'][] = array( 'key' => '_thumbnail_id');
        }

        // display products in category.
        if ( ! empty( $settings['exad_woo_product_categories'] ) ) {
            $args['tax_query'] = array(
                array(
                    'taxonomy' => 'product_cat',
                    'field'    => 'term_id',
                    'terms'    => $settings['exad_woo_product_categories']
                )
            );
        }

        $this->add_render_attribute(
            'exad_woo_product_grid_wrapper',
            [
                'class' => "products woocommerce exad-woo-products exad-col-{$settings['exad_woo_product_grid_column_no']}"
            ]
        );

        $wp_query = new \WP_Query( $args );
        if ( $wp_query->have_posts() ) : ?>
        <div class="main-product-wrapper">
            <div <?php echo $this->get_render_attribute_string( 'exad_woo_product_grid_wrapper' ); ?>>
            <?php
                while ( $wp_query->have_posts() ) : $wp_query->the_post();
                    global $product, $post;
                    $post_id        = $product->get_id();
                    $average        = $product->get_average_rating();
                    $attachment_ids = $product->get_gallery_image_ids();
                    ?>

                    <div <?php post_class( 'exad-woo-product-item exad-col' ); ?>>
                    <?php do_action( 'exad_before_each_product_item' ); ?>
                        <div class="exad-single-woo-product-wrapper">
                        <?php if( has_post_thumbnail() ) : ?>
                            <div class="exad-single-woo-product-image">
                            <?php
                                $this->exad_woo_product_label();
                                the_post_thumbnail( $settings['image_size_size'] ); ?>
                                  <?php if ( ( 'yes' == $settings['exad_woo_product_quick_view_swithcer'] ) || ('yes' == $settings['exad_woo_show_add_to_cart_icon_on_hover'] ) ) { ?>
                                    <div class="exad-single-woo-product-hover-items">
                                        <?php if ( 'yes' == $settings['exad_woo_show_add_to_cart_icon_on_hover'] ) { ?>
                                            <?php woocommerce_template_loop_add_to_cart(); ?>
                                        <?php } ;?>
                                        <?php if ( 'yes' == $settings['exad_woo_product_quick_view_swithcer'] ) { ?>
                                            <a href="javascript:void(0)" class="exad-product-quickview-btn exadquickview" data-widget-id = "<?php echo esc_attr( $widget_id ) ;?>" data-page-id = "<?php echo esc_attr( $page_id ) ;?>" data-product-id="<?php echo esc_attr( $post_id ) ;?>" title="<?php echo esc_html( $settings['exad_woo_product_quick_view_text']) ?>"><span><?php echo esc_html( $settings['exad_woo_product_quick_view_text']) ?></span></a>
                                        <?php } ;?>
                                    </div>
                                <?php } ;?>
                                <?php 
                                if( ! empty( $attachment_ids[0] ) && 'yes' == $settings['exad_woo_product_show_gallery_image_on_hover'] ) : ?>
                                    <span class="exad-product-hover-image">
                                        <?php echo wp_get_attachment_image( $attachment_ids[0], $settings['image_size_size'] ); ?>
                                    </span>
                                <?php endif; ?>
                            </div>
                            <?php endif; ?>

                            <div class="exad-single-woo-product-content">
                            <?php
                                do_action( 'exad_before_each_product_content' );
                                if( 'yes' == $settings['exad_woo_product_show_category'] ) :
                                    $terms = get_the_terms( $product->get_id(), 'product_cat' );
                                    if ( ! empty( $terms ) ) : ?>
                                        <a class="exad-product-cat" href="<?php echo esc_url( get_category_link( $terms[0]->term_id ) ); ?>"><?php echo esc_html( $terms[0]->name ); ?></a>
                                    <?php endif;                               
                                endif; 
                                ?>
                                <a href="<?php echo get_permalink(); ?>">
                                    <h3 class="exad-woo-product-content-name"><?php echo get_the_title(); ?></h3>
                                </a>
                                <?php
                                echo $this->exad_woo_product_price();
                                if( 'yes' == $starRating ) : ?>                           
                                    <ul class="exad-woo-product-content-rating">
                                        <div class="exad-woo-product-star-rating" title="<?php echo sprintf(__( 'Rated %s out of 5', 'exclusive-addons-elementor-pro' ), $average); ?>">
                                            <span style="width:<?php echo ( ( $average / 5 ) * 100 ); ?>%"><strong itemprop="ratingValue" class="rating"><?php echo $average; ?></strong> <?php _e( 'out of 5', 'exclusive-addons-elementor-pro' ); ?></span>
                                        </div>
                                    </ul>
                                <?php    
                                endif;

                                if( 'yes' == $settings['exad_woo_show_product_excerpt'] ) :
                                    $excerptLength = $settings['exad_woo_product_excerpt_length'] ? $settings['exad_woo_product_excerpt_length'] : 10; ?>
                                        <p class="exad-woo-product-content-description"><?php echo wp_trim_words( wp_kses_post( get_the_excerpt() ), esc_html( $excerptLength ) ); ?></p>
                                
                                <?php
                                endif;

                                if( 'yes' === $settings['exad_woo_show_add_to_cart_button'] ){
                                    woocommerce_template_loop_add_to_cart();
                                }
                                do_action('exad_after_each_product_content');
                                ?>

                            </div>
                        </div>
                        <?php do_action('exad_after_each_product_item'); ?>
                    </div>
                <?php endwhile; ?>
            </div>

            
            <?php
                $this->add_render_attribute(
                    'exad_woo_product_load_more_button',
                    [
                        'data-product-categories'      => $settings['exad_woo_product_categories'],
                        'data-order-by' => $settings['exad_woo_order_by'],
                        'data-order'    => $settings['exad_woo_order'],
                        'data-per-page'     => $settings['product_per_page'],
                        'data-in-ids'     => $settings['product_in_ids'],
                        'data-not-in-ids'   => $settings['product_not_in_ids'],
                        'data-image-size' => $settings['image_size_size'],
                        'data-only-post-has-image' => $settings['only_post_has_image'],
                        'data-show_category' => $settings['exad_woo_product_show_category'],
                        'data-show-star-rating' => $settings['exad_woo_product_show_star_rating'],
                        'data-sell-in-percentage-tag-enable' => $settings['exad_woo_product_sell_in_percentage_tag_enable'],
                        'data-sale-tag-enable' => $settings['exad_woo_product_sale_tag_enable'],
                        'data-sold-out-tag-enable' => $settings['exad_woo_product_sold_out_tag_enable'],
                        'data-featured-tag-enable' => $settings['exad_woo_product_featured_tag_enable'],
                        'data-featured-tag-text' => $settings['exad_woo_product_featured_tag_text'],
                        'data-excerpt' => $settings['exad_woo_show_product_excerpt'],
                        'data-excerpt-length' => $settings['exad_woo_product_excerpt_length'],
                        'data-excerpt-length' => $settings['exad_woo_product_excerpt_length'],
                        'data-offset-value' => $new_offset,
                    ]
                ); 
                ?>
                <?php if( 'load-more-btn' === $settings['exad_woo_product_pagination_options'] ) { ?>
                    <div class="exad-woo-product-load-btn">
                        <a class="exad-woo-product-paginate-btn" <?php echo $this->get_render_attribute_string( 'exad_woo_product_load_more_button' ); ?> href="#">
                            <?php echo esc_html( $settings['exad_woo_product_enable_load_more_btn_text'] ); ?>
                        </a>
                    </div>
                <?php } ?>
                <?php if( 'default-pagination' === $settings['exad_woo_product_pagination_options'] ) { ?>
                    <?php
                     
                    if ( $settings['exad_woo_product_pagination_prev_text'] ) {
                        $prev_text = $settings['exad_woo_product_pagination_prev_text'];
                     }  else if( empty( $settings['exad_woo_product_pagination_prev_text'] ) ) {
                        $prev_text = '';
                     } else {
                        $prev_text = apply_filters('exad_product_pagination_prev', __('Prev', 'exclusive-addons-elementor-pro') );
                     }

                    if ( $settings['exad_woo_product_pagination_next_text'] ) {
                        $next_text = $settings['exad_woo_product_pagination_next_text'];
                     } else if( empty( $settings['exad_woo_product_pagination_next_text'] ) ) {
                        $next_text = '';
                     } else {
                        $next_text = apply_filters('exad_product_pagination_next', __('Prev', 'exclusive-addons-elementor-pro') );
                     }
          

                        $pos = '';
                        $prev_icon = 'eicon-chevron-left';
                        $next_icon = 'eicon-chevron-right';
                      
                        $args = apply_filters(
                            'exad_pagination_args',
                            array(
                                'base'      => esc_url( str_replace( 999999999, '%#%', remove_query_arg( 'add-to-cart', get_pagenum_link( 999999999, false ) ) ) ),
                                'current'   => $paged,
                                'total'     => $wp_query->max_num_pages,
                                'mid_size'  => 1,
                                'type'      => 'list',
                                'prev_text' => '<i class="' . esc_attr($prev_icon) . '"></i>' . esc_html($prev_text),
                                'next_text' => esc_html($next_text) . '<i class="' . esc_attr($next_icon) . '"></i>',
                            )
                        );

                        $pagination_html = paginate_links( $args );
                   
                        echo '<div class="exad-pagination pagination' . ( $pos ? esc_attr( ' d-flex justify-content-' . $pos ) : '' ) . '">' . $pagination_html . '</div>';
                    ?>
                <?php } ?>
            </div>
        <?php                        
        endif;
        wp_reset_postdata();
    }
}