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
use Elementor\Plugin;
use \ExclusiveAddons\Pro\Includes\WooBuilder\Woo_Preview_Data;

class Product_Price extends Widget_Base {

	public function get_name() {
		return 'exad-product-price';
	}

	public function get_title() {
		return __( 'Product Price', 'exclusive-addons-elementor-pro' );
	}

	public function get_icon() {
		return 'exad exad-logo exad-woo-products';
	}

    public function get_categories() {
        return ['exclusive-addons-elementor'];
    }

	public function get_keywords() {
		return [ 'woo price', 'shop', 'store', 'price', 'product price', 'sale' ];
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
			'exad_product_price_before',
			[
				'label'       => esc_html__( 'Show Text Before Price', 'exclusive-addons-elementor-pro' ),
				'type'        => Controls_Manager::TEXTAREA
			]
        );

		$this->add_control(
			'exad_product_price_after',
			[
				'label'       => esc_html__( 'Show Text After Price', 'exclusive-addons-elementor-pro' ),
				'type'        => Controls_Manager::TEXTAREA
			]
        );
		
        $this->add_control( 'exad_product_update_info',
            [
                'type'  => Controls_Manager::RAW_HTML,
                'raw'   => __( '<strong>Product Price - </strong> Go to Style Tab ',
                        'exclusive-addons-elementor-pro' ),
                    'content_classes' => 'exad-panel-notice',
            ]
        );

        $this->end_controls_section();


		/**
		 * Style Section
		 */

