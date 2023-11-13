<?php

namespace ExclusiveAddons\Elementor\Extensions;

use \Elementor\Plugin;
use Elementor\Utils;
use Elementor\Controls_Stack;

class Cross_Site_Copy_Paste {

	/**
	 * Ajax call.
	 */
	public static function init() {
		add_action( 'wp_ajax_exad_process_import', array( __CLASS__, 'process_media_import' ) );
	}

	/**
	 * Media import support
	 *
	 * @return void
	 */
	public static function process_media_import() {

		check_ajax_referer( 'exad_process_import', 'nonce' );

		if ( ! current_user_can( 'edit_posts' ) ) {
			wp_send_json_error(
				__( 'You do not have access to perform the operation.', 'exclusive-addons-elementor-pro' ),
				403
			);
		}

		$media = isset( $_POST['content'] ) ? wp_unslash( $_POST['content'] ) : '';

		if ( empty( $media ) ) {
			wp_send_json_error( __( 'No content found. Cannot be processed.', 'exclusive-addons-elementor-pro' ) );
		}

		$media = array( json_decode( $media, true ) ); 
		$media = self::replace_content_ids( $media );
		$media = self::import_media_contents( $media );

		wp_send_json_success( $media );
	}

	/**
	 * Replace media items IDs.
	 *
	 */
	protected static function replace_content_ids( $media ) {
		return Plugin::instance()->db->iterate_data(
			$media,
			function( $element ) {
				$element['id'] = Utils::generate_random_string();
				return $element;
			}
		);
	}

	/**
	 * Media import process.
	 *
	 */
	protected static function import_media_contents( $media ) {
		return Plugin::instance()->db->iterate_data(
			$media,
			function( $element_instance ) {
				$element = Plugin::instance()->elements_manager->create_element_instance( $element_instance );

				if ( ! $element ) {
					return null;
				}

				return self::process_content_import( $element );
			}
		);
	}

	/**
	 * Process element content for import.
	 *
	 */
	protected static function process_content_import( Controls_Stack $element ) {
		$element_instance = $element->get_data();
		$method           = 'on_import';

		if ( method_exists( $element, $method ) ) {
			$element_instance = $element->{$method}( $element_instance );
		}

		foreach ( $element->get_controls() as $control ) {
			$control_class = Plugin::instance()->controls_manager->get_control( $control['type'] );
			$control_name  = $control['name'];

			if ( ! $control_class ) {
				return $element_instance;
			}

			if ( method_exists( $control_class, $method ) ) {
				$element_instance['settings'][ $control_name ] = $control_class->{$method}( $element->get_settings( $control_name ), $control );
			}
		}

		return $element_instance;
	}
}

Cross_Site_Copy_Paste::init();
