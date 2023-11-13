<?php
namespace ExclusiveAddons\Elements;

if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.

use \Elementor\Widget_Base;
use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Border;
use \Elementor\Group_Control_Box_Shadow;
use \Elementor\Group_Control_Typography;
use \Elementor\Group_Control_Background;
use \ExclusiveAddons\Pro\Elementor\ProHelper;

class Gravity_Form extends Widget_Base {

	public function get_name() {
		return 'exad-gravity-form';
	}

	public function get_title() {
		return esc_html__( 'Gravity Form',  'exclusive-addons-elementor-pro' );
	}

	public function get_icon() {
		return 'exad exad-logo exad-gravity-form';
	}

	public function get_keywords() {
		return [ 'form', 'gravityform', 'contact form' ];
	}

	public function get_categories() {
		return [ 'exclusive-addons-elementor' ];
	}

	protected function register_controls() {

		if( ! class_exists( 'GFCommon' ) ) {
			$this->start_controls_section(
				'exad_gravity_from_panel_notice',
				[
					'label' => __('Notice!', 'exclusive-addons-elementor-pro'),
				]
			);

			$this->add_control(
				'exad_gravity_from_panel_notice_text',
				[
					'type'            => Controls_Manager::RAW_HTML,
					'raw'             => __('<strong>Gravity-Form</strong> is not installed/activated on your site. Please install and activate Gravity Form first.',
						'exclusive-addons-elementor-pro'),
					'content_classes' => 'exad-panel-notice',
				]
			);

			$this->end_controls_section();
			return;
		}

		$this->start_controls_section(
			'exad_gravity_form_content',
			[
				'label' => esc_html__( 'Gravity Form',  'exclusive-addons-elementor-pro' )
			]
		);

		$this->add_control(
			'exad_gravity_form_query',
			[
				'label' 		=> esc_html__( 'Select a Gravity Form', 'exclusive-addons-elementor-pro' ),
				'type' 			=> Controls_Manager::SELECT,
				'label_block' 	=> true,
				'default'       => 0,
				'options' 		=> ProHelper::exad_get_gravity_forms()
			]
		);

        $this->add_control(
            'exad_gravity_form_show_title',
            [
                'label'         => esc_html__( 'Title', 'exclusive-addons-elementor-pro' ),
                'type'          => Controls_Manager::SWITCHER,
				'label_on' 		=> __( 'Show', 'exclusive-addons-elementor-pro' ),
				'label_off'     => __( 'Hide', 'exclusive-addons-elementor-pro' ),               
                'default'       => 'yes',
                'return_value'  => 'yes'
            ]
        );

        $this->add_control(
            'exad_gravity_form_show_desc',
            [
                'label'         => esc_html__( 'Description', 'exclusive-addons-elementor-pro' ),
                'type'          => Controls_Manager::SWITCHER,
				'label_on' 		=> __( 'Show', 'exclusive-addons-elementor-pro' ),
				'label_off'     => __( 'Hide', 'exclusive-addons-elementor-pro' ),               
                'default'       => 'yes',
                'return_value'  => 'yes'
            ]
        ); 

        $this->add_control(
            'exad_gravity_form_show_field_desc',
            [
                'label'         => esc_html__( 'Field Description', 'exclusive-addons-elementor-pro' ),
                'type'          => Controls_Manager::SWITCHER,
				'label_on' 		=> __( 'Show', 'exclusive-addons-elementor-pro' ),
				'label_off'     => __( 'Hide', 'exclusive-addons-elementor-pro' ),               
                'default'       => 'yes',
                'return_value'  => 'yes'
            ]
        ); 

        $this->add_control(
            'exad_gravity_form_show_ajax',
            [
                'label'         => esc_html__( 'Use Ajax', 'exclusive-addons-elementor-pro' ),
                'type'          => Controls_Manager::SWITCHER,
				'label_on' 		=> __( 'Show', 'exclusive-addons-elementor-pro' ),
				'label_off'     => __( 'Hide', 'exclusive-addons-elementor-pro' ),               
                'default'       => 'no',
                'return_value'  => 'yes'
            ]
        );

        $this->add_control(
            'exad_gravity_form_show_placeholder',
            [
                'label'         => esc_html__( 'Placeholder', 'exclusive-addons-elementor-pro' ),
                'type'          => Controls_Manager::SWITCHER,
				'label_on' 		=> __( 'Show', 'exclusive-addons-elementor-pro' ),
				'label_off'     => __( 'Hide', 'exclusive-addons-elementor-pro' ),               
                'default'       => 'yes',
                'return_value'  => 'yes'
            ]
        );  

        $this->add_control(
            'exad_gravity_form_show_label',
            [
                'label'         => esc_html__( 'Label', 'exclusive-addons-elementor-pro' ),
                'type'          => Controls_Manager::SWITCHER,
				'label_on' 		=> __( 'Show', 'exclusive-addons-elementor-pro' ),
				'label_off'     => __( 'Hide', 'exclusive-addons-elementor-pro' ),               
                'default'       => 'yes',
                'return_value'  => 'yes'
            ]
        );    

        $this->add_control(
            'exad_gravity_form_show_error_messages',
            [
                'label'         => esc_html__( 'Error Messages', 'exclusive-addons-elementor-pro' ),
                'type'          => Controls_Manager::SWITCHER,
				'label_on' 		=> __( 'Show', 'exclusive-addons-elementor-pro' ),
				'label_off'     => __( 'Hide', 'exclusive-addons-elementor-pro' ),                
                'default'       => 'yes',
                'return_value'  => 'yes'
            ]
        );

        $this->add_control(
            'exad_gravity_form_show_validation_error_messages',
            [
                'label'         => esc_html__( 'Validation Errors Messages', 'exclusive-addons-elementor-pro' ),
                'type'          => Controls_Manager::SWITCHER,
				'label_on' 		=> __( 'Show', 'exclusive-addons-elementor-pro' ),
				'label_off'     => __( 'Hide', 'exclusive-addons-elementor-pro' ),               
                'default'       => 'yes',
                'return_value'  => 'yes'
            ]
        );

		$this->end_controls_section();	

		$this->start_controls_section(
			'exad_gravity_form_styles',
			[
				'label' => esc_html__( 'Form', 'exclusive-addons-elementor-pro' ),
				'tab'   => Controls_Manager::TAB_STYLE
			]
		);
		
		// $this->add_control(
		// 	'exad_gravity_form_background',
		// 	[
		// 		'label'     => esc_html__( 'Background Color', 'exclusive-addons-elementor-pro' ),
		// 		'type'      => Controls_Manager::COLOR,
		// 		'selectors' => [
		// 			'{{WRAPPER}} .exad-gravity-form' => 'background: {{VALUE}};'
		// 		]
		// 	]
		// );

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'exad_gravity_form_background',
				'label' => __( 'Background', 'exclusive-addons-elementor-pro' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .exad-gravity-form',
			]
		);
		
		$this->add_control(
			'exad_gravity_form_alignment',
			[
				'label'         => esc_html__( 'Alignment', 'exclusive-addons-elementor-pro' ),
				'type'          => Controls_Manager::CHOOSE,
				'toggle'        => false,
				'label_block'   => true,
				'default'       => 'default',
				'options' 		=> [
					'default' 	=> [
						'title' => __( 'Default', 'exclusive-addons-elementor-pro' ),
						'icon' 	=> 'eicon-ban'
					],
					'left' 		=> [
						'title' => esc_html__( 'Left', 'exclusive-addons-elementor-pro' ),
						'icon' 	=> 'eicon-text-align-left'
					],
					'center' 	=> [
						'title' => esc_html__( 'Center', 'exclusive-addons-elementor-pro' ),
						'icon' 	=> 'eicon-text-align-center'
					],
					'right' 	=> [
						'title' => esc_html__( 'Right', 'exclusive-addons-elementor-pro' ),
						'icon' 	=> 'eicon-text-align-right'
					]
				]
			]
		);

