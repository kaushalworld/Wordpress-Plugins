<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
 * Handle Analytify REST API endpoints
 */
class Analytify_Rest_API {

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
	 * Post ID (optional).
	 *
	 * @var string
	 */
	private $post_id;

	/**
	 * Set compare 'start state'.
	 *
	 * @var string
	 */
	private $compare_start_date = null;

	/**
	 * Set compare 'End state'.
	 *
	 * @var string
	 */
	private $compare_end_date = null;

	/**
	 * Set compare number of days.
	 *
	 * @var string
	 */
	private $compare_days = null;

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
		add_action( 'rest_api_init', array( $this, 'analytify_rest_api_init' ) );

		// Formate 'general_statistics' footer, add labels and description.
		add_filter( 'analytify_general_stats_footer', array( $this, 'general_stats_footer' ), 10, 2 );

		add_filter( 'analytify_single_post_sections', array( $this, 'single_post_sections' ), 10, 3 );
	}

	/**
	 * Register end point.
	 *
	 * @return void
	 */
	public function analytify_rest_api_init() {

		$this->wp_analytify = $GLOBALS['WP_ANALYTIFY'];
		$this->ga_mode      = WPANALYTIFY_Utils::get_ga_mode();

		register_rest_route(
			'wp-analytify/v1',
			'/get_report/(?P<request_type>[a-zA-Z0-9-]+)',
			array(
				array(
					'methods'             => WP_REST_Server::READABLE, // Get Request.
					'callback'            => array( $this, 'handle_request' ),
					'permission_callback' => array( $this, 'permission_check' ),
					// 'permission_callback' => '__return_true',
				),
			)
		);
	}

	/**
	 * Checks access permission.
	 * Checks if the user is logged-in and checks if the user role has access.
	 *
	 * @return boolean
	 */
	public function permission_check( $data ) {

		// If the route is for single post stats.
		if ( strpos( $data->get_route(), 'single-post-stats' ) ) {
			$is_access_level = $this->wp_analytify->settings->get_option( 'show_analytics_roles_back_end', 'wp-analytify-admin', array( 'administrator' ) );
			return (bool) $this->wp_analytify->pa_check_roles( $is_access_level );
		}

		$is_access_level = $this->wp_analytify->settings->get_option( 'show_analytics_roles_dashboard', 'wp-analytify-dashboard', array( 'administrator' ) );
		return (bool) $this->wp_analytify->pa_check_roles( $is_access_level );
	}

	/**
	 * Handle the request.
	 *
	 * @param WP_REST_Request $request WP REST request object.
	 * @return array|WP_Error
	 */
	public function handle_request( WP_REST_Request $request ) {
		$request_type = $request->get_param( 'request_type' );

		$this->start_date  = $request->get_param( 'sd' );
		$this->end_date    = $request->get_param( 'ed' );
		$this->date_differ = $request->get_param( 'd_diff' );
		$this->post_id     = $request->get_param( 'post_id' );

		if ( ! $this->start_date ) {
			$this->start_date = wp_date( 'Y-m-d', strtotime( '-30 days', current_time( 'timestamp' ) ) );
		}
		if ( ! $this->end_date ) {
			$this->end_date = wp_date( 'Y-m-d', current_time( 'timestamp' ) );
		}
		if ( $this->date_differ ) {
			update_option( 'analytify_date_differ', $this->date_differ );
		}


		switch ( $request_type ) {
			case 'general-stats':
				return $this->general_stats();
			case 'top-pages-stats':
				return $this->top_pages_stats();
			case 'geographic-stats':
				return $this->geographic_stats();
			case 'system-stats':
				return $this->system_stats();
			case 'keyword-stats':
				return $this->keyword_stats();
			case 'social-stats':
				return $this->social_stats();
			case 'referer-stats':
				return $this->get_referer_stats();
			case 'what-is-happening-stats':
				return $this->get_what_is_happening_stats();
			case 'single-post-stats':
				return $this->get_single_post_stats();
		}

		// If no request type match, Return error.
		return new WP_Error( 'analytify_invalid_endpoint', esc_html__( 'Invalid endpoint.', 'wp-analytify' ), array( 'status' => 404 ) );
	}

	/**
	 * Get general stats.
	 *
	 * @return array
	 */
	private function general_stats() {

		$this->set_compare_dates();

		// Container all the text information about the stats in boxes.
		$boxes_description = array(
			'sessions'         => array(
				'title'       => esc_html__( 'Sessions', 'wp-analytify' ),
				'description' => esc_html__( 'A session is a time period in which a user is actively engaged with your website.', 'wp-analytify' ),
				'bottom'      => false,
				'number'      => 0,
			),
			'visitors'         => array(
				'title'       => esc_html__( 'Visitors', 'wp-analytify' ),
				'description' => esc_html__( 'Users who complete a minimum of one session on your website.', 'wp-analytify' ),
				'bottom'      => false,
				'number'      => 0,
			),
			'pageviews'        => array(
				'title'       => esc_html__( 'Page Views', 'wp-analytify' ),
				'description' => esc_html__( 'Page Views are the total number of Pageviews, these include repeated views.', 'wp-analytify' ),
				'bottom'      => false,
				'number'      => 0,
			),
			'avg_time_on_site' => array(
				'title'       => esc_html__( 'Avg. Time on Site', 'wp-analytify' ),
				'description' => esc_html__( 'Total time that a single user spends on your website.', 'wp-analytify' ),
				'bottom'      => false,
				'number'      => 0,
			),
			'bounce_rate'      => array(
				'title'       => esc_html__( 'Bounce Rate', 'wp-analytify' ),
				'description' => esc_html__( 'Percentage of single page visits (i.e number of visits in which a visitor leaves your website from the landing page without browsing your website).', 'wp-analytify' ),
				'append'      => '<span class="analytify_xl_f">%</span>',
				'bottom'      => false,
				'number'      => 0,
			),
			'pages_session'    => array(
				'title'       => esc_html__( 'Pages per Session', 'wp-analytify' ),
				'description' => esc_html__( 'Pages per Session is the number of pages viewed by a user during a single session. Repeated views are counted.', 'wp-analytify' ),
				'bottom'      => false,
				'number'      => 0,
			),
			// 'new_sessions' is only for UA.
			'new_sessions'     => array(
				'title'       => esc_html__( '% New Sessions', 'wp-analytify' ),
				'description' => esc_html__( 'A new session is the time period when a new user comes to your website and is actively engaged with your website.', 'wp-analytify' ),
				'append'      => '<span class="analytify_xl_f">%</span>',
				'bottom'      => false,
				'number'      => 0,
			),
			// 'engaged_sessions' is only for GA4.
			'engaged_sessions' => array(
				'title'       => esc_html__( 'Engaged Sessions', 'wp-analytify' ),
				'description' => esc_html__( 'The number of sessions that lasted longer than 10 seconds, or had a conversion event, or had 2 or more page views.', 'wp-analytify' ),
				'bottom'      => false,
				'number'      => 0,
			),
		);
		$chart_description = array(
			'new_vs_returning_visitors' => array(
				'title'  => esc_html__( 'New vs Returning Visitors', 'wp-analytify' ),
				'type'   => 'PIE',
				'stats'  => array(
					'new'       => array(
						'label'  => esc_html__( 'New', 'wp-analytify' ),
						'number' => 0,
					),
					'returning' => array(
						'label'  => esc_html__( 'Returning', 'wp-analytify' ),
						'number' => 0,
					),
				),
				'colors' => apply_filters( 'analytify_new_vs_returning_visitors_chart_colors', array( '#03a1f8', '#00c853' ) ),
			),
			'visitor_devices'           => array(
				'title'  => esc_html__( 'Devices of Visitors', 'wp-analytify' ),
				'type'   => 'PIE',
				'stats'  => array(
					'mobile'  => array(
						'label'  => esc_html__( 'Mobile', 'wp-analytify' ),
						'number' => 0,
					),
					'tablet'  => array(
						'label'  => esc_html__( 'Tablet', 'wp-analytify' ),
						'number' => 0,
					),
					'desktop' => array(
						'label'  => esc_html__( 'Desktop', 'wp-analytify' ),
						'number' => 0,
					),
				),
				'colors' => apply_filters( 'analytify_visitor_devices_chart_colors', array( '#444444', '#ffbc00', '#ff5252' ) ),
			),
		);

		$footer_description = false;

		// Container numbers (or string) for the different stats.
		$boxes_stats = array();

		if ( 'ga4' === $this->ga_mode ) {

			unset( $boxes_description['new_sessions'] );

			$general_stats_raw = $this->wp_analytify->get_reports('show-default-overall-dashboard', array(
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
				), $this->get_dates());

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
				)
			);

			$general_stats = $general_stats_raw['aggregations'];
			// code added by jawad during debug added isset checks on number field.
			$boxes_stats = array(
				'sessions'         => array(
					'raw'    => isset( $general_stats['sessions'] ) ? $general_stats['sessions'] : 0,
					'number' => isset( $general_stats['sessions'] ) ? WPANALYTIFY_Utils::pretty_numbers( $general_stats['sessions'] ) : 0,
				),

				'visitors'         => array(
					'raw'    => isset( $general_stats['totalUsers'] ) ? $general_stats['totalUsers'] : 0,
					'number' => isset( $general_stats['totalUsers'] ) ? WPANALYTIFY_Utils::pretty_numbers( $general_stats['totalUsers'] ) : 0,
				),

				'pageviews'        => array(
					'raw'    => isset( $general_stats['screenPageViews'] ) ? $general_stats['screenPageViews'] : 0,
					'number' => isset( $general_stats['screenPageViews'] ) ? WPANALYTIFY_Utils::pretty_numbers( $general_stats['screenPageViews'] ) : 0,
				),

				'avg_time_on_site' => array(
					'raw'    => isset( $general_stats['averageSessionDuration'] ) ? $general_stats['averageSessionDuration'] : 0,
					'number' => isset( $general_stats['averageSessionDuration'] ) ? WPANALYTIFY_Utils::pretty_time( $general_stats['averageSessionDuration'] ) : 0,
				),

				'bounce_rate'      => array(
					'raw'    => isset( $general_stats['bounceRate'] ) ? $general_stats['bounceRate'] : 0,
					'number' => isset( $general_stats['bounceRate'] ) ? WPANALYTIFY_Utils::fraction_to_percentage( $general_stats['bounceRate'] ) : 0,
				),

				'pages_session'    => array(
					'raw'    => isset( $general_stats['screenPageViewsPerSession'] ) ? $general_stats['screenPageViewsPerSession'] : 0,
					'number' => isset( $general_stats['screenPageViewsPerSession'] ) ? round( $general_stats['screenPageViewsPerSession'], 2 ) : 0,
				),

				'engaged_sessions' => array(
					'raw'    => isset( $general_stats['engagedSessions'] ) ? $general_stats['engagedSessions'] : 0,
					'number' => isset( $general_stats['engagedSessions'] ) ? WPANALYTIFY_Utils::pretty_numbers( $general_stats['engagedSessions'] ) : 0,
				),
			);

			if ( $this->compare_start_date && $this->compare_end_date ) {
				$compare_stats_raw = $this->wp_analytify->get_reports(
					'show-default-overall-dashboard-compare',
					array(
						'sessions',
						'totalUsers',
						'screenPageViews',
						'averageSessionDuration',
						'bounceRate',
						'screenPageViewsPerSession',
						'engagedSessions',
					),
					array(
						'start' => $this->compare_start_date,
						'end'   => $this->compare_end_date,
					)
				);
			}

			if ( isset( $compare_stats_raw['aggregations'] ) ) {
				$compare_stats = array(
					'sessions'         => isset( $compare_stats_raw['aggregations']['sessions'] ) ? $compare_stats_raw['aggregations']['sessions'] : 0,
					'visitors'         => isset( $compare_stats_raw['aggregations']['totalUsers'] ) ? $compare_stats_raw['aggregations']['totalUsers'] : 0,
					'pageviews'        => isset( $compare_stats_raw['aggregations']['screenPageViews'] ) ? $compare_stats_raw['aggregations']['screenPageViews'] : 0,
					'avg_time_on_site' => isset( $compare_stats_raw['aggregations']['averageSessionDuration'] ) ? $compare_stats_raw['aggregations']['averageSessionDuration'] : 0,
					'bounce_rate'      => isset( $compare_stats_raw['aggregations']['bounceRate'] ) ? $compare_stats_raw['aggregations']['bounceRate'] : 0,
					'pages_session'    => isset( $compare_stats_raw['aggregations']['screenPageViewsPerSession'] ) ? $compare_stats_raw['aggregations']['screenPageViewsPerSession'] : 0,
					'engaged_sessions' => isset( $compare_stats_raw['aggregations']['engagedSessions'] ) ? $compare_stats_raw['aggregations']['engagedSessions'] : 0,
				);
			}

			if ( isset( $general_stats['newUsers'] ) ) {
				$chart_description['new_vs_returning_visitors']['stats']['new']['number'] = $general_stats['newUsers'];
			}

			if ( isset( $general_stats['activeUsers'] ) ) {
				$chart_description['new_vs_returning_visitors']['stats']['returning']['number'] = $general_stats['activeUsers'];
			}

			if ( $device_category_stats['rows'] ) {
				foreach ( $device_category_stats['rows'] as $device ) {
					$chart_description['visitor_devices']['stats'][ $device['deviceCategory'] ]['number'] = $device['sessions'];
				}
			}

			if ( isset( $general_stats['userEngagementDuration'] ) ) {
				$footer_description = apply_filters( 'analytify_general_stats_footer', $general_stats['userEngagementDuration'], array( $this->start_date, $this->end_date ) );
			}
		} else {

			unset( $boxes_description['engaged_sessions'] );

			$general_stats_raw = $this->wp_analytify->pa_get_analytics_dashboard( 'ga:sessions,ga:users,ga:pageviews,ga:avgSessionDuration,ga:bounceRate,ga:pageviewsPerSession,ga:percentNewSessions,ga:newUsers,ga:sessionDuration', $this->start_date, $this->end_date, false, false, false, false, 'show-default-overall-dashboard' );

			// New vs returning users.
			$new_returning_stats_raw = $this->wp_analytify->pa_get_analytics_dashboard( 'ga:users', $this->start_date, $this->end_date, 'ga:userType', false, false, false, 'show-default-new-returning-dashboard' );

			// Device category.
			$device_category_stats_raw = $this->wp_analytify->pa_get_analytics_dashboard( 'ga:sessions', $this->start_date, $this->end_date, 'ga:deviceCategory', '-ga:sessions', false, false, 'show-default-overall-device-dashboard' );

			// Get prev stats.
			if ( $this->compare_start_date && $this->compare_end_date ) {
				$compare_stats_raw = $this->wp_analytify->pa_get_analytics_dashboard( 'ga:sessions,ga:users,ga:pageviews,ga:avgSessionDuration,ga:bounceRate,ga:pageviewsPerSession,ga:percentNewSessions,ga:newUsers', $this->compare_start_date, $this->compare_end_date, false, false, false, false, 'show-default-overall-dashboard-compare' );
			}

			if ( isset( $general_stats_raw['totalsForAllResults'] ) && $general_stats_raw['totalsForAllResults'] ) {
				$general_stats = $general_stats_raw['totalsForAllResults'];
				$boxes_stats   = array(
					'sessions'         => array(
						'raw'    => $general_stats['ga:sessions'],
						'number' => $general_stats['ga:sessions'] ? WPANALYTIFY_Utils::pretty_numbers( $general_stats['ga:sessions'] ) : 0,
					),

					'visitors'         => array(
						'raw'    => $general_stats['ga:users'],
						'number' => $general_stats['ga:users'] ? WPANALYTIFY_Utils::pretty_numbers( $general_stats['ga:users'] ) : 0,
					),

					'pageviews'        => array(
						'raw'    => $general_stats['ga:pageviews'],
						'number' => $general_stats['ga:pageviews'] ? WPANALYTIFY_Utils::pretty_numbers( $general_stats['ga:pageviews'] ) : 0,
					),

					'avg_time_on_site' => array(
						'raw'    => $general_stats['ga:avgSessionDuration'],
						'number' => $general_stats['ga:avgSessionDuration'] ? WPANALYTIFY_Utils::pretty_time( $general_stats['ga:avgSessionDuration'] ) : 0,
					),

					'bounce_rate'      => array(
						'raw'    => $general_stats['ga:bounceRate'],
						'number' => $general_stats['ga:bounceRate'] ? WPANALYTIFY_Utils::pretty_numbers( $general_stats['ga:bounceRate'] ) : 0,
					),

					'pages_session'    => array(
						'raw'    => $general_stats['ga:pageviewsPerSession'],
						'number' => $general_stats['ga:pageviewsPerSession'] ? round( $general_stats['ga:pageviewsPerSession'], 2 ) : 0,
					),

					'new_sessions'     => array(
						'raw'    => $general_stats['ga:percentNewSessions'],
						'number' => $general_stats['ga:percentNewSessions'] ? WPANALYTIFY_Utils::pretty_numbers( $general_stats['ga:percentNewSessions'] ) : 0,
					),
				);
			}

			if ( isset( $compare_stats_raw['totalsForAllResults'] ) ) {
				$compare_stats = array(
					'sessions'         => $compare_stats_raw['totalsForAllResults']['ga:sessions'],
					'visitors'         => $compare_stats_raw['totalsForAllResults']['ga:users'],
					'pageviews'        => $compare_stats_raw['totalsForAllResults']['ga:pageviews'],
					'avg_time_on_site' => $compare_stats_raw['totalsForAllResults']['ga:avgSessionDuration'],
					'bounce_rate'      => $compare_stats_raw['totalsForAllResults']['ga:bounceRate'],
					'pages_session'    => $compare_stats_raw['totalsForAllResults']['ga:pageviewsPerSession'],
					'new_sessions'     => $compare_stats_raw['totalsForAllResults']['ga:percentNewSessions'],
				);
			}

			if ( isset( $new_returning_stats_raw['rows'][0][1] ) ) {
				$chart_description['new_vs_returning_visitors']['stats']['new']['number'] = $new_returning_stats_raw['rows'][0][1];
			}

			if ( isset( $new_returning_stats_raw['rows'][1][1] ) ) {
				$chart_description['new_vs_returning_visitors']['stats']['returning']['number'] = $new_returning_stats_raw['rows'][1][1];
			}

			if ( isset( $device_category_stats_raw['rows'] ) && $device_category_stats_raw['rows'] ) {
				foreach ( $device_category_stats_raw['rows'] as $device ) {
					$chart_description['visitor_devices']['stats'][ $device[0] ]['number'] = $device[1];
				}
			}

			if ( isset( $general_stats_raw['totalsForAllResults']['ga:sessionDuration'] ) ) {
				$footer_description = apply_filters( 'analytify_general_stats_footer', $general_stats_raw['totalsForAllResults']['ga:sessionDuration'], array( $this->start_date, $this->end_date ) );
			}
		}

		foreach ( $boxes_description as $key => $box ) {
			if ( isset( $boxes_stats[ $key ] ) ) {
				$boxes_description[ $key ]['number'] = (string) $boxes_stats[ $key ]['number'];
				if ( isset( $compare_stats[ $key ] ) ) {
					$boxes_description[ $key ]['bottom'] = $this->compare_stat( $boxes_stats[ $key ]['raw'], $compare_stats[ $key ], $key );
				}
			}
		}

		return array(
			'success' => true,
			'boxes'   => apply_filters( 'analytify_general_stats_boxes', $boxes_description, array( $this->start_date, $this->end_date ) ),
			'charts'  => apply_filters( 'analytify_general_stats_charts', $chart_description, array( $this->start_date, $this->end_date ) ),
			'footer'  => $footer_description,
		);
	}

	/**
	 * Endpoint for 'Top pages by views'.
	 *
	 * @return array
	 */
	private function top_pages_stats() {

		// API limit for pages.
		$api_limit = apply_filters( 'analytify_api_limit_top_pages_stats', 50, 'dashboard' );

		// Site URL.
		$site_url = $this->get_profile_info( 'website_url' );

		$stats = array();

		if ( 'ga4' === $this->ga_mode ) {
			$stats_raw = $this->wp_analytify->get_reports('show-default-top-pages-dashboard', array(
					'screenPageViews',
					'averageSessionDuration',
					'bounceRate',
				), $this->get_dates(), array(
					'pageTitle',
					'pagePath',
				), array(
					'type'  => 'metric',
					'name'  => 'screenPageViews',
					'order' => 'desc',
				), array(
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
				), $api_limit);
			if ( $stats_raw['rows'] ) {
				$no = 1;
				foreach ( $stats_raw['rows'] as $row ) {
					$views = $row['screenPageViews'] ? WPANALYTIFY_Utils::pretty_numbers( $row['screenPageViews'] ) : 0;
					if ( $views < 1 ) {
						continue;
					}
					$stats[] = array(
						'no'                     => null,
						'pageTitle'              => '<a href="' . $site_url . $row['pagePath'] . '" target="_blank">' . $row['pageTitle'] . '</a>',
						'screenPageViews'        => $views,
						'userEngagementDuration' => $row['averageSessionDuration'] ? WPANALYTIFY_Utils::pretty_time( $row['averageSessionDuration'] ) : 0,
						'bounceRate'             => $row['bounceRate'] ? WPANALYTIFY_Utils::fraction_to_percentage( $row['bounceRate'] ) . '%' : 0,
					);
				}
			}
		} else {
			$stats_raw = $this->wp_analytify->pa_get_analytics_dashboard( 'ga:pageviews,ga:avgTimeOnPage,ga:bounceRate', $this->start_date, $this->end_date, 'ga:PageTitle,ga:pagePath', '-ga:pageviews', false, $api_limit, 'show-default-top-pages-dashboard' );
			if ( isset( $stats_raw['rows'] ) && $stats_raw['rows'] ) {
				$no = 1;
				foreach ( $stats_raw['rows'] as $row ) {
					$stats[] = array(
						'no'                     => null,
						'pageTitle'              => '<a href="' . $site_url . $row[1] . '" target="_blank">' . $row[0] . '</a>',
						'screenPageViews'        => $row[2] ? WPANALYTIFY_Utils::pretty_numbers( $row[2] ) : 0,
						'userEngagementDuration' => $row[3] ? WPANALYTIFY_Utils::pretty_time( $row[3] ) : 0,
						'bounceRate'             => ( $row[4] ? WPANALYTIFY_Utils::pretty_numbers( $row[4] ) : 0 ) . '%',
					);
				}
			}
		}

		return array(
			'success'    => true,
			'headers'    => array(
				'no'                     => array(
					'label'    => esc_html__( '#', 'wp-analytify' ),
					'type'     => 'counter',
					'th_class' => 'analytify_num_row',
					'td_class' => 'analytify_txt_center',
				),
				'pageTitle'              => array(
					'label'    => esc_html__( 'Title', 'wp-analytify' ),
					'th_class' => 'analytify_txt_left',
					'td_class' => '',
				),
				'screenPageViews'        => array(
					'label'    => esc_html__( 'Views', 'wp-analytify' ),
					'th_class' => 'analytify_value_row',
					'td_class' => 'analytify_txt_center analytify_value_row',
				),
				'userEngagementDuration' => array(
					'label'    => esc_html__( 'Avg. Time', 'wp-analytify' ),
					'th_class' => 'analytify_value_row',
					'td_class' => 'analytify_txt_center analytify_value_row',
				),
				'bounceRate'             => array(
					'label'    => esc_html__( 'Bounce Rate', 'wp-analytify' ),
					'th_class' => 'analytify_value_row',
					'td_class' => 'analytify_txt_center analytify_value_row',
				),
			),
			'stats'      => $stats,
			'pagination' => true,
			'footer'     => apply_filters( 'analytify_top_pages_footer', __( 'Top pages and posts.', 'wp-analytify' ), array( $this->start_date, $this->end_date ) ),
		);
	}

	/**
	 * Get Geography Stats (country and cities).
	 *
	 * @return array
	 */
	private function geographic_stats() {

		$this->set_compare_dates();

		// Limit for the table data.
		$country_limit = apply_filters( 'analytify_api_limit_country_stats', 5, 'dashboard' );

		// API limit for cities.
		$cities_limit = apply_filters( 'analytify_api_limit_city_stats', 5, 'dashboard' );

		$geo_map_data  = array();
		$country_stats = array();
		$city_stats    = array();

		$after_top_country_text = '';
		$after_top_city_text    = '';

		/**
		 * For Pro legacy support.
		 * CSV export button in generated by this action.
		 */
		ob_start();
		do_action( 'analytify_after_top_country_text' );
		$after_top_country_text .= ob_get_clean();

		ob_start();
		do_action( 'analytify_after_top_city_text' );
		$after_top_city_text .= ob_get_clean();

		if ( 'ga4' === $this->ga_mode ) {

			$dashboard_profile_id = WPANALYTIFY_Utils::get_reporting_property();
			$report_url           = WP_ANALYTIFY_FUNCTIONS::get_ga_report_url( $dashboard_profile_id );

			$after_top_country_text .= ' <a href="javascript: return false;" data-ga-dashboard-link="' . WPANALYTIFY_Utils::get_all_stats_link( $report_url, 'top_countries' ) . '" target="_blank" class="analytify_tooltip"><span class="analytify_tooltiptext">' . __( 'View All Top Countries', 'wp-analytify' ) . '</span><span aria-hidden="true" class="dashicons dashicons-external"></span></a>';

			$after_top_city_text .= ' <a href="javascript: return false;" data-ga-dashboard-link="' . WPANALYTIFY_Utils::get_all_stats_link( $report_url, 'top_cities' ) . '" target="_blank" class="analytify_tooltip"><span class="analytify_tooltiptext">' . __( 'View All Top Cities', 'wp-analytify' ) . '</span><span aria-hidden="true" class="dashicons dashicons-external"></span></a>';

			$country_stats_raw = $this->wp_analytify->get_reports(
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
				)
			);

			$city_stats_raw = $this->wp_analytify->get_reports(
				'show-geographic-cities-dashboard',
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
				$cities_limit
			);

			if ( $country_stats_raw['rows'] ) {
				$country_count = 0;
				foreach ( $country_stats_raw['rows'] as $row ) {
					if ( $country_count < $country_limit ) {
						$country_stats[] = array(
							'country'  => '<span class="analytify_' . str_replace( ' ', '_', strtolower( $row['country'] ) ) . ' analytify_flages"></span> ' . $row['country'],
							'sessions' => $row['sessions'],
						);
					}
					if ( 'United States' === $row['country'] ) {
						$row['country'] = 'United States of America';
					}
					$geo_map_data[] = $row;
					$country_count++;
				}
			}

			if ( $city_stats_raw['rows'] ) {
				foreach ( $city_stats_raw['rows'] as $row ) {
					$city_stats[] = array(
						'city'     => '<span class="analytify_' . str_replace( ' ', '_', strtolower( $row['country'] ) ) . ' analytify_flages"></span> ' . $row['city'],
						'sessions' => $row['sessions'],
					);
				}
			}
		} else {

			$country_stats_raw = $this->wp_analytify->pa_get_analytics_dashboard( 'ga:sessions', $this->start_date, $this->end_date, 'ga:country', '-ga:sessions', 'ga:country!=(not set)', false, 'show-geographic-countries-dashboard' );

			$city_stats_raw = $this->wp_analytify->pa_get_analytics_dashboard( 'ga:sessions', $this->start_date, $this->end_date, 'ga:city,ga:country', '-ga:sessions', 'ga:city!=(not set);ga:country!=(not set)', $cities_limit, 'show-geographic-cities-dashboard' );

			// Add keys to the array, to match GA4.
			if ( isset( $country_stats_raw['rows'] ) && $country_stats_raw['rows'] ) {
				$country_count = 0;
				foreach ( $country_stats_raw['rows'] as $row ) {
					if ( $country_count < $country_limit ) {
						$country_stats[] = array(
							'country'  => '<span class="analytify_' . str_replace( ' ', '_', strtolower( $row[0] ) ) . ' analytify_flages"></span> ' . $row[0],
							'sessions' => $row[1],
						);
					}
					$geo_map_data[] = array(
						'sessions' => $row[1],
						'country'  => 'United States' === $row[0] ? 'United States of America' : $row[0],
					);
					$country_count++;
				}
			}

			// Add keys to the array, to match GA4.
			if ( isset( $city_stats_raw['rows'] ) && $city_stats_raw['rows'] ) {
				foreach ( $city_stats_raw['rows'] as $row ) {
					$city_stats[] = array(
						'city'     => '<span class="analytify_' . str_replace( ' ', '_', strtolower( $row[1] ) ) . ' analytify_flages"></span> ' . $row[0],
						'sessions' => $row[2],
					);
				}
			}
		}

		$country = array(
			'headers' => array(
				'country'  => array(
					'label'    => esc_html__( 'Top Countries', 'wp-analytify' ) . $after_top_country_text,
					'th_class' => 'analytify_txt_left analytify_vt_middle analytify_top_geographic_detials_wraper',
					'td_class' => '',
				),
				'sessions' => array(
					'label'    => esc_html__( 'Visitors', 'wp-analytify' ),
					'th_class' => 'analytify_value_row',
					'td_class' => 'analytify_txt_center',
				),
			),
			'stats'   => $country_stats,
		);

		$city = array(
			'headers' => array(
				'city'     => array(
					'label'    => esc_html__( 'Top Cities', 'wp-analytify' ) . $after_top_city_text,
					'th_class' => 'analytify_txt_left analytify_vt_middle analytify_top_geographic_detials_wraper analytify_brd_lft',
					'td_class' => 'analytify_boder_left',
				),
				'sessions' => array(
					'label'    => esc_html__( 'Visitors', 'wp-analytify' ),
					'th_class' => 'analytify_value_row',
					'td_class' => 'analytify_txt_center',
				),
			),
			'stats'   => $city_stats,
		);

		return array(
			'success' => true,
			'map'     => array(
				'title'   => esc_html__( 'Geographic Stats', 'wp-analytify' ),
				'label'   => array(
					'high' => esc_html__( 'Hight', 'wp-analytify' ),
					'low'  => esc_html__( 'Low', 'wp-analytify' ),
				),
				'stats'   => $geo_map_data,
				'highest' => ! empty( $geo_map_data ) ? max( array_column( $geo_map_data, 'sessions' ) ) + 1 : 1,
				'colors'  => apply_filters( 'analytify_world_map_colors', array( '#ff5252', '#ffbc00', '#448aff' ) ),
			),
			'country' => $country,
			'city'    => $city,
			'footer'  => apply_filters( 'analytify_top_country_city_footer', __( 'Top countries and cities.', 'wp-analytify' ), array( $this->start_date, $this->end_date ) ),
		);
	}

	/**
	 * Endpoint for 'Tech Stats'.
	 *
	 * @return array
	 */
	private function system_stats() {

		// API limit.
		$browser_stats_limit = apply_filters( 'analytify_api_limit_browser_stats', 5, 'dashboard' );
		$os_stats_limit      = apply_filters( 'analytify_api_limit_os_stats', 5, 'dashboard' );
		$mobile_stats_limit  = apply_filters( 'analytify_api_limit_mobile_stats', 5, 'dashboard' );

		$browser_stats = array();
		$os_stats      = array();
		$mobile_stats  = array();

		if ( 'ga4' === $this->ga_mode ) {

			$browser_stats_raw = $this->wp_analytify->get_reports('show-default-browser-dashboard', array(
					'sessions',
				), $this->get_dates(), array(
					'browser',
					'operatingSystem',
				), array(
					'type'  => 'metric',
					'name'  => 'sessions',
					'order' => 'desc',
				), array(
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
				), $browser_stats_limit);

			$os_stats_raw = $this->wp_analytify->get_reports('show-default-os-dashboard', array(
					'sessions',
				), $this->get_dates(), array(
					'operatingSystem',
					'operatingSystemVersion',
				), array(
					'type'  => 'metric',
					'name'  => 'sessions',
					'order' => 'desc',
				), array(
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
				), $os_stats_limit);

			$mobile_stats_raw = $this->wp_analytify->get_reports('show-default-mobile-dashboard', array(
					'sessions',
				), $this->get_dates(), array(
					'mobileDeviceBranding',
					'mobileDeviceModel',
				), array(
					'type'  => 'metric',
					'name'  => 'sessions',
					'order' => 'desc',
				), array(
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
				), $mobile_stats_limit);

			if ( isset( $browser_stats_raw['rows'] ) && $browser_stats_raw['rows'] ) {
				foreach ( $browser_stats_raw['rows'] as $row ) {
					$browser_stats[] = array(
						'browser'  => '<span class="' . pretty_class( $row['browser'] ) . ' analytify_social_icons"></span>' . '<span class="' . pretty_class( $row['operatingSystem'] ) . ' analytify_social_icons"></span>' . $row['browser'] . ' ' . $row['operatingSystem'],
						'sessions' => $row['sessions'],
					);
				}
			}

			if ( isset( $os_stats_raw['rows'] ) && $os_stats_raw['rows'] ) {
				foreach ( $os_stats_raw['rows'] as $row ) {
					$os_stats[] = array(
						'os'       => '<span class="' . pretty_class( $row['operatingSystem'] ) . ' analytify_social_icons"></span> ' . $row['operatingSystem'] . ' ' . $row['operatingSystemVersion'],
						'sessions' => $row['sessions'],
					);
				}
			}

			if ( isset( $mobile_stats_raw['rows'] ) && $mobile_stats_raw['rows'] ) {
				foreach ( $mobile_stats_raw['rows'] as $row ) {
					$mobile_stats[] = array(
						'mobile'   => '<span class="' . pretty_class( $row['mobileDeviceBranding'] ) . ' analytify_social_icons"></span> ' . $row['mobileDeviceBranding'] . ' ' . $row['mobileDeviceModel'],
						'sessions' => $row['sessions'],
					);
				}
			}
		} else {

			$browser_stats_raw = $this->wp_analytify->pa_get_analytics_dashboard( 'ga:sessions', $this->start_date, $this->end_date, 'ga:browser,ga:operatingSystem', '-ga:sessions', 'ga:browser!=(not set);ga:operatingSystem!=(not set)', $browser_stats_limit, 'show-default-browser-dashboard' );

			$os_stats_raw = $this->wp_analytify->pa_get_analytics_dashboard( 'ga:sessions', $this->start_date, $this->end_date, 'ga:operatingSystem,ga:operatingSystemVersion', '-ga:sessions', 'ga:operatingSystemVersion!=(not set)', $os_stats_limit, 'show-default-os-dashboard' );

			$mobile_stats_raw = $this->wp_analytify->pa_get_analytics_dashboard( 'ga:sessions', $this->start_date, $this->end_date, 'ga:mobileDeviceBranding,ga:mobileDeviceModel', '-ga:sessions', 'ga:mobileDeviceModel!=(not set);ga:mobileDeviceBranding!=(not set)', $mobile_stats_limit, 'show-default-mobile-dashboard' );

			if ( isset( $browser_stats_raw['rows'] ) && $browser_stats_raw['rows'] ) {
				foreach ( $browser_stats_raw['rows'] as $row ) {
					$browser_stats[] = array(
						'browser'  => '<span class="' . pretty_class( $row[0] ) . ' analytify_social_icons"></span>' . '<span class="' . pretty_class( $row[1] ) . ' analytify_social_icons"></span>' . $row[0] . ' ' . $row[1],
						'sessions' => $row[2],
					);
				}
			}

			if ( isset( $os_stats_raw['rows'] ) && $os_stats_raw['rows'] ) {
				foreach ( $os_stats_raw['rows'] as $row ) {
					$os_stats[] = array(
						'os'       => '<span class="' . pretty_class( $row[0] ) . ' analytify_social_icons"></span> ' . $row[0] . ' ' . $row[1],
						'sessions' => WPANALYTIFY_Utils::pretty_numbers( $row[2] ),
					);
				}
			}

			if ( isset( $mobile_stats_raw['rows'] ) && $mobile_stats_raw['rows'] ) {
				foreach ( $mobile_stats_raw['rows'] as $row ) {
					$mobile_stats[] = array(
						'mobile'   => '<span class="' . pretty_class( $row[0] ) . ' analytify_social_icons"></span> ' . $row[0] . ' ' . $row[1],
						'sessions' => WPANALYTIFY_Utils::pretty_numbers( $row[2] ),
					);
				}
			}
		}

		/**
		 * For Pro legacy support.
		 * CSV export button in generated by this action.
		 */

		$after_top_browser_text          = '';
		$after_top_operating_system_text = '';
		$after_top_mobile_device_text    = '';

		ob_start();
		do_action( 'analytify_after_top_browser_text' );
		$after_top_browser_text .= ob_get_clean();

		ob_start();
		do_action( 'analytify_after_top_operating_system_text' );
		$after_top_operating_system_text .= ob_get_clean();

		ob_start();
		do_action( 'analytify_after_top_mobile_device_text' );
		$after_top_mobile_device_text .= ob_get_clean();

		$browser = array(
			'headers' => array(
				'browser'  => array(
					'label'    => esc_html__( 'Browsers statistics', 'wp-analytify' ) . $after_top_browser_text,
					'th_class' => 'analytify_txt_left analytify_top_geographic_detials_wraper',
					'td_class' => '',
				),
				'sessions' => array(
					'label'    => esc_html__( 'Visits', 'wp-analytify' ),
					'th_class' => 'analytify_value_row',
					'td_class' => 'analytify_txt_center',
				),
			),
			'stats'   => $browser_stats,
		);

		$os = array(
			'headers' => array(
				'os'       => array(
					'label'    => esc_html__( 'Operating system statistics', 'wp-analytify' ) . $after_top_operating_system_text,
					'th_class' => 'analytify_txt_left analytify_top_geographic_detials_wraper analytify_brd_lft',
					'td_class' => 'analytify_boder_left',
				),
				'sessions' => array(
					'label'    => esc_html__( 'Visits', 'wp-analytify' ),
					'th_class' => 'analytify_value_row',
					'td_class' => 'analytify_txt_center',
				),
			),
			'stats'   => $os_stats,
		);

		$mobile = array(
			'headers' => array(
				'mobile'   => array(
					'label'    => esc_html__( 'Mobile device statistics', 'wp-analytify' ) . $after_top_mobile_device_text,
					'th_class' => 'analytify_txt_left analytify_top_geographic_detials_wraper analytify_brd_lft',
					'td_class' => 'analytify_boder_left',
				),
				'sessions' => array(
					'label'    => esc_html__( 'Visits', 'wp-analytify' ),
					'th_class' => 'analytify_value_row',
					'td_class' => 'analytify_txt_center',
				),
			),
			'stats'   => $mobile_stats,
		);

		return array(
			'success' => true,
			'browser' => $browser,
			'os'      => $os,
			'mobile'  => $mobile,
			'footer'  => apply_filters( 'analytify_system_stats_footer', __( 'Top browsers and operating systems.', 'wp-analytify' ), array( $this->start_date, $this->end_date ) ),
		);
	}

	/**
	 * Endpoint for 'How people are finding you (keywords)'.
	 *
	 * @return array
	 */
	private function keyword_stats() {

		// API limit.
		$api_stats_limit = apply_filters( 'analytify_api_limit_keywords_stats', 10, 'dashboard' );

		$headers        = true;
		$keywords_stats = array();
		$total_sessions = '0';
		$success        = true;
		$error_message  = false;

		if ( 'ga4' === $this->ga_mode ) {

			$keyword_stats_raw = $this->wp_analytify->get_search_console_stats(
				'show-default-keyword-dashboard',
				$this->get_dates(),
				$api_stats_limit
			);

			if ( isset( $keyword_stats_raw['error']['status'] ) && isset( $keyword_stats_raw['error']['message'] ) ) {
				return array(
					'success'   => false,
					'error_box' => array(
						'title'   => __( 'Unable To Fetch Reports', 'wp-analytify' ),
						'content' => '<p class="analytify-promo-popup-paragraph analytify-error-popup-paragraph"><strong>' . __( 'Status:', 'wp-analytify' ) . ' </strong> ' . $keyword_stats_raw['error']['status'] . '</p><p class="analytify-promo-popup-paragraph analytify-error-popup-paragraph"><strong>' . __( 'Message:', 'wp-analytify' ) . ' </strong> ' . $keyword_stats_raw['error']['message'] . '</p>',
					),
				);
			}

			if ( isset( $keyword_stats_raw['response']['rows'] ) && $keyword_stats_raw['response']['rows'] > 0 ) {
				foreach ( $keyword_stats_raw['response']['rows'] as $row ) {
					$keywords_stats[] = array(
						'keyword_url' => $row['keys'][0],
						'impressions' => $row['impressions'],
						'clicks'      => $row['clicks'],
					);
				}
				$success = true;
				$headers = array(
					'keyword_url' => array(
						'label'    => esc_html__( 'Keywords', 'wp-analytify' ),
						'th_class' => 'analytify_txt_left analytify_link_title',
						'td_class' => '',
					),
					'impressions' => array(
						'label'    => esc_html__( 'Impressions', 'wp-analytify' ),
						'th_class' => 'analytify_value_row',
						'td_class' => 'analytify_txt_center analytify_value_row',
					),
					'clicks'      => array(
						'label'    => esc_html__( 'Clicks', 'wp-analytify' ),
						'th_class' => 'analytify_value_row',
						'td_class' => 'analytify_txt_center analytify_value_row',
					),
				);
			}
		} else {

			$keyword_stats_raw = $this->wp_analytify->pa_get_analytics_dashboard( 'ga:sessions', $this->start_date, $this->end_date, 'ga:keyword', '-ga:sessions', false, $api_stats_limit, 'show-default-keyword-dashboard' );

			if ( isset( $keyword_stats_raw['totalsForAllResults']['ga:sessions'] ) ) {
				$total_sessions = $keyword_stats_raw['totalsForAllResults']['ga:sessions'];
			}

			if ( isset( $keyword_stats_raw['rows'] ) && $keyword_stats_raw['rows'] ) {
				foreach ( $keyword_stats_raw['rows'] as $row ) {
					$bar = '';
					if ( $total_sessions && $total_sessions > 0 ) {
						$bar = ' <span class="analytify_bar_graph"><span style="width:' . ( $row[1] / $total_sessions ) * 100 . '%"></span></span>';
					}
					$keywords_stats[] = array(
						'keyword'  => $row[0] . $bar,
						'sessions' => $row[1],
					);
				}
			}

			if ( isset( $keyword_stats_raw['rows'] ) || isset( $keyword_stats_raw['totalsForAllResults']['ga:sessions'] ) ) {
				$success = true;
				$headers = array(
					'keyword'  => array(
						'label'    => false,
						'th_class' => 'analytify_txt_left analytify_link_title',
						'td_class' => '',
					),
					'sessions' => array(
						'label'    => false,
						'th_class' => 'analytify_value_row',
						'td_class' => 'analytify_txt_center analytify_value_row',
					),
				);
			}
		}

		return array(
			'success'       => $success,
			'error_message' => $error_message,
			'headers'       => $headers,
			'stats'         => $keywords_stats,
			'title_stats'   => $total_sessions != 0 ? '<span class="analytify_medium_f">' . __( 'Total Visits', 'wp-analytify' ) . '</span> ' . $total_sessions : false,
			'footer'        => apply_filters( 'analytify_keywords_footer', __( 'Ranked keywords.', 'wp-analytify' ), array( $this->start_date, $this->end_date ) ),
		);
	}

	/**
	 * Endpoint for 'Social Media' stats.
	 *
	 * @return array
	 */
	private function social_stats() {

		// API limit.
		$api_stats_limit = apply_filters( 'analytify_api_limit_social_media_stats', 5, 'dashboard' );

		$social_stats   = array();
		$total_sessions = false;

		if ( 'ga4' === $this->ga_mode ) {

			$social_stats_raw = $this->wp_analytify->get_reports('show-default-social-dashboard', array(
					'sessions',
				), $this->get_dates(), array(
					'sessionSource',
				), array(
					'type'  => 'metric',
					'name'  => 'sessions',
					'order' => 'desc',
				), array(
					'logic'   => 'AND',
					'filters' => array(
						array(
							'type'           => 'dimension',
							'name'           => 'sessionSource',
							'match_type'     => 5,
							'value'          => '^([a-z-]*\.|)(facebook|reddit|youtube|tumblr|quora|instagram|linkedin|yelp|wordpress|pinterest|twitter|t)(\.(com|org|co|)|)$',
							'not_expression' => false,
						),
					),
				), $api_stats_limit * 3);

			if ( isset( $social_stats_raw['rows'] ) && $social_stats_raw['rows'] && is_array( $social_stats_raw['rows'] ) ) {
				$social_stats_ga4_raw = WPANALYTIFY_Utils::ga4_social_stats( $social_stats_raw['rows'] );
				$total_sessions = 0;
				foreach ( $social_stats_ga4_raw as $row ) {
					$social_stats[] = array(
						'network'  => '<span class="' . pretty_class( $row['sessionSource'] ) . ' analytify_social_icons"></span> ' . $row['sessionSource'],
						'sessions' => WPANALYTIFY_Utils::pretty_numbers( $row['sessions'] ),
					);
					$total_sessions += $row['sessions'];
				}
			}
			// return array(
			// 	'success'   => false,
			// 	'error_box' => array(
			// 		'title'   => esc_html__( 'Reports Coming Soon For GA4', 'wp-analytify' ),
			// 		'content' => '<p class="analytify-promo-popup-paragraph analytify-error-popup-paragraph"><strong>' . esc_html__( 'Status: ' ) . '</strong>' . __( 'Reports are under development.', 'wp-analytify' ) . '</p><p class="analytify-promo-popup-paragraph analytify-error-popup-paragraph"><strong>' . esc_html__( 'Message: ', 'wp-analytify' ) . '</strong>' . esc_html__( 'Social media stats will be available in the future.', 'wp-analytify' ) . '</p>',
			// 	),
			// );

		} else {

			$social_stats_raw = $this->wp_analytify->pa_get_analytics_dashboard( 'ga:sessions', $this->start_date, $this->end_date, 'ga:socialNetwork', '-ga:sessions', 'ga:socialNetwork!=(not set)', $api_stats_limit, 'show-default-social-dashboard' );

			if ( isset( $social_stats_raw['totalsForAllResults']['ga:sessions'] ) ) {
				$total_sessions = $social_stats_raw['totalsForAllResults']['ga:sessions'];
			}

			if ( isset( $social_stats_raw['rows'] ) && $social_stats_raw['rows'] ) {
				foreach ( $social_stats_raw['rows'] as $row ) {
					$social_stats[] = array(
						'network'  => '<span class="' . pretty_class( $row[0] ) . ' analytify_social_icons"></span> ' . $row[0],
						'sessions' => WPANALYTIFY_Utils::pretty_numbers( $row[1] ),
					);
				}
			}
		}

		return array(
			'success'       => true,
			'error_message' => false,
			'headers'       => array(
				'network'  => array(
					'label'    => false,
					'th_class' => '',
					'td_class' => '',
				),
				'sessions' => array(
					'label'    => false,
					'th_class' => '',
					'td_class' => 'analytify_txt_center analytify_value_row',
				),
			),
			'stats'         => $social_stats,
			'title_stats'   => $total_sessions ? '<span class="analytify_medium_f">' . __( 'Total Visits', 'wp-analytify' ) . '</span> ' . $total_sessions : false,
			'footer'        => apply_filters( 'analytify_social_footer', __( 'Number of visitors coming from Social Channels.', 'wp-analytify' ), array( $this->start_date, $this->end_date ) ),
		);
	}

	/**
	 * Endpoint for 'Top Referer'.
	 *
	 * @return array
	 */
	private function get_referer_stats() {

		// API limit.
		$api_stats_limit = apply_filters( 'analytify_api_limit_referer_stats', 5, 'dashboard' );

		$referer_stats  = array();
		$total_sessions = false;

		if ( 'ga4' === $this->ga_mode ) {

			$referer_stats_raw = $this->wp_analytify->get_reports(
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
				$api_stats_limit
			);

			if ( isset( $referer_stats_raw['aggregations']['sessions'] ) ) {
				$total_sessions = $referer_stats_raw['aggregations']['sessions'];
			}

			if ( $referer_stats_raw['rows'] ) {
				foreach ( $referer_stats_raw['rows'] as $row ) {
					$bar = '';
					if ( $total_sessions && $total_sessions > 0 ) {
						$bar = ' <span class="analytify_bar_graph"><span style="width:' . ( $row['sessions'] / $total_sessions ) * 100 . '%"></span></span>';
					}
					$referer_stats[] = array(
						'referer'  => $row['sessionSource'] . '/' . $row['sessionMedium'] . $bar,
						'sessions' => $row['sessions'],
					);
				}
			}
		} else {

			$referer_stats_raw = $this->wp_analytify->pa_get_analytics_dashboard_via_rest( 'ga:sessions', $this->start_date, $this->end_date, 'ga:source,ga:medium', '-ga:sessions', false, $api_stats_limit, 'show-default-refferer' );

			if ( isset( $referer_stats_raw['totalsForAllResults']['ga:sessions'] ) ) {
				$total_sessions = $referer_stats_raw['totalsForAllResults']['ga:sessions'];
			}

			if ( isset( $referer_stats_raw['rows'] ) && $referer_stats_raw['rows'] ) {
				foreach ( $referer_stats_raw['rows'] as $row ) {
					$bar = '';
					if ( $total_sessions && $total_sessions > 0 ) {
						$bar = ' <span class="analytify_bar_graph"><span style="width:' . ( $row[2] / $total_sessions ) * 100 . '%"></span></span>';
					}
					$referer_stats[] = array(
						'referer'  => $row[0] . '/' . $row[1] . $bar,
						'sessions' => $row[2],
					);
				}
			}
		}

		return array(
			'success'     => true,
			'headers'     => array(
				'referer'  => array(
					'label'    => false,
					'th_class' => '',
					'td_class' => '',
				),
				'sessions' => array(
					'label'    => false,
					'th_class' => '',
					'td_class' => 'analytify_txt_center analytify_value_row',
				),
			),
			'stats'       => $referer_stats,
			'title_stats' => $total_sessions ? '<span class="analytify_medium_f">' . esc_html__( 'Total Visits', 'wp-analytify' ) . '</span> ' . $total_sessions : false,
			'footer'      => apply_filters( 'analytify_referer_footer', __( 'Top referrers to your website.', 'wp-analytify' ), array( $this->start_date, $this->end_date ) ),
		);
	}

	/**
	 * Endpoint for 'What's happening when users come to your site'.
	 *
	 * @return array
	 */
	private function get_what_is_happening_stats() {

		// API limit.
		$api_stats_limit = apply_filters( 'analytify_api_limit_what_happen_stats', 5, 'dashboard' );

		$what_happen_stats = array();
		$headers           = false;
		$footer            = false;

		if ( 'ga4' === $this->ga_mode ) {

			$page_stats_raw = $this->wp_analytify->get_reports(
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
				$api_stats_limit
			);

			if ( $page_stats_raw['rows'] ) {
				$num = 1;
				foreach ( $page_stats_raw['rows'] as $row ) {
					$what_happen_stats[] = array(
						'title_link'             => '<span class="analytify_page_name analytify_bullet_' . $num . '">' . $row['pageTitle'] . '</span><a target="_blank" href="' . $row['landingPage'] . '">' . $row['landingPage'] . '</a>',
						'userEngagementDuration' => WPANALYTIFY_Utils::pretty_time( $row['userEngagementDuration'] ),
						'engagedSessions'        => WPANALYTIFY_Utils::pretty_numbers( $row['engagedSessions'] ),
						'engagementRate'         => '<div class="analytify_enter_exit_bars">' . round( WPANALYTIFY_Utils::fraction_to_percentage( $row['engagementRate'] ), 2 ) . '<span class="analytify_persantage_sign">%</span><span class="analytify_bar_graph"><span style="width:' . round( WPANALYTIFY_Utils::fraction_to_percentage( $row['engagementRate'] ), 2 ) . '%"></span></span></div>',
					);
					$num++;
				}

				$headers = array(
					'title_link'             => array(
						'label'    => esc_html__( 'Title / Link', 'wp-analytify' ),
						'th_class' => 'analytify_txt_left analytify_link_title',
						'td_class' => 'analytify_page_url_detials',
					),
					'userEngagementDuration' => array(
						'label'    => esc_html__( 'User Engagement Duration', 'wp-analytify' ),
						'th_class' => 'analytify_compair_value_row',
						'td_class' => 'analytify_txt_center analytify_w_300 analytify_l_f',
					),
					'engagedSessions'        => array(
						'label'    => esc_html__( 'Engaged Sessions', 'wp-analytify' ),
						'th_class' => 'analytify_compair_value_row',
						'td_class' => 'analytify_txt_center analytify_w_300 analytify_l_f',
					),
					'engagementRate'         => array(
						'label'    => esc_html__( 'Engagement Rate', 'wp-analytify' ),
						'th_class' => 'analytify_compair_row',
						'td_class' => 'analytify_txt_center analytify_w_300 analytify_l_f',
					),
				);
			}
		} else {

			$what_happen_stats_raw = $this->wp_analytify->pa_get_analytics_dashboard_via_rest( 'ga:entrances,ga:exits,ga:entranceRate,ga:exitRate', $this->start_date, $this->end_date, 'ga:pageTitle,ga:pagePath', '-ga:entrances', false, $api_stats_limit, 'show-default-what-happen' );

			if ( isset( $what_happen_stats_raw['api_error'] ) ) {
				return array(
					'success'       => false,
					'error_message' => $what_happen_stats_raw['api_error'],
				);
			}

			if ( isset( $what_happen_stats_raw['rows'] ) && $what_happen_stats_raw['rows'] ) {
				$site_url = $this->get_profile_info( 'website_url' );
				$num      = 1;
				foreach ( $what_happen_stats_raw['rows'] as $row ) {

					$entrance_num = round( $row[4], 2 );
					$exit_num     = round( $row[5], 2 );

					$what_happen_stats[] = array(
						'title_link'    => '<span class="analytify_page_name analytify_bullet_' . $num . '">' . $row[0] . '</span><a target="_blank" href="' . $site_url . $row[1] . '">' . $row[1] . '</a>',
						'entrance'      => WPANALYTIFY_Utils::pretty_numbers( $row[2] ),
						'exits'         => WPANALYTIFY_Utils::pretty_numbers( $row[3] ),
						'entrance_exit' => '<div class="analytify_enter_exit_bars analytify_enter">' . $entrance_num . '<span class="analytify_persantage_sign">%</span><span class="analytify_bar_graph"><span style="width:' . $entrance_num . '%"></span></span></div><div class="analytify_enter_exit_bars">' . $exit_num . '<span class="analytify_persantage_sign">%</span><span class="analytify_bar_graph"><span style="width:' . $exit_num . '%"></span></span></div>',
					);
					$num++;
				}

				$headers = array(
					'title_link'    => array(
						'label'    => esc_html__( 'Title / Link', 'wp-analytify' ),
						'th_class' => 'analytify_txt_left analytify_link_title',
						'td_class' => 'analytify_page_url_detials',
					),
					'entrance'      => array(
						'label'    => esc_html__( 'Entrance', 'wp-analytify' ),
						'th_class' => 'analytify_compair_value_row',
						'td_class' => 'analytify_txt_center analytify_w_300 analytify_l_f',
					),
					'exits'         => array(
						'label'    => esc_html__( 'Exits', 'wp-analytify' ),
						'th_class' => 'analytify_compair_value_row',
						'td_class' => 'analytify_txt_center analytify_w_300 analytify_l_f',
					),
					'entrance_exit' => array(
						'label'    => esc_html__( 'Entrance% Exits%', 'wp-analytify' ),
						'th_class' => 'analytify_compair_row',
						'td_class' => 'analytify_txt_center analytify_w_300 analytify_l_f',
					),
				);

				$footer_text = sprintf( __( 'Did you know that %1$s people landed directly to your site at %2$s?', 'wp-analytify' ), WPANALYTIFY_Utils::pretty_numbers( $what_happen_stats_raw['rows'][0][2] ), $what_happen_stats_raw['rows'][0][1] );

				$footer = apply_filters( 'analytify_what_is_happening_footer', $footer_text, array( $this->start_date, $this->end_date ) );
			}
		}

		return array(
			'success' => true,
			'headers' => $headers,
			'stats'   => $what_happen_stats,
			'footer'  => $footer,
		);
	}

	/**
	 * Endpoint for all the stat sections on single post edit page.
	 *
	 * @return array
	 */
	private function get_single_post_stats() {
		$sections = array();

		/**
		 * Sections added by the Core:
		 * 'General Statistics', 'Scroll Depth Reach'.
		 *
		 * Section added by Pro:
		 * 'Geographic', 'System Stats', 'How people are finding you (keywords)',
		 * 'Social Media', 'Top Referrers', 'What's happening when users come to your page'.
		 *
		 * More sections, can be added via the filter.
		 */
		$sections = apply_filters( 'analytify_single_post_sections', $sections, $this->post_id, array( $this->start_date, $this->end_date ) );

		if ( ! $sections || ! is_array( $sections ) ) {
			$sections['success'] = false;
			$sections['message'] = esc_html__( 'No sections found.', 'wp-analytify' );
		} else {
			$sections['success'] = true;
			$sections['heading'] = sprintf( esc_html__( 'Displaying Analytics of this page from %1$s to %2$s.', 'wp-analytify' ), wp_date( 'jS F, Y', strtotime( $this->start_date ) ), wp_date( 'jS F, Y', strtotime( $this->end_date ) ) );
		}

		return $sections;
	}

	/**
	 * Adds 'General Statistics', 'Scroll Depth Reach' sections for single post stats.
	 *
	 * @param array $sections Sections.
	 * @param int   $post_id  Post id.
	 * @param array $date     Start and End date.
	 * @return array
	 */
	public function single_post_sections( $sections, $post_id, $date ) {

		$show_settings = $this->wp_analytify->settings->get_option( 'show_panels_back_end', 'wp-analytify-admin', array( 'show-overall-dashboard' ) );
		if ( empty( $show_settings ) || ( ! in_array( 'show-overall-dashboard', $show_settings, true ) && ! in_array( 'show-scroll-depth-stats', $show_settings, true ) ) ) {
			return $sections;
		}

		$report = new Analytify_Report(
			array(
				'dashboard_type' => 'single_post',
				'start_date'     => $date[0],
				'end_date'       => $date[1],
				'post_id'        => $post_id,
			)
		);

		if ( in_array( 'show-overall-dashboard', $show_settings, true ) ) {
			$general_stats = $report->get_general_stats();

			$sections['general_stats'] = array(
				'title' => esc_html__( 'General Statistics', 'wp-analytify' ),
				'type'  => 'boxes',
				'stats' => $general_stats['boxes'],
				// TODO: add footer.
				// 'footer' => apply_filters( 'analytify_general_stats_single_footer', $general_stats_footer, $post_id, $date ),
			);
		}

		if ( in_array( 'show-scroll-depth-stats', $show_settings, true ) && 'on' === $this->wp_analytify->settings->get_option( 'depth_percentage', 'wp-analytify-advanced' ) ) {

			$scroll_depth_stats = $report->get_scroll_depth_stats();

			$sections['scroll_depth'] = array(
				'title'       => esc_html__( 'Scroll Depth Reach', 'wp-analytify' ),
				'type'        => 'table',
				'table_class' => 'analytify_bar_tables',
				'headers'     => array(
					'percentage' => array(
						'label'    => esc_html__( 'Scroll Percentage', 'wp-analytify' ),
						'th_class' => 'analytify_txt_left',
						'td_class' => '',
					),
					'events'     => array(
						'label'    => esc_html__( 'Total Reached', 'wp-analytify' ),
						'th_class' => '',
						'td_class' => 'analytify_txt_center analytify_value_row',
					),
				),
				'stats'       => $scroll_depth_stats['stats'],
			);
		}

		return $sections;
	}

	/**
	 * Formate 'general_statistics' footer, add labels and description.
	 *
	 * @param string $number Number to format.
	 * @param array  $data   Start and End date.
	 *
	 * @return string
	 */
	public function general_stats_footer( $number, $data ) {
		return sprintf( __( 'Total time visitors spent on your site: %s?', 'wp-analytify' ), '<span class="analytify_red general_stats_message">' . WPANALYTIFY_Utils::pretty_time( $number ) . '</span>' );
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
	 * Sets compare dates based on the start an end dates.
	 *
	 * @return void
	 */
	private function set_compare_dates() {
		$date_diff = WPANALYTIFY_Utils::calculate_date_diff( $this->start_date, $this->end_date );
		if ( ! $date_diff ) {
			return;
		}

		$this->compare_start_date = $date_diff['start_date'];
		$this->compare_end_date   = $date_diff['end_date'];
		$this->compare_days       = $date_diff['diff_days'];
	}

	/**
	 * Compares current stat with the previous one and returns the formatted difference.
	 *
	 * @param int    $current_stat Current stat.
	 * @param int    $old_stat     Old stat to compare with.
	 * @param string $type         Type of stat (key).
	 *
	 * @return array
	 */
	private function compare_stat( $current_stat, $old_stat, $type ) {

		// Check for compare dates.
		if ( is_null( $this->compare_start_date ) || is_null( $this->compare_end_date ) || is_null( $this->compare_days ) ) {
			return false;
		}

		// So we don't divide by zero.
		if ( ! $old_stat || 0 == $old_stat ) {
			return false;
		}
		$number = number_format( ( ( $current_stat - $old_stat ) / $old_stat ) * 100, 2 );

		if ( 'bounce_rate' === $type ) {
			$arrow_type = ( $number < 0 ) ? 'analytify_green_inverted' : 'analytify_red_inverted';
		} else {
			$arrow_type = ( $number > 0 ) ? 'analytify_green' : 'analytify_red';
		}

		return array(
			'arrow_type' => $arrow_type,
			'main_text'  => $number . esc_html__( '%', 'wp-analytify' ),
			'sub_text'   => sprintf( esc_html__( '%s days ago', 'wp-analytify' ), $this->compare_days ),
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

}

/**
 * Init the instance.
 */
Analytify_Rest_API::get_instance();
