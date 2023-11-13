<?php


namespace ShopEngine_Pro\Modules\Partial_Payment\Frontend\Order\Sub_Order;


use WC_Order;
use WC_Order_Item;
use WP_User;

class Schedule_Payment extends WC_Order {

	protected $parent_order = null;


	public function get_type() {
		return 'pp_installment';
	}

	/**
	 * Get created via.
	 *
	 * @param string $context What the value is for. Valid values are view and edit.
	 *
	 * @return string
	 */
	public function get_created_via( $context = 'view' ) {
		return 'admin';
	}

	/**
	 * Alias for get_customer_id().
	 *
	 * @param string $context What the value is for. Valid values are view and edit.
	 *
	 * @return int
	 */
	public function get_user_id( $context = 'view' ) {
		$parent = $this->set_parent();
		$parent->is_paid();

		return $parent->get_user_id( $context );
	}

	protected function set_parent() {

		if ( ! $this->parent_order ) {
			$this->parent_order = wc_get_order( $this->get_parent_id() );
		}

		return $this->parent_order;
	}

	/**
	 * Get the user associated with the order. False for guests.
	 *
	 * @return WP_User|false
	 */
	public function get_user() {
		$parent = $this->set_parent();
		if ( $parent ) {
			return $parent->get_user();
		}
	}

	public function get_fees( $force_parent = true ) {
		return $this->get_items( 'fee', $force_parent );
	}

	/**
	 * Return an array of items/products within this order.
	 *
	 * @param string|array $types Types of line items to get (array or string).
	 *
	 * @return WC_Order_Item[]
	 */
	public function get_items( $types = 'line_item', $self = false ) {
		global $pagenow;

		$parent = $self ? $this : $this->set_parent();

		if ( $pagenow == 'post.php' ) {
			$parent = $this;
		}

		$items = array();
		$types = array_filter( (array) $types );

		foreach ( $types as $type ) {
			$group = $parent->type_to_group( $type );

			if ( $group ) {
				if ( ! isset( $this->items[ $group ] ) ) {
					$parent->items[ $group ] = array_filter( $parent->data_store->read_items( $parent, $type ) );
				}
				// Don't use array_merge here because keys are numeric.
				$items = $items + $parent->items[ $group ];
			}
		}

		return apply_filters( 'woocommerce_order_get_items', $items, $parent, $types );
	}


	/**
	 * Adds an order item to this order. The order item will not persist until save.
	 *
	 * @param WC_Order_Item $item Order item object (product, shipping, fee, coupon, tax).
	 *
	 * @return false|void
	 * @since 3.0.0
	 */
	public function add_item( $item, $self = true ) {
		$items_key = $this->get_items_key( $item );

		if ( ! $items_key ) {
			return false;
		}

		// Make sure existing items are loaded so we can append this new one.
		if ( ! isset( $this->items[ $items_key ] ) ) {
			$this->items[ $items_key ] = $this->get_items( $item->get_type(), true );
		}

		// Set parent.
		$item->set_order_id( $this->get_id() );

		// Append new row with generated temporary ID.
		$item_id = $item->get_id();

		if ( $item_id ) {
			$this->items[ $items_key ][ $item_id ] = $item;
		} else {
			$this->items[ $items_key ][ 'new:' . $items_key . count( $this->items[ $items_key ] ) ] = $item;
		}
	}


	/**
	 * Gets the order number for display (by default, order ID).
	 *
	 * @return string
	 */
	public function get_order_number() {
		global $pagenow;
		if ( $pagenow == 'post.php' ) {
			$id = $this->get_id();
		} else {
			$id = $this->get_parent_id();
		}

		return (string) apply_filters( 'woocommerce_order_number', $id, $this );
	}

	/**
	 * Get shipping address line 1.
	 *
	 * @param string $context What the value is for. Valid values are view and edit.
	 *
	 * @return string
	 */
	public function get_shipping_address_1( $context = 'view' ) {

		$parent = $this->set_parent();
		if ( $parent ) {
			return $parent->get_shipping_address_1( $context );
		}

		return $this->get_address_prop( 'address_1', 'shipping', $context );
	}

	/**
	 * Get shipping address line 2.
	 *
	 * @param string $context What the value is for. Valid values are view and edit.
	 *
	 * @return string
	 */
	public function get_shipping_address_2( $context = 'view' ) {

		$parent = $this->set_parent();
		if ( $parent ) {
			return $parent->get_shipping_address_2( $context );
		}

		return $this->get_address_prop( 'address_2', 'shipping', $context );
	}


	public function get_address( $type = 'billing' ) {
		$parent = $this->set_parent();

		return apply_filters( 'woocommerce_get_order_address', array_merge( $parent->data[ $type ], $parent->get_prop( $type, 'view' ) ), $type, $parent );
	}

	/**
	 * Returns true if the order has a shipping address.
	 *
	 * @return boolean
	 * @since  3.0.4
	 */
	public function has_shipping_address() {
		$parent = $this->set_parent();

		return $parent->get_shipping_address_1() || $parent->get_shipping_address_2();
	}


	/**
	 * Get totals for display on pages and in emails.
	 *
	 * @param string $tax_display Tax to display.
	 *
	 * @return array
	 */
	public function get_order_item_totals( $tax_display = '' ) {
		$parent      = $this->set_parent();
		$tax_display = $tax_display ? $tax_display : get_option( 'woocommerce_tax_display_cart' );
		$total_rows  = array();

		$parent->add_order_item_totals_subtotal_row( $total_rows, $tax_display );
		$parent->add_order_item_totals_discount_row( $total_rows, $tax_display );
		$parent->add_order_item_totals_shipping_row( $total_rows, $tax_display );
		$parent->add_order_item_totals_fee_rows( $total_rows, $tax_display );
		$parent->add_order_item_totals_tax_rows( $total_rows, $tax_display );
		$parent->add_order_item_totals_payment_method_row( $total_rows, $tax_display );
		$parent->add_order_item_totals_refund_rows( $total_rows, $tax_display );
		$parent->add_order_item_totals_total_row( $total_rows, $tax_display );

		return apply_filters( 'woocommerce_get_order_item_totals', $total_rows, $this, $tax_display );
	}

}