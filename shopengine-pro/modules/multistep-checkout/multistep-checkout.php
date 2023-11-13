<?php

namespace ShopEngine_Pro\Modules\Multistep_Checkout;

use Elementor\Controls_Manager;
use ShopEngine_Pro\Traits\Singleton;

class Multistep_Checkout {

    use Singleton;

    /**
     * @var int
     */
    public $current_page_id = 0;

    public function init() {
        //phpcs:disable WordPress.Security.NonceVerification 
        if(isset($_REQUEST['action']) && $_REQUEST['action'] === 'elementor') {

            $template_id = isset($_REQUEST['post']) ? (int) $_REQUEST['post'] : 0;
            $template    = \ShopEngine\Core\Builders\Templates::get_template_type_by_id($template_id);

            if('checkout' === $template) {
                $this->load();
            }
        }
        //phpcs:enable 
    }

	public function load() {

		add_action('wp_enqueue_scripts', [$this, 'scripts']);
		add_action('elementor/element/section/section_layout/after_section_end', [$this, 'register_section_controls'], 5);
		add_action('elementor/element/section/section_layout/after_section_end', [$this, 'register_inner_section_controls'], 6);
	}

	/**
	 *
	 * enqueue all necessary scripts for this module
	 *
	 */
    public function scripts() {

        wp_enqueue_style('shopengine-pro-multistep-checkout-style', \ShopEngine_Pro::module_url() . 'multistep-checkout/assets/css/main.css', [], \ShopEngine_Pro::version());
        wp_enqueue_script('shopengine-pro-multistep-checkout-script', \ShopEngine_Pro::module_url() . 'multistep-checkout/assets/js/main.js', ['jquery'], \ShopEngine_Pro::version(), true);
		
		$need_login_validate =  get_option( 'woocommerce_enable_guest_checkout' ) === 'no' && (get_option('woocommerce_enable_signup_and_login_from_checkout') === 'no');

		wp_localize_script('shopengine-pro-multistep-checkout-script', 'shopEngineMultistepCheckout', [
			'rest_nonce'				=> wp_create_nonce('wp_rest'),
			'is_login'					=> is_user_logged_in() ? esc_html__('You are already logged in.', 'shopengine-pro') : false,
			'existing_account_login'	=> ('no' === get_option( 'woocommerce_enable_checkout_login_reminder' )) ? esc_html__('Log into an existing account during checkout disable.', 'shopengine-pro') : false,
			'need_login_validate'		=> $need_login_validate,
		]);
	}

