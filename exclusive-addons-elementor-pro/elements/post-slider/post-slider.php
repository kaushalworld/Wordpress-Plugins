<?php
namespace ExclusiveAddons\Elements;

if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.

use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Border;
use \Elementor\Group_Control_Box_Shadow;
use \Elementor\Group_Control_Image_Size;
use \Elementor\Group_Control_Typography;
use \Elementor\Utils;
use \Elementor\Widget_Base;
use \ExclusiveAddons\Elementor\Helper;

class Post_Slider extends Widget_Base {

    public function get_name() {
        return 'exad-post-slider';
    }

    public function get_title() {
        return __( 'Post Slider', 'exclusive-addons-elementor-pro' );
    }

    public function get_icon() {
        return 'exad exad-logo exad-post-slider';
    }

    public function get_categories() {
        return [ 'exclusive-addons-elementor' ];
    }

    public function get_script_depends() {
        return [ 'exad-slick', 'exad-slick-animation' ];
    }

	protected function register_controls() {
		$exad_primary_color   = get_option( 'exad_primary_color_option', '#7a56ff' );

  		$this->start_controls_section(
  			'exad_post_slider_query',
  			[
  				'label' => __( 'Query', 'exclusive-addons-elementor-pro' )
  			]
  		);

  		$this->add_control(
            'exad_post_slider_type',
            [
				'label'   => __( 'Post Type', 'exclusive-addons-elementor-pro' ),
				'type'    => Controls_Manager::SELECT,
				'options' => Helper::exad_get_post_types(),
				'default' => 'post'

            ]
        );

        $this->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
				'name'    => 'image_size',
				'default' => 'full'
            ]
        );

        $this->add_control(
            'exad_post_slider_per_page',
            [
				'label'   => __( 'Number of Slider Items', 'exclusive-addons-elementor-pro' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => '6'
            ]
		);

        $this->add_control(
            'exad_post_slider_offset',
            [
                'label'   => __( 'Offset', 'exclusive-addons-elementor-pro' ),
                'type'    => Controls_Manager::NUMBER,
                'default' => '0'
            ]
        );

        $this->add_control(
        	'exad_post_slider_exclude_post',
        	[
				'label'       => __( 'Exclude Post', 'exclusive-addons-elementor-pro' ),
				'label_block' => true,
				'type'        => Controls_Manager::SELECT2,
				'multiple'    => true,
				'default'     => [],
				'options'     => Helper::exad_get_all_posts(),
				'condition'   => [
					'exad_post_slider_type' => 'post'
				]
            ]
        );

		$this->add_control(
        	'exad_post_slider_authors',
        	[
				'label'       => __( 'Author', 'exclusive-addons-elementor-pro' ),
				'label_block' => true,
				'type'        => Controls_Manager::SELECT2,
				'multiple'    => true,
				'default'     => [],
				'options'     => Helper::exad_get_authors()
            ]
        );

        $this->add_control(
        	'exad_post_slider_categories',
        	[
				'label'       => __( 'Categories', 'exclusive-addons-elementor-pro' ),
				'label_block' => true,
				'type'        => Controls_Manager::SELECT2,
				'multiple'    => true,
				'default'     => [],
				'options'     => Helper::exad_get_all_categories(),
				'condition'   => [
					'exad_post_slider_type' => 'post'
				]
            ]
        );

        $this->add_control(
        	'exad_post_slider_tags',
        	[
				'label'       => __( 'Tags', 'exclusive-addons-elementor-pro' ),
				'label_block' => true,
				'type'        => Controls_Manager::SELECT2,
				'multiple'    => true,
				'default'     => [],
				'options'     => Helper::exad_get_all_tags(),
				'condition'   => [
					'exad_post_slider_type' => 'post'
				]
            ]
        );

        $this->add_control(
            'exad_post_slider_order',
            [
				'label'    => __( 'Order', 'exclusive-addons-elementor-pro' ),
				'type'     => Controls_Manager::SELECT,
                'default'  => 'desc',
				'options'  => [
					'asc'  => __( 'Ascending', 'exclusive-addons-elementor-pro' ),
					'desc' => __( 'Descending', 'exclusive-addons-elementor-pro' )
                ]
            ]
        );

        $this->add_control(
            'exad_post_slider_order_by',
            [
				'label'    => __( 'Order By', 'exclusive-addons-elementor-pro' ),
				'type'     => Controls_Manager::SELECT,
                'default'  => 'date',
				'options'  => [
					'ID'  => __( 'ID', 'exclusive-addons-elementor-pro' ),
					'date'  => __( 'Date', 'exclusive-addons-elementor-pro' ),
					'modified' => __( 'Modified', 'exclusive-addons-elementor-pro' ),
					'author' => __( 'Author Name', 'exclusive-addons-elementor-pro' ),
					'title' => __( 'Post Title', 'exclusive-addons-elementor-pro' ),
					'name' => __( 'Post Name', 'exclusive-addons-elementor-pro' ),
                ]
            ]
        );

        $this->add_control(
            'exad_post_slider_show_only_post_has_image',
            [
                'label'         => __( 'Show only post has feature image.', 'exclusive-addons-elementor-pro' ),
                'type'          => Controls_Manager::SWITCHER,
                'default'       => 'yes',
                'return_value'  => 'yes'
            ]
        );

        $this->add_control(
			'exad_post_slider_ignore_sticky',
			[
				'label'        => __( 'Ignore Sticky?', 'exclusive-addons-elementor-pro' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'	   => __( 'On', 'exclusive-addons-elementor-pro' ),
				'label_off'    => __( 'Off', 'exclusive-addons-elementor-pro' ),
				'return_value' => 'yes',
				'default'      => 'yes'
			]
		); 

        $this->add_control(
            'exad_post_slider_show_excerpt',
            [
                'label'        => __( 'Enable Excerpt.', 'exclusive-addons-elementor-pro' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'	   => __( 'On', 'exclusive-addons-elementor-pro' ),
				'label_off'    => __( 'Off', 'exclusive-addons-elementor-pro' ),
                'default'      => 'yes',
                'return_value' => 'yes'
            ]
        );  

        $this->add_control(
            'exad_post_slider_excerpt_length',
            [
				'label'     => __( 'Excerpt Words Length', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => '25',
				'condition' => [
					'exad_post_slider_show_excerpt' => 'yes'
				]
            ]
        );

        $this->add_control(
			'exad_post_slider_show_title',
			[
				'label'        => __( 'Enable Title', 'exclusive-addons-elementor-pro' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'	   => __( 'On', 'exclusive-addons-elementor-pro' ),
				'label_off'    => __( 'Off', 'exclusive-addons-elementor-pro' ),
				'return_value' => 'yes',
				'default'      => 'yes'
			]
		);

		$this->add_control(
            'exad_post_slider_title_length',
            [
				'label'     => __( 'Title Words Length', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => '10',
				'condition' => [
					'exad_post_slider_show_title' => 'yes'
				]
            ]
        );

        $this->add_control(
            'exad_post_slider_title_tag',
            [
                'label'   => __('Title HTML Tag', 'exclusive-addons-elementor'),
                'type'    => Controls_Manager::SELECT,
                'options' => Helper::exad_title_tags(),
                'default' => 'h2',
            ]
		);

        $this->add_control(
            'exad_post_slider_show_read_more_btn',
            [
                'label'        => __( 'Enable Details Button', 'exclusive-addons-elementor-pro' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'	   => __( 'On', 'exclusive-addons-elementor-pro' ),
				'label_off'    => __( 'Off', 'exclusive-addons-elementor-pro' ),
                'default'      => 'yes',
                'return_value' => 'yes'
            ]
        );  

        $this->add_control(
            'exad_post_slider_show_read_more_btn_new_tab',
            [
                'label'        => esc_html__( 'Enable New Tab', 'exclusive-addons-elementor' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'	   => __( 'On', 'exclusive-addons-elementor' ),
				'label_off'    => __( 'Off', 'exclusive-addons-elementor' ),
                'default'      => 'yes',
                'return_value' => 'yes',
				'condition'     => [
                    'exad_post_slider_show_read_more_btn' => 'yes'
				],
            ]
        );

        $this->add_control(
            'exad_post_slider_read_more_btn_text',
            [   
                'label'         => __( 'Button Text', 'exclusive-addons-elementor-pro' ),
                'type'          => Controls_Manager::TEXT,
                'placeholder'   => __( 'Read More', 'exclusive-addons-elementor-pro'),
                'default'       => __( 'Read More', 'exclusive-addons-elementor-pro' ),
                'condition'     => [
                    '.exad_post_slider_show_read_more_btn' => 'yes'
                ]
            ]
        );

		$this->end_controls_section();

		$this->start_controls_section(
			'exad_post_slider_settings',
			[
				'label' => __( 'Settings', 'exclusive-addons-elementor-pro' )
			]
		);

        $this->add_control(
            'exad_post_slider_nav',
            [
                'label'      => __( 'Navigation', 'exclusive-addons-elementor-pro' ),
                'type'       => Controls_Manager::SELECT,
                'default'    => 'both',
                'options'    => [
                    'arrows' => __( 'Arrows', 'exclusive-addons-elementor-pro' ),
                    'dots'   => __( 'Dots', 'exclusive-addons-elementor-pro' ),
                    'both'   => __( 'Arrows and Dots', 'exclusive-addons-elementor-pro' ),
                    'none'   => __( 'None', 'exclusive-addons-elementor-pro' )
                ]
            ]
        );

        $this->add_control(
            'exad_post_slider_dots_type',
            [
                'label'     => __( 'Dots Type', 'exclusive-addons-elementor-pro' ),
                'type'      => Controls_Manager::SELECT,
                'default'   => 'dot-bullet',
                'options'   => [
                    'dot-bullet'      => __( 'Bullet', 'exclusive-addons-elementor-pro' ),
                    'dot-image'       => __( 'Image', 'exclusive-addons-elementor-pro' )
                    
                ],
                'condition' => [
                    'exad_post_slider_nav' => [ 'both', 'dots' ]
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
				'name'    => 'dot_image_size',
				'default' => 'medium_large',
                'condition' => [
                    'exad_post_slider_nav' => [ 'both', 'dots' ],
                    'exad_post_slider_dots_type' => ['dot-image']
                ]
            ]    
        );

        $this->add_control(
            'exad_post_slider_autoplay',
            [
				'label'   => __( 'Autoplay', 'exclusive-addons-elementor-pro' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes'
            ]
        );

        $this->add_control(
            'exad_post_slider_pause_on_hover',
            [
				'label'        => __( 'Pause on Hover', 'exclusive-addons-elementor-pro' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => 'no',
				'return_value' => 'yes',
                'condition'    => [
                    'exad_post_slider_autoplay' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'exad_post_slider_loop',
            [
                'label'   => __( 'Infinite Loop', 'exclusive-addons-elementor-pro' ),
                'type'    => Controls_Manager::SWITCHER,
                'default' => 'yes'
            ]
        );

        $this->add_control(
            'exad_post_slider_enable_fade',
            [
				'label'        => __( 'Enable Fade?', 'exclusive-addons-elementor-pro' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => 'no',
				'return_value' => 'yes'
            ]
        );

        $this->add_control(
            'exad_post_slider_slide_vertically',
            [
				'label'        => __( 'Enable Vertical Slide Mode?', 'exclusive-addons-elementor-pro' ),
				'type'         => Controls_Manager::SWITCHER,
				'description'  => __( 'Default sliders are slide horizontally. By enabling this feature, the slider will be slide vertically.', 'exclusive-addons-elementor-pro' ),
				'default'      => 'no',
				'return_value' => 'yes',
				'condition'    => [
					'exad_post_slider_enable_fade!' => 'yes'
				]
            ]
        );

        $this->add_control(
            'exad_post_slider_enable_center_mode',
            [
				'label'        => __( 'Enable Center Mode?', 'exclusive-addons-elementor-pro' ),
				'type'         => Controls_Manager::SWITCHER,
				'description'  => __( 'Enables centered view with partial prev/next slides. Use with odd numbered slidesToShow counts.', 'exclusive-addons-elementor-pro' ),
				'default'      => 'no',
				'return_value' => 'yes',
				'condition'	   => [
					'exad_post_slider_enable_fade!' => 'yes'
				]
            ]
        );

        $this->add_control(
            'exad_post_slider_progress_bar',
            [
				'type'         => Controls_Manager::SWITCHER,
				'label'        => __( 'Slider Progress Bar?', 'exclusive-addons-elementor-pro' ),
				'default'      => 'no',
				'return_value' => 'yes',
				'description'  => __('Progress bar in slider.', 'exclusive-addons-elementor-pro')
            ]
        );

        $this->add_control(
            'exad_post_slider_autoplay_speed',
            [
                'label'     => __( 'Autoplay Speed(ms)', 'exclusive-addons-elementor-pro' ),
                'type'      => Controls_Manager::NUMBER,
                'default'   => 5000,
				'selectors' => [
					'{{WRAPPER}} .slick-active.slick-current .exad-slider-progressbar-active' => 'animation-duration: {{SIZE}}ms;-moz-animation-duration: {{SIZE}}ms;-ms-animation-duration: {{SIZE}}ms;-webkit-animation-duration: {{SIZE}}ms;'
				],
                'condition' => [
                    'exad_post_slider_autoplay' => 'yes'
                ]
            ]
        );

		$this->add_control(
            'exad_post_slider_transition_speed',
            [
                'label'   => __( 'Transition Speed(ms)', 'exclusive-addons-elementor-pro' ),
                'type'    => Controls_Manager::NUMBER,
                'default' => 1000
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'exad_post_slider_container_style',
            [
                'label' => __( 'Container', 'exclusive-addons-elementor-pro' ),
                'tab'   => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_control(
            'exad_enable_slider_bg_overlay',
            [
                'label'        => __( 'Background Overlay', 'exclusive-addons-elementor-pro' ),
                'type'         => Controls_Manager::SWITCHER,
                'default'      => 'yes',
                'return_value' => 'yes'
            ]
        );

        $this->add_control(
            'exad_post_slider_bg_overlay_color',
            [
                'label'     => __( 'Overlay Color', 'exclusive-addons-elementor-pro' ),
                'type'      => Controls_Manager::COLOR,
                'label_on'  => __( 'Enable', 'exclusive-addons-elementor-pro' ),
				'label_off' => __( 'Disable', 'exclusive-addons-elementor-pro' ),
                'default'   => 'rgba(0,0,0,0.3)',
                'selectors' => [
                    '{{WRAPPER}} .exad-slider-bg-overlay' => 'background-color: {{VALUE}};'
                ],
                'condition' => [
                	'exad_enable_slider_bg_overlay' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'exad_post_slider_full_screen_size',
            [
				'label'        => __( 'Height Full Screen?', 'exclusive-addons-elementor-pro' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => 'no',
				'return_value' => 'yes',
				'description'  => __( 'Set your slider fullscreen.', 'exclusive-addons-elementor-pro' )
            ]
        );

		$this->add_responsive_control(
			'exad_post_slider_height',
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
					'exad_post_slider_full_screen_size!' => 'yes'
				]
			]
		);

		$this->add_responsive_control(
			'exad_post_slider_content_max_width',
			[
				'label'          => __( 'Content Width', 'exclusive-addons-elementor-pro' ),
				'type'           => Controls_Manager::SLIDER,
				'range'          => [
					'px'         => [
						'min'    => 0,
						'max'    => 1000
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
            'exad_post_slider_content_padding',
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
			'exad_post_slider_padding_in_centermode',
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
                    'exad_post_slider_enable_center_mode' => 'yes',
                    'exad_post_slider_enable_fade!'       => 'yes'
				]
			]
		);

		$this->add_responsive_control(
			'exad_post_slider_horizontal_position',
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
				'selectors'      => [
					'{{WRAPPER}} .exad-slider .exad-slide-inner' => 'justify-content: {{VALUE}}; -webkit-justify-content: {{VALUE}};'
				]
			]
		);

		$this->add_responsive_control(
			'exad_post_slider_vertical_position',
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
			'exad_post_slider_text_align',
			[
				'label'         => __( 'Text Align', 'exclusive-addons-elementor-pro' ),
				'type'          => Controls_Manager::CHOOSE,
                'toggle'        => false,
				'label_block'   => false,
				'default'       => 'center',
				'options'       => [
                    'left'      => [
                        'title' => __( 'Left', 'exclusive-addons-elementor-pro' ),
                        'icon'  => 'eicon-text-align-left'
                    ],
                    'center'    => [
                        'title' => __( 'Center', 'exclusive-addons-elementor-pro' ),
                        'icon'  => 'eicon-text-align-center'
                    ],
                    'right'     => [
                        'title' => __( 'Right', 'exclusive-addons-elementor-pro' ),
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
				'name' => 'exad_post_slider_container_boeder',
				'label' => __( 'Border', 'exclusive-addons-elementor-pro' ),
				'selector' => '{{WRAPPER}} .exad-post-slider .exad-each-slider-item',
			]
        );
        
        $this->add_responsive_control(
            'exad_post_slider_container_radius',
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
                    '{{WRAPPER}} .exad-post-slider .exad-each-slider-item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->add_responsive_control(
            'exad_post_slider_container_item_margin',
            [
                'label'         => __( 'Item Margin', 'exclusive-addons-elementor-pro' ),
                'type'          => Controls_Manager::DIMENSIONS,              
                'size_units'    => [ 'px', 'em', '%' ],
                'selectors'     => [
                    '{{WRAPPER}} .exad-post-slider .exad-each-slider-item' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'exad_post_slider_container_item_shadow',
				'selector' => '{{WRAPPER}} .exad-post-slider .exad-each-slider-item'
			]
		);

        $this->end_controls_section();

        $this->start_controls_section(
            'exad_post_slider_content_style',
            [
                'label' => __( 'Content Title', 'exclusive-addons-elementor-pro' ),
                'tab'   => Controls_Manager::TAB_STYLE,
                'condition' => [
					'exad_post_slider_show_title' => 'yes'
				]
            ]
        );

		$this->add_control(
		    'exad_post_slider_title_color',
		    [
		        'label'     => __( 'Color', 'exclusive-addons-elementor-pro' ),
		        'type'      => Controls_Manager::COLOR,
		        'default'	=> '#ffffff',
		        'selectors' => [
		            '{{WRAPPER}} .exad-slide-content .exad-post-slider-title' => 'color: {{VALUE}};'
		        ],
				'condition' => [
					'exad_post_slider_show_title' => 'yes'
				]
		    ]
		);

		$this->add_control(
		    'exad_post_slider_title_bg_color',
		    [
		        'label'     => __( 'Background Color', 'exclusive-addons-elementor-pro' ),
		        'type'      => Controls_Manager::COLOR,
		        'selectors' => [
		            '{{WRAPPER}} .exad-slide-content .exad-post-slider-title' => 'background-color: {{VALUE}};'
		        ],
				'condition' => [
					'exad_post_slider_show_title' => 'yes'
				]
		    ]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
            	'name'		=> 'exad_post_slider_title_typography',
				'selector'	=> '{{WRAPPER}} .exad-slide-content .exad-post-slider-title',
				'condition' => [
					'exad_post_slider_show_title' => 'yes'
				]
			]
		);

        $this->add_responsive_control(
            'exad_post_slider_title_padding',
            [
				'label'      => __('Padding', 'exclusive-addons-elementor-pro'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors'  => [
                    '{{WRAPPER}} .exad-slide-content .exad-post-slider-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
				'condition' => [
					'exad_post_slider_show_title' => 'yes'
				]
            ]
        );

        $this->add_responsive_control(
            'exad_post_slider_title_margin',
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
                    '{{WRAPPER}} .exad-slide-content .exad-post-slider-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
				'condition' => [
					'exad_post_slider_show_title' => 'yes'
				]
            ]
        );

        $this->add_group_control(
        	Group_Control_Border::get_type(),
            [
                'name'      => 'exad_post_slider_title_border',
                'selector'  => '{{WRAPPER}} .exad-slide-content .exad-post-slider-title',
				'condition' => [
					'exad_post_slider_show_title' => 'yes'
				]
            ]
        );

		$this->add_responsive_control(
			'exad_post_slider_title_border_radius',
			[
				'label'      => __( 'Border Radius', 'exclusive-addons-elementor-pro' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px'],
				'selectors'  => [
					'{{WRAPPER}} .exad-slide-content .exad-post-slider-title'=> 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				],
				'condition' => [
					'exad_post_slider_show_title' => 'yes'
				]
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'      => 'exad_post_slider_title_box_shadow',
				'selector'  => '{{WRAPPER}} .exad-slide-content .exad-post-slider-title',
				'condition' => [
					'exad_post_slider_show_title' => 'yes'
				]
			]
		);

        $this->add_control(
            'exad_post_slider_title_animation_in',
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
                ],
				'condition'        => [
					'exad_post_slider_show_title' => 'yes'
				]
            ]
        );

        $this->add_control(
            'exad_post_slider_title_animation_out',
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
                ],
				'condition'         => [
					'exad_post_slider_show_title' => 'yes'
				]
            ]
        );

        $this->add_control(
            'exad_post_slider_title_animation_delay_in',
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
                ],
				'condition'     => [
					'exad_post_slider_show_title' => 'yes'
				] 
            ]
        ); 

        $this->add_control(
            'exad_post_slider_title_animation_duration_in',
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
                ],
				'condition'     => [
					'exad_post_slider_show_title' => 'yes'
				] 
            ]
        );

        $this->add_control(
            'exad_post_slider_title_animation_duration_out',
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
                ],
				'condition'     => [
					'exad_post_slider_show_title' => 'yes'
				]  
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'exad_post_slider_content_details_style',
            [
                'label' => __( 'Content Details', 'exclusive-addons-elementor-pro' ),
                'tab'   => Controls_Manager::TAB_STYLE,
                'condition' => [
					'exad_post_slider_show_excerpt' => 'yes'
				]
            ]
        );

		$this->add_control(
		    'exad_post_slider_details_color',
		    [
		        'label'     => __( 'Color', 'exclusive-addons-elementor-pro' ),
		        'type'      => Controls_Manager::COLOR,
		        'default'	=> '#ffffff',
		        'selectors' => [
		            '{{WRAPPER}} .exad-slide-content .exad-slider-excerpt' => 'color: {{VALUE}};'
		        ],
				'condition' => [
					'exad_post_slider_show_excerpt' => 'yes'
				]
		    ]
		);

		$this->add_control(
		    'exad_post_slider_details_bg_color',
		    [
		        'label'     => __( 'Background Color', 'exclusive-addons-elementor-pro' ),
		        'type'      => Controls_Manager::COLOR,
		        'selectors' => [
		            '{{WRAPPER}} .exad-slide-content .exad-slider-excerpt' => 'background-color: {{VALUE}};'
		        ],
				'condition' => [
					'exad_post_slider_show_excerpt' => 'yes'
				]
		    ]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
            	'name'		=> 'exad_post_slider_details_typography',
				'selector'	=> '{{WRAPPER}} .exad-slide-content .exad-slider-excerpt',
				'condition' => [
					'exad_post_slider_show_excerpt' => 'yes'
				]
			]
		);

        $this->add_responsive_control(
            'exad_post_slider_details_padding',
            [
                'label'      => __('Padding', 'exclusive-addons-elementor-pro'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .exad-slide-content .exad-slider-excerpt' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
				'condition' => [
					'exad_post_slider_show_excerpt' => 'yes'
				]
            ]
        );

        $this->add_responsive_control(
            'exad_post_slider_details_margin',
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
                    '{{WRAPPER}} .exad-slide-content .exad-slider-excerpt' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
				'condition'    => [
					'exad_post_slider_show_excerpt' => 'yes'
				]
            ]
        );

        $this->add_group_control(
        	Group_Control_Border::get_type(),
            [
                'name'      => 'exad_post_slider_details_border',
                'selector'  => '{{WRAPPER}} .exad-slide-content .exad-slider-excerpt',
				'condition' => [
					'exad_post_slider_show_excerpt' => 'yes'
				]
            ]
        );

		$this->add_responsive_control(
			'exad_post_slider_details_border_radius',
			[
				'label'      => __( 'Border Radius', 'exclusive-addons-elementor-pro' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px'],
				'selectors'  => [
					'{{WRAPPER}} .exad-slide-content .exad-slider-excerpt'=> 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				],
				'condition' => [
					'exad_post_slider_show_excerpt' => 'yes'
				]
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'exad_post_slider_details_box_shadow',
				'selector' => '{{WRAPPER}} .exad-slide-content .exad-slider-excerpt',
				'condition' => [
					'exad_post_slider_show_excerpt' => 'yes'
				]
			]
		);

        $this->add_control(
            'exad_post_slider_details_animation_in',
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
                ],
				'condition'        => [
					'exad_post_slider_show_excerpt' => 'yes'
				]
            ]
        );

        $this->add_control(
            'exad_post_slider_details_animation_out',
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
                ],
				'condition'         => [
					'exad_post_slider_show_excerpt' => 'yes'
				]
            ]
        );

        $this->add_control(
            'exad_post_slider_details_animation_delay_in',
            [
                'label'         => __( 'Delay In', 'exclusive-addons-elementor-pro' ),
                'type'          => Controls_Manager::SLIDER,
                'default'       => [
                    'size'      => .2
                ],
                'range'         => [
                    'px'        => [
                        'min'   => 0,
                        'max'   => 1,
                        'step'  => .1
                    ]
                ],
				'condition'     => [
					'exad_post_slider_show_excerpt' => 'yes'
				]
            ]
        ); 

        $this->add_control(
            'exad_post_slider_details_animation_duration_in',
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
                ],
				'condition'     => [
					'exad_post_slider_show_excerpt' => 'yes'
				]
            ]
        );

        $this->add_control(
            'exad_post_slider_details_animation_duration_out',
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
                ],
				'condition'     => [
					'exad_post_slider_show_excerpt' => 'yes'
				]
            ]
        );

        $this->end_controls_section();

		$this->start_controls_section(
            'exad_post_slider_btn_style_section',
            [
				'label'     => __( 'Content Button', 'exclusive-addons-elementor-pro' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
                	'exad_post_slider_show_read_more_btn' => 'yes'
                ]
            ]
        );

        $this->add_responsive_control(
            'exad_post_slider_btn_padding',
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
            'exad_post_slider_btn_margin',
            [
                'label'      => __( 'Margin', 'exclusive-addons-elementor-pro' ),
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
                'name'     => 'exad_post_slider_btn_typography',
                'selector' => '{{WRAPPER}} .exad-slide-content a'
            ]
        );

        $this->add_control(
            'exad_post_slider_button_animation_in',
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
            'exad_post_slider_button_animation_out',
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
            'exad_post_slider_button_animation_delay_in',
            [
                'label'         => __( 'Delay In', 'exclusive-addons-elementor-pro' ),
                'type'          => Controls_Manager::SLIDER,
                'default'       => [
                    'size'      => .3
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
            'exad_post_slider_button_animation_duration_in',
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
            'exad_post_slider_button_animation_duration_out',
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

        $this->start_controls_tabs( 'exad_post_slider_button_style_tabs' );

            // normal state tab
            $this->start_controls_tab( 'exad_post_slider_btn_normal', [ 'label' => __( 'Normal', 'exclusive-addons-elementor-pro' ) ] );

            $this->add_control(
                'exad_post_slider_btn_normal_text_color',
                [
                    'label'     => __( 'Color', 'exclusive-addons-elementor-pro' ),
                    'type'      => Controls_Manager::COLOR,
                    'default'   => '#ffffff',
                    'selectors' => [
                        '{{WRAPPER}} .exad-slide-content a' => 'color: {{VALUE}};'
                    ]
                ]
            );

            $this->add_control(
                'exad_post_slider_btn_normal_bg_color',
                [
                    'label'     => __( 'Background Color', 'exclusive-addons-elementor-pro' ),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .exad-slide-content a' => 'background-color: {{VALUE}};'
                    ]
                ]
            );

	       	$this->add_group_control(
	            Group_Control_Border::get_type(),
	            [
	                'name'               => 'exad_post_slider_btn_border',
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
				'exad_post_slider_button_border_radius',
				[
					'label'      => __( 'Border Radius', 'exclusive-addons-elementor-pro' ),
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
                    'name'      => 'exad_post_slider_button_shadow',
                    'selector'  => '{{WRAPPER}} .exad-slide-content a',
                    'separator' => 'before'
                ]
            );

            $this->end_controls_tab();

            // hover state tab
            $this->start_controls_tab( 'exad_post_slider_btn_hover', [ 'label' => __( 'Hover', 'exclusive-addons-elementor-pro' ) ] );

            $this->add_control(
                'exad_post_slider_btn_hover_text_color',
                [
                    'label'     => __( 'Color', 'exclusive-addons-elementor-pro' ),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .exad-slide-content a:hover' => 'color: {{VALUE}};'
                    ]
                ]
            );

            $this->add_control(
                'exad_post_slider_btn_hover_bg_color',
                [
                    'label'     => __( 'Background Color', 'exclusive-addons-elementor-pro' ),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .exad-slide-content a:hover' => 'background: {{VALUE}};'
                    ]
                ]
            );

            $this->add_group_control(
                Group_Control_Border::get_type(),
                [
                    'name'     => 'exad_post_slider_btn_hover_border',
                    'selector' => '{{WRAPPER}} .exad-slide-content a:hover'
                ]
            );

			$this->add_responsive_control(
				'exad_post_slider_button_border_radius_hover',
				[
					'label'      => __( 'Border Radius', 'exclusive-addons-elementor-pro' ),
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
                    'name'      => 'exad_post_slider_button_hover_shadow',
                    'selector'  => '{{WRAPPER}} .exad-slide-content a:hover'
                ]
            );

            $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section(); 

        $this->start_controls_section(
            'exad_post_slider_progressbar_style_section',
            [
                'label'         => __('Progressbar', 'exclusive-addons-elementor-pro'),
                'tab'           => Controls_Manager::TAB_STYLE,
                'condition'     => [
                    'exad_post_slider_progress_bar' => 'yes'
                ]                
            ]
        );

        $this->add_control(
            'exad_post_slider_progressbar_color',
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
            'exad_post_slider_progressbar_height',
            [
                'label'         => __( 'Height', 'exclusive-addons-elementor-pro' ),
                'type'          => Controls_Manager::SLIDER,
                'default'       => [
                    'size'      => 7
                ],
                'range'         => [
                    'px'        => [
                        'min'   => 1,
                        'max'   => 20,
                        'step'  => 1
                    ]
                ],
                'selectors'     => [
                    '{{WRAPPER}} .slick-active.slick-current .exad-slider-progressbar-active' => 'height: {{SIZE}}{{UNIT}};'
                ],  
                'description'   => __( 'Default: 7px.', 'exclusive-addons-elementor-pro' )            
            ]
        ); 

        $this->end_controls_section();

        $this->start_controls_section(
            'exad_post_slider_arrow_controls_style_section',
            [
                'label'     => __('Arrow Controls', 'exclusive-addons-elementor-pro' ),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'exad_post_slider_nav' => [ 'arrows', 'both' ]
                ]               
            ]
        );

        // $this->add_responsive_control(
		// 	'exad_post_slider_vertical_offset',
		// 	[
		// 		'label'        => __( 'Vertical Offset', 'exclusive-addons-elementor-pro' ),
		// 		'type'         => Controls_Manager::SLIDER,
		// 		'size_units'   => [ 'px', '%' ],
		// 		'range'        => [
		// 			'px'       => [
		// 				'min'  => -1000,
		// 				'max'  => 1000,
		// 				'step' => 5
		// 			],
		// 			'%'        => [
		// 				'min'  => 0,
		// 				'max'  => 100
		// 			]
		// 		],
		// 		'default'      => [
		// 			'unit'     => '%',
		// 			'size'     => 50
		// 		],
		// 		'selectors'    => [
		// 			'{{WRAPPER}} .exad-slider .slick-next, {{WRAPPER}} .exad-slider .slick-prev' => 'top: {{SIZE}}{{UNIT}};'
		// 		]
		// 	]
		// );

        $this->add_responsive_control(
            'exad_post_slider_arrows_size',
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
            'exad_post_slider_arrow_width',
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
            'exad_post_slider_arrow_height',
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
			'exad_post_slider_prev_arrow_position',
			[
				'label' => __( 'Previous Arrow Position', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::POPOVER_TOGGLE,
				'label_off' => __( 'Default', 'exclusive-addons-elementor-pro' ),
				'label_on' => __( 'Custom', 'exclusive-addons-elementor-pro' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
        );
        
        $this->start_popover();

            $this->add_responsive_control(
                'exad_post_slider_prev_arrow_position_x_offset',
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
                        'unit' => 'px',
                        'size' => 30,
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .exad-post-slider .slick-prev' => 'left: {{SIZE}}{{UNIT}};',
                    ],
                ]
            );

            $this->add_responsive_control(
                'exad_post_slider_prev_arrow_position_y_offset',
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
                        '{{WRAPPER}} .exad-post-slider .slick-prev' => 'top: {{SIZE}}{{UNIT}};',
                    ],
                ]
            );

        $this->end_popover();

        $this->add_control(
			'exad_post_slider_next_arrow_position',
			[
				'label' => __( 'Next Arrow Position', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::POPOVER_TOGGLE,
				'label_off' => __( 'Default', 'exclusive-addons-elementor-pro' ),
				'label_on' => __( 'Custom', 'exclusive-addons-elementor-pro' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
        );
        
        $this->start_popover();

            $this->add_responsive_control(
                'exad_post_slider_next_arrow_position_x_offset',
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
                        'unit' => 'px',
                        'size' => 30,
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .exad-post-slider .slick-next' => 'right: {{SIZE}}{{UNIT}};',
                    ],
                ]
            );

            $this->add_responsive_control(
                'exad_post_slider_next_arrow_position_y_offset',
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
                        '{{WRAPPER}} .exad-post-slider .slick-next' => 'top: {{SIZE}}{{UNIT}};',
                    ],
                ]
            );

        $this->end_popover();

		$this->start_controls_tabs( 'exad_post_slider_arrows_style_tabs' );

        	// normal state tab
        	$this->start_controls_tab( 'exad_post_slider_arrow_normal_style', [ 'label' => __( 'Normal', 'exclusive-addons-elementor-pro' ) ] );

		        $this->add_control(
		            'exad_post_slider_arrows_color',
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
		            'exad_post_slider_arrows_bg_color',
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
		                'name'      => 'exad_post_slider_arrows_border',
		                'selector'  => '{{WRAPPER}} .exad-slider .slick-next,{{WRAPPER}} .exad-slider .slick-prev'
		            ]
		        );

				$this->add_responsive_control(
					'exad_post_slider_arrows_border_radius',
					[
						'label'      => __( 'Border Radius', 'exclusive-addons-elementor-pro' ),
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
                
                $this->add_group_control(
                    Group_Control_Box_Shadow::get_type(),
                    [
                        'name'     => 'exad_post_slider_arrows_box_shadow',
                        'selector' => '{{WRAPPER}} .exad-slider .slick-next,{{WRAPPER}} .exad-slider .slick-prev'
                    ]
                );

			$this->end_controls_tab();


        	// hover state tab
        	$this->start_controls_tab( 'exad_post_slider_arrow_hover_style', [ 'label' => __( 'Hover', 'exclusive-addons-elementor-pro' ) ] );

		        $this->add_control(
		            'exad_post_slider_arrows_hover_color',
		            [
		                'label'         => __( 'Color', 'exclusive-addons-elementor-pro' ),
		                'type'          => Controls_Manager::COLOR,
		                'selectors'     => [
		                    '{{WRAPPER}} .exad-slider .slick-next:hover:before,{{WRAPPER}} .exad-slider .slick-prev:hover:before' => 'color: {{VALUE}};'
		                ]          
		            ]
		        );

		        $this->add_control(
		            'exad_post_slider_arrows_hover_bg_color',
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
		                'name'      => 'exad_post_slider_arrows_hover_border',
		                'selector'  => '{{WRAPPER}} .exad-slider .slick-next:hover,{{WRAPPER}} .exad-slider .slick-prev:hover'
		            ]
		        );


				$this->add_responsive_control(
					'exad_post_slider_arrows_hover_border_radius',
					[
						'label'      => __( 'Border Radius', 'exclusive-addons-elementor-pro' ),
						'type'       => Controls_Manager::DIMENSIONS,
						'size_units' => [ 'px'],
						'selectors'  => [
							'{{WRAPPER}} .exad-slider .slick-next:hover,{{WRAPPER}} .exad-slider .slick-prev:hover'=> 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
						]
					]
                );
                
                $this->add_group_control(
                    Group_Control_Box_Shadow::get_type(),
                    [
                        'name'     => 'exad_post_slider_arrows_hover_box_shadow',
                        'selector' => '{{WRAPPER}} .exad-slider .slick-next:hover,{{WRAPPER}} .exad-slider .slick-prev:hover'
                    ]
                );

			$this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();

        $this->start_controls_section(
            'exad_post_slider_dot_image_controls_style_section',
            [
                'label'     => __('Dots Thumbnail', 'exclusive-addons-elementor-pro' ),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'exad_post_slider_nav'       => ['dots', 'both'],
                    'exad_post_slider_dots_type' => 'dot-image'
                ]                
            ]
        );

        $this->add_responsive_control(
            'exad_post_slider_dot_image_padding',
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
            'exad_post_slider_dot_image_margin',
            [
                'label'        => __('Margin', 'exclusive-addons-elementor-pro'),
                'type'         => Controls_Manager::DIMENSIONS,
                'size_units'   => ['px', '%'],
                'default'      => [
                    'top'      => '20',
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
            'exad_post_slider_dot_image_height',
            [
                'label'       => __( 'Height', 'exclusive-addons-elementor-pro' ),
                'type'        => Controls_Manager::SLIDER,
                'range'       => [
                    'px'      => [
                        'min' => 50,
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
            'exad_post_slider_dot_image_width',
            [
                'label'       => __( 'Width', 'exclusive-addons-elementor-pro' ),
                'type'        => Controls_Manager::SLIDER,
                'range'       => [
                    'px'      => [
                        'min' => 50,
                        'max' => 5000
                    ]
                ],
                'selectors'   => [
                    '{{WRAPPER}} .exad-slider .slick-dots li a' => 'width: {{SIZE}}{{UNIT}};'
                ]
            ]
        );

        $this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'exad_post_slider_dot_image_border',
				'label' => __( 'Border', 'exclusive-addons-elementor-pro' ),
				'selector' => '{{WRAPPER}} .exad-slider .slick-dots li a img',
			]
        );

        $this->add_responsive_control(
            'exad_post_slider_dot_image_border_radius',
            [
                'label'      => __( 'Border Radius', 'exclusive-addons-elementor-pro' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px'],
                'selectors'  => [
                    '{{WRAPPER}} .exad-slider .slick-dots li a img'=> 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'exad_post_slider_dot_image_shadow',
				'selector' => '{{WRAPPER}} .exad-slider .slick-dots li a img'
			]
		);

        $this->end_controls_section();

        $this->start_controls_section(
            'exad_post_slider_dot_bullet_controls_style_section',
            [
                'label'     => __('Dots Bullet', 'exclusive-addons-elementor-pro' ),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'exad_post_slider_nav'       => ['dots', 'both'],
                    'exad_post_slider_dots_type' => 'dot-bullet'
                ]                
            ]
        );

        $this->add_responsive_control(
            'exad_post_slider_dot_bullet_margin',
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

        $this->add_control(
			'exad_post_slider_dot_bullet_position',
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
                'exad_post_slider_dot_bullet_position_left',
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
                'exad_post_slider_dot_bullet_position_right',
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

        $this->start_controls_tabs( 'exad_post_slider_dot_bullet_style_tabs' );

        // normal state tab
        $this->start_controls_tab( 'exad_post_slider_dot_bullet_normal', [ 'label' => __( 'Normal', 'exclusive-addons-elementor-pro' ) ] );

            $this->add_responsive_control(
                'exad_post_slider_dot_bullet_width',
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
                'exad_post_slider_dot_bullet_height',
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
                'exad_post_slider_dot_bullet_color',
                [
                    'label'     => __( 'Color', 'exclusive-addons-elementor-pro' ),
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
                    'name'            => 'exad_post_slider_dot_bullet_border',
                    'selector'        => '{{WRAPPER}} .exad-slider.dot-bullet ul.slick-dots li'
                ]
            );

            $this->add_responsive_control(
                'exad_post_slider_dot_bullet_border_radius',
                [
                    'label'      => __( 'Border Radius', 'exclusive-addons-elementor-pro' ),
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
            $this->start_controls_tab( 'exad_post_slider_dot_bullet_active', [ 'label' => __( 'Active', 'exclusive-addons-elementor-pro' ) ] );

            $this->add_responsive_control(
                'exad_post_slider_dot_bullet_active_width',
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
                'exad_post_slider_dot_bullet_active_height',
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
                'exad_post_slider_dot_bullet_active_color',
                [
                    'label'     => __( 'Color', 'exclusive-addons-elementor-pro' ),
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
                    'name'     => 'exad_post_slider_dot_bullet_active_border',
                    'selector' => '{{WRAPPER}} .exad-slider.dot-bullet ul.slick-dots li.slick-active'
                ]
            );

            $this->add_responsive_control(
                'exad_post_slider_dot_bullet_active_border_radius',
                [
                    'label'      => __( 'Border Radius', 'exclusive-addons-elementor-pro' ),
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

	private function render_image( $image_id, $image_size, $settings ) {

        if ( has_post_thumbnail() ) {
            $image_src = Group_Control_Image_Size::get_attachment_image_src( $image_id, $image_size, $settings );
        } else {
            $image_src = EXAD_ASSETS_URL . 'img/placeholder.png';
        }

        return $image_src;
    }

	protected function render() {
		$settings              = $this->get_settings_for_display();
		$exadSliderProgressbar = $settings['exad_post_slider_progress_bar'];
		$autoplaySpeedInSecond = ( $settings['exad_post_slider_autoplay_speed'] / 1000 );
		$args                  = Helper::exad_get_post_arguments( $settings, 'exad_post_slider' );
       
        $bar                   = 'yes' === $exadSliderProgressbar ? 'active' : 'inactive';
        $direction             = is_rtl() ? 'true' : 'false';

        $exadSliderControls    = [ 'exad-slider', 'exad-post-slider' ];
        $exadSliderControls[]  =  'yes' === $settings['exad_post_slider_full_screen_size'] ? 'fullscreen' : '';

        if ( 'both' || 'dots' === $settings['exad_post_slider_nav'] ) :
            $exadSliderControls[] = esc_attr( $settings['exad_post_slider_dots_type'] );
        else :
            $exadSliderControls[] = 'dot-hide';
        endif;

        $this->add_render_attribute(
            'exad_post_slider_controls',
            [
				'class'             => $exadSliderControls,
				'data-slider-nav'   => esc_attr( $settings['exad_post_slider_nav'] ),
				'data-slider-speed' => esc_attr( $settings['exad_post_slider_transition_speed'] ),
                'data-direction'    => esc_attr( $direction )
            ]
        );

        if ( 'yes' === $settings['exad_post_slider_autoplay'] ) :
            $this->add_render_attribute( 'exad_post_slider_controls', 'data-autoplay', 'true' );
            $this->add_render_attribute( 'exad_post_slider_controls', 'data-autoplayspeed', esc_attr( $settings['exad_post_slider_autoplay_speed'] ) );
	        if ( 'yes' === $settings['exad_post_slider_pause_on_hover'] ) :
	            $this->add_render_attribute( 'exad_post_slider_controls', 'data-pauseonhover', 'true' );
	        endif;
        endif;

        if ( 'yes' === $settings['exad_post_slider_loop'] ) :
            $this->add_render_attribute( 'exad_post_slider_controls', 'data-loop', 'true' );
        endif;
        
        if ( 'yes' === $settings['exad_post_slider_enable_fade'] ) :
            $this->add_render_attribute( 'exad_post_slider_controls', 'data-enable-fade', 'true' );
        else :
	        if ( 'yes' === $settings['exad_post_slider_slide_vertically'] ) :
	            $this->add_render_attribute( 'exad_post_slider_controls', 'data-slide-vertically', 'true' );
	        endif;
	        if ( 'yes' === $settings['exad_post_slider_enable_center_mode'] ) :
	            $this->add_render_attribute( 'exad_post_slider_controls', 'data-centermode', 'true' );
	            $centerModePadding = $settings['exad_post_slider_padding_in_centermode']['size'];
	            $centerModePadding .= $settings['exad_post_slider_padding_in_centermode']['unit'];
	            $this->add_render_attribute( 'exad_post_slider_controls', 'data-centermode-padding', esc_attr( $centerModePadding ) );
	        endif;
        endif;

        if ( 'both' || 'dots' === $settings['exad_post_slider_nav'] ) :
            $this->add_render_attribute( 'exad_post_slider_controls', 'data-dots-type', esc_attr( $settings['exad_post_slider_dots_type'] ) );
        endif;

        // show only post has feature image
        if( 'yes' === $settings['exad_post_slider_show_only_post_has_image'] ) :
            $args['meta_query'][] = array( 'key' => '_thumbnail_id');
        endif;
        
        $wp_query = new \WP_Query( $args );

        if( 'yes' == $settings['exad_post_slider_show_read_more_btn_new_tab'] ){
            $target = "_blank";
        } else{
            $target = "_self";
        }

        if ( $wp_query->have_posts() ) : ?>
            <div <?php echo $this->get_render_attribute_string( 'exad_post_slider_controls' ); ?>>
                <?php
                while ( $wp_query->have_posts() ) : $wp_query->the_post();
                	$slider_featured_img  	= wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'full' );
                    ?>

           			<div class="exad-each-slider-item" data-image="<?php echo esc_url( $this->render_image( get_post_thumbnail_id( get_the_id() ), 'dot_image_size', $settings ) ); ?>">
           				<div class="exad-slider-progressbar-<?php echo esc_attr( $bar ); ?>"></div>
           				<?php if( 'yes' === $settings['exad_enable_slider_bg_overlay'] ) : ?>
	           				<div class="exad-slider-bg-overlay"></div>
                        <?php endif; ?>

				        <div class="exad-slide-bg" style="background-image:url(<?php echo esc_url( $this->render_image( get_post_thumbnail_id( get_the_id() ), 'image_size', $settings ) ); ?>)"></div>
				        <div class="exad-slide-inner">
				            <div class="exad-slide-content">
                            <?php
				            	if( 'yes' === $settings['exad_post_slider_show_title'] ) :
					            	$title_animation_in  = $settings['exad_post_slider_title_animation_in'];
							        $title_animation_out = $settings['exad_post_slider_title_animation_out'];
							        $title_delay_in      = $settings['exad_post_slider_title_animation_delay_in']['size'];
							        $title_duration_in   = $settings['exad_post_slider_title_animation_duration_in']['size'];
							        $title_duration_out  = $settings['exad_post_slider_title_animation_duration_out']['size']; 
                                    $title_delay_out     = $autoplaySpeedInSecond - ( $title_delay_in + $title_duration_in + $title_duration_out );
                                ?>    
					                <<?php echo Utils::validate_html_tag( $settings['exad_post_slider_title_tag'] ); ?> class="exad-post-slider-title" data-animation-in="<?php echo esc_attr( $title_animation_in ); ?>" data-delay-in="<?php echo esc_attr( $title_delay_in ); ?>" data-duration-in="<?php echo esc_attr( $title_duration_in ); ?>" data-animation-out="<?php echo esc_attr( $title_animation_out ); ?>" data-delay-out="<?php echo esc_attr( $title_delay_out ); ?>" data-duration-out="<?php echo esc_attr( $title_duration_out ); ?>">
                                        <?php echo wp_trim_words( get_the_title(), $settings['exad_post_slider_title_length'], '...' ); ?>
					                </<?php echo Utils::validate_html_tag( $settings['exad_post_slider_title_tag'] ); ?>>
                                <?php
					            endif;

				                if( 'yes' === $settings['exad_post_slider_show_excerpt'] ) :
					                $details_animation_in  = $settings['exad_post_slider_details_animation_in'];
							        $details_animation_out = $settings['exad_post_slider_details_animation_out'];
							        $details_delay_in      = $settings['exad_post_slider_details_animation_delay_in']['size'];
							        $details_duration_in   = $settings['exad_post_slider_details_animation_duration_in']['size'];
							        $details_duration_out  = $settings['exad_post_slider_details_animation_duration_out']['size'];
                                    $details_delay_out     = $autoplaySpeedInSecond - ( $details_delay_in + $details_duration_in + $details_duration_out );
                                ?>    
					                <div class="exad-slider-excerpt" data-animation-in="<?php echo esc_attr( $details_animation_in ); ?>" data-delay-in="<?php echo esc_attr( $details_delay_in ); ?>" data-duration-in="<?php echo esc_attr( $details_duration_in ); ?>" data-animation-out="<?php echo esc_attr( $details_animation_out ); ?>" data-delay-out="<?php echo esc_attr( $details_delay_out ); ?>" data-duration-out="<?php echo esc_attr( $details_duration_out ); ?>">
                                        <?php echo Helper::exad_get_post_excerpt( get_the_ID(), wp_kses_post( $settings['exad_post_slider_excerpt_length'] ) ); ?>
					                </div>
                                <?php    
					            endif;

					            if( 'yes' === $settings['exad_post_slider_show_read_more_btn'] ) :
					            	$button_animation_in  = $settings['exad_post_slider_button_animation_in'];
							        $button_animation_out = $settings['exad_post_slider_button_animation_out'];
							        $button_delay_in      = $settings['exad_post_slider_button_animation_delay_in']['size'];
							        $button_duration_in   = $settings['exad_post_slider_button_animation_duration_in']['size'];
							        $button_duration_out  = $settings['exad_post_slider_button_animation_duration_out']['size'];
                                    $button_delay_out     = $autoplaySpeedInSecond - ( $button_delay_in + $button_duration_in + $button_duration_out );
                                ?>    
					                <div class="exad-slider-btn" data-animation-in="<?php echo esc_attr( $button_animation_in ); ?>" data-delay-in="<?php echo esc_attr( $button_delay_in ); ?>" data-duration-in="<?php echo esc_attr( $button_duration_in ); ?>" data-animation-out="<?php echo esc_attr( $button_animation_out ); ?>" data-delay-out="<?php echo esc_attr( $button_delay_out ); ?>" data-duration-out="<?php echo esc_attr( $button_duration_out ); ?>">
                                        
								        <a href="<?php echo get_the_permalink(); ?>" target="<?php echo $target; ?>">
                                            <?php echo esc_html( $settings['exad_post_slider_read_more_btn_text'] ); ?>
								        </a>
							    	</div>
                                <?php endif; ?>
				            </div>
				        </div>
				    </div>
                <?php endwhile; ?>
            </div>
        <?php    
        else :
        	_e( 'No Post Items Found.', 'exclusive-addons-elementor-pro' );
        endif;
        wp_reset_postdata(); 
	}
}