<?php

namespace ShopEngine_Pro\Modules\Currency_Switcher\Base;

use ShopEngine_Pro\Traits\Singleton;

defined('ABSPATH') || exit;

class Currency_Switcher_Admin {

	use Singleton;

	public function init() {
		add_filter('woocommerce_general_settings', [$this, 'woocommerce_general_settings']);
	}

	public function woocommerce_general_settings($settings) {

        $title = esc_html__("Go Setting","shopengine-pro");
        foreach ($settings as $key => $value) {
            if (isset($value['id'])) {
               if (in_array($value['id'], ['woocommerce_currency', 'woocommerce_price_num_decimals', 'woocommerce_currency_pos'])) {
                    unset($settings[$key]);
                }
                if ($value['id'] === 'pricing_options') {
                   $settings[$key]['desc'] = sprintf(esc_html__('This field is for frontend display settings only. ShopEngine has been activated. Please set the default currency from %s.', 'shopengine-pro'), '<a title="' . $title . '" href="'.get_admin_url().'edit.php?post_type=shopengine-template#shopengine-modules'.'">'.esc_html__('here', 'shopengine-pro').'</a>');
                }
            }
        }
        return $settings;
	}
}
