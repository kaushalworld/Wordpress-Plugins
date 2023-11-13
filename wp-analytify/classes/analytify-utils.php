<?php
class WPANALYTIFY_Utils {

	/**
	 * Use wp_unslash if available, otherwise fall back to stripslashes_deep
	 *
	 * @param string|array $arg
	 *
	 * @since  2.0
	 * @return string|array
	 */
	public static function safe_wp_unslash( $arg ) {
		return function_exists( 'wp_unslash' ) ? wp_unslash( $arg ) : stripslashes_deep( $arg );
	}

	/**
	 * Check if tracking script is allowed on current page. 
	 *
	 * @return boolean
	 */
	public static function skip_page_tracking() {

		if ( ! is_singular() ) {
			return false;
		}
	
		global $post;

		if ( ! is_object( $post ) ) {
			return false;
		}
	
		return (bool) get_post_meta( $post->ID, '_analytify_skip_tracking', true );
	}

	/**
	 * Returns the timezone string for a site, even if it's set to a UTC offset.
	 *
	 * @return string
	 */
	// method was removed when the timezone filter was removed.
	// public static function timezone() {

	// 	$timezone_string = get_option( 'timezone_string' );
	// 	if ( empty( $timezone_string ) ) {
	// 		// Create a UTC+- zone if no timezone string exists.
	// 		$timezone_string = get_option( 'gmt_offset' );

	// 		$momentjs_tz_map = array(
	// 			'-12'    => 'Etc/GMT+12',
	// 			'-11.5'  => 'Pacific/Niue',
	// 			'-11'    => 'Pacific/Pago_Pago',
	// 			'-10.5'  => 'Pacific/Honolulu',
	// 			'-10'    => 'Pacific/Honolulu',
	// 			'-9.5'   => 'Pacific/Marquesas',
	// 			'-9'     => 'America/Anchorage',
	// 			'-8.5'   => 'Pacific/Pitcairn',
	// 			'-8'     => 'America/Los_Angeles',
	// 			'-7.5'   => 'America/Edmonton',
	// 			'-7'     => 'America/Denver',
	// 			'-6.5'   => 'Pacific/Easter',
	// 			'-6'     => 'America/Chicago',
	// 			'-5.5'   => 'America/Havana',
	// 			'-5'     => 'America/New_York',
	// 			'-4.5'   => 'America/Halifax',
	// 			'-4'     => 'America/Manaus',
	// 			'-3.5'   => 'America/St_Johns',
	// 			'-3'     => 'America/Sao_Paulo',
	// 			'-2.5'   => 'Atlantic/South_Georgia',
	// 			'-2'     => 'Atlantic/South_Georgia',
	// 			'-1.5'   => 'Atlantic/Cape_Verde',
	// 			'-1'     => 'Atlantic/Azores',
	// 			'-0.5'   => 'Atlantic/Reykjavik',
	// 			'0'      => 'Etc/UTC',
	// 			''       => 'Etc/UTC',
	// 			'0.5'    => 'Etc/UTC',
	// 			'1'      => 'Europe/Madrid',
	// 			'1.5'    => 'Europe/Belgrade',
	// 			'2'      => 'Africa/Tripoli',
	// 			'2.5'    => 'Asia/Amman',
	// 			'3'      => 'Europe/Moscow',
	// 			'3.5'    => 'Asia/Tehran',
	// 			'4'      => 'Europe/Samara',
	// 			'4.5'    => 'Asia/Kabul',
	// 			'5'      => 'Asia/Karachi',
	// 			'5.5'    => 'Asia/Kolkata',
	// 			'5.75'   => 'Asia/Kathmandu',
	// 			'6'      => 'Asia/Dhaka',
	// 			'6.5'    => 'Asia/Rangoon',
	// 			'7'      => 'Asia/Bangkok',
	// 			'7.5'    => 'Asia/Bangkok',
	// 			'8'      => 'Asia/Shanghai',
	// 			'8.5'    => 'Asia/Pyongyang',
	// 			'8.75'   => 'Australia/Eucla',
	// 			'9'      => 'Asia/Tokyo',
	// 			'9.5'    => 'Australia/Darwin',
	// 			'10'     => 'Australia/Brisbane',
	// 			'10.5'   => 'Australia/Adelaide',
	// 			'11'     => 'Australia/Melbourne',
	// 			'11.5'   => 'Pacific/Norfolk',
	// 			'12'     => 'Asia/Anadyr',
	// 			'12.75'  => 'Asia/Anadyr',
	// 			'13'     => 'Pacific/Fiji',
	// 			'13.75'  => 'Pacific/Chatham',
	// 			'14'     => 'Pacific/Tongatapu',
	// 		);

	// 		$timezone_string = isset( $momentjs_tz_map[$timezone_string] ) ? $momentjs_tz_map[$timezone_string] : 'Etc/UTC';
	// 	}

	// 	return $timezone_string;
	// }

	/**
	 * Pretty time to display.
	 *
	 * @param int $time time.
	 *
	 * @since  2.0
	 */
	public static function pretty_time( $time ) {

		 // Check if numeric.
		 if ( is_numeric( $time ) ) {

			 $value = array(
				 'years'   => '00',
				 'days'    => '00',
				 'hours'   => '',
				 'minutes' => '',
				 'seconds' => '',
			 );

			 $attach_hours = '';
			 $attach_min = '';
			 $attach_sec = '';
			 if ( $time >= 31556926 ) {
				 $value['years'] = floor( $time / 31556926 );
				 $time           = ($time % 31556926);
			 } //$time >= 31556926

			 if ( $time >= 86400 ) {
				 $value['days'] = floor( $time / 86400 );
				 $time          = ($time % 86400);
			 } //$time >= 86400
			 if ( $time >= 3600 ) {
				 $value['hours'] = str_pad( floor( $time / 3600 ), 1, 0, STR_PAD_LEFT );
				 $time           = ($time % 3600);
			 } //$time >= 3600
			 if ( $time >= 60 ) {
				 $value['minutes'] = str_pad( floor( $time / 60 ), 1, 0, STR_PAD_LEFT );
				 $time             = ($time % 60);
			 } //$time >= 60
			 $value['seconds'] = str_pad( floor( $time ), 1, 0, STR_PAD_LEFT );
			 // Get the hour:minute:second version.
			 if ( '' != $value['hours'] ) {
				 $attach_hours = '<span class="analytify_xl_f">' . _x( 'h', 'Hour Time', 'wp-analytify' ) . ' </span> ';
			 }
			 if ( '' != $value['minutes'] ) {
				 $attach_min = '<span class="analytify_xl_f">' . _x( 'm', 'Minute Time', 'wp-analytify' ) . ' </span>';
			 }
			 if ( '' != $value['seconds'] ) {
				 $attach_sec = '<span class="analytify_xl_f">' . _x( 's', 'Second Time', 'wp-analytify' ) . '</span>';
			 }
			 return $value['hours'] . $attach_hours . $value['minutes'] . $attach_min . $value['seconds'] . $attach_sec;
		 } //is_numeric($time)
		 else {
			 return false;
		 }
	 }

