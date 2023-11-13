<?php

use ShopEngine_Pro\Modules\Comparison\Comparison_Support;

defined('ABSPATH') || exit;

/**
 * Plugin Name: ShopEngine Pro
 * Description: The most advanced addons for Elementor with tons of widgets, layout pack and powerful custom controls.
 * Plugin URI: https://wpmet.com/plugins/shopengine
 * Author: Wpmet
 * Version: 2.2.2
 * Author URI: https://wpmet.com/
 *
 * Text Domain: shopengine-pro
 * Domain Path: /languages
 *
 */
update_option('__shopengine_oppai__', 1);
update_option('__shopengine_license_key__', '****-*******');
wp_cache_set('shopengine_pro__license_status', 'valid');
wp_cache_set('shopengine_pro__license_key', ['checksum' => 1, 'key' => '****-*******',]);
if(!class_exists('ShopEngine_Pro')) {

	final class ShopEngine_Pro {

		/**
		 * Plugin Version
		 *
		 * @since 1.0.0
		 * @var string The plugin version.
		 */
		static function version() {
			return '2.2.2';
		}

		/**
		 * Package type
		 *
		 * @since 1.2.0
		 * @var string The plugin purchase type [pro/ free].
		 */
		static function package_type() {
			return 'pro';
		}

		/**
		 * Product ID
		 *
		 * @since 1.2.6
		 * @var string The plugin ID in our server.
		 */
		static function product_id() {
			return '115390';
		}

		/**
		 * Author Name
		 *
		 * @since 1.3.1
		 * @var string The plugin author.
		 */
		static function author_name() {
			return 'Wpmet';
		}

		/**
		 * Store Name
		 *
		 * @since 1.3.1
		 * @var string The store name: self site, envato.
		 */
		static function store_name() {
			return 'wpmet';
		}

		/**
		 * Minimum ShopEngine_Pro Version
		 *
		 * @since 1.0.0
		 * @var string Minimum ShopEngine_Pro version required to run the plugin.
		 */
		static function min_shopengine_version() {
			return '1.1.8';
		}

		/**
		 * Plugin file
		 *
		 * @since 1.0.0
		 * @var string plugin's root file.
		 */
		static function plugin_file() {
			return __FILE__;
		}

		/**
		 * Plugin url
		 *
		 * @since 1.0.0
		 * @var string plugin's root url.
		 */
		static function plugin_url() {
			return trailingslashit(plugin_dir_url(__FILE__));
		}

		/**
		 * Plugin dir
		 *
		 * @since 1.0.0
		 * @var string plugin's root directory.
		 */
		static function plugin_dir() {
			return trailingslashit(plugin_dir_path(__FILE__));
		}

		/**
		 * Plugin's widget directory.
		 *
		 * @since 1.0.0
		 * @var string widget's root directory.
		 */
		static function widget_dir() {
			return self::plugin_dir() . 'widgets/';
		}

		/**
		 * Plugin's widget url.
		 *
		 * @since 1.0.0
		 * @var string widget's root url.
		 */
		static function widget_url() {
			return self::plugin_url() . 'widgets/';
		}


		/**
		 * API url
		 *
		 * @since 1.0.0
		 * @var string for license, layout notification related functions.
		 */
		static function api_url() {
			return 'https://api.wpmet.com/public/';
		}

		/**
		 * Account url
		 *
		 * @since 1.2.6
		 * @var string for plugin update notification, user account page.
		 */
		static function account_url() {
			return 'https://account.wpmet.com';
		}

		/**
		 * Plugin's module directory.
		 *
		 * @since 1.0.0
		 * @var string module's root directory.
		 */
		static function module_dir() {
			return self::plugin_dir() . 'modules/';
		}

		/**
		 * Plugin's module url.
		 *
		 * @since 1.0.0
		 * @var string module's root url.
		 */
		static function module_url() {
			return self::plugin_url() . 'modules/';
		}


		/**
		 * Plugin's lib directory.
		 *
		 * @since 1.0.0
		 * @var string lib's root directory.
		 */
		static function lib_dir() {
			return self::plugin_dir() . 'libs/';
		}

		/**
		 * Plugin's lib url.
		 *
		 * @since 1.0.0
		 * @var string lib's root url.
		 */
		static function lib_url() {
			return self::plugin_url() . 'libs/';
		}


		/**
		 * Constructor
		 *
		 * @since 1.0.0
		 * @access public
		 */
		public function __construct() {
			// Load the main static helper class.
			require_once self::plugin_dir() . 'libs/notice/notice.php';

			// Load translation
			add_action('init', [$this, 'i18n']);
			// Init Plugin
			$this->init();
		}

		/**
		 * Load Textdomain
		 *
		 * Load plugin localization files.
		 * Fired by `init` action hook.
		 *
		 * @since 1.0.0
		 * @access public
		 */
		public function i18n() {
			load_plugin_textdomain('shopengine-pro', false, dirname(plugin_basename(__FILE__)) . '/languages/');
		}

		/**
		 * Initialize the plugin
		 *
		 * Checks for basic plugin requirements, if one check fail don't continue,
		 * if all check have passed include the plugin class.
		 *
		 * Fired by `plugins_loaded` action hook.
		 *
		 * @since 1.0.0
		 * @access public
		 */
		public function init() {

			// init notice class
			\Oxaim\Libs\Notice::init();

			// Check if ShopEngine is installed and activated.
			if(!class_exists('ShopEngine')) {

				$this->missing_shopengine();

				return;
			}

			if(!version_compare(\ShopEngine::version(), self::min_shopengine_version(), '>=')) {

				$this->unmatched_shopengine_version();

				return;
			}

			// Once we get here, We have passed all validation checks so we can safely include our plugin.

			add_filter('shopengine/core/package_type', function ($package_type) {
				return self::package_type();
			});

			add_action('shopengine/before_loaded', function () {
				// Load the Handler class, it's the core class of ShopEngine_Pro.
				require_once self::plugin_dir() . 'plugin.php';
			});

			/**
			 * add pro version support for comparison module
			 */
			 add_action('shopengine/module/comparison-module-pro-support', function () {
				$comparison_support = new Comparison_Support();
				$comparison_support->init();
		 	}, 100);
		}

		/**
		 * Admin notice
		 *
		 * Warning when the site doesn't have required ShopEngine.
		 *
		 * @since 1.0.0
		 * @access public
		 */
		public function missing_shopengine() {
        	//phpcs:disable WordPress.Security.NonceVerification -- Can't set nonce. Cause it's fire on 'plugins_loaded' hook
			if(isset($_GET['activate'])) {
				unset($_GET['activate']);
			}
			//phpcs:enable
			$btn = [
				'default_class' => 'button',
				'class'         => 'button-primary ', // button-primary button-secondary button-small button-large button-link
			];

			if(file_exists(WP_PLUGIN_DIR . '/shopengine/shopengine.php')) {
				$btn['text'] = esc_html__('Activate ShopEngine', 'shopengine-pro');
				$btn['url']  = wp_nonce_url(self_admin_url('plugins.php?action=activate&plugin=shopengine/shopengine.php&plugin_status=all&paged=1'), 'activate-plugin_shopengine/shopengine.php');
			} else {
				$btn['text'] = esc_html__('Install ShopEngine', 'shopengine-pro');
				$btn['url']  = wp_nonce_url(self_admin_url('update.php?action=install-plugin&plugin=shopengine'), 'install-plugin_shopengine');
			}

			\Oxaim\Libs\Notice::instance('shopengine-pro', 'missing-shopengine')
			                  ->set_type('error')
			                  ->set_message(sprintf(esc_html__('ShopEngine Pro requires ShopEngine, which is currently NOT RUNNING. ', 'shopengine-pro')))
			                  ->set_button($btn)
			                  ->call();
		}

		public function unmatched_shopengine_version() {

			\Oxaim\Libs\Notice::instance('shopengine-pro', 'missing-shopengine')
			                  ->set_type('error')
			                  ->set_message(esc_html__('To run properly ShopEngine Pro requires ShopEngine minimum version 2.0.0-beta', 'shopengine-pro'))
			                  ->call();
		}
	}

	add_action('plugins_loaded', function () {
		do_action('shopengine_pro/before_loaded');
		new ShopEngine_Pro();
		do_action('shopengine_pro/after_loaded');
	}, 20);
}
