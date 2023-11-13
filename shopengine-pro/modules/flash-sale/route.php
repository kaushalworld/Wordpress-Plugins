<?php

namespace ShopEngine_Pro\Modules\Flash_Sale;

use ShopEngine\Base\Api;

class Route extends Api {

	public function config() {

		$this->prefix = 'flash-sale';
		$this->param  = "";
	}

	public function get_products() {

		$data = $this->request->get_params();
		$query_args = [
            'post_type'         => 'product',
            'post_status'       => 'publish',
            'posts_per_page'    => 15,
        ];

        if(isset($data['ids'])){
            $ids = explode(',', $data['ids']);
            $query_args['post__in'] = $ids;
        }
        if(isset($data['s'])){
            $query_args['s'] = $data['s'];
        }

        $query = new \WP_Query($query_args);
		$products = [];
		foreach($query->posts as $post) {
			$products[$post->ID] = $post->post_title;
		}
		return [
			'status' => 'success',
			'result' => $products,
			'message' => esc_html__('products fetched', 'shopengine-pro')
		];
	}

	public function get_categories() {

		$data = $this->request->get_params();

		$query_args = [
            'taxonomy'      => ['product_cat'], // taxonomy name
            'orderby'       => 'name', 
            'order'         => 'DESC',
            'hide_empty'    => false,
            'number'        => 6
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
			'message' => esc_html__('products fetched', 'shopengine-pro')
		];
	}

	public function get_user_roles() {
		global $wp_roles;
		$roles = $wp_roles->roles;
		$r = [];
		foreach($roles as $key => $role) {
			$r[$key] = $role['name'];
		}
		return [
			'status' => 'success',
			'result' => $r,
			'message' => esc_html__('user roles fetched', 'shopengine-pro')
		];
	}
}


