<?php

/**
 * This function returns dates for the date picker.
 * 
 * @version 5.0.4
 * 
 * @since 5.0.4
 */

function analytify_datepicker_dates() {

	$wp_analytify   = $GLOBALS['WP_ANALYTIFY'];

	$start_date_val = strtotime( '-1 month' );
	$end_date_val   = strtotime( 'now' );
	$start_date     = wp_date( 'Y-m-d', $start_date_val );
	$end_date       = wp_date( 'Y-m-d', $end_date_val );

	/**
	 * Always remember the previously selected date.
	 */
	$_differ = get_option( 'analytify_date_differ' );

		if ( $_differ ) {
		if ( $_differ == 'current_day' ) {
			$start_date = wp_date( 'Y-m-d' );
		} elseif( $_differ == 'yesterday') {
			$start_date = wp_date( 'Y-m-d', strtotime( '-1 day' ) );
			$end_date   = wp_date( 'Y-m-d', strtotime( '-1 day' ) );
		} elseif ( $_differ == 'last_7_days' ) {
			$start_date = wp_date( 'Y-m-d', strtotime( '-7 days' ) );
		} elseif ( $_differ == 'last_14_days' ) {
			$start_date = wp_date( 'Y-m-d', strtotime( '-14 days' ) );
		} elseif ( $_differ == 'last_30_days' ) {
			$start_date = wp_date( 'Y-m-d', strtotime( '-1 month' ) );
		} elseif (  $_differ == 'this_month' ) {
			$start_date =  wp_date('Y-m-01') ;
		} elseif ( $_differ == 'last_month' ) {
			$start_date =  wp_date('Y-m-01', strtotime('-1 month') );
			$end_date =  wp_date('Y-m-t', strtotime('-1 month') );
		} elseif ( $_differ == 'last_3_months' ) {
			$start_date =  wp_date('Y-m-01', strtotime('-3 month') );
			$end_date =  wp_date('Y-m-t', strtotime('-1 month') );
		} elseif ( $_differ == 'last_6_months' ) {
			$start_date =  wp_date('Y-m-01', strtotime('-6 month') );
			$end_date =  wp_date('Y-m-t', strtotime('-1 month') );
		} elseif ( $_differ == 'last_year' ) {
			$start_date =  wp_date('Y-m-01', strtotime('-1 year') );
			$end_date =  wp_date('Y-m-t', strtotime('-1 month') );
		}

	}
	/**
	 * Default dates.
	 * $_POST dates are checked incase the Per version is older than 5.0.0.
	 */
	if ( isset( $_POST['analytify_date_start'] ) && ! empty( $_POST['analytify_date_start'] ) && isset( $_POST['analytify_date_end'] ) && ! empty( $_POST['analytify_date_end'] ) ) {
		$start_date	= sanitize_text_field( wp_unslash( $_POST['analytify_date_start'] ) );
		$end_date	= sanitize_text_field( wp_unslash( $_POST['analytify_date_end'] ) );
	} 

	return array(
		'start_date' => $start_date,
		'end_date'   => $end_date
	);
}

/**
 * This function is provided by bcmath extension.
 * and is used by new GA library. check if the 
 * function exists if not add our own definition
 * of this function.
 * 
 * @since 5.0.3
 */
if ( !function_exists('bccomp') ) {
	function bccomp($left_operand, $right_operand, $scale = 0) {
	  // Implement the bccomp function using regular PHP math operations
	  // Here's a simple example implementation:
	  if ($left_operand > $right_operand) {
		return 1;
	  } else if ($left_operand < $right_operand) {
		return -1;
	  } else {
		return 0;
	  }
	} 

}
  
/**
 * Queue some JavaScript code to be output in the footer.
 *
 * @param string $code
 */
function wpa_enqueue_js( $code ) {
	global $wpa_queued_js;

	if ( empty( $wpa_queued_js ) ) {
		$wpa_queued_js = '';
	}

	$wpa_queued_js .= "\n" . $code . "\n";
}

/**
 * Output any queued javascript code in the footer.
 */
function wpa_print_js() {
	global $wpa_queued_js;

	if ( ! empty( $wpa_queued_js ) ) {

		echo "<!-- Analytify footer JavaScript -->\n<script type=\"text/javascript\">\njQuery(function($) {";

		// Sanitize
		$wpa_queued_js = wp_check_invalid_utf8( $wpa_queued_js );
		$wpa_queued_js = preg_replace( '/&#(x)?0*(?(1)27|39);?/i', "'", $wpa_queued_js );
		$wpa_queued_js = str_replace( "\r", '', $wpa_queued_js );

		echo $wpa_queued_js . "});\n</script>\n";

		unset( $wpa_queued_js );
	}
}

