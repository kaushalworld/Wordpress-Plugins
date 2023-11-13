<?php

namespace ShopEngine_Pro\Modules\Partial_Payment\Frontend\Checkout;

use ShopEngine_Pro\Modules\Partial_Payment\Settings\Partial_Payment_Data;
use WC_Order_Item_Product;

defined( 'ABSPATH' ) || exit;

class Partial_Payment_Checkout {

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

		// orders & payment
		add_action( 'woocommerce_review_order_after_order_total', [ $this, 'add_html_to_cart_summery_table' ] );
		add_action( 'woocommerce_available_payment_gateways', [ $this, 'remove_avoid_payment_methods' ] );
		add_filter( 'woocommerce_checkout_create_order_line_item', [ $this, 'add_pre_order_meta_to_item' ], 10, 4 );
	}

	/**
	 * remove avoid payment gateway for Partial payment
	 *
	 * @param $available_gateways
	 *
	 * @return mixed
	 */
	public function remove_avoid_payment_methods( $available_gateways ) {
		$this->data->set_partial_subtotal();

		if ( $this->data->exist_partial_payment_product_in_cart ) {

			foreach ( $available_gateways as $key => $available_gateway ) {

				if ( in_array( $key, $this->data->settings['avoid_payment_methods'] ) ) {
					unset( $available_gateways[ $key ] );
				}
			}
		}

		return $available_gateways;
	}


	/**
	 * add partial payment data to cart summery table
	 */
	public function add_html_to_cart_summery_table() {
		$this->data->set_partial_subtotal();
		if ( $this->data->subtotal_second_payment > 0 ) {
			$due = WC()->cart->get_total( 'f' ) - $this->data->subtotal_first_payment;
			?>

            <tr  >
                <th> <?php echo esc_html( $this->data->settings['first_installment_label'] ) ?> </th>
                <td>  <?php shopengine_pro_content_render(wc_price( $this->data->subtotal_first_payment)); ?>  </td>
            </tr>
            <tr  >
                <th> <?php echo esc_html( $this->data->settings['second_installment_label'] ) ?></th>
                <td> <?php shopengine_pro_content_render(wc_price( $due )); ?> </td>
            </tr>

            <tr class="order-topay">
                <th> <?php echo esc_html( $this->data->settings['to_pay_label'] ) ?> </th>
                <td>  <?php shopengine_pro_content_render(wc_price( $this->data->subtotal_first_payment )); ?>  </td>
            </tr>
			<?php
		}
	}

	public function add_pre_order_meta_to_item( WC_Order_Item_Product $item, $cart_item_key, $values, $order ) {

		$cart_item = WC()->cart->get_cart()[ $cart_item_key ];

		if ( isset( $cart_item['cart_partial_payment_status'] ) ) {

			$item->update_meta_data( 'shopengine_pp_status', 'yes' );
			$item->update_meta_data( 'shopengine_pp_amount', 'yes' );
			$item->update_meta_data( 'shopengine_pp_amount', 'yes' );

		}

		if ( isset( $cart_item['pre_order_status'] ) && $cart_item['pre_order_status'] == true ) {
			$item->update_meta_data( 'shopengine_pre_order_item', 'yes' );
		}
	}
}
