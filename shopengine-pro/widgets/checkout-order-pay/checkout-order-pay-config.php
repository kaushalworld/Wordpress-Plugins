<?php

namespace Elementor;

defined( 'ABSPATH' ) || exit;

class ShopEngine_Checkout_Order_Pay_Config extends \ShopEngine\Base\Widget_Config
{
    public function get_name()
    {
        return 'checkout-order-pay';
    }

    public function get_title()
    {
        return esc_html__( 'Checkout Order Pay', 'shopengine-pro' );
    }

    public function get_icon()
    {
        return 'shopengine-widget-icon shopengine-icon-cross_sells';
    }

    public function get_categories()
    {
        return ['shopengine-checkout'];
    }

    public function get_keywords()
    {
        return ['woocommerce', 'checkout', 'form-pay'];
    }

    public function get_template_territory()
    {
        return ['checkout-order-pay'];
    }
}
