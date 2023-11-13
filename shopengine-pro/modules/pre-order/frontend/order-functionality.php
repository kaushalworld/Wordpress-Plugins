<?php

namespace ShopEngine_Pro\Modules\Pre_Order\Frontend;

use ShopEngine;
use ShopEngine_Pro\Modules\Pre_Order\Settings\Pre_Order_Settings;
use WC_Order;
use WC_Order_Item_Product;

defined( 'ABSPATH' ) || exit;

class Order_Functionality {

	/**
	 * Pre_Order_Settings object
	 */
	private $settings;

	public function __construct() {
		$this->settings = Pre_Order_Settings::instance();
	}


	public function init() {

		add_filter( 'woocommerce_checkout_create_order', [ $this, 'add_pre_order_data_to_order' ], 10, 2 );
		add_filter( 'woocommerce_checkout_create_order_line_item', [ $this, 'add_pre_order_meta_to_item' ], 10, 4 );
	}

	public function add_pre_order_data_to_order( WC_Order $order, $checkout_data ) {

		if ( $this->settings->has_pre_order_in_cart() ) {
			$order->update_meta_data( 'shopengine_pre_order', 'yes' );
		}
	}

	public function add_pre_order_meta_to_item( WC_Order_Item_Product $item, $cart_item_key, $values, $order ) {

		$cart_item = WC()->cart->get_cart()[ $cart_item_key ];

		if ( isset( $cart_item['pre_order_status'] ) && $cart_item['pre_order_status'] == true ) {
			
			$item->update_meta_data( 'shopengine_pre_order_item', 'yes' );

			$this->settings->product_id = isset($cart_item['variation_id']) &&  $cart_item['variation_id'] > 0 ?  $cart_item['variation_id'] : $cart_item['product_id'];
		 
			// for calculating remaining Item
			$variantID =isset($cart_item['variation_id']) &&  $cart_item['variation_id'] > 0 ?  $cart_item['variation_id'] : null ;
			$productID = $cart_item['product_id'];

			$remaining_amount =  $this->settings->get_remaining_items($productID, $variantID );

			$quantity = (int)$cart_item['quantity'] ;

			$booked_amount =  get_post_meta( $this->settings->product_id, 'shopengine_pre_order_booked_items', true );
 
			if ( $remaining_amount < $quantity ) {
			 throw new \Exception( "Pre-Order Item already Booked" );
			}

			$new_booked_items = ( $booked_amount ? (int)$booked_amount : 0 ) + $quantity;

			if ( $booked_amount ) {
				update_post_meta( $this->settings->product_id, 'shopengine_pre_order_booked_items', $new_booked_items );
			}else{
				add_post_meta( $this->settings->product_id, 'shopengine_pre_order_booked_items', $new_booked_items );	
			}	

		}
	}
}