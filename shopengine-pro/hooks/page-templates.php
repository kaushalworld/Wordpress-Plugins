<?php

namespace ShopEngine_Pro\Hooks;

defined('ABSPATH') || exit;

class Page_Templates {

	public function __construct() {
		add_filter('shopengine/page_templates', [$this, 'get_list'], 1);
		add_filter('shopengine_template_category_id', [$this, 'get_template_category_id']);
	}

	public function get_template_category_id($category_id) {
		if(is_product()) {
			$terms       = wc_get_product_terms(get_the_ID(), 'product_cat', ['orderby' => 'parent', 'order' => 'DESC']);
			return $terms[0]->parent !== 0 ? $terms[0]->parent : $terms[0]->term_id;
		} elseif(is_archive() && !is_shop()) {
			$category = get_queried_object();
			return isset($category->term_id) ? $category->term_id : $category_id;
		}
		return $category_id;
	}

	public function get_list($list): array {

		return array_merge($list, [
			'order'            => [
				'title'   => esc_html__('Order / Thank you', 'shopengine-pro'),
				'package' => 'pro',
				'class'   => 'ShopEngine_Pro\Templates\Hooks\Thank_You',
				'opt_key' => 'order',
				'css'     => 'order',
				'url'	  => get_permalink( wc_get_page_id( 'checkout' ) )
			],
			'my_account_login' => [
				'title'   => esc_html__('My Account Login / Register', 'shopengine-pro'),
				'package' => 'pro',
				'class'   => 'ShopEngine_Pro\Templates\Hooks\Account_Login',
				'opt_key' => 'my_account_login',
				'css'     => 'account-login-register',
			],
			'my_account'       => [
				'title'   => esc_html__('Account Dashboard', 'shopengine-pro'),
				'package' => 'pro',
				'class'   => 'ShopEngine_Pro\Templates\Hooks\Account',
				'opt_key' => 'my_account',
				'css'     => 'account',
				'url'	  => get_permalink( wc_get_page_id( 'myaccount' ) )
			],
			'account_orders'       => [
				'title'   => esc_html__('My Account Orders', 'shopengine-pro'),
				'package' => 'pro',
				'class'   => 'ShopEngine_Pro\Templates\Hooks\Account_Orders',
				'opt_key' => 'account_orders',
				'css'     => 'account-orders',
				'url'	  => get_permalink( wc_get_page_id( 'myaccount' ) )
			],
			'account_downloads'    => [
				'title'   => esc_html__('My Account Downloads', 'shopengine-pro'),
				'package' => 'pro',
				'class'   => 'ShopEngine_Pro\Templates\Hooks\Account_Downloads',
				'opt_key' => 'account_downloads',
				'css'     => 'account-downloads',
				'url'	  => get_permalink( wc_get_page_id( 'myaccount' ) )
			],
			'account_orders_view'  => [
				'title'   => esc_html__('My Account Order Details', 'shopengine-pro'),
				'package' => 'pro',
				'class'   => 'ShopEngine_Pro\Templates\Hooks\Account_Orders_View',
				'opt_key' => 'account_orders_view',
				'css'     => 'account-orders-view',
				'url'	  => get_permalink( wc_get_page_id( 'myaccount' ) )
			],
			'account_edit_account' => [
				'title'   => esc_html__('My Account Details', 'shopengine-pro'),
				'package' => 'pro',
				'class'   => 'ShopEngine_Pro\Templates\Hooks\Account_Details',
				'opt_key' => 'account_edit_account',
				'css'     => 'account-details',
				'url'	  => get_permalink( wc_get_page_id( 'myaccount' ) )
			],
			'account_edit_address' => [
				'title'   => esc_html__('My Account Address', 'shopengine-pro'),
				'package' => 'pro',
				'class'   => 'ShopEngine_Pro\Templates\Hooks\Account_Address',
				'opt_key' => 'account_edit_address',
				'css'     => 'account-address',
				'url'	  => get_permalink( wc_get_page_id( 'myaccount' ) )
			],
			'lost-password'     => [
				'title'   => esc_html__('My Account Lost Password', 'shopengine-pro'),
				'package' => 'pro',
				'class'   => 'ShopEngine_Pro\Templates\Hooks\Lost_Password',
				'opt_key' => 'lost-password',
				'css'     => 'lost-password',
				'url'     => get_permalink(wc_get_page_id('myaccount')),
			],
			'reset-password'     => [
				'title'   => esc_html__('My Account Reset Password', 'shopengine-pro'),
				'package' => 'pro',
				'class'   => 'ShopEngine_Pro\Templates\Hooks\Reset_Password',
				'opt_key' => 'reset-password',
				'css'     => 'reset-password',
				'url'     => get_permalink(wc_get_page_id('myaccount')),
			],
			'empty-cart'     => [
				'title'   => esc_html__('Empty Cart', 'shopengine-pro'),
				'package' => 'pro',
				'class'   => 'ShopEngine_Pro\Templates\Hooks\Empty_Cart',
				'opt_key' => 'empty-cart',
				'css'     => 'empty-cart',
				'url'     => get_permalink(wc_get_page_id('cart')),
			],
			'checkout-order-pay' => [
				'title'   => esc_html__('Checkout Order Pay', 'shopengine-pro'),
				'package' => 'pro',
				'class'   => 'ShopEngine_Pro\Templates\Hooks\Checkout_Order_Pay',
				'opt_key' => 'checkout-order-pay',
				'css'     => 'checkout-order-pay',
				'url'     => get_permalink(wc_get_page_id('checkout')). '/order-pay',
			]
		]);
	}
}
