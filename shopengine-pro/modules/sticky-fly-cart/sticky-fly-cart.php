<?php

namespace ShopEngine_Pro\Modules\Sticky_Fly_Cart;

use ShopEngine\Core\Register\Module_List;
use ShopEngine_Pro\Traits\Singleton;

class Sticky_Fly_Cart {

	use Singleton; 

	public function init() {

		new Route();

		add_action('wp', [$this, 'init_functions']);
		add_action('wp_ajax_shopengine_cart_total', [$this, 'shopengine_cart_total']);
		add_action('wp_ajax_nopriv_shopengine_cart_total', [$this, 'shopengine_cart_total']);
	}

	

	public function init_functions(){

		if( $this->need_to_disable() ) {
			return;
		}

		add_action('wp_footer', [$this, 'screens']);
		add_action('wp_enqueue_scripts', [$this, 'enqueue']);
	}

	public function shopengine_cart_total() {

		$cart = WC()->cart;

		$response = [
			'items_count'	=> $cart->get_cart_contents_count(),
			'items_html'	=> sprintf(_n('%s Item', '%s Items', $cart->get_cart_contents_count(), 'shopengine-pro'), number_format_i18n($cart->get_cart_contents_count())),
			'amount'		=> $cart->get_cart_total(),
			'status'		=> 'success'
		];
		wp_send_json($response);
		exit;
	}

	public function screens() {

		$settings = Module_List::instance()->get_settings('sticky-fly-cart');

		include plugin_dir_path(__FILE__) . 'screens/default.php';
	}