	/**
	 * Pretty numbers to display.
	 *
	 * @param int $time time.
	 *
	 * @since  2.0
	 */
	public static function pretty_numbers( $num ) {

		if ( ! is_numeric( $num ) ) {
			return $num;
		}

		return ( $num > 10000) ? round( ($num / 1000), 2 ) . 'k' : number_format( $num );

	}

	/**
	 * Convert fraction to percentage.
	 * 
	 * @param int $number
	 * 
	 * @since 5.0.0
	 */
	public static function fraction_to_percentage( $number ){
		return WPANALYTIFY_Utils::pretty_numbers( $number * 100 );
	}

	/**
	 * Check the current permalink structure
	 * and returns the correct delimeter to be
	 * used in url.
	 * 
	 * @since 5.0.0
	 */
	public static function get_delimiter(){
		$rest_url  = esc_url_raw( get_rest_url() );
		$delimiter = strpos( $rest_url, '/wp-json/' ) !== false ? '?' : '&';
		return $delimiter;
	}


	/**
	 * show coupon message to Free users Only.
	 */
	public static function is_active_pro() {

		return ( is_plugin_active( 'wp-analytify-pro/wp-analytify-pro.php' ) ) ? true : false;

	}


	/**
	 * Checks if a module is active, via options
	 *
	 * @param string $slug	slug of the module
	 * @return boolean
	 */
	public static function is_module_active ( $slug ) {

		$wp_analytify_modules = get_option( 'wp_analytify_modules' );

		return ( $wp_analytify_modules && isset( $wp_analytify_modules[$slug] ) && isset( $wp_analytify_modules[$slug]['status'] ) && 'active' === $wp_analytify_modules[$slug]['status'] ) ? true : false;

	}


	/**
	 * Show notices if some exception occurs.
	 *
	 * @param  array $exception exception details
	 *
	 * @since 2.0.5
	 */
	public static function handle_exceptions( $_exception_errors ) {


		if ( isset( $_exception_errors[0]['reason'] ) && $_exception_errors[0]['reason'] == 'dailyLimitExceeded' ) {
			add_action( 'admin_notices', array( 'WPANALYTIFY_Utils', 'daily_limit_exceed_error' ), 9 );
		} elseif ( isset( $_exception_errors[0]['reason'] ) && $_exception_errors[0]['reason'] == 'insufficientPermissions' && $_exception_errors[0]['domain'] == 'global') {
			add_action( 'admin_notices', array( 'WPANALYTIFY_Utils', 'no_profile_error' ), 9 );
		} elseif ( isset( $_exception_errors[0]['reason'] ) && $_exception_errors[0]['reason'] == 'insufficientPermissions' ) {
			add_action( 'admin_notices', array( 'WPANALYTIFY_Utils', 'insufficent_permissions_error' ), 9 );
		} elseif ( isset( $_exception_errors[0]['reason'] ) && $_exception_errors[0]['reason'] == 'usageLimits.userRateLimitExceededUnreg' ) {
			add_action( 'admin_notices', array( 'WPANALYTIFY_Utils', 'user_rate_limit_unreg_error' ), 9 );
		} elseif ( isset( $_exception_errors[0]['reason'] ) && $_exception_errors[0]['reason'] == 'userRateLimitExceeded' ) {
			add_action( 'admin_notices', array( 'WPANALYTIFY_Utils', 'user_rate_limit_error' ), 9 );
		} elseif ( isset( $_exception_errors[0]['reason'] ) && $_exception_errors[0]['reason'] == 'rateLimitExceeded' ) {
			add_action( 'admin_notices', array( 'WPANALYTIFY_Utils', 'rate_limit_exceeded_error' ), 9 );
		} elseif ( isset( $_exception_errors[0]['reason'] ) && $_exception_errors[0]['reason'] == 'quotaExceeded' ) {
			add_action( 'admin_notices', array( 'WPANALYTIFY_Utils', 'quota_exceeded_error' ), 9 );
		} elseif ( isset( $_exception_errors[0]['reason'] ) && $_exception_errors[0]['reason'] == 'accessNotConfigured' ) {
			add_action( 'admin_notices', array( 'WPANALYTIFY_Utils', 'accessNotConfigured' ), 9 );
		} elseif ( isset( $_exception_errors[0]['reason'] ) && $_exception_errors[0]['reason'] == 'unexpected_profile_error' ){
			add_action( 'admin_notices', array( 'WPANALYTIFY_Utils', 'unexpected_profile_error' ), 9 );
		} elseif ( isset( $_exception_errors[0]['reason'] ) && $_exception_errors[0]['reason'] == 'ACCESS_TOKEN_SCOPE_INSUFFICIENT' ) {
			add_action( 'admin_notices', array( 'WPANALYTIFY_Utils', 'insufficient_token_scope' ), 9 );
		}
	}

