<?php
namespace ExclusiveAddons\Elements;

if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.

use \Elementor\Widget_Base;
use \Elementor\Controls_Manager;
use \Elementor\Plugin;
use \Elementor\Group_Control_Border;
use \Elementor\Group_Control_Box_Shadow;
use \Elementor\Group_Control_Typography;
use \Elementor\Group_Control_Background;

class Content_Switcher extends Widget_Base {

    public function get_name() {
        return 'exad-content-switcher';
    }

    public function get_title() {
        return esc_html__( 'Content Switcher', 'exclusive-addons-elementor-pro' );
    }

    public function get_icon() {
        return 'exad exad-logo exad-content-switcher';
    }

    public function get_categories() {
        return [ 'exclusive-addons-elementor' ];
    }

    protected function register_controls() {
        $exad_primary_color   = get_option( 'exad_primary_color_option', '#7a56ff' );
        
        /**
         * Content Switcher Content
         */
        $this->start_controls_section(
            'exad_switcher_content_section',
            [
                'label' => __( 'Content', 'exclusive-addons-elementor-pro' )
            ]
        );

        $this->start_controls_tabs( 'exad_switcher_content_tabs' );

            $this->start_controls_tab( 'exad_switcher_content_primary', [ 'label' => __( 'Primary', 'exclusive-addons-elementor-pro' ) ] );

                $this->add_control(
                    'exad_switcher_content_primary_heading',
                    [
                        'label'       => esc_html__( 'Heading', 'exclusive-addons-elementor-pro' ),
                        'type'        => Controls_Manager::TEXT,
                        'label_block' => true,
                        'default'     => esc_html__( 'Primary Heading', 'exclusive-addons-elementor-pro' )
                    ]
                );

                $this->add_control(
                    'exad_switcher_primary_content_type',
                    [
                        'label'   => __( 'Content Type', 'exclusive-addons-elementor-pro' ),
                        'type'    => Controls_Manager::SELECT,
                        'default' => 'content',
                        'options' => [
                            'content'       => __( 'Content', 'exclusive-addons-elementor-pro' ),
                            'save_template' => __( 'Save Template', 'exclusive-addons-elementor-pro' )
                        ]
                    ]
                );

                $this->add_control(
                    'exad_switcher_primary_content_save_template',
                    [
                        'label'     => __( 'Select Section', 'exclusive-addons-elementor-pro' ),
                        'type'      => Controls_Manager::SELECT,
                        'options'   => $this->get_saved_template( 'section' ),
                        'default'   => '-1',
                        'condition' => [
                            'exad_switcher_primary_content_type' => 'save_template'
                        ]
                    ]
                );

                $this->add_control(
                    'exad_switcher_content_primary_content',
                    [
                        'label'       => __( 'Content', 'exclusive-addons-elementor-pro' ),
                        'type'        => Controls_Manager::WYSIWYG,
                        'default'     => __( 'Primary content is written here.', 'exclusive-addons-elementor-pro' ),
                        'placeholder' => __( 'Type your description here', 'exclusive-addons-elementor-pro' ),
                        'condition'   => [
                            'exad_switcher_primary_content_type' => 'content'
                        ]
                    ]
                );

            $this->end_controls_tab();

            $this->start_controls_tab( 'exad_switcher_content_secondary', [ 'label' => __('Secondary', 'exclusive-addons-elementor-pro') ] );

                $this->add_control(
                    'exad_switcher_content_secondary_heading',
                    [
                        'label'       => esc_html__( 'Heading', 'exclusive-addons-elementor-pro' ),
                        'type'        => Controls_Manager::TEXT,
                        'label_block' => true,
                        'default'     => esc_html__( 'Secondary Heading', 'exclusive-addons-elementor-pro' )
                    ]
                );

                $this->add_control(
                    'exad_switcher_secondary_content_type',
                    [
                        'label'   => __( 'Content Type', 'exclusive-addons-elementor-pro' ),
                        'type'    => Controls_Manager::SELECT,
                        'default' => 'content',
                        'options' => [
                            'content'       => __( 'Content', 'exclusive-addons-elementor-pro' ),
                            'save_template' => __( 'Save Template', 'exclusive-addons-elementor-pro' )
                        ]
                    ]
                );

                $this->add_control(
                    'exad_switcher_secondary_content_save_template',
                    [
                        'label'     => __( 'Select Section', 'exclusive-addons-elementor-pro' ),
                        'type'      => Controls_Manager::SELECT,
                        'options'   => $this->get_saved_template( 'section' ),
                        'default'   => '-1',
                        'condition' => [
                            'exad_switcher_secondary_content_type' => 'save_template'
                        ]
                    ]
                );

                $this->add_control(
                    'exad_switcher_content_secondary_content',
                    [
                        'label'       => __( 'Content', 'exclusive-addons-elementor-pro' ),
                        'type'        => Controls_Manager::WYSIWYG,
                        'default'     => __( 'Secondary content is written here.', 'exclusive-addons-elementor-pro' ),
                        'placeholder' => __( 'Type your description here', 'exclusive-addons-elementor-pro' ),
                        'condition'   => [
                            'exad_switcher_secondary_content_type' => 'content'
                        ]
                    ]
                );

            $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();

        /**
         * Content Switcher Style
         */
        $this->start_controls_section(
            'exad_switcher_content_heading_style',
            [
                'label' => __( 'Switcher Heading', 'exclusive-addons-elementor-pro' ),
                'tab'   => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_control(
			'exad_switcher_content_heading_allignment',
			[
                'label'   => __( 'Alignment', 'exclusive-addons-elementor-pro' ),
                'type'    => Controls_Manager::CHOOSE,
                'default' => 'exad_switecher_center',
                'toggle'  => false,
                'options' => [
					'exad_switecher_left'   => [
                        'title'        => __( 'Left', 'exclusive-addons-elementor-pro' ),
                        'icon'         => 'eicon-text-align-left'
					],
					'exad_switecher_center' => [
                        'title'        => __( 'Center', 'exclusive-addons-elementor-pro' ),
                        'icon'         => 'eicon-text-align-center'
					],
					'exad_switecher_right'  => [
                        'title'        => __( 'Right', 'exclusive-addons-elementor-pro' ),
                        'icon'         => 'eicon-text-align-right'
                    ],
					'exad_switecher_justify'  => [
                        'title'        => __( 'justify', 'exclusive-addons-elementor-pro' ),
                        'icon'         => 'eicon-text-align-right'
					]
				]
			]
        );

        // $this->add_control(
        //     'exad_switcher_content_heading_background',
        //     [
        //         'label'     => __( 'Background Color', 'exclusive-addons-elementor-pro' ),
        //         'type'      => Controls_Manager::COLOR,
        //         'selectors' => [
        //             '{{WRAPPER}} .exad-content-switcher-toggle-inner' => 'background: {{VALUE}};',
        //         ]
        //     ]
        // );

        $this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'exad_switcher_content_heading_background',
				'label' => __( 'Background', 'exclusive-addons-elementor-pro' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .exad-content-switcher-toggle-inner',
			]
		);

        $this->add_responsive_control(
			'exad_switcher_content_heading_padding',
			[
                'label'        => __( 'Padding', 'exclusive-addons-elementor-pro' ),
                'type'         => Controls_Manager::DIMENSIONS,
                'size_units'   => [ 'px', '%' ],
                'default'      => [
                    'top'      => '30',
                    'right'    => '0',
                    'bottom'   => '30',
                    'left'     => '0',
                    'unit'     => 'px',
                    'isLinked' => false
                ],
				'selectors'    => [
					'{{WRAPPER}} .exad-content-switcher-toggle-inner' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
        );

        $this->add_group_control(
			Group_Control_Border::get_type(),
			[
                'name'     => 'exad_switcher_content_heading_border',
                'selector' => '{{WRAPPER}} .exad-content-switcher-toggle-inner'
			]
		);

        $this->add_responsive_control(
			'exad_switcher_content_heading_radius',
			[
                'label'      => __( 'Border Radius', 'exclusive-addons-elementor-pro' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors'  => [
					'{{WRAPPER}} .exad-content-switcher-toggle-inner' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
        );
        
        $this->add_responsive_control(
			'exad_switcher_content_heading_spacing',
			[
                'label'       => __( 'Heading Spacing', 'exclusive-addons-elementor-pro' ),
                'type'        => Controls_Manager::SLIDER,
                'size_units'  => [ 'px', '%' ],
                'range'       => [
					'px'      => [
						'min' => 0,
						'max' => 100
					]
				],
				'default'     => [
					'unit'    => 'px',
					'size'    => 20
				],
				'selectors'   => [
					'{{WRAPPER}} .exad-content-switcher-toggle-label-1' => 'margin-right: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .exad-content-switcher-toggle-label-2' => 'margin-left: {{SIZE}}{{UNIT}};'
				]
			]
        );
        
        $this->add_responsive_control(
			'exad_switcher_content_heading_bottom_spacing',
			[
                'label'       => __( 'Bottom Spacing', 'exclusive-addons-elementor-pro' ),
                'type'        => Controls_Manager::SLIDER,
                'size_units'  => [ 'px' ],
                'range'       => [
					'px'      => [
						'min' => 0,
						'max' => 100
					]
				],
				'default'     => [
					'unit'    => 'px',
					'size'    => 0
				],
				'selectors'   => [
					'{{WRAPPER}} .exad-content-switcher-toggle-inner' => 'margin-bottom: {{SIZE}}{{UNIT}};'
				]
			]
        );

        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
                'name'     => 'exad_switcher_content_heading_typography',
                'selector' => '{{WRAPPER}} .exad-content-switcher-toggle-label-1, {{WRAPPER}} .exad-content-switcher-toggle-label-2'
			]
        );
        
        $this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
                'name'     => 'exad_switcher_content_heading_shadow',
                'selector' => '{{WRAPPER}} .exad-content-switcher-toggle-inner'
			]
		);
        
        $this->start_controls_tabs('exad_switcher_content_heading_bottom_tabs');

            $this->start_controls_tab('exad_switcher_content_heading_primary', [ 'label' => __( 'Primary Heading', 'exclusive-addons-elementor-pro' ) ] );

                $this->add_control(
                    'exad_switcher_content_heading_primary_color',
                    [
                        'label'     => __( 'Text Color', 'exclusive-addons-elementor-pro' ),
                        'type'      => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .exad-content-switcher-toggle-label-1' => 'color: {{VALUE}};'
                        ]
                    ]
                );
                
            $this->end_controls_tab();

            $this->start_controls_tab('exad_switcher_content_heading_secondary', [ 'label' => __('Secondary Heading', 'exclusive-addons-elementor-pro') ] );

                $this->add_control(
                    'exad_switcher_content_heading_secondary_color',
                    [
                        'label'     => __( 'Text Color', 'exclusive-addons-elementor-pro' ),
                        'type'      => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .exad-content-switcher-toggle-label-2' => 'color: {{VALUE}};'
                        ]
                    ]
                );
                
