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

class Product_Meta extends Widget_Base {

    public function get_name() {
        return 'exad-product-meta';
    }

    public function get_title() {
        return esc_html__( 'Product Meta', 'exclusive-addons-elementor-pro' );
    }

    public function get_icon() {
        return 'exad exad-logo exad-woo-products';
    }

    public function get_categories() {
        return ['exclusive-addons-elementor'];
    }

    public function get_keywords() {
        return ['product meta', 'attributes', 'single product meta', 'woo product meta', 'woo attributes'];
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
			'section_product_meta_captions',
			[
				'label' => __( 'Mate Content', 'exclusive-addons-elementor-pro' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'section_product_meta_category_heading_caption',
			[
				'label' => __( 'Category', 'exclusive-addons-elementor-pro' ),
				'type'  => Controls_Manager::HEADING,
			]
		);

		$this->add_control(
			'exad_product_meta_category_caption_single',
			[
				'label' => __( 'Singular', 'exclusive-addons-elementor-pro' ),
				'type'  => Controls_Manager::TEXT,
				'placeholder' => __( 'Category', 'exclusive-addons-elementor-pro' ),
			]
		);

		$this->add_control(
			'exad_product_meta_category_caption_plural',
			[
				'label' => __( 'Plural', 'exclusive-addons-elementor-pro' ),
				'type'  => Controls_Manager::TEXT,
				'placeholder' => __( 'Categories', 'exclusive-addons-elementor-pro' ),
			]
		);

		$this->add_control(
			'exad_product_meta_tag_heading_caption',
			[
				'label' => __( 'Tag', 'exclusive-addons-elementor-pro' ),
				'type'  => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'tag_caption_single',
			[
				'label' => __( 'Singular', 'exclusive-addons-elementor-pro' ),
				'type'  => Controls_Manager::TEXT,
				'placeholder' => __( 'Tag', 'exclusive-addons-elementor-pro' ),
			]
		);

		$this->add_control(
			'exad_product_meta_tag_caption_plural',
			[
				'label' => __( 'Plural', 'exclusive-addons-elementor-pro' ),
				'type'  => Controls_Manager::TEXT,
				'placeholder' => __( 'Tags', 'exclusive-addons-elementor-pro' ),
			]
		);

		$this->add_control(
			'heading_sku_caption',
			[
				'label' => __( 'SKU', 'exclusive-addons-elementor-pro' ),
				'type'  => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'exad_product_meta_sku_caption',
			[
				'label' => __( 'SKU', 'exclusive-addons-elementor-pro' ),
				'type'  => Controls_Manager::TEXT,
				'placeholder' => __( 'SKU', 'exclusive-addons-elementor-pro' ),
			]
		);

		$this->add_control(
			'exad_product_meta_sku_missing_caption',
			[
				'label' => __( 'Missing', 'exclusive-addons-elementor-pro' ),
				'type'  => Controls_Manager::TEXT,
				'placeholder' => __( 'N/A', 'exclusive-addons-elementor-pro' ),
			]
		);

		$this->add_control(
			'exad_product_meta_separator_heading',
			[
				'label' => __( 'Meta Link Separator', 'exclusive-addons-elementor-pro' ),
				'type'  => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'exad_product_meta_separator',
			[
				'label' => __( 'Separator', 'exclusive-addons-elementor-pro' ),
				'type'  => Controls_Manager::TEXT,
				'default' 	  => __( ', ', 'exclusive-addons-elementor-pro' ),
				'placeholder' => __( 'Separator', 'exclusive-addons-elementor-pro' ),
			]
		);

		
        $this->add_control(
            'exad_woo_meta_content_update',
            [
                'label' => '<div class="elementor-update-preview" style="display: block;"><div class="elementor-update-preview-button-wrapper" style="display:block;"><button class="elementor-update-preview-button elementor-button elementor-button-success" style="background: #d30c5c; margin: 0 auto; display:block;">Apply Changes</button></div><div class="elementor-update-preview-title" style="display:block;text-align:center;margin-top: 10px;">'. __( 'Hit the button to apply changes if it hasn\'t already.', 'exclusive-addons-elementor-pro' ) .'</div></div>',
                'type' => Controls_Manager::RAW_HTML,
				'separator' => 'before',
            ]
        );

		$this->end_controls_section();

        /**
         * Content Section
         */
        $this->start_controls_section(
            'exad_product_meta_content_section',
            [
                'label' => esc_html__( 'Before & After', 'exclusive-addons-elementor-pro' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

		$this->add_control(
			'exad_product_meta_before',
			[
				'label'       => esc_html__( 'Show Text Before Meta', 'exclusive-addons-elementor-pro' ),
				'type'        => Controls_Manager::TEXTAREA
			]
        );

		$this->add_control(
			'exad_product_meta_after',
			[
				'label'       => esc_html__( 'Show Text After Meta', 'exclusive-addons-elementor-pro' ),
				'type'        => Controls_Manager::TEXTAREA
			]
        );
		
        $this->add_control( 'exad_product_update_info',
            [
                'type'  => Controls_Manager::RAW_HTML,
                'raw'   => __( '<strong>product meta - </strong> Go to Style Tab ',
                        'exclusive-addons-elementor-pro' ),
                    'content_classes' => 'exad-panel-notice',
            ]
        );

        $this->end_controls_section();

        /**
		 * Style Section
		 */

		/*
		* container Styling Section
		*/
        $this->start_controls_section(
            'exad_product_meta_container_style_section',
            [
                'label' => esc_html__( 'Container', 'exclusive-addons-elementor-pro' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

		$this->add_responsive_control(
            'exad_product_meta_container_alignment',
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
                    '{{WRAPPER}} .exad-product-meta' => 'text-align: {{VALUE}};'
                ]
            ]
        );

        $this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'exad_product_meta_container_background',
				'types'    => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .exad-product-meta'
			]
		);

		$this->add_responsive_control(
			'exad_product_meta_container_padding',
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
					'{{WRAPPER}} .exad-product-meta' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
		);

		$this->add_responsive_control(
			'exad_product_meta_container_margin',
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
					'{{WRAPPER}} .exad-product-meta' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
        );

        $this->add_responsive_control(
			'exad_product_meta_container_radius',
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
					'{{WRAPPER}} .exad-product-meta' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'exad_product_meta_container_border',
				'selector' => '{{WRAPPER}} .exad-product-meta'
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'exad_product_meta_container_shadow',
				'selector' => '{{WRAPPER}} .exad-product-meta'
			]
		);

        $this->end_controls_section();

        /*
		* container Styling Section
		*/
        $this->start_controls_section(
            'exad_product_meta_container_box_style_section',
            [
                'label' => esc_html__( 'Meta Container', 'exclusive-addons-elementor-pro' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
			'exad_product_meta_view',
			[
				'label' => __( 'Display Style', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'inline-view',
				'options' => [
					'block-view' => __( 'Block', 'exclusive-addons-elementor-pro' ),
					'inline-view' => __( 'Inline', 'exclusive-addons-elementor-pro' ),
				],
				'prefix_class' => 'exad-woo-meta-',
			]
		);

        $this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'exad_product_meta_container_box_background',
				'types'    => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .exad-product-meta .exad-meta-container'
			]
		);

		$this->add_responsive_control(
			'exad_product_meta_container_box_padding',
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
					'{{WRAPPER}} .exad-product-meta .exad-meta-container' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
		);

		$this->add_responsive_control(
			'exad_product_meta_container_box_margin',
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
					'{{WRAPPER}} .exad-product-meta .exad-meta-container' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
        );

		$this->add_responsive_control(
			'space_between',
			[
				'label' => __( 'Space Between', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 50,
					],
				],
				'selectors' => [
					'{{WRAPPER}}:not(.exad-woo-meta-inline-view) .exad-product-meta .exad-meta-container:not(:first-child)' => 'margin-top: calc({{SIZE}}{{UNIT}}/2)',
					'{{WRAPPER}}.exad-woo-meta-inline-view .exad-product-meta .exad-meta-container' => 'margin-right: calc({{SIZE}}{{UNIT}}/2); margin-left: calc({{SIZE}}{{UNIT}}/2)',
					'{{WRAPPER}}.exad-woo-meta-inline-view .exad-product-meta' => 'margin-right: calc(-{{SIZE}}{{UNIT}}/2); margin-left: calc(-{{SIZE}}{{UNIT}}/2)',
				],
			]
		);

        $this->add_responsive_control(
			'exad_product_meta_container_box_radius',
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
					'{{WRAPPER}} .exad-product-meta .exad-meta-container' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'exad_product_meta_container_box_border',
				'selector' => '{{WRAPPER}} .exad-product-meta .exad-meta-container'
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'exad_product_meta_container_box_shadow',
				'selector' => '{{WRAPPER}} .exad-product-meta .exad-meta-container'
			]
		);

        $this->end_controls_section();

        /**
		* Style Tab Meta Style
		*/
		$this->start_controls_section(
            'exad_product_meta_data_style',
            [
                'label' => esc_html__( 'Meta Style', 'exclusive-addons-elementor-pro' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

		$this->add_control(
			'exad_product_meta_label_heading_style',
			[
				'label' 	=> __( 'Meta Label', 'exclusive-addons-elementor-pro' ),
				'type'  	=> Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' 	   => 'exad_meta_label_text_typography',
				'selector' => '{{WRAPPER}} .exad-product-meta .exad-meta-container .detail-label',
			]
		);

		$this->add_control(
			'exad_product_meta_text_color',
			[
				'label' 	=> __( 'Color', 'exclusive-addons-elementor-pro' ),
				'type' 		=> Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .exad-product-meta .exad-meta-container .detail-label' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
            'eexad_product_meta_label_bg_color',
            [
                'label'     => esc_html__('Background Color', 'exclusive-addons-elementor-pro'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'condition' => [
                    'exad_product_meta_link_as_box' => 'yes',
                ],
                'selectors' => [
                    '{{WRAPPER}} .exad-product-meta .exad-meta-container .detail-label' => 'background: {{VALUE}};'
                ]
            ]
        );

        $this->add_responsive_control(
			'exad_product_meta_label_padding',
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
					'{{WRAPPER}} .exad-product-meta .exad-meta-container .detail-label' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
		);

        $this->add_responsive_control(
			'exad_product_meta_label_radius',
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
					'{{WRAPPER}} .exad-product-meta .exad-meta-container .detail-label' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'      => 'exad_product_meta_label_border',
				'selector'  => '{{WRAPPER}} .exad-product-meta .exad-meta-container .detail-label',
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'      => 'exad_product_meta_label_box_shadow',
				'selector'  => '{{WRAPPER}} .exad-product-meta .exad-meta-container .detail-label',
			]
		);

		$this->add_control(
			'exad_product_meta_link_heading_style',
			[
				'label' 	=> __( 'Meta Links', 'exclusive-addons-elementor-pro' ),
				'type'  	=> Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

        $this->add_control(
			'exad_product_meta_link_as_box',
			[
				'label'         => esc_html__( 'Box View', 'exclusive-addons-elementor-pro' ),
				'type'          => Controls_Manager::SWITCHER,
                'description'   => __( 'Show Link as Box', 'exclusive-addons-elementor-pro' ),
                'label_on'      => __( 'Yes', 'exclusive-addons-elementor-pro' ),
				'label_off'     => __( 'No', 'exclusive-addons-elementor-pro' ),
                'return_value'  => 'yes',
				'default'       => 'no',
			]
		);

		
		$this->add_responsive_control(
			'exad_product_meta_link_space_between',
			[
				'label' => __( 'Space Between', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 25,
					],
				],
				'default' 		=> [
					'unit' 		=> 'px',
					'size' 		=> 8,
				],
				'selectors' => [
					'{{WRAPPER}} .exad-product-meta .exad-meta-container .detail-content a:not(:last-child)' => 'margin-right: {{SIZE}}{{UNIT}}',
					'{{WRAPPER}} .exad-product-meta .exad-meta-container .sku:not(:last-child)' => 'margin-right: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' 		=> 'exad_product_meta_link_typography',
				'selector' 	=> '{{WRAPPER}} .exad-product-meta .exad-meta-container a',
			]
		);

		$this->add_control(
			'exad_product_meta_link_color',
			[
				'label' => __( 'Color', 'exclusive-addons-elementor-pro' ),
				'type' 	=> Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .exad-product-meta .exad-meta-container a' => 'color: {{VALUE}}',
				],
			]
		);

        $this->add_control(
            'eexad_product_meta_link_bg_color',
            [
                'label'     => esc_html__('Background Color', 'exclusive-addons-elementor-pro'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'condition' => [
                    'exad_product_meta_link_as_box' => 'yes',
                ],
                'selectors' => [
                    '{{WRAPPER}} .exad-product-meta .exad-meta-container a' => 'background: {{VALUE}};'
                ]
            ]
        );

        $this->add_responsive_control(
			'exad_product_meta_links_box_padding',
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
                'condition' => [
                    'exad_product_meta_link_as_box' => 'yes',
                ],
				'selectors'     => [
					'{{WRAPPER}} .exad-product-meta .exad-meta-container a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
		);

        $this->add_responsive_control(
			'exad_product_meta_links_box_radius',
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
                'condition' => [
                    'exad_product_meta_link_as_box' => 'yes',
                ],
				'selectors'  => [
					'{{WRAPPER}} .exad-product-meta .exad-meta-container a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'      => 'exad_product_meta_links_box_border',
				'selector'  => '{{WRAPPER}} .exad-product-meta .exad-meta-container a',
                'condition' => [
                    'exad_product_meta_link_as_box' => 'yes',
                ],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'      => 'exad_product_meta_links_box_shadow',
				'selector'  => '{{WRAPPER}} .exad-product-meta .exad-meta-container a',
                'condition' => [
                    'exad_product_meta_link_as_box' => 'yes',
                ],
			]
		);

		$this->end_controls_section();

        /*
		* Before & After meta Styling Section
		*/
		$this->start_controls_section(
            'exad_product_meta_before_after_style_section',
            [
                'label' => esc_html__( 'Before & After Style', 'exclusive-addons-elementor-pro' ),
				'tab'   => Controls_Manager::TAB_STYLE
            ]
        );

		$this->add_control(
			'exad_product_meta_before_style',
			[
				'label'     => __( 'Before Meta', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before'
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'             => 'exad_product_meta_before_typography',
				'selector'         => '{{WRAPPER}} .exad-product-meta .exad-meta-before',
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
			'exad_product_meta_before_color',
			[
				'label'     => __( 'Color', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#333333',
				'selectors' => [
					'{{WRAPPER}} .exad-product-meta .exad-meta-before' => 'color: {{VALUE}};'
				]
			]
		);

		$this->add_responsive_control(
			'exad_product_meta_before_margin',
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
					'{{WRAPPER}} .exad-product-meta .exad-meta-before' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
		);

        $this->add_control(
			'exad_product_meta_after_style',
			[
				'label'     => __( 'After Meta', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before'
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'             => 'exad_product_meta_after_typography',
				'selector'         => '{{WRAPPER}} .exad-product-meta .exad-meta-after',
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
			'exad_product_meta_after_color',
			[
				'label'     => __( 'Color', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#333333',
				'selectors' => [
					'{{WRAPPER}} .exad-product-meta .exad-meta-after' => 'color: {{VALUE}};'
				]
			]
		);

		$this->add_responsive_control(
			'exad_product_meta_after_margin',
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
					'{{WRAPPER}} .exad-product-meta .exad-meta-after' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
		);
		$this-> end_controls_section();

    }

	private function get_plural_or_single( $single, $plural, $count ) {
		return 1 === $count ? $single : $plural;
	}

    protected function render() {

        if ( !class_exists( 'woocommerce' ) ) {
            return;
        }

		do_action( 'exad_woo_builder_widget_before_render', $this );

        $settings = $this->get_settings_for_display();
        global $product;
		$product = wc_get_product();

        if ( empty( $product ) ) {
			return;
		}

        $sku = $product->get_sku();

		$settings = $this->get_settings_for_display();
		$exad_product_meta_sku_caption = ! empty( $settings['exad_product_meta_sku_caption'] ) ? $settings['exad_product_meta_sku_caption'] : __( 'SKU', 'exclusive-addons-elementor-pro' );
		$sku_missing = ! empty( $settings['exad_product_meta_sku_missing_caption'] ) ? $settings['exad_product_meta_sku_missing_caption'] : __( 'N/A', 'exclusive-addons-elementor-pro' );
		$exad_product_meta_category_caption_single = ! empty( $settings['exad_product_meta_category_caption_single'] ) ? $settings['exad_product_meta_category_caption_single'] : __( 'Category', 'exclusive-addons-elementor-pro' );
		$exad_product_meta_category_caption_plural = ! empty( $settings['exad_product_meta_category_caption_plural'] ) ? $settings['exad_product_meta_category_caption_plural'] : __( 'Categories', 'exclusive-addons-elementor-pro' );
		$tag_caption_single = ! empty( $settings['tag_caption_single'] ) ? $settings['tag_caption_single'] : __( 'Tag', 'exclusive-addons-elementor-pro' );
		$exad_product_meta_tag_caption_plural = ! empty( $settings['exad_product_meta_tag_caption_plural'] ) ? $settings['exad_product_meta_tag_caption_plural'] : __( 'Tags', 'exclusive-addons-elementor-pro' );

        do_action( 'exad_woo_meta_widget_before_render', $this );
        ?>

		<div class="exad-product-meta">

			<?php if ( ! empty( $settings['exad_product_meta_before'] ) ) : ?>
				<p class="exad-meta-before" ><?php echo wp_kses_post( $settings['exad_product_meta_before'] );?></p>
			<?php endif; ?>
           
            <?php
				if(  \Elementor\Plugin::instance()->editor->is_edit_mode() ){
					echo Woo_Preview_Data::instance()->default( $this->get_name() );
				}else{

					if ( empty( $product ) ) {
						return;
					}

					$separator = $settings['exad_product_meta_separator'];

                    if ( wc_product_sku_enabled() && ( $sku || $product->is_type( 'variable' ) ) ) : ?>
                        <span class="sku_wrapper exad-meta-container"><span class="detail-label"><?php echo esc_html( $exad_product_meta_sku_caption ); ?></span> <span class="sku"><?php echo $sku ? $sku : esc_html( $sku_missing ); ?></span></span>
                    <?php endif; ?>
    
                    <?php if ( count( $product->get_category_ids() ) ) : ?>
                        <span class="posted_in exad-meta-container"><span class="detail-label"><?php echo esc_html( $this->get_plural_or_single( $exad_product_meta_category_caption_single, $exad_product_meta_category_caption_plural, count( $product->get_category_ids() ) ) ); ?></span> <span class="detail-content"><?php echo get_the_term_list( $product->get_id(), 'product_cat', '', $separator ); ?></span></span>
                    <?php endif; ?>
    
                    <?php if ( count( $product->get_tag_ids() ) ) : ?>
                        <span class="tagged_as exad-meta-container"><span class="detail-label"><?php echo esc_html( $this->get_plural_or_single( $tag_caption_single, $exad_product_meta_tag_caption_plural, count( $product->get_tag_ids() ) ) ); ?></span> <span class="detail-content"><?php echo get_the_term_list( $product->get_id(), 'product_tag', '', $separator ); ?></span></span>
                    <?php endif;

				} ?>

            <?php if ( ! empty( $settings['exad_product_meta_after'] ) ) : ?>
				<p class="exad-meta-after" ><?php echo wp_kses_post( $settings['exad_product_meta_after'] );?></p>
			<?php endif; ?>
		</div>
        <?php
        do_action( 'exad_woo_meta_widget_after_render', $this );

    }
}