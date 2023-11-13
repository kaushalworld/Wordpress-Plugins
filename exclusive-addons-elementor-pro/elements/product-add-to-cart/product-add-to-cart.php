<?php
namespace ExclusiveAddons\Elements;

if ( !defined( 'ABSPATH' ) ) {
    exit;
}
// If this file is called directly, abort.

use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Border;
use \Elementor\Group_Control_Box_Shadow;
use \Elementor\Group_Control_Typography;
use \Elementor\Group_Control_Background;
use \Elementor\Widget_Base;
use \ExclusiveAddons\Pro\Includes\WooBuilder\Woo_Preview_Data;

class Product_Add_to_Cart extends Widget_Base {

    public function get_name() {
        return 'product-add-to-cart';
    }

    public function get_title() {
        return esc_html__( 'Add to Cart', 'exclusive-addons-elementor-pro' );
    }

    public function get_icon() {
        return 'exad exad-logo exad-woo-products';
    }

    public function get_categories() {
        return ['exclusive-addons-elementor'];
    }

    public function get_keywords() {
        return ['product cart', 'add to cart', 'cart button', 'single product cart', 'woo product cart'];
    }

    protected function register_controls() {

        $exad_primary_color = get_option( 'exad_primary_color_option', '#7a56ff' );

        if ( !class_exists( 'woocommerce' ) ) {
            $this->start_controls_section(
                'exad_panel_notice',
                [
                    'label' => __( 'Notice!', 'exclusive-addons-elementor-pro' ),
                ]
            );

            $this->add_control(
                'exad_panel_notice_text',
                [
                    'type'            => Controls_Manager::RAW_HTML,
                    'raw'             => __( '<strong>WooCommerce</strong> is not installed/activated on your site. Please install and activate <a href="plugin-install.php?s=wpcf7&tab=search&type=term" target="_blank">WooCommerce</a> first.',
                        'exclusive-addons-elementor-pro' ),
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
            'exad_product_add_to_cart_content_section',
            [
                'label' => esc_html__( 'Content', 'exclusive-addons-elementor-pro' ),
            ]
        );

		$this->add_control(
			'exad_add_to_cart_button_text',
			[
				'label'      => esc_html__( 'Button Text', 'exclusive-addons-elementor-pro' ),
				'type'       => Controls_Manager::TEXT,
				'default'    => esc_html__( 'Add to Cart', 'exclusive-addons-elementor-pro' ),
			]
		);

		$this->add_control(
			'exad_add_to_cart_view',
			[
				'label' => __( 'Display Style', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'inline-view',
				'options' => [
					'block-view' => __( 'Block', 'exclusive-addons-elementor-pro' ),
					'inline-view' => __( 'Inline', 'exclusive-addons-elementor-pro' ),
				],
				'prefix_class' => 'exad-woo-cart-',
			]
		);

        $this->add_control(
            'exad_woo_add_to_cart_content_update',
            [
                'label' => '<div class="elementor-update-preview" style="display: block;"><div class="elementor-update-preview-button-wrapper" style="display:block;"><button class="elementor-update-preview-button elementor-button elementor-button-success" style="background: #d30c5c; margin: 0 auto; display:block;">Apply Changes</button></div><div class="elementor-update-preview-title" style="display:block;text-align:center;margin-top: 10px;">'. __( 'Hit the button to apply changes if it hasn\'t already.', 'exclusive-addons-elementor-pro' ) .'</div></div>',
                'type' => Controls_Manager::RAW_HTML,
				'separator'  => 'before',
            ]
        );

	

		$this->end_controls_section();

        /**
         * Before & After Section
         */

        $this->start_controls_section(
            'exad_product_add_to_cart_content_before_after_section',
            [
                'label' => esc_html__( 'Before & After', 'exclusive-addons-elementor-pro' ),
            ]
        );

		$this->add_control(
			'product_add_to_cart_before',
			[
				'label'       => esc_html__( 'Show Text Before Cart', 'exclusive-addons-elementor-pro' ),
				'type'        => Controls_Manager::TEXTAREA
			]
        );

		$this->add_control(
			'product_add_to_cart_after',
			[
				'label'       => esc_html__( 'Show Text After Cart', 'exclusive-addons-elementor-pro' ),
				'type'        => Controls_Manager::TEXTAREA
			]
        );

        $this->end_controls_section();

        /**
         * Style Section
         */

		/*
		* Title container Styling Section
		*/
        $this->start_controls_section(
            'exad_product_add_to_cart_container_style_section',
            [
                'label' => esc_html__( 'Container', 'exclusive-addons-elementor-pro' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'exad_product_add_to_cart_container_alignment',
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
                'selectors_dictionary' => [
                    'left'      => 'text-align: left; display: flex; justify-content: flex-start',
					'center'    => 'text-align: center; display: flex; justify-content: center',
					'right'     => 'text-align: right; display: flex; justify-content: flex-end',
                    'justify'   => 'display: block; width: 100%; justify-content: center; text-align: center;',
                ],
                'selectors'     => [
                    '{{WRAPPER}} .exad-product-add-to-cart' => 'text-align: {{VALUE}};'
                ]
            ]
        );

        $this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'exad_product_add_to_cart_container_background',
				'types'    => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .exad-product-add-to-cart'
			]
		);

		$this->add_responsive_control(
			'exad_product_add_to_cart_container_padding',
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
					'{{WRAPPER}} .exad-product-add-to-cart' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
		);

		$this->add_responsive_control(
			'exad_product_add_to_cart_container_margin',
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
					'{{WRAPPER}} .exad-product-add-to-cart' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
        );

        $this->add_responsive_control(
			'exad_product_add_to_cart_container_radius',
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
					'{{WRAPPER}} .exad-product-add-to-cart' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'exad_product_add_to_cart_container_border',
				'selector' => '{{WRAPPER}} .exad-product-add-to-cart'
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'exad_product_add_to_cart_container_box_shadow',
				'selector' => '{{WRAPPER}} .exad-product-add-to-cart'
			]
		);

        $this->end_controls_section();

         /**
         * Quantity Style Section
         */
        $this->start_controls_section(
            'exad_add_to_cart_button_quantity_style',
            [
                'label' => __( 'Quantity', 'exclusive-addons-elementor-pro' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

		$this->add_control(
			'product_add_to_cart_quantity_input_field_style',
			[
				'label'     => __( 'Input Field', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before'
			]
		);

		$this->add_group_control(
            Group_Control_Typography::get_type(),
            array(
                'name'      => 'exad_add_to_cart_quantity_input_field_typography',
                'label'     => __( 'Typography', 'exclusive-addons-elementor-pro' ),
                'selector'  => '{{WRAPPER}} .exad-product-add-to-cart form.cart .quantity input',
            )
        );

		$this->add_responsive_control(
			'exad_add_to_cart_quantity_input_width',
			[
				'label' => __( 'Input Width', 'exclusive-addons-elementor-pro' ),
				'type'  => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%'],
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
					'{{WRAPPER}}:not(.exad-woo-cart-block-view) .exad-product-add-to-cart form.cart .quantity' => 'width: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}}:not(.exad-woo-cart-inline-view) .exad-product-add-to-cart form.cart .quantity' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);
		
		$this->add_responsive_control(
			'exad_add_to_cart_quantity_input_height',
			[
				'label' => __( 'Input Height', 'exclusive-addons-elementor-pro' ),
				'type'  => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .exad-product-add-to-cart form.cart .quantity input' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'exad_add_to_cart_quantity_input_padding',
			[
				'label' => __( 'Input Padding', 'exclusive-addons-elementor-pro' ),
				'type'  => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .exad-product-add-to-cart form.cart .quantity input' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'exad_add_to_cart_quantity_input_background',
			[
				'label'     => esc_html__( 'Input Background Color', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .exad-product-add-to-cart form.cart .quantity input' => 'background: {{VALUE}};'
				]
			]
		);

		$this->add_control(
			'exad_add_to_cart_quantity_input_text_color',
			[
				'label'     => esc_html__( 'Input Text Color', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .exad-product-add-to-cart form.cart .quantity input' => 'color: {{VALUE}};'
				]
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'  => 'exad_add_to_cart_quantity_input_border',
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
				'selector' => '{{WRAPPER}} .exad-product-add-to-cart form.cart .quantity input',
			]
		);

		$this->add_responsive_control(
			'exad_add_to_cart_quantity_input_border_radius',
			[
				'label' => __( 'Input Border Radius', 'exclusive-addons-elementor-pro' ),
				'type'  => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .exad-product-add-to-cart form.cart .quantity input' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .exad-product-add-to-cart form.cart .quantity .exad-quantity-minus-btn' => 'border-radius: {{TOP}}{{UNIT}} 0 0 {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .exad-product-add-to-cart form.cart .quantity .exad-quantity-plus-btn' => 'border-radius: 0 {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} 0;',
				],
			]
		);

		$this->add_control(
			'product_add_to_cart_quantity_input_icon_field_style',
			[
				'label'     => __( 'Quantity Icon', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before'
			]
		);

		
		$this->add_responsive_control(
			'exad_add_to_cart_quantity_icon_width',
			[
				'label' => __( 'Input Icon Width', 'exclusive-addons-elementor-pro' ),
				'type'  => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .exad-product-add-to-cart form.cart .quantity .exad-quantity-minus-btn' => 'width: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .exad-product-add-to-cart form.cart .quantity .exad-quantity-plus-btn' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'exad_add_to_cart_quantity_icon_minus_position',
			[
				'label' => __( 'Quantity Minus Position ', 'exclusive-addons-elementor-pro' ),
				'type'  => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default'      => [
                    'unit'     => 'px',
                    'size'     => 1
                ],
				'selectors' => [
					'{{WRAPPER}} .exad-product-add-to-cart form.cart .quantity .exad-quantity-minus-btn' => 'left: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->add_responsive_control(
			'exad_add_to_cart_quantity_icon_plus_postion',
			[
				'label' => __( 'Quantity Plus Position', 'exclusive-addons-elementor-pro' ),
				'type'  => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default'      => [
                    'unit'     => 'px',
                    'size'     => 1
                ],
				'selectors' => [
					'{{WRAPPER}} .exad-product-add-to-cart form.cart .quantity .exad-quantity-plus-btn' => 'right: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'  => 'exad_add_to_cart_quantity_icon_border',
                'label' => __( 'Border', 'exclusive-addons-elementor-pro' ),
                'selector' => '{{WRAPPER}} .exad-product-add-to-cart form.cart .quantity .exad-quantity-plus-btn, {{WRAPPER}} .exad-product-add-to-cart form.cart .quantity .exad-quantity-minus-btn',
            ]
        );

		$this->add_responsive_control(
			'exad_add_to_cart_quantity_input_border_minus_radius',
			[
				'label' => __( 'Quantity Minus Radius', 'exclusive-addons-elementor-pro' ),
				'type'  => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .exad-product-add-to-cart form.cart .quantity .exad-quantity-minus-btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'exad_add_to_cart_quantity_input_border_plus_radius',
			[
				'label' => __( 'Quantity Plus Radius', 'exclusive-addons-elementor-pro' ),
				'type'  => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .exad-product-add-to-cart form.cart .quantity .exad-quantity-plus-btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs('exad_quantity_normal_style_tabs');
            
        // Button Normal tab
        $this->start_controls_tab(
            'exad_add_to_cart_quantity_normal_style_tab',
            [
                'label' => __( 'Normal', 'exclusive-addons-elementor-pro' ),
            ]
        );
            
		$this->add_control(
			'exad_add_to_cart_quantity_icon_color',
			[
				'label'     => esc_html__( 'Input Icon Color', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .exad-product-add-to-cart form.cart .exad-quantity-minus-btn::before' => 'background: {{VALUE}};',
					'{{WRAPPER}} .exad-product-add-to-cart form.cart .quantity .exad-quantity-plus-btn::before' => 'background: {{VALUE}};',
					'{{WRAPPER}} .exad-product-add-to-cart form.cart .quantity .exad-quantity-plus-btn::after' => 'background: {{VALUE}};'
				]
			]
		);

		$this->add_control(
			'exad_add_to_cart_quantity_icon_background',
			[
				'label'     => esc_html__( 'Input Icon Background', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .exad-product-add-to-cart form.cart .quantity .exad-quantity-minus-btn' => 'background: {{VALUE}};',
					'{{WRAPPER}} .exad-product-add-to-cart form.cart .quantity .exad-quantity-plus-btn' => 'background: {{VALUE}};'
				]
			]
		);

		$this->add_control(
			'exad_add_to_cart_quantity_icon_left_border',
			[
				'label'     => esc_html__( 'Input Icon Left/Right Border Color', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .exad-product-add-to-cart form.cart .quantity .exad-quantity-minus-btn' => 'border-right: 1px solid {{VALUE}};',
					'{{WRAPPER}} .exad-product-add-to-cart form.cart .quantity .exad-quantity-plus-btn' => 'border-left: 1px solid {{VALUE}};'
				]
			]
		);

		$this->end_controls_tab();

        // Button Hover tab
        $this->start_controls_tab(
            'exad_add_to_cart_quantity_hover_style_tab',
            [
                'label' => __( 'Hover', 'exclusive-addons-elementor-pro' ),
            ]
        ); 
            
		$this->add_control(
			'exad_add_to_cart_quantity_hover_icon_color',
			[
				'label'     => esc_html__( 'Input Icon Color', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .exad-product-add-to-cart form.cart .exad-quantity-minus-btn:hover::before' => 'background: {{VALUE}};',
					'{{WRAPPER}} .exad-product-add-to-cart form.cart .quantity .exad-quantity-plus-btn:hover::before' => 'background: {{VALUE}};',
					'{{WRAPPER}} .exad-product-add-to-cart form.cart .quantity .exad-quantity-plus-btn:hover::after' => 'background: {{VALUE}};'
				]
			]
		);

		$this->add_control(
			'exad_add_to_cart_quantity_hover_icon_background',
			[
				'label'     => esc_html__( 'Input Icon Background', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .exad-product-add-to-cart form.cart .quantity .exad-quantity-minus-btn:hover' => 'background: {{VALUE}};',
					'{{WRAPPER}} .exad-product-add-to-cart form.cart .quantity .exad-quantity-plus-btn:hover' => 'background: {{VALUE}};'
				]
			]
		);

		$this->add_control(
			'exad_add_to_cart_quantity_hover_icon_left_border',
			[
				'label'     => esc_html__( 'Input Icon Left/Right Border Color', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .exad-product-add-to-cart form.cart .quantity .exad-quantity-minus-btn:hover' => 'border-right: 1px solid {{VALUE}};',
					'{{WRAPPER}} .exad-product-add-to-cart form.cart .quantity .exad-quantity-plus-btn:hover' => 'border-left: 1px solid {{VALUE}};'
				]
			]
		);

		$this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();

        /**
         * Button Style Section
         */
        $this->start_controls_section(
            'exad_add_to_cart_button_style',
            [
                'label' => __( 'Button', 'exclusive-addons-elementor-pro' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            array(
                'name'      => 'exad_add_to_cart_button_typography',
                'label'     => __( 'Typography', 'exclusive-addons-elementor-pro' ),
                'selector'  => '{{WRAPPER}} .exad-product-add-to-cart .cart button.button',
            )
        );
  
        $this->add_responsive_control(
            'exad_add_to_cart_button_left_spacing',
            [
                'label'         => __( 'Left Spacing', 'exclusive-addons-elementor-pro' ),
                'type'          => Controls_Manager::SLIDER,
                'range'         => [
                    'px'        => [
                        'min'   => 0,
                        'max'   => 100,
                        'step'  => 1
                    ]
                ],
                'size_units'    => [ 'px' ],
                'default'       => [
                    'unit'      => 'px',
					'size'      => 10
                ],
                'selectors'     => [
                    '{{WRAPPER}}:not(.exad-woo-cart-block-view) .exad-product-add-to-cart .cart button.button' => 'margin-left: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}}:not(.exad-woo-cart-inline-view) .exad-product-add-to-cart .cart button.button' => 'margin-top: {{SIZE}}{{UNIT}};'
                ]
            ]
        );

        $this->add_responsive_control(
            'exad_add_to_cart_button_padding',
            [
                'label' => __( 'Padding', 'exclusive-addons-elementor-pro' ),
                'type'  => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em' ],
                'default'       => [
					'top'       => '12',
					'right'     => '45',
					'bottom'    => '12',
					'left'      => '45',
					'unit'      => 'px',
                    'isLinked'  => false
				],
                'selectors' => [
                    '{{WRAPPER}} .exad-product-add-to-cart .cart button.button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                ],
            ]
        );

        $this->add_responsive_control(
            'exad_add_to_cart_button_margin',
            [
                'label' => __( 'Margin', 'exclusive-addons-elementor-pro' ),
                'type'  => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .exad-product-add-to-cart .cart button.button' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                ],
            ]
        );

        $this->add_responsive_control(
            'exad_add_to_cart_add_to_cart_button_border_radius',
            [
                'label' => __( 'Border Radius', 'exclusive-addons-elementor-pro' ),
                'type'  => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'default'    => [
					'top'    => '0',
					'right'  => '0',
					'bottom' => '0',
					'left'   => '0',
					'unit'   => 'px',
                    'isLinked'  => false
				],
                'selectors'  => [
                    '{{WRAPPER}} .exad-product-add-to-cart .cart button.button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'  => 'exad_add_to_cart_button_border',
                'label' => __( 'Border', 'exclusive-addons-elementor-pro' ),
                'fields_options'     => [
                    'border'         => [
                        'default'    => 'solid'
                    ],
                    'width'          => [
                        'default'    => [
                            'top'    => '1',
                            'right'  => '1',
                            'bottom' => '1',
                            'left'   => '1',
                            'isLinked'  => false
                        ]
                    ],
                    'color'          => [
                        'default'    => $exad_primary_color
                    ]
                ],
                'selector' => '{{WRAPPER}} .exad-product-add-to-cart .cart button.button',
            ]
        );

        $this->start_controls_tabs('exad_button_normal_style_tabs');
            
        // Button Normal tab
        $this->start_controls_tab(
            'exad_add_to_cart_normal_style_tab',
            [
                'label' => __( 'Normal', 'exclusive-addons-elementor-pro' ),
            ]
        );
            
        $this->add_control(
            'exad_add_to_cart_button_color',
            [
                'label'     => __( 'Text Color', 'exclusive-addons-elementor-pro' ),
                'type'      => Controls_Manager::COLOR,
                'default'	=> "#fff",
                'selectors' => [
                    '{{WRAPPER}} .exad-product-add-to-cart .cart button.button' => 'color: {{VALUE}} !important;',
                ],
            ]
        );

        $this->add_control(
            'exad_add_to_cart_button_background_color',
            [
                'label' => __( 'Background Color', 'exclusive-addons-elementor-pro' ),
                'type'  => Controls_Manager::COLOR,
                'default'	=> $exad_primary_color,
                'selectors' => [
                    '{{WRAPPER}} .exad-product-add-to-cart .cart button.button' => 'background-color: {{VALUE}} !important',
                ],
            ]
        );

        $this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'exad_add_to_cart_button_box_shadow',
				'selector' => '{{WRAPPER}} .exad-product-add-to-cart .cart button.button'
			]
		);

        $this->end_controls_tab();

        // Button Hover tab
        $this->start_controls_tab(
            'exad_add_to_cart_button_hover_style_tab',
            [
                'label' => __( 'Hover', 'exclusive-addons-elementor-pro' ),
            ]
        ); 
            
        $this->add_control(
            'exad_add_to_cart_button_hover_color',
            [
                'label'     => __( 'Text Color', 'exclusive-addons-elementor-pro' ),
                'type'      => Controls_Manager::COLOR,
                'default'	=> $exad_primary_color,
                'selectors' => [
                    '{{WRAPPER}} .exad-product-add-to-cart .cart button.button:hover' => 'color: {{VALUE}} !important;',
                ],
            ]
        );

        $this->add_control(
            'exad_add_to_cart_button_hover_background_color',
            [
                'label' => __( 'Background Color', 'exclusive-addons-elementor-pro' ),
                'type'  => Controls_Manager::COLOR,
                'default'	=> "#fff",
                'selectors' => [
                    '{{WRAPPER}} .exad-product-add-to-cart .cart button.button:hover' => 'background-color: {{VALUE}} !important',
                ],
            ]
        );

        $this->add_control(
            'exad_add_to_cart_button_hover_border_color',
            [
                'label' => __( 'Border Color', 'exclusive-addons-elementor-pro' ),
                'type'  => Controls_Manager::COLOR,
                'default'	=> $exad_primary_color,
                'selectors' => [
                    '{{WRAPPER}} .exad-product-add-to-cart .cart button.button:hover' => 'border-color: {{VALUE}} !important',
                ],
            ]
        );

        $this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'exad_add_to_cart_button_hover_box_shadow',
				'selector' => '{{WRAPPER}} .exad-product-add-to-cart .cart button.button:hover'
			]
		);

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();

		
	/*
	* Form Cart Styling Section
	*/
	$this->start_controls_section(
		'exad_product_add_to_cart_stock_variation_style_section',
		[
			'label' => esc_html__( 'Stock & variation', 'exclusive-addons-elementor-pro' ),
			'tab'   => Controls_Manager::TAB_STYLE
		]
	);

	$this->add_control(
		'product_add_to_cart_stock_heading_style',
		[
			'label'     => __( 'Stock', 'exclusive-addons-elementor-pro' ),
			'type'      => Controls_Manager::HEADING,
			'separator' => 'before'
		]
	);	

	$this->add_group_control(
		Group_Control_Typography::get_type(),
		array(
			'name'      => 'exad_add_to_cart_button_stock_typography',
			'label'     => __( 'Typography', 'exclusive-addons-elementor-pro' ),
			'selector'  => '{{WRAPPER}} .exad-product-add-to-cart form .single_variation_wrap .woocommerce-variation-availability, {{WRAPPER}} .exad-product-add-to-cart .stock.in-stock',
		)
	);

	$this->add_control(
		'exad_add_to_cart_button_stock_variation_stock_color',
		[
			'label'     => __( 'Stock Color', 'exclusive-addons-elementor-pro' ),
			'type'      => Controls_Manager::COLOR,
			'default'	=> $exad_primary_color,
			'selectors' => [
				'{{WRAPPER}} .exad-product-add-to-cart form .single_variation_wrap .woocommerce-variation-availability' => 'color: {{VALUE}};',
				'{{WRAPPER}} .exad-product-add-to-cart .stock.in-stock' => 'color: {{VALUE}};',
			],
		]
	);

	$this->add_responsive_control(
		'exad_add_to_cart_button_stock_variation_stock_margin',
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
				'{{WRAPPER}} .exad-product-add-to-cart form .single_variation_wrap .woocommerce-variation-availability' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				'{{WRAPPER}} .exad-product-add-to-cart .stock.in-stock' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			]
		]
	);

	$this->add_control(
		'product_add_to_cart_variation_heading_style',
		[
			'label'     => __( 'Variation Price', 'exclusive-addons-elementor-pro' ),
			'type'      => Controls_Manager::HEADING,
			'separator' => 'before'
		]
	);

	$this->add_group_control(
		Group_Control_Typography::get_type(),
		array(
			'name'      => 'exad_add_to_cart_button_variations_price_typography',
			'label'     => __( 'Variation Typography', 'exclusive-addons-elementor-pro' ),
			'selector'  => '{{WRAPPER}} .exad-product-add-to-cart form .single_variation_wrap .woocommerce-variation-price',
		)
	);

	$this->add_control(
		'exad_add_to_cart_button_variation_price_color',
		[
			'label'     => __( 'Variation Price Color', 'exclusive-addons-elementor-pro' ),
			'type'      => Controls_Manager::COLOR,
			'default'	=> $exad_primary_color,
			'selectors' => [
				'{{WRAPPER}} .exad-product-add-to-cart form .single_variation_wrap .woocommerce-variation-price' => 'color: {{VALUE}};',
				'{{WRAPPER}} .exad-product-add-to-cart form .single_variation_wrap .woocommerce-variation-price span' => 'color: {{VALUE}};',
			],
		]
	);

	$this->add_responsive_control(
		'exad_add_to_cart_button_stock_variation_price_margin',
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
				'{{WRAPPER}} .exad-product-add-to-cart form .single_variation_wrap .woocommerce-variation-price' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			]
		]
	);

	$this->add_control(
		'product_add_to_cart_variation_description_heading_style',
		[
			'label'     => __( 'Description', 'exclusive-addons-elementor-pro' ),
			'type'      => Controls_Manager::HEADING,
			'separator' => 'before'
		]
	);

	
	$this->add_control(
		'exad_add_to_cart_button_stock_variation_description_color',
		[
			'label'     => esc_html__( 'Color', 'exclusive-addons-elementor-pro' ),
			'type'      => Controls_Manager::COLOR,
			'default'   => '#000000',
			'selectors' => [
				'{{WRAPPER}} .exad-product-add-to-cart form .single_variation_wrap .woocommerce-variation-description' => 'color: {{VALUE}};'
			]
		]
	);

	$this->add_group_control(
		Group_Control_Typography::get_type(),
		[
			'name'     => 'exad_add_to_cart_button_stock_variation_description_typography',
			'selector' => '{{WRAPPER}} .exad-product-add-to-cart form .single_variation_wrap .woocommerce-variation-description'
		]
	);

	$this->add_responsive_control(
		'exad_add_to_cart_button_stock_variation_description_margin',
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
				'{{WRAPPER}} .exad-product-add-to-cart form .single_variation_wrap .woocommerce-variation-description' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			]
		]
	);

	$this->end_controls_section();

  		/*
		* Form Cart Styling Section
		*/
		$this->start_controls_section(
            'exad_product_add_to_cart_form_style_section',
            [
                'label' => esc_html__( 'Form', 'exclusive-addons-elementor-pro' ),
				'tab'   => Controls_Manager::TAB_STYLE
            ]
        );

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'             => 'exad_product_add_to_cart_form_typography',
				'selector'         => '{{WRAPPER}} .exad-product-add-to-cart table tbody tr td',
			]
		);

		$this->add_control(
			'exad_product_add_to_cart_form_table_row_vertical_alignment',
			[
				'label'   => __( 'Vertical Alignment', 'exclusive-addons-elementor-pro' ),
				'type'    => Controls_Manager::CHOOSE,
				'options' => [
					'top' => [
						'title'  => __( 'Top', 'exclusive-addons-elementor-pro' ),
						'icon'   => 'eicon-v-align-top'
					],
					'middle'     => [
						'title'  => __( 'Middle', 'exclusive-addons-elementor-pro' ),
						'icon'   => 'eicon-v-align-middle'
					],
					'bottom'   => [
						'title'  => __( 'Bottom', 'exclusive-addons-elementor-pro' ),
						'icon'   => 'eicon-v-align-bottom'
					]
				],
				'default' => 'middle',
				'selectors' => [
					'{{WRAPPER}} .exad-product-add-to-cart table tbody tr td' => 'vertical-align: {{VALUE}};'
				]
			]
		);

        $this->add_control(
			'exad_product_add_to_cart_form_table_row_horizontal_alignment',
			[
				'label'   => __( 'Horizontal Alignment', 'exclusive-addons-elementor-pro' ),
				'type'    => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title'  => __( 'Left', 'exclusive-addons-elementor-pro' ),
						'icon'   => 'eicon-text-align-left'
					],
					'center'     => [
						'title'  => __( 'Center', 'exclusive-addons-elementor-pro' ),
						'icon'   => 'eicon-text-align-center'
					],
					'right'   => [
						'title'  => __( 'Right', 'exclusive-addons-elementor-pro' ),
						'icon'   => 'eicon-text-align-right'
					]
				],
				'default' => 'center',
				'selectors' => [
					'{{WRAPPER}} .exad-product-add-to-cart table tbody tr td' => 'text-align: {{VALUE}};'
				]
			]
		);

		$this->add_control(
            'exad_product_add_to_cart_form_text_color',
            [
                'label'     => __( 'Text Color', 'exclusive-addons-elementor-pro' ),
                'type'      => Controls_Manager::COLOR,
                'default'	=> $exad_primary_color,
                'selectors' => [
                    '{{WRAPPER}} .exad-product-add-to-cart table tbody tr td' => 'color: {{VALUE}} !important;',
                ],
            ]
        );

		$this->add_control(
            'exad_product_add_to_cart_form_background_color',
            [
                'label' => __( 'Background Color', 'exclusive-addons-elementor-pro' ),
                'type'  => Controls_Manager::COLOR,
                'default'	=> "#fff",
                'selectors' => [
                    '{{WRAPPER}} .exad-product-add-to-cart table tbody tr td' => 'background-color: {{VALUE}} !important',
                ],
            ]
        );
		
        $this->add_responsive_control(
            'exad_product_add_to_cart_form_padding',
            [
                'label' => __( 'Padding', 'exclusive-addons-elementor-pro' ),
                'type'  => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em' ],
                'selectors' => [
                    '.exad-product-add-to-cart table tbody tr td' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                ],
            ]
        );
		
        $this->add_responsive_control(
            'exad_product_add_to_cart_form_border_radius',
            [
                'label' => __( 'Border Radius', 'exclusive-addons-elementor-pro' ),
                'type'  => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'default'    => [
					'top'    => '0',
					'right'  => '0',
					'bottom' => '0',
					'left'   => '0',
					'unit'   => 'px',
                    'isLinked'  => false
				],
                'selectors'  => [
                    '{{WRAPPER}} .exad-product-add-to-cart table tbody tr td' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                ],
            ]
        );

		$this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'  => 'exad_product_add_to_cart_form__border',
                'label' => __( 'Border', 'exclusive-addons-elementor-pro' ),
                'selector' => '{{WRAPPER}} .exad-product-add-to-cart table tbody tr td',
            ]
        );

        $this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'exad_product_add_to_cart_form_box_shadow',
				'selector' => '{{WRAPPER}} .exad-product-add-to-cart table tbody tr td'
			]
		);

