<?php

namespace ShopEngine_Pro\Templates\Hooks;

use ShopEngine\Core\Builders\Templates;
use ShopEngine\Core\Page_Templates\Hooks\Base;
use ShopEngine_Pro\Traits\Path_Correction;

defined('ABSPATH') || exit;

class Account_Orders_View extends Account {

	use Path_Correction;

	protected $page_type = 'account_orders_view';

	public function init(): void {
	}

	protected function template_include_pre_condition(): bool {

		return is_account_page() && is_wc_endpoint_url('view-order');
	}
}
