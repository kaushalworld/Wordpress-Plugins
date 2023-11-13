<?php

namespace Elementor;

defined('ABSPATH') || exit;

class ShopEngine_Product_Filters_Config extends \ShopEngine\Base\Widget_Config {

	public function get_name() {
		return 'product-filters';
	}

	public function get_title() {
		return esc_html__('Product Filters', 'shopengine-pro');
	}

	public function get_icon() {
		return 'shopengine-widget-icon shopengine-icon-cross_sells';
	}

	public function get_categories() {
		return ['shopengine-archive'];
	}

	public function get_keywords() {
		return ['woocommerce', 'shop', 'store', 'title', 'heading', 'product', 'ajax'];
	}

	public function get_script_depends() {
		return ['jquery-ui-slider'];
	}

	public function get_template_territory() {
		return ['shop', 'archive'];
	}

	public function get_attribute_taxonomies() {

		$attributes = wc_get_attribute_taxonomies();
		$attr = [];
		foreach($attributes as $attribute) {
			if($attribute->attribute_type === 'select') {
				$attr[$attribute->attribute_id] = $attribute->attribute_label;
			}
		}
		return $attr;
	}
}
