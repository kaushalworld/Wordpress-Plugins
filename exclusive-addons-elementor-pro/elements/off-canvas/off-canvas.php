<?php
namespace ExclusiveAddons\Elements;

if ( ! defined( 'ABSPATH' ) ) exit;

use \Elementor\Controls_Manager;
use \Elementor\Widget_Base;
use \Elementor\Plugin;
use \Elementor\Icons_Manager;
use \Elementor\Group_Control_Typography;
use \Elementor\Group_Control_Border;
use \Elementor\Group_Control_Box_Shadow;
use \Elementor\Group_Control_Background;
use \ExclusiveAddons\Pro\Elementor\ProHelper;

class Off_Canvas extends Widget_Base {
	
	public function get_name() {
		return 'exad-offcanvas';
	}

	public function get_title() {
		return esc_html__( 'Off Canvas', 'exclusive-addons-elementor-pro' );
	}

	public function get_icon() {
		return 'exad exad-logo exad-off-canvas';
	}

	public function get_categories() {
		return [ 'exclusive-addons-elementor' ];
	}

	public function get_keywords() {
        return [ 'offcanvas', 'canvas', 'off' ];
    }

	protected function register_controls() {
		
		/**
		* offcanvas Content Section
		*/
		$this->start_controls_section(
			'exad_offcanvas_content_section',
			[
				'label' => esc_html__( 'Content', 'exclusive-addons-elementor-pro' )
			]
        );
        
        $this->add_control(
            'exad_offcanvas_content_type',
            [
                'label'   	=> __( 'Content Type', 'exclusive-addons-elementor-pro' ),
                'type'    	=> Controls_Manager::SELECT,
                'default' 	=> 'content',
                'options' 	=> [
                    'content'       => __( 'Content', 'exclusive-addons-elementor-pro' ),
                    'save_template' => __( 'Save Template', 'exclusive-addons-elementor-pro' ),
                    'menu' 			=> __( 'Menu', 'exclusive-addons-elementor-pro' ),
                    'widgets' 		=> __( 'Widgets', 'exclusive-addons-elementor-pro' ),
                ]
            ]
        );

        $this->add_control(
            'exad_offcanvas_save_template',
            [
                'label'     => __( 'Select Section', 'exclusive-addons-elementor-pro' ),
                'type'      => Controls_Manager::SELECT,
                'options'   => $this->get_saved_template( 'section' ),
                'default'   => '-1',
                'condition' => [
                    'exad_offcanvas_content_type' => 'save_template'
                ]
            ]
        );

        $this->add_control(
            'exad_offcanvas_content',
            [
                'label'       => __( 'Content', 'exclusive-addons-elementor-pro' ),
                'type'        => Controls_Manager::WYSIWYG,
                'default'     => __( 'This is offcanvas content.', 'exclusive-addons-elementor-pro' ),
                'placeholder' => __( 'Type your description here', 'exclusive-addons-elementor-pro' ),
                'condition'   => [
                    'exad_offcanvas_content_type' => 'content'
                ]
            ]
		);
		
		$menus = $this->get_menus_list();

		if ( ! empty( $menus ) ) {
			$this->add_control(
				'exad_offcanvas_menu',
				array(
					'label'        => __( 'Menu', 'exclusive-addons-elementor-pro' ),
					'type'         => Controls_Manager::SELECT,
					'options'      => $menus,
					'default'      => array_keys( $menus )[0],
					'save_default' => true,
					'description'  => sprintf( __( 'Go to the <a href="%s" target="_blank">Menus screen</a> to manage your menus.', 'exclusive-addons-elementor-pro' ), admin_url( 'nav-menus.php' ) ),
					'condition'   => [
						'exad_offcanvas_content_type' => 'menu'
					]
				)
			);
		} else {
			$this->add_control(
				'exad_offcanvas_menu',
				array(
					'type'            => Controls_Manager::RAW_HTML,
					'raw'             => sprintf( __( '<strong>There are no menus in your site.</strong><br>Go to the <a href="%s" target="_blank">Menus screen</a> to create one.', 'exclusive-addons-elementor-pro' ), admin_url( 'nav-menus.php?action=edit&menu=0' ) ),
					'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
					'condition'   => [
						'exad_offcanvas_content_type' => 'menu'
					]
				)
			);
		}

		$this->add_control(
			'exad_offcanvas_widgets',
			[
				'label'       => esc_html__( 'Choose Widgets', 'exclusive-addons-elementor-pro' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => '0',
				'options'     => ProHelper::get_widget_option(),
				'label_block' => 'true',
				'condition'   => [
					'exad_offcanvas_content_type' => 'widgets'
				]
			]
		);

		$this->end_controls_section();

		/**
		* offcanvas button Section
		*/
		$this->start_controls_section(
			'exad_offcanvas_button_section',
			[
				'label' => esc_html__( 'Button', 'exclusive-addons-elementor-pro' )
			]
        );
        
        $this->add_control(
            'exad_offcanvas_button_type',
            [
                'label'   	=> __( 'Button Type', 'exclusive-addons-elementor-pro' ),
                'type'    	=> Controls_Manager::SELECT,
                'default' 	=> 'button',
                'options' 	=> [
                    'button'      	=> __( 'Button', 'exclusive-addons-elementor-pro' ),
                    'icon' 			=> __( 'Icon', 'exclusive-addons-elementor-pro' ),
                    'custom-class' 	=> __( 'Custom Class', 'exclusive-addons-elementor-pro' ),
                ]
            ]
		);

		$this->add_control(
            'exad_offcanvas_button_position',
            [
                'label'   	=> __( 'Button Position', 'exclusive-addons-elementor-pro' ),
                'type'    	=> Controls_Manager::SELECT,
                'default' 	=> 'relative',
                'options' 	=> [
                    'fixed'      	=> __( 'Fixed', 'exclusive-addons-elementor-pro' ),
                    'relative'     	=> __( 'Relative', 'exclusive-addons-elementor-pro' ),
                ]
            ]
		);

		$this->add_control(
			'exad_offcanvas_button_position_popover',
			[
				'label' 		=> __( 'Button Position', 'exclusive-addons-elementor-pro' ),
				'type' 			=> Controls_Manager::POPOVER_TOGGLE,
				'label_off' 	=> __( 'Default', 'exclusive-addons-elementor-pro' ),
				'label_on' 		=> __( 'Custom', 'exclusive-addons-elementor-pro' ),
				'return_value' 	=> 'yes',
				'default' 		=> 'yes',
				'condition'		=> [
					'exad_offcanvas_button_position' => 'fixed'
				]
 			]
		);

		$this->start_popover();
		$this->add_responsive_control(
			'exad_offcanvas_button_position_popover_x_offset',
			[
				'label' 			=> __( 'X Offset', 'exclusive-addons-elementor-pro' ),
				'type' 				=> Controls_Manager::SLIDER,
				'size_units' 		=> [ 'px', '%' ],
				'range' 			=> [
					'px' 	=> [
						'min' 	=> -1000,
						'max' 	=> 1000,
					],
					'%' 	=> [
						'min' 	=> -50,
						'max' 	=> 100,
					],
				],
				'default' 	=> [
					'unit' 		=> '%',
					'size' 		=> 0,
				],
				'selectors' => [
					'{{WRAPPER}} .exad-offcanvas.exad-offcanvas-button-fixed .exad-offcanvas-open-button-wrapper' => 'left: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'exad_offcanvas_button_position_popover_y_offset',
			[
				'label' 		=> __( 'Y Offset', 'exclusive-addons-elementor-pro' ),
				'type' 			=> Controls_Manager::SLIDER,
				'size_units' 	=> [ 'px', '%' ],
				'range' 	=> [
					'px' 	=> [
						'min' 	=> -1000,
						'max' 	=> 1000,
					],
					'%' 	=> [
						'min' 	=> -50,
						'max' 	=> 100,
					],
				],
				'default' 	=> [
					'unit' 		=> '%',
					'size' 		=> 50,
				],
				'selectors' => [
					'{{WRAPPER}} .exad-offcanvas.exad-offcanvas-button-fixed .exad-offcanvas-open-button-wrapper' => 'top: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'exad_offcanvas_button_position_popover_rotation',
			[
				'label' 		=> __( 'Rotation', 'exclusive-addons-elementor-pro' ),
				'type' 			=> Controls_Manager::SLIDER,
				'range' 	=> [
					'px'       => [
                        'min'  => 0,
                        'max'  => 360,
                        'step' => 5
                    ]
				],
				'selectors' => [
					'{{WRAPPER}} .exad-offcanvas.exad-offcanvas-button-fixed .exad-offcanvas-open-button-wrapper' => 'transform: rotate( {{SIZE}}deg );',
				],
			]
		);

		$this->end_popover();
		
		$this->add_control(
			'exad_offcanvas_button_text',
			[
				'label' 		=> __( 'Button Text', 'exclusive-addons-elementor-pro' ),
				'type' 			=> Controls_Manager::TEXT,
				'default'	 	=> __( 'Click me', 'exclusive-addons-elementor-pro' ),
                'condition'   	=> [
                    'exad_offcanvas_button_type' => 'button'
                ]
			]
		);

		$this->add_control(
            'exad_offcanvas_button_text_icon',
            [
                'label'       	=> __('Icon', 'exclusive-addons-elementor-pro'),
                'type'        	=> Controls_Manager::ICONS,
                'default'     	=> [
                    'value'   		=> 'fas fa-align-justify',
                    'library' 		=> 'fa-solid'
                ],
                'condition'   	=> [
                    'exad_offcanvas_button_type' => 'button'
                ]
            ]
		);

		$this->add_control(
            'exad_offcanvas_button_text_icon_position',
            [
                'label'   	=> __( 'Icon Position', 'exclusive-addons-elementor-pro' ),
                'type'    	=> Controls_Manager::SELECT,
                'default' 	=> 'after',
                'options' 	=> [
                    'before'    => __( 'Before Text', 'exclusive-addons-elementor-pro' ),
                    'after' 	=> __( 'After Text', 'exclusive-addons-elementor-pro' ),
				],
				'condition'  => [
                    'exad_offcanvas_button_type' => 'button'
                ]
            ]
		);

		$this->add_responsive_control(
			'exad_offcanvas_button_text_icon_spacing',
			[
				'label' 		=> __( 'Icon Spacing', 'exclusive-addons-elementor-pro' ),
				'type' 			=> Controls_Manager::SLIDER,
				'size_units' 	=> [ 'px' ],
				'range' 		=> [
					'px' 		=> [
						'min' 	=> 0,
						'max' 	=> 50,
					],
				],
				'default' 		=> [
					'unit' 		=> 'px',
					'size' 		=> 10,
				],
				'selectors' 	=> [
					'{{WRAPPER}} .exad-offcanvas-open-button.before i' => 'margin-right: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .exad-offcanvas-open-button.after i' => 'margin-left: {{SIZE}}{{UNIT}};',
				],
				'condition'   	=> [
                    'exad_offcanvas_button_type' => 'button'
                ]
			]
		);

        $this->add_control(
            'exad_offcanvas_button_icon',
            [
                'label'       => __('Icon', 'exclusive-addons-elementor-pro'),
                'type'        => Controls_Manager::ICONS,
                'default'     => [
                    'value'   => 'fas fa-align-justify',
                    'library' => 'fa-solid'
                ],
                'condition'   => [
                    'exad_offcanvas_button_type' => 'icon'
                ]
            ]
		);

		$this->add_control(
			'exad_offcanvas_custom_class',
			array(
				'label'       => __( 'Custom Class', 'exclusive-addons-elementor-pro' ),
				'type'        => Controls_Manager::TEXT,
				'description' => __( 'Add your custom class without the dot.', 'exclusive-addons-elementor-pro' ),
				'condition'   => [
                    'exad_offcanvas_button_type' => 'custom-class'
                ]
			)
		);

		$this->end_controls_section();

		/**
		* offcanvas Section
		*/
		$this->start_controls_section(
			'exad_offcanvas_section',
			[
				'label' => esc_html__( 'Off-Canvas', 'exclusive-addons-elementor-pro' )
			]
		);
		
		$this->add_responsive_control(
			'exad_offcanvas_width',
			[
				'label' 			=> __( 'Width', 'exclusive-addons-elementor-pro' ),
				'type' 				=> Controls_Manager::SLIDER,
				'size_units' 		=> [ 'px', '%' ],
				'range' 			=> [
					'px' 	=> [
						'min' 	=> 0,
						'max' 	=> 1000,
						'step' 	=> 5,
					],
					'%' 	=> [
						'min' 	=> 0,
						'max' 	=> 100,
					],
				],
				'default' 	=> [
					'unit' 		=> 'px',
					'size' 		=> 300,
				],
				'selectors' => [
					'{{WRAPPER}} .exad-offcanvas-content.offcanvas-left .exad-offcanvas-content-inner' => 'width: {{SIZE}}{{UNIT}}; left: calc( 0px - ({{SIZE}}{{UNIT}}) );',
					'{{WRAPPER}} .exad-offcanvas-content.offcanvas-left .exad-offcanvas-content-inner.offcanvas-active' => 'left: calc( ({{SIZE}}{{UNIT}}) - ({{SIZE}}{{UNIT}}) );',
					'{{WRAPPER}} .exad-offcanvas-content.offcanvas-right .exad-offcanvas-content-inner' => 'width: {{SIZE}}{{UNIT}}; right: calc( 0px - ({{SIZE}}{{UNIT}}) );',
					'{{WRAPPER}} .exad-offcanvas-content.offcanvas-right .exad-offcanvas-content-inner.offcanvas-active' => 'right: calc( ({{SIZE}}{{UNIT}}) - ({{SIZE}}{{UNIT}}) );',
					'{{WRAPPER}} .exad-offcanvas-content.offcanvas-top .exad-offcanvas-content-inner' => 'height: {{SIZE}}{{UNIT}}; top: calc( 0px - ({{SIZE}}{{UNIT}}) );',
					'{{WRAPPER}} .exad-offcanvas-content.offcanvas-top .exad-offcanvas-content-inner.offcanvas-active' => 'top: calc( ({{SIZE}}{{UNIT}}) - ({{SIZE}}{{UNIT}}) );',
					'{{WRAPPER}} .exad-offcanvas-content.offcanvas-bottom .exad-offcanvas-content-inner' => 'height: {{SIZE}}{{UNIT}}; bottom: calc( 0px - ({{SIZE}}{{UNIT}}) );',
					'{{WRAPPER}} .exad-offcanvas-content.offcanvas-bottom .exad-offcanvas-content-inner.offcanvas-active' => 'bottom: calc( ({{SIZE}}{{UNIT}}) - ({{SIZE}}{{UNIT}}) );',
				],
			]
		);

		$this->add_control(
			'exad_offcanvas_position',
			[
				'label' 	=> __( 'Position', 'exclusive-addons-elementor-pro' ),
				'type' 		=> Controls_Manager::CHOOSE,
				'options' 	=> [
					'offcanvas-left' 	=> [
						'title' 	=> __( 'Left', 'exclusive-addons-elementor-pro' ),
						'icon' 		=> 'eicon-arrow-left',
					],
					'offcanvas-right' 	=> [
						'title' 	=> __( 'Right', 'exclusive-addons-elementor-pro' ),
						'icon' 		=> 'eicon-arrow-right',
					],
					'offcanvas-top' 	=> [
						'title' 	=> __( 'Top', 'exclusive-addons-elementor-pro' ),
						'icon' 		=> 'eicon-arrow-up',
					],
					'offcanvas-bottom' 	=> [
						'title' 	=> __( 'Bottom', 'exclusive-addons-elementor-pro' ),
						'icon' 		=> 'eicon-arrow-down',
					],
				],
				'default' 	=> 'offcanvas-left',
				'toggle' 	=> true,
			]
		);

		$this->add_control(
            'exad_offcanvas_appear_animation',
            [
                'label'   	=> __( 'Appear Animation', 'exclusive-addons-elementor-pro' ),
                'type'    	=> Controls_Manager::SELECT,
                'default' 	=> 'slide',
                'options' 	=> [
                    'slide'       	=> __( 'Slide', 'exclusive-addons-elementor-pro' ),
                    'push' 			=> __( 'Push', 'exclusive-addons-elementor-pro' ),
                ]
            ]
		);

		$this->end_controls_section();

		/**
		* offcanvas Close Button section
		*/
		$this->start_controls_section(
			'exad_offcanvas_close_button_section',
			[
				'label' => esc_html__( 'Close Button', 'exclusive-addons-elementor-pro' )
			]
		);

		$this->add_control(
			'exad_offcanvas_show_close_button',
			[
				'label' 		=> __( 'Show Close Button', 'exclusive-addons-elementor-pro' ),
				'type' 			=> Controls_Manager::SWITCHER,
				'label_on' 		=> __( 'Show', 'exclusive-addons-elementor-pro' ),
				'label_off' 	=> __( 'Hide', 'exclusive-addons-elementor-pro' ),
				'return_value' 	=> 'yes',
				'default' 		=> 'yes',
			]
		);

		$this->add_control(
			'exad_offcanvas_close_esc_keypress',
			[
				'label' 		=> __( 'Close on ESC key', 'exclusive-addons-elementor-pro' ),
				'type' 			=> Controls_Manager::SWITCHER,
				'label_on' 		=> __( 'On', 'exclusive-addons-elementor-pro' ),
				'label_off' 	=> __( 'Off', 'exclusive-addons-elementor-pro' ),
				'return_value' 	=> 'yes',
				'default' 		=> 'no',
			]
		);

		$this->add_control(
			'exad_offcanvas_close_overlay_click',
			[
				'label' 		=> __( 'Close on Click Overlay', 'exclusive-addons-elementor-pro' ),
				'type' 			=> Controls_Manager::SWITCHER,
				'label_on' 		=> __( 'On', 'exclusive-addons-elementor-pro' ),
				'label_off' 	=> __( 'Off', 'exclusive-addons-elementor-pro' ),
				'return_value' 	=> 'yes',
				'default' 		=> 'no',
			]
		);

		$this->end_controls_section();

		/**
		* offcanvas Button Style Section
		*/
		$this->start_controls_section(
			'exad_offcanvas_button_style',
			[
				'label' => esc_html__( 'Button', 'exclusive-addons-elementor-pro' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'exad_offcanvas_button_alignment',
			[
				'label' 	=> __( 'Alignment', 'exclusive-addons-elementor-pro' ),
				'type' 		=> Controls_Manager::CHOOSE,
				'options' 	=> [
					'align-left' 	=> [
						'title' 	=> __( 'Left', 'exclusive-addons-elementor-pro' ),
						'icon' 		=> 'eicon-h-align-left',
					],
					'align-center' 	=> [
						'title' 	=> __( 'Right', 'exclusive-addons-elementor-pro' ),
						'icon' 		=> 'eicon-h-align-center',
					],
					'align-right' 	=> [
						'title' 	=> __( 'Top', 'exclusive-addons-elementor-pro' ),
						'icon' 		=> 'eicon-h-align-right',
					],
				],
				'default' 	=> 'align-center',
				'toggle' 	=> true,
				'condition' => [
					'exad_offcanvas_button_position' => 'relative'
				]
			]
		);
		
		$this->add_responsive_control(
			'exad_offcanvas_button_padding',
			[
				'label' 		=> __( 'Padding', 'exclusive-addons-elementor-pro' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'default'		=> [
					'top' 		=> '10',
					'right' 	=> '30',
					'bottom' 	=> '10',
					'left' 		=> '30',
					'unit' 		=> 'px',
					'isLinked' 	=> false,
				],
				'selectors' 	=> [
					'{{WRAPPER}} .exad-offcanvas-open-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'exad_offcanvas_button_radius',
			[
				'label' 			=> __( 'Radius', 'exclusive-addons-elementor-pro' ),
				'type' 				=> Controls_Manager::DIMENSIONS,
				'size_units' 		=> [ 'px', '%', 'em' ],
				'default'			=> [
					'top' 		=> '0',
					'right' 	=> '0',
					'bottom'	=> '0',
					'left' 		=> '0',
					'unit' 		=> 'px',
					'isLinked' 	=> true,
				],
				'selectors' => [
					'{{WRAPPER}} .exad-offcanvas-open-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' 			=> 'exad_offcanvas_button_typography',
				'label' 		=> __( 'Typography', 'exclusive-addons-elementor-pro' ),
				'selector' 		=> '{{WRAPPER}} .exad-offcanvas-open-button',
				'condition' 	=> [
					'exad_offcanvas_button_type' => 'button'
				]
			]
		);

		$this->add_responsive_control(
			'exad_offcanvas_icon_size',
			[
				'label' 		=> __( 'Icon Size', 'exclusive-addons-elementor-pro' ),
				'type' 			=> Controls_Manager::SLIDER,
				'size_units' 	=> [ 'px' ],
				'range' 	=> [
					'px' 	=> [
						'min' 	=> 0,
						'max' 	=> 100,
					],
				],
				'default' 	=> [
					'unit' 		=> 'px',
					'size'	 	=> 20,
				],
				'selectors' => [
					'{{WRAPPER}} .exad-offcanvas-open-button i' => 'font-size: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'exad_offcanvas_button_type' => 'icon'
				]
			]
		);

		$this->start_controls_tabs( 'exad_offcanvas_button_tabs', [ 'condition' => [ 'exad_offcanvas_button_type' => ['button', 'icon' ] ] ] );
            // normal state tab
			$this->start_controls_tab( 'exad_offcanvas_button_normal', [ 'label' => esc_html__( 'Normal', 'exclusive-addons-elementor-pro' ) ] );
			
				$this->add_control(
					'exad_offcanvas_button_background_normal',
					[
						'label' 		=> __( 'Background Color', 'exclusive-addons-elementor-pro' ),
						'type'	 		=> Controls_Manager::COLOR,
						'default' 		=> '#7a56ff',
						'selectors' 	=> [
							'{{WRAPPER}} .exad-offcanvas-open-button' => 'background: {{VALUE}}',
						],
					]
				);

				$this->add_control(
					'exad_offcanvas_button_text_color_normal',
					[
						'label' 		=> __( 'Text Color', 'exclusive-addons-elementor-pro' ),
						'type' 			=> Controls_Manager::COLOR,
						'default' 		=> '#ffffff',
						'selectors' 	=> [
							'{{WRAPPER}} .exad-offcanvas-open-button' => 'color: {{VALUE}}',
						],
					]
				);

				$this->add_group_control(
					Group_Control_Border::get_type(),
					[
						'name' 		=> 'exad_offcanvas_button_border_normal',
						'label' 	=> __( 'Border', 'exclusive-addons-elementor-pro' ),
						'selector' 	=> '{{WRAPPER}} .exad-offcanvas-open-button',
					]
				);

				$this->add_group_control(
					Group_Control_Box_Shadow::get_type(),
					[
						'name' 		=> 'exad_offcanvas_button_shadow_normal',
						'label' 	=> __( 'Box Shadow', 'exclusive-addons-elementor-pro' ),
						'selector' 	=> '{{WRAPPER}} .exad-offcanvas-open-button',
					]
				);

            $this->end_controls_tab();

            // hover state tab
			$this->start_controls_tab( 'exad_offcanvas_button_hover', [ 'label' => esc_html__( 'Hover', 'exclusive-addons-elementor-pro' ) ] );
			
				$this->add_control(
					'exad_offcanvas_button_background_hover',
					[
						'label' 		=> __( 'Background Color', 'exclusive-addons-elementor-pro' ),
						'type' 			=> Controls_Manager::COLOR,
						'default' 		=> '#ffffff',
						'selectors' 	=> [
							'{{WRAPPER}} .exad-offcanvas-open-button:hover' => 'background: {{VALUE}}',
						],
					]
				);

				$this->add_control(
					'exad_offcanvas_button_text_color_hover',
					[
						'label' 		=> __( 'Text Color', 'exclusive-addons-elementor-pro' ),
						'type' 			=> Controls_Manager::COLOR,
						'default' 		=> '#7a56ff',
						'selectors' 	=> [
							'{{WRAPPER}} .exad-offcanvas-open-button:hover' => 'color: {{VALUE}}',
						],
					]
				);

				$this->add_group_control(
					Group_Control_Border::get_type(),
					[
						'name' 		=> 'exad_offcanvas_button_border_hover',
						'label'	 	=> __( 'Border', 'exclusive-addons-elementor-pro' ),
						'selector' 	=> '{{WRAPPER}} .exad-offcanvas-open-button:hover',
					]
				);

				$this->add_group_control(
					Group_Control_Box_Shadow::get_type(),
					[
						'name' 			=> 'exad_offcanvas_button_shadow_hover',
						'label' 		=> __( 'Box Shadow', 'exclusive-addons-elementor-pro' ),
						'selector' 		=> '{{WRAPPER}} .exad-offcanvas-open-button:hover',
					]
				);

            $this->end_controls_tab();

        $this->end_controls_tabs();

		$this->end_controls_section();

		/**
		* offcanvas Button Style Section
		*/
		$this->start_controls_section(
			'exad_offcanvas_style_section',
			[
				'label' => esc_html__( 'Off-Canvas', 'exclusive-addons-elementor-pro' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' 		=> 'exad_offcanvas_background',
				'label' 	=> __( 'Background', 'exclusive-addons-elementor-pro' ),
				'types' 	=> [ 'classic', 'gradient' ],
				'selector' 	=> '{{WRAPPER}} .exad-offcanvas-content .exad-offcanvas-content-inner',
			]
		);

		$this->add_control(
			'exad_offcanvas_content_text_color',
			[
				'label' 		=> __( 'Text Color', 'exclusive-addons-elementor-pro' ),
				'type' 			=> Controls_Manager::COLOR,
				'default' 		=> '#000000',
				'selectors' 	=> [
					'{{WRAPPER}} .exad-offcanvas-content .exad-offcanvas-content-body' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_responsive_control(
			'exad_offcanvas_padding',
			[
				'label' 		=> __( 'Padding', 'exclusive-addons-elementor-pro' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'default'		=> [
					'top' 			=> '50',
					'right' 		=> '30',
					'bottom' 		=> '50',
					'left' 			=> '30',
					'unit' 			=> 'px',
					'isLinked' 		=> false,
				],
				'selectors' => [
					'{{WRAPPER}} .exad-offcanvas-content .exad-offcanvas-content-body' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'exad_offcanvas_margin',
			[
				'label' 		=> __( 'Margin', 'exclusive-addons-elementor-pro' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'default'		=> [
					'top' 			=> '0',
					'right' 		=> '0',
					'bottom' 		=> '0',
					'left' 			=> '0',
					'unit' 			=> 'px',
					'isLinked' 		=> false,
				],
				'selectors' => [
					'{{WRAPPER}} .exad-offcanvas-content.offcanvas-left .exad-offcanvas-content-inner.offcanvas-active' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .exad-offcanvas-content.offcanvas-left .exad-offcanvas-content-inner' => 'height: calc( 100% -  ( {{BOTTOM}}{{UNIT}} ) );',
					'{{WRAPPER}} .exad-offcanvas-content.offcanvas-right .exad-offcanvas-content-inner.offcanvas-active' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .exad-offcanvas-content.offcanvas-right .exad-offcanvas-content-inner' => 'height: calc( 100% -  ( {{BOTTOM}}{{UNIT}} ) );',
					'{{WRAPPER}} .exad-offcanvas-content.offcanvas-top .exad-offcanvas-content-inner.offcanvas-active' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .exad-offcanvas-content.offcanvas-top .exad-offcanvas-content-inner' => 'width: calc( 100% -  ( {{RIGHT}}{{UNIT}} ) );',
					'{{WRAPPER}} .exad-offcanvas-content.offcanvas-bottom .exad-offcanvas-content-inner.offcanvas-active' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .exad-offcanvas-content.offcanvas-bottom .exad-offcanvas-content-inner' => 'width: calc( 100% -  ( {{RIGHT}}{{UNIT}} ) );',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'exad_offcanvas_border',
				'label' => __( 'Border', 'exclusive-addons-elementor-pro' ),
				'selector' => '{{WRAPPER}} .exad-offcanvas-content.offcanvas-left .exad-offcanvas-content-inner, {{WRAPPER}} .exad-offcanvas-content.offcanvas-right .exad-offcanvas-content-inner, {{WRAPPER}} .exad-offcanvas-content.offcanvas-top .exad-offcanvas-content-inner, {{WRAPPER}} .exad-offcanvas-content.offcanvas-bottom .exad-offcanvas-content-inner'
			]
		);

		$this->add_responsive_control(
			'exad_offcanvas_border_radius',
			[
				'label' 		=> __( 'Border Radius', 'exclusive-addons-elementor-pro' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'default'		=> [
					'top' 			=> '0',
					'right' 		=> '0',
					'bottom' 		=> '0',
					'left' 			=> '0',
					'unit' 			=> 'px',
					'isLinked' 		=> false,
				],
				'selectors' => [
					'{{WRAPPER}} .exad-offcanvas-content.offcanvas-left .exad-offcanvas-content-inner' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .exad-offcanvas-content.offcanvas-right .exad-offcanvas-content-inner' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .exad-offcanvas-content.offcanvas-top .exad-offcanvas-content-inner' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .exad-offcanvas-content.offcanvas-bottom .exad-offcanvas-content-inner' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'exad_offcanvas_box_shadow',
				'label' => __( 'Box Shadow', 'exclusive-addons-elementor-pro' ),
				'selector' => '{{WRAPPER}} .exad-offcanvas-content.offcanvas-left .exad-offcanvas-content-inner, {{WRAPPER}} .exad-offcanvas-content.offcanvas-right .exad-offcanvas-content-inner, .exad-offcanvas-content.offcanvas-top .exad-offcanvas-content-inner, .exad-offcanvas-content.offcanvas-bottom .exad-offcanvas-content-inner'
			]
		);

		$this->add_control(
			'exad_offcanvas_overlay_background',
			[
				'label' 		=> __( 'Overlay Color', 'exclusive-addons-elementor-pro' ),
				'type' 			=> Controls_Manager::COLOR,
				'default' 		=> 'rgba(0, 0, 0, .5)',
				'selectors' 	=> [
					'{{WRAPPER}} .exad-offcanvas-overlay' => 'background: {{VALUE}}',
				],
			]
		);

		$this->end_controls_section();

		/**
		* offcanvas Menu Style
		*/
		$this->start_controls_section(
			'exad_offcanvas_menu_style',
			[
				'label' => esc_html__( 'Off-Canvas Menu', 'exclusive-addons-elementor-pro' ),
				'tab'   => Controls_Manager::TAB_STYLE,
				'condition' => [
					'exad_offcanvas_content_type' => 'menu'
				]
			]
		);

		$this->add_responsive_control(
			'exad_offcanvas_menu_padding',
			[
				'label' 			=> __( 'Padding', 'exclusive-addons-elementor-pro' ),
				'type' 				=> Controls_Manager::DIMENSIONS,
				'size_units' 		=> [ 'px', '%', 'em' ],
				'default'			=> [
					'top' 		=> '10',
					'right' 	=> '0',
					'bottom' 	=> '10',
					'left' 		=> '0',
					'unit' 		=> 'px',
					'isLinked' 	=> false,
				],
				'selectors' 		=> [
					'{{WRAPPER}} .exad-offcanvas-menu .menu-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'exad_offcanvas_menu_margin',
			[
				'label' 			=> __( 'Margin', 'exclusive-addons-elementor-pro' ),
				'type' 				=> Controls_Manager::DIMENSIONS,
				'size_units' 		=> [ 'px', '%', 'em' ],
				'default'			=> [
					'top' 		=> '0',
					'right' 	=> '0',
					'bottom' 	=> '0',
					'left' 		=> '0',
					'unit' 		=> 'px',
					'isLinked' 	=> false,
				],
				'selectors' 		=> [
					'{{WRAPPER}} .exad-offcanvas-menu .menu-item' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' 			=> 'exad_offcanvas_menu_typography',
				'label' 		=> __( 'Typography', 'exclusive-addons-elementor-pro' ),
				'selector' 		=> '{{WRAPPER}} .exad-offcanvas-menu .menu-item a',
			]
		);

		$this->start_controls_tabs( 'exad_offcanvas_menu_style_tab' );
            // normal state tab
			$this->start_controls_tab( 'exad_offcanvas_menu_normal', [ 'label' => esc_html__( 'Normal', 'exclusive-addons-elementor-pro' ) ] );
			
				$this->add_control(
					'exad_offcanvas_menu_normal_background',
					[
						'label' 		=> __( 'Background Color', 'exclusive-addons-elementor-pro' ),
						'type'	 		=> Controls_Manager::COLOR,
						'selectors' 	=> [
							'{{WRAPPER}} .exad-offcanvas-menu .menu-item' => 'background: {{VALUE}}',
						],
					]
				);

				$this->add_control(
					'exad_offcanvas_menu_normal_text_color',
					[
						'label' 		=> __( 'Text Color', 'exclusive-addons-elementor-pro' ),
						'type' 			=> Controls_Manager::COLOR,
						'selectors' 	=> [
							'{{WRAPPER}} .exad-offcanvas-menu .menu-item a' => 'color: {{VALUE}}',
						],
					]
				);

				$this->add_group_control(
					Group_Control_Border::get_type(),
					[
						'name' 		=> 'exad_offcanvas_menu_normal_border',
						'label' 	=> __( 'Border', 'exclusive-addons-elementor-pro' ),
						'selector' 	=> '{{WRAPPER}} .exad-offcanvas-menu .menu-item',
					]
				);

            $this->end_controls_tab();

            // hover state tab
			$this->start_controls_tab( 'exad_offcanvas_menu_hover', [ 'label' => esc_html__( 'Hover', 'exclusive-addons-elementor-pro' ) ] );
			
				$this->add_control(
					'exad_offcanvas_menu_hover_background',
					[
						'label' 		=> __( 'Background Color', 'exclusive-addons-elementor-pro' ),
						'type'	 		=> Controls_Manager::COLOR,
						'selectors' 	=> [
							'{{WRAPPER}} .exad-offcanvas-menu .menu-item:hover' => 'background: {{VALUE}}',
						],
					]
				);

				$this->add_control(
					'exad_offcanvas_menu_hover_text_color',
					[
						'label' 		=> __( 'Text Color', 'exclusive-addons-elementor-pro' ),
						'type' 			=> Controls_Manager::COLOR,
						'selectors' 	=> [
							'{{WRAPPER}} .exad-offcanvas-menu .menu-item:hover a' => 'color: {{VALUE}}',
						],
					]
				);

				$this->add_group_control(
					Group_Control_Border::get_type(),
					[
						'name' 		=> 'exad_offcanvas_menu_hover_border',
						'label' 	=> __( 'Border', 'exclusive-addons-elementor-pro' ),
						'selector' 	=> '{{WRAPPER}} .exad-offcanvas-menu .menu-item:hover',
					]
				);

            $this->end_controls_tab();

        $this->end_controls_tabs();

		$this->end_controls_section();

		/**
		 * Offcanvas widget style section
		 */

		 /**
		* offcanvas Menu Style
		*/
		$this->start_controls_section(
			'exad_offcanvas_widget_style',
			[
				'label' => esc_html__( 'Off-Canvas Widget', 'exclusive-addons-elementor-pro' ),
				'tab'   => Controls_Manager::TAB_STYLE,
				'condition' => [
					'exad_offcanvas_content_type' => 'widgets'
				]
			]
		);

		$this->add_control(
			'exad_offcanvas_widget_title',
			[
				'label' => __( 'Widget Title', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' 			=> 'exad_offcanvas_widget_title_typography',
				'label' 		=> __( 'Typography', 'exclusive-addons-elementor-pro' ),
				'selector' 		=> '{{WRAPPER}} .exad-offcanvas-widget .sidebar-box .widget-title',
			]
		);

		$this->add_control(
			'exad_offcanvas_widget_title_color',
			[
				'label' 		=> __( 'Text Color', 'exclusive-addons-elementor-pro' ),
				'type' 			=> Controls_Manager::COLOR,
				'selectors' 	=> [
					'{{WRAPPER}} .exad-offcanvas-widget .sidebar-box .widget-title' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'exad_offcanvas_widget_content',
			[
				'label' => __( 'Widget Content', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' 			=> 'exad_offcanvas_widget_content_typography',
				'label' 		=> __( 'Typography', 'exclusive-addons-elementor-pro' ),
				'selector' 		=> '{{WRAPPER}} .exad-offcanvas-widget .sidebar-box',
			]
		);

		$this->add_control(
			'exad_offcanvas_widget_content_color',
			[
				'label' 		=> __( 'Text Color', 'exclusive-addons-elementor-pro' ),
				'type' 			=> Controls_Manager::COLOR,
				'selectors' 	=> [
					'{{WRAPPER}} .exad-offcanvas-widget .sidebar-box' => 'color: {{VALUE}}',
				],
			]
		);

		$this->end_controls_section();

		/**
		* offcanvas close button Style
		*/
		$this->start_controls_section(
			'exad_offcanvas_close_button_style',
			[
				'label' 		=> esc_html__( 'Close Button', 'exclusive-addons-elementor-pro' ),
				'tab'   		=> Controls_Manager::TAB_STYLE,
				'condition' 	=> [
					'exad_offcanvas_show_close_button' => 'yes'
				]
			]
		);

		$this->add_control(
			'exad_offcanvas_close_button_background',
			[
				'label' 		=> __( 'Background Color', 'exclusive-addons-elementor-pro' ),
				'type' 			=> Controls_Manager::COLOR,
				'selectors' 	=> [
					'{{WRAPPER}} .exad-offcanvas-close-button'=> 'background: {{VALUE}}',
				],
			]
		);

		$this->add_responsive_control(
			'exad_offcanvas_close_button_box_size',
			[
				'label' 		=> __( 'Box Size', 'exclusive-addons-elementor-pro' ),
				'type' 			=> Controls_Manager::SLIDER,
				'size_units' 	=> [ 'px' ],
				'range' 		=> [
					'px' 		=> [
						'min' => 0,
						'max' => 100,
					],
				],
				'default' 		=> [
					'unit' 	=> 'px',
					'size' 	=> 30,
				],
				'selectors' 	=> [
					'{{WRAPPER}} .exad-offcanvas-close-button' => 'height: {{SIZE}}{{UNIT}}; width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'exad_offcanvas_close_button_icon_size',
			[
				'label' 		=> __( 'Icon Size', 'exclusive-addons-elementor-pro' ),
				'type' 			=> Controls_Manager::SLIDER,
				'size_units' 	=> [ 'px' ],
				'range' 		=> [
					'px' 	=> [
						'min' 	=> 0,
						'max' 	=> 80,
					],
				],
				'default' 	=> [
					'unit'	 	=> 'px',
					'size' 		=> 20,
				],
				'selectors' 	=> [
					'{{WRAPPER}} .exad-offcanvas-close-button span::before,
					{{WRAPPER}} .exad-offcanvas-close-button span::after' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'exad_offcanvas_close_button_color',
			[
				'label' 		=> __( 'Icon Color', 'exclusive-addons-elementor-pro' ),
				'type' 			=> Controls_Manager::COLOR,
				'default' 		=> '#000000',
				'selectors' 	=> [
					'{{WRAPPER}} .exad-offcanvas-close-button span::before,
					{{WRAPPER}} .exad-offcanvas-close-button span::after' => 'background: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' 		=> 'exad_offcanvas_close_button_border',
				'label' 	=> __( 'Border', 'exclusive-addons-elementor-pro' ),
				'selector' 	=> '{{WRAPPER}} .exad-offcanvas-close-button',
			]
		);

		$this->add_responsive_control(
			'exad_offcanvas_close_button_radius',
			[
				'label' 			=> __( 'Box Border Radius', 'exclusive-addons-elementor-pro' ),
				'type' 				=> Controls_Manager::DIMENSIONS,
				'size_units' 		=> [ 'px', '%', 'em' ],
				'default'			=> [
					'top' 		=> '0',
					'right' 	=> '0',
					'bottom' 	=> '0',
					'left' 		=> '0',
					'unit' 		=> 'px',
					'isLinked' 	=> true,
				],
				'selectors' 		=> [
					'{{WRAPPER}} .exad-offcanvas-close-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'exad_offcanvas_close_button_position',
			[
				'label' 		=> __( 'Button Position', 'exclusive-addons-elementor-pro' ),
				'type' 			=> Controls_Manager::POPOVER_TOGGLE,
				'label_off' 	=> __( 'Default', 'exclusive-addons-elementor-pro' ),
				'label_on' 		=> __( 'Custom', 'exclusive-addons-elementor-pro' ),
				'return_value' 	=> 'yes',
				'default' 		=> 'yes',
			]
		);

		$this->start_popover();
		$this->add_responsive_control(
			'exad_offcanvas_close_button_position_x_offset',
			[
				'label' 			=> __( 'X Offset', 'exclusive-addons-elementor-pro' ),
				'type' 				=> Controls_Manager::SLIDER,
				'size_units' 		=> [ 'px', '%' ],
				'range' 			=> [
					'px' 	=> [
						'min' 	=> -500,
						'max' 	=> 1000,
					],
					'%' 	=> [
						'min' 	=> -100,
						'max' 	=> 100,
					],
				],
				'default' 	=> [
					'unit' 		=> 'px',
					'size' 		=> 30,
				],
				'selectors' => [
					'{{WRAPPER}} .exad-offcanvas-close-button' => 'right: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'exad_offcanvas_close_button_position_y_offset',
			[
				'label' 		=> __( 'Y Offset', 'exclusive-addons-elementor-pro' ),
				'type' 			=> Controls_Manager::SLIDER,
				'size_units' 	=> [ 'px', '%' ],
				'range' 	=> [
					'px' 	=> [
						'min' 	=> -500,
						'max' 	=> 1000,
					],
					'%' 	=> [
						'min' 	=> -100,
						'max' 	=> 100,
					],
				],
				'default' 	=> [
					'unit' 		=> 'px',
					'size' 		=> 30,
				],
				'selectors' => [
					'{{WRAPPER}} .exad-offcanvas-close-button' => 'top: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->end_popover();

		$this->end_controls_section();
    }

    /**
	 *  Get Saved page
	 *
	 *  @param string $type Type.
	 *  @since 0.0.1
	 *  @return string
	 */
	public function get_saved_template( $type = 'page' ) {

		$saved_template = $this->get_post_template( $type );
		$options[-1]   = __( 'Select', 'exclusive-addons-elementor-pro' );
		if ( count( $saved_template ) ) :
			foreach ( $saved_template as $saved_row ) :
				$options[ $saved_row['id'] ] = $saved_row['name'];
			endforeach;
		else :
			$options['no_template'] = __( 'No section template is added.', 'exclusive-addons-elementor-pro' );
		endif;
		return $options;
	}

	/**
	 *  Get Templates based on category
	 *
	 *  @param string $type Type.
	 *  @since 0.0.1
	 *  @return string
	 */
	public function get_post_template( $type = 'page' ) {
		$posts = get_posts(
			array(
				'post_type'        => 'elementor_library',
				'orderby'          => 'title',
				'order'            => 'ASC',
				'posts_per_page'   => '-1',
				'tax_query'        => array(
					array(
						'taxonomy' => 'elementor_library_type',
						'field'    => 'slug',
						'terms'    => $type
					)
				)
			)
		);

		$templates = array();

		foreach ( $posts as $post ) :
			$templates[] = array(
				'id'   => $post->ID,
				'name' => $post->post_title
			);
		endforeach;

		return $templates;
	}

	/**
	 * Get available menus list
	 *
	 * @since 1.11.0
	 * @return array Array of menu
	 * @access public
	 */
	public function get_menus_list() {
		$menus = wp_get_nav_menus();

		$options = array();

		foreach ( $menus as $menu ) {
			$options[ $menu->slug ] = $menu->name;
		}

		return $options;
	}

	/**
	 * Render Menu HTML.
	 *
	 * @since 1.11.0
	 * @param array $settings The settings array.
	 * @param int   $node_id The node id.
	 * @return string menu HTML
	 * @access public
	 */
	public function get_menu_html( $settings ) {

		$menus = $this->get_menus_list();

		if ( ! empty( $menus ) ) {

			$args = array(
				'echo'        => false,
				'menu'        => $settings['exad_offcanvas_menu'],
				'menu_class'  => 'exad-offcanvas-menu',
				'fallback_cb' => '__return_empty_string',
				'container'   => '',
			);

			$menu_html = wp_nav_menu( $args );

			return $menu_html;
		}
	}

	protected function render() {
        $settings = $this->get_settings_for_display();
        $id = $this->get_id();
		
		$this->add_render_attribute(
			'exad_offcanvas',
			[
				'class'             	=> [ 'exad-offcanvas', 'exad-offcanvas-button-'.$settings['exad_offcanvas_button_position'] ],
				'data-esc_keypress'    	=> esc_attr( $settings['exad_offcanvas_close_esc_keypress'] ),
				'data-overlay_click'    => esc_attr( $settings['exad_offcanvas_close_overlay_click'] ),
				'data-custom_class'    	=> esc_attr( $settings['exad_offcanvas_custom_class'] ),
			]
		);

		$this->add_render_attribute( 
			'exad_offcanvas_content', 
			'class', ['exad-offcanvas-content', esc_attr( $settings['exad_offcanvas_position'] )] 
		);

		$this->add_render_attribute( 
			'exad_offcanvas_open_button_wrapper', 
			'class', [
				'exad-offcanvas-open-button-wrapper',
				esc_attr( $settings['exad_offcanvas_button_alignment'] ),
			] 
		);

		$this->add_render_attribute(
			'exad_offcanvas_content_inner',
			[
				'class'             		=> 'exad-offcanvas-content-inner',
				'data-appear_animation'    	=> esc_attr( $settings['exad_offcanvas_appear_animation'] ),
				'data-position'    	=> esc_attr( $settings['exad_offcanvas_position'] ),
			]
		);

    ?>
	<div <?php echo $this->get_render_attribute_string( 'exad_offcanvas' ); ?> data-offcanvas >
		<div <?php echo $this->get_render_attribute_string( 'exad_offcanvas_open_button_wrapper' ); ?> >
			<a class="exad-offcanvas-open-button <?php echo esc_attr( $settings['exad_offcanvas_button_text_icon_position'] ) ?>" href="#">
				<?php if ( 'button' === $settings['exad_offcanvas_button_type'] ) { ?>
					<?php if( 'before' === $settings['exad_offcanvas_button_text_icon_position'] ) { ?>
						<?php Icons_Manager::render_icon( $settings['exad_offcanvas_button_text_icon'], [ 'aria-hidden' => 'true' ] ); ?>
						<?php echo $settings[ 'exad_offcanvas_button_text' ]; ?>
					<?php } ?>
					<?php if( 'after' === $settings['exad_offcanvas_button_text_icon_position'] ) { ?>
						<?php echo $settings[ 'exad_offcanvas_button_text' ]; ?>
						<?php Icons_Manager::render_icon( $settings['exad_offcanvas_button_text_icon'], [ 'aria-hidden' => 'true' ] ); ?>
					<?php } ?>
				<?php } ?>
				<?php if ( 'icon' === $settings['exad_offcanvas_button_type'] ) { ?>
					<?php Icons_Manager::render_icon( $settings['exad_offcanvas_button_icon'], [ 'aria-hidden' => 'true' ] ); ?>
				<?php } ?>
			</a>
		</div>
        <div <?php echo $this->get_render_attribute_string( 'exad_offcanvas_content' ); ?>>
            <div <?php echo $this->get_render_attribute_string( 'exad_offcanvas_content_inner' ); ?> >
                <div class="exad-offcanvas-content-body">
                    <?php if( 'content' === $settings['exad_offcanvas_content_type'] ) : ?>
                        <?php echo wp_kses_post( $settings['exad_offcanvas_content'] ); ?>
					<?php endif; ?>
					<?php if( 'save_template' === $settings['exad_offcanvas_content_type'] ) : ?>
						<?php echo Plugin::$instance->frontend->get_builder_content_for_display( $settings['exad_offcanvas_save_template'] ); ?>
					<?php endif; ?>
					<?php if( 'menu' === $settings['exad_offcanvas_content_type'] ) : ?>
						<?php echo $this->get_menu_html( $settings ); ?>
					<?php endif; ?>
					<?php if( 'widgets' === $settings['exad_offcanvas_content_type'] ) : ?>
						<div class="exad-offcanvas-widget">
							<?php dynamic_sidebar( $settings['exad_offcanvas_widgets'] ); ?>
						</div>
					<?php endif; ?>
					<?php if( 'yes' === $settings['exad_offcanvas_show_close_button'] ) { ?>
						<a class="exad-offcanvas-close-button" href="#"><span></span></a>
					<?php } ?>
                </div>
            </div>
            <div class="exad-offcanvas-overlay"></div>
        </div>
    </div>
    <?php    
	}

}