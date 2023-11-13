<?php
/**
 * GeneratepressCompatibility.
 */

namespace ExclusiveAddons\Pro\Includes\HeaderFooter;

class Compatibility {

	/**
	 * Instance of Compatibility
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

			add_action( 'wp', [ self::$instance, 'hooks' ] );
		endif;

		return self::$instance;
	}

	/**
	 * Run all the Actions / Filters.
	 */
	public function hooks() {
		if ( exad_header_enabled() ) :
			add_action( 'template_redirect', [ $this, 'generatepress_setup_header' ] );
			add_action( 'generate_header', 'exad_render_header' );
		endif;

		if ( exad_footer_enabled() ) :
			add_action( 'template_redirect', [ $this, 'generatepress_setup_footer' ] );
			add_action( 'generate_footer', 'exad_render_footer' );
		endif;
	}

	/**
	 * Disable header from the theme.
	 */
	public function generatepress_setup_header() {
		remove_action( 'generate_header', 'generate_construct_header' );
		remove_action( 'generate_after_header', 'generate_add_navigation_after_header', 5 );
	}

	/**
	 * Disable footer from the theme.
	 */
	public function generatepress_setup_footer() {
		remove_action( 'generate_footer', 'generate_construct_footer_widgets', 5 );
		remove_action( 'generate_footer', 'generate_construct_footer' );
	}

}

Compatibility::instance();