	public static function handle_ga4_exceptions(){
		$analytify_ga4_exceptions = get_option('analytify_ga4_exceptions');
		// Handle measurement protocol secret errors.
		if ( ! empty( $analytify_ga4_exceptions['mp_secret_exception']['reason'] ) && ( $analytify_ga4_exceptions['mp_secret_exception']['reason'] == 'ACCESS_TOKEN_SCOPE_INSUFFICIENT' || $analytify_ga4_exceptions['mp_secret_exception']['reason'] == 'Request had insufficient authentication scopes.' ) ) {
			add_action( 'admin_notices', array( 'WPANALYTIFY_Utils', 'insufficient_token_scope' ), 9 );
		}
		// Handle ga4 stream errors.
		if ( ! empty( $analytify_ga4_exceptions['create_stream_exception']['reason'] ) && ( $analytify_ga4_exceptions['create_stream_exception']['reason'] == 'ACCESS_TOKEN_SCOPE_INSUFFICIENT' || $analytify_ga4_exceptions['create_stream_exception']['reason'] == 'Request had insufficient authentication scopes.' ) ) {
			add_action( 'admin_notices', array( 'WPANALYTIFY_Utils', 'insufficient_token_scope' ), 9 );
		}
	}

	/**
	 * Indicates that user has not selected all the scopes on auth screen.
	 *
	 * @since 5.0.0
	 */
	public static function insufficient_token_scope() {

		$class   = 'wp-analytify-danger';
		$message = sprintf( __( '%1$sInsufficient Authentication Scopes:%2$s Please reauthenticate Analytify with your Google Analytics account and select all permission scopes at the Auth screen to ensure data from your website is properly tracked in Google Analytics.', 'wp-analytify'), '<b>', '</b>' );
		analytify_notice( $message, $class );
	}

	/**
	 * Indicates that user has exceeded the daily quota (either per project or per view (profile)).
	 *
	 * @since 2.0.5
	 */
	public static function daily_limit_exceed_error() {

		$class   = 'wp-analytify-danger';
		$link    = 'https://analytify.io/doc/fix-403-daily-limit-exceeded/';
		$message = sprintf( __( '%1$sDaily Limit Exceeded:%2$s This Indicates that user has exceeded the daily quota (either per project or per view (profile)). Please %3$sfollow this tutorial%4$s to fix this issue. let us know this issue (if it still doesn\'t work) in the Help tab of Analytify->settings page.', 'wp-analytify'), '<b>', '</b>', '<a href="'. $link .'" target="_blank">', '</a>' );
		analytify_notice( $message, $class );
	}

	/**
	 * Indicates that the user does not have sufficient permissions.
	 *
	 * @since 2.0.5
	 */
	public static function insufficent_permissions_error() {

		$class   = 'wp-analytify-danger';
		$link    = 'https://analytics.google.com/';
		$message = sprintf( __( 'Insufficient Permissions: Indicates that the user does not have sufficient permissions for the entity specified in the query. let us know this issue in Help tab of Analytify->settings page.', 'wp-analytify'), $link );
		analytify_notice( $message, $class );
	}

	/**
	 * Indicates that the application needs to be registered in the Google Console
	 *
	 * @since 2.0.5
	 */
	public static function user_rate_limit_unreg_error() {

		$class   = 'wp-analytify-danger';
		$link    = 'https://analytify.io/get-client-id-client-secret-developer-api-key-google-developers-console-application/';
		$message = sprintf( __( '%1$susageLimits.userRateLimitExceededUnreg:%2$s Indicates that the application needs to be registered in the Google API Console. Read %3$sthis guide%4$s for to make it work. let us know this issue in (if it still doesn\'t work) Help tab of Analytify->settings page.', 'wp-analytify'), '<b>', '</b>', '<a href="'. $link .'">', '</a>'  );
		analytify_notice( $message, $class );
	}

	/**
	 * 	Indicates that the user rate limit has been exceeded. The maximum rate limit is 10 qps per IP address.
	 *
	 * @since 2.0.5
	 */
	public static function user_rate_limit_error() {

		$class   = 'wp-analytify-danger';
		$link    = 'https://console.developers.google.com/';

		$message = sprintf( __( '%1$sUser Rate Limit Exceeded:%2$s Indicates that the user rate limit has been exceeded. The maximum rate limit is 10 qps per IP address. The default value set in Google API Console is 1 qps per IP address. You can increase this limit in the %3$sGoogle API Console%4$s to a maximum of 10 qps. let us know this issue in Help tab of Analytify->settings page.', 'wp-analytify'), '<b>', '</b>', '<a href="'. $link .'">', '</a>'  );
		analytify_notice( $message, $class );
	}

	/**
	 * 	Indicates that the global or overall project rate limits have been exceeded.
	 *
	 * @since 2.0.5
	 */
	public static function rate_limit_exceeded_error() {

		$class   = 'wp-analytify-danger';
		$link    = 'https://analytics.google.com/';
		$message = sprintf( __( '%1$sRate Limit Exceeded:%2$s Indicates that the global or overall project rate limits have been exceeded. let us know this issue in Help tab of Analytify->settings page.', 'wp-analytify'), '<b>', '</b>' );
		analytify_notice( $message, $class );
	}

	/**
	 * 	Indicates that the 10 concurrent requests per view (profile) in the Core Reporting API has been reached.
	 *
	 * @since 2.0.5
	 */
	public static function quota_exceeded_error() {

		$class   = 'wp-analytify-danger';
		$link    = 'https://analytics.google.com/';
		$message = sprintf( __( '%1$sQuota Exceeded:%2$s This indicates that the 10 concurrent requests per view (profile) in the Core Reporting API has been reached. let us know this issue in Help tab of Analytify->settings page.', 'wp-analytify'), '<b>', '</b>' );
		analytify_notice( $message, $class );
	}

	/**
	 * 	Access Not Configured.
	 *
	 * @since 2.0.5
	 */
	public static function accessNotConfigured() {

		$class   = 'wp-analytify-danger';
		$link    = 'https://console.developers.google.com/';

		$message = sprintf( __( '%1$sAccess Not Configured:%2$s Google Analytics API has not been used in this project before or it is disabled. Enable it by visiting your project in %3$sGoogle Project Console%4$s then retry. If you enabled this API recently, wait a few minutes for the action to propagate to our systems and retry.', 'wp-analytify' ), '<b>', '</b>', '<a href="'. $link .'">', '</a>' );
		analytify_notice( $message, $class );
	}

