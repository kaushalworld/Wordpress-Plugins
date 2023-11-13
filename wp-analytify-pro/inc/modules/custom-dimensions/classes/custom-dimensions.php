<?php
class Analytify_Google_Dimensions extends WP_Analytify_Pro_Base {

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 */
	protected $plugin_name = 'wp-analytify-custom-dimensions';

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {

		$this->includes();
		$this->admin_hooks();
		$this->public_hooks();
	}

	private function includes() {

		require ANALYTIFY_PRO_ROOT_PATH . '/inc/modules/custom-dimensions/classes/analytify-dimensions-tracking.php';
	}

	/**
	 * Define constant if not already set
	 *
	 * @param  string      $name
	 * @param  string|bool $value
	 */
	private function define( $name, $value ) {

		if ( ! defined( $name ) ) {
			define( $name, $value );
		}
	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function admin_hooks() {

		add_action( 'admin_enqueue_scripts' , array( $this, 'admin_scripts' ) );
		add_action( 'analytify_dashboad_dropdown_option' , array( $this, 'dashboad_dropdown_option' ) );
		add_action( 'analytify_add_submenu', array( $this, 'add_menu_option' ), 65 );
		add_action( 'analytify_settings_logs', array( $this, 'settings_logs' ) );

	}

	public function dashboad_dropdown_option() {
		echo '<li><a href="'. admin_url( 'admin.php?page=analytify-dimensions' ) .'">'. __( 'Dimensions', 'wp-analytify-custom-dimensions' ) .'</a></li>';
	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function public_hooks() {

    	add_action( 'wp_analytify_dimensions_tab', array( $this, 'dimensions_tab' ) );
    	add_filter( 'wp_analytify_pro_setting_fields', array( $this, 'dimensions_setting_fields' ) , 20, 1 );
    	add_action( 'wp_analytify_pro_setting_tabs' , array( $this, 'dimensions_setting_tabs' ) , 20 , 1 );
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {

		return $this->plugin_name;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {

		return $this->version;
	}
	/**
	 * Enqueue admin scripts.
	 *
	 * @since 1.0.0
	 */
	public function admin_scripts( $page ) {

		if ( 'analytify_page_analytify-settings' === $page ) {
			wp_enqueue_style('analytify_dimension_style', plugins_url( 'assets/css/main.css', dirname( __FILE__ ) ), array(), false );
			wp_enqueue_script( 'analytify_dimension_script', plugins_url( 'assets/js/main.js', dirname( __FILE__ ) ), array( 'jquery' ), false, 'true' );
			wp_localize_script( 'analytify_dimension_script', 'analytify_dimension', array(
				'reporting_mode' => method_exists( 'WPANALYTIFY_Utils', 'get_ga_mode' ) ? WPANALYTIFY_Utils::get_ga_mode() : 'ga3',
			) );
		}
	}

	/**
	 * Add sttings tab for plugin.
	 *
	 * @since 1.0.0
	 */
	public function dimensions_setting_tabs( $old_tabs ) {

		$pro_tabs = array(
			array(
				'id'       => 'wp-analytify-custom-dimensions',
				'title'    => __( 'Dimensions', 'wp-analytify-custom-dimensions' ),
				'priority' => '0',
			),
		);

		return array_merge( $old_tabs,$pro_tabs );
	}

	/**
	 * Add diemnsions settings fileds.
	 *
	 * @since 1.0.0
	 */
	public function dimensions_setting_fields( $old_fields ) {
		$pro_fields = array(
				'wp-analytify-custom-dimensions' => array(
					array(
						'name'    => 'analytiy_custom_dimensions',
						'label'   => __( 'Add Custom Dimensions', 'wp-analytify-custom-dimensions' ),
						'desc'    => __( 'Learn and Setup custom dimensions in Google Analytics.', 'wp-analytify-custom-dimensions' ),
						'type'    => ( method_exists( 'WPANALYTIFY_Utils', 'get_ga_mode' ) && 'ga4' === WPANALYTIFY_Utils::get_ga_mode() ) ? 'ga_dimensions_repeater' : 'dimensions_repeater',
						'default' => array(),
						'options' => self::get_current_dimensions(),
					)
				)
			);

		return array_merge( $old_fields, $pro_fields );
	}

	/**
	 * Get current list of all dimension.
	 *
	 * @since 1.0.0
	 * @return array
	 */
	public static function get_current_dimensions() {
		return array(
			'author'        => array(
				'title'     => __( 'Author', 'wp-analytify-pro' ),
				'is_enable' => true,
				'scope'     => 'hit',
				'value'     => 'wpa_author',
				'id'        => '1',
			),
			'post_type'   => array(
				'title'     => __( 'Post Type', 'wp-analytify-pro' ),
				'is_enable' => true,
				'scope'     => 'hit',
				'value'     => 'wpa_post_type',
				'id'        => '2',
			),
			'published_at'  => array(
				'title'     => __( 'Published at', 'wp-analytify-pro' ),
				'is_enable' => true,
				'scope'     => 'hit',
				'value'     => 'wpa_published_at',
				'id'        => '3',
			),
			'category'      => array(
				'title'     => __( 'Category', 'wp-analytify-pro' ),
				'is_enable' => true,
				'scope'     => 'hit',
				'value'     => 'wpa_post_category',
				'id'        => '4',
			),
			'tags'          => array(
				'title'     => __( 'Tags', 'wp-analytify-pro' ),
				'is_enable' => true,
				'scope'     => 'hit',
				'value'     => 'wpa_tags',
				'id'        => '5',
			),
			'user_id'       => array(
				'title'     => __( 'User ID', 'wp-analytify-pro' ),
				'is_enable' => true,
				'scope'     => 'sessions',
				'value'     => 'wpa_user_id',
				'id'        => '6',
			),
			'logged_in'     => array(
				'title'     => __( 'Logged in', 'wp-analytify-pro' ),
				'is_enable' => true,
				'scope'     => 'sessions',
				'value'     => 'wpa_logged_in',
				'id'        => '7',
			),
			'seo_score'     => array(
				'title'     => __( 'SEO Score', 'wp-analytify-pro' ),
				'is_enable' => self::yoast_seo_availability(),
				'scope'     => 'hit',
				'value'     => 'wpa_seo_score',
				'id'        => '8',
			),
			'focus_keyword' => array(
				'title'     => __( 'Focus Keyword', 'wp-analytify-pro' ),
				'is_enable' => self::yoast_seo_availability(),
				'metric'    => 'hit',
				'value'     => 'wpa_focus_keyword',
				'id'        => '9',
			),
		);
	}

	/**
	 * Check Yoast Free/Pro available.
	 *
	 * @since 1.0.0
	 * @return array
	 */
	private static function yoast_seo_availability() {

		return class_exists( 'WPSEO_Frontend' );
	}

	/**
	 * Add plugin menu page
	 *
	 * @since 1.0.0
	 */
	public function add_menu_option() {

		add_submenu_page( 'analytify-dashboard', 'Analytify Dimensions', __( 'Dimensions', 'wp-analytify-pro' ), 'manage_options', 'analytify-dimensions',  array( $this, 'pa_page_file_path' ), 47 );
	}

	/**
	 * Plugin menu callback
	 *
	 * @since 1.0
	 */
	public function pa_page_file_path() {

		$screen = get_current_screen();

		$wp_analytify   = $GLOBALS['WP_ANALYTIFY'];
		$selected_stats = $wp_analytify->settings->get_option( 'show_analytics_panels_dashboard', 'wp-analytify-dashboard', array() );

		$dashboard_profile_id = is_callable( array('WPANALYTIFY_Utils', 'get_reporting_property') ) ? WPANALYTIFY_Utils::get_reporting_property() : '';
		$access_token         = get_option( 'post_analytics_token' );
		$version              = defined( 'ANALYTIFY_PRO_VERSION' ) ? ANALYTIFY_PRO_VERSION : ANALYTIFY_VERSION;

		//Get the start date and end date from wpa-core-functions
		if ( function_exists( 'analytify_datepicker_dates' ) ) {
			extract( analytify_datepicker_dates() );
		} else {
			$start_date = wp_date( 'Y-m-d', strtotime( '-1 month' ) );
			$end_date   = wp_date( 'Y-m-d', strtotime( 'now' ) );
		}
		
		// Get compare dates for legacy version (before v5.0.0).
		$date_diff          = is_callable( array('WPANALYTIFY_Utils', 'calculate_date_diff') ) ? WPANALYTIFY_Utils::calculate_date_diff( $start_date, $end_date ) : array( 'start_date'=>'', 'end_date' => '' );
		$compare_start_date = $date_diff['start_date'];
		$compare_end_date   = $date_diff['end_date'];

		/*
		 * Check with roles assigned at dashboard settings.
		 */
		$is_access_level = $wp_analytify->settings->get_option( 'show_analytics_roles_dashboard', 'wp-analytify-dashboard' );

		// Show dashboard to admin incase of empty access roles.
		if ( empty( $is_access_level ) ) {
			$is_access_level = array( 'administrator' );
		}

		if ( $wp_analytify->pa_check_roles( $is_access_level ) ) {
			if ( $access_token ) {
				// Dequeue event calendar js.
				wp_dequeue_script( 'tribe-common' );

				require_once ANALYTIFY_PRO_ROOT_PATH . '/inc/modules/custom-dimensions/view/admin-dashboard.php';
			} else {
				_e( 'You must be authenticated to see the Analytics Dashboard.', 'wp-analytify-pro' );
			}
		} else {
			_e( 'You don\'t have access to Analytify Dashboard.', 'wp-analytify-pro' );
		}
	}

	/**
	 * Add events tracking  settings in diagnostic information.
	 *
	 */
	public function settings_logs() {

		echo "\r\n";

		echo "-- Custom Dimensions Setting --\r\n \r\n";
		
		$options	= get_option( 'wp-analytify-custom-dimensions' );
		$dimensions	= isset( $options['analytiy_custom_dimensions'] ) ? array_values( $options['analytiy_custom_dimensions'] ) : array();

		if ( method_exists( 'WPANALYTIFY_Utils', 'print_settings_array' ) ) {
			WPANALYTIFY_Utils::print_settings_array( array(
				'analytiy_custom_dimensions' => $dimensions
			) );
		}
	}

}

new Analytify_Google_Dimensions();
