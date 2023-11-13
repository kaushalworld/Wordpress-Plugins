<?php
namespace ExclusiveAddons\ProElementor;
use WPML_Elementor_Module_With_Items;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}


/**
 * Class WPML_Exad_Comparison_Table
 */
class WPML_Exad_Comparison_Table extends WPML_Elementor_Module_With_Items {

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
		return [ 'exad_table_heading_col', 'exad_table_heading_currency_symbol', 'exad_table_heading_current_price',  'exad_table_heading_regular_price', 'exad_table_heading_duration', 'exad_table_heading_ribbon_text', 'exad_table_body_text', 'exad_table_body_tooltip_text', 'exad_table_body_button_text', 'exad_table_body_row_id_class', 'exad_table_body_button_link'];
	}

	/**
	 * @param string $field
	 * @return string
	 */
	protected function get_title( $field ) {
		switch( $field ) {

			case 'exad_table_heading_col':
				return esc_html__( 'Heading Name', 'exclusive-addons-elementor-pro' );

			case 'exad_table_heading_currency_symbol':
				return esc_html__( 'Currency Symbol', 'exclusive-addons-elementor-pro' );

            case 'exad_table_heading_current_price':
				return esc_html__( 'Price', 'exclusive-addons-elementor-pro' );	

            case 'exad_table_heading_regular_price':
				return esc_html__( 'Regular Price', 'exclusive-addons-elementor-pro' );

            case 'exad_table_heading_duration':
				return esc_html__( 'Duration', 'exclusive-addons-elementor-pro' );

            case 'exad_table_heading_ribbon_text':
				return esc_html__( 'Ribbon Text', 'exclusive-addons-elementor-pro' );

            case 'exad_table_body_text':
				return esc_html__( 'Text', 'exclusive-addons-elementor-pro' );

            case 'exad_table_body_tooltip_text':
				return esc_html__( 'Tooltip Text', 'exclusive-addons-elementor-pro' );     

            case 'exad_table_body_button_text':
				return esc_html__( 'Button Text', 'exclusive-addons-elementor-pro' );  
				
			case 'exad_table_body_button_link':
				return esc_html__( 'Button Link URL', 'exclusive-addons-elementor-pro' ); 

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

			case 'exad_table_heading_currency_symbol':
				return 'LINE';

            case 'exad_table_heading_current_price':
				return 'LINE';

            case 'exad_table_heading_regular_price':
				return 'LINE';

            case 'exad_table_heading_duration':
				return 'LINE';            

            case 'exad_table_heading_ribbon_text':
				return 'LINE'; 

            case 'exad_table_body_text':
				return 'AREA'; 

            case 'exad_table_body_tooltip_text':
				return 'AREA';

            case 'exad_table_body_button_text':
				return 'LINE';   

			case 'exad_table_body_button_link':
				return 'LINK'; 
            
            case 'exad_table_body_row_id_class':
				return 'LINE';

			default:
				return '';
		}
	}

}
