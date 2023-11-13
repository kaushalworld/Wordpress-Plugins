<?php

namespace ShopEngine_Pro\Modules\Partial_Payment;

use ShopEngine\Traits\Singleton;
use ShopEngine_Pro\Libs\Schedule\Partial_Payment_Schedule;
use ShopEngine_Pro\Modules\Partial_Payment\Admin\Partial_Payment_Admin;
use ShopEngine_Pro\Modules\Partial_Payment\Api\Partial_Payment_Api;
use ShopEngine_Pro\Modules\Partial_Payment\Common\Common_Functionality;
use ShopEngine_Pro\Modules\Partial_Payment\Common\Order_Status_Action;
use ShopEngine_Pro\Modules\Partial_Payment\Frontend\Partial_Payment_Frontend;
use ShopEngine_Pro\Modules\Partial_Payment\Settings\Partial_Payment_Data;

defined( 'ABSPATH' ) || exit;

/**
 * Partial payment main class
 * @since  1.1.3
 *
 */
class Partial_Payment  {
	use Singleton;

	public function init() {

		define( 'PP_TEMPLATE_PATH', untrailingslashit( plugin_dir_path( __FILE__ ) ) . '/templates/' );

	    add_action( 'init', array( $this, 'register_partial_payment_post_type' ), 100 );


		if ( is_admin() ) {
			Partial_Payment_Admin::instance()->init();
		} else {
			Partial_Payment_Frontend::instance()->init();
		}

		$common_functionalities = new Common_Functionality( new Partial_Payment_Data() );
		$common_functionalities->init();


		/**
		 * change order partial calculation depending on-change order status
		 */
		add_action( 'woocommerce_order_status_changed', [ new Order_Status_Action(), 'order_status_changed' ], 10, 4 );

		// api for payment method . Will used in Partial Payment Settings
		(new Partial_Payment_Api() )->init();

		if ( class_exists( 'WooCommerce' ) ) {
			add_action( 'wp_loaded', function () {
				new Partial_Payment_Schedule();
			} );
		}
	}

	public function register_partial_payment_post_type() {

		wc_register_order_type(
			'pp_installment',
			array(
				'labels'                           => array(
					'name'          => esc_html__( 'Partial Payment Installments', 'shopengine-pro' ),
					'singular_name' => esc_html__( 'Partial Payment Installment', 'shopengine-pro' ),
					'edit_item'     => esc_html_x( 'Edit Partial Payment Installment', 'custom post type setting', 'shopengine-pro' ),
					'search_items'  => esc_html__( 'Search Partial Payment Installments', 'shopengine-pro' ),
					'parent'        => esc_html_x( 'Order', 'custom post type setting', 'shopengine-pro' ),
					'menu_name'     => esc_html__( 'Partial Payment Installments', 'shopengine-pro' ),
				),
				'public'                           => false,
				'show_ui'                          => true,
				'capability_type'                  => 'shop_order',
				'capabilities'                     => array(
					'create_posts' => 'do_not_allow',
				),
				'map_meta_cap'                     => true,
				'publicly_queryable'               => false,
				'exclude_from_search'              => true,
				'show_in_menu'                     => 'woocommerce',
				'hierarchical'                     => false,
				'show_in_nav_menus'                => false,
				'rewrite'                          => false,
				'query_var'                        => false,
				'supports'                         => array( 'title', 'comments', 'custom-fields' ),
				'has_archive'                      => false,

				// wc_register_order_type() params
				'exclude_from_orders_screen'       => true,
				'add_order_meta_boxes'             => true,
				'exclude_from_order_count'         => true,
				'exclude_from_order_views'         => true,
				'exclude_from_order_webhooks'      => true,
				'exclude_from_order_reports'       => true,
				'exclude_from_order_sales_reports' => true,
				'class_name'                       => 'ShopEngine_Pro\Modules\Partial_Payment\Frontend\Order\Sub_Order\Schedule_Payment',
			)

		);
	}
}