<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
 * Generates and returns reports - for pro version
 */
class Analytify_Report_Pro extends Analytify_Report_Abstract {

	/**
	 * Returns country stats.
	 *
	 * @return array
	 */
	public function get_country_stats( $type = 'limited' ) {
		$cache_key = $this->cache_key( 'countries' );

		// API limit.
		$api_limit = apply_filters( 'analytify_api_limit_country_stats', 210, $this->dashboard_type, $this->post_id, $type );

		if ( $this->is_ga4 ) {
			return $this->country_stats_ga4( $api_limit, $cache_key, $type );
		} else {
			return $this->country_stats_ua( $api_limit, $cache_key, $type );
		}
	}

	/**
	 * Generates country stats - GA4.
	 *
	 * @param int    $api_limit API limit.
	 * @param string $cache_key Cache key.
	 * @return array
	 */
	protected function country_stats_ga4( $api_limit, $cache_key, $type ) {

		$stats = array();

		$dimensions = array(
			'country',
		);
		$filters    = array(
			array(
				'type'           => 'dimension',
				'name'           => 'country',
				'match_type'     => 4,
				'value'          => '(not set)',
				'not_expression' => true,
			),
		);

		$raw = $this->wp_analytify->get_reports(
			$cache_key,
			array(
				'sessions',
			),
			$this->get_dates(),
			$this->attach_post_url_dimension( $dimensions ),
			array(
				'type'  => 'metric',
				'name'  => 'sessions',
				'order' => 'desc',
			),
			array(
				'logic'   => 'AND',
				'filters' => $this->attach_post_url_filter( $filters ),
			),
			$api_limit
		);

		if ( isset( $raw['rows'] ) && $raw['rows'] ) {

			if ( 'csv' !== $this->dashboard_type || 'full' !== $type ) {
				$raw['rows'] = array_slice( $raw['rows'], 0, 5 );
			}

			foreach ( $raw['rows'] as $row ) {
				$single_stat['country'] = $row['country'];
				if ( 'csv' !== $this->dashboard_type ) {
					$single_stat['country'] = '<span class="' . pretty_class( $row['country'] ) . ' analytify_flages"></span> ' . $row['country'];
				}
				$single_stat['sessions'] = WPANALYTIFY_Utils::pretty_numbers( $row['sessions'] );

				$stats[] = $single_stat;
			}
		}

		return array(
			'stats' => $stats,
		);
	}

	/**
	 * Generates country stats - UA.
	 *
	 * @param int    $api_limit API limit.
	 * @param string $cache_key Cache key.
	 * @return array
	 */
	protected function country_stats_ua( $api_limit, $cache_key, $type ) {
		$stats = array();

		$raw = $this->wp_analytify->pa_get_analytics( 'ga:sessions', $this->start_date, $this->end_date, 'ga:country', '-ga:sessions', 'ga:country!=(not set);' . $this->attach_ua_filter(), $api_limit, $cache_key );

		if ( isset( $raw['rows'] ) && $raw['rows'] ) {

			if ( 'csv' !== $this->dashboard_type || 'full' !== $type ) {
				$raw['rows'] = array_slice( $raw['rows'], 0, 5 );
			}

			foreach ( $raw['rows'] as $row ) {
				$single_stat['country'] = $row[0];
				if ( 'csv' !== $this->dashboard_type ) {
					$single_stat['country'] = '<span class="' . pretty_class( $row[0] ) . ' analytify_flages"></span> ' . $row[0];
				}
				$single_stat['sessions'] = WPANALYTIFY_Utils::pretty_numbers( $row[1] );

				$stats[] = $single_stat;
			}
		}

		return array(
			'stats' => $stats,
		);
	}

	/**
	 * Returns city stats.
	 *
	 * @return array
	 */
	public function get_city_stats() {
		$cache_key = $this->cache_key( 'cities' );

		// API limit.
		$default   = 'csv' === $this->dashboard_type ? 200 : 5;
		$api_limit = apply_filters( 'analytify_api_limit_city_stats', $default, $this->dashboard_type, $this->post_id );

		if ( $this->is_ga4 ) {
			return $this->city_stats_ga4( $api_limit, $cache_key );
		} else {
			return $this->city_stats_ua( $api_limit, $cache_key );
		}
	}

