<?php

namespace ShopEngine_Pro\Modules\Pre_Order\Admin;

use ShopEngine\Modules\Swatches\Swatches;
use ShopEngine_Pro;
use ShopEngine_Pro\Modules\Pre_Order\Frontend\Single_Product_Functionality;
use ShopEngine_Pro\Modules\Pre_Order\Settings\Helper;
use ShopEngine_Pro\Modules\Pre_Order\Settings\Pre_Order_Settings;
use WC_Product;

defined( 'ABSPATH' ) || exit;

class Pre_Order_Admin {

	/**
	 * Pre_Order_Settings object
	 */
	private $settings;

	public function __construct() {
		$this->settings = Pre_Order_Settings::instance();
	}


	public function init() {

		add_action( 'admin_enqueue_scripts', [ $this, 'add_admin_enqueue' ] );

		/**
		 * Showing extra column in the orders table
		 */
		add_filter( 'manage_edit-shop_order_columns', [ $this, 'add_column_in_order_listing_page' ], 10, 1 );
		add_action( 'manage_shop_order_posts_custom_column', [ $this, 'set_order_type_column_value' ], 10, 2 );

		new Pre_Order_Admin_Fields($this->settings);
		new Pre_Order_Admin_Fields_Process($this->settings);


		add_action( 'woocommerce_admin_stock_html', [$this,'change_stock_html'], 10, 2 );
	}


	function change_stock_html( $stock_html, \WC_Product $product ) {
		if (  $product->get_meta( 'shopengine_pre_order_status' ) === 'yes' ) {
			$stock_html =  '<mark class="onbackorder">'.esc_html__('Pre-Order', 'shopengine-pro') .'</mark>';

			if ( $product->get_meta( 'shopengine_product_pp_status' ) === 'yes' ) {
				$stock_html .= '<mark class="onbackorder">&#160;'. esc_html__('& Partial Payment', 'shopengine-pro') .'</mark>';
			}
		}



		return $stock_html;
	}


	public function add_admin_enqueue() {
		wp_enqueue_style( 'admin-pre-order-module-css', ShopEngine_Pro::module_url() . 'pre-order/assets/css/pre-order-admin.css', [], ShopEngine_Pro::version() );
		wp_enqueue_script( 'admin-pre-order-module-js', ShopEngine_Pro::module_url() . 'pre-order/assets/js/pre-order-admin.js', [
			'jquery'
		] );
	}



	public function add_column_in_order_listing_page( $columns ) {

		if ( ! isset( $columns['order_page_order_type'] ) ) {

			$order_total = $columns['order_total'];
			$wc_actions  = $columns['wc_actions'];
			unset( $columns['order_total'], $columns['wc_actions'] );

			$columns['order_page_order_type'] = esc_html__( 'Order Type', 'shopengine-pro' );
			$columns['order_total']           = $order_total;
			$columns['wc_actions']            = $wc_actions;

		}

		return $columns;
	}

	public function set_order_type_column_value( $column ) {

		global $the_order;

		if ( $column == 'order_page_order_type' && $the_order->get_meta( 'shopengine_pre_order' ) == 'yes' ) {
			$pre_order_item_count = 0;
			$items                = $the_order->get_items();
			foreach ( $the_order->get_items() as $item ) {
				if ( $item->get_meta( 'shopengine_pre_order_item' ) == 'yes' ) {
					$pre_order_item_count += 1;
				}
			}

			shopengine_pro_content_render("<span class='shopengine-pre-order-product-badge'>"
				.esc_html__( "Pre-Order", "shopengine-pro" )
				."</span> <br> <b title='PreOrder Item/s'> $pre_order_item_count/"
				. count( $items ) . " Item" . ( $pre_order_item_count > 1 ? 's' : '' ) . "</b>");
		}
	}
}
