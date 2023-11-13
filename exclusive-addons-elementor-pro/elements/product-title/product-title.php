<?php
namespace ExclusiveAddons\Elements;

if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.

use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Image_Size;
use \Elementor\Group_Control_Border;
use \Elementor\Group_Control_Box_Shadow;
use \Elementor\Group_Control_Typography;
use \Elementor\Widget_Base;
use \Elementor\Group_Control_Background;
use \Elementor\Group_Control_Text_Shadow;
use \Elementor\Icons_Manager;
use \ExclusiveAddons\Pro\Elementor\ProHelper;

class Product_Title extends Widget_Base {

	public function get_name() {
		return 'exad-product-title';
	}

	public function get_title() {
		return esc_html__( 'Product Title', 'exclusive-addons-elementor-pro' );
	}

	public function get_icon() {
		return 'exad exad-logo exad-woo-products';
	}

	public function get_categories() {
		return [ 'exclusive-addons-elementor' ];
	}

	public function get_keywords() {
	    return [ 'cart', 'woocommerce', 'check' ];
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
				    'type' => Controls_Manager::RAW_HTML,
				    'raw'  => __('<strong>WooCommerce</strong> is not installed/activated on your site. Please install and activate <a href="plugin-install.php?s=wpcf7&tab=search&type=term" target="_blank">WooCommerce</a> first.',
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
            'exad_product_title_content_section',
            [
                'label' => esc_html__( 'Content', 'exclusive-addons-elementor-pro' ),
            ]
        );

		$this->add_control(
			'before_title',
			[
				'label'   => esc_html__( 'Before Title', 'exclusive-addons-elementor-pro' ),
				'type'    => Controls_Manager::TEXT
			]
        );

		$this->add_control(
			'after_title',
			[
				'label'   => esc_html__( 'After Title', 'exclusive-addons-elementor-pro' ),
				'type'    => Controls_Manager::TEXT
			]
        );

		$this->add_control(
			'exad_product_title_link',
			[
				'label' 		=> __( 'Link', 'exclusive-addons-elementor-pro' ),
				'type' 			=> Controls_Manager::URL,
				'placeholder' 	=> __( 'https://your-link.com', 'exclusive-addons-elementor-pro' ),
				'show_external' => true,
				'default' => [
					'url' 		  => '',
					'is_external' => true,
					'nofollow'    => true,
				],
			]
		);

		$this->add_control(
			'exad_product_title_tag',
			[
				'label' => __( 'HTML Tag', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'h1' => 'H1',
					'h2' => 'H2',
					'h3' => 'H3',
					'h4' => 'H4',
					'h5' => 'H5',
					'h6' => 'H6',
					'div' => 'div',
					'span' => 'span',
					'p' => 'p',
				],
				'default' => 'h3',
			]
		);

		$this->end_controls_section();

		/*
		* Title container Styling Section
		*/
        $this->start_controls_section(
            'exad_product_title_container_style_section',
            [
                'label' => esc_html__( 'Container', 'exclusive-addons-elementor-pro' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

		$this->add_responsive_control(
            'exad_product_title_container_alignment',
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
                'selectors'      => [
                    '{{WRAPPER}} .exad-product-title' => 'text-align: {{VALUE}};'
                ]
            ]
        );

        $this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'exad_product_title_container_background',
				'types'    => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .exad-product-title'
			]
		);

		$this->add_responsive_control(
			'exad_product_title_container_padding',
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
					'{{WRAPPER}} .exad-product-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
		);

		$this->add_responsive_control(
			'exad_product_title_container_margin',
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
					'{{WRAPPER}} .exad-product-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
        );

        $this->add_responsive_control(
			'exad_product_title_container_radius',
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
					'{{WRAPPER}} .exad-product-title' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'exad_product_title_container_border',
				'selector' => '{{WRAPPER}} .exad-product-title'
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'exad_product_title_container_box_shadow',
				'selector' => '{{WRAPPER}} .exad-product-title'
			]
		);