	/**
	 * Generates city stats - GA4.
	 *
	 * @param int    $api_limit API limit.
	 * @param string $cache_key Cache key.
	 * @return array
	 */
	protected function city_stats_ga4( $api_limit, $cache_key ) {
		$stats = array();

		$dimensions = array(
			'city',
			'country',
		);
		$filters    = array(
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
		);

		$raw = $this->wp_analytify->get_reports(
			$cache_key,
			array(
				'sessions',
			),
			$this->get_dates(),
			$this->attach_post_url_dimension( $dimensions ),
			array(
				'type'  => 'metric',
				'name'  => 'sessions',
				'order' => 'desc',
			),
			array(
				'logic'   => 'AND',
				'filters' => $this->attach_post_url_filter( $filters ),
			),
			$api_limit
		);

		if ( isset( $raw['rows'] ) && $raw['rows'] ) {
			foreach ( $raw['rows'] as $row ) {
				if ( 'csv' === $this->dashboard_type ) {
					$single_stat['country'] = $row['country'];
					$single_stat['city']    = $row['city'];
				} else {
					$single_stat['city'] = '<span class="' . pretty_class( $row['country'] ) . ' analytify_flages"></span> ' . $row['city'];
				}
				$single_stat['sessions'] = $row['sessions'];

				$stats[] = $single_stat;
			}
		}

		return array(
			'stats' => $stats,
		);
	}

	/**
	 * Generates city stats - UA.
	 *
	 * @param int    $api_limit API limit.
	 * @param string $cache_key Cache key.
	 * @return array
	 */
	protected function city_stats_ua( $api_limit, $cache_key ) {

		$stats = array();

		$raw = $this->wp_analytify->pa_get_analytics( 'ga:sessions', $this->start_date, $this->end_date, 'ga:city,ga:country', '-ga:sessions', 'ga:city!=(not set);ga:country!=(not set);' . $this->attach_ua_filter(), $api_limit, $cache_key );

		if ( isset( $raw['rows'] ) && $raw['rows'] ) {
			foreach ( $raw['rows'] as $row ) {
				if ( 'csv' === $this->dashboard_type ) {
					$single_stat['country'] = $row[1];
					$single_stat['city']    = $row[0];
				} else {
					$single_stat['city'] = '<span class="' . pretty_class( $row[1] ) . ' analytify_flages"></span> ' . $row[0];
				}
				$single_stat['sessions'] = WPANALYTIFY_Utils::pretty_numbers( $row[2] );

				$stats[] = $single_stat;
			}
		}

		return array(
			'stats' => $stats,
		);
	}

	/**
	 * Returns browser stats.
	 *
	 * @return array
	 */
	public function get_browser_stats() {
		$cache_key = $this->cache_key( 'browsers' );

		// API limit.
		$default   = 'csv' === $this->dashboard_type ? 100 : 5;
		$api_limit = apply_filters( 'analytify_api_limit_browser_stats', $default, $this->dashboard_type, $this->post_id );

		if ( $this->is_ga4 ) {
			return $this->browser_stats_ga4( $api_limit, $cache_key );
		} else {
			return $this->browser_stats_ua( $api_limit, $cache_key );
		}
	}

	/**
	 * Generates browser stats - GA4.
	 *
	 * @param int    $api_limit API limit.
	 * @param string $cache_key Cache key.
	 * @return array
	 */
	protected function browser_stats_ga4( $api_limit, $cache_key ) {

		$stats = array();

		$dimensions = array(
			'browser',
			'operatingSystem',
		);
		$filters    = array(
			array(
				'type'           => 'dimension',
				'name'           => 'operatingSystem',
				'match_type'     => 4,
				'value'          => '(not set)',
				'not_expression' => true,
			),
		);

		$raw = $this->wp_analytify->get_reports(
			$cache_key,
			array(
				'sessions',
			),
			$this->get_dates(),
			$this->attach_post_url_dimension( $dimensions ),
			array(
				'type'  => 'metric',
				'name'  => 'sessions',
				'order' => 'desc',
			),
			array(
				'logic'   => 'AND',
				'filters' => $this->attach_post_url_filter( $filters ),
			),
			$api_limit,
		);

		if ( isset( $raw['rows'] ) && $raw['rows'] ) {
			foreach ( $raw['rows'] as $row ) {

				if ( 'csv' === $this->dashboard_type ) {
					$single_stat['browser'] = $row['browser'];
					$single_stat['os']      = $row['operatingSystem'];
				} else {
					$single_stat['browser'] = '<span class="' . pretty_class( $row['browser'] ) . ' analytify_social_icons"></span><span class="' .  pretty_class( $row['operatingSystem'] ) . ' analytify_social_icons"></span>' . $row['browser'] . ' ' . $row['operatingSystem'];
				}
				$single_stat['sessions'] = WPANALYTIFY_Utils::pretty_numbers( $row['sessions'] );

				$stats[] = $single_stat;
			}
		}

		return array(
			'stats' => $stats,
		);
	}

