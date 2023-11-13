<?php

namespace ShopEngine_Pro\Hooks;

class Pro_Sample_Designs {

	public function __construct() {

		add_filter('shopengine/templates/sample-designs', [$this, 'load_sample_design']);
	}

	public function load_sample_design($designs) {

		//$content_domain = 'https://api.wpmet.com/public/shopengine-layouts/contents/account-dashboard/01/preview.jpg';
		//$content_domain = 'https://api.wpmet.com/public/shopengine-layouts/';
		$content_domain = \ShopEngine_Pro::plugin_dir() . 'sample-designs/';

		return array_merge($designs, [
			'order' => [
				[
					'id'            => 'order-01',
					'package'       => 'free',
					'title'         => 'Order/Thank You Design 1',
					'preview_thumb' => $content_domain.'contents/order/01/preview.jpg',
					'demo_url'      => 'https://demo.xpeedstudio.com/bajaar/shopengine-template/order-thank-you/',
					'file'          => $content_domain.'contents/order/01/content.json',
				]
			],
			'quick_checkout' => [
				[
					'id'            => 'quickcheckout-01',
					'package'       => 'free',
					'title'         => 'Quick Checkout Design 1',
					'preview_thumb' => $content_domain.'contents/quickcheckout/01/preview.jpg',
					'demo_url'      => 'https://demo.xpeedstudio.com/bajaar/checkout/',
					'file'          => $content_domain.'contents/quickcheckout/01/content.json',
				]
			],
			'my_account' => [
				[
					'id'            => 'account-dashboard-01',
					'package'       => 'free',
					'title'         => 'Account Dashboard Design 1',
					'preview_thumb' => $content_domain.'contents/account-dashboard/01/preview.jpg',
					'demo_url'      => 'https://demo.xpeedstudio.com/bajaar/shopengine-template/account-page-template/',
					'file'          => $content_domain.'contents/account-dashboard/01/content.json',
				]
			],
			'account_orders' => [
				[
					'id'            => 'account-orders-01',
					'package'       => 'free',
					'title'         => 'Account Orders Design 1',
					'preview_thumb' => $content_domain.'contents/account-orders/01/preview.jpg',
					'demo_url'      => 'https://demo.xpeedstudio.com/bajaar/shopengine-template/account-orders-template/',
					'file'          => $content_domain.'contents/account-orders/01/content.json',
				]
			],
			'account_orders_view' => [
				[
					'id'            => 'account-order-details-01',
					'package'       => 'free',
					'title'         => 'Account Order Details Design 1',
					'preview_thumb' => $content_domain.'contents/account-order-details/01/preview.jpg',
					'demo_url'      => 'https://demo.xpeedstudio.com/bajaar/shopengine-template/account-order-view/',
					'file'          => $content_domain.'contents/account-order-details/01/content.json',
				]
			],
			'account_downloads' => [
				[
					'id'            => 'account-downloads-01',
					'package'       => 'free',
					'title'         => 'Account Downloads Design 1',
					'preview_thumb' => $content_domain.'contents/account-downloads/01/preview.jpg',
					'demo_url'      => 'https://demo.xpeedstudio.com/bajaar/shopengine-template/account-order-view/',
					'file'          => $content_domain.'contents/account-downloads/01/content.json',
				]
			],
			'account_edit_address' => [
				[
					'id'            => 'account-address-01',
					'package'       => 'free',
					'title'         => 'Account Address Design 1',
					'preview_thumb' => $content_domain.'contents/account-address/01/preview.jpg',
					'demo_url'      => 'https://demo.xpeedstudio.com/bajaar/shopengine-template/account-address/',
					'file'          => $content_domain.'contents/account-address/01/content.json',
				]
			],
			'account_edit_account' => [
				[
					'id'            => 'account-details-01',
					'package'       => 'free',
					'title'         => 'Account Details Design 1',
					'preview_thumb' => $content_domain.'contents/account-details/01/preview.jpg',
					'demo_url'      => 'https://demo.xpeedstudio.com/bajaar/shopengine-template/account-details/',
					'file'          => $content_domain.'contents/account-details/01/content.json',
				]
			],
			'my_account_login' => [
				[
					'id'            => 'account-login-register-01',
					'package'       => 'free',
					'title'         => 'Account Login/Register Design 1',
					'preview_thumb' => $content_domain.'contents/account-login-register/01/preview.jpg',
					'demo_url'      => 'https://demo.xpeedstudio.com/bajaar/shopengine-template/account-login-resister/',
					'file'          => $content_domain.'contents/account-login-register/01/content.json',
				]
			],
		]);
	}
}
