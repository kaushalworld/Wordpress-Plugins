<?php

/**
 * This file handles all the CSV export related functionality
 * 
 */

if ( ! defined('ABSPATH') ) {
	// exit if accessed directly
	exit;
}

/**
 * Handles CSV Export
 */
class AnalytifyCSVExport {

	/**
	 * The main Analytify object.
	 *
	 * @var object
	 */
	private $wp_analytify;

	/**
	 * GA version (ga4 or ga3).
	 *
	 * @var string
	 */
	private $ga_mode;

	/**
	 * Requested csv type (section).
	 *
	 * @var string
	 */
	private $type;

	/**
	 * Selected 'start state'.
	 *
	 * @var string
	 */
	private $start_date;

	/**
	 * Selected 'End state'.
	 *
	 * @var string
	 */
	private $end_date;

	/**
	 * WC's currency symbol.
	 *
	 * @var string
	 */
	private $wc_currency_symbol = null;

	/**
	 * Constructor
	 */
	public function __construct() {
		$this->wp_analytify = $GLOBALS['WP_ANALYTIFY'];
		$this->ga_mode      = method_exists( 'WPANALYTIFY_Utils', 'get_ga_mode' ) ? WPANALYTIFY_Utils::get_ga_mode() : 'ga3';
	}

	/**
	 * Verifies nonce.
	 * Also checks for user capabilities.
	 *
	 * @param string $nonce  Nonce.
	 * @param string $action Nonce Action.
	 * @return bool
	 */
	public function auth_check( $nonce, $action ) {

		if ( ! wp_verify_nonce( $nonce, $action ) ) {
			return false;
		}

		$is_access_level = $this->wp_analytify->settings->get_option( 'show_analytics_roles_dashboard', 'wp-analytify-dashboard', array( 'administrator' ) );
		if ( ! $this->wp_analytify->pa_check_roles( $is_access_level ) ) {
			return false;
		}

		return true;
	}

	/**
	 * Generates export data and update the option.
	 *
	 * @param string $type CSV type.
	 * @param array  $date Date range (start and end).
	 * @param array  $args Additional arguments.
	 *
	 * @return bool
	 */
	public function generate_export_data( $type, $date, $args ) {

		$this->type       = $type;
		$this->start_date = $date['start_date'];
		$this->end_date   = $date['end_date'];

		switch ( $type ) {
			case 'general-stats':
				$data = $this->export_general_stats();
				break;
			case 'top-pages':
				$data = $this->export_top_pages();
				break;
			case 'top-countries':
				$data = $this->export_top_countries();
				break;
			case 'top-cities':
				$data = $this->export_top_cities();
				break;
			case 'top-keywords':
				$data = $this->export_top_keywords();
				break;
			case 'top-social-media':
				$data = $this->export_top_social_media();
				break;
			case 'top-reffers': // For legacy support.
			case 'top-referrer':
				$data = $this->export_top_referrer();
				break;
			case 'what-happen':
				$data = $this->export_what_is_happening();
				break;
			case 'top-ajax':
				$data = $this->export_top_ajax_errors();
				break;
			case 'top-404':
				$data = $this->export_top_404_errors();
				break;
			case 'top-js-error':
				$data = $this->export_top_js_errors();
				break;
			case 'top-browsers':
				$data = $this->export_top_browsers();
				break;
			case 'top-operating-system':
				$data = $this->export_top_operating_system();
				break;
			case 'top-mobile-device':
				$data = $this->export_top_mobile_device();
				break;

			case 'forms-dashboard':
				$form = ! empty( $args ) ? $args : false;
				$data = $this->export_forms_dashboard( $form );
				break;

			// Events Tracking sections.
			case 'external-links':
			case 'download-links':
			case 'tel-links':
			case 'affiliate-links':
			case 'mail-links':
				$data = $this->export_event_tracking_section();
				break;

			// Custom Dimensions sections.
			case 'custom-dimension-author':
			case 'custom-dimension-post_type':
			case 'custom-dimension-published_at':
			case 'custom-dimension-category':
			case 'custom-dimension-tags':
			case 'custom-dimension-user_id':
			case 'custom-dimension-logged_in':
			case 'custom-dimension-seo_score':
			case 'custom-dimension-focus_keyword':
				$data = $this->export_custom_dimension_section();
				break;

			case 'search-terms':
				$data = $this->export_search_terms();
				break;

			case 'demographics':
				$data = $this->export_demographics();
				break;

			case 'author-stats': // For legacy support.
				if ( isset( $args['filter'] ) && 'true' === $args['filter'] ) {
					$author_id = 0;
				} else {
					$dimension = explode( '==', $args['filter'] );
					$user = get_user_by( 'login', $dimension[1] );
					$author_id = $user ? $user->ID : 0;
				}

				$data = $this->export_author_stats( $author_id );
				break;
			case 'authors-dashboard':
				$author_id = isset( $args ) && is_numeric( $args ) ? $args : 0;
				$data      = $this->export_author_stats( $author_id );
				break;

			case 'top-sales-countries':
				$data = $this->export_top_sales_countries();
				break;

			case 'measuring-roi':
				$data = $this->export_measuring_roi();
				break;

			case 'products-performance':
				$data = $this->export_products_performance();
				break;

			case 'product-lists-analysis':
				$data = $this->export_product_lists_analysis();
				break;

			case 'product-categories':
				$data = $this->export_product_categories();
				break;

			case 'coupons-analysis':
				$data = $this->export_coupons_analysis();
				break;

			default:
				wp_send_json_error( 'Invalid export type.', 404 );
		}

		if ( is_array( $data ) && ! empty( $data ) ) {
			update_option( 'analytify_csv_data', $data );
			return true;
		}

		return false;
	}