	/**
	 * Generates browser stats - UA.
	 *
	 * @param int    $api_limit API limit.
	 * @param string $cache_key Cache key.
	 * @return array
	 */
	protected function browser_stats_ua( $api_limit, $cache_key ) {
		$stats = array();

		$raw = $this->wp_analytify->pa_get_analytics_dashboard( 'ga:sessions', $this->start_date, $this->end_date, 'ga:browser,ga:operatingSystem', '-ga:sessions', 'ga:browser!=(not set);ga:operatingSystem!=(not set);' . $this->attach_ua_filter(), $api_limit, $cache_key );

		if ( isset( $raw['rows'] ) && $raw['rows'] ) {
			foreach ( $raw['rows'] as $row ) {

				if ( 'csv' === $this->dashboard_type ) {
					$single_stat['browser'] = $row[0];
					$single_stat['os']      = $row[1];
				} else {
					$single_stat['browser'] = '<span class="' . pretty_class( $row[0] ) . ' analytify_social_icons"></span><span class="' . pretty_class( $row[1] ) . ' analytify_social_icons"></span>' . $row[0] . ' ' . $row[1];
				}
				$single_stat['sessions'] = WPANALYTIFY_Utils::pretty_numbers( $row[2] );

				$stats[] = $single_stat;
			}
		}

		return array(
			'stats' => $stats,
		);
	}

	/**
	 * Returns browser stats.
	 *
	 * @return array
	 */
	public function get_os_stats() {
		$cache_key = $this->cache_key( 'os' );

		// API limit.
		$default   = 'csv' === $this->dashboard_type ? 100 : 5;
		$api_limit = apply_filters( 'analytify_api_limit_os_stats', $default, $this->dashboard_type, $this->post_id );

		if ( $this->is_ga4 ) {
			return $this->os_stats_ga4( $api_limit, $cache_key );
		} else {
			return $this->os_stats_ua( $api_limit, $cache_key );
		}
	}

	/**
	 * Generates os stats - GA4.
	 *
	 * @param int    $api_limit API limit.
	 * @param string $cache_key Cache key.
	 * @return array
	 */
	protected function os_stats_ga4( $api_limit, $cache_key ) {

		$stats = array();

		$dimensions = array(
			'operatingSystem',
			'operatingSystemVersion',
		);
		$filters    = array(
			array(
				'type'           => 'dimension',
				'name'           => 'operatingSystemVersion',
				'match_type'     => 4,
				'value'          => '(not set)',
				'not_expression' => true,
			),
		);

		$raw = $this->wp_analytify->get_reports(
			$cache_key,
			array(
				'sessions',
			),
			$this->get_dates(),
			$this->attach_post_url_dimension( $dimensions ),
			array(
				'type'  => 'metric',
				'name'  => 'sessions',
				'order' => 'desc',
			),
			array(
				'logic'   => 'AND',
				'filters' => $this->attach_post_url_filter( $filters ),
			),
			$api_limit,
		);

		if ( isset( $raw['rows'] ) && $raw['rows'] ) {
			foreach ( $raw['rows'] as $row ) {

				if ( 'csv' === $this->dashboard_type ) {
					$single_stat['os']         = $row['operatingSystem'];
					$single_stat['os_version'] = $row['operatingSystemVersion'];
				} else {
					$single_stat['os'] = '<span class="' . pretty_class( $row['operatingSystem'] ) . ' analytify_social_icons"></span> ' . $row['operatingSystem'] . ' ' . $row['operatingSystemVersion'];
				}
				$single_stat['sessions'] = WPANALYTIFY_Utils::pretty_numbers( $row['sessions'] );

				$stats[] = $single_stat;
			}
		}

		return array(
			'stats' => $stats,
		);
	}

