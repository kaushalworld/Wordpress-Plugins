<?php

namespace ShopEngine_Pro\Templates\Hooks;

defined('ABSPATH') || exit;

use ShopEngine\Core\Builders\Templates;
use ShopEngine\Core\Page_Templates\Hooks\Base;
use ShopEngine\Widgets\Widget_Helper;
use ShopEngine_Pro\Traits\Path_Correction;

defined('ABSPATH') || exit;

class Account extends Base {

	use Path_Correction;

	protected $page_type = 'my_account';
	protected $template_part = 'content-account.php';


	public function init(): void {

		$this->delayed_hook_conflicts();
	}

	public function delayed_hook_conflicts() {
		Widget_Helper::instance()->wc_template_replace_multiple(
			[
				'myaccount/navigation.php',
				'myaccount/my-account.php',
				'myaccount/dashboard.php',
			]
		);
	}

	protected function template_include_pre_condition(): bool {

		return is_user_logged_in() && is_account_page() && !is_wc_endpoint_url();
	}
}


// wp_loaded 
// wp