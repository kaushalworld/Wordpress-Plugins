<?php
namespace ExclusiveAddons\ProElementor;
use WPML_Elementor_Module_With_Items;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}


/**
 * Class WPML_Exad_Mega_Menu
 */
class WPML_Exad_Mega_Menu extends WPML_Elementor_Module_With_Items {

	/**
	 * @return string
	 */
	public function get_items_field() {
		return [ 'exad_mega_menu_items' ];
	}

	/**
	 * @return array
	 */
	public function get_fields() {
		return [ 'exad_mega_menu_text', 'exad_mega_menu_label' ];
	}

	/**
	 * @param string $field
	 * @return string
	 */
	protected function get_title( $field ) {
		switch( $field ) {

			case 'exad_mega_menu_text':
				return esc_html__( 'Text', 'exclusive-addons-elementor-pro' );		

            case 'exad_mega_menu_label':
				return esc_html__( 'Label', 'exclusive-addons-elementor-pro' );    

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
			case 'exad_mega_menu_text':
				return 'LINE';

            case 'exad_mega_menu_label':
				return 'LINE';

			default:
				return '';
		}
	}

}
