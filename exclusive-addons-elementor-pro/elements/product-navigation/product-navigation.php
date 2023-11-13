<?php
namespace ExclusiveAddons\Elements;

if ( !defined( 'ABSPATH' ) ) {
    exit;
}
// If this file is called directly, abort.

use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Border;
use \Elementor\Group_Control_Box_Shadow;
use \Elementor\Group_Control_Typography;
use \Elementor\Group_Control_Background;
use \Elementor\Icons_Manager;
use \Elementor\Widget_Base;

class Product_Navigation extends Widget_Base {

    public function get_name() {
        return 'exad-product-navigation';
    }

    public function get_title() {
        return esc_html__( 'Product Navigation', 'exclusive-addons-elementor-pro' );
    }

    public function get_icon() {
        return 'exad exad-logo exad-woo-products';
    }

    public function get_categories() {
        return ['exclusive-addons-elementor'];
    }

    public function get_keywords() {
        return ['navigation', 'pagination', 'single product nav', 'woo product navigation', 'woo nav'];
    }

    protected function register_controls() {

		$exad_primary_color = get_option( 'exad_primary_color_option', '#7a56ff' );

        if ( !class_exists( 'woocommerce' ) ) {
            $this->start_controls_section(
                'exad_panel_notice',
                [
                    'label' => __( 'Notice!', 'exclusive-addons-elementor-pro' ),
                ]
            );

            $this->add_control(
                'exad_panel_notice_text',
                [
                    'type'            => Controls_Manager::RAW_HTML,
                    'raw'             => __( '<strong>WooCommerce</strong> is not installed/activated on your site. Please install and activate <a href="plugin-install.php?s=wpcf7&tab=search&type=term" target="_blank">WooCommerce</a> first.',
                        'exclusive-addons-elementor-pro' ),
                    'content_classes' => 'exad-panel-notice',
                ]
            );

            $this->end_controls_section();

            return;
        }

                
        /**
         * Navigation Section
         */
        $this->start_controls_section(
			'exad_product_navigation',
			[
				'label' => __( 'Navigation', 'exclusive-addons-elementor-pro' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'exad_product_navigation_prev_heading',
			[
				'label' => __( 'Prev', 'exclusive-addons-elementor-pro' ),
				'type'  => Controls_Manager::HEADING,
                'separator' => 'before',
			]
		);

		$this->add_control(
			'exad_product_navigation_prev_text',
			[
				'label' => __( 'Prev', 'exclusive-addons-elementor-pro' ),
				'type'  => Controls_Manager::TEXT,
				'placeholder' => __( 'Prev', 'exclusive-addons-elementor-pro' ),
                'default' => __( 'Prev', 'exclusive-addons-elementor-pro' ),
			]
		);

		$this->add_control(
			'exad_product_navigation_prev_icon',
			[
				'label'       => __( 'Icon For Prev', 'exclusive-addons-elementor-pro' ),
				'type'        => Controls_Manager::ICONS,
				'default'     => [
					'value'   => 'fas fa-chevron-left',
					'library' => 'fa-solid'
				],
			]
		);

        $this->add_control(
			'exad_product_navigation_next_heading',
			[
				'label' => __( 'Next', 'exclusive-addons-elementor-pro' ),
				'type'  => Controls_Manager::HEADING,
                'separator' => 'before',
			]
		);

		$this->add_control(
			'exad_product_navigation_next_text',
			[
				'label' => __( 'Next', 'exclusive-addons-elementor-pro' ),
				'type'  => Controls_Manager::TEXT,
				'placeholder' => __( 'Next', 'exclusive-addons-elementor-pro' ),
                'default' => __( 'Next', 'exclusive-addons-elementor-pro' ),
			]
		);

        
		$this->add_control(
			'exad_product_navigation_next_icon',
			[
				'label'       => __( 'Icon For Next', 'exclusive-addons-elementor-pro' ),
				'type'        => Controls_Manager::ICONS,
				'default'     => [
					'value'   => 'fas fa-chevron-right',
					'library' => 'fa-solid'
				],
			]
		);

        $this->end_controls_section();

        /**
         * Content Section
         */
        $this->start_controls_section(
            'exad_product_nav_content_section',
            [
                'label' => esc_html__( 'Before & After', 'exclusive-addons-elementor-pro' ),
            ]
        );

        $this->add_control(
			'exad_product_nav_before',
			[
				'label'       => esc_html__( 'Show Text Before Nav', 'exclusive-addons-elementor-pro' ),
				'type'        => Controls_Manager::TEXTAREA
			]
        );

		$this->add_control(
			'exad_product_nav_after',
			[
				'label'       => esc_html__( 'Show Text After Nav', 'exclusive-addons-elementor-pro' ),
				'type'        => Controls_Manager::TEXTAREA
			]
        );

        $this->end_controls_section();

        /**
		 * Style Section
		 */

		/*
		* container Styling Section
		*/
        $this->start_controls_section(
            'exad_product_nav_container_style_section',
            [
                'label' => esc_html__( 'Container', 'exclusive-addons-elementor-pro' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

		$this->add_responsive_control(
            'exad_product_nav_container_alignment',
            [
                'label'         => esc_html__( 'Alignment', 'exclusive-addons-elementor-pro' ),
                'type'          => Controls_Manager::CHOOSE,
                'default'       => 'left',
                'toggle'        => false,
                'options'       => [
                    'left' => [
                        'title'  => esc_html__( 'Left', 'exclusive-addons-elementor-pro' ),
                        'icon'   => 'eicon-h-align-left'
                    ],
                    'center'     => [
                        'title'  => esc_html__( 'Center', 'exclusive-addons-elementor-pro' ),
                        'icon'   => 'eicon-h-align-center'
                    ],
                    'right'   => [
                        'title'  => esc_html__( 'Right', 'exclusive-addons-elementor-pro' ),
                        'icon'   => 'eicon-h-align-right'
                    ]
                ],
                'selectors_dictionary' => [
                    'left'      => 'justify-content: flex-start;',
					'center'    => 'justify-content: center;',
					'right'     => 'justify-content: flex-end;',
                ],
                'selectors'     => [
                    '{{WRAPPER}} .exad-product-nav-container .exad-product-navigation' => '{{VALUE}};'
                ]
            ]
        );

        $this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'exad_product_nav_container_background',
				'types'    => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .exad-product-nav-container'
			]
		);

		$this->add_responsive_control(
			'exad_product_nav_container_padding',
			[
				'label'         => __( 'Padding', 'exclusive-addons-elementor-pro' ),
				'type'          => Controls_Manager::DIMENSIONS,
				'size_units'    => [ 'px', '%' ],
				'default'       => [
					'top'       => '0',
					'right'     => '0',
					'bottom'    => '0',
					'left'      => '0',
					'unit'      => 'px',
                    'isLinked'  => false
				],
				'selectors'     => [
					'{{WRAPPER}} .exad-product-nav-container' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
		);

		$this->add_responsive_control(
			'exad_product_nav_container_margin',
			[
				'label'        => __( 'Margin', 'exclusive-addons-elementor-pro' ),
				'type'         => Controls_Manager::DIMENSIONS,
				'size_units'   => [ 'px', '%' ],
				'default'      => [
					'top'      => '0',
					'right'    => '0',
					'bottom'   => '0',
					'left'     => '0',
					'unit'     => 'px',
					'isLinked' => false
				],
				'selectors'    => [
					'{{WRAPPER}} .exad-product-nav-container' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
        );

        $this->add_responsive_control(
			'exad_product_nav_container_radius',
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
					'{{WRAPPER}} .exad-product-nav-container' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'exad_product_nav_container_border',
				'selector' => '{{WRAPPER}} .exad-product-nav-container'
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'exad_product_nav_container_shadow',
				'selector' => '{{WRAPPER}} .exad-product-nav-container'
			]
		);

        $this->end_controls_section();

        /**
		* Style Tab Prev Style
		*/
		$this->start_controls_section(
            'exad_product_navigation_icon_text_style',
            [
                'label'     => esc_html__( 'icon / Text', 'exclusive-addons-elementor-pro' ),
                'tab'       => Controls_Manager::TAB_STYLE,
            ]
        ); 

        
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'exad_product_navigation_icon_text_typography',
                'selector' => '{{WRAPPER}} .exad-product-navigation .exad-product-next span, {{WRAPPER}} .exad-product-navigation .exad-product-prev span',
            ]
        );

        $this->add_responsive_control(
            'exad_product_navigation_style_icon_size',
            [
                'label'      => __( 'icon Size', 'exclusive-addons-elementor-pro' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range'      => [
                    'px' => [
                        'min' => 12,
                        'max' => 50,
                    ],
                ],
                'default'    => [
                    'unit' => 'px',
                    'size' => 16,
                ],
                'selectors'  => [
                    '{{WRAPPER}} .exad-product-navigation .exad-product-next i' => 'font-size: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .exad-product-navigation .exad-product-prev i' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'exad_product_navigation_style_icon_spacing',
            [
                'label'      => __( 'icon Spacing', 'exclusive-addons-elementor-pro' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range'      => [
                    'px' => [
                        'min' => 0,
                        'max' => 50,
                    ],
                ],
                'default'    => [
                    'unit' => 'px',
                    'size' => 16,
                ],
                'selectors'  => [
                    '{{WRAPPER}} .exad-product-navigation .exad-product-next span' => 'margin-right: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .exad-product-navigation .exad-product-prev span' => 'margin-left: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        /**
		* Style Tab Prev Style
		*/

		$this->start_controls_section(
            'exad_product_navigation_style_',
            [
                'label'     => esc_html__( 'Navigation', 'exclusive-addons-elementor-pro' ),
                'tab'       => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'exad_product_navigation_style_alignment',
            [
                'label'         => esc_html__('Nav Alignment', 'exclusive-addons-elementor-pro'),
                'type'          => Controls_Manager::CHOOSE,
                'toggle'        => false,
                'label_block'   => true,
                'default'       => 'center',
                'options'       => [
                    'left'      => [
                        'title' => esc_html__('Left', 'exclusive-addons-elementor-pro'),
                        'icon'  => 'eicon-text-align-left'
                    ],
                    'center'    => [
                        'title' => esc_html__('Center', 'exclusive-addons-elementor-pro'),
                        'icon'  => 'eicon-text-align-center'
                    ],
                    'right'     => [
                        'title' => esc_html__('Right', 'exclusive-addons-elementor-pro'),
                        'icon'  => 'eicon-text-align-right'
                    ],
                ],
				'selectors_dictionary' => [
                    'left'      => 'text-align: left; display: flex; justify-content: flex-start; margin-right: auto;',
					'center'    => 'text-align: center; display: flex; justify-content: center; margin-left: auto; margin-right: auto;',
					'right'     => 'text-align: right; display: flex; justify-content: flex-end; margin-left: auto;',
                ],
                'selectors'     => [
                    '{{WRAPPER}} .exad-product-navigation .exad-product-navigation-link a.exad-product-prev' => '{{VALUE}};',
                    '{{WRAPPER}} .exad-product-navigation .exad-product-navigation-link a.exad-product-next' => '{{VALUE}};'
                ]
            ]
        );

        $this->add_responsive_control(
            'exad_product_navigation_style_spacing',
            [
                'label'      => __( 'Nav Specing', 'exclusive-addons-elementor-pro' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range'      => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'default'    => [
                    'unit' => 'px',
                    'size' => 15,
                ],
                'selectors'  => [
                    '{{WRAPPER}} .exad-product-navigation-link+.exad-product-navigation-link' => 'margin-left: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'exad_product_navigation_style_radius',
            [
                'label'      => __( 'Border Radius', 'exclusive-addons-elementor-pro' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'default'    => [
                    'top'      => '0',
                    'right'    => '0',
                    'bottom'   => '0',
                    'left'     => '0',
                    'unit'     => 'px',
                    'isLinked' => true,
                ],
                'selectors'  => [
                    '{{WRAPPER}} .exad-product-navigation .exad-product-prev' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .exad-product-navigation .exad-product-next' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'exad_product_navigation_style_height',
            [
                'label'      => __( 'Height', 'exclusive-addons-elementor-pro' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range'      => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'default'    => [
                    'unit' => 'px',
                    'size' => 45,
                ],
                'selectors'  => [
                    '{{WRAPPER}} .exad-product-navigation .exad-product-prev' => 'height: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .exad-product-navigation .exad-product-next' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'exad_product_navigation_style_width',
            [
                'label'      => __( 'Width', 'exclusive-addons-elementor-pro' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range'      => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'default'    => [
                    'unit' => 'px',
                    'size' => 110,
                ],
                'selectors'  => [
                    '{{WRAPPER}} .exad-product-navigation .exad-product-prev' => 'width: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .exad-product-navigation .exad-product-next' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs( 'exad_product_navigation_styles_tabs' );

			// normal state rating
            $this->start_controls_tab( 'exad_product_navigation_styles_normal', [ 'label' => esc_html__( 'Normal', 'exclusive-addons-elementor-pro' ) ] );

                $this->add_control(
                    'exad_product_navigation_style_color',
                    [
                        'label'     => __( 'Text & Icon Color', 'exclusive-addons-elementor-pro' ),
                        'type'      => Controls_Manager::COLOR,
                        'default'   => $exad_primary_color,
                        'selectors' => [
                            '{{WRAPPER}} .exad-product-navigation .exad-product-prev' => 'color: {{VALUE}};',
                            '{{WRAPPER}} .exad-product-navigation .exad-product-prev i' => 'color: {{VALUE}};',
                            '{{WRAPPER}} .exad-product-navigation .exad-product-next' => 'color: {{VALUE}};',
                        ],
                    ]
                );

                $this->add_control(
                    'exad_product_navigation_style_background',
                    [
                        'label'     => __( 'Background Color', 'exclusive-addons-elementor-pro' ),
                        'type'      => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .exad-product-navigation .exad-product-prev' => 'background: {{VALUE}};',
                            '{{WRAPPER}} .exad-product-navigation .exad-product-next' => 'background: {{VALUE}};',
                        ],
                    ]
                );
				
				$this->add_responsive_control(
                    'exad_product_navigation_style_opacity',
                    [
                        'label'     => __( 'Opacity', 'exclusive-addons-elementor-pro' ),
                        'type'      => Controls_Manager::SLIDER,
                        'default' => [
							'size' => 1,
						],
						'range' => [
							'px' => [
								'max' => 1,
								'step' => 0.01,
							],
						],
                        'selectors' => [
                            '{{WRAPPER}} .exad-product-navigation .exad-product-prev' => 'opacity: {{SIZE}};',
                            '{{WRAPPER}} ..exad-product-navigation .exad-product-next' => 'opacity: {{SIZE}};',
                        ],
                    ]
                );

                $this->add_group_control(
                    Group_Control_Border::get_type(),
                    [
                        'name'     => 'exad_product_navigation_style_border',
                        'label'    => __( 'Border', 'exclusive-addons-elementor-pro' ),
                        'selector' => '{{WRAPPER}} .exad-product-navigation .exad-product-prev, {{WRAPPER}} .exad-product-navigation .exad-product-next',
                    ]
                );

                $this->add_group_control(
                    Group_Control_Box_Shadow::get_type(),
                    [
                        'name'     => 'exad_product_navigation_style_box_shadow',
                        'selector' => '{{WRAPPER}} .exad-product-navigation .exad-product-prev, {{WRAPPER}} .exad-product-navigation .exad-product-next'
                    ]
                );

			$this->end_controls_tab();

			// hover state rating
            $this->start_controls_tab( 'exad_product_navigation_styles_hover', [ 'label' => esc_html__( 'Hover/active', 'exclusive-addons-elementor-pro' ) ] );

                $this->add_control(
                    'exad_product_navigation_style_active_color',
                    [
                        'label'     => __( 'Text & Icon Color', 'exclusive-addons-elementor-pro' ),
                        'type'      => Controls_Manager::COLOR,
                        'default'   => '#fff',
                        'selectors' => [
                            '{{WRAPPER}} .exad-product-navigation .exad-product-prev:hover' => 'color: {{VALUE}};',
                            '{{WRAPPER}} .exad-product-navigation .exad-product-prev:hover i' => 'color: {{VALUE}};',
                            '{{WRAPPER}} .exad-product-navigation .exad-product-next:hover' => 'color: {{VALUE}};',
                        ],
                    ]
                );

                $this->add_control(
                    'exad_product_navigation_style_active_background',
                    [
                        'label'     => __( 'Background Color', 'exclusive-addons-elementor-pro' ),
                        'type'      => Controls_Manager::COLOR,
                        'default'   => $exad_primary_color,
                        'selectors' => [
                            '{{WRAPPER}} .exad-product-navigation .exad-product-prev:hover' => 'background: {{VALUE}};',
                            '{{WRAPPER}} .exad-product-navigation .exad-product-next:hover' => 'background: {{VALUE}};',
                        ],
                    ]
                );

				$this->add_responsive_control(
                    'exad_product_navigation_style_hover_opacity',
                    [
                        'label'     => __( 'Opacity', 'exclusive-addons-elementor-pro' ),
                        'type'      => Controls_Manager::SLIDER,
						'default' => [
							'size' => 1,
						],
						'range' => [
							'px' => [
								'max' => 1,
								'step' => 0.01,
							],
						],
                        'selectors' => [
							'{{WRAPPER}} .exad-product-navigation .exad-product-prev:hover' => 'opacity: {{SIZE}};',
							'{{WRAPPER}} .exad-product-navigation .exad-product-next:hover' => 'opacity: {{SIZE}};',
                        ],
                    ]
                );

                $this->add_group_control(
                    Group_Control_Border::get_type(),
                    [
                        'name'     => 'exad_product_navigation_style_active_border',
                        'label'    => __( 'Border', 'exclusive-addons-elementor-pro' ),
                        'selector' => '{{WRAPPER}} .exad-product-navigation .exad-product-prev:hover, {{WRAPPER}} .exad-product-navigation .exad-product-next:hover',
                    ]
                );
                
                $this->add_group_control(
                    Group_Control_Box_Shadow::get_type(),
                    [
                        'name'     => 'exad_product_navigation_style_box_shadow_hover',
                        'selector' => '{{WRAPPER}} .exad-product-navigation .exad-product-prev:hover, {{WRAPPER}} .exad-product-navigation .exad-product-next:hover'
                    ]
                );

			$this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();

        /*
		* ToolTip Image Styling Section
		*/
        $this->start_controls_section(
            'exad_product_navigation_tooltip_image_style_section',
            [
                'label' => __( 'Tooltip Image', 'exclusive-addons-elementor-pro' ),
                'tab'   => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_responsive_control(
			'exad_product_navigation_tooltip_image_box_radius',
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
                    '{{WRAPPER}} .exad-product-navigation-link .product-thumbnail img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'exad_product_navigation_tooltip_image_box_border',
				'selector' => '{{WRAPPER}} .exad-product-navigation-link .product-thumbnail img',
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'exad_product_navigation_tooltip_image_box_shadow',
				'selector' => '{{WRAPPER}} .exad-product-navigation-link .product-thumbnail img'
			]
		);

        $this->end_controls_section();

         // Tooltip Style tab section
         $this->start_controls_section(
            'exad_product_navigation_tooltip_style_section',
            [
                'label' => __( 'Tooltip Styles', 'exclusive-addons-elementor-pro' ),
                'tab'   => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'             => 'exad_product_navigation_tooltip_content_typography',
				'selector'         => '{{WRAPPER}} .exad-product-navigation-link .product-thumbnail h3.product-title',
				'fields_options'   => [
					'font_size'    => [
		                'default'  => [
		                    'unit' => 'px',
		                    'size' => 14
		                ]
		            ],
		            'font_weight'  => [
		                'default'  => '600'
		            ]
	            ]
			]
		);

        $this->add_control(
            'exad_tooltip_style_color',
            [
                'label'     => __( 'Text Color', 'exclusive-addons-elementor-pro' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .exad-product-navigation-link .product-thumbnail .product-title' => 'color: {{VALUE}};'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'     => 'exad_product_navigation_tooltip_content_background',
                'types'    => [ 'classic', 'gradient' ], 
                'fields_options'  => [
                    'background'  => [
                        'default' => 'classic'
                    ],
                    'color'       => [
                        'default' => '#fff',
                    ]
                ],
                'selector' => '{{WRAPPER}} .exad-product-navigation-link .product-thumbnail'
            ]
        );

        $this->add_responsive_control(
			'exad_product_navigation_tooltip_text_width',
		    [
                'label' => __( 'Tooltip Width', 'exclusive-addons-elementor-pro' ),
                'type'  => Controls_Manager::SLIDER,
                'range' => [
		            'px'       => [
		                'min'  => 0,
		                'max'  => 1000,
		                'step' => 5
		            ],
		            '%'        => [
		                'min'  => 0,
		                'max'  => 100
		            ]
		        ],
                'size_units'   => [ 'px', '%' ],
                'default'      => [
                    'unit'     => 'px',
                    'size'     => 120
                ],
		        'selectors'    => [
		            '{{WRAPPER}} .exad-product-navigation-link .product-thumbnail' => 'width: {{SIZE}}{{UNIT}};'
		        ]
		    ]
		);

        $this->add_responsive_control(
            'exad_product_navigation_tooltip_text_padding',
            [
                'label'      => __( 'Padding', 'exclusive-addons-elementor-pro' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'default'    => [
                    'top'    => 10,
                    'right'  => 10,
                    'bottom' => 10,
                    'left'   => 10
                ],
                'selectors'  => [
                    '{{WRAPPER}} .exad-product-navigation-link .product-thumbnail' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
                'separator'  =>'before'
            ]
        );

        $this->add_responsive_control(
            'exad_product_navigation_tooltip_content_border_radius',
            [
                'label'      => esc_html__( 'Border Radius', 'exclusive-addons-elementor-pro' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'default'    => [
                    'top'    => 4,
                    'right'  => 4,
                    'bottom' => 4,
                    'left'   => 4
                ],
                'selectors'  => [
                    '{{WRAPPER}} .exad-product-navigation-link .product-thumbnail' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px !important;'
                ]
            ]
        );
    
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'exad_product_navigation_tooltip_box_shadow_hover',
                'selector' => '{{WRAPPER}} .exad-product-navigation-link .product-thumbnail'
            ]
        );

        $this->add_control(
            'exad_product_navigation_tooltip_box_prev_position',
            [
                'label'        => __( 'Previous Hover Box Position', 'exclusive-addons-elementor-pro' ),
                'type'         => Controls_Manager::POPOVER_TOGGLE,
                'label_off'    => __( 'Default', 'exclusive-addons-elementor-pro' ),
                'label_on'     => __( 'Custom', 'exclusive-addons-elementor-pro' ),
                'return_value' => 'yes',
                'default'      => 'yes',
            ]
        );
        
        $this->start_popover();

            $this->add_responsive_control(
                'exad_product_navigation_tooltip_box_prev_position_x_offset',
                [
                    'label'      => __( 'X Offset', 'exclusive-addons-elementor-pro' ),
                    'type'       => Controls_Manager::SLIDER,
                    'size_units' => ['px', '%'],
                    'range'      => [
                        'px' => [
                            'min' => -3000,
                            'max' => 3000,
                        ],
                        '%'  => [
                            'min' => -100,
                            'max' => 100,
                        ],
                    ],
                    'default'    => [
                        'unit' => 'px',
                        'size' => 0,
                    ],
                    'selectors'  => [
                        '{{WRAPPER}} .exad-product-navigation-link.product-prev .product-thumbnail.prev-short-info' => 'left: {{SIZE}}{{UNIT}};',
                    ],
                ]
            );

            $this->add_responsive_control(
                'exad_product_navigation_tooltip_box_prev_position_y_offset',
                [
                    'label'      => __( 'Y Offset', 'exclusive-addons-elementor-pro' ),
                    'type'       => Controls_Manager::SLIDER,
                    'size_units' => ['px', '%'],
                    'range'      => [
                        'px' => [
                            'min' => -3000,
                            'max' => 3000,
                        ],
                        '%'  => [
                            'min' => -100,
                            'max' => 100,
                        ],
                    ],
                    'default'    => [
                        'unit' => '%',
                        'size' => 100,
                    ],
                    'selectors'  => [
                        '{{WRAPPER}} .exad-product-navigation-link.product-prev .product-thumbnail.prev-short-info' => 'top: {{SIZE}}{{UNIT}};',
                    ],
                ]
            );

        $this->end_popover();

        $this->add_control(
            'exad_product_navigation_tooltip_box_next_position',
            [
                'label'        => __( 'Next Hover Box Position', 'exclusive-addons-elementor-pro' ),
                'type'         => Controls_Manager::POPOVER_TOGGLE,
                'label_off'    => __( 'Default', 'exclusive-addons-elementor-pro' ),
                'label_on'     => __( 'Custom', 'exclusive-addons-elementor-pro' ),
                'return_value' => 'yes',
                'default'      => 'yes',
            ]
        );
        
        $this->start_popover();

            $this->add_responsive_control(
                'exad_product_navigation_tooltip_box_next_position_x_offset',
                [
                    'label'      => __( 'X Offset', 'exclusive-addons-elementor-pro' ),
                    'type'       => Controls_Manager::SLIDER,
                    'size_units' => ['px', '%'],
                    'range'      => [
                        'px' => [
                            'min' => -3000,
                            'max' => 3000,
                        ],
                        '%'  => [
                            'min' => -100,
                            'max' => 100,
                        ],
                    ],
                    'default'    => [
                        'unit' => 'px',
                        'size' => 0,
                    ],
                    'selectors'  => [
                        '{{WRAPPER}} .exad-product-navigation-link.product-next .product-thumbnail.next-short-info' => 'right: {{SIZE}}{{UNIT}};',
                    ],
                ]
            );

            $this->add_responsive_control(
                'exad_product_navigation_tooltip_box_next_position_y_offset',
                [
                    'label'      => __( 'Y Offset', 'exclusive-addons-elementor-pro' ),
                    'type'       => Controls_Manager::SLIDER,
                    'size_units' => ['px', '%'],
                    'range'      => [
                        'px' => [
                            'min' => -3000,
                            'max' => 3000,
                        ],
                        '%'  => [
                            'min' => -100,
                            'max' => 100,
                        ],
                    ],
                    'default'    => [
                        'unit' => '%',
                        'size' => 100,
                    ],
                    'selectors'  => [
                        '{{WRAPPER}} .exad-product-navigation-link.product-next .product-thumbnail.next-short-info' => 'top: {{SIZE}}{{UNIT}};',
                    ],
                ]
            );

        $this->end_popover();

        $this->end_controls_section();

        /*
		* Before & After meta Styling Section
		*/
		$this->start_controls_section(
            'exad_product_nav_before_after_style_section',
            [
                'label' => esc_html__( 'Before & After Style', 'exclusive-addons-elementor-pro' ),
				'tab'   => Controls_Manager::TAB_STYLE
            ]
        );

		$this->add_control(
			'exad_product_nav_before_style',
			[
				'label'     => __( 'Before Nav', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before'
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'             => 'exad_product_nav_before_typography',
				'selector'         => '{{WRAPPER}} .exad-meta-before',
			]
		);

		$this->add_control(
			'exad_product_nav_before_color',
			[
				'label'     => __( 'Color', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#333333',
				'selectors' => [
					'{{WRAPPER}} .exad-meta-before' => 'color: {{VALUE}};'
				]
			]
		);

		$this->add_responsive_control(
			'exad_product_nav_before_margin',
			[
				'label'      => __( 'Margin', 'exclusive-addons-elementor-pro' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'default'    => [
					'top'    => '0',
					'right'  => '0',
					'bottom' => '0',
					'left'   => '0',
                    'isLinked' => false
				],
				'selectors'  => [
					'{{WRAPPER}} .exad-nav-before' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
		);

        $this->add_control(
			'exad_product_meta_after_style',
			[
				'label'     => __( 'After Nav', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before'
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'             => 'exad_product_nav_after_typography',
				'selector'         => '{{WRAPPER}} .exad-nav-after',
            ]
		);

		$this->add_control(
			'exad_product_nav_after_color',
			[
				'label'     => __( 'Color', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#333333',
				'selectors' => [
					'{{WRAPPER}} .exad-nav-after' => 'color: {{VALUE}};'
				]
			]
		);

		$this->add_responsive_control(
			'exad_product_nav_after_margin',
			[
				'label'      => __( 'Margin', 'exclusive-addons-elementor-pro' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'default'    => [
					'top'    => '0',
					'right'  => '0',
					'bottom' => '0',
					'left'   => '0',
                    'isLinked' => false
				],
				'selectors'  => [
					'{{WRAPPER}} .exad-nav-after' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
		);
		$this-> end_controls_section();

    }

    protected function render() {

        if ( !class_exists( 'woocommerce' ) ) {
            return;
        }

        $settings = $this->get_settings_for_display();
        global $product;
		$product = wc_get_product();
                
        if ( empty( $product ) ) {
			return;
		}

        $next_post = get_next_post( true, '', 'product_cat' );
        $prev_post = get_previous_post( true, '', 'product_cat' );
        

        $next_label_escaped = ! empty( $settings['exad_product_navigation_next_text'] ) ? $settings['exad_product_navigation_next_text'] : __( 'Nav', 'exclusive-addons-elementor-pro' );
        $prev_label_escaped = ! empty( $settings['exad_product_navigation_prev_text'] ) ? $settings['exad_product_navigation_prev_text'] : __( 'Prev', 'exclusive-addons-elementor-pro' );


        do_action( 'exad_woo_nav_widget_before_render', $this );
        ?>
        <div class="exad-product-nav-container">
			<?php if ( ! empty( $settings['exad_product_nav_before'] ) ) : ?>
				<p class="exad-nav-before" ><?php echo wp_kses_post( $settings['exad_product_nav_before'] );?></p>
			<?php endif; ?>
         
            <ul class="exad-product-navigation">
                <?php
                if ( is_a( $prev_post, 'WP_Post' ) ) :
                    ?>
                    <li class="exad-product-navigation-link product-prev">
                        <a class="exad-product-prev" href="<?php echo esc_url( get_the_permalink( $prev_post->ID ) ); ?>" aria-label="Previous" tabindex="-1">
                        <?php Icons_Manager::render_icon( $settings['exad_product_navigation_prev_icon'], [ 'aria-hidden' => 'true' ] ); ?>
                        <?php if ( !empty( $settings['exad_product_navigation_prev_text'] ) ) : ?>
                            <span><?php echo $prev_label_escaped; ?></span>
                        <?php endif; ?>
                        </a>
                        <div class="dropdown product-thumbnail prev-short-info">
                            <a title="<?php echo esc_html( get_the_title( $prev_post->ID ) ); ?>" href="<?php echo esc_url( get_the_permalink( $prev_post->ID ) ); ?>"><?php echo get_the_post_thumbnail( $prev_post->ID, apply_filters( 'single_product_small_thumbnail_size', 'thumbnail' ) ) . '<h3 class="product-title">' . esc_html( get_the_title( $prev_post->ID ) ) . '</h3>'; ?></a>
                        </div>
                    </li>
                    <?php
                endif;

                if ( is_a( $next_post, 'WP_Post' ) ) :
                    ?>
                    <li class="exad-product-navigation-link product-next">
                        <a class="exad-product-next" href="<?php echo esc_url( get_the_permalink( $next_post->ID ) ); ?>" aria-label="Next" tabindex="-1">
                            <?php if ( !empty( $settings['exad_product_navigation_next_text'] ) ) :  ?>
                                <span><?php echo $next_label_escaped; ?></span>
                            <?php endif;?>
                            <?php Icons_Manager::render_icon( $settings['exad_product_navigation_next_icon'], [ 'aria-hidden' => 'true' ] ); ?>
                        </a>
                        <div class="dropdown product-thumbnail next-short-info">
                            <a title="<?php echo esc_html( get_the_title( $next_post->ID ) ); ?>" href="<?php echo esc_url( get_the_permalink( $next_post->ID ) ); ?>"><?php echo get_the_post_thumbnail( $next_post->ID, apply_filters( 'single_product_small_thumbnail_size', 'thumbnail' ) ) . '<h3 class="product-title">' . esc_html( get_the_title( $next_post->ID ) ) . '</h3>'; ?></a>
                        </div>
                    </li>
                    <?php
                endif;
                ?>
            </ul>

            <?php if ( ! empty( $settings['exad_product_nav_after'] ) ) : ?>
				<p class="exad-nav-after" ><?php echo wp_kses_post( $settings['exad_product_nav_after'] );?></p>
			<?php endif; ?>
        </div>
        <?php
        do_action( 'exad_woo_nav_widget_after_render', $this );

    }
}