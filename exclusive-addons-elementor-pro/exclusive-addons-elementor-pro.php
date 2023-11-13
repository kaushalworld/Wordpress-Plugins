<?php
/**
 * Plugin Name: Exclusive Addons Elementor Pro
 * Plugin URI: https://exclusiveaddons.com/
 * Description: Packed with a bunch of Exclusively designed widgets for Elementor with all the customizations you ever imagined.
 * Version: 1.5.3
 * Author: DevsCred.com
 * Author URI: https://devscred.com/
 * Elementor tested up to: 3.13.2
 * Elementor Pro tested up to: 3.13.1
 * Text Domain: exclusive-addons-elementor
 * Domain Path: /languages
 * License: GPL3
 */

if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! defined( 'EXAD_PRO_PBNAME' ) ) define( 'EXAD_PRO_PBNAME', plugin_basename(__FILE__) );
if ( ! defined( 'EXAD_PRO_PATH' ) ) define( 'EXAD_PRO_PATH', plugin_dir_path( __FILE__ ) );
if ( ! defined( 'EXAD_PRO_ADMIN' ) ) define( 'EXAD_PRO_ADMIN', plugin_dir_path( __FILE__ ) . 'admin/' );	
if ( ! defined( 'EXAD_PRO_ADMIN_URL' ) ) define( 'EXAD_PRO_ADMIN_URL', plugins_url( '/', __FILE__ ) . 'admin/' );	
if ( ! defined( 'EXAD_PRO_ELEMENTS' ) ) define( 'EXAD_PRO_ELEMENTS', plugin_dir_path( __FILE__ ) . 'elements/' );
if ( ! defined( 'EXAD_PRO_EXTENSIONS' ) ) define( 'EXAD_PRO_EXTENSIONS', plugin_dir_path( __FILE__ ) . 'extensions/' );
if ( ! defined( 'EXAD_PRO_TEMPLATES' ) ) define( 'EXAD_PRO_TEMPLATES', plugin_dir_path( __FILE__ ) . 'includes/template-parts/' );
if ( ! defined( 'EXAD_PRO_URL' ) ) define( 'EXAD_PRO_URL', plugins_url( '/', __FILE__ ) );
if ( ! defined( 'EXAD_PRO_ASSETS_URL' ) ) define( 'EXAD_PRO_ASSETS_URL', EXAD_PRO_URL . 'assets/' );
if ( ! defined( 'EXAD_PRO_PLUGIN_VERSION' ) ) define( 'EXAD_PRO_PLUGIN_VERSION', '1.5.3' );
if ( ! defined( 'MINIMUM_ELEMENTOR_VERSION' ) ) define( 'MINIMUM_ELEMENTOR_VERSION', '2.0.0' );
if ( ! defined( 'MINIMUM_PHP_VERSION' ) ) define( 'MINIMUM_PHP_VERSION', '5.4' );

if ( ! defined( 'EXAD_SL_ITEM_SLUG' ) ) define( 'EXAD_SL_ITEM_SLUG', 'exclusive-addons-elementor' );
if ( ! defined( 'EXAD_SL_STORE_URL' ) ) define( 'EXAD_SL_STORE_URL', 'https://exclusiveaddons.com/' );
if ( ! defined( 'EXAD_SL_ITEM_ID' ) ) define( 'EXAD_SL_ITEM_ID', 5931 );
if ( ! defined( 'EXAD_SL_ITEM_NAME' ) ) define('EXAD_SL_ITEM_NAME', 'Exclusive Addons Elementor Pro');

update_option( 'exclusive-addons-elementor-license-key', '*********' );
update_option( 'exclusive-addons-elementor-license-status', 'valid' );
set_transient( 'exclusive-addons-elementor-license_data', ['license' => 'valid', 'license_limit' => '999'] );
/**
 * Check if Excluisve Addons is installed
 * 
 */
function is_exad_plugin_installed($basename) {
	if ( !function_exists('get_plugins') ) {
		include_once ABSPATH . 'wp-admin/includes/plugin.php';
	}

	$plugins = get_plugins();

	return isset($plugins[$basename]);
}

/**
* Exclusive Addons Plugin Missing notice
* 
*/
function excluisve_addons_plugin_missing_notice() {
	if ( !current_user_can( 'activate_plugins' ) ) {
		return;
	}

	if ( did_action( 'exad/exclusive_addons_active' ) ) {
		return;
	}

	$plugin = 'exclusive-addons-for-elementor/exclusive-addons-elementor.php';

	if ( is_exad_plugin_installed( $plugin ) ) {
		$activation_url = wp_nonce_url('plugins.php?action=activate&amp;plugin=' . $plugin . '&amp;plugin_status=all&amp;paged=1&amp;s', 'activate-plugin_' . $plugin);
		$message = __('<strong>Exclusive Addons Elementor - Pro</strong> requires <strong>Exclusive Addons Elementor</strong> plugin to be active. Please activate Exclusive Addons Elementor to continue.', 'exclusive-addons-elementor-pro');
		$button_text = __('Activate Exclusive Addons Elementor', 'exclusive-addons-elementor-pro');
	} else {
		$activation_url = wp_nonce_url( self_admin_url('update.php?action=install-plugin&plugin=exclusive-addons-for-elementor'), 'install-plugin_exclusive-addons-for-elementor' );
		$message = sprintf(__('<strong>Exclusive Addons Elementor - Pro</strong> requires <strong>Exclusive Addons Elementor</strong> plugin to be installed and activated. Please install Exclusive Addons Elementor to continue.', 'exclusive-addons-elementor-pro'), '<strong>', '</strong>');
		$button_text = __('Install Exclusive Addons Elementor', 'exclusive-addons-elementor-pro');
	}

	$button = '<p><a href="' . $activation_url . '" class="button-primary">' . $button_text . '</a></p>';

	printf('<div class="error"><p>%1$s</p>%2$s</div>', __($message), $button);
}

add_action( 'admin_notices', 'excluisve_addons_plugin_missing_notice' );


/**
 * 
 * Initiate plugin Base class
 *   
 * @return void
 */	
function exad_pro_initiate_plugin() {

	require_once EXAD_PRO_PATH . 'base.php';
	\ExclusiveAddons\Pro\Elementor\Base::instance();
} 
add_action( 'exad/before_init', 'exad_pro_initiate_plugin' );


/**
 * 
 * Plugin Updater 
 * 
 */
function exad_plugin_updater() {
	include_once EXAD_PRO_PATH . 'includes/plugin-updater.php';
	// Disable SSL verification
	add_filter('edd_sl_api_request_verify_ssl', '__return_false');
	// retrieve our license key from the DB
	$license_key = get_option( EXAD_SL_ITEM_SLUG . '-license-key' ); 

	// setup the updater
	$exad_updater = new \ExclusiveAddons\Pro\Elementor\Plugin_Updater( EXAD_SL_STORE_URL, EXAD_PRO_PBNAME, array(
		'version' 	=> EXAD_PRO_PLUGIN_VERSION,
		'license' 	=> $license_key,
		'item_id'   => EXAD_SL_ITEM_ID,
		'author'    => 'DevsCred'
	) );

}
add_action( 'plugins_loaded', 'exad_plugin_updater' );

/**
 * Load the HeaderFooter Class.
 */
function exad_hf_init() {
	include_once EXAD_PRO_PATH . 'includes/header-footer/class-exad-hf-elementor.php';
	ExclusiveAddons\Pro\Includes\Header_Footer::instance();
}

add_action( 'plugins_loaded', 'exad_hf_init' );