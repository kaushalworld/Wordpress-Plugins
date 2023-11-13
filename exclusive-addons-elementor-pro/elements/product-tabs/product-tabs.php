<?php
namespace ExclusiveAddons\Elements;

if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.

use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Image_Size;
use \Elementor\Group_Control_Border;
use \Elementor\Group_Control_Box_Shadow;
use \Elementor\Group_Control_Typography;
use \Elementor\Widget_Base;
use \Elementor\Group_Control_Background;
use \Elementor\Group_Control_Text_Shadow;
use \ExclusiveAddons\Pro\Includes\WooBuilder\Woo_Preview_Data;

class Product_tabs extends Widget_Base {

	public function get_name() {
		return 'exad-product-tabs';
	}

	public function get_title() {
		return esc_html__( 'Product Tabs', 'exclusive-addons-elementor-pro' );
	}

	public function get_icon() {
		return 'exad exad-logo exad-woo-products';
	}

	public function get_categories() {
		return [ 'exclusive-addons-elementor' ];
	}

	public function get_keywords() {
	    return [ 'additional-information', 'additional', 'tab additional', 'tab description', 'tab Reviews', 'product tabs' ];
	}

    protected function register_controls() {

		$exad_primary_color   = get_option( 'exad_primary_color_option', '#7a56ff' );

        if( ! class_exists( 'woocommerce' ) ) {
		    $this->start_controls_section(
			    'exad_panel_notice',
			    [
				    'label' => __('Notice!', 'exclusive-addons-elementor-pro'),
			    ]
		    );

		    $this->add_control(
			    'exad_panel_notice_text',
			    [
				    'type'            => Controls_Manager::RAW_HTML,
				    'raw'             => __('<strong>WooCommerce</strong> is not installed/activated on your site. Please install and activate <a href="plugin-install.php?s=wpcf7&tab=search&type=term" target="_blank">WooCommerce</a> first.',
					    'exclusive-addons-elementor-pro'),
				    'content_classes' => 'exad-panel-notice',
			    ]
		    );

            $this->end_controls_section();
            
		    return;
		}

        /**
         * Content Section
         */

        $this->start_controls_section(
            'exad_tab_panel_description_content_section',
            [
                'label' => esc_html__( 'Content', 'exclusive-addons-elementor-pro' ),
            ]
        );

        $this->add_control(
			'exad_product_tabs_info_before',
			[
				'label'       => esc_html__( 'Show Text Before Tabs', 'exclusive-addons-elementor-pro' ),
				'type'        => Controls_Manager::TEXTAREA
			]
        );

		$this->add_control(
			'exad_product_tabs_info_after',
			[
				'label'       => esc_html__( 'Show Text After Tabs', 'exclusive-addons-elementor-pro' ),
				'type'        => Controls_Manager::TEXTAREA
			]
        );
        
        $this->add_control( 'exad_product_update_info',
            [
                'type'  => Controls_Manager::RAW_HTML,
                'raw'   => __( '<strong>Product Tabs - </strong> Go to Style Tab ',
                        'exclusive-addons-elementor-pro' ),
                    'content_classes' => 'exad-panel-notice',
            ]
        );

        $this->end_controls_section();

		/*
		* product short description container Styling Section
		*/
        $this->start_controls_section(
            'exad_tab_panel_description_container_style_section',
            [
                'label' => esc_html__( 'Container', 'exclusive-addons-elementor-pro' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
		);

        $this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'exad_tab_panel_description_container_background',
				'types'    => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .exad-single-product-details'
			]
		);

		$this->add_responsive_control(
			'exad_tab_panel_description_container_padding',
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
					'{{WRAPPER}} .exad-single-product-details' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
		);

		$this->add_responsive_control(
			'exad_tab_panel_description_container_margin',
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
					'{{WRAPPER}} .exad-single-product-details' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
        );

        $this->add_responsive_control(
			'exad_tab_panel_description_container_radius',
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
					'{{WRAPPER}} .exad-single-product-details' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'exad_tab_panel_description_container_border',
				'selector' => '{{WRAPPER}} .exad-single-product-details'
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'exad_tab_panel_description_container_box_shadow',
				'selector' => '{{WRAPPER}} .exad-single-product-details'
			]
		);

        $this->end_controls_section();

