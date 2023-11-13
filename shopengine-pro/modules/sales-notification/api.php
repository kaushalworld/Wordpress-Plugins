<?php

namespace ShopEngine_Pro\Modules\Sales_Notification;


use Exception;
use ShopEngine\Base\Api as Base_Api;

class Api extends Base_Api {

	/**
	 * @throws Exception
	 */
	public function get_sales_notification(): array {

		return ( new Notification_Data() )->get_data();
	}

	public function config() {
		$this->prefix = '';
	}

}