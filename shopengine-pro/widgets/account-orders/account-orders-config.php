<?php

namespace Elementor;

defined('ABSPATH') || exit;

class ShopEngine_Account_Orders_Config extends \ShopEngine\Base\Widget_Config
{

	public function get_name() {
		return 'account-orders';
	}

	public function get_title() {

		return esc_html__('My Account Orders', 'shopengine-pro');
	}

	public function get_icon() {
		return 'shopengine-widget-icon shopengine-icon-orders_ac';
	}

	public function get_categories() {
		return ['shopengine-my_account'];
	}

	public function get_keywords() {
		return ['account orders', 'shopengine', 'account'];
	}

	public function get_template_territory() {
		return ['my_account', 'account_orders'];
	}
}
