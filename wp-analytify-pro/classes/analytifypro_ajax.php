<?php

if( ! defined('ABSPATH') ){
	// exit if accessed directly
	exit;
}

if ( class_exists( 'WPANALYTIFY_AJAX' ) ){

	//wp_die('Test');

	if( ! class_exists( 'WPANALYTIFYPRO_AJAX') ) {

		/*
		 * Handling all the AJAX calls in WP Analytify
		 * @since 1.2.4
		 * @class WPANALYTIFY_AJAX
		 */
		class WPANALYTIFYPRO_AJAX extends WPANALYTIFY_AJAX{

			public static function init(){

				parent::init();

				$ajax_calls = array(
					'load_mobile_stats'	     => false,
					'load_real_time_stats'	 => false,
					'load_online_visitors'	 => true,
					// 'load_ajax_error'        => false,
					// 'load_404_error'         => false,
					// 'load_javascript_error'  => false,
					'load_default_ajax_error' => false,
					'load_default_404_error' => false,
					'load_default_javascript_error'  => false,
					'load_detail_realtime_stats' => false,
					'export_csv' => false,
				);

				foreach ($ajax_calls as $ajax_call => $no_priv) {
					# code...
					add_action( 'wp_ajax_analytify_' . $ajax_call, array( __CLASS__, $ajax_call ) );

					if ( $no_priv ) {
						add_action( 'wp_ajax_nopriv_analytify_' . $ajax_call, array( __CLASS__, $ajax_call ) );
					}
				}
			}


			public static function load_mobile_stats() {

				$WP_Analytify = $GLOBALS['WP_ANALYTIFY'];

				$dashboard_profile_ID = $_GET['dashboard_profile_ID'];
				$start_date           = $_GET["start_date"];
				$end_date             = $_GET["end_date"];

				if (is_array( self::$show_settings ) and in_array( 'show-mobile-dashboard', self::$show_settings )){

					$mobile_stats = get_transient( md5('show-mobile-dashboard' . $dashboard_profile_ID . $start_date . $end_date ) ) ;
					if( $mobile_stats === false ) {
						$mobile_stats = $WP_Analytify->pa_get_analytics_dashboard( 'ga:sessions', $start_date, $end_date, 'ga:mobileDeviceInfo', '-ga:sessions', false, 5);
						set_transient(  md5('show-mobile-dashboard' . $dashboard_profile_ID . $start_date . $end_date ) , $mobile_stats, 60 * 60 * 20 );
					}

					if ( isset( $mobile_stats->totalsForAllResults )) {
					  include ANALYTIFY_PRO_ROOT_PATH . '/views/admin/mobile-stats.php';
					  pa_include_mobile($WP_Analytify, $mobile_stats);
					}
				}

				die();
			}


			// public static function load_real_time_stats(){

			// 	$WP_Analytify = $GLOBALS['WP_ANALYTIFY'];

			// 	if (is_array( self::$show_settings ) and in_array( 'show-real-time', self::$show_settings )){

			// 		include ANALYTIFY_PRO_ROOT_PATH . '/views/admin/realtime-stats.php';
			// 		pa_include_realtime( self );

			// 	}

			// 	die();
			// }



			public static function load_online_visitors() {

				//echo 'Ok';
				//die('kkk');


				if (! isset( $_POST['pa_security'] ) OR ! wp_verify_nonce( $_POST['pa_security'] , 'pa_get_online_data' ) ) {
					return;
				}

				if (! function_exists( 'curl_version' ) ) {
					die('cURL not exists.');
				}

				print_r( stripslashes( json_encode( self::pa_realtime_data( ) ) ) );

				die();
			}

			/**
			 * Grab RealTime Data
			 */
			public static function pa_realtime_data() {

				// revoke, if already quota error.
				if ( get_transient( 'analytify_quota_exception' ) ) {
					return false;
				}

				$WP_Analytify = $GLOBALS['WP_ANALYTIFY'];
				$profile_id   = $WP_Analytify->settings->get_option( 'profile_for_dashboard','wp-analytify-profile' );
				$metrics      = 'ga:activeVisitors';
				$dimensions   = 'ga:source,ga:keyword,ga:trafficType,ga:visitorType';

				try {

					$data = $WP_Analytify->service->data_realtime->get ( 'ga:' . $profile_id, $metrics, array(
						'dimensions' => $dimensions
					) );

				} catch ( Exception $e ) {
					return false;
				}

				return $data;
			}

			/**
			 * Run on details realtime stats.
			 *
			 * @since 2.0.0
			 */
			public static function load_detail_realtime_stats() {
				if (! isset( $_POST['pa_security'] ) OR ! wp_verify_nonce( $_POST['pa_security'] , 'pa_get_online_data' ) ) {
					return;
				}

				if (! function_exists( 'curl_version' ) ) {
					die('cURL not exists.');
				}

				if ( defined( 'JSON_UNESCAPED_UNICODE' ) ) {
					echo json_encode( self::pa_details_realtime_data( ), JSON_UNESCAPED_UNICODE );
				} else {
					echo json_encode( self::pa_details_realtime_data( ) );
				}

				die();
			}

			/**
			 * Grab data for detail realtime stats.
			 *
			 *
			 * @since 2.0.0
			 */
			public static function pa_details_realtime_data() {

				if ( method_exists( 'WPANALYTIFY_Utils', 'get_ga_mode' ) && 'ga4' === WPANALYTIFY_Utils::get_ga_mode() ) {
					$wp_analytify = $GLOBALS['WP_ANALYTIFY'];

					$real_time_report = $wp_analytify->get_real_time_reports(
						array(
							'activeUsers',
						),
						array(
							'unifiedScreenName'
						)
					);

					return $real_time_report;

				} else {
					$WP_Analytify = $GLOBALS['WP_ANALYTIFY'];
					$profile_id   = $WP_Analytify->settings->get_option( 'profile_for_dashboard','wp-analytify-profile' );
					
					$metrics      = 'ga:activeVisitors';
					$dimensions   = 'ga:pagePath,ga:source,ga:keyword,ga:trafficType,ga:visitorType,ga:pageTitle';

					try {
						$data = $WP_Analytify->service->data_realtime->get ( 'ga:' . $profile_id, $metrics,  array (
						'dimensions' => $dimensions
						)  );
					}
					catch ( Exception $e ) {
						update_option ( 'pa_lasterror_occur', esc_html($e));
						return '';
					}

					return $data;
				}
			}


			public static function load_ajax_error( ) {

				$WP_Analytify         = $GLOBALS['WP_ANALYTIFY'];
				$dashboard_profile_ID = $_GET['dashboard_profile_ID'];
				$start_date           = $_GET['start_date'];
				$end_date             = $_GET['end_date'];

				$ajax_error = get_transient( md5( 'show-ajax-error' . $dashboard_profile_ID . $start_date . $end_date ) );

				if ( $ajax_error === false ) {
					$ajax_error = $WP_Analytify->pa_get_analytics_dashboard( 'ga:totalEvents', $start_date, $end_date, 'ga:eventAction,ga:eventLabel', '-ga:totalEvents' , 'ga:eventCategory==Ajax Error', 5 );
					set_transient( md5( 'show-ajax-error' . $dashboard_profile_ID . $start_date . $end_date ) , $ajax_error, 60 * 60 * 20 );
				}

				if ( isset( $ajax_error->totalsForAllResults ) ) {
					include ANALYTIFY_PRO_ROOT_PATH . '/views/admin/miscellaneous-error-stats.php';

					pa_include_miscellaneous_error_stats( $WP_Analytify , $ajax_error , 'Ajax Errors' );
				}
				wp_die(  );
			}

			public static function load_404_error( ) {
				$WP_Analytify         = $GLOBALS['WP_ANALYTIFY'];
				$dashboard_profile_ID = $_GET['dashboard_profile_ID'];
				$start_date           = $_GET['start_date'];
				$end_date             = $_GET['end_date'];

				$page_404_error = get_transient( md5( 'show-404-error' . $dashboard_profile_ID . $start_date . $end_date ) );

				if ( $page_404_error === false ) {
					$page_404_error = $WP_Analytify->pa_get_analytics_dashboard( 'ga:totalEvents', $start_date, $end_date, 'ga:eventAction,ga:eventLabel', '-ga:totalEvents' , 'ga:eventCategory==404 Error', 5 );
					set_transient( md5( 'show-404-error' . $dashboard_profile_ID . $start_date . $end_date ) , $page_404_error, 60 * 60 * 20 );
				}

				if ( $page_404_error->totalsForAllResults ) {

					include ANALYTIFY_PRO_ROOT_PATH . '/views/admin/miscellaneous-error-stats.php';
					pa_include_miscellaneous_error_stats( $WP_Analytify , $page_404_error , '404 Errors' );
				}

				wp_die( );
			}

			public static function load_javascript_error( ) {

				$WP_Analytify         = $GLOBALS['WP_ANALYTIFY'];
				$dashboard_profile_ID = $_GET['dashboard_profile_ID'];
				$start_date           = $_GET['start_date'];
				$end_date             = $_GET['end_date'];

				$javascript_error = get_transient( md5( 'show-javascript-error' . $dashboard_profile_ID . $start_date . $end_date ) );

				if ( $javascript_error === false ) {
					$javascript_error = $WP_Analytify->pa_get_analytics_dashboard( 'ga:totalEvents', $start_date, $end_date, 'ga:eventAction,ga:eventLabel', '-ga:totalEvents' , 'ga:eventCategory==JavaScript Error', 5 );
					set_transient( md5( 'show-javascript-error' . $dashboard_profile_ID . $start_date . $end_date ) , $javascript_error, 60 * 60 * 20 );
				}

				if ( $javascript_error->totalsForAllResults ) {
					include ANALYTIFY_PRO_ROOT_PATH . '/views/admin/miscellaneous-error-stats.php';
					pa_include_miscellaneous_error_stats( $WP_Analytify , $javascript_error , 'Javascript Errors' );
				}

				wp_die( );
			}

			public static function load_default_ajax_error() {

				$WP_Analytify         = $GLOBALS['WP_ANALYTIFY'];
				$dashboard_profile_ID = $_GET['dashboard_profile_ID'];
				$start_date           = $_GET['start_date'];
				$end_date             = $_GET['end_date'];

				$ajax_error = $WP_Analytify->pa_get_analytics_dashboard( 'ga:totalEvents', $start_date, $end_date, 'ga:eventAction,ga:eventLabel', '-ga:totalEvents' , 'ga:eventCategory==Ajax Error', 5, 'show-top-ajax-errors' );

				if ( $ajax_error ) {
					include ANALYTIFY_PRO_ROOT_PATH . '/views/default/admin/ajax-error.php';
					fetch_error( $WP_Analytify, $ajax_error );

				}

				wp_die( );
			}

			public static function load_default_404_error() {

				$WP_Analytify         = $GLOBALS['WP_ANALYTIFY'];
				$dashboard_profile_ID = $_GET['dashboard_profile_ID'];
				$start_date           = $_GET['start_date'];
				$end_date             = $_GET['end_date'];

				$page_404_error = $WP_Analytify->pa_get_analytics_dashboard( 'ga:totalEvents', $start_date, $end_date, 'ga:eventAction,ga:eventLabel', '-ga:totalEvents' , 'ga:eventCategory==404 Error', 5, 'show-top-404-pages' );

				if ( $page_404_error ) {
					include ANALYTIFY_PRO_ROOT_PATH . '/views/default/admin/404-error.php';
					fetch_error( $WP_Analytify, $page_404_error );
				}

				wp_die();

			}

			public static function load_default_javascript_error() {

				$WP_Analytify         = $GLOBALS['WP_ANALYTIFY'];
				$dashboard_profile_ID = $_GET['dashboard_profile_ID'];
				$start_date           = $_GET['start_date'];
				$end_date             = $_GET['end_date'];

				$javascript_error = $WP_Analytify->pa_get_analytics_dashboard( 'ga:totalEvents', $start_date, $end_date, 'ga:eventAction,ga:eventLabel', '-ga:totalEvents' , 'ga:eventCategory==JavaScript Error', 5, 'show-top-js-errors' );

				if ( $javascript_error ) {
					include ANALYTIFY_PRO_ROOT_PATH . '/views/default/admin/javascript-error.php';
					fetch_error( $WP_Analytify, $javascript_error );
				}

				wp_die();

			}

			/**
			 * Calculate the Stats on Export.
			 *
			 * @since 2.0.17
			 */
			public static function export_csv() {

				$input = $_REQUEST;

				$type  = sanitize_text_field( $input['stats_type'] );
				$nonce = sanitize_text_field( $input['security'] );
				$args  = isset( $input['args'] ) ? $input['args'] : array();

				$csv_export = new AnalytifyCSVExport();
				if ( $csv_export->auth_check( $nonce, 'analytify_export_nonce' ) ) {

					$date = array(
						'start_date' => sanitize_text_field( $input['start_date'] ),
						'end_date'   => sanitize_text_field( $input['end_date'] ),
					);
					if ( $csv_export->generate_export_data( $type, $date, $args ) ) {
						return true;
					}

					wp_send_json_error( 'Unable to export data.', 400 );
				}

				wp_send_json_error( 'Permission denied.', 403 );
			}

		}

		WPANALYTIFYPRO_AJAX::init();

	}
}
