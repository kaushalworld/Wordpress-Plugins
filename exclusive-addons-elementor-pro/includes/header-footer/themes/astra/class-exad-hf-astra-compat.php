<?php

/**
 * Astra theme compatibility.
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

			add_action( 'wp', [ self::$instance, 'hooks' ] );
		endif;

		return self::$instance;
	}

	/**
	 * Run all the Actions / Filters.
	 */
	public function hooks() {
		if ( exad_header_enabled() ) :
			add_action( 'template_redirect', [ $this, 'astra_setup_header' ], 10 );
			add_action( 'astra_header', 'exad_render_header' );
		endif;

		if ( exad_footer_enabled() ) :
			add_action( 'template_redirect', [ $this, 'astra_setup_footer' ], 10 );
			add_action( 'astra_footer', 'exad_render_footer' );
		endif;
	}

	/**
	 * Disable header from the theme.
	 */
	public function astra_setup_header() {
		remove_action( 'astra_header', 'astra_header_markup' );
	}

	/**
	 * Disable footer from the theme.
	 */
	public function astra_setup_footer() {
		remove_action( 'astra_footer', 'astra_footer_markup' );
	}

}

Compatibility::instance();
