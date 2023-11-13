<?php

namespace ShopEngine_Pro\Modules\Currency_Switcher\Base;

use ShopEngine\Core\Register\Model;
use ShopEngine_Pro\Modules\Currency_Switcher\Currency_Providers;
use ShopEngine_Pro\Traits\Singleton;
use ShopEngine_Pro\Modules\Currency_Switcher\Base\Currency_Provider_Register;

class Currency_Rates_Update {

	use Singleton;

	private $settings;

	public function init() {

		$this->settings = Model::source('settings')->get_option('modules');
		if(is_null($this->settings)) {
			return false;
		}
		return $this->providers();
	}

	public function update_rates(array $currencies) {

		$missing = [];
		$currency_option_list = $this->settings['currency-switcher']['settings']['currencies']['value'];
		if(is_array($currency_option_list)) {
			foreach($currency_option_list as $key => $currency) {
				if (!empty($currencies[$currency['code']])) {
					$currency_option_list[$key]['rate'] = $currencies[$currency['code']];
				} else {
					$missing[] = $currency['code'];
				}
			}
		}
		
		$this->settings['currency-switcher']['settings']['currencies']['value'] = $currency_option_list;

		Model::source('settings')->set_option('modules', $this->settings);
		
		if(empty($missing)) {
			return [
				'status' =>  'success',
				'message' => esc_html__('Your Currencies Rate Updated Successfully!', 'shopengine-pro')
			];
		}
		return [
			'status' 	=> 'failed',
			'message' 	=> esc_html__('This api service product not have your some currencies', 'shopengine-pro'),
			'missing'	=> $missing
		];
	}


	public function providers() {

		foreach(Currency_Provider_Register::provider_list() as $key => $value) {
			if($this->settings['currency-switcher']['settings']['default_api_service_provider']['value'] === $key) {
				$provider = new $value['base_class']();
				if ($provider instanceof Currency_Providers) {
					$data = $provider->get_currencies($this->settings);
					if (isset($data['status']) && $data['status'] === 'failed') {
						return $data;
					}
					return $this->update_rates($data);
				}
			}
		}
	}
}
