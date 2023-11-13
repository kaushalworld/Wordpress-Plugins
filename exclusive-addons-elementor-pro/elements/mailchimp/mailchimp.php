<?php
namespace ExclusiveAddons\Elements;

if( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.

use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Typography;
use \Elementor\Group_Control_Box_Shadow;
use \Elementor\Group_Control_Border;
use \ExclusiveAddons\Pro\Elementor\ProHelper;
use \Elementor\Widget_Base;
use \Elementor\Icons_Manager;

class MailChimp extends Widget_Base {

    public function get_name() {
        return 'exad-mailchimp';
    }

    public function get_title() {
        return esc_html__( 'MailChimp', 'exclusive-addons-elementor-pro' );
    }

    public function get_icon() {
        return 'exad exad-logo exad-mailchimp';
    }

    public function get_categories() {
        return [ 'exclusive-addons-elementor' ];
    }

    protected function register_controls() {
        $exad_primary_color = get_option( 'exad_primary_color_option', '#7a56ff' );
        $admin_link         = admin_url( 'admin.php?page=exad-settings' );
        $api_link           = 'https://rudrastyh.com/mailchimp-api/subscription.html#api';

        $this->start_controls_section(
            'exad_mailchimp_api_settings',
            [
                'label' => __( 'Settings', 'exclusive-addons-elementor-pro' )
            ]
        );

        $this->add_control(
            'exad_mailchimp_items',
            [
                'label'       => __( 'Mailchimp List', 'exclusive-addons-elementor-pro' ),
                'type'        => Controls_Manager::SELECT,
                'label_block' => false,
                'options'     => ProHelper::exad_mailchimp_list_items(),
                'description' => sprintf( __( 'To display MailChimp without an issue, you need to configure MailChimp API key. Please configure API key from the "API Keys" tab <a href="%s" target="_blank" rel="noopener">here</a>. This <a href="%s" target="_blank" rel="noopener">article</a> will help you to find out your API.', 'exclusive-addons-elementor-pro' ), esc_url( $admin_link ), esc_url( $api_link ) )
            ]
        );

        $this->add_control(
            'exad_mailchimp_content_type',
            [
                'label'          => __( 'Type', 'exclusive-addons-elementor-pro' ),
                'type'           => Controls_Manager::SELECT,
                'default'        => 'horizontal',
                'options'        => [
                    'vertical'   => __( 'Vertical', 'exclusive-addons-elementor-pro' ),
                    'horizontal' => __( 'Horozontal', 'exclusive-addons-elementor-pro' )
                ]
            ]
        );

        $this->add_control(
            'exad_mailchimp_enable_label',
            [
                'label'        => __( 'Enable Label', 'exclusive-addons-elementor-pro' ),
                'type'         => Controls_Manager::SWITCHER,
                'default'      => 'yes',
                'return_value' => 'yes'
            ]
        );

        $this->add_control(
            'exad_mailchimp_enable_placeholder',
            [
                'label'        => __( 'Enable Placeholder', 'exclusive-addons-elementor-pro' ),
                'type'         => Controls_Manager::SWITCHER,
                'default'      => 'yes',
                'return_value' => 'yes'
            ]
        );

        $this->add_control(
            'exad_mailchimp_email_label_text',
            [
                'label'       => __( 'Email Label', 'exclusive-addons-elementor-pro' ),
                'type'        => Controls_Manager::TEXT,
                'label_block' => false,
                'default'     => __( 'Email', 'exclusive-addons-elementor-pro' ),
                'condition'   => [
                    'exad_mailchimp_enable_label' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'exad_mailchimp_email_placeholder_text',
            [
                'label'       => __( 'Email Placeholder', 'exclusive-addons-elementor-pro' ),
                'type'        => Controls_Manager::TEXT,
                'label_block' => false,
                'default'     => __( 'Email', 'exclusive-addons-elementor-pro' ),
                'condition'   => [
                    'exad_mailchimp_enable_placeholder' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'exad_mailchimp_firstname_show',
            [
                'label'        => __( 'Enable First Name', 'exclusive-addons-elementor-pro' ),
                'type'         => Controls_Manager::SWITCHER,
                'default'      => 'no',
                'return_value' => 'yes'
            ]
        );

        $this->add_control(
            'exad_mailchimp_firstname_label_text',
            [
                'label'       => __( 'First Name Label', 'exclusive-addons-elementor-pro' ),
                'type'        => Controls_Manager::TEXT,
                'label_block' => false,
                'default'     => 'First Name',
                'condition'   => [
                    'exad_mailchimp_firstname_show' => 'yes',
                    'exad_mailchimp_enable_label'   => 'yes'
                ]
            ]
        );

        $this->add_control(
            'exad_mailchimp_firstname_placeholder_text',
            [
                'label'       => __( 'First Name Placeholder', 'exclusive-addons-elementor-pro' ),
                'type'        => Controls_Manager::TEXT,
                'label_block' => false,
                'default'     => __( 'First Name', 'exclusive-addons-elementor-pro' ),
                'condition'   => [
                    'exad_mailchimp_firstname_show'     => 'yes',
                    'exad_mailchimp_enable_placeholder' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'exad_mailchimp_lastname_show',
            [
                'label'        => __( 'Enable Last Name', 'exclusive-addons-elementor-pro' ),
                'type'         => Controls_Manager::SWITCHER,
                'default'      => 'no',
                'return_value' => 'yes'
            ]
        );

        $this->add_control(
            'exad_mailchimp_last_name_label_text',
            [
                'label'       => __( 'Last Name Label', 'exclusive-addons-elementor-pro' ),
                'type'        => Controls_Manager::TEXT,
                'label_block' => false,
                'default'     => 'Last Name',
                'condition'   => [
                    'exad_mailchimp_lastname_show' => 'yes',
                    'exad_mailchimp_enable_label'  => 'yes'
                ]
            ]
        );

        $this->add_control(
            'exad_mailchimp_lastname_placeholder_text',
            [
                'label'       => __( 'Last Name Placeholder', 'exclusive-addons-elementor-pro' ),
                'type'        => Controls_Manager::TEXT,
                'label_block' => false,
                'default'     => __( 'Last Name', 'exclusive-addons-elementor-pro' ),
                'condition'   => [
                    'exad_mailchimp_lastname_show'      => 'yes',
                    'exad_mailchimp_enable_placeholder' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'exad_mailchimp_button_text',
            [
                'label'       => __( 'Button Text', 'exclusive-addons-elementor-pro' ),
                'type'        => Controls_Manager::TEXT,
                'label_block' => false,
                'default'     => __( 'Subscribe', 'exclusive-addons-elementor-pro' )
            ]
        );

        $this->add_control(
			'exad_mailchimp_button_icon',
			[
				'label'       => __( 'Button Icon', 'exclusive-addons-elementor-pro' ),
				'type'        => Controls_Manager::ICONS,
                'default'     => [
                    'value'   => 'fas fa-arrow-right',
                    'library' => 'fa-solid'
                ],
			]
		);

        $this->add_control(
            'exad_mailchimp_loading_text',
            [
                'label'       => __( 'Loading Text', 'exclusive-addons-elementor-pro' ),
                'type'        => Controls_Manager::TEXT,
                'label_block' => false,
                'default'     => __( 'Submitting...', 'exclusive-addons-elementor-pro' )
            ]
        );

        $this->add_control(
            'exad_mailchimp_success_text',
            [
                'label'       => __( 'Success Text', 'exclusive-addons-elementor-pro' ),
                'type'        => Controls_Manager::TEXTAREA,
                'label_block' => true,
                'default'     => __( 'You have subscribed successfully...', 'exclusive-addons-elementor-pro' )
            ]
        );

        $this->add_control(
            'exad_mailchimp_error_text',
            [
                'label'       => __( 'Error Text', 'exclusive-addons-elementor-pro' ),
                'type'        => Controls_Manager::TEXTAREA,
                'label_block' => true,
                'default'     => __( 'Something goes wrong, please try again later.', 'exclusive-addons-elementor-pro' )
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
          'exad_mailchimp_style',
            [
                'label' => __( 'Mailchimp Field', 'exclusive-addons-elementor-pro' ),
                'tab'   => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_control(
			'exad_mailchimp_each_item_alignment',
			[
				'label' => __( 'Alignment', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'flex-start' => [
						'title' => __( 'Left', 'exclusive-addons-elementor-pro' ),
						'icon' => 'fa fa-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'exclusive-addons-elementor-pro' ),
						'icon' => 'fa fa-align-center',
					],
					'flex-end' => [
						'title' => __( 'Right', 'exclusive-addons-elementor-pro' ),
						'icon' => 'fa fa-align-right',
					],
				],
				'default' => 'flex-start',
                'toggle' => true,
                'selectors' => [
                    '{{WRAPPER}} .exad-mailchimp-container.exad-mailchimp-type-horizontal .exad-mailchimp-form-container' => 'justify-content: {{VALUE}};'
                ],
                'condition'    => [
                    'exad_mailchimp_content_type' => 'horizontal'
                ]
			]
        );

        $this->add_control(
			'exad_mailchimp_each_item_vertical_alignment',
			[
				'label' => __( 'Alignment', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'exad-mailchimp-item-vertical-left' => [
						'title' => __( 'Left', 'exclusive-addons-elementor-pro' ),
						'icon' => 'fa fa-align-left',
					],
					'exad-mailchimp-item-vertical-center' => [
						'title' => __( 'Center', 'exclusive-addons-elementor-pro' ),
						'icon' => 'fa fa-align-center',
					],
					'exad-mailchimp-item-vertical-right' => [
						'title' => __( 'Right', 'exclusive-addons-elementor-pro' ),
						'icon' => 'fa fa-align-right',
					],
				],
				'default' => 'exad-mailchimp-item-vertical-left',
                'toggle' => true,
                'condition'  => [
                    'exad_mailchimp_content_type' => 'vertical'
                ]
			]
        );
        
        $this->add_responsive_control(
            'exad_mailchimp_each_item_width',
            [
                'label'       => esc_html__( 'Field Item Width', 'exclusive-addons-elementor-pro' ),
                'type'        => Controls_Manager::SLIDER,
                'size_units'  => [ 'px', '%' ],
                'range'       => [
                    'px'      => [
                        'min' => 10,
                        'max' => 2000
                    ],
                    '%'      => [
                        'min' => 1,
                        'max' => 100
                    ]
                ],
                'default' => [
					'unit' => '%',
					'size' => 100,
				],
                'selectors'   => [
                    '{{WRAPPER}} .exad-mailchimp-form-container .exad-mailchimp-item' => 'width: {{SIZE}}{{UNIT}};'
                ]
            ]
        );

        $this->add_responsive_control(
            'exad_mailchimp_each_item_height',
            [
                'label'       => esc_html__( 'Field Item Height', 'exclusive-addons-elementor-pro' ),
                'type'        => Controls_Manager::SLIDER,
                'size_units'  => [ 'px', '%' ],
                'range'       => [
                    'px'      => [
                        'min' => 0,
                        'max' => 300
                    ],
                ],
                'default' => [
					'unit' => 'px',
					'size' => 50,
				],
                'selectors'   => [
                    '{{WRAPPER}} .exad-mailchimp-form-container .exad-mailchimp-item' => 'height: {{SIZE}}{{UNIT}};'
                ]
            ]
        );

        $this->add_control(
            'exad_mailchimp_each_item_bg_color',
            [
                'label'     => __( 'Background Color', 'exclusive-addons-elementor-pro' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .exad-mailchimp-container .exad-mailchimp-input-field' => 'background-color: {{VALUE}};'
                ]
            ]
        );

        $this->add_responsive_control(
            'exad_mailchimp_each_item_padding',
            [
                'label'      => __('Padding', 'exclusive-addons-elementor-pro'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'default'    => [
                    'top'    => 15,
                    'right'  => 15,
                    'bottom' => 15,
                    'left'   => 15,
                    'unit'   => 'px'
                ],
                'selectors'  => [
                    '{{WRAPPER}} .exad-mailchimp-container .exad-mailchimp-input-field' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->add_responsive_control(
            'exad_mailchimp_each_item_margin',
            [
                'label'      => __('Margin', 'exclusive-addons-elementor-pro'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .exad-mailchimp-container .exad-mailchimp-item' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
                'condition'  => [
                    'exad_mailchimp_content_type' => 'vertical'
                ]
            ]
        );

        $this->add_responsive_control(
            'exad_mailchimp_form_horizontal_type_each_item_spacing',
            [
                'label'        => __( 'Spacing', 'exclusive-addons-elementor-pro' ),
                'type'         => Controls_Manager::SLIDER,
                'range'        => [
                    'px'       => [
                        'min'  => 0,
                        'max'  => 200,
                        'step' => 1
                    ]
                ],
                'default'      => [
                    'unit'     => 'px',
                    'size'     => 25
                ],
                'size_units'   => [ 'px', 'em', '%' ],
                'selectors'    => [
                    '{{WRAPPER}} .exad-mailchimp-container.exad-mailchimp-type-horizontal .exad-mailchimp-item:not(:last-child)' => 'margin-right: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .exad-mailchimp-container.exad-mailchimp-type-vertical .exad-mailchimp-item:not(:last-child)' => 'margin-bottom: {{SIZE}}{{UNIT}};'
                ],
                // 'condition'    => [
                //     'exad_mailchimp_content_type' => 'horizontal'
                // ]
            ]
        );

        $this->add_responsive_control(
            'exad_mailchimp_each_item_border_radius',
            [
                'label'      => __('Border Radius', 'exclusive-addons-elementor-pro'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'default'    => [
                    'top'    => 0,
                    'right'  => 0,
                    'bottom' => 0,
                    'left'   => 0,
                    'unit'   => 'px'
                ],
                'selectors'  => [
                    '{{WRAPPER}} .exad-mailchimp-container .exad-mailchimp-input-field' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'exad_mailchimp_each_item_typography',
				'label' => __( 'Typography', 'exclusive-addons-elementor-pro' ),
				'selector' => '{{WRAPPER}} .exad-mailchimp-container .exad-mailchimp-input-field',
			]
        );
        
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'                   => 'exad_mailchimp_each_item_shadow',
                'selector'               => '{{WRAPPER}} .exad-mailchimp-container .exad-mailchimp-input-field',
            ]
        );   

        $this->start_controls_tabs( 'exad_mailchimp_each_item_border_tabs' );

            $this->start_controls_tab( 'normal', [ 'label' => esc_html__( 'Normal', 'exclusive-addons-elementor-pro' ) ] );

            $this->add_group_control(
                Group_Control_Border::get_type(),
                [
                    'name'               => 'exad_exclusive_each_item_border',
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
                    'selector'           => '{{WRAPPER}} .exad-mailchimp-container .exad-mailchimp-input-field'
                ]
            );

            $this->end_controls_tab();

            $this->start_controls_tab( 'focus', [ 'label' => esc_html__( 'Focus', 'exclusive-addons-elementor-pro' ) ] );

            $this->add_group_control(
                Group_Control_Border::get_type(),
                [
                    'name'            => 'exad_exclusive_each_item_border_on_focus',
                    'fields_options'  => [
                        'border'      => [
                            'default' => 'solid'
                        ],
                        'color'       => [
                            'default' => $exad_primary_color
                        ]
                    ],
                    'selector'        => '{{WRAPPER}} .exad-mailchimp-container .exad-mailchimp-input-field:focus'
                ]
            );

            $this->end_controls_tab();
        
        $this->end_controls_tabs();

        $this->end_controls_section();

        $this->start_controls_section(
          'exad_mailchimp_label_style',
            [
                'label'     => __( 'Label', 'exclusive-addons-elementor-pro' ),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'exad_mailchimp_enable_label' => 'yes'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'exad_mailchimp_label_typography',
                'selector' => '{{WRAPPER}} .exad-mailchimp-container label'
            ]
        );

        $this->add_control(
            'exad_mailchimp_label_color',
            [
                'label'     => __( 'Text Color', 'exclusive-addons-elementor-pro' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#000000',
                'selectors' => [
                    '{{WRAPPER}} .exad-mailchimp-container label' => 'color: {{VALUE}};'
                ]
            ]
        );

        $this->add_responsive_control(
            'exad_mailchimp_label_margin',
            [
                'label'        => __('Margin', 'exclusive-addons-elementor-pro'),
                'type'         => Controls_Manager::DIMENSIONS,
                'size_units'   => ['px', '%'],
                'default'      => [
                    'top'      => '0',
                    'right'    => '0',
                    'bottom'   => '5',
                    'left'     => '0',
                    'isLinked' => false
                ],
                'selectors'    => [
                    '{{WRAPPER}} .exad-mailchimp-container label' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
          'exad_mailchimp_placeholder_style',
            [
                'label'     => __( 'Placeholder', 'exclusive-addons-elementor-pro' ),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'exad_mailchimp_enable_placeholder' => 'yes'
                ]
            ]
        );

        $this->add_control(
                'exad_mailchimp_placeholder_color',
                [
                    'label'     => esc_html__( 'Placeholder Color', 'exclusive-addons-elementor-pro' ),
                    'type'      => Controls_Manager::COLOR,         
                    'selectors' => [
                        '{{WRAPPER}} .exad-mailchimp-container ::-webkit-input-placeholder' => 'color: {{VALUE}};',
                        '{{WRAPPER}} .exad-mailchimp-container ::-moz-placeholder'          => 'color: {{VALUE}};',
                        '{{WRAPPER}} .exad-mailchimp-container ::-ms-input-placeholder'     => 'color: {{VALUE}};'
                    ]
                ]
            );  

        $this->end_controls_section();

        $this->start_controls_section(
            'exad_mailchimp_form_submit_button_styles',
            [
                'label'         => esc_html__( 'Submit Button', 'exclusive-addons-elementor-pro' ),
                'tab'           => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_responsive_control(
            'exad_mailchimp_form_submit_btn_width',
            [
                'label'       => esc_html__( 'Button Width', 'exclusive-addons-elementor-pro' ),
                'type'        => Controls_Manager::SLIDER,
                'size_units'  => [ 'px', 'em', '%' ],
                'range'       => [
                    'px'      => [
                        'min' => 10,
                        'max' => 1500
                    ],
                    'em'      => [
                        'min' => 1,
                        'max' => 80
                    ]
                ],
                'selectors'   => [
                    '{{WRAPPER}} button.exad-mailchimp-subscribe-btn' => 'width: {{SIZE}}{{UNIT}};'
                ]
            ]
        );

        $this->add_responsive_control(
            'exad_mailchimp_form_submit_btn_icon spacing',
            [
                'label'       => esc_html__( 'Icon Spacing', 'exclusive-addons-elementor-pro' ),
                'type'        => Controls_Manager::SLIDER,
                'size_units'  => [ 'px' ],
                'range'       => [
                    'px'      => [
                        'min' => 0,
                        'max' => 50
                    ],
                ],
                'default'     => [
                    'unit'     => 'px',
					'size'     => 10
                ],
                'selectors'   => [
                    '{{WRAPPER}} button.exad-mailchimp-subscribe-btn .exad-mailchimp-subscribe-btn-icon' => 'margin-left: {{SIZE}}{{UNIT}};'
                ]
            ]
        );
        
        $this->add_control(
            'exad_mailchimp_form_submit_btn_alignment',
            [
                'label'         => esc_html__( 'Button Alignment', 'exclusive-addons-elementor-pro' ),
                'type'          => Controls_Manager::CHOOSE,
                'label_block'   => true,
                'toggle'        => false,
                'default'       => 'default',
                'options'       => [
                    'default'   => [
                        'title' => __( 'Default', 'exclusive-addons-elementor-pro' ),
                        'icon'  => 'eicon-ban'
                    ],
                    'left'      => [
                        'title' => esc_html__( 'Left', 'exclusive-addons-elementor-pro' ),
                        'icon'  => 'eicon-text-align-left'
                    ],
                    'center'    => [
                        'title' => esc_html__( 'Center', 'exclusive-addons-elementor-pro' ),
                        'icon'  => 'eicon-text-align-center'
                    ],
                    'right'     => [
                        'title' => esc_html__( 'Right', 'exclusive-addons-elementor-pro' ),
                        'icon'  => 'eicon-text-align-right'
                    ]
                ],
                'condition'     => [
                    'exad_mailchimp_content_type' => 'vertical'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'exad_mailchimp_form_submit_btn_typography',
                'selector' => '{{WRAPPER}} button.exad-mailchimp-subscribe-btn'
            ]
        );     

        $this->add_responsive_control(
            'exad_mailchimp_form_submit_btn_margin',
            [
                'label'      => esc_html__( 'Margin', 'exclusive-addons-elementor-pro' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} button.exad-mailchimp-subscribe-btn' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );  
        
        $this->add_responsive_control(
            'exad_mailchimp_form_submit_btn_padding',
            [
                'label'        => esc_html__( 'Padding', 'exclusive-addons-elementor-pro' ),
                'type'         => Controls_Manager::DIMENSIONS,
                'size_units'   => [ 'px', 'em', '%' ],
                'default'      => [
                    'top'      => '12',
                    'right'    => '40',
                    'bottom'   => '12',
                    'left'     => '40',
                    'unit'     => 'px',
                    'isLinked' => false
                ],
                'selectors'    => [
                    '{{WRAPPER}} button.exad-mailchimp-subscribe-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );      

        $this->add_responsive_control(
            'exad_mailchimp_form_submit_btn_border_radius',
            [
                'label'        => __('Border Radius', 'exclusive-addons-elementor-pro'),
                'type'         => Controls_Manager::DIMENSIONS,
                'size_units'   => ['px', '%'],
                'default'      => [
                    'top'      => '0',
                    'right'    => '0',
                    'bottom'   => '0',
                    'left'     => '0',
                    'isLinked' => false
                ],
                'selectors'    => [
                    '{{WRAPPER}} button.exad-mailchimp-subscribe-btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );
        
        $this->start_controls_tabs( 'exad_mailchimp_form_submit_button_tabs' );

        $this->start_controls_tab( 'exad_mailchimp_form_submit_button_normal', [ 'label' => esc_html__( 'Normal', 'exclusive-addons-elementor-pro' ) ] );

        $this->add_control(
            'exad_mailchimp_form_submit_btn_text_color',
            [
                'label'     => esc_html__( 'Text Color', 'exclusive-addons-elementor-pro' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} button.exad-mailchimp-subscribe-btn' => 'color: {{VALUE}};'
                ]
            ]
        );

        $this->add_control(
            'exad_mailchimp_form_submit_btn_background_color',
            [
                'label'     => esc_html__( 'Background Color', 'exclusive-addons-elementor-pro' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#7a56ff',
                'selectors' => [
                    '{{WRAPPER}} button.exad-mailchimp-subscribe-btn' => 'background-color: {{VALUE}};'
                ]
            ]
        );
        
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'               => 'exad_mailchimp_form_submit_btn_border',
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
                        'default'    => '#7a56ff'
                    ]
                ],
                'selector'           => '{{WRAPPER}} button.exad-mailchimp-subscribe-btn'
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'                   => 'exad_mailchimp_form_submit_btn_box_shadow',
                'selector'               => '{{WRAPPER}} button.exad-mailchimp-subscribe-btn',
                'fields_options'         => [
                    'box_shadow_type'    => [ 
                        'default'        =>'yes' 
                    ],
                    'box_shadow'         => [
                        'default'        => [
                            'horizontal' => 0,
                            'vertical'   => 13,
                            'blur'       => 33,
                            'spread'     => 0,
                            'color'      => 'rgba(51, 77, 128, 0.2)'
                        ]
                    ]
                ]
            ]
        ); 
        
        $this->end_controls_tab();

        $this->start_controls_tab( 'exad_mailchimp_form_submit_button_hover', [ 'label' => esc_html__( 'Hover', 'exclusive-addons-elementor-pro' ) ] );

        $this->add_control(
            'exad_mailchimp_form_submit_btn_hover_text_color',
            [
                'label'     => esc_html__( 'Text Color', 'exclusive-addons-elementor-pro' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#7a56ff',
                'selectors' => [
                    '{{WRAPPER}} button.exad-mailchimp-subscribe-btn:hover' => 'color: {{VALUE}};'
                ]
            ]
        );

        $this->add_control(
            'exad_mailchimp_form_submit_btn_hover_background_color',
            [
                'label'     => esc_html__( 'Background Color', 'exclusive-addons-elementor-pro' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} button.exad-mailchimp-subscribe-btn:hover' => 'background-color: {{VALUE}};'
                ]
            ]
        );

        $this->add_control(
            'exad_mailchimp_form_submit_btn_hover_border_color',
            [
                'label'     => esc_html__( 'Border Color', 'exclusive-addons-elementor-pro' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} button.exad-mailchimp-subscribe-btn:hover' => 'border-color: {{VALUE}};'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'                   => 'exad_mailchimp_form_submit_btn_hover_box_shadow',
                'selector'               => '{{WRAPPER}} button.exad-mailchimp-subscribe-btn:hover',
            ]
        ); 
        
        $this->end_controls_tab();
        
        $this->end_controls_tabs();
        
        $this->end_controls_section();

        $this->start_controls_section(
            'exad_mailchimp_form_message_styles',
            [
                'label' => esc_html__( 'Message', 'exclusive-addons-elementor-pro' ),
                'tab'   => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_control(
            'exad_mailchimp_form_success_message_style',
            [
                'label'     => __( 'Success Message', 'exclusive-addons-elementor-pro' ),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before'
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'exad_mailchimp_form_success_message_typography',
                'selector' => '{{WRAPPER}} .exad-mailchimp-success-message p'
            ]
        );

        $this->add_control(
            'exad_mailchimp_form_success_message_color',
            [
                'label'     => __( 'Color', 'exclusive-addons-elementor-pro' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .exad-mailchimp-success-message p' => 'color: {{VALUE}};'
                ]
            ]
        );

        $this->add_control(
            'exad_mailchimp_form_error_message_style',
            [
                'label'     => __( 'Error Message', 'exclusive-addons-elementor-pro' ),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before'
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'exad_mailchimp_form_error_message_typography',
                'selector' => '{{WRAPPER}} .exad-mailchimp-error-msg p'
            ]
        );

        $this->add_control(
            'exad_mailchimp_form_error_message_color',
            [
                'label'     => __( 'Color', 'exclusive-addons-elementor-pro' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .exad-mailchimp-error-msg p' => 'color: {{VALUE}};'
                ]
            ]
        );


        $this->end_controls_section();
      
    }

    protected function render() {

        $settings = $this->get_settings();
        $api_key  = get_option('exad_save_mailchimp_api');
        $email_placeholder = $firsname_placeholder = $lastname_placeholder = '';

        // $icon = Icons_Manager::render_icon( $settings['exad_mailchimp_button_icon'], [ 'aria-hidden' => 'true' ] );

        if( 'yes' === $settings['exad_mailchimp_enable_placeholder'] ) :
            $email_placeholder    = $settings['exad_mailchimp_email_placeholder_text'];
            $firsname_placeholder = $settings['exad_mailchimp_firstname_placeholder_text'];
            $lastname_placeholder = $settings['exad_mailchimp_lastname_placeholder_text'];
        endif;

        $this->add_render_attribute(
            'exad_mailchimp_container',
            [
                'class'             => [ 
                    'exad-mailchimp-container', 
                    'exad-mailchimp-type-'.esc_attr( $settings['exad_mailchimp_content_type'] ),
                    $settings['exad_mailchimp_each_item_vertical_alignment']
                ],
                'data-mailchimp-id' => esc_attr( $this->get_id() ),
                'data-api-key'      => esc_attr( $api_key ),
                'data-list-id'      => esc_attr( $settings['exad_mailchimp_items'] ),
                'data-button-text'  => esc_attr( $settings['exad_mailchimp_button_text'] ),
                'data-icon-text'    => $settings['exad_mailchimp_button_icon']['value'],
                'data-success-text' => esc_attr( $settings['exad_mailchimp_success_text'] ),
                'data-error-text'   => esc_attr( $settings['exad_mailchimp_error_text'] ),
                'data-loading-text' => esc_attr( $settings['exad_mailchimp_loading_text'] )
            ]
        );

        if( 'vertical' === $settings['exad_mailchimp_content_type'] ) :
            $this->add_render_attribute( 'exad_mailchimp_container', 'class', 'button-align-'.esc_attr( $settings['exad_mailchimp_form_submit_btn_alignment'] ) );
        endif;
        
        if( ! empty( $api_key ) ) : ?>
            <div <?php echo $this->get_render_attribute_string( 'exad_mailchimp_container' ); ?>>
                <form id="exad-mailchimp-form-<?php echo esc_attr( $this->get_id() ); ?>" method="POST">
                    <div class="exad-mailchimp-form-container">
                        <div class="exad-mailchimp-item exad-mailchimp-email">
                            <?php if( 'yes' === $settings['exad_mailchimp_enable_label'] ) : ?>
                                <label for="<?php echo esc_attr( $settings['exad_mailchimp_email_label_text'] ); ?>"><?php echo esc_html( $settings['exad_mailchimp_email_label_text'] ); ?></label>
                            <?php endif; ?>
                            <input type="email" name="exad_mailchimp_email" class="exad-mailchimp-input-field" placeholder="<?php echo esc_attr( $email_placeholder ); ?>" required="required">
                        </div>

                        <?php if( 'yes' === $settings['exad_mailchimp_firstname_show'] ) : ?>
                            <div class="exad-mailchimp-item exad-mailchimp-firstname">
                                <?php if( 'yes' === $settings['exad_mailchimp_enable_label'] ) : ?>
                                    <label for="<?php echo esc_attr( $settings['exad_mailchimp_firstname_label_text'] ); ?>"><?php echo esc_html( $settings['exad_mailchimp_firstname_label_text'] ); ?></label>
                                <?php endif; ?>
                                <input type="text" name="exad_mailchimp_firstname" class="exad-mailchimp-input-field" placeholder="<?php echo esc_attr( $firsname_placeholder ); ?>">
                            </div>
                        <?php endif;

                        if( 'yes' === $settings['exad_mailchimp_lastname_show'] ) : ?>
                            <div class="exad-mailchimp-item exad-mailchimp-lastname">
                                <?php if( 'yes' === $settings['exad_mailchimp_enable_label'] ) : ?>
                                    <label for="<?php echo esc_attr( $settings['exad_mailchimp_last_name_label_text'] ); ?>"><?php echo esc_html( $settings['exad_mailchimp_last_name_label_text'] ); ?></label>
                                <?php endif; ?>
                                <input type="text" name="exad_mailchimp_lastname" class="exad-mailchimp-input-field" placeholder="<?php echo esc_attr( $lastname_placeholder ); ?>">
                            </div>
                        <?php endif; ?>

                        <div class="exad-mailchimp-submit-btn">
                            <button class="exad-mailchimp-subscribe-btn">
                                <?php if ( ! empty( $settings['exad_mailchimp_button_text'] ) ) : ?>
                                    <span class="exad-mailchimp-subscribe-btn-text"><?php echo esc_html( $settings['exad_mailchimp_button_text'] ); ?></span>
                                <?php endif;
                                if ( ! empty( $settings['exad_mailchimp_button_icon']['value'] ) ) : ?>
                                    <span class="exad-mailchimp-subscribe-btn-icon">
                                        <?php Icons_Manager::render_icon( $settings['exad_mailchimp_button_icon'], [ 'aria-hidden' => 'true' ] ); ?>
                                    </span>
                                <?php endif; ?>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        <?php else : ?>
            <p class="exad-mailchimp-error-msg"><?php echo esc_html( 'Please insert your API key first.', 'exclusive-addons-elementor-pro' ); ?></p>
        <?php endif;
    }
}