<?php

namespace Elementor;

defined('ABSPATH') || exit;

class ShopEngine_Account_Form_Lost_Passowrd_Config extends \ShopEngine\Base\Widget_Config
{

	public function get_name() {
		return 'account-form-lost-password';
	}


	public function get_title() {
		return esc_html__('Account Lost Password Form', 'shopengine-pro');
	}


	public function get_icon() {
		return 'shopengine-widget-icon shopengine-icon-account_form_register';
	}

	public function get_categories() {
		return ['shopengine-my_account'];
	}

	public function get_keywords() {
		return ['woocommerce', 'shopengine', 'dashboard', 'my account form', 'lost-passowrd', 'my account'];
	}

	public function get_template_territory() {
		return ['my_account', 'lost-password'];
	}
}
