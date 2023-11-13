<?php
namespace ExclusiveAddons\Elements;

if ( ! defined( 'ABSPATH' ) ) exit;

use Elementor\Controls_Manager;
use Elementor\Utils;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Background;
use Elementor\Icons_Manager;
use Elementor\Widget_Base;
use Elementor\Plugin;
use Elementor\Repeater;

class Mega_Menu extends Widget_Base {

	public function get_name() {
		return 'exad-mega-menu';
	}

	public function get_title() {
		return esc_html__( 'Mega Menu', 'exclusive-addons-elementor-pro' );
	}

	public function get_icon() {
		return 'exad exad-logo exad-navigation-menu';
	}

	public function get_categories() {
		return [ 'exclusive-addons-elementor' ];
	}

	public function get_keywords() {
        return [ 'menu', 'nav', 'mega', 'mega menu', 'nevigation' ];
	}

	public function get_script_depends() {
        return [ 'exad-slicknav' ];
    }

	/**
	 * Register Nav Menu General Controls.
	 *
	 * @since 1.3.0
	 * @access protected
	 */
	protected function register_controls() {

		$this->start_controls_section(
			'exad_mega_menu_content',
			[
				'label' => __( 'Content', 'exclusive-addons-elementor-pro' ),
			]
		);
		
		$this->add_control(
			'exad_mega_menu_oriantation',
			[
				'label'     => __( 'Menu Oriantation', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'horizontal',
				'options'   => [
					'vertical'   => __( 'Vertical', 'exclusive-addons-elementor-pro' ),
					'horizontal'    => __( 'Horizontal', 'exclusive-addons-elementor-pro' ),
				],
			]
		);
        
        $repeater = new Repeater();

		$repeater->add_control(
			'exad_mega_menu_item_type',
			[
				'label'   => __( 'Item Type', 'exclusive-addons-elementor-pro' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'exad_mega_item_menu',
				'options' => [
					'exad_mega_item_menu'    => __( 'Menu', 'exclusive-addons-elementor-pro' ),
					'exad_mega_item_submenu' => __( 'Sub Menu', 'exclusive-addons-elementor-pro' ),
                ],
            ]
		);

		// menu

		$repeater->add_control(
			'exad_mega_menu_icon',
			[
				'label' => __( 'Icon', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::ICONS,
				'condition' => [
					'exad_mega_submenu_type!' => 'exad_mega_save_template'
				]
			]
		);

		$repeater->add_control(
            'exad_mega_menu_text',
            [
                'label' => __( 'Text', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Item', 'exclusive-addons-elementor-pro' ),
				'conditions'  => [
					'relation' => 'or',
					'terms'    => [
						[
							'name'     => 'exad_mega_menu_item_type',
							'operator' => '==',
							'value'    => 'exad_mega_item_menu',
						],
						[
							'name'     => 'exad_mega_submenu_type',
							'operator' => '==',
							'value'    => 'exad_mega_submenu_text',
						],
					],
				],
            ]
		);

		$repeater->add_control(
			'exad_mega_menu_item_link',
			[
				'label' => __( 'Menu Item Link', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::URL,
				'placeholder' => __( 'https://your-link.com', 'exclusive-addons-elementor-pro' ),
				'show_external' => true,
				'default' => [
					'url' => '#',
					'is_external' => true,
					'nofollow' => true,
				],
				'condition' => [
					'exad_mega_menu_item_type' => 'exad_mega_item_menu'
				]
			]
		);

		$repeater->add_control(
			'exad_mega_menu_dropdown_width',
			[
				'label'       => __( 'Horizontal Dropdown Width', 'exclusive-addons-elementor-pro' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => 'default',
				'description' => __( 'This only works with Horizontal Mega Menu', 'exclusive-addons-elementor-pro' ),
				'options'     => [
					'default'   => __( 'Default', 'exclusive-addons-elementor-pro' ),
					'custom'    => __( 'Custom', 'exclusive-addons-elementor-pro' ),
					'column'    => __( 'Equal to Column', 'exclusive-addons-elementor-pro' ),
					'container' => __( 'Equal to Container', 'exclusive-addons-elementor-pro' ),
					'section'   => __( 'Equal to 	Section', 'exclusive-addons-elementor-pro' ),
				],
				'condition'   => [
					'exad_mega_menu_item_type' => 'exad_mega_item_menu',
				],
			]
		);

		$repeater->add_control(
			'exad_mega_menu_dropdown_custom_width',
			[
				'label' => __( 'Custom Width', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
						'step' => 5,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 200,
				],
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} ul.exad-sub-menu' => 'width: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'exad_mega_menu_item_type' => 'exad_mega_item_menu',
					'exad_mega_menu_dropdown_width' => 'custom'
				]
			]
		);

		$repeater->add_control(
			'exad_mega_menu_vertical_dropdown_width',
			[
				'label'       => __( 'Vertical Dropdown Width', 'exclusive-addons-elementor-pro' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => 'vertical-default',
				'description' => __( 'This only works with Vertical Mega Menu', 'exclusive-addons-elementor-pro' ),
				'options'     => [
					'vertical-default'   => __( 'Default', 'exclusive-addons-elementor-pro' ),
					'vertical-container'    => __( 'Container', 'exclusive-addons-elementor-pro' ),
					'vertical-custom'    => __( 'Custom', 'exclusive-addons-elementor-pro' ),
				],
				'condition'   => [
					'exad_mega_menu_item_type' => 'exad_mega_item_menu',
				],
			]
		);

		$repeater->add_control(
			'exad_mega_menu_dropdown_vertical_custom_width',
			[
				'label' => __( 'Custom Width', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
						'step' => 5,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 200,
				],
				'selectors' => [
					'{{WRAPPER}} .exad-mega-menu.exad-mega-menu-oriantation-vertical {{CURRENT_ITEM}} ul.exad-sub-menu' => 'width: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'exad_mega_menu_item_type' => 'exad_mega_item_menu',
					'exad_mega_menu_vertical_dropdown_width' => 'vertical-custom'
				]
			]
		);

		$repeater->add_control(
			'exad_mega_menu_enable_label',
			[
				'label' => __( 'Enable Label', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Yes', 'exclusive-addons-elementor-pro' ),
				'label_off' => __( 'No', 'exclusive-addons-elementor-pro' ),
				'return_value' => 'yes',
				'default' => 'no',
				'condition' => [
					'exad_mega_submenu_type!' => 'exad_mega_save_template',
				]
			]
		);

		$repeater->add_control(
            'exad_mega_menu_label',
            [
                'label' => __( 'Label', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Hot', 'exclusive-addons-elementor-pro' ),
				'conditions'  => [
					'relation' => 'and',
					'terms'    => [
						[
							'name'     => 'exad_mega_submenu_type',
							'operator' => '==',
							'value'    => 'exad_mega_submenu_text',
						],
						[
							'name'     => 'exad_mega_menu_enable_label',
							'operator' => '==',
							'value'    => 'yes',
						],
					],
				],
            ]
		);

		$repeater->add_control(
			'exad_mega_menu_enable_label_custom_style',
			[
				'label' => __( 'Label Custom Style', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Yes', 'exclusive-addons-elementor-pro' ),
				'label_off' => __( 'No', 'exclusive-addons-elementor-pro' ),
				'return_value' => 'yes',
				'default' => 'no',
				'condition' => [
					// 'exad_mega_menu_item_type' => 'exad_mega_item_menu',
					'exad_mega_menu_enable_label' => 'yes',
					'exad_mega_submenu_type' => 'exad_mega_submenu_text'
				]
			]
		);

		$repeater->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'exad_mega_menu_custom_label_background',
				'label'    => __( 'Background', 'exclusive-addons-elementor-pro' ),
				'types'    => ['classic', 'gradient'],
				'selector' => '{{WRAPPER}} {{CURRENT_ITEM}} .exad-mega-menu-label',
				'condition' => [
					// 'exad_mega_menu_item_type' => 'exad_mega_item_menu',
					'exad_mega_menu_enable_label' => 'yes',
					'exad_mega_menu_enable_label_custom_style' => 'yes',
					'exad_mega_submenu_type' => 'exad_mega_submenu_text'
				]
			]
		);

		$repeater->add_control(
			'exad_mega_menu_custom_label_color',
			[
				'label'     => esc_html__('Text Color', 'exclusive-addons-elementor-pro'),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .exad-mega-menu-label' => 'color: {{VALUE}};'
				],
				'condition' => [
					// 'exad_mega_menu_item_type' => 'exad_mega_item_menu',
					'exad_mega_menu_enable_label' => 'yes',
					'exad_mega_menu_enable_label_custom_style' => 'yes',
					'exad_mega_submenu_type' => 'exad_mega_submenu_text'
				]
			]
		);

		$repeater->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'exad_mega_menu_custom_label_border',
				'label' => __( 'Border', 'exclusive-addons-elementor-pro' ),
				'selector' => '{{WRAPPER}} {{CURRENT_ITEM}} .exad-mega-menu-label',
				'condition' => [
					// 'exad_mega_menu_item_type' => 'exad_mega_item_menu',
					'exad_mega_menu_enable_label' => 'yes',
					'exad_mega_menu_enable_label_custom_style' => 'yes',
					'exad_mega_submenu_type' => 'exad_mega_submenu_text'
				]
			]
		);

		// Submenu
		
		$repeater->add_control(
			'exad_mega_submenu_type',
			[
				'label'   => __( 'Submenu Type', 'exclusive-addons-elementor-pro' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'exad_mega_submenu_text',
				'options' => [
					'exad_mega_submenu_text'    => __( 'Text', 'exclusive-addons-elementor-pro' ),
					'exad_mega_save_template' => __( 'Save Template', 'exclusive-addons-elementor-pro' ),
				],
				'condition' => [
					'exad_mega_menu_item_type' => 'exad_mega_item_submenu'
				]
            ]
		);

		$repeater->add_control(
			'exad_mega_submenu_item_link',
			[
				'label' => __( 'Submenu Item Link', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::URL,
				'placeholder' => __( 'https://your-link.com', 'exclusive-addons-elementor-pro' ),
				'show_external' => true,
				'default' => [
					'url' => '#',
					'is_external' => true,
					'nofollow' => true,
				],
				'condition' => [
					'exad_mega_menu_item_type' => 'exad_mega_item_submenu',
					'exad_mega_submenu_type' => 'exad_mega_submenu_text'
				]
			]
		);
		
		$repeater->add_control(
			'exad_mega_submenu_save_template',
			[
				'label'     => __( 'Select Section', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => $this->get_saved_template( 'section' ),
				'default'   => '-1',
				'condition' => [
					'exad_mega_menu_item_type' => 'exad_mega_item_submenu',
					'exad_mega_submenu_type' => 'exad_mega_save_template'
				]
			]
		);
		
		// Mega Menu Repeter Field
        $this->add_control(
			'exad_mega_menu_items',
			[
				'label'       => __( 'Menu Items', 'exclusive-addons-elementor-pro' ),
				'type'        => Controls_Manager::REPEATER,
				'show_label'  => true,
				'fields'      => $repeater->get_controls(),
				'default'     => [
					[
						'exad_mega_menu_item_type' => 'exad_mega_item_menu',
						'exad_mega_menu_text'      => __( 'Menu Item 1', 'exclusive-addons-elementor-pro' ),
                    ],
					[
						'exad_mega_menu_item_type' => 'exad_mega_item_submenu',
						'exad_mega_menu_text'      => __( 'Sub Menu 1', 'exclusive-addons-elementor-pro' ),
                    ],
					[
						'exad_mega_menu_item_type' => 'exad_mega_item_submenu',
						'exad_mega_menu_text'      => __( 'Sub Menu 2', 'exclusive-addons-elementor-pro' ),
                    ],
					[
						'exad_mega_menu_item_type' => 'exad_mega_item_menu',
						'exad_mega_menu_text'      => __( 'Menu Item 2', 'exclusive-addons-elementor-pro' ),
                    ],
					[
						'exad_mega_menu_item_type' => 'exad_mega_item_submenu',
						'exad_mega_menu_text'      => __( 'Sub Menu 1', 'exclusive-addons-elementor-pro' ),
                    ],
					[
						'exad_mega_menu_item_type' => 'exad_mega_item_submenu',
						'exad_mega_menu_text'      => __( 'Sub Menu 2', 'exclusive-addons-elementor-pro' ),
					],
					[
						'exad_mega_menu_item_type' => 'exad_mega_item_menu',
						'exad_mega_menu_text'      => __( 'Menu Item 3', 'exclusive-addons-elementor-pro' ),
                    ],
					[
						'exad_mega_menu_item_type' => 'exad_mega_item_submenu',
						'exad_mega_menu_text'      => __( 'Sub Menu 1', 'exclusive-addons-elementor-pro' ),
                    ],
					[
						'exad_mega_menu_item_type' => 'exad_mega_item_submenu',
						'exad_mega_menu_text'      => __( 'Sub Menu 2', 'exclusive-addons-elementor-pro' ),
                    ],
                ],
				'title_field' => '{{{ exad_mega_menu_text }}}',
				'separator'   => 'before',
            ]
		);

		$this->add_control(
			'exad-mega-menu-breakpoint',
			[
				'label'        => __( 'Breakpoint', 'exclusive-addons-elementor-pro' ),
				'type'         => Controls_Manager::SELECT,
				'default'      => 'tablet',
				'options'      => [
					'mobile' => __( 'Mobile (768px >)', 'exclusive-addons-elementor-pro' ),
					'tablet' => __( 'Tablet (1025px >)', 'exclusive-addons-elementor-pro' ),
					'none'   => __( 'None', 'exclusive-addons-elementor-pro' ),
				],
				'prefix_class' => 'exad-mega-menu__breakpoint-',
				'render_type'  => 'template'
			]
		);

		$this->end_controls_section();

		/**
		 * Mega menu Container Style
		 */

		$this->start_controls_section(
			'exad_mega_menu_container_style',
			[
				'label' => __( 'Container', 'exclusive-addons-elementor-pro' ),
				'tab'   => Controls_Manager::TAB_STYLE
			]
		);

		$this->add_control(
			'exad_mega_menu_alignment',
			[
				'label'        => __( 'Alignment', 'exclusive-addons-elementor-pro' ),
				'type'         => Controls_Manager::CHOOSE,
				'default'      => 'left',
				'options'      => [
					'left'    => [
						'title' => __( 'Left', 'exclusive-addons-elementor-pro' ),
						'icon'  => 'eicon-h-align-left',
					],
					'center'  => [
						'title' => __( 'Center', 'exclusive-addons-elementor-pro' ),
						'icon'  => 'eicon-h-align-center',
					],
					'right'   => [
						'title' => __( 'Right', 'exclusive-addons-elementor-pro' ),
						'icon'  => 'eicon-h-align-right',
					],
					'justify' => [
						'title' => __( 'Justify', 'exclusive-addons-elementor-pro' ),
						'icon'  => 'eicon-h-align-stretch',
					],
				],
				'condition' => [
					'exad_mega_menu_oriantation' => 'horizontal'
				]
			]
		);

		$this->add_control(
			'exad_mega_menu_width',
			[
				'label' => __( 'Vertical Container Width', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
						'step' => 5,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 280,
				],
				'selectors' => [
					'{{WRAPPER}} .exad-mega-menu.exad-mega-menu-oriantation-vertical' => 'width: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'exad_mega_menu_oriantation' => 'vertical'
				]
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'exad_mega_menu_container_background',
				'label'    => __( 'Background', 'exclusive-addons-elementor-pro' ),
				'types'    => ['classic', 'gradient'],
				'selector' => '{{WRAPPER}} .exad-mega-menu',
			]
		);

		$this->add_responsive_control(
			'exad_mega_menu_container_padding',
			[
				'label'      => __( 'Padding', 'exclusive-addons-elementor-pro' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%', 'em'],
				'default'    => [
					'top'      => '0',
					'right'    => '0',
					'bottom'   => '0',
					'left'     => '0',
					'unit'     => 'px',
					'isLinked' => true,
				],
				'selectors'  => [
					'{{WRAPPER}} .exad-mega-menu' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'exad_mega_menu_container_border',
				'label' => __( 'Border', 'exclusive-addons-elementor-pro' ),
				'selector' => '{{WRAPPER}} .exad-mega-menu',
			]
		);

		$this->add_responsive_control(
			'exad_mega_menu_container_border_radius',
			[
				'label'      => __( 'Border Radius', 'exclusive-addons-elementor-pro' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%', 'em'],
				'default'    => [
					'top'      => '0',
					'right'    => '0',
					'bottom'   => '0',
					'left'     => '0',
					'unit'     => 'px',
					'isLinked' => true,
				],
				'selectors'  => [
					'{{WRAPPER}} .exad-mega-menu' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'exad_mega_menu_container_box_shadow',
				'label' => __( 'Box Shadow', 'exclusive-addons-elementor-pro' ),
				'selector' => '{{WRAPPER}} .exad-mega-menu',
			]
		);
		
		$this->end_controls_section();

		/**
		 * Mega menu Main Menu Style
		 */

		$this->start_controls_section(
			'exad_mega_main_menu_style',
			[
				'label' => __( 'Main Menu', 'exclusive-addons-elementor-pro' ),
				'tab'   => Controls_Manager::TAB_STYLE
			]
		);

		$this->add_responsive_control(
			'exad_mega_main_menu_horizontal_padding',
			[
				'label'      => __( 'Horizontal Padding', 'exclusive-addons-elementor-pro' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'max' => 100
					],
				],
				'default'    => [
					'size' => 15,
					'unit' => 'px'
				],
				'selectors'  => [
					// '{{WRAPPER}} .exad-mega-menu-wrapper .exad-mega-menu-list li.menu-item a.exad-menu-item' => 'padding-left: {{SIZE}}{{UNIT}}; padding-right: {{SIZE}}{{UNIT}}',
					'{{WRAPPER}} a.exad-menu-item' => 'padding-left: {{SIZE}}{{UNIT}}; padding-right: {{SIZE}}{{UNIT}}',
				]
			]
		);

		$this->add_responsive_control(
			'exad_mega_main_menu_vertical_padding',
			[
				'label'      => __( 'Vertical Padding', 'exclusive-addons-elementor-pro' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'max' => 100
					],
				],
				'default'    => [
					'size' => 15,
					'unit' => 'px'
				],
				'selectors'  => [
					// '{{WRAPPER}} .exad-mega-menu-wrapper .exad-mega-menu-list li.menu-item a.exad-menu-item' => 'padding-top: {{SIZE}}{{UNIT}}; padding-bottom: {{SIZE}}{{UNIT}}',
					'{{WRAPPER}} a.exad-menu-item' => 'padding-top: {{SIZE}}{{UNIT}}; padding-bottom: {{SIZE}}{{UNIT}}',
				]
			]
		);

		$this->add_responsive_control(
			'exad_mega_main_menu_space_between',
			[
				'label'      => __( 'Space Between', 'exclusive-addons-elementor-pro' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'max' => 100
					],
				],
				'default'    => [
					'size' => 5,
					'unit' => 'px'
				],
				'selectors'  => [
					'{{WRAPPER}} .exad-mega-menu-wrapper .exad-mega-menu-list > li.menu-item:not(:last-child)' => 'margin-right: {{SIZE}}{{UNIT}};',
				]
			]
		);

		$this->add_responsive_control(
			'exad_mega_main_menu_row_between',
			[
				'label'      => __( 'Row Between', 'exclusive-addons-elementor-pro' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'max' => 100
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .exad-mega-menu-wrapper .exad-mega-menu-list > li.menu-item:not(:last-child)' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				]
			]
		);

		$this->add_control(
			'exad_mega_menu_icon_size',
			[
				'label'      => __( 'Icon Size', 'exclusive-addons-elementor-pro' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'max' => 100
					],
				],
				'default'    => [
					'size' => 17,
					'unit' => 'px'
				],
				'selectors'  => [
					'{{WRAPPER}} .exad-menu-item .exad-mega-menu-icon i' => 'font-size: {{SIZE}}{{UNIT}};',
				]
			]
		);

		$this->add_control(
			'exad_mega_menu_icon_spacing',
			[
				'label'      => __( 'Icon Spacing', 'exclusive-addons-elementor-pro' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'max' => 100
					],
				],
				'default'    => [
					'size' => 10,
					'unit' => 'px'
				],
				'selectors'  => [
					'{{WRAPPER}} .exad-menu-item .exad-mega-menu-icon i' => 'margin-right: {{SIZE}}{{UNIT}};',
				]
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'exad_mega_main_menu_typography',
				'label' => __( 'Typography', 'exclusive-addons-elementor-pro' ),
				'selector' => '{{WRAPPER}} .exad-menu-item',
			]
		);

		$this->add_responsive_control(
			'exad_mega_main_menu_border_radius',
			[
				'label'      => __( 'Border Radius', 'exclusive-addons-elementor-pro' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%', 'em'],
				'default'    => [
					'top'      => '0',
					'right'    => '0',
					'bottom'   => '0',
					'left'     => '0',
					'unit'     => 'px',
					'isLinked' => true,
				],
				'selectors'  => [
					'{{WRAPPER}} .exad-mega-menu-wrapper .exad-mega-menu-list li.menu-item a.exad-menu-item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs('exad_mega_main_menu_tabs');

            // Normal item
            $this->start_controls_tab('exad_mega_main_menu_normal', ['label' => esc_html__('Normal', 'exclusive-addons-elementor-pro')]);

                $this->add_control(
                    'exad_mega_main_menu_normal_background',
                    [
                        'label'     => esc_html__('Background Color', 'exclusive-addons-elementor-pro'),
						'type'      => Controls_Manager::COLOR,
						'default'   => '#7d5bfb',
                        'selectors' => [
                            '{{WRAPPER}} .exad-mega-menu-wrapper .exad-mega-menu-list li.menu-item a.exad-menu-item' => 'background: {{VALUE}};'
                        ]
                    ]
                );

                $this->add_control(
                    'exad_mega_main_menu_normal_text_color',
                    [
                        'label'     => esc_html__('Text Color', 'exclusive-addons-elementor-pro'),
                        'type'      => Controls_Manager::COLOR,
                        'default'   => '#ffffff',
                        'selectors' => [
                            '{{WRAPPER}} .exad-mega-menu-wrapper .exad-mega-menu-list li.menu-item a.exad-menu-item' => 'color: {{VALUE}};'
                        ]
                    ]
                );

                $this->add_group_control(
                    Group_Control_Border::get_type(),
                    [
                        'name' => 'exad_mega_main_menu_normal_border',
                        'label' => __( 'Border', 'exclusive-addons-elementor-pro' ),
                        'selector' => '{{WRAPPER}} .exad-mega-menu-wrapper .exad-mega-menu-list li.menu-item a.exad-menu-item',
                    ]
                );

                $this->add_group_control(
                    Group_Control_Box_Shadow::get_type(),
                    [
                        'name' => 'exad_mega_main_menu_normal_box_shadow',
                        'label' => __( 'Box Shadow', 'exclusive-addons-elementor-pro' ),
                        'selector' => '{{WRAPPER}} .exad-mega-menu-wrapper .exad-mega-menu-list li.menu-item a.exad-menu-item',
                    ]
                );

            $this->end_controls_tab();

            // Hover item
            $this->start_controls_tab('exad_mega_main_menu_hover', ['label' => esc_html__('Hover', 'exclusive-addons-elementor-pro')]);
        
                $this->add_control(
                    'exad_mega_main_menu_hover_background_color',
                    [
                        'label'     => esc_html__('Background Color', 'exclusive-addons-elementor-pro'),
                        'type'      => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .exad-mega-menu-wrapper .exad-mega-menu-list li.menu-item:hover a.exad-menu-item' => 'background: {{VALUE}};'
                        ]
                    ]
                );

                $this->add_control(
                    'exad_mega_main_menu_hover_text_color',
                    [
                        'label'     => esc_html__('Text Color', 'exclusive-addons-elementor-pro'),
                        'type'      => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .exad-mega-menu-wrapper .exad-mega-menu-list li.menu-item:hover a.exad-menu-item' => 'color: {{VALUE}};'
                        ]
                    ]
                );

                $this->add_group_control(
                    Group_Control_Border::get_type(),
                    [
                        'name' => 'exad_mega_main_menu_hover_border',
                        'label' => __( 'Border', 'exclusive-addons-elementor-pro' ),
                        'selector' => '{{WRAPPER}} .exad-mega-menu-wrapper .exad-mega-menu-list li.menu-item:hover a.exad-menu-item',
                    ]
                );

                $this->add_group_control(
                    Group_Control_Box_Shadow::get_type(),
                    [
                        'name' => 'exad_mega_main_menu_hover_box_shadow',
                        'label' => __( 'Box Shadow', 'exclusive-addons-elementor-pro' ),
                        'selector' => '{{WRAPPER}} .exad-mega-menu-wrapper .exad-mega-menu-list li.menu-item:hover a.exad-menu-item',
                    ]
                );
                
            $this->end_controls_tab();

        $this->end_controls_tabs();

		$this->end_controls_section();

		/**
		 * Mega menu Label Style
		 */

		$this->start_controls_section(
			'exad_mega_menu_label_style',
			[
				'label' => __( 'Label', 'exclusive-addons-elementor-pro' ),
				'tab'   => Controls_Manager::TAB_STYLE
			]
		);

		$this->add_control(
			'exad_mega_menu_label_position',
			[
				'label' => __( 'Position', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::POPOVER_TOGGLE,
				'label_off' => __( 'Default', 'exclusive-addons-elementor-pro' ),
				'label_on' => __( 'Custom', 'exclusive-addons-elementor-pro' ),
				'return_value' => 'yes',
                'default' => 'yes',
			]
		);

		$this->start_popover();

            $this->add_control(
                'exad_mega_menu_label_position_left',
                [
                    'label' => __( 'Left Spacing', 'exclusive-addons-elementor-pro' ),
                    'type' => Controls_Manager::SLIDER,
                    'size_units' => [ 'px' ],
                    'range' => [
                        'px' => [
                            'min' => 1,
                            'max' => 500,
                            'step' => 1,
                        ]
                    ],
                    'default' => [
                        'unit' => 'px',
                        'size' => 10,
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .exad-mega-menu-label' => 'left: {{SIZE}}{{UNIT}};',
                    ]
                ]
            );

            $this->add_control(
                'exad_mega_menu_label_position_top',
                [
                    'label' => __( 'Top Spacing', 'exclusive-addons-elementor-pro' ),
                    'type' => Controls_Manager::SLIDER,
                    'size_units' => [ 'px' ],
                    'range' => [
                        'px' => [
                            'min' => 1,
                            'max' => 100,
                            'step' => 1,
                        ]
                    ],
                    'default' => [
                        'unit' => 'px',
                        'size' => 8,
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .exad-mega-menu-label' => 'top: -{{SIZE}}{{UNIT}};',
                    ]
                ]
            );
        
        $this->end_popover();

		$this->add_responsive_control(
			'exad_mega_menu_label_padding',
			[
				'label'      => __( 'Padding', 'exclusive-addons-elementor-pro' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%', 'em'],
				'default'    => [
					'top'      => '2',
					'right'    => '5',
					'bottom'   => '2',
					'left'     => '5',
					'unit'     => 'px',
					'isLinked' => true,
				],
				'selectors'  => [
					'{{WRAPPER}} .exad-mega-menu-label' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'exad_mega_menu_label_background',
				'label'    => __( 'Background', 'exclusive-addons-elementor-pro' ),
				'types'    => ['classic', 'gradient'],
				'selector' => '{{WRAPPER}} .exad-mega-menu-label',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'exad_mega_menu_label_typography',
				'label' => __( 'Typography', 'exclusive-addons-elementor-pro' ),
				'selector' => '{{WRAPPER}} .exad-mega-menu-label',
			]
		);

		$this->add_control(
			'exad_mega_menu_label_color',
			[
				'label'     => esc_html__('Text Color', 'exclusive-addons-elementor-pro'),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .exad-mega-menu-label' => 'color: {{VALUE}};'
				]
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'exad_mega_menu_label_border',
				'label' => __( 'Border', 'exclusive-addons-elementor-pro' ),
				'selector' => '{{WRAPPER}} .exad-mega-menu-label',
			]
		);

		$this->add_responsive_control(
			'exad_mega_menu_label_radius',
			[
				'label'      => __( 'Border Radius', 'exclusive-addons-elementor-pro' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%', 'em'],
				'default'    => [
					'top'      => '0',
					'right'    => '0',
					'bottom'   => '0',
					'left'     => '0',
					'unit'     => 'px',
					'isLinked' => true,
				],
				'selectors'  => [
					'{{WRAPPER}} .exad-mega-menu-label' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'exad_mega_menu_label_shadow',
				'label' => __( 'Box Shadow', 'exclusive-addons-elementor-pro' ),
				'selector' => '{{WRAPPER}} .exad-mega-menu-wrapper .exad-mega-menu-list li.menu-item a.exad-menu-item .exad-mega-menu-label',
			]
		);

		$this->end_controls_section();

		/**
		 * Mega menu Dropdown Style
		 */

		$this->start_controls_section(
			'exad_mega_dropdown_menu_style',
			[
				'label' => __( 'Dropdown Menu', 'exclusive-addons-elementor-pro' ),
				'tab'   => Controls_Manager::TAB_STYLE
			]
		);

		$this->add_control(
			'exad_mega_dropdown_icon_size',
			[
				'label'      => __( 'Icon Size', 'exclusive-addons-elementor-pro' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'max' => 100
					],
				],
				'default'    => [
					'size' => 17,
					'unit' => 'px'
				],
				'selectors'  => [
					'{{WRAPPER}} .exad-menu-item .exad-menu-toggle i' => 'font-size: {{SIZE}}{{UNIT}};',
				]
			]
		);

		$this->add_control(
			'exad_mega_dropdown_icon_spacing',
			[
				'label'      => __( 'Icon Spacing', 'exclusive-addons-elementor-pro' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'max' => 100
					],
				],
				'default'    => [
					'size' => 10,
					'unit' => 'px'
				],
				'selectors'  => [
					'{{WRAPPER}} .exad-menu-item .exad-menu-toggle i' => 'margin-left: {{SIZE}}{{UNIT}};',
				]
			]
		);

		$this->add_control(
			'exad_mega_dropdown_menu_padding',
			[
				'label'     => __('Padding', 'exclusive-addons-elementor-pro'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%', 'em'],
				'default'    => [
					'top'      => '10',
					'right'    => '10',
					'bottom'   => '10',
					'left'     => '10',
					'unit'     => 'px',
					'isLinked' => true,
				],
				'selectors' => [
					'{{WRAPPER}} .exad-mega-menu-wrapper .exad-sub-menu li.menu-item a.exad-sub-menu-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					// '{{WRAPPER}} .exad-mega-menu-wrapper .exad-sub-menu div.exad-mega-menu-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'exad_mega_dropdown_menu_typography',
				'label' => __( 'Typography', 'exclusive-addons-elementor-pro' ),
				'selector' => '{{WRAPPER}} .exad-mega-menu-wrapper .exad-sub-menu li.menu-item a.exad-sub-menu-item',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'exad_mega_dropdown_menu_border',
				'label' => __( 'Border', 'exclusive-addons-elementor-pro' ),
				'selector' => '{{WRAPPER}} .exad-mega-menu-wrapper .exad-sub-menu',
			]
		);

		$this->add_control(
			'exad_mega_dropdown_menu_border_radius',
			[
				'label'     => __('Border Radius', 'exclusive-addons-elementor-pro'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%', 'em'],
				'default'    => [
					'top'      => '0',
					'right'    => '0',
					'bottom'   => '0',
					'left'     => '0',
					'unit'     => 'px',
					'isLinked' => true,
				],
				'selectors' => [
					'{{WRAPPER}} .exad-mega-menu-wrapper .exad-sub-menu' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					// '{{WRAPPER}} .exad-mega-menu-wrapper .exad-sub-menu div.exad-mega-menu-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'exad_mega_dropdown_menu_box_shadow',
				'label' => __( 'Box Shadow', 'exclusive-addons-elementor-pro' ),
				'selector' => '{{WRAPPER}} .exad-mega-menu-wrapper .exad-sub-menu',
			]
		);

		$this->start_controls_tabs('exad_mega_dropdown_menu_tabs');

            // Normal item
            $this->start_controls_tab('exad_mega_dropdown_menu_normal', ['label' => esc_html__('Normal', 'exclusive-addons-elementor-pro')]);

                $this->add_control(
                    'exad_mega_dropdown_menu_normal_background',
                    [
                        'label'     => esc_html__('Background Color', 'exclusive-addons-elementor-pro'),
						'type'      => Controls_Manager::COLOR,
						'default'   => '#222222',
                        'selectors' => [
                            '{{WRAPPER}} .exad-mega-menu-wrapper .exad-sub-menu li.menu-item' => 'background: {{VALUE}};',
                            '{{WRAPPER}} .exad-mega-menu-wrapper .exad-sub-menu div.exad-mega-menu-content' => 'background: {{VALUE}};'
                        ]
                    ]
                );

                $this->add_control(
                    'exad_mega_dropdown_menu_normal_text_color',
                    [
                        'label'     => esc_html__('Text Color', 'exclusive-addons-elementor-pro'),
                        'type'      => Controls_Manager::COLOR,
                        'default'   => '#ffffff',
                        'selectors' => [
                            '{{WRAPPER}} .exad-mega-menu-wrapper .exad-sub-menu li.menu-item a.exad-sub-menu-item' => 'color: {{VALUE}};',
                            // '{{WRAPPER}} .exad-mega-menu-wrapper .exad-sub-menu div.exad-mega-menu-content' => 'color: {{VALUE}};'
                        ]
                    ]
                );

            $this->end_controls_tab();

            // Hover item
            $this->start_controls_tab('exad_mega_dropdown_menu_hover', ['label' => esc_html__('Hover', 'exclusive-addons-elementor-pro')]);
        
				$this->add_control(
					'exad_mega_dropdown_menu_hover_background',
					[
						'label'     => esc_html__('Background Color', 'exclusive-addons-elementor-pro'),
						'type'      => Controls_Manager::COLOR,
						'default'   => '#7d5bfb',
						'selectors' => [
							'{{WRAPPER}} .exad-mega-menu-wrapper .exad-sub-menu li.menu-item:hover' => 'background: {{VALUE}};',
						]
					]
				);

				$this->add_control(
					'exad_mega_dropdown_menu_hover_text_color',
					[
						'label'     => esc_html__('Text Color', 'exclusive-addons-elementor-pro'),
						'type'      => Controls_Manager::COLOR,
						'default'   => '#ffffff',
						'selectors' => [
							'{{WRAPPER}} .exad-mega-menu-wrapper .exad-sub-menu li.menu-item:hover a.exad-sub-menu-item' => 'color: {{VALUE}};',
							// '{{WRAPPER}} .exad-mega-menu-wrapper .exad-sub-menu div.exad-mega-menu-content' => 'color: {{VALUE}};'
						]
					]
				);
                
            $this->end_controls_tab();

		$this->end_controls_tabs();
		
		$this->add_control(
			'exad_mega_dropdown_menu_devider_heading',
			[
				'label' => __( 'Devider', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'exad_mega_dropdown_menu_devider_width',
			[
				'label'      => __( 'Devider Width', 'exclusive-addons-elementor-pro' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'max' => 5
					],
				],
				'default'    => [
					'size' => 1,
					'unit' => 'px'
				],
				'selectors'  => [
					'{{WRAPPER}} .exad-mega-menu-wrapper .exad-sub-menu li.menu-item:not(:last-child)' => 'border-bottom-width: {{SIZE}}{{UNIT}};',
				]
			]
		);

		$this->add_control(
			'exad_mega_dropdown_menu_devider_color',
			[
				'label'     => esc_html__('Text Color', 'exclusive-addons-elementor-pro'),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#c5c5c5',
				'selectors' => [
					'{{WRAPPER}} .exad-mega-menu-wrapper .exad-sub-menu li.menu-item:not(:last-child)' => 'border-bottom-color: {{VALUE}};',
				]
			]
		);

		$this->add_control(
			'exad_mega_dropdown_menu_overflow_heading_in_mobile',
			[
				'label'     => esc_html__( 'OverFlow DropDown', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before'
			]
		);

		$this->add_control(
			'exad_mega_dropdown_menu_overflow_in_mobile',
			[
				'label'         => __( 'OverFlow DropDown Menu', 'exclusive-addons-elementor-pro' ),
				'description' 	=> esc_html__( 'When Sticky Overflow Y Mega menu in Tab & Mobile Version.', 'exclusive-addons-elementor-pro' ),
				'type'          => Controls_Manager::SWITCHER,
				'label_on'      => __( 'Yes', 'exclusive-addons-elementor-pro' ),
				'label_off'     => __( 'No', 'exclusive-addons-elementor-pro' ),
				'render_type'   => 'ui',
				'return_value'  => 'yes',
				'default'       => 'no',
				'prefix_class'  => 'exad-mega-menu-dropdown-overflow-',
			]
		);

		$this->add_responsive_control(
			'exad_mega_dropdown_menu_overflow_in_responsive_height',
			[
				'label' => __( 'Max Height', 'exclusive-addons-elementor-pro' ),
				'description' 	=> esc_html__( 'Set Max Height of the DropDown Menu When display in Tab & Mobile Version.', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 500,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 350,
				],
				'condition' => [
					'exad_mega_dropdown_menu_overflow_in_mobile' => 'yes'
				],
				'selectors' => [
					'{{WRAPPER}}.exad-mega-menu__breakpoint-mobile.exad-mega-menu-dropdown-overflow-yes .exad-mega-menu-wrapper .slicknav_menu .slicknav_nav' => 'max-height: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}}.exad-mega-menu__breakpoint-tablet.exad-mega-menu-dropdown-overflow-yes .exad-mega-menu-wrapper .slicknav_menu .slicknav_nav' => 'max-height: {{SIZE}}{{UNIT}};',
				],
			]
		);


		$this->end_controls_section();

		/**
		 * Mega menu Responsive Style
		 */

		$this->start_controls_section(
			'exad_mega_menu_responsive_style',
			[
				'label' => __( 'Responsive Style', 'exclusive-addons-elementor-pro' ),
				'tab'   => Controls_Manager::TAB_STYLE
			]
		);

		$this->add_control(
			'exad_mega_menu_toggle_style',
			[
				'label' => __( 'Menu Trigger & Close Icon', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'exad_mega_menu_toggle_padding',
			[
				'label'      => esc_html__( 'Padding', 'exclusive-addons-elementor-pro' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%'],
				'selectors'  => [
					'{{WRAPPER}} .slicknav_btn'=> 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				]
			]
		);

		$this->add_control(
			'exad_mega_menu_toggle_color',
			[
				'label'     => __( 'Toggle Bar Color', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .slicknav_menu .slicknav_icon-bar' => 'background-color: {{VALUE}}'
				]
			]
		);

		$this->add_control(
			'exad_mega_menu_toggle_background',
			[
				'label'     => __( 'Background Color', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .slicknav_btn' => 'background-color: {{VALUE}};'
				]
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'exad_mega_menu_toggle_border',
				'label' => __( 'Border', 'exclusive-addons-elementor-pro' ),
				'selector' => '{{WRAPPER}} .slicknav_btn',
			]
		);

		$this->add_responsive_control(
			'exad_mega_menu_toggle_icon_size',
			[
				'label'       => __( 'Icon Size', 'exclusive-addons-elementor-pro' ),
				'type'        => Controls_Manager::SLIDER,
				'range'       => [
					'px'      => [
						'min' => 10
					]
				],
				'selectors'   => [
					'{{WRAPPER}} .slicknav_menu .slicknav_icon-bar' => 'width: {{SIZE}}{{UNIT}}'
				]
			]
		);

		$this->add_responsive_control(
			'exad_mega_menu_toggle_border_radius',
			[
				'label'      => __( 'Border Radius', 'exclusive-addons-elementor-pro' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .slicknav_btn' => 'border-radius: {{SIZE}}{{UNIT}}'
				]
			]
		);

		$this->add_control(
			'exad_mega_main_menu_responsive_style',
			[
				'label' => __( 'Main Menu', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'exad_mega_main_menu_responsive_background',
			[
				'label'     => __( 'Background Color', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .exad-mega-menu-wrapper .slicknav_menu .slicknav_nav' => 'background-color: {{VALUE}};',
				]
			]
		);

		$this->add_control(
			'exad_mega_main_menu_responsive_text_color',
			[
				'label'     => esc_html__('Text Color', 'exclusive-addons-elementor-pro'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .exad-mega-menu-wrapper .slicknav_menu .slicknav_nav li.menu-item a.exad-menu-item' => 'color: {{VALUE}};',
					'{{WRAPPER}} .exad-mega-menu-wrapper .slicknav_menu .slicknav_nav .slicknav_arrow' => 'color: {{VALUE}};'
				]
			]
		);

		$this->add_control(
			'exad_mega_main_menu_responsive_separator_color',
			[
				'label'     => esc_html__('Item Separator Color', 'exclusive-addons-elementor-pro'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .exad-mega-menu-wrapper .slicknav_menu .slicknav_nav li.menu-item:not(:last-child)' => 'border-bottom: 1px solid {{VALUE}};',
				]
			]
		);

		$this->end_controls_section();
	}

	/**
	 *  Get Saved Widgets
	 *
	 *  @param string $type Type.
	 *  @since 0.0.1
	 *  @return string
	 */
	public function get_saved_template( $type = 'page' ) {

		$saved_widgets = $this->get_post_template( $type );
		$options[-1]   = __( 'Select', 'exclusive-addons-elementor-pro' );
		if ( count( $saved_widgets ) ) :
			foreach ( $saved_widgets as $saved_row ) :
				$options[ $saved_row['id'] ] = $saved_row['name'];
			endforeach;
		else :
			$options['no_template'] = __( 'No section template is added.', 'exclusive-addons-elementor-pro' );
		endif;
		return $options;
	}

	/**
	 *  Get Templates based on category
	 *
	 *  @param string $type Type.
	 *  @since 0.0.1
	 *  @return string
	 */
	public function get_post_template( $type = 'page' ) {
		$posts = get_posts(
			array(
				'post_type'        => 'elementor_library',
				'orderby'          => 'title',
				'order'            => 'ASC',
				'posts_per_page'   => '-1',
				'tax_query'        => array(
					array(
						'taxonomy' => 'elementor_library_type',
						'field'    => 'slug',
						'terms'    => $type
					)
				)
			)
		);

		$templates = array();

		foreach ( $posts as $post ) :
			$templates[] = array(
				'id'   => $post->ID,
				'name' => $post->post_title
			);
		endforeach;

		return $templates;
	}

	/**
	 * Render Nav Menu output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.3.0
	 * @access protected
	 */
	protected function render() {

		$settings = $this->get_settings_for_display();
		$i        = 0;
		$in_if    = false;
		$is_child = false;
        ?>

		<div class="exad-mega-menu exad-mega-menu-oriantation-<?php echo $settings['exad_mega_menu_oriantation']; ?>" data-mega-menu-oriantation=<?php echo $settings['exad_mega_menu_oriantation']; ?>>
			<nav class="exad-mega-menu-wrapper exad-mega-menu-align-<?php echo $settings['exad_mega_menu_alignment']; ?>">
				<ul class="exad-mega-menu-list">
				<?php
				$i        = 0;
				$is_child = false;
				foreach ( $settings['exad_mega_menu_items'] as $menu => $item ) {
					$repeater_sub_menu_item = $this->get_repeater_setting_key( 'exad_mega_menu_text', 'exad_mega_menu_items', $menu );

					if ( 'exad_mega_item_submenu' === $item['exad_mega_menu_item_type'] ) {
						if ( false === $is_child ) { ?>
							<ul class='exad-sub-menu parent-do-not-have-template'>
						<?php } 

						if( $item['exad_mega_submenu_type'] === 'exad_mega_submenu_text' ){

							if( !empty($item['exad_mega_submenu_item_link']) ){
								$target = $item['exad_mega_submenu_item_link']['is_external'] ? ' target="_blank"' : '';
								$nofollow = $item['exad_mega_submenu_item_link']['nofollow'] ? ' rel="nofollow"' : '';
							}

							$this->add_render_attribute(
								'menu-sub-item' . $item['_id'],
								'class',
								'menu-item child menu-item-has-children elementor-repeater elementor-repeater-item-' . $item['_id']
							); ?>

							<li <?php echo $this->get_render_attribute_string( 'menu-sub-item' . $item['_id'] ); ?>>
								<a href="<?php echo $item['exad_mega_submenu_item_link']['url']; ?>" <?php echo $target; ?> <?php echo $nofollow; ?> class='exad-sub-menu-item'>
									<?php if( !empty( $item['exad_mega_menu_icon']) ) { ?>
										<span class="exad-mega-sub-menu-icon">
											<?php Icons_Manager::render_icon( $item['exad_mega_menu_icon'], [ 'aria-hidden' => 'true' ] ); ?>
										</span>
									<?php } ?>
									<?php echo $this->get_render_attribute_string( $repeater_sub_menu_item )?> <?php echo $item['exad_mega_menu_text']; ?>
									<?php if( 'yes' === $item['exad_mega_menu_enable_label'] ){ ?>
										<span class='exad-mega-menu-label'><?php echo esc_html( $item['exad_mega_menu_label'] ); ?></span>
									<?php } ?>
								</a>
							</li>
						<?php } ?>
						<?php if( $item['exad_mega_submenu_type'] === 'exad_mega_save_template' ){

							$this->add_render_attribute(
								'menu-content-item' . $item['_id'],
								'class',
								'menu-item exad-mega-menu-content saved-content child elementor-repeater elementor-repeater-item-' . $item['_id']
							); ?>
							<div <?php echo $this->get_render_attribute_string( 'menu-content-item' . $item['_id'] ); ?>>
								<?php echo Plugin::$instance->frontend->get_builder_content_for_display( wp_kses_post( $item['exad_mega_submenu_save_template'] ) ); ?>
							</div>
						<?php } ?>

						<?php 
						$is_child = true;
						$in_if    = true;
					} else {
						$this->add_render_attribute( 'menu-item' . $item['_id'], 'class', 'menu-item menu-item-has-children parent parent-has-no-child elementor-repeater-item-' . $item['_id'] );
						$this->add_render_attribute( 'menu-item' . $item['_id'], 'data-dropdown_width', $item['exad_mega_menu_dropdown_width'] );
						$this->add_render_attribute( 'menu-item' . $item['_id'], 'data-vertical_dropdown_width', $item['exad_mega_menu_vertical_dropdown_width'] );

						$is_child = false;
						if ( true === $in_if ) {
							$in_if   = false; ?>
							</ul></li>
						<?php }

							$i++; ?>

							<li <?php echo $this->get_render_attribute_string( 'menu-item' . $item['_id'] );?>>

						<?php if ( array_key_exists( $menu + 1, $settings['exad_mega_menu_items'] ) ) {
							if ( 'exad_mega_item_submenu' === $settings['exad_mega_menu_items'][ $menu + 1 ]['exad_mega_menu_item_type'] ) { ?>
								<div class='exad-has-submenu-container'>
							<?php }
						} ?>

						<?php
							if( !empty($item['exad_mega_menu_item_link']) ){
								$submenu_target = $item['exad_mega_menu_item_link']['is_external'] ? ' target="_blank"' : '';
								$submenu_nofollow = $item['exad_mega_menu_item_link']['nofollow'] ? ' rel="nofollow"' : '';
							}
						?>

						<a href="<?php echo $item['exad_mega_menu_item_link']['url']; ?>" <?php echo $submenu_target; ?> <?php echo $submenu_nofollow; ?> class='exad-menu-item'>
							<?php if( !empty( $item['exad_mega_menu_icon']) ) { ?>
								<span class="exad-mega-menu-icon">
									<?php Icons_Manager::render_icon( $item['exad_mega_menu_icon'], [ 'aria-hidden' => 'true' ] ); ?>
								</span>
							<?php } ?>
							<?php echo $this->get_render_attribute_string( $repeater_sub_menu_item ); ?> <?php echo $item['exad_mega_menu_text']; ?>
							<?php if( 'horizontal' ===$settings['exad_mega_menu_oriantation'] ) { ?>
								<span class='exad-menu-toggle sub-arrow parent-item'><i class='fa fa-angle-down'></i></span>
							<?php } ?>
							<?php if( 'vertical' ===$settings['exad_mega_menu_oriantation'] ) { ?>
								<span class='exad-menu-toggle sub-arrow parent-item'><i class='eicon-angle-right'></i></span>
							<?php } ?>
							<?php if( 'yes' === $item['exad_mega_menu_enable_label'] ){ ?>
								<span class='exad-mega-menu-label'><?php echo esc_html( $item['exad_mega_menu_label'] ); ?></span>
							<?php } ?>
						</a>
						<?php if ( array_key_exists( $menu + 1, $settings['exad_mega_menu_items'] ) ) {
							if ( 'exad_mega_item_submenu' === $settings['exad_mega_menu_items'][ $menu + 1 ]['exad_mega_menu_item_type'] ) { ?>
								</div>
							<?php }
						}
					}
				} ?>
				</ul>
			</nav>
		</div>
		<?php
	}
}

