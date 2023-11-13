<?php

namespace Elementor;

use ShopEngine\Widgets\Products;

defined('ABSPATH') || exit;

class ShopEngine_Product_Size_Charts extends \ShopEngine\Base\Widget {

    public function config() {
        return new ShopEngine_Product_Size_Charts_Config();
    }

    protected function register_controls() {
        
        $this->start_controls_section(
            'shopengine_product_size_charts_content_section',
            [
                'label' => esc_html__('Size Charts Settings', 'shopengine-pro'),
                'tab'   => Controls_Manager::TAB_CONTENT
            ]
        );

        $this->add_control(
			'shopengine_product_size_type',
			[
				'label' => esc_html__( 'View chart as', 'shopengine-pro' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'normal' => esc_html__( 'Normal', 'shopengine-pro' ),
					'modal' => esc_html__( 'Modal', 'shopengine-pro' )
				],
				'default' => 'modal',
			]
		);

        $this->add_control(
            'shopengine_product_size_charts_button_text',
            [
                'label'   => esc_html__('Button Label', 'shopengine-pro'),
                'type'    => Controls_Manager::TEXT,
                'default' => 'View Size Chart',
                'condition'	=> [
					'shopengine_product_size_type'	=> 'modal'
				],
            ]
        );
        
        $this->add_control(
            'shopengine_product_size_charts_title_text',
            [
                'label'   => esc_html__('Chart Heading', 'shopengine-pro'),
                'type'    => Controls_Manager::TEXT,
                'default' => 'Product size char',
                'condition'	=> [
					'shopengine_product_size_type'	=> 'normal'
				],
            ]
        );

        $this->end_controls_section();

        /**
         * 
         * 
         *
         *  Size chart normal style section start 
         */ 
        $this->start_controls_section(
            'shopengine_product_size_charts_normal_style',
            [
                'label' => esc_html__('Size Chart Style', 'shopengine-pro'),
                'tab'   => Controls_Manager::TAB_STYLE,
                'condition'	=> [
					'shopengine_product_size_type'	=> 'normal'
				],
            ]
        );

        $this->add_control(
			'shopengine_product_size_chart_alignment',
			[
				'label'     => esc_html__('Alignment', 'shopengine-pro'),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => [
					'start'   => [
						'description' => esc_html__('Left', 'shopengine-pro'),
						'icon'        => 'eicon-text-align-left',
					],
					'center' => [
						'description' => esc_html__('Center', 'shopengine-pro'),
						'icon'        => 'eicon-text-align-center',
					],
					'end'  => [
						'description' => esc_html__('Right', 'shopengine-pro'),
						'icon'        => 'eicon-text-align-right',
					],
				],
                'prefix_class' => 'elementor-align-',
				'selectors' => [
					'{{WRAPPER}} .shopengine-product-size-chart-body' => 'display: flex; flex-direction: column; align-items: {{VALUE}};',
					'.rtl {{WRAPPER}}.elementor-align-left .shopengine-product-size-chart-body' => 'display: flex; flex-direction: column; align-items: right;',
					'.rtl {{WRAPPER}}.elementor-align-right .shopengine-product-size-chart-body' => 'display: flex; flex-direction: column; align-items: left;',
				],
			]
		);

        $this->add_control(
            'shopengine_product_size_charts_heading_color',
            [
                'label'     => esc_html__('Heading Color', 'shopengine-pro'),
                'type'      => Controls_Manager::COLOR,
                'alpha'     => false,
                'default'   => '#101010',
                'selectors' => [
                    '{{WRAPPER}} .shopengine-product-size-chart-heading' => 'color: {{VALUE}};'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'           => 'shopengine_product_size_chart_heading_typography',
                'label'          => esc_html__('Title Typography', 'shopengine-pro'),
                'selector'       => '{{WRAPPER}} .shopengine-product-size-chart-heading',
                'exclude'        => ['text_decoration', 'text_transform', 'font_style', 'word_spacing', 'letter_spacing'],
                'fields_options' => [
                    'typography'     => [
                        'default' => 'custom'
                    ],
                    'font_weight'    => [
                        'default' => '400'
                    ],
                    'font_size'      => [
                        'label'      => esc_html__('Font Size (px)', 'shopengine-pro'),
                        'default'    => [
                            'size' => '18',
                            'unit' => 'px'
                        ],
                        'size_units' => ['px']
                    ],
                    'text_transform' => [
                        'default' => 'uppercase'
                    ],
                    'line_height'    => [
                        'label'          => esc_html__('Line Height (px)', 'shopengine-pro'),
                        'default'        => [
                            'size' => '18',
                            'unit' => 'px'
                        ],
                        'size_units'     => ['px']
                    ]
                ]
            ]
        );

        $this->add_control(
            'shopengine_product_size_chart_heading_margin',
            [
                'label'      => esc_html__('Heading margin (px)', 'shopengine-pro'),
                'type'       => Controls_Manager::DIMENSIONS,
                'default'    => [
                    'top'      => '0',
                    'right'    => '0',
                    'bottom'   => '10',
                    'left'     => '0',
                    'unit'     => 'px',
                    'isLinked' => true
                ],
                'size_units' => ['px'],
                'selectors'  => [
                    '{{WRAPPER}} .shopengine-product-size-chart-heading' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '.rtl {{WRAPPER}} .shopengine-product-size-chart-heading' => 'margin: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
                ]
            ]
        );

        $this->add_control(
			'shopengine_product_size_charts_divider',
			[
				'type' => Controls_Manager::DIVIDER,
			]
		);

        $this->add_responsive_control (
            'shopengine_product_size_charts_image_width',
            [
                'label'      => esc_html__('Image width (px)', 'shopengine-pro'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range'      => [
                    'px' => [
                        'min'  => 0,
                        'max'  => 1000,
                        'step' => 1
                    ]
                ],
                'selectors'  => [
                    '{{WRAPPER}} .shopengine-product-size-chart-img, {{WRAPPER}} .shopengine-product-size-chart-img img' => 'width: {{SIZE}}{{UNIT}}',
                ]
            ]
        );

        $this->add_control(
            'shopengine_product_size_charts_image_padding',
            [
                'label'      => esc_html__('Image padding (px)', 'shopengine-pro'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px'],
                'selectors'  => [
                    '{{WRAPPER}} .shopengine-product-size-chart-img' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '.rtl {{WRAPPER}} .shopengine-product-size-chart-img' => 'padding: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
                ]
            ]
        );

        $this->add_control (
            'shopengine_product_size_charts_image_radius',
            [
                'label'      => esc_html__('Image border radius (px)', 'shopengine-pro'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range'      => [
                    'px' => [
                        'min'  => 0,
                        'max'  => 1000,
                        'step' => 1
                    ]
                ],
                'selectors'  => [
                    '{{WRAPPER}} .shopengine-product-size-chart-img, {{WRAPPER}} .shopengine-product-size-chart-img img' => 'border-radius: {{SIZE}}{{UNIT}}',
                ]
            ]
        );

        

        $this->end_controls_section();
        //Size chart normal style section end

        $this->start_controls_section(
            'shopengine_product_size_charts_button_style',
            [
                'label' => esc_html__('Size Charts Button', 'shopengine-pro'),
                'tab'   => Controls_Manager::TAB_STYLE,
                'condition'	=> [
					'shopengine_product_size_type'	=> 'modal'
				],
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'           => 'shopengine_product_size_charts_typography',
                'label'          => esc_html__('Typography', 'shopengine-pro'),
                'selector'       => '{{WRAPPER}} .shopengine-product-size-chart-body .shopengine-product-size-chart-button',
                'exclude'        => ['text_decoration', 'text_transform', 'font_style', 'word_spacing', 'letter_spacing', 'line_height'],
                'fields_options' => [
                    'typography'     => [
                        'default' => 'custom'
                    ],
                    'font_weight'    => [
                        'default' => '600'
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
                        'default' => 'uppercase'
                    ],
                    'line_height'    => [
                        'label'          => esc_html__('Line Height (px)', 'shopengine-pro'),
                        'default'        => [
                            'size' => '18',
                            'unit' => 'px'
                        ],
                        'size_units'     => ['px'],
                        'tablet_default' => [
                            'unit' => 'px'
                        ],
                        'mobile_default' => [
                            'unit' => 'px'
                        ],
                        'selectors'      => [
                            '{{WRAPPER}} .shopengine-product-size-chart-body .shopengine-product-size-chart-button' => 'line-height: {{SIZE}}{{UNIT}} !important;'
                        ]
                    ]
                ]
            ]
        );

        $this->start_controls_tabs('shopengine_product_size_charts_style_tabs');

        $this->start_controls_tab('shopengine_product_size_charts_style_normal',
            [
                'label' => esc_html__('Normal', 'shopengine-pro')
            ]
        );

        $this->add_control(
            'shopengine_product_size_charts_text_color_normal',
            [
                'label'     => esc_html__('Color', 'shopengine-pro'),
                'type'      => Controls_Manager::COLOR,
                'alpha'     => false,
                'default'   => '#FFFFFF',
                'selectors' => [
                    '{{WRAPPER}} .shopengine-product-size-chart-body .shopengine-product-size-chart-button' => 'color: {{VALUE}};'
                ]
            ]
        );

        $this->add_control(
            'shopengine_product_size_charts_bg_color_normal',
            [
                'label'     => esc_html__('Background Color', 'shopengine-pro'),
                'type'      => Controls_Manager::COLOR,
                'alpha'     => false,
                'default'   => '#101010',
                'selectors' => [
                    '{{WRAPPER}} .shopengine-product-size-chart-body .shopengine-product-size-chart-button' => 'background-color: {{VALUE}} !important;'
                ]
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab('shopengine_product_size_charts_style_hover',
            [
                'label' => esc_html__('Hover', 'shopengine-pro')
            ]
        );

        $this->add_control(
            'shopengine_product_size_charts_text_color_hover',
            [
                'label'     => esc_html__('Color', 'shopengine-pro'),
                'type'      => Controls_Manager::COLOR,
                'alpha'     => false,
                'default'   => '#FFFFFF',
                'selectors' => [
                    '{{WRAPPER}} .shopengine-product-size-chart-body .shopengine-product-size-chart-button:hover' => 'color: {{VALUE}};'
                ]
            ]
        );

        $this->add_control(
            'shopengine_product_size_charts_bg_color_hover',
            [
                'label'     => esc_html__('Background Color', 'shopengine-pro'),
                'type'      => Controls_Manager::COLOR,
                'alpha'     => false,
                'default'   => '#312b2b',
                'selectors' => [
                    '{{WRAPPER}} .shopengine-product-size-chart-body .shopengine-product-size-chart-button:hover' => 'background-color: {{VALUE}} !important;'
                ]
            ]
        );

        $this->add_control(
            'shopengine_product_size_charts_border_color_hover',
            [
                'label'     => esc_html__('Border Color', 'shopengine-pro'),
                'type'      => Controls_Manager::COLOR,
                'alpha'     => false,
                'default'   => '#312b2b',
                'selectors' => [
                    '{{WRAPPER}} .shopengine-product-size-chart-body .shopengine-product-size-chart-button:hover' => 'border-color: {{VALUE}};'
                ]
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'           => 'shopengine_product_size_charts_border',
                'selector'       => '{{WRAPPER}} .shopengine-product-size-chart-body .shopengine-product-size-chart-button',
                'size_units'     => ['px'],
                'fields_options' => [
                    'border' => [
                        'default' => 'solid'
                    ],
                    'width'  => [
                        'default' => [
                            'top'      => '1',
                            'right'    => '1',
                            'bottom'   => '1',
                            'left'     => '1',
                            'isLinked' => true
                        ],
                        'selectors' => [
                            '{{WRAPPER}} .shopengine-product-size-chart-body ' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                            '.rtl {{WRAPPER}} .shopengine-product-size-chart-body .shopengine-product-size-chart-button ' => 'border-width: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
                        ],
                    ],
                    'color'  => [
                        'default' => '#101010',
                        'alpha'   => false
                    ]
                ],
                'separator'      => 'before'
            ]
        );

        $this->add_control(
            'shopengine_product_size_charts_border_radius',
            [
                'label'      => esc_html__('Border Radius (px)', 'shopengine-pro'),
                'type'       => Controls_Manager::DIMENSIONS,
                'default'    => [
                    'top'      => '5',
                    'right'    => '5',
                    'bottom'   => '5',
                    'left'     => '5',
                    'unit'     => 'px',
                    'isLinked' => true
                ],
                'size_units' => ['px'],
                'selectors'  => [
                    '{{WRAPPER}} .shopengine-product-size-chart-body .shopengine-product-size-chart-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '.rtl {{WRAPPER}} .shopengine-product-size-chart-body .shopengine-product-size-chart-button' => 'border-radius: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'shopengine_product_size_charts_padding',
            [
                'label'      => esc_html__('Padding (px)', 'shopengine-pro'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px'],
                'default'    => [
                    'top'      => '12',
                    'right'    => '25',
                    'bottom'   => '12',
                    'left'     => '25',
                    'unit'     => 'px',
                    'isLinked' => false
                ],
                'selectors'  => [
                    '{{WRAPPER}} .shopengine-product-size-chart-body .shopengine-product-size-chart-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                    '.rtl {{WRAPPER}} .shopengine-product-size-chart-body .shopengine-product-size-chart-button' => 'padding: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}} !important;',
                ],
                'separator'  => 'before'
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'shopengine_product_size_charts_content_style_section',
            [
                'label' => esc_html__('Size Charts Popup', 'shopengine-pro'),
                'tab'   => Controls_Manager::TAB_STYLE,
                'condition'	=> [
					'shopengine_product_size_type'	=> 'modal'
				],
            ]
        );

        $this->add_control(
            'shopengine_product_size_charts_content_border_radius',
            [
                'label'      => esc_html__('Border Radius (px)', 'shopengine-pro'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range'      => [
                    'px' => [
                        'min'  => 0,
                        'max'  => 100,
                        'step' => 1
                    ],
                    '%'  => [
                        'min'  => 0,
                        'max'  => 100,
                        'step' => 1
                    ]
                ],
                'selectors'  => [
                    '.shopengine-product-size-chart .shopengine-product-size-chart-contant'     => 'border-radius: {{SIZE}}{{UNIT}}',
                    '.shopengine-product-size-chart .shopengine-product-size-chart-contant img' => 'border-radius: {{SIZE}}{{UNIT}}'
                ]
            ]
        );

        $this->add_responsive_control(
            'shopengine_product_size_charts_content_padding',
            [
                'label'      => esc_html__('Padding (px)', 'shopengine-pro'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px'],
                'default'    => [
                    'top'      => '10',
                    'right'    => '10',
                    'bottom'   => '10',
                    'left'     => '10',
                    'unit'     => 'px',
                    'isLinked' => false
                ],
                'selectors'  => [
                    '{{WRAPPER}} .shopengine-product-size-chart .shopengine-product-size-chart-contant' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                    '.rtl {{WRAPPER}} .shopengine-product-size-chart .shopengine-product-size-chart-contant' => 'padding: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}} !important;',
                ]
            ]
        );

        $this->add_control(
            'shopengine_product_size_charts_content_background_color',
            [
                'label'     => esc_html__('Background Color', 'shopengine-pro'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#ffffff',
                'alpha'     => false,
                'selectors' => [
                    '{{WRAPPER}} .shopengine-product-size-chart .shopengine-product-size-chart-contant' => 'background-color: {{VALUE}}',
                ]
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