/**
 * Change the admin footer text on Analytify admin pages
 *
 * @since  1.2.4
 * @param  string $footer_text
 * @return string
 */
function wpa_admin_rate_footer_text( $footer_text ) {

	$rate_text = '';
	$current_screen = get_current_screen();

	// Add the Analytify admin pages
	$wpa_pages[] = 'toplevel_page_analytify-dashboard';
	$wpa_pages[] = 'analytify_page_analytify-campaigns';
	$wpa_pages[] = 'analytify_page_analytify-settings';

	// update_option( 'analytify_admin_footer_text_rated', 0 );
	// Check to make sure we're on a Analytify admin pages
	if ( isset( $current_screen->id ) && in_array( $current_screen->id, $wpa_pages ) ) {
		// Change the footer text
		if ( ! get_option( 'analytify_admin_footer_text_rated' ) ) {
				$rate_text = sprintf( esc_html__( 'If you like %1$s Analytify %2$s please leave us a %5$s %3$s %6$s rating. %4$s A huge thank you from %1$s WPBrigade %2$s in advance!', 'wp-analytify' ), '<strong>', '</strong>', '&#9733;&#9733;&#9733;&#9733;&#9733;', '<br />', '<a href="https://analytify.io/go/rate-analytify" target="_blank" class="wpa-rating-footer" data-rated="Thanks dude ;)">', '</a>' );
					wpa_enqueue_js( "
                        jQuery('a.wpa-rating-footer').on('click', function() {
                            jQuery.post( '" . admin_url( 'admin-ajax.php' ) . "', { action: 'analytify_rated' } );
                            jQuery(this).parent().text( jQuery(this).data( 'rated' ) );
                        });
                    " );
		} else {
			$rate_text = esc_html_e( 'Thank you for tracking with Analytify.', 'wp-analytify' );
		}

		return $rate_text;
	}

	return $footer_text;
}

/**
 * Delete the cache of dashboard sections
 *
 * @since  1.2.6
 * @param  $start_date Start Date
 * @param  $end_date End Date
 * @return void
 */

function delete_dashboard_transients( $dashboard_profile_ID, $start_date, $end_date ) {

	delete_transient( md5( 'show-overall-dashboard'      . $dashboard_profile_ID . $start_date . $end_date ) );
	delete_transient( md5( 'show-top-pages-dashboard'    . $dashboard_profile_ID . $start_date . $end_date ) );
	delete_transient( md5( 'show-country-dashboard'      . $dashboard_profile_ID . $start_date . $end_date ) );
	delete_transient( md5( 'show-city-dashboard'         . $dashboard_profile_ID . $start_date . $end_date ) );
	delete_transient( md5( 'show-keywords-dashboard'     . $dashboard_profile_ID . $start_date . $end_date ) );
	delete_transient( md5( 'show-social-dashboard'       . $dashboard_profile_ID . $start_date . $end_date ) );
	delete_transient( md5( 'show-browser-dashboard'      . $dashboard_profile_ID . $start_date . $end_date ) );
	delete_transient( md5( 'show-os-dashboard'           . $dashboard_profile_ID . $start_date . $end_date ) );
	delete_transient( md5( 'show-mobile-dashboard'       . $dashboard_profile_ID . $start_date . $end_date ) );
	delete_transient( md5( 'show-referrer-dashboard'     . $dashboard_profile_ID . $start_date . $end_date ) );
	delete_transient( md5( 'show-page-stats-dashboard'   . $dashboard_profile_ID . $start_date . $end_date ) );

	delete_transient( md5( 'show-default-overall-dashboard' 			 . $dashboard_profile_ID . $start_date . $end_date ) );
	delete_transient( md5( 'show-default-overall-device-dashboard' . $dashboard_profile_ID . $start_date . $end_date ) );
	delete_transient( md5( 'show-default-overall-dashboard-compare'. $dashboard_profile_ID . $start_date . $end_date ) );
	delete_transient( md5( 'show-default-top-pages-dashboard' 		 . $dashboard_profile_ID . $start_date . $end_date ) );
	delete_transient( md5( 'show-geographic-countries-dashboard' 	 . $dashboard_profile_ID . $start_date . $end_date ) );
	delete_transient( md5( 'show-geographic-cities-dashboard' 		 . $dashboard_profile_ID . $start_date . $end_date ) );
	delete_transient( md5( 'show-default-browser-dashboard'				 . $dashboard_profile_ID . $start_date . $end_date ) );
	delete_transient( md5( 'show-default-os-dashboard'						 . $dashboard_profile_ID . $start_date . $end_date ) );
	delete_transient( md5( 'show-default-mobile-dashboard'				 . $dashboard_profile_ID . $start_date . $end_date ) );
	delete_transient( md5( 'show-default-keyword-dashboard'				 . $dashboard_profile_ID . $start_date . $end_date ) );
	delete_transient( md5( 'show-default-pages-dashboard'					 . $dashboard_profile_ID . $start_date . $end_date ) );
	delete_transient( md5( 'show-default-social-dashboard'				 . $dashboard_profile_ID . $start_date . $end_date ) );
	delete_transient( md5( 'show-default-reffers-dashboard'				 . $dashboard_profile_ID . $start_date . $end_date ) );
	delete_transient( md5( 'show-default-reffers-dashboard'				 . $dashboard_profile_ID . $start_date . $end_date ) );
	delete_transient( md5( 'show-default-new-returning-dashboard'  . $dashboard_profile_ID . $start_date . $end_date ) );


}


/**
 * Dashboard settings backward compatibility till 1.2.5
 *
 * @since 1.2.6
 */
function wpa_dashboard_compatible() {

	$version = get_option( 'wpa_current_version' );

	if ( ! $version ) {
		// Run when version is less or equal than 1.2.5
		update_option( 'access_role_dashboard', array(
			'administrator',
			'editor',
		));
		update_option( 'dashboard_panels',  array(
			'show-real-time',
			'show-overall-dashboard',
			'show-top-pages-dashboard',
			'show-os-dashboard',
			'show-country-dashboard',
			'show-keywords-dashboard',
			'show-social-dashboard',
			'show-browser-dashboard',
			'show-referrer-dashboard',
			'show-page-stats-dashboard',
			'show-mobile-dashboard',
			'show-os-dashboard',
			'show-city-dashboard',
		));

		update_option( 'wpa_current_version', ANALYTIFY_VERSION );

	}

}



/**
 * Return classes for dashboard icons.
 * @param  string $class class name
 * @return string       return class.
 *
 * @since 2.0.0
 */
function pretty_class( $class ) {

	if ( "Google+" === $class ) {
		return 'analytify_google_plus';
	}
	else if ( "(not set)" === $class ) {
		return "analytify_not_set";
	}

 	return	"analytify_" . transliterateString( str_replace( array("’","‘",' & ','-',' '), '_', strtolower( $class ) ) );

}

/**
 * Replace special charters with alphabets
 *
 * @since 2.0.0
 */
function transliterateString( $txt ) {
    $transliterationTable = array('á' => 'a', 'Á' => 'A', 'à' => 'a', 'À' => 'A', 'ă' => 'a', 'Ă' => 'A', 'â' => 'a', 'Â' => 'A', 'å' => 'a', 'Å' => 'A', 'ã' => 'a', 'Ã' => 'A', 'ą' => 'a', 'Ą' => 'A', 'ā' => 'a', 'Ā' => 'A', 'ä' => 'ae', 'Ä' => 'AE', 'æ' => 'ae', 'Æ' => 'AE', 'ḃ' => 'b', 'Ḃ' => 'B', 'ć' => 'c', 'Ć' => 'C', 'ĉ' => 'c', 'Ĉ' => 'C', 'č' => 'c', 'Č' => 'C', 'ċ' => 'c', 'Ċ' => 'C', 'ç' => 'c', 'Ç' => 'C', 'ď' => 'd', 'Ď' => 'D', 'ḋ' => 'd', 'Ḋ' => 'D', 'đ' => 'd', 'Đ' => 'D', 'ð' => 'dh', 'Ð' => 'Dh', 'é' => 'e', 'É' => 'E', 'è' => 'e', 'È' => 'E', 'ĕ' => 'e', 'Ĕ' => 'E', 'ê' => 'e', 'Ê' => 'E', 'ě' => 'e', 'Ě' => 'E', 'ë' => 'e', 'Ë' => 'E', 'ė' => 'e', 'Ė' => 'E', 'ę' => 'e', 'Ę' => 'E', 'ē' => 'e', 'Ē' => 'E', 'ḟ' => 'f', 'Ḟ' => 'F', 'ƒ' => 'f', 'Ƒ' => 'F', 'ğ' => 'g', 'Ğ' => 'G', 'ĝ' => 'g', 'Ĝ' => 'G', 'ġ' => 'g', 'Ġ' => 'G', 'ģ' => 'g', 'Ģ' => 'G', 'ĥ' => 'h', 'Ĥ' => 'H', 'ħ' => 'h', 'Ħ' => 'H', 'í' => 'i', 'Í' => 'I', 'ì' => 'i', 'Ì' => 'I', 'î' => 'i', 'Î' => 'I', 'ï' => 'i', 'Ï' => 'I', 'ĩ' => 'i', 'Ĩ' => 'I', 'į' => 'i', 'Į' => 'I', 'ī' => 'i', 'Ī' => 'I', 'ĵ' => 'j', 'Ĵ' => 'J', 'ķ' => 'k', 'Ķ' => 'K', 'ĺ' => 'l', 'Ĺ' => 'L', 'ľ' => 'l', 'Ľ' => 'L', 'ļ' => 'l', 'Ļ' => 'L', 'ł' => 'l', 'Ł' => 'L', 'ṁ' => 'm', 'Ṁ' => 'M', 'ń' => 'n', 'Ń' => 'N', 'ň' => 'n', 'Ň' => 'N', 'ñ' => 'n', 'Ñ' => 'N', 'ņ' => 'n', 'Ņ' => 'N', 'ó' => 'o', 'Ó' => 'O', 'ò' => 'o', 'Ò' => 'O', 'ô' => 'o', 'Ô' => 'O', 'ő' => 'o', 'Ő' => 'O', 'õ' => 'o', 'Õ' => 'O', 'ø' => 'oe', 'Ø' => 'OE', 'ō' => 'o', 'Ō' => 'O', 'ơ' => 'o', 'Ơ' => 'O', 'ö' => 'oe', 'Ö' => 'OE', 'ṗ' => 'p', 'Ṗ' => 'P', 'ŕ' => 'r', 'Ŕ' => 'R', 'ř' => 'r', 'Ř' => 'R', 'ŗ' => 'r', 'Ŗ' => 'R', 'ś' => 's', 'Ś' => 'S', 'ŝ' => 's', 'Ŝ' => 'S', 'š' => 's', 'Š' => 'S', 'ṡ' => 's', 'Ṡ' => 'S', 'ş' => 's', 'Ş' => 'S', 'ș' => 's', 'Ș' => 'S', 'ß' => 'SS', 'ť' => 't', 'Ť' => 'T', 'ṫ' => 't', 'Ṫ' => 'T', 'ţ' => 't', 'Ţ' => 'T', 'ț' => 't', 'Ț' => 'T', 'ŧ' => 't', 'Ŧ' => 'T', 'ú' => 'u', 'Ú' => 'U', 'ù' => 'u', 'Ù' => 'U', 'ŭ' => 'u', 'Ŭ' => 'U', 'û' => 'u', 'Û' => 'U', 'ů' => 'u', 'Ů' => 'U', 'ű' => 'u', 'Ű' => 'U', 'ũ' => 'u', 'Ũ' => 'U', 'ų' => 'u', 'Ų' => 'U', 'ū' => 'u', 'Ū' => 'U', 'ư' => 'u', 'Ư' => 'U', 'ü' => 'ue', 'Ü' => 'UE', 'ẃ' => 'w', 'Ẃ' => 'W', 'ẁ' => 'w', 'Ẁ' => 'W', 'ŵ' => 'w', 'Ŵ' => 'W', 'ẅ' => 'w', 'Ẅ' => 'W', 'ý' => 'y', 'Ý' => 'Y', 'ỳ' => 'y', 'Ỳ' => 'Y', 'ŷ' => 'y', 'Ŷ' => 'Y', 'ÿ' => 'y', 'Ÿ' => 'Y', 'ź' => 'z', 'Ź' => 'Z', 'ž' => 'z', 'Ž' => 'Z', 'ż' => 'z', 'Ż' => 'Z', 'þ' => 'th', 'Þ' => 'Th', 'µ' => 'u', 'а' => 'a', 'А' => 'a', 'б' => 'b', 'Б' => 'b', 'в' => 'v', 'В' => 'v', 'г' => 'g', 'Г' => 'g', 'д' => 'd', 'Д' => 'd', 'е' => 'e', 'Е' => 'E', 'ё' => 'e', 'Ё' => 'E', 'ж' => 'zh', 'Ж' => 'zh', 'з' => 'z', 'З' => 'z', 'и' => 'i', 'И' => 'i', 'й' => 'j', 'Й' => 'j', 'к' => 'k', 'К' => 'k', 'л' => 'l', 'Л' => 'l', 'м' => 'm', 'М' => 'm', 'н' => 'n', 'Н' => 'n', 'о' => 'o', 'О' => 'o', 'п' => 'p', 'П' => 'p', 'р' => 'r', 'Р' => 'r', 'с' => 's', 'С' => 's', 'т' => 't', 'Т' => 't', 'у' => 'u', 'У' => 'u', 'ф' => 'f', 'Ф' => 'f', 'х' => 'h', 'Х' => 'h', 'ц' => 'c', 'Ц' => 'c', 'ч' => 'ch', 'Ч' => 'ch', 'ш' => 'sh', 'Ш' => 'sh', 'щ' => 'sch', 'Щ' => 'sch', 'ъ' => '', 'Ъ' => '', 'ы' => 'y', 'Ы' => 'y', 'ь' => '', 'Ь' => '', 'э' => 'e', 'Э' => 'e', 'ю' => 'ju', 'Ю' => 'ju', 'я' => 'ja', 'Я' => 'ja');
    return str_replace( array_keys ( $transliterationTable ), array_values( $transliterationTable ), $txt );
}


/**
 * Helper function for translation.
 */
if ( ! function_exists( 'analytify__' ) ) {
	/**
	 * Wrapper for __() gettext function.
	 * @param  string $string     Translatable text string
	 * @param  string $textdomain Text domain, default: wp-analytify
	 * @return void
	 */
	function analytify__( $string, $textdomain = 'wp-analytify' ) {
		return __( $string, $textdomain );
	}
}

if ( ! function_exists( 'analytify_e' ) ) {
	/**
	 * Wrapper for _e() gettext function.
	 * @param  string $string     Translatable text string
	 * @param  string $textdomain Text domain, default: wp-analytify
	 * @return void
	 */
	function analytify_e( $string, $textdomain = 'wp-analytify' ) {
		echo __( $string, $textdomain );
	}
}


/**
 * Get Analytify site link with refferal data.
 * @param  string $url          Page url default set to pricing page.
 * @param  string $campaing_url Campaings parameters.
 *
 * @since 2.1.21
 */
function analytify_get_update_link( $url = '', $campaing_url = '' ) {

	if ( defined( 'ANALYTIFY_AFFILIATE_ID' ) ) {
		$ref_id = ANALYTIFY_AFFILIATE_ID;
	}

	if ( $url == '' ) {
		$url = 'https://analytify.io/pricing/';
	}

	if ( empty( $ref_id ) ) {
		return $url . $campaing_url;
	}

	return $url . 'ref/' . $ref_id . '/' . $campaing_url;

}

/**
* Ignore tracking if user excluded.
*
* @since 2.1.21
*/
function analytify_is_track_user() {

	global $current_user;
	$roles = $current_user->roles;
	$is_track = $GLOBALS['WP_ANALYTIFY']->settings->get_option( 'exclude_users_tracking','wp-analytify-profile', array() );

	if ( is_user_logged_in() && in_array( $roles[0], $is_track ) ) {
		return false;
	} else {
		return true;
	}

}

/**
 * Add custom admin notice
 * @param  string $message Custom Message
 * @param  string $class   wp-analytify-success,wp-analytify-danger
 *
 * @since 2.1.22
 */
 function analytify_notice( $message, $class = 'wp-analytify-success' ) {
		echo '<div class="wp-analytify-notification '. $class .'">
							<a class="" href="#" aria-label="Dismiss the welcome panel"></a>
							<div class="wp-analytify-notice-logo">
								<img src="' . plugins_url( 'assets/img/notice-logo.svg', dirname ( __FILE__ ) ) . '" alt="">
							</div>
							<div class="wp-analytify-notice-discription">
								<p>' . $message .'</p>
							</div>
				</div>';
 }




class WP_ANALYTIFY_FUNCTIONS {


	/**
	 * @param  [string] page name
	 * @param  string custom message
	 * @return [boolean] true or false
	 *
	 * @since  [1.3]
	 */
	public static function wpa_check_profile_selection( $type, $message = '' ) {

		$_analytify_profile = get_option( 'wp-analytify-profile' );
		$dashboard_profile = isset ( $_analytify_profile['profile_for_dashboard'] ) ? $_analytify_profile['profile_for_dashboard'] : '';

		if ( empty( $dashboard_profile ) ) {

			if ( $message == '' ) {
			//  echo sprintf( esc_html__( '%1$s %2$s' . $type . ' Dashboard can\'t be loaded until your select your website profile %3$s here %4$s %5$s %6$s', 'wp-analytify' ), '<div class="error notice is-dismissible">', '<p>', '<a style="text-decoration:none" href="' . menu_page_url( 'analytify-settings', false ) . '#wp-analytify-profile">', '</a>', '</p>', '</div>' ); 

				$class   = 'wp-analytify-danger';
				$link    = menu_page_url( 'analytify-settings', false ) . '#wp-analytify-profile';
				$notice_message = sprintf( esc_html__( $type . ' Dashboard can\'t be loaded until you select your website profile %1$s here%2$s.', 'wp-analytify' ), '<a style="text-decoration:none" href="'. $link .'">', '</a>' );
				analytify_notice( $notice_message, $class );
			} else {
				echo $message; 
			}
			return true;

		} else {
			return false;
		}
	}

	/**
	 * General Redirect URL to
	 *
	 * @return [type] [description]
	 */
	public static function generate_login_url() {
		$wp_analytify = $GLOBALS['WP_ANALYTIFY'];
		$url = array(
			'next'            => $wp_analytify->pa_setting_url(),
			'scope'           => ANALYTIFY_SCOPE_FULL,
			'response_type'   => 'code',
			'access_type'     => 'offline',
			'approval_prompt' => 'force',
		);

		if ( 'on' == $wp_analytify->settings->get_option( 'user_advanced_keys','wp-analytify-advanced' ) ) {
			$redirect_url   = $wp_analytify->settings->get_option( 'redirect_uri','wp-analytify-advanced' );
			$client_id      = $wp_analytify->settings->get_option( 'client_id','wp-analytify-advanced' );

			$url['redirect_uri'] = $redirect_url;
			$url['client_id']    = $client_id;
		} else {
			$url['redirect_uri'] = ANALYTIFY_REDIRECT;
			$url['client_id']    = ANALYTIFY_CLIENTID;
			// used to redirect the user back to site.
			$url['state']        = get_admin_url() . 'admin.php?page=analytify-settings';
		}
		return http_build_query( $url );
	}



	public static function fetch_profiles_list() {

		$wp_analytify = $GLOBALS['WP_ANALYTIFY'];
		$profiles = get_transient( 'profiles_list' );

		if ( ! $profiles && get_option( 'pa_google_token' ) ) {

			$profiles = $wp_analytify->pt_get_analytics_accounts();
			set_transient( 'profiles_list' , $profiles, 0 );
		}

		return $profiles;
	}

	/**
	 * Fetch list of all profiles in dropdown
	 *
	 * @since  2.0.0
	 * @return object accounts list
	 */
	public static function fetch_profiles_list_summary() {

		$wp_analytify = $GLOBALS['WP_ANALYTIFY'];
		$profiles = get_option( 'profiles_list_summary' );

		if ( ! $profiles && get_option( 'pa_google_token' ) ) {

			$profiles = $wp_analytify->pt_get_analytics_accounts_summary();
			update_option( 'profiles_list_summary' , $profiles );
		}

		return $profiles;
	}

	/**
	 * Returns the property list that was saved after fetching from Google.
	 * If DB does not contains the list, get using Google's method for UA and GA4.
	 *
	 * @param string $mode Mode (UA or GA4).
	 * @return array
	 */
	public static function fetch_ga_properties( $mode = 'both' ) {
		$wp_analytify = $GLOBALS['WP_ANALYTIFY'];
		if ( $wp_analytify->get_ga4_exception() ) {
			WPANALYTIFY_Utils::handle_exceptions( $wp_analytify->get_ga4_exception() );
		}

		$properties = get_option( 'analytify-ga-properties-summery' );

		// If option is not set yet, get and generate property list for both UA and GA4.
		if ( empty( $properties['GA4'] ) && empty( $properties['UA'] ) && get_option( 'pa_google_token' ) ) {

			$wp_analytify = $GLOBALS['WP_ANALYTIFY'];
			// Store all UA properties.
			error_reporting(error_reporting() ^ E_DEPRECATED); // toggle E_DEPRECATED (off)
			$properties['UA'] = array();
			error_reporting(error_reporting() ^ E_DEPRECATED); // toggle E_DEPRECATED (back on)
			// Store all GA4 properties.
			$properties['GA4'] = array();

			// Fetch ga4 or UA properties based on the google analytics version.
			if ( 'ga4' === WPANALYTIFY_Utils::get_ga_mode() ) {
				$ga4_profiles_raw = $wp_analytify->get_ga_properties();
				if ( ! empty( $ga4_profiles_raw ) ) {
					foreach ( $ga4_profiles_raw as $parent_account_name => $account_properties ) {
						foreach ( $account_properties as $property_item ) {
							// Push into an array with the property name as key and profile ID as child key.
							$properties['GA4'][ $parent_account_name ][ 'ga4:' . $property_item['id'] ] = array(
								'name'            => $property_item['display_name'],
								'code'            => $property_item['id'],
								'property_id'     => '',
								'website_url'     => '',
								'web_property_id' => '',
								'view_id'         => '',
							);
						}
					}
				}
			} elseif ( 'ga3' === WPANALYTIFY_Utils::get_ga_mode() ) {
				$ua_profiles_raw  = $wp_analytify->pt_get_analytics_accounts_summary();
				if ( ! empty( $ua_profiles_raw ) && isset( $ua_profiles_raw->items ) ) {
					foreach ( $ua_profiles_raw->getItems() as $account ) {
						foreach ( $account->getWebProperties() as $key => $property ) {
							foreach ( $property->getProfiles() as $profile ) {
								// Push into an array with the property name as key and profile ID as child key.
								$properties['UA'][ $property->getName() ][ $profile->getId() ] = array(
									'name'            => $profile->getName(),
									'code'            => $property->getId(),
									'property_id'     => $account->getId(),
									'website_url'     => $property->getWebsiteUrl(),
									'web_property_id' => $property->getInternalWebPropertyId(),
									'view_id'         => $profile->getId(),
								);
							}
						}
					}
				}
			}

			update_option( 'analytify-ga-properties-summery', $properties );
		}

		return $properties;

	}

	/**
	 * This function is used to fetch the profile name, UA Code from selected account/property.
	 *
	 * @param string|int $id    - Profile ID.
	 * @param string     $index - Type of info wanted.
	 * @return string
	 */
	public static function search_profile_info( $id, $index ) {

		if ( ! get_option( 'pa_google_token' ) ) {
			return;
		}

		$ga_properties = self::fetch_ga_properties();
		$ga_properties = WPANALYTIFY_Utils::get_ga_mode() == 'ga4' ? $ga_properties['GA4'] : $ga_properties['UA'];

		if ( empty( $ga_properties ) ) {
			return;
		}

		foreach ( $ga_properties as $account => $properties ) {
			foreach ( $properties as $property_id => $property ) {
				if ( $property_id == $id ) {
					switch ( $index ) {
						case 'webPropertyId':
							return $property['code'];
						case 'websiteUrl':
							return $property['website_url'];
						case 'name':
							return $property['name'];
						case 'accountId':
							return $property['property_id'];
						case 'internalWebPropertyId':
							return $property['web_property_id'];
						case 'viewId':
							return $property['view_id'];
						default:
							return '';
					}
				}
			}
		}

		return '';
	}

	/**
	 * This function is used to fetch the property information
	 *
	 * @param string $name Name of the value required. Accepts:property_id, stream_name, measurement_id, url
	 * 
	 * @return string
	 */
	public static function ga_reporting_property_info( $name ) {

		if ( ! get_option( 'pa_google_token' ) ) { 
			return ''; 
		}

		$property_data = get_option( 'analytify_reporting_property_info', false );

		if ( ! $property_data ) {
			return ''; 
		}

		switch ( $name ) {
			case ( 'property_id' === $name || 'webPropertyId' === $name ) :
				$value = $property_data['property_id'];
				break;
			case ( 'stream_name' === $name || 'name' === $name ) :
				$value = str_replace( ' - ' . $property_data['url'], '', $property_data['stream_name'] );
				break;
			case 'measurement_id':
				$value = $property_data['measurement_id'];
				break;
			case ( 'url' === $name || 'websiteUrl' === $name ) :
				$value = $property_data['url'];
				break;
			default:
				$value = '';
				break;
		}

		return $value;
	}

	/**
	 * Return the UA Code for selected profile.
	 *
	 * @since 2.0.4
	 */
	public static function get_UA_code() {
		$_ua_code = get_option( 'analytify_ua_code' );
		if ( $_ua_code ) {
			return $_ua_code;
		} 
		$_ua_code =	WP_ANALYTIFY_FUNCTIONS::search_profile_info( $GLOBALS['WP_ANALYTIFY']->settings->get_option( 'profile_for_posts', 'wp-analytify-profile' ), 'webPropertyId' );
		update_option( 'analytify_ua_code', $_ua_code );
		return $_ua_code;
	}

	public static function is_connected() {

	}

	public static function is_profile_selected() {
		$load_profile_settings = get_option( 'wp-analytify-profile' );
		if ( !empty( $load_profile_settings['profile_for_posts'] ) && !empty( $load_profile_settings['profile_for_dashboard'] ) ) {
			return true;
		}
		return false;
	}

	public static function get_ga_report_url( $dashboard_profile_ID ) {
		if ( 'ga4' === WPANALYTIFY_Utils::get_ga_mode() ) {
			return 'p' . WPANALYTIFY_Utils::get_reporting_property();
		} else {
			return 'a' .  WP_ANALYTIFY_FUNCTIONS::search_profile_info( $dashboard_profile_ID, 'accountId' ) . 'w' . WP_ANALYTIFY_FUNCTIONS::search_profile_info( $dashboard_profile_ID, 'internalWebPropertyId' ) . 'p' . $dashboard_profile_ID . '/';
		}	
	}

	public static function get_ga_report_range( $start_date, $end_date, $compare_start_date, $compare_end_date ) {
		return '%3F_u.date00%3D' . str_replace( '-', '', $start_date ) .'%26_u.date01%3D' . str_replace( '-', '', $end_date ) . '%26_u.date10%3D' . str_replace( '-', '', $compare_start_date ) .'%26_u.date11%3D' . str_replace( '-', '', $compare_end_date ) ;
	}
}

function analytify_get_logger() {
	static $logger = null;

	$class = apply_filters( 'woocommerce_logging_class', 'ANALYTIFY_Logger' );

	if ( null === $logger || ! is_a( $logger, $class ) ) {
		$implements = class_implements( $class );

		if ( is_array( $implements ) && in_array( 'ANALYTIFY_Logger_Interface', $implements, true ) ) {
			if ( is_object( $class ) ) {
				$logger = $class;
			} else {
				$logger = new $class();
			}

		}
	}

	return $logger;
}


/**
 * Registers the default log handler.
 *
 * @since 2.1.23
 * @param array $handlers Handlers.
 * @return array
 */
function analytify_register_default_log_handler( $handlers ) {
	if ( defined( 'ANALYTIFY_LOG_HANDLER' ) && class_exists( ANALYTIFY_LOG_HANDLER ) ) {
		$handler_class   = ANALYTIFY_LOG_HANDLER;
		$default_handler = new $handler_class();
	} else {
		$default_handler = new ANALYTIFY_Log_Handler_File();
	}

	array_push( $handlers, $default_handler );

	return $handlers;
}
add_filter( 'analytify_register_log_handlers', 'analytify_register_default_log_handler' );


/**
 * Remove non-Analytify notices from Analytify page.
 *
 * @since 2.1.23
 */
function hide_non_analytify_notice () {
	// Return if not Analytify page.
	if ( empty( $_REQUEST['page'] ) || strpos( $_REQUEST['page'], 'analytify' ) === false ) {
		return;
	}

	global $wp_filter;
	if ( !empty( $wp_filter['user_admin_notices']->callbacks ) && is_array( $wp_filter['user_admin_notices']->callbacks ) ) {
		foreach( $wp_filter['user_admin_notices']->callbacks as $priority => $hooks ) {
			foreach ( $hooks as $name => $arr ) {

				if ( is_object( $arr['function'] ) && $arr['function'] instanceof Closure ) {
					unset( $wp_filter['user_admin_notices']->callbacks[ $priority ][ $name ] );
					continue;
				}

				if ( ( ! empty( $arr['function'][0] ) && is_object( $arr['function'][0] ) && strpos( strtolower( get_class( $arr['function'][0] ) ), 'analytify' ) !== false ) || 'WPANALYTIFY_Utils' == $arr['function'][0] ) {
					continue;
				}
				if ( !empty( $name ) && strpos( $name, 'analytify' ) === false ) {
					unset( $wp_filter['user_admin_notices']->callbacks[$priority][$name] );
				}
			}
		}
	}

	if ( !empty( $wp_filter['admin_notices']->callbacks ) && is_array( $wp_filter['admin_notices']->callbacks ) ) {
		foreach( $wp_filter['admin_notices']->callbacks as $priority => $hooks ) {
			foreach ( $hooks as $name => $arr ) {
				if ( is_object( $arr['function'] ) && $arr['function'] instanceof Closure ) {
					unset( $wp_filter['admin_notices']->callbacks[ $priority ][ $name ] );
					continue;
				}
				if ( ( ! empty( $arr['function'][0] ) && is_object( $arr['function'][0] ) && strpos( strtolower( get_class( $arr['function'][0] ) ), 'analytify' ) !== false ) || 'WPANALYTIFY_Utils' == $arr['function'][0] ) {
					continue;
				}
				if ( !empty( $name ) && strpos( $name, 'analytify' ) === false ) {
					unset( $wp_filter['admin_notices']->callbacks[$priority][$name] );
				}
			}
		}
	}

	if ( !empty( $wp_filter['all_admin_notices']->callbacks ) && is_array( $wp_filter['all_admin_notices']->callbacks ) ) {
		foreach( $wp_filter['all_admin_notices']->callbacks as $priority => $hooks ) {
			foreach ( $hooks as $name => $arr ) {

				if ( is_object( $arr['function'] ) && $arr['function'] instanceof Closure ) {
					unset( $wp_filter['all_admin_notices']->callbacks[ $priority ][ $name ] );
					continue;
				}
				if ( ( ! empty( $arr['function'][0] ) && is_object( $arr['function'][0] ) && strpos( strtolower( get_class( $arr['function'][0] ) ), 'analytify' ) !== false ) || 'WPANALYTIFY_Utils' == $arr['function'][0] ) {
					continue;
				}
				if ( !empty( $name ) && strpos( $name, 'analytify' ) === false ) {
					unset( $wp_filter['all_admin_notices']->callbacks[$priority][$name] );
				}
			}
		}
	}
}
add_action( 'admin_print_scripts', 'hide_non_analytify_notice' );
add_action( 'admin_head', 'hide_non_analytify_notice', PHP_INT_MAX  );
