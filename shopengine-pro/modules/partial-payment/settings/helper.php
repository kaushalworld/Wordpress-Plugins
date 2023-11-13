<?php

namespace ShopEngine_Pro\Modules\Partial_Payment\Settings;


class Helper {

	public static function payment_methods() {
		$final_payment_gateways = [];
		$payment_gateways       = WC()->payment_gateways->get_available_payment_gateways();

		foreach ( $payment_gateways as $key => $payment_gateway ) {
			$final_payment_gateways[ $key ] = $payment_gateway->title;
		}

		return $final_payment_gateways;
	}

}