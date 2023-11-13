<?php

namespace Elementor;

use ShopEngine\Widgets\Products;

defined('ABSPATH') || exit;

class Shopengine_Best_Selling_Product extends \ShopEngine\Base\Widget {

	public function config() {
		return new Shopengine_Best_Selling_Product_Config();
	}

	protected function register_controls() {

		/*
			============================
			Content Panel
			============================
		*/

		$this->start_controls_section(
			'shopengine_section_content',
			[
				'label' => esc_html__('Content', 'shopengine-pro'),
				'tab'   => Controls_Manager::TAB_LAYOUT,
			]
		);

		$this->add_control(
			'shopengine_content_layout',
			[
				'label'   => esc_html__('Layout', 'shopengine-pro'),
				'type'    => Controls_Manager::SELECT,
				'default' => 'grid',
				'options' => [
					'grid'    => esc_html__('Grid', 'shopengine-pro'),
					// 'slider'  => esc_html__('Slider', 'shopengine-pro')
				],
			]
		);

		$this->add_control(
			'shopengine_last_day',
			[
				'label'        => esc_html__('Show Product Of', 'shopengine-pro'),
				'type'         => Controls_Manager::SELECT,
				'default'  => '7',
				'options'      => [
					'1'		=> esc_html__('Last Day', 'shopengine-pro'),
					'7'		=> esc_html__('7 Days', 'shopengine-pro'),
					'30'	=> esc_html__('1 Month', 'shopengine-pro'),
					'182'	=> esc_html__('6 Months', 'shopengine-pro'),
					'365'	=> esc_html__('1 Year', 'shopengine-pro'),
					'life_time'  => esc_html__('Life Time', 'shopengine-pro'),
				],
			]
		);

		$this->add_control(
			'shopengine_product_limit',
			[
				'label'     => esc_html__('Show Maximum Product', 'shopengine-pro'),
				'type'      => Controls_Manager::NUMBER,
				'min'		=> 1,
				'step'		=> 1,
				'default'	=> 8,
			]
		);
		
		$this->add_control(
			'shopengine_is_cats',
			[
				'label'        => esc_html__('Show Categories', 'shopengine-pro'),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__('Show', 'shopengine-pro'),
				'label_off'    => esc_html__('Hide', 'shopengine-pro'),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);


		$this->add_control(
			'shopengine_is_rating',
			[
				'label'        => esc_html__('Rating', 'shopengine-pro'),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__('Show', 'shopengine-pro'),
				'label_off'    => esc_html__('Hide', 'shopengine-pro'),
				'return_value' => 'yes',
				'default'      => 'yes',
				
			]
		);

		$this->add_control(
			'shopengine_show_regular_price',
			[
				'label'        => esc_html__('Show Regular Price', 'shopengine-pro'),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__('Show', 'shopengine-pro'),
				'label_off'    => esc_html__('Hide', 'shopengine-pro'),
				'return_value' => 'yes',
				'default'      => 'yes',
				'selectors'    => [
					'{{WRAPPER}} .shopengine-best-selling-product .price del' => 'display: block;',
				],
			]
		);


		$this->end_controls_section(); // end ./ Content Panel

		/*
			============================
			Grid Layout Control
			============================
		*/

		$this->start_controls_section(
			'shopengine_grid_layout',
			[
				'label' => esc_html__('Grid Layout', 'shopengine-pro'),
				'tab'   => Controls_Manager::TAB_LAYOUT,
				'condition' => [
					'shopengine_content_layout' => 'grid'
				]
			]
		);

		$this->add_responsive_control(
			'shopengine_grid_layout_column',
			[
				'label'     => esc_html__('Grid Columns', 'shopengine-pro'),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => 1,
						'max' => 15,
					],
				],
				'default'   => [
					'size' => 4,
				],

				'selectors' => [
					'{{WRAPPER}} .view-grid' => 'grid-template-columns: repeat({{SIZE}}, 1fr);',
				],
			]
		);

