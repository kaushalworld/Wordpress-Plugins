<?php

namespace ShopEngine_Pro\Modules\Sales_Notification;

use DateTime;
use Exception;
use ShopEngine\Core\Register\Module_List;
use WC_DateTime;

class Notification_Data {

	/**
	 * @throws Exception
	 */
	public function get_data(): array {

		$settings = Module_List::instance()->get_settings( 'sales-notification' );

		$show_thumbnail = $settings['show_thumbnail']['value'] ?? 'user' ;
		$product_limit = $settings['product_limit']['value'] ?? 20 ;


		$orders = wc_get_orders( [
			'orderby' => 'ID',
			'order'   => 'DESC',
			'limit'   => $product_limit
		] );

		$order_data = [
			"status" => 1,
			"count"  => count( $orders ),
			"data"   => []
		];

		foreach ( $orders as $order ) {

			$address = $order->get_address();

			$thumbnail = null;

			if ( $show_thumbnail == 'user' ) {
				$thumbnail = $order->get_user() ? get_avatar_url( $order->get_user()->get( 'ID' ) ) : get_avatar_url( false );
			}

			if(isset($settings['hide_last_name']['value']) && $settings['hide_last_name']['value'] === 'yes') {
				$customer_name = $order->get_billing_first_name();
			}else {
				$customer_name = $order->get_formatted_billing_full_name();
			}

			foreach ( $order->get_items() as $item ) {

				$item_data = $item->get_data();

				if ( ! $thumbnail && $show_thumbnail == 'product' ) {
					$thumbnail = wp_get_attachment_image_url( wc_get_product( $item_data['product_id'] )->get_image_id(), 'full' );
				}

				$order_data['data'][] = [
					"transaction_id"    => $order->get_id(),
					"product_id"        => $item_data['product_id'],
					"product_title"     => $item_data['name'],
					"customer_id"       => $order->get_customer_id(),
					"customer_name"     => $customer_name,
					"customer_location" => $address['city'] . ', ' . $address['country'],
					"purchase_time"     => $this->generate_purchase_time( $order->get_date_created() ),
					"quantity"          => $item_data['quantity'],
					"thumbnail"         => $thumbnail,
					"product_url"       => get_permalink( $item_data['product_id'] ),
				];

			}

		}

		return $order_data;
	}


	/**
	 * @throws Exception
	 */
	private function generate_purchase_time( WC_DateTime $created_at ): string {

		$time_ago = esc_html__('About', 'shopengine-pro');

		$currentDate = new DateTime();

		$difference = $currentDate->diff( new DateTime( $created_at ) );

		if ( $difference->d > 0 ) {

			$time_ago .= sprintf(' %1$s %2$s ', $difference->d, esc_html__('days ago', 'shopengine-pro'));

		} else if ( $difference->h > 0 ) {

			$time_ago .= sprintf(' %1$s %2$s ', $difference->h, esc_html__('hours ago', 'shopengine-pro'));

		} else if ( $difference->i > 0 ) {

			$time_ago .= sprintf(' %1$s %2$s ', $difference->i, esc_html__('minutes ago', 'shopengine-pro'));

		} else if ( $difference->s > 0 ) {

			$time_ago .= sprintf(' %1$s %2$s ', $difference->s, esc_html__('seconds ago', 'shopengine-pro'));

		}

		return $time_ago;
	}


}