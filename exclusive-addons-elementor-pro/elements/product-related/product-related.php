<?php
namespace ExclusiveAddons\Elements;

if ( !defined( 'ABSPATH' ) ) {
    exit;
}
// If this file is called directly, abort.

use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Border;
use \Elementor\Group_Control_Box_Shadow;
use \Elementor\Group_Control_Typography;
use \Elementor\Group_Control_Background;
use \Elementor\Widget_Base;
use \ExclusiveAddons\Pro\Includes\WooBuilder\Woo_Preview_Data;

class Product_Related extends Widget_Base {

    public function get_name() {
        return 'exad-product-related';
    }

    public function get_title() {
        return esc_html__( 'Product Related', 'exclusive-addons-elementor-pro' );
    }

    public function get_icon() {
        return 'exad exad-logo exad-woo-products';
    }

    public function get_categories() {
        return ['exclusive-addons-elementor'];
    }

    public function get_keywords() {
        return ['product related', 'related product', 'related', 'related grid', 'woo product related carousel', 'woo related carousel'];
    }

    protected function register_controls() {

		$exad_primary_color = get_option( 'exad_primary_color_option', '#7a56ff' );

        if ( !class_exists( 'woocommerce' ) ) {
            $this->start_controls_section(
                'exad_panel_notice',
                [
                    'label' => __( 'Notice!', 'exclusive-addons-elementor-pro' ),
                ]
            );

            $this->add_control(
                'exad_panel_notice_text',
                [
                    'type'            => Controls_Manager::RAW_HTML,
                    'raw'             => __( '<strong>WooCommerce</strong> is not installed/activated on your site. Please install and activate <a href="plugin-install.php?s=wpcf7&tab=search&type=term" target="_blank">WooCommerce</a> first.',
                        'exclusive-addons-elementor-pro' ),
                    'content_classes' => 'exad-panel-notice',
                ]
            );

            $this->end_controls_section();

            return;
        }

		
        /**
         * Title Section
         */
		$this->start_controls_section(
			'exad_product_related_title_setting_section',
			[
				'label' => __( 'Title', 'exclusive-addons-elementor-pro' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'exad_product_related_title_text',
			[
				'label'      => esc_html__( 'Related Products', 'exclusive-addons-elementor-pro' ),
				'type'       => Controls_Manager::TEXT,
                'label_block'   => true,
				'default'    => esc_html__( 'Related Products', 'exclusive-addons-elementor-pro' ),
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'exad_product_related_content_setting_section',
			[
				'label' => __( 'Content Settings', 'exclusive-addons-elementor-pro' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
            'exad_product_related_content_setting_layout',
            [
				'label'   => __( 'Layout', 'exclusive-addons-elementor-pro' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'grid-layout',
				'prefix_class' => 'exad-product-',
				'options' => [
					'grid-layout' => esc_html__( 'Grid Layout', 'exclusive-addons-elementor-pro' ),
					'carousel-layout' => esc_html__( 'Carousel Layout', 'exclusive-addons-elementor-pro' ),
				]
            ]
		);

		$this->add_control(
			'posts_per_page',
			[
				'label' => __( 'Products Per Page', 'exclusive-addons-elementor-pro' ),
				'type'  => Controls_Manager::NUMBER,
				'default' => 4,
				'range' => [
					'px' => [
						'max' => 20,
					],
				],
			]
		);

		$this->add_responsive_control(
			'columns',
			[
				'label' => __( 'Columns', 'exclusive-addons-elementor-pro' ),
				'type'  => Controls_Manager::NUMBER,
				'prefix_class' => 'exclusive-addons-elementorducts-columns%s-',
				'default' => 4,
				'min' => 1,
				'max' => 12,
			]
		);

		$this->add_control(
			'orderby',
			[
				'label' => __( 'Order By', 'exclusive-addons-elementor-pro' ),
				'type'  => Controls_Manager::SELECT,
				'default' => 'date',
				'options' => [
					'date' => __( 'Date', 'exclusive-addons-elementor-pro' ),
					'title' => __( 'Title', 'exclusive-addons-elementor-pro' ),
					'price' => __( 'Price', 'exclusive-addons-elementor-pro' ),
					'popularity' => __( 'Popularity', 'exclusive-addons-elementor-pro' ),
					'rating' => __( 'Rating', 'exclusive-addons-elementor-pro' ),
					'rand' => __( 'Random', 'exclusive-addons-elementor-pro' ),
					'menu_order' => __( 'Menu Order', 'exclusive-addons-elementor-pro' ),
				],
			]
		);

		$this->add_control(
			'order',
			[
				'label' => __( 'Order', 'exclusive-addons-elementor-pro' ),
				'type'  => Controls_Manager::SELECT,
				'default' => 'desc',
				'options' => [
					'asc' => __( 'ASC', 'exclusive-addons-elementor-pro' ),
					'desc' => __( 'DESC', 'exclusive-addons-elementor-pro' ),
				],
			]
		);

        
		$this->add_control(
            'exad_product_related_content_update',
            [
                'label' => '<div class="elementor-update-preview" style="display: block;"><div class="elementor-update-preview-button-wrapper" style="display:block;"><button class="elementor-update-preview-button elementor-button elementor-button-success" style="background: #d30c5c; margin: 0 auto; display:block;">Apply Changes</button></div><div class="elementor-update-preview-title" style="display:block;text-align:center;margin-top: 10px;">'. __( 'Hit the button to apply changes if it hasn\'t already.', 'exclusive-addons-elementor-pro' ) .'</div></div>',
                'type' => Controls_Manager::RAW_HTML,
				'separator'  => 'before',
            ]
        );


		$this->end_controls_section();

        /**
  		*  Content Tab Carousel Settings
  		*/
          $this->start_controls_section(
            'exad_section_carousel_settings',
            [
                'label' => esc_html__( 'Carousel Settings', 'exclusive-addons-elementor-pro' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
                'condition' => [
                    'exad_product_related_content_setting_layout' => 'carousel-layout',
                ],
            ]
		);

		$slides_per_view = range( 1, 6 );
		$slides_per_view = array_combine( $slides_per_view, $slides_per_view );

		$this->add_control(
            'exad_product_related_carousel_nav',
            [
                'label'   => esc_html__( 'Navigation Style', 'exclusive-addons-elementor-pro' ),
                'type'    => Controls_Manager::SELECT,
                'prefix_class' => 'exad-product-navigation-',
                'default' => 'arrows-dots',
                'options' => [
					'arrows'   => esc_html__( 'Arrows', 'exclusive-addons-elementor-pro' ),
					'nav-dots' => esc_html__( 'Dots', 'exclusive-addons-elementor-pro' ),
                    'arrows-dots'     => esc_html__( 'Arrows and Dots', 'exclusive-addons-elementor-pro' ),
					'progress-bar' => esc_html__( 'Progress Bar', 'exclusive-addons-elementor-pro' ),
					'arrows-progress-bar' => esc_html__( 'Arrows and Progress Bar', 'exclusive-addons-elementor-pro' ),
					'fraction' => esc_html__( 'Fraction', 'exclusive-addons-elementor-pro' ),
					'arrows-fraction' => esc_html__( 'Arrows and Fraction', 'exclusive-addons-elementor-pro' ),
					'none'     => esc_html__( 'None', 'exclusive-addons-elementor-pro' )                    
                ]
            ]
        );

		$this->add_responsive_control(
			'slider_per_view',
			[
				'type'    => Controls_Manager::SELECT,
				'label'   => esc_html__( 'Columns', 'exclusive-addons-elementor-pro' ),
				'options' => $slides_per_view,
				'default' => '3',
				'tablet_default' => '2',
				'mobile_default' => '1',
			]
		);

		$this->add_responsive_control(
			'exad_product_related_carousel_column_space',
			[
				'label' => __( 'Column Space', 'exclusive-addons-elementor-pro' ),
				'type'  => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 30,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 15,
				]
			]
		);

		$this->add_control(
			'exad_product_related_carousel_slides_to_scroll',
			[
				'type'    => Controls_Manager::SELECT,
				'label'   => esc_html__( 'Items to Scroll', 'exclusive-addons-elementor-pro' ),
				'options' => $slides_per_view,
				'default'        => 1,
				'tablet_default' => 1,
				'mobile_default' => 1,
			]
		);

		$this->add_control(
			'exad_product_related_carousel_slides_per_column',
			[
				'type'      => Controls_Manager::SELECT,
				'label'     => esc_html__( 'Slides Per Column', 'exclusive-addons-elementor-pro' ),
				'options'   => $slides_per_view,
				'default'   => '1',
			]
		);
		
		$this->add_control(
			'exad_product_related_carousel_transition_duration',
			[
				'label'   => esc_html__( 'Transition Duration', 'exclusive-addons-elementor-pro' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 1000
			]
		);

		$this->add_control(
			'exad_product_related_carousel_autoheight',
			[
				'label'     => esc_html__( 'Auto Height', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::SWITCHER,
				'default'   => 'yes'
			]
		);

		$this->add_control(
			'exad_product_related_carousel_autoplay',
			[
				'label'     => esc_html__( 'Autoplay', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::SWITCHER,
				'default'   => 'yes'
			]
		);

		$this->add_control(
			'exad_product_related_carousel_autoplay_speed',
			[
				'label'     => esc_html__( 'Autoplay Speed', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 5000,
				'condition' => [
					'exad_product_related_carousel_autoplay' => 'yes'
				]
			]
		);

		$this->add_control(
			'exad_product_related_carousel_loop',
			[
				'label'   => esc_html__( 'Infinite Loop', 'exclusive-addons-elementor-pro' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes'
			]
		);

		$this->add_control(
			'exad_product_related_carousel_pause',
			[
				'label'     => esc_html__( 'Pause on Hover', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::SWITCHER,
				'default'   => 'yes',
				'condition' => [
					'exad_product_related_carousel_autoplay' => 'yes'
				]
			]
		);

		$this->add_control(
			'exad_product_related_carousel_slide_centered',
			[
				'label'       => esc_html__( 'Centered Mode Slide', 'exclusive-addons-elementor-pro' ),
				'type'        => Controls_Manager::SWITCHER,
				'default'     => 'no',
			]
		);
		
		$this->add_control(
			'exad_product_related_carousel_grab_cursor',
			[
				'label'       => esc_html__( 'Grab Cursor', 'exclusive-addons-elementor-pro' ),
				'type'        => Controls_Manager::SWITCHER,
				'default'     => 'no',
			]
		);

		$this->add_control(
			'exad_product_related_carousel_observer',
			[
				'label'       => esc_html__( 'Observer', 'exclusive-addons-elementor-pro' ),
				'type'        => Controls_Manager::SWITCHER,
				'default'     => 'no',
			]
		);

		$this->end_controls_section();

        /**
         * Style Section
         */

		/*
		*Related product Title Styling Section
		*/
		$this->start_controls_section(
            'exad_product_related_title_style',
            [
                'label'     => __( 'Related Title', 'exclusive-addons-elementor-pro' ),
                'tab'       => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'exad_product_related_title_typography',
                'selector' => '{{WRAPPER}} .exad-product-related .related.products > h2'
            ]
        );

        $this->add_control(
            'exad_product_related_title_color',
            [
                'label'     => esc_html__( 'Color', 'exclusive-addons-elementor-pro' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#000000',
                'selectors' => [
                    '{{WRAPPER}} .exad-product-related .related.products > h2' => 'color: {{VALUE}};'
                ]
            ]
        );

        $this->add_responsive_control(
            'exad_product_related_title_align',
            [
                'label'         => esc_html__( 'Alignment', 'exclusive-addons-elementor-pro' ),
                'type'          => Controls_Manager::CHOOSE,
                'default'       => 'left',
                'toggle'        => false,
                'options'       => [
                    'left' => [
                        'title'  => esc_html__( 'Left', 'exclusive-addons-elementor-pro' ),
                        'icon'   => 'eicon-h-align-left'
                    ],
                    'center'     => [
                        'title'  => esc_html__( 'Center', 'exclusive-addons-elementor-pro' ),
                        'icon'   => 'eicon-h-align-center'
                    ],
                    'right'   => [
                        'title'  => esc_html__( 'Right', 'exclusive-addons-elementor-pro' ),
                        'icon'   => 'eicon-h-align-right'
                    ]
                ],
                'selectors'     => [
                    '{{WRAPPER}} .exad-product-related .related.products > h2' => 'text-align: {{VALUE}};'
                ]
            ]
        );

        $this->add_responsive_control(
            'exad_product_related_title_margin',
            [
                'label'         => esc_html__( 'Margin', 'exclusive-addons-elementor-pro' ),
                'type'          => Controls_Manager::DIMENSIONS,            
                'size_units'    => [ 'px', 'em', '%' ],
                'selectors'     => [
                        '{{WRAPPER}} .exad-product-related .related.products > h2' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->end_controls_section();

		/*
		* Related container Styling Section
		*/
        $this->start_controls_section(
            'exad_product_related_container_style_section',
            [
                'label' => esc_html__( 'Container', 'exclusive-addons-elementor-pro' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'exad_product_related_container_background',
				'types'    => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .exad-product-related .related .products li'
			]
		);

		$this->add_responsive_control(
			'exad_product_related_container_padding',
			[
				'label'         => __( 'Padding', 'exclusive-addons-elementor-pro' ),
				'type'          => Controls_Manager::DIMENSIONS,
				'size_units'    => [ 'px', '%' ],
				'default'       => [
					'top'       => '0',
					'right'     => '0',
					'bottom'    => '0',
					'left'      => '0',
					'unit'      => 'px',
                    'isLinked'  => false
				],
				'selectors'     => [
					'{{WRAPPER}} .exad-product-related .related .products li' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
		);

        $this->add_responsive_control(
			'exad_product_related_container_radius',
			[
				'label'      => __( 'Border Radius', 'exclusive-addons-elementor-pro' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'default'    => [
					'top'    => '0',
					'right'  => '0',
					'bottom' => '0',
					'left'   => '0',
					'unit'   => 'px'
				],
				'selectors'  => [
					'{{WRAPPER}} .exad-product-related .related .products li' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'exad_product_related_container_border',
				'selector' => '{{WRAPPER}} .exad-product-related .related .products li'
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'exad_product_related_container_box_shadow',
				'selector' => '{{WRAPPER}} .exad-product-related .related .products li'
			]
		);

        $this->end_controls_section();

		/*
		* Related Content Box Styling Section
		*/
        $this->start_controls_section(
            'exad_product_related_content_box_style',
            [
                'label'   => __( 'Content Box', 'exclusive-addons-elementor-pro' ),
                'tab'     => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_responsive_control(
            'exad_product_related_content_box_align',
            [
                'label'         => esc_html__( 'Alignment', 'exclusive-addons-elementor-pro' ),
                'type'          => Controls_Manager::CHOOSE,
                'toggle'        => false,
                'options'       => [
                    'left' => [
                        'title'  => esc_html__( 'Left', 'exclusive-addons-elementor-pro' ),
                        'icon'   => 'eicon-h-align-left'
                    ],
                    'center'     => [
                        'title'  => esc_html__( 'Center', 'exclusive-addons-elementor-pro' ),
                        'icon'   => 'eicon-h-align-center'
                    ],
                    'right'   => [
                        'title'  => esc_html__( 'Right', 'exclusive-addons-elementor-pro' ),
                        'icon'   => 'eicon-h-align-right'
                    ]
                ],
                'default' => 'left',
				'selectors_dictionary' => [
					'left' => 'display: flex; flex-direction: column; align-items: flex-start; text-align: left;',
					'center' => 'display: flex; flex-direction: column; align-items: center; text-align: center;',
					'right' => 'display: flex; flex-direction: column; align-items: flex-end; text-align: right;',
				],
                'selectors'     => [
                    '{{WRAPPER}} .exad-product-related .related .products .product' => '{{VALUE}};',
                ]
            ]
        );

        $this->add_responsive_control(
            'exad_product_related_content_box_rating_align',
            [
                'label'         => esc_html__( 'Rating Alignment', 'exclusive-addons-elementor-pro' ),
                'type'          => Controls_Manager::CHOOSE,
                'default'       => 'left',
                'toggle'        => false,
                'options'       => [
                    'left' => [
                        'title'  => esc_html__( 'Left', 'exclusive-addons-elementor-pro' ),
                        'icon'   => 'eicon-h-align-left'
                    ],
                    'center'     => [
                        'title'  => esc_html__( 'Center', 'exclusive-addons-elementor-pro' ),
                        'icon'   => 'eicon-h-align-center'
                    ],
                    'right'   => [
                        'title'  => esc_html__( 'Right', 'exclusive-addons-elementor-pro' ),
                        'icon'   => 'eicon-h-align-right'
                    ]
                ],
                'default' => 'left',
				'selectors_dictionary' => [
					'left' => 'display: flex; flex-direction: column; align-items: flex-start; text-align: left; margin-right: auto',
					'center' => 'display: flex; flex-direction: column; align-items: center; text-align: center; margin-left: auto; margin-right: auto',
					'right' => 'display: flex; flex-direction: column; align-items: flex-end; text-align: right; margin-left: auto',
				],
                'selectors'     => [
                    '{{WRAPPER}} .exad-product-related .related .products .product .star-rating' => '{{VALUE}};'
                ]
            ]
        );

        
        $this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'exad_product_related_content_box_background',
				'types'    => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .exad-product-related .related .products .product'
			]
		);

		$this->add_responsive_control(
			'exad_product_related_content_box_padding',
			[
				'label'         => __( 'Padding', 'exclusive-addons-elementor-pro' ),
				'type'          => Controls_Manager::DIMENSIONS,
				'size_units'    => [ 'px', '%' ],
				'default'       => [
					'top'       => '0',
					'right'     => '0',
					'bottom'    => '0',
					'left'      => '0',
					'unit'      => 'px',
                    'isLinked'  => false
				],
				'selectors'     => [
					'{{WRAPPER}} .exad-product-related .related .products .product' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
		);

        $this->add_responsive_control(
			'exad_product_related_content_box_radius',
			[
				'label'      => __( 'Border Radius', 'exclusive-addons-elementor-pro' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'default'    => [
					'top'    => '0',
					'right'  => '0',
					'bottom' => '0',
					'left'   => '0',
					'unit'   => 'px'
				],
				'selectors'  => [
					'{{WRAPPER}} .exad-product-related .related .products .product' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'      => 'exad_product_related_content_box_border',
				'selector'  => '{{WRAPPER}} .exad-product-related .related .products .product'
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'exad_product_related_content_box_box_shadow',
				'selector' => '{{WRAPPER}} .exad-product-related .related .products .product'
			]
		);

        $this->end_controls_section();

		/*
		* Related Product Image Styling Section
		*/
		$this->start_controls_section(
            'exad_product_related_image_style',
            [
                'label' => __( 'Image and Tags', 'exclusive-addons-elementor-pro' ),
                'tab'   => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_responsive_control(
            'exad_product_related_image_height',
            [
                'label'         => esc_html__('Image Height', 'exclusive-addons-elementor-pro' ),
                'type'          => Controls_Manager::SLIDER,
                'selectors'     => [
                    '{{WRAPPER}} .exad-product-related .related .products li a img' => 'height: {{SIZE}}{{UNIT}};'
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

        $this->add_responsive_control(
            'exad_product_related_image_padding',
            [
                'label'         => esc_html__( 'Padding', 'exclusive-addons-elementor-pro' ),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => [ 'px', '%' ],
                'selectors'     => [
                    '{{WRAPPER}} .exad-product-related .related .products li a img' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ]
            ]
        );

        $this->add_control(
            'exad_product_related_image_overlay_color',
            [
                'label'     => esc_html__( 'Overlay', 'exclusive-addons-elementor-pro' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .exad-product-related .related .products li a.woocommerce-LoopProduct-link:before' => 'background-color: {{VALUE}};'
                ]
            ]
        );

        $this->add_control(
            'exad_product_related_image_hover_overlay_color',
            [
                'label'     => esc_html__( 'Hover Overlay', 'exclusive-addons-elementor-pro' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .exad-product-related .related .products li a.woocommerce-LoopProduct-link:hover:before' => 'background-color: {{VALUE}};'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'      => 'exad_product_related_image_border',
                'selector'  => '{{WRAPPER}} .exad-product-related .related .products li a img'
            ]
        );

        $this->add_responsive_control(
            'exad_product_related_image_border_radius',
            [
                'label'         => esc_html__( 'Border Radius', 'exclusive-addons-elementor-pro' ),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => [ 'px', '%' ],
                'selectors'     => [
                    '{{WRAPPER}} .exad-product-related .related .products li a img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .exad-product-related .related .products li a.woocommerce-LoopProduct-link:before' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'      => 'exad_product_related_image_box_shadow',
                'selector'  => '{{WRAPPER}} .exad-product-related .related .products li a img'        
            ]
        );

		$this->add_control(
            'exad_product_related_product_tag_style',
            [
                'label'         => esc_html__( 'Tags', 'exclusive-addons-elementor-pro' ),
                'type'          => Controls_Manager::HEADING,
                'separator'     => 'before'
            ]
        );

        $this->add_responsive_control(
            'exad_product_related_product_tag_position',
            [
                'label'         => esc_html__('Position(From Right Side)', 'exclusive-addons-elementor-pro' ),
                'type'          => Controls_Manager::SLIDER,
                'default'       => [
                    'size'      => 20,
                    'unit'      => 'px'
                ],  
                'selectors'     => [
                    '.woocommerce {{WRAPPER}} .exad-product-related .related .products li a span.onsale' => 'right: {{SIZE}}{{UNIT}};'
                ],                
                'range'         => [
                    'px'        => [
                        'min'   => 0,
                        'max'   => 40,
                        'step'  => 1
                    ]
                ]
            ]
        );  

        $this->add_responsive_control(
            'exad_product_related_product_image_sale_height',
            [
                'label'         => esc_html__('Sale Height', 'exclusive-addons-elementor-pro' ),
                'type'          => Controls_Manager::SLIDER,
                'selectors'     => [
                    '.woocommerce {{WRAPPER}} .exad-product-related .related .products li a span.onsale' => 'min-height: {{SIZE}}{{UNIT}}; line-height: {{SIZE}}{{UNIT}};'
                ],                
                'range'         => [
                    'px'        => [
                        'min'   => 0,
                        'max'   => 100,
                        'step'  => 1
                    ]
                ],
                'default' => [
					'unit' => 'px',
					'size' => 25,
				]
            ]
        );  

        $this->add_responsive_control(
            'exad_product_related_product_tag_padding',
            [
                'label'         => esc_html__( 'Padding', 'exclusive-addons-elementor-pro' ),
                'type'          => Controls_Manager::DIMENSIONS,            
                'size_units'    => [ 'px', 'em', '%' ],
                'default'       => [
					'top'       => '10',
					'right'     => '20',
					'bottom'    => '10',
					'left'      => '20',
					'unit'      => 'px',
                    'isLinked'  => false
				],
                'selectors'     => [
                        '.woocommerce {{WRAPPER}} .exad-product-related .related .products li a span.onsale' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->add_control(
            'exad_product_related_product_tag_border_radius',
            [
                'label'         => esc_html__( 'Border Radius', 'exclusive-addons-elementor-pro' ),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => [ 'px', '%' ],
                'default'    => [
                    'top'      => '10',
                    'right'    => '10',
                    'bottom'   => '10',
                    'left'     => '10',
                    'unit'     => 'px',
                    'isLinked' => true,
                ],
                'selectors'     => [
                    '.woocommerce {{WRAPPER}} .exad-product-related .related .products li a span.onsale' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->add_control(
            'exad_product_related_product_sale_tag_style',
            [
                'label'     => esc_html__( 'Sale Tag', 'exclusive-addons-elementor-pro' ),
                'type'      => Controls_Manager::HEADING
            ]
        );
        
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            array(
                'name'      => 'exad_product_related_product_sale_tag_typography',
                'label'     => __( 'Typography', 'exclusive-addons-elementor-pro' ),
                'selector'  => '.woocommerce {{WRAPPER}} .exad-product-related .related .products li a span.onsale',
            )
        );

        $this->add_control(
            'exad_product_related_product_sale_tag_color',
            [
                'label'     => esc_html__( 'Color', 'exclusive-addons-elementor-pro' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#ffffff',
                'selectors' => [
                    '.woocommerce {{WRAPPER}} .exad-product-related .related .products li a span.onsale' => 'color: {{VALUE}};'
                ]
            ]
        );

        $this->add_control(
            'exad_product_related_product_sale_tag_bg_color',
            [
                'label'     => esc_html__( 'Background Color', 'exclusive-addons-elementor-pro' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => $exad_primary_color,
                'selectors' => [
                    '.woocommerce {{WRAPPER}} .exad-product-related .related .products li a span.onsale' => 'background-color: {{VALUE}};'
                ]
            ]
        );

        $this->end_controls_section();

		/*
		*Related product Title Styling Section
		*/
		$this->start_controls_section(
            'exad_product_related_product_title_style',
            [
                'label'     => __( 'Title', 'exclusive-addons-elementor-pro' ),
                'tab'       => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'exad_product_related_product_title_typography',
                'selector' => '{{WRAPPER}} .exad-product-related .related .products li a .woocommerce-loop-product__title'
            ]
        );

        $this->add_control(
            'exad_product_related_product_title_color',
            [
                'label'     => esc_html__( 'Color', 'exclusive-addons-elementor-pro' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#000000',
                'selectors' => [
                    '{{WRAPPER}} .exad-product-related .related .products li a .woocommerce-loop-product__title' => 'color: {{VALUE}};'
                ]
            ]
        );

        $this->add_responsive_control(
            'exad_product_related_product_title_margin',
            [
                'label'         => esc_html__( 'Margin', 'exclusive-addons-elementor-pro' ),
                'type'          => Controls_Manager::DIMENSIONS,            
                'size_units'    => [ 'px', 'em', '%' ],
                'selectors'     => [
                        '{{WRAPPER}} .exad-product-related .related .products li a .woocommerce-loop-product__title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->end_controls_section();

		/*
		* Before & After Related Styling Section
		*/
		$this->start_controls_section(
            'exad_product_related_product_price_style',
            [
                'label'     => __( 'Price', 'exclusive-addons-elementor-pro' ),
                'tab'       => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'exad_product_related_product_price_typography',
                'selector' => '{{WRAPPER}} .exad-product-related .related .products li a .price'
            ]
        );

        $this->add_control(
            'exad_product_related_product_price_color',
            [
                'label'     => esc_html__( 'Color', 'exclusive-addons-elementor-pro' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#000000',
                'selectors' => [
                    '{{WRAPPER}} .exad-product-related .related .products li a .price' => 'color: {{VALUE}};'
                ]
            ]
        );

        $this->add_responsive_control(
            'exad_product_related_product_price_margin',
            [
                'label'         => esc_html__( 'Margin', 'exclusive-addons-elementor-pro' ),
                'type'          => Controls_Manager::DIMENSIONS,            
                'size_units'    => [ 'px', 'em', '%' ],
                'selectors'     => [
                        '{{WRAPPER}} .exad-product-related .related .products li a .price' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->end_controls_section();

		/*
		* Related product star rating Styling Section
		*/
        $this->start_controls_section(
            'exad_product_related_product_star_rating_style',
            [
                'label'     => __( 'Star Rating', 'exclusive-addons-elementor-pro' ),
                'tab'       => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'exad_product_related_product_star_rating_font_size',
            [
                'label'         => esc_html__('Font Size', 'exclusive-addons-elementor-pro' ),
                'type'          => Controls_Manager::SLIDER,
                'default'       => [
                    'size'      => 18,
                    'unit'      => 'px'
                ],  
                'selectors'     => [
                    '{{WRAPPER}} .exad-product-related .related .products li a .star-rating' => 'font-size: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};'
                ],                
                'range'         => [
                    'px'        => [
                        'min'   => 8,
                        'max'   => 30,
                        'step'  => 1
                    ]
                ]
            ]
        );  

        $this->add_control(
            'exad_product_related_product_star_rating_color',
            [
                'label'         => esc_html__( 'Color', 'exclusive-addons-elementor-pro' ),
                'type'          => Controls_Manager::COLOR, 
                'default'       => '#3BC473',       
                'selectors'     => [
                    '{{WRAPPER}} .exad-product-related .related .products li a .star-rating:before' => 'color: {{VALUE}};',
                ],               
            ]
        );

		$this->add_control(
			'exad_product_related_product_star_rating_active_color',
			[
				'label'     => __( 'Color', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ff5b84',
				'selectors' => [
					'{{WRAPPER}} .exad-product-related .related .products li a .star-rating' => 'color: {{VALUE}};'
				]
			]
		);

        $this->add_responsive_control(
            'exad_product_related_product_star_rating_margin',
            [
                'label'         => esc_html__( 'Margin', 'exclusive-addons-elementor-pro' ),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => [ 'px' ],
                'default'       => [
                    'top'       => 10,
                    'right'     => 0,
                    'bottom'    => 10,
                    'left'      => 0
                ],
                'selectors'     => [
                    '{{WRAPPER}} .exad-product-related .related .products li a .star-rating' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->end_controls_section();

			
		/*
		* Related product button Styling Section
		*/
		$this->start_controls_section(
            'exad_product_related_product_add_to_cart_btn_style',
            [
                'label'     => __( 'Button', 'exclusive-addons-elementor-pro' ),
                'tab'       => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'exad_product_related_product_add_to_cart_btn_typography',
                'selector' => '{{WRAPPER}} .exad-product-related .related .products li a.button'
            ]
        );

        $this->add_responsive_control(
            'exad_product_related_product_add_to_cart_btn_padding',
            [
                'label'         => esc_html__( 'Padding', 'exclusive-addons-elementor-pro' ),
                'type'          => Controls_Manager::DIMENSIONS,            
                'size_units'    => [ 'px', 'em', '%' ],
                'selectors'     => [
                        '{{WRAPPER}} .exad-product-related .related .products li a.button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->add_responsive_control(
            'exad_product_related_product_add_to_cart_btn_margin',
            [
                'label'         => esc_html__( 'Margin', 'exclusive-addons-elementor-pro' ),
                'type'          => Controls_Manager::DIMENSIONS,            
                'size_units'    => [ 'px', 'em', '%' ],
                'selectors'     => [
                        '{{WRAPPER}} .exad-product-related .related .products li a.button' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );


        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'      => 'exad_product_related_product_add_to_cart_btn_border',
                'selector'  => '{{WRAPPER}} .exad-product-related .related .products li a.button'
            ]
        );

        $this->add_responsive_control(
            'exad_product_related_product_add_to_cart_btn_border_radius',
            [
                'label'         => esc_html__( 'Border Radius', 'exclusive-addons-elementor-pro' ),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => [ 'px', '%' ],
                'selectors'     => [
                    '{{WRAPPER}} .exad-product-related .related .products li a.button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->start_controls_tabs( 'exad_product_related_product_add_to_cart_btn_tabs' );

            // Normal State Tab
            $this->start_controls_tab( 'exad_product_related_product_add_to_cart_btn_normal', [ 'label' => esc_html__( 'Normal', 'exclusive-addons-elementor-pro' ) ] );

            $this->add_control(
                'exad_product_related_product_add_to_cart_btn_normal_color',
                [
                    'label'     => esc_html__( 'Color', 'exclusive-addons-elementor-pro' ),
                    'type'      => Controls_Manager::COLOR,
                    'default'   => '#ffffff',
                    'selectors' => [
                        '{{WRAPPER}} .exad-product-related .related .products li a.button' => 'color: {{VALUE}};'
                    ]
                ]
            );

            $this->add_control(
                'exad_product_related_product_add_to_cart_btn_normal_bg_color',
                [
                    'label'     => esc_html__( 'Background Color', 'exclusive-addons-elementor-pro' ),
                    'type'      => Controls_Manager::COLOR,
                    'default'   => '#3BC473',
                    'selectors' => [
                        '{{WRAPPER}} .exad-product-related .related .products li a.button' => 'background-color: {{VALUE}};'
                    ]
                ]
            );

            $this->add_control(
                'exad_product_related_product_add_to_cart_btn_normal_border_color',
                [
                    'label'     => esc_html__( 'Border Color', 'exclusive-addons-elementor-pro' ),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .exad-product-related .related .products li a.button' => 'border-color: {{VALUE}};'
                    ]
                ]
            );

            $this->add_group_control(
                Group_Control_Box_Shadow::get_type(),
                [
                    'name'     => 'exad_product_related_product_add_to_cart_btn_normal_shadow',
                    'label'    => __( 'Box Shadow', 'exclusive-addons-elementor-pro' ),
                    'selector' => '{{WRAPPER}} .exad-product-related .related .products li a.button',
                ]
            );
            
            $this->end_controls_tab();

            // Hover State Tab
            $this->start_controls_tab( 'exad_product_related_product_add_to_cart_btn_hover', [ 'label' => esc_html__( 'Hover', 'exclusive-addons-elementor-pro' ) ] );

            $this->add_control(
                'exad_product_related_product_add_to_cart_btn_hover_color',
                [
                    'label'     => esc_html__( 'Color', 'exclusive-addons-elementor-pro' ),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .exad-product-related .related .products li a.button:hover' => 'color: {{VALUE}};'
                    ]
                ]
            );

            $this->add_control(
                'exad_product_related_product_add_to_cart_btn_hover_bg_color',
                [
                    'label'     => esc_html__( 'Background Color', 'exclusive-addons-elementor-pro' ),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .exad-product-related .related .products li a.button:hover' => 'background-color: {{VALUE}};'
                    ]
                ]
            );

            $this->add_control(
                'exad_product_related_product_add_to_cart_btn_hover_border_color',
                [
                    'label'     => esc_html__( 'Border Color', 'exclusive-addons-elementor-pro' ),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .exad-product-related .related .products li a.button:hover' => 'border-color: {{VALUE}};'
                    ]
                ]

            );

            $this->add_group_control(
                Group_Control_Box_Shadow::get_type(),
                [
                    'name'     => 'exad_product_related_product_add_to_cart_btn_hover_shadow',
                    'label'    => __( 'Box Shadow', 'exclusive-addons-elementor-pro' ),
                    'selector' => '{{WRAPPER}} .exad-product-related .related .products li a.button:hover',
                ]
            );

            $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();

        /**
		 * Style Tab Arrows Style
		 */
		$this->start_controls_section(
            'exad_product_related_carousel_nav_arrow',
            [
                'label'     => esc_html__( 'Arrows', 'exclusive-addons-elementor-pro' ),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'exad_product_related_carousel_nav' => ['arrows', 'arrows-dots', 'arrows-fraction', 'arrows-progress-bar'],
                    'exad_product_related_content_setting_layout' => 'carousel-layout',
                ],
            ]
        );

        $this->add_responsive_control(
            'exad_product_related_carousel_nav_arrow_box_size',
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
                    '{{WRAPPER}} .exad-product-related .related .product-prev' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .exad-product-related .related .product-next' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'exad_product_related_carousel_nav_arrow_icon_size',
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
                    '{{WRAPPER}} .exad-product-related .related .product-prev svg' => 'font-size: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .exad-product-related .related .product-next svg' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        
        $this->add_control(
            'exad_product_related_carousel_prev_arrow_position',
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
                'exad_product_related_carousel_prev_arrow_position_x_offset',
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
                        'size' => -55,
                    ],
                    'selectors'  => [
                        '{{WRAPPER}} .exad-product-related .related .product-prev' => 'left: {{SIZE}}{{UNIT}};',
                    ],
                ]
            );

            $this->add_responsive_control(
                'exad_product_related_carousel_prev_arrow_position_y_offset',
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
                        '{{WRAPPER}} .exad-product-related .related .product-prev' => 'top: {{SIZE}}{{UNIT}};',
                    ],
                ]
            );

        $this->end_popover();

        $this->add_control(
            'exad_product_related_carousel_next_arrow_position',
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
                'exad_product_related_carousel_next_arrow_position_x_offset',
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
                        'size' => -55,
                    ],
                    'selectors'  => [
                        '{{WRAPPER}} .exad-product-related .related .product-next' => 'right: {{SIZE}}{{UNIT}};',
                    ],
                ]
            );

            $this->add_responsive_control(
                'exad_product_related_carousel_next_arrow_position_y_offset',
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
                        '{{WRAPPER}} .exad-product-related .related .product-next' => 'top: {{SIZE}}{{UNIT}};',
                    ],
                ]
            );

        $this->end_popover();

        $this->add_responsive_control(
            'exad_product_related_carousel_nav_arrow_radius',
            [
                'label'      => __( 'Border radius', 'exclusive-addons-elementor-pro' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'default'    => [
                    'top'      => '50',
                    'right'    => '50',
                    'bottom'   => '50',
                    'left'     => '50',
                    'unit'     => 'px',
                    'isLinked' => true,
                ],
                'selectors'  => [
                    '{{WRAPPER}} .exad-product-related .related .product-prev' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .exad-product-related .related .product-next' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs( 'exad_product_related_carousel_nav_arrow_tabs' );

			// normal state rating
			$this->start_controls_tab( 'exad_product_related_carousel_nav_arrow_normal', [ 'label' => esc_html__( 'Normal', 'exclusive-addons-elementor-pro' ) ] );

                $this->add_control(
                    'exad_product_related_carousel_arrow_normal_background',
                    [
                        'label'     => __( 'Background Color', 'exclusive-addons-elementor-pro' ),
                        'type'      => Controls_Manager::COLOR,
                        'default'   =>  $exad_primary_color,
                        'selectors' => [
                            '{{WRAPPER}} .exad-product-related .related .product-prev' => 'background: {{VALUE}}',
                            '{{WRAPPER}} .exad-product-related .related .product-next' => 'background: {{VALUE}}',
                        ],
                    ]
                );

                $this->add_control(
                    'exad_product_related_carousel_arrow_normal_color',
                    [
                        'label'     => __( 'Icon Color', 'exclusive-addons-elementor-pro' ),
                        'type'      => Controls_Manager::COLOR,
                        'default'   => '#ffffff',
                        'selectors' => [
                            '{{WRAPPER}} .exad-product-related .related .product-prev svg' => 'color: {{VALUE}};',
                            '{{WRAPPER}} .exad-product-related .related .product-next svg' => 'color: {{VALUE}};',
                        ],
                    ]
                );

                $this->add_group_control(
                    Group_Control_Border::get_type(),
                    [
                        'name'     => 'exad_product_related_carousel_arrow_normal_border',
                        'label'    => __( 'Border', 'exclusive-addons-elementor-pro' ),
                        'selector' => '{{WRAPPER}} .exad-product-related .related .product-prev, {{WRAPPER}} .exad-product-related .related .product-next',
                    ]
                );

                $this->add_group_control(
                    Group_Control_Box_Shadow::get_type(),
                    [
                        'name'     => 'exad_product_related_carousel_arrow_normal_shadow',
                        'label'    => __( 'Box Shadow', 'exclusive-addons-elementor-pro' ),
                        'selector' => '{{WRAPPER}} .exad-product-related .related .product-prev, {{WRAPPER}} .exad-product-related .related .product-next',
                    ]
                );

			$this->end_controls_tab();

			// hover state rating
			$this->start_controls_tab( 'exad_product_related_carousel_nav_arrow_hover', [ 'label' => esc_html__( 'Hover', 'exclusive-addons-elementor-pro' ) ] );

                $this->add_control(
                    'exad_product_related_carousel_arrow_hover_background',
                    [
                        'label'     => __( 'Background Color', 'exclusive-addons-elementor-pro' ),
                        'type'      => Controls_Manager::COLOR,
                        'default'   => $exad_primary_color,
                        'selectors' => [
                            '{{WRAPPER}} .exad-product-related .related .product-prev:hover' => 'background: {{VALUE}}',
                            '{{WRAPPER}} .exad-product-related .related .product-next:hover' => 'background: {{VALUE}}',
                        ],
                    ]
                );

                $this->add_control(
                    'exad_product_related_carousel_arrow_hover_color',
                    [
                        'label'     => __( 'Icon Color', 'exclusive-addons-elementor-pro' ),
                        'type'      => Controls_Manager::COLOR,
                        'default'   => '#ffffff',
                        'selectors' => [
                            '{{WRAPPER}} .exad-product-related .related .product-prev:hover svg' => 'color: {{VALUE}}',
                            '{{WRAPPER}} .exad-product-related .related .product-next:hover svg' => 'color: {{VALUE}}',
                        ],
                    ]
                );

                $this->add_group_control(
                    Group_Control_Border::get_type(),
                    [
                        'name'     => 'exad_product_related_carousel_arrow_hover_border',
                        'label'    => __( 'Border', 'exclusive-addons-elementor-pro' ),
                        'selector' => '{{WRAPPER}} .exad-product-related .related .product-prev:hover, {{WRAPPER}} .exad-product-related .related .product-next:hover',
                    ]
                );

                $this->add_group_control(
                    Group_Control_Box_Shadow::get_type(),
                    [
                        'name'     => 'exad_product_related_carousel_arrow_hover_shadow',
                        'label'    => __( 'Box Shadow', 'exclusive-addons-elementor-pro' ),
                        'selector' => '{{WRAPPER}} .exad-product-related .related .product-prev:hover, {{WRAPPER}} .exad-product-related .related .product-next:hover',
                    ]
                );

			$this->end_controls_tab();

        $this->end_controls_tabs();

		$this->end_controls_section();

		/**
		* Style Tab Dots Style
		*/
		$this->start_controls_section(
            'exad_product_related_carousel_nav_dot',
            [
                'label'     => esc_html__( 'Dots', 'exclusive-addons-elementor-pro' ),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'exad_product_related_carousel_nav' => ['nav-dots', 'arrows-dots'],
                    'exad_product_related_content_setting_layout' => 'carousel-layout',
                ],
            ]
        );

        $this->add_responsive_control(
            'exad_product_tabs_control_item_cexad_product_related_carousel_nav_dot_alignmentontrol_item_alignment',
            [
                'label'         => esc_html__('Dots Alignment', 'exclusive-addons-elementor-pro'),
                'type'          => Controls_Manager::CHOOSE,
                'toggle'        => false,
                'label_block'   => true,
                'default'       => 'center',
                'options'       => [
                    'left'      => [
                        'title' => esc_html__('Left', 'exclusive-addons-elementor-pro'),
                        'icon'  => 'eicon-text-align-left'
                    ],
                    'center'    => [
                        'title' => esc_html__('Center', 'exclusive-addons-elementor-pro'),
                        'icon'  => 'eicon-text-align-center'
                    ],
                    'right'     => [
                        'title' => esc_html__('Right', 'exclusive-addons-elementor-pro'),
                        'icon'  => 'eicon-text-align-right'
                    ],
                ],
				'selectors_dictionary' => [
                    'left'      => 'text-align: left; display: flex; justify-content: flex-start; margin-right: auto;',
					'center'    => 'text-align: center; display: flex; justify-content: center; margin-left: auto; margin-right: auto;',
					'right'     => 'text-align: right; display: flex; justify-content: flex-end; margin-left: auto;',
                ],
                'selectors'     => [
                    '{{WRAPPER}} .exad-product-related .exad-dots-container' => '{{VALUE}};'
                ]
            ]
        );      

        $this->add_responsive_control(
            'exad_product_related_carousel_dots_top_spacing',
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
                    '{{WRAPPER}} .exad-product-related .exad-swiper-pagination' => 'margin-top: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

		$this->add_responsive_control(
			'exad_product_related_carousel_dots_spacing_btwn',
			[
				'label' => __( 'Space Between', 'exclusive-addons-elementor-pro' ),
				'type'  => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 8,
				],
                'condition' => [
                    'exad_product_related_carousel_nav' => ['nav-dots', 'arrows-dots'],
                ],
				'selectors' => [
					'{{WRAPPER}} .exad-product-related .exad-swiper-pagination .swiper-pagination-bullet:not(:last-child)' => 'margin-right: {{SIZE}}{{UNIT}};',
				]
			]
		);

        $this->add_responsive_control(
            'exad_product_related_carousel_nav_dot_radius',
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
                    '{{WRAPPER}} .exad-product-related .exad-swiper-pagination .swiper-pagination-bullet' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs( 'exad_product_related_carousel_nav_dots_tabs' );

			// normal state rating
            $this->start_controls_tab( 'exad_product_related_carousel_nav_dots_normal', [ 'label' => esc_html__( 'Normal', 'exclusive-addons-elementor-pro' ) ] );

                $this->add_responsive_control(
                    'exad_product_related_carousel_dots_normal_height',
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
                            '{{WRAPPER}} .exad-product-related .exad-swiper-pagination .swiper-pagination-bullet' => 'height: {{SIZE}}{{UNIT}};',
                        ],
                    ]
                );

				$this->add_responsive_control(
                    'exad_product_related_carousel_dots_normal_width',
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
                            '{{WRAPPER}} .exad-product-related .exad-swiper-pagination .swiper-pagination-bullet' => 'width: {{SIZE}}{{UNIT}};',
                        ],
                    ]
                );

                $this->add_control(
                    'exad_product_related_carousel_dots_normal_background',
                    [
                        'label'     => __( 'Background Color', 'exclusive-addons-elementor-pro' ),
                        'type'      => Controls_Manager::COLOR,
                        'default'   => '#e5e5e5',
                        'selectors' => [
                            '{{WRAPPER}} .exad-product-related .exad-swiper-pagination .swiper-pagination-bullet' => 'background: {{VALUE}};',
                        ],
                    ]
                );
				
				$this->add_responsive_control(
                    'exad_product_related_carousel_dots_normal_opacity',
                    [
                        'label'     => __( 'Opacity', 'exclusive-addons-elementor-pro' ),
                        'type'      => Controls_Manager::SLIDER,
                        'default' => [
							'size' => 1,
						],
						'range' => [
							'px' => [
								'max' => 1,
								'step' => 0.01,
							],
						],
                        'selectors' => [
                            '{{WRAPPER}} .exad-product-related .exad-swiper-pagination .swiper-pagination-bullet' => 'opacity: {{SIZE}};',
                        ],
                    ]
                );

                $this->add_group_control(
                    Group_Control_Border::get_type(),
                    [
                        'name'     => 'exad_product_related_carousel_dots_normal_border',
                        'label'    => __( 'Border', 'exclusive-addons-elementor-pro' ),
                        'selector' => '{{WRAPPER}} .exad-product-related .exad-swiper-pagination .swiper-pagination-bullet , {{WRAPPER}} .exad-product-related .exad-swiper-pagination .swiper-pagination-bullet:hover',
                    ]
                );

			$this->end_controls_tab();

			// hover state rating
            $this->start_controls_tab( 'exad_product_related_carousel_nav_dots_hover', [ 'label' => esc_html__( 'Hover/active', 'exclusive-addons-elementor-pro' ) ] );
            
                $this->add_responsive_control(
                    'exad_product_related_carousel_dots_active_height',
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
                            '{{WRAPPER}} .exad-product-related .exad-swiper-pagination .swiper-pagination-bullet-active' => 'height: {{SIZE}}{{UNIT}};',
                        ],
                    ]
                );

				$this->add_responsive_control(
                    'exad_product_related_carousel_dots_active_width',
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
                            '{{WRAPPER}} .exad-product-related .exad-swiper-pagination .swiper-pagination-bullet-active' => 'width: {{SIZE}}{{UNIT}};',
                        ],
                    ]
                );

                $this->add_control(
                    'exad_product_related_carousel_dots_active_background',
                    [
                        'label'     => __( 'Background Color', 'exclusive-addons-elementor-pro' ),
                        'type'      => Controls_Manager::COLOR,
                        'default'   => $exad_primary_color,
                        'selectors' => [
                            '{{WRAPPER}} .exad-product-related .exad-swiper-pagination .swiper-pagination-bullet-active' => 'background: {{VALUE}};',
                            '{{WRAPPER}} .exad-product-related .exad-swiper-pagination .swiper-pagination-bullet:hover' => 'background: {{VALUE}};',
                        ],
                    ]
                );

				$this->add_responsive_control(
                    'exad_product_related_carousel_dots_hover_opacity',
                    [
                        'label'     => __( 'Opacity', 'exclusive-addons-elementor-pro' ),
                        'type'      => Controls_Manager::SLIDER,
						'default' => [
							'size' => 1,
						],
						'range' => [
							'px' => [
								'max' => 1,
								'step' => 0.01,
							],
						],
                        'selectors' => [
							'{{WRAPPER}} .exad-product-related .exad-swiper-pagination .swiper-pagination-bullet-active' => 'opacity: {{SIZE}};',
                            '{{WRAPPER}} .exad-product-related .exad-swiper-pagination .swiper-pagination-bullet:hover' => 'opacity: {{SIZE}};',
                        ],
                    ]
                );

                $this->add_group_control(
                    Group_Control_Border::get_type(),
                    [
                        'name'     => 'exad_product_related_carousel_dots_active_border',
                        'label'    => __( 'Border', 'exclusive-addons-elementor-pro' ),
                        'selector' => '{{WRAPPER}} .exad-product-related .exad-swiper-pagination .swiper-pagination-bullet-active, {{WRAPPER}} .exad-product-related .exad-swiper-pagination .swiper-pagination-bullet:hover',
                    ]
                );

			$this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();

        /**
		* Style Tab Fraction Style
		*/
		$this->start_controls_section(
            'exad_product_related_carousel_nav_fraction',
            [
                'label'     => esc_html__( 'Fraction', 'exclusive-addons-elementor-pro' ),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'exad_product_related_carousel_nav' => ['fraction', 'arrows-fraction'],
                    'exad_product_related_content_setting_layout' => 'carousel-layout',
                ],
            ]
        );

        $this->add_control(
            'exad_product_related_carousel_nav_fraction_alignment',
            [
                'label'   => __( 'Alignment', 'exclusive-addons-elementor-pro' ),
                'type'    => Controls_Manager::CHOOSE,
                'options' => [
                    'exad-product-carousel-dots-left'   => [
                        'title' => __( 'Left', 'exclusive-addons-elementor-pro' ),
                        'icon'  => 'eicon-h-align-left',
                    ],
                    'exad-product-carousel-dots-center' => [
                        'title' => __( 'Center', 'exclusive-addons-elementor-pro' ),
                        'icon'  => 'eicon-h-align-center',
                    ],
                    'exad-product-carousel-dots-right'  => [
                        'title' => __( 'Right', 'exclusive-addons-elementor-pro' ),
                        'icon'  => 'eicon-h-align-right',
                    ],
                ],
                'default' => 'exad-product-carousel-dots-center',
            ]
        );

        $this->add_responsive_control(
            'exad_product_related_carousel_fraction_top_spacing',
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
                    'size' => 30,
                ],
                'selectors'  => [
                    '{{WRAPPER}} .exad-product-related .exad-swiper-pagination' => 'margin-top: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
			'exad_product_related_carousel_fraction_spacing_btwn',
			[
				'label' => __( 'Space Between', 'exclusive-addons-elementor-pro' ),
				'type'  => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 8,
				],
				'selectors' => [
					'{{WRAPPER}} .exad-product-related .exad-swiper-pagination.swiper-pagination-fraction .swiper-pagination-current' => 'margin-right: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .exad-product-related .exad-swiper-pagination.swiper-pagination-fraction .swiper-pagination-total' => 'margin-left: {{SIZE}}{{UNIT}};',
				]
			]
		);

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'exad_product_related_carousel_swiper-pagination_fraction_typography',
                'selector' => '{{WRAPPER}} .exad-product-related .exad-swiper-pagination.swiper-pagination-fraction *',
            ]
        );

        $this->add_responsive_control(
            'exad_product_related_carousel_nav_fraction_radius',
            [
                'label'      => __( 'Border Radius', 'exclusive-addons-elementor-pro' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'default'    => [
                    'top'      => '50',
                    'right'    => '50',
                    'bottom'   => '50',
                    'left'     => '50',
                    'unit'     => 'px',
                    'isLinked' => true,
                ],
                'selectors'  => [
                    '{{WRAPPER}} .exad-product-related .exad-swiper-pagination.swiper-pagination-fraction span' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs( 'exad_product_related_carousel_nav_fraction_tabs' );
        // normal state rating

            $this->start_controls_tab( 'exad_product_related_carousel_nav_fraction_normal', [ 'label' => esc_html__( 'Normal', 'exclusive-addons-elementor-pro' ) ] );
                $this->add_responsive_control(
                    'exad_product_related_carousel_fraction_normal_height',
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
                            'size' => 32,
                        ],
                        'selectors'  => [
                            '{{WRAPPER}} .exad-product-related .exad-swiper-pagination.swiper-pagination-fraction .swiper-pagination-total' => 'height: {{SIZE}}{{UNIT}};',
                            '{{WRAPPER}} .exad-product-related .exad-swiper-pagination.swiper-pagination-fraction .swiper-pagination-total' => 'line-height: {{SIZE}}{{UNIT}};',
                        ],
                    ]
                );

                $this->add_responsive_control(
                    'exad_product_related_carousel_fraction_normal_width',
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
                            'size' => 32,
                        ],
                        'selectors'  => [
                            '{{WRAPPER}} .exad-product-related .exad-swiper-pagination.swiper-pagination-fraction .swiper-pagination-total' => 'width: {{SIZE}}{{UNIT}};',
                        ],
                    ]
                );

                $this->add_control(
                    'exad_product_related_carousel_pagination_fraction_color',
                    [
                        'label'     => esc_html__( 'Color', 'exclusive-addons-elementor-pro' ),
                        'type'      => Controls_Manager::COLOR,
                        'default'   => '#000000',
                        'selectors' => [
                            '{{WRAPPER}} .exad-product-related .exad-swiper-pagination.swiper-pagination-fraction .swiper-pagination-total' => 'color: {{VALUE}};'
                        ]
                    ]
                );      
                
                $this->add_control(
                    'exad_product_related_carousel_fraction_normal_background',
                    [
                        'label'     => __( 'Background Color', 'exclusive-addons-elementor-pro' ),
                        'type'      => Controls_Manager::COLOR,
                        'default'   => '#e5e5e5',
                        'selectors' => [
                            '{{WRAPPER}} .exad-product-related .exad-swiper-pagination.swiper-pagination-fraction .swiper-pagination-total' => 'background: {{VALUE}};',
                        ],
                    ]
                );
                
                $this->add_group_control(
                    Group_Control_Border::get_type(),
                    [
                        'name'     => 'exad_product_related_carousel_fraction_normal_border',
                        'label'    => __( 'Border', 'exclusive-addons-elementor-pro' ),
                        'selector' => '{{WRAPPER}} .exad-product-related .exad-swiper-pagination.swiper-pagination-fraction .swiper-pagination-total',
                    ]
                );
            $this->end_controls_tab();

            // hover state rating
            $this->start_controls_tab( 'exad_product_related_carousel_nav_fraction_hover', [ 'label' => esc_html__( 'Hover/active', 'exclusive-addons-elementor-pro' ) ] );
            
                $this->add_responsive_control(
                    'exad_product_related_carousel_fraction_active_height',
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
                            'size' => 32,
                        ],
                        'selectors'  => [
                            '{{WRAPPER}} .exad-product-related .exad-swiper-pagination.swiper-pagination-fraction .swiper-pagination-current' => 'height: {{SIZE}}{{UNIT}};',
                            '{{WRAPPER}} .exad-product-related .exad-swiper-pagination.swiper-pagination-fraction .swiper-pagination-current' => 'line-height: {{SIZE}}{{UNIT}};',
                        ],
                    ]
                );

				$this->add_responsive_control(
                    'exad_product_related_carousel_fraction_active_width',
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
                            'size' => 32,
                        ],
                        'selectors'  => [
                            '{{WRAPPER}} .exad-product-related .exad-swiper-pagination.swiper-pagination-fraction .swiper-pagination-current' => 'width: {{SIZE}}{{UNIT}};',
                        ],
                    ]
                );

                $this->add_control(
                    'exad_product_related_carousel_pagination_fraction_current_color',
                    [
                        'label'     => esc_html__( 'Color', 'exclusive-addons-elementor-pro' ),
                        'type'      => Controls_Manager::COLOR,
                        'default'   => '#fff',
                        'selectors' => [
                            '{{WRAPPER}} .exad-product-related .exad-swiper-pagination.swiper-pagination-fraction .swiper-pagination-current' => 'color: {{VALUE}};'
                        ]
                    ]
                );     

                $this->add_control(
                    'exad_product_related_carousel_fraction_active_background',
                    [
                        'label'     => __( 'Background Color', 'exclusive-addons-elementor-pro' ),
                        'type'      => Controls_Manager::COLOR,
                        'default'   => $exad_primary_color,
                        'selectors' => [
                            '{{WRAPPER}} .exad-product-related .exad-swiper-pagination.swiper-pagination-fraction .swiper-pagination-current:hover' => 'background: {{VALUE}};',
                            '{{WRAPPER}} .exad-product-related .exad-swiper-pagination.swiper-pagination-fraction .swiper-pagination-current' => 'background: {{VALUE}};',
                        ],
                    ]
                );

                $this->add_group_control(
                    Group_Control_Border::get_type(),
                    [
                        'name'     => 'exad_product_related_carousel_fraction_active_border',
                        'label'    => __( 'Border', 'exclusive-addons-elementor-pro' ),
                        'selector' => '{{WRAPPER}} .exad-product-related .exad-swiper-pagination.swiper-pagination-fraction .swiper-pagination-current',
                    ]
                );

			$this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

	    /**
		* Style Tab progressbar Style
		*/
		$this->start_controls_section(
            'exad_product_related_carousel_nav_progressbar',
            [
                'label'     => esc_html__( 'Progress Bar', 'exclusive-addons-elementor-pro' ),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'exad_product_related_carousel_nav' => ['progress-bar', 'arrows-progress-bar'],
                    'exad_product_related_content_setting_layout' => 'carousel-layout',
                ],
            ]
        );

        $this->add_control(
            'exad_product_related_carousel_nav_progressbar_normal_color',
            [
                'label'     => __( 'Normal Color', 'exclusive-addons-elementor-pro' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#e5e5e5',
                'selectors' => [
                    '{{WRAPPER}} .exad-product-related .exad-dots-container .exad-swiper-pagination.swiper-pagination.swiper-pagination-progressbar' => 'background: {{VALUE}};',
                ],
            ]
        );
        
        $this->add_control(
            'exad_product_related_carousel_nav_progressbar_active_color',
            [
                'label'     => __( 'Active Color', 'exclusive-addons-elementor-pro' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => $exad_primary_color,
                'separator' => "after",
                'selectors' => [
                    '{{WRAPPER}} .exad-product-related .exad-dots-container .exad-swiper-pagination.swiper-pagination.swiper-pagination-progressbar .swiper-pagination-progressbar-fill' => 'background: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
			'exad_product_related_carousel_nav_Progress_position',
			[
				'label'   => __( 'Position', 'exclusive-addons-elementor-pro' ),
				'type'    => Controls_Manager::CHOOSE,
				'toggle'  => false,
				'default' => 'exad-Progressbar-align-top',
				'options' => [
					'exad-Progressbar-align-top' => [
						'title' => __( 'Top', 'exclusive-addons-elementor-pro' ),
						'icon'  => 'eicon-arrow-up'
					],
					'exad-Progressbar-align-bottom' => [
						'title' => __( 'Bottom', 'exclusive-addons-elementor-pro' ),
						'icon'  => 'eicon-arrow-down'
					]
				]
			]
		);
        
        $this->add_responsive_control(
			'exad_product_related_carousel_nav_Progress_specing',
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
					'size'    => 0
				],
				'selectors'   => [
					'{{WRAPPER}} .exad-product-carousel-wrapper.exad-carousel-item.exad-Progressbar-align-top .exad-dots-container .exad-swiper-pagination.swiper-pagination.swiper-pagination-progressbar' => 'top: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .exad-product-carousel-wrapper.exad-carousel-item.exad-Progressbar-align-bottom .exad-dots-container .exad-swiper-pagination.swiper-pagination.swiper-pagination-progressbar' => 'bottom: {{SIZE}}{{UNIT}};'
				]
			]
		);

        $this->add_responsive_control(
            'exad_product_related_carousel_nav_progressbar_height',
            [
                'label'      => __( 'Height', 'exclusive-addons-elementor-pro' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range'      => [
                    'px' => [
                        'min' => 0,
                        'max' => 10,
                    ],
                ],
                'default'    => [
                    'unit' => 'px',
                    'size' => 4,
                ],
                'selectors'  => [
                    '{{WRAPPER}} .exad-product-related .exad-dots-container .exad-swiper-pagination.swiper-pagination.swiper-pagination-progressbar' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

    }


	public function exad_related_product_title( $title ) {

		$settings = $this->get_settings();

		$title = $settings['exad_product_related_title_text'];

		return $title;

	}

    protected function render() {

        if ( !class_exists( 'woocommerce' ) ) {
            return;
        }

        do_action( 'exad_woo_builder_widget_before_render', $this );

		if ( ! post_type_supports( 'product', 'comments' ) ) {
			return;
		}

        $settings = $this->get_settings_for_display();
        $carousel_id    = 'exad-product-related-' . $this->get_id();

            $this->add_render_attribute( 'exad-product-related', 'id',  $carousel_id );
            $this->add_render_attribute( 'exad-product-related', 'class',  'exad-product-related' );
            
            // Carousel Settings
            $elementor_viewport_lg = get_option( 'elementor_viewport_lg' );
            $elementor_viewport_md = get_option( 'elementor_viewport_md' );
            $exad_viewport_lg     = !empty($elementor_viewport_lg) ? $elementor_viewport_lg - 1 : 1023;
            $exad_viewport_md     = !empty($elementor_viewport_md) ? $elementor_viewport_md - 1 : 767;
    
            if ( 'nav-dots' == $settings['exad_product_related_carousel_nav'] || 'arrows-dots' == $settings['exad_product_related_carousel_nav'] ) {
                $swiper_pagination_type = 'bullets';
            } elseif ( 'fraction' == $settings['exad_product_related_carousel_nav'] || 'arrows-fraction' == $settings['exad_product_related_carousel_nav'] ) {
                $swiper_pagination_type = 'fraction';
            } elseif ( 'progress-bar' == $settings['exad_product_related_carousel_nav'] || 'arrows-progress-bar' == $settings['exad_product_related_carousel_nav'] ) {
                $swiper_pagination_type = 'progressbar';
            } else {
                $swiper_pagination_type = '';
            }
       
        if ( "carousel-layout" == $settings['exad_product_related_content_setting_layout'] ) {

            $carousel_data_settings = wp_json_encode(
                array_filter([
                    "autoplay"           	=> $settings["exad_product_related_carousel_autoplay"] ? true : false,
                    "delay" 				=> $settings["exad_product_related_carousel_autoplay_speed"] ? true : false,
                    "loop"           		=> $settings["exad_product_related_carousel_loop"] ? true : false,
                    "speed"       			=> $settings["exad_product_related_carousel_transition_duration"],
                    "pauseOnHover"       	=> $settings["exad_product_related_carousel_pause"] ? true : false,
                    "slidesPerView"         => isset($settings["slider_per_view_mobile"]) ? (int)$settings["slider_per_view_mobile"] : 1,
                    "slidesPerColumn" 		=> ($settings["exad_product_related_carousel_slides_per_column"] > 1) ? $settings["exad_product_related_carousel_slides_per_column"] : false,
                    "centeredSlides"        => $settings["exad_product_related_carousel_slide_centered"] ? true : false,
                    "spaceBetween"   		=> $settings['exad_product_related_carousel_column_space']['size'],
                    "grabCursor"  			=> ($settings["exad_product_related_carousel_grab_cursor"] === "yes") ? true : false,
                    "observer"       		=> ($settings["exad_product_related_carousel_observer"]) ? true : false,
                    "observeParents" 		=> ($settings["exad_product_related_carousel_observer"]) ? true : false,
                    "breakpoints"     		=> [
    
                        (int) $exad_viewport_md 	=> [
                            "slidesPerView" 	=> isset($settings["slider_per_view_tablet"]) ? (int)$settings["slider_per_view_tablet"] : 2,
                            "spaceBetween"  	=> $settings["exad_product_related_carousel_column_space"]["size"],
                            "centeredSlides" => $settings["exad_product_related_carousel_slide_centered"] ? true : false,
                        ],
                        (int) $exad_viewport_lg 	=> [
                            "slidesPerView" 	=> (int)$settings["slider_per_view"],
                            "spaceBetween"  	=> $settings["exad_product_related_carousel_column_space"]["size"],
                            "centeredSlides" => $settings["exad_product_related_carousel_slide_centered"] ? false : true,
                        ]
                    ],
                    "pagination" 			 	=>  [ 
                        "el" 				=> "#". $carousel_id . " .exad-swiper-pagination",
                        "type"       		=> $swiper_pagination_type,
                        "clickable"  		=> true,
                    ],
                    "navigation" => [
                        "nextEl" => "#". $carousel_id . " .product-next",
                        "prevEl" => "#". $carousel_id . " .product-prev",
                    ],
    
                ])
            );
            
        $this->add_render_attribute( '_wrapper', 'class', esc_attr( $settings['exad_product_related_carousel_nav_fraction_alignment'] ) );
        if ( 'progress-bar' == $settings['exad_product_related_carousel_nav'] || 'arrows-progress-bar' == $settings['exad_product_related_carousel_nav']) {
            $this->add_render_attribute( '_wrapper', 'class', esc_attr( $settings['exad_product_related_carousel_nav_Progress_position'] ) );
        }

        // Carousel Settings end
    
         $this->add_render_attribute( 'exad-product-related', 'data-carousel',  $carousel_data_settings );

        }
              
		?>
		<div <?php echo $this->get_render_attribute_string( 'exad-product-related' ); ?>>

			<?php do_action( 'exad_woo_builder_widget_related_before_render' ); ?>

			<?php 
			global $product;

			$product = wc_get_product();

			if ( \Elementor\Plugin::instance()->editor->is_edit_mode() ) {
                add_filter( 'woocommerce_product_related_products_heading', [ $this, 'exad_related_product_title' ], 10, 2 );
				echo Woo_Preview_Data::instance()->default( $this->get_name() );
			} else {
				if ( empty( $product ) ) {
					return;
				}

                $args = [
					'posts_per_page' => 6,
					'columns' => 4,
					'orderby' => $settings['orderby'],
					'order' => $settings['order'],
				];
		
				if ( ! empty( $settings['posts_per_page'] ) ) {
					$args['posts_per_page'] = $settings['posts_per_page'];
				}
		
				if ( ! empty( $settings['columns'] ) ) {
					$args['columns'] = $settings['columns'];
				}

                add_filter( 'woocommerce_product_related_products_heading', [ $this, 'exad_related_product_title' ], 10, 2 );
				wc_set_loop_prop( 'columns', apply_filters( 'woocommerce_related_products_columns', $args['columns'] ) );
				
				// Get visible related products then sort them at random.
				$args['related_products'] = array_filter( array_map( 'wc_get_product', wc_get_related_products( $product->get_id(), $args['posts_per_page'], $product->get_upsell_ids() ) ), 'wc_products_array_filter_visible' );
		
				// Handle orderby.
				$args['related_products'] = wc_products_array_orderby( $args['related_products'], $args['orderby'], $args['order'] );
		
				wc_get_template( 'single-product/related.php', $args );
			} ?>

			<?php do_action( 'exad_woo_builder_widget_related_after_render' ); ?>

		</div>
	<?php
	}

}