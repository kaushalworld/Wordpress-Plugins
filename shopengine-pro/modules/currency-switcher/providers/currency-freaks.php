<?php

namespace ShopEngine_Pro\Modules\Currency_Switcher\Providers;

use ShopEngine_Pro\Modules\Currency_Switcher\Currency_Providers;

class Currency_Freaks extends Currency_Providers
{
    public function get_name()
    {
        return 'currency_freaks';
    }

    /**
     * @param $settings
     */
    public function get_currencies($settings)
    {
        $response      = wp_remote_get('https://api.currencyfreaks.com/latest?apikey=' . str_replace(' ', '', $settings['currency-switcher']['settings']['currency_freaks_api_credential']['value']) . '&format=json');
        $response_body = json_decode(wp_remote_retrieve_body($response), true);
        $response_code = wp_remote_retrieve_response_code($response);

        if ($response_code === 200) {
            return $response_body['rates'];
        }
        return [
            'status' => 'failed',
            'message' => isset($response_body['error']['message']) ? $response_body['error']['message'] : esc_html__('something was wrong with currencyfreaks credential', 'shopengine-pro')
        ];
    }
}