	/**
	 * Generates 'general-stats'.
	 *
	 * @return array
	 */
	private function export_general_stats() {

		// Calculate the start and end date difference.
		$date_diff = $this->calculate_date_diff( null );

		// Data holder.
		$stats       = array();
		$device_data = array(
			'mobile'  => 0,
			'tablet'  => 0,
			'desktop' => 0,
		);

		if ( 'ga4' === $this->ga_mode ) {

			$general_stats_raw = $this->wp_analytify->get_reports(
				'show-default-overall-dashboard',
				array(
					'sessions',
					'totalUsers',
					'screenPageViews',
					'averageSessionDuration',
					'bounceRate',
					'screenPageViewsPerSession',
					'engagedSessions',
					'userEngagementDuration',
					'newUsers',
					'activeUsers',
				),
				$this->get_dates(),
				array(),
				array(),
				array(),
				0,
				false
			);

			$general_stats = $general_stats_raw['aggregations'];

			$device_category_stats = $this->wp_analytify->get_reports(
				'show-default-overall-device-dashboard',
				array(
					'sessions',
				),
				$this->get_dates(),
				array(
					'deviceCategory',
				),
				array(
					'type' => 'dimension',
					'name' => 'deviceCategory',
				),
				array(),
				0,
				false
			);

			foreach ( $device_category_stats['rows'] as $device ) {
				$device_data[ $device['deviceCategory'] ] = $device['sessions'];
			}

			$stats = array(
				array(
					'Sessions',
					$general_stats['sessions'] ? WPANALYTIFY_Utils::pretty_numbers( $general_stats['sessions'] ) : 0,
					$date_diff && $compare_results['ga:sessions'] ? number_format( ( ( $general_stats['sessions'] - $compare_results['ga:sessions'] ) / $compare_results['ga:sessions'] ) * 100, 2 ) . '%' : '0%',
				),
				array(
					'Visitors',
					isset( $general_stats['totalUsers'] ) ? $general_stats['totalUsers'] : 0,
					$date_diff && $compare_results['ga:users'] ? number_format( ( ( $general_stats['totalUsers'] - $compare_results['ga:users'] ) / $compare_results['ga:users'] ) * 100, 2 ) . '%' : '0%',
				),
				array(
					'Page Views',
					$general_stats['screenPageViews'] ? WPANALYTIFY_Utils::pretty_numbers( $general_stats['screenPageViews'] ) : 0,
					$date_diff && $compare_results['ga:pageviews'] ? number_format( ( ( $general_stats['screenPageViews'] - $compare_results['ga:pageviews'] ) / $compare_results['ga:pageviews'] ) * 100, 2 ) . '%' : '0%',
				),
				array(
					'Avg. Time On Site',
					$general_stats['averageSessionDuration'] ? strip_tags( WPANALYTIFY_Utils::pretty_time( $general_stats['averageSessionDuration'] ) ) : 0,
					$date_diff && $compare_results['ga:avgSessionDuration'] ? number_format( ( ( $general_stats['averageSessionDuration'] - $compare_results['ga:avgSessionDuration'] ) / $compare_results['ga:avgSessionDuration'] ) * 100, 2 ) . '%' : '0%',
				),
				array(
					'Bounce Rate',
					$general_stats['bounceRate'] ? WPANALYTIFY_Utils::pretty_numbers( $general_stats['bounceRate'] ) . '%' : '0%',
					$date_diff && $compare_results['ga:bounceRate'] ? number_format( ( ( $general_stats['bounceRate'] - $compare_results['ga:bounceRate'] ) / $compare_results['ga:bounceRate'] ) * 100, 2 ) . '%' : '0%',
				),
				array(
					'Pages/Session',
					$general_stats['screenPageViewsPerSession'] ? round( $general_stats['screenPageViewsPerSession'], 2 ) . '%' : '0%',
					$date_diff && $compare_results['ga:pageviewsPerSession'] ? number_format( ( ( $general_stats['screenPageViewsPerSession'] - $compare_results['ga:pageviewsPerSession'] ) / $compare_results['ga:pageviewsPerSession'] ) * 100, 2 ) . '%' : '0%',
				),
				array(
					'Engaged Sessions',
					isset( $general_stats['engagedSessions'] ) ? $general_stats['engagedSessions'] : 0,
					$date_diff && $compare_results['ga:percentNewSessions'] ? number_format( ( ( $general_stats['engagedSessions'] - $compare_results['ga:percentNewSessions'] ) / $compare_results['ga:percentNewSessions'] ) * 100, 2 ) . '%' : '0%',
				),
				array(
					'New Users',
					$general_stats['newUsers'] ? WPANALYTIFY_Utils::pretty_numbers( $general_stats['newUsers'] ) : 0,
					'',
				),
				array(
					'Returning Users',
					$general_stats['activeUsers'] ? WPANALYTIFY_Utils::pretty_numbers( $general_stats['activeUsers'] ) : 0,
					'',
				),
				array(
					'Mobile Visitors',
					$device_data['mobile'] ? WPANALYTIFY_Utils::pretty_numbers( $device_data['mobile'] ) : 0,
					'',
				),
				array(
					'Tablet Visitors',
					$device_data['tablet'] ? WPANALYTIFY_Utils::pretty_numbers( $device_data['tablet'] ) : 0,
					'',
				),
				array(
					'Desktop Visitors',
					$device_data['desktop'] ? WPANALYTIFY_Utils::pretty_numbers( $device_data['desktop'] ) : 0,
					'',
				),
			);

		} else {

			// General stats.
			$raw_results = $this->wp_analytify->pa_get_analytics_dashboard( 'ga:sessions,ga:users,ga:pageviews,ga:avgSessionDuration,ga:bounceRate,ga:pageviewsPerSession,ga:percentNewSessions,ga:newUsers,ga:sessionDuration', $this->start_date, $this->end_date, false, false, false, false, 'show-default-overall-dashboard' );
			$results     = isset( $raw_results['totalsForAllResults'] ) ? $raw_results['totalsForAllResults'] : array();

			// New vs returning users.
			$new_returning_stats = $this->wp_analytify->pa_get_analytics_dashboard( 'ga:users', $this->start_date, $this->end_date, 'ga:userType', false, false, false, 'show-default-new-returning-dashboard' );

			$new_users       = isset( $new_returning_stats['rows'][0][1] ) ? $new_returning_stats['rows'][0][1] : 0;
			$returning_users = isset( $new_returning_stats['rows'][1][1] ) ? $new_returning_stats['rows'][1][1] : 0;

			// Device category stats.
			$device_category_stats = $this->wp_analytify->pa_get_analytics_dashboard( 'ga:sessions', $this->start_date, $this->end_date, 'ga:deviceCategory', '-ga:sessions', false, false, 'show-default-overall-device-dashboard' );

			if ( ! empty( $device_category_stats->rows ) ) {
				foreach ( $device_category_stats->rows as $row ) {
					if ( 'mobile' === $row[0] ) {
						$device_data['mobile'] = $row[1];
					} elseif ( 'tablet' === $row[0] ) {
						$device_data['tablet'] = $row[1];
					} elseif ( 'desktop' === $row[0] ) {
						$device_data['desktop'] = $row[1];
					}
				}
			}

			// Get previous stats of same date range.
			if ( $date_diff ) {
				$raw_compare_results = $this->wp_analytify->pa_get_analytics_dashboard( 'ga:sessions,ga:users,ga:pageviews,ga:avgSessionDuration,ga:bounceRate,ga:pageviewsPerSession,ga:percentNewSessions,ga:newUsers,ga:sessionDuration', $date_diff['start_date'], $date_diff['end_date'], false, false, false, false, 'show-default-overall-dashboard-compare' );
				$compare_results     = isset( $raw_compare_results['totalsForAllResults'] ) ? $raw_compare_results['totalsForAllResults'] : array();
			}

			$stats = array(
				array(
					'Sessions',
					WPANALYTIFY_Utils::pretty_numbers( $results['ga:sessions'] ),
					$date_diff && $compare_results['ga:sessions'] ? number_format( ( ( $results['ga:sessions'] - $compare_results['ga:sessions'] ) / $compare_results['ga:sessions'] ) * 100, 2 ) . '%' : '0%',
				),
				array(
					'Visitors',
					WPANALYTIFY_Utils::pretty_numbers( $results['ga:users'] ),
					$date_diff && $compare_results['ga:users'] ? number_format( ( ( $results['ga:users'] - $compare_results['ga:users'] ) / $compare_results['ga:users'] ) * 100, 2 ) . '%' : '0%',
				),
				array(
					'Page Views',
					WPANALYTIFY_Utils::pretty_numbers( $results['ga:pageviews'] ),
					$date_diff && $compare_results['ga:pageviews'] ? number_format( ( ( $results['ga:pageviews'] - $compare_results['ga:pageviews'] ) / $compare_results['ga:pageviews'] ) * 100, 2 ) . '%' : '0%',
				),
				array(
					'Avg. Time On Site',
					strip_tags( WPANALYTIFY_Utils::pretty_numbers( $results['ga:avgSessionDuration'] ) ),
					$date_diff && $compare_results['ga:avgSessionDuration'] ? number_format( ( ( $results['ga:avgSessionDuration'] - $compare_results['ga:avgSessionDuration'] ) / $compare_results['ga:avgSessionDuration'] ) * 100, 2 ) . '%' : '0%',
				),
				array(
					'Bounce Rate',
					WPANALYTIFY_Utils::pretty_numbers( $results['ga:bounceRate'] ).'%',
					$date_diff && $compare_results['ga:bounceRate'] ? number_format( ( ( $results['ga:bounceRate'] - $compare_results['ga:bounceRate'] ) / $compare_results['ga:bounceRate'] ) * 100, 2 ) . '%' : '0%',
				),
				array(
					'Pages/Session',
					round( $results['ga:pageviewsPerSession'], 2 ),
					$date_diff && $compare_results['ga:pageviewsPerSession'] ? number_format( ( ( $results['ga:pageviewsPerSession'] - $compare_results['ga:pageviewsPerSession'] ) / $compare_results['ga:pageviewsPerSession'] ) * 100, 2 ) . '%' : '0%',
				),
				array(
					'% New Sessions',
					WPANALYTIFY_Utils::pretty_numbers( $results['ga:percentNewSessions'] ),
					$date_diff && $compare_results['ga:percentNewSessions'] ? number_format( ( ( $results['ga:percentNewSessions'] - $compare_results['ga:percentNewSessions'] ) / $compare_results['ga:percentNewSessions'] ) * 100, 2 ) . '%' : '0%',
				),
				array(
					'New Users',
					WPANALYTIFY_Utils::pretty_numbers( $new_users ),
					'',
				),
				array(
					'Returning Users',
					WPANALYTIFY_Utils::pretty_numbers( $returning_users ),
					'',
				),
				array(
					'Mobile Visitors',
					WPANALYTIFY_Utils::pretty_numbers( $device_data['mobile'] ),
					'',
				),
				array(
					'Tablet Visitors',
					WPANALYTIFY_Utils::pretty_numbers( $device_data['tablet'] ),
					'',
				),
				array(
					'Desktop Visitors',
					WPANALYTIFY_Utils::pretty_numbers( $device_data['desktop'] ),
					'',
				),
			);

		}

		$columns = array(
			array(
				'0' => esc_html__( 'Stats Name', 'wp-analytify-pro' ),
				'1' => esc_html__( 'Stats Value', 'wp-analytify-pro' ),
				'2' => esc_html__( 'Conversion Rate', 'wp-analytify-pro' ),
			),
		);
		return array_merge( $columns, $stats );
	}

	/**
	 * Generates 'top-pages'.
	 *
	 * @return array
	 */
	private function export_top_pages() {

		// API limit.
		$api_limit = apply_filters( 'analytify_api_limit_top_pages_stats', 100, 'csv_export' );

		// Site URL.
		$site_url = $this->get_profile_info( 'website_url' );

		// Data holder.
		$stats = array();

		if ( 'ga4' === $this->ga_mode ) {

			$stats_raw = $this->wp_analytify->get_reports(
				'show-default-top-pages-dashboard',
				array(
					'screenPageViews',
					'userEngagementDuration',
					'bounceRate',
				),
				$this->get_dates(),
				array(
					'pageTitle',
					'pagePath',
				),
				array(
					'type'  => 'metric',
					'name'  => 'screenPageViews',
					'order' => 'desc',
				),
				array(
					'logic'   => 'AND',
					'filters' => array(
						array(
							'type'           => 'dimension',
							'name'           => 'pageTitle',
							'match_type'     => 4,
							'value'          => '(not set)',
							'not_expression' => true,
						),
						array(
							'type'           => 'dimension',
							'name'           => 'pagePath',
							'match_type'     => 4,
							'value'          => '(not set)',
							'not_expression' => true,
						),
					),
				),
				$api_limit,
				false
			);

			if ( isset( $stats_raw['rows'] ) && $stats_raw['rows'] ) {
				foreach ( $stats_raw['rows'] as $row ) {
					$views = $row['screenPageViews'] ? $row['screenPageViews'] : 0;
					if ( $views < 1 ) {
						continue;
					}
					$stats[] = array(
						'0' => $row['pageTitle'],
						'1' => $site_url . $row['pagePath'],
						'2' => WPANALYTIFY_Utils::pretty_numbers( $views ),
						'3' => $row['userEngagementDuration'] ? strip_tags( WPANALYTIFY_Utils::pretty_time( $row['userEngagementDuration'] ) ) : 0,
						'4' => ( $row['bounceRate'] ? WPANALYTIFY_Utils::pretty_numbers( $row['bounceRate'] ) : 0 ) . '%',
					);
				}
			}
		} else {

			$stats_raw = $this->wp_analytify->pa_get_analytics_dashboard( 'ga:pageviews,ga:avgTimeOnPage,ga:bounceRate', $this->start_date, $this->end_date, 'ga:PageTitle,ga:pagePath', '-ga:pageviews', false, $api_limit, );
			if ( isset( $stats_raw['rows'] ) && $stats_raw['rows'] ) {
				foreach ( $stats_raw['rows'] as $row ) {
					if ( $row[2] <= 0 ) {
						continue;
					}
					$stats[] = array(
						'0' => $row[0],
						'1' => $site_url . $row[1],
						'2' => $row[2] ? WPANALYTIFY_Utils::pretty_numbers( $row[2] ) : 0,
						'3' => $row[3] ? strip_tags( WPANALYTIFY_Utils::pretty_time( $row[3] ) ) : 0,
						'4' => ( $row[4] ? WPANALYTIFY_Utils::pretty_numbers( $row[4] ) : 0 ) . '%',
					);
				}
			}
		}

		$columns = array(
			array(
				'0' => esc_html__( 'Title', 'wp-analytify-pro' ),
				'1' => esc_html__( 'Link', 'wp-analytify-pro' ),
				'2' => esc_html__( 'Views', 'wp-analytify-pro' ),
				'3' => esc_html__( 'Avg. Time', 'wp-analytify-pro' ),
				'4' => esc_html__( 'Bounce Rate', 'wp-analytify-pro' ),
			),
		);
		return array_merge( $columns, $stats );
	}

