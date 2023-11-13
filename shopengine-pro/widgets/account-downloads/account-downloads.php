<?php

namespace Elementor;

use ShopEngine\Widgets\Products;

defined('ABSPATH') || exit;


class ShopEngine_Account_Downloads extends \ShopEngine\Base\Widget
{

	public function config() {
		return new ShopEngine_Account_Downloads_Config();
	}

	protected function register_controls() {


		/*
			---------------------------------
		  	Header Section
			------------------------------------
		 */

		$this->start_controls_section(
			'shopengine_account_section',
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
					'{{WRAPPER}} .shopengine-account-downloads .woocommerce-table thead th' => 'color: {{VALUE}}',
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
					'{{WRAPPER}} .shopengine-account-downloads .woocommerce-table thead' => 'background: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'shopengine_orders_header_text_typography',
				'label'    => esc_html__('Typography', 'shopengine-pro'),
				'selector' => '{{WRAPPER}} .shopengine-account-downloads .woocommerce-table thead th',
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
						'default'    => [
							'size' => '55',
							'unit' => 'px'
						],
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
			'shopengine_body_table_section',
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
					'{{WRAPPER}} .shopengine-account-downloads .woocommerce-table tbody' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'shopengine_download_body_color',
			[
				'label'     => esc_html__('Text Color', 'shopengine-pro'),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#3A3A3A',
				'alpha'     => false,
				'selectors' => [
					'{{WRAPPER}} .shopengine-account-downloads .woocommerce-table tbody tr td' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'shopengine_download_body_link_color',
			[
				'label'     => esc_html__('Link Color', 'shopengine-pro'),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#4169E1',
				'alpha'     => false,
				'selectors' => [
					'{{WRAPPER}} .shopengine-account-downloads .woocommerce-table tbody tr .download-product a' => 'color: {{VALUE}}',
				],
			]
		);


		$this->add_control(
			'shopengine_download_link_hover_color',
			[
				'label'     => esc_html__('Link Hover Color', 'shopengine-pro'),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#3A3A3A',
				'alpha'     => false,
				'selectors' => [
					'{{WRAPPER}} .shopengine-account-downloads .woocommerce-table tbody tr .download-product a:hover' => 'color: {{VALUE}}',]
			]
		);


		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'shopengine_orders_body_text_typography',
				'label'    => esc_html__('Text Typography', 'shopengine-pro'),
				'selector' => '{{WRAPPER}} .shopengine-account-downloads .woocommerce-table tbody tr .download-product a, {{WRAPPER}} .shopengine-account-downloads .woocommerce-table tbody tr td',
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
						'default'        => [
							'size' => '55',
							'unit' => 'px'
						],
						'tablet_default' => [
							'size' => '34',
							'unit' => 'px'
						],
						'mobile_default' => [
							'size' => '30',
							'unit' => 'px'
						],
						'size_units'     => ['px']
					],
				],
			]
		);


		$this->add_control(
			'shopengine_download_body_row_heading',
			[
				'label'     => esc_html__('Row Border and Stripe', 'shopengine-pro'),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'shopengine_orders_body_row_heading_note',
			[
				'type'            => Controls_Manager::RAW_HTML,
				'raw'             => esc_html__('stripe background Control appears on tablet and mobile devices', 'shopengine-pro'),
				'content_classes' => 'elementor-descriptor'
			]
		);


		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'shopengine_download_body_row_border',
				'label'    => esc_html__('Border', 'shopengine-pro'),
				'selector' => '{{WRAPPER}} .shopengine-account-downloads .woocommerce-table tbody tr',

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
				'label'          => esc_html__('Responsive Striped Background', 'shopengine-pro'),
				'type'           => Controls_Manager::COLOR,
				'default'        => '#fff',
				'alpha'          => false,
				'selectors'      => [
					'{{WRAPPER}} .shopengine-account-downloads .shop_table_responsive tbody tr:nth-child(2n)' => 'background: {{VALUE}}',
				]
			]
		);


		$this->end_controls_section();  // end ./ body section style

		/*
			---------------------------------
		  	download button
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
					'{{WRAPPER}} .shopengine-account-downloads .woocommerce-table tbody tr td.download-file a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
					'.rtl {{WRAPPER}} .shopengine-account-downloads .woocommerce-table tbody tr td.download-file a' => 'padding: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}} !important;',
				]
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
					'{{WRAPPER}} .shopengine-account-downloads .woocommerce-table tbody tr td.download-file a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
					'.rtl {{WRAPPER}} .shopengine-account-downloads .woocommerce-table tbody tr td.download-file a' => 'border-radius: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}} !important;',
				]
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'shopengine_download_button_padding_typography',
				'label'    => esc_html__('Button Typography', 'shopengine-pro'),
				'selector' => '{{WRAPPER}} .shopengine-account-downloads .woocommerce-table tbody tr td.download-file a',
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
				'name'     => 'shopengine_download_button_box_shadow',
				'label'    => esc_html__('Box Shadow', 'shopengine-pro'),
				'selector' => '{{WRAPPER}} .shopengine-account-downloads .woocommerce-table tbody tr td.download-file a',
			]
		);


		$this->start_controls_tabs('shopengine_download_button_tabs');

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
					'{{WRAPPER}} .shopengine-account-downloads .woocommerce-order-downloads .woocommerce-table tbody tr td.download-file a.button' => 'color: {{VALUE}} !important;'
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
					'{{WRAPPER}} .shopengine-account-downloads .woocommerce-table tbody tr td.download-file a' => 'background: {{VALUE}}  !important;'
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
					'{{WRAPPER}} .shopengine-account-downloads .woocommerce-table tbody tr td.download-file a:hover' => 'color: {{VALUE}} !important'
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
					'{{WRAPPER}} .shopengine-account-downloads .woocommerce-table tbody tr td.download-file a:hover' => 'background: {{VALUE}} !important'
				],
			]
		);


		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->end_controls_section(); // end ./ download button
	}


	protected function screen() {

		$tpl = Products::instance()->get_widget_template($this->get_name(), 'default', \ShopEngine_Pro::widget_dir());

		include $tpl;
	}
}