	/**
	 * Generates os stats - UA.
	 *
	 * @param int    $api_limit API limit.
	 * @param string $cache_key Cache key.
	 * @return array
	 */
	protected function os_stats_ua( $api_limit, $cache_key ) {
		$stats = array();

		$raw = $this->wp_analytify->pa_get_analytics_dashboard( 'ga:sessions', $this->start_date, $this->end_date, 'ga:operatingSystem,ga:operatingSystemVersion', '-ga:sessions', 'ga:operatingSystemVersion!=(not set);' . $this->attach_ua_filter(), $api_limit, $cache_key );

		if ( isset( $raw['rows'] ) && $raw['rows'] ) {
			foreach ( $raw['rows'] as $row ) {

				if ( 'csv' === $this->dashboard_type ) {
					$single_stat['os']         = $row[0];
					$single_stat['os_version'] = $row[1];
				} else {
					$single_stat['os'] = '<span class="' . pretty_class( $row[0] ) . ' analytify_social_icons"></span> ' . $row[0] . ' ' . $row[1];
				}
				$single_stat['sessions'] = WPANALYTIFY_Utils::pretty_numbers( $row[2] );

				$stats[] = $single_stat;
			}
		}

		return array(
			'stats' => $stats,
		);
	}

	/**
	 * Returns browser stats.
	 *
	 * @return array
	 */
	public function get_mobile_stats() {
		$cache_key = $this->cache_key( 'mobile' );

		// API limit.
		$default   = 'csv' === $this->dashboard_type ? 100 : 5;
		$api_limit = apply_filters( 'analytify_api_limit_mobile_stats', $default, $this->dashboard_type, $this->post_id );

		if ( $this->is_ga4 ) {
			return $this->mobile_stats_ga4( $api_limit, $cache_key );
		} else {
			return $this->mobile_stats_ua( $api_limit, $cache_key );
		}
	}

	/**
	 * Generates mobile stats - GA4.
	 *
	 * @param int    $api_limit API limit.
	 * @param string $cache_key Cache key.
	 * @return array
	 */
	protected function mobile_stats_ga4( $api_limit, $cache_key ) {

		$stats = array();

		$dimensions = array(
			'mobileDeviceBranding',
			'mobileDeviceModel',
		);
		$filters    = array(
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
		);

		$raw = $this->wp_analytify->get_reports(
			$cache_key,
			array(
				'sessions',
			),
			$this->get_dates(),
			$this->attach_post_url_dimension( $dimensions ),
			array(
				'type'  => 'metric',
				'name'  => 'sessions',
				'order' => 'desc',
			),
			array(
				'logic'   => 'AND',
				'filters' => $this->attach_post_url_filter( $filters ),
			),
			$api_limit,
		);

		if ( isset( $raw['rows'] ) && $raw['rows'] ) {
			foreach ( $raw['rows'] as $row ) {

				if ( 'csv' === $this->dashboard_type ) {
					$single_stat['mobile'] = $row['mobileDeviceModel'];
					$single_stat['brand']  = $row['mobileDeviceBranding'];
				} else {
					$single_stat['mobile'] = '<span class="' . pretty_class( $row['mobileDeviceBranding'] ) . ' analytify_social_icons"></span> ' . $row['mobileDeviceBranding'] . ' ' . $row['mobileDeviceModel'];
				}
				$single_stat['sessions'] = WPANALYTIFY_Utils::pretty_numbers( $row['sessions'] );

				$stats[] = $single_stat;
			}
		}

		return array(
			'stats' => $stats,
		);
	}

	/**
	 * Generates mobile stats - UA.
	 *
	 * @param int    $api_limit API limit.
	 * @param string $cache_key Cache key.
	 * @return array
	 */
	protected function mobile_stats_ua( $api_limit, $cache_key ) {
		$stats = array();

		$raw = $this->wp_analytify->pa_get_analytics_dashboard( 'ga:sessions', $this->start_date, $this->end_date, 'ga:mobileDeviceBranding,ga:mobileDeviceModel', '-ga:sessions', 'ga:mobileDeviceModel!=(not set);ga:mobileDeviceBranding!=(not set);' . $this->attach_ua_filter(), $api_limit, $cache_key );

		if ( isset( $raw['rows'] ) && $raw['rows'] ) {
			foreach ( $raw['rows'] as $row ) {

				if ( 'csv' === $this->dashboard_type ) {
					$single_stat['mobile'] = $row[0];
					$single_stat['brand']  = $row[1];
				} else {
					$single_stat['mobile'] = '<span class="' . pretty_class( $row[0] ) . ' analytify_social_icons"></span> ' . $row[0] . ' ' . $row[1];
				}
				$single_stat['sessions'] = WPANALYTIFY_Utils::pretty_numbers( $row[2] );

				$stats[] = $single_stat;
			}
		}

		return array(
			'stats' => $stats,
		);
	}

