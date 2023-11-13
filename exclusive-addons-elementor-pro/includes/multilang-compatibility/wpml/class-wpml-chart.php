<?php
namespace ExclusiveAddons\ProElementor;
use WPML_Elementor_Module_With_Items;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}


/**
 * Class WPML_Exad_Chart
 */
class WPML_Exad_Chart extends WPML_Elementor_Module_With_Items {

	/**
	 * @return string
	 */
	public function get_items_field() {
		return [ 'exad_chart_labels', 'exad_chart_datasets' ];
	}

	/**
	 * @return array
	 */
	public function get_fields() {
		return [ 'exad_chart_label_name', 'label', 'data',  'exad_chart_individual_bg_colors', 'border_colors' ];
	}
	
	/**
	 * @param string $field
	 * @return string
	 */
	protected function get_title( $field ) {
		switch( $field ) {

			case 'exad_chart_label_name':
				return esc_html__( 'Label', 'exclusive-addons-elementor-pro' );

			case 'label':
				return esc_html__( 'Label', 'exclusive-addons-elementor-pro' );

            case 'data':
				return esc_html__( 'Data', 'exclusive-addons-elementor-pro' );	

            case 'exad_chart_individual_bg_colors':
				return esc_html__( 'Background', 'exclusive-addons-elementor-pro' );

            case 'border_colors':
				return esc_html__( 'Border Colors', 'exclusive-addons-elementor-pro' );

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
			case 'exad_chart_label_name':
				return 'LINE';

			case 'label':
				return 'LINE';

            case 'data':
				return 'LINE';

            case 'exad_chart_individual_bg_colors':
				return 'LINE';

            case 'border_colors':
				return 'LINE';

			default:
				return '';
		}
	}

}