            $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();

        /**
         * Content Switcher Style
         */
        $this->start_controls_section(
            'exad_switcher_content_switch_style',
            [
                'label' => __( 'Switch Style', 'exclusive-addons-elementor-pro' ),
                'tab'   => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_control(
			'exad_switcher_content_switch',
			[
                'label'     => __( 'Switch Background', 'exclusive-addons-elementor-pro' ),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'after'
			]
        );

        $this->add_responsive_control(
			'exad_switcher_content_switch_width',
			[
                'label'       => __( 'Width', 'exclusive-addons-elementor-pro' ),
                'type'        => Controls_Manager::SLIDER,
                'size_units'  => [ 'px' ],
                'range'       => [
					'px'      => [
						'min' => 0,
						'max' => 100
					]
				],
				'default'     => [
					'unit'    => 'px',
					'size'    => 70
				],
				'selectors'   => [
					'{{WRAPPER}} .exad-content-switcher-toggle-switch-slider' => 'width: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .exad-content-switcher-toggle-switch-label' => 'width: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} input:checked + .exad-content-switcher-toggle-switch-slider:before' => '-webkit-transform: translate( calc( {{SIZE}}{{UNIT}} - {{exad_switcher_content_switch_control_width.size}}{{exad_switcher_content_switch_control_width.unit}} ) , -50%); -ms-transform: translate(calc( {{SIZE}}{{UNIT}} - {{exad_switcher_content_switch_control_width.size}}{{exad_switcher_content_switch_control_width.unit}} ), -50%);transform: translate(calc( {{SIZE}}{{UNIT}} - {{exad_switcher_content_switch_control_width.size}}{{exad_switcher_content_switch_control_width.unit}} ), -50%);'
				]
			]
        );
        
        $this->add_responsive_control(
			'exad_switcher_content_switch_height',
			[
                'label'       => __( 'Height', 'exclusive-addons-elementor-pro' ),
                'type'        => Controls_Manager::SLIDER,
                'size_units'  => [ 'px' ],
                'range'       => [
					'px'      => [
						'min' => 0,
						'max' => 100
					]
				],
				'default'     => [
					'unit'    => 'px',
					'size'    => 30
				],
				'selectors'   => [
                    '{{WRAPPER}} .exad-content-switcher-toggle-switch-slider, 
                    {{WRAPPER}} .exad-content-switcher-toggle-switch, 
                    {{WRAPPER}} .exad-content-switcher-toggle-switch-label' => 'height: {{SIZE}}{{UNIT}};'
				]
			]
        );

        $this->add_responsive_control(
			'exad_switcher_content_switch_radius',
			[
                'label'      => __( 'Switch Border Radius', 'exclusive-addons-elementor-pro' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'default'    => [
                    'top'    => '30',
                    'right'  => '30',
                    'bottom' => '30',
                    'left'   => '30',
                    'unit'   => 'px'
                ],
                'selectors'  => [
					'{{WRAPPER}} .exad-content-switcher-toggle-switch-slider' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
        );

        $this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
                'name'     => 'exad_switcher_content_switch_shadow',
                'selector' => '{{WRAPPER}} .exad-content-switcher-toggle-switch-slider'
			]
		);

        $this->start_controls_tabs('exad_switcher_content_switch_tabs');

            $this->start_controls_tab('exad_switcher_content_switch_off', [ 'label' => __( 'Switch OFF', 'exclusive-addons-elementor-pro') ] );

                $this->add_group_control(
                    Group_Control_Background::get_type(),
                    [
                        'name' => 'exad_switcher_content_switch_off_bg_color',
                        'label' => __( 'Background', 'exclusive-addons-elementor-pro' ),
                        'types' => [ 'classic', 'gradient' ],
                        'fields_options'  => [
                            'background'  => [
                                'default' => 'classic'
                            ],
                            'color'       => [
                                'default' => $exad_primary_color
                            ]
                        ],
                        'selector' => '{{WRAPPER}} .exad-content-switcher-toggle-switch-slider',
                    ]
                );

                $this->add_control(
                    'exad_switcher_content_switch_off_border_style',
                    [
                        'label' => __( 'Switch Border Style', 'exclusive-addons-elementor-pro' ),
                        'type' => Controls_Manager::SELECT,
                        'default' => 'none',
                        'options' => [
                            'none' => __( 'None', 'exclusive-addons-elementor-pro' ),
                            'solid'  => __( 'Solid', 'exclusive-addons-elementor-pro' ),
                            'dashed' => __( 'Dashed', 'exclusive-addons-elementor-pro' ),
                            'dotted' => __( 'Dotted', 'exclusive-addons-elementor-pro' ),
                            'double' => __( 'Double', 'exclusive-addons-elementor-pro' ),
                        ],
                        'selectors'   => [
                            '{{WRAPPER}} .exad-content-switcher-toggle-switch-slider' => 'border-style: {{VALUE}};'
                        ]
                    ]
                );
        
                $this->add_responsive_control(
                    'exad_switcher_content_switch_off_border_width',
                    [
                        'label'       => __( 'Switch Border Width', 'exclusive-addons-elementor-pro' ),
                        'type'        => Controls_Manager::SLIDER,
                        'size_units'  => [ 'px' ],
                        'range'       => [
                            'px'      => [
                                'min' => 0,
                                'max' => 10
                            ]
                        ],
                        'default'     => [
                            'unit'    => 'px',
                            'size'    => 0
                        ],
                        'selectors'   => [
                            '{{WRAPPER}} .exad-content-switcher-toggle-switch-slider' => 'border-width: {{SIZE}}{{UNIT}};'
                        ],
                        'condition' => [
                            'exad_switcher_content_switch_off_border_style!' => 'none'
                        ]
                    ]
                );
        
                $this->add_control(
                    'exad_switcher_content_switch_off_border_color',
                    [
                        'label'     => __( 'Switch Border color', 'exclusive-addons-elementor-pro' ),
                        'type'      => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .exad-content-switcher-toggle-switch-slider' => 'border-color: {{VALUE}};'
                        ],
                        'condition' => [
                            'exad_switcher_content_switch_off_border_style!' => 'none'
                        ]
                    ]
                );
                
            $this->end_controls_tab();

            $this->start_controls_tab('exad_switcher_content_switch_on', [ 'label' => __( 'Switch ON', 'exclusive-addons-elementor-pro') ] );

                $this->add_group_control(
                    Group_Control_Background::get_type(),
                    [
                        'name' => 'exad_switcher_content_switch_on_bg_color',
                        'label' => __( 'Background', 'exclusive-addons-elementor-pro' ),
                        'types' => [ 'classic', 'gradient' ],
                        'selector' => '{{WRAPPER}} input:checked + .exad-content-switcher-toggle-switch-slider',
                    ]
                );

                $this->add_control(
                    'exad_switcher_content_switch_on_border_style',
                    [
                        'label' => __( 'Switch Border Style', 'exclusive-addons-elementor-pro' ),
                        'type' => Controls_Manager::SELECT,
                        'default' => 'none',
                        'options' => [
                            'none' => __( 'None', 'exclusive-addons-elementor-pro' ),
                            'solid'  => __( 'Solid', 'exclusive-addons-elementor-pro' ),
                            'dashed' => __( 'Dashed', 'exclusive-addons-elementor-pro' ),
                            'dotted' => __( 'Dotted', 'exclusive-addons-elementor-pro' ),
                            'double' => __( 'Double', 'exclusive-addons-elementor-pro' ),
                        ],
                        'selectors'   => [
                            '{{WRAPPER}} input:checked + .exad-content-switcher-toggle-switch-slider' => 'border-style: {{VALUE}};'
                        ]
                    ]
                );
        
                $this->add_responsive_control(
                    'exad_switcher_content_switch_on_border_width',
                    [
                        'label'       => __( 'Switch Border Width', 'exclusive-addons-elementor-pro' ),
                        'type'        => Controls_Manager::SLIDER,
                        'size_units'  => [ 'px' ],
                        'range'       => [
                            'px'      => [
                                'min' => 0,
                                'max' => 10
                            ]
                        ],
                        'default'     => [
                            'unit'    => 'px',
                            'size'    => 0
                        ],
                        'selectors'   => [
                            '{{WRAPPER}} input:checked + .exad-content-switcher-toggle-switch-slider' => 'border-width: {{SIZE}}{{UNIT}};'
                        ],
                        'condition' => [
                            'exad_switcher_content_switch_on_border_style!' => 'none'
                        ]
                    ]
                );
        
                $this->add_control(
                    'exad_switcher_content_switch_on_border_color',
                    [
                        'label'     => __( 'Switch Border color', 'exclusive-addons-elementor-pro' ),
                        'type'      => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} input:checked + .exad-content-switcher-toggle-switch-slider' => 'border-color: {{VALUE}};'
                        ],
                        'condition' => [
                            'exad_switcher_content_switch_on_border_style!' => 'none'
                        ]
                    ]
                );

