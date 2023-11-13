<?php

namespace ShopEngine_Pro\Modules\Flash_Sale;

use ShopEngine\Core\Register\Module_List;
use ShopEngine_Pro\Modules\Flash_Sale\Base\Flash_Sale_Backend;
use ShopEngine_Pro\Modules\Flash_Sale\Base\Flash_Sale_Frontend;
use ShopEngine_Pro\Traits\Singleton;

class Flash_Sale_Countdown {

	use Singleton;

	private $flash_sale_events;
	private $price;
	private $regular_price;
	private $is_sale;
	private $override_woocommerce_sale;
	private $categories;
	private $discount_limit_type;

	public function init() {
		new Route();
		// $this->product_quantity_limit_check();
		$this->flash_sale_events();
		if(is_admin()) {
			Flash_Sale_Backend::instance()->init($this->flash_sale_events, $this->override_woocommerce_sale);
		}else {
			Flash_Sale_Frontend::instance()->init($this->flash_sale_events, $this->override_woocommerce_sale);
		}
	}

	// public function product_quantity_limit_check() {
    // 	$items = WC()->cart->get_cart();
	// 	error_log(print_r($items, true));
	// 	remove_action( 'woocommerce_checkout_order_review', 'woocommerce_checkout_payment', 20 );
	// }

	public function flash_sale_events() {
		$settings = Module_List::instance()->get_settings('flash-sale-countdown');
		$this->flash_sale_events = self::flash_sale_campaign($settings);
		$this->override_woocommerce_sale = $settings['override_woocommerce_sale']['value'];
	}

	public static function flash_sale_campaign($settings) {
		$e = [];
		foreach($settings['flash_sale']['value'] as $value) {
			if(!empty($value['start_date'])) {
				$start_date = strtotime($value['start_date'].' 00:00:00');
			}else {
				$start_date = time() - 1;
			}
			if(empty($value['end_date'])) {
				continue;
			}
			$end_date = strtotime($value['end_date'].' 24:00:00');
			if($start_date < time() && $end_date > time()) {
				if (!empty($value['user_roles'])) {
					if (is_user_logged_in()) {
						$user_data = wp_get_current_user();
						$user_role = $user_data->roles[0];
					}else {
						$user_role = 'customer';
					}
					if (!in_array($user_role, $value['user_roles'])) {
						continue;
					}
				}
				if (!empty($value['category_list'])) {
					$query_args = array(
						'post_status' => 'publish', 
						'post_type' => 'product',
						'posts_per_page'=> -1,
						'tax_query' => array(
							array(
									'taxonomy' => 'product_cat',
									'field' => 'id',
									'terms' => $value['category_list'],
							)
						)
					);
					$products = new \WP_Query($query_args);
					foreach($products->posts as $product) {
						if (!in_array($product->ID, $value['product_list'])) {
							$value['product_list'][] = $product->ID;
						}
					}
				}
				if(isset($value['uid'])) {
					$e[$value['uid']] = $value;
				}else {
					$e[] = $value;
				}
			}
		}
		return $e;
	}

	public static function is_product_flash_sale($flash_sale_events, $product_id) {
		foreach($flash_sale_events as $event) {
			if (!empty($event['category_list'])) {
				$query_args = array(
					'post_status' => 'publish', 
					'post_type' => 'product',
					'tax_query' => array(
						array(
								'taxonomy' => 'product_cat',
								'field' => 'id',
								'terms' => $event['category_list'],
						)
					)
				);
				$products = new \WP_Query($query_args);
				foreach($products->posts as $product) {
					if (!in_array($product->ID, $event['product_list'])) {
						$event['product_list'][] = $product->ID;
					}
				}
			}
			if (!empty($event['product_list']) && ! is_admin()) {
				foreach($event['product_list'] as $single_product){
					$product = wc_get_product($single_product);

					if( method_exists($product, 'get_children') ){						
						foreach($product->get_children() as $child_product){
							if (!in_array($child_product, $event['product_list'])) {
								$event['product_list'][] = $child_product;
							}
						}
					}
				}
			}
		
			if (in_array($product_id, $event['product_list'])) {
				return $event;
			}
		}
		return null;
	}
}