	/**
	 * 	Access Not Configured.
	 *
	 * @since 2.0.5
	 */
	public static function unexpected_profile_error() {

		$class   = 'wp-analytify-danger';

		$message = sprintf( __( '%1$sUnexpected Error:%2$s An unexpected error occurred while getting profiles list from the Google Analytics account. let us know this issue in Help tab of Analytify->settings page.', 'wp-analytify'), '<b>', '</b>' );
		analytify_notice( $message, $class );
	}

	/**
	 * Indicates that user have no register site on Google Analytics.
	 *
	 * @since 2.1.22
	 */
	public static function no_profile_error() {

		$class   = 'wp-analytify-danger';
		$message = '<p class="description" style="color:#ed1515">No Website is registered with your Email at <a href="https://analytics.google.com/">Google Analytics</a>.<br/> Please setup your site first, Check out this guide <a href="https://analytify.io/setup-account-google-analytics/">here</a> to setup it properly.</p>';
		analytify_notice( $message, $class );
	}

	/**
	* Clear cache when query string is set.
	* @return bool
	*
	* @since 2.1.9
	*/
	public static function force_clear_cache() {

		if ( isset( $_GET[ 'force-clear-cache' ] ) && '1' == $_GET[ 'force-clear-cache' ] ) {
			return true;
		}

		return false;
	}

	/**
	 * Get the last element of array.
	 *
	 * @since 2.1.12
	 */
	static function end( $array ) {
		return end( $array );
	}

	/**
	 * Get the Date Selection List.
	 *
	 * @since 2.1.14
	 */
	public static function get_date_list() {
		ob_start();
		?>
			<ul class="analytify_select_date_list">

				<li><?php _e( 'Today', 'wp-analytify' )?> <span data-date-diff="current_day" data-start="" data-end=""><span class="analytify_start_date_data analytify_current_day"></span> – <span class="analytify_end_date_data analytify_today_date"></span></span></li>
				
				<li><?php _e( 'Yesterday', 'wp-analytify' )?> <span data-date-diff="yesterday" data-start="" data-end=""><span class="analytify_start_date_data analytify_yesterday"></span> – <span class="analytify_end_date_data analytify_yesterday_date"></span></span></li>

				<li><?php _e( 'Last 7 days', 'wp-analytify' )?> <span data-date-diff="last_7_days" data-start="" data-end=""><span class="analytify_start_date_data analytify_last_7_days"></span> – <span class="analytify_end_date_data analytify_today_date"></span></span></li>

				<li><?php _e( 'Last 14 days', 'wp-analytify' )?> <span data-date-diff="last_14_days" data-start="" data-end=""><span class="analytify_start_date_data analytify_last_14_days"></span> – <span class="analytify_end_date_data analytify_today_date"></span></span></li>

				<li><?php _e( 'Last 30 days', 'wp-analytify' )?> <span data-date-diff="last_30_days" data-start="" data-end=""><span class="analytify_start_date_data analytify_last_30_day"></span> – <span class="analytify_end_date_data analytify_today_date"></span></span></li>

				<li><?php _e( 'This month', 'wp-analytify' )?> <span data-date-diff="this_month" data-start="" data-end=""><span class="analytify_start_date_data analytify_this_month_start_date"></span> – <span class="analytify_end_date_data analytify_today_date"></span></span></li>

				<li><?php _e( 'Last month', 'wp-analytify' )?> <span data-date-diff="last_month" data-start="" data-end=""><span class="analytify_start_date_data analytify_last_month_start_date"></span> – <span class="analytify_end_date_data analytify_last_month_end_date"></span></span></li>

				<li><?php _e( 'Last 3 months', 'wp-analytify' )?> <span data-date-diff="last_3_months" data-start="" data-end=""><span class="analytify_start_date_data analytify_last_3_months_start_date"></span> – <span class="analytify_end_date_data analytify_last_month_end_date"></span></span></li>

				<li><?php _e( 'Last 6 months', 'wp-analytify' )?> <span data-date-diff="last_6_months" data-start="" data-end=""><span class="analytify_start_date_data analytify_last_6_months_start_date"></span> – <span class="analytify_end_date_data analytify_last_month_end_date"></span></span></li>

				<li><?php _e( 'Last year', 'wp-analytify' )?> <span data-date-diff="last_year" data-start="" data-end=""><span class="analytify_start_date_data analytify_last_year_start_date"></span> – <span class="analytify_end_date_data analytify_last_month_end_date"></span></span></li>

				<li><?php _e( 'Custom Range', 'wp-analytify' )?> <span class="custom_range"><?php _e( 'Select a custom date', 'wp-analytify' )?></span></li>
			</ul>
		<?php
		$content = ob_get_clean();
		echo $content;
	}

	/**
	 * Remove WordPress plugin directory.
	 *
	 * @since 2.1.14
	 */
	public static function remove_wp_plugin_dir( $name ) {
		$plugin = str_replace( WP_PLUGIN_DIR, '', $name );

		return substr( $plugin, 1 );
	}

	/**
	 * Calculates compare start and end date, also returns the difference in days.
	 *
	 * @param string $start_date Start date.
	 * @param string $end_date   End date.
	 *
	 * @return array
	 */
	public static function calculate_date_diff( $start_date, $end_date ) {


		$diff               = date_diff( date_create( $end_date ), date_create( $start_date ) );
		$compare_start_date = date( 'Y-m-d', strtotime( $start_date . $diff->format( ' %R%a days' ) ) );
		$compare_end_date   = $start_date;
		$diff_days          = $diff->format( '%a' );

		return array(
			'start_date' => $compare_start_date,
			'end_date'   => $compare_end_date,
			'diff_days'  => (string) $diff_days,
		);
	}

