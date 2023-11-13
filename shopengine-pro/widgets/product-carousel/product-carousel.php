<?php

namespace Elementor;

use ShopEngine\Core\Elementor_Controls\Controls_Manager as ShopEngine_Controls_Manager;
use ShopEngine\Widgets\Products;

defined('ABSPATH') || exit;


class ShopEngine_Product_Carousel extends \ShopEngine\Base\Widget {

	public function config() {
		return new ShopEngine_Product_Carousel_Config();
	}

	protected function register_controls() {
		// GENERAL - SECTION
		$this->start_controls_section(
			'general',
			[
				'label' => esc_html__('General', 'shopengine-pro'),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'products_per_page',
			[
				'label'   => esc_html__('Products Per Page', 'shopengine-pro'),
				'type'    => Controls_Manager::NUMBER,
				'default' => 12,
			]
		);

		$this->add_control(
			'product_order',
			[
				'label'   => esc_html__('Order', 'shopengine-pro'),
				'type'    => Controls_Manager::SELECT,
				'default' => 'DESC',
				'options' => [
					'ASC'  => esc_html__('ASC', 'shopengine-pro'),
					'DESC' => esc_html__('DESC', 'shopengine-pro'),
				],
			]
		);

		$this->add_control(
			'product_orderby',
			[
				'label'   => esc_html__('Order By', 'shopengine-pro'),
				'type'    => Controls_Manager::SELECT,
				'default' => 'date',
				'options' => $this->config()->product_order_by(),
			]
		);

		$this->add_control(
			'product_by',
			[
				'label'     => esc_html__('Product Query By', 'shopengine-pro'),
				'type'      => Controls_Manager::SELECT2,
				'options'   => $this->config()->product_query_by(),
				'default'   => 'product',
				'seperator' => 'before',
			]
		);

		$this->add_control(
			'term_list',
			[
				'label'       => esc_html__('Select Categories', 'shopengine-pro'),
				'type'        => ShopEngine_Controls_Manager::AJAXSELECT2,
				'options'     => 'ajaxselect2/product_cat',
				'multiple'    => true,
				'label_block' => true,
				'condition'   => [
					'product_by' => 'category',
				],
			]
		);

		$this->add_control(
			'tag_lists',
			[
				'label'       => esc_html__('Select Tags', 'shopengine-pro'),
				'type'        => ShopEngine_Controls_Manager::AJAXSELECT2,
				'options'     => 'ajaxselect2/product_tags',
				'multiple'    => true,
				'label_block' => true,
				'condition'   => [
					'product_by' => 'tag',
				],
			]
		);

		$this->add_control(
			'product_list',
			[
				'label'       => esc_html__('Select Products', 'shopengine-pro'),
				'type'        => ShopEngine_Controls_Manager::AJAXSELECT2,
				'options'     => 'ajaxselect2/product_list',
				'multiple'    => true,
				'label_block' => true,
				'condition'   => [
					'product_by' => 'product',
				],
			]
		);

		$this->add_control(
			'rating_list',
			[
				'label'       => esc_html__('Select Rating', 'shopengine-pro'),
				'type'        => Controls_Manager::SELECT2,
				'options'     => [
					'1' => esc_html__('1 star', 'shopengine-pro'),
					'2' => esc_html__('2 star', 'shopengine-pro'),
					'3' => esc_html__('3 star', 'shopengine-pro'),
					'4' => esc_html__('4 star', 'shopengine-pro'),
					'5' => esc_html__('5 star', 'shopengine-pro'),
				],
				'multiple'    => true,
				'label_block' => true,
				'default'     => [5],
				'condition'   => [
					'product_by' => 'rating',
				],
			]
		);

		$this->add_control(
			'pa_attribute_list',
			[
				'label'       => esc_html__('Select Attributes', 'shopengine-pro'),
				'type'        => ShopEngine_Controls_Manager::AJAXSELECT2,
				'options'     => 'ajaxselect2/product_pa_list',
				'multiple'    => true,
				'label_block' => true,
				'condition'   => [
					'product_by' => 'attribute',
				],
			]
		);

		$this->add_control(
			'author_list',
			[
				'label'       => esc_html__('Select Authors', 'shopengine-pro'),
				'type'        => ShopEngine_Controls_Manager::AJAXSELECT2,
				'options'     => 'ajaxselect2/product_authors',
				'multiple'    => true,
				'label_block' => true,
				'condition'   => [
					'product_by' => 'author',
				],
			]
		);

		$this->end_controls_section();

		// CAROUSEL - SECTION
		$this->start_controls_section(
			'carousel_settings',
			[
				'label' => esc_html__('Carousel Settings', 'shopengine-pro'),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_responsive_control(
			'slider_spacing',
			[
				'label' => esc_html__( 'Spacing (px)', 'shopengine-pro' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					],
				],
				'devices' => [ 'desktop', 'tablet', 'mobile' ],
				'desktop_default' => [
					'size' => 30,
					'unit' => 'px',
				],
				'tablet_default' => [
					'size' => 30,
					'unit' => 'px',
				],
				'mobile_default' => [
					'size' => 30,
					'unit' => 'px',
				],
				'default' => [
					'size' => 30,
					'unit' => 'px',
				],
				'render_type' => 'template',
				'selectors' => [
					'{{WRAPPER}} .shopengine-product-carousel' => '--ekit-team-slider-spacing: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'slide_to_show',
			[
				'label' => esc_html__( 'Slides To Show', 'shopengine-pro' ),
				'type' =>  Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 12,
						'step' => 1,
					],
				],
				'devices' => [ 'desktop', 'tablet', 'mobile' ],
				'desktop_default' => [
					'size' => 4,
					'unit' => 'px',
				],
				'tablet_default' => [
					'size' => 3,
					'unit' => 'px',
				],
				'mobile_default' => [
					'size' => 1,
					'unit' => 'px',
				],
				'default' => [
					'size' => 4,
					'unit' => 'px',
				],
				'render_type' => 'template',
				'selectors' => [
					'{{WRAPPER}} .shopengine-product-carousel' => '--ekit-team-slider-slides-to-show: {{SIZE}};',
				],
			]
		);

		$this->add_control(
			'carousel_autoplay',
			[
				'label'        => esc_html__('Autoplay', 'shopengine-pro'),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__('Yes', 'shopengine-pro'),
				'label_off'    => esc_html__('No', 'shopengine-pro'),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'carousel_speed',
			[
				'label'        => esc_html__('Speed (ms)', 'shopengine-pro'),
				'type'         => Controls_Manager::NUMBER,
				'default'      => 1000,
				'min'          => 500,
				'max'          => 15000,
				'step'         => 100,
			]
		);

		$this->add_control(
			'carousel_loop',
			[
				'label'        => esc_html__('Enable Loop?', 'shopengine-pro'),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__('Yes', 'shopengine-pro'),
				'label_off'    => esc_html__('No', 'shopengine-pro'),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'carousel_arrow',
			[
				'label'        => esc_html__('Show Arrow', 'shopengine-pro'),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__('Yes', 'shopengine-pro'),
				'label_off'    => esc_html__('No', 'shopengine-pro'),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'arrow_type',
			[
				'label' =>esc_html__( 'Arrow Type', 'shopengine-pro' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'icon',
				'options' => [
					'icon' => esc_html__( 'Icon', 'shopengine-pro' ),
					'text' => esc_html__( 'Text', 'shopengine-pro' ),
					'text_with_icon' => esc_html__( 'Text With Icon', 'shopengine-pro' ),
				],
				'condition' => [
					'carousel_arrow' => 'yes'
				]
			]
		);

		$this->add_control(
			'arrow_left_text',
			[
				'label' => esc_html__( 'Left Arrow Text', 'shopengine-pro' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'Previous', 'shopengine-pro' ),
				'dynamic' => [
					'active' => true,
				],
				'conditions' => [
					'relation' => 'and',
					'terms' => [
						[
							'name' => 'carousel_arrow',
							'operator' => '===',
							'value' => 'yes',
						],
						[
							'relation' => 'or',
							'terms' => [
								[
									'name' => 'arrow_type',
									'operator' => '===',
									'value' => 'text',
								],
								[
									'name' => 'arrow_type',
									'operator' => '===',
									'value' => 'text_with_icon',
								],
							],
						],
					],
				],
			]
		);

		$this->add_control(
			'arrow_right_text',
			[
				'label' => esc_html__( 'Right Arrow Text', 'shopengine-pro' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'Next', 'shopengine-pro' ),
				'dynamic' => [
					'active' => true,
				],
				'conditions' => [
					'relation' => 'and',
					'terms' => [
						[
							'name' => 'carousel_arrow',
							'operator' => '===',
							'value' => 'yes',
						],
						[
							'relation' => 'or',
							'terms' => [
								[
									'name' => 'arrow_type',
									'operator' => '===',
									'value' => 'text',
								],
								[
									'name' => 'arrow_type',
									'operator' => '===',
									'value' => 'text_with_icon',
								],
							],
						],
					],
				],
			]
		);

		$this->add_control(
			'left_arrow_icon',
			[
				'label' => esc_html__( 'Left Arrow Icon', 'shopengine-pro' ),
				'type' => Controls_Manager::ICONS,
				'default' => [
					'value' => 'fas fa-chevron-left',
					'library' => 'fa-solid',
				],
				'conditions' => [
					'relation' => 'and',
					'terms' => [
						[
							'name' => 'carousel_arrow',
							'operator' => '===',
							'value' => 'yes',
						],
						[
							'relation' => 'or',
							'terms' => [
								[
									'name' => 'arrow_type',
									'operator' => '===',
									'value' => 'icon',
								],
								[
									'name' => 'arrow_type',
									'operator' => '===',
									'value' => 'text_with_icon',
								],
							],
						],
					],
				],
			]
		);

		$this->add_control(
			'right_arrow_icon',
			[
				'label' => esc_html__( 'Right Arrow Icon', 'shopengine-pro' ),
				'type' => Controls_Manager::ICONS,
				'default' => [
					'value' => 'fas fa-chevron-right',
					'library' => 'fa-solid',
				],
				'conditions' => [
					'relation' => 'and',
					'terms' => [
						[
							'name' => 'carousel_arrow',
							'operator' => '===',
							'value' => 'yes',
						],
						[
							'relation' => 'or',
							'terms' => [
								[
									'name' => 'arrow_type',
									'operator' => '===',
									'value' => 'icon',
								],
								[
									'name' => 'arrow_type',
									'operator' => '===',
									'value' => 'text_with_icon',
								],
							],
						],
					],
				],
			]
		);

		$this->add_control(
			'carousel_dot',
			[
				'label'        => esc_html__('Show Dot', 'shopengine-pro'),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__('Yes', 'shopengine-pro'),
				'label_off'    => esc_html__('No', 'shopengine-pro'),
				'return_value' => 'yes',
				'default'      => '',
			]
		);

		$this->end_controls_section();

		// SETTINGS - SECTION
		$this->start_controls_section(
			'settings',
			[
				'label' => esc_html__('Settings', 'shopengine-pro'),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		// SETTINGS - BADGE
		$this->add_control(
			'badge_settings',
			[
				'label'     => esc_html__('Badge', 'shopengine-pro'),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'show_sale',
			[
				'label'        => esc_html__('Show Sale Badge?', 'shopengine-pro'),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__('Yes', 'shopengine-pro'),
				'label_off'    => esc_html__('No', 'shopengine-pro'),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'show_off',
			[
				'label'        => esc_html__('Show Discount Percentage', 'shopengine-pro'),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__('Yes', 'shopengine-pro'),
				'label_off'    => esc_html__('No', 'shopengine-pro'),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'show_tag',
			[
				'label'        => esc_html__('Show Tag', 'shopengine-pro'),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__('Yes', 'shopengine-pro'),
				'label_off'    => esc_html__('No', 'shopengine-pro'),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'show_stock_out_badge',
			[
				'label'        => esc_html__('Show Stock Out Badge', 'shopengine-pro'),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__('Yes', 'shopengine-pro'),
				'label_off'    => esc_html__('No', 'shopengine-pro'),
				'return_value' => 'yes',
				'default'      => '',
			]
		);
		
        $this->add_control(
            'out_of_stock_product_visibility',
            [
                'label'   => esc_html__('Out of Stock Visibility', 'shopengine-pro'),
                'type'    => Controls_Manager::SELECT,
                'default' => 'default',
                'options' => [
                    'default' => esc_html__('Default', 'shopengine-pro'),
                    'show'  => esc_html__('Show', 'shopengine-pro'),
                    'hide' => esc_html__('Hide', 'shopengine-pro')
                ]
            ]
        );

		$this->add_control(
			'badge_position',
			[
				'label'      => esc_html__('Badge Position', 'shopengine-pro'),
				'type'       => Controls_Manager::CHOOSE,
				'options'    => [
					'top-left'  => [
						'title' => esc_html__('Top Left', 'shopengine-pro'),
						'icon'  => 'eicon-h-align-left',
					],
					'top-right' => [
						'title' => esc_html__('Top Right', 'shopengine-pro'),
						'icon'  => 'eicon-h-align-right',
					],
					'custom'    => [
						'title' => esc_html__('Custom', 'shopengine-pro'),
						'icon'  => 'eicon-settings',
					],
				],
				'default'    => 'top-right',
				'toggle'     => false,
				'conditions' => [
					'relation' => 'or',
					'terms'    => [
						[
							'name'     => 'show_sale',
							'operator' => '===',
							'value'    => 'yes',
						],
						[
							'name'     => 'show_off',
							'operator' => '===',
							'value'    => 'yes',
						],
					],
				],
			]
		);

		$this->add_control(
			'badge_position_x_axis',
			[
				'label'      => esc_html__('Badge Position (X axis)', 'shopengine-pro'),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => ['px', '%'],
				'range'      => [
					'px' => [
						'min'  => 0,
						'max'  => 1000,
						'step' => 1,
					],
					'%'  => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default'    => [
					'unit' => '%',
					'size' => 4,
				],
				'selectors'  => [
					'{{WRAPPER}} .product-tag-sale-badge' => 'left: {{SIZE}}{{UNIT}};',
					'.rtl {{WRAPPER}} .product-tag-sale-badge' => 'right: {{SIZE}}{{UNIT}};',
				],
				'condition'  => [
					'badge_position' => 'custom',
				],
			]
		);

		$this->add_control(
			'badge_position_y_axis',
			[
				'label'      => esc_html__('Badge Position (Y axis)', 'shopengine-pro'),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => ['px', '%'],
				'range'      => [
					'px' => [
						'min'  => 0,
						'max'  => 1000,
						'step' => 1,
					],
					'%'  => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default'    => [
					'unit' => '%',
					'size' => 4,
				],
				'selectors'  => [
					'{{WRAPPER}} .product-tag-sale-badge' => 'top: {{SIZE}}{{UNIT}};',
				],
				'condition'  => [
					'badge_position' => 'custom',
				],
			]
		);

		$this->add_control(
			'badge_align',
			[
				'label'      => esc_html__('Badge Align', 'shopengine-pro'),
				'type'       => Controls_Manager::CHOOSE,
				'options'    => [
					'vertical'   => [
						'title' => esc_html__('Vertical', 'shopengine-pro'),
						'icon'  => 'eicon-navigation-vertical',
					],
					'horizontal' => [
						'title' => esc_html__('Horizontal', 'shopengine-pro'),
						'icon'  => 'eicon-navigation-horizontal',
					],
				],
				'default'    => 'horizontal',
				'toggle'     => false,
				'conditions' => [
					'relation' => 'or',
					'terms'    => [
						[
							'name'     => 'show_sale',
							'operator' => '===',
							'value'    => 'yes',
						],
						[
							'name'     => 'show_off',
							'operator' => '===',
							'value'    => 'yes',
						],
					],
				],
			]
		);

		// SETTINGS - TITLE
		$this->add_control(
			'title_settings',
			[
				'label'     => esc_html__('Title', 'shopengine-pro'),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'title_character',
			[
				'label'        => esc_html__('Chracter to Show', 'shopengine-pro'),
				'description'  => esc_html__('Chracter to show in the product title', 'shopengine-pro'),
				'type'         => Controls_Manager::NUMBER,
				'return_value' => 'yes',
				'default'      => 30,
			]
		);

		// SETTINGS - HOVER
		$this->add_control(
			'product_hover_overlay_settings',
			[
				'label'     => esc_html__('Product Hover', 'shopengine-pro'),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'show_product_hover_overlay',
			[
				'label'        => esc_html__('Show Product Hover', 'shopengine-pro'),
				'description'  => esc_html__('Styling controls are in the style tab', 'shopengine-pro'),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__('Yes', 'shopengine-pro'),
				'label_off'    => esc_html__('No', 'shopengine-pro'),
				'default'      => 'yes',
				'return_value' => 'yes',
				'selectors'    => [
					'{{WRAPPER}} .shopengine-product-carousel .overlay-add-to-cart' => 'display: flex;',
				],
			]
		);

		$this->add_control(
			'product_hover_overlay_position',
			[
				'label'     => esc_html__('Position', 'shopengine-pro'),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => [
					'left'   => [
						'title' => esc_html__('Left', 'shopengine-pro'),
						'icon'  => 'eicon-h-align-left',
					],
					'right'  => [
						'title' => esc_html__('Right', 'shopengine-pro'),
						'icon'  => 'eicon-h-align-right',
					],
					'bottom' => [
						'title' => esc_html__('Bottom', 'shopengine-pro'),
						'icon'  => 'eicon-v-align-bottom',
					],
					'center' => [
						'title' => esc_html__('Center', 'shopengine-pro'),
						'icon'  => 'eicon-h-align-center',
					],
				],
				'default'   => 'bottom',
				'toggle'    => false,
				'condition' => [
					'show_product_hover_overlay' => 'yes',
				],
			]
		);

		// SETTINGS - PRICE
		$this->add_control(
			'price_settings',
			[
				'label'     => esc_html__('Price', 'shopengine-pro'),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'price_alignment',
			[
				'label'     => esc_html__('Alignment', 'shopengine-pro'),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'flex-start',
				'options'   => [
					'flex-start'    => esc_html__('Start', 'shopengine-pro'),
					'center'        => esc_html__('Center', 'shopengine-pro'),
					'flex-end'      => esc_html__('End', 'shopengine-pro'),
					'space-around'  => esc_html__('Space Around', 'shopengine-pro'),
					'space-between' => esc_html__('Space Between', 'shopengine-pro'),
					'space-evenly'  => esc_html__('Space Evenly', 'shopengine-pro'),
				],
				'selectors' => [
					'{{WRAPPER}} .shopengine-product-carousel .product-price .price' => 'justify-content: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'show_off_price_tag',
			[
				'label'        => esc_html__('Show Off Tag', 'shopengine-pro'),
				'description'  => esc_html__('Styling controls are in the style tab', 'shopengine-pro'),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__('Yes', 'shopengine-pro'),
				'label_off'    => esc_html__('No', 'shopengine-pro'),
				'return_value' => 'yes',
				'default'      => 'yes',
				'selectors'    => [
					'{{WRAPPER}} .shopengine-product-carousel .product-price .price .shopengine-discount-badge' => 'display: inline-block;',
				],
			]
		);

		// SETTINGS - CATEGORY
		$this->add_control(
			'category_settings',
			[
				'label'     => esc_html__('Category', 'shopengine-pro'),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'show_category',
			[
				'label'        => esc_html__('Show Category?', 'shopengine-pro'),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__('Yes', 'shopengine-pro'),
				'label_off'    => esc_html__('No', 'shopengine-pro'),
				'return_value' => 'yes',
				'default'      => 'yes',
				'selectors'    => [
					'{{WRAPPER}} .shopengine-product-carousel .product-category' => 'display: inline-block;',
				],
			]
		);

		$this->add_control(
			'category_limit',
			[
				'label'     => esc_html__('Category Limit', 'shopengine-pro'),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 1,
				'min'       => 1,
				'max'       => 100,
				'step'      => 1,
				'condition' => [
					'show_category' => 'yes',
				],
			]
		);

		// SETTINGS - RATTING
		$this->add_control(
			'show_rating',
			[
				'label'       => esc_html__('Show Rating?', 'shopengine-pro'),
				'description' => esc_html__('Styling controls are in the style tab', 'shopengine-pro'),
				'type'        => Controls_Manager::SWITCHER,
				'label_on'    => esc_html__('Yes', 'shopengine-pro'),
				'label_off'   => esc_html__('No', 'shopengine-pro'),
				'default'     => 'yes',
				'selectors'   => [
					'{{WRAPPER}} .shopengine-product-carousel .product-rating' => 'display: block;',
				],
				'separator'   => 'before',
			]
		);

		$this->end_controls_section();

		// STYLE - PRODUCT WRAP
		$this->start_controls_section(
			'product_wrap_style_section',
			[
				'label' => esc_html__('Product Wrap', 'shopengine-pro'),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'product_content_align',
			[
				'label'     => esc_html__('Content Alignment', 'shopengine-pro'),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => [
					'left'   => [
						'description' => esc_html__('Left', 'shopengine-pro'),
						'icon'        => 'eicon-text-align-left',
					],
					'center' => [
						'description' => esc_html__('Center', 'shopengine-pro'),
						'icon'        => 'eicon-text-align-center',
					],
					'right'  => [
						'description' => esc_html__('Right', 'shopengine-pro'),
						'icon'        => 'eicon-text-align-right',
					],
				],
				'prefix_class' => 'elementor-align-',
				'selectors_dictionary' => [
					'left'   => 'text-align :left; align-items: flex-start;',
					'right'  => 'text-align :right; align-items: flex-end;',
					'center' => 'text-align :center; align-items: center;'
				],
				'selectors' => [
					'{{WRAPPER}} .shopengine-product-carousel .shopengine-single-product-item' => '{{VALUE}};',
					'.rtl {{WRAPPER}}.elementor-align-left .shopengine-single-product-item' => 'text-align: right;',
					'.rtl {{WRAPPER}}.elementor-align-right .shopengine-single-product-item' => 'text-align: left;',
				],
			]
		);

		$this->add_control(
			'product_item_bg_color',
			[
				'label'     => esc_html__('Background Color', 'shopengine-pro'),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#fff',
				'alpha'     => false,
				'selectors' => [
					'{{WRAPPER}} .shopengine-single-product-item' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'product_item_column_gap',
			[
				'label'      => esc_html__('Column Gap (px)', 'shopengine-pro'),
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
					'size' => '20',
				]
			]
		);

		$this->add_responsive_control(
			'product_wrap_padding',
			[
				'label'      => esc_html__('Padding (px)', 'shopengine-pro'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px'],
				'default'    => [
					'top'      => '15',
					'right'    => '15',
					'bottom'   => '15',
					'left'     => '15',
					'unit'     => 'px',
					'isLinked' => true,
				],
				'selectors'  => [
					'{{WRAPPER}} .shopengine-single-product-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.rtl {{WRAPPER}} .shopengine-single-product-item' => 'padding: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				],
				'separator'  => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'      => 'product_wrap_border',
				'label'     => esc_html__('Border', 'shopengine-pro'),
				'selector'  => '{{WRAPPER}} .shopengine-single-product-item',
				'fields_options' => [
					'width'  => [
						'selectors' => [
							'{{WRAPPER}} .shopengine-single-product-item' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
							'.rtl {{WRAPPER}} .shopengine-single-product-item' => 'border-width: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
						],	
					]
				],
				'separator' => 'before',
			]
		);

		$this->end_controls_section();

		// STYLE - PRODUCT IMAGE
		$this->start_controls_section(
			'product_image_style',
			[
				'label' => esc_html__('Product Image', 'shopengine-pro'),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'product_image_bg',
			[
				'label'     => esc_html__('Image Background', 'shopengine-pro'),
				'type'      => Controls_Manager::COLOR,
				'alpha'     => false,
				'selectors' => [
					'{{WRAPPER}} .product-thumb' => 'background: {{VALUE}}',
				],
			]
		);

		$this->add_responsive_control(
			'product_image_margin',
			[
				'label'      => esc_html__('Margin (px)', 'shopengine-pro'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px'],
				'default'    => [
					'top'      => '0',
					'right'    => '0',
					'bottom'   => '15',
					'left'     => '0',
					'unit'     => 'px',
					'isLinked' => false,
				],
				'selectors'  => [
					'{{WRAPPER}} .product-thumb' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.rtl {{WRAPPER}} .product-thumb' => 'margin: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				],
				'separator'  => 'before',
			]
		);

		$this->end_controls_section();

		// STYLE - 	PRODUCT BADGE
		$this->start_controls_section(
			'product_badge_style_section',
			[
				'label'      => esc_html__('Product Badge', 'shopengine-pro'),
				'tab'        => Controls_Manager::TAB_STYLE,
				'conditions' => [
					'relation' => 'or',
					'terms'    => [
						[
							'name'     => 'show_sale',
							'operator' => '===',
							'value'    => 'yes',
						],
						[
							'name'     => 'show_off',
							'operator' => '===',
							'value'    => 'yes',
						],
					],
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'           => 'product_badge_typography',
				'label'          => esc_html__('Typography', 'shopengine-pro'),
				'selector'       => '{{WRAPPER}} .product-tag-sale-badge .tag a, {{WRAPPER}} .product-tag-sale-badge .no-link',
				'exclude'        => ['font_family', 'font_style', 'letter_spacing', 'text_decoration'],
				'fields_options' => [
					'typography'  => [
						'default' => 'custom',
					],
					'font_weight' => [
						'default' => '700',
					],
					'font_size'   => [
						'default'    => [
							'size' => '12',
							'unit' => 'px',
						],
						'label'      => esc_html__('Font Size (px)', 'shopengine-pro'),
						'size_units' => ['px'],
						'responsive' => false,
					],
					'line_height' => [
						'default'    => [
							'size' => '24',
							'unit' => 'px',
						],
						'size_units' => ['px'], // enable only px
						'responsive' => false,
					],
				],
			]
		);

		$this->add_control(
			'product_badge_color',
			[
				'label'     => esc_html__('Color', 'shopengine-pro'),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'alpha'     => false,
				'selectors' => [
					'{{WRAPPER}} .product-tag-sale-badge .tag a, {{WRAPPER}} .product-tag-sale-badge .no-link' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'product_badge_bg',
			[
				'label'     => esc_html__('Badge Background', 'shopengine-pro'),
				'type'      => Controls_Manager::COLOR,
				'alpha'     => false,
				'default'   => '#f03d3f',
				'selectors' => [
					'{{WRAPPER}} .product-tag-sale-badge .tag a, {{WRAPPER}} .product-tag-sale-badge .no-link' => 'background: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'product_percentage_badge_bg',
			[
				'label'     => esc_html__('Percentage Badge Background', 'shopengine-pro'),
				'type'      => Controls_Manager::COLOR,
				'alpha'     => false,
				'selectors' => [
					'{{WRAPPER}} .product-tag-sale-badge .off' => 'background: {{VALUE}}',
				],
				'condition' => [
					'show_off' => 'yes',
				],
			]
		);

		$this->add_control(
			'product_tag_badge_bg',
			[
				'label'     => esc_html__('Tag Badge Background', 'shopengine-pro'),
				'type'      => Controls_Manager::COLOR,
				'alpha'     => false,
				'selectors' => [
					'{{WRAPPER}} .product-tag-sale-badge .tag a' => 'background: {{VALUE}}',
				],
				'condition' => [
					'show_tag' => 'yes',
				],
			]
		);

		$this->add_control(
			'stock_out_badge_bg',
			[
				'label'     => esc_html__('Stock Out Badge Background', 'shopengine-pro'),
				'type'      => Controls_Manager::COLOR,
				'alpha'     => false,
				'selectors' => [
					'{{WRAPPER}} .product-tag-sale-badge .out-of-stock' => 'background: {{VALUE}}',
				],
				'condition' => [
					'show_stock_out_badge' => 'yes',
				],
			]
		);

		$this->add_responsive_control(
			'product_badge_space_between',
			[
				'label'      => esc_html__('Space In-between Badge (px)', 'shopengine-pro'),
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
					'size' => 5,
				],
				'selectors'  => [
					'{{WRAPPER}} .product-tag-sale-badge ul'                => 'display:flex;gap: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .product-tag-sale-badge.align-vertical ul li:not(:last-child)' => 'gap: {{SIZE}}{{UNIT}} 0;',
				],
				'separator'  => 'before',
			]
		);

		$this->add_responsive_control(
			'product_badge_padding',
			[
				'label'      => esc_html__('Padding (px)', 'shopengine-pro'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px'],
				'default'    => [
					'top'      => '0',
					'right'    => '10',
					'bottom'   => '0',
					'left'     => '10',
					'unit'     => 'px',
					'isLinked' => false,
				],
				'selectors'  => [
					'{{WRAPPER}} .product-tag-sale-badge .tag a, {{WRAPPER}} .product-tag-sale-badge .no-link' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.rtl {{WRAPPER}} .product-tag-sale-badge .tag a, {{WRAPPER}} .product-tag-sale-badge .no-link' => 'padding: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				],
				'separator'  => 'before',
			]
		);

		$this->add_responsive_control(
			'product_badge_margin',
			[
				'label'      => esc_html__('Margin (px)', 'shopengine-pro'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px'],
				'selectors'  => [
					'{{WRAPPER}} .product-tag-sale-badge .tag a, {{WRAPPER}} .product-tag-sale-badge .no-link' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.rtl {{WRAPPER}} .product-tag-sale-badge .tag a, {{WRAPPER}} .product-tag-sale-badge .no-link' => 'margin: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				],
				'separator'  => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'      => 'badge_border',
				'label'     => esc_html__('Border', 'shopengine-pro'),
				'selector'  => '{{WRAPPER}} .product-tag-sale-badge .tag a, {{WRAPPER}} .product-tag-sale-badge .no-link ,{{WRAPPER}} .product-tag-sale-badge .no-link.out-of-stock',
				'fields_options' => [
					'width'  => [
						'selectors' => [
							'{{WRAPPER}} .product-tag-sale-badge .tag a, {{WRAPPER}} .product-tag-sale-badge .no-link ,{{WRAPPER}} .product-tag-sale-badge .no-link.out-of-stock'                    => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
							'.rtl {{WRAPPER}} .product-tag-sale-badge .tag a,.rtl {{WRAPPER}} .product-tag-sale-badge .no-link ,.rtl {{WRAPPER}} .product-tag-sale-badge .no-link.out-of-stock'               => 'border-width: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
						],	
					]
				],
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'badge_border_radius',
			[
				'label'      => esc_html__('Border Radius', 'shopengine-pro'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px'],
				'default'    => [
					'top'    => '3',
					'right'  => '3',
					'bottom' => '3',
					'left'   => '3',
				],
				'selectors'  => [
					'{{WRAPPER}} .product-tag-sale-badge .tag a, {{WRAPPER}} .product-tag-sale-badge .no-link' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.rtl {{WRAPPER}} .product-tag-sale-badge .tag a,.rtl {{WRAPPER}} .product-tag-sale-badge .no-link' => 'border-radius: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		// STYLE - PRODUCT CATEGORY
		$this->start_controls_section(
			'product_category_style_section',
			[
				'label'     => esc_html__('Product Category', 'shopengine-pro'),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_category' => 'yes',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'           => 'product_category_typography',
				'label'          => esc_html__('Typography', 'shopengine-pro'),
				'selector'       => '{{WRAPPER}} .product-category ul li a',
				'exclude'        => ['font_family', 'font_style', 'letter_spacing', 'text_decoration'],
				'fields_options' => [
					'typography'  => [
						'default' => 'custom',
					],
					'font_weight' => [
						'default' => '400',
					],
					'font_size'   => [
						'default'    => [
							'size' => '13',
							'unit' => 'px',
						],
						'label'      => esc_html__('Font Size (px)', 'shopengine-pro'),
						'size_units' => ['px'],
						'responsive' => false,
					],
					'line_height' => [
						'default'    => [
							'size' => '20',
							'unit' => 'px',
						],
						'size_units' => ['px'], // enable only px
						'responsive' => false,
					],
				],
				'separator'      => 'after',
			]
		);

		$this->start_controls_tabs(
			'product_category_tabs'
		);

		$this->start_controls_tab(
			'product_category_normal_tab',
			[
				'label' => esc_html__('Normal', 'shopengine-pro'),
			]
		);

		$this->add_control(
			'product_category_color',
			[
				'label'     => esc_html__('Color', 'shopengine-pro'),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#858585',
				'alpha'     => false,
				'selectors' => [
					'{{WRAPPER}} .product-category ul li a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'product_category_hover_tab',
			[
				'label' => esc_html__('Hover', 'shopengine-pro'),
			]
		);

		$this->add_control(
			'product_category_hover_color',
			[
				'label'     => esc_html__('Color', 'shopengine-pro'),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#F03D3F',
				'alpha'     => false,
				'selectors' => [
					'{{WRAPPER}} .product-category ul li a:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->add_responsive_control(
			'product_category_padding',
			[
				'label'      => esc_html__('Padding (px)', 'shopengine-pro'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px'],
				'default'    => [
					'top'      => '0',
					'right'    => '0',
					'bottom'   => '5',
					'left'     => '0',
					'unit'     => 'px',
					'isLinked' => false,
				],
				'selectors'  => [
					'{{WRAPPER}} .product-category' => 'line-height: 0; padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.rtl {{WRAPPER}} .product-category' => 'line-height: 0; padding: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				],
				'separator'  => 'before',
			]
		);

		$this->end_controls_section();

		// STYLE - PRODUCT TITLE
		$this->start_controls_section(
			'product_title_style_section',
			[
				'label' => esc_html__('Product Title', 'shopengine-pro'),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'           => 'product_title_typography',
				'label'          => esc_html__('Typography', 'shopengine-pro'),
				'selector'       => '{{WRAPPER}} .product-title',
				'exclude'        => ['font_family', 'font_style', 'letter_spacing', 'text_decoration'],
				'fields_options' => [
					'typography'  => [
						'default' => 'custom',
					],
					'font_weight' => [
						'default' => '400',
					],
					'font_size'   => [
						'default'    => [
							'size' => '15',
							'unit' => 'px',
						],
						'label'      => esc_html__('Font Size (px)', 'shopengine-pro'),
						'size_units' => ['px'],
						'responsive' => false,
					],
					'line_height' => [
						'default'    => [
							'size' => '18',
							'unit' => 'px',
						],
						'size_units' => ['px'], // enable only px
						'responsive' => false,
					],
				],
			]
		);

		$this->start_controls_tabs(
			'product_title_color_tabs'
		);

		$this->start_controls_tab(
			'product_title_color_normal_tab',
			[
				'label' => esc_html__('Normal', 'shopengine-pro'),
			]
		);

		$this->add_control(
			'product_title_color',
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

		$this->end_controls_tab();

		$this->start_controls_tab(
			'product_title_color_hover_tab',
			[
				'label' => esc_html__('Hover', 'shopengine-pro'),
			]
		);

		$this->add_control(
			'product_title_hover_color',
			[
				'label'     => esc_html__('Color', 'shopengine-pro'),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#F03D3F',
				'alpha'     => false,
				'selectors' => [
					'{{WRAPPER}} .product-title a:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->add_responsive_control(
			'product_title_padding',
			[
				'label'      => esc_html__('Padding (px)', 'shopengine-pro'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px'],
				'default'    => [
					'top'      => '0',
					'right'    => '0',
					'bottom'   => '8',
					'left'     => '0',
					'unit'     => 'px',
					'isLinked' => false,
				],
				'selectors'  => [
					'{{WRAPPER}} .product-title' => 'margin: 0; padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.rtl {{WRAPPER}} .product-title' => 'margin: 0; padding: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				],
				'separator'  => 'before',
			]
		);

		$this->end_controls_section();

		// STYLE - PRODUCT RATING
		$this->start_controls_section(
			'product_rating_style_section',
			[
				'label'     => esc_html__('Product Rating', 'shopengine-pro'),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_rating' => 'yes',
				],
			]
		);

		$this->add_control(
			'product_rating_star_size',
			[
				'label'      => esc_html__('Rating Star Size', 'shopengine-pro'),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range'      => [
					'px' => [
						'min'  => 0,
						'max'  => 100,
						'step' => 1,
					],
				],
				'default'    => [
					'unit' => 'px',
					'size' => 12,
				],
				'selectors'  => [
					'{{WRAPPER}} .product-rating .star-rating' => 'font-size: {{SIZE}}{{UNIT}};',
				],
				'separator'  => 'before',
			]
		);

		$this->add_control(
			'product_rating_star_color',
			[
				'label'     => esc_html__('Star Color', 'shopengine-pro'),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#fec42d',
				'alpha'     => false,
				'selectors' => [
					'{{WRAPPER}} .product-rating .star-rating span::before' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'product_rating_empty_star_color',
			[
				'label'     => esc_html__('Empty Star Color', 'shopengine-pro'),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#fec42d',
				'alpha'     => false,
				'selectors' => [
					'{{WRAPPER}} .product-rating .star-rating::before' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'product_rating_count_color',
			[
				'label'     => esc_html__('Count Color', 'shopengine-pro'),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#999999',
				'alpha'     => false,
				'selectors' => [
					'{{WRAPPER}} .rating-count' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'           => 'product_rating_count_typography',
				'label'          => esc_html__('Count Typography', 'shopengine-pro'),
				'selector'       => '{{WRAPPER}} .rating-count',
				'exclude'        => ['font_family', 'font_style', 'letter_spacing', 'text_decoration'],
				'fields_options' => [
					'typography'  => [
						'default' => 'custom',
					],
					'font_weight' => [
						'default' => '400',
					],
					'font_size'   => [
						'default'    => [
							'size' => '12',
							'unit' => 'px',
						],
						'label'      => esc_html__('Font Size (px)', 'shopengine-pro'),
						'size_units' => ['px'],
						'responsive' => false,
					],
					'line_height' => [
						'default'    => [
							'size' => '12',
							'unit' => 'px',
						],
						'size_units' => ['px'], // enable only px
						'responsive' => false,
					],
				],
			]
		);

		$this->add_responsive_control(
			'product_rating_padding',
			[
				'label'      => esc_html__('Padding (px)', 'shopengine-pro'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px'],
				'default'    => [
					'top'      => '0',
					'right'    => '0',
					'bottom'   => '20',
					'left'     => '0',
					'unit'     => 'px',
					'isLinked' => false,
				],
				'selectors'  => [
					'{{WRAPPER}} .product-rating' => 'line-height: 0; padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.rtl {{WRAPPER}} .product-rating' => 'line-height: 0; padding: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				],
				'separator'  => 'before',
			]
		);

		$this->end_controls_section();

		// STYLE - PRODUCT PRICE
		$this->start_controls_section(
			'product_price_style_section',
			[
				'label' => esc_html__('Product Price', 'shopengine-pro'),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'product_price_price_color',
			[
				'label'     => esc_html__('Color', 'shopengine-pro'),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#101010',
				'alpha'     => false,
				'selectors' => [
					'{{WRAPPER}} .product-price :is(.price, .amount, bdi)' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'product_price_sale_price_color',
			[
				'label'     => esc_html__('Sale Color', 'shopengine-pro'),
				'type'      => Controls_Manager::COLOR,
				'alpha'     => false,
				'default'   => '#999999',
				'selectors' => [
					'{{WRAPPER}} .product-price .price del' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'           => 'product_price_typography',
				'label'          => esc_html__('Typography', 'shopengine-pro'),
				'selector'       => '{{WRAPPER}} .product-price .price',
				'exclude'        => ['font_family', 'font_style', 'letter_spacing', 'text_decoration'],
				'fields_options' => [
					'typography'  => [
						'default' => 'custom',
					],
					'font_weight' => [
						'default' => '700',
					],
					'font_size'   => [
						'default'    => [
							'size' => '16',
							'unit' => 'px',
						],
						'label'      => esc_html__('Font Size (px)', 'shopengine-pro'),
						'size_units' => ['px'],
						'responsive' => false,
					],
					'line_height' => [
						'default'    => [
							'size' => '20',
							'unit' => 'px',
						],
						'label'      => esc_html__('Line Height (px)', 'shopengine-pro'),
						'size_units' => ['px'], // enable only px
						'responsive' => false,
					],
				],
			]
		);

		$this->add_control(
			'product_price_space_between',
			[
				'label'      => esc_html__('Space In-between Prices (px)', 'shopengine-pro'),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range'      => [
					'px' => [
						'min'  => 0,
						'max'  => 200,
						'step' => 1,
					],
				],
				'default'    => [
					'unit' => 'px',
					'size' => 5,
				],
				'selectors'  => [
					'{{WRAPPER}} .shopengine-product-carousel .product-price .price ins' => 'margin-right: {{SIZE}}{{UNIT}};',
					'.rtl {{WRAPPER}} .shopengine-product-carousel .product-price .price ins' => 'margin-left: {{SIZE}}{{UNIT}};',
				],

			]
		);

		$this->add_control(
			'product_price_discount_badge_style_section',
			[
				'label'     => esc_html__('Price Discount Badge', 'shopengine-pro'),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					'show_off_price_tag' => 'yes',
				],
			]
		);

		$this->add_control(
			'product_price_discount_badge_color',
			[
				'label'     => esc_html__('Color', 'shopengine-pro'),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#FFFFFF',
				'alpha'     => false,
				'selectors' => [
					'{{WRAPPER}} .shopengine-product-carousel .product-price .price .shopengine-discount-badge' => 'color: {{VALUE}};',
				],
				'condition' => [
					'show_off_price_tag' => 'yes',
				],
			]
		);

		$this->add_control(
			'product_price_discount_badge_bg_color',
			[
				'label'     => esc_html__('Background', 'shopengine-pro'),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#F54F29',
				'alpha'     => false,
				'selectors' => [
					'{{WRAPPER}} .shopengine-product-carousel .product-price .price .shopengine-discount-badge' => 'background: {{VALUE}};',
				],
				'condition' => [
					'show_off_price_tag' => 'yes',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'           => 'product_price_discount_badge_typography',
				'label'          => esc_html__('Typography', 'shopengine-pro'),
				'description'    => esc_html__('Typography for sale price and discount badge', 'shopengine-pro'),
				'selector'       => '{{WRAPPER}} .shopengine-product-carousel .product-price .price .shopengine-discount-badge',
				'exclude'        => ['font_family', 'font_style', 'letter_spacing', 'text_decoration'],
				'fields_options' => [
					'typography'  => [
						'default' => 'custom',
						'label'   => esc_html__('Typography Sale and Discount', 'shopengine-pro'),
					],
					'font_weight' => [
						'default' => '700',
					],
					'font_size'   => [
						'default'    => [
							'size' => '16',
							'unit' => 'px',
						],
						'label'      => esc_html__('Font Size (px)', 'shopengine-pro'),
						'size_units' => ['px'],
					],
					'line_height' => [
						'default'    => [
							'size' => '24',
							'unit' => 'px',
						],
						'label'      => esc_html__('Line Height (px)', 'shopengine-pro'),
						'size_units' => ['px'], // enable only px
						'responsive' => false,
					],
				],
			]
		);

		$this->add_responsive_control(
			'product_price_discount_badge_padding',
			[
				'label'      => esc_html__('Badge Padding', 'shopengine-pro'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px'],
				'default'    => [
					'top'      => '0',
					'right'    => '10',
					'bottom'   => '0',
					'left'     => '10',
					'unit'     => 'px',
					'isLinked' => false,
				],
				'selectors'  => [
					'{{WRAPPER}} .shopengine-product-carousel .product-price .price .shopengine-discount-badge' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.rtl {{WRAPPER}} .shopengine-product-carousel .product-price .price .shopengine-discount-badge' => 'padding: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				],
				'condition'  => [
					'show_off_price_tag' => 'yes',
				],
				'separator'  => 'before',
			]
		);

		$this->add_responsive_control(
			'product_price_discount_badge_margin',
			[
				'label'      => esc_html__('Badge Margin', 'shopengine-pro'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px'],
				'default'    => [
					'top'      => '0',
					'right'    => '0',
					'bottom'   => '0',
					'left'     => '5',
					'unit'     => 'px',
					'isLinked' => false,
				],
				'selectors'  => [
					'{{WRAPPER}} .shopengine-product-carousel .product-price .price .shopengine-discount-badge' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.rtl {{WRAPPER}} .shopengine-product-carousel .product-price .price .shopengine-discount-badge' => 'margin: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				],
				'condition'  => [
					'show_off_price_tag' => 'yes',
				],
				'separator'  => 'before',
			]
		);

		$this->add_responsive_control(
			'product_price_wrap_padding',
			[
				'label'      => esc_html__('Wrap Padding (px)', 'shopengine-pro'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px'],
				'default'    => [
					'top'      => '0',
					'right'    => '0',
					'bottom'   => '15',
					'left'     => '0',
					'unit'     => 'px',
					'isLinked' => false,
				],
				'selectors'  => [
					'{{WRAPPER}} .product-price' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.rtl {{WRAPPER}} .product-price' => 'padding: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				],
				'separator'  => 'before',
			]
		);

		$this->end_controls_section();

		// STYLE - PRODUCT HOVER
		$this->start_controls_section(
			'product_hover_overlay_style_section',
			[
				'label'     => esc_html__('Product Hover', 'shopengine-pro'),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_product_hover_overlay' => 'yes',
				],
			]
		);

		$this->start_controls_tabs(
			'product_hover_overlay_color_tabs'
		);

		$this->start_controls_tab(
			'product_hover_overlay_color_normal_tab',
			[
				'label' => esc_html__('Normal', 'shopengine-pro'),
			]
		);

		$this->add_control(
			'product_hover_overlay_color',
			[
				'label'     => esc_html__('Color', 'shopengine-pro'),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#101010',
				'alpha'     => false,
				'selectors' => [
					'{{WRAPPER}} .overlay-add-to-cart a::before' => 'color: {{VALUE}};',
					'{{WRAPPER}} .overlay-add-to-cart a::after'  => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'product_hover_overlay_bg_color',
			[
				'label'     => esc_html__('Background Color', 'shopengine-pro'),
				'type'      => Controls_Manager::COLOR,
				'alpha'     => false,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .overlay-add-to-cart a' => 'background: {{VALUE}} !important;',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'product_hover_overlay_color_hover_tab',
			[
				'label' => esc_html__('Hover', 'shopengine-pro'),
			]
		);

		$this->add_control(
			'product_hover_overlay_hover_color',
			[
				'label'     => esc_html__('Color', 'shopengine-pro'),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#F03D3F',
				'alpha'     => false,
				'selectors' => [
					'{{WRAPPER}} .overlay-add-to-cart a.active::before' => 'color: {{VALUE}};',
					'{{WRAPPER}} .overlay-add-to-cart a.added::before'  => 'color: {{VALUE}};',
					'{{WRAPPER}} .overlay-add-to-cart a.loading::after' => 'color: {{VALUE}};',
					'{{WRAPPER}} .overlay-add-to-cart a:hover::before'  => 'color: {{VALUE}};',
					'{{WRAPPER}} .overlay-add-to-cart a:hover::after'   => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'product_hover_overlay_hover_bg_color',
			[
				'label'     => esc_html__('Background Color', 'shopengine-pro'),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'alpha'     => false,
				'selectors' => [
					'{{WRAPPER}} .overlay-add-to-cart a.active' => 'background: {{VALUE}} !important;',
					'{{WRAPPER}} .overlay-add-to-cart a:hover'  => 'background: {{VALUE}} !important;',
					'{{WRAPPER}} .overlay-add-to-cart a:hover'  => 'background: {{VALUE}} !important;',
				],
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->add_responsive_control(
			'product_hover_overlay_font_size',
			[
				'label'      => esc_html__('Font Size (px)', 'shopengine-pro'),
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
					'size' => 18,
				],
				'selectors'  => [
					'{{WRAPPER}} .overlay-add-to-cart a::before' => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .overlay-add-to-cart a::after'  => 'font-size: {{SIZE}}{{UNIT}};',
				],
				'separator'  => 'before',
			]
		);

		$this->add_responsive_control(
			'product_hover_overlay_padding',
			[
				'label'      => esc_html__('Item Padding (px)', 'shopengine-pro'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px'],
				'default'    => [
					'top'      => '10',
					'right'    => '22',
					'bottom'   => '10',
					'left'     => '22',
					'unit'     => 'px',
					'isLinked' => false,
				],
				'selectors'  => [
					'{{WRAPPER}} .overlay-add-to-cart a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.rtl {{WRAPPER}} .overlay-add-to-cart a' => 'padding: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				],
				'separator'  => 'before',
			]
		);

		$this->add_responsive_control(
			'product_hover_overlay_item_space_between',
			[
				'label'      => esc_html__('Space In-between Items (px)', 'shopengine-pro'),
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
					'size' => 0,
				],
				'selectors'  => [
					'{{WRAPPER}} .overlay-add-to-cart.position-bottom a:not(:last-child)'                  => 'margin-right: {{SIZE}}{{UNIT}};',
					'.rtl {{WRAPPER}} .overlay-add-to-cart.position-bottom a:not(:last-child)'                  => 'margin-left: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .overlay-add-to-cart.position-left a:not(:last-child)'                    => 'margin-bottom: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .overlay-add-to-cart.position-right a:not(:last-child)'                   => 'margin-bottom: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .overlay-add-to-cart.position-center a:not(:nth-child(2n))'               => 'margin-right: {{SIZE}}{{UNIT}};',
					'.rtl {{WRAPPER}} .overlay-add-to-cart.position-center a:not(:nth-child(2n))'               => 'margin-left: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .overlay-add-to-cart.position-center a:not(:nth-child(1), :nth-child(2))' => 'margin-top: {{SIZE}}{{UNIT}};',
				],
				'separator'  => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'           => 'product_hover_overlay_border',
				'label'          => esc_html__('Border', 'shopengine-pro'),
				'fields_options' => [
					'border' => [
						'default'   => '',
						'selectors' => [
							'{{SELECTOR}} .overlay-add-to-cart'                    => 'border-style: {{VALUE}};',
							'{{SELECTOR}} .overlay-add-to-cart a:not(:last-child)' => 'border-style: {{VALUE}};',
						],
					],
					'width'  => [
						'label'     => esc_html__('Border Width', 'shopengine-pro'),
						'default'   => [
							'top'      => '0',
							'right'    => '0',
							'bottom'   => '0',
							'left'     => '0',
							'isLinked' => true,
						],
						'selectors' => [
							'{{SELECTOR}} .overlay-add-to-cart'                    => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
							'.rtl {{SELECTOR}} .overlay-add-to-cart'               => 'border-width: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
							'{{SELECTOR}} .overlay-add-to-cart a:not(:last-child)' => 'border-width: 0 {{RIGHT}}{{UNIT}} 0 0;',
							'{{SELECTOR}} .overlay-add-to-cart a:not(:last-child)' => 'border-width: 0 0 0 {{RIGHT}}{{UNIT}};',
						],
					],
					'color'  => [
						'label'     => esc_html__('Border Color', 'shopengine-pro'),
						'default'   => '#F2F2F2',
						'selectors' => [
							'{{SELECTOR}} .overlay-add-to-cart'                    => 'border-color: {{VALUE}};',
							'{{SELECTOR}} .overlay-add-to-cart a:not(:last-child)' => 'border-color: {{VALUE}};',
						],
					],
				],
				'separator'      => 'before',
			]
		);

		$this->add_responsive_control(
			'product_hover_overlay_border_radius',
			[
				'label'      => esc_html__('Border Radius (px)', 'shopengine-pro'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px'],
				'default'    => [
					'top'      => '5',
					'right'    => '5',
					'bottom'   => '0',
					'left'     => '0',
					'unit'     => 'px',
					'isLinked' => false,
				],
				'selectors'  => [
					'{{WRAPPER}} .overlay-add-to-cart' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.rtl {{WRAPPER}} .overlay-add-to-cart' => 'border-radius: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				],
				'separator'  => 'before',
			]
		);

		$this->add_responsive_control(
			'product_hover_overlay_margin',
			[
				'label'      => esc_html__('Wrap Margin (px)', 'shopengine-pro'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px'],
				'default'    => [
					'top'      => '0',
					'right'    => '0',
					'bottom'   => '0',
					'left'     => '0',
					'unit'     => 'px',
					'isLinked' => false,
				],
				'selectors'  => [
					'{{WRAPPER}} .overlay-add-to-cart' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.rtl {{WRAPPER}} .overlay-add-to-cart' => 'margin: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				],
				'separator'  => 'before',
			]
		);

		$this->end_controls_section();

		/** Arrow Style Section */  
		$this->start_controls_section(
			'carousel_section_navigation',
			[
				'label' => esc_html__( 'Arrows', 'shopengine-pro' ),
				'tab'   => Controls_Manager::TAB_STYLE,
				'condition' => [
					'carousel_arrow' => 'yes'
				]
			]
		);

		$this->add_responsive_control(
			'arrow_size',
			[
				'label' => esc_html__( 'Size', 'shopengine-pro' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 200,
						'step' => 1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .shopengine-product-carousel .elementor-swiper-button > i' => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .shopengine-product-carousel .elementor-swiper-button > svg' => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .shopengine-product-carousel .elementor-swiper-button > span' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'arrow_text_space',
			[
				'label' => esc_html__( 'Space Between', 'shopengine-pro' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px'],
				'default' => [
					'unit' => 'px',
					'size' => 5,
				],
				'selectors' => [
					'{{WRAPPER}} .shopengine-product-carousel .swiper-button-prev span' => 'margin-left: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .shopengine-product-carousel .swiper-button-next span' => 'margin-right: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'carousel_arrow' => 'yes',
					'arrow_type' => 'text_with_icon'
				]
			]
		);

		$this->add_control(
			'arrow_position_popover_toggle',
			[
				'label' => esc_html__( 'Arrow Position', 'shopengine-pro' ),
				'type' => Controls_Manager::POPOVER_TOGGLE,
				'label_off' => esc_html__( 'Default', 'shopengine-pro' ),
				'label_on' => esc_html__( 'Custom', 'shopengine-pro' ),
				'return_value' => 'yes',
				'default' => '',
			]
		);

		$this->start_popover();

		$this->add_control(
			'arrow_pos_head',
			[
				'label' => esc_html__( 'Left Arrow Position', 'shopengine-pro' ),
				'type' => Controls_Manager::HEADING
			]
		);

		$this->add_responsive_control(
			'arrow_left_pos_left',
			[
				'label' => esc_html__( 'Left Arrow Position (X)', 'shopengine-pro' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range' => [
					'px' => [
						'min' => -1000,
						'max' => 1000,
						'step' => 1,
					],
					'%' => [
						'min' => -100,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .shopengine-product-carousel .swiper-button-prev' => 'left: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'arrow_left_pos_top',
			[
				'label' => esc_html__( 'Left Arrow Position (Y)', 'shopengine-pro' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range' => [
					'px' => [
						'min' => -1000,
						'max' => 1000,
						'step' => 1,
					],
					'%' => [
						'min' => -100,
						'max' => 100,
					],
				],

				'selectors' => [
					'{{WRAPPER}} .shopengine-product-carousel .swiper-button-prev' => 'top: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'arrow_right_pos_head',
			[
				'label' => esc_html__( 'Right Arrow Position', 'shopengine-pro' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'arrow_right_pos_right',
			[
				'label' => esc_html__( 'Right Arrow Position (X)', 'shopengine-pro' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range' => [
					'px' => [
						'min' => -1000,
						'max' => 1000,
						'step' => 1,
					],
					'%' => [
						'min' => -100,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .shopengine-product-carousel .swiper-button-next' => 'right: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'arrow_right_pos_top',
			[
				'label' => esc_html__( 'Right Arrow Position (Y)', 'shopengine-pro' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range' => [
					'px' => [
						'min' => -1000,
						'max' => 1000,
						'step' => 1,
					],
					'%' => [
						'min' => -100,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .shopengine-product-carousel .swiper-button-next' => 'top: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_popover();

		// Arrow Normal
		$this->start_controls_tabs('arrow_style_tabs');

		$this->start_controls_tab(
			'arrow_normal_tab',
			[
				'label' => esc_html__( 'Normal', 'shopengine-pro' ),
			]
		);

		$this->add_control(
			'arrow_color',
			[
				'label' => esc_html__( 'ColorX', 'shopengine-pro' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#00000090',
				'selectors' => [
					'{{WRAPPER}} .shopengine-product-carousel .elementor-swiper-button > i' => 'color: {{VALUE}}',
					'{{WRAPPER}} .shopengine-product-carousel .elementor-swiper-button > svg' => 'fill: {{VALUE}}',
					'{{WRAPPER}} .shopengine-product-carousel .elementor-swiper-button > span' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'arrow_background',
			[
				'label' => esc_html__( 'Background ColorY', 'shopengine-pro' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .shopengine-product-carousel .elementor-swiper-button' => 'background: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'arrow_border_group',
				'label' => esc_html__( 'Border', 'shopengine-pro' ),
				'selector' => '{{WRAPPER}} .shopengine-product-carousel .elementor-swiper-button',
			]
		);

		$this->end_controls_tab();

		//  Arrow hover tab
		$this->start_controls_tab(
			'arrow_hover_tab',
			[
				'label' => esc_html__( 'Hover', 'shopengine-pro' ),
			]
		);

		$this->add_control(
			'arrow_hv_color',
			[
				'label' => esc_html__( 'Color', 'shopengine-pro' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .shopengine-product-carousel .elementor-swiper-button:hover > i' => 'color: {{VALUE}}',
					'{{WRAPPER}} .shopengine-product-carousel .elementor-swiper-button:hover > svg' => 'fill: {{VALUE}}',
					'{{WRAPPER}} .shopengine-product-carousel .elementor-swiper-button:hover > span' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'arrow_hover_background',
			[
				'label' => esc_html__( 'Background Color', 'shopengine-pro' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .shopengine-product-carousel .elementor-swiper-button:hover' => 'background: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'arrow_border_hover_group',
				'label' => esc_html__( 'Border', 'shopengine-pro' ),
				'selector' => '{{WRAPPER}} .shopengine-product-carousel .elementor-swiper-button:hover',
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_responsive_control(
			'arrow_border_radious',
			[
				'label' => esc_html__( 'Border Radius', 'shopengine-pro' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .shopengine-product-carousel .elementor-swiper-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'before'
			]
		);

		$this->add_responsive_control(
			'arrow_padding',
			[
				'label' => esc_html__( 'Padding', 'shopengine-pro' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .shopengine-product-carousel .elementor-swiper-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		/** Dot Style Section */ 
		$this->start_controls_section(
			'navigation_dot',
			[
				'label' => esc_html__( 'Dots', 'shopengine-pro' ),
				'tab'   => Controls_Manager::TAB_STYLE,
				'condition' => [
						'carousel_dot' => 'yes'
				]
			]
		);

		$this->add_control(
			'dots_left_right_spacing',
			[
				'label' => esc_html__( 'Space Between', 'shopengine-pro' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 20,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 4,
				],
				'selectors' => [
					'{{WRAPPER}} .shopengine-product-carousel .swiper-pagination .swiper-pagination-bullet' => 'margin-right: {{SIZE}}{{UNIT}};margin-left: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'dots_top_to_bottom',
			[
				'label' => esc_html__( 'Spacing Top To Bottom', 'shopengine-pro' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px'],
				'range' => [
					'px' => [
						'min' => -100,
						'max' => 200,
						'step' => 1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .shopengine-product-carousel .swiper-pagination' => 'transform: translateY({{SIZE}}{{UNIT}});',
				],
			]
		);

		$this->add_control(
			'dots_opacity',
			[
				'label' => esc_html__( 'Opacity', 'shopengine-pro' ),
				'type' =>  Controls_Manager::NUMBER,
				'min' => 0,
				'max' => 1,
				'step' => 0.1,
				'selectors' => [
					'{{WRAPPER}} .shopengine-product-carousel .swiper-pagination .swiper-pagination-bullet:not(.swiper-pagination-bullet-active)' => 'opacity: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'dot_width',
			[
				'label' => esc_html__( 'Width (px)', 'shopengine-pro' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'default' => [
					'unit' => 'px',
					'size' => 8,
				],
				'selectors' => [
					'{{WRAPPER}} .shopengine-product-carousel .swiper-pagination .swiper-pagination-bullet' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'dot_height',
			[
				'label' => esc_html__( 'Height (px)', 'shopengine-pro' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'default' => [
					'unit' => 'px',
					'size' => 8,
				],
				'selectors' => [
					'{{WRAPPER}} .shopengine-product-carousel .swiper-pagination .swiper-pagination-bullet' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'dot_border',
				'label' => esc_html__( 'Border', 'shopengine-pro' ),
				'selector' => '{{WRAPPER}} .shopengine-product-carousel .swiper-pagination .swiper-pagination-bullet',
			]
		);

		$this->add_control(
			'dot_border_radius',
			[
				'label' => esc_html__( 'Border radius', 'shopengine-pro' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .shopengine-product-carousel .swiper-pagination .swiper-pagination-bullet' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'dot_background',
				'label' => esc_html__( 'Background', 'shopengine-pro' ),
				'types' => [ 'classic', 'gradient' ],
				'exclude' => ['image'],
				'selector' => '{{WRAPPER}} .shopengine-product-carousel .swiper-pagination .swiper-pagination-bullet',
			]
		);

		$this->add_control(
			'dot_active_heading',
			[
				'label' => esc_html__( 'Active', 'shopengine-pro' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'dot_active_background',
				'label' => esc_html__( 'Background', 'shopengine-pro' ),
				'types' => [ 'classic', 'gradient' ],
				'exclude' => ['image'],
				'selector' => '{{WRAPPER}} .shopengine-product-carousel .swiper-pagination .swiper-pagination-bullet-active',
			]
		);

		$this->add_responsive_control(
			'dot_active_scale',
			[
				'label' => esc_html__( 'Scale', 'shopengine-pro' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 2,
						'step' => 0.1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 1.2,
				],
				'selectors' => [
					'{{WRAPPER}} .shopengine-product-carousel .swiper-pagination .swiper-pagination-bullet-active' => 'transform: scale({{SIZE}});',
				],
			]
		);

		$this->add_control(
			'dot_position',
			[
				'label' => esc_html__( 'Position Vertical', 'shopengine-pro' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'default' => [
					'unit' => 'px',
				],
				'selectors' => [
					'{{WRAPPER}} .shopengine-product-carousel .swiper-pagination .swiper-pagination-bullet-active' => 'transform: translateY({{SIZE}}{{UNIT}});',
				],
			]
		);

		$this->add_control(
			'dot_active_width',
			[
				'label' => esc_html__( 'Width (px)', 'shopengine-pro' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'selectors' => [
					'{{WRAPPER}} .shopengine-product-carousel .swiper-pagination .swiper-pagination-bullet-active' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'dot_active_height',
			[
				'label' => esc_html__( 'Height (px)', 'shopengine-pro' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'selectors' => [
					'{{WRAPPER}} .shopengine-product-carousel .swiper-pagination .swiper-pagination-bullet-active' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'dot_border_active',
				'label' => esc_html__( 'Border', 'shopengine-pro' ),
				'selector' => '{{WRAPPER}} .shopengine-product-carousel .swiper-pagination .swiper-pagination-bullet-active',
			]
		);

		$this->end_controls_section();

		/**
		 * Section: Global Font
		 */
		$this->start_controls_section(
			'shopengine_section_style_global',
			[
				'label' => esc_html__('Global Font', 'shopengine-pro'),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'shopengine_product_list_font_family',
			[
				'label'       => esc_html__('Font Family', 'shopengine-pro'),
				'description' => esc_html__('This font family is set for this specific widget.', 'shopengine-pro'),
				'type'        => Controls_Manager::FONT,
				'selectors'   => [
					'{{WRAPPER}} .product-tag-sale-badge .tag a, {{WRAPPER}} .product-tag-sale-badge .no-link,
                         {{WRAPPER}} .product-category ul li a,
                         {{WRAPPER}} .product-title,
                         {{WRAPPER}} .rating-count,
                         {{WRAPPER}} .product-price .price,
                         {{WRAPPER}} .shopengine-product-carousel .product-price .price .shopengine-discount-badge' => 'font-family: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function screen() {

		$settings = $this->get_settings_for_display();

		extract($settings);

		$tpl = Products::instance()->get_widget_template($this->get_name(), 'default', \ShopEngine_Pro::widget_dir());

		include $tpl;
	}
}