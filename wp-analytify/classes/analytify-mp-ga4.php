<?php
/**
 * This file contains the class that makes the gtag api calls.
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( ! class_exists( 'Analytify_MP_GA4' ) ) {
	/**
	 * Class that makes the gtag api calls.
	 * Use for server-side calls.
	 */
	class Analytify_MP_GA4 {

		/**
		 * The Google Analytics API URL.
		 */
		const GOOGLE_ANALYTICS_API_URL = 'https://www.google-analytics.com/mp/collect';

		/**
		 * The single instance of the class.
		 *
		 * @var object
		 */
		private static $instance;

		/**
		 * Client ID
		 *
		 * @var string
		 */
		private $client_id = null;

		/**
		 * Measurement ID
		 *
		 * @var string
		 */
		private $measurement_id = null;

		/**
		 * API secret
		 *
		 * @var string
		 */
		private $api_secret = null;

		/**
		 * Analytify global object.
		 */

		private $wp_analytify = null;

		/**
		 * Returns the single instance of the class.
		 *
		 * @return object Class instance
		 */
		public static function get_instance() {
			if ( empty( self::$instance ) ) {
				self::$instance = new self();
			}

			return self::$instance;
		}

		/**
		 * Class constructor.
		 *
		 */
		private function __construct() {
			$this->wp_analytify = $GLOBALS['WP_ANALYTIFY'];

			$this->api_secret     = $this->wp_analytify->settings->get_option( 'measurement_protocol_secret', 'wp-analytify-advanced', false );
			$this->measurement_id = WP_ANALYTIFY_FUNCTIONS::get_UA_code();
			$this->client_id      = $this->get_client_id();
		}

		private function get_client_id(){

			$client_id = '';

			if( isset( $_COOKIE['_ga'] ) ) {

				$client_id_raw  = $_COOKIE['_ga'];
				$parts = explode( "." , $client_id_raw );
				$client_id = "{$parts[2]}.{$parts[3]}";

			} else {

				$client_id = ( 'on' === $this->wp_analytify->settings->get_option( 'user_advanced_keys','wp-analytify-advanced' ) ) ? $this->wp_analytify->settings->get_option( 'client_id','wp-analytify-advanced' ) : ANALYTIFY_CLIENTID;

			}

			return $client_id;

			
		}

		/**
		 * Returns the Google Analytics API URL.
		 *
		 * @return string
		 */
		private function api_url() {
			$url = add_query_arg(
				array(
					'measurement_id' => $this->measurement_id,
					'api_secret'     => $this->api_secret,
				),
				self::GOOGLE_ANALYTICS_API_URL
			);
			return esc_url_raw( $url );
		}

		/**
		 * Send data to Google Analytics.
		 *
		 * @param array $events Data to send.
		 * @return bool
		 */
		public function send_hit( $events ) {

			$url = $this->api_url();

			$debug_mode = apply_filters( 'analytify_debug_mode', false );

			if ( $debug_mode ) {
				foreach ( $events as $index => $event ) {
					$events[ $index ]['params']['debug_mode'] = 1;
				}
			}

			$events = apply_filters( 'analytify_ga4_events_for_mp_api_call', $events );

			$body = array(
				'client_id' => $this->client_id,
				'events'    => $events,
			);
			$response = wp_remote_post($url, array(
					'timeout' => 5,
					'body'    => wp_json_encode( $body ),
				));
			if ( is_wp_error( $response ) ) {
				return false;
			}

			return true;

		}

	}
}

/**
 * Uses the singleton pattern to call the api.
 *
 * @param array $events Parameters to send to the API.
 *
 * @return bool
 */
function analytify_mp_ga4( $events ) {
	return Analytify_MP_GA4::get_instance()->send_hit( $events );
}