	/**
	 * Renders date form.
	 * This form is used in the dashboard pages.
	 *
	 * @param string $start_date Start date value.
	 * @param string $end_date End date value.
	 */
	public static function date_form( $start_date, $end_date, $args = array() ) {

		$_analytify_profile	= get_option( 'wp-analytify-profile' );
		$dashboard_profile	= isset( $_analytify_profile['profile_for_dashboard'] ) ? $_analytify_profile['profile_for_dashboard'] : '';

		if ( empty( $dashboard_profile ) ) {
			return;
		}
		?>

		<form class="analytify_form_date analytify_form_date_pro" action="" method="post">

			<?php
			if ( isset( $args['input_before_field_set'] ) && ! empty( $args['input_before_field_set'] ) ) {
				echo $args['input_before_field_set'];
			}
			?>

			<div class="analytify_select_date_fields">
				<input type="hidden" name="st_date" id="analytify_start_val">
				<input type="hidden" name="ed_date" id="analytify_end_val">
				<input type="hidden" name="analytify_date_diff" id="analytify_date_diff">

				<input type="hidden" name="analytify_date_start" id="analytify_date_start" value="<?php echo isset( $start_date ) ? $start_date : '' ?>">
				<input type="hidden" name="analytify_date_end" id="analytify_date_end" value="<?php echo isset( $end_date ) ? $end_date : '' ?>">

				<label for="analytify_start"><?php _e( 'From:', 'wp-analytify' )?></label>
				<input type="text" required id="analytify_start" value="">
				<label for="analytify_end"><?php _e( 'To:', 'wp-analytify' )?></label>
				<input type="text" onpaste="return: false;" oncopy="return: false;" autocomplete="off" required id="analytify_end" value="">

				<div class="analytify_arrow_date_picker"></div>
			</div>

			<?php if( isset($args['input_after_field_set']) and !empty($args['input_after_field_set']) ){
				echo $args['input_after_field_set'];
			} ?>

			<input type="submit" value="<?php _e( 'View Stats', 'wp-analytify' ) ?>" name="view_data" class="analytify_submit_date_btn"<?php if( isset($args['input_submit_id']) and !empty($args['input_submit_id']) ){ ?> id="<?php echo $args['input_submit_id']; ?>"<?php } ?>>

			<?php echo self::get_date_list(); ?>

		</form>
	<?php 
	}

	/**
	 * Prints the settings fields and values in presentable way.
	 *
	 * @param array $settings_array
	 */
	public static function print_settings_array( $settings_array ) {

		if ( is_array( $settings_array ) ) {
			foreach ( $settings_array as $key => $value ) {
				if ( is_array( $value ) ) {
					echo "$key:\r\n";
					echo print_r( $value, true ) . "\r\n";
				} else {
					echo "$key: $value\r\n";
				}
			}
		}
	}

	/**
	 * Check tracking code is enabled on site.
	 * The method checks for both manual or profile selection for tracking code.
	 *
	 * @param bool $only_auth Tracking only with authentication, no manual code.
	 * @return boolean
	 */
	public static function is_tracking_available( $only_auth = false ) {

		global $current_user;

		$roles = $current_user->roles;

		// Check user role is excluded form tracking. 
		if ( isset( $roles[0] ) && in_array( $roles[0], $GLOBALS['WP_ANALYTIFY']->settings->get_option( 'exclude_users_tracking', 'wp-analytify-profile', array() ) ) ) {
			return false;
		}

		// Check for GDPR compliance.
		if ( Analytify_GDPR_Compliance::is_gdpr_compliance_blocking() ) {
			return false;
		}

		if ( get_option( 'pa_google_token' ) ) { // Authenticated, check profiles selection and tracking option.
			if ( 'on' === $GLOBALS['WP_ANALYTIFY']->settings->get_option( 'install_ga_code', 'wp-analytify-profile', 'off' ) && WP_ANALYTIFY_FUNCTIONS::get_UA_code() ) { 
				return true;
			}
		} else if ( ! $only_auth && $GLOBALS['WP_ANALYTIFY']->settings->get_option( 'manual_ua_code', 'wp-analytify-authentication', false ) ) { // Not authenticated, manual code.
			return true;
		}
	}

	/**
	 * Check is current edit page has gutenberg enabled.
	 *
	 * @return boolean
	 */
	public static function is_gutenberg_editor() {

		if ( function_exists( 'is_gutenberg_page' ) && is_gutenberg_page() ) {
			return true;
		}

		$current_screen = get_current_screen();
		
		if ( method_exists( get_current_screen(), 'is_block_editor' ) && $current_screen->is_block_editor() ) {
			return true;
		}

		return false;
	}

	/**
	 * Get current post type in admin panel.
	 *
	 * @return string|null
	 */
	public static function get_current_admin_post_type() {

		global $post, $typenow, $current_screen;

		if ( $post && $post->post_type ) {
			return $post->post_type;
		} elseif ( $typenow ) {
			return $typenow;
		} elseif ( $current_screen && $current_screen->post_type ) {
			return $current_screen->post_type;
		} elseif ( isset( $_REQUEST['post_type'] ) ) {
			return sanitize_key( $_REQUEST['post_type'] );
		}

		return null;
	}

	/**
	 * Check if addons needs update to work
	 * smoothly with new Analytify 5.0.0
	 *
	 * @return array
	 * 
	 * @since 5.0.0
	 */
	public static function get_addons_to_update() {

		$addons_to_update = array();

		if ( defined( 'ANALYTIFY_PRO_VERSION' ) && -1 === version_compare( ANALYTIFY_PRO_VERSION, '5.0.0' ) ) {
			$addons_to_update[] = 'Analytify Pro';
		}
		if ( defined( 'ANALTYIFY_WOOCOMMERCE_VERSION' ) && -1 === version_compare( ANALTYIFY_WOOCOMMERCE_VERSION, '5.0.0' ) ) {
			$addons_to_update[] = 'Analytify - WooCommerce Tracking';
		}
		if ( defined( 'ANALTYIFY_AUTHORS_DASHBORD_VERSION' ) && -1 === version_compare( ANALTYIFY_AUTHORS_DASHBORD_VERSION, '3.0.0' ) ) {
			$addons_to_update[] = 'Analytify - Authors Tracking';
		}
		if ( defined( 'ANALYTIFY_FORMS_VERSION' ) && -1 === version_compare( ANALYTIFY_FORMS_VERSION, '3.0.0' ) ) {
			$addons_to_update[] = 'Analytify - Forms Tracking';
		}
		if ( defined( 'ANALTYIFY_CAMPAIGNS_VERSION' ) && -1 === version_compare( ANALTYIFY_CAMPAIGNS_VERSION, '3.0.0' ) ) {
			$addons_to_update[] = 'Analytify - UTM Campaigns Tracking';
		}
		if ( defined( 'ANALTYIFY_EMAIL_VERSION' ) && -1 === version_compare( ANALTYIFY_EMAIL_VERSION, '3.0.0' ) ) {
			$addons_to_update[] = 'Analytify - Email Notifications';
		}
		if ( defined( 'ANALYTIFY_DASHBOARD_VERSION' ) && -1 === version_compare( ANALYTIFY_DASHBOARD_VERSION, '3.0.0' ) ) {
			$addons_to_update[] = 'Plugin Name: Analytify - Google Analytics Dashboard Widget';
		}
		if ( class_exists( 'WP_Analytify_Edd' ) ) {
			$all_plugins = get_plugins();

			if ( isset( $all_plugins['wp-analytify-edd/wp-analytify-edd.php']['Version'] ) && -1 === version_compare( $all_plugins['wp-analytify-edd/wp-analytify-edd.php']['Version'], '3.0.0' ) ) {
				$addons_to_update[] = 'Analytify - Easy Digital Downloads Tracking';
			}
		}

		return $addons_to_update;
	}


