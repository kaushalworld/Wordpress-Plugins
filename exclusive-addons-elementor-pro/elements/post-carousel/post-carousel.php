<?php
namespace ExclusiveAddons\Elements;

if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.

use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Border;
use \Elementor\Group_Control_Box_Shadow;
use \Elementor\Group_Control_Image_Size;
use \Elementor\Group_Control_Typography;
use \Elementor\Group_Control_Background;
use \Elementor\Widget_Base;
use \ExclusiveAddons\Elementor\Helper;
use \ExclusiveAddons\Pro\Elementor\ProHelper;


class Post_Carousel extends Widget_Base {

    public function get_name() {
        return 'exad-post-carousel';
    }

    public function get_title() {
        return esc_html__( 'Post Carousel', 'exclusive-addons-elementor-pro' );
    }

    public function get_icon() {
        return 'exad exad-logo exad-post-carousel';
    }

    public function get_categories() {
        return [ 'exclusive-addons-elementor' ];
    }

    public function get_script_depends() {
        return [ 'exad-slick' ];
    }

    protected function register_controls() {
        $exad_primary_color   = get_option( 'exad_primary_color_option', '#7a56ff' );

        // Get Available Taxonomies
		$post_taxonomies = Helper::exad_get_custom_types_of( 'tax', false );

        $post_types = Helper::exad_get_post_types();

        $this->start_controls_section(
            'exad_section_post_carousel_filters',
            [
                'label' => __( 'Settings', 'exclusive-addons-elementor-pro' )
            ]
        );
        
        $this->add_control(
            'exad_post_carousel_type',
            [
                'label'   => __( 'Post Type', 'exclusive-addons-elementor-pro' ),
                'type'    => Controls_Manager::SELECT,
                'options' => Helper::exad_get_post_types(),
                'default' => 'post'

            ]
        );

        $this->add_control(
            'exad_post_carousel_per_page',
            [
                'label'   => __( 'Posts Per Page', 'exclusive-addons-elementor-pro' ),
                'type'    => Controls_Manager::NUMBER,
                'default' => '6'
            ]
        );
        
        $this->add_control(
            'exad_post_carousel_offset',
            [
                'label'   => __( 'Offset', 'exclusive-addons-elementor-pro' ),
                'type'    => Controls_Manager::NUMBER,
                'default' => '0'
            ]
        );

        $this->add_control(
        	'exad_post_carousel_exclude_post',
        	[
				'label'       => __( 'Exclude Post', 'exclusive-addons-elementor-pro' ),
				'label_block' => true,
				'type'        => Controls_Manager::SELECT2,
				'multiple'    => true,
				'default'     => [],
				'options'     => Helper::exad_get_all_posts(),
				'condition'   => [
					'exad_post_carousel_type' => 'post'
				]
            ]
        );

        $this->add_control(
            'exad_post_carousel_authors',
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
            'exad_post_carousel_categories',
            [
                'label'       => __( 'Categories', 'exclusive-addons-elementor-pro' ),
                'label_block' => true,
                'type'        => Controls_Manager::SELECT2,
                'multiple'    => true,
                'default'     => [],
                'options'     => Helper::exad_get_all_categories(),
                'condition'   => [
                    'exad_post_carousel_type' => 'post'
                ]
            ]
        );

        // Taxonomies
		foreach ( $post_taxonomies as $slug => $title ) {
			global $wp_taxonomies;
			$post_type = '';

			if ( isset($wp_taxonomies[$slug]) && isset($wp_taxonomies[$slug]->object_type[0]) ) {
				$post_type = $wp_taxonomies[$slug]->object_type[0];
			}

			$this->add_control(
				'exad_query_taxonomy_'. $slug,
				[
					'label' => $title,
					'type' => Controls_Manager::SELECT2,
					'multiple' => true,
					'label_block' => true,
					'options' => Helper::exad_get_terms_by_taxonomy( $slug ),
					'condition' => [
                        'exad_post_carousel_type!' => 'post',
						'exad_post_carousel_type' => $post_type,
                        
					],
				]
			);
            
            $this->add_control(
				'exad_query_exclude_terms_'. $slug,
				[
					'label' => esc_html__( 'Exclude ', 'exclusive-addons-elementor-pro' ) . $title,
					'type' => Controls_Manager::SELECT2,
					'multiple' => true,
					'label_block' => true,
					'options' => Helper::exad_get_terms_by_taxonomy( $slug ),
					'condition' => [
                        'exad_post_carousel_type!' => ['post', 'product'],
						'exad_post_carousel_type' => $post_type,
                        
					],
				]
			);

		}

        $this->add_control(
            'exad_post_carousel_tags',
            [
                'label'       => __( 'Tags', 'exclusive-addons-elementor-pro' ),
                'label_block' => true,
                'type'        => Controls_Manager::SELECT2,
                'multiple'    => true,
                'default'     => [],
                'options'     => Helper::exad_get_all_tags(),
                'condition'   => [
                    'exad_post_carousel_type' => 'post'
                ]
            ]
        );

        // Exclude
		foreach ( $post_types as $slug => $title ) {

			$this->add_control(
				'exad_query_exclude_'. $slug,
				[
					'label' => esc_html__( 'Exclude ', 'exclusive-addons-elementor-pro' ) . $title,
					'type' => Controls_Manager::SELECT2,
					'multiple' => true,
					'label_block' => true,
					'options' => Helper::exad_get_posts_by_post_type( $slug ),
					'condition' => [
                        'exad_post_carousel_type!' => ['post', 'product'],
						'exad_post_carousel_type' => $slug,
					],
				]
			);

		}

        $this->add_control(
            'exad_post_carousel_order',
            [
                'label'    => __( 'Order', 'exclusive-addons-elementor-pro' ),
                'type'     => Controls_Manager::SELECT,
                'default'  => 'desc',
                'options'  => [
                    'asc'  => 'Ascending',
                    'desc' => 'Descending'
                ]

            ]
        );

        $this->add_control(
            'exad_post_carousel_order_by',
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
                    'rand' => __( 'Random', 'exclusive-addons-elementor-pro' ),
                ]
            ]
        );

        $this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name'      => 'post_carousel_image_size',
				'default'   => 'medium_large'
			]
		);

        $this->add_control(
            'exad_post_carousel_ignore_sticky',
            [
                'label'        => esc_html__( 'Ignore Sticky?', 'exclusive-addons-elementor-pro' ),
                'type'         => Controls_Manager::SWITCHER,
                'return_value' => 'yes',
                'default'      => 'yes'
            ]
        );

        $this->add_control(
            'exad_post_carousel_show_excerpt',
            [
                'label'        => esc_html__( 'Enable Excerpt.', 'exclusive-addons-elementor-pro' ),
                'type'         => Controls_Manager::SWITCHER,
                'default'      => 'yes',
                'return_value' => 'yes'
            ]
        );  

        $this->add_control(
            'exad_carousel_excerpt_length',
            [
                'label'     => __( 'Excerpt Words', 'exclusive-addons-elementor-pro' ),
                'type'      => Controls_Manager::NUMBER,
                'default'   => '25',
                'condition' => [
                    'exad_post_carousel_show_excerpt' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'exad_post_carousel_show_image',
            [
                'label'        => esc_html__( 'Enable Image', 'exclusive-addons-elementor-pro' ),
                'type'         => Controls_Manager::SWITCHER,
                'return_value' => 'yes',
                'default'      => 'yes'
            ]
        );


        $this->add_control(
            'exad_post_carousel_show_title',
            [
                'label'        => esc_html__( 'Enable Title', 'exclusive-addons-elementor-pro' ),
                'type'         => Controls_Manager::SWITCHER,
                'return_value' => 'yes',
                'default'      => 'yes'
            ]
        );

        $this->add_control(
            'exad_post_carousel_title_tag',
            [
                'label'   => __('Title HTML Tag', 'exclusive-addons-elementor'),
                'type'    => Controls_Manager::SELECT,
                'options' => Helper::exad_title_tags(),
                'default' => 'h3',
            ]
		);

        $this->add_control(
			'exad_post_carousel_title_full',
			[
				'label'        => esc_html__( 'Enable Title Length (Full or Short)', 'exclusive-addons-elementor-pro' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'	   => __( 'Full', 'exclusive-addons-elementor-pro' ),
				'label_off'    => __( 'Short', 'exclusive-addons-elementor-pro' ),
				'return_value' => 'yes',
				'default'      => 'yes'
			]
		);

		$this->add_control(
            'exad_post_carousel_title_length',
            [
				'label'     => __( 'Title Words Length', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => '10',
				'condition' => [
					'exad_post_carousel_title_full!' => 'yes'
				]
            ]
        );

        $this->add_control(
            'exad_post_carousel_show_read_more_btn',
            [
                'label'        => esc_html__( 'Enable Details Button', 'exclusive-addons-elementor-pro' ),
                'type'         => Controls_Manager::SWITCHER,
                'default'      => 'yes',
                'return_value' => 'yes'
            ]
        );  

        $this->add_control(
            'exad_post_carousel_read_more_btn_text',
            [   
                'label'       => esc_html__( 'Button Text', 'exclusive-addons-elementor-pro' ),
                'type'        => Controls_Manager::TEXT,
                'placeholder' => esc_html__('Read More', 'exclusive-addons-elementor-pro'),
                'default'     => esc_html__('Read More', 'exclusive-addons-elementor-pro' ),
                'condition'   => [
                    '.exad_post_carousel_show_read_more_btn' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'exad_post_carousel_show_read_more_btn_new_tab',
            [
                'label'        => esc_html__( 'Enable New Tab', 'exclusive-addons-elementor' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'	   => __( 'On', 'exclusive-addons-elementor' ),
				'label_off'    => __( 'Off', 'exclusive-addons-elementor' ),
                'default'      => 'yes',
                'return_value' => 'yes',
				'condition'     => [
                    'exad_post_carousel_show_read_more_btn' => 'yes'
				],
            ]
        );

        $this->end_controls_section();
        
        $this->start_controls_section(
            'exad_section_post_carousel_meta_options',
            [
                'label' => __( 'Post Meta', 'exclusive-addons-elementor-pro' )
            ]
        );

        $this->add_control(
            'exad_post_carousel_show_category',
            [
                'label'        => esc_html__( 'Enable Category', 'exclusive-addons-elementor-pro' ),
                'type'         => Controls_Manager::SWITCHER,
                'return_value' => 'yes',
                'default'      => 'yes'
            ]
        );

        $this->add_control(
            'exad_post_carousel_show_user_avatar',
            [
                'label'        => esc_html__( 'Enable Avatar', 'exclusive-addons-elementor-pro' ),
                'type'         => Controls_Manager::SWITCHER,
                'return_value' => 'yes',
                'default'      => 'no'
            ]
        );

        $this->add_control(
            'exad_post_carousel_show_user_name',
            [
                'label'        => esc_html__( 'Enable Author Name', 'exclusive-addons-elementor-pro' ),
                'type'         => Controls_Manager::SWITCHER,
                'return_value' => 'yes',
                'default'      => 'yes'
            ]
        );

        $this->add_control(
            'exad_post_carousel_show_user_name_tag',
            [
                'label'        => esc_html__( 'Enable Author Name Tag', 'exclusive-addons-elementor-pro' ),
                'type'         => Controls_Manager::SWITCHER,
                'return_value' => 'yes',
                'default'      => 'yes',
                'condition'    => [
                    '.exad_post_carousel_show_user_name' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'exad_post_carousel_user_name_tag',
            [   
                'label'         => esc_html__( 'Author Name Tag', 'exclusive-addons-elementor-pro' ),
                'type'          => Controls_Manager::TEXT,
                'default'       => esc_html__('By: ', 'exclusive-addons-elementor-pro' ),
                'condition'     => [
                    '.exad_post_carousel_show_user_name_tag' => 'yes',
                    '.exad_post_carousel_show_user_name'     => 'yes'
                ]
            ]
        );

        $this->add_control(
            'exad_post_carousel_show_date',
            [
                'label'        => esc_html__( 'Enable Date', 'exclusive-addons-elementor-pro' ),
                'type'         => Controls_Manager::SWITCHER,
                'return_value' => 'yes',
                'default'      => 'yes'
            ]
        );

        $this->add_control(
            'exad_post_carousel_show_date_tag',
            [
                'label'        => esc_html__( 'Enable Date Tag', 'exclusive-addons-elementor-pro' ),
                'type'         => Controls_Manager::SWITCHER,
                'return_value' => 'yes',
                'default'      => 'yes',
                'condition'    => [
                    '.exad_post_carousel_show_date' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'exad_post_carousel_date_tag',
            [   
                'label'         => esc_html__( 'Date Tag', 'exclusive-addons-elementor-pro' ),
                'type'          => Controls_Manager::TEXT,
                'default'       => esc_html__('Date: ', 'exclusive-addons-elementor-pro' ),
                'condition'     => [
                    '.exad_post_carousel_show_date_tag' => 'yes',
                    '.exad_post_carousel_show_date'     => 'yes'
                ]
            ]
        );

        $this->add_control(
            'exad_post_carousel_show_read_time',
            [
                'label'        => esc_html__( 'Enable Reading Time', 'exclusive-addons-elementor-pro' ),
                'type'         => Controls_Manager::SWITCHER,
                'return_value' => 'yes',
                'default'      => 'yes'
            ]
        );

        $this->add_control(
            'exad_post_carousel_show_comment',
            [
                'label'        => esc_html__( 'Enable Comment', 'exclusive-addons-elementor-pro' ),
                'type'         => Controls_Manager::SWITCHER,
                'return_value' => 'yes',
                'default'      => 'yes'
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_carousel_settings',
            [
                'label' => esc_html__( 'Carousel Settings', 'exclusive-addons-elementor-pro' )
            ]
        );

        $this->add_control(
            'exad_post_carousel_nav',
            [
                'label'   => esc_html__( 'Navigation Style', 'exclusive-addons-elementor-pro' ),
                'type'    => Controls_Manager::SELECT,
                'default' => 'arrows',
                'options' => [
                    'arrows' => esc_html__( 'Arrows', 'exclusive-addons-elementor-pro' ),
                    'dots'   => esc_html__( 'Dots', 'exclusive-addons-elementor-pro' ),
                    'both'   => esc_html__( 'Arrows and Dots', 'exclusive-addons-elementor-pro' ),
                    'none'   => esc_html__( 'None', 'exclusive-addons-elementor-pro' )
                ]
            ]
        );

        $slides_per_view = range( 1, 6 );
        $slides_per_view = array_combine( $slides_per_view, $slides_per_view );

        $this->add_responsive_control(
            'exad_post_carousel_per_view',
            [
                'label'   => __( 'Columns', 'exclusive-addons-elementor-pro' ),
                'type'    => Controls_Manager::SELECT,
                'default' => '3',
                'options' => $slides_per_view,
                'tablet_default' => '2',
				'mobile_default' => '1',
            ]
        );

        $this->add_control(
            'exad_post_carousel_slides_to_scroll',
            [
                'type'    => Controls_Manager::SELECT,
                'label'   => esc_html__( 'Items to Scroll', 'exclusive-addons-elementor-pro' ),
                'options' => $slides_per_view,
                'default' => '1'
            ]
        );

        $this->add_control(
            'exad_post_carousel_transition_duration',
            [
                'label'   => esc_html__( 'Transition Duration', 'exclusive-addons-elementor-pro' ),
                'type'    => Controls_Manager::NUMBER,
                'default' => 1000
            ]
        );

        $this->add_control(
            'exad_post_carousel_autoplay',
            [
                'label'     => esc_html__( 'Autoplay', 'exclusive-addons-elementor-pro' ),
                'type'      => Controls_Manager::SWITCHER,
                'default'   => 'no'
            ]
        );

        $this->add_control(
            'exad_post_carousel_autoplay_speed',
            [
                'label'     => esc_html__( 'Autoplay Speed', 'exclusive-addons-elementor-pro' ),
                'type'      => Controls_Manager::NUMBER,
                'default'   => 5000,
                'condition' => [
                    'exad_post_carousel_autoplay' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'exad_post_carousel_loop',
            [
                'label'   => esc_html__( 'Infinite Loop', 'exclusive-addons-elementor-pro' ),
                'type'    => Controls_Manager::SWITCHER,
                'default' => 'yes'
            ]
        );

        $this->add_control(
            'exad_post_carousel_pause',
            [
                'label'     => esc_html__( 'Pause on Hover', 'exclusive-addons-elementor-pro' ),
                'type'      => Controls_Manager::SWITCHER,
                'default'   => 'yes',
                'condition' => [
                    'exad_post_carousel_autoplay' => 'yes'
                ]
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'exad_section_post_carousel_container',
            [
                'label' => __( 'Container', 'exclusive-addons-elementor-pro' ),
                'tab'   => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_control(
			'exad_post_carousel_container_bg_color',
			[
				'label'     => __( 'Background Color', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .exad-row-wrapper .exad-post-grid-container' => 'background: {{VALUE}};'
				]

			]
		);

		$this->add_group_control(
        	Group_Control_Border::get_type(),
            [
                'name'      => 'exad_post_carousel_container_border',
                'selector'  => '{{WRAPPER}} .exad-row-wrapper .exad-post-grid-container'
            ]
        );

        $this->add_responsive_control(
            'exad_post_carousel_radius',
            [
                'label'      => esc_html__( 'Border Radius', 'exclusive-addons-elementor-pro' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px' ],
                'selectors'  => [
                    '{{WRAPPER}} .exad-row-wrapper .exad-post-grid-container'=> 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .exad-row-wrapper .exad-post-grid-container .exad-post-grid-thumbnail'=> 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} 0 0;'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'exad_post_carousel_box_shadow',
                'selector' => '{{WRAPPER}} .exad-row-wrapper .exad-post-grid-container'
            ]
        );

        $this->add_responsive_control(
            'exad_post_carousel_container_margin',
            [
                'label'        => esc_html__( 'Margin', 'exclusive-addons-elementor-pro' ),
                'type'         => Controls_Manager::DIMENSIONS,
                'default'      => [
                    'top'      => '0',
                    'right'    => '10',
                    'bottom'   => '20',
                    'left'     => '10',
                    'unit'     => 'px',
                    'isLinked' => false
                ],              
                'size_units'   => [ 'px', 'em', '%' ],
                'selectors'    => [
                    '{{WRAPPER}} .exad-post-grid-container' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->add_responsive_control(
            'exad_post_carousel_container_padding',
            [
                'label'        => esc_html__( 'Padding', 'exclusive-addons-elementor-pro' ),
                'type'         => Controls_Manager::DIMENSIONS,
                'default'      => [
                    'top'      => '0',
                    'right'    => '0',
                    'bottom'   => '0',
                    'left'     => '0',
                    'unit'     => 'px',
                    'isLinked' => false
                ],              
                'size_units'   => [ 'px', 'em', '%' ],
                'selectors'    => [
                    '{{WRAPPER}} .exad-post-grid-container' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->end_controls_section();

        // Image Styles
        $this->start_controls_section(
            'exad_section_post_carousel_image_style',
            [
                'label'     => __( 'Image', 'exclusive-addons-elementor-pro' ),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'exad_post_carousel_show_image' => 'yes'
                ]
            ]
        );

        $this->add_responsive_control(
            'exad_section_post_carousel_image_padding',
            [
                'label'      => esc_html__( 'Padding', 'exclusive-addons-elementor-pro' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .exad-row-wrapper .exad-post-grid-container .exad-post-grid-thumbnail'=> 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->add_responsive_control(
            'exad_section_post_carousel_image_radius',
            [
                'label'      => esc_html__( 'Border Radius', 'exclusive-addons-elementor-pro' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px'],
                'selectors'  => [
                    '{{WRAPPER}} .exad-post-grid-thumbnail img'=> 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .exad-row-wrapper .exad-post-grid-container .exad-post-grid-thumbnail::before'=> 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->add_control(
            'exad_post_carousel_image_align',
            [
                'label'         => esc_html__( 'Image Position', 'exclusive-addons-elementor-pro' ),
                'type'          => Controls_Manager::CHOOSE,
                'toggle'        => false,
                'default'       => 'top',
                'options'       => [
                    'left'      => [
                        'title' => esc_html__( 'Left', 'exclusive-addons-elementor-pro' ),
                        'icon'  => 'eicon-arrow-left'
                    ],
                    'top'       => [
                        'title' => esc_html__( 'Top', 'exclusive-addons-elementor-pro' ),
                        'icon'  => 'eicon-arrow-up'
                    ],
                    'right'     => [
                        'title' => esc_html__( 'Right', 'exclusive-addons-elementor-pro' ),
                        'icon'  => 'eicon-arrow-right'
                    ]
                ]
            ]
        );

        $this->add_responsive_control(
			'exad_post_carousel_image_height',
			[
				'label'       => __( 'Image Min Height', 'exclusive-addons-elementor-pro' ),
				'type'        => Controls_Manager::SLIDER,
				'size_units'  => [ 'px' ],
				'range'       => [
					'px'      => [
						'min' => 0,
						'max' => 700
					]
				],
				'selectors'   => [
					'{{WRAPPER}} .exad-post-grid-container.image-position-top .exad-post-grid-thumbnail > a' => 'min-height: {{SIZE}}{{UNIT}};'
				],
				'condition' => [
					'exad_post_carousel_image_align' => 'top'
				]
			]
        );
        
        $this->add_control(
			'exad_post_carousel_image_fixed_height',
			[
				'label'        => esc_html__( 'Fixed Height ?', 'exclusive-addons-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'	   => __( 'Yes', 'exclusive-addons-elementor' ),
				'label_off'    => __( 'No', 'exclusive-addons-elementor' ),
				'return_value' => 'yes',
				'default'      => 'no'
			]
		);

		$this->add_responsive_control(
			'eexad_post_carousel_image_height',
			[
				'label'       => __( 'Image Height', 'exclusive-addons-elementor' ),
				'type'        => Controls_Manager::SLIDER,
				'size_units'  => [ 'px' , '%'],
				'range'       => [
					'px'      => [
						'min' => 0,
						'max' => 500
					]
				],
				'selectors'   => [
					'{{WRAPPER}} .exad-post-grid-container.image-position-top .exad-post-grid-thumbnail > a' => 'height: {{SIZE}}{{UNIT}};'
				],
				'condition' => [
                    'exad_post_carousel_image_align' => 'top',
					'exad_post_carousel_image_fixed_height' => 'yes',
                   
				]
			]
		);

        $this->add_control(
			'exad_section_post_carousel_image_overlay_heading',
			[
				'label' => __( 'Image Overlay Background', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
        );
        
        $this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'exad_section_post_carousel_image_overlay',
				'label' => __( 'Image Overlay', 'exclusive-addons-elementor-pro' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .exad-row-wrapper .exad-post-grid-container .exad-post-grid-thumbnail:before',
			]
		);

        $this->end_controls_section();


        // Content Styles
        $this->start_controls_section(
            'exad_post_carousel_content_style',
            [
                'label' => __( 'Content', 'exclusive-addons-elementor-pro' ),
                'tab'   => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_control(
            'exad_post_carousel_content_bg_color',
            [
                'label'     => __( 'Background Color', 'exclusive-addons-elementor-pro' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#f5f7fa',
                'selectors' => [
                    '{{WRAPPER}} .exad-row-wrapper .exad-post-grid-three .exad-post-grid-body' => 'background-color: {{VALUE}};'
                ]

            ]
        );

        $this->add_responsive_control(
            'exad_post_carousel_content_margin',
            [
                'label'         => esc_html__( 'Margin', 'exclusive-addons-elementor-pro' ),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => [ 'px', 'em', '%' ],
                'selectors'     => [
                    '{{WRAPPER}} .exad-row-wrapper .exad-post-grid-three .exad-post-grid-body' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->add_responsive_control(
            'exad_post_carousel_content_padding',
            [
                'label'      => esc_html__( 'Padding', 'exclusive-addons-elementor-pro' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%'],
                'default'    => [
                    'top'    => '20',
                    'right'  => '20',
                    'bottom' => '20',
                    'left'   => '20'
                ],
                'selectors'  => [
                    '{{WRAPPER}} .exad-row-wrapper .exad-post-grid-three .exad-post-grid-body'=> 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'      => 'exad_post_carousel_content_border',
                'selector'  => '{{WRAPPER}} .exad-row-wrapper .exad-post-grid-three .exad-post-grid-body'
            ]
        );

        $this->add_responsive_control(
            'exad_post_carousel_content_box_border_radius',
            [
                'label'      => esc_html__( 'Border Radius', 'exclusive-addons-elementor-pro' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px'],
                'selectors'  => [
                    '{{WRAPPER}} .exad-row-wrapper .exad-post-grid-three .exad-post-grid-body'=> 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'exad_post_carousel_content_box_shadow',
                'selector' => '{{WRAPPER}} .exad-row-wrapper .exad-post-grid-three .exad-post-grid-body'
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'exad_post_carousel_title',
            [
                'label'     => __( 'Title', 'exclusive-addons-elementor-pro' ),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'exad_post_carousel_show_title' => 'yes'
                ]
            ]
        );

        $this->add_responsive_control(
            'exad_post_carousel_title_margin',
            [
                'label'      => esc_html__( 'Margin', 'exclusive-addons-elementor-pro' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],                 
                'selectors'  => [
                    '{{WRAPPER}} .exad-post-grid-container .exad-post-grid-body h3' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->add_responsive_control(
            'exad_post_carousel_title_alignment',
            [
                'label'         => __( 'Title Alignment', 'exclusive-addons-elementor-pro' ),
                'type'          => Controls_Manager::CHOOSE,
                'toggle'        => false,
                'options'       => [
                    'left'      => [
                        'title' => __( 'Left', 'exclusive-addons-elementor-pro' ),
                        'icon'  => 'eicon-text-align-left'
                    ],
                    'center'    => [
                        'title' => __( 'center', 'exclusive-addons-elementor-pro' ),
                        'icon'  => 'eicon-text-align-center'
                    ],
                    'right'     => [
                        'title' => __( 'Right', 'exclusive-addons-elementor-pro' ),
                        'icon'  => 'eicon-text-align-right'
                    ]
                ],
                'selectors'     => [
                    '{{WRAPPER}} .exad-post-grid-body .exad-post-grid-title' => 'text-align: {{VALUE}};'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'exad_post_carousel_title_typography',
                'selector' => '{{WRAPPER}} .exad-row-wrapper .exad-post-grid-body .exad-post-grid-title'
            ]
        );

        $this->start_controls_tabs( 'exad_post_carousel_title_tabs' );

            $this->start_controls_tab( 'normal', [ 'label' => esc_html__( 'Normal', 'exclusive-addons-elementor-pro' ) ] );

            $this->add_control(
                'exad_post_carousel_title_color',
                [
                    'label'     => __( 'Color', 'exclusive-addons-elementor-pro' ),
                    'type'      => Controls_Manager::COLOR,
                    'default'   => '#1B1D26',
                    'selectors' => [
                        '{{WRAPPER}} .exad-row-wrapper .exad-post-grid-body .exad-post-grid-title' => 'color: {{VALUE}};'
                    ]
    
                ]
            );

            $this->end_controls_tab();
            
            $this->start_controls_tab( 'hover', [ 'label' => esc_html__( 'Hover', 'exclusive-addons-elementor-pro' ) ] );

            $this->add_control(
                'exad_post_carousel_title_hover_color',
                [
                    'label'     => __( 'Color', 'exclusive-addons-elementor-pro' ),
                    'type'      => Controls_Manager::COLOR,
                    'default'   => '#0A1724',
                    'selectors' => [
                        '{{WRAPPER}} .exad-row-wrapper .exad-post-grid-body .exad-post-grid-title:hover' => 'color: {{VALUE}};'
                    ]
    
                ]
            );

            $this->end_controls_tab();
        
        $this->end_controls_tabs();

        $this->end_controls_section();

        $this->start_controls_section(
            'exad_post_carousel_excerpt_style',
            [
                'label'     => __( 'Excerpt', 'exclusive-addons-elementor-pro' ),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'exad_post_carousel_show_excerpt' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'exad_post_carousel_excerpt_color',
            [
                'label'     => __( 'Text Color', 'exclusive-addons-elementor-pro' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#848484',
                'selectors' => [
                    '{{WRAPPER}} .exad-post-grid-body .exad-post-grid-description' => 'color: {{VALUE}};'
                ]
            ]
        );

        $this->add_responsive_control(
            'exad_post_carousel_excerpt_alignment',
            [
                'label'         => __( 'Alignment', 'exclusive-addons-elementor-pro' ),
                'type'          => Controls_Manager::CHOOSE,
                'toggle'        => false,
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
                    ],
                    'justify'   => [
                        'title' => __( 'Justified', 'exclusive-addons-elementor-pro' ),
                        'icon'  => 'eicon-text-align-justify'
                    ]
                ],
                'selectors'     => [
                    '{{WRAPPER}} .exad-post-grid-body .exad-post-grid-description' => 'text-align: {{VALUE}};'
                ]
            ]
        );

        $this->add_responsive_control(
            'exad_post_carousel_excerpt_margin',
            [
                'label'         => esc_html__( 'Margin', 'exclusive-addons-elementor-pro' ),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => [ 'px', 'em', '%' ],                 
                'selectors'     => [
                    '{{WRAPPER}} .exad-row-wrapper .exad-post-grid-body .exad-post-grid-description' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'exad_post_carousel_category_style',
            [
                'label'     => __( 'Category', 'exclusive-addons-elementor-pro' ),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'exad_post_carousel_show_category' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'exad_post_carousel_category_default_position',
            [
                'label'        => esc_html__( 'Category Position Default?', 'exclusive-addons-elementor-pro' ),
                'type'         => Controls_Manager::SWITCHER,
                'return_value' => 'yes',
                'default'      => 'yes'
            ]
        );

        $this->add_control(
            'exad_post_carousel_category_position_over_image',
            [
                'label'     => esc_html__( 'Category Position Over Image', 'exclusive-addons-elementor-pro' ),
                'type'      => Controls_Manager::SELECT,
                'default'   => '-bottom-left',
                'options'   => [
                    '-bottom-left'  => esc_html__( 'Bottom Left Corner', 'exclusive-addons-elementor-pro' ),
                    '-top-right'    => esc_html__( 'Top Right Corner', 'exclusive-addons-elementor-pro' )
                ],
                'condition' => [
                    '.exad_post_carousel_category_default_position!' => 'yes'
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'          => 'exad_post_carousel_category_typography',
                'selector'      => '{{WRAPPER}} .exad-post-grid-container ul.exad-post-grid-category li a'
            ]
        );

        $this->add_control(
            'exad_post_carousel_category_color',
            [
                'label'     => __( 'Color', 'exclusive-addons-elementor-pro' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .exad-post-grid-container ul.exad-post-grid-category li a' => 'color: {{VALUE}};'
                ]
            ]
        );

        $this->add_control(
            'exad_post_carousel_category_bg_odd_color',
            [
                'label'     => __( 'Background Color (Odd)', 'exclusive-addons-elementor-pro' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#28CAD1',
                'selectors' => [
                    '{{WRAPPER}} .exad-row-wrapper .exad-post-grid-category li:nth-child(2n-1)' => 'background: {{VALUE}};'
                ]
            ]
        );

        $this->add_control(
            'exad_post_carousel_category_bg_even_color',
            [
                'label'     => __( 'Background Color (Even)', 'exclusive-addons-elementor-pro' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#7a56ff',
                'selectors' => [
                    '{{WRAPPER}} .exad-row-wrapper .exad-post-grid-category li:nth-child(2n)' => 'background: {{VALUE}};'
                ]
            ]
        );

        $this->add_responsive_control(
            'exad_post_carousel_category_padding',
            [
                'label'        => esc_html__( 'Padding', 'exclusive-addons-elementor-pro' ),
                'type'         => Controls_Manager::DIMENSIONS,
                'size_units'   => [ 'px', '%'],
                'default'      => [
                    'top'      => '1',
                    'right'    => '10',
                    'bottom'   => '1',
                    'left'     => '10',
                    'isLinked' => false
                ],
                'selectors'    => [
                    '{{WRAPPER}} .exad-post-grid-container ul.exad-post-grid-category li a'=> 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->add_responsive_control(
            'exad_post_carousel_category_all_item_margin',
            [
                'label'      => esc_html__( 'Margin(Each Item)', 'exclusive-addons-elementor-pro' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],                 
                'selectors'  => [
                    '{{WRAPPER}} .exad-post-grid-container ul.exad-post-grid-category li:not(:last-child)' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->add_responsive_control(
            'exad_post_carousel_category_each_item_margin',
            [
                'label'      => esc_html__( 'Margin(All Items)', 'exclusive-addons-elementor-pro' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],                 
                'selectors'  => [
                    '{{WRAPPER}} .exad-post-grid-container ul.exad-post-grid-category' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'      => 'exad_post_carousel_category_border',
                'selector'  => '{{WRAPPER}} .exad-post-grid-container ul.exad-post-grid-category li'
            ]
        );

        $this->add_responsive_control(
            'exad_post_carousel_category_border_radius',
            [
                'label'      => esc_html__( 'Border Radius', 'exclusive-addons-elementor-pro' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px'],
                'selectors'  => [
                    '{{WRAPPER}} .exad-post-grid-container ul.exad-post-grid-category li'=> 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'exad_post_carousel_author_date_style',
            [
                'label' => __( 'Author & Date', 'exclusive-addons-elementor-pro' ),
                'tab'   => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_responsive_control(
			'exad_post_carousel_author_image_size',
			[
				'label'       => __( 'Author Image Size', 'exclusive-addons-elementor-pro' ),
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
					'size'    => 40
				],
				'selectors'   => [
					'{{WRAPPER}} .exad-author-avatar img' => 'height: {{SIZE}}{{UNIT}}; width: {{SIZE}}{{UNIT}};'
				]
			]
		);

        $this->add_responsive_control(
            'exad_post_carousel_author_date_margin',
            [
                'label'        => esc_html__( 'Margin', 'exclusive-addons-elementor-pro' ),
                'type'         => Controls_Manager::DIMENSIONS,
                'size_units'   => [ 'px', 'em', '%' ],
                'default'      => [
                    'top'      => '10',
                    'right'    => '0',
                    'bottom'   => '10',
                    'left'     => '0',
                    'isLinked' => false
                ],                 
                'selectors'    => [
                    '{{WRAPPER}} .exad-row-wrapper .exad-post-grid-body ul.show-avatar-no' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->add_control(
            'exad_post_carousel_meta_style',
            [
                'label'     => __( 'Meta', 'exclusive-addons-elementor-pro' ),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before'
            ]
        );

        $this->add_responsive_control(
			'exad_post_carousel_meta_spacing',
			[
				'label'       => __( 'Spacing Between Author & Date', 'exclusive-addons-elementor-pro' ),
				'type'        => Controls_Manager::SLIDER,
				'size_units'  => [ 'px' ],
				'range'       => [
					'px'      => [
						'min' => 0,
						'max' => 150
					]
				],
				'default'     => [
					'unit'    => 'px',
					'size'    => 15
				],
				'selectors'   => [
					'{{WRAPPER}} .exad-post-grid-body .exad-post-data li:not(:last-child)' => 'margin-right: {{SIZE}}{{UNIT}};'
				]
			]
		);

        $this->add_control(
            'exad_post_carousel_author_date_color',
            [
                'label'     => __( 'Color', 'exclusive-addons-elementor-pro' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#848484',
                'selectors' => [
                    '{{WRAPPER}} .exad-row-wrapper .exad-post-grid-body .exad-post-data li span' => 'color: {{VALUE}};'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'exad_post_carousel_author_date_typography',
                'selector' => '{{WRAPPER}} .exad-row-wrapper .exad-post-grid-body .exad-post-data li span'
            ]
        );

        $this->add_control(
            'exad_post_carousel_date_style',
            [
                'label'     => __( 'Meta Link', 'exclusive-addons-elementor-pro' ),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before'
            ]
        );

        $this->add_control(
            'exad_post_carousel_author_date_link_color',
            [
                'label'     => __( 'Color', 'exclusive-addons-elementor-pro' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#848484',
                'selectors' => [
                    '{{WRAPPER}} .exad-row-wrapper .exad-post-grid-body .exad-post-data li span a' => 'color: {{VALUE}};'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'exad_post_carousel_author_date_link_typography',
                'selector' => '{{WRAPPER}} .exad-row-wrapper .exad-post-grid-body .exad-post-data li span a'
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'exad_post_carousel_reading_time_comment_style',
            [
                'label' => __( 'Reading Time & Comment', 'exclusive-addons-elementor-pro' ),
                'tab'   => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_responsive_control(
            'exad_post_carousel_reading_time_comment_margin',
            [
                'label'        => esc_html__( 'Margin', 'exclusive-addons-elementor-pro' ),
                'type'         => Controls_Manager::DIMENSIONS,
                'size_units'   => [ 'px', 'em', '%' ],
                'default'      => [
                    'top'      => '10',
                    'right'    => '0',
                    'bottom'   => '10',
                    'left'     => '0',
                    'isLinked' => false
                ],               
                'selectors'    => [
                    '{{WRAPPER}} .exad-row-wrapper .exad-post-grid-body ul.exad-post-grid-time-comment' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->add_control(
            'exad_post_carousel_reading_time_style',
            [
                'label'     => __( 'Reading Time', 'exclusive-addons-elementor-pro' ),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
                'condition' => [
                    'exad_post_carousel_show_read_time' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'exad_post_carousel_reading_time_color',
            [
                'label'     => __( 'Color', 'exclusive-addons-elementor-pro' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#90929C',
                'selectors' => [
                    '{{WRAPPER}} .exad-post-grid-container .exad-post-grid-body ul.exad-post-grid-time-comment li.exad-post-grid-read-time' => 'color: {{VALUE}};'
                ],
                'condition' => [
                    'exad_post_carousel_show_read_time' => 'yes'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'exad_post_carousel_reading_time_typography',
                'selector'  => '{{WRAPPER}} .exad-post-grid-container .exad-post-grid-body ul.exad-post-grid-time-comment li.exad-post-grid-read-time',
                'condition' => [
                    'exad_post_carousel_show_read_time' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'exad_post_carousel_comment_style',
            [
                'label'     => __( 'Comment', 'exclusive-addons-elementor-pro' ),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
                'condition' => [
                    'exad_post_carousel_show_comment' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'exad_post_carousel_comment_color',
            [
                'label'     => __( 'Color', 'exclusive-addons-elementor-pro' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#90929C',
                'selectors' => [
                    '{{WRAPPER}} .exad-post-grid-container .exad-post-grid-body ul.exad-post-grid-time-comment li a.exad-post-grid-comment' => 'color: {{VALUE}};'
                ],
                'condition' => [
                    'exad_post_carousel_show_comment' => 'yes'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'exad_post_carousel_comment_typography',
                'selector'  => '{{WRAPPER}} .exad-post-grid-container .exad-post-grid-body ul.exad-post-grid-time-comment li a.exad-post-grid-comment',
                'condition' => [
                    'exad_post_carousel_show_comment' => 'yes'
                ]
            ]
        );
        
        $this->end_controls_section();
        
        /**
         * -------------------------------------------
         * button style
         * -------------------------------------------
         */
        $this->start_controls_section(
            'exad_post_carousel_details_btn_style_section',
            [
                'label'         => esc_html__( 'Button Style', 'exclusive-addons-elementor-pro' ),
                'tab'           => Controls_Manager::TAB_STYLE,
                'condition'     => [
                    '.exad_post_carousel_show_read_more_btn' => 'yes'
                ]
            ]
        );

        $this->add_responsive_control(
            'exad_post_carousel_details_btn_padding',
            [
                'label'         => esc_html__( 'Padding', 'exclusive-addons-elementor-pro' ),
                'type'          => Controls_Manager::DIMENSIONS,           
                'size_units'    => [ 'px', 'em', '%' ],
                'selectors'     => [
                    '{{WRAPPER}} .exad-post-grid-container .exad-post-grid-body .exad-post-footer a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->add_responsive_control(
            'exad_post_carousel_details_btn_margin',
            [
                'label'         => esc_html__( 'Margin', 'exclusive-addons-elementor-pro' ),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => [ 'px', 'em', '%' ],                 
                'selectors'     => [
                    '{{WRAPPER}} .exad-post-grid-container .exad-post-grid-body .exad-post-footer a' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'exad_post_carousel_details_btn_typography',
                'selector' => '{{WRAPPER}} .exad-post-grid-container .exad-post-grid-body .exad-post-footer a'
            ]
        );

        $this->start_controls_tabs( 'exad_post_carousel_details_button_style_tabs' );

            // normal state tab
            $this->start_controls_tab( 'exad_post_carousel_details_btn_normal', [ 'label' => esc_html__( 'Normal', 'exclusive-addons-elementor-pro' ) ] );

            $this->add_control(
                'exad_post_carousel_details_btn_normal_text_color',
                [
                    'label'     => esc_html__( 'Text Color', 'exclusive-addons-elementor-pro' ),
                    'type'      => Controls_Manager::COLOR,
                    'default'   => '#7a56ff',
                    'selectors' => [
                        '{{WRAPPER}} .exad-post-grid-container .exad-post-grid-body .exad-post-footer a' => 'color: {{VALUE}};'
                    ]
                ]
            );

            $this->add_control(
                'exad_post_carousel_details_btn_normal_bg_color',
                [
                    'label'     => esc_html__( 'Background Color', 'exclusive-addons-elementor-pro' ),
                    'type'      => Controls_Manager::COLOR,
                    'default'   => 'rgba(0,0,0,0)',
                    'selectors' => [
                        '{{WRAPPER}} .exad-post-grid-container .exad-post-grid-body .exad-post-footer a' => 'background: {{VALUE}};'
                    ]
                ]
            );

            $this->add_group_control(
            Group_Control_Border::get_type(),
                [
                    'name'      => 'exad_post_carousel_details_btn_border',
                    'selector'  => '{{WRAPPER}} .exad-post-grid-container .exad-post-grid-body .exad-post-footer a'
                ]
            );

            $this->add_responsive_control(
                'exad_post_carousel_details_button_border_radius',
                [
                    'label'      => esc_html__( 'Border Radius', 'exclusive-addons-elementor-pro' ),
                    'type'       => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px'],
                    'selectors'  => [
                        '{{WRAPPER}} .exad-post-grid-container .exad-post-grid-body .exad-post-footer a'=> 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                    ]
                ]
            );

            $this->add_group_control(
                Group_Control_Box_Shadow::get_type(),
                [
                    'name'      => 'exad_post_carousel_details_button_shadow',
                    'selector'  => '{{WRAPPER}} .exad-post-grid-container .exad-post-grid-body .exad-post-footer a',
                    'separator' => 'before'
                ]
            );

            $this->end_controls_tab();

            // hover state tab
            $this->start_controls_tab( 'exad_post_carousel_details_btn_hover', [ 'label' => esc_html__( 'Hover', 'exclusive-addons-elementor-pro' ) ] );

            $this->add_control(
                'exad_post_carousel_details_btn_hover_text_color',
                [
                    'label'     => esc_html__( 'Text Color', 'exclusive-addons-elementor-pro' ),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .exad-post-grid-container .exad-post-grid-body .exad-post-footer a:hover' => 'color: {{VALUE}};'
                    ]
                ]
            );

            $this->add_control(
                'exad_post_carousel_details_btn_hover_bg_color',
                [
                    'label'     => esc_html__( 'Background Color', 'exclusive-addons-elementor-pro' ),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .exad-post-grid-container .exad-post-grid-body .exad-post-footer a:hover' => 'background: {{VALUE}};'
                    ]
                ]
            );

            $this->add_responsive_control(
                'exad_post_carousel_details_button_border_radius_hover',
                [
                    'label'      => esc_html__( 'Border Radius', 'exclusive-addons-elementor-pro' ),
                    'type'       => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px'],
                    'selectors'  => [
                        '{{WRAPPER}} .exad-post-grid-container .exad-post-grid-body .exad-post-footer a:hover'=> 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                    ]
                ]
            );

            $this->add_group_control(
                Group_Control_Box_Shadow::get_type(),
                [
                    'name'      => 'exad_post_carousel_details_button_hover_shadow',
                    'selector'  => '{{WRAPPER}} .exad-post-grid-container .exad-post-grid-body .exad-post-footer a:hover',
                    'separator' => 'before'
                ]
            );

            $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();

        $this->start_controls_section(
            'exad_post_carousel_nav_arrow',
            [
                'label'     => esc_html__( 'Arrows', 'exclusive-addons-elementor-pro' ),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'exad_post_carousel_nav' => ['arrows', 'both'],
                ],
            ]
        );

        $this->add_responsive_control(
            'exad_post_carousel_nav_arrow_box_width',
            [
                'label'      => __( 'Box Width', 'exclusive-addons-elementor-pro' ),
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
                    '{{WRAPPER}} .exad-post-carousel .exad-carousel-nav-prev' => 'width: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .exad-post-carousel .exad-carousel-nav-next' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'exad_post_carousel_nav_arrow_box_height',
            [
                'label'      => __( 'Box Height', 'exclusive-addons-elementor-pro' ),
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
                    '{{WRAPPER}} .exad-post-carousel .exad-carousel-nav-prev' => 'height: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .exad-post-carousel .exad-carousel-nav-next' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'exad_post_carousel_nav_arrow_icon_size',
            [
                'label'      => __( 'Icon Size', 'exclusive-addons-elementor-pro' ),
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
                    'size' => 16,
                ],
                'selectors'  => [
                    '{{WRAPPER}} .exad-post-carousel .exad-carousel-nav-prev i' => 'font-size: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .exad-post-carousel .exad-carousel-nav-next i' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        
        $this->add_control(
            'exad_post_carousel_prev_arrow_position',
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
                'exad_post_carousel_prev_arrow_position_x_offset',
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
                        '{{WRAPPER}} .exad-post-carousel .exad-carousel-nav-prev' => 'left: {{SIZE}}{{UNIT}};',
                    ],
                ]
            );

            $this->add_responsive_control(
                'exad_post_carousel_prev_arrow_position_y_offset',
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
                        '{{WRAPPER}} .exad-post-carousel .exad-carousel-nav-prev' => 'top: {{SIZE}}{{UNIT}};',
                    ],
                ]
            );

        $this->end_popover();

        $this->add_control(
            'exad_post_carousel_next_arrow_position',
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
                'exad_post_carousel_next_arrow_position_x_offset',
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
                        '{{WRAPPER}} .exad-post-carousel .exad-carousel-nav-next' => 'right: {{SIZE}}{{UNIT}};',
                    ],
                ]
            );

            $this->add_responsive_control(
                'exad_post_carousel_next_arrow_position_y_offset',
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
                        '{{WRAPPER}} .exad-post-carousel .exad-carousel-nav-next' => 'top: {{SIZE}}{{UNIT}};',
                    ],
                ]
            );

        $this->end_popover();

        $this->add_responsive_control(
            'exad_post_carousel_nav_arrow_radius',
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
                    '{{WRAPPER}} .exad-post-carousel .exad-carousel-nav-prev' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .exad-post-carousel .exad-carousel-nav-next' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs( 'exad_post_carousel_nav_arrow_tabs' );

			// normal state rating
			$this->start_controls_tab( 'exad_post_carousel_nav_arrow_normal', [ 'label' => esc_html__( 'Normal', 'exclusive-addons-elementor-pro' ) ] );

                $this->add_control(
                    'exad_post_carousel_arrow_normal_background',
                    [
                        'label'     => __( 'Background Color', 'exclusive-addons-elementor-pro' ),
                        'type'      => Controls_Manager::COLOR,
                        'default'   => '#ffffff',
                        'selectors' => [
                            '{{WRAPPER}} .exad-post-carousel .exad-carousel-nav-prev' => 'background: {{VALUE}}',
                            '{{WRAPPER}} .exad-post-carousel .exad-carousel-nav-next' => 'background: {{VALUE}}',
                        ],
                    ]
                );

                $this->add_control(
                    'exad_post_carousel_arrow_normal_color',
                    [
                        'label'     => __( 'Icon Color', 'exclusive-addons-elementor-pro' ),
                        'type'      => Controls_Manager::COLOR,
                        'default'   => $exad_primary_color,
                        'selectors' => [
                            '{{WRAPPER}} .exad-post-carousel .exad-carousel-nav-prev i' => 'color: {{VALUE}};',
                            '{{WRAPPER}} .exad-post-carousel .exad-carousel-nav-next i' => 'color: {{VALUE}};',
                        ],
                    ]
                );

                $this->add_group_control(
                    Group_Control_Border::get_type(),
                    [
                        'name'     => 'exad_post_carousel_arrow_normal_border',
                        'label'    => __( 'Border', 'exclusive-addons-elementor-pro' ),
                        'selector' => '{{WRAPPER}} .exad-post-carousel .exad-carousel-nav-prev, {{WRAPPER}} .exad-post-carousel .exad-carousel-nav-next',
                    ]
                );

                $this->add_group_control(
                    Group_Control_Box_Shadow::get_type(),
                    [
                        'name'     => 'exad_post_carousel_arrow_normal_shadow',
                        'label'    => __( 'Box Shadow', 'exclusive-addons-elementor-pro' ),
                        'selector' => '{{WRAPPER}} .exad-post-carousel .exad-carousel-nav-prev, {{WRAPPER}} .exad-post-carousel .exad-carousel-nav-next',
                    ]
                );

			$this->end_controls_tab();

			// hover state rating
			$this->start_controls_tab( 'exad_post_carousel_nav_arrow_hover', [ 'label' => esc_html__( 'Hover', 'exclusive-addons-elementor-pro' ) ] );

                $this->add_control(
                    'exad_post_carousel_arrow_hover_background',
                    [
                        'label'     => __( 'Background Color', 'exclusive-addons-elementor-pro' ),
                        'type'      => Controls_Manager::COLOR,
                        'default'   => $exad_primary_color,
                        'selectors' => [
                            '{{WRAPPER}} .exad-post-carousel .exad-carousel-nav-prev:hover' => 'background: {{VALUE}}',
                            '{{WRAPPER}} .exad-post-carousel .exad-carousel-nav-next:hover' => 'background: {{VALUE}}',
                        ],
                    ]
                );

                $this->add_control(
                    'exad_post_carousel_arrow_hover_color',
                    [
                        'label'     => __( 'Icon Color', 'exclusive-addons-elementor-pro' ),
                        'type'      => Controls_Manager::COLOR,
                        'default'   => '#ffffff',
                        'selectors' => [
                            '{{WRAPPER}} .exad-post-carousel .exad-carousel-nav-prev:hover i' => 'color: {{VALUE}}',
                            '{{WRAPPER}} .exad-post-carousel .exad-carousel-nav-next:hover i' => 'color: {{VALUE}}',
                        ],
                    ]
                );

                $this->add_group_control(
                    Group_Control_Border::get_type(),
                    [
                        'name'     => 'exad_post_carousel_arrow_hover_border',
                        'label'    => __( 'Border', 'exclusive-addons-elementor-pro' ),
                        'selector' => '{{WRAPPER}} .exad-post-carousel .exad-carousel-nav-prev:hover, {{WRAPPER}} .exad-post-carousel .exad-carousel-nav-next:hover',
                    ]
                );

                $this->add_group_control(
                    Group_Control_Box_Shadow::get_type(),
                    [
                        'name'     => 'exad_post_carousel_arrow_hover_shadow',
                        'label'    => __( 'Box Shadow', 'exclusive-addons-elementor-pro' ),
                        'selector' => '{{WRAPPER}} .exad-post-carousel .exad-carousel-nav-prev:hover, {{WRAPPER}} .exad-post-carousel .exad-carousel-nav-next:hover',
                    ]
                );

			$this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();

        $this->start_controls_section(
            'exad_post_carousel_nav_dot',
            [
                'label'     => esc_html__( 'Dots', 'exclusive-addons-elementor-pro' ),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'exad_post_carousel_nav' => ['dots', 'both'],
                ],
            ]
        );

        $this->add_responsive_control(
            'exad_post_carousel_dots_item_spacing',
            [
                'label'      => __( 'Each Item Spacing', 'exclusive-addons-elementor-pro' ),
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
                    '{{WRAPPER}} .exad-post-carousel .slick-dots li:not(:last-child)' => 'margin-right: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'exad_post_carousel_nav_dot_radius',
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
                    '{{WRAPPER}} .exad-post-carousel .slick-dots li button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'exad_post_carousel_dots_position',
            [
                'label'        => __( 'Dots Position', 'exclusive-addons-elementor-pro' ),
                'type'         => Controls_Manager::POPOVER_TOGGLE,
                'label_off'    => __( 'Default', 'exclusive-addons-elementor-pro' ),
                'label_on'     => __( 'Custom', 'exclusive-addons-elementor-pro' ),
                'return_value' => 'yes',
                'default'      => 'yes',
            ]
        );
        
        $this->start_popover();

            $this->add_responsive_control(
                'exad_post_carousel_dots_position_x_offset',
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
                        'unit' => '%',
                        'size' => 50,
                    ],
                    'selectors'  => [
                        '{{WRAPPER}} .exad-post-carousel.exad-carousel-item .slick-dots' => 'left: {{SIZE}}{{UNIT}};',
                    ],
                ]
            );

            $this->add_responsive_control(
                'exad_post_carousel_dots_position_y_offset',
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
                        'unit' => 'px',
                        'size' => -30,
                    ],
                    'selectors'  => [
                        '{{WRAPPER}} .exad-post-carousel.exad-carousel-item .slick-dots' => 'bottom: {{SIZE}}{{UNIT}};',
                    ],
                ]
            );

        $this->end_popover();

        $this->start_controls_tabs( 'exad_post_carousel_nav_dots_tabs' );

			// normal state rating
            $this->start_controls_tab( 'exad_post_carousel_nav_dots_normal', [ 'label' => esc_html__( 'Normal', 'exclusive-addons-elementor-pro' ) ] );
            
                $this->add_responsive_control(
                    'exad_post_carousel_dots_normal_width',
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
                            '{{WRAPPER}} .exad-post-carousel .slick-dots li button' => 'width: {{SIZE}}{{UNIT}};',
                        ],
                    ]
                );

                $this->add_responsive_control(
                    'exad_post_carousel_dots_normal_height',
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
                            '{{WRAPPER}} .exad-post-carousel .slick-dots li button' => 'height: {{SIZE}}{{UNIT}};',
                        ],
                    ]
                );

                $this->add_control(
                    'exad_post_carousel_dots_normal_background',
                    [
                        'label'     => __( 'Background Color', 'exclusive-addons-elementor-pro' ),
                        'type'      => Controls_Manager::COLOR,
                        'default'   => '#e5e5e5',
                        'selectors' => [
                            '{{WRAPPER}} .exad-post-carousel .slick-dots li button' => 'background: {{VALUE}};',
                        ],
                    ]
                );

                $this->add_group_control(
                    Group_Control_Border::get_type(),
                    [
                        'name'     => 'exad_post_carousel_dots_normal_border',
                        'label'    => __( 'Border', 'exclusive-addons-elementor-pro' ),
                        'selector' => '{{WRAPPER}} .exad-post-carousel .slick-dots li button',
                    ]
                );

			$this->end_controls_tab();

			// hover state rating
            $this->start_controls_tab( 'exad_post_carousel_nav_dots_hover', [ 'label' => esc_html__( 'Hover/active', 'exclusive-addons-elementor-pro' ) ] );
            
                $this->add_responsive_control(
                    'exad_post_carousel_dots_active_width',
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
                            '{{WRAPPER}} .exad-post-carousel .slick-dots li.slick-active button' => 'width: {{SIZE}}{{UNIT}};',
                        ],
                    ]
                );

                $this->add_responsive_control(
                    'exad_post_carousel_dots_active_height',
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
                            '{{WRAPPER}} .exad-post-carousel .slick-dots li.slick-active button' => 'height: {{SIZE}}{{UNIT}};',
                        ],
                    ]
                );

                $this->add_control(
                    'exad_post_carousel_dots_active_background',
                    [
                        'label'     => __( 'Background Color', 'exclusive-addons-elementor-pro' ),
                        'type'      => Controls_Manager::COLOR,
                        'default'   => $exad_primary_color,
                        'selectors' => [
                            '{{WRAPPER}} .exad-post-carousel .slick-dots li.slick-active button' => 'background: {{VALUE}};',
                            '{{WRAPPER}} .exad-post-carousel .slick-dots li button:hover'        => 'background: {{VALUE}};',
                        ],
                    ]
                );

                $this->add_group_control(
                    Group_Control_Border::get_type(),
                    [
                        'name'     => 'exad_post_carousel_dots_active_border',
                        'label'    => __( 'Border', 'exclusive-addons-elementor-pro' ),
                        'selector' => '{{WRAPPER}} .exad-post-carousel .slick-dots li.slick-active button, {{WRAPPER}} .exad-post-carousel .slick-dots li button:hover',
                    ]
                );

			$this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();
    }

    protected function render() {
        $settings                  = $this->get_settings_for_display();     
        $settings['template_type'] = $this->get_name();
        $settings['post_args']     = Helper::exad_get_post_carousel_arguments( $settings, 'exad_post_carousel' );
        $direction                 = is_rtl() ? 'true' : 'false';
        
        $this->add_render_attribute(
            'exad_post_carousel_wrapper',
            [
                'class'                         => [ 'exad-row-wrapper exad-post-carousel exad-carousel-item' ],
                'data-carousel-nav'             => esc_attr( $settings['exad_post_carousel_nav'] ),
                'data-carousel-column'          => intval( esc_attr( $settings['exad_post_carousel_per_view'] ) ),
                'data-carousel-column-tablet'   => intval( esc_attr( isset( $settings['exad_post_carousel_per_view_tablet'] ) ) ? (int)$settings['exad_post_carousel_per_view_tablet'] : 2 ),
                'data-carousel-column-mobile'   => intval( esc_attr( isset( $settings['exad_post_carousel_per_view_mobile'] ) ) ? (int)$settings['exad_post_carousel_per_view_mobile'] : 1 ),
                'data-slidestoscroll'           => intval( esc_attr( $settings['exad_post_carousel_slides_to_scroll'] ) ),
                'data-carousel-speed'           => esc_attr( $settings['exad_post_carousel_transition_duration'] ),
                'data-direction'                => esc_attr( $direction )
            ]
        );

        if ( 'yes' === $settings['exad_post_carousel_pause'] ) {
            $this->add_render_attribute( 'exad_post_carousel_wrapper', 'data-pauseonhover', 'true' );
        }


        if ( 'yes' === $settings['exad_post_carousel_autoplay'] ) {
            $this->add_render_attribute( 'exad_post_carousel_wrapper', 'data-autoplay', 'true' );
            $this->add_render_attribute( 'exad_post_carousel_wrapper', 'data-autoplayspeed', intval( esc_attr( $settings['exad_post_carousel_autoplay_speed'] ) ) );
        }

        if ( 'yes' === $settings['exad_post_carousel_loop'] ) {
            $this->add_render_attribute( 'exad_post_carousel_wrapper', 'data-loop', 'true' );
        }
        ?>

        <div <?php echo $this->get_render_attribute_string( 'exad_post_carousel_wrapper' ); ?>>
            <?php ProHelper::exad_get_posts( $settings ); ?>
        </div>
        
    <?php    
    }
}