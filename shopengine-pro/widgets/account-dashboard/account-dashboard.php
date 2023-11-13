<?php

namespace Elementor;

use ShopEngine\Widgets\Products;

defined('ABSPATH') || exit;

class ShopEngine_Account_Dashboard extends \ShopEngine\Base\Widget
{

	public function config() {
		return new ShopEngine_Account_Dashboard_Config();
	}

	public static function shopengine_font_weight() {
		$typo_weight_options = [
			'' => esc_html__('Default', 'shopengine-pro'),
		];

		foreach(array_merge(['normal', 'bold'], range(100, 900, 100)) as $weight) {
			$typo_weight_options[$weight] = ucfirst($weight);
		}

		return $typo_weight_options;
	}


	protected function register_controls() {

		$this->start_controls_section(
			'shopengine_layout_section',
			[
				'label' => esc_html__('Dashboard Style', 'shopengine-pro'),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'shopengine_account_dashboard_text_color',
			[
				'label'     => esc_html__('Text color', 'shopengine-pro'),
				'type'      => Controls_Manager::COLOR,
				'alpha'     => false,
				'default'   => '#3A3A3A',
				'selectors' => [
					'{{WRAPPER}} .shopengine-account-dashboard p' => 'margin:0 !important ; color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'shopengine_account_dashboard_text_link_font_weight',
			[
				'label'     => esc_html__('Text and Link Font Weight', 'shopengine-pro'),
				'type'      => Controls_Manager::SELECT,
				'default'   => '400',
				'options'   => self::shopengine_font_weight(),
				'selectors' => [
					'{{WRAPPER}} .shopengine-account-dashboard :is(p, a)' => 'font-weight: {{VALUE}};',
				],
				'separator'  => 'after',
			]
		);

		$this->add_control(
			'shopengine_account_dashboard_user_color',
			[
				'label'     => esc_html__('User color', 'shopengine-pro'),
				'type'      => Controls_Manager::COLOR,
				'alpha'     => false,
				'default'   => '#3A3A3A',
				'selectors' => [
					'{{WRAPPER}} .shopengine-account-dashboard p strong' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'shopengine_account_dashboard_user_font_weight',
			[
				'label'     => esc_html__('User Font Weight', 'shopengine-pro'),
				'type'      => Controls_Manager::SELECT,
				'default'   => '700',
				'options'   => self::shopengine_font_weight(),
				'selectors' => [
					'{{WRAPPER}} .shopengine-account-dashboard p strong' => 'font-weight: {{VALUE}};',
				],
				'separator'  => 'after',
			]
		);

		$this->add_control(
			'shopengine_account_dashboard_link_color',
			[
				'label'     => esc_html__('Link color', 'shopengine-pro'),
				'type'      => Controls_Manager::COLOR,
				'alpha'     => false,
				'default'   => '#4169E1',
				'selectors' => [
					'{{WRAPPER}} .shopengine-account-dashboard p a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'shopengine_account_dashboard_link_hover_color',
			[
				'label'     => esc_html__('Link Hover color', 'shopengine-pro'),
				'type'      => Controls_Manager::COLOR,
				'alpha'     => false,
				'default'   => '#879BD6',
				'selectors' => [
					'{{WRAPPER}} .shopengine-account-dashboard p a:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'shopengine_account_dashboard_link_text_decoration',
			[
				'label'     => esc_html__('Link text decoration', 'shopengine-pro'),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'none',
				'options'   => [
					''             => esc_html__('Default', 'shopengine-pro'),
					'underline'    => esc_html__('Underline', 'shopengine-pro', 'shopengine'),
					'overline'     => esc_html__('Overline', 'shopengine-pro', 'shopengine'),
					'line-through' => esc_html__('Line Through', 'shopengine-pro', 'shopengine'),
					'none'         => esc_html__('None', 'shopengine-pro', 'shopengine'),
				],
				'selectors' => [
					'{{WRAPPER}} .shopengine-account-dashboard p a' => 'text-decoration: {{VALUE}};',
				],
				'separator'  => 'after',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'shopengine_account_dashboard_typography',
				'label'    => esc_html__('Typography', 'shopengine-pro'),
				'selector' => '{{WRAPPER}} .shopengine-account-dashboard p',
				'exclude'  => ['letter_spacing', 'font_style', 'font_weight', 'text_decoration'],

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
						'label'      => esc_html__('Line-Height (px)', 'shopengine-pro'),
						'default'    => [
							'size' => '20',
							'unit' => 'px'
						],
						'size_units' => ['px']
					],
				],
			]
		);

		$this->add_responsive_control(
			'shopengine_account_dashboard_spacing',
			[
				'label'      => esc_html__('Space between (px)', 'shopengine-pro'),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range'      => [
					'px' => [
						'min'  => 0,
						'max'  => 500,
						'step' => 1,
					]
				],
				'default'    => [
					'unit' => 'px',
					'size' => 15,
				],
				'selectors'  => [
					'{{WRAPPER}} .shopengine-account-dashboard p:first-child' => 'margin-bottom: {{SIZE}}{{UNIT}} !important;',
				],
			]
		);


		$this->end_controls_section();
	}


	protected function screen() {

		if(!is_user_logged_in()) {

			return esc_html__('You need first to be logged in', 'shopengine-pro');
		}

		$tpl = Products::instance()->get_widget_template($this->get_name(), 'default', \ShopEngine_Pro::widget_dir());

		include $tpl;
	}
}
