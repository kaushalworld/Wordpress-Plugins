<?php

namespace Elementor;

use ShopEngine\Core\Template_Cpt;
use ShopEngine\Widgets\Products;

defined('ABSPATH') || exit;


class ShopEngine_Thankyou_Address_Details extends \ShopEngine\Base\Widget
{

	public function config() {
		return new ShopEngine_Thankyou_Address_Details_Config();
	}

	protected function register_controls() {
		
		// Style Tab - Default Style
		$this->start_controls_section(
			'shopengine_thankyou_address_details_styles_section',
			[
				'label' => esc_html__('Styles', 'shopengine-pro'),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		// Style Heading - Wrap
		$this->add_control(
			'shopengine_thankyou_address_details_wrap_heading',
			[
				'label'		=> esc_html__( 'Wrap', 'shopengine-pro' ),
				'type'		=> Controls_Manager::HEADING,
			]
		);


		$this->add_responsive_control(
			'shopengine_thankyou_address_details_alignment',
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
					'{{WRAPPER}} .shopengine-thankyou-address-details'         => 'text-align: {{VALUE}};',
					'{{WRAPPER}} .shopengine-thankyou-address-details address' => 'text-align: {{VALUE}};',
					'.rtl {{WRAPPER}}.elementor-align-left .shopengine-thankyou-address-details' => 'text-align:right;', 
					'.rtl {{WRAPPER}}.elementor-align-right .shopengine-thankyou-address-details' => 'text-align:left;',
					'.rtl {{WRAPPER}}.elementor-align-right .shopengine-thankyou-address-details address' => 'text-align:left;',
					'.rtl {{WRAPPER}}.elementor-align-left .shopengine-thankyou-address-details address' => 'text-align:right;',
				],
			]
		);

		// Style Heading - Title
		$this->add_control(
			'shopengine_thankyou_address_details_title_heading',
			[
				'label'		=> esc_html__( 'Title', 'shopengine-pro' ),
				'type'		=> Controls_Manager::HEADING,
                'separator'	=> 'before',
			]
		);

		$this->add_control(
			'shopengine_thankyou_address_details_title_color',
			[
				'label'     => esc_html__('Color', 'shopengine-pro'),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#3A3A3A',
				'alpha'     => false,
				'selectors' => [
					'{{WRAPPER}} .shopengine-thankyou-address-details :is(h2, .woocommerce-column__title)' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'           => 'shopengine_thankyou_address_details_title_typography',
				'label'          => esc_html__('Typography', 'shopengine-pro'),
				'selector'       => '{{WRAPPER}} .shopengine-thankyou-address-details :is(h2, .woocommerce-column__title)',
				'exclude'        => ['font_family', 'letter_spacing', 'text_decoration', 'font_style'],
				'fields_options' => [
					'typography'  => [
						'default' => 'custom',
					],
					'font_weight' => [
						'default' => '600',
					],
					'font_size'      => [
						'label'      => esc_html__('Font Size (px)', 'shopengine-pro'),
						'size_units' => ['px'],
						'default'    => [
							'size' => '22',
							'unit' => 'px'
						]
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

		// Style Heading - Address
		$this->add_control(
			'shopengine_thankyou_address_details_address_heading',
			[
				'label'		=> esc_html__( 'Address', 'shopengine-pro' ),
				'type'		=> Controls_Manager::HEADING,
                'separator'	=> 'before',
			]
		);

		$this->add_control(
			'shopengine_thankyou_address_details_address_color',
			[
				'label'     => esc_html__('Color', 'shopengine-pro'),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#3A3A3A',
				'alpha'     => false,
				'selectors' => [
					'{{WRAPPER}} .shopengine-thankyou-address-details :not(.woocommerce-column__title)' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'           => 'shopengine_thankyou_address_details_address_typography',
				'label'          => esc_html__('Typography', 'shopengine-pro'),
				'selector'       => '{{WRAPPER}} .shopengine-thankyou-address-details :not(.woocommerce-column__title)',
				'exclude'        => ['font_family', 'letter_spacing', 'text_decoration'],
				'fields_options' => [
					'typography'  => [
						'default' => 'custom',
					],
					'font_weight' => [
						'default' => '400',
					],
					'font_size'      => [
						'label'      => esc_html__('Font Size (px)', 'shopengine-pro'),
						'size_units' => ['px'],
						'default'    => [
							'size' => '16',
							'unit' => 'px'
						]
					],
					'line_height'    => [
						'label'      => esc_html__('Line Height (px)', 'shopengine-pro'),
						'default'    => [
							'size' => '26',
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
					'font_style'      => [
						'default'    => 'normal'
					],
				],
			)
		);

		// Style Heading - Global Font
		$this->add_control(
			'shopengine_thankyou_address_details_global_font_heading',
			[
				'label'		=> esc_html__( 'Global Font', 'shopengine-pro' ),
				'type'		=> Controls_Manager::HEADING,
                'separator'	=> 'before',
			]
		);

		$this->add_control(
			'shopengine_thankyou_address_details_font_family',
			[
				'label'       => esc_html__('Font Family', 'shopengine-pro'),
				'description' => esc_html__('This font family is set for this specific widget.', 'shopengine-pro'),
				'type'        => Controls_Manager::FONT,
				'selectors'   => [
					'{{WRAPPER}} .shopengine-thankyou-address-details'	=> 'font-family: {{VALUE}};',
					'{{WRAPPER}} .shopengine-thankyou-address-details :is(h2, p, address .woocommerce-column__title)'	=> 'font-family: {{VALUE}};',
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
