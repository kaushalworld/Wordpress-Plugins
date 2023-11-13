<?php

namespace Elementor;

defined( 'ABSPATH' ) || exit;

use ShopEngine\Widgets\Products;

class ShopEngine_Checkout_Order_Pay extends \ShopEngine\Base\Widget
{
    public function config()
    {
        return new ShopEngine_Checkout_Order_Pay_Config();
    }

    protected function register_controls()
    {
        $this->start_controls_section(
			'shopengine_order_pay_table_header_section',
			array(
				'label' => esc_html__('Table Header', 'shopengine-pro'),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

        $this->add_control(
			'shopengine_order_pay_table_header_text_color',
			[
				'label'     => esc_html__('Text Color', 'shopengine-pro'),
				'type'      => Controls_Manager::COLOR,
				'alpha'		=> false,
				'default'   => '#3A3A3A',
				'selectors' => [
					'{{WRAPPER}} .shopengine-widget .shopengine-checkout-order-pay .shop_table thead tr th' => 'color: {{VALUE}};',
				]
			]
		);

        $this->add_control(
			'shopengine_order_pay_table_header_bg_color',
			[
				'label'     => esc_html__('Background Color', 'shopengine-pro'),
				'type'      => Controls_Manager::COLOR,
				'alpha'		=> false,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .shopengine-widget .shopengine-checkout-order-pay .shop_table thead tr' => 'background-color: {{VALUE}};',
				]
			]
		);

        $this->add_control(
			'shopengine_order_pay_table_header_border_bottom_color',
			[
				'label'     => esc_html__('Border Bottom Color', 'shopengine-pro'),
				'type'      => Controls_Manager::COLOR,
				'alpha'		=> false,
				'default'   => '#DCDCDC',
				'selectors' => [
					'{{WRAPPER}} .shopengine-widget .shopengine-checkout-order-pay .shop_table thead tr th' => 'box-shadow: 0px 1px {{VALUE}}, 0 3px #fff;',
				]
			]
		);

        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'           => 'shopengine_order_pay_table_header_typography',
				'label'          => esc_html__('Typography', 'shopengine-pro'),
				'selector'       => '{{WRAPPER}} .shopengine-widget .shopengine-checkout-order-pay .shop_table thead tr th',
				'exclude'        => ['font_family', 'text_decoration', 'font_style', 'letter_spacing'],
				'fields_options' => [
					'typography'     => [
						'default' => 'custom',
					],
					'font_size'      => [
						'label'      => esc_html__('Font Size (px)', 'shopengine-pro'),
						'size_units' => ['px'],
						'default'    => [
							'size' => '16',
							'unit' => 'px'
						]
					],
					'font_weight'    => [
						'default' => '600',
					],
				],
			]
		);

