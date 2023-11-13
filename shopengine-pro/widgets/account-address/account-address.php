<?php

namespace Elementor;

use ShopEngine\Widgets\Products;

defined('ABSPATH') || exit;


class ShopEngine_Account_Address extends \ShopEngine\Base\Widget
{

	public function config() {
		return new ShopEngine_Account_Address_Config();
	}

	/**
	 * Address Types.
	 *
	 * Retrieve a list of address types.
	 *
	 * @since 1.0.0
	 * @access protected
	 *
	 * @return array Address types.
	 */
	protected function address_types() {
		return [
			''         => esc_html__('Default', 'shopengine-pro'),
			'billing'  => esc_html__('Billing Address Form', 'shopengine-pro'),
			'shipping' => esc_html__('Shipping Address Form', 'shopengine-pro'),
		];
	}


	protected function register_controls() {
		/**
		 * Section: Account Address
		 */
		$this->start_controls_section(
			'shopengine_section_account_address_details_styles',
			[
				'label' => esc_html__('Account Address', 'shopengine-pro'),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'shopengine_account_address_type',
			[
				'label'   => esc_html__('Address Type', 'shopengine-pro'),
				'type'    => Controls_Manager::SELECT,
				'options' => $this->address_types(),
			]
		);

		$this->add_control(
			'shopengine_account_address_info',
			[
				'type'            => Controls_Manager::RAW_HTML,
				'raw'             => esc_html__('Note: This is just a demonstration of how a different Account Address will look in the frontend.', 'shopengine-pro'),
				'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
			]
		);
		$this->end_controls_section();


		/**
		 * Section: Billing & Shipping Address
		 */
		$this->start_controls_section(
			'shopengine_account_address_section_billing_shipping',
			[
				'label' => esc_html__('Billing & Shipping Address', 'shopengine-pro'),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		/**
		 * Message
		 */
		$this->add_control(
			'shopengine_account_address_message_head',
			[
				'label' => esc_html__('Message', 'shopengine-pro'),
				'type'  => Controls_Manager::HEADING,
			]
		);

		$this->add_control(
			'shopengine_ad_address_message_clr',
			[
				'label'     => esc_html__('Color', 'shopengine-pro'),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#3a3a3a',
				'alpha'     => false,
				'selectors' => [
					'{{WRAPPER}} .shopengine-account-address > p' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'shopengine_ad_address_message_font_size',
			[
				'label'      => esc_html__('Font Size (px)', 'shopengine-pro'),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range'      => [
					'px' => [
						'min'  => 0,
						'max'  => 1000,
						'step' => 5,
					],
				],
				'default'    => [
					'unit' => 'px',
					'size' => 16,
				],
				'selectors'  => [
					'{{WRAPPER}} .shopengine-account-address > p' => 'font-size: {{SIZE}}{{UNIT}} !important;',
				],
			]
		);

		$this->add_control(
			'shopengine_ad_address_message_line_height',
			[
				'label'      => esc_html__('Line Height (px)', 'shopengine-pro'),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range'      => [
					'px' => [
						'min'  => 0,
						'max'  => 1000,
						'step' => 5,
					],
				],
				'default'    => [
					'unit' => 'px',
					'size' => 16,
				],
				'selectors'  => [
					'{{WRAPPER}} .shopengine-account-address > p' => 'line-height: {{SIZE}}{{UNIT}} !important;',
				],
			]
		);

		$this->add_responsive_control(
			'shopengine_ad_address_message_spacing',
			array(
				'label'      => esc_html__('Bottom Spacing', 'shopengine-pro'),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range'      => array(
					'px' => array(
						'min' => 1,
						'max' => 300,
					),
				),
				'default'    => [
					'unit' => 'px',
					'size' => 30,
				],
				'selectors'  => array(
					'{{WRAPPER}} .shopengine-account-address > p' => 'margin-bottom: {{SIZE}}{{UNIT}} !important;',
				),

			)
		);

		/**
		 * Title
		 */
		$this->add_control(
			'shopengine_account_address_title_head',
			[
				'label'     => esc_html__('Title', 'shopengine-pro'),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'shopengine_account_address_title_color',
			[
				'label'     => esc_html__('Color', 'shopengine-pro'),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#3A3A3A',
				'alpha'     => false,
				'selectors' => [
					'{{WRAPPER}} .shopengine-account-address .woocommerce-Addresses header h3' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'           => 'shopengine_account_address_title_typography',
				'label'          => esc_html__('Typography', 'shopengine-pro'),
				'selector'       => '{{WRAPPER}} .shopengine-account-address .woocommerce-Addresses header h3',
				'exclude'		 => ['text_decoration', 'font_family', 'text_transform', 'font_style', 'letter_spacing'],
				'fields_options' => [
					'typography'  => [
						'default' => 'custom',
					],
					'font_weight' => [
						'default' => '600',
					],
					'font_size'   => [
						'size_units' => ['px'],
						'labale'	=> 'Font size (px)',
						'default' => [
							'size' => '22',
							'unit' => 'px'
						],
						'selectors' => [
							'{{WRAPPER}} .shopengine-account-address .woocommerce-Address header h3' => 'font-size: {{SIZE}}{{UNIT}} !important;',
						],
					],
					'line_height' => [
						'size_units' => ['px'],
						'labale'	=> 'Line Height (px)',
						'default' => [
							'size' => '22',
							'unit' => 'px'
						]
					],
				],
			)
		);

		$this->add_control(
			'shopengine_account_address_title_margin',
			[
				'label'      => esc_html__('Margin', 'shopengine-pro'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px'],
				'default'    => [
					'unit'     => 'px',
					'top'      => 0,
					'right'    => 0,
					'bottom'   => 10,
					'left'     => 0,
					'isLinked' => false
				],
				'selectors'  => [
					'{{WRAPPER}} .shopengine-account-address .woocommerce-Address header h3' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.rtl {{WRAPPER}} .shopengine-account-address .woocommerce-Address header h3' => 'margin: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				],
			]
		);


		/**
		 * Address
		 */
		$this->add_control(
			'shopengine_account_address_address_head',
			[
				'label'     => esc_html__('Address', 'shopengine-pro'),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'shopengine_account_address_address_color',
			[
				'label'     => esc_html__('Color', 'shopengine-pro'),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#979797',
				'alpha'     => false,
				'selectors' => [
					'{{WRAPPER}} .shopengine-account-address .woocommerce-Addresses address' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'           => 'shopengine_account_address_address_typography',
				'label'          => esc_html__('Typography', 'shopengine-pro'),
				'selector'       => '{{WRAPPER}} .shopengine-account-address .woocommerce-Addresses address, {{WRAPPER}} .shopengine-account-address > p',
				'exclude'		 => ['text_decoration', 'font_family', 'text_transform', 'font_style', 'letter_spacing'],
				'fields_options' => [
					'typography'  => [
						'default' => 'custom',
					],
					'font_weight' => [
						'default' => '400',
					],
					'font_size'   => [
						'size_units' => ['px'],
						'labale'	=> 'Font size (px)',
						'default' => [
							'size' => '16',
							'unit' => 'px'
						],
					],
					'line_height' => [
						'size_units' => ['px'],
						'labale'	=> 'Line Height (px)',
						'default' => [
							'size' => '22',
							'unit' => 'px'
						]
					],
				],
			)
		);

		$this->add_responsive_control(
			'shopengine_account_address_content_padding',
			[
				'label'      => esc_html__('Content Padding (px)', 'shopengine-pro'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px'],
				'selectors'  => [
					'{{WRAPPER}}  .shopengine-account-address .woocommerce-Address' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.rtl {{WRAPPER}}  .shopengine-account-address .woocommerce-Address' => 'padding: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				],
				'separator'  => 'before',
			]
		);
		$this->end_controls_section();


		/**
		 * Section: Form Title
		 */
		$this->start_controls_section(
			'shopengine_account_address_section_form_title',
			[
				'label' => esc_html__('Form: Title', 'shopengine-pro'),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'shopengine_account_address_form_title',
			[
				'label'     => esc_html__('Enable Title', 'shopengine-pro'),
				'type'      => Controls_Manager::SWITCHER,
				'default'   => 'yes',
				'selectors' => [
					'{{WRAPPER}} .shopengine-account-address-form form > h3' => 'display: block',
				],
			]
		);

		$this->add_control(
			'shopengine_account_address_form_title_color',
			[
				'label'     => esc_html__('Color', 'shopengine-pro'),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#3A3A3A',
				'alpha'     => false,
				'selectors' => [
					'{{WRAPPER}} .shopengine-account-address-form form > h3' => 'color: {{VALUE}}',
				],
				'condition' => [
					'shopengine_account_address_form_title' => 'yes'
				]
			]
		);

		$this->add_responsive_control(
			'shopengine_account_address_form_title_font',
			[
				'label'      => esc_html__('Font Size (px)', 'shopengine-pro'),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range'      => [
					'px' => [
						'min' => 0,
						'max' => 64,
					],
				],
				'default'    => [
					'size' => 22,
				],
				'selectors'  => [
					'{{WRAPPER}} .shopengine-account-address-form form > h3' => 'font-size: {{SIZE}}{{UNIT}};'
				],
				'condition'  => [
					'shopengine_account_address_form_title' => 'yes'
				]
			]
		);

		$this->add_responsive_control(
			'shopengine_account_address_form_title_spacing',
			[
				'label'      => esc_html__('Margin', 'shopengine-pro'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px'],
				'default'    => [
					'unit'     => 'px',
					'top'      => 0,
					'right'    => 0,
					'bottom'   => 18,
					'left'     => 0,
					'isLinked' => false
				],
				'selectors'  => [
					'{{WRAPPER}} .shopengine-account-address-form form > h3' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.rtl {{WRAPPER}} .shopengine-account-address-form form > h3' => 'margin: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				],
				'condition'  => [
					'shopengine_account_address_form_title' => 'yes'
				]
			]
		);
		$this->end_controls_section();


		/**
		 * Section: Form Label
		 */
		$this->start_controls_section(
			'shopengine_account_address_section_form_label',
			[
				'label' => esc_html__('Form: Label', 'shopengine-pro'),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'shopengine_account_address_form_label_color',
			[
				'label'     => esc_html__('Color', 'shopengine-pro'),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#3a3a3a',
				'alpha'     => false,
				'selectors' => [
					'{{WRAPPER}} .shopengine-account-address-form p.form-row > label' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'shopengine_account_address_form_label_required',
			[
				'label'     => esc_html__('Required Color', 'shopengine-pro'),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#E70B0B',
				'alpha'     => false,
				'selectors' => [
					'{{WRAPPER}} .shopengine-account-address-form p.form-row > label .required' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'shopengine_account_address_form_label_font',
			[
				'label'      => esc_html__('Font Size (px)', 'shopengine-pro'),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range'      => [
					'px' => [
						'min' => 0,
						'max' => 64,
					],
				],
				'default'    => [
					'size' => 16,
				],
				'selectors'  => [
					'{{WRAPPER}} .shopengine-account-address-form p.form-row > label'           => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .shopengine-account-address-form p.form-row > label .required' => 'font-size: {{SIZE}}{{UNIT}};',
				]
			]
		);

		$this->add_responsive_control(
			'shopengine_account_address_form_label_spacing',
			[
				'label'      => esc_html__('Margin', 'shopengine-pro'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px'],
				'selectors'  => [
					'{{WRAPPER}} .shopengine-account-address-form p.form-row > label' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.rtl {{WRAPPER}} .shopengine-account-address-form p.form-row > label' => 'margin: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				]
			]
		);
		$this->end_controls_section();


		/**
		 * Section: Form Input
		 */
		$this->start_controls_section(
			'shopengine_input_style_wrapper',
			[
				'label' => esc_html__('Form: Input', 'shopengine-pro'),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'shopengine_ad_address_input_font_size',
			[
				'label'      => esc_html__('Font Size (px)', 'shopengine-pro'),
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
					'size' => 16,
				],

				'selectors'  => [
					'{{WRAPPER}} .shopengine-account-address-form p.form-row .woocommerce-input-wrapper input'                      => 'font-size: {{SIZE}}{{UNIT}} !important;',
					'{{WRAPPER}} .shopengine-account-address-form p.form-row .woocommerce-input-wrapper .select2-selection--single' => 'font-size: {{SIZE}}{{UNIT}} !important;',
					'{{WRAPPER}} .shopengine-account-address-form p.form-row .woocommerce-input-wrapper > select'                   => 'font-size: {{SIZE}}{{UNIT}} !important;',
				],
			]
		);

		$this->add_responsive_control(
			'shopengine_input_style_padding',
			[
				'label'      => esc_html__('Input Padding', 'shopengine-pro'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px'],
				'selectors'  => [
					'{{WRAPPER}} .shopengine-account-address-form p.form-row .woocommerce-input-wrapper input'                      => 'height:auto; padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
					'.rtl {{WRAPPER}} .shopengine-account-address-form p.form-row .woocommerce-input-wrapper input'                      => 'height:auto; padding: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}} !important;',
					'{{WRAPPER}} .shopengine-account-address-form p.form-row .woocommerce-input-wrapper .select2-selection--single' => 'height:auto; padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
					'.rtl {{WRAPPER}} .shopengine-account-address-form p.form-row .woocommerce-input-wrapper .select2-selection--single' => 'height:auto; padding: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}} !important;',
					'{{WRAPPER}} .shopengine-account-address-form p.form-row .woocommerce-input-wrapper > select'                   => 'height:auto; padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
					'.rtl {{WRAPPER}} .shopengine-account-address-form p.form-row .woocommerce-input-wrapper > select'                   => 'height:auto; padding: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}} !important;',
				],
				'default'    => [
					'unit'   => 'px',
					'top'    => 10,
					'right'  => 20,
					'bottom' => 10,
					'left'   => 20,
				],
				'separator'  => 'before'
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
				'label'     => esc_html__('Color', 'shopengine-pro'),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#000000',
				'alpha'     => false,
				'selectors' => [
					'{{WRAPPER}} .shopengine-account-address-form p.form-row .woocommerce-input-wrapper input'                           => 'color: {{VALUE}};',
					'{{WRAPPER}} .shopengine-account-address-form p.form-row .woocommerce-input-wrapper input::placeholder'              => 'color: {{VALUE}};',
					'{{WRAPPER}} .shopengine-account-address-form p.form-row .woocommerce-input-wrapper .select2-selection--single span' => 'color: {{VALUE}};',
					'{{WRAPPER}} .shopengine-account-address-form p.form-row .woocommerce-input-wrapper > select'                        => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'shopengine_input_background',
			[
				'label'     => esc_html__('Background Color', 'shopengine-pro'),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'alpha'     => false,
				'selectors' => [
					'{{WRAPPER}} .shopengine-account-address-form p.form-row .woocommerce-input-wrapper input'                      => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .shopengine-account-address-form p.form-row .woocommerce-input-wrapper .select2-selection--single' => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .shopengine-account-address-form p.form-row .woocommerce-input-wrapper > select'                   => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'           => 'shopengine_input_border',
				'label'          => esc_html__('Border', 'shopengine-pro'),
				'fields_options' => [
					'border' => [
						'default' => 'solid',
					],
					'width'  => [
						'default' => [
							'top'      => '1',
							'right'    => '1',
							'bottom'   => '1',
							'left'     => '1',
							'isLinked' => true,
						],
						'selectors' => [
							'{{WRAPPER}} .shopengine-account-address-form p.form-row .woocommerce-input-wrapper input, .shopengine-account-address-form p.form-row .woocommerce-input-wrapper .select2-selection--single, .shopengine-account-address-form p.form-row .woocommerce-input-wrapper > select' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
							'.rtl {{WRAPPER}} .shopengine-account-address-form p.form-row .woocommerce-input-wrapper input, .shopengine-account-address-form p.form-row .woocommerce-input-wrapper .select2-selection--single, .shopengine-account-address-form p.form-row .woocommerce-input-wrapper > select' => 'border-width: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}}',
						]
					],
					'color'  => [
						'default' => '#dee3ea'
					]
				],
				'selector'       => '{{WRAPPER}} .shopengine-account-address-form p.form-row .woocommerce-input-wrapper input,
					{{WRAPPER}} .shopengine-account-address-form p.form-row .woocommerce-input-wrapper .select2-selection--single,
					{{WRAPPER}} .shopengine-account-address-form p.form-row .woocommerce-input-wrapper > select'
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
				'label'     => esc_html__('Color', 'shopengine-pro'),
				'type'      => Controls_Manager::COLOR,
				'alpha'		=> false,
				'selectors' => [
					'{{WRAPPER}} .shopengine-account-address-form p.form-row .woocommerce-input-wrapper input:focus'                           => 'color: {{VALUE}};',
					'{{WRAPPER}} .shopengine-account-address-form p.form-row .woocommerce-input-wrapper .select2-selection--single:focus span' => 'color: {{VALUE}};',
					'{{WRAPPER}} .shopengine-account-address-form p.form-row .woocommerce-input-wrapper > select'                              => 'color: {{VALUE}};',
				],
				'default'   => '#000000',
			]
		);

		$this->add_control(
			'shopengine_input_background_focus',
			[
				'label'     => esc_html__('Background Color', 'shopengine-pro'),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'alpha'     => false,
				'selectors' => [
					'{{WRAPPER}} .shopengine-account-address-form p.form-row .woocommerce-input-wrapper input:focus'                      => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .shopengine-account-address-form p.form-row .woocommerce-input-wrapper .select2-selection--single:focus' => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .shopengine-account-address-form p.form-row .woocommerce-input-wrapper > select:focus'                   => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'shopengine_input_border_focus',
				'label'    => esc_html__('Border', 'shopengine-pro'),
				'selector' => '{{WRAPPER}} .shopengine-account-address-form p.form-row .woocommerce-input-wrapper input:focus,
					{{WRAPPER}} .shopengine-account-address-form p.form-row .woocommerce-input-wrapper .select2-selection--single:focus,
					{{WRAPPER}} .shopengine-account-address-form p.form-row .woocommerce-input-wrapper > select:focus'
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		
		


		$this->end_controls_section(); // end ./input style controls


		/**
		 * Section: Form Submit Button
		 */
		$this->start_controls_section(
			'shopengine_submit_button_style_wrapper',
			[
				'label' => esc_html__('Form: Submit Button', 'shopengine-pro'),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'           => 'shopengine_typography_secondary',
				'label'          => esc_html__('Typography', 'shopengine-pro'),
				'description'    => esc_html__('This style is applicable to : Form Input', 'shopengine-pro'),
				'exclude'        => ['font_style', 'font_family', 'line_height', 'letter_spacing', 'text_decoration'],
				'fields_options' => [
					'font_size' => [
						'label'      => esc_html__('Font Size (px)', 'shopengine-pro'),
						'size_units' => ['px'],
						'responsive' => false,
					],
				],
				'selector' => '{{WRAPPER}} .shopengine-account-address-form form button.button',
			]
		);

		$this->add_responsive_control(
			'shopengine_submit_button_padding',
			[
				'label'      => esc_html__('Padding', 'shopengine-pro'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px'],
				'default'    => [
					'unit'   => 'px',
					'top'    => 14,
					'right'  => 25,
					'bottom' => 14,
					'left'   => 25
				],
				'selectors'  => [
					'{{WRAPPER}} .shopengine-account-address-form form button.button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.rtl {{WRAPPER}} .shopengine-account-address-form form button.button' => 'padding: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs('shopengine_normal_color');
		// regular hover style
		$this->start_controls_tab(
			'shopengine_tab_item_normal',
			[
				'label' => esc_html__('Normal', 'shopengine-pro'),
			]
		);


		$this->add_control(
			'shopengine_submit_button_clr',
			[
				'label'     => esc_html__('Color', 'shopengine-pro'),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#fff',
				'alpha'     => false,
				'selectors' => [
					'{{WRAPPER}} .shopengine-account-address-form form button.button' => 'color: {{VALUE}} !important;',
				],
			]
		);

		$this->add_control(
			'shopengine_submit_button_bg_clr',
			[
				'label'     => esc_html__('Background', 'shopengine-pro'),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#3a3a3a',
				'alpha'     => false,
				'selectors' => [
					'{{WRAPPER}} .shopengine-account-address-form form button.button' => 'background-color: {{VALUE}} !important;',
				],
			]
		);

		$this->end_controls_tab();
		// hover style control
		$this->start_controls_tab(
			'shopengine_tab_item_hover',
			[
				'label' => esc_html__('Hover', 'shopengine-pro'),
			]
		);

		$this->add_control(
			'shopengine_submit_button_clr_hover',
			[
				'label'     => esc_html__('Color', 'shopengine-pro'),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#fff',
				'alpha'     => false,
				'selectors' => [
					'{{WRAPPER}} .shopengine-account-address-form form button.button:hover' => 'color: {{VALUE}} !important;',
				],
			]
		);

		$this->add_control(
			'shopengine_submit_button_bg_clr_hover',
			[
				'label'     => esc_html__('Background', 'shopengine-pro'),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#101010',
				'alpha'     => false,
				'selectors' => [
					'{{WRAPPER}} .shopengine-account-address-form form button.button:hover' => 'background-color: {{VALUE}} !important;',
				],
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->end_controls_section(); // end ./submit button style controls


		/**
		 * Section: Form Typography
		 */
		$this->start_controls_section(
			'shopengine_typography',
			[
				'label' => esc_html__('Global Font', 'shopengine-pro'),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'shopengine_typography_primary',
				'label'    => esc_html__('Typography', 'shopengine-pro'),
				'exclude'  => ['letter_spacing', 'text_decoration', 'font_size', 'font_style', 'font_weight', 'line_height'],
				'fields_options' => [
					'font_size' => [
						'label'      => esc_html__('Font Size (px)', 'shopengine-pro'),
						'size_units' => ['px'],
						'responsive' => false,
					],
					'line_height' => [
						'label'      => esc_html__('Line Height (px)', 'shopengine-pro'),
						'size_units' => ['px'],
						'responsive' => false,
					],
				],
				'selector' => '{{WRAPPER}} :is(.button, label, p, input, .select2-selection--single, address, h1,h2,h3,h4,h5,h6, a)',
			]
		);

		



		$this->end_controls_section();
	}


	protected function screen() {

		if(!is_user_logged_in()) {

			return esc_html__('You need first to be logged in', 'shopengine-pro');
		}

		$settings = $this->get_settings_for_display();

		$address_type = $settings['shopengine_account_address_type'];
		$edit_screen = in_array($address_type, array_keys($this->address_types())) ? $address_type : ''; // Validate Stock Type.

		$tpl = Products::instance()->get_widget_template($this->get_name(), 'default', \ShopEngine_Pro::widget_dir());

		include $tpl;
	}
}
