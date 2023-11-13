<?php

namespace ExclusiveAddons\Elementor\Extensions;

use Elementor\Elementor_Base;
use Elementor\Controls_Manager;
use Elementor\Element_Base;
use Elementor\Widget_Base;
use Elementor\Repeater;

class Section_Particles {

    public static function init() {
        add_action( 'elementor/frontend/section/before_render',array( __CLASS__, 'before_render') );
        add_action( 'elementor/element/section/section_layout/after_section_end',array( __CLASS__, 'register_controls'), 10 );
        add_action( 'elementor/frontend/section/after_render',array( __CLASS__, 'after_render') );
    }

    public static function register_controls( $element ) {

        $element->start_controls_section(
            'exad_particles_section',
            [
                'label' => 'Exclusive Particles <i class="exad-extention-logo exad exad-logo"></i>',
                'tab'   => Controls_Manager::TAB_LAYOUT
            ]
        );

        $element->add_control(
            'exad_particle_switch',
            [
                'label' => __( 'Enable Particles', 'exclusive-addons-elementor-pro' ),
                'type'  => Controls_Manager::SWITCHER,
            ]
        );

        $element->add_control(
            'exad_particle_area_zindex',
            [
                'label'   => __( 'Z-index', 'exclusive-addons-elementor-pro' ),
                'type'    => Controls_Manager::NUMBER,
                'default' => 0,
                'condition' => [
                    'exad_particle_switch'  => 'yes'
                ]
            ]
        );

        $element->add_control(
            'exad_particle_theme_from',
            [
                'label'     => __( 'Theme Source', 'exclusive-addons-elementor-pro' ),
                'type'      => Controls_Manager::CHOOSE,
                'options' => [
                    'presets' => [
                        'title' => __( 'Defaults', 'exclusive-addons-elementor-pro' ),
                        'icon' => 'fa fa-list',
                    ],
                    'custom' => [
                        'title' => __( 'Custom', 'exclusive-addons-elementor-pro' ),
                        'icon' => 'fa fa-edit',
                    ],
                ],
                'condition' => [
                    'exad_particle_switch'  => 'yes'
                ],
                'default'   => 'presets'
            ]
        );

        $element->add_control(
            'exad_particle_color',
            [
                'label'       => esc_html__( 'Particle Color', 'exclusive-addons-elementor-pro' ),
                'type'        => Controls_Manager::COLOR,
                'label_block' => true,
                'default'       => '#786AF9',
                'condition' => [
                    'exad_particle_theme_from' => 'presets',
                    'exad_particle_switch'     => 'yes'
                ]
            ]
        );

        $element->add_control(
			'exad_particle_size',
			[
				'label'         => esc_html__('Particle Size', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::NUMBER,
				'min' => 0,
				'max' => 500,
				'step' => 1,
                'default' => 5,
                'condition' => [
                    'exad_particle_theme_from' => 'presets',
                    'exad_particle_switch'     => 'yes'
                ]
			]
        );

        $element->add_control(
            'exad_particle_line_link_color',
            [
                'label'       => esc_html__( 'Link Line Color', 'exclusive-addons-elementor-pro' ),
                'type'        => Controls_Manager::COLOR,
                'label_block' => true,
                'default'       => '#786AF9',
                'condition' => [
                    'exad_particle_theme_from' => 'presets',
                    'exad_particle_switch'     => 'yes'
                ]
            ]
        );

        $element->add_control(
			'exad_particle_number',
			[
				'label'         => esc_html__('Particle Number', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::NUMBER,
				'min' => 0,
				'max' => 1000,
				'step' => 1,
                'default' => 40,
                'condition' => [
                    'exad_particle_theme_from' => 'presets',
                    'exad_particle_switch'     => 'yes'
                ]
			]
        );
        
        $element->add_control(
			'exad_particle_line_link_distance',
			[
				'label'         => esc_html__('Line Link Distance', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::NUMBER,
				'min' => 0,
				'max' => 2000,
				'step' => 1,
                'default' => 300,
                'condition' => [
                    'exad_particle_theme_from' => 'presets',
                    'exad_particle_switch'     => 'yes'
                ]
			]
        );

        $element->add_control(
			'exad_particle_moving_speed',
			[
				'label'         => esc_html__('Moving Speed', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::NUMBER,
				'min' => 0,
				'max' => 200,
				'step' => 1,
                'default' => 5,
                'condition' => [
                    'exad_particle_theme_from' => 'presets',
                    'exad_particle_switch'     => 'yes'
                ]
			]
        );
        
        $element->add_control(
            'exad_particle_move_direction',
            [
                'label'   => __( 'Moving Direction', 'exclusive-addons-elementor-pro' ),
                'type'    => Controls_Manager::SELECT,
                'default' => 'none',
                'options' => [
                    'none'         => __( 'None', 'exclusive-addons-elementor-pro' ),
                    'top'          => __( 'Top', 'exclusive-addons-elementor-pro' ),
                    'top-right'    => __( 'Top Right', 'exclusive-addons-elementor-pro' ),
                    'bottom-right' => __( 'Bottom Right', 'exclusive-addons-elementor-pro' ),
                    'bottom'       => __( 'Bottom', 'exclusive-addons-elementor-pro' ),
                    'bottom-left'  => __( 'Bottom Left', 'exclusive-addons-elementor-pro' ),
                    'left'         => __( 'Left', 'exclusive-addons-elementor-pro' ),
                    'left-top'     => __( 'Left Top', 'exclusive-addons-elementor-pro' ),
                ],
                'condition' => [
                    'exad_particle_theme_from' => 'presets',
                    'exad_particle_switch'     => 'yes'
                ]
            ]
        );

        $element->add_control(
			'exad_particle_interactivity',
			[
				'label' => __( 'Interactivity', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::POPOVER_TOGGLE,
				'label_off' => __( 'Default', 'exclusive-addons-elementor-pro' ),
				'label_on' => __( 'Custom', 'exclusive-addons-elementor-pro' ),
				'return_value' => 'yes',
                'default' => 'yes',
                'condition' => [
                    'exad_particle_theme_from' => 'presets',
                    'exad_particle_switch'     => 'yes'
                ]
			]
        );
        
        $element->start_popover();

            $element->add_control(
                'exad_particle_interactivity_hover',
                [
                    'label' => __( 'OnHover', 'exclusive-addons-elementor-pro' ),
                    'type' => Controls_Manager::HEADING,
                    'separator' => 'before',
                ]
            );

            $element->add_control(
                'exad_particle_interactivity_enable_hover',
                [
                    'label' => __( 'Enable OnHover', 'exclusive-addons-elementor-pro' ),
                    'type' => Controls_Manager::SWITCHER,
                    'label_on' => __( 'Yes', 'exclusive-addons-elementor-pro' ),
                    'label_off' => __( 'No', 'exclusive-addons-elementor-pro' ),
                    'return_value' => true,
                    'default' => true,
                ]
            );

            $element->add_control(
                'exad_particle_interactivity_hover_mode',
                [
                    'label'   => __( 'Mode', 'exclusive-addons-elementor-pro' ),
                    'type'    => Controls_Manager::SELECT,
                    'default' => 'repulse',
                    'options' => [
                        'grab'         => __( 'Grap', 'exclusive-addons-elementor-pro' ),
                        'bubble'          => __( 'Bubble', 'exclusive-addons-elementor-pro' ),
                        'repulse'    => __( 'Repulse', 'exclusive-addons-elementor-pro' ),
                    ],
                ]
            );

            $element->add_control(
                'exad_particle_interactivity_click',
                [
                    'label' => __( 'OnClick', 'exclusive-addons-elementor-pro' ),
                    'type' => Controls_Manager::HEADING,
                    'separator' => 'before',
                ]
            );

            $element->add_control(
                'exad_particle_interactivity_enable_click',
                [
                    'label' => __( 'Enable OnClick', 'exclusive-addons-elementor-pro' ),
                    'type' => Controls_Manager::SWITCHER,
                    'label_on' => __( 'Yes', 'exclusive-addons-elementor-pro' ),
                    'label_off' => __( 'No', 'exclusive-addons-elementor-pro' ),
                    'return_value' => true,
                    'default' => true,
                ]
            );

            $element->add_control(
                'exad_particle_interactivity_click_mode',
                [
                    'label'   => __( 'Mode', 'exclusive-addons-elementor-pro' ),
                    'type'    => Controls_Manager::SELECT,
                    'default' => 'repulse',
                    'options' => [
                        'push'         => __( 'Push', 'exclusive-addons-elementor-pro' ),
                        'bubble'          => __( 'Bubble', 'exclusive-addons-elementor-pro' ),
                        'repulse'    => __( 'Repulse', 'exclusive-addons-elementor-pro' ),
                    ],
                ]
            );

        $element->end_popover();

        $element->add_control(
            'exad_particle_preset_themes',
            [
                'label'       => esc_html__( 'Preset Themes', 'exclusive-addons-elementor-pro' ),
                'type'        => Controls_Manager::SELECT,
                'label_block' => true,
                'options'     => [
                    'polygon'  => __( 'Polygon', 'exclusive-addons-elementor-pro' ),
                    'nasa'     => __( 'Nasa', 'exclusive-addons-elementor-pro' ),
                    'bubble'   => __( 'Bubble', 'exclusive-addons-elementor-pro' ),
                    'snow'     => __( 'Snow', 'exclusive-addons-elementor-pro' ),
                    'nyan_cat' => __( 'Nyan Cat', 'exclusive-addons-elementor-pro' )
                ],
                'default'       => 'polygon',
                'condition' => [
                    'exad_particle_theme_from' => 'presets',
                    'exad_particle_switch'     => 'yes'
                ]
            ]
        );
        
        $element->add_control(
            'exad_particles_custom_style',
            [
                'label'       => __( 'Custom Style', 'exclusive-addons-elementor-pro' ),
                'type'        => Controls_Manager::TEXTAREA,
                'description' => __( 'Generate your custom particles JSON code from <a href="http://vincentgarreau.com/particles.js/#default" target="_blank">Here!</a>. Simply just past the JSON code above.', 'exclusive-addons-elementor-pro' ),
                'condition' => [
                    'exad_particle_theme_from' => 'custom',
                    'exad_particle_switch'     => 'yes'
                ]
            ]
        );

        $element->add_control(
            'exad_particle_section_notice',
            [
                'raw'       => __( 'You need to configure a <strong style="color:green">Background Type</strong> to see this in full effect. You can do this by switching to the <strong style="color:green">Style</strong> Tab.', 'exclusive-addons-elementor-pro' ),
                'type'      => Controls_Manager::RAW_HTML,
                'condition' => [
                    'exad_particle_switch'     => 'yes'
                ]
            ]
        );
        
        $element->end_controls_section();

    }

    public static function before_render( $element ) {

        $settings = $element->get_settings();


        if($settings['exad_particle_switch'] !== 'yes') {
            $element->add_render_attribute( '_wrapper', 'data-exad-particle-enable', 'false' );
        }
        
        if( $settings['exad_particle_switch'] == 'yes' ){
            $element->add_render_attribute(
                '_wrapper',
                [
                    'class'                           => 'exad-section-particles-' . $element->get_id(),
                    'data-exad-particle-enable'    => 'true',
                    'data-exad-particle-color'     => $settings['exad_particle_color'],
                    'data-exad-particle-number'     => $settings['exad_particle_number'],
                    'data-exad-theme-source'       => $settings['exad_particle_theme_from'],
                    'data-exad-preset-theme'       => $settings['exad_particle_preset_themes'],
                    'data-exad-custom-style'       => $settings['exad_particles_custom_style'],
                    'data-exad-line-link-color'     => $settings['exad_particle_line_link_color'],
                    'data-exad-line-link-distance'     => $settings['exad_particle_line_link_distance'],
                    'data-exad-particle-size'     => $settings['exad_particle_size'],
                    'data-exad-particle-move-direction'     => $settings['exad_particle_move_direction'],
                    'data-exad-particle-move-speed'     => $settings['exad_particle_moving_speed'],
                    'data-exad-particle-interactivity-enable-hover'     => $settings['exad_particle_interactivity_enable_hover'],
                    'data-exad-particle-interactivity-enable-click'     => $settings['exad_particle_interactivity_enable_click'],
                    'data-exad-particle-interactivity-hover-mode'     => $settings['exad_particle_interactivity_hover_mode'],
                    'data-exad-particle-interactivity-click-mode'     => $settings['exad_particle_interactivity_click_mode'],
                ]
            );
        }
        
    }

    public static function after_render( $element ) {
        
        $data     = $element->get_data();
        $settings = $element->get_settings_for_display();
        $type     = $data['elType'];
        $zindex   = ! empty( $settings['exad_particle_area_zindex'] ) ? $settings['exad_particle_area_zindex'] : 0;

        if( ('section' == $type) && ($element->get_settings('exad_particle_switch') == 'yes') ) { ?>
            <style>
                .elementor-element-<?php echo $element->get_id(); ?>.exad-particles-section > canvas{
                    z-index: <?php echo $zindex; ?>;
                    position: absolute;
                    top:0;
                }
            </style>
            <?php
        }
    }

}

Section_Particles::init();
