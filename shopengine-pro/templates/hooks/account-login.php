<?php

namespace ShopEngine_Pro\Templates\Hooks;

defined('ABSPATH') || exit;

use ShopEngine\Core\Page_Templates\Hooks\Base;
use ShopEngine_Pro\Traits\Path_Correction;

defined('ABSPATH') || exit;

class Account_Login extends Base {

	use Path_Correction;

	protected $page_type = 'my_account_login';
	protected $template_part = 'content-login.php';

	public function init(): void {
	}

	protected function template_include_pre_condition(): bool {

		return is_account_page() && !is_user_logged_in();
	}
}