	/**
	 * Generates 'top-countries'.
	 *
	 * @return array
	 */
	private function export_top_countries() {

		// API limit.
		$api_limit =  apply_filters( 'analytify_api_limit_country_stats', 100, 'csv_export' );

		$stats = array();

		if ( 'ga4' === $this->ga_mode ) {

			$stats_raw = $this->wp_analytify->get_reports(
				'show-geographic-countries-dashboard',
				array(
					'sessions',
				),
				$this->get_dates(),
				array(
					'country',
				),
				array(
					'type'  => 'dimension',
					'name'  => 'sessions',
					'order' => 'desc',
				),
				array(
					'logic'   => 'AND',
					'filters' => array(
						array(
							'type'           => 'dimension',
							'name'           => 'country',
							'match_type'     => 4,
							'value'          => '(not set)',
							'not_expression' => true,
						),
					),
				),
				$api_limit,
				false
			);

			if ( isset( $stats_raw['rows'] ) && $stats_raw['rows'] ) {
				foreach ( $stats_raw['rows'] as $row ) {
					$stats[] = array(
						'0' => $row['country'],
						'1' => $row['sessions'],
					);
				}
			}

		} else {

			$stats_raw = $this->wp_analytify->pa_get_analytics_dashboard( 'ga:sessions', $this->start_date, $this->end_date, 'ga:country', '-ga:sessions', 'ga:country!=(not set)', $api_limit );
			$stats     = $stats_raw['rows'];

		}

		$columns = array(
			array(
				'0' => esc_html__( 'Country', 'wp-analytify-pro' ),
				'1' => esc_html__( 'Views', 'wp-analytify-pro' ),
			),
		);
		return array_merge( $columns, $stats );
	}

	/**
	 * Generates 'top-cities'.
	 *
	 * @return array
	 */
	private function export_top_cities() {

		// API limit.
		$api_limit = apply_filters( 'analytify_api_limit_city_stats', 100, 'csv_export' );

		$stats = array();

		if ( 'ga4' === $this->ga_mode ) {

			$stats_raw = $this->wp_analytify->get_reports(
				'show-geographic-countries-dashboard',
				array(
					'sessions',
				),
				$this->get_dates(),
				array(
					'city',
					'country',
				),
				array(
					'type'  => 'metric',
					'name'  => 'sessions',
					'order' => 'desc',
				),
				array(
					'logic'   => 'AND',
					'filters' => array(
						array(
							'type'           => 'dimension',
							'name'           => 'city',
							'match_type'     => 4,
							'value'          => '(not set)',
							'not_expression' => true,
						),
						array(
							'type'           => 'dimension',
							'name'           => 'country',
							'match_type'     => 4,
							'value'          => '(not set)',
							'not_expression' => true,
						),
					),
				),
				$api_limit,
				false
			);

			if ( isset( $stats_raw['rows'] ) && $stats_raw['rows'] ) {
				foreach ( $stats_raw['rows'] as $row ) {
					$stats[] = array(
						'0' => $row['city'],
						'1' => $row['country'],
						'2' => $row['sessions'],
					);
				}
			}
		} else {

			$stats_raw = $this->wp_analytify->pa_get_analytics_dashboard( 'ga:sessions', $this->start_date, $this->end_date, 'ga:city,ga:country', '-ga:sessions', 'ga:city!=(not set);ga:country!=(not set)', $api_limit );
			$stats     = $stats_raw['rows'];

		}

		$columns = array(
			array(
				'0' => esc_html__( 'City', 'wp-analytify-pro' ),
				'1' => esc_html__( 'Country', 'wp-analytify-pro' ),
				'2' => esc_html__( 'Views', 'wp-analytify-pro' ),
			),
		);
		return array_merge( $columns, $stats );
	}

	/**
	 * Generates 'top-keywords'.
	 *
	 * @return array
	 */
	private function export_top_keywords() {

		// API limit.
		$api_limit = apply_filters( 'analytify_api_limit_keywords_stats', 100, 'csv_export' );

		$stats = array();

		if ( 'ga4' === $this->ga_mode ) {

			$stats_raw = $this->wp_analytify->get_search_console_stats(
				'show-default-keyword-dashboard',
				$this->get_dates(),
				$api_limit
			);

			if ( isset( $stats_raw['error']['status'] ) && isset( $stats_raw['error']['message'] ) ) {
				return false;
			}

			if ( isset( $stats_raw['response']['rows'] ) && $stats_raw['response']['rows'] > 0 ) {
				foreach ( $stats_raw['response']['rows'] as $row ) {
					$stats[] = array(
						'0' => $row['keys'][0],
						'1' => $row['clicks'],
					);
				}
			}
		} else {
			$stats_raw = $this->wp_analytify->pa_get_analytics_dashboard( 'ga:sessions', $this->start_date, $this->end_date, 'ga:keyword', '-ga:sessions', false, $api_limit );
			$stats     = $stats_raw['rows'];
		}

		$columns = array(
			array(
				'0' => esc_html__( 'Keyword', 'wp-analytify-pro' ),
				'1' => esc_html__( 'Views', 'wp-analytify-pro' ),
			),
		);
		return array_merge( $columns, $stats );
	}

	/**
	 * Generates 'top-social-media'.
	 *
	 * @return array
	 */
	private function export_top_social_media() {

		// API limit.
		$api_limit = apply_filters( 'analytify_api_limit_social_media_stats', 100, 'csv_export' );

		$stats = array();

		if ( 'ga4' === $this->ga_mode ) {
			// TODO: missing_ga4.
			return false;
		} else {
			$stats_raw = $this->wp_analytify->pa_get_analytics_dashboard( 'ga:sessions', $this->start_date, $this->end_date, 'ga:socialNetwork', '-ga:sessions', 'ga:socialNetwork!=(not set)', $api_limit );
			$stats     = $stats_raw['rows'];
		}

		$columns = array(
			array(
				'0' => esc_html__( 'Social Media', 'wp-analytify-pro' ),
				'1' => esc_html__( 'Views', 'wp-analytify-pro' ),
			),
		);
		return array_merge( $columns, $stats );
	}

	/**
	 * Generates 'top-referrer'.
	 *
	 * @return array
	 */
	private function export_top_referrer() {

		// API limit.
		$api_limit = apply_filters( 'analytify_api_limit_referer_stats', 100, 'csv_export' );

		$stats = array();

		if ( 'ga4' === $this->ga_mode ) {
			$stats_raw = $this->wp_analytify->get_reports(
				'show-default-refers-dashboard',
				array(
					'sessions',
				),
				$this->get_dates(),
				array(
					'sessionSource',
					'sessionMedium',
				),
				array(
					'type'  => 'metric',
					'name'  => 'sessions',
					'order' => 'desc',
				),
				array(),
				$api_limit,
				false
			);

			if ( isset( $stats_raw['rows'] ) && $stats_raw['rows'] ) {
				foreach ( $stats_raw['rows'] as $row ) {
					$stats[] = array(
						'0' => $row['sessionSource'],
						'1' => $row['sessionMedium'],
						'2' => $row['sessions'],
					);
				}
			}
		} else {
			$stats_raw = $this->wp_analytify->pa_get_analytics_dashboard( 'ga:sessions', $this->start_date, $this->end_date, 'ga:source,ga:medium', '-ga:sessions', false, $api_limit );
			$stats     = $stats_raw['rows'];
		}

		$columns = array(
			array(
				'0' => esc_html__( 'Referrers', 'wp-analytify-pro' ),
				'1' => esc_html__( 'Type', 'wp-analytify-pro' ),
				'2' => esc_html__( 'Views', 'wp-analytify-pro' ),
			),
		);
		return array_merge( $columns, $stats );
	}

	/**
	 * Generates 'top-referrer'.
	 *
	 * @return array
	 */
	private function export_what_is_happening() {

		// API limit.
		$api_limit = apply_filters( 'analytify_api_limit_what_happen_stats', 100, 'csv_export' );

		// Site URL.
		$site_url = $this->get_profile_info( 'website_url' );

		$stats = array();

		if ( 'ga4' === $this->ga_mode ) {

			$stats_raw = $this->wp_analytify->get_reports(
				'show-default-what-happen',
				array(
					'engagedSessions',
					'engagementRate',
					'userEngagementDuration',
				),
				$this->get_dates(),
				array(
					'landingPage',
					'pageTitle',
				),
				array(
					'type'  => 'metric',
					'name'  => 'engagedSessions',
					'order' => 'desc',
				),
				array(),
				$api_limit,
				false
			);

			if ( isset( $stats_raw['rows'] ) && $stats_raw['rows'] ) {
				foreach ( $stats_raw['rows'] as $row ) {
					$stats[] = array(
						'0' => $row['pageTitle'],
						'1' => $row['landingPage'],
						'2' => strip_tags( WPANALYTIFY_Utils::pretty_time( $row['userEngagementDuration'] ) ),
						'3' => WPANALYTIFY_Utils::pretty_numbers( $row['engagedSessions'] ),
						'4' => round( $row['engagementRate'], 2 ) . '%',
					);
				}
			}

			$columns = array(
				array(
					'0' => esc_html__( 'Title', 'wp-analytify-pro' ),
					'1' => esc_html__( 'Link', 'wp-analytify-pro' ),
					'2' => esc_html__( 'User Engagement Duration', 'wp-analytify-pro' ),
					'3' => esc_html__( 'Engaged Sessions', 'wp-analytify-pro' ),
					'4' => esc_html__( 'Engagement Rate', 'wp-analytify-pro' ),
				),
			);

		} else {

			$stats_raw = $this->wp_analytify->pa_get_analytics_dashboard( 'ga:entrances,ga:exits,ga:entranceRate,ga:exitRate', $this->start_date, $this->end_date, 'ga:pageTitle,ga:pagePath', '-ga:entrances', false, $api_limit );

			if ( isset( $stats_raw['rows'] ) && $stats_raw['rows'] ) {
				foreach ( $stats_raw['rows'] as $row ) {
					$stats[] = array(
						'0' => $row[0],
						'1' => $site_url . $row[1],
						'2' => $row[2],
						'3' => $row[3],
						'4' => $row[4],
						'5' => $row[5],
					);
				}
			}

			$columns = array(
				array(
					'0' => esc_html__( 'Title', 'wp-analytify-pro' ),
					'1' => esc_html__( 'Link', 'wp-analytify-pro' ),
					'2' => esc_html__( 'Entrance', 'wp-analytify-pro' ),
					'3' => esc_html__( 'Exits', 'wp-analytify-pro' ),
					'4' => esc_html__( 'Entrance %', 'wp-analytify-pro' ),
					'5' => esc_html__( 'Exits %', 'wp-analytify-pro' ),
				),
			);
		}

		return array_merge( $columns, $stats );
	}

