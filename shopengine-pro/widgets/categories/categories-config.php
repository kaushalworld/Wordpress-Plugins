<?php

namespace Elementor;

defined('ABSPATH') || exit;

class ShopEngine_Categories_Config extends \ShopEngine\Base\Widget_Config {

	public function get_name() {
		return 'categories';
	}

	public function get_title() {
		return esc_html__('Categories', 'shopengine-pro');
	}

	public function get_icon() {
		return 'shopengine-widget-icon shopengine-icon-product_categories';
	}

	public function get_categories() {
		return ['shopengine-general'];
	}

	public function get_keywords() {
		return ['woocommerce', 'shopengine', 'category', 'product categories'];
	}

	public function get_template_territory() {
		return [];
	}
}