	/**
	 * Take the ga4 social stats raw array
	 * map it to predefined array of social network
	 * sort the array in desc order by number of sessions
	 * 
	 * @param array $social_stats_raw original raw array of ga4 social stats.
	 * @return array $social_network new array with UA social stats raw array like structure.
	 * 
	 * @since 5.0.0
	 */
	public static function ga4_social_stats( $social_stats_raw ) {
		$social_network = array(
			array( 'sessionSource' => 'facebook'  , 'sessions' => 0 ),
			array( 'sessionSource' => 'instagram' , 'sessions' => 0 ),
			array( 'sessionSource' => 'wordpress' , 'sessions' => 0 ),
			array( 'sessionSource' => 'linkedin'  , 'sessions' => 0 ),
			array( 'sessionSource' => 'youtube'   , 'sessions' => 0 ),
			array( 'sessionSource' => 'twitter'   , 'sessions' => 0 ),
			array( 'sessionSource' => 'pinterest' , 'sessions' => 0 ),
			array( 'sessionSource' => 'yelp'      , 'sessions' => 0 ),
			array( 'sessionSource' => 'tumblr'    , 'sessions' => 0 ),
			array( 'sessionSource' => 'quora'     , 'sessions' => 0 ),
			array( 'sessionSource' => 'reddit'    , 'sessions' => 0 ),
		);
		foreach ($social_stats_raw as $stat) {
			foreach ( $social_network as &$item ) {
				if ( strpos( $stat['sessionSource'], $item['sessionSource'] ) !== false ) {
					$item['sessions'] += $stat['sessions'];
					break;
				}
			}
        }
		$social_network = array_filter( $social_network, function ($item) {
			return $item['sessions'] > 0;
		} );
		usort( $social_network, function($a, $b) {
			return $b['sessions'] - $a['sessions'];
		} );
		return $social_network;
	}
	/**
	 * Get the value of a settings field
	 * While this addon is present in WP_Analytify_Settings
	 * we are creating the same method in this class also
	 * to avoid the need of passing WP_Analytify_Settings 
	 * instance here.
	 *
	 * @param string $option  settings field name
	 * @param string $section the section name this field belongs to
	 * @param string $default default text if it's not found
	 * @return string
	 * 
	 * @since 5.0.0
	 */
	public static function get_option( $option, $section, $default = '' ) {

		$options = get_option( $section );

		if ( isset( $options[ $option ] ) ) {
			return $options[ $option ];
		}

		return $default;
	}

	/**
	 * Take the name of the section and the option value
	 * and save the value in section 
	 * 
	 * @param string $option settings field name
	 * @param string $section the section this field belong to
	 * @param string $value the option value to be inserted in options table
	 * 
	 * @since 5.0.0
	 */
	public static function update_option( $option, $section, $value ) {
		$options = (array)get_option( $section );
		$options[$option] = $value;
		update_option( $section , $options );

	}

	/**
	 * Add ga4 exception.
	 * 
	 * @param string $type which api method triggered it.
	 * @param string $reason status or reason depends.
	 * @param string $message actual error message.
	 * 
	 * @since 5.0.0
	 */
	public static function add_ga4_exception( $type , $reason, $message ){
		$analytify_ga4_exceptions = (array)get_option('analytify_ga4_exceptions');
		$analytify_ga4_exceptions[$type]['reason'] = $reason;
		$analytify_ga4_exceptions[$type]['message'] = $message;
		update_option('analytify_ga4_exceptions', $analytify_ga4_exceptions);
	}
	/**
	 * remove ga4 exception.
	 * 
	 * @param string $type which api method triggered it.
	 * 
	 * @since 5.0.0
	 */
	public static function remove_ga4_exception( $type ){
		$analytify_ga4_exceptions = (array)get_option('analytify_ga4_exceptions');
		unset( $analytify_ga4_exceptions[$type] );
		update_option('analytify_ga4_exceptions', $analytify_ga4_exceptions);
	}

	/**
	 * Return the ga4 streams for currently selected property.
	 */
	public static function fetch_ga4_streams(){
		
		$_analytify_profile	= get_option( 'wp-analytify-profile' );
		$post_profile	    = isset( $_analytify_profile['profile_for_posts'] ) ? $_analytify_profile['profile_for_posts'] : '';
		$post_profile       = explode( ':', $post_profile )[1] ?? false;
		
		// store all the streams
		$streams            = array();
		if( $post_profile ) {
			$properties   = get_option('analytify-ga4-streams');
            $streams_data = $properties[$post_profile] ?? array();

			// adding support for old implementation
            $using_old_structure = false;

			foreach( $streams_data as $stream ) {
				if( ! is_array($stream) ){
					$using_old_structure = true;
					break;
				}
				$streams[$stream['measurement_id']] = $stream['stream_name'];
			}

			// below code is added for old compatibility that we build for ga4 beta testers.
			if( $using_old_structure && isset( $streams_data['measurement_id'] ) ) {
				$streams[$streams_data['measurement_id']] = $streams_data['stream_name'];
			}
		}

		return $streams;

	}
	/**
	 * Get current ga mode based on option selected in settings.
	 *
	 * @return string
	 */
	public static function get_ga_mode( $property_for = 'profile_for_dashboard' ) {

		$ga_mode     = WPANALYTIFY_Utils::get_option( 'google_analytics_version', 'wp-analytify-advanced' );
		$old_version = get_option('WP_ANALYTIFY_PLUGIN_VERSION_OLD');

		if( ! empty( $ga_mode ) ) {
			return $ga_mode;
		}

		$property_id = self::get_option( 'profile_for_dashboard' , 'wp-analytify-profile' );

		if( empty( $old_version ) || false !== strpos( $property_id, 'ga4') ){
			$ga_mode = 'ga4';
		} else {
			$ga_mode = 'ga3';
		}
		

		return $ga_mode;
	}