	/**
	 * Returns referer stats.
	 *
	 * @return array
	 */
	public function get_referrer_stats() {
		$cache_key = $this->cache_key( 'referrer' );

		// API limit.
		$default   = 'csv' === $this->dashboard_type ? 100 : 5;
		$api_limit = apply_filters( 'analytify_api_limit_referrer_stats', $default, $this->dashboard_type, $this->post_id );

		if ( $this->is_ga4 ) {
			return $this->referrer_stats_ga4( $api_limit, $cache_key );
		} else {
			return $this->referrer_stats_ua( $api_limit, $cache_key );
		}
	}

	/**
	 * Generates referrer stats - GA4.
	 *
	 * @param int    $api_limit API limit.
	 * @param string $cache_key Cache key.
	 * @return array
	 */
	protected function referrer_stats_ga4( $api_limit, $cache_key ) {
		$stats = array();

		$dimensions = array(
			'sessionSource',
			'sessionMedium',
		);
		$filters    = array();

		$raw = $this->wp_analytify->get_reports(
			$cache_key,
			array(
				'sessions',
			),
			$this->get_dates(),
			$this->attach_post_url_dimension( $dimensions ),
			array(
				'type'  => 'metric',
				'name'  => 'sessions',
				'order' => 'desc',
			),
			array(
				'logic'   => 'AND',
				'filters' => $this->attach_post_url_filter( $filters ),
			),
			$api_limit
		);

		if ( isset( $raw['aggregations']['sessions'] ) ) {
			$total_sessions = $raw['aggregations']['sessions'];
		}

		if ( isset( $raw['rows'] ) && $raw['rows'] ) {
			foreach ( $raw['rows'] as $row ) {

				if ( 'csv' === $this->dashboard_type ) {
					$single_stat['source'] = $row['sessionSource'];
					$single_stat['medium'] = $row['sessionMedium'];
				} else {
					$single_stat['referer'] = $row['sessionSource'] . '/' . $row['sessionMedium'];
					if ( $total_sessions && $total_sessions > 0 ) {
						$single_stat['referer'] .= ' <span class="analytify_bar_graph"><span style="width:' . ( $row['sessions'] / $total_sessions ) * 100 . '%"></span></span>';
					}
				}
				$single_stat['sessions'] = WPANALYTIFY_Utils::pretty_numbers( $row['sessions'] );

				$stats[] = $single_stat;
			}
		}

		return array(
			'stats' => $stats,
		);
	}

	/**
	 * Generates referrer stats - UA.
	 *
	 * @param int    $api_limit API limit.
	 * @param string $cache_key Cache key.
	 * @return array
	 */
	protected function referrer_stats_ua( $api_limit, $cache_key ) {
		$stats = array();

		$raw = $this->wp_analytify->pa_get_analytics_dashboard_via_rest( 'ga:sessions', $this->start_date, $this->end_date, 'ga:source,ga:medium', '-ga:sessions', $this->attach_ua_filter(), $api_limit, $cache_key );

		$total_sessions = false;
		if ( isset( $raw['totalsForAllResults']['ga:sessions'] ) ) {
			$total_sessions = $raw['totalsForAllResults']['ga:sessions'];
		}

		if ( isset( $raw['rows'] ) && $raw['rows']  ) {
			foreach ( $raw['rows'] as $row ) {

				if ( 'csv' === $this->dashboard_type ) {
					$single_stat['source'] = $row[0];
					$single_stat['medium'] = $row[1];
				} else {
					$single_stat['referer'] = $row[0] . '/' . $row[1];
					if ( $total_sessions && $total_sessions > 0 ) {
						$single_stat['referer'] .= ' <span class="analytify_bar_graph"><span style="width:' . ( $row[2] / $total_sessions ) * 100 . '%"></span></span>';
					}
				}
				$single_stat['sessions'] = WPANALYTIFY_Utils::pretty_numbers( $row[2] );

				$stats[] = $single_stat;
			}
		}

		return array(
			'stats' => $stats,
		);
	}

	/**
	 * Returns social media stats.
	 *
	 * @return array
	 */
	public function get_social_media_stats() {
		$cache_key = $this->cache_key( 'social' );

		// API limit.
		$default   = 'csv' === $this->dashboard_type ? 200 : 5;
		$api_limit = apply_filters( 'analytify_api_limit_social_media_stats', $default, $this->dashboard_type, $this->post_id );

		if ( $this->is_ga4 ) {
			// TODO: missing_ga4
			return false;
		} else {
			return $this->social_media_stats_ua( $api_limit, $cache_key );
		}
	}

