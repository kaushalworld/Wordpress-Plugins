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
use \Elementor\Icons_Manager;

class Woo_Cart extends Widget_Base {

	public function get_name() {
		return 'exad-woo-cart';
	}

	public function get_title() {
		return esc_html__( 'Woo Cart', 'exclusive-addons-elementor-pro' );
	}

	public function get_icon() {
		return 'exad exad-logo exad-woo-cart';
	}

	public function get_categories() {
		return [ 'exclusive-addons-elementor' ];
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
		 * Content Section
		 */

        $this->start_controls_section(
            'exad_woo_content_section',
            [
                'label' => esc_html__( 'Content', 'exclusive-addons-elementor-pro' ),
            ]
		);
		
		$this->add_control(
			'exad_woo_content_layout',
			[
				'label' => __( 'Layout', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'exad-cart-layout-1',
				'options' => [
					'exad-cart-layout-1'  => __( 'Layout 1', 'exclusive-addons-elementor-pro' ),
					'exad-cart-layout-2'  => __( 'Layout 2', 'exclusive-addons-elementor-pro' ),
				],
			]
		);

		$this->add_control(
            'exad_woo_cross_sell_display',
            [
				'label'        => esc_html__( 'Show Cross Sell', 'exclusive-addons-elementor-pro' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'exclusive-addons-elementor-pro' ),
				'label_off' => __( 'Hide', 'exclusive-addons-elementor-pro' ),
				'return_value' => 'yes',
				'default' => 'yes',
            ]
        );

		$this->end_controls_section();

		
		/**
		 * Cross sell setting Section
		 */

        $this->start_controls_section(
            'exad_woo_cross_sell_settings_style_section',
            [
				'label' => esc_html__( 'Cross Sell Settings', 'exclusive-addons-elementor-pro' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
				'condition' => [
                    'exad_woo_cross_sell_display' => 'yes'
                ]
            ]
		);

		$this->add_control(
            'exad_woo_cross_sell_content_setting_layout',
            [
				'label'   => __( 'Layout', 'exclusive-addons-elementor-pro' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'grid-layout',
				'prefix_class' => 'exad-cart-cross-sell-',
				'condition' => [
                    'exad_woo_cross_sell_display' => 'yes',
                ],
				'options' => [
					'grid-layout' 		=> esc_html__( 'Grid Layout', 'exclusive-addons-elementor-pro' ),
					'carousel-layout' 	=> esc_html__( 'Carousel Layout', 'exclusive-addons-elementor-pro' ),
				]
            ]
		);

		$this->add_responsive_control(
			'exad_cross_sell_columns',
			[
				'label' => __( 'Columns', 'exclusive-addons-elementor-pro' ),
				'type'  => Controls_Manager::NUMBER,
				'prefix_class' => 'exad-cross-sell-columns%s-',
				'default' => 2,
				'min' => 1,
				'max' => 6,
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
                    'exad_woo_cross_sell_content_setting_layout' => 'carousel-layout',
                ],
            ]
		);

		$slides_per_view = range( 1, 6 );
		$slides_per_view = array_combine( $slides_per_view, $slides_per_view );

		$this->add_control(
            'exad_cross_sell_carousel_nav',
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
			'exad_cross_sell_carousel_slider_per_view',
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
			'exad_cross_sell_carousel_column_space',
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
			'exad_cross_sell_carousel_slides_to_scroll',
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
			'exad_cross_sell_carousel_slides_per_column',
			[
				'type'      => Controls_Manager::SELECT,
				'label'     => esc_html__( 'Slides Per Column', 'exclusive-addons-elementor-pro' ),
				'options'   => $slides_per_view,
				'default'   => '1',
			]
		);
		
		$this->add_control(
			'exad_cross_sell_carousel_transition_duration',
			[
				'label'   => esc_html__( 'Transition Duration', 'exclusive-addons-elementor-pro' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 1000
			]
		);

		$this->add_control(
			'exad_cross_sell_carousel_autoheight',
			[
				'label'     => esc_html__( 'Auto Height', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::SWITCHER,
				'default'   => 'yes'
			]
		);

		$this->add_control(
			'exad_cross_sell_carousel_autoplay',
			[
				'label'     => esc_html__( 'Autoplay', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::SWITCHER,
				'default'   => 'yes'
			]
		);

		$this->add_control(
			'exad_cross_sell_carousel_autoplay_speed',
			[
				'label'     => esc_html__( 'Autoplay Speed', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 5000,
				'condition' => [
					'exad_cross_sell_carousel_autoplay' => 'yes'
				]
			]
		);

		$this->add_control(
			'exad_cross_sell_carousel_loop',
			[
				'label'   => esc_html__( 'Infinite Loop', 'exclusive-addons-elementor-pro' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes'
			]
		);

		$this->add_control(
			'exad_cross_sell_carousel_pause',
			[
				'label'     => esc_html__( 'Pause on Hover', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::SWITCHER,
				'default'   => 'yes',
				'condition' => [
					'exad_cross_sell_carousel_autoplay' => 'yes'
				]
			]
		);

		$this->add_control(
			'exad_cross_sell_carousel_slide_centered',
			[
				'label'       => esc_html__( 'Centered Mode Slide', 'exclusive-addons-elementor-pro' ),
				'type'        => Controls_Manager::SWITCHER,
				'default'     => 'no',
			]
		);
		
		$this->add_control(
			'exad_cross_sell_carousel_grab_cursor',
			[
				'label'       => esc_html__( 'Grab Cursor', 'exclusive-addons-elementor-pro' ),
				'type'        => Controls_Manager::SWITCHER,
				'default'     => 'no',
			]
		);

		$this->add_control(
			'exad_cross_sell_carousel_observer',
			[
				'label'       => esc_html__( 'Observer', 'exclusive-addons-elementor-pro' ),
				'type'        => Controls_Manager::SWITCHER,
				'default'     => 'no',
			]
		);

		$this->end_controls_section();

		/**
		 * Container Section
		 */

        $this->start_controls_section(
            'exad_woo_cart_style_section',
            [
				'label' => esc_html__( 'Container', 'exclusive-addons-elementor-pro' ),
				'tab'   => Controls_Manager::TAB_STYLE
            ]
		);

		$this->add_responsive_control(
			'exad_woo_cart_container_padding',
			[
				'label' => __( 'Padding', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .exad-woo-cart' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'exad_woo_cart_container_background',
				'label' => __( 'Background', 'exclusive-addons-elementor-pro' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .exad-woo-cart',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'exad_woo_cart_container_border',
				'label' => __( 'Border', 'exclusive-addons-elementor-pro' ),
				'selector' => '{{WRAPPER}} .exad-woo-cart',
			]
		);

		$this->add_responsive_control(
			'exad_woo_cart_container_border_radius',
			[
				'label' => __( 'Border Radius', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .exad-woo-cart' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'exad_woo_cart_container_box_shadow',
				'label' => __( 'Box Shadow', 'exclusive-addons-elementor-pro' ),
				'selector' => '{{WRAPPER}} .exad-woo-cart',
			]
		);

		$this->end_controls_section();

		/**
		 * Cart Table Section
		 */

        $this->start_controls_section(
            'exad_woo_cart_product_table_section',
            [
				'label' => esc_html__( 'Cart Table', 'exclusive-addons-elementor-pro' ),
				'tab'   => Controls_Manager::TAB_STYLE
            ]
		);

		$this->add_responsive_control(
			'exad_woo_cart_product_table_width',
			[
				'label' => __( 'Cart Table Width', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ '%' ],
				'range' => [
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default' => [
					'unit' => '%',
					'size' => 70,
				],
				'selectors' => [
					'{{WRAPPER}} .exad-woo-cart.exad-cart-layout-2 .woocommerce .woocommerce-cart-form' => 'width: {{SIZE}}%;',
					'{{WRAPPER}} .exad-woo-cart.exad-cart-layout-2 .woocommerce .cart-collaterals' => 'width: calc( 100% - {{SIZE}}% );',
				],
				'condition' => [
					'exad_woo_content_layout' => 'exad-cart-layout-2'
				]
			]
		);

		$this->add_responsive_control(
			'exad_woo_cart_product_table_gap',
			[
				'label' => __( 'Cart Table Gap', 'exclusive-addons-elementor-pro' ),
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
					'size' => 20,
				],
				'selectors' => [
					'{{WRAPPER}} .exad-woo-cart.exad-cart-layout-2 .woocommerce .woocommerce-cart-form' => 'margin-right: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'exad_woo_content_layout' => 'exad-cart-layout-2'
				]
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'exad_woo_cart_product_table_background',
				'label' => __( 'Background', 'exclusive-addons-elementor-pro' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .exad-woo-cart .woocommerce-cart-form__contents',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'exad_woo_cart_product_table_border',
				'label' => __( 'Border', 'exclusive-addons-elementor-pro' ),
				'fields_options'  => [
                    'border' 	  => [
                        'default' => 'solid'
                    ],
                    'width'  	  => [
                        'default' 	 => [
                            'top'    => '1',
                            'right'  => '1',
                            'bottom' => '1',
                            'left'   => '1'
                        ]
                    ],
                    'color' 	  => [
                        'default' => '#dddddd'
                    ]
                ],
				'selector' => '{{WRAPPER}} .exad-woo-cart .woocommerce-cart-form__contents',
			]
		);

		$this->add_control(
			'exad_woo_cart_product_table_border_collapse',
			[
				'label' => __( 'Border Collapse', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'collapse',
				'options' => [
					'collapse'  => __( 'Collapse', 'exclusive-addons-elementor-pro' ),
					'separate'  => __( 'Separate', 'exclusive-addons-elementor-pro' ),
				],
				'description' => __( 'If Border Collapse is collapse then the border of table do not work.', 'exclusive-addons-elementor-pro' ),
				'selectors' => [
					'{{WRAPPER}} .exad-woo-cart .woocommerce-cart-form__contents' => 'border-collapse: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'exad_woo_cart_product_table_border_radius',
			[
				'label' => __( 'Border Radius', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'default' => [
					'top' => '0',
					'left' => '0',
					'bottom' => '0',
					'right' => '0',
					'unit' => 'px',
					'isLinked' => true
				],
				'selectors' => [
					'{{WRAPPER}} .exad-woo-cart .woocommerce-cart-form__contents' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'exad_woo_cart_product_table_box_shadow',
				'label' => __( 'Box Shadow', 'exclusive-addons-elementor-pro' ),
				'selector' => '{{WRAPPER}} .exad-woo-cart .woocommerce-cart-form__contents',
			]
		);

		$this->end_controls_section();

		/**
		 * Cart Table Heading Section
		 */

        $this->start_controls_section(
            'exad_woo_cart_product_table_heading_section',
            [
				'label' => esc_html__( 'Cart Table Heading', 'exclusive-addons-elementor-pro' ),
				'tab'   => Controls_Manager::TAB_STYLE
            ]
		);

		$this->add_responsive_control(
			'exad_woo_cart_product_table_heading_alignment',
			[
				'label' => __( 'Alignment', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => __( 'Left', 'exclusive-addons-elementor-pro' ),
						'icon' => 'fa fa-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'exclusive-addons-elementor-pro' ),
						'icon' => 'fa fa-align-center',
					],
					'right' => [
						'title' => __( 'Right', 'exclusive-addons-elementor-pro' ),
						'icon' => 'fa fa-align-right',
					],
				],
				'default' => 'left',
				'toggle' => true,
				'selectors' => [
					'{{WRAPPER}} .exad-woo-cart .woocommerce-cart-form__contents thead tr th' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'exad_woo_cart_product_table_heading_padding',
			[
				'label' => __( 'Padding', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'default' => [
					'top' => '15',
					'right' => '20',
					'bottom' => '15',
					'left' => '15',
					'unit' => 'px',
					'isLinked' => false,
				],
				'selectors' => [
					'{{WRAPPER}} .exad-woo-cart .woocommerce-cart-form__contents thead tr th' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'exad_woo_cart_product_table_heading_background',
			[
				'label' => __( 'Background Color', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .exad-woo-cart .woocommerce-cart-form__contents thead tr th' => 'background: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'exad_woo_cart_product_table_heading_typograpgy',
				'label' => __( 'Typography', 'exclusive-addons-elementor-pro' ),
				'selector' => '{{WRAPPER}} .exad-woo-cart .woocommerce-cart-form__contents thead tr th',
			]
		);

		$this->add_control(
			'exad_woo_cart_product_table_heading_text_color',
			[
				'label' => __( 'Text Color', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .exad-woo-cart .woocommerce-cart-form__contents thead tr th' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'exad_woo_cart_product_table_heading_text_border',
				'label' => __( 'Border', 'exclusive-addons-elementor-pro' ),
				'fields_options'  => [
                    'border' 	  => [
                        'default' => 'solid'
                    ],
                    'width'  	  => [
                        'default' 	 => [
                            'top'    => '0',
                            'right'  => '0',
                            'bottom' => '1',
                            'left'   => '0'
                        ]
                    ],
                    'color' 	  => [
                        'default' => '#dddddd'
                    ]
                ],
				'selector' => '{{WRAPPER}} .exad-woo-cart .woocommerce-cart-form__contents thead tr th',
			]
		);

		$this->end_controls_section();

		/**
		 * Cart Table Item Section
		 */

        $this->start_controls_section(
            'exad_woo_cart_product_table_item_section',
            [
				'label' => esc_html__( 'Cart Table Item', 'exclusive-addons-elementor-pro' ),
				'tab'   => Controls_Manager::TAB_STYLE
            ]
		);

		$this->add_responsive_control(
			'exad_woo_cart_product_table_item_alignment',
			[
				'label' => __( 'Alignment', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => __( 'Left', 'exclusive-addons-elementor-pro' ),
						'icon' => 'fa fa-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'exclusive-addons-elementor-pro' ),
						'icon' => 'fa fa-align-center',
					],
					'right' => [
						'title' => __( 'Right', 'exclusive-addons-elementor-pro' ),
						'icon' => 'fa fa-align-right',
					],
				],
				'default' => 'left',
				'toggle' => true,
				'selectors' => [
					'{{WRAPPER}} .exad-woo-cart .woocommerce-cart-form__contents tbody tr.woocommerce-cart-form__cart-item td' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'exad_woo_cart_product_table_item_padding',
			[
				'label' => __( 'Padding', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'default' => [
					'top' => '15',
					'right' => '20',
					'bottom' => '15',
					'left' => '15',
					'unit' => 'px',
					'isLinked' => false,
				],
				'selectors' => [
					'{{WRAPPER}} .exad-woo-cart .woocommerce-cart-form__contents tbody tr td' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'exad_woo_cart_product_table_item_border',
				'label' => __( 'Border', 'exclusive-addons-elementor-pro' ),
				'fields_options'  => [
                    'border' 	  => [
                        'default' => 'solid'
                    ],
                    'width'  	  => [
                        'default' 	 => [
                            'top'    => '0',
                            'right'  => '0',
                            'bottom' => '1',
                            'left'   => '0'
                        ]
                    ],
                    'color' 	  => [
                        'default' => '#dddddd'
                    ]
                ],
				'selector' => '{{WRAPPER}} .exad-woo-cart .woocommerce-cart-form__contents tbody tr.woocommerce-cart-form__cart-item td',
			]
		);

		$this->start_controls_tabs( 'exad_woo_cart_product_table_item_tabs' );

            // Normal State Tab
			$this->start_controls_tab( 'exad_woo_cart_product_table_item_odd', [ 'label' => esc_html__( 'ODD ITEM', 'exclusive-addons-elementor-pro' ) ] );

				$this->add_control(
					'exad_woo_cart_product_table_item_odd_background',
					[
						'label'     => esc_html__( 'Background Color', 'exclusive-addons-elementor-pro' ),
						'type'      => Controls_Manager::COLOR,
						'default'   => '#ffffff',
						'selectors' => [
							'{{WRAPPER}} .exad-woo-cart .woocommerce-cart-form__contents tbody tr.woocommerce-cart-form__cart-item:nth-child(odd) td' => 'background: {{VALUE}};'
						]
					]
				);
            
            $this->end_controls_tab();

            // Hover State Tab
			$this->start_controls_tab( 'exad_woo_cart_product_table_item_even', [ 'label' => esc_html__( 'EVEN ITEM', 'exclusive-addons-elementor-pro' ) ] );
			
				$this->add_control(
					'exad_woo_cart_product_table_item_even_background',
					[
						'label'     => esc_html__( 'Background Color', 'exclusive-addons-elementor-pro' ),
						'type'      => Controls_Manager::COLOR,
						'default'   => '#ffffff',
						'selectors' => [
							'{{WRAPPER}} .exad-woo-cart .woocommerce-cart-form__contents tbody tr.woocommerce-cart-form__cart-item:nth-child(even) td' => 'background: {{VALUE}};'
						]
					]
				);

            $this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_control(
			'exad_woo_cart_product_table_item_image_heading',
			[
				'label' => __( 'Image', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'exad_woo_cart_product_table_item_image_width',
			[
				'label' => __( 'Width', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 500,
						'step' => 5,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 100,
				],
				'selectors' => [
					'{{WRAPPER}} .exad-woo-cart .woocommerce-cart-form__contents tbody tr td.product-thumbnail img' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'exad_woo_cart_product_table_item_image_border',
				'label' => __( 'Border', 'exclusive-addons-elementor-pro' ),
				'selector' => '{{WRAPPER}} .exad-woo-cart .woocommerce-cart-form__contents tbody tr td.product-thumbnail img',
			]
		);

		$this->add_responsive_control(
			'exad_woo_cart_product_table_item_image_border_radius',
			[
				'label' => __( 'Border Radius', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .exad-woo-cart .woocommerce-cart-form__contents tbody tr td.product-thumbnail img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'exad_woo_cart_product_table_item_image_box_shadow',
				'label' => __( 'Box Shadow', 'exclusive-addons-elementor-pro' ),
				'selector' => '{{WRAPPER}} .exad-woo-cart .woocommerce-cart-form__contents tbody tr td.product-thumbnail img',
			]
		);

		$this->add_control(
			'exad_woo_cart_product_table_item_product_name_heading',
			[
				'label' => __( 'Product Name', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'exad_woo_cart_product_table_item_product_name_typography',
				'label' => __( 'Typography', 'exclusive-addons-elementor-pro' ),
				'selector' => '{{WRAPPER}} .exad-woo-cart .woocommerce-cart-form__contents tbody tr td.product-name a',
			]
		);

		$this->start_controls_tabs( 'exad_woo_cart_product_table_item_product_name_tabs' );

            // Normal State Tab
			$this->start_controls_tab( 'exad_woo_cart_product_table_item_product_name_normal', [ 'label' => esc_html__( 'Normal', 'exclusive-addons-elementor-pro' ) ] );

				$this->add_control(
					'exad_woo_cart_product_table_item_product_name_normal_color',
					[
						'label'     => esc_html__( 'Text Color', 'exclusive-addons-elementor-pro' ),
						'type'      => Controls_Manager::COLOR,
						'default'   => '#000000',
						'selectors' => [
							'{{WRAPPER}} .exad-woo-cart .woocommerce-cart-form__contents tbody tr td.product-name a' => 'color: {{VALUE}};'
						]
					]
				);
            
            $this->end_controls_tab();

            // Hover State Tab
			$this->start_controls_tab( 'exad_woo_cart_product_table_item_product_name_hover', [ 'label' => esc_html__( 'Hover', 'exclusive-addons-elementor-pro' ) ] );
			
				$this->add_control(
					'exad_woo_cart_product_table_item_product_name_hover_color',
					[
						'label'     => esc_html__( 'Text Color', 'exclusive-addons-elementor-pro' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .exad-woo-cart .woocommerce-cart-form__contents tbody tr td.product-name a:hover' => 'color: {{VALUE}};'
						]
					]
				);

            $this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_control(
			'exad_woo_cart_product_table_item_product_price_heading',
			[
				'label' => __( 'Product Price', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'exad_woo_cart_product_table_item_product_price_typography',
				'label' => __( 'Typography', 'exclusive-addons-elementor-pro' ),
				'selector' => '{{WRAPPER}} .exad-woo-cart .woocommerce-cart-form__contents tbody tr td.product-price',
			]
		);

		$this->add_control(
			'exad_woo_cart_product_table_item_product_quantity_heading',
			[
				'label' => __( 'Product Quantity', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'exad_woo_cart_product_table_item_product_quantity_input_width',
			[
				'label' => __( 'Input Width', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 500,
						'step' => 5,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 100,
				],
				'selectors' => [
					'{{WRAPPER}} .exad-woo-cart .woocommerce-cart-form__contents tbody tr td.product-quantity .quantity input' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'exad_woo_cart_product_table_item_product_quantity_input_height',
			[
				'label' => __( 'Input Height', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
						'step' => 5,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .exad-woo-cart .woocommerce-cart-form__contents tbody tr td.product-quantity .quantity input' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'exad_woo_cart_product_table_item_product_quantity_input_padding',
			[
				'label' => __( 'Input Padding', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .exad-woo-cart .woocommerce-cart-form__contents tbody tr td.product-quantity .quantity input' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'exad_woo_cart_product_table_item_product_quantity_input_background',
			[
				'label'     => esc_html__( 'Input Background Color', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .exad-woo-cart .woocommerce-cart-form__contents tbody tr td.product-quantity .quantity input' => 'background: {{VALUE}};'
				]
			]
		);

		$this->add_control(
			'exad_woo_cart_product_table_item_product_quantity_input_text_color',
			[
				'label'     => esc_html__( 'Input Text Color', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .exad-woo-cart .woocommerce-cart-form__contents tbody tr td.product-quantity .quantity input' => 'color: {{VALUE}};'
				]
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'exad_woo_cart_product_table_item_product_quantity_input_border',
				'label' => __( 'Border', 'exclusive-addons-elementor-pro' ),
				'fields_options'  => [
                    'border' 	  => [
                        'default' => 'solid'
                    ],
                    'width'  	  => [
                        'default' 	 => [
                            'top'    => '1',
                            'right'  => '1',
                            'bottom' => '1',
                            'left'   => '1'
                        ]
                    ],
                    'color' 	  => [
                        'default' => '#dddddd'
                    ]
                ],
				'selector' => '{{WRAPPER}} .exad-woo-cart .woocommerce-cart-form__contents tbody tr td.product-quantity .quantity input',
			]
		);

		$this->add_responsive_control(
			'exad_woo_cart_product_table_item_product_quantity_input_border_radius',
			[
				'label' => __( 'Input Border Radius', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .exad-woo-cart .woocommerce-cart-form__contents tbody tr td.product-quantity .quantity input' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .exad-woo-cart .woocommerce-cart-form__contents tbody tr td.product-quantity .quantity .exad-quantity-minus-btn' => 'border-radius: {{TOP}}{{UNIT}} 0 0 {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .exad-woo-cart .woocommerce-cart-form__contents tbody tr td.product-quantity .quantity .exad-quantity-plus-btn' => 'border-radius: 0 {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} 0;',
				],
			]
		);

		$this->add_control(
			'exad_woo_cart_product_table_item_product_quantity_icon_color',
			[
				'label'     => esc_html__( 'Input Icon Color', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .exad-woo-cart .woocommerce-cart-form__contents tbody tr td.product-quantity .quantity .exad-quantity-minus-btn::before' => 'background: {{VALUE}};',
					'{{WRAPPER}} .exad-woo-cart .woocommerce-cart-form__contents tbody tr td.product-quantity .quantity .exad-quantity-plus-btn::before' => 'background: {{VALUE}};',
					'{{WRAPPER}} .exad-woo-cart .woocommerce-cart-form__contents tbody tr td.product-quantity .quantity .exad-quantity-plus-btn::after' => 'background: {{VALUE}};'
				]
			]
		);

		$this->add_responsive_control(
			'exad_woo_cart_product_table_item_product_quantity_icon_width',
			[
				'label' => __( 'Input Icon Width', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .exad-woo-cart .woocommerce-cart-form__contents tbody tr td.product-quantity .quantity .exad-quantity-minus-btn' => 'width: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .exad-woo-cart .woocommerce-cart-form__contents tbody tr td.product-quantity .quantity .exad-quantity-plus-btn' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'exad_woo_cart_product_table_item_product_quantity_icon_background',
			[
				'label'     => esc_html__( 'Input Icon Background', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .exad-woo-cart .woocommerce-cart-form__contents tbody tr td.product-quantity .quantity .exad-quantity-minus-btn' => 'background: {{VALUE}};',
					'{{WRAPPER}} .exad-woo-cart .woocommerce-cart-form__contents tbody tr td.product-quantity .quantity .exad-quantity-plus-btn' => 'background: {{VALUE}};'
				]
			]
		);

		$this->add_control(
			'exad_woo_cart_product_table_item_product_quantity_icon_left_border',
			[
				'label'     => esc_html__( 'Input Icon Left/Right Border Color', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .exad-woo-cart .woocommerce-cart-form__contents tbody tr td.product-quantity .quantity .exad-quantity-minus-btn' => 'border-right: 1px solid {{VALUE}};',
					'{{WRAPPER}} .exad-woo-cart .woocommerce-cart-form__contents tbody tr td.product-quantity .quantity .exad-quantity-plus-btn' => 'border-left: 1px solid {{VALUE}};'
				]
			]
		);

		$this->add_control(
			'exad_woo_cart_product_table_item_subtotal_heading',
			[
				'label' => __( 'Product Subtotal', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'exad_woo_cart_product_table_item_subtotal_typography',
				'label' => __( 'Typography', 'exclusive-addons-elementor-pro' ),
				'selector' => '{{WRAPPER}} .exad-woo-cart .woocommerce-cart-form__contents tbody tr td.product-subtotal',
			]
		);

		$this->add_control(
			'exad_woo_cart_product_table_item_subtotal_color',
			[
				'label'     => esc_html__( 'Product Subtotal Text Color', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .exad-woo-cart .woocommerce-cart-form__contents tbody tr td.product-subtotal' => 'color: {{VALUE}};'
				]
			]
		);

		$this->end_controls_section();

		/**
		 * Cart Table Item Remove Section
		 */

        $this->start_controls_section(
            'exad_woo_cart_product_table_item_remove_section',
            [
				'label' => esc_html__( 'Cart Item Remove Icon', 'exclusive-addons-elementor-pro' ),
				'tab'   => Controls_Manager::TAB_STYLE
            ]
		);

		$this->add_responsive_control(
			'exad_woo_cart_product_table_item_remove_icon_size',
			[
				'label' => __( 'Remove Icon Size', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 50,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 20,
				],
				'selectors' => [
					'{{WRAPPER}} .exad-woo-cart .woocommerce-cart-form__contents tbody tr td.product-remove a' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'exad_woo_cart_product_table_item_remove_icon_box_size',
			[
				'label' => __( 'Remove Icon Box Size', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 50,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 20,
				],
				'selectors' => [
					'{{WRAPPER}} .exad-woo-cart .woocommerce-cart-form__contents tbody tr td.product-remove a' => 'height: {{SIZE}}{{UNIT}}; width: {{SIZE}}{{UNIT}}; line-height: calc( {{SIZE}}{{UNIT}} - 4px );',
				],
			]
		);

		$this->add_responsive_control(
			'exad_woo_cart_product_table_item_remove_icon_box_radius',
			[
				'label' => __( 'Border Radius', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'default' => [
					'top' => '50',
					'right' => '50',
					'bottom' => '50',
					'left' => '50',
					'unit' => 'px',
					'isLinked' => true,
				],
				'selectors' => [
					'{{WRAPPER}} .exad-woo-cart .woocommerce-cart-form__contents tbody tr td.product-remove a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs( 'exad_woo_cart_product_table_item_remove_icon_tabs' );

            // Normal State Tab
			$this->start_controls_tab( 'exad_woo_cart_product_item_remove_icon_normal', [ 'label' => esc_html__( 'Normal', 'exclusive-addons-elementor-pro' ) ] );

				$this->add_control(
					'exad_woo_cart_product_item_remove_icon_normal_background',
					[
						'label'     => esc_html__( 'Icon Background Color', 'exclusive-addons-elementor-pro' ),
						'type'      => Controls_Manager::COLOR,
						'default'   => '#000000',
						'selectors' => [
							'{{WRAPPER}} .exad-woo-cart .woocommerce-cart-form__contents tbody tr td.product-remove a' => 'background: {{VALUE}};'
						]
					]
				);

				$this->add_control(
					'exad_woo_cart_product_item_remove_icon_normal_color',
					[
						'label'     => esc_html__( 'Icon Color', 'exclusive-addons-elementor-pro' ),
						'type'      => Controls_Manager::COLOR,
						'default'   => '#ffffff',
						'selectors' => [
							'{{WRAPPER}} .exad-woo-cart .woocommerce-cart-form__contents tbody tr td.product-remove a' => 'color: {{VALUE}} !important;'
						]
					]
				);

				$this->add_group_control(
					Group_Control_Border::get_type(),
					[
						'name' => 'exad_woo_cart_product_item_remove_icon_normal_border',
						'label' => __( 'Border', 'exclusive-addons-elementor-pro' ),
						'selector' => '{{WRAPPER}} .exad-woo-cart .woocommerce-cart-form__contents tbody tr td.product-remove a',
					]
				);

				$this->add_group_control(
					Group_Control_Box_Shadow::get_type(),
					[
						'name' => 'exad_woo_cart_product_item_remove_icon_normal_box_shadow',
						'label' => __( 'Box Shadow', 'exclusive-addons-elementor-pro' ),
						'selector' => '{{WRAPPER}} .exad-woo-cart .woocommerce-cart-form__contents tbody tr td.product-remove a',
					]
				);
            
            $this->end_controls_tab();

            // Hover State Tab
			$this->start_controls_tab( 'exad_woo_cart_product_item_remove_icon_hover', [ 'label' => esc_html__( 'Hover', 'exclusive-addons-elementor-pro' ) ] );
			
				$this->add_control(
					'exad_woo_cart_product_item_remove_icon_hover_background',
					[
						'label'     => esc_html__( 'Icon Background Color', 'exclusive-addons-elementor-pro' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .exad-woo-cart .woocommerce-cart-form__contents tbody tr td.product-remove a:hover' => 'background: {{VALUE}};'
						]
					]
				);

				$this->add_control(
					'exad_woo_cart_product_item_remove_icon_hover_color',
					[
						'label'     => esc_html__( 'Icon Color', 'exclusive-addons-elementor-pro' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .exad-woo-cart .woocommerce-cart-form__contents tbody tr td.product-remove a:hover' => 'color: {{VALUE}} !important;'
						]
					]
				);

				$this->add_group_control(
					Group_Control_Border::get_type(),
					[
						'name' => 'exad_woo_cart_product_item_remove_icon_hover_border',
						'label' => __( 'Border', 'exclusive-addons-elementor-pro' ),
						'selector' => '{{WRAPPER}} .exad-woo-cart .woocommerce-cart-form__contents tbody tr td.product-remove a:hover',
					]
				);

				$this->add_group_control(
					Group_Control_Box_Shadow::get_type(),
					[
						'name' => 'exad_woo_cart_product_item_remove_icon_hover_box_shadow',
						'label' => __( 'Box Shadow', 'exclusive-addons-elementor-pro' ),
						'selector' => '{{WRAPPER}} .exad-woo-cart .woocommerce-cart-form__contents tbody tr td.product-remove a:hover',
					]
				);

            $this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		/**
		 * Cart Table Coupon Section
		 */

        $this->start_controls_section(
            'exad_woo_cart_coupon_section',
            [
				'label' => esc_html__( 'Cart Coupon', 'exclusive-addons-elementor-pro' ),
				'tab'   => Controls_Manager::TAB_STYLE
            ]
		);

		$this->add_control(
			'exad_woo_cart_coupon_section_background',
			[
				'label'     => esc_html__( 'Coupon Section Background', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'default' 	=> '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .exad-woo-cart .woocommerce-cart-form__contents tbody tr td.actions' => 'background: {{VALUE}};'
				]
			]
		);

		$this->add_responsive_control(
			'exad_woo_cart_coupon_section_padding',
			[
				'label' => __( 'Coupon Section Padding', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .exad-woo-cart .woocommerce-cart-form__contents tbody tr td.actions' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'exad_woo_cart_coupon_section_border',
				'label' => __( 'Border', 'exclusive-addons-elementor-pro' ),
				'selector' => '{{WRAPPER}} .exad-woo-cart .woocommerce-cart-form__contents tbody tr td.actions',
			]
		);

		$this->add_control(
			'exad_woo_cart_coupon_input_heading',
			[
				'label' => __( 'Cart Coupon Input', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'exad_woo_cart_coupon_input_width',
			[
				'label' => __( 'Input Width', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 500,
						'step' => 5,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 200,
				],
				'selectors' => [
					'{{WRAPPER}} .exad-woo-cart .woocommerce-cart-form__contents tbody tr .coupon input#coupon_code' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'exad_woo_cart_coupon_input_height',
			[
				'label' => __( 'Input Height', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 500,
						'step' => 5,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .exad-woo-cart .woocommerce-cart-form__contents tbody tr .coupon input#coupon_code' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'exad_woo_cart_coupon_input_padding',
			[
				'label' => __( 'Input Padding', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .exad-woo-cart .woocommerce-cart-form__contents tbody tr .coupon input#coupon_code' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'exad_woo_cart_coupon_input_background',
			[
				'label'     => esc_html__( 'Input Background Color', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .exad-woo-cart .woocommerce-cart-form__contents tbody tr .coupon input#coupon_code' => 'background: {{VALUE}};'
				]
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'exad_woo_cart_coupon_input_typography',
				'label' => __( 'Typography', 'exclusive-addons-elementor-pro' ),
				'selector' => '{{WRAPPER}} .exad-woo-cart .woocommerce-cart-form__contents tbody tr .coupon input#coupon_code',
			]
		);

		$this->add_control(
			'exad_woo_cart_coupon_input_text_color',
			[
				'label'     => esc_html__( 'Input Text Color', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .exad-woo-cart .woocommerce-cart-form__contents tbody tr .coupon input#coupon_code' => 'color: {{VALUE}};'
				]
			]
		);

		$this->add_control(
			'exad_woo_cart_coupon_input_placeholder_text_color',
			[
				'label'     => esc_html__( 'Input Placeholder Text Color', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .exad-woo-cart .woocommerce-cart-form__contents tbody tr .coupon input#coupon_code::placeholder' => 'color: {{VALUE}};'
				]
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'exad_woo_cart_coupon_input_border',
				'label' => __( 'Border', 'exclusive-addons-elementor-pro' ),
				'selector' => '{{WRAPPER}} .exad-woo-cart .woocommerce-cart-form__contents tbody tr .coupon input#coupon_code',
			]
		);

		$this->add_responsive_control(
			'exad_woo_cart_coupon_input_border_radius',
			[
				'label' => __( 'Input Border Radius', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'default' => [
					'top' => '5',
					'right' => '5',
					'bottom' => '5',
					'left' => '5',
					'unit' => 'px',
					'isLinked' => true,
				],
				'selectors' => [
					'{{WRAPPER}} .exad-woo-cart .woocommerce-cart-form__contents tbody tr .coupon input#coupon_code' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'exad_woo_cart_coupon_button_heading',
			[
				'label' => __( 'Cart Coupon Button', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'exad_woo_cart_coupon_button_padding',
			[
				'label' => __( 'Coupon Button Padding', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'default' => [
					'top' => '15',
					'right' => '30',
					'bottom' => '15',
					'left' => '30',
					'unit' => 'px',
					'isLinked' => false,
				],
				'selectors' => [
					'{{WRAPPER}} .exad-woo-cart .woocommerce-cart-form__contents tbody tr .coupon button.button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'exad_woo_cart_coupon_button_typography',
				'label' => __( 'Typography', 'exclusive-addons-elementor-pro' ),
				'selector' => '{{WRAPPER}} .exad-woo-cart .woocommerce-cart-form__contents tbody tr .coupon button.button',
			]
		);

		$this->add_responsive_control(
			'exad_woo_cart_coupon_button_border_radius',
			[
				'label' => __( 'Coupon Button Border Radius', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'default' => [
					'top' => '5',
					'right' => '5',
					'bottom' => '5',
					'left' => '5',
					'unit' => 'px',
					'isLinked' => true,
				],
				'selectors' => [
					'{{WRAPPER}} .exad-woo-cart .woocommerce-cart-form__contents tbody tr .coupon button.button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs( 'exad_woo_cart_coupon_button_tabs' );

            // Normal State Tab
			$this->start_controls_tab( 'exad_woo_cart_coupon_button_normal', [ 'label' => esc_html__( 'Normal', 'exclusive-addons-elementor-pro' ) ] );

				$this->add_control(
					'exad_woo_cart_coupon_button_normal_background',
					[
						'label'     => esc_html__( 'Background Color', 'exclusive-addons-elementor-pro' ),
						'type'      => Controls_Manager::COLOR,
						'default'   => '#000000',
						'selectors' => [
							'{{WRAPPER}} .exad-woo-cart .woocommerce-cart-form__contents tbody tr .coupon button.button' => 'background: {{VALUE}};'
						]
					]
				);

				$this->add_control(
					'exad_woo_cart_coupon_button_normal_color',
					[
						'label'     => esc_html__( 'Text Color', 'exclusive-addons-elementor-pro' ),
						'type'      => Controls_Manager::COLOR,
						'default'   => '#ffffff',
						'selectors' => [
							'{{WRAPPER}} .exad-woo-cart .woocommerce-cart-form__contents tbody tr .coupon button.button' => 'color: {{VALUE}};'
						]
					]
				);

				$this->add_group_control(
					Group_Control_Border::get_type(),
					[
						'name' => 'exad_woo_cart_coupon_button_normal_border',
						'label' => __( 'Border', 'exclusive-addons-elementor-pro' ),
						'selector' => '{{WRAPPER}} .exad-woo-cart .woocommerce-cart-form__contents tbody tr .coupon button.button',
					]
				);

				$this->add_group_control(
					Group_Control_Box_Shadow::get_type(),
					[
						'name' => 'exad_woo_cart_coupon_button_normal_box_shadow',
						'label' => __( 'Box Shadow', 'exclusive-addons-elementor-pro' ),
						'selector' => '{{WRAPPER}} .exad-woo-cart .woocommerce-cart-form__contents tbody tr .coupon button.button',
					]
				);
            
            $this->end_controls_tab();

            // Hover State Tab
			$this->start_controls_tab( 'exad_woo_cart_coupon_button_hover', [ 'label' => esc_html__( 'Hover', 'exclusive-addons-elementor-pro' ) ] );
			
				$this->add_control(
					'exad_woo_cart_coupon_button_hover_background',
					[
						'label'     => esc_html__( 'Background Color', 'exclusive-addons-elementor-pro' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .exad-woo-cart .woocommerce-cart-form__contents tbody tr .coupon button.button:hover' => 'background: {{VALUE}};'
						]
					]
				);

				$this->add_control(
					'exad_woo_cart_coupon_button_hover_color',
					[
						'label'     => esc_html__( 'Text Color', 'exclusive-addons-elementor-pro' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .exad-woo-cart .woocommerce-cart-form__contents tbody tr .coupon button.button:hover' => 'color: {{VALUE}};'
						]
					]
				);

				$this->add_group_control(
					Group_Control_Border::get_type(),
					[
						'name' => 'exad_woo_cart_coupon_button_hover_border',
						'label' => __( 'Border', 'exclusive-addons-elementor-pro' ),
						'selector' => '{{WRAPPER}} .exad-woo-cart .woocommerce-cart-form__contents tbody tr .coupon button.button:hover',
					]
				);

				$this->add_group_control(
					Group_Control_Box_Shadow::get_type(),
					[
						'name' => 'exad_woo_cart_coupon_button_hover_box_shadow',
						'label' => __( 'Box Shadow', 'exclusive-addons-elementor-pro' ),
						'selector' => '{{WRAPPER}} .exad-woo-cart .woocommerce-cart-form__contents tbody tr .coupon button.button:hover',
					]
				);

            $this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		/**
		 * Cart Table Item Section
		 */

        $this->start_controls_section(
            'exad_woo_cart_update_button_section',
            [
				'label' => esc_html__( 'Update Cart Button', 'exclusive-addons-elementor-pro' ),
				'tab'   => Controls_Manager::TAB_STYLE
            ]
		);

		$this->add_responsive_control(
			'exad_woo_cart_update_button_padding',
			[
				'label' => __( 'Padding', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'default' => [
					'top' => '15',
					'right' => '30',
					'bottom' => '15',
					'left' => '30',
					'unit' => 'px',
					'isLinked' => false,
				],
				'selectors' => [
					'{{WRAPPER}} .exad-woo-cart .woocommerce-cart-form__contents tbody tr button.button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'exad_woo_cart_update_button_typography',
				'label' => __( 'Typography', 'exclusive-addons-elementor-pro' ),
				'selector' => '{{WRAPPER}} .exad-woo-cart .woocommerce-cart-form__contents tbody tr button.button',
			]
		);

		$this->add_responsive_control(
			'exad_woo_cart_update_button_radius',
			[
				'label' => __( 'Border Radius', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'default' => [
					'top' => '5',
					'right' => '5',
					'bottom' => '5',
					'left' => '5',
					'unit' => 'px',
					'isLinked' => true,
				],
				'selectors' => [
					'{{WRAPPER}} .exad-woo-cart .woocommerce-cart-form__contents tbody tr button.button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs( 'exad_woo_cart_update_button_tabs' );

            // Normal State Tab
			$this->start_controls_tab( 'exad_woo_cart_update_button_normal', [ 'label' => esc_html__( 'Normal', 'exclusive-addons-elementor-pro' ) ] );

				$this->add_control(
					'exad_woo_cart_update_button_normal_background',
					[
						'label'     => esc_html__( 'Background Color', 'exclusive-addons-elementor-pro' ),
						'type'      => Controls_Manager::COLOR,
						'default'   => '#000000',
						'selectors' => [
							'{{WRAPPER}} .exad-woo-cart .woocommerce-cart-form__contents tbody tr button.button' => 'background: {{VALUE}};'
						]
					]
				);

				$this->add_control(
					'exad_woo_cart_update_button_normal_color',
					[
						'label'     => esc_html__( 'Text Color', 'exclusive-addons-elementor-pro' ),
						'type'      => Controls_Manager::COLOR,
						'default'   => '#ffffff',
						'selectors' => [
							'{{WRAPPER}} .exad-woo-cart .woocommerce-cart-form__contents tbody tr button.button' => 'color: {{VALUE}};'
						]
					]
				);

				$this->add_group_control(
					Group_Control_Border::get_type(),
					[
						'name' => 'exad_woo_cart_update_button_normal_border',
						'label' => __( 'Border', 'exclusive-addons-elementor-pro' ),
						'selector' => '{{WRAPPER}} .exad-woo-cart .woocommerce-cart-form__contents tbody tr button.button',
					]
				);

				$this->add_group_control(
					Group_Control_Box_Shadow::get_type(),
					[
						'name' => 'exad_woo_cart_update_button_normal_shadow',
						'label' => __( 'Box Shadow', 'exclusive-addons-elementor-pro' ),
						'selector' => '{{WRAPPER}} .exad-woo-cart .woocommerce-cart-form__contents tbody tr button.button',
					]
				);
            
            $this->end_controls_tab();

            // Hover State Tab
			$this->start_controls_tab( 'exad_woo_cart_update_button_hover', [ 'label' => esc_html__( 'Hover', 'exclusive-addons-elementor-pro' ) ] );
			
				$this->add_control(
					'exad_woo_cart_update_button_hover_background',
					[
						'label'     => esc_html__( 'Background Color', 'exclusive-addons-elementor-pro' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .exad-woo-cart .woocommerce-cart-form__contents tbody tr button.button:hover' => 'background: {{VALUE}};'
						]
					]
				);

				$this->add_control(
					'exad_woo_cart_update_button_hover_color',
					[
						'label'     => esc_html__( 'Text Color', 'exclusive-addons-elementor-pro' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .exad-woo-cart .woocommerce-cart-form__contents tbody tr button.button:hover' => 'color: {{VALUE}};'
						]
					]
				);

				$this->add_group_control(
					Group_Control_Border::get_type(),
					[
						'name' => 'exad_woo_cart_update_button_hover_border',
						'label' => __( 'Border', 'exclusive-addons-elementor-pro' ),
						'selector' => '{{WRAPPER}} .exad-woo-cart .woocommerce-cart-form__contents tbody tr button.button:hover',
					]
				);

				$this->add_group_control(
					Group_Control_Box_Shadow::get_type(),
					[
						'name' => 'exad_woo_cart_update_button_hover_box_shadow',
						'label' => __( 'Box Shadow', 'exclusive-addons-elementor-pro' ),
						'selector' => '{{WRAPPER}} .exad-woo-cart .woocommerce-cart-form__contents tbody tr button.button:hover',
					]
				);

            $this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		/**
		 * Cart Total Section
		 */

        $this->start_controls_section(
            'exad_woo_cart_total_section',
            [
				'label' => esc_html__( 'Cart Total Box', 'exclusive-addons-elementor-pro' ),
				'tab'   => Controls_Manager::TAB_STYLE
            ]
		);

		$this->add_responsive_control(
			'exad_woo_cart_total_box_width',
			[
				'label' => __( 'Cart Total Box Width', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ '%' ],
				'range' => [
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .exad-woo-cart .cart_totals' => 'width: {{SIZE}}%;',
				],
				'condition' => [
					'exad_woo_content_layout' => 'exad-cart-layout-1'
				]
			]
		);

		$this->add_responsive_control(
			'exad_woo_cart_total_box_top_spacing',
			[
				'label' => __( 'Top Spacing', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .exad-woo-cart .cart_totals' => 'margin-top: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'exad_woo_cart_total_box_background',
				'label' => __( 'Background', 'exclusive-addons-elementor-pro' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .exad-woo-cart .cart_totals',
			]
		);

		$this->add_responsive_control(
			'exad_woo_cart_total_box_padding',
			[
				'label' => __( 'Padding', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'default' => [
					'top' => '20',
					'right' => '20',
					'bottom' => '20',
					'left' => '20',
					'unit' => 'px',
					'isLinked' => true,
				],
				'selectors' => [
					'{{WRAPPER}} .exad-woo-cart .cart_totals' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'exad_woo_cart_total_box_border',
				'label' => __( 'Border', 'exclusive-addons-elementor-pro' ),
				'fields_options'  => [
                    'border' 	  => [
                        'default' => 'solid'
                    ],
                    'width'  	  => [
                        'default' 	 => [
                            'top'    => '1',
                            'right'  => '1',
                            'bottom' => '1',
                            'left'   => '1'
                        ]
                    ],
                    'color' 	  => [
                        'default' => '#dddddd'
                    ]
                ],
				'selector' => '{{WRAPPER}} .exad-woo-cart .cart_totals',
			]
		);

		$this->add_responsive_control(
			'exad_woo_cart_total_box_border_radius',
			[
				'label' => __( 'Border Radius', 'exclusive-addons-elementor-pro' ),
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
					'{{WRAPPER}} .exad-woo-cart .cart_totals' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'exad_woo_cart_total_box_box_shadow',
				'label' => __( 'Box Shadow', 'exclusive-addons-elementor-pro' ),
				'selector' => '{{WRAPPER}} .exad-woo-cart .cart_totals',
			]
		);

		$this->end_controls_section();

		/**
		 * Cart Total Heading Section
		 */

        $this->start_controls_section(
            'exad_woo_cart_total_heading_section',
            [
				'label' => esc_html__( 'Cart Total Heading', 'exclusive-addons-elementor-pro' ),
				'tab'   => Controls_Manager::TAB_STYLE
            ]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'exad_woo_cart_total_heading_background',
				'label' => __( 'Background', 'exclusive-addons-elementor-pro' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .exad-woo-cart .cart_totals h2',
			]
		);

		$this->add_responsive_control(
			'exad_woo_cart_total_heading_padding',
			[
				'label' => __( 'Padding', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .exad-woo-cart .cart_totals h2' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'exad_woo_cart_total_heading_margin',
			[
				'label' => __( 'Margin', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'default' => [
					'top' => '0',
					'right' => '0',
					'bottom' => '10',
					'left' => '0',
					'unit' => 'px',
					'isLinked' => true,
				],
				'selectors' => [
					'{{WRAPPER}} .exad-woo-cart .cart_totals h2' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'exad_woo_cart_total_heading_typography',
				'label' => __( 'Typography', 'exclusive-addons-elementor-pro' ),
				'selector' => '{{WRAPPER}} .exad-woo-cart .cart_totals h2',
			]
		);

		$this->add_control(
			'exad_woo_cart_total_heading_text_color',
			[
				'label' => __( 'Text Color', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .exad-woo-cart .cart_totals h2' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'exad_woo_cart_total_heading_border',
				'label' => __( 'Border', 'exclusive-addons-elementor-pro' ),
				'selector' => '{{WRAPPER}} .exad-woo-cart .cart_totals h2',
			]
		);

		$this->add_responsive_control(
			'exad_woo_cart_total_heading_border_radius',
			[
				'label' => __( 'Border Radius', 'exclusive-addons-elementor-pro' ),
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
					'{{WRAPPER}} .exad-woo-cart .cart_totals h2' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		/**
		 * Cart Total Table Section
		 */

        $this->start_controls_section(
            'exad_woo_cart_total_table_section',
            [
				'label' => esc_html__( 'Cart Total Table', 'exclusive-addons-elementor-pro' ),
				'tab'   => Controls_Manager::TAB_STYLE
            ]
		);

		$this->add_responsive_control(
			'exad_woo_cart_total_table_padding',
			[
				'label' => __( 'Padding', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'default' => [
					'top' => '15',
					'right' => '20',
					'bottom' => '15',
					'left' => '20',
					'unit' => 'px',
					'isLinked' => false,
				],
				'selectors' => [
					'{{WRAPPER}} .exad-woo-cart .cart_totals tr th' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .exad-woo-cart .cart_totals tr td' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'exad_woo_cart_total_table_border',
				'label' => __( 'Border', 'exclusive-addons-elementor-pro' ),
				'selector' => '{{WRAPPER}} .exad-woo-cart .cart_totals tr th, {{WRAPPER}} .exad-woo-cart .cart_totals tr td, {{WRAPPER}} .exad-woo-cart .cart_totals table',
			]
		);

		$this->add_control(
			'exad_woo_cart_total_table_heading',
			[
				'label' => __( 'Heading', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'exad_woo_cart_total_table_heading_background',
			[
				'label'     => esc_html__( 'Background Color', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .exad-woo-cart .cart_totals tr th' => 'background: {{VALUE}};'
				]
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'exad_woo_cart_total_table_heading_typography',
				'label' => __( 'Typography', 'exclusive-addons-elementor-pro' ),
				'selector' => '{{WRAPPER}} .exad-woo-cart .cart_totals tr th',
			]
		);

		$this->add_control(
			'exad_woo_cart_total_table_heading_text_color',
			[
				'label'     => esc_html__( 'Text Color', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .exad-woo-cart .cart_totals tr th' => 'color: {{VALUE}};'
				]
			]
		);

		$this->add_control(
			'exad_woo_cart_total_table_price_heading',
			[
				'label' => __( 'Price', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'exad_woo_cart_total_table_price_alignment',
			[
				'label' => __( 'Alignment', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => __( 'Left', 'exclusive-addons-elementor-pro' ),
						'icon' => 'fa fa-align-left',
					],
					'right' => [
						'title' => __( 'Right', 'exclusive-addons-elementor-pro' ),
						'icon' => 'fa fa-align-right',
					],
				],
				'default' => 'left',
				'toggle' => true,
				'selectors' => [
					'{{WRAPPER}} .exad-woo-cart .cart_totals tr td' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'exad_woo_cart_total_table_price_background',
			[
				'label'     => esc_html__( 'Background Color', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .exad-woo-cart .cart_totals tr td' => 'background: {{VALUE}};'
				]
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'exad_woo_cart_total_table_price_typography',
				'label' => __( 'Typography', 'exclusive-addons-elementor-pro' ),
				'selector' => '{{WRAPPER}} .exad-woo-cart .cart_totals tr td',
			]
		);

		$this->add_control(
			'exad_woo_cart_total_table_price_text_color',
			[
				'label'     => esc_html__( 'Text Color', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .exad-woo-cart .cart_totals tr td' => 'color: {{VALUE}};'
				]
			]
		);

		$this->end_controls_section();

		/**
		 * Cart Checkout Button Section
		 */

        $this->start_controls_section(
            'exad_woo_cart_checkout_button_section',
            [
				'label' => esc_html__( 'Checkout Button', 'exclusive-addons-elementor-pro' ),
				'tab'   => Controls_Manager::TAB_STYLE
            ]
		);

		$this->add_responsive_control(
			'exad_woo_cart_checkout_button_alignment',
			[
				'label' => __( 'Alignment', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'exad-checkout-button-left' => [
						'title' => __( 'Left', 'exclusive-addons-elementor-pro' ),
						'icon' => 'fa fa-align-left',
					],
					'exad-checkout-button-center' => [
						'title' => __( 'Center', 'exclusive-addons-elementor-pro' ),
						'icon' => 'fa fa-align-center',
					],
					'exad-checkout-button-right' => [
						'title' => __( 'Right', 'exclusive-addons-elementor-pro' ),
						'icon' => 'fa fa-align-right',
					],
					'exad-checkout-button-justify' => [
						'title' => __( 'Justify', 'exclusive-addons-elementor-pro' ),
						'icon' => 'fa fa-align-justify',
					],
				],
				'default' => 'exad-checkout-button-left',
				'toggle' => true,
			]
		);

		$this->add_responsive_control(
			'exad_woo_cart_checkout_button_padding',
			[
				'label' => __( 'Padding', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'default' => [
					'top' => '15',
					'right' => '30',
					'bottom' => '15',
					'left' => '30',
					'unit' => 'px',
					'isLinked' => false,
				],
				'selectors' => [
					'{{WRAPPER}} .exad-woo-cart .cart_totals .wc-proceed-to-checkout .checkout-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'exad_woo_cart_checkout_button_margin',
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
					'{{WRAPPER}} .exad-woo-cart .cart_totals .wc-proceed-to-checkout .checkout-button' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'exad_woo_cart_checkout_button_typography',
				'label' => __( 'Typography', 'exclusive-addons-elementor-pro' ),
				'selector' => '{{WRAPPER}} .exad-woo-cart .cart_totals .wc-proceed-to-checkout .checkout-button',
			]
		);

		$this->add_responsive_control(
			'exad_woo_cart_checkout_button_border_radius',
			[
				'label' => __( 'Border Radius', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'default' => [
					'top' => '5',
					'right' => '5',
					'bottom' => '5',
					'left' => '5',
					'unit' => 'px',
					'isLinked' => true,
				],
				'selectors' => [
					'{{WRAPPER}} .exad-woo-cart .cart_totals .wc-proceed-to-checkout .checkout-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs( 'exad_woo_cart_checkout_button_tabs' );

            // Normal State Tab
			$this->start_controls_tab( 'exad_woo_cart_checkout_button_normal', [ 'label' => esc_html__( 'Normal', 'exclusive-addons-elementor-pro' ) ] );

				$this->add_control(
					'exad_woo_cart_checkout_button_normal_background',
					[
						'label'     => esc_html__( 'Background Color', 'exclusive-addons-elementor-pro' ),
						'type'      => Controls_Manager::COLOR,
						'default'   => '#000000',
						'selectors' => [
							'{{WRAPPER}} .exad-woo-cart .cart_totals .wc-proceed-to-checkout .checkout-button' => 'background: {{VALUE}};'
						]
					]
				);

				$this->add_control(
					'exad_woo_cart_checkout_button_normal_text_color',
					[
						'label'     => esc_html__( 'Text Color', 'exclusive-addons-elementor-pro' ),
						'type'      => Controls_Manager::COLOR,
						'default'   => '#ffffff',
						'selectors' => [
							'{{WRAPPER}} .exad-woo-cart .cart_totals .wc-proceed-to-checkout .checkout-button' => 'color: {{VALUE}};'
						]
					]
				);

				$this->add_group_control(
					Group_Control_Border::get_type(),
					[
						'name' => 'exad_woo_cart_checkout_button_normal_border',
						'label' => __( 'Border', 'exclusive-addons-elementor-pro' ),
						'selector' => '{{WRAPPER}} .exad-woo-cart .cart_totals .wc-proceed-to-checkout .checkout-button',
					]
				);

				$this->add_group_control(
					Group_Control_Box_Shadow::get_type(),
					[
						'name' => 'exad_woo_cart_checkout_button_normal_border',
						'label' => __( 'Box Shadow', 'exclusive-addons-elementor-pro' ),
						'selector' => '{{WRAPPER}} .exad-woo-cart .cart_totals .wc-proceed-to-checkout .checkout-button',
					]
				);
            
            $this->end_controls_tab();

            // Hover State Tab
			$this->start_controls_tab( 'exad_woo_cart_checkout_button_hover', [ 'label' => esc_html__( 'Hover', 'exclusive-addons-elementor-pro' ) ] );
			
				$this->add_control(
					'exad_woo_cart_checkout_button_hover_background',
					[
						'label'     => esc_html__( 'Background Color', 'exclusive-addons-elementor-pro' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .exad-woo-cart .cart_totals .wc-proceed-to-checkout .checkout-button:hover' => 'background: {{VALUE}};'
						]
					]
				);

				$this->add_control(
					'exad_woo_cart_checkout_button_hover_text_color',
					[
						'label'     => esc_html__( 'Text Color', 'exclusive-addons-elementor-pro' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .exad-woo-cart .cart_totals .wc-proceed-to-checkout .checkout-button:hover' => 'color: {{VALUE}};'
						]
					]
				);

				$this->add_group_control(
					Group_Control_Border::get_type(),
					[
						'name' => 'exad_woo_cart_checkout_button_hover_border',
						'label' => __( 'Border', 'exclusive-addons-elementor-pro' ),
						'selector' => '{{WRAPPER}} .exad-woo-cart .cart_totals .wc-proceed-to-checkout .checkout-button:hover',
					]
				);

				$this->add_group_control(
					Group_Control_Box_Shadow::get_type(),
					[
						'name' => 'exad_woo_cart_checkout_button_hover_box_shadow',
						'label' => __( 'Box Shadow', 'exclusive-addons-elementor-pro' ),
						'selector' => '{{WRAPPER}} .exad-woo-cart .cart_totals .wc-proceed-to-checkout .checkout-button:hover',
					]
				);

            $this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		/**
		 * Cart Empty Section
		 */

        $this->start_controls_section(
            'exad_woo_cart_empty_section',
            [
				'label' => esc_html__( 'Cart Empty', 'exclusive-addons-elementor-pro' ),
				'tab'   => Controls_Manager::TAB_STYLE
            ]
		);

		$this->add_responsive_control(
			'exad_woo_cart_empty_padding',
			[
				'label' => __( 'Padding', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'default' => [
					'top' => '15',
					'right' => '30',
					'bottom' => '15',
					'left' => '50',
					'unit' => 'px',
					'isLinked' => false,
				],
				'selectors' => [
					'{{WRAPPER}} .exad-woo-cart .cart-empty' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'exad_woo_cart_empty_margin',
			[
				'label' => __( 'Margin', 'exclusive-addons-elementor-pro' ),
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
					'{{WRAPPER}} .exad-woo-cart .cart-empty' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'exad_woo_cart_empty_background',
				'label' => __( 'Background', 'exclusive-addons-elementor-pro' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .exad-woo-cart .cart-empty',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'exad_woo_cart_empty_typography',
				'label' => __( 'Typography', 'exclusive-addons-elementor-pro' ),
				'selector' => '{{WRAPPER}} .exad-woo-cart .cart-empty',
			]
		);

		$this->add_control(
			'exad_woo_cart_empty_text_color',
			[
				'label'     => esc_html__( 'Text Color', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .exad-woo-cart .cart-empty' => 'color: {{VALUE}};',
				]
			]
		);

		$this->add_control(
			'exad_woo_cart_empty_icon_color',
			[
				'label'     => esc_html__( 'Icon Color', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .exad-woo-cart .cart-empty::before' => 'color: {{VALUE}};'
				]
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'exad_woo_cart_empty_border',
				'label' => __( 'Border', 'exclusive-addons-elementor-pro' ),
				'selector' => '{{WRAPPER}} .exad-woo-cart .cart-empty',
			]
		);

		$this->add_responsive_control(
			'exad_woo_cart_empty_border_radius',
			[
				'label' => __( 'Border Radous', 'exclusive-addons-elementor-pro' ),
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
					'{{WRAPPER}} .exad-woo-cart .cart-empty' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'exad_woo_cart_empty_box_shadow',
				'label' => __( 'Box Shadow', 'exclusive-addons-elementor-pro' ),
				'selector' => '{{WRAPPER}} .exad-woo-cart .cart-empty',
			]
		);

		$this->end_controls_section();

		/**
		 * Cart Return To shop Button Section
		 */

        $this->start_controls_section(
            'exad_woo_cart_return_shop_button_section',
            [
				'label' => esc_html__( 'Return to Shop Button', 'exclusive-addons-elementor-pro' ),
				'tab'   => Controls_Manager::TAB_STYLE
            ]
		);

		$this->add_responsive_control(
			'exad_woo_cart_return_shop_button_padding',
			[
				'label' => __( 'Padding', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'default' => [
					'top' => '15',
					'right' => '30',
					'bottom' => '15',
					'left' => '30',
					'unit' => 'px',
					'isLinked' => false,
				],
				'selectors' => [
					'{{WRAPPER}} .exad-woo-cart .return-to-shop a.button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'exad_woo_cart_return_shop_button_margin',
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
					'{{WRAPPER}} .exad-woo-cart .return-to-shop a.button' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'exad_woo_cart_return_shop_button_typography',
				'label' => __( 'Typography', 'exclusive-addons-elementor-pro' ),
				'selector' => '{{WRAPPER}} .exad-woo-cart .return-to-shop a.button',
			]
		);

		$this->add_responsive_control(
			'exad_woo_cart_return_shop_button_border_radius',
			[
				'label' => __( 'Border Radius', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'default' => [
					'top' => '5',
					'right' => '5',
					'bottom' => '5',
					'left' => '5',
					'unit' => 'px',
					'isLinked' => true,
				],
				'selectors' => [
					'{{WRAPPER}} .exad-woo-cart .return-to-shop a.button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs( 'exad_woo_cart_return_shop_button_tabs' );

            // Normal State Tab
			$this->start_controls_tab( 'exad_woo_cart_return_shop_button_normal', [ 'label' => esc_html__( 'Normal', 'exclusive-addons-elementor-pro' ) ] );

				$this->add_control(
					'exad_woo_cart_return_shop_button_normal_background',
					[
						'label'     => esc_html__( 'Background Color', 'exclusive-addons-elementor-pro' ),
						'type'      => Controls_Manager::COLOR,
						'default'   => '#000000',
						'selectors' => [
							'{{WRAPPER}} .exad-woo-cart .return-to-shop a.button' => 'background: {{VALUE}};'
						]
					]
				);

				$this->add_control(
					'exad_woo_cart_return_shop_button_normal_text_color',
					[
						'label'     => esc_html__( 'Text Color', 'exclusive-addons-elementor-pro' ),
						'type'      => Controls_Manager::COLOR,
						'default'   => '#ffffff',
						'selectors' => [
							'{{WRAPPER}} .exad-woo-cart .return-to-shop a.button' => 'color: {{VALUE}};'
						]
					]
				);

				$this->add_group_control(
					Group_Control_Border::get_type(),
					[
						'name' => 'exad_woo_cart_return_shop_button_normal_border',
						'label' => __( 'Border', 'exclusive-addons-elementor-pro' ),
						'selector' => '{{WRAPPER}} .exad-woo-cart .return-to-shop a.button',
					]
				);

				$this->add_group_control(
					Group_Control_Box_Shadow::get_type(),
					[
						'name' => 'exad_woo_cart_return_shop_button_normal_shadow',
						'label' => __( 'Box Shadow', 'exclusive-addons-elementor-pro' ),
						'selector' => '{{WRAPPER}} .exad-woo-cart .return-to-shop a.button',
					]
				);
            
            $this->end_controls_tab();

            // Hover State Tab
			$this->start_controls_tab( 'exad_woo_cart_return_shop_button_hover', [ 'label' => esc_html__( 'Hover', 'exclusive-addons-elementor-pro' ) ] );
			
				$this->add_control(
					'exad_woo_cart_return_shop_button_hover_background',
					[
						'label'     => esc_html__( 'Background Color', 'exclusive-addons-elementor-pro' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .exad-woo-cart .return-to-shop a.button:hover' => 'background: {{VALUE}};'
						]
					]
				);

				$this->add_control(
					'exad_woo_cart_return_shop_button_hover_text_color',
					[
						'label'     => esc_html__( 'Text Color', 'exclusive-addons-elementor-pro' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .exad-woo-cart .return-to-shop a.button:hover' => 'color: {{VALUE}};'
						]
					]
				);

				$this->add_group_control(
					Group_Control_Border::get_type(),
					[
						'name' => 'exad_woo_cart_return_shop_button_hover_border',
						'label' => __( 'Border', 'exclusive-addons-elementor-pro' ),
						'selector' => '{{WRAPPER}} .exad-woo-cart .return-to-shop a.button:hover',
					]
				);

				$this->add_group_control(
					Group_Control_Box_Shadow::get_type(),
					[
						'name' => 'exad_woo_cart_return_shop_button_hover_shadow',
						'label' => __( 'Box Shadow', 'exclusive-addons-elementor-pro' ),
						'selector' => '{{WRAPPER}} .exad-woo-cart .return-to-shop a.button:hover',
					]
				);

            $this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();


		/**
		 * Cross Sell Section
		 */
        $this->start_controls_section(
            'exad_woo_cross_sell_container_section',
            [
				'label' => esc_html__( 'Cross Sell Container', 'exclusive-addons-elementor-pro' ),
				'tab'   => Controls_Manager::TAB_STYLE,
				'condition' => [
                    'exad_woo_cross_sell_display' => 'yes'
                ]
            ]
		);

		$this->add_responsive_control(
			'exad_woo_cross_sell_container_width',
			[
				'label' => __( 'Cross Sell Container Width', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ '%' ],
				'range' => [
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .exad-woo-cart .cross-sells' => 'width: {{SIZE}}%;',
				],
				'condition' => [
					'exad_woo_content_layout' => 'exad-cart-layout-1'
				]
			]
		);

		$this->add_responsive_control(
			'exad_woo_cross_sell_container_top_spacing',
			[
				'label' => __( 'Top Spacing', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .exad-woo-cart .cross-sells' => 'margin-top: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'exad_woo_cross_sell_container_background',
				'label' => __( 'Background', 'exclusive-addons-elementor-pro' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .exad-woo-cart .cross-sells',
			]
		);

		$this->add_responsive_control(
			'exad_woo_cross_sell_container_padding',
			[
				'label' => __( 'Padding', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'default' => [
					'top' => '20',
					'right' => '20',
					'bottom' => '20',
					'left' => '20',
					'unit' => 'px',
					'isLinked' => true,
				],
				'selectors' => [
					'{{WRAPPER}} .exad-woo-cart .cross-sells' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'exad_woo_cross_sell_container_border',
				'label' => __( 'Border', 'exclusive-addons-elementor-pro' ),
				'fields_options'  => [
                    'border' 	  => [
                        'default' => 'solid'
                    ],
                    'width'  	  => [
                        'default' 	 => [
                            'top'    => '1',
                            'right'  => '1',
                            'bottom' => '1',
                            'left'   => '1'
                        ]
                    ],
                    'color' 	  => [
                        'default' => '#dddddd'
                    ]
                ],
				'selector' => '{{WRAPPER}} .exad-woo-cart .cross-sells',
			]
		);

		$this->add_responsive_control(
			'exad_woo_cross_sell_container_border_radius',
			[
				'label' => __( 'Border Radius', 'exclusive-addons-elementor-pro' ),
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
					'{{WRAPPER}} .exad-woo-cart .cross-sells' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'exad_woo_cross_sell_container_box_shadow',
				'label' => __( 'Box Shadow', 'exclusive-addons-elementor-pro' ),
				'selector' => '{{WRAPPER}} .exad-woo-cart .cross-sells',
			]
		);

		$this->end_controls_section();

		/**
		 * Cross sell Heading Section
		 */
        $this->start_controls_section(
            'exad_woo_cross_sell_title_heading_section',
            [
				'label' => esc_html__( 'Cross Sell Heading', 'exclusive-addons-elementor-pro' ),
				'tab'   => Controls_Manager::TAB_STYLE,
				'condition' => [
                    'exad_woo_cross_sell_display' => 'yes'
                ]
            ]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'exad_woo_cross_sell_title_heading_background',
				'label' => __( 'Background', 'exclusive-addons-elementor-pro' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .cart-collaterals .cross-sells > h2',
			]
		);

		$this->add_responsive_control(
			'exad_woo_cross_sell_title_heading_padding',
			[
				'label' => __( 'Padding', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .cart-collaterals .cross-sells > h2' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'exad_woo_cross_sell_title_heading_margin',
			[
				'label' => __( 'Margin', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'default' => [
					'top' => '0',
					'right' => '0',
					'bottom' => '10',
					'left' => '0',
					'unit' => 'px',
					'isLinked' => true,
				],
				'selectors' => [
					'{{WRAPPER}} .cart-collaterals .cross-sells > h2' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'exad_woo_cross_sell_title_heading_typography',
				'label' => __( 'Typography', 'exclusive-addons-elementor-pro' ),
				'selector' => '{{WRAPPER}} .cart-collaterals .cross-sells > h2',
			]
		);

		$this->add_control(
			'exad_woo_cross_sell_title_heading_text_color',
			[
				'label' => __( 'Text Color', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .cart-collaterals .cross-sells > h2' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'exad_woo_cross_sell_title_heading_border',
				'label' => __( 'Border', 'exclusive-addons-elementor-pro' ),
				'selector' => '{{WRAPPER}} .cart-collaterals .cross-sells > h2',
			]
		);

		$this->add_responsive_control(
			'exad_woo_cross_sell_title_heading_border_radius',
			[
				'label' => __( 'Border Radius', 'exclusive-addons-elementor-pro' ),
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
					'{{WRAPPER}} .cart-collaterals .cross-sells > h2' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		/*
		* Cross Sell Content Box Styling Section
		*/
        $this->start_controls_section(
            'exad_woo_cross_sell_content_box_style',
            [
                'label'     => __( 'Cross Sell', 'exclusive-addons-elementor-pro' ),
                'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
                    'exad_woo_cross_sell_display' => 'yes'
                ]
            ]
        );

		$this->add_control(
			'exad_woo_cross_sell_content_box_heading',
			[
				'label'     => __( 'Content Box', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'after'
			]
		);

        $this->add_responsive_control(
            'exad_woo_cross_sell_content_box_align',
            [
                'label'         => esc_html__( 'Alignment', 'exclusive-addons-elementor-pro' ),
                'type'          => Controls_Manager::CHOOSE,
                'default'       => 'left',
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
                'selectors'     => [
                    '{{WRAPPER}} .cart-collaterals .cross-sells .products .product' => 'text-align: {{VALUE}};'
                ]
            ]
        );

        $this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'exad_woo_cross_sell_content_box_background',
				'types'    => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .cart-collaterals .cross-sells .products .product'
			]
		);

		$this->add_responsive_control(
			'exad_woo_cross_sell_content_box_padding',
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
					'{{WRAPPER}} .cart-collaterals .cross-sells .products .product' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
		);

        $this->add_responsive_control(
			'exad_woo_cross_sell_content_box_radius',
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
					'{{WRAPPER}} .cart-collaterals .cross-sells .products .product' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'exad_woo_cross_sell_content_box_border',
				'selector' => '{{WRAPPER}} .cart-collaterals .cross-sells .products .product'
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'exad_woo_cross_sell_content_box_box_shadow',
				'selector' => '{{WRAPPER}} .cart-collaterals .cross-sells .products .product'
			]
		);

		$this->add_control(
			'exad_woo_cross_sell_content_box_img_heading',
			[
				'label'     => __( 'Image and Tags', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'after'
			]
		);
		$this->add_responsive_control(
            'exad_product_cross_sell_image_height',
            [
                'label'         => esc_html__('Image Height', 'exclusive-addons-elementor-pro' ),
                'type'          => Controls_Manager::SLIDER,
                'selectors'     => [
                    '{{WRAPPER}} .cart-collaterals .cross-sells .products .product a img' => 'height: {{SIZE}}{{UNIT}};'
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
                    '{{WRAPPER}} .cart-collaterals .cross-sells .products .product img' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ]
            ]
        );

		$this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'      => 'exad_product_cross_sell_image_border',
                'selector'  => '{{WRAPPER}} .cart-collaterals .cross-sells .products .product a img'
            ]
        );

        $this->add_responsive_control(
            'exad_product_cross_sell_image_border_radius',
            [
                'label'         => esc_html__( 'Border Radius', 'exclusive-addons-elementor-pro' ),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => [ 'px', '%' ],
                'selectors'     => [
                    '{{WRAPPER}} .cart-collaterals .cross-sells .products .product a img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'      => 'exad_product_cross_sell_image_box_shadow',
                'selector'  => '{{WRAPPER}} .cart-collaterals .cross-sells .products .product a img'        
            ]
        );

		$this->add_control(
            'exad_woo_cross_sell_image_tag_style',
            [
                'label'         => esc_html__( 'Tags', 'exclusive-addons-elementor-pro' ),
                'type'          => Controls_Manager::HEADING,
                'separator'     => 'before'
            ]
        );

        $this->add_responsive_control(
            'exad_woo_cross_sell_image_tag_position',
            [
                'label'         => esc_html__('Position(From Right Side)', 'exclusive-addons-elementor-pro' ),
                'type'          => Controls_Manager::SLIDER, 
				'range'         => [
                    'px'        => [
                        'min'   => 0,
                        'max'   => 40,
                        'step'  => 1
                    ]
				],
				'default'       => [
                    'size'      => 20,
                    'unit'      => 'px'
                ],
                'selectors'     => [
                    '{{WRAPPER}} .cart-collaterals .cross-sells .products .product a span.onsale' => 'right: {{SIZE}}{{UNIT}}; top: {{SIZE}}{{UNIT}};',
                ],                
            ]
        );  

		$this->add_responsive_control(
			'exad_woo_cross_sell_image_tag_width',
			[
				'label' => __( 'Width', 'exclusive-addons-elementor-pro' ),
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
					'size' => 25,
				],
				'selectors' => [
					'{{WRAPPER}} .cart-collaterals .cross-sells .products .product a span.onsale' => 'width: {{SIZE}}{{UNIT}};',
				]
			]
		);

		$this->add_responsive_control(
			'exad_woo_cross_sell_image_tag_height',
			[
				'label' => __( 'Height', 'exclusive-addons-elementor-pro' ),
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
					'size' => 15,
				],
				'selectors' => [
					'{{WRAPPER}} .cart-collaterals .cross-sells .products .product a span.onsale' => 'height: {{SIZE}}{{UNIT}}; line-height: {{SIZE}}{{UNIT}};',
				]
			]
		);

        $this->add_responsive_control(
            'exad_woo_cross_sell_image_tag_padding',
            [
                'label'         => esc_html__( 'Padding', 'exclusive-addons-elementor-pro' ),
                'type'          => Controls_Manager::DIMENSIONS,            
                'size_units'    => [ 'px', 'em', '%' ],
                'selectors'     => [
                        '{{WRAPPER}} .cart-collaterals .cross-sells .products .product a span.onsale' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->add_responsive_control(
            'exad_woo_cross_sell_image_tag_border_radius',
            [
                'label'         => esc_html__( 'Border Radius', 'exclusive-addons-elementor-pro' ),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => [ 'px', '%' ],
                'selectors'     => [
                    '{{WRAPPER}} .cart-collaterals .cross-sells .products .product a span.onsale' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->add_control(
            'exad_woo_cross_sell_image_sale_tag_style',
            [
                'label'         => esc_html__( 'Sale Tag', 'exclusive-addons-elementor-pro' ),
                'type'          => Controls_Manager::HEADING
            ]
        );

        $this->add_control(
            'exad_woo_cross_sell_image_sale_tag_color',
            [
                'label'     => esc_html__( 'Color', 'exclusive-addons-elementor-pro' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .cart-collaterals .cross-sells .products .product a span.onsale' => 'color: {{VALUE}};'
                ]
            ]
        );

        $this->add_control(
            'exad_woo_cross_sell_image_sale_tag_bg_color',
            [
                'label'     => esc_html__( 'Background Color', 'exclusive-addons-elementor-pro' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#3BC473',
                'selectors' => [
                    '{{WRAPPER}} .cart-collaterals .cross-sells .products .product a span.onsale' => 'background-color: {{VALUE}};'
                ]
            ]
        );

		$this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'      => 'exad_woo_cross_sell_image_sale_tag_box_shadow',
                'selector'  => '{{WRAPPER}} .cart-collaterals .cross-sells .products .product a span.onsale'    
            ]
        );

		$this->add_control(
            'exad_woo_cross_sell_title_heading_style',
            [
                'label'         => esc_html__( 'Title', 'exclusive-addons-elementor-pro' ),
                'type'          => Controls_Manager::HEADING,
                'separator'     => 'before'
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'exad_woo_cross_sell_title_typography',
                'selector' => '{{WRAPPER}} .cart-collaterals .cross-sells .products .product a .woocommerce-loop-product__title'
            ]
        );

        $this->add_control(
            'exad_woo_cross_sell_title_color',
            [
                'label'     => esc_html__( 'Color', 'exclusive-addons-elementor-pro' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#000000',
                'selectors' => [
                    '{{WRAPPER}} .cart-collaterals .cross-sells .products .product a .woocommerce-loop-product__title' => 'color: {{VALUE}};'
                ]
            ]
        );

        $this->add_responsive_control(
            'exad_woo_cross_sell_title_margin',
            [
                'label'         => esc_html__( 'Margin', 'exclusive-addons-elementor-pro' ),
                'type'          => Controls_Manager::DIMENSIONS,            
                'size_units'    => [ 'px', 'em', '%' ],
                'selectors'     => [
                        '{{WRAPPER}} .cart-collaterals .cross-sells .products .product a .woocommerce-loop-product__title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

		$this->add_control(
            'exad_woo_cross_sell_price_heading_style',
            [
                'label'         => esc_html__( 'Price', 'exclusive-addons-elementor-pro' ),
                'type'          => Controls_Manager::HEADING,
                'separator'     => 'before'
            ]
        );

		$this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'exad_woo_cross_sell_price_typography',
                'selector' => '{{WRAPPER}} .cart-collaterals .cross-sells .products .product a .price'
            ]
        );

        $this->add_control(
            'exad_woo_cross_sell_price_color',
            [
                'label'     => esc_html__( 'Color', 'exclusive-addons-elementor-pro' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#000000',
                'selectors' => [
                    '{{WRAPPER}} .cart-collaterals .cross-sells .products .product a .price' => 'color: {{VALUE}};'
                ]
            ]
        );

		$this->add_control(
            'exad_woo_cross_sell_price_del_color_switcher',
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
                'name'     => 'exad_woo_cross_sell_price_del_typography',
                'condition'    => [
                    'exad_woo_cross_sell_price_del_color_switcher' => 'yes',
                ],
                'selector' => '{{WRAPPER}} .cart-collaterals .cross-sells .products .product .price del'
            ]
        );

        $this->add_control(
            'exad_woo_cross_sell_price_del_color',
            [
                'label'     => esc_html__( 'Color', 'exclusive-addons-elementor-pro' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#000000',
                'condition'    => [
                    'exad_woo_cross_sell_price_del_color_switcher' => 'yes',
                ],
                'selectors' => [
                    '{{WRAPPER}} .cart-collaterals .cross-sells .products .product .price del' => 'color: {{VALUE}};'
                ]
            ]
        );

        $this->add_responsive_control(
            'exad_woo_cross_sell_price_margin',
            [
                'label'         => esc_html__( 'Margin', 'exclusive-addons-elementor-pro' ),
                'type'          => Controls_Manager::DIMENSIONS,            
                'size_units'    => [ 'px', 'em', '%' ],
                'selectors'     => [
                        '{{WRAPPER}} .cart-collaterals .cross-sells .products .product .price del' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

		$this->add_control(
            'exad_woo_cross_sell_rating_heading_style',
            [
                'label'         => esc_html__( 'Rating', 'exclusive-addons-elementor-pro' ),
                'type'          => Controls_Manager::HEADING,
                'separator'     => 'before'
            ]
        );

		$this->add_responsive_control(
            'exad_woo_cross_sell_star_rating_font_size',
            [
                'label'         => esc_html__('Font Size', 'exclusive-addons-elementor-pro' ),
                'type'          => Controls_Manager::SLIDER,
                'default'       => [
                    'size'      => 18,
                    'unit'      => 'px'
                ],                 
                'range'         => [
                    'px'        => [
                        'min'   => 8,
                        'max'   => 30,
                        'step'  => 1
                    ]
				],
				'selectors'     => [
                    '{{WRAPPER}} .cart-collaterals .cross-sells .products .product a .star-rating' => 'font-size: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};'
                ], 
            ]
        );  

        $this->add_control(
            'exad_woo_cross_sell_star_rating_color',
            [
                'label'         => esc_html__( 'Color', 'exclusive-addons-elementor-pro' ),
                'type'          => Controls_Manager::COLOR, 
                'default'       => '#3BC473',       
                'selectors'     => [
                    '{{WRAPPER}} .cart-collaterals .cross-sells .products .product a .star-rating:before' => 'color: {{VALUE}};',
                ],               
            ]
        );

		$this->add_control(
			'exad_woo_cross_sell_star_rating_active_color',
			[
				'label'     => __( 'Color', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ff5b84',
				'selectors' => [
					'{{WRAPPER}} .cart-collaterals .cross-sells .products .product a .star-rating' => 'color: {{VALUE}};'
				]
			]
		);

        $this->add_responsive_control(
            'exad_woo_cross_sell_star_rating_margin',
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
                    '{{WRAPPER}} .cart-collaterals .cross-sells .products .product a .star-rating' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

		$this->add_control(
            'exad_woo_cross_sell_btn_heading_style',
            [
                'label'         => esc_html__( 'Button', 'exclusive-addons-elementor-pro' ),
                'type'          => Controls_Manager::HEADING,
                'separator'     => 'before'
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'exad_woo_cross_sell_add_to_cart_btn_typography',
                'selector' => '{{WRAPPER}} .cart-collaterals .cross-sells .products .product a.button'
            ]
        );

        $this->add_responsive_control(
            'exad_woo_cross_sell_add_to_cart_btn_padding',
            [
                'label'         => esc_html__( 'Padding', 'exclusive-addons-elementor-pro' ),
                'type'          => Controls_Manager::DIMENSIONS,            
                'size_units'    => [ 'px', 'em', '%' ],
                'selectors'     => [
                        '{{WRAPPER}} .cart-collaterals .cross-sells .products .product a.button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->add_responsive_control(
            'exad_woo_cross_sell_add_to_cart_btn_margin',
            [
                'label'         => esc_html__( 'Margin', 'exclusive-addons-elementor-pro' ),
                'type'          => Controls_Manager::DIMENSIONS,            
                'size_units'    => [ 'px', 'em', '%' ],
                'selectors'     => [
                        '{{WRAPPER}} .cart-collaterals .cross-sells .products .product a.button' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'      => 'exad_woo_cross_sell_add_to_cart_btn_border',
                'selector'  => '{{WRAPPER}} .cart-collaterals .cross-sells .products .product a.button'
            ]
        );

        $this->add_responsive_control(
            'exad_woo_cross_sell_add_to_cart_btn_border_radius',
            [
                'label'         => esc_html__( 'Border Radius', 'exclusive-addons-elementor-pro' ),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => [ 'px', '%' ],
                'selectors'     => [
                    '{{WRAPPER}} .cart-collaterals .cross-sells .products .product a.button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->start_controls_tabs( 'exad_woo_cross_sell_product_add_to_cart_btn_tabs' );

            // Normal State Tab
            $this->start_controls_tab( 'exad_woo_cross_sell_product_add_to_cart_btn_normal', [ 'label' => esc_html__( 'Normal', 'exclusive-addons-elementor-pro' ) ] );

            $this->add_control(
                'exad_woo_cross_sell_add_to_cart_btn_normal_color',
                [
                    'label'     => esc_html__( 'Color', 'exclusive-addons-elementor-pro' ),
                    'type'      => Controls_Manager::COLOR,
                    'default'   => '#ffffff',
                    'selectors' => [
                        '{{WRAPPER}} .cart-collaterals .cross-sells .products .product a.button' => 'color: {{VALUE}};'
                    ]
                ]
            );

            $this->add_control(
                'exad_woo_cross_sell_add_to_cart_btn_normal_bg_color',
                [
                    'label'     => esc_html__( 'Background Color', 'exclusive-addons-elementor-pro' ),
                    'type'      => Controls_Manager::COLOR,
                    'default'   => '#3BC473',
                    'selectors' => [
                        '{{WRAPPER}} .cart-collaterals .cross-sells .products .product a.button' => 'background-color: {{VALUE}};'
                    ]
                ]
            );

            $this->add_control(
                'exad_woo_cross_sell_add_to_cart_btn_normal_border_color',
                [
                    'label'     => esc_html__( 'Border Color', 'exclusive-addons-elementor-pro' ),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .cart-collaterals .cross-sells .products .product a.button' => 'border-color: {{VALUE}};'
                    ]
                ]
            );

            $this->add_group_control(
                Group_Control_Box_Shadow::get_type(),
                [
                    'name'     => 'exad_woo_cross_sell_add_to_cart_btn_normal_shadow',
                    'label'    => __( 'Box Shadow', 'exclusive-addons-elementor-pro' ),
                    'selector' => '{{WRAPPER}} .cart-collaterals .cross-sells .products .product .products li a.button',
                ]
            );
            
            $this->end_controls_tab();

            // Hover State Tab
            $this->start_controls_tab( 'exad_woo_cross_sell_add_to_cart_btn_hover', [ 'label' => esc_html__( 'Hover', 'exclusive-addons-elementor-pro' ) ] );

            $this->add_control(
                'exad_woo_cross_sell_add_to_cart_btn_hover_color',
                [
                    'label'     => esc_html__( 'Color', 'exclusive-addons-elementor-pro' ),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .cart-collaterals .cross-sells .products .product a.button:hover' => 'color: {{VALUE}};'
                    ]
                ]
            );

            $this->add_control(
                'exad_woo_cross_sell_add_to_cart_btn_hover_bg_color',
                [
                    'label'     => esc_html__( 'Background Color', 'exclusive-addons-elementor-pro' ),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .cart-collaterals .cross-sells .products .product a.button:hover' => 'background-color: {{VALUE}};'
                    ]
                ]
            );

            $this->add_control(
                'exad_woo_cross_sell_add_to_cart_btn_hover_border_color',
                [
                    'label'     => esc_html__( 'Border Color', 'exclusive-addons-elementor-pro' ),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .cart-collaterals .cross-sells .products .product a.button:hover' => 'border-color: {{VALUE}};'
                    ]
                ]

            );

            $this->add_group_control(
                Group_Control_Box_Shadow::get_type(),
                [
                    'name'      => 'exad_woo_cross_sell_product_add_to_cart_btn_hover_shadow',
                    'label'     => __( 'Box Shadow', 'exclusive-addons-elementor-pro' ),
                    'selector'  => '{{WRAPPER}} .cart-collaterals .cross-sells .products .product a.button:hover',
                ]
            );

            $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();

		/**
		 * Style Tab Arrows Style
		 */
		$this->start_controls_section(
            'exad_cross_sell_carousel_nav_arrow',
            [
                'label'     => esc_html__( 'Arrows', 'exclusive-addons-elementor-pro' ),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'exad_cross_sell_carousel_nav' => ['arrows', 'arrows-dots', 'arrows-fraction', 'arrows-progress-bar'],
                    'exad_woo_cross_sell_content_setting_layout' => 'carousel-layout',
                ],
            ]
        );

        $this->add_responsive_control(
            'exad_cross_sell_carousel_nav_arrow_box_size',
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
                    'size' => 30,
                ],
                'selectors'  => [
                    '{{WRAPPER}} .exad-woo-cart .cross-sells .product-prev' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .exad-woo-cart .cross-sells .product-next' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'exad_cross_sell_carousel_nav_arrow_icon_size',
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
                    'size' => 14,
                ],
                'selectors'  => [
                    '{{WRAPPER}} .exad-woo-cart .cross-sells .product-prev svg' => 'font-size: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .exad-woo-cart .cross-sells .product-next svg' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        
        $this->add_control(
            'exad_cross_sell_carousel_prev_arrow_position',
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
                'exad_cross_sell_carousel_prev_arrow_position_x_offset',
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
                        'size' => -18,
                    ],
                    'selectors'  => [
                        '{{WRAPPER}} .exad-woo-cart .cross-sells .product-prev' => 'left: {{SIZE}}{{UNIT}};',
                    ],
                ]
            );

            $this->add_responsive_control(
                'exad_cross_sell_carousel_prev_arrow_position_y_offset',
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
                        '{{WRAPPER}} .exad-woo-cart .cross-sells .product-prev' => 'top: {{SIZE}}{{UNIT}};',
                    ],
                ]
            );

        $this->end_popover();

        $this->add_control(
            'exad_cross_sell_carousel_next_arrow_position',
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
                'exad_cross_sell_carousel_next_arrow_position_x_offset',
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
                        'size' => -18,
                    ],
                    'selectors'  => [
                        '{{WRAPPER}} .exad-woo-cart .cross-sells .product-next' => 'right: {{SIZE}}{{UNIT}};',
                    ],
                ]
            );

            $this->add_responsive_control(
                'exad_cross_sell_carousel_next_arrow_position_y_offset',
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
                        '{{WRAPPER}} .exad-woo-cart .cross-sells .product-next' => 'top: {{SIZE}}{{UNIT}};',
                    ],
                ]
            );

        $this->end_popover();

        $this->add_responsive_control(
            'exad_cross_sell_carousel_nav_arrow_radius',
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
                    '{{WRAPPER}} .exad-woo-cart .cross-sells .product-prev' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .exad-woo-cart .cross-sells .product-next' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs( 'exad_cross_sell_carousel_nav_arrow_tabs' );

			// normal state rating
			$this->start_controls_tab( 'exad_cross_sell_carousel_nav_arrow_normal', [ 'label' => esc_html__( 'Normal', 'exclusive-addons-elementor-pro' ) ] );

                $this->add_control(
                    'exad_cross_sell_carousel_arrow_normal_background',
                    [
                        'label'     => __( 'Background Color', 'exclusive-addons-elementor-pro' ),
                        'type'      => Controls_Manager::COLOR,
                        'default'   =>  $exad_primary_color,
                        'selectors' => [
                            '{{WRAPPER}} .exad-woo-cart .cross-sells .product-prev' => 'background: {{VALUE}}',
                            '{{WRAPPER}} .exad-woo-cart .cross-sells .product-next' => 'background: {{VALUE}}',
                        ],
                    ]
                );

                $this->add_control(
                    'exad_cross_sell_carousel_arrow_normal_color',
                    [
                        'label'     => __( 'Icon Color', 'exclusive-addons-elementor-pro' ),
                        'type'      => Controls_Manager::COLOR,
                        'default'   => '#ffffff',
                        'selectors' => [
                            '{{WRAPPER}} .exad-woo-cart .cross-sells .product-prev svg' => 'color: {{VALUE}};',
                            '{{WRAPPER}} .exad-woo-cart .cross-sells .product-next svg' => 'color: {{VALUE}};',
                        ],
                    ]
                );

                $this->add_group_control(
                    Group_Control_Border::get_type(),
                    [
                        'name'     => 'exad_cross_sell_carousel_arrow_normal_border',
                        'label'    => __( 'Border', 'exclusive-addons-elementor-pro' ),
                        'selector' => '{{WRAPPER}} .exad-woo-cart .cross-sells .product-prev, {{WRAPPER}} .exad-woo-cart .cross-sells .product-next',
                    ]
                );

                $this->add_group_control(
                    Group_Control_Box_Shadow::get_type(),
                    [
                        'name'     => 'exad_cross_sell_carousel_arrow_normal_shadow',
                        'label'    => __( 'Box Shadow', 'exclusive-addons-elementor-pro' ),
                        'selector' => '{{WRAPPER}} .exad-woo-cart .cross-sells .product-prev, {{WRAPPER}} .exad-woo-cart .cross-sells .product-next',
                    ]
                );

			$this->end_controls_tab();

			// hover state rating
			$this->start_controls_tab( 'exad_cross_sell_carousel_nav_arrow_hover', [ 'label' => esc_html__( 'Hover', 'exclusive-addons-elementor-pro' ) ] );

                $this->add_control(
                    'exad_cross_sell_carousel_arrow_hover_background',
                    [
                        'label'     => __( 'Background Color', 'exclusive-addons-elementor-pro' ),
                        'type'      => Controls_Manager::COLOR,
                        'default'   => $exad_primary_color,
                        'selectors' => [
                            '{{WRAPPER}} .exad-woo-cart .cross-sells .product-prev:hover' => 'background: {{VALUE}}',
                            '{{WRAPPER}} .exad-woo-cart .cross-sells .product-next:hover' => 'background: {{VALUE}}',
                        ],
                    ]
                );

                $this->add_control(
                    'exad_cross_sell_carousel_arrow_hover_color',
                    [
                        'label'     => __( 'Icon Color', 'exclusive-addons-elementor-pro' ),
                        'type'      => Controls_Manager::COLOR,
                        'default'   => '#ffffff',
                        'selectors' => [
                            '{{WRAPPER}} .exad-woo-cart .cross-sells .product-prev:hover svg' => 'color: {{VALUE}}',
                            '{{WRAPPER}} .exad-woo-cart .cross-sells .product-next:hover svg' => 'color: {{VALUE}}',
                        ],
                    ]
                );

                $this->add_group_control(
                    Group_Control_Border::get_type(),
                    [
                        'name'     => 'exad_cross_sell_carousel_arrow_hover_border',
                        'label'    => __( 'Border', 'exclusive-addons-elementor-pro' ),
                        'selector' => '{{WRAPPER}} .exad-woo-cart .cross-sells .product-prev:hover, {{WRAPPER}} .exad-woo-cart .cross-sells .product-next:hover',
                    ]
                );

                $this->add_group_control(
                    Group_Control_Box_Shadow::get_type(),
                    [
                        'name'     => 'exad_cross_sell_carousel_arrow_hover_shadow',
                        'label'    => __( 'Box Shadow', 'exclusive-addons-elementor-pro' ),
                        'selector' => '{{WRAPPER}} .exad-woo-cart .cross-sells .product-prev:hover, {{WRAPPER}} .exad-woo-cart .cross-sells .product-next:hover',
                    ]
                );

			$this->end_controls_tab();

        $this->end_controls_tabs();

		$this->end_controls_section();

		/**
		* Style Tab Dots Style
		*/
		$this->start_controls_section(
            'exad_cross_sell_carousel_nav_dot',
            [
                'label'     => esc_html__( 'Dots', 'exclusive-addons-elementor-pro' ),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'exad_cross_sell_carousel_nav' => ['nav-dots', 'arrows-dots'],
                    'exad_woo_cross_sell_content_setting_layout' => 'carousel-layout',
                ],
            ]
        );

        $this->add_responsive_control(
            'exad_product_tabs_control_item_cexad_cross_sell_carousel_nav_dot_alignmentontrol_item_alignment',
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
                    '{{WRAPPER}} .exad-woo-cart .cross-sells .exad-dots-container' => '{{VALUE}};'
                ]
            ]
        );      

        $this->add_responsive_control(
            'exad_cross_sell_carousel_dots_top_spacing',
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
                    '{{WRAPPER}} .exad-woo-cart .cross-sells .exad-swiper-pagination' => 'margin-top: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

		$this->add_responsive_control(
			'exad_cross_sell_carousel_dots_spacing_btwn',
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
                    'exad_cross_sell_carousel_nav' => ['nav-dots', 'arrows-dots'],
                ],
				'selectors' => [
					'{{WRAPPER}} .exad-woo-cart .cross-sells .exad-swiper-pagination .swiper-pagination-bullet:not(:last-child)' => 'margin-right: {{SIZE}}{{UNIT}};',
				]
			]
		);

        $this->add_responsive_control(
            'exad_cross_sell_carousel_nav_dot_radius',
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
                    '{{WRAPPER}} .exad-woo-cart .cross-sells .exad-swiper-pagination .swiper-pagination-bullet' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs( 'exad_cross_sell_carousel_nav_dots_tabs' );

			// normal state rating
            $this->start_controls_tab( 'exad_cross_sell_carousel_nav_dots_normal', [ 'label' => esc_html__( 'Normal', 'exclusive-addons-elementor-pro' ) ] );

                $this->add_responsive_control(
                    'exad_cross_sell_carousel_dots_normal_height',
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
                            '{{WRAPPER}} .exad-woo-cart .cross-sells .exad-swiper-pagination .swiper-pagination-bullet' => 'height: {{SIZE}}{{UNIT}};',
                        ],
                    ]
                );

				$this->add_responsive_control(
                    'exad_cross_sell_carousel_dots_normal_width',
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
                            '{{WRAPPER}} .exad-woo-cart .cross-sells .exad-swiper-pagination .swiper-pagination-bullet' => 'width: {{SIZE}}{{UNIT}};',
                        ],
                    ]
                );

                $this->add_control(
                    'exad_cross_sell_carousel_dots_normal_background',
                    [
                        'label'     => __( 'Background Color', 'exclusive-addons-elementor-pro' ),
                        'type'      => Controls_Manager::COLOR,
                        'default'   => '#e5e5e5',
                        'selectors' => [
                            '{{WRAPPER}} .exad-woo-cart .cross-sells .exad-swiper-pagination .swiper-pagination-bullet' => 'background: {{VALUE}};',
                        ],
                    ]
                );
				
				$this->add_responsive_control(
                    'exad_cross_sell_carousel_dots_normal_opacity',
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
                            '{{WRAPPER}} .exad-woo-cart .cross-sells .exad-swiper-pagination .swiper-pagination-bullet' => 'opacity: {{SIZE}};',
                        ],
                    ]
                );

                $this->add_group_control(
                    Group_Control_Border::get_type(),
                    [
                        'name'     => 'exad_cross_sell_carousel_dots_normal_border',
                        'label'    => __( 'Border', 'exclusive-addons-elementor-pro' ),
                        'selector' => '{{WRAPPER}} .exad-woo-cart .cross-sells .exad-swiper-pagination .swiper-pagination-bullet , {{WRAPPER}} .exad-woo-cart .cross-sells .exad-swiper-pagination .swiper-pagination-bullet:hover',
                    ]
                );

			$this->end_controls_tab();

			// hover state rating
            $this->start_controls_tab( 'exad_cross_sell_carousel_nav_dots_hover', [ 'label' => esc_html__( 'Hover/active', 'exclusive-addons-elementor-pro' ) ] );
            
                $this->add_responsive_control(
                    'exad_cross_sell_carousel_dots_active_height',
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
                            '{{WRAPPER}} .exad-woo-cart .cross-sells .exad-swiper-pagination .swiper-pagination-bullet-active' => 'height: {{SIZE}}{{UNIT}};',
                        ],
                    ]
                );

				$this->add_responsive_control(
                    'exad_cross_sell_carousel_dots_active_width',
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
                            '{{WRAPPER}} .exad-woo-cart .cross-sells .exad-swiper-pagination .swiper-pagination-bullet-active' => 'width: {{SIZE}}{{UNIT}};',
                        ],
                    ]
                );

                $this->add_control(
                    'exad_cross_sell_carousel_dots_active_background',
                    [
                        'label'     => __( 'Background Color', 'exclusive-addons-elementor-pro' ),
                        'type'      => Controls_Manager::COLOR,
                        'default'   => $exad_primary_color,
                        'selectors' => [
                            '{{WRAPPER}} .exad-woo-cart .cross-sells .exad-swiper-pagination .swiper-pagination-bullet-active' => 'background: {{VALUE}};',
                            '{{WRAPPER}} .exad-woo-cart .cross-sells .exad-swiper-pagination .swiper-pagination-bullet:hover' => 'background: {{VALUE}};',
                        ],
                    ]
                );

				$this->add_responsive_control(
                    'exad_cross_sell_carousel_dots_hover_opacity',
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
							'{{WRAPPER}} .exad-woo-cart .cross-sells .exad-swiper-pagination .swiper-pagination-bullet-active' => 'opacity: {{SIZE}};',
                            '{{WRAPPER}} .exad-woo-cart .cross-sells .exad-swiper-pagination .swiper-pagination-bullet:hover' => 'opacity: {{SIZE}};',
                        ],
                    ]
                );

                $this->add_group_control(
                    Group_Control_Border::get_type(),
                    [
                        'name'     => 'exad_cross_sell_carousel_dots_active_border',
                        'label'    => __( 'Border', 'exclusive-addons-elementor-pro' ),
                        'selector' => '{{WRAPPER}} .exad-woo-cart .cross-sells .exad-swiper-pagination .swiper-pagination-bullet-active, {{WRAPPER}} .exad-woo-cart .cross-sells .exad-swiper-pagination .swiper-pagination-bullet:hover',
                    ]
                );

			$this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();

        /**
		* Style Tab Fraction Style
		*/
		$this->start_controls_section(
            'exad_cross_sell_carousel_nav_fraction',
            [
                'label'     => esc_html__( 'Fraction', 'exclusive-addons-elementor-pro' ),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'exad_cross_sell_carousel_nav' => ['fraction', 'arrows-fraction'],
                    'exad_woo_cross_sell_content_setting_layout' => 'carousel-layout',
                ],
            ]
        );

        $this->add_control(
            'exad_cross_sell_carousel_nav_fraction_alignment',
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
            'exad_cross_sell_carousel_fraction_top_spacing',
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
                    '{{WRAPPER}} .exad-woo-cart .cross-sells .exad-swiper-pagination' => 'margin-top: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
			'exad_cross_sell_carousel_fraction_spacing_btwn',
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
					'{{WRAPPER}} .exad-woo-cart .cross-sells .exad-swiper-pagination.swiper-pagination-fraction .swiper-pagination-current' => 'margin-right: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .exad-woo-cart .cross-sells .exad-swiper-pagination.swiper-pagination-fraction .swiper-pagination-total' => 'margin-left: {{SIZE}}{{UNIT}};',
				]
			]
		);

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'exad_cross_sell_carousel_swiper-pagination_fraction_typography',
                'selector' => '{{WRAPPER}} .exad-woo-cart .cross-sells .exad-swiper-pagination.swiper-pagination-fraction *',
            ]
        );

        $this->add_responsive_control(
            'exad_cross_sell_carousel_nav_fraction_radius',
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
                    '{{WRAPPER}} .exad-woo-cart .cross-sells .exad-swiper-pagination.swiper-pagination-fraction span' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs( 'exad_cross_sell_carousel_nav_fraction_tabs' );
        // normal state rating

            $this->start_controls_tab( 'exad_cross_sell_carousel_nav_fraction_normal', [ 'label' => esc_html__( 'Normal', 'exclusive-addons-elementor-pro' ) ] );
                $this->add_responsive_control(
                    'exad_cross_sell_carousel_fraction_normal_height',
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
                            '{{WRAPPER}} .exad-woo-cart .cross-sells .exad-swiper-pagination.swiper-pagination-fraction .swiper-pagination-total' => 'height: {{SIZE}}{{UNIT}};',
                            '{{WRAPPER}} .exad-woo-cart .cross-sells .exad-swiper-pagination.swiper-pagination-fraction .swiper-pagination-total' => 'line-height: {{SIZE}}{{UNIT}};',
                        ],
                    ]
                );

                $this->add_responsive_control(
                    'exad_cross_sell_carousel_fraction_normal_width',
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
                            '{{WRAPPER}} .exad-woo-cart .cross-sells .exad-swiper-pagination.swiper-pagination-fraction .swiper-pagination-total' => 'width: {{SIZE}}{{UNIT}};',
                        ],
                    ]
                );

                $this->add_control(
                    'exad_cross_sell_carousel_pagination_fraction_color',
                    [
                        'label'     => esc_html__( 'Color', 'exclusive-addons-elementor-pro' ),
                        'type'      => Controls_Manager::COLOR,
                        'default'   => '#000000',
                        'selectors' => [
                            '{{WRAPPER}} .exad-woo-cart .cross-sells .exad-swiper-pagination.swiper-pagination-fraction .swiper-pagination-total' => 'color: {{VALUE}};'
                        ]
                    ]
                );      
                
                $this->add_control(
                    'exad_cross_sell_carousel_fraction_normal_background',
                    [
                        'label'     => __( 'Background Color', 'exclusive-addons-elementor-pro' ),
                        'type'      => Controls_Manager::COLOR,
                        'default'   => '#e5e5e5',
                        'selectors' => [
                            '{{WRAPPER}} .exad-woo-cart .cross-sells .exad-swiper-pagination.swiper-pagination-fraction .swiper-pagination-total' => 'background: {{VALUE}};',
                        ],
                    ]
                );
                
                $this->add_group_control(
                    Group_Control_Border::get_type(),
                    [
                        'name'     => 'exad_cross_sell_carousel_fraction_normal_border',
                        'label'    => __( 'Border', 'exclusive-addons-elementor-pro' ),
                        'selector' => '{{WRAPPER}} .exad-woo-cart .cross-sells .exad-swiper-pagination.swiper-pagination-fraction .swiper-pagination-total',
                    ]
                );
            $this->end_controls_tab();

            // hover state rating
            $this->start_controls_tab( 'exad_cross_sell_carousel_nav_fraction_hover', [ 'label' => esc_html__( 'Hover/active', 'exclusive-addons-elementor-pro' ) ] );
            
                $this->add_responsive_control(
                    'exad_cross_sell_carousel_fraction_active_height',
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
                            '{{WRAPPER}} .exad-woo-cart .cross-sells .exad-swiper-pagination.swiper-pagination-fraction .swiper-pagination-current' => 'height: {{SIZE}}{{UNIT}};',
                            '{{WRAPPER}} .exad-woo-cart .cross-sells .exad-swiper-pagination.swiper-pagination-fraction .swiper-pagination-current' => 'line-height: {{SIZE}}{{UNIT}};',
                        ],
                    ]
                );

				$this->add_responsive_control(
                    'exad_cross_sell_carousel_fraction_active_width',
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
                            '{{WRAPPER}} .exad-woo-cart .cross-sells .exad-swiper-pagination.swiper-pagination-fraction .swiper-pagination-current' => 'width: {{SIZE}}{{UNIT}};',
                        ],
                    ]
                );

                $this->add_control(
                    'exad_cross_sell_carousel_pagination_fraction_current_color',
                    [
                        'label'     => esc_html__( 'Color', 'exclusive-addons-elementor-pro' ),
                        'type'      => Controls_Manager::COLOR,
                        'default'   => '#fff',
                        'selectors' => [
                            '{{WRAPPER}} .exad-woo-cart .cross-sells .exad-swiper-pagination.swiper-pagination-fraction .swiper-pagination-current' => 'color: {{VALUE}};'
                        ]
                    ]
                );     

                $this->add_control(
                    'exad_cross_sell_carousel_fraction_active_background',
                    [
                        'label'     => __( 'Background Color', 'exclusive-addons-elementor-pro' ),
                        'type'      => Controls_Manager::COLOR,
                        'default'   => $exad_primary_color,
                        'selectors' => [
                            '{{WRAPPER}} .exad-woo-cart .cross-sells .exad-swiper-pagination.swiper-pagination-fraction .swiper-pagination-current:hover' => 'background: {{VALUE}};',
                            '{{WRAPPER}} .exad-woo-cart .cross-sells .exad-swiper-pagination.swiper-pagination-fraction .swiper-pagination-current' => 'background: {{VALUE}};',
                        ],
                    ]
                );

                $this->add_group_control(
                    Group_Control_Border::get_type(),
                    [
                        'name'     => 'exad_cross_sell_carousel_fraction_active_border',
                        'label'    => __( 'Border', 'exclusive-addons-elementor-pro' ),
                        'selector' => '{{WRAPPER}} .exad-woo-cart .cross-sells .exad-swiper-pagination.swiper-pagination-fraction .swiper-pagination-current',
                    ]
                );

			$this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

	    /**
		* Style Tab progressbar Style
		*/
		$this->start_controls_section(
            'exad_cross_sell_carousel_nav_progressbar',
            [
                'label'     => esc_html__( 'Progress Bar', 'exclusive-addons-elementor-pro' ),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'exad_cross_sell_carousel_nav' => ['progress-bar', 'arrows-progress-bar'],
                    'exad_woo_cross_sell_content_setting_layout' => 'carousel-layout',
                ],
            ]
        );

        $this->add_control(
            'exad_cross_sell_carousel_nav_progressbar_normal_color',
            [
                'label'     => __( 'Normal Color', 'exclusive-addons-elementor-pro' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#e5e5e5',
                'selectors' => [
                    '{{WRAPPER}} .exad-woo-cart .cross-sells .exad-dots-container .exad-swiper-pagination.swiper-pagination.swiper-pagination-progressbar' => 'background: {{VALUE}};',
                ],
            ]
        );
        
        $this->add_control(
            'exad_cross_sell_carousel_nav_progressbar_active_color',
            [
                'label'     => __( 'Active Color', 'exclusive-addons-elementor-pro' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => $exad_primary_color,
                'separator' => "after",
                'selectors' => [
                    '{{WRAPPER}} .exad-woo-cart .cross-sells .exad-dots-container .exad-swiper-pagination.swiper-pagination.swiper-pagination-progressbar .swiper-pagination-progressbar-fill' => 'background: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
			'exad_cross_sell_carousel_nav_Progress_position',
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
			'exad_cross_sell_carousel_nav_Progress_specing',
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
            'exad_cross_sell_carousel_nav_progressbar_height',
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
                    '{{WRAPPER}} .exad-woo-cart .cross-sells .exad-dots-container .exad-swiper-pagination.swiper-pagination.swiper-pagination-progressbar' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

    }

	public function insertcart_display_quantity_plus() {
		echo '<button class="exad-quantity-plus-btn"></button>';
	}

	public function insertcart_display_quantity_minus() {
		echo '<button class="exad-quantity-minus-btn"></button>';
	}

	public function cross_sell_columns($columns) {

		$settings = $this->get_settings();
		$columns = 4;

		if ( ! empty( $settings['exad_cross_sell_columns'] ) ) {
            $columns = $settings['exad_cross_sell_columns'];
        }
		return $columns;
	}

    protected function render() {
        if( ! class_exists('woocommerce') ) {
	        return;
        }

		$settings = $this->get_settings_for_display();

		if ( "carousel-layout" == $settings['exad_woo_cross_sell_content_setting_layout'] ) {

			// Carousel Settings
			$elementor_viewport_lg = get_option( 'elementor_viewport_lg' );
			$elementor_viewport_md = get_option( 'elementor_viewport_md' );
			$exad_viewport_lg     = !empty($elementor_viewport_lg) ? $elementor_viewport_lg - 1 : 1023;
			$exad_viewport_md     = !empty($elementor_viewport_md) ? $elementor_viewport_md - 1 : 767;
	
			if ( 'nav-dots' == $settings['exad_cross_sell_carousel_nav'] || 'arrows-dots' == $settings['exad_cross_sell_carousel_nav'] ) {
				$swiper_pagination_type = 'bullets';
			} elseif ( 'fraction' == $settings['exad_cross_sell_carousel_nav'] || 'arrows-fraction' == $settings['exad_cross_sell_carousel_nav'] ) {
				$swiper_pagination_type = 'fraction';
			} elseif ( 'progress-bar' == $settings['exad_cross_sell_carousel_nav'] || 'arrows-progress-bar' == $settings['exad_cross_sell_carousel_nav'] ) {
				$swiper_pagination_type = 'progressbar';
			} else {
				$swiper_pagination_type = '';
			}

		   $carousel_data_settings = wp_json_encode(
			   array_filter([
				   "autoplay"           	=> $settings["exad_cross_sell_carousel_autoplay"] ? true : false,
				   "delay" 				=> $settings["exad_cross_sell_carousel_autoplay_speed"] ? true : false,
				   "loop"           		=> $settings["exad_cross_sell_carousel_loop"] ? true : false,
				   "speed"       			=> $settings["exad_cross_sell_carousel_transition_duration"],
				   "pauseOnHover"       	=> $settings["exad_cross_sell_carousel_pause"] ? true : false,
				   "slidesPerView"         => (int) $settings["exad_cross_sell_carousel_slider_per_view_mobile"],
				   "slidesPerColumn" 		=> ($settings["exad_cross_sell_carousel_slides_per_column"] > 1) ? $settings["exad_cross_sell_carousel_slides_per_column"] : false,
				   "centeredSlides"        => $settings["exad_cross_sell_carousel_slide_centered"] ? true : false,
				   "spaceBetween"   		=> $settings['exad_cross_sell_carousel_column_space']['size'],
				   "grabCursor"  			=> ($settings["exad_cross_sell_carousel_grab_cursor"] === "yes") ? true : false,
				   "observer"       		=> ($settings["exad_cross_sell_carousel_observer"]) ? true : false,
				   "observeParents" 		=> ($settings["exad_cross_sell_carousel_observer"]) ? true : false,
				   "breakpoints"     		=> [
   
					   (int) $exad_viewport_md 	=> [
						   "slidesPerView" 	=> (int) $settings["exad_cross_sell_carousel_slider_per_view_tablet"],
						   "spaceBetween"  	=> $settings["exad_cross_sell_carousel_column_space"]["size"],
						   "centeredSlides" => $settings["exad_cross_sell_carousel_slide_centered"] ? true : false,
					   ],
					   (int) $exad_viewport_lg 	=> [
						   "slidesPerView" 	=> (int) $settings["exad_cross_sell_carousel_slider_per_view"],
						   "spaceBetween"  	=> $settings["exad_cross_sell_carousel_column_space"]["size"],
						   "centeredSlides" => $settings["exad_cross_sell_carousel_slide_centered"] ? false : true,
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
		   
		$this->add_render_attribute( '_wrapper', 'class', esc_attr( $settings['exad_cross_sell_carousel_nav_fraction_alignment'] ) );
		if ( 'progress-bar' == $settings['exad_cross_sell_carousel_nav'] || 'arrows-progress-bar' == $settings['exad_cross_sell_carousel_nav']) {
			$this->add_render_attribute( '_wrapper', 'class', esc_attr( $settings['exad_cross_sell_carousel_nav_Progress_position'] ) );
		}

		// Carousel Settings end
   
		$this->add_render_attribute( '_wrapper', 'data-carousel',  $carousel_data_settings );

	   }

		add_action( 'woocommerce_after_quantity_input_field', [ $this, 'insertcart_display_quantity_plus'] );
		add_action( 'woocommerce_before_quantity_input_field',  [ $this, 'insertcart_display_quantity_minus'] );

		add_filter( 'woocommerce_cross_sells_columns', [ $this, 'cross_sell_columns' ] );
		?>

		<?php if ( 'yes' !== $settings['exad_woo_cross_sell_display'] ) {
			remove_action( 'woocommerce_cart_collaterals', 'woocommerce_cross_sell_display' );
		} ?>

		<div class="exad-woo-cart <?php echo $settings['exad_woo_cart_checkout_button_alignment']; ?> <?php echo $settings['exad_woo_content_layout']; ?>">
			<?php echo do_shortcode( '[woocommerce_cart]' ); ?>
		</div>

		<?php
    }
}