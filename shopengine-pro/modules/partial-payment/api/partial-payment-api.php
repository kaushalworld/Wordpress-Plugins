<?php


namespace ShopEngine_Pro\Modules\Partial_Payment\Api;


use ShopEngine\Base\Api;
use ShopEngine_Pro\Modules\Partial_Payment\Frontend\Cart\Partial_Payment_Cart;
use WC_Payment_Gateways;

class Partial_Payment_Api extends Api {


	public function config() {
		$this->prefix = 'partial-payment';
	}


	public function get_payment_methods(): array {

		$available_payment_gateways = [];

		$wcpg = WC_Payment_Gateways::instance();

		foreach($wcpg->get_available_payment_gateways() as $key => $value) {

			$available_payment_gateways[$key] = $value->title;

		}

		return [
			'status' => 'success',
			'result' => $available_payment_gateways,
			'message' => esc_html__('available payment gateway fetched', 'shopengine-pro')
		];
	}

	public function post_partial_data() {

		$partialData = new Partial_Payment_Cart();
	    $data = $partialData->get_partial_payment_deposit_amount();

		wp_send_json($data);
	}

}