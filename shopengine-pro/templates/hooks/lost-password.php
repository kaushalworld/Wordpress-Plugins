<?php

namespace ShopEngine_Pro\Templates\Hooks;

defined('ABSPATH') || exit;

use ShopEngine\Core\Page_Templates\Hooks\Base;
use ShopEngine_Pro\Traits\Path_Correction;

class Lost_Password extends Base
{
    use Path_Correction;

    /**
     * @var string
     */
    protected $page_type = 'lost-password';
    /**
     * @var string
     */
    protected $template_part = 'content-lost-password.php';

    public function init(): void {}

    protected function template_include_pre_condition(): bool
    {
        // phpcs:ignore WordPress.Security.NonceVerification.Recommended
        return is_account_page() && is_wc_endpoint_url('lost-password') && empty($_GET['show-reset-form']);
    }
}
