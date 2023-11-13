<?php

namespace ShopEngine_Pro\Modules\Currency_Switcher\Base;

use ShopEngine_Pro\Traits\Singleton;

defined('ABSPATH') || exit;

class Currency_Switcher_Frontend {

	use Singleton;

	private $currency_symbol = '$';
	private $currency_code;
	private $currency_rate;
	private $currency_position;
	private $currency_decimal;
	private $widget_name;
	private $settings;
	private $payment_gateways;
	private $format;
	
	public function __construct() {
		if (!session_id()) {
			@session_start();
		}
	}

	public function init($settings) {

		$this->settings = $settings;
		$this->currency_rate();
		$this->price_icon_format();
		$this->hooks();
	}

	public function hooks() {

		add_action('elementor/element/before_section_start', function ($content) {
			$this->widget_name = $content->get_name();
			return $content;
		}, 10, 2);
		add_filter('woocommerce_product_get_regular_price', [$this, 'product_regular_price_exchange']);
		add_filter('woocommerce_product_get_price', [$this, 'product_price_exchange']);
		add_filter('woocommerce_product_get_sale_price', [$this, 'product_sale_price_exchange']);
		add_filter('shopengine_filter_price_range', [$this, 'filter_price_range']);
		add_filter('wc_get_price_decimals', [$this, 'price_decimals']);
		add_filter('woocommerce_currency_symbol', [$this, 'currency_symbol'], 99999);
		add_filter('woocommerce_price_format', [$this, 'currency_symbol_format'], 99999);
		add_action('woocommerce_coupon_loaded', [$this, 'coupon_amount_exchange'], 9999);
		add_filter('woocommerce_available_payment_gateways', [$this, 'payment_gateways']);
		add_filter('woocommerce_currency', [$this, 'currency_code']);
		add_filter('flash_sale_fixed_discount_amount', [$this, 'flash_sale_fixed_discount_amount']);
		add_filter('shopengine_product_filter_currency_symbol_format', [$this, 'currency_symbol_format']);
		add_filter('woocommerce_variation_prices', [$this, 'variation_product_regular_price'], 9999);
		add_filter('woocommerce_product_variation_get_price', [$this, 'product_price'], 9999);
		add_filter('woocommerce_product_variation_get_regular_price', [$this, 'product_price'], 9999);
		add_filter('shopengine_currency_exchange_rate', [$this, 'currency_exchange_rate']);
		add_filter('woocommerce_shipping_packages', [$this, 'shipping_cost_exchange']);
	}
	
	public function shipping_cost_exchange($packages){
		foreach($packages as $package) {
			foreach($package['rates'] as $rate) {
				$rate->set_cost($this->currency_switcher($rate->get_cost()));
			}
		}
		return $packages;
	}

	public function currency_exchange_rate($rate) {
		return $this->currency_rate;
	}

	public function product_price($price) {
		return $this->currency_switcher($price);
	}

	public function variation_product_regular_price($prices) {
		$updated_price = [];
		foreach($prices as $key => $values) {
			foreach($values as $k => $value) {
				$updated_price[$key][$k] = $this->currency_switcher($value); 
			}
		}
		if(empty($updated_price)){
			return $prices;
		}
		return $updated_price;
	}

	public function currency_code() {
		return strtoupper($this->currency_code);
	}

	public function payment_gateways($gateways) {
		$HTTP_REFERER = isset($_SERVER['HTTP_REFERER'])? sanitize_text_field(wp_unslash($_SERVER['HTTP_REFERER'])) : '';
		if (empty($HTTP_REFERER) || strpos($HTTP_REFERER, 'shopengine-template') === false) {
			if(is_array($this->payment_gateways)) {
				foreach ($this->payment_gateways as $gateway) {
					if (isset($gateways[$gateway])) {
						unset($gateways[$gateway]);
					}
				}
			}
		}
		return $gateways;
	}

