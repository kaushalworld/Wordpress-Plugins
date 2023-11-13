<?php

namespace Elementor;

use ShopEngine\Widgets\Products;

defined('ABSPATH') || exit;


class ShopEngine_Account_Navigation extends \ShopEngine\Base\Widget
{

	public function config() {
		return new ShopEngine_Account_Navigation_Config();
	}


	protected function register_controls() {


		/*
			----------------------------
			list Styles
			----------------------------
		*/

		$this->start_controls_section(
			'shopengine_account_navigation_list', [
				                                    'label' => esc_html__('Navigation List', 'shopengine-pro'),
				                                    'tab'   => Controls_Manager::TAB_STYLE,
			                                    ]
		);

		$this->add_control(
			'shopengine_account_navigation_list_color',
			[
				'label'     => esc_html__('List Color', 'shopengine-pro'),
				'type'      => Controls_Manager::COLOR,
				'alpha'     => false,
				'default'   => '#B1ADAD',
				'selectors' => [
					'{{WRAPPER}} .shopengine-account-navigation ul li a'         => 'color: {{VALUE}} !important;',
					'{{WRAPPER}} .shopengine-account-navigation ul li a::before' => 'background-color: {{VALUE}};',
				],
			]
		);


		$this->add_control(
			'shopengine_account_navigation_list_hover_color',
			[
				'label'     => esc_html__('Hover and Active Color', 'shopengine-pro'),
				'type'      => Controls_Manager::COLOR,
				'alpha'     => false,
				'default'   => '#3A3A3A',
				'selectors' => [
					'{{WRAPPER}} .shopengine-account-navigation ul li a:hover'            => 'color: {{VALUE}} !important;',
					'{{WRAPPER}} .shopengine-account-navigation ul li a:hover:before'     => 'background-color: {{VALUE}} !important;',
					'{{WRAPPER}} .shopengine-account-navigation ul li.is-active a'        => 'color: {{VALUE}} !important;',
					'{{WRAPPER}} .shopengine-account-navigation ul li.is-active a:before' => 'background-color: {{VALUE}} !important;',
				],
			]
		);

		$this->add_control(
			'shopengine_account_navigation_list_active_bg',
			[
				'label'     => esc_html__('Active Background', 'shopengine-pro'),
				'type'      => Controls_Manager::COLOR,
				'alpha'     => false,
				'default'   => '#F2F2F2',
				'selectors' => [
					'{{WRAPPER}} .shopengine-account-navigation ul li.is-active' => 'background: {{VALUE}} !important;',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'shopengine_account_navigation_list_Typography',
				'label'    => esc_html__('Typography', 'shopengine-pro'),
				'selector' => '{{WRAPPER}} .shopengine-account-navigation ul li',
				'exclude'  => ['letter_spacing', 'font_style', 'text_decoration'],

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
						'selectors' => [
							'{{WRAPPER}} .shopengine-account-navigation ul li' => 'line-height: {{SIZE}}{{UNIT}} !important;',
						],
						'size_units' => ['px']
					],
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'           => 'shopengine_account_navigation_box_shadow',
				'label'          => esc_html__('List Box Shadow', 'shopengine-pro'),
				'selector'       => '{{WRAPPER}} .shopengine-account-navigation ul li.is-active',
				'exclude'        => ['box_shadow_position'],
				'fields_options' => [
					'box_shadow' => [
						'default' => [
							'horizontal' => 0,
							'vertical'   => 10,
							'blur'       => 20,
							'spread'     => 0,
							'color'      => 'rgba(0,0,0,0.08)',
						],
					],

				],

			]
		);


		$this->end_controls_section(); // end ./ list style

		/*
			----------------------------
			Container Styles
			----------------------------
		*/

		$this->start_controls_section(
			'shopengine_account_navigation_section', [
				                                       'label' => esc_html__('Navigation Container', 'shopengine-pro'),
				                                       'tab'   => Controls_Manager::TAB_STYLE,
			                                       ]
		);

		$this->add_control(
			'shopengine_account_navigation_container_border_color',
			[
				'label'     => esc_html__('Border Color', 'shopengine-pro'),
				'type'      => Controls_Manager::COLOR,
				'alpha'     => false,
				'default'   => '#F2F2F2',
				'selectors' => [
					'{{WRAPPER}} .shopengine-account-navigation ul' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'shopengine_account_navigation_container_padding',
			[
				'label'      => esc_html__('Container Padding', 'shopengine-pro'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px'],
				'default'    => [
					'top'      => '0',
					'right'    => '40',
					'bottom'   => '0',
					'left'     => '40',
					'unit'     => 'px',
					'isLinked' => false,
				],
				'selectors'  => [
					'{{WRAPPER}} .shopengine-account-navigation ul'    => 'padding: {{TOP}}{{UNIT}} 0 {{BOTTOM}}{{UNIT}} 0;',
					'{{WRAPPER}} .shopengine-account-navigation ul li' => 'padding: 0 {{RIGHT}}{{UNIT}} 0 {{LEFT}}{{UNIT}};',
					'.rtl {{WRAPPER}} .shopengine-account-navigation ul li' => 'padding: 0 {{LEFT}}{{UNIT}} 0 {{RIGHT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section(); // end ./ Container Styles
	}


	protected function screen() {


		if(!is_user_logged_in()) {
			?>
            <div class="shopengine shopengine-editor-alert shopengine-editor-alert-warning">
				<?php echo esc_html__('You need first to be logged in', 'shopengine-pro') ?>
            </div>
			<?php
			return;
		}

		$tpl = Products::instance()->get_widget_template($this->get_name(), 'default', \ShopEngine_Pro::widget_dir());
		include $tpl;
	}
}
