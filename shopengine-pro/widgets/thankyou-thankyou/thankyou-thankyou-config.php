<?php

namespace Elementor;

defined('ABSPATH') || exit;

class ShopEngine_Thankyou_Thankyou_Config extends \ShopEngine\Base\Widget_Config{

	public function get_name() {
		return 'thankyou-thankyou';
	}


	public function get_title() {
		return esc_html__('Order Thank You', 'shopengine-pro');
	}


	public function get_icon() {
		return 'shopengine-widget-icon shopengine-icon-thankyou_message';
	}


	public function get_categories() {
		return ['shopengine-order'];
	}


	public function get_keywords() {
		return ['woocommerce', 'shopengine', 'thank you'];
	}

	public function get_template_territory() {
		return ['order'];
	}
}