	/**
	 * Get ga reporting property selected based on ga mode.
	 *
	 * @return string
	 */
	public static function get_reporting_property() {

		$property_id = $GLOBALS['WP_ANALYTIFY']->settings->get_option( 'profile_for_dashboard', 'wp-analytify-profile' );

		if ( false !== strpos( $property_id, 'ga4:' ) ) {
			$property_id = explode( ':', $property_id )[1];
		}

		return $property_id;
	}

	/**
	 * Create markup for dashboard subtitle section.
	 *
	 * @return void
	 */
	public static function dashboard_subtitle_section() {

		$dashboard_profile_ID = self::get_reporting_property();

		if ( 'ga4' === self::get_ga_mode() ) {
			$name = WP_ANALYTIFY_FUNCTIONS::ga_reporting_property_info( 'stream_name' );
			$url  = WP_ANALYTIFY_FUNCTIONS::ga_reporting_property_info( 'url' );
		} else {
			$name = WP_ANALYTIFY_FUNCTIONS::search_profile_info( $dashboard_profile_ID, 'name' );
			$url = WP_ANALYTIFY_FUNCTIONS::search_profile_info( $dashboard_profile_ID, 'websiteUrl' );
		}

		if ( $name && $url ) {
		?>
			<span class="analytify_stats_of"><a href="<?php echo $url; ?>" target="_blank"><?php echo $url; ?></a> (<?php echo $name; ?>)</span>
		<?php
		}
	}

	/**
	 * Returns the property URL for the currently selected property.
	 *
	 * @return string
	 */
	public static function get_property_url() {
		return 'ga4' === self::get_ga_mode() ? WP_ANALYTIFY_FUNCTIONS::ga_reporting_property_info( 'url' ) : WP_ANALYTIFY_FUNCTIONS::search_profile_info( self::get_reporting_property(), 'websiteUrl' );
	}

	/**
	 * Create markup for error message box.
	 *
	 * @param string $status
	 * @param string $message
	 * @param string $heading
	 * 
	 * @return void
	 */
	public static function create_error_box( $status, $message, $heading = 'Unable To Fetch Reports' ) {
		?>

		<div class="analytify-email-promo-contianer">
			<div class="analytify-email-premium-overlay">
				<div class="analytify-email-premium-popup">
					<h3 class="analytify-promo-popup-heading" style="text-align: left;"><?php _e( $heading, 'wp-analytify' ); ?></h3>
					<p class="analytify-promo-popup-paragraph analytify-error-popup-paragraph"><strong><?php _e( 'Status:', 'wp-analytify' ); ?> </strong> <?php echo $status; ?></p>
					<p class="analytify-promo-popup-paragraph analytify-error-popup-paragraph"><strong><?php _e( 'Message:', 'wp-analytify' ); ?> </strong> <?php echo $message; ?></p>
				</div>
			</div>
		</div>

		<?php
	}

	/**
	 * Analytify required dimensions for reporting
	 *
	 * @return return
	 */
	public static function required_dimensions() {

		return array(
			array(
				'parameter_name' => 'wpa_author',
				'display_name'   => 'WPA Author',
				'scope'          => 1,
			),
			array(
				'parameter_name' => 'wpa_post_type',
				'display_name'   => 'WPA Post Type',
				'scope'          => 1,
			),
			array(
				'parameter_name' => 'wpa_published_at',
				'display_name'   => 'WPA Published At',
				'scope'          => 1,
			),
			array(
				'parameter_name' => 'wpa_category',
				'display_name'   => 'WPA Category',
				'scope'          => 1,
			),
			array(
				'parameter_name' => 'wpa_tags',
				'display_name'   => 'WPA Tags',
				'scope'          => 1,
			),
			array(
				'parameter_name' => 'wpa_user_id',
				'display_name'   => 'WPA WP User ID',
				'scope'          => 1,
			),
			array(
				'parameter_name' => 'wpa_logged_in',
				'display_name'   => 'WPA Logged In',
				'scope'          => 1,
			),
			array(
				'parameter_name' => 'wpa_seo_score',
				'display_name'   => 'WPA SEO Score',
				'scope'          => 1,
			),
			array(
				'parameter_name' => 'wpa_focus_keyword',
				'display_name'   => 'WPA Focus Keyword',
				'scope'          => 1,
			),
			array(
				'parameter_name' => 'wpa_link_action',
				'display_name'   => 'WPA Link Action',
				'scope'          => 1,
			),
			array(
				'parameter_name' => 'wpa_label',
				'display_name'   => 'WPA Label',
				'scope'          => 1,
			),
			array(
				'parameter_name' => 'wpa_category',
				'display_name'   => 'WPA Category',
				'scope'          => 1,
			),
			array(
				'parameter_name' => 'wpa_affiliate_label',
				'display_name'   => 'WPA Affiliate Label',
				'scope'          => 1,
			),
			array(
				'parameter_name' => 'wpa_email_address',
				'display_name'   => 'WPA Email Address',
				'scope'          => 1,
			),
			array(
				'parameter_name' => 'wpa_form_id',
				'display_name'   => 'WPA Form Id',
				'scope'          => 1,
			),
			array(
				'parameter_name' => 'wpa_is_affiliate_link',
				'display_name'   => 'WPA Is Affiliate Link',
				'scope'          => 1,
			),
			array(
				'parameter_name' => 'wpa_link_label',
				'display_name'   => 'WPA Link Label',
				'scope'          => 1,
			),
			array(
				'parameter_name' => 'wpa_link_text',
				'display_name'   => 'WPA Link Text',
				'scope'          => 1,
			),
			array(
				'parameter_name' => 'wpa_outbound',
				'display_name'   => 'WPA Outbound',
				'scope'          => 1,
			),
			array(
				'parameter_name' => 'wpa_tel_number',
				'display_name'   => 'WPA Tel Number',
				'scope'          => 1,
			),
			array(
				'parameter_name' => 'wpa_scroll_depth',
				'display_name'   => 'WPA Scroll Depth',
				'scope'          => 1,
			),
			array(
				'parameter_name' => 'wpa_seo_score',
				'display_name'   => 'WPA Seo Score',
				'scope'          => 1,
			),
			array(
				'parameter_name' => 'wpa_percentage',
				'display_name'   => 'WPA Percentage',
				'scope'          => 1,
			),
			array(
				'parameter_name' => 'wpa_post_category',
				'display_name'   => 'WPA Post Category',
				'scope'          => 1,
			),
			// array(
			// 	'parameter_name' => 'wpa_video_provider',
			// 	'display_name'   => 'WPA Video Provider',
			// 	'scope'          => 1,
			// ),
			// array(
			// 	'parameter_name' => 'wpa_video_title',
			// 	'display_name'   => 'WPA Video Title',
			// 	'scope'          => 1,
			// ),
			// array(
			// 	'parameter_name' => 'wpa_video_url',
			// 	'display_name'   => 'WPA Video Url',
			// 	'scope'          => 1,
			// ),
		);
	}

