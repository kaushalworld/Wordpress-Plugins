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

class Product_Cross_Sell extends Widget_Base {

	public function get_name() {
		return 'exad-product-cross-sell';
	}

	public function get_title() {
		return esc_html__( 'Product Cross Sell', 'exclusive-addons-elementor-pro' );
	}

	public function get_icon() {
		return 'exad exad-logo exad-woo-products';
	}

	public function get_categories() {
		return [ 'exclusive-addons-elementor' ];
	}

	public function get_keywords() {
	    return [ 'product Cross Sell', 'Cross Sell', 'Cross Sell carousel', 'Cross Sell grid' ];
	}

    protected function register_controls() {

        $exad_primary_color   = get_option( 'exad_primary_color_option', '#7a56ff' );

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
         * Title Section
         */
		$this->start_controls_section(
			'exad_product_cross_sell_section_title_setting_section',
			[
				'label' => __( 'Title', 'exclusive-addons-elementor-pro' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'exad_product_cross_sell_section_title_text',
			[
				'label'      => esc_html__( 'You may also like&hellip;', 'exclusive-addons-elementor-pro' ),
				'type'       => Controls_Manager::TEXT,
                'label_block'   => true,
				'default'    => esc_html__( 'You may also like&hellip;', 'exclusive-addons-elementor-pro' ),
			]
		);

        $this->end_controls_section();

        /**
         * Content Section
         */
        $this->start_controls_section(
            'exad_product_cross_sell_content_settings_section',
            [
                'label' => esc_html__( 'Cross Sell Settings', 'exclusive-addons-elementor-pro' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'exad_product_cross_sell_content_setting_layout',
            [
				'label'   => __( 'Layout', 'exclusive-addons-elementor-pro' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'grid-layout',
				'prefix_class' => 'woocommerce exad-product-cross-sell-',
				'options' => [
					'grid-layout' => esc_html__( 'Grid Layout', 'exclusive-addons-elementor-pro' ),
					'carousel-layout' => esc_html__( 'Carousel Layout', 'exclusive-addons-elementor-pro' ),
				]
            ]
		);

        $this->add_control(
			'exad_product_cross_sell_posts_per_page',
			[
				'label' => __( 'Products Per Page', 'exclusive-addons-elementor-pro' ),
				'type'  => Controls_Manager::NUMBER,
				'default' => 4,
				'range' => [
					'px' => [
						'max' => 20,
					],
				],
			]
		);

		$this->add_responsive_control(
			'exad_cross_sell_columns',
			[
				'label' => __( 'Columns', 'exclusive-addons-elementor-pro' ),
				'type'  => Controls_Manager::NUMBER,
				'prefix_class' => 'exad-cross-sell-columns%s-',
				'default' => 4,
				'min' => 1,
				'max' => 6,
			]
		);

		$this->add_control(
			'exad_cross_sell_orderby',
			[
				'label' => __( 'Order By', 'exclusive-addons-elementor-pro' ),
				'type'  => Controls_Manager::SELECT,
				'default' => 'date',
				'options' => [
					'date'          => __( 'Date', 'exclusive-addons-elementor-pro' ),
					'title'         => __( 'Title', 'exclusive-addons-elementor-pro' ),
					'price'         => __( 'Price', 'exclusive-addons-elementor-pro' ),
					'popularity'    => __( 'Popularity', 'exclusive-addons-elementor-pro' ),
					'rating'        => __( 'Rating', 'exclusive-addons-elementor-pro' ),
					'rand'          => __( 'Random', 'exclusive-addons-elementor-pro' ),
					'menu_order'    => __( 'Menu Order', 'exclusive-addons-elementor-pro' ),
				],
			]
		);

		$this->add_control(
			'exad_cross_sell_order',
			[
				'label' => __( 'Order', 'exclusive-addons-elementor-pro' ),
				'type'  => Controls_Manager::SELECT,
				'default' => 'desc',
				'options' => [
					'asc'   => __( 'ASC', 'exclusive-addons-elementor-pro' ),
					'desc'  => __( 'DESC', 'exclusive-addons-elementor-pro' ),
				],
			]
		);

		$this->add_control(
			'exad_cross_sell_show_heading',
			[
				'label'         => __( 'Heading', 'exclusive-addons-elementor-pro' ),
				'type'          => Controls_Manager::SWITCHER,
				'label_on'      => __( 'Show', 'exclusive-addons-elementor-pro' ),
				'label_off'     => __( 'Hide', 'exclusive-addons-elementor-pro' ),
				'render_type'   => 'ui',
				'return_value'  => 'yes',
				'default'       => 'yes',
				'prefix_class'  => 'exad-show-heading-',
			]
		);

		$this->end_controls_section();

        /**
         * Content Section
         */
        $this->start_controls_section(
            'exad_product_cross_sell_content_section',
            [
                'label' => esc_html__( 'Content', 'exclusive-addons-elementor-pro' ),
            ]
        );

        $this->add_control(
			'exad_product_cross_sell_before',
			[
				'label'       => esc_html__( 'Before Cross Sell', 'exclusive-addons-elementor-pro' ),
				'type'        => Controls_Manager::TEXTAREA
			]
        );

		$this->add_control(
			'exad_product_cross_sell_after',
			[
				'label'       => esc_html__( 'After Cross Sell', 'exclusive-addons-elementor-pro' ),
				'type'        => Controls_Manager::TEXTAREA
			]
        );
        
        $this->add_control( 'exad_product_update_info',
            [
                'type'  => Controls_Manager::RAW_HTML,
                'raw'   => __( '<strong>Product Cross Sell - </strong> Go to Style Tab ',
                        'exclusive-addons-elementor-pro' ),
                    'content_classes' => 'exad-panel-notice',
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
                'condition' => [
                    'exad_product_cross_sell_content_setting_layout' => 'carousel-layout',
                ],
            ]
		);

		$slides_per_view = range( 1, 6 );
		$slides_per_view = array_combine( $slides_per_view, $slides_per_view );

		$this->add_control(
            'exad_product_cross_sell_carousel_nav',
            [
                'label'   => esc_html__( 'Navigation Style', 'exclusive-addons-elementor-pro' ),
                'type'    => Controls_Manager::SELECT,
                'prefix_class' => 'exad-product-navigation-',
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
			'exad_product_cross_sell_carousel_column_space',
			[
				'label' => __( 'Column Space', 'exclusive-addons-elementor-pro' ),
				'type'  => Controls_Manager::SLIDER,
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
			'exad_product_cross_sell_carousel_slides_to_scroll',
			[
				'type'    => Controls_Manager::SELECT,
				'label'   => esc_html__( 'Items to Scroll', 'exclusive-addons-elementor-pro' ),
				'options' => $slides_per_view,
				'default'        => 1,
				'tablet_default' => 1,
				'mobile_default' => 1,
			]
		);

		$this->add_control(
			'exad_product_cross_sell_carousel_slides_per_column',
			[
				'type'      => Controls_Manager::SELECT,
				'label'     => esc_html__( 'Slides Per Column', 'exclusive-addons-elementor-pro' ),
				'options'   => $slides_per_view,
				'default'   => '1',
			]
		);
		
		$this->add_control(
			'exad_product_cross_sell_carousel_transition_duration',
			[
				'label'   => esc_html__( 'Transition Duration', 'exclusive-addons-elementor-pro' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 1000
			]
		);

		$this->add_control(
			'exad_product_cross_sell_carousel_autoheight',
			[
				'label'     => esc_html__( 'Auto Height', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::SWITCHER,
				'default'   => 'yes'
			]
		);

		$this->add_control(
			'exad_product_cross_sell_carousel_autoplay',
			[
				'label'     => esc_html__( 'Autoplay', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::SWITCHER,
				'default'   => 'yes'
			]
		);

		$this->add_control(
			'exad_product_cross_sell_carousel_autoplay_speed',
			[
				'label'     => esc_html__( 'Autoplay Speed', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 5000,
				'condition' => [
					'exad_product_cross_sell_carousel_autoplay' => 'yes'
				]
			]
		);

		$this->add_control(
			'exad_product_cross_sell_carousel_loop',
			[
				'label'   => esc_html__( 'Infinite Loop', 'exclusive-addons-elementor-pro' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes'
			]
		);

		$this->add_control(
			'exad_product_cross_sell_carousel_pause',
			[
				'label'     => esc_html__( 'Pause on Hover', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::SWITCHER,
				'default'   => 'yes',
				'condition' => [
					'exad_product_cross_sell_carousel_autoplay' => 'yes'
				]
			]
		);

		$this->add_control(
			'exad_product_cross_sell_carousel_slide_centered',
			[
				'label'       => esc_html__( 'Centered Mode Slide', 'exclusive-addons-elementor-pro' ),
				'type'        => Controls_Manager::SWITCHER,
				'default'     => 'no',
			]
		);
		
		$this->add_control(
			'exad_product_cross_sell_carousel_grab_cursor',
			[
				'label'       => esc_html__( 'Grab Cursor', 'exclusive-addons-elementor-pro' ),
				'type'        => Controls_Manager::SWITCHER,
				'default'     => 'no',
			]
		);

		$this->add_control(
			'exad_product_cross_sell_carousel_observer',
			[
				'label'       => esc_html__( 'Observer', 'exclusive-addons-elementor-pro' ),
				'type'        => Controls_Manager::SWITCHER,
				'default'     => 'no',
			]
		);

		$this->end_controls_section();

        /**
         * Style Section
         */

        /*
		* product Cross Sell container Styling Section
		*/
        $this->start_controls_section(
            'exad_product_cross_sell_container_style_section',
            [
                'label' => esc_html__( 'Container', 'exclusive-addons-elementor-pro' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
		);

        $this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'exad_product_cross_sell_container_background',
				'types'    => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .exad-product-cross-sell'
			]
		);

		$this->add_responsive_control(
			'exad_product_cross_sell_container_padding',
			[
				'label'         => __( 'Padding', 'exclusive-addons-elementor-pro' ),
				'type'          => Controls_Manager::DIMENSIONS,
				'size_units'    => [ 'px', '%' ],
				'default'       => [
					'top'       => '0',
					'right'     => '0',
					'bottom'    => '0',
					'left'      => '0',
					'unit'      => 'px',
                    'isLinked'  => false
				],
				'selectors'     => [
					'{{WRAPPER}} .exad-product-cross-sell' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
		);

		$this->add_responsive_control(
			'exad_product_cross_sell_container_margin',
			[
				'label'        => __( 'Margin', 'exclusive-addons-elementor-pro' ),
				'type'         => Controls_Manager::DIMENSIONS,
				'size_units'   => [ 'px', '%' ],
				'default'      => [
					'top'      => '0',
					'right'    => '0',
					'bottom'   => '0',
					'left'     => '0',
					'unit'     => 'px',
					'isLinked' => false
				],
				'selectors'    => [
					'{{WRAPPER}} .exad-product-cross-sell' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
        );

        $this->add_responsive_control(
			'exad_product_cross_sell_container_radius',
			[
				'label'      => __( 'Border Radius', 'exclusive-addons-elementor-pro' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'default'    => [
					'top'    => '0',
					'right'  => '0',
					'bottom' => '0',
					'left'   => '0',
					'unit'   => 'px'
				],
				'selectors'  => [
					'{{WRAPPER}} .exad-product-cross-sell' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'               => 'exad_product_cross_sell_container_border',
				'selector'           => '{{WRAPPER}} .exad-product-cross-sell'
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'exad_product_cross_sell_container_box_shadow',
				'selector' => '{{WRAPPER}} .exad-product-cross-sell'
			]
		);

        $this->end_controls_section();

        /*
        *Cross Sell product Title Styling Section
		*/
		$this->start_controls_section(
            'exad_product_cross_sell_title_style',
            [
                'label'     => __( 'Cross Sell Title', 'exclusive-addons-elementor-pro' ),
                'tab'       => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'exad_product_cross_sell_title_typography',
                'selector' => '{{WRAPPER}} .exad-product-cross-sell .Cross Sells.products > h2'
            ]
        );

        $this->add_control(
            'exad_product_cross_sell_title_color',
            [
                'label'     => esc_html__( 'Color', 'exclusive-addons-elementor-pro' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#000000',
                'selectors' => [
                    '{{WRAPPER}} .exad-product-cross-sell .cross-sells > h2' => 'color: {{VALUE}};'
                ]
            ]
        );

        $this->add_responsive_control(
            'exad_product_cross_sell_title_margin',
            [
                'label'         => esc_html__( 'Margin', 'exclusive-addons-elementor-pro' ),
                'type'          => Controls_Manager::DIMENSIONS,            
                'size_units'    => [ 'px', 'em', '%' ],
                'selectors'     => [
                        '{{WRAPPER}} .exad-product-cross-sell .cross-sells > h2' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->end_controls_section();

	    /*
		* Cross-Sells Content Box Styling Section
		*/
        $this->start_controls_section(
            'exad_product_cross_sell_content_box_style',
            [
                'label'     => __( 'Content Box', 'exclusive-addons-elementor-pro' ),
                'tab'       => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_responsive_control(
            'exad_product_cross_sell_content_box_align',
            [
                'label'         => esc_html__( 'Alignment', 'exclusive-addons-elementor-pro' ),
                'type'          => Controls_Manager::CHOOSE,
                'toggle'        => false,
                'options'       => [
                    'left' => [
                        'title'  => esc_html__( 'Left', 'exclusive-addons-elementor-pro' ),
                        'icon'   => 'eicon-h-align-left'
                    ],
                    'center'     => [
                        'title'  => esc_html__( 'Center', 'exclusive-addons-elementor-pro' ),
                        'icon'   => 'eicon-h-align-center'
                    ],
                    'right'   => [
                        'title'  => esc_html__( 'Right', 'exclusive-addons-elementor-pro' ),
                        'icon'   => 'eicon-h-align-right'
                    ]
                ],
                'default' => 'left',
				'selectors_dictionary' => [
					'left' => 'display: flex; flex-direction: column; align-items: flex-start; text-align: left;',
					'center' => 'display: flex; flex-direction: column; align-items: center; text-align: center;',
					'right' => 'display: flex; flex-direction: column; align-items: flex-end; text-align: right;',
				],
                'selectors'     => [
                    '{{WRAPPER}} .exad-product-cross-sell .cross-sells .products .product' => '{{VALUE}};'
                ]
            ]
        );

        $this->add_responsive_control(
            'exad_product_cross_sell_content_box_rating_align',
            [
                'label'         => esc_html__( 'Rating Alignment', 'exclusive-addons-elementor-pro' ),
                'type'          => Controls_Manager::CHOOSE,
                'toggle'        => false,
                'options'       => [
                    'left' => [
                        'title'  => esc_html__( 'Left', 'exclusive-addons-elementor-pro' ),
                        'icon'   => 'eicon-h-align-left'
                    ],
                    'center'     => [
                        'title'  => esc_html__( 'Center', 'exclusive-addons-elementor-pro' ),
                        'icon'   => 'eicon-h-align-center'
                    ],
                    'right'   => [
                        'title'  => esc_html__( 'Right', 'exclusive-addons-elementor-pro' ),
                        'icon'   => 'eicon-h-align-right'
                    ]
                ],
                'default' => 'left',
				'selectors_dictionary' => [
					'left' => 'display: flex; flex-direction: column; align-items: flex-start; text-align: left; margin-right: auto',
					'center' => 'display: flex; flex-direction: column; align-items: center; text-align: center; margin-left: auto; margin-right: auto',
					'right' => 'display: flex; flex-direction: column; align-items: flex-end; text-align: right; margin-left: auto',
				],
                'selectors'     => [
                    '{{WRAPPER}} .exad-product-cross-sell .cross-sells .products .product .star-rating' => '{{VALUE}};'
                ]
            ]
        );


        $this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'exad_product_cross_sell_content_box_background',
				'types'    => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .exad-product-cross-sell .cross-sells .products .product'
			]
		);

		$this->add_responsive_control(
			'exad_product_cross_sell_content_box_padding',
			[
				'label'         => __( 'Padding', 'exclusive-addons-elementor-pro' ),
				'type'          => Controls_Manager::DIMENSIONS,
				'size_units'    => [ 'px', '%' ],
				'default'       => [
					'top'       => '0',
					'right'     => '0',
					'bottom'    => '0',
					'left'      => '0',
					'unit'      => 'px',
                    'isLinked'  => false
				],
				'selectors'     => [
					'{{WRAPPER}} .exad-product-cross-sell .cross-sells .products .product' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
		);

        $this->add_responsive_control(
			'exad_product_cross_sell_content_box_radius',
			[
				'label'      => __( 'Border Radius', 'exclusive-addons-elementor-pro' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'default'    => [
					'top'    => '0',
					'right'  => '0',
					'bottom' => '0',
					'left'   => '0',
					'unit'   => 'px'
				],
				'selectors'  => [
					'{{WRAPPER}} .exad-product-cross-sell .cross-sells .products .product' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'exad_product_cross_sell_content_box_border',
				'selector' => '{{WRAPPER}} .exad-product-cross-sell .cross-sells .products .product'
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'exad_product_cross_sell_content_box_box_shadow',
				'selector' => '{{WRAPPER}} .exad-product-cross-sell .cross-sells .products .product'
			]
		);

        $this->end_controls_section();

        /*
		* Cross-Sells Product Image Styling Section
		*/
		$this->start_controls_section(
            'exad_product_cross_sell_image_style',
            [
                'label'     => __( 'Image and Tags', 'exclusive-addons-elementor-pro' ),
                'tab'       => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_control(
            'exad_product_cross_sell_image_height',
            [
                'label'         => esc_html__('Image Height', 'exclusive-addons-elementor-pro' ),
                'type'          => Controls_Manager::SLIDER,
                'selectors'     => [
                    '{{WRAPPER}} .exad-product-cross-sell .cross-sells .products li a img' => 'height: {{SIZE}}{{UNIT}};'
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
            'exad_product_cross_sell_image_padding',
            [
                'label'         => esc_html__( 'Padding', 'exclusive-addons-elementor-pro' ),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => [ 'px', '%' ],
                'selectors'     => [
                    '{{WRAPPER}} .exad-product-cross-sell .cross-sells .products li a img' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ]
            ]
        );

        $this->add_control(
            'exad_product_cross_sell_image_overlay_color',
            [
                'label'     => esc_html__( 'Overlay', 'exclusive-addons-elementor-pro' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .exad-product-cross-sell .cross-sells .products li a.woocommerce-LoopProduct-link:before' => 'background-color: {{VALUE}};'
                ]
            ]
        );

        $this->add_control(
            'exad_product_cross_sell_image_hover_overlay_color',
            [
                'label'     => esc_html__( 'Hover Overlay', 'exclusive-addons-elementor-pro' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .exad-product-cross-sell .cross-sells .products li a.woocommerce-LoopProduct-link:hover:before' => 'background-color: {{VALUE}};'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'      => 'exad_product_cross_sell_image_border',
                'selector'  => '{{WRAPPER}} .exad-product-cross-sell .cross-sells .products li a img'
            ]
        );

        $this->add_responsive_control(
            'exad_product_cross_sell_image_border_radius',
            [
                'label'         => esc_html__( 'Border Radius', 'exclusive-addons-elementor-pro' ),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => [ 'px', '%' ],
                'selectors'     => [
                    '{{WRAPPER}} .exad-product-cross-sell .cross-sells .products li a img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .exad-product-cross-sell .cross-sells .products li a.woocommerce-LoopProduct-link:before' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'      => 'exad_product_cross_sell_image_box_shadow',
                'selector'  => '{{WRAPPER}} .exad-product-cross-sell .cross-sells .products li a img'        
            ]
        );

		$this->add_control(
            'exad_product_cross_sell_product_tag_style',
            [
                'label'         => esc_html__( 'Tags', 'exclusive-addons-elementor-pro' ),
                'type'          => Controls_Manager::HEADING,
                'separator'     => 'before'
            ]
        );

        $this->add_responsive_control(
            'exad_product_cross_sell_product_tag_position',
            [
                'label'         => esc_html__('Position(From Right Side)', 'exclusive-addons-elementor-pro' ),
                'type'          => Controls_Manager::SLIDER,
                'default'       => [
                    'size'      => 20,
                    'unit'      => 'px'
                ],  
                'selectors'     => [
                    '.woocommerce {{WRAPPER}} .exad-product-cross-sell .cross-sells .products li a span.onsale' => 'right: {{SIZE}}{{UNIT}};'
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
            'exad_product_cross_sell_product_tag_padding',
            [
                'label'         => esc_html__( 'Padding', 'exclusive-addons-elementor-pro' ),
                'type'          => Controls_Manager::DIMENSIONS,            
                'size_units'    => [ 'px', 'em', '%' ],
                'selectors'     => [
                        '.woocommerce {{WRAPPER}} .exad-product-cross-sell .cross-sells .products li a span.onsale' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->add_responsive_control(
            'exad_product_cross_sell_product_tag_border_radius',
            [
                'label'         => esc_html__( 'Border Radius', 'exclusive-addons-elementor-pro' ),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => [ 'px', '%' ],
                'selectors'     => [
                    '.woocommerce {{WRAPPER}} .exad-product-cross-sell .cross-sells .products li a span.onsale' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->add_control(
            'exad_product_cross_sell_product_sale_tag_style',
            [
                'label'         => esc_html__( 'Sale Tag', 'exclusive-addons-elementor-pro' ),
                'type'          => Controls_Manager::HEADING
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            array(
                'name'      => 'exad_product_cross_sell_product_sale_tag_typography',
                'label'     => __( 'Typography', 'exclusive-addons-elementor-pro' ),
                'selector'  => '.woocommerce {{WRAPPER}} .exad-product-cross-sell .cross-sells .products li a span.onsale',
            )
        );

        $this->add_control(
            'exad_product_cross_sell_product_sale_tag_color',
            [
                'label'     => esc_html__( 'Color', 'exclusive-addons-elementor-pro' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#ffffff',
                'selectors' => [
                    '.woocommerce {{WRAPPER}} .exad-product-cross-sell .cross-sells .products li a span.onsale' => 'color: {{VALUE}};'
                ]
            ]
        );

        $this->add_control(
            'exad_product_cross_sell_product_sale_tag_bg_color',
            [
                'label'     => esc_html__( 'Background Color', 'exclusive-addons-elementor-pro' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#3BC473',
                'selectors' => [
                    '.woocommerce {{WRAPPER}} .exad-product-cross-sell .cross-sells .products li a span.onsale' => 'background-color: {{VALUE}};'
                ]
            ]
        );

        $this->end_controls_section();

		/*
		*Cross-Sells product Title Styling Section
		*/
		$this->start_controls_section(
            'exad_product_cross_sell_product_title_style',
            [
                'label'     => __( 'Title', 'exclusive-addons-elementor-pro' ),
                'tab'       => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'exad_product_cross_sell_product_title_typography',
                'selector' => '{{WRAPPER}} .exad-product-cross-sell .cross-sells .products li a .woocommerce-loop-product__title'
            ]
        );

        $this->add_control(
            'exad_product_cross_sell_product_title_color',
            [
                'label'     => esc_html__( 'Color', 'exclusive-addons-elementor-pro' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#000000',
                'selectors' => [
                    '{{WRAPPER}} .exad-product-cross-sell .cross-sells .products li a .woocommerce-loop-product__title' => 'color: {{VALUE}};'
                ]
            ]
        );

        $this->add_responsive_control(
            'exad_product_cross_sell_product_title_margin',
            [
                'label'         => esc_html__( 'Margin', 'exclusive-addons-elementor-pro' ),
                'type'          => Controls_Manager::DIMENSIONS,            
                'size_units'    => [ 'px', 'em', '%' ],
                'selectors'     => [
                        '{{WRAPPER}} .exad-product-cross-sell .cross-sells .products li a .woocommerce-loop-product__title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->end_controls_section();

		/*
		* Before & After Cross-Sells Styling Section
		*/
		$this->start_controls_section(
            'exad_product_cross_sell_product_price_style',
            [
                'label'     => __( 'Price', 'exclusive-addons-elementor-pro' ),
                'tab'       => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'exad_product_cross_sell_product_price_typography',
                'selector' => '{{WRAPPER}} .exad-product-cross-sell .cross-sells .products li a .price'
            ]
        );

        $this->add_control(
            'exad_product_cross_sell_product_price_color',
            [
                'label'     => esc_html__( 'Color', 'exclusive-addons-elementor-pro' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#000000',
                'selectors' => [
                    '{{WRAPPER}} .exad-product-cross-sell .cross-sells .products li a .price' => 'color: {{VALUE}};'
                ]
            ]
        );

        $this->add_responsive_control(
            'exad_product_cross_sell_product_price_margin',
            [
                'label'         => esc_html__( 'Margin', 'exclusive-addons-elementor-pro' ),
                'type'          => Controls_Manager::DIMENSIONS,            
                'size_units'    => [ 'px', 'em', '%' ],
                'selectors'     => [
                        '{{WRAPPER}} .exad-product-cross-sell .cross-sells .products li a .price' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->end_controls_section();

		/*
		* Cross-Sells product star rating Styling Section
		*/
        $this->start_controls_section(
            'exad_product_cross_sell_product_star_rating_style',
            [
                'label'     => __( 'Star Rating', 'exclusive-addons-elementor-pro' ),
                'tab'       => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'exad_product_cross_sell_product_star_rating_font_size',
            [
                'label'         => esc_html__('Font Size', 'exclusive-addons-elementor-pro' ),
                'type'          => Controls_Manager::SLIDER,
                'default'       => [
                    'size'      => 18,
                    'unit'      => 'px'
                ],  
                'selectors'     => [
                    '{{WRAPPER}} .exad-product-cross-sell .cross-sells .products li a .star-rating' => 'font-size: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};'
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
            'exad_product_cross_sell_product_star_rating_color',
            [
                'label'         => esc_html__( 'Color', 'exclusive-addons-elementor-pro' ),
                'type'          => Controls_Manager::COLOR, 
                'default'       => '#3BC473',       
                'selectors'     => [
                    '{{WRAPPER}} .exad-product-cross-sell .cross-sells .products li a .star-rating:before' => 'color: {{VALUE}};',
                ],               
            ]
        );

		$this->add_control(
			'exad_product_cross_sell_product_star_rating_active_color',
			[
				'label'     => __( 'Color', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ff5b84',
				'selectors' => [
					'{{WRAPPER}} .exad-product-cross-sell .cross-sells .products li a .star-rating' => 'color: {{VALUE}};'
				]
			]
		);

        $this->add_responsive_control(
            'exad_product_cross_sell_product_star_rating_margin',
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
                    '{{WRAPPER}} .exad-product-cross-sell .cross-sells .products li a .star-rating' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->end_controls_section();

			
		/*
		* Cross-Sells product button Styling Section
		*/
		$this->start_controls_section(
            'exad_product_cross_sell_product_add_to_cart_btn_style',
            [
                'label'     => __( 'Button', 'exclusive-addons-elementor-pro' ),
                'tab'       => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'exad_product_cross_sell_product_add_to_cart_btn_typography',
                'selector' => '{{WRAPPER}} .exad-product-cross-sell .cross-sells .products li a.button'
            ]
        );

        $this->add_responsive_control(
            'exad_product_cross_sell_product_add_to_cart_btn_padding',
            [
                'label'         => esc_html__( 'Padding', 'exclusive-addons-elementor-pro' ),
                'type'          => Controls_Manager::DIMENSIONS,            
                'size_units'    => [ 'px', 'em', '%' ],
                'selectors'     => [
                        '{{WRAPPER}} .exad-product-cross-sell .cross-sells .products li a.button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->add_responsive_control(
            'exad_product_cross_sell_product_add_to_cart_btn_margin',
            [
                'label'         => esc_html__( 'Margin', 'exclusive-addons-elementor-pro' ),
                'type'          => Controls_Manager::DIMENSIONS,            
                'size_units'    => [ 'px', 'em', '%' ],
                'selectors'     => [
                        '{{WRAPPER}} .exad-product-cross-sell .cross-sells .products li a.button' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );


        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'      => 'exad_product_cross_sell_product_add_to_cart_btn_border',
                'selector'  => '{{WRAPPER}} .exad-product-cross-sell .cross-sells .products li a.button'
            ]
        );

        $this->add_responsive_control(
            'exad_product_cross_sell_product_add_to_cart_btn_border_radius',
            [
                'label'         => esc_html__( 'Border Radius', 'exclusive-addons-elementor-pro' ),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => [ 'px', '%' ],
                'selectors'     => [
                    '{{WRAPPER}} .exad-product-cross-sell .cross-sells .products li a.button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->start_controls_tabs( 'exad_product_cross_sell_product_add_to_cart_btn_tabs' );

            // Normal State Tab
            $this->start_controls_tab( 'exad_product_cross_sell_product_add_to_cart_btn_normal', [ 'label' => esc_html__( 'Normal', 'exclusive-addons-elementor-pro' ) ] );

            $this->add_control(
                'exad_product_cross_sell_product_add_to_cart_btn_normal_color',
                [
                    'label'     => esc_html__( 'Color', 'exclusive-addons-elementor-pro' ),
                    'type'      => Controls_Manager::COLOR,
                    'default'   => '#ffffff',
                    'selectors' => [
                        '{{WRAPPER}} .exad-product-cross-sell .cross-sells .products li a.button' => 'color: {{VALUE}};'
                    ]
                ]
            );

            $this->add_control(
                'exad_product_cross_sell_product_add_to_cart_btn_normal_bg_color',
                [
                    'label'     => esc_html__( 'Background Color', 'exclusive-addons-elementor-pro' ),
                    'type'      => Controls_Manager::COLOR,
                    'default'   => '#3BC473',
                    'selectors' => [
                        '{{WRAPPER}} .exad-product-cross-sell .cross-sells .products li a.button' => 'background-color: {{VALUE}};'
                    ]
                ]
            );

            $this->add_control(
                'exad_product_cross_sell_product_add_to_cart_btn_normal_border_color',
                [
                    'label'     => esc_html__( 'Border Color', 'exclusive-addons-elementor-pro' ),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .exad-product-cross-sell .cross-sells .products li a.button' => 'border-color: {{VALUE}};'
                    ]
                ]
            );

            $this->add_group_control(
                Group_Control_Box_Shadow::get_type(),
                [
                    'name'     => 'exad_product_cross_sell_product_add_to_cart_btn_normal_shadow',
                    'label'    => __( 'Box Shadow', 'exclusive-addons-elementor-pro' ),
                    'selector' => '{{WRAPPER}} .exad-product-cross-sell .cross-sells .products li a.button',
                ]
            );
            
            $this->end_controls_tab();

            // Hover State Tab
            $this->start_controls_tab( 'exad_product_cross_sell_product_add_to_cart_btn_hover', [ 'label' => esc_html__( 'Hover', 'exclusive-addons-elementor-pro' ) ] );

            $this->add_control(
                'exad_product_cross_sell_product_add_to_cart_btn_hover_color',
                [
                    'label'     => esc_html__( 'Color', 'exclusive-addons-elementor-pro' ),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .exad-product-cross-sell .cross-sells .products li a.button:hover' => 'color: {{VALUE}};'
                    ]
                ]
            );

            $this->add_control(
                'exad_product_cross_sell_product_add_to_cart_btn_hover_bg_color',
                [
                    'label'     => esc_html__( 'Background Color', 'exclusive-addons-elementor-pro' ),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .exad-product-cross-sell .cross-sells .products li a.button:hover' => 'background-color: {{VALUE}};'
                    ]
                ]
            );

            $this->add_control(
                'exad_product_cross_sell_product_add_to_cart_btn_hover_border_color',
                [
                    'label'     => esc_html__( 'Border Color', 'exclusive-addons-elementor-pro' ),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .exad-product-cross-sell .cross-sells .products li a.button:hover' => 'border-color: {{VALUE}};'
                    ]
                ]

            );

            $this->add_group_control(
                Group_Control_Box_Shadow::get_type(),
                [
                    'name'      => 'exad_product_cross_sell_product_add_to_cart_btn_hover_shadow',
                    'label'     => __( 'Box Shadow', 'exclusive-addons-elementor-pro' ),
                    'selector'  => '{{WRAPPER}} .exad-product-cross-sell .cross-sells .products li a.button:hover',
                ]
            );

            $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();

        /**
		 * Style Tab Arrows Style
		 */
		$this->start_controls_section(
            'exad_product_cross_sell_carousel_nav_arrow',
            [
                'label'     => esc_html__( 'Arrows', 'exclusive-addons-elementor-pro' ),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'exad_product_cross_sell_carousel_nav' => ['arrows', 'arrows-dots', 'arrows-fraction', 'arrows-progress-bar'],
                    'exad_product_cross_sell_content_setting_layout' => 'carousel-layout',
                ],
            ]
        );

        $this->add_responsive_control(
            'exad_product_cross_sell_carousel_nav_arrow_box_size',
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
                    '{{WRAPPER}} .exad-product-cross-sell .cross-sells .product-prev' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .exad-product-cross-sell .cross-sells .product-next' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'exad_product_cross_sell_carousel_nav_arrow_icon_size',
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
                    '{{WRAPPER}} .exad-product-cross-sell .cross-sells .product-prev svg' => 'font-size: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .exad-product-cross-sell .cross-sells .product-next svg' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        
        $this->add_control(
            'exad_product_cross_sell_carousel_prev_arrow_position',
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
                'exad_product_cross_sell_carousel_prev_arrow_position_x_offset',
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
                        'size' => -55,
                    ],
                    'selectors'  => [
                        '{{WRAPPER}} .exad-product-cross-sell .cross-sells .product-prev' => 'left: {{SIZE}}{{UNIT}};',
                    ],
                ]
            );

            $this->add_responsive_control(
                'exad_product_cross_sell_carousel_prev_arrow_position_y_offset',
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
                        '{{WRAPPER}} .exad-product-cross-sell .cross-sells .product-prev' => 'top: {{SIZE}}{{UNIT}};',
                    ],
                ]
            );

        $this->end_popover();

        $this->add_control(
            'exad_product_cross_sell_carousel_next_arrow_position',
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
                'exad_product_cross_sell_carousel_next_arrow_position_x_offset',
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
                        'size' => -55,
                    ],
                    'selectors'  => [
                        '{{WRAPPER}} .exad-product-cross-sell .cross-sells .product-next' => 'right: {{SIZE}}{{UNIT}};',
                    ],
                ]
            );

            $this->add_responsive_control(
                'exad_product_cross_sell_carousel_next_arrow_position_y_offset',
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
                        '{{WRAPPER}} .exad-product-cross-sell .cross-sells .product-next' => 'top: {{SIZE}}{{UNIT}};',
                    ],
                ]
            );

        $this->end_popover();

        $this->add_responsive_control(
            'exad_product_cross_sell_carousel_nav_arrow_radius',
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
                    '{{WRAPPER}} .exad-product-cross-sell .cross-sells .product-prev' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .exad-product-cross-sell .cross-sells .product-next' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs( 'exad_product_cross_sell_carousel_nav_arrow_tabs' );

			// normal state rating
			$this->start_controls_tab( 'exad_product_cross_sell_carousel_nav_arrow_normal', [ 'label' => esc_html__( 'Normal', 'exclusive-addons-elementor-pro' ) ] );

                $this->add_control(
                    'exad_product_cross_sell_carousel_arrow_normal_background',
                    [
                        'label'     => __( 'Background Color', 'exclusive-addons-elementor-pro' ),
                        'type'      => Controls_Manager::COLOR,
                        'default'   =>  $exad_primary_color,
                        'selectors' => [
                            '{{WRAPPER}} .exad-product-cross-sell .cross-sells .product-prev' => 'background: {{VALUE}}',
                            '{{WRAPPER}} .exad-product-cross-sell .cross-sells .product-next' => 'background: {{VALUE}}',
                        ],
                    ]
                );

                $this->add_control(
                    'exad_product_cross_sell_carousel_arrow_normal_color',
                    [
                        'label'     => __( 'Icon Color', 'exclusive-addons-elementor-pro' ),
                        'type'      => Controls_Manager::COLOR,
                        'default'   => '#ffffff',
                        'selectors' => [
                            '{{WRAPPER}} .exad-product-cross-sell .cross-sells .product-prev svg' => 'color: {{VALUE}};',
                            '{{WRAPPER}} .exad-product-cross-sell .cross-sells .product-next svg' => 'color: {{VALUE}};',
                        ],
                    ]
                );

                $this->add_group_control(
                    Group_Control_Border::get_type(),
                    [
                        'name'     => 'exad_product_cross_sell_carousel_arrow_normal_border',
                        'label'    => __( 'Border', 'exclusive-addons-elementor-pro' ),
                        'selector' => '{{WRAPPER}} .exad-product-cross-sell .cross-sells .product-prev, {{WRAPPER}} .exad-product-cross-sell .cross-sells .product-next',
                    ]
                );

                $this->add_group_control(
                    Group_Control_Box_Shadow::get_type(),
                    [
                        'name'     => 'exad_product_cross_sell_carousel_arrow_normal_shadow',
                        'label'    => __( 'Box Shadow', 'exclusive-addons-elementor-pro' ),
                        'selector' => '{{WRAPPER}} .exad-product-cross-sell .cross-sells .product-prev, {{WRAPPER}} .exad-product-cross-sell .cross-sells .product-next',
                    ]
                );

			$this->end_controls_tab();

			// hover state rating
			$this->start_controls_tab( 'exad_product_cross_sell_carousel_nav_arrow_hover', [ 'label' => esc_html__( 'Hover', 'exclusive-addons-elementor-pro' ) ] );

                $this->add_control(
                    'exad_product_cross_sell_carousel_arrow_hover_background',
                    [
                        'label'     => __( 'Background Color', 'exclusive-addons-elementor-pro' ),
                        'type'      => Controls_Manager::COLOR,
                        'default'   => $exad_primary_color,
                        'selectors' => [
                            '{{WRAPPER}} .exad-product-cross-sell .cross-sells .product-prev:hover' => 'background: {{VALUE}}',
                            '{{WRAPPER}} .exad-product-cross-sell .cross-sells .product-next:hover' => 'background: {{VALUE}}',
                        ],
                    ]
                );

                $this->add_control(
                    'exad_product_cross_sell_carousel_arrow_hover_color',
                    [
                        'label'     => __( 'Icon Color', 'exclusive-addons-elementor-pro' ),
                        'type'      => Controls_Manager::COLOR,
                        'default'   => '#ffffff',
                        'selectors' => [
                            '{{WRAPPER}} .exad-product-cross-sell .cross-sells .product-prev:hover svg' => 'color: {{VALUE}}',
                            '{{WRAPPER}} .exad-product-cross-sell .cross-sells .product-next:hover svg' => 'color: {{VALUE}}',
                        ],
                    ]
                );

                $this->add_group_control(
                    Group_Control_Border::get_type(),
                    [
                        'name'     => 'exad_product_cross_sell_carousel_arrow_hover_border',
                        'label'    => __( 'Border', 'exclusive-addons-elementor-pro' ),
                        'selector' => '{{WRAPPER}} .exad-product-cross-sell .cross-sells .product-prev:hover, {{WRAPPER}} .exad-product-cross-sell .cross-sells .product-next:hover',
                    ]
                );

                $this->add_group_control(
                    Group_Control_Box_Shadow::get_type(),
                    [
                        'name'     => 'exad_product_cross_sell_carousel_arrow_hover_shadow',
                        'label'    => __( 'Box Shadow', 'exclusive-addons-elementor-pro' ),
                        'selector' => '{{WRAPPER}} .exad-product-cross-sell .cross-sells .product-prev:hover, {{WRAPPER}} .exad-product-cross-sell .cross-sells .product-next:hover',
                    ]
                );

			$this->end_controls_tab();

        $this->end_controls_tabs();

		$this->end_controls_section();

		/**
		* Style Tab Dots Style
		*/
		$this->start_controls_section(
            'exad_product_cross_sell_carousel_nav_dot',
            [
                'label'     => esc_html__( 'Dots', 'exclusive-addons-elementor-pro' ),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'exad_product_cross_sell_carousel_nav' => ['nav-dots', 'arrows-dots'],
                    'exad_product_cross_sell_content_setting_layout' => 'carousel-layout',
                ],
            ]
        );

        $this->add_responsive_control(
            'exad_product_tabs_control_item_cexad_product_cross_sell_carousel_nav_dot_alignmentontrol_item_alignment',
            [
                'label'         => esc_html__('Dots Alignment', 'exclusive-addons-elementor-pro'),
                'type'          => Controls_Manager::CHOOSE,
                'toggle'        => false,
                'label_block'   => true,
                'default'       => 'center',
                'options'       => [
                    'left'      => [
                        'title' => esc_html__('Left', 'exclusive-addons-elementor-pro'),
                        'icon'  => 'eicon-text-align-left'
                    ],
                    'center'    => [
                        'title' => esc_html__('Center', 'exclusive-addons-elementor-pro'),
                        'icon'  => 'eicon-text-align-center'
                    ],
                    'right'     => [
                        'title' => esc_html__('Right', 'exclusive-addons-elementor-pro'),
                        'icon'  => 'eicon-text-align-right'
                    ],
                ],
				'selectors_dictionary' => [
                    'left'      => 'text-align: left; display: flex; justify-content: flex-start; margin-right: auto;',
					'center'    => 'text-align: center; display: flex; justify-content: center; margin-left: auto; margin-right: auto;',
					'right'     => 'text-align: right; display: flex; justify-content: flex-end; margin-left: auto;',
                ],
                'selectors'     => [
                    '{{WRAPPER}} .exad-product-cross-sell .exad-dots-container' => '{{VALUE}};'
                ]
            ]
        );      

        $this->add_responsive_control(
            'exad_product_cross_sell_carousel_dots_top_spacing',
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
                    '{{WRAPPER}} .exad-product-cross-sell .exad-swiper-pagination' => 'margin-top: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

		$this->add_responsive_control(
			'exad_product_cross_sell_carousel_dots_spacing_btwn',
			[
				'label' => __( 'Space Between', 'exclusive-addons-elementor-pro' ),
				'type'  => Controls_Manager::SLIDER,
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
                    'exad_product_cross_sell_carousel_nav' => ['nav-dots', 'arrows-dots'],
                ],
				'selectors' => [
					'{{WRAPPER}} .exad-product-cross-sell .exad-swiper-pagination .swiper-pagination-bullet:not(:last-child)' => 'margin-right: {{SIZE}}{{UNIT}};',
				]
			]
		);

        $this->add_responsive_control(
            'exad_product_cross_sell_carousel_nav_dot_radius',
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
                    '{{WRAPPER}} .exad-product-cross-sell .exad-swiper-pagination .swiper-pagination-bullet' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs( 'exad_product_cross_sell_carousel_nav_dots_tabs' );

			// normal state rating
            $this->start_controls_tab( 'exad_product_cross_sell_carousel_nav_dots_normal', [ 'label' => esc_html__( 'Normal', 'exclusive-addons-elementor-pro' ) ] );

                $this->add_responsive_control(
                    'exad_product_cross_sell_carousel_dots_normal_height',
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
                            '{{WRAPPER}} .exad-product-cross-sell .exad-swiper-pagination .swiper-pagination-bullet' => 'height: {{SIZE}}{{UNIT}};',
                        ],
                    ]
                );

				$this->add_responsive_control(
                    'exad_product_cross_sell_carousel_dots_normal_width',
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
                            '{{WRAPPER}} .exad-product-cross-sell .exad-swiper-pagination .swiper-pagination-bullet' => 'width: {{SIZE}}{{UNIT}};',
                        ],
                    ]
                );

                $this->add_control(
                    'exad_product_cross_sell_carousel_dots_normal_background',
                    [
                        'label'     => __( 'Background Color', 'exclusive-addons-elementor-pro' ),
                        'type'      => Controls_Manager::COLOR,
                        'default'   => '#e5e5e5',
                        'selectors' => [
                            '{{WRAPPER}} .exad-product-cross-sell .exad-swiper-pagination .swiper-pagination-bullet' => 'background: {{VALUE}};',
                        ],
                    ]
                );
				
				$this->add_responsive_control(
                    'exad_product_cross_sell_carousel_dots_normal_opacity',
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
                            '{{WRAPPER}} .exad-product-cross-sell .exad-swiper-pagination .swiper-pagination-bullet' => 'opacity: {{SIZE}};',
                        ],
                    ]
                );

                $this->add_group_control(
                    Group_Control_Border::get_type(),
                    [
                        'name'     => 'exad_product_cross_sell_carousel_dots_normal_border',
                        'label'    => __( 'Border', 'exclusive-addons-elementor-pro' ),
                        'selector' => '{{WRAPPER}} .exad-product-cross-sell .exad-swiper-pagination .swiper-pagination-bullet , {{WRAPPER}} .exad-product-cross-sell .exad-swiper-pagination .swiper-pagination-bullet:hover',
                    ]
                );

			$this->end_controls_tab();

			// hover state rating
            $this->start_controls_tab( 'exad_product_cross_sell_carousel_nav_dots_hover', [ 'label' => esc_html__( 'Hover/active', 'exclusive-addons-elementor-pro' ) ] );
            
                $this->add_responsive_control(
                    'exad_product_cross_sell_carousel_dots_active_height',
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
                            '{{WRAPPER}} .exad-product-cross-sell .exad-swiper-pagination .swiper-pagination-bullet-active' => 'height: {{SIZE}}{{UNIT}};',
                        ],
                    ]
                );

				$this->add_responsive_control(
                    'exad_product_cross_sell_carousel_dots_active_width',
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
                            '{{WRAPPER}} .exad-product-cross-sell .exad-swiper-pagination .swiper-pagination-bullet-active' => 'width: {{SIZE}}{{UNIT}};',
                        ],
                    ]
                );

                $this->add_control(
                    'exad_product_cross_sell_carousel_dots_active_background',
                    [
                        'label'     => __( 'Background Color', 'exclusive-addons-elementor-pro' ),
                        'type'      => Controls_Manager::COLOR,
                        'default'   => $exad_primary_color,
                        'selectors' => [
                            '{{WRAPPER}} .exad-product-cross-sell .exad-swiper-pagination .swiper-pagination-bullet-active' => 'background: {{VALUE}};',
                            '{{WRAPPER}} .exad-product-cross-sell .exad-swiper-pagination .swiper-pagination-bullet:hover' => 'background: {{VALUE}};',
                        ],
                    ]
                );

				$this->add_responsive_control(
                    'exad_product_cross_sell_carousel_dots_hover_opacity',
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
							'{{WRAPPER}} .exad-product-cross-sell .exad-swiper-pagination .swiper-pagination-bullet-active' => 'opacity: {{SIZE}};',
                            '{{WRAPPER}} .exad-product-cross-sell .exad-swiper-pagination .swiper-pagination-bullet:hover' => 'opacity: {{SIZE}};',
                        ],
                    ]
                );

                $this->add_group_control(
                    Group_Control_Border::get_type(),
                    [
                        'name'     => 'exad_product_cross_sell_carousel_dots_active_border',
                        'label'    => __( 'Border', 'exclusive-addons-elementor-pro' ),
                        'selector' => '{{WRAPPER}} .exad-product-cross-sell .exad-swiper-pagination .swiper-pagination-bullet-active, {{WRAPPER}} .exad-product-cross-sell .exad-swiper-pagination .swiper-pagination-bullet:hover',
                    ]
                );

			$this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();

        /**
		* Style Tab Fraction Style
		*/
		$this->start_controls_section(
            'exad_product_cross_sell_carousel_nav_fraction',
            [
                'label'     => esc_html__( 'Fraction', 'exclusive-addons-elementor-pro' ),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'exad_product_cross_sell_carousel_nav' => ['fraction', 'arrows-fraction'],
                    'exad_product_cross_sell_content_setting_layout' => 'carousel-layout',
                ],
            ]
        );

        $this->add_control(
            'exad_product_cross_sell_carousel_nav_fraction_alignment',
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
            'exad_product_cross_sell_carousel_fraction_top_spacing',
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
                    '{{WRAPPER}} .exad-product-cross-sell .exad-swiper-pagination' => 'margin-top: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
			'exad_product_cross_sell_carousel_fraction_spacing_btwn',
			[
				'label' => __( 'Space Between', 'exclusive-addons-elementor-pro' ),
				'type'  => Controls_Manager::SLIDER,
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
					'{{WRAPPER}} .exad-product-cross-sell .exad-swiper-pagination.swiper-pagination-fraction .swiper-pagination-current' => 'margin-right: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .exad-product-cross-sell .exad-swiper-pagination.swiper-pagination-fraction .swiper-pagination-total' => 'margin-left: {{SIZE}}{{UNIT}};',
				]
			]
		);

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'exad_product_cross_sell_carousel_swiper-pagination_fraction_typography',
                'selector' => '{{WRAPPER}} .exad-product-cross-sell .exad-swiper-pagination.swiper-pagination-fraction *',
            ]
        );

        $this->add_responsive_control(
            'exad_product_cross_sell_carousel_nav_fraction_radius',
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
                    '{{WRAPPER}} .exad-product-cross-sell .exad-swiper-pagination.swiper-pagination-fraction span' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs( 'exad_product_cross_sell_carousel_nav_fraction_tabs' );
        // normal state rating

            $this->start_controls_tab( 'exad_product_cross_sell_carousel_nav_fraction_normal', [ 'label' => esc_html__( 'Normal', 'exclusive-addons-elementor-pro' ) ] );
                $this->add_responsive_control(
                    'exad_product_cross_sell_carousel_fraction_normal_height',
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
                            '{{WRAPPER}} .exad-product-cross-sell .exad-swiper-pagination.swiper-pagination-fraction .swiper-pagination-total' => 'height: {{SIZE}}{{UNIT}};',
                            '{{WRAPPER}} .exad-product-cross-sell .exad-swiper-pagination.swiper-pagination-fraction .swiper-pagination-total' => 'line-height: {{SIZE}}{{UNIT}};',
                        ],
                    ]
                );

                $this->add_responsive_control(
                    'exad_product_cross_sell_carousel_fraction_normal_width',
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
                            '{{WRAPPER}} .exad-product-cross-sell .exad-swiper-pagination.swiper-pagination-fraction .swiper-pagination-total' => 'width: {{SIZE}}{{UNIT}};',
                        ],
                    ]
                );

                $this->add_control(
                    'exad_product_cross_sell_carousel_pagination_fraction_color',
                    [
                        'label'     => esc_html__( 'Color', 'exclusive-addons-elementor-pro' ),
                        'type'      => Controls_Manager::COLOR,
                        'default'   => '#000000',
                        'selectors' => [
                            '{{WRAPPER}} .exad-product-cross-sell .exad-swiper-pagination.swiper-pagination-fraction .swiper-pagination-total' => 'color: {{VALUE}};'
                        ]
                    ]
                );      
                
                $this->add_control(
                    'exad_product_cross_sell_carousel_fraction_normal_background',
                    [
                        'label'     => __( 'Background Color', 'exclusive-addons-elementor-pro' ),
                        'type'      => Controls_Manager::COLOR,
                        'default'   => '#e5e5e5',
                        'selectors' => [
                            '{{WRAPPER}} .exad-product-cross-sell .exad-swiper-pagination.swiper-pagination-fraction .swiper-pagination-total' => 'background: {{VALUE}};',
                        ],
                    ]
                );
                
                $this->add_group_control(
                    Group_Control_Border::get_type(),
                    [
                        'name'     => 'exad_product_cross_sell_carousel_fraction_normal_border',
                        'label'    => __( 'Border', 'exclusive-addons-elementor-pro' ),
                        'selector' => '{{WRAPPER}} .exad-product-cross-sell .exad-swiper-pagination.swiper-pagination-fraction .swiper-pagination-total',
                    ]
                );
            $this->end_controls_tab();

            // hover state rating
            $this->start_controls_tab( 'exad_product_cross_sell_carousel_nav_fraction_hover', [ 'label' => esc_html__( 'Hover/active', 'exclusive-addons-elementor-pro' ) ] );
            
                $this->add_responsive_control(
                    'exad_product_cross_sell_carousel_fraction_active_height',
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
                            '{{WRAPPER}} .exad-product-cross-sell .exad-swiper-pagination.swiper-pagination-fraction .swiper-pagination-current' => 'height: {{SIZE}}{{UNIT}};',
                            '{{WRAPPER}} .exad-product-cross-sell .exad-swiper-pagination.swiper-pagination-fraction .swiper-pagination-current' => 'line-height: {{SIZE}}{{UNIT}};',
                        ],
                    ]
                );

				$this->add_responsive_control(
                    'exad_product_cross_sell_carousel_fraction_active_width',
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
                            '{{WRAPPER}} .exad-product-cross-sell .exad-swiper-pagination.swiper-pagination-fraction .swiper-pagination-current' => 'width: {{SIZE}}{{UNIT}};',
                        ],
                    ]
                );

                $this->add_control(
                    'exad_product_cross_sell_carousel_pagination_fraction_current_color',
                    [
                        'label'     => esc_html__( 'Color', 'exclusive-addons-elementor-pro' ),
                        'type'      => Controls_Manager::COLOR,
                        'default'   => '#fff',
                        'selectors' => [
                            '{{WRAPPER}} .exad-product-cross-sell .exad-swiper-pagination.swiper-pagination-fraction .swiper-pagination-current' => 'color: {{VALUE}};'
                        ]
                    ]
                );     

                $this->add_control(
                    'exad_product_cross_sell_carousel_fraction_active_background',
                    [
                        'label'     => __( 'Background Color', 'exclusive-addons-elementor-pro' ),
                        'type'      => Controls_Manager::COLOR,
                        'default'   => $exad_primary_color,
                        'selectors' => [
                            '{{WRAPPER}} .exad-product-cross-sell .exad-swiper-pagination.swiper-pagination-fraction .swiper-pagination-current:hover' => 'background: {{VALUE}};',
                            '{{WRAPPER}} .exad-product-cross-sell .exad-swiper-pagination.swiper-pagination-fraction .swiper-pagination-current' => 'background: {{VALUE}};',
                        ],
                    ]
                );

                $this->add_group_control(
                    Group_Control_Border::get_type(),
                    [
                        'name'     => 'exad_product_cross_sell_carousel_fraction_active_border',
                        'label'    => __( 'Border', 'exclusive-addons-elementor-pro' ),
                        'selector' => '{{WRAPPER}} .exad-product-cross-sell .exad-swiper-pagination.swiper-pagination-fraction .swiper-pagination-current',
                    ]
                );

			$this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

	    /**
		* Style Tab progressbar Style
		*/
		$this->start_controls_section(
            'exad_product_cross_sell_carousel_nav_progressbar',
            [
                'label'     => esc_html__( 'Progress Bar', 'exclusive-addons-elementor-pro' ),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'exad_product_cross_sell_carousel_nav' => ['progress-bar', 'arrows-progress-bar'],
                    'exad_product_cross_sell_content_setting_layout' => 'carousel-layout',
                ],
            ]
        );

        $this->add_control(
            'exad_product_cross_sell_carousel_nav_progressbar_normal_color',
            [
                'label'     => __( 'Normal Color', 'exclusive-addons-elementor-pro' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#e5e5e5',
                'selectors' => [
                    '{{WRAPPER}} .exad-product-cross-sell .exad-dots-container .exad-swiper-pagination.swiper-pagination.swiper-pagination-progressbar' => 'background: {{VALUE}};',
                ],
            ]
        );
        
        $this->add_control(
            'exad_product_cross_sell_carousel_nav_progressbar_active_color',
            [
                'label'     => __( 'Active Color', 'exclusive-addons-elementor-pro' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => $exad_primary_color,
                'separator' => "after",
                'selectors' => [
                    '{{WRAPPER}} .exad-product-cross-sell .exad-dots-container .exad-swiper-pagination.swiper-pagination.swiper-pagination-progressbar .swiper-pagination-progressbar-fill' => 'background: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
			'exad_product_cross_sell_carousel_nav_Progress_position',
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
			'exad_product_cross_sell_carousel_nav_Progress_specing',
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
            'exad_product_cross_sell_carousel_nav_progressbar_height',
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
                    '{{WRAPPER}} .exad-product-cross-sell .exad-dots-container .exad-swiper-pagination.swiper-pagination.swiper-pagination-progressbar' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

		/*
		* Before & After Cross-Sells Styling Section
		*/
		$this->start_controls_section(
            'exad_product_cross_sell_before_after_style_section',
            [
                'label' => esc_html__( 'Before & After Style', 'exclusive-addons-elementor-pro' ),
				'tab'   => Controls_Manager::TAB_STYLE
            ]
        );

		$this->add_control(
			'exad_product_cross_sell_before_style',
			[
				'label'     => __( 'Before Cross Sells', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before'
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'exad_product_cross_sell_before_typography',
				'selector' => '{{WRAPPER}} .exad-product-cross-sell .product-cross-sells-before',
			]
		);

		$this->add_control(
			'exad_product_cross_sell_before_color',
			[
				'label'     => __( 'Color', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#333333',
				'selectors' => [
					'{{WRAPPER}} .exad-product-cross-sell .product-cross-sells-before' => 'color: {{VALUE}};'
				]
			]
		);

		$this->add_responsive_control(
			'exad_product_cross_sell_before_margin',
			[
				'label'      => __( 'Margin', 'exclusive-addons-elementor-pro' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'default'    => [
					'top'    => '0',
					'right'  => '0',
					'bottom' => '0',
					'left'   => '0',
                    'isLinked' => false
				],
				'selectors'  => [
					'{{WRAPPER}} .exad-product-cross-sell .product-cross-sells-before' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
		);

        $this->add_control(
			'exad_product_cross_sell_after_style',
			[
				'label'     => __( 'After Cross Sells', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before'
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'exad_product_cross_sell_after_typography',
				'selector'  => '{{WRAPPER}} .exad-product-cross-sell .product-cross-sells-after',
			]
		);

		$this->add_control(
			'exad_product_cross_sell_after_color',
			[
				'label'     => __( 'Color', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#333333',
				'selectors' => [
					'{{WRAPPER}} .exad-product-cross-sell .product-cross-sells-after' => 'color: {{VALUE}};'
				]
			]
		);

		$this->add_responsive_control(
			'exad_product_cross_sell_after_margin',
			[
				'label'      => __( 'Margin', 'exclusive-addons-elementor-pro' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'default'    => [
					'top'    => '0',
					'right'  => '0',
					'bottom' => '0',
					'left'   => '0',
                    'isLinked' => false
				],
				'selectors'  => [
					'{{WRAPPER}} .exad-product-cross-sell .product-cross-sells-after' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
		);
		$this-> end_controls_section();
    }

    // define the woocommerce_product_upsells_products_heading callback 
    public function exad_woocommerce_cross_sell_products_heading( $title ){ 
        $settings = $this->get_settings();
        $title = $settings['exad_product_cross_sell_section_title_text'];
        return $title ;
    }
    
    protected function render() {
        if( ! class_exists('woocommerce') ) {
            return;
        }

        $settings = $this->get_settings_for_display();
        
		$product_per_page   = '-1';
        $columns            = 4;
        $orderby            = 'rand';
        $order              = 'desc';
        if ( ! empty( $settings['exad_cross_sell_columns'] ) ) {
            $columns = $settings['exad_cross_sell_columns'];
        }
        if ( ! empty( $settings['exad_cross_sell_orderby'] ) ) {
            $orderby = $settings['exad_cross_sell_orderby'];
        }
        if ( ! empty( $settings['exad_cross_sell_order'] ) ) {
            $order = $settings['exad_cross_sell_order'];
        } 
        if ( ! empty( $settings['exad_product_cross_sell_posts_per_page'] ) ) {
            $order = $settings['exad_product_cross_sell_posts_per_page'];
        }

        if ( "carousel-layout" == $settings['exad_product_cross_sell_content_setting_layout'] ) {

             // Carousel Settings
             $elementor_viewport_lg = get_option( 'elementor_viewport_lg' );
             $elementor_viewport_md = get_option( 'elementor_viewport_md' );
             $exad_viewport_lg     = !empty($elementor_viewport_lg) ? $elementor_viewport_lg - 1 : 1023;
             $exad_viewport_md     = !empty($elementor_viewport_md) ? $elementor_viewport_md - 1 : 767;
     
             if ( 'nav-dots' == $settings['exad_product_cross_sell_carousel_nav'] || 'arrows-dots' == $settings['exad_product_cross_sell_carousel_nav'] ) {
                 $swiper_pagination_type = 'bullets';
             } elseif ( 'fraction' == $settings['exad_product_cross_sell_carousel_nav'] || 'arrows-fraction' == $settings['exad_product_cross_sell_carousel_nav'] ) {
                 $swiper_pagination_type = 'fraction';
             } elseif ( 'progress-bar' == $settings['exad_product_cross_sell_carousel_nav'] || 'arrows-progress-bar' == $settings['exad_product_cross_sell_carousel_nav'] ) {
                 $swiper_pagination_type = 'progressbar';
             } else {
                 $swiper_pagination_type = '';
             }

            $carousel_data_settings = wp_json_encode(
                array_filter([
                    "autoplay"           	=> $settings["exad_product_cross_sell_carousel_autoplay"] ? true : false,
                    "delay" 				=> $settings["exad_product_cross_sell_carousel_autoplay_speed"] ? true : false,
                    "loop"           		=> $settings["exad_product_cross_sell_carousel_loop"] ? true : false,
                    "speed"       			=> $settings["exad_product_cross_sell_carousel_transition_duration"],
                    "pauseOnHover"       	=> $settings["exad_product_cross_sell_carousel_pause"] ? true : false,
                    "slidesPerView"         => isset($settings["slider_per_view_mobile"]) ? (int)$settings["slider_per_view_mobile"] : 1,
                    "slidesPerColumn" 		=> ($settings["exad_product_cross_sell_carousel_slides_per_column"] > 1) ? $settings["exad_product_cross_sell_carousel_slides_per_column"] : false,
                    "centeredSlides"        => $settings["exad_product_cross_sell_carousel_slide_centered"] ? true : false,
                    "spaceBetween"   		=> $settings['exad_product_cross_sell_carousel_column_space']['size'],
                    "grabCursor"  			=> ($settings["exad_product_cross_sell_carousel_grab_cursor"] === "yes") ? true : false,
                    "observer"       		=> ($settings["exad_product_cross_sell_carousel_observer"]) ? true : false,
                    "observeParents" 		=> ($settings["exad_product_cross_sell_carousel_observer"]) ? true : false,
                    "breakpoints"     		=> [
    
                        (int) $exad_viewport_md 	=> [
                            "slidesPerView" 	=> isset($settings["slider_per_view_tablet"]) ? (int)$settings["slider_per_view_tablet"] : 2,
                            "spaceBetween"  	=> $settings["exad_product_cross_sell_carousel_column_space"]["size"],
                            "centeredSlides" => $settings["exad_product_cross_sell_carousel_slide_centered"] ? true : false,
                        ],
                        (int) $exad_viewport_lg 	=> [
                            "slidesPerView" 	=> (int)$settings["slider_per_view"],
                            "spaceBetween"  	=> $settings["exad_product_cross_sell_carousel_column_space"]["size"],
                            "centeredSlides" => $settings["exad_product_cross_sell_carousel_slide_centered"] ? false : true,
                        ]
                    ],
                    "pagination" 			 	=>  [ 
                        "el" 				=> ".exad-swiper-pagination",
                        "type"       		=> $swiper_pagination_type,
                        "clickable"  		=> true,
                    ],
                    "navigation" => [
                        "nextEl" => ".product-next",
                        "prevEl" => ".product-prev",
                    ],
    
                ])
            );
            
        $this->add_render_attribute( '_wrapper', 'class', esc_attr( $settings['exad_product_cross_sell_carousel_nav_fraction_alignment'] ) );
        if ( 'progress-bar' == $settings['exad_product_cross_sell_carousel_nav'] || 'arrows-progress-bar' == $settings['exad_product_cross_sell_carousel_nav']) {
            $this->add_render_attribute( '_wrapper', 'class', esc_attr( $settings['exad_product_cross_sell_carousel_nav_Progress_position'] ) );
        }

         $this->add_render_attribute( '_wrapper', 'data-carousel',  $carousel_data_settings );

        }
        // Carousel Settings end
        ?>

        <div class="exad-product-cross-sell">

            <?php do_action( 'exad_woo_builder_widget_product_cross_sells_before_render' ); ?>

                <?php if ( ! empty( $settings['exad_product_cross_sell_before'] ) ) : ?>
                    <p class="product-cross-sells-before" ><?php echo wp_kses_post( $settings['exad_product_cross_sell_before'] );?></p>
                <?php endif; ?>

                <?php 
                    global $product;

                    $product = wc_get_product();

                    if ( \Elementor\Plugin::instance()->editor->is_edit_mode() ) {
                        add_filter('woocommerce_product_cross_sells_products_heading', [ $this, 'exad_woocommerce_cross_sell_products_heading'], 10, 1);
                         echo '<p>'.esc_html__( 'No cross-sale products are available.','exclusive-addons-elementor-pro' ).'</p>';
                    } else {
                        add_filter('woocommerce_product_cross_sells_products_heading', [ $this, 'exad_woocommerce_cross_sell_products_heading'], 10, 1);
                        woocommerce_cross_sell_display( $product_per_page, $columns, $orderby, $order );
                    }
                ?>

                <?php if ( ! empty( $settings['exad_product_cross_sell_after'] ) ) : ?>
                    <p class="product-cross-sells-after" ><?php echo wp_kses_post( $settings['exad_product_cross_sell_after'] );?></p>
                <?php endif; ?>	

            <?php do_action( 'exad_woo_builder_widget_product_cross_sell_after_render' ); ?>

        </div>

        <?php
    }
}