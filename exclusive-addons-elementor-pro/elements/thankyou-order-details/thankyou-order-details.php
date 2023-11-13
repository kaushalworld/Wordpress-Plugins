<?php
namespace ExclusiveAddons\Elements;

if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.

use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Border;
use \Elementor\Group_Control_Box_Shadow;
use \Elementor\Group_Control_Typography;
use \Elementor\Widget_Base;
use \Elementor\Group_Control_Background;
use \ExclusiveAddons\Pro\Elementor\ProHelper;

class Woo_Thank_you_order_Details extends Widget_Base {

	public function get_name() {
		return 'exad-thank-you-order-details';
	}

	public function get_title() {
		return __( 'Thank You Order Details', 'exclusive-addons-elementor-pro' );
	}

	public function get_icon() {
		return 'exad exad-logo exad-woo-products';
	}

	public function get_categories() {
		return [ 'exclusive-addons-elementor' ];
	}

	public function get_keywords() {
	    return [ 'thank you', 'order details', 'thank you order details' ];
	}

    protected function register_controls() {

        $exad_primary_color   = get_option( 'exad_primary_color_option', '#7a56ff' );

        if( ! class_exists( 'woocommerce' ) ) {
		    $this->start_controls_section(
			    'exad_panel_notice',
			    [
				    'label' => __('Notice!', 'exclusive-addons-elementor-pro'),
					'tab'   => Controls_Manager::TAB_CONTENT,
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
         * Title Section
         */
		$this->start_controls_section(
			'exad_thank_you_order_details_section_title_setting_section',
			[
				'label' => __( 'Section Title', 'exclusive-addons-elementor-pro' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'exad_thank_you_order_details_section_title_text',
			[
				'label'      => __( 'Order Details', 'exclusive-addons-elementor-pro' ),
				'type'       => Controls_Manager::TEXT,
                'label_block'   => true,
				'default'    => __( 'Order Details', 'exclusive-addons-elementor-pro' ),
			]
		);

		$this->add_control(
			'exad_thank_you_order_details_table_header_title_text',
			[
				'label'      => __( 'Table Header', 'exclusive-addons-elementor-pro' ),
				'type'       => Controls_Manager::TEXT,
                'label_block'   => true,
				'default'    => __( 'Product', 'exclusive-addons-elementor-pro' ),
			]
		);	

		$this->add_control(
			'exad_thank_you_order_details_table_header_title_2_text',
			[
				'label'      => __( 'Table Header', 'exclusive-addons-elementor-pro' ),
				'type'       => Controls_Manager::TEXT,
                'label_block'   => true,
				'default'    => __( 'Total', 'exclusive-addons-elementor-pro' ),
			]
		);


		$this->end_controls_section();
		
		  /**
         * Style Section
         */

		/*
		*SECTION product Title Styling Section
		*/
		$this->start_controls_section(
            'exad_thank_you_order_details_section_title_style',
            [
                'label'     => __( 'Section Title', 'exclusive-addons-elementor-pro' ),
                'tab'       => Controls_Manager::TAB_STYLE
            ]
        );

		$this->add_responsive_control(
            'exad_thank_you_order_details_section_alignment',
            [
                'label'         => __( 'Alignment', 'exclusive-addons-elementor-pro' ),
                'type'          => Controls_Manager::CHOOSE,
                'default'       => 'left',
                'toggle'        => false,
                'options'       => [
                    'left' => [
                        'title'  => __( 'Left', 'exclusive-addons-elementor-pro' ),
                        'icon'   => 'eicon-h-align-left'
                    ],
                    'center'     => [
                        'title'  => __( 'Center', 'exclusive-addons-elementor-pro' ),
                        'icon'   => 'eicon-h-align-center'
                    ],
                    'right'   => [
                        'title'  => __( 'Right', 'exclusive-addons-elementor-pro' ),
                        'icon'   => 'eicon-h-align-right'
                    ]
                ],
                'selectors'     => [
                    '{{WRAPPER}} .exad-thank-you-order-details .woocommerce-order-details__title' => 'text-align: {{VALUE}};'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'exad_thank_you_order_details_section_typography',
                'selector' => '{{WRAPPER}} .exad-thank-you-order-details .woocommerce-order-details__title'
            ]
        );

        $this->add_control(
            'exad_thank_you_order_details_section_title_color',
            [
                'label'     => __( 'Color', 'exclusive-addons-elementor-pro' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#000000',
                'selectors' => [
                    '{{WRAPPER}} .exad-thank-you-order-details .woocommerce-order-details__title' => 'color: {{VALUE}};'
                ]
            ]
        );

   		$this->add_control(
            'exad_thank_you_order_details_section_title_bg_color',
            [
                'label'     => __( 'Background Color', 'exclusive-addons-elementor-pro' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .exad-thank-you-order-details .woocommerce-order-details__title' => 'background: {{VALUE}};'
                ]
            ]
        );

		$this->add_responsive_control(
            'exad_thank_you_order_details_section_title_padding',
            [
                'label'         => __( 'Padding', 'exclusive-addons-elementor-pro' ),
                'type'          => Controls_Manager::DIMENSIONS,            
                'size_units'    => [ 'px', 'em', '%' ],
                'selectors'     => [
                        '{{WRAPPER}} .exad-thank-you-order-details .woocommerce-order-details__title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->add_responsive_control(
            'exad_thank_you_order_details_section_title_margin',
            [
                'label'         => __( 'Margin', 'exclusive-addons-elementor-pro' ),
                'type'          => Controls_Manager::DIMENSIONS,            
                'size_units'    => [ 'px', 'em', '%' ],
                'selectors'     => [
                        '{{WRAPPER}} .exad-thank-you-order-details .woocommerce-order-details__title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

		$this->add_responsive_control(
			'exad_thank_you_order_details_section_title_radius',
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
					'{{WRAPPER}} .exad-thank-you-order-details .woocommerce-order-details__title' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'exad_thank_you_order_details_section_title_border',
				'selector' => '{{WRAPPER}} .exad-thank-you-order-details .woocommerce-order-details__title'
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'exad_thank_you_order_details_section_title_box_shadow',
				'selector' => '{{WRAPPER}} .exad-thank-you-order-details .woocommerce-order-details__title'
			]
		);

        $this->end_controls_section();

        /*
		* product container Styling Section
		*/
        $this->start_controls_section(
            'exad_thank_you_order_details_container_style_section',
            [
                'label' => __( 'Container', 'exclusive-addons-elementor-pro' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
		);

		$this->add_responsive_control(
            'exad_thank_you_order_details_container_alignment',
            [
                'label'         => __( 'Alignment', 'exclusive-addons-elementor-pro' ),
                'type'          => Controls_Manager::CHOOSE,
                'default'       => 'left',
                'toggle'        => false,
                'options'       => [
                    'left' => [
                        'title'  => __( 'Left', 'exclusive-addons-elementor-pro' ),
                        'icon'   => 'eicon-h-align-left'
                    ],
                    'center'     => [
                        'title'  => __( 'Center', 'exclusive-addons-elementor-pro' ),
                        'icon'   => 'eicon-h-align-center'
                    ],
                    'right'   => [
                        'title'  => __( 'Right', 'exclusive-addons-elementor-pro' ),
                        'icon'   => 'eicon-h-align-right'
                    ]
                ],
                'selectors'     => [
                    '{{WRAPPER}} .exad-thank-you-order-details .woocommerce-table' => 'text-align: {{VALUE}};'
                ]
            ]
        );

        $this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'exad_thank_you_order_details_container_background',
				'types'    => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .exad-thank-you-order-details .woocommerce-table'
			]
		);

		$this->add_responsive_control(
			'exad_thank_you_order_details_container_padding',
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
					'{{WRAPPER}} .exad-thank-you-order-details .woocommerce-table' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
		);

		$this->add_responsive_control(
			'exad_thank_you_order_details_container_margin',
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
					'{{WRAPPER}} .exad-thank-you-order-details .woocommerce-table' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
        );

        $this->add_responsive_control(
			'exad_thank_you_order_details_container_radius',
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
					'{{WRAPPER}} .exad-thank-you-order-details .woocommerce-table' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'exad_thank_you_order_details_container_border',
				'selector' => '{{WRAPPER}} .exad-thank-you-order-details .woocommerce-table'
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'exad_thank_you_order_details_container_box_shadow',
				'selector' => '{{WRAPPER}} .exad-thank-you-order-details .woocommerce-table'
			]
		);

        $this->end_controls_section();

		/**
         * -------------------------------------------
         * Tab Style Table Style
         * -------------------------------------------
         */ 
        $this->start_controls_section(
            'exad_thank_you_order_details_tables_style',
            [
                'label' => __('Table', 'exclusive-addons-elementor-pro'),
                'tab'   => Controls_Manager::TAB_STYLE
            ]
        );

		$this->add_control(
            'exad_thank_you_order_details_table_header_style',
            [
                'label'     => __('Header', 'exclusive-addons-elementor-pro'),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'exad_thank_you_order_details_table_header_typography',
                'selector' => '{{WRAPPER}} .woocommerce-order-details table thead th',
                'fields_options'     => [
                    'text_transform' => [
                        'default'    => 'capitalize'
                    ]
                ]
            ]
        );

        $this->add_control(
            'exad_thank_you_order_details_table_header_color',
            [
                'label'     => __('Header Color', 'exclusive-addons-elementor-pro'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#444444',
                'selectors' => [
                    '{{WRAPPER}} .woocommerce-order-details table thead th' => 'color: {{VALUE}};'
                ]
            ]
        );

        $this->add_control(
            'exad_thank_you_order_details_table_header_bg_color',
            [
                'label'     => __('Header Background Color', 'exclusive-addons-elementor-pro'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .woocommerce-order-details table thead th'      => 'background: {{VALUE}};'
                ]
            ]
        );

        $this->add_responsive_control(
            'exad_thank_you_order_details_table_header_padding',
            [
                'label'      => __('Padding', 'exclusive-addons-elementor-pro'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .woocommerce-order-details table thead th' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'exad_thank_you_order_details_table_header_border',
                'selector' => '{{WRAPPER}} .woocommerce-order-details table thead th'
            ]
        );

		
		$this->add_control(
            'exad_thank_you_order_details_table_content_style',
            [
                'label'     => __('Table Content', 'exclusive-addons-elementor-pro'),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'exad_thank_you_order_details_table_typography',
                'selector' => '{{WRAPPER}} .woocommerce-order-details table tbody td, {{WRAPPER}} .woocommerce-order-details table tbody td *',
            ]
        );

        $this->add_control(
			'exad_thank_you_order_details_table_row_horizontal_alignment',
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
					'{{WRAPPER}} .woocommerce-order-details table tbody tr td, {{WRAPPER}} .woocommerce-order-details table thead tr th, {{WRAPPER}} .exad-thank-you-order-details .woocommerce-table' => 'text-align: {{VALUE}};'
				]
			]
		);

        $this->add_responsive_control(
            'exad_thank_you_order_details_table_padding',
            [
                'label'      => __('Padding', 'exclusive-addons-elementor-pro'),
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
                    '{{WRAPPER}} .woocommerce-order-details table' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->add_control(
            'exad_thank_you_order_details_table_bg_color',
            [
                'label'     => __('Background Color', 'exclusive-addons-elementor-pro'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .woocommerce-order-details table' => 'background: {{VALUE}};'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'                 => 'exad_thank_you_order_details_table_border',
                'fields_options'       => [
                    'border'           => [
                        'default'      => 'solid'
                    ],
                    'color'            => [
                        'default'      => 'rgba(255,255,255,0)'
                    ]
                ],
                'selector'             => '{{WRAPPER}} .woocommerce-order-details table'
            ]
        );

        $this->add_control(
            'exad_thank_you_order_details_table_border_radius',
            [
                'label'   => __('Border Radius', 'exclusive-addons-elementor-pro'),
                'type'    => Controls_Manager::SLIDER,
                'range'   => [
                    'px'  => [
                        'max' => 30
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .woocommerce-order-details table' => 'border-radius: {{SIZE}}px;'
                ]
            ]
        );

        $this->add_control(
            'exad_thank_you_order_details_table_row_style',
            [
                'label'     => __('Table Rows', 'exclusive-addons-elementor-pro'),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'exad_thank_you_order_details_table_row_link_color',
            [
                'label'     => __('Link Color', 'exclusive-addons-elementor-pro'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .woocommerce-order-details table tbody tr td a' => 'color: {{VALUE}};'
                ]
            ]
        );        

		$this->add_control(
            'exad_thank_you_order_details_table_row_color',
            [
                'label'     => __('Row Color', 'exclusive-addons-elementor-pro'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#444444',
                'selectors' => [
                    '{{WRAPPER}} .woocommerce-order-details table tbody tr td' => 'color: {{VALUE}};'
                ]
            ]
        );

        $this->add_control(
            'exad_thank_you_order_details_table_row_bg_color',
            [
                'label'     => __('Row Background Color', 'exclusive-addons-elementor-pro'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .woocommerce-order-details table tbody tr td'      => 'background: {{VALUE}};'
                ]
            ]
        );

        $this->add_control(
            'exad_thank_you_order_details_table_even_row_color',
            [
                'label'     => __('Even Color', 'exclusive-addons-elementor-pro'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#444444',
                'selectors' => [
                    '{{WRAPPER}} .woocommerce-order-details table tbody tr:nth-child(even) td' => 'color: {{VALUE}};'
                ]
            ]
        );

        $this->add_control(
            'exad_thank_you_order_details_table_even_row_bg_color',
            [
                'label'     => __('Even Background Color', 'exclusive-addons-elementor-pro'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .woocommerce-order-details table tbody tr:nth-child(even) td'      => 'background: {{VALUE}};'
                ]
            ]
        );

        $this->add_control(
            'exad_thank_you_order_details_table_cell_style',
            [
                'label'     => __('Table Cell', 'exclusive-addons-elementor-pro'),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_responsive_control(
            'exad_thank_you_order_details_table_cell_padding',
            [
                'label'      => __('Padding', 'exclusive-addons-elementor-pro'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .woocommerce-order-details table tbody tr td' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'                 => 'exad_thank_you_order_details_table_cell_border',
                'fields_options'       => [
                    'border'           => [
                        'default'      => 'solid'
                    ],
                    'color'            => [
                        'default'      => '#ccc'
                    ]
                ],
                'selector'             => '{{WRAPPER}} .woocommerce-order-details table tbody tr td'
            ]
        );

		$this->add_control(
            'exad_thank_you_order_details_table_footer_style',
            [
                'label'     => __('Table Footer', 'exclusive-addons-elementor-pro'),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

		$this->add_control(
            'exad_thank_you_order_details_table_footer_heading_style',
            [
                'label'     => __('Footer Heading ', 'exclusive-addons-elementor-pro'),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

		$this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'exad_thank_you_order_details_table_footer_headind_typography',
                'selector' => '{{WRAPPER}} .woocommerce-order-details table tfoot th',
                'fields_options'     => [
                    'text_transform' => [
                        'default'    => 'capitalize'
                    ]
                ]
            ]
        );

		$this->add_control(
            'exad_thank_you_order_details_table_footer_heading_color',
            [
                'label'     => __('Footer Color', 'exclusive-addons-elementor-pro'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .woocommerce-order-details table tfoot th' => 'color: {{VALUE}};'
                ]
            ]
        );

        $this->add_control(
            'exad_thank_you_order_details_table_footer_heading_bg_color',
            [
                'label'     => __('Footer Background Color', 'exclusive-addons-elementor-pro'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .woocommerce-order-details table tfoot th'      => 'background: {{VALUE}};'
                ]
            ]
        );

		$this->add_control(
            'exad_thank_you_order_details_table_footer_content_style',
            [
                'label'     => __('Table Content', 'exclusive-addons-elementor-pro'),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'exad_thank_you_order_details_table_footer_typography',
                'selector' => '{{WRAPPER}} .woocommerce-order-details table tfoot td',
            ]
        );

        $this->add_control(
            'exad_thank_you_order_details_table_footer_color',
            [
                'label'     => __('Footer Color', 'exclusive-addons-elementor-pro'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .woocommerce-order-details table tfoot td' => 'color: {{VALUE}};'
                ]
            ]
        );

        $this->add_control(
            'exad_thank_you_order_details_table_footer_bg_color',
            [
                'label'     => __('Footer Background Color', 'exclusive-addons-elementor-pro'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .woocommerce-order-details table tfoot td'      => 'background: {{VALUE}};'
                ]
            ]
        );

        $this->add_responsive_control(
            'exad_thank_you_order_details_table_footer_padding',
            [
                'label'      => __('Padding', 'exclusive-addons-elementor-pro'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .woocommerce-order-details table tfoot td' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .woocommerce-order-details table tfoot th' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'exad_thank_you_order_details_table_footer_border',
                'selector' => '{{WRAPPER}} .woocommerce-order-details table tfoot td, {{WRAPPER}} .woocommerce-order-details table tfoot th'
            ]
        );

		$this->end_controls_section();

    }

    
    protected function render() {
        if( ! class_exists('woocommerce') ) {
            return;
        }

        $settings = $this->get_settings_for_display();

        global $wp;
        
        if( isset( $wp->query_vars['order-received'] ) ){
            $received_order_id = $wp->query_vars['order-received'];
        }else{
           $received_order_id = ProHelper::exad_product_get_last_order_id();
        }
        if( !$received_order_id ){ return; }
    
        $order = wc_get_order( $received_order_id );
    
        $order_id = $order->get_id();
        
        if ( ! $order = wc_get_order( $order_id ) ) { return; }
        
        $order_items           = $order->get_items( apply_filters( 'woocommerce_purchase_order_item_types', 'line_item' ) );
        $show_purchase_note    = $order->has_status( apply_filters( 'woocommerce_purchase_note_order_statuses', array( 'completed', 'processing' ) ) );
        $show_customer_details = is_user_logged_in() && $order->get_user_id() === get_current_user_id();
        $downloads             = $order->get_downloadable_items();
        $show_downloads        = $order->has_downloadable_item() && $order->is_download_permitted();
        
        if ( $show_downloads ) {
            wc_get_template( 'order/order-downloads.php', array( 'downloads' => $downloads, 'show_title' => true ) );
        }
        ?>
 
        <div class="exad-thank-you-order-details">

            <?php do_action( 'exad_woo_builder_widget_product_stock_before_render' ); ?>

               <div class="woocommerce-order-details">
                   <?php do_action( 'woocommerce_order_details_before_order_table', $order ); ?>
               
                   <h2 class="woocommerce-order-details__title"><?php echo esc_html( $settings['exad_thank_you_order_details_section_title_text'] ); ?></h2>
               
                   <table class="woocommerce-table woocommerce-table--order-details shop_table order_details">
               
                       <thead>
                           <tr>
                               <th class="woocommerce-table__product-name product-name"><?php echo esc_html( $settings['exad_thank_you_order_details_table_header_title_text']  ); ?></th>
                               <th class="woocommerce-table__product-table product-total"><?php echo esc_html( $settings['exad_thank_you_order_details_table_header_title_2_text']); ?></th>
                           </tr>
                       </thead>
               
                       <tbody>
                           <?php
                           do_action( 'woocommerce_order_details_before_order_table_items', $order );
               
                           foreach ( $order_items as $item_id => $item ) {
                               $product = $item->get_product();
                               wc_get_template( 'order/order-details-item.php', array(
                                   'order'              => $order,
                                   'item_id'            => $item_id,
                                   'item'               => $item,
                                   'show_purchase_note' => $show_purchase_note,
                                   'purchase_note'      => $product ? $product->get_purchase_note() : '',
                                   'product'            => $product,
                               ) );
                           }
               
                           do_action( 'woocommerce_order_details_after_order_table_items', $order );
                           ?>
                       </tbody>
               
                       <tfoot>
                           <?php
                               foreach ( $order->get_order_item_totals() as $key => $total ) {
                                   ?>
                                   <tr>
                                       <th scope="row"><?php echo $total['label']; ?></th>
                                       <td><?php echo ( 'payment_method' === $key ) ? esc_html( $total['value'] ) : $total['value']; ?></td>
                                   </tr>
                                   <?php
                               }
                           ?>
                           <?php if ( $order->get_customer_note() ) : ?>
                               <tr>
                                   <th><?php esc_html_e( 'Note:', 'exclusive-addons-elementor-pro' ); ?></th>
                                   <td><?php echo wptexturize( $order->get_customer_note() ); ?></td>
                               </tr>
                           <?php endif; ?>
                       </tfoot>
                   </table>
               
                   <?php do_action( 'woocommerce_order_details_after_order_table', $order ); ?>
				</div>

            <?php do_action( 'exad_woo_builder_widget_product_stock_after_render' ); ?>

        </div>

        <?php
    }
}