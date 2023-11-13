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

class Woo_Checkout extends Widget_Base {

	public function get_name() {
		return 'exad-woo-checkout';
	}

	public function get_title() {
		return esc_html__( ' Woo Checkout', 'exclusive-addons-elementor-pro' );
	}

	public function get_icon() {
		return 'exad exad-logo exad-woo-checkout';
	}

	public function get_categories() {
		return [ 'exclusive-addons-elementor' ];
	}

	public function get_keywords() {
	    return [ 'cart', 'woocommerce', 'check' ];
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
            'exad_woo_checkout_content_section',
            [
                'label' => esc_html__( 'Content', 'exclusive-addons-elementor-pro' ),
            ]
        );

		$this->add_control(
			'exad_woo_checkout_layout',
			[
				'label' => __( 'Layout', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'layout-1',
				'options' => [
					'layout-1'  => __( 'Layout 1', 'exclusive-addons-elementor-pro' ),
					'layout-2' => __( 'Layout 2', 'exclusive-addons-elementor-pro' ),
				],
			]
		);

		$this->add_control(
			'exad_woo_checkout_layout_gap',
			[
				'label' => __( 'Layout Gap', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 10,
				],
				'selectors' => [
					'{{WRAPPER}} .exad-woo-checkout.layout-2 .woocommerce form.woocommerce-checkout' => 'column-gap: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'exad_woo_checkout_layout' => 'layout-2'
				]
			]
		);

		$this->end_controls_section();

		/**
		 * Checkout Style Section
		 */

        $this->start_controls_section(
            'exad_woo_checkout_style_section',
            [
				'label' => esc_html__( 'Container', 'exclusive-addons-elementor-pro' ),
				'tab'       => Controls_Manager::TAB_STYLE
            ]
		);
		
		$this->add_control(
			'exad_woo_checkout_container_padding',
			[
				'label' => __( 'Padding', 'exclusive-addons-elementor-pro' ),
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
					'{{WRAPPER}} .exad-woo-checkout' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'exad_woo_checkout_container_background',
				'label' => __( 'Background', 'exclusive-addons-elementor-pro' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .exad-woo-checkout',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'exad_woo_checkout_container_border',
				'label' => __( 'Border', 'exclusive-addons-elementor-pro' ),
				'selector' => '{{WRAPPER}} .exad-woo-checkout',
			]
		);

		$this->add_control(
			'exad_woo_checkout_container_border_radius',
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
					'{{WRAPPER}} .exad-woo-checkout' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'exad_woo_checkout_container_box_shadow',
				'label' => __( 'Box Shadow', 'exclusive-addons-elementor-pro' ),
				'selector' => '{{WRAPPER}} .exad-woo-checkout',
			]
		);

		$this->end_controls_section();

		/**
		 * Checkout Style Section
		 */

        $this->start_controls_section(
            'exad_woo_checkout_coupon_style',
            [
				'label' => esc_html__( 'Coupon Bar', 'exclusive-addons-elementor-pro' ),
				'tab'       => Controls_Manager::TAB_STYLE
            ]
		);

		$this->add_control(
			'exad_woo_checkout_coupon_box_heading',
			[
				'label' => __( 'Coupon Box', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::HEADING,
			]
		);

		$this->add_control(
			'exad_woo_checkout_coupon_box_padding',
			[
				'label' => __( 'Padding', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'default' => [
					'top' => '20',
					'right' => '32',
					'bottom' => '16',
					'left' => '56',
					'unit' => 'px',
					'isLinked' => false,
				],
				'selectors' => [
					'{{WRAPPER}} .exad-woo-checkout .woocommerce-form-coupon-toggle .woocommerce-info' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'exad_woo_checkout_coupon_box_background',
				'label' => __( 'Background', 'exclusive-addons-elementor-pro' ),
				'types' => [ 'classic', 'gradient' ],
				'fields_options'  => [
					'background'  => [
						'default' => 'classic'
					],
					'color'       => [
						'default' => '#f2f2f2'
					]
				],
				'selector' => '{{WRAPPER}} .exad-woo-checkout .woocommerce-form-coupon-toggle .woocommerce-info',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'exad_woo_checkout_coupon_text_typography',
				'label' => __( 'Typography', 'exclusive-addons-elementor-pro' ),
				'selector' => '{{WRAPPER}} .exad-woo-checkout .woocommerce-form-coupon-toggle .woocommerce-info, {{WRAPPER}} .exad-woo-checkout .woocommerce-form-coupon-toggle .woocommerce-info .showcoupon',
			]
		);

		$this->add_control(
			'exad_woo_checkout_coupon_text_color',
			[
				'label' => __( 'Text Color', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .exad-woo-checkout .woocommerce-form-coupon-toggle .woocommerce-info' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'exad_woo_checkout_coupon_icon_color',
			[
				'label' => __( 'Icon Color', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .exad-woo-checkout .woocommerce-form-coupon-toggle .woocommerce-info:before' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'exad_woo_checkout_coupon_link_color',
			[
				'label' => __( 'Link Color', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .exad-woo-checkout .woocommerce-form-coupon-toggle .woocommerce-info .showcoupon' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'exad_woo_checkout_coupon_link_hover_color',
			[
				'label' => __( 'Link Hover Color', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .exad-woo-checkout .woocommerce-form-coupon-toggle .woocommerce-info .showcoupon:hover' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'exad_woo_checkout_coupon_box_border',
				'label' => __( 'Border', 'exclusive-addons-elementor-pro' ),
				'selector' => '{{WRAPPER}} .exad-woo-checkout .woocommerce-form-coupon-toggle .woocommerce-info',
			]
		);

		$this->add_control(
			'exad_woo_checkout_coupon_box_border_radius',
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
					'{{WRAPPER}} .exad-woo-checkout .woocommerce-form-coupon-toggle .woocommerce-info' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'exad_woo_checkout_coupon_box_shadow',
				'label' => __( 'Box Shadow', 'exclusive-addons-elementor-pro' ),
				'selector' => '{{WRAPPER}} .exad-woo-checkout .woocommerce-form-coupon-toggle .woocommerce-info',
			]
		);

		$this->add_control(
			'exad_woo_checkout_coupon_form_heading',
			[
				'label' => __( 'Coupon Form', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before'
			]
		);

		$this->add_control(
			'exad_woo_checkout_coupon_form_background_color',
			[
				'label' => __( 'Background Color', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .exad-woo-checkout .woocommerce-form-coupon' => 'background: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'exad_woo_checkout_coupon_form_padding',
			[
				'label' => __( 'padding', 'exclusive-addons-elementor-pro' ),
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
					'{{WRAPPER}} .exad-woo-checkout .woocommerce-form-coupon' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'exad_woo_checkout_coupon_form_bottom_spacing',
			[
				'label' => __( 'Bottom Spacing', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 10,
				],
				'selectors' => [
					'{{WRAPPER}} .exad-woo-checkout .woocommerce-form-coupon' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'exad_woo_checkout_coupon_form_border',
				'label' => __( 'Border', 'exclusive-addons-elementor-pro' ),
				'selector' => '{{WRAPPER}} .exad-woo-checkout .woocommerce-form-coupon',
			]
		);

		$this->add_control(
			'exad_woo_checkout_coupon_form_border_radius',
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
					'{{WRAPPER}} .exad-woo-checkout .woocommerce-form-coupon' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'exad_woo_checkout_coupon_form_box_shadow',
				'label' => __( 'Box Shadow', 'exclusive-addons-elementor-pro' ),
				'selector' => '{{WRAPPER}} .exad-woo-checkout .woocommerce-form-coupon',
			]
		);

		$this->add_control(
			'exad_woo_checkout_coupon_form_label_heading',
			[
				'label' => __( 'Coupon Form Label', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before'
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'exad_woo_checkout_coupon_form_label_typography',
				'label' => __( 'Typography', 'exclusive-addons-elementor-pro' ),
				'selector' => '{{WRAPPER}} .exad-woo-checkout .woocommerce-form-coupon p',
			]
		);

		$this->add_control(
			'exad_woo_checkout_coupon_form_label_color',
			[
				'label' => __( 'Text Color', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .exad-woo-checkout .woocommerce-form-coupon p' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'exad_woo_checkout_coupon_form_label_margin',
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
					'{{WRAPPER}} .exad-woo-checkout .woocommerce-form-coupon p' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'exad_woo_checkout_coupon_form_input_field_heading',
			[
				'label' => __( 'Coupon Form Input Field', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before'
			]
		);

		$this->add_control(
			'exad_woo_checkout_coupon_form_input_field_width',
			[
				'label' => __( 'Input Field Height', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 40,
				],
				'selectors' => [
					'{{WRAPPER}} .exad-woo-checkout .woocommerce-form-coupon input' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'exad_woo_checkout_coupon_form_input_field_padding',
			[
				'label' => __( 'Input Field Padding', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'default' => [
					'top' => '10',
					'right' => '10',
					'bottom' => '10',
					'left' => '10',
					'unit' => 'px',
					'isLinked' => true,
				],
				'selectors' => [
					'{{WRAPPER}} .exad-woo-checkout .woocommerce-form-coupon input' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'exad_woo_checkout_coupon_form_input_field_background',
			[
				'label' => __( 'Input Field Background Color', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .exad-woo-checkout .woocommerce-form-coupon input' => 'background: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'exad_woo_checkout_coupon_form_input_field_typography',
				'label' => __( 'Typography', 'exclusive-addons-elementor-pro' ),
				'selector' => '{{WRAPPER}} .exad-woo-checkout .woocommerce-form-coupon input',
			]
		);

		$this->add_control(
			'exad_woo_checkout_coupon_form_input_field_text_color',
			[
				'label' => __( 'Input Field Text Color', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .exad-woo-checkout .woocommerce-form-coupon input' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'exad_woo_checkout_coupon_form_input_field_placeholder_color',
			[
				'label' => __( 'Input Field Placeholder Color', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .exad-woo-checkout .woocommerce-form-coupon input::placeholder' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'exad_woo_checkout_coupon_form_input_field_border',
				'label' => __( 'Border', 'exclusive-addons-elementor-pro' ),
				'selector' => '{{WRAPPER}} .exad-woo-checkout .woocommerce-form-coupon input',
			]
		);

		$this->add_control(
			'exad_woo_checkout_coupon_form_input_field_border_radius',
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
					'{{WRAPPER}} .exad-woo-checkout .woocommerce-form-coupon input' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'exad_woo_checkout_coupon_form_input_field_box_shadow',
				'label' => __( 'Box Shadow', 'exclusive-addons-elementor-pro' ),
				'selector' => '{{WRAPPER}} .exad-woo-checkout .woocommerce-form-coupon input',
			]
		);

		$this->add_control(
			'exad_woo_checkout_apply_coupon_heading',
			[
				'label' => __( 'Apply Coupon Button', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before'
			]
		);

		$this->add_control(
			'exad_woo_checkout_apply_coupon_alignment',
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
				'selectors' => [
					'{{WRAPPER}} .exad-woo-checkout .woocommerce-form-coupon .form-row-last' => 'text-align: {{VALUE}};',
				],
				'toggle' => true,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'exad_woo_checkout_apply_coupon_button_typography',
				'label' => __( 'Typography', 'exclusive-addons-elementor-pro' ),
				'selector' => '{{WRAPPER}} .exad-woo-checkout .woocommerce-form-coupon .form-row-last button',
			]
        );

        $this->add_responsive_control(
            'exad_woo_checkout_apply_coupon_button_padding',
            [
                'label'      => __( 'Padding', 'exclusive-addons-elementor-pro' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'default'    => [
                    'top'      => '10',
                    'right'    => '20',
                    'bottom'   => '10',
                    'left'     => '20',
                    'unit'     => 'px',
                    'isLinked' => false,
                ],
                'selectors'  => [
                    '{{WRAPPER}} .exad-woo-checkout .woocommerce-form-coupon .form-row-last button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
		);
		
        $this->add_responsive_control(
            'exad_woo_checkout_apply_coupon_button_margin',
            [
                'label'      => __( 'Margin', 'exclusive-addons-elementor-pro' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'default'    => [
                    'top'      => '10',
                    'right'    => '0',
                    'bottom'   => '0',
                    'left'     => '0',
                    'unit'     => 'px',
                    'isLinked' => false,
                ],
                'selectors'  => [
                    '{{WRAPPER}} .exad-woo-checkout .woocommerce-form-coupon .form-row-last button' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'exad_woo_checkout_apply_coupon_button_radius',
            [
                'label'      => __( 'Border Radius', 'exclusive-addons-elementor-pro' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'default'    => [
                    'top'      => '5',
                    'right'    => '5',
                    'bottom'   => '5',
                    'left'     => '5',
                    'unit'     => 'px',
                    'isLinked' => true,
                ],
                'selectors'  => [
                    '{{WRAPPER}} .exad-woo-checkout .woocommerce-form-coupon .form-row-last button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs('exad_woo_checkout_apply_coupon_button_tabs');

            // Normal item
            $this->start_controls_tab('exad_woo_checkout_apply_coupon_button_normal', ['label' => esc_html__('Normal', 'exclusive-addons-elementor-pro')]);

                $this->add_control(
                    'exad_woo_checkout_apply_coupon_button_normal_background',
                    [
                        'label'     => esc_html__('Backgroun Color', 'exclusive-addons-elementor-pro'),
                        'type'      => Controls_Manager::COLOR,
                        'default'   => '#000000',
                        'selectors' => [
                            '{{WRAPPER}} .exad-woo-checkout .woocommerce-form-coupon .form-row-last button' => 'Background: {{VALUE}};'
                        ]
                    ]
                );

                $this->add_control(
                    'exad_woo_checkout_apply_coupon_button_normal_color',
                    [
                        'label'     => esc_html__('Text Color', 'exclusive-addons-elementor-pro'),
                        'type'      => Controls_Manager::COLOR,
                        'default'   => '#ffffff',
                        'selectors' => [
                            '{{WRAPPER}} .exad-woo-checkout .woocommerce-form-coupon .form-row-last button' => 'color: {{VALUE}};'
                        ]
                    ]
                );

                $this->add_group_control(
                    Group_Control_Border::get_type(),
                    [
                        'name' => 'exad_woo_checkout_apply_coupon_button_normal_border',
                        'label' => __( 'Border', 'exclusive-addons-elementor-pro' ),
                        'selector' => '{{WRAPPER}} .exad-woo-checkout .woocommerce-form-coupon .form-row-last button',
                    ]
                );

                $this->add_group_control(
                    Group_Control_Box_Shadow::get_type(),
                    [
                        'name' => 'exad_woo_checkout_apply_coupon_button_normal_box_shadow',
                        'label' => __( 'Box Shadow', 'exclusive-addons-elementor-pro' ),
                        'selector' => '{{WRAPPER}} .exad-woo-checkout .woocommerce-form-coupon .form-row-last button',
                    ]
                );

            $this->end_controls_tab();

            // Hover item
            $this->start_controls_tab('exad_woo_checkout_apply_coupon_button_hover', ['label' => esc_html__('Hover', 'exclusive-addons-elementor-pro')]);

                $this->add_control(
                    'exad_woo_checkout_apply_coupon_button_hover_background',
                    [
                        'label'     => esc_html__('Backgroun Color', 'exclusive-addons-elementor-pro'),
                        'type'      => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .exad-woo-checkout .woocommerce-form-coupon .form-row-last button:hover' => 'Background: {{VALUE}};'
                        ]
                    ]
                );

                $this->add_control(
                    'exad_woo_checkout_apply_coupon_button_hover_color',
                    [
                        'label'     => esc_html__('Text Color', 'exclusive-addons-elementor-pro'),
                        'type'      => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .exad-woo-checkout .woocommerce-form-coupon .form-row-last button:hover' => 'color: {{VALUE}};'
                        ]
                    ]
                );

                $this->add_group_control(
                    Group_Control_Border::get_type(),
                    [
                        'name' => 'exad_woo_checkout_apply_coupon_button_hover_border',
                        'label' => __( 'Border', 'exclusive-addons-elementor-pro' ),
                        'selector' => '{{WRAPPER}} .exad-woo-checkout .woocommerce-form-coupon .form-row-last button:hover',
                    ]
                );

                $this->add_group_control(
                    Group_Control_Box_Shadow::get_type(),
                    [
                        'name' => 'exad_woo_checkout_apply_coupon_button_hover_box_shadow',
                        'label' => __( 'Box Shadow', 'exclusive-addons-elementor-pro' ),
                        'selector' => '{{WRAPPER}} .exad-woo-checkout .woocommerce-form-coupon .form-row-last button:hover',
                    ]
                );
                
            $this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		/**
		 * Section Style Section
		 */

        $this->start_controls_section(
            'exad_woo_checkout_input_section',
            [
				'label' => esc_html__( 'Input Field, Textarea & Label', 'exclusive-addons-elementor-pro' ),
				'tab'       => Controls_Manager::TAB_STYLE
            ]
		);
		
		$this->add_responsive_control(
            'exad_woo_checkout_input_padding',
            [
                'label'      => __( 'Padding', 'exclusive-addons-elementor-pro' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'default'    => [
                    'top'      => '0',
                    'right'    => '15',
                    'bottom'   => '0',
                    'left'     => '15',
                    'unit'     => 'px',
                    'isLinked' => false,
                ],
                'selectors'  => [
                    '{{WRAPPER}} .exad-woo-checkout .woocommerce-billing-fields .input-text' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .exad-woo-checkout .woocommerce-additional-fields .input-text' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .exad-woo-checkout .woocommerce-shipping-fields .input-text' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .exad-woo-checkout .select2-selection--single .select2-selection__rendered' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
		);

		$this->add_control(
			'exad_woo_checkout_input_field_spacing',
			[
				'label' => __( 'Spacing between Input Field', 'exclusive-addons-elementor-pro' ),
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
					'{{WRAPPER}} .exad-woo-checkout .woocommerce .woocommerce-billing-fields__field-wrapper .form-row' => 'margin-bottom: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .exad-woo-checkout .woocommerce .woocommerce-shipping-fields__field-wrapper .form-row' => 'margin-bottom: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .exad-woo-checkout .woocommerce .woocommerce-additional-fields__field-wrapper .form-row' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'exad_woo_checkout_first_last_name_spacing',
			[
				'label' => __( 'Spacing between First Name & Last Name', 'exclusive-addons-elementor-pro' ),
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
					'size' => 5,
				],
				'selectors' => [
					'{{WRAPPER}} .exad-woo-checkout .woocommerce .woocommerce-billing-fields__field-wrapper .form-row.form-row-first' => 'padding-right: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .exad-woo-checkout .woocommerce .woocommerce-shipping-fields__field-wrapper .form-row.form-row-first' => 'padding-right: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .exad-woo-checkout .woocommerce .woocommerce-billing-fields__field-wrapper .form-row.form-row-last' => 'padding-left: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .exad-woo-checkout .woocommerce .woocommerce-shipping-fields__field-wrapper .form-row.form-row-last' => 'padding-left: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'exad_woo_checkout_input_field_height',
			[
				'label' => __( 'Input Field Height', 'exclusive-addons-elementor-pro' ),
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
					'size' => 45,
				],
				'selectors' => [
					'{{WRAPPER}} .exad-woo-checkout .woocommerce-billing-fields .input-text' => 'height: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .exad-woo-checkout .woocommerce-additional-fields .input-text' => 'height: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .exad-woo-checkout .woocommerce-shipping-fields .input-text' => 'height: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .exad-woo-checkout .select2-selection--single' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'exad_woo_checkout_textarea_height',
			[
				'label' => __( 'Text Area Height', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
						'step' => 5,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 150,
				],
				'selectors' => [
					'{{WRAPPER}} .exad-woo-checkout .woocommerce-billing-fields textarea' => 'height: {{SIZE}}{{UNIT}} !important;',
					'{{WRAPPER}} .exad-woo-checkout .woocommerce-additional-fields textarea' => 'height: {{SIZE}}{{UNIT}} !important;',
					'{{WRAPPER}} .exad-woo-checkout .woocommerce-shipping-fields textarea' => 'height: {{SIZE}}{{UNIT}} !important;',
				],
			]
		);

		$this->add_control(
			'exad_woo_checkout_input_field_background',
			[
				'label'     => esc_html__('Input Field Background Color', 'exclusive-addons-elementor-pro'),
				'type'      => Controls_Manager::COLOR,
				'default' 	=> '#f2f2f2',
				'selectors' => [
					'{{WRAPPER}} .exad-woo-checkout .input-text' => 'Background: {{VALUE}};',
					'{{WRAPPER}} .exad-woo-checkout .select2-selection--single' => 'Background: {{VALUE}};'
				]
			]
		);

		$this->add_control(
			'exad_woo_checkout_input_field_placeholder_color',
			[
				'label'     => esc_html__('Input Field Placeholder Color', 'exclusive-addons-elementor-pro'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .exad-woo-checkout .input-text::placeholder' => 'color: {{VALUE}};'
				]
			]
		);

		$this->add_control(
			'exad_woo_checkout_input_field_text_color',
			[
				'label'     => esc_html__('Input Field Text Color', 'exclusive-addons-elementor-pro'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .exad-woo-checkout .input-text' => 'color: {{VALUE}};',
					'{{WRAPPER}} .exad-woo-checkout .select2-selection--single' => 'color: {{VALUE}};'
				]
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'exad_woo_checkout_input_field_typography',
				'label' => __( 'Typography', 'exclusive-addons-elementor-pro' ),
				'selector' => '{{WRAPPER}} .exad-woo-checkout .input-text, .exad-woo-checkout .select2-selection--single',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'exad_woo_checkout_input_field_border',
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
                        'default' => '#d9d9d9'
                    ]
                ],
				'selector' => '{{WRAPPER}} .exad-woo-checkout .input-text, {{WRAPPER}} .exad-woo-checkout .select2-selection--single',
			]
		);

		$this->add_responsive_control(
            'exad_woo_checkout_input_field_border_radius',
            [
                'label'      => __( 'Border Radius', 'exclusive-addons-elementor-pro' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'default'    => [
                    'top'      => '4',
                    'right'    => '4',
                    'bottom'   => '4',
                    'left'     => '4',
                    'unit'     => 'px',
                    'isLinked' => true,
                ],
                'selectors'  => [
                    '{{WRAPPER}} .exad-woo-checkout .input-text' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .exad-woo-checkout .select2-selection--single' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'exad_woo_checkout_input_field_box_shadow',
				'label' => __( 'Box Shadow', 'exclusive-addons-elementor-pro' ),
				'selector' => '{{WRAPPER}} .exad-woo-checkout .input-text',
			]
		);

		$this->end_controls_section();

		/**
		 * Section Label Style Section
		 */

        $this->start_controls_section(
            'exad_woo_checkout_label_section',
            [
				'label' => esc_html__( 'Label', 'exclusive-addons-elementor-pro' ),
				'tab'       => Controls_Manager::TAB_STYLE
            ]
		);

		$this->add_control(
			'exad_woo_checkout_label_color',
			[
				'label'     => esc_html__('Label Color', 'exclusive-addons-elementor-pro'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .exad-woo-checkout .woocommerce-billing-fields__field-wrapper .form-row label' => 'color: {{VALUE}};',
					'{{WRAPPER}} .exad-woo-checkout .woocommerce-shipping-fields__field-wrapper .form-row label' => 'color: {{VALUE}};',
					'{{WRAPPER}} .exad-woo-checkout .woocommerce-additional-fields__field-wrapper .form-row label' => 'color: {{VALUE}};',
				]
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'exad_woo_checkout_label_typography',
				'label' => __( 'Typography', 'exclusive-addons-elementor-pro' ),
				'selector' => '{{WRAPPER}} .exad-woo-checkout .woocommerce-billing-fields__field-wrapper .form-row label',
				'selector' => '{{WRAPPER}} .exad-woo-checkout .woocommerce-shipping-fields__field-wrapper .form-row label',
				'selector' => '{{WRAPPER}} .exad-woo-checkout .woocommerce-additional-fields__field-wrapper .form-row label',
			]
		);

		$this->add_control(
			'exad_woo_checkout_label_spacing',
			[
				'label' => __( 'Label Bottom Spacing', 'exclusive-addons-elementor-pro' ),
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
					'size' => 6,
				],
				'selectors' => [
					'{{WRAPPER}} .exad-woo-checkout .woocommerce-billing-fields__field-wrapper .form-row label' => 'margin-bottom: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .exad-woo-checkout .woocommerce-additional-fields__field-wrapper .form-row label' => 'margin-bottom: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .exad-woo-checkout .woocommerce-shipping-fields__field-wrapper .form-row label' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		/**
		 * Section Billing Style Section
		 */

        $this->start_controls_section(
            'exad_woo_checkout_billing_section',
            [
				'label' => esc_html__( 'Billing Section', 'exclusive-addons-elementor-pro' ),
				'tab'       => Controls_Manager::TAB_STYLE
            ]
		);

		$this->add_control(
			'exad_woo_checkout_billing_background',
			[
				'label'     => esc_html__('Background Color', 'exclusive-addons-elementor-pro'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .exad-woo-checkout .woocommerce-billing-fields' => 'background: {{VALUE}};',
				]
			]
		);

		$this->add_responsive_control(
            'exad_woo_checkout_billing_padding',
            [
                'label'      => __( 'Padding', 'exclusive-addons-elementor-pro' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'default'    => [
                    'top'      => '0',
                    'right'    => '0',
                    'bottom'   => '0',
                    'left'     => '0',
                    'unit'     => 'px',
                    'isLinked' => true,
                ],
                'selectors'  => [
                    '{{WRAPPER}} .exad-woo-checkout .woocommerce-billing-fields' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
		);

		$this->add_responsive_control(
            'exad_woo_checkout_billing_margin',
            [
                'label'      => __( 'Margin', 'exclusive-addons-elementor-pro' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'default'    => [
                    'top'      => '0',
                    'right'    => '0',
                    'bottom'   => '0',
                    'left'     => '0',
                    'unit'     => 'px',
                    'isLinked' => true,
                ],
                'selectors'  => [
                    '{{WRAPPER}} .exad-woo-checkout .woocommerce-billing-fields' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'exad_woo_checkout_billing_border',
				'label' => __( 'Border', 'exclusive-addons-elementor-pro' ),
				'selector' => '{{WRAPPER}} .exad-woo-checkout .woocommerce-billing-fields',
			]
		);

		$this->add_control(
			'exad_woo_checkout_billing_title_color',
			[
				'label'     => esc_html__('Title Color', 'exclusive-addons-elementor-pro'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .exad-woo-checkout .woocommerce-billing-fields h3' => 'color: {{VALUE}};',
				]
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'exad_woo_checkout_billing_title_typography',
				'label' => __( 'Typography', 'exclusive-addons-elementor-pro' ),
				'selector' => '{{WRAPPER}} .exad-woo-checkout .woocommerce-billing-fields h3',
			]
		);

		$this->add_responsive_control(
            'exad_woo_checkout_billing_title_margin',
            [
                'label'      => __( 'Title Margin', 'exclusive-addons-elementor-pro' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'default'    => [
                    'top'      => '0',
                    'right'    => '0',
                    'bottom'   => '20',
                    'left'     => '0',
                    'unit'     => 'px',
                    'isLinked' => true,
                ],
                'selectors'  => [
                    '{{WRAPPER}} .exad-woo-checkout .woocommerce-billing-fields h3' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
		);

		$this->end_controls_section();

		/**
		 * Section Additional Style Section
		 */

        $this->start_controls_section(
            'exad_woo_checkout_additional_section',
            [
				'label' => esc_html__( 'Additional Information', 'exclusive-addons-elementor-pro' ),
				'tab'       => Controls_Manager::TAB_STYLE
            ]
		);

		$this->add_control(
			'exad_woo_checkout_additional_background',
			[
				'label'     => esc_html__('Background Color', 'exclusive-addons-elementor-pro'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .exad-woo-checkout .woocommerce-additional-fields' => 'background: {{VALUE}};',
				]
			]
		);

		$this->add_responsive_control(
            'exad_woo_checkout_additional_padding',
            [
                'label'      => __( 'Padding', 'exclusive-addons-elementor-pro' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'default'    => [
                    'top'      => '0',
                    'right'    => '0',
                    'bottom'   => '0',
                    'left'     => '0',
                    'unit'     => 'px',
                    'isLinked' => true,
                ],
                'selectors'  => [
                    '{{WRAPPER}} .exad-woo-checkout .woocommerce-additional-fields' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
		);

		$this->add_responsive_control(
            'exad_woo_checkout_additional_margin',
            [
                'label'      => __( 'Margin', 'exclusive-addons-elementor-pro' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'default'    => [
                    'top'      => '0',
                    'right'    => '0',
                    'bottom'   => '0',
                    'left'     => '0',
                    'unit'     => 'px',
                    'isLinked' => true,
                ],
                'selectors'  => [
                    '{{WRAPPER}} .exad-woo-checkout .woocommerce-additional-fields' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'exad_woo_checkout_additional_border',
				'label' => __( 'Border', 'exclusive-addons-elementor-pro' ),
				'selector' => '{{WRAPPER}} .exad-woo-checkout .woocommerce-additional-fields',
			]
		);

		$this->add_control(
			'exad_woo_checkout_additional_title_color',
			[
				'label'     => esc_html__('Title Color', 'exclusive-addons-elementor-pro'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .exad-woo-checkout .woocommerce-additional-fields h3' => 'color: {{VALUE}};',
				]
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'exad_woo_checkout_additional_title_typography',
				'label' => __( 'Typography', 'exclusive-addons-elementor-pro' ),
				'selector' => '{{WRAPPER}} .exad-woo-checkout .woocommerce-additional-fields h3',
			]
		);

		$this->add_responsive_control(
            'exad_woo_checkout_additional_title_margin',
            [
                'label'      => __( 'Title Margin', 'exclusive-addons-elementor-pro' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'default'    => [
                    'top'      => '0',
                    'right'    => '0',
                    'bottom'   => '20',
                    'left'     => '0',
                    'unit'     => 'px',
                    'isLinked' => true,
                ],
                'selectors'  => [
                    '{{WRAPPER}} .exad-woo-checkout .woocommerce-additional-fields h3' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
		);

		$this->end_controls_section();

		/**
		 * Section Shipping Style Section
		 */

        $this->start_controls_section(
            'exad_woo_checkout_shipping_section',
            [
				'label' => esc_html__( 'Shipping Information', 'exclusive-addons-elementor-pro' ),
				'tab'       => Controls_Manager::TAB_STYLE
            ]
		);

		$this->add_control(
			'exad_woo_checkout_shipping_background',
			[
				'label'     => esc_html__('Background Color', 'exclusive-addons-elementor-pro'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .exad-woo-checkout .woocommerce-shipping-fields' => 'background: {{VALUE}};',
				]
			]
		);

		$this->add_responsive_control(
            'exad_woo_checkout_shipping_padding',
            [
                'label'      => __( 'Padding', 'exclusive-addons-elementor-pro' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'default'    => [
                    'top'      => '0',
                    'right'    => '0',
                    'bottom'   => '0',
                    'left'     => '0',
                    'unit'     => 'px',
                    'isLinked' => true,
                ],
                'selectors'  => [
                    '{{WRAPPER}} .exad-woo-checkout .woocommerce-shipping-fields' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
		);

		$this->add_responsive_control(
            'exad_woo_checkout_shipping_margin',
            [
                'label'      => __( 'Margin', 'exclusive-addons-elementor-pro' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'default'    => [
                    'top'      => '0',
                    'right'    => '0',
                    'bottom'   => '0',
                    'left'     => '0',
                    'unit'     => 'px',
                    'isLinked' => true,
                ],
                'selectors'  => [
                    '{{WRAPPER}} .exad-woo-checkout .woocommerce-shipping-fields' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'exad_woo_checkout_shipping_border',
				'label' => __( 'Border', 'exclusive-addons-elementor-pro' ),
				'selector' => '{{WRAPPER}} .exad-woo-checkout .woocommerce-shipping-fields',
			]
		);

		$this->add_control(
			'exad_woo_checkout_shipping_title_color',
			[
				'label'     => esc_html__('Title Color', 'exclusive-addons-elementor-pro'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .exad-woo-checkout .woocommerce-shipping-fields h3' => 'color: {{VALUE}};',
				]
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'exad_woo_checkout_shipping_title_typography',
				'label' => __( 'Typography', 'exclusive-addons-elementor-pro' ),
				'selector' => '{{WRAPPER}} .exad-woo-checkout .woocommerce-shipping-fields h3',
			]
		);

		$this->add_responsive_control(
            'exad_woo_checkout_shipping_title_margin',
            [
                'label'      => __( 'Title Margin', 'exclusive-addons-elementor-pro' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'default'    => [
                    'top'      => '0',
                    'right'    => '0',
                    'bottom'   => '20',
                    'left'     => '0',
                    'unit'     => 'px',
                    'isLinked' => true,
                ],
                'selectors'  => [
                    '{{WRAPPER}} .exad-woo-checkout .woocommerce-shipping-fields h3' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
		);

		$this->end_controls_section();

		/**
		 * Section Order Style Section
		 */

        $this->start_controls_section(
            'exad_woo_checkout_order_section',
            [
				'label' => esc_html__( 'Order Section', 'exclusive-addons-elementor-pro' ),
				'tab'       => Controls_Manager::TAB_STYLE
            ]
		);

		$this->add_control(
			'exad_woo_checkout_order_heading',
			[
				'label' => __( 'Order Heading', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::HEADING,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'exad_woo_checkout_order_heading_typography',
				'label' => __( 'Typography', 'exclusive-addons-elementor-pro' ),
				'selector' => '{{WRAPPER}} .exad-woo-checkout .exad-woo-checkout-wrapper #order_review_heading',
			]
		);

		$this->add_control(
			'exad_woo_checkout_order_heading_text_color',
			[
				'label'     => esc_html__('Order Text Color', 'exclusive-addons-elementor-pro'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .exad-woo-checkout .exad-woo-checkout-wrapper #order_review_heading' => 'color: {{VALUE}};',
				]
			]
		);

		$this->add_responsive_control(
            'exad_woo_checkout_order_heading_margin',
            [
                'label'      => __( 'Order Margin', 'exclusive-addons-elementor-pro' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'default'    => [
                    'top'      => '0',
                    'right'    => '0',
                    'bottom'   => '20',
                    'left'     => '0',
                    'unit'     => 'px',
                    'isLinked' => true,
                ],
                'selectors'  => [
                    '{{WRAPPER}} .exad-woo-checkout .exad-woo-checkout-wrapper #order_review_heading' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
		);

		$this->add_control(
			'exad_woo_checkout_order_table_heading',
			[
				'label' => __( 'Order Table', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::HEADING,
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'exad_woo_checkout_order_table_border',
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
                        'default' => '#d9d9d9'
                    ]
                ],
				'selector' => '{{WRAPPER}} .exad-woo-checkout .woocommerce table.shop_table',
			]
		);

		$this->add_responsive_control(
            'exad_woo_checkout_order_table_border_radius',
            [
                'label'      => __( 'Border Radius', 'exclusive-addons-elementor-pro' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'default'    => [
                    'top'      => '5',
                    'right'    => '5',
                    'bottom'   => '5',
                    'left'     => '5',
                    'unit'     => 'px',
                    'isLinked' => true,
                ],
                'selectors'  => [
                    '{{WRAPPER}} .exad-woo-checkout .woocommerce table.shop_table' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
		);

		$this->start_controls_tabs( 'exad_woo_checkout_order_table_tabs' );

            // Table Heading
			$this->start_controls_tab( 'exad_woo_checkout_order_table_tabs_heading', [ 'label' => esc_html__( 'Table Heading', 'exclusive-addons-elementor-pro' ) ] );

				$this->add_control(
					'exad_woo_checkout_order_table_tabs_heading_allignment',
					[
						'label' => __( 'Text Alignment', 'exclusive-addons-elementor-pro' ),
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
						'default' => 'left',
						'toggle' => true,
						'selectors'  => [
							'{{WRAPPER}} .exad-woo-checkout .woocommerce table.shop_table thead th' => 'text-align: {{VALUE}};',
						],
					]
				);

				$this->add_control(
					'exad_woo_checkout_order_table_tabs_heading_background',
					[
						'label'     => esc_html__('Background Color', 'exclusive-addons-elementor-pro'),
						'type'      => Controls_Manager::COLOR,
						'default' 	=> '#f9f9f9',
						'selectors' => [
							'{{WRAPPER}} .exad-woo-checkout .woocommerce table.shop_table thead th' => 'background: {{VALUE}};',
						]
					]
				);

				$this->add_responsive_control(
					'exad_woo_checkout_order_table_tabs_heading_padding',
					[
						'label'      => __( 'Padding', 'exclusive-addons-elementor-pro' ),
						'type'       => Controls_Manager::DIMENSIONS,
						'size_units' => ['px', '%', 'em'],
						'default'    => [
							'top'      => '10',
							'right'    => '20',
							'bottom'   => '20',
							'left'     => '20',
							'unit'     => 'px',
							'isLinked' => false,
						],
						'selectors'  => [
							'{{WRAPPER}} .exad-woo-checkout .woocommerce table.shop_table thead th' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						],
					]
				);

				$this->add_group_control(
					Group_Control_Typography::get_type(),
					[
						'name' => 'exad_woo_checkout_order_table_tabs_heading_typography',
						'label' => __( 'Typography', 'exclusive-addons-elementor-pro' ),
						'selector' => '{{WRAPPER}} .exad-woo-checkout .woocommerce table.shop_table thead th',
					]
				);
		
				$this->add_control(
					'exad_woo_checkout_order_table_tabs_heading_typography',
					[
						'label'     => esc_html__('Text Color', 'exclusive-addons-elementor-pro'),
						'type'      => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .exad-woo-checkout .woocommerce table.shop_table thead th' => 'color: {{VALUE}};',
						]
					]
				);

				$this->add_control(
					'exad_woo_checkout_order_table_tabs_heading_separator_style',
					[
						'label' => __( 'Separator Style', 'exclusive-addons-elementor-pro' ),
						'type' => Controls_Manager::SELECT,
						'default' => 'solid',
						'options' => [
							'none' => __( 'None', 'exclusive-addons-elementor-pro' ),
							'solid'  => __( 'Solid', 'exclusive-addons-elementor-pro' ),
							'dashed' => __( 'Dashed', 'exclusive-addons-elementor-pro' ),
							'dotted' => __( 'Dotted', 'exclusive-addons-elementor-pro' ),
							'double' => __( 'Double', 'exclusive-addons-elementor-pro' ),
						],
						'selectors' => [
							'{{WRAPPER}} .exad-woo-checkout .woocommerce table.shop_table thead th:not(:last-child)' => 'border-right-style: {{VALUE}};',
							'{{WRAPPER}} .exad-woo-checkout .woocommerce table.shop_table thead th' => 'border-bottom-style: {{VALUE}};',
						],
					]
				);

				$this->add_control(
					'exad_woo_checkout_order_table_tabs_heading_separator_width',
					[
						'label' => __( 'Separator Width', 'exclusive-addons-elementor-pro' ),
						'type' => Controls_Manager::SLIDER,
						'size_units' => [ 'px' ],
						'range' => [
							'px' => [
								'min' => 0,
								'max' => 10,
								'step' => 1,
							]
						],
						'default' => [
							'unit' => 'px',
							'size' => 1,
						],
						'selectors' => [
							'{{WRAPPER}} .exad-woo-checkout .woocommerce table.shop_table thead th:not(:last-child)' => 'border-right-width: {{SIZE}}{{UNIT}};',
							'{{WRAPPER}} .exad-woo-checkout .woocommerce table.shop_table thead th' => 'border-bottom-width: {{SIZE}}{{UNIT}};',
						],
						'condition' => [
							'exad_woo_checkout_order_table_tabs_heading_separator_style!' => 'none'
						]
					]
				);

				$this->add_control(
					'exad_woo_checkout_order_table_tabs_heading_separator_color',
					[
						'label'     => esc_html__('Separator Color', 'exclusive-addons-elementor-pro'),
						'type'      => Controls_Manager::COLOR,
						'default' 	=> '#d9d9d9',
						'selectors' => [
							'{{WRAPPER}} .exad-woo-checkout .woocommerce table.shop_table thead th:not(:last-child)' => 'border-right-color: {{VALUE}};',
							'{{WRAPPER}} .exad-woo-checkout .woocommerce table.shop_table thead th' => 'border-bottom-color: {{VALUE}};',
						],
						'condition' => [
							'exad_woo_checkout_order_table_tabs_heading_separator_style!' => 'none'
						]
					]
				);
            
            $this->end_controls_tab();

            // Table Product
			$this->start_controls_tab( 'exad_woo_checkout_order_table_tabs_product', [ 'label' => esc_html__( 'Table Product', 'exclusive-addons-elementor-pro' ) ] );

				$this->add_control(
					'exad_woo_checkout_order_table_tabs_product_allignment',
					[
						'label' => __( 'Text Alignment', 'exclusive-addons-elementor-pro' ),
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
						'default' => 'left',
						'toggle' => true,
						'selectors'  => [
							'{{WRAPPER}} .exad-woo-checkout .woocommerce table.shop_table tbody .cart_item td' => 'text-align: {{VALUE}};',
						],
					]
				);

				$this->add_control(
					'exad_woo_checkout_order_table_tabs_product_background',
					[
						'label'     => esc_html__('Background Color', 'exclusive-addons-elementor-pro'),
						'type'      => Controls_Manager::COLOR,
						'default' 	=> '#ffffff',
						'selectors' => [
							'{{WRAPPER}} .exad-woo-checkout .woocommerce table.shop_table tbody .cart_item td' => 'background: {{VALUE}};',
						]
					]
				);

				$this->add_responsive_control(
					'exad_woo_checkout_order_table_tabs_product_padding',
					[
						'label'      => __( 'Padding', 'exclusive-addons-elementor-pro' ),
						'type'       => Controls_Manager::DIMENSIONS,
						'size_units' => ['px', '%', 'em'],
						'default'    => [
							'top'      => '10',
							'right'    => '20',
							'bottom'   => '10',
							'left'     => '20',
							'unit'     => 'px',
							'isLinked' => false,
						],
						'selectors'  => [
							'{{WRAPPER}} .exad-woo-checkout .woocommerce table.shop_table tbody .cart_item td' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						],
					]
				);

				$this->add_group_control(
					Group_Control_Typography::get_type(),
					[
						'name' => 'exad_woo_checkout_order_table_tabs_product_typography',
						'label' => __( 'Typography', 'exclusive-addons-elementor-pro' ),
						'selector' => '{{WRAPPER}} .exad-woo-checkout .woocommerce table.shop_table tbody .cart_item td',
					]
				);
		
				$this->add_control(
					'exad_woo_checkout_order_table_tabs_product_typography',
					[
						'label'     => esc_html__('Text Color', 'exclusive-addons-elementor-pro'),
						'type'      => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .exad-woo-checkout .woocommerce table.shop_table tbody .cart_item td' => 'color: {{VALUE}};',
						]
					]
				);

				$this->add_control(
					'exad_woo_checkout_order_table_tabs_product_separator_style',
					[
						'label' => __( 'Separator Style', 'exclusive-addons-elementor-pro' ),
						'type' => Controls_Manager::SELECT,
						'default' => 'solid',
						'options' => [
							'none' => __( 'None', 'exclusive-addons-elementor-pro' ),
							'solid'  => __( 'Solid', 'exclusive-addons-elementor-pro' ),
							'dashed' => __( 'Dashed', 'exclusive-addons-elementor-pro' ),
							'dotted' => __( 'Dotted', 'exclusive-addons-elementor-pro' ),
							'double' => __( 'Double', 'exclusive-addons-elementor-pro' ),
						],
						'selectors' => [
							'{{WRAPPER}} .exad-woo-checkout .woocommerce table.shop_table tbody .cart_item td:not(:last-child)' => 'border-right-style: {{VALUE}};',
							'{{WRAPPER}} .exad-woo-checkout .woocommerce table.shop_table tbody .cart_item td' => 'border-bottom-style: {{VALUE}};',
						],
					]
				);

				$this->add_control(
					'exad_woo_checkout_order_table_tabs_product_separator_width',
					[
						'label' => __( 'Separator Width', 'exclusive-addons-elementor-pro' ),
						'type' => Controls_Manager::SLIDER,
						'size_units' => [ 'px' ],
						'range' => [
							'px' => [
								'min' => 0,
								'max' => 10,
								'step' => 1,
							]
						],
						'default' => [
							'unit' => 'px',
							'size' => 1,
						],
						'selectors' => [
							'{{WRAPPER}} .exad-woo-checkout .woocommerce table.shop_table tbody .cart_item td:not(:last-child)' => 'border-right-width: {{SIZE}}{{UNIT}};',
							'{{WRAPPER}} .exad-woo-checkout .woocommerce table.shop_table tbody .cart_item td' => 'border-bottom-width: {{SIZE}}{{UNIT}};',
						],
						'condition' => [
							'exad_woo_checkout_order_table_tabs_product_separator_style!' => 'none'
						]
					]
				);

				$this->add_control(
					'exad_woo_checkout_order_table_tabs_product_separator_color',
					[
						'label'     => esc_html__('Separator Color', 'exclusive-addons-elementor-pro'),
						'type'      => Controls_Manager::COLOR,
						'default' 	=> '#d9d9d9',
						'selectors' => [
							'{{WRAPPER}} .exad-woo-checkout .woocommerce table.shop_table tbody .cart_item td:not(:last-child)' => 'border-right-color: {{VALUE}};',
							'{{WRAPPER}} .exad-woo-checkout .woocommerce table.shop_table tbody .cart_item td' => 'border-bottom-color: {{VALUE}};',
						],
						'condition' => [
							'exad_woo_checkout_order_table_tabs_product_separator_style!' => 'none'
						]
					]
				);

			$this->end_controls_tab();
			
            // Table Footer
			$this->start_controls_tab( 'exad_woo_checkout_order_table_tabs_footer', [ 'label' => esc_html__( 'Table Footer', 'exclusive-addons-elementor-pro' ) ] );
			
				$this->add_control(
					'exad_woo_checkout_order_table_tabs_footer_allignment',
					[
						'label' => __( 'Text Alignment', 'exclusive-addons-elementor-pro' ),
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
						'default' => 'left',
						'toggle' => true,
						'selectors'  => [
							'{{WRAPPER}} .exad-woo-checkout .woocommerce table.shop_table tfoot tr th' => 'text-align: {{VALUE}};',
							'{{WRAPPER}} .exad-woo-checkout .woocommerce table.shop_table tfoot tr td' => 'text-align: {{VALUE}};',
						],
					]
				);

				$this->add_control(
					'exad_woo_checkout_order_table_tabs_footer_background',
					[
						'label'     => esc_html__('Background Color', 'exclusive-addons-elementor-pro'),
						'type'      => Controls_Manager::COLOR,
						'default' 	=> '#f2f2f2',
						'selectors' => [
							'{{WRAPPER}} .exad-woo-checkout .woocommerce table.shop_table tfoot tr th' => 'background: {{VALUE}};',
							'{{WRAPPER}} .exad-woo-checkout .woocommerce table.shop_table tfoot tr td' => 'background: {{VALUE}};',
						]
					]
				);

				$this->add_responsive_control(
					'exad_woo_checkout_order_table_tabs_footer_padding',
					[
						'label'      => __( 'Padding', 'exclusive-addons-elementor-pro' ),
						'type'       => Controls_Manager::DIMENSIONS,
						'size_units' => ['px', '%', 'em'],
						'default'    => [
							'top'      => '10',
							'right'    => '20',
							'bottom'   => '10',
							'left'     => '20',
							'unit'     => 'px',
							'isLinked' => false,
						],
						'selectors'  => [
							'{{WRAPPER}} .exad-woo-checkout .woocommerce table.shop_table tfoot tr th' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
							'{{WRAPPER}} .exad-woo-checkout .woocommerce table.shop_table tfoot tr td' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						],
					]
				);

				$this->add_group_control(
					Group_Control_Typography::get_type(),
					[
						'name' => 'exad_woo_checkout_order_table_tabs_footer_typography',
						'label' => __( 'Typography', 'exclusive-addons-elementor-pro' ),
						'selector' => '{{WRAPPER}} .exad-woo-checkout .woocommerce table.shop_table tfoot tr th, {{WRAPPER}} .exad-woo-checkout .woocommerce table.shop_table tfoot tr td',
					]
				);
		
				$this->add_control(
					'exad_woo_checkout_order_table_tabs_footer_typography',
					[
						'label'     => esc_html__('Text Color', 'exclusive-addons-elementor-pro'),
						'type'      => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .exad-woo-checkout .woocommerce table.shop_table tfoot tr th' => 'color: {{VALUE}};',
							'{{WRAPPER}} .exad-woo-checkout .woocommerce table.shop_table tfoot tr td' => 'color: {{VALUE}};',
						]
					]
				);

				$this->add_control(
					'exad_woo_checkout_order_table_tabs_footer_separator_style',
					[
						'label' => __( 'Separator Style', 'exclusive-addons-elementor-pro' ),
						'type' => Controls_Manager::SELECT,
						'default' => 'solid',
						'options' => [
							'none' => __( 'None', 'exclusive-addons-elementor-pro' ),
							'solid'  => __( 'Solid', 'exclusive-addons-elementor-pro' ),
							'dashed' => __( 'Dashed', 'exclusive-addons-elementor-pro' ),
							'dotted' => __( 'Dotted', 'exclusive-addons-elementor-pro' ),
							'double' => __( 'Double', 'exclusive-addons-elementor-pro' ),
						],
						'selectors' => [
							'{{WRAPPER}} .exad-woo-checkout .woocommerce table.shop_table tfoot tr th' => 'border-right-style: {{VALUE}};',
							'{{WRAPPER}} .exad-woo-checkout .woocommerce table.shop_table tfoot tr:not(:last-child) th' => 'border-bottom-style: {{VALUE}};',
							'{{WRAPPER}} .exad-woo-checkout .woocommerce table.shop_table tfoot tr:not(:last-child) td' => 'border-bottom-style: {{VALUE}};',
						],
					]
				);

				$this->add_control(
					'exad_woo_checkout_order_table_tabs_footer_separator_width',
					[
						'label' => __( 'Separator Width', 'exclusive-addons-elementor-pro' ),
						'type' => Controls_Manager::SLIDER,
						'size_units' => [ 'px' ],
						'range' => [
							'px' => [
								'min' => 0,
								'max' => 10,
								'step' => 1,
							]
						],
						'default' => [
							'unit' => 'px',
							'size' => 1,
						],
						'selectors' => [
							'{{WRAPPER}} .exad-woo-checkout .woocommerce table.shop_table tfoot tr th' => 'border-right-width: {{SIZE}}{{UNIT}};',
							'{{WRAPPER}} .exad-woo-checkout .woocommerce table.shop_table tfoot tr:not(:last-child) th' => 'border-bottom-width: {{SIZE}}{{UNIT}};',
							'{{WRAPPER}} .exad-woo-checkout .woocommerce table.shop_table tfoot tr:not(:last-child) td' => 'border-bottom-width: {{SIZE}}{{UNIT}};',
						],
						'condition' => [
							'exad_woo_checkout_order_table_tabs_footer_separator_style!' => 'none'
						]
					]
				);

				$this->add_control(
					'exad_woo_checkout_order_table_tabs_footer_separator_color',
					[
						'label'     => esc_html__('Separator Color', 'exclusive-addons-elementor-pro'),
						'type'      => Controls_Manager::COLOR,
						'default' 	=> '#d9d9d9',
						'selectors' => [
							'{{WRAPPER}} .exad-woo-checkout .woocommerce table.shop_table tfoot tr th' => 'border-right-color: {{VALUE}};',
							'{{WRAPPER}} .exad-woo-checkout .woocommerce table.shop_table tfoot tr:not(:last-child) th' => 'border-bottom-color: {{VALUE}};',
							'{{WRAPPER}} .exad-woo-checkout .woocommerce table.shop_table tfoot tr:not(:last-child) td' => 'border-bottom-color: {{VALUE}};',
						],
						'condition' => [
							'exad_woo_checkout_order_table_tabs_footer_separator_style!' => 'none'
						]
					]
				);

            $this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		/**
		 * Section Payment Style Section
		 */

        $this->start_controls_section(
            'exad_woo_checkout_payment_section',
            [
				'label' => esc_html__( 'Payment Section', 'exclusive-addons-elementor-pro' ),
				'tab'       => Controls_Manager::TAB_STYLE
            ]
		);

		$this->add_control(
			'exad_woo_checkout_payment_background',
			[
				'label'     => esc_html__('Background Color', 'exclusive-addons-elementor-pro'),
				'type'      => Controls_Manager::COLOR,
				'default' 	=> '#f2f2f2',
				'selectors' => [
					'{{WRAPPER}} .exad-woo-checkout .woocommerce-checkout-payment' => 'background: {{VALUE}} !important;',
				]
			]
		);

		$this->add_responsive_control(
			'exad_woo_checkout_payment_padding',
			[
				'label'      => __( 'Padding', 'exclusive-addons-elementor-pro' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%', 'em'],
				'default'    => [
					'top'      => '0',
					'right'    => '0',
					'bottom'   => '0',
					'left'     => '0',
					'unit'     => 'px',
					'isLinked' => true,
				],
				'selectors'  => [
					'{{WRAPPER}} .exad-woo-checkout .woocommerce-checkout-payment' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'exad_woo_checkout_payment_border',
				'label' => __( 'Border', 'exclusive-addons-elementor-pro' ),
				'selector' => '{{WRAPPER}} .exad-woo-checkout .woocommerce-checkout-payment',
			]
		);

		$this->add_responsive_control(
            'exad_woo_checkout_payment_border_radius',
            [
                'label'      => __( 'Border Radius', 'exclusive-addons-elementor-pro' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'default'    => [
                    'top'      => '5',
                    'right'    => '5',
                    'bottom'   => '5',
                    'left'     => '5',
                    'unit'     => 'px',
                    'isLinked' => true,
                ],
                'selectors'  => [
                    '{{WRAPPER}} .exad-woo-checkout .woocommerce-checkout-payment' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                ],
            ]
		);

		$this->add_control(
			'exad_woo_checkout_payment_payment_method_label',
			[
				'label' => __( 'Payment Method Label', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'exad_woo_checkout_payment_payment_method_text_color',
			[
				'label'     => esc_html__('Text Color', 'exclusive-addons-elementor-pro'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .exad-woo-checkout .woocommerce-checkout-payment li label' => 'color: {{VALUE}};',
				]
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'exad_woo_checkout_payment_payment_method_typography',
				'label' => __( 'Typography', 'exclusive-addons-elementor-pro' ),
				'selector' => '{{WRAPPER}} .exad-woo-checkout .woocommerce-checkout-payment li label',
			]
		);

		$this->add_control(
			'exad_woo_checkout_payment_payment_method_box',
			[
				'label' => __( 'Payment Method Box', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'exad_woo_checkout_payment_payment_method_box_background_color',
			[
				'label'     => esc_html__('Background Color', 'exclusive-addons-elementor-pro'),
				'type'      => Controls_Manager::COLOR,
				'default' 	=> '#d9d9d9',
				'selectors' => [
					'{{WRAPPER}} .exad-woo-checkout .woocommerce-checkout-payment li .payment_box' => 'background-color: {{VALUE}} !important;',
					'{{WRAPPER}} .exad-woo-checkout .woocommerce-checkout-payment li .payment_box:before' => 'border-bottom-color: {{VALUE}} !important;',
				]
			]
		);

		$this->add_control(
			'exad_woo_checkout_payment_payment_method_box_text_color',
			[
				'label'     => esc_html__('Text Color', 'exclusive-addons-elementor-pro'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .exad-woo-checkout .woocommerce-checkout-payment li .payment_box' => 'color: {{VALUE}} !important;',
				]
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'exad_woo_checkout_payment_payment_method_box_typography',
				'label' => __( 'Typography', 'exclusive-addons-elementor-pro' ),
				'selector' => '{{WRAPPER}} .exad-woo-checkout .woocommerce-checkout-payment li .payment_box p',
			]
		);

		$this->add_responsive_control(
            'exad_woo_checkout_payment_payment_method_box_radius',
            [
                'label'      => __( 'Border radius', 'exclusive-addons-elementor-pro' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'default'    => [
                    'top'      => '0',
                    'right'    => '0',
                    'bottom'   => '0',
                    'left'     => '0',
                    'unit'     => 'px',
                    'isLinked' => true,
                ],
                'selectors'  => [
                    '{{WRAPPER}} .exad-woo-checkout .woocommerce-checkout-payment li .payment_box' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                ],
            ]
		);

		$this->add_control(
			'exad_woo_checkout_payment_privacy_policy',
			[
				'label' => __( 'Payment Privacy Policy', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'exad_woo_checkout_payment_privacy_policy_typography',
				'label' => __( 'Typography', 'exclusive-addons-elementor-pro' ),
				'selector' => '{{WRAPPER}} .exad-woo-checkout .woocommerce-checkout-payment .woocommerce-privacy-policy-text',
			]
		);

		$this->add_control(
			'exad_woo_checkout_payment_privacy_policy_color',
			[
				'label'     => esc_html__('Text Color', 'exclusive-addons-elementor-pro'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .exad-woo-checkout .woocommerce-checkout-payment .woocommerce-privacy-policy-text' => 'color: {{VALUE}} !important;',
				]
			]
		);

		$this->add_control(
			'exad_woo_checkout_payment_privacy_policy_link_color',
			[
				'label'     => esc_html__('Link Text Color', 'exclusive-addons-elementor-pro'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .exad-woo-checkout .woocommerce-checkout-payment .woocommerce-privacy-policy-text a' => 'color: {{VALUE}} !important;',
				]
			]
		);

		$this->add_control(
			'exad_woo_checkout_payment_privacy_policy_saperator_color',
			[
				'label'     => esc_html__('Separator Color', 'exclusive-addons-elementor-pro'),
				'type'      => Controls_Manager::COLOR,
				'default' 	=> '#d9d9d9',
				'selectors' => [
					'{{WRAPPER}} .exad-woo-checkout .woocommerce-checkout #payment ul.payment_methods' => 'border-bottom-color: {{VALUE}} !important;',
				]
			]
		);

		$this->add_control(
			'exad_woo_checkout_payment_button',
			[
				'label' => __( 'Payment Button', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
            'exad_woo_checkout_payment_button_padding',
            [
                'label'      => __( 'Padding', 'exclusive-addons-elementor-pro' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'default'    => [
                    'top'      => '12',
                    'right'    => '20',
                    'bottom'   => '12',
                    'left'     => '20',
                    'unit'     => 'px',
                    'isLinked' => true,
                ],
                'selectors'  => [
                    '{{WRAPPER}} .exad-woo-checkout .woocommerce-checkout-payment #place_order' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                ],
            ]
		);

		$this->add_responsive_control(
            'exad_woo_checkout_payment_button_margin',
            [
                'label'      => __( 'Margin', 'exclusive-addons-elementor-pro' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'default'    => [
                    'top'      => '0',
                    'right'    => '0',
                    'bottom'   => '0',
                    'left'     => '0',
                    'unit'     => 'px',
                    'isLinked' => true,
                ],
                'selectors'  => [
                    '{{WRAPPER}} .exad-woo-checkout .woocommerce-checkout-payment #place_order' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                ],
            ]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'exad_woo_checkout_payment_button_typography',
				'label' => __( 'Typography', 'exclusive-addons-elementor-pro' ),
				'selector' => '{{WRAPPER}} .exad-woo-checkout .woocommerce-checkout-payment #place_order',
			]
		);

		$this->add_responsive_control(
            'exad_woo_checkout_payment_button_border_radius',
            [
                'label'      => __( 'Border Radius', 'exclusive-addons-elementor-pro' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'default'    => [
                    'top'      => '0',
                    'right'    => '0',
                    'bottom'   => '0',
                    'left'     => '0',
                    'unit'     => 'px',
                    'isLinked' => true,
                ],
                'selectors'  => [
                    '{{WRAPPER}} .exad-woo-checkout .woocommerce-checkout-payment #place_order' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                ],
            ]
		);

		$this->start_controls_tabs( 'exad_woo_checkout_payment_button_tabs' );

            // Table Product
			$this->start_controls_tab( 'exad_woo_checkout_payment_button_normal', [ 'label' => esc_html__( 'Normal', 'exclusive-addons-elementor-pro' ) ] );

				$this->add_control(
					'exad_woo_checkout_payment_button_normal_color',
					[
						'label'     => esc_html__('Text Color', 'exclusive-addons-elementor-pro'),
						'type'      => Controls_Manager::COLOR,
						'default' 	=> '#ffffff',
						'selectors' => [
							'{{WRAPPER}} .exad-woo-checkout .woocommerce-checkout-payment #place_order' => 'color: {{VALUE}};',
						]
					]
				);

				$this->add_control(
					'exad_woo_checkout_payment_button_normal_background_color',
					[
						'label'     => esc_html__('Background Color', 'exclusive-addons-elementor-pro'),
						'type'      => Controls_Manager::COLOR,
						'default' 	=> '#000000',
						'selectors' => [
							'{{WRAPPER}} .exad-woo-checkout .woocommerce-checkout-payment #place_order' => 'background: {{VALUE}};',
						]
					]
				);

				$this->add_group_control(
					Group_Control_Border::get_type(),
					[
						'name' => 'exad_woo_checkout_payment_button_normal_border',
						'label' => __( 'Border', 'exclusive-addons-elementor-pro' ),
						'selector' => '{{WRAPPER}} .exad-woo-checkout .woocommerce-checkout-payment #place_order',
					]
				);

				$this->add_group_control(
					Group_Control_Box_Shadow::get_type(),
					[
						'name' => 'exad_woo_checkout_payment_button_normal_box_shadow',
						'label' => __( 'Box Shadow', 'exclusive-addons-elementor-pro' ),
						'selector' => '{{WRAPPER}} .exad-woo-checkout .woocommerce-checkout-payment #place_order',
					]
				);

			$this->end_controls_tab();
			
            // Table Footer
			$this->start_controls_tab( 'exad_woo_checkout_payment_button_hover', [ 'label' => esc_html__( 'Hover', 'exclusive-addons-elementor-pro' ) ] );

				$this->add_control(
					'exad_woo_checkout_payment_button_hover_color',
					[
						'label'     => esc_html__('Text Color', 'exclusive-addons-elementor-pro'),
						'type'      => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .exad-woo-checkout .woocommerce-checkout-payment #place_order:hover' => 'color: {{VALUE}};',
						]
					]
				);

				$this->add_control(
					'exad_woo_checkout_payment_button_hover_background_color',
					[
						'label'     => esc_html__('Background Color', 'exclusive-addons-elementor-pro'),
						'type'      => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .exad-woo-checkout .woocommerce-checkout-payment #place_order:hover' => 'background: {{VALUE}};',
						]
					]
				);

				$this->add_group_control(
					Group_Control_Border::get_type(),
					[
						'name' => 'exad_woo_checkout_payment_button_hover_border',
						'label' => __( 'Border', 'exclusive-addons-elementor-pro' ),
						'selector' => '{{WRAPPER}} .exad-woo-checkout .woocommerce-checkout-payment #place_order:hover',
					]
				);

				$this->add_group_control(
					Group_Control_Box_Shadow::get_type(),
					[
						'name' => 'exad_woo_checkout_payment_button_hover_box_shadow',
						'label' => __( 'Box Shadow', 'exclusive-addons-elementor-pro' ),
						'selector' => '{{WRAPPER}} .exad-woo-checkout .woocommerce-checkout-payment #place_order:hover',
					]
				);
			
            $this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

    }

    protected function render() {
        if( ! class_exists('woocommerce') ) {
	        return;
        }

		$settings           = $this->get_settings_for_display();
		?>

		<div class="exad-woo-checkout <?php echo $settings['exad_woo_checkout_layout']; ?>">

			<?php do_action( 'exad_woo_before_checkout_wrap' ); ?>

				<div class="exad-woo-checkout-wrapper">
					<?php do_action( 'exad_woo_before_checkout_content' ); ?>
						<?php echo do_shortcode( '[woocommerce_checkout]' ); ?>
					<?php do_action( 'exad_woo_after_checkout_content' ); ?>
				</div>

			<?php do_action( 'exad_woo_after_checkout_wrap' ); ?>

		</div>

		<?php
    }
}