	/**
	 * Social Media stats - UA.
	 *
	 * @param int    $api_limit API limit.
	 * @param string $cache_key Cache key.
	 * @return array
	 */
	private function social_media_stats_ua( $api_limit, $cache_key ) {
		$stats          = array();
		$total_sessions = 0;

		$raw = $this->wp_analytify->pa_get_analytics( 'ga:sessions', $this->start_date, $this->end_date, 'ga:socialNetwork', '-ga:sessions', 'ga:socialNetwork!=(not set);' . $this->attach_ua_filter(), $api_limit, $cache_key );

		if ( isset( $raw['totalsForAllResults']['ga:sessions'] ) ) {
			$total_sessions = $raw['totalsForAllResults']['ga:sessions'];
		}

		if ( isset( $raw['rows'] ) && $raw['rows'] ) {
			foreach ( $raw['rows'] as $row ) {

				if ( 'csv' === $this->dashboard_type ) {
					$single_stat['network'] = $row[0];
				} else {
					$single_stat['network'] = '<span class="' . pretty_class( $row[0] ) . ' analytify_social_icons"></span> ' . $row[0];
				}
				$single_stat['sessions'] = WPANALYTIFY_Utils::pretty_numbers( $row[1] );

				$stats[] = $single_stat;
			}
		}

		return array(
			'stats'          => $stats,
			'total_sessions' => $total_sessions,
		);
	}

	/**
	 * Returns social media stats.
	 *
	 * @return array
	 */
	public function get_whats_happening_stats() {
		$cache_key = $this->cache_key( 'whats-happening' );

		// API limit.
		switch ( $this->dashboard_type ) {
			case 'single_post':
				$default = 1;
				break;
			case 'csv':
				$default = 100;
				break;
			default:
				$default = 5;
				break;
		}

		$api_limit = apply_filters( 'analytify_api_limit_what_happen_stats', $default, $this->dashboard_type, $this->post_id );

		if ( $this->is_ga4 ) {
			// TODO: missing_ga4
			return false;
		} else {
			return $this->what_happen_stats_ua( $api_limit, $cache_key );
		}
	}

	/**
	 * What's happening stats - UA.
	 *
	 * @param int    $api_limit API limit.
	 * @param string $cache_key Cache key.
	 * @return array
	 */
	private function what_happen_stats_ua( $api_limit, $cache_key ) {
		$stats = array();

		$raw = $this->wp_analytify->pa_get_analytics( 'ga:entrances,ga:exits,ga:entranceRate,ga:exitRate', $this->start_date, $this->end_date, 'ga:pagePath', '-ga:entrances', $this->attach_ua_filter(), $api_limit, $cache_key );

		$site_url = $this->get_profile_info( 'website_url' );

		if ( isset( $raw['rows'] ) && $raw['rows'] ) {
			$num = 1;
			foreach ( $raw['rows'] as $row ) {

				if ( 'csv' === $this->dashboard_type ) {
					$single_stat['title'] = $row[1];
					$single_stat['link']  = $row[0];
				} elseif ( 'single_post' !== $this->dashboard_type ) {
					$single_stat['title_link'] = '<span class="analytify_page_name analytify_bullet_' . $num . '">' . $row[0] . '</span><a target="_blank" href="' . $site_url . $row[1] . '">' . $row[1] . '</a>';
				}

				$single_stat['entrance'] = WPANALYTIFY_Utils::pretty_numbers( $row[2] );
				$single_stat['exits']    = WPANALYTIFY_Utils::pretty_numbers( $row[3] );

				if ( 'csv' !== $this->dashboard_type ) {
					$entrance_num = round( $row[4], 2 );
					$exit_num     = round( $row[5], 2 );

					$single_stat['percentage'] = '<div class="analytify_enter_exit_bars analytify_enter">' . $entrance_num . '<span class="analytify_persantage_sign">%</span><span class="analytify_bar_graph"><span style="width:' . $entrance_num . '%"></span></span></div><div class="analytify_enter_exit_bars">' . $exit_num . '<span class="analytify_persantage_sign">%</span><span class="analytify_bar_graph"><span style="width:' . $exit_num . '%"></span></span></div>';
				}

				$stats[] = $single_stat;
				$num++;
			}
		}

		return array(
			'stats' => $stats,
		);
	}
}
