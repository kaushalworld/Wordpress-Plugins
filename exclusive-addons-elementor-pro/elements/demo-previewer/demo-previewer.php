<?php
namespace ExclusiveAddons\Elements;

if ( ! defined( 'ABSPATH' ) ) exit;

use \Elementor\Controls_Manager;
use \Elementor\Widget_Base;
use \Elementor\Control_Media;
use \Elementor\Utils;
use \Elementor\Group_Control_Image_Size;
use \Elementor\Group_Control_Border;
use \Elementor\Group_Control_Box_Shadow;
use \Elementor\Group_Control_Typography;
use \Elementor\Repeater;
use \Elementor\Group_Control_Background;
use \Elementor\Icons_Manager;
use \ExclusiveAddons\Elementor\Helper;

class Demo_Previewer extends Widget_Base {
	
	public function get_name() {
		return 'exad-demo-previewer';
	}

	public function get_title() {
		return esc_html__( 'Demo Previewer', 'exclusive-addons-elementor-pro' );
	}

	public function get_icon() {
		return 'exad exad-logo exad-demo-previewer';
	}

	public function get_categories() {
		return [ 'exclusive-addons-elementor' ];
	}

	public function get_script_depends(){
        return [ 'exad-isotope-pro', 'exad-simple-load-more' ];
    }

	public function get_keywords() {
        return [ 'thumb', 'preview', 'thumb preview', 'demo', 'previewer', 'preview', 'demo previewer' ];
    }