            $this->end_controls_tab();

        $this->end_controls_tabs();
        
        $this->add_control(
			'exad_switcher_content_switch_control',
			[
                'label'     => __( 'Switch Control', 'exclusive-addons-elementor-pro' ),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before'
			]
        );
        
        $this->add_responsive_control(
			'exad_switcher_content_switch_control_spacing_with_border',
			[
                'label'       => __( 'Left & Right Spacing', 'exclusive-addons-elementor-pro' ),
                'type'        => Controls_Manager::SLIDER,
                'size_units'  => [ 'px' ],
                'range'       => [
					'px'      => [
						'min' => 0,
						'max' => 20
					]
				],
				'default'     => [
					'unit'    => 'px',
					'size'    => 5
				],
				'selectors'   => [
                    '{{WRAPPER}} .exad-content-switcher-toggle-switch-slider:before'                 => 'margin-left: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} input:checked + .exad-content-switcher-toggle-switch-slider:before' => 'margin-left: calc( -{{SIZE}}{{UNIT}} - ( {{exad_switcher_content_switch_on_border_width.size}}{{exad_switcher_content_switch_on_border_width.unit}} * 2 ) ) ;',
                    '{{WRAPPER}} input:checked + .exad-content-switcher-toggle-switch-slider:before' => 'margin-left: calc( -{{SIZE}}{{UNIT}} - ( {{exad_switcher_content_switch_off_border_width.size}}{{exad_switcher_content_switch_off_border_width.unit}} * 2 ) ) ;'
                ],
                'condition' => [
                    'exad_switcher_content_switch_off_border_style!' => 'none',
                    'exad_switcher_content_switch_on_border_style!' => 'none',
                ]
			]
        );

