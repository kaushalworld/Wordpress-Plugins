<?php
namespace ExclusiveAddons\Elements;

if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.

use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Image_Size;
use \ExclusiveAddons\Pro\Elementor\ProHelper;
use \Elementor\Widget_Base;
use \Elementor\Group_Control_Background;
use \Elementor\Group_Control_Typography;
use \Elementor\Group_Control_Border;
use \Elementor\Group_Control_Box_Shadow;

class Woo_Category extends Widget_Base {

	public function get_name() {
		return 'exad-woo-category';
	}

	public function get_title() {
		return esc_html__( 'Woo category', 'exclusive-addons-elementor-pro' );
	}

	public function get_icon() {
		return 'exad exad-logo exad-woo-category';
	}

	public function get_categories() {
		return [ 'exclusive-addons-elementor' ];
	}

	public function get_script_depends() {
		return [ 'exad-slick' ];
	}

    protected function register_controls() {

        $exad_primary_color   = get_option( 'exad_primary_color_option', '#7a56ff' );

        $this->start_controls_section(
            'exad_woo_product_cat_query_section',
            [
                'label' => esc_html__( 'Query', 'exclusive-addons-elementor-pro' )
            ]
        );

        $this->add_control(
            'exad_woo_product_cat_content_type',
            [
                'label'      => esc_html__( 'Content Type', 'exclusive-addons-elementor-pro' ),
                'type'       => Controls_Manager::SELECT,
                'default'    => 'grid',
                'options'    => [
                    'grid'   => esc_html__( 'Grid', 'exclusive-addons-elementor-pro' ),
                    'slider' => esc_html__( 'Slider',   'exclusive-addons-elementor-pro' )
                ]
            ]
        );

        $this->add_control(
			'exad_woo_product_cat_subtitle',
			[
				'label' => __( 'Subtitle', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Collection', 'exclusive-addons-elementor-pro' ),
			]
		);

        $grid_column_per_view = range( 1, 6 );
        $grid_column_per_view = array_combine( $grid_column_per_view, $grid_column_per_view );

        $this->add_control(
            'exad_woo_product_cat_grid_column_no',
            [
                'label'     => __( 'Number of Columns', 'exclusive-addons-elementor-pro' ),
                'type'      => Controls_Manager::SELECT,
                'default'   => '3',
                'options'   => $grid_column_per_view,
                'condition' => [
                    'exad_woo_product_cat_content_type' => 'grid'
                ]
            ]
        );

        $this->add_control(
            'exad_woo_product_cat_items_to_show',
            [
                'label'       => __( 'Number of Category to Show.', 'exclusive-addons-elementor-pro' ),
                'type'        => Controls_Manager::NUMBER,
                'default'     => 0,
                'min'         => 0,
                'step'        => 1,
                'description' => esc_html__( 'Default 0. It will show all the category items.', 'exclusive-addons-elementor-pro' )
            ]
        );

        $this->add_control(
            'exad_woo_product_include_categories',
            [
                'label'       => esc_html__( 'Include Specific Category', 'exclusive-addons-elementor-pro' ),
                'label_block' => true,
                'type'        => Controls_Manager::SELECT2,
                'options'     => ProHelper::exad_woo_product_categories_fetch( 'product' ),
                'multiple'    => true
            ]
        );

        $this->add_control(
            'exad_woo_product_exclude_categories',
            [
                'label'       => esc_html__( 'Exclude Specific Category', 'exclusive-addons-elementor-pro' ),
                'label_block' => true,
                'type'        => Controls_Manager::SELECT2,
                'options'     => ProHelper::exad_woo_product_categories_fetch( 'product' ),
                'multiple'    => true,
                'description' => esc_html__( 'Either use exclude or include, don\'t use both together.', 'exclusive-addons-elementor-pro' )
            ]
        );

        $this->add_control(
            'exad_woo_product_cat_order_by',
            [
                'type'    => Controls_Manager::SELECT,
                'label'   => esc_html__( 'Order by', 'exclusive-addons-elementor-pro' ),
                'default' => 'name',
                'options' => [
                    'name'       => esc_html__('Name', 'exclusive-addons-elementor-pro' ),
                    'id'         => esc_html__('ID', 'exclusive-addons-elementor-pro' ),
                    'count'      => esc_html__('Count', 'exclusive-addons-elementor-pro' ),
                    'slug'       => esc_html__('Slug', 'exclusive-addons-elementor-pro' ),
                    'term_group' => esc_html__('Term Group', 'exclusive-addons-elementor-pro' ),
                    'none'       => esc_html__('None', 'exclusive-addons-elementor-pro' )
                ]
            ]
        );

        $this->add_control(
            'exad_woo_product_cat_order',
            [
                'type'          => Controls_Manager::SELECT,
                'label'         => esc_html__( 'Order', 'exclusive-addons-elementor-pro' ),
                'default'       => 'DESC',
                'options'       => [
                    'ASC'       => esc_html__( 'Ascending', 'exclusive-addons-elementor-pro' ),
                    'DESC'      => esc_html__( 'Descending', 'exclusive-addons-elementor-pro' )
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
                'name'          => 'image_size',
                'default'       => 'medium_large'
            ]
        );

        $this->add_control(
            'exad_woo_product_cat_enable_parent_cat_icon',
            [
                'type'          => Controls_Manager::SWITCHER,
                'label'         => esc_html__( 'Enable Parent Cat Icon?', 'exclusive-addons-elementor-pro' ),
                'default'       => 'yes',
                'return_value'  => 'yes'
            ]
        );

        $this->add_control(
            'exad_woo_product_cat_enable_parent_only',
            [
                'type'          => Controls_Manager::SWITCHER,
                'label'         => esc_html__( 'Enable Only Top Level Category?', 'exclusive-addons-elementor-pro' ),
                'default'       => 'yes',
                'return_value'  => 'yes',
                'description'  => esc_html__( 'By enabling this option, only top level category will show.', 'exclusive-addons-elementor-pro' )
            ]
        );

        $this->add_control(
            'exad_woo_product_cat_hide_empty_cat',
            [
                'type'         => Controls_Manager::SWITCHER,
                'label'        => esc_html__( 'Hide Empty Cat?', 'exclusive-addons-elementor-pro' ),
                'default'      => 'yes',
                'return_value' => 'yes'
            ]
        );

        $this->add_control(
            'exad_woo_product_cat_hide_empty_child_cat',
            [
                'type'         => Controls_Manager::SWITCHER,
                'label'        => esc_html__( 'Hide Empty Child Cat?', 'exclusive-addons-elementor-pro' ),
                'default'      => 'yes',
                'return_value' => 'yes'
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'exad_woo_product_cat_container_style',
            [
                'label'     => __( 'Container', 'exclusive-addons-elementor-pro' ),
                'tab'       => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'exad_woo_product_cat_item_overlay',
            [
                'type'         => Controls_Manager::SWITCHER,
                'label'        => esc_html__( 'Overlay', 'exclusive-addons-elementor-pro' ),
                'default'      => 'yes',
                'return_value' => 'yes',
                'render_type'  => 'template',
                'prefix_class' => 'exad-woo-product-cat-item-overlay-'
            ]
        );

        $this->add_control(
            'exad_woo_product_cat_item_overlay_background',
            [
                'label'     => esc_html__( 'Overlay background Color', 'exclusive-addons-elementor-pro' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => 'rgba(0, 0, 0, .5)',
                'selectors' => [
                    '{{WRAPPER}} .exad-wc-cat-link.exad-woo-product-cat-item-overlay-yes::before' => 'background: {{VALUE}};'
                ],
                'condition' => [
                    'exad_woo_product_cat_item_overlay' => 'yes'
                ]
            ]
        );

        $this->add_control(
			'exad_woo_product_cat_item_image_hover_animation',
			[
				'label' => __( 'Image Hover Animation', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'none',
				'options' => [
					'none'  => __( 'None', 'exclusive-addons-elementor-pro' ),
					'zoom-in'  => __( 'Zoom In', 'exclusive-addons-elementor-pro' ),
					'zoom-out'  => __( 'Zoom Out', 'exclusive-addons-elementor-pro' ),
				],
			]
        );

        $this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'exad_woo_product_cat_container_border',
				'label' => __( 'Border', 'exclusive-addons-elementor-pro' ),
				'selector' => '{{WRAPPER}} .exad-single-product-cat .exad-woo-cat-item',
			]
        );
        
        $this->add_control(
			'exad_woo_product_cat_container_border_radius',
			[
				'label' => __( 'Border radius', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'default' => [
                    'top' => '0',
                    'right' => '0',
                    'bottom' => '0',
                    'left' => '0',
                    'unit' => 'px',
                    'isLinked' => true,
                ],
				'selectors' => [
					'{{WRAPPER}} .exad-single-product-cat .exad-woo-cat-item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .exad-single-product-cat' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
			]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'exad_woo_product_cat_content_style',
            [
                'label'     => __( 'Content', 'exclusive-addons-elementor-pro' ),
                'tab'       => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
			'exad_woo_product_cat_content_position',
			[
				'label' => __( 'Content Position', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'default',
				'options' => [
					'default'  => __( 'Default', 'exclusive-addons-elementor-pro' ),
					'absolute'  => __( 'Absolute', 'exclusive-addons-elementor-pro' ),
				],
			]
		);

        $this->add_control(
			'exad_woo_product_cat_content_alignment',
			[
				'label' => __( 'Alignment', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::CHOOSE,
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
				'default' => 'left',
                'toggle' => true,
                'selectors' => [
                    '{{WRAPPER}} .exad-woo-product-cat-items .exad-woo-cat-item a.exad-cat-btn.absolute' => 'text-align: {{VALUE}};',
                    '{{WRAPPER}} .exad-woo-product-cat-items .exad-woo-cat-item a.exad-cat-btn.default' => 'text-align: {{VALUE}};',
                ]
			]
        );
        
        $this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'exad_woo_product_cat_content_backgroung',
				'label' => __( 'Background', 'exclusive-addons-elementor-pro' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .exad-woo-product-cat-items .exad-woo-cat-item a.exad-cat-btn',
			]
        );
        
        $this->add_control(
			'exad_woo_product_cat_content_padding',
			[
				'label' => __( 'Padding', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'default' => [
                    'top' => '12',
                    'right' => '25',
                    'bottom' => '12',
                    'left' => '25',
                    'unit' => 'px',
                    'isLinked' => false,
                ],
				'selectors' => [
					'{{WRAPPER}} .exad-woo-product-cat-items .exad-woo-cat-item a.exad-cat-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
			]
        );
        
        $this->add_control(
			'exad_woo_product_cat_content_margin',
			[
				'label' => __( 'Margin', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'default' => [
                    'top' => '0',
                    'right' => '0',
                    'bottom' => '0',
                    'left' => '0',
                    'unit' => 'px',
                    'isLinked' => true,
                ],
				'selectors' => [
					'{{WRAPPER}} .exad-woo-product-cat-items .exad-woo-cat-item a.exad-cat-btn.absolute' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition' => [
                    'exad_woo_product_cat_content_position' => 'absolute'
                ]
			]
        );

        $this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'exad_woo_product_cat_content_border',
				'label' => __( 'Border', 'exclusive-addons-elementor-pro' ),
				'selector' => '{{WRAPPER}} .exad-woo-product-cat-items .exad-woo-cat-item a.exad-cat-btn',
			]
		);

        $this->add_control(
			'exad_woo_product_cat_content_radius',
			[
				'label' => __( 'Border radius', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'default' => [
                    'top' => '0',
                    'right' => '0',
                    'bottom' => '0',
                    'left' => '0',
                    'unit' => 'px',
                    'isLinked' => true,
                ],
				'selectors' => [
					'{{WRAPPER}} .exad-woo-product-cat-items .exad-woo-cat-item a.exad-cat-btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
			]
        );

        $this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'exad_woo_product_cat_content_shadow',
				'label' => __( 'Box Shadow', 'exclusive-addons-elementor-pro' ),
				'selector' => '{{WRAPPER}} .exad-woo-product-cat-items .exad-woo-cat-item a.exad-cat-btn',
			]
        );
        
        $this->add_control(
			'exad_woo_product_cat_content_category',
			[
				'label' => __( 'Category', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
        );
        
        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'exad_woo_product_cat_content_category_typography',
				'label' => __( 'Typography', 'exclusive-addons-elementor-pro' ),
				'selector' => '{{WRAPPER}} .exad-woo-product-cat-items .exad-woo-cat-item a.exad-cat-btn',
			]
        );
        
        $this->add_control(
			'exad_woo_product_cat_content_category_color',
			[
				'label' => __( 'Title Color', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#000000',
				'selectors' => [
					'{{WRAPPER}} .exad-woo-product-cat-items .exad-woo-cat-item a.exad-cat-btn' => 'color: {{VALUE}}',
				],
			]
        );

        $this->add_control(
			'exad_woo_product_cat_content_subtitle',
			[
				'label' => __( 'Subtitle', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
        );
        
        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'exad_woo_product_cat_content_subtitle_typography',
				'label' => __( 'Typography', 'exclusive-addons-elementor-pro' ),
				'selector' => '{{WRAPPER}} .exad-woo-product-sub-cat',
			]
        );
        
        $this->add_control(
			'exad_woo_product_cat_content_subtitle_color',
			[
				'label' => __( 'Title Color', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#000000',
				'selectors' => [
					'{{WRAPPER}} .exad-woo-product-sub-cat' => 'color: {{VALUE}}',
				],
			]
        );

        $this->add_control(
			'exad_woo_product_cat_content_subtitle_margin',
			[
				'label' => __( 'Margin', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'default' => [
                    'top' => '0',
                    'right' => '0',
                    'bottom' => '0',
                    'left' => '0',
                    'unit' => 'px',
                    'isLinked' => true,
                ],
				'selectors' => [
					'{{WRAPPER}} .exad-woo-product-sub-cat' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
			]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'exad_woo_product_cat_carousel_each_item_style',
            [
                'label'     => __( 'Item', 'exclusive-addons-elementor-pro' ),
                'tab'       => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'exad_woo_product_cat_content_image_height',
            [
                'label'         => esc_html__('Image Height', 'exclusive-addons-elementor-pro' ),
                'type'          => Controls_Manager::SLIDER,
                'selectors'     => [
                    '{{WRAPPER}} .exad-woo-product-cat-items .exad-woo-cat-item .exad-wc-cat-link' => 'height: {{SIZE}}{{UNIT}};'
                ],                
                'range'         => [
                    'px'        => [
                        'min'   => 0,
                        'max'   => 1000,
                        'step'  => 1
                    ]
                ]
            ]
        );

        $this->add_control(
            'exad_woo_product_cat_carousel_each_item_spacing_type',
            [
                'label'       => __( 'Spacing', 'exclusive-addons-elementor-pro' ),
                'type'        => Controls_Manager::SELECT,
                'default'     => 'default',
                'options'     => [
                    'default' => esc_html__( 'Default', 'exclusive-addons-elementor-pro' ),
                    'custom'  => esc_html__( 'Custom', 'exclusive-addons-elementor-pro' )
                ],
                'condition' => [
                    'exad_woo_product_cat_content_type' => 'grid'
                ]
            ]
        );

        $grid_row_margin     = is_rtl() ? '0 0 -{{SIZE}}{{UNIT}} -{{SIZE}}{{UNIT}};' : '0 -{{SIZE}}{{UNIT}} -{{SIZE}}{{UNIT}} 0;';
        $grid_column_padding = is_rtl() ? '0 0 {{SIZE}}{{UNIT}} {{SIZE}}{{UNIT}};' : '0 {{SIZE}}{{UNIT}} {{SIZE}}{{UNIT}} 0;';

        $this->add_control(
            'exad_woo_product_cat_carousel_each_item_custom_spacing',
            [
                'label'        => esc_html__('Custom Spacing', 'exclusive-addons-elementor-pro' ),
                'type'         => Controls_Manager::SLIDER,
                'show_label'   => false,
                'default'      => [
                    'size'     => 20,
                    'unit'     => 'px'
                ],  
                'selectors'    => [
                    '{{WRAPPER}} .exad-element-row-grid'                => 'margin: ' . $grid_row_margin,
                    '{{WRAPPER}} .exad-element-row-grid .exad-col-grid' => 'padding:' . $grid_column_padding
                ],              
                'range'        => [
                    'px'       => [
                        'min'  => 0,
                        'max'  => 100,
                        'step' => 1
                    ]
                ],
                'condition'    => [
                    'exad_woo_product_cat_carousel_each_item_spacing_type' => 'custom',
                    'exad_woo_product_cat_content_type'                    => 'grid'
                ]
            ]
        ); 

        $this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'exad_woo_product_cat_item_border',
				'label' => __( 'Border', 'exclusive-addons-elementor-pro' ),
				'selector' => '{{WRAPPER}} .exad-wc-cat-link',
			]
		);

        $this->add_control(
			'exad_woo_product_cat_item_radius',
			[
				'label' => __( 'Border Radius', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'default' => [
                    'top' => '0',
                    'right' => '0',
                    'bottom' => '0',
                    'left' => '0',
                    'unit' => 'px',
                    'isLinked' => true,
                ],
				'selectors' => [
					'{{WRAPPER}} .exad-wc-cat-link' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
			]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'exad_woo_product_cat_carousel_settings',
            [
                'label'     => esc_html__( 'Carousel Settings', 'exclusive-addons-elementor-pro' ),
                'condition' => [
                    'exad_woo_product_cat_content_type' => 'slider'
                ]
            ]
        );

        $this->add_control(
            'exad_woo_product_cat_carousel_nav',
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

        $this->add_control(
            'exad_woo_product_cat_carousel_per_view',
            [
                'label'   => __( 'Columns', 'exclusive-addons-elementor-pro' ),
                'type'    => Controls_Manager::SELECT,
                'default' => '3',
                'options' => $slides_per_view
            ]
        );

        $this->add_control(
            'exad_woo_product_cat_carousel_slides_to_scroll',
            [
                'type'    => Controls_Manager::SELECT,
                'label'   => esc_html__( 'Items to Scroll', 'exclusive-addons-elementor-pro' ),
                'options' => $slides_per_view,
                'default' => '1'
            ]
        );

        $this->add_control(
            'exad_woo_product_cat_carousel_transition_duration',
            [
                'label'   => esc_html__( 'Transition Duration', 'exclusive-addons-elementor-pro' ),
                'type'    => Controls_Manager::NUMBER,
                'default' => 1000
            ]
        );

        $this->add_control(
            'exad_woo_product_cat_carousel_autoplay',
            [
                'label'     => esc_html__( 'Autoplay', 'exclusive-addons-elementor-pro' ),
                'type'      => Controls_Manager::SWITCHER,
                'default'   => 'no'
            ]
        );

        $this->add_control(
            'exad_woo_product_cat_carousel_autoplay_speed',
            [
                'label'     => esc_html__( 'Autoplay Speed', 'exclusive-addons-elementor-pro' ),
                'type'      => Controls_Manager::NUMBER,
                'default'   => 5000,
                'condition' => [
                    'exad_woo_product_cat_carousel_autoplay' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'exad_woo_product_cat_carousel_loop',
            [
                'label'   => esc_html__( 'Infinite Loop', 'exclusive-addons-elementor-pro' ),
                'type'    => Controls_Manager::SWITCHER,
                'default' => 'yes'
            ]
        );

        $this->add_control(
            'exad_woo_product_cat_carousel_pause',
            [
                'label'     => esc_html__( 'Pause on Hover', 'exclusive-addons-elementor-pro' ),
                'type'      => Controls_Manager::SWITCHER,
                'default'   => 'yes',
                'condition' => [
                    'exad_woo_product_cat_carousel_autoplay' => 'yes'
                ]
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'exad_woo_product_cat_carousel_carousel_nav_arrow',
            [
                'label'     => esc_html__( 'Arrows', 'exclusive-addons-elementor-pro' ),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'exad_woo_product_cat_carousel_nav' => ['arrows', 'both'],
                    'exad_woo_product_cat_content_type' => 'slider',
                ],
            ]
        );

        $this->add_control(
            'exad_woo_product_cat_carousel_carousel_nav_arrow_box_size',
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
                    '{{WRAPPER}} .exad-woo-product-cat-items .exad-carousel-nav-prev' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .exad-woo-product-cat-items .exad-carousel-nav-next' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'exad_woo_product_cat_carousel_carousel_nav_arrow_icon_size',
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
                    '{{WRAPPER}} .exad-woo-product-cat-items .exad-carousel-nav-prev i' => 'font-size: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .exad-woo-product-cat-items .exad-carousel-nav-next i' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        
        $this->add_control(
            'exad_woo_product_cat_carousel_carousel_prev_arrow_position',
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

            $this->add_control(
                'exad_woo_product_cat_carousel_carousel_prev_arrow_position_x_offset',
                [
                    'label'      => __( 'X Offset', 'exclusive-addons-elementor-pro' ),
                    'type'       => Controls_Manager::SLIDER,
                    'size_units' => ['px', '%'],
                    'range'      => [
                        'px' => [
                            'min' => -500,
                            'max' => 500,
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
                        '{{WRAPPER}} .exad-woo-product-cat-items .exad-carousel-nav-prev' => 'left: {{SIZE}}{{UNIT}};',
                    ],
                ]
            );

            $this->add_control(
                'exad_woo_product_cat_carousel_carousel_prev_arrow_position_y_offset',
                [
                    'label'      => __( 'Y Offset', 'exclusive-addons-elementor-pro' ),
                    'type'       => Controls_Manager::SLIDER,
                    'size_units' => ['px', '%'],
                    'range'      => [
                        'px' => [
                            'min' => -500,
                            'max' => 500,
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
                        '{{WRAPPER}} .exad-woo-product-cat-items .exad-carousel-nav-prev' => 'top: {{SIZE}}{{UNIT}};',
                    ],
                ]
            );

        $this->end_popover();

        $this->add_control(
            'exad_woo_product_cat_carousel_carousel_next_arrow_position',
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

            $this->add_control(
                'exad_woo_product_cat_carousel_carousel_next_arrow_position_x_offset',
                [
                    'label'      => __( 'X Offset', 'exclusive-addons-elementor-pro' ),
                    'type'       => Controls_Manager::SLIDER,
                    'size_units' => ['px', '%'],
                    'range'      => [
                        'px' => [
                            'min' => -500,
                            'max' => 500,
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
                        '{{WRAPPER}} .exad-woo-product-cat-items .exad-carousel-nav-next' => 'right: {{SIZE}}{{UNIT}};',
                    ],
                ]
            );

            $this->add_control(
                'exad_woo_product_cat_carousel_carousel_next_arrow_position_y_offset',
                [
                    'label'      => __( 'Y Offset', 'exclusive-addons-elementor-pro' ),
                    'type'       => Controls_Manager::SLIDER,
                    'size_units' => ['px', '%'],
                    'range'      => [
                        'px' => [
                            'min' => -500,
                            'max' => 500,
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
                        '{{WRAPPER}} .exad-woo-product-cat-items .exad-carousel-nav-next' => 'top: {{SIZE}}{{UNIT}};',
                    ],
                ]
            );

        $this->end_popover();

        $this->add_control(
            'exad_woo_product_cat_carousel_carousel_nav_arrow_radius',
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
                    '{{WRAPPER}} .exad-woo-product-cat-items .exad-carousel-nav-prev' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .exad-woo-product-cat-items .exad-carousel-nav-next' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs( 'exad_woo_product_cat_carousel_carousel_nav_arrow_tabs' );

			// normal state rating
			$this->start_controls_tab( 'exad_woo_product_cat_carousel_carousel_nav_arrow_normal', [ 'label' => esc_html__( 'Normal', 'exclusive-addons-elementor-pro' ) ] );

                $this->add_control(
                    'exad_woo_product_cat_carousel_carousel_arrow_normal_background',
                    [
                        'label'     => __( 'Background Color', 'exclusive-addons-elementor-pro' ),
                        'type'      => Controls_Manager::COLOR,
                        'default'   => '#ffffff',
                        'selectors' => [
                            '{{WRAPPER}} .exad-woo-product-cat-items .exad-carousel-nav-prev' => 'background: {{VALUE}}',
                            '{{WRAPPER}} .exad-woo-product-cat-items .exad-carousel-nav-next' => 'background: {{VALUE}}',
                        ],
                    ]
                );

                $this->add_control(
                    'exad_woo_product_cat_carousel_carousel_arrow_normal_color',
                    [
                        'label'     => __( 'Icon Color', 'exclusive-addons-elementor-pro' ),
                        'type'      => Controls_Manager::COLOR,
                        'default'   => $exad_primary_color,
                        'selectors' => [
                            '{{WRAPPER}} .exad-woo-product-cat-items .exad-carousel-nav-prev i' => 'color: {{VALUE}};',
                            '{{WRAPPER}} .exad-woo-product-cat-items .exad-carousel-nav-next i' => 'color: {{VALUE}};',
                        ],
                    ]
                );

                $this->add_group_control(
                    Group_Control_Border::get_type(),
                    [
                        'name'     => 'exad_woo_product_cat_carousel_carousel_arrow_normal_border',
                        'label'    => __( 'Border', 'exclusive-addons-elementor-pro' ),
                        'selector' => '{{WRAPPER}} .exad-woo-product-cat-items .exad-carousel-nav-prev, {{WRAPPER}} .exad-woo-product-cat-items .exad-carousel-nav-next',
                    ]
                );

                $this->add_group_control(
                    Group_Control_Box_Shadow::get_type(),
                    [
                        'name'     => 'exad_woo_product_cat_carousel_carousel_arrow_normal_shadow',
                        'label'    => __( 'Box Shadow', 'exclusive-addons-elementor-pro' ),
                        'selector' => '{{WRAPPER}} .exad-woo-product-cat-items .exad-carousel-nav-prev, {{WRAPPER}} .exad-woo-product-cat-items .exad-carousel-nav-next',
                    ]
                );

			$this->end_controls_tab();

			// hover state rating
			$this->start_controls_tab( 'exad_woo_product_cat_carousel_carousel_nav_arrow_hover', [ 'label' => esc_html__( 'Hover', 'exclusive-addons-elementor-pro' ) ] );

                $this->add_control(
                    'exad_woo_product_cat_carousel_carousel_arrow_hover_background',
                    [
                        'label'     => __( 'Background Color', 'exclusive-addons-elementor-pro' ),
                        'type'      => Controls_Manager::COLOR,
                        'default'   => $exad_primary_color,
                        'selectors' => [
                            '{{WRAPPER}} .exad-woo-product-cat-items .exad-carousel-nav-prev:hover' => 'background: {{VALUE}}',
                            '{{WRAPPER}} .exad-woo-product-cat-items .exad-carousel-nav-next:hover' => 'background: {{VALUE}}',
                        ],
                    ]
                );

                $this->add_control(
                    'exad_woo_product_cat_carousel_carousel_arrow_hover_color',
                    [
                        'label'     => __( 'Icon Color', 'exclusive-addons-elementor-pro' ),
                        'type'      => Controls_Manager::COLOR,
                        'default'   => '#ffffff',
                        'selectors' => [
                            '{{WRAPPER}} .exad-woo-product-cat-items .exad-carousel-nav-prev:hover i' => 'color: {{VALUE}}',
                            '{{WRAPPER}} .exad-woo-product-cat-items .exad-carousel-nav-next:hover i' => 'color: {{VALUE}}',
                        ],
                    ]
                );

                $this->add_group_control(
                    Group_Control_Border::get_type(),
                    [
                        'name'     => 'exad_woo_product_cat_carousel_carousel_arrow_hover_border',
                        'label'    => __( 'Border', 'exclusive-addons-elementor-pro' ),
                        'selector' => '{{WRAPPER}} .exad-woo-product-cat-items .exad-carousel-nav-prev:hover, {{WRAPPER}} .exad-woo-product-cat-items .exad-carousel-nav-next:hover',
                    ]
                );

                $this->add_group_control(
                    Group_Control_Box_Shadow::get_type(),
                    [
                        'name'     => 'exad_woo_product_cat_carousel_carousel_arrow_hover_shadow',
                        'label'    => __( 'Box Shadow', 'exclusive-addons-elementor-pro' ),
                        'selector' => '{{WRAPPER}} .exad-woo-product-cat-items .exad-carousel-nav-prev:hover, {{WRAPPER}} .exad-woo-product-cat-items .exad-carousel-nav-next:hover',
                    ]
                );

			$this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();

        $this->start_controls_section(
            'exad_woo_product_cat_carousel_nav_dot',
            [
                'label'     => esc_html__( 'Dots', 'exclusive-addons-elementor-pro' ),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'exad_woo_product_cat_carousel_nav' => ['dots', 'both'],
                    'exad_woo_product_cat_content_type' => 'slider',
                ],
            ]
        );

        $this->add_control(
            'exad_woo_product_cat_carousel_nav_dot_alignment',
            [
                'label'   => __( 'Alignment', 'exclusive-addons-elementor-pro' ),
                'type'    => Controls_Manager::CHOOSE,
                'options' => [
                    'exad-woo-product-cat-carousel-dots-left'   => [
                        'title' => __( 'Left', 'exclusive-addons-elementor-pro' ),
                        'icon'  => 'fa fa-align-left',
                    ],
                    'exad-woo-product-cat-carousel-dots-center' => [
                        'title' => __( 'Center', 'exclusive-addons-elementor-pro' ),
                        'icon'  => 'fa fa-align-center',
                    ],
                    'exad-woo-product-cat-carousel-dots-right'  => [
                        'title' => __( 'Right', 'exclusive-addons-elementor-pro' ),
                        'icon'  => 'fa fa-align-right',
                    ],
                ],
                'default' => 'exad-woo-product-cat-carousel-dots-center',
            ]
        );

        $this->add_control(
            'exad_woo_product_cat_carousel_dots_top_spacing',
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
                    '{{WRAPPER}} .exad-woo-product-cat-items .slick-dots' => 'margin-top: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'exad_woo_product_cat_carousel_nav_dot_radius',
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
                    '{{WRAPPER}} .exad-woo-product-cat-items .slick-dots li button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs( 'exad_woo_product_cat_carousel_nav_dots_tabs' );

			// normal state rating
            $this->start_controls_tab( 'exad_woo_product_cat_carousel_nav_dots_normal', [ 'label' => esc_html__( 'Normal', 'exclusive-addons-elementor-pro' ) ] );
            
                $this->add_control(
                    'exad_woo_product_cat_carousel_dots_normal_width',
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
                            '{{WRAPPER}} .exad-woo-product-cat-items .slick-dots li button' => 'width: {{SIZE}}{{UNIT}};',
                        ],
                    ]
                );

                $this->add_control(
                    'exad_woo_product_cat_carousel_dots_normal_height',
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
                            '{{WRAPPER}} .exad-woo-product-cat-items .slick-dots li button' => 'height: {{SIZE}}{{UNIT}};',
                        ],
                    ]
                );

                $this->add_control(
                    'exad_woo_product_cat_carousel_dots_normal_background',
                    [
                        'label'     => __( 'Background Color', 'exclusive-addons-elementor-pro' ),
                        'type'      => Controls_Manager::COLOR,
                        'default'   => '#e5e5e5',
                        'selectors' => [
                            '{{WRAPPER}} .exad-woo-product-cat-items .slick-dots li button' => 'background: {{VALUE}};',
                        ],
                    ]
                );

                $this->add_group_control(
                    Group_Control_Border::get_type(),
                    [
                        'name'     => 'exad_woo_product_cat_carousel_dots_normal_border',
                        'label'    => __( 'Border', 'exclusive-addons-elementor-pro' ),
                        'selector' => '{{WRAPPER}} .exad-woo-product-cat-items .slick-dots li button',
                    ]
                );

			$this->end_controls_tab();

			// hover state rating
            $this->start_controls_tab( 'exad_woo_product_cat_carousel_nav_dots_hover', [ 'label' => esc_html__( 'Hover/active', 'exclusive-addons-elementor-pro' ) ] );
            
                $this->add_control(
                    'exad_woo_product_cat_carousel_dots_active_width',
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
                            '{{WRAPPER}} .exad-woo-product-cat-items .slick-dots li.slick-active button' => 'width: {{SIZE}}{{UNIT}};',
                        ],
                    ]
                );

                $this->add_control(
                    'exad_woo_product_cat_carousel_dots_active_height',
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
                            '{{WRAPPER}} .exad-woo-product-cat-items .slick-dots li.slick-active button' => 'height: {{SIZE}}{{UNIT}};',
                        ],
                    ]
                );

                $this->add_control(
                    'exad_woo_product_cat_carousel_dots_active_background',
                    [
                        'label'     => __( 'Background Color', 'exclusive-addons-elementor-pro' ),
                        'type'      => Controls_Manager::COLOR,
                        'default'   => $exad_primary_color,
                        'selectors' => [
                            '{{WRAPPER}} .exad-woo-product-cat-items .slick-dots li.slick-active button' => 'background: {{VALUE}};',
                            '{{WRAPPER}} .exad-woo-product-cat-items .slick-dots li button:hover'        => 'background: {{VALUE}};',
                        ],
                    ]
                );

                $this->add_group_control(
                    Group_Control_Border::get_type(),
                    [
                        'name'     => 'exad_woo_product_cat_carousel_dots_active_border',
                        'label'    => __( 'Border', 'exclusive-addons-elementor-pro' ),
                        'selector' => '{{WRAPPER}} .exad-woo-product-cat-items .slick-dots li.slick-active button, {{WRAPPER}} .exad-woo-product-cat-items .slick-dots li button:hover',
                    ]
                );

			$this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();

    }

    protected function render() {
        $settings         = $this->get_settings_for_display();
        $orderby          = esc_attr( $settings['exad_woo_product_cat_order_by'] );
        $order            = esc_attr( $settings['exad_woo_product_cat_order'] );        
        $hide_empty       = 'yes' === esc_attr( $settings['exad_woo_product_cat_hide_empty_cat'] ) ? 1 : 0;  
        $hide_empty_child = 'yes' === esc_attr( $settings['exad_woo_product_cat_hide_empty_child_cat'] ) ? true : false;  
        $top_level_cats   = 'yes' === esc_attr( $settings['exad_woo_product_cat_enable_parent_only'] ) ? 0 : '';  
        $direction        = is_rtl() ? 'true' : 'false';
        
        $prod_categories = get_terms( 'product_cat', array(
            'orderby'    => $orderby,
            'order'      => $order,
            'hide_empty' => $hide_empty,
            'number'     => $settings['exad_woo_product_cat_items_to_show'],
            'parent'     => $top_level_cats,
            'include'    => $settings['exad_woo_product_include_categories'],
            'exclude'    => $settings['exad_woo_product_exclude_categories']
        ) );

        $this->add_render_attribute(
            'exad_woo_product_cat_wrapper',
            [
                'class' => [
                    'exad-woo-product-cat-items',
                    'exad-element-row-'.esc_attr( $settings['exad_woo_product_cat_content_type'] ),
                    $settings['exad_woo_product_cat_carousel_nav_dot_alignment'],
                ]
            ]
        );

        $this->add_render_attribute(
            'exad_woo_product_single_cat_wrapper',
            [
                'class' => [
                    'exad-single-product-cat',
                    'exad-col-'.esc_attr( $settings['exad_woo_product_cat_content_type'] )
                ]
            ]
        );

        if( 'grid' === $settings['exad_woo_product_cat_content_type'] ) :
            $this->add_render_attribute( 'exad_woo_product_cat_wrapper', 'class', 'exad-col-'.esc_attr( $settings['exad_woo_product_cat_grid_column_no'] ) );
        else :                        
            $this->add_render_attribute(
                'exad_woo_product_cat_wrapper',
                [
                    'class'                => 'exad-woo-product-cat-slider exad-carousel-item exad-slider-gap-default',
                    'data-carousel-nav'    => esc_attr( $settings['exad_woo_product_cat_carousel_nav'] ),
                    'data-carousel-column' => intval( esc_attr( $settings['exad_woo_product_cat_carousel_per_view'] ) ),
                    'data-slidestoscroll'  => intval( esc_attr( $settings['exad_woo_product_cat_carousel_slides_to_scroll'] ) ),
                    'data-carousel-speed'  => esc_attr( $settings['exad_woo_product_cat_carousel_transition_duration'] ),
                    'data-direction'       => esc_attr( $direction )
                ]
            );
            if ( 'yes' === $settings['exad_woo_product_cat_carousel_pause'] ) :
                $this->add_render_attribute( 'exad_woo_product_cat_wrapper', 'data-pauseonhover', 'true' );
            endif;
            if ( 'yes' === $settings['exad_woo_product_cat_carousel_autoplay'] ) :
                $this->add_render_attribute( 'exad_woo_product_cat_wrapper', 'data-autoplay', 'true' );
                $this->add_render_attribute( 'exad_woo_product_cat_wrapper', 'data-autoplayspeed', intval( esc_attr( $settings['exad_woo_product_cat_carousel_autoplay_speed'] ) ) );
            endif;
            if ( 'yes' === $settings['exad_woo_product_cat_carousel_loop'] ) :
                $this->add_render_attribute( 'exad_woo_product_cat_wrapper', 'data-loop', 'true' );
            endif;
        endif;
        if( is_array( $prod_categories ) ) : ?>
            <div <?php echo $this->get_render_attribute_string( 'exad_woo_product_cat_wrapper' ); ?>>
            <?php
                foreach( $prod_categories as $prod_cat ) :
                    $child_cat_args = array(
                        'taxonomy'           => 'product_cat',
                        'hide_empty'         => 0,
                        'child_of'           => $prod_cat->term_id
                    );
                    $cat_thumb_id    = get_term_meta( $prod_cat->term_id, 'thumbnail_id', true );
                    $cat_thumb_url   = wp_get_attachment_thumb_url( $cat_thumb_id );
                    $term_link       = get_term_link( $prod_cat, 'product_cat' );
                    $image           = wp_get_attachment_image_src( $cat_thumb_id, 'medium_large' );
                    $chaid_cat_terms = get_terms( $child_cat_args );
                    $term_meta       = get_option( 'taxonomy_'.$prod_cat->term_id );
                    ?>    
                    <div <?php echo $this->get_render_attribute_string( 'exad_woo_product_single_cat_wrapper' ); ?>>
                        <div class="exad-woo-cat-item">
                            <figure>
                                <a href="<?php echo esc_url( $term_link ); ?>" class="exad-wc-cat-link exad-woo-product-cat-item-overlay-<?php echo $settings['exad_woo_product_cat_item_overlay']; ?> <?php echo $settings['exad_woo_product_cat_item_image_hover_animation']; ?>">
                                    <?php echo wp_get_attachment_image( $cat_thumb_id, $settings['image_size_size'] ); ?>
                                </a>
                                <figcaption>
                                    <a href="<?php echo esc_url( $term_link ); ?>" class="exad-cat-btn <?php echo $settings['exad_woo_product_cat_content_position']; ?>">
                                    <?php if( !empty( $settings['exad_woo_product_cat_subtitle'] ) ) : ?>
                                        <p class="exad-woo-product-sub-cat"><?php echo esc_html($settings['exad_woo_product_cat_subtitle']); ?></p>
                                    <?php endif; ?>
                                    <?php if( 'yes' === $settings['exad_woo_product_cat_enable_parent_cat_icon'] && is_array( $term_meta ) && ! empty( $term_meta['cat_icons'] ) ) : ?>
                                        <i class="<?php echo esc_attr( $term_meta['cat_icons'] ); ?>"></i>
                                    <?php endif; ?>
                                    <?php echo esc_html( $prod_cat->name ).'<span class="exad-woo-cat-item-count">('.esc_html( $prod_cat->count ).')</span> '; ?>
                                    </a>
                                </figcaption>
                            </figure>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    <?php
    }
}