<?php

namespace ShopEngine_Pro\Modules\Sticky_Fly_Cart;

use ShopEngine\Base\Api;

class Route extends Api {

	public function config() {
		$this->prefix = 'fly-cart';
		$this->param  = "";
	}

	public function get_pages() {

		$query_args = [
			'post_type'         => 'page',
			'post_status'       => 'publish',
			'posts_per_page'    => 10,
		];

		if(!empty($this->request['s'])) {
			$query_args['s'] = $this->request['s'];
		}

		$query = new \WP_Query($query_args);
		$pages = $query->have_posts() ? wp_list_pluck($query->posts, 'post_title', 'ID') : [];

		return [
			'status' => 'success',
			'result' => $pages,
			'message' => esc_html__('Fetched', 'shopengine-pro')
		];
	}
}