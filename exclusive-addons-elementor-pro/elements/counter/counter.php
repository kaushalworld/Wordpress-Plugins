<?php
namespace ExclusiveAddons\Elements;

if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.

use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Border;
use \Elementor\Group_Control_Box_Shadow;
use \Elementor\Group_Control_Image_Size;
use \Elementor\Icons_Manager;
use \Elementor\Group_Control_Background;
use \Elementor\Group_Control_Typography;
use \Elementor\Utils;
use \ExclusiveAddons\Elementor\Helper;
use \Elementor\Widget_Base;


class Counter extends Widget_Base {
	
	public function get_name() {
		return 'exad-counter';
	}
	public function get_title() {
		return esc_html__( 'Counter', 'exclusive-addons-elementor-pro' );
	}
	public function get_icon() {
		return 'exad exad-logo exad-counter';
	}
	public function get_categories() {
		return [ 'exclusive-addons-elementor' ];
	}

	public function get_script_depends() {
		return [ 'exad-waypoints', 'exad-counter' ];
	}

	public function get_keywords() {
        return [ 'up', 'increase', 'counter up', 'count up' ];
    }

	protected function register_controls() {
		$exad_primary_color = get_option( 'exad_primary_color_option', '#7a56ff' );

		/*
		* Number Content
		*/
	    $this->start_controls_section(
			'exad_section_counter_number',
			[
				'label' => esc_html__( 'Contents', 'exclusive-addons-elementor-pro' )
			]
	    );

	    $this->add_control(
	        'exad_counter_img_or_icon',
	        [
				'label'       => esc_html__( 'Image or Icon', 'exclusive-addons-elementor-pro' ),
				'type'        => Controls_Manager::CHOOSE,
				'toggle'      => false,
				'label_block' => true,
				'default'     => 'icon',
	            'options'     => [
					'none'      => [
						'title' => esc_html__( 'None', 'exclusive-addons-elementor-pro' ),
						'icon'  => 'eicon-ban'
					],
					'icon'      => [
						'title' => esc_html__( 'Icon', 'exclusive-addons-elementor-pro' ),
						'icon'  => 'eicon-info-circle'
					],
					'img'       => [
						'title' => esc_html__( 'Image', 'exclusive-addons-elementor-pro' ),
						'icon'  => 'eicon-image-bold'
					]
				],
	        ]
	    );

	  	$this->add_control(
	        'exad_counter_icon',
	        [
				'label'       => esc_html__( 'Icon', 'exclusive-addons-elementor-pro' ),
				'type'        => Controls_Manager::ICONS,
				'default'     => [
	                'value'   => 'fas fa-spinner',
	                'library' => 'fa-solid'
	            ],
		      	'condition'   => [
	                'exad_counter_img_or_icon' => 'icon'
	            ]
	        ]
	    );

	    $this->add_control(
	        'exad_counter_image',
	        [
				'label'     => esc_html__( 'Image', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::MEDIA,
				'default'   => [
	                'url'   => Utils::get_placeholder_image_src()
	            ],
				'dynamic' => [
					'active' => true,
				],
	            'condition' => [
	                'exad_counter_img_or_icon' => 'img'
	            ]
	        ]
	    );

		$this->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
				'name'    => 'exad_counter_image_size',
				'default' => 'thumbnail',
				'condition' => [
	                'exad_counter_img_or_icon' => 'img'
	            ]
            ]
        );

