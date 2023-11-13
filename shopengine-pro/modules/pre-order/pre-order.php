<?php

namespace ShopEngine_Pro\Modules\Pre_Order;

use ShopEngine_Pro\Modules\Pre_Order\Admin\Pre_Order_Admin;
use ShopEngine_Pro\Modules\Pre_Order\Api\Pre_Order_Api;
use ShopEngine_Pro\Modules\Pre_Order\Common\Common_Functionality;
use ShopEngine_Pro\Modules\Pre_Order\Frontend\Pre_Order_Frontend;
use ShopEngine\Traits\Singleton;

defined( 'ABSPATH' ) || exit;

/**
 * Partial payment main class
 * @since  1.1.3
 *
 */
class Pre_Order {

	use Singleton;


	public function init() {

		if ( is_admin() ) {
			( new Pre_Order_Admin() )->init();
		} else {
			( new Pre_Order_Frontend() )->init();
		}

		( new Common_Functionality() )->init();

		add_action( 'woocommerce_product_stock_status_options', [ $this, 'add_pre_order_status_to_product' ], 10, 2 );

		(new Pre_Order_Api() )->init();
	}


	public function add_pre_order_status_to_product( $status ) {

		$status['pre_order'] = esc_html__( 'Pre order', 'shopengine-pro' );

		return $status;
	}

}
