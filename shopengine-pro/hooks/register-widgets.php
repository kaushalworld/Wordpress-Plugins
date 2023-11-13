<?php

namespace ShopEngine_Pro\Hooks;

defined( 'ABSPATH' ) || exit;

class Register_Widgets {

	public function __construct() {
		add_filter( 'shopengine/widgets/list', [ $this, 'get_list' ] );
	}

	public function get_list( $list ) {

		$pro_list = [
			'account-dashboard'          => [
				'slug'    => 'account-dashboard',
				'title'   => esc_html__( 'Account Dashboard', 'shopengine-pro' ),
				'package' => 'pro',
			],
			'account-address'          => [
				'slug'    => 'account-address',
				'title'   => esc_html__( 'Account Address', 'shopengine-pro' ),
				'package' => 'pro',
			],
			'account-details'          => [
				'slug'    => 'account-details',
				'title'   => esc_html__( 'Account Details', 'shopengine-pro' ),
				'package' => 'pro',
			],
			'account-downloads'        => [
				'slug'    => 'account-downloads',
				'title'   => esc_html__( 'Account Downloads', 'shopengine-pro' ),
				'package' => 'pro',
			],
			'account-form-login'       => [
				'slug'    => 'account-form-login',
				'title'   => esc_html__( 'Account Form - Login', 'shopengine-pro' ),
				'package' => 'pro',
			],
			'account-form-register'    => [
				'slug'    => 'account-form-register',
				'title'   => esc_html__( 'Account Form - Register', 'shopengine-pro' ),
				'package' => 'pro',
			],
			'account-logout'           => [
				'slug'    => 'account-logout',
				'title'   => esc_html__( 'Account Logout', 'shopengine-pro' ),
				'package' => 'pro',
			],
			'account-navigation'       => [
				'slug'    => 'account-navigation',
				'title'   => esc_html__( 'Account Navigation', 'shopengine-pro' ),
				'package' => 'pro',
			],
			'account-order-details'    => [
				'slug'    => 'account-order-details',
				'title'   => esc_html__( 'Account Order - Details', 'shopengine-pro' ),
				'package' => 'pro',
			],
			'account-orders'           => [
				'slug'    => 'account-orders',
				'title'   => esc_html__( 'Account Orders', 'shopengine-pro' ),
				'package' => 'pro',
			],
			'categories'               => [
				'slug'    => 'categories',
				'title'   => esc_html__( 'Categories', 'shopengine-pro' ),
				'package' => 'pro',
			],
			'product-filters'          => [
				'slug'    => 'product-filters',
				'title'   => esc_html__( 'Product Filters', 'shopengine-pro' ),
				'package' => 'pro',
			],
			'thankyou-address-details' => [
				'slug'    => 'thankyou-address-details',
				'title'   => esc_html__( 'Thank You Address Details', 'shopengine-pro' ),
				'package' => 'pro',
			],
			'thankyou-order-confirm'   => [
				'slug'    => 'thankyou-order-confirm',
				'title'   => esc_html__( 'Order Confirm', 'shopengine-pro' ),
				'package' => 'pro',
			],
			'thankyou-order-details'   => [
				'slug'    => 'thankyou-order-details',
				'title'   => esc_html__( 'Order Details', 'shopengine-pro' ),
				'package' => 'pro',
			],
			'thankyou-thankyou'        => [
				'slug'    => 'thankyou-thankyou',
				'title'   => esc_html__( 'Order Thank You', 'shopengine-pro' ),
				'package' => 'pro',
			],
			'currency-switcher' => [
				'slug'	=> 'currency-switcher',
				'title' => esc_html__('Currency Switcher', 'shopengine-pro'),
				'package' => 'pro'
			],
			'flash-sale-products'       => [
				'slug'    => 'flash-sale-products',
				'title'   => esc_html__('Flash Sale Products', 'shopengine-pro'),
				'package' => 'pro',
			],
			'best-selling-product'       => [
				'slug'    => 'best-selling-product',
				'title'   => esc_html__('Best Selling Product', 'shopengine-pro'),
				'package' => 'pro',
			],
			'comparison-button'         => [
				'slug'    => 'comparison-button',
				'title'   => esc_html__('Comparison Button', 'shopengine-pro'),
				'package' => 'pro',
			],
			'product-size-charts'         => [
				'slug'    => 'product-size-charts',
				'title'   => esc_html__('Product Size Chart', 'shopengine-pro'),
				'package' => 'pro',
			],
			'vacation'         => [
				'slug'    => 'vacation',
				'title'   => esc_html__('Vacation', 'shopengine-pro'),
				'package' => 'pro',
			],
			'advanced-coupon'         => [
				'slug'    => 'advanced-coupon',
				'title'   => esc_html__('Advanced Coupon', 'shopengine-pro'),
				'package' => 'pro',
			],
			'avatar'         => [
				'slug'    => 'avatar',
				'title'   => esc_html__('Avatar', 'shopengine-pro'),
				'package' => 'pro',
			],
			'account-form-lost-password'         => [
				'slug'    => 'account-form-lost-password',
				'title'   => esc_html__('Account Lost Password', 'shopengine-pro'),
				'package' => 'pro',
			],
			'account-form-reset-password'         => [
				'slug'    => 'account-form-reset-password',
				'title'   => esc_html__('Account Reset Password', 'shopengine-pro'),
				'package' => 'pro',
			],
			'checkout-order-pay'         => [
				'slug'    => 'checkout-order-pay',
				'title'   => esc_html__('Checkout Order Pay', 'shopengine-pro'),
				'package' => 'pro'
			],
			'product-carousel'         => [
				'slug'    => 'product-carousel',
				'title'   => esc_html__('Product Carousel', 'shopengine-pro'),
				'package' => 'pro'
			]
		];

		return array_merge( $list, array_map(function($v){
			$v['path'] = \ShopEngine_Pro::widget_dir() . $v['slug'] . '/';
			return $v;
		}, $pro_list));
	}
}