	/**
	 * Generates 'top-ajax'.
	 *
	 * @return array
	 */
	private function export_top_ajax_errors() {

		// API limit.
		$api_limit = apply_filters( 'analytify_api_limit_ajax_error_stats', 100, 'csv_export' );

		$stats = array();

		if ( 'ga4' === $this->ga_mode ) {
			$stats_raw = $this->wp_analytify->get_reports(
				'show-top-ajax-errors',
				array(
					'eventCount',
				),
				$this->get_dates(),
				array(
					'customEvent:wpa_action',
					'customEvent:wpa_category',
					'customEvent:wpa_label',
				),
				array(
					'type'  => 'metric',
					'name'  => 'eventCount',
					'order' => 'desc',
				),
				array(
					'logic'   => 'AND',
					'filters' => array(
						array(
							'type'       => 'dimension',
							'name'       => 'customEvent:wpa_category',
							'match_type' => 1,
							'value'      => 'Ajax Error',
						),
					),
				),
				$api_limit,
				false
			);

			if ( isset( $stats_raw['rows'] ) && $stats_raw['rows'] ) {
				foreach ( $stats_raw['rows'] as $row ) {
					$stats[] = array(
						'0' => $row['customEvent:wpa_action'],
						'1' => $row['customEvent:wpa_label'],
						'2' => WPANALYTIFY_Utils::pretty_numbers( $row['eventCount'] ),
					);
				}
			}
		} else {

			$stats_raw = $this->wp_analytify->pa_get_analytics_dashboard( 'ga:totalEvents', $this->start_date, $this->end_date, 'ga:eventAction,ga:eventLabel', '-ga:totalEvents', 'ga:eventCategory==Ajax Error', $api_limit );

			if ( isset( $stats_raw['rows'] ) && $stats_raw['rows'] ) {
				foreach ( $stats_raw['rows'] as $row ) {
					$stats[] = array(
						'0' => $row[0],
						'1' => $row[1],
						'2' => WPANALYTIFY_Utils::pretty_numbers( $row[2] ),
					);
				}
			}
		}

		$columns = array(
			array(
				'0' => esc_html__( 'Error', 'wp-analytify-pro' ),
				'1' => esc_html__( 'Link', 'wp-analytify-pro' ),
				'2' => esc_html__( 'Hits', 'wp-analytify-pro' ),
			),
		);
		return array_merge( $columns, $stats );
	}

	/**
	 * Generates 'top-404'.
	 *
	 * @return array
	 */
	private function export_top_404_errors() {

		// API limit.
		$api_limit = apply_filters( 'analytify_api_limit_404_error_stats', 100, 'csv_export' );

		$stats = array();

		if ( 'ga4' === $this->ga_mode ) {
			$stats_raw = $this->wp_analytify->get_reports(
				'show-top-404-pages',
				array(
					'eventCount',
				),
				$this->get_dates(),
				array(
					'customEvent:wpa_category',
					'customEvent:wpa_label',
				),
				array(
					'type'  => 'metric',
					'name'  => 'eventCount',
					'order' => 'desc',
				),
				array(
					'logic'   => 'AND',
					'filters' => array(
						array(
							'type'       => 'dimension',
							'name'       => 'customEvent:wpa_category',
							'match_type' => 1,
							'value'      => '404 Error',
						),
					),
				),
				$api_limit,
				false
			);

			if ( isset( $stats_raw['rows'] ) && $stats_raw['rows'] ) {
				foreach ( $stats_raw['rows'] as $row ) {
					$stats[] = array(
						'0'  => $row['customEvent:wpa_label'],
						'1' => WPANALYTIFY_Utils::pretty_numbers( $row['eventCount'] ),
					);
				}
			}
		} else {
			$stats_raw = $this->wp_analytify->pa_get_analytics_dashboard( 'ga:totalEvents', $this->start_date, $this->end_date, 'ga:eventAction,ga:eventLabel', '-ga:totalEvents', 'ga:eventCategory==404 Error', $api_limit );

			if ( isset( $stats_raw['rows'] ) && $stats_raw['rows'] ) {
				foreach ( $stats_raw['rows'] as $row ) {
					$stats[] = array(
						'0' => $row[1],
						'1' => WPANALYTIFY_Utils::pretty_numbers( $row[2] ),
					);
				}
			}
		}

		$columns = array(
			array(
				'0' => esc_html__( 'Link', 'wp-analytify-pro' ),
				'1' => esc_html__( 'Hits', 'wp-analytify-pro' ),
			),
		);
		return array_merge( $columns, $stats );
	}

	/**
	 * Generates 'top-js-error'.
	 *
	 * @return array
	 */
	private function export_top_js_errors() {

		// API limit.
		$api_limit = apply_filters( 'analytify_api_limit_js_error_stats', 100, 'csv_export' );

		$stats = array();

		if ( 'ga4' === $this->ga_mode ) {
			$stats_raw = $this->wp_analytify->get_reports(
				'show-top-js-errors',
				array(
					'eventCount',
				),
				$this->get_dates(),
				array(
					'customEvent:wpa_action',
					'customEvent:wpa_label',
					'customEvent:wpa_category',
				),
				array(
					'type'  => 'metric',
					'name'  => 'eventCount',
					'order' => 'desc',
				),
				array(
					'logic'   => 'AND',
					'filters' => array(
						array(
							'type'       => 'dimension',
							'name'       => 'customEvent:wpa_category',
							'match_type' => 1,
							'value'      => 'JavaScript Error',
						),
					),
				),
				$api_limit,
				false
			);

			if ( isset( $stats_raw['rows'] ) && $stats_raw['rows'] ) {
				foreach ( $stats_raw['rows'] as $row ) {
					$stats[] = array(
						'0' => $row['customEvent:wpa_action'],
						'1' => $row['customEvent:wpa_label'],
						'2' => WPANALYTIFY_Utils::pretty_numbers( $row['eventCount'] ),
					);
				}
			}
		} else {
			$stats_raw = $this->wp_analytify->pa_get_analytics_dashboard( 'ga:totalEvents', $this->start_date, $this->end_date, 'ga:eventAction,ga:eventLabel', '-ga:totalEvents', 'ga:eventCategory==JavaScript Error', $api_limit );

			if ( isset( $stats_raw['rows'] ) && $stats_raw['rows'] ) {
				foreach ( $stats_raw['rows'] as $row ) {
					$stats[] = array(
						'0' => $row[0],
						'1' => $row[1],
						'2' => WPANALYTIFY_Utils::pretty_numbers( $row[2] ),
					);
				}
			}
		}

		$columns = array(
			array(
				'0' => esc_html__( 'Error', 'wp-analytify-pro' ),
				'1' => esc_html__( 'Link', 'wp-analytify-pro' ),
				'2' => esc_html__( 'Hits', 'wp-analytify-pro' ),
			),
		);
		return array_merge( $columns, $stats );
	}

	/**
	 * Generates 'top-browsers'.
	 *
	 * @return array
	 */
	private function export_top_browsers() {

		// API limit.
		$api_limit = apply_filters( 'analytify_api_limit_browser_stats', 100, 'csv_export' );

		$stats = array();

		if ( 'ga4' === $this->ga_mode ) {
			$stats_raw = $this->wp_analytify->get_reports(
				'show-default-browser-dashboard',
				array(
					'sessions',
				),
				$this->get_dates(),
				array(
					'browser',
					'operatingSystem',
				),
				array(
					'type'  => 'metric',
					'name'  => 'sessions',
					'order' => 'desc',
				),
				array(
					'logic'   => 'AND',
					'filters' => array(
						array(
							'type'           => 'dimension',
							'name'           => 'operatingSystem',
							'match_type'     => 4,
							'value'          => '(not set)',
							'not_expression' => true,
						),
					),
				),
				$api_limit,
				false
			);

			if ( isset( $stats_raw['rows'] ) && $stats_raw['rows'] ) {
				foreach ( $stats_raw['rows'] as $rows ) {
					$stats[] = array(
						'0' => $rows['browser'],
						'1' => $rows['operatingSystem'],
						'2' => WPANALYTIFY_Utils::pretty_numbers( $rows['sessions'] ),
					);
				}
			}
		} else {
			$stats_raw = $this->wp_analytify->pa_get_analytics_dashboard( 'ga:sessions', $this->start_date, $this->end_date, 'ga:browser,ga:operatingSystem', '-ga:sessions', 'ga:browser!=(not set);ga:operatingSystem!=(not set)', $api_limit );
			$stats     = $stats_raw['rows'];
		}

		$columns = array(
			array(
				'0' => esc_html__( 'Browser', 'wp-analytify-pro' ),
				'1' => esc_html__( 'Operating System', 'wp-analytify-pro' ),
				'2' => esc_html__( 'Visits', 'wp-analytify-pro' ),
			),
		);
		return array_merge( $columns, $stats );
	}

	/**
	 * Generates 'top-operating-system'.
	 *
	 * @return array
	 */
	private function export_top_operating_system() {

		// API limit.
		$api_limit = apply_filters( 'analytify_api_limit_os_stats', 100, 'csv_export' );

		$stats = array();

		if ( 'ga4' === $this->ga_mode ) {
			$stats_raw = $this->wp_analytify->get_reports(
				'show-default-os-dashboard',
				array(
					'sessions',
				),
				$this->get_dates(),
				array(
					'operatingSystem',
					'operatingSystemVersion',
				),
				array(
					'type'  => 'metric',
					'name'  => 'sessions',
					'order' => 'desc',
				),
				array(
					'logic'   => 'AND',
					'filters' => array(
						array(
							'type'           => 'dimension',
							'name'           => 'operatingSystemVersion',
							'match_type'     => 4,
							'value'          => '(not set)',
							'not_expression' => true,
						),
					),
				),
				$api_limit,
				false
			);

			if ( isset( $stats_raw['rows'] ) && $stats_raw['rows'] ) {
				foreach ( $stats_raw['rows'] as $rows ) {
					$stats[] = array(
						'0' => $rows['operatingSystem'],
						'1' => $rows['operatingSystemVersion'],
						'2' => WPANALYTIFY_Utils::pretty_numbers( $rows['sessions'] ),
					);
				}
			}
		} else {
			$stats_raw = $this->wp_analytify->pa_get_analytics_dashboard( 'ga:sessions', $this->start_date, $this->end_date, 'ga:operatingSystem,ga:operatingSystemVersion', '-ga:sessions', 'ga:operatingSystemVersion!=(not set)', $api_limit );
			$stats     = $stats_raw['rows'];
		}

		$columns = array(
			array(
				'0' => esc_html__( 'Operating System', 'wp-analytify-pro' ),
				'1' => esc_html__( 'Version', 'wp-analytify-pro' ),
				'2' => esc_html__( 'Visits', 'wp-analytify-pro' ),
			),
		);
		return array_merge( $columns, $stats );
	}

