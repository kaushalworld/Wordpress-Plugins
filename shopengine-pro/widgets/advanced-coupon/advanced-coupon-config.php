<?php

namespace Elementor;

defined('ABSPATH') || exit;

class ShopEngine_Advanced_Coupon_Config extends \ShopEngine\Base\Widget_Config{

	public function get_name() {
		return 'advanced-coupon';
	}


	public function get_title() {
		return esc_html__('Advanced Coupon', 'shopengine-pro');
	}


	public function get_icon() {
		return 'shopengine-widget-icon shopengine-icon-checkout_coupon_form';
	}


	public function get_categories() {
		return ['shopengine-general'];
	}


	public function get_keywords() {
		return ['woocommerce', 'shopengine', 'advanced-coupon'];
	}

	public function get_template_territory() {
		return [];
	}
}