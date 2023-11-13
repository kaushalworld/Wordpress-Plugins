<?php
namespace ExclusiveAddons\ProElementor;
use WPML_Elementor_Module_With_Items;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}


/**
 * Class WPML_Exad_Team_Carousel
 */
class WPML_Exad_Team_Carousel extends WPML_Elementor_Module_With_Items {

	/**
	 * @return string
	 */
	public function get_items_field() {
		return [ 'exad_team_carousel_repeater' ];
	}

	/**
	 * @return array
	 */
	public function get_fields() {
		return [ 'exad_team_carousel_name', 'exad_team_carousel_designation','exad_team_carousel_description', 'exad_team_carousel_cta_btn_text' ];
	}

	/**
	 * @param string $field
	 * @return string
	 */
	protected function get_title( $field ) {
		switch( $field ) {

			case 'exad_team_carousel_name':
				return esc_html__( 'Name', 'exclusive-addons-elementor-pro' );		

            case 'exad_team_carousel_designation':
				return esc_html__( 'Designation', 'exclusive-addons-elementor-pro' );  

			case 'exad_team_carousel_description':
				return esc_html__( 'Description', 'exclusive-addons-elementor-pro' );   

			case 'exad_team_carousel_cta_btn_text':
				return esc_html__( 'Text', 'exclusive-addons-elementor-pro' );   

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
			case 'exad_team_carousel_name':
				return 'LINE';

            case 'exad_team_carousel_designation':
				return 'LINE'; 

			case 'exad_team_carousel_description':
				return 'AREA';

            case 'exad_team_carousel_cta_btn_text':
				return 'LINE';

			default:
				return '';
		}
	}

}
