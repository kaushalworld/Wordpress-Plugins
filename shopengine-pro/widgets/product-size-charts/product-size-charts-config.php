<?php

namespace Elementor;

defined('ABSPATH') || exit;

class ShopEngine_Product_Size_Charts_Config extends \ShopEngine\Base\Widget_Config {

    public function get_name() {
        return 'product-size-charts';
    }

    public function get_title() {
        return esc_html__('Product Size Charts', 'shopengine-pro');
    }

    public function get_icon() {
        return 'eicon-post-list shopengine-widget-icon';
    }

    public function get_categories() {
        return ['shopengine-single'];
    }

    public function get_keywords() {
        return ['woocommerce', 'charts', 'size', 'single'];
    }

    public function get_template_territory() {
        return ['single', 'quick_view'];
    }
}
