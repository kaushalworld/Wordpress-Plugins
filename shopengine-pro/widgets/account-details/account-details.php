<?php

namespace Elementor;

use ShopEngine\Widgets\Products;

defined('ABSPATH') || exit;


class ShopEngine_Account_Details extends \ShopEngine\Base\Widget {

	public function config() {
		return new ShopEngine_Account_Details_Config();
	}

	protected function register_controls() {
		/*
			-------------------------------------
			account details lable style
			-------------------------------------
		*/

		$this->start_controls_section(
			'shopengine_account_dashboard_label_style',
			[
				'label' => esc_html__('Label Style', 'shopengine-pro'),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'shopengine_label_color',
			[
				'label'     => esc_html__('Label Color', 'shopengine-pro'),
				'type'      => Controls_Manager::COLOR,
				'alpha'     => false,
				'default'   => '#707070',
				'selectors' => [
					'{{WRAPPER}} .shopengine-account-details form p.form-row label' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'shopengine_label_required',
			[
				'label'     => esc_html__('Required Color', 'shopengine-pro'),
				'type'      => Controls_Manager::COLOR,
				'alpha'     => false,
				'default'   => '#f00',
				'selectors' => [
					'{{WRAPPER}} .shopengine-account-details form p.form-row label .required' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'           => 'shopengine_account_dashboard_label_typography',
				'label'          => esc_html__('Typography', 'shopengine-pro'),
				'exclude'        => ['font_family', 'text_decoration', 'letter_spacing', 'font_style', 'line_height'],
				'fields_options' => [
					'typography' => [
						'default' => 'custom',
					],
					'font_size'  => [
						'size_units' => ['px'],
						'default'    => [
							'size' => '16',
							'unit' => 'px'
						],
						'responsive' => false,
					],
				],
				'selector'       => '{{WRAPPER}} .shopengine-account-details form p :is(label, label .required)'
			]
		);

		$this->add_control(
			'shopengine_label_margin',
			[
				'label'      => esc_html__('Margin', 'shopengine-pro'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px'],
				'default'    => [
					'top'    => 0,
					'right'  => 0,
					'bottom' => 4,
					'left'   => 0,
					'isLinked'	=> false,
				],
				'selectors'  => [
					'{{WRAPPER}} .shopengine-account-details form p.form-row label' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
					'.rtl {{WRAPPER}} .shopengine-account-details form p.form-row label' => 'margin: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}}',
				],
			]
		);

		$this->end_controls_section(); // end ./ account details lable style

		/*
			-------------------------------------
			account details input style
			-------------------------------------
		*/

		$this->start_controls_section(
			'shopengine_account_dashboard_input_style',
			[
				'label' => esc_html__('Input Style', 'shopengine-pro'),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'           => 'shopengine_account_dashboard_input_typography',
				'label'          => esc_html__('Typography', 'shopengine-pro'),
				'exclude'        => ['font_family', 'text_decoration', 'letter_spacing', 'font_style', 'line_height'],
				'fields_options' => [
					'typography' => [
						'default' => 'custom',
					],
					'font_size'  => [
						'size_units' => ['px'],
						'default'    => [
							'size' => '14',
							'unit' => 'px'
						],
						'responsive' => false,
					],
				],
				'selector'       => '{{WRAPPER}} .shopengine-account-details form p.form-row :is(input, input::placeholder)'
			]
		);

		$this->add_responsive_control(
			'shopengine_input_padding',
			[
				'label'      => esc_html__('Input Padding', 'shopengine-pro'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px'],
				'selectors'  => [
					'{{WRAPPER}} .shopengine-account-details form p.form-row input' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.rtl {{WRAPPER}} .shopengine-account-details form p.form-row input' => 'padding: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				],
				'default'    => [
					'unit'   => 'px',
					'top'    => 10,
					'right'  => 20,
					'bottom' => 10,
					'left'   => 20,
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
				'label'     => esc_html__('Text Color', 'shopengine-pro'),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#000000',
				'alpha'		=> false,
				'selectors' => [
					'{{WRAPPER}} .shopengine-account-details form p.form-row input'              => 'color: {{VALUE}};',
					'{{WRAPPER}} .shopengine-account-details form p.form-row input::placeholder' => 'color: {{VALUE}};'
				],
			]
		);

		$this->add_control(
			'shopengine_input_background',
			[
				'label'     => esc_html__('Background Color', 'shopengine-pro'),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'alpha'		=> false,
				'selectors' => [
					'{{WRAPPER}} .shopengine-account-details form p.form-row input' => 'background-color: {{VALUE}};'
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
						'label'	  => esc_html__( 'Border Width', 'shopengine-pro' ),
						'default' => [
							'top'      => '1',
							'right'    => '1',
							'bottom'   => '1',
							'left'     => '1',
							'isLinked' => true,
						],
					],
					'color'  => [
						'label'	  => esc_html__( 'Border Color', 'shopengine-pro' ),
						'default' => '#dee3ea',
						'alpha'	  => false,
					]
				],
				'selector'       => '{{WRAPPER}} .shopengine-account-details form p.form-row input'
			]
		);

		$this->add_control(
            'shopengine_input_border_radius',
            [
                'label'      => esc_html__('Border Radius (px)', 'shopengine-pro'),
                'type'       => Controls_Manager::DIMENSIONS,
                'default'    => [
                    'top'      => '5',
                    'right'    => '5',
                    'bottom'   => '5',
                    'left'     => '5',
                    'unit'     => 'px',
                    'isLinked' => true,
                ],
                'size_units' => ['px'],
                'selectors'  => [
                    '{{WRAPPER}} .shopengine-account-details form p.form-row input' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '.rtl {{WRAPPER}} .shopengine-account-details form p.form-row input' => 'border-radius: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
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
				'label'     => esc_html__('Text Color', 'shopengine-pro'),
				'type'      => Controls_Manager::COLOR,
				'alpha'		=> false,
				'selectors' => [
					'{{WRAPPER}} .shopengine-account-details form p.form-row input:focus' => 'color: {{VALUE}};'
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
				'alpha'		=> false,
				'selectors' => [
					'{{WRAPPER}} .shopengine-account-details form p.form-row input:focus' => 'background-color: {{VALUE}};'
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'shopengine_input_border_focus',
				'label'    => esc_html__('Border', 'shopengine-pro'),
				'selector' => '{{WRAPPER}} .shopengine-account-details form p.form-row input:focus',
				'fields_options' => [
					'width'  => [
						'label'	  => esc_html__( 'Border Width', 'shopengine-pro' ),
					],
					'color'  => [
						'label'	  => esc_html__( 'Border Color', 'shopengine-pro' ),
						'alpha'	  => false,
					]
				],
			]
		);

		$this->add_control(
            'shopengine_input_border_radius_focus',
            [
                'label'      => esc_html__('Border Radius (px)', 'shopengine-pro'),
                'type'       => Controls_Manager::DIMENSIONS,
                'default'    => [
                    'top'      => '5',
                    'right'    => '5',
                    'bottom'   => '5',
                    'left'     => '5',
                    'unit'     => 'px',
                    'isLinked' => true,
                ],
                'size_units' => ['px'],
                'selectors'  => [
                    '{{WRAPPER}} .shopengine-account-details form p.form-row input:focus' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '.rtl {{WRAPPER}} .shopengine-account-details form p.form-row input:focus' => 'border-radius: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
                ],
            ]
        );

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		/*
			-------------------------------------
			form
			-------------------------------------
		*/

		$this->start_controls_section(
			'shopengine_account_dashboard_form',
			[
				'label' => esc_html__('Form', 'shopengine-pro'),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'shopengine_form_legend_color',
			[
				'label'     => esc_html__('Legend Color', 'shopengine-pro'),
				'type'      => Controls_Manager::COLOR,
				'alpha'     => false,
				'default'   => '#3a3a3a',
				'selectors' => [
					'{{WRAPPER}} .shopengine-account-details form fieldset legend' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'           => 'shopengine_legend_typography',
				'label'          => esc_html__('Typography', 'shopengine-pro'),
				'exclude'        => ['font_family', 'text_decoration', 'letter_spacing', 'font_style', 'line_height'],
				'fields_options' => [
					'typography' => [
						'default' => 'custom',
					],
					'font_size'  => [
						'size_units' => ['px'],
						'default'    => [
							'size' => '22',
							'unit' => 'px'
						],
						'responsive' => false,
					],
				],
				'selector'       => '{{WRAPPER}} .shopengine-account-details form fieldset legend'
			]
		);

		$this->add_control(
			'shopengine_form_outline_color',
			[
				'label'     => esc_html__('Form Outline Color', 'shopengine-pro'),
				'type'      => Controls_Manager::COLOR,
				'alpha'     => false,
				'default'   => '#3a3a3a',
				'selectors' => [
					'{{WRAPPER}} .shopengine-account-details form fieldset' => 'border-color: {{VALUE}};',
				],
				'separator' => 'before',
			]
		);

		$this->end_controls_section();

		/*
			-------------------------------------
			form and button
			-------------------------------------
		*/

		$this->start_controls_section(
			'shopengine_account_dashboard_button',
			[
				'label' => esc_html__('Button', 'shopengine-pro'),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'shopengine_form_button_font_size',
			[
				'label'      => esc_html__('Button Font Size (px)', 'shopengine-pro'),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range'      => [
					'px' => [
						'min' => 0,
						'max' => 64,
					],
				],
				'default'    => [
					'size' => 15,
				],
				'selectors'  => [
					'{{WRAPPER}} .shopengine-account-details form p button.button' => 'font-size: {{SIZE}}{{UNIT}};',
				]
			]
		);

		$this->start_controls_tabs(
			'shopengine_form_button_tabs'
		);

		$this->start_controls_tab(
			'shopengine_form_button_tab_normal',
			[
				'label' => esc_html__('Normal', 'shopengine-pro'),
			]
		);

		$this->add_control(
			'shopengine_form_button_normal_clr',
			[
				'label'     => esc_html__('Button Color', 'shopengine-pro'),
				'type'      => Controls_Manager::COLOR,
				'alpha'     => false,
				'default'   => '#fff',
				'selectors' => [
					'{{WRAPPER}} .shopengine-account-details form p button.button' => 'color: {{VALUE}} !important',
				],
			]
		);

		$this->add_control(
			'shopengine_form_button_normal_bg',
			[
				'label'     => esc_html__('Background', 'shopengine-pro'),
				'type'      => Controls_Manager::COLOR,
				'alpha'     => false,
				'default'   => '#3a3a3a',
				'selectors' => [
					'{{WRAPPER}} .shopengine-account-details form p button.button' => 'background: {{VALUE}} !important',
				],
			]
		);

		$this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'           => 'shopengine_form_button_border',
                'selector'       => '{{WRAPPER}} .shopengine-account-details form p button.button',
				'size_units'     => ['px'],
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
					],
					'color'  => [
						'default' => '#101010',
						'alpha'		=> false,
					]
				],
            ]
        );

		$this->add_control(
            'shopengine_save_button_radius',
            [
                'label'      => esc_html__('Border Radius (px)', 'shopengine-pro'),
                'type'       => Controls_Manager::DIMENSIONS,
                'default'    => [
                    'top'      => '5',
                    'right'    => '5',
                    'bottom'   => '5',
                    'left'     => '5',
                    'unit'     => 'px',
                    'isLinked' => true,
                ],
                'size_units' => ['px'],
                'selectors'  => [
                    '{{WRAPPER}} .shopengine-account-details form p button.button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '.rtl {{WRAPPER}} .shopengine-account-details form p button.button' => 'border-radius: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
                ],
            ]
        );

		$this->end_controls_tab();

		// hover color
		$this->start_controls_tab(
			'shopengine_form_button_tab_normal_hover',
			[
				'label' => esc_html__('Hover', 'shopengine-pro'),
			]
		);

		$this->add_control(
			'shopengine_form_button_normal_clr_hover',
			[
				'label'     => esc_html__('Button Color', 'shopengine-pro'),
				'type'      => Controls_Manager::COLOR,
				'alpha'     => false,
				'default'   => '#fff',
				'selectors' => [
					'{{WRAPPER}} .shopengine-account-details form p button.button:hover' => 'color: {{VALUE}} !important;',
				],
			]
		);

		$this->add_control(
			'shopengine_form_button_normal_bg_hover',
			[
				'label'     => esc_html__('Background', 'shopengine-pro'),
				'type'      => Controls_Manager::COLOR,
				'alpha'     => false,
				'default'   => '#101010',
				'selectors' => [
					'{{WRAPPER}} .shopengine-account-details form p button.button:hover' => 'background: {{VALUE}} !important;',
				],
			]
		);

		$this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'           => 'shopengine_form_button_border_hover',
                'selector'       => '{{WRAPPER}} .shopengine-account-details form p button.button:hover',
				'size_units'     => ['px'],
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
							'{{WRAPPER}} .shopengine-account-details form p button.button:hover' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
							'.rtl {{WRAPPER}} .shopengine-account-details form p button.button:hover' => 'border-width: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
						],
					],
					'color'  => [
						'default' => '#101010',
						'alpha'		=> false,
					]
				],
            ]
        );

		$this->add_control(
            'shopengine_save_button_radius_hover',
            [
                'label'      => esc_html__('Border Radius (px)', 'shopengine-pro'),
                'type'       => Controls_Manager::DIMENSIONS,
                'default'    => [
                    'top'      => '5',
                    'right'    => '5',
                    'bottom'   => '5',
                    'left'     => '5',
                    'unit'     => 'px',
                    'isLinked' => true,
                ],
                'size_units' => ['px'],
                'selectors'  => [
                    '{{WRAPPER}} .shopengine-account-details form p button.button:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '.rtl {{WRAPPER}} .shopengine-account-details form p button.button:hover' => 'border-radius: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
                ],
            ]
        );

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->add_control(
			'shopengine_submit_button_padding',
			[
				'label'      => esc_html__('Padding', 'shopengine-pro'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px'],
				'separator'  => 'before',
				'default'    => [
					'unit'   => 'px',
					'top'    => 14,
					'right'  => 25,
					'bottom' => 14,
					'left'   => 25
				],
				'selectors'  => [
					'{{WRAPPER}} .shopengine-account-details form button.button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.rtl {{WRAPPER}} .shopengine-account-details form button.button' => 'padding: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section(); // end ./ form and button
		

		/**
		 	-------------------------------
			 Global Font 
			-------------------------------	
		 */
		$this->start_controls_section(
			'shopengine_section_style_global',
			[
				'label' => esc_html__('Global Font', 'shopengine-pro'),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
			$this->add_control(
				'shopengine_account_details_font_family',
				[
					'label'       => esc_html__('Font Family', 'shopengine-pro'),
					'description' => esc_html__('This font family is set for this specific widget.', 'shopengine-pro'),
					'type'        => Controls_Manager::FONT,
					'selectors'   => [
						'{{WRAPPER}} .shopengine-account-details form p :is(label, label .required),
						 {{WRAPPER}} .shopengine-account-details form p.form-row :is(input, input::placeholder),
						 {{WRAPPER}} .shopengine-account-details form fieldset legend,
						 {{WRAPPER}} .shopengine-account-details form .form-row > span,
						 {{WRAPPER}} .button' => 'font-family: {{VALUE}};',
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