        $this->add_responsive_control(
			'shopengine_order_pay_table_header_padding',
			[
				'label'      => esc_html__('Padding (px)', 'shopengine-pro'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px'],
				'default'    => [
					'top'      => '8',
					'right'    => '14',
					'bottom'   => '8',
					'left'     => '14',
					'unit'     => 'px',
					'isLinked' => true,
				],
				'selectors'  => [
					'{{WRAPPER}} .shopengine-widget .shopengine-checkout-order-pay .shop_table thead tr th' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.rtl {{WRAPPER}} .shopengine-widget .shopengine-checkout-order-pay .shop_table thead tr th' => 'padding: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				],
			]
		);

        $this->end_controls_section();

        $this->start_controls_section(
			'shopengine_order_pay_table_body_section',
			array(
				'label' => esc_html__('Table Body', 'shopengine-pro'),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

        $this->add_control(
			'shopengine_order_pay_table_body_text_color',
			[
				'label'     => esc_html__('Text Color', 'shopengine-pro'),
				'type'      => Controls_Manager::COLOR,
				'alpha'		=> false,
				'default'   => '#3A3A3A',
				'selectors' => [
					'{{WRAPPER}} .shopengine-widget .shopengine-checkout-order-pay .shop_table tbody .order_item td' => 'color: {{VALUE}};',
				]
			]
		);

        $this->add_control(
			'shopengine_order_pay_table_body_bg_color',
			[
				'label'     => esc_html__('Background Color', 'shopengine-pro'),
				'type'      => Controls_Manager::COLOR,
				'alpha'		=> false,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .shopengine-widget .shopengine-checkout-order-pay .shop_table tbody .order_item' => 'background-color: {{VALUE}};',
				]
			]
		);

        $this->add_control(
			'shopengine_order_pay_table_body_border_bottom_color',
			[
				'label'     => esc_html__('Border Bottom Color', 'shopengine-pro'),
				'type'      => Controls_Manager::COLOR,
				'alpha'		=> false,
				'default'   => '#DCDCDC',
				'selectors' => [
					'{{WRAPPER}} .shopengine-widget .shopengine-checkout-order-pay .shop_table tbody .order_item' => 'box-shadow: 0px 1px {{VALUE}}, 0 3px #fff;',
				]
			]
		);

        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'           => 'shopengine_order_pay_table_body_typography',
				'label'          => esc_html__('Typography', 'shopengine-pro'),
				'selector'       => '{{WRAPPER}} .shopengine-widget .shopengine-checkout-order-pay .shop_table tbody .order_item td',
				'exclude'        => ['font_family', 'text_decoration', 'font_style', 'letter_spacing'],
				'fields_options' => [
					'typography'     => [
						'default' => 'custom',
					],
					'font_size'      => [
						'label'      => esc_html__('Font Size (px)', 'shopengine-pro'),
						'size_units' => ['px'],
						'default'    => [
							'size' => '14',
							'unit' => 'px'
						]
					],
					'font_weight'    => [
						'default' => '400',
					],
				],
			]
		);

        $this->add_responsive_control(
			'shopengine_order_pay_table_body_padding',
			[
				'label'      => esc_html__('Padding (px)', 'shopengine-pro'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px'],
				'default'    => [
					'top'      => '8',
					'right'    => '14',
					'bottom'   => '8',
					'left'     => '14',
					'unit'     => 'px',
					'isLinked' => true,
				],
				'selectors'  => [
					'{{WRAPPER}} .shopengine-widget .shopengine-checkout-order-pay .shop_table tbody .order_item td' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.rtl {{WRAPPER}} .shopengine-widget .shopengine-checkout-order-pay .shop_table tbody .order_item td' => 'padding: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				],
			]
		);

        $this->end_controls_section();

        $this->start_controls_section(
			'shopengine_order_pay_table_footer_section',
			array(
				'label' => esc_html__('Table Footer', 'shopengine-pro'),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

        $this->add_control(
			'shopengine_order_pay_table_footer_text_color',
			[
				'label'     => esc_html__('Text Color', 'shopengine-pro'),
				'type'      => Controls_Manager::COLOR,
				'alpha'		=> false,
				'default'   => '#3A3A3A',
				'selectors' => [
					'{{WRAPPER}} .shopengine-widget .shopengine-checkout-order-pay .shop_table tfoot tr :is(th, td)' => 'color: {{VALUE}};',
				]
			]
		);

        $this->add_control(
			'shopengine_order_pay_table_footer_bg_color',
			[
				'label'     => esc_html__('Background Color', 'shopengine-pro'),
				'type'      => Controls_Manager::COLOR,
				'alpha'		=> false,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .shopengine-widget .shopengine-checkout-order-pay .shop_table tfoot tr' => 'background-color: {{VALUE}};',
				]
			]
		);

        $this->add_control(
			'shopengine_order_pay_table_footer_border_bottom_color',
			[
				'label'     => esc_html__('Border Bottom Color', 'shopengine-pro'),
				'type'      => Controls_Manager::COLOR,
				'alpha'		=> false,
				'default'   => '#DCDCDC',
				'selectors' => [
					'{{WRAPPER}} .shopengine-widget .shopengine-checkout-order-pay .shop_table tfoot tr' => 'box-shadow: 0px 1px {{VALUE}}, 0 3px #fff;',
				]
			]
		);

        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'           => 'shopengine_order_pay_table_footer_typography',
				'label'          => esc_html__('Typography', 'shopengine-pro'),
				'selector'       => '{{WRAPPER}} .shopengine-widget .shopengine-checkout-order-pay .shop_table tfoot tr :is(th, td)',
				'exclude'        => ['font_family', 'text_decoration', 'font_style', 'letter_spacing'],
				'fields_options' => [
					'typography'     => [
						'default' => 'custom',
					],
					'font_size'      => [
						'label'      => esc_html__('Font Size (px)', 'shopengine-pro'),
						'size_units' => ['px'],
						'default'    => [
							'size' => '14',
							'unit' => 'px'
						]
					],
					'font_weight'    => [
						'default' => '400',
					],
				],
			]
		);

