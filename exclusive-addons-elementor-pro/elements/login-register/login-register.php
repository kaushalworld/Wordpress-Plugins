<?php
namespace ExclusiveAddons\Elements;

if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.

use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Border;
use \Elementor\Group_Control_Box_Shadow;
use \Elementor\Group_Control_Typography;
use \Elementor\Widget_Base;
use \Elementor\Group_Control_Background;
use \Elementor\Icons_Manager;
use \ExclusiveAddons\Pro\Elementor\LoginClass;

class Login_Register extends Widget_Base {

    public function get_name() {
        return 'exad-login-register';
    }

    public function get_title() {
        return __( 'Login Form', 'exclusive-addons-elementor-pro' );
    }

    public function get_icon() {
        return 'exad exad-logo exad-login-register';
    }

    public function get_categories() {
        return [ 'exclusive-addons-elementor' ];
    }

    protected function register_controls() {
        $exad_primary_color = get_option( 'exad_primary_color_option', '#7a56ff' );

        $this->start_controls_section(
            'exad_login_register_settings',
            [
                'label' => __( 'Settings', 'exclusive-addons-elementor-pro' )
            ]
        );

        $this->add_control(
            'exad_login_enable_heading',
            [
                'label'        => __( 'Enable Heading', 'exclusive-addons-elementor-pro' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => __( 'On', 'exclusive-addons-elementor-pro' ),
                'label_off'    => __( 'Off', 'exclusive-addons-elementor-pro' ),
                'return_value' => 'yes',
                'default'      => 'yes'
            ]
        );

        $this->add_control(
            'exad_login_heading_icon',
            [
                'label'       => __( 'Heading Icon', 'exclusive-addons-elementor-pro' ),
				'type'        => Controls_Manager::ICONS,
				'default'     => [
                    'value'   => 'fab fa-wordpress-simple',
                    'library' => 'fa-brands'
                ],
                'condition'   => [
                    'exad_login_enable_heading' => 'yes'
                ]
            ]
		);

        $this->add_control(
            'exad_login_heading_text',
            [
                'label'       => __( 'Heaging Text', 'exclusive-addons-elementor-pro' ),
                'type'        => Controls_Manager::TEXT,
                'default'     => __( 'Login Form', 'exclusive-addons-elementor-pro' ),
                'condition'   => [
                    'exad_login_enable_heading' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'exad_login_register_button_text',
            [
                'label'       => __( 'Button Text', 'exclusive-addons-elementor-pro' ),
                'type'        => Controls_Manager::TEXT,
                'default'     => __( 'Log In', 'exclusive-addons-elementor-pro' )
            ]
        );

        $this->add_control(
            'exad_enable_redirect_after_login',
            [
                'label'        => __( 'Redirect After Login', 'exclusive-addons-elementor-pro' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => __( 'On', 'exclusive-addons-elementor-pro' ),
                'label_off'    => __( 'Off', 'exclusive-addons-elementor-pro' ),
                'return_value' => 'yes',
                'default'      => 'no'
            ]
        );

        $this->add_control(
            'exad_redirect_after_login_link',
            [
                'type'          => Controls_Manager::URL,
                'show_label'    => false,
                'show_external' => false,
                'placeholder'   => __( 'https://your-link.com', 'exclusive-addons-elementor-pro' ),
                'description'   => __( 'Note: Because of security reasons, you can only use your current domain here.', 'exclusive-addons-elementor-pro' ),
                'condition'     => [
                    'exad_enable_redirect_after_login' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'exad_enable_redirect_after_logout',
            [
                'label'        => __( 'Redirect After Logout', 'exclusive-addons-elementor-pro' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => __( 'On', 'exclusive-addons-elementor-pro' ),
                'label_off'    => __( 'Off', 'exclusive-addons-elementor-pro' ),
                'return_value' => 'yes',
                'default'      => 'no'
            ]
        );

        $this->add_control(
            'exad_redirect_after_logout_link',
            [
                'type'          => Controls_Manager::URL,
                'show_label'    => false,
                'show_external' => false,
                'placeholder'   => __( 'https://your-link.com', 'exclusive-addons-elementor-pro' ),
                'description'   => __( 'Note: Because of security reasons, you can only use your current domain here.', 'exclusive-addons-elementor-pro' ),
                'condition'     => [
                    'exad_enable_redirect_after_logout' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'exad_enable_lost_password',
            [
                'label'        => __( 'Lost Password', 'exclusive-addons-elementor-pro' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => __( 'Show', 'exclusive-addons-elementor-pro' ),
                'label_off'    => __( 'Hide', 'exclusive-addons-elementor-pro' ),
                'return_value' => 'yes',
                'default'      => 'yes'
            ]
        );

        $this->add_control(
            'exad_lost_password_text',
            [
                'label'       => __( 'Lost Password text', 'exclusive-addons-elementor-pro' ),
                'type'        => Controls_Manager::TEXT,
                'default'     => __( 'Lost Your password', 'exclusive-addons-elementor-pro' ),
                'condition'   => [
                    'exad_enable_remember_me' => 'yes',
                ]
            ]
        );

        if ( get_option( 'users_can_register' ) ) :
            $this->add_control(
                'exad_enable_register',
                [
                    'label'        => __( 'Register', 'exclusive-addons-elementor-pro' ),
                    'type'         => Controls_Manager::SWITCHER,
                    'label_on'     => __( 'Show', 'exclusive-addons-elementor-pro' ),
                    'label_off'    => __( 'Hide', 'exclusive-addons-elementor-pro' ),
                    'return_value' => 'yes',
                    'default'      => 'yes'
                ]
            );
        endif;

        $this->add_control(
            'exad_enable_remember_me',
            [
                'label'        => __( 'Remember me', 'exclusive-addons-elementor-pro' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => __( 'Show', 'exclusive-addons-elementor-pro' ),
                'label_off'    => __( 'Hide', 'exclusive-addons-elementor-pro' ),
                'return_value' => 'yes',
                'default'      => 'yes'
            ]
        );

        $this->add_control(
            'exad_remember_me_text',
            [
                'label'       => __( 'Remember me text', 'exclusive-addons-elementor-pro' ),
                'type'        => Controls_Manager::TEXT,
                'default'     => __( 'Remember Me', 'exclusive-addons-elementor-pro' ),
                'condition'   => [
                    'exad_enable_remember_me' => 'yes',
                ]
            ]
        );

        $this->add_control(
            'exad_enable_logged_in_message',
            [
                'label'        => __( 'Logged in Message', 'exclusive-addons-elementor-pro' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => __( 'Show', 'exclusive-addons-elementor-pro' ),
                'label_off'    => __( 'Hide', 'exclusive-addons-elementor-pro' ),
                'return_value' => 'yes',
                'default'      => 'yes'
            ]
        );

        $this->add_control(
            'exad_login_register_enable_label',
            [
                'label'        => __( 'Label', 'exclusive-addons-elementor-pro' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => __( 'Show', 'exclusive-addons-elementor-pro' ),
                'label_off'    => __( 'Hide', 'exclusive-addons-elementor-pro' ),
                'return_value' => 'yes',
                'default'      => 'yes'
            ]
        );

        $this->add_control(
            'exad_login_register_username_laebl',
            [
                'label'       => __( 'Username Label', 'exclusive-addons-elementor-pro' ),
                'type'        => Controls_Manager::TEXT,
                'default'     => __( 'Username or Email Address', 'exclusive-addons-elementor-pro' ),
                'condition'   => [
                    'exad_login_register_enable_label' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'exad_login_register_password_laebl',
            [
                'label'       => __( 'Password Label', 'exclusive-addons-elementor-pro' ),
                'type'        => Controls_Manager::TEXT,
                'default'     => __( 'Password', 'exclusive-addons-elementor-pro' ),
                'condition'   => [
                    'exad_login_register_enable_label' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'exad_enable_placeholder',
            [
                'label'        => __( 'Placeholder', 'exclusive-addons-elementor-pro' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => __( 'Show', 'exclusive-addons-elementor-pro' ),
                'label_off'    => __( 'Hide', 'exclusive-addons-elementor-pro' ),
                'return_value' => 'yes',
                'default'      => 'yes'
            ]
        );

        $this->add_control(
            'exad_login_register_username_placeholder',
            [
                'label'       => __( 'Username Placeholder', 'exclusive-addons-elementor-pro' ),
                'type'        => Controls_Manager::TEXT,
                'default'     => __( 'Username or Email Address', 'exclusive-addons-elementor-pro' ),
                'condition'   => [
                    'exad_enable_placeholder' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'exad_login_register_password_placeholder',
            [
                'label'       => __( 'Password Placeholder', 'exclusive-addons-elementor-pro' ),
                'type'        => Controls_Manager::TEXT,
                'default'     => __( 'Password', 'exclusive-addons-elementor-pro' ),
                'condition'   => [
                    'exad_enable_placeholder' => 'yes'
                ]
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'exad_login_register_container_style',
            [
                'label'         => __( 'Container', 'exclusive-addons-elementor-pro' ),
                'tab'           => Controls_Manager::TAB_STYLE                   
            ]
        );

        $this->add_responsive_control(
			'exad_login_register_container_width',
			[
				'label' => __( 'Container Width(%)', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ '%' ],
				'range' => [
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default' => [
					'unit' => '%',
					'size' => 100,
				],
				'selectors' => [
					'{{WRAPPER}} .exad-login-register' => 'max-width: {{SIZE}}%; width: 100%',
				],
			]
		);

        $this->add_control(
			'exad_login_register_container_alignment',
			[
				'label' => __( 'Alignment', 'exclusive-addons-elementor-pro' ),
				'type'        => Controls_Manager::CHOOSE,
				'toggle'      => false,
				'options' => [
					'exad-container-left'   => [
						'title' => esc_html__( 'Left', 'exclusive-addons-elementor-pro' ),
						'icon'  => 'eicon-text-align-left'
					],
					'exad-container-center' => [
						'title' => esc_html__( 'Center', 'exclusive-addons-elementor-pro' ),
						'icon'  => 'eicon-text-align-center'
					],
					'exad-container-right'  => [
						'title' => esc_html__( 'Right', 'exclusive-addons-elementor-pro' ),
						'icon'  => 'eicon-text-align-right'
					]
				],
				'default' => 'exad-container-left',
				'selectors_dictionary' => [
					'exad-container-left' => 'margin-right: auto;',
					'exad-container-center' => 'margin-left: auto; margin-right: auto',
					'exad-container-right' => 'margin-left: auto;',
				],
				'selectors' => [
					'{{WRAPPER}} .exad-login-register' => '{{VALUE}};'
				]
			]
        );

        $this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'exad_login_register_container_background',
				'label' => __( 'Background', 'exclusive-addons-elementor-pro' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .exad-login-register',
			]
        );

        $this->add_responsive_control(
			'exad_login_register_container_padding',
			[
				'label' => __( 'Padding', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'default' => [
                    'top' => '0',
                    'right' => '0',
                    'bottom' => '0',
                    'left' => '0',
                    'unit' => 'px',
                    'isLinked' => true,
                ],
				'selectors' => [
					'{{WRAPPER}} .exad-login-register' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
        );

        $this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'exad_login_register_container_border',
				'label' => __( 'Border', 'exclusive-addons-elementor-pro' ),
				'selector' => '{{WRAPPER}} .exad-login-register',
			]
        );
        
        $this->add_responsive_control(
			'exad_login_register_container_radius',
			[
				'label' => __( 'Border Radius', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'default' => [
                    'top' => '0',
                    'right' => '0',
                    'bottom' => '0',
                    'left' => '0',
                    'unit' => 'px',
                    'isLinked' => true,
                ],
				'selectors' => [
					'{{WRAPPER}} .exad-login-register' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
        );
        
        $this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'exad_login_register_container_shadow',
				'label' => __( 'Box Shadow', 'exclusive-addons-elementor-pro' ),
                'selector' => '{{WRAPPER}} .exad-login-register',
			]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'exad_login_register_heading_style',
            [
                'label'         => __( 'Heading', 'exclusive-addons-elementor-pro' ),
                'tab'           => Controls_Manager::TAB_STYLE,
                'condition'   => [
                    'exad_login_enable_heading' => 'yes'
                ]                   
            ]
        );

        $this->add_responsive_control(
			'exad_login_register_heading_alignment',
			[
				'label'       => esc_html__( 'Alignment', 'exclusive-addons-elementor-pro' ),
				'type'        => Controls_Manager::CHOOSE,
				'toggle'      => false,
				'options'     => [
					'exad-login-heading-left'   => [
						'title' => esc_html__( 'Left', 'exclusive-addons-elementor-pro' ),
						'icon'  => 'eicon-text-align-left'
					],
					'exad-login-heading-center' => [
						'title' => esc_html__( 'Center', 'exclusive-addons-elementor-pro' ),
						'icon'  => 'eicon-text-align-center'
					],
					'exad-login-heading-right'  => [
						'title' => esc_html__( 'Right', 'exclusive-addons-elementor-pro' ),
						'icon'  => 'eicon-text-align-right'
					]
				],
				'default'     => 'exad-login-heading-center'
			]
        );

        $this->add_control(
			'exad_login_register_heading_icon',
			[
				'label' => __( 'Icon', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

        $this->add_responsive_control(
            'exad_login_register_heading_icon_size',
            [
                'label'      => __( 'Icon Size', 'exclusive-addons-elementor-pro' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'range' => [
					'px' => [
						'min' => 0,
						'max' => 500,
					],
				],
                'default'    => [
                    'size'   => 30
                ],
                'selectors'  => [
                    '{{WRAPPER}} .exad-login-register-icon i' => 'font-size: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .exad-login-register-icon svg' => 'height: {{SIZE}}{{UNIT}}; width: {{SIZE}}{{UNIT}};'
                ]
            ]
        );

        $this->add_control(
            'exad_login_register_heading_icon_box',
            [
				'label'        => esc_html__( 'Icon Box', 'exclusive-addons-elementor-pro' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => 'no',
				'return_value' => 'yes'
            ]
		);
		
		$this->add_responsive_control(
			'exad_login_register_heading_icon_box_height',
			[
				'label'     => esc_html__( 'Height', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 50,
				],
				'selectors' => [
					'{{WRAPPER}} .exad-login-register-icon.yes' => 'height: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'exad_login_register_heading_icon_box' => 'yes'
				]
			]
		);
		$this->add_responsive_control(
			'exad_login_register_heading_icon_box_width',
			[
				'label'     => esc_html__( 'Width', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 50,
				],
				'selectors' => [
					'{{WRAPPER}} .exad-login-register-icon.yes' => 'width: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'exad_login_register_heading_icon_box' => 'yes'
				]
			]
        );

        $this->add_responsive_control(
			'exad_login_register_heading_icon_box_top_spacing',
			[
				'label'     => esc_html__( 'Top Spacing', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => -200,
						'max' => 200,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 0,
				],
				'selectors' => [
					'{{WRAPPER}} .exad-login-register-icon.yes' => 'margin-top: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'exad_login_register_heading_icon_box' => 'yes'
				]
			]
		);
        
        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'            => 'exad_login_register_heading_icon_box_background',
                'types'           => [ 'classic', 'gradient' ],
                'selector'        => '{{WRAPPER}} .exad-login-register-icon.yes',
                'condition' => [
                    'exad_login_register_heading_icon_box' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'exad_login_register_heading_icon_box_icon_color',
            [
                'label'     => esc_html__( 'Icon Color', 'exclusive-addons-elementor-pro' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#000000',
                'selectors' => [
                    '{{WRAPPER}} .exad-login-register-icon i' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'exad_login_register_heading_icon_box_border',
                'selector' => '{{WRAPPER}} .exad-login-register-icon.yes',
                'condition' => [
                    'exad_login_register_heading_icon_box' => 'yes'
                ]
            ]
        );

        $this->add_responsive_control(
			'exad_login_register_heading_icon_box_border_radius',
			[
				'label' => __( 'Border Radius', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'default' => [
                    'top' => '0',
                    'right' => '0',
                    'bottom' => '0',
                    'left' => '0',
                    'unit' => 'px',
                    'isLinked' => true,
                ],
				'selectors' => [
					'{{WRAPPER}} .exad-login-register-icon.yes' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition' => [
					'exad_login_register_heading_icon_box' => 'yes'
				]
			]
		);

        $this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'exad_login_register_heading_icon_box_box_shadow',
				'label' => __( 'Box Shadow', 'exclusive-addons-elementor-pro' ),
                'selector' => '{{WRAPPER}} .exad-login-register-icon.yes',
                'condition' => [
                    'exad_login_register_heading_icon_box' => 'yes'
                ]
			]
        );
        
        $this->add_control(
			'exad_login_register_heading_text',
			[
				'label' => __( 'Heading text', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
        );
        
        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'exad_login_register_heading_text_typography',
				'label' => __( 'Typography', 'exclusive-addons-elementor-pro' ),
				'selector' => '{{WRAPPER}} .exad-login-register_heading-text',
			]
        );
        
        $this->add_control(
			'exad_login_register_heading_text_color',
			[
				'label' => __( 'Text Color', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .exad-login-register_heading-text' => 'color: {{VALUE}}',
				],
			]
        );
        
        $this->add_responsive_control(
			'exad_login_register_heading_text_margin',
			[
				'label' => __( 'Margin', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'default' => [
                    'top' => '0',
                    'right' => '0',
                    'bottom' => '0',
                    'left' => '0',
                    'unit' => 'px',
                    'isLinked' => true,
                ],
				'selectors' => [
					'{{WRAPPER}} .exad-login-register_heading-text' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

        $this->end_controls_section();

        $this->start_controls_section(
            'exad_login_register_label_style',
            [
                'label'         => __( 'Label', 'exclusive-addons-elementor-pro' ),
                'tab'           => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'exad_login_register_enable_label' => 'yes'
                ]                   
            ]
        );

        $this->add_responsive_control(
			'exad_login_register_label_alignment',
			[
				'label' => __( 'Alignment', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => __( 'Left', 'exclusive-addons-elementor-pro' ),
						'icon' => 'fa fa-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'exclusive-addons-elementor-pro' ),
						'icon' => 'fa fa-align-center',
					],
					'right' => [
						'title' => __( 'Right', 'exclusive-addons-elementor-pro' ),
						'icon' => 'fa fa-align-right',
					],
				],
				'default' => 'left',
                'toggle' => true,
                'selectors' => [
					'{{WRAPPER}} .exad-login-register-wrapper label' => 'text-align: {{VALUE}};',
				],
			]
		);

        $this->add_control(
            'exad_login_register_label_color',
            [
                'label'     => __( 'Color', 'exclusive-addons-elementor-pro' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#000000',
                'selectors' => [
                    '{{WRAPPER}} .exad-login-register-wrapper label' => 'color: {{VALUE}};'
                ]               
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'exad_login_register_label_typography',
                'selector' => '{{WRAPPER}} .exad-login-register-wrapper label'
            ]
        );

        $this->add_responsive_control(
            'exad_login_register_label_spacing',
            [
                'label'      => __( 'Margin', 'exclusive-addons-elementor-pro' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'default'    => [
                    'top'    => '0',
                    'right'  => '0',
                    'bottom' => '10',
                    'left'   => '0',
                    'unit'   => 'px',
                    'isLinked' => false
                ],
                'selectors'  => [
                    '{{WRAPPER}} .exad-login-register-wrapper label' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'exad_login_register_input_field_style',
            [
                'label'         => __( 'Input Field', 'exclusive-addons-elementor-pro' ),
                'tab'           => Controls_Manager::TAB_STYLE                   
            ]
        );

        $this->add_responsive_control(
            'exad_login_register_container_spacing',
            [
                'label'      => __( 'Spacing', 'exclusive-addons-elementor-pro' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'default'    => [
                    'size'   => 10
                ],
                'selectors'  => [
                    '{{WRAPPER}} .exad-login-register-field-item' => 'margin-bottom: {{SIZE}}{{UNIT}};'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'exad_login_register_items_typography',
                'selector' => '{{WRAPPER}} .exad-login-registration-form .exad-login-register-input-field, {{WRAPPER}} .exad-login-registration-form .exad-login-register-password-field'
            ]
        );

        $this->add_control(
            'exad_login_register_items_placeholder_text_color',
            [
                'label'     => __( 'Placeholder Text Color', 'exclusive-addons-elementor-pro' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .exad-login-registration-form input[type=text]::-webkit-input-placeholder, {{WRAPPER}} .exad-login-registration-form input[type=password]::-webkit-input-placeholder' => 'color: {{VALUE}};'
                ]               
            ]
        );

        $this->add_responsive_control(
			'exad_login_register_items_height',
			[
				'label' => __( 'Input Field Height', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 40,
				],
				'selectors' => [
					'{{WRAPPER}} .exad-login-registration-form .exad-login-register-input-field, {{WRAPPER}} .exad-login-registration-form .exad-login-register-password-field' => 'height: {{SIZE}}{{UNIT}}',
				],
			]
		);

        $this->add_responsive_control(
            'exad_login_register_items_padding',
            [
                'label'      => __( 'Padding', 'exclusive-addons-elementor-pro' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px'],
                'selectors'  => [
                    '{{WRAPPER}} .exad-login-registration-form .exad-login-register-input-field, {{WRAPPER}} .exad-login-registration-form .exad-login-register-password-field' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->add_responsive_control(
            'exad_login_register_items_border_radius',
            [
                'label'      => __( 'Border Radius', 'exclusive-addons-elementor-pro' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px'],
                'selectors'  => [
                    '{{WRAPPER}} .exad-login-registration-form .exad-login-register-input-field, {{WRAPPER}} .exad-login-registration-form .exad-login-register-password-field' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->start_controls_tabs( 'exad_login_register_items_tabs' );

            // Normal State Tab
            $this->start_controls_tab( 'exad_login_register_items_tab_normal', [ 'label' => esc_html__( 'Normal', 'exclusive-addons-elementor-pro' ) ] );

                $this->add_control(
                    'exad_login_register_items_text_color',
                    [
                        'label'     => __( 'Text Color', 'exclusive-addons-elementor-pro' ),
                        'type'      => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .exad-login-registration-form input[type=text], {{WRAPPER}} .exad-login-registration-form input[type=password]' => 'color: {{VALUE}};'
                        ]               
                    ]
                );

                $this->add_control(
                    'exad_login_register_items_bg_color',
                    [
                        'label'     => __( 'Background Color', 'exclusive-addons-elementor-pro' ),
                        'type'      => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .exad-login-registration-form input[type=text], {{WRAPPER}} .exad-login-registration-form input[type=password]' => 'background-color: {{VALUE}};'
                        ]               
                    ]
                );

                $this->add_group_control(
                    Group_Control_Border::get_type(),
                    [
                        'name'               => 'exad_login_register_items_border',
                        'fields_options'     => [
                            'border'         => [
                                'default'    => 'solid'
                            ],
                            'width'          => [
                                'default'    => [
                                    'top'    => '1',
                                    'right'  => '1',
                                    'bottom' => '1',
                                    'left'   => '1'
                                ]
                            ],
                            'color'          => [
                                'default'    => '#000000'
                            ]
                        ],
                        'selector'           => '{{WRAPPER}} .exad-login-registration-form .exad-login-register-input-field, {{WRAPPER}} .exad-login-registration-form .exad-login-register-password-field'
                    ]
                );

                $this->add_group_control(
                    Group_Control_Box_Shadow::get_type(),
                    [
                        'name'     => 'exad_login_register_items_box_shadow',
                        'selector' => '{{WRAPPER}} .exad-login-registration-form input[type=text], {{WRAPPER}} .exad-login-registration-form input[type=password]'
                    ]
                );

            $this->end_controls_tab();

            // Focus State Tab
            $this->start_controls_tab( 'exad_login_register_items_tab_focus', [ 'label' => esc_html__( 'Focus', 'exclusive-addons-elementor-pro' ) ] );

                $this->add_control(
                    'exad_login_register_items_focus_text_color',
                    [
                        'label'     => __( 'Text Color', 'exclusive-addons-elementor-pro' ),
                        'type'      => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .exad-login-registration-form input[type=text]:focus, {{WRAPPER}} .exad-login-registration-form input[type=password]:focus' => 'color: {{VALUE}};'
                        ]               
                    ]
                );

                $this->add_control(
                    'exad_login_register_items_focus_bg_color',
                    [
                        'label'     => __( 'Background Color', 'exclusive-addons-elementor-pro' ),
                        'type'      => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .exad-login-registration-form input[type=text]:focus, {{WRAPPER}} .exad-login-registration-form input[type=password]:focus' => 'background-color: {{VALUE}};'
                        ]               
                    ]
                );

                $this->add_group_control(
                    Group_Control_Border::get_type(),
                    [
                        'name'            => 'exad_login_register_items_focus_border',
                        'fields_options'  => [
                            'border'      => [
                                'default' => 'solid'
                            ],
                            'color'       => [
                                'default' => $exad_primary_color
                            ]
                        ],
                        'selector'        => '{{WRAPPER}} .exad-login-registration-form input[type=text]:focus, {{WRAPPER}} .exad-login-registration-form input[type=password]:focus'
                    ]
                );

                $this->add_group_control(
                    Group_Control_Box_Shadow::get_type(),
                    [
                        'name'     => 'exad_login_register_items_focus_box_shadow',
                        'selector' => '{{WRAPPER}} .exad-login-registration-form input[type=text]:focus, {{WRAPPER}} .exad-login-registration-form input[type=password]:focus'
                    ]
                );

            $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();

        $this->start_controls_section(
            'exad_login_register_styles_remember_lost_password',
            [
                'label'     => esc_html__( 'Remember/Lost Password', 'exclusive-addons-elementor-pro' ),
                'tab'       => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_control(
			'exad_login_register_styles_remember_lost_password_position',
			[
				'label' => __( 'Remember Me & Lost Password Position', 'exclusive-addons-elementor-pro' ),
                'type' => Controls_Manager::SELECT,
                'label_block' => true,
				'default' => 'bottom-of-button',
				'options' => [
					'top-over-button'  => __( 'Top Over Button', 'exclusive-addons-elementor-pro' ),
					'bottom-of-button'  => __( 'Bottom of Button', 'exclusive-addons-elementor-pro' ),
				],
			]
        );
        
        $this->add_control(
			'exad_login_register_styles_remember_lost_password_alignment',
			[
				'label' => __( 'Remember Me & Lost Password Alignment', 'exclusive-addons-elementor-pro' ),
                'type' => Controls_Manager::SELECT,
                'label_block' => true,
				'default' => 'space-between',
				'options' => [
					'flex-start'  => __( 'Left', 'exclusive-addons-elementor-pro' ),
					'center'  => __( 'Center', 'exclusive-addons-elementor-pro' ),
					'flex-end'  => __( 'Right', 'exclusive-addons-elementor-pro' ),
					'space-between'  => __( 'Space Between', 'exclusive-addons-elementor-pro' ),
                ],
                'selectors' => [
					'{{WRAPPER}} .exad-login-register-remember' => 'justify-content: {{VALUE}};',
				],
			]
        );
        
        $this->add_responsive_control(
            'exad_login_register_remember_me_checkbox_margin',
            [
                'label'      => __( 'Remember Me & Lost Password Margin', 'exclusive-addons-elementor-pro' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'default'    => [
                    'top'    => '10',
                    'right'  => '0',
                    'bottom' => '10',
                    'left'   => '0',
                    'unit'   => 'px',
                    'isLinked' => false
                ],
                'selectors'  => [
                    '{{WRAPPER}} .exad-login-register-remember' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->add_control(
			'exad_login_register_remember',
			[
				'label' => __( 'Remember Me', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
        );

        $this->add_responsive_control(
			'exad_login_register_remember_checkbox_size',
			[
				'label' => __( 'Checkbox Size', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 50,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 17,
				],
				'selectors' => [
					'{{WRAPPER}} .exad-login-registration-form input[type=checkbox]' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}}',
				],
			]
		);

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'exad_login_register_remember_typography',
                'selector' => '{{WRAPPER}} .exad-login-register-remember .exad-login-remember-me-label'
            ]
        );

        $this->add_control(
            'exad_login_register_remember_color',
            [
                'label'     => __( 'Remember Me Text Color', 'exclusive-addons-elementor-pro' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#000000',
                'selectors' => [
                    '{{WRAPPER}} .exad-login-register-remember .exad-login-remember-me-label' => 'color: {{VALUE}};'
                ],           
            ]
        );

        $this->add_control(
            'exad_login_register_remember_me_checkbox_color',
            [
                'label'     => __( 'Check Box Background Color', 'exclusive-addons-elementor-pro' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#dddddd',
                'selectors' => [
                    '{{WRAPPER}} .exad-login-registration-form input[type=checkbox]' => 'background-color: {{VALUE}};'
                ],
                'condition' => [
                    'exad_enable_remember_me' => 'yes'
                ]            
            ]
        );

        $this->add_control(
            'exad_login_register_remember_me_checkbox_checked_color',
            [
                'label'     => __( 'Check Box Color( When Checked )', 'exclusive-addons-elementor-pro' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => $exad_primary_color,
                'selectors' => [
                    '{{WRAPPER}} .exad-login-registration-form input[type=checkbox]:checked:before' => 'border-color: {{VALUE}};'
                ],
                'condition' => [
                    'exad_enable_remember_me' => 'yes'
                ]               
            ]
        );

        $this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'exad_login_register_remember_me_checkbox_border',
				'label' => __( 'Border', 'exclusive-addons-elementor-pro' ),
				'selector' => '{{WRAPPER}} .exad-login-registration-form input[type=checkbox]',
			]
        );

        $this->add_responsive_control(
            'exad_login_register_remember_me_checkbox_radius',
            [
                'label'      => __( 'Border Radius', 'exclusive-addons-elementor-pro' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'default'    => [
                    'top'    => '0',
                    'right'  => '0',
                    'bottom' => '0',
                    'left'   => '0',
                    'unit'   => 'px'
                ],
                'selectors'  => [
                    '{{WRAPPER}} .exad-login-registration-form input[type=checkbox]' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->add_responsive_control(
            'exad_login_register_remember_me_margin',
            [
                'label'      => __( 'Remember Me Margin', 'exclusive-addons-elementor-pro' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'default'    => [
                    'top'    => '0',
                    'right'  => '0',
                    'bottom' => '0',
                    'left'   => '0',
                    'unit'   => 'px'
                ],
                'selectors'  => [
                    '{{WRAPPER}} .exad-login-register-remember .exad-login-register-field-item, {{WRAPPER}} .exad-login-register-remember .exad-login-register-field-item label' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'exad_login_register_remember_me_checkbox_shadow',
                'selector' => '{{WRAPPER}} .exad-login-registration-form input[type=checkbox]'
            ]
        );

        $this->add_control(
			'exad_login_register_lost_password',
			[
				'label' => __( 'Lost Password', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'exad_login_register_lost_password_typography',
                'selector' => '{{WRAPPER}} .exad-login-registration-form a'
            ]
        );

        $this->add_control(
            'exad_login_register_container_link_color',
            [
                'label'     => __( 'Lost Password Link Color', 'exclusive-addons-elementor-pro' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#000000',
                'selectors' => [
                    '{{WRAPPER}} .exad-login-registration-form a' => 'color: {{VALUE}};'
                ]               
            ]
        );

        $this->add_control(
            'exad_login_register_container_link_hover_color',
            [
                'label'     => __( 'Lost Password Link Color( Hover )', 'exclusive-addons-elementor-pro' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .exad-login-registration-form a:hover' => 'color: {{VALUE}};'
                ]               
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'exad_login_register_styles_button',
            [
                'label'     => esc_html__( 'Button', 'exclusive-addons-elementor-pro' ),
                'tab'       => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_responsive_control(
			'exad_login_register_button_alignment',
			[
				'label' => __( 'Alignment', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'exad-submit-button-left' => [
						'title' => __( 'Left', 'exclusive-addons-elementor-pro' ),
						'icon' => 'fa fa-align-left',
					],
					'exad-submit-button-center' => [
						'title' => __( 'Center', 'exclusive-addons-elementor-pro' ),
						'icon' => 'fa fa-align-center',
					],
					'exad-submit-button-right' => [
						'title' => __( 'Right', 'exclusive-addons-elementor-pro' ),
						'icon' => 'fa fa-align-right',
					],
					'exad-submit-button-justify' => [
						'title' => __( 'Right', 'exclusive-addons-elementor-pro' ),
						'icon' => 'fa fa-align-justify',
					],
				],
				'default' => 'exad-submit-button-left',
				'toggle' => true,
			]
		);

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'exad_login_register_button_typography',
                'selector' => '{{WRAPPER}} .exad-login-registration-form .exad-login-register-submit-button'
            ]
        );

        $this->add_responsive_control(
            'exad_login_register_button_margin',
            [
                'label'        => esc_html__( 'Margin', 'exclusive-addons-elementor-pro' ),
                'type'         => Controls_Manager::DIMENSIONS,
                'size_units'   => [ 'px', 'em', '%' ],
                'default'      => [
                    'top'      => '5',
                    'right'    => '0',
                    'bottom'   => '15',
                    'left'     => '0',
                    'unit'     => 'px',
                    'isLinked' => false
                ],
                'selectors'    => [
                    '{{WRAPPER}} .exad-login-registration-form .exad-login-register-submit-button' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->add_responsive_control(
            'exad_login_register_button_padding',
            [
                'label'        => __( 'Padding', 'exclusive-addons-elementor-pro' ),
                'type'         => Controls_Manager::DIMENSIONS,
                'size_units'   => [ 'px' ],
                'default'      => [
                    'top'      => '10',
                    'right'    => '45',
                    'bottom'   => '10',
                    'left'     => '45',
                    'isLinked' => false
                ],
                'selectors'    => [
                    '{{WRAPPER}} .exad-login-registration-form .exad-login-register-submit-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->add_responsive_control(
            'exad_login_register_button_radius',
            [
                'label'      => __( 'Border Radius', 'exclusive-addons-elementor-pro' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'default'    => [
                    'top'    => '0',
                    'right'  => '0',
                    'bottom' => '0',
                    'left'   => '0',
                    'unit'   => 'px'
                ],
                'selectors'  => [
                    '{{WRAPPER}} .exad-login-registration-form .exad-login-register-submit-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->start_controls_tabs( 'exad_login_register_button_tabs' );

            $this->start_controls_tab( 'exad_login_register_button_normal', [ 'label' => esc_html__( 'Normal', 'exclusive-addons-elementor-pro' ) ] );

                $this->add_control(
                    'exad_login_register_button_normal_color',
                    [
                        'label'     => esc_html__( 'Text Color', 'exclusive-addons-elementor-pro' ),
                        'type'      => Controls_Manager::COLOR,
                        'default'   => '#000000',
                        'selectors' => [
                            '{{WRAPPER}} .exad-login-registration-form .exad-login-register-submit-button' => 'color: {{VALUE}};'
                        ]
                    ]
                );

                $this->add_control(
                    'exad_login_register_button_normal_bg',
                    [
                        'label'     => esc_html__( 'Background Color', 'exclusive-addons-elementor-pro' ),
                        'type'      => Controls_Manager::COLOR,
                        'default'   => '#ffffff',
                        'selectors' => [
                            '{{WRAPPER}} .exad-login-registration-form .exad-login-register-submit-button' => 'background-color: {{VALUE}};'
                        ]
                    ]
                );

                $this->add_group_control(
                    Group_Control_Border::get_type(),
                    [
                        'name'               => 'exad_login_register_button_normal_border',
                        'fields_options'     => [
                            'border'         => [
                                'default'    => 'solid'
                            ],
                            'width'          => [
                                'default'    => [
                                    'top'    => '1',
                                    'right'  => '1',
                                    'bottom' => '1',
                                    'left'   => '1'
                                ]
                            ],
                            'color'          => [
                                'default'    => '#000000'
                            ]
                        ],
                        'selector'           => '{{WRAPPER}} .exad-login-registration-form .exad-login-register-submit-button'
                    ]
                );

                $this->add_group_control(
                    Group_Control_Box_Shadow::get_type(),
                    [
                        'name'     => 'exad_login_register_button_normal_box_shadow',
                        'selector' => '{{WRAPPER}} .exad-login-registration-form .exad-login-register-submit-button'
                    ]
                );
        
            $this->end_controls_tab();

            $this->start_controls_tab( 'exad_login_register_button_hover', [ 'label' => esc_html__( 'Hover', 'exclusive-addons-elementor-pro' ) ] );

                $this->add_control(
                    'exad_login_register_button_hover_color',
                    [
                        'label'     => esc_html__( 'Text Color', 'exclusive-addons-elementor-pro' ),
                        'type'      => Controls_Manager::COLOR,
                        'default'   => '#ffffff',
                        'selectors' => [
                            '{{WRAPPER}} .exad-login-registration-form .exad-login-register-submit-button:hover' => 'color: {{VALUE}};'
                        ]
                    ]
                );

                $this->add_control(
                    'exad_login_register_button_hover_bg',
                    [
                        'label'     => esc_html__( 'Background Color', 'exclusive-addons-elementor-pro' ),
                        'type'      => Controls_Manager::COLOR,
                        'default'   => '#000000',
                        'selectors' => [
                            '{{WRAPPER}} .exad-login-registration-form .exad-login-register-submit-button:hover' => 'background-color: {{VALUE}};'
                        ]
                    ]
                );

                $this->add_group_control(
                    Group_Control_Border::get_type(),
                    [
                        'name'     => 'exad_login_register_button_hover_border',
                        'selector' => '{{WRAPPER}} .exad-login-registration-form .exad-login-register-submit-button:hover'
                    ]
                );

                $this->add_group_control(
                    Group_Control_Box_Shadow::get_type(),
                    [
                        'name'     => 'exad_login_register_button_hover_box_shadow',
                        'selector' => '{{WRAPPER}} .exad-login-registration-form .exad-login-register-submit-button:hover'
                    ]
                );

            $this->end_controls_tab();
        
        $this->end_controls_tabs();

        $this->end_controls_section();

        $this->start_controls_section(
            'exad_login_register_logged_in_message',
            [
                'label'     => esc_html__( 'Logged In Message', 'exclusive-addons-elementor-pro' ),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'exad_enable_logged_in_message' => 'yes'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'exad_login_register_logged_in_typography',
                'selector' => '{{WRAPPER}} .exad-logged-in-message'
            ]
        );

        $this->add_control(
            'exad_login_register_logged_in_color',
            [
                'label'     => __( 'Color', 'exclusive-addons-elementor-pro' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#000000',
                'selectors' => [
                    '{{WRAPPER}} .exad-logged-in-message' => 'color: {{VALUE}};'
                ]               
            ]
        );

        $this->add_control(
            'exad_login_register_logged_in_link_color',
            [
                'label'     => __( 'Link Color', 'exclusive-addons-elementor-pro' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#000000',
                'selectors' => [
                    '{{WRAPPER}} .exad-logged-in-message a' => 'color: {{VALUE}};'
                ]               
            ]
        );

        $this->add_control(
            'exad_login_register_logged_in_link_hover_color',
            [
                'label'     => __( 'Link Color( Hover )', 'exclusive-addons-elementor-pro' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .exad-logged-in-message a:hover' => 'color: {{VALUE}};'
                ]               
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'exad_login_register_error_message',
            [
                'label'     => esc_html__( 'Error Message', 'exclusive-addons-elementor-pro' ),
                'tab'       => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'exad_login_register_error_typography',
                'selector' => '{{WRAPPER}} .exad-login-register .exad-login-field-message .exad-loginform-error'
            ]
        );

        $this->add_control(
            'exad_login_register_error_color',
            [
                'label'     => __( 'Text Color', 'exclusive-addons-elementor-pro' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#EE4B2B',
                'selectors' => [
                    '{{WRAPPER}} .exad-login-register .exad-login-field-message .exad-loginform-error' => 'color: {{VALUE}};'
                ]           
            ]
        );

        $this->end_controls_section();

    }

    protected function render() {
        $settings           = $this->get_settings_for_display();
        $current_url        = remove_query_arg( 'fake_arg' );
        $logout_redirect    = $current_url;
        $show_lost_password = 'yes' === $settings['exad_enable_lost_password'];
        $show_register      = get_option( 'users_can_register' ) && 'yes' === $settings['exad_enable_register'];
        $redirect_url = '';

        $invalid_username = '';
		$invalid_password = '';
		$session_error    = isset( $_SESSION['exad_error'] ) ? $_SESSION['exad_error'] : '';
		$session_id       = session_id();

		if ( ! empty( $session_id ) ) {
			if ( isset( $_SESSION['exad_error'] ) ) {
				if ( isset( $session_error ) ) {
					if ( 'invalid_username' === $session_error ) {
						$invalid_username = __( 'Unknown Username. Check again or try your email address.', 'exclusive-addons-elementor-pro' );
					} elseif ( 'invalid_email' === $session_error ) {
						$invalid_username = __( 'Unknown Email address. Check again or try your username.', 'exclusive-addons-elementor-pro' );
					} elseif ( 'incorrect_password' === $session_error ) {
						$invalid_password = __( 'Error: The Password you have entered is incorrect.', 'exclusive-addons-elementor-pro' );
					}
					unset( $_SESSION['exad_error'] );
				}
			}
		}

        $this->add_render_attribute( 'exad_login_register_form', 'class',  'exad-login-registration-form' );
        $this->add_render_attribute( 'exad_login_register_container', 'class',  'exad-login-register-wrapper' );
        $this->add_render_attribute( 'exad_login_register_submit_button_wrapper', 'class', 'exad-login-register-submit-button-wrapper');
        $this->add_render_attribute( 'exad_login_register_submit_button','class', 'exad-login-register-submit-button' );

        $this->add_render_attribute(
            'exad_login_register_input_field',
            [
                'type'  => 'text',
                'name'  => 'log',
                'id'    => 'user',
                'class' => 'exad-login-register-input-field'
            ]
        );

        $this->add_render_attribute(
            'exad_login_register_password_field',
            [
                'type'  => 'password',
                'name'  => 'pwd',
                'id'    => 'password',
                'class' => 'exad-login-register-password-field'
            ]
        );

        if( 'yes' === $settings['exad_enable_placeholder'] ) :
            $this->add_render_attribute( 'exad_login_register_input_field', 'placeholder', $settings['exad_login_register_username_placeholder'] );
            $this->add_render_attribute( 'exad_login_register_password_field', 'placeholder', $settings['exad_login_register_password_placeholder'] );
        endif;

        // if( 'yes' !== $settings['exad_enable_lost_password'] && 'yes' !== $settings['exad_enable_register'] ) :
            $this->add_render_attribute(
                'exad_login_register_submit_button_wrapper',
                [
                    'class' => [ 
                        esc_attr( $settings['exad_login_register_button_alignment'] )
                    ]
                ]
            );
        // endif;

        $this->add_render_attribute( 'exad_login_register_field_attr', 'input', 'required', true );
        $this->add_render_attribute( 'exad_login_register_field_attr', 'class', 'exad-login-register-field-item' );
        $this->add_render_attribute( 'exad_login_register_field_attr', 'aria-required', 'required', true );

        if ( 'yes' === $settings['exad_enable_redirect_after_login'] && ! empty( $settings['exad_redirect_after_login_link']['url'] ) ) :
            $redirect_url = $settings['exad_redirect_after_login_link']['url'];
        else :
            $redirect_url = $current_url;
        endif;

        if ( 'yes' === $settings['exad_enable_redirect_after_logout'] && ! empty( $settings['exad_redirect_after_logout_link']['url'] ) ) :
            $logout_redirect = $settings['exad_redirect_after_logout_link']['url'];
        endif;

        if ( is_user_logged_in() && ! \Elementor\Plugin::$instance->editor->is_edit_mode() ) :
            if ( 'yes' === $settings['exad_enable_logged_in_message'] ) :
                $current_user = wp_get_current_user();
                echo '<div class="exad-logged-in-message">' .
                    sprintf( __( 'You are Logged in as %1$s (<a class=""href="%2$s">Logout</a>)', 'exclusive-addons-elementor-pro' ), esc_html( $current_user->display_name ), wp_logout_url( esc_url( $logout_redirect ) ) ) .
                '</div>';
            endif;
            return;
        endif;
        ?>

        <div class="exad-login-register">
            <?php if( 'yes' === $settings['exad_login_enable_heading'] ) { ?>
                <div class="exad-login-register-heading <?php echo $settings['exad_login_register_heading_alignment'] ?>">
                    <?php if( !empty( $settings['exad_login_heading_icon']) ) { ?>
                        <span class="exad-login-register-icon <?php echo $settings['exad_login_register_heading_icon_box']; ?>">
                            <?php Icons_Manager::render_icon( $settings['exad_login_heading_icon'], [ 'aria-hidden' => 'true' ] ); ?>
                        </span>
                    <?php } ?>
                    <?php if( !empty( $settings['exad_login_heading_text']) ) { ?>
                        <h3 class="exad-login-register_heading-text">
                            <?php echo wp_kses_post( $settings['exad_login_heading_text'] ); ?>
                        </h3>
                    <?php } ?>
                </div>
            <?php } ?>
            <!-- esc_url( site_url( 'wp-login.php', 'login_post' ) ) -->
            <form <?php echo $this->get_render_attribute_string( 'exad_login_register_form' ); ?> method="post">   
                <input type="hidden" name="redirect_to" value="<?php echo esc_attr( $redirect_url ); ?>">
                <div <?php echo $this->get_render_attribute_string( 'exad_login_register_container' ); ?>>
                    <div <?php echo $this->get_render_attribute_string( 'exad_login_register_field_attr' ); ?>>
                        <?php
                            if ( $settings['exad_login_register_enable_label'] ) :
                                echo '<label for="user">' . esc_html( $settings['exad_login_register_username_laebl'] ) . '</label>';
                            endif;
                            echo '<input ' . $this->get_render_attribute_string( 'exad_login_register_input_field' ) . '>';
                        ?>
                        <?php if ( '' !== $invalid_username ) { ?>
                            <span class="exad-login-field-message"><span class="exad-loginform-error"><?php echo wp_kses_post( $invalid_username ); ?></span></span>
                        <?php } ?>
                    </div>
                    <div <?php echo $this->get_render_attribute_string( 'exad_login_register_field_attr' ); ?>>
                        <?php
                            if ( $settings['exad_login_register_enable_label'] ) :
                                echo '<label for="password">' . esc_html( $settings['exad_login_register_password_laebl'] ) . '</label>';
                            endif;
                            echo '<input ' . $this->get_render_attribute_string( 'exad_login_register_password_field' ) . '>';
                        ?>
                        <?php if ( '' !== $invalid_password ) { ?>
                            <span class="exad-login-field-message"><span class="exad-loginform-error"><?php echo wp_kses_post( $invalid_password ); ?></span></span>
                        <?php } ?>
                    </div>

                    <?php if( 'top-over-button' === $settings['exad_login_register_styles_remember_lost_password_position'] ): ?>
                        <div class="exad-login-register-remember">
                            <?php if ( 'yes' === $settings['exad_enable_remember_me'] ) : ?>
                                <div <?php echo $this->get_render_attribute_string( 'exad_login_register_field_attr' ); ?>>
                                    <label for="exad-login-forever-remember-me" class="exad-login-remember-me-label">
                                        <input class="exad-login-remember-me-input" type="checkbox" name="rememberme" value="forever">
                                        <?php echo esc_html( $settings['exad_remember_me_text'] ); ?>
                                    </label>
                                </div>
                            <?php endif; ?>
                            <?php if ( $show_lost_password || $show_register ) : ?>
                                <div class="exad-login-register-lost-password-wrapper">
                                    <?php if ( $show_lost_password ) : ?>
                                        <a class="exad-login-register-lost-password" href="<?php echo wp_lostpassword_url( esc_url( $redirect_url ) ); ?>">
                                            <?php echo esc_html( $settings['exad_lost_password_text'] ); ?>
                                        </a>
                                    <?php endif;

                                    if ( $show_register ) :
                                        if ( $show_lost_password ) :
                                            echo '<span class="exad-login-register-separator"> | </span>';
                                        endif;
                                        echo '<a class="exad-registration-link" href="'.wp_registration_url().'">';
                                            _e( 'Register', 'exclusive-addons-elementor-pro' );
                                        echo '</a>';
                                    endif;
                                echo '</div>';
                            endif;
                        echo '</div>';
                    endif; ?>

                    <div <?php echo $this->get_render_attribute_string( 'exad_login_register_submit_button_wrapper' ); ?>>
                        <button name="exad-login-submit" type="submit" <?php echo $this->get_render_attribute_string( 'exad_login_register_submit_button' ); ?>>
                            <?php if ( ! empty( $settings['exad_login_register_button_text'] ) ) : ?>
                                <span class="exad-login-register-button-text"><?php echo esc_html( $settings['exad_login_register_button_text'] ); ?></span>
                            <?php endif; ?>
                        </button>
                        <?php
							wp_nonce_field( 'exad-login', 'exad-login-nonce' );
						?>
                    </div>

                    <?php if( 'bottom-of-button' === $settings['exad_login_register_styles_remember_lost_password_position'] ): ?>

                        <div class="exad-login-register-remember">
                            <?php if ( 'yes' === $settings['exad_enable_remember_me'] ) : ?>
                                <div <?php echo $this->get_render_attribute_string( 'exad_login_register_field_attr' ); ?>>
                                    <label for="exad-login-forever-remember-me" class="exad-login-remember-me-label">
                                        <input class="exad-login-remember-me-input" type="checkbox" name="rememberme" value="forever">
                                        <?php echo esc_html( $settings['exad_remember_me_text'] ); ?>
                                    </label>
                                </div>
                            <?php endif; ?>
                            <?php if ( $show_lost_password || $show_register ) : ?>
                                <div class="exad-login-register-lost-password-wrapper">
                                    <?php if ( $show_lost_password ) : ?>
                                        <a class="exad-login-register-lost-password" href="<?php echo wp_lostpassword_url( esc_url( $redirect_url ) ); ?>">
                                            <?php echo esc_html( $settings['exad_lost_password_text'] ); ?>
                                        </a>
                                    <?php endif;

                                    if ( $show_register ) :
                                        if ( $show_lost_password ) :
                                            echo '<span class="exad-login-register-separator"> | </span>';
                                        endif;
                                        echo '<a class="exad-registration-link" href="'.wp_registration_url().'">';
                                            _e( 'Register', 'exclusive-addons-elementor-pro' );
                                        echo '</a>';
                                    endif;
                                echo '</div>';
                            endif;
                        echo '</div>';
                    endif;

                echo '</div>';
            echo '</form>';
        echo '</div>';
    }
}