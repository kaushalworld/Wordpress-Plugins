<?php

namespace ShopEngine_Pro\Modules\Pre_Order\Admin;

use ShopEngine_Pro;
use ShopEngine_Pro\Modules\Pre_Order\Settings\Pre_Order_Settings;
use WC_Product_Variation;

defined( 'ABSPATH' ) || exit;

class Pre_Order_Admin_Fields_Process {

	/**
	 * Pre_Order_Settings object
	 */
	private $settings;

	public function __construct( Pre_Order_Settings $settings ) {
		$this->settings = $settings;
		$this->init();
	}


	public function init() {

		/**
		 * update pre-order meta data coming form pre-order fields
		 * @for simple product
		 */
		add_action( 'woocommerce_process_product_meta', [ $this, 'save_partial_payment_product_meta' ] );

		/**
		 * update pre-order meta data coming form pre-order fields
		 * @for variant  product
		 */
		add_action( 'woocommerce_save_product_variation', [ $this, 'save_variation_settings_fields' ], 10, 2 );


		/**
		 * save simple product event
		 * @for setting sale price of simple product when stock status is pre_order and sale price from pre-order price.
		 */
		add_action( 'save_post', [ $this, 'change_sale_price_from_pre_order_price' ], 10, 2 );

		/**
		 * save variant product event
		 * @for setting sale price of variant product when stock status is pre_order and sale price from pre-order price.
		 */
		add_action( 'woocommerce_save_product_variation', [
			$this,
			'change_variant_sale_price_from_pre_order_price'
		], 12, 2 );
	}


