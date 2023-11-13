<?php


namespace ShopEngine_Pro\Modules\Partial_Payment\Common;


use WC_Data_Exception;
use WC_Order;

class Order_Status_Action {

	public function order_status_changed( $order_id, $from_status, $to_status, WC_Order $order ) {

		if ( ! $order->get_meta( 'order_partial_payment_status' ) || $order->get_meta( 'order_partial_payment_status' ) !== 'yes' ) {
			return true;
		}

		if ( $order->get_type() == 'pp_installment' ) {

			$parent_order = wc_get_order( $order->get_parent_id() );
			$this->process_sub_order_status( $from_status, $to_status, $order, $parent_order );

		} else {

			$this->process_parent_order_status( $from_status, $to_status, $order );

		}
		return true;
	}

	private function process_sub_order_status( $from_status, $to_status, WC_Order $order, WC_Order $parent_order ) {

		$installment = $order->get_meta( 'installment' );

		if ( in_array( $to_status, [ 'processing', 'completed' ] ) ) {

			if ( $installment === 'first' ) {

				if ( $parent_order->get_meta( 'first_installment_paid' ) == 'no' ) {

					$parent_order->update_meta_data( 'first_installment_paid', 'yes' );
					$paid_amount     = $parent_order->get_meta( 'partial_payment_paid_amount' );
					$new_paid_amount = $paid_amount + $order->get_total();
					$parent_order->update_meta_data( 'partial_payment_paid_amount', $new_paid_amount );
					$parent_order->update_meta_data( 'partial_payment_due_amount', $parent_order->get_total() - $new_paid_amount );
					$parent_order->save();
				}
			}

			if ( $installment === 'second' ) {

				if ( $parent_order->get_meta( 'second_installment_paid' ) == 'no' ) {

					$parent_order->update_meta_data( 'second_installment_paid', 'yes' );
					$paid_amount     = $parent_order->get_meta( 'partial_payment_paid_amount' );
					$new_paid_amount = $paid_amount + $order->get_total();
					$parent_order->update_meta_data( 'partial_payment_paid_amount', $new_paid_amount );
					$parent_order->update_meta_data( 'partial_payment_due_amount', $parent_order->get_total() - $new_paid_amount );
					$parent_order->save();

				}
			}

		}

		if ( in_array( $to_status, [ 'on-hold', 'failed', 'cancelled', 'pending' ] ) ) {

			$first_installment_paid  = $parent_order->get_meta( 'first_installment_paid' );
			$second_installment_paid = $parent_order->get_meta( 'second_installment_paid' );

			if ( $installment === 'first' ) {

				if ( $first_installment_paid == 'yes' ) {
					$parent_order->update_meta_data( 'first_installment_paid', 'no' );

					$paid_amount = (float)$parent_order->get_meta( 'partial_payment_paid_amount' ) - (float)$parent_order->get_meta('partial_payment_first_installment');

					$parent_order->update_meta_data( 'partial_payment_paid_amount', $paid_amount );
					$parent_order->update_meta_data( 'partial_payment_due_amount',  $parent_order->get_total() - $paid_amount );
				}

			}

			if ( $installment === 'second' ) {
				if ( $second_installment_paid == 'yes' ) {
					$parent_order->update_meta_data( 'second_installment_paid', 'no' );


					$paid_amount = (float)$parent_order->get_meta( 'partial_payment_paid_amount' ) - (float)$parent_order->get_meta('partial_payment_second_installment');

					$parent_order->update_meta_data( 'partial_payment_paid_amount', $paid_amount );
					$parent_order->update_meta_data( 'partial_payment_due_amount',  $parent_order->get_total() - $paid_amount );

				}
			}

			$parent_order->set_status( 'on-hold' );
			$parent_order->save();
		}
	}

	private function process_parent_order_status( $from_status, $to_status, WC_Order $order ) {
		if ( in_array( $from_status, [ 'pending', 'on-hold' ] ) && in_array( $to_status, [
				'processing',
				'completed'
			] ) ) {

			$sub_orders = wc_get_orders( [
				'parent'  => $order->get_id(),
				'type'    => 'pp_installment',
				'orderby' => 'ID',
				'order'   => 'ASC',
			] );

			foreach ( $sub_orders as $sub_order ) {
				if ( $sub_order->get_status() !== $to_status ) {
					$sub_order->set_status( $to_status );
					$sub_order->save();
				}
			}
		}


		if ( in_array( $from_status, [ 'pending', 'on-hold' ] ) && in_array( $to_status, [ 'failed', 'cancelled' ] ) ) {

			$sub_orders = wc_get_orders( [
				'parent'  => $order->get_id(),
				'type'    => 'pp_installment',
				'orderby' => 'ID',
				'order'   => 'ASC',
			] );

			foreach ( $sub_orders as $sub_order ) {
				$sub_order->set_status( $to_status );
				$sub_order->save();
			}

		}
	}
}