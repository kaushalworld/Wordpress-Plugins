<?php
namespace ExclusiveAddons\Elements;

if ( ! defined( 'ABSPATH' ) ) exit;

use Elementor\Controls_Manager;
use Elementor\Utils;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Background;
use Elementor\Widget_Base;
use Elementor\Plugin;

class Navigation_Menu extends Widget_Base {
	
	/**
	 * Menu index.
	 *
	 * @access protected
	 * @var $nav_menu_index
	 */
	protected $nav_menu_index = 1;

	public function get_name() {
		return 'exad-navigation-menu';
	}

	public function get_title() {
		return esc_html__( 'Navigation Menu', 'exclusive-addons-elementor-pro' );
	}

	public function get_icon() {
		return 'exad exad-logo exad-navigation-menu';
	}

	public function get_categories() {
		return [ 'exclusive-addons-elementor' ];
	}

	public function get_keywords() {
        return [ 'menu', 'nav', 'button' ];
	}

	public function get_script_depends() {
        return [ 'exad-slicknav' ];
    }

	/**
	 * Retrieve the menu index.
	 *
	 * Used to get index of nav menu.
	 *
	 * @since 1.3.0
	 * @access protected
	 *
	 * @return string nav index.
	 */
	protected function get_nav_menu_index() {
		return $this->nav_menu_index++;
	}

	/**
	 * Retrieve the list of available menus.
	 *
	 * Used to get the list of available menus.
	 *
	 * @since 1.3.0
	 * @access private
	 *
	 * @return array get WordPress menus list.
	 */
	private function get_available_menus() {

		$menus = wp_get_nav_menus();

		$options = [];

		foreach ( $menus as $menu ) {
			$options[ $menu->slug ] = $menu->name;
		}

		return $options;
	}

	/**
	 * Register Nav Menu controls.
	 *
	 * @since 1.3.0
	 * @access protected
	 */
	protected function register_controls() {

		$this->register_general_content_controls();
		$this->register_style_content_controls();
		$this->register_dropdown_content_controls();
	}

	/**
	 * Register Nav Menu General Controls.
	 *
	 * @since 1.3.0
	 * @access protected
	 */
	protected function register_general_content_controls() {

		$this->start_controls_section(
			'section_menu',
			[
				'label' => __( 'Menu', 'exclusive-addons-elementor-pro' ),
			]
		);

		$menus = $this->get_available_menus();

		if ( ! empty( $menus ) ) :
			$this->add_control(
				'menu',
				[
					'label'        => __( 'Menu', 'exclusive-addons-elementor-pro' ),
					'type'         => Controls_Manager::SELECT,
					'options'      => $menus,
					'default'      => array_keys( $menus )[0],
					'save_default' => true,
					'separator'    => 'after',
					'description'  => sprintf( __( 'Go to the <a href="%s" target="_blank">Menus screen</a> to manage your menus.', 'exclusive-addons-elementor-pro' ), admin_url( 'nav-menus.php' ) ),
				]
			);
		else :
			$this->add_control(
				'menu',
				[
					'type'            => Controls_Manager::RAW_HTML,
					/* translators: %s Nav menu URL */
					'raw'             => sprintf( __( '<strong>There are no menus in your site.</strong><br>Go to the <a href="%s" target="_blank">Menus screen</a> to create one.', 'exclusive-addons-elementor-pro' ), admin_url( 'nav-menus.php?action=edit&menu=0' ) ),
					'separator'       => 'after',
					'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
				]
			);
		endif;

		$this->add_control(
			'layout_heading',
			[
				'type'      => Controls_Manager::HEADING,
				'label'     => __( 'Layout', 'exclusive-addons-elementor-pro' ),
				'separator' => 'before'
			]
		);

		$this->add_control(
			'exad_nav_menu_layout',
			[
				'label'        => __( 'Layout', 'exclusive-addons-elementor-pro' ),
				'type'         => Controls_Manager::SELECT,
				'default'      => 'horizontal',
				'options'      => [
					'horizontal' => __( 'Horizontal', 'exclusive-addons-elementor-pro' ),
					'vartical' => __( 'Vertical', 'exclusive-addons-elementor-pro' ),
				],
			]
		);

		$this->add_control(
			'navmenu_align',
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
				'prefix_class' => 'exad-nav-menu__align-',
			]
		);

