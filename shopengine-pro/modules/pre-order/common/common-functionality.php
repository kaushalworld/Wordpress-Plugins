<?php

namespace ShopEngine_Pro\Modules\Pre_Order\Common;


use ShopEngine_Pro\Modules\Pre_Order\Settings\Pre_Order_Settings;

class Common_Functionality {

	/**
	 * Pre_Order_Settings object
	 */
	private $settings;

	public function __construct() {
		$this->settings = Pre_Order_Settings::instance();
	}


	public function init() {

		add_filter( 'woocommerce_order_item_get_formatted_meta_data', [ $this, 're_format_order_item_meta' ], 10, 4 );
	}

	public function re_format_order_item_meta( $formatted_meta, $item ) {
		foreach ( $formatted_meta as $key => $meta ) {
			if ( $meta->key == 'shopengine_pre_order_item' ) {
				$meta->display_key = "<span class='shopengine-pre-order-product-badge'>{$this->settings->pre_order_label}</span>";
			}
		}

		return $formatted_meta;
	}
}