<?php


namespace ShopEngine_Pro\Modules\Pre_Order\Api;


use ShopEngine\Base\Api;
use ShopEngine_Pro\Modules\Pre_Order\Frontend\Single_Product_Functionality;

class Pre_Order_Api extends Api {


	public function config() {
		$this->prefix = 'pre-order';
	}


	public function post_single_product_content() {

		$partialData = new Single_Product_Functionality();
	    $data = $partialData->get_pre_order_content();

		wp_send_json($data);
	}

}