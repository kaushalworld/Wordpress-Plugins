<?php

namespace Elementor;

defined('ABSPATH') || exit;

class ShopEngine_Thankyou_Address_Details_Config extends \ShopEngine\Base\Widget_Config {

	public function get_name() {
		return 'thankyou-address-details';
	}


	public function get_title() {
		return esc_html__('Address details', 'shopengine-pro');
	}


	public function get_icon() {
		return 'shopengine-widget-icon shopengine-icon-thankyou_address_details';
	}


	public function get_categories() {
		return ['shopengine-order'];
	}


	public function get_keywords() {
		return ['woocommerce', 'shopengine', 'address details', 'thank you'];
	}


	public function get_template_territory() {
		return ['order'];
	}
}
