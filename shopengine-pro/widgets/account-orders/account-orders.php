<?php

namespace Elementor;

use ShopEngine\Widgets\Products;

defined('ABSPATH') || exit;


class ShopEngine_Account_Orders extends \ShopEngine\Base\Widget
{

	public function config() {
		return new ShopEngine_Account_Orders_Config();
	}

	protected function register_controls() {


		/*
			---------------------------------
			  Header Section
			------------------------------------
		 */

		$this->start_controls_section(
			'shopengine_section_orders_header',
			[
				'label' => esc_html__('Table Heading', 'shopengine-pro'),
				'tab'   => Controls_Manager::TAB_STYLE
			]
		);

		$this->add_control(
			'shopengine_orders_header_color',
			[
				'label'     => esc_html__('Text Color', 'shopengine-pro'),
				'type'      => Controls_Manager::COLOR,
				'alpha'     => false,
				'default'   => '#3A3A3A',
				'selectors' => [
					'{{WRAPPER}} .shopengine-account-orders .woocommerce-orders-table .woocommerce-orders-table__header' => 'color: {{VALUE}}',
					'{{WRAPPER}} .shopengine-account-orders .woocommerce-order-details thead'                            => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'shopengine_orders_header_background',
			[
				'label'     => esc_html__('Background', 'shopengine-pro'),
				'type'      => Controls_Manager::COLOR,
				'alpha'     => false,
				'default'   => '#F5F5F5',
				'selectors' => [
					'{{WRAPPER}} .shopengine-account-orders .woocommerce-orders-table thead'  => 'background: {{VALUE}}',
					'{{WRAPPER}} .shopengine-account-orders .woocommerce-order-details thead' => 'background: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'shopengine_orders_header_text_typography',
				'label'    => esc_html__('Typography', 'shopengine-pro'),
				'selector' => '{{WRAPPER}} .shopengine-account-orders .woocommerce-orders-table .woocommerce-orders-table__header, {{WRAPPER}} .shopengine-account-orders .woocommerce-order-details thead',
				'exclude'  => ['letter_spacing', 'text_decoration'],

				'fields_options' => [
					'typography'  => [
						'default' => 'custom',
					],
					'font_weight' => [
						'default' => '600',
					],
					'font_size'   => [
						'label'      => esc_html__('Font Size (px)', 'shopengine-pro'),
						'default'    => [
							'size' => '16',
							'unit' => 'px'
						],
						'size_units' => ['px']
					],
					'line_height' => [
						'label'      => esc_html__('Line-Height (px)', 'shopengine-pro'),
						'size_units' => ['px']
					],
				],
			]
		);


		$this->end_controls_section(); // end ./ header section

		/*
			---------------------------------
			  body section  style
			------------------------------------
		 */

		$this->start_controls_section(
			'shopengine_section_orders_body',
			[
				'label' => esc_html__('Table Body', 'shopengine-pro'),
				'tab'   => Controls_Manager::TAB_STYLE
			]
		);

		$this->add_control(
			'shopengine_download_body_bg_color',
			[
				'label'     => esc_html__('Body Background', 'shopengine-pro'),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'alpha'     => false,
				'selectors' => [
					'{{WRAPPER}} .shopengine-account-orders .woocommerce-orders-table tbody' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'shopengine_orders_body_color',
			[
				'label'     => esc_html__('Text Color', 'shopengine-pro'),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#3A3A3A',
				'alpha'     => false,
				'selectors' => [
					'{{WRAPPER}} .shopengine-account-orders .woocommerce-orders-table .woocommerce-orders-table__cell'         => 'color: {{VALUE}}',
					'{{WRAPPER}} .shopengine-account-orders .woocommerce-orders-table .woocommerce-orders-table__cell .amount' => 'color: {{VALUE}}',
					'{{WRAPPER}} .shopengine-account-orders .woocommerce-order-details tbody'                                  => 'color: {{VALUE}}',
					'{{WRAPPER}} .shopengine-account-orders .woocommerce-order-details tfoot'                                  => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'shopengine_orders_body_link_color',
			[
				'label'     => esc_html__('Link Color', 'shopengine-pro'),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#4169E1',
				'alpha'     => false,
				'selectors' => [
					'{{WRAPPER}} .shopengine-account-orders .woocommerce-orders-table .woocommerce-orders-table__cell-order-number a' => 'color: {{VALUE}}',
					'{{WRAPPER}} .shopengine-account-orders .woocommerce-order-details tbody a'                                       => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'shopengine_orders_body_link_hover_color',
			[
				'label'     => esc_html__('Link Hover Color', 'shopengine-pro'),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#3A3A3A',
				'alpha'     => false,
				'selectors' => [
					'{{WRAPPER}} .shopengine-account-orders .woocommerce-orders-table .woocommerce-orders-table__cell-order-number a:hover' => 'color: {{VALUE}}',
					'{{WRAPPER}} {{WRAPPER}} .shopengine-account-orders .woocommerce-order-details tbody a:hover'                           => 'color: {{VALUE}}',
				]
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'shopengine_orders_body_text_typography',
				'label'    => esc_html__('Text Typography', 'shopengine-pro'),
				'selector' => '{{WRAPPER}} .shopengine-account-orders .woocommerce-orders-table > tbody .woocommerce-orders-table__row td, {{WRAPPER}} .shopengine-account-orders .woocommerce-order-details tbody, {{WRAPPER}} .shopengine-account-orders .woocommerce-order-details tfoot',
				'exclude'  => ['letter_spacing', 'text_decoration'],

				'fields_options' => [
					'typography'  => [
						'default' => 'custom',
					],
					'font_weight' => [
						'default' => '400',
					],
					'font_size'   => [
						'label'      => esc_html__('Font Size (px)', 'shopengine-pro'),
						'default'    => [
							'size' => '16',
							'unit' => 'px'
						],
						'size_units' => ['px']
					],
					'line_height' => [
						'label'          => esc_html__('Line-Height (px)', 'shopengine-pro'),
						'size_units'     => ['px']
					],
				],
			]
		);

		$this->add_control(
			'shopengine_orders_body_row_heading',
			[
				'label'     => esc_html__('Row Border and Responsive Stripe', 'shopengine-pro'),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'shopengine_orders_body_row_heading_note',
			[
				'type'            => Controls_Manager::RAW_HTML,
				'raw'             => esc_html__('Responsive stripe background Control appears on tablet and mobile devices', 'shopengine-pro'),
				'content_classes' => 'elementor-descriptor'
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'shopengine_orders_body_row_border',
				'label'    => esc_html__('Border', 'shopengine-pro'),
				'selector' => '{{WRAPPER}} .shopengine-account-orders .woocommerce-orders-table .woocommerce-orders-table__row, {{WRAPPER}} .shopengine-account-orders .woocommerce-order-details tbody tr, {{WRAPPER}} .shopengine-account-orders .woocommerce-order-details tfoot tr',
				'fields_options' => [
					'border_type' => [
						'default' => 'yes'
					],
					'border'      => [
						'default'    => 'solid',
						'devices'    => ['desktop'],
						'responsive' => true,
					],

					'width' => [
						'label'              => esc_html__('Border Width', 'shopengine-pro'),
						'allowed_dimensions' => ['bottom'],
						'default'            => [
							'bottom' => '1',
							'unit'   => 'px',
						],
						'devices'            => ['desktop'],
						'responsive'         => true,
					],

					'color' => [
						'label'      => esc_html__('Border Row Color', 'shopengine-pro'),
						'alpha'      => false,
						'default'    => '#F2F2F2',
						'devices'    => ['desktop'],
						'responsive' => true,
					],
				],

			]
		);

		$this->add_control(
			'shopengine_responsive_striped_bg',
			[
				'label'          => esc_html__('Striped Background', 'shopengine-pro'),
				'type'           => Controls_Manager::COLOR,
				'default'        => '#fff',
				'alpha'          => false,
				'selectors'      => [
					'{{WRAPPER}} .shopengine-account-orders table.shop_table_responsive tr:nth-child(even)' => 'background: {{VALUE}}',
				]
			]
		);

		$this->add_control(
			'shopengine_orders_body_cell_padding_divider',
			[
				'type' => Controls_Manager::DIVIDER,
			]
		);

		$this->add_responsive_control(
			'shopengine_orders_body_cell_padding',
			[
				'label'      => esc_html__('Cell Padding', 'shopengine-pro'),
				'type'       => Controls_Manager::DIMENSIONS,
				'default'    => [
					'top'      => '10',
					'right'    => '30',
					'bottom'   => '10',
					'left'     => '30',
					'unit'     => 'px',
					'isLinked' => true,
				],
				'size_units' => ['px'],
				'selectors'  => [
					'{{WRAPPER}} .shopengine-account-orders table :is(tbody, tfoot, thead) tr' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.rtl {{WRAPPER}} .shopengine-account-orders table :is(tbody, tfoot, thead) tr' => 'padding: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();  // end ./ body section style

		/*
			---------------------------------
			  Address Details Section
			------------------------------------
		 */
		$this->start_controls_section(
			'shopengine_section_order_address_details',
			[
				'label' => esc_html__('Address Details', 'shopengine-pro'),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'shopengine_account_order_title_color',
			[
				'label'     => esc_html__('Title Color', 'shopengine-pro'),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#3A3A3A',
				'selectors' => [
					'{{WRAPPER}} .shopengine-account-orders .woocommerce-customer-details h2' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'shopengine_account_order_address_color',
			[
				'label'     => esc_html__('Address Text Color', 'shopengine-pro'),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#979797',
				'selectors' => [
					'{{WRAPPER}} .shopengine-account-orders .woocommerce-customer-details address' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'shopengine_account_order_address_align',
			[
				'label'     => esc_html__('Align', 'shopengine-pro'),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => [
					'left'   => [
						'title' => esc_html__('Left', 'shopengine-pro'),
						'icon'  => 'eicon-text-align-left',
					],
					'center' => [
						'title' => esc_html__('Center', 'shopengine-pro'),
						'icon'  => 'eicon-text-align-center',
					],
					'right'  => [
						'title' => esc_html__('Right', 'shopengine-pro'),
						'icon'  => 'eicon-text-align-right',
					]
				],
				'prefix_class' => 'elementor-align-',
				'selectors' => [
					'{{WRAPPER}} .shopengine-account-orders .woocommerce-customer-details'         => 'text-align: {{VALUE}}',
					'.rtl {{WRAPPER}}.elementor-align-left .shopengine-account-orders .woocommerce-customer-details'         => 'text-align:right;', 
					'{{WRAPPER}} .shopengine-account-orders .woocommerce-customer-details address' => 'text-align: {{VALUE}}',
					'.rtl {{WRAPPER}}.elementor-align-right .shopengine-account-orders .woocommerce-customer-details address' => 'text-align:left;', 
				],
			]
		);

		$this->add_control(
			'shopengine_account_order_address_hide_icon',
			[
				'label'        => esc_html__('Hide Icon', 'shopengine-pro'),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__('Yes', 'shopengine-pro'),
				'label_off'    => esc_html__('No', 'shopengine-pro'),
				'default'      => false,
				'return_value' => true,
				'selectors'    => [
					'{{WRAPPER}} .shopengine-account-orders .woocommerce-customer-details address p::before' => 'display: none;',
					'{{WRAPPER}} .shopengine-account-orders .woocommerce-customer-details address p'         => 'padding-left: 0;',
				],
			]
		);

		$this->add_responsive_control(
			'shopengine_account_order_address_content_padding',
			[
				'label'      => esc_html__('Content Padding', 'shopengine-pro'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px'],
				'default'    => [
					'isLinked' => false,
				],
				'selectors'  => [
					'{{WRAPPER}} .shopengine-account-orders .woocommerce-customer-details address' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.rtl {{WRAPPER}} .shopengine-account-orders .woocommerce-customer-details address' => 'padding: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);

		$this->end_controls_section();

		/*
			---------------------------------
			  Action button
			------------------------------------
		 */

		$this->start_controls_section(
			'shopengine_orders_button_action_section',
			[
				'label' => esc_html__('Action Buttons', 'shopengine-pro'),
				'tab'   => Controls_Manager::TAB_STYLE
			]
		);

		$this->add_responsive_control(
			'shopengine_orders_action_button_padding',
			[
				'label'      => esc_html__('Padding', 'shopengine-pro'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px'],
				'default'    => [
					'top'      => '12',
					'right'    => '21',
					'bottom'   => '12',
					'left'     => '21',
					'unit'     => 'px',
					'isLinked' => false,
				],
				'selectors'  => [
					'{{WRAPPER}} .shopengine-account-orders .woocommerce-orders-table .button'  => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
					'.rtl {{WRAPPER}} .shopengine-account-orders .woocommerce-orders-table .button'  => 'padding: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}} !important;',
					'{{WRAPPER}} .shopengine-account-orders .woocommerce-pagination .button'    => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
					'.rtl {{WRAPPER}} .shopengine-account-orders .woocommerce-pagination .button'    => 'padding: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}} !important;',
					'{{WRAPPER}} .shopengine-account-orders .woocommerce-order-details .button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
					'.rtl {{WRAPPER}} .shopengine-account-orders .woocommerce-order-details .button' => 'padding: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}} !important;',
				]
			]
		);

		$this->add_control(
			'shopengine_orders_button_action_border_radius',
			[
				'label'      => esc_html__('Border Radius', 'shopengine-pro'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px'],
				'default'    => [
					'top'      => '3',
					'right'    => '3',
					'bottom'   => '3',
					'left'     => '3',
					'unit'     => 'px',
					'isLinked' => true,
				],
				'selectors'  => [
					'{{WRAPPER}} .shopengine-account-orders .woocommerce-orders-table .button'  => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.rtl {{WRAPPER}} .shopengine-account-orders .woocommerce-orders-table .button'  => 'border-radius: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
					'{{WRAPPER}} .shopengine-account-orders .woocommerce-pagination .button'    => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.rl {{WRAPPER}} .shopengine-account-orders .woocommerce-pagination .button'    => 'border-radius: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
					'{{WRAPPER}} .shopengine-account-orders .woocommerce-order-details .button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.rtl {{WRAPPER}} .shopengine-account-orders .woocommerce-order-details .button' => 'border-radius: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'shopengine_orders_button_view_typography',
				'label'    => esc_html__('Button Typography', 'shopengine-pro'),
				'selector' => '{{WRAPPER}} .shopengine-account-orders .woocommerce-orders-table .button, {{WRAPPER}} .shopengine-account-orders .woocommerce-pagination .button, {{WRAPPER}} .shopengine-account-orders .woocommerce-order-details .button',
				'exclude'  => ['letter_spacing', 'text_decoration', 'font_style', 'line_height'],

				'fields_options' => [
					'typography'  => [
						'default' => 'custom',
					],
					'font_weight' => [
						'default' => '500',
					],
					'font_size'   => [
						'label'      => esc_html__('Font Size (px)', 'shopengine-pro'),
						'default'    => [
							'size' => '15',
							'unit' => 'px'
						],
						'responsive' => false,
						'size_units' => ['px']
					],
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'shopengine_orders_button_view_box_shadow',
				'label'    => esc_html__('Box Shadow', 'shopengine-pro'),
				'selector' => '{{WRAPPER}} .shopengine-account-orders .woocommerce-orders-table tbody .woocommerce-orders-table__cell .button, {{WRAPPER}} .shopengine-account-orders .woocommerce-order-details .button',
			]
		);

		/**
		 * View button specific controls
		 */
		$this->add_control(
			'shopengine_orders_body_button_view_heading',
			[
				'label'     => esc_html__('View Button', 'shopengine-pro'),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before'
			]
		);

		$this->start_controls_tabs('shopengine_orders_button_view_style_tab');

		$this->start_controls_tab(
			'shopengine_orders_button_view_tabnormal',
			[
				'label' => esc_html__('Normal', 'shopengine-pro'),
			]
		);

		$this->add_control(
			'shopengine_orders_button_view_color_normal',
			[
				'label'     => esc_html__('Color', 'shopengine-pro'),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#3A3A3A',
				'alpha'     => false,
				'selectors' => [
					'{{WRAPPER}} .shopengine-account-orders .woocommerce-orders-table .woocommerce-orders-table__cell .button.view' => 'color: {{VALUE}} !important;',
					'{{WRAPPER}} .shopengine-account-orders .woocommerce-order-details .button'                                     => 'color: {{VALUE}} !important;'
				],
			]
		);

		$this->add_control(
			'shopengine_orders_button_view_background_normal',
			[
				'label'     => esc_html__('Background', 'shopengine-pro'),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#f1f1f1',
				'alpha'     => false,
				'selectors' => [
					'{{WRAPPER}} .shopengine-account-orders .woocommerce-orders-table tbody .woocommerce-orders-table__cell .button.view' => 'background-color: {{VALUE}} !important; width:initial;',
					'{{WRAPPER}} .shopengine-account-orders .woocommerce-order-details .button'                                           => 'background-color: {{VALUE}} !important; width:initial;',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'shopengine_orders_button_view_tabhover',
			[
				'label' => esc_html__('Hover', 'shopengine-pro'),
			]
		);

		$this->add_control(
			'shopengine_orders_button_view_color_hover',
			[
				'label'     => esc_html__('Color', 'shopengine-pro'),
				'type'      => Controls_Manager::COLOR,
				'alpha'     => false,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .shopengine-account-orders .woocommerce-orders-table .woocommerce-orders-table__cell .button.view:hover' => 'color: {{VALUE}} !important',
					'{{WRAPPER}} .shopengine-account-orders .woocommerce-order-details .button:hover'                                     => 'color: {{VALUE}} !important',
				],
			]
		);

		$this->add_control(
			'shopengine_orders_button_view_background_hover',
			[
				'label'     => esc_html__('Background', 'shopengine-pro'),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#3a3a3a',
				'alpha'     => false,
				'selectors' => [
					'{{WRAPPER}} .shopengine-account-orders .woocommerce-orders-table .woocommerce-orders-table__cell .button.view:hover' => 'background-color: {{VALUE}} !important;',
					'{{WRAPPER}} .shopengine-account-orders .woocommerce-order-details .button:hover'                                     => 'background-color: {{VALUE}} !important;z',
				],
			]
		);


		$this->end_controls_tab();

		$this->end_controls_tabs();

		/**
		 * Cancel button controls
		 */
		$this->add_control(
			'shopengine_orders_body_button_cancel_heading',
			[
				'label'     => esc_html__('Cancel Button', 'shopengine-pro'),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before'
			]
		);

		$this->start_controls_tabs('shopengine_orders_button_cancel_style_tab');

		$this->start_controls_tab(
			'shopengine_orders_button_cancel_tabnormal',
			[
				'label' => esc_html__('Normal', 'shopengine-pro'),
			]
		);

		$this->add_control(
			'shopengine_orders_button_cancel_color_normal',
			[
				'label'     => esc_html__('Color', 'shopengine-pro'),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#3A3A3A',
				'alpha'     => false,
				'selectors' => [
					'{{WRAPPER}} .shopengine-account-orders .woocommerce-orders-table .woocommerce-orders-table__cell .button.cancel' => 'color: {{VALUE}}'
				],
			]
		);

		$this->add_control(
			'shopengine_orders_button_cancel_background_normal',
			[
				'label'     => esc_html__('Background', 'shopengine-pro'),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#EFEFEF',
				'alpha'     => false,
				'selectors' => [
					'{{WRAPPER}} .shopengine-account-orders .woocommerce-orders-table tbody .woocommerce-orders-table__cell .button.cancel' => 'background: {{VALUE}}'
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'shopengine_orders_button_cancel_tabhover',
			[
				'label' => esc_html__('Hover', 'shopengine-pro'),
			]
		);

		$this->add_control(
			'shopengine_orders_button_cancel_color_hover',
			[
				'label'     => esc_html__('Color', 'shopengine-pro'),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .shopengine-account-orders .woocommerce-orders-table .woocommerce-orders-table__cell .button.cancel:hover' => 'color: {{VALUE}}'
				],
			]
		);

		$this->add_control(
			'shopengine_orders_button_cancel_background_hover',
			[
				'label'     => esc_html__('Background', 'shopengine-pro'),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#3a3a3a',
				'alpha'     => false,
				'selectors' => [
					'{{WRAPPER}} .shopengine-account-orders .woocommerce-orders-table .woocommerce-orders-table__cell .button.cancel:hover' => 'background: {{VALUE}}'
				],
			]
		);


		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->end_controls_section(); // end ./ action button

		/*
			---------------------------------
			  Pagination Section
			------------------------------------
		 */

		$this->start_controls_section(
			'shopengine_orders_button_pagination_section',
			[
				'label' => esc_html__('Pagination Button', 'shopengine-pro'),
				'tab'   => Controls_Manager::TAB_STYLE
			]
		);

		$this->add_responsive_control(
			'shopengine_orders_pagination_padding',
			[
				'label'      => esc_html__('Padding', 'shopengine-pro'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px'],
				'default'    => [
					'top'      => '9',
					'right'    => '21',
					'bottom'   => '10',
					'left'     => '21',
					'unit'     => 'px',
					'isLinked' => false,
				],
				'selectors'  => [
					'{{WRAPPER}} .shopengine-account-orders .woocommerce-pagination .button' => 'height:auto; padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.rtl {{WRAPPER}} .shopengine-account-orders .woocommerce-pagination .button' => 'height:auto; padding: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				]
			]
		);

		$this->add_control(
			'shopengine_orders_pagination_border_radius',
			[
				'label'      => esc_html__('Border Radius', 'shopengine-pro'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px'],
				'default'    => [
					'top'      => '3',
					'right'    => '3',
					'bottom'   => '3',
					'left'     => '3',
					'unit'     => 'px',
					'isLinked' => true,
				],
				'selectors'  => [
					'{{WRAPPER}} .shopengine-account-orders .woocommerce-pagination .button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.rtl {{WRAPPER}} .shopengine-account-orders .woocommerce-pagination .button' => 'border-radius: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				]
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'shopengine_orders_pagination_typography',
				'label'    => esc_html__('Button Typography', 'shopengine-pro'),
				'selector' => '{{WRAPPER}} .shopengine-account-orders .woocommerce-pagination .button',
				'exclude'  => ['letter_spacing', 'text_decoration', 'font_style', 'line_height'],

				'fields_options' => [
					'typography'  => [
						'default' => 'custom',
					],
					'font_weight' => [
						'default' => '500',
					],
					'font_size'   => [
						'label'      => esc_html__('Font Size (px)', 'shopengine-pro'),
						'default'    => [
							'size' => '15',
							'unit' => 'px'
						],
						'responsive' => false,
						'size_units' => ['px']
					],
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'shopengine_orders_pagination_box_shadow',
				'label'    => esc_html__('Box Shadow', 'shopengine-pro'),
				'selector' => '{{WRAPPER}} .shopengine-account-orders .woocommerce-pagination .button',
			]
		);

		/**
		 * Pagination button controls
		 */
		$this->add_control(
			'shopengine_orders_body_pagination_buttons_heading',
			[
				'label'     => esc_html__('Pagination Buttons', 'shopengine-pro'),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before'
			]
		);

		$this->add_control(
			'shopengine_orders_body_pagination_buttons_heading_note',
			[
				'type'            => Controls_Manager::RAW_HTML,
				'raw'             => esc_html__('The pagination buttons control will modify next and previous buttons', 'shopengine-pro'),
				'content_classes' => 'elementor-descriptor'
			]
		);

		$this->start_controls_tabs('shopengine_orders_body_pagination_buttons_tabs');

		$this->start_controls_tab(
			'shopengine_orders_body_pagination_tab_normal_tab',
			[
				'label' => esc_html__('Normal', 'shopengine-pro'),
			]
		);

		$this->add_control(
			'shopengine_orders_body_pagination_tab_normal_clr',
			[
				'label'     => esc_html__('Color', 'shopengine-pro'),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#3A3A3A',
				'alpha'     => false,
				'selectors' => [
					'{{WRAPPER}} .shopengine-account-orders .woocommerce-pagination .button' => 'color: {{VALUE}} !important'
				],
			]
		);

		$this->add_control(
			'shopengine_orders_body_pagination_tab_normal_bg',
			[
				'label'     => esc_html__('Background', 'shopengine-pro'),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#EFEFEF',
				'alpha'     => false,
				'selectors' => [
					'{{WRAPPER}} .shopengine-account-orders .woocommerce-pagination .button' => 'background: {{VALUE}} !important'
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'shopengine_orders_body_pagination_tab_hover',
			[
				'label' => esc_html__('Hover', 'shopengine-pro'),
			]
		);

		$this->add_control(
			'shopengine_orders_body_pagination_tab_hover_clr',
			[
				'label'     => esc_html__('Color', 'shopengine-pro'),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .shopengine-account-orders .woocommerce-pagination .button:hover' => 'color: {{VALUE}} !important'
				],
			]
		);

		$this->add_control(
			'shopengine_orders_body_pagination_tab_hover_bg',
			[
				'label'     => esc_html__('Background', 'shopengine-pro'),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#3a3a3a',
				'alpha'     => false,
				'selectors' => [
					'{{WRAPPER}} .shopengine-account-orders .woocommerce-pagination .button:hover' => 'background: {{VALUE}} !important'
				],
			]
		);


		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	/**
	 * Render widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function screen() {

		if(!is_user_logged_in()) {

			echo esc_html__('You need first to be logged in', 'shopengine-pro');

			return;
		}

		$tpl = Products::instance()->get_widget_template($this->get_name(), 'default', \ShopEngine_Pro::widget_dir());

		include $tpl;
	}
}