	/**
	 * Generates 'top-mobile-device'.
	 *
	 * @return array
	 */
	private function export_top_mobile_device() {

		// API limit.
		$api_limit = apply_filters( 'analytify_api_limit_mobile_stats', 100, 'csv_export' );

		$stats = array();

		if ( 'ga4' === $this->ga_mode ) {
			$stats_raw = $this->wp_analytify->get_reports(
				'show-default-mobile-dashboard',
				array(
					'sessions',
				),
				$this->get_dates(),
				array(
					'mobileDeviceBranding',
					'mobileDeviceModel',
				),
				array(
					'type'  => 'metric',
					'name'  => 'sessions',
					'order' => 'desc',
				),
				array(
					'logic'   => 'AND',
					'filters' => array(
						array(
							'type'           => 'dimension',
							'name'           => 'deviceCategory',
							'match_type'     => 4,
							'value'          => 'desktop',
							'not_expression' => true,
						),
						array(
							'type'           => 'dimension',
							'name'           => 'mobileDeviceModel',
							'match_type'     => 4,
							'value'          => '(not set)',
							'not_expression' => true,
						),
					),
				),
				$api_limit,
				false
			);
			if ( isset( $stats_raw['rows'] ) && $stats_raw['rows'] ) {
				foreach ( $stats_raw['rows'] as $row ) {
					$stats[] = array(
						'0' => $row['mobileDeviceBranding'],
						'1' => $row['mobileDeviceModel'],
						'2' => WPANALYTIFY_Utils::pretty_numbers( $row['sessions'] ),
					);
				}
			}
		} else {
			$stats_raw = $this->wp_analytify->pa_get_analytics_dashboard( 'ga:sessions', $this->start_date, $this->end_date, 'ga:mobileDeviceBranding,ga:mobileDeviceModel', '-ga:sessions', 'ga:mobileDeviceModel!=(not set);ga:mobileDeviceBranding!=(not set)', $api_limit );
			$stats     = $stats_raw['rows'];
		}

		$columns = array(
			array(
				'0' => esc_html__( 'Device', 'wp-analytify-pro' ),
				'1' => esc_html__( 'Model', 'wp-analytify-pro' ),
				'2' => esc_html__( 'Visits', 'wp-analytify-pro' ),
			),
		);
		return array_merge( $columns, $stats );
	}

	/**
	 * Forms dashboard (individual sections).
	 *
	 * @param string $form Form category.
	 * @return array
	 */
	private function export_forms_dashboard( $form ) {

		// API limit.
		$api_limit = apply_filters( 'analytify_api_limit_forms', 100, 'csv_export', $form );

		$stats = array();

		if ( 'ga4' === $this->ga_mode ) {
			$raw_report = $this->wp_analytify->get_reports(
				'show-analytify-forms-dashboard',
				array(
					'eventCount',
				),
				$this->get_dates(),
				array(
					'customEvent:wpa_category',
					'customEvent:wpa_link_action',
					'customEvent:wpa_link_label',
				),
				array(
					'type'  => 'metric',
					'name'  => 'eventCount',
					'order' => 'desc',
				),
				array(
					'logic'   => 'AND',
					'filters' => array(
						array(
							'type'       => 'dimension',
							'name'       => 'customEvent:wpa_category',
							'match_type' => 1,
							'value'      => $form,
						),
					),
				),
				$api_limit,
				false,
			);

			// Break the report into separate forms for submission and impression.
			if ( isset( $raw_report['rows'] ) && ! empty( $raw_report['rows'] ) ) {
				foreach ( $raw_report['rows'] as $raw_rows ) {
					$_ct   = $raw_rows['customEvent:wpa_category'];
					$_lb   = $raw_rows['customEvent:wpa_link_label'];
					$_ac   = $raw_rows['customEvent:wpa_link_action'];
					$count = $raw_rows['eventCount'];

					$stats = apply_filters( 'analytify_forms_row_format', $stats, $_ct, $_lb, $_ac, $count );
				}
			}
		} else {
			$raw_report = $this->wp_analytify->pa_get_analytics_dashboard( 'ga:totalEvents', $this->start_date, $this->end_date, 'ga:eventCategory,ga:eventAction,ga:eventLabel', '-ga:totalEvents', 'ga:eventCategory=@' . $form, $api_limit );

			// Break the report into separate forms for submission and impression.
			if ( isset( $raw_report['rows'] ) && ! empty( $raw_report['rows'] ) ) {
				foreach ( $raw_report['rows'] as $raw_rows ) {
					$_ct   = $raw_rows[0];
					$_lb   = $raw_rows[2];
					$_ac   = $raw_rows[1];
					$count = $raw_rows[3];

					$stats = apply_filters( 'analytify_forms_row_format', $stats, $_ct, $_lb, $_ac, $count );
				}
			}
		}

		if ( ! empty( $stats ) ) {
			// Remove keys from parent and child arrays to fit the export standard.
			$stats = array_map(
				function ( $item ) { return array_values( $item ); },
				array_values( $stats[ $form ]['stats'] )
			);
		}

		if ( 'analytify_form_custom' === $form ) {
			$columns = array(
				array(
					'0' => esc_html__( 'Name', 'wp-analytify-pro' ),
					'1' => esc_html__( 'Impressions', 'wp-analytify-pro' ),
					'2' => esc_html__( 'Submissions', 'wp-analytify-pro' ),
				),
			);
		} else {
			$columns = array(
				array(
					'0' => esc_html__( 'Form ID', 'wp-analytify-pro' ),
					'1' => esc_html__( 'Name', 'wp-analytify-pro' ),
					'2' => esc_html__( 'Impressions', 'wp-analytify-pro' ),
					'3' => esc_html__( 'Submissions', 'wp-analytify-pro' ),
				),
			);
		}

		return array_merge( $columns, $stats );
	}

	/**
	 * Generates events tracking dashboard (individual sections).
	 *
	 * @return array
	 */
	private function export_event_tracking_section() {

		switch ( $this->type ) {
			case 'external-links':
				$section = 'external';
				break;

			case 'download-links':
				$section = 'download';
				break;

			case 'tel-links':
				$section = 'tel';
				break;

			case 'affiliate-links':
				$section = 'outbound-link';
				break;

			case 'mail-links':
				$section = 'mail';
				break;

			default:
				return false;
		}

		// API limit.
		$api_limit = apply_filters( 'analytify_api_limit_event_tracking', 100, 'csv_export', $section );

		$stats = array();

		$categories = array( 'external', 'download', 'tel', 'outbound-link', 'mail' );
		if ( ! in_array( $section, $categories, true ) ) {
			return $stats;
		}

		if ( 'ga4' === $this->ga_mode ) {
			$stats_raw = $this->wp_analytify->get_reports(
				'show-default-events-tracking',
				array(
					'eventCount',
				),
				$this->get_dates(),
				array(
					'customEvent:wpa_category',
					'customEvent:wpa_link_label',
					'customEvent:wpa_link_action',
				),
				array(
					'type'  => 'metric',
					'name'  => 'eventCount',
					'order' => 'desc',
				),
				array(
					'logic'   => 'AND',
					'filters' => array(
						array(
							'type'       => 'dimension',
							'name'       => 'customEvent:wpa_category',
							'match_type' => '1',
							'value'      => $section,
						),
					),
				),
				$api_limit,
				false
			);
			if ( isset( $stats_raw['rows'] ) && $stats_raw['rows'] ) {
				foreach ( $stats_raw['rows'] as $row ) {
					$stats[] = array(
						'0' => $row['customEvent:wpa_link_label'],
						'1' => $row['customEvent:wpa_link_action'],
						'2' => WPANALYTIFY_Utils::pretty_numbers( $row['eventCount'] ),
					);
				}
			}
		} else {
			$stats_raw = $this->wp_analytify->pa_get_analytics_dashboard( 'ga:totalEvents', $this->start_date, $this->end_date, 'ga:eventCategory,ga:eventLabel,ga:eventAction', '-ga:totalEvents', 'ga:eventCategory==' . $section, $api_limit );
			if ( isset( $stats_raw['rows'] ) && $stats_raw['rows'] ) {
				foreach ( $stats_raw['rows'] as $row ) {
					$stats[] = array(
						'0' => $row[1],
						'1' => $row[2],
						'2' => WPANALYTIFY_Utils::pretty_numbers( $row[3] ),
					);
				}
			}
		}

		$columns = array(
			array(
				'0' => esc_html__( 'Label', 'wp-analytify-pro' ),
				'1' => esc_html__( 'Link', 'wp-analytify-pro' ),
				'2' => esc_html__( 'Clicks', 'wp-analytify-pro' ),
			),
		);
		return array_merge( $columns, $stats );
	}

	/**
	 * Generates custom dimension dashboard (individual sections).
	 *
	 * @return array
	 */
	private function export_custom_dimension_section() {

		// Get set dimensions from settings.
		$setting_dimensions = $this->wp_analytify->settings->get_option( 'analytiy_custom_dimensions', 'wp-analytify-custom-dimensions' );

		$set_dimensions = array();
		$stats          = array();

		foreach ( $setting_dimensions as $dimension ) {
			if ( isset( $dimension['id'] ) ) {
				$set_dimensions[ $dimension['id'] ] = $dimension['type'];
			} else {
				$set_dimensions[] = $dimension['type'];
			}
		}

		$dimensions = array(
			'custom-dimension-post_type'     => 'post_type',
			'custom-dimension-author'        => 'author',
			'custom-dimension-published_at'  => 'published_at',
			'custom-dimension-category'      => 'category',
			'custom-dimension-tags'          => 'tags',
			'custom-dimension-user_id'       => 'user_id',
			'custom-dimension-logged_in'     => 'logged_in',
			'custom-dimension-seo_score'     => 'seo_score',
			'custom-dimension-focus_keyword' => 'focus_keyword',
		);

		if ( empty( array_values( $set_dimensions ) ) || ! in_array( $dimensions[ $this->type ], $set_dimensions, true ) ) {
			return false;
		}

		$api_limit  = apply_filters( 'analytify_api_limit_custom_dimensions_' . $dimensions[ $this->type ] . '_stats', 100, 'csv_export' );

		if ( 'ga4' === $this->ga_mode ) {
			$defined_dimensions = Analytify_Google_Dimensions::get_current_dimensions();
			$identifier         = $defined_dimensions[ $dimensions[ $this->type ] ]['value'];

			$stats_raw = $this->wp_analytify->get_reports(
				'show-sessions-dimensions-stats-' . $identifier,
				array(
					'sessions',
				),
				$this->get_dates(),
				array(
					'customEvent:' . $identifier,
				),
				array(
					'order' => 'desc',
					'type'  => 'metric',
					'name'  => 'sessions',
				),
				array(
					'logic'   => 'AND',
					'filters' => array(
						array(
							'type'           => 'dimension',
							'name'           => 'customEvent:' . $identifier,
							'match_type'     => 4,
							'value'          => '(not set)',
							'not_expression' => true,
						),
					),
				),
				$api_limit,
				false
			);

			if ( isset( $stats_raw['rows'] ) && $stats_raw['rows'] ) {
				foreach ( $stats_raw['rows'] as $row ) {
					$stats[] = array(
						'label' => apply_filters( 'analytify_custom_dimension_row_label', $row[ 'customEvent:' . $identifier ], $dimensions[ $this->type ], 'csv_download' ),
						'views' => $row['sessions'],
					);
				}
			}
		} else {
			$id = array_search( $dimensions[ $this->type ], $set_dimensions, true );
			if ( ! $id ) {
				return false;
			}

			$metric    = 'logged_in' === $dimensions[ $this->type ] || 'user_id' === $dimensions[ $this->type ] ? 'ga:sessions' : 'ga:pageviews';
			$stats_raw = $this->wp_analytify->pa_get_analytics_dashboard( $metric, $this->start_date, $this->end_date, 'ga:dimension' . $id, $metric, false, $api_limit );

			if ( isset( $stats_raw['rows'] ) && $stats_raw['rows'] ) {
				foreach ( $stats_raw['rows'] as $row ) {
					$stats[] = array(
						'label' => apply_filters( 'analytify_custom_dimension_row_label', $row[0], $dimensions[ $this->type ], 'csv_export' ),
						'views' => $row[1],
					);
				}
			}
		}

		$columns = array(
			array(
				'0' => esc_html__( 'Label', 'wp-analytify-pro' ),
				'1' => esc_html__( 'Link', 'wp-analytify-pro' ),
			),
		);
		return array_merge( $columns, $stats );
	}