        $this->add_responsive_control(
			'shopengine_order_pay_table_footer_padding',
			[
				'label'      => esc_html__('Padding (px)', 'shopengine-pro'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px'],
				'default'    => [
					'top'      => '8',
					'right'    => '14',
					'bottom'   => '8',
					'left'     => '14',
					'unit'     => 'px',
					'isLinked' => true,
				],
				'selectors'  => [
					'{{WRAPPER}} .shopengine-widget .shopengine-checkout-order-pay .shop_table tfoot tr :is(th, td)' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.rtl {{WRAPPER}} .shopengine-widget .shopengine-checkout-order-pay .shop_table tfoot tr :is(th, td)' => 'padding: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				],
			]
		);

        $this->end_controls_section();

        $this->start_controls_section(
			'shopengine_order_pay_payment_section',
			array(
				'label' => esc_html__('Payment Methods', 'shopengine-pro'),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

        $this->add_control(
			'shopengine_order_pay_payment_label',
			[
				'label' => esc_html__('Label', 'shopengine-pro'),
				'type'  => Controls_Manager::HEADING,
                'separator' => 'after'
			]
		);

        $this->add_control(
			'shopengine_order_pay_payment_label_color',
			[
				'label'     => esc_html__('Label Color', 'shopengine-pro'),
				'type'      => Controls_Manager::COLOR,
				'alpha'		=> false,
				'default'   => '#3A3A3A',
				'selectors' => [
					'{{WRAPPER}} .shopengine-widget .shopengine-checkout-order-pay #payment .wc_payment_methods .wc_payment_method label' => 'color: {{VALUE}};',
				]
			]
		);

        $this->add_control(
			'shopengine_order_pay_payment_label_gap',
			[
				'label'      => esc_html__('Label Gap(px)', 'shopengine-pro'),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range'      => [
					'px' => [
						'min'  => 0,
						'max'  => 100,
						'step' => 1,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .shopengine-widget .shopengine-checkout-order-pay #payment .wc_payment_methods .wc_payment_method label' => 'margin-left: {{SIZE}}{{UNIT}};',
				],
			]
		);

        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'           => 'shopengine_order_pay_payment_label_typography',
				'label'          => esc_html__('Label Typography', 'shopengine-pro'),
				'selector'       => '{{WRAPPER}} .shopengine-widget .shopengine-checkout-order-pay #payment .wc_payment_methods .wc_payment_method label',
				'exclude'        => ['font_family', 'text_decoration', 'font_style', 'letter_spacing'],
				'fields_options' => [
					'typography'     => [
						'default' => 'custom',
					],
					'font_size'      => [
						'label'      => esc_html__('Font Size (px)', 'shopengine-pro'),
						'size_units' => ['px'],
						'default'    => [
							'size' => '16',
							'unit' => 'px'
						]
					],
					'font_weight'    => [
						'default' => '400',
					],
				],
			]
		);

        $this->add_control(
			'shopengine_order_pay_payment_checkbox',
			[
				'label' => esc_html__('Checkbox', 'shopengine-pro'),
				'type'  => Controls_Manager::HEADING,
                'separator' => 'after'
			]
		);

        $this->add_control(
			'shopengine_order_pay_payment_checkbox_color',
			[
				'label'     => esc_html__('Checkbox Color', 'shopengine-pro'),
				'type'      => Controls_Manager::COLOR,
				'alpha'		=> false,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .shopengine-widget .shopengine-checkout-order-pay #payment .wc_payment_methods .wc_payment_method .input-radio' => 'accent-color: {{VALUE}};',
				]
			]
		);

