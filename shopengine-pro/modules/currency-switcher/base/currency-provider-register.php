<?php

namespace ShopEngine_Pro\Modules\Currency_Switcher\Base;

class Currency_Provider_Register {
	public static function provider_list()  {
		return [
			'fixer' => [
				'base_class' => 'ShopEngine_Pro\Modules\Currency_Switcher\Providers\Fixer',
			],
			'currency_freaks' => [
				'base_class' => 'ShopEngine_Pro\Modules\Currency_Switcher\Providers\Currency_Freaks'
			]
		];
	}
}