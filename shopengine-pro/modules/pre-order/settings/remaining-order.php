<?php


namespace ShopEngine_Pro\Modules\Pre_Order\Settings;


use ShopEngine_Pro\Traits\Singleton;

class Remaining_Order {

	use Singleton;

	/**
	 * Generate booked order amount once for a product
	 * keep generated list to array for performance optimizing.
	 * @var array
	 */
	private $list_generated = [] ;

	public function __construct() {

		add_filter( 'woocommerce_order_data_store_cpt_get_orders_query', [ $this, 'pre_order_query_modify' ], 10, 2 );
	}


	public function pre_order_query_modify( $query, $query_vars ): array {

		if ( isset( $query_vars['shopengine_pre_order_query'] ) &&  $query_vars['shopengine_pre_order_query'] ) {

			$query['meta_query'][] = [
				'key' => 'shopengine_pre_order',
				'value' => 'yes',
			];

		}

		return $query;
	}

	private function get_product_total_orders( $product_id, $variation_id = null ): int {
		global $wpdb;

		$query = 'SELECT sum(lookup.product_qty) as total FROM `'.$wpdb->prefix.'wc_order_product_lookup` as lookup';
		$query .=' INNER JOIN '.$wpdb->prefix.'wc_order_stats AS stat on lookup.order_id = stat.order_id ';
		$query .=' INNER JOIN '.$wpdb->prefix.'woocommerce_order_itemmeta as itemmeta ON lookup.order_item_id = itemmeta.order_item_id AND itemmeta.meta_key = "shopengine_pre_order_item"';
		$query .=$wpdb->prepare(' WHERE lookup.`product_id` = %d', intval( $product_id ))  . ( $variation_id ? $wpdb->prepare(' AND lookup.`variation_id` = %d', intval( $variation_id ))  : '' )   ;
		$query .= ' AND stat.status NOT IN (\'wc-cancelled\', \'wc-refunded\') ;';

		return intval( $wpdb->get_col( $query )[0] ?? 0 ); //phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared
	}

	public function booked_Orders( $product_id , $variation_id = null): int {

		if( isset( $this->list_generated[ $product_id.$variation_id ] ) ){
			return $this->list_generated[ $product_id.$variation_id ] ;
		}


		$this->list_generated[ $product_id.$variation_id ] =  $this->get_product_total_orders( $product_id,$variation_id );


		return $this->list_generated[ $product_id.$variation_id ] ;
	}

}