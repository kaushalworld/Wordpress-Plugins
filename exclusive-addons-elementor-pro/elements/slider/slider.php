<?php
namespace ExclusiveAddons\Elements;

if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.

use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Border;
use \Elementor\Repeater;
use \Elementor\Group_Control_Box_Shadow;
use \Elementor\Group_Control_Typography;
use \Elementor\Widget_Base;
use \Elementor\Group_Control_Background;
use \Elementor\Utils;
use \ExclusiveAddons\Elementor\Helper;


class Slider extends Widget_Base {
	
	public function get_name() {
		return 'exad-exclusive-slider';
	}
	public function get_title() {
		return esc_html__( 'Slider', 'exclusive-addons-elementor-pro' );
	}
	public function get_icon() {
		return 'exad exad-logo exad-slider';
	}
	public function get_categories() {
		return [ 'exclusive-addons-elementor' ];
	}

	public function get_keywords() {
	    return [ 'slides', 'carousel', 'image', 'slider', 'gallery' ];
	}

    public function get_script_depends() {
        return [ 'exad-slick', 'exad-slick-animation' ];
    }

    protected function register_controls() {

		$this->start_controls_section(
			'exad_slider_items',
			[
				'label' => __( 'Slides', 'exclusive-addons-elementor-pro' )
			]
		);

 		$sliderItem = new Repeater();

        $sliderItem->start_controls_tabs( 'exad_slider_item' );

        $sliderItem->start_controls_tab( 'exad_slider_background', [ 'label' => __( 'Background', 'exclusive-addons-elementor-pro' ) ] );

		$sliderItem->add_control(
			'exad_slider_bg',
			[
				'label'     => __( 'Color', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#7a56ff',
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .exad-slide-bg' => 'background-color: {{VALUE}};'
				]
			]
		);

        $sliderItem->add_control(
            'exad_slider_img',
            [
                'label'     => __( 'Image', 'exclusive-addons-elementor-pro' ),
                'type'      => Controls_Manager::MEDIA,
                'dynamic' => [
					'active' => true,
				],
                'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .exad-slide-bg' => 'background-image: url({{URL}})'
				]
            ]
        );

        $sliderItem->add_control(
			'exad_slider_img_size',
			[
				'label' => __( 'Background Position', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'cover',
				'options' => [
					'auto'  => __( 'Auto', 'exclusive-addons-elementor-pro' ),
					'contain'  => __( 'Contain', 'exclusive-addons-elementor-pro' ),
					'cover'  => __( 'Cover', 'exclusive-addons-elementor-pro' ),
                ],
                'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .exad-slide-bg' => 'background-size: {{VALUE}}'
				]
			]
        );
        
        $sliderItem->add_control(
			'exad_slider_img_position_offset',
			[
				'label' => __( 'Background Custom Position', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::POPOVER_TOGGLE,
				'label_off' => __( 'Default', 'exclusive-addons-elementor-pro' ),
				'label_on' => __( 'Custom', 'exclusive-addons-elementor-pro' ),
				'return_value' => 'yes',
                'default' => 'yes',
			]
        );
        
        $sliderItem->start_popover();

            $sliderItem->add_control(
                'exad_slider_img_position_x_offset',
                [
                    'label' => __( 'X Offset', 'exclusive-addons-elementor-pro' ),
                    'type' => Controls_Manager::SLIDER,
                    'size_units' => [ 'px', '%' ],
                    'range' => [
                        'px' => [
                            'min' => -3000,
                            'max' => 3000,
                        ],
                        '%' => [
                            'min' => -100,
                            'max' => 100,
                        ],
                    ],
                    'default' => [
                        'unit' => '%',
                        'size' => 50,
                    ],
                    'selectors' => [
                        '{{WRAPPER}} {{CURRENT_ITEM}} .exad-slide-bg' => 'background-position-x: {{SIZE}}{{UNIT}}'
                    ],
                ]
            );

            $sliderItem->add_control(
                'exad_slider_img_position_y_offset',
                [
                    'label' => __( 'Y Offset', 'exclusive-addons-elementor-pro' ),
                    'type' => Controls_Manager::SLIDER,
                    'size_units' => [ 'px', '%' ],
                    'range' => [
                        'px' => [
                            'min' => -3000,
                            'max' => 3000,
                        ],
                        '%' => [
                            'min' => -100,
                            'max' => 100,
                        ],
                    ],
                    'default' => [
                        'unit' => '%',
                        'size' => 50,
                    ],
                    'selectors' => [
                        '{{WRAPPER}} {{CURRENT_ITEM}} .exad-slide-bg' => 'background-position-y: {{SIZE}}{{UNIT}}'
                    ],
                ]
            );

        $sliderItem->end_popover();

        $sliderItem->add_control(
            'exad_slider_bg_overlay',
            [
                'label'        => __( 'Background Overlay', 'exclusive-addons-elementor-pro' ),
                'type'         => Controls_Manager::SWITCHER,
                'default'      => 'no',
                'return_value' => 'yes'
            ]
        );

        $sliderItem->add_control(
            'exad_slider_bg_overlay_color',
            [
                'label'      => __( 'Color', 'exclusive-addons-elementor-pro' ),
                'type'       => Controls_Manager::COLOR,
                'default'    => 'rgba(0,0,0,0.5)',
                'conditions' => [
                    'terms'  => [
                        [
                            'name'  => 'exad_slider_bg_overlay',
                            'value' => 'yes'
                        ]
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}} .exad-slider-bg-overlay' => 'background-color: {{VALUE}};'
                ]
            ]
        );

        $sliderItem->end_controls_tab();

        $sliderItem->start_controls_tab( 'exad_slider_content', [ 'label' => __( 'Content', 'exclusive-addons-elementor-pro' ) ] );

        $sliderItem->add_control(
            'exad_slider_title',
            [
                'label'         => __( 'Title', 'exclusive-addons-elementor-pro' ),
                'type'          => Controls_Manager::TEXT,
                'dynamic'       => [ 'active' => true ],
                'label_block'   => true,
                'default'       => __( 'Exclusive Addon Slider Title...', 'exclusive-addons-elementor-pro' )
            ]
        );

        $sliderItem->add_control(
            'exad_slider_details',
            [
                'label'         => __( 'Details', 'exclusive-addons-elementor-pro' ),
                'type'          => Controls_Manager::TEXTAREA,
                'dynamic'       => [ 'active' => true ],
                'default'       => __( 'Lorem Ipsum is simply dummy text of the printing and typesetting industry.', 'exclusive-addons-elementor-pro' )
            ]
        );

        $sliderItem->add_control(
            'exad_slider_button_text',
            [
                'label'         => __( 'Button Text', 'exclusive-addons-elementor-pro' ),
                'type'          => Controls_Manager::TEXT,
                'dynamic'       => [ 'active' => true ],
                'default'       => __( 'READ MORE', 'exclusive-addons-elementor-pro' )
            ]
        );

        $sliderItem->add_control(
            'exad_slider_button_url',
            [
                'label'           => __( 'Link', 'exclusive-addons-elementor-pro' ),
                'type'            => Controls_Manager::URL,
                'dynamic'       => [ 'active' => true ],
                'label_block'     => true,
                'show_external'   => true,
				'default' 		  => [
					'url'         => '#',
					'is_external' => true
				],
                'placeholder'     => __( 'http://your-link.com', 'exclusive-addons-elementor-pro' )
            ]
        );

        $sliderItem->end_controls_tab();

        $sliderItem->start_controls_tab( 'style', [ 'label' => __( 'Style', 'exclusive-addons-elementor-pro' ) ] );

        // custom style for single slide item
        $sliderItem->add_control(
            'exad_single_slider_custom_style',
            [
                'label'         => __( 'Custom', 'exclusive-addons-elementor-pro' ),
                'type'          => Controls_Manager::SWITCHER,
                'return_value'  => 'yes',
                'description'   => __( 'Set custom style that will only affect this specific slide item.', 'exclusive-addons-elementor-pro' )
            ]
        );		

        $sliderItem->add_control(
            'exad_single_slider_title_position',
            [
                'label'     => esc_html__( 'Position', 'exclusive-addons-elementor-pro' ),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
                'condition' => [
                    'exad_single_slider_custom_style' => 'yes'
                ]
            ]
        );

		$sliderItem->add_responsive_control(
	        'exad_single_slider_horizontal_position',
	        [
	            'label'          => __( 'Horizontal Position', 'exclusive-addons-elementor-pro' ),
	            'type'           => Controls_Manager::CHOOSE,
                'toggle'         => false,
	            'label_block'    => false,
	            'options'        => [
	                'flex-start' => [
	                    'title'  => __( 'Left', 'exclusive-addons-elementor-pro' ),
	                    'icon'   => 'eicon-h-align-left'
	                ],
	                'center'     => [
	                    'title'  => __( 'Center', 'exclusive-addons-elementor-pro' ),
	                    'icon'   => 'eicon-h-align-center'
	                ],
	                'flex-end'   => [
	                    'title'  => __( 'Right', 'exclusive-addons-elementor-pro' ),
	                    'icon'   => 'eicon-h-align-right'
	                ]
	            ],
	            'selectors'      => [
	                '{{WRAPPER}} .exad-slider {{CURRENT_ITEM}} .exad-slide-inner' => 'justify-content: {{VALUE}}; -webkit-justify-content: {{VALUE}};'
	            ],
	            'condition'      => [
	                'exad_single_slider_custom_style' => 'yes'
	            ]
	        ]
	    );

        $sliderItem->add_responsive_control(
         	'exad_single_slider_vertical_position',
         	[
             	'label'          => __( 'Vertical Position', 'exclusive-addons-elementor-pro' ),
             	'type'           => Controls_Manager::CHOOSE,
                'toggle'         => false,
             	'label_block'    => false,
             	'options'        => [
	                'flex-start' => [
	                    'title'  => __( 'Top', 'exclusive-addons-elementor-pro' ),
	                    'icon'   => 'eicon-v-align-top'
	                ],
	                'center'     => [
	                    'title'  => __( 'Middle', 'exclusive-addons-elementor-pro' ),
	                    'icon'   => 'eicon-v-align-middle'
	                ],
	                'flex-end'   => [
	                    'title'  => __( 'Bottom', 'exclusive-addons-elementor-pro' ),
	                    'icon'   => 'eicon-v-align-bottom'
	                ]
	            ],
	            'selectors'      => [
	                '{{WRAPPER}} .exad-slider {{CURRENT_ITEM}} .exad-slide-inner' => 'align-items: {{VALUE}}; -webkit-align-items: {{VALUE}};'
	            ],
	            'condition'      => [
	                'exad_single_slider_custom_style' => 'yes'
	            ]
	        ]
        );

		$sliderItem->add_responsive_control(
			'exad_single_slider_text_align',
			[
				'label'         => __( 'Text Align', 'exclusive-addons-elementor-pro' ),
				'type'          => Controls_Manager::CHOOSE,
                'toggle'        => false,
				'label_block'   => false,
                'options'       => [
                    'left'      => [
                        'title' => esc_html__( 'Left', 'exclusive-addons-elementor-pro' ),
                        'icon'  => 'eicon-text-align-left'
                    ],
                    'center'    => [
                        'title' => esc_html__( 'Center', 'exclusive-addons-elementor-pro' ),
                        'icon'  => 'eicon-text-align-center'
                    ],
                    'right'     => [
                        'title' => esc_html__( 'Right', 'exclusive-addons-elementor-pro' ),
                        'icon'  => 'eicon-text-align-right'
                    ]
                ],
				'selectors'     => [
					'{{WRAPPER}} .exad-slider {{CURRENT_ITEM}} .exad-slide-inner' => 'text-align: {{VALUE}};'
				],
	            'condition'     => [
	                'exad_single_slider_custom_style' => 'yes'
	            ]
			]
		);