	/**
	 * Search term dashboard.
	 *
	 * @return array
	 */
	private function export_search_terms() {

		// API limit.
		$api_limit = apply_filters( 'analytify_api_limit_search_term_stats', 100, 'csv_export' );

		$stats = array();

		if ( 'ga4' === $this->ga_mode ) {

			$columns = array(
				array(
					'0' => esc_html__( 'Search Term', 'wp-analytify-pro' ),
					'1' => esc_html__( 'Total Search', 'wp-analytify-pro' ),
					'2' => esc_html__( 'Search per Session', 'wp-analytify-pro' ),
					'3' => esc_html__( 'Total Users', 'wp-analytify-pro' ),
				),
			);

			$stats_raw = $this->wp_analytify->get_reports(
				'show-search-term',
				array(
					'eventCount',
					'sessions',
					'totalUsers',
				),
				$this->get_dates(),
				array(
					'searchTerm',
				),
				array(
					'type'  => 'metric',
					'name'  => 'eventCount',
					'order' => 'desc',
				),
				array(
					'logic'   => 'AND',
					'filters' => array(
						array(
							'type'           => 'dimension',
							'name'           => 'searchTerm',
							'match_type'     => 1,
							'value'          => '',
							'not_expression' => true,
						),
					),
				),
				$api_limit,
				false
			);

			if ( isset( $stats_raw['rows'] ) && $stats_raw['rows'] ) {
				foreach ( $stats_raw['rows'] as $row ) {
					$stats[] = array(
						'term'    => $row['searchTerm'],
						'total'   => $row['eventCount'],
						'session' => $row['sessions'],
						'users'   => $row['totalUsers'],
					);
				}
			}
		} else {

			$columns = array(
				array(
					'0' => esc_html__( 'Search Term', 'wp-analytify-pro' ),
					'1' => esc_html__( 'Total Unique Searches', 'wp-analytify-pro' ),
					'2' => esc_html__( 'Results Pageviews/Search', 'wp-analytify-pro' ),
					'3' => esc_html__( '% Search Exits', 'wp-analytify-pro' ),
					'4' => esc_html__( '% Search Refinements', 'wp-analytify-pro' ),
					'5' => esc_html__( 'Time After Search', 'wp-analytify-pro' ),
					'6' => esc_html__( 'Avg. Search Depth', 'wp-analytify-pro' ),
				),
			);

			$stats_raw = $this->wp_analytify->pa_get_analytics_dashboard( 'ga:searchUniques,ga:avgSearchResultViews,ga:searchExitRate,ga:percentSearchRefinements,ga:avgSearchDuration,ga:avgSearchDepth', $this->start_date, $this->end_date, 'ga:searchKeyword', '-ga:searchUniques', false, $api_limit );
			if ( isset( $stats_raw['rows'] ) && $stats_raw['rows'] ) {
				foreach ( $stats_raw['rows'] as $row ) {
					$stats[] = array(
						'0' => $row[0],
						'1' => $row[1],
						'2' => WPANALYTIFY_Utils::pretty_time( $row[2], 2 ),
						'3' => number_format( $row[3], 2 ) . esc_html__( '%', 'wp-analytify-pro' ),
						'4' => number_format( $row[4], 2 ) . esc_html__( '%', 'wp-analytify-pro' ),
						'5' => WPANALYTIFY_Utils::pretty_time( $row[5] ),
						'6' => number_format( $row[6], 2 ),
					);
				}
			}
		}
		return array_merge( $columns, $stats );
	}

	/**
	 * Demographics dashboard.
	 *
	 * @return array
	 */
	private function export_demographics() {

		// API limit.
		$api_limit = apply_filters( 'analytify_api_limit_demographic_stats', 100, 'csv_export' );

		$stats = array();

		if ( 'ga4' === $this->ga_mode ) {
			$stats_raw = $this->wp_analytify->get_reports(
				'show-demographic-stats',
				array(
					'sessions',
				),
				$this->get_dates(),
				array(
					'userAgeBracket',
					'userGender',
				),
				array(
					'type'  => 'metric',
					'name'  => 'sessions',
					'order' => 'desc',
				),
				array(),
				$api_limit,
				false
			);
			if ( isset( $stats_raw['rows'] ) && $stats_raw['rows'] ) {
				foreach ( $stats_raw['rows'] as $row ) {
					$stats[] = array(
						'0' => $row['userAgeBracket'],
						'1' => $row['userGender'],
						'2' => WPANALYTIFY_Utils::pretty_numbers( $row['sessions'] ),
					);
				}
			}
		} else {
			$stats_raw = $this->wp_analytify->pa_get_analytics_dashboard( 'ga:sessions', $this->start_date, $this->end_date, 'ga:userAgeBracket,ga:userGender', false, false, $api_limit );
			if ( isset( $stats_raw['rows'] ) && $stats_raw['rows'] ) {
				foreach ( $stats_raw['rows'] as $row ) {
					$stats[] = array(
						'0' => $row[0],
						'1' => $row[1],
						'2' => WPANALYTIFY_Utils::pretty_numbers( $row[2] ),
					);
				}
			}
		}

		$columns = array(
			array(
				'0' => esc_html__( 'Age', 'wp-analytify-pro' ),
				'1' => esc_html__( 'Gender', 'wp-analytify-pro' ),
				'2' => esc_html__( 'Visits', 'wp-analytify-pro' ),
			),
		);
		return array_merge( $columns, $stats );
	}

	/**
	 * Authors dashboard.
	 *
	 * @param int $id Author ID.
	 * @return array
	 */
	public function export_author_stats( $id ) {

		if ( '0' != $id ) {
			$wp_user = get_user_by( 'id', $id );
			if ( ! $wp_user ) {
				return array();
			}
		}

		// API limit.
		$api_limit = apply_filters( 'analytify_api_limit_authors_main_dashboard', 100, 'csv_export', $id );

		$stats = array();

		if ( 'ga4' === $this->ga_mode ) {

			$dimension_filers = array();

			if ( '0' != $id ) {
				$dimension_filers[] = array(
					'type'       => 'dimension',
					'name'       => 'customEvent:wpa_author',
					'match_type' => '4',
					'value'      => $wp_user->user_login,
				);
			} else {
				$dimension_filers[] = array(
					'type'           => 'dimension',
					'name'           => 'customEvent:wpa_author',
					'match_type'     => 4,
					'value'          => '(not set)',
					'not_expression' => true,
				);
			}

			$stats_raw = $this->wp_analytify->get_reports(
				'show-authors-stats-' . $id,
				array(
					'sessions',
					'screenPageViews',
					'totalUsers',
					'userEngagementDuration',
					'bounceRate',
				),
				$this->get_dates(),
				array(
					'customEvent:wpa_author',
					'PageTitle',
					'pagePath',
				),
				array(
					'type'  => 'metric',
					'name'  => 'screenPageViews',
					'order' => 'desc',
				),
				array(
					'logic'   => 'AND',
					'filters' => $dimension_filers,
				),
				$api_limit,
				false
			);

			if ( isset( $stats_raw['rows'] ) && $stats_raw['rows'] ) {
				foreach ( $stats_raw['rows'] as $row ) {
					$stats[] = array(
						'0' => $row['customEvent:wpa_author'],
						'1' => $row['PageTitle'],
						'2' => $row['pagePath'],
						'3' => WPANALYTIFY_Utils::pretty_numbers( $row['sessions'] ),
						'4' => WPANALYTIFY_Utils::pretty_numbers( $row['screenPageViews'] ),
						'5' => WPANALYTIFY_Utils::pretty_numbers( $row['totalUsers'] ),
						'6' => strip_tags( WPANALYTIFY_Utils::pretty_time( $row['userEngagementDuration'] ) ),
						'7' => WPANALYTIFY_Utils::pretty_numbers( $row['bounceRate'] ) . '%',
					);
				}
			}
		} else {

			$set_dimensions    = $this->wp_analytify->settings->get_option( 'analytiy_custom_dimensions', 'wp-analytify-custom-dimensions' );
			$authors_dimension = '';
			$author_dimension  = false;

			foreach ( $set_dimensions as $dimension ) {
				if ( 'author' === $dimension['type'] ) {
					$author_dimension = 'ga:dimension' . $dimension['id'];
					break;
				}
			}

			if ( ! $author_dimension ) {
				return array();
			}

			if ( '0' != $id ) {
				$dimension_filer = $author_dimension . '==' . $wp_user->user_login;
			} else {
				$dimension_filer = '';
			}

			$stats_raw = $this->wp_analytify->pa_get_analytics_dashboard(
				'ga:sessions,ga:pageviews,ga:users,ga:avgTimeOnPage,ga:bounceRate',
				$this->start_date,
				$this->end_date,
				$author_dimension . ',ga:PageTitle,ga:pagePath',
				'-ga:pageviews',
				$dimension_filer,
				$api_limit,
				''
			);
			if ( isset( $stats_raw['rows'] ) && $stats_raw['rows'] ) {
				foreach ( $stats_raw['rows'] as $row ) {
					$stats[] = array(
						'0' => $row[0],
						'1' => $row[1],
						'2' => $row[2],
						'3' => WPANALYTIFY_Utils::pretty_numbers( $row[3] ),
						'4' => WPANALYTIFY_Utils::pretty_numbers( $row[4] ),
						'5' => WPANALYTIFY_Utils::pretty_numbers( $row[5] ),
						'6' => strip_tags( WPANALYTIFY_Utils::pretty_time( $row[6] ) ),
						'7' => WPANALYTIFY_Utils::pretty_numbers( $row[7] ) . '%',
					);
				}
			}
		}

		$columns = array(
			array(
				'0' => esc_html__( 'Author', 'wp-analytify-pro' ),
				'1' => esc_html__( 'Post Title', 'wp-analytify-pro' ),
				'2' => esc_html__( 'Post Link', 'wp-analytify-pro' ),
				'3' => esc_html__( 'Sessions', 'wp-analytify-pro' ),
				'4' => esc_html__( 'Page Views', 'wp-analytify-pro' ),
				'5' => esc_html__( 'Visitors', 'wp-analytify-pro' ),
				'6' => esc_html__( 'Avg. Time', 'wp-analytify-pro' ),
				'7' => esc_html__( 'Bounce Rate', 'wp-analytify-pro' ),
			),
		);
		return array_merge( $columns, $stats );
	}