		/*
		* Pricing container Styling Section
		*/
        $this->start_controls_section(
            'exad_product_price_container_style_section',
            [
                'label' => esc_html__( 'Container', 'exclusive-addons-elementor-pro' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

		$this->add_responsive_control(
            'exad_product_price_container_alignment',
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
                    '{{WRAPPER}} .exad-product-price' => 'text-align: {{VALUE}};'
                ]
            ]
        );

        $this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'exad_product_price_container_background',
				'types'    => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .exad-product-price'
			]
		);

		$this->add_responsive_control(
			'exad_product_price_container_padding',
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
					'{{WRAPPER}} .exad-product-price' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
		);

		$this->add_responsive_control(
			'exad_product_price_container_margin',
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
					'{{WRAPPER}} .exad-product-price' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
        );

        $this->add_responsive_control(
			'exad_product_price_container_radius',
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
					'{{WRAPPER}} .exad-product-price' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'exad_product_price_container_border',
				'selector' => '{{WRAPPER}} .exad-product-price'
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'exad_product_price_container_box_shadow',
				'selector' => '{{WRAPPER}} .exad-product-price'
			]
		);

        $this->end_controls_section();

		/*
		* Pricing Styling Section
		*/
		$this->start_controls_section(
			'exad_section_price_style',
			[
				'label' => __( 'Price Style', 'exclusive-addons-elementor-pro' ),
				'tab' 	=> Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'exad_text_align',
			[
				'label' => __( 'Alignment', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => __( 'Left', 'exclusive-addons-elementor-pro' ),
						'icon' => 'eicon-text-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'exclusive-addons-elementor-pro' ),
						'icon' => 'eicon-text-align-center',
					],
					'right' => [
						'title' => __( 'Right', 'exclusive-addons-elementor-pro' ),
						'icon' => 'eicon-text-align-right',
					],
				],
				'selectors' => [
					'{{WRAPPER}}' => 'text-align: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'exad_price_color',
			[
				'label' => __( 'Color', 'exclusive-addons-elementor-pro' ),
				'type' 	=> Controls_Manager::COLOR,
				'default' => $exad_primary_color,
				'selectors' => [
					'.woocommerce {{WRAPPER}} .price' => 'color: {{VALUE}}',
				],
			]
		);

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'exad_product_price_typography',
                'selector' => '.woocommerce {{WRAPPER}} .price'
            ]
        );

		$this->add_control(
			'exad_sale_heading',
			[
				'label' => __( 'Sale Price', 'exclusive-addons-elementor-pro' ),
				'type'  => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'exad_sale_price_color',
			[
				'label' => __( 'Color', 'exclusive-addons-elementor-pro' ),
				'type'  => Controls_Manager::COLOR,
				'selectors' => [
					'.woocommerce {{WRAPPER}} .price ins' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' 		=> 'exad_sale_price_typography',
				'selector'  => '.woocommerce {{WRAPPER}} .price ins',
			]
		);

		$this->add_control(
			'exad_price_block',
			[
				'label' => __( 'Stacked', 'exclusive-addons-elementor-pro' ),
				'type'  => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'prefix_class' => 'exad-prduct-price-block-',
			]
		);

		$this->add_responsive_control(
			'exad_sale_price_spacing',
			[
				'label' => __( 'Spacing', 'exclusive-addons-elementor-pro' ),
				'type'  => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'range' => [
					'em' => [
						'min' => 0,
						'max' => 5,
						'step' => 0.1,
					],
				],
				'selectors' => [
					// 'body:not(.rtl) {{WRAPPER}}:not(.exclusive-addons-elementorduct-price-block-yes) del' => 'margin-right: {{SIZE}}{{UNIT}}',
					// 'body.rtl {{WRAPPER}}:not(.exclusive-addons-elementorduct-price-block-yes) del' => 'margin-left: {{SIZE}}{{UNIT}}',
					// '{{WRAPPER}}.exclusive-addons-elementorduct-price-block-yes del' => 'margin-bottom: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->end_controls_section();

		/*
		* Before & After Price Styling Section
		*/
		$this->start_controls_section(
            'exad_woo_price_before_after_style_section',
            [
                'label' => esc_html__( 'Before & After Style', 'exclusive-addons-elementor-pro' ),
				'tab'   => Controls_Manager::TAB_STYLE
            ]
        );

		$this->add_control(
			'exad_woo_price_before_style',
			[
				'label'     => __( 'Before Price', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before'
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'             => 'exad_woo_price_before_typography',
				'selector'         => '{{WRAPPER}} .exad-product-price .product-price-before',
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
			'exad_woo_price_before_color',
			[
				'label'     => __( 'Color', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#333333',
				'selectors' => [
					'{{WRAPPER}} .exad-product-price .product-price-before' => 'color: {{VALUE}};'
				]
			]
		);

		$this->add_responsive_control(
			'exad_woo_price_before_margin',
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
					'{{WRAPPER}} .exad-product-price .product-price-before' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
		);

        $this->add_control(
			'exad_woo_price_after_style',
			[
				'label'     => __( 'After Price', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before'
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'             => 'exad_woo_price_after_typography',
				'selector'         => '{{WRAPPER}} .exad-product-price .product-price-after',
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
			'exad_woo_price_after_color',
			[
				'label'     => __( 'Color', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#333333',
				'selectors' => [
					'{{WRAPPER}} .exad-product-price .product-price-after' => 'color: {{VALUE}};'
				]
			]
		);

		$this->add_responsive_control(
			'exad_woo_price_after_margin',
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
					'{{WRAPPER}} .exad-product-price .product-price-after' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
		);
		$this-> end_controls_section();

	}

	protected function render() {

        if ( !class_exists( 'woocommerce' ) ) {
            return;
        }
		
		do_action( 'exad_woo_builder_widget_before_render', $this );

        $settings = $this->get_settings_for_display();
		global $product;
		$product = wc_get_product();

        do_action( 'exad_woo_price_widget_price_before_render', $this );
        ?>

		<div class="exad-product-price">

			<?php if ( ! empty( $settings['exad_product_price_before'] ) ) : ?>
				<p class="product-price-before" ><?php echo wp_kses_post( $settings['exad_product_price_before'] );?></p>
			<?php endif; ?>

			
				<?php
				if(  \Elementor\Plugin::instance()->editor->is_edit_mode() ){
					echo Woo_Preview_Data::instance()->default( $this->get_name() );
				}else{

					if ( empty( $product ) ) {
						return;
					}

					wc_get_template( '/single-product/price.php' );
				} ?>
			
			<?php if ( ! empty( $settings['exad_product_price_after'] ) ) : ?>
				<p class="product-price-after" ><?php echo wp_kses_post( $settings['exad_product_price_after'] );?></p>
			<?php endif; ?>
		</div>
        <?php
        do_action( 'exad_woo_price_widget_price_after_render', $this );
	}

}