<?php
namespace ExclusiveAddons\ProElementor;
use WPML_Elementor_Module_With_Items;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}


/**
 * Class WPML_Exad_Image_Hotspot
 */
class WPML_Exad_Image_Hotspot extends WPML_Elementor_Module_With_Items {

	/**
	 * @return string
	 */
	public function get_items_field() {
		return [ 'exad_hotspots' ];
	}

	/**
	 * @return array
	 */
	public function get_fields() {
		return [ 'exad_tooltip_content_heading', 'exad_tooltip_content_subheading', 'exad_tooltip_content_button', 'exad_hotspot_text' ];
	}

	/**
	 * @param string $field
	 * @return string
	 */
	protected function get_title( $field ) {
		switch( $field ) {

			case 'exad_tooltip_content_heading':
				return esc_html__( 'Tooltip Heading', 'exclusive-addons-elementor-pro' );		

            case 'exad_tooltip_content_subheading':
				return esc_html__( 'Tooltip Subheading', 'exclusive-addons-elementor-pro' );    

            case 'exad_tooltip_content_button':
				return esc_html__( 'Tooltip Button Text', 'exclusive-addons-elementor-pro' );

            case 'exad_hotspot_text':
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
			case 'exad_tooltip_content_heading':
				return 'LINE';

            case 'exad_tooltip_content_subheading':
				return 'AREA';

            case 'exad_tooltip_content_button':
				return 'LINE';

            case 'exad_hotspot_text':
				return 'LINE';

			default:
				return '';
		}
	}

}
