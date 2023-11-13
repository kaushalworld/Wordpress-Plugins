<?php

namespace Elementor;

defined('ABSPATH') || exit;

class ShopEngine_Account_Navigation_Config extends \ShopEngine\Base\Widget_Config
{

	public function get_name() {
		return 'account-navigation';
	}


	public function get_title() {
		return esc_html__('Account Navigation', 'shopengine-pro');
	}


	public function get_icon() {
		return 'shopengine-widget-icon shopengine-icon-account_address';
	}


	public function get_categories() {
		return ['shopengine-my_account'];
	}


	public function get_keywords() {
		return ['woocommerce', 'shopengine', 'my account', 'dashboard', 'account navigation'];
	}

	public function get_template_territory() {
		return ['my_account', 'account_orders', 'account_orders_view', 'account_downloads', 'account_edit_address', 'account_edit_account', 'my_account_login'];
	}
}
