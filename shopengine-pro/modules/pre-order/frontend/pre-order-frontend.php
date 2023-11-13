<?php

namespace ShopEngine_Pro\Modules\Pre_Order\Frontend;

use ShopEngine\Modules\Swatches\Swatches;
use ShopEngine_Pro;
use ShopEngine_Pro\Modules\Pre_Order\Settings\Pre_Order_Settings;

defined( 'ABSPATH' ) || exit;

class Pre_Order_Frontend {


	public function init() {

		add_action( 'wp_enqueue_scripts', [ $this, 'add_enqueue' ] );

		( new Single_Product_Functionality() )->init();
		( new Cart_Functionality() )->init();
		( new Order_Functionality() )->init();
	}

	/**
	 * add pre-order css & js
	 */
	public function add_enqueue() {
		wp_enqueue_script( 'pre-order-module-js', ShopEngine_Pro::module_url() . 'pre-order/assets/js/pre-order-frontend.js', [
			'jquery'
		] );
		wp_enqueue_style( 'pre-order-module-css', ShopEngine_Pro::module_url() . 'pre-order/assets/css/pre-order-frontend.css', [], ShopEngine_Pro::version() );
	}
}