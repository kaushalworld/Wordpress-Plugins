<?php

/**
 * Storefront theme compatibility.
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
			add_action( 'template_redirect', [ $this, 'setup_header' ], 10 );
			add_action( 'storefront_before_header', 'exad_render_header', 500 );
		endif;

		if ( exad_footer_enabled() ) :
			add_action( 'template_redirect', [ $this, 'setup_footer' ], 10 );
			add_action( 'storefront_after_footer', 'exad_render_footer', 500 );
		endif;

		if ( exad_header_enabled() || exad_footer_enabled() ) :
			add_action( 'wp_enqueue_scripts', [ $this, 'styles' ] );
		endif;
	}

	/**
	 * Add inline CSS to hide empty divs for header and footer in storefront
	 *
	 * @return void
	 */
	public function styles() {
		$css = '';

		if ( true === exad_header_enabled() ) :
			$css .= '.site-header {
				display: none;
			}';
		endif;

		if ( true === exad_footer_enabled() ) :
			$css .= '.site-footer {
				display: none;
			}';
		endif;

		wp_add_inline_style( 'exad-hf-style', $css );
	}

	/**
	 * Disable header from the theme.
	 */
	public function setup_header() {
		for ( $priority = 0; $priority < 200; $priority ++ ) :
			remove_all_actions( 'storefront_header', $priority );
		endfor;
	}

	/**
	 * Disable footer from the theme.
	 */
	public function setup_footer() {
		for ( $priority = 0; $priority < 200; $priority ++ ) :
			remove_all_actions( 'storefront_footer', $priority );
		endfor;
	}

}

Compatibility::instance();
