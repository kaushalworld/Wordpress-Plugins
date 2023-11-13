<?php

namespace Elementor;

defined('ABSPATH') || exit;

class ShopEngine_Vacation_Config extends \ShopEngine\Base\Widget_Config{

	public function get_name() {
		return 'vacation';
	}


	public function get_title() {
		return esc_html__('Vacation Notice', 'shopengine-pro');
	}


	public function get_icon() {
		return 'shopengine-widget-icon shopengine-icon-thankyou_message';
	}


	public function get_categories() {
		return ['shopengine-general'];
	}


	public function get_keywords() {
		return ['woocommerce', 'shopengine', 'vacation'];
	}

	public function get_template_territory() {
		return [];
	}
}