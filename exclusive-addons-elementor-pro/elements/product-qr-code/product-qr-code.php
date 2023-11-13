<?php
namespace ExclusiveAddons\Elements;

if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.

use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Border;
use \Elementor\Group_Control_Box_Shadow;
use \Elementor\Group_Control_Typography;
use \Elementor\Widget_Base;
use \Elementor\Group_Control_Background;
use \ExclusiveAddons\Pro\Elementor\ProHelper;

class Product_QR_Code extends Widget_Base {

	public function get_name() {
		return 'exad-product-qr-code';
	}

	public function get_title() {
		return esc_html__( 'Product QR Code', 'exclusive-addons-elementor-pro' );
	}

	public function get_icon() {
		return 'exad exad-logo exad-woo-products';
	}

	public function get_categories() {
		return [ 'exclusive-addons-elementor' ];
	}

	public function get_keywords() {
	    return [ 'product qr', 'qr code' ];
	}

    protected function register_controls() {

        $exad_primary_color   = get_option( 'exad_primary_color_option', '#7a56ff' );

        if( ! class_exists( 'woocommerce' ) ) {
		    $this->start_controls_section(
			    'exad_panel_notice',
			    [
				    'label' => __('Notice!', 'exclusive-addons-elementor-pro'),
			    ]
		    );

		    $this->add_control(
			    'exad_panel_notice_text',
			    [
				    'type'            => Controls_Manager::RAW_HTML,
				    'raw'             => __('<strong>WooCommerce</strong> is not installed/activated on your site. Please install and activate <a href="plugin-install.php?s=wpcf7&tab=search&type=term" target="_blank">WooCommerce</a> first.',
					    'exclusive-addons-elementor-pro'),
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
            'exad_product_qr_code_content_section',
            [
                'label' => esc_html__( 'Content', 'exclusive-addons-elementor-pro' ),
            ]
		);

        $this->add_control(
			'exad_product_qr_code_before',
			[
				'label'       => esc_html__( 'Show Text Before QR Code', 'exclusive-addons-elementor-pro' ),
				'type'        => Controls_Manager::TEXTAREA
			]
        );

		$this->add_control(
			'exad_product_qr_code_after',
			[
				'label'       => esc_html__( 'Show Text After QR Code', 'exclusive-addons-elementor-pro' ),
				'type'        => Controls_Manager::TEXTAREA
			]
        );
        
        $this->add_control( 'exad_product_update_info',
            [
                'type'  => Controls_Manager::RAW_HTML,
                'raw'   => __( '<strong>product QR Code - </strong> Go to Style Tab ',
                        'exclusive-addons-elementor-pro' ),
                    'content_classes' => 'exad-panel-notice',
            ]
        );

        $this->end_controls_section();

        /*
		* product QR Code container Styling Section
		*/
        $this->start_controls_section(
            'exad_product_qr_code_container_style_section',
            [
                'label' => esc_html__( 'Container', 'exclusive-addons-elementor-pro' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
		);

		$this->add_responsive_control(
            'exad_product_qr_code_container_alignment',
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
                    '{{WRAPPER}} .exad-product-qr-code' => 'text-align: {{VALUE}};'
                ]
            ]
        );

        $this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'exad_product_qr_code_container_background',
				'types'    => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .exad-product-qr-code'
			]
		);

		$this->add_responsive_control(
			'exad_product_qr_code_container_padding',
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
					'{{WRAPPER}} .exad-product-qr-code' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
		);

		$this->add_responsive_control(
			'exad_product_qr_code_container_margin',
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
					'{{WRAPPER}} .exad-product-qr-code' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
        );

        $this->add_responsive_control(
			'exad_product_qr_code_container_radius',
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
					'{{WRAPPER}} .exad-product-qr-code' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'exad_product_qr_code_container_border',
				'selector' => '{{WRAPPER}} .exad-product-qr-code'
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'exad_product_qr_code_container_box_shadow',
				'selector' => '{{WRAPPER}} .exad-product-qr-code'
			]
		);

        $this->end_controls_section();

