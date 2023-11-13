<?php
namespace ExclusiveAddons\Elements;

if ( ! defined( 'ABSPATH' ) ) exit;

use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Border;
use \Elementor\Group_Control_Typography;
use \Elementor\Widget_Base;
use \Elementor\Icons_Manager;
use \Elementor\Group_Control_Box_Shadow;

class Social_Share extends Widget_Base {
    
    public function get_name() {
        return 'exad-social-share';
    }

    public function get_title() {
        return __( 'Social Share', 'exclusive-addons-elementor-pro' );
    }

    public function get_icon() {
        return 'exad exad-logo exad-social-share';
    }

    public function get_categories() {
        return [ 'exclusive-addons-elementor' ];
    }

    public function get_keywords() {
	    return [ 'link', 'media', 'sharing' ];
	}

    protected function register_controls() {

        $exad_primary_color = get_option( 'exad_primary_color_option', '#7a56ff' );
        
        /**
         * -------------------------------------------
         * social share style tab
         * -------------------------------------------
         */
        $this->start_controls_section(
            'social_share_icon_general_style_section',
            [
                'label' => __( 'General', 'exclusive-addons-elementor-pro' )
            ]
        );      

        $this->add_control(
            'social_share_icon_display_type',
            [
                'label'          => __( 'Skin Type', 'exclusive-addons-elementor-pro' ),
                'type'           => Controls_Manager::SELECT,
                'default'        => 'horizontal',
                'options'        => [
                    'horizontal' => __( 'Horizontal',   'exclusive-addons-elementor-pro' ),
                    'vertical'   => __( 'Vertical', 'exclusive-addons-elementor-pro' )
                ]
            ]
        );

        $this->add_control(
            'enable_label',
            [
                'label'        => __( 'Enable Label?', 'exclusive-addons-elementor-pro' ),
                'type'         => Controls_Manager::SWITCHER,
                'default'      => 'yes',
                'return_value' => 'yes'
            ]
        ); 

        $this->add_control(
            'social_share_icon_open_tab',
            [
                'label'          => __( 'Open In', 'exclusive-addons-elementor-pro' ),
                'type'           => Controls_Manager::SELECT,
                'default'        => 'new-tab',
                'options'        => [
                    'new-tab'    => __( 'New Tab',   'exclusive-addons-elementor-pro' ),
                    'same-tab'   => __( 'Same Tab', 'exclusive-addons-elementor-pro' )
                ]
            ]
        );

        $this->add_control(
            'social_share_facebook_heading',
            [
                'label'         => __( 'Facebook', 'exclusive-addons-elementor-pro' ),
                'type'          => Controls_Manager::HEADING,
                'separator'     => 'before'
            ]
        );

        $this->add_control(
            'enable_facebook',
            [
                'label'        => __( 'Enable?', 'exclusive-addons-elementor-pro' ),
                'type'         => Controls_Manager::SWITCHER,
                'default'      => 'yes',
                'return_value' => 'yes'
            ]
        ); 

        $this->add_control(
            'social_share_facebook_icon',
            [
                'label'       => __( 'Icon', 'exclusive-addons-elementor-pro' ),
                'type'        => Controls_Manager::ICONS,
                'default'     => [
                    'value'   => 'fab fa-facebook-f',
                    'library' => 'fa-brands'
                ],
                'condition'   => [
                    'enable_facebook' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'social_share_facebook_label',
            [
                'label'       => __( 'Label', 'exclusive-addons-elementor-pro' ),
                'type'        => Controls_Manager::TEXT,
                'default'     => __( 'Facebook', 'exclusive-addons-elementor-pro' ),
                'condition'   => [
                    'enable_facebook' => 'yes',
                    'enable_label' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'social_share_twitter_heading',
            [
                'label'         => __( 'Twitter', 'exclusive-addons-elementor-pro' ),
                'type'          => Controls_Manager::HEADING,
                'separator'     => 'before'
            ]
        );

        $this->add_control(
            'enable_twitter',
            [
                'label'        => __( 'Enable?', 'exclusive-addons-elementor-pro' ),
                'type'         => Controls_Manager::SWITCHER,
                'default'      => 'yes',
                'return_value' => 'yes'
            ]
        );

        $this->add_control(
            'social_share_twitter_icon',
            [
                'label'       => __( 'Icon', 'exclusive-addons-elementor-pro' ),
                'type'        => Controls_Manager::ICONS,
                'default'     => [
                    'value'   => 'fab fa-twitter',
                    'library' => 'fa-brands'
                ],
                'condition'   => [
                    'enable_twitter' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'social_share_twitter_label',
            [
                'label'       => __( 'Label', 'exclusive-addons-elementor-pro' ),
                'type'        => Controls_Manager::TEXT,
                'default'     => __( 'Twitter', 'exclusive-addons-elementor-pro' ),
                'condition'   => [
                    'enable_twitter' => 'yes',
                    'enable_label' => 'yes'
                ]
            ]
        ); 

        $this->add_control(
            'social_share_pinterest_heading',
            [
                'label'         => __( 'Pinterest', 'exclusive-addons-elementor-pro' ),
                'type'          => Controls_Manager::HEADING,
                'separator'     => 'before'
            ]
        );

        $this->add_control(
            'enable_pinterest',
            [
                'label'        => __( 'Enable?', 'exclusive-addons-elementor-pro' ),
                'type'         => Controls_Manager::SWITCHER,
                'default'      => 'yes',
                'return_value' => 'yes'
            ]
        ); 

        $this->add_control(
            'social_share_pinterest_icon',
            [
                'label'       => __( 'Icon', 'exclusive-addons-elementor-pro' ),
                'type'        => Controls_Manager::ICONS,
                'default'     => [
                    'value'   => 'fab fa-pinterest',
                    'library' => 'fa-brands'
                ],
                'condition'   => [
                    'enable_pinterest' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'social_share_pinterest_label',
            [
                'label'       => __( 'Label', 'exclusive-addons-elementor-pro' ),
                'type'        => Controls_Manager::TEXT,
                'default'     => __( 'Pinterest', 'exclusive-addons-elementor-pro' ),
                'condition'   => [
                    'enable_pinterest' => 'yes',
                    'enable_label' => 'yes'
                ]
            ]
        ); 

        $this->add_control(
            'social_share_linkedin_heading',
            [
                'label'         => __( 'LinkedIn', 'exclusive-addons-elementor-pro' ),
                'type'          => Controls_Manager::HEADING,
                'separator'     => 'before'
            ]
        );

        $this->add_control(
            'enable_linkedin',
            [
                'label'        => __( 'Enable?', 'exclusive-addons-elementor-pro' ),
                'type'         => Controls_Manager::SWITCHER,
                'default'      => 'yes',
                'return_value' => 'yes'
            ]
        ); 

        $this->add_control(
            'social_share_linkedin_icon',
            [
                'label'       => __( 'Icon', 'exclusive-addons-elementor-pro' ),
                'type'        => Controls_Manager::ICONS,
                'default'     => [
                    'value'   => 'fab fa-linkedin-in',
                    'library' => 'fa-brands'
                ],
                'condition'   => [
                    'enable_linkedin' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'social_share_linkedin_label',
            [
                'label'       => __( 'Label', 'exclusive-addons-elementor-pro' ),
                'type'        => Controls_Manager::TEXT,
                'default'     => __( 'Linkedin', 'exclusive-addons-elementor-pro' ),
                'condition'   => [
                    'enable_linkedin' => 'yes',
                    'enable_label' => 'yes'
                ]
            ]
        ); 

        $this->add_control(
            'social_share_reddit_heading',
            [
                'label'         => __( 'Reddit', 'exclusive-addons-elementor-pro' ),
                'type'          => Controls_Manager::HEADING,
                'separator'     => 'before'
            ]
        );

        $this->add_control(
            'enable_reddit',
            [
                'label'        => __( 'Enable?', 'exclusive-addons-elementor-pro' ),
                'type'         => Controls_Manager::SWITCHER,
                'default'      => 'yes',
                'return_value' => 'yes'
            ]
        );

        $this->add_control(
            'social_share_reddit_icon',
            [
                'label'       => __( 'Icon', 'exclusive-addons-elementor-pro' ),
                'type'        => Controls_Manager::ICONS,
                'default'     => [
                    'value'   => 'fab fa-reddit-alien',
                    'library' => 'fa-brands'
                ],
                'condition'   => [
                    'enable_reddit' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'social_share_reddit_label',
            [
                'label'       => __( 'Label', 'exclusive-addons-elementor-pro' ),
                'type'        => Controls_Manager::TEXT,
                'default'     => __( 'Reddit', 'exclusive-addons-elementor-pro' ),
                'condition'   => [
                    'enable_reddit' => 'yes',
                    'enable_label' => 'yes'
                ]
            ]
        );

        $this->end_controls_section(); 

        $this->start_controls_section(
            'social_share_icon_general_style',
            [
                'label'         => __('General', 'exclusive-addons-elementor-pro'),
                'tab'           => Controls_Manager::TAB_STYLE
            ]
        );      

        $this->add_control(
			'social_share_icon_alignment',
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
                'default' => 'center',
                'selectors'      => [
                    '{{WRAPPER}} .exad-social-share-icons' => 'justify-content: {{VALUE}}'
                ],
                'condition' => [
                    'social_share_icon_display_type' => 'horizontal'
                ]
			]
        );
        
        $this->add_control(
            'enable_social_icon_box',
            [
                'label'        => __( 'Enable?', 'exclusive-addons-elementor-pro' ),
                'type'         => Controls_Manager::SWITCHER,
                'default'      => 'no',
                'return_value' => 'yes',
                'condition' => [
                    'enable_label!' => 'yes'
                ]
            ]
        );

        $this->add_responsive_control(
			'enable_social_icon_width',
			[
				'label' => __( 'Width', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 200,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 50,
				],
				'selectors' => [
					'{{WRAPPER}} .exad-social-share-icons.exad-social-share-box-yes a' => 'width: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'enable_social_icon_box' => 'yes',
                    'enable_label!' => 'yes'
                ]
			]
        );
        
        $this->add_responsive_control(
			'enable_social_icon_height',
			[
				'label' => __( 'Height', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 200,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 50,
				],
				'selectors' => [
					'{{WRAPPER}} .exad-social-share-icons.exad-social-share-box-yes a' => 'height: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'enable_social_icon_box' => 'yes',
                    'enable_label!' => 'yes'
                ]
			]
		);

        $this->add_responsive_control(
            'social_share_icon_spacing',
            [
                'label'          => __( 'Icon Spacing', 'exclusive-addons-elementor-pro'),
                'type'           => Controls_Manager::SLIDER,
                'size_units'     => [ 'px' ],
                'range'          => [
                    'px'         => [
                        'min'    => 0,
                        'max'    => 50
                    ]
                ],
                'default'        => [
                    'unit'       => 'px',
                    'size'       => 10
                ],
                'selectors'      => [
                    '{{WRAPPER}} .exad-social-share-icons i' => 'margin-right: {{SIZE}}{{UNIT}}',
                    '{{WRAPPER}} .exad-social-share-icons svg' => 'margin-right: {{SIZE}}{{UNIT}}'
                ]
            ]
        );

        $this->add_responsive_control(
            'social_share_icon_size',
            [
                'label'          => __( 'Icon size', 'exclusive-addons-elementor-pro'),
                'type'           => Controls_Manager::SLIDER,
                'size_units'     => [ 'px' ],
                'range'          => [
                    'px'         => [
                        'min'    => 0,
                        'max'    => 50
                    ]
                ],
                'default'        => [
                    'unit'       => 'px',
                    'size'       => 18
                ],
                'selectors'      => [
                    '{{WRAPPER}} .exad-social-share-icons i' => 'font-size: {{SIZE}}{{UNIT}}',
                    '{{WRAPPER}} .exad-social-share-icons svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};'
                ]
            ]
        );


        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'social_share_icon_typography',
                'selector' => '{{WRAPPER}} .exad-social-share-icons a'
            ]
        );

        $this->add_responsive_control(
            'social_share_icon_margin',
            [
                'label'         => __( 'Margin', 'exclusive-addons-elementor-pro' ),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => [ 'px' ],
                'default'       => [
                    'top'       => '20',
                    'right'     => '10',
                    'bottom'    => '10',
                    'left'      => '0',
                    'unit'      => 'px',
                    'isLinked'  => false
                ],
                'selectors'     => [
                    '{{WRAPPER}} .exad-social-share-icons a' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->add_responsive_control(
            'social_share_icon_padding',
            [
                'label'         => __( 'Padding', 'exclusive-addons-elementor-pro' ),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => [ 'px' ],
                'default'       => [
                    'top'       => '10',
                    'right'     => '20',
                    'bottom'    => '10',
                    'left'      => '20',
                    'unit'      => 'px',
                    'isLinked'  => false
                ],
                'selectors'     => [
                    '{{WRAPPER}} .exad-social-share-icons a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->add_responsive_control(
            'social_share_icon_border_radius',
            [
                'label'        => esc_html__( 'Border Radius', 'exclusive-addons-elementor-pro' ),
                'type'         => Controls_Manager::DIMENSIONS,            
                'size_units'   => [ 'px', 'em' ],
                'selectors'    => [
                    '{{WRAPPER}} .exad-social-share-icons a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );      

        $this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'social_share_icon_shadow',
				'label' => __( 'Box Shadow', 'exclusive-addons-elementor-pro' ),
				'selector' => '{{WRAPPER}} .exad-social-share-icons a',
			]
		);

        $this->end_controls_section();   

        $this->start_controls_section(
            'social_share_icon_individual_section',
            [
                'label'         => __('Individual Style', 'exclusive-addons-elementor-pro'),
                'tab'           => Controls_Manager::TAB_STYLE
            ]
        ); 

        $this->add_control(
            'social_share_facebook_style',
            [
                'label'         => __( 'Facebook', 'exclusive-addons-elementor-pro' ),
                'type'          => Controls_Manager::HEADING,
                'separator'     => 'before',
                'condition'   => [
                    'enable_facebook' => 'yes'
                ]
            ]
        );

        $this->start_controls_tabs( 'social_share_facebook_tabs' );
			// Normal State Tab
			$this->start_controls_tab( 'social_share_facebook_normal', [ 'label' => esc_html__( 'Normal', 'exclusive-addons-elementor-pro' ) ] );

                $this->add_control(
                    'social_share_facebook_color_normal',
                    [
                        'label'     => esc_html__( 'Text & Icon Color', 'exclusive-addons-elementor-pro' ),
                        'type'      => Controls_Manager::COLOR,
                        'default'   => '#ffffff',
                        'selectors' => [
                            '{{WRAPPER}} .exad-social-share-icons .exad-facebook-social-icon a' => 'color: {{VALUE}};',
                            '{{WRAPPER}} .exad-social-share-icons .exad-facebook-social-icon a svg path' => 'fill: {{VALUE}};'
                        ],
                        'condition'   => [
                            'enable_facebook' => 'yes'
                        ]
                    ]
                );

                $this->add_control(
                    'social_share_facebook_bg_color_normal',
                    [
                        'label'     => esc_html__( 'Background Color', 'exclusive-addons-elementor-pro' ),
                        'type'      => Controls_Manager::COLOR,
                        'default'   => '#3B5998',
                        'selectors' => [
                            '{{WRAPPER}} .exad-social-share-icons .exad-facebook-social-icon a' => 'background-color: {{VALUE}};'
                        ],
                        'condition'   => [
                            'enable_facebook' => 'yes'
                        ]
                    ]
                );

                $this->add_group_control(
                    Group_Control_Border::get_type(),
                    [
                        'name' => 'social_share_facebook_border_normal',
                        'label' => __( 'Border', 'exclusive-addons-elementor-pro' ),
                        'selector' => '{{WRAPPER}} .exad-social-share-icons .exad-facebook-social-icon a',
                        'condition'   => [
                            'enable_facebook' => 'yes'
                        ]
                    ]
                );

                $this->add_group_control(
                    Group_Control_Box_Shadow::get_type(),
                    [
                        'name' => 'social_share_facebook_shadow_normal',
                        'label' => __( 'Box Shadow', 'exclusive-addons-elementor-pro' ),
                        'selector' => '{{WRAPPER}} .exad-social-share-icons .exad-facebook-social-icon a',
                    ]
                );

            $this->end_controls_tab();

            // Hover State Tab
            $this->start_controls_tab( 'social_share_facebook_hover', [ 'label' => esc_html__( 'Hover', 'exclusive-addons-elementor-pro' ) ] );

                $this->add_control(
                    'social_share_facebook_color_hover',
                    [
                        'label'     => esc_html__( 'Color', 'exclusive-addons-elementor-pro' ),
                        'type'      => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .exad-social-share-icons .exad-facebook-social-icon a:hover' => 'color: {{VALUE}};',
                            '{{WRAPPER}} .exad-social-share-icons .exad-facebook-social-icon a:hover svg path' => 'fill: {{VALUE}};'
                        ],
                        'condition'   => [
                            'enable_facebook' => 'yes'
                        ]
                    ]
                );

                $this->add_control(
                    'social_share_facebook_bg_color_hover',
                    [
                        'label'     => esc_html__( 'Background Color', 'exclusive-addons-elementor-pro' ),
                        'type'      => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .exad-social-share-icons .exad-facebook-social-icon a:hover' => 'background-color: {{VALUE}};'
                        ],
                        'condition'   => [
                            'enable_facebook' => 'yes'
                        ]
                    ]
                );

                $this->add_group_control(
                    Group_Control_Border::get_type(),
                    [
                        'name' => 'social_share_facebook_border_hover',
                        'label' => __( 'Border', 'exclusive-addons-elementor-pro' ),
                        'selector' => '{{WRAPPER}} .exad-social-share-icons .exad-facebook-social-icon a:hover',
                        'condition'   => [
                            'enable_facebook' => 'yes'
                        ]
                    ]
                );

                $this->add_group_control(
                    Group_Control_Box_Shadow::get_type(),
                    [
                        'name' => 'social_share_facebook_shadow_hover',
                        'label' => __( 'Box Shadow', 'exclusive-addons-elementor-pro' ),
                        'selector' => '{{WRAPPER}} .exad-social-share-icons .exad-facebook-social-icon a:hover',
                    ]
                );

            $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_control(
            'social_share_twitter_style',
            [
                'label'         => __( 'Twitter', 'exclusive-addons-elementor-pro' ),
                'type'          => Controls_Manager::HEADING,
                'separator'     => 'before',
                'condition'   => [
                    'enable_twitter' => 'yes'
                ]
            ]
        );

        $this->start_controls_tabs( 'social_share_twitter_tabs' );
			// Normal State Tab
			$this->start_controls_tab( 'social_share_twitter_normal', [ 'label' => esc_html__( 'Normal', 'exclusive-addons-elementor-pro' ) ] );

                $this->add_control(
                    'social_share_twitter_color_normal',
                    [
                        'label'     => esc_html__( 'Icon & Text Color', 'exclusive-addons-elementor-pro' ),
                        'type'      => Controls_Manager::COLOR,
                        'default'   => '#ffffff',
                        'selectors' => [
                            '{{WRAPPER}} .exad-social-share-icons .exad-twitter-social-icon a' => 'color: {{VALUE}};',
                            '{{WRAPPER}} .exad-social-share-icons .exad-twitter-social-icon a svg path' => 'fill: {{VALUE}};'
                        ],
                        'condition'   => [
                            'enable_twitter' => 'yes'
                        ]
                    ]
                );

                $this->add_control(
                    'social_share_twitter_bg_color_normal',
                    [
                        'label'     => esc_html__( 'Background Color', 'exclusive-addons-elementor-pro' ),
                        'type'      => Controls_Manager::COLOR,
                        'default'   => '#55ACEE',
                        'selectors' => [
                            '{{WRAPPER}} .exad-social-share-icons .exad-twitter-social-icon a' => 'background-color: {{VALUE}};'
                        ],
                        'condition'   => [
                            'enable_twitter' => 'yes'
                        ]
                    ]
                );

                $this->add_group_control(
                    Group_Control_Border::get_type(),
                    [
                        'name' => 'social_share_twitter_border_normal',
                        'label' => __( 'Border', 'exclusive-addons-elementor-pro' ),
                        'selector' => '{{WRAPPER}} .exad-social-share-icons .exad-twitter-social-icon a',
                        'condition'   => [
                            'enable_twitter' => 'yes'
                        ]
                    ]
                );

                $this->add_group_control(
                    Group_Control_Box_Shadow::get_type(),
                    [
                        'name' => 'social_share_twitter_shadow_normal',
                        'label' => __( 'Box Shadow', 'exclusive-addons-elementor-pro' ),
                        'selector' => '{{WRAPPER}} .exad-social-share-icons .exad-twitter-social-icon a',
                    ]
                );

            $this->end_controls_tab();

            // Hover State Tab
            $this->start_controls_tab( 'social_share_twitter_hover', [ 'label' => esc_html__( 'Hover', 'exclusive-addons-elementor-pro' ) ] );

                $this->add_control(
                    'social_share_twitter_color_hover',
                    [
                        'label'     => esc_html__( 'Icon & Text Color', 'exclusive-addons-elementor-pro' ),
                        'type'      => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .exad-social-share-icons .exad-twitter-social-icon a:hover' => 'color: {{VALUE}};',
                            '{{WRAPPER}} .exad-social-share-icons .exad-twitter-social-icon a:hover svg path' => 'fill: {{VALUE}};'
                        ],
                        'condition'   => [
                            'enable_twitter' => 'yes'
                        ]
                    ]
                );

                $this->add_control(
                    'social_share_twitter_bg_color_hover',
                    [
                        'label'     => esc_html__( 'Background Color', 'exclusive-addons-elementor-pro' ),
                        'type'      => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .exad-social-share-icons .exad-twitter-social-icon a:hover' => 'background-color: {{VALUE}};'
                        ],
                        'condition'   => [
                            'enable_twitter' => 'yes'
                        ]
                    ]
                );

                $this->add_group_control(
                    Group_Control_Border::get_type(),
                    [
                        'name' => 'social_share_twitter_border_hover',
                        'label' => __( 'Border', 'exclusive-addons-elementor-pro' ),
                        'selector' => '{{WRAPPER}} .exad-social-share-icons .exad-twitter-social-icon a:hover',
                        'condition'   => [
                            'enable_twitter' => 'yes'
                        ]
                    ]
                );

                $this->add_group_control(
                    Group_Control_Box_Shadow::get_type(),
                    [
                        'name' => 'social_share_twitter_shadow_hover',
                        'label' => __( 'Box Shadow', 'exclusive-addons-elementor-pro' ),
                        'selector' => '{{WRAPPER}} .exad-social-share-icons .exad-twitter-social-icon a:hover',
                    ]
                );

            $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_control(
            'social_share_pinterest_style',
            [
                'label'         => __( 'Pinterest', 'exclusive-addons-elementor-pro' ),
                'type'          => Controls_Manager::HEADING,
                'separator'     => 'before',
                'condition'   => [
                    'enable_pinterest' => 'yes'
                ]
            ]
        );

        $this->start_controls_tabs( 'social_share_pinterest_tabs' );
			// Normal State Tab
			$this->start_controls_tab( 'social_share_pinterest_normal', [ 'label' => esc_html__( 'Normal', 'exclusive-addons-elementor-pro' ) ] );

                $this->add_control(
                    'social_share_pinterest_color_normal',
                    [
                        'label'     => esc_html__( 'Icon & Text Color', 'exclusive-addons-elementor-pro' ),
                        'type'      => Controls_Manager::COLOR,
                        'default'   => '#ffffff',
                        'selectors' => [
                            '{{WRAPPER}} .exad-social-share-icons .exad-pinterest-social-icon a' => 'color: {{VALUE}};',
                            '{{WRAPPER}} .exad-social-share-icons .exad-pinterest-social-icon a svg path' => 'fill: {{VALUE}};'
                        ],
                        'condition'   => [
                            'enable_pinterest' => 'yes'
                        ]
                    ]
                );

                $this->add_control(
                    'social_share_pinterest_bg_color_normal',
                    [
                        'label'     => esc_html__( 'Background Color', 'exclusive-addons-elementor-pro' ),
                        'type'      => Controls_Manager::COLOR,
                        'default'   => '#cb2027',
                        'selectors' => [
                            '{{WRAPPER}} .exad-social-share-icons .exad-pinterest-social-icon a' => 'background-color: {{VALUE}};'
                        ],
                        'condition'   => [
                            'enable_pinterest' => 'yes'
                        ]
                    ]
                );

                $this->add_group_control(
                    Group_Control_Border::get_type(),
                    [
                        'name' => 'social_share_pinterest_border_normal',
                        'label' => __( 'Border', 'exclusive-addons-elementor-pro' ),
                        'selector' => '{{WRAPPER}} .exad-social-share-icons .exad-pinterest-social-icon a',
                        'condition'   => [
                            'enable_pinterest' => 'yes'
                        ]
                    ]
                );

                $this->add_group_control(
                    Group_Control_Box_Shadow::get_type(),
                    [
                        'name' => 'social_share_pinterest_shadow_normal',
                        'label' => __( 'Box Shadow', 'exclusive-addons-elementor-pro' ),
                        'selector' => '{{WRAPPER}} .exad-social-share-icons .exad-pinterest-social-icon a',
                    ]
                );

            $this->end_controls_tab();

            // Hover State Tab
            $this->start_controls_tab( 'social_share_pinterest_hover', [ 'label' => esc_html__( 'Hover', 'exclusive-addons-elementor-pro' ) ] );

                $this->add_control(
                    'social_share_pinterest_color_hover',
                    [
                        'label'     => esc_html__( 'Icon & Text Color', 'exclusive-addons-elementor-pro' ),
                        'type'      => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .exad-social-share-icons .exad-pinterest-social-icon a:hover' => 'color: {{VALUE}};',
                            '{{WRAPPER}} .exad-social-share-icons .exad-pinterest-social-icon a:hover svg path' => 'fill: {{VALUE}};'
                        ],
                        'condition'   => [
                            'enable_pinterest' => 'yes'
                        ]
                    ]
                );

                $this->add_control(
                    'social_share_pinterest_bg_color_hover',
                    [
                        'label'     => esc_html__( 'Background Color', 'exclusive-addons-elementor-pro' ),
                        'type'      => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .exad-social-share-icons .exad-pinterest-social-icon a:hover' => 'background-color: {{VALUE}};'
                        ],
                        'condition'   => [
                            'enable_pinterest' => 'yes'
                        ]
                    ]
                );

                $this->add_group_control(
                    Group_Control_Border::get_type(),
                    [
                        'name' => 'social_share_pinterest_border_hover',
                        'label' => __( 'Border', 'exclusive-addons-elementor-pro' ),
                        'selector' => '{{WRAPPER}} .exad-social-share-icons .exad-pinterest-social-icon a:hover',
                        'condition'   => [
                            'enable_pinterest' => 'yes'
                        ]
                    ]
                );

                $this->add_group_control(
                    Group_Control_Box_Shadow::get_type(),
                    [
                        'name' => 'social_share_pinterest_shadow_hover',
                        'label' => __( 'Box Shadow', 'exclusive-addons-elementor-pro' ),
                        'selector' => '{{WRAPPER}} .exad-social-share-icons .exad-pinterest-social-icon a:hover',
                    ]
                );

            $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_control(
            'social_share_linkedin_style',
            [
                'label'         => __( 'linkedin', 'exclusive-addons-elementor-pro' ),
                'type'          => Controls_Manager::HEADING,
                'separator'     => 'before',
                'condition'   => [
                    'enable_linkedin' => 'yes'
                ]
            ]
        );

        $this->start_controls_tabs( 'social_share_linkedin_tabs' );
			// Normal State Tab
			$this->start_controls_tab( 'social_share_linkedin_normal', [ 'label' => esc_html__( 'Normal', 'exclusive-addons-elementor-pro' ) ] );

                $this->add_control(
                    'social_share_linkedin_color_normal',
                    [
                        'label'     => esc_html__( 'Color', 'exclusive-addons-elementor-pro' ),
                        'type'      => Controls_Manager::COLOR,
                        'default'   => '#ffffff',
                        'selectors' => [
                            '{{WRAPPER}} .exad-social-share-icons .exad-linkedin-social-icon a' => 'color: {{VALUE}};',
                            '{{WRAPPER}} .exad-social-share-icons .exad-linkedin-social-icon a svg path' => 'fill: {{VALUE}};'
                        ],
                        'condition'   => [
                            'enable_linkedin' => 'yes'
                        ]
                    ]
                );

                $this->add_control(
                    'social_share_linkedin_bg_color_normal',
                    [
                        'label'     => esc_html__( 'Background Color', 'exclusive-addons-elementor-pro' ),
                        'type'      => Controls_Manager::COLOR,
                        'default'   => '#007bb5',
                        'selectors' => [
                            '{{WRAPPER}} .exad-social-share-icons .exad-linkedin-social-icon a' => 'background-color: {{VALUE}};'
                        ],
                        'condition'   => [
                            'enable_linkedin' => 'yes'
                        ]
                    ]
                );

                $this->add_group_control(
                    Group_Control_Border::get_type(),
                    [
                        'name' => 'social_share_linkedin_border_normal',
                        'label' => __( 'Border', 'exclusive-addons-elementor-pro' ),
                        'selector' => '{{WRAPPER}} .exad-social-share-icons .exad-linkedin-social-icon a',
                        'condition'   => [
                            'enable_linkedin' => 'yes'
                        ]
                    ]
                );

                $this->add_group_control(
                    Group_Control_Box_Shadow::get_type(),
                    [
                        'name' => 'social_share_linkedin_shadow_normal',
                        'label' => __( 'Box Shadow', 'exclusive-addons-elementor-pro' ),
                        'selector' => '{{WRAPPER}} .exad-social-share-icons .exad-linkedin-social-icon a',
                    ]
                );

            $this->end_controls_tab();

            // Hover State Tab
            $this->start_controls_tab( 'social_share_linkedin_hover', [ 'label' => esc_html__( 'Hover', 'exclusive-addons-elementor-pro' ) ] );

                $this->add_control(
                    'social_share_linkedin_color_hover',
                    [
                        'label'     => esc_html__( 'Color', 'exclusive-addons-elementor-pro' ),
                        'type'      => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .exad-social-share-icons .exad-linkedin-social-icon a:hover' => 'color: {{VALUE}};',
                            '{{WRAPPER}} .exad-social-share-icons .exad-linkedin-social-icon a:hover svg path' => 'fill: {{VALUE}};'
                        ],
                        'condition'   => [
                            'enable_linkedin' => 'yes'
                        ]
                    ]
                );

                $this->add_control(
                    'social_share_linkedin_bg_color_hover',
                    [
                        'label'     => esc_html__( 'Background Color', 'exclusive-addons-elementor-pro' ),
                        'type'      => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .exad-social-share-icons .exad-linkedin-social-icon a:hover' => 'background-color: {{VALUE}};'
                        ],
                        'condition'   => [
                            'enable_linkedin' => 'yes'
                        ]
                    ]
                );

                $this->add_group_control(
                    Group_Control_Border::get_type(),
                    [
                        'name' => 'social_share_linkedin_border_hover',
                        'label' => __( 'Border', 'exclusive-addons-elementor-pro' ),
                        'selector' => '{{WRAPPER}} .exad-social-share-icons .exad-linkedin-social-icon a:hover',
                        'condition'   => [
                            'enable_linkedin' => 'yes'
                        ]
                    ]
                );

                $this->add_group_control(
                    Group_Control_Box_Shadow::get_type(),
                    [
                        'name' => 'social_share_linkedin_shadow_hover',
                        'label' => __( 'Box Shadow', 'exclusive-addons-elementor-pro' ),
                        'selector' => '{{WRAPPER}} .exad-social-share-icons .exad-linkedin-social-icon a:hover',
                    ]
                );

            $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_control(
            'social_share_reddit_style',
            [
                'label'         => __( 'Reddit', 'exclusive-addons-elementor-pro' ),
                'type'          => Controls_Manager::HEADING,
                'separator'     => 'before',
                'condition'   => [
                    'enable_reddit' => 'yes'
                ]
            ]
        );

        $this->start_controls_tabs( 'social_share_reddit_tabs' );
			// Normal State Tab
			$this->start_controls_tab( 'social_share_reddit_normal', [ 'label' => esc_html__( 'Normal', 'exclusive-addons-elementor-pro' ) ] );

                $this->add_control(
                    'social_share_reddit_color_normal',
                    [
                        'label'     => esc_html__( 'Color', 'exclusive-addons-elementor-pro' ),
                        'type'      => Controls_Manager::COLOR,
                        'default'   => '#ffffff',
                        'selectors' => [
                            '{{WRAPPER}} .exad-social-share-icons .exad-reddit-social-icon a' => 'color: {{VALUE}};',
                            '{{WRAPPER}} .exad-social-share-icons .exad-reddit-social-icon a svg path' => 'fill: {{VALUE}};'
                        ],
                        'condition'   => [
                            'enable_reddit' => 'yes'
                        ]
                    ]
                );

                $this->add_control(
                    'social_share_reddit_bg_color_normal',
                    [
                        'label'     => esc_html__( 'Background Color', 'exclusive-addons-elementor-pro' ),
                        'type'      => Controls_Manager::COLOR,
                        'default'   => '#ff5700',
                        'selectors' => [
                            '{{WRAPPER}} .exad-social-share-icons .exad-reddit-social-icon a' => 'background-color: {{VALUE}};'
                        ],
                        'condition'   => [
                            'enable_reddit' => 'yes'
                        ]
                    ]
                );

                $this->add_group_control(
                    Group_Control_Border::get_type(),
                    [
                        'name' => 'social_share_reddit_border_normal',
                        'label' => __( 'Border', 'exclusive-addons-elementor-pro' ),
                        'selector' => '{{WRAPPER}} .exad-social-share-icons .exad-reddit-social-icon a',
                        'condition'   => [
                            'enable_reddit' => 'yes'
                        ]
                    ]
                );

                $this->add_group_control(
                    Group_Control_Box_Shadow::get_type(),
                    [
                        'name' => 'social_share_reddit_shadow_normal',
                        'label' => __( 'Box Shadow', 'exclusive-addons-elementor-pro' ),
                        'selector' => '{{WRAPPER}} .exad-social-share-icons .exad-reddit-social-icon a',
                    ]
                );

            $this->end_controls_tab();

            // Hover State Tab
            $this->start_controls_tab( 'social_share_reddit_hover', [ 'label' => esc_html__( 'Hover', 'exclusive-addons-elementor-pro' ) ] );

                $this->add_control(
                    'social_share_reddit_color_hover',
                    [
                        'label'     => esc_html__( 'Icon & Text Color', 'exclusive-addons-elementor-pro' ),
                        'type'      => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .exad-social-share-icons .exad-reddit-social-icon a:hover' => 'color: {{VALUE}};',
                            '{{WRAPPER}} .exad-social-share-icons .exad-reddit-social-icon a:hover svg path' => 'fill: {{VALUE}};'
                        ],
                        'condition'   => [
                            'enable_reddit' => 'yes'
                        ]
                    ]
                );

                $this->add_control(
                    'social_share_reddit_bg_color_hover',
                    [
                        'label'     => esc_html__( 'Background Color', 'exclusive-addons-elementor-pro' ),
                        'type'      => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .exad-social-share-icons .exad-reddit-social-icon a:hover' => 'background-color: {{VALUE}};'
                        ],
                        'condition'   => [
                            'enable_reddit' => 'yes'
                        ]
                    ]
                );

                $this->add_group_control(
                    Group_Control_Border::get_type(),
                    [
                        'name' => 'social_share_reddit_border_hover',
                        'label' => __( 'Border', 'exclusive-addons-elementor-pro' ),
                        'selector' => '{{WRAPPER}} .exad-social-share-icons .exad-reddit-social-icon a:hover',
                        'condition'   => [
                            'enable_reddit' => 'yes'
                        ]
                    ]
                );

                $this->add_group_control(
                    Group_Control_Box_Shadow::get_type(),
                    [
                        'name' => 'social_share_reddit_shadow_hover',
                        'label' => __( 'Box Shadow', 'exclusive-addons-elementor-pro' ),
                        'selector' => '{{WRAPPER}} .exad-social-share-icons .exad-reddit-social-icon a:hover',
                    ]
                );

            $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();   

    }

    protected function render() {
        $settings     = $this->get_settings_for_display();
        $type         = $settings['social_share_icon_display_type'];
        $enable_label = $settings['enable_label'];
        $enable_fb    = $settings['enable_facebook'];
        $enable_tw    = $settings['enable_twitter'];
        $enable_pt    = $settings['enable_pinterest'];
        $enable_ld    = $settings['enable_linkedin'];
        $enable_rd    = $settings['enable_reddit'];
        $image_link   = wp_get_attachment_url( get_post_thumbnail_id() );

        $this->add_render_attribute( 
            'exad-social-share-icons', 
            [ 
                'class' => [ 
                    'exad-social-share-icons',
                    'exad-social-share-display-'.esc_attr( $type ),
                    'exad-social-share-box-'.esc_attr( $settings['enable_social_icon_box'] )
                ]
            ]
        );

        if( 'new-tab' == $settings['social_share_icon_open_tab'] ) :
            $target = '_blank';
        else :
            $target = '_self';
        endif;

        ?>
        <div <?php echo $this->get_render_attribute_string( 'exad-social-share-icons' ); ?>>
            <?php if( 'yes' === $enable_fb ) : ?>
                <div class="exad-facebook-social-icon">
                    <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo esc_url( get_permalink() ); ?>" target="<?php echo esc_attr( $target ); ?>" title="<?php _e( 'Facebook', 'exclusive-addons-elementor-pro' ); ?>">
                        <?php Icons_Manager::render_icon( $settings['social_share_facebook_icon'], [ 'aria-hidden' => 'true' ] ); ?>
                        <?php if( 'yes' === $enable_label ) : ?>
                            <span><?php echo esc_html( $settings['social_share_facebook_label'] ); ?></span>
                        <?php endif; ?>
                    </a>
                </div>
            <?php endif; ?>

            <?php if( 'yes' === $enable_tw ) : ?>
                <div class="exad-twitter-social-icon">
                    <a href="https://twitter.com/intent/tweet?text=<?php echo esc_url( get_permalink() ); ?>" target="<?php echo esc_attr( $target ); ?>" title="<?php _e( 'Twitter', 'exclusive-addons-elementor-pro' ); ?>">
                        <?php Icons_Manager::render_icon( $settings['social_share_twitter_icon'], [ 'aria-hidden' => 'true' ] ); ?>
                        <?php if( 'yes' === $enable_label ) : ?>
                            <span><?php echo esc_html( $settings['social_share_twitter_label'] ); ?></span>
                        <?php endif; ?>                                
                    </a>
                </div>
            <?php endif; ?>

            <?php if( 'yes' === $enable_pt ) : ?>
                <div class="exad-pinterest-social-icon">
                    <a href="https://pinterest.com/pin/create/button/?url=<?php echo esc_url( get_permalink() ); ?>&media=<?php echo esc_url( $image_link ); ?>" target="<?php echo esc_attr( $target ); ?>" title="<?php _e( 'Pinterest', 'exclusive-addons-elementor-pro' ); ?>">
                        <?php Icons_Manager::render_icon( $settings['social_share_pinterest_icon'], [ 'aria-hidden' => 'true' ] ); ?>
                        <?php if( 'yes' === $enable_label ) : ?>
                            <span><?php echo esc_html( $settings['social_share_pinterest_label'] ); ?></span>
                        <?php endif; ?>                                   
                    </a>
                </div>
            <?php endif; ?>

            <?php if( 'yes' === $enable_ld ) : ?>
                <div class="exad-linkedin-social-icon">
                    <a href="https://linkedin.com/shareArticle?mini=true&url=<?php echo esc_url( get_permalink() ); ?>&title=<?php echo esc_attr(sanitize_title( get_the_title() ) ); ?>" title="<?php _e( 'Linkedin', 'exclusive-addons-elementor-pro' ); ?>" target="<?php echo esc_attr( $target ); ?>">
                        <?php Icons_Manager::render_icon( $settings['social_share_linkedin_icon'], [ 'aria-hidden' => 'true' ] ); ?>
                        <?php if( 'yes' === $enable_label ) : ?>
                            <span><?php echo esc_html( $settings['social_share_linkedin_label'] ); ?></span>
                        <?php endif; ?>                                
                    </a>
                </div>
            <?php endif; ?>

            <?php if( 'yes' === $enable_rd ) : ?>
                <div class="exad-reddit-social-icon">
                    <a href="https://www.reddit.com/submit?url=<?php echo esc_url( get_permalink() ); ?>&title=<?php echo esc_attr( get_the_title() ); ?>" target="<?php echo esc_attr( $target ); ?>" title="<?php _e( 'Reddit', 'exclusive-addons-elementor-pro' ); ?>">
                        <?php Icons_Manager::render_icon( $settings['social_share_reddit_icon'], [ 'aria-hidden' => 'true' ] ); ?>
                        <?php if( 'yes' === $enable_label ) : ?>
                            <span><?php echo esc_html( $settings['social_share_reddit_label'] ); ?></span>
                        <?php endif; ?>
                    </a>             
                </div>
            <?php endif; ?>
        </div>
        <?php
    }

}