<?php


namespace ShopEngine_Pro\Modules\Partial_Payment\Frontend\Order;


use Exception;
use ShopEngine\Utils\Helper;
use ShopEngine_Pro\Modules\Partial_Payment\Frontend\Order\Sub_Order\Create_Schedule_Payment;
use ShopEngine_Pro\Modules\Partial_Payment\Settings\Partial_Payment_Data;
use WC_Geolocation;
use WC_Order;
use WP_Error;

class Create_Order {

	/**
	 * instance of Partial_Payment_Data() object;
	 * @var
	 */
	private $data;

	/**
	 * Partial_Payment_Cart constructor.
	 *
	 * @param Partial_Payment_Data $data
	 */
	public function __construct( Partial_Payment_Data $data ) {
		$this->data = $data;
	}


	public function create( $checkoutObject ) {

		try {

			$this->check_guest_checkout();

			// partial data with  class Partial_Payment_Data class
			$this->data->set_partial_subtotal();

			$data = $checkoutObject->get_posted_data();

			$order_id           = absint( WC()->session->get( 'order_awaiting_payment' ) );
			$cart_hash          = WC()->cart->get_cart_hash();
			$available_gateways = WC()->payment_gateways->get_available_payment_gateways();
			$order              = $order_id ? wc_get_order( $order_id ) : null;

			/**
			 * If there is an order pending payment, we can resume it here so
			 * long as it has not changed. If the order has changed, i.e.
			 * different items or cost, create a new order. We use a hash to
			 * detect changes which is based on cart items + order total.
			 */
			if ( $order && $order->has_cart_hash( $cart_hash ) && $order->has_status( array( 'pending', 'failed' ) ) ) {
				// Action for 3rd parties.
				do_action( 'woocommerce_resume_order', $order_id );

				// Remove all items - we will re-add them later.
				$order->remove_order_items();
			} else {
				$order = new WC_Order();
			}

			$fields_prefix = array(
				'shipping' => true,
				'billing'  => true,
			);

			$shipping_fields = array(
				'shipping_method' => true,
				'shipping_total'  => true,
				'shipping_tax'    => true,
			);
			foreach ( $data as $key => $value ) {
				if ( is_callable( array( $order, "set_{$key}" ) ) ) {
					$order->{"set_{$key}"}( $value );
					// Store custom fields prefixed with wither shipping_ or billing_. This is for backwards compatibility with 2.6.x.
				} elseif ( isset( $fields_prefix[ current( explode( '_', $key ) ) ] ) ) {
					if ( ! isset( $shipping_fields[ $key ] ) ) {
						$order->update_meta_data( '_' . $key, $value );
					}
				}
			}

			$order->hold_applied_coupons( $data['billing_email'] );
			$order->set_created_via( 'checkout' );
			$order->set_cart_hash( $cart_hash );
			$order->set_customer_id( apply_filters( 'woocommerce_checkout_customer_id', get_current_user_id() ) );
			$order->set_currency( get_woocommerce_currency() );
			$order->set_prices_include_tax( 'yes' === get_option( 'woocommerce_prices_include_tax' ) );
			$order->set_customer_ip_address( WC_Geolocation::get_ip_address() );
			$order->set_customer_user_agent( wc_get_user_agent() );
			$order->set_customer_note( isset( $data['order_comments'] ) ? $data['order_comments'] : '' );
			$order->set_payment_method( '' );
			$checkoutObject->set_data_from_cart( $order );

			$order_total = WC()->cart->get_total( 'f' );

			$due_amount = $order_total - $this->data->subtotal_first_payment;

			/**
			 * Action hook to adjust order before save.
			 *
			 * @since 3.0.0
			 */
			do_action( 'woocommerce_checkout_create_order', $order, $data );

			// Save the order.
			$order_id = $order->save();

			/**
			 * Action hook fired after an order is created used to add custom meta to the order.
			 *
			 * @since 3.0.0
			 */
			do_action( 'woocommerce_checkout_update_order_meta', $order_id, $data );


			// partial deposit sub-order
			$item_name                   = esc_html__( 'Partial Payment (Deposit Amount) for order #' . $order_id, 'shopengine-pro' );
			$partial_payment_first_order = new Create_Schedule_Payment( $order_id, $this->data->subtotal_first_payment, $item_name );

			$meta = [
				[
					"key"   => "order_partial_payment_status",
					"value" => "yes",
				],
				[
					"key"   => "installment",
					"value" => "first",
				]
			];

			$available_gateways      = WC()->payment_gateways->get_available_payment_gateways();
			$selected_payment_method = $data['payment_method'];
			$payment_method          = isset( $available_gateways[ $selected_payment_method ] ) ? $available_gateways[ $selected_payment_method ] : $selected_payment_method;


			$partial_payment_first_order->create( $meta, $payment_method );

			// Due Amount sub-order
			$item_name                    = esc_html__( 'Partial Payment (Rest amount without first deposit) #' . $order_id, 'shopengine-pro' );
			$partial_payment_second_order = new Create_Schedule_Payment( $order_id, $due_amount, $item_name );

			$meta = [
				[
					"key"   => "order_partial_payment_status",
					"value" => "yes",
				],
				[
					"key"   => "installment",
					"value" => "second",
				]
			];

			$partial_payment_second_order->create( $meta );

			$main_order = wc_get_order( $order_id );
			$main_order->update_meta_data( 'order_partial_payment_status', 'yes' );
			$main_order->update_meta_data( 'order_partial_payment_parent_order', 'yes' );
			$main_order->update_meta_data( 'partial_payment_order_total_amount', $order_total );
			$main_order->update_meta_data( 'partial_payment_first_installment', $this->data->subtotal_first_payment );
			$main_order->update_meta_data( 'partial_payment_second_installment', $due_amount );
			$main_order->update_meta_data( 'partial_payment_paid_amount', 0 );
			$main_order->update_meta_data( 'partial_payment_due_amount', $order_total );
			$main_order->update_meta_data( 'first_installment_paid', 'no' );
			$main_order->update_meta_data( 'second_installment_paid', 'no' );
			$main_order->save();

			return absint( $partial_payment_first_order->order_id );


			//  return $order_id;

		} catch ( Exception $e ) { 
			return new WP_Error( 'checkout-error', $e->getMessage() );
		}
	}


	private function check_guest_checkout() {

	 	if ( Helper::is_guest_checkout_allowed() && ! is_user_logged_in() ) {

			    $url = home_url('my-account').'?redirect_to='.home_url('checkout');
				$order = esc_html__("Login For Order","shopengine-pro");

			    wc_add_notice(
				    sprintf('<div class="">'.esc_html__('Please login from', 'shopengine-pro').'<a title="' . $order . '" href="%s">'.esc_html__('here', 'shopengine-pro').'</a></div>', $url),
				    'error'
			    );

			throw new Exception( esc_html__("You must be logged in to checkout for partial payment", 'shopengine-pro') );
	 	}
	}
}
