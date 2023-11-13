<?php

namespace ShopEngine_Pro\Templates\Hooks;

use ShopEngine\Core\Builders\Templates;
use ShopEngine\Core\Page_Templates\Hooks\Base;
use ShopEngine_Pro\Traits\Path_Correction;

defined('ABSPATH') || exit;


class Thank_You extends Base {

	use Path_Correction;

	protected $page_type = 'order';
	protected $template_part = 'content-thankyou.php';


	public function init(): void {
	}

	protected function template_include_pre_condition(): bool {

		return is_checkout() && is_wc_endpoint_url('order-received');
	}
}