  		$this->add_responsive_control(
  			'exad_gravity_form_width',
  			[
  				'label' 		=> esc_html__( 'Width', 'exclusive-addons-elementor-pro' ),
  				'type' 			=> Controls_Manager::SLIDER,
				'size_units' 	=> [ 'px', 'em', '%' ],
				'range' 		=> [
					'px' 		=> [
						'min' 	=> 10,
						'max' 	=> 1500
					],
					'%'         => [
						'min'   => 0,
						'max'   => 100
					]
				],
				'selectors' 	=> [
					'{{WRAPPER}} .exad-gravity-form' => 'width: {{SIZE}}{{UNIT}};'
				]
  			]
  		);

  		$this->add_responsive_control(
  			'exad_gravity_form_max_width',
  			[
  				'label' 		=> esc_html__( 'Max Width', 'exclusive-addons-elementor-pro' ),
  				'type' 			=> Controls_Manager::SLIDER,
				'size_units' 	=> [ 'px', 'em', '%' ],
				'range' 		=> [
					'px' 		=> [
						'min' 	=> 10,
						'max' 	=> 1500
					],
					'%'         => [
						'min'   => 0,
						'max'   => 100
					]
				],
				'selectors'     => [
					'{{WRAPPER}} .exad-gravity-form' => 'max-width: {{SIZE}}{{UNIT}};'
				]
  			]
  		);		
		
