<?php

namespace Elementor;

defined('ABSPATH') || exit;

class ShopEngine_Account_Order_Details_Config extends \ShopEngine\Base\Widget_Config {

	public function get_name() {
		return 'account-order-details';
	}


	public function get_title() {
		return esc_html__('Account Order Details', 'shopengine-pro');
	}


	public function get_icon() {
		return 'shopengine-widget-icon shopengine-icon-thankyou_order_details';
	}


	public function get_categories() {
		return ['shopengine-my_account'];
	}


	public function get_keywords() {
		return ['woocommerce', 'shopengine', 'dashboard', 'account order details'];
	}


	public function get_template_territory() {
		return ['account_orders_view'];
	}
}
