<?php
namespace ExclusiveAddons\ProElementor;
use WPML_Elementor_Module_With_Items;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}


/**
 * Class WPML_Exad_Demo_Previewer
 */
class WPML_Exad_Demo_Previewer extends WPML_Elementor_Module_With_Items {

	/**
	 * @return string
	 */
	public function get_items_field() {
		return [ 'exad_demo_previewer_items' ];
	}

	/**
	 * @return array
	 */
	public function get_fields() {
		return [ 'exad_demo_previewer_item_title', 'exad_demo_previewer_item_title_url','exad_demo_previewer_item_description', 'exad_demo_previewer_item_content_button_text',  'exad_demo_previewer_item_content_button_url','exad_demo_previewer_control_name', 'exad_demo_previewer_filter_name', 'exad_demo_previewer_tag_list', 'exad_demo_previewer_label_list' ];
	}

	/**
	 * @param string $field
	 * @return string
	 */
	protected function get_title( $field ) {
		switch( $field ) {

			case 'exad_demo_previewer_item_title':
				return esc_html__( 'Title', 'exclusive-addons-elementor-pro' );

			case 'exad_demo_previewer_item_title_url':
				return esc_html__( 'Title URL', 'exclusive-addons-elementor-pro' );

			case 'exad_demo_previewer_item_description':
				return esc_html__( 'Description', 'exclusive-addons-elementor-pro' );

            case 'exad_demo_previewer_item_content_button_text':
				return esc_html__( 'Content Button Text', 'exclusive-addons-elementor-pro' );	 

			case 'exad_demo_previewer_item_content_button_url':
				return esc_html__( 'Content Button URL', 'exclusive-addons-elementor-pro' );	

            case 'exad_demo_previewer_control_name':
				return esc_html__( 'Control Name', 'exclusive-addons-elementor-pro' );

            case 'exad_demo_previewer_filter_name':
				return esc_html__( 'Dropdown Filter Name', 'exclusive-addons-elementor-pro' );

            case 'exad_demo_previewer_tag_list':
				return esc_html__( 'Tag List', 'exclusive-addons-elementor-pro' );

            case 'exad_demo_previewer_label_list':
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
			case 'exad_demo_previewer_item_title':
				return 'LINE';

			case 'exad_demo_previewer_item_title_url':
				return 'LINK';

			case 'exad_demo_previewer_item_description':
				return 'AREA';

            case 'exad_demo_previewer_item_content_button_text':
				return 'LINE';

			case 'exad_demo_previewer_item_content_button_url':
					return 'LINK'; 

            case 'exad_demo_previewer_control_name':
				return 'LINE';

            case 'exad_demo_previewer_filter_name':
				return 'LINE';            

            case 'exad_demo_previewer_tag_list':
				return 'LINE'; 

            case 'exad_demo_previewer_label_list':
				return 'LINE'; 
				
			

			default:
				return '';
		}
	}

}