	protected function register_controls() {
        $exad_primary_color   = get_option( 'exad_primary_color_option', '#7a56ff' );
		
		/**
		* thumb Preview Content Section
		*/
		$this->start_controls_section(
			'exad_demo_previewer_content',
			[
				'label' => esc_html__( 'Content', 'exclusive-addons-elementor-pro' )
			]
        );

        $this->add_control(
            'exad_demo_previewer_title_tag',
            [
                'label'   => __('Title HTML Tag', 'exclusive-addons-elementor-pro'),
                'type'    => Controls_Manager::SELECT,
                'options' => Helper::exad_title_tags(),
                'default' => 'h6',
            ]
		);
        
        $repeater = new Repeater();

        $repeater->add_control(
            'exad_demo_previewer_cover_image', 
            [
				'label'       => esc_html__('Cover Image', 'exclusive-addons-elementor-pro'),
                'type'        => Controls_Manager::MEDIA,
                'default'     => [
                    'url'     => Utils::get_placeholder_image_src()
                ],
                'dynamic' => [
					'active' => true,
				]
			]
        );

        $repeater->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
                'name'    => 'demo_previewer_cover_image_size',
                'default' => 'full'
            ]
        );

        $repeater->add_control(
            'exad_demo_previewer_scroll_image', 
            [
				'label'       => esc_html__('Scroll Image', 'exclusive-addons-elementor-pro'),
                'type'        => Controls_Manager::MEDIA,
                'default'     => [
                    'url'     => Utils::get_placeholder_image_src()
                ],
                'dynamic' => [
					'active' => true,
				]
			]
        );

        $repeater->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
                'name'    => 'demo_previewer_scroll_image_size',
                'default' => 'medium_large'
            ]
        );

        $repeater->add_control(
            'exad_demo_previewer_item_title', 
            [
				'label'       => esc_html__('Title', 'exclusive-addons-elementor-pro'),
                'type'        => Controls_Manager::TEXT,
                'label_block' => true,
                'default'     => esc_html__('Thumb Title', 'exclusive-addons-elementor-pro')
			]
        );

        $repeater->add_control(
            'exad_demo_previewer_item_title_url', 
            [
				'label' => __( 'Title URL', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::URL,
				'placeholder' => __( 'https://your-link.com', 'exclusive-addons-elementor-pro' ),
			]
        );
        
        $repeater->add_control(
            'exad_demo_previewer_item_description', 
            [
                'label'       => esc_html__('Description', 'exclusive-addons-elementor-pro'),
                'type'        => Controls_Manager::TEXTAREA,
                'label_block' => true,
                'default'     => esc_html__('Lorem ipsum dolor sit amet.', 'exclusive-addons-elementor-pro')
			]
        );

        $repeater->add_control(
			'exad_demo_previewer_enable_content_btn',
			[
				'label' => __( 'Show Content Button', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'exclusive-addons-elementor-pro' ),
				'label_off' => __( 'Hide', 'exclusive-addons-elementor-pro' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
        );

        $repeater->add_control(
            'exad_demo_previewer_item_content_button_text', 
            [
                'label'       => esc_html__('Content Button Text', 'exclusive-addons-elementor-pro'),
                'type'        => Controls_Manager::TEXT,
                'default'     => esc_html__('Download', 'exclusive-addons-elementor-pro'),
                'label_block' => true,
                'condition' => [
                    'exad_demo_previewer_enable_content_btn' => 'yes'
                ]
			]
        );

        $repeater->add_control(
            'exad_demo_previewer_item_content_button_url',
            [
                'label'         => esc_html__( 'Link', 'exclusive-addons-elementor-pro' ),
                'type'          => Controls_Manager::URL,
                'label_block'   => true,
                'placeholder'   => __( 'https://your-link.com', 'exclusive-addons-elementor-pro' ),
                'show_external' => true,
                'default'       => [
                    'url'         => '#',
                    'is_external' => true
                ],
                'condition' => [
                    'exad_demo_previewer_enable_content_btn' => 'yes'
                ]
            ]
        );

        $repeater->add_control(
            'exad_demo_previewer_item_content_button_icon',
            [
                'label'   => esc_html__( 'Icon', 'exclusive-addons-elementor-pro' ),
                'type'    => Controls_Manager::ICONS,
                'default' => [
                    'value'   => 'fa fa-arrow-down',
                    'library' => 'fa-solid'
                ],
                'condition' => [
                    'exad_demo_previewer_enable_content_btn' => 'yes'
                ]
            ]
        );
        
        $repeater->add_control(
            'exad_demo_previewer_control_name', 
            [
				'label'       => esc_html__('Control Name', 'exclusive-addons-elementor-pro'),
                'type'        => Controls_Manager::TEXT,
                'label_block' => true,
                'description' => __( '<b>Comma separated demo controls. Example: Design, Development</b>', 'exclusive-addons-elementor-pro' )
			]
        );

        $repeater->add_control(
            'exad_demo_previewer_filter_name', 
            [
				'label'       => esc_html__('Dropdown Filter Name', 'exclusive-addons-elementor-pro'),
                'type'        => Controls_Manager::TEXT,
                'label_block' => true,
                'description' => __( '<b>Comma separated demo controls. Example: popular, New</b>', 'exclusive-addons-elementor-pro' ),
			]
        );

        $repeater->add_control(
			'exad_demo_previewer_enable_tag',
			[
				'label' => __( 'Enable Tag List?', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'exclusive-addons-elementor-pro' ),
				'label_off' => __( 'Hide', 'exclusive-addons-elementor-pro' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
        );

        $repeater->add_control(
            'exad_demo_previewer_tag_list',
            [
                'label'       => esc_html__('Tag List', 'exclusive-addons-elementor-pro'),
                'type'        => Controls_Manager::TEXT,
                'label_block' => true,
                'default'     => 'Hot, New',
                'description' => __( '<b>Comma separated Label. Example: Hot, New</b>', 'exclusive-addons-elementor-pro' ),
                'condition'   => [
                    'exad_demo_previewer_enable_tag' => 'yes'
                ]
            ]
        );

        $repeater->add_control(
			'exad_demo_previewer_enable_label',
			[
				'label' => __( 'Enable Label?', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'exclusive-addons-elementor-pro' ),
				'label_off' => __( 'Hide', 'exclusive-addons-elementor-pro' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
        );

        $repeater->add_control(
			'exad_demo_previewer_label_list',
			[
				'label' => __( 'Label', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::TEXT,
                'default' => __( 'Free', 'exclusive-addons-elementor-pro' ),
                'condition' => [
                    'exad_demo_previewer_enable_label' => 'yes'
                ]
			]
        );
        
        $repeater->add_control(
			'exad_demo_previewer_label_custom_style',
			[
				'label' => __( 'Label Custome Style?', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'exclusive-addons-elementor-pro' ),
				'label_off' => __( 'Hide', 'exclusive-addons-elementor-pro' ),
				'return_value' => 'yes',
				'default' => 'no',
			]
        );

        $repeater->add_control(
            'exad_demo_previewer_label_custom_background',
            [
                'label'     => esc_html__('Background Color', 'exclusive-addons-elementor-pro'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}}.exad-demo-previewer-item .exad-demo-previewer-label-text' => 'background: {{VALUE}};'
                ],
                'condition' => [
                    'exad_demo_previewer_label_custom_style' => 'yes'
                ]
            ]
        );

        $repeater->add_control(
            'exad_demo_previewer_label_custom_color',
            [
                'label'     => esc_html__('Text Color', 'exclusive-addons-elementor-pro'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}}.exad-demo-previewer-item .exad-demo-previewer-label-text' => 'color: {{VALUE}};'
                ],
                'condition' => [
                    'exad_demo_previewer_label_custom_style' => 'yes'
                ]
            ]
        );

        $repeater->add_responsive_control(
            'exad_demo_previewer_label_custom_padding',
            [
                'label'      => __( 'Padding', 'exclusive-addons-elementor-pro' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'default'    => [
                    'top'      => '0',
                    'right'    => '0',
                    'bottom'   => '0',
                    'left'     => '0',
                    'unit'     => 'px',
                    'isLinked' => true,
                ],
                'selectors'  => [
                    '{{WRAPPER}} {{CURRENT_ITEM}}.exad-demo-previewer-item .exad-demo-previewer-label-text' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition' => [
                    'exad_demo_previewer_label_custom_style' => 'yes'
                ]
            ]
        );

        $repeater->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'exad_demo_previewer_label_custom_border',
				'label' => __( 'Border', 'exclusive-addons-elementor-pro' ),
                'selector' => '{{WRAPPER}} {{CURRENT_ITEM}}.exad-demo-previewer-item .exad-demo-previewer-label-text',
                'condition' => [
                    'exad_demo_previewer_label_custom_style' => 'yes'
                ]
			]
        );

        $repeater->add_responsive_control(
            'exad_demo_previewer_label_custom_border_radius',
            [
                'label'      => __( 'Border Radius', 'exclusive-addons-elementor-pro' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'default'    => [
                    'top'      => '0',
                    'right'    => '0',
                    'bottom'   => '0',
                    'left'     => '0',
                    'unit'     => 'px',
                    'isLinked' => true,
                ],
                'selectors'  => [
                    '{{WRAPPER}} {{CURRENT_ITEM}}.exad-demo-previewer-item .exad-demo-previewer-label-text' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition' => [
                    'exad_demo_previewer_label_custom_style' => 'yes'
                ]
            ]
        );

        $repeater->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'exad_demo_previewer_label_custom_shadow',
				'label' => __( 'Box Shadow', 'exclusive-addons-elementor-pro' ),
                'selector' => '{{WRAPPER}} {{CURRENT_ITEM}}.exad-demo-previewer-item .exad-demo-previewer-label-text',
                'condition' => [
                    'exad_demo_previewer_label_custom_style' => 'yes'
                ]
			]
		);

        $this->add_control(
			'exad_demo_previewer_items',
			[
				'type' 		=> Controls_Manager::REPEATER,
				'fields' 	=> $repeater->get_controls(),
				'default' => [
                    ['exad_demo_previewer_control_name' => 'Design, Branding'],
                    ['exad_demo_previewer_control_name' => 'Interior'],
                    ['exad_demo_previewer_control_name' => 'Development'],
                    ['exad_demo_previewer_control_name' => 'Design, Interior'],
                    ['exad_demo_previewer_control_name' => 'Branding, Development'],
                    ['exad_demo_previewer_control_name' => 'Design, Development'],
                ],
				'title_field' => '{{exad_demo_previewer_item_title}}'
			]
        );

        $this->end_controls_section();

		/**
		* thumb Preview Setting Section
		*/
		$this->start_controls_section(
			'exad_demo_previewer_settings',
			[
				'label' => esc_html__( 'Settings', 'exclusive-addons-elementor-pro' )
			]
        );

        $this->add_control(
            'exad_demo_previewer_layout',
            [
                'label'   => esc_html__('Layout', 'exclusive-addons-elementor-pro'),
                'type'    => Controls_Manager::SELECT,
                'default' => 'exad-demo-previewer-layout-1',
                'options' => [
                    'exad-demo-previewer-layout-1' => esc_html__('Layout 1', 'exclusive-addons-elementor-pro'),
                    'exad-demo-previewer-layout-2' => esc_html__('Layout 2', 'exclusive-addons-elementor-pro'),
                    'exad-demo-previewer-layout-3' => esc_html__('Layout 3', 'exclusive-addons-elementor-pro'),
                ]
            ]
		);
        
        $this->add_control(
			'exad_demo_previewer_enable_filter_nav',
			[
				'label' => __( 'Filter Navigation', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'exclusive-addons-elementor-pro' ),
				'label_off' => __( 'Hide', 'exclusive-addons-elementor-pro' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
        );
        
        $this->add_control(
            'exad_demo_previewer_all_item_text',
            [
                'label'     => esc_html__('Text for All Item', 'exclusive-addons-elementor-pro'),
                'type'      => Controls_Manager::TEXT,
                'default'   => __('All', 'exclusive-addons-elementor-pro'),
                'condition' => [
                    'exad_demo_previewer_enable_filter_nav' => 'yes'
                ]
            ]
        );

        $this->add_control(
			'exad_demo_previewer_enable_dropdown_filter',
			[
				'label' => __( 'Enable Dropdown Filter', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'exclusive-addons-elementor-pro' ),
				'label_off' => __( 'Hide', 'exclusive-addons-elementor-pro' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
        );

        $this->add_control(
            'exad_demo_previewer_dropdown_filter_text', 
            [
                'label'       => esc_html__('Text for All Dropdown', 'exclusive-addons-elementor-pro'),
                'type'        => Controls_Manager::TEXT,
                'default'     => esc_html__('All', 'exclusive-addons-elementor-pro'),
                'condition' => [
                    'exad_demo_previewer_enable_dropdown_filter' => 'yes'
                ]
			]
        );

        $this->add_control(
			'exad_demo_previewer_enable_search',
			[
				'label' => __( 'Enable Search Field', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'exclusive-addons-elementor-pro' ),
				'label_off' => __( 'Hide', 'exclusive-addons-elementor-pro' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
        );

        $this->add_control(
            'exad_demo_previewer_search_placeholder_text', 
            [
                'label'       => esc_html__('Search Placeholder Text', 'exclusive-addons-elementor-pro'),
                'type'        => Controls_Manager::TEXT,
                'default'     => esc_html__('Search', 'exclusive-addons-elementor-pro'),
                'label_block' => true,
                'condition' => [
                    'exad_demo_previewer_enable_search' => 'yes'
                ]
			]
        );

		$this->add_control(
            'exad_demo_previewer_columns',
            [
                'label'   => esc_html__('Columns', 'exclusive-addons-elementor-pro'),
                'type'    => Controls_Manager::SELECT,
                'default' => 'exad-col-3',
                'options' => [
                    'exad-col-1' => esc_html__('1', 'exclusive-addons-elementor-pro'),
                    'exad-col-2' => esc_html__('2',   'exclusive-addons-elementor-pro'),
                    'exad-col-3' => esc_html__('3', 'exclusive-addons-elementor-pro'),
                    'exad-col-4' => esc_html__('4',  'exclusive-addons-elementor-pro')
                ]
            ]
		);

        $this->add_control(
			'exad_demo_previewer_scroll_duration',
			[
				'label' => __( 'Scroll Duration', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::NUMBER,
				'min' => 0,
                'max' => 20,
                'default' => '4',
                'selectors' => [
					'{{WRAPPER}} .exad-demo-previewer-image:hover .exad-demo-previewer-scroll-image' => 'transition: transform {{VALUE}}s ease-in-out;;',
				],
			]
		);

        $this->add_control(
			'exad_demo_previewer_load_more_button',
			[
				'label' => esc_html__( 'Load More Button', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'exclusive-addons-elementor-pro' ),
				'label_off' => esc_html__( 'Hide', 'exclusive-addons-elementor-pro' ),
				'return_value' => 'yes',
				'default' => 'no',
			]
		);

        $this->add_control(
            'exad_demo_previewer_load_more_button_text', 
            [
                'label'       => esc_html__('Load More Button Text', 'exclusive-addons-elementor-pro'),
                'type'        => Controls_Manager::TEXT,
                'default'     => esc_html__('Load More', 'exclusive-addons-elementor-pro'),
                'label_block' => true,
                'condition' => [
                    'exad_demo_previewer_load_more_button' => 'yes'
                ]
			]
        );

        $this->add_control(
			'exad_demo_previewer_item_show',
			[
				'label' => esc_html__( 'Number of item', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::NUMBER,
				'min' => 0,
				'max' => 50,
				'step' => 1,
                'default' => 3,
                'condition' => [
                    'exad_demo_previewer_load_more_button' => 'yes'
                ]
			]
		);

        $this->end_controls_section();

		/**
		* Thumb Preview Container Style
		*/
		$this->start_controls_section(
			'exad_demo_previewer_container_style',
			[
                'label' => esc_html__( 'Container', 'exclusive-addons-elementor-pro' ),
                'tab'   => Controls_Manager::TAB_STYLE
			]
		);

		$this->add_responsive_control(
			'exad_demo_previewer_column_gap',
			[
				'label' => __( 'Column Gap', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 50,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 15,
				],
				'selectors' => [
					'{{WRAPPER}} .exad-demo-previewer-content-wrapper' => 'margin: {{SIZE}}{{UNIT}};',
				],
			]
        );
        
        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'     => 'exad_demo_previewer_container_bg',
                'label'    => __( 'Background', 'exclusive-addons-elementor-pro' ),
                'types'    => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .exad-demo-previewer .exad-demo-previewer-element',
            ]
        );

        $this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'exad_demo_previewer_container_border',
				'label' => __( 'Border', 'exclusive-addons-elementor-pro' ),
				'selector' => '{{WRAPPER}} .exad-demo-previewer .exad-demo-previewer-element',
			]
		);

        $this->add_responsive_control(
            'exad_demo_previewer_container_border_radius',
            [
                'label'      => __( 'Radius', 'exclusive-addons-elementor-pro' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'default'    => [
                    'top'      => '0',
                    'right'    => '0',
                    'bottom'   => '0',
                    'left'     => '0',
                    'unit'     => 'px',
                    'isLinked' => true,
                ],
                'selectors'  => [
                    '{{WRAPPER}} .exad-demo-previewer .exad-demo-previewer-element' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'exad_demo_previewer_container_border_box_shadow',
				'label' => __( 'Box Shadow', 'exclusive-addons-elementor-pro' ),
				'selector' => '{{WRAPPER}} .exad-demo-previewer .exad-demo-previewer-element',
			]
		);

        $this->end_controls_section();
        
		/**
		* Thumb Preview Filter Nav
		*/
		$this->start_controls_section(
			'exad_demo_previewer_filter_nav_style',
			[
                'label' => esc_html__( 'Nav Bar', 'exclusive-addons-elementor-pro' ),
                'tab'   => Controls_Manager::TAB_STYLE
			]
        );

        $this->add_responsive_control(
			'exad_demo_previewer_filter_nav_width',
			[
				'label' => __( 'Width', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ '%' ],
				'range' => [
					'%' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => '%',
					'size' => 20,
				],
				'selectors' => [
					'{{WRAPPER}} .exad-demo-previewer.exad-demo-previewer-layout-2 .exad-demo-previewer-menu-wrapper' => 'width: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .exad-demo-previewer.exad-demo-previewer-layout-2 .exad-demo-previewer-element' => 'width: calc( 100% - {{SIZE}}{{UNIT}} );',
                ],
                'condition' => [
                    'exad_demo_previewer_layout' => 'exad-demo-previewer-layout-2'
                ]
			]
        );

        $this->add_control(
			'exad_demo_previewer_filter_nav_alignment',
			[
				'label' => __( 'Allignment', 'exclusive-addons-elementor-pro' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'space-between',
				'options' => [
					'flex-start'  => __( 'Left', 'exclusive-addons-elementor-pro' ),
					'center'  => __( 'Center', 'exclusive-addons-elementor-pro' ),
					'flex-end'  => __( 'Right', 'exclusive-addons-elementor-pro' ),
					'space-between'  => __( 'Space Between', 'exclusive-addons-elementor-pro' ),
                ],
                'selectors'  => [
                    '{{WRAPPER}} .exad-demo-previewer .exad-demo-previewer-menu-wrapper' => 'justify-content: {{VALUE}};',
                ],
                'condition' => [
                    'exad_demo_previewer_layout' => 'exad-demo-previewer-layout-1'
                ]
			]
        );

        $this->add_control(
			'exad_demo_previewer_nav_order',
			[
				'label' => __( 'Nav Order', 'exclusive-addons-elementor-pro' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'control-nav-dropdown-filter-search',
                'label_block' => true,
				'options' => [
					'control-nav-dropdown-filter-search'  => __( 'Control Nav > Dropdown Filter > Search', 'exclusive-addons-elementor-pro' ),
					'search-control-nav-dropdown-filter'  => __( 'Search > Control Nav > Dropdown Filter', 'exclusive-addons-elementor-pro' ),
					'dropdown-filter-control-nav-search'  => __( 'Dropdown Filter > Control Nav > Search', 'exclusive-addons-elementor-pro' ),
                ],
			]
        );
        
        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'     => 'exad_demo_previewer_filter_nav_bg',
                'label'    => __( 'Background', 'exclusive-addons-elementor-pro' ),
                'types'    => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .exad-demo-previewer .exad-demo-previewer-menu-wrapper',
            ]
        );
        
        $this->add_responsive_control(
            'exad_demo_previewer_filter_nav_padding',
            [
                'label'      => __( 'Padding', 'exclusive-addons-elementor-pro' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'default'    => [
                    'top'      => '10',
                    'right'    => '20',
                    'bottom'   => '10',
                    'left'     => '20',
                    'unit'     => 'px',
                    'isLinked' => false,
                ],
                'selectors'  => [
                    '{{WRAPPER}} .exad-demo-previewer .exad-demo-previewer-menu-wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'exad_demo_previewer_filter_nav_margin',
            [
                'label'      => __( 'Margin', 'exclusive-addons-elementor-pro' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'default'    => [
                    'top'      => '0',
                    'right'    => '0',
                    'bottom'   => '20',
                    'left'     => '0',
                    'unit'     => 'px',
                    'isLinked' => false,
                ],
                'selectors'  => [
                    '{{WRAPPER}} .exad-demo-previewer .exad-demo-previewer-menu-wrapper' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'exad_demo_previewer_filter_nav_border',
				'label' => __( 'Border', 'exclusive-addons-elementor-pro' ),
				'selector' => '{{WRAPPER}} .exad-demo-previewer .exad-demo-previewer-menu-wrapper',
			]
		);

        $this->add_responsive_control(
            'exad_demo_previewer_filter_nav_radius',
            [
                'label'      => __( 'Radius', 'exclusive-addons-elementor-pro' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'default'    => [
                    'top'      => '0',
                    'right'    => '0',
                    'bottom'   => '0',
                    'left'     => '0',
                    'unit'     => 'px',
                    'isLinked' => true,
                ],
                'selectors'  => [
                    '{{WRAPPER}} .exad-demo-previewer .exad-demo-previewer-menu-wrapper' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'exad_demo_previewer_filter_nav_box_shadow',
				'label' => __( 'Box Shadow', 'exclusive-addons-elementor-pro' ),
				'selector' => '{{WRAPPER}} .exad-demo-previewer .exad-demo-previewer-menu-wrapper',
			]
		);

        $this->end_controls_section();
        
        /**
		* Thumb Preview Filter Nav Item
		*/
		$this->start_controls_section(
			'exad_demo_previewer_filter_nav_item_style',
			[
                'label' => esc_html__( 'Nav control Item', 'exclusive-addons-elementor-pro' ),
                'tab'   => Controls_Manager::TAB_STYLE
			]
        );

        $this->add_control(
			'exad_demo_previewer_filter_nav_item_alignment',
			[
				'label' => __( 'Alignment', 'exclusive-addons-elementor-pro' ),
                'type' => Controls_Manager::CHOOSE,
                'default' => 'center',
				'options' => [
					'left' => [
						'title' => __( 'Left', 'exclusive-addons-elementor-pro' ),
						'icon' => 'fa fa-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'exclusive-addons-elementor-pro' ),
						'icon' => 'fa fa-align-center',
					],
					'right' => [
						'title' => __( 'Right', 'exclusive-addons-elementor-pro' ),
						'icon' => 'fa fa-align-right',
					],
                ],
                'selectors'  => [
                    '{{WRAPPER}} .exad-demo-previewer .exad-demo-previewer-dropdown-control-wrapper button.filter-item' => 'text-align: {{VALUE}};',
                ],
                'condition' => [
                    'exad_demo_previewer_layout' => [ 'exad-demo-previewer-layout-2', 'exad-demo-previewer-layout-3' ]
                ]
			]
		);

        $this->add_responsive_control(
            'exad_demo_previewer_filter_nav_item_padding',
            [
                'label'      => __( 'Padding', 'exclusive-addons-elementor-pro' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'default'    => [
                    'top'      => '10',
                    'right'    => '20',
                    'bottom'   => '10',
                    'left'     => '20',
                    'unit'     => 'px',
                    'isLinked' => false,
                ],
                'selectors'  => [
                    '{{WRAPPER}} .exad-demo-previewer .exad-demo-previewer-dropdown-control-wrapper button.filter-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'exad_demo_previewer_filter_nav_item_margin',
            [
                'label'      => __( 'Margin', 'exclusive-addons-elementor-pro' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'default'    => [
                    'top'      => '0',
                    'right'    => '5',
                    'bottom'   => '0',
                    'left'     => '0',
                    'unit'     => 'px',
                    'isLinked' => false,
                ],
                'selectors'  => [
                    '{{WRAPPER}} .exad-demo-previewer .exad-demo-previewer-dropdown-control-wrapper button.filter-item:not(:last-child)' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'exad_demo_previewer_filter_nav_item_radius',
            [
                'label'      => __( 'Border Radius', 'exclusive-addons-elementor-pro' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'default'    => [
                    'top'      => '0',
                    'right'    => '0',
                    'bottom'   => '0',
                    'left'     => '0',
                    'unit'     => 'px',
                    'isLinked' => false,
                ],
                'selectors'  => [
                    '{{WRAPPER}} .exad-demo-previewer .exad-demo-previewer-dropdown-control-wrapper button.filter-item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'exad_demo_previewer_filter_nav_item_typography',
				'label' => __( 'Typography', 'exclusive-addons-elementor-pro' ),
				'selector' => '{{WRAPPER}} .exad-demo-previewer .exad-demo-previewer-dropdown-control-wrapper button.filter-item',
			]
        );
        
        $this->start_controls_tabs('exad_demo_previewer_filter_nav_item_tabs');

            // Normal item
            $this->start_controls_tab('exad_demo_previewer_filter_nav_item_normal', ['label' => esc_html__('Normal', 'exclusive-addons-elementor-pro')]);

                $this->add_control(
                    'exad_demo_previewer_filter_nav_item_normal_bg',
                    [
                        'label'     => esc_html__('Background Color', 'exclusive-addons-elementor-pro'),
                        'type'      => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .exad-demo-previewer .exad-demo-previewer-dropdown-control-wrapper button.filter-item' => 'background: {{VALUE}};'
                        ]
                    ]
                );

                $this->add_control(
                    'exad_demo_previewer_filter_nav_item_normal_color',
                    [
                        'label'     => esc_html__('Text Color', 'exclusive-addons-elementor-pro'),
                        'type'      => Controls_Manager::COLOR,
                        'default'   => '#6c6c6c',
                        'selectors' => [
                            '{{WRAPPER}} .exad-demo-previewer .exad-demo-previewer-dropdown-control-wrapper button.filter-item' => 'color: {{VALUE}};'
                        ]
                    ]
                );

                $this->add_group_control(
                    Group_Control_Border::get_type(),
                    [
                        'name' => 'exad_demo_previewer_filter_nav_item_normal_border',
                        'label' => __( 'Border', 'exclusive-addons-elementor-pro' ),
                        'selector' => '{{WRAPPER}} .exad-demo-previewer .exad-demo-previewer-dropdown-control-wrapper button.filter-item',
                    ]
                );

                $this->add_group_control(
                    Group_Control_Box_Shadow::get_type(),
                    [
                        'name' => 'exad_demo_previewer_filter_nav_item_normal_shadow',
                        'label' => __( 'Box Shadow', 'exclusive-addons-elementor-pro' ),
                        'selector' => '{{WRAPPER}} .exad-demo-previewer .exad-demo-previewer-dropdown-control-wrapper button.filter-item',
                    ]
                );

            $this->end_controls_tab();

            // Hover item
            $this->start_controls_tab('exad_demo_previewer_filter_nav_item_hover', ['label' => esc_html__('Hover', 'exclusive-addons-elementor-pro')]);
        
                $this->add_control(
                    'exad_demo_previewer_filter_nav_item_hover_bg',
                    [
                        'label'     => esc_html__('Background Color', 'exclusive-addons-elementor-pro'),
                        'type'      => Controls_Manager::COLOR,
                        'default'   => '#7d5bfb',
                        'selectors' => [
                            '{{WRAPPER}} .exad-demo-previewer .exad-demo-previewer-dropdown-control-wrapper button.filter-item:hover' => 'background: {{VALUE}};'
                        ]
                    ]
                );

                $this->add_control(
                    'exad_demo_previewer_filter_nav_item_hover_color',
                    [
                        'label'     => esc_html__('Text Color', 'exclusive-addons-elementor-pro'),
                        'type'      => Controls_Manager::COLOR,
                        'default'   => '#ffffff',
                        'selectors' => [
                            '{{WRAPPER}} .exad-demo-previewer .exad-demo-previewer-dropdown-control-wrapper button.filter-item:hover' => 'color: {{VALUE}};'
                        ]
                    ]
                );

                $this->add_group_control(
                    Group_Control_Border::get_type(),
                    [
                        'name' => 'exad_demo_previewer_filter_nav_item_hover_border',
                        'label' => __( 'Border', 'exclusive-addons-elementor-pro' ),
                        'selector' => '{{WRAPPER}} .exad-demo-previewer .exad-demo-previewer-dropdown-control-wrapper button.filter-item:hover',
                    ]
                );

                $this->add_group_control(
                    Group_Control_Box_Shadow::get_type(),
                    [
                        'name' => 'exad_demo_previewer_filter_nav_item_hover_shadow',
                        'label' => __( 'Box Shadow', 'exclusive-addons-elementor-pro' ),
                        'selector' => '{{WRAPPER}} .exad-demo-previewer .exad-demo-previewer-dropdown-control-wrapper button.filter-item:hover',
                    ]
                );
                
            $this->end_controls_tab();

            // Active item
            $this->start_controls_tab('exad_demo_previewer_filter_nav_item_active', ['label' => esc_html__('Active', 'exclusive-addons-elementor-pro')]);
        
                $this->add_control(
                    'exad_demo_previewer_filter_nav_item_active_bg',
                    [
                        'label'     => esc_html__('Background Color', 'exclusive-addons-elementor-pro'),
                        'type'      => Controls_Manager::COLOR,
                        'default'   => '#7d5bfb',
                        'selectors' => [
                            '{{WRAPPER}} .exad-demo-previewer .exad-demo-previewer-dropdown-control-wrapper button.filter-item.current' => 'background: {{VALUE}};'
                        ]
                    ]
                );

                $this->add_control(
                    'exad_demo_previewer_filter_nav_item_active_color',
                    [
                        'label'     => esc_html__('Text Color', 'exclusive-addons-elementor-pro'),
                        'type'      => Controls_Manager::COLOR,
                        'default'   => '#ffffff',
                        'selectors' => [
                            '{{WRAPPER}} .exad-demo-previewer .exad-demo-previewer-dropdown-control-wrapper button.filter-item.current' => 'color: {{VALUE}};'
                        ]
                    ]
                );

                $this->add_group_control(
                    Group_Control_Border::get_type(),
                    [
                        'name' => 'exad_demo_previewer_filter_nav_item_active_border',
                        'label' => __( 'Border', 'exclusive-addons-elementor-pro' ),
                        'selector' => '{{WRAPPER}} .exad-demo-previewer .exad-demo-previewer-dropdown-control-wrapper button.filter-item.current',
                    ]
                );

                $this->add_group_control(
                    Group_Control_Box_Shadow::get_type(),
                    [
                        'name' => 'exad_demo_previewer_filter_nav_item_active_shadow',
                        'label' => __( 'Box Shadow', 'exclusive-addons-elementor-pro' ),
                        'selector' => '{{WRAPPER}} .exad-demo-previewer .exad-demo-previewer-dropdown-control-wrapper button.filter-item.current',
                    ]
                );
                
            $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();

        /**
		* Thumb Preview Dropdown Filter
		*/
		$this->start_controls_section(
			'exad_demo_previewer_dropdown_filter_style',
			[
                'label' => esc_html__( 'Filter', 'exclusive-addons-elementor-pro' ),
                'tab'   => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'exad_demo_previewer_enable_dropdown_filter' => 'yes'
                ]
			]
        );

        $this->add_control(
			'exad_demo_previewer_dropdown_filter_heading',
			[
				'label' => __( 'Dropdown Filter', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::HEADING,
			]
		);

        $this->add_responsive_control(
			'exad_demo_previewer_dropdown_filter_width',
			[
				'label' => __( 'Width', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 500,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 200,
				],
				'selectors' => [
					'{{WRAPPER}} .exad-demo-previewer-dropdown-filter-wrapper' => 'width: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'exad_demo_previewer_layout' => 'exad-demo-previewer-layout-1'
                ]
			]
        );

        $this->add_responsive_control(
            'exad_demo_previewer_dropdown_filter_padding',
            [
                'label'      => __( 'Padding', 'exclusive-addons-elementor-pro' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'default'    => [
                    'top'      => '10',
                    'right'    => '20',
                    'bottom'   => '10',
                    'left'     => '20',
                    'unit'     => 'px',
                    'isLinked' => false,
                ],
                'selectors'  => [
                    '{{WRAPPER}} .exad-demo-previewer-dropdown-filter-wrapper .exad-demo-previewer-dropdown-filter-default li' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'exad_demo_previewer_dropdown_filter_margin',
            [
                'label'      => __( 'Margin', 'exclusive-addons-elementor-pro' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'default'    => [
                    'top'      => '0',
                    'right'    => '0',
                    'bottom'   => '0',
                    'left'     => '0',
                    'unit'     => 'px',
                    'isLinked' => false,
                ],
                'selectors'  => [
                    '{{WRAPPER}} .exad-demo-previewer-dropdown-filter-wrapper' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'exad_demo_previewer_dropdown_filter_background',
            [
                'label'     => esc_html__('Background Color', 'exclusive-addons-elementor-pro'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .exad-demo-previewer-dropdown-filter-wrapper .exad-demo-previewer-dropdown-filter-default' => 'background: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'exad_demo_previewer_dropdown_filter_color',
            [
                'label'     => esc_html__('Text Color', 'exclusive-addons-elementor-pro'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#000000',
                'selectors' => [
                    '{{WRAPPER}} .exad-demo-previewer-dropdown-filter-wrapper .exad-demo-previewer-dropdown-filter-default li button' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .exad-demo-previewer-dropdown-filter-wrapper .exad-demo-previewer-dropdown-filter-shape svg path' => 'fill: {{VALUE}};',
                ]
            ]
        );

        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'exad_demo_previewer_dropdown_filter_typography',
				'label' => __( 'Typography', 'exclusive-addons-elementor-pro' ),
				'selector' => '{{WRAPPER}} .exad-demo-previewer-dropdown-filter-wrapper .exad-demo-previewer-dropdown-filter-default li button',
			]
		);

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'exad_demo_previewer_dropdown_filter_border',
                'label' => __( 'Border', 'exclusive-addons-elementor-pro' ),
                'selector' => '{{WRAPPER}} .exad-demo-previewer-dropdown-filter-wrapper .exad-demo-previewer-dropdown-filter-default',
            ]
        );

        $this->add_responsive_control(
            'exad_demo_previewer_dropdown_filter_border_radius',
            [
                'label'      => __( 'Border Radius', 'exclusive-addons-elementor-pro' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'default'    => [
                    'top'      => '0',
                    'right'    => '0',
                    'bottom'   => '0',
                    'left'     => '0',
                    'unit'     => 'px',
                    'isLinked' => true,
                ],
                'selectors'  => [
                    '{{WRAPPER}} .exad-demo-previewer-dropdown-filter-wrapper .exad-demo-previewer-dropdown-filter-default' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'exad_demo_previewer_dropdown_filter_box_shadow',
                'label' => __( 'Box Shadow', 'exclusive-addons-elementor-pro' ),
                'selector' => '{{WRAPPER}} .exad-demo-previewer-dropdown-filter-wrapper .exad-demo-previewer-dropdown-filter-default',
            ]
        );

        $this->add_control(
			'exad_demo_previewer_dropdown_filter_items_heading',
			[
				'label' => __( 'Dropdown Filter Items', 'exclusive-addons-elementor-pro' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before'
			]
        );

        $this->add_responsive_control(
			'exad_demo_previewer_dropdown_filter_items_top_spacing',
			[
				'label' => __( 'Dropdown Items Top Spacing', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 40,
				],
				'selectors' => [
					'{{WRAPPER}} .exad-demo-previewer-dropdown-filter-wrapper .exad-demo-previewer-dropdown-filter-select' => 'top: {{SIZE}}{{UNIT}};',
				],
			]
        );

        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'exad_demo_previewer_dropdown_filter_items_typography',
				'label' => __( 'Typography', 'exclusive-addons-elementor-pro' ),
				'selector' => '{{WRAPPER}} .exad-demo-previewer-dropdown-filter-wrapper .exad-demo-previewer-dropdown-filter-select li button',
			]
		);

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'exad_demo_previewer_dropdown_filter_items_border',
                'label' => __( 'Border', 'exclusive-addons-elementor-pro' ),
                'selector' => '{{WRAPPER}} .exad-demo-previewer-dropdown-filter-wrapper .exad-demo-previewer-dropdown-filter-select',
            ]
        );

        $this->add_responsive_control(
            'exad_demo_previewer_dropdown_filter_items_border_radius',
            [
                'label'      => __( 'Border Radius', 'exclusive-addons-elementor-pro' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'default'    => [
                    'top'      => '0',
                    'right'    => '0',
                    'bottom'   => '0',
                    'left'     => '0',
                    'unit'     => 'px',
                    'isLinked' => true,
                ],
                'selectors'  => [
                    '{{WRAPPER}} .exad-demo-previewer-dropdown-filter-wrapper .exad-demo-previewer-dropdown-filter-select' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        
        $this->add_responsive_control(
            'exad_demo_previewer_dropdown_filter_item_padding',
            [
                'label'      => __( 'Item Padding', 'exclusive-addons-elementor-pro' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'default'    => [
                    'top'      => '10',
                    'right'    => '20',
                    'bottom'   => '10',
                    'left'     => '20',
                    'unit'     => 'px',
                    'isLinked' => false,
                ],
                'selectors'  => [
                    '{{WRAPPER}} .exad-demo-previewer-dropdown-filter-wrapper .exad-demo-previewer-dropdown-filter-select li' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'exad_demo_previewer_dropdown_filter_item_border_bottom_color',
            [
                'label'     => esc_html__('Item Border Bottom Color', 'exclusive-addons-elementor-pro'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#000000',
                'selectors' => [
                    '{{WRAPPER}} .exad-demo-previewer-dropdown-filter-wrapper .exad-demo-previewer-dropdown-filter-select li:not(:last-child)' => 'border-bottom: 1px solid {{VALUE}};',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'exad_demo_previewer_dropdown_filter_items_box_shadow',
                'label' => __( 'Box Shadow', 'exclusive-addons-elementor-pro' ),
                'selector' => '{{WRAPPER}} .exad-demo-previewer-dropdown-filter-wrapper .exad-demo-previewer-dropdown-filter-select',
            ]
        );

        $this->start_controls_tabs('exad_demo_previewer_dropdown_filter_item_tabs');

            // Normal item
            $this->start_controls_tab('exad_demo_previewer_dropdown_filter_item_normal', ['label' => esc_html__('Normal', 'exclusive-addons-elementor-pro')]);

                $this->add_control(
                    'exad_demo_previewer_dropdown_filter_item_normal_bg_color',
                    [
                        'label'     => esc_html__('Background Color', 'exclusive-addons-elementor-pro'),
                        'type'      => Controls_Manager::COLOR,
                        'default'   => '#ffffff',
                        'selectors' => [
                            '{{WRAPPER}} .exad-demo-previewer-dropdown-filter-wrapper .exad-demo-previewer-dropdown-filter-select li' => 'background: {{VALUE}};'
                        ]
                    ]
                );

                $this->add_control(
                    'exad_demo_previewer_dropdown_filter_item_normal_color',
                    [
                        'label'     => esc_html__('Text Color', 'exclusive-addons-elementor-pro'),
                        'type'      => Controls_Manager::COLOR,
                        'default'   => '#000000',
                        'selectors' => [
                            '{{WRAPPER}} .exad-demo-previewer-dropdown-filter-wrapper .exad-demo-previewer-dropdown-filter-select li button' => 'color: {{VALUE}};'
                        ]
                    ]
                );

            $this->end_controls_tab();

            // Hover item
            $this->start_controls_tab('exad_demo_previewer_dropdown_filter_item_hover', ['label' => esc_html__('Hover', 'exclusive-addons-elementor-pro')]);

                $this->add_control(
                    'exad_demo_previewer_dropdown_filter_item_hover_bg_color',
                    [
                        'label'     => esc_html__('Background Color', 'exclusive-addons-elementor-pro'),
                        'type'      => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .exad-demo-previewer-dropdown-filter-wrapper .exad-demo-previewer-dropdown-filter-select li:hover' => 'background: {{VALUE}};'
                        ]
                    ]
                );

                $this->add_control(
                    'exad_demo_previewer_dropdown_filter_item_hover_color',
                    [
                        'label'     => esc_html__('Text Color', 'exclusive-addons-elementor-pro'),
                        'type'      => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .exad-demo-previewer-dropdown-filter-wrapper .exad-demo-previewer-dropdown-filter-select li:hover button' => 'color: {{VALUE}};'
                        ]
                    ]
                );
                
            $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();

        /**
		* Thumb Preview search
		*/
		$this->start_controls_section(
			'exad_demo_previewer_search_style',
			[
                'label' => esc_html__( 'Search Field', 'exclusive-addons-elementor-pro' ),
                'tab'   => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'exad_demo_previewer_enable_search' => 'yes'
                ]
			]
        );

        $this->add_responsive_control(
			'exad_demo_previewer_search_width',
			[
				'label' => __( 'Width', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 500,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 200,
				],
				'selectors' => [
					'{{WRAPPER}} .exad-demo-previewer-search' => 'width: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'exad_demo_previewer_layout' => 'exad-demo-previewer-layout-1'
                ]
			]
        );

        $this->add_responsive_control(
			'exad_demo_previewer_search_height',
			[
				'label' => __( 'Height', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 40,
				],
				'selectors' => [
					'{{WRAPPER}} .exad-demo-previewer-search' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'     => 'exad_demo_previewer_search_background',
                'label'    => __( 'Background', 'exclusive-addons-elementor-pro' ),
                'types'    => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .exad-demo-previewer-search #exad-demo-previewer-search-input',
            ]
        );

        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'exad_demo_previewer_search_typography',
				'label' => __( 'Typography', 'exclusive-addons-elementor-pro' ),
				'selector' => '{{WRAPPER}} .exad-demo-previewer-search #exad-demo-previewer-search-input',
			]
        );

        $this->add_control(
            'exad_demo_previewer_search_text_color',
            [
                'label'     => esc_html__('Text Color', 'exclusive-addons-elementor-pro'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#000000',
                'selectors' => [
                    '{{WRAPPER}} .exad-demo-previewer-search #exad-demo-previewer-search-input' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .exad-demo-previewer-search .exad-demo-previewer-search-icon svg path' => 'fill: {{VALUE}};'
                ]
            ]
        );

        $this->add_control(
            'exad_demo_previewer_search_placeholder_color',
            [
                'label'     => esc_html__('Placeholder Color', 'exclusive-addons-elementor-pro'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#000000',
                'selectors' => [
                    '{{WRAPPER}} .exad-demo-previewer-search #exad-demo-previewer-search-input::placeholder' => 'color: {{VALUE}};'
                ]
            ]
        );

        $this->add_responsive_control(
            'exad_demo_previewer_search_padding',
            [
                'label'      => __( 'Padding', 'exclusive-addons-elementor-pro' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'default'    => [
                    'top'      => '0',
                    'right'    => '20',
                    'bottom'   => '0',
                    'left'     => '20',
                    'unit'     => 'px',
                    'isLinked' => false,
                ],
                'selectors'  => [
                    '{{WRAPPER}} .exad-demo-previewer-search #exad-demo-previewer-search-input' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'exad_demo_previewer_search_margin',
            [
                'label'      => __( 'Margin', 'exclusive-addons-elementor-pro' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'default'    => [
                    'top'      => '0',
                    'right'    => '0',
                    'bottom'   => '0',
                    'left'     => '0',
                    'unit'     => 'px',
                    'isLinked' => false,
                ],
                'selectors'  => [
                    '{{WRAPPER}} .exad-demo-previewer-search' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'exad_demo_previewer_search_border',
                'label' => __( 'Border', 'exclusive-addons-elementor-pro' ),
                'selector' => '{{WRAPPER}} .exad-demo-previewer-search #exad-demo-previewer-search-input',
            ]
        );

        $this->add_responsive_control(
            'exad_demo_previewer_search_border_radius',
            [
                'label'      => __( 'Border Radius', 'exclusive-addons-elementor-pro' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'default'    => [
                    'top'      => '0',
                    'right'    => '0',
                    'bottom'   => '0',
                    'left'     => '0',
                    'unit'     => 'px',
                    'isLinked' => false,
                ],
                'selectors'  => [
                    '{{WRAPPER}} .exad-demo-previewer-search #exad-demo-previewer-search-input' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'exad_demo_previewer_search_box_shadow',
                'label' => __( 'Box Shadow', 'exclusive-addons-elementor-pro' ),
                'selector' => '{{WRAPPER}} .exad-demo-previewer-search #exad-demo-previewer-search-input',
            ]
        );

        $this->end_controls_section();

        /**
		* Thumb Preview Filter Nav Item
		*/
		$this->start_controls_section(
			'exad_demo_previewer_item_style',
			[
                'label' => esc_html__( 'Preview Item', 'exclusive-addons-elementor-pro' ),
                'tab'   => Controls_Manager::TAB_STYLE
			]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'     => 'exad_demo_previewer_item_backgroungd',
                'label'    => __( 'Background', 'exclusive-addons-elementor-pro' ),
                'types'    => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .exad-demo-previewer .exad-demo-previewer-content-wrapper',
            ]
        );

        $this->add_responsive_control(
            'exad_demo_previewer_item_padding',
            [
                'label'      => __( 'Padding', 'exclusive-addons-elementor-pro' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'default'    => [
                    'top'      => '0',
                    'right'    => '0',
                    'bottom'   => '0',
                    'left'     => '0',
                    'unit'     => 'px',
                    'isLinked' => false,
                ],
                'selectors'  => [
                    '{{WRAPPER}} .exad-demo-previewer .exad-demo-previewer-content-wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'exad_demo_previewer_item_border',
                'label' => __( 'Border', 'exclusive-addons-elementor-pro' ),
                'selector' => '{{WRAPPER}} .exad-demo-previewer .exad-demo-previewer-content-wrapper',
            ]
        );

        $this->add_responsive_control(
            'exad_demo_previewer_item_radius',
            [
                'label'      => __( 'Border Radius', 'exclusive-addons-elementor-pro' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'default'    => [
                    'top'      => '0',
                    'right'    => '0',
                    'bottom'   => '0',
                    'left'     => '0',
                    'unit'     => 'px',
                    'isLinked' => false,
                ],
                'selectors'  => [
                    '{{WRAPPER}} .exad-demo-previewer .exad-demo-previewer-content-wrapper' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'exad_demo_previewer_item_box_shadow',
                'label' => __( 'Box Shadow', 'exclusive-addons-elementor-pro' ),
                'selector' => '{{WRAPPER}} .exad-demo-previewer .exad-demo-previewer-content-wrapper',
            ]
        );

        $this->end_controls_section();

        /**
		* Thumb Preview image
		*/
		$this->start_controls_section(
			'exad_demo_previewer_item_image',
			[
                'label' => esc_html__( 'Preview Image', 'exclusive-addons-elementor-pro' ),
                'tab'   => Controls_Manager::TAB_STYLE
			]
        );

        $this->add_responsive_control(
			'exad_demo_previewer_item_image_height',
			[
				'label' => __( 'Image Height', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 500,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 225,
				],
				'selectors' => [
					'{{WRAPPER}} .exad-demo-previewer-image' => 'height: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .exad-demo-previewer-image:hover .exad-demo-previewer-scroll-image' => 'transform: translateY(calc(-100% + {{SIZE}}{{UNIT}}));',
				],
			]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'exad_demo_previewer_item_image_border',
                'label' => __( 'Border', 'exclusive-addons-elementor-pro' ),
                'selector' => '{{WRAPPER}} .exad-demo-previewer-image',
            ]
        );

        $this->add_responsive_control(
            'exad_demo_previewer_item_image_radius',
            [
                'label'      => __( 'Border Radius', 'exclusive-addons-elementor-pro' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'default'    => [
                    'top'      => '0',
                    'right'    => '0',
                    'bottom'   => '0',
                    'left'     => '0',
                    'unit'     => 'px',
                    'isLinked' => false,
                ],
                'selectors'  => [
                    '{{WRAPPER}} .exad-demo-previewer-image' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'exad_demo_previewer_item_image_shadow',
                'label' => __( 'Box Shadow', 'exclusive-addons-elementor-pro' ),
                'selector' => '{{WRAPPER}} .exad-demo-previewer-image',
            ]
        );

        $this->end_controls_section();

        /**
		* Thumb Preview Content
		*/
		$this->start_controls_section(
			'exad_demo_previewer_item_content',
			[
                'label' => esc_html__( 'Preview Content', 'exclusive-addons-elementor-pro' ),
                'tab'   => Controls_Manager::TAB_STYLE
			]
        );

        $this->add_responsive_control(
            'exad_demo_previewer_item_content_padding',
            [
                'label'      => __( 'Padding', 'exclusive-addons-elementor-pro' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'default'    => [
                    'top'      => '10',
                    'right'    => '0',
                    'bottom'   => '0',
                    'left'     => '0',
                    'unit'     => 'px',
                    'isLinked' => false,
                ],
                'selectors'  => [
                    '{{WRAPPER}} .exad-demo-previewer-item-content-wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
			'exad_demo_previewer_item_content_title_style',
			[
				'label' => __( 'Content Heading', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
        );

        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'exad_demo_previewer_item_content_title_typography',
				'label' => __( 'Typography', 'exclusive-addons-elementor-pro' ),
				'selector' => '{{WRAPPER}} .exad-demo-previewer-item-content-title a',
			]
        );

        $this->add_responsive_control(
            'exad_demo_previewer_item_content_title_margin',
            [
                'label'      => __( 'Margin', 'exclusive-addons-elementor-pro' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'default'    => [
                    'top'      => '0',
                    'right'    => '0',
                    'bottom'   => '5',
                    'left'     => '0',
                    'unit'     => 'px',
                    'isLinked' => false,
                ],
                'selectors'  => [
                    '{{WRAPPER}} .exad-demo-previewer-item-content-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs('exad_demo_previewer_item_content_title_tabs');

            // Normal item
            $this->start_controls_tab('exad_demo_previewer_item_content_title_normal', ['label' => esc_html__('Normal', 'exclusive-addons-elementor-pro')]);

                $this->add_control(
                    'exad_demo_previewer_item_content_title_normal_color',
                    [
                        'label'     => esc_html__('Text Color', 'exclusive-addons-elementor-pro'),
                        'type'      => Controls_Manager::COLOR,
                        'default'   => '#000000',
                        'selectors' => [
                            '{{WRAPPER}} .exad-demo-previewer-item-content-title a' => 'color: {{VALUE}};'
                        ]
                    ]
                );

            $this->end_controls_tab();

            // Hover item
            $this->start_controls_tab('exad_demo_previewer_item_content_title_hover', ['label' => esc_html__('Hover', 'exclusive-addons-elementor-pro')]);

                $this->add_control(
                    'exad_demo_previewer_item_content_title_hover_color',
                    [
                        'label'     => esc_html__('Text Color', 'exclusive-addons-elementor-pro'),
                        'type'      => Controls_Manager::COLOR,
                        'default'   => $exad_primary_color,
                        'selectors' => [
                            '{{WRAPPER}} .exad-demo-previewer-item-content-title a:hover' => 'color: {{VALUE}};'
                        ]
                    ]
                );
                
            $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_control(
			'exad_demo_previewer_item_content_description_style',
			[
				'label' => __( 'Content Description', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
        );

        $this->add_control(
            'exad_demo_previewer_item_content_description_color',
            [
                'label'     => esc_html__('Text Color', 'exclusive-addons-elementor-pro'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#000000',
                'selectors' => [
                    '{{WRAPPER}} .exad-demo-previewer-item-content-description' => 'color: {{VALUE}};'
                ]
            ]
        );

        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'exad_demo_previewer_item_content_description_typography',
				'label' => __( 'Typography', 'exclusive-addons-elementor-pro' ),
				'selector' => '{{WRAPPER}} .exad-demo-previewer-item-content-description',
			]
        );

        $this->add_responsive_control(
            'exad_demo_previewer_item_content_description_margin',
            [
                'label'      => __( 'Margin', 'exclusive-addons-elementor-pro' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'default'    => [
                    'top'      => '0',
                    'right'    => '0',
                    'bottom'   => '0',
                    'left'     => '0',
                    'unit'     => 'px',
                    'isLinked' => false,
                ],
                'selectors'  => [
                    '{{WRAPPER}} .exad-demo-previewer-item-content-description' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
			'exad_demo_previewer_item_content_button_style',
			[
				'label' => __( 'Content Button', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
        );

        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'exad_demo_previewer_item_content_button_typography',
				'label' => __( 'Typography', 'exclusive-addons-elementor-pro' ),
				'selector' => '{{WRAPPER}} .exad-demo-previewer-item-content-button',
			]
        );

        $this->add_responsive_control(
            'exad_demo_previewer_item_content_button_padding',
            [
                'label'      => __( 'Padding', 'exclusive-addons-elementor-pro' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'default'    => [
                    'top'      => '10',
                    'right'    => '20',
                    'bottom'   => '10',
                    'left'     => '20',
                    'unit'     => 'px',
                    'isLinked' => false,
                ],
                'selectors'  => [
                    '{{WRAPPER}} .exad-demo-previewer-item-content-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'exad_demo_previewer_item_content_button_radius',
            [
                'label'      => __( 'Border Radius', 'exclusive-addons-elementor-pro' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'default'    => [
                    'top'      => '0',
                    'right'    => '0',
                    'bottom'   => '0',
                    'left'     => '0',
                    'unit'     => 'px',
                    'isLinked' => true,
                ],
                'selectors'  => [
                    '{{WRAPPER}} .exad-demo-previewer-item-content-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
			'exad_demo_previewer_content_button_icon_spacing',
			[
				'label' => __( 'Icon Right Spacing', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 30,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 5,
				],
				'selectors' => [
					'{{WRAPPER}} .exad-demo-previewer-item-content-button span' => 'margin-right: {{SIZE}}{{UNIT}};',
				],
			]
        );

        $this->start_controls_tabs('exad_demo_previewer_item_content_button_tabs');

            // Normal item
            $this->start_controls_tab('exad_demo_previewer_item_content_button_normal', ['label' => esc_html__('Normal', 'exclusive-addons-elementor-pro')]);

                $this->add_control(
                    'exad_demo_previewer_item_content_button_normal_background',
                    [
                        'label'     => esc_html__('Backgroun Color', 'exclusive-addons-elementor-pro'),
                        'type'      => Controls_Manager::COLOR,
                        'default'   => '#000000',
                        'selectors' => [
                            '{{WRAPPER}} .exad-demo-previewer-item-content-button' => 'Background: {{VALUE}};'
                        ]
                    ]
                );

                $this->add_control(
                    'exad_demo_previewer_item_content_button_normal_color',
                    [
                        'label'     => esc_html__('Text Color', 'exclusive-addons-elementor-pro'),
                        'type'      => Controls_Manager::COLOR,
                        'default'   => '#ffffff',
                        'selectors' => [
                            '{{WRAPPER}} .exad-demo-previewer-item-content-button' => 'color: {{VALUE}};'
                        ]
                    ]
                );

                $this->add_group_control(
                    Group_Control_Border::get_type(),
                    [
                        'name' => 'exad_demo_previewer_item_content_button_normal_border',
                        'label' => __( 'Border', 'exclusive-addons-elementor-pro' ),
                        'selector' => '{{WRAPPER}} .exad-demo-previewer-item-content-button',
                    ]
                );

                $this->add_group_control(
                    Group_Control_Box_Shadow::get_type(),
                    [
                        'name' => 'exad_demo_previewer_item_content_button_box_shadow',
                        'label' => __( 'Box Shadow', 'exclusive-addons-elementor-pro' ),
                        'selector' => '{{WRAPPER}} .exad-demo-previewer-item-content-button',
                    ]
                );

            $this->end_controls_tab();

            // Hover item
            $this->start_controls_tab('exad_demo_previewer_item_content_button_hover', ['label' => esc_html__('Hover', 'exclusive-addons-elementor-pro')]);

                $this->add_control(
                    'exad_demo_previewer_item_content_button_hover_background',
                    [
                        'label'     => esc_html__('Backgroun Color', 'exclusive-addons-elementor-pro'),
                        'type'      => Controls_Manager::COLOR,
                        'default'   => '#ffffff',
                        'selectors' => [
                            '{{WRAPPER}} .exad-demo-previewer-item-content-button:hover' => 'Background: {{VALUE}};'
                        ]
                    ]
                );

                $this->add_control(
                    'exad_demo_previewer_item_content_button_hover_color',
                    [
                        'label'     => esc_html__('Text Color', 'exclusive-addons-elementor-pro'),
                        'type'      => Controls_Manager::COLOR,
                        'default'   => '#000000',
                        'selectors' => [
                            '{{WRAPPER}} .exad-demo-previewer-item-content-button:hover' => 'color: {{VALUE}};'
                        ]
                    ]
                );

                $this->add_group_control(
                    Group_Control_Border::get_type(),
                    [
                        'name' => 'exad_demo_previewer_item_content_button_hover_border',
                        'label' => __( 'Border', 'exclusive-addons-elementor-pro' ),
                        'selector' => '{{WRAPPER}} .exad-demo-previewer-item-content-button:hover',
                    ]
                );

                $this->add_group_control(
                    Group_Control_Box_Shadow::get_type(),
                    [
                        'name' => 'exad_demo_previewer_item_content_button_hover_box_shadow',
                        'label' => __( 'Box Shadow', 'exclusive-addons-elementor-pro' ),
                        'selector' => '{{WRAPPER}} .exad-demo-previewer-item-content-button:hover',
                    ]
                );
                
            $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();

        /**
		*  Tag & label style
		*/
		$this->start_controls_section(
			'exad_demo_previewer_item_date_tag',
			[
                'label' => esc_html__( 'Tag & Label', 'exclusive-addons-elementor-pro' ),
                'tab'   => Controls_Manager::TAB_STYLE
			]
        );

        $this->add_responsive_control(
            'exad_demo_previewer_item_date_tag_padding',
            [
                'label'      => __( 'Padding', 'exclusive-addons-elementor-pro' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'default'    => [
                    'top'      => '10',
                    'right'    => '0',
                    'bottom'   => '0',
                    'left'     => '0',
                    'unit'     => 'px',
                    'isLinked' => false,
                ],
                'selectors'  => [
                    '{{WRAPPER}} .exad-demo-previewer-item-date' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'exad_demo_previewer_item_date_tag_margin',
            [
                'label'      => __( 'Margin', 'exclusive-addons-elementor-pro' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'default'    => [
                    'top'      => '0',
                    'right'    => '0',
                    'bottom'   => '0',
                    'left'     => '0',
                    'unit'     => 'px',
                    'isLinked' => false,
                ],
                'selectors'  => [
                    '{{WRAPPER}} .exad-demo-previewer-item-date' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'exad_demo_previewer_item_date_tag_border',
                'label' => __( 'Border', 'exclusive-addons-elementor-pro' ),
                'selector' => '{{WRAPPER}} .exad-demo-previewer-item-date',
            ]
        );

        $this->add_control(
			'exad_demo_previewer_item_tag',
			[
				'label' => __( 'Tags', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
        );

        $this->add_responsive_control(
			'exad_demo_previewer_item_tag_spacing',
			[
				'label' => __( 'Tag Item Spacing', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					]
				],
				'default' => [
					'unit' => 'px',
					'size' => 10,
				],
				'selectors' => [
					'{{WRAPPER}} .exad-demo-previewer-item .exad-demo-previewer-tag ul li:not(:last-child)' => 'margin-right: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .exad-demo-previewer-item .exad-demo-previewer-tag ul li:not(:last-child)::before' => 'right: calc( 0% - ( ( {{SIZE}}{{UNIT}} + {{exad_demo_previewer_item_tag_separator_width.size}}{{exad_demo_previewer_item_tag_separator_width.unit}} ) / 2 ) );',
				],
			]
        );
        
        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'exad_demo_previewer_item_tag_typography',
				'label' => __( 'Typography', 'exclusive-addons-elementor-pro' ),
				'selector' => '{{WRAPPER}} .exad-demo-previewer-item .exad-demo-previewer-tag ul li',
			]
		);
        
        $this->add_control(
            'exad_demo_previewer_item_tag_color',
            [
                'label'     => esc_html__('Text Color', 'exclusive-addons-elementor-pro'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#000000',
                'selectors' => [
                    '{{WRAPPER}} .exad-demo-previewer-item .exad-demo-previewer-tag ul li' => 'color: {{VALUE}};'
                ]
            ]
        );

        $this->add_control(
			'exad_demo_previewer_item_tag_separator',
			[
				'label' => __( 'Enable Separator?', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'exclusive-addons-elementor-pro' ),
				'label_off' => __( 'Hide', 'exclusive-addons-elementor-pro' ),
				'return_value' => 'yes',
				'default' => 'no',
			]
        );

        $this->add_control(
			'exad_demo_previewer_item_tag_separator_popover',
			[
				'label' => __( 'Separator', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::POPOVER_TOGGLE,
				'label_off' => __( 'Default', 'exclusive-addons-elementor-pro' ),
				'label_on' => __( 'Custom', 'exclusive-addons-elementor-pro' ),
				'return_value' => 'yes',
                'default' => 'yes',
                'condition' => [
                    'exad_demo_previewer_item_tag_separator' => 'yes'
                ]
			]
		);

        $this->start_popover();

            $this->add_responsive_control(
                'exad_demo_previewer_item_tag_separator_width',
                [
                    'label' => __( 'Separator Width', 'exclusive-addons-elementor-pro' ),
                    'type' => Controls_Manager::SLIDER,
                    'size_units' => [ 'px' ],
                    'range' => [
                        'px' => [
                            'min' => 1,
                            'max' => 100,
                            'step' => 1,
                        ]
                    ],
                    'default' => [
                        'unit' => 'px',
                        'size' => 3,
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .exad-demo-previewer-item .exad-demo-previewer-tag ul li:not(:last-child)::before' => 'width: {{SIZE}}{{UNIT}};',
                    ],
                    'condition' => [
                        'exad_demo_previewer_item_tag_separator' => 'yes'
                    ]
                ]
            );

            $this->add_responsive_control(
                'exad_demo_previewer_item_tag_separator_height',
                [
                    'label' => __( 'Separator Height', 'exclusive-addons-elementor-pro' ),
                    'type' => Controls_Manager::SLIDER,
                    'size_units' => [ 'px' ],
                    'range' => [
                        'px' => [
                            'min' => 1,
                            'max' => 100,
                            'step' => 1,
                        ]
                    ],
                    'default' => [
                        'unit' => 'px',
                        'size' => 3,
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .exad-demo-previewer-item .exad-demo-previewer-tag ul li:not(:last-child)::before' => 'height: {{SIZE}}{{UNIT}};',
                    ],
                    'condition' => [
                        'exad_demo_previewer_item_tag_separator' => 'yes'
                    ]
                ]
            );

            $this->add_control(
                'exad_demo_previewer_item_tag_separator_color',
                [
                    'label'     => esc_html__('Color', 'exclusive-addons-elementor-pro'),
                    'type'      => Controls_Manager::COLOR,
                    'default'   => '#000000',
                    'selectors' => [
                        '{{WRAPPER}} .exad-demo-previewer-item .exad-demo-previewer-tag ul li:not(:last-child)::before' => 'background: {{VALUE}};'
                    ],
                    'condition' => [
                        'exad_demo_previewer_item_tag_separator' => 'yes'
                    ]
                ]
            );
        
        $this->end_popover();

        $this->add_control(
			'exad_demo_previewer_item_label',
			[
				'label' => __( 'Label', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
        );

        $this->add_control(
            'exad_demo_previewer_label_background',
            [
                'label'     => esc_html__('Background Color', 'exclusive-addons-elementor-pro'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .exad-demo-previewer-item .exad-demo-previewer-label-text' => 'background: {{VALUE}};'
                ],
            ]
        );

        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'exad_demo_previewer_label_typography',
				'label' => __( 'Typography', 'exclusive-addons-elementor-pro' ),
				'selector' => '{{WRAPPER}} .exad-demo-previewer-item .exad-demo-previewer-label-text',
			]
		);

        $this->add_control(
            'exad_demo_previewer_label_color',
            [
                'label'     => esc_html__('Text Color', 'exclusive-addons-elementor-pro'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .exad-demo-previewer-item .exad-demo-previewer-label-text' => 'color: {{VALUE}};'
                ],
            ]
        );

        $this->add_responsive_control(
            'exad_demo_previewer_label_padding',
            [
                'label'      => __( 'Padding', 'exclusive-addons-elementor-pro' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'default'    => [
                    'top'      => '0',
                    'right'    => '0',
                    'bottom'   => '0',
                    'left'     => '0',
                    'unit'     => 'px',
                    'isLinked' => true,
                ],
                'selectors'  => [
                    '{{WRAPPER}} .exad-demo-previewer-item .exad-demo-previewer-label-text' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'exad_demo_previewer_label_border',
				'label' => __( 'Border', 'exclusive-addons-elementor-pro' ),
                'selector' => '{{WRAPPER}} .exad-demo-previewer-item .exad-demo-previewer-label-text',
			]
        );

        $this->add_responsive_control(
            'exad_demo_previewer_label_border_radius',
            [
                'label'      => __( 'Border Radius', 'exclusive-addons-elementor-pro' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'default'    => [
                    'top'      => '0',
                    'right'    => '0',
                    'bottom'   => '0',
                    'left'     => '0',
                    'unit'     => 'px',
                    'isLinked' => true,
                ],
                'selectors'  => [
                    '{{WRAPPER}} .exad-demo-previewer-item .exad-demo-previewer-label-text' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'exad_demo_previewer_label_shadow',
				'label' => __( 'Box Shadow', 'exclusive-addons-elementor-pro' ),
                'selector' => '{{WRAPPER}} .exad-demo-previewer-item .exad-demo-previewer-label-text',
			]
		);

        $this->end_controls_section();

        /**
		* LOad More Button
		*/
		$this->start_controls_section(
			'exad_demo_previewer_load_more_style',
			[
                'label' => esc_html__( 'Load More Button', 'exclusive-addons-elementor-pro' ),
                'tab'   => Controls_Manager::TAB_STYLE
			]
        );

        $this->add_responsive_control(
			'exad_demo_previewer_load_more_alignment',
			[
				'label' => esc_html__( 'Alignment', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => esc_html__( 'Left', 'exclusive-addons-elementor-pro' ),
						'icon' => 'eicon-h-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'exclusive-addons-elementor-pro' ),
						'icon' => 'eicon-h-align-center',
					],
					'right' => [
						'title' => esc_html__( 'Right', 'exclusive-addons-elementor-pro' ),
						'icon' => 'eicon-h-align-right',
					],
				],
                'desktop_default' => 'center',
				'tablet_default' => 'center',
				'mobile_default' => 'center',
				'selectors_dictionary' => [
					'left' => 'text-align: left;',
					'center' => 'text-align: center;',
					'right' => 'text-align: right;',
				],
				'selectors' => [
					'{{WRAPPER}} .exad-demo-previewer .exad-demo-previewer-load-more-wrapper' => '{{VALUE}};'
				]
			]
		);

        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'exad_demo_previewer_load_more_typography',
				'label' => __( 'Typography', 'exclusive-addons-elementor-pro' ),
				'selector' => '{{WRAPPER}} .exad-demo-previewer #exad-demo-previewer-load-more-button',
			]
		);

        $this->add_responsive_control(
            'exad_demo_previewer_load_more_margin',
            [
                'label'      => __( 'Margin', 'exclusive-addons-elementor-pro' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'default'    => [
                    'top'      => '20',
                    'right'    => '0',
                    'bottom'   => '0',
                    'left'     => '0',
                    'unit'     => 'px',
                    'isLinked' => false,
                ],
                'selectors'  => [
                    '{{WRAPPER}} .exad-demo-previewer #exad-demo-previewer-load-more-button' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'exad_demo_previewer_load_more_padding',
            [
                'label'      => __( 'Padding', 'exclusive-addons-elementor-pro' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'default'    => [
                    'top'      => '10',
                    'right'    => '20',
                    'bottom'   => '10',
                    'left'     => '20',
                    'unit'     => 'px',
                    'isLinked' => false,
                ],
                'selectors'  => [
                    '{{WRAPPER}} .exad-demo-previewer #exad-demo-previewer-load-more-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'exad_demo_previewer_load_more_radius',
            [
                'label'      => __( 'Border Radius', 'exclusive-addons-elementor-pro' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'default'    => [
                    'top'      => '0',
                    'right'    => '0',
                    'bottom'   => '0',
                    'left'     => '0',
                    'unit'     => 'px',
                    'isLinked' => true,
                ],
                'selectors'  => [
                    '{{WRAPPER}} .exad-demo-previewer #exad-demo-previewer-load-more-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs('exad_demo_previewer_load_more_tabs');

            // Normal item
            $this->start_controls_tab('exad_demo_previewer_load_more_button_normal', ['label' => esc_html__('Normal', 'exclusive-addons-elementor-pro')]);

                $this->add_control(
                    'exad_demo_previewer_load_more_normal_background',
                    [
                        'label'     => esc_html__('Backgroun Color', 'exclusive-addons-elementor-pro'),
                        'type'      => Controls_Manager::COLOR,
                        'default'   => '#000000',
                        'selectors' => [
                            '{{WRAPPER}} .exad-demo-previewer #exad-demo-previewer-load-more-button' => 'background: {{VALUE}};'
                        ]
                    ]
                );

                $this->add_control(
                    'exad_demo_previewer_load_more_normal_color',
                    [
                        'label'     => esc_html__('Text Color', 'exclusive-addons-elementor-pro'),
                        'type'      => Controls_Manager::COLOR,
                        'default'   => '#ffffff',
                        'selectors' => [
                            '{{WRAPPER}} .exad-demo-previewer #exad-demo-previewer-load-more-button' => 'color: {{VALUE}};'
                        ]
                    ]
                );

                $this->add_group_control(
                    Group_Control_Border::get_type(),
                    [
                        'name' => 'exad_demo_previewer_load_more_normal_border',
                        'label' => __( 'Border', 'exclusive-addons-elementor-pro' ),
                        'selector' => '{{WRAPPER}} .exad-demo-previewer #exad-demo-previewer-load-more-button',
                    ]
                );

                $this->add_group_control(
                    Group_Control_Box_Shadow::get_type(),
                    [
                        'name' => 'exad_demo_previewer_load_more_normal_box_shadow',
                        'label' => __( 'Box Shadow', 'exclusive-addons-elementor-pro' ),
                        'selector' => '{{WRAPPER}} .exad-demo-previewer #exad-demo-previewer-load-more-button',
                    ]
                );

            $this->end_controls_tab();

            // Hover item
            $this->start_controls_tab('exad_demo_previewer_load_more_button_hover', ['label' => esc_html__('Hover', 'exclusive-addons-elementor-pro')]);

                $this->add_control(
                    'exad_demo_previewer_load_more_hover_background',
                    [
                        'label'     => esc_html__('Backgroun Color', 'exclusive-addons-elementor-pro'),
                        'type'      => Controls_Manager::COLOR,
                        'default'   => '#e5e5e5',
                        'selectors' => [
                            '{{WRAPPER}} .exad-demo-previewer #exad-demo-previewer-load-more-button:hover' => 'Background: {{VALUE}};'
                        ]
                    ]
                );

                $this->add_control(
                    'exad_demo_previewer_load_more_hover_color',
                    [
                        'label'     => esc_html__('Text Color', 'exclusive-addons-elementor-pro'),
                        'type'      => Controls_Manager::COLOR,
                        'default'   => '#000000',
                        'selectors' => [
                            '{{WRAPPER}} .exad-demo-previewer #exad-demo-previewer-load-more-button:hover' => 'color: {{VALUE}};'
                        ]
                    ]
                );

                $this->add_group_control(
                    Group_Control_Border::get_type(),
                    [
                        'name' => 'exad_demo_previewer_load_more_hover_border',
                        'label' => __( 'Border', 'exclusive-addons-elementor-pro' ),
                        'selector' => '{{WRAPPER}} .exad-demo-previewer #exad-demo-previewer-load-more-button:hover',
                    ]
                );

                $this->add_group_control(
                    Group_Control_Box_Shadow::get_type(),
                    [
                        'name' => 'exad_demo_previewer_load_more_hover_box_shadow',
                        'label' => __( 'Box Shadow', 'exclusive-addons-elementor-pro' ),
                        'selector' => '{{WRAPPER}} .exad-demo-previewer #exad-demo-previewer-load-more-button:hover',
                    ]
                );
                
            $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
	
	    do_action('exad_demo-previewer_wrapper_before');
        ?>

        <div id ="exad-demo-previewer-id-<?php echo $this->get_id(); ?>" class="exad-demo-previewer-items">
            <div class="exad-demo-previewer exad-demo-previewer-wrapper <?php echo $settings['exad_demo_previewer_layout']; ?>">
                <?php if( 'yes' === $settings['exad_demo_previewer_enable_filter_nav'] ): ?>
                    <div class="exad-demo-previewer-menu-wrapper <?php echo $settings['exad_demo_previewer_nav_order']; ?>">
                        <div class="exad-demo-previewer-menu exad-demo-previewer-dropdown-control-wrapper" data-filter-group="control">
                            <?php do_action( 'exad_demo_previewer_controls_wrapper_before' ); 
                            if( !empty( $settings['exad_demo_previewer_all_item_text'] ) ) : ?>
                                <button data-filter="*" class="filter-item current"><?php echo esc_html( $settings['exad_demo_previewer_all_item_text'] ); ?></button>
                            <?php 
                            endif;
                            $exad_demo_previewer_controls             = array_column( $settings['exad_demo_previewer_items'], 'exad_demo_previewer_control_name' );
                            $exad_demo_previewer_controls_comma_separated = implode( ', ', $exad_demo_previewer_controls );
                            $exad_demo_previewer_controls_array           = explode( ",",$exad_demo_previewer_controls_comma_separated );
                            $exad_demo_previewer_controls_lowercase       = array_map( 'strtolower', $exad_demo_previewer_controls_array );
                            $exad_demo_previewer_controls_remove_space    = array_filter( array_map( 'trim', $exad_demo_previewer_controls_lowercase ) );
                            $exad_demo_previewer_controls_items           = array_unique( $exad_demo_previewer_controls_remove_space );

                            foreach( $exad_demo_previewer_controls_items as $control ) :
                                $control_attribute = preg_replace( '#[ -]+#', '-', $control );
                            ?>    
                                <button class="filter-item" data-filter=".<?php echo esc_attr( $control_attribute ); ?>"><?php echo esc_html( $control ); ?></button>
                            <?php     
                            endforeach;
                            do_action( 'exad_demo_previewer_controls_wrapper_after' );
                            ?>
                        </div>

                        <?php     
                        if( 'yes' === $settings['exad_demo_previewer_enable_dropdown_filter'] ) { ?>
                            <div class="exad-demo-previewer-menu exad-demo-previewer-dropdown-filter-wrapper" data-filter-group="filter">
                                <span class="exad-demo-previewer-dropdown-filter-shape">
                                    <svg width="18" height="9" viewBox="0 0 18 9" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M12.5 8a.5.5 0 010 1h-7a.5.5 0 010-1h7zm3-4a.5.5 0 010 1h-13a.5.5 0 010-1h13zm2-4a.5.5 0 010 1H.5a.5.5 0 010-1h17z" fill="#D4D9E6" fill-rule="evenodd"></path>
                                    </svg>
                                </span>
                                <?php 
                                do_action( 'exad_demo_previewer_filter_wrapper_before' );
                                if( !empty( $settings['exad_demo_previewer_all_item_text'] ) ) : ?>
                                    <ul class="exad-demo-previewer-dropdown-filter-default">
                                        <li><button data-filter="*" class="filter-item current"><?php echo esc_html( $settings['exad_demo_previewer_dropdown_filter_text'] ); ?></button></li>
                                    </ul>
                                <?php
                                endif;
                                $exad_demo_previewer_filters             = array_column( $settings['exad_demo_previewer_items'], 'exad_demo_previewer_filter_name' );
                                $exad_demo_previewer_filters_comma_separated = implode( ', ', $exad_demo_previewer_filters );
                                $exad_demo_previewer_filters_array           = explode( ",",$exad_demo_previewer_filters_comma_separated );
                                $exad_demo_previewer_filters_lowercase       = array_map( 'strtolower', $exad_demo_previewer_filters_array );
                                $exad_demo_previewer_filters_remove_space    = array_filter( array_map( 'trim', $exad_demo_previewer_filters_lowercase ) );
                                $exad_demo_previewer_filters_items           = array_unique( $exad_demo_previewer_filters_remove_space );
                                ?>
                                <ul class="exad-demo-previewer-dropdown-filter-select">
                                <?php
                                    if( !empty( $settings['exad_demo_previewer_all_item_text'] ) ) : ?>
                                        <li><button data-filter="*" class="filter-item current"><?php echo esc_html( $settings['exad_demo_previewer_dropdown_filter_text'] ); ?></button></li>
                                    <?php
                                    endif;
                                    foreach( $exad_demo_previewer_filters_items as $filter ) :
                                        $filter_attribute = preg_replace( '#[ -]+#', '-', $filter ); ?>
                                        <li><button class="filter-item" data-filter=".<?php echo esc_attr( $filter_attribute ); ?>"><?php echo esc_html( $filter ); ?></button></li>
                                    <?php endforeach; ?>
                                </ul>
                                <?php do_action( 'exad_demo_previewer_filter_wrapper_after' ); ?>
                            </div>
                        <?php } ?>
                        <?php if( 'yes' === $settings['exad_demo_previewer_enable_search'] ) { ?>
                            <div class="exad-demo-previewer-search">
                                <input id="exad-demo-previewer-search-input" type="text" placeholder="<?php echo esc_attr( $settings['exad_demo_previewer_search_placeholder_text'] ); ?>">
                                <div class="exad-demo-previewer-search-icon">
                                    <svg width="19" height="19" viewBox="0 0 19 19" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M3.075 3.075a7.5 7.5 0 0110.95 10.241l3.9 3.902a.5.5 0 01-.707.707l-3.9-3.901A7.5 7.5 0 013.074 3.075zm.707.707a6.5 6.5 0 109.193 9.193 6.5 6.5 0 00-9.193-9.193z" fill="#46D39A" fill-rule="nonzero"/>
                                    </svg>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                <?php endif; ?>

                <div id ="filters-<?php echo $this->get_id(); ?>" class="exad-demo-previewer-element" data-button=<?php echo $settings['exad_demo_previewer_load_more_button']; ?>
                <?php if( 'yes' === $settings['exad_demo_previewer_load_more_button'] ){ ?>
                    data-button_text="<?php echo $settings['exad_demo_previewer_load_more_button_text']; ?>"
                    data-number_item="<?php echo $settings['exad_demo_previewer_item_show']; ?>"
                <?php } ?> >
                <?php
                    foreach( $settings['exad_demo_previewer_items'] as $index => $gallery ) :
                        $exad_controls                = $gallery['exad_demo_previewer_control_name'];
                        $exad_controls_to_array       = explode( ",",$exad_controls );
                        $exad_controls_to_lowercase   = array_map( 'strtolower', $exad_controls_to_array );
                        $exad_controls_remove_space   = array_filter( array_map( 'trim', $exad_controls_to_lowercase ) );
                        $exad_controls_space_replaced = array_map( function($val) { return str_replace( ' ', '-', $val ); }, $exad_controls_remove_space );
                        $exad_control                 = implode ( " ", $exad_controls_space_replaced );

                        $exad_filters                = $gallery['exad_demo_previewer_filter_name'];
                        $exad_filters_to_array       = explode( ",",$exad_filters );
                        $exad_filters_to_lowercase   = array_map( 'strtolower', $exad_filters_to_array );
                        $exad_filters_remove_space   = array_filter( array_map( 'trim', $exad_filters_to_lowercase ) );
                        $exad_filters_space_replaced = array_map( function($val) { return str_replace( ' ', '-', $val ); }, $exad_filters_remove_space );
                        $exad_filter                 = implode ( " ", $exad_filters_space_replaced );

                        $title                       = $gallery['exad_demo_previewer_item_title'];
                        $content                     = $gallery['exad_demo_previewer_item_description'];

                        do_action( 'exad_demo_previewer_item_wrapper_before' ); ?>

                        <div class="exad-demo-previewer-item <?php echo esc_attr( $exad_control ). ' '.esc_attr( $exad_filter ). ' '.esc_attr( $settings['exad_demo_previewer_columns'] ).' elementor-repeater-item-'.$gallery['_id']; ?>">
                            <div class="exad-demo-previewer-content-wrapper">
								<div class="exad-demo-previewer-image">
                                <?php
                                    $target = $gallery['exad_demo_previewer_item_title_url']['is_external'] ? ' target="_blank"' : '';
                                    $nofollow = $gallery['exad_demo_previewer_item_title_url']['nofollow'] ? ' rel="nofollow"' : ''; 
                                    ?>
                                    <figure class="exad-demo-previewer-scroll-image">
                                    <?php
                                        if ( !empty( $gallery['exad_demo_previewer_scroll_image']['url'] ) ) { 
                                            echo Group_Control_Image_Size::get_attachment_image_html( $gallery, 'demo_previewer_scroll_image_size', 'exad_demo_previewer_scroll_image' );
                                        }
                                    ?>
                                    </figure>

                                    <figure class="exad-demo-previewer-cover-image">
                                    <?php
                                        if ( !empty( $gallery['exad_demo_previewer_cover_image']['url'] ) ) {
                                            echo Group_Control_Image_Size::get_attachment_image_html( $gallery, 'demo_previewer_cover_image_size', 'exad_demo_previewer_cover_image' );
                                        }
                                    ?>
                                    </figure>
								</div>
								<div class="exad-demo-previewer-item-content-wrapper">
                                    <div class="exad-demo-previewer-item-content-inner <?php echo $gallery['exad_demo_previewer_enable_content_btn']; ?>">
                                        <div class="exad-demo-previewer-item-content">
                                        <?php
                                            if( !empty( $gallery['exad_demo_previewer_item_title'] ) ) { ?>
                                                <<?php echo Utils::validate_html_tag( $settings['exad_demo_previewer_title_tag'] ); ?> class="exad-demo-previewer-item-content-title">
                                                    <a href="<?php echo $gallery['exad_demo_previewer_item_title_url']['url']; ?>"<?php echo  $target . $nofollow; ?>>
                                                        <?php echo $gallery['exad_demo_previewer_item_title']; ?>
                                                    </a>
                                                </<?php echo Utils::validate_html_tag( $settings['exad_demo_previewer_title_tag'] ); ?>>
                                            <?php }
                                            if( !empty( $gallery['exad_demo_previewer_item_description'] ) ) { ?>
                                                <p class="exad-demo-previewer-item-content-description"><?php echo $gallery['exad_demo_previewer_item_description']; ?></p>
                                            <?php } ?>    
                                        </div>
                                        <?php
                                        if( 'yes' === $gallery['exad_demo_previewer_enable_content_btn'] ) :
                                            $target_btn = $gallery['exad_demo_previewer_item_content_button_url']['is_external'] ? ' target="_blank"' : '';
                                            $nofollow_btn = $gallery['exad_demo_previewer_item_content_button_url']['nofollow'] ? ' rel="nofollow"' : '';
                                        ?>
                                            <a class="exad-demo-previewer-item-content-button" href="<?php echo $gallery['exad_demo_previewer_item_content_button_url']['url']; ?>" <?php echo $target_btn . $nofollow_btn; ?>>
                                                <span>
                                                    <?php Icons_Manager::render_icon( $gallery['exad_demo_previewer_item_content_button_icon'] ); ?>
                                                </span>
                                            <?php echo esc_html( $gallery['exad_demo_previewer_item_content_button_text'] ); ?>
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                    <?php
                                    if( 'yes' === $gallery['exad_demo_previewer_enable_tag'] || 'yes' === $gallery['exad_demo_previewer_enable_label'] ) { ?>
                                        <div class="exad-demo-previewer-item-date">
                                            <?php
                                            if( 'yes' === $gallery['exad_demo_previewer_enable_tag'] ) { ?>
                                                <div class="exad-demo-previewer-tag">
                                                    <ul>
                                                    <?php
                                                        $exad_tags = $gallery['exad_demo_previewer_tag_list'];
                                                        $exad_tags_array       = explode( ",",$exad_tags );
                                                        $exad_tags_remove_space   = array_filter( array_map( 'trim', $exad_tags_array ) );
                                                        foreach($exad_tags_remove_space as $tags) { ?>
                                                            <li><?php echo $tags; ?></li>
                                                        <?php } ?>
                                                    </ul>
                                                </div>
                                            <?php
                                            }

                                            if( 'yes' === $gallery['exad_demo_previewer_enable_label'] ) { ?>
                                                <div class="exad-demo-previewer-label">
                                                    <span class="exad-demo-previewer-label-text"><?php echo esc_html( $gallery['exad_demo_previewer_label_list'] ); ?></span>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    <?php } ?>
								</div>
                            </div>
                        </div>
                        <?php do_action('exad_demo_previewer_item_wrapper_after');
                    endforeach;
                    ?>

                </div>
            </div>
        </div>
        <?php do_action('exad_demo_previewer_wrapper_after');

        if (\Elementor\Plugin::instance()->editor->is_edit_mode()) {
            $this->render_editor_script();
        }
	}

	private function render_editor_script()
        { ?>
        <script type="text/javascript">
            ( function($) {
                if ( $.isFunction( $.fn.isotope ) ) {
                    $( "#exad-demo-previewer-id-<?php echo $this->get_id(); ?>" ).each( function() {
                        var $container  = $( this ).find( '.exad-demo-previewer-element' );
                        var carouselNav = $container.attr( 'id' );
                        
                        var galleryItem = '#' + $(this).attr( 'id' );
                        $container.isotope( {
                            filter: '*',
                            animationOptions: {
                                queue: true
                            }
                        } );

                        $container.imagesLoaded( function() {
                            $container.isotope('layout');
                        });

                        $( galleryItem + ' .exad-demo-previewer-menu button' ).click(function(){
                            $( galleryItem + ' .exad-demo-previewer-menu button.current' ).removeClass( 'current' );
                            $(this).addClass('current');
                     
                            var selector = $(this).attr( 'data-filter' );
                            $container.isotope( {
                                filter: selector,
                                animationOptions: {
                                    queue: true
                                }
                            } );
                            return false;
                        } );

                        var filterWrapper = $( this ).find(".exad-demo-previewer-dropdown-filter-wrapper");
                        var defalutFilter = $( this ).find(".exad-demo-previewer-dropdown-filter-default");
                        var selectFilterList = $( this ).find(".exad-demo-previewer-dropdown-filter-select li");
                        var defaultFilterList = $( this ).find(".exad-demo-previewer-dropdown-filter-default li");

                        $( this ).find(".exad-demo-previewer-dropdown-filter-default").on( 'click', function(){
                            filterWrapper.toggleClass("active");
                        });
                        
                        $( galleryItem + ".exad-demo-previewer-dropdown-filter-select li" ).click(function(){
                            var currentele = $(this).html();
                            $( galleryItem + ".exad-demo-previewer-dropdown-filter-default" ).html(currentele);
                            $( galleryItem +".exad-demo-previewer-dropdown-filter-wrapper" ).removeClass("active");
                        });

                        var loadButton = $container.data('button');

                        if( loadButton === 'yes' ){
                            
                            //****************************
                            // Isotope Load more button
                            //****************************
                            var numberCount = $container.data('number_item');
                            var buttonText = $container.data('button_text');
    
                            var initShow = numberCount; //number of items loaded on init & onclick load more button
                            var counter = initShow; //counter for load more button
                            var iso = $container.data('isotope'); // get Isotope instance
    
                            loadMore(initShow); //execute function onload

                            //append load more button
                            $container.after('<div class="exad-demo-previewer-load-more-wrapper"><a href="#" id="exad-demo-previewer-load-more-button">'+ buttonText +'</a></div>');
                            
                            var buttonClass  = $( this ).find( '#exad-demo-previewer-load-more-button' );
    
                            function loadMore(toShow) {
                                $container.find(".hidden").removeClass("hidden");
    
                                var hiddenElems = iso.filteredItems.slice(toShow, iso.filteredItems.length).map(function(item) {
                                    return item.element;
                                });
                                
                                $(hiddenElems).addClass('hidden');
                                $container.isotope('layout');
    
                                //when no more to load, hide show more button
                                if (hiddenElems.length == 0) {
                                    jQuery(buttonClass).hide();
                                } else {
                                    jQuery(buttonClass).show();
                                };
    
                            }
    
                            //when load more button clicked
                            $(buttonClass).click(function() {
                                if ($('.filter-item').data('clicked')) {
                                //when filter button clicked, set initial value for counter
                                    counter = initShow;
                                    $('.filter-item').data('clicked', false);
                                } else {
                                    counter = counter;
                                };
    
                                counter = counter + initShow;
    
                                loadMore(counter);
                            });
    
                            //when filter button clicked
                            $(".filter-item").click(function() {
                                $(this).data('clicked', true);
    
                                loadMore(initShow);
                            });
                        }

                    } );
                }
            })(jQuery);
        </script>
    <?php
    }

}