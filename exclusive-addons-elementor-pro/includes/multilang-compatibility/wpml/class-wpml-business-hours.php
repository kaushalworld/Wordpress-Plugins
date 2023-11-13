<?php
namespace ExclusiveAddons\ProElementor;
use WPML_Elementor_Module_With_Items;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}


/**
 * Class WPML_Exad_Business_Hours
 */
class WPML_Exad_Business_Hours extends WPML_Elementor_Module_With_Items {

	/**
	 * @return string
	 */
	public function get_items_field() {
		return 'exad_business_hours_repeater';
	}

	/**
	 * @return array
	 */
	public function get_fields() {
		return [ 'exad_business_hours_day', 'exad_business_hours_time' ];
	}

	/**
	 * @param string $field
	 * @return string
	 */
	protected function get_title( $field ) {
		switch( $field ) {

			case 'exad_business_hours_day':
				return esc_html__( 'Day', 'exclusive-addons-elementor-pro' );

			case 'exad_business_hours_time':
				return esc_html__( 'Time', 'exclusive-addons-elementor-pro' );

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
			case 'exad_business_hours_day':
				return 'LINE';

			case 'exad_business_hours_time':
				return 'LINE';

			default:
				return '';
		}
	}

}
