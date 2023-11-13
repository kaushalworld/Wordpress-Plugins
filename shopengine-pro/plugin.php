<?php

namespace ShopEngine_Pro;

defined( 'ABSPATH') || exit;


/**
 * ShopEngine_Pro - the God class.
 * Initiate all necessary classes, hooks, configs.
 *
 * @since 1.2.0
 */
class Plugin {


	/**
	 * The plugin instance.
	 *
	 * @since 1.0.0
	 * @access public
	 * @static
	 *
	 * @var Handler
	 */
	public static $instance = null;

	/**
	 * Construct the plugin object.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function __construct() {
		// Call the method for ShopEngine_Pro autoloader.
		$this->registrar_autoloader();

		new Hooks\Register_Modules();
		new Hooks\Register_Widgets();
		new Hooks\Page_Templates();
		//
		//new Hooks\Pro_Sample_Designs();

		new Widgets\Init\Enqueue_Scripts();

		// if($license->status() != 'valid' && apply_filters('shopengine_pro/license/hide_banner', false) != true){
		//     \Oxaim\Libs\Notice::instance('shopengine-pro', 'pro-not-active')
		//     ->set_class('error')
		//     ->set_dismiss('global', (3600 * 24 * 30))
		//     ->set_message(esc_html__('Please activate ShopEngine Pro to get automatic updates and premium support.', 'shopengine-pro'))
		//     ->set_button([
		//         'url' => self_admin_url('admin.php?page=shopengine-pro-license'),
		//         'text' => 'Activate License Now',
		//         'class' => 'button-primary'
		//     ])
		//     ->call();
		// }
	}


	/**
	 * Autoloader.
	 *
	 * ShopEngine_Pro autoloader loads all the classes needed to run the plugin.
	 *
	 * @since 1.0.0
	 * @access private
	 */
	private function registrar_autoloader() {
		require_once \ShopEngine_Pro::plugin_dir() . '/autoloader.php';
		Autoloader::run();

		require_once \ShopEngine_Pro::plugin_dir() . '/helpers/helper.php';
	}


	/**
	 * Instance.
	 *
	 * Ensures only one instance of the plugin class is loaded or can be loaded.
	 *
	 * @return Handler An instance of the class.
	 * @since 1.0.0
	 * @access public
	 * @static
	 *
	 */
	public static function instance() {
		if(is_null(self::$instance)) {

			// Fire when ShopEngine_Pro instance.
			self::$instance = new self();

			// Fire when ShopEngine_Pro was fully loaded and instantiated.
			do_action('shopengine_pro/loaded');
		}

		return self::$instance;
	}
}

// Run the instance.
Plugin::instance();
