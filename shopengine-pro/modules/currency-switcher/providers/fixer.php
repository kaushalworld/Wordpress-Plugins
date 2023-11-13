<?php

namespace ShopEngine_Pro\Modules\Currency_Switcher\Providers;

use ShopEngine_Pro\Modules\Currency_Switcher\Currency_Providers;

class Fixer extends Currency_Providers {

	public function get_name() {
		return 'fixer';
	}

	public function get_currencies($settings) {
		$request = wp_remote_get('http://data.fixer.io/api/latest?access_key=' . $settings['currency-switcher']['settings']['fixer_api_credential']['value']);
		$curr = json_decode($request['body']);
		if ($curr->success === false) {
			return [
				'status' => 'failed',
				'message' => $curr->error->info
			];
		}
		$c = (array)$curr->rates;
		$usd = $c['USD'];
		$currency = ['EUR' => (1 / $usd)];
		foreach ($c as $key => $value) {
			$currency[$key] = ((1 / $usd) * $value);
		}
		return $currency;
	}
}