<?php

namespace ShopEngine_Pro\Modules\Cross_Sell_Popup;

use ShopEngine_Pro\Traits\Singleton;

defined('ABSPATH') || exit;

class Cross_Sell_Popup
{
	const SESSION_KEY = 'shopengine_recently_cart_added_product';

	use Singleton;

	public function init()
	{
		new Route;

		if (!session_id()) {
			session_start(['read_and_close' => true]);
		}

		add_action('woocommerce_add_to_cart', function ($data, $product_id) {
			//phpcs:disable WordPress.Security.NonceVerification
			//No nonce found
			if( isset($_REQUEST['action']) && sanitize_text_field(wp_unslash($_REQUEST['action'])) === 'astra_add_cart_single_product' ) {
				$_SESSION[self::SESSION_KEY] = $product_id;
			} elseif (isset($_REQUEST['shopengine_quick_checkout']) && sanitize_text_field(wp_unslash($_REQUEST['shopengine_quick_checkout'])) === 'modal-content') {
				$_SESSION[self::SESSION_KEY] = $product_id;
			}
			//phpcs:enable
		}, 10, 2);
		
		add_action('wp_footer', function () {
			if (isset($_SESSION[self::SESSION_KEY])) {
				if (is_product()) {
					$product_id = (int) $_SESSION[self::SESSION_KEY];
					$this->render_cross_sell_view($product_id);
				}
				unset($_SESSION[self::SESSION_KEY]);
			}
		});

		add_action('wp_enqueue_scripts', [$this, 'enqueue']);
	}

	public function enqueue() {
		wp_enqueue_style('shopengine-cross-sell-popup', \ShopEngine_Pro::module_url() . 'cross-sell-popup/assets/css/cross-sell-popup.css');
		wp_enqueue_script('shopengine-cross-sell-popup', \ShopEngine_Pro::module_url() . 'cross-sell-popup/assets/js/cross-sell-popup.js', ['jquery'], \ShopEngine_Pro::version(), true);
		wp_localize_script('shopengine-cross-sell-popup','crossSellData', [
			'post_id' => get_the_ID() ? get_the_ID() : 0,
			'is_product' => is_product(),
		]);
	}

	public function render_cross_sell_view($product_id)
	{
		$cross_sell_product_ids = get_post_meta($product_id, '_crosssell_ids', true);

		if ($cross_sell_product_ids && is_product()) {
			$args = [
				'post_type' => 'product',
				'post__in'  => $cross_sell_product_ids
			];

			$the_query = new \WP_Query($args);
			include_once \ShopEngine_Pro::plugin_dir() . 'modules/cross-sell-popup/view/default.php';
		}
	}
}
