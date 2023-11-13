<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Analytify_Report_Abstract' ) ) {
	/**
	 * Generates and returns reports
	 */
	abstract class Analytify_Report_Abstract {

		/**
		 * The main Analytify object.
		 *
		 * @var object
		 */
		protected $wp_analytify;

		/**
		 * Is reporting GA4 or not?
		 *
		 * @var boolean
		 */
		protected $is_ga4;

		/**
		 * Selected 'start state'.
		 *
		 * @var string
		 */
		protected $start_date;

		/**
		 * Selected 'End state'.
		 *
		 * @var string
		 */
		protected $end_date;

		/**
		 * Post ID.
		 *
		 * @var int
		 */
		protected $post_id;

		/**
		 * Post URL without the domain, with query string.
		 *
		 * @var string
		 */
		protected $post_url;

		/**
		 * Type of report.
		 * Can be 'dashboard', 'csv', 'single_post', 'email'.
		 *
		 * @var string
		 */
		protected $dashboard_type;

		/**
		 * Class constructor.
		 *
		 * @param array $args Arguments.
		 * @return void
		 */
		public function __construct( $args = array() ) {
			$this->wp_analytify = $GLOBALS['WP_ANALYTIFY'];
			$this->is_ga4       = method_exists( 'WPANALYTIFY_Utils', 'get_ga_mode' ) ? 'ga4' === WPANALYTIFY_Utils::get_ga_mode() : false;

			/**
			 * Setting default args.
			 */
			// Dashboard type - Can be 'dashboard', 'csv', 'single_post', 'email'.
			$this->dashboard_type = isset( $args['dashboard_type'] ) && in_array( $args['dashboard_type'], array( 'dashboard', 'csv', 'single_post', 'email' ), true ) ? $args['dashboard_type'] : 'dashboard';

			// Dates.
			$this->start_date = isset( $args['start_date'] ) ? $args['start_date'] : wp_date( 'Y-m-d', strtotime( '-30 days', current_time( 'timestamp' ) ) );
			$this->end_date   = isset( $args['end_date'] ) ? $args['end_date'] : wp_date( 'Y-m-d', current_time( 'timestamp' ) );

			// Post ID and URL.
			if ( 'single_post' === $this->dashboard_type ) {
				$this->post_id  = isset( $args['post_id'] ) ? $args['post_id'] : null;

				// URL.
				$permalink      = get_permalink( $this->post_id );

				$this->post_url = apply_filters( 'analytify_single_post_stats_url', $permalink, $this->post_id );
			}
		}

		/**
		 * Text holder for general stat boxes.
		 *
		 * @return array
		 */
		protected function general_stats_boxes() {
			return array(
				'sessions'         => array(
					'title'       => esc_html__( 'Sessions', 'wp-analytify' ),
					'value'       => '0',
					'description' => esc_html__( 'A session is a time period in which a user is actively engaged with your website.', 'wp-analytify' ),
					'append'      => false,
				),
				'visitors'         => array(
					'title'       => esc_html__( 'Visitors', 'wp-analytify' ),
					'value'       => '0',
					'description' => esc_html__( 'Users who complete a minimum of one session on your website.', 'wp-analytify' ),
					'append'      => false,
				),
				'page_views'       => array(
					'title'       => esc_html__( 'Page Views', 'wp-analytify' ),
					'value'       => '0',
					'description' => esc_html__( 'Total number of Page Views, these include repeated views.', 'wp-analytify' ),
					'append'      => false,
				),
				'avg_time_on_page' => array(
					'title'       => esc_html__( 'Avg. Time on Page', 'wp-analytify' ),
					'value'       => '0',
					'description' => esc_html__( 'Total time that a single user spends on your website.', 'wp-analytify' ),
					'append'      => false,
				),
				'bounce_rate'      => array(
					'title'       => esc_html__( 'Bounce Rate', 'wp-analytify' ),
					'value'       => '0',
					'description' => esc_html__( 'Percentage of single page visits (i.e number of visits in which a visitor leaves your website from the landing page without browsing your website).', 'wp-analytify' ),
					'append'      => '<span class="analytify_xl_f">%</span>',
				),
				'new_sessions'     => array(
					'title'       => esc_html__( '% New sessions', 'wp-analytify' ),
					'value'       => '0',
					'description' => esc_html__( 'A new session is a time period when a new user comes to your website and is actively engaged with your website.', 'wp-analytify' ),
					'append'      => '<span class="analytify_xl_f">%</span>',
				),
				'view_per_session' => array(
					'title'       => esc_html__( 'Engaged Sessions', 'wp-analytify' ),
					'value'       => '0',
					'description' => esc_html__( 'Number of page views by a user during a single session. Repeated views are counted.', 'wp-analytify' ),
					'append'      => false,
				),
			);
		}

		/**
		 * Attaches post URL dimension.
		 * Only if the dashboard type is 'single_post'.
		 *
		 * @param array $dimensions Dimensions.
		 * @return array
		 */
		protected function attach_post_url_dimension( $dimensions = array() ) {
			if ( 'single_post' === $this->dashboard_type ) {
				$dimensions[] = 'pagePath';
			}
			return $dimensions;
		}

		/**
		 * Attaches post URL filter to filters array.
		 * Only if the dashboard type is 'single_post'.
		 *
		 * @param array $filters Filters.
		 * @return array
		 */
		protected function attach_post_url_filter( $filters = array() ) {
			$link = apply_filters( 'analytify_sinlge_stats_permalink', $this->post_url );
			$u_post = parse_url( urldecode( $link ) );
			$filter = $u_post['path'];
			// change the page poth filter for site that use domain mapping.
			$filter = apply_filters( 'analytify_page_path_filter', $filter, $u_post );

			// Url have query string incase of WPML.
			if ( isset( $u_post['query'] )  ) {
				$filter .= '?' . $u_post['query'];
			}

			if ( 'single_post' === $this->dashboard_type ) {
				$filters[] = array(
					'type'       => 'dimension',
					'name'       => 'pagePath',
					'match_type' => 1,
					'value'      => $filter,
				);
				$filters[] = array(
					'type'           => 'dimension',
					'name'           => 'pagePath',
					'match_type'     => 4,
					'value'          => '(not set)',
					'not_expression' => true,
				);
			}
			return $filters;
		}

		/**
		 * Attaches post URL filter to be used with UA reports.
		 *
		 * @return string
		 */
		protected function attach_ua_filter() {
			$filter = false;
			if ( 'single_post' === $this->dashboard_type ) {
				$link = apply_filters( 'analytify_sinlge_stats_permalink', $this->post_url );
				$u_post = parse_url( urldecode( $link ) );
				$filter = 'ga:pagePath==' . $u_post['path'] . '';
				// change the page poth filter for site that use domain mapping.
				$filter = apply_filters( 'analytify_page_path_filter', $filter, $u_post );

				// Url have query string incase of WPML.
				if ( isset( $u_post['query'] )  ) {
					$filter .= '?' . $u_post['query'];
				}
	
				
			}
			return $filter;
		}

		/**
		 * Generates the cache key based on what type of dashboard is being displayed.
		 *
		 * @param string $key Cache Key.
		 * @return string
		 */
		protected function cache_key( $key ) {

			switch ( $this->dashboard_type ) {
				case 'single_post':
					$key = $key . '-' . $this->post_id;
					break;
				case 'csv':
					$key = $key . '-csv';
					break;
				default:
					break;
			}

			return $key;
		}

		/**
		 * Removes keys from sub-arrays.
		 *
		 * @param array $stats Stats.
		 * @return array
		 */
		protected function strip_child_keys( $stats ) {
			return array_map(
				function ( $item ) {
					return array_values( $item );
				},
				array_values( $stats )
			);
		}

		/**
		 * Returns start and end date as an array to be used for GA4's get_reports()
		 *
		 * @return array
		 */
		protected function get_dates() {
			return array(
				'start' => $this->start_date,
				'end'   => $this->end_date,
			);
		}

		/**
		 * Get profile related data based on the key (option) provided.
		 *
		 * @param string $key Option name.
		 * @return string|null
		 */
		protected function get_profile_info( $key ) {
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
	}
}
