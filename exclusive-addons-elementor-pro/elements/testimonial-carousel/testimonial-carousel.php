<?php
namespace ExclusiveAddons\Elements;

if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.

use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Border;
use \Elementor\Repeater;
use \Elementor\Group_Control_Box_Shadow;
use \Elementor\Group_Control_Image_Size;
use \Elementor\Group_Control_Background;
use \Elementor\Group_Control_Typography;
use \Elementor\Utils;
use \Elementor\Widget_Base;
use \Elementor\Icons_Manager;
use \ExclusiveAddons\Elementor\Helper;

class Testimonial_Carousel extends Widget_Base {

	public function get_name() {
		return 'exad-testimonial-carousel';
	}

	public function get_title() {
		return esc_html__( 'Testimonial Carousel', 'exclusive-addons-elementor-pro' );
	}

	public function get_icon() {
		return 'exad exad-logo exad-testimonial-carousel';
	}

	public function get_categories() {
		return [ 'exclusive-addons-elementor' ];
	}

	public function get_keywords() {
        return [ 'review', 'feedback' ];
    }

	public function get_script_depends() {
		return [ 'exad-slick' ];
	}

	protected function register_controls() {
		$exad_primary_color   = get_option( 'exad_primary_color_option', '#7a56ff' );

		$this->start_controls_section(
			'section_testimonial_carousel',
			[
				'label' => esc_html__( 'Contents', 'exclusive-addons-elementor-pro' ),
			]
		);

		$this->add_control(
            'exad_testimonial_carousel_name_tag',
            [
                'label'   => __('Name HTML Tag', 'exclusive-addons-elementor-pro'),
                'type'    => Controls_Manager::SELECT,
                'options' => Helper::exad_title_tags(),
                'default' => 'h4',
            ]
		);

		$testimonial_repeater = new Repeater();
		
		$testimonial_repeater->add_control(
			'exad_testimonial_carousel_image',
			[
				'label'   => __( 'Image', 'exclusive-addons-elementor-pro' ),
				'type'    => Controls_Manager::MEDIA,
				'default' => [
					'url' => Utils::get_placeholder_image_src()
				],
				'dynamic' => [
					'active' => true,
				]
			]
		);

		$testimonial_repeater->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name'      => 'thumbnail',
				'default'   => 'full',
				'condition' => [
					'exad_testimonial_carousel_image[url]!' => ''
				]
			]
		);

		$testimonial_repeater->add_control(
			'exad_testimonial_carousel_description',
			[
				'label'   => esc_html__( 'Testimonial', 'exclusive-addons-elementor-pro' ),
				'type'    => Controls_Manager::TEXTAREA,
				'default' => esc_html__( 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen.', 'exclusive-addons-elementor-pro' )
			]
		);

		$testimonial_repeater->add_control(
			'exad_testimonial_carousel_name',
			[
				'label'   => esc_html__( 'Name', 'exclusive-addons-elementor-pro' ),
				'type'    => Controls_Manager::TEXT,
				'default' => esc_html__( 'John Doe', 'exclusive-addons-elementor-pro' )
			]
		);
		
		$testimonial_repeater->add_control(
			'exad_testimonial_carousel_designation',
			[
				'label'   => esc_html__( 'Designation', 'exclusive-addons-elementor-pro' ),
				'type'    => Controls_Manager::TEXT,
				'default' => esc_html__( 'Co-Founder', 'exclusive-addons-elementor-pro' )
			]
		);

		$testimonial_repeater->add_control(
			'exad_testimonial_carousel_enable_rating',
			[
				'label'   => esc_html__( 'Display Rating?', 'exclusive-addons-elementor-pro' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'no'
			]
		);

		$testimonial_repeater->add_control(
			'exad_testimonial_carousel_rating_icon',
			[
				'label' => __( 'Rating Icon', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::ICONS,
				'label_block' => false,
				'default' => [
					'value' => 'fas fa-star',
					'library' => 'solid',
				],
				'skin' => 'inline',
				'exclude_inline_options' => ['svg'],
				'condition' => [
					'exad_testimonial_carousel_enable_rating' => 'yes'
				]
			]
		);

		$rating_number = range( 1, 5 );
        $rating_number = array_combine( $rating_number, $rating_number );

		$testimonial_repeater->add_control(
		  	'exad_testimonial_carousel_rating_number',
		  	[
				'label'     => __( 'Rating Number', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 5,
				'options'   => $rating_number,
				'condition' => [
					'exad_testimonial_carousel_enable_rating' => 'yes'
				]
		  	]
		);

		$testimonial_repeater->add_control(
			'exad_testimonial_carousel_custom_style',
			[
				'label' => __( 'Custom Style?', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'exclusive-addons-elementor-pro' ),
				'label_off' => __( 'Hide', 'exclusive-addons-elementor-pro' ),
				'return_value' => 'yes',
				'default' => 'no',
			]
        );

        $testimonial_repeater->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'exad_testimonial_carousel_custom_background',
				'label' => __( 'Background', 'exclusive-addons-elementor-pro' ),
				'types' => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}} {{CURRENT_ITEM}}.exad-testimonial-wrapper',
                'condition'       => [
                    'exad_testimonial_carousel_custom_style' => 'yes'
                ]
			]
        );

		$testimonial_repeater->add_control(
			'exad_testimonial_carousel_custom_testimonial_color',
			[
				'label' => __( 'Testimonial Text Color', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}}.exad-testimonial-wrapper .exad-testimonial-description' => 'color: {{VALUE}}',
				],
				'condition'       => [
                    'exad_testimonial_carousel_custom_style' => 'yes'
                ]
			]
		);

		$testimonial_repeater->add_control(
			'exad_testimonial_carousel_custom_title_color',
			[
				'label' => __( 'Name Text Color', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}}.exad-testimonial-wrapper .exad-testimonial-name' => 'color: {{VALUE}}',
				],
				'condition'       => [
                    'exad_testimonial_carousel_custom_style' => 'yes'
                ]
			]
		);

		$testimonial_repeater->add_control(
			'exad_testimonial_carousel_custom_designation_color',
			[
				'label' => __( 'Designation Text Color', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}}.exad-testimonial-wrapper .exad-testimonial-designation' => 'color: {{VALUE}}',
				],
				'condition'       => [
                    'exad_testimonial_carousel_custom_style' => 'yes'
                ]
			]
		);

		$testimonial_repeater->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'exad_testimonial_carousel_custom_border',
				'label' => __( 'Border', 'exclusive-addons-elementor-pro' ),
				'types' => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}} {{CURRENT_ITEM}}.exad-testimonial-wrapper',
                'condition'       => [
                    'exad_testimonial_carousel_custom_style' => 'yes'
                ]
			]
		);

		$this->add_control(
			'testimonial_carousel_repeater',
			[
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $testimonial_repeater->get_controls(),
				'title_field' => '{{{ exad_testimonial_carousel_name }}}',
				'default'     => [
					[ 'exad_testimonial_carousel_name' => __( 'Paul Gillian', 'exclusive-addons-elementor-pro' ) ],
					[ 'exad_testimonial_carousel_name' => __( 'David Fontaine', 'exclusive-addons-elementor-pro' ) ],
					[ 'exad_testimonial_carousel_name' => __( 'Charles Jensen', 'exclusive-addons-elementor-pro' ) ],
					[ 'exad_testimonial_carousel_name' => __( 'Francis Miller', 'exclusive-addons-elementor-pro' ) ]
				]	
			]
		);

		$this->end_controls_section();
	
		$this->start_controls_section(
			'section_test_carousel_settings',
			[
				'label' => esc_html__( 'Carousel Settings', 'exclusive-addons-elementor-pro' )
			]
		);

		$slides_per_view = range( 1, 6 );
		$slides_per_view = array_combine( $slides_per_view, $slides_per_view );

		$this->add_control(
            'exad_testimonial_carousel_nav',
            [
                'label'   => esc_html__( 'Navigation Style', 'exclusive-addons-elementor-pro' ),
                'type'    => Controls_Manager::SELECT,
                'default' => 'arrows',
                'options' => [
					'arrows'   => esc_html__( 'Arrows', 'exclusive-addons-elementor-pro' ),
					'nav-dots' => esc_html__( 'Dots', 'exclusive-addons-elementor-pro' ),
					'both'     => esc_html__( 'Arrows and Dots', 'exclusive-addons-elementor-pro' ),
					'none'     => esc_html__( 'None', 'exclusive-addons-elementor-pro' )                    
                ]
            ]
        );

		$this->add_responsive_control(
			'exad_testimonial_per_view',
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
			'exad_testimonial_slides_to_scroll',
			[
				'type'    => Controls_Manager::SELECT,
				'label'   => esc_html__( 'Items to Scroll', 'exclusive-addons-elementor-pro' ),
				'options' => $slides_per_view,
				'default' => '1'
			]
		);

		$this->add_control(
			'exad_testimonial_transition_duration',
			[
				'label'   => esc_html__( 'Transition Duration', 'exclusive-addons-elementor-pro' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 1000
			]
		);

		$this->add_control(
			'exad_testimonial_autoplay',
			[
				'label'     => esc_html__( 'Autoplay', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::SWITCHER,
				'default'   => 'yes'
			]
		);

		$this->add_control(
			'exad_testimonial_autoplay_speed',
			[
				'label'     => esc_html__( 'Autoplay Speed', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 5000,
				'condition' => [
					'exad_testimonial_autoplay' => 'yes'
				]
			]
		);

		$this->add_control(
			'exad_testimonial_loop',
			[
				'label'   => esc_html__( 'Infinite Loop', 'exclusive-addons-elementor-pro' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes'
			]
		);

		$this->add_control(
			'exad_testimonial_pause',
			[
				'label'     => esc_html__( 'Pause on Hover', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::SWITCHER,
				'default'   => 'yes',
				'condition' => [
					'exad_testimonial_autoplay' => 'yes'
				]
			]
		);

		$this->end_controls_section();

		/*
		* Testimonial Carousel container Styling Section
		*/
		$this->start_controls_section(
			'exad_section_testimonial_carousel_styles_presets',
			[
				'label' => esc_html__( 'Container', 'exclusive-addons-elementor-pro' ),
				'tab'   => Controls_Manager::TAB_STYLE
			]
		);

		$this->add_control(
			'exad_testimonial_carousel_layout',
			[
				'label' => __( 'Layout', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'layout-1',
				'options' => [
					'layout-1'  => __( 'Layout 1', 'exclusive-addons-elementor-pro' ),
					'layout-2' => __( 'Layout 2', 'exclusive-addons-elementor-pro' ),
				],
			]
		);

		$this->add_control(
			'exad_testimonial_carousel_container_alignment',
			[
				'label'   => __( 'Alignment', 'exclusive-addons-elementor-pro' ),
				'type'    => Controls_Manager::CHOOSE,
				'toggle'  => false,
				'default' => 'exad-testimonial-align-left',
				'options' => [
					'exad-testimonial-align-left'   => [
						'title' => __( 'Left', 'exclusive-addons-elementor-pro' ),
						'icon'  => 'eicon-arrow-left'
					],
					'exad-testimonial-align-center' => [
						'title' => __( 'Center', 'exclusive-addons-elementor-pro' ),
						'icon'  => 'eicon-arrow-up'
					],
					'exad-testimonial-align-right'  => [
						'title' => __( 'Right', 'exclusive-addons-elementor-pro' ),
						'icon'  => 'eicon-arrow-right'
					],
					'exad-testimonial-align-bottom' => [
						'title' => __( 'Bottom', 'exclusive-addons-elementor-pro' ),
						'icon'  => 'eicon-arrow-down'
					]
				]
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'exad_testimonial_carousel_container_background',
				'types'    => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .exad-testimonial-wrapper'
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'            => 'exad_testimonial_carousel_container_border',
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
				'selector'        => '{{WRAPPER}} .exad-testimonial-wrapper'
			]
		);

		$this->add_responsive_control(
			'exad_testimonial_carousel_container_radius',
			[
				'label'      => __( 'Border radius', 'exclusive-addons-elementor-pro' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'separator'  => 'before',
				'default'    => [
					'top'    => '10',
					'right'  => '10',
					'bottom' => '10',
					'left'   => '10'
				],
				'selectors'  => [
					'{{WRAPPER}} .exad-testimonial-wrapper' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
		);

		$this->add_responsive_control(
			'exad_testimonial_carousel_container_padding',
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
					'{{WRAPPER}} .exad-testimonial-wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
		);

		$this->add_responsive_control(
			'exad_testimonial_carousel_container_margin',
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
					'{{WRAPPER}} .exad-testimonial-wrapper' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'exad_testimonial_carousel_container_box_shadow',
				'selector' => '{{WRAPPER}} .exad-testimonial-wrapper'
			]
		);

		$this->end_controls_section();

		/**
		 * Testimonial Carousel Image Style Section
		 */
		$this->start_controls_section(
			'exad_testimonial_carousel_image_style',
			[
				'label' => esc_html__( 'Reviewer Image', 'exclusive-addons-elementor-pro' ),
				'tab'   => Controls_Manager::TAB_STYLE
			]
		);

		$this->add_control(
			'exad_testimonial_carousel_image_box',
			[
				'label'        => __( 'Image Box', 'exclusive-addons-elementor-pro' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'ON', 'exclusive-addons-elementor-pro' ),
				'label_off'    => __( 'OFF', 'exclusive-addons-elementor-pro' ),
				'return_value' => 'yes',
				'default'      => 'yes'
			]
		);

		$this->add_responsive_control(
			'exad_testimonial_carousel_image_box_height',
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
					'size'    => 80
				],
				'selectors'   => [
					'{{WRAPPER}} .exad-testimonial-thumb'=> 'height: {{SIZE}}{{UNIT}};'
				],
				'condition'   => [
					'exad_testimonial_carousel_image_box' => 'yes'
				]
			]
		);

		$this->add_responsive_control(
			'exad_testimonial_carousel_image_box_width',
			[
				'label'       => __( 'Width', 'exclusive-addons-elementor-pro' ),
				'type'        => Controls_Manager::SLIDER,
				'separator'   => 'after',
				'size_units'  => [ 'px' ],
				'range'       => [
					'px'      => [
						'min' => 0,
						'max' => 500
					]
				],
				'default'     => [
					'unit'    => 'px',
					'size'    => 80
				],
				'selectors'   => [
					'{{WRAPPER}} .exad-testimonial-thumb'=> 'width: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .exad-testimonial-image-align-left .exad-testimonial-thumb, {{WRAPPER}} .exad-testimonial-image-align-right .exad-testimonial-thumb'=> 'width: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .exad-testimonial-image-align-left .exad-testimonial-reviewer, {{WRAPPER}} .exad-testimonial-image-align-right .exad-testimonial-reviewer'=> 'width: calc( 100% - {{SIZE}}{{UNIT}} );',
					'{{WRAPPER}} .exad-testimonial-wrapper.exad-testimonial-align-left .exad-testimonial-content-wrapper-arrow::before'=> 'left: calc( {{SIZE}}{{UNIT}} / 2 );',
					'{{WRAPPER}} .exad-testimonial-wrapper.exad-testimonial-align-right .exad-testimonial-content-wrapper-arrow::before'=> 'right: calc(( {{SIZE}}{{UNIT}} / 2) - 10px);'
				],
				'condition'   => [
					'exad_testimonial_carousel_image_box' => 'yes'
				]
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'      => 'exad_testimonial_carousel_image_box_border',
				'selector'  => '{{WRAPPER}} .exad-testimonial-thumb',
				'condition' => [
					'exad_testimonial_carousel_image_box' => 'yes'
				]
			]
		);

		$this->add_responsive_control(
			'exad_testimonial_carousel_image_box_radius',
			[
				'label'      => __( 'Border radius', 'exclusive-addons-elementor-pro' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'default'    => [
					'top'    => '50',
					'right'  => '50',
					'bottom' => '50',
					'left'   => '50',
					'unit'   => '%'
				],
				'selectors'  => [
					'{{WRAPPER}} .exad-testimonial-thumb'     => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .exad-testimonial-thumb img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'exad_testimonial_carousel_image_box_shadow',
				'selector' => '{{WRAPPER}} .exad-testimonial-thumb'
			]
		);

		$this->add_responsive_control(
			'exad_testimonial_carousel_image_box_margin_bottom',
			[
				'label'       => __( 'Bottom Spacing', 'exclusive-addons-elementor-pro' ),
				'type'        => Controls_Manager::SLIDER,
				'size_units'  => [ 'px' ],
				'range'       => [
					'px'      => [
						'min' => -500,
						'max' => 500
					],
				],
				'default'     => [
					'unit'    => 'px',
					'size'    => 0
				],
				'selectors'   => [
					'{{WRAPPER}} .exad-testimonial-thumb'=> 'margin-bottom: {{SIZE}}{{UNIT}};'
				],
				'condition'   => [
					'exad_testimonial_carousel_container_alignment' => 'exad-testimonial-align-bottom'
				]
			]
		);

		$this-> end_controls_section();

		/**
		 * Testimonial Carousel Description Style Section
		 */
		$this->start_controls_section(
			'exad_testimonial_carousel_description_style',
			[
				'label' => esc_html__( 'Testimonial', 'exclusive-addons-elementor-pro' ),
				'tab'   => Controls_Manager::TAB_STYLE
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'exad_testimonial_carousel_description_typography',
				'selector' => '{{WRAPPER}} .exad-testimonial-description'
			]
		);

		$this->add_control(
			'exad_testimonial_carousel_description_color',
			[
				'label'     => __( 'Text Color', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#222222',
				'selectors' => [
					'{{WRAPPER}} .exad-testimonial-description' => 'color: {{VALUE}};'
				]
			]
		);

		$this->add_control(
			'exad_testimonial_carousel_description_bg_color',
			[
				'label'     => __( 'Background Color', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .exad-testimonial-content-wrapper'               => 'background: {{VALUE}};',
					'{{WRAPPER}} .exad-testimonial-content-wrapper-arrow::before' => 'color: {{VALUE}};'
				]
			]
		);

		$this->add_responsive_control(
			'exad_testimonial_carousel_description_radius',
			[
				'label'      => __( 'Border Radius', 'exclusive-addons-elementor-pro' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'default'    => [
					'top'    => '0',
					'right'  => '0',
					'bottom' => '0',
					'left'   => '0'
				],
				'selectors'  => [
					'{{WRAPPER}} .exad-testimonial-content-wrapper' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
		);

		$this->add_responsive_control(
			'exad_testimonial_carousel_description_spacing_bottom',
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
					'size'    => 20
				],
				'selectors'   => [
					'{{WRAPPER}} .exad-testimonial-content-wrapper' => 'margin-bottom: {{SIZE}}{{UNIT}};'
				],
				'condition' => [
					'exad_testimonial_carousel_layout' => 'layout-1'
				]
			]
		);

		$this->add_responsive_control(
			'exad_testimonial_carousel_description_spacing_top',
			[
				'label'       => __( 'Top Spacing', 'exclusive-addons-elementor-pro' ),
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
					'size'    => 20
				],
				'selectors'   => [
					'{{WRAPPER}} .exad-testimonial-content-wrapper' => 'margin-top: {{SIZE}}{{UNIT}};'
				],
				'condition' => [
					'exad_testimonial_carousel_layout' => 'layout-2'
				]
			]
		);

		$this->add_responsive_control(
			'exad_testimonial_carousel_description_padding',
			[
				'label'      => __( 'Padding', 'exclusive-addons-elementor-pro' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'default'    => [
					'top'    => '0',
					'right'  => '0',
					'bottom' => '0',
					'left'   => '0'
				],
				'selectors'  => [
					'{{WRAPPER}} .exad-testimonial-content-wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'exad_testimonial_carousel_description_box_shadow',
				'selector' => '{{WRAPPER}} .exad-testimonial-content-wrapper'
			]
		);

		$this->add_control(
			'exad_testimonial_carousel_description_arrow_enable',
			[
				'label'        => __( 'Show Arrow', 'exclusive-addons-elementor-pro' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'ON', 'exclusive-addons-elementor-pro' ),
				'label_off'    => __( 'OFF', 'exclusive-addons-elementor-pro' ),
				'return_value' => 'yes',
				'default'      => 'no',
				'separator'    => 'before'
			]
		);

		$this-> end_controls_section();

		/**
		 * Testimonial Carousel Rating Style
		 */

		$this->start_controls_section(
			'exad_testimonial_carousel_rating_style',
			[
				'label'     => esc_html__( 'Rating', 'exclusive-addons-elementor-pro' ),
				'tab'       => Controls_Manager::TAB_STYLE
			]
		);

		$this->add_responsive_control(
			'exad_testimonial_carousel_rating_size',
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
					'{{WRAPPER}} .exad-testimonial-ratings li i' => 'font-size: {{SIZE}}{{UNIT}};'
				]
			]
		);

		$this->add_responsive_control(
			'exad_testimonial_carousel_rating_icon_margin',
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
					'{{WRAPPER}} .exad-testimonial-ratings li:not(:last-child) i' => 'margin-right: {{SIZE}}{{UNIT}};'
				]
			]
		);

		$this->add_responsive_control(
			'exad_testimonial_carousel_rating_margin',
			[
				'label'        => __( 'Margin', 'exclusive-addons-elementor-pro' ),
				'type'         => Controls_Manager::DIMENSIONS,
				'size_units'   => [ 'px', '%', 'em' ],
				'default'      => [
					'top'      => '20',
					'right'    => '0',
					'bottom'   => '0',
					'left'     => '0',
					'isLinked' => false
				],
				'selectors'    => [
					'{{WRAPPER}} .exad-testimonial-ratings' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
		);

		$this->start_controls_tabs( 'exad_testimonial_carousel_rating_tabs' );

			// normal state rating
			$this->start_controls_tab( 'exad_testimonial_carousel_rating_normal', [ 'label' => esc_html__( 'Normal', 'exclusive-addons-elementor-pro' ) ] );

				$this->add_control(
					'exad_testimonial_carousel_rating_normal_color',
					[
						'label'     => __( 'Color', 'exclusive-addons-elementor-pro' ),
						'type'      => Controls_Manager::COLOR,
						'default'   => '#222222',
						'selectors' => [
							'{{WRAPPER}} .exad-testimonial-ratings li i' => 'color: {{VALUE}};'
						]
					]
				);

			$this->end_controls_tab();

			// hover state rating
			$this->start_controls_tab( 'exad_testimonial_carousel_rating_active', [ 'label' => esc_html__( 'Active', 'exclusive-addons-elementor-pro' ) ] );

				$this->add_control(
					'exad_testimonial_carousel_rating_active_color',
					[
						'label'     => __( 'Color', 'exclusive-addons-elementor-pro' ),
						'type'      => Controls_Manager::COLOR,
						'default'   => '#ff5b84',
						'selectors' => [
							'{{WRAPPER}} .exad-testimonial-ratings li.exad-testimonial-ratings-active i' => 'color: {{VALUE}};'
						]
					]
				);

			$this->end_controls_tab();

		$this->end_controls_tabs();

		$this-> end_controls_section();

		/**
		 * Testimonial Riviewer Style Section
		 */
		$this->start_controls_section(
			'exad_testimonial_carousel_reviewer_style',
			[
				'label' => esc_html__( 'Reviewer', 'exclusive-addons-elementor-pro' ),
				'tab'   => Controls_Manager::TAB_STYLE
			]
		);

		$this->add_responsive_control(
			'exad_testimonial_carousel_reviewer_padding',
			[
				'label'      => __( 'Padding', 'exclusive-addons-elementor-pro' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'default'    => [
					'top'    => '0',
					'right'  => '0',
					'bottom' => '0',
					'left'   => '0'
				],
				'selectors'  => [
					'{{WRAPPER}} .exad-testimonial-reviewer-wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
		);

		$this->add_responsive_control(
			'exad_testimonial_carousel_reviewer_spacing',
			[
				'label'       => __( 'Spacing', 'exclusive-addons-elementor-pro' ),
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
					'size'    => 20
				],
				'selectors'   => [
					'{{WRAPPER}} .exad-testimonial-wrapper.exad-testimonial-align-left .exad-testimonial-reviewer-wrapper .exad-testimonial-reviewer' => 'padding-left: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .exad-testimonial-wrapper.exad-testimonial-align-right .exad-testimonial-reviewer-wrapper .exad-testimonial-reviewer' => 'padding-right: {{SIZE}}{{UNIT}};'
				],
				'condition'   => [
					'exad_testimonial_carousel_container_alignment' => ['exad-testimonial-align-left', 'exad-testimonial-align-right']
				]
			]
		);

		// Testimonial Title Style Section
		$this->add_control(
			'exad_testimonial_carousel_title_style',
			[
				'label'     => __( 'Reviewer Title', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before'
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'             => 'exad_testimonial_carousel_title_typography',
				'selector'         => '{{WRAPPER}} .exad-testimonial-name',
				'fields_options'   => [
					'font_size'    => [
		                'default'  => [
		                    'unit' => 'px',
		                    'size' => 22
		                ]
		            ],
		            'font_weight'  => [
		                'default'  => '600'
		            ]
	            ]
			]
		);

		$this->add_control(
			'exad_testimonial_carousel_title_color',
			[
				'label'     => __( 'Color', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#000000',
				'selectors' => [
					'{{WRAPPER}} .exad-testimonial-name' => 'color: {{VALUE}};'
				]
			]
		);

		$this->add_responsive_control(
			'exad_testimonial_carousel_title_margin',
			[
				'label'      => __( 'Margin', 'exclusive-addons-elementor-pro' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'default'    => [
					'top'    => '0',
					'right'  => '0',
					'bottom' => '0',
					'left'   => '0'
				],
				'selectors'  => [
					'{{WRAPPER}} .exad-testimonial-name' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
		);

		// Testimonial Designation Style Section
		$this->add_control(
			'exad_testimonial_carousel_designation_style',
			[
				'label'     => __( 'Reviewer Designation', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before'
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'             => 'exad_testimonial_carousel_designation_typography',
				'selector'         => '{{WRAPPER}} .exad-testimonial-designation',
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
			'exad_testimonial_carousel_designation_color',
			[
				'label'     => __( 'Color', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#333333',
				'selectors' => [
					'{{WRAPPER}} .exad-testimonial-designation' => 'color: {{VALUE}};'
				]
			]
		);

		$this->add_responsive_control(
			'exad_testimonial_carousel_designation_margin',
			[
				'label'      => __( 'Margin', 'exclusive-addons-elementor-pro' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'default'    => [
					'top'    => '0',
					'right'  => '0',
					'bottom' => '0',
					'left'   => '0'
				],
				'selectors'  => [
					'{{WRAPPER}} .exad-testimonial-designation' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
		);

		$this-> end_controls_section();

		/**
		 * Arrows Style
		 */

		$this->start_controls_section(
            'exad_testimonial_carousel_nav_arrow',
            [
                'label'     => esc_html__( 'Arrows', 'exclusive-addons-elementor-pro' ),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'exad_testimonial_carousel_nav' => ['arrows', 'both'],
                ],
            ]
        );

        $this->add_responsive_control(
            'exad_testimonial_carousel_nav_arrow_box_size',
            [
                'label'      => __( 'Box Size', 'exclusive-addons-elementor-pro' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range'      => [
                    'px' => [
                        'min' => 0,
                        'max' => 200,
                    ],
                ],
                'default'    => [
                    'unit' => 'px',
                    'size' => 50,
                ],
                'selectors'  => [
                    '{{WRAPPER}} .exad-testimonial-carousel-wrapper .exad-carousel-nav-prev' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .exad-testimonial-carousel-wrapper .exad-carousel-nav-next' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'exad_testimonial_carousel_nav_arrow_icon_size',
            [
                'label'      => __( 'Icon Size', 'exclusive-addons-elementor-pro' ),
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
                    '{{WRAPPER}} .exad-testimonial-carousel-wrapper .exad-carousel-nav-prev i' => 'font-size: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .exad-testimonial-carousel-wrapper .exad-carousel-nav-next i' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        
        $this->add_control(
            'exad_testimonial_carousel_prev_arrow_position',
            [
                'label'        => __( 'Previous Arrow Position', 'exclusive-addons-elementor-pro' ),
                'type'         => Controls_Manager::POPOVER_TOGGLE,
                'label_off'    => __( 'Default', 'exclusive-addons-elementor-pro' ),
                'label_on'     => __( 'Custom', 'exclusive-addons-elementor-pro' ),
                'return_value' => 'yes',
                'default'      => 'yes',
            ]
        );
        
        $this->start_popover();

            $this->add_responsive_control(
                'exad_testimonial_carousel_prev_arrow_position_x_offset',
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
                        'size' => 30,
                    ],
                    'selectors'  => [
                        '{{WRAPPER}} .exad-testimonial-carousel-wrapper .exad-carousel-nav-prev' => 'left: {{SIZE}}{{UNIT}};',
                    ],
                ]
            );

            $this->add_responsive_control(
                'exad_testimonial_carousel_prev_arrow_position_y_offset',
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
                        'size' => 50,
                    ],
                    'selectors'  => [
                        '{{WRAPPER}} .exad-testimonial-carousel-wrapper .exad-carousel-nav-prev' => 'top: {{SIZE}}{{UNIT}};',
                    ],
                ]
            );

        $this->end_popover();

        $this->add_control(
            'exad_testimonial_carousel_next_arrow_position',
            [
                'label'        => __( 'Next Arrow Position', 'exclusive-addons-elementor-pro' ),
                'type'         => Controls_Manager::POPOVER_TOGGLE,
                'label_off'    => __( 'Default', 'exclusive-addons-elementor-pro' ),
                'label_on'     => __( 'Custom', 'exclusive-addons-elementor-pro' ),
                'return_value' => 'yes',
                'default'      => 'yes',
            ]
        );
        
        $this->start_popover();

            $this->add_responsive_control(
                'exad_testimonial_carousel_next_arrow_position_x_offset',
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
                        'size' => 30,
                    ],
                    'selectors'  => [
                        '{{WRAPPER}} .exad-testimonial-carousel-wrapper .exad-carousel-nav-next' => 'right: {{SIZE}}{{UNIT}};',
                    ],
                ]
            );

            $this->add_responsive_control(
                'exad_testimonial_carousel_next_arrow_position_y_offset',
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
                        'size' => 50,
                    ],
                    'selectors'  => [
                        '{{WRAPPER}} .exad-testimonial-carousel-wrapper .exad-carousel-nav-next' => 'top: {{SIZE}}{{UNIT}};',
                    ],
                ]
            );

        $this->end_popover();

        $this->add_responsive_control(
            'exad_testimonial_carousel_nav_arrow_radius',
            [
                'label'      => __( 'Border radius', 'exclusive-addons-elementor-pro' ),
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
                    '{{WRAPPER}} .exad-testimonial-carousel-wrapper .exad-carousel-nav-prev' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .exad-testimonial-carousel-wrapper .exad-carousel-nav-next' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs( 'exad_testimonial_carousel_nav_arrow_tabs' );

			// normal state rating
			$this->start_controls_tab( 'exad_testimonial_carousel_nav_arrow_normal', [ 'label' => esc_html__( 'Normal', 'exclusive-addons-elementor-pro' ) ] );

                $this->add_control(
                    'exad_testimonial_carousel_arrow_normal_background',
                    [
                        'label'     => __( 'Background Color', 'exclusive-addons-elementor-pro' ),
                        'type'      => Controls_Manager::COLOR,
                        'default'   => '#ffffff',
                        'selectors' => [
                            '{{WRAPPER}} .exad-testimonial-carousel-wrapper .exad-carousel-nav-prev' => 'background: {{VALUE}}',
                            '{{WRAPPER}} .exad-testimonial-carousel-wrapper .exad-carousel-nav-next' => 'background: {{VALUE}}',
                        ],
                    ]
                );

                $this->add_control(
                    'exad_testimonial_carousel_arrow_normal_color',
                    [
                        'label'     => __( 'Icon Color', 'exclusive-addons-elementor-pro' ),
                        'type'      => Controls_Manager::COLOR,
                        'default'   => $exad_primary_color,
                        'selectors' => [
                            '{{WRAPPER}} .exad-testimonial-carousel-wrapper .exad-carousel-nav-prev i' => 'color: {{VALUE}};',
                            '{{WRAPPER}} .exad-testimonial-carousel-wrapper .exad-carousel-nav-next i' => 'color: {{VALUE}};',
                        ],
                    ]
                );

                $this->add_group_control(
                    Group_Control_Border::get_type(),
                    [
                        'name'     => 'exad_testimonial_carousel_arrow_normal_border',
                        'label'    => __( 'Border', 'exclusive-addons-elementor-pro' ),
                        'selector' => '{{WRAPPER}} .exad-testimonial-carousel-wrapper .exad-carousel-nav-prev, {{WRAPPER}} .exad-testimonial-carousel-wrapper .exad-carousel-nav-next',
                    ]
                );

                $this->add_group_control(
                    Group_Control_Box_Shadow::get_type(),
                    [
                        'name'     => 'exad_testimonial_carousel_arrow_normal_shadow',
                        'label'    => __( 'Box Shadow', 'exclusive-addons-elementor-pro' ),
                        'selector' => '{{WRAPPER}} .exad-testimonial-carousel-wrapper .exad-carousel-nav-prev, {{WRAPPER}} .exad-testimonial-carousel-wrapper .exad-carousel-nav-next',
                    ]
                );

			$this->end_controls_tab();

			// hover state rating
			$this->start_controls_tab( 'exad_testimonial_carousel_nav_arrow_hover', [ 'label' => esc_html__( 'Hover', 'exclusive-addons-elementor-pro' ) ] );

                $this->add_control(
                    'exad_testimonial_carousel_arrow_hover_background',
                    [
                        'label'     => __( 'Background Color', 'exclusive-addons-elementor-pro' ),
                        'type'      => Controls_Manager::COLOR,
                        'default'   => $exad_primary_color,
                        'selectors' => [
                            '{{WRAPPER}} .exad-testimonial-carousel-wrapper .exad-carousel-nav-prev:hover' => 'background: {{VALUE}}',
                            '{{WRAPPER}} .exad-testimonial-carousel-wrapper .exad-carousel-nav-next:hover' => 'background: {{VALUE}}',
                        ],
                    ]
                );

                $this->add_control(
                    'exad_testimonial_carousel_arrow_hover_color',
                    [
                        'label'     => __( 'Icon Color', 'exclusive-addons-elementor-pro' ),
                        'type'      => Controls_Manager::COLOR,
                        'default'   => '#ffffff',
                        'selectors' => [
                            '{{WRAPPER}} .exad-testimonial-carousel-wrapper .exad-carousel-nav-prev:hover i' => 'color: {{VALUE}}',
                            '{{WRAPPER}} .exad-testimonial-carousel-wrapper .exad-carousel-nav-next:hover i' => 'color: {{VALUE}}',
                        ],
                    ]
                );

                $this->add_group_control(
                    Group_Control_Border::get_type(),
                    [
                        'name'     => 'exad_testimonial_carousel_arrow_hover_border',
                        'label'    => __( 'Border', 'exclusive-addons-elementor-pro' ),
                        'selector' => '{{WRAPPER}} .exad-testimonial-carousel-wrapper .exad-carousel-nav-prev:hover, {{WRAPPER}} .exad-testimonial-carousel-wrapper .exad-carousel-nav-next:hover',
                    ]
                );

                $this->add_group_control(
                    Group_Control_Box_Shadow::get_type(),
                    [
                        'name'     => 'exad_testimonial_carousel_arrow_hover_shadow',
                        'label'    => __( 'Box Shadow', 'exclusive-addons-elementor-pro' ),
                        'selector' => '{{WRAPPER}} .exad-testimonial-carousel-wrapper .exad-carousel-nav-prev:hover, {{WRAPPER}} .exad-testimonial-carousel-wrapper .exad-carousel-nav-next:hover',
                    ]
                );

			$this->end_controls_tab();

        $this->end_controls_tabs();

		$this->end_controls_section();

		/**
		 * Dots Style
		 */
		
		$this->start_controls_section(
            'exad_testimonial_carousel_nav_dot',
            [
                'label'     => esc_html__( 'Dots', 'exclusive-addons-elementor-pro' ),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'exad_testimonial_carousel_nav' => ['nav-dots', 'both'],
                ],
            ]
        );

        $this->add_control(
            'exad_testimonial_carousel_nav_dot_alignment',
            [
                'label'   => __( 'Alignment', 'exclusive-addons-elementor-pro' ),
                'type'    => Controls_Manager::CHOOSE,
                'options' => [
                    'exad-testimonial-carousel-dots-left'   => [
                        'title' => __( 'Left', 'exclusive-addons-elementor-pro' ),
                        'icon'  => 'fa fa-align-left',
                    ],
                    'exad-testimonial-carousel-dots-center' => [
                        'title' => __( 'Center', 'exclusive-addons-elementor-pro' ),
                        'icon'  => 'fa fa-align-center',
                    ],
                    'exad-testimonial-carousel-dots-right'  => [
                        'title' => __( 'Right', 'exclusive-addons-elementor-pro' ),
                        'icon'  => 'fa fa-align-right',
                    ],
                ],
                'default' => 'exad-testimonial-carousel-dots-center',
            ]
        );

        $this->add_responsive_control(
            'exad_testimonial_carousel_dots_top_spacing',
            [
                'label'      => __( 'Top Spacing', 'exclusive-addons-elementor-pro' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range'      => [
                    'px' => [
                        'min' => -200,
                        'max' => 200,
                    ],
                ],
                'default'    => [
                    'unit' => 'px',
                    'size' => 0,
                ],
                'selectors'  => [
                    '{{WRAPPER}} .exad-testimonial-carousel-wrapper .slick-dots' => 'margin-top: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'exad_testimonial_carousel_nav_dot_radius',
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
                    '{{WRAPPER}} .exad-testimonial-carousel-wrapper .slick-dots li button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs( 'exad_testimonial_carousel_nav_dots_tabs' );

			// normal state rating
            $this->start_controls_tab( 'exad_testimonial_carousel_nav_dots_normal', [ 'label' => esc_html__( 'Normal', 'exclusive-addons-elementor-pro' ) ] );
            
                $this->add_responsive_control(
                    'exad_testimonial_carousel_dots_normal_width',
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
                            'size' => 10,
                        ],
                        'selectors'  => [
                            '{{WRAPPER}} .exad-testimonial-carousel-wrapper .slick-dots li button' => 'width: {{SIZE}}{{UNIT}};',
                        ],
                    ]
                );

                $this->add_responsive_control(
                    'exad_testimonial_carousel_dots_normal_height',
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
                            'size' => 10,
                        ],
                        'selectors'  => [
                            '{{WRAPPER}} .exad-testimonial-carousel-wrapper .slick-dots li button' => 'height: {{SIZE}}{{UNIT}};',
                        ],
                    ]
                );

                $this->add_control(
                    'exad_testimonial_carousel_dots_normal_background',
                    [
                        'label'     => __( 'Background Color', 'exclusive-addons-elementor-pro' ),
                        'type'      => Controls_Manager::COLOR,
                        'default'   => '#e5e5e5',
                        'selectors' => [
                            '{{WRAPPER}} .exad-testimonial-carousel-wrapper .slick-dots li button' => 'background: {{VALUE}};',
                        ],
                    ]
                );

                $this->add_group_control(
                    Group_Control_Border::get_type(),
                    [
                        'name'     => 'exad_testimonial_carousel_dots_normal_border',
                        'label'    => __( 'Border', 'exclusive-addons-elementor-pro' ),
                        'selector' => '{{WRAPPER}} .exad-testimonial-carousel-wrapper .slick-dots li button',
                    ]
                );

			$this->end_controls_tab();

			// hover state rating
            $this->start_controls_tab( 'exad_testimonial_carousel_nav_dots_hover', [ 'label' => esc_html__( 'Hover/active', 'exclusive-addons-elementor-pro' ) ] );
            
                $this->add_responsive_control(
                    'exad_testimonial_carousel_dots_active_width',
                    [
                        'label'      => __( 'Width', 'exclusive-addons-elementor-pro' ),
                        'type'       => Controls_Manager::SLIDER,
                        'size_units' => ['px', '%'],
                        'range'      => [
                            'px' => [
                                'min' => 0,
                                'max' => 100,
                            ],
                        ],
                        'default'    => [
                            'unit' => 'px',
                            'size' => 10,
                        ],
                        'selectors'  => [
                            '{{WRAPPER}} .exad-testimonial-carousel-wrapper .slick-dots li.slick-active button' => 'width: {{SIZE}}{{UNIT}};',
                        ],
                    ]
                );

                $this->add_responsive_control(
                    'exad_testimonial_carousel_dots_active_height',
                    [
                        'label'      => __( 'Height', 'exclusive-addons-elementor-pro' ),
                        'type'       => Controls_Manager::SLIDER,
                        'size_units' => ['px', '%'],
                        'range'      => [
                            'px' => [
                                'min' => 0,
                                'max' => 100,
                            ],
                        ],
                        'default'    => [
                            'unit' => 'px',
                            'size' => 10,
                        ],
                        'selectors'  => [
                            '{{WRAPPER}} .exad-testimonial-carousel-wrapper .slick-dots li.slick-active button' => 'height: {{SIZE}}{{UNIT}};',
                        ],
                    ]
                );

                $this->add_control(
                    'exad_testimonial_carousel_dots_active_background',
                    [
                        'label'     => __( 'Background Color', 'exclusive-addons-elementor-pro' ),
                        'type'      => Controls_Manager::COLOR,
                        'default'   => $exad_primary_color,
                        'selectors' => [
                            '{{WRAPPER}} .exad-testimonial-carousel-wrapper .slick-dots li.slick-active button' => 'background: {{VALUE}};',
                            '{{WRAPPER}} .exad-testimonial-carousel-wrapper .slick-dots li button:hover'        => 'background: {{VALUE}};',
                        ],
                    ]
                );

                $this->add_group_control(
                    Group_Control_Border::get_type(),
                    [
                        'name'     => 'exad_testimonial_carousel_dots_active_border',
                        'label'    => __( 'Border', 'exclusive-addons-elementor-pro' ),
                        'selector' => '{{WRAPPER}} .exad-testimonial-carousel-wrapper .slick-dots li.slick-active button, {{WRAPPER}} .exad-testimonial-carousel-wrapper .slick-dots li button:hover',
                    ]
                );

			$this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();

		/**
		 * Testimonial Carousel other style Style Section
		 */
		$this->start_controls_section(
			'exad_testimonial_carousel_other_style',
			[
				'label' => esc_html__( 'Advanced Option', 'exclusive-addons-elementor-pro' ),
				'tab'   => Controls_Manager::TAB_STYLE
			]
		);

		$this->start_controls_tabs( 'exad_testimonial_carousel_other_tabs' );

			// normal state rating
			$this->start_controls_tab( 'exad_testimonial_carousel_other_style_inactive', [ 'label' => esc_html__( 'Inactive', 'exclusive-addons-elementor-pro' ) ] );

				$this->add_control(
					'exad_testimonial_carousel_slide_opacity_inactive',
					[
						'label'     => __( 'Inactive Item Opacity', 'exclusive-addons-elementor-pro' ),
						'type'      => Controls_Manager::NUMBER,
						'min'       => 0,
						'max'       => 1,
						'selectors' => [
							'{{WRAPPER}} .exad-testimonial-wrapper.slick-slide' => 'opacity: {{VALUE}};'
						]
					]
				);

				$this->add_control(
					'exad_testimonial_carousel_slide_item_scale_inactive',
					[
						'label'     => __( 'Scale', 'exclusive-addons-elementor-pro' ),
						'type'      => Controls_Manager::NUMBER,
						'min'       => 0,
						'max'       => 5,
						'selectors' => [
							'{{WRAPPER}} .exad-testimonial-wrapper.slick-slide' => 'transform: scale( {{VALUE}} );'
						]
					]
				);

			$this->end_controls_tab();

			// hover state rating
			$this->start_controls_tab( 'exad_testimonial_carousel_other_style_active', [ 'label' => esc_html__( 'Active', 'exclusive-addons-elementor-pro' ) ] );

				$this->add_control(
					'exad_testimonial_carousel_slide_opacity_active',
					[
						'label'     => __( 'Active Item Opacity', 'exclusive-addons-elementor-pro' ),
						'type'      => Controls_Manager::NUMBER,
						'min'       => 0,
						'max'       => 1,
						'default'   => '1',
						'selectors' => [
							'{{WRAPPER}} .exad-testimonial-wrapper.slick-slide.slick-current.slick-active' => 'opacity: {{VALUE}};'
						]
					]
				);

				$this->add_control(
					'exad_testimonial_carousel_slide_item_scale_active',
					[
						'label'     => __( 'Scale', 'exclusive-addons-elementor-pro' ),
						'type'      => Controls_Manager::NUMBER,
						'min'       => 0,
						'max'       => 5,
						'default'   => '1',
						'selectors' => [
							'{{WRAPPER}} .exad-testimonial-wrapper.slick-slide.slick-current.slick-active' => 'transform: scale( {{VALUE}} );'
						]
					]
				);

			$this->end_controls_tab();

		$this->end_controls_tabs();

		$this-> end_controls_section();

	}

	private function render_testimonial_carousel_image( $image_url ) {
		$output = '';
		if ( ! empty( $image_url ) ) :
			$output .= '<div class="exad-testimonial-thumb">';
				$output .= $image_url;
			$output .= '</div>';
		endif;
		return $output;
	}

	protected function render() {
		$settings  = $this->get_settings_for_display();
		$direction = is_rtl() ? 'true' : 'false';
    
        $this->add_render_attribute( 
			'exad-testimonial-carousel', 
			[ 
				'class'               => [ 'exad-testimonial-carousel-wrapper exad-testimonial-carousel exad-carousel-item', esc_attr( $settings['exad_testimonial_carousel_nav_dot_alignment'] ) ],
				'data-slidestoscroll' => intval( esc_attr( $settings['exad_testimonial_slides_to_scroll'] ) ),
				'data-slidestoshow'   => intval( esc_attr( $settings['exad_testimonial_per_view'] ) ),
				'data-slidestoshow-tablet'   => intval( esc_attr( isset( $settings['exad_testimonial_per_view_tablet'] ) ) ? (int)$settings['exad_testimonial_per_view_tablet'] : 2  ),
				'data-slidestoshow-mobile'   => intval( esc_attr( isset( $settings['exad_testimonial_per_view_mobile'] ) ) ? (int)$settings['exad_testimonial_per_view_mobile'] : 1),
				'data-carousel-nav'   => esc_attr( $settings['exad_testimonial_carousel_nav'] ),
				'data-speed'          => esc_attr( $settings['exad_testimonial_transition_duration'] ),
				'data-direction'      => esc_attr( $direction )
			]
		);

		if ( 'yes' === $settings['exad_testimonial_autoplay'] ) {
            $this->add_render_attribute( 'exad-testimonial-carousel', 'data-autoplay', 'true' );
            $this->add_render_attribute( 'exad-testimonial-carousel', 'data-autoplayspeed', intval( esc_attr( $settings['exad_testimonial_autoplay_speed'] ) ) );
		}

		if ( 'yes' === $settings['exad_testimonial_pause'] ) {
            $this->add_render_attribute( 'exad-testimonial-carousel', 'data-pauseonhover', 'true' );
        }

		if ( 'yes' === $settings['exad_testimonial_loop'] ) {
            $this->add_render_attribute( 'exad-testimonial-carousel', 'data-loop', 'true' );
		}

		$this->add_render_attribute( 'exad_testimonial_content_wrapper', 'class', 'exad-testimonial-content-wrapper' );

		if ( 'yes' === $settings['exad_testimonial_carousel_description_arrow_enable'] ) {
			$this->add_render_attribute( 'exad_testimonial_content_wrapper', 'class', 'exad-testimonial-content-wrapper-arrow' );
		}
		

		if ( is_array( $settings['testimonial_carousel_repeater'] ) ) : 
		?>
			<div <?php echo $this->get_render_attribute_string( 'exad-testimonial-carousel' );?> >
				<?php
				$testimonial_carousel_image_url = '';
				foreach ( $settings['testimonial_carousel_repeater'] as $testimonial ) : 
					if ( $testimonial['exad_testimonial_carousel_image']['url'] || $testimonial['exad_testimonial_carousel_image']['id'] ) :
						$testimonial_carousel_image_url = Group_Control_Image_Size::get_attachment_image_html( $testimonial, 'thumbnail', 'exad_testimonial_carousel_image' );
					endif;
					?>
					<div class="exad-testimonial-wrapper <?php echo esc_attr( $settings['exad_testimonial_carousel_container_alignment'] );?> elementor-repeater-item-<?php echo esc_attr( $testimonial['_id'] ); ?>">
						<div class="exad-testimonial-wrapper-inner">
							<?php if( 'layout-1' === $settings['exad_testimonial_carousel_layout'] ){ ?>
								<div <?php echo $this->get_render_attribute_string( 'exad_testimonial_content_wrapper' );?> >
									<?php if ( ! empty( $testimonial['exad_testimonial_carousel_description'] ) ) : ?>
										<p class="exad-testimonial-description" ><?php echo wp_kses_post( $testimonial['exad_testimonial_carousel_description'] );?></p>
										<?php if ( 'yes' === $testimonial['exad_testimonial_carousel_enable_rating'] ) : ?>
											<ul class="exad-testimonial-ratings">
												<?php // $this->render_testimonial_carousel_rating( $testimonial['exad_testimonial_carousel_rating_number'] );
												$ratings = '';
												$ratings = $testimonial['exad_testimonial_carousel_rating_number'];
												for( $i = 1; $i <= 5; $i++ ) {
													if( $ratings >= $i ) {
														$rating_active_class = '<li class="exad-testimonial-ratings-active"><i class="'.$testimonial['exad_testimonial_carousel_rating_icon']['value'].'"></i></li>';
													} else {
														$rating_active_class = '<li><i class="'.$testimonial['exad_testimonial_carousel_rating_icon']['value'].'"></i></li>';
													}
													echo $rating_active_class;
												}?>
											</ul>
										<?php endif;
									endif;?>						
								</div>				
							<?php } ;?>

							<div class="exad-testimonial-reviewer-wrapper">
								<?php if( 'exad-testimonial-align-bottom' !== $settings['exad_testimonial_carousel_container_alignment'] ) : 
									echo $this->render_testimonial_carousel_image( $testimonial_carousel_image_url );
								endif;?>

								<div class="exad-testimonial-reviewer">
									<?php if ( ! empty( $testimonial['exad_testimonial_carousel_name'] ) ) : ?>
										<<?php echo Utils::validate_html_tag( $settings['exad_testimonial_carousel_name_tag'] ); ?> class="exad-testimonial-name">
											<?php echo esc_html( $testimonial['exad_testimonial_carousel_name'] );?>
										</<?php echo Utils::validate_html_tag( $settings['exad_testimonial_carousel_name_tag'] ); ?>>
									<?php endif;
									if ( ! empty( $testimonial['exad_testimonial_carousel_designation'] ) ) : ?>
										<span class="exad-testimonial-designation"><?php echo esc_html( $testimonial['exad_testimonial_carousel_designation'] );?></span>
									<?php endif;?>
								</div>

								<?php if( 'exad-testimonial-align-bottom' === $settings['exad_testimonial_carousel_container_alignment'] ) :
									echo $this->render_testimonial_carousel_image( $testimonial_carousel_image_url );
								endif;?>
							</div>

							<?php if( 'layout-2' === $settings['exad_testimonial_carousel_layout'] ){ ?>
								<div <?php echo $this->get_render_attribute_string( 'exad_testimonial_content_wrapper' );?>>
									<?php if ( ! empty( $testimonial['exad_testimonial_carousel_description'] ) ) : ?>
										<p class="exad-testimonial-description" ><?php echo wp_kses_post( $testimonial['exad_testimonial_carousel_description'] );?></p>
										<?php if ( 'yes' === $testimonial['exad_testimonial_carousel_enable_rating'] ) : ?>
											<ul class="exad-testimonial-ratings">
												<?php // $this->render_testimonial_carousel_rating( $testimonial['exad_testimonial_carousel_rating_number'] );
												$ratings = '';
												$ratings = $testimonial['exad_testimonial_carousel_rating_number'];
												for( $i = 1; $i <= 5; $i++ ) {
													if( $ratings >= $i ) {
														$rating_active_class = '<li class="exad-testimonial-ratings-active"><i class="'.$testimonial['exad_testimonial_carousel_rating_icon']['value'].'"></i></li>';
													} else {
														$rating_active_class = '<li><i class="'.$testimonial['exad_testimonial_carousel_rating_icon']['value'].'"></i></li>';
													}
													echo $rating_active_class;
												}?>
											</ul>
										<?php endif;
									endif;?>					
								</div>				
							<?php } ?>

						</div>
					</div>

				<?php endforeach;?>
			</div>
		<?php	
		endif;
	}

	/**
     * Render testimonial carousel widget output in the editor.
     *
     * Written as a Backbone JavaScript template and used to generate the live preview.
     *
     * @since 1.0.0
     * @access protected
     */
    protected function content_template() {
    	?>
    	<#
	    	var direction = elementorCommon.config.isRTL ? 'true' : 'false';

	        view.addRenderAttribute( 
	            'exad-testimonial-carousel', 
	            {
	                'class' : [ 'exad-testimonial-carousel-wrapper exad-testimonial-carousel exad-carousel-item', settings.exad_testimonial_carousel_nav_dot_alignment ],
	                'data-slidestoshow' : settings.exad_testimonial_per_view,
	                'data-carousel-nav' : settings.exad_testimonial_carousel_nav,
	                'data-slidestoscroll' : settings.exad_testimonial_slides_to_scroll,
	                'data-speed': settings.exad_testimonial_transition_duration,
	                'data-direction': direction
	            }
	        );

	        if ( 'yes' === settings.exad_testimonial_autoplay ) {
	            view.addRenderAttribute( 'exad-testimonial-carousel', 'data-autoplay', 'true' );
	            view.addRenderAttribute( 'exad-testimonial-carousel', 'data-autoplayspeed', settings.exad_testimonial_autoplay_speed );
	        }
	        
	        if ( 'yes' === settings.exad_testimonial_pause ) {
	            view.addRenderAttribute( 'exad-testimonial-carousel', 'data-pauseonhover', 'true' );
	        }

	        if ( 'yes' === settings.exad_testimonial_loop ) {
	            view.addRenderAttribute( 'exad-testimonial-carousel', 'data-loop', 'true' );
	        }

	        view.addRenderAttribute( 'exad_testimonial_content_wrapper', 'class', 'exad-testimonial-content-wrapper' );

	        if ( 'yes' === settings.exad_testimonial_carousel_description_arrow_enable ) {
	            view.addRenderAttribute( 'exad_testimonial_content_wrapper', 'class', 'exad-testimonial-content-wrapper-arrow' );
	        }

			var TestimonialCarouselNameHTMLTag = elementor.helpers.validateHTMLTag( settings.exad_testimonial_carousel_name_tag );
    	#>
    	<# if ( settings.testimonial_carousel_repeater.length ) { #>
    		<div {{{ view.getRenderAttributeString( 'exad-testimonial-carousel' ) }}}>
    			<# _.each( settings.testimonial_carousel_repeater, function( testimonialItem, index ) { 
					var image_url = '';
					if ( testimonialItem.exad_testimonial_carousel_image.url ) {
                        var image = {
                            id: testimonialItem.exad_testimonial_carousel_image.id,
                            url: testimonialItem.exad_testimonial_carousel_image.url,
                            size: testimonialItem.thumbnail_size,
                            dimension: testimonialItem.thumbnail_custom_dimension,
                            model: view.getEditModel()
                        };

                        image_url = elementor.imagesManager.getImageUrl( image );
                    } 
                #>
                <div class="exad-testimonial-wrapper {{{ settings.exad_testimonial_carousel_container_alignment }}} elementor-repeater-item-{{ testimonialItem. _id }}">
                	<div class="exad-testimonial-wrapper-inner">
						<# if( 'layout-1' === settings.exad_testimonial_carousel_layout ){ #>
							<div {{{ view.getRenderAttributeString( 'exad_testimonial_content_wrapper' ) }}}>

								<# if ( '' !== testimonialItem.exad_testimonial_carousel_description ) { #>
									<p class="exad-testimonial-description">
										{{{ testimonialItem.exad_testimonial_carousel_description }}}
									</p>
									<# if ( 'yes' === testimonialItem.exad_testimonial_carousel_enable_rating ) { #>
										<ul class="exad-testimonial-ratings">
											<#
												var $ratings             = testimonialItem.exad_testimonial_carousel_rating_number;
												var $rating_active_class = '';
												for( var $i = 1; $i <= 5; $i++ ) {
													if( $ratings >= $i ) { #>
													<li class="exad-testimonial-ratings-active"><i class="{{ testimonialItem.exad_testimonial_carousel_rating_icon.value }}"></i></li>
													<# } else { #>
													<li><i class="{{ testimonialItem.exad_testimonial_carousel_rating_icon.value }}"></i></li>
													<# }
												}
											#>
										</ul>
									<# } #>
								<# } #>
							</div>
						<# } #>
                		<div class="exad-testimonial-reviewer-wrapper">
                			<# if ( 'exad-testimonial-align-bottom' !== settings.exad_testimonial_carousel_container_alignment ) { #>
	                			<# if ( image_url ) { #>
                                    <div class="exad-testimonial-thumb">
                                        <img src="{{ image_url }}" alt="{{ testimonialItem.exad_testimonial_carousel_name }}">
                                    </div>
	                            <# } #>
                			<# } #>
                			<div class="exad-testimonial-reviewer">
                				<# if ( '' !== testimonialItem.exad_testimonial_carousel_name ) { #>
                					<{{{ TestimonialCarouselNameHTMLTag }}} class="exad-testimonial-name">
                						{{{ testimonialItem.exad_testimonial_carousel_name }}}
                					</{{{ TestimonialCarouselNameHTMLTag }}}>
                				<# } #>
                				<# if ( '' !== testimonialItem.exad_testimonial_carousel_designation ) { #>
                					<span class="exad-testimonial-designation">
                						{{{ testimonialItem.exad_testimonial_carousel_designation }}}
                					</span>
                				<# } #>
                			</div>
                			<# if ( 'exad-testimonial-align-bottom' === settings.exad_testimonial_carousel_container_alignment ) { #>
	                			<# if ( image_url ) { #>
                                    <div class="exad-testimonial-thumb">
                                        <img src="{{ image_url }}" alt="{{ testimonialItem.exad_testimonial_carousel_name }}">
                                    </div>
	                            <# } #>
                			<# } #>
                		</div>

						<# if( 'layout-2' === settings.exad_testimonial_carousel_layout ){ #>
							<div {{{ view.getRenderAttributeString( 'exad_testimonial_content_wrapper' ) }}}>

								<# if ( '' !== testimonialItem.exad_testimonial_carousel_description ) { #>
									<p class="exad-testimonial-description">
										{{{ testimonialItem.exad_testimonial_carousel_description }}}
									</p>
									<# if ( 'yes' === testimonialItem.exad_testimonial_carousel_enable_rating ) { #>
										<ul class="exad-testimonial-ratings">
											<#
												var $ratings             = testimonialItem.exad_testimonial_carousel_rating_number;
												var $rating_active_class = '';
												for( var $i = 1; $i <= 5; $i++ ) {
													if( $ratings >= $i ) { #>
													<li class="exad-testimonial-ratings-active"><i class="{{ testimonialItem.exad_testimonial_carousel_rating_icon.value }}"></i></li>
													<# } else { #>
													<li><i class="{{ testimonialItem.exad_testimonial_carousel_rating_icon.value }}"></i></li>
													<# }
												}
											#>
										</ul>
									<# } #>
								<# } #>
							</div>
						<# } #>

                	</div>
                </div>
                <# } ); #>
    		</div>
    	<# } #>
    	<?php
	}
}