		/*
		* QR Code container Styling Section
		*/
        $this->start_controls_section(
            'exad_product_qr_code_container_box_style_section',
            [
                'label' => esc_html__( 'QR Image', 'exclusive-addons-elementor-pro' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );
	
        $this->add_responsive_control(
			'exad_product_qr_image_width',
			[
				'label' => __( 'Width', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range' => [
					'px' => [
						'min' 	=> 0,
						'max' 	=> 500,
						'step' 	=> 5,
					],
					'%' => [
						'min' 	=> 0,
						'max' 	=> 80,
					],
				],
				'default' 		=> [
					'unit' 		=> 'px',
					'size' 		=> 150,
				],
				'selectors' => [
					'{{WRAPPER}} .exad-product-qr-code .exad-product-qrcode-img img' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

        $this->add_control(
            'exad_product_qr_add_cart_url',
            [
                'label' => __( 'Enable Add to Cart URL', 'exclusive-addons-elementor-pro' ),
                'type' => Controls_Manager::SWITCHER,
                'return_value' => 'yes',
                'default' => 'no',
            ]
        );

        $this->add_control(
            'exad_product_qr_quantity',
            [
                'label' => __( 'Quantity', 'exclusive-addons-elementor-pro' ),
                'type' => Controls_Manager::NUMBER,
                'min' => 0,
                'max' => 1000,
                'step' => 1,
                'default' => 1,
                'condition'=>[
                    'exad_product_qr_add_cart_url'=>'yes',
                ],
            ]
        );

        $this->add_control(
            'eexad_product_qr_code_link_bg_color',
            [
                'label'     => esc_html__('Background Color', 'exclusive-addons-elementor-pro'),
                'type'      => Controls_Manager::COLOR,
                'separator' => 'before',
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .exad-product-qr-code .exad-product-qrcode-img img' => 'background: {{VALUE}};'
                ]
            ]
        );

        $this->add_responsive_control(
			'exad_product_qr_code_links_box_padding',
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
					'{{WRAPPER}} .exad-product-qr-code .exad-product-qrcode-img img' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
		);

        $this->add_responsive_control(
			'exad_product_qr_code_links_box_radius',
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
                    '{{WRAPPER}} .exad-product-qr-code .exad-product-qrcode-img img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'exad_product_qr_code_links_box_border',
				'selector' => '{{WRAPPER}} .exad-product-qr-code .exad-product-qrcode-img img',
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'exad_product_qr_code_links_box_shadow',
				'selector' => '{{WRAPPER}} .exad-product-qr-code .exad-product-qrcode-img img'
			]
		);


        $this->end_controls_section();

		/*
		* Before & After QR Code Styling Section
		*/
		$this->start_controls_section(
            'exad_product_qr_code_before_after_style_section',
            [
                'label' => esc_html__( 'Before & After Style', 'exclusive-addons-elementor-pro' ),
				'tab'   => Controls_Manager::TAB_STYLE
            ]
        );

		$this->add_control(
			'exad_product_qr_code_before_style',
			[
				'label'     => __( 'Before QR Code', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before'
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'exad_product_qr_code_before_typography',
				'selector' => '{{WRAPPER}} .exad-product-qr-code .product-qr-code-before',
			]
		);

		$this->add_control(
			'exad_product_qr_code_before_color',
			[
				'label'     => __( 'Color', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#333333',
				'selectors' => [
					'{{WRAPPER}} .exad-product-qr-code .product-qr-code-before' => 'color: {{VALUE}};'
				]
			]
		);

		$this->add_responsive_control(
			'exad_product_qr_code_before_margin',
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
					'{{WRAPPER}} .exad-product-qr-code .product-qr-code-before' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
		);

        $this->add_control(
			'exad_product_qr_code_after_style',
			[
				'label'     => __( 'After QR Code', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before'
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'exad_product_qr_code_after_typography',
				'selector' => '{{WRAPPER}} .exad-product-qr-code .product-qr-code-after',
			]
		);

		$this->add_control(
			'exad_product_qr_code_after_color',
			[
				'label'     => __( 'Color', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#333333',
				'selectors' => [
					'{{WRAPPER}} .exad-product-qr-code .product-qr-code-after' => 'color: {{VALUE}};'
				]
			]
		);

		$this->add_responsive_control(
			'exad_product_qr_code_after_margin',
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
					'{{WRAPPER}} .exad-product-qr-code .product-qr-code-after' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
		);
		$this-> end_controls_section();

    }

    protected function render() {
        if( ! class_exists('woocommerce') ) {
            return;
        }

        $settings = $this->get_settings_for_display();
        ?>

        <div class="exad-product-qr-code">

            <?php do_action( 'exad_woo_builder_widget_product_qr_before_render' ); ?>

                <?php if ( ! empty( $settings['exad_product_qr_code_before'] ) ) : ?>
                    <p class="product-qr-code-before" ><?php echo wp_kses_post( $settings['exad_product_qr_code_before'] );?></p>
                <?php endif; ?>

                <?php 
                    global $product;

                    $product = wc_get_product();

                    $this->add_render_attribute( 'exad_area_attr', 'class', 'exad-product-qrcode-img' );

                    if ( \Elementor\Plugin::instance()->editor->is_edit_mode() ) {
                        $product_id = ProHelper::exad_product_get_last_product_id();
                    } else{
                        $product_id = get_the_ID();
                    }
            
                    $quantity = ( !empty( $settings['exad_product_qr_quantity'] ) ? $settings['exad_product_qr_quantity'] : 1 );
                    if( $settings['exad_product_qr_add_cart_url'] == 'yes' ){
                        $url = get_the_permalink( $product_id ).sprintf('?add-to-cart=%s&quantity=%s',$product_id, $quantity );
                    }else{
                        $url = get_the_permalink( $product_id );
                    }
            
                    $title = get_the_title( $product_id );
                    $product_url   = urlencode( $url );
            
                    $size    = ( !empty( $settings['exad_product_qr_image_width']['size'] ) ? $settings['exad_product_qr_image_width']['size'] : 120 );
                    $dimension = $size.'x'.$size;
            
                    $image_src = sprintf( 'https://api.qrserver.com/v1/create-qr-code/?size=%s&ecc=L&qzone=1&data=%s', $dimension, $product_url );

                ?>

                    <div <?php echo $this->get_render_attribute_string( 'exad_area_attr' ); ?> >
                        <?php
                            echo sprintf('<img src="%1$s" alt="%2$s">', $image_src, $title );
                        ?>
                    </div>

                <?php if ( ! empty( $settings['exad_product_qr_code_after'] ) ) : ?>
                    <p class="product-qr-code-after" ><?php echo wp_kses_post( $settings['exad_product_qr_code_after'] );?></p>
                <?php endif; ?>	

            <?php do_action( 'exad_woo_builder_widget_product_qr_after_render' ); ?>

        </div>

        <?php
    }
}