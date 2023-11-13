<?php

namespace ShopEngine_Pro\Modules\Partial_Payment\Frontend\Order;

use ShopEngine_Pro\Modules\Partial_Payment\Settings\Partial_Payment_Data;
use WC_Data_Exception;
use WC_Order;

defined( 'ABSPATH' ) || exit;

class Partial_Payment_Order {


	/**
	 * instance of Partial_Payment_Data() object;
	 * @var
	 */
	private $data;

	/**
	 * Partial_Payment_Checkout constructor.
	 *
	 */
	public function __construct() {
		$this->data = Partial_Payment_Data::instance();
	}

	public function init() {

		add_filter( 'woocommerce_checkout_create_order_line_item', [ $this, 'add_pre_order_meta_to_item' ], 10, 4 );

		add_action( 'woocommerce_create_order', [ $this, 'create_order' ], 10, 2 );

		add_filter( 'woocommerce_get_order_item_totals', [ $this, 'update_single_order_details' ], 10, 2 );
		add_action( 'woocommerce_order_details_after_order_table', [ $this, 'add_sub_order_content_after_order_table' ] );

		add_action( 'woocommerce_before_pay_action', [ $this, 'order_payment_initiate' ], 10, 1 );
	}



	public function add_pre_order_meta_to_item( \WC_Order_Item_Product $item, $cart_item_key, $values, $order ) {

		$cart_item = WC()->cart->get_cart()[ $cart_item_key ];

		if ( isset( $cart_item['cart_partial_payment_status'] ) && $cart_item['cart_partial_payment_status'] ) {
		 	$this->data->set_product( $cart_item['product_id'] );
			$item->update_meta_data( 'shopengine_pp_amount_type', $this->data->get_amount_type_value() );
			$item->update_meta_data( 'shopengine_pp_amount', $this->data->get_partial_amount_value() );
		}
	}


	/**
	 * @param $null
	 * @param $checkoutObject
	 *
	 * @return int|null
	 * @throws WC_Data_Exception
	 */
	public function create_order( $null, $checkoutObject ) {
		$this->data->set_partial_subtotal();

		if ( $this->data->exist_partial_payment_product_in_cart ) {

			$order = new Create_Order( $this->data );

			return $order->create( $checkoutObject );

		}

		return null;
	}


	/**
	 * initiate payment
	 *
	 * @param $order
	 */
	public function order_payment_initiate( $order ) {
		/*	$order->update_meta_data( 'partial_payment_second_installment_ongoing', 'yes' );
			$order->save();*/
	}

	/**
	 *  Overwrite  default order tr for order details page
	 *
	 * @param $total_rows
	 * @param $order
	 *
	 * @return mixed
	 */
	public function update_single_order_details( $total_rows, $order ) {

		if ( $order->get_meta( 'order_partial_payment_status' ) !== 'yes' ) {
			return $total_rows;
		}

		$parent_order = $order->get_meta( 'order_partial_payment_parent_order' );
		if ( $parent_order !== 'yes' ) {
			$order = wc_get_order( $order->get_parent_id() );
		}

		// Deposit order no need to show 'order again' button
		remove_action( 'woocommerce_order_details_after_order_table', 'woocommerce_order_again_button' );

		// Overwrite  default order tr
		$total_rows['order_total'] = array(
			'label' => apply_filters( 'label_order_total', esc_html__( 'Total:', 'shopengine-pro' ) ),
			'value' => apply_filters( 'woocommerce_deposit_top_pay_html', wc_price( $order->get_meta( 'partial_payment_order_total_amount' ),  ['currency' => $order->get_currency()] ) ),
		);

		$total_rows['deposit_total'] = array(
			'label' => apply_filters( 'label_deposit_total',  esc_html( $this->data->settings['first_installment_label'] ) ),
			'value' => apply_filters( 'woocommerce_deposit_top_pay_html', wc_price( $order->get_meta( 'partial_payment_first_installment' ), ['currency' => $order->get_currency()] ) ),
		);

		$total_rows['despoit_paid'] = array(
			'label' => apply_filters( 'label_deposit_paid', esc_html(  $this->data->settings['second_installment_label'] ) ),
			'value' => wc_price( $order->get_meta( 'partial_payment_second_installment' ), ['currency' => $order->get_currency()] ),
		);

		$total_rows['due_payment']  = array(
			'label' => apply_filters( 'label_due_payment', esc_html__( 'Due:', 'shopengine-pro' ) ),
			'value' => wc_price( $order->get_meta( 'partial_payment_due_amount' ), ['currency' => $order->get_currency()] ),
		);

		return $total_rows;
	}


	/**
	 * @param $order
	 */
	public function add_sub_order_content_after_order_table( $order ) {

		$parent_order = $order->get_meta( 'order_partial_payment_parent_order' );

		$orders = wc_get_orders( [
			'parent'  => $parent_order == 'yes' ? $order->get_id() : $order->get_parent_id(),
			'type'    => 'pp_installment',
			'orderby' => 'ID',
			'order'   => 'ASC',
		] );

		$order_has_deposit = $order->get_meta( 'order_partial_payment_status', true );

		if ( $order_has_deposit === 'yes' ) {

			wc_get_template(
				'frontend/order/order-summery.php', array(
				'parent_order_id' => $parent_order == 'yes' ? $order->get_id() : $order->get_parent_id(),
				'order_id'        => $order->get_id(),
				'orders'          => $orders
			),
				'',
				PP_TEMPLATE_PATH
			);
		}
	}

}
