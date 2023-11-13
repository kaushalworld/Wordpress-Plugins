<?php
namespace ExclusiveAddons\Elements;

if ( ! defined( 'ABSPATH' ) ) exit;
// If this file is called directly, abort.

use \Elementor\Controls_Manager;
use \Elementor\Widget_Base;
use \Elementor\Control_Media;
use \Elementor\Group_Control_Background;
use \Elementor\Group_Control_Image_Size;
use \Elementor\Group_Control_Border;
use \Elementor\Group_Control_Box_Shadow;
use \Elementor\Icons_Manager;

class Image_Carousel extends Widget_Base {
    public function get_categories() {
        return ['exclusive-addons-elementor'];
    }

    public function get_icon() {
        return 'exad exad-logo exad-image-carousel';
    }

    public function get_keywords() {
        return ['image', 'carousel', 'image-carousel'];
    }

    public function get_name() {
        return 'exad-image-carousel';
    }

    public function get_script_depends() {
        return ['exad-slick'];
    }

    public function get_title() {
        return esc_html__( 'Image Carousel', 'exclusive-addons-elementor-pro' );
    }

    protected function register_controls() {

        $exad_primary_color   = get_option( 'exad_primary_color_option', '#7a56ff' );

        $this->start_controls_section(
            'exad_image_carousel_content_section',
            [
                'label' => esc_html__( 'Contents', 'exclusive-addons-elementor-pro' ),
            ]
        );

        $this->add_control(
            'exad_image_carousel_gallery',
            [
                'label'   => __( 'Add Images', 'exclusive-addons-elementor-pro' ),
                'type'    => Controls_Manager::GALLERY,
                'default' => [],
                'dynamic' => [
					'active' => true,
				]
            ]
        );

        $this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name'      => 'thumbnail',
                'default'   => 'full'
			]
		);

        $this->end_controls_section();

        $this->start_controls_section(
            'exad_image_carousel_settings_section',
            [
                'label' => esc_html__( 'Settings', 'exclusive-addons-elementor-pro' ),
            ]
        );

        $this->add_control(
            'exad_image_carousel_oriantation',
            [
                'label'   => esc_html__( 'Carousel Oriantation', 'exclusive-addons-elementor-pro' ),
                'type'    => Controls_Manager::SELECT,
                'default' => 'horizontal',
                'options' => [
                    'horizontal' => esc_html__( 'Horizontal', 'exclusive-addons-elementor-pro' ),
                    'vertical'   => esc_html__( 'Vertical', 'exclusive-addons-elementor-pro' ),
                ],
            ]
        );

        $this->add_control(
            'exad_image_carousel_infinite_loop',
            [
                'label'        => __( 'Infinite Loop', 'exclusive-addons-elementor-pro' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => __( 'ON', 'exclusive-addons-elementor-pro' ),
                'label_off'    => __( 'OFF', 'exclusive-addons-elementor-pro' ),
                'return_value' => 'yes',
                'default'      => 'yes',
            ]
        );

        $this->add_control(
            'exad_image_carousel_nav',
            [
                'label'   => esc_html__( 'Navigation Style', 'exclusive-addons-elementor-pro' ),
                'type'    => Controls_Manager::SELECT,
                'default' => 'arrows',
                'options' => [
                    'arrows' => esc_html__( 'Arrows', 'exclusive-addons-elementor-pro' ),
                    'dots'   => esc_html__( 'Dots', 'exclusive-addons-elementor-pro' ),
                    'both'   => esc_html__( 'Arrows and Dots', 'exclusive-addons-elementor-pro' ),
                    'none'   => esc_html__( 'None', 'exclusive-addons-elementor-pro' ),
                ],
            ]
        );

        $this->add_control(
	        'exad_image_carousel_nav_arrow_previous_icon',
	        [
				'label'       => esc_html__( 'Previous Arrow Icon', 'exclusive-addons-elementor-pro' ),
				'type'        => Controls_Manager::ICONS,
				'default'     => [
	                'value'   => 'fas fa-chevron-left',
	                'library' => 'fa-solid'
	            ],
		      	'condition'   => [
	                'exad_image_carousel_nav' => [ 'arrows', 'both' ]
	            ]
	        ]
        );
        
        $this->add_control(
	        'exad_image_carousel_nav_arrow_next_icon',
	        [
				'label'       => esc_html__( 'Next Arrow Icon', 'exclusive-addons-elementor-pro' ),
				'type'        => Controls_Manager::ICONS,
				'default'     => [
	                'value'   => 'fas fa-chevron-right',
	                'library' => 'fa-solid'
	            ],
		      	'condition'   => [
	                'exad_image_carousel_nav' => [ 'arrows', 'both' ]
	            ]
	        ]
	    );

        $this->add_control(
            'exad_image_carousel_nav_dot_type',
            [
                'label'   => esc_html__( 'Dots Type', 'exclusive-addons-elementor-pro' ),
                'type'    => Controls_Manager::SELECT,
                'default' => 'bullet',
                'options' => [
                    'bullet' => esc_html__( 'Bullet', 'exclusive-addons-elementor-pro' ),
                    'image'   => esc_html__( 'Image', 'exclusive-addons-elementor-pro' ),
                ],
                'condition' => [
                    'exad_image_carousel_nav' => [ 'dots', 'both' ]
                ]
            ]
        );

        $slides_per_view = range( 1, 6 );
        $slides_per_view = array_combine( $slides_per_view, $slides_per_view );

        $this->add_responsive_control(
            'exad_image_carousel_slide_to_show',
            [
                'type'    => Controls_Manager::SELECT,
                'label'   => esc_html__( 'Columns', 'exclusive-addons-elementor-pro' ),
                'options' => $slides_per_view,
                'default' => '3',
                'tablet_default' => '2',
				'mobile_default' => '1',
            ]
        );

        $this->add_control(
            'exad_image_carousel_slides_to_scroll',
            [
                'type'    => Controls_Manager::SELECT,
                'label'   => esc_html__( 'Items to Scroll', 'exclusive-addons-elementor-pro' ),
                'options' => $slides_per_view,
                'default' => '1',
            ]
        );

        $this->add_control(
            'exad_image_carousel_autoplay',
            [
                'label'        => __( 'Autoplay', 'exclusive-addons-elementor-pro' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => __( 'ON', 'exclusive-addons-elementor-pro' ),
                'label_off'    => __( 'OFF', 'exclusive-addons-elementor-pro' ),
                'return_value' => 'yes',
                'default'      => 'yes',
            ]
        );
        
        $this->add_control(
			'exad_image_carousel_autoplay_speed',
			[
				'label'     => esc_html__( 'Autoplay Speed', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 5000,
				'condition' => [
					'exad_image_carousel_autoplay' => 'yes'
				]
			]
		);

        $this->end_controls_section();

        $this->start_controls_section(
            'exad_image_carousel_advance_settings_section',
            [
                'label' => esc_html__( 'Advance Settings', 'exclusive-addons-elementor-pro' ),
            ]
        );

        $this->add_control(
            'exad_image_carousel_fade',
            [
                'label'        => __( 'Fade', 'exclusive-addons-elementor-pro' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => __( 'ON', 'exclusive-addons-elementor-pro' ),
                'label_off'    => __( 'OFF', 'exclusive-addons-elementor-pro' ),
                'return_value' => 'yes',
                'default'      => 'no',
            ]
        );

        $this->add_control(
            'exad_image_carousel_center_mode',
            [
                'label'        => __( 'Center Mode', 'exclusive-addons-elementor-pro' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => __( 'ON', 'exclusive-addons-elementor-pro' ),
                'label_off'    => __( 'OFF', 'exclusive-addons-elementor-pro' ),
                'return_value' => 'yes',
                'default'      => 'no',
            ]
        );

        $this->add_control(
			'exad_image_carousel_center_padding',
			[
				'label'     => esc_html__( 'Center Padding', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 30,
				'condition' => [
					'exad_image_carousel_center_mode' => 'yes'
				]
			]
        );

        $this->start_controls_tabs( 'exad_image_carousel_advance_tab' );

			// normal state rating
			$this->start_controls_tab( 'exad_image_carousel_advance_tab_inactive', [ 'label' => esc_html__( 'Inactive', 'exclusive-addons-elementor-pro' ) ] );

				$this->add_control(
					'exad_image_carousel_advance_inactive_opacity',
					[
						'label'     => __( 'Inactive Item Opacity', 'exclusive-addons-elementor-pro' ),
						'type'      => Controls_Manager::NUMBER,
						'min'       => 0,
                        'max'       => 1,
                        'step'      => .1,
						'selectors' => [
							'{{WRAPPER}} .exad-image-carousel-item.slick-slide' => 'opacity: {{VALUE}};'
						]
					]
				);

				$this->add_control(
					'exad_image_carousel_advance_inactive_scale',
					[
						'label'     => __( 'Scale', 'exclusive-addons-elementor-pro' ),
						'type'      => Controls_Manager::NUMBER,
						'min'       => 0,
                        'max'       => 3,
                        'step'      => .1,
						'selectors' => [
							'{{WRAPPER}} .exad-image-carousel-item.slick-slide' => 'transform: scale( {{VALUE}} );'
						]
					]
				);

			$this->end_controls_tab();

			// hover state rating
			$this->start_controls_tab( 'exad_image_carousel_advance_tab_active', [ 'label' => esc_html__( 'Active', 'exclusive-addons-elementor-pro' ) ] );

				$this->add_control(
					'exad_image_carousel_advance_active_opacity',
					[
						'label'     => __( 'Active Item Opacity', 'exclusive-addons-elementor-pro' ),
						'type'      => Controls_Manager::NUMBER,
						'min'       => 0,
                        'max'       => 1,
                        'step'      => .1,
						'default'   => '1',
						'selectors' => [
							'{{WRAPPER}} .exad-image-carousel-item.slick-slide.slick-current.slick-active' => 'opacity: {{VALUE}};'
						]
					]
				);

				$this->add_control(
					'exad_image_carousel_advance_active_scale',
					[
						'label'     => __( 'Scale', 'exclusive-addons-elementor-pro' ),
						'type'      => Controls_Manager::NUMBER,
						'min'       => 0,
                        'max'       => 3,
                        'step'      => .1,
						'default'   => '1',
						'selectors' => [
							'{{WRAPPER}} .exad-image-carousel-item.slick-slide.slick-current.slick-active' => 'transform: scale( {{VALUE}} );'
						]
					]
				);

			$this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();

        $this->start_controls_section(
            'exad_image_carousel_style_section',
            [
                'label' => esc_html__( 'Container', 'exclusive-addons-elementor-pro' ),
                'tab'   => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_responsive_control(
			'exad_image_carousel_container_margin',
			[
				'label'      => __( 'Margin', 'exclusive-addons-elementor-pro' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'default'    => [
					'top'    => '0',
					'right'  => '0',
					'bottom' => '0',
                    'left'   => '0',
                    'unit'   => 'px'
				],
				'selectors'  => [
					'{{WRAPPER}} .exad-image-carousel-slider' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'exad_image_carousel_image_style_section',
            [
                'label' => esc_html__( 'Image', 'exclusive-addons-elementor-pro' ),
                'tab'   => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_responsive_control(
			'exad_image_carousel_image_height',
			[
				'label' => __( 'Image Height', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 2000,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .exad-image-carousel-item' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
        );

        $this->add_responsive_control(
			'exad_image_carousel_image_padding',
			[
				'label'      => __( 'Padding', 'exclusive-addons-elementor-pro' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'default'    => [
					'top'    => '0',
					'right'  => '0',
					'bottom' => '0',
                    'left'   => '0',
                    'unit' => 'px',
				],
				'selectors'  => [
					'{{WRAPPER}} .exad-image-carousel-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
        );

        $this->add_responsive_control(
			'exad_image_carousel_image_margin',
			[
				'label'      => __( 'Margin', 'exclusive-addons-elementor-pro' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'default'    => [
					'top'    => '10',
					'right'  => '10',
					'bottom' => '10',
                    'left'   => '10',
                    'unit' => 'px',
				],
				'selectors'  => [
					'{{WRAPPER}} .exad-image-carousel-item' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'exad_image_carousel_image_border',
                'label' => __( 'Border', 'exclusive-addons-elementor-pro' ),
                'selector' => '{{WRAPPER}} .exad-image-carousel-item',
            ]
        );

        $this->add_responsive_control(
			'exad_image_carousel_image_border_radius',
			[
				'label'      => __( 'Border Radius', 'exclusive-addons-elementor-pro' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'default'    => [
					'top'    => '0',
					'right'  => '0',
					'bottom' => '0',
                    'left'   => '0',
                    'unit' => 'px',
				],
				'selectors'  => [
					'{{WRAPPER}} .exad-image-carousel-item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				]
			]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'exad_image_carousel_image_shadow',
                'label' => __( 'Box Shadow', 'exclusive-addons-elementor-pro' ),
                'selector' => '{{WRAPPER}} .exad-image-carousel-item',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'exad_image_carousel_nav_arrow',
            [
                'label' => esc_html__( 'Arrows', 'exclusive-addons-elementor-pro' ),
                'tab'   => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'exad_image_carousel_nav' => [ 'arrows', 'both' ]
                ]
            ]
        );

        $this->add_responsive_control(
			'exad_image_carousel_nav_arrow_box_height',
			[
				'label' => __( 'Box Height', 'exclusive-addons-elementor-pro' ),
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
					'size' => 50,
				],
				'selectors' => [
					'{{WRAPPER}} .exad-image-carousel-prev' => 'height: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .exad-image-carousel-next' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
        );

        $this->add_responsive_control(
			'exad_image_carousel_nav_arrow_box_width',
			[
				'label' => __( 'Box Width', 'exclusive-addons-elementor-pro' ),
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
					'size' => 50,
				],
				'selectors' => [
					'{{WRAPPER}} .exad-image-carousel-prev' => 'width: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .exad-image-carousel-next' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
        );

        $this->add_responsive_control(
			'exad_image_carousel_nav_arrow_icon_size',
			[
				'label' => __( 'Icon Size', 'exclusive-addons-elementor-pro' ),
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
					'size' => 16,
				],
				'selectors' => [
					'{{WRAPPER}} .exad-image-carousel-prev i' => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .exad-image-carousel-next i' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
        );
        
        $this->add_control(
			'exad_image_carousel_prev_arrow_position',
			[
				'label' => __( 'Previous Arrow Position', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::POPOVER_TOGGLE,
				'label_off' => __( 'Default', 'exclusive-addons-elementor-pro' ),
				'label_on' => __( 'Custom', 'exclusive-addons-elementor-pro' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
        );
        
        $this->start_popover();

            $this->add_responsive_control(
                'exad_image_carousel_prev_arrow_position_x_offset',
                [
                    'label' => __( 'X Offset', 'exclusive-addons-elementor-pro' ),
                    'type' => Controls_Manager::SLIDER,
                    'size_units' => [ 'px', '%' ],
                    'range' => [
                        'px' => [
                            'min' => -1000,
                            'max' => 1000,
                        ],
                        '%' => [
                            'min' => -100,
                            'max' => 100,
                        ],
                    ],
                    'default' => [
                        'unit' => 'px',
                        'size' => 30,
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .exad-image-carousel-prev' => 'left: {{SIZE}}{{UNIT}};',
                    ],
                ]
            );

            $this->add_responsive_control(
                'exad_image_carousel_prev_arrow_position_y_offset',
                [
                    'label' => __( 'Y Offset', 'exclusive-addons-elementor-pro' ),
                    'type' => Controls_Manager::SLIDER,
                    'size_units' => [ 'px', '%' ],
                    'range' => [
                        'px' => [
                            'min' => -1000,
                            'max' => 1000,
                        ],
                        '%' => [
                            'min' => -100,
                            'max' => 100,
                        ],
                    ],
                    'default' => [
                        'unit' => '%',
                        'size' => 50,
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .exad-image-carousel-prev' => 'top: {{SIZE}}{{UNIT}};',
                    ],
                ]
            );

        $this->end_popover();

        $this->add_control(
			'exad_image_carousel_next_arrow_position',
			[
				'label' => __( 'Next Arrow Position', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::POPOVER_TOGGLE,
				'label_off' => __( 'Default', 'exclusive-addons-elementor-pro' ),
				'label_on' => __( 'Custom', 'exclusive-addons-elementor-pro' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
        );
        
        $this->start_popover();

            $this->add_responsive_control(
                'exad_image_carousel_next_arrow_position_x_offset',
                [
                    'label' => __( 'X Offset', 'exclusive-addons-elementor-pro' ),
                    'type' => Controls_Manager::SLIDER,
                    'size_units' => [ 'px', '%' ],
                    'range' => [
                        'px' => [
                            'min' => -1000,
                            'max' => 1000,
                        ],
                        '%' => [
                            'min' => -100,
                            'max' => 100,
                        ],
                    ],
                    'default' => [
                        'unit' => 'px',
                        'size' => 30,
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .exad-image-carousel-next' => 'right: {{SIZE}}{{UNIT}};',
                    ],
                ]
            );

            $this->add_responsive_control(
                'exad_image_carousel_next_arrow_position_y_offset',
                [
                    'label' => __( 'Y Offset', 'exclusive-addons-elementor-pro' ),
                    'type' => Controls_Manager::SLIDER,
                    'size_units' => [ 'px', '%' ],
                    'range' => [
                        'px' => [
                            'min' => -1000,
                            'max' => 1000,
                        ],
                        '%' => [
                            'min' => -100,
                            'max' => 100,
                        ],
                    ],
                    'default' => [
                        'unit' => '%',
                        'size' => 50,
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .exad-image-carousel-next' => 'top: {{SIZE}}{{UNIT}};',
                    ],
                ]
            );

        $this->end_popover();

        $this->add_responsive_control(
			'exad_image_carousel_nav_arrow_radius',
			[
				'label' => __( 'Border radius', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'default' => [
                    'top' => '0',
                    'right' => '0',
                    'bottom' => '0',
                    'left' => '0',
                    'unit' => 'px',
                    'isLinked' => true,
                ],
				'selectors' => [
					'{{WRAPPER}} .exad-image-carousel-prev' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .exad-image-carousel-next' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				],
			]
		);

        $this->start_controls_tabs( 'exad_image_carousel_nav_arrow_tabs' );

			// normal state rating
			$this->start_controls_tab( 'exad_image_carousel_nav_arrow_normal', [ 'label' => esc_html__( 'Normal', 'exclusive-addons-elementor-pro' ) ] );

                $this->add_group_control(
                    Group_Control_Background::get_type(),
                    [
                        'name' => 'exad_image_carousel_arrow_normal_background',
                        'label' => __( 'Background', 'exclusive-addons-elementor-pro' ),
                        'types' => [ 'classic', 'gradient' ],
                        'selector' => '{{WRAPPER}} .exad-image-carousel-prev, {{WRAPPER}} .exad-image-carousel-next'
                    ]
                );

                $this->add_control(
                    'exad_image_carousel_arrow_normal_color',
                    [
                        'label' => __( 'Icon Color', 'exclusive-addons-elementor-pro' ),
                        'type' => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .exad-image-carousel-prev i' => 'color: {{VALUE}};',
                            '{{WRAPPER}} .exad-image-carousel-next i' => 'color: {{VALUE}};',
                        ],
                    ]
                );

                $this->add_group_control(
                    Group_Control_Border::get_type(),
                    [
                        'name' => 'exad_image_carousel_arrow_normal_border',
                        'label' => __( 'Border', 'exclusive-addons-elementor-pro' ),
                        'selector' => '{{WRAPPER}} .exad-image-carousel-prev, {{WRAPPER}} .exad-image-carousel-next',
                    ]
                );

                $this->add_group_control(
                    Group_Control_Box_Shadow::get_type(),
                    [
                        'name' => 'exad_image_carousel_arrow_normal_shadow',
                        'label' => __( 'Box Shadow', 'exclusive-addons-elementor-pro' ),
                        'selector' => '{{WRAPPER}} .exad-image-carousel-prev, {{WRAPPER}} .exad-image-carousel-next',
                    ]
                );

			$this->end_controls_tab();

			// hover state rating
			$this->start_controls_tab( 'exad_image_carousel_nav_arrow_hover', [ 'label' => esc_html__( 'Hover', 'exclusive-addons-elementor-pro' ) ] );

                $this->add_group_control(
                    Group_Control_Background::get_type(),
                    [
                        'name' => 'exad_image_carousel_arrow_hover_background',
                        'label' => __( 'Background', 'exclusive-addons-elementor-pro' ),
                        'types' => [ 'classic', 'gradient' ],
                        'selector' => '{{WRAPPER}} .exad-image-carousel-prev:hover, {{WRAPPER}} .exad-image-carousel-next:hover'
                    ]
                );

                $this->add_control(
                    'exad_image_carousel_arrow_hover_color',
                    [
                        'label' => __( 'Icon Color', 'exclusive-addons-elementor-pro' ),
                        'type' => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .exad-image-carousel-prev:hover i' => 'color: {{VALUE}}',
                            '{{WRAPPER}} .exad-image-carousel-next:hover i' => 'color: {{VALUE}}',
                        ],
                    ]
                );

                $this->add_group_control(
                    Group_Control_Border::get_type(),
                    [
                        'name' => 'exad_image_carousel_arrow_hover_border',
                        'label' => __( 'Border', 'exclusive-addons-elementor-pro' ),
                        'selector' => '{{WRAPPER}} .exad-image-carousel-prev:hover, {{WRAPPER}} .exad-image-carousel-next:hover',
                    ]
                );

                $this->add_group_control(
                    Group_Control_Box_Shadow::get_type(),
                    [
                        'name' => 'exad_image_carousel_arrow_hover_shadow',
                        'label' => __( 'Box Shadow', 'exclusive-addons-elementor-pro' ),
                        'selector' => '{{WRAPPER}} .exad-image-carousel-prev:hover, {{WRAPPER}} .exad-image-carousel-next:hover',
                    ]
                );

			$this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();

        $this->start_controls_section(
            'exad_image_carousel_nav_dot',
            [
                'label' => esc_html__( 'Dots/Thumb', 'exclusive-addons-elementor-pro' ),
                'tab'   => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'exad_image_carousel_nav' => [ 'dots', 'both' ]
                ]
            ]
        );

        $this->add_control(
			'exad_image_carousel_nav_dot_position',
			[
				'label' => __( 'Dot Image Position', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'exad-image-carousel-dots-image-left' => [
						'title' => __( 'Left', 'exclusive-addons-elementor-pro' ),
						'icon' => 'eicon-h-align-left',
					],
					'exad-image-carousel-dots-image-bottom' => [
						'title' => __( 'Bottom', 'exclusive-addons-elementor-pro' ),
						'icon' => 'eicon-v-align-bottom',
					],
					'exad-image-carousel-dots-image-right' => [
						'title' => __( 'Right', 'exclusive-addons-elementor-pro' ),
						'icon' => 'eicon-h-align-right',
					],
				],
                'default' => 'exad-image-carousel-dots-image-bottom',
                'condition' => [
                    'exad_image_carousel_nav_dot_type' => 'image',
                ]
			]
        );

        $this->add_control(
			'exad_image_carousel_nav_dot_image_alignment',
			[
				'label' => __( 'Alignment', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'exad-image-carousel-dots-image-left' => [
						'title' => __( 'Left', 'exclusive-addons-elementor-pro' ),
						'icon' => 'fa fa-align-left',
					],
					'exad-image-carousel-dots-image-center' => [
						'title' => __( 'Center', 'exclusive-addons-elementor-pro' ),
						'icon' => 'fa fa-align-center',
					],
					'exad-image-carousel-dots-image-right' => [
						'title' => __( 'Right', 'exclusive-addons-elementor-pro' ),
						'icon' => 'fa fa-align-right',
					],
					'exad-image-carousel-dots-image-justify' => [
						'title' => __( 'Right', 'exclusive-addons-elementor-pro' ),
						'icon' => 'fa fa-align-justify',
					],
				],
                'default' => 'exad-image-carousel-dots-image-center',
                'condition' => [
                    'exad_image_carousel_nav_dot_type' => 'image',
                    '!exad_image_carousel_nav_dot_position' => 'exad-image-carousel-dots-image-bottom',
                ]
			]
        );
        
        $this->add_responsive_control(
            'exad_image_carousel_dots_image_width',
            [
                'label' => __( 'Width', 'exclusive-addons-elementor-pro' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 300,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 100,
                ],
                'selectors' => [
                    '{{WRAPPER}} .exad-image-carousel-slider .slick-dots li a' => 'width: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'exad_image_carousel_nav_dot_type' => 'image',
                    'exad_image_carousel_nav_dot_image_alignment!' => 'exad-image-carousel-dots-image-justify',
                    'exad_image_carousel_nav_dot_position' => [ 'exad-image-carousel-dots-image-bottom' ]
                ]
            ]
        );

        $this->add_responsive_control(
            'exad_image_carousel_dots_image_container_width',
            [
                'label' => __( 'Dot Container Width', 'exclusive-addons-elementor-pro' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%' ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 500,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 80,
                    ],
                ],
                'default' => [
                    'unit' => '%',
                    'size' => 20,
                ],
                'selectors' => [
                    '{{WRAPPER}} .exad-image-carousel-wrapper.exad-image-carousel-dots-image-right .exad-image-carousel-slider .slick-dots' => 'width: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .exad-image-carousel-wrapper.exad-image-carousel-dots-image-left .exad-image-carousel-slider .slick-dots' => 'width: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .exad-image-carousel-wrapper.exad-image-carousel-dots-image-right .exad-image-carousel-slider .slick-list' => 'width: calc( 100% - {{SIZE}}{{UNIT}} );',
                ],
                'condition' => [
                    'exad_image_carousel_nav_dot_type' => 'image',
                    'exad_image_carousel_nav_dot_position' => [ 'exad-image-carousel-dots-image-left', 'exad-image-carousel-dots-image-right']
                ]
            ]
        );

        $this->add_responsive_control(
            'exad_image_carousel_dots_image_container_height',
            [
                'label' => __( 'Dot Container Height', 'exclusive-addons-elementor-pro' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%' ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .exad-image-carousel-wrapper.exad-image-carousel-dots-image-right .exad-image-carousel-slider .slick-dots' => 'height: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .exad-image-carousel-wrapper.exad-image-carousel-dots-image-left .exad-image-carousel-slider .slick-dots' => 'height: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'exad_image_carousel_nav_dot_type' => 'image',
                    'exad_image_carousel_nav_dot_position' => [ 'exad-image-carousel-dots-image-left', 'exad-image-carousel-dots-image-right']
                ]
            ]
        );

        $this->add_responsive_control(
			'exad_image_carousel_dots_image_item_margin',
			[
				'label' => __( 'Dot Item Margin', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'default' => [
                    'top' => '10',
                    'right' => '0',
                    'bottom' => '10',
                    'left' => '0',
                    'unit' => 'px',
                    'isLinked' => true,
                ],
				'selectors' => [
					'{{WRAPPER}} .exad-image-carousel-wrapper.exad-image-carousel-dots-image-left .exad-image-carousel-slider .slick-dots li' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .exad-image-carousel-wrapper.exad-image-carousel-dots-image-right .exad-image-carousel-slider .slick-dots li' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .exad-image-carousel-slider .slick-dots li:not(:last-child)' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
			]
        );
        
        $this->add_responsive_control(
            'exad_image_carousel_dots_image_height',
            [
                'label' => __( 'Height', 'exclusive-addons-elementor-pro' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 300,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 100,
                ],
                'selectors' => [
                    '{{WRAPPER}} .exad-image-carousel-slider .slick-dots li a' => 'height: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'exad_image_carousel_nav_dot_type' => 'image'
                ]
            ]
        );

        $this->add_control(
			'exad_image_carousel_dots_spacing',
			[
				'label' => __( 'Position', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::POPOVER_TOGGLE,
				'label_off' => __( 'Default', 'exclusive-addons-elementor-pro' ),
				'label_on' => __( 'Custom', 'exclusive-addons-elementor-pro' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
        );
        
        $this->start_popover();

            $this->add_responsive_control(
                'exad_image_carousel_dots_top_spacing',
                [
                    'label' => __( 'Top Margin', 'exclusive-addons-elementor-pro' ),
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
                        '{{WRAPPER}} .exad-image-carousel-slider .slick-dots' => 'margin-top: {{SIZE}}{{UNIT}};',
                    ],
                    'condition' => [
                        'exad_image_carousel_nav_dot_type' => 'image'
                    ]
                ]
            );

            $this->add_responsive_control(
                'exad_image_carousel_dots_image_left_spacing',
                [
                    'label' => __( 'Left Margin', 'exclusive-addons-elementor-pro' ),
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
                        '{{WRAPPER}} .exad-image-carousel-slider .slick-dots' => 'margin-left: {{SIZE}}{{UNIT}};',
                    ],
                    'condition' => [
                        'exad_image_carousel_nav_dot_type' => 'image'
                    ]
                ]
            );

            $this->add_responsive_control(
                'exad_image_carousel_dots_image_right_spacing',
                [
                    'label' => __( 'Right Margin', 'exclusive-addons-elementor-pro' ),
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
                        '{{WRAPPER}} .exad-image-carousel-slider .slick-dots' => 'margin-right: {{SIZE}}{{UNIT}};',
                    ],
                    'condition' => [
                        'exad_image_carousel_nav_dot_type' => 'image'
                    ]
                ]
            );

            $this->add_responsive_control(
                'exad_image_carousel_dots_left_spacing',
                [
                    'label' => __( 'X Offset', 'exclusive-addons-elementor-pro' ),
                    'type' => Controls_Manager::SLIDER,
                    'size_units' => [ 'px', '%' ],
                    'range' => [
                        'px' => [
                            'min' => -1000,
                            'max' => 1000,
                        ],
                        '%' => [
                            'min' => -100,
                            'max' => 100,
                        ],
                    ],
                    'default' => [
                        'unit' => '%',
                        'size' => 50,
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .exad-image-carousel-slider.exad-image-carousel-dot-bullet .slick-dots' => 'left: {{SIZE}}{{UNIT}};',
                    ],
                    'condition' => [
                        'exad_image_carousel_nav_dot_type' => 'bullet'
                    ]
                ]
            );

            $this->add_responsive_control(
                'exad_image_carousel_dots_right_spacing',
                [
                    'label' => __( 'Y Offset', 'exclusive-addons-elementor-pro' ),
                    'type' => Controls_Manager::SLIDER,
                    'size_units' => [ 'px', '%' ],
                    'range' => [
                        'px' => [
                            'min' => -500,
                            'max' => 500,
                        ],
                        '%' => [
                            'min' => -100,
                            'max' => 100,
                        ],
                    ],
                    'default' => [
                        'unit' => 'px',
                        'size' => 0,
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .exad-image-carousel-slider.exad-image-carousel-dot-bullet .slick-dots' => 'bottom: {{SIZE}}{{UNIT}};',
                    ],
                    'condition' => [
                        'exad_image_carousel_nav_dot_type' => 'bullet'
                    ]
                ]
            );

        $this->end_popover();

        $this->add_responsive_control(
			'exad_image_carousel_nav_dot_radius',
			[
				'label' => __( 'Border Radius', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'default' => [
                    'top' => '0',
                    'right' => '0',
                    'bottom' => '0',
                    'left' => '0',
                    'unit' => 'px',
                    'isLinked' => true,
                ],
				'selectors' => [
					'{{WRAPPER}} .exad-image-carousel-slider .slick-dots li' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .exad-image-carousel-slider .slick-dots li a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
        );
        
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'exad_image_carousel_dots_image_border',
                'label' => __( 'Border', 'exclusive-addons-elementor-pro' ),
                'selector' => '{{WRAPPER}} .exad-image-carousel-slider .slick-dots li a',
                'condition' => [
                    'exad_image_carousel_nav_dot_type' => 'image'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'exad_image_carousel_dots_image_shadow',
                'label' => __( 'Box Shadow', 'exclusive-addons-elementor-pro' ),
                'selector' => '{{WRAPPER}} .exad-image-carousel-slider .slick-dots li a',
                'condition' => [
                    'exad_image_carousel_nav_dot_type' => 'image'
                ]
            ]
        );

        $this->start_controls_tabs( 'exad_image_carousel_nav_dots_image_tabs',[ 'condition' => [ 'exad_image_carousel_nav_dot_type' => 'image'] ] );

			// normal state rating
            $this->start_controls_tab( 'exad_image_carousel_nav_dots_image_normal', [ 'label' => esc_html__( 'Normal', 'exclusive-addons-elementor-pro' ) ] );

                $this->add_responsive_control(
                    'exad_image_carousel_nav_dots_image_normal_blur',
                    [
                        'label' => __( 'Blur', 'exclusive-addons-elementor-pro' ),
                        'type' => Controls_Manager::SLIDER,
                        'size_units' => [ 'px' ],
                        'range' => [
                            'px' => [
                                'min' => 0,
                                'max' => 20,
                            ],
                        ],
                        'default' => [
                            'unit' => 'px',
                            'size' => 0,
                        ],
                        'selectors' => [
                            '{{WRAPPER}} .exad-image-carousel-slider .slick-dots li a' => 'filter: blur({{SIZE}}{{UNIT}}); -webkit-filter: blur({{SIZE}}{{UNIT}});',
                        ],
                    ]
                );

                $this->add_control(
					'exad_image_carousel_nav_dots_image_normal_opacity',
					[
						'label'     => __( 'Opacity', 'exclusive-addons-elementor-pro' ),
						'type'      => Controls_Manager::NUMBER,
						'min'       => 0,
						'max'       => 1,
						'selectors' => [
							'{{WRAPPER}} .exad-image-carousel-slider .slick-dots li a' => 'opacity: {{VALUE}};'
						]
					]
				);

			$this->end_controls_tab();

			// hover state rating
            $this->start_controls_tab( 'exad_image_carousel_nav_dots_image_hover', [ 'label' => esc_html__( 'active', 'exclusive-addons-elementor-pro' ) ] );

                $this->add_responsive_control(
                    'exad_image_carousel_nav_dots_image_active_blur',
                    [
                        'label' => __( 'Blur', 'exclusive-addons-elementor-pro' ),
                        'type' => Controls_Manager::SLIDER,
                        'size_units' => [ 'px' ],
                        'range' => [
                            'px' => [
                                'min' => 0,
                                'max' => 20,
                            ],
                        ],
                        'default' => [
                            'unit' => 'px',
                            'size' => 0,
                        ],
                        'selectors' => [
                            '{{WRAPPER}} .exad-image-carousel-slider .slick-dots li.slick-active a' => 'filter: blur({{SIZE}}{{UNIT}}); -webkit-filter: blur({{SIZE}}{{UNIT}});',
                        ],
                    ]
                );

                $this->add_control(
					'exad_image_carousel_nav_dots_image_active_opacity',
					[
						'label'     => __( 'Opacity', 'exclusive-addons-elementor-pro' ),
						'type'      => Controls_Manager::NUMBER,
						'min'       => 0,
						'max'       => 1,
						'selectors' => [
							'{{WRAPPER}} .exad-image-carousel-slider .slick-dots li.slick-active a' => 'opacity: {{VALUE}};'
						]
					]
				);

			$this->end_controls_tab();

        $this->end_controls_tabs();

        $this->start_controls_tabs( 'exad_image_carousel_nav_dots_tabs',[ 'condition' => [ 'exad_image_carousel_nav_dot_type' => 'bullet'] ] );

			// normal state rating
            $this->start_controls_tab( 'exad_image_carousel_nav_dots_normal', [ 'label' => esc_html__( 'Normal', 'exclusive-addons-elementor-pro' ) ] );
            
                $this->add_responsive_control(
                    'exad_image_carousel_dots_normal_width',
                    [
                        'label' => __( 'Width', 'exclusive-addons-elementor-pro' ),
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
                            'size' => 10,
                        ],
                        'selectors' => [
                            '{{WRAPPER}} .exad-image-carousel-slider .slick-dots li' => 'width: {{SIZE}}{{UNIT}};',
                        ],
                    ]
                );
                
                $this->add_responsive_control(
                    'exad_image_carousel_dots_normal_height',
                    [
                        'label' => __( 'Height', 'exclusive-addons-elementor-pro' ),
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
                            'size' => 10,
                        ],
                        'selectors' => [
                            '{{WRAPPER}} .exad-image-carousel-slider .slick-dots li' => 'height: {{SIZE}}{{UNIT}};',
                        ],
                    ]
                );

                $this->add_control(
                    'exad_image_carousel_dots_normal_background',
                    [
                        'label' => __( 'Background Color', 'exclusive-addons-elementor-pro' ),
                        'type' => Controls_Manager::COLOR,
                        'default' => '#e5e5e5',
                        'selectors' => [
                            '{{WRAPPER}} .exad-image-carousel-slider .slick-dots li' => 'background: {{VALUE}};',
                        ],
                    ]
                );

                $this->add_group_control(
                    Group_Control_Border::get_type(),
                    [
                        'name' => 'exad_image_carousel_dots_normal_border',
                        'label' => __( 'Border', 'exclusive-addons-elementor-pro' ),
                        'selector' => '{{WRAPPER}} .exad-image-carousel-slider .slick-dots li',
                    ]
                );

			$this->end_controls_tab();

			// hover state rating
            $this->start_controls_tab( 'exad_image_carousel_nav_dots_hover', [ 'label' => esc_html__( 'Hover/active', 'exclusive-addons-elementor-pro' ) ] );
            
                $this->add_responsive_control(
                    'exad_image_carousel_dots_active_width',
                    [
                        'label' => __( 'Width', 'exclusive-addons-elementor-pro' ),
                        'type' => Controls_Manager::SLIDER,
                        'size_units' => [ 'px', '%' ],
                        'range' => [
                            'px' => [
                                'min' => 0,
                                'max' => 100,
                            ],
                        ],
                        'default' => [
                            'unit' => 'px',
                            'size' => 10,
                        ],
                        'selectors' => [
                            '{{WRAPPER}} .exad-image-carousel-slider .slick-dots li.slick-active' => 'width: {{SIZE}}{{UNIT}};',
                        ],
                    ]
                );
                
                $this->add_responsive_control(
                    'exad_image_carousel_dots_active_height',
                    [
                        'label' => __( 'Height', 'exclusive-addons-elementor-pro' ),
                        'type' => Controls_Manager::SLIDER,
                        'size_units' => [ 'px', '%' ],
                        'range' => [
                            'px' => [
                                'min' => 0,
                                'max' => 100,
                            ],
                        ],
                        'default' => [
                            'unit' => 'px',
                            'size' => 10,
                        ],
                        'selectors' => [
                            '{{WRAPPER}} .exad-image-carousel-slider .slick-dots li.slick-active' => 'height: {{SIZE}}{{UNIT}};',
                        ],
                    ]
                );

                $this->add_control(
                    'exad_image_carousel_dots_active_background',
                    [
                        'label' => __( 'Background Color', 'exclusive-addons-elementor-pro' ),
                        'type' => Controls_Manager::COLOR,
                        'default' => $exad_primary_color,
                        'selectors' => [
                            '{{WRAPPER}} .exad-image-carousel-slider .slick-dots li.slick-active' => 'background: {{VALUE}};',
                            '{{WRAPPER}} .exad-image-carousel-slider .slick-dots li:hover' => 'background: {{VALUE}};',
                        ],
                    ]
                );

                $this->add_group_control(
                    Group_Control_Border::get_type(),
                    [
                        'name' => 'exad_image_carousel_dots_active_border',
                        'label' => __( 'Border', 'exclusive-addons-elementor-pro' ),
                        'selector' => '{{WRAPPER}} .exad-image-carousel-slider .slick-dots li.slick-active, {{WRAPPER}} .exad-image-carousel-slider .slick-dots li:hover',
                    ]
                );

			$this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();

    }

    protected function render() {
        $settings = $this->get_settings_for_display();

        $this->add_render_attribute(
            'exad_image_carousel_slider',
            [
                'class'                 => ['exad-image-carousel-slider', $settings['exad_image_carousel_nav_dot_image_alignment'], 'exad-image-carousel-dot-'.$settings['exad_image_carousel_nav_dot_type'] ],
                'data-slides_to_scroll' => intval( esc_attr( $settings['exad_image_carousel_slides_to_scroll'] ) ),
                'data-slides_to_show'   => intval( esc_attr( $settings['exad_image_carousel_slide_to_show'] ) ),
                'data-slides_to_show_tablet'   => intval( esc_attr( isset( $settings['exad_image_carousel_slide_to_show_tablet'] ) ) ? (int)$settings['exad_image_carousel_slide_to_show_tablet'] : 2  ),
				'data-slides_to_show_mobile'   => intval( esc_attr( isset( $settings['exad_image_carousel_slide_to_show_mobile'] ) ) ? (int)$settings['exad_image_carousel_slide_to_show_mobile'] : 1),
                'data-carousel_nav'     => esc_attr( $settings['exad_image_carousel_nav'] ),
                'data-oriantation'     => esc_attr( $settings['exad_image_carousel_oriantation'] ),
            ]
        );

        if ( 'dots' === $settings['exad_image_carousel_nav'] || 'both' === $settings['exad_image_carousel_nav'] ) {
            $this->add_render_attribute( 'exad_image_carousel_slider', 'data-dot_type', $settings['exad_image_carousel_nav_dot_type'] );
        }

        if ( 'yes' === $settings['exad_image_carousel_infinite_loop'] ) {
            $this->add_render_attribute( 'exad_image_carousel_slider', 'data-infinite_loop', 'true' );
        }

        if ( 'yes' === $settings['exad_image_carousel_fade'] ) {
            $this->add_render_attribute( 'exad_image_carousel_slider', 'data-fade', 'true' );
        }

        if ( 'yes' === $settings['exad_image_carousel_autoplay'] ) {
            $this->add_render_attribute( 'exad_image_carousel_slider', 'data-autoplay', 'true' );
            $this->add_render_attribute( 'exad_image_carousel_slider', 'data-autoplayspeed', intval( esc_attr( $settings['exad_image_carousel_autoplay_speed'] ) ) );
        }
        
        if ( 'yes' === $settings['exad_image_carousel_center_mode'] ) {
            $this->add_render_attribute( 'exad_image_carousel_slider', 'data-center_mode', 'true' );
            $this->add_render_attribute( 'exad_image_carousel_slider', 'data-center_padding', intval( esc_attr( $settings['exad_image_carousel_center_padding'] ) ) );
		}

        ?>
            <div class="exad-image-carousel-wrapper <?php echo $settings['exad_image_carousel_nav_dot_position']; ?>">
                <div class="exad-image-carousel-prev">
                    <?php Icons_Manager::render_icon( $settings['exad_image_carousel_nav_arrow_previous_icon'], [ 'aria-hidden' => 'true' ] ); ?>
                </div>
                <div <?php echo $this->get_render_attribute_string( 'exad_image_carousel_slider' ); ?> >
                    <?php foreach ( $settings['exad_image_carousel_gallery'] as $image ) { 

                        $image_url = Group_Control_Image_Size::get_attachment_image_src( $image['id'], 'thumbnail', $settings );
                        $data_image = 'data-image="'. $image_url .'"';

                        ?>
                        <div class="exad-image-carousel-item" <?php echo ( 'image' === $settings['exad_image_carousel_nav_dot_type'] ) ? $data_image : ''; ?>>
                           <img src="<?php echo esc_attr( $image_url ); ?>" alt="<?php echo esc_attr( Control_Media::get_image_alt( $image ) ); ?>">
                        </div>
                    <?php } ?>
                </div>
                <div class="exad-image-carousel-next">
                    <?php Icons_Manager::render_icon( $settings['exad_image_carousel_nav_arrow_next_icon'], [ 'aria-hidden' => 'true' ] ); ?>
                </div>
            </div>
        <?php
    }
}