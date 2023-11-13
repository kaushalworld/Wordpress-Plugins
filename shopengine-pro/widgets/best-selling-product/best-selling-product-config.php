<?php

namespace Elementor;

defined('ABSPATH') || exit;

class Shopengine_Best_Selling_Product_Config extends \ShopEngine\Base\Widget_Config {

    public function get_name() {
        return 'best-selling-product';
    }

    public function get_title() {
        return esc_html__('Best Selling Product', 'shopengine-pro');
    }

    public function get_icon() {
        return 'shopengine-widget-icon shopengine-icon-orders_ac';
    }

    public function get_categories() {
        return ['shopengine-general'];
    }

    public function get_keywords() {
        return ['woocommerce', 'best selling product', 'shopengine', 'product', 'best', 'sell'];
    }

    public function get_template_territory() {
		return [];
	}
}
