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

class Product_Rating extends Widget_Base {

    public function get_name() {
        return 'exad-product-rating';
    }

    public function get_title() {
        return esc_html__( 'Product Rating', 'exclusive-addons-elementor-pro' );
    }

    public function get_icon() {
        return 'exad exad-logo exad-woo-products';
    }

    public function get_categories() {
        return ['exclusive-addons-elementor'];
    }

    public function get_keywords() {
        return ['exad_product rating', 'rating', 'single rating', 'single product rating', 'woo product rating'];
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
            'exad_product_rating_content_section',
            [
                'label' => esc_html__( 'Content', 'exclusive-addons-elementor-pro' ),
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
         * Style Section
         */

		/*
		* Rating container Styling Section
		*/
        $this->start_controls_section(
            'exad_product_rating_container_style_section',
            [
                'label' => esc_html__( 'Container', 'exclusive-addons-elementor-pro' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

		$this->add_responsive_control(
            'exad_product_rating_container_alignment',
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
                    '{{WRAPPER}} .exad-product-rating' => 'text-align: {{VALUE}};'
                ]
            ]
        );

        $this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'exad_product_rating_container_background',
				'types'    => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .exad-product-rating'
			]
		);

		$this->add_responsive_control(
			'exad_product_rating_container_padding',
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
					'{{WRAPPER}} .exad-product-rating' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
		);

		$this->add_responsive_control(
			'exad_product_rating_container_margin',
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
					'{{WRAPPER}} .exad-product-rating' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
        );

        $this->add_responsive_control(
			'exad_product_rating_container_radius',
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
					'{{WRAPPER}} .exad-product-rating' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'exad_product_rating_container_border',
				'selector' => '{{WRAPPER}} .exad-product-rating'
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'exad_product_rating_container_box_shadow',
				'selector' => '{{WRAPPER}} .exad-product-rating'
			]
		);

        $this->end_controls_section();

        /**
		 * Product Rating Style Section
		 */
		$this->start_controls_section(
			'exad_product_rating_style',
			[
				'label'     => esc_html__( 'Rating', 'exclusive-addons-elementor-pro' ),
				'tab'       => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'exad_product_rating_size',
			[
				'label'       => __( 'Icon Size', 'exclusive-addons-elementor-pro' ),
				'type'        => Controls_Manager::SLIDER,
				'size_units'  => [ 'px', '%' ],
				'range'       => [
					'px'      => [
						'min' => 0,
						'max' => 50
					]
				],
				'default'     => [
					'unit'    => 'px',
					'size'    => 20
				],
				'selectors'   => [
					'{{WRAPPER}} .star-rating' => 'font-size: {{SIZE}}{{UNIT}};'
				]
			]
		);

		$this->add_responsive_control(
			'exad_woo_price_after_margin',
			[
				'label'      => __( 'Icon Margin', 'exclusive-addons-elementor-pro' ),
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
					'{{WRAPPER}} .star-rating' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
		);

		$this->start_controls_tabs( 'exad_product_rating_tabs' );

			// normal state rating
			$this->start_controls_tab( 'exad_product_rating_normal', [ 'label' => esc_html__( 'Normal', 'exclusive-addons-elementor-pro' ) ] );

				$this->add_control(
					'exad_product_rating_normal_color',
					[
						'label'     => __( 'Color', 'exclusive-addons-elementor-pro' ),
						'type'      => Controls_Manager::COLOR,
						'default'   => '#222222',
						'selectors' => [
                            '{{WRAPPER}} .star-rating::before' => 'color: {{VALUE}} !important;',
						]
					]
				);

			$this->end_controls_tab();

			// hover state rating
			$this->start_controls_tab( 'exad_product_rating_active', [ 'label' => esc_html__( 'Active', 'exclusive-addons-elementor-pro' ) ] );

				$this->add_control(
					'exad_product_rating_active_color',
					[
						'label'     => __( 'Color', 'exclusive-addons-elementor-pro' ),
						'type'      => Controls_Manager::COLOR,
						'default'   => '#ff5b84',
						'selectors' => [
							'{{WRAPPER}} .star-rating' => 'color: {{VALUE}};'
						]
					]
				);

			$this->end_controls_tab();

		$this->end_controls_tabs();

		$this-> end_controls_section();

		/*
		* Rating Review Link Styling Section
		*/
		$this->start_controls_section(
			'exad_section_rating_review_link_style',
			[
				'label' => __( 'Review', 'exclusive-addons-elementor-pro' ),
				'tab' 	=> Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'exad_product_rating_review_color',
			[
				'label' => __( 'Color', 'exclusive-addons-elementor-pro' ),
				'type' 	=> Controls_Manager::COLOR,
				'default' => $exad_primary_color,
				'selectors' => [
					'.woocommerce {{WRAPPER}} .exad-product-rating .woocommerce-product-rating .woocommerce-review-link' => 'color: {{VALUE}}',
				],
			]
		);

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'exad_product_rating_review_typography',
                'selector' => '.woocommerce {{WRAPPER}} .exad-product-rating .woocommerce-product-rating .woocommerce-review-link'
            ]
        );

		$this-> end_controls_section();

    }

    protected function render() {
        if ( !class_exists( 'woocommerce' ) ) {
            return;
        }

		if ( ! post_type_supports( 'product', 'comments' ) ) {
			return;
		}

        $settings = $this->get_settings_for_display();
		?>
		<div class="exad-product-rating">

			<?php do_action( 'exad_woo_builder_widget_rating_before_render' ); ?>

			<?php 
			global $product;

			$product = wc_get_product();

			if ( \Elementor\Plugin::instance()->editor->is_edit_mode() ) {
				echo Woo_Preview_Data::instance()->default( $this->get_name() );
			} else {
				if ( empty( $product ) ) {
					return;
				}

				wc_get_template( 'single-product/rating.php' );
			} ?>

			<?php do_action( 'exad_woo_builder_widget_rating_after_render' ); ?>

		</div>
	<?php
	}

}