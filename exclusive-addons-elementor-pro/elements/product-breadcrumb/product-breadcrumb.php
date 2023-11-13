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

class Product_Breadcrumb extends Widget_Base {

    public function get_name() {
        return 'exad-product-breadcrumb';
    }

    public function get_title() {
        return esc_html__( 'Product Breadcrumb', 'exclusive-addons-elementor-pro' );
    }

    public function get_icon() {
        return 'exad exad-logo exad-woo-products';
    }

    public function get_categories() {
        return ['exclusive-addons-elementor'];
    }

    public function get_keywords() {
        return ['product breadcrumb', 'breadcrumb', 'single product breadcrumb', 'woo product breadcrumb', 'woo breadcrumb'];
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
            'exad_product_breadcrumb_content_section',
            [
                'label' => esc_html__( 'Content', 'exclusive-addons-elementor-pro' ),
            ]
        );

		$this->add_control(
			'exad_product_breadcrumb_before',
			[
				'label'       => esc_html__( 'Show Text Before Breadcrumb', 'exclusive-addons-elementor-pro' ),
				'type'        => Controls_Manager::TEXTAREA
			]
        );

		$this->add_control(
			'exad_product_breadcrumb_after',
			[
				'label'       => esc_html__( 'Show Text After Breadcrumb', 'exclusive-addons-elementor-pro' ),
				'type'        => Controls_Manager::TEXTAREA
			]
        );
		
        $this->add_control( 'exad_product_update_info',
            [
                'type'  => Controls_Manager::RAW_HTML,
                'raw'   => __( '<strong>Product Breadcrumb - </strong> Go to Style Tab ',
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
            'exad_product_breadcrumb_container_style_section',
            [
                'label' => esc_html__( 'Container', 'exclusive-addons-elementor-pro' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

		$this->add_responsive_control(
            'exad_product_breadcrumb_container_alignment',
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
                    '{{WRAPPER}} .exad-product-breadcrumb' => 'text-align: {{VALUE}};'
                ]
            ]
        );

        $this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'exad_product_breadcrumb_container_background',
				'types'    => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .exad-product-breadcrumb'
			]
		);

		$this->add_responsive_control(
			'exad_product_breadcrumb_container_padding',
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
					'{{WRAPPER}} .exad-product-breadcrumb' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
		);

		$this->add_responsive_control(
			'exad_product_breadcrumb_container_margin',
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
					'{{WRAPPER}} .exad-product-breadcrumb' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
        );

        $this->add_responsive_control(
			'exad_product_breadcrumb_container_radius',
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
					'{{WRAPPER}} .exad-product-breadcrumb' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'      => 'exad_product_breadcrumb_container_border',
				'selector'  => '{{WRAPPER}} .exad-product-breadcrumb'
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'exad_product_breadcrumb_container_box_shadow',
				'selector' => '{{WRAPPER}} .exad-product-breadcrumb'
			]
		);

        $this->end_controls_section();

        /**
		* Style Tab breadcrumb Style
		*/
		$this->start_controls_section(
            'exad_product_breadcrumb_style',
            [
                'label'     => esc_html__( 'Breadcrumb Style', 'exclusive-addons-elementor-pro' ),
                'tab'       => Controls_Manager::TAB_STYLE,
            ]
        );

