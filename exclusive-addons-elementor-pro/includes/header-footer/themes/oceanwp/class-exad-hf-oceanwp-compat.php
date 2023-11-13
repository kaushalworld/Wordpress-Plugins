<?php
/**
 * OceanWP theme compatibility.
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
			add_action( 'ocean_header', 'exad_render_header' );
		endif;

		if ( exad_footer_enabled() ) :
			add_action( 'template_redirect', [ $this, 'setup_footer' ], 10 );
			add_action( 'ocean_footer', 'exad_render_footer' );
		endif;
	}

	/**
	 * Disable header from the theme.
	 */
	public function setup_header() {
		remove_action( 'ocean_top_bar', 'oceanwp_top_bar_template' );
		remove_action( 'ocean_header', 'oceanwp_header_template' );
		remove_action( 'ocean_page_header', 'oceanwp_page_header_template' );
	}

	/**
	 * Disable footer from the theme.
	 */
	public function setup_footer() {
		remove_action( 'ocean_footer', 'oceanwp_footer_template' );
	}

}

Compatibility::instance();
