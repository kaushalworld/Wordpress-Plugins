<?php

namespace ShopEngine_Pro\Modules\Pre_Order\Settings;


use ShopEngine\Core\Register\Module_List;
use ShopEngine_Pro\Traits\Singleton;
use WC_Product_Variation;

defined( 'ABSPATH' ) || exit;

class Pre_Order_Settings {
	use Singleton;

	public $product_id;
	public $pre_order_label;
	public $pre_order_closed_label;
	public $pre_order_countdown_status;
	public $pre_order_countdown_label;
	public $pre_order_primary_color;
	public $pre_order_radius;
	public $product;


	public function __construct() {

		$settings = Module_List::instance()->get_settings( 'pre-order' );

		$this->pre_order_label            = !empty($settings['pre_order_label']['value']) ? shopengine_pro_translator('pre-order__pre_order_label', $settings['pre_order_label']['value']) : esc_html__('Pre-Order', 'shopengine-pro');
		$this->pre_order_closed_label     = !empty($settings['pre_order_closed_label']['value']) ? shopengine_pro_translator('pre-order__pre_order_closed_label', $settings['pre_order_closed_label']['value']) : esc_html__('Pre-Order Closed', 'shopengine-pro');
		$this->pre_order_countdown_status = $settings['pre_order_countdown_status']['value'] ?? 'yes';
		$this->pre_order_countdown_label  = !empty($settings['pre_order_countdown_label']['value']) ? shopengine_pro_translator('pre-order__pre_order_countdown_label', $settings['pre_order_countdown_label']['value']) : esc_html__('Pre-Order Countdown', 'shopengine-pro');
		$this->pre_order_primary_color	  = $settings['pre_order_primary_color']['value'] ?? '#101010';
		$this->pre_order_radius	  		  = $settings['pre_order_radius']['value'] ?? '4';
	}

	public function get_status() {
		return get_post_meta( $this->product_id, 'shopengine_pre_order_status', true );
	}

	public function get_max_order() {
		return get_post_meta( $this->product_id, 'shopengine_pre_order_max_order', true );
	}

	public function get_available_date() {
		return get_post_meta( $this->product_id, 'shopengine_pre_order_available_date', true );
	}
 
	public function get_price() {
		return get_post_meta( $this->product_id, 'shopengine_pre_order_price', true );
	}
 
	public function get_booked_amount($product_id, $variation_id = null) {
		return Remaining_Order::instance()->booked_Orders( $product_id, $variation_id );
	}
 	
	public function get_remaining_items($product_id, $variation_id = null) {
		
		$allowed_order =  $this->get_max_order() ;

		$booked_item = $this->get_booked_amount($product_id, $variation_id);

		return (int)$allowed_order - ( $booked_item ? $booked_item : 0 );
	}
 
	public function get_product_message() {
		$message =  get_post_meta( $this->product_id, 'shopengine_pre_order_product_message', true );
		return $message ? $message : "Available On [available_date]" ;
	}

	public function validateDate( $date, $format = 'Y-m-d' )
	{
		try {
			$d = \DateTime::createFromFormat($format, $date);
			return $d && $d->format($format) == $date;
		}catch (\Exception $error){
			return false;
		}
	}

	public function pre_order_is_closed( $quantity = 1 ) {

		$status = false;

		$available_date = $this->get_available_date();

		if(! $available_date ){
		return true;
		}

		if( !is_string($available_date) && !$this->validateDate($available_date) ){
			return true;
		}

		if ( $available_date && ( strtotime( $available_date ) <= strtotime( date( 'Y-m-d' ) ) ) ) {
			$status = true;

			/**
			 * check and auto update product to standard product( disable pre-order)
			 */
			$this->convert_to_standard_product();

		} else {

			if(!$this->product){
				$this->set_product( $this->product_id ) 	;
			}

			$variation_id =  null ;
			$product_id =  $this->product_id ;

		 	if( $this->product->get_parent_id() ){
				// variant product id

				$variation_id =   $this->product_id;
			    $product_id =   $this->product->get_parent_id();

			}

			if ( $this->get_remaining_items($product_id, $variation_id) < $quantity ) $status = true;
			
		}

		return $status;
	}

	public function has_pre_order_in_cart() {
		$status = false;
		if( !WC()->cart ){
			return $status;
		}
		
		foreach ( WC()->cart->get_cart() as $cart_item ) {
			if ( isset( $cart_item['pre_order_status'] ) && $cart_item['pre_order_status'] == true ) {
				$status = true;
			}
		}

		return $status;
	}



	private function convert_to_standard_product(){

		if( get_post_meta( $this->product_id, 'shopengine_pre_order_auto_convert', true ) == 'yes' ){

			if(!$this->product){
				$this->set_product( $this->product_id ) 	;
			}

		    delete_post_meta( $this->product_id, 'shopengine_pre_order_status' );
			delete_post_meta( $this->product_id, 'shopengine_pre_order_max_order' );
			delete_post_meta( $this->product_id, 'shopengine_pre_order_available_date' );
			delete_post_meta( $this->product_id, 'shopengine_pre_order_price' );
			delete_post_meta( $this->product_id, 'shopengine_pre_order_remaining_items' );
			delete_post_meta( $this->product_id, 'shopengine_pre_order_product_message' );
			delete_post_meta( $this->product_id, 'shopengine_pre_order_auto_convert' );

			$this->product->set_stock_status('instock');
			$this->product->save();

		}
	}

	/**
	 * set product
	 *
	 * @param $product_id
	 * @param null $variant_id
	 */
	public function set_product( $product_id, $is_variant_product = false ) {
		$this->product_id = $product_id;

		if($is_variant_product){
			$this->product = new WC_Product_Variation( $product_id );
		}else{
			$this->product = wc_get_product( $product_id );
		}
	}

}