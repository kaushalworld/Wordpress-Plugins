<?php

namespace ShopEngine_Pro\Modules\Sales_Notification;

use ShopEngine\Traits\Singleton;
use ShopEngine\Core\Register\Module_List;

class Sales_Notification {
	use Singleton;


	public function init() {

		add_action('wp_enqueue_scripts', [$this, 'scripts'] );
    	add_action('wp_footer', [$this, 'screens']);

		new Api();
	}
	/**
	 * 
	 * Load footer content
	 *  
	 */ 
	public function screens(){
		// Disabled sales notifications loading in elementor edit view
		if( class_exists('\Elementor\Plugin') && \Elementor\Plugin::$instance->preview->is_preview_mode()) { return false; }

		include plugin_dir_path(__FILE__) . 'screens/footer.php';
	}

	/**
	 * 
	 * enqueue all necessary scripts for this module
	 *  
	 */
	public function scripts(){
		// Disabled sales notifications loading in elementor edit view
		if( class_exists('\Elementor\Plugin') && \Elementor\Plugin::$instance->preview->is_preview_mode() ) { return false; }

		if( !isset($_COOKIE['shopengine_wsnc']) ) {
			wp_enqueue_style( 'wsnc-style', \ShopEngine_Pro::module_url()  . 'sales-notification/assets/css/main.css', [], \ShopEngine_Pro::version() );
			wp_enqueue_script( 'wsnc-js-defer', \ShopEngine_Pro::module_url()  . 'sales-notification/assets/js/main.js', ['jquery'], \ShopEngine_Pro::version(), true );
		}

		// get value form dashboard settings
		$settings = Module_List::instance()->get_settings('sales-notification');

		$cookiesExpire = isset($settings['cookie_expire_in_days']['value']) ? $settings['cookie_expire_in_days']['value'] : 1;
		$notificatonInterval = isset($settings['notification_interval_in_ms']['value']) ? $settings['notification_interval_in_ms']['value'] : 7000;
		$notificationDelay = isset($settings['notification_delay']['value']) ? $settings['notification_delay']['value'] : 4000;
		

		/**
		 * pass user configurable data to script file 
		 * @method wp_localize_script
		 * 
		 */

		$data = array(
			'cookieExpireInDays' => $cookiesExpire,
			'notificationIntervalInMs' => $notificatonInterval,
			'notificationDelay' => $notificationDelay,
			'api' => get_rest_url(null, 'shopengine-builder/v1/sales_notification'),
			'purchasedTitle' => esc_html__('Purchased', 'shopengine-pro')
		);

		wp_localize_script( 'wsnc-js-defer', 'wsnc_var', $data );

		// configure notification panel style		
		$this->configure_style( $settings );
	}

	/**
	 * 
	 * confgure the notification layout
	 * @method configure_style
	 * @param $settings contains all the settings value defined by user form dashboard
	 * 
	 */
	public function configure_style ( $settings ) { 

		$color	= isset($settings['color']['value']) ? $settings['color']['value'] : '#4f4f4f25';
		$radius = isset($settings['radius']['value']) ? $settings['radius']['value'] : 60;
		
		// remove alpha from color
		if( strlen($color) > 7 ) {
			$color	= substr($color, 0, -2);
		}
		
		$output = "
		:root {
			--shopengine-sn-primary-clr: $color;
			--shopengine-sn-shadow: -2px 7px 25px ". $color ."25;
			--shopengine-sn-radius: ". $radius ."px;
			--shopengine-sn-text-clr: #05264a;
			--shopengine-sn-bg-clr: #ffffff;
			--shopengine-sn-transition: all 0.3s ease-out;
			--shopengine-sn-wrapper-width: 320px;
		}
		";

		wp_add_inline_style( 'wsnc-style', $output );
	}

}
