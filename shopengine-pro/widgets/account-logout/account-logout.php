<?php

namespace Elementor;


use ShopEngine\Core\Template_Cpt;
use ShopEngine\Widgets\Products;

defined('ABSPATH') || exit;


class ShopEngine_Account_Logout extends \ShopEngine\Base\Widget
{

	public function config() {
		return new ShopEngine_Account_Logout_Config();
	}


	protected function register_controls() {

		/*
			-----------------------
			Logout Content controls
			-----------------------
		*/ 

		$this->start_controls_section(
			'shopengine_acc_logout_content_section',
			[
				'label'	=> esc_html__( 'Content', 'shopengine-pro' ),
				'tab'	=> Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'shopengine_acc_logout_content_icon',
			[
				'label'	=> esc_html__( 'Icon', 'shopengine-pro' ),
				'type'	=> Controls_Manager::ICONS,
				'default'		=> [
					'value'		=> 'fas fa-sign-out-alt',
					'library'	=> 'fa-solid',
				],
			]
		);

		$this->add_control(
			'shopengine_acc_logout_content_title',
			[
				'label' => esc_html__( 'Logout Text', 'shopengine-pro' ),
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
				'default' => esc_html__( 'Logout', 'shopengine-pro' ),
				'placeholder' => esc_html__( 'Enter logout title', 'shopengine-pro' ),
			]
		);


		$this->add_responsive_control(
			'shopengine_logout_alignment',
			[
				'label'     => esc_html__('Alignment', 'shopengine-pro'),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => [
					'left'   => [
						'description' => esc_html__('Left', 'shopengine-pro'),
						'icon'        => 'eicon-text-align-left',
					],
					'center' => [
						'description' => esc_html__('Center', 'shopengine-pro'),
						'icon'        => 'eicon-text-align-center',
					],
					'right'  => [
						'description' => esc_html__('Right', 'shopengine-pro'),
						'icon'        => 'eicon-text-align-right',
					],
				],
				'prefix_class' => 'elementor-align-',
				'selectors' => [
					'{{WRAPPER}} .shopengine-account-logout' => 'text-align: {{VALUE}};',
					'.rtl {{WRAPPER}}.elementor-align-left .shopengine-account-logout' => 'text-align:right;',
					'.rtl {{WRAPPER}}.elementor-align-right .shopengine-account-logout' => 'text-align:left;',
				],
			]
		);

		$this->end_controls_section();


		/*
			-----------------------
			Logout Style Controls
			-----------------------
		*/ 

		$this->start_controls_section(
			'shopengine_acc_logout_style_section',
			[
				'label'	=> esc_html__( 'Style', 'shopengine-pro' ),
				'tab'	=> Controls_Manager::TAB_STYLE,
			]
		);


		$this->add_control(
			'shopengine_acc_logout_style_color',
			[
				'label'	=> esc_html__( 'Logout Color', 'shopengine-pro' ),
				'type'	=> Controls_Manager::COLOR,
				'default' => '#101010',
				'alpha'	=> false,
				'selectors' => [
					'{{WRAPPER}} .shopengine-account-logout a' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'shopengine_acc_logout_style_Hover_color',
			[
				'label'	=> esc_html__( 'Logout Hover Color', 'shopengine-pro' ),
				'type'	=> Controls_Manager::COLOR,
				'default' => '#FF5050',
				'alpha'	=> false,
				'selectors' => [
					'{{WRAPPER}} .shopengine-account-logout a:hover' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'           => 'shopengine_account_logout_typography',
				'label'          => esc_html__('Typography', 'shopengine-pro'),
				'selector'       => '{{WRAPPER}} .shopengine-account-logout a',
				'exclude'		 => ['font_style', 'letter_spacing', 'text_decoration'], 
				'fields_options' => [
					'typography'  => [
						'default' => 'custom',
					],
					'font_weight' => [
						'default' => '400',
					],
					'font_size'   => [
						'size_units' => ['px'],
						'responsive' => false,
						'default' => [
							'size' => '20',
							'unit' => 'px'
						],
					],
					'line_height' => [
						'size_units' => ['px'],
						'responsive' => false,
						'default' => [
							'size' => '22',
							'unit' => 'px'
						]
					],
				],
			)
		);

		$this->end_controls_section();
	}


	protected function screen() {

		$settings = $this->get_settings_for_display();

		$tpl = Products::instance()->get_widget_template($this->get_name(), 'default', \ShopEngine_Pro::widget_dir());

		include $tpl;
	}
}