		$this-> end_controls_section();

        /*
		* Before & After Cart Styling Section
		*/
		$this->start_controls_section(
            'product_add_to_cart_before_after_style_section',
            [
                'label' => esc_html__( 'Before & After Style', 'exclusive-addons-elementor-pro' ),
				'tab'   => Controls_Manager::TAB_STYLE
            ]
        );

		$this->add_control(
			'product_add_to_cart_before_style',
			[
				'label'     => __( 'Before Cart', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before'
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'             => 'product_add_to_cart_before_typography',
				'selector'         => '{{WRAPPER}} .product-cart-before',
				'fields_options'   => [
					'font_size'    => [
		                'default'  => [
		                    'unit' => 'px',
		                    'size' => 14
		                ]
		            ],
		            'font_weight'  => [
		                'default'  => '600'
		            ]
	            ]
			]
		);

		$this->add_control(
			'product_add_to_cart_before_color',
			[
				'label'     => __( 'Color', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#333333',
				'selectors' => [
					'{{WRAPPER}} .product-cart-before' => 'color: {{VALUE}};'
				]
			]
		);

		$this->add_responsive_control(
			'product_add_to_cart_before_margin',
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
					'{{WRAPPER}} .product-cart-before' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
		);

        $this->add_control(
			'product_add_to_cart_after_style',
			[
				'label'     => __( 'After Cart', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before'
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'             => 'product_add_to_cart_after_typography',
				'selector'         => '{{WRAPPER}} .product-cart-after',
				'fields_options'   => [
					'font_size'    => [
		                'default'  => [
		                    'unit' => 'px',
		                    'size' => 14
		                ]
		            ],
		            'font_weight'  => [
		                'default'  => '600'
		            ]
	            ]
			]
		);

		$this->add_control(
			'product_add_to_cart_after_color',
			[
				'label'     => __( 'Color', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#333333',
				'selectors' => [
					'{{WRAPPER}} .product-cart-after' => 'color: {{VALUE}};'
				]
			]
		);

		$this->add_responsive_control(
			'product_add_to_cart_after_margin',
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
					'{{WRAPPER}} .product-cart-after' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
		);
		$this-> end_controls_section();

    }

    public function add_to_cart_text( $button_text ) {

		$settings = $this->get_settings();

        if (! empty( $settings['exad_add_to_cart_button_text'] )){
            $button_text = $settings['exad_add_to_cart_button_text'];
        } 
      
		return $button_text;

	}

    protected function render() {

        if ( !class_exists( 'woocommerce' ) ) {
            return;
        }

		do_action( 'exad_woo_builder_widget_before_render', $this );

        $settings = $this->get_settings_for_display();
        ?>

        <?php if ( ! empty( $settings['product_add_to_cart_before'] ) ) : ?>
            <p class="product-cart-before" ><?php echo wp_kses_post( $settings['product_add_to_cart_before'] );?></p>
        <?php endif; ?>

		<div class="exad-product-add-to-cart">

            <?php
            do_action( 'exad_woo_builder_widget_cart_button_before_render', $this ); ?>

            <?php global $product;

            $product = wc_get_product();

            if ( \Elementor\Plugin::instance()->editor->is_edit_mode() ) {
                echo Woo_Preview_Data::instance()->default( $this->get_name() );
            } else {
                if ( empty( $product ) ) {
                    return;
                }
                ?>

                <div class="<?php echo esc_attr( wc_get_product()->get_type() ); ?>">
                    <?php 

                    $text_callback = function() {
                        ob_start();

                        if (! empty( $settings['exad_add_to_cart_button_text'] )){
                            $text = $settings['exad_add_to_cart_button_text'];
                        } 

                        return ob_get_clean();
                    };

                    add_filter( 'woocommerce_product_single_add_to_cart_text', [ $this, 'add_to_cart_text' ] );

                    	ob_start();
                        woocommerce_template_single_add_to_cart();
                        $form = ob_get_clean();
                        $form = str_replace( 'single_add_to_cart_button', 'exad-button single_add_to_cart_button elementor-button', $form );
                        echo $form;

                    remove_filter( 'woocommerce_product_single_add_to_cart_text', [ $this, 'add_to_cart_text' ] );
                    ?>
                </div>

                <?php
            } ?>
            <?php do_action( 'exad_woo_builder_widget_cart_button_after_render', $this ); ?>
		</div>

        <?php if ( ! empty( $settings['product_add_to_cart_after'] ) ) : ?>
            <p class="product-cart-after" ><?php echo wp_kses_post( $settings['product_add_to_cart_after'] );?></p>
        <?php endif; ?>

        <?php

    }

}