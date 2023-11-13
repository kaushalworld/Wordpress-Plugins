<?php

namespace Elementor;

use ShopEngine\Core\Template_Cpt;
use ShopEngine\Widgets\Products;

defined('ABSPATH') || exit;


class ShopEngine_Thankyou_Thankyou extends \ShopEngine\Base\Widget
{

	public function config() {
		return new ShopEngine_Thankyou_Thankyou_Config();
	}


	protected function register_controls() {

		// Style Tab
		$this->start_controls_section(
			'shopengine_order_thankyou_style_section',
			array(
				'label' => esc_html__('Style', 'shopengine-pro'),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_responsive_control(
			'shopengine_thankyou_align',
			\ShopEngine\Utils\Controls_Helper::get_alignment_conf(
				'shopengine-thankyou-align-',
				'',
				[
					'{{WRAPPER}} .shopengine-thankyou-thankyou' => 'text-align: {{VALUE}};',
					'.rtl {{WRAPPER}}.shopengine-thankyou-align-left .shopengine-thankyou-thankyou' => 'text-align:right;',  
					'.rtl {{WRAPPER}}.shopengine-thankyou-align-right .shopengine-thankyou-thankyou' => 'text-align:left;',
				]
			)
		);

		$this->add_control(
			'shopengine_order_thankyou_title_heading',
			[
				'label'     => esc_html__('Title', 'shopengine-pro'),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'shopengine_order_thankyou_title_color',
			[
				'label'     => esc_html__('Color', 'shopengine-pro'),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#3A3A3A',
				'alpha'     => false,
				'selectors' => [
					'{{WRAPPER}} .shopengine-thankyou-thankyou h3' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'           => 'shopengine_order_thankyou_title_typography',
				'label'          => esc_html__('Typography', 'shopengine-pro'),
				'selector'       => '{{WRAPPER}} .shopengine-thankyou-thankyou h3',
				'exclude'        => ['font_family', 'text_decoration', 'font_style'],
				'fields_options' => [
					'typography'     => [
						'default' => 'custom',
					],
					'font_size'      => [
						'label'      => esc_html__('Font Size (px)', 'shopengine-pro'),
						'size_units' => ['px'],
						'default'    => [
							'size' => '48',
							'unit' => 'px'
						]
					],
					'font_weight'    => [
						'default' => '700',
					],
					'text_transform' => [
						'default' => 'uppercase',
					],
					'line_height'    => [
						'label'      => esc_html__('Line Height (px)', 'shopengine-pro'),
						'default'    => [
							'size' => '46',
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
							'size' => '0.3',
						]
					],
				],
			)
		);

		$this->add_responsive_control(
			'shopengine_order_thankyou_title_margin',
			[
				'label'      => esc_html__('Margin (px)', 'shopengine-pro'),
				'type'       => Controls_Manager::DIMENSIONS,
				'default'    => [
					'top'      => '0',
					'right'    => '0',
					'bottom'   => '10',
					'left'     => '0',
					'unit'     => 'px',
					'isLinked' => false,
				],
				'size_units' => ['px'],
				'selectors'  => [
					'{{WRAPPER}} .shopengine-thankyou-thankyou h3' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.rtl {{WRAPPER}} .shopengine-thankyou-thankyou h3' => 'margin: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};'
				],
			]
		);

		$this->add_control(
			'shopengine_order_thankyou_description',
			[
				'label'     => esc_html__('Description', 'shopengine-pro'),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'shopengine_order_thankyou_color',
			[
				'label'     => esc_html__('Color', 'shopengine-pro'),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#9C9C9C',
				'alpha'     => false,
				'selectors' => [
					'{{WRAPPER}} .shopengine-thankyou-thankyou p' => 'color: {{VALUE}}; margin: 0;',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'           => 'shopengine_order_thankyou_description_typography',
				'label'          => esc_html__('Typography', 'shopengine-pro'),
				'selector'       => '{{WRAPPER}} .shopengine-thankyou-thankyou p',
				'exclude'        => ['font_family', 'text_decoration', 'font_style'],
				'fields_options' => [
					'typography'     => [
						'default' => 'custom',
					],
					'font_size'      => [
						'label'      => esc_html__('Font Size (px)', 'shopengine-pro'),
						'size_units' => ['px'],
						'default'    => [
							'size' => '22',
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
							'size' => '22',
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

		// Style Tab - Global Font
		$this->add_control(
			'shopengine_order_thankyou_global_font_section',
			[
				'label'     => esc_html__('Global Font', 'shopengine-pro'),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'shopengine_order_thankyou_font_family',
			[
				'label'       => esc_html__('Font Family', 'shopengine-pro'),
				'description' => esc_html__('This font family is set for this specific widget.', 'shopengine-pro'),
				'type'        => Controls_Manager::FONT,
				'selectors'   => [
					'{{WRAPPER}} .shopengine-thankyou-thankyou :is(h2, h3, p)' => 'font-family: {{VALUE}}',
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