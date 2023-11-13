<?php

namespace Elementor;

use ShopEngine\Widgets\Products;

defined('ABSPATH') || exit;

class ShopEngine_Account_Form_Lost_Password extends \ShopEngine\Base\Widget
{

	public function config() {
		return new ShopEngine_Account_Form_Lost_Passowrd_Config();
	}

	protected function register_controls() {

		$this->start_controls_section(
			'shopengine_lost_password_input_label_section',
			[
				'label' => esc_html__('Label', 'shopengine-pro'),
				'tab'   => Controls_Manager::TAB_STYLE
			]
		);

		$this->add_control(
			'shopengine_lost_password_input_label_color',
			[
				'label'     => esc_html__('Color', 'shopengine-pro'),
				'type'      => Controls_Manager::COLOR,
				'alpha'		=> false,
				'default'   => '#3A3A3A',
				'selectors' => [
					'{{WRAPPER}} .woocommerce-ResetPassword label' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'shopengine_lost_password_input_label_font_size',
			[
				'label'      => esc_html__('Font size (px)', 'shopengine-pro'),
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
					'size' => 16,
				],
				'selectors'  => [
					'{{WRAPPER}} .woocommerce-ResetPassword label' => 'font-size: {{SIZE}}{{UNIT}}'
				],
			]
		);
		
		$this->end_controls_section();

		/*
			------------------------
			Form Input Controls
			------------------------
		*/ 

		$this->start_controls_section(
			'shopengine_lost_password_input_section',
			[
				'label' => esc_html__('Input', 'shopengine-pro'),
				'tab'   => Controls_Manager::TAB_STYLE
			]
		);
		$this->add_control(
			'shopengine_lost_password_height_width',
			[
				'label'      => esc_html__('Height (px)', 'shopengine-pro'),
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
					'size' => 35,
				],
				'selectors'  => [
					'{{WRAPPER}} .shopengine .woocommerce-ResetPassword .form-row :is(input)' => 'min-height: {{SIZE}}{{UNIT}}'
				],
			]
		);
		$this->add_control(
			'shopengine_lost_password_input_width',
			[
				'label'      => esc_html__('Width (px)', 'shopengine-pro'),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => ['%', 'px'],
				'range'      => [
					'%'  => [
						'min'  => 0,
						'max'  => 100,
						'step' => 1,
					],
					'px' => [
						'min'  => 0,
						'max'  => 800,
						'step' => 1,
					],
				],
				'default'    => [
					'unit' => '%',
					'size' => 100,
				],
				'selectors'  => [
					'{{WRAPPER}} .shopengine .woocommerce-ResetPassword .form-row' => 'width: {{SIZE}}{{UNIT}}'
				],
			]
		);

		$this->add_control(
			'shopengine_lost_passowrd_input_margin',
			[
				'label'      => esc_html__('Margin (px)', 'shopengine-pro'),
				'type'       => Controls_Manager::DIMENSIONS,
				'default'	 => [
					'top'    => 8,
					'bottom' => 0,
					'left'	 => 0,
					'right'  => 0,
					'unit' => 'px',
				],
				'size_units' => ['px'],
				'selectors'  => [
					'{{WRAPPER}} .shopengine .woocommerce-ResetPassword .woocommerce-form-row input' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.rtl {{WRAPPER}} .shopengine .woocommerce-ResetPassword .woocommerce-form-row input' => 'margin: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'shopengine_lost_passowrd_input_padding',
			[
				'label'      => esc_html__('Padding (px)', 'shopengine-pro'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px'],
				'selectors'  => [
					'{{WRAPPER}} .shopengine .woocommerce-ResetPassword .woocommerce-form-row input' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.rtl {{WRAPPER}} .shopengine .woocommerce-ResetPassword .woocommerce-form-row input' => 'padding: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				],
			]
		);
		
		$this->add_control(
			'shopengine_lost_password_typography_seconday',
			[
				'label'      => esc_html__('Font size (px)', 'shopengine-pro'),
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
					'size' => 16,
				],
				'selectors'  => [
					'{{WRAPPER}} .shopengine .woocommerce-ResetPassword .form-row :is(input)' => 'font-size: {{SIZE}}{{UNIT}}'
				],
			]
		);

		$this->start_controls_tabs('shopengine_input_tabs_style');

		$this->start_controls_tab(
			'shopengine_lost_password_input_tabnormal',
			[
				'label' => esc_html__('Normal', 'shopengine-pro'),
			]
		);

		$this->add_control(
			'shopengine_lost_password_input_color',
			[
				'label'     => esc_html__('Input Color', 'shopengine-pro'),
				'type'      => Controls_Manager::COLOR,
				'alpha'		=> false,
				'selectors' => [
					'{{WRAPPER}} .woocommerce-ResetPassword input:not(.woocommerce-form__input-checkbox)'  => 'color: {{VALUE}};',
					'{{WRAPPER}} .woocommerce-ResetPassword textarea'                                      => 'color: {{VALUE}};',
					'{{WRAPPER}} .woocommerce-ResetPassword .woocommerce-input-wrapper .select2-selection' => 'color: {{VALUE}};'
				],
				'default'   => '#000000',
			]
		);

		$this->add_control(
			'shopengine_lost_password_input_background',
			[
				'label'     => esc_html__('Background color', 'shopengine-pro'),
				'type'      => Controls_Manager::COLOR,
				'alpha'		=> false,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .woocommerce-ResetPassword input:not(.woocommerce-ResetPassword__input-checkbox),
					{{WRAPPER}} .woocommerce-ResetPassword textarea,
					{{WRAPPER}} .woocommerce-ResetPassword .select2-selection
					' => 'background-color: {{VALUE}}',
				]
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'shopengine_lost_password_input_tabfocus',
			[
				'label' => esc_html__('Focus', 'shopengine-pro'),
			]
		);

		$this->add_control(
			'shopengine_lost_password_input_color_focus',
			[
				'label'     => esc_html__('Input Color', 'shopengine-pro'),
				'type'      => Controls_Manager::COLOR,
				'alpha'		=> false,
				'selectors' => [
					'{{WRAPPER}} .woocommerce-ResetPassword input:not(.woocommerce-form__input-checkbox):focus'  => 'color: {{VALUE}};',
					'{{WRAPPER}} .woocommerce-ResetPassword textarea:focus'                                      => 'color: {{VALUE}};',
					'{{WRAPPER}} .woocommerce-ResetPassword .woocommerce-input-wrapper .select2-selection:focus' => 'color: {{VALUE}};'
				],
				'default'   => '#000000',
			]
		);

		$this->add_control(
			'shopengine_lost_password_input_background_focus',
			[
				'label'     => esc_html__('Background color', 'shopengine-pro'),
				'type'      => Controls_Manager::COLOR,
				'alpha'		=> false,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .woocommerce-ResetPassword input:not(.woocommerce-ResetPassword__input-checkbox):focus, {{WRAPPER}} .woocommerce-ResetPassword textarea:focus, {{WRAPPER}} .woocommerce-ResetPassword .select2-selection:focus' => 'background-color: {{VALUE}}',
				]
			]
		);

		$this->add_control(
			'shopengine_lost_password_input_border_color_focus',
			[
				'label'     => esc_html__('Border color', 'shopengine-pro'),
				'type'      => Controls_Manager::COLOR,
				'alpha'		=> false,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .woocommerce-ResetPassword input:not(.woocommerce-ResetPassword__input-checkbox):focus, {{WRAPPER}} .woocommerce-ResetPassword textarea:focus, {{WRAPPER}} .woocommerce-ResetPassword .select2-selection:focus' => 'border-color: {{VALUE}}',
				]
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'shopengine_lost_passowrd_input_border',
				'label'    => esc_html__('Border', 'shopengine-pro'),
				'selector' => '{{WRAPPER}} .woocommerce-ResetPassword input:not(.woocommerce-ResetPassword__input-checkbox), {{WRAPPER}} .woocommerce-ResetPassword textarea, {{WRAPPER}} .woocommerce-ResetPassword .select2-selection',
			]
		);

		$this->end_controls_section();

		/*
			--------------------------
			Form Button controls
			--------------------------
		*/ 

		$this->start_controls_section(
			'shopengine_lost_password_button_section',
			[
				'label' => esc_html__('Button', 'shopengine-pro'),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);


		$this->start_controls_tabs('shopengine_login_btn_style_tabs');

		$this->start_controls_tab(
			'shopengine_lost_password_login_btn_tabnormal',
			[
				'label' =>esc_html__('Normal', 'shopengine-pro'),
			]
		);

		$this->add_control(
			'shopengine_lost_password_button_color',
			[
				'label' =>esc_html__('Text Color', 'shopengine-pro'),
				'type' => Controls_Manager::COLOR,
				'default' => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .woocommerce-ResetPassword button' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'shopengine_lost_password_button_bg',
			[
				'label' =>esc_html__('Background Color', 'shopengine-pro'),
				'type' => Controls_Manager::COLOR,
				'default' => '#101010',
				'selectors' => [
					'{{WRAPPER}} .woocommerce-ResetPassword button' => 'background: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'shopengine_lost_password_tab_button_hover',
			[
				'label' => esc_html__('Hover', 'shopengine-pro'),
			]
		);

		$this->add_control(
			'shopengine_lost_password_button_text_hover',
			[
				'label' => esc_html__('Text Color', 'shopengine-pro'),
				'type' => Controls_Manager::COLOR,
				'default' => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .woocommerce-ResetPassword button:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'shopengine_lost_password_button_bg_hover',
			[
				'label' =>esc_html__('Background Color', 'shopengine-pro'),
				'type' => Controls_Manager::COLOR,
				'default' => '#312b2b',
				'selectors' => [
					'{{WRAPPER}} .woocommerce-ResetPassword button:hover' => 'background: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'           => 'shopengine_lost_password_button_typography',
				'label'          => esc_html__('Typography', 'shopengine-pro'),
				'selector'       => '{{WRAPPER}} .woocommerce-ResetPassword button',
				'exclude'        => ['font_family', 'font_style', 'text_decoration', 'letter_spacing'],
				'fields_options' => [
					'typography'     => [
						'default' => 'custom',
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
				],
			)
		);

		$this->add_control(
			'shopengine_lost_password_button_padding',
			[
				'label'      => esc_html__('Padding (px)', 'shopengine-pro'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px'],
				'default'	=> [
					'top'	=> '10',
					'right'	=> '10',
					'bottom' => '10',
					'left' => '10',
					'unit' => 'px',
					'isLinked' => true,
				],
				'selectors'  => [
					'{{WRAPPER}} .woocommerce-ResetPassword button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.rtl {{WRAPPER}} .woocommerce-ResetPassword button' => 'padding: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				],
			]
		);
		
		$this->add_control(
			'shopengine_lost_password_button_border_radius',
			[
				'label'      => esc_html__('Border Radius (px)', 'shopengine-pro'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px'],
				'size_units' => ['px'],
				'default'	=> [
					'top'		=> '6',
					'right'	=> '6',
					'bottom' => '6',
					'left' => '6',
					'unit' => 'px',
					'isLinked' => true,
				],
				'selectors'  => [
					'{{WRAPPER}} .woocommerce-ResetPassword button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.rtl {{WRAPPER}} .woocommerce-ResetPassword button' => 'border-radius: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				],
			]
		);


		$this->end_controls_section();

		/**
		 * Typography Section
		 */
		$this->start_controls_section(
			'shopengine_lost_password_typography_section',
			[
				'label' => esc_html__('Global Font', 'shopengine-pro'),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'shopengine_lost_password_font_family',
			[
				'label'       => esc_html__('Font Family', 'shopengine-pro'),
				'description' => esc_html__('This font family is set for this specific widget.', 'shopengine-pro'),
				'type'        => Controls_Manager::FONT,
				'default'     => '',
				'selectors'   => [
					'{{WRAPPER}} .woocommerce-ResetPassword :is(label, input, button, p, *)' => 'font-family: {{VALUE}}',
				],
			]
		);


		$this->end_controls_section();
	}

	protected function screen() {

		$settings = $this->get_settings_for_display();

		$tpl = Products::instance()->get_widget_template($this->get_name(),'default', \ShopEngine_Pro::widget_dir());
		
		// phpcs:ignore WordPress.Security.NonceVerification.Recommended
		if(isset($_GET['reset-link-sent']) && sanitize_text_field(wp_unslash($_GET['reset-link-sent'])) == 'true'){
			$tpl = Products::instance()->get_widget_template($this->get_name(),'lost-password-confirmation', \ShopEngine_Pro::widget_dir());
		}

		include $tpl;
	}
}
