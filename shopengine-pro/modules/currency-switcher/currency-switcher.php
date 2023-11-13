<?php

namespace ShopEngine_Pro\Modules\Currency_Switcher;

use ShopEngine\Core\Register\Module_List;
use ShopEngine_Pro\Modules\Currency_Switcher\Base\Currency_Rates_Update;
use ShopEngine_Pro\Traits\Singleton;
use ShopEngine_Pro\Modules\Currency_Switcher\Base\Currency_Switcher_Admin;
use ShopEngine_Pro\Modules\Currency_Switcher\Base\Currency_Switcher_Frontend;

defined('ABSPATH') || exit;

class Currency_Switcher {

	use Singleton;

	public function init() {
		
		new Route;
		
		$settings = Module_List::instance()->get_settings('currency-switcher');

		// auto update currency rates start
		$transient = get_transient('shopengine_currency_auto_update');
		if($settings['currency_auto_update']['value'] === 'yes' && !isset($transient)) {
			Currency_Rates_Update::instance()->init();
			$time = time()+(60*60*$settings['currency_auto_update_time']['value']);
			set_transient('shopengine_currency_auto_update', $time);
		}
		// auto update currency rates end

		if (is_admin()) {
			Currency_Switcher_Admin::instance()->init();
		} else {
			Currency_Switcher_Frontend::instance()->init($settings);
		}
	}
}