	public function coupon_amount_exchange($coupon) {
		$type = $coupon->get_discount_type();
		if ($type === 'fixed_product' || $type === 'fixed_cart') {
			$coupon->set_amount($this->currency_switcher($coupon->get_amount()));
		}
		return $coupon;
	}

	public function price_decimals($decimal) {
		if ($this->currency_decimal) {
			return $this->currency_decimal;
		}
		return $decimal;
	}

	public function currency_symbol_format() {
		return $this->format;
	}

	public function price_icon_format() {

		if ($this->currency_position) {
			$position = $this->currency_position;
		} else {
			$position = 'left';
		}
		$format = '%1$s%2$s';
		switch ($position) {
			case 'left':
				$format = '%1$s%2$s';
				break;
			case 'right':
				$format = '%2$s%1$s';
				break;
			case 'left_space':
				$format = '%1$s&nbsp;%2$s';
				break;
			case 'right_space':
				$format = '%2$s&nbsp;%1$s';
				break;
		}
		$this->format = $format;
	}

	public function product_sale_price_exchange($price) {
		return $this->currency_switcher($price);
	}

	public function product_regular_price_exchange($price) {
		return $this->currency_switcher($price);
	}

	public function product_price_exchange($price) {
		return $this->currency_switcher($price);
	}

	public function filter_price_range($range) {
		$min = $this->currency_switcher($range[0]);
		$max = $this->currency_switcher($range[1]);
		return [floor($min), round($max)];
	}

	public function currency_symbol($symbol) {

		if ($this->widget_name === 'shopengine-thankyou-order-confirm' || $this->widget_name === 'shopengine-thankyou-order-details') {
			return $symbol;
		}
		return $this->currency_symbol;
	}

	public function currency_switcher($value) {
		if(!empty($value)) {
			return $this->currency_rate * (float)$value;
		}
		return $value;
	}

	private function currency_rate() {

		$curr = $this->find_currency($this->settings);
		$this->currency_code = $curr['code'];

		if (!empty($curr['currency']) && $curr['currency']['enable'] === 'yes') {
			$this->currency_symbol = $curr['currency']['symbol'];
			$this->currency_rate = $curr['currency']['rate'];
			$this->currency_position = $curr['currency']['position'];
			$this->currency_decimal = $curr['currency']['decimal'];
			$this->payment_gateways = $curr['currency']['payment_gateways'];
			$_SESSION['shopengine_currency_code'] = $this->currency_code;
		} else {
			$this->currency_rate = 1;
		}
	}

	public function find_currency($settings) {

		$codes = [];
		if (!empty($_GET['preview_nonce']) && !empty($_GET['shopengine_template_id'])) {
			if(!wp_verify_nonce(sanitize_text_field(wp_unslash($_GET['preview_nonce'])), 'template_preview_' . sanitize_text_field(wp_unslash($_GET['shopengine_template_id'])))){
				return;
			}
		}
		if (!empty($_GET['currency'])) {
			$codes[] = sanitize_text_field(wp_unslash($_GET['currency']));
		} 
		if(!empty($_SESSION['shopengine_currency_code'])) {
			$codes[] = sanitize_text_field($_SESSION['shopengine_currency_code']);
		}
		if(!empty($settings['default_currency']['value'])) {
			$codes[] = $settings['default_currency']['value'];
		}
		$currency = '';
		$code = 'USD';
		foreach($codes as $value) {
			$curr = $this->get_currency($value, $settings);
			if(!empty($curr)) {
				$currency = $curr;
				$code = $value;
				break;
			}
		}
		if($currency === '') {
			if(!empty($settings['currencies']['value'][0])){
				$currency = $settings['currencies']['value'][0];
			}
		}

		return ['currency' => $currency, 'code' => $code];
	}

	public function flash_sale_fixed_discount_amount($amount) {
		return $this->currency_switcher($amount);
	}

	private function get_currency($code, $settings) {
		$_currency = [];
		foreach ($settings['currencies']['value'] as $currency) {
			if($currency['code'] == $code) {
				$_currency = $currency;
			}
		}
		return $_currency;
	} 
}
