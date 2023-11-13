<?php

namespace Elementor;

use ShopEngine\Core\Template_Cpt;
use ShopEngine\Widgets\Products;

defined('ABSPATH') || exit;


class ShopEngine_Thankyou_Order_Confirm extends \ShopEngine\Base\Widget
{

	public function config() {
		return new ShopEngine_Thankyou_Order_Confirm_Config();
	}

	protected function register_controls() {

		// Style Tab - Table Body
		$this->start_controls_section(
			'shopengine_thankyou_order_confirm_table_body_section',
			[
				'label' => esc_html__('Table Body', 'shopengine-pro'),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'           => 'shopengine_thankyou_order_confirm_table_body_typography',
				'label'          => esc_html__('Typography', 'shopengine-pro'),
				'selector'       => '{{WRAPPER}} .shopengine-thankyou-order-confirm table :not(thead) tr :is(th,td, span, a)',
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
					'letter_spacing' => [
						'default' => [
							'size' => '0',
						]
					],
				],
			)
		);

		$this->start_controls_tabs('shopengine_thankyou_order_confirm_table_body_tabs');

		$this->start_controls_tab('shopengine_thankyou_order_confirm_table_body_normal_tab',
			[
				'label' => esc_html__('Normal', 'shopengine-pro'),
			]
		);

		$this->add_control(
			'shopengine_thankyou_order_confirm_table_body_color',
			[
				'label'     => esc_html__('Color', 'shopengine-pro'),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#3A3A3A',
				'alpha'     => false,
				'selectors' => [
					'{{WRAPPER}} .shopengine-thankyou-order-confirm table :not(thead) tr:nth-child(even) :is(th, td, span, .amount)'	=> 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'shopengine_thankyou_order_confirm_table_body_bg_color',
			[
				'label'     => esc_html__('Background', 'shopengine-pro'),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#FFFFFF',
				'alpha'     => false,
				'selectors' => [
					'{{WRAPPER}} .shopengine-thankyou-order-confirm table :not(thead) tr:nth-child(even)' => 'background: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab('shopengine_thankyou_order_confirm_table_body_striped_tab',
			[
				'label' => esc_html__('Striped', 'shopengine-pro'),
			]
		);

		$this->add_control(
			'shopengine_thankyou_order_confirm_table_body_striped_color',
			[
				'label'     => esc_html__('Color', 'shopengine-pro'),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#3A3A3A',
				'alpha'     => false,
				'selectors' => [
					'{{WRAPPER}} .shopengine-thankyou-order-confirm table :not(thead) tr:nth-child(odd) :is(th, td, span, .amount)' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'shopengine_thankyou_order_confirm_table_body_striped_bg_color',
			[
				'label'     => esc_html__('Background', 'shopengine-pro'),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#F9F9F9',
				'alpha'     => false,
				'selectors' => [
					'{{WRAPPER}} .shopengine-thankyou-order-confirm table :not(thead) tr:nth-child(odd)' => 'background: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_control(
			'shopengine_thankyou_order_confirm_table_body_link_color',
			[
				'label'     => esc_html__('Link Color', 'shopengine-pro'),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#4169E1',
				'alpha'     => false,
				'selectors' => [
					'{{WRAPPER}} .shopengine-thankyou-order-confirm table :not(thead) tr a' => 'color: {{VALUE}};',
				],
				'separator' => 'before',
			]
		);

		$this->add_control(
			'shopengine_thankyou_order_confirm_table_body_link_hover_color',
			[
				'label'     => esc_html__('Link Hover Color', 'shopengine-pro'),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#E65093',
				'alpha'     => false,
				'selectors' => [
					'{{WRAPPER}} .shopengine-thankyou-order-confirm table :not(thead) tr a:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'           	=> 'shopengine_thankyou_order_confirm_table_body_border',
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
							'{{WRAPPER}} .shopengine-thankyou-order-confirm table :not(thead) tr' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
							'.rtl {{WRAPPER}} .shopengine-thankyou-order-confirm table :not(thead) tr' => 'border-width: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
						],
					],
					'color'  => [
						'default' => '#F2F2F2'
					]
				],
				'selector'     		=> '{{WRAPPER}} .shopengine-thankyou-order-confirm table :not(thead) tr',
				'separator'			=> 'before',
			]
		);

		$this->add_responsive_control(
			'shopengine_thankyou_order_confirm_table_body_padding',
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
					'{{WRAPPER}} .shopengine-thankyou-order-confirm table :not(thead) tr td' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.rtl {{WRAPPER}} .shopengine-thankyou-order-confirm table :not(thead) tr td' => 'padding: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};'
				],
				'separator'	=> 'before',
			]
		);

		$this->end_controls_section();

		// Style Tab - Global Font
		$this->start_controls_section(
			'shopengine_thankyou_order_confirm_global_font_section',
			[
				'label' => esc_html__('Global Font', 'shopengine-pro'),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'shopengine_thankyou_order_confirm_font_family',
			[
				'label'       => esc_html__('Font Family', 'shopengine-pro'),
				'description' => esc_html__('This font family is set for this specific widget.', 'shopengine-pro'),
				'type'        => Controls_Manager::FONT,
				'selectors'   => [
					'{{WRAPPER}} .shopengine-thankyou-order-confirm table :is(tr, th, td, span, .amount, a)' => 'font-family: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();
	}


	protected function screen() {

		$settings = $this->get_settings_for_display();

		$post_type = get_post_type();

		$order_id = $this->get_the_order_id();

		if($post_type == Template_Cpt::TYPE && $order_id == 0) {
			// get a order to show in editor mode
			$orders = \ShopEngine\Widgets\Products::instance()->get_a_order_id();

			if(!empty($orders[0])) {
				$order_id = $orders[0]->get_id();
			} else {
				?>
                <div class="shopengine shopengine-editor-alert shopengine-editor-alert-warning">
					<?php echo esc_html__('No order found.', 'shopengine-pro'); ?>
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
