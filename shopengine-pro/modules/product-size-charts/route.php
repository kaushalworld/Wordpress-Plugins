<?php

namespace ShopEngine_Pro\Modules\Product_Size_Charts;

use ShopEngine\Base\Api;

class Route extends Api {

	public function config() {

		$this->prefix = 'product-size-charts';
		$this->param  = "";
	}

	public function get_categories() {

		$data = $this->request->get_params();

		$query_args = [
            'taxonomy'      => ['product_cat'],
            'orderby'       => 'name', 
            'order'         => 'DESC',
            'hide_empty'    => false,
            'number'        => 10
        ];

		if(isset($data['ids'])){
            $ids = explode(',', $data['ids']);
            $query_args['include'] = $ids;
        }
        if(isset($data['s'])){
            $query_args['name__like'] = $data['s'];
        }

		$product_cat = get_terms($query_args);
		$product_categories = [];
		foreach($product_cat as $category) {
			$product_categories[$category->term_id] = $category->name;
		}
		
		return [
			'status' => 'success',
			'result' => $product_categories,
			'message' => esc_html__('product categories fetched', 'shopengine-pro')
		];
	}
}