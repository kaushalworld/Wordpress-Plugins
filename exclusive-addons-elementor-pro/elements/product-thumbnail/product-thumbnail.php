<?php
namespace ExclusiveAddons\Elements;

if ( !defined( 'ABSPATH' ) ) {
    exit;
}
// If this file is called directly, abort.

use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Typography;
use \Elementor\Group_Control_Background;
use \Elementor\Group_Control_Image_Size;
use \Elementor\Group_Control_Border;
use \Elementor\Group_Control_Box_Shadow;
use \Elementor\Widget_Base;
use \ExclusiveAddons\Pro\Includes\WooBuilder\Woo_Preview_Data;

class Product_Image extends Widget_Base {

    public function get_name() {
        return 'exad-product-image';
    }

    public function get_title() {
        return esc_html__( 'Product Image', 'exclusive-addons-elementor-pro' );
    }

    public function get_icon() {
        return 'exad exad-logo exad-woo-products';
    }

    public function get_categories() {
        return ['exclusive-addons-elementor'];
    }

    public function get_keywords() {
        return ['product image', 'woocommerce', 'image', 'single product image', 'woo product image'];
    }

    public function get_script_depends() {
		return [ 'swiper', 'flexslider', 'zoom', 'wc-single-product' ];
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
         * Content Section
         */
        $this->start_controls_section(
            'exad_product_title_content_section',
            [
                'label' => esc_html__( 'Content', 'exclusive-addons-elementor-pro' ),
            ]
        );

            
		$this->add_control(
            'exad_product_thumb_view_style',
            [
                'label'   => esc_html__( 'Thumbnail View', 'exclusive-addons-elementor-pro' ),
                'type'    => Controls_Manager::SELECT,
                'default' => 'default',
                'prefix_class' => 'exad-product-thumb-view-',
                'options' => [
					'default'   => esc_html__( 'Default', 'exclusive-addons-elementor-pro' ),
					'carousel'  => esc_html__( 'Carousel', 'exclusive-addons-elementor-pro' )                    
                ]
            ]
        );

		$this->add_control(
			'exad_product_image_before',
			[
				'label'       => esc_html__( 'Before Gallery', 'exclusive-addons-elementor-pro' ),
				'type'        => Controls_Manager::TEXTAREA
			]
        );

		$this->add_control(
			'exad_product_image_after',
			[
				'label'       => esc_html__( 'After Gallery', 'exclusive-addons-elementor-pro' ),
				'type'        => Controls_Manager::TEXTAREA
			]
        );
        
        $this->add_control(
            'exad_product_image_content_update',
            [
                'label' => '<div class="elementor-update-preview" style="display: block;"><div class="elementor-update-preview-button-wrapper" style="display:block;"><button class="elementor-update-preview-button elementor-button elementor-button-success" style="background: #d30c5c; margin: 0 auto; display:block;">Apply Changes</button></div><div class="elementor-update-preview-title" style="display:block;text-align:center;margin-top: 10px;">'. __( 'Hit the button to apply changes if it hasn\'t already.', 'exclusive-addons-elementor-pro' ) .'</div></div>',
                'type' => Controls_Manager::RAW_HTML,
				'separator'  => 'before',
            ]
        );

        $this->end_controls_section();

        /**
  		* Carousel Setting Content Tab
  		*/
          $this->start_controls_section(
			'exad_section_carousel_settings',
			[
				'label' => esc_html__( 'Carousel Settings', 'exclusive-addons-elementor-pro' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$slides_per_view = range( 1, 6 );
		$slides_per_view = array_combine( $slides_per_view, $slides_per_view );

		$this->add_control(
            'exad_product_thumb_carousel_position',
            [
                'label'   => esc_html__( 'Slider Position', 'exclusive-addons-elementor-pro' ),
                'type'    => Controls_Manager::SELECT,
                'default' => 'horizontal',
                'options' => [
					'horizontal'   => esc_html__( 'Horizontal', 'exclusive-addons-elementor-pro' ),
					'vertical' => esc_html__( 'Vertical', 'exclusive-addons-elementor-pro' ),   
                ]
            ]
        );

		$this->add_responsive_control(
			'exad_product_thumb_slider_per_view',
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
			'exad_product_thumb_column_space',
			[
				'label' => __( 'Item Space', 'exclusive-addons-elementor-pro' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 5
			]
		);

		$this->add_control(
			'exad_product_thumb_slides_to_scroll',
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
			'exad_product_thumb_transition_duration',
			[
				'label'   => esc_html__( 'Transition Duration', 'exclusive-addons-elementor-pro' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 1000
			]
		);

		$this->add_control(
			'exad_product_thumb_autoplay',
			[
				'label'     => esc_html__( 'Autoplay', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::SWITCHER,
				'default'   => 'yes'
			]
		);
        
		$this->add_control(
            'exad_product_thumb_nav',
            [
                'label'   => esc_html__( 'Navigation Style', 'exclusive-addons-elementor-pro' ),
                'type'    => Controls_Manager::SELECT,
                'default' => 'arrows',
                'options' => [
					'arrows'   => esc_html__( 'Arrows', 'exclusive-addons-elementor-pro' ),
					'none'     => esc_html__( 'None', 'exclusive-addons-elementor-pro' )                    
                ]
            ]
        );

		$this->end_controls_section();

        /**
         * Style Section
         */

        /*
		* Image container Styling Section
		*/
        $this->start_controls_section(
            'exad_product_image_container_style_section',
            [
                'label' => esc_html__( 'Container', 'exclusive-addons-elementor-pro' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'exad_product_image_container_background',
				'types'    => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .exad-product-image'
			]
		);

		$this->add_responsive_control(
			'exad_product_image_container_padding',
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
					'{{WRAPPER}} .exad-product-image' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
		);

		$this->add_responsive_control(
			'exad_product_image_container_margin',
			[
				'label'        => __( 'Margin', 'exclusive-addons-elementor-pro' ),
				'type'         => Controls_Manager::DIMENSIONS,
				'size_units'   => [ 'px', '%' ],
				'default'      => [
					'top'      => '0',
					'right'    => '0',
					'bottom'   => '0',
					'left'     => '0',
					'unit'     => 'px',
					'isLinked' => false
				],
				'selectors'    => [
					'{{WRAPPER}} .exad-product-image' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
        );

        $this->add_responsive_control(
			'exad_product_image_container_radius',
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
					'{{WRAPPER}} .exad-product-image' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'       => 'exad_product_image_container_border',
				'selector'   => '{{WRAPPER}} .exad-product-image'
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'exad_product_image_container_box_shadow',
				'selector' => '{{WRAPPER}} .exad-product-image'
			]
		);

        $this->end_controls_section();

        /*
		* Image Styling Section
		*/
        $this->start_controls_section(
            'exad_product_image_style_section',
            [
                'label' => esc_html__( 'Image Style', 'exclusive-addons-elementor-pro' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'exad_product_image_enable_sale_flash',
            [
                'label'        => __( 'Enable Sale Flash', 'exclusive-addons-elementor-pro' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => __( 'Show', 'exclusive-addons-elementor-pro' ),
                'label_off'    => __( 'Hide', 'exclusive-addons-elementor-pro' ),
                'return_value' => 'yes',
                'default'      => 'yes',
            ]
        );

        $this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' 		=> 'exad_product_image_border',
				'label' 	=> __( 'Border', 'exclusive-addons-elementor-pro' ),
				'selector' 	=> '{{WRAPPER}} .exad-product-image .images img.wp-post-image',
			]
        );
        
        $this->add_responsive_control(
            'exad_product_image_border_radius',
            [
                'label'         => __( 'Border Radius', 'exclusive-addons-elementor-pro' ),
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
                    '{{WRAPPER}} .exad-product-image .images img.wp-post-image' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' 		=> 'exad_product_image_box_shadow',
				'label' 	=> __( 'Box Shadow', 'exclusive-addons-elementor-pro' ),
				'selector' 	=> '{{WRAPPER}} .exad-product-image .images img.wp-post-image',
			]
		);

        $this->end_controls_section();

        /*
		* Product Image sale Styling Section
		*/
		$this->start_controls_section(
            'exad_product_image_sale_style',
            [
                'label'     => __( 'Sale Tags', 'exclusive-addons-elementor-pro' ),
                'tab'       => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_responsive_control(
            'exad_product_image_sale_tag_left_position',
            [
                'label'         => esc_html__('Horizontal Position', 'exclusive-addons-elementor-pro' ),
                'type'          => Controls_Manager::SLIDER,
                'default'       => [
                    'size'      => 20,
                    'unit'      => 'px'
                ],               
                'range'         => [
                    'px'        => [
                        'min'   => 0,
                        'max'   => 100,
                        'step'  => 5
                    ]
                ],
                'selectors'     => [
                    '.woocommerce {{WRAPPER}} .exad-product-image span.onsale' => 'left: {{SIZE}}{{UNIT}};'
                ],   
            ]
        );  

        $this->add_responsive_control(
            'exad_product_image_sale_tag_top_position',
            [
                'label'         => esc_html__('Vertical Position', 'exclusive-addons-elementor-pro' ),
                'type'          => Controls_Manager::SLIDER,
                'default'       => [
                    'size'      => 20,
                    'unit'      => 'px'
                ],               
                'range'         => [
                    'px'        => [
                        'min'   => 0,
                        'max'   => 100,
                        'step'  => 5
                    ]
                ],
                'selectors'     => [
                    '.woocommerce {{WRAPPER}} .exad-product-image span.onsale' => 'top: {{SIZE}}{{UNIT}};'
                ],   
            ]
        );  

        $this->add_responsive_control(
            'exad_product_image_sale_height',
            [
                'label'         => esc_html__('Sale Height', 'exclusive-addons-elementor-pro' ),
                'type'          => Controls_Manager::SLIDER,
                'selectors'     => [
                    '.woocommerce {{WRAPPER}} .exad-product-image span.onsale' => 'min-height: {{SIZE}}{{UNIT}}; line-height: {{SIZE}}{{UNIT}};'
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
            'exad_product_image_sale_tag_padding',
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
                        '.woocommerce {{WRAPPER}} .exad-product-image span.onsale' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->add_responsive_control(
            'exad_product_image_sale_tag_border_radius',
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
                    '.woocommerce {{WRAPPER}} .exad-product-image span.onsale' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->add_control(
            'exad_product_image_sale_tag_style',
            [
                'label'         => esc_html__( 'Sale Tag', 'exclusive-addons-elementor-pro' ),
                'type'          => Controls_Manager::HEADING
            ]
        );

        $this->add_control(
            'exad_product_image_sale_tag_color',
            [
                'label'     => esc_html__( 'Color', 'exclusive-addons-elementor-pro' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#ffffff',
                'selectors' => [
                    '.woocommerce {{WRAPPER}} .exad-product-image span.onsale' => 'color: {{VALUE}};'
                ]
            ]
        );

        $this->add_control(
            'exad_product_image_sale_tag_bg_color',
            [
                'label'     => esc_html__( 'Background Color', 'exclusive-addons-elementor-pro' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => $exad_primary_color,
                'selectors' => [
                    '.woocommerce {{WRAPPER}} .exad-product-image span.onsale' => 'background-color: {{VALUE}};'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'      => 'exad_product_image_sale_shadow',
                'selector'  => '.woocommerce {{WRAPPER}} .exad-product-image span.onsale'        
            ]
        );

        $this->end_controls_section();

        /**
         * Thumbnail Style Section
         */

        $this->start_controls_section(
            'exad_product_image_thumbnail_style',
            [
                'label' => esc_html__( 'Thumbnail Style', 'exclusive-addons-elementor-pro' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'exad_product_image_thumbnail_alignment',
            [
                'label'         => esc_html__( 'Alignment', 'exclusive-addons-elementor-pro' ),
                'type'          => Controls_Manager::CHOOSE,
                'default'       => 'left',
                'prefix_class'  => 'exad-product-thumb-verticle-',
                'toggle'        => false,
                'options'       => [
                    'left' => [
                        'title'  => esc_html__( 'Left', 'exclusive-addons-elementor-pro' ),
                        'icon'   => 'eicon-h-align-left'
                    ],
                    'right'   => [
                        'title'  => esc_html__( 'Right', 'exclusive-addons-elementor-pro' ),
                        'icon'   => 'eicon-h-align-right'
                    ]
                ],
                'condition'   => [
					'exad_product_thumb_carousel_position' => 'vertical'
				],
                'selectors_dictionary' => [
                    'left'      => 'flex-direction: row-reverse;',
					'right'     => 'flex-direction: row;',
                ],
                'selectors'     => [
                    '{{WRAPPER}} .exad-product-image .woocommerce-product-gallery' => '{{VALUE}};'
                ]
            ]
        );

		$this->add_responsive_control(
			'exad_product_image_thumbnail_height',
			[
				'label' => __( 'Container Height', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range' => [
					'px' => [
						'min' 	=> 0,
						'max' 	=> 300,
						'step' 	=> 5,
					],
					'%' => [
						'min' 	=> 0,
						'max' 	=> 100,
					],
				],
				'default' 		=> [
					'unit' 		=> 'px',
					'size' 		=> 200,
				],
                'condition'   => [
					'exad_product_thumb_carousel_position' => 'vertical'
				],
				'selectors' => [
					'{{WRAPPER}} .exad-product-image.thumbnails-gallery-align-left .gallery-thumb-swiper.swiper-container.swiper-container-vertical' => 'height: {{SIZE}}{{UNIT}} !important;',
				],
			]
		);


        $this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' 		=> 'exad_product_image_thumbnail_border',
				'label' 	=> __( 'Border', 'exclusive-addons-elementor-pro' ),
				'selector' 	=> '{{WRAPPER}} .exad-product-image .images .flex-control-thumbs li img',
			]
        );
        
        $this->add_responsive_control(
            'exad_product_image_thumbnail_border_radius',
            [
                'label'         => __( 'Border Radius', 'exclusive-addons-elementor-pro' ),
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
                    '{{WRAPPER}} .exad-product-image .images .flex-control-thumbs li img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' 		=> 'exad_product_image_thumbnail_box_shadow',
				'label' 	=> __( 'Box Shadow', 'exclusive-addons-elementor-pro' ),
				'selector' 	=> '{{WRAPPER}} .exad-product-image .images .flex-control-thumbs li img',
			]
		);

        $this->end_controls_section();

		/**
		 * Style Tab Arrows Style
		 */
		$this->start_controls_section(
            'exad_product_image_thumbnail_carousel_nav_arrow',
            [
                'label'     => esc_html__( 'Arrows', 'exclusive-addons-elementor-pro' ),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition'   => [
					'exad_product_thumb_nav' => 'arrows'
				],
            ]
        );

        $this->add_responsive_control(
            'exad_product_image_thumbnail_carousel_nav_arrow_box_size',
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
                    'size' => 30,
                ],
                'selectors'  => [
                    '{{WRAPPER}} .exad-product-image.thumbnails-gallery-align-left .woocommerce-product-gallery .thumb-prev' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .exad-product-image.thumbnails-gallery-align-left .woocommerce-product-gallery .thumb-next' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'exad_product_image_thumbnail_carousel_nav_arrow_icon_size',
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
                    'size' => 14,
                ],
                'selectors'  => [
                    '{{WRAPPER}} .exad-product-image.thumbnails-gallery-align-left .woocommerce-product-gallery .thumb-prev svg' => 'font-size: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .exad-product-image.thumbnails-gallery-align-left .woocommerce-product-gallery .thumb-next svg' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        
        $this->add_control(
            'exad_product_image_thumbnail_carousel_prev_arrow_position',
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

        // vertical carousel
            $this->add_responsive_control(
                'exad_product_image_thumbnail_carousel_prev_arrow_position_x_offset',
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
                        'size' => 13,
                    ],
                    'condition'   => [
                        'exad_product_thumb_carousel_position' => 'vertical'
                    ],
                    'selectors'  => [
                        '{{WRAPPER}} .exad-product-image.thumbnails-gallery-align-left .woocommerce-product-gallery .thumb-prev' => 'left: {{SIZE}}{{UNIT}};',
                    ],
                ]
            );

            $this->add_responsive_control(
                'exad_product_image_thumbnail_carousel_prev_arrow_position_y_offset',
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
                        'size' => 27,
                    ],
                    'condition'   => [
                        'exad_product_thumb_carousel_position' => 'vertical'
                    ],
                    'selectors'  => [
                        '{{WRAPPER}} .exad-product-image.thumbnails-gallery-align-left .woocommerce-product-gallery .thumb-prev' => 'bottom: {{SIZE}}{{UNIT}};',
                    ],
                ]
            );    

            // horizontal carousel
             $this->add_responsive_control(
                'exad_product_image_thumbnail_carousel_horizontal_prev_arrow_position_x_offset',
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
                        'size' => -15,
                    ],
                    'condition'   => [
                        'exad_product_thumb_carousel_position' => 'horizontal'
                    ],
                    'selectors'  => [
                        '{{WRAPPER}} .exad-product-image.thumbnails-gallery-align-bottom .woocommerce-product-gallery .thumb-prev' => 'left: {{SIZE}}{{UNIT}};',
                    ],
                ]
            );

            $this->add_responsive_control(
                'exad_product_image_thumbnail_carousel_horizontal_prev_arrow_position_y_offset',
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
                        'size' => 15,
                    ],
                    'condition'   => [
                        'exad_product_thumb_carousel_position' => 'horizontal'
                    ],
                    'selectors'  => [
                        '{{WRAPPER}} .exad-product-image.thumbnails-gallery-align-bottom .woocommerce-product-gallery .thumb-prev' => 'bottom: {{SIZE}}{{UNIT}};',
                    ],
                ]
            );

        $this->end_popover();

        $this->add_control(
            'exad_product_image_thumbnail_carousel_next_arrow_position',
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
            //vertical carousel
            $this->add_responsive_control(
                'exad_product_image_thumbnail_carousel_next_arrow_position_x_offset',
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
                    'condition'   => [
                        'exad_product_thumb_carousel_position' => 'vertical'
                    ],
                    'selectors'  => [
                        '{{WRAPPER}} .exad-product-image.thumbnails-gallery-align-left .woocommerce-product-gallery .thumb-next' => 'right: {{SIZE}}{{UNIT}};',
                    ],
                ]
            );

            $this->add_responsive_control(
                'exad_product_image_thumbnail_carousel_next_arrow_position_y_offset',
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
                        'size' => 27,
                    ],
                    'condition'   => [
                        'exad_product_thumb_carousel_position' => 'vertical'
                    ],
                    'selectors'  => [
                        '{{WRAPPER}} .exad-product-image.thumbnails-gallery-align-left .woocommerce-product-gallery .thumb-next' => 'top: {{SIZE}}{{UNIT}};',
                    ],
                ]
            );

            //horizontal carousel
            $this->add_responsive_control(
                'exad_product_image_thumbnail_carousel_horizontal_next_arrow_position_x_offset',
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
                        'size' => -9,
                    ],
                    'condition'   => [
                        'exad_product_thumb_carousel_position' => 'horizontal'
                    ],
                    'selectors'  => [
                        '{{WRAPPER}} .exad-product-image.thumbnails-gallery-align-bottom .woocommerce-product-gallery .thumb-next' => 'right: {{SIZE}}{{UNIT}};',
                    ],
                ]
            );

            $this->add_responsive_control(
                'exad_product_image_thumbnail_carousel_horizontal_next_arrow_position_y_offset',
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
                        'size' => 15,
                    ],
                    'condition'   => [
                        'exad_product_thumb_carousel_position' => 'horizontal'
                    ],
                    'selectors'  => [
                        '{{WRAPPER}} .exad-product-image.thumbnails-gallery-align-bottom .woocommerce-product-gallery .thumb-next' => 'bottom: {{SIZE}}{{UNIT}};',
                    ],
                ]
            );

        $this->end_popover();

        $this->add_responsive_control(
            'exad_product_image_thumbnail_carousel_nav_arrow_radius',
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
                    '{{WRAPPER}} .exad-product-image.thumbnails-gallery-align-left .woocommerce-product-gallery .thumb-prev' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .exad-product-image.thumbnails-gallery-align-left .woocommerce-product-gallery .thumb-next' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs( 'exad_product_image_thumbnail_carousel_nav_arrow_tabs' );

			// normal state rating
			$this->start_controls_tab( 'exad_product_image_thumbnail_carousel_nav_arrow_normal', [ 'label' => esc_html__( 'Normal', 'exclusive-addons-elementor-pro' ) ] );

                $this->add_control(
                    'exad_product_image_thumbnail_carousel_arrow_normal_background',
                    [
                        'label'     => __( 'Background Color', 'exclusive-addons-elementor-pro' ),
                        'type'      => Controls_Manager::COLOR,
                        'default'   =>  $exad_primary_color,
                        'selectors' => [
                            '{{WRAPPER}} .exad-product-image.thumbnails-gallery-align-left .woocommerce-product-gallery .thumb-prev' => 'background: {{VALUE}}',
                            '{{WRAPPER}} .exad-product-image.thumbnails-gallery-align-left .woocommerce-product-gallery .thumb-next' => 'background: {{VALUE}}',
                        ],
                    ]
                );

                $this->add_control(
                    'exad_product_image_thumbnail_carousel_arrow_normal_color',
                    [
                        'label'     => __( 'Icon Color', 'exclusive-addons-elementor-pro' ),
                        'type'      => Controls_Manager::COLOR,
                        'default'   => '#ffffff',
                        'selectors' => [
                            '{{WRAPPER}} .exad-product-image.thumbnails-gallery-align-left .woocommerce-product-gallery .thumb-prev svg' => 'color: {{VALUE}};',
                            '{{WRAPPER}} .exad-product-image.thumbnails-gallery-align-left .woocommerce-product-gallery .thumb-next svg' => 'color: {{VALUE}};',
                        ],
                    ]
                );

                $this->add_group_control(
                    Group_Control_Border::get_type(),
                    [
                        'name'     => 'exad_product_image_thumbnail_carousel_arrow_normal_border',
                        'label'    => __( 'Border', 'exclusive-addons-elementor-pro' ),
                        'selector' => '{{WRAPPER}} .exad-product-image.thumbnails-gallery-align-left .woocommerce-product-gallery .thumb-prev, {{WRAPPER}} .exad-product-image.thumbnails-gallery-align-left .woocommerce-product-gallery .thumb-next',
                    ]
                );

                $this->add_group_control(
                    Group_Control_Box_Shadow::get_type(),
                    [
                        'name'     => 'exad_product_image_thumbnail_carousel_arrow_normal_shadow',
                        'label'    => __( 'Box Shadow', 'exclusive-addons-elementor-pro' ),
                        'selector' => '{{WRAPPER}} .exad-product-image.thumbnails-gallery-align-left .woocommerce-product-gallery .thumb-prev, {{WRAPPER}} .exad-product-image.thumbnails-gallery-align-left .woocommerce-product-gallery .thumb-next',
                    ]
                );

			$this->end_controls_tab();

			// hover state rating
			$this->start_controls_tab( 'exad_product_image_thumbnail_carousel_nav_arrow_hover', [ 'label' => esc_html__( 'Hover', 'exclusive-addons-elementor-pro' ) ] );

                $this->add_control(
                    'exad_product_image_thumbnail_carousel_arrow_hover_background',
                    [
                        'label'     => __( 'Background Color', 'exclusive-addons-elementor-pro' ),
                        'type'      => Controls_Manager::COLOR,
                        'default'   => $exad_primary_color,
                        'selectors' => [
                            '{{WRAPPER}} .exad-product-image.thumbnails-gallery-align-left .woocommerce-product-gallery .thumb-prev:hover' => 'background: {{VALUE}}',
                            '{{WRAPPER}} .exad-product-image.thumbnails-gallery-align-left .woocommerce-product-gallery .thumb-next:hover' => 'background: {{VALUE}}',
                        ],
                    ]
                );

                $this->add_control(
                    'exad_product_image_thumbnail_carousel_arrow_hover_color',
                    [
                        'label'     => __( 'Icon Color', 'exclusive-addons-elementor-pro' ),
                        'type'      => Controls_Manager::COLOR,
                        'default'   => '#ffffff',
                        'selectors' => [
                            '{{WRAPPER}} .exad-product-image.thumbnails-gallery-align-left .woocommerce-product-gallery .thumb-prev:hover svg' => 'color: {{VALUE}}',
                            '{{WRAPPER}} .exad-product-image.thumbnails-gallery-align-left .woocommerce-product-gallery .thumb-next:hover svg' => 'color: {{VALUE}}',
                        ],
                    ]
                );

                $this->add_group_control(
                    Group_Control_Border::get_type(),
                    [
                        'name'     => 'exad_product_image_thumbnail_carousel_arrow_hover_border',
                        'label'    => __( 'Border', 'exclusive-addons-elementor-pro' ),
                        'selector' => '{{WRAPPER}} .exad-product-image.thumbnails-gallery-align-left .woocommerce-product-gallery .thumb-prev:hover, {{WRAPPER}} .exad-product-image.thumbnails-gallery-align-left .woocommerce-product-gallery .thumb-next:hover',
                    ]
                );

                $this->add_group_control(
                    Group_Control_Box_Shadow::get_type(),
                    [
                        'name'     => 'exad_product_image_thumbnail_carousel_arrow_hover_shadow',
                        'label'    => __( 'Box Shadow', 'exclusive-addons-elementor-pro' ),
                        'selector' => '{{WRAPPER}} .exad-product-image.thumbnails-gallery-align-left .woocommerce-product-gallery .thumb-prev:hover, {{WRAPPER}} .exad-product-image.thumbnails-gallery-align-left .woocommerce-product-gallery .thumb-next:hover',
                    ]
                );

			$this->end_controls_tab();

        $this->end_controls_tabs();

		$this->end_controls_section();

		/*
		* Before & After image Styling Section
		*/
		$this->start_controls_section(
            'exad_product_image_before_after_style_section',
            [
                'label' => esc_html__( 'Before & After Style', 'exclusive-addons-elementor-pro' ),
				'tab'   => Controls_Manager::TAB_STYLE
            ]
        );

		$this->add_control(
			'exad_product_image_before_style',
			[
				'label'     => __( 'Show Text Before Gallery', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before'
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'             => 'exad_product_image_before_typography',
				'selector'         => '{{WRAPPER}} .product-image-before',
				'fields_options'   => [
					'font_size'    => [
		                'default'  => [
		                    'unit' => 'px',
		                    'size' => 14
		                ]
		            ],
		            'font_weight'  => [
		                'default'  => '600'
		            ]
	            ]
			]
		);

		$this->add_control(
			'exad_product_image_before_color',
			[
				'label'     => __( 'Color', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#333333',
				'selectors' => [
					'{{WRAPPER}} .product-image-before' => 'color: {{VALUE}};'
				]
			]
		);

		$this->add_responsive_control(
			'exad_product_image_before_margin',
			[
				'label'      => __( 'Margin', 'exclusive-addons-elementor-pro' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'default'    => [
					'top'    => '0',
					'right'  => '0',
					'bottom' => '0',
					'left'   => '0',
                    'isLinked' => false
				],
				'selectors'  => [
					'{{WRAPPER}} .product-image-before' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
		);

        $this->add_control(
			'exad_product_image_after_style',
			[
				'label'     => __( 'Show Text After Gallery', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before'
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'             => 'exad_product_image_after_typography',
				'selector'         => '{{WRAPPER}} .product-image-after',
				'fields_options'   => [
					'font_size'    => [
		                'default'  => [
		                    'unit' => 'px',
		                    'size' => 14
		                ]
		            ],
		            'font_weight'  => [
		                'default'  => '600'
		            ]
	            ]
			]
		);

		$this->add_control(
			'exad_product_image_after_color',
			[
				'label'     => __( 'Color', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#333333',
				'selectors' => [
					'{{WRAPPER}} .product-image-after' => 'color: {{VALUE}};'
				]
			]
		);

		$this->add_responsive_control(
			'exad_product_image_after_margin',
			[
				'label'      => __( 'Margin', 'exclusive-addons-elementor-pro' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'default'    => [
					'top'    => '0',
					'right'  => '0',
					'bottom' => '0',
					'left'   => '0',
                    'isLinked' => false
				],
				'selectors'  => [
					'{{WRAPPER}} .product-image-after' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
		);
		$this-> end_controls_section();
		
    }

    protected function render() {

        do_action( 'exad_woo_builder_widget_before_render', $this );
        
        if ( !class_exists( 'woocommerce' ) ) {
            return;
        }

        $settings = $this->get_settings_for_display();

        $this->add_render_attribute( 'exad-product-image', 'class',  'exad-product-image');

        $render_class = '';
        if ( $settings['exad_product_thumb_carousel_position'] == 'vertical' ) {
         $render_class .= "thumbnails-gallery-align-left";
        } else  {
         $render_class .= "thumbnails-gallery-align-bottom";
        }
 
        $this->add_render_attribute( 'exad-product-image', 'class',  $render_class );
        
        if ( "carousel" === $settings['exad_product_thumb_view_style'] ) {
            $carousel_data_settings = wp_json_encode(
                array_filter([
                    'slidesPerView'  => $settings['exad_product_thumb_slider_per_view'],
                    'spaceBetween'   => $settings['exad_product_thumb_column_space'],
                    'speed'          => $settings['exad_product_thumb_transition_duration'],
                    'centeredSlides' => true,
                    'direction'      => $settings['exad_product_thumb_carousel_position'],
                    "autoplay"       => ( $settings["exad_product_thumb_autoplay"]  == "yes" ) ? true : false,
                    "loop"           => false,
                    "arrows"         => ( $settings["exad_product_thumb_nav"] == "arrows" ) ? true : false,
                    "navigation" => [
                        "nextEl" => ".thumb-next",
                        "prevEl" => ".thumb-prev",
                    ],
                    ])
                );
    
           $this->add_render_attribute( 'exad-product-image', 'data-carousel_type',  $carousel_data_settings );

        }

	
        ?>

		<?php if ( ! empty( $settings['exad_product_image_before'] ) ) : ?>
            <p class="product-image-before" ><?php echo wp_kses_post( $settings['exad_product_image_before'] );?></p>
        <?php endif; ?>

		<div <?php echo $this->get_render_attribute_string( 'exad-product-image' ); ?>>

            <?php

            do_action( 'exad_woo_builder_widget_image_gallery_before_render', $this );
            global $product;

            $product = wc_get_product();

            if ( \Elementor\Plugin::instance()->editor->is_edit_mode() ) {
         
                echo Woo_Preview_Data::instance()->default( $this->get_name() ); 
                wp_enqueue_script('swiper');
                ?>
                <script>
                    jQuery( '.woocommerce-product-gallery' ).each( function () {
                        jQuery( this ).wc_product_gallery();
                    } );
                </script>
            <?php
            } else {
                if ( empty( $product ) ) {
                    return;
                }
                
                if ( 'yes' === $settings['exad_product_image_enable_sale_flash'] ) {
                    wc_get_template( 'loop/sale-flash.php' );
                }
                wc_get_template( 'single-product/product-image.php' );

                // On render widget from Editor - trigger the init manually.
                if ( wp_doing_ajax() ) {
                    ?>
                    <script>
                        jQuery( '.woocommerce-product-gallery' ).each( function() {
                            jQuery( this ).wc_product_gallery();
                        } );
                    </script>
                    <?php
                }
            }
            do_action( 'exad_woo_builder_widget_image_gallery_after_render', $this ); ?>
		</div>
		<?php if ( ! empty( $settings['exad_product_image_after'] ) ) : ?>
            <p class="product-image-after" ><?php echo wp_kses_post( $settings['exad_product_image_after'] );?></p>
        <?php endif; ?>
		
        <?php

    }
}