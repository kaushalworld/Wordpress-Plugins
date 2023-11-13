<?php
namespace ExclusiveAddons\Elements;

if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.

use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Border;
use \Elementor\Group_Control_Box_Shadow;
use \Elementor\Group_Control_Typography;
use \Elementor\Group_Control_Background;
use \Elementor\Widget_Base;
use \Elementor\Icons_Manager;

class Iconbox extends Widget_Base {
	
	public function get_name() {
		return 'exad-iconbox';
    }
    
	public function get_title() {
		return esc_html__( 'Icon Box', 'exclusive-addons-elementor-pro' );
    }
    
	public function get_icon() {
		return 'exad exad-logo exad-iconbox';
    }
    
	public function get_categories() {
		return [ 'exclusive-addons-elementor' ];
    }

    public function get_keywords() {
		return [ 'iconbox', 'icon', 'box' ];
    }
    
    protected function register_controls() {
		/**
  		 * Icon Box Content
  		 */
  		$this->start_controls_section(
            'exad_section_icon_box_content',
            [
                'label' => esc_html__( 'Content', 'exclusive-addons-elementor-pro' )
            ]
        );

        $this->add_control(
            'exad_icon_box_icon',
            [
                'label'       => __( 'Icon', 'exclusive-addons-elementor-pro' ),
				'type'        => Controls_Manager::ICONS,
				'default'     => [
                    'value'   => 'fab fa-wordpress-simple',
                    'library' => 'fa-brands'
                ],
            ]
		);
		
		$this->add_control(
			'exad_icon_box_label_switcher',
			[
				'label' => __( 'Enable Label', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'exclusive-addons-elementor-pro' ),
				'label_off' => __( 'Hide', 'exclusive-addons-elementor-pro' ),
				'return_value' => 'yes',
				'default' => 'no',
			]
		);

		$this->add_control(
			'exad_icon_box_label',
			[
				'label'       => esc_html__( 'Label Text', 'exclusive-addons-elementor-pro' ),
				'type'        => Controls_Manager::TEXT,
				'label_block' => true,
				'separator'   => 'before',
				'default'     => esc_html__( 'Icon Label', 'exclusive-addons-elementor-pro' ),
				'condition'   => [
					'exad_icon_box_label_switcher' => 'yes'
				]
			]
		);
        
        $this->add_control(
			'exad_icon_box_title',
			[
				'label'       => esc_html__( 'Title', 'exclusive-addons-elementor-pro' ),
				'type'        => Controls_Manager::TEXT,
				'label_block' => true,
				'default'     => esc_html__( 'Icon Box Title', 'exclusive-addons-elementor-pro' )
			]
        );
		$this->add_control(
			'exad_icon_box_title_tag',
			[
				'label'   => esc_html__( 'Heading Tag', 'exclusive-addons-elementor-pro' ),
				'type'    => Controls_Manager::CHOOSE,
				'default' => 'h3',
				'toggle'  => false,
				'options' => [
					'h1'  => [
						'title' => __( 'H1', 'exclusive-addons-elementor-pro' ),
						'icon'  => 'eicon-editor-h1'
					],
					'h2'  => [
						'title' => __( 'H2', 'exclusive-addons-elementor-pro' ),
						'icon'  => 'eicon-editor-h2'
					],
					'h3'  => [
						'title' => __( 'H3', 'exclusive-addons-elementor-pro' ),
						'icon'  => 'eicon-editor-h3'
					],
					'h4'  => [
						'title' => __( 'H4', 'exclusive-addons-elementor-pro' ),
						'icon'  => 'eicon-editor-h4'
					],
					'h5'  => [
						'title' => __( 'H5', 'exclusive-addons-elementor-pro' ),
						'icon'  => 'eicon-editor-h5'
					],
					'h6'  => [
						'title' => __( 'H6', 'exclusive-addons-elementor-pro' ),
						'icon'  => 'eicon-editor-h6'
					]
				]
			]
		);
        
        $this->add_control(
			'exad_icon_box_description',
			[
				'label'       => esc_html__( 'Description', 'exclusive-addons-elementor-pro' ),
				'type'        => Controls_Manager::TEXTAREA,
				'label_block' => true,
				'default'     => esc_html__( 'Icon Box Description', 'exclusive-addons-elementor-pro' )
			]
        );
        
        $this->add_control(
			'exad_icon_box_url',
			[
				'label'       => __( 'URL', 'exclusive-addons-elementor-pro' ),
				'type'        => Controls_Manager::URL,
				'placeholder' => __( 'https://your-link.com', 'exclusive-addons-elementor-pro' ),
				'label_block' => true
			]
		);

        $this->end_controls_section();
        
        /**
  		 * Icon Box Container Style
  		 */
  		$this->start_controls_section(
            'exad_section_icon_box_container',
            [
                'label' => esc_html__( 'Container', 'exclusive-addons-elementor-pro' ),
                'tab'       => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
			'exad_iconbox_alignment',
			[
				'label'       => esc_html__( 'Alignment', 'exclusive-addons-elementor-pro' ),
				'type'        => Controls_Manager::CHOOSE,
				'toggle'      => false,
				'options'     => [
					'exad-iconbox-left'   => [
						'title' => esc_html__( 'Left', 'exclusive-addons-elementor-pro' ),
						'icon'  => 'eicon-text-align-left'
					],
					'exad-iconbox-center' => [
						'title' => esc_html__( 'Center', 'exclusive-addons-elementor-pro' ),
						'icon'  => 'eicon-text-align-center'
					],
					'exad-iconbox-right'  => [
						'title' => esc_html__( 'Right', 'exclusive-addons-elementor-pro' ),
						'icon'  => 'eicon-text-align-right'
					]
				],
				'default'     => 'exad-iconbox-center'
			]
        );

        $this->add_responsive_control(
			'exad_iconbox_padding',
			[
				'label' => __( 'Padding', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'default'  => [
					'top' => '30',
					'right' => '30',
					'bottom' => '30',
					'left' => '30',
					'unit' => 'px',
					'isLinked' => false,
				],
				'selectors' => [
					'{{WRAPPER}} .exad-iconbox' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
			]
        );
        
        $this->add_responsive_control(
			'exad_iconbox_radius',
			[
				'label' => __( 'Border Radius', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'default'  => [
					'top' => '10',
					'right' => '10',
					'bottom' => '10',
					'left' => '10',
					'unit' => 'px',
					'isLinked' => true,
				],
				'selectors' => [
					'{{WRAPPER}} .exad-iconbox' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
			]
		);
        
        $this->start_controls_tabs( 'exad_iconbox_container_tab' );
			// Normal State Tab
			$this->start_controls_tab( 'exad_iconbox_container_normal', [ 'label' => esc_html__( 'Normal', 'exclusive-addons-elementor-pro' ) ] );
                
                $this->add_group_control(
                    Group_Control_Background::get_type(),
                    [
                        'name'            => 'exad_iconbox_container_background_normal',
                        'types'           => [ 'classic', 'gradient' ],
						'fields_options'  => [
							'background'  => [
								'default' => 'classic'
							],
							'color'       => [
								'default' => '#F1E3FF'
							]
						],
                        'selector'        => '{{WRAPPER}} .exad-iconbox',
                    ]
                );

				$this->add_group_control(
					Group_Control_Border::get_type(),
					[
						'name'     => 'exad_iconbox_container_border_normal',
                        'selector' => '{{WRAPPER}} .exad-iconbox',
					]
                );

                $this->add_group_control(
                    Group_Control_Box_Shadow::get_type(),
                    [
                        'name' => 'exad_iconbox_container_shadow_normal',
                        'label' => __( 'Box Shadow', 'exclusive-addons-elementor-pro' ),
                        'selector' => '{{WRAPPER}} .exad-iconbox',
                    ]
                );

			$this->end_controls_tab();

			// Hover State Tab
			$this->start_controls_tab( 'exad_iconbox_container_hover', [ 'label' => esc_html__( 'Hover', 'exclusive-addons-elementor-pro' ) ] );

                $this->add_group_control(
                    Group_Control_Background::get_type(),
                    [
                        'name'            => 'exad_iconbox_container_background_hover',
                        'types'           => [ 'classic', 'gradient' ],
                        'selector'        => '{{WRAPPER}} .exad-iconbox:hover',
                    ]
                );

                $this->add_group_control(
                    Group_Control_Border::get_type(),
                    [
                        'name'     => 'exad_iconbox_container_border_hover',
                        'selector' => '{{WRAPPER}} .exad-iconbox:hover',
                    ]
                );

                $this->add_group_control(
                    Group_Control_Box_Shadow::get_type(),
                    [
                        'name' => 'exad_iconbox_container_shadow_hover',
                        'label' => __( 'Box Shadow', 'exclusive-addons-elementor-pro' ),
                        'selector' => '{{WRAPPER}} .exad-iconbox:hover',
                    ]
                );
				
			$this->end_controls_tab();
        $this->end_controls_tabs();

		$this->end_controls_section();
		
		/*
		* Icon Box Label Style Section
		*/
		$this->start_controls_section(
			'exad_section_icon_box_label_style',
			[
				'label' => esc_html__( 'Label', 'exclusive-addons-elementor-pro' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$badge_align = is_rtl() ? 'right' : 'left';

		$this->add_responsive_control(
			'exad_icon_box_label_left_offset',
			[
				'label'       => __( 'X-Offset', 'exclusive-addons-elementor-pro' ),
				'type'        => Controls_Manager::SLIDER,
				'size_units'  => [ 'px', '%' ],
				'range'       => [
					'px'      => [
						'min' => 0,
						'max' => 500
					],
					'%'       => [
						'min' => 0,
						'max' => 100
					]
				],
				'default'      => [
                    'unit'     => '%',
                    'size'     => 0
                ],
				'selectors'    => [
					'{{WRAPPER}} .exad-iconbox-label' => $badge_align.': {{SIZE}}{{UNIT}};'
				]
			]
		);

		$this->add_responsive_control(
			'exad_icon_box_label_top_offset',
			[
				'label'       => __( 'Y-Offset', 'exclusive-addons-elementor-pro' ),
				'type'        => Controls_Manager::SLIDER,
				'size_units'  => [ 'px', '%' ],
				'range'       => [
					'px'      => [
						'min' => 0,
						'max' => 500
					],
					'%'       => [
						'min' => 0,
						'max' => 100
					]
				],
				'default'     => [
                    'unit'    => '%',
                    'size'    => 0
                ],
				'selectors'   => [
					'{{WRAPPER}} .exad-iconbox-label' => 'top: {{SIZE}}{{UNIT}};'
				]
			]
		);

		$this->add_control(
			'exad_icon_box_label_background',
			[
				'label'     => esc_html__( 'Background Color', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#222222',
				'selectors' => [
					'{{WRAPPER}} .exad-iconbox-label' => 'background: {{VALUE}};'
				]
			]
		);

		$this->add_control(
			'exad_icon_box_label_text_color',
			[
				'label'     => esc_html__( 'Text Color', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#fff',
				'selectors' => [
					'{{WRAPPER}} .exad-iconbox-label' => 'color: {{VALUE}};'
				]
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'exad_icon_box_label_typography',
				'selector' => '{{WRAPPER}} .exad-iconbox-label'
			]
		);

		$this->add_responsive_control(
			'exad_icon_box_label_padding',
			[
				'label'      => __( 'Padding', 'exclusive-addons-elementor-pro' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'default'    => [
					'top'    => '10',
					'right'  => '15',
					'bottom' => '10',
					'left'   => '15',
					'unit'   => 'px'
				],
				'selectors'  => [
					'{{WRAPPER}} .exad-iconbox-label' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				],
			]
		);
 
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'exad_icon_box_label_border',
				'selector' => '{{WRAPPER}} .exad-iconbox-label'
			]
		);

		$this->add_responsive_control(
			'exad_icon_box_label_radius',
			[
				'label'      => __( 'Border Radius', 'exclusive-addons-elementor-pro' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'default'    => [
					'top'    => '30',
					'right'  => '30',
					'bottom' => '30',
					'left'   => '30',
					'unit'   => 'px'
				],
				'selectors'  => [
					'{{WRAPPER}} .exad-iconbox-label' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'exad_icon_box_label_shadow',
				'selector' => '{{WRAPPER}} .exad-iconbox-label'
			]
		);

		$this->add_control(
			'exad_icon_box_label_z_index',
			[
				'label' => __( 'Z Index', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::NUMBER,
				'min' => -100,
				'max' => 10000,
				'step' => 0,
				'default' => 1,
				'selectors'  => [
					'{{WRAPPER}} .exad-iconbox-label' => 'z-index: {{SIZE}};'
				],
			]
		);

		$this->end_controls_section();
        
        /**
  		 * Icon Box icon Style
  		 */
  		$this->start_controls_section(
            'exad_section_icon_box_icon',
            [
                'label' => esc_html__( 'Icon', 'exclusive-addons-elementor-pro' ),
                'tab'       => Controls_Manager::TAB_STYLE,
            ]
        );

		$this->add_control(
			'exad_icon_box_icon_position',
			[
				'label'   => __( 'Position', 'exclusive-addons-elementor-pro' ),
				'type'    => Controls_Manager::CHOOSE,
				'toggle'  => false,
				'options' => [
					'exad-iconbox-icon-position-left'   => [
						'title' => __( 'Left', 'exclusive-addons-elementor-pro' ),
						'icon'  => 'eicon-arrow-left'
					],
					'exad-iconbox-icon-position-center' => [
						'title' => __( 'Top', 'exclusive-addons-elementor-pro' ),
						'icon'  => 'eicon-arrow-up'
					],
					'exad-iconbox-icon-position-right'  => [
						'title' => __( 'Right', 'exclusive-addons-elementor-pro' ),
						'icon'  => 'eicon-arrow-right'
					]
				],
				'default' => 'exad-iconbox-icon-position-center'
			]
		);

        $this->add_control(
            'exad_iconbox_enable',
            [
				'label'        => esc_html__( 'Icon Box Enable', 'exclusive-addons-elementor-pro' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => 'yes',
				'return_value' => 'yes'
            ]
		);
		
		$this->add_responsive_control(
			'exad_iconbox_height',
			[
				'label'     => esc_html__( 'Height', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 200,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 80,
				],
				'selectors' => [
					'{{WRAPPER}} .exad-iconbox-icon.yes' => 'height: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'exad_iconbox_enable' => 'yes'
				]
			]
		);
		$this->add_responsive_control(
			'exad_iconbox_width',
			[
				'label'     => esc_html__( 'Width', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 200,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 80,
				],
				'selectors' => [
					'{{WRAPPER}} .exad-iconbox-icon.yes' => 'width: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .exad-iconbox.exad-iconbox-icon-position-left .exad-iconbox-content' => 'flex-basis: calc( 100% - {{SIZE}}px );',
				  	'{{WRAPPER}} .exad-iconbox.exad-iconbox-icon-position-right .exad-iconbox-content' => 'flex-basis: calc( 100% - {{SIZE}}px );'
				],
				'condition' => [
					'exad_iconbox_enable' => 'yes'
				]
			]
		);

        $this->add_responsive_control(
			'exad_icon_box_icon_size',
			[
				'label' => __( 'Size', 'exclusive-addons-elementor-pro' ),
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
					'size' => 30,
				],
				'selectors' => [
                    '{{WRAPPER}} .exad-iconbox-icon i' => 'font-size: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .exad-iconbox-icon svg' => 'height: {{SIZE}}px; width: {{SIZE}}px;'
				],
			]
        );

        $this->add_responsive_control(
			'exad_icon_box_icon_radius',
			[
				'label' => __( 'Border Radius', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'default'  => [
					'top' => '50',
					'right' => '50',
					'bottom' => '50',
					'left' => '50',
					'unit' => 'px',
					'isLinked' => true,
				],
				'selectors' => [
					'{{WRAPPER}} .exad-iconbox-icon.yes' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition' => [
					'exad_iconbox_enable' => 'yes'
				]
			]
		);

        $this->start_controls_tabs( 'exad_iconbox_icon_tabs' );
			// Normal State Tab
			$this->start_controls_tab( 'exad_iconbox_icon_normal', [ 'label' => esc_html__( 'Normal', 'exclusive-addons-elementor-pro' ) ] );
                
                $this->add_group_control(
                    Group_Control_Background::get_type(),
                    [
                        'name'            => 'exad_iconbox_icon_background_normal',
                        'types'           => [ 'classic', 'gradient' ],
						'fields_options'  => [
							'background'  => [
								'default' => 'classic'
							],
							'color'       => [
								'default' => '#B266FF'
							]
						],
                        'selector'        => '{{WRAPPER}} .exad-iconbox-icon.yes',
                        'condition' => [
                            'exad_iconbox_enable' => 'yes'
                        ]
                    ]
                );

				$this->add_control(
					'exad_iconbox_icon_color_normal',
					[
						'label'     => esc_html__( 'Icon Color', 'exclusive-addons-elementor-pro' ),
						'type'      => Controls_Manager::COLOR,
						'default'   => '#ffffff',
						'selectors' => [
							'{{WRAPPER}} .exad-iconbox-icon i' => 'color: {{VALUE}}',
							'{{WRAPPER}} .exad-iconbox-icon svg path' => 'fill: {{VALUE}}'
						],
					]
				);

				$this->add_group_control(
					Group_Control_Border::get_type(),
					[
						'name'     => 'exad_iconbox_icon_border_normal',
                        'selector' => '{{WRAPPER}} .exad-iconbox-icon.yes',
                        'condition' => [
                            'exad_iconbox_enable' => 'yes'
                        ]
					]
				);

				$this->add_group_control(
                    Group_Control_Box_Shadow::get_type(),
                    [
                        'name' => 'exad_iconbox_icon_shadow_normal',
                        'label' => __( 'Box Shadow', 'exclusive-addons-elementor-pro' ),
                        'selector' => '{{WRAPPER}} .exad-iconbox-icon.yes',
                        'condition' => [
                            'exad_iconbox_enable' => 'yes'
                        ]
                    ]
                );

			$this->end_controls_tab();

			// Hover State Tab
			$this->start_controls_tab( 'exad_iconbox_icon_hover', [ 'label' => esc_html__( 'Hover', 'exclusive-addons-elementor-pro' ) ] );

                $this->add_group_control(
                    Group_Control_Background::get_type(),
                    [
                        'name'            => 'exad_iconbox_icon_background_hover',
                        'types'           => [ 'classic', 'gradient' ],
                        'selector'        => '{{WRAPPER}} .exad-iconbox:hover .exad-iconbox-icon.yes',
                        'condition' => [
                            'exad_iconbox_enable' => 'yes'
                        ]
                    ]
                );

                $this->add_control(
                    'exad_iconbox_icon_color_hover',
                    [
                        'label'     => esc_html__( 'Icon Color', 'exclusive-addons-elementor-pro' ),
                        'type'      => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .exad-iconbox:hover .exad-iconbox-icon i' => 'color: {{VALUE}}',
                            '{{WRAPPER}} .exad-iconbox:hover .exad-iconbox-icon svg path' => 'fill: {{VALUE}}'
                        ],
                    ]
                );

                $this->add_group_control(
                    Group_Control_Border::get_type(),
                    [
                        'name'     => 'exad_iconbox_icon_border_hover',
                        'selector' => '{{WRAPPER}} .exad-iconbox:hover .exad-iconbox-icon.yes',
                        'condition' => [
                            'exad_iconbox_enable' => 'yes'
                        ]
                    ]
				);
				
				$this->add_group_control(
                    Group_Control_Box_Shadow::get_type(),
                    [
                        'name' => 'exad_iconbox_icon_shadow_hover',
                        'label' => __( 'Box Shadow', 'exclusive-addons-elementor-pro' ),
                        'selector' => '{{WRAPPER}} .exad-iconbox:hover .exad-iconbox-icon.yes',
                        'condition' => [
                            'exad_iconbox_enable' => 'yes'
                        ]
                    ]
                );
				
			$this->end_controls_tab();
        $this->end_controls_tabs();

        $this->end_controls_section();
        
        /**
  		 * Icon Box Title Style
  		 */
  		$this->start_controls_section(
            'exad_section_iconbox_title',
            [
                'label' => esc_html__( 'Title', 'exclusive-addons-elementor-pro' ),
                'tab'       => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'exad_iconbox_title_typography',
				'selector' => '{{WRAPPER}} .exad-iconbox-title'
			]
		);

        $this->add_responsive_control(
			'exad_iconbox_title_margin',
			[
				'label' => __( 'Margin', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .exad-iconbox-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
			]
		);

        $this->start_controls_tabs( 'exad_iconbox_title_tabs' );
			// Normal State Tab
			$this->start_controls_tab( 'exad_iconbox_title_normal', [ 'label' => esc_html__( 'Normal', 'exclusive-addons-elementor-pro' ) ] );

				$this->add_control(
					'exad_iconbox_title_normal_color',
					[
						'label'     => esc_html__( 'Text Color', 'exclusive-addons-elementor-pro' ),
						'type'      => Controls_Manager::COLOR,
						'default'   => '#000000',
						'selectors' => [
							'{{WRAPPER}} .exad-iconbox-title' => 'color: {{VALUE}}'
						],
					]
				);

			$this->end_controls_tab();

			// Hover State Tab
			$this->start_controls_tab( 'exad_iconbox_title_hover', [ 'label' => esc_html__( 'Hover', 'exclusive-addons-elementor-pro' ) ] );

                $this->add_control(
                    'exad_iconbox_title_hover_color',
                    [
                        'label'     => esc_html__( 'Text Color', 'exclusive-addons-elementor-pro' ),
                        'type'      => Controls_Manager::COLOR,
                        'default'   => '#000',
                        'selectors' => [
                            '{{WRAPPER}} .exad-iconbox:hover .exad-iconbox-title' => 'color: {{VALUE}}'
                        ],
                    ]
                );
				
			$this->end_controls_tab();
        $this->end_controls_tabs();

        $this->end_controls_section();
        
        /**
  		 * Icon Box Discription Style
  		 */
  		$this->start_controls_section(
            'exad_section_iconbox_description',
            [
                'label' => esc_html__( 'Description', 'exclusive-addons-elementor-pro' ),
                'tab'       => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'exad_iconbox_description_typography',
				'selector' => '{{WRAPPER}} .exad-iconbox-description'
			]
		);

        $this->add_responsive_control(
			'exad_iconbox_description_margin',
			[
				'label' => __( 'Margin', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .exad-iconbox-description' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
			]
		);

        $this->start_controls_tabs( 'exad_iconbox_description_tabs' );
			// Normal State Tab
			$this->start_controls_tab( 'exad_iconbox_description_normal', [ 'label' => esc_html__( 'Normal', 'exclusive-addons-elementor-pro' ) ] );

				$this->add_control(
					'exad_iconbox_description_normal_color',
					[
						'label'     => esc_html__( 'Text Color', 'exclusive-addons-elementor-pro' ),
						'type'      => Controls_Manager::COLOR,
						'default'   => '#000000',
						'selectors' => [
							'{{WRAPPER}} .exad-iconbox-description' => 'color: {{VALUE}}'
						],
					]
				);

			$this->end_controls_tab();

			// Hover State Tab
			$this->start_controls_tab( 'exad_iconbox_description_hover', [ 'label' => esc_html__( 'Hover', 'exclusive-addons-elementor-pro' ) ] );

                $this->add_control(
                    'exad_iconbox_description_hover_color',
                    [
                        'label'     => esc_html__( 'Text Color', 'exclusive-addons-elementor-pro' ),
                        'type'      => Controls_Manager::COLOR,
                        'default'   => '#000000',
                        'selectors' => [
                            '{{WRAPPER}} .exad-iconbox:hover .exad-iconbox-description' => 'color: {{VALUE}}'
                        ],
                    ]
                );
				
			$this->end_controls_tab();
        $this->end_controls_tabs();

		$this->end_controls_section();
	}

	protected function render() {
        $settings      = $this->get_settings_for_display();

        if( $settings['exad_icon_box_url']['url'] ) {
            $this->add_render_attribute( 'exad_icon_box_url', 'href', esc_url( $settings['exad_icon_box_url']['url'] ) );
	        if( $settings['exad_icon_box_url']['is_external'] ) {
	            $this->add_render_attribute( 'exad_icon_box_url', 'target', '_blank' );
	        }
	        if( $settings['exad_icon_box_url']['nofollow'] ) {
	            $this->add_render_attribute( 'exad_icon_box_url', 'rel', 'nofollow' );
	        }
        }

        $this->add_render_attribute( 'exad_icon_box_url', 'class', 'exad-iconbox-wrapper' );

		?>
		

        <div class="exad-iconbox <?php echo $settings['exad_iconbox_alignment']; ?> <?php echo $settings['exad_icon_box_icon_position']; ?>">
            <?php if( !empty( $settings['exad_icon_box_url']['url'] ) ) { ?>
                <a <?php echo $this->get_render_attribute_string( 'exad_icon_box_url' ); ?>>
			<?php } ?>
				<?php if( $settings['exad_icon_box_label_switcher'] === 'yes' ) : ?>
					<span class="exad-iconbox-label">
						<?php echo $settings['exad_icon_box_label']; ?>
					</span>
				<?php endif; ?>
                <span class="exad-iconbox-icon <?php echo $settings['exad_iconbox_enable']; ?>">
                    <?php Icons_Manager::render_icon( $settings['exad_icon_box_icon'], [ 'aria-hidden' => 'true' ] ); ?>
                </span>
				<div class="exad-iconbox-content">
					<?php if( !empty( $settings['exad_icon_box_title']) ) { ?>
						<?php echo '<'.$settings['exad_icon_box_title_tag'].' class="exad-iconbox-title">'; ?>
							<?php echo wp_kses_post( $settings['exad_icon_box_title'] ); ?>
						<?php echo '</'.$settings['exad_icon_box_title_tag'].'>'; ?>
					<?php } ?>
					<?php if( !empty( $settings['exad_icon_box_description']) ) { ?>
						<p class="exad-iconbox-description">
							<?php echo wp_kses_post( $settings['exad_icon_box_description'] ); ?>
						</p>
					<?php } ?>
				</div>
            <?php if( !empty( $settings['exad_icon_box_url']['url'] ) ) { ?>
                </a>
            <?php } ?>
        </div>
		<?php 
	}

	protected function content_template() {

		?>
		<# var iconHTML = elementor.helpers.renderIcon( view, settings.exad_icon_box_icon, { 'aria-hidden': true }, 'i' , 'object' ) #>
        <# if( settings.exad_icon_box_url.url ) { #>
            <# view.addRenderAttribute( 'exad_icon_box_url', 'href', settings.exad_icon_box_url.url ) #>
	        <# if( settings.exad_icon_box_url.is_external ) { #>
	            <# view.addRenderAttribute( 'exad_icon_box_url', 'target', '_blank' ) #>
				<# } #>
			<# if( settings.exad_icon_box_url.nofollow ) { #>
	            <# view.addRenderAttribute( 'exad_icon_box_url', 'rel', 'nofollow' ) #>
			<# } #>
		<# } #>
        <# view.addRenderAttribute( 'exad_icon_box_url', 'class', 'exad-iconbox-wrapper' ) #>

        <div class="exad-iconbox {{ settings.exad_iconbox_alignment }} {{ settings.exad_icon_box_icon_position }}">
            <# if( settings.exad_icon_box_url.url ) { #>
                <a {{{ view.getRenderAttributeString( 'exad_icon_box_url' ) }}}>
			<# } #>
				<# if( settings.exad_icon_box_label_switcher === 'yes' ) { #>
					<span class="exad-iconbox-label">
						{{{ settings.exad_icon_box_label }}}
					</span>
				<# } #>
                <span class="exad-iconbox-icon {{ settings.exad_iconbox_enable }}">
					{{{ iconHTML.value }}}
                </span>
				<div class="exad-iconbox-content">
					<# if( settings.exad_icon_box_title ) { #>
						<{{ settings.exad_icon_box_title_tag }} class="exad-iconbox-title">
							{{{ settings.exad_icon_box_title }}}
						</{{ settings.exad_icon_box_title_tag }}>
					<# } #>
					<# if( settings.exad_icon_box_description ) { #>
						<p class="exad-iconbox-description">
							{{{ settings.exad_icon_box_description }}}
						</p>
					<# } #>
				</div>
            <# if( settings.exad_icon_box_url.url ) { #>
                </a>
			<# } #>
        </div>
		<?php
	}
}