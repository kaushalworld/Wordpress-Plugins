<?php

namespace ExclusiveAddons\Elementor\Extensions;

use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Utils;

class Gradient_Animation {

    public static function init() {
		add_action( 'elementor/frontend/section/before_render', array( __CLASS__, 'before_render' ) );
        add_action( 'elementor/element/section/section_layout/after_section_end', array( __CLASS__,'register_controls' ),10 );
		add_action( 'elementor/frontend/section/after_render', array( __CLASS__, 'after_render' ) );
	}

    public static function register_controls( $section ) {

        $section->start_controls_section(
            'exad_background_color_change_section',
            [
                'label' => 'Exclusive Gradient Animation <i class="exad-extention-logo exad exad-logo"></i>',
                'tab'   => Controls_Manager::TAB_LAYOUT
            ]
		);
		
		$section->add_control(
            'exad_enable_section_background_color_change',
            [
				'label'        => __( 'Enable', 'exclusive-addons-elementor-pro' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => 'no',
                'return_value' => 'yes',
                'render_type'  => 'template',
				'label_on'     => __( 'Enable', 'exclusive-addons-elementor-pro' ),
                'label_off'    => __( 'Disable', 'exclusive-addons-elementor-pro' ),
                'prefix_class' => 'exad-background-color-change-',
            ]
		);

		$section->add_control(
			'exad_gradient_animation_z_index',
			[
                'label'   => __( 'Z Index', 'exclusive-addons-elementor-pro' ),
                'type'    => Controls_Manager::NUMBER,
                'min'     => -1000,
                'max'     => 1000,
                'step'    => 1,
                'default' => 0,
                'selectors' => [
					'{{WRAPPER}} .exad-background-animation-canvas' => 'z-index: {{VALUE}}',
				],
                'condition' => [
                    'exad_enable_section_background_color_change' => 'yes'
                ]
			]
        );

		$section->add_control(
			'exad_bg_animation_first_gradient_heading',
			[
				'label' => __( 'First Gradient', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'after',
				'condition'    => [
					'exad_enable_section_background_color_change' => 'yes'
				]
			]
		);

		$section->add_control(
			'list_color_1',
			[
				'label' => __( 'Color 1', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::COLOR,
				'default'      => '#61CE70',
                'render_type'  => 'template',
				'prefix_class' => 'exad-color-1',
				'condition'    => [
					'exad_enable_section_background_color_change' => 'yes'
				]
			]
		);
		$section->add_control(
			'list_color_2',
			[
				'label' => __( 'Color 2', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::COLOR,
				'default'      => '#23A455',
                'render_type'  => 'template',
				'prefix_class' => 'exad-color-2',
				'condition'    => [
					'exad_enable_section_background_color_change' => 'yes'
				]
			]
		);
		$section->add_control(
			'exad_bg_animation_second_gradient_heading',
			[
				'label' => __( 'Second Gradient', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'after',
				'condition'    => [
					'exad_enable_section_background_color_change' => 'yes'
				]
			]
		);
		$section->add_control(
			'list_color_3',
			[
				'label' => __( 'Color 3', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::COLOR,
				'default'      => '#4054B2',
                'render_type'  => 'template',
				'prefix_class' => 'exad-color-3',
				'condition'    => [
					'exad_enable_section_background_color_change' => 'yes'
				]
			]
		);
		$section->add_control(
			'list_color_4',
			[
				'label' => __( 'Color 4', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::COLOR,
				'default'      => '#1B2868',
                'render_type'  => 'template',
				'prefix_class' => 'exad-color-4',
				'condition'    => [
					'exad_enable_section_background_color_change' => 'yes'
				]
			]
		);
		$section->add_control(
			'exad_bg_animation_third_gradient_heading',
			[
				'label' => __( 'Third Gradient', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'after',
				'condition'    => [
					'exad_enable_section_background_color_change' => 'yes'
				]
			]
		);
		$section->add_control(
			'list_color_5',
			[
				'label' => __( 'Color 5', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::COLOR,
				'default'      => '#6EC1E4',
                'render_type'  => 'template',
				'prefix_class' => 'exad-color-5',
				'condition'    => [
					'exad_enable_section_background_color_change' => 'yes'
				]
			]
		);
		$section->add_control(
			'list_color_6',
			[
				'label' => __( 'Color 6', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::COLOR,
				'default'      => '#3394BD',
                'render_type'  => 'template',
				'prefix_class' => 'exad-color-6',
				'condition'    => [
					'exad_enable_section_background_color_change' => 'yes'
				]
			]
		);

        $section->end_controls_section();

	}

    public static function before_render( $section ) {

		$settings = $section->get_settings();
	}

    public static function after_render( $section ) {
        
		$settings = $section->get_settings_for_display();
    }

}

Gradient_Animation::init();
