<?php
namespace Elementor;

defined('ABSPATH') || exit;

use ShopEngine\Widgets\Products;

class ShopEngine_Comparison_Button extends \ShopEngine\Base\Widget {

	public function config() {
		return new ShopEngine_Comparison_Button_Config();
	}

	protected function register_controls() {


		$this->start_controls_section(
			'shopengine_comparison_btn_content_section',
			array(
				'label' => esc_html__('Content', 'shopengine-pro'),
			)
		);

		$this->add_control(
			'shopengine_comparison_btn_text',
			[
				'label' =>esc_html__('Label', 'shopengine-pro'),
				'type' => Controls_Manager::TEXT,
				'default' =>esc_html__( 'Product Compare', 'shopengine-pro'),
				'placeholder' =>esc_html__('Product Compare', 'shopengine-pro'),
				'dynamic' => [
					'active' => true,
				],
			]
		);

		$this->add_control(
			'shopengine_comparison_btn_icon_settings',
			[
				'label' => esc_html__('Icon Settings', 'shopengine-pro'),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
		
		$this->add_control(
			'shopengine_comparison_btn_show_icon',
			[
				'label' => esc_html__('Show Icon? ', 'shopengine-pro'),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'yes',
				'label_on' =>esc_html__('Yes', 'shopengine-pro'),
				'label_off' =>esc_html__('No', 'shopengine-pro'),
			]
		);
		
		$this->add_control(
			'shopengine_comparison_btn_icon',
			[
				'label' =>esc_html__('Icon', 'shopengine-pro'),
				'type' => Controls_Manager::ICONS,
				'label_block' => true,
				'default' => [
					'value' => 'shopengine-icon-product_compare_1',
					'library' => 'fa-regular',
				],
				'condition'	=> [
					'shopengine_comparison_btn_show_icon'	=> 'yes'
				]
			]
		);

		$this->add_control(
			'shopengine_comparison_btn_icon_position',
			[
				'label' =>esc_html__('Icon Position', 'shopengine-pro'),
				'type' => Controls_Manager::SELECT,
				'default' => 'left',
				'options' => [
					'left' =>esc_html__('Before', 'shopengine-pro'),
					'right' =>esc_html__('After', 'shopengine-pro'),
				],
				'condition'	=> [
					'shopengine_comparison_btn_show_icon'	=> 'yes'
				]
			]
		);

		$this->add_control(
			'shopengine_comparison_btn_counter_settings',
			[
				'label' => esc_html__('Counter Settings', 'shopengine-pro'),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
		
		$this->add_control(
			'shopengine_comparison_btn_show_counter',
			[
				'label' => esc_html__('Show Counter? ', 'shopengine-pro'),
				'type' => Controls_Manager::SWITCHER,
				'default' => '',
				'label_on' =>esc_html__('Yes', 'shopengine-pro'),
				'label_off' =>esc_html__('No', 'shopengine-pro'),
			]
		);
		
		$this->add_control(
			'shopengine_comparison_btn_show_counter_badge',
			[
				'label' => esc_html__('Show Counter Badge? ', 'shopengine-pro'),
				'type' => Controls_Manager::SWITCHER,
				'default' => '',
				'label_on' =>esc_html__('Yes', 'shopengine-pro'),
				'label_off' =>esc_html__('No', 'shopengine-pro'),
				'condition'	=> [
					'shopengine_comparison_btn_show_counter'	=> 'yes'
				]
			]
		);

		$this->add_control(
			'shopengine_comparison_btn_counter_position',
			[
				'label' =>esc_html__('Counter Position', 'shopengine-pro'),
				'type' => Controls_Manager::SELECT,
				'default' => 'right',
				'options' => [
					'left' =>esc_html__('Before', 'shopengine-pro'),
					'right' =>esc_html__('After', 'shopengine-pro'),
				],
				'condition'	=> [
					'shopengine_comparison_btn_show_counter'		=> 'yes',
					'shopengine_comparison_btn_show_counter_badge!'	=> 'yes'
				]
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'shopengine_comparison_btn_section_style_section',
			[
				'label' =>esc_html__('Button', 'shopengine-pro'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'shopengine_comparison_btn_alignment',
			[
				'label' =>esc_html__('Alignment', 'shopengine-pro'),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left'    => [
						'title' =>esc_html__('Left', 'shopengine-pro'),
						'icon' => 'eicon-text-align-left',
					],
					'center' => [
						'title' =>esc_html__('Center', 'shopengine-pro'),
						'icon' => 'eicon-text-align-center',
					],
					'right' => [
						'title' =>esc_html__('Right', 'shopengine-pro'),
						'icon' => 'eicon-text-align-right',
					],
				],
				'prefix_class' => 'elementor-align-',
				'selectors' => [
					'{{WRAPPER}} .shopengine-comparison-button' => 'text-align: {{VALUE}};',
					'.rtl {{WRAPPER}}.elementor-align-left .shopengine-comparison-button' => 'text-align:right;',
					'.rtl {{WRAPPER}}.elementor-align-right .shopengine-comparison-button' => 'text-align:left;',
				],
			]
		);

		$this->add_responsive_control(
			'shopengine_comparison_btn_width',
			[
				'label'			=> esc_html__('Width', 'shopengine-pro'),
				'type'			=> Controls_Manager::SLIDER,
				'size_units'	=> ['px', '%'],
				'selectors'		=> [
					'{{WRAPPER}} .shopengine-comparison-button .comparison-button' => 'width: {{SIZE}}%;',
				]
			]
		);

		$this->add_responsive_control(
			'shopengine_comparison_btn_padding',
			[
				'label' =>esc_html__('Padding (px)', 'shopengine-pro'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units'	=> ['px'],
                'default'    => [
                    'top'      => '12',
                    'right'    => '15',
                    'bottom'   => '12',
                    'left'     => '15',
                    'unit'     => 'px',
                    'isLinked' => false,
                ],
				'selectors' => [
					'{{WRAPPER}} .shopengine-comparison-button .comparison-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.rtl {{WRAPPER}} .shopengine-comparison-button .comparison-button' => 'padding: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'shopengine_comparison_btn_typography',
				'label' =>esc_html__('Typography', 'shopengine-pro'),
				'selector' => '{{WRAPPER}} .shopengine-comparison-button .comparison-button',
				'fields_options' => [
					'typography'     => [
						'default' => 'custom',
					],
					'font_weight'    => [
						'default' => '600',
					],
					'font_size'      => [
						'label'      => esc_html__('Font Size (px)', 'shopengine-pro'),
						'default'    => [
							'size' => '15',
							'unit' => 'px'
						],
						'size_units' => ['px']
					],
					'text_transform' => [
						'default' => 'uppercase',
					],
					'line_height'    => [
						'label'      => esc_html__('Line Height (px)', 'shopengine-pro'),
						'default'    => [
							'size' => '18',
							'unit' => 'px'
						],
						'size_units' => ['px'],
						'tablet_default' => [
							'unit' => 'px',
						],
						'mobile_default' => [
							'unit' => 'px',
						]
					],
				],
			]
		);

		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name' => 'shopengine_comparison_btn_shadow',
				'selector' => '{{WRAPPER}} .shopengine-comparison-button .comparison-button',
			]
		);

		$this->start_controls_tabs('shopengine_comparison_btn_style_tabs');

		$this->start_controls_tab(
			'shopengine_comparison_btn_tabnormal',
			[
				'label' =>esc_html__('Normal', 'shopengine-pro'),
			]
		);

		$this->add_control(
			'shopengine_comparison_btn_text_color',
			[
				'label' =>esc_html__('Text Color', 'shopengine-pro'),
				'type' => Controls_Manager::COLOR,
				'default' => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .shopengine-comparison-button .comparison-button' => 'color: {{VALUE}};',
					'{{WRAPPER}} .shopengine-comparison-button .comparison-button path' => 'stroke: {{VALUE}}; fill: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'shopengine_comparison_btn_bg_color',
			[
				'label' =>esc_html__('Background Color', 'shopengine-pro'),
				'type' => Controls_Manager::COLOR,
				'default' => '#101010',
				'selectors' => [
					'{{WRAPPER}} .shopengine-comparison-button .comparison-button' => 'background: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'shopengine_comparison_btn_tab_button_hover',
			[
				'label' =>esc_html__('Hover', 'shopengine-pro'),
			]
		);

		$this->add_control(
			'shopengine_comparison_btn_hover_color',
			[
				'label' =>esc_html__('Text Color', 'shopengine-pro'),
				'type' => Controls_Manager::COLOR,
				'default' => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .shopengine-comparison-button .comparison-button:hover' => 'color: {{VALUE}};',
					'{{WRAPPER}} .shopengine-comparison-button .comparison-button:hover svg path' => 'stroke: {{VALUE}}; fill: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'shopengine_comparison_btn_bg_hover_color',
			[
				'label' =>esc_html__('Background Color', 'shopengine-pro'),
				'type' => Controls_Manager::COLOR,
				'default' => '#312b2b',
				'selectors' => [
					'{{WRAPPER}} .shopengine-comparison-button .comparison-button:hover' => 'background: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->end_controls_section();

		$this->start_controls_section(
			'shopengine_comparison_btn_border_style_section',
			[
				'label' => esc_html__('Border', 'shopengine-pro'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'shopengine_comparison_btn_border_style',
			[
				'label' => esc_html__('Border Type', 'shopengine-pro'),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'none' => esc_html__('None', 'shopengine-pro'),
					'solid' => esc_html_x('Solid', 'Border Control', 'shopengine-pro'),
					'double' => esc_html_x('Double', 'Border Control', 'shopengine-pro'),
					'dotted' => esc_html_x('Dotted', 'Border Control', 'shopengine-pro'),
					'dashed' => esc_html_x('Dashed', 'Border Control', 'shopengine-pro'),
					'groove' => esc_html_x('Groove', 'Border Control', 'shopengine-pro'),
				],
				'default'	=> 'none',
				'selectors' => [
					'{{WRAPPER}} .shopengine-comparison-button .comparison-button' => 'border-style: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'shopengine_comparison_btn_border_dimensions',
			[
				'label' 	=> esc_html__('Width', 'shopengine-pro'),
				'type' 		=> Controls_Manager::DIMENSIONS,
				'condition'	=> [
					'shopengine_comparison_btn_border_style!' => 'none'
				],
				'selectors' => [
					'{{WRAPPER}} .shopengine-comparison-button .comparison-button' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.rtl {{WRAPPER}} .shopengine-comparison-button .comparison-button' => 'border-width: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs('shopengine_comparison_btn_border_style_tabs');

		$this->start_controls_tab(
			'shopengine_comparison_btn_tab_border_normal',
			[
				'label' =>esc_html__('Normal', 'shopengine-pro'),
			]
		);

		$this->add_control(
			'shopengine_comparison_btn_border_color',
			[
				'label' => esc_html__('Color', 'shopengine-pro'),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .shopengine-comparison-button .comparison-button' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'shopengine_comparison_btn_border_radius',
			[
				'label' =>esc_html__('Border Radius', 'shopengine-pro'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%'],
				'default' => [
					'top' => '',
					'right' => '',
					'bottom' => '' ,
					'left' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .shopengine-comparison-button .comparison-button' =>  'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.rtl {{WRAPPER}} .shopengine-comparison-button .comparison-button' =>  'border-radius: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'shopengine_comparison_btn_tab_button_border_hover',
			[
				'label' =>esc_html__('Hover', 'shopengine-pro'),
			]
		);

		$this->add_control(
			'shopengine_comparison_btn_hover_border_color',
			[
				'label' => esc_html__('Color', 'shopengine-pro'),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .shopengine-comparison-button .comparison-button:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'shopengine_comparison_btn_border_radius_hover',
			[
				'label' =>esc_html__('Border Radius', 'shopengine-pro'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%'],
				'selectors' => [
					'{{WRAPPER}} .shopengine-comparison-button .comparison-button:hover' =>  'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.rtl {{WRAPPER}} .shopengine-comparison-button .comparison-button:hover' =>  'border-radius: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->end_controls_section();

		$this->start_controls_section(
			'shopengine_comparison_btn_box_shadow_style_section',
			[
				'label' =>esc_html__('Shadow', 'shopengine-pro'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
			  'name' => 'shopengine_comparison_btn_box_shadow_group',
			  'selector' => '{{WRAPPER}} .shopengine-comparison-button .comparison-button',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'shopengine_comparison_btn_icon_style_section',
			[
				'label' =>esc_html__('Icon', 'shopengine-pro'),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition'	=> [
					'shopengine_comparison_btn_show_icon'	=> 'yes'
				]
			]
		);

		$this->add_responsive_control(
			'shopengine_comparison_btn_normal_icon_font_size',
			array(
				'label'      => esc_html__('Font Size', 'shopengine-pro'),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => ['px', 'em', 'rem'],
				'range'      => array(
					'px' => array(
						'min' => 1,
						'max' => 100,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .shopengine-comparison-button .comparison-button > i' => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .shopengine-comparison-button .comparison-button > svg'	=> 'max-width: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'shopengine_comparison_btn_normal_icon_padding_left',
			[
				'label' => esc_html__('Add space after icon', 'shopengine-pro'),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 5,
				],
				'selectors' => [
					'{{WRAPPER}} .shopengine-comparison-button .comparison-button > i, {{WRAPPER}} .shopengine-comparison-button .comparison-button > svg' => 'margin-right: {{SIZE}}{{UNIT}};',
					'.rtl {{WRAPPER}} .shopengine-comparison-button .comparison-button > i, .rtl {{WRAPPER}} .shopengine-comparison-button .comparison-button > svg' => 'margin-left: {{SIZE}}{{UNIT}}; margin-right: 0;',
				],
				'condition' => [
					'shopengine_comparison_btn_icon_position' => 'left'
				]
			]
		);

		$this->add_responsive_control(
			'shopengine_comparison_btn_normal_icon_padding_right',
			[
				'label' => esc_html__('Add space before icon', 'shopengine-pro'),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
						'step' =>1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 5,
				],
				'selectors' => [
					'{{WRAPPER}} .shopengine-comparison-button .comparison-button > i, {{WRAPPER}} .shopengine-comparison-button .comparison-button > svg' => 'margin-left: {{SIZE}}{{UNIT}};',
					'.rtl {{WRAPPER}} .shopengine-comparison-button .comparison-button > i, .rtl {{WRAPPER}} .shopengine-comparison-button .comparison-button > svg' => 'margin-left: 0; margin-right: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'shopengine_comparison_btn_icon_position' => 'right'
				]
			]
		);

		$this->add_responsive_control(
			'shopengine_comparison_btn_normal_icon_vertical_align',
			array(
				'label'      => esc_html__('Move Icon Vertically', 'shopengine-pro'),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array(
					'px', 'em', 'rem',
				),
				'range'      => array(
					'px' => array(
						'min' => -20,
						'max' => 20,
					),
					'em' => array(
						'min' => -5,
						'max' => 5,
					),
					'rem' => array(
						'min' => -5,
						'max' => 5,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .shopengine-comparison-button .comparison-button i, .shopengine-comparison-button .comparison-button i:before, {{WRAPPER}} .shopengine-comparison-button .comparison-button svg' => ' -webkit-transform: translateY({{SIZE}}{{UNIT}}); -ms-transform: translateY({{SIZE}}{{UNIT}}); transform: translateY({{SIZE}}{{UNIT}}); display: inline-block;',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'shopengine_comparison_btn_badge_section',
			[
				'label' =>esc_html__('Badge', 'shopengine-pro'),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition'	=> [
					'shopengine_comparison_btn_show_counter'		=> 'yes',
					'shopengine_comparison_btn_show_counter_badge'	=> 'yes',
				]
			]
		);

		$this->add_control(
			'shopengine_comparison_btn_badge_position_controls',
			[
				'label'			=> esc_html__('Position Controls', 'shopengine-pro'),
				'type'			=> Controls_Manager::POPOVER_TOGGLE,
				'label_off'		=> esc_html__('Disabled', 'shopengine-pro'),
				'label_on'		=> esc_html__('Enabled', 'shopengine-pro'),
				'return_value'	=> 'yes',
				'default'		=> 'yes',
			]
		);

		$this->start_popover();

		$this->add_responsive_control(
			'shopengine_comparison_btn_badge_top_position',
			array(
				'label'      => esc_html__('Top Position', 'shopengine-pro'),
				'description' => esc_html__('To add bottom position, empty top position', 'shopengine-pro'),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => ['px', '%'],
				'range'      => [
					'px' => [
						'min' => -500,
						'max' => 500,
					],
					'%' => [
						'min' => -100,
						'max' => 100,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => -10,
				],
				'selectors'  => [
					'{{WRAPPER}} .shopengine-comparison-button .comparison-button .comparison-counter-badge' => 'top: {{SIZE}}{{UNIT}}',
				],
				'condition'	=> [
					'shopengine_comparison_btn_badge_bottom_position[size]'	=> ''
				]
			)
		);

		$this->add_responsive_control(
			'shopengine_comparison_btn_badge_right_position',
			array(
				'label'      => esc_html__('Right Position', 'shopengine-pro'),
				'description' => esc_html__('To add left position, empty right position', 'shopengine-pro'),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => ['px', '%'],
				'range'      => [
					'px' => [
						'min' => -500,
						'max' => 500,
					],
					'%' => [
						'min' => -100,
						'max' => 100,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => -10,
				],
				'selectors'  => [
					'{{WRAPPER}} .shopengine-comparison-button .comparison-button .comparison-counter-badge' => 'right: {{SIZE}}{{UNIT}}',
				],
				'condition'	=> [
					'shopengine_comparison_btn_badge_left_position[size]'	=> ''
				]
			)
		);

		$this->add_responsive_control(
			'shopengine_comparison_btn_badge_bottom_position',
			array(
				'label'      => esc_html__('Bottom Position', 'shopengine-pro'),
				'description' => esc_html__('To add top position, empty bottom position', 'shopengine-pro'),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => ['px', '%'],
				'range'      => [
					'px' => [
						'min' => -500,
						'max' => 500,
					],
					'%' => [
						'min' => -100,
						'max' => 100,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .shopengine-comparison-button .comparison-button .comparison-counter-badge' => 'bottom: {{SIZE}}{{UNIT}}',
				],
				'condition'	=> [
					'shopengine_comparison_btn_badge_top_position[size]'	=> ''
				]
			)
		);

		$this->add_responsive_control(
			'shopengine_comparison_btn_badge_left_position',
			array(
				'label'      => esc_html__('Left Position', 'shopengine-pro'),
				'description' => esc_html__('To add right position, empty left position', 'shopengine-pro'),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => ['px', '%'],
				'range'      => [
					'px' => [
						'min' => -500,
						'max' => 500,
					],
					'%' => [
						'min' => -100,
						'max' => 100,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .shopengine-comparison-button .comparison-button .comparison-counter-badge' => 'bottom: {{SIZE}}{{UNIT}}',
				],
				'condition'	=> [
					'shopengine_comparison_btn_badge_right_position[size]'	=> ''
				]
			)
		);

		$this->end_popover();

		$this->add_responsive_control(
			'shopengine_comparison_btn_badge_size',
			array(
				'label'      => esc_html__('Badge Size', 'shopengine-pro'),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range'      => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 25,
				],
				'selectors'  => [
					'{{WRAPPER}} .shopengine-comparison-button .comparison-button .comparison-counter-badge' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}}; line-height: {{SIZE}}{{UNIT}};',
				],
			)
		);
		
		$this->add_responsive_control(
			'shopengine_comparison_btn_badge_font_size',
			array(
				'label'      => esc_html__('Font Size', 'shopengine-pro'),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range'      => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors'  =>[
					'{{WRAPPER}} .shopengine-comparison-button .comparison-button .comparison-counter-badge' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			)
		);
		
		$this->add_control(
			'shopengine_comparison_btn_badge_text_color',
			[
				'label' => esc_html__('Text Color', 'shopengine-pro'),
				'type' => Controls_Manager::COLOR,
				'default' => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .shopengine-comparison-button .comparison-button .comparison-counter-badge' => 'color: {{VALUE}};',
				],
			]
		);
		
		$this->add_control(
			'shopengine_comparison_btn_badge_bg_color',
			[
				'label' => esc_html__('Background Color', 'shopengine-pro'),
				'type' => Controls_Manager::COLOR,
				'default' => '#2851f3',
				'selectors' => [
					'{{WRAPPER}} .shopengine-comparison-button .comparison-button .comparison-counter-badge' => 'background: {{VALUE}};',
				],
			]
		);
		
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'shopengine_comparison_btn_badge_border',
				'label' => esc_html__('Border', 'shopengine-pro'),
				'selector' => '{{WRAPPER}} .shopengine-comparison-button .comparison-button .comparison-counter-badge',
				'fields_options' => [
					'width' => [
						'selectors' => [
							'{{WRAPPER}} .shopengine-comparison-button .comparison-button .comparison-counter-badge' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
							'.rtl {{WRAPPER}} .shopengine-comparison-button .comparison-button .comparison-counter-badge' => 'border-width: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}}',
						]
					]
				],
			]
		);

		$this->add_responsive_control(
			'shopengine_comparison_btn_badge_border_radius',
			[
				'label' => esc_html__('Border Radius', 'shopengine-pro'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%'],
				'default' => [
					'top' => '100',
					'right' => '100',
					'bottom' => '100' ,
					'left' => '100',
					'unit' => '%',
				],
				'selectors' => [
					'{{WRAPPER}} .shopengine-comparison-button .comparison-button .comparison-counter-badge' =>  'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.rtl {{WRAPPER}} .shopengine-comparison-button .comparison-button .comparison-counter-badge' =>  'border-radius: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
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
