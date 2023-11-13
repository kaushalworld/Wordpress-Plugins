jQuery(document).ready(function ($) {
	var exad_hf_hide_shortcode_field = function() {
		var selected = jQuery('#ehf_template_type').val() || 'none';
		jQuery( '.exad-hf-options-table' ).removeClass().addClass( 'exad-hf-options-table widefat exad-hf-selected-template-type-' + selected );
	}

	jQuery(document).on( 'change', '#ehf_template_type', function( e ) {
		exad_hf_hide_shortcode_field();
	});

	exad_hf_hide_shortcode_field();
});
