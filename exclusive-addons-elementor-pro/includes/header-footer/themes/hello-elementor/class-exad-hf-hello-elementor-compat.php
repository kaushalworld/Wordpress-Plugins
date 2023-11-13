<?php

/**
 * Hello Elementor compatibility.
 */
namespace ExclusiveAddons\Pro\Includes\HeaderFooter;

class Compatibility {

	/**
	 * Instance of Compatibility.
	 *
	 * @var Compatibility
	 */
	private static $instance;

	/**
	 *  Initiator
	 */
	public static function instance() {
		if ( ! isset( self::$instance ) ) :
			self::$instance = new Compatibility();
			require_once EXAD_PRO_PATH . 'includes/header-footer/themes/default/class-exad-default-compat.php';
		endif;

		return self::$instance;
	}
}

Compatibility::instance();
