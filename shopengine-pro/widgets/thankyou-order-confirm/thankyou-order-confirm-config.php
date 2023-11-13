<?php

namespace Elementor;

defined('ABSPATH') || exit;

class ShopEngine_Thankyou_Order_Confirm_Config extends \ShopEngine\Base\Widget_Config {

	public function get_name() {
		return 'thankyou-order-confirm';
	}


	public function get_title() {
		return esc_html__('Order Confirm', 'shopengine-pro');
	}


	public function get_icon() {
		return 'shopengine-widget-icon shopengine-icon-thankyou_order_confirm';
	}


	public function get_categories() {
		return ['shopengine-order'];
	}


	public function get_keywords() {
		return ['woocommerce', 'shopengine', 'order confirmation', 'thank you'];
	}

	public function get_template_territory() {
		return ['order'];
	}
}
