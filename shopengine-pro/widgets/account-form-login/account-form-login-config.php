<?php

namespace Elementor;

defined('ABSPATH') || exit;

class ShopEngine_Account_Form_Login_Config extends \ShopEngine\Base\Widget_Config
{
	/**
	 * Get widget name.
	 *
	 * Retrieve widget name.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'account-form-login';
	}

	/**
	 * Get widget title.
	 *
	 * Retrieve widget title.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__('My Account Form Login', 'shopengine-pro');
	}

	/**
	 * Get widget icon.
	 *
	 * Retrieve widget icon.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'shopengine-widget-icon shopengine-icon-checkout_form_login';
	}

	/**
	 * Get widget categories.
	 *
	 * Retrieve the list of categories the oEmbed widget belongs to.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return array Widget categories.
	 */
	public function get_categories() {
		return ['shopengine-my_account'];
	}

	public function get_keywords() {
		return ['woocommerce', 'shopengine', 'dashboard', 'my account form', 'login', 'my account'];
	}

	public function get_template_territory() {
		return ['my_account_login', 'my_account', 'checkout_without_account'];
	}
}
