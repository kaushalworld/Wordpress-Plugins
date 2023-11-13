<?php

namespace ShopEngine_Pro\Modules\Back_Order\Common;


class Item_Meta_Format {

	public function init() {

		add_filter('woocommerce_order_item_get_formatted_meta_data', [$this, 're_format_order_item_meta'], 10, 4);
	}

	public function re_format_order_item_meta($formatted_meta, $item) {

		foreach($formatted_meta as $key => $meta) {

			if($meta->key == 'shopengine_is_backordered') {
				$meta->display_key   = "<span class='shopengine-pre-order-product-badge'>" . esc_html__('Backorder', 'shopengine-pro') . "</span>";
				$meta->display_value = esc_html__('Yes', 'shopengine-pro');
			}

			if($meta->key == 'shopengine_backordered_qty') {
				$meta->display_key = esc_html__('Quantity', 'shopengine-pro');
			}
		}

		return $formatted_meta;
	}
}