    /**
     * @param $control
     */
    public function register_section_controls($control) {

        $control->start_controls_section(
            'shopengine_multistep_checkout_settings_section',
            [
                'label'					=> esc_html__('Multistep Checkout', 'shopengine-pro'),
                'tab'					=> Controls_Manager::TAB_LAYOUT,
                'hide_in_inner'			=> true,
                'frontend_available'	=> true
            ]
        );

        $control->add_control(
            'shopengine_multistep_checkout_enable',
            [
                'label'					=> esc_html__('Enable Multistep Checkout', 'shopengine-pro'),
                'type'					=> Controls_Manager::SWITCHER,
                'label_on'				=> esc_html__('Yes', 'shopengine-pro'),
                'label_off'				=> esc_html__('No', 'shopengine-pro'),
                'return_value'			=> 'enabled',
                'default'				=> 'no',
                'frontend_available'	=> true,
				'prefix_class'			=> 'shopengine-multistep-',
            ]
        );

        $control->add_control(
            'shopengine_multistep_adaptive_height',
            [
                'label'					=> esc_html__('Adaptive Step Container Height?', 'shopengine-pro'),
                'description'			=> esc_html__('Enable this to make the multistep setp height adapt to current step height. ( Disables Equal Height Step Container )', 'shopengine-pro'),
                'type'					=> Controls_Manager::SWITCHER,
                'label_on'				=> esc_html__('Yes', 'shopengine-pro'),
                'label_off'				=> esc_html__('No', 'shopengine-pro'),
                'return_value'			=> 'yes',
                'default'				=> 'yes',
                'frontend_available'	=> true,
                'condition' => [
					'shopengine_multistep_checkout_enable' => 'enabled'
                ],
            ]
        );

        $control->add_control(
            'shopengine_multistep_step_scroll_top',
            [
                'label'					=> esc_html__('Enable scroll to top?', 'shopengine-pro'),
                'description'			=> esc_html__('Enable scroll to top animation for bigger form when click on the next/prev button', 'shopengine-pro'),
                'type'					=> Controls_Manager::SWITCHER,
                'label_on'				=> esc_html__('Yes', 'shopengine-pro'),
                'label_off'				=> esc_html__('No', 'shopengine-pro'),
                'return_value'			=> 'yes',
                'default'				=> 'no',
                'frontend_available'	=> true,
                'condition'				=> [
                    'shopengine_multistep_checkout_enable' => 'enabled'
                ],
            ]
        );

        $control->add_control(
            'shopengine_multistep_display_nav',
            [
                'label'					=> esc_html__('Display Multistep Nav?', 'shopengine-pro'),
                'type' 					=> Controls_Manager::SWITCHER,
                'label_on' 				=> esc_html__('Yes', 'shopengine-pro'),
                'label_off' 			=> esc_html__('No', 'shopengine-pro'),
                'return_value' 			=> 'yes',
                'default' 				=> 'yes',
                'separator' 			=> 'before',
                'frontend_available' 	=> true,
                'selectors'				=> [
                    '{{WRAPPER}}.shopengine-multistep-enabled .shopengine-multistep-navbar' => 'display: block;',
                ],
                'condition' 			=> [
					'shopengine_multistep_checkout_enable' => 'enabled'
                ],
            ]
        );

        $control->add_control(
            'shopengine_multistep_next_previous_button',
            [
                'label'					=> esc_html__('Display Global Next/Previous Button?', 'shopengine-pro'),
                'type' 					=> Controls_Manager::SWITCHER,
                'label_on' 				=> esc_html__('Yes', 'shopengine-pro'),
                'label_off' 			=> esc_html__('No', 'shopengine-pro'),
                'return_value' 			=> 'yes',
                'default' 				=> 'yes',
                'separator' 			=> 'before',
                'frontend_available' 	=> true,
                'selectors'				=> [
                    '{{WRAPPER}}.shopengine-multistep-enabled .shopengine-multistep-footer' => 'display: flex;',
                ],
                'condition' 			=> [
					'shopengine_multistep_checkout_enable' => 'enabled'
                ],
            ]
        );

        $control->add_control(
            'shopengine_multistep_shape',
            [
                'label'					=> esc_html__('Nav Shape', 'shopengine-pro'),
                'type' 					=> Controls_Manager::SWITCHER,
                'label_on' 				=> esc_html__('No', 'shopengine-pro'),
                'label_off' 			=> esc_html__('Yes', 'shopengine-pro'),
                'return_value' 			=> 'yes',
                'default' 				=> 'yes',
                'separator' 			=> 'before',
                'frontend_available' 	=> true,
                'selectors'				=> [
                    '{{WRAPPER}}.shopengine-multistep-enabled .shopengine-multistep-navbar ul li .shopengine-multistep-button::after' => 'display: none;',
                    '{{WRAPPER}}.shopengine-multistep-enabled .shopengine-multistep-navbar ul li .shopengine-multistep-button::before' => 'display: none;',
                ],
                'condition' 			=> [
					'shopengine_multistep_checkout_enable' => 'enabled'
                ],
            ]
        );

        $control->add_control(
            'shopengine_multistep_next_button_text',
            [
                'label'					=> esc_html__('Next Button Text', 'shopengine-pro'),
                'type'					=> Controls_Manager::TEXT,
                'default'				=> esc_html__('Next', 'shopengine-pro'),
                'frontend_available' 	=> true,
                'condition' => [
					'shopengine_multistep_checkout_enable' => 'enabled',
                    'shopengine_multistep_next_previous_button' => 'yes',
                ],
            ]
        );

        $control->add_control(
            'shopengine_multistep_previous_button_text',
            [
                'label'					=> esc_html__('Previous Button Text', 'shopengine-pro'),
                'type'					=> Controls_Manager::TEXT,
                'default'				=> esc_html__('Previous', 'shopengine-pro'),
                'frontend_available' 	=> true,
                'condition' => [
					'shopengine_multistep_checkout_enable' => 'enabled',
                    'shopengine_multistep_next_previous_button' => 'yes',
                ],
            ]
        );

		$control->end_controls_section();

        $control->start_controls_section(
            'shopengine_multistep_checkout_style_section',
            [
                'label'					=> esc_html__('Multistep Checkout', 'shopengine-pro'),
                'tab'					=> Controls_Manager::TAB_STYLE,
                'hide_in_inner'			=> true,
                'frontend_available'	=> true,
                'condition' => [
					'shopengine_multistep_checkout_enable' => 'enabled',
                ],
            ]
        );

		// Nav Style
		$control->add_control(
			'shopengine_multistep_nav_style_heading',
			[
				'label'     => esc_html__('Nav', 'shopengine-pro'),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
                'condition' => [
                    'shopengine_multistep_display_nav' => 'yes',
                ],
			]
		);

		$control->add_control(
			'shopengine_multistep_nav_style_alignment_controls',
			[
				'label'			=> esc_html__('Alignment Controls', 'shopengine-pro'),
				'type'			=> Controls_Manager::POPOVER_TOGGLE,
				'label_off'		=> esc_html__('Disabled', 'shopengine-pro'),
				'label_on'		=> esc_html__('Enabled', 'shopengine-pro'),
				'return_value'	=> 'yes',
				'default'		=> 'yes',
                'condition' => [
                    'shopengine_multistep_display_nav' => 'yes',
                ],
			]
		);

		$control->start_popover();

		$control->add_responsive_control(
			'shopengine_multistep_nav_direction',
			[
				'label'	=> esc_html__('Direction', 'shopengine-pro'),
				'type'	=> Controls_Manager::CHOOSE,
                'options'	=> [
                    'row' => [
                        'title' => esc_html__('Row', 'shopengine-pro'),
                        'icon' => 'eicon-arrow-right',
                    ],
                    'column' => [
                        'title' => esc_html__('Column', 'shopengine-pro'),
                        'icon' => 'eicon-arrow-down',
                    ],
                ],
				'default'	=> 'row',
                'selectors'	=> [
                    '{{WRAPPER}} .shopengine-multistep-navbar ul' => 'flex-direction: {{VALUE}};',
                ],
			]
		);

        $control->add_responsive_control(
            'shopengine_multistep_nav_justify_content',
            [
                'label'	=> esc_html__('Justify Content', 'shopengine-pro'),
                'type'	=> Controls_Manager::CHOOSE,
                'options'	=> [
                    'center' => [
                        'title' => esc_html__('Center', 'shopengine-pro'),
                        'icon' => 'eicon-justify-center-h',
                    ],
                    'flex-start' => [
                        'title' => esc_html__('Left', 'shopengine-pro'),
                        'icon' => 'eicon-justify-start-h',
                    ],
                    'flex-end' => [
                        'title' => esc_html__('Right', 'shopengine-pro'),
                        'icon' => 'eicon-justify-end-h',
                    ],
                    'space-between' => [
                        'title' => esc_html__('Space Between', 'shopengine-pro'),
                        'icon' => 'eicon-justify-space-evenly-h',
                    ],
                    'space-around' => [
                        'title' => esc_html__('Space Around', 'shopengine-pro'),
                        'icon' => 'eicon-justify-space-around-h',
                    ],
                    'space-evenly' => [
                        'title' => esc_html__('Space Evenly', 'shopengine-pro'),
                        'icon' => 'eicon-justify-space-evenly-h',
                    ],
                ],
                'default'	=> 'space-between',
                'toggle'	=> true,
                'selectors'	=> [
                    '{{WRAPPER}} .shopengine-multistep-navbar ul' => 'justify-content: {{VALUE}};',
                ],
            ]
        );

        $control->add_responsive_control(
            'shopengine_multistep_nav_align_items',
            [
                'label'	=> esc_html__('Align Items', 'shopengine-pro'),
                'type'	=> Controls_Manager::CHOOSE,
                'options'	=> [
                    'center' => [
                        'title' => esc_html__('Center', 'shopengine-pro'),
                        'icon' => 'eicon-justify-center-h',
                    ],
                    'flex-start' => [
                        'title' => esc_html__('Left', 'shopengine-pro'),
                        'icon' => 'eicon-align-start-v',
                    ],
                    'flex-end' => [
                        'title' => esc_html__('Right', 'shopengine-pro'),
                        'icon' => 'eicon-align-end-v',
                    ],
                    'stretch' => [
                        'title' => esc_html__('Stretch', 'shopengine-pro'),
                        'icon' => 'eicon-align-stretch-h',
                    ],
                    'baseline' => [
                        'title' => esc_html__('Baseline', 'shopengine-pro'),
                        'icon' => 'eicon-font',
                    ],
                ],
                'default'	=> 'stretch',
                'toggle'	=> true,
                'selectors'	=> [
                    '{{WRAPPER}} .shopengine-multistep-navbar ul' => 'align-items: {{VALUE}};',
                ],
            ]
        );

		$control->end_popover();

        $control->add_responsive_control(
            'shopengine_multistep_nav_height',
            [
                'label'      => esc_html__('Nav Height', 'shopengine-pro'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range'      => [
                    'px' => [
                        'min' => 0,
                        'max' => 100
                    ],
                ],
                'default'    => [
                    'unit' => 'px',
                    'size' => 30,
                ],
                'selectors'  => [
                    '{{WRAPPER}} .shopengine-multistep-navbar ul li .shopengine-multistep-button' => '--arrow-stroke-width: {{SIZE}}{{UNIT}};'
				],
                'condition' => [
                    'shopengine_multistep_display_nav' => 'yes',
                ],
            ]
        );

		$control->start_controls_tabs(
			'shopengine_multistep_nav_style_tabs',
			[
				'condition' => [
					'shopengine_multistep_display_nav' => 'yes',
				],
			]
		);

		$control->start_controls_tab(
			'shopengine_multistep_nav_style_tab_normal',
			[
				'label' => esc_html__('Normal', 'shopengine-pro'),
			]
		);

		$control->add_control(
			'shopengine_multistep_nav_color',
			[
				'label'     => esc_html__('Color', 'shopengine-pro'),
				'type'      => Controls_Manager::COLOR,
				'alpha'		=> false,
				'default'   => '#FFFFFF',
				'selectors' => [
					'{{WRAPPER}} .shopengine-multistep-navbar ul li .shopengine-multistep-button' => 'color: {{VALUE}};',
				],
			]
		);

		$control->add_control(
			'shopengine_multistep_nav_bg_color',
			[
				'label'     => esc_html__('Background', 'shopengine-pro'),
				'type'      => Controls_Manager::COLOR,
				'alpha'		=> false,
				'default'   => '#101010',
				'selectors' => [
					'{{WRAPPER}} .shopengine-multistep-navbar'	=> '--disable-bg: {{VALUE}};',
				],
			]
		);

		$control->add_control(
			'shopengine_multistep_nav_shape_color',
			[
				'label'     => esc_html__('Shape Color', 'shopengine-pro'),
				'type'      => Controls_Manager::COLOR,
				'alpha'		=> false,
				'default'   => '#FFFFFF',
				'selectors' => [
					'{{WRAPPER}} .shopengine-multistep-navbar ul li .shopengine-multistep-button::before' => 'border-left-color: {{VALUE}};',
				],
			]
		);

		$control->end_controls_tab();

		$control->start_controls_tab(
			'shopengine_multistep_nav_style_tab_active',
			[
				'label' => esc_html__('Active', 'shopengine-pro'),
			]
		);

		$control->add_control(
			'shopengine_multistep_nav_active_color',
			[
				'label'     => esc_html__('Color', 'shopengine-pro'),
				'type'      => Controls_Manager::COLOR,
				'alpha'		=> false,
				'default'   => '#FFFFFF',
				'selectors' => [
					'{{WRAPPER}} .shopengine-multistep-navbar ul li:hover .shopengine-multistep-button' => 'color: {{VALUE}};',
					'{{WRAPPER}} .shopengine-multistep-navbar ul li.active .shopengine-multistep-button' => 'color: {{VALUE}};',
				],
			]
		);

		$control->add_control(
			'shopengine_multistep_nav_active_bg_color',
			[
				'label'     => esc_html__('Background', 'shopengine-pro'),
				'type'      => Controls_Manager::COLOR,
				'alpha'		=> false,
				'default'   => '#312b2b',
				'selectors' => [
					'{{WRAPPER}} .shopengine-multistep-navbar'	=> '--background: {{VALUE}};',
				],
			]
		);

		$control->end_controls_tab();

		$control->end_controls_tabs();

        $control->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name'           => 'shopengine_multistep_navbar_border',
				'label'          => esc_html__('Border', 'shopengine-pro'),
				'fields_options' => [
					'width'  => [
						'label'   => esc_html__('Border Width', 'shopengine-pro'),
						'default' => [
							'top'      => 1,
							'right'    => 1,
							'bottom'   => 1,
							'left'     => 1,
							'isLinked' => true,
						],
						'responsive' => false,
					],
					'color'  => [
						'label'   => esc_html__('Border Color', 'shopengine-pro'),
						'default' => '#dee3ea',
						'alpha'	  => false,
					],
				],
                'condition' => [
                    'shopengine_multistep_shape' => 'yes',
                ],
				'selector'  => '{{WRAPPER}} .shopengine-multistep-navbar ul li .shopengine-multistep-button',
			]
		);

        $control->add_control(
			'shopengine_multistep_navbar_border_radius',
			[
				'label'     => esc_html__('Border Radius (px)', 'shopengine-pro'),
				'type'      => Controls_Manager::DIMENSIONS,
				'size_units' => ['px'],
				'default'   => [
					'top'      => '4',
					'right'    => '4',
					'bottom'   => '4',
					'left'     => '4',
					'unit'     => 'px',
					'isLinked' => true,
				],
                'condition' => [
                    'shopengine_multistep_shape' => 'yes',
                ],
				'selectors' => [
					'{{WRAPPER}} .shopengine-multistep-navbar ul li .shopengine-multistep-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.rtl {{WRAPPER}} .shopengine-multistep-navbar ul li .shopengine-multistep-button' => 'border-radius: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				],
			]
		);

		$control->add_responsive_control(
			'shopengine_multistep_nav_padding',
			[
				'label'      => esc_html__('Padding (px)', 'shopengine-pro'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px'],
				'default'    => [
					'top'      => '0',
					'right'    => '30',
					'bottom'   => '0',
					'left'     => '30',
					'unit'     => 'px',
					'isLinked' => false,
				],
				'separator' => 'before',
                'condition' => [
                    'shopengine_multistep_display_nav' => 'yes',
                ],
				'selectors'  => [
					'{{WRAPPER}} .shopengine-multistep-navbar ul li .shopengine-multistep-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$control->add_responsive_control(
			'shopengine_multistep_nav_margin',
			[
				'label'      => esc_html__('Item Margin (px)', 'shopengine-pro'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px'],
				'separator' => 'before',
                'condition' => [
                    'shopengine_multistep_display_nav' => 'yes',
                ],
				'separator' => 'after',
				'selectors'  => [
					'{{WRAPPER}} .shopengine-multistep-navbar ul li' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		// Step Wrap Style
		$control->add_control(
			'shopengine_multistep_step_wrap_style_heading',
			[
				'label'     => esc_html__('Step Wrap', 'shopengine-pro'),
				'type'      => Controls_Manager::HEADING,
			]
		);

		$control->add_responsive_control(
			'shopengine_multistep_step_wrap_margin',
			[
				'label'      => esc_html__('Margin (px)', 'shopengine-pro'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px'],
				'default'    => [
					'top'      => '30',
					'right'    => '0',
					'bottom'   => '30',
					'left'     => '0',
					'unit'     => 'px',
					'isLinked' => false,
				],
				'selectors'  => [
					'{{WRAPPER}}.shopengine-multistep-enabled .shopengine-steps-wrapper' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		// Next/Previous Button Style
		$control->add_control(
			'shopengine_multistep_next_previous_button_style_heading',
			[
				'label'     => esc_html__('Next/Previous Button', 'shopengine-pro'),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
                'condition' => [
                    'shopengine_multistep_next_previous_button' => 'yes',
                ],
			]
		);

        $control->add_responsive_control(
            'shopengine_multistep_next_previous_button_alignment',
            [
                'label'					=> esc_html__('Button Alignment', 'shopengine-pro'),
                'type'					=> Controls_Manager::CHOOSE,
                'options'				=> [
                    'center' => [
                        'title' => esc_html__('Center', 'shopengine-pro'),
                        'icon' => 'eicon-justify-center-h',
                    ],
                    'flex-start' => [
                        'title' => esc_html__('Left', 'shopengine-pro'),
                        'icon' => 'eicon-justify-start-h',
                    ],
                    'flex-end' => [
                        'title' => esc_html__('Right', 'shopengine-pro'),
                        'icon' => 'eicon-justify-end-h',
                    ],
                    'space-between' => [
                        'title' => esc_html__('Space Between', 'shopengine-pro'),
                        'icon' => 'eicon-justify-space-evenly-h',
                    ],
                    'space-around' => [
                        'title' => esc_html__('Space Around', 'shopengine-pro'),
                        'icon' => 'eicon-justify-space-around-h',
                    ],
                    'space-evenly' => [
                        'title' => esc_html__('Space Evenly', 'shopengine-pro'),
                        'icon' => 'eicon-justify-space-evenly-h',
                    ],
                ],
                'default'				=> 'flex-end',
                'toggle' 				=> true,
                'selectors'				=> [
                    '{{WRAPPER}}.shopengine-multistep-enabled .shopengine-multistep-footer' => 'justify-content: {{VALUE}};',
                ],
                'condition' => [
                    'shopengine_multistep_next_previous_button' => 'yes',
                ],
            ]
        );

		$control->start_controls_tabs(
			'shopengine_multistep_button_style_tabs',
			[
				'condition' => [
					'shopengine_multistep_next_previous_button' => 'yes',
				],
			]
		);

		$control->start_controls_tab(
			'shopengine_multistep_button_style_tab_normal',
			[
				'label' => esc_html__('Normal', 'shopengine-pro'),
			]
		);

		$control->add_control(
			'shopengine_multistep_next_previous_button_color',
			[
				'label'     => esc_html__('Color', 'shopengine-pro'),
				'type'      => Controls_Manager::COLOR,
				'alpha'		=> false,
				'default'   => '#FFFFFF',
				'selectors' => [
					'{{WRAPPER}} .shopengine-multistep-footer span' => 'color: {{VALUE}};',
				],
			]
		);

		$control->add_control(
			'shopengine_multistep_next_previous_button_bg_color',
			[
				'label'     => esc_html__('Background', 'shopengine-pro'),
				'type'      => Controls_Manager::COLOR,
				'alpha'		=> false,
				'default'   => '#101010',
				'selectors' => [
					'{{WRAPPER}} .shopengine-multistep-footer span' => 'background: {{VALUE}};',
				],
			]
		);

		$control->end_controls_tab();

		$control->start_controls_tab(
			'shopengine_multistep_button_style_tab_hover',
			[
				'label' => esc_html__('Hover', 'shopengine-pro'),
			]
		);

		$control->add_control(
			'shopengine_multistep_next_previous_button_hover_color',
			[
				'label'     => esc_html__('Color', 'shopengine-pro'),
				'type'      => Controls_Manager::COLOR,
				'alpha'		=> false,
				'default'   => '#FFFFFF',
				'selectors' => [
					'{{WRAPPER}} .shopengine-multistep-footer span:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$control->add_control(
			'shopengine_multistep_next_previous_button_hover_bg_color',
			[
				'label'     => esc_html__('Background', 'shopengine-pro'),
				'type'      => Controls_Manager::COLOR,
				'alpha'		=> false,
				'default'   => '#312b2b',
				'selectors' => [
					'{{WRAPPER}} .shopengine-multistep-footer span:hover' => 'background: {{VALUE}};',
				],
			]
		);

		$control->end_controls_tab();

		$control->end_controls_tabs();

		$control->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name'       => 'shopengine_multistep_next_previous_button_border',
				'label'      => esc_html__(' Border (px)', 'shopengine-pro'),
				'size_units' => ['px'],
				'selector'   => '{{WRAPPER}} .shopengine-multistep-footer span',
				'condition' => [
					'shopengine_multistep_next_previous_button' => 'yes',
				],
			]
		);

		$control->add_responsive_control(
			'shopengine_multistep_next_previous_button_padding',
			[
				'label'      => esc_html__('Padding (px)', 'shopengine-pro'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px'],
				'default'    => [
					'top'      => '10',
					'right'    => '20',
					'bottom'   => '10',
					'left'     => '20',
					'unit'     => 'px',
					'isLinked' => false,
				],
				'condition' => [
					'shopengine_multistep_next_previous_button' => 'yes',
				],
				'selectors'  => [
					'{{WRAPPER}} .shopengine-multistep-footer span' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$control->end_controls_section();
    }

    /**
     * @param $control
     */
    public function register_inner_section_controls($control) {

        $control->start_controls_section(
            'shopengine__multistep_checkout_inner_section',
            [
                'label'              => esc_html__('Multistep Checkout Step', 'shopengine-pro'),
                'tab'                => Controls_Manager::TAB_LAYOUT,
                'hide_in_top'        => true,
                'frontend_available' => true
            ]
        );

        $control->add_control(
            'shopengine_multistep_checkout_tab_title',
            [
                'label'              => esc_html__('Tab Title', 'shopengine-pro'),
                'type'               => Controls_Manager::TEXT,
                'label_block'        => true,
                'render_type'        => 'none',
                'frontend_available' => true
            ]
        );

        $control->add_control(
            'shopengine__multistep_checkout_tab_icon',
            [
                'label'              => esc_html__('Tab Icon', 'shopengine-pro'),
                'type'               => Controls_Manager::ICONS,
                'label_block'        => true,
                'render_type'        => 'none',
                'frontend_available' => true
            ]
        );

        $control->end_controls_section();
    }
}
