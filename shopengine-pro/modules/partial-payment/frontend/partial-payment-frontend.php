<?php

namespace ShopEngine_Pro\Modules\Partial_Payment\Frontend;

use ShopEngine\Traits\Singleton;
use ShopEngine_Pro;
use ShopEngine_Pro\Modules\Partial_Payment\Frontend\Cart\Partial_Payment_Cart;
use ShopEngine_Pro\Modules\Partial_Payment\Frontend\Checkout\Partial_Payment_Checkout;
use ShopEngine_Pro\Modules\Partial_Payment\Frontend\Order\Partial_Payment_Order;

defined( 'ABSPATH' ) || exit;

class Partial_Payment_Frontend {
	use Singleton;

	public function init() {


		add_action( 'wp_enqueue_scripts', [ $this, 'add_enqueue' ] );

		$cart_functionalities = new Partial_Payment_Cart();
		$cart_functionalities->init();

		$checkout_functionalities = new Partial_Payment_Checkout();
		$checkout_functionalities->init();

		$order_functionalities = new Partial_Payment_Order();
		$order_functionalities->init();

		add_action('woocommerce_my_account_my_orders_actions', [$this, 'hide_payment_button'], 10, 2);
	}

	/**
	 * remove payment button from order list in my-account for partial payment parent order
	 * @param $actions
	 * @param $order
	 *
	 * @return mixed
	 */
	public function hide_payment_button($actions, $order){

		if ( $order->get_meta( 'order_partial_payment_status' ) == 'yes' &&  $order->get_meta( 'order_partial_payment_parent_order' ) == 'yes' && $order->needs_payment() ) {
			unset( $actions['pay'] );
		}

		return $actions;
	}

	/**
	 * add partial payment css & js
	 */
	public function add_enqueue() {
		wp_enqueue_script( 'partial-payment-js', ShopEngine_Pro::module_url() . 'partial-payment/assets/js/partial-payment-frontend.js', [
			'jquery',
		] );
		wp_enqueue_style( 'partial-payment-module-css', ShopEngine_Pro::module_url() . 'partial-payment/assets/css/partial-payment.css', [], ShopEngine_Pro::version() );
	}

}