	    $this->add_control(
			'exad_counter_number',
			[
				'label'     => esc_html__( 'Count Number', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::NUMBER,
				'separator' => 'before',
				'default'   => 50
			]
		);

		$this->add_control(
			'exad_counter_title',
			[
				'label'   => esc_html__( 'Title', 'exclusive-addons-elementor-pro' ),
				'type'    => Controls_Manager::TEXT,
				'default' => esc_html__( 'Counter Title', 'exclusive-addons-elementor-pro' )
			]
		);

		$this->add_control(
            'exad_counter_title_tag',
            [
                'label'   => __('Heading HTML Tag', 'exclusive-addons-elementor-pro'),
                'type'    => Controls_Manager::SELECT,
                'options' => Helper::exad_title_tags(),
                'default' => 'h4',
            ]
		);

		$this->add_control(
			'exad_counter_suffix',
			[
				'label'   => __( 'Suffix', 'exclusive-addons-elementor-pro' ),
				'type'    => Controls_Manager::TEXT,
				'default' => "+"
			]
		);

		$this->add_control(
			'exad_counter_speed',
			[
				'label'       => esc_html__( 'Counting Speed', 'exclusive-addons-elementor-pro' ),
				'type'        => Controls_Manager::NUMBER,
				'description' => __( 'In Milliseconds', 'exclusive-addons-elementor-pro' ),
				'default'     => 2000
			]
		);

		$this->add_control(
			'exad_counter_layout',
			[
				'label' => __( 'Counter Position', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'layout-1' => [
						'title' => __( 'Icon Top', 'exclusive-addons-elementor-pro' ),
						'icon' => 'eicon-v-align-top',
					],
					'layout-2' => [
						'title' => __( 'Number Buttom', 'exclusive-addons-elementor-pro' ),
						'icon' => 'eicon-v-align-bottom',
					],
					'layout-3' => [
						'title' => __( 'Icon Left', 'exclusive-addons-elementor-pro' ),
						'icon' => 'eicon-h-align-left',
					],
					'layout-4' => [
						'title' => __( 'Icon Right', 'exclusive-addons-elementor-pro' ),
						'icon' => 'eicon-h-align-right',
					],
				],
				'default' => 'layout-1',
				'toggle' => true,
			]
		);
	    
		$this->end_controls_section();
				
		/*
		* Counter Styling Section
		*/
		$this->start_controls_section(
			'exad_section_counter_container',
			[
				'label' => esc_html__( 'Container', 'exclusive-addons-elementor-pro' ),
				'tab'   => Controls_Manager::TAB_STYLE
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'exad_counter_background',
				'types'    => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .exad-counter-item',
				'fields_options'  => [
                    'background'  => [
                        'default' => 'classic'
                    ],
                    'color'       => [
                        'default' => $exad_primary_color
                    ]
                ]
			]
		);

		$this->add_control(
			'exad_counter_alignment',
			[
				'label'     => esc_html__( 'Alignment', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::CHOOSE,
				'toggle'    => false,
				'separator' => 'after',
				'default'   => 'exad-counter-center',
				'options'   => [
					'exad-counter-left'   => [
						'title' => __( 'Left', 'exclusive-addons-elementor-pro' ),
						'icon'  => 'eicon-text-align-left'
					],
					'exad-counter-center' => [
						'title' => __( 'Center', 'exclusive-addons-elementor-pro' ),
						'icon'  => 'eicon-text-align-center'
					],
					'exad-counter-right'  => [
						'title' => __( 'Right', 'exclusive-addons-elementor-pro' ),
						'icon'  => 'eicon-text-align-right'
					]
				]
			]
        );
        
        $this->add_responsive_control(
			'exad_counter_wrapper_padding',
			[
				'label'        => __( 'Padding', 'exclusive-addons-elementor-pro' ),
				'type'         => Controls_Manager::DIMENSIONS,
				'size_units'   => [ 'px', '%', 'em' ],
				'default'      => [
					'top'      => 20,
					'right'    => 20,
					'bottom'   => 20,
					'left'     => 20
				],
				'selectors'    => [
					'{{WRAPPER}} .exad-counter-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
		);

		$this->add_responsive_control(
			'exad_counter_container_margin',
			[
				'label'        => __( 'Margin', 'exclusive-addons-elementor-pro' ),
				'type'         => Controls_Manager::DIMENSIONS,
				'separator'    => 'after',
				'size_units'   => [ 'px', 'em' ],
				'default'      => [
					'top'      => 0,
					'right'    => 0,
					'bottom'   => 0,
					'left'     => 0
				],
				'selectors'    => [
					'{{WRAPPER}} .exad-counter-item' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
		);
		
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'exad_counter_container_border',
				'selector' => '{{WRAPPER}} .exad-counter-item'
			]
		);
        
        $this->add_responsive_control(
			'exad_counter_radius',
			[
				'label'        => __( 'Border Radius', 'exclusive-addons-elementor-pro' ),
				'type'         => Controls_Manager::DIMENSIONS,
				'size_units'   => [ 'px', 'em', '%' ],
				'default'      => [
					'top'      => 5,
					'right'    => 5,
					'bottom'   => 5,
					'left'     => 5
				],
				'selectors'    => [
					'{{WRAPPER}} .exad-counter-item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
        );

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'exad_counter_container_shadow',
				'selector' => '{{WRAPPER}} .exad-counter-item'
			]
		);

		$this->end_controls_section();

		/**
		* Style Tab: Icon
		**/
		$this->start_controls_section(
			'exad_counter_icon_style',
			[
				'label'     => esc_html__( 'Icon', 'exclusive-addons-elementor-pro' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
	                'exad_counter_img_or_icon' => 'icon'
	            ]
			]
		);

		$this->add_control(
			'exad_counter_icon_box',
			[
				'label'        => __( 'Icon Box Enable or Disable', 'exclusive-addons-elementor-pro' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'Show', 'exclusive-addons-elementor-pro' ),
				'label_off'    => __( 'Hide', 'exclusive-addons-elementor-pro' ),
				'return_value' => 'yes',
				'default'      => 'no',
			]
		);

		$this->add_responsive_control(
			'exad_counter_icon_box_size',
			[
				'label'      => esc_html__( 'Box Size', 'exclusive-addons-elementor-pro' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range'      => [
					'px'       => [
						'min'  => 20,
						'max'  => 200,
					]
				],
				'default'   => [
					'unit'  => 'px',
					'size'  => 24
				],
				'selectors' => [
					'{{WRAPPER}} .exad-counter-item .exad-counter-icon.yes' => 'height: {{SIZE}}{{UNIT}}; width: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .exad-counter-item.layout-3 .exad-counter-icon.yes' => 'width: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .exad-counter-item.layout-3 .exad-counter-content-wrapper' => 'width: calc( 100% - {{SIZE}}{{UNIT}} );',
					'{{WRAPPER}} .exad-counter-item.layout-4 .exad-counter-icon.yes' => 'width: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .exad-counter-item.layout-4 .exad-counter-content-wrapper' => 'width: calc( 100% - {{SIZE}}{{UNIT}} );'
				],
				'condition'	=> [
					'exad_counter_icon_box' => 'yes'
				]
			]
		);

		$this->add_responsive_control(
			'exad_counter_icon_size',
			[
				'label'      => esc_html__( 'Size', 'exclusive-addons-elementor-pro' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range'      => [
					'px'       => [
						'min'  => 10,
						'max'  => 50,
						'step' => 5
					]
				],
				'default'   => [
					'unit'  => 'px',
					'size'  => 24
				],
				'selectors' => [
					'{{WRAPPER}} .exad-counter-item .exad-counter-icon i' => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .exad-counter-item .exad-counter-icon svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};'
				]
			]
		);

		$this->add_control(
			'exad_counter_icon_color',
			[
				'label'     => esc_html__( 'Color', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .exad-counter-item .exad-counter-icon' => 'color: {{VALUE}};'
				]
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'exad_counter_icon_background',
				'types'    => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .exad-counter-item .exad-counter-icon'
			]
		);

		$this->add_responsive_control(
			'exad_counter_icon_margin',
			[
				'label'      => __( 'Margin', 'exclusive-addons-elementor-pro' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'separator'  => 'after',
				'default'    => [
					'top'    => '0',
					'right'  => '0',
					'bottom' => '0',
					'left'   => '0'
				],
				'selectors'  => [
					'{{WRAPPER}} .exad-counter-item .exad-counter-icon' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'exad_counter_icon_border',
				'selector' => '{{WRAPPER}} .exad-counter-item .exad-counter-icon'
			]
		);

		$this->add_responsive_control(
			'exad_counter_icon_border_radius',
			[
				'label'      => __( 'Border Radius', 'exclusive-addons-elementor-pro' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'default'    => [
					'top'    => '50',
					'right'  => '50',
					'bottom' => '50',
					'left'   => '50',
					'unit'   => '%'
				],
				'selectors'  => [
					'{{WRAPPER}} .exad-counter-item .exad-counter-icon' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
		);

		$this->end_controls_section();

		/**
		* Style Tab: Image
		**/
		$this->start_controls_section(
			'exad_counter_image_style',
			[
				'label'     => esc_html__( 'Image', 'exclusive-addons-elementor-pro' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'exad_counter_img_or_icon' => 'img',
					'exad_counter_image[url]!' => ''
	            ]
			]
		);

		$this->add_responsive_control(
			'exad_counter_image_padding',
			[
				'label'      => __( 'Padding', 'exclusive-addons-elementor-pro' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'separator'  => 'before',
				'default'    => [
					'top'    => '10',
					'right'  => '10',
					'bottom' => '10',
					'left'   => '10'
				],
				'selectors'  => [
					'{{WRAPPER}} .exad-counter-item .exad-counter-icon img' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
		);

		$this->add_responsive_control(
			'exad_counter_image_margin',
			[
				'label'      => __( 'Margin', 'exclusive-addons-elementor-pro' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'separator'  => 'after',
				'default'    => [
					'top'    => '0',
					'right'  => '0',
					'bottom' => '0',
					'left'   => '0'
				],
				'selectors'  => [
					'{{WRAPPER}} .exad-counter-item .exad-counter-icon img' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'exad_counter_image_border',
				'selector' => '{{WRAPPER}} .exad-counter-item .exad-counter-icon img'
			]
		);

		$this->add_responsive_control(
			'exad_counter_image_border_radius',
			[
				'label'      => __( 'Border Radius', 'exclusive-addons-elementor-pro' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .exad-counter-item .exad-counter-icon img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
		);

		$this->end_controls_section();

		/**
		* Style Tab: Counter Number
		**/
		$this->start_controls_section(
			'exad_counter_number_style',
			[
				'label' => __( 'Number', 'exclusive-addons-elementor-pro' ),
				'tab'   => Controls_Manager::TAB_STYLE
			]
		);

		$this->add_control(
			'exad_counter_number_box',
			[
				'label'        => __( 'Number Box Enable or Disable', 'exclusive-addons-elementor-pro' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'Show', 'exclusive-addons-elementor-pro' ),
				'label_off'    => __( 'Hide', 'exclusive-addons-elementor-pro' ),
				'return_value' => 'yes',
				'default'      => 'no',
			]
		);

		$this->add_responsive_control(
			'exad_counter_number_box_height',
			[
				'label'      => esc_html__( 'Number Box Height', 'exclusive-addons-elementor-pro' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px'       => [
						'min'  => 50,
						'max'  => 300,
					]
				],
				'default'   => [
					'unit'  => 'px',
					'size'  => 70
				],
				'selectors' => [
					'{{WRAPPER}} .exad-counter-data.yes' => 'height: {{SIZE}}{{UNIT}}; width: {{SIZE}}{{UNIT}}',
					'{{WRAPPER}} .exad-counter-data.yes .exad-counter' => 'line-height: calc( {{SIZE}}{{UNIT}} - (6px*2))',
					'{{WRAPPER}} .exad-counter-data.yes .exad-counter-suffix' => 'line-height: calc( {{SIZE}}{{UNIT}} - (6px*2))'
				],
				'condition'	=> [
					'exad_counter_number_box' => 'yes'
				]
			]
		);

		$this->add_responsive_control(
			'exad_counter_number_box_width',
			[
				'label'      => esc_html__( 'Number Box Width', 'exclusive-addons-elementor-pro' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px'       => [
						'min'  => 50,
						'max'  => 300,
					]
				],
				'default'   => [
					'unit'  => 'px',
					'size'  => 70
				],
				'selectors' => [
					'{{WRAPPER}} .exad-counter-data.yes' => 'width: {{SIZE}}{{UNIT}}',
				],
				'condition'	=> [
					'exad_counter_number_box' => 'yes'
				]
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'      => 'exad_counter_number_box_background',
				'label'     => __( 'Background', 'exclusive-addons-elementor-pro' ),
				'types'     => ['classic', 'gradient'],
				'selector'  => '{{WRAPPER}} .exad-counter-data.yes',
				'condition' => [
					'exad_counter_number_box' => 'yes',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'exad_counter_number_box_border',
				'label'    => __( 'Border', 'exclusive-addons-elementor-pro' ),
				'selector' => '{{WRAPPER}} .exad-counter-data.yes',
				'condition' => [
					'exad_counter_number_box' => 'yes',
				],
			]
		);

		$this->add_responsive_control(
			'exad_counter_number_box_radius',
			[
				'label'      => __( 'Box Border Radius', 'exclusive-addons-elementor-pro' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'default'    => [
					'top'      => 0,
					'right'    => 0,
					'bottom'   => 0,
					'left'     => 0
				],
				'selectors' => [
					'{{WRAPPER}} .exad-counter-data.yes' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				],
				'condition'	=> [
					'exad_counter_number_box' => 'yes'
				]
			]
		);

		$this->add_responsive_control(
			'exad_counter_number_margin',
			[
				'label'      => __( 'Number Margin', 'exclusive-addons-elementor-pro' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .exad-counter-item .exad-counter-data' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				],
				'condition'	=> [
					'exad_counter_layout' => [ 'layout-3', 'layout-4' ]
				]
			]
		);

		$this->add_control(
			'exad_counter_number_color',
			[
				'label'     => __( 'Color', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .exad-counter-item .exad-counter-data' => 'color: {{VALUE}};'
				]
			]
		);
		
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'exad_counter_number_typography',
				'selector' => '{{WRAPPER}} .exad-counter-item .exad-counter-data '
			]
		);


		$this->add_responsive_control(
			'exad_counter_number_bottom_spacing',
			[
				'label'      => esc_html__( 'Bottom Spacing', 'exclusive-addons-elementor-pro' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px'       => [
						'min'  => 0,
						'max'  => 100,
					]
				],
				'default'   => [
					'unit'  => 'px',
					'size'  => 20
				],
				'selectors' => [
					'{{WRAPPER}} .exad-counter-item .exad-counter-data.yes' => 'margin-bottom: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .exad-counter-item .exad-counter-data' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
				'condition'	=> [
					'exad_counter_layout' => [ 'layout-1', 'layout-2' ]
				]
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'exad_counter_number_box_shadow',
				'label' => __( 'Box Shadow', 'exclusive-addons-elementor-pro' ),
				'selector' => '{{WRAPPER}} .exad-counter-item .exad-counter-data.yes',
				'condition'	=> [
					'exad_counter_number_box' => 'yes'
				]
			]
		);

		$this->add_control(
			'exad_counter_number_suffix_heading',
			[
				'label' => __( 'Suffix', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'exad_counter_suffix_color',
			[
				'label'     => __( 'Color', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .exad-counter-item .exad-counter-data .exad-counter-suffix' => 'color: {{VALUE}};'
				]
			]
		);
		
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'exad_counter_suffix_typography',
				'selector' => '{{WRAPPER}} .exad-counter-item .exad-counter-data .exad-counter-suffix'
			]
		);
		
		$this->add_responsive_control(
			'exad_counter_suffix_spacing',
			[
				'label'      => __( 'Spacing', 'exclusive-addons-elementor-pro' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px'],
				'default'    => [
                    'size'   => 1,
                    'unit'   => 'px'
                ],
				'range'      => [
					'px'     => [
						'min' => 0,
						'max' => 25
					]
				],
				'selectors'  => [
					'{{WRAPPER}} .exad-counter-item .exad-counter-data .exad-counter-suffix' => 'margin-left: {{SIZE}}{{UNIT}};'
				]
			]
		);
		
		$this->end_controls_section();

		/**
		* Style Tab: Suffix
		**/
		// $this->start_controls_section(
		// 	'exad_counter_suffix_style',
		// 	[
		// 		'label' => __( 'Suffix', 'exclusive-addons-elementor-pro' ),
		// 		'tab'   => Controls_Manager::TAB_STYLE
		// 	]
		// );

		

		// $this->end_controls_section();

		/**
		* Style Tab: Counter Title
		**/
		$this->start_controls_section(
			'exad_counter_title_style',
			[
				'label' => __( 'Title', 'exclusive-addons-elementor-pro' ),
				'tab'   => Controls_Manager::TAB_STYLE
			]
		);

		$this->add_control(
			'exad_counter_title_color',
			[
				'label'     => __( 'Color', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
						'{{WRAPPER}} .exad-counter-item .exad-counter-content .exad-counterup-title' => 'color: {{VALUE}};'
				]
			]
		);
		
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'exad_counter_title_typography',
				'selector' => '{{WRAPPER}} .exad-counter-item .exad-counter-content .exad-counterup-title'
			]
		);

		$this->add_responsive_control(
			'exad_counter_title_margin',
			[
				'label'      => __( 'Margin', 'exclusive-addons-elementor-pro' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .exad-counter-item .exad-counter-content .exad-counterup-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
		);
		
		$this->end_controls_section();

	}

	private function counterUpContent( $number, $suffix ) {
		$output = '<div '.$this->get_render_attribute_string( 'exad_counter_data' ).'>';
			$number ? $output .= '<span '.$this->get_render_attribute_string( 'exad_counter_number' ).'>'.esc_html( $number ).'</span>' : '';
			$suffix ? $output .= '<span '.$this->get_render_attribute_string( 'exad_counter_suffix' ).'>'.$suffix.'</span>' : '';
		$output .= '</div>';
		return $output;
	}

	private function counterUpTitle( $title ) {
		$output = '';
		$settings       = $this->get_settings_for_display();
		if( $title ) {
			$output = '<div class="exad-counter-content">';
				$output .= '<'.Utils::validate_html_tag( $settings['exad_counter_title_tag'] ) .' '.$this->get_render_attribute_string( 'exad_counter_title' ).'>'.wp_kses_post( $title ).'</'.Utils::validate_html_tag( $settings['exad_counter_title_tag'] ).'>';
			$output .= '</div>';
		}
		return $output;
	}

	protected function render() {
		$settings       = $this->get_settings_for_display();
		$counter_image  = $settings['exad_counter_image'];
		$counter_layout = $settings['exad_counter_layout'];

		$this->add_render_attribute( 'exad_counter_data', [
			'class'              => ['exad-counter-data', esc_attr( $settings['exad_counter_number_box'] )],
		] );

		$this->add_render_attribute( 'exad_counter_title', 'class', 'exad-counterup-title' );
		$this->add_inline_editing_attributes( 'exad_counter_title', 'basic' );

		$this->add_render_attribute( 'exad_counter_suffix', 'class', 'exad-counter-suffix' );
		$this->add_inline_editing_attributes( 'exad_counter_suffix', 'none' );

		$this->add_render_attribute( 'exad_counter_number', [
			'class'              => 'exad-counter', 
			'data-counter-speed' =>  esc_attr( $settings['exad_counter_speed'] )
		] );
		$this->add_inline_editing_attributes( 'exad_counter_number', 'none' );


		do_action('exad_counter_wrapper_before');
		?>
	    <div class="exad-counter-wrapper">
	        <div class="exad-counter-item <?php echo esc_attr( $settings['exad_counter_alignment'] ); ?> <?php echo esc_attr( $counter_layout ); ?>">

	        	<?php if ( 'img' === $settings['exad_counter_img_or_icon'] && ! empty( $settings['exad_counter_image']['url'] ) ) : ?>
                    <span class="exad-counter-icon">
                        <?php echo Group_Control_Image_Size::get_attachment_image_html( $settings, 'exad_counter_image_size', 'exad_counter_image' ); ?>
                    </span>
                <?php endif;

		        if ( 'icon' === $settings['exad_counter_img_or_icon'] && ! empty( $settings['exad_counter_icon']['value'] ) ) : ?>
		          	<span class="exad-counter-icon <?php echo esc_attr( $settings['exad_counter_icon_box'] ); ?>">
		    			<?php Icons_Manager::render_icon( $settings['exad_counter_icon'], [ 'aria-hidden' => 'true' ] ); ?>
		          	</span>
				<?php endif;

				do_action('exad_counter_content_before');

				if ( 'layout-1' === $counter_layout ) {
					echo $this->counterUpContent( $settings['exad_counter_number'], $settings['exad_counter_suffix'] );
					echo $this->counterUpTitle( $settings['exad_counter_title'] );
				} 
				if ( 'layout-2' === $counter_layout ) {
					echo $this->counterUpTitle( $settings['exad_counter_title'] );
					echo $this->counterUpContent( $settings['exad_counter_number'], $settings['exad_counter_suffix'] );
				}
				if ( 'layout-3' === $counter_layout ) { ?>
					<div class="exad-counter-content-wrapper">
						<?php
							echo $this->counterUpContent( $settings['exad_counter_number'], $settings['exad_counter_suffix'] );
							echo $this->counterUpTitle( $settings['exad_counter_title'] );
						?>
					</div>
				<?php }
				if ( 'layout-4' === $counter_layout ) { ?>
					<div class="exad-counter-content-wrapper">
						<?php 
							echo $this->counterUpContent( $settings['exad_counter_number'], $settings['exad_counter_suffix'] );
							echo $this->counterUpTitle( $settings['exad_counter_title'] );
						?>
					</div>
				<?php }
				
				do_action('exad_counter_content_after'); ?>

	        </div>
	    </div>
		<?php
	    do_action('exad_counter_wrapper_after');
	}

	/**
     * Render counter widget output in the editor.
     *
     * Written as a Backbone JavaScript template and used to generate the live preview.
     *
     * @since 1.0.0
     * @access protected
     */
    protected function content_template() {
		?>
    	<#
    		if ( settings.exad_counter_image.url || settings.exad_counter_image.id ) {
                var image = {
                    id: settings.exad_counter_image.id,
                    url: settings.exad_counter_image.url,
                    size: settings.exad_counter_image_size_size,
                    dimension: settings.exad_counter_image_size_custom_dimension,
                    model: view.getEditModel()
                };

                var imageURL = elementor.imagesManager.getImageUrl( image );
            }

			view.addRenderAttribute( 'exad_counter_data', {
				'class'              : ['exad-counter-data', settings.exad_counter_number_box ]
			} );

            view.addRenderAttribute( 'exad_counter_title', 'class', 'exad-counterup-title' );
			view.addInlineEditingAttributes( 'exad_counter_title', 'basic' );

			view.addRenderAttribute( 'exad_counter_suffix', 'class', 'exad-counter-suffix' );
			view.addInlineEditingAttributes( 'exad_counter_suffix', 'none' );

			view.addRenderAttribute( 'exad_counter_number', {
				'class': [ 
					'exad-counter', 
					settings.exad_counter_speed
				]
			} );

			view.addInlineEditingAttributes( 'exad_counter_number', 'none' );

            var iconHTML = elementor.helpers.renderIcon( view, settings.exad_counter_icon, { 'aria-hidden': true }, 'i' , 'object' );

			var counterTitleHTMLTag = elementor.helpers.validateHTMLTag( settings.exad_counter_title_tag );
    	#>
		<div class="exad-counter-wrapper">
			<div class="exad-counter-item {{{ settings.exad_counter_alignment }}} {{{ settings.exad_counter_layout }}}">

				<# if ( 'img' === settings.exad_counter_img_or_icon && settings.exad_counter_image.url ) { #>
					<span class="exad-counter-icon">
                    	<img src="{{{ imageURL }}}">
                    </span>
                <# } #>

				<# if ( 'icon' === settings.exad_counter_img_or_icon && iconHTML.value ) { #>
					<span class="exad-counter-icon {{{ settings.exad_counter_icon_box }}}">
                    	{{{ iconHTML.value }}}
                    </span>
                <# } #>
				<# if ( 'layout-1' === settings.exad_counter_layout ) { #>
					<div {{{ view.getRenderAttributeString( 'exad_counter_data' ) }}}>
						<# if ( settings.exad_counter_number ) { #>
							<span {{{ view.getRenderAttributeString( 'exad_counter_number' ) }}}>
								{{{ settings.exad_counter_number }}}
							</span>
						<# } #>

						<# if ( settings.exad_counter_suffix ) { #>
							<span {{{ view.getRenderAttributeString( 'exad_counter_suffix' ) }}}>
								{{{ settings.exad_counter_suffix }}}
							</span>
						<# } #>
					</div>
					<# if ( settings.exad_counter_title ) { #>
                        <div class="exad-counter-content">
                            <{{{ counterTitleHTMLTag }}} {{{ view.getRenderAttributeString( 'exad_counter_title' ) }}}>
                                {{{ settings.exad_counter_title }}}
                            </{{{ counterTitleHTMLTag }}}>
                        </div>
                    <# } #>
				<# } #>
				<# if ( 'layout-2' === settings.exad_counter_layout ) { #>
					<# if ( settings.exad_counter_title ) { #>
                        <div class="exad-counter-content">
                            <{{{ counterTitleHTMLTag }}} {{{ view.getRenderAttributeString( 'exad_counter_title' ) }}}>
                                {{{ settings.exad_counter_title }}}
                            </{{{ counterTitleHTMLTag }}}>
                        </div>
                    <# } #>
					<div {{{ view.getRenderAttributeString( 'exad_counter_data' ) }}}>
						<# if ( settings.exad_counter_number ) { #>
							<span {{{ view.getRenderAttributeString( 'exad_counter_number' ) }}}>
								{{{ settings.exad_counter_number }}}
							</span>
						<# } #>
						<# if ( settings.exad_counter_suffix ) { #>
							<span {{{ view.getRenderAttributeString( 'exad_counter_suffix' ) }}}>
								{{{ settings.exad_counter_suffix }}}
							</span>
						<# } #>
					</div>
				<# } #>
				<# if ( 'layout-3' === settings.exad_counter_layout ) { #>
					<div class="exad-counter-content-wrapper">
						<div {{{ view.getRenderAttributeString( 'exad_counter_data' ) }}}>
							<# if ( settings.exad_counter_number ) { #>
								<span {{{ view.getRenderAttributeString( 'exad_counter_number' ) }}}>
									{{{ settings.exad_counter_number }}}
								</span>
							<# } #>

							<# if ( settings.exad_counter_suffix ) { #>
								<span {{{ view.getRenderAttributeString( 'exad_counter_suffix' ) }}}>
									{{{ settings.exad_counter_suffix }}}
								</span>
							<# } #>
						</div>
						<# if ( settings.exad_counter_title ) { #>
							<div class="exad-counter-content">
								<{{{ counterTitleHTMLTag }}} {{{ view.getRenderAttributeString( 'exad_counter_title' ) }}}>
									{{{ settings.exad_counter_title }}}
								</{{{ counterTitleHTMLTag }}}>
							</div>
						<# } #>
					</div>
				<# } #>
				<# if ( 'layout-4' === settings.exad_counter_layout ) { #>
					<div class="exad-counter-content-wrapper">
						<div {{{ view.getRenderAttributeString( 'exad_counter_data' ) }}}>
							<# if ( settings.exad_counter_number ) { #>
								<span {{{ view.getRenderAttributeString( 'exad_counter_number' ) }}}>
									{{{ settings.exad_counter_number }}}
								</span>
							<# } #>

							<# if ( settings.exad_counter_suffix ) { #>
								<span {{{ view.getRenderAttributeString( 'exad_counter_suffix' ) }}}>
									{{{ settings.exad_counter_suffix }}}
								</span>
							<# } #>
						</div>
						<# if ( settings.exad_counter_title ) { #>
							<div class="exad-counter-content">
								<{{{ counterTitleHTMLTag }}} {{{ view.getRenderAttributeString( 'exad_counter_title' ) }}}>
									{{{ settings.exad_counter_title }}}
								</{{{ counterTitleHTMLTag }}}>
							</div>
						<# } #>
					</div>
				<# } #>

			</div>
		</div>
    	<?php
    }
}