	public function enqueue() {
		wp_enqueue_style('shopengine-sticky-fly-cart', \ShopEngine_Pro::module_url() . 'sticky-fly-cart/assets/css/sticky-fly-cart.css');
		wp_enqueue_script('shopengine-sticky-fly-cart', \ShopEngine_Pro::module_url() . 'sticky-fly-cart/assets/js/sticky-fly-cart.js', ['jquery'], \ShopEngine_Pro::version(), true);
		
		$settings = Module_List::instance()->get_settings('sticky-fly-cart');
		extract($settings);

		// fixed cart styles
		$cart_button_size				= !empty($sticky_button['value'][0]['size']) ? $sticky_button['value'][0]['size'] : '60px';
		$cart_button_icon_size			= !empty($sticky_button['value'][0]['icon_size']) ? $sticky_button['value'][0]['icon_size'] : '25px';
		$cart_button_color				= !empty($sticky_button['value'][0]['color']) ? $sticky_button['value'][0]['color'] : '#101010';
		$cart_button_bg					= !empty($sticky_button['value'][0]['bg']) ? $sticky_button['value'][0]['bg'] : '#ffffff';
		$cart_button_pos_top			= !empty($sticky_button['value'][0]['pos_top']) ? $sticky_button['value'][0]['pos_top'] : 'auto';
		$cart_button_pos_right			= !empty($sticky_button['value'][0]['pos_right']) ? $sticky_button['value'][0]['pos_right'] : '12px';
		$cart_button_pos_bottom			= !empty($sticky_button['value'][0]['pos_bottom']) ? $sticky_button['value'][0]['pos_bottom'] : '12px';
		$cart_button_pos_left			= !empty($sticky_button['value'][0]['pos_left']) ? $sticky_button['value'][0]['pos_left'] : 'auto';

		// fixed cart counter styles
		$cart_button_counter_size		= !empty($sticky_button_counter['value'][0]['size']) ? $sticky_button_counter['value'][0]['size'] : '32px';
		$cart_button_counter_font_size	= !empty($sticky_button_counter['value'][0]['font_size']) ? $sticky_button_counter['value'][0]['font_size'] : '16px';
		$cart_button_counter_color		= !empty($sticky_button_counter['value'][0]['color']) ? $sticky_button_counter['value'][0]['color'] : '#FFFFFF';
		$cart_button_counter_bg			= !empty($sticky_button_counter['value'][0]['bg']) ? $sticky_button_counter['value'][0]['bg'] : '#FF3F00';
		$cart_button_counter_pos_top	= !empty($sticky_button_counter['value'][0]['pos_top']) ? $sticky_button_counter['value'][0]['pos_top'] : '-15px';
		$cart_button_counter_pos_right	= !empty($sticky_button_counter['value'][0]['pos_right']) ? $sticky_button_counter['value'][0]['pos_right'] : 'auto';
		$cart_button_counter_pos_bottom	= !empty($sticky_button_counter['value'][0]['pos_bottom']) ? $sticky_button_counter['value'][0]['pos_bottom'] : 'auto';
		$cart_button_counter_pos_left	= !empty($sticky_button_counter['value'][0]['pos_left']) ? $sticky_button_counter['value'][0]['pos_left'] : '-15px';

		// cart body styles
		$mini_cart_body_color			= !empty($cart_body['value'][0]['color']) ? $cart_body['value'][0]['color'] : '#101010';
		$mini_cart_body_link_hover_color= !empty($cart_body['value'][0]['link_hover_color']) ? $cart_body['value'][0]['link_hover_color'] : '#312b2b';
		$mini_cart_body_bg				= !empty($cart_body['value'][0]['bg']) ? $cart_body['value'][0]['bg'] : '#ffffff';
		$mini_cart_body_padding			= !empty($cart_body['value'][0]['padding']) ? $cart_body['value'][0]['padding'] : '15px';
		$mini_cart_body_width			= !empty($cart_body['value'][0]['width']) ? $cart_body['value'][0]['width'] : '350px';

		// cart header styles
		$mini_cart_header_padding		= !empty($cart_header['value'][0]['padding']) ? $cart_header['value'][0]['padding'] : '0 0 10px 0';

		// cart items styles
		$mini_cart_items_padding		= !empty($cart_items['value'][0]['padding']) ? $cart_items['value'][0]['padding'] : '15px 10px 15px 0';
		$mini_cart_items_border_bottom	= !empty($cart_items['value'][0]['border_bottom']) ? $cart_items['value'][0]['border_bottom'] : '1px solid #e6ebee';
		$mini_cart_items_font_size		= !empty($cart_items['value'][0]['font_size']) ? $cart_items['value'][0]['font_size'] : '15px';

		// cart subtotal styles
		$mini_cart_subtotal_padding		= !empty($cart_subtotal['value'][0]['padding']) ? $cart_subtotal['value'][0]['padding'] : '15px 0';

		// cart buttons styles
		$mini_cart_buttons_wrap_padding	= !empty($cart_buttons['value'][0]['wrap_padding']) ? $cart_buttons['value'][0]['wrap_padding'] : '15px';
		$mini_cart_buttons_padding		= !empty($cart_buttons['value'][0]['padding']) ? $cart_buttons['value'][0]['padding'] : '12px 10px 12px 10px';
		$mini_cart_buttons_color		= !empty($cart_buttons['value'][0]['color']) ? $cart_buttons['value'][0]['color'] : '#ffffff';
		$mini_cart_buttons_bg			= !empty($cart_buttons['value'][0]['bg']) ? $cart_buttons['value'][0]['bg'] : '#101010';
		$mini_cart_buttons_hover_bg		= !empty($cart_buttons['value'][0]['hover_bg']) ? $cart_buttons['value'][0]['hover_bg'] : '#312b2b';

		$custom_css = "

		:root {
			--sticky-fly-cart-button-size: $cart_button_size;
			--sticky-fly-cart-button-icon-size: $cart_button_icon_size;
			--sticky-fly-cart-button-color: $cart_button_color;
			--sticky-fly-cart-button-bg: $cart_button_bg;
			--sticky-fly-cart-button-pos-top: $cart_button_pos_top;
			--sticky-fly-cart-button-pos-right: $cart_button_pos_right;
			--sticky-fly-cart-button-pos-bottom: $cart_button_pos_bottom;
			--sticky-fly-cart-button-pos-left: $cart_button_pos_left;

			--sticky-fly-cart-button-counter-size: $cart_button_counter_size;
			--sticky-fly-cart-button-counter-font-size: $cart_button_counter_font_size;
			--sticky-fly-cart-button-counter-color: $cart_button_counter_color;
			--sticky-fly-cart-button-counter-bg: $cart_button_counter_bg;
			--sticky-fly-cart-button-counter-pos-top: $cart_button_counter_pos_top;
			--sticky-fly-cart-button-counter-pos-right: $cart_button_counter_pos_right;
			--sticky-fly-cart-button-counter-pos-bottom: $cart_button_counter_pos_bottom;
			--sticky-fly-cart-button-counter-pos-left: $cart_button_counter_pos_left;

			--cart-body-color: $mini_cart_body_color;
			--cart-body-link_hover_color: $mini_cart_body_link_hover_color;
			--cart-body-bg: $mini_cart_body_bg;
			--cart-body-padding: $mini_cart_body_padding;
			--cart-body-width: $mini_cart_body_width;

			--cart-header-padding: $mini_cart_header_padding;

			--cart-items-padding: $mini_cart_items_padding;
			--cart-items-border-bottom: $mini_cart_items_border_bottom;
			--cart-items-title-font-size: $mini_cart_items_font_size;

			--cart-subtotal-padding: $mini_cart_subtotal_padding;

			--cart-buttons-wrap-padding: $mini_cart_buttons_wrap_padding;
			--cart-buttons-padding: $mini_cart_buttons_padding;
			--cart-buttons-wrap-color: $mini_cart_buttons_color;
			--cart-buttons-wrap-bg: $mini_cart_buttons_bg;
			--cart-buttons-wrap-hover-bg: $mini_cart_buttons_hover_bg;
		}
		
		";
		wp_add_inline_style( 'shopengine-sticky-fly-cart', $custom_css);
	}

	public function need_to_disable() {

		$settings = Module_List::instance()->get_settings('sticky-fly-cart');
		$exclude_pages = !empty($settings['exclude_pages']['value']) ? $settings['exclude_pages']['value'] : [];
		$current_page_id = get_the_ID();

		if(is_shop()) {
			$current_page_id = get_option('woocommerce_shop_page_id');
		}

	 	return in_array($current_page_id, $exclude_pages);
	}
}