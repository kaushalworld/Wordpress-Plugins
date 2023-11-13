<?php

namespace Elementor;

defined('ABSPATH') || exit;

class ShopEngine_Thankyou_Order_Details_Config extends \ShopEngine\Base\Widget_Config{

    public function get_name() {
		return 'thankyou-order-details';
	}


	public function get_title() {
		return esc_html__('Order Details', 'shopengine-pro');
	}


	public function get_icon() {
		return 'shopengine-widget-icon shopengine-icon-thankyou_order_details';
	}


	public function get_categories() {
		return ['shopengine-order'];
	}


	public function get_keywords() {
		return ['woocommerce', 'shopengine', 'order details', 'thank you'];
	}

	public function get_template_territory() {
		return ['order'];
	}


}