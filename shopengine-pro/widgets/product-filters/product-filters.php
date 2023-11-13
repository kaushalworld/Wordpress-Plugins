<?php

namespace Elementor;

defined('ABSPATH') || exit;

use ShopEngine\Controls;
use ShopEngine\Widgets\Products;
use ShopEngine\Core\Elementor_Controls\Controls_Manager as ShopEngine_Controls_Manager;

class ShopEngine_Product_Filters extends \ShopEngine\Base\Widget
{

	public function config()
	{
		return new ShopEngine_Product_Filters_Config();
	}

	public function get_script_depends()
	{
		return ['asrange-js'];
	}

	protected function register_controls()
	{
		/**
		 * Section: Price Filter
		 */
		$this->start_controls_section(
			'shopengine_section_filters_list',
			[
				'label' => esc_html__('Filters', 'shopengine-pro'),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);


		$this->add_control(
			'shopengine_filter_toggle_price',
			[
				'label'        => esc_html__('Price Filter', 'shopengine-pro'),
				'type'         => Controls_Manager::POPOVER_TOGGLE,
				'label_off'    => esc_html__('Disabled', 'shopengine-pro'),
				'label_on'     => esc_html__('Enabled', 'shopengine-pro'),
				'return_value' => 'yes',
				'default'      => 'yes',
				'separator'    => 'before',
			]
		);

		$this->start_popover();

		$this->add_control(
			'shopengine_filter_price_title',
			[
				'label'       => esc_html__('Title', 'shopengine-pro'),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__('Price Range', 'shopengine-pro'),
				'placeholder' => esc_html__('Type your title here', 'shopengine-pro'),
			]
		);

		$this->add_control(
			'shopengine_filter_price_min',
			[
				'label'       => esc_html__('Min Price', 'shopengine-pro'),
				'type'        => Controls_Manager::NUMBER,
				'placeholder' => '0',
				'default'     => 0,
			]
		);

		$this->add_control(
			'shopengine_filter_price_max',
			[
				'label'       => esc_html__('Max Price', 'shopengine-pro'),
				'type'        => Controls_Manager::NUMBER,
				'placeholder' => '9999',
				'default'     => 9999,
			]
		);

		$this->add_control(
			'shopengine_range_slider_dot_type',
			[
				'label'        => esc_html__('Dot Type', 'shopengine-pro'),
				'type'         => Controls_Manager::CHOOSE,
				'options'      => [
					'square' => [
						'title' => esc_html__('Square', 'shopengine-pro'),
						'icon'  => 'eicon-square',
					],
					'circle' => [
						'title' => esc_html__('Circle', 'shopengine-pro'),
						'icon'  => 'eicon-dot-circle-o',
					],
				],
				'default'      => 'square',
				'toggle'       => false,
				'prefix_class' => 'dot-type-',
			]
		);


		$this->end_popover();
		// END OF PRICE FILTER CONTROLS

		$this->add_control(
			'shopengine_filter_toggle_rating',
			[
				'label'        => esc_html__('Rating Filter', 'shopengine-pro'),
				'type'         => Controls_Manager::POPOVER_TOGGLE,
				'label_off'    => esc_html__('Disabled', 'shopengine-pro'),
				'label_on'     => esc_html__('Enabled', 'shopengine-pro'),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->start_popover();

		$this->add_control(
			'shopengine_filter_rating_expand_collapse',
			[
				'label' => esc_html__('Expand Collapse by default', 'shopengine-pro'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__('Show', 'shopengine-pro'),
				'label_off' => esc_html__('Hide', 'shopengine-pro'),
				'return_value' => 'yes',
				'default' => 'no',
				'condition' => [
					'shopengine_filter_view_mode' => 'collapse',
				],
			]
		);

		$this->add_control(
			'shopengine_filter_rating_title',
			[
				'label'       => esc_html__('Title', 'shopengine-pro'),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__('Product rating', 'shopengine-pro'),
				'placeholder' => esc_html__('Type your title here', 'shopengine-pro'),
			]
		);

		$this->add_control(
			'shopengine_filter_rating_styles',
			[
				'label' => esc_html__('Styles', 'shopengine-pro'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'multiple' => true,
				'options' => [
					'default'  => esc_html__('Default', 'shopengine-pro'),
					'style_2' => esc_html__('Circle', 'shopengine-pro'),
				],
				'default' => 'default',
			]
		);


		$this->end_popover();
		// END OF PRICE FILTER CONTROLS

		$this->add_control(
			'shopengine_filter_toggle_color',
			[
				'label'        => esc_html__('Color Filter', 'shopengine-pro'),
				'type'         => Controls_Manager::POPOVER_TOGGLE,
				'label_off'    => esc_html__('Disabled', 'shopengine-pro'),
				'label_on'     => esc_html__('Enabled', 'shopengine-pro'),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);
		$this->start_popover();

		$this->add_control(
			'shopengine_filter_color_title',
			[
				'label'       => esc_html__('Title', 'shopengine-pro'),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__('Product Colors', 'shopengine-pro'),
				'placeholder' => esc_html__('Type your title here', 'shopengine-pro'),
			]
		);

		$this->add_control(
			'shopengine_filter_color_styles',
			[
				'label' => esc_html__('Styles', 'shopengine-pro'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'multiple' => true,
				'options' => [
					'default'  => esc_html__('Default', 'shopengine-pro'),
					'style_2' => esc_html__('Circle', 'shopengine-pro'),
				],
				'default' => 'default',
			]
		);

		$this->add_control(
			'shopengine_filter_color_expand_collapse',
			[
				'label' => esc_html__('Expand Collapse by default', 'shopengine-pro'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__('Show', 'shopengine-pro'),
				'label_off' => esc_html__('Hide', 'shopengine-pro'),
				'return_value' => 'yes',
				'default' => 'no',
				'condition' => [
					'shopengine_filter_view_mode' => 'collapse',
				],
			]
		);

		$this->add_control(
			'shopengine_filter_color_dot_status',
			[
				'label'   => esc_html__('Show Color Dot', 'shopengine-pro'),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->end_popover();
		// END OF COLOR FILTER CONTROLS

		$this->add_control(
			'shopengine_filter_toggle_category',
			[
				'label'        => esc_html__('Category Filter', 'shopengine-pro'),
				'type'         => Controls_Manager::POPOVER_TOGGLE,
				'label_off'    => esc_html__('Disabled', 'shopengine-pro'),
				'label_on'     => esc_html__('Enabled', 'shopengine-pro'),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->start_popover();

		$this->add_control(
			'shopengine_filter_category_title',
			[
				'label'       => esc_html__('Title', 'shopengine-pro'),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__('Product Categories', 'shopengine-pro'),
				'placeholder' => esc_html__('Type your title here', 'shopengine-pro'),
			]
		);

		//Styles for filter
		$this->add_control(
			'shopengine_filter_category_styles',
			[
				'label' => esc_html__('Styles', 'shopengine-pro'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'multiple' => true,
				'options' => [
					'default'  => esc_html__('Default', 'shopengine-pro'),
					'style_2' => esc_html__('Circle', 'shopengine-pro'),
				],
				'default' => 'default',
			]
		);

		$this->add_control(
			'shopengine_filter_category_orderby',
			[
				'label'       => esc_html__('Order by', 'shopengine-pro'),
				'type'        => Controls_Manager::SELECT,
				'default'     => 'name',
				'options'     => [
					'order' => esc_html__('Category order', 'shopengine-pro'),
					'name'  => esc_html__('Name', 'shopengine-pro'),
				],
			]
		);

		$this->add_control(
			'shopengine_filter_category_expand_collapse',
			[
				'label' => esc_html__('Expand Collapse by default', 'shopengine-pro'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__('Show', 'shopengine-pro'),
				'label_off' => esc_html__('Hide', 'shopengine-pro'),
				'return_value' => 'yes',
				'default' => 'no',
				'condition' => [
					'shopengine_filter_view_mode' => 'collapse',
				],
			]
		);

		$this->add_control(
			'shopengine_filter_category_hierarchical',
			[
				'label'        => esc_html__('Show hierarchy', 'shopengine-pro'),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__('Yes', 'shopengine-pro'),
				'label_off'    => esc_html__('No', 'shopengine-pro'),
				'return_value' => 'yes',
				'default'      => 'yes',
				'condition' => [
					'shopengine_filter_category_styles' => 'default',
				],
			]
		);

		$this->add_control(
			'shopengine_filter_category_show_parent_only',
			[
				'label'        => esc_html__('Show parent only', 'shopengine-pro'),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__('Yes', 'shopengine-pro'),
				'label_off'    => esc_html__('No', 'shopengine-pro'),
				'return_value' => 'yes',
				'default'      => '',
				'condition'    => [
					'shopengine_filter_category_hierarchical!' => 'yes',
				],
			]
		);

		$this->add_control(
			'shopengine_filter_category_hide_empty',
			[
				'label'        => esc_html__('Hide empty categories', 'shopengine-pro'),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__('Yes', 'shopengine-pro'),
				'label_off'    => esc_html__('No', 'shopengine-pro'),
				'return_value' => 'yes',
				'default'      => '',
			]
		);

		$this->add_control(
			'shopengine_filter_except_category',
			[
				'label' => esc_html__('Except category', 'shopengine-pro'),
				'label_block' 	=> true,
				'type'			=> ShopEngine_Controls_Manager::AJAXSELECT2,
				'options'		=> 'ajaxselect2/product_cat',
				'multiple'		=> true,
				'default'		=> [],
			]
		);

		$this->end_popover();
		// END OF CATEGORY FILTER CONTROLS

		$this->add_control(
			'shopengine_enable_image',
			[
				'label'        => esc_html__('Image Filter', 'shopengine-pro'),
				'type'         => Controls_Manager::POPOVER_TOGGLE,
				'label_off'    => esc_html__('Disabled', 'shopengine-pro'),
				'label_on'     => esc_html__('Enabled', 'shopengine-pro'),
				'return_value' => 'yes',
				'default'      => 'no',
			]
		);
		$this->start_popover();

		$this->add_control(
			'shopengine_filter_image_title',
			[
				'label'       => esc_html__('Title', 'shopengine-pro'),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__('Product Images', 'shopengine-pro'),
				'placeholder' => esc_html__('Type your title here', 'shopengine-pro'),
			]
		);

		$this->add_control(
			'shopengine_filter_image_styles',
			[
				'label' => esc_html__('Styles', 'shopengine-pro'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'multiple' => true,
				'options' => [
					'default'  => esc_html__('Default', 'shopengine-pro'),
					'style_2' => esc_html__('Circle', 'shopengine-pro'),
				],
				'default' => 'default',
			]
		);

		$this->add_control(
			'shopengine_filter_image_expand_collapse',
			[
				'label' => esc_html__('Expand Collapse by default', 'shopengine-pro'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__('Show', 'shopengine-pro'),
				'label_off' => esc_html__('Hide', 'shopengine-pro'),
				'return_value' => 'yes',
				'default' => 'no',
				'condition' => [
					'shopengine_filter_view_mode' => 'collapse',
				],
			]
		);


		$this->end_popover();
		// END OF IMAGE FILTER CONTROLS

		$this->add_control(
			'shopengine_enable_label',
			[
				'label'        => esc_html__('Label Filter', 'shopengine-pro'),
				'type'         => Controls_Manager::POPOVER_TOGGLE,
				'label_off'    => esc_html__('Disabled', 'shopengine-pro'),
				'label_on'     => esc_html__('Enabled', 'shopengine-pro'),
				'return_value' => 'yes',
				'default'      => 'no',
			]
		);
		$this->start_popover();

		$this->add_control(
			'shopengine_filter_label_title',
			[
				'label'       => esc_html__('Title', 'shopengine-pro'),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__('Product Label', 'shopengine-pro'),
				'placeholder' => esc_html__('Type your title here', 'shopengine-pro'),
			]
		);

		//Styles for filter
		$this->add_control(
			'shopengine_filter_label_styles',
			[
				'label' => esc_html__('Styles', 'shopengine-pro'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'multiple' => true,
				'options' => [
					'default'  => esc_html__('Default', 'shopengine-pro'),
					'style_2' => esc_html__('Circle', 'shopengine-pro'),
				],
				'default' => 'default',
			]
		);

		$this->add_control(
			'shopengine_filter_label_expand_collapse',
			[
				'label' => esc_html__('Expand Collapse by default', 'shopengine-pro'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__('Show', 'shopengine-pro'),
				'label_off' => esc_html__('Hide', 'shopengine-pro'),
				'return_value' => 'yes',
				'default' => 'no',
				'condition' => [
					'shopengine_filter_view_mode' => 'collapse',
				],
			]
		);

		$this->end_popover();

		$this->add_control(
			'shopengine_enable_shipping',
			[
				'label'        => esc_html__('Shipping Filter', 'shopengine-pro'),
				'type'         => Controls_Manager::POPOVER_TOGGLE,
				'label_off'    => esc_html__('Disabled', 'shopengine-pro'),
				'label_on'     => esc_html__('Enabled', 'shopengine-pro'),
				'return_value' => 'yes',
				'default'      => 'no',
			]
		);
		$this->start_popover();

		$this->add_control(
			'shopengine_filter_shipping_title',
			[
				'label'       => esc_html__('Title', 'shopengine-pro'),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__('Shipping', 'shopengine-pro'),
				'placeholder' => esc_html__('Type your title here', 'shopengine-pro'),
			]
		);

		//Styles for filter
		$this->add_control(
			'shopengine_filter_shipping_styles',
			[
				'label' => esc_html__('Styles', 'shopengine-pro'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'multiple' => true,
				'options' => [
					'default'  => esc_html__('Default', 'shopengine-pro'),
					'style_2' => esc_html__('Circle', 'shopengine-pro'),
				],
				'default' => 'default',
			]
		);

		$this->add_control(
			'shopengine_filter_shipping_expand_collapse',
			[
				'label' => esc_html__('Expand Collapse by default', 'shopengine-pro'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__('Show', 'shopengine-pro'),
				'label_off' => esc_html__('Hide', 'shopengine-pro'),
				'return_value' => 'yes',
				'default' => 'no',
				'condition' => [
					'shopengine_filter_view_mode' => 'collapse',
				],
			]
		);

		$this->end_popover();

		$this->add_control(
			'shopengine_enable_stock',
			[
				'label'        => esc_html__('Stock Filter', 'shopengine-pro'),
				'type'         => Controls_Manager::POPOVER_TOGGLE,
				'label_off'    => esc_html__('Disabled', 'shopengine-pro'),
				'label_on'     => esc_html__('Enabled', 'shopengine-pro'),
				'return_value' => 'yes',
				'default'      => 'no',
			]
		);
		$this->start_popover();

		$this->add_control(
			'shopengine_filter_stock_title',
			[
				'label'       => esc_html__('Title', 'shopengine-pro'),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__('Stock', 'shopengine-pro'),
				'placeholder' => esc_html__('Type your title here', 'shopengine-pro'),
			]
		);

		//Styles for filter
		$this->add_control(
			'shopengine_filter_stock_styles',
			[
				'label' => esc_html__('Styles', 'shopengine-pro'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'multiple' => true,
				'options' => [
					'default'  => esc_html__('Default', 'shopengine-pro'),
					'style_2' => esc_html__('Circle', 'shopengine-pro'),
				],
				'default' => 'default',
			]
		);

		$this->add_control(
			'shopengine_filter_stock_expand_collapse',
			[
				'label' => esc_html__('Expand Collapse by default', 'shopengine-pro'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__('Show', 'shopengine-pro'),
				'label_off' => esc_html__('Hide', 'shopengine-pro'),
				'return_value' => 'yes',
				'default' => 'no',
				'condition' => [
					'shopengine_filter_view_mode' => 'collapse',
				],
			]
		);

		$this->end_popover();

		$this->add_control(
			'shopengine_enable_onsale',
			[
				'label'        => esc_html__('On Sale Filter', 'shopengine-pro'),
				'type'         => Controls_Manager::POPOVER_TOGGLE,
				'label_off'    => esc_html__('Disabled', 'shopengine-pro'),
				'label_on'     => esc_html__('Enabled', 'shopengine-pro'),
				'return_value' => 'yes',
				'default'      => 'no',
			]
		);
		$this->start_popover();

		$this->add_control(
			'shopengine_filter_onsale_title',
			[
				'label'       => esc_html__('Title', 'shopengine-pro'),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__('On Sale', 'shopengine-pro'),
				'placeholder' => esc_html__('Type your title here', 'shopengine-pro'),
			]
		);

		//Styles for filter
		$this->add_control(
			'shopengine_filter_onsale_styles',
			[
				'label' => esc_html__('Styles', 'shopengine-pro'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'multiple' => true,
				'options' => [
					'default'  => esc_html__('Default', 'shopengine-pro'),
					'style_2' => esc_html__('Circle', 'shopengine-pro'),
				],
				'default' => 'default',
			]
		);

		$this->add_control(
			'shopengine_filter_onsale_expand_collapse',
			[
				'label' => esc_html__('Expand Collapse by default', 'shopengine-pro'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__('Show', 'shopengine-pro'),
				'label_off' => esc_html__('Hide', 'shopengine-pro'),
				'return_value' => 'yes',
				'default' => 'no',
				'condition' => [
					'shopengine_filter_view_mode' => 'collapse',
				],
			]
		);

		$this->end_popover();

		// END OF LABEL FILTER CONTROLS

		$this->end_controls_section();

		/**
		 * Layout Settings
		 */
		$this->start_controls_section(
			'shopengine_section_filter_layout_settings',
			[
				'label' => esc_html__('Layout', 'shopengine-pro'),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		// filter view mode
		$this->add_control(
			'shopengine_filter_view_mode',
			[
				'label'       => esc_html__('Filter View Mode', 'shopengine-pro'),
				'type'        => Controls_Manager::SELECT,
				'default'     => 'card',
				'options'     => [
					'card' => esc_html__('Card', 'shopengine-pro'),
					'collapse'  => esc_html__('Collapse', 'shopengine-pro'),
				],
			]
		);

		// Toggle Button
		$this->add_control(
			'shopengine_filter_toggle_button',
			[
				'label'        => esc_html__('Enable Container Toggle Button?', 'shopengine-pro'),
				'type'         => Controls_Manager::POPOVER_TOGGLE,
				'label_off'    => esc_html__('Disabled', 'shopengine-pro'),
				'label_on'     => esc_html__('Enabled', 'shopengine-pro'),
				'return_value' => 'yes',
				'default'      => '',
			]
		);

		$this->start_popover();

		$this->add_control(
			'shopengine_filter_toggle_button_toggler',
			[
				'label'       => esc_html__('Toggle Button Text', 'shopengine-pro'),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__('Button Text', 'shopengine-pro'),
				'default'     => esc_html__('Filter', 'shopengine-pro'),
			]
		);

		$this->add_responsive_control(
			'shopengine_filter_toggle_button_toggler_alignment',
			[
				'label'       => esc_html__('Alignment', 'shopengine-pro'),
				'type'        => Controls_Manager::CHOOSE,
				'options'     => [
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
				'description' => esc_html__('Note: Dropdown content with align according to button alignment.', 'shopengine-pro'),
				'default'     => 'left',
				'prefix_class' => 'shopengine-filter--align-',
				'selectors'   => [
					'{{WRAPPER}} .shopengine-product-filters .shopengine-filter-group .shopengine-filter-group-toggle-wrapper'  => 'text-align: {{VALUE}};',
					'.rtl {{WRAPPER}}.shopengine-filter--align-left .shopengine-product-filters .shopengine-filter-group .shopengine-filter-group-toggle-wrapper'  => 'text-align: right;',
					'.rtl {{WRAPPER}}.shopengine-filter--align-right .shopengine-product-filters .shopengine-filter-group .shopengine-filter-group-toggle-wrapper'  => 'text-align: left;',
					'{{WRAPPER}} .shopengine-product-filters .shopengine-filter-group .shopengine-filter-group-content-wrapper' => '{{VALUE}}: 0;',
				],
			]
		);



		$this->add_control(
			'shopengine_filter_toggler_icon_status',
			[
				'label'        => esc_html__('Show Icon', 'shopengine-pro'),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__('Show', 'shopengine-pro'),
				'label_off'    => esc_html__('Hide', 'shopengine-pro'),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'shopengine_filter_toggler_icon',
			[
				'label'     => esc_html__('Icon', 'shopengine-pro'),
				'type'      => Controls_Manager::ICONS,
				'default'   => [
					'value'   => 'fas fa-filter',
					'library' => 'fa-solid',
				],
				'condition' => [
					'shopengine_filter_toggler_icon_status' => 'yes',
				],
			]
		);

		$this->add_control(
			'shopengine_filter_toggler_icon_position',
			[
				'label'     => esc_html__('Icon Position', 'shopengine-pro'),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'left',
				'options'   => [
					'left'  => esc_html__('Left', 'shopengine-pro'),
					'right' => esc_html__('Right', 'shopengine-pro'),
				],
				'condition' => [
					'shopengine_filter_toggler_icon_status' => 'yes',
				],
			]
		);

		// Off-Canvas Option.
		$this->add_control(
			'shopengine_filter_offcanvas',
			[
				'label'			=> esc_html__('Off-Canvas', 'shopengine-pro'),
				'description'	=> esc_html__("Adjust the 'Container Width' to 300px.", 'shopengine-pro'),
				'type'			=> Controls_Manager::SWITCHER,
				'prefix_class'	=> 'shopengine-filter--offcanvas-',
			]
		);

		$this->add_control(
			'shopengine_filter_offcanvas_overlay',
			[
				'label'			=> esc_html__('Off-Canvas Overlay', 'shopengine-pro'),
				'type'			=> Controls_Manager::SWITCHER,
				'default'		=> '',
				"return_value"	=> 'yes',
				'condition'		=> [
					'shopengine_filter_offcanvas' => 'yes',
				],
			]
		);

		$this->add_control(
			'shopengine_filter_offcanvas_overlay_color',
			[
				'label' => esc_html__('Overlay Color', 'shopengine-pro'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .shopengine-widget .shopengine-filter-overlay' => 'background-color: {{VALUE}}',
				],
				'condition'		=> [
					'shopengine_filter_offcanvas' => 'yes',
				],
			]
		);

		$this->add_responsive_control(
			'shopengine_section_filter_content_width',
			[
				'label'      => esc_html__('Container Width', 'shopengine-pro'),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => ['px', '%'],
				'range'      => [
					'px' => [
						'min'  => 0,
						'max'  => 1600,
						'step' => 1,
					],
					'%'  => [
						'min'  => 0,
						'max'  => 100,
						'step' => 1,
					],
				],
				'default'    => [
					'unit' => 'px',
					'size' => 1140,
				],
				'separator'  => 'before',
				'selectors'  => [
					'{{WRAPPER}} .shopengine-product-filters .shopengine-filter-group-content-wrapper' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		// Toggler Responsive Breakpoint.
		$this->add_control(
			'shopengine_filter_toggler_breakpoint',
			[
				'label'     => esc_html__('Breakpoint', 'shopengine-pro'),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'none',
				'options'   => [
					'none'  	=> esc_html__('None', 'shopengine-pro'),
					'tablet'	=> esc_html__('Tablet (> 1025px)', 'shopengine-pro'),
					'mobile'	=> esc_html__('Mobile (> 768px)', 'shopengine-pro'),
				],
				'prefix_class' => 'shopengine-filter-break--',
				'condition' => [
					'shopengine_filter_offcanvas!' => 'yes',
				],
			]
		);

		$this->end_popover();
		// End Toggle Button Popover

		$this->add_responsive_control(
			'shopengine_section_filter_layout_col_number',
			[
				'label'     => esc_html('Columns (per row)', 'shopengine-pro'),
				'type'      => Controls_Manager::SLIDER,
				'units'     => 'px',
				'range'     => [
					'px' => [
						'min'  => 1,
						'max'  => 6,
						'step' => 1,
					],
				],
				'default'   => [
					'size' => 1,
				],
				'selectors' => [
					'{{WRAPPER}} .shopengine-product-filters .shopengine-product-filters-wrapper' => 'grid-template-columns: repeat({{SIZE}}, 1fr) ;',
				],
			]
		);

		$this->add_responsive_control(
			'shopengine_section_filter_layout_col_padding',
			[
				'label'     => esc_html('Filter Item Gap', 'shopengine-pro'),
				'type'      => Controls_Manager::SLIDER,
				'units'     => 'px',
				'range'     => [
					'px' => [
						'min'  => 1,
						'max'  => 200,
						'step' => 1,
					],
				],
				'default'   => [
					'size' => 15,
				],
				'selectors' => [
					'{{WRAPPER}} .shopengine-product-filters .shopengine-product-filters-wrapper' => 'gap:{{SIZE}}{{UNIT}};',
				],
			]
		);


		$this->end_controls_section();

		/**
		 * Styles: Common
		 */
		$this->start_controls_section(
			'shopengine_section_filter_common_style',
			[
				'label' => esc_html__('Common Styles', 'shopengine-pro'),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		/**
		 * Style: Typography
		 */
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'label'          => esc_html__('Title Typography', 'shopengine-pro'),
				'name'           => 'shopengine_section_filters_typography_title',
				'selector'       => '{{WRAPPER}} .shopengine-product-filters h3.shopengine-product-filter-title',
				'exclude'        => ['font_family', 'text_decoration'],
				'fields_options' => [
					'typography'  => [
						'default' => 'custom',
					],
					'font_weight'    => [
						'default' => '700',
					],
					'font_size'     => [
						'label'      => esc_html__('Font Size (px)', 'shopengine-pro'),
						'default'    => [
							'size' => '18',
							'unit' => 'px',
						],
						'size_units' => ['px'],
						'responsive' => true, // responsive support for bajaar theme
					],
					'line_height'    => [
						'label'      => esc_html__('Line-Height (px)', 'shopengine-pro'),
						'default'    => [
							'size' => '22',
							'unit' => 'px',
						],
						'size_units' => ['px'],
						'responsive' => true, // responsive support for bajaar theme
					],
					'text_transform' => [
						'default' => 'uppercase',
					],
					'letter_spacing'  => [
						'responsive' => false,
					],
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'           => 'shopengine_product_filters_typography_primary',
				'label'          => esc_html__('Body Typography', 'shopengine-pro'),
				'selector'       => '{{WRAPPER}} .shopengine-product-filters .shopengine-filter-price-reset,
                    {{WRAPPER}} .shopengine-product-filters .shopengine-filter-price-result,
                    {{WRAPPER}} .shopengine-product-filters .filter-input-group label',
				'exclude'        => ['font_family'],
				'fields_options' => [
					'font_size'   => [
						'label'      => esc_html__('Font Size (px)', 'shopengine-pro'),
						'size_units' => ['px'],
						'responsive' => true, // responsive support for bajaar theme
					],
					'line_height' => [
						'label'      => esc_html__('Line-Height (px)', 'shopengine-pro'),
						'size_units' => ['px'],
						'responsive' => true, // responsive support for bajaar theme
					],
					'letter_spacing'  => [
						'responsive' => false,
					],
				],
			]
		);

		$this->add_control(
			'shopengine_filter_heading_color',
			[
				'label'     => esc_html__('Heading Color', 'shopengine-pro'),
				'type'      => Controls_Manager::COLOR,
				'alpha'		=> false,
				'default'   => '#505255',
				'selectors' => [
					'{{WRAPPER}} .shopengine-product-filters h3.shopengine-product-filter-title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'shopengine_filter_title_color',
			[
				'label'     => esc_html__('Filter Label Color', 'shopengine-pro'),
				'type'      => Controls_Manager::COLOR,
				'alpha'		=> false,
				'default'   => '#505255',
				'selectors' => [
					'{{WRAPPER}} .shopengine-product-filters :is(.shopengine-filter-category-label, .shopengine-filter-color-label, .shopengine-filter-attribute-label,.shopengine-filter-stock-label,.shopengine-filter-onsale-label,.shopengine-filter-label-label,.shopengine-filter-shipping-label,.shopengine-filter-color-label)' => 'color: {{VALUE}};',

				],
			]
		);

		$this->add_control(
			'shopengine_filter_title_color_hover',
			[
				'label'     => esc_html__('Filter Label Hover Color', 'shopengine-pro'),
				'type'      => Controls_Manager::COLOR,
				'alpha'		=> false,
				'default'   => '#075FCB',
				'selectors' => [
					'{{WRAPPER}} .shopengine-product-filters :is(.shopengine-filter-category-label, .shopengine-filter-color-label, .shopengine-filter-attribute-label,.shopengine-filter-stock-label,.shopengine-filter-onsale-label, .shopengine-collapse .shopengine-product-filter-title,.shopengine-filter-label-label,.shopengine-filter-shipping-label,.shopengine-filter-color-label):hover' => 'color: {{VALUE}};',
				],
			]
		);


		$this->add_control(
			'shopengine_filter_price_font',
			[
				'label'     => esc_html__('Global Font Family', 'shopengine-pro'),
				'type'      => Controls_Manager::FONT,
				'selectors' => [
					'{{WRAPPER}} .shopengine-product-filters .shopengine-filter-price-reset,
					{{WRAPPER}} .shopengine-product-filters .shopengine-filter-price-result,
					{{WRAPPER}} .shopengine-product-filters .filter-input-group label,
					{{WRAPPER}} .shopengine-product-filters .shopengine-filter-group .shopengine-filter-group-toggle,
					{{WRAPPER}} .shopengine-product-filters h3.shopengine-product-filter-title' => 'font-family: {{VALUE}}',
				],
			]
		);


		$this->add_control(
			'shopengine_filter_title_spacing',
			[
				'label'      => esc_html__('Title padding Bottom', 'shopengine-pro'),
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
					'size' => 9,
				],
				'selectors'  => [
					'{{WRAPPER}} .shopengine-product-filters .shopengine-filter-single:not(.shopengine-collapse) h3.shopengine-product-filter-title' => 'padding-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);



		$this->add_control(
			'shopengine_filter_color_line_spacing',
			[
				'label'      => esc_html__('Item gap', 'shopengine-pro'),
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
					'size' => 9,
				],
				'selectors'  => [
					'{{WRAPPER}} .shopengine-product-filters  .filter-input-group, 
					 {{WRAPPER}} .shopengine-product-filters .shopengine-filter-rating__labels button:not(:last-child)' => 'margin: {{SIZE}}{{UNIT}} 0;',
				],
			]
		);


		$this->add_control(
			'shopengine_filter_checkbox_style',
			[
				'label'     => esc_html__('Checkbox Style', 'shopengine-pro'),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
				'conditions' => [
					'relation' => 'or',
					'terms' => [
						['name' => 'shopengine_filter_color_styles', 'operator' => '===', 'value' => 'default'],
						['name' => 'shopengine_filter_image_styles', 'operator' => '===', 'value' => 'default'],
						['name' => 'shopengine_filter_rating_styles', 'operator' => '===', 'value' => 'default'],
						['name' => 'shopengine_filter_category_styles', 'operator' => '===', 'value' => 'default'],
						['name' => 'shopengine_filter_label_styles', 'operator' => '===', 'value' => 'default'],
						['name' => 'shopengine_filter_attribute_styles', 'operator' => '===', 'value' => 'default'],
						['name' => 'shopengine_filter_shipping_styles', 'operator' => '===', 'value' => 'default'],
						['name' => 'shopengine_filter_stock_styles', 'operator' => '===', 'value' => 'default'],
						['name' => 'shopengine_filter_onsale_styles', 'operator' => '===', 'value' => 'default'],
					],
				],

			]
		);

		$this->add_control(
			'shopengine_check_icon',
			[
				'label'   => esc_html__('Checkbox Icon', 'shopengine-pro'),
				'type'    => Controls_Manager::ICONS,
				'default' => [
					'value'   => 'fas fa-check',
					'library' => 'fa-solid',
				],
				'conditions' => [
					'relation' => 'or',
					'terms' => [
						['name' => 'shopengine_filter_color_styles', 'operator' => '===', 'value' => 'default'],
						['name' => 'shopengine_filter_image_styles', 'operator' => '===', 'value' => 'default'],
						['name' => 'shopengine_filter_rating_styles', 'operator' => '===', 'value' => 'default'],
						['name' => 'shopengine_filter_category_styles', 'operator' => '===', 'value' => 'default'],
						['name' => 'shopengine_filter_label_styles', 'operator' => '===', 'value' => 'default'],
						['name' => 'shopengine_filter_attribute_styles', 'operator' => '===', 'value' => 'default'],
						['name' => 'shopengine_filter_shipping_styles', 'operator' => '===', 'value' => 'default'],
						['name' => 'shopengine_filter_stock_styles', 'operator' => '===', 'value' => 'default'],
						['name' => 'shopengine_filter_onsale_styles', 'operator' => '===', 'value' => 'default'],
					],
				],

			]
		);


		$this->add_control(
			'shopengine_checkbox_icon_size',
			[
				'label'      => esc_html__('Checkbox Icon Size', 'shopengine-pro'),
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
					'{{WRAPPER}} .shopengine-product-filters .shopengine-filter-rating__labels--mark :is(span, i, svg, img)' => 'font-size: {{SIZE}}{{UNIT}}; width: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .shopengine-product-filters .shopengine-checkbox-icon :is(span, i, svg, img)' => 'font-size: {{SIZE}}{{UNIT}}; width: {{SIZE}}{{UNIT}};',
				],
				'conditions' => [
					'relation' => 'or',
					'terms' => [
						['name' => 'shopengine_filter_color_styles', 'operator' => '===', 'value' => 'default'],
						['name' => 'shopengine_filter_image_styles', 'operator' => '===', 'value' => 'default'],
						['name' => 'shopengine_filter_rating_styles', 'operator' => '===', 'value' => 'default'],
						['name' => 'shopengine_filter_category_styles', 'operator' => '===', 'value' => 'default'],
						['name' => 'shopengine_filter_label_styles', 'operator' => '===', 'value' => 'default'],
						['name' => 'shopengine_filter_attribute_styles', 'operator' => '===', 'value' => 'default'],
						['name' => 'shopengine_filter_shipping_styles', 'operator' => '===', 'value' => 'default'],
						['name' => 'shopengine_filter_stock_styles', 'operator' => '===', 'value' => 'default'],
						['name' => 'shopengine_filter_onsale_styles', 'operator' => '===', 'value' => 'default'],
					],
				],
			]
		);


		$this->add_control(
			'shopengine_checkbox_tabs_normal_clr',
			[
				'label'     => esc_html__('Checkbox Border Color', 'shopengine-pro'),
				'type'      => Controls_Manager::COLOR,
				'alpha'     => false,
				'default'   => '#eeeeee',
				'selectors' => [
					'{{WRAPPER}} .shopengine-product-filters .shopengine-filter-rating__labels--mark' => 'border-color: {{VALUE}} !important;',
					'{{WRAPPER}} .shopengine-product-filters .shopengine-checkbox-icon'               => 'border-color: {{VALUE}} !important;',
				],
				'conditions' => [
					'relation' => 'or',
					'terms' => [
						['name' => 'shopengine_filter_color_styles', 'operator' => '===', 'value' => 'default'],
						['name' => 'shopengine_filter_image_styles', 'operator' => '===', 'value' => 'default'],
						['name' => 'shopengine_filter_rating_styles', 'operator' => '===', 'value' => 'default'],
						['name' => 'shopengine_filter_category_styles', 'operator' => '===', 'value' => 'default'],
						['name' => 'shopengine_filter_label_styles', 'operator' => '===', 'value' => 'default'],
						['name' => 'shopengine_filter_attribute_styles', 'operator' => '===', 'value' => 'default'],
						['name' => 'shopengine_filter_shipping_styles', 'operator' => '===', 'value' => 'default'],
						['name' => 'shopengine_filter_stock_styles', 'operator' => '===', 'value' => 'default'],
						['name' => 'shopengine_filter_onsale_styles', 'operator' => '===', 'value' => 'default'],
					],
				],
			]
		);


		$this->add_control(
			'shopengine_checkbox_tabs_checked_clr',
			[
				'label'     => esc_html__('Checked Icon Color', 'shopengine-pro'),
				'type'      => Controls_Manager::COLOR,
				'alpha'     => false,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .shopengine-product-filters .rating-label-triger.checked .shopengine-filter-rating__labels--mark' => 'color: {{VALUE}}',
					'{{WRAPPER}} .shopengine-product-filters input:checked + label .shopengine-checkbox-icon' => 'color: {{VALUE}}',
				],
				'conditions' => [
					'relation' => 'or',
					'terms' => [
						['name' => 'shopengine_filter_color_styles', 'operator' => '===', 'value' => 'default'],
						['name' => 'shopengine_filter_image_styles', 'operator' => '===', 'value' => 'default'],
						['name' => 'shopengine_filter_rating_styles', 'operator' => '===', 'value' => 'default'],
						['name' => 'shopengine_filter_category_styles', 'operator' => '===', 'value' => 'default'],
						['name' => 'shopengine_filter_label_styles', 'operator' => '===', 'value' => 'default'],
						['name' => 'shopengine_filter_attribute_styles', 'operator' => '===', 'value' => 'default'],
						['name' => 'shopengine_filter_shipping_styles', 'operator' => '===', 'value' => 'default'],
						['name' => 'shopengine_filter_stock_styles', 'operator' => '===', 'value' => 'default'],
						['name' => 'shopengine_filter_onsale_styles', 'operator' => '===', 'value' => 'default'],
					],
				],
			]
		);

		$this->add_control(
			'shopengine_checkbox_tabs_checked_bg_clr',
			[
				'label'     => esc_html__('Checked Background', 'shopengine-pro'),
				'type'      => Controls_Manager::COLOR,
				'alpha'     => false,
				'default'   => '#FF3F00',
				'separator' => 'after',
				'selectors' => [
					'{{WRAPPER}} .shopengine-product-filters .rating-label-triger.checked .shopengine-filter-rating__labels--mark' => 'background: {{VALUE}}; border-color: {{VALUE}} !important;',
					'{{WRAPPER}} .shopengine-product-filters input:checked + label .shopengine-checkbox-icon'                      => 'background: {{VALUE}}; border-color: {{VALUE}} !important;',
					'{{WRAPPER}} .open .shopengine-collapse-icon' => 'color: {{VALUE}} !important;',
				],
				'conditions' => [
					'relation' => 'or',
					'terms' => [
						['name' => 'shopengine_filter_color_styles', 'operator' => '===', 'value' => 'default'],
						['name' => 'shopengine_filter_image_styles', 'operator' => '===', 'value' => 'default'],
						['name' => 'shopengine_filter_rating_styles', 'operator' => '===', 'value' => 'default'],
						['name' => 'shopengine_filter_category_styles', 'operator' => '===', 'value' => 'default'],
						['name' => 'shopengine_filter_label_styles', 'operator' => '===', 'value' => 'default'],
						['name' => 'shopengine_filter_attribute_styles', 'operator' => '===', 'value' => 'default'],
						['name' => 'shopengine_filter_shipping_styles', 'operator' => '===', 'value' => 'default'],
						['name' => 'shopengine_filter_stock_styles', 'operator' => '===', 'value' => 'default'],
						['name' => 'shopengine_filter_onsale_styles', 'operator' => '===', 'value' => 'default'],
					],
				],
			]
		);

		$this->add_control(
			'shopengine_checkbox_size',
			[
				'label'      => esc_html__('Checkbox Size', 'shopengine-pro'),
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
					'size' => 22,
				],
				'selectors'  => [
					'{{WRAPPER}} .shopengine-product-filters .shopengine-filter-rating__labels--mark' => 'line-height: {{SIZE}}{{UNIT}}; width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .shopengine-product-filters .shopengine-checkbox-icon'               => 'line-height: {{SIZE}}{{UNIT}}; width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
				'conditions' => [
					'relation' => 'or',
					'terms' => [
						['name' => 'shopengine_filter_color_styles', 'operator' => '===', 'value' => 'default'],
						['name' => 'shopengine_filter_image_styles', 'operator' => '===', 'value' => 'default'],
						['name' => 'shopengine_filter_rating_styles', 'operator' => '===', 'value' => 'default'],
						['name' => 'shopengine_filter_category_styles', 'operator' => '===', 'value' => 'default'],
						['name' => 'shopengine_filter_label_styles', 'operator' => '===', 'value' => 'default'],
						['name' => 'shopengine_filter_attribute_styles', 'operator' => '===', 'value' => 'default'],
						['name' => 'shopengine_filter_shipping_styles', 'operator' => '===', 'value' => 'default'],
						['name' => 'shopengine_filter_stock_styles', 'operator' => '===', 'value' => 'default'],
						['name' => 'shopengine_filter_onsale_styles', 'operator' => '===', 'value' => 'default'],
					],
				],
			]
		);

		$this->add_control(
			'shopengine_checkbox_vertical_position',
			[
				'label'      => esc_html__('Vertical position', 'shopengine-pro'),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range'      => [
					'px' => [
						'min'  => -100,
						'max'  => 100,
						'step' => 1,
					],
				],
				'default'    => [
					'unit' => 'px',
					'size' => 0,
				],
				'selectors'  => [
					'{{WRAPPER}} .shopengine-product-filters .shopengine-filter-rating__labels--mark' => 'transform: translateY( {{SIZE}}{{UNIT}});',
					'{{WRAPPER}} .shopengine-product-filters .shopengine-checkbox-icon'               => 'transform: translateY( {{SIZE}}{{UNIT}});',
				],
				'conditions' => [
					'relation' => 'or',
					'terms' => [
						['name' => 'shopengine_filter_color_styles', 'operator' => '===', 'value' => 'default'],
						['name' => 'shopengine_filter_image_styles', 'operator' => '===', 'value' => 'default'],
						['name' => 'shopengine_filter_rating_styles', 'operator' => '===', 'value' => 'default'],
						['name' => 'shopengine_filter_category_styles', 'operator' => '===', 'value' => 'default'],
						['name' => 'shopengine_filter_label_styles', 'operator' => '===', 'value' => 'default'],
						['name' => 'shopengine_filter_attribute_styles', 'operator' => '===', 'value' => 'default'],
						['name' => 'shopengine_filter_shipping_styles', 'operator' => '===', 'value' => 'default'],
						['name' => 'shopengine_filter_stock_styles', 'operator' => '===', 'value' => 'default'],
						['name' => 'shopengine_filter_onsale_styles', 'operator' => '===', 'value' => 'default'],
					],
				],
			]
		);


		$this->add_control(
			'shopengine_checkbox_radius',
			[
				'label'      => esc_html__('Border Radius', 'shopengine-pro'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px'],
				'default'    => [
					'top'      => '3',
					'right'    => '3',
					'bottom'   => '3',
					'left'     => '3',
					'unit'     => 'px',
					'isLinked' => true,
				],
				'selectors'  => [
					'{{WRAPPER}} .shopengine-product-filters .shopengine-filter-rating__labels--mark' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
					'.rtl {{WRAPPER}} .shopengine-product-filters .shopengine-filter-rating__labels--mark' => 'border-radius: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}} !important;',
					'{{WRAPPER}} .shopengine-product-filters .shopengine-checkbox-icon'               => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
					'.rtl {{WRAPPER}} .shopengine-product-filters .shopengine-checkbox-icon'               => 'border-radius: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}} !important;',
				],
				'conditions' => [
					'relation' => 'or',
					'terms' => [
						['name' => 'shopengine_filter_color_styles', 'operator' => '===', 'value' => 'default'],
						['name' => 'shopengine_filter_image_styles', 'operator' => '===', 'value' => 'default'],
						['name' => 'shopengine_filter_rating_styles', 'operator' => '===', 'value' => 'default'],
						['name' => 'shopengine_filter_category_styles', 'operator' => '===', 'value' => 'default'],
						['name' => 'shopengine_filter_label_styles', 'operator' => '===', 'value' => 'default'],
						['name' => 'shopengine_filter_attribute_styles', 'operator' => '===', 'value' => 'default'],
						['name' => 'shopengine_filter_shipping_styles', 'operator' => '===', 'value' => 'default'],
						['name' => 'shopengine_filter_stock_styles', 'operator' => '===', 'value' => 'default'],
						['name' => 'shopengine_filter_onsale_styles', 'operator' => '===', 'value' => 'default'],
					],
				],
			]
		);

		$this->add_control(
			'shopengine_filter_circle_style',
			[
				'label'     => esc_html__('Circle Style', 'shopengine-pro'),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
				'conditions' => [
					'relation' => 'or',
					'terms' => [
						['name' => 'shopengine_filter_color_styles', 'operator' => '===', 'value' => 'style_2'],
						['name' => 'shopengine_filter_image_styles', 'operator' => '===', 'value' => 'style_2'],
						['name' => 'shopengine_filter_rating_styles', 'operator' => '===', 'value' => 'style_2'],
						['name' => 'shopengine_filter_category_styles', 'operator' => '===', 'value' => 'style_2'],
						['name' => 'shopengine_filter_label_styles', 'operator' => '===', 'value' => 'style_2'],
						['name' => 'shopengine_filter_attribute_styles', 'operator' => '===', 'value' => 'style_2'],
						['name' => 'shopengine_filter_shipping_styles', 'operator' => '===', 'value' => 'style_2'],
						['name' => 'shopengine_filter_stock_styles', 'operator' => '===', 'value' => 'style_2'],
						['name' => 'shopengine_filter_onsale_styles', 'operator' => '===', 'value' => 'style_2'],
					],
				],
			]
		);

		$this->add_control(
			'shpengine_cirlce_icon',
			[
				'label' => esc_html__('Circle Icon', 'shopengine-pro'),
				'type' => \Elementor\Controls_Manager::ICONS,
				'default' => [
					'value' => 'fas fa-circle',
					'library' => 'solid',
				],
				'conditions' => [
					'relation' => 'or',
					'terms' => [
						['name' => 'shopengine_filter_color_styles', 'operator' => '===', 'value' => 'style_2'],
						['name' => 'shopengine_filter_image_styles', 'operator' => '===', 'value' => 'style_2'],
						['name' => 'shopengine_filter_rating_styles', 'operator' => '===', 'value' => 'style_2'],
						['name' => 'shopengine_filter_category_styles', 'operator' => '===', 'value' => 'style_2'],
						['name' => 'shopengine_filter_label_styles', 'operator' => '===', 'value' => 'style_2'],
						['name' => 'shopengine_filter_attribute_styles', 'operator' => '===', 'value' => 'style_2'],
						['name' => 'shopengine_filter_shipping_styles', 'operator' => '===', 'value' => 'style_2'],
						['name' => 'shopengine_filter_stock_styles', 'operator' => '===', 'value' => 'style_2'],
						['name' => 'shopengine_filter_onsale_styles', 'operator' => '===', 'value' => 'style_2'],
					],
				],
			]
		);

		$this->add_control(
			'shopengine_style_icon_size',
			[
				'label'      => esc_html__('Circle Icon Size', 'shopengine-pro'),
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
					'{{WRAPPER}} .shopengine-product-filters .shopengine-style-icon :is(span, i, svg, img)' => 'font-size: {{SIZE}}{{UNIT}}; width: {{SIZE}}{{UNIT}};display:inline-block;',
				],
				'conditions' => [
					'relation' => 'or',
					'terms' => [
						['name' => 'shopengine_filter_color_styles', 'operator' => '===', 'value' => 'style_2'],
						['name' => 'shopengine_filter_image_styles', 'operator' => '===', 'value' => 'style_2'],
						['name' => 'shopengine_filter_rating_styles', 'operator' => '===', 'value' => 'style_2'],
						['name' => 'shopengine_filter_category_styles', 'operator' => '===', 'value' => 'style_2'],
						['name' => 'shopengine_filter_label_styles', 'operator' => '===', 'value' => 'style_2'],
						['name' => 'shopengine_filter_attribute_styles', 'operator' => '===', 'value' => 'style_2'],
						['name' => 'shopengine_filter_shipping_styles', 'operator' => '===', 'value' => 'style_2'],
						['name' => 'shopengine_filter_stock_styles', 'operator' => '===', 'value' => 'style_2'],
						['name' => 'shopengine_filter_onsale_styles', 'operator' => '===', 'value' => 'style_2'],
					],
				],
			]
		);

		$this->add_control(
			'shopengine_style_icon_vertical_position',
			[
				'label'      => esc_html__('Circle Icon Vertical position', 'shopengine-pro'),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range'      => [
					'px' => [
						'min'  => -100,
						'max'  => 100,
						'step' => 1,
					],
				],
				'default'    => [
					'unit' => 'px',
					'size' => 0,
				],
				'selectors'  => [
					'{{WRAPPER}} .shopengine-product-filters .shopengine-style-icon' => 'transform: translateY( {{SIZE}}{{UNIT}});',
				],
				'conditions' => [
					'relation' => 'or',
					'terms' => [
						['name' => 'shopengine_filter_color_styles', 'operator' => '===', 'value' => 'style_2'],
						['name' => 'shopengine_filter_image_styles', 'operator' => '===', 'value' => 'style_2'],
						['name' => 'shopengine_filter_rating_styles', 'operator' => '===', 'value' => 'style_2'],
						['name' => 'shopengine_filter_category_styles', 'operator' => '===', 'value' => 'style_2'],
						['name' => 'shopengine_filter_label_styles', 'operator' => '===', 'value' => 'style_2'],
						['name' => 'shopengine_filter_attribute_styles', 'operator' => '===', 'value' => 'style_2'],
						['name' => 'shopengine_filter_shipping_styles', 'operator' => '===', 'value' => 'style_2'],
						['name' => 'shopengine_filter_stock_styles', 'operator' => '===', 'value' => 'style_2'],
						['name' => 'shopengine_filter_onsale_styles', 'operator' => '===', 'value' => 'style_2'],
					],
				],
			]
		);

		$this->add_control(
			'shopengine_filter_title_color_active',
			[
				'label'     => esc_html__('Filter Label Active Color', 'shopengine-pro'),
				'type'      => Controls_Manager::COLOR,
				'alpha'		=> false,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .shopengine-product-filters .shopengine-filter-categories:checked + .shopengine-filter-category-label' => 'color: {{VALUE}};',
					'{{WRAPPER}} .shopengine-product-filters .shopengine-filter-stock:checked + .shopengine-filter-stock-label' => 'color: {{VALUE}};',
					'{{WRAPPER}} .shopengine-product-filters .shopengine-filter-onsale:checked + .shopengine-filter-onsale-label' => 'color: {{VALUE}};',
					'{{WRAPPER}} .shopengine-product-filters .shopengine-filter-attribute:checked + .shopengine-filter-attribute-label' => 'color: {{VALUE}};',
					'{{WRAPPER}} .shopengine-product-filters .shopengine-filter-label:checked + .shopengine-filter-label-label' => 'color: {{VALUE}};',
					'{{WRAPPER}} .shopengine-product-filters .shopengine-filter-shipping:checked + .shopengine-filter-shipping-label' => 'color: {{VALUE}};',
					'{{WRAPPER}} .shopengine-product-filters .shopengine-filter-colors:checked + .shopengine-filter-color-label' => 'color: {{VALUE}};',
				],
				'conditions' => [
					'relation' => 'or',
					'terms' => [
						['name' => 'shopengine_filter_color_styles', 'operator' => '===', 'value' => 'style_2'],
						['name' => 'shopengine_filter_image_styles', 'operator' => '===', 'value' => 'style_2'],
						['name' => 'shopengine_filter_rating_styles', 'operator' => '===', 'value' => 'style_2'],
						['name' => 'shopengine_filter_category_styles', 'operator' => '===', 'value' => 'style_2'],
						['name' => 'shopengine_filter_label_styles', 'operator' => '===', 'value' => 'style_2'],
						['name' => 'shopengine_filter_attribute_styles', 'operator' => '===', 'value' => 'style_2'],
						['name' => 'shopengine_filter_shipping_styles', 'operator' => '===', 'value' => 'style_2'],
						['name' => 'shopengine_filter_stock_styles', 'operator' => '===', 'value' => 'style_2'],
						['name' => 'shopengine_filter_onsale_styles', 'operator' => '===', 'value' => 'style_2'],
					],
				],
			]
		);

		$this->add_control(
			'shopengine_filter_icon_color',
			[
				'label'     => esc_html__('Filter icon Color', 'shopengine-pro'),
				'type'      => Controls_Manager::COLOR,
				'alpha'		=> false,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .shopengine-product-filters .shopengine-filter-category-label .shopengine-style-icon' => 'color: {{VALUE}};',
					'{{WRAPPER}} .shopengine-product-filters .shopengine-filter-stock-label .shopengine-style-icon' => 'color: {{VALUE}};',
					'{{WRAPPER}} .shopengine-product-filters .shopengine-filter-onsale-label .shopengine-style-icon' => 'color: {{VALUE}};',
					'{{WRAPPER}} .shopengine-product-filters .shopengine-filter-attribute-label .shopengine-style-icon' => 'color: {{VALUE}};',
					'{{WRAPPER}} .shopengine-product-filters .shopengine-filter-image-label .shopengine-style-icon' => 'color: {{VALUE}};',
					'{{WRAPPER}} .shopengine-product-filters .shopengine-filter-label-label .shopengine-style-icon' => 'color: {{VALUE}};',
					'{{WRAPPER}} .shopengine-product-filters .shopengine-filter-shipping-label .shopengine-style-icon' => 'color: {{VALUE}};',
					'{{WRAPPER}} .shopengine-product-filters .shopengine-filter-color-label .shopengine-style-icon' => 'color: {{VALUE}};',
					'{{WRAPPER}} .shopengine-product-filters .rating-label-triger.shopengine-style-icon .shopengine-filter-rating__labels--mark' => 'color: {{VALUE}};',
				],
				'conditions' => [
					'relation' => 'or',
					'terms' => [
						['name' => 'shopengine_filter_color_styles', 'operator' => '===', 'value' => 'style_2'],
						['name' => 'shopengine_filter_image_styles', 'operator' => '===', 'value' => 'style_2'],
						['name' => 'shopengine_filter_rating_styles', 'operator' => '===', 'value' => 'style_2'],
						['name' => 'shopengine_filter_category_styles', 'operator' => '===', 'value' => 'style_2'],
						['name' => 'shopengine_filter_label_styles', 'operator' => '===', 'value' => 'style_2'],
						['name' => 'shopengine_filter_attribute_styles', 'operator' => '===', 'value' => 'style_2'],
						['name' => 'shopengine_filter_shipping_styles', 'operator' => '===', 'value' => 'style_2'],
						['name' => 'shopengine_filter_stock_styles', 'operator' => '===', 'value' => 'style_2'],
						['name' => 'shopengine_filter_onsale_styles', 'operator' => '===', 'value' => 'style_2'],
					],
				],
			]
		);
		$this->add_control(
			'shopengine_filter_icon_color_hover',
			[
				'label'     => esc_html__('Filter icon Color Hover', 'shopengine-pro'),
				'type'      => Controls_Manager::COLOR,
				'alpha'		=> false,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .shopengine-product-filters .shopengine-filter-category-label:hover .shopengine-style-icon' => 'color: {{VALUE}};transition: all 0.3s ease-in-out;',
					'{{WRAPPER}} .shopengine-product-filters .shopengine-filter-stock-label:hover .shopengine-style-icon' => 'color: {{VALUE}};transition: all 0.3s ease-in-out;',
					'{{WRAPPER}} .shopengine-product-filters .shopengine-filter-onsale-label:hover .shopengine-style-icon' => 'color: {{VALUE}};transition: all 0.3s ease-in-out;',
					'{{WRAPPER}} .shopengine-product-filters .shopengine-filter-attribute-label:hover .shopengine-style-icon' => 'color: {{VALUE}};transition: all 0.3s ease-in-out;',
					'{{WRAPPER}} .shopengine-product-filters .shopengine-filter-image-label:hover .shopengine-style-icon' => 'color: {{VALUE}};transition: all 0.3s ease-in-out;',
					'{{WRAPPER}} .shopengine-product-filters .shopengine-filter-label-label:hover .shopengine-style-icon' => 'color: {{VALUE}};transition: all 0.3s ease-in-out;',
					'{{WRAPPER}} .shopengine-product-filters .shopengine-filter-shipping-label:hover .shopengine-style-icon' => 'color: {{VALUE}};transition: all 0.3s ease-in-out;',
					'{{WRAPPER}} .shopengine-product-filters .shopengine-filter-color-label:hover .shopengine-style-icon' => 'color: {{VALUE}};transition: all 0.3s ease-in-out;',
					'{{WRAPPER}} .shopengine-product-filters .shopengine-filter-rating__labels .shopengine-style-icon:hover .shopengine-filter-rating__labels--mark' => 'color: {{VALUE}};transition: all 0.3s ease-in-out;',
				],
				'conditions' => [
					'relation' => 'or',
					'terms' => [
						['name' => 'shopengine_filter_color_styles', 'operator' => '===', 'value' => 'style_2'],
						['name' => 'shopengine_filter_image_styles', 'operator' => '===', 'value' => 'style_2'],
						['name' => 'shopengine_filter_rating_styles', 'operator' => '===', 'value' => 'style_2'],
						['name' => 'shopengine_filter_category_styles', 'operator' => '===', 'value' => 'style_2'],
						['name' => 'shopengine_filter_label_styles', 'operator' => '===', 'value' => 'style_2'],
						['name' => 'shopengine_filter_attribute_styles', 'operator' => '===', 'value' => 'style_2'],
						['name' => 'shopengine_filter_shipping_styles', 'operator' => '===', 'value' => 'style_2'],
						['name' => 'shopengine_filter_stock_styles', 'operator' => '===', 'value' => 'style_2'],
						['name' => 'shopengine_filter_onsale_styles', 'operator' => '===', 'value' => 'style_2'],
					],
				],
			]
		);

		$this->add_control(
			'shopengine_filter_icon_color_active',
			[
				'label'     => esc_html__('Filter icon Color Active', 'shopengine-pro'),
				'type'      => Controls_Manager::COLOR,
				'alpha'		=> false,
				'default'   => '',
				'separator' => 'after',
				'selectors' => [
					'{{WRAPPER}} .shopengine-product-filters .shopengine-filter-categories:checked + .shopengine-filter-category-label .shopengine-style-icon' => 'color: {{VALUE}};',
					'{{WRAPPER}} .shopengine-product-filters .shopengine-filter-stock:checked + .shopengine-filter-stock-label .shopengine-style-icon' => 'color: {{VALUE}};',
					'{{WRAPPER}} .shopengine-product-filters .shopengine-filter-onsale:checked + .shopengine-filter-onsale-label .shopengine-style-icon' => 'color: {{VALUE}};',
					'{{WRAPPER}} .shopengine-product-filters .shopengine-filter-attribute:checked + .shopengine-filter-attribute-label .shopengine-style-icon' => 'color: {{VALUE}};',
					'{{WRAPPER}} .shopengine-product-filters .shopengine-filter-image:checked + .shopengine-filter-image-label .shopengine-style-icon' => 'color: {{VALUE}};',
					'{{WRAPPER}} .shopengine-product-filters .shopengine-filter-label:checked + .shopengine-filter-label-label .shopengine-style-icon' => 'color: {{VALUE}};',
					'{{WRAPPER}} .shopengine-product-filters .shopengine-filter-shipping:checked + .shopengine-filter-shipping-label .shopengine-style-icon' => 'color: {{VALUE}};',
					'{{WRAPPER}} .shopengine-product-filters .shopengine-filter-colors:checked + .shopengine-filter-color-label .shopengine-style-icon' => 'color: {{VALUE}};',
					'{{WRAPPER}} .shopengine-product-filters .rating-label-triger.shopengine-style-icon.checked .shopengine-filter-rating__labels--mark' => 'color: {{VALUE}};',
				],
				'conditions' => [
					'relation' => 'or',
					'terms' => [
						['name' => 'shopengine_filter_color_styles', 'operator' => '===', 'value' => 'style_2'],
						['name' => 'shopengine_filter_image_styles', 'operator' => '===', 'value' => 'style_2'],
						['name' => 'shopengine_filter_rating_styles', 'operator' => '===', 'value' => 'style_2'],
						['name' => 'shopengine_filter_category_styles', 'operator' => '===', 'value' => 'style_2'],
						['name' => 'shopengine_filter_label_styles', 'operator' => '===', 'value' => 'style_2'],
						['name' => 'shopengine_filter_attribute_styles', 'operator' => '===', 'value' => 'style_2'],
						['name' => 'shopengine_filter_shipping_styles', 'operator' => '===', 'value' => 'style_2'],
						['name' => 'shopengine_filter_stock_styles', 'operator' => '===', 'value' => 'style_2'],
						['name' => 'shopengine_filter_onsale_styles', 'operator' => '===', 'value' => 'style_2'],
					],
				],
			]
		);


		$this->add_control(
			'shopengine_checkbox_margin_right',
			[
				'label'      => esc_html__('Margin right', 'shopengine-pro'),
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
					'size' => 10,
				],
				'selectors'  => [
					'{{WRAPPER}} .shopengine-product-filters .shopengine-filter-rating__labels--mark'		=> 'margin-right: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .shopengine-product-filters .shopengine-checkbox-icon'						=> 'margin-right: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .shopengine-product-filters .shopengine-style-icon'						=> 'margin-right: {{SIZE}}{{UNIT}};',
					'.rtl {{WRAPPER}} .shopengine-product-filters .shopengine-filter-rating__labels--mark'	=> 'margin-left: {{SIZE}}{{UNIT}}; margin-right: 0;',
					'.rtl {{WRAPPER}} .shopengine-product-filters .shopengine-checkbox-icon'				=> 'margin-left: {{SIZE}}{{UNIT}}; margin-right: 0;',
					'.rtl {{WRAPPER}} .shopengine-product-filters .shopengine-style-icon'				=> 'margin-left: {{SIZE}}{{UNIT}}; margin-right: 0;',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'content_section',
			[
				'label' => esc_html__('Attributes', 'shopengine-pro'),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$attribute_repeater = new \Elementor\Repeater();

		$attribute_repeater->add_control(
			'shopengine_attribute_title',
			[
				'label' => esc_html__('Title', 'shopengine-pro'),
				'type' => \Elementor\Controls_Manager::TEXT,
				'label_block' => true,
			]
		);
		$attribute_repeater->add_control(
			'shopengine_attribute',
			[
				'label' => esc_html__('Attribute', 'shopengine-pro'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => $this->config()->get_attribute_taxonomies()
			]
		);

		$this->add_control(
			'shopengine_enable_attribute',
			[
				'label' => esc_html__('Enable attributes', 'shopengine-pro'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__('Show', 'shopengine-pro'),
				'label_off' => esc_html__('Hide', 'shopengine-pro'),
				'return_value' => 'yes',
				'default' => 'no',
			]
		);

		$this->add_control(
			'shopengine_filter_attribute_expand_collapse',
			[
				'label' => esc_html__('Expand Collapse by default', 'shopengine-pro'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__('Show', 'shopengine-pro'),
				'label_off' => esc_html__('Hide', 'shopengine-pro'),
				'return_value' => 'yes',
				'default' => 'no',
				'condition' => [
					'shopengine_filter_view_mode' => 'collapse',
				],
			]
		);

		//Styles for filter
		$this->add_control(
			'shopengine_filter_attribute_styles',
			[
				'label' => esc_html__('Styles', 'shopengine-pro'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'multiple' => true,
				'options' => [
					'default'  => esc_html__('Default', 'shopengine-pro'),
					'style_2' => esc_html__('Circle', 'shopengine-pro'),
				],
				'default' => 'default',
				'condition' => [
					'shopengine_enable_attribute' => 'yes',
				],
			]
		);

		$this->add_control(
			'shopengine_attributes_list',
			[
				'label' => esc_html__('Attributes list', 'shopengine-pro'),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $attribute_repeater->get_controls(),
				'condition' => [
					'shopengine_enable_attribute' => 'yes',
				],
				'title_field' => '{{{ shopengine_attribute_title }}}',
			]
		);

		$this->end_controls_section();

		/**
		 * Styles : Toggle Button
		 */
		$this->start_controls_section(
			'shopengine_section_filter_group_style',
			[
				'label'     => esc_html__('Filter Toggle Button & Container', 'shopengine-pro'),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'shopengine_filter_toggle_button' => 'yes',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'           => 'shopengine_filter_toggler_typography',
				'label'          => esc_html__('Typography', 'shopengine-pro'),
				'selector'       => '{{WRAPPER}} .shopengine-product-filters .shopengine-filter-group .shopengine-filter-group-toggle',
				'exclude'  => ['font_family', 'text_decoration'],
				'fields_options' => [
					'typography'  => [
						'default' => 'custom',
					],
					'font_weight' => [
						'default' => '600',
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
							'size' => '18',
							'unit' => 'px',
						],
						'label'      => esc_html__('Line Height (px)', 'shopengine-pro'),
						'size_units' => ['px'],
						'responsive' => false,
					],
					'letter_spacing' => [
						'responsive' => false,
					],
				],
			]
		);

		$this->start_controls_tabs('shopengine_filter_toggler_style_tabs');

		$this->start_controls_tab(
			'shopengine_filter_toggler_style_normal',
			[
				'label' => esc_html__('Normal', 'shopengine-pro'),
			]
		);

		$this->add_control(
			'shopengine_filter_toggler_color',
			[
				'label'     => esc_html__('Color', 'shopengine-pro'),
				'type'      => Controls_Manager::COLOR,
				'alpha'     => false,
				'default'   => '#101010',
				'selectors' => [
					'{{WRAPPER}} .shopengine-product-filters .shopengine-filter-group .shopengine-filter-group-toggle' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'shopengine_filter_toggler_background',
			[
				'label'     => esc_html__('Background Color', 'shopengine-pro'),
				'type'      => Controls_Manager::COLOR,
				'alpha'     => false,
				'default'   => '#fff',
				'selectors' => [
					'{{WRAPPER}} .shopengine-product-filters .shopengine-filter-group .shopengine-filter-group-toggle' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'shopengine_filter_toggler_style_hover',
			[
				'label' => esc_html__('Hover & Active', 'shopengine-pro'),
			]
		);

		$this->add_control(
			'shopengine_filter_toggler_color_hover',
			[
				'label'     => esc_html__('Color', 'shopengine-pro'),
				'type'      => Controls_Manager::COLOR,
				'alpha'     => false,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .shopengine-product-filters .shopengine-filter-group .shopengine-filter-group-toggle:hover'  => 'color: {{VALUE}}',
					'{{WRAPPER}} .shopengine-product-filters .shopengine-filter-group .shopengine-filter-group-toggle.active' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'shopengine_filter_toggler_background_hover',
			[
				'label'     => esc_html__('Background Color', 'shopengine-pro'),
				'type'      => Controls_Manager::COLOR,
				'alpha'     => false,
				'default'   => '#3a3a3a',
				'selectors' => [
					'{{WRAPPER}} .shopengine-product-filters .shopengine-filter-group .shopengine-filter-group-toggle:hover'  => 'background-color: {{VALUE}}',
					'{{WRAPPER}} .shopengine-product-filters .shopengine-filter-group .shopengine-filter-group-toggle.active' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'           => 'shopengine_filter_toggler_border',
				'label'          => esc_html__('Border (px)', 'shopengine-pro'),
				'size_units'     => ['px'],
				'fields_options' => [
					'border' => [
						'default' => 'solid',
					],
					'width'  => [
						'default' => [
							'top'      => '2',
							'right'    => '2',
							'bottom'   => '2',
							'left'     => '2',
							'isLinked' => true,
						],
						'selectors' => [
							'{{WRAPPER}} .shopengine-product-filters .shopengine-filter-group .shopengine-filter-group-toggle' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
							'.rtl {{WRAPPER}} .shopengine-product-filters .shopengine-filter-group .shopengine-filter-group-toggle' => 'border-width: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}}',
						]
					],
					'color'  => [
						'default' => '#3a3a3a',
					],
				],
				'selector'       => '{{WRAPPER}} .shopengine-product-filters .shopengine-filter-group .shopengine-filter-group-toggle',
				'separator'      => 'before',
			]
		);

		$this->add_responsive_control(
			'shopengine_filter_toggler_padding',
			[
				'label'      => esc_html__('Padding (px)', 'shopengine-pro'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px'],
				'default'    => [
					'top'      => '10',
					'right'    => '20',
					'bottom'   => '10',
					'left'     => '20',
					'unit'     => 'px',
					'isLinked' => false,
				],
				'selectors'  => [
					'{{WRAPPER}} .shopengine-product-filters .shopengine-filter-group .shopengine-filter-group-toggle' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.rtl {{WRAPPER}} .shopengine-product-filters .shopengine-filter-group .shopengine-filter-group-toggle' => 'padding: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				],
			]
		);
		$this->add_responsive_control(
			'shopengine_filter_toggler_margin',
			[
				'label'      => esc_html__('Margin (px)', 'shopengine-pro'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px'],
				'default'    => [
					'top'      => '0',
					'right'    => '0',
					'bottom'   => '16',
					'left'     => '0',
					'unit'     => 'px',
					'isLinked' => false,
				],
				'selectors'  => [
					'{{WRAPPER}} .shopengine-product-filters .shopengine-filter-group .shopengine-filter-group-toggle' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.rtl {{WRAPPER}} .shopengine-product-filters .shopengine-filter-group .shopengine-filter-group-toggle' => 'margin: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'shopengine_section_filter_content_background',
			[
				'label'     => esc_html__('Container Background Color', 'shopengine-pro'),
				'type'      => Controls_Manager::COLOR,
				'alpha'     => false,
				'default'   => '#fff',
				'separator' => 'before',
				'selectors' => [
					'{{WRAPPER}} .shopengine-product-filters .shopengine-filter-group .shopengine-filter-group-content' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'       => 'shopengine_filter_content_border',
				'label'      => esc_html__('Container Border (px)', 'shopengine-pro'),
				'size_units' => ['px'],
				'selector'   => '{{WRAPPER}} .shopengine-product-filters .shopengine-filter-group .shopengine-filter-group-content-wrapper',
			]
		);


		$this->add_responsive_control(
			'shopengine_section_filter_content_padding',
			[
				'label'      => esc_html__('Container Padding (px)', 'shopengine-pro'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px'],
				'default'    => [
					'top'      => '20',
					'right'    => '40',
					'bottom'   => '20',
					'left'     => '40',
					'unit'     => 'px',
					'isLinked' => false,
				],
				'selectors'  => [
					'{{WRAPPER}} .shopengine-product-filters .shopengine-filter-group .shopengine-filter-group-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.rtl {{WRAPPER}} .shopengine-product-filters .shopengine-filter-group .shopengine-filter-group-content' => 'padding: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'           => 'shopengine_section_filter_content_box_shadow',
				'label'          => esc_html__('Container Box Shadow', 'shopengine-pro'),
				'selector'       => '{{WRAPPER}} .shopengine-product-filters .shopengine-filter-group .shopengine-filter-group-content-wrapper',
				'fields_options' => [
					'box_shadow_type' => [
						'default' => 'yes',
					],
					'box_shadow'      => [
						'default' => [
							'horizontal' => 0,
							'vertical'   => 70,
							'blur'       => 99,
							'spread'     => 0,
							'color'      => 'rgba(0,0,0,0.08)',
						],
					],
				],
			]
		);

		$this->end_controls_section();

		/**
		 * Style: Price Filter
		 */
		$this->start_controls_section(
			'shopengine_section_filter_price_style',
			[
				'label'     => esc_html__('Price Filter / Range Slider', 'shopengine-pro'),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'shopengine_filter_toggle_price' => 'yes',
				],
			]
		);
		$this->add_control(
			'shopengine_range_slider_color',
			[
				'label'     => esc_html__('Slider Color', 'shopengine-pro'),
				'type'      => Controls_Manager::COLOR,
				'alpha'     => false,
				'selectors' => [
					'{{WRAPPER}} .shopengine-filter-price .asRange:before' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'shopengine_range_slider_active_color',
			[
				'label'     => esc_html__('Active Slider Color', 'shopengine-pro'),
				'type'      => Controls_Manager::COLOR,
				'alpha'     => false,
				'selectors' => [
					'{{WRAPPER}} .shopengine-filter-price .asRange > .asRange-selected:before' => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .shopengine-filter-price .asRange > .asRange-pointer'         => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'shopengine_range_text_color',
			[
				'label'     => esc_html__('Range Pricing Text Color', 'shopengine-pro'),
				'type'      => Controls_Manager::COLOR,
				'alpha'     => false,
				'selectors' => [
					'{{WRAPPER}} .shopengine-filter-price-result' => 'color: {{VALUE}};',
				],
				'separator' => 'after',
			]
		);

		$this->add_control(
			'shopengine_filter_price_reset_btn_heading',
			[
				'label'     => esc_html__('Reset Button', 'shopengine-pro'),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);


		$this->add_control(
			'shopengine_reset_btn_margin_bottom',
			[
				'label'      => esc_html__('Margin bottom', 'shopengine-pro'),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range'      => [
					'px' => [
						'min' => 0,
						'max' => 300,
					],
				],
				'default'    => [
					'unit' => 'px',
					'size' => 5,
				],
				'selectors'  => [
					'{{WRAPPER}} .shopengine-filter-price-btns' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs(
			'shopengine_tab_reset_btn'
		);

		$this->start_controls_tab(
			'shopengine_tab_reset_btn_normal',
			[
				'label' => esc_html__('Normal', 'shopengine-pro'),
			]
		);
		$this->add_control(
			'shopengine_reset_btn_color',
			[
				'label'     => esc_html__('Text Color', 'shopengine-pro'),
				'type'      => Controls_Manager::COLOR,
				'alpha'     => false,
				'selectors' => [
					'{{WRAPPER}} .shopengine-filter-price-reset' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'shopengine_reset_btn_bg_color',
			[
				'label'     => esc_html__('Background Color', 'shopengine-pro'),
				'type'      => Controls_Manager::COLOR,
				'alpha'     => false,
				'selectors' => [
					'{{WRAPPER}} .shopengine-filter-price-reset' => 'background-color: {{VALUE}};',
				],
			]
		);


		$this->end_controls_tab();

		$this->start_controls_tab(
			'shopengine_tab_reset_btn_hover',
			[
				'label' => esc_html__('Hover', 'shopengine-pro'),
			]
		);
		$this->add_control(
			'shopengine_reset_btn_hover_color',
			[
				'label'     => esc_html__('Text Color', 'shopengine-pro'),
				'type'      => Controls_Manager::COLOR,
				'alpha'     => false,
				'selectors' => [
					'{{WRAPPER}} .shopengine-filter-price-reset:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'shopengine_reset_btn_hover_bg_color',
			[
				'label'     => esc_html__('Background Color', 'shopengine-pro'),
				'type'      => Controls_Manager::COLOR,
				'alpha'     => false,
				'selectors' => [
					'{{WRAPPER}} .shopengine-filter-price-reset:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();


		$this->end_controls_section();

		/**
		 * Style: Rating Filter
		 */
		$this->start_controls_section(
			'shopengine_section_filter_rating_style',
			[
				'label' => esc_html__('Rating Filter', 'shopengine-pro'),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'shopengine_star_rating',
			[
				'label'   => esc_html__('Rating Icon', 'shopengine-pro'),
				'type'    => Controls_Manager::ICONS,
				'default' => [
					'value'   => 'fas fa-star',
					'library' => 'fa-solid',
				],
			]
		);


		$this->add_control(
			'shopengine_star_active_clr',
			[
				'label'     => esc_html__('Active star color', 'shopengine-pro'),
				'type'      => Controls_Manager::COLOR,
				'alpha'     => false,
				'default'   => '#FEC42D',
				'selectors' => [
					'{{WRAPPER}} .shopengine-product-filters .shopengine-filter-rating__labels-star.active' => 'color: {{VALUE}}',
				],
			]
		);



		$this->add_control(
			'shopengine_star_spacing',
			[
				'label'      => esc_html__('Space between', 'shopengine-pro'),
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
					'size' => 2,
				],
				'selectors'  => [
					'{{WRAPPER}} .shopengine-product-filters .shopengine-filter-rating__labels-star :is(i, svg)' => 'margin: 0 {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'shopengine_star_size',
			[
				'label'      => esc_html__('Star Size', 'shopengine-pro'),
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
					'size' => 16,
				],
				'selectors'  => [
					'{{WRAPPER}} .shopengine-product-filters .shopengine-filter-rating__labels-star :is(i, svg)' => 'font-size: {{SIZE}}{{UNIT}}; width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();


		/**
		 * Style: Category Filter
		 */
		$this->start_controls_section(
			'shopengine_section_filter_category_style',
			[
				'label'     => esc_html__('Category Filter', 'shopengine-pro'),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'shopengine_filter_toggle_category' => 'yes',
				],
			]
		);



		$this->add_control(
			'shopengine_filter_subcategory_marign',
			[
				'label'      => esc_html__('Sub Category Padding', 'shopengine-pro'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px'],
				'default'    => [
					'top'      => '0',
					'right'    => '0',
					'bottom'   => '0',
					'left'     => '24',
					'unit'     => 'px',
					'isLinked' => false,
				],
				'selectors'  => [
					'{{WRAPPER}} .shopengine-product-filters .shopengine-filter-category .shopengine-filter-category-subcategories' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
					'.rtl {{WRAPPER}} .shopengine-product-filters .shopengine-filter-category .shopengine-filter-category-subcategories' => 'padding: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}} !important;',
				],
			]
		);

		$this->add_control(
			'shopengine_filter_scrollbar_heading',
			[
				'label' => esc_html__('Custom ScrollBar', 'shopengine-pro'),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					'shopengine_filter_styles' => 'style_2',
				],
			]
		);

		$this->add_control(
			'shopengine_filter_show_scrollbar',
			[
				'label' => esc_html__('Show Scrollbar', 'shopengine-pro'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__('Show', 'shopengine-pro'),
				'label_off' => esc_html__('Hide', 'shopengine-pro'),
				'return_value' => 'yes',
				'separator' => 'before',
				'default' => '',
				'condition' => [
					'shopengine_filter_category_styles' => 'style_2',
				],
			]
		);

		$this->add_control(
			'shopengine_filter_max_height',
			[
				'label' => esc_html__('Max Height', 'shopengine-pro'),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
						'step' => 1,
					],
				],
				'default' => [],
				'condition' => [
					'shopengine_filter_category_styles' => 'style_2',
					'shopengine_filter_show_scrollbar' => 'yes',
				],
			]
		);

		$this->add_control(
			'shopengine_filter_scrollbar_width',
			[
				'label' => esc_html__('Scrollbar Width', 'shopengine-pro'),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 50,
						'step' => 1,
					],
				],
				'default' => [],
				'condition' => [
					'shopengine_filter_category_styles' => 'style_2',
					'shopengine_filter_show_scrollbar' => 'yes',
				],
				'selectors' => [
					'{{WRAPPER}} .shopengine-product-filters .shopengine-filter-category .ss-scroll' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'shopengine_filter_scrollbar_color',
			[
				'label'     => esc_html__('Scrollbar Color', 'shopengine-pro'),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .shopengine-product-filters .shopengine-filter-category .ss-scroll' => 'background-color: {{VALUE}};',
				],
				'condition' => [
					'shopengine_filter_category_styles' => 'style_2',
					'shopengine_filter_show_scrollbar' => 'yes',
				],
			]
		);



		$this->add_control(
			'shopengine_filter_badge_heading',
			[
				'label' => esc_html__('Badge', 'shopengine-pro'),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					'shopengine_filter_category_styles' => 'style_2',
				],
			]
		);

		$this->add_control(
			'shopengine_filter_badge_width',
			[
				'label' => esc_html__('Badge Width', 'shopengine-pro'),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'separator' => 'before',
				'size_units' => ['px'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					],
				],
				'default' => [],
				'selectors' => [
					'{{WRAPPER}} .shopengine-product-filters .shopengine-filter-single .shopengine-filter-category li .shopengine-filter-category-label .shopengine-filter-category-count' => 'width: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'shopengine_filter_category_styles' => 'style_2',
				],
			]
		);
		$this->add_control(
			'shopengine_filter_badge_height',
			[
				'label' => esc_html__('Badge Height', 'shopengine-pro'),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					],
				],
				'default' => [],
				'selectors' => [
					'{{WRAPPER}} .shopengine-product-filters .shopengine-filter-single .shopengine-filter-category li .shopengine-filter-category-label .shopengine-filter-category-count' => 'height: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'shopengine_filter_category_styles' => 'style_2',
				],
			]
		);

		$this->add_control(
			'shopengine_filter_badge_padding',
			[
				'label' => esc_html__('Padding', 'shopengine-pro'),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => ['px'],
				'selectors' => [
					'{{WRAPPER}} .shopengine-product-filters .shopengine-filter-single .shopengine-filter-category li .shopengine-filter-category-label .shopengine-filter-category-count' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.rtl {{WRAPPER}} .shopengine-product-filters .shopengine-filter-single .shopengine-filter-category li .shopengine-filter-category-label .shopengine-filter-category-count' => 'padding: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				],
				'condition' => [
					'shopengine_filter_category_styles' => 'style_2',
				],
			]
		);
		$this->add_control(
			'shopengine_filter_badge_border_radius',
			[
				'label' => esc_html__('Border Radius', 'shopengine-pro'),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .shopengine-product-filters .shopengine-filter-single .shopengine-filter-category li .shopengine-filter-category-label .shopengine-filter-category-count' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.rtl {{WRAPPER}} .shopengine-product-filters .shopengine-filter-single .shopengine-filter-category li .shopengine-filter-category-label .shopengine-filter-category-count' => 'border-radius: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				],
				'condition' => [
					'shopengine_filter_category_styles' => 'style_2',
				],
			]
		);

		$this->add_control(
			'shopengine_filter_badg_text_color',
			[
				'label'     => esc_html__('Badge Text Color', 'shopengine-pro'),
				'type'      => Controls_Manager::COLOR,
				'alpha'		=> false,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .shopengine-product-filters .shopengine-filter-single .shopengine-filter-category li .shopengine-filter-category-label .shopengine-filter-category-count' => 'color: {{VALUE}};',
				],
				'condition' => [
					'shopengine_filter_category_styles' => 'style_2',
				],
			]
		);

		$this->add_control(
			'shopengine_filter_badge_bg_color',
			[
				'label'     => esc_html__('Badge Background Color', 'shopengine-pro'),
				'type'      => Controls_Manager::COLOR,
				'alpha'		=> false,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .shopengine-product-filters .shopengine-filter-single .shopengine-filter-category li .shopengine-filter-category-label .shopengine-filter-category-count' => 'background-color: {{VALUE}};',
				],
				'condition' => [
					'shopengine_filter_category_styles' => 'style_2',
				],
			]
		);

		$this->add_control(
			'shopengine_filter_badge_active_color',
			[
				'label'     => esc_html__('Badge Active Color', 'shopengine-pro'),
				'type'      => Controls_Manager::COLOR,
				'alpha'		=> false,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .shopengine-product-filters .shopengine-filter-category .shopengine-filter-categories:checked + .shopengine-filter-category-label .shopengine-filter-category-count' => 'color: {{VALUE}};',
				],
				'condition' => [
					'shopengine_filter_category_styles' => 'style_2',
				],
			]
		);

		$this->add_control(
			'shopengine_filter_badge_active_bg_color',
			[
				'label'     => esc_html__('Badge Active Background', 'shopengine-pro'),
				'type'      => Controls_Manager::COLOR,
				'alpha'		=> false,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .shopengine-product-filters .shopengine-filter-category .shopengine-filter-categories:checked + .shopengine-filter-category-label .shopengine-filter-category-count' => 'background-color: {{VALUE}};',
				],
				'condition' => [
					'shopengine_filter_category_styles' => 'style_2',
				],
			]
		);

		$this->end_controls_section();

		/**
		 * Styles: Common
		 */
		$this->start_controls_section(
			'shopengine_section_filter_collapse',
			[
				'label' => esc_html__('Collapse Styles', 'shopengine-pro'),
				'tab'   => Controls_Manager::TAB_STYLE,
				'condition'    => [
					'shopengine_filter_view_mode' => 'collapse',
				],
			]
		);

		$this->add_control(
			'shopengine_section_filter_collapse_border',
			[
				'label'     => esc_html__('Collapse Container Border', 'shopengine-pro'),
				'type'      => Controls_Manager::COLOR,
				'alpha'     => false,
				'default'   => '#eeeeee',
				'selectors' => [
					'{{WRAPPER}} .shopengine-collapse' => 'border:1px solid {{VALUE}} !important;',
				],
			]
		);



		$this->add_responsive_control(
			'shopengine_section_filter_collapse_padding',
			[
				'label'      => esc_html__('Container Padding', 'shopengine-pro'),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range'      => [
					'px' => [
						'min'  => 0,
						'max'  => 100,
						'step' => 1,
					]
				],
				'default'    => [
					'unit' => 'px',
					'size' => 17,
				],
				'selectors'  => [
					'{{WRAPPER}} .shopengine-collapse .shopengine-product-filter-title' => 'padding: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .shopengine-collapse .shopengine-product-filter-title' => 'padding: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .shopengine-collapse .shopengine-collapse-body.open' => 'padding: 0 {{SIZE}}{{UNIT}} {{SIZE}}{{UNIT}} {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function screen()
	{
		$settings = $this->get_settings_for_display();

		$price_min = $settings['shopengine_filter_price_min'] ? $settings['shopengine_filter_price_min'] : 0;
		$price_max = $settings['shopengine_filter_price_max'] ? $settings['shopengine_filter_price_max'] : 9999;

		$default_range = apply_filters('shopengine_filter_price_range', [$price_min, $price_max]);

		$tpl = Products::instance()->get_widget_template($this->get_name(), 'default', \ShopEngine_Pro::widget_dir());

		include $tpl;
	}
}
