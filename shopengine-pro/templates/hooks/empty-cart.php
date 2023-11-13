<?php

namespace ShopEngine_Pro\Templates\Hooks;

defined('ABSPATH') || exit;

use ShopEngine\Core\Page_Templates\Hooks\Base;
use ShopEngine_Pro\Traits\Path_Correction;

class Empty_Cart extends Base
{
    use Path_Correction;

    /**
     * @var string
     */
    protected $page_type = 'empty-cart';
    /**
     * @var string
     */
    protected $template_part = 'content-empty-cart.php';

    public function init(): void {}

    protected function template_include_pre_condition(): bool
    {
        return is_cart() && WC()->cart->is_empty();
    }
}
