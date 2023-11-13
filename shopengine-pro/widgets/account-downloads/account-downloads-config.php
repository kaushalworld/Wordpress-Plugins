<?php

namespace Elementor;

defined('ABSPATH') || exit;

class ShopEngine_Account_Downloads_Config extends \ShopEngine\Base\Widget_Config
{
	public function get_name() {

		return 'account-downloads';
	}


	public function get_title() {

		return esc_html__('Account Downloads', 'shopengine-pro');
	}


	public function get_icon() {

		return 'shopengine-widget-icon shopengine-icon-account_downloads';
	}


	public function get_categories() {

		return ['shopengine-my_account'];
	}


	public function get_keywords() {

		return ['woocommerce', 'shopengine', 'my account', 'downloads', 'account downloads'];
	}


	public function get_template_territory() {
		return ['account_downloads', 'my_account'];
	}
}
