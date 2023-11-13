<?php

namespace Elementor;

use ShopEngine\Core\Template_Cpt;
use ShopEngine\Widgets\Products;

defined('ABSPATH') || exit;


class ShopEngine_Thankyou_Order_Details extends \ShopEngine\Base\Widget
{

	public function config()
    {
        return new ShopEngine_Thankyou_Order_Details_Config();
    }


	protected function register_controls() {

        // Style Tab - Table Common
        $this->start_controls_section(
            'shopengine_thankyou_order_details_table_common_section',
            [
                'label' => esc_html__('Table Common', 'shopengine-pro'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

		$this->add_control(
			'shopengine_thankyou_order_details_table_link_heading',
			[
				'label'		=> esc_html__( 'Table Links', 'shopengine-pro' ),
				'type'		=> Controls_Manager::HEADING,
			]
		);

		$this->add_control(
			'shopengine_thankyou_order_details_table_link_color',
			[
				'label'     => esc_html__('Link Color', 'shopengine-pro'),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#4169E1',
				'alpha'     => false,
				'selectors' => [
					'{{WRAPPER}} .shopengine-thankyou-order-details table a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'shopengine_thankyou_order_details_table_link_hover_color',
			[
				'label'     => esc_html__('Link Hover Color', 'shopengine-pro'),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#E65093',
				'alpha'     => false,
				'selectors' => [
					'{{WRAPPER}} .shopengine-thankyou-order-details table a:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'shopengine_thankyou_order_details_table_row_heading',
			[
				'label'		=> esc_html__( 'Table Row', 'shopengine-pro' ),
				'type'		=> Controls_Manager::HEADING,
                'separator'	=> 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'           	=> 'shopengine_thankyou_order_details_table_row_border',
				'label'          	=> esc_html__('Border', 'shopengine-pro'),
				'fields_options'	=> [
					'border' => [
						'default' => 'solid',
					],
					'width'  => [
						'label'	=> esc_html__('Width (px)', 'shopengine-pro'),
						'size_units' => ['px'],
						'default' => [
							'top'      => '1',
							'right'    => '1',
							'bottom'   => '1',
							'left'     => '1',
							'isLinked' => true,
						],
						'selectors'  => [
							'{{WRAPPER}} .shopengine-thankyou-order-details table tr' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
							'.rtl {{WRAPPER}} .shopengine-thankyou-order-details table tr' => 'border-width: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
						],
					],
					'color'  => [
						'default' => '#F2F2F2'
					]
				],
				'selector'     		=> '{{WRAPPER}} .shopengine-thankyou-order-details table tr',
			]
		);

		$this->add_responsive_control(
			'shopengine_thankyou_order_details_table_row_padding',
			[
				'label'      => esc_html__('Padding (px)', 'shopengine-pro'),
				'type'       => Controls_Manager::DIMENSIONS,
				'default'    => [
					'top'      => '15',
					'right'    => '20',
					'bottom'   => '15',
					'left'     => '20',
					'unit'     => 'px',
					'isLinked' => false,
				],
				'size_units' => ['px'],
				'selectors'  => [
					'{{WRAPPER}} .shopengine-thankyou-order-details table tr :is(th, td)' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.rtl {{WRAPPER}} .shopengine-thankyou-order-details table tr :is(th, td)' => 'padding: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};'
				],
				'separator'	=> 'before',
			]
		);

        $this->end_controls_section();

        // Style Tab - Table
        $this->start_controls_section(
            'shopengine_thankyou_order_details_table_data_section',
            [
                'label' => esc_html__('Table Data', 'shopengine-pro'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

		$this->add_control(
			'shopengine_thankyou_order_details_table_header_heading',
			[
				'label'		=> esc_html__( 'Table Header', 'shopengine-pro' ),
				'type'		=> Controls_Manager::HEADING,
                'separator'	=> 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'           => 'shopengine_thankyou_order_details_table_header_typography',
				'label'          => esc_html__('Typography', 'shopengine-pro'),
				'selector'       => '{{WRAPPER}} .shopengine-thankyou-order-details table thead tr th',
				'exclude'        => ['font_family', 'letter_spacing', 'text_decoration', 'font_style'],
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
						'default' => '600',
					],
					'text_transform' => [
						'default' => 'uppercase',
					],
					'line_height'    => [
						'label'      => esc_html__('Line Height (px)', 'shopengine-pro'),
						'default'    => [
							'size' => '20',
							'unit' => 'px',
						],
						'size_units' => ['px'],
						'tablet_default' => [
							'unit' => 'px',
						],
						'mobile_default' => [
							'unit' => 'px',
						],
					],
				],
			)
		);

        $this->add_control(
            'shopengine_thankyou_order_details_table_header_color',
            [
                'label' => esc_html__( 'Color', 'shopengine-pro' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#3A3A3A',
				'alpha'     => false,
                'selectors' => [
                    '{{WRAPPER}} .shopengine-thankyou-order-details table thead th' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'shopengine_thankyou_order_details_table_header_bg_color',
            [
                'label' => esc_html__( 'Background Color', 'shopengine-pro' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#f9f9f9',
				'alpha'     => false,
                'selectors' => [
                    '{{WRAPPER}} .shopengine-thankyou-order-details table thead tr' => 'background-color: {{VALUE}};',
                ],
            ]
        );

		$this->add_control(
			'shopengine_thankyou_order_details_table_body_heading',
			[
				'label'		=> esc_html__( 'Table Body', 'shopengine-pro' ),
				'type'		=> Controls_Manager::HEADING,
                'separator'	=> 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'           => 'shopengine_thankyou_order_details_table_body_typography',
				'label'          => esc_html__('Typography', 'shopengine-pro'),
				'selector'       => '{{WRAPPER}} .shopengine-thankyou-order-details table tbody :is(tr, th, td, span, .amount)',
				'exclude'        => ['font_family', 'letter_spacing', 'text_decoration', 'font_style'],
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
						'default' => '',
					],
					'line_height'    => [
						'label'      => esc_html__('Line Height (px)', 'shopengine-pro'),
						'default'    => [
							'size' => '20',
							'unit' => 'px',
						],
						'size_units' => ['px'],
						'tablet_default' => [
							'unit' => 'px',
						],
						'mobile_default' => [
							'unit' => 'px',
						],
					],
				],
			)
		);

        $this->start_controls_tabs('shopengine_thankyou_order_details_table_body_tabs');

        $this->start_controls_tab('shopengine_thankyou_order_details_table_body_normal_tab',
            [
                'label' => esc_html__('Normal', 'shopengine-pro'),
            ]
        );

        $this->add_control(
            'shopengine_thankyou_order_details_table_body_color',
            [
                'label' => esc_html__( 'Color', 'shopengine-pro' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#3A3A3A',
				'alpha'     => false,
                'selectors' => [
					'{{WRAPPER}} .shopengine-thankyou-order-details table tbody tr:nth-child(odd) :is(th, td, span, .amount)'	=> 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'shopengine_thankyou_order_details_table_body_bg_color',
            [
                'label' => esc_html__( 'Background Color', 'shopengine-pro' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#FFFFFF',
				'alpha'     => false,
                'selectors' => [
					'{{WRAPPER}} .shopengine-thankyou-order-details table tbody tr:nth-child(odd)' => 'background: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab('shopengine_thankyou_order_details_table_body_striped_tab',
            [
                'label' => esc_html__('Striped', 'shopengine-pro'),
            ]
        );

        $this->add_control(
            'shopengine_thankyou_order_details_table_body_striped_color',
            [
                'label' => esc_html__( 'Color', 'shopengine-pro' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#3A3A3A',
				'alpha'     => false,
                'selectors' => [
                    '{{WRAPPER}} .shopengine-thankyou-order-details table tbody tr:nth-child(even) :is(th, td, span, .amount)' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'shopengine_thankyou_order_details_table_body_striped_bg_color',
            [
                'label' => esc_html__( 'Background Color', 'shopengine-pro' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#F9F9F9',
                'selectors' => [
					'{{WRAPPER}} .shopengine-thankyou-order-details table tbody tr:nth-child(even)' => 'background: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

		$this->add_control(
			'shopengine_thankyou_order_details_table_footer_heading',
			[
				'label'		=> esc_html__( 'Table Footer', 'shopengine-pro' ),
				'type'		=> Controls_Manager::HEADING,
                'separator'	=> 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'           => 'shopengine_thankyou_order_details_table_footer_typography',
				'label'          => esc_html__('Typography', 'shopengine-pro'),
				'selector'       => '{{WRAPPER}} .shopengine-thankyou-order-details table tfoot :is(tr, th, td, span, .amount)',
				'exclude'        => ['font_family', 'letter_spacing', 'text_decoration', 'font_style'],
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
						'default' => '',
					],
					'line_height'    => [
						'label'      => esc_html__('Line Height (px)', 'shopengine-pro'),
						'default'    => [
							'size' => '20',
							'unit' => 'px',
						],
						'size_units' => ['px'],
						'tablet_default' => [
							'unit' => 'px',
						],
						'mobile_default' => [
							'unit' => 'px',
						],
					],
				],
			)
		);

        $this->start_controls_tabs('shopengine_thankyou_order_details_table_footer_tabs');

        $this->start_controls_tab('shopengine_thankyou_order_details_table_footer_normal_tab',
            [
                'label' => esc_html__('Normal', 'shopengine-pro'),
            ]
        );

        $this->add_control(
            'shopengine_thankyou_order_details_table_footer_color',
            [
                'label' => esc_html__( 'Color', 'shopengine-pro' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#3A3A3A',
				'alpha'     => false,
                'selectors' => [
					'{{WRAPPER}} .shopengine-thankyou-order-details table tfoot tr:nth-child(odd) :is(th, td, span, .amount)'	=> 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'shopengine_thankyou_order_details_table_footer_bg_color',
            [
                'label' => esc_html__( 'Background Color', 'shopengine-pro' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#F9F9F9',
				'alpha'     => false,
                'selectors' => [
					'{{WRAPPER}} .shopengine-thankyou-order-details table tfoot tr:nth-child(odd)' => 'background: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab('shopengine_thankyou_order_details_table_footer_striped_tab',
            [
                'label' => esc_html__('Striped', 'shopengine-pro'),
            ]
        );

        $this->add_control(
            'shopengine_thankyou_order_details_table_footer_striped_color',
            [
                'label' => esc_html__( 'Color', 'shopengine-pro' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#3A3A3A',
				'alpha'     => false,
                'selectors' => [
                    '{{WRAPPER}} .shopengine-thankyou-order-details table tfoot tr:nth-child(even) :is(th, td, span, .amount)' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'shopengine_thankyou_order_details_table_footer_striped_bg_color',
            [
                'label' => esc_html__( 'Background Color', 'shopengine-pro' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#FFFFFF',
				'alpha'     => false,
                'selectors' => [
					'{{WRAPPER}} .shopengine-thankyou-order-details table tfoot tr:nth-child(even)' => 'background: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();

		// Style Tab - Global Font
		$this->start_controls_section(
			'shopengine_thankyou_order_details_global_font_section',
			[
				'label' => esc_html__('Global Font', 'shopengine-pro'),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'shopengine_thankyou_order_details_font_family',
			[
				'label'       => esc_html__('Font Family', 'shopengine-pro'),
				'description' => esc_html__('This font family is set for this specific widget.', 'shopengine-pro'),
				'type'        => Controls_Manager::FONT,
				'selectors'   => [
					'{{WRAPPER}} .shopengine-thankyou-order-details :is(h2, .woocommerce-order-details__title)'     => 'font-family: {{VALUE}};',
					'{{WRAPPER}} .shopengine-thankyou-order-details table :is(tr, th, td, span, .amount, a)'        => 'font-family: {{VALUE}};',
				],
			]
		);
	}


	protected function screen() {

		$settings = $this->get_settings_for_display();

		$post_type = get_post_type();

		$order_id = $this->get_the_order_id();

		if($post_type == Template_Cpt::TYPE && $order_id == 0 ) {
            // get a order to show in editor mode
            $orders = \ShopEngine\Widgets\Products::instance()->get_a_order_id();

            if ( !empty( $orders[0] ) ) {
                $order_id = $orders[0]->get_id();
            }
            else {
                ?>
                <div class="shopengine shopengine-editor-alert shopengine-editor-alert-warning">
                    <?php echo esc_html__('No order details found.', 'shopengine-pro'); ?>
                </div>
                <?php

                return;
            }
		}

        $tpl = Products::instance()->get_widget_template($this->get_name(), 'default', \ShopEngine_Pro::widget_dir());

        include $tpl;
	}


	private function get_the_order_id() {

		global $wp;

		//todo- should we return the last order id for editor???

		return isset($wp->query_vars['order-received']) ? $wp->query_vars['order-received'] : 0;
	}
}