        $sliderItem->add_control(
            'exad_single_slider_animation',
            [
                'label'     => esc_html__( 'Animation', 'exclusive-addons-elementor-pro' ),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
                'condition' => [
                    'exad_single_slider_custom_style' => 'yes'
                ]
            ]
        );

        $sliderItem->add_control(
            'exad_single_slider_title_animation',
            [
                'label'     => esc_html__( 'Title', 'exclusive-addons-elementor-pro' ),
                'type'      => Controls_Manager::HEADING,
                'condition' => [
                    'exad_single_slider_custom_style' => 'yes'
                ]
            ]
        );

  		$sliderItem->add_control(
            'exad_single_slider_title_animation_in',
            [
                'label'            => __( 'Animation In', 'exclusive-addons-elementor-pro' ),
                'type'             => Controls_Manager::SELECT,
                'default'          => 'default',
                'options'          => [
                    ''             => __('None', 'exclusive-addons-elementor-pro'),
                    'default'      => __('Default', 'exclusive-addons-elementor-pro'),
                    'fadeIn'       => __('fadeIn', 'exclusive-addons-elementor-pro'),
                    'fadeInUp'     => __('fadeInUp', 'exclusive-addons-elementor-pro'),
                    'fadeInDown'   => __('fadeInDown', 'exclusive-addons-elementor-pro'),
                    'fadeInLeft'   => __('fadeInLeft', 'exclusive-addons-elementor-pro'),
                    'fadeInRight'  => __('fadeInRight', 'exclusive-addons-elementor-pro'),
                    'slideInUp'    => __('slideInUp', 'exclusive-addons-elementor-pro'),
                    'slideInDown'  => __('slideInDown', 'exclusive-addons-elementor-pro'),
                    'slideInLeft'  => __('slideInLeft', 'exclusive-addons-elementor-pro'),
                    'slideInRight' => __('slideInRight', 'exclusive-addons-elementor-pro')
                ],
                'condition'        => [
                    'exad_single_slider_custom_style' => 'yes'
                ]
            ]
        );

        $sliderItem->add_control(
            'exad_single_slider_title_animation_out',
            [
                'label'             => __( 'Animation Out', 'exclusive-addons-elementor-pro' ),
                'type'              => Controls_Manager::SELECT,
                'default'           => 'default',
                'options'           => [
                    ''              => __('None', 'exclusive-addons-elementor-pro'),
                    'default'       => __('Default', 'exclusive-addons-elementor-pro'),
                    'fadeOut'       => __('fadeOut', 'exclusive-addons-elementor-pro'),
                    'fadeOutUp'     => __('fadeOutUp', 'exclusive-addons-elementor-pro'),
                    'fadeOutDown'   => __('fadeOutDown', 'exclusive-addons-elementor-pro'),
                    'fadeOutLeft'   => __('fadeOutLeft', 'exclusive-addons-elementor-pro'),
                    'fadeOutRight'  => __('fadeOutRight', 'exclusive-addons-elementor-pro'),
                    'slideOutUp'    => __('slideOutUp', 'exclusive-addons-elementor-pro'),
                    'slideOutDown'  => __('slideOutDown', 'exclusive-addons-elementor-pro'),
                    'slideOutLeft'  => __('slideOutLeft', 'exclusive-addons-elementor-pro'),
                    'slideOutRight' => __('slideOutRight', 'exclusive-addons-elementor-pro')
                ],
                'condition'         => [
                    'exad_single_slider_custom_style' => 'yes'
                ]
            ]
        );

        $sliderItem->add_control(
            'exad_single_slider_title_animation_delay_in',
            [
                'label'         => __( 'Delay In', 'exclusive-addons-elementor-pro' ),
                'type'          => Controls_Manager::SLIDER,
                'range'         => [
                    'px'        => [
                        'min'   => 0,
                        'max'   => 1,
                        'step'  => .1
                    ]
                ],
                'condition'     => [
                    'exad_single_slider_custom_style' => 'yes'
                ]  
            ]
        ); 

        $sliderItem->add_control(
            'exad_single_slider_title_animation_duration_in',
            [
                'label'         => __( 'Duration In(second)', 'exclusive-addons-elementor-pro' ),
                'type'          => Controls_Manager::SLIDER,
                'range'         => [
                    'px'        => [
                        'min'   => 0,
                        'max'   => 1,
                        'step'  => .1
                    ]
                ],
                'condition'     => [
                    'exad_single_slider_custom_style' => 'yes'
                ]  
            ]
        );

        $sliderItem->add_control(
            'exad_single_slider_title_animation_duration_out',
            [
                'label'         => __( 'Duration Out(second)', 'exclusive-addons-elementor-pro' ),
                'type'          => Controls_Manager::SLIDER,
                'range'         => [
                    'px'        => [
                        'min'   => 0,
                        'max'   => 1,
                        'step'  => .1
                    ]
                ],
                'condition'     => [
                    'exad_single_slider_custom_style' => 'yes'
                ]  
            ]
        );

        $sliderItem->add_control(
            'exad_single_slider_details_animation',
            [
                'label'     => esc_html__( 'Details', 'exclusive-addons-elementor-pro' ),
                'type'      => Controls_Manager::HEADING,
                'condition' => [
                    'exad_single_slider_custom_style' => 'yes'
                ]
            ]
        );

        $sliderItem->add_control(
            'exad_single_slider_details_animation_in',
            [
                'label'            => __( 'Animation In', 'exclusive-addons-elementor-pro' ),
                'type'             => Controls_Manager::SELECT,
                'default'          => 'default',
                'options'          => [
                    ''             => __('None', 'exclusive-addons-elementor-pro'),
                    'default'      => __('Default', 'exclusive-addons-elementor-pro'),
                    'fadeIn'       => __('fadeIn', 'exclusive-addons-elementor-pro'),
                    'fadeInUp'     => __('fadeInUp', 'exclusive-addons-elementor-pro'),
                    'fadeInDown'   => __('fadeInDown', 'exclusive-addons-elementor-pro'),
                    'fadeInLeft'   => __('fadeInLeft', 'exclusive-addons-elementor-pro'),
                    'fadeInRight'  => __('fadeInRight', 'exclusive-addons-elementor-pro'),
                    'slideInUp'    => __('slideInUp', 'exclusive-addons-elementor-pro'),
                    'slideInDown'  => __('slideInDown', 'exclusive-addons-elementor-pro'),
                    'slideInLeft'  => __('slideInLeft', 'exclusive-addons-elementor-pro'),
                    'slideInRight' => __('slideInRight', 'exclusive-addons-elementor-pro')
                ],
                'condition'        => [
                    'exad_single_slider_custom_style' => 'yes'
                ]
            ]
        );

        $sliderItem->add_control(
            'exad_single_slider_details_animation_out',
            [
                'label'             => __( 'Animation Out', 'exclusive-addons-elementor-pro' ),
                'type'              => Controls_Manager::SELECT,
                'default'           => 'default',
                'options'           => [
                    ''              => __('None', 'exclusive-addons-elementor-pro'),
                    'default'       => __('Default', 'exclusive-addons-elementor-pro'),
                    'fadeOut'       => __('fadeOut', 'exclusive-addons-elementor-pro'),
                    'fadeOutUp'     => __('fadeOutUp', 'exclusive-addons-elementor-pro'),
                    'fadeOutDown'   => __('fadeOutDown', 'exclusive-addons-elementor-pro'),
                    'fadeOutLeft'   => __('fadeOutLeft', 'exclusive-addons-elementor-pro'),
                    'fadeOutRight'  => __('fadeOutRight', 'exclusive-addons-elementor-pro'),
                    'slideOutUp'    => __('slideOutUp', 'exclusive-addons-elementor-pro'),
                    'slideOutDown'  => __('slideOutDown', 'exclusive-addons-elementor-pro'),
                    'slideOutLeft'  => __('slideOutLeft', 'exclusive-addons-elementor-pro'),
                    'slideOutRight' => __('slideOutRight', 'exclusive-addons-elementor-pro')
                ],
                'condition'         => [
                    'exad_single_slider_custom_style' => 'yes'
                ]
            ]
        );

        $sliderItem->add_control(
            'exad_single_slider_details_animation_delay_in',
            [
                'label'         => __( 'Delay In', 'exclusive-addons-elementor-pro' ),
                'type'          => Controls_Manager::SLIDER,
                'range'         => [
                    'px'        => [
                        'min'   => 0,
                        'max'   => 1,
                        'step'  => .1
                    ]
                ],
                'condition'     => [
                    'exad_single_slider_custom_style' => 'yes'
                ]  
            ]
        ); 

        $sliderItem->add_control(
            'exad_single_slider_details_animation_duration_in',
            [
                'label'         => __( 'Duration In(second)', 'exclusive-addons-elementor-pro' ),
                'type'          => Controls_Manager::SLIDER,
                'range'         => [
                    'px'        => [
                        'min'   => 0,
                        'max'   => 1,
                        'step'  => .1
                    ]
                ],
                'condition'     => [
                    'exad_single_slider_custom_style' => 'yes'
                ]  
            ]
        );

        $sliderItem->add_control(
            'exad_single_slider_details_animation_duration_out',
            [
                'label'         => __( 'Duration Out(second)', 'exclusive-addons-elementor-pro' ),
                'type'          => Controls_Manager::SLIDER,
                'range'         => [
                    'px'        => [
                        'min'   => 0,
                        'max'   => 1,
                        'step'  => .1
                    ]
                ],
                'condition'     => [
                    'exad_single_slider_custom_style' => 'yes'
                ]  
            ]
        );

        $sliderItem->add_control(
            'exad_single_slider_button_animation',
            [
                'label'     => esc_html__( 'Button', 'exclusive-addons-elementor-pro' ),
                'type'      => Controls_Manager::HEADING,
                'condition' => [
                    'exad_single_slider_custom_style' => 'yes'
                ]
            ]
        );

        $sliderItem->add_control(
            'exad_single_slider_button_animation_in',
            [
                'label'            => __( 'Animation In', 'exclusive-addons-elementor-pro' ),
                'type'             => Controls_Manager::SELECT,
                'default'          => 'default',
                'options'          => [
                    ''             => __('None', 'exclusive-addons-elementor-pro'),
                    'default'      => __('Default', 'exclusive-addons-elementor-pro'),
                    'fadeIn'       => __('fadeIn', 'exclusive-addons-elementor-pro'),
                    'fadeInUp'     => __('fadeInUp', 'exclusive-addons-elementor-pro'),
                    'fadeInDown'   => __('fadeInDown', 'exclusive-addons-elementor-pro'),
                    'fadeInLeft'   => __('fadeInLeft', 'exclusive-addons-elementor-pro'),
                    'fadeInRight'  => __('fadeInRight', 'exclusive-addons-elementor-pro'),
                    'slideInUp'    => __('slideInUp', 'exclusive-addons-elementor-pro'),
                    'slideInDown'  => __('slideInDown', 'exclusive-addons-elementor-pro'),
                    'slideInLeft'  => __('slideInLeft', 'exclusive-addons-elementor-pro'),
                    'slideInRight' => __('slideInRight', 'exclusive-addons-elementor-pro')
                ],
                'condition'        => [
                    'exad_single_slider_custom_style' => 'yes'
                ]
            ]
        );

        $sliderItem->add_control(
            'exad_single_slider_button_animation_out',
            [
                'label'             => __( 'Animation Out', 'exclusive-addons-elementor-pro' ),
                'type'              => Controls_Manager::SELECT,
                'default'           => 'default',
                'options'           => [
                    ''              => __('None', 'exclusive-addons-elementor-pro'),
                    'default'       => __('Default', 'exclusive-addons-elementor-pro'),
                    'fadeOut'       => __('fadeOut', 'exclusive-addons-elementor-pro'),
                    'fadeOutUp'     => __('fadeOutUp', 'exclusive-addons-elementor-pro'),
                    'fadeOutDown'   => __('fadeOutDown', 'exclusive-addons-elementor-pro'),
                    'fadeOutLeft'   => __('fadeOutLeft', 'exclusive-addons-elementor-pro'),
                    'fadeOutRight'  => __('fadeOutRight', 'exclusive-addons-elementor-pro'),
                    'slideOutUp'    => __('slideOutUp', 'exclusive-addons-elementor-pro'),
                    'slideOutDown'  => __('slideOutDown', 'exclusive-addons-elementor-pro'),
                    'slideOutLeft'  => __('slideOutLeft', 'exclusive-addons-elementor-pro'),
                    'slideOutRight' => __('slideOutRight', 'exclusive-addons-elementor-pro')
                ],
                'condition'         => [
                    'exad_single_slider_custom_style' => 'yes'
                ]
            ]
        );