	/**
	 * update sale price when set price for pre-order (Less than regular price)
	 *
	 * @param $product_id
	 * @param $post
	 *
	 * @return mixed
	 */
	public function change_sale_price_from_pre_order_price( $product_id, $post ) {

		if(!isset($_POST['_wpnonce']) || !isset($_POST['post_ID']) || !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['_wpnonce'])),'update-post_'.sanitize_text_field(wp_unslash($_POST['post_ID'])))){
			return false;
		}

		$this->settings->product_id = $product_id;

		$product = wc_get_product( $product_id );

		if(!$product){
			return false;
		}

		if ( $this->settings->get_status() == 'yes' ) {

			$sale_price_meta = (float) get_post_meta( $product_id, 'shopengine_pre_order_price', true );

			if ( $sale_price_meta && ( $sale_price_meta > 0 ) ) {

				if ( ( $product->get_sale_price() != $sale_price_meta ) ) {

					$product->set_sale_price( $sale_price_meta );
					$product->save();

				}

			}

		} else if ( isset( $_POST['shopengine_pre_order_price'] ) && sanitize_text_field(wp_unslash($_POST['shopengine_pre_order_price'] ))) {

			/**
			 * change sale price null
			 *  because if user change stock status change from pre_order to another then "shopengine_pre_order_price" field must have value
			 *  because we do not change value after stock_status changed
			 *  this context will be fired when user change stock status and have value in "shopengine_pre_order_price" field
			 */
			$product->set_sale_price( '' );
			$product->save();
		}
	}


	/**
	 * update sale price when set price for pre-order (Less than regular price)
	 * @for variant product
	 *
	 * @param $variation_id
	 * @param $loop
	 *
	 * @return mixed
	 */
	public function change_variant_sale_price_from_pre_order_price( $variation_id, $loop ) {
		
		check_ajax_referer('save-variations','security');

		$this->settings->product_id = $variation_id;

		$product = new WC_Product_Variation( $variation_id );

		if(!$product){
			return false;
		}
		if(isset($_POST['shopengine_pre_order_price'][ $loop ])){
			$pre_order_price = sanitize_text_field(wp_unslash($_POST['shopengine_pre_order_price'][ $loop ])) ?? 0;
		}

		if ( $this->settings->get_status() == 'yes' && $pre_order_price ) {

			if ( $product->get_sale_price() != $pre_order_price ) {

				$product->set_sale_price( $pre_order_price );
				$product->save();

			}

		} else if ( $pre_order_price > 0 ) {

			/**
			 * change sale price null
			 *  because if user change stock status change from pre_order to another then "shopengine_pre_order_price" field must have value
			 *  because we do not change value after stock_status changed
			 *  this context will be fired when user change stock status and have value in "shopengine_pre_order_price" field
			 */
			$product->set_sale_price( '' );
			$product->save();
		}
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


	public function save_variation_settings_fields( $variation_id, $loop ) {
		
		check_ajax_referer('save-variations','security');
		
		$post_id = $variation_id;

		if($variation_id < 1){
			return false;
		}

		if ( isset( $_POST['variable_stock_status'][ $loop ] ) && ( 'pre_order' == $_POST['variable_stock_status'][ $loop ] ) ) {

			update_post_meta(
				$post_id,
				'shopengine_pre_order_status',
				'yes'
			);
			if(isset($_POST['shopengine_pre_order_max_order'][ $loop ])){
				$max_order = sanitize_text_field(wp_unslash($_POST['shopengine_pre_order_max_order'][ $loop ])) ?? null;
			}
			if ( $max_order && (int) $max_order ) {

				update_post_meta(
					$post_id,
					'shopengine_pre_order_max_order',
					$max_order
				);

			}
			if(isset($_POST['shopengine_pre_order_available_date'][ $loop ])){
				$available_date = sanitize_text_field(wp_unslash($_POST['shopengine_pre_order_available_date'][ $loop ])) ?? null;
			}
			if ( $available_date && $this->validateDate( $available_date ) ) {

				update_post_meta(
					$post_id,
					'shopengine_pre_order_available_date',
					$available_date
				);

			} else {

				delete_post_meta( $post_id, 'shopengine_pre_order_available_date' );

			}
			if(isset($_POST['shopengine_pre_order_price'][ $loop ])){
				$price = sanitize_text_field(wp_unslash($_POST['shopengine_pre_order_price'][ $loop ])) ?? null;
			}
			if ( $price && (float) $price > 0 ) {

				update_post_meta(
					$post_id,
					'shopengine_pre_order_price',
					$price
				);

			} else {
				delete_post_meta( $post_id, 'shopengine_pre_order_price' );
			}

			if ( isset( $_POST['shopengine_pre_order_product_message'][ $loop ] ) ) {
				update_post_meta(
					$post_id,
					'shopengine_pre_order_product_message',
					sanitize_text_field(wp_unslash($_POST['shopengine_pre_order_product_message'][ $loop ]))
				);
			}
			if(isset($_POST['shopengine_pre_order_auto_convert'][ $loop ])){
				$auto_convert = sanitize_text_field(wp_unslash($_POST['shopengine_pre_order_auto_convert'][ $loop ])) ?? null;
			}
			if ( $auto_convert ) {
				update_post_meta(
					$post_id,
					'shopengine_pre_order_auto_convert',
					sanitize_text_field($auto_convert)
				);
			}

		} else {

			delete_post_meta( $post_id, 'shopengine_pre_order_status' );
			delete_post_meta( $post_id, 'shopengine_pre_order_max_order' );
			delete_post_meta( $post_id, 'shopengine_pre_order_available_date' );
			delete_post_meta( $post_id, 'shopengine_pre_order_price' );
			delete_post_meta( $post_id, 'shopengine_pre_order_remaining_items' );
			delete_post_meta( $post_id, 'shopengine_pre_order_product_message' );
			delete_post_meta( $post_id, 'shopengine_pre_order_auto_convert' );

			return false;
		}
	}


	public function save_partial_payment_product_meta( $post_id ) {
		
		if(!isset($_POST['_wpnonce']) || !isset($_POST['post_ID']) || !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['_wpnonce'])),'update-post_'.sanitize_text_field(wp_unslash($_POST['post_ID'])))){
			return false;
		}

		/**
		 * remove previous product meta for pre-order
		 */
		delete_post_meta( $post_id, 'shopengine_pre_order_status' );

		if ( isset( $_POST['_stock_status'] ) && ( 'pre_order' == $_POST['_stock_status'] ) && !isset( $_POST['variable_stock_status'] ) ) {

			update_post_meta(
				$post_id,
				'shopengine_pre_order_status',
				'yes'
			);
			if(isset($_POST['shopengine_pre_order_max_order'])){
				$max_order = sanitize_text_field(wp_unslash($_POST['shopengine_pre_order_max_order'])) ?? null;
			}
			if ( $max_order && (int) $max_order ) {

				update_post_meta(
					$post_id,
					'shopengine_pre_order_max_order',
					$max_order
				);

			} else {
				delete_post_meta( $post_id, 'shopengine_pre_order_max_order' );
			}
			if(isset($_POST['shopengine_pre_order_available_date'])){
				$available_date = sanitize_text_field(wp_unslash($_POST['shopengine_pre_order_available_date'])) ?? null;
			}
			if ( $available_date && $this->validateDate( $available_date ) ) {

				update_post_meta(
					$post_id,
					'shopengine_pre_order_available_date',
					$available_date
				);

			} else {
				delete_post_meta( $post_id, 'shopengine_pre_order_price' );
			}
			if(isset($_POST['shopengine_pre_order_price'])){
				$price = sanitize_text_field(wp_unslash($_POST['shopengine_pre_order_price'])) ?? null;
			}
			if ( $price && (int) $price ) {

				update_post_meta(
					$post_id,
					'shopengine_pre_order_price',
					$price
				);

			} else {
				delete_post_meta( $post_id, 'shopengine_pre_order_price' );
			}
			if(isset($_POST['shopengine_pre_order_product_message'])){
				$message = sanitize_text_field(wp_unslash($_POST['shopengine_pre_order_product_message'])) ?? null;
			}
			if ( $message ) {
				update_post_meta(
					$post_id,
					'shopengine_pre_order_product_message',
					$message
				);
			}
			$auto_convert = isset($_POST['shopengine_pre_order_auto_convert']) ? sanitize_text_field(wp_unslash($_POST['shopengine_pre_order_auto_convert'])) : null;
			if ( $auto_convert ) {
				update_post_meta(
					$post_id,
					'shopengine_pre_order_auto_convert',
					$auto_convert
				);
			}


		} else {

			delete_post_meta( $post_id, 'shopengine_pre_order_status' );
			delete_post_meta( $post_id, 'shopengine_pre_order_max_order' );
			delete_post_meta( $post_id, 'shopengine_pre_order_available_date' );
			delete_post_meta( $post_id, 'shopengine_pre_order_price' );
			delete_post_meta( $post_id, 'shopengine_pre_order_remaining_items' );
			delete_post_meta( $post_id, 'shopengine_pre_order_product_message' );
			delete_post_meta( $post_id, 'shopengine_pre_order_auto_convert' );

			return false;
		}
	}
}