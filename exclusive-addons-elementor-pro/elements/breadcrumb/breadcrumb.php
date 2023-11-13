<?php
namespace ExclusiveAddons\Elements;

if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.

use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Border;
use \Elementor\Group_Control_Typography;
use \Elementor\Icons_Manager;
use \Elementor\Widget_Base;
use \Elementor\Group_Control_Background;
use \Elementor\Group_Control_Box_Shadow;

class Breadcrumb extends Widget_Base {

	public function get_name() {
		return 'exad-breadcrumbs';
	}

	public function get_title() {
		return esc_html__( 'Breadcrumbs', 'exclusive-addons-elementor-pro' );
	}

	public function get_icon() {
		return 'exad exad-logo exad-breadcrumb';
	}

	public function get_keywords() {
		return [ 'exclusive', 'breadcrumbs', 'header', 'title', 'heading' ];
	}

   	public function get_categories() {
		return [ 'exclusive-addons-elementor' ];
	}

	protected function register_controls() {

  		$this->start_controls_section(
			'exad_section_side_a_content',
			[
				'label' => __( 'Front', 'exclusive-addons-elementor-pro' )
			]
		);

		$this->add_control(
            'exad_breadcrumbs_show_is_home',
            [
				'label'        => esc_html__( 'Show Home ?', 'exclusive-addons-elementor-pro' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => 'yes',
            ]
        );

		$this->add_control(
			'exad_breadcrumbs_home_text',
			[
				'label'   => __( 'Text For Home', 'exclusive-addons-elementor-pro' ),
				'type'    => Controls_Manager::TEXT,
				'default' => __( 'Home', 'exclusive-addons-elementor-pro' ),
				'condition'   => [
                    'exad_breadcrumbs_show_is_home' => 'yes',
                ]
			]
		);

        $this->add_control(
            'exad_breadcrumbs_with_icon',
            [
				'label'        => esc_html__( 'Show With Icon', 'exclusive-addons-elementor-pro' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => 'no',
				'return_value' => 'yes'
            ]
        );

		$this->add_control(
			'exad_breadcrumbs_home_icon',
			[
				'label'       => __( 'Home Icon', 'exclusive-addons-elementor-pro' ),
				'type'        => Controls_Manager::ICONS,
                'default'     => [
                    'value'   => 'fas fa-home',
                    'library' => 'fa-solid'
                ],
				'condition'   => [
                    'exad_breadcrumbs_with_icon' => 'yes'
                ]
			]
		);

		$this->add_control(
			'exad_breadcrumbs_other_icon',
			[
				'label'       => __( 'Icon For Others', 'exclusive-addons-elementor-pro' ),
				'type'        => Controls_Manager::ICONS,
				'default'     => [
					'value'   => 'far fa-file-alt',
					'library' => 'fa-regular'
				],
				'condition'   => [
                    'exad_breadcrumbs_with_icon' => 'yes'
                ]
			]
		);
		
		$this->add_control(
			'exad_breadcrumbs_separate_with_arrow',
			[
				'label'   => __( 'Separator Type', 'exclusive-addons-elementor-pro' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'icon',
				'options' => [
					'none' => __( 'None', 'exclusive-addons-elementor-pro' ),
					'icon' => __( 'Icon', 'exclusive-addons-elementor-pro' ),
					'text' => __( 'Text', 'exclusive-addons-elementor-pro' )
				]
			]
		);
	
		$icon_indicator = is_rtl() ? 'left' : 'right';

		$this->add_control(
			'exad_breadcrumbs_separate_arrow',
			[
				'label'       => __( 'Separator Icon', 'exclusive-addons-elementor-pro' ),
				'type'        => Controls_Manager::ICONS,				
                'default'     => [
                    'value'   => 'fas fa-angle-'.$icon_indicator,
                    'library' => 'fa-solid'
                ],
				'condition'   => [
                    'exad_breadcrumbs_separate_with_arrow' => 'icon'
                ]
			]
		);

		$this->add_control(
			'exad_breadcrumbs_separate_arrow_text',
			[
				'label'     => __( 'Symbol', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => __( '/', 'exclusive-addons-elementor-pro' ),
				'condition' => [
                    'exad_breadcrumbs_separate_with_arrow' => 'text'
                ]
			]
		);

		$this->end_controls_section();

        $this->start_controls_section(
            'exad_breadcrumbs_container_style',
            [
				'label' => esc_html__( 'Container', 'exclusive-addons-elementor-pro' ),
				'tab'   => Controls_Manager::TAB_STYLE
            ]
		);	

		$this->add_responsive_control(
			'exad_breadcrumbs_container_alignment',
			[
				'label'   => __( 'Alignment', 'exclusive-addons-elementor-pro' ),
				'type'    => Controls_Manager::CHOOSE,
				'options' => [
					'flex-start' => [
						'title'  => __( 'Left', 'exclusive-addons-elementor-pro' ),
						'icon'   => 'eicon-text-align-left'
					],
					'center'     => [
						'title'  => __( 'Center', 'exclusive-addons-elementor-pro' ),
						'icon'   => 'eicon-text-align-center'
					],
					'flex-end'   => [
						'title'  => __( 'Right', 'exclusive-addons-elementor-pro' ),
						'icon'   => 'eicon-text-align-right'
					]
				],
				'default' => 'center',
				'selectors' => [
					'{{WRAPPER}} .exad-breadcrumb-wrapper' => 'justify-content: {{VALUE}};'
				]
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'exad_breadcrumbs_container_background',
				'types'    => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} ul.exad-breadcrumb-items'
			]
		);

		$this->add_responsive_control(
            'exad_breadcrumbs_container_padding',
            [
				'label'        => esc_html__( 'Padding', 'exclusive-addons-elementor-pro' ),
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
                    '{{WRAPPER}} ul.exad-breadcrumb-items' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->add_group_control(
        	Group_Control_Border::get_type(),
            [
				'name'     => 'exad_breadcrumbs_container',
				'selector' => '{{WRAPPER}} .exad-breadcrumb-items'
            ]
        );

		$this->add_responsive_control(
			'exad_breadcrumbs_container_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'exclusive-addons-elementor-pro' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px'],
				'selectors'  => [
					'{{WRAPPER}} ul.exad-breadcrumb-items'=> 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'exad_breadcrumbs_container_box_shadow',
				'selector' => '{{WRAPPER}} ul.exad-breadcrumb-items'
			]
		);

		$this->end_controls_section();

        $this->start_controls_section(
            'exad_breadcrumbs_item_style',
            [
				'label' => esc_html__( 'Item', 'exclusive-addons-elementor-pro' ),
				'tab'   => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
				'name'     => 'exad_breadcrumbs_item_typography',
				'selector' => '{{WRAPPER}} ul.exad-breadcrumb-items li.exad-breadcrumb-item'
            ]
        );

        $this->add_responsive_control(
            'exad_breadcrumbs_item_padding',
            [
				'label'        => esc_html__( 'Padding', 'exclusive-addons-elementor-pro' ),
				'type'         => Controls_Manager::DIMENSIONS,            
				'size_units'   => [ 'px', 'em', '%' ],
				'default'      => [
					'top'      => '10',
					'right'    => '25',
					'bottom'   => '10',
					'left'     => '25',
					'unit'     => 'px',
					'isLinked' => false
				],
                'selectors'    => [
                    '{{WRAPPER}} ul.exad-breadcrumb-items li.exad-breadcrumb-item a, {{WRAPPER}} ul.exad-breadcrumb-items li.exad-breadcrumb-item.last-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );
        
        $this->add_responsive_control(
            'exad_breadcrumbs_item_margin',
            [
				'label'      => esc_html__( 'Margin', 'exclusive-addons-elementor-pro' ),
				'type'       => Controls_Manager::DIMENSIONS,            
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
                    '{{WRAPPER}} ul.exad-breadcrumb-items li.exad-breadcrumb-item:not(:last-child)' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

		$this->start_controls_tabs( 'exad_breadcrumbs_item_style_tabs' );

            // normal state tab
            $this->start_controls_tab( 'exad_breadcrumbs_first_item', [ 'label' => esc_html__( 'First Item', 'exclusive-addons-elementor-pro' ) ] );

            $this->add_control(
                'exad_breadcrumbs_first_item_text_color',
                [
                    'label'     => esc_html__( 'Color', 'exclusive-addons-elementor-pro' ),
                    'type'      => Controls_Manager::COLOR,
                    'default'   => '#797c80',
                    'selectors' => [
                        '{{WRAPPER}} ul.exad-breadcrumb-items li.exad-breadcrumb-item.first-item a' => 'color: {{VALUE}};'
                    ]
                ]
			);
			
			$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name'     => 'exad_breadcrumbs_first_item_bg_color',
					'types'    => [ 'classic', 'gradient' ],
					'selector' => '{{WRAPPER}} ul.exad-breadcrumb-items li.exad-breadcrumb-item.first-item'
				]
			);
			
			$this->add_responsive_control(
				'exad_breadcrumbs_first_item_padding',
				[
					'label'        => esc_html__( 'Padding', 'exclusive-addons-elementor-pro' ),
					'type'         => Controls_Manager::DIMENSIONS,            
					'size_units'   => [ 'px', 'em', '%' ],
					'selectors'    => [
						'{{WRAPPER}} ul.exad-breadcrumb-items li.exad-breadcrumb-item.first-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
					]
				]
			);

	 		$this->add_group_control(
	        	Group_Control_Border::get_type(),
	            [
					'name'     => 'exad_breadcrumbs_first_item_border',
					'selector' => '{{WRAPPER}} ul.exad-breadcrumb-items li.exad-breadcrumb-item.first-item'
	            ]
	        );

			$this->add_responsive_control(
				'exad_breadcrumbs_first_item_border_radius',
				[
					'label'      => esc_html__( 'Border Radius', 'exclusive-addons-elementor-pro' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px'],
					'selectors'  => [
						'{{WRAPPER}} ul.exad-breadcrumb-items li.exad-breadcrumb-item.first-item'=> 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
					]
				]
			);

			$this->add_group_control(
				Group_Control_Box_Shadow::get_type(),
				[
					'name'     => 'exad_breadcrumbs_first_item_shadow',
					'selector' => '{{WRAPPER}} ul.exad-breadcrumb-items li.exad-breadcrumb-item.first-item'
				]
			);

            $this->end_controls_tab();

            // hover state tab
            $this->start_controls_tab( 'exad_breadcrumbs_inner_items', [ 'label' => esc_html__( 'Inner Items', 'exclusive-addons-elementor-pro' ) ] );

            $this->add_control(
                'exad_breadcrumbs_inner_items_text_color',
                [
                    'label'     => esc_html__( 'Color', 'exclusive-addons-elementor-pro' ),
                    'type'      => Controls_Manager::COLOR,
                    'default'   => '#797c80',
                    'selectors' => [
                        '{{WRAPPER}} ul.exad-breadcrumb-items li.exad-breadcrumb-item.inner-items a' => 'color: {{VALUE}};'
                    ]
                ]
			);
			
			$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name'     => 'exad_breadcrumbs_inner_items_bg_color',
					'types'    => [ 'classic', 'gradient' ],
					'selector' => '{{WRAPPER}} ul.exad-breadcrumb-items li.exad-breadcrumb-item.inner-items'
				]
			);
			
			$this->add_responsive_control(
				'exad_breadcrumbs_inner_items_padding',
				[
					'label'        => esc_html__( 'Padding', 'exclusive-addons-elementor-pro' ),
					'type'         => Controls_Manager::DIMENSIONS,            
					'size_units'   => [ 'px', 'em', '%' ],
					'selectors'    => [
						'{{WRAPPER}} ul.exad-breadcrumb-items li.exad-breadcrumb-item.inner-items' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
					]
				]
			);

	 		$this->add_group_control(
	        	Group_Control_Border::get_type(),
	            [
	                'name'      => 'exad_breadcrumbs_inner_items_border',
	                'selector'  => '{{WRAPPER}} ul.exad-breadcrumb-items li.exad-breadcrumb-item.inner-items'
	            ]
	        );

			$this->add_responsive_control(
				'exad_breadcrumbs_inner_items_border_radius',
				[
					'label'      => esc_html__( 'Border Radius', 'exclusive-addons-elementor-pro' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px'],
					'selectors'  => [
						'{{WRAPPER}} ul.exad-breadcrumb-items li.exad-breadcrumb-item.inner-items'=> 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
					]
				]
			);

			$this->add_group_control(
				Group_Control_Box_Shadow::get_type(),
				[
					'name'     => 'exad_breadcrumbs_inner_items_shadow',
					'selector' => '{{WRAPPER}} ul.exad-breadcrumb-items li.exad-breadcrumb-item.inner-items'
				]
			);

            $this->end_controls_tab();

            // active state tab
            $this->start_controls_tab( 'exad_breadcrumbs_item_active', [ 'label' => esc_html__( 'Active Item', 'exclusive-addons-elementor-pro' ) ] );

            $this->add_control(
                'exad_breadcrumbs_item_active_color',
                [
                    'label'     => esc_html__( 'Color', 'exclusive-addons-elementor-pro' ),
                    'type'      => Controls_Manager::COLOR,
                    'default'	=> '#7a56ff',
                    'selectors' => [
                        '{{WRAPPER}} ul.exad-breadcrumb-items li.exad-breadcrumb-item.active' => 'color: {{VALUE}};'
                    ]
                ]
			);
			
			$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name'     => 'exad_breadcrumbs_item_active_bg_color',
					'types'    => [ 'classic', 'gradient' ],
					'selector' => '{{WRAPPER}} ul.exad-breadcrumb-items li.exad-breadcrumb-item.active'
				]
			);
			
			$this->add_responsive_control(
				'exad_breadcrumbs_item_active_padding',
				[
					'label'        => esc_html__( 'Padding', 'exclusive-addons-elementor-pro' ),
					'type'         => Controls_Manager::DIMENSIONS,            
					'size_units'   => [ 'px', 'em', '%' ],
					'selectors'    => [
						'{{WRAPPER}} ul.exad-breadcrumb-items li.exad-breadcrumb-item.active' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
					]
				]
			);

	 		$this->add_group_control(
	        	Group_Control_Border::get_type(),
	            [
	                'name'      => 'exad_breadcrumbs_item_active_border',
	                'selector'  => '{{WRAPPER}} ul.exad-breadcrumb-items li.exad-breadcrumb-item.active'
	            ]
	        );

			$this->add_responsive_control(
				'exad_breadcrumbs_item_active_border_radius',
				[
					'label'      => esc_html__( 'Border Radius', 'exclusive-addons-elementor-pro' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px'],
					'selectors'  => [
						'{{WRAPPER}} ul.exad-breadcrumb-items li.exad-breadcrumb-item.active'=> 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
					]
				]
			);

			$this->add_group_control(
				Group_Control_Box_Shadow::get_type(),
				[
					'name'     => 'exad_breadcrumbs_item_active_box_shadow',
					'selector' => '{{WRAPPER}} ul.exad-breadcrumb-items li.exad-breadcrumb-item.active'
				]
			);

            $this->end_controls_tab();

        $this->end_controls_tabs();

		$this->add_control(
			'exad_breadcrumbs_item_icon_style',
			[
				'label'     => __( 'Other Icons', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
                'condition' => [
                	'exad_breadcrumbs_with_icon' => 'yes'
                ]
			]
		);

		$this->add_responsive_control(
			'exad_breadcrumbs_item_icon_spaching',
			[
				'label'       => esc_html__( 'Icon Spacing', 'exclusive-addons-elementor-pro' ),
				'type'        => Controls_Manager::SLIDER,
				'range'       => [
					'px'      => [
						'max' => 50
					]
				],
				'default'     => [
					'unit'    => 'px',
					'size'    => 10
				],
				'selectors'   => [
					'{{WRAPPER}} ul.exad-breadcrumb-items li.exad-breadcrumb-item i.exad-breadcrumb-icon' => 'margin-right: {{SIZE}}px'
				],
				'condition'   => [
					'exad_breadcrumbs_with_icon' => 'yes'
				]
			]
	  	);

		$this->add_control(
			'exad_breadcrumbs_item_arrow_separator_style',
			[
				'label'     => __( 'Separator Icon', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
                'condition' => [
					'exad_breadcrumbs_separate_with_arrow!'    => 'none'
                ]
			]
		);

		$this->add_responsive_control(
			'exad_breadcrumbs_item_arrow_separator_left_sppacing',
			[
			  'label'         => esc_html__( 'Left Spacing', 'exclusive-addons-elementor-pro' ),
			  'type'          => Controls_Manager::SLIDER,
			  'range'         => [
					'px'      => [
						'max' => 100
					]
			  	],
			  	'selectors'     => [
					'{{WRAPPER}} ul.exad-breadcrumb-items li.exad-breadcrumb-item i.exad-arrow' => 'right: -{{SIZE}}px',
					'{{WRAPPER}} ul.exad-breadcrumb-items li.exad-breadcrumb-item div.exad-arrow' => 'right: -{{SIZE}}px'
			  	],
			  	'condition'     => [
			  		'exad_breadcrumbs_separate_with_arrow!'    => 'none'
			  	]
			]
	  	);

	    $this->add_responsive_control(
      		'exad_breadcrumbs_item_arrow_separator_size',
      		[
				'label'       => esc_html__( 'Box Size', 'exclusive-addons-elementor-pro' ),
				'type'        => Controls_Manager::SLIDER,
		        'range'       => [
		          	'px'      => [
		              	'max' => 100
		          	]
		        ],
		        'selectors'   => [
		          	'{{WRAPPER}} ul.exad-breadcrumb-items li.exad-breadcrumb-item i.exad-arrow' => 'width: {{SIZE}}px; height: {{SIZE}}px; line-height: {{SIZE}}px;',
		          	'{{WRAPPER}} ul.exad-breadcrumb-items li.exad-breadcrumb-item div.exad-arrow' => 'width: {{SIZE}}px; height: {{SIZE}}px; line-height: {{SIZE}}px;'
		        ],
				'condition'   => [
                	'exad_breadcrumbs_separate_with_arrow!'    => 'none'
                ]
	      	]
	    );

	    $this->add_responsive_control(
      		'exad_breadcrumbs_item_arrow_separator_font_size',
      		[
				'label'     => esc_html__( 'Font Size', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::SLIDER,
				'selectors' => [
		          	'{{WRAPPER}} ul.exad-breadcrumb-items li.exad-breadcrumb-item i.exad-arrow' => 'font-size: {{SIZE}}px;',
		          	'{{WRAPPER}} ul.exad-breadcrumb-items li.exad-breadcrumb-item div.exad-arrow' => 'font-size: {{SIZE}}px;'
		        ],
				'condition' => [
                	'exad_breadcrumbs_separate_with_arrow!'    => 'none'
                ]
	      	]
	    );

        $this->add_control(
			'exad_breadcrumbs_item_arrow_separator_color',
			[
				'label'     => __( 'Color', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} ul.exad-breadcrumb-items li.exad-breadcrumb-item i.exad-arrow' => 'color: {{VALUE}};',
					'{{WRAPPER}} ul.exad-breadcrumb-items li.exad-breadcrumb-item div.exad-arrow' => 'color: {{VALUE}};'
				],
				'default'	=> '#797c80',
				'condition' => [
                	'exad_breadcrumbs_separate_with_arrow!'    => 'none'
                ]
			]
		);

        $this->add_control(
			'exad_breadcrumbs_item_arrow_separator_bg_color',
			[
				'label'     => __( 'Background Color', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} ul.exad-breadcrumb-items li.exad-breadcrumb-item i.exad-arrow' => 'background-color: {{VALUE}};',
					'{{WRAPPER}} ul.exad-breadcrumb-items li.exad-breadcrumb-item div.exad-arrow' => 'background-color: {{VALUE}};'
				],
				'condition' => [
                	'exad_breadcrumbs_separate_with_arrow!'    => 'none'
                ]
			]
		);

        $this->add_group_control(
        	Group_Control_Border::get_type(),
            [
                'name'      => 'exad_breadcrumbs_item_arrow_separator_border',
                'selector'  => '{{WRAPPER}} ul.exad-breadcrumb-items li.exad-breadcrumb-item i.exad-arrow, {{WRAPPER}} ul.exad-breadcrumb-items li.exad-breadcrumb-item div.exad-arrow',
				'condition' => [
                	'exad_breadcrumbs_separate_with_arrow!'    => 'none'
                ]
            ]
        );

		$this->add_responsive_control(
			'exad_breadcrumbs_item_arrow_separator_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'exclusive-addons-elementor-pro' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px'],
				'selectors'  => [
					'{{WRAPPER}} ul.exad-breadcrumb-items li.exad-breadcrumb-item i.exad-arrow'=> 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} ul.exad-breadcrumb-items li.exad-breadcrumb-item div.exad-arrow'=> 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				],
				'condition'  => [
                	'exad_breadcrumbs_separate_with_arrow!'    => 'none'
                ]
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
					'name'      => 'exad_breadcrumbs_item_arrow_separator_shadow',
					'selector'  => '{{WRAPPER}} ul.exad-breadcrumb-items li.exad-breadcrumb-item i.exad-arrow, {{WRAPPER}} ul.exad-breadcrumb-items li.exad-breadcrumb-item div.exad-arrow',
					'condition' => [
					'exad_breadcrumbs_separate_with_arrow!'    => 'none'
                ]
			]
		);


		$this->end_controls_section();
	}

   	protected function exadBreadcrumbs( $hometext, $withIcon, $homeIcon, $otherIcon, $separator_icon, $separate_with_icon ) {
  	
		$settings 		= $this->get_settings_for_display();
		$name           = $hometext;
		$otherIcon      = 'yes' === $withIcon ? '<i class="exad-breadcrumb-icon '.esc_attr( $otherIcon['value'] ).'"></i>' : '';

		if ( 'icon' === $separate_with_icon ) :
			$separator_icon = '<i class="exad-arrow '.esc_attr( $separator_icon['value'] ).'"></i>';
		elseif ( 'text' === $separate_with_icon ) :
			$separator_icon = '<div class="exad-arrow">'.esc_attr( $separator_icon ).'</div>';
		endif;

		$currentBefore = '<li class="exad-breadcrumb-item last-item active">'.$otherIcon;
		$currentAfter  = '</li>';

		if ( ! is_home() && ! is_front_page() || is_paged() ) : ?>
		  
			<div class="exad-breadcrumb-wrapper">
				<ul class="exad-breadcrumb-items">
				<?php	  
					global $post;
					$home = get_bloginfo( 'url' );
	
					if ( 'yes' === $settings['exad_breadcrumbs_show_is_home'] && !empty( $settings['exad_breadcrumbs_home_text'] ) ) : 
					?>
					<li class="exad-breadcrumb-item first-item">
						<a href="<?php echo esc_url( $home ); ?>">
						<?php
							if ( 'yes' === $withIcon ) :
								Icons_Manager::render_icon( $homeIcon, [ 'class' => 'exad-breadcrumb-icon' ] );
							endif;
							echo esc_html( $name );
						?>	
						</a>
						<?php echo $separator_icon; ?>
					</li>

					<?php	
					endif;	
					if ( \Elementor\Plugin::$instance->editor->is_edit_mode() || is_page() || is_single() ) :
						if ( ! $post->post_parent ) :
							echo $currentBefore;
							the_title();
							echo $currentAfter;
					
						elseif ( $post->post_parent ) :
							$parent_id   = $post->post_parent;
							$breadcrumbs = array();
							while ( $parent_id ) :
								$page = get_page( $parent_id );
								$breadcrumbs[] = '<li class="exad-breadcrumb-item inner-items"><a href="' . get_permalink( $page->ID ) . '">'.$otherIcon . get_the_title( $page->ID ) . '</a>'.$separator_icon.'</li>';
								$parent_id  = $page->post_parent;
							endwhile;
							$breadcrumbs = array_reverse( $breadcrumbs );
							foreach ( $breadcrumbs as $crumb ) echo $crumb;
							echo $currentBefore;
							the_title();
							echo $currentAfter;
					
						endif;
					endif;
					?>
				</ul>
			</div>
		<?php		
  		endif;
	}

	protected function render() {

		$settings = $this->get_settings_for_display();
	
		$homeText = $settings['exad_breadcrumbs_home_text'];
		$withIcon = $settings['exad_breadcrumbs_with_icon'];

		$homeIcon = $otherIcon = $separator_icon = $separate_with_icon = '';

		if ( 'icon' === $settings['exad_breadcrumbs_separate_with_arrow'] ) :
			$separator_icon     = $settings['exad_breadcrumbs_separate_arrow'];
			$separate_with_icon = 'icon';
		elseif ( 'text' === $settings['exad_breadcrumbs_separate_with_arrow'] ) :
			$separator_icon     = $settings['exad_breadcrumbs_separate_arrow_text'];
			$separate_with_icon = 'text';
		endif;
		
		if ( 'yes' === $withIcon ) :
			$homeIcon  = $settings['exad_breadcrumbs_home_icon'];
			$otherIcon = $settings['exad_breadcrumbs_other_icon'];
		endif;

 		$this->exadBreadcrumbs( $homeText, $withIcon, $homeIcon, $otherIcon, $separator_icon, $separate_with_icon );

	}
}