        $this->add_responsive_control(
			'exad_switcher_content_switch_control_spacing_without_border',
			[
                'label'       => __( 'Left & Right Spacing', 'exclusive-addons-elementor-pro' ),
                'type'        => Controls_Manager::SLIDER,
                'size_units'  => [ 'px' ],
                'range'       => [
					'px'      => [
						'min' => 0,
						'max' => 20
					]
				],
				'default'     => [
					'unit'    => 'px',
					'size'    => 5
				],
				'selectors'   => [
                    '{{WRAPPER}} .exad-content-switcher-toggle-switch-slider:before'                 => 'margin-left: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} input:checked + .exad-content-switcher-toggle-switch-slider:before' => 'margin-left: -{{SIZE}}{{UNIT}} ;',
                ],
                'condition' => [
                    'exad_switcher_content_switch_off_border_style' => 'none',
                    'exad_switcher_content_switch_on_border_style' => 'none'
                ]
			]
        );

        $this->add_responsive_control(
			'exad_switcher_content_switch_control_radius',
			[
                'label'      => __( 'Switch Control Border Radius', 'exclusive-addons-elementor-pro' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'default'    => [
                    'top'    => '30',
                    'right'  => '30',
                    'bottom' => '30',
                    'left'   => '30',
                    'unit'   => 'px'
                ],
                'selectors'  => [
					'{{WRAPPER}} .exad-content-switcher-toggle-switch-slider:before' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
        );

        $this->start_controls_tabs( 'exad_switcher_content_switch_control_tabs' );

            $this->start_controls_tab( 'exad_switcher_content_switch_control_off', [ 'label' => __( 'Switch Control OFF', 'exclusive-addons-elementor-pro' ) ] );

                $this->add_responsive_control(
                    'exad_switcher_content_switch_control_width',
                    [
                        'label'       => __( 'Width', 'exclusive-addons-elementor-pro' ),
                        'type'        => Controls_Manager::SLIDER,
                        'size_units'  => [ 'px' ],
                        'range'       => [
                            'px'      => [
                                'min' => 0,
                                'max' => 50
                            ]
                        ],
                        'default'     => [
                            'unit'    => 'px',
                            'size'    => 27
                        ],
                        'selectors'   => [
                            '{{WRAPPER}} .exad-content-switcher-toggle-switch-slider:before' => 'width: {{SIZE}}{{UNIT}};'
                        ]
                    ]
                );
                
                $this->add_responsive_control(
                    'exad_switcher_content_switch_control_height',
                    [
                        'label'       => __( 'Height', 'exclusive-addons-elementor-pro' ),
                        'type'        => Controls_Manager::SLIDER,
                        'size_units'  => [ 'px' ],
                        'range'       => [
                            'px'      => [
                                'min' => 0,
                                'max' => 50
                            ]
                        ],
                        'default'     => [
                            'unit'    => 'px',
                            'size'    => 27
                        ],
                        'selectors'   => [
                            '{{WRAPPER}} .exad-content-switcher-toggle-switch-slider:before' => 'height: {{SIZE}}{{UNIT}};'
                        ]
                    ]
                );

                $this->add_group_control(
                    Group_Control_Background::get_type(),
                    [
                        'name' => 'exad_switcher_content_switch_off_switch_control_color',
                        'label' => __( 'Background', 'exclusive-addons-elementor-pro' ),
                        'types' => [ 'classic', 'gradient' ],
                        'fields_options'  => [
                            'background'  => [
                                'default' => 'classic'
                            ],
                            'color'       => [
                                'default' => '#ffffff',
                            ]
                        ],
                        'selector' => '{{WRAPPER}} .exad-content-switcher-toggle-switch-slider:before',
                    ]
                );

                $this->add_group_control(
                    Group_Control_Border::get_type(),
                    [
                        'name'     => 'exad_switcher_content_switch_off_control_border',
                        'selector' => '{{WRAPPER}} .exad-content-switcher-toggle-switch-slider:before'
                    ]
                );

                $this->add_group_control(
                    Group_Control_Box_Shadow::get_type(),
                    [
                        'name'     => 'exad_switcher_content_switch_on_control_shadow',
                        'selector' => '{{WRAPPER}} .exad-content-switcher-toggle-switch-slider:before'
                    ]
                );
                
            $this->end_controls_tab();

            $this->start_controls_tab( 'exad_switcher_content_switch_control_on', [ 'label' => __( 'Switch Control ON', 'exclusive-addons-elementor-pro' ) ] );

                $this->add_responsive_control(
                    'exad_switcher_content_switch_on_control_width',
                    [
                        'label'       => __( 'Width', 'exclusive-addons-elementor-pro' ),
                        'type'        => Controls_Manager::SLIDER,
                        'size_units'  => [ 'px' ],
                        'range'       => [
                            'px'      => [
                                'min' => 0,
                                'max' => 50
                            ]
                        ],
                        'default'     => [
                            'unit'    => 'px',
                            'size'    => 27
                        ],
                        'selectors'   => [
                            '{{WRAPPER}} input:checked + .exad-content-switcher-toggle-switch-slider:before' => 'width: {{SIZE}}{{UNIT}};'
                        ]
                    ]
                );
                
                $this->add_responsive_control(
                    'exad_switcher_content_switch_on_control_height',
                    [
                        'label'       => __( 'Height', 'exclusive-addons-elementor-pro' ),
                        'type'        => Controls_Manager::SLIDER,
                        'size_units'  => [ 'px' ],
                        'range'       => [
                            'px'      => [
                                'min' => 0,
                                'max' => 50
                            ]
                        ],
                        'default'     => [
                            'unit'    => 'px',
                            'size'    => 27
                        ],
                        'selectors'   => [
                            '{{WRAPPER}} input:checked + .exad-content-switcher-toggle-switch-slider:before' => 'height: {{SIZE}}{{UNIT}};'
                        ]
                    ]
                );

                $this->add_group_control(
                    Group_Control_Background::get_type(),
                    [
                        'name' => 'exad_switcher_content_switch_on_switch_control_color',
                        'label' => __( 'Background', 'exclusive-addons-elementor-pro' ),
                        'types' => [ 'classic', 'gradient' ],
                        'fields_options'  => [
                            'background'  => [
                                'default' => 'classic'
                            ],
                            'color'       => [
                                'default' => '#ffffff',
                            ]
                        ],
                        'selector' => '{{WRAPPER}} input:checked + .exad-content-switcher-toggle-switch-slider:before',
                    ]
                );

                $this->add_group_control(
                    Group_Control_Border::get_type(),
                    [
                        'name'     => 'exad_switcher_content_switch_on_control_border',
                        'selector' => '{{WRAPPER}} input:checked + .exad-content-switcher-toggle-switch-slider:before'
                    ]
                );

                $this->add_group_control(
                    Group_Control_Box_Shadow::get_type(),
                    [
                        'name'     => 'exad_switcher_content_switch_off_control_shadow',
                        'selector' => '{{WRAPPER}} input:checked + .exad-content-switcher-toggle-switch-slider:before'
                    ]
                );

            $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();

        /**
         * Content Switcher Content
         */
        $this->start_controls_section(
            'exad_switcher_content_main_contant_style',
            [
                'label' => __( 'Switcher Content', 'exclusive-addons-elementor-pro' ),
                'tab'   => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_group_control(
			Group_Control_Background::get_type(),
			[
                'name'     => 'exad_switcher_main_contant_background',
                'label'    => __( 'Background', 'exclusive-addons-elementor-pro' ),
                'types'    => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}} .exad-content-switcher-content-wrap'
			]
        );

        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
                'name'     => 'exad_switcher_main_contant_typography',
                'selector' => '{{WRAPPER}} .exad-content-switcher-content-wrap'
			]
		);
        
        $this->add_control(
            'exad_switcher_main_contant_text_color',
            [
                'label'     => __( 'Text Color', 'exclusive-addons-elementor-pro' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .exad-content-switcher-content-wrap' => 'color: {{VALUE}};'
                ]
            ]
        );

        $this->add_responsive_control(
			'exad_switcher_main_contant_padding',
			[
                'label'        => __( 'Padding', 'exclusive-addons-elementor-pro' ),
                'type'         => Controls_Manager::DIMENSIONS,
                'size_units'   => [ 'px', '%' ],
                'default'      => [
                    'top'      => '20',
                    'right'    => '20',
                    'bottom'   => '20',
                    'left'     => '20',
                    'unit'     => 'px'
                ],
				'selectors'    => [
					'{{WRAPPER}} .exad-content-switcher-content-wrap' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
        );

        $this->add_group_control(
			Group_Control_Border::get_type(),
			[
                'name'     => 'exad_switcher_main_contant_border',
                'selector' => '{{WRAPPER}} .exad-content-switcher-content-wrap'
			]
		);
        
        $this->add_responsive_control(
			'exad_switcher_main_contant_radius',
			[
                'label'      => __( 'Border Radius', 'exclusive-addons-elementor-pro' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors'  => [
					'{{WRAPPER}} .exad-content-switcher-content-wrap' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
        );

        $this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
                'name'     => 'exad_switcher_main_contant_shadow',
                'selector' => '{{WRAPPER}} .exad-content-switcher-content-wrap'
			]
		);

        $this->end_controls_section();
    }

    /**
	 *  Get Saved Widgets
	 *
	 *  @param string $type Type.
	 *  @since 0.0.1
	 *  @return string
	 */
	public function get_saved_template( $type = 'page' ) {

		$saved_widgets = $this->get_post_template( $type );
		$options[-1]   = __( 'Select', 'exclusive-addons-elementor-pro' );
		if ( count( $saved_widgets ) ) :
			foreach ( $saved_widgets as $saved_row ) :
				$options[ $saved_row['id'] ] = $saved_row['name'];
			endforeach;
		else :
			$options['no_template'] = __( 'No section template is added.', 'exclusive-addons-elementor-pro' );
		endif;
		return $options;
	}

	/**
	 *  Get Templates based on category
	 *
	 *  @param string $type Type.
	 *  @since 0.0.1
	 *  @return string
	 */
	public function get_post_template( $type = 'page' ) {
		$posts = get_posts(
			array(
				'post_type'        => 'elementor_library',
				'orderby'          => 'title',
				'order'            => 'ASC',
				'posts_per_page'   => '-1',
				'tax_query'        => array(
					array(
						'taxonomy' => 'elementor_library_type',
						'field'    => 'slug',
						'terms'    => $type
					)
				)
			)
		);

		$templates = array();

		foreach ( $posts as $post ) :
			$templates[] = array(
				'id'   => $post->ID,
				'name' => $post->post_title
			);
		endforeach;

		return $templates;
	}

    protected function render() {
        $settings = $this->get_settings_for_display();
        ?>
        <div class="exad-content-switcher-wrapper">
            <div class="exad-content-switcher-toggle <?php echo esc_attr( $settings['exad_switcher_content_heading_allignment'] ); ?>">
                <div class="exad-content-switcher-toggle-inner">
                    <div class="exad-content-switcher-toggle-label-1">
                        <?php echo esc_html( $settings['exad_switcher_content_primary_heading'] ); ?>
                    </div>
                    <div class="exad-content-switcher-toggle-switch">
                        <label class="exad-content-switcher-toggle-switch-label">
                            <input class="input" type="checkbox">
                            <span class="exad-content-switcher-toggle-switch-slider"></span>
                        </label>
                    </div>
                    <div class="exad-content-switcher-toggle-label-2">
                        <?php echo esc_html( $settings['exad_switcher_content_secondary_heading'] ); ?>
                    </div>
                </div>
            </div>
            <div class="exad-content-switcher-content-wrap">
                <div class="exad-content-switcher-primary-wrap">
                    <?php if( 'content' === $settings['exad_switcher_primary_content_type'] ) : ?>
                        <?php echo wp_kses_post( $settings['exad_switcher_content_primary_content'] ); ?>
                    <?php endif; ?>
                    <?php if( 'save_template' === $settings['exad_switcher_primary_content_type'] ) : ?>
                        <?php echo Plugin::$instance->frontend->get_builder_content_for_display( wp_kses_post( $settings['exad_switcher_primary_content_save_template'] ) ); ?>
                    <?php endif; ?>
                </div>
                <div class="exad-content-switcher-secondary-wrap">
                    <?php if( 'content' === $settings['exad_switcher_secondary_content_type'] ) : ?>
                        <?php echo wp_kses_post( $settings['exad_switcher_content_secondary_content'] ); ?>
                    <?php endif; ?>
                    <?php if( 'save_template' === $settings['exad_switcher_secondary_content_type'] ) : ?>
                        <?php echo Plugin::$instance->frontend->get_builder_content_for_display( wp_kses_post( $settings['exad_switcher_secondary_content_save_template'] ) ); ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <?php
    }
}