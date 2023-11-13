<?php

namespace Elementor;

use ShopEngine\Widgets\Products;

defined('ABSPATH') || exit;


class ShopEngine_Account_Order_Details extends \ShopEngine\Base\Widget
{

	public function config() {
		return new ShopEngine_Account_Order_Details_Config();
	}

	protected function register_controls() {

		/*
			--------------------------
			Heading and Info start
			--------------------------
		*/


		$this->start_controls_section(
			'shopengine_account_order_heading',
			[
				'label' => esc_html__('Heading', 'shopengine-pro'),
				'tab'   => Controls_Manager::TAB_STYLE
			]
		);

		$this->add_control(
			'shopengine_account_order_hightlight_clr',
			[
				'label'     => esc_html__('Highlight color', 'shopengine-pro'),
				'type'      => Controls_Manager::COLOR,
				'alpha'     => false,
				'default'   => '#3A3A3A',
				'selectors' => [
					'{{WRAPPER}} .shopengine-account-order-details mark' => 'color: {{VALUE}}',
				],
			]
		);


		$this->add_control(
			'shopengine_account_order_hightlight_bg_clr',
			[
				'label'     => esc_html__('Highlight background color', 'shopengine-pro'),
				'type'      => Controls_Manager::COLOR,
				'alpha'     => false,
				'default'   => '#FFF8C0',
				'selectors' => [
					'{{WRAPPER}} .shopengine-account-order-details mark' => 'background: {{VALUE}}',
				],
				'separator'  => 'after',
			]
		);

		$this->add_control(
			'shopengine_account_order_heading_clr',
			[
				'label'     => esc_html__('Heading color', 'shopengine-pro'),
				'type'      => Controls_Manager::COLOR,
				'alpha'     => false,
				'default'   => '#3A3A3A',
				'selectors' => [
					'{{WRAPPER}} .shopengine-account-order-details :is(h1,h2,h3,h4,h5,h6)[class$="__title"]' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'shopengine_account_order_heading_typography',
				'label'    => esc_html__('Heading typography', 'shopengine-pro'),
				'selector' => '{{WRAPPER}} .shopengine-account-order-details :is(h1,h2,h3,h4,h5,h6)[class$="__title"]',
				'exclude'  => ['font_family', 'letter_spacing', 'font_style', 'text_decoration'],
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
							'size' => '22',
							'unit' => 'px'
						],
						'size_units' => ['px'],
						'responsive' => false,
					],
					'line_height' => [
						'label'      => esc_html__('Line-Height (px)', 'shopengine-pro'),
						'default'    => [
							'size' => '24',
							'unit' => 'px'
						],
						'size_units' => ['px'],
						'responsive' => false,
					],
				],
			]
		);


		$this->add_control(
			'shopengine_account_order_heading_margin',
			[
				'label'              => esc_html__('Heading margin', 'shopengine-pro'),
				'type'               => Controls_Manager::DIMENSIONS,
				'size_units'         => ['px'],
				'allowed_dimensions' => ['top', 'bottom'],
				'default'            => [
					'top'      => '0',
					'right'    => '0',
					'bottom'   => '15',
					'left'     => '0',
					'unit'     => 'px',
					'isLinked' => false,
				],
				'selectors'          => [
					'{{WRAPPER}} .shopengine-account-order-details :is(h1,h2,h3,h4,h5,h6)[class$="__title"]' => 'border:0;margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .shopengine-account-order-details section'                                  => 'margin: 0 !important',
				],
			]
		);


		$this->end_controls_section(); // end ./ header section

		/*
			---------------------------------
		  	Header Section
			------------------------------------
		 */

		$this->start_controls_section(
			'shopengine_account_table_heading',
			[
				'label' => esc_html__('Table and Title', 'shopengine-pro'),
				'tab'   => Controls_Manager::TAB_STYLE
			]
		);

		$this->add_control(
			'shopengine_account_table_heading_color',
			[
				'label'     => esc_html__('Text Color', 'shopengine-pro'),
				'type'      => Controls_Manager::COLOR,
				'alpha'     => false,
				'default'   => '#3A3A3A',
				'selectors' => [
					'{{WRAPPER}} .shopengine-account-order-details table thead tr th' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'shopengine_account_table_heading_background',
			[
				'label'     => esc_html__('Background', 'shopengine-pro'),
				'type'      => Controls_Manager::COLOR,
				'alpha'     => false,
				'default'   => '#F5F5F5',
				'selectors' => [
					'{{WRAPPER}} .shopengine-account-order-details table thead' => 'background: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'shopengine_account_table_heading_background_typography',
				'label'    => esc_html__('Typography', 'shopengine-pro'),
				'selector' => '{{WRAPPER}} .shopengine-account-order-details table thead th',
				'exclude'  => ['font_family', 'letter_spacing', 'text_decoration', 'line_height', 'font_style'],
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
						'size_units' => ['px'],
						'responsive' => false,
					]

				],
			]
		);

		$this->add_control(
			'shopengine_account_table_horizontial_padding_divider',
			[
				'type' => Controls_Manager::DIVIDER,
			]
		);

		$this->add_responsive_control(
			'shopengine_account_table_horizontial_padding',
			[
				'label'      => esc_html__('Table Horizontial Padding (px)', 'shopengine-pro'),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range'      => [
					'px' => [
						'min'  => 0,
						'max'  => 100,
						'step' => 1,
					]
				],
				'default'    => [
					'unit' => 'px',
					'size' => 40,
				],
				'selectors'  => [
					'{{WRAPPER}} .shopengine-account-order-details table tr :is( td:first-child, th:first-child )' => 'padding-left:{{SIZE}}{{UNIT}} !important;',
					'{{WRAPPER}} .shopengine-account-order-details table tr :is( td:last-child, th:last-child )'   => 'padding-right:{{SIZE}}{{UNIT}} !important;',
					'.rtl {{WRAPPER}} .shopengine-account-order-details table tr :is( td:first-child, th:first-child )' => 'padding-right:{{SIZE}}{{UNIT}} !important; padding-left: 0px !important;',
					'.rtl {{WRAPPER}} .shopengine-account-order-details table tr :is( td:last-child, th:last-child )'   => 'padding-left:{{SIZE}}{{UNIT}} !important; padding-right: 0px !important;',
				],
			]
		);

		$this->add_control(
			'shopengine_account_table_vertical_padding',
			[
				'label'      => esc_html__('Heading Vertical Padding (px)', 'shopengine-pro'),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range'      => [
					'px' => [
						'min'  => 0,
						'max'  => 100,
						'step' => 1,
					]
				],
				'default'    => [
					'unit' => 'px',
					'size' => 15,
				],
				'selectors'  => [
					'{{WRAPPER}} .shopengine-account-order-details table thead th' => 'padding: {{SIZE}}{{UNIT}} 0;',
				],
			]
		);

		$this->end_controls_section(); // end ./ header section

		/*
			--------------------------
			account table
			--------------------------
		*/
		$this->start_controls_section(
			'shopengine_account_table',
			[
				'label' => esc_html__('Table Body', 'shopengine-pro'),
				'tab'   => Controls_Manager::TAB_STYLE
			]
		);

		$this->add_control(
			'shopengine_account_table_text_clr',
			[
				'label'     => esc_html__('Text Color', 'shopengine-pro'),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#3A3A3A',
				'alpha'     => false,
				'selectors' => [
					'{{WRAPPER}} .shopengine-account-order-details table :is( tfoot, tbody ) tr :is( td, th, .amount )' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'shopengine_orders_body_text_typography',
				'label'    => esc_html__('Text Typography', 'shopengine-pro'),
				'selector' => '{{WRAPPER}} .shopengine-account-order-details table :is( tfoot, tbody ) tr :is( th , td, span, h4 ), {{WRAPPER}} .shopengine-account-order-details table td::before',
				'exclude'  => ['font_family', 'letter_spacing', 'text_decoration', 'font_weight', 'text_decoration', 'font_style'],
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
							'size' => '16',
							'unit' => 'px'
						],
						'size_units' => ['px'],
						'responsive' => false,
					],
					'line_height' => [
						'label'      => esc_html__('Line Height (px)', 'shopengine-pro'),
						'default'    => [
							'size' => '34',
							'unit' => 'px'
						],
						'size_units' => ['px'],
						'responsive' => false,
					],
				],
			]
		);

		$this->add_control(
			'shopengine_account_table_link_color_divider',
			[
				'type' => Controls_Manager::DIVIDER,
			]
		);

		$this->add_control(
			'shopengine_account_table_link_color',
			[
				'label'     => esc_html__('Link Color', 'shopengine-pro'),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#4169E1',
				'alpha'     => false,
				'selectors' => [
					'{{WRAPPER}} .shopengine-account-order-details table :is( tfoot, tbody ) tr :is( .download-product, .product-name, th ) a' => 'color: {{VALUE}}',
				],
			]
		);


		$this->add_control(
			'shopengine_account_table_link_color_hover',
			[
				'label'     => esc_html__('Link Hover Color', 'shopengine-pro'),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#3A3A3A',
				'alpha'     => false,
				'selectors' => [
					'{{WRAPPER}} .shopengine-account-order-details table :is( tfoot, tbody ) tr :is( .download-product, .product-name, th ) a:hover' => 'color: {{VALUE}}',]
			]
		);

		$this->add_control(
			'shopengine_account_table_link_text_decoration',
			[
				'label'     => esc_html__('Link text decoration', 'shopengine-pro'),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'underline',
				'options'   => [
					''             => esc_html__('Default', 'shopengine-pro'),
					'underline'    => esc_html__('Underline', 'shopengine-pro', 'shopengine'),
					'overline'     => esc_html__('Overline', 'shopengine-pro', 'shopengine'),
					'line-through' => esc_html__('Line Through', 'shopengine-pro', 'shopengine'),
					'none'         => esc_html__('None', 'shopengine-pro', 'shopengine'),
				],
				'selectors' => [
					'{{WRAPPER}} .shopengine-account-order-details table :is( tfoot, tbody ) tr :is( .download-product, .product-name, th ) a' => 'text-decoration: {{VALUE}};',
				]
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'shopengine_account_table_border_bottom',
				'label'    => esc_html__('Border', 'shopengine-pro'),
				'selector' => '{{WRAPPER}} .shopengine-account-order-details table :is(tbody, tfoot) tr',
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
				'separator'  => 'before',
			]
		);


		$this->end_controls_section(); //end ./ account table


		/*
			---------------------------------
		  	download buttons
			------------------------------------
		 */


		$this->start_controls_section(
			'shopengine_download_button_action_section',
			[
				'label' => esc_html__('Download Buttons', 'shopengine-pro'),
				'tab'   => Controls_Manager::TAB_STYLE
			]
		);

		$this->add_responsive_control(
			'shopengine_download_button_padding',
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
					'{{WRAPPER}} .shopengine-account-order-details .woocommerce-table tbody tr td.download-file a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
				],
			]
		);

		$this->add_responsive_control(
			'shopengine_download_button_margin',
			[
				'label'      => esc_html__('Margin', 'shopengine-pro'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px'],
				'selectors'  => [
					'{{WRAPPER}} .shopengine-account-order-details .woocommerce-table tbody tr td.download-file a' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
				],
				'separator' => 'before',
			]
		);

		$this->add_control(
			'shopengine_download_button_padding_radius',
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
					'{{WRAPPER}} .shopengine-account-order-details .woocommerce-table tbody tr td.download-file a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
				],
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'shopengine_download_button_padding_typography',
				'label'    => esc_html__('Button Typography', 'shopengine-pro'),
				'selector' => '{{WRAPPER}} .shopengine-account-order-details .woocommerce-table tbody tr td.download-file a',
				'exclude'  => ['font_family', 'letter_spacing', 'text_decoration', 'font_style', 'line_height'],
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
				'name'     => 'shopengine_download_button_box_shadow',
				'label'    => esc_html__('Box Shadow', 'shopengine-pro'),
				'selector' => '{{WRAPPER}} .shopengine-account-order-details .woocommerce-table tbody tr td.download-file a',
			]
		);


		$this->start_controls_tabs(
			'shopengine_download_button_tabs',
			[
				'separator' => 'before',
			]
		);

		$this->start_controls_tab(
			'shopengine_download_button_tab_normal',
			[
				'label' => esc_html__('Normal', 'shopengine-pro'),
			]
		);

		$this->add_control(
			'shopengine_download_button_tab_clr',
			[
				'label'     => esc_html__('Color', 'shopengine-pro'),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#fffffff',
				'alpha'     => false,
				'selectors' => [
					'{{WRAPPER}} .shopengine-account-order-details .woocommerce-table tbody tr td.download-file a' => 'color: {{VALUE}} !important;'
				],
			]
		);

		$this->add_control(
			'shopengine_download_button_tab_bg',
			[
				'label'     => esc_html__('Background', 'shopengine-pro'),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#3A3A3A',
				'alpha'     => false,
				'selectors' => [
					'{{WRAPPER}} .shopengine-account-order-details .woocommerce-table tbody tr td.download-file a' => 'background: {{VALUE}}  !important;'
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'shopengine_download_button_tab_hover',
			[
				'label' => esc_html__('Hover', 'shopengine-pro'),
			]
		);

		$this->add_control(
			'shopengine_download_button_tab_hover_clr',
			[
				'label'     => esc_html__('Color', 'shopengine-pro'),
				'type'      => Controls_Manager::COLOR,
				'alpha'     => false,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .shopengine-account-order-details .woocommerce-table tbody tr td.download-file a:hover' => 'color: {{VALUE}} !important'
				],
			]
		);

		$this->add_control(
			'shopengine_download_button_tab_hover_bg',
			[
				'label'     => esc_html__('Background', 'shopengine-pro'),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#101010',
				'alpha'     => false,
				'selectors' => [
					'{{WRAPPER}} .shopengine-account-order-details .woocommerce-table tbody tr td.download-file a:hover' => 'background: {{VALUE}} !important'
				],
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->end_controls_section(); // end ./ download button


		/*
			---------------------------------
		  	order again button
			------------------------------------
		 */


		$this->start_controls_section(
			'shopengine_order_btn_section',
			[
				'label' => esc_html__('Order Again Button', 'shopengine-pro'),
				'tab'   => Controls_Manager::TAB_STYLE
			]
		);

		$this->add_responsive_control(
			'shopengine_order_again_button_margin',
			[
				'label'      => esc_html__('Margin', 'shopengine-pro'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px'],
				'default'    => [
					'top'      => '0',
					'right'    => '0',
					'bottom'   => '20',
					'left'     => '0',
					'unit'     => 'px',
					'isLinked' => false,
				],
				'selectors'  => [
					'{{WRAPPER}} .shopengine-account-order-details p.order-again a' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
				]
			]
		);

		$this->add_responsive_control(
			'shopengine_order_btn_padding',
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
					'{{WRAPPER}} .shopengine-account-order-details p.order-again a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
				]
			]
		);

		$this->add_control(
			'shopengine_order_btn_section_radius',
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
					'{{WRAPPER}} .shopengine-account-order-details p.order-again a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
				]
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'shopengine_order_btn_section_typography',
				'label'    => esc_html__('Button Typography', 'shopengine-pro'),
				'selector' => '{{WRAPPER}} .shopengine-account-order-details p.order-again a',
				'exclude'  => ['font_family', 'letter_spacing', 'text_decoration', 'font_style', 'line_height'],
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
				'name'     => 'shopengine_order_btn_section_box_shadow',
				'label'    => esc_html__('Box Shadow', 'shopengine-pro'),
				'selector' => '{{WRAPPER}} .shopengine-account-order-details p.order-again a',
			]
		);


		$this->start_controls_tabs('shopengine_order_btn_section_tabs');

		$this->start_controls_tab(
			'shopengine_order_btn_section_tab_normal',
			[
				'label' => esc_html__('Normal', 'shopengine-pro'),
			]
		);

		$this->add_control(
			'shopengine_order_btn_normal_clr',
			[
				'label'     => esc_html__('Color', 'shopengine-pro'),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#3A3A3A',
				'alpha'     => false,
				'selectors' => [
					'{{WRAPPER}} .shopengine-account-order-details p.order-again a' => 'color: {{VALUE}} !important;'
				],
			]
		);

		$this->add_control(
			'shopengine_order_btn_normal_bg',
			[
				'label'     => esc_html__('Background', 'shopengine-pro'),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ECECEC',
				'alpha'     => false,
				'selectors' => [
					'{{WRAPPER}} .shopengine-account-order-details p.order-again a' => 'background: {{VALUE}}  !important;'
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'shopengine_order_btn_section_tab_hover',
			[
				'label' => esc_html__('Hover', 'shopengine-pro'),
			]
		);

		$this->add_control(
			'shopengine_order_btn_hover_clr',
			[
				'label'     => esc_html__('Color', 'shopengine-pro'),
				'type'      => Controls_Manager::COLOR,
				'alpha'     => false,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .shopengine-account-order-details p.order-again a:hover' => 'color: {{VALUE}} !important'
				],
			]
		);

		$this->add_control(
			'shopengine_order_btn_hover_bg',
			[
				'label'     => esc_html__('Background', 'shopengine-pro'),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#101010',
				'alpha'     => false,
				'selectors' => [
					'{{WRAPPER}} .shopengine-account-order-details p.order-again a:hover' => 'background: {{VALUE}} !important'
				],
			]
		);


		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->end_controls_section(); // end ./ order again button


		/*
			--------------------------------------
			Address section
			------------------------------------
		*/
		$this->start_controls_section(
			'shopengin_account_address_section',
			[
				'label' => esc_html__('Address section', 'shopengine-pro'),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);


		$this->add_control(
			'shopengin_account_address_text_clr',
			[
				'label'     => esc_html__('Address Text Color', 'shopengine-pro'),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#979797',
				'alpha'     => false,
				'selectors' => [
					'{{WRAPPER}} .shopengine-account-order-details :is( .addresses, .woocommerce-customer-details ) :is(address, p)' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'           => 'shopengin_account_address_text_typography',
				'label'          => esc_html__('Address Typography', 'shopengine-pro'),
				'selector'       => '{{WRAPPER}} .shopengine-account-order-details :is( .addresses, .woocommerce-customer-details ) :is(address, p)',
				'exclude'        => ['font_family', 'letter_spacing', 'font_style', 'text_decoration'],
				'fields_options' => [
					'typography'  => [
						'default' => 'custom',
					],
					'font_weight' => [
						'default' => '400',
					],
					'font_size'   => [
						'default'    => [
							'size' => '16',
							'unit' => 'px'
						],
						'label'      => esc_html__( 'Font Size (px)', 'shopengine-pro' ),
						'size_units' => ['px'],
						'responsive' => false,
					],
					'line_height' => [
						'default'    => [
							'size' => '22',
							'unit' => 'px'
						],
						'label'      => esc_html__( 'Line Height (px)', 'shopengine-pro' ),
						'size_units' => ['px'],
						'responsive' => false,
					],
				],
			)
		);

		$this->end_controls_section(); // end ./ Address section
		

		/**
		 * Section: Global Font
		 */
		$this->start_controls_section(
			'shopengine_section_style_global',
			[
				'label' => esc_html__('Global Font', 'shopengine-pro'),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
			$this->add_control(
				'shopengine_acc_order_details_font',
				[
					'label'       => esc_html__( 'Font Family', 'shopengine-pro' ),
					'description' => esc_html__( 'This font family is set for this specific widget.', 'shopengine-pro' ),
					'type'        => Controls_Manager::FONT,
					'selectors'   => [
						'{{WRAPPER}} .shopengine-account-order-details :is(h1,h2,h3,h4,h5,h6)[class$="__title"],
						 {{WRAPPER}} .shopengine-account-order-details table thead th,
						 {{WRAPPER}} .shopengine-account-order-details table :is( tfoot, tbody ) tr :is( th , td, span ),
						 {{WRAPPER}} .shopengine-account-order-details .woocommerce-table tbody tr td.download-file a,
						 {{WRAPPER}} .shopengine-account-order-details p.order-again a,
						 {{WRAPPER}} .shopengine-account-order-details :is( .addresses, .woocommerce-customer-details ) :is(address, p)' => 'font-family: {{VALUE}};',
					],
				]
			);
		$this->end_controls_section();
	}


	protected function screen() {

		if(!is_user_logged_in()) {
			?>
            <div class="shopengine shopengine-editor-alert shopengine-editor-alert-warning">
				<?php echo esc_html__('You need first to be logged in', 'shopengine-pro'); ?>
            </div>
			<?php

			return;
		}

		$tpl = Products::instance()->get_widget_template($this->get_name(), 'default', \ShopEngine_Pro::widget_dir());

		include $tpl;
	}
}
