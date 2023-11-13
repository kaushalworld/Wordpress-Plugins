<?php
namespace ExclusiveAddons\ProElementor;
use WPML_Elementor_Module_With_Items;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}


/**
 * Class WPML_Exad_Slider
 */
class WPML_Exad_Slider extends WPML_Elementor_Module_With_Items {

	/**
	 * @return string
	 */
	public function get_items_field() {
		return [ 'exad_slides' ];
	}

	/**
	 * @return array
	 */
	public function get_fields() {
		return [ 'exad_slider_title', 'exad_slider_details','exad_slider_button_text' ];
	}

	/**
	 * @param string $field
	 * @return string
	 */
	protected function get_title( $field ) {
		switch( $field ) {

			case 'exad_slider_title':
				return esc_html__( 'Title', 'exclusive-addons-elementor-pro' );		

            case 'exad_slider_details':
				return esc_html__( 'Details', 'exclusive-addons-elementor-pro' );  

			case 'exad_slider_button_text':
				return esc_html__( 'Button Text', 'exclusive-addons-elementor-pro' );    

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
			case 'exad_slider_title':
				return 'LINE';

            case 'exad_slider_details':
				return 'AREA'; 

			case 'exad_slider_button_text':
				return 'LINE';

			default:
				return '';
		}
	}

}
