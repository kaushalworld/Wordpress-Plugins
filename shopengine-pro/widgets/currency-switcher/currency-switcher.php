<?php

namespace Elementor;

use ShopEngine\Widgets\Products;

defined('ABSPATH') || exit;


class Shopengine_Currency_Switcher extends \ShopEngine\Base\Widget {


	public function config() {
		return new ShopEngine_Currency_Switcher_Config();
	}

	protected function register_controls() {
		$this->start_controls_section(
			'shopengine_section_general',
			[
				'label' => esc_html__('General', 'shopengine-pro'),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);


		$this->add_control(
			'shopengine_default_text',
			[
				'label'     => esc_html__('Default Text', 'shopengine-pro'),
				'type'      => Controls_Manager::TEXT,
				'default'   => 'Select Currency'
			]
		);

		$this->add_control(
			'shopengine_currency_switcher_height',
			[
				'label'     => esc_html__('Height (px)', 'shopengine-pro'),
				'type'      => Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'default'   => [
					'size' => 40,
				],
				'selectors' => [
					'{{WRAPPER}} .shopengine-currency-switcher--select' => 'height: {{SIZE}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'shopengine_currency_switcher_font',
				'selector' => '{{WRAPPER}} .shopengine-currency-switcher--select',
				'exclude' => ['letter_spacing', 'font_style', 'text_decoration', 'line_height'],
				'fields_options' => [
					'typography'  => [
						'default' => 'custom',
					],
					'font_size'   => [
						'size_units' => ['px'],
					],
				],
			]
		);

		$this->add_control(
			'shopengine_arrow_size',
			[
				'label'     => esc_html__('Arrow Size (px)', 'shopengine-pro'),
				'type'      => Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'selectors' => [
					'{{WRAPPER}} .shopengine-currency-switcher--icon' => 'font-size: {{SIZE}}{{UNIT}};',
				]
			]
		);

		$this->start_controls_tabs(
			'shopengine_tab_colors'
		);
		$this->start_controls_tab(
			'shopengine_tab_colors_normal',
			[
				'label' => esc_html__('Normal', 'shopengine-pro'),
			]
		);
		$this->add_control(
			'shopengine_currency_switcher_color',
			[
				'label'     => esc_html__('Text Color', 'shopengine-pro'),
				'type'      => Controls_Manager::COLOR,
				'alpha'		=> false,
				'selectors' => [
					'{{WRAPPER}} .shopengine-currency-switcher' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'shopengine_currency_switcher_bg_color',
			[
				'label'     => esc_html__('Background Color', 'shopengine-pro'),
				'type'      => Controls_Manager::COLOR,
				'alpha'		=> false,
				'selectors' => [
					'{{WRAPPER}} .shopengine-currency-switcher--select'             => 'background-color: {{VALUE}};'
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'shopengine_currency_switcher_border',
				'selector' => '{{WRAPPER}} .shopengine-currency-switcher--select',
				'fields_options' => [
					'border-radius' => [
						'selectors' => [
							'{{WRAPPER}} .shopengine-currency-switcher--select' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
							'.rtl {{WRAPPER}} .shopengine-currency-switcher--select' => 'border-radius: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}}',
						],
					],
					'width' => [
						'label'      => esc_html__('Border Width', 'shopengine-pro'),
						'default'    => [
							'top'    => '1',
							'right'  => '1',
							'bottom' => '1',
							'left'   => '1',
							'unit'   => 'px',
						],
						'selectors' => [
							'{{WRAPPER}} .shopengine-currency-switcher--select' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
							'.rtl {{WRAPPER}} .shopengine-currency-switcher--select' => 'border-width: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
						],
						'responsive' => false,
					],
				],
			]
		);
		$this->end_controls_tab();

		$this->start_controls_tab(
			'shopengine_tab_colors_hover',
			[
				'label' => esc_html__('Hover', 'shopengine-pro'),
			]
		);
		$this->add_control(
			'shopengine_currency_switcher_hover_color',
			[
				'label'     => esc_html__('Text Color', 'shopengine-pro'),
				'type'      => Controls_Manager::COLOR,
				'alpha'		=> false,
				'selectors' => [
					'{{WRAPPER}} .shopengine-currency-switcher:hover'           => 'color: {{VALUE}};'
				],
			]
		);

		$this->add_control(
			'shopengine_currency_switcher_hover_bg_color',
			[
				'label'     => esc_html__('Background Color', 'shopengine-pro'),
				'type'      => Controls_Manager::COLOR,
				'alpha'		=> false,
				'selectors' => [
					'{{WRAPPER}} .shopengine-currency-switcher--select:hover'             => 'background-color: {{VALUE}};'
				],
			]
		);

		$this->add_control(
			'shopengine_currency_switcher_hover_border',
			[
				'label'     => esc_html__('Border Color', 'shopengine-pro'),
				'type'      => Controls_Manager::COLOR,
				'alpha'		=> false,
				'selectors' => [
					'{{WRAPPER}} .shopengine-currency-switcher--select:hover' => 'border-color: {{VALUE}};',
				],
			]
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->add_control(
			'shopengine_currency_switcher_radius',
			[
				'label'      => esc_html__('Border Radius', 'shopengine-pro'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px'],
				'selectors'  => [
					'{{WRAPPER}} .shopengine-currency-switcher--select'             => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.rtl {{WRAPPER}} .shopengine-currency-switcher--select'             => 'border-radius: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				],
				'separator'  => 'before',
			]
		);

		$this->add_responsive_control(
			'shopengine_currency_switcher_padding',
			[
				'label'      => esc_html__('Padding', 'shopengine-pro'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px'],
				'selectors'  => [
					'{{WRAPPER}} .shopengine-currency-switcher--select'             => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.rtl {{WRAPPER}} .shopengine-currency-switcher--select'             => 'padding: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				],
				'separator'  => 'before',
			]
		);

		$this->end_controls_section();
	}

	public function get_icon_html($icon) {
	}

	protected function screen() {
		$settings = $this->get_settings_for_display();
		shopengine_pro_content_render(\ShopEngine\Utils\Helper::render($this->view_render($settings)));
	}

	protected function view_render($settings = []) {
		$tpl = Products::instance()->get_widget_template($this->get_name(), 'default', \ShopEngine_Pro::widget_dir());

		include $tpl;
	}
}