	/**
	 * WC's Top Sales Countries
	 *
	 * @return array
	 */
	private function export_top_sales_countries() {

		$api_limit = apply_filters( 'analytify_api_limit_sales_countries', 50, 'csv_export', 'WC' );

		$stats = array();

		if ( 'ga4' === $this->ga_mode ) {

			$stats_raw = $this->wp_analytify->get_reports(
				'show-woo-geographical-stats',
				array(
					'itemPurchaseQuantity',
					'purchaseRevenue',
				),
				$this->get_dates(),
				array(
					'country',
				),
				array(
					'type'  => 'metric',
					'name'  => 'itemPurchaseQuantity',
					'order' => 'desc',
				),
				array(
					'logic'   => 'AND',
					'filters' => array(
						array(
							'type'           => 'dimension',
							'name'           => 'country',
							'match_type'     => 4,
							'value'          => '(not set)',
							'not_expression' => true,
						),
					),
				),
				$api_limit
			);

			if ( isset( $stats_raw['rows'] ) && $stats_raw['rows'] ) {
				foreach ( $stats_raw['rows'] as $row ) {
					$stats[] = array(
						'0' => $row['country'],
						'1' => $row['itemPurchaseQuantity'],
						'2' => $row['purchaseRevenue'],
					);
				}
			}
		} else {

			$geographic_filter = apply_filters( 'analytify_enhanced_geographic_filter', 'ga:country!=(not set);ga:itemQuantity>0' );

			$stats_raw = $this->wp_analytify->pa_get_analytics_dashboard( 'ga:itemQuantity,ga:transactionRevenue', $this->start_date, $this->end_date, 'ga:country', '-ga:itemQuantity', $geographic_filter, $api_limit, 'show-woo-geographical-stats' );

			if ( isset( $stats_raw['rows'] ) && $stats_raw['rows'] ) {
				foreach ( $stats_raw['rows'] as $row ) {
					$stats[] = array(
						'0' => $row[0],
						'1' => $row[1],
						'2' => $row[2],
					);
				}
			}
		}

		$columns = array(
			array(
				'0' => esc_html__( 'Country', 'wp-analytify-pro' ),
				'1' => esc_html__( 'No. of Sales', 'wp-analytify-pro' ),
				'2' => esc_html__( 'Revenue', 'wp-analytify-pro' ),
			),
		);
		return array_merge( $columns, $stats );
	}

	/**
	 * WC's Measuring ROI
	 *
	 * @return array
	 */
	private function export_measuring_roi() {

		$api_limit = apply_filters( 'analytify_api_limit_measuring_roi', 50, 'csv_export', 'WC' );

		$stats = array();

		if ( 'ga4' === $this->ga_mode ) {
			$stats_raw = $this->wp_analytify->get_reports(
				'show-woo-roi-stats',
				array(
					'sessions',
					'bounceRate',
					'transactions',
					'purchaseRevenue',
				),
				$this->get_dates(),
				array(
					'sourceMedium',
				),
				array(
					'type'  => 'metric',
					'name'  => 'purchaseRevenue',
					'order' => 'desc',
				),
				array(),
				$api_limit
			);

			if ( isset( $stats_raw['rows'] ) && $stats_raw['rows'] ) {
				$k = 0;
				foreach ( $stats_raw['rows'] as $row ) {
					$k++;
					$stats[] = array(
						'0' => $k,
						'1' => $row['sourceMedium'],
						'2' => WPANALYTIFY_Utils::pretty_numbers( $row['sessions'] ),
						'3' => WPANALYTIFY_Utils::pretty_numbers( $row['bounceRate'] ) . '%',
						'4' => $row['transactions'],
						'5' => $this->wc_currency_symbol() . number_format( $row['purchaseRevenue'], 2 ),
					);
				}
			}
		} else {
			$roi_filter = apply_filters( 'analytify_enhanced_roi_filter', 'ga:transactionRevenue>0' );

			$stats_raw = $this->wp_analytify->pa_get_analytics_dashboard( 'ga:sessions,ga:bounceRate,ga:transactions,ga:transactionRevenue', $this->start_date, $this->end_date, 'ga:sourceMedium', '-ga:transactionRevenue', $roi_filter, $api_limit, 'show-woo-roi-stats' );

			if ( isset( $stats_raw['rows'] ) && $stats_raw['rows'] ) {
				$k = 0;
				foreach ( $stats_raw['rows'] as $row ) {
					$k++;
					$stats[] = array(
						'0' => $k,
						'1' => $row[0],
						'2' => WPANALYTIFY_Utils::pretty_numbers( $row[1] ),
						'3' => WPANALYTIFY_Utils::pretty_numbers( $row[2] ) . '%',
						'4' => $row[3],
						'5' => $this->wc_currency_symbol() . number_format( $row[4], 2 ),
					);
				}
			}
		}

		$columns = array(
			array(
				'0' => esc_html__( 'No.', 'wp-analytify-pro' ),
				'1' => esc_html__( 'Source/Medium', 'wp-analytify-pro' ),
				'2' => esc_html__( 'Session', 'wp-analytify-pro' ),
				'3' => esc_html__( 'Bounce Rate', 'wp-analytify-pro' ),
				'4' => esc_html__( 'Transactions', 'wp-analytify-pro' ),
				'5' => esc_html__( 'Transactions Revenue', 'wp-analytify-pro' ),
			),
		);
		return array_merge( $columns, $stats );
	}

	/**
	 * Export WC's product performance.
	 *
	 * @return array
	 */
	private function export_products_performance() {

		$api_limit = apply_filters( 'analytify_api_limit_products_performance', 50, 'csv_export', 'WC' );

		$stats = array();

		if ( 'ga4' === $this->ga_mode ) {
			$stats_raw = $this->wp_analytify->get_reports(
				'show-woo-product-performance-stats',
				array(
					'itemRevenue',
					'ecommercePurchases',
					'itemPurchaseQuantity',
					'cartToViewRate',
					// TODO: (missing_ga4) 'buyToDetailRate'
				),
				$this->get_dates(),
				array(
					'itemName',
				),
				array(
					'type'  => 'metric',
					'name'  => 'itemPurchaseQuantity',
					'order' => 'desc',
				),
				array(
					'logic'   => 'AND',
					'filters' => array(
						array(
							'type'           => 'dimension',
							'name'           => 'itemName',
							'match_type'     => 4,
							'value'          => '(not set)',
							'not_expression' => true,
						),
					),
				),
				$api_limit
			);

			if ( isset( $stats_raw['rows'] ) && $stats_raw['rows'] ) {
				foreach ( $stats_raw['rows'] as $row ) {
					$stats[] = array(
						'0' => $row['itemName'],
						'1' => $this->wc_currency_symbol() . number_format( $row['itemRevenue'], 2 ),
						'2' => $row['ecommercePurchases'],
						'3' => $row['itemPurchaseQuantity'],
						'4' => number_format( $row['cartToViewRate'], 2 ) . '%',
						'5' => '',
					);
				}
			}
		} else {
			$stats_raw = $this->wp_analytify->pa_get_analytics_dashboard( 'ga:itemRevenue,ga:uniquePurchases,ga:itemQuantity,ga:cartToDetailRate,ga:buyToDetailRate', $this->start_date, $this->end_date, 'ga:productName', '-ga:itemRevenue', 'ga:productName!=(not set)', $api_limit, 'show-woo-product-performance-stats' );

			if ( isset( $stats_raw['rows'] ) && $stats_raw['rows'] ) {
				foreach ( $stats_raw['rows'] as $row ) {
					$stats[] = array(
						'0' => $row[0],
						'1' => $this->wc_currency_symbol() . number_format( $row[1], 2 ),
						'2' => $row[2],
						'3' => $row[3],
						'4' => number_format( $row[4], 2 ).'%',
						'5' => number_format( $row[5], 2 ).'%',
					);
				}
			}
		}

		$columns = array(
			array(
				'0' => esc_html__( 'Name', 'wp-analytify-pro' ),
				'1' => esc_html__( 'Product Revenue', 'wp-analytify-pro' ),
				'2' => esc_html__( 'Unique Purchases', 'wp-analytify-pro' ),
				'3' => esc_html__( 'Quantity', 'wp-analytify-pro' ),
				'4' => esc_html__( 'Cart-to-Detail Rate', 'wp-analytify-pro' ),
				'5' => esc_html__( 'Buy-to-Detail Rate', 'wp-analytify-pro' ),
			),
		);
		return array_merge( $columns, $stats );
	}

