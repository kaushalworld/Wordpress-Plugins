<?php

namespace ShopEngine_Pro\Modules\Cross_Sell_Popup;

defined('ABSPATH') || exit;

use ShopEngine\Base\Api;

class Route extends Api
{
	public function config()
	{
		$this->prefix = 'cross-sell-popup';
		$this->param  = "";
	}

	public function get_cross_sell_products()
	{
		$data = $this->request->get_params();

		unset($_SESSION[\ShopEngine_Pro\Modules\Cross_Sell_Popup\Cross_Sell_Popup::SESSION_KEY]);
 
		if(empty($data['product_id'])) {
			return [
				'status' => 'failed'
			];
		}

		$product_id = intval($data['product_id']);

		$cross_sell_product_ids = get_post_meta($product_id, '_crosssell_ids', true);

		if ($cross_sell_product_ids) {
			$args = [
				'post_type' => 'product',
				'post__in'  => $cross_sell_product_ids
			];

			$the_query = new \WP_Query($args);

			ob_start();

			include_once \ShopEngine_Pro::plugin_dir() . 'modules/cross-sell-popup/view/default.php';

			return ob_get_clean();
		}

		return false;
	}
}