		$this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'exad_product_breadcrumb_typography',
				'label'    => __( 'Normal Item Typography', 'exclusive-addons-elementor-pro' ),
                'selector' => '{{WRAPPER}} .exad-product-breadcrumb .woocommerce-breadcrumb a'
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'exad_product_breadcrumb_active_typography',
				'label'    => __( 'Active Item Typography', 'exclusive-addons-elementor-pro' ),
                'selector' => '{{WRAPPER}} .exad-product-breadcrumb .woocommerce-breadcrumb'
            ]
        );

        $this->add_control(
            'exad_product_breadcrumb_normal_color',
            [
                'label'     => __( 'Normal Color', 'exclusive-addons-elementor-pro' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#767676',
                'selectors' => [
                    '{{WRAPPER}} .exad-product-breadcrumb .woocommerce-breadcrumb' => 'color: {{VALUE}};',
                ],
            ]
        );
        
        $this->add_control(
            'exad_product_breadcrumb_active_color',
            [
                'label'     => __( 'Active Color', 'exclusive-addons-elementor-pro' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => $exad_primary_color,
                'selectors' => [
                    '{{WRAPPER}} .exad-product-breadcrumb .woocommerce-breadcrumb > a' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();

        /*
		* Before & After description Styling Section
		*/
		$this->start_controls_section(
            'exad_product_breadcrumb_before_after_style_section',
            [
                'label' => esc_html__( 'Before & After Style', 'exclusive-addons-elementor-pro' ),
				'tab'   => Controls_Manager::TAB_STYLE
            ]
        );

		$this->add_control(
			'exad_product_breadcrumb_before_style',
			[
				'label'     => __( 'Before Breadcrumb', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before'
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'             => 'exad_product_breadcrumb_before_typography',
				'selector'         => '{{WRAPPER}} .exad-product-breadcrumb .exad-breadcrumb-before',
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
			'exad_product_breadcrumb_before_color',
			[
				'label'     => __( 'Color', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#333333',
				'selectors' => [
					'{{WRAPPER}} .exad-product-breadcrumb .exad-breadcrumb-before' => 'color: {{VALUE}};'
				]
			]
		);

		$this->add_responsive_control(
			'exad_product_breadcrumb_before_margin',
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
					'{{WRAPPER}} .exad-product-breadcrumb .exad-breadcrumb-before' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
		);

        $this->add_control(
			'exad_product_breadcrumb_after_style',
			[
				'label'     => __( 'After Breadcrumb', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before'
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'             => 'exad_product_breadcrumb_after_typography',
				'selector'         => '{{WRAPPER}} .exad-product-breadcrumb .exad-breadcrumb-after',
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
			'exad_product_breadcrumb_after_color',
			[
				'label'     => __( 'Color', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#333333',
				'selectors' => [
					'{{WRAPPER}} .exad-product-breadcrumb .exad-breadcrumb-after' => 'color: {{VALUE}};'
				]
			]
		);

		$this->add_responsive_control(
			'exad_product_breadcrumb_after_margin',
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
					'{{WRAPPER}} .exad-product-breadcrumb .exad-breadcrumb-after' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
		);
		$this-> end_controls_section();
    }
    
    public function my_remove_breadcrumbs() {
        remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0 );
    }

    protected function render() {

        if ( !class_exists( 'woocommerce' ) ) {
            return;
        }

		if ( ! post_type_supports( 'product', 'comments' ) ) {
			return;
		}

        $settings = $this->get_settings_for_display();
        global $product;
		$product = wc_get_product();

        do_action( 'exad_woo_breadcrumb_widget_before_render', $this );
        ?>

		<div class="exad-product-breadcrumb">

			<?php if ( ! empty( $settings['exad_product_breadcrumb_before'] ) ) : ?>
				<p class="exad-breadcrumb-before" ><?php echo wp_kses_post( $settings['exad_product_breadcrumb_before'] );?></p>
			<?php endif; ?>
            <?php remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0 ); ?>
    
           <?php  add_action( 'init', [ $this ,'my_remove_breadcrumbs'] ); ?>
            <?php woocommerce_breadcrumb() ;?>
            <?php  ?>

            <?php if ( ! empty( $settings['exad_product_breadcrumb_after'] ) ) : ?>
				<p class="exad-breadcrumb-after" ><?php echo wp_kses_post( $settings['exad_product_breadcrumb_after'] );?></p>
			<?php endif; ?>
		</div>
        <?php
        do_action( 'exad_woo_breadcrumb_widget_after_render', $this );

    }
}