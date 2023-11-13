<?php
/**
 * Default_Compat setup
 */

namespace ExclusiveAddons\Pro\Includes\HeaderFooter;

/**
 * Exad theme compatibility.
 */
class Default_Compat {

	/**
	 *  Initiator
	 */
	public function __construct() {
		add_action( 'wp', [ $this, 'hooks' ] );
	}

	/**
	 * Run all the Actions / Filters.
	 */
	public function hooks() {
		if ( exad_header_enabled() ) :
			// Replace header.php template.
			add_action( 'get_header', [ $this, 'override_header' ] );

			// Display Exad_HF's header in the replaced header.
			add_action( 'exad_hf_header', 'exad_render_header' );
		endif;

		if ( exad_footer_enabled() ) :
			// Replace footer.php template.
			add_action( 'get_footer', [ $this, 'override_footer' ] );
		endif;

		if ( exad_footer_enabled() ) :
			// Display Exad_HF's footer in the replaced header.
			add_action( 'exad_hf_footer', 'exad_render_footer' );
		endif;
	}

	/**
	 * Function for overriding the header in the elmentor way.
	 *
	 * @return void
	 */
	public function override_header() {
		require_once EXAD_PRO_PATH . 'includes/header-footer/themes/default/exad-header.php';
		$templates   = [];
		$templates[] = 'header.php';
		// Avoid running wp_head hooks again.
		remove_all_actions( 'wp_head' );
		ob_start();
		locate_template( $templates, true );
		ob_get_clean();
	}

	/**
	 * Function for overriding the footer in the elmentor way.
	 *
	 * @return void
	 */
	public function override_footer() {
		require_once EXAD_PRO_PATH . 'includes/header-footer/themes/default/exad-footer.php';
		$templates   = [];
		$templates[] = 'footer.php';
		// Avoid running wp_footer hooks again.
		remove_all_actions( 'wp_footer' );
		ob_start();
		locate_template( $templates, true );
		ob_get_clean();
	}

}

new Default_Compat();