        $sliderItem->add_control(
            'exad_single_slider_button_animation_delay_in',
            [
                'label'         => __( 'Delay In', 'exclusive-addons-elementor-pro' ),
                'type'          => Controls_Manager::SLIDER,
                'range'         => [
                    'px'        => [
                        'min'   => 0,
                        'max'   => 1,
                        'step'  => .1
                    ]
                ],
                'condition'     => [
                    'exad_single_slider_custom_style' => 'yes'
                ]  
            ]
        ); 

        $sliderItem->add_control(
            'exad_single_slider_button_animation_duration_in',
            [
                'label'         => __( 'Duration In(second)', 'exclusive-addons-elementor-pro' ),
                'type'          => Controls_Manager::SLIDER,
                'range'         => [
                    'px'        => [
                        'min'   => 0,
                        'max'   => 1,
                        'step'  => .1
                    ]
                ],
                'condition'     => [
                    'exad_single_slider_custom_style' => 'yes'
                ]  
            ]
        );

        $sliderItem->add_control(
            'exad_single_slider_button_animation_duration_out',
            [
                'label'         => __( 'Duration Out(second)', 'exclusive-addons-elementor-pro' ),
                'type'          => Controls_Manager::SLIDER,
                'range'         => [
                    'px'        => [
                        'min'   => 0,
                        'max'   => 1,
                        'step'  => .1
                    ]
                ],
                'condition'     => [
                    'exad_single_slider_custom_style' => 'yes'
                ]  
            ]
        );

        $sliderItem->end_controls_tab();

        $sliderItem->end_controls_tabs();

        $this->add_control(
            'exad_slides',
            [
                'label'         => __( 'Slides', 'exclusive-addons-elementor-pro' ),
                'type'          => Controls_Manager::REPEATER,
                'show_label'    => true,
                'default'       => [
                    [
						'exad_slider_title' => __( 'Slider Title 1', 'exclusive-addons-elementor-pro' ),
						'exad_slider_bg'    => '#7a56ff'
                    ],
                    [
						'exad_slider_title' => __( 'Slider Title 2', 'exclusive-addons-elementor-pro' ),
						'exad_slider_bg'    => '#673AB7'
                    ],
                    [
						'exad_slider_title' => __( 'Slider Title 3', 'exclusive-addons-elementor-pro' ),
						'exad_slider_bg'    => '#3F51B5'
                    ]
                ],
                'fields'        => $sliderItem->get_controls(),
                'title_field'   => '{{{ exad_slider_title }}}'
            ]
        );

        $this->add_control(
            'exad_slider_title_html_tag',
            [
                'label'   => __('Title HTML Tag', 'exclusive-addons-elementor-pro'),
                'type'    => Controls_Manager::SELECT,
				'separator' => 'before',
                'options' => Helper::exad_title_tags(),
                'default' => 'h2',
            ]
		);

        $this->add_control(
            'exad_slider_details_html_tag',
            [
                'label'   => __('Short Details HTML Tag', 'exclusive-addons-elementor-pro'),
                'type'    => Controls_Manager::SELECT,
                'options' => Helper::exad_title_tags(),
                'default' => 'p',
            ]
		);


        $this->end_controls_section();

		$this->start_controls_section(
			'exad_slider_settings',
			[
				'label' => __( 'Settings', 'exclusive-addons-elementor-pro' )
			]
		);

        $this->add_control(
            'exad_slider_nav',
            [
                'label'      => esc_html__( 'Navigation', 'exclusive-addons-elementor-pro' ),
                'type'       => Controls_Manager::SELECT,
                'default'    => 'both',
                'options'    => [
                    'arrows' => esc_html__( 'Arrows', 'exclusive-addons-elementor-pro' ),
                    'dots'   => esc_html__( 'Dots', 'exclusive-addons-elementor-pro' ),
                    'both'   => esc_html__( 'Arrows and Dots', 'exclusive-addons-elementor-pro' ),
                    'none'   => esc_html__( 'None', 'exclusive-addons-elementor-pro' )
                ]
            ]
        );

        $this->add_control(
            'exad_slider_dots_type',
            [
                'label'     => esc_html__( 'Dots Type', 'exclusive-addons-elementor-pro' ),
                'type'      => Controls_Manager::SELECT,
                'default'   => 'dot-bullet',
                'options'   => [
                    'dot-bullet'      => esc_html__( 'Bullet', 'exclusive-addons-elementor-pro' ),
                    'dot-image'       => esc_html__( 'Image', 'exclusive-addons-elementor-pro' )
                    
                ],
                'condition' => [
                    'exad_slider_nav' => [ 'both', 'dots' ]
                ]
            ]
        );

        $this->add_control(
            'exad_slider_autoplay',
            [
                'label'     => esc_html__( 'Autoplay', 'exclusive-addons-elementor-pro' ),
                'type'      => Controls_Manager::SWITCHER,
                'default'   => 'yes'
            ]
        );

