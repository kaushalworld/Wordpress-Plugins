<?php
/**
 * Handle Analytify REST end points
 */
class Analytify_Pro_Rest_API {

	/**
	 * The single instance of the class.
	 *
	 * @var object
	 */
	private static $instance;

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
	 * Set 'date differ'.
	 *
	 * @var string
	 */
	private $date_differ;

	/**
	 * Set compare 'start state'.
	 *
	 * @var string
	 */
	private $compare_start_date = NULL;

	/**
	 * Set compare 'End state'.
	 *
	 * @var string
	 */
	private $compare_end_date = NULL;

	/**
	 * Set compare number of days.
	 *
	 * @var string
	 */
	private $compare_days = NULL;

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
	 * @return void
	 */
	private function __construct() {

		// Register API endpoints.
		add_action( 'rest_api_init', array( $this, 'rest_api_init' ) );

		// Filters raw events tracking stats and splits them into separate arrays for each event type.
		add_filter( 'analytify_events_tracking_raw_stats', array( $this, 'filter_events_tracking_raw_stats' ), 10, 2 );

		// Filters row label depending on the the dimension type.
		add_filter( 'analytify_custom_dimension_row_label', array( $this, 'filter_custom_dimension_row_label' ), 10, 2 );
	}

	/**
	 * Register end point.
	 *
	 * @return void
	 */
	public function rest_api_init() {

		$this->wp_analytify = $GLOBALS['WP_ANALYTIFY'];
		$this->ga_mode      = method_exists( 'WPANALYTIFY_Utils', 'get_ga_mode' ) ? WPANALYTIFY_Utils::get_ga_mode() : 'ga3';

		register_rest_route(
			'wp-analytify/v1',
			'/get_pro_report/(?P<request_type>[a-zA-Z0-9-]+)',
			array(
				array(
					'methods'             => WP_REST_Server::READABLE, // Get Request.
					'callback'            => array( $this, 'handle_request' ),
					'permission_callback' => array( $this, 'permission_check' ),
				),
			)
		);
	}

	/**
	 * Checks access permission.
	 * Checks if the user is logged-in and checks of the user role has access.
	 *
	 * @return boolean
	 */
	public function permission_check() {
		$is_access_level = $this->wp_analytify->settings->get_option( 'show_analytics_roles_dashboard', 'wp-analytify-dashboard', array( 'Administrator' ) );
		return (bool) $this->wp_analytify->pa_check_roles( $is_access_level );
	}

	/**
	 * Handles the request.
	 *
	 * @param WP_REST_Request $request WP REST request object.
	 *
	 * @return array|WP_Error
	 */
	public function handle_request( WP_REST_Request $request ) {

		$request_type = $request->get_param( 'request_type' );

		$this->start_date  = $request->get_param( 'sd' );
		$this->end_date    = $request->get_param( 'ed' );
		$this->date_differ = $request->get_param( 'd_diff' );
		$this->type        = $request->get_param( 'type' );

		switch ( $request_type ) {
			case 'ajax-error':
				return $this->ajax_error();
			case '404-error':
				return $this->not_found_error();
			case 'js-error':
				return $this->js_error();
			case 'events-tracking':
				return $this->events_tracking();
			case 'custom-dimensions':
				return $this->custom_dimensions();
			case 'search-terms':
				return $this->search_terms();
			case 'demographics':
				return $this->demographics();
			case 'real-time':
				return $this->real_time();

			// TODO: fix these. It should return json only, no markup.
			
			case 'compare-stats':
				return $this->compare_stats();
		}

		// If no request type match, Return error.
		return new WP_Error( 'analytify_invalid_endpoint', __( 'Invalid endpoint.', 'wp-analytify-pro' ), array( 'status' => 404 ) );
	}

