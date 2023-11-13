<?php

namespace Elementor;

use ShopEngine\Widgets\Products;
use ShopEngine_Pro; 
defined('ABSPATH') || exit;


class ShopEngine_Advanced_Coupon extends \ShopEngine\Base\Widget
{

	public function config() {
		return new ShopEngine_Advanced_Coupon_Config();
	}


	protected function register_controls() {

		/*
			------------------------------
			General settings
			------------------------------
		*/
		$this->start_controls_section(
			'shopengine_advanced_coupon_general',
			[
				'label' => esc_html__('General', 'shopengine-pro'),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

        $this->add_control(
			'shopengine_advanced_coupon_title',
			[
				'label'       => esc_html__('Title', 'shopengine-pro'),
				'type'        => Controls_Manager::TEXT,
				'default'     => 'Hurry. Going fast!',
				'label_block' => true,
			]
		);

        $this->add_control(
			'shopengine_advanced_coupon_subtitle',
			[
				'label'       => esc_html__('Sub-Title', 'shopengine-pro'),
				'type'        => Controls_Manager::TEXT,
				'default'     => 'On the range of products.',
				'label_block' => true,
			]
		);

        $this->add_control(
			'shopengine_advanced_coupon_date',
			[
				'label'       => esc_html__('Date', 'shopengine-pro'),
				'type'        => Controls_Manager::TEXT,
				'default'     => '31-Dec-2022',
				'label_block' => true,
			]
		);

		$this->add_control(
			'shopengine_advanced_coupon_discount_seperator',
			[
				'label' => esc_html__( 'Discount', 'shopengine-pro' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'shopengine_advanced_coupon_discount_price_prefix',
			[
				'label'       => esc_html__('Prefix', 'shopengine-pro'),
				'type'        => Controls_Manager::TEXT,
				'default'     => '$',
				'label_block' => true,
			]
		);
		$this->add_control(
			'shopengine_advanced_coupon_discount_price',
			[
				'label'       => esc_html__('Price', 'shopengine-pro'),
				'type'        => Controls_Manager::TEXT,
				'default'     => '10',
				'label_block' => true,
			]
		);
		$this->add_control(
			'shopengine_advanced_coupon_discount_text',
			[
				'label'       => esc_html__('Discount Text', 'shopengine-pro'),
				'type'        => Controls_Manager::TEXT,
				'default'     => 'DISCOUNT',
				'label_block' => true,
			]
		);

		$this->add_control(
			'shopengine_advanced_coupon_button_seperator',
			[
				'label' => esc_html__( 'Button', 'shopengine-pro' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'shopengine_advanced_coupon_sample_code',
			[
				'label'       => esc_html__('Coupon Code', 'shopengine-pro'),
				'type'        => Controls_Manager::TEXT,
				'default'     => 'SAMPLE-CODE',
				'label_block' => true,
			]
		);

		$this->end_controls_section();

        /*
			------------------------------
			Style settings
			------------------------------
		*/

        $this->start_controls_section(
			'shopengine_advanced_coupon_content_section',
			array(
				'label' => esc_html__('Content', 'shopengine-pro'),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_responsive_control(
			'shopengine_advanced_coupon_alignment',
			[
				'label'     => esc_html__('Alignment', 'shopengine-pro'),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => [
					'left'   => [
						'title' => esc_html__('Left', 'shopengine-pro'),
						'icon'  => 'eicon-text-align-left',
					],
					'center' => [
						'title' => esc_html__('Center', 'shopengine-pro'),
						'icon'  => 'eicon-text-align-center',
					],
					'right'  => [
						'title' => esc_html__('Right', 'shopengine-pro'),
						'icon'  => 'eicon-text-align-right',
					]
				],
				'prefix_class' => 'elementor-align-',
				'selectors' => [
					'{{WRAPPER}} .shopengine-advanced-coupon-container'  => 'justify-content: {{VALUE}};',
					'.rtl {{WRAPPER}}.elementor-align-left .shopengine-advanced-coupon-container'  => 'justify-content: start;',
					'.rtl {{WRAPPER}}.elementor-align-right .shopengine-advanced-coupon-container'  => 'justify-content: end;',
				],
			]
		);

        $this->add_control(
			'shopengine_advanced_coupon_content_bg',
			[
				'label'     => esc_html__('Background', 'shopengine-pro'),
				'type'      => Controls_Manager::COLOR,
				'alpha'		=> false,
				'default'   => '#F53851',
				'selectors' => [
					'{{WRAPPER}} .shopengine-advanced-coupon-container-inner' => 'background: {{VALUE}};',
				]
			]
		);

		$this->end_controls_section();

		//Title & SubTitle Section
        $this->start_controls_section(
			'shopengine_advanced_coupon_title_section',
			array(
				'label' => esc_html__('Title & SubTitle', 'shopengine-pro'),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);
        
        $this->add_control(
			'shopengine_advanced_coupon_title_color',
			[
				'label'     => esc_html__('Color', 'shopengine-pro'),
				'type'      => Controls_Manager::COLOR,
				'alpha'		=> false,
				'default'   => '#FFFFFF',
				'selectors' => [
					'{{WRAPPER}} .shopengine-advanced-coupon-container-inner .shopengine-advanced-coupon-body .shopengine-advanced-coupon-content h5' => 'color: {{VALUE}};',
				]
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'           => 'shopengine_advanced_coupon_title_typography',
				'label'          => esc_html__('Typography', 'shopengine-pro'),
				'selector'       => '{{WRAPPER}} .shopengine-advanced-coupon-container-inner .shopengine-advanced-coupon-body .shopengine-advanced-coupon-content h5',
				'exclude'        => ['font_family', 'text_decoration', 'font_style', 'line_height'],
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
						'default' => '700',
					],
					'text_transform' => [
						'default' => 'none',
					],
					'letter_spacing' => [
						'default' => [
							'size' => '0',
						]
					],
					'word_spacing' => [
						'default' => [
							'size' => '',
						]
					],
				],
			]
		);

		$this->add_control(
			'shopengine_advanced_coupon_subtitle_font_weight',
			 [
			'label' => esc_html__('Subtitle Font Weight', 'shopengine-pro'),
			'type' => Controls_Manager::SELECT,
			'default' => '400',
			'options' => [
				'100' => '100',
				'200' => '200',
				'300' => '300',
				'400' => '400',
				'500' => '500',
				'600' => '600',
				'700' => '700',
				'800' => '800',
				'900' => '900',
				'' => esc_html__( 'Default', 'shopengine-pro' ),
				'normal' => esc_html__( 'Normal', 'shopengine-pro' ),
				'bold' => esc_html__( 'Bold', 'shopengine-pro' ),
			],
			'selectors' => [
				'{{WRAPPER}} .shopengine-advanced-coupon-container-inner .shopengine-advanced-coupon-body .shopengine-advanced-coupon-content h5 p' => 'font-weight: {{VALUE}};',
			]
		]
	);

        $this->end_controls_section();

		//Icon Section
        $this->start_controls_section(
			'shopengine_advanced_coupon_icon_section',
			array(
				'label' => esc_html__('Icon', 'shopengine-pro'),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);
        
		$this->add_control(
			'shopengine_advanced_coupon_icon_bg',
			[
				'label'     => esc_html__('icon Background', 'shopengine-pro'),
				'type'      => Controls_Manager::COLOR,
				'alpha'		=> false,
				'default'   => '#D61E37',
				'selectors' => [
				]
			]
		);

		$this->add_control(
			'shopengine_advanced_coupon_icon_size',
			[
				'label'      => esc_html__('Icon Size', 'shopengine-pro'),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range'      => [
					'px' => [
						'min'  => 0,
						'max'  => 40,
						'step' => 1,
					],
				],
                'default'    => [
					'unit' => 'px',
					'size' => 18,
				],
			]
		);

        $this->end_controls_section();

		//discount price section
		$this->start_controls_section(
			'shopengine_advanced_coupon_discount_section',
			array(
				'label' => esc_html__('Discount Price', 'shopengine-pro'),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'shopengine_advanced_coupon_discount_color',
			[
				'label'     => esc_html__('Color', 'shopengine-pro'),
				'type'      => Controls_Manager::COLOR,
				'alpha'		=> false,
				'default'   => '#FFFFFF',
				'selectors' => [
					'{{WRAPPER}} .shopengine-advanced-coupon-container-inner .shopengine-advanced-coupon-discount h1' => 'color: {{VALUE}};',
					'{{WRAPPER}} .shopengine-advanced-coupon-container-inner .shopengine-advanced-coupon-discount .advanced-coupon-discount' => 'color: {{VALUE}};'
				]
			]
		);

		$this->end_controls_section();

		//date section
		$this->start_controls_section(
			'shopengine_advanced_coupon_date_section',
			array(
				'label' => esc_html__('Date', 'shopengine-pro'),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'shopengine_advanced_coupon_date_color',
			[
				'label'     => esc_html__('Date Color', 'shopengine-pro'),
				'type'      => Controls_Manager::COLOR,
				'alpha'		=> false,
				'default'   => '#FFFFFF',
				'selectors' => [
					'{{WRAPPER}} .shopengine-advanced-coupon-container-inner .shopengine-advanced-coupon-date p' => 'color: {{VALUE}};',
				]
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'           => 'shopengine_advanced_coupon_date_typography',
				'label'          => esc_html__('Typography', 'shopengine-pro'),
				'selector'       => '{{WRAPPER}} .shopengine-advanced-coupon-container-inner .shopengine-advanced-coupon-date p',
				'exclude'        => ['font_family', 'text_decoration', 'font_style', 'line_height'],
				'fields_options' => [
					'typography'     => [
						'default' => 'custom',
					],
					'font_size'      => [
						'label'      => esc_html__('Font Size (px)', 'shopengine-pro'),
						'size_units' => ['px'],
						'default'    => [
							'size' => '12',
							'unit' => 'px'
						]
					],
					'font_weight'    => [
						'default' => '400',
					],
					'text_transform' => [
						'default' => 'none',
					],
					'letter_spacing' => [
						'default' => [
							'size' => '0',
						]
					],
					'word_spacing' => [
						'default' => [
							'size' => '',
						]
					],
				],
			]
		);

		$this->end_controls_section();

		//Button Section
        $this->start_controls_section(
			'shopengine_advanced_coupon_button_section',
			array(
				'label' => esc_html__('Button', 'shopengine-pro'),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'shopengine_advanced_coupon_buttons_color',
			[
				'label'     => esc_html__('color', 'shopengine-pro'),
				'type'      => Controls_Manager::COLOR,
				'alpha'		=> false,
				'default'   => '#FFFFFF',
				'selectors' => [
					'{{WRAPPER}} .shopengine-advanced-coupon-button button, {{WRAPPER}} .shopengine-advanced-coupon-footer button' => 'color: {{VALUE}} !important;',
				]
			]
		);

		$this->add_control(
			'shopengine_advanced_coupon_buttons_bg',
			[
				'label'     => esc_html__('Background', 'shopengine-pro'),
				'type'      => Controls_Manager::COLOR,
				'alpha'		=> false,
				'default'   => '#D61E37',
				'selectors' => [
					'{{WRAPPER}} .shopengine-advanced-coupon-button button, {{WRAPPER}} .shopengine-advanced-coupon-footer button' => 'background: {{VALUE}} !important;',
					'{{WRAPPER}} .shopengine-advanced-coupon-footer button:before' => 'border-color: transparent transparent {{VALUE}} transparent;',
					'{{WRAPPER}} .shopengine-advanced-coupon-footer button:after' => 'border-color: transparent transparent transparent {{VALUE}};',
				]
			]
		);

		$this->end_controls_section();
	}



	protected function screen() {

		$settings = $this->get_settings_for_display();

		$tpl = Products::instance()->get_widget_template($this->get_name(), 'default', \ShopEngine_Pro::widget_dir());

		include $tpl;
	}
}