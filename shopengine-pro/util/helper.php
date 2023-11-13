<?php

namespace ShopEngine_Pro\Util;

class Helper {

	public static function get_woo_tax_attribute($taxonomy, $trim = true) {

		global $wpdb;

		$attr = $taxonomy;

		if($trim === true) {

			$attr = substr($taxonomy, 3);
		}

		$attr = $wpdb->get_row($wpdb->prepare("SELECT * FROM " . $wpdb->prefix . "woocommerce_attribute_taxonomies WHERE attribute_name = %s", $attr));

		return $attr;
	}

	public static function get_dummy() {

		return WC()->plugin_url() . '/assets/images/placeholder.png';
	}

		public static function get_kses_array()
	{
		return [
			'a'                             => [
				'class'            => [],
				'href'             => [],
				'rel'              => [],
				'title'            => [],
				'target'           => [],
				'data-quantity'    => [],
				'data-product_id'  => [],
				'data-product_sku' => [],
				'data-pid'         => [],
				'aria-label'       => [],
			],
			'abbr'                          => [
				'title' => [],
			],
			'b'                             => [],
			'blockquote'                    => [
				'cite' => [],
			],
			'cite'                          => [
				'title' => [],
			],
			'code'                          => [],
			'del'                           => [
				'datetime' => [],
				'title'    => [],
			],
			'dd'                            => [],
			'div'                           => [
				'class' 				=> [],
				'title' 				=> [],
				'style' 				=> [],
				'data-product-id' 		=> [],
				'data-attribute_name'	=> [],
				'id'					=> []
			],
			'dl'                            => [],
			'dt'                            => [],
			'em'                            => [],
			'h1'                            => [
				'class' => [],
			],
			'h2'                            => [
				'class' => [],
			],
			'h3'                            => [
				'class' => [],
			],
			'h4'                            => [
				'class' => [],
			],
			'h5'                            => [
				'class' => [],
			],
			'h6'                            => [
				'class' => [],
			],
			'i'                             => [
				'class' => [],
			],
			'img'                           => [
				'alt'      => [],
				'class'    => [],
				'height'   => [],
				'src'      => [],
				'width'    => [],
				'decoding' => [],
				'loading'  => [],
				'srcset'   => [],
				'sizes'    => []
			],
			'li'                            => [
				'class' => [],
			],
			'ol'                            => [
				'class' => [],
			],
			'p'                             => [
				'class' => [],
			],
			'q'                             => [
				'cite'  => [],
				'title' => [],
			],
			'span'                          => [
				'class' => [],
				'title' => [],
				'style' => [],
			],
			'iframe'                        => [
				'width'       => [],
				'height'      => [],
				'scrolling'   => [],
				'frameborder' => [],
				'allow'       => [],
				'src'         => [],
			],
			'strike'                        => [],
			'br'                            => [],
			'strong'                        => [
				'class' => [],
				'id'	=> [],
			],
			'data-wow-duration'             => [],
			'data-wow-delay'                => [],
			'data-wallpaper-options'        => [],
			'data-stellar-background-ratio' => [],
			'ul'                            => [
				'class' => [],
			],
			'button' => [
				'class' => [],
				'title' => [],
				'data-share-url' => [],
				'data-message' => []
			],
		];
	}

}
