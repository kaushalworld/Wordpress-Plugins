<?php

namespace ShopEngine_Pro\Templates\Hooks;

defined( 'ABSPATH' ) || exit;

use ShopEngine\Core\Page_Templates\Hooks\Base;
use ShopEngine_Pro\Traits\Path_Correction;

class Checkout_Order_Pay extends Base
{
    use Path_Correction;

    /**
     * @var string
     */
    protected $page_type = 'checkout-order-pay';

    /**
     * @var string
     */
    protected $template_part = 'checkout-order-pay.php';

    public function init(): void
    {}

    protected function template_include_pre_condition(): bool
    {
        return is_checkout_pay_page();
    }
}
