<?php
namespace ExclusiveAddons\Elements;

if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.

use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Image_Size;
use \Elementor\Icons_Manager;
use \Elementor\Group_Control_Border;
use \Elementor\Group_Control_Box_Shadow;
use \Elementor\Group_Control_Typography;
use \Elementor\Widget_Base;
use \Elementor\Group_Control_Background;

class Woo_Product_Carousel extends Widget_Base {
    
	public function get_name() {
		return 'exad-woo-product-carousel';
	}

	public function get_title() {
		return esc_html__( 'Woo Product Carousel', 'exclusive-addons-elementor-pro' );
	}

	public function get_icon() {
		return 'exad exad-logo exad-woo-products';
	}

	public function get_categories() {
		return [ 'exclusive-addons-elementor' ];
	}

    public function get_keywords() {
        return [ 'woo product', 'product carousel', 'carousel', 'woo carousel' ];
    }

	public function get_script_depends() {
		return [ 'swiper' ];
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

        $admin_link = admin_url( 'admin.php?page=exad-settings' );
        $exad_primary_color = get_option( 'exad_primary_color_option', '#7a56ff' );

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

        /**
  		*  Content Tab Query
  		*/
        $this->start_controls_section(
            'exad_woo_product_carousel_content_section',
            [
                'label' => esc_html__( 'Query', 'exclusive-addons-elementor-pro' ),
            ]
        );

        $this->add_control(
            'exad_woo_product_carousel_categories',
            [
                'label'         => esc_html__( 'Product Category', 'exclusive-addons-elementor-pro' ),
                'label_block'   => true,
                'type'          => Controls_Manager::SELECT2,
                'options'       => $this->exad_get_product_categories( 'product' ),
                'multiple'      => true
            ]
        );

         // show only featured Products?
         $this->add_control(
            'exad_woo_product_carousel_featured_switcher',
            [
                'label'         => esc_html__( 'Show only featured Products', 'exclusive-addons-elementor-pro' ),
                'type'          => Controls_Manager::SWITCHER,
                'default'       => 'no',
                'return_value'  => 'yes'
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
            'exad_woo_product_carousel_feature_options.',
            [
                'label'         => esc_html__( 'Features', 'exclusive-addons-elementor-pro' ),
                'type'          => Controls_Manager::HEADING,
                'separator'     => 'before'
            ]
        );

        $this->add_control(
            'exad_woo_product_carousel_show_category',
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
            'exad_woo_product_carousel_show_star_rating',
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
            'exad_woo_product_carousel_sell_in_percentage_tag_enable',
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
            'exad_woo_product_carousel_sale_tag_enable',
            [
                'label'        => esc_html__( 'Enable Sale Tag.', 'exclusive-addons-elementor-pro' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => __( 'Show', 'exclusive-addons-elementor-pro' ),
                'label_off'    => __( 'Hide', 'exclusive-addons-elementor-pro' ),
                'default'      => 'yes',
                'return_value' => 'yes',
                'description'  => __('Show "Sale" tag for products which are featured.', 'exclusive-addons-elementor-pro' ),
                'condition'    => [
                    'exad_woo_product_carousel_sell_in_percentage_tag_enable!' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'exad_woo_product_carousel_sold_out_tag_enable',
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
            'exad_woo_product_carousel_featured_tag_enable',
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
            'exad_woo_product_carousel_featured_tag_text',
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
            'exad_woo_product_carousel_excerpt_length',
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
            'exad_woo_product_carousel_show_add_to_cart_button',
            [
                'label'        => esc_html__( 'Enable Add to Cart Button', 'exclusive-addons-elementor-pro' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => __( 'Show', 'exclusive-addons-elementor-pro' ),
                'label_off'    => __( 'Hide', 'exclusive-addons-elementor-pro' ),
                'default'      => 'yes',
                'return_value' => 'yes'      
            ]
        );

        $this->end_controls_section();

        /**
  		*  Content Tab Carousel Settings
  		*/
        $this->start_controls_section(
            'exad_section_carousel_settings',
            [
                'label' => esc_html__( 'Carousel Settings', 'exclusive-addons-elementor-pro' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
		);

		$slides_per_view = range( 1, 6 );
		$slides_per_view = array_combine( $slides_per_view, $slides_per_view );

		$this->add_control(
            'exad_woo_product_carousel_nav',
            [
                'label'   => esc_html__( 'Navigation Style', 'exclusive-addons-elementor-pro' ),
                'type'    => Controls_Manager::SELECT,
                'default' => 'arrows-dots',
                'options' => [
					'arrows'   => esc_html__( 'Arrows', 'exclusive-addons-elementor-pro' ),
					'nav-dots' => esc_html__( 'Dots', 'exclusive-addons-elementor-pro' ),
                    'arrows-dots'     => esc_html__( 'Arrows and Dots', 'exclusive-addons-elementor-pro' ),
					'progress-bar' => esc_html__( 'Progress Bar', 'exclusive-addons-elementor-pro' ),
					'arrows-progress-bar' => esc_html__( 'Arrows and Progress Bar', 'exclusive-addons-elementor-pro' ),
					'fraction' => esc_html__( 'Fraction', 'exclusive-addons-elementor-pro' ),
					'arrows-fraction' => esc_html__( 'Arrows and Fraction', 'exclusive-addons-elementor-pro' ),
					'none'     => esc_html__( 'None', 'exclusive-addons-elementor-pro' )                    
                ]
            ]
        );

		$this->add_responsive_control(
			'slider_per_view',
			[
				'type'    => Controls_Manager::SELECT,
				'label'   => esc_html__( 'Columns', 'exclusive-addons-elementor-pro' ),
				'options' => $slides_per_view,
				'default' => '3',
				'tablet_default' => '2',
				'mobile_default' => '1',
			]
		);

		$this->add_responsive_control(
			'exad_woo_product_carousel_column_space',
			[
				'label' => __( 'Column Space', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 30,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 15,
				]
			]
		);

		$this->add_control(
			'exad_woo_product_carousel_slides_per_column',
			[
				'type'      => Controls_Manager::SELECT,
				'label'     => esc_html__( 'Slides Per Column', 'exclusive-addons-elementor-pro' ),
				'options'   => $slides_per_view,
				'default'   => '1',
			]
		);
		
		$this->add_control(
			'exad_woo_product_carousel_transition_duration',
			[
				'label'   => esc_html__( 'Transition Duration', 'exclusive-addons-elementor-pro' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 1000
			]
		);

		$this->add_control(
			'exad_woo_product_carousel_autoheight',
			[
				'label'     => esc_html__( 'Auto Height', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::SWITCHER,
				'default'   => 'yes'
			]
		);

		$this->add_control(
			'exad_woo_product_carousel_autoplay',
			[
				'label'     => esc_html__( 'Autoplay', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::SWITCHER,
				'default'   => 'yes'
			]
		);

		$this->add_control(
			'exad_woo_product_carousel_autoplay_speed',
			[
				'label'     => esc_html__( 'Autoplay Speed', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 5000,
				'condition' => [
					'exad_woo_product_carousel_autoplay' => 'yes'
				]
			]
		);

		$this->add_control(
			'exad_woo_product_carousel_loop',
			[
				'label'   => esc_html__( 'Infinite Loop', 'exclusive-addons-elementor-pro' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes'
			]
		);

		$this->add_control(
			'exad_woo_product_carousel_slide_centered',
			[
				'label'       => esc_html__( 'Centered Mode Slide', 'exclusive-addons-elementor-pro' ),
				'type'        => Controls_Manager::SWITCHER,
				'default'   => 'no',
			]
		);
		
		$this->add_control(
			'exad_woo_product_carousel_grab_cursor',
			[
				'label'       => esc_html__( 'Grab Cursor', 'exclusive-addons-elementor-pro' ),
				'type'        => Controls_Manager::SWITCHER,
				'default'   => 'no',
			]
		);

		$this->add_control(
			'exad_woo_product_carousel_observer',
			[
				'label'       => esc_html__( 'Observer', 'exclusive-addons-elementor-pro' ),
				'type'        => Controls_Manager::SWITCHER,
				'default'   => 'no',
			]
		);

		$this->end_controls_section();

        /**
  		*  Style Tab Container
  		*/
        $this->start_controls_section(
            'exad_woo_product_carousel_container_style',
            [
                'label'     => __( 'Container', 'exclusive-addons-elementor-pro' ),
                'tab'       => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_responsive_control(
            'exad_woo_product_carousel_container_padding',
            [
                'label'         => esc_html__( 'Padding', 'exclusive-addons-elementor-pro' ),
                'type'          => Controls_Manager::DIMENSIONS,            
                'size_units'    => [ 'px', 'em', '%' ],
                'default'       => [
                    'top'       => 0,
                    'right'     => 0,
                    'bottom'    => 0,
                    'left'      => 0,
                    'unit'      => 'px',
                    'isLinked'  => true
                ],
                'selectors'     => [
                        '{{WRAPPER}} .exad-woo-products-container.woocommerce .exad-woo-product-carousel-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->add_responsive_control(
            'exad_woo_product_carousel_container_margin',
            [
                'label'         => esc_html__( 'Margin', 'exclusive-addons-elementor-pro' ),
                'type'          => Controls_Manager::DIMENSIONS,            
                'size_units'    => [ 'px', 'em', '%' ],
                'default'       => [
                    'top'       => 0,
                    'right'     => 0,
                    'bottom'    => 0,
                    'left'      => 0,
                    'unit'      => 'px',
                    'isLinked'  => true
                ],
                'selectors'     => [
                        '{{WRAPPER}} .exad-woo-products-container.woocommerce .exad-woo-product-carousel-item' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'exad_woo_product_carousel_container_background',
				'label' => __( 'Background', 'exclusive-addons-elementor-pro' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .exad-woo-products-container.woocommerce .exad-woo-product-carousel-item',
			]
        ); 

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'      => 'exad_woo_product_carousel_container_border',
                'selector'  => '{{WRAPPER}} .exad-woo-products-container.woocommerce .exad-woo-product-carousel-item'
            ]
        );

        $this->add_responsive_control(
            'exad_woo_product_carousel_container_border_radius',
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
                        '{{WRAPPER}} .exad-woo-products-container.woocommerce .exad-woo-product-carousel-item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        ); 

        $this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'exad_woo_product_carousel_container_shadow',
				'label' => __( 'Box Shadow', 'exclusive-addons-elementor-pro' ),
				'selector' => '{{WRAPPER}} .exad-woo-products-container.woocommerce .exad-woo-product-carousel-item',
			]
		);

        $this->end_controls_section();

        /**
  		*  Style Tab Content Box
  		*/
        $this->start_controls_section(
            'exad_woo_product_carousel_content_box_style',
            [
                'label'     => __( 'Content Box', 'exclusive-addons-elementor-pro' ),
                'tab'       => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_responsive_control(
            'exad_woo_product_carousel_content_box_align',
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
            'exad_woo_product_carousel_content_box_padding',
            [
                'label'         => esc_html__( 'Padding', 'exclusive-addons-elementor-pro' ),
                'type'          => Controls_Manager::DIMENSIONS,            
                'size_units'    => [ 'px', 'em', '%' ],
                'default'       => [
                    'top'       => 20,
                    'right'     => 20,
                    'bottom'    => 20,
                    'left'      => 20,
                    'unit'      => 'px',
                    'isLinked' => true
                ],
                'selectors'     => [
                        '{{WRAPPER}} .exad-single-woo-product-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->add_responsive_control(
            'exad_woo_product_carousel_content_box_margin',
            [
                'label'         => esc_html__('Margin', 'exclusive-addons-elementor-pro' ),
                'type'          => Controls_Manager::DIMENSIONS, 
                'size_units'    => [ 'px', 'em', '%' ],
                'default'       => [
                    'top'       => 0,
                    'right'     => 0,
                    'bottom'    => 0,
                    'left'      => 0,
                    'isLinked' => true
                ],
                'selectors'     => [
                    '{{WRAPPER}} .exad-single-woo-product-content' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );  

        $this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'exad_woo_product_carousel_content_box_background',
				'label' => __( 'Background', 'exclusive-addons-elementor-pro' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .exad-single-woo-product-content',
			]
		);

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'      => 'exad_woo_product_carousel_content_box_border',
                'selector'  => '{{WRAPPER}} .exad-single-woo-product-content'
            ]
        );

        $this->add_responsive_control(
            'exad_woo_product_carousel_content_box_border_radius',
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
                'name'      => 'exad_woo_product_carousel_content_box_box_shadow',
                'selector'  => '{{WRAPPER}} .exad-single-woo-product-content'        
            ]
        );

        $this->end_controls_section();

        /**
  		*  Style Tab Image and Tags
  		*/
        $this->start_controls_section(
            'exad_woo_product_carousel_image_and_tag_style',
            [
                'label'     => __( 'Image and Tags', 'exclusive-addons-elementor-pro' ),
                'tab'       => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_control(
            'exad_woo_product_carousel_image_style',
            [
                'label'         => esc_html__( 'Image', 'exclusive-addons-elementor-pro' ),
                'type'          => Controls_Manager::HEADING
            ]
        );

        $this->add_responsive_control(
            'exad_woo_product_carousel_image_height',
            [
                'label'         => esc_html__('Image Height', 'exclusive-addons-elementor-pro' ),
                'type'          => Controls_Manager::SLIDER,
                'selectors'     => [
                    '{{WRAPPER}} .exad-woo-products-container.woocommerce .exad-woo-product-carousel-item .exad-single-woo-product-image' => 'height: {{SIZE}}{{UNIT}};'
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
            'exad_woo_product_carousel_image_padding',
            [
                'label'         => esc_html__( 'Padding', 'exclusive-addons-elementor-pro' ),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => [ 'px', '%' ],
                'selectors'     => [
                    '{{WRAPPER}} .exad-woo-products-container.woocommerce .exad-woo-product-carousel-item .exad-single-woo-product-image img' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ]
            ]
        );

        $this->add_control(
            'exad_woo_product_carousel_image_overlay_color',
            [
                'label'     => esc_html__( 'Overlay', 'exclusive-addons-elementor-pro' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .exad-woo-products-container.woocommerce .exad-woo-product-carousel-item .exad-single-woo-product-image:before' => 'background-color: {{VALUE}};'
                ]
            ]
        );

        $this->add_control(
            'exad_woo_product_carousel_image_hover_overlay_color',
            [
                'label'     => esc_html__( 'Hover Overlay', 'exclusive-addons-elementor-pro' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .exad-woo-products-container.woocommerce .exad-woo-product-carousel-item .exad-single-woo-product-image:hover:before' => 'background-color: {{VALUE}};'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'      => 'exad_woo_product_carousel_image_border',
                'selector'  => '{{WRAPPER}} .exad-woo-products-container.woocommerce .exad-woo-product-carousel-item .exad-single-woo-product-image img'
            ]
        );

        $this->add_responsive_control(
            'exad_woo_product_carousel_image_border_radius',
            [
                'label'         => esc_html__( 'Border Radius', 'exclusive-addons-elementor-pro' ),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => [ 'px', '%' ],
                'selectors'     => [
                    '{{WRAPPER}} .exad-woo-products-container.woocommerce .exad-woo-product-carousel-item .exad-single-woo-product-image img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .exad-woo-products-container.woocommerce .exad-woo-product-carousel-item .exad-single-woo-product-image:before' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->add_control(
            'exad_woo_product_carousel_show_gallery_image_on_hover',
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
                'name'      => 'exad_woo_product_carousel_image_box_shadow',
                'selector'  => '{{WRAPPER}} .exad-woo-products-container.woocommerce .exad-woo-product-carousel-item .exad-single-woo-product-image img'        
            ]
        );

        $this->add_control(
            'exad_woo_product_carousel_tag_style',
            [
                'label'         => esc_html__( 'Tags', 'exclusive-addons-elementor-pro' ),
                'type'          => Controls_Manager::HEADING,
                'separator'     => 'before'
            ]
        );

        $this->add_responsive_control(
            'exad_woo_product_carousel_tag_position',
            [
                'label'         => esc_html__('Position(From Right Side)', 'exclusive-addons-elementor-pro' ),
                'type'          => Controls_Manager::SLIDER,
                'default'       => [
                    'size'      => 20,
                    'unit'      => 'px'
                ],  
                'selectors'     => [
                    '{{WRAPPER}} .exad-woo-products-container.woocommerce .exad-woo-product-carousel-item .exad-single-woo-product-image .exad-woo-product-content-badge' => 'right: {{SIZE}}{{UNIT}};'
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
            'exad_woo_product_carousel_tag_padding',
            [
                'label'         => esc_html__( 'Padding', 'exclusive-addons-elementor-pro' ),
                'type'          => Controls_Manager::DIMENSIONS,            
                'size_units'    => [ 'px', 'em', '%' ],
                'selectors'     => [
                        '{{WRAPPER}} .exad-woo-products-container.woocommerce .exad-woo-product-carousel-item .exad-single-woo-product-image .exad-woo-product-content-badge li' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->add_responsive_control(
            'exad_woo_product_carousel_tag_border_radius',
            [
                'label'         => esc_html__( 'Border Radius', 'exclusive-addons-elementor-pro' ),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => [ 'px', '%' ],
                'selectors'     => [
                    '{{WRAPPER}} .exad-woo-products-container.woocommerce .exad-woo-product-carousel-item .exad-single-woo-product-image .exad-woo-product-content-badge li' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->add_control(
            'exad_woo_product_carousel_sale_tag_style',
            [
                'label'         => esc_html__( 'Sale Tag', 'exclusive-addons-elementor-pro' ),
                'type'          => Controls_Manager::HEADING
            ]
        );

        $this->add_control(
            'exad_woo_product_carousel_sale_tag_color',
            [
                'label'     => esc_html__( 'Color', 'exclusive-addons-elementor-pro' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .exad-woo-products-container.woocommerce .exad-woo-product-carousel-item .exad-single-woo-product-image .exad-woo-product-content-badge li.onsale' => 'color: {{VALUE}};'
                ]
            ]
        );

        $this->add_control(
            'exad_woo_product_carousel_sale_tag_bg_color',
            [
                'label'     => esc_html__( 'Background Color', 'exclusive-addons-elementor-pro' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#3BC473',
                'selectors' => [
                    '{{WRAPPER}} .exad-woo-products-container.woocommerce .exad-woo-product-carousel-item .exad-single-woo-product-image .exad-woo-product-content-badge li.onsale' => 'background-color: {{VALUE}};'
                ]
            ]
        );

        $this->add_control(
            'exad_woo_product_carousel_sold_out_tag_style',
            [
                'label'         => esc_html__( 'Sold Out Tag', 'exclusive-addons-elementor-pro' ),
                'type'          => Controls_Manager::HEADING
            ]
        );

        $this->add_control(
            'exad_woo_product_carousel_sold_out_tag_color',
            [
                'label'     => esc_html__( 'Color', 'exclusive-addons-elementor-pro' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .exad-woo-products-container.woocommerce .exad-woo-product-carousel-item .exad-single-woo-product-image .exad-woo-product-content-badge li.out-of-stock' => 'color: {{VALUE}};'
                ]
            ]
        );

        $this->add_control(
            'exad_woo_product_carousel_sold_out_tag_bg_color',
            [
                'label'     => esc_html__( 'Background Color', 'exclusive-addons-elementor-pro' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#3BC473',
                'selectors' => [
                    '{{WRAPPER}} .exad-woo-products-container.woocommerce .exad-woo-product-carousel-item .exad-single-woo-product-image .exad-woo-product-content-badge li.out-of-stock' => 'background-color: {{VALUE}};'
                ]
            ]
        );

        $this->add_control(
            'exad_woo_product_carousel_featured_tag_style',
            [
                'label'         => esc_html__( 'Featured Tag', 'exclusive-addons-elementor-pro' ),
                'type'          => Controls_Manager::HEADING
            ]
        );

        $this->add_control(
            'exad_woo_product_carousel_featured_tag_color',
            [
                'label'     => esc_html__( 'Color', 'exclusive-addons-elementor-pro' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .exad-woo-products-container.woocommerce .exad-woo-product-carousel-item .exad-single-woo-product-image .exad-woo-product-content-badge li.featured' => 'color: {{VALUE}};'
                ]
            ]
        );

        $this->add_control(
            'exad_woo_product_carousel_featured_tag_bg_color',
            [
                'label'     => esc_html__( 'Background Color', 'exclusive-addons-elementor-pro' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#FF7272',
                'selectors' => [
                    '{{WRAPPER}} .exad-woo-products-container.woocommerce .exad-woo-product-carousel-item .exad-single-woo-product-image .exad-woo-product-content-badge li.featured' => 'background-color: {{VALUE}};'
                ]
            ]
        );

        $this->end_controls_section();

        /**
  		*  Style Tab Product Category
  		*/
        $this->start_controls_section(
            'exad_woo_product_carousel_cat_style',
            [
                'label'     => __( 'Category', 'exclusive-addons-elementor-pro' ),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'exad_woo_product_carousel_show_category' => 'yes'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'exad_woo_product_carousel_cat_typography',
                'selector' => '{{WRAPPER}} .exad-woo-products-container.woocommerce .exad-woo-product-carousel-item .exad-single-woo-product-content a.exad-product-cat'
            ]
        );

        $this->add_responsive_control(
            'exad_woo_product_carousel_cat_padding',
            [
                'label'         => esc_html__( 'Padding', 'exclusive-addons-elementor-pro' ),
                'type'          => Controls_Manager::DIMENSIONS,            
                'size_units'    => [ 'px', 'em', '%' ],
                'selectors'     => [
                        '{{WRAPPER}} .exad-woo-products-container.woocommerce .exad-woo-product-carousel-item .exad-single-woo-product-content a.exad-product-cat' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->add_responsive_control(
            'exad_woo_product_carousel_cat_margin',
            [
                'label'         => esc_html__( 'Margin', 'exclusive-addons-elementor-pro' ),
                'type'          => Controls_Manager::DIMENSIONS,            
                'size_units'    => [ 'px', 'em', '%' ],
                'selectors'     => [
                        '{{WRAPPER}} .exad-woo-products-container.woocommerce .exad-woo-product-carousel-item .exad-single-woo-product-content a.exad-product-cat' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'      => 'exad_woo_product_carousel_cat_border',
                'selector'  => '{{WRAPPER}} .exad-woo-products-container.woocommerce .exad-woo-product-carousel-item .exad-single-woo-product-content a.exad-product-cat'
            ]
        );

        $this->add_responsive_control(
            'exad_woo_product_carousel_cat_border_radius',
            [
                'label'         => esc_html__( 'Border Radius', 'exclusive-addons-elementor-pro' ),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => [ 'px', '%' ],
                'selectors'     => [
                    '{{WRAPPER}} .exad-woo-products-container.woocommerce .exad-woo-product-carousel-item .exad-single-woo-product-content a.exad-product-cat' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->start_controls_tabs( 'exad_woo_product_carousel_cat_tabs' );

            // Normal State Tab
            $this->start_controls_tab( 'exad_woo_product_carousel_cat_normal', [ 'label' => esc_html__( 'Normal', 'exclusive-addons-elementor-pro' ) ] );

            $this->add_control(
                'exad_woo_product_carousel_cat_normal_color',
                [
                    'label'     => esc_html__( 'Color', 'exclusive-addons-elementor-pro' ),
                    'type'      => Controls_Manager::COLOR,
                    'default'   => '#000000',
                    'selectors' => [
                        '{{WRAPPER}} .exad-woo-products-container.woocommerce .exad-woo-product-carousel-item .exad-single-woo-product-content a.exad-product-cat' => 'color: {{VALUE}};'
                    ]
                ]
            );

            $this->add_control(
                'exad_woo_product_carousel_cat_normal_bg_color',
                [
                    'label'     => esc_html__( 'Background Color', 'exclusive-addons-elementor-pro' ),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .exad-woo-products-container.woocommerce .exad-woo-product-carousel-item .exad-single-woo-product-content a.exad-product-cat' => 'background-color: {{VALUE}};'
                    ]
                ]
            );

            $this->add_control(
                'exad_woo_product_carousel_cat_normal_border_color',
                [
                    'label'     => esc_html__( 'Border Color', 'exclusive-addons-elementor-pro' ),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .exad-woo-products-container.woocommerce .exad-woo-product-carousel-item .exad-single-woo-product-content a.exad-product-cat' => 'border-color: {{VALUE}};'
                    ]
                ]
            );
            
            $this->end_controls_tab();

            // Hover State Tab
            $this->start_controls_tab( 'exad_woo_product_carousel_cat_hover', [ 'label' => esc_html__( 'Hover', 'exclusive-addons-elementor-pro' ) ] );

            $this->add_control(
                'exad_woo_product_carousel_cat_hover_color',
                [
                    'label'     => esc_html__( 'Color', 'exclusive-addons-elementor-pro' ),
                    'type'      => Controls_Manager::COLOR,
                    'default'   => '#000000',
                    'selectors' => [
                        '{{WRAPPER}} .exad-woo-products-container.woocommerce .exad-woo-product-carousel-item .exad-single-woo-product-content a.exad-product-cat:hover' => 'color: {{VALUE}};'
                    ]
                ]
            );

            $this->add_control(
                'exad_woo_product_carousel_cat_hover_bg_color',
                [
                    'label'     => esc_html__( 'Background Color', 'exclusive-addons-elementor-pro' ),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .exad-woo-products-container.woocommerce .exad-woo-product-carousel-item .exad-single-woo-product-content a.exad-product-cat:hover' => 'background-color: {{VALUE}};'
                    ]
                ]
            );

            $this->add_control(
                'exad_woo_product_carousel_cat_hover_border_color',
                [
                    'label'     => esc_html__( 'Border Color', 'exclusive-addons-elementor-pro' ),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .exad-woo-products-container.woocommerce .exad-woo-product-carousel-item .exad-single-woo-product-content a.exad-product-cat:hover' => 'border-color: {{VALUE}};'
                    ]
                ]
            );

            $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();

        /**
  		*  Style Tab Product Title
  		*/
        $this->start_controls_section(
            'exad_woo_product_carousel_title_style',
            [
                'label'     => __( 'Title', 'exclusive-addons-elementor-pro' ),
                'tab'       => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'exad_woo_product_carousel_title_typography',
                'selector' => '{{WRAPPER}} .exad-single-woo-product-content h3.exad-woo-product-content-name'
            ]
        );

        $this->add_control(
            'exad_woo_product_carousel_title_color',
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
            'exad_woo_product_carousel_title_margin',
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

        /**
  		*  Style Tab Product Price
  		*/
        $this->start_controls_section(
            'exad_woo_product_carousel_price_style',
            [
                'label'     => __( 'Price', 'exclusive-addons-elementor-pro' ),
                'tab'       => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'exad_woo_product_carousel_price_typography',
                'selector' => '{{WRAPPER}} .exad-woo-products-container.woocommerce .exad-woo-product-carousel-item span.exad-woo-product-content-price'
            ]
        );

        $this->add_control(
            'exad_woo_product_carousel_price_color',
            [
                'label'     => esc_html__( 'Color', 'exclusive-addons-elementor-pro' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#000000',
                'selectors' => [
                    '{{WRAPPER}} .exad-woo-products-container.woocommerce .exad-woo-product-carousel-item span.exad-woo-product-content-price' => 'color: {{VALUE}};'
                ]
            ]
        );

        $this->add_control(
            'exad_woo_product_carousel_price_del_color_switcher',
            [
                'label'        => esc_html__( 'Style Delete Pricing', 'exclusive-addons-elementor-pro' ),
                'description'  => esc_html__('Set Delete Pricing Color & Typography', 'exclusive-addons-elementor-pro' ),
                'separator'     => 'before',
                'type'         => Controls_Manager::SWITCHER,
                'default'      => 'no',
                'return_value' => 'yes'      
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'exad_woo_product_carousel_price_del_typography',
                'condition'    => [
                    'exad_woo_product_carousel_price_del_color_switcher' => 'yes',
                ],
                'selector' => '{{WRAPPER}} .exad-woo-products-container.woocommerce .exad-woo-product-carousel-item span.exad-woo-product-content-price del'
            ]
        );

        $this->add_control(
            'exad_woo_product_carousel_price_del_color',
            [
                'label'     => esc_html__( 'Color', 'exclusive-addons-elementor-pro' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#000000',
                'condition'    => [
                    'exad_woo_product_carousel_price_del_color_switcher' => 'yes',
                ],
                'selectors' => [
                    '{{WRAPPER}} .exad-woo-products-container.woocommerce .exad-woo-product-carousel-item span.exad-woo-product-content-price del' => 'color: {{VALUE}};'
                ]
            ]
        );

        $this->add_responsive_control(
			'exad_woo_product_carousel_price_del_right_space',
			[
				'label' => __( 'Right Space', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 30,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 10,
                ],
                'condition'    => [
                    'exad_woo_product_carousel_price_del_color_switcher' => 'yes',
                ],
                'selectors' => [
                    '{{WRAPPER}} .exad-woo-products-container.woocommerce .exad-woo-product-carousel-item span.exad-woo-product-content-price del' => 'margin-right: {{SIZE}}{{UNIT}};',
                ]
			]
		);

        $this->add_responsive_control(
            'exad_woo_product_carousel_price_margin',
            [
                'label'         => esc_html__( 'Margin', 'exclusive-addons-elementor-pro' ),
                'type'          => Controls_Manager::DIMENSIONS, 
                'separator'     => 'before',           
                'size_units'    => [ 'px', 'em', '%' ],
                'selectors'     => [
                        '{{WRAPPER}} .exad-woo-products-container.woocommerce .exad-woo-product-carousel-item span.exad-woo-product-content-price' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->end_controls_section();

        /**
  		*  Style Tab Star Rating
  		*/
        $this->start_controls_section(
            'exad_woo_product_carousel_star_rating_style',
            [
                'label'     => __( 'Star Rating', 'exclusive-addons-elementor-pro' ),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'exad_woo_product_carousel_show_star_rating' => 'yes'
                ]
            ]
        );

        $this->add_responsive_control(
            'exad_woo_product_carousel_star_rating_font_size',
            [
                'label'         => esc_html__('Font Size', 'exclusive-addons-elementor-pro' ),
                'type'          => Controls_Manager::SLIDER,
                'default'       => [
                    'size'      => 18,
                    'unit'      => 'px'
                ],  
                'selectors'     => [
                    '{{WRAPPER}} .exad-woo-products-container.woocommerce .exad-woo-product-carousel-item .exad-woo-product-star-rating' => 'font-size: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};'
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
            'exad_woo_product_carousel_star_rating_color',
            [
                'label'         => esc_html__( 'Color', 'exclusive-addons-elementor-pro' ),
                'type'          => Controls_Manager::COLOR, 
                'default'       => '#3BC473',       
                'selectors'     => [
                    '{{WRAPPER}} .exad-woo-products-container.woocommerce .exad-woo-product-carousel-item .exad-woo-product-star-rating:before' => 'color: {{VALUE}};',
                ],               
            ]
        );

        $this->add_control(
			'exad_woo_product_carousel_star_rating_active_color',
			[
				'label'     => __( 'Active Color', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#FF7272',
				'selectors' => [
					'{{WRAPPER}} .exad-woo-products-container.woocommerce .exad-woo-product-carousel-item .exad-woo-product-star-rating span' => 'color: {{VALUE}};'
				]
			]
		);

        $this->add_responsive_control(
            'exad_woo_product_carousel_star_rating_margin',
            [
                'label'         => esc_html__( 'Margin', 'exclusive-addons-elementor-pro' ),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => [ 'px' ],
                'default'       => [
                    'top'       => 10,
                    'right'     => 0,
                    'bottom'    => 10,
                    'left'      => 0,
                    'isLinked'  => false
                ],
                'selectors'     => [
                    '{{WRAPPER}} ul.exad-woo-product-content-rating' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->end_controls_section();

        /**
  		*  Style Tab Excerpt
  		*/
        $this->start_controls_section(
            'exad_woo_product_carousel_excerpt_style',
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
                'name'     => 'exad_woo_product_carousel_excerpt_typography',
                'selector' => '{{WRAPPER}} .exad-single-woo-product-content p.exad-woo-product-content-description'
            ]
        );

        $this->add_control(
            'exad_woo_product_carousel_excerpt_color',
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
            'exad_woo_product_carousel_excerpt_margin',
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

        /**
  		*  Style Tab Button
  		*/
        $this->start_controls_section(
            'exad_woo_product_carousel_add_to_cart_btn_style',
            [
                'label'     => __( 'Button', 'exclusive-addons-elementor-pro' ),
                'tab'       => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'exad_woo_product_carousel_add_to_cart_btn_typography',
                'selector' => '{{WRAPPER}} .exad-woo-products-container.woocommerce .exad-woo-product-carousel-item .exad-single-woo-product-content a.button, {{WRAPPER}} .exad-woo-products-container.woocommerce .exad-woo-product-carousel-item .exad-single-woo-product-content a.added_to_cart'
            ]
        );

        $this->add_responsive_control(
            'exad_woo_product_carousel_add_to_cart_btn_padding',
            [
                'label'         => esc_html__( 'Padding', 'exclusive-addons-elementor-pro' ),
                'type'          => Controls_Manager::DIMENSIONS,            
                'size_units'    => [ 'px', 'em', '%' ],
                'selectors'     => [
                        '{{WRAPPER}} .exad-woo-products-container.woocommerce .exad-woo-product-carousel-item .exad-single-woo-product-content a.button, {{WRAPPER}} .exad-woo-products-container.woocommerce .exad-woo-product-carousel-item .exad-single-woo-product-content a.added_to_cart' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->add_responsive_control(
            'exad_woo_product_carousel_add_to_cart_btn_margin',
            [
                'label'         => esc_html__( 'Margin', 'exclusive-addons-elementor-pro' ),
                'type'          => Controls_Manager::DIMENSIONS,            
                'size_units'    => [ 'px', 'em', '%' ],
                'selectors'     => [
                        '{{WRAPPER}} .exad-woo-products-container.woocommerce .exad-woo-product-carousel-item .exad-single-woo-product-content a.button, {{WRAPPER}} .exad-woo-products-container.woocommerce .exad-woo-product-carousel-item .exad-single-woo-product-content a.added_to_cart' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );


        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'      => 'exad_woo_product_carousel_add_to_cart_btn_border',
                'selector'  => '{{WRAPPER}} .exad-woo-products-container.woocommerce .exad-woo-product-carousel-item .exad-single-woo-product-content a.button, {{WRAPPER}} .exad-woo-products-container.woocommerce .exad-woo-product-carousel-item .exad-single-woo-product-content a.added_to_cart'
            ]
        );

        $this->add_responsive_control(
            'exad_woo_product_carousel_add_to_cart_btn_border_radius',
            [
                'label'         => esc_html__( 'Border Radius', 'exclusive-addons-elementor-pro' ),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => [ 'px', '%' ],
                'selectors'     => [
                    '{{WRAPPER}} .exad-woo-products-container.woocommerce .exad-woo-product-carousel-item .exad-single-woo-product-content a.button, {{WRAPPER}} .exad-woo-products-container.woocommerce .exad-woo-product-carousel-item .exad-single-woo-product-content a.added_to_cart' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->start_controls_tabs( 'exad_woo_product_carousel_add_to_cart_btn_tabs' );

            // Normal State Tab
            $this->start_controls_tab( 'exad_woo_product_carousel_add_to_cart_btn_normal', [ 'label' => esc_html__( 'Normal', 'exclusive-addons-elementor-pro' ) ] );

            $this->add_control(
                'exad_woo_product_carousel_add_to_cart_btn_normal_color',
                [
                    'label'     => esc_html__( 'Color', 'exclusive-addons-elementor-pro' ),
                    'type'      => Controls_Manager::COLOR,
                    'default'   => '#ffffff',
                    'selectors' => [
                        '{{WRAPPER}} .exad-woo-products-container.woocommerce .exad-woo-product-carousel-item .exad-single-woo-product-content a.button, {{WRAPPER}} .exad-woo-products-container.woocommerce .exad-woo-product-carousel-item .exad-single-woo-product-content a.added_to_cart' => 'color: {{VALUE}};'
                    ]
                ]
            );

            $this->add_control(
                'exad_woo_product_carousel_add_to_cart_btn_normal_bg_color',
                [
                    'label'     => esc_html__( 'Background Color', 'exclusive-addons-elementor-pro' ),
                    'type'      => Controls_Manager::COLOR,
                    'default'   => '#3BC473',
                    'selectors' => [
                        '{{WRAPPER}} .exad-woo-products-container.woocommerce .exad-woo-product-carousel-item .exad-single-woo-product-content a.button, {{WRAPPER}} .exad-woo-products-container.woocommerce .exad-woo-product-carousel-item .exad-single-woo-product-content a.added_to_cart' => 'background-color: {{VALUE}};'
                    ]
                ]
            );

            $this->add_control(
                'exad_woo_product_carousel_add_to_cart_btn_normal_border_color',
                [
                    'label'     => esc_html__( 'Border Color', 'exclusive-addons-elementor-pro' ),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .exad-woo-products-container.woocommerce .exad-woo-product-carousel-item .exad-single-woo-product-content a.button, {{WRAPPER}} .exad-woo-products-container.woocommerce .exad-woo-product-carousel-item .exad-single-woo-product-content a.added_to_cart' => 'border-color: {{VALUE}};'
                    ]
                ]
            );

            $this->add_group_control(
                Group_Control_Box_Shadow::get_type(),
                [
                    'name' => 'exad_woo_product_carousel_add_to_cart_btn_normal_shadow',
                    'label' => __( 'Box Shadow', 'exclusive-addons-elementor-pro' ),
                    'selector' => '{{WRAPPER}} .exad-woo-products-container.woocommerce .exad-woo-product-carousel-item .exad-single-woo-product-content a.button, {{WRAPPER}} .exad-woo-products-container.woocommerce .exad-woo-product-carousel-item .exad-single-woo-product-content a.added_to_cart',
                ]
            );
            
            $this->end_controls_tab();

            // Hover State Tab
            $this->start_controls_tab( 'exad_woo_product_carousel_add_to_cart_btn_hover', [ 'label' => esc_html__( 'Hover', 'exclusive-addons-elementor-pro' ) ] );

            $this->add_control(
                'exad_woo_product_carousel_add_to_cart_btn_hover_color',
                [
                    'label'     => esc_html__( 'Color', 'exclusive-addons-elementor-pro' ),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .exad-woo-products-container.woocommerce .exad-woo-product-carousel-item .exad-single-woo-product-content a.button:hover, {{WRAPPER}} .exad-woo-products-container.woocommerce .exad-woo-product-carousel-item .exad-single-woo-product-content a.added_to_cart:hover' => 'color: {{VALUE}};'
                    ]
                ]
            );

            $this->add_control(
                'exad_woo_product_carousel_add_to_cart_btn_hover_bg_color',
                [
                    'label'     => esc_html__( 'Background Color', 'exclusive-addons-elementor-pro' ),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .exad-woo-products-container.woocommerce .exad-woo-product-carousel-item .exad-single-woo-product-content a.button:hover, {{WRAPPER}} .exad-woo-products-container.woocommerce .exad-woo-product-carousel-item .exad-single-woo-product-content a.added_to_cart:hover' => 'background-color: {{VALUE}};'
                    ]
                ]
            );

            $this->add_control(
                'exad_woo_product_carousel_add_to_cart_btn_hover_border_color',
                [
                    'label'     => esc_html__( 'Border Color', 'exclusive-addons-elementor-pro' ),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .exad-woo-products-container.woocommerce .exad-woo-product-carousel-item .exad-single-woo-product-content a.button:hover, {{WRAPPER}} .exad-woo-products-container.woocommerce .exad-woo-product-carousel-item .exad-single-woo-product-content a.added_to_cart:hover' => 'border-color: {{VALUE}};'
                    ]
                ]

            );

            $this->add_group_control(
                Group_Control_Box_Shadow::get_type(),
                [
                    'name' => 'exad_woo_product_carousel_add_to_cart_btn_hover_shadow',
                    'label' => __( 'Box Shadow', 'exclusive-addons-elementor-pro' ),
                    'selector' => '{{WRAPPER}} .exad-woo-products-container.woocommerce .exad-woo-product-carousel-item .exad-single-woo-product-content a.button:hover, {{WRAPPER}} .exad-woo-products-container.woocommerce .exad-woo-product-carousel-item .exad-single-woo-product-content a.added_to_cart:hover',
                ]
            );

            $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();

        /**
		 * Style Tab Arrows Style
		 */
		$this->start_controls_section(
            'exad_woo_product_carousel_nav_arrow',
            [
                'label'     => esc_html__( 'Arrows', 'exclusive-addons-elementor-pro' ),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'exad_woo_product_carousel_nav' => ['arrows', 'arrows-dots', 'arrows-fraction', 'arrows-progress-bar'],
                ],
            ]
        );

        $this->add_responsive_control(
            'exad_woo_product_carousel_nav_arrow_box_size',
            [
                'label'      => __( 'Box Size', 'exclusive-addons-elementor-pro' ),
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
                    'size' => 50,
                ],
                'selectors'  => [
                    '{{WRAPPER}} .exad-product-carousel-wrapper .exad-carousel-nav-prev' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .exad-product-carousel-wrapper .exad-carousel-nav-next' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'exad_woo_product_carousel_nav_arrow_icon_size',
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
                    '{{WRAPPER}} .exad-product-carousel-wrapper .exad-carousel-nav-prev i' => 'font-size: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .exad-product-carousel-wrapper .exad-carousel-nav-next i' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        
        $this->add_control(
            'exad_woo_product_carousel_prev_arrow_position',
            [
                'label'        => __( 'Previous Arrow Position', 'exclusive-addons-elementor-pro' ),
                'type'         => Controls_Manager::POPOVER_TOGGLE,
                'label_off'    => __( 'Default', 'exclusive-addons-elementor-pro' ),
                'label_on'     => __( 'Custom', 'exclusive-addons-elementor-pro' ),
                'return_value' => 'yes',
                'default'      => 'yes',
            ]
        );
        
        $this->start_popover();

            $this->add_responsive_control(
                'exad_woo_product_carousel_prev_arrow_position_x_offset',
                [
                    'label'      => __( 'X Offset', 'exclusive-addons-elementor-pro' ),
                    'type'       => Controls_Manager::SLIDER,
                    'size_units' => ['px', '%'],
                    'range'      => [
                        'px' => [
                            'min' => -3000,
                            'max' => 3000,
                        ],
                        '%'  => [
                            'min' => -100,
                            'max' => 100,
                        ],
                    ],
                    'default'    => [
                        'unit' => 'px',
                        'size' => 30,
                    ],
                    'selectors'  => [
                        '{{WRAPPER}} .exad-product-carousel-wrapper .exad-carousel-nav-prev' => 'left: {{SIZE}}{{UNIT}};',
                    ],
                ]
            );

            $this->add_responsive_control(
                'exad_woo_product_carousel_prev_arrow_position_y_offset',
                [
                    'label'      => __( 'Y Offset', 'exclusive-addons-elementor-pro' ),
                    'type'       => Controls_Manager::SLIDER,
                    'size_units' => ['px', '%'],
                    'range'      => [
                        'px' => [
                            'min' => -3000,
                            'max' => 3000,
                        ],
                        '%'  => [
                            'min' => -100,
                            'max' => 100,
                        ],
                    ],
                    'default'    => [
                        'unit' => '%',
                        'size' => 50,
                    ],
                    'selectors'  => [
                        '{{WRAPPER}} .exad-product-carousel-wrapper .exad-carousel-nav-prev' => 'top: {{SIZE}}{{UNIT}};',
                    ],
                ]
            );

        $this->end_popover();

        $this->add_control(
            'exad_woo_product_carousel_next_arrow_position',
            [
                'label'        => __( 'Next Arrow Position', 'exclusive-addons-elementor-pro' ),
                'type'         => Controls_Manager::POPOVER_TOGGLE,
                'label_off'    => __( 'Default', 'exclusive-addons-elementor-pro' ),
                'label_on'     => __( 'Custom', 'exclusive-addons-elementor-pro' ),
                'return_value' => 'yes',
                'default'      => 'yes',
            ]
        );
        
        $this->start_popover();

            $this->add_responsive_control(
                'exad_woo_product_carousel_next_arrow_position_x_offset',
                [
                    'label'      => __( 'X Offset', 'exclusive-addons-elementor-pro' ),
                    'type'       => Controls_Manager::SLIDER,
                    'size_units' => ['px', '%'],
                    'range'      => [
                        'px' => [
                            'min' => -3000,
                            'max' => 3000,
                        ],
                        '%'  => [
                            'min' => -100,
                            'max' => 100,
                        ],
                    ],
                    'default'    => [
                        'unit' => 'px',
                        'size' => 30,
                    ],
                    'selectors'  => [
                        '{{WRAPPER}} .exad-product-carousel-wrapper .exad-carousel-nav-next' => 'right: {{SIZE}}{{UNIT}};',
                    ],
                ]
            );

            $this->add_responsive_control(
                'exad_woo_product_carousel_next_arrow_position_y_offset',
                [
                    'label'      => __( 'Y Offset', 'exclusive-addons-elementor-pro' ),
                    'type'       => Controls_Manager::SLIDER,
                    'size_units' => ['px', '%'],
                    'range'      => [
                        'px' => [
                            'min' => -3000,
                            'max' => 3000,
                        ],
                        '%'  => [
                            'min' => -100,
                            'max' => 100,
                        ],
                    ],
                    'default'    => [
                        'unit' => '%',
                        'size' => 50,
                    ],
                    'selectors'  => [
                        '{{WRAPPER}} .exad-product-carousel-wrapper .exad-carousel-nav-next' => 'top: {{SIZE}}{{UNIT}};',
                    ],
                ]
            );

        $this->end_popover();

        $this->add_responsive_control(
            'exad_woo_product_carousel_nav_arrow_radius',
            [
                'label'      => __( 'Border radius', 'exclusive-addons-elementor-pro' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'default'    => [
                    'top'      => '50',
                    'right'    => '50',
                    'bottom'   => '50',
                    'left'     => '50',
                    'unit'     => 'px',
                    'isLinked' => true,
                ],
                'selectors'  => [
                    '{{WRAPPER}} .exad-product-carousel-wrapper .exad-carousel-nav-prev' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .exad-product-carousel-wrapper .exad-carousel-nav-next' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs( 'exad_woo_product_carousel_nav_arrow_tabs' );

			// normal state rating
			$this->start_controls_tab( 'exad_woo_product_carousel_nav_arrow_normal', [ 'label' => esc_html__( 'Normal', 'exclusive-addons-elementor-pro' ) ] );

                $this->add_control(
                    'exad_woo_product_carousel_arrow_normal_background',
                    [
                        'label'     => __( 'Background Color', 'exclusive-addons-elementor-pro' ),
                        'type'      => Controls_Manager::COLOR,
                        'default'   =>  $exad_primary_color,
                        'selectors' => [
                            '{{WRAPPER}} .exad-product-carousel-wrapper .exad-carousel-nav-prev' => 'background: {{VALUE}}',
                            '{{WRAPPER}} .exad-product-carousel-wrapper .exad-carousel-nav-next' => 'background: {{VALUE}}',
                        ],
                    ]
                );

                $this->add_control(
                    'exad_woo_product_carousel_arrow_normal_color',
                    [
                        'label'     => __( 'Icon Color', 'exclusive-addons-elementor-pro' ),
                        'type'      => Controls_Manager::COLOR,
                        'default'   => '#ffffff',
                        'selectors' => [
                            '{{WRAPPER}} .exad-product-carousel-wrapper .exad-carousel-nav-prev i' => 'color: {{VALUE}};',
                            '{{WRAPPER}} .exad-product-carousel-wrapper .exad-carousel-nav-next i' => 'color: {{VALUE}};',
                        ],
                    ]
                );

                $this->add_group_control(
                    Group_Control_Border::get_type(),
                    [
                        'name'     => 'exad_woo_product_carousel_arrow_normal_border',
                        'label'    => __( 'Border', 'exclusive-addons-elementor-pro' ),
                        'selector' => '{{WRAPPER}} .exad-product-carousel-wrapper .exad-carousel-nav-prev, {{WRAPPER}} .exad-product-carousel-wrapper .exad-carousel-nav-next',
                    ]
                );

                $this->add_group_control(
                    Group_Control_Box_Shadow::get_type(),
                    [
                        'name'     => 'exad_woo_product_carousel_arrow_normal_shadow',
                        'label'    => __( 'Box Shadow', 'exclusive-addons-elementor-pro' ),
                        'selector' => '{{WRAPPER}} .exad-product-carousel-wrapper .exad-carousel-nav-prev, {{WRAPPER}} .exad-product-carousel-wrapper .exad-carousel-nav-next',
                    ]
                );

			$this->end_controls_tab();

			// hover state rating
			$this->start_controls_tab( 'exad_woo_product_carousel_nav_arrow_hover', [ 'label' => esc_html__( 'Hover', 'exclusive-addons-elementor-pro' ) ] );

                $this->add_control(
                    'exad_woo_product_carousel_arrow_hover_background',
                    [
                        'label'     => __( 'Background Color', 'exclusive-addons-elementor-pro' ),
                        'type'      => Controls_Manager::COLOR,
                        'default'   => $exad_primary_color,
                        'selectors' => [
                            '{{WRAPPER}} .exad-product-carousel-wrapper .exad-carousel-nav-prev:hover' => 'background: {{VALUE}}',
                            '{{WRAPPER}} .exad-product-carousel-wrapper .exad-carousel-nav-next:hover' => 'background: {{VALUE}}',
                        ],
                    ]
                );

                $this->add_control(
                    'exad_woo_product_carousel_arrow_hover_color',
                    [
                        'label'     => __( 'Icon Color', 'exclusive-addons-elementor-pro' ),
                        'type'      => Controls_Manager::COLOR,
                        'default'   => '#ffffff',
                        'selectors' => [
                            '{{WRAPPER}} .exad-product-carousel-wrapper .exad-carousel-nav-prev:hover i' => 'color: {{VALUE}}',
                            '{{WRAPPER}} .exad-product-carousel-wrapper .exad-carousel-nav-next:hover i' => 'color: {{VALUE}}',
                        ],
                    ]
                );

                $this->add_group_control(
                    Group_Control_Border::get_type(),
                    [
                        'name'     => 'exad_woo_product_carousel_arrow_hover_border',
                        'label'    => __( 'Border', 'exclusive-addons-elementor-pro' ),
                        'selector' => '{{WRAPPER}} .exad-product-carousel-wrapper .exad-carousel-nav-prev:hover, {{WRAPPER}} .exad-product-carousel-wrapper .exad-carousel-nav-next:hover',
                    ]
                );

                $this->add_group_control(
                    Group_Control_Box_Shadow::get_type(),
                    [
                        'name'     => 'exad_woo_product_carousel_arrow_hover_shadow',
                        'label'    => __( 'Box Shadow', 'exclusive-addons-elementor-pro' ),
                        'selector' => '{{WRAPPER}} .exad-product-carousel-wrapper .exad-carousel-nav-prev:hover, {{WRAPPER}} .exad-product-carousel-wrapper .exad-carousel-nav-next:hover',
                    ]
                );

			$this->end_controls_tab();

        $this->end_controls_tabs();

		$this->end_controls_section();

		/**
		* Style Tab Dots Style
		*/
		$this->start_controls_section(
            'exad_woo_product_carousel_nav_dot',
            [
                'label'     => esc_html__( 'Dots', 'exclusive-addons-elementor-pro' ),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'exad_woo_product_carousel_nav' => ['nav-dots', 'arrows-dots'],
                ],
            ]
        );

        $this->add_control(
            'exad_woo_product_carousel_nav_dot_alignment',
            [
                'label'   => __( 'Alignment', 'exclusive-addons-elementor-pro' ),
                'type'    => Controls_Manager::CHOOSE,
                'options' => [
                    'exad-product-carousel-dots-left'   => [
                        'title' => __( 'Left', 'exclusive-addons-elementor-pro' ),
                        'icon'  => 'eicon-h-align-left',
                    ],
                    'exad-product-carousel-dots-center' => [
                        'title' => __( 'Center', 'exclusive-addons-elementor-pro' ),
                        'icon'  => 'eicon-h-align-center',
                    ],
                    'exad-product-carousel-dots-right'  => [
                        'title' => __( 'Right', 'exclusive-addons-elementor-pro' ),
                        'icon'  => 'eicon-h-align-right',
                    ],
                ],
                'default' => 'exad-product-carousel-dots-center',
            ]
        );

        $this->add_responsive_control(
            'exad_woo_product_carousel_dots_top_spacing',
            [
                'label'      => __( 'Top Spacing', 'exclusive-addons-elementor-pro' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range'      => [
                    'px' => [
                        'min' => -200,
                        'max' => 200,
                    ],
                ],
                'default'    => [
                    'unit' => 'px',
                    'size' => 0,
                ],
                'selectors'  => [
                    '{{WRAPPER}} .exad-product-carousel-wrapper .exad-swiper-pagination' => 'margin-top: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

		$this->add_responsive_control(
			'exad_woo_product_carousel_dots_spacing_btwn',
			[
				'label' => __( 'Space Between', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 8,
				],
                'condition' => [
                    'exad_woo_product_carousel_nav' => ['nav-dots', 'arrows-dots'],
                ],
				'selectors' => [
					'{{WRAPPER}} .exad-product-carousel-wrapper .exad-swiper-pagination .swiper-pagination-bullet:not(:last-child)' => 'margin-right: {{SIZE}}{{UNIT}};',
				]
			]
		);

        $this->add_responsive_control(
            'exad_woo_product_carousel_nav_dot_radius',
            [
                'label'      => __( 'Border Radius', 'exclusive-addons-elementor-pro' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'default'    => [
                    'top'      => '0',
                    'right'    => '0',
                    'bottom'   => '0',
                    'left'     => '0',
                    'unit'     => 'px',
                    'isLinked' => true,
                ],
                'selectors'  => [
                    '{{WRAPPER}} .exad-product-carousel-wrapper .exad-swiper-pagination .swiper-pagination-bullet' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs( 'exad_woo_product_carousel_nav_dots_tabs' );

			// normal state rating
            $this->start_controls_tab( 'exad_woo_product_carousel_nav_dots_normal', [ 'label' => esc_html__( 'Normal', 'exclusive-addons-elementor-pro' ) ] );

                $this->add_responsive_control(
                    'exad_woo_product_carousel_dots_normal_height',
                    [
                        'label'      => __( 'Height', 'exclusive-addons-elementor-pro' ),
                        'type'       => Controls_Manager::SLIDER,
                        'size_units' => ['px'],
                        'range'      => [
                            'px' => [
                                'min' => 0,
                                'max' => 100,
                            ],
                        ],
                        'default'    => [
                            'unit' => 'px',
                            'size' => 10,
                        ],
                        'selectors'  => [
                            '{{WRAPPER}} .exad-product-carousel-wrapper .exad-swiper-pagination .swiper-pagination-bullet' => 'height: {{SIZE}}{{UNIT}};',
                        ],
                    ]
                );

				$this->add_responsive_control(
                    'exad_woo_product_carousel_dots_normal_width',
                    [
                        'label'      => __( 'Width', 'exclusive-addons-elementor-pro' ),
                        'type'       => Controls_Manager::SLIDER,
                        'size_units' => ['px'],
                        'range'      => [
                            'px' => [
                                'min' => 0,
                                'max' => 100,
                            ],
                        ],
                        'default'    => [
                            'unit' => 'px',
                            'size' => 10,
                        ],
                        'selectors'  => [
                            '{{WRAPPER}} .exad-product-carousel-wrapper .exad-swiper-pagination .swiper-pagination-bullet' => 'width: {{SIZE}}{{UNIT}};',
                        ],
                    ]
                );

                $this->add_control(
                    'exad_woo_product_carousel_dots_normal_background',
                    [
                        'label'     => __( 'Background Color', 'exclusive-addons-elementor-pro' ),
                        'type'      => Controls_Manager::COLOR,
                        'default'   => '#e5e5e5',
                        'selectors' => [
                            '{{WRAPPER}} .exad-product-carousel-wrapper .exad-swiper-pagination .swiper-pagination-bullet' => 'background: {{VALUE}};',
                        ],
                    ]
                );
				
				$this->add_responsive_control(
                    'exad_woo_product_carousel_dots_normal_opacity',
                    [
                        'label'     => __( 'Opacity', 'exclusive-addons-elementor-pro' ),
                        'type'      => Controls_Manager::SLIDER,
                        'default' => [
							'size' => 1,
						],
						'range' => [
							'px' => [
								'max' => 1,
								'step' => 0.01,
							],
						],
                        'selectors' => [
                            '{{WRAPPER}} .exad-product-carousel-wrapper .exad-swiper-pagination .swiper-pagination-bullet' => 'opacity: {{SIZE}};',
                        ],
                    ]
                );

                $this->add_group_control(
                    Group_Control_Border::get_type(),
                    [
                        'name'     => 'exad_woo_product_carousel_dots_normal_border',
                        'label'    => __( 'Border', 'exclusive-addons-elementor-pro' ),
                        'selector' => '{{WRAPPER}} .exad-product-carousel-wrapper .exad-swiper-pagination .swiper-pagination-bullet , {{WRAPPER}} .exad-product-carousel-wrapper .exad-swiper-pagination .swiper-pagination-bullet:hover',
                    ]
                );

			$this->end_controls_tab();

			// hover state rating
            $this->start_controls_tab( 'exad_woo_product_carousel_nav_dots_hover', [ 'label' => esc_html__( 'Hover/active', 'exclusive-addons-elementor-pro' ) ] );
            
                $this->add_responsive_control(
                    'exad_woo_product_carousel_dots_active_height',
                    [
                        'label'      => __( 'Height', 'exclusive-addons-elementor-pro' ),
                        'type'       => Controls_Manager::SLIDER,
                        'size_units' => ['px', '%'],
                        'range'      => [
                            'px' => [
                                'min' => 0,
                                'max' => 100,
                            ],
                        ],
                        'default'    => [
                            'unit' => 'px',
                            'size' => 10,
                        ],
                        'selectors'  => [
                            '{{WRAPPER}} .exad-product-carousel-wrapper .exad-swiper-pagination .swiper-pagination-bullet-active' => 'height: {{SIZE}}{{UNIT}};',
                        ],
                    ]
                );

				$this->add_responsive_control(
                    'exad_woo_product_carousel_dots_active_width',
                    [
                        'label'      => __( 'Width', 'exclusive-addons-elementor-pro' ),
                        'type'       => Controls_Manager::SLIDER,
                        'size_units' => ['px', '%'],
                        'range'      => [
                            'px' => [
                                'min' => 0,
                                'max' => 100,
                            ],
                        ],
                        'default'    => [
                            'unit' => 'px',
                            'size' => 10,
                        ],
                        'selectors'  => [
                            '{{WRAPPER}} .exad-product-carousel-wrapper .exad-swiper-pagination .swiper-pagination-bullet-active' => 'width: {{SIZE}}{{UNIT}};',
                        ],
                    ]
                );

                $this->add_control(
                    'exad_woo_product_carousel_dots_active_background',
                    [
                        'label'     => __( 'Background Color', 'exclusive-addons-elementor-pro' ),
                        'type'      => Controls_Manager::COLOR,
                        'default'   => $exad_primary_color,
                        'selectors' => [
                            '{{WRAPPER}} .exad-product-carousel-wrapper .exad-swiper-pagination .swiper-pagination-bullet-active' => 'background: {{VALUE}};',
                            '{{WRAPPER}} .exad-product-carousel-wrapper .exad-swiper-pagination .swiper-pagination-bullet:hover' => 'background: {{VALUE}};',
                        ],
                    ]
                );

				$this->add_responsive_control(
                    'exad_woo_product_carousel_dots_hover_opacity',
                    [
                        'label'     => __( 'Opacity', 'exclusive-addons-elementor-pro' ),
                        'type'      => Controls_Manager::SLIDER,
						'default' => [
							'size' => 1,
						],
						'range' => [
							'px' => [
								'max' => 1,
								'step' => 0.01,
							],
						],
                        'selectors' => [
							'{{WRAPPER}} .exad-product-carousel-wrapper .exad-swiper-pagination .swiper-pagination-bullet-active' => 'opacity: {{SIZE}};',
                            '{{WRAPPER}} .exad-product-carousel-wrapper .exad-swiper-pagination .swiper-pagination-bullet:hover' => 'opacity: {{SIZE}};',
                        ],
                    ]
                );

                $this->add_group_control(
                    Group_Control_Border::get_type(),
                    [
                        'name'     => 'exad_woo_product_carousel_dots_active_border',
                        'label'    => __( 'Border', 'exclusive-addons-elementor-pro' ),
                        'selector' => '{{WRAPPER}} .exad-product-carousel-wrapper .exad-swiper-pagination .swiper-pagination-bullet-active, {{WRAPPER}} .exad-product-carousel-wrapper .exad-swiper-pagination .swiper-pagination-bullet:hover',
                    ]
                );

			$this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();

        /**
		* Style Tab Fraction Style
		*/
		$this->start_controls_section(
            'exad_woo_product_carousel_nav_fraction',
            [
                'label'     => esc_html__( 'Fraction', 'exclusive-addons-elementor-pro' ),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'exad_woo_product_carousel_nav' => ['fraction', 'arrows-fraction'],
                ],
            ]
        );

        $this->add_control(
            'exad_woo_product_carousel_nav_fraction_alignment',
            [
                'label'   => __( 'Alignment', 'exclusive-addons-elementor-pro' ),
                'type'    => Controls_Manager::CHOOSE,
                'options' => [
                    'exad-product-carousel-dots-left'   => [
                        'title' => __( 'Left', 'exclusive-addons-elementor-pro' ),
                        'icon'  => 'fa fa-align-left',
                    ],
                    'exad-product-carousel-dots-center' => [
                        'title' => __( 'Center', 'exclusive-addons-elementor-pro' ),
                        'icon'  => 'fa fa-align-center',
                    ],
                    'exad-product-carousel-dots-right'  => [
                        'title' => __( 'Right', 'exclusive-addons-elementor-pro' ),
                        'icon'  => 'fa fa-align-right',
                    ],
                ],
                'default' => 'exad-product-carousel-dots-center',
            ]
        );

        $this->add_responsive_control(
            'exad_woo_product_carousel_fraction_top_spacing',
            [
                'label'      => __( 'Top Spacing', 'exclusive-addons-elementor-pro' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range'      => [
                    'px' => [
                        'min' => -200,
                        'max' => 200,
                    ],
                ],
                'default'    => [
                    'unit' => 'px',
                    'size' => 30,
                ],
                'selectors'  => [
                    '{{WRAPPER}} .exad-product-carousel-wrapper .exad-swiper-pagination' => 'margin-top: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
			'exad_woo_product_carousel_fraction_spacing_btwn',
			[
				'label' => __( 'Space Between', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 8,
				],
				'selectors' => [
					'{{WRAPPER}} .exad-product-carousel-wrapper .exad-swiper-pagination.swiper-pagination-fraction .swiper-pagination-current' => 'margin-right: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .exad-product-carousel-wrapper .exad-swiper-pagination.swiper-pagination-fraction .swiper-pagination-total' => 'margin-left: {{SIZE}}{{UNIT}};',
				]
			]
		);

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'exad_woo_product_carousel_swiper-pagination_fraction_typography',
                'selector' => '{{WRAPPER}} .exad-product-carousel-wrapper .exad-swiper-pagination.swiper-pagination-fraction *',
            ]
        );

        $this->add_responsive_control(
            'exad_woo_product_carousel_nav_fraction_radius',
            [
                'label'      => __( 'Border Radius', 'exclusive-addons-elementor-pro' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'default'    => [
                    'top'      => '50',
                    'right'    => '50',
                    'bottom'   => '50',
                    'left'     => '50',
                    'unit'     => 'px',
                    'isLinked' => true,
                ],
                'selectors'  => [
                    '{{WRAPPER}} .exad-product-carousel-wrapper .exad-swiper-pagination.swiper-pagination-fraction span' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs( 'exad_woo_product_carousel_nav_fraction_tabs' );
        // normal state rating

            $this->start_controls_tab( 'exad_woo_product_carousel_nav_fraction_normal', [ 'label' => esc_html__( 'Normal', 'exclusive-addons-elementor-pro' ) ] );
                $this->add_responsive_control(
                    'exad_woo_product_carousel_fraction_normal_height',
                    [
                        'label'      => __( 'Height', 'exclusive-addons-elementor-pro' ),
                        'type'       => Controls_Manager::SLIDER,
                        'size_units' => ['px'],
                        'range'      => [
                            'px' => [
                                'min' => 0,
                                'max' => 100,
                            ],
                        ],
                        'default'    => [
                            'unit' => 'px',
                            'size' => 32,
                        ],
                        'selectors'  => [
                            '{{WRAPPER}} .exad-product-carousel-wrapper .exad-swiper-pagination.swiper-pagination-fraction .swiper-pagination-total' => 'height: {{SIZE}}{{UNIT}};',
                            '{{WRAPPER}} .exad-product-carousel-wrapper .exad-swiper-pagination.swiper-pagination-fraction .swiper-pagination-total' => 'line-height: {{SIZE}}{{UNIT}};',
                        ],
                    ]
                );

                $this->add_responsive_control(
                    'exad_woo_product_carousel_fraction_normal_width',
                    [
                        'label'      => __( 'Width', 'exclusive-addons-elementor-pro' ),
                        'type'       => Controls_Manager::SLIDER,
                        'size_units' => ['px'],
                        'range'      => [
                            'px' => [
                                'min' => 0,
                                'max' => 100,
                            ],
                        ],
                        'default'    => [
                            'unit' => 'px',
                            'size' => 32,
                        ],
                        'selectors'  => [
                            '{{WRAPPER}} .exad-product-carousel-wrapper .exad-swiper-pagination.swiper-pagination-fraction .swiper-pagination-total' => 'width: {{SIZE}}{{UNIT}};',
                        ],
                    ]
                );

                $this->add_control(
                    'exad_woo_product_carousel_pagination_fraction_color',
                    [
                        'label'     => esc_html__( 'Color', 'exclusive-addons-elementor-pro' ),
                        'type'      => Controls_Manager::COLOR,
                        'default'   => '#000000',
                        'selectors' => [
                            '{{WRAPPER}} .exad-product-carousel-wrapper .exad-swiper-pagination.swiper-pagination-fraction .swiper-pagination-total' => 'color: {{VALUE}};'
                        ]
                    ]
                );      
                
                $this->add_control(
                    'exad_woo_product_carousel_fraction_normal_background',
                    [
                        'label'     => __( 'Background Color', 'exclusive-addons-elementor-pro' ),
                        'type'      => Controls_Manager::COLOR,
                        'default'   => '#e5e5e5',
                        'selectors' => [
                            '{{WRAPPER}} .exad-product-carousel-wrapper .exad-swiper-pagination.swiper-pagination-fraction .swiper-pagination-total' => 'background: {{VALUE}};',
                        ],
                    ]
                );
                
                $this->add_group_control(
                    Group_Control_Border::get_type(),
                    [
                        'name'     => 'exad_woo_product_carousel_fraction_normal_border',
                        'label'    => __( 'Border', 'exclusive-addons-elementor-pro' ),
                        'selector' => '{{WRAPPER}} .exad-product-carousel-wrapper .exad-swiper-pagination.swiper-pagination-fraction .swiper-pagination-total',
                    ]
                );
            $this->end_controls_tab();

            // hover state rating
            $this->start_controls_tab( 'exad_woo_product_carousel_nav_fraction_hover', [ 'label' => esc_html__( 'Hover/active', 'exclusive-addons-elementor-pro' ) ] );
            
                $this->add_responsive_control(
                    'exad_woo_product_carousel_fraction_active_height',
                    [
                        'label'      => __( 'Height', 'exclusive-addons-elementor-pro' ),
                        'type'       => Controls_Manager::SLIDER,
                        'size_units' => ['px', '%'],
                        'range'      => [
                            'px' => [
                                'min' => 0,
                                'max' => 100,
                            ],
                        ],
                        'default'    => [
                            'unit' => 'px',
                            'size' => 32,
                        ],
                        'selectors'  => [
                            '{{WRAPPER}} .exad-product-carousel-wrapper .exad-swiper-pagination.swiper-pagination-fraction .swiper-pagination-current' => 'height: {{SIZE}}{{UNIT}};',
                            '{{WRAPPER}} .exad-product-carousel-wrapper .exad-swiper-pagination.swiper-pagination-fraction .swiper-pagination-current' => 'line-height: {{SIZE}}{{UNIT}};',
                        ],
                    ]
                );

				$this->add_responsive_control(
                    'exad_woo_product_carousel_fraction_active_width',
                    [
                        'label'      => __( 'Width', 'exclusive-addons-elementor-pro' ),
                        'type'       => Controls_Manager::SLIDER,
                        'size_units' => ['px', '%'],
                        'range'      => [
                            'px' => [
                                'min' => 0,
                                'max' => 100,
                            ],
                        ],
                        'default'    => [
                            'unit' => 'px',
                            'size' => 32,
                        ],
                        'selectors'  => [
                            '{{WRAPPER}} .exad-product-carousel-wrapper .exad-swiper-pagination.swiper-pagination-fraction .swiper-pagination-current' => 'width: {{SIZE}}{{UNIT}};',
                        ],
                    ]
                );

                $this->add_control(
                    'exad_woo_product_carousel_pagination_fraction_current_color',
                    [
                        'label'     => esc_html__( 'Color', 'exclusive-addons-elementor-pro' ),
                        'type'      => Controls_Manager::COLOR,
                        'default'   => '#fff',
                        'selectors' => [
                            '{{WRAPPER}} .exad-product-carousel-wrapper .exad-swiper-pagination.swiper-pagination-fraction .swiper-pagination-current' => 'color: {{VALUE}};'
                        ]
                    ]
                );     

                $this->add_control(
                    'exad_woo_product_carousel_fraction_active_background',
                    [
                        'label'     => __( 'Background Color', 'exclusive-addons-elementor-pro' ),
                        'type'      => Controls_Manager::COLOR,
                        'default'   => $exad_primary_color,
                        'selectors' => [
                            '{{WRAPPER}} .exad-product-carousel-wrapper .exad-swiper-pagination.swiper-pagination-fraction .swiper-pagination-current:hover' => 'background: {{VALUE}};',
                            '{{WRAPPER}} .exad-product-carousel-wrapper .exad-swiper-pagination.swiper-pagination-fraction .swiper-pagination-current' => 'background: {{VALUE}};',
                        ],
                    ]
                );

                $this->add_group_control(
                    Group_Control_Border::get_type(),
                    [
                        'name'     => 'exad_woo_product_carousel_fraction_active_border',
                        'label'    => __( 'Border', 'exclusive-addons-elementor-pro' ),
                        'selector' => '{{WRAPPER}} .exad-product-carousel-wrapper .exad-swiper-pagination.swiper-pagination-fraction .swiper-pagination-current',
                    ]
                );

			$this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

	    /**
		* Style Tab progressbar Style
		*/
		$this->start_controls_section(
            'exad_woo_product_carousel_nav_progressbar',
            [
                'label'     => esc_html__( 'Progress Bar', 'exclusive-addons-elementor-pro' ),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'exad_woo_product_carousel_nav' => ['progress-bar', 'arrows-progress-bar'],
                ],
            ]
        );

        $this->add_control(
            'exad_woo_product_carousel_nav_progressbar_normal_color',
            [
                'label'     => __( 'Normal Color', 'exclusive-addons-elementor-pro' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#e5e5e5',
                'selectors' => [
                    '{{WRAPPER}} .exad-product-carousel-wrapper .exad-dots-container .exad-swiper-pagination.swiper-pagination.swiper-pagination-progressbar' => 'background: {{VALUE}};',
                ],
            ]
        );
        
        $this->add_control(
            'exad_woo_product_carousel_nav_progressbar_active_color',
            [
                'label'     => __( 'Active Color', 'exclusive-addons-elementor-pro' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => $exad_primary_color,
                'separator' => "after",
                'selectors' => [
                    '{{WRAPPER}} .exad-product-carousel-wrapper .exad-dots-container .exad-swiper-pagination.swiper-pagination.swiper-pagination-progressbar .swiper-pagination-progressbar-fill' => 'background: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
			'exad_woo_product_carousel_nav_Progress_position',
			[
				'label'   => __( 'Position', 'exclusive-addons-elementor-pro' ),
				'type'    => Controls_Manager::CHOOSE,
				'toggle'  => false,
				'default' => 'exad-Progressbar-align-top',
				'options' => [
					'exad-Progressbar-align-top' => [
						'title' => __( 'Top', 'exclusive-addons-elementor-pro' ),
						'icon'  => 'eicon-arrow-up'
					],
					'exad-Progressbar-align-bottom' => [
						'title' => __( 'Bottom', 'exclusive-addons-elementor-pro' ),
						'icon'  => 'eicon-arrow-down'
					]
				]
			]
		);
        
        $this->add_responsive_control(
			'exad_woo_product_carousel_nav_Progress_specing',
			[
				'label'       => __( 'Spacing', 'exclusive-addons-elementor-pro' ),
				'type'        => Controls_Manager::SLIDER,
				'size_units'  => [ 'px' ],
				'range'       => [
					'px'      => [
						'min' => 0,
						'max' => 100
					]
				],
				'default'     => [
					'unit'    => 'px',
					'size'    => 0
				],
				'selectors'   => [
					'{{WRAPPER}} .exad-product-carousel-wrapper.exad-carousel-item.exad-Progressbar-align-top .exad-dots-container .exad-swiper-pagination.swiper-pagination.swiper-pagination-progressbar' => 'top: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .exad-product-carousel-wrapper.exad-carousel-item.exad-Progressbar-align-bottom .exad-dots-container .exad-swiper-pagination.swiper-pagination.swiper-pagination-progressbar' => 'bottom: {{SIZE}}{{UNIT}};'
				]
			]
		);

        $this->add_responsive_control(
            'exad_woo_product_carousel_nav_progressbar_height',
            [
                'label'      => __( 'Height', 'exclusive-addons-elementor-pro' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range'      => [
                    'px' => [
                        'min' => 0,
                        'max' => 10,
                    ],
                ],
                'default'    => [
                    'unit' => 'px',
                    'size' => 4,
                ],
                'selectors'  => [
                    '{{WRAPPER}} .exad-product-carousel-wrapper .exad-dots-container .exad-swiper-pagination.swiper-pagination.swiper-pagination-progressbar' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

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

    private function exad_woo_product_carousel_label() {
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

                if ( $percentage && ( 'yes' == $settings['exad_woo_product_carousel_sell_in_percentage_tag_enable'] )) { 
                    echo '<li class="onsale percent">'.$percentage.'%'.'</li>';
                } else if( $percentage && ( 'yes' != $settings['exad_woo_product_carousel_sell_in_percentage_tag_enable'] ) ) {
                    if('yes' == $settings['exad_woo_product_carousel_sale_tag_enable']){
                        echo '<li class="onsale">'.apply_filters('exad_product_offer_tag_filter', __('Sale', 'exclusive-addons-elementor-pro') ).'</li>';
                    }
                }

            }

            //Hot label
            if ($product->is_featured() && !$out_of_stock && ( 'yes' == $settings['exad_woo_product_carousel_featured_tag_enable'] )) {
                echo '<li class="featured">'.esc_html($settings['exad_woo_product_carousel_featured_tag_text']).'</li>';
            }

            // Out of stock
            if ($out_of_stock && ( 'yes' == $settings['exad_woo_product_carousel_sold_out_tag_enable'] )) {
                echo '<li class="out-of-stock">'.apply_filters('exad_product_sold_out_filter', __('Sold out', 'exclusive-addons-elementor-pro') ).'</li>';
            }
        ?>
        </ul>
    <?php    
    }

    /**
     * product price
     */
    protected function exad_woo_product_carousel_price() {

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

        $settings           = $this->get_settings_for_display();
        $id                 = $this->get_id();
        $starRating         = $settings['exad_woo_product_carousel_show_star_rating'];
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

        $args = array(
            'post_type'      => 'product',
            'post_status'    => 'publish',
            'no_found_rows'  => true,
            'posts_per_page' => $product_per_page,
            'orderby'        => $orderby,
            'order'          => $order,
            'post__in'       => $product_in_ids,
            'post__not_in'   => $product_not_in_ids,
            'meta_query'     => [],
			'tax_query'      => [ 'relation' => 'AND' ],
        );

        //$product_visibility_term_ids = wc_get_product_visibility_term_ids();

        // show only post has feature image
        if( $settings['only_post_has_image'] == 'yes' ){
            $args['meta_query'][] = array( 'key' => '_thumbnail_id');
        }

        // display products in category.
        if ( ! empty( $settings['exad_woo_product_carousel_categories'] ) ) {
            $args['tax_query'] = array(
                array(
                    'taxonomy' => 'product_cat',
                    'field'    => 'term_id',
                    'terms'    => $settings['exad_woo_product_carousel_categories'],
                    'operator' => 'IN'
                ),
            );
        }

        // display products in featured.
        if ( "yes" == $settings['exad_woo_product_carousel_featured_switcher'] ) {
            $args['tax_query'] = array(
                array(
                    'taxonomy' => 'product_visibility',
                    'field'    => 'term_id',
                    'terms'    => 'featured',
                    'operator' => 'IN'
                ),
            );
        }

        $this->add_render_attribute(
            'exad_woo_product_carousel_grid_wrapper',
            [
                'id'    => "exad-woo-carousel-wrapper",
                'class' => "woocommerce exad-woo-products-container"
            ]
        );

        
        // Carousel Settings
        $elementor_viewport_lg = get_option( 'elementor_viewport_lg' );
		$elementor_viewport_md = get_option( 'elementor_viewport_md' );
		$exad_viewport_lg     = !empty($elementor_viewport_lg) ? $elementor_viewport_lg - 1 : 1023;
		$exad_viewport_md     = !empty($elementor_viewport_md) ? $elementor_viewport_md - 1 : 767;

        if ( 'nav-dots' === $settings['exad_woo_product_carousel_nav'] || 'arrows-dots' === $settings['exad_woo_product_carousel_nav'] ) {
            $swiper_pagination_type = 'bullets';
        } elseif ( 'fraction' === $settings['exad_woo_product_carousel_nav'] || 'arrows-fraction' === $settings['exad_woo_product_carousel_nav'] ) {
            $swiper_pagination_type = 'fraction';
        } elseif ( 'progress-bar' === $settings['exad_woo_product_carousel_nav'] || 'arrows-progress-bar' === $settings['exad_woo_product_carousel_nav'] ) {
            $swiper_pagination_type = 'progressbar';
        } else {
			$swiper_pagination_type = '';
		}

        $this->add_render_attribute( 
            'exad-product-carousel-wrapper', 
            [ 
                'class'               => [ 'exad-product-carousel-wrapper exad-carousel-item' ],
            ]
        );
        $this->add_render_attribute( 
            'exad-product-carousel-wrapper', 
            [ 
                'data-autoplay' => ($settings["exad_woo_product_carousel_autoplay"] === "yes") ? true : false,
                'data-delay' => $settings["exad_woo_product_carousel_autoplay_speed"],
                'data-loop' => $settings["exad_woo_product_carousel_loop"] ? true : false,
                'data-speed' => $settings["exad_woo_product_carousel_transition_duration"],
                'data-slidesPerView' => isset($settings["slider_per_view_mobile"]) ? (int)$settings["slider_per_view_mobile"] : 1,
                'data-slidesPerColumn' => ($settings["exad_woo_product_carousel_slides_per_column"] > 1) ? $settings["exad_woo_product_carousel_slides_per_column"] : false,
                'data-centeredSlides' => ($settings["exad_woo_product_carousel_slide_centered"] === "yes") ? true : false,
                'data-spaceBetween' => $settings['exad_woo_product_carousel_column_space']['size'],
                'data-grabCursor' => ($settings["exad_woo_product_carousel_grab_cursor"] === "yes") ? true : false,
                'data-autoHeight' => ($settings["exad_woo_product_carousel_autoheight"] === "yes") ? true : false,
                'data-observer' => ($settings["exad_woo_product_carousel_observer"] === "yes") ? true : false,
                'data-type' => $swiper_pagination_type,
            ]
        );

        $breakpoint_data_settings = wp_json_encode(
            array_filter([
                (int) $exad_viewport_md 	=> [
                    "slidesPerView" 	=> isset($settings["slider_per_view_tablet"]) ? (int)$settings["slider_per_view_tablet"] : 2,
                    "spaceBetween"  	=> $settings["exad_woo_product_carousel_column_space"]["size"],
                    
                ],
                (int) $exad_viewport_lg 	=> [
                    "slidesPerView" 	=> (int)$settings["slider_per_view"],
                    "spaceBetween"  	=> $settings["exad_woo_product_carousel_column_space"]["size"],
                    
                ]
            ])
        );
        $this->add_render_attribute( 'exad-product-carousel-wrapper', 'data-breakpoint_settings',  $breakpoint_data_settings );
        $this->add_render_attribute( 'exad-product-carousel-wrapper', 'class', esc_attr( $settings['exad_woo_product_carousel_nav_dot_alignment'] ) );
        $this->add_render_attribute( 'exad-product-carousel-wrapper', 'class', esc_attr( $settings['exad_woo_product_carousel_nav_fraction_alignment'] ) );
        if ( 'progress-bar' === $settings['exad_woo_product_carousel_nav'] || 'arrows-progress-bar' === $settings['exad_woo_product_carousel_nav']) {
            $this->add_render_attribute( 'exad-product-carousel-wrapper', 'class', esc_attr( $settings['exad_woo_product_carousel_nav_Progress_position'] ) );
        }

        // Carousel Settings end


        $wp_query = new \WP_Query( $args );
        if ( $wp_query->have_posts() ) : ?>
            <div <?php echo $this->get_render_attribute_string( 'exad_woo_product_carousel_grid_wrapper' ); ?>>
                <div <?php echo $this->get_render_attribute_string( 'exad-product-carousel-wrapper' ); ?>>
                    <div class="swiper-container exad-product-carousel-wrapper-container">
                        <div class="swiper-wrapper">
                            <?php
                                while ( $wp_query->have_posts() ) : $wp_query->the_post();
                                    global $product, $post;
                                    $post_id        = $product->get_id();
                                    $average        = $product->get_average_rating();
                                    $attachment_ids = $product->get_gallery_image_ids();
                                    ?>
                                    <div class="swiper-slide exad-single-woo-carousel">
                                        <div <?php post_class( 'exad-woo-product-carousel-item exad-col' ); ?>>
                                        <?php do_action( 'exad_before_each_product_item' ); ?>
                                            <div class="exad-single-woo-product-wrapper">
                                            <?php if( has_post_thumbnail() ) : ?>
                                                <div class="exad-single-woo-product-image">
                                                <?php
                                                    $this->exad_woo_product_carousel_label();
                                                    the_post_thumbnail( $settings['image_size_size'] ); ?>
                                                    <?php if( 'yes' === $settings['exad_woo_product_carousel_show_add_to_cart_button'] ){ ?>
                                                    <div class="exad-single-woo-product-hover-items">
                                                        <?php woocommerce_template_loop_add_to_cart(); ?>
                                                    </div>
                                                    <?php } ?>
                                                    <?php 
                                                    if( ! empty( $attachment_ids[0] ) && 'yes' == $settings['exad_woo_product_carousel_show_gallery_image_on_hover'] ) : ?>
                                                        <span class="exad-product-hover-image">
                                                            <?php echo wp_get_attachment_image( $attachment_ids[0], $settings['image_size_size'] ); ?>
                                                        </span>
                                                    <?php endif; ?>
                                                </div>
                                                <?php endif; ?>

                                                <div class="exad-single-woo-product-content">
                                                <?php
                                                    do_action( 'exad_before_each_product_content' );
                                                    if( 'yes' == $settings['exad_woo_product_carousel_show_category'] ) :
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
                                                    echo $this->exad_woo_product_carousel_price();
                                                    if( 'yes' == $starRating ) : ?>                           
                                                        <ul class="exad-woo-product-content-rating">
                                                            <div class="exad-woo-product-star-rating" title="<?php echo sprintf(__( 'Rated %s out of 5', 'exclusive-addons-elementor-pro' ), $average); ?>">
                                                                <span style="width:<?php echo ( ( $average / 5 ) * 100 ); ?>%"><strong itemprop="ratingValue" class="rating"><?php echo $average; ?></strong> <?php _e( 'out of 5', 'exclusive-addons-elementor-pro' ); ?></span>
                                                            </div>
                                                        </ul>
                                                    <?php    
                                                    endif;

                                                    if( 'yes' == $settings['exad_woo_show_product_excerpt'] ) :
                                                        $excerptLength = $settings['exad_woo_product_carousel_excerpt_length'] ? $settings['exad_woo_product_carousel_excerpt_length'] : 10; ?>
                                                            <p class="exad-woo-product-content-description"><?php echo wp_trim_words( wp_kses_post( get_the_excerpt() ), esc_html( $excerptLength ) ); ?></p>
                                                    
                                                    <?php
                                                    endif;

                                                    if( 'yes' === $settings['exad_woo_product_carousel_show_add_to_cart_button'] ){
                                                        woocommerce_template_loop_add_to_cart();
                                                    }
                                                    do_action('exad_after_each_product_content');
                                                    ?>

                                                </div>
                                            </div>
                                        <?php do_action('exad_after_each_product_item'); ?>
                                        </div>
                                    </div>
                            <?php endwhile; ?>
                        </div>
                    </div>
                    <?php if ( class_exists('woocommerce') ):
                        if( $settings['exad_woo_product_carousel_nav'] === "arrows" || $settings['exad_woo_product_carousel_nav'] === "arrows-dots" || $settings['exad_woo_product_carousel_nav'] === "arrows-progress-bar" || $settings['exad_woo_product_carousel_nav'] == "arrows-fraction" ) : ?>
                            <div class="exad-carousel-nav-next"><i class="eicon-chevron-right"></i></div>
                            <div class="exad-carousel-nav-prev"><i class="eicon-chevron-left"></i></div>
                        <?php endif; ?>
                        <?php if( $settings['exad_woo_product_carousel_nav'] === "nav-dots" || $settings['exad_woo_product_carousel_nav'] === "arrows-dots" || $settings['exad_woo_product_carousel_nav'] === "progress-bar" || $settings['exad_woo_product_carousel_nav'] === "fraction" || $settings['exad_woo_product_carousel_nav'] === "arrows-progress-bar" || $settings['exad_woo_product_carousel_nav'] === "arrows-fraction" ) : ?>
                            <div class="exad-dots-container">
                                <div class="exad-swiper-pagination swiper-pagination"></div>
                            </div>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
            </div>

        <?php                        
        endif;
        wp_reset_postdata();
    }
}

