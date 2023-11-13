<?php
namespace ExclusiveAddons\ProElementor;
use WPML_Elementor_Module_With_Items;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}


/**
 * Class WPML_Exad_Table
 */
class WPML_Exad_Table extends WPML_Elementor_Module_With_Items {

	/**
	 * @return string
	 */
	public function get_items_field() {
		return [ 'exad_table_heading_columns', 'exad_table_body_rows' ];
	}

	/**
	 * @return array
	 */
	public function get_fields() {
		return [ 'exad_table_heading_col', 'exad_table_body_row_content','exad_table_body_row_id_class' ];
	}

	/**
	 * @param string $field
	 * @return string
	 */
	protected function get_title( $field ) {
		switch( $field ) {

			case 'exad_table_heading_col':
				return esc_html__( 'Heading Name', 'exclusive-addons-elementor-pro' );		

            case 'exad_table_body_row_content':
				return esc_html__( 'Column Text', 'exclusive-addons-elementor-pro' );  

			case 'exad_table_body_row_id_class':
				return esc_html__( 'CSS ID', 'exclusive-addons-elementor-pro' );   

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
			case 'exad_table_heading_col':
				return 'LINE';

            case 'exad_table_body_row_content':
				return 'AREA'; 

			case 'exad_table_body_row_id_class':
				return 'LINE';

			default:
				return '';
		}
	}

}
