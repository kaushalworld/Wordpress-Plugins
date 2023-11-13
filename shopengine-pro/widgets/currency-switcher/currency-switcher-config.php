<?php

namespace Elementor;

defined('ABSPATH') || exit;

class ShopEngine_Currency_Switcher_Config extends \ShopEngine\Base\Widget_Config {

	public function get_name() {
		return 'currency-switcher';
	}


	public function get_title() {
		return esc_html__('Currency Switcher', 'shopengine-pro');
	}


	public function get_categories() {
		return ['shopengine-general'];
	}


	public function get_icon() {
		return 'shopengine-widget-icon shopengine-icon-checkout_payment';
	}


	public function get_keywords() {
		return ['woocommerce', 'shop', 'currency', 'currency switcher', 'money', 'switcher', 'shopengine'];
	}


	public function get_template_territory() {
		return [];
	}
}