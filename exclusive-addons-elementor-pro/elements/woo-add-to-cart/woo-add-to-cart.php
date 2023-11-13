<?php
namespace ExclusiveAddons\Elements;

if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.

use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Border;
use \Elementor\Group_Control_Box_Shadow;
use \Elementor\Group_Control_Typography;
use \Elementor\Widget_Base;
use \Elementor\Group_Control_Background;
use \Elementor\Icons_Manager;
use \ExclusiveAddons\Pro\Elementor\Woo_Mini_cart_helper;

class Woo_Mini_Cart extends Widget_Base {

	public function get_name() {
		return 'exad-woo-add-to-cart';
	}

	public function get_title() {
		return esc_html__( 'Woo Mini Cart', 'exclusive-addons-elementor-pro' );
	}

	public function get_icon() {
		return 'exad exad-logo exad-woo-minicart';
	}

	public function get_categories() {
		return [ 'exclusive-addons-elementor' ];
	}

	public function get_keywords() {
	    return [ 'mini', 'woocommerce', 'cart', 'menu', 'header' ];
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
            'exad_woo_mini_cart_content_section',
            [
                'label' => esc_html__( 'Content', 'exclusive-addons-elementor-pro' ),
            ]
        );

        $this->add_control(
			'exad_woo_mini_cart_icon',
			[
				'label' => __( 'Icon', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::ICONS,
				'default' => [
					'value' => 'fas fa-cart-arrow-down',
					'library' => 'solid',
				],
			]
		);

		$this->add_control(
			'exad_woo_mini_cart_show_price',
			[
				'label' => __( 'Show Price Count', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'exclusive-addons-elementor-pro' ),
				'label_off' => __( 'Hide', 'exclusive-addons-elementor-pro' ),
				'return_value' => 'yes',
				'default' => 'no',
			]
		);

		$this->add_control(
			'exad_woo_mini_cart_visibility',
			[
				'label' => __( 'Cart Bag Visibility', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'hover',
				'options' => [
					'hover'  => __( 'Hover', 'exclusive-addons-elementor-pro' ),
					'click'  => __( 'Click', 'exclusive-addons-elementor-pro' ),
					'fly-out'  => __( 'Fly Out', 'exclusive-addons-elementor-pro' ),
				],
			]
		);

		$this->add_control(
			'exad_woo_mini_cart_bag_title',
			[
				'label' => __( 'Cart Bag Heading', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Items Seleceted', 'exclusive-addons-elementor-pro' ),
			]
		);

		$this->add_control(
			'exad_woo_mini_cart_visibility_animation',
			[
				'label' => __( 'Cart Bag Visibility Animation', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'slide-down',
				'options' => [
					'slide-up'  => __( 'Slide Down', 'exclusive-addons-elementor-pro' ),
					'slide-down'  => __( 'Slide Up', 'exclusive-addons-elementor-pro' ),
					'zoom-down'  => __( 'Zoom Down', 'exclusive-addons-elementor-pro' ),
				],
				'condition' => [
					'exad_woo_mini_cart_visibility!' => 'fly-out'
				]
			]
		);

		$this->add_control(
			'exad_woo_mini_cart_fly_out_appere_position',
			[
				'label' => __( 'Fly Out Appear Position', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'fly-out-appear-position-left' => [
						'title' => __( 'Left', 'exclusive-addons-elementor-pro' ),
						'icon' => 'eicon-arrow-left',
					],
					'fly-out-appear-position-right' => [
						'title' => __( 'Right', 'exclusive-addons-elementor-pro' ),
						'icon' => 'eicon-arrow-right',
					],
				],
				'default' => 'fly-out-appear-position-left',
				'toggle' => true,
				'condition' => [
					'exad_woo_mini_cart_visibility' => 'fly-out'
				]
			]
		);

		$this->add_control(
			'exad_woo_mini_cart_color',
			[
				'label'     => esc_html__( 'Overlay Color', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => 'rgba(0,0,0,.5)',
				'selectors' => [
					'{{WRAPPER}} .exad-woo-mini-cart-wrapper .exad-woo-cart-bag-fly-out-overlay' => 'background-color: {{VALUE}};',
				],
				'condition' => [
					'exad_woo_mini_cart_visibility' => 'fly-out'
				]
			]
		);

		$this->add_control(
			'exad_woo_mini_cart_view_button_alignment',
			[
				'label' => __( 'Button Allignment', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'button-inline',
				'options' => [
					'button-inline'  => __( 'Inline', 'exclusive-addons-elementor-pro' ),
					'button-full-width'  => __( 'Full Width', 'exclusive-addons-elementor-pro' ),
				],
			]
		);

		$this->end_controls_section();

		/**
		 * Cart Icon Style
		 */
		
		$this->start_controls_section(
            'exad_woo_mini_cart_icon_style',
            [
				'label' => esc_html__( 'Cart Icon', 'exclusive-addons-elementor-pro' ),
				'tab'       => Controls_Manager::TAB_STYLE
            ]
		);

		$this->add_control(
			'exad_woo_mini_cart_icon_alignment',
			[
				'label' => __( 'Icon Alignment', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'cart-icon-left' => [
						'title' => __( 'Left', 'exclusive-addons-elementor-pro' ),
						'icon' => 'eicon-text-align-left',
					],
					'cart-icon-center' => [
						'title' => __( 'Center', 'exclusive-addons-elementor-pro' ),
						'icon' => 'eicon-text-align-center',
					],
					'cart-icon-right' => [
						'title' => __( 'Right', 'exclusive-addons-elementor-pro' ),
						'icon' => 'eicon-text-align-right',
					],
				],
				'default' => 'cart-icon-left',
				'toggle' => true,
			]
		);

		$this->add_control(
			'exad_woo_mini_cart_icon_box',
			[
				'label' => __( 'Enable Icon Box', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'exclusive-addons-elementor-pro' ),
				'label_off' => __( 'Hide', 'exclusive-addons-elementor-pro' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->add_responsive_control(
			'exad_woo_mini_cart_icon_box_width',
			[
				'label' => __( 'Width', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 200,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 50,
				],
				'selectors' => [
					'{{WRAPPER}} .exad-woo-mini-cart .exad-woo-cart-icon' => 'width: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'exad_woo_mini_cart_icon_box' => 'yes'
				]
			]
		);

		$this->add_responsive_control(
			'exad_woo_mini_cart_icon_box_height',
			[
				'label' => __( 'Height', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 200,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 50,
				],
				'selectors' => [
					'{{WRAPPER}} .exad-woo-mini-cart .exad-woo-cart-icon' => 'height: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'exad_woo_mini_cart_icon_box' => 'yes'
				]
			]
		);

		$this->add_responsive_control(
			'exad_woo_mini_cart_icon_padding',
			[
				'label' => __( 'Padding', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'default' => [
					'top' => '10',
					'right' => '10',
					'bottom' => '10',
					'left' => '10',
					'unit' => 'px',
					'isLinked' => true
				],
				'selectors' => [
					'{{WRAPPER}} .exad-woo-mini-cart .exad-woo-cart-icon' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [
					'exad_woo_mini_cart_icon_box!' => 'yes'
				]
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'exad_woo_mini_cart_icon_background',
				'label' => __( 'Background', 'exclusive-addons-elementor-pro' ),
				'types' => [ 'classic', 'gradient' ],
				'fields_options'  => [
					'background'  => [
						'default' => 'classic'
					],
					'color'       => [
						'default' => $exad_primary_color
					]
				],
				'selector' => '{{WRAPPER}} .exad-woo-mini-cart .exad-woo-cart-icon',
			]
		);

		$this->add_control(
			'exad_woo_mini_cart_icon_color',
			[
				'label' => __( 'Icon Color', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .exad-woo-mini-cart .exad-woo-cart-icon i' => 'color: {{VALUE}}',
					'{{WRAPPER}} .exad-woo-mini-cart .exad-woo-cart-icon svg path' => 'fill: {{VALUE}}',
				],
			]
		);

		$this->add_responsive_control(
			'exad_woo_mini_cart_icon_size',
			[
				'label' => __( 'Icon Size', 'exclusive-addons-elementor-pro' ),
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
					'size' => 24,
				],
				'selectors' => [
					'{{WRAPPER}} .exad-woo-mini-cart .exad-woo-cart-icon i' => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .exad-woo-mini-cart .exad-woo-cart-icon svg' => 'height: {{SIZE}}{{UNIT}}; width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'exad_woo_mini_cart_icon_border',
				'label' => __( 'Border', 'exclusive-addons-elementor-pro' ),
				'selector' => '{{WRAPPER}} .exad-woo-mini-cart .exad-woo-cart-icon',
			]
		);

		$this->add_responsive_control(
			'exad_woo_mini_cart_icon_border_radius',
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
					'isLinked' => true
				],
				'selectors' => [
					'{{WRAPPER}} .exad-woo-mini-cart .exad-woo-cart-icon' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'exad_woo_mini_cart_icon_box_shadow',
				'label' => __( 'Box Shadow', 'exclusive-addons-elementor-pro' ),
				'selector' => '{{WRAPPER}} .exad-woo-mini-cart .exad-woo-cart-icon',
			]
		);
		
		$this->end_controls_section();

		/**
		 * Cart Count Number Style
		 */

		$this->start_controls_section(
            'exad_woo_mini_cart_count_number_style',
            [
				'label' => esc_html__( 'Cart Count Item Number', 'exclusive-addons-elementor-pro' ),
				'tab'       => Controls_Manager::TAB_STYLE
            ]
		);

		$this->add_control(
			'exad_woo_mini_cart_count_number_box_enable',
			[
				'label' => __( 'Enable Number Box', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'exclusive-addons-elementor-pro' ),
				'label_off' => __( 'Hide', 'exclusive-addons-elementor-pro' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->add_responsive_control(
			'exad_woo_mini_cart_count_number_box_width',
			[
				'label' => __( 'Width', 'exclusive-addons-elementor-pro' ),
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
					'{{WRAPPER}} .exad-woo-mini-cart .exad-woo-cart-icon .exad-cart-items-count-number' => 'width: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'exad_woo_mini_cart_count_number_box_enable' => 'yes'
				]
			]
		);

		$this->add_responsive_control(
			'exad_woo_mini_cart_count_number_box_height',
			[
				'label' => __( 'Height', 'exclusive-addons-elementor-pro' ),
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
					'{{WRAPPER}} .exad-woo-mini-cart .exad-woo-cart-icon .exad-cart-items-count-number' => 'height: {{SIZE}}{{UNIT}}; line-height: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'exad_woo_mini_cart_count_number_box_enable' => 'yes'
				]
			]
		);

		$this->add_control(
			'exad_woo_mini_cart_count_number_position',
			[
				'label' => __( 'Number Position', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::POPOVER_TOGGLE,
				'label_off' => __( 'Default', 'exclusive-addons-elementor-pro' ),
				'label_on' => __( 'Custom', 'exclusive-addons-elementor-pro' ),
				'return_value' => 'yes',
                'default' => 'yes',
			]
		);

		$this->start_popover();

            $this->add_responsive_control(
                'exad_woo_mini_cart_count_number_position_left',
                [
                    'label' => __( 'X Offset', 'exclusive-addons-elementor-pro' ),
                    'type' => Controls_Manager::SLIDER,
                    'size_units' => [ 'px' ],
                    'range' => [
                        'px' => [
                            'min' => -300,
                            'max' => 300,
                            'step' => 1,
                        ]
                    ],
                    'default' => [
                        'unit' => 'px',
                        'size' => 34,
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .exad-woo-mini-cart .exad-woo-cart-icon .exad-cart-items-count-number' => 'left: {{SIZE}}{{UNIT}};',
                    ],
                ]
            );

            $this->add_responsive_control(
                'exad_woo_mini_cart_count_number_position_top',
                [
                    'label' => __( 'Y Offset', 'exclusive-addons-elementor-pro' ),
                    'type' => Controls_Manager::SLIDER,
                    'size_units' => [ 'px' ],
                    'range' => [
                        'px' => [
                            'min' => -300,
                            'max' => 300,
                            'step' => 1,
                        ]
                    ],
                    'default' => [
                        'unit' => 'px',
                        'size' => 0,
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .exad-woo-mini-cart .exad-woo-cart-icon .exad-cart-items-count-number' => 'top: {{SIZE}}{{UNIT}};',
                    ],
                ]
            );
        
        $this->end_popover();

		$this->add_responsive_control(
			'exad_woo_mini_cart_count_number_padding',
			[
				'label' => __( 'Padding', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'default' => [
					'top' => '2',
					'right' => '2',
					'bottom' => '2',
					'left' => '2',
					'unit' => 'px',
					'isLinked' => true
				],
				'selectors' => [
					'{{WRAPPER}} .exad-woo-mini-cart .exad-woo-cart-icon .exad-cart-items-count-number' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [
					'exad_woo_mini_cart_count_number_box_enable!' => 'yes'
				]
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'exad_woo_mini_cart_count_number_background',
				'label' => __( 'Background', 'exclusive-addons-elementor-pro' ),
				'types' => [ 'classic', 'gradient' ],
				'fields_options'  => [
					'background'  => [
						'default' => 'classic'
					],
					'color'       => [
						'default' => '#FF7676'
					]
				],
				'selector' => '{{WRAPPER}} .exad-woo-mini-cart .exad-woo-cart-icon .exad-cart-items-count-number',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'exad_woo_mini_cart_count_number_typography',
				'label' => __( 'Typography', 'exclusive-addons-elementor-pro' ),
				'selector' => '{{WRAPPER}} .exad-woo-mini-cart .exad-woo-cart-icon .exad-cart-items-count-number',
			]
		);

		$this->add_control(
			'exad_woo_mini_cart_count_number_color',
			[
				'label' => __( 'Number Color', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#fff',
				'selectors' => [
					'{{WRAPPER}} .exad-woo-mini-cart .exad-woo-cart-icon .exad-cart-items-count-number' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'exad_woo_mini_cart_count_number_border',
				'label' => __( 'Border', 'exclusive-addons-elementor-pro' ),
				'selector' => '{{WRAPPER}} .exad-woo-mini-cart .exad-woo-cart-icon .exad-cart-items-count-number',
			]
		);

		$this->add_responsive_control(
			'exad_woo_mini_cart_count_number_border_radius',
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
					'isLinked' => true
				],
				'selectors' => [
					'{{WRAPPER}} .exad-woo-mini-cart .exad-woo-cart-icon .exad-cart-items-count-number' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				]
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'exad_woo_mini_cart_count_number_box_shadow',
				'label' => __( 'Box Shadow', 'exclusive-addons-elementor-pro' ),
				'selector' => '{{WRAPPER}} .exad-woo-mini-cart .exad-woo-cart-icon .exad-cart-items-count-number',
			]
		);

		$this->end_controls_section();

		/**
		 * Cart Price Style
		 */

		$this->start_controls_section(
            'exad_woo_mini_cart_count_price_style',
            [
				'label' => esc_html__( 'Cart Total Price', 'exclusive-addons-elementor-pro' ),
				'tab'       => Controls_Manager::TAB_STYLE
            ]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'exad_woo_mini_cart_count_price_typography',
				'label' => __( 'Typography', 'exclusive-addons-elementor-pro' ),
				'selector' => '{{WRAPPER}} .exad-woo-mini-cart .exad-cart-items-count-price',
			]
		);

		$this->add_control(
			'exad_woo_mini_cart_count_price_color',
			[
				'label' => __( 'Price Color', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .exad-woo-mini-cart .exad-cart-items-count-price' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_responsive_control(
			'exad_woo_mini_cart_count_price_left_spacing',
			[
				'label' => __( 'Left Spacing', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 100,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 10,
				],
				'selectors' => [
					'{{WRAPPER}} .exad-woo-mini-cart .exad-cart-items-count-price' => 'margin-left: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		/**
		 * Cart Bag Style
		 */

		$this->start_controls_section(
            'exad_woo_mini_cart_bag_style',
            [
				'label' => esc_html__( 'Cart Bag', 'exclusive-addons-elementor-pro' ),
				'tab'       => Controls_Manager::TAB_STYLE
            ]
		);

		$this->add_control(
			'exad_woo_mini_cart_bag_position',
			[
				'label' => __( 'Cart Bag Position', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'cart-bag-position-left' => [
						'title' => __( 'Left', 'exclusive-addons-elementor-pro' ),
						'icon' => 'eicon-text-align-left',
					],
					'cart-bag-position-right' => [
						'title' => __( 'Right', 'exclusive-addons-elementor-pro' ),
						'icon' => 'eicon-text-align-right',
					],
				],
				'default' => 'cart-bag-position-left',
				'toggle' => true,
				'condition' => [
					'exad_woo_mini_cart_visibility!' => 'fly-out'
				]
			]
		);

		$this->add_responsive_control(
			'exad_woo_mini_cart_bag_width',
			[
				'label' => __( 'Width', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 1000,
						'step' => 1,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 350,
				],
				'selectors' => [
					'{{WRAPPER}} .exad-woo-mini-cart .exad-woo-mini-cart-wrapper .exad-woo-cart-bag' => 'width: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .exad-woo-mini-cart.fly-out.fly-out-appear-position-left .exad-woo-mini-cart-wrapper .exad-woo-cart-bag' => 'width: {{SIZE}}{{UNIT}}; left: calc( 0px - {{SIZE}}{{UNIT}} );',
					'{{WRAPPER}} .exad-woo-mini-cart.fly-out.fly-out-appear-position-right .exad-woo-mini-cart-wrapper .exad-woo-cart-bag' => 'width: {{SIZE}}{{UNIT}}; right: calc( 0px - {{SIZE}}{{UNIT}} );',
					'{{WRAPPER}} .exad-woo-mini-cart.fly-out.fly-out-appear-position-left .exad-woo-mini-cart-wrapper .exad-woo-cart-bag.fly-out-active' => 'left: calc( {{SIZE}}{{UNIT}} - {{SIZE}}{{UNIT}} );',
					'{{WRAPPER}} .exad-woo-mini-cart.fly-out.fly-out-appear-position-right .exad-woo-mini-cart-wrapper .exad-woo-cart-bag.fly-out-active' => 'right: calc( {{SIZE}}{{UNIT}} - {{SIZE}}{{UNIT}} );',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'exad_woo_mini_cart_bag_background',
				'label' => __( 'Background', 'exclusive-addons-elementor-pro' ),
				'types' => [ 'classic', 'gradient' ],
				'fields_options'  => [
					'background'  => [
						'default' => 'classic'
					],
					'color'       => [
						'default' => $exad_primary_color
					]
				],
				'selector' => '{{WRAPPER}} .exad-woo-mini-cart .exad-woo-mini-cart-wrapper .exad-woo-cart-bag',
			]
		);

		$this->add_responsive_control(
			'exad_woo_mini_cart_bag_padding',
			[
				'label' => __( 'Padding', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'default' => [
					'top' => '12',
					'right' => '12',
					'bottom' => '12',
					'left' => '12',
					'unit' => 'px',
					'isLinked' => true
				],
				'selectors' => [
					'{{WRAPPER}} .exad-woo-mini-cart .exad-woo-mini-cart-wrapper .exad-woo-cart-bag' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				]
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'exad_woo_mini_cart_bag_border',
				'label' => __( 'Border', 'exclusive-addons-elementor-pro' ),
				'selector' => '{{WRAPPER}} .exad-woo-mini-cart .exad-woo-mini-cart-wrapper .exad-woo-cart-bag',
			]
		);

		$this->add_responsive_control(
			'exad_woo_mini_cart_bag_border_radius',
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
					'isLinked' => true
				],
				'selectors' => [
					'{{WRAPPER}} .exad-woo-mini-cart .exad-woo-mini-cart-wrapper .exad-woo-cart-bag' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				]
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'exad_woo_mini_cart_bag_box_shadow',
				'label' => __( 'Box Shadow', 'exclusive-addons-elementor-pro' ),
				'selector' => '{{WRAPPER}} .exad-woo-mini-cart .exad-woo-mini-cart-wrapper .exad-woo-cart-bag',
			]
		);

		$this->end_controls_section();

		/**
		 * Cart Heading Style
		 */

		$this->start_controls_section(
            'exad_woo_mini_cart_heading_style',
            [
				'label' => esc_html__( 'Cart Heading', 'exclusive-addons-elementor-pro' ),
				'tab'       => Controls_Manager::TAB_STYLE
            ]
		);

		$this->add_control(
			'exad_woo_mini_cart_heading_alignment',
			[
				'label' => __( 'Alignment', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => __( 'Left', 'exclusive-addons-elementor-pro' ),
						'icon' => 'eicon-text-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'exclusive-addons-elementor-pro' ),
						'icon' => 'eicon-text-align-center',
					],
					'right' => [
						'title' => __( 'Right', 'exclusive-addons-elementor-pro' ),
						'icon' => 'eicon-text-align-right',
					],
				],
				'default' => 'center',
				'toggle' => true,
				'selectors' => [
					'{{WRAPPER}} .exad-woo-mini-cart .exad-woo-mini-cart-wrapper .exad-woo-cart-bag .exad-cart-items-heading' => 'text-align: {{VALUE}};',
				]
			]
		);

		$this->add_responsive_control(
			'exad_woo_mini_cart_heading_margin',
			[
				'label' => __( 'Margin', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'default' => [
					'top' => '0',
					'right' => '0',
					'bottom' => '20',
					'left' => '0',
					'unit' => 'px',
					'isLinked' => true
				],
				'selectors' => [
					'{{WRAPPER}} .exad-woo-mini-cart .exad-woo-mini-cart-wrapper .exad-woo-cart-bag .exad-cart-items-heading' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				]
			]
		);

		$this->add_responsive_control(
			'exad_woo_mini_cart_heading_padding',
			[
				'label' => __( 'Padding', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'default' => [
					'top' => '10',
					'right' => '10',
					'bottom' => '10',
					'left' => '10',
					'unit' => 'px',
					'isLinked' => true
				],
				'selectors' => [
					'{{WRAPPER}} .exad-woo-mini-cart .exad-woo-mini-cart-wrapper .exad-woo-cart-bag .exad-cart-items-heading' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				]
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'exad_woo_mini_cart_heading_background',
				'label' => __( 'Background', 'exclusive-addons-elementor-pro' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .exad-woo-mini-cart .exad-woo-mini-cart-wrapper .exad-woo-cart-bag .exad-cart-items-heading',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'exad_woo_mini_cart_heading_typography',
				'label' => __( 'Typography', 'exclusive-addons-elementor-pro' ),
				'selector' => '{{WRAPPER}} .exad-woo-mini-cart .exad-woo-mini-cart-wrapper .exad-woo-cart-bag .exad-cart-items-heading',
			]
		);

		$this->add_control(
			'exad_woo_mini_cart_heading_color',
			[
				'label'     => esc_html__( 'Text Color', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .exad-woo-mini-cart .exad-woo-mini-cart-wrapper .exad-woo-cart-bag .exad-cart-items-heading' => 'color: {{VALUE}};'
				]
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'exad_woo_mini_cart_heading_border',
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
                        'default' => 'rgba(255,255,255,.5)'
                    ]
                ],
				'selector' => '{{WRAPPER}} .exad-woo-mini-cart .exad-woo-mini-cart-wrapper .exad-woo-cart-bag .exad-cart-items-heading',
			]
		);

		$this->add_responsive_control(
			'exad_woo_mini_cart_heading_border_radius',
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
					'isLinked' => true
				],
				'selectors' => [
					'{{WRAPPER}} .exad-woo-mini-cart .exad-woo-mini-cart-wrapper .exad-woo-cart-bag .exad-cart-items-heading' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				]
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'exad_woo_mini_cart_heading_box_shadow',
				'label' => __( 'Box Shadow', 'exclusive-addons-elementor-pro' ),
				'selector' => '{{WRAPPER}} .exad-woo-mini-cart .exad-woo-mini-cart-wrapper .exad-woo-cart-bag .exad-cart-items-heading',
			]
		);

		$this->end_controls_section();

		/**
		 * Cart Item Style
		 */

		$this->start_controls_section(
            'exad_woo_mini_cart_bag_item_style',
            [
				'label' => esc_html__( 'Cart Item', 'exclusive-addons-elementor-pro' ),
				'tab'       => Controls_Manager::TAB_STYLE
            ]
		);

		$this->add_responsive_control(
			'exad_woo_mini_cart_bag_item_padding',
			[
				'label' => __( 'Padding', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'default' => [
					'top' => '10',
					'right' => '0',
					'bottom' => '10',
					'left' => '0',
					'unit' => 'px',
					'isLinked' => false
				],
				'selectors' => [
					'{{WRAPPER}} .exad-woo-cart-bag ul.woocommerce-mini-cart li.woocommerce-mini-cart-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				]
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'exad_woo_mini_cart_bag_item_border',
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
                        'default' => 'rgba(255,255,255,.5)'
                    ]
                ],
				'selector' => '{{WRAPPER}} .exad-woo-cart-bag ul.woocommerce-mini-cart li.woocommerce-mini-cart-item',
			]
		);

		$this->add_control(
			'exad_woo_mini_cart_bag_item_image_heading',
			[
				'label' => __( 'Image', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'exad_woo_mini_cart_bag_item_image_size',
			[
				'label' => __( 'Image Size', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 300,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 80,
				],
				'selectors' => [
					'{{WRAPPER}} .exad-woo-cart-bag ul.woocommerce-mini-cart li.woocommerce-mini-cart-item a img' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'exad_woo_mini_cart_bag_item_image_border',
				'label' => __( 'Border', 'exclusive-addons-elementor-pro' ),
				'selector' => '{{WRAPPER}} .exad-woo-cart-bag ul.woocommerce-mini-cart li.woocommerce-mini-cart-item a img',
			]
		);

		$this->add_responsive_control(
			'exad_woo_mini_cart_bag_item_image_border_radius',
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
					'isLinked' => true
				],
				'selectors' => [
					'{{WRAPPER}} .exad-woo-cart-bag ul.woocommerce-mini-cart li.woocommerce-mini-cart-item a img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				]
			]
		);

		$this->add_responsive_control(
			'exad_woo_mini_cart_bag_item_image_right_spacing',
			[
				'label' => __( 'Image Right Spacing', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 100,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 20,
				],
				'selectors' => [
					'{{WRAPPER}} .exad-woo-cart-bag ul.woocommerce-mini-cart li.woocommerce-mini-cart-item a img' => 'margin-right: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'exad_woo_mini_cart_bag_item_image_box_shadow',
				'label' => __( 'Box Shadow', 'exclusive-addons-elementor-pro' ),
				'selector' => '{{WRAPPER}} .exad-woo-cart-bag ul.woocommerce-mini-cart li.woocommerce-mini-cart-item a img',
			]
		);

		$this->add_control(
			'exad_woo_mini_cart_bag_item_product_name_heading',
			[
				'label' => __( 'Product Name', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'exad_woo_mini_cart_bag_item_product_name_typography',
				'label' => __( 'Typography', 'exclusive-addons-elementor-pro' ),
				'selector' => '{{WRAPPER}} .exad-woo-cart-bag ul.woocommerce-mini-cart li.woocommerce-mini-cart-item a',
			]
		);

		$this->start_controls_tabs( 'exad_woo_mini_cart_bag_item_product_name_tabs' );

            // Normal State Tab
            $this->start_controls_tab( 'exad_woo_mini_cart_bag_item_product_name_normal', [ 'label' => esc_html__( 'Normal', 'exclusive-addons-elementor-pro' ) ] );

				$this->add_control(
					'exad_woo_mini_cart_bag_item_product_name_color_normal',
					[
						'label'     => esc_html__( 'Text Color', 'exclusive-addons-elementor-pro' ),
						'type'      => Controls_Manager::COLOR,
						'default'   => '#ffffff',
						'selectors' => [
							'{{WRAPPER}} .exad-woo-cart-bag ul.woocommerce-mini-cart li.woocommerce-mini-cart-item a' => 'color: {{VALUE}};'
						]
					]
				);
            
            $this->end_controls_tab();

            // Hover State Tab
            $this->start_controls_tab( 'exad_woo_mini_cart_bag_item_product_name_hover', [ 'label' => esc_html__( 'Hover', 'exclusive-addons-elementor-pro' ) ] );

				$this->add_control(
					'exad_woo_mini_cart_bag_item_product_name_color_hover',
					[
						'label'     => esc_html__( 'Text Color', 'exclusive-addons-elementor-pro' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .exad-woo-cart-bag ul.woocommerce-mini-cart li.woocommerce-mini-cart-item a:hover' => 'color: {{VALUE}};'
						]
					]
				);

            $this->end_controls_tab();

		$this->end_controls_tabs();
		
		$this->add_control(
			'exad_woo_mini_cart_bag_item_product_price_heading',
			[
				'label' => __( 'Product Quantity & Price', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'exad_woo_mini_cart_bag_item_product_price_margin',
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
					'isLinked' => false
				],
				'selectors' => [
					'{{WRAPPER}} .exad-woo-cart-bag ul.woocommerce-mini-cart li.woocommerce-mini-cart-item .quantity' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				]
			]
		);

		$this->start_controls_tabs( 'exad_woo_mini_cart_bag_item_product_price_tabs' );

            // Normal State Tab
			$this->start_controls_tab( 'exad_woo_mini_cart_bag_item_product_quantity', [ 'label' => esc_html__( 'Product Quantity', 'exclusive-addons-elementor-pro' ) ] );
			
				$this->add_group_control(
					Group_Control_Typography::get_type(),
					[
						'name' => 'exad_woo_mini_cart_bag_item_product_quantity_typography',
						'label' => __( 'Typography', 'exclusive-addons-elementor-pro' ),
						'selector' => '{{WRAPPER}} .exad-woo-cart-bag ul.woocommerce-mini-cart li.woocommerce-mini-cart-item .quantity',
					]
				);

				$this->add_control(
					'exad_woo_mini_cart_bag_item_product_quantity_color',
					[
						'label'     => esc_html__( 'Text Color', 'exclusive-addons-elementor-pro' ),
						'type'      => Controls_Manager::COLOR,
						'default'   => '#f5f5f5',
						'selectors' => [
							'{{WRAPPER}} .exad-woo-cart-bag ul.woocommerce-mini-cart li.woocommerce-mini-cart-item .quantity' => 'color: {{VALUE}};'
						]
					]
				);
            
            $this->end_controls_tab();

            // Hover State Tab
			$this->start_controls_tab( 'exad_woo_mini_cart_bag_item_product_price', [ 'label' => esc_html__( 'Product Price', 'exclusive-addons-elementor-pro' ) ] );
			
				$this->add_group_control(
					Group_Control_Typography::get_type(),
					[
						'name' => 'exad_woo_mini_cart_bag_item_product_price_typography',
						'label' => __( 'Typography', 'exclusive-addons-elementor-pro' ),
						'selector' => '{{WRAPPER}} .exad-woo-cart-bag ul.woocommerce-mini-cart li.woocommerce-mini-cart-item .woocommerce-Price-amount',
					]
				);

				$this->add_control(
					'exad_woo_mini_cart_bag_item_product_price_color',
					[
						'label'     => esc_html__( 'Text Color', 'exclusive-addons-elementor-pro' ),
						'type'      => Controls_Manager::COLOR,
						'default'   => '#f5f5f5',
						'selectors' => [
							'{{WRAPPER}} .exad-woo-cart-bag ul.woocommerce-mini-cart li.woocommerce-mini-cart-item .woocommerce-Price-amount' => 'color: {{VALUE}};'
						]
					]
				);

            $this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_control(
			'exad_woo_mini_cart_bag_item_remove_heading',
			[
				'label' => __( 'Remove Item Icon', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'exad_woo_mini_cart_bag_item_remove_icon_box_size',
			[
				'label' => __( 'Remove Icon Box Size', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 50,
						'step' => 1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .exad-woo-cart-bag ul.woocommerce-mini-cart li.woocommerce-mini-cart-item .remove_from_cart_button' => 'height: {{SIZE}}{{UNIT}}; width: {{SIZE}}{{UNIT}}; line-height: calc( {{SIZE}}{{UNIT}} - 5px );',
				],
			]
		);

		$this->add_control(
			'exad_woo_mini_cart_bag_item_remove_icon_background_color',
			[
				'label'     => esc_html__( 'Remove Icon Background Color', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .exad-woo-cart-bag ul.woocommerce-mini-cart li.woocommerce-mini-cart-item .remove_from_cart_button' => 'background: {{VALUE}};'
				]
			]
		);

		$this->add_responsive_control(
			'exad_woo_mini_cart_bag_item_remove_icon_size',
			[
				'label' => __( 'Remove Icon Size', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 50,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 13,
				],
				'selectors' => [
					'{{WRAPPER}} .exad-woo-cart-bag ul.woocommerce-mini-cart li.woocommerce-mini-cart-item .remove_from_cart_button' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'exad_woo_mini_cart_bag_item_remove_icon_color',
			[
				'label'     => esc_html__( 'Remove Icon Color', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .exad-woo-cart-bag ul.woocommerce-mini-cart li.woocommerce-mini-cart-item .remove_from_cart_button' => 'color: {{VALUE}};'
				]
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'exad_woo_mini_cart_bag_item_remove_icon_box_border',
				'label' => __( 'Border', 'exclusive-addons-elementor-pro' ),
				'selector' => '{{WRAPPER}} .exad-woo-cart-bag ul.woocommerce-mini-cart li.woocommerce-mini-cart-item .remove_from_cart_button',
			]
		);

		$this->add_responsive_control(
			'exad_woo_mini_cart_bag_item_remove_icon_border_radius',
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
					'isLinked' => false
				],
				'selectors' => [
					'{{WRAPPER}} .exad-woo-cart-bag ul.woocommerce-mini-cart li.woocommerce-mini-cart-item .remove_from_cart_button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				]
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'exad_woo_mini_cart_bag_item_remove_icon_box_shadow',
				'label' => __( 'Box Shadow', 'exclusive-addons-elementor-pro' ),
				'selector' => '{{WRAPPER}} .exad-woo-cart-bag ul.woocommerce-mini-cart li.woocommerce-mini-cart-item .remove_from_cart_button',
			]
		);

		$this->add_control(
			'exad_woo_mini_cart_bag_item_empty_message_heading',
			[
				'label' => __( 'Empty Product Message', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'exad_woo_mini_cart_bag_item_empty_message_typography',
				'label' => __( 'Typography', 'exclusive-addons-elementor-pro' ),
				'selector' => '{{WRAPPER}} .exad-woo-cart-bag .woocommerce-mini-cart__empty-message',
			]
		);

		$this->add_control(
			'exad_woo_mini_cart_bag_item_empty_message_color',
			[
				'label'     => esc_html__( 'Empty Message Color', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .exad-woo-cart-bag .woocommerce-mini-cart__empty-message' => 'color: {{VALUE}};'
				]
			]
		);

		$this->end_controls_section();

		/**
		 * Cart Subtotal Style
		 */

		$this->start_controls_section(
            'exad_woo_mini_cart_subtotal_style',
            [
				'label' => esc_html__( 'Subtotal', 'exclusive-addons-elementor-pro' ),
				'tab'       => Controls_Manager::TAB_STYLE
            ]
		);

		$this->add_responsive_control(
			'exad_woo_mini_cart_subtotal_margin',
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
					'isLinked' => false
				],
				'selectors' => [
					'{{WRAPPER}} .exad-woo-cart-bag .woocommerce-mini-cart__total' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				]
			]
		);

		$this->add_responsive_control(
			'exad_woo_mini_cart_subtotal_padding',
			[
				'label' => __( 'Padding', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'default' => [
					'top' => '10',
					'right' => '0',
					'bottom' => '10',
					'left' => '0',
					'unit' => 'px',
					'isLinked' => false
				],
				'selectors' => [
					'{{WRAPPER}} .exad-woo-cart-bag .woocommerce-mini-cart__total' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				]
			]
		);

		$this->add_control(
			'exad_woo_mini_cart_subtotal_title_heading',
			[
				'label' => __( 'Sobtotal Title', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'exad_woo_mini_cart_subtotal_title_typography',
				'label' => __( 'Typography', 'exclusive-addons-elementor-pro' ),
				'selector' => '{{WRAPPER}} .exad-woo-cart-bag .woocommerce-mini-cart__total',
			]
		);

		$this->add_control(
			'exad_woo_mini_cart_subtotal_title_color',
			[
				'label'     => esc_html__( 'Text Color', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .exad-woo-cart-bag .woocommerce-mini-cart__total' => 'color: {{VALUE}};'
				]
			]
		);

		$this->add_control(
			'exad_woo_mini_cart_subtotal_price_heading',
			[
				'label' => __( 'Sobtotal Price', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'exad_woo_mini_cart_subtotal_price_typography',
				'label' => __( 'Typography', 'exclusive-addons-elementor-pro' ),
				'selector' => '{{WRAPPER}} .exad-woo-cart-bag .woocommerce-mini-cart__total .woocommerce-Price-amount',
			]
		);

		$this->add_control(
			'exad_woo_mini_cart_subtotal_price_color',
			[
				'label'     => esc_html__( 'Text Color', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .exad-woo-cart-bag .woocommerce-mini-cart__total .woocommerce-Price-amount' => 'color: {{VALUE}};'
				]
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'exad_woo_mini_cart_subtotal_border',
				'label' => __( 'Border', 'exclusive-addons-elementor-pro' ),
				'selector' => '{{WRAPPER}} .exad-woo-cart-bag .woocommerce-mini-cart__total',
			]
		);

		$this->end_controls_section();

		/**
		 * Cart View Cart Style
		 */

		$this->start_controls_section(
            'exad_woo_mini_cart_view_cart_style',
            [
				'label' => esc_html__( 'View Cart Button', 'exclusive-addons-elementor-pro' ),
				'tab'       => Controls_Manager::TAB_STYLE
            ]
		);

		$this->add_responsive_control(
			'exad_woo_mini_cart_view_cart_left_spacing',
			[
				'label' => __( 'Left Spacing', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 100,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 10,
				],
				'selectors' => [
					'{{WRAPPER}} .exad-woo-cart-bag .woocommerce-mini-cart__buttons .wc-forward:first-child' => 'margin-right: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'exad_woo_mini_cart_view_button_alignment' => 'button-inline'
				]
			]
		);

		$this->add_responsive_control(
			'exad_woo_mini_cart_view_cart_bottom_spacing',
			[
				'label' => __( 'Bottom Spacing', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 100,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 10,
				],
				'selectors' => [
					'{{WRAPPER}} .exad-woo-cart-bag .woocommerce-mini-cart__buttons .wc-forward:first-child' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'exad_woo_mini_cart_view_button_alignment' => 'button-full-width'
				]
			]
		);

		$this->add_responsive_control(
			'exad_woo_mini_cart_view_cart_padding',
			[
				'label' => __( 'Padding', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'default' => [
					'top' => '10',
					'right' => '10',
					'bottom' => '10',
					'left' => '10',
					'unit' => 'px',
					'isLinked' => false
				],
				'selectors' => [
					'{{WRAPPER}} .exad-woo-cart-bag .woocommerce-mini-cart__buttons .wc-forward:first-child' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				]
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'exad_woo_mini_cart_view_cart_typography',
				'label' => __( 'Typography', 'exclusive-addons-elementor-pro' ),
				'selector' => '{{WRAPPER}} .exad-woo-cart-bag .woocommerce-mini-cart__buttons .wc-forward:first-child',
			]
		);

		$this->add_responsive_control(
			'exad_woo_mini_cart_view_cart_radius',
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
					'isLinked' => false
				],
				'selectors' => [
					'{{WRAPPER}} .exad-woo-cart-bag .woocommerce-mini-cart__buttons .wc-forward:first-child' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				]
			]
		);

		$this->start_controls_tabs( 'exad_woo_mini_cart_view_cart_tabs' );

            // Normal State Tab
			$this->start_controls_tab( 'exad_woo_mini_cart_view_cart_normal', [ 'label' => esc_html__( 'Normal', 'exclusive-addons-elementor-pro' ) ] );

				$this->add_control(
					'exad_woo_mini_cart_view_cart_normal_background',
					[
						'label'     => esc_html__( 'Background Color', 'exclusive-addons-elementor-pro' ),
						'type'      => Controls_Manager::COLOR,
						'default'   => '#ffffff',
						'selectors' => [
							'{{WRAPPER}} .exad-woo-cart-bag .woocommerce-mini-cart__buttons .wc-forward:first-child' => 'background: {{VALUE}};'
						]
					]
				);

				$this->add_control(
					'exad_woo_mini_cart_view_cart_normal_color',
					[
						'label'     => esc_html__( 'Text Color', 'exclusive-addons-elementor-pro' ),
						'type'      => Controls_Manager::COLOR,
						'default'   => '#000000',
						'selectors' => [
							'{{WRAPPER}} .exad-woo-cart-bag .woocommerce-mini-cart__buttons .wc-forward:first-child' => 'color: {{VALUE}};'
						]
					]
				);

				$this->add_group_control(
					Group_Control_Border::get_type(),
					[
						'name' => 'exad_woo_mini_cart_view_cart_normal_border',
						'label' => __( 'Border', 'exclusive-addons-elementor-pro' ),
						'selector' => '{{WRAPPER}} .exad-woo-cart-bag .woocommerce-mini-cart__buttons .wc-forward:first-child',
					]
				);

				$this->add_group_control(
					Group_Control_Box_Shadow::get_type(),
					[
						'name' => 'exad_woo_mini_cart_view_cart_normal_shadow',
						'label' => __( 'Box Shadow', 'exclusive-addons-elementor-pro' ),
						'selector' => '{{WRAPPER}} .exad-woo-cart-bag .woocommerce-mini-cart__buttons .wc-forward:first-child',
					]
				);
            
            $this->end_controls_tab();

            // Hover State Tab
			$this->start_controls_tab( 'exad_woo_mini_cart_view_cart_hover', [ 'label' => esc_html__( 'Hover', 'exclusive-addons-elementor-pro' ) ] );
			
				$this->add_control(
					'exad_woo_mini_cart_view_cart_hover_background',
					[
						'label'     => esc_html__( 'Background Color', 'exclusive-addons-elementor-pro' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .exad-woo-cart-bag .woocommerce-mini-cart__buttons .wc-forward:first-child:hover' => 'background: {{VALUE}};'
						]
					]
				);

				$this->add_control(
					'exad_woo_mini_cart_view_cart_hover_color',
					[
						'label'     => esc_html__( 'Text Color', 'exclusive-addons-elementor-pro' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .exad-woo-cart-bag .woocommerce-mini-cart__buttons .wc-forward:first-child:hover' => 'color: {{VALUE}};'
						]
					]
				);

				$this->add_group_control(
					Group_Control_Border::get_type(),
					[
						'name' => 'exad_woo_mini_cart_view_cart_hover_border',
						'label' => __( 'Border', 'exclusive-addons-elementor-pro' ),
						'selector' => '{{WRAPPER}} .exad-woo-cart-bag .woocommerce-mini-cart__buttons .wc-forward:first-child:hover',
					]
				);

				$this->add_group_control(
					Group_Control_Box_Shadow::get_type(),
					[
						'name' => 'exad_woo_mini_cart_view_cart_hover_shadow',
						'label' => __( 'Box Shadow', 'exclusive-addons-elementor-pro' ),
						'selector' => '{{WRAPPER}} .exad-woo-cart-bag .woocommerce-mini-cart__buttons .wc-forward:first-child:hover',
					]
				);

            $this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		/**
		 * Cart Check out Style
		 */

		$this->start_controls_section(
            'exad_woo_mini_cart_checkout_style',
            [
				'label' => esc_html__( 'Checkout Button', 'exclusive-addons-elementor-pro' ),
				'tab'       => Controls_Manager::TAB_STYLE
            ]
		);

		$this->add_responsive_control(
			'exad_woo_mini_cart_checkout_padding',
			[
				'label' => __( 'Padding', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'default' => [
					'top' => '10',
					'right' => '10',
					'bottom' => '10',
					'left' => '10',
					'unit' => 'px',
					'isLinked' => false
				],
				'selectors' => [
					'{{WRAPPER}} .exad-woo-cart-bag .woocommerce-mini-cart__buttons .wc-forward:last-child' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				]
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'exad_woo_mini_cart_checkout_typography',
				'label' => __( 'Typography', 'exclusive-addons-elementor-pro' ),
				'selector' => '{{WRAPPER}} .exad-woo-cart-bag .woocommerce-mini-cart__buttons .wc-forward:last-child',
			]
		);

		$this->add_responsive_control(
			'exad_woo_mini_cart_checkout_radius',
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
					'isLinked' => true
				],
				'selectors' => [
					'{{WRAPPER}} .exad-woo-cart-bag .woocommerce-mini-cart__buttons .wc-forward:last-child' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				]
			]
		);

		$this->start_controls_tabs( 'exad_woo_mini_cart_checkout_tabs' );

            // Normal State Tab
			$this->start_controls_tab( 'exad_woo_mini_cart_checkout_normal', [ 'label' => esc_html__( 'Normal', 'exclusive-addons-elementor-pro' ) ] );

				$this->add_control(
					'exad_woo_mini_cart_checkout_normal_background',
					[
						'label'     => esc_html__( 'Background Color', 'exclusive-addons-elementor-pro' ),
						'type'      => Controls_Manager::COLOR,
						'default'   => '#ffffff',
						'selectors' => [
							'{{WRAPPER}} .exad-woo-cart-bag .woocommerce-mini-cart__buttons .wc-forward:last-child' => 'background: {{VALUE}};'
						]
					]
				);

				$this->add_control(
					'exad_woo_mini_cart_checkout_normal_color',
					[
						'label'     => esc_html__( 'Text Color', 'exclusive-addons-elementor-pro' ),
						'type'      => Controls_Manager::COLOR,
						'default'   => '#000000',
						'selectors' => [
							'{{WRAPPER}} .exad-woo-cart-bag .woocommerce-mini-cart__buttons .wc-forward:last-child' => 'color: {{VALUE}};'
						]
					]
				);

				$this->add_group_control(
					Group_Control_Border::get_type(),
					[
						'name' => 'exad_woo_mini_cart_checkout_normal_border',
						'label' => __( 'Border', 'exclusive-addons-elementor-pro' ),
						'selector' => '{{WRAPPER}} .exad-woo-cart-bag .woocommerce-mini-cart__buttons .wc-forward:last-child',
					]
				);

				$this->add_group_control(
					Group_Control_Box_Shadow::get_type(),
					[
						'name' => 'exad_woo_mini_cart_checkout_normal_shadow',
						'label' => __( 'Box Shadow', 'exclusive-addons-elementor-pro' ),
						'selector' => '{{WRAPPER}} .exad-woo-cart-bag .woocommerce-mini-cart__buttons .wc-forward:last-child',
					]
				);
            
            $this->end_controls_tab();

            // Hover State Tab
			$this->start_controls_tab( 'exad_woo_mini_cart_checkout_hover', [ 'label' => esc_html__( 'Hover', 'exclusive-addons-elementor-pro' ) ] );
			
				$this->add_control(
					'exad_woo_mini_cart_checkout_hover_background',
					[
						'label'     => esc_html__( 'Background Color', 'exclusive-addons-elementor-pro' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .exad-woo-cart-bag .woocommerce-mini-cart__buttons .wc-forward:last-child:hover' => 'background: {{VALUE}};'
						]
					]
				);

				$this->add_control(
					'exad_woo_mini_cart_checkout_hover_color',
					[
						'label'     => esc_html__( 'Text Color', 'exclusive-addons-elementor-pro' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .exad-woo-cart-bag .woocommerce-mini-cart__buttons .wc-forward:last-child:hover' => 'color: {{VALUE}};'
						]
					]
				);

				$this->add_group_control(
					Group_Control_Border::get_type(),
					[
						'name' => 'exad_woo_mini_cart_checkout_hover_border',
						'label' => __( 'Border', 'exclusive-addons-elementor-pro' ),
						'selector' => '{{WRAPPER}} .exad-woo-cart-bag .woocommerce-mini-cart__buttons .wc-forward:last-child:hover',
					]
				);

				$this->add_group_control(
					Group_Control_Box_Shadow::get_type(),
					[
						'name' => 'exad_woo_mini_cart_checkout_hover_shadow',
						'label' => __( 'Box Shadow', 'exclusive-addons-elementor-pro' ),
						'selector' => '{{WRAPPER}} .exad-woo-cart-bag .woocommerce-mini-cart__buttons .wc-forward:last-child:hover',
					]
				);

            $this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		/**
		 * Cart Check out Style
		 */

		$this->start_controls_section(
            'exad_woo_mini_cart_flyout_close_button_style',
            [
				'label' => esc_html__( 'Flyout Close Button', 'exclusive-addons-elementor-pro' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'exad_woo_mini_cart_visibility' => 'fly-out'
				]
            ]
		);

		$this->add_responsive_control(
			'exad_woo_mini_cart_flyout_close_button_box_size',
			[
				'label' => __( 'Button Box Size', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					]
				],
				'default' => [
					'unit' => 'px',
					'size' => 25,
				],
				'selectors' => [
					'{{WRAPPER}} .exad-woo-mini-cart .exad-woo-cart-bag-fly-out-close-icon' => 'height: {{SIZE}}{{UNIT}}; width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'exad_woo_mini_cart_flyout_close_button_box_background',
			[
				'label'     => esc_html__( 'Box Background Color', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .exad-woo-mini-cart .exad-woo-cart-bag-fly-out-close-icon' => 'background: {{VALUE}};'
				]
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'exad_woo_mini_cart_flyout_close_button_box_border',
				'label' => __( 'Border', 'exclusive-addons-elementor-pro' ),
				'selector' => '{{WRAPPER}} .exad-woo-mini-cart .exad-woo-cart-bag-fly-out-close-icon',
			]
		);

		$this->add_responsive_control(
			'exad_woo_mini_cart_flyout_close_button_box_border_radius',
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
					'isLinked' => true
				],
				'selectors' => [
					'{{WRAPPER}} .exad-woo-mini-cart .exad-woo-cart-bag-fly-out-close-icon' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'exad_woo_mini_cart_flyout_close_button_box_shadow',
				'label' => __( 'Box Shadow', 'exclusive-addons-elementor-pro' ),
				'selector' => '{{WRAPPER}} .exad-woo-mini-cart .exad-woo-cart-bag-fly-out-close-icon',
			]
		);

		$this->add_responsive_control(
			'exad_woo_mini_cart_flyout_close_button_icon_size',
			[
				'label' => __( 'Close Icon Size', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					]
				],
				'default' => [
					'unit' => 'px',
					'size' => 15,
				],
				'selectors' => [
					'{{WRAPPER}} .exad-woo-mini-cart .exad-woo-cart-bag-fly-out-close-icon:before' => 'height: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .exad-woo-mini-cart .exad-woo-cart-bag-fly-out-close-icon:after' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'exad_woo_mini_cart_flyout_close_button_box_icon_color',
			[
				'label'     => esc_html__( 'Close Icon Color', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#000000',
				'selectors' => [
					'{{WRAPPER}} .exad-woo-mini-cart .exad-woo-cart-bag-fly-out-close-icon:before' => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .exad-woo-mini-cart .exad-woo-cart-bag-fly-out-close-icon:after' => 'background-color: {{VALUE}};'
				]
			]
		);

		$this->add_control(
			'exad_woo_mini_cart_flyout_close_button_position',
			[
				'label' => __( 'Close Button Position', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::POPOVER_TOGGLE,
				'label_off' => __( 'Default', 'exclusive-addons-elementor-pro' ),
				'label_on' => __( 'Custom', 'exclusive-addons-elementor-pro' ),
				'return_value' => 'yes',
                'default' => 'yes',
			]
		);

		$this->start_popover();

            $this->add_responsive_control(
                'exad_woo_mini_cart_flyout_close_button_position_x_offset',
                [
                    'label' => __( 'X Offset', 'exclusive-addons-elementor-pro' ),
                    'type' => Controls_Manager::SLIDER,
                    'size_units' => [ 'px' ],
                    'range' => [
                        'px' => [
                            'min' => 0,
                            'max' => 500,
                            'step' => 1,
                        ]
                    ],
                    'default' => [
                        'unit' => 'px',
                        'size' => 10,
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .exad-woo-mini-cart .exad-woo-cart-bag-fly-out-close-icon' => 'right: {{SIZE}}{{UNIT}};',
                    ],
                ]
            );

            $this->add_responsive_control(
                'exad_woo_mini_cart_flyout_close_button_position_y_offset',
                [
                    'label' => __( 'Y Offset', 'exclusive-addons-elementor-pro' ),
                    'type' => Controls_Manager::SLIDER,
                    'size_units' => [ 'px' ],
                    'range' => [
                        'px' => [
                            'min' => 0,
                            'max' => 1000,
                            'step' => 1,
                        ]
                    ],
                    'default' => [
                        'unit' => 'px',
                        'size' => 10,
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .exad-woo-mini-cart .exad-woo-cart-bag-fly-out-close-icon' => 'top: {{SIZE}}{{UNIT}};',
                    ],
                ]
            );
        
        $this->end_popover();

		$this->end_controls_section();

    }

    protected function render() {
        if( ! class_exists('woocommerce') ) {
	        return;
        }

		$settings = $this->get_settings_for_display();

		$this->add_render_attribute(
            'exad_woo_mini_cart',
            [
                'class'           => [ 'exad-woo-mini-cart', $settings['exad_woo_mini_cart_visibility'], $settings['exad_woo_mini_cart_icon_alignment'], $settings['exad_woo_mini_cart_bag_position'], $settings['exad_woo_mini_cart_fly_out_appere_position'], $settings['exad_woo_mini_cart_visibility_animation'] ],
                'data-visibility' => $settings['exad_woo_mini_cart_visibility'],
            ]
        );
		$this->add_render_attribute(
            'exad_woo_mini_cart_wrapper',
            [
                'class' => ['exad-woo-mini-cart-wrapper', 'exad-cart-icon-box-'.$settings['exad_woo_mini_cart_icon_box'], $settings['exad_woo_mini_cart_view_button_alignment'] ],
            ]
        );
		?>

		<div <?php echo $this->get_render_attribute_string( 'exad_woo_mini_cart' ); ?>>

			<div <?php echo $this->get_render_attribute_string( 'exad_woo_mini_cart_wrapper' ); ?>>
				<span class="exad-woo-cart-icon">
					<?php Icons_Manager::render_icon( $settings['exad_woo_mini_cart_icon'], [ 'aria-hidden' => 'true' ] ); ?>
					<span class="exad-cart-items-count-number">
						<?php echo (( WC()->cart != '' ) ? WC()->cart->get_cart_contents_count() : '' ); ?>
					</span>
				</span>
				<?php if( 'yes' === $settings['exad_woo_mini_cart_show_price'] ){ ?>
					<span class="exad-cart-items-count-price">
						<?php echo (( WC()->cart != '' ) ? WC()->cart->get_cart_total() : '' ); ?>
					</span>
				<?php
				}
				?>
				<div class="exad-woo-cart-bag">
					<div class="exad-cart-items-heading">
						<span class="exad-cart-items-heading-text"><?php echo (( WC()->cart != '' ) )?  WC()->cart->get_cart_contents_count() : '' ; ?></span> 
						<?php echo esc_html( $settings['exad_woo_mini_cart_bag_title'] ); ?>
					</div>
					<div class="widget_shopping_cart_content">
						<?php (( WC()->cart != '' ) ? woocommerce_mini_cart() : '' ); ?>
					</div>
					<?php if( 'fly-out' === $settings['exad_woo_mini_cart_visibility'] ){ ?>
						<div class="exad-woo-cart-bag-fly-out-close-icon"></div>
					<?php } ?>
				</div>
				<?php if( 'fly-out' === $settings['exad_woo_mini_cart_visibility'] ){ ?>
					<div class="exad-woo-cart-bag-fly-out-overlay"></div>
				<?php } ?>
			</div>

		</div>


		<?php
    }
}