        $this->end_controls_section();

		/*
		* Title Styling Section
		*/
		$this->start_controls_section(
            'exad_product_title_style_section',
            [
                'label' => esc_html__( 'Title', 'exclusive-addons-elementor-pro' ),
				'tab'   => Controls_Manager::TAB_STYLE
            ]
        );

		$this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'exad_product_title_typography',
                'selector' => '{{WRAPPER}} .exad-product-title .exad-product-title-content'
            ]
        );

		$this->add_control(
			'exad_product_title_color',
			[
				'label'     => esc_html__( 'Color', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#000000',
				'selectors' => [
					'{{WRAPPER}} .exad-product-title .exad-product-title-content' => 'color: {{VALUE}};'
				]
			]
		);

		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name' => 'exad_product_title_text_shadow',
				'label' => __( 'Text Shadow', 'exclusive-addons-elementor-pro' ),
				'selector' => '{{WRAPPER}} .exad-product-title .exad-product-title-content'
			]
		);

		$this->add_control(
			'exad_product_title_bland_mode',
			[
				'label' => __( 'Blend Mode', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'' => __( 'Normal', 'exclusive-addons-elementor-pro' ),
					'multiply' => 'Multiply',
					'screen' => 'Screen',
					'overlay' => 'Overlay',
					'darken' => 'Darken',
					'lighten' => 'Lighten',
					'color-dodge' => 'Color Dodge',
					'color-burn' => 'Color Burn',
					'hue' => 'Hue',
					'saturation' => 'Saturation',
					'color' => 'Color',
					'exclusion' => 'Exclusion',
					'luminosity' => 'Luminosity',
				],
				'selectors' => [
					'{{WRAPPER}} .exad-product-title .exad-product-title-content' => 'mix-blend-mode: {{VALUE}}',
				],
				'separator' => 'none',
			]
		);

		$this->end_controls_section();

    }

    protected function render() {
        if( ! class_exists('woocommerce') ) {
	        return;
        }

		$settings = $this->get_settings_for_display();
		?>

		<div class="exad-product-title">

			<?php do_action( 'exad_woo_builder_widget_title_before_render' ); ?>

			<?php 
				if( !empty( $settings['exad_product_title_link']['url'] ) ) :
		            $this->add_render_attribute( 'link', 'href', esc_url( $settings['exad_product_title_link']['url'] ) );
			        if( $settings['exad_product_title_link']['is_external'] ) :
			            $this->add_render_attribute( 'link', 'target', '_blank' );
			        endif;
			        if( $settings['exad_product_title_link']['nofollow'] ) :
			            $this->add_render_attribute( 'link', 'rel', 'nofollow' );
			        endif; ?>
		    <a <?php echo $this->get_render_attribute_string( 'link' ); ?>>
			<?php endif; ?>

				<<?php echo $settings['exad_product_title_tag']; ?> class="product_title entry-title exad-product-title-content">
					<?php if ( ! empty( $settings['before_title'] ) ) : ?>
						<?php echo wp_kses_post( $settings['before_title'] ); ?>
					<?php endif; ?>	

					<?php 
					if( \Elementor\Plugin::instance()->editor->is_edit_mode() || \Elementor\Plugin::instance()->preview->is_preview_mode()){

            			$title = get_the_title( ProHelper::exad_product_get_last_product_id() );
						echo $title;

					} else {
						the_title();
					}?>
					
					<?php if ( ! empty( $settings['after_title'] ) ) : ?>
						<?php echo wp_kses_post( $settings['after_title'] ); ?>
					<?php endif; ?>	
				</<?php echo $settings['exad_product_title_tag']; ?>>

			<?php  if( !empty( $settings['exad_product_title_link']['url'] ) ) : ?>
				</a>
			<?php endif; ?>	

			<?php do_action( 'exad_woo_builder_widget_title_after_render' ); ?>

		</div>

		<?php
    }
}