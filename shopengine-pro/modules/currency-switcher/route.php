<?php

namespace ShopEngine_Pro\Modules\Currency_Switcher;

use ShopEngine\Base\Api;
use ShopEngine\Core\Register\Module_List;
use ShopEngine_Pro\Modules\Currency_Switcher\Base\Currency_Provider_Register;
use ShopEngine_Pro\Modules\Currency_Switcher\Base\Currency_Rates_Update;
use WC_Payment_Gateways;

class Route extends Api
{
    public function config()
    {
        $this->prefix = 'shopengine_currency';
        $this->param  = "";
    }

    public function post_update_rate()
    {
        return Currency_Rates_Update::instance()->init();
    }

    /**
     * @return mixed
     */
    public function get_update_currency_rate()
    {
        $currency_rate_update = $this->post_update_rate();

        if (!$currency_rate_update) {
            return [
                'status'  => 'failed',
                'message' => esc_html__('something was wrong', 'shopengine-pro')
            ];
        } elseif (isset($currency_rate_update['status']) && $currency_rate_update['status'] === 'failed') {
            return $currency_rate_update;
        }

        return [
            'status'  => 'success',
            'data'    => (new Module_List)->get_settings('currency-switcher')['currencies']['value'],
            'message' => esc_html__('Currencies rate updated successfully!', 'shopengine-pro')
        ];
    }

    public function get_currency_providers()
    {
        $provider_list = [];
        foreach (Currency_Provider_Register::provider_list() as $key => $value) {
            $provider_list[$key] = ucwords(str_replace('_', ' ', $key));
        }

        return [
            'status'  => 'success',
            'result'  => $provider_list,
            'message' => esc_html__('currency providers fetched', 'shopengine-pro')
        ];
    }

    public function get_setting_currencies()
    {
        $settings = Module_List::instance()->get_settings('currency-switcher');

        $currencies = [];
        foreach ($settings['currencies']['value'] as $currency) {
            $currencies[$currency['code']] = $currency['name'];
        }

        return [
            'status'  => 'success',
            'result'  => $currencies,
            'message' => esc_html__('currencies fetched', 'shopengine-pro')
        ];
    }

    public function get_available_payment_gateways()
    {
        $available_payment_gateways = [];
        $wc_payment_gateways        = WC_Payment_Gateways::instance();
        foreach ($wc_payment_gateways->get_available_payment_gateways() as $key => $value) {
            $available_payment_gateways[$key] = $value->title;
        }
        return [
            'status'  => 'success',
            'result'  => $available_payment_gateways,
            'message' => esc_html__('available payment gateway fetched', 'shopengine-pro')
        ];
    }
}
