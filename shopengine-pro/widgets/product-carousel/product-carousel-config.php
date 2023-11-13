<?php

namespace Elementor;

defined('ABSPATH') || exit;

class ShopEngine_Product_Carousel_Config extends \ShopEngine\Base\Widget_Config {

	public function get_name() {
		return 'product-carousel';
	}

	public function get_title() {
		return esc_html__('Product Carousel', 'shopengine-pro');
	}

	public function get_icon() {
		return 'eicon-slider-push shopengine-widget-icon';
	}

	public function get_categories() {
		return ['shopengine-general'];
	}

	public function get_keywords() {
		return ['woocommerce', 'shopengine-pro', 'product', 'product carousel'];
	}

	public function get_template_territory() {
		return [];
	}

	public function product_order_by() {
		return [
			'ID'            => esc_html__('ID', 'shopengine-pro'),
			'title'         => esc_html__('Title', 'shopengine-pro'),
			'name'          => esc_html__('Name', 'shopengine-pro'),
			'date'          => esc_html__('Date', 'shopengine-pro'),
			'comment_count' => esc_html__('Popular', 'shopengine-pro'),
			'modified'      => esc_html__('Modified', 'shopengine-pro'),
			'price'         => esc_html__('Price', 'shopengine-pro'),
			'sales'         => esc_html__('Sales', 'shopengine-pro'),
			'rated'         => esc_html__('Top Rated', 'shopengine-pro'),
			'rand'          => esc_html__('Random', 'shopengine-pro'),
			'menu_order'    => esc_html__('Menu Order', 'shopengine-pro'),
			'sku'           => esc_html__('SKU', 'shopengine-pro'),
			'stock_status'  => esc_html__('Stock Status', 'shopengine-pro'),
		];
	}

	public function product_query_by() {
		return [
			'category'  => esc_html__('Category', 'shopengine-pro'),
			'tag'       => esc_html__('Tag', 'shopengine-pro'),
			'product'   => esc_html__('Product', 'shopengine-pro'),
			'rating'    => esc_html__('Rating', 'shopengine-pro'),
			'attribute' => esc_html__('Attribute', 'shopengine-pro'),
			'author'    => esc_html__('Author', 'shopengine-pro'),
			'featured'  => esc_html__('Featured', 'shopengine-pro'),
			'sale'      => esc_html__('Sale', 'shopengine-pro'),
			'viewed'    => esc_html__('Recently Viewed', 'shopengine-pro'),
		];
	}

}