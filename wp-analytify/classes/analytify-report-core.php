<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
 * Generates and returns reports
 */
class Analytify_Report extends Analytify_Report_Abstract {

	/**
	 * Hold numbers of general stats only.
	 * Can be used for generating footers.
	 *
	 * @var array
	 */
	private $general_stats_num = null;

	/**
	 * Undocumented function
	 *
	 * @return array
	 */
	public function get_general_stats() {

		$cache_key = $this->cache_key( 'general-stats' );

		if ( $this->is_ga4 ) {
			return $this->general_stats_ga4( $cache_key );
		} else {
			return $this->general_stats_ua( $cache_key );
		}

	}

	/**
	 * Generates browser stats - GA4.
	 *
	 * @param string $cache_key Cache key.
	 * @return array
	 */
	protected function general_stats_ga4( $cache_key ) {

		$boxes = $this->general_stats_boxes();
		unset( $boxes['new_sessions'] );

		$dimensions = array();
		$filters    = array();

		$raw = $this->wp_analytify->get_reports(
			$cache_key,
			array(
				'sessions',
				'totalUsers',
				'screenPageViews',
				'engagementRate',
				'bounceRate',
				'screenPageViewsPerSession',
				'averageSessionDuration',
			),
			$this->get_dates(),
			$this->attach_post_url_dimension( $dimensions ),
			array(),
			array(
				'logic'   => 'AND',
				'filters' => $this->attach_post_url_filter( $filters ),
			)
		);

		if ( isset( $raw['aggregations']['sessions'] ) ) {
			$boxes['sessions']['value']    = WPANALYTIFY_Utils::pretty_numbers( $raw['aggregations']['sessions'] );
			$general_stats_num['sessions'] = $raw['aggregations']['sessions'];
		}
		if ( isset( $raw['aggregations']['totalUsers'] ) ) {
			$boxes['visitors']['value']    = WPANALYTIFY_Utils::pretty_numbers( $raw['aggregations']['totalUsers'] );
			$general_stats_num['visitors'] = $raw['aggregations']['totalUsers'];
		}
		if ( isset( $raw['aggregations']['screenPageViews'] ) ) {
			$boxes['page_views']['value']    = WPANALYTIFY_Utils::pretty_numbers( $raw['aggregations']['screenPageViews'] );
			$general_stats_num['page_views'] = $raw['aggregations']['screenPageViews'];
		}
		if ( isset( $raw['aggregations']['averageSessionDuration'] ) ) {
			$boxes['avg_time_on_page']['value']    = WPANALYTIFY_Utils::pretty_time( $raw['aggregations']['averageSessionDuration'] );
			$general_stats_num['avg_time_on_page'] = $raw['aggregations']['averageSessionDuration'];
		}
		if ( isset( $raw['aggregations']['bounceRate'] ) ) {
			$boxes['bounce_rate']['value']    = WPANALYTIFY_Utils::fraction_to_percentage( $raw['aggregations']['bounceRate'] );
			$general_stats_num['bounce_rate'] = $raw['aggregations']['bounceRate'];
		}
		if ( isset( $raw['aggregations']['screenPageViewsPerSession'] ) ) {
			$boxes['view_per_session']['value']    = WPANALYTIFY_Utils::pretty_numbers( $raw['aggregations']['screenPageViewsPerSession'] );
			$general_stats_num['view_per_session'] = $raw['aggregations']['screenPageViewsPerSession'];
		}

		return array(
			'boxes' => $boxes,
		);
	}

	/**
	 * Generates browser stats - UA.
	 *
	 * @param string $cache_key Cache key.
	 * @return array
	 */
	protected function general_stats_ua( $cache_key ) {
		$boxes = $this->general_stats_boxes();
		unset( $boxes['view_per_session'] );

		$raw = $this->wp_analytify->pa_get_analytics_dashboard( 'ga:sessions,ga:users,ga:pageviews,ga:avgSessionDuration,ga:bounceRate,ga:pageviewsPerSession,ga:percentNewSessions,ga:newUsers,ga:sessionDuration', $this->start_date, $this->end_date, false, false, $this->attach_ua_filter(), false, $cache_key );

		if ( isset( $raw['totalsForAllResults']['ga:sessions'] ) ) {
			$boxes['sessions']['value']    = WPANALYTIFY_Utils::pretty_numbers( $raw['totalsForAllResults']['ga:sessions'] );
			$general_stats_num['sessions'] = $raw['totalsForAllResults']['ga:sessions'];
		}
		if ( isset( $raw['totalsForAllResults']['ga:users'] ) ) {
			$boxes['visitors']['value']    = WPANALYTIFY_Utils::pretty_numbers( $raw['totalsForAllResults']['ga:users'] );
			$general_stats_num['visitors'] = $raw['totalsForAllResults']['ga:users'];
		}
		if ( isset( $raw['totalsForAllResults']['ga:pageviews'] ) ) {
			$boxes['page_views']['value']    = WPANALYTIFY_Utils::pretty_numbers( $raw['totalsForAllResults']['ga:pageviews'] );
			$general_stats_num['page_views'] = $raw['totalsForAllResults']['ga:pageviews'];
		}
		if ( isset( $raw['totalsForAllResults']['ga:avgSessionDuration'] ) ) {
			$boxes['avg_time_on_page']['value']    = WPANALYTIFY_Utils::pretty_time( $raw['totalsForAllResults']['ga:avgSessionDuration'] );
			$general_stats_num['avg_time_on_page'] = $raw['totalsForAllResults']['ga:avgSessionDuration'];
		}
		if ( isset( $raw['totalsForAllResults']['ga:bounceRate'] ) ) {
			$boxes['bounce_rate']['value']    = WPANALYTIFY_Utils::pretty_numbers( $raw['totalsForAllResults']['ga:bounceRate'] );
			$general_stats_num['bounce_rate'] = $raw['totalsForAllResults']['ga:bounceRate'];
		}
		if ( isset( $raw['totalsForAllResults']['ga:percentNewSessions'] ) ) {
			$boxes['new_sessions']['value']    = WPANALYTIFY_Utils::pretty_numbers( $raw['totalsForAllResults']['ga:percentNewSessions'] );
			$general_stats_num['new_sessions'] = $raw['totalsForAllResults']['ga:percentNewSessions'];
		}

		return array(
			'boxes' => $boxes,
		);
	}