		$this->add_responsive_control(
			'exad_gravity_form_margin',
			[
				'label' 		=> esc_html__( 'Margin', 'exclusive-addons-elementor-pro' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', 'em', '%' ],
				'selectors' 	=> [
					'{{WRAPPER}} .exad-gravity-form' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
		);		
		
		$this->add_responsive_control(
			'exad_gravity_form_padding',
			[
				'label' 		=> esc_html__( 'Padding', 'exclusive-addons-elementor-pro' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', 'em', '%' ],
				'selectors' 	=> [
					'{{WRAPPER}} .exad-gravity-form' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
		);		
		
		$this->add_responsive_control(
			'exad_gravity_form_border_radius',
			[
				'label' 		=> esc_html__( 'Border Radius', 'exclusive-addons-elementor-pro' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', 'em' ],
				'selectors' 	=> [
					'{{WRAPPER}} .exad-gravity-form' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
		);		
		
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'exad_gravity_form_border',
				'selector' => '{{WRAPPER}} .exad-gravity-form'
			]
		);		
		
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'exad_gravity_form_box_shadow',
				'selector' => '{{WRAPPER}} .exad-gravity-form'
			]
		);
		
		$this->end_controls_section();

        $this->start_controls_section(
            'exad_gravity_form_title_desc_style',
            [
				'label' => __( 'Title & Description', 'exclusive-addons-elementor-pro' ),
				'tab'   => Controls_Manager::TAB_STYLE
            ]
        );
        
        $this->add_responsive_control(
            'exad_gravity_form_title_alignment',
            [
                'label'         => __( 'Alignment', 'exclusive-addons-elementor-pro' ),
				'type'          => Controls_Manager::CHOOSE,
				'toggle'        => false,
				'default'       => '',
				'selectors'     => [
					'{{WRAPPER}} .exad-gravity-form .gform_wrapper .gform_heading' => 'text-align: {{VALUE}};'
				],
				'options' 		=> [
					'default' 	=> [
						'title' => __( 'Default', 'exclusive-addons-elementor-pro' ),
						'icon' 	=> 'eicon-ban'
					],
					'left' 		=> [
						'title' => esc_html__( 'Left', 'exclusive-addons-elementor-pro' ),
						'icon' 	=> 'eicon-text-align-left'
					],
					'center' 	=> [
						'title' => esc_html__( 'Center', 'exclusive-addons-elementor-pro' ),
						'icon' 	=> 'eicon-text-align-center'
					],
					'right' 	=> [
						'title' => esc_html__( 'Right', 'exclusive-addons-elementor-pro' ),
						'icon' 	=> 'eicon-text-align-right'
					]
				]
			]
		);
        
        $this->add_control(
            'exad_gravity_form_title',
            [
                'label'                 	=> __( 'Title', 'exclusive-addons-elementor-pro' ),
                'type'                  	=> Controls_Manager::HEADING,
				'separator'             	=> 'before',
                'condition'             	=> [
                    'exad_gravity_form_show_title' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'exad_gravity_form_title_color',
            [
                'label'                 	=> __( 'Color', 'exclusive-addons-elementor-pro' ),
                'type'                  	=> Controls_Manager::COLOR,
                'default'               	=> '',
                'selectors'             	=> [
                    '{{WRAPPER}} .exad-gravity-form .gform_wrapper .gform_title, {{WRAPPER}} .exad-gravity-form .exad-gravity-form-title' => 'color: {{VALUE}};'
                ],
                'condition'             	=> [
                    'exad_gravity_form_show_title' => 'yes'
                ]
            ]
        );
        
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'                  	=> 'exad_gravity_form_title_typography',
                'selector'              	=> '{{WRAPPER}} .exad-gravity-form .gform_wrapper .gform_title, {{WRAPPER}} .exad-gravity-form .exad-gravity-form-title',
                'condition'             	=> [
                    'exad_gravity_form_show_title' => 'yes'
                ]
            ]
        );
        
        $this->add_control(
            'exad_gravity_form_description',
            [
                'label'                 	=> __( 'Description', 'exclusive-addons-elementor-pro' ),
                'type'                  	=> Controls_Manager::HEADING,
				'separator'             	=> 'before',
                'condition'             	=> [
                    'exad_gravity_form_show_desc'  => 'yes'
                ]
            ]
        );

        $this->add_control(
            'exad_gravity_form_description_color',
            [
                'label'                 	=> __( 'Color', 'exclusive-addons-elementor-pro' ),
                'type'                  	=> Controls_Manager::COLOR,
                'default'               	=> '',
                'selectors'            		=> [
                    '{{WRAPPER}} .exad-gravity-form .gform_wrapper .gform_description, {{WRAPPER}} .exad-gravity-form .exad-gravity-form-description' => 'color: {{VALUE}};'
                ],
                'condition'             	=> [
                    'exad_gravity_form_show_desc' 	=> 'yes'
                ]
            ]
        );
        
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'                  	=> 'exad_gravity_form_description_typography',
                'selector'              	=> '{{WRAPPER}} .exad-gravity-form .gform_wrapper .gform_description, {{WRAPPER}} .exad-gravity-form .exad-gravity-form-description',
                'condition'             	=> [
                    'exad_gravity_form_show_desc' 	=> 'yes'
                ]
            ]
        );
        
        $this->end_controls_section();
        
		$this->start_controls_section(
			'exad_gravity_form_field_styles',
			[
				'label' 		=> esc_html__( 'Form Fields', 'exclusive-addons-elementor-pro' ),
				'tab' 			=> Controls_Manager::TAB_STYLE
			]
		);
		
		$this->add_control(
			'exad_gravity_form_input_background',
			[
				'label' 		=> esc_html__( 'Input Field Background', 'exclusive-addons-elementor-pro' ),
				'type' 			=> Controls_Manager::COLOR,
                'selectors'             => [
                    '{{WRAPPER}} .exad-gravity-form .gfield input[type="text"], {{WRAPPER}} .exad-gravity-form .gfield textarea, {{WRAPPER}} .exad-gravity-form .gfield select' => 'background-color: {{VALUE}};'
                ]
			]
		);		

		$this->add_responsive_control(
            'exad_gravity_form_field_gap',
            [
                'label'         => __( 'Field Gap', 'exclusive-addons-elementor-pro' ),
                'type'          => Controls_Manager::SLIDER,
                'range'         => [
                    'px'        => [
                        'min'   => 0,
                        'max'   => 100,
                        'step'  => 1
                    ],
                ],
                'default'       => [
					'unit'      => 'px',
					'size'      => 20
				],
                'size_units'    => [ 'px' ],
                'selectors'     => [
                    '{{WRAPPER}} .exad-gravity-form .gfield' => 'margin-bottom: {{SIZE}}{{UNIT}}'
                ]
            ]
		);
		
		$this->add_responsive_control(
            'exad_gravity_form_text_indent',
            [
                'label'         => __( 'Text Indent', 'exclusive-addons-elementor-pro' ),
                'type'          => Controls_Manager::SLIDER,
                'range'         => [
                    'px'        => [
                        'min'   => 0,
                        'max'   => 60,
                        'step'  => 1
                    ],
                    '%'         => [
                        'min'   => 0,
                        'max'   => 30,
                        'step'  => 1
                    ]
                ],
                'default'       => [
					'unit'      => 'px',
					'size'      => 5
				],
                'size_units'    => [ 'px', 'em', '%' ],
                'selectors'     => [
                    '{{WRAPPER}} .exad-gravity-form .gfield input[type="text"], {{WRAPPER}} .exad-gravity-form .gfield textarea, {{WRAPPER}} .exad-gravity-form .gfield select' => 'text-indent: {{SIZE}}{{UNIT}}'
                ]
            ]
        );

  		$this->add_responsive_control(
  			'exad_gravity_form_input_width',
  			[
  				'label' 		=> esc_html__( 'Input Width', 'exclusive-addons-elementor-pro' ),
  				'type' 			=> Controls_Manager::SLIDER,
				'size_units' 	=> [ 'px', 'em', '%' ],
				'range' 		=> [
					'px' 		=> [
						'min' 	=> 10,
						'max' 	=> 1500
					],
					'em' 		=> [
						'min' 	=> 1,
						'max' 	=> 80
					]
				],
				'selectors' 	=> [
					'{{WRAPPER}} .exad-gravity-form .gfield input[type="text"],{{WRAPPER}} .exad-gravity-form .gfield select' => 'width: {{SIZE}}{{UNIT}};'
				]
  			]
  		);
		
  		$this->add_responsive_control(
  			'exad_gravity_form_textarea_width',
  			[
  				'label' 		=> esc_html__( 'Textarea Width', 'exclusive-addons-elementor-pro' ),
  				'type' 			=> Controls_Manager::SLIDER,
				'size_units' 	=> [ 'px', 'em', '%' ],
				'range' 		=> [
					'px' 		=> [
						'min' 	=> 10,
						'max' 	=> 1500
					],
					'em' 		=> [
						'min' 	=> 1,
						'max' 	=> 80
					]
				],
				'selectors' 	=> [
					'{{WRAPPER}} .exad-gravity-form .gfield textarea' => 'width: {{SIZE}}{{UNIT}};'
				]
  			]
  		);	
		
		$this->add_responsive_control(
			'exad_gravity_form_input_padding',
			[
				'label' 		=> esc_html__( 'Fields Padding', 'exclusive-addons-elementor-pro' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', 'em', '%' ],
				'default'       => [
                    'top'       => 10,
                    'right'     => 0,
                    'bottom'    => 10,
                    'left'      => 0,
                    'unit'      => 'px',
                    'isLinked'  => false
                ],
				'selectors'     => [
					'{{WRAPPER}} .exad-gravity-form .gform_wrapper input:not([type=radio]):not([type=checkbox]):not([type=submit]):not([type=button]):not([type=image]):not([type=file]), {{WRAPPER}} .exad-gravity-form .gfield textarea, {{WRAPPER}} .exad-gravity-form .gfield select' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]				
			]
		);	
		
		$this->add_responsive_control(
			'exad_gravity_form_input_border_radius',
			[
				'label' 		=> esc_html__( 'Border Radius', 'exclusive-addons-elementor-pro' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px' ],
				'default'       => [
					'top'       => '0',
					'right'     => '0',
					'bottom'    => '0',
					'left'      => '0',
				],
				'selectors'     => [
					'{{WRAPPER}} .exad-gravity-form .gfield input[type="text"], {{WRAPPER}} .exad-gravity-form .gfield textarea, {{WRAPPER}} .exad-gravity-form .gfield select' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]				
			]
		);	

		$this->start_controls_tabs( 'exad_gravity_form_input_style_tab' );

	        $this->start_controls_tab(
	            'exad_gravity_form_input_normal_state',
	            [
	                'label'      => __( 'Normal', 'exclusive-addons-elementor-pro' )
	            ]
	        );

	        $this->add_control(
				'exad_gravity_form_field_color',
				[
					'label' 		=> esc_html__( 'Color', 'exclusive-addons-elementor-pro' ),
					'type' 			=> Controls_Manager::COLOR,
					'selectors' 	=> [
						'{{WRAPPER}} .exad-gravity-form .gfield input[type="text"], {{WRAPPER}} .exad-gravity-form .gfield textarea, {{WRAPPER}} .exad-gravity-form .gform_wrapper select, .exad-gravity-form .gform_wrapper .exad-gform-select::before' => 'color: {{VALUE}};'
					]
				]
			);
			
			$this->add_control(
				'exad_gravity_form_placeholder_color',
				[
					'label' 		=> esc_html__( 'Placeholder Color', 'exclusive-addons-elementor-pro' ),
					'type' 			=> Controls_Manager::COLOR,
					'condition'     => [
	                    'exad_gravity_form_show_placeholder' => 'yes'
	                ],				
					'selectors' 	=> [
						'{{WRAPPER}} .exad-gravity-form ::-webkit-input-placeholder' => 'color: {{VALUE}};',
						'{{WRAPPER}} .exad-gravity-form ::-moz-placeholder'          => 'color: {{VALUE}};',
						'{{WRAPPER}} .exad-gravity-form ::-ms-input-placeholder'     => 'color: {{VALUE}};'
					]
				]
			);		
			
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name' 			=> 'exad_gravity_form_input_field_typography',
					'selector' 		=> '{{WRAPPER}} .exad-gravity-form .gform_wrapper .gfield input[type="text"], {{WRAPPER}} .exad-gravity-form .gform_wrapper .gfield textarea, {{WRAPPER}} .exad-gravity-form .gform_wrapper select'
				]
			);
		
			$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name'            => 'exad_gravity_form_input_border',
					'fields_options'  => [
	                    'border' 	  => [
	                        'default' => 'solid'
	                    ],
	                    'width'  	  => [
	                        'default' 	 => [
	                            'top'    => '1',
	                            'right'  => '1',
	                            'bottom' => '1',
	                            'left'   => '1'
	                        ]
	                    ],
	                    'color' 	  => [
	                        'default' => 'rgba(104,104,104,0.88)'
	                    ]
	                ],
					'selector'        => '{{WRAPPER}} .exad-gravity-form .gfield input[type="text"], {{WRAPPER}} .exad-gravity-form .gfield textarea, {{WRAPPER}} .exad-gravity-form .gfield select'
				]
			);		
			
			$this->add_group_control(
				Group_Control_Box_Shadow::get_type(),
				[
					'name' 			=> 'exad_gravity_form_input_box_shadow',
					'selector'      => '{{WRAPPER}} .exad-gravity-form .gfield input[type="text"], {{WRAPPER}} .exad-gravity-form .gfield textarea, {{WRAPPER}} .exad-gravity-form .gfield select'			
				]
			);

			$this->end_controls_tab();

	        $this->start_controls_tab(
	            'exad_gravity_form_input_focus_state',
	            [
	                'label' => __( 'Focus', 'exclusive-addons-elementor-pro' )
	            ]
	        );

			$this->add_control(
				'exad_gravity_form_input_focus_color',
				[
					'label' 		=> esc_html__( 'Color', 'exclusive-addons-elementor-pro' ),
					'type' 			=> Controls_Manager::COLOR,
					'selectors' 	=> [
						'{{WRAPPER}} .exad-gravity-form .gfield input[type="text"]:focus, {{WRAPPER}} .exad-gravity-form .gfield textarea:focus, {{WRAPPER}} .exad-gravity-form .gform_wrapper select:focus, {{WRAPPER}} .exad-gravity-form input[type="text"]:focus::-webkit-input-placeholder, {{WRAPPER}} .exad-gravity-form .gfield textarea:focus::-webkit-input-placeholder' => 'color: {{VALUE}};'
					]
				]
			);

			$this->add_control(
				'exad_gravity_form_input_focus_background',
				[
					'label' 		=> esc_html__( 'Background', 'exclusive-addons-elementor-pro' ),
					'type' 			=> Controls_Manager::COLOR,
					'selectors' 	=> [
						'{{WRAPPER}} .exad-gravity-form .gfield input[type="text"]:focus, {{WRAPPER}} .exad-gravity-form .gfield textarea:focus' => 'background: {{VALUE}};'
					]
				]
			);	

			$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name' 			  => 'exad_gravity_form_input_focus_border',
					'fields_options'  => [
	                    'border' 	  => [
	                        'default' => 'solid'
	                    ],
	                    'color' 	  => [
	                        'default' => '#7a56ff'
	                    ]
	                ],
					'selector' 		  => '{{WRAPPER}} .exad-gravity-form .gfield input[type="text"]:focus, {{WRAPPER}} .exad-gravity-form .gfield textarea:focus, {{WRAPPER}} .exad-gravity-form .gfield select:focus'
				]
			);	

			$this->add_group_control(
				Group_Control_Box_Shadow::get_type(),
				[
					'name' 			=> 'exad_gravity_form_input_focus_box_shadow',
					'selector' 		=> '{{WRAPPER}} .exad-gravity-form .gfield input[type="text"]:focus, {{WRAPPER}} .exad-gravity-form .gfield textarea:focus'
				]
			);

			$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();	
		
		$this->start_controls_section(
			'exad_gravity_form_typography',
			[
				'label' 		=> esc_html__( 'Label', 'exclusive-addons-elementor-pro' ),
				'tab' 			=> Controls_Manager::TAB_STYLE,
				'condition'     => [
                    'exad_gravity_form_show_label' => 'yes'
                ]
			]
		);		

		$this->add_control(
			'exad_gravity_form_label_color',
			[
				'label' 		=> esc_html__( 'Color', 'exclusive-addons-elementor-pro' ),
				'type' 			=> Controls_Manager::COLOR,
				'selectors' 	=> [
					'{{WRAPPER}} .exad-gravity-form .gform_wrapper .top_label .gfield_label, {{WRAPPER}} .exad-gravity-form .gform_wrapper .field_sublabel_below .ginput_complex.ginput_container label' => 'color: {{VALUE}};'
				]
			]
		);

		$this->add_control(
			'exad_gravity_form_label_required_color',
			[
				'label' 		=> esc_html__( 'Required Asterisk Color', 'exclusive-addons-elementor-pro' ),
				'type' 			=> Controls_Manager::COLOR,
				'selectors' 	=> [
					'{{WRAPPER}} .exad-gravity-form .gform_wrapper .top_label span.gfield_required' => 'color: {{VALUE}};'
				]
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' 			=> 'exad_gravity_form_label_typography',			
				'selector' 		=> '{{WRAPPER}} .exad-gravity-form .gform_wrapper .top_label .gfield_label, {{WRAPPER}} .exad-gravity-form .gform_wrapper .field_sublabel_below .ginput_complex.ginput_container label'
			]
		);

		$this->add_responsive_control(
			'exad_gravity_form_label_margin',
			[
				'label' 	   => esc_html__( 'Label Margin', 'exclusive-addons-elementor-pro' ),
				'type' 		   => Controls_Manager::DIMENSIONS,
				'size_units'   => [ 'px', 'em', '%' ],
				'default'      => [
                    'top'      => '0',
                    'right'    => '0',
                    'bottom'   => '10',
                    'left'     => '0',
                    'unit'     => 'px',
                    'isLinked' => false
                ],
				'selectors'    => [
					'{{WRAPPER}} .exad-gravity-form .gform_wrapper .gfield_label' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
		);	

		$this->add_control(
            'exad_gravity_form_sub_label_style',
            [
				'label'     => esc_html__( 'Sub Label', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before'
            ]
        );

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'exad_gravity_form_sub_label_typography',
				'selector' => '{{WRAPPER}} .exad-gravity-form .gform_body .gfield .ginput_complex label'
			]
		);
		
		$this->add_responsive_control(
			'exad_gravity_form_sub_label_margin',
			[
				'label' 	   => esc_html__( 'Sub Label Margin', 'exclusive-addons-elementor-pro' ),
				'type' 		   => Controls_Manager::DIMENSIONS,
				'size_units'   => [ 'px', 'em', '%' ],
				'default'      => [
                    'top'      => '10',
                    'right'    => '0',
                    'bottom'   => '5',
                    'left'     => '0',
                    'unit'     => 'px',
                    'isLinked' => false
                ],
				'selectors'    => [
					'{{WRAPPER}} .exad-gravity-form .gform_body .gfield .ginput_complex label' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
		);	

		$this->end_controls_section();	

		$this->start_controls_section(
			'exad_gravity_form_radio_and_checkbox',
			[
				'label' 		=> esc_html__( 'Radio & Checkbox', 'exclusive-addons-elementor-pro' ),
				'tab' 			=> Controls_Manager::TAB_STYLE
			]
		);		

        $this->add_responsive_control(
            'exad_gravity_form_radio_and_checkbox_size',
            [
				'label'         => __( 'Size', 'exclusive-addons-elementor-pro' ),
				'type'          => Controls_Manager::SLIDER,
				'range'         => [
                    'px'        => [
                        'min'   => 10,
                        'max'   => 80,
                        'step'  => 1
                    ]
                ],
                'size_units'    => [ 'px', 'em', '%' ],
                'selectors'     => [
                    '{{WRAPPER}} .exad-gravity-form input[type="checkbox"], {{WRAPPER}} .exad-gravity-form input[type="radio"]' => 'width: {{SIZE}}{{UNIT}} !important; height: {{SIZE}}{{UNIT}} !important'
                ]
            ]
        );
        
        $this->start_controls_tabs( 'exad_gravity_form_radio_and_checkbox_style_tab' );

        $this->start_controls_tab(
            'exad_gravity_form_radio_and_checkbox_normal_state',
            [
                'label'          => __( 'Normal', 'exclusive-addons-elementor-pro' )
            ]
        );

        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' 			=> 'exad_gravity_form_radio_and_checkbox_label_typography',			
				'selector' 		=> '{{WRAPPER}} .exad-gravity-form .gform_wrapper ul.gfield_checkbox li input[type=checkbox]+label, {{WRAPPER}} .exad-gravity-form .gform_wrapper ul.gfield_radio li input[type=radio]+label'
			]
		);

        $this->add_control(
            'exad_gravity_form_radio_and_checkbox_color',
            [
                'label'          => __( 'Color', 'exclusive-addons-elementor-pro' ),
                'type'           => Controls_Manager::COLOR,
                'default'        => '',
                'selectors'      => [
                    '{{WRAPPER}} .exad-gravity-form input[type="checkbox"], {{WRAPPER}} .exad-gravity-form input[type="radio"]' => 'background: {{VALUE}}'
                ]
            ]
        );
        
        $this->add_responsive_control(
            'exad_gravity_form_radio_and_checkbox_border_width',
            [
                'label'         => __( 'Border Width', 'exclusive-addons-elementor-pro' ),
                'type'          => Controls_Manager::SLIDER,
                'range'         => [
                    'px'        => [
                        'min'   => 0,
                        'max'   => 25,
                        'step'  => 1
                    ]
                ],
                'size_units'    => [ 'px' ],
                'selectors'     => [
                    '{{WRAPPER}} .exad-gravity-form input[type="checkbox"], {{WRAPPER}} .exad-gravity-form input[type="radio"]' => 'border-width: {{SIZE}}{{UNIT}}'
                ]
            ]
        );

        $this->add_control(
            'exad_gravity_form_radio_and_checkbox_border_color',
            [
                'label'        => __( 'Border Color', 'exclusive-addons-elementor-pro' ),
                'type'         => Controls_Manager::COLOR,
                'default'      => '',
                'selectors'    => [
                    '{{WRAPPER}} .exad-gravity-form input[type="checkbox"], {{WRAPPER}} .exad-gravity-form input[type="radio"]' => 'border-color: {{VALUE}}'
                ]
            ]
        );
        
        $this->add_control(
            'exad_gravity_form_checkbox_heading',
            [
                'label'        => __( 'Checkbox', 'exclusive-addons-elementor-pro' ),
                'type'         => Controls_Manager::HEADING
            ]
        );

		$this->add_responsive_control(
			'exad_gravity_form_checkbox_border_radius',
			[
				'label'         => __( 'Border Radius', 'exclusive-addons-elementor-pro' ),
				'type'         	=> Controls_Manager::DIMENSIONS,
				'size_units'    => [ 'px', 'em', '%' ],
				'selectors'     => [
					'{{WRAPPER}} .exad-gravity-form input[type="checkbox"], {{WRAPPER}} .exad-gravity-form input[type="checkbox"]:before' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
		);
        
        $this->add_control(
            'exad_gravity_form_radio_heading',
            [
				'label' => __( 'Radio Buttons', 'exclusive-addons-elementor-pro' ),
				'type'  => Controls_Manager::HEADING
            ]
        );

		$this->add_responsive_control(
			'exad_gravity_form_radio_border_radius',
			[
				'label'         => __( 'Border Radius', 'exclusive-addons-elementor-pro' ),
				'type'          => Controls_Manager::DIMENSIONS,
				'size_units'    => [ 'px', 'em', '%' ],
				'selectors'     => [
					'{{WRAPPER}} .exad-gravity-form input[type="radio"], {{WRAPPER}} .exad-gravity-form input[type="radio"]:before' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
		);

        $this->end_controls_tab();

        $this->start_controls_tab(
            'exad_gravity_form_radio_checkbox_checked_state',
            [
                'label' => __( 'Checked', 'exclusive-addons-elementor-pro' )
            ]
        );

        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' 			=> 'exad_gravity_form_radio_and_checkbox_label_checked_typography',			
				'selector' 		=> '{{WRAPPER}} .exad-gravity-form .gform_wrapper ul.gfield_checkbox li input[type=checkbox]:checked+label, {{WRAPPER}} .exad-gravity-form .gform_wrapper ul.gfield_radio li input[type=radio]:checked+label'
			]
		);

        $this->add_control(
            'exad_gravity_form_radio_checkbox_color_checked',
            [
                'label'         => __( 'Color', 'exclusive-addons-elementor-pro' ),
                'type'          => Controls_Manager::COLOR,
                'default'       => '#7a56ff',
                'selectors'     => [
                    '{{WRAPPER}} .exad-gravity-form input[type="checkbox"]:checked:before, {{WRAPPER}} .exad-gravity-form input[type="radio"]:checked:before' => 'background: {{VALUE}};'
                ]
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

		$this->end_controls_section();
		
		$this->start_controls_section(
			'exad_gravity_form_dropdown',
			[
				'label' 		=> esc_html__( 'Dropdown', 'exclusive-addons-elementor-pro' ),
				'tab' 			=> Controls_Manager::TAB_STYLE
			]
		);	

		$this->add_responsive_control(
			'exad_gravity_form_dropdown_field_width',
			[
				'label' 		=> esc_html__( 'Dropdown Field Width', 'exclusive-addons-elementor-pro' ),
				'type' 			=> Controls_Manager::SLIDER,
				'size_units' 	=> [ 'px', '%' ],
				'range' 		=> [
					'px' 		=> [
						'min' 	=> 10,
						'max' 	=> 2000
					],
					'%' 		=> [
						'min' 	=> 1,
						'max' 	=> 100
					]
				],
				'selectors' 	=> [
					'{{WRAPPER}} .exad-gravity-form .gform_wrapper .exad-gform-select' => 'width: {{SIZE}}{{UNIT}};'
				]
			]
		);

		$this->add_responsive_control(
			'exad_gravity_form_dropdown_field_spacing',
			[
				'label' 		=> esc_html__( 'Dropdown Field Spacing', 'exclusive-addons-elementor-pro' ),
				'type' 			=> Controls_Manager::SLIDER,
				'size_units' 	=> [ 'px' ],
				'range' 		=> [
					'px' 		=> [
						'min' 	=> 0,
						'max' 	=> 100
					],
				],
				'selectors' 	=> [
					'{{WRAPPER}} .exad-gravity-form .gform_wrapper .exad-gform-select' => 'margin-right: {{SIZE}}{{UNIT}};'
				]
			]
		);

		$this->add_responsive_control(
			'exad_gravity_form_dropdown_icon_right_spacing',
			[
				'label' 		=> esc_html__( 'Dropdown Icon Right Spacing', 'exclusive-addons-elementor-pro' ),
				'type' 			=> Controls_Manager::SLIDER,
				'size_units' 	=> [ 'px' ],
				'range' 		=> [
					'px' 		=> [
						'min' 	=> 0,
						'max' 	=> 100
					],
				],
				'selectors' 	=> [
					'{{WRAPPER}} .exad-gravity-form .gform_wrapper .exad-gform-select::before' => 'right: {{SIZE}}{{UNIT}};'
				]
			]
		);

		$this->add_responsive_control(
			'exad_gravity_form_dropdown_icon_size',
			[
				'label' 		=> esc_html__( 'Dropdown Icon Size', 'exclusive-addons-elementor-pro' ),
				'type' 			=> Controls_Manager::SLIDER,
				'size_units' 	=> [ 'px' ],
				'range' 		=> [
					'px' 		=> [
						'min' 	=> 0,
						'max' 	=> 50
					],
				],
				'default'       => [
					'unit'      => 'px',
					'size'      => 20
				],
				'selectors' 	=> [
					'{{WRAPPER}} .exad-gravity-form .gform_wrapper .exad-gform-select::before' => 'font-size: {{SIZE}}{{UNIT}};'
				]
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'exad_gravity_form_submit_button_styles',
			[
				'label' 		=> esc_html__( 'Submit Button', 'exclusive-addons-elementor-pro' ),
				'tab' 			=> Controls_Manager::TAB_STYLE
			]
		);

  		$this->add_responsive_control(
  			'exad_gravity_form_submit_btn_width',
  			[
  				'label' 		=> esc_html__( 'Button Width', 'exclusive-addons-elementor-pro' ),
  				'type' 			=> Controls_Manager::SLIDER,
				'size_units' 	=> [ 'px', 'em', '%' ],
				'range' 		=> [
					'px' 		=> [
						'min' 	=> 10,
						'max' 	=> 1500
					],
					'em' 		=> [
						'min' 	=> 1,
						'max' 	=> 80
					]
				],
				'selectors' 	=> [
					'{{WRAPPER}} .exad-gravity-form .gform_wrapper .gform_footer input.button[type=submit]' => 'width: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .exad-gravity-form .gform_wrapper .gform-button' => 'width: {{SIZE}}{{UNIT}};'
				]
  			]
  		);
  		
		$this->add_control(
			'exad_gravity_form_submit_btn_alignment',
			[
				'label' 		=> esc_html__( 'Button Alignment', 'exclusive-addons-elementor-pro' ),
				'type' 			=> Controls_Manager::CHOOSE,
				'label_block' 	=> true,
				'toggle'        => false,
				'default' 		=> 'default',
				'options' 		=> [
					'default' 	=> [
						'title' => __( 'Default', 'exclusive-addons-elementor-pro' ),
						'icon' 	=> 'eicon-ban'
					],
					'left' 		=> [
						'title' => esc_html__( 'Left', 'exclusive-addons-elementor-pro' ),
						'icon' 	=> 'eicon-text-align-left'
					],
					'center' 	=> [
						'title' => esc_html__( 'Center', 'exclusive-addons-elementor-pro' ),
						'icon' 	=> 'eicon-text-align-center'
					],
					'right' 	=> [
						'title' => esc_html__( 'Right', 'exclusive-addons-elementor-pro' ),
						'icon' 	=> 'eicon-text-align-right'
					]
				]
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
             	'name' 			=> 'exad_gravity_form_submit_btn_typography',
				'selector' 		=> '{{WRAPPER}} .exad-gravity-form .gform_wrapper .gform_footer input.button[type=submit], {{WRAPPER}} .exad-gravity-form .gform_wrapper .gform-button',
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'           => 'exad_gravity_form_submit_btn_box_shadow',
				'selector'       => '{{WRAPPER}} .exad-gravity-form .gform_wrapper .gform_footer input.button[type=submit], {{WRAPPER}} .exad-gravity-form .gform_wrapper .gform-button',
				'fields_options' => [
                    'box_shadow_type' => [ 
                        'default'     =>'yes' 
                    ],
                    'box_shadow'  => [
                        'default' => [
                            'horizontal' => 0,
                            'vertical'   => 13,
                            'blur'       => 33,
                            'spread'     => 0,
                            'color'      => 'rgba(51, 77, 128, 0.2)'
                        ]
                    ]
                ]
			]
		);		

		$this->add_responsive_control(
			'exad_gravity_form_submit_btn_margin',
			[
				'label' 		=> esc_html__( 'Margin', 'exclusive-addons-elementor-pro' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', 'em', '%' ],
				'selectors' 	=> [
					'{{WRAPPER}} .exad-gravity-form .gform_wrapper .gform_footer input.button[type=submit]' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .exad-gravity-form .gform_wrapper .gform-button' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
		);	
		
		$this->add_responsive_control(
			'exad_gravity_form_submit_btn_padding',
			[
				'label' 	   => esc_html__( 'Padding', 'exclusive-addons-elementor-pro' ),
				'type' 		   => Controls_Manager::DIMENSIONS,
				'size_units'   => [ 'px', 'em', '%' ],
				'default'      => [
                    'top'      => '20',
                    'right'    => '50',
                    'bottom'   => '20',
                    'left'     => '50',
                    'unit'     => 'px',
                    'isLinked' => false
                ],
				'selectors'    => [
					'{{WRAPPER}} .exad-gravity-form .gform_wrapper .gform_footer input.button[type=submit]' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .exad-gravity-form .gform_wrapper .gform-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
		);		
		
		$this->start_controls_tabs( 'exad_gravity_form_submit_button_tabs' );

		$this->start_controls_tab( 'normal', [ 'label' => esc_html__( 'Normal', 'exclusive-addons-elementor-pro' ) ] );

		$this->add_control(
			'exad_gravity_form_submit_btn_text_color',
			[
				'label'     => esc_html__( 'Color', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .exad-gravity-form .gform_wrapper .gform_footer input.button[type=submit]' => 'color: {{VALUE}};',
					'{{WRAPPER}} .exad-gravity-form .gform_wrapper .gform-button' => 'color: {{VALUE}};'
				]
			]
		);

		$this->add_control(
			'exad_gravity_form_submit_btn_background_color',
			[
				'label'     => esc_html__( 'Background Color', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#7a56ff',
				'selectors' => [
					'{{WRAPPER}} .exad-gravity-form .gform_wrapper .gform_footer input.button[type=submit]' => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .exad-gravity-form .gform_wrapper .gform-button' => 'background-color: {{VALUE}};'
				]
			]
		);
		
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'           => 'exad_gravity_form_submit_btn_border',
				'fields_options' => [
                    'border' 	     => [
                        'default'    => 'solid'
                    ],
                    'width'  	     => [
                        'default' 	 => [
                            'top'    => '1',
                            'right'  => '1',
                            'bottom' => '1',
                            'left'   => '1'
                        ]
                    ],
                    'color' 	  => [
                        'default' => '#7a56ff'
                    ]
                ],
				'selector' 		  => '{{WRAPPER}} .exad-gravity-form .gform_wrapper .gform_footer input.button[type=submit], {{WRAPPER}} .exad-gravity-form .gform_wrapper .gform-button'
			]
		);

		$this->add_responsive_control(
            'exad_gravity_form_submit_btn_border_radius',
            [
				'label'        => __('Border Radius', 'exclusive-addons-elementor-pro'),
				'type'         => Controls_Manager::DIMENSIONS,
				'size_units'   => ['px', '%'],
				'default'      => [
					'top'      => '0',
					'right'    => '0',
					'bottom'   => '0',
					'left'     => '0',
					'isLinked' => false
				],
                'selectors'    => [
                    '{{WRAPPER}} .exad-gravity-form .gform_wrapper .gform_footer input.button[type=submit]' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .exad-gravity-form .gform_wrapper .gform-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );
		
		$this->end_controls_tab();

		$this->start_controls_tab( 'exad_gravity_form_submit_btn_hover', [ 'label' => esc_html__( 'Hover', 'exclusive-addons-elementor-pro' ) ] );

		$this->add_control(
			'exad_gravity_form_submit_btn_hover_text_color',
			[
				'label'     => esc_html__( 'Color', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#7a56ff',
				'selectors' => [
					'{{WRAPPER}} .exad-gravity-form .gform_wrapper .gform_footer input.button[type=submit]:hover' => 'color: {{VALUE}};',
					'{{WRAPPER}} .exad-gravity-form .gform_wrapper .gform-button:hover' => 'color: {{VALUE}};'
				]
			]
		);

		$this->add_control(
			'exad_gravity_form_submit_btn_hover_background_color',
			[
				'label'     => esc_html__( 'Background Color', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .exad-gravity-form .gform_wrapper .gform_footer input.button[type=submit]:hover' => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .exad-gravity-form .gform_wrapper .gform-button:hover' => 'background-color: {{VALUE}};'
				]
			]
		);

		$this->add_control(
			'exad_gravity_form_submit_btn_hover_border_color',
			[
				'label' 		=> esc_html__( 'Border Color', 'exclusive-addons-elementor-pro' ),
				'type' 			=> Controls_Manager::COLOR,
				'selectors' 	=> [
					'{{WRAPPER}} .exad-gravity-form .gform_wrapper .gform_footer input.button[type=submit]:hover' => 'border-color: {{VALUE}};',
					'{{WRAPPER}} .exad-gravity-form .gform_wrapper .gform-button:hover' => 'border-color: {{VALUE}};'
				]
			]
		);
		
		$this->end_controls_tab();
		
		$this->end_controls_tabs();
		
		$this->end_controls_section();

		$this->start_controls_section(
			'exad_gravity_form_field_description_styles',
			[
				'label' 		=> esc_html__( 'Field Description', 'exclusive-addons-elementor-pro' ),
				'tab' 			=> Controls_Manager::TAB_STYLE
			]
		);

		$this->add_control(
			'exad_gravity_form_field_description_text_color',
			[
				'label'     => esc_html__( 'Color', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .exad-gravity-form .gfield .gfield_description' => 'color: {{VALUE}};'
				]
			]
		);

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'          => 'exad_gravity_form_field_description_text_typography',
                'selector'      => '{{WRAPPER}} .exad-gravity-form .gfield .gfield_description'
            ]
        );

  		$this->add_responsive_control(
  			'exad_gravity_form_field_description_text_margin_top',
  			[
  				'label' 		=> esc_html__( 'Spacing', 'exclusive-addons-elementor-pro' ),
  				'type' 			=> Controls_Manager::SLIDER,
				'size_units' 	=> [ 'px', 'em', '%' ],
				'range' 		=> [
					'px' 		=> [
                        'min'   => 0,
                        'step'  => 1,
                        'max'   => 100
					]
				],
				'default'       => [
					'unit'      => 'px',
					'size'      => 10
				],
				'selectors' 	=> [
					'{{WRAPPER}} .exad-gravity-form .gfield .gfield_description' => 'padding-top: {{SIZE}}{{UNIT}};'
				]
  			]
  		);

		$this->end_controls_section();

		$this->start_controls_section(
            'exad_gravity_form_price_section_style',
            [
				'label' => __( 'Price', 'exclusive-addons-elementor-pro' ),
				'tab'   => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_control(
            'exad_gravity_form_price_label_color',
            [
				'label'     => __( 'Label Color', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
                    '{{WRAPPER}} .exad-gravity-form .gform_wrapper .ginput_product_price_label' => 'color: {{VALUE}}'
                ]
            ]
        );

        $this->add_control(
            'exad_gravity_form_price_text_color',
            [
				'label'     => __( 'Price Color', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
                    '{{WRAPPER}} .exad-gravity-form .gform_wrapper .ginput_product_price' => 'color: {{VALUE}}'
                ]
            ]
        );
        
        $this->end_controls_section();

		$this->start_controls_section(
			'exad_gravity_form_break_style',
			[
				'label' => __( 'Break', 'exclusive-addons-elementor-pro' ),
				'tab'   => Controls_Manager::TAB_STYLE
			]
		);

		$this->add_control(
			'exad_gravity_form_section_break_style',
			[
				'label' => __( 'Section Break', 'exclusive-addons-elementor-pro' ),
				'type'  => Controls_Manager::HEADING
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'exad_gravity_form_section_break_title_typography',
				'label'    => __( 'Title Typography', 'exclusive-addons-elementor-pro' ),
				'selector' => '{{WRAPPER}} .exad-gravity-form .gsection .gsection_title'
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'exad_gravity_form_section_break_description_typography',
				'label'    => __( 'Description Typography', 'exclusive-addons-elementor-pro' ),
				'selector' => '{{WRAPPER}} .exad-gravity-form  .gsection .gsection_description'
			]
		);

		$this->start_controls_tabs( 'exad_gravity_form_tabs_section_break_style' );

			$this->start_controls_tab( 'exad_gravity_form_section_break_title', [ 'label' => __( 'Title', 'exclusive-addons-elementor-pro' ) ] );

			$this->add_control(
				'exad_gravity_form_section_break_title_color',
				[
					'label'     => __( 'Color', 'exclusive-addons-elementor-pro' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .exad-gravity-form .gsection .gsection_title' => 'color: {{VALUE}};'
					]
				]
			);

			$this->end_controls_tab();

			$this->start_controls_tab(
				'exad_gravity_form_section_break_tab_description',
				[
					'label' => __( 'Description', 'exclusive-addons-elementor-pro' ),
				]
			);

			$this->add_control(
				'exad_gravity_form_section_break_description_color',
				[
					'label'     => __( 'Color', 'exclusive-addons-elementor-pro' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .exad-gravity-form .gsection .gsection_description' => 'color: {{VALUE}};'
					]
				]
			);

			$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_control(
			'exad_gravity_form_page_break',
			[
				'label'     => __( 'Page Break', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before'
			]
		);

		$this->add_control(
			'exad_gravity_form_page_break_progress_bar_color',
			[
				'label'     => __( 'Progress bar background Color', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .exad-gravity-form .gform_wrapper .percentbar_blue' => 'background-color: {{VALUE}};'
				]
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'exad_gravity_form_page_break_button_box_shadow',
				'label'    => __( 'Button Box Shadow', 'exclusive-addons-elementor-pro' ),
				'selector' => '{{WRAPPER}} .exad-gravity-form .gform_next_button.button, {{WRAPPER}} .exad-gravity-form .gform_previous_button.button'
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'exad_gravity_form_page_break_button_border',
				'selector' => '{{WRAPPER}} .exad-gravity-form .gform_next_button.button, {{WRAPPER}} .exad-gravity-form .gform_previous_button.button'
			]
		);

		$this->add_control(
			'exad_gravity_form_page_break_button_border_radius',
			[
				'label'      => __( 'Button Border Radius', 'exclusive-addons-elementor-pro' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .exad-gravity-form .gform_next_button.button'     => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .exad-gravity-form .gform_previous_button.button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
		);

		$this->start_controls_tabs( 'exad_gravity_form_page_break_tabs_button_style' );

		$this->start_controls_tab( 'exad_gravity_form_page_break_tab_button_normal', [ 'label' => __( 'Normal', 'exclusive-addons-elementor-pro' ) ] );

			$this->add_control(
				'exad_gravity_form_page_break_color',
				[
					'label'     => __( 'Color', 'exclusive-addons-elementor-pro' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => '',
					'selectors' => [
						'{{WRAPPER}} .exad-gravity-form .gform_next_button.button'     => 'color: {{VALUE}};',
						'{{WRAPPER}} .exad-gravity-form .gform_previous_button.button' => 'color: {{VALUE}};'
					]
				]
			);

			$this->add_control(
				'exad_gravity_form_page_break_bg_color',
				[
					'label'     => __( 'Background Color', 'exclusive-addons-elementor-pro' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .exad-gravity-form .gform_next_button.button'     => 'background-color: {{VALUE}};',
						'{{WRAPPER}} .exad-gravity-form .gform_previous_button.button' => 'background-color: {{VALUE}};'
					]
				]
			);

			$this->end_controls_tab();

			$this->start_controls_tab( 'exad_gravity_form_page_break_tab_button_hover', [ 'label' => __( 'Hover', 'exclusive-addons-elementor-pro' ) ] );

			$this->add_control(
				'exad_gravity_form_page_break_hover_color',
				[
					'label'     => __( 'Color', 'exclusive-addons-elementor-pro' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .exad-gravity-form .gform_next_button.button:hover'     => 'color: {{VALUE}};',
						'{{WRAPPER}} .exad-gravity-form .gform_next_button.button:focus'     => 'color: {{VALUE}};',
						'{{WRAPPER}} .exad-gravity-form .gform_previous_button.button:hover' => 'color: {{VALUE}};',
						'{{WRAPPER}} .exad-gravity-form .gform_previous_button.button:focus' => 'color: {{VALUE}};'
					]
				]
			);

			$this->add_control(
				'exad_gravity_form_page_break_hover_bg_color',
				[
					'label'     => __( 'Background Color', 'exclusive-addons-elementor-pro' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .exad-gravity-form .gform_next_button.button:hover'     => 'background-color: {{VALUE}};',
						'{{WRAPPER}} .exad-gravity-form .gform_next_button.button:focus'     => 'background-color: {{VALUE}};',
						'{{WRAPPER}} .exad-gravity-form .gform_previous_button.button:hover' => 'background-color: {{VALUE}};',
						'{{WRAPPER}} .exad-gravity-form .gform_previous_button.button:focus' => 'background-color: {{VALUE}};'
					]
				]
			);

			$this->add_control(
				'exad_gravity_form_page_break_hover_border_color',
				[
					'label'     => __( 'Border Color', 'exclusive-addons-elementor-pro' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .exad-gravity-form .gform_next_button.button:hover'     => 'border-color: {{VALUE}};',
						'{{WRAPPER}} .exad-gravity-form .gform_next_button.button:focus'     => 'border-color: {{VALUE}};',
						'{{WRAPPER}} .exad-gravity-form .gform_previous_button.button:hover' => 'border-color: {{VALUE}};',
						'{{WRAPPER}} .exad-gravity-form .gform_previous_button.button:focus' => 'border-color: {{VALUE}};'
					]
				]
			);

			$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		$this->start_controls_section(
			'exad_gravity_form_repeater_list',
			[
				'label' => __( 'List', 'exclusive-addons-elementor-pro' ),
				'tab'   => Controls_Manager::TAB_STYLE
			]
		);

		$this->add_control(
			'exad_gravity_form_repeater_list_odd_background_color',
			[
				'label'     => __( 'Background Color (Odd)', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'default'	=> 'rgba(0,0,0,0)',
				'selectors' => [
					'{{WRAPPER}} .exad-gravity-form .gfield_list .gfield_list_row_odd td' => 'background-color: {{VALUE}};'
				]
			]
		);

		$this->add_control(
			'exad_gravity_form_repeater_list_even_background_color',
			[
				'label'     => __( 'Background Color (Even)', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'default'	=> 'rgba(0,0,0,0)',
				'selectors' => [
					'{{WRAPPER}} .exad-gravity-form .gfield_list .gfield_list_row_even td' => 'background-color: {{VALUE}};'
				]
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'exad_gravity_form_error_styles',
			[
				'label' 		=> esc_html__( 'Errors', 'exclusive-addons-elementor-pro' ),
				'tab' 			=> Controls_Manager::TAB_STYLE
			]
		);

		$this->add_control(
			'exad_gravity_form_error_messages_heading',
			[
				'type' 			=> Controls_Manager::HEADING,
				'label' 		=> esc_html__( 'Error Messages', 'exclusive-addons-elementor-pro' ),
                'condition'     => [
                    '.exad_gravity_form_show_error_messages' => 'yes'
                ]
			]
		);

		$this->add_control(
			'exad_gravity_form_error_messages_text_color',
			[
				'label'     => esc_html__( 'Color', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .exad-gravity-form .gfield .validation_message' => 'color: {{VALUE}};'
				],
                'condition' => [
                    '.exad_gravity_form_show_error_messages' => 'yes'
                ]
			]
		);

  		$this->add_responsive_control(
  			'exad_gravity_form_error_messages_text_margin_top',
  			[
  				'label' 		=> esc_html__( 'Spacing', 'exclusive-addons-elementor-pro' ),
  				'type' 			=> Controls_Manager::SLIDER,
				'size_units' 	=> [ 'px', 'em', '%' ],
				'range' 		=> [
					'px' 		=> [
                        'min'   => 0,
                        'step'  => 1,
                        'max'   => 100
					]
				],
				'selectors' 	=> [
					'{{WRAPPER}} .exad-gravity-form .gfield .validation_message' => 'margin-top: {{SIZE}}{{UNIT}};'
				],
                'condition'     => [
                    '.exad_gravity_form_show_error_messages' => 'yes'
                ]
  			]
  		);

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'          => 'exad_gravity_form_error_messages_text_typography',
                'selector'      => '{{WRAPPER}} .exad-gravity-form .gfield .validation_message',
                'condition'     => [
                    '.exad_gravity_form_show_error_messages' => 'yes'
                ]
            ]
        );

		$this->add_control(
			'exad_gravity_form_validation_error_messages_heading',
			[
				'type' 			=> Controls_Manager::HEADING,
				'label' 		=> esc_html__( 'Validation Error Messages', 'exclusive-addons-elementor-pro' ),
				'separator'		=> 'after',
                'condition'     => [
                    '.exad_gravity_form_show_validation_error_messages' => 'yes'
                ]
			]
		);

		$this->add_control(
			'exad_gravity_form_validation_error_messages_text_color',
			[
				'label'     => esc_html__( 'Color', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .exad-gravity-form .gform_wrapper .validation_error' => 'color: {{VALUE}};'
				],
                'condition' => [
                    '.exad_gravity_form_show_validation_error_messages' => 'yes'
                ]
			]
		);

		$this->add_control(
			'exad_gravity_form_validation_error_messages_text_border_color',
			[
				'label'     => esc_html__( 'Border Color', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .exad-gravity-form .gform_wrapper .validation_error' => 'border-top-color: {{VALUE}};',
					'{{WRAPPER}} .exad-gravity-form .gform_wrapper .validation_error' => 'border-bottom-color: {{VALUE}};'
				],
                'condition' => [
                    '.exad_gravity_form_show_validation_error_messages' => 'yes'
                ]
			]
		);

		$this->add_control(
			'exad_gravity_form_validation_error_messages_text_bg_color',
			[
				'label'     => esc_html__( 'Background Color', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .exad-gravity-form .gform_wrapper .validation_error' => 'background-color: {{VALUE}};'
				],
                'condition' => [
                    '.exad_gravity_form_show_validation_error_messages' => 'yes'
                ]
			]
		);

  		$this->add_responsive_control(
  			'exad_gravity_form_validation_error_messages_text_margin_top',
  			[
  				'label' 		=> esc_html__( 'Spacing', 'exclusive-addons-elementor-pro' ),
  				'type' 			=> Controls_Manager::SLIDER,
				'size_units' 	=> [ 'px', 'em', '%' ],
				'range' 		=> [
					'px' 		=> [
                        'min'   => 0,
                        'step'  => 1,
                        'max'   => 100
					]
				],
				'selectors' 	=> [
					'{{WRAPPER}} .exad-gravity-form .gform_wrapper .validation_error' => 'margin-top: {{SIZE}}{{UNIT}};'
				],
                'condition'     => [
                    '.exad_gravity_form_show_validation_error_messages' => 'yes'
                ]
  			]
  		);

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'          => 'exad_gravity_form_validation_error_messages_text_typography',
                'selector'      => '{{WRAPPER}} .exad-gravity-form .gform_wrapper .validation_error',
                'condition'     => [
                    '.exad_gravity_form_show_validation_error_messages' => 'yes'
                ]
            ]
        );

        $this->add_group_control(
        Group_Control_Border::get_type(),
            [
				'name'        => 'exad_gravity_form_btn_border',
				'fields_options'     => [
                    'border' 	     => [
                        'default'    => 'solid'
                    ],
                    'width'  	     => [
                        'default' 	 => [
                            'top'    => '1',
                            'right'  => '0',
                            'bottom' => '1',
                            'left'   => '0'
                        ]
                    ],
                    'color' 	  => [
                        'default' => '#7a56ff'
                    ]
                ],               
				'selector'    => '{{WRAPPER}} .exad-gravity-form .gform_wrapper .validation_error',
                'condition'   => [
                    '.exad_gravity_form_show_validation_error_messages' => 'yes'
                ]
            ]
        );

		$this->end_controls_section();

		$this->start_controls_section(
			'exad_gravity_form_thank_u_message_style_tab',
			[
				'label' => esc_html__( 'Thank You Message', 'exclusive-addons-elementor-pro' ),
				'tab'   => Controls_Manager::TAB_STYLE
			]
		);

        $this->add_control(
            'exad_gravity_form_thank_u_message_text_color',
            [
				'label'     => __( 'Color', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
                    '{{WRAPPER}} .exad-gravity-form .gform_confirmation_wrapper .gform_confirmation_message' => 'color: {{VALUE}};'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
				'name'     => 'exad_gravity_form_thank_u_message_text_typography',
				'selector' => '{{WRAPPER}} .exad-gravity-form .gform_confirmation_wrapper .gform_confirmation_message'
            ]
        );

  		$this->add_responsive_control(
  			'exad_gravity_form_thank_u_message_text_margin_top',
  			[
  				'label' 		=> esc_html__( 'Spacing', 'exclusive-addons-elementor-pro' ),
  				'type' 			=> Controls_Manager::SLIDER,
				'size_units' 	=> [ 'px', 'em', '%' ],
				'range' 		=> [
					'px' 		=> [
                        'min'   => 0,
                        'step'  => 1,
                        'max'   => 100
					]
				],
				'selectors' 	=> [
					'{{WRAPPER}} .exad-gravity-form .gform_confirmation_wrapper .gform_confirmation_message' => 'margin-top: {{SIZE}}{{UNIT}};'
				]
  			]
  		);

		$this->end_controls_section();		
	}

	protected function render() {
		if( ! class_exists( 'GFCommon' ) ) { 
			return;
		}

		$settings     = $this->get_settings();
		$title        = $settings['exad_gravity_form_show_title'];
		$desc         = $settings['exad_gravity_form_show_desc'];
		$field_desc   = $settings['exad_gravity_form_show_field_desc'];
		$ajax         = $settings['exad_gravity_form_show_ajax'];
		$placeholder  = $settings['exad_gravity_form_show_placeholder'];
		$label        = $settings['exad_gravity_form_show_label'];
		$error        = $settings['exad_gravity_form_show_error_messages'];
		$valid        = $settings['exad_gravity_form_show_validation_error_messages'];		
		$contact_form = $settings['exad_gravity_form_query'];
		
		$title        = 'yes' === $title ? 'true' : 'false';
		$desc         = 'yes' === $desc ? 'true' : 'false';
		$ajax         = 'yes' === $ajax ? 'true' : 'false';
		$field_desc   = 'yes' !== $field_desc ? 'no' : '';
		$placeholder  = 'yes' !== $placeholder ? 'no' : '';
		$label        = 'yes' !== $label ? 'no' : '';
		$error        = 'yes' !== $error ? 'no' : '';
		$valid        = 'yes' !== $valid ? 'no' : '';

		$this->add_render_attribute(
			'exad_gravity_form_parameters',
			[
				'class' => [ 
					'exad-gravity-form', 
					'form-align-'.esc_attr( $settings['exad_gravity_form_alignment'] ),
					'button-align-'.esc_attr( $settings['exad_gravity_form_submit_btn_alignment'] ),
					'placeholder-'.esc_attr( $placeholder ),
					'label-'.esc_attr( $label ),
					'field-desc-'.esc_attr( $field_desc ),
					'show-error-'.esc_attr( $error ),
					'show-valid-'.esc_attr( $valid )
				]
			]
		);

	    if( $contact_form ){ ?>
	    	<div <?php echo $this->get_render_attribute_string( 'exad_gravity_form_parameters' ); ?>>
		     	<?php echo do_shortcode( '[gravityform id="'.esc_attr( $contact_form ).'" title="'.esc_attr( $title ).'" description="'.esc_attr( $desc ).'" ajax="'.esc_attr( $ajax ).'"]' ); ?>
		    </div>
		<?php
	    }
	}
}