        $this->add_control(
            'exad_slider_pause_on_hover',
            [
				'label'        => esc_html__( 'Pause on Hover', 'exclusive-addons-elementor-pro' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => 'no',
				'return_value' => 'yes',
                'condition'    => [
                    'exad_slider_autoplay' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'exad_slider_loop',
            [
                'label'   => esc_html__( 'Infinite Loop', 'exclusive-addons-elementor-pro' ),
                'type'    => Controls_Manager::SWITCHER,
                'default' => 'yes'
            ]
        );

        $this->add_control(
            'exad_slider_enable_fade',
            [
				'label'        => esc_html__( 'Enable Fade?', 'exclusive-addons-elementor-pro' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => 'no',
				'return_value' => 'yes'
            ]
        );

        $this->add_control(
            'exad_slider_slide_vertically',
            [
				'label'        => esc_html__( 'Enable Vertical Slide Mode?', 'exclusive-addons-elementor-pro' ),
				'type'         => Controls_Manager::SWITCHER,
				'description'  => esc_html__( 'Default sliders are slide horizontally. By enabling this feature, the slider will be slide vertically.', 'exclusive-addons-elementor-pro' ),
				'default'      => 'no',
				'return_value' => 'yes',
				'condition'	   => [
					'exad_slider_enable_fade!' => 'yes'
				]
            ]
        );

        $this->add_control(
            'exad_slider_enable_center_mode',
            [
				'label'        => esc_html__( 'Enable Center Mode?', 'exclusive-addons-elementor-pro' ),
				'type'         => Controls_Manager::SWITCHER,
				'description'  => esc_html__( 'Enables centered view with partial prev/next slides. Use with odd numbered slidesToShow counts.', 'exclusive-addons-elementor-pro' ),
				'default'      => 'no',
				'return_value' => 'yes',
				'condition'	   => [
					'exad_slider_enable_fade!' => 'yes'
				]
            ]
        );

        $this->add_control(
            'exad_slider_progress_bar',
            [
                'type'          => Controls_Manager::SWITCHER,
                'label'         => __( 'Slider Progress Bar?', 'exclusive-addons-elementor-pro' ),
                'default'       => 'no',
                'return_value'  => 'yes',
                'description'   => __('Progress bar in slider.', 'exclusive-addons-elementor-pro')
            ]
        );

        $this->add_control(
            'exad_slider_autoplay_speed',
            [
                'label'     => esc_html__( 'Autoplay Speed(ms)', 'exclusive-addons-elementor-pro' ),
                'type'      => Controls_Manager::NUMBER,
                'default'   => 5000,
				'selectors' => [
					'{{WRAPPER}} .slick-active.slick-current .exad-slider-progressbar-active' => 'animation-duration: {{SIZE}}ms;-moz-animation-duration: {{SIZE}}ms;-ms-animation-duration: {{SIZE}}ms;-webkit-animation-duration: {{SIZE}}ms;'
				],
                'condition' => [
                    'exad_slider_autoplay' => 'yes'
                ]
            ]
        );

		$this->add_control(
            'exad_slider_transition_speed',
            [
                'label'   => esc_html__( 'Transition Speed(ms)', 'exclusive-addons-elementor-pro' ),
                'type'    => Controls_Manager::NUMBER,
                'default' => 1000
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'exad_slider_container_style',
            [
                'label' => __( 'Container', 'exclusive-addons-elementor-pro' ),
                'tab'   => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_control(
            'exad_slider_full_screen_size',
            [
                'label'         => __( 'Height Full Screen?', 'exclusive-addons-elementor-pro' ),
                'type'          => Controls_Manager::SWITCHER,
                'default'		=> 'no',
                'return_value'  => 'yes',
                'description'   => __( 'Set your slider fullscreen.', 'exclusive-addons-elementor-pro' )
            ]
        );

		$this->add_responsive_control(
			'exad_slider_height',
			[
				'label'       => __( 'Custom Height', 'exclusive-addons-elementor-pro' ),
				'type'        => Controls_Manager::SLIDER,
				'range'       => [
					'px'      => [
						'min' => 100,
						'max' => 1500
					],
					'vh'      => [
						'min' => 10,
						'max' => 100
					]
				],
				'default'     => [
					'size'    => 600,
					'unit'    => 'px'
				],
				'size_units'  => [ 'px', 'vh', 'em' ],
				'selectors'   => [
                    '{{WRAPPER}} .slick-slide .exad-each-slider-item' => 'height: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .exad-each-slider-item.slick-slide'  => 'height: {{SIZE}}{{UNIT}};'
				],
				'condition'   => [
					'exad_slider_full_screen_size!' => 'yes'
				]
			]
		);

		$this->add_responsive_control(
			'exad_slider_content_max_width',
			[
				'label'          => __( 'Container Width', 'exclusive-addons-elementor-pro' ),
				'type'           => Controls_Manager::SLIDER,
				'range'          => [
					'px'         => [
						'min'    => 0,
						'max'    => 2000
					],
					'%' 	     => [
						'min'    => 0,
						'max'    => 100
					]
				],
				'size_units'     => [ '%', 'px' ],
				'default'        => [
					'size'       => '65',
					'unit'       => '%'
				],
				'tablet_default' => [
					'unit'       => '%'
				],
				'mobile_default' => [
					'unit'       => '%'
				],
				'selectors'      => [
					'{{WRAPPER}} .exad-slide-content' => 'max-width: {{SIZE}}{{UNIT}};'
				]
			]
		);

        $this->add_responsive_control(
            'exad_slider_content_padding',
            [
                'label'         => __( 'Padding', 'exclusive-addons-elementor-pro' ),
                'type'          => Controls_Manager::DIMENSIONS,
                'default'       => [
                    'top'       => '70',
                    'right'     => '55',
                    'bottom'    => '70',
                    'left'      => '55',
                    'isLinked'  => false
                ],                
                'size_units'    => [ 'px', 'em', '%' ],
                'selectors'     => [
                    '{{WRAPPER}} .exad-slide-inner' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

		$this->add_responsive_control(
			'exad_slider_padding_in_centermode',
			[
				'label'       => __( 'Center Mode Padding', 'exclusive-addons-elementor-pro' ),
				'type'        => Controls_Manager::SLIDER,
				'range'       => [
					'px'      => [
						'min' => 0,
						'max' => 1000
					],
					'%' 	  => [
						'min' => 0,
						'max' => 100
					]
				],
				'size_units'  => ['px', '%' ],
				'default'     => [
					'size'    => '150',
					'unit'    => 'px'
				],
				'condition'   => [
                    'exad_slider_enable_center_mode' => 'yes',
                    'exad_slider_enable_fade!'       => 'yes'
				]
			]
		);

		$this->add_responsive_control(
			'exad_slider_horizontal_position',
			[
				'label'          => __( 'Horizontal Position', 'exclusive-addons-elementor-pro' ),
				'type'           => Controls_Manager::CHOOSE,
                'toggle'         => false,
				'label_block'    => false,
				'default'        => 'center',
				'options'        => [
					'flex-start' => [
						'title'  => __( 'Left', 'exclusive-addons-elementor-pro' ),
						'icon'   => 'eicon-h-align-left'
					],
					'center'     => [
						'title'  => __( 'Center', 'exclusive-addons-elementor-pro' ),
						'icon'   => 'eicon-h-align-center'
					],
					'flex-end'   => [
						'title'  => __( 'Right', 'exclusive-addons-elementor-pro' ),
						'icon'   => 'eicon-h-align-right'
					]
				],
				'selectors'     => [
					'{{WRAPPER}} .exad-slider .exad-slide-inner' => 'justify-content: {{VALUE}}; -webkit-justify-content: {{VALUE}};'
				]
			]
		);

		$this->add_responsive_control(
			'exad_slider_vertical_position',
			[
				'label'          => __( 'Vertical Position', 'exclusive-addons-elementor-pro' ),
				'type'           => Controls_Manager::CHOOSE,
                'toggle'         => false,
				'label_block'    => false,
				'default'        => 'center',
				'options'        => [
					'flex-start' => [
						'title'  => __( 'Top', 'exclusive-addons-elementor-pro' ),
						'icon'   => 'eicon-v-align-top'
					],
					'center'     => [
						'title'  => __( 'Middle', 'exclusive-addons-elementor-pro' ),
						'icon'   => 'eicon-v-align-middle'
					],
					'flex-end'   => [
						'title'  => __( 'Bottom', 'exclusive-addons-elementor-pro' ),
						'icon'   => 'eicon-v-align-bottom'
					]
				],
				'selectors'      => [
					'{{WRAPPER}} .exad-slider .exad-slide-inner' => 'align-items: {{VALUE}}; -webkit-align-items: {{VALUE}};'
				]
			]
		);

		$this->add_responsive_control(
			'exad_slider_text_align',
			[
				'label'         => __( 'Text Align', 'exclusive-addons-elementor-pro' ),
				'type'          => Controls_Manager::CHOOSE,
                'toggle'        => false,
				'label_block'   => false,
				'default'       => 'center',
				'options'       => [
                    'left'      => [
                        'title' => esc_html__( 'Left', 'exclusive-addons-elementor-pro' ),
                        'icon'  => 'eicon-text-align-left'
                    ],
                    'center'    => [
                        'title' => esc_html__( 'Center', 'exclusive-addons-elementor-pro' ),
                        'icon'  => 'eicon-text-align-center'
                    ],
                    'right'     => [
                        'title' => esc_html__( 'Right', 'exclusive-addons-elementor-pro' ),
                        'icon'  => 'eicon-text-align-right'
                    ]
                ],
				'selectors'     => [
					'{{WRAPPER}} .exad-slide-inner' => 'text-align: {{VALUE}};'
				]
			]
        );

        $this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'exad_slider_container_boeder',
				'label' => __( 'Border', 'exclusive-addons-elementor-pro' ),
				'selector' => '{{WRAPPER}} .exad-each-slider-item',
			]
        );
        
        $this->add_responsive_control(
            'exad_slider_container_radius',
            [
                'label'         => __( 'Radius', 'exclusive-addons-elementor-pro' ),
                'type'          => Controls_Manager::DIMENSIONS,
                'default'       => [
                    'top'       => '0',
                    'right'     => '0',
                    'bottom'    => '0',
                    'left'      => '0',
                    'isLinked'  => true
                ],                
                'size_units'    => [ 'px', 'em', '%' ],
                'selectors'     => [
                    '{{WRAPPER}} .exad-each-slider-item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->add_responsive_control(
            'exad_slider_container_item_margin',
            [
                'label'         => __( 'Item Margin', 'exclusive-addons-elementor-pro' ),
                'type'          => Controls_Manager::DIMENSIONS,              
                'size_units'    => [ 'px', 'em', '%' ],
                'selectors'     => [
                    '{{WRAPPER}} .exad-each-slider-item' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'exad_slider_container_item_shadow',
				'selector' => '{{WRAPPER}} .exad-each-slider-item'
			]
		);

        $this->end_controls_section();

        $this->start_controls_section(
            'exad_slider_content_style',
            [
                'label' => __( 'Content Title', 'exclusive-addons-elementor-pro' ),
                'tab'   => Controls_Manager::TAB_STYLE
            ]
        );

		$this->add_control(
		    'exad_slider_title_color',
		    [
		        'label'     => __( 'Color', 'exclusive-addons-elementor-pro' ),
		        'type'      => Controls_Manager::COLOR,
		        'default'	=> '#ffffff',
		        'selectors' => [
		            '{{WRAPPER}} .exad-slide-content .exad-slider-title' => 'color: {{VALUE}};'
		        ]
		    ]
		);
        
        $this->add_control(
            'exad_single_slider_custom_style_title_background_enable',
            [
                'label'         => __( 'Enable Title Background', 'exclusive-addons-elementor-pro' ),
                'type'          => Controls_Manager::SWITCHER,
                'return_value'  => 'yes',
            ]
        );	

        $this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'      => 'exad_single_slider_custom_style_title_background',
				'types'     => [ 'classic', 'gradient' ],
                'selector'  => '{{WRAPPER}} .exad-slide-content.exad-slide-content-title-background-yes .exad-slider-title','{{WRAPPER}} .exad-slide-content .exad-slider-title',
                'condition' => [
                    'exad_single_slider_custom_style_title_background_enable' => 'yes'
                ]
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
            	'name'		=> 'exad_slider_title_typography',
				'selector'	=> '{{WRAPPER}} .exad-slide-content .exad-slider-title'
			]
		);

        $this->add_responsive_control(
            'exad_slider_title_padding',
            [
				'label'      => __('Padding', 'exclusive-addons-elementor-pro'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors'  => [
                    '{{WRAPPER}} .exad-slide-content .exad-slider-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->add_responsive_control(
            'exad_slider_title_margin',
            [
				'label'        => __('Margin', 'exclusive-addons-elementor-pro'),
				'type'         => Controls_Manager::DIMENSIONS,
				'size_units'   => ['px', '%'],
              	'default'      => [
                    'top'      => '0',
                    'right'    => '0',
                    'bottom'   => '20',
                    'left'     => '0',
                    'isLinked' => false
                ], 
                'selectors'    => [
                    '{{WRAPPER}} .exad-slide-content .exad-slider-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->add_group_control(
        	Group_Control_Border::get_type(),
            [
                'name'      => 'exad_slider_title_border',
                'selector'  => '{{WRAPPER}} .exad-slide-content .exad-slider-title'
            ]
        );

		$this->add_responsive_control(
			'exad_slider_title_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'exclusive-addons-elementor-pro' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px'],
				'selectors'  => [
					'{{WRAPPER}} .exad-slide-content .exad-slider-title'=> 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'exad_slider_title_box_shadow',
				'selector' => '{{WRAPPER}} .exad-slide-content .exad-slider-title'
			]
		);

        $this->add_control(
            'exad_slider_title_animation_in',
            [
                'label'            => __( 'Animation In', 'exclusive-addons-elementor-pro' ),
                'description'      => __( 'Select title animation style for this slide only.', 'exclusive-addons-elementor-pro' ),
                'type'             => Controls_Manager::SELECT,
                'default'          => 'fadeInDown',
                'options'          => [
                    ''             => __('None', 'exclusive-addons-elementor-pro'),
                    'fadeIn'       => __('fadeIn', 'exclusive-addons-elementor-pro'),
                    'fadeInUp'     => __('fadeInUp', 'exclusive-addons-elementor-pro'),
                    'fadeInDown'   => __('fadeInDown', 'exclusive-addons-elementor-pro'),
                    'fadeInLeft'   => __('fadeInLeft', 'exclusive-addons-elementor-pro'),
                    'fadeInRight'  => __('fadeInRight', 'exclusive-addons-elementor-pro'),
                    'slideInUp'    => __('slideInUp', 'exclusive-addons-elementor-pro'),
                    'slideInDown'  => __('slideInDown', 'exclusive-addons-elementor-pro'),
                    'slideInLeft'  => __('slideInLeft', 'exclusive-addons-elementor-pro'),
                    'slideInRight' => __('slideInRight', 'exclusive-addons-elementor-pro')
                ]
            ]
        );

        $this->add_control(
            'exad_slider_title_animation_out',
            [
                'label'             => __( 'Animation Out', 'exclusive-addons-elementor-pro' ),
                'type'              => Controls_Manager::SELECT,
                'default'           => 'fadeOutDown',
                'options'           => [
                    ''              => __('None', 'exclusive-addons-elementor-pro'),
                    'fadeOut'       => __('fadeOut', 'exclusive-addons-elementor-pro'),
                    'fadeOutUp'     => __('fadeOutUp', 'exclusive-addons-elementor-pro'),
                    'fadeOutDown'   => __('fadeOutDown', 'exclusive-addons-elementor-pro'),
                    'fadeOutLeft'   => __('fadeOutLeft', 'exclusive-addons-elementor-pro'),
                    'fadeOutRight'  => __('fadeOutRight', 'exclusive-addons-elementor-pro'),
                    'slideOutUp'    => __('slideOutUp', 'exclusive-addons-elementor-pro'),
                    'slideOutDown'  => __('slideOutDown', 'exclusive-addons-elementor-pro'),
                    'slideOutLeft'  => __('slideOutLeft', 'exclusive-addons-elementor-pro'),
                    'slideOutRight' => __('slideOutRight', 'exclusive-addons-elementor-pro')
                ]
            ]
        );

        $this->add_control(
            'exad_slider_title_animation_delay_in',
            [
                'label'         => __( 'Delay In', 'exclusive-addons-elementor-pro' ),
                'type'          => Controls_Manager::SLIDER,
                'default'       => [
                    'size'      => .1,
                ],
                'range'         => [
                    'px'        => [
                        'min'   => 0,
                        'max'   => 1,
                        'step'  => .1
                    ]
                ]  
            ]
        ); 

        $this->add_control(
            'exad_slider_title_animation_duration_in',
            [
                'label'         => __( 'Duration In(second)', 'exclusive-addons-elementor-pro' ),
                'type'          => Controls_Manager::SLIDER,
                'default'       => [
                    'size'      => .5
                ],
                'range'         => [
                    'px'        => [
                        'min'   => 0,
                        'max'   => 3,
                        'step'  => .1
                    ]
                ]  
            ]
        );

        $this->add_control(
            'exad_slider_title_animation_duration_out',
            [
                'label'         => __( 'Duration Out(second)', 'exclusive-addons-elementor-pro' ),
                'type'          => Controls_Manager::SLIDER,
                'default'       => [
                    'size'      => 1
                ],
                'range'         => [
                    'px'        => [
                        'min'   => 0,
                        'max'   => 3,
                        'step'  => .1
                    ]
                ]  
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'exad_slider_content_details',
            [
                'label' => __( 'Content Details', 'exclusive-addons-elementor-pro' ),
                'tab'   => Controls_Manager::TAB_STYLE
            ]
        );

		$this->add_control(
		    'exad_slider_details_color',
		    [
		        'label'     => __( 'Color', 'exclusive-addons-elementor-pro' ),
		        'type'      => Controls_Manager::COLOR,
		        'default'	=> '#ffffff',
		        'selectors' => [
		            '{{WRAPPER}} .exad-slide-content .exad-slider-details' => 'color: {{VALUE}};'
		        ]
		    ]
		);

		$this->add_control(
		    'exad_slider_details_bg_color',
		    [
		        'label'     => __( 'Background Color', 'exclusive-addons-elementor-pro' ),
		        'type'      => Controls_Manager::COLOR,
		        'selectors' => [
		            '{{WRAPPER}} .exad-slide-content .exad-slider-details' => 'background-color: {{VALUE}};'
		        ]
		    ]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
            	'name'		=> 'exad_slider_details_typography',
				'selector'	=> '{{WRAPPER}} .exad-slide-content .exad-slider-details'
			]
		);

        $this->add_responsive_control(
            'exad_slider_details_padding',
            [
                'label'      => __('Padding', 'exclusive-addons-elementor-pro'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .exad-slide-content .exad-slider-details' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->add_responsive_control(
            'exad_slider_details_margin',
            [
                'label'      => __('Margin', 'exclusive-addons-elementor-pro'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .exad-slide-content .exad-slider-details' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
            ]
        );

        $this->add_group_control(
        	Group_Control_Border::get_type(),
            [
                'name'      => 'exad_slider_details_border',
                'selector'  => '{{WRAPPER}} .exad-slide-content .exad-slider-details'
            ]
        );

		$this->add_responsive_control(
			'exad_slider_details_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'exclusive-addons-elementor-pro' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px'],
				'selectors'  => [
					'{{WRAPPER}} .exad-slide-content .exad-slider-details'=> 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'exad_slider_details_box_shadow',
				'selector' => '{{WRAPPER}} .exad-slide-content .exad-slider-details'
			]
		);

        $this->add_control(
            'exad_slider_details_animation_in',
            [
                'label'            => __( 'Animation In', 'exclusive-addons-elementor-pro' ),
                'description'      => __( 'Select title animation style for this slide only.', 'exclusive-addons-elementor-pro' ),
                'type'             => Controls_Manager::SELECT,
                'default'          => 'fadeInDown',
                'options'          => [
                    ''             => __('None', 'exclusive-addons-elementor-pro'),
                    'fadeIn'       => __('fadeIn', 'exclusive-addons-elementor-pro'),
                    'fadeInUp'     => __('fadeInUp', 'exclusive-addons-elementor-pro'),
                    'fadeInDown'   => __('fadeInDown', 'exclusive-addons-elementor-pro'),
                    'fadeInLeft'   => __('fadeInLeft', 'exclusive-addons-elementor-pro'),
                    'fadeInRight'  => __('fadeInRight', 'exclusive-addons-elementor-pro'),
                    'slideInUp'    => __('slideInUp', 'exclusive-addons-elementor-pro'),
                    'slideInDown'  => __('slideInDown', 'exclusive-addons-elementor-pro'),
                    'slideInLeft'  => __('slideInLeft', 'exclusive-addons-elementor-pro'),
                    'slideInRight' => __('slideInRight', 'exclusive-addons-elementor-pro')
                ]
            ]
        );

        $this->add_control(
            'exad_slider_details_animation_out',
            [
                'label'             => __( 'Animation Out', 'exclusive-addons-elementor-pro' ),
                'type'              => Controls_Manager::SELECT,
                'default'           => 'fadeOutDown',
                'options'           => [
                    ''              => __('None', 'exclusive-addons-elementor-pro'),
                    'fadeOut'       => __('fadeOut', 'exclusive-addons-elementor-pro'),
                    'fadeOutUp'     => __('fadeOutUp', 'exclusive-addons-elementor-pro'),
                    'fadeOutDown'   => __('fadeOutDown', 'exclusive-addons-elementor-pro'),
                    'fadeOutLeft'   => __('fadeOutLeft', 'exclusive-addons-elementor-pro'),
                    'fadeOutRight'  => __('fadeOutRight', 'exclusive-addons-elementor-pro'),
                    'slideOutUp'    => __('slideOutUp', 'exclusive-addons-elementor-pro'),
                    'slideOutDown'  => __('slideOutDown', 'exclusive-addons-elementor-pro'),
                    'slideOutLeft'  => __('slideOutLeft', 'exclusive-addons-elementor-pro'),
                    'slideOutRight' => __('slideOutRight', 'exclusive-addons-elementor-pro')
                ]
            ]
        );

        $this->add_control(
            'exad_slider_details_animation_delay_in',
            [
                'label'         => __( 'Delay In', 'exclusive-addons-elementor-pro' ),
                'type'          => Controls_Manager::SLIDER,
                'default'       => [
                    'size'      => .2,
                ],
                'range'         => [
                    'px'        => [
                        'min'   => 0,
                        'max'   => 1,
                        'step'  => .1
                    ]
                ]  
            ]
        ); 

        $this->add_control(
            'exad_slider_details_animation_duration_in',
            [
                'label'         => __( 'Duration In(second)', 'exclusive-addons-elementor-pro' ),
                'type'          => Controls_Manager::SLIDER,
                'default'       => [
                    'size'      => .5
                ],
                'range'         => [
                    'px'        => [
                        'min'   => 0,
                        'max'   => 1,
                        'step'  => .1
                    ]
                ]  
            ]
        );

        $this->add_control(
            'exad_slider_details_animation_duration_out',
            [
                'label'         => __( 'Duration Out(second)', 'exclusive-addons-elementor-pro' ),
                'type'          => Controls_Manager::SLIDER,
                'default'       => [
                    'size'      => 1
                ],
                'range'         => [
                    'px'        => [
                        'min'   => 0,
                        'max'   => 1,
                        'step'  => .1
                    ]
                ]  
            ]
        );

        $this->end_controls_section();

		$this->start_controls_section(
            'exad_slider_btn_style_section',
            [
                'label'         => esc_html__( 'Content Button', 'exclusive-addons-elementor-pro' ),
                'tab'           => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_responsive_control(
            'exad_slider_btn_padding',
            [
                'label'         => __( 'Padding', 'exclusive-addons-elementor-pro' ),
                'type'          => Controls_Manager::DIMENSIONS,
                'default'       => [
                    'top'       => '12',
                    'right'     => '30',
                    'bottom'    => '12',
                    'left'      => '30',
                    'isLinked'  => false
                ],                
                'size_units'    => [ 'px', 'em', '%' ],
                'selectors'     => [
                    '{{WRAPPER}} .exad-slide-content a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->add_responsive_control(
            'exad_slider_btn_margin',
            [
                'label'      => esc_html__( 'Margin', 'exclusive-addons-elementor-pro' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],                 
                'selectors'  => [
                    '{{WRAPPER}} .exad-slide-content a' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'exad_slider_btn_typography',
                'selector' => '{{WRAPPER}} .exad-slide-content a'
            ]
        );

        $this->add_control(
            'exad_slider_button_animation_in',
            [
                'label'            => __( 'Animation In', 'exclusive-addons-elementor-pro' ),
                'description'      => __( 'Select title animation style for this slide only.', 'exclusive-addons-elementor-pro' ),
                'type'             => Controls_Manager::SELECT,
                'default'          => 'fadeInDown',
                'options'          => [
                    ''             => __('None', 'exclusive-addons-elementor-pro'),
                    'fadeIn'       => __('fadeIn', 'exclusive-addons-elementor-pro'),
                    'fadeInUp'     => __('fadeInUp', 'exclusive-addons-elementor-pro'),
                    'fadeInDown'   => __('fadeInDown', 'exclusive-addons-elementor-pro'),
                    'fadeInLeft'   => __('fadeInLeft', 'exclusive-addons-elementor-pro'),
                    'fadeInRight'  => __('fadeInRight', 'exclusive-addons-elementor-pro'),
                    'slideInUp'    => __('slideInUp', 'exclusive-addons-elementor-pro'),
                    'slideInDown'  => __('slideInDown', 'exclusive-addons-elementor-pro'),
                    'slideInLeft'  => __('slideInLeft', 'exclusive-addons-elementor-pro'),
                    'slideInRight' => __('slideInRight', 'exclusive-addons-elementor-pro')
                ]
            ]
        );

        $this->add_control(
            'exad_slider_button_animation_out',
            [
                'label'             => __( 'Animation Out', 'exclusive-addons-elementor-pro' ),
                'type'              => Controls_Manager::SELECT,
                'default'           => 'fadeOutDown',
                'options'           => [
                    ''              => __('None', 'exclusive-addons-elementor-pro'),
                    'fadeOut'       => __('fadeOut', 'exclusive-addons-elementor-pro'),
                    'fadeOutUp'     => __('fadeOutUp', 'exclusive-addons-elementor-pro'),
                    'fadeOutDown'   => __('fadeOutDown', 'exclusive-addons-elementor-pro'),
                    'fadeOutLeft'   => __('fadeOutLeft', 'exclusive-addons-elementor-pro'),
                    'fadeOutRight'  => __('fadeOutRight', 'exclusive-addons-elementor-pro'),
                    'slideOutUp'    => __('slideOutUp', 'exclusive-addons-elementor-pro'),
                    'slideOutDown'  => __('slideOutDown', 'exclusive-addons-elementor-pro'),
                    'slideOutLeft'  => __('slideOutLeft', 'exclusive-addons-elementor-pro'),
                    'slideOutRight' => __('slideOutRight', 'exclusive-addons-elementor-pro')
                ]
            ]
        );

        $this->add_control(
            'exad_slider_button_animation_delay_in',
            [
                'label'         => __( 'Delay In', 'exclusive-addons-elementor-pro' ),
                'type'          => Controls_Manager::SLIDER,
                'default'       => [
                    'size'      => .3,
                ],
                'range'         => [
                    'px'        => [
                        'min'   => 0,
                        'max'   => 1,
                        'step'  => .1
                    ]
                ]  
            ]
        ); 

        $this->add_control(
            'exad_slider_button_animation_duration_in',
            [
                'label'         => __( 'Duration In(second)', 'exclusive-addons-elementor-pro' ),
                'type'          => Controls_Manager::SLIDER,
                'default'       => [
                    'size'      => .5
                ],
                'range'         => [
                    'px'        => [
                        'min'   => 0,
                        'max'   => 1,
                        'step'  => .1
                    ]
                ]  
            ]
        );

        $this->add_control(
            'exad_slider_button_animation_duration_out',
            [
                'label'         => __( 'Duration Out(second)', 'exclusive-addons-elementor-pro' ),
                'type'          => Controls_Manager::SLIDER,
                'default'       => [
                    'size'      => 1
                ],
                'range'         => [
                    'px'        => [
                        'min'   => 0,
                        'max'   => 1,
                        'step'  => .1
                    ]
                ]  
            ]
        );

        $this->start_controls_tabs( 'exad_slider_button_style_tabs' );

            // normal state tab
            $this->start_controls_tab( 'exad_slider_btn_normal', [ 'label' => esc_html__( 'Normal', 'exclusive-addons-elementor-pro' ) ] );

            $this->add_control(
                'exad_slider_btn_normal_text_color',
                [
                    'label'     => esc_html__( 'Color', 'exclusive-addons-elementor-pro' ),
                    'type'      => Controls_Manager::COLOR,
                    'default'   => '#ffffff',
                    'selectors' => [
                        '{{WRAPPER}} .exad-slide-content a' => 'color: {{VALUE}};'
                    ]
                ]
            );

            $this->add_control(
                'exad_slider_btn_normal_bg_color',
                [
                    'label'     => esc_html__( 'Background Color', 'exclusive-addons-elementor-pro' ),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .exad-slide-content a' => 'background-color: {{VALUE}};'
                    ]
                ]
            );

	       	$this->add_group_control(
	            Group_Control_Border::get_type(),
	            [
	                'name'               => 'exad_slider_btn_border',
	                'selector'           => '{{WRAPPER}} .exad-slide-content a',
	                'fields_options'     => [
	                    'border' 	     => [
	                        'default'    => 'solid'
	                    ],
	                    'width'  		 => [
	                        'default' 	 => [
	                            'top'    => '2',
	                            'right'  => '2',
	                            'bottom' => '2',
	                            'left'   => '2'
	                        ]
	                    ],
	                    'color'          => [
	                        'default'    => '#ffffff'
	                    ]
	                ]
	            ]
	        );

			$this->add_responsive_control(
				'exad_slider_button_border_radius',
				[
					'label'      => esc_html__( 'Border Radius', 'exclusive-addons-elementor-pro' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px'],
					'selectors'  => [
						'{{WRAPPER}} .exad-slide-content a'=> 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
					]
				]
			);

            $this->add_group_control(
                Group_Control_Box_Shadow::get_type(),
                [
                    'name'      => 'exad_slider_button_shadow',
                    'selector'  => '{{WRAPPER}} .exad-slide-content a',
                    'separator' => 'before'
                ]
            );

            $this->end_controls_tab();

            // hover state tab
            $this->start_controls_tab( 'exad_slider_btn_hover', [ 'label' => esc_html__( 'Hover', 'exclusive-addons-elementor-pro' ) ] );

            $this->add_control(
                'exad_slider_btn_hover_text_color',
                [
                    'label'     => esc_html__( 'Color', 'exclusive-addons-elementor-pro' ),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .exad-slide-content a:hover' => 'color: {{VALUE}};'
                    ]
                ]
            );

            $this->add_control(
                'exad_slider_btn_hover_bg_color',
                [
                    'label'     => esc_html__( 'Background Color', 'exclusive-addons-elementor-pro' ),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .exad-slide-content a:hover' => 'background: {{VALUE}};'
                    ]
                ]
            );

            $this->add_group_control(
                Group_Control_Border::get_type(),
                [
                    'name'     => 'exad_slider_btn_hover_border',
                    'selector' => '{{WRAPPER}} .exad-slide-content a:hover'
                ]
            );

			$this->add_responsive_control(
				'exad_slider_button_border_radius_hover',
				[
					'label'      => esc_html__( 'Border Radius', 'exclusive-addons-elementor-pro' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px'],
					'selectors'  => [
						'{{WRAPPER}} .exad-slide-content a:hover'=> 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
					]
				]
			);

            $this->add_group_control(
                Group_Control_Box_Shadow::get_type(),
                [
                    'name'      => 'exad_slider_button_hover_shadow',
                    'selector'  => '{{WRAPPER}} .exad-slide-content a:hover'
                ]
            );

            $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section(); 

        $this->start_controls_section(
            'exad_slider_progressbar_style_section',
            [
                'label'         => __('Progressbar', 'exclusive-addons-elementor-pro'),
                'tab'           => Controls_Manager::TAB_STYLE,
                'condition'     => [
                    'exad_slider_progress_bar' => 'yes'
                ]                
            ]
        );

        $this->add_control(
            'exad_slider_progressbar_color',
            [
                'label'         => __( 'Color', 'exclusive-addons-elementor-pro' ),
                'type'          => Controls_Manager::COLOR,
                'default'       => 'rgba(255,255,255,.7)',
                'selectors'     => [
                    '{{WRAPPER}} .slick-active.slick-current .exad-slider-progressbar-active' => 'background-color: {{VALUE}};'
                ]
            ]
        ); 

        $this->add_responsive_control(
            'exad_slider_progressbar_height',
            [
                'label'         => __( 'Height', 'exclusive-addons-elementor-pro' ),
                'type'          => Controls_Manager::SLIDER,
                'default'       => [
                    'size'      => 7,
                ],
                'range'         => [
                    'px'        => [
                        'min'   => 1,
                        'max'   => 20,
                        'step'  => 1
                    ],
                ],
                'selectors'     => [
                    '{{WRAPPER}} .slick-active.slick-current .exad-slider-progressbar-active' => 'height: {{SIZE}}{{UNIT}};',
                ],  
                'description'   => __( 'Default: 7px.', 'exclusive-addons-elementor-pro' )            
            ]
        ); 

        $this->end_controls_section();

        $this->start_controls_section(
            'exad_slider_arrow_controls_style_section',
            [
                'label'     => __('Arrow Controls', 'exclusive-addons-elementor-pro' ),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'exad_slider_nav' => [ 'arrows', 'both' ]
                ]               
            ]
        );

        $this->add_control(
            'exad_slider_arrows_style',
            [
                'label' => esc_html__( 'Arrows', 'exclusive-addons-elementor-pro' ),
                'type'  => Controls_Manager::HEADING
            ]
        );

        $this->add_responsive_control(
            'exad_slider_arrows_size',
            [
                'label'         => __( 'Size', 'exclusive-addons-elementor-pro' ),
                'type'          => Controls_Manager::SLIDER,
                'default'       => [
                    'size'      => 35
                ],
                'range'         => [
                    'px'        => [
                        'min'   => 1,
                        'max'   => 70,
                        'step'  => 1
                    ]
                ],
                'selectors'     => [
                    '{{WRAPPER}} .exad-slider .slick-next:before,{{WRAPPER}} .exad-slider .slick-prev:before' => 'font-size: {{SIZE}}{{UNIT}};'
                ]
            ]
        );

        $this->add_responsive_control(
            'exad_slider_arrow_width',
            [
                'label'         => __( 'Width', 'exclusive-addons-elementor-pro' ),
                'type'          => Controls_Manager::SLIDER,
                'default'       => [
                    'size'      => 55
                ],
                'range'         => [
                    'px'        => [
                        'min'   => 1,
                        'max'   => 200,
                        'step'  => 1
                    ]
                ],
                'selectors'     => [
                    '{{WRAPPER}} .exad-slider .slick-next,{{WRAPPER}} .exad-slider .slick-prev' => 'width: {{SIZE}}{{UNIT}};'
                ]
            ]
        );

        $this->add_responsive_control(
            'exad_slider_arrow_height',
            [
                'label'         => __( 'Height', 'exclusive-addons-elementor-pro' ),
                'type'          => Controls_Manager::SLIDER,
                'default'       => [
                    'size'      => 95
                ],
                'range'         => [
                    'px'        => [
                        'min'   => 1,
                        'max'   => 200,
                        'step'  => 1
                    ]
                ],
                'selectors'     => [
                    '{{WRAPPER}} .exad-slider .slick-next,{{WRAPPER}} .exad-slider .slick-prev' => 'height: {{SIZE}}{{UNIT}}; line-height: {{SIZE}}{{UNIT}};'
                ]
            ]
        );

        $this->add_control(
            'exad_slider_prev_arrow_position',
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
                'exad_slider_prev_arrow_position_x_offset',
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
                        '{{WRAPPER}} .exad-slider .slick-prev' => 'left: {{SIZE}}{{UNIT}};',
                    ],
                ]
            );

            $this->add_responsive_control(
                'exad_slider_prev_arrow_position_y_offset',
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
                        '{{WRAPPER}} .exad-slider .slick-prev' => 'top: {{SIZE}}{{UNIT}};',
                    ],
                ]
            );

        $this->end_popover();

        $this->add_control(
            'exad_slider_next_arrow_position',
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
                'exad_slider_next_arrow_position_x_offset',
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
                        '{{WRAPPER}} .exad-slider .slick-next' => 'right: {{SIZE}}{{UNIT}};',
                    ],
                ]
            );

            $this->add_responsive_control(
                'exad_slider_next_arrow_position_y_offset',
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
                        '{{WRAPPER}} .exad-slider .slick-next' => 'top: {{SIZE}}{{UNIT}};',
                    ],
                ]
            );

        $this->end_popover();

		$this->start_controls_tabs( 'exad_slider_arrows_style_tabs' );

        	// normal state tab
        	$this->start_controls_tab( 'exad_slider_arrow_normal_style', [ 'label' => esc_html__( 'Normal', 'exclusive-addons-elementor-pro' ) ] );

		        $this->add_control(
		            'exad_slider_arrows_color',
		            [
		                'label'         => __( 'Color', 'exclusive-addons-elementor-pro' ),
		                'type'          => Controls_Manager::COLOR,
		                'default'       => '#ffffff',
		                'selectors'     => [
		                    '{{WRAPPER}} .exad-slider .slick-next:before,{{WRAPPER}} .exad-slider .slick-prev:before' => 'color: {{VALUE}};'
		                ]          
		            ]
		        );

		        $this->add_control(
		            'exad_slider_arrows_bg_color',
		            [
		                'label'         => __( 'Background Color', 'exclusive-addons-elementor-pro' ),
		                'type'          => Controls_Manager::COLOR,
		                'default'       => 'rgba(255,255,255,.3)',
		                'selectors'     => [
		                    '{{WRAPPER}} .exad-slider .slick-next,{{WRAPPER}} .exad-slider .slick-prev' => 'background-color: {{VALUE}};'
		                ]            
		            ]
		        );

		        $this->add_group_control(
		        	Group_Control_Border::get_type(),
		            [
		                'name'      => 'exad_slider_arrows_border',
		                'selector'  => '{{WRAPPER}} .exad-slider .slick-next,{{WRAPPER}} .exad-slider .slick-prev'
		            ]
		        );

				$this->add_responsive_control(
					'exad_slider_arrows_border_radius',
					[
						'label'      => esc_html__( 'Border Radius', 'exclusive-addons-elementor-pro' ),
						'type'       => Controls_Manager::DIMENSIONS,
						'size_units' => [ 'px'],
						'selectors'  => [
							'{{WRAPPER}} .exad-slider .slick-next,{{WRAPPER}} .exad-slider .slick-prev'=> 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
						],
                        'default'    => [
                            'top'    => 0,
                            'right'  => 0,
                            'bottom' => 0,
                            'left'   => 0
                        ] 
					]
				);

			$this->end_controls_tab();


        	// hover state tab
        	$this->start_controls_tab( 'exad_slider_arrow_hover_style', [ 'label' => esc_html__( 'Hover', 'exclusive-addons-elementor-pro' ) ] );

		        $this->add_control(
		            'exad_slider_arrows_hover_color',
		            [
		                'label'         => __( 'Color', 'exclusive-addons-elementor-pro' ),
		                'type'          => Controls_Manager::COLOR,
		                'selectors'     => [
		                    '{{WRAPPER}} .exad-slider .slick-next:hover:before,{{WRAPPER}} .exad-slider .slick-prev:hover:before' => 'color: {{VALUE}};'
		                ]          
		            ]
		        );

		        $this->add_control(
		            'exad_slider_arrows_hover_bg_color',
		            [
		                'label'         => __( 'Background Color', 'exclusive-addons-elementor-pro' ),
		                'type'          => Controls_Manager::COLOR,
		                'selectors'     => [
		                    '{{WRAPPER}} .exad-slider .slick-next:hover,{{WRAPPER}} .exad-slider .slick-prev:hover' => 'background-color: {{VALUE}};'
		                ]          
		            ]
		        );

		        $this->add_group_control(
		        	Group_Control_Border::get_type(),
		            [
		                'name'      => 'exad_slider_arrows_hover_border',
		                'selector'  => '{{WRAPPER}} .exad-slider .slick-next:hover,{{WRAPPER}} .exad-slider .slick-prev:hover'
		            ]
		        );


				$this->add_responsive_control(
					'exad_slider_arrows_hover_border_radius',
					[
						'label'      => esc_html__( 'Border Radius', 'exclusive-addons-elementor-pro' ),
						'type'       => Controls_Manager::DIMENSIONS,
						'size_units' => [ 'px'],
						'selectors'  => [
							'{{WRAPPER}} .exad-slider .slick-next:hover,{{WRAPPER}} .exad-slider .slick-prev:hover'=> 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
						]
					]
				);

			$this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();

        $this->start_controls_section(
            'exad_slider_dot_image_controls_style_section',
            [
                'label'     => __('Dots Thumbnail', 'exclusive-addons-elementor-pro' ),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'exad_slider_nav'       => ['dots', 'both'],
                    'exad_slider_dots_type' => 'dot-image'
                ]                
            ]
        );

        $this->add_responsive_control(
            'exad_slider_dot_image_padding',
            [
                'label'      => __('Padding', 'exclusive-addons-elementor-pro'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .exad-slider.dot-image ul.slick-dots li' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->add_responsive_control(
            'exad_slider_dot_image_margin',
            [
                'label'        => __('Margin', 'exclusive-addons-elementor-pro'),
                'type'         => Controls_Manager::DIMENSIONS,
                'size_units'   => ['px', '%'],
                'default'      => [
                    'top'      => '10',
                    'right'    => '10',
                    'bottom'   => '0',
                    'left'     => '10',
                    'isLinked' => false
                ], 
                'selectors'    => [
                    '{{WRAPPER}} .exad-slider.dot-image ul.slick-dots li' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->add_responsive_control(
            'exad_slider_dot_image_height',
            [
                'label'       => __( 'Height', 'exclusive-addons-elementor-pro' ),
                'type'        => Controls_Manager::SLIDER,
                'range'       => [
                    'px'      => [
                        'min' => 0,
                        'max' => 500
                    ]
                ],
                'default'     => [
                    'size'    => 100,
                    'unit'    => 'px'
                ],
                'selectors'   => [
                    '{{WRAPPER}} .exad-slider .slick-dots li a' => 'height: {{SIZE}}{{UNIT}};'
                ]
            ]
        );

        $this->add_responsive_control(
            'exad_slider_dot_image_width',
            [
                'label'       => __( 'Width', 'exclusive-addons-elementor-pro' ),
                'type'        => Controls_Manager::SLIDER,
                'range'       => [
                    'px'      => [
                        'min' => 0,
                        'max' => 5000
                    ]
                ],
                'selectors'   => [
                    '{{WRAPPER}} .exad-slider .slick-dots li a' => 'width: {{SIZE}}{{UNIT}};'
                ]
            ]
        );

        $this->add_responsive_control(
            'exad_slider_dot_image_border_radius',
            [
                'label'      => esc_html__( 'Border Radius', 'exclusive-addons-elementor-pro' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px'],
                'selectors'  => [
                    '{{WRAPPER}} .exad-slider .slick-dots li a img'=> 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'exad_slider_dot_bullet_controls_style_section',
            [
                'label'     => __('Dots Bullet', 'exclusive-addons-elementor-pro' ),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'exad_slider_nav'       => ['dots', 'both'],
                    'exad_slider_dots_type' => 'dot-bullet'
                ]                
            ]
        );

        $this->add_control(
			'exad_slider_dot_bullet_position',
			[
				'label' => __( 'Position', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::POPOVER_TOGGLE,
				'label_off' => __( 'Default', 'exclusive-addons-elementor-pro' ),
				'label_on' => __( 'Custom', 'exclusive-addons-elementor-pro' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
        );
        
        $this->start_popover();

            $this->add_responsive_control(
                'exad_slider_dot_bullet_position_left',
                [
                    'label' => __( 'Top & Bottom', 'exclusive-addons-elementor-pro' ),
                    'type' => Controls_Manager::SLIDER,
                    'size_units' => [ 'px', '%' ],
                    'range' => [
                        'px' => [
                            'min' => -2000,
                            'max' => 2000,
                        ],
                        '%' => [
                            'min' => -100,
                            'max' => 100,
                        ],
                    ],
                    'default' => [
                        'unit' => 'px',
                        'size' => 15,
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .exad-slider.dot-bullet ul.slick-dots' => 'bottom: {{SIZE}}{{UNIT}};',
                    ],
                ]
            );

            $this->add_responsive_control(
                'exad_slider_dot_bullet_position_right',
                [
                    'label' => __( 'Left & Right', 'exclusive-addons-elementor-pro' ),
                    'type' => Controls_Manager::SLIDER,
                    'size_units' => [ 'px', '%' ],
                    'range' => [
                        'px' => [
                            'min' => -2000,
                            'max' => 2000,
                        ],
                        '%' => [
                            'min' => -100,
                            'max' => 100,
                        ],
                    ],
                    'default' => [
                        'unit' => '%',
                        'size' => 50,
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .exad-slider.dot-bullet ul.slick-dots' => 'left: {{SIZE}}{{UNIT}};',
                    ],
                ]
            );

        $this->end_popover();

        $this->add_responsive_control(
            'exad_slider_dot_bullet_margin',
            [
                'label'        => __('Margin', 'exclusive-addons-elementor-pro'),
                'type'         => Controls_Manager::DIMENSIONS,
                'size_units'   => ['px', '%'],
                'default'      => [
                    'top'      => '0',
                    'right'    => '10',
                    'bottom'   => '0',
                    'left'     => '0',
                    'isLinked' => false
                ], 
                'selectors'    => [
                    '{{WRAPPER}} .exad-slider.dot-bullet ul.slick-dots li' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );


        $this->start_controls_tabs( 'exad_slider_dot_bullet_style_tabs' );

        // normal state tab
        $this->start_controls_tab( 'exad_slider_dot_bullet_normal', [ 'label' => esc_html__( 'Normal', 'exclusive-addons-elementor-pro' ) ] );

            $this->add_responsive_control(
                'exad_slider_dot_bullet_width',
                [
                    'label'       => __( 'Width', 'exclusive-addons-elementor-pro' ),
                    'type'        => Controls_Manager::SLIDER,
                    'range'       => [
                        'px'      => [
                            'min' => 0,
                            'max' => 100
                        ]
                    ],
                    'default'     => [
                        'size'    => 10,
                        'unit'    => 'px'
                    ],
                    'selectors'   => [
                        '{{WRAPPER}} .exad-slider.dot-bullet ul.slick-dots li' => 'width: {{SIZE}}{{UNIT}};'
                    ]
                ]
            );

            $this->add_responsive_control(
                'exad_slider_dot_bullet_height',
                [
                    'label'       => __( 'Height', 'exclusive-addons-elementor-pro' ),
                    'type'        => Controls_Manager::SLIDER,
                    'range'       => [
                        'px'      => [
                            'min' => 0,
                            'max' => 100
                        ]
                    ],
                    'default'     => [
                        'size'    => 10,
                        'unit'    => 'px'
                    ],
                    'selectors'   => [
                        '{{WRAPPER}} .exad-slider.dot-bullet ul.slick-dots li' => 'height: {{SIZE}}{{UNIT}};'
                    ]
                ]
            );

            $this->add_control(
                'exad_slider_dot_bullet_color',
                [
                    'label'     => esc_html__( 'Background Color', 'exclusive-addons-elementor-pro' ),
                    'type'      => Controls_Manager::COLOR,
                    'default'   => 'rgba(255,255,255,.3)',
                    'selectors' => [
                        '{{WRAPPER}} .exad-slider.dot-bullet ul.slick-dots li' => 'background-color: {{VALUE}};'
                    ]
                ]
            );

            $this->add_group_control(
                Group_Control_Border::get_type(),
                [
                    'name'            => 'exad_slider_dot_bullet_border',
                    'selector'        => '{{WRAPPER}} .exad-slider.dot-bullet ul.slick-dots li'
                ]
            );

            $this->add_responsive_control(
                'exad_slider_dot_bullet_border_radius',
                [
                    'label'      => esc_html__( 'Border Radius', 'exclusive-addons-elementor-pro' ),
                    'type'       => Controls_Manager::DIMENSIONS,
                    'default'    => [
                        'top'    => 100,
                        'right'  => 100,
                        'bottom' => 100,
                        'left'   => 100,
                        'unit'   => '%'
                    ],                
                    'size_units' => [ 'px', 'em', '%' ],
                    'selectors'  => [
                        '{{WRAPPER}} .exad-slider.dot-bullet ul.slick-dots li'=> 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                    ]
                ]
            );

            $this->end_controls_tab();

            // active state tab
            $this->start_controls_tab( 'exad_slider_dot_bullet_active', [ 'label' => esc_html__( 'Active', 'exclusive-addons-elementor-pro' ) ] );

            $this->add_responsive_control(
                'exad_slider_dot_bullet_active_width',
                [
                    'label'       => __( 'Width', 'exclusive-addons-elementor-pro' ),
                    'type'        => Controls_Manager::SLIDER,
                    'range'       => [
                        'px'      => [
                            'min' => 0,
                            'max' => 100
                        ]
                    ],
                    'default'     => [
                        'size'    => 10,
                        'unit'    => 'px'
                    ],
                    'selectors'   => [
                        '{{WRAPPER}} .exad-slider.dot-bullet ul.slick-dots li.slick-active' => 'width: {{SIZE}}{{UNIT}};'
                    ]
                ]
            );

            $this->add_responsive_control(
                'exad_slider_dot_bullet_active_height',
                [
                    'label'       => __( 'Height', 'exclusive-addons-elementor-pro' ),
                    'type'        => Controls_Manager::SLIDER,
                    'range'       => [
                        'px'      => [
                            'min' => 0,
                            'max' => 100
                        ]
                    ],
                    'default'     => [
                        'size'    => 10,
                        'unit'    => 'px'
                    ],
                    'selectors'   => [
                        '{{WRAPPER}} .exad-slider.dot-bullet ul.slick-dots li.slick-active' => 'height: {{SIZE}}{{UNIT}};'
                    ]
                ]
            );

            $this->add_control(
                'exad_slider_dot_bullet_active_color',
                [
                    'label'     => esc_html__( 'Background Color', 'exclusive-addons-elementor-pro' ),
                    'type'      => Controls_Manager::COLOR,
                    'default'   => 'rgba(255,255,255,1)',
                    'selectors' => [
                        '{{WRAPPER}} .exad-slider.dot-bullet ul.slick-dots li.slick-active' => 'background-color: {{VALUE}};'
                    ]
                ]
            );

            $this->add_group_control(
                Group_Control_Border::get_type(),
                [
                    'name'     => 'exad_slider_dot_bullet_active_border',
                    'selector' => '{{WRAPPER}} .exad-slider.dot-bullet ul.slick-dots li.slick-active'
                ]
            );

            $this->add_responsive_control(
                'exad_slider_dot_bullet_active_border_radius',
                [
                    'label'      => esc_html__( 'Border Radius', 'exclusive-addons-elementor-pro' ),
                    'type'       => Controls_Manager::DIMENSIONS,
                    'default'    => [
                        'top'    => 100,
                        'right'  => 100,
                        'bottom' => 100,
                        'left'   => 100,
                        'unit'   => '%'
                    ],                
                    'size_units'    => [ 'px', 'em', '%' ],
                    'selectors'  => [
                        '{{WRAPPER}} .exad-slider.dot-bullet ul.slick-dots li.slick-active'=> 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                    ]
                ]
            );

            $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();
    }
  
    protected function render() {
        $settings              = $this->get_settings_for_display();
        $exadSliderProgressbar = $settings['exad_slider_progress_bar'];
        $pauseOnHover          = $settings['exad_slider_pause_on_hover'];
        $autoplaySpeed         = $settings['exad_slider_autoplay_speed'];
        $autoplaySpeedInSecond = ( $settings['exad_slider_autoplay_speed'] / 1000 );
        
        $exadSliderControls    = ['exad-slider'];
        $exadSliderControls[]  =  'yes' === $settings['exad_slider_full_screen_size'] ? 'fullscreen' : '';
        
        $title_animation_in    = $settings['exad_slider_title_animation_in'];
        // var_dump($title_animation_in);
        $title_animation_out   = $settings['exad_slider_title_animation_out'];
        $title_delay_in        = $settings['exad_slider_title_animation_delay_in']['size'];
        $title_duration_in     = $settings['exad_slider_title_animation_duration_in']['size'];
        $title_duration_out    = $settings['exad_slider_title_animation_duration_out']['size'];
        
        $details_animation_in  = $settings['exad_slider_details_animation_in'];
        $details_animation_out = $settings['exad_slider_details_animation_out'];
        $details_delay_in      = $settings['exad_slider_details_animation_delay_in']['size'];
        $details_duration_in   = $settings['exad_slider_details_animation_duration_in']['size'];
        $details_duration_out  = $settings['exad_slider_details_animation_duration_out']['size'];
        
        $button_animation_in   = $settings['exad_slider_button_animation_in'];
        $button_animation_out  = $settings['exad_slider_button_animation_out'];
        $button_delay_in       = $settings['exad_slider_button_animation_delay_in']['size'];
        $button_duration_in    = $settings['exad_slider_button_animation_duration_in']['size'];
        $button_duration_out   = $settings['exad_slider_button_animation_duration_out']['size'];
        
        $bar                   = 'yes' === $exadSliderProgressbar ? 'active' : 'inactive';
        $direction             = is_rtl() ? 'true' : 'false';

        if ( 'both' || 'dots' === $settings['exad_slider_nav'] ) {
            $exadSliderControls[] = $settings['exad_slider_dots_type'];
        } else {
            $exadSliderControls[] = 'dot-hide';
        }

        $this->add_render_attribute(
            'exad_slider_controls',
            [
				'class'             => $exadSliderControls,
				'data-slider-nav'   => $settings['exad_slider_nav'],
				'data-slider-speed' => $settings['exad_slider_transition_speed'],
                'data-direction'    => $direction
            ]
        );

        if ( 'yes' === $settings['exad_slider_autoplay'] ) {
            $this->add_render_attribute( 'exad_slider_controls', 'data-autoplay', "true" );
            $this->add_render_attribute( 'exad_slider_controls', 'data-autoplayspeed', $settings['exad_slider_autoplay_speed'] );
	        if ( 'yes' === $settings['exad_slider_pause_on_hover'] ) {
	            $this->add_render_attribute( 'exad_slider_controls', 'data-pauseonhover', "true" );
	        }
        }

        if ( 'yes' === $settings['exad_slider_loop'] ) {
            $this->add_render_attribute( 'exad_slider_controls', 'data-loop', "true" );
        }
        
        if ( 'yes' === $settings['exad_slider_enable_fade'] ) {
            $this->add_render_attribute( 'exad_slider_controls', 'data-enable-fade', "true" );
        } else {
	        if ( 'yes' === $settings['exad_slider_slide_vertically'] ) {
	            $this->add_render_attribute( 'exad_slider_controls', 'data-slide-vertically', "true" );
	        } 
	        if ( 'yes' === $settings['exad_slider_enable_center_mode'] ) {
	            $this->add_render_attribute( 'exad_slider_controls', 'data-centermode', "true" );
	            $centerModePadding = $settings['exad_slider_padding_in_centermode']['size'];
	            $centerModePadding .= $settings['exad_slider_padding_in_centermode']['unit'];
	            $this->add_render_attribute( 'exad_slider_controls', 'data-centermode-padding', $centerModePadding );
	        }        	
        }

        if ( 'both' || 'dots' === $settings['exad_slider_nav'] ) {
            $this->add_render_attribute( 'exad_slider_controls', 'data-dots-type', $settings['exad_slider_dots_type'] );
        }

		if( is_array( $settings['exad_slides'] ) ): ?>
			<div <?php echo $this->get_render_attribute_string( 'exad_slider_controls' ); ?>>
				<?php foreach($settings['exad_slides'] as $key => $each_slide):
                    $each_title_animation_in  = $each_slide['exad_single_slider_title_animation_in'];
                    $each_title_animation_out = $each_slide['exad_single_slider_title_animation_out'];
                    $each_title_delay_in      = isset( $each_slide['exad_single_slider_title_animation_delay_in']['size'] );
                    $each_title_duration_in   = isset( $each_slide['exad_single_slider_title_animation_duration_in']['size'] );
                    $each_title_duration_out  = isset( $each_slide['exad_single_slider_title_animation_duration_out']['size'] );

                    $each_details_animation_in  = $each_slide['exad_single_slider_details_animation_in'];
                    $each_details_animation_out = $each_slide['exad_single_slider_details_animation_out'];
                    empty( $each_title_delay_in) ? $each_title_delay_in          = $title_delay_in : '';
                    empty( $each_title_duration_in ) ? $each_title_duration_in   = $title_duration_in : '';
                    empty( $each_title_duration_out ) ? $each_title_duration_out = $title_duration_out : '';

                    $title_delay_out = $autoplaySpeedInSecond - ( $each_title_delay_in + $each_title_duration_in + $each_title_duration_out );

                    
                    $each_details_delay_in      = isset( $each_slide['exad_single_slider_details_animation_delay_in']['size'] );
                    $each_details_duration_in   = isset( $each_slide['exad_single_slider_details_animation_duration_in']['size'] );
                    $each_details_duration_out  = isset( $each_slide['exad_single_slider_details_animation_duration_out']['size'] );

                    empty( $each_details_delay_in ) ? $each_details_delay_in         = $details_delay_in : '';
                    empty( $each_details_duration_in ) ? $each_details_duration_in   = $details_duration_in : '';
                    empty( $each_details_duration_out ) ? $each_details_duration_out = $details_duration_out : '';

                    $details_delay_out = $autoplaySpeedInSecond - ( $each_details_delay_in + $each_details_duration_in + $each_details_duration_out );

                    $each_button_animation_in  = $each_slide['exad_single_slider_button_animation_in'];
                    $each_button_animation_out = $each_slide['exad_single_slider_button_animation_out'];
                    $each_button_delay_in      = isset( $each_slide['exad_single_slider_button_animation_delay_in']['size'] );
                    $each_button_duration_in   = isset( $each_slide['exad_single_slider_button_animation_duration_in']['size'] );
                    $each_button_duration_out  = isset( $each_slide['exad_single_slider_button_animation_duration_out']['size'] );

                    empty( $each_button_delay_in ) ? $each_button_delay_in         = $button_delay_in : '';
                    empty( $each_button_duration_in ) ? $each_button_duration_in   = $button_duration_in : '';
                    empty( $each_button_duration_out ) ? $each_button_duration_out = $button_duration_out : '';

                    $button_delay_out = $autoplaySpeedInSecond - ( $each_button_delay_in + $each_button_duration_in + $each_button_duration_out );

                    if( 'yes' === $each_slide['exad_single_slider_custom_style'] ){
                        // title
                        if( 'default' === $each_slide['exad_single_slider_title_animation_in'] ){
                            $exad_title_animation_in = $title_animation_in;
                        } else {
                            $exad_title_animation_in = $each_title_animation_in;
                        }

                        if( 'default' === $each_slide['exad_single_slider_title_animation_out'] ){
                            $exad_title_animation_out = $title_animation_out;
                        } else {
                            $exad_title_animation_out = $each_title_animation_out;
                        }
                        // Details
                        if( 'default' === $each_slide['exad_single_slider_details_animation_in'] ){
                            $exad_details_animation_in = $details_animation_in;
                        } else {
                            $exad_details_animation_in = $each_details_animation_in;
                        }

                        if( 'default' === $each_slide['exad_single_slider_details_animation_out'] ){
                            $exad_details_animation_out = $details_animation_out;
                        } else {
                            $exad_details_animation_out = $each_details_animation_out;
                        }
                        // Button
                        if( 'default' === $each_slide['exad_single_slider_button_animation_in'] ){
                            $exad_button_animation_in = $button_animation_in;
                        } else {
                            $exad_button_animation_in = $each_button_animation_in;
                        }

                        if( 'default' === $each_slide['exad_single_slider_button_animation_out'] ){
                            $exad_button_animation_out = $button_animation_out;
                        } else {
                            $exad_button_animation_out = $each_button_animation_out;
                        }
                    } else {
                        $exad_title_animation_in = $title_animation_in;
                        $exad_title_animation_out = $title_animation_out;
                        $exad_details_animation_in = $details_animation_in;
                        $exad_details_animation_out = $details_animation_out;
                        $exad_button_animation_in = $button_animation_in;
                        $exad_button_animation_out = $button_animation_out;
                    }


                    ?>
					<div class="exad-each-slider-item elementor-repeater-item-<?php echo esc_attr( $each_slide['_id'] ); ?>" data-image="<?php echo esc_url( $each_slide['exad_slider_img']['url'] ); ?>">

						<div class="exad-slider-progressbar-<?php echo esc_attr( $bar ); ?>"></div>
                        <?php if ( 'yes' === $each_slide['exad_slider_bg_overlay'] ) { ?>
                            <div class="exad-slider-bg-overlay"></div>
                        <?php }; ?>
						<div class="exad-slide-bg"></div>

                        <div class="exad-slide-inner">
                            <div class="exad-slide-content exad-slide-content-title-background-<?php echo esc_attr( $settings['exad_single_slider_custom_style_title_background_enable'] ); ?>">
                                <?php if( $each_slide['exad_slider_title'] ) : ?>
                                    <<?php echo Utils::validate_html_tag( $settings['exad_slider_title_html_tag'] ); ?> class="exad-slider-title" data-animation-in="<?php echo esc_attr( $exad_title_animation_in ); ?>" data-delay-in="<?php echo esc_attr( $each_title_delay_in ); ?>" data-duration-in="<?php echo esc_attr( $each_title_duration_in ); ?>" data-animation-out="<?php echo esc_attr( $exad_title_animation_out ); ?>" data-delay-out="<?php echo esc_attr( $title_delay_out ); ?>" data-duration-out="<?php echo esc_attr( $each_title_duration_out ); ?>"><?php echo wp_kses_post($each_slide['exad_slider_title']); ?></<?php echo Utils::validate_html_tag( $settings['exad_slider_title_html_tag'] ); ?>>
                                <?php endif;

                                if( $each_slide['exad_slider_details'] ) : ?>
                                    <<?php echo Utils::validate_html_tag( $settings['exad_slider_details_html_tag'] ); ?> class="exad-slider-details" data-animation-in="<?php echo esc_attr( $exad_details_animation_in ); ?>" data-delay-in="<?php echo esc_attr( $each_details_delay_in ); ?>" data-duration-in="<?php echo esc_attr( $each_details_duration_in ); ?>" data-animation-out="<?php echo esc_attr( $exad_details_animation_out ); ?>" data-delay-out="<?php echo esc_attr( $details_delay_out ); ?>" data-duration-out="<?php echo esc_attr( $each_details_duration_out ); ?>"><?php echo wp_kses_post( $each_slide['exad_slider_details'] ); ?></<?php echo Utils::validate_html_tag( $settings['exad_slider_details_html_tag'] ); ?>>
                                <?php endif;

                                if ( ! empty( $each_slide['exad_slider_button_text'] ) ) :
                                    if ( $each_slide['exad_slider_button_url']['url'] ) {
                                        $href = 'href="'.esc_url($each_slide['exad_slider_button_url']['url']).'"';
                                    } else {
                                        $href = '';
                                    }
                                    if ( $each_slide['exad_slider_button_url']['is_external'] === 'on' ) {
                                        $target = ' target= _blank';
                                    } else {
                                        $target = '';
                                    }
                                    if ( $each_slide['exad_slider_button_url']['nofollow'] === 'on' ) {
                                        $target .= ' rel= nofollow ';
                                    } ?>
                                    <div class="exad-slider-btn">
                                        <a data-animation-in="<?php echo esc_attr( $exad_button_animation_in ); ?>" data-delay-in="<?php echo esc_attr( $each_button_delay_in ); ?>" data-duration-in="<?php echo esc_attr( $each_button_duration_in ); ?>" data-animation-out="<?php echo esc_attr( $exad_button_animation_out ); ?>" data-delay-out="<?php echo esc_attr( $button_delay_out ); ?>" data-duration-out="<?php echo esc_attr( $each_button_duration_out ); ?>" <?php echo $href.esc_attr( $target ); ?>><?php echo esc_html( $each_slide['exad_slider_button_text'] ); ?></a>
                                    </div>
                                <?php endif; ?>
			    			</div>
		    			</div>
		    		</div>
				<?php endforeach; ?>
			</div>
		<?php endif;
    }

}