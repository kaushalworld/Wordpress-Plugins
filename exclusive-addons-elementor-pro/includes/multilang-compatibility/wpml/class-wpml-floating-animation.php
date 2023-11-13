<?php
namespace ExclusiveAddons\ProElementor;
use WPML_Elementor_Module_With_Items;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}


/**
 * Class WPML_Exad_Floating_Animation
 */
class WPML_Exad_Floating_Animation extends WPML_Elementor_Module_With_Items {

	/**
	 * @return string
	 */
	public function get_items_field() {
		return [ 'exad_blob_multi_shape_list' ];
	}

	/**
	 * @return array
	 */
	public function get_fields() {
		return [ 'exad_blob_multi_shape_title' ];
	}

	/**
	 * @param string $field
	 * @return string
	 */
	protected function get_title( $field ) {
		switch( $field ) {

			case 'exad_blob_multi_shape_title':
				return esc_html__( 'Shape Title', 'exclusive-addons-elementor-pro' );

			default:
				return '';
		}
	}

	/**
	 * @param string $field
	 * @return string
	 */
	protected function get_editor_type( $field ) {
		switch( $field ) {
			case 'exad_blob_multi_shape_title':
				return 'LINE';

			default:
				return '';
		}
	}

}
