<?php
namespace Elementor;

defined('ABSPATH') || exit;

class ShopEngine_Comparison_Button_Config extends \ShopEngine\Base\Widget_Config {

	public function get_name() {
		return 'comparison-button';
	}

	public function get_title() {
		return esc_html__('Comparison Button', 'shopengine-pro');
	}

	public function get_categories() {
		return ['shopengine-general'];
	}

	public function get_icon() {
		return 'shopengine-widget-icon shopengine-icon-product_compare_1';
	}

	public function get_keywords() {
		return ['woocommerce', 'shopengine', 'comparison button', 'compare button'];
	}

	public function get_template_territory() {
		return [];
	}
}