	/**
	 * Export WC's product list.
	 *
	 * @return array
	 */
	private function export_product_lists_analysis() {

		$api_limit = apply_filters( 'analytify_api_limit_product_lists_analysis', 50, 'csv_export', 'WC' );

		$stats = array();

		if ( 'ga4' === $this->ga_mode ) {
			$stats_raw = $this->wp_analytify->get_reports(
				'show-woo-product-list-stats',
				array(
					'itemListViews',
					'itemListClicks',
					'itemListClickThroughRate',
					'addToCarts',
					'checkouts',
					'ecommercePurchases',
					'itemRevenue',
				),
				$this->get_dates(),
				array(
					'productListName',
				),
				array(
					'type'  => 'metric',
					'name'  => 'itemRevenue',
					'order' => 'desc',
				),
				array(
					'logic'   => 'AND',
					'filters' => array(
						array(
							'type'           => 'dimension',
							'name'           => 'productListName',
							'match_type'     => 4,
							'value'          => '(not set)',
							'not_expression' => true,
						),
					),
				),
				$api_limit
			);

			if ( isset( $stats_raw['rows'] ) && $stats_raw['rows'] ) {
				$k = 0;
				foreach ( $stats_raw['rows'] as $row ) {
					$k++;
					$stats[] = array(
						'0' => $k,
						'1' => $row['productListName'],
						'2' => $row['itemListViews'],
						'3' => $row['itemListClicks'],
						'4' => number_format( $row['itemListClickThroughRate'], 2 ) . '%',
						'5' => $row['addToCarts'],
						'6' => $row['checkouts'],
						'7' => $row['ecommercePurchases'],
						'8' => $this->wc_currency_symbol() . number_format( $row['itemRevenue'], 2 ),
					);
				}
			}
		} else {
			$stats_raw = $this->wp_analytify->pa_get_analytics_dashboard( 'ga:productListViews,ga:productListClicks,ga:productListCTR,ga:productAddsToCart,ga:productCheckouts,ga:uniquePurchases,ga:itemRevenue', $this->start_date, $this->end_date, 'ga:productListName', '-ga:itemRevenue', 'ga:productListName!=(not set)', $api_limit, 'show-woo-product-list-stats' );

			if ( isset( $stats_raw['rows'] ) && $stats_raw['rows'] ) {
				$k = 0;
				foreach ( $stats_raw['rows'] as $row ) {
					$k++;
					$stats[] = array(
						'0' => $k,
						'1' => $row[0],
						'2' => $row[1],
						'3' => $row[2],
						'4' => number_format( $row[3], 2 ) . '%',
						'5' => $row[4],
						'6' => $row[5],
						'7' => $row[6],
						'8' => $this->wc_currency_symbol() . number_format( $row[7], 2 ),
					);
				}
			}
		}

		$columns = array(
			array(
				'0' => esc_html__( 'No.', 'wp-analytify-pro' ),
				'1' => esc_html__( 'List Name', 'wp-analytify-pro' ),
				'2' => esc_html__( 'Product List Views', 'wp-analytify-pro' ),
				'3' => esc_html__( 'Product List Clicks', 'wp-analytify-pro' ),
				'4' => esc_html__( 'Product List CTR', 'wp-analytify-pro' ),
				'5' => esc_html__( 'Product Adds to Cart', 'wp-analytify-pro' ),
				'6' => esc_html__( 'Product Checkouts', 'wp-analytify-pro' ),
				'7' => esc_html__( 'Unique Purchases', 'wp-analytify-pro' ),
				'8' => esc_html__( 'Product Revenue', 'wp-analytify-pro' ),
			),
		);
		return array_merge( $columns, $stats );
	}

	/**
	 * WC's product categories export.
	 *
	 * @return array
	 */
	private function export_product_categories() {

		$api_limit = apply_filters( 'analytify_api_limit_product_categories', 50, 'csv_export', 'WC' );

		$stats = array();

		if ( 'ga4' === $this->ga_mode ) {
			$stats_raw = $this->wp_analytify->get_reports(
				'show-woo-categories-performance-stats',
				array(
					'itemRevenue',
					'ecommercePurchases',
					'itemPurchaseQuantity',
					'cartToViewRate',
					// TODO: (missing_ga4) buyToDetailRate
				),
				$this->get_dates(),
				array(
					'itemCategory',
				),
				array(
					'type'  => 'metric',
					'name'  => 'itemPurchaseQuantity',
					'order' => 'desc',
				),
				array(
					'logic'   => 'AND',
					'filters' => array(
						array(
							'type'           => 'dimension',
							'name'           => 'itemCategory',
							'match_type'     => 4,
							'value'          => '(not set)',
							'not_expression' => true,
						),
					),
				),
				$api_limit
			);

			if ( isset( $stats_raw['rows'] ) && $stats_raw['rows'] ) {
				$k = 0;
				foreach ( $stats_raw['rows'] as $row ) {
					$k++;
					$stats[] = array(
						'0' => $k,
						'1' => $row['itemCategory'],
						'2' => $this->wc_currency_symbol() .  number_format( $row['itemRevenue'], 2 ),
						'3' => $row['ecommercePurchases'],
						'4' => $row['itemPurchaseQuantity'],
						'5' => number_format( $row['cartToViewRate'], 2 ) . '%',
						'6' => '',
					);
				}
			}
		} else {
			$stats_raw = $this->wp_analytify->pa_get_analytics_dashboard( 'ga:itemRevenue,ga:uniquePurchases,ga:itemQuantity,ga:cartToDetailRate,ga:buyToDetailRate', $this->start_date, $this->end_date, 'ga:productCategoryHierarchy', '-ga:itemQuantity', 'ga:productCategoryHierarchy!=(not set)', $api_limit, 'pa_get_analytics_dashboard' );

			if ( isset( $stats_raw['rows'] ) && $stats_raw['rows'] ) {
				$k = 0;
				foreach ( $stats_raw['rows'] as $row ) {
					$k++;
					$stats[] = array(
						'0' => $k,
						'1' => $row[0],
						'2' => $this->wc_currency_symbol() .  number_format( $row[1], 2 ),
						'3' => $row[2],
						'4' => $row[3],
						'5' => number_format( $row[4], 2 ) . '%',
						'6' => number_format( $row[5], 2 ) . '%',
					);
				}
			}
		}

		$columns = array(
			array(
				'0' => esc_html__( 'No.', 'wp-analytify-pro' ),
				'1' => esc_html__( 'Name', 'wp-analytify-pro' ),
				'2' => esc_html__( 'Product Revenue', 'wp-analytify-pro' ),
				'3' => esc_html__( 'Unique Purchases', 'wp-analytify-pro' ),
				'4' => esc_html__( 'Quantity', 'wp-analytify-pro' ),
				'5' => esc_html__( 'Cart-to-Detail Rate', 'wp-analytify-pro' ),
				'6' => esc_html__( 'Buy-to-Detail Rate', 'wp-analytify-pro' ),
			),
		);
		return array_merge( $columns, $stats );
	}

	/**
	 * WC's coupons analysis export.
	 *
	 * @return array
	 */
	private function export_coupons_analysis() {

		$api_limit = apply_filters( 'analytify_api_limit_coupons_analysis', 50, 'csv_export', 'WC' );

		$stats = array();

		if ( 'ga4' === $this->ga_mode ) {
			$stats_raw = $this->wp_analytify->get_reports(
				'show-woo-coupons-analysis-stats',
				array(
					'purchaseRevenue',
					'transactions',
					// TODO: (missing_ga4) 'revenuePerTransaction',
				),
				$this->get_dates(),
				array(
					'orderCoupon',
				),
				array(
					'type'  => 'dimension',
					'name'  => 'orderCoupon',
					'order' => 'desc',
				),
				array(
					'logic'   => 'AND',
					'filters' => array(
						array(
							'type'           => 'dimension',
							'name'           => 'orderCoupon',
							'match_type'     => 4,
							'value'          => '(not set)',
							'not_expression' => true,
						),
					),
				),
				$api_limit
			);

			if ( isset( $stats_raw['rows'] ) && $stats_raw['rows'] ) {
				$k = 0;
				foreach ( $stats_raw['rows'] as $row ) {
					$k++;
					$stats[] = array(
						'0' => $k,
						'1' => $row['orderCoupon'],
						'2' => $this->wc_currency_symbol() . number_format( $row['purchaseRevenue'], 2 ),
						'3' => $row['transactions'],
						'4' => '',
					);
				}
			}
		} else {

			$coupon_filter = apply_filters( 'analytify_enhanced_coupon_filter', 'ga:orderCouponCode!=(not set)' );

			$stats_raw = $this->wp_analytify->pa_get_analytics_dashboard( 'ga:transactionRevenue,ga:transactions,ga:revenuePerTransaction', $this->start_date, $this->end_date, 'ga:orderCouponCode', '-ga:orderCouponCode', $coupon_filter, $api_limit, 'show-woo-coupons-analysis-stats' );

			if ( isset( $stats_raw['rows'] ) && $stats_raw['rows'] ) {
				$k = 0;
				foreach ( $stats_raw['rows'] as $row ) {
					$k++;
					$stats[] = array(
						'0' => $k,
						'1' => $row[0],
						'2' => $this->wc_currency_symbol() . number_format( $row[1], 2 ),
						'3' => $row[2],
						'4' => $this->wc_currency_symbol() . number_format( $row[3], 2 ),
					);
				}
			}
		}

		$columns = array(
			array(
				'0' => esc_html__( 'No.', 'wp-analytify-pro' ),
				'1' => esc_html__( 'Coupon Code', 'wp-analytify-pro' ),
				'2' => esc_html__( 'Revenue', 'wp-analytify-pro' ),
				'3' => esc_html__( 'Transactions', 'wp-analytify-pro' ),
				'4' => esc_html__( 'Average Order Value', 'wp-analytify-pro' ),
			),
		);
		return array_merge( $columns, $stats );
	}

	/**
	 * Calculates compare start and end date, also returns the difference in days.
	 *
	 * Note: a similar method exists in Core (WPANALYTIFY_Utils::calculate_date_diff),
	 * this was created for legacy support.
	 *
	 * @param array $date Start and end dates.
	 *
	 * @return array|false
	 */
	private function calculate_date_diff( $date ) {

		if ( is_null( $date ) ) {
			$start_date = $this->start_date;
			$end_date   = $this->end_date;
		} else {
			$start_date = $date['start'];
			$end_date   = $date['end'];
		}

		if ( $start_date === $end_date ) {
			return false;
		}

		$diff               = date_diff( date_create( $end_date ), date_create( $start_date ) );
		$compare_start_date = wp_date( 'Y-m-d', strtotime( $start_date . $diff->format( ' %R%a days' ) ) );
		$compare_end_date   = $start_date;
		$diff_days          = $diff->format( '%a' );

		return array(
			'start_date' => $compare_start_date,
			'end_date'   => $compare_end_date,
			'diff_days'  => (string) $diff_days,
		);
	}

	/**
	 * Get profile related data based on the key (option) provided.
	 *
	 * @param string $key Option name.
	 * @return string|null
	 */
	private function get_profile_info( $key ) {
		$dashboard_profile_id = $this->wp_analytify->settings->get_option( 'profile_for_dashboard', 'wp-analytify-profile' );
		switch ( $key ) {
			case 'profile_id':
				return $dashboard_profile_id;
			case 'website_url':
				return WP_ANALYTIFY_FUNCTIONS::search_profile_info( $dashboard_profile_id, 'websiteUrl' );
			default:
				return null;
		}
	}

	/**
	 * Returns start and end date as an array to be used for GA4's get_reports()
	 *
	 * @return array
	 */
	private function get_dates() {
		return array(
			'start' => $this->start_date,
			'end'   => $this->end_date,
		);
	}

	/**
	 * Returns WC currency symbol.
	 *
	 * @return string
	 */
	private function wc_currency_symbol() {

		if ( is_null( $this->wc_currency_symbol ) ) {
			$this->wc_currency_symbol = function_exists( 'get_woocommerce_currency_symbol' ) ? html_entity_decode( get_woocommerce_currency_symbol(), ENT_QUOTES, 'utf-8') : '';
		}
		return $this->wc_currency_symbol;
	}
}