	/**
	 * Endpoint for 'Top ajax errors'.
	 *
	 * @return array
	 */
	private function ajax_error() {

		// API limit.
		$api_limit = apply_filters( 'analytify_api_limit_ajax_error_stats', 5, 'dashboard' );

		$stats = array();

		if ( 'ga4' === $this->ga_mode ) {
			$stats_raw = $this->wp_analytify->get_reports(
				'show-top-ajax-errors',
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
							'value'      => 'Ajax Error',
						),
					),
				),
				$api_limit
			);

			if ( isset( $stats_raw['rows'] ) && ! empty( $stats_raw['rows'] ) ) {
				foreach ( $stats_raw['rows'] as $row ) {
					$stats[] = array(
						'no'   => null,
						'url'  => $row['customEvent:wpa_label'],
						'hits' => WPANALYTIFY_Utils::pretty_numbers( $row['eventCount'] ),
					);
				}
			}
		} else {

			$stats_raw = $this->wp_analytify->pa_get_analytics_dashboard( 'ga:totalEvents', $this->start_date, $this->end_date, 'ga:eventAction,ga:eventLabel', '-ga:totalEvents', 'ga:eventCategory==Ajax Error', $api_limit, 'show-top-ajax-errors' );

			if ( isset( $stats_raw['rows'] ) && ! empty( $stats_raw['rows'] ) ) {
				foreach ( $stats_raw['rows'] as $row ) {
					$stats[] = array(
						'no'   => null,
						'url'  => $row[1],
						'hits' => WPANALYTIFY_Utils::pretty_numbers( $row[2] ),
					);
				}
			}
		}

		return array(
			'success' => true,
			'headers' => array(
				'no'  => array(
					'label'    => esc_html__( '#', 'wp-analytify-pro' ),
					'type'     => 'counter',
					'th_class' => 'analytify_num_row',
					'td_class' => 'analytify_txt_center',
				),
				'url' => array(
					'label'    => esc_html__( 'URL', 'wp-analytify-pro' ),
					'th_class' => 'analytify_txt_left',
					'td_class' => '',
				),
				'hits' => array(
					'label'    => esc_html__( 'Hits', 'wp-analytify-pro' ),
					'th_class' => 'analytify_value_row',
					'td_class' => 'analytify_txt_center',
				),
			),
			'stats'   => $stats,
			'footer'  => apply_filters( 'analytify_ajax_error_footer', __( 'Ajax errors.', 'wp-analytify-pro' ), array( $this->start_date, $this->end_date ) ),
		);
	}

	/**
	 * Endpoint for 'Top 404 pages'.
	 *
	 * @return array
	 */
	private function not_found_error() {

		// API limit.
		$api_limit = apply_filters( 'analytify_api_limit_404_error_stats', 5, 'dashboard' );

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
				$api_limit
			);

			if ( isset( $stats_raw['rows'] ) && ! empty( $stats_raw['rows'] ) ) {
				foreach ( $stats_raw['rows'] as $row ) {
					$stats[] = array(
						'no'   => null,
						'url'  => $row['customEvent:wpa_label'],
						'hits' => WPANALYTIFY_Utils::pretty_numbers( $row['eventCount'] ),
					);
				}
			}
		} else {
			$stats_raw = $this->wp_analytify->pa_get_analytics_dashboard( 'ga:totalEvents', $this->start_date, $this->end_date, 'ga:eventAction,ga:eventLabel', '-ga:totalEvents', 'ga:eventCategory==404 Error', $api_limit, 'show-top-404-pages' );

			if ( isset( $stats_raw['rows'] ) && ! empty( $stats_raw['rows'] ) ) {
				foreach ( $stats_raw['rows'] as $row ) {
					$stats[] = array(
						'no'   => null,
						'url'  => $row[1],
						'hits' => WPANALYTIFY_Utils::pretty_numbers( $row[2] ),
					);
				}
			}
		}

		return array(
			'success' => true,
			'headers' => array(
				'no'  => array(
					'label'    => esc_html__( '#', 'wp-analytify-pro' ),
					'type'     => 'counter',
					'th_class' => 'analytify_num_row',
					'td_class' => 'analytify_txt_center',
				),
				'url' => array(
					'label'    => esc_html__( 'URL', 'wp-analytify-pro' ),
					'th_class' => 'analytify_txt_left',
					'td_class' => '',
				),
				'hits' => array(
					'label'    => esc_html__( 'Hits', 'wp-analytify-pro' ),
					'th_class' => 'analytify_value_row',
					'td_class' => 'analytify_txt_center',
				),
			),
			'stats'   => $stats,
			'footer'  => apply_filters( 'analytify_404_error_footer', __( '404 errors.', 'wp-analytify-pro' ), array( $this->start_date, $this->end_date ) ),
		);
	}

	/**
	 * Endpoint for 'Top JS errors'.
	 *
	 * @return array
	 */
	private function js_error() {

		// API limit.
		$api_limit = apply_filters( 'analytify_api_limit_js_error_stats', 5, 'dashboard' );

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
				$api_limit
			);

			if ( isset( $stats_raw['rows'] ) && ! empty( $stats_raw['rows'] ) ) {
				foreach ( $stats_raw['rows'] as $row ) {
					$stats[] = array(
						'no'    => null,
						'error' => $row['customEvent:wpa_action'],
						'url'   => $row['customEvent:wpa_label'],
						'hits'   => WPANALYTIFY_Utils::pretty_numbers( $row['eventCount'] ),
					);
				}
			}
		} else {
			$stats_raw = $this->wp_analytify->pa_get_analytics_dashboard( 'ga:totalEvents', $this->start_date, $this->end_date, 'ga:eventAction,ga:eventLabel', '-ga:totalEvents', 'ga:eventCategory==JavaScript Error', $api_limit, 'show-top-js-errors' );

			if ( isset( $stats_raw['rows'] ) && ! empty( $stats_raw['rows'] ) ) {
				foreach ( $stats_raw['rows'] as $row ) {
					$stats[] = array(
						'no'    => null,
						'error' => $row[0],
						'url'   => $row[1],
						'hits'  => WPANALYTIFY_Utils::pretty_numbers( $row[2] ),
					);
				}
			}
		}

		return array(
			'success' => true,
			'headers' => array(
				'no'  => array(
					'label'    => esc_html__( '#', 'wp-analytify-pro' ),
					'type'     => 'counter',
					'th_class' => 'analytify_num_row',
					'td_class' => 'analytify_txt_center',
				),
				'error' => array(
					'label'    => esc_html__( 'Error', 'wp-analytify-pro' ),
					'th_class' => 'analytify_txt_left',
					'td_class' => '',
				),
				'url' => array(
					'label'    => esc_html__( 'URL', 'wp-analytify-pro' ),
					'th_class' => 'analytify_txt_left',
					'td_class' => '',
				),
				'hits' => array(
					'label'    => esc_html__( 'Hits', 'wp-analytify-pro' ),
					'th_class' => 'analytify_value_row',
					'td_class' => 'analytify_txt_center',
				),
			),
			'stats'   => $stats,
			'footer'  => apply_filters( 'analytify_404_error_footer', __( 'JavaScript errors.', 'wp-analytify-pro' ), array( $this->start_date, $this->end_date ) ),
		);
	}

	/**
	 * Generates the 'visitor/views' graph on the main dashboard
	 *
	 * TODO: fix this.
	 * @return string
	 */
	private function compare_stats() {

		$this_month_start_date = $this->start_date;
		$this_month_end_date   = $this->end_date;

		$this_year_start_date = $this->start_date;
		$this_year_end_data   = $this->end_date;

		$previous_year_start_date = date( 'Y-m-d', strtotime( $this->start_date . ' -1 year' ) );
		$previous_year_end_date   = date( 'Y-m-d', strtotime( $this->end_date . ' -1 year' ) );

		$date1 = date_create( $this_year_start_date );
		$date2 = date_create( $this_year_end_data );
		$diff  = date_diff( $date2, $date1 );

		$previous_month_start_date = date( 'Y-m-d', strtotime( $this->start_date . ' -1 month' ) );
		$previous_month_end_date   = date( 'Y-m-d', strtotime( $this->end_date . ' -1 month' ) );

		$is_three_month = false;

		// $view_data = $this->view_data

		if ( 'ga4' === $this->ga_mode ) {

			$year_dimensions = array( 'year', 'month' );

			/**
			 * Get 'users' and 'views' for this month, previous month, this year and previous year.
			 * 
			 */

			$this_month_stats = $this->wp_analytify->get_reports(
				'show-this-month-stats',
				array(
					'totalUsers',
					'screenPageViews',
				),
				array(
					'start' => $this_month_start_date,
					'end'   => $this_month_end_date,
				),
				array(
					'date',
				),
				array(
					'type' => 'dimension',
					'name' => 'date',
				),
				array(),
				1000,
			);

			$previous_month_stats = $this->wp_analytify->get_reports(
				'show-previous-month-stats',
				array(
					'totalUsers',
					'screenPageViews',
				),
				array(
					'start' => $previous_month_start_date,
					'end'   => $previous_month_end_date,
				),
				array(
					'date',
				),
				array(
					'type' => 'dimension',
					'name' => 'date',
				),
				array(),
				1000,
			);

			// If difference less than 3 months, get data on date base.
			if ( $diff->format( '%a' ) < 90 ) {
				$year_dimensions = array( 'date' );
				$is_three_month = true;
			}

			$this_year_stats = $this->wp_analytify->get_reports(
				'show-this-year-stats',
				array(
					'totalUsers',
					'screenPageViews',
				),
				array(
					'start' => $this_year_start_date,
					'end'   => $this_year_end_data,
				),
				$year_dimensions,
				array(
					'type' => 'dimension',
					'name' => 'date',
				),
				array(),
				1000,
			);

			$previous_year_stats = $this->wp_analytify->get_reports(
				'show-previous-year-stats',
				array(
					'totalUsers',
					'screenPageViews',
				),
				array(
					'start' => $previous_year_start_date,
					'end'   => $previous_year_end_date,
				),
				$year_dimensions,
				array(
					'type' => 'dimension',
					'name' => 'date',
				),
				array(),
				1000,
			);

			include ANALYTIFY_PRO_ROOT_PATH . '/views/default/admin/main-comparison-stats.php';
			return fetch_visitors_views_comparison( $this->wp_analytify, $this_month_stats, $previous_month_stats, $this_year_stats, $previous_year_stats, $is_three_month, $this_month_start_date, $this_month_end_date, $previous_month_start_date, $previous_month_end_date, $this_year_start_date, $this_year_end_data, $previous_year_start_date, $previous_year_end_date );

		} else {

			$dashboard_profile_ID = $this->wp_analytify->settings->get_option( 'profile_for_dashboard', 'wp-analytify-profile' );
			$year_dimensions      = 'ga:yearMonth';

			// If difference less than 3 months, get data on date base.
			if ( $diff->format( '%a' ) < 90 ) {
				$year_dimensions = 'ga:date';
				$is_three_month  = true;
			}

			$this_month_stats = $this->wp_analytify->pa_get_analytics_dashboard( 'ga:users,ga:pageviews', $this_month_start_date, $this_month_end_date, 'ga:date', false, false, 1000, 'show-this-month-stats' );

			$previous_month_stats = $this->wp_analytify->pa_get_analytics_dashboard( 'ga:users,ga:pageviews', $previous_month_start_date, $previous_month_end_date, 'ga:date', false, false, 1000, 'show-previous-month-stats' );

			$this_year_stats = $this->wp_analytify->pa_get_analytics_dashboard( 'ga:users,ga:pageviews', $this_year_start_date, $this_year_end_data, $year_dimensions, false, false, 10000, 'show-this-year-stats' );

			$previous_year_stats = $this->wp_analytify->pa_get_analytics_dashboard( 'ga:users,ga:pageviews', $previous_year_start_date, $previous_year_end_date, $year_dimensions, false, false, 10000, 'show-previous-year-stats' );

			if ( isset( $this_month_stats['rows'] ) ) {
				include ANALYTIFY_PRO_ROOT_PATH . '/views/default/admin/main-comparison-stats-deprecated.php';
				return fetch_visitors_views_comparison( $this->wp_analytify, $this_month_stats, $previous_month_stats, $this_year_stats, $previous_year_stats, $is_three_month, $this_month_start_date, $this_month_end_date, $previous_month_start_date, $previous_month_end_date, $this_year_start_date, $this_year_end_data, $previous_year_start_date, $previous_year_end_date );
			}
		}
	}

	/**
	 * Endpoint for 'Events Tracking' (module).
	 *
	 * @return array
	 */
	private function events_tracking() {

		// API limit.
		$api_limit = apply_filters( 'analytify_api_limit_events_tracking_stats', 200, 'dashboard' );

		$stats_external = array();
		$stats_download = array();
		$stats_tel      = array();
		$stats_outbound = array();
		$stats_mail     = array();

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
					'logic'   => 'OR',
					'filters' => array(
						array(
							'type'       => 'dimension',
							'name'       => 'customEvent:wpa_category',
							'match_type' => '1',
							'value'      => 'external',
						),
						array(
							'type'       => 'dimension',
							'name'       => 'customEvent:wpa_category',
							'match_type' => '1',
							'value'      => 'download',
						),
						array(
							'type'       => 'dimension',
							'name'       => 'customEvent:wpa_category',
							'match_type' => '1',
							'value'      => 'tel',
						),
						array(
							'type'       => 'dimension',
							'name'       => 'customEvent:wpa_category',
							'match_type' => '1',
							'value'      => 'outbound-link',
						),
						array(
							'type'       => 'dimension',
							'name'       => 'customEvent:wpa_category',
							'match_type' => '1',
							'value'      => 'mail',
						),
					),
				),
				$api_limit
			);
		} else {
			$stats_raw = $this->wp_analytify->pa_get_analytics_dashboard( 'ga:totalEvents', $this->start_date, $this->end_date, 'ga:eventCategory,ga:eventLabel,ga:eventAction', '-ga:totalEvents', 'ga:eventCategory==external,ga:eventCategory==outbound-link,ga:eventCategory==download,ga:eventCategory==tel,ga:eventCategory==mail', $api_limit, 'show-default-events-tracking' );
		}

		if ( isset( $stats_raw['rows'] ) && ! empty( $stats_raw['rows'] ) ) {
			$filtered_stats = apply_filters( 'analytify_events_tracking_raw_stats', $stats_raw['rows'], $this->ga_mode, array( $this->start_date, $this->end_date ) );

			// Split the stats into external, download, tel, outbound and mail.
			$stats_external = isset( $filtered_stats['external'] ) ? $filtered_stats['external'] : array();
			$stats_download = isset( $filtered_stats['download'] ) ? $filtered_stats['download'] : array();
			$stats_tel      = isset( $filtered_stats['tel'] ) ? $filtered_stats['tel'] : array();
			$stats_outbound = isset( $filtered_stats['outbound-link'] ) ? $filtered_stats['outbound-link'] : array();
			$stats_mail     = isset( $filtered_stats['mail'] ) ? $filtered_stats['mail'] : array();

			// wrapped the links in a tag with blank attribute.
			if( ! empty ( $stats_external ) ) {
				foreach ( $stats_external as $key => $stat ) {
					$stats_external[$key]['action'] = '<a href="' . esc_url_raw( $stats_external[$key]['action'] ) . '" target="_blank">' . esc_html( $stats_external[$key]['action'] ) . '</a>';
				}
			}
		}

		$headers = array(
			'no'  => array(
				'label'    => esc_html__( '#', 'wp-analytify-pro' ),
				'type'     => 'counter',
				'th_class' => 'wd_1',
				'td_class' => '',
			),
			'label' => array(
				'label'    => esc_html__( 'Label', 'wp-analytify-pro' ),
				'th_class' => 'analytify_txt_left',
				'td_class' => '',
			),
			'action' => array(
				'label'    => esc_html__( 'Link', 'wp-analytify-pro' ),
				'th_class' => 'analytify_txt_left',
				'td_class' => '',
			),
			'views' => array(
				'label'    => esc_html__( 'Clicks', 'wp-analytify-pro' ),
				'th_class' => 'analytify_value_row',
				'td_class' => 'analytify_txt_center',
			),
		);

		return array(
			'success'  => true,
			'external' => array(
				'headers' => $headers,
				'stats'   => $stats_external,
			),
			'download' => array(
				'headers' => $headers,
				'stats'   => $stats_download,
			),
			'tel'      => array(
				'headers' => $headers,
				'stats'   => $stats_tel,
			),
			'outbound' => array(
				'headers' => $headers,
				'stats'   => $stats_outbound,
			),
			'mail'     => array(
				'headers' => $headers,
				'stats'   => $stats_mail,
			),
			'pagination' => true,
		);
	}

	/**
	 * Endpoint for 'Custom Dimensions' (module).
	 *
	 * @return array
	 */
	private function custom_dimensions() {

		$sections      = array();
		$success       = true;
		$error_message = false;

		$dimensions = $this->wp_analytify->settings->get_option( 'analytiy_custom_dimensions', 'wp-analytify-custom-dimensions' );

		$headers = array(
			'label' => array(
				'label'    => null,
				'th_class' => '',
				'td_class' => '',
			),
			'views' => array(
				'label'    => null,
				'th_class' => '',
				'td_class' => 'analytify_txt_center analytify_value_row',
			),
		);

		if ( ! $dimensions ) {
			$error_message = __( 'No dimension is set. Please set dimensions from the settings.', 'wp-analytify-pro' );
		} else {
			if ( 'ga4' === $this->ga_mode ) {

				$defined_dimensions = Analytify_Google_Dimensions::get_current_dimensions();

				foreach ( $dimensions as $key => $value ) {
					$type       = $value['type'];
					$label      = isset( $defined_dimensions[ $type ]['title'] ) ? $defined_dimensions[ $type ]['title'] : '';
					$identifier = isset( $defined_dimensions[ $type ]['value'] ) ? $defined_dimensions[ $type ]['value'] : '';
					$api_limit  = apply_filters( 'analytify_api_limit_custom_dimensions_' . $type . '_stats', 10, 'dashboard' );

					if ( ! $identifier ) {
						continue;
					}

					$dimension_stats = $this->wp_analytify->get_reports(
						'show-sessions-dimensions-stats-' . $type,
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
						$api_limit
					);

					$sections[ $type ]['headers'] = $headers;
					$sections[ $type ]['title']   = $label . ' <a href="#" class="analytify-export-data analytify_tooltip" data-stats-type="custom-dimension-' . $type . '"><span class="analytify_tooltiptext">' . esc_html__( 'Export Stats', 'wp-analytify-pro' ) . '</span></a>';
					$sections[ $type ]['stats']   = array();

					$total = 0;

					if ( isset( $dimension_stats['rows'] ) && $dimension_stats['rows'] ) {
						foreach ( $dimension_stats['rows'] as $row ) {
							$sections[ $type ]['stats'][] = array(
								'label' => apply_filters( 'analytify_custom_dimension_row_label', $row[ 'customEvent:' . $identifier ], $type, 'dashboard' ),
								'views' => $row['sessions'],
							);

							$total = $total + $row['sessions'];
						}
					}

					$sections[ $type ]['title_stats'] = $total ? '<span class="analytify_medium_f">' . __( 'Total', 'wp-analytify-pro' ) . '</span> ' . $total : false;
				}
			} else {
				$defined_dimensions = Analytify_Google_Dimensions::get_current_dimensions();
				foreach ( $dimensions as $key => $value ) {

					if ( ! $value['id'] ) {
						$value['id'] = $defined_dimensions[$key]['id'];
					}

					$type      = $value['type'];
					$id        = $value['id'];
					$label     = ucfirst( str_replace( '_', ' ', $type ) );
					$api_limit = apply_filters( 'analytify_api_limit_custom_dimensions_' . $type . '_stats', 10, 'dashboard' );
					$metric    = 'logged_in' === $type || 'user_id' === $type ? 'ga:sessions' : 'ga:pageviews';

					// $dimension_stats = $this->wp_analytify->pa_get_analytics_dashboard( $metric, $this->start_date, $this->end_date, 'ga:dimension' . $id, $metric, false, $api_limit, 'show-sessions-dimensions-stats-' . $type );
					ob_start();
					$dimension_stats = $this->wp_analytify->pa_get_analytics_dashboard( $metric, $this->start_date, $this->end_date, 'ga:dimension' . $id, $metric, false, $api_limit, 'show-sessions-dimensions-stats-' . $type );
    				$decoded_stats = ob_get_clean();
					// $dimension_stats = json_decode( $decoded_stats, true );
					$total           = isset( $dimension_stats['totalsForAllResults'][ $metric ] ) ? $dimension_stats['totalsForAllResults'][ $metric ] : "0";

					$sections[ $type ] = array(
						'title'       => $label . ' <a href="#" class="analytify-export-data analytify_tooltip" data-stats-type="custom-dimension-' . $type . '"><span class="analytify_tooltiptext">' . esc_html__( 'Export Stats', 'wp-analytify-pro' ) . '</span></a>',
						'title_stats' => $total ? '<span class="analytify_medium_f">' . __( 'Total', 'wp-analytify-pro' ) . '</span> ' . $total : false,
						'headers'     => $headers,
						'stats'       => array(),
					);

					if ( isset( $dimension_stats['rows'] ) && $dimension_stats['rows'] ) {
						foreach ( $dimension_stats['rows'] as $row ) {
							$sections[ $type ]['stats'][] = array(
								'label' => apply_filters( 'analytify_custom_dimension_row_label', $row[0], $type, 'dashboard' ),
								'views' => $row[1],
							);
						}
					}
				}
			}
		}

		return array(
			'success'       => $success,
			'error_message' => $error_message,
			'sections'      => $sections,
		);
	}

	/**
	 * Endpoint for 'Search Term' dashboard.
	 *
	 * @return array
	 */
	private function search_terms() {

		// API limit.
		$api_limit = apply_filters( 'analytify_api_limit_search_term_stats', 50, 'dashboard' );

		$headers = array();
		$stats   = array();

		if ( 'ga4' === $this->ga_mode ) {

			$headers = array(
				'no'      => array(
					'label'    => esc_html__( '#', 'wp-analytify-pro' ),
					'type'     => 'counter',
					'th_class' => 'analytify_num_row',
					'td_class' => 'analytify_txt_center',
				),
				'term'    => array(
					'label'    => esc_html__( 'Search Term', 'wp-analytify-pro' ),
					'th_class' => 'analytify_txt_left',
					'td_class' => '',
				),
				'total'   => array(
					'label'    => esc_html__( 'Total Search', 'wp-analytify-pro' ),
					'th_class' => 'analytify_value_row',
					'td_class' => 'analytify_txt_center',
				),
				'session' => array(
					'label'    => esc_html__( 'Search per Session', 'wp-analytify-pro' ),
					'th_class' => 'analytify_value_row',
					'td_class' => 'analytify_txt_center',
				),
				'users'   => array(
					'label'    => esc_html__( 'Total Users', 'wp-analytify-pro' ),
					'th_class' => 'analytify_value_row',
					'td_class' => 'analytify_txt_center',
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
				$api_limit
			);

			if ( isset( $stats_raw['rows'] ) && $stats_raw['rows'] ) {
				foreach ( $stats_raw['rows'] as $row ) {
					$stats[] = array(
						'no'      => null,
						'term'    => $row['searchTerm'],
						'total'   => $row['eventCount'],
						'session' => $row['sessions'],
						'users'   => $row['totalUsers'],
					);
				}
			}
		} else {

			$headers = array(
				'no'                => array(
					'label'    => esc_html__( '#', 'wp-analytify-pro' ),
					'type'     => 'counter',
					'th_class' => 'analytify_num_row',
					'td_class' => 'analytify_txt_center',
				),
				'term'               => array(
					'label'    => esc_html__( 'Search Term', 'wp-analytify-pro' ),
					'th_class' => 'analytify_txt_left',
					'td_class' => '',
				),
				'unique'             => array(
					'label'    => esc_html__( 'Total Unique Searches', 'wp-analytify-pro' ),
					'th_class' => 'analytify_value_row',
					'td_class' => 'analytify_txt_center',
				),
				'result_per_search'  => array(
					'label'    => esc_html__( 'Results Pageviews/Search', 'wp-analytify-pro' ),
					'th_class' => 'analytify_value_row',
					'td_class' => 'analytify_txt_center',
				),
				'search_exists'      => array(
					'label'    => esc_html__( '% Search Exits', 'wp-analytify-pro' ),
					'th_class' => 'analytify_value_row',
					'td_class' => 'analytify_txt_center',
				),
				'search_refinements' => array(
					'label'    => esc_html__( '% Search Refinements', 'wp-analytify-pro' ),
					'th_class' => 'analytify_value_row',
					'td_class' => 'analytify_txt_center',
				),
				'time_after_search'  => array(
					'label'    => esc_html__( 'Time After Search', 'wp-analytify-pro' ),
					'th_class' => 'analytify_value_row',
					'td_class' => 'analytify_txt_center',
				),
				'avg_search_depth'   => array(
					'label'    => esc_html__( 'Avg. Search Depth', 'wp-analytify-pro' ),
					'th_class' => 'analytify_value_row',
					'td_class' => 'analytify_txt_center',
				),
			);

			$stats_raw = $this->wp_analytify->pa_get_analytics_dashboard( 'ga:searchUniques,ga:avgSearchResultViews,ga:searchExitRate,ga:percentSearchRefinements,ga:avgSearchDuration,ga:avgSearchDepth', $this->start_date, $this->end_date, 'ga:searchKeyword', '-ga:searchUniques', false, $api_limit, 'show-search-term' );
			if ( isset( $stats_raw['rows'] ) && $stats_raw['rows'] ) {
				foreach ( $stats_raw['rows'] as $row ) {
					$stats[] = array(
						'no'                 => null,
						'term'               => $row[0],
						'unique'             => $row[1],
						'result_per_search'  => WPANALYTIFY_Utils::pretty_time( $row[2], 2 ),
						'search_exists'      => number_format( $row[3], 2 ) . esc_html__( '%', 'wp-analytify-pro' ),
						'search_refinements' => number_format( $row[4], 2 ) . esc_html__( '%', 'wp-analytify-pro' ),
						'time_after_search'  => WPANALYTIFY_Utils::pretty_time( $row[5] ),
						'avg_search_depth'   => number_format( $row[6], 2 ),
					);
				}
			}
		}

		return array(
			'success'    => true,
			'headers'    => $headers,
			'stats'      => $stats,
			'footer'     => apply_filters( 'analytify_search_term_footer', __( 'List of the Terms that were searched for on your site.', 'wp-analytify-pro' ), array( $this->start_date, $this->end_date ) ),
			'pagination' => true,
		);
	}

	/**
	 * Endpoint for 'Demographic' dashboard.
	 *
	 * @return array
	 */
	private function demographics() {

		// API limit.
		$api_limit = apply_filters( 'analytify_api_limit_demographic_stats', 20, 'dashboard' );

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
				$api_limit
			);
			if ( isset( $stats_raw['rows'] ) && $stats_raw['rows'] ) {
				foreach ( $stats_raw['rows'] as $row ) {
					$stats[] = array(
						'no'     => null,
						'age'    => $row['userAgeBracket'],
						'gender' => $row['userGender'],
						'views'  => WPANALYTIFY_Utils::pretty_numbers( $row['sessions'] ),
					);
				}
			}
		} else {
			$stats_raw = $this->wp_analytify->pa_get_analytics_dashboard( 'ga:sessions', $this->start_date, $this->end_date, 'ga:userAgeBracket,ga:userGender', false, false, $api_limit, 'show-demographic-stats' );
			if ( isset( $stats_raw['rows'] ) && $stats_raw['rows'] ) {
				foreach ( $stats_raw['rows'] as $row ) {
					$stats[] = array(
						'no'     => null,
						'age'    => $row[0],
						'gender' => $row[1],
						'views'  => WPANALYTIFY_Utils::pretty_numbers( $row[2] ),
					);
				}
			}
		}

		return array(
			'success'    => true,
			'headers'    => array(
				'no'     => array(
					'label'    => esc_html__( '#', 'wp-analytify-pro' ),
					'type'     => 'counter',
					'th_class' => 'analytify_num_row',
					'td_class' => 'analytify_txt_center',
				),
				'age'    => array(
					'label'    => esc_html__( 'Age', 'wp-analytify-pro' ),
					'th_class' => 'analytify_txt_left',
					'td_class' => '',
				),
				'gender' => array(
					'label'    => esc_html__( 'Gender', 'wp-analytify-pro' ),
					'th_class' => 'analytify_txt_left',
					'td_class' => '',
				),
				'views'  => array(
					'label'    => esc_html__( 'Total Views', 'wp-analytify-pro' ),
					'th_class' => 'analytify_value_row',
					'td_class' => 'analytify_txt_center',
				),
			),
			'stats'      => $stats,
			'footer'     => apply_filters( 'analytify_demographic_footer', __( 'Demographic Stats.', 'wp-analytify-pro' ), array( $this->start_date, $this->end_date ) ),
			'pagination' => true,
		);
	}

	/**
	 * Real Time reporting.
	 *
	 * @return array
	 */
	private function real_time() {

		$page_prefix = apply_filters( 'analytify_realtime_page_url_prefix', '' );

		switch ( $this->type ) {
			case 'counter':
				$type = 'counter';
				break;

			default:
				$type = 'all';
				break;
		}

		if ( method_exists( 'WPANALYTIFY_Utils', 'get_ga_mode' ) && 'ga4' === $this->ga_mode ) {

			$headers = array();
			$rows    = array();
			$counter = array(
				'online'  => 0,
				'desktop' => 0,
				'tablet'  => 0,
				'mobile'  => 0,
			);

			if ( 'all' === $type ) {
				$headers = array(
					'no'     => array(
						'label'    => esc_html__( '#', 'wp-analytify-pro' ),
						'type'     => 'counter',
						'th_class' => 'analytify_num_row',
						'td_class' => 'analytify_txt_center',
					),
					'page'    => array(
						'label'    => esc_html__( 'Page', 'wp-analytify-pro' ),
						'th_class' => 'analytify_txt_left',
						'td_class' => '',
					),
					'visitors'  => array(
						'label'    => esc_html__( 'Visitors', 'wp-analytify-pro' ),
						'th_class' => 'analytify_value_row',
						'td_class' => 'analytify_txt_center',
					),
				);
			}

			// To get unique visitors added a country dimension to differentiate.
			$online_visitors = $this->wp_analytify->get_real_time_reports(
				array(
					'activeUsers',
				),
				array(
					'deviceCategory',
					'country',
				)
			);
			if( isset( $online_visitors['rows'] ) && $online_visitors['rows']  ) {
				foreach( $online_visitors['rows'] as $visitors ) {
					$counter['online'] += $visitors['activeUsers'];
					switch ( $visitors['deviceCategory'] ) {
						case 'desktop':
							$counter['desktop'] += $visitors['activeUsers'];
							break;
						case 'tablet':
							$counter['tablet']  += $visitors['activeUsers'];
							break;
						case 'mobile':
							$counter['mobile']  += $visitors['activeUsers'];
							break;
						default:
							break;
					}
				}
			}
			$raw_stats = $this->wp_analytify->get_real_time_reports(
				array(
					'activeUsers',
				),
				array(
					'unifiedScreenName',
				)
			);

			if ( isset( $raw_stats['rows'] ) && $raw_stats['rows'] ) {
				foreach ( $raw_stats['rows'] as $row ) {

					// $counter['online']++;

					if ( 'all' === $type ) {
						$rows[] = array(
							'no'       => null,
							'page'     => $row['unifiedScreenName'],
							'visitors' => WPANALYTIFY_Utils::pretty_numbers( $row['activeUsers'] ),
						);
					}
				}
				// Limit pages.
				$rows = array_slice( $rows, 0, apply_filters( 'analytify_realtime_limit_pages', 20 ) );
			}
		} else {

			$headers = array();
			$rows    = array();
			$counter = array(
				'online'    => 0,
				'referral'  => 0,
				'organic'   => 0,
				'social'    => 0,
				'direct'    => 0,
				'new'       => 0,
				'returning' => 0,
			);

			$profile_id = $this->wp_analytify->settings->get_option( 'profile_for_dashboard', 'wp-analytify-profile' );
			try {
				$raw_stats = $this->wp_analytify->service->data_realtime->get(
					'ga:' . $profile_id,
					'ga:activeVisitors',
					array(
						'dimensions' => 'ga:pageTitle,ga:pagePath,ga:trafficType,ga:visitorType',
					)
				);
			} catch ( Exception $e ) {
				return array(
					'success'       => false,
					'error_message' => $e->getMessage(),
				);
			}

			if ( 'all' === $type ) {
				$headers = array(
					'no'     => array(
						'label'    => esc_html__( '#', 'wp-analytify-pro' ),
						'type'     => 'counter',
						'th_class' => 'analytify_num_row',
						'td_class' => 'analytify_txt_center',
					),
					'page'    => array(
						'label'    => esc_html__( 'Page', 'wp-analytify-pro' ),
						'th_class' => 'analytify_txt_left',
						'td_class' => '',
					),
					'visitors'  => array(
						'label'    => esc_html__( 'Visitors', 'wp-analytify-pro' ),
						'th_class' => 'analytify_value_row',
						'td_class' => 'analytify_txt_center',
					),
				);
			}

			if ( isset( $raw_stats['rows'] ) && $raw_stats['rows'] ) {
				foreach ( $raw_stats['rows'] as $row ) {

					switch ( $row[2] ) {
						case 'REFERRAL':
							$counter['referral']++;
							break;
						case 'ORGANIC':
							$counter['organic']++;
							break;
						case 'SOCIAL':
							$counter['social']++;
							break;
						case 'DIRECT':
							$counter['direct']++;
							break;
						default:
							break;
					}

					if ( "RETURNING" === $row[3] ) {
						$counter['returning']++;
					} elseif ( "NEW" === $row[3] ) {
						$counter['new']++;
					}

					if ( 'all' === $type ) {
						$rows[] = array(
							'no'       => null,
							'page'     => '<a href="' . $page_prefix . esc_url_raw( $row[1] ) . '" target="_blank">' . esc_html( $row[0] ) . '</a>',
							'visitors' => $row[4],
						);
					}
				}

				// Limit pages.
				$rows = array_slice( $rows, 0, apply_filters( 'analytify_realtime_limit_pages', 20 ) );
			}

			if ( isset( $raw_stats['totalsForAllResults']['ga:activeVisitors'] ) ) {
				$counter['online'] = $raw_stats['totalsForAllResults']['ga:activeVisitors'];
			}
		}

		return array(
			'success' => true,
			'title'   => esc_html__( 'Real Time', 'wp-analytify-pro' ),
			'counter' => $counter,
			'headers' => $headers,
			'stats'   => $rows,
		);
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
	 * Filters raw events tracking stats and splits them into separate arrays for each event type.
	 *
	 * @param array  $stats_raw Raw events tracking stats.
	 * @param string $ga_mode   GA mode.
	 *
	 * @return array
	 */
	public function filter_events_tracking_raw_stats( $stats_raw, $ga_mode ) {
		$stats = array();

		$categories = array( 'external', 'download', 'tel', 'outbound-link', 'mail' );

		if ( 'ga4' === $ga_mode ) {
			foreach ( $stats_raw as $row ) {
				$event_category = $row['customEvent:wpa_category'];

				if ( in_array( $event_category, $categories, true ) ) {
					$stats[ $event_category ][] = array(
						'no'     => null,
						'label'  => $row['customEvent:wpa_link_label'],
						'action' => $row['customEvent:wpa_link_action'],
						'views'  => WPANALYTIFY_Utils::pretty_numbers( $row['eventCount'] ),
					);
				}
			}
		} else {
			foreach ( $stats_raw as $row ) {
				$event_category = $row[0];

				if ( in_array( $event_category, $categories, true ) ) {
					$stats[ $event_category ][] = array(
						'no'     => null,
						'label'  => $row[1],
						'action' => $row[2],
						'views'  => WPANALYTIFY_Utils::pretty_numbers( $row[3] ),
					);
				}
			}
		}

		// Limit all event categories.
		if ( ! empty( $stats ) ) {
			foreach ( array_keys( $stats ) as $key ) {
				$limit         = apply_filters( 'analytify_events_tracking_limit_' . $key . '_stats', 50 );
				$stats[ $key ] = array_slice( $stats[ $key ], 0, $limit, true );
			}
		}

		return $stats;
	}

	/**
	 * Applied as a filter to a single custom dimension row label.
	 *
	 * @param string $label Row label.
	 * @param string $type  Dimension type.
	 *
	 * @return string
	 */
	public function filter_custom_dimension_row_label( $label, $type ) {
		switch ( $type ) {
			case 'logged_in':
				return 'true' === $label ? esc_html__( 'Logged-In', 'wp-analytify-pro' ) : esc_html__( 'Logged-Out', 'wp-analytify-pro' );

			case 'published_at':
				return wp_date( get_option( 'date_format' ) . ' ' . get_option( 'time_format' ), strtotime( $label ) );

			case 'user_id':
				$user = get_user_by( 'id', $label );
				return ( $user && $user->user_login ) ? $user->user_login : $label;

			default:
				return $label;
		}
	}
}

/**
 * Init the instance.
 *
 */
Analytify_Pro_Rest_API::get_instance();