        $this->add_control(
			'shopengine_order_pay_payment_checkbox_position',
			[
				'label'      => esc_html__('Checkbox PositonY(px)', 'shopengine-pro'),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range'      => [
					'px' => [
						'min'  => 0,
						'max'  => 50,
						'step' => 1,
					],
				],
				'default'    => [
					'unit' => 'px',
					'size' => 6,
				],
				'selectors'  => [
					'{{WRAPPER}} .shopengine-widget .shopengine-checkout-order-pay #payment .wc_payment_methods .wc_payment_method .input-radio' => 'transform: translateY({{SIZE}}{{UNIT}});',
				],
			]
		);

		$this->add_control(
			'shopengine_order_pay_payment_description',
			[
				'label' => esc_html__('Description', 'shopengine-pro'),
				'type'  => Controls_Manager::HEADING,
                'separator' => 'after'
			]
		);

		$this->add_control(
			'shopengine_order_pay_payment_description_color',
			[
				'label'     => esc_html__('Description Color', 'shopengine-pro'),
				'type'      => Controls_Manager::COLOR,
				'alpha'		=> false,
				'default'   => '#979797',
				'selectors' => [
					'{{WRAPPER}} .shopengine-widget .shopengine-checkout-order-pay #payment .wc_payment_methods .wc_payment_method .payment_box' => 'color: {{VALUE}};',
				]
			]
		);

		$this->add_control(
			'shopengine_order_pay_payment_description_bg_color',
			[
				'label'     => esc_html__('Description Background', 'shopengine-pro'),
				'type'      => Controls_Manager::COLOR,
				'alpha'		=> false,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .shopengine-widget .shopengine-checkout-order-pay #payment .wc_payment_methods .wc_payment_method .payment_box' => 'background-color: {{VALUE}};',
				]
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'           => 'shopengine_order_pay_payment_description_typography',
				'label'          => esc_html__('Description Typography', 'shopengine-pro'),
				'selector'       => '{{WRAPPER}} .shopengine-widget .shopengine-checkout-order-pay #payment .wc_payment_methods .wc_payment_method .payment_box',
				'exclude'        => ['font_family', 'text_decoration', 'font_style', 'letter_spacing'],
				'fields_options' => [
					'typography'     => [
						'default' => 'custom',
					],
					'font_size'      => [
						'label'      => esc_html__('Font Size (px)', 'shopengine-pro'),
						'size_units' => ['px'],
						'default'    => [
							'size' => '13',
							'unit' => 'px'
						]
					],
					'font_weight'    => [
						'default' => '400',
					],
				],
			]
		);

		$this->add_responsive_control(
			'shopengine_order_pay_payment_description_padding',
			[
				'label'      => esc_html__('Padding (px)', 'shopengine-pro'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px'],
				'default'    => [
					'top'      => '5',
					'right'    => '30',
					'bottom'   => '0',
					'left'     => '30',
					'unit'     => 'px',
					'isLinked' => false,
				],
				'selectors'  => [
					'{{WRAPPER}} .shopengine-widget .shopengine-checkout-order-pay #payment .wc_payment_methods .wc_payment_method .payment_box' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.rtl {{WRAPPER}} .shopengine-widget .shopengine-checkout-order-pay #payment .wc_payment_methods .wc_payment_method .payment_box' => 'padding: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'shopengine_order_pay_payment_description_margin',
			[
				'label'      => esc_html__('Margin (px)', 'shopengine-pro'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px'],
				'selectors'  => [
					'{{WRAPPER}} .shopengine-widget .shopengine-checkout-order-pay #payment .wc_payment_methods .wc_payment_method .payment_box' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.rtl {{WRAPPER}} .shopengine-widget .shopengine-checkout-order-pay #payment .wc_payment_methods .wc_payment_method .payment_box' => 'margin: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				],
			]
		);

        $this->end_controls_section();

		$this->start_controls_section(
			'shopengine_order_pay_order_button_section',
			array(
				'label' => esc_html__('Order Button', 'shopengine-pro'),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		$this->start_controls_tabs(
			'shopengine_order_pay_order_button_colors_tab'
		);

		$this->start_controls_tab(
			'shopengine_order_pay_order_button_color_normal_tab',
			[
				'label' => esc_html__( 'Normal', 'shopengine-pro' ),
			]
		);

		$this->add_control(
			'shopengine_order_pay_order_button_color_normal',
			[
				'label'     => esc_html__('Color', 'shopengine-pro'),
				'type'      => Controls_Manager::COLOR,
				'alpha'		=> false,
				'default'   => '#fff',
				'selectors' => [
					'{{WRAPPER}} .shopengine-widget .shopengine-checkout-order-pay #payment .form-row #place_order' => 'color: {{VALUE}};',
				]
			]
		);

		$this->add_control(
			'shopengine_order_pay_order_button_bg_normal',
			[
				'label'     => esc_html__('Background Color', 'shopengine-pro'),
				'type'      => Controls_Manager::COLOR,
				'alpha'		=> false,
				'default'   => '#101010',
				'selectors' => [
					'{{WRAPPER}} .shopengine-widget .shopengine-checkout-order-pay #payment .form-row #place_order' => 'background-color: {{VALUE}};',
				]
			]
		);
		
		$this->end_controls_tab();
		$this->start_controls_tab(
			'shopengine_order_pay_order_button_color_hover_tab',
			[
				'label' => esc_html__( 'Hover', 'shopengine-pro' ),
			]
		);

		$this->add_control(
			'shopengine_order_pay_order_button_color_hover',
			[
				'label'     => esc_html__('Color', 'shopengine-pro'),
				'type'      => Controls_Manager::COLOR,
				'alpha'		=> false,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .shopengine-widget .shopengine-checkout-order-pay #payment .form-row #place_order:hover' => 'color: {{VALUE}};',
				]
			]
		);

		$this->add_control(
			'shopengine_order_pay_order_button_bg_hover',
			[
				'label'     => esc_html__('Background Color', 'shopengine-pro'),
				'type'      => Controls_Manager::COLOR,
				'alpha'		=> false,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .shopengine-widget .shopengine-checkout-order-pay #payment .form-row #place_order:hover' => 'background-color: {{VALUE}};',
				]
			]
		);

		$this->add_control(
			'shopengine_order_pay_order_button_border_color_hover',
			[
				'label'     => esc_html__('Border Color', 'shopengine-pro'),
				'type'      => Controls_Manager::COLOR,
				'alpha'		=> false,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .shopengine-widget .shopengine-checkout-order-pay #payment .form-row #place_order:hover' => 'border-color: {{VALUE}};',
				]
			]
		);
		
		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'           => 'shopengine_order_pay_order_button_typography',
				'label'          => esc_html__('Typography', 'shopengine-pro'),
				'selector'       => '{{WRAPPER}} .shopengine-widget .shopengine-checkout-order-pay #payment .form-row #place_order',
				'separator'      => 'before',
				'exclude'        => ['font_family', 'text_decoration', 'font_style', 'letter_spacing'],
				'fields_options' => [
					'typography'     => [
						'default' => 'custom',
					],
					'font_size'      => [
						'label'      => esc_html__('Font Size (px)', 'shopengine-pro'),
						'size_units' => ['px'],
						'default'    => [
							'size' => '16',
							'unit' => 'px'
						]
					],
					'font_weight'    => [
						'default' => '400',
					],
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'shopengine_order_pay_order_button_border',
				'selector' => '{{WRAPPER}} .shopengine-widget .shopengine-checkout-order-pay #payment .form-row #place_order',
			]
		);

		$this->add_responsive_control(
			'shopengine_order_pay_order_button_padding',
			[
				'label'      => esc_html__('Padding (px)', 'shopengine-pro'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px'],
				'selectors'  => [
					'{{WRAPPER}} .shopengine-widget .shopengine-checkout-order-pay #payment .form-row #place_order' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.rtl {{WRAPPER}} .shopengine-widget .shopengine-checkout-order-pay #payment .form-row #place_order' => 'padding: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'shopengine_order_pay_order_button_margin',
			[
				'label'      => esc_html__('Margin (px)', 'shopengine-pro'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px'],
				'selectors'  => [
					'{{WRAPPER}} .shopengine-widget .shopengine-checkout-order-pay #payment .form-row #place_order' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.rtl {{WRAPPER}} .shopengine-widget .shopengine-checkout-order-pay #payment .form-row #place_order' => 'margin: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'shopengine_order_pay_payment_privacy_section',
			array(
				'label' => esc_html__('Privacy & Policy', 'shopengine-pro'),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'shopengine_order_pay_payment_privacy_color',
			[
				'label'     => esc_html__('Color', 'shopengine-pro'),
				'type'      => Controls_Manager::COLOR,
				'alpha'		=> false,
				'default'   => '#979797',
				'selectors' => [
					'{{WRAPPER}} .shopengine-widget .shopengine-checkout-order-pay #payment .form-row .woocommerce-privacy-policy-text p' => 'color: {{VALUE}};',
				]
			]
		);

		$this->add_control(
			'shopengine_order_pay_payment_privacy_link_color',
			[
				'label'     => esc_html__('Link Color', 'shopengine-pro'),
				'type'      => Controls_Manager::COLOR,
				'alpha'		=> false,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .shopengine-widget .shopengine-checkout-order-pay #payment .form-row .woocommerce-privacy-policy-text p .woocommerce-privacy-policy-link' => 'color: {{VALUE}};',
				]
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'           => 'shopengine_order_pay_payment_privacy_typography',
				'label'          => esc_html__('Typography', 'shopengine-pro'),
				'selector'       => '{{WRAPPER}} .shopengine-widget .shopengine-checkout-order-pay #payment .form-row .woocommerce-privacy-policy-text p',
				'exclude'        => ['font_family', 'text_decoration', 'font_style', 'letter_spacing'],
				'fields_options' => [
					'typography'     => [
						'default' => 'custom',
					],
					'font_size'      => [
						'label'      => esc_html__('Font Size (px)', 'shopengine-pro'),
						'size_units' => ['px'],
						'default'    => [
							'size' => '13',
							'unit' => 'px'
						]
					],
					'font_weight'    => [
						'default' => '400',
					],
				],
			]
		);

		$this->add_responsive_control(
			'shopengine_order_pay_payment_privacy_padding',
			[
				'label'      => esc_html__('Padding (px)', 'shopengine-pro'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px'],
				'selectors'  => [
					'{{WRAPPER}} .shopengine-widget .shopengine-checkout-order-pay #payment .form-row .woocommerce-privacy-policy-text ' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.rtl {{WRAPPER}} .shopengine-widget .shopengine-checkout-order-pay #payment .form-row .woocommerce-privacy-policy-text ' => 'padding: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
    }

    protected function screen()
    {
        $settings = $this->get_settings_for_display();

        $tpl = Products::instance()->get_widget_template( $this->get_name(), 'default', \ShopEngine_Pro::widget_dir() );

        include $tpl;
    }
}