	/**
	 * Create all stats external link takes to Google Analytics.
	 *
	 * @param string $report_url
	 * @param string $report
	 * @param string $date_range
	 * 
	 * @return string
	 */
	public static function get_all_stats_link( $report_url, $report, $date_range = false ) {

		if ( 'ga4' === self::get_ga_mode() ) {
			switch ( $report ) {
				case 'top_pages':
					$link = 'top_pages';
					break;
				case 'top_countries':
					$link = 'top_countries';
					break;
				case 'top_cities':
					$link .= 'top_cities';
					break;
				case 'referer':
					$link = 'referer';
					break;
				case 'top_products':
					$link = 'top_products';
					break;
				case 'source_medium':
					$link = 'source_medium';
					break;
				case 'top_countries_sales':
					$link = 'top_countries_sales';
					break;
				default:
					$link = '';
					break;
			}
		} else {
			switch ( $report ) {
				case 'top_pages':
					$link = 'https://analytics.google.com/analytics/web/#report/content-pages/' . $report_url . $date_range;
					break;
				case 'top_countries':
					$link = 'https://analytics.google.com/analytics/web/#report/visitors-geo/' . $report_url . $date_range;
					break;
				case 'top_cities':
					$link = 'https://analytics.google.com/analytics/web/#report/visitors-geo/' . $report_url . $date_range;
					break;
				case 'top_products':
					$link = 'https://analytics.google.com/analytics/web/#/report/conversions-ecommerce-product-performance/' . $report_url . $date_range;
					break;
				case 'source_medium':
					$link = 'https://analytics.google.com/analytics/web/#/report/trafficsources-all-traffic/' . $report_url . $date_range . '&explorer-table-dataTable.sortColumnName=analytics.transactionRevenue&explorer-table-dataTable.sortDescending=true&explorer-table.plotKeys=%5B%5D/';
					break;
				case 'top_countries_sales':
					$link = 'https://analytics.google.com/analytics/web/#/report/visitors-geo/' . $report_url . $date_range . '&geo-table-dataTable.sortColumnName=analytics.transactions&geo-table-dataTable.sortDescending=true&geo-table.plotKeys=%5B%5D/';
					break;
				case 'social_media':
					$link = 'https://analytics.google.com/analytics/web/#report/social-overview/' . $report_url . $date_range;
					break;
				case 'referer':
					$link = 'https://analytics.google.com/analytics/web/#/report/trafficsources-all-traffic/' . $report_url . $date_range . '&explorer-table-dataTable.sortColumnName=analytics.visits&explorer-table-dataTable.sortDescending=true&explorer-table.plotKeys=%5B%5D&explorer-table.secSegmentId=analytics.sourceMedium';
					break;
				default:
					$link = '';
					break;
			}
		}

		return $link;
	}

}

/**
 * Remove assets of other plugin/theme.
 *
 * @since 2.1.22
 */
function analytify_remove_conflicting_asset_files( $page ) {

	if ( 'toplevel_page_analytify-dashboard' !== $page ) {
		return;
	}

	wp_dequeue_script( 'default' ); // Bridge theme.
	wp_dequeue_script( 'bridge-admin-default' ); // Bridge theme.
	wp_dequeue_script( 'gdlr-tax-meta' ); // MusicClub theme.
	wp_dequeue_script( 'woosb-backend' ); // WooCommerce Product Bundle.
	wp_deregister_script( 'bf-admin-plugins' ); // Better Ads Manager plugin.
	wp_dequeue_script( 'bf-admin-plugins' ); // Better Ads Manager plugin.
	wp_deregister_script( 'unite-ace-js' ); // Brooklyn theme.

	wp_deregister_script( 'elementor-common' ); // Elementor plugin.
	wp_dequeue_script( 'jquery-widgetopts-option-tabs' ); // Widget Options plugin.
	wp_dequeue_script( 'rml-default-folder' ); // WP Real Media Library plugin.
	wp_dequeue_script( 'resume_manager_admin_js' ); // WP Job Manager - Resume Manager plugin.

	if ( class_exists( 'Woocommerce_Pre_Order' ) ) {
		wp_dequeue_script( 'plugin-js' ); // Woocommerce Pre Order.
	}

	if ( class_exists( 'GhostPool_Setup' ) ) {
		wp_dequeue_script( 'theme-setup' ); // Huber theme.
	}
  
	if ( class_exists( 'WPcleverWoobt' ) ) {
		wp_dequeue_script( 'woobt-backend' ); // WPC Frequently Bought Together.
	}
}
add_action( 'admin_enqueue_scripts', 'analytify_remove_conflicting_asset_files', 999 );
