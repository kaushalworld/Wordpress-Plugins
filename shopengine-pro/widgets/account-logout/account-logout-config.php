<?php

namespace Elementor;

defined('ABSPATH') || exit;

class ShopEngine_Account_Logout_Config extends \ShopEngine\Base\Widget_Config
{
	public function get_name() {
		return 'account-logout';
	}


	public function get_title() {
		return esc_html__('Account Logout', 'shopengine-pro');
	}


	public function get_icon() {
		return 'shopengine-widget-icon shopengine-icon-account_logout';
	}


	public function get_categories() {
		return ['shopengine-my_account'];
	}


	public function get_keywords() {
		return ['woocommerce', 'shopengine', 'logout', 'my account'];
	}

	public function get_template_territory() {
		return ['my_account', 'my_account_login', 'account_downloads', 'account_edit_account', 'account_edit_address', 'account_orders_view', 'account_orders'];
	}
}
