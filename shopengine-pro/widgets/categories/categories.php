<?php

namespace Elementor;


use ShopEngine\Core\Template_Cpt;
use ShopEngine\Widgets\Products;

defined('ABSPATH') || exit;


class ShopEngine_Categories extends \ShopEngine\Base\Widget
{

	public function config() {
		return new ShopEngine_Categories_Config();
	}


	protected function register_controls() {
		
		$this->start_controls_section(
			'shopengine_section_product_categories_content',
			array(
				'label' => esc_html__('Content', 'shopengine-pro'),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'shopengine_product_categories_title',
			[
				'label'       => esc_html__('Title', 'shopengine-pro'),
				'type'        => Controls_Manager::TEXT,
				'default'     => 'Product categories',
				'label_block' => true,
			]
		);

		$this->add_control(
			'shopengine_product_categories_orderby',
			[
				'label'       => esc_html__('Order by', 'shopengine-pro'),
				'type'        => Controls_Manager::SELECT,
				'default'     => 'name',
				'options'     => [
					'order' => esc_html__('Category order', 'shopengine-pro'),
					'name'  => esc_html__('Name', 'shopengine-pro'),
				],
				'label_block' => true,
			]
		);

		$this->add_control(
			'shopengine_product_categories_dropdown',
			[
				'label'        => esc_html__('Show as dropdown', 'shopengine-pro'),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__('Yes', 'shopengine-pro'),
				'label_off'    => esc_html__('No', 'shopengine-pro'),
				'return_value' => 'yes',
				'default'      => '',
			]
		);

		$this->add_control(
			'shopengine_product_categories_count',
			[
				'label'        => esc_html__('Show product counts', 'shopengine-pro'),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__('Yes', 'shopengine-pro'),
				'label_off'    => esc_html__('No', 'shopengine-pro'),
				'return_value' => 'yes',
				'default'      => '',
			]
		);

		$this->add_control(
			'shopengine_product_categories_hierarchical',
			[
				'label'        => esc_html__('Show hierarchy', 'shopengine-pro'),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__('Yes', 'shopengine-pro'),
				'label_off'    => esc_html__('No', 'shopengine-pro'),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'shopengine_product_categories_show_parent_only',
			[
				'label'        => esc_html__('Show parent only', 'shopengine-pro'),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__('Yes', 'shopengine-pro'),
				'label_off'    => esc_html__('No', 'shopengine-pro'),
				'return_value' => 'yes',
				'default'      => '',
				'condition'    => [
					'shopengine_product_categories_hierarchical!' => 'yes',
				],
			]
		);

		$this->add_control(
			'shopengine_product_categories_hide_empty',
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
			'shopengine_product_categories_max_depth',
			[
				'label'   => esc_html__('Maximum Depth', 'shopengine-pro'),
				'type'    => Controls_Manager::NUMBER,
				'min'     => 0,
				'max'     => 10,
				'step'    => 1,
				'default' => 0,
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'shopengine_section_product_categories_title',
			array(
				'label' => esc_html__('Title', 'shopengine-pro'),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'shopengine_product_categories_title_color',
			[
				'label'     => esc_html__('Color', 'shopengine-pro'),
				'type'      => Controls_Manager::COLOR,
				'alpha'		=> false,
				'default'   => '#3e3e3e',
				'selectors' => [
					'{{WRAPPER}} .shopengine-categories h2' => 'color: {{VALUE}};',
				]
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'           => 'shopengine_product_categories_title_typography',
				'label'          => esc_html__('Typography', 'shopengine-pro'),
				'selector'       => '{{WRAPPER}} .shopengine-categories h2',
				'exclude'        => ['font_family', 'text_decoration', 'font_style'],
				'fields_options' => [
					'typography'     => [
						'default' => 'custom',
					],
					'font_size'      => [
						'label'      => esc_html__('Font Size (px)', 'shopengine-pro'),
						'size_units' => ['px'],
						'default'    => [
							'size' => '16',
							'unit' => 'px'
						]
					],
					'font_weight'    => [
						'default' => '500',
					],
					'text_transform' => [
						'default' => 'uppercase',
					],
					'line_height'    => [
						'size_units' => ['px'],
						'default' => [
							'size' => '20',
							'unit' => 'px'
						]
					],
					'letter_spacing' => [
						'default' => [
							'size' => '0',
						]
					],
				],
			]
		);

		$this->add_responsive_control(
			'shopengine_product_categories_title_margin',
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
					'{{WRAPPER}} .shopengine-categories h2' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.rtl {{WRAPPER}} .shopengine-categories h2' => 'margin: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'shopengine_section_product_categories_list',
			array(
				'label' => esc_html__('Category List', 'shopengine-pro'),
				'tab'   => Controls_Manager::TAB_STYLE,
				'condition'  => [
					'shopengine_product_categories_dropdown!' => 'yes',
				],
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'           => 'shopengine_product_categories_list_typography',
				'label'          => esc_html__('Typography', 'shopengine-pro'),
				'selector'       => '{{WRAPPER}} .shopengine-categories ul li *, {{WRAPPER}} .shopengine-categories ul li.cat-parent::before',
				'exclude'        => ['font_family', 'text_decoration', 'line_height', 'font_style'],
				'fields_options' => [
					'typography'     => [
						'default' => 'custom',
					],
					'font_size'      => [
						'label'      => esc_html__('Font Size (px)', 'shopengine-pro'),
						'size_units' => ['px'],
						'default'    => [
							'size' => '14',
							'unit' => 'px'
						]
					],
					'font_weight'    => [
						'default' => '500',
					],
					'text_transform' => [
						'default' => '',
					],
					'line_height'    => [
						'default' => [
							'size' => '20',
							'unit' => 'px'
						]
					],
					'letter_spacing' => [
						'default' => [
							'size' => '0',
						]
					],
				],
			]
		);

		$this->start_controls_tabs(
			'shopengine_product_categories_tabs'
		);

		$this->start_controls_tab(
			'shopengine_product_categories_normal_tab',
			[
				'label' => esc_html__('Normal', 'shopengine-pro'),
			]
		);

		$this->add_control(
			'shopengine_product_categories_list_color',
			[
				'label'     => esc_html__('Color', 'shopengine-pro'),
				'type'      => Controls_Manager::COLOR,
				'alpha'		=> false,
				'default'   => '#3e3e3e',
				'selectors' => [
					'{{WRAPPER}} .shopengine-categories ul li *'                  => 'color: {{VALUE}};',
					'{{WRAPPER}} .shopengine-categories ul li.cat-parent::before' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'shopengine_product_categories_hover_tab',
			[
				'label' => esc_html__('Hover', 'shopengine-pro'),
			]
		);

		$this->add_control(
			'shopengine_product_categories_list_hover_color',
			[
				'label'     => esc_html__('Color', 'shopengine-pro'),
				'type'      => Controls_Manager::COLOR,
				'alpha'		=> false,
				'default'   => '#3e3e3e',
				'selectors' => [
					'{{WRAPPER}} .shopengine-categories ul li:hover > a'     => 'color: {{VALUE}};',
					'{{WRAPPER}} .shopengine-categories ul li:hover > span'  => 'color: {{VALUE}};',
					'{{WRAPPER}} .shopengine-categories ul li:hover::before' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->add_responsive_control(
			'shopengine_product_categories_list_padding',
			[
				'label'      => esc_html__('Padding (px)', 'shopengine-pro'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px'],
				'default'    => [
					'top'      => '15',
					'right'    => '0',
					'bottom'   => '15',
					'left'     => '0',
					'unit'     => 'px',
					'isLinked' => false,
				],
				'selectors'  => [
					'{{WRAPPER}} .shopengine-categories ul li a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.rtl {{WRAPPER}} .shopengine-categories ul li a' => 'padding: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				],
				'separator'  => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'           => 'shopengine_product_categories_list_border',
				'label'          => esc_html__('Border', 'shopengine-pro'),
				'fields_options' => [
					'border' => [
						'default' => 'solid',
					],
					'width'  => [
						'default' => [
							'top'      => '1',
							'right'    => '0',
							'bottom'   => '0',
							'left'     => '0',
							'isLinked' => false,
						],
						'selectors' => [
							'{{WRAPPER}} .shopengine-categories ul li:not(:first-of-type), {{WRAPPER}} .shopengine-categories ul li .children li' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
							'.rtl {{WRAPPER}} .shopengine-categories ul li:not(:first-of-type), {{WRAPPER}} .shopengine-categories ul li .children li' => 'border-width: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}}',
						]
					],
					'color'  => [
						'default' => '#DEDFE2'
					]
				],
				'selector'       => '{{WRAPPER}} .shopengine-categories ul li:not(:first-of-type), {{WRAPPER}} .shopengine-categories ul li .children li',
				'separator'      => 'before',
			]
		);

		$this->add_control(
			'shopengine_product_categories_sub_category_padding_left',
			[
				'label'     => esc_html__('Sub Category Padding Left (px)', 'shopengine-pro'),
				'type'      => Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range' => [
					'px' => [
						'min'	=> 0,
						'max'	=> 100,
						'step'	=> 1,
					]
				],
				'default' => [
					'unit' => 'px',
					'size' => 20,
				],
				'selectors' => [
					'{{WRAPPER}} .shopengine-categories ul.children  li' => 'padding-left: {{SIZE}}{{UNIT}};',
					'.rtl {{WRAPPER}} .shopengine-categories ul.children  li' => 'padding-right: {{SIZE}}{{UNIT}}; padding-left:0px;',
				],
				'condition'  => [
					'shopengine_product_categories_hierarchical' => 'yes',
				],
				'separator'      => 'before',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'shopengine_section_product_categories_dropdown',
			array(
				'label' => esc_html__('Category Dropdown', 'shopengine-pro'),
				'tab'   => Controls_Manager::TAB_STYLE,
				'condition'  => [
					'shopengine_product_categories_dropdown' => 'yes',
				],
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'           => 'shopengine_product_categories_dropdown_typography',
				'label'          => esc_html__('Typography', 'shopengine-pro'),
				'selector'       => '{{WRAPPER}} .shopengine-categories .select2 :is(.select2-selection__rendered), .select2-container--default .elementor-element-{{ID}} .select2-dropdown :is(.select2-results__option)',
				'exclude'        => ['font_family'],
				'fields_options' => [
					'typography'     => [
						'default' => 'custom',
					],
					'font_size'      => [
						'label'      => esc_html__('Font Size (px)', 'shopengine-pro'),
						'size_units' => ['px'],
						'default'    => [
							'size' => '14',
							'unit' => 'px'
						]
					],
					'font_weight'    => [
						'default' => '500',
					],
					'text_transform' => [
						'default' => '',
					],
					'line_height'    => [
						'label'      => esc_html__('Line Height (px)', 'shopengine-pro'),
						'default' => [
							'size' => '20',
							'unit' => 'px'
						],
						'size_units' => ['px'],
						'tablet_default' => [
							'unit' => 'px',
						],
						'mobile_default' => [
							'unit' => 'px',
						],
					],
					'letter_spacing' => [
						'label'      => esc_html__('Letter Spacing (px)', 'shopengine-pro'),
						'default' => [
							'size' => '0',
						],
						'size_units' => ['px'],
					],
				],
			]
		);

		$this->start_controls_tabs(
			'shopengine_product_categories_dropdown_tabs'
		);

		$this->start_controls_tab(
			'shopengine_product_categories_dropdown_normal_tab',
			[
				'label' => esc_html__('Normal', 'shopengine-pro'),
			]
		);

		$this->add_control(
			'shopengine_product_categories_dropdown_color',
			[
				'label'     => esc_html__('Color', 'shopengine-pro'),
				'type'      => Controls_Manager::COLOR,
				'alpha'		=> false,
				'default'   => '#3e3e3e',
				'selectors' => [
					'{{WRAPPER}} .shopengine-categories .select2-selection__rendered, .select2-container--default .elementor-element-{{ID}} :is(ul li)'	=> 'color: {{VALUE}};',
					'{{WRAPPER}} .shopengine-categories .select2-selection__arrow b'  => 'border-color: {{VALUE}} transparent transparent transparent !important;',
				],
			]
		);

		$this->add_control(
			'shopengine_product_categories_dropdown_bg_color',
			[
				'label'     => esc_html__('Background Color', 'shopengine-pro'),
				'type'      => Controls_Manager::COLOR,
				'alpha'		=> false,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .shopengine-categories .select2-selection'	=> 'background: {{VALUE}};',
					'.select2-container--default .elementor-element-{{ID}}.select2-dropdown'	=> 'background: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'shopengine_product_categories_dropdown_hover_tab',
			[
				'label' => esc_html__('Hover', 'shopengine-pro'),
			]
		);

		$this->add_control(
			'shopengine_product_categories_dropdown_hover_color',
			[
				'label'     => esc_html__('Color', 'shopengine-pro'),
				'type'      => Controls_Manager::COLOR,
				'alpha'		=> false,
				'default'   => '#3E3E3E',
				'selectors' => [
					'.select2-container--default .elementor-element-{{ID}} :is(.select2-results__option--highlighted, .select2-results__option:hover)'	=> 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'shopengine_product_categories_dropdown_bg_hover_color',
			[
				'label'     => esc_html__('Background Color', 'shopengine-pro'),
				'type'      => Controls_Manager::COLOR,
				'alpha'		=> false,
				'default'   => '#dee3ea',
				'selectors' => [
					'.select2-container--default .elementor-element-{{ID}} :is(.select2-results__option--highlighted, .select2-results__option:hover)'	=> 'background: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'           => 'shopengine_product_categories_dropdown_border',
				'label'          => esc_html__('Border', 'shopengine-pro'),
				'selector'       => '{{WRAPPER}} .shopengine-categories .select2-selection, .select2-dropdown.elementor-element-{{ID}}, .select2-container--default .elementor-element-{{ID}} :is(.select2-search--dropdown .select2-search__field, .select2-search--dropdown .select2-search__field:focus)',
				'fields_options' => [
					'border_type' => [
						'default' => 'yes',
					],
					'border'      => [
						'default'    => 'solid',
					],
					'width' => [
						'label'		=> esc_html__('Width (px)', 'shopengine-pro'),
						'size_units' => ['px'],
						'default'	=> [
							'top'      => '1',
							'right'    => '1',
							'bottom'   => '1',
							'left'     => '1',
							'unit'     => 'px',
						],
						'selectors' => [
							'{{WRAPPER}} .shopengine-categories .select2-selection, .select2-dropdown.elementor-element-{{ID}}, .select2-container--default .elementor-element-{{ID}} :is(.select2-search--dropdown .select2-search__field, .select2-search--dropdown .select2-search__field:focus)' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
							'.rtl {{WRAPPER}} .shopengine-categories .select2-selection, .select2-dropdown.elementor-element-{{ID}}, .select2-container--default .elementor-element-{{ID}} :is(.select2-search--dropdown .select2-search__field, .select2-search--dropdown .select2-search__field:focus)' => 'border-width: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}}',
						]
					],
					'color' => [
						'alpha'      => false,
						'default'    => '#dee3ea',
					],
				],
				'separator'      => 'before',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'shopengine_section_product_categories_typography',
			array(
				'label' => esc_html__('Global Font', 'shopengine-pro'),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'shopengine_product_categories_font_family',
			[
				'label'       => esc_html__('Font Family', 'shopengine-pro'),
				'description' => esc_html__('This font family is set for this specific widget.', 'shopengine-pro'),
				'type'        => Controls_Manager::FONT,
				'default'     => '',
				'selectors'   => [
					'{{WRAPPER}} .shopengine-categories *' => 'font-family: {{VALUE}}',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function screen() {

		$settings = $this->get_settings_for_display();
		$post_type = get_post_type();
		$product = Products::instance()->get_product($post_type);

		$tpl = Products::instance()->get_widget_template($this->get_name(), 'default', \ShopEngine_Pro::widget_dir());

		include $tpl;
	}
}
