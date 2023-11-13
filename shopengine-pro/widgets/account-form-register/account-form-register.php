<?php

namespace Elementor;

use ShopEngine\Widgets\Products;

defined('ABSPATH') || exit;


class ShopEngine_Account_Form_Register extends \ShopEngine\Base\Widget
{

	public function config() {
		return new ShopEngine_Account_Form_Register_Config();
	}


	protected function register_controls() {
		
		/*
			----------------------------
			Form label controls
			----------------------------
		*/ 

		$this->start_controls_section(
			'shopengine_input_label_section',
			[
				'label' => esc_html__('Label', 'shopengine-pro'),
				'tab'   => Controls_Manager::TAB_STYLE
			]
		);

		$this->add_control(
			'shopengine_input_label_color',
			[
				'label'     => esc_html__('Color', 'shopengine-pro'),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#3A3A3A',
				'alpha'		=> false,
				'selectors' => [
					'{{WRAPPER}} .shopengine-account-form-register .woocommerce-form-register .form-row label' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'shopengine_input_required_indicator_color',
			[
				'label'     => esc_html__('Required Indicator Color:', 'shopengine-pro'),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#3A3A3A',
				'alpha'		=> false,
				'selectors' => [
					'{{WRAPPER}} .woocommerce-form-row .required' => 'color: {{VALUE}}',
				]
			]
		);

		$this->add_control(
			'shopengine_input_label_font_size',
			[
				'label'      => esc_html__('Font Size (px)', 'shopengine-pro'),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range'      => [
					'px' => [
						'min'  => 0,
						'max'  => 100,
						'step' => 1,
					],
				],
				'default'    => [
					'unit' => 'px',
					'size' => 18,
				],
				'selectors'  => [
					'{{WRAPPER}} .shopengine-account-form-register .woocommerce-form-register .form-row :is(label, .required)'	=> 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);


		$this->end_controls_section();

		/*
			----------------------------
			Form Input controls
			----------------------------
		*/ 

		$this->start_controls_section(
			'shopengine_input_section',
			[
				'label' => esc_html__('Input', 'shopengine-pro'),
				'tab'   => Controls_Manager::TAB_STYLE
			]
		);

		$this->add_control(
			'shopengine_input_input_font_size',
			[
				'label'      => esc_html__('Font Size (px)', 'shopengine-pro'),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range'      => [
					'px' => [
						'min'  => 0,
						'max'  => 100,
						'step' => 1,
					],
				],
				'default'    => [
					'unit' => 'px',
					'size' => 18,
				],
				'selectors'  => [
					'{{WRAPPER}} .shopengine-account-form-register .woocommerce-form-register .form-row input'	=> 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'shopengine_input_padding',
			[
				'label'      => esc_html__('Padding', 'shopengine-pro'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px'],
				'selectors'  => [
					'{{WRAPPER}} .shopengine-account-form-register .woocommerce-form-register .form-row input' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.rtl {{WRAPPER}} .shopengine-account-form-register .woocommerce-form-register .form-row input' => 'padding: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				],
				'separator'  => 'before'
			]
		);

		$this->add_control(
			'shopengine_input_margin',
			[
				'label'      => esc_html__('Margin (px)', 'shopengine-pro'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px'],
				'default'	 => [
					'top'	=> 10,
					'right' => 0,
					'bottom'=> 10,
					'left'	=> 0,
					'size_unit' => 'px',
					'is_linked' => false,
				],
				'selectors'  => [
					'{{WRAPPER}} .shopengine-widget .shopengine-account-form-register .woocommerce-form-register .form-row .woocommerce-Input'  => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.rtl {{WRAPPER}} .shopengine-widget .shopengine-account-form-register .woocommerce-form-register .form-row .woocommerce-Input'  => 'margin: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs('shopengine_input_tabs_style');

		$this->start_controls_tab(
			'shopengine_input_tabnormal',
			[
				'label' => esc_html__('Normal', 'shopengine-pro'),
			]
		);

		$this->add_control(
			'shopengine_input_color',
			[
				'label'     => esc_html__('Input Color', 'shopengine-pro'),
				'type'      => Controls_Manager::COLOR,
				'alpha'		=> false,
				'selectors' => [
					'{{WRAPPER}} .shopengine-account-form-register .woocommerce-form-register .form-row input' => 'color: {{VALUE}};',

				],
				'default'   => '#101010',
			]
		);

		$this->add_control(
			'shopengine_input_background',
			[
				'label'     => esc_html__('Input Background color', 'shopengine-pro'),
				'type'      => Controls_Manager::COLOR,
				'alpha'		=> false,
				'default'	=> '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .shopengine-account-form-register .woocommerce-form-register .form-row input' => 'background-color: {{VALUE}};',
				],
			]
		);



		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'shopengine_input_border',
				'label'    => esc_html__('Border', 'shopengine-pro'),
				'selector' => '{{WRAPPER}} .shopengine-account-form-register .woocommerce-form-register .form-row input',
				'fields_options' => [
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
							'{{WRAPPER}} .shopengine-account-form-register .woocommerce-form-register .form-row input' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
							'.rtl {{WRAPPER}} .shopengine-account-form-register .woocommerce-form-register .form-row input' => 'border-width: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
						],
						'responsive' => false,
					],
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'shopengine_input_tabfocus',
			[
				'label' => esc_html__('Focus', 'shopengine-pro'),
			]
		);

		$this->add_control(
			'shopengine_input_color_focus',
			[
				'label'     => esc_html__('Input Color', 'shopengine-pro'),
				'type'      => Controls_Manager::COLOR,
				'alpha'		=> false,
				'selectors' => [
					'{{WRAPPER}} .shopengine-account-form-register .woocommerce-form-register .form-row input:focus' => 'color: {{VALUE}};',
				],
				'default'   => '#000000',
			]
		);


		$this->add_control(
			'shopengine_input_background_focus',
			[
				'label'     => esc_html__('Input Background color', 'shopengine-pro'),
				'type'      => Controls_Manager::COLOR,
				'alpha'		=> false,
				'default'	=> '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .shopengine-account-form-register .woocommerce-form-register .form-row input:focus' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'shopengine_input_border_focus',
				'label'    => esc_html__('Border', 'shopengine-pro'),
				'selector' => '{{WRAPPER}} .shopengine-account-form-register .woocommerce-form-register .form-row input:focus',
				'fields_options' => [
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
							'{{WRAPPER}} .shopengine-account-form-register .woocommerce-form-register .form-row input:focus' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
							'.rtl {{WRAPPER}} .shopengine-account-form-register .woocommerce-form-register .form-row input:focus' => 'border-width: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
						],
						'responsive' => false,
					],
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_responsive_control(
			'shopengine_input_border_radius',
			[
				'label' =>esc_html__('Border Radius', 'shopengine-pro'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%'],
				'default' => [
					'top' => '',
					'right' => '',
					'bottom' => '' ,
					'left' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .shopengine-account-form-register .woocommerce-form-register .form-row input' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.rtl {{WRAPPER}} .shopengine-account-form-register .woocommerce-form-register .form-row input' => 'border-radius: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				],
			]
		);
		

		$this->end_controls_section();
		
		/*
			----------------------------
			Form Message controls
			----------------------------
		*/ 
		$this->start_controls_section(
			'shopengine_message_section',
			[
				'label' => esc_html__('Message', 'shopengine-pro'),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'shopengine_input_message_color',
			[
				'label'     => esc_html__('Color', 'shopengine-pro'),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#3A3A3A',
				'alpha'		=> false,
				'selectors' => [
					'{{WRAPPER}} .shopengine-account-form-register .woocommerce-form-register :is(.woocommerce-pending-message, .woocommerce-privacy-policy-text p)' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'shopengine_input_message_linkcolor',
			[
				'label'     => esc_html__('Link Color', 'shopengine-pro'),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#3A3A3A',
				'alpha'		=> false,
				'selectors' => [
					'{{WRAPPER}} .shopengine-account-form-register .woocommerce-form-register :is(.woocommerce-pending-message, .woocommerce-privacy-policy-text) a' => 'color: {{VALUE}}',
				],
			]
		);


		$this->add_control(
			'shopengine_input_message_font_size',
			[
				'label'      => esc_html__('Font Size (px)', 'shopengine-pro'),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range'      => [
					'px' => [
						'min'  => 0,
						'max'  => 100,
						'step' => 1,
					],
				],
				'default'    => [
					'unit' => 'px',
					'size' => 18,
				],
				'selectors'  => [
					'{{WRAPPER}} .shopengine-account-form-register .woocommerce-form-register :is(.woocommerce-pending-message, .woocommerce-privacy-policy-text p)'	=> 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'shopengine_input_message_line_height',
			[
				'label'      => esc_html__('Line Height (px)', 'shopengine-pro'),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range'      => [
					'px' => [
						'min'  => 0,
						'max'  => 200,
						'step' => 1,
					],
				],
				'default'    => [
					'unit' => 'px',
					'size' => 22,
				],
				'selectors'  => [
					'{{WRAPPER}} .shopengine-account-form-register .woocommerce-form-register :is(.woocommerce-pending-message, .woocommerce-privacy-policy-text p)'	=> 'line-height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		/*
			----------------------------
			Form Button controls
			----------------------------
		*/ 
		$this->start_controls_section(
			'shopengine_button_section',
			[
				'label' => esc_html__('Button', 'shopengine-pro'),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'           => 'shopengine_register_btn_typography',
				'label'          => esc_html__('Typography', 'shopengine-pro'),
				'selector'       => '{{WRAPPER}} .woocommerce-form button.button',
				'exclude'        => ['text_decoration'],
				'fields_options' => [
					'typography'     => [
						'default' => 'custom',
					],
					'font_size'    => [
						'default'  => [
							'size' => '16',
							'unit' => 'px'
						],
						'label'      => 'Line-height (px)',
						'size_units' => ['px']
					],
					'font_weight'    => [
						'default' => '700',
					],
					'line_height'    => [
						'default'    => [
							'size' => '22',
							'unit' => 'px'
						],
						'label'      => 'Line-height (px)',
						'size_units' => ['px']
					],
					'letter_spacing' => [
						'responsive' => false,
					]
				],
			)
		);
		
		$this->start_controls_tabs('shopengine_login_btn_style_tabs');

		$this->start_controls_tab(
			'shopengine_register_btn_tabnormal',
			[
				'label' =>esc_html__('Normal', 'shopengine-pro'),
			]
		);

		$this->add_control(
			'shopengine_button_color',
			[
				'label' =>esc_html__('Text Color', 'shopengine-pro'),
				'type' => Controls_Manager::COLOR,
				'default' => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .shopengine-account-form-register .woocommerce-form-register .form-row button.button' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'shopengine_button_bg',
			[
				'label' =>esc_html__('Background Color', 'shopengine-pro'),
				'type' => Controls_Manager::COLOR,
				'default' => '#101010',
				'selectors' => [
					'{{WRAPPER}} .shopengine-account-form-register .woocommerce-form-register .form-row button.button' => 'background: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'shopengine_register_btn_tab_button_hover',
			[
				'label' =>esc_html__('Hover', 'shopengine-pro'),
			]
		);

		$this->add_control(
			'shopengine_button_bg_hover',
			[
				'label' =>esc_html__('Text Color', 'shopengine-pro'),
				'type' => Controls_Manager::COLOR,
				'default' => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .shopengine-account-form-register .woocommerce-form-register .form-row button.button:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'shopengine_register_btn_bg_hover_color',
			[
				'label' =>esc_html__('Background Color', 'shopengine-pro'),
				'type' => Controls_Manager::COLOR,
				'default' => '#312b2b',
				'selectors' => [
					'{{WRAPPER}} .shopengine-account-form-register .woocommerce-form-register .form-row button.button:hover' => 'background: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_control(
			'shopengine_button_padding',
			[
				'label'      => esc_html__('Padding', 'shopengine-pro'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px'],
				'default'	 => [
					'top'	=> 15,
					'right' => 30,
					'bottom'=> 15,
					'left'	=> 30,
					'size_units' => 'px',
					'is_linked' => false,
				],
				'selectors'  => [
					'{{WRAPPER}} .woocommerce-form button.button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.rtl {{WRAPPER}} .woocommerce-form button.button' => 'padding: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				],
			]
		);


		$this->add_control(
			'shopengine_button_margin',
			[
				'label'      => esc_html__('Margin', 'shopengine-pro'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px'],
				'selectors'  => [
					'{{WRAPPER}} .woocommerce-form button.button' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.rtl {{WRAPPER}} .woocommerce-form button.button' => 'margin: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				],
			]
		);


		$this->add_control(
			'shopengine_register_border_radius',
			[
				'label'      => esc_html__('Border Radius (px)', 'shopengine-pro'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px'],
				'size_units' => ['px'],
				'default'	=> [
					'top'		=> '3',
					'right'	=> '3',
					'bottom' => '3',
					'left' => '3',
					'unit' => 'px',
					'isLinked' => true,
				],
				'selectors'  => [
					'{{WRAPPER}} .woocommerce-form button.button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.rtl {{WRAPPER}} .woocommerce-form button.button' => 'border-radius: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'shopengine_register_btn_width',
			[
				'label' => esc_html__( 'Width', 'shopengine-pro' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
						'step' => 5,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default' => [
					'unit' => '%',
					'size' => 50,
				],
				'selectors' => [
					'{{WRAPPER}} .shopengine-account-form-register .woocommerce-form-register .form-row button.button' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		/*
			----------------------------
			Form Typography controls
			----------------------------
		*/ 

		$this->start_controls_section(
			'shopengine_typography_section',
			[
				'label' => esc_html__('Global Font', 'shopengine-pro'),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'shopengine_product_categories_font_family',
			[
				'label'       => esc_html__('Font Family', 'shopengine-pro'),
				'description' => esc_html__('This font family is set for this specific widget.', 'shopengine-pro'),
				'type'        => Controls_Manager::FONT,
				'default'     => '',
				'selectors'   => [
					'{{WRAPPER}} .woocommerce-form :is(label, input, button, p, *, div)' => 'font-family: {{VALUE}}',
				],
			]
		);


		$this->end_controls_section();
	}


	protected function screen() {

	//	if(is_lost_password_page()) return;

		$settings = $this->get_settings_for_display();

		$tpl = Products::instance()->get_widget_template($this->get_name(), 'default', \ShopEngine_Pro::widget_dir());

		include $tpl;
	}
}