	/**
	 * Returns the simple stats for general stats.
	 * This is intended to be used for the footer or in some calculation.
	 *
	 * @return array
	 */
	public function get_general_stats_num() {
		return $this->general_stats_num;
	}

	/**
	 * Returns scroll depth stats.
	 *
	 * @return array
	 */
	public function get_scroll_depth_stats() {

		$cache_key = $this->cache_key( 'scroll-depth' );

		if ( $this->is_ga4 ) {
			return $this->scroll_depth_ga4( $cache_key );
		} else {
			return $this->scroll_depth_ua( $cache_key );
		}
	}

	/**
	 * Generates scroll depth stats - GA4.
	 *
	 * @param string $cache_key Cache key.
	 * @return array
	 */
	protected function scroll_depth_ga4( $cache_key ) {

		$stats = array();

		$dimensions = array(
			'customEvent:wpa_category',
			'customEvent:wpa_percentage',
		);
		$filters    = array(
			array(
				'type'       => 'dimension',
				'name'       => 'customEvent:wpa_category',
				'match_type' => 1,
				'value'      => 'Analytify Scroll Depth',
			),
			array(
				'type'           => 'dimension',
				'name'           => 'customEvent:wpa_percentage',
				'match_type'     => 4,
				'value'          => '(not set)',
				'not_expression' => true,
			),
		);

		$raw = $this->wp_analytify->get_reports(
			$cache_key,
			array(
				'eventCount',
			),
			$this->get_dates(),
			$this->attach_post_url_dimension( $dimensions ),
			array(),
			array(
				'logic'   => 'AND',
				'filters' => $this->attach_post_url_filter( $filters ),
			)
		);

		$total = 1;
		if ( isset( $raw['aggregations']['eventCount'] ) && $raw['aggregations']['eventCount'] > 0 ) {
			$total = $raw['aggregations']['eventCount'];
		}

		if ( isset( $raw['rows'] ) && $raw['rows'] ) {
			foreach ( $raw['rows'] as $row ) {
				if ( 'csv' === $this->dashboard_type ) {
					$single_stat['percentage'] = $row['customEvent:wpa_percentage'] . esc_html__( '%', 'wp-analytify' );
				} else {
					$bar = is_numeric( $row['eventCount'] ) ? round( ( $row['eventCount'] / $total ) * 100 ) : 0;

					$single_stat['percentage']  = esc_html( $row['customEvent:wpa_percentage'] ) . esc_html__( '%', 'wp-analytify' );
					$single_stat['percentage'] .= '<span class="analytify_bar_graph"><span style="width:' . $bar . '%"></span></span>';
				}
				$single_stat['events'] = esc_html( $row['eventCount'] );

				$stats[] = $single_stat;
			}
		}

		return array(
			'stats' => $stats,
		);
	}

	/**
	 * Generates scroll depth stats - UA.
	 *
	 * @param string $cache_key Cache key.
	 * @return array
	 */
	protected function scroll_depth_ua( $cache_key ) {

		$stats  = array();
		$filter = false;
		if ( 'single_post' === $this->dashboard_type ) {
			$filter = 'ga:eventLabel==' . $this->post_url;
		}

		$raw = $this->wp_analytify->pa_get_analytics( 'ga:totalEvents,ga:eventValue', $this->start_date, $this->end_date, 'ga:eventCategory,ga:eventAction,ga:eventLabel', false, $filter, false, $cache_key );

		$total = 1;
		if ( isset( $raw['totalsForAllResults']['ga:totalEvents'] ) && $raw['totalsForAllResults']['ga:totalEvents'] > 0 ) {
			$total = $raw['totalsForAllResults']['ga:totalEvents'];
		}

		$scroll_stats = isset( $stats['rows'] ) && $stats['rows'] ? $stats['rows'] : array();

		// Sort array in ascending order of depth threshold.
		usort(
			$scroll_stats,
			function( $a, $b ) {
				return $a[1] - $b[1];
			}
		);

		if ( $scroll_stats ) {
			foreach ( $scroll_stats as $row ) {
				if ( 'csv' === $this->dashboard_type ) {
					$single_stat['percentage'] = $row[1] . esc_html__( '%', 'wp-analytify' );
				} else {
					$bar = is_numeric( $row[3] ) ? round( ( $row[3] / $total ) * 100 ) : 0;

					$single_stat['percentage']  = esc_html( $row[1] ) . esc_html__( '%', 'wp-analytify' );
					$single_stat['percentage'] .= '<span class="analytify_bar_graph"><span style="width:' . $bar . '%"></span></span>';
				}
				$single_stat['events'] = esc_html( $row[3] );

				$stats[] = $single_stat;
			}
		}

		return array(
			'stats' => $stats,
		);
	}
}