		$this->add_control(
			'heading_responsive',
			[
				'type'      => Controls_Manager::HEADING,
				'label'     => __( 'Responsive', 'exclusive-addons-elementor-pro' ),
				'separator' => 'before'
			]
		);

		$this->add_control(
			'dropdown',
			[
				'label'        => __( 'Breakpoint', 'exclusive-addons-elementor-pro' ),
				'type'         => Controls_Manager::SELECT,
				'default'      => 'tablet',
				'options'      => [
					'mobile' => __( 'Mobile (768px >)', 'exclusive-addons-elementor-pro' ),
					'tablet' => __( 'Tablet (1025px >)', 'exclusive-addons-elementor-pro' ),
					'none'   => __( 'None', 'exclusive-addons-elementor-pro' ),
				],
				'prefix_class' => 'exad-nav-menu__breakpoint-',
				'render_type'  => 'template'
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Register Nav Menu General Controls.
	 *
	 * @since 1.3.0
	 * @access protected
	 */
	protected function register_style_content_controls() {

		$this->start_controls_section(
			'exad_nav_menu_container',
			[
				'label'     => __( 'Container', 'exclusive-addons-elementor-pro' ),
				'tab'       => Controls_Manager::TAB_STYLE
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'exad_nav_menu_container_background',
				'label' => __( 'Background', 'exclusive-addons-elementor-pro' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .exad-nav-menu-wrapper',
			]
		);

		$this->add_responsive_control(
			'exad_nav_menu_container_padding',
			[
				'label'      => __( 'Padding', 'exclusive-addons-elementor-pro' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'default'    => [
					'top' => '0',
					'right' => '0',
					'bottom' => '0',
					'left' => '0',
					'unit' => 'px',
					'isLinked' => true,
				],
				'selectors'  => [
					'{{WRAPPER}} .exad-nav-menu-wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'exad_nav_menu_container_border',
				'label' => __( 'Border', 'exclusive-addons-elementor-pro' ),
				'selector' => '{{WRAPPER}} .exad-nav-menu-wrapper',
			]
		);

		$this->add_responsive_control(
			'exad_nav_menu_container_border_radius',
			[
				'label'      => __( 'Border Radius', 'exclusive-addons-elementor-pro' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'default'    => [
					'top' => '0',
					'right' => '0',
					'bottom' => '0',
					'left' => '0',
					'unit' => 'px',
					'isLinked' => true,
				],
				'selectors'  => [
					'{{WRAPPER}} .exad-nav-menu-wrapper' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'exad_nav_menu_container_border_box_shadow',
				'label' => __( 'Box Shadow', 'exclusive-addons-elementor-pro' ),
				'selector' => '{{WRAPPER}} .exad-nav-menu-wrapper',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_main-menu',
			[
				'label'     => __( 'Main Menu', 'exclusive-addons-elementor-pro' ),
				'tab'       => Controls_Manager::TAB_STYLE
			]
		);

		$this->add_responsive_control(
			'padding_horizontal_menu_item',
			[
				'label'      => __( 'Horizontal Padding', 'exclusive-addons-elementor-pro' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'max' => 50
					],
				],
				'default'    => [
					'size' => 25,
					'unit' => 'px'
				],
				'selectors'  => [
					'{{WRAPPER}} .exad-nav-menu__layout-horizontal a.exad-menu-item' => 'padding-left: {{SIZE}}{{UNIT}}; padding-right: {{SIZE}}{{UNIT}}',
					'{{WRAPPER}} .exad-nav-menu__layout-horizontal a.exad-sub-menu-item' => 'padding-left: {{SIZE}}{{UNIT}}; padding-right: {{SIZE}}{{UNIT}};'
				]
			]
		);

		$this->add_responsive_control(
			'padding_vertical_menu_item',
			[
				'label'      => __( 'Vertical Padding', 'exclusive-addons-elementor-pro' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'max' => 50,
					],
				],
				'default'    => [
					'size' => 15,
					'unit' => 'px',
				],
				'selectors'  => [
					'{{WRAPPER}} .exad-nav-menu__layout-horizontal a.exad-menu-item, {{WRAPPER}} .exad-nav-menu__layout-horizontal a.exad-sub-menu-item' => 'padding-top: {{SIZE}}{{UNIT}}; padding-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'menu_space_between',
			[
				'label'      => __( 'Space Between', 'exclusive-addons-elementor-pro' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'max' => 100,
					],
				],
				'selectors'  => [
					'body:not(.rtl) {{WRAPPER}} .exad-nav-menu__layout-horizontal .exad-nav-menu > li.menu-item:not(:last-child)' => 'margin-right: {{SIZE}}{{UNIT}}',
					'body.rtl {{WRAPPER}} .exad-nav-menu__layout-horizontal .exad-nav-menu > li.menu-item:not(:last-child)' => 'margin-left: {{SIZE}}{{UNIT}}',
					'{{WRAPPER}} nav:not(.exad-nav-menu__layout-horizontal) .exad-nav-menu > li.menu-item:not(:last-child)' => 'margin-bottom: {{SIZE}}{{UNIT}}',
					'(tablet)body:not(.rtl) {{WRAPPER}}.exad-nav-menu__breakpoint-tablet .exad-nav-menu__layout-horizontal .exad-nav-menu > li.menu-item:not(:last-child)' => 'margin-right: 0px',
					'(mobile)body:not(.rtl) {{WRAPPER}}.exad-nav-menu__breakpoint-mobile .exad-nav-menu__layout-horizontal .exad-nav-menu > li.menu-item:not(:last-child)' => 'margin-right: 0px'
				]
			]
		);

		$this->add_responsive_control(
			'menu_row_space',
			[
				'label'      => __( 'Row Spacing', 'exclusive-addons-elementor-pro' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'max' => 100
					],
				],
				'selectors'  => [
					'body:not(.rtl) {{WRAPPER}} .exad-nav-menu__layout-horizontal .exad-nav-menu > li.menu-item' => 'margin-bottom: {{SIZE}}{{UNIT}}'
				]
			]
		);

		$this->add_control(
			'style_divider',
			[
				'type' => Controls_Manager::DIVIDER,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'menu_typography',
				'separator' => 'before',
				'selector'  => '{{WRAPPER}} a.exad-menu-item',
			]
		);

		$this->add_control(
			'exad_nav_menu_hover_style',
			[
				'label'        => __( 'Hover Effect', 'exclusive-addons-elementor-pro' ),
				'type'         => Controls_Manager::SELECT,
				'default'      => 'none',
				'options'      => [
					'none' => __( 'None', 'exclusive-addons-elementor-pro' ),
					'effect-1' => __( 'Effect 1', 'exclusive-addons-elementor-pro' ),
					'effect-2' => __( 'Effect 2', 'exclusive-addons-elementor-pro' ),
					'effect-3' => __( 'Effect 3', 'exclusive-addons-elementor-pro' ),
					'effect-4' => __( 'Effect 4', 'exclusive-addons-elementor-pro' ),
					'effect-5' => __( 'Effect 5', 'exclusive-addons-elementor-pro' ),
					'effect-6' => __( 'Effect 6', 'exclusive-addons-elementor-pro' ),
				],
			]
		);

		$this->start_controls_tabs( 'tabs_menu_item_style' );

		$this->start_controls_tab(
			'tab_menu_item_normal',
			[
				'label' => __( 'Normal', 'exclusive-addons-elementor-pro' ),
			]
		);

		$this->add_responsive_control(
			'color_menu_item',
			[
				'label'     => __( 'Text Color', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#000000',
				'selectors' => [
					'{{WRAPPER}} .exad-nav-menu__layout-horizontal a.exad-menu-item' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'bg_color_menu_item',
			[
				'label'     => __( 'Background Color', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .exad-nav-menu__layout-horizontal a.exad-menu-item' => 'background-color: {{VALUE}}',
				]
			]
		);

		$this->add_responsive_control(
			'menu_item_border_radius',
			[
				'label'      => __( 'Border Radius', 'exclusive-addons-elementor-pro' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .exad-nav-menu__layout-horizontal a.exad-menu-item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_menu_item_hover',
			[
				'label' => __( 'Hover', 'exclusive-addons-elementor-pro' ),
			]
		);

		$this->add_responsive_control(
			'color_menu_item_hover',
			[
				'label'     => __( 'Text Color', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .exad-nav-menu__layout-horizontal a.exad-menu-item:hover' => 'color: {{VALUE}}'
				]
			]
		);

		$this->add_control(
			'color_menu_item_bg_hover',
			[
				'label'     => __( 'Background Color', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .exad-nav-menu__layout-horizontal a.exad-menu-item:hover'  => 'background-color: {{VALUE}}'
				]
			]
		);

		$this->add_control(
			'exad_nav_border_effect_hover_color',
			[
				'label'     => __( 'Border Effect Color', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#000000',
				'selectors' => [
					'{{WRAPPER}} .exad-nav-menu__layout-horizontal.effect-1 .exad-nav-menu li a.exad-menu-item::before' => 'background: {{VALUE}}',
					'{{WRAPPER}} .exad-nav-menu__layout-horizontal.effect-2 .exad-nav-menu li a.exad-menu-item::before' => 'background: {{VALUE}}',
					'{{WRAPPER}} .exad-nav-menu__layout-horizontal.effect-3 .exad-nav-menu li a.exad-menu-item::before' => 'background: {{VALUE}}',
					'{{WRAPPER}} .exad-nav-menu__layout-horizontal.effect-3 .exad-nav-menu li a.exad-menu-item::after' => 'background: {{VALUE}}',
					'{{WRAPPER}} .exad-nav-menu__layout-horizontal.effect-4 .exad-nav-menu li a.exad-menu-item::before' => 'border-top-color: {{VALUE}}; border-bottom-color: {{VALUE}};',
					'{{WRAPPER}} .exad-nav-menu__layout-horizontal.effect-5 .exad-nav-menu li a.exad-menu-item::before' => 'border-left-color: {{VALUE}}; border-right-color: {{VALUE}};',
					'{{WRAPPER}} .exad-nav-menu__layout-horizontal.effect-6 .exad-nav-menu li a.exad-menu-item::before' => 'background: {{VALUE}}',
				],
			]
		);

		$this->add_responsive_control(
			'exad_nav_border_effect_hover_border_width',
			[
				'label'      => __( 'Border Width', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 5,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 2,
				],
				'selectors' => [
					'{{WRAPPER}} .exad-nav-menu__layout-horizontal.effect-1 .exad-nav-menu li a.exad-menu-item::before' => 'height: {{SIZE}}{{UNIT}}',
					'{{WRAPPER}} .exad-nav-menu__layout-horizontal.effect-2 .exad-nav-menu li a.exad-menu-item::before' => 'height: {{SIZE}}{{UNIT}}',
					'{{WRAPPER}} .exad-nav-menu__layout-horizontal.effect-3 .exad-nav-menu li a.exad-menu-item::before' => 'height: {{SIZE}}{{UNIT}}',
					'{{WRAPPER}} .exad-nav-menu__layout-horizontal.effect-3 .exad-nav-menu li a.exad-menu-item::after' => 'height: {{SIZE}}{{UNIT}}',
					'{{WRAPPER}} .exad-nav-menu__layout-horizontal.effect-4 .exad-nav-menu li a.exad-menu-item::before' => 'border-top-width: {{SIZE}}{{UNIT}}; border-bottom-width: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .exad-nav-menu__layout-horizontal.effect-5 .exad-nav-menu li a.exad-menu-item::before' => 'border-left-width: {{SIZE}}{{UNIT}}; border-right-width: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .exad-nav-menu__layout-horizontal.effect-6 .exad-nav-menu li a.exad-menu-item::before' => 'height: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_responsive_control(
			'menu_item_hover_border_radius',
			[
				'label'      => __( 'Border Radius', 'exclusive-addons-elementor-pro' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .exad-nav-menu__layout-horizontal a.exad-menu-item:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
		);
			
		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_menu_item_active',
			[
				'label' => __( 'Active', 'exclusive-addons-elementor-pro' ),
			]
		);

		$this->add_responsive_control(
			'color_menu_item_active',
			[
				'label'     => __( 'Text Color', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .menu-item.current-menu-item a.exad-menu-item,
					{{WRAPPER}} .menu-item.current-menu-ancestor a.exad-menu-item' => 'color: {{VALUE}}'
				]
			]
		);		

		$this->add_control(
			'background_menu_item_active',
			[
				'label'     => __( 'Background Color', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .menu-item.current-menu-item a.exad-menu-item,
					{{WRAPPER}} .menu-item.current-menu-ancestor a.exad-menu-item' => 'background: {{VALUE}}'
				]
			]
		);		
		
		$this->add_control(
			'exad_nav_border_effect_active_color',
			[
				'label'     => __( 'Border Effect Color', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#000000',
				'selectors' => [
					'{{WRAPPER}} .exad-nav-menu__layout-horizontal.effect-1 .exad-nav-menu li.current-menu-item a.exad-menu-item::before' => 'background: {{VALUE}}',
					'{{WRAPPER}} .exad-nav-menu__layout-horizontal.effect-2 .exad-nav-menu li.current-menu-item a.exad-menu-item::before' => 'background: {{VALUE}}',
					'{{WRAPPER}} .exad-nav-menu__layout-horizontal.effect-3 .exad-nav-menu li.current-menu-item a.exad-menu-item::before' => 'background: {{VALUE}}',
					'{{WRAPPER}} .exad-nav-menu__layout-horizontal.effect-3 .exad-nav-menu li.current-menu-item a.exad-menu-item::after' => 'background: {{VALUE}}',
					'{{WRAPPER}} .exad-nav-menu__layout-horizontal.effect-4 .exad-nav-menu li.current-menu-item a.exad-menu-item::before' => 'border-top: 3px solid {{VALUE}}; border-bottom: 3px solid {{VALUE}};',
					'{{WRAPPER}} .exad-nav-menu__layout-horizontal.effect-5 .exad-nav-menu li.current-menu-item a.exad-menu-item::before' => 'border-left: 3px solid {{VALUE}}; border-right: 3px solid {{VALUE}};',
					'{{WRAPPER}} .exad-nav-menu__layout-horizontal.effect-6 .exad-nav-menu li.current-menu-item a.exad-menu-item::before' => 'background: {{VALUE}}',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_responsive_control(
			'exad_nav_menu_arrow_margin',
			[
				'label'      => __( 'Arrow Margin', 'exclusive-addons-elementor-pro' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'separator'  => 'before',
				'size_units' => [ 'px', '%' ],
				'default'    => [
					'top' => '0',
					'right' => '0',
					'bottom' => '5',
					'left' => '10',
					'unit' => 'px',
					'isLinked' => false,
				],
				'selectors'  => [
					'{{WRAPPER}} .exad-nav-menu .sub-arrow' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Register Nav Menu General Controls.
	 *
	 * @since 1.3.0
	 * @access protected
	 */
	protected function register_dropdown_content_controls() {

		$this->start_controls_section(
			'section_style_dropdown',
			[
				'label' => __( 'Dropdown', 'exclusive-addons-elementor-pro' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'dropdown_description',
			[
				'raw'             => __( '<b>Note:</b> On desktop, below style options will apply to the submenu. On mobile, this will apply to the entire menu.', 'exclusive-addons-elementor-pro' ),
				'type'            => Controls_Manager::RAW_HTML,
				'content_classes' => 'elementor-descriptor'
			]
		);

		$this->start_controls_tabs( 'tabs_dropdown_item_style' );

		$this->start_controls_tab(
			'tab_dropdown_item_normal',
			[
				'label' => __( 'Normal', 'exclusive-addons-elementor-pro' ),
			]
		);

		$this->add_responsive_control(
			'color_dropdown_item',
			[
				'label'     => __( 'Text Color', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#000000',
				'selectors' => [
					'{{WRAPPER}} .slicknav_nav li.exad-creative-menu a, {{WRAPPER}} .slicknav_nav .slicknav_arrow, {{WRAPPER}} .exad-nav-menu__layout-horizontal ul.sub-menu a.exad-sub-menu-item' => 'color: {{VALUE}}'
				]
			]
		);

		$this->add_control(
			'background_color_dropdown_item',
			[
				'label'     => __( 'Background Color', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .slicknav_nav li.exad-creative-menu, {{WRAPPER}} .exad-nav-menu__layout-horizontal ul.sub-menu a.exad-sub-menu-item' => 'background-color: {{VALUE}}'
				]
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_dropdown_item_hover',
			[
				'label' => __( 'Hover', 'exclusive-addons-elementor-pro' ),
			]
		);

		$this->add_responsive_control(
			'color_dropdown_item_hover',
			[
				'label'     => __( 'Text Color', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .slicknav_nav li.exad-creative-menu:hover a, {{WRAPPER}} .slicknav_nav li.exad-creative-menu:hover .slicknav_arrow span, {{WRAPPER}} .exad-nav-menu__layout-horizontal ul.sub-menu a.exad-sub-menu-item:hover' => 'color: {{VALUE}}'
				]
			]
		);

		$this->add_control(
			'background_color_dropdown_item_hover',
			[
				'label'     => __( 'Background Color', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .slicknav_nav li.exad-creative-menu:hover, {{WRAPPER}} .exad-nav-menu__layout-horizontal ul.sub-menu a.exad-sub-menu-item:hover' => 'background-color: {{VALUE}}'
				],
				'separator' => 'after'
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_dropdown_item_active',
			[
				'label' => __( 'Active', 'exclusive-addons-elementor-pro' ),
			]
		);

		$this->add_responsive_control(
			'color_dropdown_item_active',
			[
				'label'     => __( 'Text Color', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .exad-nav-menu__layout-horizontal ul.sub-menu .menu-item.current-menu-item a.exad-sub-menu-item.exad-sub-menu-item-active, {{WRAPPER}} .slicknav_nav ul.sub-menu .menu-item.current-menu-item a.exad-sub-menu-item.exad-sub-menu-item-active, {{WRAPPER}} .slicknav_nav ul.sub-menu .menu-item.current-menu-item .slicknav_arrow span' => 'color: {{VALUE}}'
				]
			]
		);

		$this->add_control(
			'background_color_dropdown_item_active',
			[
				'label'     => __( 'Background Color', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'separator' => 'after',
				'selectors' => [
					'{{WRAPPER}} .exad-nav-menu__layout-horizontal ul.sub-menu .menu-item.current-menu-item a.exad-sub-menu-item.exad-sub-menu-item-active,	
					{{WRAPPER}} .slicknav_nav ul.sub-menu .menu-item.current-menu-item' => 'background-color: {{VALUE}}'
				]
			]
		);

		$this->end_controls_tabs();

		$this->end_controls_tabs();

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'dropdown_typography',
				'separator' => 'before',
				'selector'  => '{{WRAPPER}} .slicknav_nav li.exad-creative-menu a, {{WRAPPER}} .exad-nav-menu__layout-horizontal ul.sub-menu a.exad-sub-menu-item'
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'dropdown_border',
				'selector' => '{{WRAPPER}} nav.exad-nav-menu__layout-horizontal .sub-menu, {{WRAPPER}} .slicknav_nav'
			]
		);

		$this->add_responsive_control(
			'dropdown_border_radius',
			[
				'label'      => __( 'Border Radius', 'exclusive-addons-elementor-pro' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .exad-nav-menu__layout-horizontal ul.sub-menu, {{WRAPPER}} .slicknav_nav'        => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .exad-nav-menu__layout-horizontal .exad-has-submenu > ul.sub-menu li:first-child a.exad-sub-menu-item'        => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} 0 0;',
					'{{WRAPPER}} .exad-nav-menu__layout-horizontal .exad-has-submenu > ul.sub-menu li:last-child a.exad-sub-menu-item'        => 'border-radius: 0 0 {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				]
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'      => 'dropdown_box_shadow',
				'exclude'   => [
					'box_shadow_position',
				],
				'selector'  => '{{WRAPPER}} .exad-nav-menu__layout-horizontal ul.sub-menu, {{WRAPPER}} .slicknav_nav',
				'separator' => 'after'
			]
		);

		$this->add_responsive_control(
			'width_dropdown_item',
			[
				'label'       => __( 'Dropdown Width (px)', 'exclusive-addons-elementor-pro' ),
				'type'        => Controls_Manager::SLIDER,
				'range'       => [
					'px'      => [
						'min' => 0,
						'max' => 500
					]
				],
				'default'     => [
					'size'    => '220',
					'unit'    => 'px'
				],
				'selectors'   => [
					'{{WRAPPER}} .exad-nav-menu__layout-horizontal ul.sub-menu' => 'width: {{SIZE}}{{UNIT}}'
				]
			]
		);

		$this->add_responsive_control(
			'padding_horizontal_dropdown_item',
			[
				'label'      => __( 'Horizontal Padding', 'exclusive-addons-elementor-pro' ),
				'type'       => Controls_Manager::SLIDER,
				'default'    => [
					'size'   => 15,
					'unit'   => 'px'
				],
				'size_units' => [ 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .exad-nav-menu__layout-horizontal ul.sub-menu li a.exad-sub-menu-item, {{WRAPPER}} .slicknav_nav .slicknav_row, {{WRAPPER}} .slicknav_nav li a' => 'padding-left: {{SIZE}}{{UNIT}}; padding-right: {{SIZE}}{{UNIT}}'
				]
			]
		);

		$this->add_responsive_control(
			'padding_vertical_dropdown_item',
			[
				'label'       => __( 'Vertical Padding', 'exclusive-addons-elementor-pro' ),
				'type'        => Controls_Manager::SLIDER,
				'size_units'  => [ 'px' ],
				'default'     => [
					'size'    => 10,
					'unit'    => 'px'
				],
				'range'       => [
					'px'      => [
						'max' => 50
					]
				],
				'selectors'   => [
					'{{WRAPPER}} .exad-nav-menu__layout-horizontal ul.sub-menu li a.exad-sub-menu-item, {{WRAPPER}} .slicknav_nav .slicknav_row, {{WRAPPER}} .slicknav_nav li a' => 'padding-top: {{SIZE}}{{UNIT}}; padding-bottom: {{SIZE}}{{UNIT}}',
				]
			]
		);

		$this->add_responsive_control(
			'distance_from_menu',
			[
				'label'     => __( 'Top Distance', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px'    => [
						'min' => -100,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .exad-nav-menu__layout-horizontal ul.sub-menu' => 'margin-top: {{SIZE}}px;'
				]
			]
		);

		$this->add_control(
			'heading_dropdown_divider',
			[
				'label'     => __( 'Divider', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'dropdown_divider_border',
			[
				'label'       => __( 'Border Style', 'exclusive-addons-elementor-pro' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => 'solid',
				'label_block' => false,
				'options'     => [
					'none'   => __( 'None', 'exclusive-addons-elementor-pro' ),
					'solid'  => __( 'Solid', 'exclusive-addons-elementor-pro' ),
					'double' => __( 'Double', 'exclusive-addons-elementor-pro' ),
					'dotted' => __( 'Dotted', 'exclusive-addons-elementor-pro' ),
					'dashed' => __( 'Dashed', 'exclusive-addons-elementor-pro' )
				],
				'selectors'   => [
					'{{WRAPPER}} .exad-nav-menu__layout-horizontal .sub-menu li.menu-item:not(:last-child)' => 'border-bottom-style: {{VALUE}};',
					'{{WRAPPER}} .slicknav_nav li:not(:first-child)' => 'border-top-style: {{VALUE}};'
				]
			]
		);

		$this->add_control(
			'divider_border_color',
			[
				'label'     => __( 'Border Color', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#cccccc',
				'selectors' => [
					'{{WRAPPER}} .exad-nav-menu__layout-horizontal .sub-menu li.menu-item:not(:last-child)' => 'border-bottom-color: {{VALUE}};',
					'{{WRAPPER}} .slicknav_nav li:not(:first-child)' => 'border-top-color: {{VALUE}};'
				],
				'condition' => [
					'dropdown_divider_border!' => 'none'
				]
			]
		);

		$this->add_control(
			'dropdown_divider_width',
			[
				'label'     => __( 'Border Width', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'max' => 50
					]
				],
				'default'   => [
					'size' => '1',
					'unit' => 'px'
				],
				'selectors' => [
					'{{WRAPPER}} .exad-nav-menu__layout-horizontal .sub-menu li.menu-item:not(:last-child)' => 'border-bottom-width: {{SIZE}}{{UNIT}}',
					'{{WRAPPER}} .slicknav_nav li:not(:first-child)' => 'border-top-width: {{SIZE}}{{UNIT}}'
				],
				'condition' => [
					'dropdown_divider_border!' => 'none'
				]
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'style_toggle',
			[
				'label'     => __( 'Menu Trigger & Close Icon', 'exclusive-addons-elementor-pro' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'dropdown!' => 'none'
				]
			]
		);

		$this->add_control(
			'toggle_padding',
			[
				'label'      => esc_html__( 'Padding', 'exclusive-addons-elementor-pro' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px'],
				'selectors'  => [
					'{{WRAPPER}} .slicknav_btn'=> 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
		);

		$this->add_control(
			'toggle_color',
			[
				'label'     => __( 'Color', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .slicknav_menu .slicknav_icon-bar' => 'background-color: {{VALUE}}'
				]
			]
		);

		$this->add_control(
			'toggle_background_color',
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
				'name' => 'exad_nav_menu_toggle_border',
				'label' => __( 'Border', 'exclusive-addons-elementor-pro' ),
				'selector' => '{{WRAPPER}} .slicknav_btn',
			]
		);

		$this->add_responsive_control(
			'toggle_size',
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
			'toggle_border_radius',
			[
				'label'      => __( 'Border Radius', 'exclusive-addons-elementor-pro' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .slicknav_btn' => 'border-radius: {{SIZE}}{{UNIT}}'
				]
			]
		);

		$this->end_controls_section();

		// $this->start_controls_section(
		// 	'exad_nav_menu_tab_style',
		// 	[
		// 		'label'     => __( 'Menu for Tablet & Mobile', 'exclusive-addons-elementor-pro' ),
		// 		'tab'       => Controls_Manager::TAB_STYLE,
		// 	]
		// );

		// $this->end_controls_section();
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
		
		$args = [
			'echo'        => false,
			'menu'        => $settings['menu'],
			'menu_class'  => 'exad-nav-menu',
			'menu_id'     => 'menu-' . $this->get_nav_menu_index() . '-' . $this->get_id(),
			'fallback_cb' => '__return_empty_string',
			'container'   => '',
			'walker'      => new \Exad_Menu_Walker,
		];

		$menu_html = wp_nav_menu( $args );

		
		$this->add_render_attribute(
			'exad-main-menu',
			'class',
			[
				'exad-nav-menu-wrapper',
				'exad-layout-'.$settings['exad_nav_menu_layout']
			]
		);

		$this->add_render_attribute( 'exad-main-menu', 'class', 'exad-nav-menu-layout' );

		$this->add_render_attribute( 'exad-main-menu', 'class', $settings['exad_nav_menu_layout'] );

		$this->add_render_attribute( 'exad-main-menu', 'data-layout', $settings['exad_nav_menu_layout'] );

		$this->add_render_attribute(
			'exad-nav-menu',
			'class',
			[
				'exad-nav-menu__layout-horizontal',
				$settings['exad_nav_menu_hover_style']
			]
		);

		?>


		<div <?php echo $this->get_render_attribute_string( 'exad-main-menu' ); ?>>
			<nav <?php echo $this->get_render_attribute_string( 'exad-nav-menu' ); ?>><?php echo $menu_html; ?></nav>       
			<div class="exad-mobile-menu"></div>       
		</div>
		<?php
	}
}