		$this->add_responsive_control(
			'shopengine_grid_layout_gap',
			[
				'label'     => esc_html__('Grid Gap', 'shopengine-pro'),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default'   => [
					'size' => 15,
				],

				'selectors' => [
					'{{WRAPPER}} .view-grid' => 'grid-gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section(); // end ./ Content Panel

		/*
			============================
			Product wrapper style
			============================
		*/

		$this->start_controls_section(
			'shopengine_section_product_wrapper',
			[
				'label' => esc_html__('Product Style', 'shopengine-pro'),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'           => 'shopengine_product_border',
				'label'          => esc_html__('Product Border', 'shopengine-pro'),
				'fields_options' => [
					'border' => [
						'default' => 'solid',
					],
					'width'  => [
						'label' => 'Border Width',
						'default' => [
							'top'      => '1',
							'right'    => '1',
							'bottom'   => '1',
							'left'     => '1',
							'isLinked' => true,
						],
						'selectors' => [
							'{{WRAPPER}} .shopengine-single-product-item' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
							'.rtl {{WRAPPER}} .shopengine-single-product-item' => 'border-width: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
						],
					],
					'color'  => [
						'default' => '#f2f2f2',
						'label' => 'Border Color',
					]
				],
				'selector' => '{{WRAPPER}} .shopengine-single-product-item'
			]
		);

		$this->add_responsive_control(
			'shopengine_product_padding',
			[
				'label'      => esc_html__('Padding', 'shopengine-pro'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px'],
				'default'    => [
					'top'      => '10',
					'right'    => '10',
					'bottom'   => '10',
					'left'     => '10',
					'isLinked' => false,
				],
				'selectors'  => [
					'{{WRAPPER}} .shopengine-single-product-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.rtl {{WRAPPER}} .shopengine-single-product-item' => 'padding: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				],

				'separator'  => 'before',
			]
		);

		$this->end_controls_section(); // end of product wrapper style

		/*
			============================
			Image Style
			============================
		*/

		$this->start_controls_section(
			'shopengine_section_image',
			[
				'label' => esc_html__('Image Style', 'shopengine-pro'),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'shopengine_image_height',
			[
				'label'     => esc_html__('Height', 'shopengine-pro'),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 500,
					],
				],
				'default'   => [
					'size' => 300,
				],

				'selectors' => [
					'{{WRAPPER}} .product-thumb img' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'shopengine_image_fit',
			[
				'label'   => esc_html__('Fit', 'shopengine-pro'),
				'type'    => Controls_Manager::SELECT,
				'default' => 'cover',
				'options' => [
					'cover'    => esc_html__('Cover', 'shopengine-pro'),
					'contain'  => esc_html__('Contain', 'shopengine-pro'),
					'fill'     => esc_html__('Fill', 'shopengine-pro')
				],
				'selectors' => [
					'{{WRAPPER}} .product-thumb img'  => 'object-fit: {{VALUE}}',
				],
			]
		);

		$this->add_responsive_control(
			'shopengine_image_position',
			[
				'label'   => esc_html__('Position', 'shopengine-pro'),
				'type'    => Controls_Manager::SELECT,
				'default' => 'center',
				'options' => [
					'top'     => esc_html__('Top', 'shopengine-pro'),
					'center'  => esc_html__('Center', 'shopengine-pro'),
					'bottom'  => esc_html__('Bottom', 'shopengine-pro')
				],
				'selectors'  => [
					'{{WRAPPER}} .product-thumb img'  => 'object-position: {{VALUE}}',
				],
			]
		);

		$this->end_controls_section(); // end Image Style

		/*
			=============================
			Product Category style
			=============================
		*/
		$this->start_controls_section(
			'shopengine_section_style_cats',
			[
				'label'     => esc_html__('Product Categories', 'shopengine-pro'),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'shopengine_is_cats' => 'yes',
				],
			]
		);

		$this->add_control(
			'shopengine_cats_color',
			[
				'label'     => esc_html__('Color', 'shopengine-pro'),
				'type'      => Controls_Manager::COLOR,
				'alpha'     => false,
				'default'   => '#858585',
				'selectors' => [
					'{{WRAPPER}} .product-category a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'           => 'shopengine_cats_font',
				'label'          => esc_html__('Typography', 'shopengine-pro'),
				'selector'       => '{{WRAPPER}} .product-category a',
				'exclude'        => ['font_family', 'letter_spacing', 'text_decoration', 'font_style'],
				'fields_options' => [
					'typography'  => [
						'default' => 'custom',
					],
					'font_weight' => [
						'default' => '400',
					],
					'font_size'   => [
						'label'      => esc_html__('Font Size (px)', 'shopengine-pro'),
						'default'    => [
							'size' => '13',
							'unit' => 'px',
						],
						'responsive' => false,
						'size_units' => ['px'],
					],
					'line_height' => [
						'label'      => esc_html__('Line-height (px)', 'shopengine-pro'),
						'default'    => [
							'size' => '14',
							'unit' => 'px',
						],
						'responsive' => false,
						'size_units' => ['px'],
					],
				],
			]
		);


		$this->add_control(
			'shopengine_cats_spacing',
			[
				'label'      => esc_html__('Padding', 'shopengine-pro'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px'],
				'default'    => [
					'top'      => '0',
					'right'    => '0',
					'bottom'   => '5',
					'left'     => '0',
					'isLinked' => false,
					'unit'     => 'px',
				],
				'selectors'  => [
					'{{WRAPPER}} .product-category' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.rtl {{WRAPPER}} .product-category' => 'padding: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				],
				'separator'  => 'before',
			]
		);
		$this->end_controls_section(); // end of product category


		/*
			=============================
			product title start
			=============================
		*/

		$this->start_controls_section(
			'shopengine_section_style_title',
			[
				'label' => esc_html__('Product Title', 'shopengine-pro'),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'shopengine_title_color',
			[
				'label'     => esc_html__('Color', 'shopengine-pro'),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#101010',
				'alpha'     => false,
				'selectors' => [
					'{{WRAPPER}} .product-title a' => 'color: {{VALUE}};',
				],
			]
		);
		
		$this->add_control(
			'shopengine_title_hover_color',
			[
				'label'     => esc_html__( 'Hover Color', 'shopengine-pro' ),
				'type'      => Controls_Manager::COLOR,
				'alpha'     => false,
				'selectors' => [
					'{{WRAPPER}} .product-title a:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'           => 'shopengine_title_color_typography',
				'label'          => esc_html__('Typography', 'shopengine-pro'),
				'selector'       => '{{WRAPPER}} .product-title a',
				'exclude'        => ['font_family', 'letter_spacing', 'text_decoration', 'font_style'],
				'fields_options' => [
					'typography'     => [
						'default' => 'custom',
					],
					'font_weight'    => [
						'default' => '500',
					],
					'font_size'      => [
						'label'      => esc_html__('Font Size (px)', 'shopengine-pro'),
						'default'    => [
							'size' => '16',
							'unit' => 'px',
						],
						'responsive' => false,
						'size_units' => ['px'],
					],
					'text_transform' => [
						'default' => 'capitalize',
					],
					'line_height'    => [
						'label'      => esc_html__('Line Height (px)', 'shopengine-pro'),
						'default'    => [
							'size' => '18',
							'unit' => 'px',
						],
						'responsive' => false,
						'size_units' => ['px'] // enable only px
					],
				],
			]
		);


		$this->add_responsive_control(
			'shopengine_title_padding',
			[
				'label'      => esc_html__('Padding', 'shopengine-pro'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px'],
				'selectors'  => [
					'{{WRAPPER}} .product-title a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.rtl {{WRAPPER}} .product-title a' => 'padding: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				],
				'separator'  => 'before',
			]
		);
		$this->end_controls_section(); // end of product title

		/*
			==============================
			product rating
			==============================
		 */
		$this->start_controls_section(
			'shopengine_section_rating',
			[
				'label'     => esc_html__('Rating', 'shopengine-pro'),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'shopengine_is_rating' => 'yes',
				],
			]
		);

		$this->add_control(
			'shopengine_product_start_color',
			[
				'label'     => esc_html__('Color', 'shopengine-pro'),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#FEC42D',
				'alpha'     => false,
				'selectors' => [
					'{{WRAPPER}} .product-rating .star-rating' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'shopengine_product_start_size',
			[
				'label'     => esc_html__('Font Size (px)', 'shopengine-pro'),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min'  => 0,
						'max'  => 50,
						'step' => 1,
					],
				],
				'default'   => [
					'unit' => 'px',
					'size' => 11,
				],
				'selectors' => [
					'{{WRAPPER}} .product-rating .star-rating, {{WRAPPER}} .product-rating .rating-count' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'shopengine_product_rating_gap',
			[
				'label'     => esc_html__('Star Gap (px)', 'shopengine-pro'),
				'type'      => Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'selectors' => [
					'{{WRAPPER}} .product-rating .star-rating' => 'letter-spacing: {{SIZE}}{{UNIT}}; width: calc(5.4em + (4 * {{SIZE}}{{UNIT}}));',
				],
			]
		);

		$this->add_responsive_control(
			'shopengine_product_star_padding',
			[
				'label'      => esc_html__('Margin', 'shopengine-pro'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px'],
				'selectors'  => [
					'{{WRAPPER}} .product-rating' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.rtl {{WRAPPER}} .product-rating' => 'margin: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				],
			]
		);


		$this->end_controls_section(); // end ./ product rating

		/*
			=============================
			product price start
			=============================
		*/
		$this->start_controls_section(
			'shopengine_section_style_price',
			[
				'label' => esc_html__('Product Price', 'shopengine-pro'),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'shopengine_sell_price_color',
			[
				'label'     => esc_html__('Color', 'shopengine-pro'),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#101010',
				'alpha'     => false,
				'selectors' => [
					'{{WRAPPER}} .product-price .price' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'           => 'shopengine_product_price_typography',
				'label'          => esc_html__('Typography', 'shopengine-pro'),
				'selector'       => '{{WRAPPER}} .product-price .price .amount',
				'exclude'        => ['font_family', 'text_transform', 'font_style', 'text_decoration', 'letter_spacing'],
				'fields_options' => [
					'typography'  => [
						'default' => 'custom',
					],
					'font_weight' => [
						'default' => '700',
					],
					'font_size'   => [
						'label'      => esc_html__('Font Size (px)', 'shopengine-pro'),
						'default'    => [
							'size' => '18',
							'unit' => 'px',
						],
						'responsive' => false,
						'size_units' => ['px'],
					],
					'line_height' => [
						'label'      => esc_html__('Line Height (px)', 'shopengine-pro'),
						'default'    => [
							'size' => '22',
							'unit' => 'px',
						],
						'responsive' => false,
						'size_units' => ['px'],
					],
				],
			]
		);

		$this->add_control(
			'shopengine_price_reg_head',
			[
				'label'     => esc_html__('Regular Price', 'shopengine-pro'),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					'shopengine_show_regular_price' => 'yes',
				],
			]
		);


		$this->add_responsive_control(
			'shopengine_price_reg_size',
			[
				'label'      => esc_html__('Font Size (px)', 'shopengine-pro'),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'selectors'  => [
					'{{WRAPPER}} .product-price .price > del bdi' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'shopengine_price_padding',
			[
				'label'      => esc_html__('Padding', 'shopengine-pro'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px'],
				'selectors'  => [
					'{{WRAPPER}} .product-price .price' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.rtl {{WRAPPER}} .product-price .price' => 'padding: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				],
				'separator'  => 'before',
			]
		);

		$this->end_controls_section(); // end of product price

		// end off tag
		/*
		   ==============================
		   Button settings
		   ==============================
		*/

		$this->start_controls_section(
			'shopengine_section_button',
			[
				'label' => esc_html__('Add To Cart Button', 'shopengine-pro'),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'shopengine_archvie_btn_padding',
			[
				'label'      => esc_html__('Padding', 'shopengine-pro'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px'],
				'default'    => [
					'top'      => '9',
					'right'    => '21',
					'bottom'   => '10',
					'left'     => '21',
					'unit'     => 'px',
					'isLinked' => false,
				],
				'selectors'  => [
					'{{WRAPPER}} .add-to-cart-bt a.button:not(.shopengine-quickview-trigger)' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
					'.rtl {{WRAPPER}} .add-to-cart-bt a.button:not(.shopengine-quickview-trigger)' => 'padding: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}} !important;',
				],
			]
		);

		$this->add_responsive_control(
			'shopengine_archvie_btn_margin',
			[
				'label'      => esc_html__('Margin', 'shopengine-pro'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px'],
				'default'    => [
					'top'      => '0',
					'right'    => '0',
					'bottom'   => '0',
					'left'     => '0',
					'unit'     => 'px',
					'isLinked' => true,
				],
				'selectors'  => [
					'{{WRAPPER}} .add-to-cart-bt a.button:not(.shopengine-quickview-trigger)' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
					'.rtl {{WRAPPER}} .add-to-cart-bt a.button:not(.shopengine-quickview-trigger)' => 'margin: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}} !important;',
				],
			]
		);

		$this->add_control(
			'shopengine_archvie_btn_radius',
			[
				'label'      => esc_html__('Border Radius', 'shopengine-pro'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px'],
				'selectors'  => [
					'{{WRAPPER}} .add-to-cart-bt a.button:not(.shopengine-quickview-trigger)' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
					'.rtl {{WRAPPER}} .add-to-cart-bt a.button:not(.shopengine-quickview-trigger)' => 'border-radius: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}} !important;',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'shopengine_archvie_btn_typography',
				'label'    => esc_html__('Button Typography', 'shopengine-pro'),
				'selector' => '{{WRAPPER}} .add-to-cart-bt a.button:not(.shopengine-quickview-trigger)',
				'exclude'  => ['font_family', 'letter_spacing', 'text_decoration', 'font_style', 'line_height'],
				'fields_options' => [
					'font_size'   => [
						'label'      => esc_html__('Font Size (px)', 'shopengine-pro'),
						'responsive' => false,
						'size_units' => ['px'],
					],
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'shopengine_archvie_btn_box_shadow',
				'label'    => esc_html__('Box Shadow', 'shopengine-pro'),
				'selector' => '{{WRAPPER}} .add-to-cart-bt .button[data-quantity]',
			]
		);


		$this->start_controls_tabs('shopengine_archvie_btn_tabs');

		$this->start_controls_tab(
			'shopengine_archvie_btn_tab_normal',
			[
				'label' => esc_html__('Normal', 'shopengine-pro'),
			]
		);

		$this->add_control(
			'shopengine_archvie_btn_normal_clr',
			[
				'label'     => esc_html__('Color', 'shopengine-pro'),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#f1f1f1',
				'alpha'     => false,
				'selectors' => [
					'{{WRAPPER}} .add-to-cart-bt a.button:not(.shopengine-quickview-trigger)' => 'text-align:left;color: {{VALUE}} !important;',
				],
			]
		);

		$this->add_control(
			'shopengine_archvie_btn_normal_bg',
			[
				'label'     => esc_html__('Background', 'shopengine-pro'),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#505255',
				'alpha'     => false,
				'selectors' => [
					'{{WRAPPER}} .add-to-cart-bt a.button:not(.shopengine-quickview-trigger)' => 'background: {{VALUE}}  !important;',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'shopengine_archvie_btn_tabs_hover',
			[
				'label' => esc_html__('Hover', 'shopengine-pro'),
			]
		);

		$this->add_control(
			'shopengine_archvie_btn_hover_clr',
			[
				'label'     => esc_html__('Color', 'shopengine-pro'),
				'type'      => Controls_Manager::COLOR,
				'alpha'     => false,
				'default'   => '#f1f1f1',
				'selectors' => [
					'{{WRAPPER}} .add-to-cart-bt a.button:not(.shopengine-quickview-trigger):hover' => 'color: {{VALUE}} !important;',
				],
			]
		);

		$this->add_control(
			'shopengine_archvie_btn_hover_bg',
			[
				'label'     => esc_html__('Background', 'shopengine-pro'),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#101010',
				'alpha'     => false,
				'selectors' => [
					'{{WRAPPER}} .add-to-cart-bt a.button:not(.shopengine-quickview-trigger):hover' => 'background: {{VALUE}} !important;',
				],
			]
		);


		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->end_controls_section(); // end ./ Button settings
	}

	/**
	 * Product Action Buttons
	 */
	public function show_product_action_btns() {
		woocommerce_template_loop_product_link_close();
		?>
        <div class="loop-product--btns">
            <div class="loop-product--btns-inner">
				<?php woocommerce_template_loop_add_to_cart(); ?>
            </div>
        </div>
		<?php
		woocommerce_template_loop_product_link_open();
	}

	protected function screen() {

		$settings = $this->get_settings_for_display();
		$settings['shopengine_group_btns'] = 'no';
		$tpl = Products::instance()->get_widget_template($this->get_name(), 'default', \ShopEngine_Pro::widget_dir());

		include $tpl;
	}
}