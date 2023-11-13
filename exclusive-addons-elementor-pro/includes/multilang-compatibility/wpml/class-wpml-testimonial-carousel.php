<?php
namespace ExclusiveAddons\ProElementor;
use WPML_Elementor_Module_With_Items;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}


/**
 * Class WPML_Exad_Testimonial_Carousel
 */
class WPML_Exad_Testimonial_Carousel extends WPML_Elementor_Module_With_Items {

	/**
	 * @return string
	 */
	public function get_items_field() {
		return [ 'testimonial_carousel_repeater' ];
	}

	/**
	 * @return array
	 */
	public function get_fields() {
		return [ 'exad_testimonial_carousel_description', 'exad_testimonial_carousel_name','exad_testimonial_carousel_designation' ];
	}

	/**
	 * @param string $field
	 * @return string
	 */
	protected function get_title( $field ) {
		switch( $field ) {

			case 'exad_testimonial_carousel_description':
				return esc_html__( 'Testimonial', 'exclusive-addons-elementor-pro' );		

            case 'exad_testimonial_carousel_name':
				return esc_html__( 'Name', 'exclusive-addons-elementor-pro' );  

			case 'exad_testimonial_carousel_designation':
				return esc_html__( 'Designation', 'exclusive-addons-elementor-pro' );   

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
			case 'exad_testimonial_carousel_description':
				return 'AREA';

            case 'exad_testimonial_carousel_name':
				return 'LINE'; 

			case 'exad_testimonial_carousel_designation':
				return 'LINE';

			default:
				return '';
		}
	}

}
