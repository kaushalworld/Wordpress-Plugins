<?php

namespace Elementor;

defined('ABSPATH') || exit;

class ShopEngine_Account_Form_Register_Config extends \ShopEngine\Base\Widget_Config
{
	public function get_name() {
		return 'account-form-register';
	}


	public function get_title() {
		return esc_html__('Account Register Form', 'shopengine-pro');
	}


	public function get_icon() {
		return 'shopengine-widget-icon shopengine-icon-account_form_register';
	}


	public function get_categories() {
		return ['shopengine-my_account'];
	}


	public function get_keywords() {
		return ['woocommerce', 'shopengine', 'my account', 'account register form'];
	}

	public function get_template_territory() {
		return ['my_account', 'my_account_login', 'checkout_without_account'];
	}
}
