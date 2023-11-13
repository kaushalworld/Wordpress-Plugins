<?php
namespace ExclusiveAddons\Elements;

if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.

use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Border;
use \Elementor\Group_Control_Box_Shadow;
use \Elementor\Group_Control_Background;
use \Elementor\Group_Control_Typography;
use \Elementor\Widget_Base;
use \ExclusiveAddons\Pro\Elementor\ProHelper;


class Cookie_Consent extends Widget_Base {
	
	public function get_name() {
		return 'exad-cookie-consent';
	}
	public function get_title() {
		return esc_html__( 'Cookie Consent', 'exclusive-addons-elementor-pro' );
	}
	public function get_icon() {
		return 'exad exad-logo exad-cookie-consent';
	}

	public function get_categories() {
		return [ 'exclusive-addons-elementor' ];
	}

	public function get_keywords() {
		return [ 'exclusive', 'cookie', 'consent', 'notification', 'session' ];
	}

	public function get_script_depends() {
        return [ 'exad-cookie-consent' ];
    }

	protected function register_controls() {
		$exad_primary_color = get_option( 'exad_primary_color_option', '#7a56ff' );

		/*
		* Cookie Consent
		*/
	    $this->start_controls_section(
			'exad_cookie_consent_section',
			[
				'label' => __( 'Contents', 'exclusive-addons-elementor-pro' )
			]
	    );

		$this->add_control(
			'exad_cookie_consent_message',
			[
				'label'   => __( 'Message', 'exclusive-addons-elementor-pro' ),
				'type'    => Controls_Manager::TEXTAREA,
				'default' => __( 'We use cookies to ensure that we give you the best experience on our website.', 'exclusive-addons-elementor-pro' )
			]
		);

		$this->add_control(
			'exad_cookie_consent_button_text',
			[
				'label'   => __( 'Cookie Button Text', 'exclusive-addons-elementor-pro' ),
				'type'    => Controls_Manager::TEXT,
				'default' => __( 'Ok, I understood.', 'exclusive-addons-elementor-pro' )
			]
		);

		$this->add_control(
			'exad_cookie_consent_position',
			[
				'label'   => __( 'Position', 'exclusive-addons-elementor-pro' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'bottom',
				'options' => [
					'top'          => __( 'Top', 'exclusive-addons-elementor-pro' ),
					'bottom'       => __( 'Bottom', 'exclusive-addons-elementor-pro' ),
					'bottom-left'  => __( 'Bottom Left', 'exclusive-addons-elementor-pro' ),
					'bottom-right' => __( 'Bottom Right', 'exclusive-addons-elementor-pro' ),
					'right-center' => __( 'Right Center', 'exclusive-addons-elementor-pro' ),
					'left-center'  => __( 'Left Center', 'exclusive-addons-elementor-pro' )
				]
			]
		);

		$this->add_control(
			'exad_cookie_consent_read_more_text',
			[
				'label'       => __( 'Read More Button Text', 'exclusive-addons-elementor-pro' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => __( 'Read more', 'exclusive-addons-elementor-pro' ),
				'default'     => __( 'Read More', 'exclusive-addons-elementor-pro' )
			]
		);

		$this->add_control(
			'exad_cookie_consent_read_more_link',
			[
				'label'         => __( 'Read More Button Link', 'exclusive-addons-elementor-pro' ),
				'type'          => Controls_Manager::URL,
				'placeholder'   => __( 'https://your-link.com', 'exclusive-addons-elementor-pro' ),
				'default'       => [
					'url'       => 'https://exclusiveaddons.com'
				]
			]
		);

		$this->add_control(
			'xad_cookie_consent_expiry_days',
			[
				'label'       => __( 'Expiry Days', 'exclusive-addons-elementor-pro' ),
				'description' => __( 'Pass -1 for no expiry', 'exclusive-addons-elementor-pro' ),
				'type'        => Controls_Manager::SLIDER,
				'default'     => [
					'size'    => 3
				],
				'range'       => [
					'px'      => [
						'min' => -1,
						'max' => 1000
					]
				]
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
            'exad_cookie_consent_container_style',
            [
				'label' => esc_html__( 'Container', 'exclusive-addons-elementor-pro' ),
				'tab'   => Controls_Manager::TAB_STYLE
            ]
        );	

        $this->add_control(
			'exad_cookie_consent_container_width',
			[
				'label'        => __( 'Width', 'exclusive-addons-elementor-pro' ),
				'type'         => Controls_Manager::SLIDER,
				'size_units'   => [ 'px', '%' ],
				'range'        => [
					'px'       => [
						'min'  => 150,
						'max'  => 1000,
						'step' => 5
					],
					'%'        => [
						'min'  => 10,
						'max'  => 100
					]
				],
				'default'      => [
					'unit'     => 'px',
					'size'     => 350
				],
				'selectors'    => [
					'body .cc-window.cc-bottom.cc-left, body .cc-window.cc-bottom.cc-right,body .cc-window.cc-left.cc-center,body .cc-window.cc-right.cc-center' => 'width: {{SIZE}}{{UNIT}};'
				],
				'condition'    => [
					'exad_cookie_consent_position' => [ 'bottom-left', 'bottom-right', 'left-center', 'right-center' ]
				]
			]
		);

        $this->add_responsive_control(
            'exad_cookie_consent_container_padding',
            [
				'label'        => esc_html__( 'Padding', 'exclusive-addons-elementor-pro' ),
				'type'         => Controls_Manager::DIMENSIONS,            
				'size_units'   => [ 'px', 'em', '%' ],
				'default'      => [
					'top'      => '20',
					'right'    => '30',
					'bottom'   => '20',
					'left'     => '30',
					'unit'     => 'px',
					'isLinked' => false
				],
                'selectors'    => [
                    'body .cc-window' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
		);
		
        $this->add_responsive_control(
            'exad_cookie_consent_container_margin',
            [
				'label'        => esc_html__( 'Margin', 'exclusive-addons-elementor-pro' ),
				'type'         => Controls_Manager::DIMENSIONS,            
				'size_units'   => [ 'px', 'em', '%' ],
				'default'      => [
					'top'      => '0',
					'right'    => '0',
					'bottom'   => '0',
					'left'     => '0',
					'unit'     => 'px',
					'isLinked' => false
				],
                'selectors'    => [
                    'body .cc-window' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'  => 'exad_cookie_consent_container_bg_color',
				'types' => [ 'classic', 'gradient' ],
				'fields_options'  => [
					'background'  => [
						'default' => 'classic'
					],
					'color'       => [
						'default' => $exad_primary_color
					]
				],
				'selector' => 'body .cc-window'
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'exad_cookie_consent_container_border',
				'selector' => 'body .cc-window'
			]
		);

		$this->add_responsive_control(
            'exad_cookie_consent_container_border_radius',
            [
				'label'        => esc_html__( 'Border Radius', 'exclusive-addons-elementor-pro' ),
				'type'         => Controls_Manager::DIMENSIONS,            
				'size_units'   => [ 'px', 'em', '%' ],
				'default'      => [
					'top'      => '0',
					'right'    => '0',
					'bottom'   => '0',
					'left'     => '0',
					'unit'     => 'px',
					'isLinked' => true
				],
                'selectors'    => [
                    'body .cc-window' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
		);
		
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'exad_cookie_consent_container_border_radius',
				'selector' => 'body .cc-window'
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
            'exad_cookie_consent_content_style',
            [
				'label' => esc_html__( 'Content', 'exclusive-addons-elementor-pro' ),
				'tab'   => Controls_Manager::TAB_STYLE
            ]
		);	
		
		$this->add_responsive_control(
			'exad_cookie_consent_content_alignment',
			[
				'label'         => esc_html__( 'Alignment', 'exclusive-addons-elementor-pro' ),
				'type'          => Controls_Manager::CHOOSE,
				'label_block'   => true,
				'toggle'        => false,
				'default'       => 'left',
				'options'       => [
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
				'selectors'     => [
					'body .cc-window.cc-bottom.cc-left, body .cc-window.cc-bottom.cc-right, body .cc-window.cc-right.cc-center, body .cc-window.cc-left.cc-center' => 'text-align: {{VALUE}};'
				],
				'condition'    => [
					'exad_cookie_consent_position' => [ 'bottom-left', 'bottom-right', 'left-center', 'right-center' ]
				]
			]
		);

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
				'name'     => 'exad_cookie_consent_content_typography',
				'selector' => 'body .cc-message'
            ]
        );

        $this->add_control(
			'exad_cookie_consent_content_color',
			[
				'label'     => __( 'Color', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'default'	=> '#ffffff',
				'selectors' => [
					'body .cc-message' => 'color: {{VALUE}};'
				]
			]
		);

		$this->add_responsive_control(
			'exad_cookie_consent_content_margin',
			[
				'label'        => __( 'Margin', 'exclusive-addons-elementor-pro' ),
				'type'         => Controls_Manager::DIMENSIONS,
				'size_units'   => [ 'px', '%', 'em' ],
				'selectors'    => [
					'body .cc-message' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
            'exad_cookie_consent_read_more_button_style',
            [
				'label' => esc_html__( 'Read More Button', 'exclusive-addons-elementor-pro' ),
				'tab'   => Controls_Manager::TAB_STYLE
            ]
		);	

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
				'name'     => 'exad_cookie_consent_read_more_button_typography',
				'selector' => 'body .cc-window .cc-link',
				'fields_options'  => [
		            'font_weight' => [
		                'default' => '600'
		            ],
		            'text_decoration' => [
		                'default' => 'underline'
		            ]
	            ]


            ]
        );

        $this->add_responsive_control(
			'exad_cookie_consent_read_more_button_border_radius',
			[
				'label'      => __( 'Border Radius', 'exclusive-addons-elementor-pro' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'body .cc-window .cc-link' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
		);

		$this->add_responsive_control(
			'exad_cookie_consent_read_more_button_padding',
			[
				'label'      => __( 'Padding', 'exclusive-addons-elementor-pro' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'body .cc-window .cc-link' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
		);

		$this->add_responsive_control(
			'exad_cookie_consent_read_more_button_margin',
			[
				'label'        => __( 'Margin', 'exclusive-addons-elementor-pro' ),
				'type'         => Controls_Manager::DIMENSIONS,
				'size_units'   => [ 'px', '%', 'em' ],
				'default'      => [
					'top'      => '0',
					'right'    => '0',
					'bottom'   => '0',
					'left'     => '5',
					'isLinked' => false
				],
				'selectors'    => [
					'body .cc-window .cc-link' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
		);

		$this->start_controls_tabs( 'exad_cookie_consent_read_more_button_tabs' );

			// Normal State Tab
			$this->start_controls_tab( 'exad_cookie_consent_read_more_button_normal', [ 'label' => esc_html__( 'Normal', 'exclusive-addons-elementor-pro' ) ] );

			$this->add_control(
				'exad_cookie_consent_read_more_button_normal_text_color',
				[
					'label'     => esc_html__( 'Text Color', 'exclusive-addons-elementor-pro' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => '#ffffff',
					'selectors' => [
						'body .cc-window .cc-link' => 'color: {{VALUE}};'
					]
				]
			);

			$this->add_control(
				'exad_cookie_consent_read_more_button_normal_bg_color',
				[
					'label'     => esc_html__( 'Background Color', 'exclusive-addons-elementor-pro' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'body .cc-window .cc-link' => 'background-color: {{VALUE}};'
					]
				]
			);

			$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name'            => 'exad_cookie_consent_read_more_button_normal_border',
					'selector'        => 'body .cc-window .cc-link'
				]
			);

			$this->add_group_control(
				Group_Control_Box_Shadow::get_type(),
				[
					'name'     => 'exad_cookie_consent_read_more_button_box_shadow',
					'selector' => 'body .cc-window .cc-link'
				]
			);

			$this->end_controls_tab();

			// Hover State Tab
			$this->start_controls_tab( 'exad_cookie_consent_read_more_button_hover', [ 'label' => esc_html__( 'Hover', 'exclusive-addons-elementor-pro' ) ] );

			$this->add_control(
				'exad_cookie_consent_read_more_button_hover_text_color',
				[
					'label'     => esc_html__( 'Text Color', 'exclusive-addons-elementor-pro' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'body .cc-window .cc-link:hover' => 'color: {{VALUE}};'
					]
				]
			);

			$this->add_control(
				'exad_cookie_consent_read_more_button_hover_bg_color',
				[
					'label'     => esc_html__( 'Background Color', 'exclusive-addons-elementor-pro' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'body .cc-window .cc-link:hover' => 'background-color: {{VALUE}};'
					]
				]
			);

			$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name'            => 'exad_cookie_consent_read_more_button_hover_border',
					'selector'        => 'body .cc-window .cc-link:hover'
				]
			);

			$this->add_group_control(
				Group_Control_Box_Shadow::get_type(),
				[
					'name'     => 'exad_cookie_consent_read_more_button_box_shadow_hover',
					'selector' => 'body .cc-window .cc-link:hover'
				]
			);

			$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		$this->start_controls_section(
            'exad_cookie_consent_button_style',
            [
				'label' => esc_html__( 'Cookie Button', 'exclusive-addons-elementor-pro' ),
				'tab'   => Controls_Manager::TAB_STYLE
            ]
		);	
		
		$this->add_responsive_control(
			'exad_cookie_consent_button_alignment',
			[
				'label'         => esc_html__( 'Alignment', 'exclusive-addons-elementor-pro' ),
				'type'          => Controls_Manager::CHOOSE,
				'label_block'   => true,
				'toggle'        => false,
				'default'       => 'flex-start',
				'options'       => [
					'flex-start'      => [
						'title' => esc_html__( 'Left', 'exclusive-addons-elementor-pro' ),
						'icon'  => 'eicon-text-align-left'
					],
					'center'    => [
						'title' => esc_html__( 'Center', 'exclusive-addons-elementor-pro' ),
						'icon'  => 'eicon-text-align-center'
					],
					'flex-end'     => [
						'title' => esc_html__( 'Right', 'exclusive-addons-elementor-pro' ),
						'icon'  => 'eicon-text-align-right'
					]
				],
				'selectors'     => [
					'body .cc-window.cc-bottom.cc-left, body .cc-window.cc-bottom.cc-right, body .cc-window.cc-right.cc-center, body .cc-window.cc-left.cc-center' => 'align-items: {{VALUE}};',
				],
				'condition'    => [
					'exad_cookie_consent_position' => [ 'bottom-left', 'bottom-right', 'left-center', 'right-center' ]
				]
			]
		);

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
				'name'     => 'exad_cookie_consent_button_typography',
				'selector' => 'body .cc-btn.cc-dismiss'
            ]
        );

        $this->add_responsive_control(
			'exad_cookie_consent_button_border_radius',
			[
				'label'      => __( 'Border Radius', 'exclusive-addons-elementor-pro' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'default'    => [
					'top'    => '4',
					'right'  => '4',
					'bottom' => '4',
					'left'   => '4'
				],
				'selectors'  => [
					'body .cc-btn.cc-dismiss' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
		);

		$this->add_responsive_control(
			'exad_cookie_consent_button_padding',
			[
				'label'      => __( 'Padding', 'exclusive-addons-elementor-pro' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'default'    => [
					'top'      => '6',
					'right'    => '25',
					'bottom'   => '6',
					'left'     => '25',
					'isLinked' => false
				],
				'selectors'  => [
					'body .cc-btn.cc-dismiss' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
		);

		$this->add_responsive_control(
			'exad_cookie_consent_button_margin',
			[
				'label'        => __( 'Margin', 'exclusive-addons-elementor-pro' ),
				'type'         => Controls_Manager::DIMENSIONS,
				'size_units'   => [ 'px', '%', 'em' ],
				'selectors'    => [
					'body .cc-btn.cc-dismiss' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
		);

		$this->start_controls_tabs( 'exad_cookie_consent_button_tabs' );

			// Normal State Tab
			$this->start_controls_tab( 'exad_cookie_consent_button_normal', [ 'label' => esc_html__( 'Normal', 'exclusive-addons-elementor-pro' ) ] );

			$this->add_control(
				'exad_cookie_consent_button_normal_text_color',
				[
					'label'     => esc_html__( 'Text Color', 'exclusive-addons-elementor-pro' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => '#ffffff',
					'selectors' => [
						'body .cc-btn.cc-dismiss' => 'color: {{VALUE}};'
					]
				]
			);

			$this->add_control(
				'exad_cookie_consent_button_normal_bg_color',
				[
					'label'     => esc_html__( 'Background Color', 'exclusive-addons-elementor-pro' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => '#42C3AF',
					'selectors' => [
						'body .cc-btn.cc-dismiss' => 'background-color: {{VALUE}};'
					]
				]
			);

			$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name'            => 'exad_cookie_consent_button_normal_border',
					'fields_options'  => [
						'border'      => [
							'default' => 'solid'
                    	],
	                    'width'       => [
	                        'default' => [
	                            'top'    => '1',
	                            'right'  => '1',
	                            'bottom' => '1',
	                            'left'   => '1'
	                        ]
	                    ],
	                    'color'       => [
	                        'default' => '#42C3AF'
	                    ]
	                ],
					'selector'        => 'body .cc-btn.cc-dismiss'
				]
			);

			$this->add_group_control(
				Group_Control_Box_Shadow::get_type(),
				[
					'name'     => 'exad_cookie_consent_button_box_shadow',
					'selector' => 'body .cc-btn.cc-dismiss'
				]
			);

			$this->end_controls_tab();

			// Hover State Tab
			$this->start_controls_tab( 'exad_cookie_consent_button_hover', [ 'label' => esc_html__( 'Hover', 'exclusive-addons-elementor-pro' ) ] );

			$this->add_control(
				'exad_cookie_consent_button_hover_text_color',
				[
					'label'     => esc_html__( 'Text Color', 'exclusive-addons-elementor-pro' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'body .cc-btn.cc-dismiss:hover' => 'color: {{VALUE}};'
					]
				]
			);

			$this->add_control(
				'exad_cookie_consent_button_hover_bg_color',
				[
					'label'     => esc_html__( 'Background Color', 'exclusive-addons-elementor-pro' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'body .cc-btn.cc-dismiss:hover' => 'background-color: {{VALUE}};'
					]
				]
			);

			$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name'            => 'exad_cookie_consent_button_hover_border',
					'selector'        => 'body .cc-btn.cc-dismiss:hover'
				]
			);

			$this->add_group_control(
				Group_Control_Box_Shadow::get_type(),
				[
					'name'     => 'exad_cookie_consent_button_box_shadow_hover',
					'selector' => 'body .cc-btn.cc-dismiss:hover'
				]
			);

			$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

	}

	protected function render() {

		$settings = $this->get_settings_for_display();

		$cc_position = $settings['exad_cookie_consent_position'];

		if ( 'bottom-left' === $cc_position ) :
			$cc_position = 'cc-bottom cc-left';
		elseif ( 'bottom-right' === $cc_position ) :
			$cc_position = 'cc-bottom cc-right';
		elseif ( 'left-center' === $cc_position ) :
			$cc_position = 'cc-left cc-center';
		elseif ( 'right-center' === $cc_position ) :
			$cc_position = 'cc-right cc-center';
		elseif ( 'top' === $cc_position ) :
			$cc_position = 'cc-top cc-banner';
		elseif ( 'bottom' === $cc_position ) :
			$cc_position = 'cc-bottom cc-banner';
		endif;

		$this->add_render_attribute( 'cookie-consent', 'class', [ 'exad-cookie-consent' ] );

		$this->add_render_attribute(
			[
				'cookie-consent' => [
					'data-settings' => [
						wp_json_encode( [
							'position' => $settings['exad_cookie_consent_position'],
							'content' => [
								'message' => $settings['exad_cookie_consent_message'],
								'dismiss' => $settings['exad_cookie_consent_button_text'],
								'link'    => $settings['exad_cookie_consent_read_more_text'],
								'href'    => esc_url( $settings['exad_cookie_consent_read_more_link']['url'] )
						  	],
						  	'cookie' => [
								'name'		=> 'exad_cookie_widget',
								'domain'	=> ProHelper::get_site_domain(),
								'expiryDays'=> esc_attr( $settings['xad_cookie_consent_expiry_days']['size'] )
						  	]
				        ] )
					]
				]
			]
		);
		
		if ( \Elementor\Plugin::$instance->editor->is_edit_mode() ) : ?>

			<div role="dialog" aria-live="polite" aria-label="cookieconsent" aria-describedby="cookieconsent:desc" class="cc-window <?php echo esc_attr( $cc_position ); ?> cc-type-info cc-banner cc-theme-block">

				<span id="cookieconsent:desc" class="cc-message"><?php echo wp_kses_post( $settings['exad_cookie_consent_message'] ); ?><a aria-label="learn more about cookies" role="button" tabindex="0" class="cc-link" href="<?php echo esc_url( $settings['exad_cookie_consent_read_more_link']['url'] ); ?>" rel="noopener noreferrer nofollow" target="_blank"><?php echo esc_html( $settings['exad_cookie_consent_read_more_text'] ); ?></a></span>
				<div class="cc-compliance">
					<a aria-label="dismiss cookie message" role="button" tabindex="0" class="cc-btn cc-dismiss"><?php echo esc_html( $settings['exad_cookie_consent_button_text'] ); ?></a>
				</div>

			</div>

	    <?php else : ?>

			<div <?php echo $this->get_render_attribute_string( 'cookie-consent' ); ?>></div>

		<?php endif;

	}
}