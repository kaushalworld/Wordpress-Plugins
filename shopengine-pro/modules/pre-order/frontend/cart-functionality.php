<?php

namespace ShopEngine_Pro\Modules\Pre_Order\Frontend;

use ShopEngine_Pro\Modules\Pre_Order\Settings\Pre_Order_Settings;
use WC_Cart;

defined( 'ABSPATH' ) || exit;

class Cart_Functionality {

	/**
	 * Pre_Order_Settings object
	 */
	private $settings;

	public function __construct() {
		$this->settings = Pre_Order_Settings::instance();
	}


	public function init() {

		add_filter( 'woocommerce_add_cart_item_data', [ $this, 'add_pre_order_to_cart' ], 10, 6 );
		add_filter( 'woocommerce_add_to_cart', [ $this, 'validate_pre_order_item' ], 10, 6 );
		add_filter( 'woocommerce_before_calculate_totals', [ $this, 'validate_pre_order_item_quantity' ], 10, 1 );
		add_filter( 'woocommerce_cart_item_name', [ $this, 'woocommerce_cart_item_name' ], 10, 4 );
	}


	public function woocommerce_cart_item_name( $name, $cart_item, $cart_item_key ) {

		$variant_id = isset($cart_item['variation_id']) && (int)$cart_item['variation_id'] > 0 ? $cart_item['variation_id'] : null;
		$this->settings->product_id = $variant_id ?? $cart_item['product_id'];

		if($variant_id){
			$this->settings->set_product( $variant_id, true );
		}

		if ( $this->settings->get_status() === 'yes' && isset( $cart_item['pre_order_status'] ) && !$this->settings->pre_order_is_closed()) {

			$pre_order_content = "<span class='shopengine-pre-order-product-badge'>{$this->settings->pre_order_label}</span>";

			return $name . $pre_order_content;

		}

		return $name ;
	}

	public function add_pre_order_to_cart( $cart_item_data, $product_id, $variation_id, $quantity ) {

		$variant_id = (int)$variation_id ? $variation_id : null;
		$this->settings->product_id = $variant_id ?? $product_id;

		if($variant_id){
			$this->settings->set_product( $variant_id, true );
		}


		if ( $this->settings->get_status() === 'yes' && !$this->settings->pre_order_is_closed( $quantity ) ) {
			$cart_item_data[ 'pre_order_status' ] = true;
		}

		return $cart_item_data;
	}


	public function validate_pre_order_item( $cart_item_key, $product_id, $quantity, $variation_id, $variation, $cart_item_data ) {

		if( $this->settings->get_status() === 'yes' ){

			$validateKey =   $this->validate_duplicate_item($cart_item_key, $product_id, $variation_id) ;
			if( $validateKey ){
				throw new \Exception( esc_html__("Item already exist in cart", 'shopengine-pro') );
			}
		}

		$cart_item = WC()->cart->get_cart()[ $cart_item_key ] ;


		$variant_id = (int)$variation_id ? $variation_id : null;
		$this->settings->product_id = $variant_id ?? $cart_item['product_id'];

		if($variant_id){
			$this->settings->set_product( $variant_id, true );
		}


		if ( $this->settings->get_status() === 'yes' && $this->settings->pre_order_is_closed( $cart_item['quantity'] ) ) {
			throw new \Exception(  esc_html__("Pre-Order Item quantity exceeded", 'shopengine-pro'));
		}
	}

	private function validate_duplicate_item($cart_item_key, $product_id, $variation_id){

		$existingID = null ;

		foreach ( WC()->cart->get_cart() as $key => $cart_item ) {
			if($key !== $cart_item_key){

				if( ($cart_item['product_id'] == $product_id) && ($cart_item['variation_id'] == $variation_id) ){
					$existingID =  $key ;
				}

			}
		}

		return $existingID;
	}


	public function validate_pre_order_item_quantity( WC_Cart $cart ) {

		$quantity_exceeded = false;

		foreach ( $cart->get_cart() as $key => $cart_item ) {

			$this->settings->product_id = isset( $cart_item['variation_id'] ) && $cart_item['variation_id'] > 0 ? $cart_item['variation_id'] : $cart_item['product_id'];

			if ( $this->settings->get_status() === 'yes' ) {

				// for calculating remaining Item
				$variantID = isset( $cart_item['variation_id'] ) && $cart_item['variation_id'] > 0 ? $cart_item['variation_id'] : null;
				$productID = $cart_item['product_id'];
				$quantity  = (int) $cart_item['quantity'];

				$remaining_amount = $this->settings->get_remaining_items( $productID, $variantID )  ;


				if ( $remaining_amount < $quantity ) {
					$quantity_exceeded = true;
					WC()->cart->set_quantity( $key, $remaining_amount, false );
				}
			}
		}

		if ( $quantity_exceeded ) {
			wc_add_notice( esc_html__( "Pre-Order Item quantity exceeded", 'shopengine-pro'), 'error' );
		}
	}
}