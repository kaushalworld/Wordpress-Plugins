<?php

namespace Elementor;

defined('ABSPATH') || exit;

class ShopEngine_Account_Address_Config extends \ShopEngine\Base\Widget_Config
{
	public function get_name() {
		return 'account-address';
	}


	public function get_title() {
		return esc_html__('Account Address', 'shopengine-pro');
	}


	public function get_icon() {
		return 'shopengine-widget-icon shopengine-icon-account_address';
	}


	public function get_categories() {
		return ['shopengine-my_account'];
	}

	public function get_template_territory() {
		return ['my_account', 'account_edit_account', 'account_edit_address'];
	}

	public function get_keywords() {
		return ['woocommerce', 'shopengine', 'my account', 'account address'];
	}
}