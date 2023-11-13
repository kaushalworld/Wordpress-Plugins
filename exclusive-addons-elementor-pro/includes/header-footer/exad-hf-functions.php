<?php
/**
 * Header Footer Function
 */

use ExclusiveAddons\Pro\Includes\Header_Footer;

/**
 * Checks if Header is enabled from HFE.
 *
 * @return bool True if header is enabled. False if header is not enabled
 */
function exad_header_enabled() {
	$header_id = Header_Footer::get_settings( 'type_header', '' );
	$status    = false;

	if ( '' !== $header_id ) :
		$status = true;
	endif;

	return apply_filters( 'exad_header_enabled', $status );
}

/**
 * Checks if Footer is enabled from HFE.
 *
 * @return bool True if header is enabled. False if header is not enabled.
 */
function exad_footer_enabled() {
	$footer_id = Header_Footer::get_settings( 'type_footer', '' );
	$status    = false;

	if ( '' !== $footer_id ) :
		$status = true;
	endif;

	return apply_filters( 'exad_footer_enabled', $status );
}

/**
 * Get HFE Header ID
 *
 * @return (String|boolean) header id if it is set else returns false.
 */
function get_exad_header_id() {
	$header_id = Header_Footer::get_settings( 'type_header', '' );

	if ( '' === $header_id ) :
		$header_id = false;
	endif;

	return apply_filters( 'get_exad_header_id', $header_id );
}

/**
 * Get HFE Footer ID
 *
 * @return (String|boolean) header id if it is set else returns false.
 */
function get_exad_footer_id() {
	$footer_id = Header_Footer::get_settings( 'type_footer', '' );

	if ( '' === $footer_id ) :
		$footer_id = false;
	endif;

	return apply_filters( 'get_exad_footer_id', $footer_id );
}

/**
 * Display header markup.
 *
 */
function exad_render_header() {

	if ( false == apply_filters( 'enable_exad_render_header', true ) ) :
		return;
	endif;

	$sticky_header = get_post_meta( get_exad_header_id(), 'sticky-header', true );

	$render_class = '';
	if ( $sticky_header ) {
		$render_class .= 'exad-sticky-header';
	}

	?>
		<header id="exad-masthead" class="<?php echo $render_class; ?>" itemscope="itemscope" itemtype="https://schema.org/WPHeader">
			<?php Header_Footer::get_header_content(); ?>
		</header>

	<?php

}

/**
 * Display footer markup.
 *
 */
function exad_render_footer() {

	if ( false == apply_filters( 'enable_exad_render_footer', true ) ) :
		return;
	endif;

	?>
		<footer itemtype="https://schema.org/WPFooter" itemscope="itemscope" id="colophon" role="contentinfo">
			<?php ExclusiveAddons\Pro\Includes\Header_Footer::get_footer_content(); ?>
		</footer>
	<?php

}