		/*
		* Tabs Control Styling Section
		*/
		$this->start_controls_section(
            'exad_product_tabs_control_style_settings',
            [
                'label' => esc_html__('Tabs', 'exclusive-addons-elementor-pro'),
                'tab'   => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_control(
            'exad_product_tabs_control_item_container_style',
            [
                'label'     => esc_html__('Tab Container', 'exclusive-addons-elementor-pro'),
                'type'      => Controls_Manager::HEADING
            ]
        );

		$this->add_control(
			'exad_product_tabs_control_container_alignment',
			[
				'label'   => __( 'Alignment', 'exclusive-addons-elementor-pro' ),
				'type'    => Controls_Manager::CHOOSE,
				'toggle'  => false,
				'default' => 'exad-tabs-menu-container-align-top',
				'options' => [
					'exad-tabs-menu-container-align-left'   => [
						'title' => __( 'Left', 'exclusive-addons-elementor-pro' ),
						'icon'  => 'eicon-arrow-left'
					],
					'exad-tabs-menu-container-align-top' => [
						'title' => __( 'Top', 'exclusive-addons-elementor-pro' ),
						'icon'  => 'eicon-arrow-up'
					],
					'exad-tabs-menu-container-align-right'  => [
						'title' => __( 'Right', 'exclusive-addons-elementor-pro' ),
						'icon'  => 'eicon-arrow-right'
					]
				]
			]
		);

		$this->add_responsive_control(
			'exad_product_tabs_control_container_nav_tabs_width',
			[
				'label' => __( 'Width', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ '%' ],
				'devices' => [ 'desktop' ],
				'range' => [
					'%' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => '%',
					'size' => 20,
				],
				'selectors' => [
					'{{WRAPPER}} .exad-single-product-details.exad-tabs-menu-container-align-left .woocommerce-tabs .wc-tabs' => 'width: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .exad-single-product-details.exad-tabs-menu-container-align-right .woocommerce-tabs .wc-tabs' => 'width: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .exad-single-product-details.exad-tabs-menu-container-align-left .woocommerce-tabs .woocommerce-Tabs-panel' => 'width: calc( 100% - {{SIZE}}{{UNIT}} );',
					'{{WRAPPER}} .exad-single-product-details.exad-tabs-menu-container-align-right .woocommerce-tabs .woocommerce-Tabs-panel' => 'width: calc( 100% - {{SIZE}}{{UNIT}} );',
                ],
                'condition' => [
                    'exad_product_tabs_control_container_alignment' => ['exad-tabs-menu-container-align-left', 'exad-tabs-menu-container-align-right']
                ]
			]
        );

		$this->add_responsive_control(
			'exad_product_tabs_control_container_nav_conten_spacing',
			[
				'label'       => __( 'Left & Right Spacing', 'exclusive-addons-elementor-pro' ),
				'type'        => Controls_Manager::SLIDER,
				'size_units'  => [ 'px' ],
				'range'       => [
					'px'      => [
						'min' => 0,
						'max' => 100
					],
				],
				'devices' => [ 'desktop', 'tablet' ],
                'default'    => [
                    'unit'   => 'px',
                    'size'   => 10
                ],
                'tablet_default' => [
					'size' => 10,
					'unit' => '%',
				],
                'mobile_default' => [
					'size' => 0,
					'unit' => 'px',
				],
                'condition' => [
					'exad_product_tabs_control_container_alignment' => ['exad-tabs-menu-container-align-left', 'exad-tabs-menu-container-align-right']
                ],
				'selectors'   => [
					'{{WRAPPER}} .exad-single-product-details.exad-tabs-menu-container-align-left .woocommerce-tabs .woocommerce-Tabs-panel' => 'margin-left: {{SIZE}}{{UNIT}}; width: calc( ( 100% - {{exad_product_tabs_control_container_nav_tabs_width.size}}{{exad_product_tabs_control_container_nav_tabs_width.unit}} ) - {{SIZE}}{{UNIT}} );',
					'{{WRAPPER}} .exad-single-product-details.exad-tabs-menu-container-align-right .woocommerce-tabs .woocommerce-Tabs-panel' => 'margin-right: {{SIZE}}{{UNIT}}; width: calc( ( 100% - {{exad_product_tabs_control_container_nav_tabs_width.size}}{{exad_product_tabs_control_container_nav_tabs_width.unit}} ) - {{SIZE}}{{UNIT}} );',
                ],
			]
		);
        
        $this->add_responsive_control(
            'exad_product_tabs_control_container_padding',
            [
                'label'        => esc_html__('Padding', 'exclusive-addons-elementor-pro'),
                'type'         => Controls_Manager::DIMENSIONS,
                'size_units'   => ['px', 'em', '%'],
                'default'      => [
                    'top'      => '30',
                    'right'    => '20',
                    'bottom'   => '30',
                    'left'     => '20',
                    'unit'     => 'px',
                    'isLinked' => false
                ],
                'selectors'    => [
                    '{{WRAPPER}} .exad-single-product-details .woocommerce-tabs .wc-tabs' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->add_responsive_control(
            'exad_product_tabs_control_container_margin',
            [
                'label'        => esc_html__('Margin', 'exclusive-addons-elementor-pro'),
                'type'         => Controls_Manager::DIMENSIONS,
                'size_units'   => ['px', 'em', '%'],
                'default'      => [
                    'top'      => '0',
                    'right'    => '0',
                    'bottom'   => '20',
                    'left'     => '0',
                    'unit'     => 'px',
                    'isLinked' => false
                ],
                'selectors'    => [
                    '{{WRAPPER}} .exad-single-product-details .woocommerce-tabs .wc-tabs' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'  => 'exad_product_tabs_control_container_background',
				'label' => __( 'Background', 'exclusive-addons-elementor-pro' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .exad-single-product-details .woocommerce-tabs .wc-tabs',
			]
		);

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'exad_product_tabs_control_container_border',
                'selector' => '{{WRAPPER}} .exad-single-product-details .woocommerce-tabs .wc-tabs',
            ]
        );

        $this->add_responsive_control(
            'exad_product_tabs_control_container_border_radius',
            [
                'label'      => esc_html__('Border Radius', 'exclusive-addons-elementor-pro'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'default'    => [
                    'top'    => 0,
                    'right'  => 0,
                    'bottom' => 0,
                    'left'   => 0,
                    'unit'   => 'px',
					'isLinked' => false
                ],
                'selectors'  => [
                    '{{WRAPPER}} .exad-single-product-details .woocommerce-tabs .wc-tabs' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'                   => 'exad_product_tabs_control_shadow',
                'selector'               => '{{WRAPPER}} .exad-single-product-details .woocommerce-tabs .wc-tabs',
                'fields_options'         => [
                    'box_shadow_type'    => [ 
                        'default'        =>'yes' 
                    ],
                    'box_shadow'         => [
                        'default'        => [
                            'horizontal' => 0,
                            'vertical'   => 10,
                            'blur'       => 33,
                            'spread'     => 0,
                            'color'      => 'rgba(51, 77, 128, 0.1)'
                        ]
                    ]
                ]
            ]
        );

        $this->add_control(
            'exad_product_tabs_control_item_style',
            [
                'label'     => esc_html__('Tab Items', 'exclusive-addons-elementor-pro'),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before'
            ]
        );

        $this->add_responsive_control(
            'exad_product_tabs_control_item_control_item_alignment',
            [
                'label'         => esc_html__('Item Alignment', 'exclusive-addons-elementor-pro'),
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
                'condition' => [
                    'exad_product_tabs_control_container_alignment!' => ['exad-tabs-menu-container-align-left', 'exad-tabs-menu-container-align-right']
				],
				'selectors_dictionary' => [
                    'left'      => 'text-align: left; display: flex; justify-content: flex-start; margin-right: auto;',
					'center'    => 'text-align: center; display: flex; justify-content: center; margin-left: auto; margin-right: auto;',
					'right'     => 'text-align: right; display: flex; justify-content: flex-end; margin-left: auto;',
                ],
                'selectors'     => [
                    '{{WRAPPER}} .exad-single-product-details .woocommerce-tabs .wc-tabs' => '{{VALUE}};'
                ]
            ]
        );      

		$this->add_responsive_control(
            'exad_product_tabs_control_item_control_item_alignment_left_right',
            [
                'label'         => esc_html__('Item Alignment2', 'exclusive-addons-elementor-pro'),
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
                    ]
                ],
				'selectors_dictionary' => [
                    'left'      => 'text-align: left; display: flex; justify-content: flex-start; margin-right: auto;',
					'center'    => 'text-align: center; display: flex; justify-content: center; margin-left: auto; margin-right: auto;',
					'right'     => 'text-align: right; display: flex; justify-content: flex-end; margin-left: auto;',
                ],
                'condition' => [
                    'exad_product_tabs_control_container_alignment' => ['exad-tabs-menu-container-align-left', 'exad-tabs-menu-container-align-right']
				],
                'selectors'     => [
                    '{{WRAPPER}} .exad-single-product-details .woocommerce-tabs .wc-tabs li a' => '{{VALUE}};'
                ]
            ]
        );

        $this->add_responsive_control(
            'exad_product_tabs_control_control_item_padding',
            [
                'label'      => esc_html__('Padding', 'exclusive-addons-elementor-pro'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'default'    => [
                    'top'    => 10,
                    'right'  => 20,
                    'bottom' => 5,
                    'left'   => 20,
                    'unit'   => 'px',
					'isLinked' => false
                ],
                'selectors'  => [
                    '{{WRAPPER}} .exad-single-product-details .woocommerce-tabs .wc-tabs li a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->add_responsive_control(
			'exad_product_tabs_control_control_item_spacing',
			[
				'label'       => __( 'Between Items Spacing', 'exclusive-addons-elementor-pro' ),
				'type'        => Controls_Manager::SLIDER,
				'size_units'  => [ 'px' ],
				'range'       => [
					'px'      => [
						'min' => 0,
						'max' => 100
					],
				],
                'default'    => [
                    'unit'   => 'px',
                    'size'   => 10
                ],
				'selectors'   => [
					'{{WRAPPER}} .exad-single-product-details.exad-tabs-menu-container-align-top .woocommerce-tabs .wc-tabs li:not(:last-child)' => 'margin-right: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .exad-single-product-details.exad-tabs-menu-container-align-left .woocommerce-tabs .wc-tabs li:not(:last-child)' => 'margin-bottom: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .exad-single-product-details.exad-tabs-menu-container-align-right .woocommerce-tabs .wc-tabs li:not(:last-child)' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
			]
		);

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'exad_product_tabs_control_control_typography',
                'selector' => '{{WRAPPER}} .exad-single-product-details .woocommerce-tabs .wc-tabs li a',
                'fields_options'     => [
                    'text_transform' => [
                        'default'    => 'capitalize'
                    ]
                ]
            ]
        );

        // Tabs
        $this->start_controls_tabs('exad_product_tabs_control_control_tabs');

        // Normal State Tab
        $this->start_controls_tab('exad_product_tabs_control_control_normal', ['label' => esc_html__('Normal', 'exclusive-addons-elementor-pro')]);

        $this->add_control(
            'exad_product_tabs_control_normal_text_color',
            [
                'label'     => esc_html__('Text Color', 'exclusive-addons-elementor-pro'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#444444',
                'selectors' => [
                    '{{WRAPPER}} .exad-single-product-details .woocommerce-tabs .wc-tabs li a' => 'color: {{VALUE}};'
                ]
            ]
        );

        $this->add_control(
            'exad_product_tabs_control_normal_bg_color',
            [
                'label'     => esc_html__('Background Color', 'exclusive-addons-elementor-pro'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .exad-single-product-details .woocommerce-tabs .wc-tabs li a' => 'background: {{VALUE}};'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'                 => 'exad_product_tabs_control_normal_border',
                'fields_options'       => [
                    'border'           => [
                        'default'      => 'solid'
                    ],
                    'width'            => [
                        'default'      => [
                            'top'      => '0',
                            'right'    => '0',
                            'bottom'   => '2',
                            'left'     => '0',
                            'isLinked' => false
                        ]
                    ],
                    'color'            => [
                        'default'      => 'rgba(255,255,255,0)'
                    ]
                ],
                'selector'             => '{{WRAPPER}} .exad-single-product-details .woocommerce-tabs .wc-tabs li a'
            ]
        );

        $this->add_control(
            'exad_product_tabs_control_normal_border_radius',
            [
                'label'   => esc_html__('Border Radius', 'exclusive-addons-elementor-pro'),
                'type'    => Controls_Manager::SLIDER,
                'range'   => [
                    'px'  => [
                        'max' => 30
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .exad-single-product-details .woocommerce-tabs .wc-tabs li a' => 'border-radius: {{SIZE}}px;'
                ]
            ]
        );

        $this->end_controls_tab();

        // Hover State Tab
        $this->start_controls_tab('exad_product_tabs_control_btn_hover', ['label' => esc_html__('Hover', 'exclusive-addons-elementor-pro')]);

        $this->add_control(
            'exad_product_tabs_control_hover_text_color',
            [
                'label'     => esc_html__('Text Color', 'exclusive-addons-elementor-pro'),
                'type'      => Controls_Manager::COLOR,
                'default'   => $exad_primary_color,
                'selectors' => [
                    '{{WRAPPER}} .exad-single-product-details .woocommerce-tabs .wc-tabs li a:hover' => 'color: {{VALUE}};'
                ]
            ]
        );

        $this->add_control(
            'exad_product_tabs_control_hover_bg_color',
            [
                'label'     => esc_html__('Background Color', 'exclusive-addons-elementor-pro'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .exad-single-product-details .woocommerce-tabs .wc-tabs li a:hover'      => 'background: {{VALUE}};'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'exad_product_tabs_control_hover_border',
                'selector' => '{{WRAPPER}} .exad-single-product-details .woocommerce-tabs .wc-tabs li a:hover'
            ]
        );

        $this->add_control(
            'exad_product_tabs_control_hover_border_radius',
            [
                'label'       => esc_html__('Border Radius', 'exclusive-addons-elementor-pro'),
                'type'        => Controls_Manager::SLIDER,
                'range'       => [
                    'px'      => [
                        'max' => 30
                    ]
                ],
                'selectors'   => [
                    '{{WRAPPER}} .exad-single-product-details .woocommerce-tabs .wc-tabs li a:hover' => 'border-radius: {{SIZE}}px;'
                ]
            ]
        );

        $this->end_controls_tab();

        // Active State Tab
        $this->start_controls_tab('exad_product_tabs_control_btn_active', ['label' => esc_html__('Active', 'exclusive-addons-elementor-pro')]);

        $this->add_control(
            'exad_product_tabs_control_active_text_color',
            [
                'label'     => esc_html__('Text Color', 'exclusive-addons-elementor-pro'),
                'type'      => Controls_Manager::COLOR,
                'default'   => $exad_primary_color,
                'selectors' => [
                    '{{WRAPPER}} .exad-single-product-details .woocommerce-tabs .wc-tabs li.active a' => 'color: {{VALUE}};'
                ]
            ]
        );

        $this->add_control(
            'exad_product_tabs_control_active_bg_color',
            [
                'label'     => esc_html__('Background Color', 'exclusive-addons-elementor-pro'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .exad-single-product-details .woocommerce-tabs .wc-tabs li.active a' => 'background: {{VALUE}};'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'                 => 'exad_product_tabs_control_active_border',
                'fields_options'       => [
                    'border'           => [
                        'default'      => 'solid'
                    ],
                    'width'            => [
                        'default'      => [
                            'top'      => '0',
                            'right'    => '0',
                            'bottom'   => '2',
                            'left'     => '0',
                            'isLinked' => false
                        ]
                    ],
                    'color'            => [
                        'default'      => $exad_primary_color
                    ]
                ],
                'selector'             => '{{WRAPPER}} .exad-single-product-details .woocommerce-tabs .wc-tabs li.active a'
            ]
        );

        $this->add_control(
            'exad_product_tabs_control_active_border_radius',
            [
                'label'       => esc_html__('Border Radius', 'exclusive-addons-elementor-pro'),
                'type'        => Controls_Manager::SLIDER,
                'range'       => [
                    'px'      => [
                        'max' => 30
                    ]
                ],
                'selectors'   => [
                    '{{WRAPPER}} .exad-single-product-details .woocommerce-tabs .wc-tabs li.active a' => 'border-radius: {{SIZE}}px;'
                ]
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();

		/*
		* Tabs panel Styling Section
		*/
		$this->start_controls_section(
			'exad_tabs_panel_content_style',
			[
				'label' => __( 'Tab Panel', 'exclusive-addons-elementor-pro' ),
				'tab'   => Controls_Manager::TAB_STYLE
			]
		);

		$this->add_control(
			'exad_tabs_panel_content_bg_color',
			[
				'label'     => __( 'Background Color', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .exad-single-product-details .woocommerce-tabs .woocommerce-Tabs-panel' => 'background-color: {{VALUE}};'
				]

			]
		);

		$this->add_responsive_control(
			'exad_tabs_panel_content_margin',
			[
				'label'         => esc_html__( 'Margin', 'exclusive-addons-elementor-pro' ),
				'type'          => Controls_Manager::DIMENSIONS,
				'size_units'    => [ 'px', 'em', '%' ],
				'selectors'     => [
					'{{WRAPPER}} .exad-single-product-details .woocommerce-tabs .woocommerce-Tabs-panel' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
		);

		$this->add_control(
			'exad_tabs_panel_content_padding',
			[
				'label'      => esc_html__( 'Padding', 'exclusive-addons-elementor-pro' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%'],
				'default'    => [
					'top'      => '20',
					'right'    => '20',
					'bottom'   => '20',
					'left'     => '20'
				],
				'selectors'  => [
					'{{WRAPPER}} .exad-single-product-details .woocommerce-tabs .woocommerce-Tabs-panel'=> 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'      => 'exad_tabs_panel_content_border',
				'selector'  => '{{WRAPPER}} .exad-single-product-details .woocommerce-tabs .woocommerce-Tabs-panel'
			]
		);

		$this->add_control(
			'exad_tabs_panel_content_box_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'exclusive-addons-elementor-pro' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px'],
				'selectors'  => [
					'{{WRAPPER}} .exad-single-product-details .woocommerce-tabs .woocommerce-Tabs-panel'=> 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'      => 'exad_tabs_panel_content_box_shadow',
				'selector'  => '{{WRAPPER}} .exad-single-product-details .woocommerce-tabs .woocommerce-Tabs-panel'
			]
		);

		$this->end_controls_section();

		/*
		* Tabs Title Styling Section
		*/
		$this->start_controls_section(
            'exad_product_tabs_title',
            [
				'label'     => __( 'Title', 'exclusive-addons-elementor-pro' ),
				'tab'       => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'exad_product_tabs_title_margin',
            [
                'label'         => esc_html__( 'Margin', 'exclusive-addons-elementor-pro' ),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => [ 'px', 'em', '%' ],                 
                'selectors'     => [
                    '{{WRAPPER}} .exad-single-product-details .woocommerce-tabs .woocommerce-Tabs-panel h2' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .exad-single-product-details .woocommerce-tabs .woocommerce-Tabs-panel h3' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

		$this->add_responsive_control(
			'exad_product_tabs_title_alignment',
			[
				'label'   => __( 'Title Alignment', 'exclusive-addons-elementor-pro' ),
				'type'    => Controls_Manager::CHOOSE,
				'toggle'  => false,
				'options' => [
					'left'		=> [
						'title' => __( 'Left', 'exclusive-addons-elementor-pro' ),
						'icon'  => 'eicon-text-align-left'
					],
					'center' 	=> [
						'title' => __( 'Center', 'exclusive-addons-elementor-pro' ),
						'icon' 	=> 'eicon-text-align-center'
					],
					'right' 	=> [
						'title' => __( 'Right', 'exclusive-addons-elementor-pro' ),
						'icon'  => 'eicon-text-align-right'
					]
				],
				'selectors' => [
					'{{WRAPPER}} .exad-single-product-details .woocommerce-tabs .woocommerce-Tabs-panel h2' => 'text-align: {{VALUE}};',
					'{{WRAPPER}} .exad-single-product-details .woocommerce-tabs .woocommerce-Tabs-panel h3' => 'text-align: {{VALUE}};',
				]
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'exad_product_tabs_title_typography',
				'selector' => '{{WRAPPER}} .exad-single-product-details .woocommerce-tabs .woocommerce-Tabs-panel h2, {{WRAPPER}} .exad-single-product-details.exad .woocommerce-tabs .woocommerce-Tabs-panel h3'
			]
		);

		$this->add_control(
			'exad_product_tabs_title_color',
			[
				'label'     => __( 'Color', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#1B1D26',
				'selectors' => [
					'{{WRAPPER}} .exad-single-product-details .woocommerce-tabs .woocommerce-Tabs-panel h2' => 'color: {{VALUE}};',
					'{{WRAPPER}} .exad-single-product-details .woocommerce-tabs .woocommerce-Tabs-panel h3' => 'color: {{VALUE}};'
				]	
			]
		);
	
		$this->end_controls_section();

		
		/*
		* description Styling Section
		*/
		$this->start_controls_section(
            'exad_tab_panel_description_style_section',
            [
                'label' => esc_html__( 'Description', 'exclusive-addons-elementor-pro' ),
				'tab'   => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_control(
			'exad_tab_panel_description_color',
			[
				'label'     => esc_html__( 'Color', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#000000',
				'selectors' => [
					'{{WRAPPER}} .exad-single-product-details .woocommerce-tabs .woocommerce-Tabs-panel p' => 'color: {{VALUE}};'
				]
			]
		);

		$this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'exad_tab_panel_description_typography',
                'selector' => '{{WRAPPER}} .exad-single-product-details .woocommerce-tabs .woocommerce-Tabs-panel'
            ]
        );

		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name' => 'exad_tab_panel_description_text_shadow',
				'label' => __( 'Text Shadow', 'exclusive-addons-elementor-pro' ),
				'selector' => '{{WRAPPER}} .exad-single-product-details .woocommerce-tabs .woocommerce-Tabs-panel'
			]
		);

		$this->end_controls_section();
		
		 /**
         * -------------------------------------------
         * Tab Style Table Style
         * -------------------------------------------
         */ 
        $this->start_controls_section(
            'exad_tab_panel_table_tables_style',
            [
                'label' => esc_html__('Tables', 'exclusive-addons-elementor-pro'),
                'tab'   => Controls_Manager::TAB_STYLE
            ]
        );
        
        $this->add_control(
            'exad_tab_panel_table_style',
            [
                'label'     => esc_html__('Table', 'exclusive-addons-elementor-pro'),
                'type'      => Controls_Manager::HEADING
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'exad_tab_panel_table_typography',
                'selector' => ' {{WRAPPER}} .exad-single-product-details .woocommerce-tabs .woocommerce-Tabs-panel table thead th, {{WRAPPER}} .exad-single-product-details .woocommerce-tabs .woocommerce-Tabs-panel table tbody td, {{WRAPPER}} .exad-single-product-details .woocommerce-tabs .woocommerce-Tabs-panel table tfoot td',
                'fields_options'     => [
                    'text_transform' => [
                        'default'    => 'capitalize'
                    ]
                ]
            ]
        );

        $this->add_control(
			'exad_tab_panel_table_row_vertical_alignment',
			[
				'label'   => __( 'Vertical Alignment', 'exclusive-addons-elementor-pro' ),
				'type'    => Controls_Manager::CHOOSE,
				'options' => [
					'top' => [
						'title'  => __( 'Top', 'exclusive-addons-elementor-pro' ),
						'icon'   => 'eicon-v-align-top'
					],
					'middle'     => [
						'title'  => __( 'Middle', 'exclusive-addons-elementor-pro' ),
						'icon'   => 'eicon-v-align-middle'
					],
					'bottom'   => [
						'title'  => __( 'Bottom', 'exclusive-addons-elementor-pro' ),
						'icon'   => 'eicon-v-align-bottom'
					]
				],
				'default' => 'middle',
				'selectors' => [
					'{{WRAPPER}} .exad-single-product-details .woocommerce-tabs .woocommerce-Tabs-panel table tbody tr td, {{WRAPPER}} .exad-single-product-details .woocommerce-tabs .woocommerce-Tabs-panel table thead tr th' => 'vertical-align: {{VALUE}};'
				]
			]
		);

        $this->add_control(
			'exad_tab_panel_table_row_horizontal_alignment',
			[
				'label'   => __( 'Horizontal Alignment', 'exclusive-addons-elementor-pro' ),
				'type'    => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title'  => __( 'Left', 'exclusive-addons-elementor-pro' ),
						'icon'   => 'eicon-text-align-left'
					],
					'center'     => [
						'title'  => __( 'Center', 'exclusive-addons-elementor-pro' ),
						'icon'   => 'eicon-text-align-center'
					],
					'right'   => [
						'title'  => __( 'Right', 'exclusive-addons-elementor-pro' ),
						'icon'   => 'eicon-text-align-right'
					]
				],
				'default' => 'center',
				'selectors' => [
					'{{WRAPPER}} .exad-single-product-details .woocommerce-tabs .woocommerce-Tabs-panel table tbody tr td, {{WRAPPER}} .exad-single-product-details .woocommerce-tabs .woocommerce-Tabs-panel table thead tr th' => 'text-align: {{VALUE}};'
				]
			]
		);

        $this->add_responsive_control(
            'exad_tab_panel_table_padding',
            [
                'label'      => esc_html__('Padding', 'exclusive-addons-elementor-pro'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'default'    => [
                    'top'    => 10,
                    'right'  => 10,
                    'bottom' => 10,
                    'left'   => 10,
                    'unit'   => 'px'
                ],
                'selectors'  => [
                    '{{WRAPPER}} .exad-single-product-details .woocommerce-tabs .woocommerce-Tabs-panel table' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->add_control(
            'exad_tab_panel_table_bg_color',
            [
                'label'     => esc_html__('Background Color', 'exclusive-addons-elementor-pro'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .exad-single-product-details .woocommerce-tabs .woocommerce-Tabs-panel table' => 'background: {{VALUE}};'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'                 => 'exad_tab_panel_table_border',
                'fields_options'       => [
                    'border'           => [
                        'default'      => 'solid'
                    ],
                    'color'            => [
                        'default'      => 'rgba(255,255,255,0)'
                    ]
                ],
                'selector'             => '{{WRAPPER}} .exad-single-product-details .woocommerce-tabs .woocommerce-Tabs-panel table'
            ]
        );

        $this->add_control(
            'exad_tab_panel_table_border_radius',
            [
                'label'   => esc_html__('Border Radius', 'exclusive-addons-elementor-pro'),
                'type'    => Controls_Manager::SLIDER,
                'range'   => [
                    'px'  => [
                        'max' => 30
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .exad-single-product-details .woocommerce-tabs .woocommerce-Tabs-panel table' => 'border-radius: {{SIZE}}px;'
                ]
            ]
        );

        $this->add_control(
            'exad_tab_panel_table_header_style',
            [
                'label'     => esc_html__('Header', 'exclusive-addons-elementor-pro'),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'exad_tab_panel_table_header_typography',
                'selector' => '{{WRAPPER}} .exad-single-product-details .woocommerce-tabs .woocommerce-Tabs-panel table thead th',
                'fields_options'     => [
                    'text_transform' => [
                        'default'    => 'capitalize'
                    ]
                ]
            ]
        );

        $this->add_control(
            'exad_tab_panel_table_header_color',
            [
                'label'     => esc_html__('Header Color', 'exclusive-addons-elementor-pro'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#444444',
                'selectors' => [
                    '{{WRAPPER}} .exad-single-product-details .woocommerce-tabs .woocommerce-Tabs-panel table thead th' => 'color: {{VALUE}};'
                ]
            ]
        );

        $this->add_control(
            'exad_tab_panel_table_header_bg_color',
            [
                'label'     => esc_html__('Header Background Color', 'exclusive-addons-elementor-pro'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .exad-single-product-details .woocommerce-tabs .woocommerce-Tabs-panel table thead th'      => 'background: {{VALUE}};'
                ]
            ]
        );

        $this->add_responsive_control(
            'exad_tab_panel_table_header_padding',
            [
                'label'      => esc_html__('Padding', 'exclusive-addons-elementor-pro'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .exad-single-product-details .woocommerce-tabs .woocommerce-Tabs-panel table thead th' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'exad_tab_panel_table_header_border',
                'selector' => '{{WRAPPER}} .exad-single-product-details .woocommerce-tabs .woocommerce-Tabs-panel table thead th'
            ]
        );

        $this->add_control(
            'exad_tab_panel_table_row_style',
            [
                'label'     => esc_html__('Table Rows', 'exclusive-addons-elementor-pro'),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'exad_tab_panel_table_row_color',
            [
                'label'     => esc_html__('Row Color', 'exclusive-addons-elementor-pro'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#444444',
                'selectors' => [
                    '{{WRAPPER}} .exad-single-product-details .woocommerce-tabs .woocommerce-Tabs-panel table tbody tr td' => 'color: {{VALUE}};'
                ]
            ]
        );

        $this->add_control(
            'exad_tab_panel_table_row_bg_color',
            [
                'label'     => esc_html__('Row Background Color', 'exclusive-addons-elementor-pro'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .exad-single-product-details .woocommerce-tabs .woocommerce-Tabs-panel table tbody tr td'      => 'background: {{VALUE}};'
                ]
            ]
        );

        $this->add_control(
            'exad_tab_panel_table_even_row_color',
            [
                'label'     => esc_html__('Even Color', 'exclusive-addons-elementor-pro'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#444444',
                'selectors' => [
                    '{{WRAPPER}} .exad-single-product-details .woocommerce-tabs .woocommerce-Tabs-panel table tbody tr:nth-child(even) td' => 'color: {{VALUE}};'
                ]
            ]
        );

        $this->add_control(
            'exad_tab_panel_table_even_row_bg_color',
            [
                'label'     => esc_html__('Even Background Color', 'exclusive-addons-elementor-pro'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .exad-single-product-details .woocommerce-tabs .woocommerce-Tabs-panel table tbody tr:nth-child(even) td'      => 'background: {{VALUE}};'
                ]
            ]
        );

        $this->add_control(
            'exad_tab_panel_table_cell_style',
            [
                'label'     => esc_html__('Table Cell', 'exclusive-addons-elementor-pro'),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_responsive_control(
            'exad_tab_panel_table_cell_padding',
            [
                'label'      => esc_html__('Padding', 'exclusive-addons-elementor-pro'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .exad-single-product-details .woocommerce-tabs .woocommerce-Tabs-panel table tbody tr td' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'                 => 'exad_tab_panel_table_cell_border',
                'fields_options'       => [
                    'border'           => [
                        'default'      => 'solid'
                    ],
                    'color'            => [
                        'default'      => '#ccc'
                    ]
                ],
                'selector'             => '{{WRAPPER}} .exad-single-product-details .woocommerce-tabs .woocommerce-Tabs-panel table tbody tr td'
            ]
        );

        $this->add_control(
            'exad_tab_panel_table_footer_style',
            [
                'label'     => esc_html__('Table Footer', 'exclusive-addons-elementor-pro'),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'exad_tab_panel_table_footer_typography',
                'selector' => '{{WRAPPER}} .exad-single-product-details .woocommerce-tabs .woocommerce-Tabs-panel table tfoot td',
                'fields_options'     => [
                    'text_transform' => [
                        'default'    => 'capitalize'
                    ]
                ]
            ]
        );

        $this->add_control(
            'exad_tab_panel_table_footer_color',
            [
                'label'     => esc_html__('Footer Color', 'exclusive-addons-elementor-pro'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#444444',
                'selectors' => [
                    '{{WRAPPER}} .exad-single-product-details .woocommerce-tabs .woocommerce-Tabs-panel table tfoot td' => 'color: {{VALUE}};'
                ]
            ]
        );

        $this->add_control(
            'exad_tab_panel_table_footer_bg_color',
            [
                'label'     => esc_html__('Footer Background Color', 'exclusive-addons-elementor-pro'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .exad-single-product-details .woocommerce-tabs .woocommerce-Tabs-panel table tfoot td'      => 'background: {{VALUE}};'
                ]
            ]
        );

        $this->add_responsive_control(
            'exad_tab_panel_table_footer_padding',
            [
                'label'      => esc_html__('Padding', 'exclusive-addons-elementor-pro'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .exad-single-product-details .woocommerce-tabs .woocommerce-Tabs-panel table tfoot td' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'exad_tab_panel_table_footer_border',
                'selector' => '{{WRAPPER}} .exad-single-product-details .woocommerce-tabs .woocommerce-Tabs-panel table tfoot td'
            ]
        );

        $this->end_controls_section();

        /*
		* Before & After Tabs Styling Section
		*/
		$this->start_controls_section(
            'exad_product_tabs_info_before_after_style_section',
            [
                'label' => esc_html__( 'Before & After Style', 'exclusive-addons-elementor-pro' ),
				'tab'   => Controls_Manager::TAB_STYLE
            ]
        );

		$this->add_control(
			'exad_product_tabs_info_before_style',
			[
				'label'     => __( 'Before Tabs', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before'
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'             => 'exad_product_tabs_info_before_typography',
				'selector'         => '{{WRAPPER}} .exad-single-product-details .product-tabs-info-before',
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
			'exad_product_tabs_info_before_color',
			[
				'label'     => __( 'Color', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#333333',
				'selectors' => [
					'{{WRAPPER}} .exad-single-product-details .product-tabs-info-before' => 'color: {{VALUE}};'
				]
			]
		);

		$this->add_responsive_control(
			'exad_product_tabs_info_before_margin',
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
					'{{WRAPPER}} .exad-single-product-details .product-tabs-info-before' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
		);

        $this->add_control(
			'exad_product_tabs_info_after_style',
			[
				'label'     => __( 'After Tabs', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before'
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'             => 'exad_product_tabs_info_after_typography',
				'selector'         => '{{WRAPPER}} .exad-single-product-details .product-tabs-info-after',
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
			'exad_product_tabs_info_after_color',
			[
				'label'     => __( 'Color', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#333333',
				'selectors' => [
					'{{WRAPPER}} .exad-single-product-details .product-tabs-info-after' => 'color: {{VALUE}};'
				]
			]
		);

		$this->add_responsive_control(
			'exad_product_tabs_info_after_margin',
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
					'{{WRAPPER}} .exad-single-product-details .product-tabs-info-after' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
		);
		$this-> end_controls_section();

        /**
		 * Reviewer Title Style Section
		 */
		$this->start_controls_section(
			'exad_product_tabs_reviewes_style',
			[
				'label' => esc_html__( 'Rivewer', 'exclusive-addons-elementor-pro' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

        $this->add_control(
			'exad_product_tabs_reviewes_title_style',
			[
				'label' => __( 'Reviewer Image', 'exclusive-addons-elementor-pro' ),
				'type'  => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'exad_product_tabs_reviewes_image_box_height',
			[
				'label'       => __( 'Height', 'exclusive-addons-elementor-pro' ),
				'type'        => Controls_Manager::SLIDER,
				'size_units'  => [ 'px' ],
				'range'       => [
					'px'      => [
						'min' => 0,
						'max' => 500
					]
				],
				'default'     => [
					'unit'    => 'px',
					'size'    => 32
				],
				'selectors'   => [
					'.woocommerce {{WRAPPER}} .exad-single-product-details #reviews #comments ol.commentlist li img.avatar'=> 'height: {{SIZE}}{{UNIT}};'
				],
			]
		);

		$this->add_responsive_control(
			'exad_product_tabs_reviewes_image_box_width',
			[
				'label'       => __( 'Width', 'exclusive-addons-elementor-pro' ),
				'type'        => Controls_Manager::SLIDER,
				'range'       => [
					'px'      => [
						'min' => 0,
						'max' => 500
					]
				],
				'default'     => [
					'unit'    => 'px',
					'size'    => 32
				],
				'selectors'   => [
					'.woocommerce {{WRAPPER}} .exad-single-product-details #reviews #comments ol.commentlist li img.avatar'=> 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

        
		$this->add_responsive_control(
			'exad_product_tabs_reviewes_image_box_radius',
			[
				'label'      => __( 'Border radius', 'exclusive-addons-elementor-pro' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'default'    => [
					'top'    => '0',
					'right'  => '0',
					'bottom' => '0',
					'left'   => '0',
					'unit'   => '%',
                    'isLinked' => false
				],
				'selectors'  => [
					'.woocommerce {{WRAPPER}} .exad-single-product-details #reviews #comments ol.commentlist li img.avatar'     => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				]
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'      => 'exad_product_tabs_reviewes_image_box_border',
				'selector'  => '.woocommerce {{WRAPPER}} .exad-single-product-details #reviews #comments ol.commentlist li img.avatar',
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'exad_product_tabs_reviewes_image_box_shadow',
				'selector' => '.woocommerce {{WRAPPER}} .exad-single-product-details #reviews #comments ol.commentlist li img.avatar'
			]
		);

		$this->add_responsive_control(
			'exad_product_tabs_reviewes_image_box_margin_left',
			[
				'label'       => __( 'Right Spacing', 'exclusive-addons-elementor-pro' ),
				'type'        => Controls_Manager::SLIDER,
				'size_units'  => [ 'px' ],
				'range'       => [
					'px'      => [
						'min' => -50,
						'max' => 100
					]
				],
				'default'     => [
					'unit'    => 'px',
					'size'    => 50
				],
				'selectors'   => [
					'.woocommerce {{WRAPPER}} .exad-single-product-details #reviews #comments ol.commentlist li .comment-text'=> 'margin-left: {{SIZE}}{{UNIT}};'
				],
			]
		);
    
		/**
		 * Reviewer Name Style Section
		 */

		$this->add_control(
			'exad_product_tabs_reviewes_image_style',
			[
				'label' => __( 'Reviewer Name', 'exclusive-addons-elementor-pro' ),
				'type'  => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'exad_product_tabs_reviewes_title_typography',
				'label'    => __( 'Typography', 'exclusive-addons-elementor-pro' ),
				'selector' => '{{WRAPPER}} .exad-single-product-details .woocommerce-Tabs-panel .woocommerce-review__author',
			]
		);

		$this->add_control(
			'exad_product_tabs_reviewes_title_color',
			[
				'label' => __( 'Color', 'exclusive-addons-elementor-pro' ),
				'type'  => Controls_Manager::COLOR,
				'default' => '#222222',
				'selectors' => [
					'{{WRAPPER}} .exad-single-product-details .woocommerce-Tabs-panel .woocommerce-review__authora' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'exad_product_tabs_reviewes_title_margin',
			[
				'label' => __( 'Margin', 'exclusive-addons-elementor-pro' ),
				'type'  => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'default' => [
					'top' => '0',
					'right' => '0',
					'bottom' => '0',
					'left' => '0',
                    'isLinked' => false
				],
				'selectors' => [
					'{{WRAPPER}} .exad-single-product-details .woocommerce-Tabs-panel .woocommerce-review__author' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		/**
		 * Reviewer date Style Section
		 */

		$this->add_control(
			'exad_product_tabs_reviewes_date_style',
			[
				'label' => __( 'Reviewer Date', 'exclusive-addons-elementor-pro' ),
				'type'  => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'exad_product_tabs_reviewes_date_typography',
				'label'     => __( 'Typography', 'exclusive-addons-elementor-pro' ),
				'selector'  => '{{WRAPPER}} .exad-single-product-details .woocommerce-Tabs-panel .woocommerce-review__published-date',
			]
		);

		$this->add_control(
			'exad_product_tabs_reviewes_date_color',
			[
				'label' => __( 'Color', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#222222',
				'selectors' => [
					'{{WRAPPER}} .exad-single-product-details .woocommerce-Tabs-panel .woocommerce-review__published-date' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'exad_product_tabs_reviewes_date_margin',
			[
				'label' => __( 'Margin', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'default' => [
					'top' => '0',
					'right' => '0',
					'bottom' => '0',
					'left' => '0',
                    'isLinked' => false
				],
				'selectors' => [
					'{{WRAPPER}} .exad-single-product-details .woocommerce-Tabs-panel .woocommerce-review__published-date' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		/**
		 * Reviewer Description Style Section description
		 */

		$this->add_control(
			'exad_product_tabs_reviewes_description_style',
			[
				'label' => __( 'Reviewer Description', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'exad_product_tabs_reviewes_date',
				'label'    => __( 'Typography', 'exclusive-addons-elementor-pro' ),
				'selector' => '{{WRAPPER}} .exad-single-product-details .woocommerce-Tabs-panel .description',
			]
		);

		$this->add_control(
			'exad_product_tabs_reviewes_description_color',
			[
				'label' => __( 'Color', 'exclusive-addons-elementor-pro' ),
				'type'  => Controls_Manager::COLOR,
				'default' => '#222222',
				'selectors' => [
					'{{WRAPPER}} .exad-single-product-details .woocommerce-Tabs-panel .description' => 'color: {{VALUE}};',
				],
			]
		);

        $this->add_control(
            'exad_product_tabs_description_normal_bg_color',
            [
                'label'     => esc_html__('Background Color', 'exclusive-addons-elementor-pro'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '.woocommerce {{WRAPPER}} .exad-single-product-details #reviews #comments ol.commentlist li .comment-text' => 'background: {{VALUE}};'
                ]
            ]
        );

        $this->add_responsive_control(
			'exad_product_tabs_reviewes_description_padding',
			[
				'label' => __( 'Padding', 'exclusive-addons-elementor-pro' ),
				'type'  => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'default' => [
					'top' => '20',
					'right' => '20',
					'bottom' => '20',
					'left' => '20',
                    'isLinked' => false
				],
				'selectors' => [
					'.woocommerce {{WRAPPER}} .exad-single-product-details #reviews #comments ol.commentlist li .comment-text' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

                
		$this->add_responsive_control(
			'exad_product_tabs_reviewes_description_radius',
			[
				'label'      => __( 'Border radius', 'exclusive-addons-elementor-pro' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'default'    => [
					'top'    => '0',
					'right'  => '0',
					'bottom' => '0',
					'left'   => '0',
					'unit'   => '%',
                    'isLinked' => false
				],
				'selectors'  => [
					'.woocommerce {{WRAPPER}} .exad-single-product-details #reviews #comments ol.commentlist li .comment-text'     => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				]
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'      => 'exad_product_tabs_reviewes_description_border',
				'selector'  => '.woocommerce {{WRAPPER}} .exad-single-product-details #reviews #comments ol.commentlist li .comment-text',
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'exad_product_tabs_reviewes_description_box_shadow',
				'selector' => '.woocommerce {{WRAPPER}} .exad-single-product-details #reviews #comments ol.commentlist li .comment-text'
			]
		);

        /**
		 * Reviewer rating Style Section
		 */

		$this->add_control(
			'exad_product_tabs_reviewes_rating_style',
			[
				'label' => __( 'Rating', 'exclusive-addons-elementor-pro' ),
				'type'  => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'exad_product_tabs_reviewes_rating_size',
			[
				'label'       => __( 'Icon Size', 'exclusive-addons-elementor-pro' ),
				'type'        => Controls_Manager::SLIDER,
				'size_units'  => [ 'px', '%' ],
				'range'       => [
					'px'      => [
						'min' => 0,
						'max' => 50
					]
				],
				'default'     => [
					'unit'    => 'px',
					'size'    => 20
				],
				'selectors'   => [
					'{{WRAPPER}} .exad-single-product-details .woocommerce-Tabs-panel .star-rating' => 'font-size: {{SIZE}}{{UNIT}};'
				]
			]
		);

		$this->add_responsive_control(
			'exad_product_tabs_reviewes_rating_icon_margin',
			[
				'label'       => __( 'Icon Margin', 'exclusive-addons-elementor-pro' ),
				'type'        => Controls_Manager::SLIDER,
				'size_units'  => [ 'px', '%' ],
				'range'       => [
					'px'      => [
						'min' => 0,
						'max' => 30
					]
				],
				'default'     => [
					'unit'    => 'px',
					'size'    => 5
				],
				'selectors'   => [
					'{{WRAPPER}} .exad-single-product-details .woocommerce-Tabs-panel .star-rating' => 'margin-right: {{SIZE}}{{UNIT}};'
				]
			]
		);

		$this->start_controls_tabs( 'exad_product_tabs_reviewes_rating_tabs' );

			// normal state rating
			$this->start_controls_tab( 'exad_product_tabs_reviewes_rating_normal', [ 'label' => esc_html__( 'Normal', 'exclusive-addons-elementor-pro' ) ] );

				$this->add_control(
					'exad_product_tabs_reviewes_rating_normal_color',
					[
						'label'     => __( 'Color', 'exclusive-addons-elementor-pro' ),
						'type'      => Controls_Manager::COLOR,
						'default'   => '#222222',
						'selectors' => [
                            '{{WRAPPER}} .exad-single-product-details .woocommerce-Tabs-panel .star-rating::before' => 'color: {{VALUE}} !important;',
						]
					]
				);

			$this->end_controls_tab();

			// hover state rating
			$this->start_controls_tab( 'exad_product_tabs_reviewes_rating_active', [ 'label' => esc_html__( 'Active', 'exclusive-addons-elementor-pro' ) ] );

				$this->add_control(
					'exad_product_tabs_reviewes_rating_active_color',
					[
						'label'     => __( 'Color', 'exclusive-addons-elementor-pro' ),
						'type'      => Controls_Manager::COLOR,
						'default'   => '#ff5b84',
						'selectors' => [
							'{{WRAPPER}} .exad-single-product-details .woocommerce-Tabs-panel .star-rating' => 'color: {{VALUE}};'
						]
					]
				);

			$this->end_controls_tab();

		$this->end_controls_tabs();

		$this-> end_controls_section();


         /**
         * -------------------------------------------
         * Tab Style Form Style
         * -------------------------------------------
         */ 
        $this->start_controls_section(
            'exad_product_tabs_reviewes_form_style',
            [
                'label' => esc_html__('Form', 'exclusive-addons-elementor-pro'),
                'tab'   => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_control(
            'exad_product_tabs_reviewes_form_container_style',
            [
                'label' => esc_html__('Form Container', 'exclusive-addons-elementor-pro'),
                'type'  => Controls_Manager::HEADING
            ]
        );

        $this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'exad_product_tabs_reviewes_form_container_background',
				'types'    => [ 'classic', 'gradient' ],
				'selector' => '.woocommerce {{WRAPPER}} .exad-single-product-details #review_form #respond .comment-form'
			]
		);

        $this->add_responsive_control(
			'exad_product_tabs_reviewes_form_container_margin',
			[
				'label'      => __( 'Margin', 'exclusive-addons-elementor-pro' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'default'    => [
					'top'    => '10',
					'right'  => '10',
					'bottom' => '10',
					'left'   => '10'
				],
				'selectors'  => [
					'.woocommerce {{WRAPPER}} .exad-single-product-details #review_form #respond .comment-form' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
		);

        $this->add_responsive_control(
			'exad_product_tabs_reviewes_form_container_padding',
			[
				'label'      => __( 'Padding', 'exclusive-addons-elementor-pro' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'default'    => [
					'top'    => '20',
					'right'  => '20',
					'bottom' => '20',
					'left'   => '20'
				],
				'selectors'  => [
					'.woocommerce {{WRAPPER}} .exad-single-product-details #review_form #respond .comment-form' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
		);

        $this->add_responsive_control(
			'exad_product_tabs_reviewes_form_container_radius',
			[
				'label'      => __( 'Border radius', 'exclusive-addons-elementor-pro' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'separator'  => 'after',
				'default'    => [
					'top'    => '10',
					'right'  => '10',
					'bottom' => '10',
					'left'   => '10'
				],
				'selectors'  => [
					'.woocommerce {{WRAPPER}} .exad-single-product-details #review_form #respond .comment-form' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
		);

        $this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'            => 'exad_product_tabs_reviewes_form_container_border',
				'fields_options'  => [
                    'border'      => [
                        'default' => 'solid'
                    ],
                    'width'          => [
                        'default'    => [
							'top'    => '1',
							'right'  => '1',
							'bottom' => '1',
							'left'   => '1'
                        ]
                    ],
                    'color'       => [
                        'default' => '#e3e3e3'
                    ]
				],
				'selector'        => '.woocommerce {{WRAPPER}} .exad-single-product-details #review_form #respond .comment-form'
			]
		);

        $this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'exad_product_tabs_reviewes_form_container_box_shadow',
				'selector' => '.woocommerce {{WRAPPER}} .exad-single-product-details #review_form #respond .comment-form'
			]
		);

        $this->add_control(
            'exad_product_tabs_reviewes_form_label_style',
            [
                'label'     => esc_html__('Label', 'exclusive-addons-elementor-pro'),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'exad_product_tabs_reviewes_form_label_typography',
                'selector' => '.woocommerce {{WRAPPER}} .exad-single-product-details #review_form #respond .comment-form label',
                'fields_options'     => [
                    'text_transform' => [
                        'default'    => 'capitalize'
                    ]
                ]
            ]
        );

        $this->add_control(
            'exad_product_tabs_reviewes_form_label_color',
            [
                'label'     => esc_html__('Label Color', 'exclusive-addons-elementor-pro'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#444444',
                'selectors' => [
                    '.woocommerce {{WRAPPER}} .exad-single-product-details #review_form #respond .comment-form label' => 'color: {{VALUE}};'
                ]
            ]
        );

        $this->add_responsive_control(
            'exad_product_tabs_reviewes_form_label_bottom_spacing',
            [
                'label'        => esc_html__( 'Label Bottom Spacing', 'exclusive-addons-elementor-pro' ),
                'type'         => Controls_Manager::SLIDER,
                'range'        => [
                    'px'       => [
                        'min'  => 0,
                        'max'  => 100,
                        'step' => 1
                    ]
                ],
                'selectors'    => [
                    '.woocommerce {{WRAPPER}} .exad-single-product-details #review_form #respond .comment-form label' => 'margin-bottom: {{SIZE}}px;'
                ]
            ]
        );

        $this->add_control(
            'exad_product_tabs_reviewes_form_input_style',
            [
                'label'     => esc_html__('Input', 'exclusive-addons-elementor-pro'),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'exad_product_tabs_reviewes_form_input_field_typography',
                'selector' => '.woocommerce {{WRAPPER}} .exad-single-product-details #review_form #respond .comment-form input[type="text"],
                        .woocommerce {{WRAPPER}} .exad-single-product-details #review_form #respond .comment-form input[type="email"],
                        .woocommerce {{WRAPPER}} .exad-single-product-details #review_form #respond .comment-form input[type="url"],
                        .woocommerce {{WRAPPER}} .exad-single-product-details #review_form #respond .comment-form input[type="password"],
                        .woocommerce {{WRAPPER}} .exad-single-product-details #review_form #respond .comment-form input[type="search"],
                        .woocommerce {{WRAPPER}} .exad-single-product-details #review_form #respond .comment-form input[type="number"],
                        .woocommerce {{WRAPPER}} .exad-single-product-details #review_form #respond .comment-form input[type="tel"],
                        .woocommerce {{WRAPPER}} .exad-single-product-details #review_form #respond .comment-form input[type="range"],
                        .woocommerce {{WRAPPER}} .exad-single-product-details #review_form #respond .comment-form input[type="date"],
                        .woocommerce {{WRAPPER}} .exad-single-product-details #review_form #respond .comment-form input[type="month"],
                        .woocommerce {{WRAPPER}} .exad-single-product-details #review_form #respond .comment-form input[type="week"],
                        .woocommerce {{WRAPPER}} .exad-single-product-details #review_form #respond .comment-form input[type="time"],
                        .woocommerce {{WRAPPER}} .exad-single-product-details #review_form #respond .comment-form input[type="datetime"],
                        .woocommerce {{WRAPPER}} .exad-single-product-details #review_form #respond .comment-form input[type="datetime-local"],
                        .woocommerce {{WRAPPER}} .exad-single-product-details #review_form #respond .comment-form input[type="color"],
                        .woocommerce {{WRAPPER}} .exad-single-product-details #review_form #respond .comment-form .select2-selection__placeholder,
                        .woocommerce {{WRAPPER}} .exad-single-product-details #review_form #respond .comment-form textarea'
            ]
        );
        
        $this->add_control(
            'exad_product_tabs_reviewes_form_input_field_text_color',
            [
                'label'     => __( 'Text Color', 'exclusive-addons-elementor-pro' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '.woocommerce {{WRAPPER}} .exad-single-product-details #review_form #respond .comment-form input, .woocommerce {{WRAPPER}} .exad-single-product-details #review_form #respond .comment-form textarea, .woocommerce {{WRAPPER}} .exad-single-product-details #review_form #respond .comment-form .select2-selection__placeholder' => 'color: {{VALUE}}'
                ]
            ]
        );

        $this->add_control(
            'exad_product_tabs_reviewes_form_input_field_placeholder_color',
            [
                'label'     => __( 'Placeholder Text Color', 'exclusive-addons-elementor-pro' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '.woocommerce {{WRAPPER}} .exad-single-product-details #review_form #respond .comment-form input[type="text"]::placeholder,
                    .woocommerce {{WRAPPER}} .exad-single-product-details #review_form #respond .comment-form input[type="email"]::placeholder,
                    .woocommerce {{WRAPPER}} .exad-single-product-details #review_form #respond .comment-form input[type="url"]::placeholder,
                    .woocommerce {{WRAPPER}} .exad-single-product-details #review_form #respond .comment-form input[type="password"]::placeholder,
                    .woocommerce {{WRAPPER}} .exad-single-product-details #review_form #respond .comment-form input[type="search"]::placeholder,
                    .woocommerce {{WRAPPER}} .exad-single-product-details #review_form #respond .comment-form input[type="number"]::placeholder,
                    .woocommerce {{WRAPPER}} .exad-single-product-details #review_form #respond .comment-form input[type="tel"]::placeholder,
                    .woocommerce {{WRAPPER}} .exad-single-product-details #review_form #respond .comment-form input[type="range"]::placeholder,
                    .woocommerce {{WRAPPER}} .exad-single-product-details #review_form #respond .comment-form input[type="date"]::placeholder,
                    .woocommerce {{WRAPPER}} .exad-single-product-details #review_form #respond .comment-form input[type="month"]::placeholder,
                    .woocommerce {{WRAPPER}} .exad-single-product-details #review_form #respond .comment-form input[type="week"]::placeholder,
                    .woocommerce {{WRAPPER}} .exad-single-product-details #review_form #respond .comment-form input[type="time"]::placeholder,
                    .woocommerce {{WRAPPER}} .exad-single-product-details #review_form #respond .comment-form input[type="datetime"]::placeholder,
                    .woocommerce {{WRAPPER}} .exad-single-product-details #review_form #respond .comment-form input[type="datetime-local"]::placeholder,
                    .woocommerce {{WRAPPER}} .exad-single-product-details #review_form #respond .comment-form input[type="color"]::placeholder,
                    .woocommerce {{WRAPPER}} .exad-single-product-details #review_form #respond .comment-form textarea::placeholder' => 'color: {{VALUE}};'
                ]
            ]
        );
  
        $this->add_control(
            'exad_product_tabs_reviewes_form_input_field_bg',
            [
                'label'     => __( 'Background Color', 'exclusive-addons-elementor-pro' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#ffffff',
                'selectors' => [
                    '.woocommerce {{WRAPPER}} .exad-single-product-details #review_form #respond .comment-form input, .woocommerce {{WRAPPER}} .exad-single-product-details #review_form #respond .comment-form textarea, .woocommerce {{WRAPPER}} .exad-single-product-details #review_form #respond .comment-form .select2-selection--single' => 'background-color: {{VALUE}}'
                ]
            ]
        );

        $this->add_responsive_control(
            'exad_product_tabs_reviewes_form_input_field_margin',
            [
                'label'      => __( 'Margin', 'exclusive-addons-elementor-pro' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors'  => [
                    '.woocommerce {{WRAPPER}} .exad-single-product-details #review_form #respond .comment-form input:not([type=checkbox]), .woocommerce {{WRAPPER}} .exad-single-product-details #review_form #respond .comment-form textarea, .woocommerce {{WRAPPER}} .exad-single-product-details #review_form #respond .comment-form .select2-container, .woocommerce {{WRAPPER}} .exad-single-product-details #review_form #respond .comment-form .select2-container .select2-selection--single' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
                'default'    => [
                    'top'    => 10,
                    'right'  => 0,
                    'bottom' => 0,
                    'left'   => 0,
                    'unit'   => 'px'
                ]
            ]
        );

        $this->add_responsive_control(
			'exad_product_tabs_reviewes_form_input_field_padding',
			[
                'label'      => __( 'Padding', 'exclusive-addons-elementor-pro' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'default'    => [
                    'unit'   => 'px',
					'size'   => 15
                ],
				'selectors'  => [
					'{{WRAPPER}} .exad-single-product-details #review_form #respond .comment-form input:not([type=checkbox]), {{WRAPPER}} .exad-single-product-details #review_form #respond .comment-form textarea, {{WRAPPER}} .exad-single-product-details #review_form #respond .comment-form .select2-selection__rendered, {{WRAPPER}} .exad-single-product-details #review_form #respond .comment-form .select2-container .select2-selection--single' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
        );

        $this->add_responsive_control(
            'exad_product_tabs_reviewes_form_input_field_height',
            [
                'label'        => esc_html__( 'Input Field Height', 'exclusive-addons-elementor-pro' ),
                'type'         => Controls_Manager::SLIDER,
                'range'        => [
                    'px'       => [
                        'min'  => 0,
                        'max'  => 150,
                        'step' => 1
                    ]
                ],
                'default'      => [
                    'unit'     => 'px',
                    'size'     => 40
                ],
                'selectors'    => [
                    '{{WRAPPER}} .exad-single-product-details #review_form #respond .comment-form .comment-form-author input[type="text"],
                     {{WRAPPER}} .exad-single-product-details #review_form #respond .comment-form .comment-form-email input[type="email"]' => 'height: {{SIZE}}px;'
                ]
            ]
        );

        $this->add_responsive_control(
            'exad_product_tabs_reviewes_form_input_field_width',
            [
                'label'         => __( 'Field Width', 'exclusive-addons-elementor-pro' ),
                'type'          => Controls_Manager::SLIDER,
                'range'         => [
                    'px'        => [
                        'min'   => 0,
                        'max'   => 1200,
                        'step'  => 1
                    ]
                ],
                'size_units'    => [ 'px', 'em', '%' ],
                'default'       => [
                    'unit'      => '%',
					'size'      => 100
                ],
                'selectors'     => [
                    '{{WRAPPER}} .exad-single-product-details #review_form #respond .comment-form .comment-form-author input[type="text"],
                     {{WRAPPER}} .exad-single-product-details #review_form #respond .comment-form .comment-form-email input[type="email"]' => 'width: {{SIZE}}{{UNIT}}'
                ]
            ]
        );

        $this->add_responsive_control(
            'exad_product_tabs_reviewes_form_input_field_bottom_spacing',
            [
                'label'        => esc_html__( 'Field Bottom Spacing', 'exclusive-addons-elementor-pro' ),
                'type'         => Controls_Manager::SLIDER,
                'range'        => [
                    'px'       => [
                        'min'  => 0,
                        'max'  => 100,
                        'step' => 1
                    ]
                ],
                'selectors'    => [
                    '.woocommerce {{WRAPPER}} .exad-single-product-details #review_form #respond .comment-form' => 'margin-bottom: {{SIZE}}px;'
                ]
            ]
        );

        $this->add_group_control(
			Group_Control_Border::get_type(),
			[
                'name'        => 'exad_product_tabs_reviewes_form_input_field_border',
                'selector'    => '{{WRAPPER}} .exad-single-product-details #review_form #respond .comment-form input:not([type=checkbox]), {{WRAPPER}} .exad-single-product-details #review_form #respond .comment-form textarea, {{WRAPPER}} .exad-single-product-details #review_form #respond .comment-form .select2-container .select2-selection--single'
			]
		);

		$this->add_responsive_control(
			'exad_product_tabs_reviewes_form_input_field_radius',
			[
                'label'      => __( 'Border Radius', 'exclusive-addons-elementor-pro' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors'  => [
					'.woocommerce {{WRAPPER}} .exad-single-product-details #review_form #respond .comment-form input:not([type=checkbox]), .woocommerce {{WRAPPER}} .exad-single-product-details #review_form #respond .comment-form textarea, .woocommerce {{WRAPPER}} .exad-single-product-details #review_form #respond .comment-form .select2-container .select2-selection--single' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
        );

        $this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'exad_product_tabs_reviewes_form_input_field_box_shadow',
				'selector' => '.woocommerce {{WRAPPER}} .exad-single-product-details #review_form #respond .comment-form input:not([type=checkbox]), .woocommerce {{WRAPPER}} .exad-single-product-details #review_form #respond .comment-form .form-submit input:not([type=submit]), .woocommerce {{WRAPPER}} .exad-single-product-details #review_form #respond .comment-form textarea, .woocommerce {{WRAPPER}} .exad-single-product-details #review_form #respond .comment-form .select2-container .select2-selection--single'
			]
		);

        /**
		 * Reviewer button Style Section
		 */
        $this->add_control(
            'exad_product_tabs_reviewes_form_btn_style',
            [
                'label'     => esc_html__('Button', 'exclusive-addons-elementor-pro'),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_responsive_control(
            'exad_product_tabs_reviewes_form_btn_alignment',
            [
                'label'   => __( 'Alignment', 'exclusive-addons-elementor-pro' ),
                'type'    => Controls_Manager::CHOOSE,
                'options' => [
                    'left'   => [
                        'title' => __( 'Left', 'exclusive-addons-elementor-pro' ),
                        'icon'  => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => __( 'Center', 'exclusive-addons-elementor-pro' ),
                        'icon'  => 'eicon-text-align-center',
                    ],
                    'right' => [
                        'title' => __( 'Right', 'exclusive-addons-elementor-pro' ),
                        'icon'  => 'eicon-text-align-right',
                    ],
                    'justify' => [
                        'title' => __( 'Justified', 'exclusive-addons-elementor-pro' ),
                        'icon'  => 'eicon-text-align-justify',
                    ],
                ],
				'desktop_default' => 'left',
				'tablet_default' => 'center',
				'mobile_default' => 'center',
				'selectors_dictionary' => [
					'left' => 'display: flex; justify-content: flex-start; margin-right: auto;',
					'center' => 'display: flex; justify-content: center; margin-left: auto;',
					'right' => 'display: flex; justify-content: flex-end; margin-left: auto;',
					'justify' => 'width: 100%; justify-content: center;',
				],
                'selectors'     => [
                    '.woocommerce {{WRAPPER}} .exad-single-product-details #review_form #respond .form-submit input[type="submit"]' => '{{VALUE}};'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'exad_product_tabs_reviewes_form_btn_typography',
                'selector' => '.woocommerce {{WRAPPER}} .exad-single-product-details #review_form #respond .form-submit input',
                'fields_options'     => [
                    'text_transform' => [
                        'default'    => 'capitalize'
                    ]
                ]
            ]
        );

        $this->add_responsive_control(
            'exad_product_tabs_reviewes_form_btn_padding',
            [
                'label'      => esc_html__('Padding', 'exclusive-addons-elementor-pro'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '.woocommerce {{WRAPPER}} .exad-single-product-details #review_form #respond .form-submit input' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->add_responsive_control(
			'exad_product_tabs_reviewes_form_btn_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'exclusive-addons-elementor-pro' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px'],
				'selectors'  => [
					'.woocommerce {{WRAPPER}} .exad-single-product-details #review_form #respond .form-submit input'=> 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
		);

        $this->add_responsive_control(
			'exad_product_tabs_reviewes_form_btn_margin_top',
			[
				'label'       => __( 'Top Spacing', 'exclusive-addons-elementor-pro' ),
				'type'        => Controls_Manager::SLIDER,
				'size_units'  => [ 'px' ],
				'range'       => [
					'px'      => [
						'min' => -50,
						'max' => 50
					]
				],
				'default'     => [
					'unit'    => 'px',
					'size'    => 20
				],
				'selectors'   => [
					'.woocommerce {{WRAPPER}} .exad-single-product-details #review_form #respond .form-submit'=> 'margin-top: {{SIZE}}{{UNIT}};'
				],
			]
		);

        $this->start_controls_tabs( 'exad_product_tabs_reviewes_form_btn_tabs' );

		$this->start_controls_tab( 'normal', [ 'label' => esc_html__( 'Normal', 'exclusive-addons-elementor-pro' ) ] );

		$this->add_control(
			'exad_product_tabs_reviewes_form_btn_text_color',
			[
				'label'		=> esc_html__( 'Text Color', 'exclusive-addons-elementor-pro' ),
				'type'		=> Controls_Manager::COLOR,
				'default'	=> "#fff",
				'selectors'	=> [
					'.woocommerce {{WRAPPER}} .exad-single-product-details #review_form #respond .form-submit input'  => 'color: {{VALUE}};'
				]
			]
		);

        $this->add_control(
            'exad_product_tabs_reviewes_form_btn_background',
            [
                'label'     => esc_html__('Background Color', 'exclusive-addons-elementor-pro'),
                'type'      => Controls_Manager::COLOR,
                'default'	=> $exad_primary_color,
                'selectors' => [
                    '.woocommerce {{WRAPPER}} .exad-single-product-details #review_form #respond .form-submit input'      => 'background: {{VALUE}};'
                ]
            ]
        );

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'            => 'exad_product_tabs_reviewes_form_btn_border',
				'fields_options'  => [
                    'border' 	  => [
                        'default' => 'solid'
                    ],
                    'width'  	  => [
                        'default' 	 => [
                            'top'    => '1',
                            'right'  => '1',
                            'bottom' => '1',
                            'left'   => '1',
                            'isLinked' => false
                        ]
                    ],
                    'color' 	  => [
                        'default' => $exad_primary_color
                    ]
                ],
				'selector'        => '.woocommerce {{WRAPPER}} .exad-single-product-details #review_form #respond .form-submit input'
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'exad_product_tabs_reviewes_form_btn_shadow',
				'selector' => '.woocommerce {{WRAPPER}} .exad-single-product-details #review_form #respond .form-submit input'
			]
		);

		$this->end_controls_tab();
		
		$this->start_controls_tab( 'exad_product_tabs_reviewes_form_btn_hover', [ 'label' => esc_html__( 'Hover', 'exclusive-addons-elementor-pro' ) ] );

		$this->add_control(
			'exad_product_tabs_reviewes_form_btn_hover_text_color',
			[
				'label'     => esc_html__( 'Text Color', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => $exad_primary_color,
				'selectors' => [
					'.woocommerce {{WRAPPER}} .exad-single-product-details #review_form #respond .form-submit input:hover' => 'color: {{VALUE}};'
				]
			]
		);

        $this->add_control(
            'exad_product_tabs_reviewes_form_btn_hover_background',
            [
                'label'     => esc_html__('Background Color', 'exclusive-addons-elementor-pro'),
                'type'      => Controls_Manager::COLOR,
                'default'   => "#fff",
                'selectors' => [
                    '.woocommerce {{WRAPPER}} .exad-single-product-details #review_form #respond .form-submit input:hover'      => 'background: {{VALUE}};'
                ]
            ]
        );

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'            => 'exad_product_tabs_reviewes_form_btn_border_hover',
                'fields_options'  => [
                    'border' 	  => [
                        'default' => 'solid'
                    ],
                    'width'  	  => [
                        'default' 	 => [
                            'top'    => '1',
                            'right'  => '1',
                            'bottom' => '1',
                            'left'   => '1',
                            'isLinked' => false
                        ]
                    ],
                    'color' 	  => [
                        'default' => $exad_primary_color
                    ]
                ],
				'selector'        => '.woocommerce {{WRAPPER}} .exad-single-product-details #review_form #respond .form-submit input:hover'
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'exad_product_tabs_reviewes_form_btn_box_shadow_hover',
				'selector' => '.woocommerce {{WRAPPER}} .exad-single-product-details #review_form #respond .form-submit input:hover'
			]
		);
		
		$this->end_controls_tab();
		
		$this->end_controls_tabs();	

        $this->end_controls_section();

    }

    protected function render() {
        if( ! class_exists('woocommerce') ) {
	        return;
        }
       do_action( 'exad_woo_builder_widget_before_render', $this );
		$settings = $this->get_settings_for_display();
		?>

		<div class="exad-single-product-details <?php echo esc_attr( $settings['exad_product_tabs_control_container_alignment'] );?>">

			<?php do_action( 'exad_woo_builder_widget_additional_info_before_render' ); ?>

                <?php if ( ! empty( $settings['exad_product_tabs_info_before'] ) ) : ?>
                    <p class="product-tabs-info-before" ><?php echo wp_kses_post( $settings['exad_product_tabs_info_before'] );?></p>
				<?php endif; ?>

                <?php 
                    global $product;

                    $product = wc_get_product();

                    if ( \Elementor\Plugin::instance()->editor->is_edit_mode() ) {
                        echo Woo_Preview_Data::instance()->default( $this->get_name() );
                    } else {
                        if ( empty( $product ) ) {
                            return;
                        }

                        wc_get_template( 'single-product/tabs/tabs.php' );

						// On render widget from Editor - trigger the init manually.
						if ( wp_doing_ajax() ) {
							?>
							<script>
								jQuery( '.wc-tabs-wrapper, .woocommerce-tabs, #rating' ).trigger( 'init' );
							</script>
							<?php
						}
                    }

                ?>

                <?php if ( ! empty( $settings['exad_product_tabs_info_after'] ) ) : ?>
					 <p class="product-tabs-info-after" ><?php echo wp_kses_post( $settings['exad_product_tabs_info_after'] );?></p>
				<?php endif; ?>	

			<?php do_action( 'exad_woo_builder_widget_exad_product_tabs_info_after_render' ); ?>

		</div>

		<?php
    }
}