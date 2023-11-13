<?php
/**
 * 
 * General Class used to set the base of the plugin.
 * It holds the analytics wrappers and sdk calls to fetch the data from Google.
 *
 * 
 * @since 1.0.0
 *
 *  @package WP_Analytify
 */

// Global variables.
define( 'ANALYTIFY_LIB_PATH', dirname( __FILE__ ) . '/lib/' );
define( 'ANALYTIFY_ID', 'wp-analytify-options' );
define( 'ANALYTIFY_NICK', 'Analytify' );
define( 'ANALYTIFY_ROOT_PATH', dirname( __FILE__ ) );
define( 'ANALYTIFY_VERSION', '5.0.5' );
define( 'ANALYTIFY_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'ANALYTIFY_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

// Grab client ID and client secret from https://console.developers.google.com/ after creating a project.
if ( get_option( 'wpa_current_version' ) ) { // Pro Keys
	define( 'ANALYTIFY_CLIENTID', '707435375568-9lria1uirhitcit2bhfg0rgbi19smjhg.apps.googleusercontent.com' );
	define( 'ANALYTIFY_CLIENTSECRET', 'b9C77PiPSEvrJvCu_a3dzXoJ' );
} else { // Free Keys
	define( 'ANALYTIFY_CLIENTID', '958799092305-7p6jlsnmv1dn44a03ma00kmdrau2i31q.apps.googleusercontent.com' );
	define( 'ANALYTIFY_CLIENTSECRET', 'Mzs1ODgJTpjk8mzQ3mbrypD3' );
}

/**
 * Sample options to flush the variables if AUTH api is not working
 * Routine in progress
 */
//var_dump(get_option( 'pa_google_token' ));
//var_dump(get_option( 'post_analytics_token' ));
// delete_option( 'pa_google_token' );
// delete_option( 'analytify-ga-properties-summery' );
// delete_option( 'post_analytics_token' );
//delete_option( 'analytify_authentication_date' );


// Basic read & write scope.
define( 'ANALYTIFY_SCOPE', 'https://www.googleapis.com/auth/analytics.readonly https://www.googleapis.com/auth/analytics.edit' );
// Full read & write and extra.
define( 'ANALYTIFY_SCOPE_FULL', 'https://www.googleapis.com/auth/analytics.readonly https://www.googleapis.com/auth/analytics https://www.googleapis.com/auth/analytics.edit https://www.googleapis.com/auth/webmasters' );

define( 'ANALYTIFY_REDIRECT', 'https://analytify.io/api/' );
define( 'ANALYTIFY_DEV_KEY', 'AIzaSyDXjBezSlaVMPk8OEi8Vw5aFvteouXHZpI' );
define( 'ANALYTIFY_STORE_URL', 'https://analytify.io' );
define( 'ANALYTIFY_PRODUCT_NAME', 'Analytify WordPress Plugin' );

include_once ANALYTIFY_PLUGIN_DIR . '/classes/analytify-settings.php';
include_once ANALYTIFY_PLUGIN_DIR . '/classes/analytify-utils.php';
include_once ANALYTIFY_PLUGIN_DIR . '/classes/analytify-mp-ga4.php';
include_once ANALYTIFY_PLUGIN_DIR . '/classes/analytify-sanitize.php';
include_once ANALYTIFY_PLUGIN_DIR . '/classes/analytify-update-routine.php';

if ( ! class_exists( 'Analytify_General' ) ) {

	/**
	 * Analytify_General Class for Analytify.
	 */
	class Analytify_General {

		public $settings;

		protected $state_data;
		protected $transient_timeout;
		protected $load_settings;
		protected $plugin_base;
		protected $plugin_settings_base;
		protected $cache_timeout;

		private $exception;

		// exceptions for ga4
		private $ga4_exception;
		private $modules;
		protected $is_reporting_in_ga4;

		// User added client id.
		private $user_client_id;
		
		// User added client secret.
		private $user_client_secret;
		/**
		 * Constructor of analytify-general class.
		 */
		public function __construct() {
			$this->transient_timeout    = 60 * 60 * 12;
			$this->plugin_base          = 'admin.php?page=analytify-dashboard';
			$this->plugin_settings_base = 'admin.php?page=analytify-settings';
			$this->exception            = get_option( 'analytify_profile_exception' );
			$this->ga4_exception        = get_option( 'analytify_ga4_exceptions' );
			$this->modules				= get_option( 'wp_analytify_modules' );
			// Setup Settings.
			$this->settings = new WP_Analytify_Settings();
			
			$this->is_reporting_in_ga4  = 'ga4' === WPANALYTIFY_Utils::get_ga_mode() ? true : false;

			if ( $this->is_reporting_in_ga4 === true ) {
				require_once ANALYTIFY_LIB_PATH . '/Google-GA4/vendor/autoload.php';
				$this->client = new Google\Client();
			} else {
				if ( ! class_exists( 'Analytify_Google_Client' ) ) {
					require_once ANALYTIFY_LIB_PATH . 'Google/Client.php';
					require_once ANALYTIFY_LIB_PATH . 'Google/Service/Analytics.php';
				}
				$this->client = new Analytify_Google_Client();
			}

			$this->client->setApprovalPrompt( 'force' );
			$this->client->setAccessType( 'offline' );

			if ( $this->settings->get_option( 'user_advanced_keys', 'wp-analytify-advanced', '' ) == 'on' ) {
				$this->user_client_id     = $this->settings->get_option( 'client_id' ,'wp-analytify-advanced' );
				$this->user_client_secret = $this->settings->get_option( 'client_secret' ,'wp-analytify-advanced' );
				$this->client->setClientId( $this->user_client_id );
				$this->client->setClientSecret( $this->user_client_secret );
				$this->client->setRedirectUri( $this->settings->get_option( 'redirect_uri', 'wp-analytify-advanced' ) );
			} else {
				$this->client->setClientId( ANALYTIFY_CLIENTID );
				$this->client->setClientSecret( ANALYTIFY_CLIENTSECRET );
				$this->client->setRedirectUri( ANALYTIFY_REDIRECT );
			}

			$this->client->setScopes( ANALYTIFY_SCOPE );

			if ( $this->is_reporting_in_ga4 === true ) {

				try {
					$this->service = new Google\Service\Analytics( $this->client );
					$this->pa_connect();
				} catch ( Exception $e ) {
					// Show error message only for logged in users.
					if ( current_user_can( 'manage_options' ) ) {
						echo sprintf( esc_html__( '%1$s Oops, Something went wrong. %2$s %5$s %2$s %3$s Don\'t worry, This error message is only visible to Administrators. %4$s %2$s ', 'wp-analytify' ), '<br /><br />', '<br />', '<i>', '</i>', esc_textarea( $e->getMessage() ) );
					}
				} catch ( Exception $e ) {
					// Show error message only for logged in users.
					if ( current_user_can( 'manage_options' ) ) {
						echo sprintf( esc_html__( '%1$s Oops, Try to %2$s Reset %3$s Authentication. %4$s %7$s %4$s %5$s Don\'t worry, This error message is only visible to Administrators. %6$s %4$s', 'wp-analytify' ), '<br /><br />', '<a href=' . esc_url( admin_url( 'admin.php?page=analytify-settings&tab=authentication' ) ) . 'title="Reset">', '</a>', '<br />', '<i>', '</i>', esc_textarea( $e->getMessage() ) );
					}
				}

			} else {

				try {
					$this->service = new Analytify_Google_Service_Analytics( $this->client );
					$this->pa_connect();
				} catch ( Exception $e ) {
					// Show error message only for logged in users.
					if ( current_user_can( 'manage_options' ) ) {
						echo sprintf( esc_html__( '%1$s Oops, Something went wrong. %2$s %5$s %2$s %3$s Don\'t worry, This error message is only visible to Administrators. %4$s %2$s ', 'wp-analytify' ), '<br /><br />', '<br />', '<i>', '</i>', esc_textarea( $e->getMessage() ) );
					}
				} catch ( Exception $e ) {
					// Show error message only for logged in users.
					if ( current_user_can( 'manage_options' ) ) {
						echo sprintf( esc_html__( '%1$s Oops, Try to %2$s Reset %3$s Authentication. %4$s %7$s %4$s %5$s Don\'t worry, This error message is only visible to Administrators. %6$s %4$s', 'wp-analytify' ), '<br /><br />', '<a href=' . esc_url( admin_url( 'admin.php?page=analytify-settings&tab=authentication' ) ) . 'title="Reset">', '</a>', '<br />', '<i>', '</i>', esc_textarea( $e->getMessage() ) );
					}
				}

			}

			add_action( 'after_setup_theme', array( $this, 'set_cache_time' ) );

			$this->set_tracking_mode();
			
		}

		/**
		 * Check the tracking method.
		 *
		 * @return string ga/gtag
		 */
		public function set_tracking_mode() {
			if ( ! defined( 'ANALYTIFY_TRACKING_MODE' ) ) {
				define( 'ANALYTIFY_TRACKING_MODE', $this->settings->get_option( 'gtag_tracking_mode', 'wp-analytify-advanced', 'ga' ) );
			}
		}
		/**
		 * Connect with Google Analytics API and get authentication token and save it. 
		 *
		 * @return void
		 */
		public function pa_connect() {
			$ga_google_authtoken = get_option( 'pa_google_token' );

			if ( ! empty( $ga_google_authtoken ) ) {

				$ga_google_authtoken = is_array( $ga_google_authtoken ) ? json_encode( $ga_google_authtoken ) : $ga_google_authtoken;

				$this->client->setAccessToken( $ga_google_authtoken );
			} else {

				$auth_code = get_option( 'post_analytics_token' );

				if ( empty( $auth_code ) ) { return false; }

				try {

					$access_token = $this->client->authenticate( $auth_code );
				} catch ( Exception $e ) {
					echo 'Analytify (Bug): ' . esc_textarea( $e->getMessage() );
					return false;
				}

				if ( $access_token ) {

					$this->client->setAccessToken( $access_token );

					update_option( 'pa_google_token', $access_token );
					update_option( 'analytify_authentication_date', date( 'l jS F Y h:i:s A' ) . date_default_timezone_get() );

					return true;
				} else {

					return false;
				}
			}

			if ( $this->is_reporting_in_ga4 === true ) {
				$access_token = $this->client->getAccessToken();	
				$access_token = $access_token['access_token'];
				$this->token = json_decode( $access_token );
			} else {
				$this->token = json_decode( $this->client->getAccessToken() );
			}

			return true;
		}

		/**
		 * Get the Google Analytics required authentication details.
		 *
		 * @return array
		 */
		private function get_ga_auth_details() {


			$raw_google_token = get_option( 'pa_google_token' );
			$google_token     = is_array( $raw_google_token ) ? $raw_google_token : json_decode( $raw_google_token, TRUE );

			if ( !empty( $google_token ) ) {
				return array(
					'credentials' => Google\ApiCore\CredentialsWrapper::build(array(
							'scopes'  => explode(' ', ANALYTIFY_SCOPE_FULL),
							'keyFile' => array(
								'type'          => 'authorized_user',
								'client_id'     => $this->user_client_id     ?? ANALYTIFY_CLIENTID ,
								'client_secret' => $this->user_client_secret ?? ANALYTIFY_CLIENTSECRET,
								'refresh_token' => $google_token['refresh_token'],
							)
						)),
				);
			}
		}

		/**
		 * Connect with Google Analytics data API.
		 *
		 * @return BetaAnalyticsDataClient
		 */
		private function connect_data_api() {

			$client = new Google\Analytics\Data\V1beta\BetaAnalyticsDataClient( $this->get_ga_auth_details() );

			return $client;
		}

		/**
		 * Connect with Google Analytics admin API.
		 * 
		 * @return AnalyticsAdminServiceClient
		 */
		private function connect_admin_api() {
			/**
			 * since a function in wp-analytify file is directly calling this method
			 * without executing the constructor first in result the ga4 libs are
			 * not included yet to avoid errors in this case we are doing require
			 * once here too.
			 */
			require_once ANALYTIFY_LIB_PATH . '/Google-GA4/vendor/autoload.php';
			$client = new Google\Analytics\Admin\V1alpha\AnalyticsAdminServiceClient( $this->get_ga_auth_details() );

			return $client;
		}

		/**
		 * Create web stream for Analytify tracking in Google Analytics.
		 * Stream types: Google\Analytics\Admin\V1alpha\DataStream\DataStreamType
		 *
		 * @param string $property_id
		 * 
		 * @return array Measurement data.
		 * 
		 * @since 5.0.0
		 */
		public function create_ga_stream( $property_id ) {
			$analytify_ga4_streams = get_option('analytify-ga4-streams');

			if( isset( $analytify_ga4_streams ) && isset( $analytify_ga4_streams[$property_id] ) && isset( $analytify_ga4_streams[$property_id]['measurement_id']) ) {
				return $analytify_ga4_streams[$property_id];
			}

			// Return if there is no property id given.
			if( empty( $property_id ) ) {
				return;
			}

			$admin_client = $this->connect_admin_api();
			$measurement_data = array();
			try {
				$formatted_property_name = $admin_client->propertyName( $property_id );
				$stream_name = 'Analytify - ' . get_site_url(); // Analytify defined stream name.

				$data_stream = new Google\Analytics\Admin\V1alpha\DataStream(
					array(
						'type' => 1,
						'display_name' => $stream_name
					) 
				);
				$web_data_stream = new Google\Analytics\Admin\V1alpha\DataStream\WebStreamData(
					array(
						'default_uri' => get_site_url(),
					) 
				);

				// Set data stream to web.
				$data_stream->setWebStreamData( $web_data_stream );

				try { // Try to create new stream.
					$web_stream = $admin_client->createDataStream( $formatted_property_name, $data_stream );
				} catch ( \Throwable $th ) { // Check if Analytify stream already exists.
					$response = $th->getMessage();
					$response = json_decode( $response );

					// Error code 6: ALREADY_EXISTS.
					if ( isset( $response->code ) && 6 === $response->code ) {
						WPANALYTIFY_Utils::remove_ga4_exception( 'create_stream_exception' );
						$paged_response = $admin_client->listDataStreams( $formatted_property_name );

						// Get pre created stream.
						foreach ( $paged_response->iterateAllElements() as $element ) {
							if ( $stream_name === $element->getDisplayName() ) {
								$web_stream = $element;
								break;
							}
						}
					} else {
						WPANALYTIFY_Utils::add_ga4_exception( 'create_stream_exception', $response->reason, $response->message );
					}
				}

				if ( $web_stream ) {
					WPANALYTIFY_Utils::remove_ga4_exception( 'create_stream_exception' );
					$measurement_data = array(
						'full_name'      => $web_stream->getName(),
						'property_id'    => $property_id,
						'stream_name'    => $web_stream->getDisplayName(),
						'measurement_id' => $web_stream->getWebStreamData()->getMeasurementId(),
						'url'            => $web_stream->getWebStreamData()->getDefaultUri(),
					);
				
				if( empty( $analytify_ga4_streams ) ) {
					$analytify_ga4_streams = array();
				}
				$analytify_ga4_streams[$property_id][$web_stream->getWebStreamData()->getMeasurementId()] = $measurement_data;
				update_option('analytify-ga4-streams', $analytify_ga4_streams);
				}
			} catch( \Throwable $th ) {
				$logger = analytify_get_logger();
				$logger->warning( $th->getMessage(), array( 'source' => 'analytify_create_stream_errors' ) );
			} finally {
				$admin_client->close();
			}

			return $measurement_data;
		}

		/**
		 * Fetches all the Google Analytics 4 data streams for a given property.
		 *
		 * @param string $property_id The ID of the property for which to fetch the data streams.
		 *
		 * @return array|false Array of data stream objects if found, otherwise false or empty array.
		 */
		public function get_ga_streams( $property_id ) {
			// If no property ID specified, return false.
			if ( empty( $property_id ) ) {
				return false;
			}

			// Format the property ID for the request.
			$formatted_parent = 'properties/' . $property_id;

			// Get all the streams saved in the database.
			$ga4_streams = (array) get_option( 'analytify-ga4-streams' );

			// Check if there are any streams for the current property.
			$streams = $ga4_streams[ $property_id ] ?? array();

			// If streams exist for this property, return them.
			if ( !empty( $streams ) ) {
				return $streams;
			}

			// Connect to the Google Analytics Admin API.
			$admin_client = $this->connect_admin_api();

			// Call the API and save the streams.
			try {
				$response = $admin_client->listDataStreams( $formatted_parent );

				// Array to store the streams.
				$all_streams = array();

				foreach ( $response as $element ) {
					$serialize  = $element->serializeToJsonString();
					// Deserialize the response to a stdClass object.
					$stream_obj = json_decode( $serialize );

					// We only need web streams.
					if ( $stream_obj->type === 'WEB_DATA_STREAM' ) {
						// Store the current stream data.
						$stream_data = array(
								'full_name'      => $stream_obj->name,
								'property_id'    => $property_id,
								'stream_name'    => $stream_obj->displayName,
								'measurement_id' => $stream_obj->webStreamData->measurementId,
								'url'            => $stream_obj->webStreamData->defaultUri,
						);
						// Add the current stream to the array of all streams.
						$all_streams[ $stream_obj->webStreamData->measurementId ] = $stream_data;
					}
				}

				// Save the streams to the database.
				$streams[ $property_id ] = $all_streams;
				update_option( 'analytify-ga4-streams', $streams );

				return $all_streams;

			} catch ( \Throwable $th ) {
				// Log the error message.
				$logger = analytify_get_logger();
				$logger->warning( $th->getMessage(), array( 'source' => 'analytify_fetch_ga_streams' ) );
				return null;
			}
		}

		/**
		 * Lookup for a single "GA4" MeasurementProtocolSecret.
		 *
		 * @param string $formattedName The name of the measurement protocol secret to lookup.
		 */
		public function get_mp_secret( $formattedName )
		{
			if( empty( $formattedName ) ) {
				return;
			}
			// Create a client.
			$admin_client = $this->connect_admin_api();
			// set the value initially to null.
			$mp_secret_value = null;
			/// Call the API and handle any network failures.
			try {
				$response = $admin_client->listMeasurementProtocolSecrets( $formattedName );
		        // loop over the response and save the first found secret value.
				foreach ($response as $element) {
					$serialized_element = $element->serializeToJsonString();
					$mp_secret_obj      = json_decode( $serialized_element );
					$mp_secret_value    = $mp_secret_obj->secretValue;
					break;
				}
			} catch ( \Throwable $th ) {
				// Log the error message.
				$logger = analytify_get_logger();
				$logger->warning( $th->getMessage(), array( 'source' => 'analytify_fetch_mp_secret' ) );
				return false;
			}
			return $mp_secret_value;
		}

		/**
		 * Create mp secret for given propert
		 * Checks if mp secret exists otherwise
		 * create newone if analytify stream exists.
		 * 
		 * @param string $property_id
		 * 
		 * @since 5.0.0
		 */
		public function create_mp_secret( $property_id, $stream_full_name, $display_name ) {
			$analytify_all_streams = (array)get_option( 'analytify-ga4-streams' );
			$analytify_ga4_stream  = isset( $analytify_all_streams[$property_id][$display_name] ) ? $analytify_all_streams[$property_id][$display_name] : "";

			if ( isset( $analytify_ga4_stream['analytify_mp_secret'] ) && $analytify_ga4_stream['analytify_mp_secret'] ) {
				return $analytify_ga4_stream['analytify_mp_secret'];
			} elseif ( empty( $analytify_ga4_stream['full_name'] ) ) {
				return;
			}

			$analyticsAdminServiceClient = $this->connect_admin_api();
			if ( ! isset( $analytify_ga4_stream['mp_user_acknowledgement'] ) || true != $analytify_ga4_stream['mp_user_acknowledgement'] ) {
				try {
					$formattedProperty = $analyticsAdminServiceClient->propertyName($property_id);
					$acknowledgement   = 'I acknowledge that I have the necessary privacy disclosures and rights from my end users for the collection and processing of their data, including the association of such data with the visitation information Google Analytics collects from my site and/or app property.';
					$response = $analyticsAdminServiceClient->acknowledgeUserDataCollection($formattedProperty, $acknowledgement);
					if ($response) {
						$analytify_ga4_stream['mp_user_acknowledgement']    = true;
						$analytify_all_streams[$property_id][$display_name] = $analytify_ga4_stream;
						update_option( 'analytify-ga4-streams' , $analytify_all_streams );
						WPANALYTIFY_Utils::remove_ga4_exception( 'mp_secret_exception' );
					}
				} catch (\Throwable $th) {
					$response = $th->getMessage();
					$response = json_decode($response);
					WPANALYTIFY_Utils::add_ga4_exception( 'mp_secret_exception', $response->reason, $response->message );
					return;
				}
			}
			
			try {
				$formattedParent           = $stream_full_name;
				$measurementProtocolSecret = new Google\Analytics\Admin\V1alpha\MeasurementProtocolSecret( ['display_name' => 'analytify_mp_secret' ] );
				$response                  = $analyticsAdminServiceClient->createMeasurementProtocolSecret( $formattedParent, $measurementProtocolSecret );
				if( $response ) {
					$secret_value                                               = $response->getSecretValue();
					$analytify_ga4_stream['analytify_mp_secret']                = $secret_value;
					$analytify_all_streams[$property_id][$display_name]         = $analytify_ga4_stream;
					update_option( 'analytify-ga4-streams' , $analytify_all_streams );
					WPANALYTIFY_Utils::remove_ga4_exception( 'mp_secret_exception' );
					return $secret_value;
				}
			} catch ( \Throwable $th ) {
				$response = $th->getMessage();
				$response = json_decode($response);
				WPANALYTIFY_Utils::add_ga4_exception( 'mp_secret_exception', $response->message, $response->message );
				$logger = analytify_get_logger();
				$logger->warning( $response->message, array( 'source' => 'analytify_create_mp_secret_error' ) );
			} finally {
     		    $analyticsAdminServiceClient->close();
     		}
		}

		/**
		 * Fetch properties form Google Analytics.
		 * Google\Analytics\Admin\V1alpha\Account
		 * 
		 * @return array
		 */
		public function get_ga_properties() {

			$admin_client = $this->connect_admin_api();
			$accounts = array();
			try{
				if ( $this->get_ga4_exception() ) {
					WPANALYTIFY_Utils::handle_exceptions( $this->get_ga4_exception() );
				}
				if ( get_option( 'pa_google_token' ) != '' ) {
					$accounts = $admin_client->listAccounts();
				} else {
					echo '<br /><div class="notice notice-warning"><p>' . esc_html__( 'Notice: You must authenticate to access your web profiles.', 'wp-analytify' ) . '</p></div>';
				}
			} catch (Exception $e) {
				$error_message = $e->getMessage();
				$logger = analytify_get_logger();
				$logger->warning( $error_message, array( 'source' => 'analytify_get_ga_properties_errors' ) );
				return array();
			}
			$ga_properties = array();

			foreach ( $accounts as $account ) {
				$formatted_account_name = 'parent:' . $account->getName();
				$properties = $admin_client->listProperties( $formatted_account_name );
				$property_data = array();

				foreach ( $properties as $property )  {
					// Extract property id since there is no direct method to get it (API is in alpha).
					$id = explode( '/', $property->getName() );
					$id = isset( $id[1] ) ? $id[1] : $property->getName();

					$property_data[] = array(
						'id' => $id,
						'name' => $property->getName(),
						'display_name' => $property->getDisplayName(),
					);
				}

				if ( $property_data ) {
					$ga_properties[$account->getDisplayName()] = $property_data;
				}
			}

			// If no error then delete the exception.
            WPANALYTIFY_Utils::remove_ga4_exception('fetch_ga4_profiles_exception');


			return $ga_properties;
		}
		
		/**
		 * Fetch reports from Google Analytics Data API.
		 * @param string $name 'test-report-name' Its the key used to store reports in transient as cache.
		 * @param array $metrics {
		 *     'screenPageViews',
		 *	   'userEngagementDuration',
		 *	   'bounceRate',
		 * }
		 * @param array $date_range {
		 *     'start' => '30daysAgo', Format should be either YYYY-MM-DD, yesterday, today, or NdaysAgo where N is a positive integer
		 *     'end'   => 'yesterday', 
		 * }
		 * @param array $dimensions {
		 *     'pageTitle',
		 *     'pagePath'
		 * }
		 * @param array $order_by {
		 *     'type' => 'metric', Should be either 'metric' or 'dimension'.
		 *     'name' => 'screenPageViews', Name of the metric or dimension.
		 * }
		 * @param array $filters {
		 *     {
		 *          'type' => 'dimension', Should be either 'metric' or 'dimension'.
		 *          'name' => 'sourcePlatform', Name of the metric or dimension.
		 *          'match_type' => 5, (EXACT = 1; BEGINS_WITH = 2; ENDS_WITH = 3; CONTAINS = 4; FULL_REGEXP = 5; PARTIAL_REGEXP = 6;)
		 *          'value' => 'Linux', Value depending on match type.
		 *          'not_expression' => true, If a not expression i.e !=
		 *     },
		 *     {
		 *         ...
		 *     }
		 *     ...
		 * }
		 * @param integer array $limit Positive integer to limit report rows.
		 * 
		 * @return array {
		 * 	   'headers' => {
		 *         ...
		 * 	   },
		 * 	   'rows' => {
		 *         ...
		 * 	   }
		 * }
		 */
		public function get_reports( $name, $metrics, $date_range, $dimensions = array(), $order_by = array(), $filters = array(), $limit = 0, $cached = true ) {
			$property_id   = WPANALYTIFY_Utils::get_reporting_property();
			
			// Don't use cache if custom API keys are in use. 
			if ( $this->settings->get_option( 'user_advanced_keys', 'wp-analytify-advanced' ) === 'on' ) {
				$cached = false;
			}

			// To override the caching.
			$cached = apply_filters( 'analytify_set_caching_to', $cached );

			if ( $cached ) {
				$cache_key = 'analytify_transient_' . md5( $name . $property_id . $date_range['start'] . $date_range['end'] );
				$report_cache = get_transient( $cache_key );

				if ( $report_cache ) {
					return $report_cache;
				}
			}

			$reports = array();

			// Default response array.
			$default_response = array(
				'headers'      => array(),
				'rows'         => array(),
				'error'        => array(),
				'aggregations' => array(),
			);

			try {
				$data_client = $this->connect_data_api();

				// Main request body for the report.
				$request_body = array(
					'property'   => 'properties/' . $property_id,
					'dateRanges' => array(
						new Google\Analytics\Data\V1beta\DateRange(
							array(
							'start_date' => isset( $date_range['start'] ) ? $date_range['start'] : 'today',
							'end_date'   => isset( $date_range['end'] ) ? $date_range['end'] : 'today',
							)
						),
					),
					'metricAggregations' => array( 1 ) // TOTAL = 1; COUNT = 4; MINIMUM = 5; MAXIMUM = 6;
				);

				// Set metrics.
				if ( $metrics ) {
					$send_metrics = array();

					foreach ( $metrics as $value ) {
						$send_metrics[] = new Google\Analytics\Data\V1beta\Metric( array( 'name' => $value ) );
					}

					$request_body['metrics'] = $send_metrics;
				}

				// Add dimensions.
				if ( $dimensions ) {
					$send_dimensions = array();

					foreach ( $dimensions as $value ) {
						$send_dimensions[] = new Google\Analytics\Data\V1beta\Dimension( array( 'name' => $value ) );
					}
	
					$request_body['dimensions'] = $send_dimensions;
				}

				// Order report by metric or dimension.
				if ( $order_by ) {
					$order_by_request = array();
					$is_desc = ( empty( $order_by['order'] ) || 'desc' !== $order_by['order'] ) ? false : true;

					if ( 'metric' === $order_by['type'] ) {
						$order_by_request = array(
							'metric' => new Google\Analytics\Data\V1beta\OrderBy\MetricOrderBy(
								array(
									'metric_name' => $order_by['name']
								)
							),
							'desc' => $is_desc,
						);
					} else if ( 'dimension' === $order_by['type'] ) {
						$order_by_request = array(
							'dimension' => new Google\Analytics\Data\V1beta\OrderBy\DimensionOrderBy(
								array(
									'dimension_name' => $order_by['name']
								)
							),
							'desc' => $is_desc,
						);
					}

					$request_body['orderBys'] = [new Google\Analytics\Data\V1beta\OrderBy( $order_by_request )];
				}

				// Filters for the report.
				if ( $filters ) {

					foreach ( $filters['filters'] as $filter_data ) {
						if ( 'dimension' === $filter_data['type'] ) {
							if ( isset( $filter_data['not_expression'] ) && $filter_data['not_expression'] ) {
								$dimension_filters[] =  new Google\Analytics\Data\V1beta\FilterExpression(
								array(
									'not_expression' => new Google\Analytics\Data\V1beta\FilterExpression(
										array(
											'filter' =>
												new \Google\Analytics\Data\V1beta\Filter (
													array(
														'field_name'    => $filter_data['name'],
														'string_filter' => new \Google\Analytics\Data\V1beta\Filter\StringFilter(
															array(
																'match_type'     => $filter_data['match_type'],
																'value'          => $filter_data['value'],
																'case_sensitive' => true
															)
														)
													)
												)
											)
										)
									)
								);
							} else {
								$dimension_filters[] = new Google\Analytics\Data\V1beta\FilterExpression(
									array(
										'filter' => new \Google\Analytics\Data\V1beta\Filter (
											array(
												'field_name'    => $filter_data['name'],
												'string_filter' => new \Google\Analytics\Data\V1beta\Filter\StringFilter(
													array(
														'match_type'     => $filter_data['match_type'],
														'value'          => $filter_data['value'],
														'case_sensitive' => true
													)
												)
											)
										)
									)
								);
							}
						} else if ( 'metric' === $filter_data['type'] ) {
							// TODO: Add metric filter.
						}
					}

					if ( $dimension_filters ) {
						$group_type = ( isset( $filters['logic'] ) && 'OR' === $filters['logic'] ) ? 'or_group' : 'and_group';
						$dimension_filter_construct = new Google\Analytics\Data\V1beta\FilterExpression(
							array(
								$group_type =>
								new \Google\Analytics\Data\V1beta\FilterExpressionList(
									array( 'expressions' => $dimension_filters )
								)
							)
						);

						$request_body['dimensionFilter'] = $dimension_filter_construct;
					}
				}

				// Set limit.
				if ( 0 < $limit ) {
					$request_body['limit'] = $limit;
				}

				// Send reports request.
				$reports = $data_client->runReport( $request_body );
			} catch ( \Throwable $th ) {
				if ( is_callable( $th, 'getStatus' ) && is_callable( $th, 'getBasicMessage' ) ) {
					$default_response['error'] = array(
						'status'  => $th->getStatus(),
						'message' => $th->getBasicMessage(),
					);
					
				} else if ( method_exists( $th, 'getMessage' ) ) {					
					$default_response['error'] = array(
						'status'  => 'Token Expired',
						'message' => $th->getMessage(),
						// 'basicmessage' => $th->getBasicMessage(),
					);
				}

				return $default_response;
			}

			if ( ! is_object( $reports ) ) {
				$default_response['error'] = array(
					'status'  => 'API Request Error',
					'message' => 'Invalid response from API, proper object not found.',
				);

				return $default_response;
			}

			if ( 0 === $reports->getRowCount() ) {
				return $default_response;
			}

			$formatted_reports = $this->format_ga_reports( $reports );

			if ( empty( $formatted_reports ) ) {
				return $default_response;
			}

			if ( $cached ) {
				set_transient( $cache_key, $formatted_reports, $this->get_cache_time() );
			}

			return $formatted_reports;
		}

		/**
		 * Fetch real time reports from Google Analytics Data API.
		 * @param string $name 'test-report-name' Its the key used to store reports in transient as cache.
		 * @param array $metrics {
		 *     'screenPageViews',
		 *	   'userEngagementDuration',
		 *	   'bounceRate',
		 * }
		 * @param array $dimensions {
		 *     'pageTitle',
		 *     'pagePath'
		 * }
		 * 
		 * @return array {
		 * 	   'headers' => {
		 *         ...
		 * 	   },
		 * 	   'rows' => {
		 *         ...
		 * 	   }
		 * }
		 */
		public function get_real_time_reports( $metrics, $dimensions = array() ) {

			$property_id = WPANALYTIFY_Utils::get_reporting_property();
			$reports = array();

			// Default response array.
			$default_response = array(
				'headers'      => array(),
				'rows'         => array(),
				'error'        => array(),
				'aggregations' => array(),
			);

			try {
				$data_client = $this->connect_data_api();

				// Main request body for the report.
				$request_body = array(
					'property' => 'properties/' . $property_id,
				);

				// Set metrics.
				if ( $metrics ) {
					$send_metrics = array();

					foreach ( $metrics as $value ) {
						$send_metrics[] = new Google\Analytics\Data\V1beta\Metric( array( 'name' => $value ) );
					}

					$request_body['metrics'] = $send_metrics;
				}
	
				// Add dimensions.
				if ( $dimensions ) {
					$send_dimensions = array();

					foreach ( $dimensions as $value ) {
						$send_dimensions[] = new Google\Analytics\Data\V1beta\Dimension( array( 'name' => $value ) );
					}
	
					$request_body['dimensions'] = $send_dimensions;
				}

				// Send reports request.
				$reports = $data_client->runRealtimeReport( $request_body );
			} catch ( \Throwable $th ) {
				$default_response['error'] = array(
					'status'  => '',
					'message' => '',
				);

				return $default_response;
			}

			if ( ! is_object( $reports ) ) {
				if ( is_callable( $th, 'getStatus' ) && is_callable( $th, 'getBasicMessage' ) ) {
					$default_response['error'] = array(
						'status'  => $th->getStatus(),
						'message' => $th->getBasicMessage(),
					);
					
				} else if ( method_exists( $th, 'getMessage' ) ) {					
					$default_response['error'] = array(
						'status'  => 'Token Expired',
						'message' => $th->getMessage(),
					);	
				}
				return $default_response;
			}

			if ( 0 === $reports->getRowCount() ) {
				return $default_response;
			}

			$formatted_reports = $this->format_ga_reports( $reports );

			if ( empty( $formatted_reports ) ) {
				return $default_response;
			}

			return $formatted_reports;
		}

		/**
		 * List all dimensions present in current selected GA property.
		 *
		 * @return array
		 */
		public function list_dimensions() {

			$property_id = WPANALYTIFY_Utils::get_reporting_property();
			$dimensions = array();

			try {
				$admin_client = $this->connect_admin_api();
				$dimensions_paged_response = $admin_client->ListCustomDimensions( 'properties/' . $property_id );

				foreach ( $dimensions_paged_response->iteratePages() as $page ) {
					foreach ( $page as $element ) {
						$dimensions[] = $element->getParameterName();
					}
				}

			} catch ( \Throwable $th ) {
				return $dimensions;
			}

			return $dimensions;
		}

		/**
		 * List all custom dimensions that needs to be created in selected GA property.
		 *
		 * @return array ()
		 */
		public function list_dimensions_needs_creation() {

			$current_property_dimensions = $this->list_dimensions();
			$required_dimensions         = WPANALYTIFY_Utils::required_dimensions();

			if ( ! empty( $current_property_dimensions ) ) {
				foreach ( $required_dimensions as $key => &$dimension ) {
					if ( in_array( $dimension['parameter_name'], $current_property_dimensions, true ) ) {
						unset( $required_dimensions[ $key ] );
					}
				}
				return $required_dimensions;
			}

			return $required_dimensions;
		}

		/**
		 * Create custom dimensions with Admin API.
		 *
		 * @param string  $parameter_name Max length of 24 characters.
		 * @param string  $display_name Max length of 82 characters.
		 * @param integer $scope 0 = Undefined scope, 1 = Event, 2 = User.
		 * @param string  $description Max length of 150 characters.
		 * @param integer $property_id Reporting property ID to associate dimension, default is current reporting property.
		 * 
		 * @return array
		 */
		public function create_dimension( $parameter_name, $display_name, $scope, $description = '', $property_id = '' ) {

			$property_id  = ! empty( $property_id ) ? $property_id : WPANALYTIFY_Utils::get_reporting_property();
			
			if( empty( $property_id ) ) {
				return;
			}
			$admin_client = $this->connect_admin_api();

			$return_response = array(
				'response' => 'created',
			);

			try {
				$formatted_property_name = $admin_client->propertyName( $property_id );
				$custom_dimension        = new Google\Analytics\Admin\V1alpha\CustomDimension(
					array(
						'parameter_name' => $parameter_name,
						'display_name'   => $display_name,
						'scope'          => $scope,
						'description'    => ! empty( $description ) ? $description : 'Analytify custom dimension.',
					)
				);

				try { // Try to create new dimension.
					$response = $admin_client->createCustomDimension( $formatted_property_name, $custom_dimension );
					if( $response ) {
						WPANALYTIFY_Utils::remove_ga4_exception( 'create_dimensions_exception' );
					}
				} catch ( \Throwable $th ) {
					$logger = analytify_get_logger();
					$logger->warning( $th->getMessage(), array( 'source' => 'analytify_create_dimension_errors' ) );
					$return_response = array(
						'response' => 'failed',
						'message'  => $th->getMessage(),
					);
				}
			} catch( \Throwable $th ) {
				
				$logger = analytify_get_logger();
				$logger->warning( $th->getMessage(), array( 'source' => 'analytify_create_dimension_errors' ) );
			} finally {
				$admin_client->close();
			}

			return $return_response;
		}

		/**
		 * Format reports data fetched from Google Analytics Data API.
		 *
		 * For references check folder for class definitions: lib\Google\vendor\google\analytics-data\src\V1beta
		 *
		 * @param $reports
		 * @return array
		 */
		public function format_ga_reports( $reports ) {

			$metric_header_data = array();
			$dimension_header_data = array();
			$aggregations = array();

			$data_rows = $reports->getRows();

			// Get metric headers.
			foreach ( $reports->getMetricHeaders() as $metric_header ) {
				$metric_header_data[] = $metric_header->getName();
			}
			// Get dimension headers.
			foreach ( $reports->getDimensionHeaders() as $dimension_header ) {
				$dimension_header_data[] = $dimension_header->getName();
			}

			$headers = array_merge( $metric_header_data, $dimension_header_data );

			// Bind metrics and dimensions to rows.
			foreach ( $data_rows as $row ) {
				$metric_data = array();
				$dimension_data = array();

				$index_metric = 0;
				$index_dimension = 0;

				foreach ( $row->getMetricValues() as $value ) {
					$metric_data[$metric_header_data[$index_metric]] = $value->getValue();
					$index_metric++;
				}

				foreach ( $row->getDimensionValues() as $value ) {
					$dimension_data[$dimension_header_data[$index_dimension]] = $value->getValue();
					$index_dimension++;
				}

				$rows[] = array_merge( $metric_data, $dimension_data );
			}

			// Get metric aggregations.
			foreach ( $reports->getTotals() as $total ) {
				$index_metric = 0;

				foreach ( $total->getMetricValues() as $value ) {
					$aggregations[$metric_header_data[$index_metric]] = $value->getValue();
					$index_metric++;
				}
			}

			$formatted_data = array(
				'headers'      => $headers,
				'rows'         => $rows,
				'aggregations' => $aggregations
			);

			return $formatted_data;
		}	

		/**
		 * Query the search console api and return the response.
		 * Since SC can have two types of domain properties.
		 * We will first go with the sc-domain prefix with property
		 * if it fails we will use the second domain type using 'https://'
		 * 
		 * @param $dates array
		 * @param $limit limit
		 * 
		 * @since 5.0.0
		 */
		public function get_search_console_stats( $transient_name, $dates = [], $limit = 10 ) {
			$response = array(
				'error' => array(),
			);
			$search_console       = new Google\Service\SearchConsole($this->client);
			$tracking_stream_info = get_option('analytify_tracking_property_info');

			$stream_url           = ! empty( $tracking_stream_info['url'] ) ? $tracking_stream_info['url'] : null;

			if ( empty( $stream_url ) ) {
				$response['error'] = array(
					'status'  => 'No Stats Available',
					'message' => __( "No URL found for the selected stream", 'wp-analytify' ),
				);
			}

			$http_stream_url      = $stream_url;

			// Prepare the url for search console domain property type.
			$domain_stream_url_filtered    = preg_replace("(^(https?:\/\/([wW]{3}\.)?)?)", "", $stream_url );
			$domain_stream_url             = "sc-domain:$domain_stream_url_filtered";
			
			// In the first trun it will request the api using sc-domain type.
			try {
				$request = new Google\Service\SearchConsole\SearchAnalyticsQueryRequest();
				$request->setStartDate( isset($dates['start']) ? $dates['start'] : 'yesterday' );
				$request->setEndDate( isset($dates['end']) ? $dates['end'] : 'today' );
				$request->setDimensions(['QUERY']);
				$request->setRowLimit($limit);
				
				$response['response'] = $search_console->searchanalytics->query($domain_stream_url, $request);
			} catch(\Throwable $th) {				
				
				try {
					$request = new Google\Service\SearchConsole\SearchAnalyticsQueryRequest();
					$request->setStartDate(isset($dates['start']) ? $dates['start'] : 'yesterday');
					$request->setEndDate(isset($dates['end']) ? $dates['end'] : 'today');
					$request->setDimensions(['QUERY']);
					$request->setRowLimit($limit);
					$response['response'] = $search_console->searchanalytics->query($http_stream_url, $request);
					unset($response['error']);
				} catch(\Throwable $th) {
					$logger = analytify_get_logger();
					$logger->warning( $th->getMessage(), array( 'source' => 'analytify_fetch_search_console_stats' ) );
					$response['error'] = [
						'status'  => "No Stats Available for $domain_stream_url_filtered",
						'message' => __( "Analytify gets GA4 Keyword stats from Search Console. Make sure you've verified and have owner access to your site in Search Console.", 'wp-analytify' ),
					];
				}
			}
			
			return $response;
		}

		/**
		 * This function grabs the data from Google Analytics for individual posts/pages.
		 *
		 * @param string $metrics
		 * @param string $start_date
		 * @param string $end_date
		 * @param boolean $dimensions
		 * @param boolean $sort
		 * @param boolean $filter
		 * @param boolean $limit
		 * @param string $name
		 * @return void
		 */
		public function pa_get_analytics( $metrics, $start_date, $end_date, $dimensions = false, $sort = false, $filter = false, $limit = false, $name = ''  ) {

			if ( $this->is_reporting_in_ga4 ) {
				return;
			}

			try {
				$this->service = new Analytify_Google_Service_Analytics( $this->client );
				$params        = array();

				if ( $dimensions ) {
					$params['dimensions'] = $dimensions;
				}

				if ( $sort ) {
					$params['sort'] = $sort;
				}

				if ( $filter ) {
					$params['filters'] = $filter;
				}

				if ( $limit ) {
					$params['max-results'] = $limit;
				}

				$profile_id = $this->settings->get_option( 'profile_for_posts', 'wp-analytify-profile' );

				if ( ! $profile_id ) {
					return false;
				}

				$transient_key = 'analytify_transient_';
				$cache_result  = get_transient( $transient_key . md5( $name . $profile_id . $start_date . $end_date . $filter ) );

				// TODO: remove this hard coded setting

				$is_custom_api = $this->settings->get_option( 'user_advanced_keys', 'wp-analytify-advanced' );
				// $is_custom_api = 'on';

				if ( 'on' !== $is_custom_api ) {
					// If exception, return if the cache result else return the error.
					if ( $exception = get_transient( 'analytify_quota_exception' ) ) {
						return $this->tackle_exception( $exception, $cache_result );
					}
				}

				// If custom keys set. Fetch fresh result always.
				if ( 'on' === $is_custom_api || $cache_result === false ) {
					$result = $this->service->data_ga->get( 'ga:' . $profile_id, $start_date, $end_date, $metrics, $params );
					set_transient( $transient_key . md5( $name . $profile_id . $start_date . $end_date . $filter ) , $result, $this->get_cache_time() );
					return $result;

				} else {
					return $cache_result;
				}
			} catch ( Analytify_Google_Service_Exception $e ) {
				// Show error message only for logged in users.
				if ( current_user_can( 'manage_options' ) ) {
					echo "<div class='wp_analytify_error_msg'>";
					echo sprintf( esc_html__( '%1$s Oops, Something went wrong. %2$s %5$s %2$s %3$s Don\'t worry, This error message is only visible to Administrators. %4$s %2$s', 'wp-analytify' ), '<br /><br />', '<br />', '<i>', '</i>', esc_html( $e->getMessage() ) );
					echo "</div>";
				}
			} catch ( Analytify_Google_Auth_Exception $e ) {
				// Show error message only for logged in users.
				if ( current_user_can( 'manage_options' ) ) {
					echo "<div class='wp_analytify_error_msg'>";
					echo sprintf( esc_html__( '%1$s Oops, Try to %3$s Reset %4$s Authentication. %2$s %7$s %2$s %5$s Don\'t worry, This error message is only visible to Administrators. %6$s %2$s', 'wp-analytify' ), '<br /><br />', '<br />', '<a href=' . esc_url( admin_url( 'admin.php?page=analytify-settings&tab=authentication' ) ) . ' title="Reset">', '</a>', '<i>', '</i>', esc_textarea( $e->getMessage() ) );
					echo "</div>";
				}
			} catch ( Analytify_Google_IO_Exception $e ) {
				// Show error message only for logged in users.
				if ( current_user_can( 'manage_options' ) ) {
					echo "<div class='wp_analytify_error_msg'>";
					echo sprintf( esc_html__( '%1$s Oops! %2$s %5$s %2$s %3$s Don\'t worry, This error message is only visible to Administrators. %4$s %2$s', 'wp-analytify' ), '<br /><br />', '<br />', '<i>', '</i>', esc_html( $e->getMessage() ) );
					echo "</div>";
				}
			}
		}

		/**
		 * This function grabs the data from Google Analytics for dashboard.
		 *
		 * @param string $metrics
		 * @param string $start_date
		 * @param string $end_date
		 * @param boolean $dimensions
		 * @param boolean $sort
		 * @param boolean $filter
		 * @param boolean $limit
		 * @param string $name
		 * 
		 * @return void
		 */
		public function pa_get_analytics_dashboard( $metrics, $start_date, $end_date, $dimensions = false, $sort = false, $filter = false, $limit = false, $name = '' ) {

			if ( $this->is_reporting_in_ga4 ) {
				return null;
			}

			try {
				$params = array();

				if ( $dimensions ) {
					$params['dimensions'] = $dimensions;
				}
				if ( $sort ) {
					$params['sort'] = $sort;
				}
				if ( $filter ) {
					$params['filters'] = $filter;
				}
				if ( $limit ) {
					$params['max-results'] = $limit;
				}

				$profile_id = $this->settings->get_option( 'profile_for_dashboard', 'wp-analytify-profile' );

				if ( ! $profile_id ) {
					return false;
				}

				$transient_key = 'analytify_transient_';

				$is_custom_api = $this->settings->get_option( 'user_advanced_keys', 'wp-analytify-advanced' );
				$cache_result = get_transient( $transient_key . md5( $name . $profile_id . $start_date . $end_date . $filter ) );

				// if ( 'on' !== $is_custom_api ) {
				// 	// If exception, return if the cache result else return the error.
				// 	if ( $exception = get_transient( 'analytify_quota_exception' ) ) {
				// 		return $this->tackle_exception( $exception, $cache_result );
				// 	}
				// }

				// If custom keys set. Fetch fresh result always.
				if ( 'on' === $is_custom_api || $cache_result === false ) {
					$result = $this->service->data_ga->get( 'ga:' . $profile_id, $start_date, $end_date, $metrics, $params );
					set_transient( $transient_key . md5( $name . $profile_id . $start_date . $end_date . $filter ) , $result, $this->get_cache_time() );
					return $result;

				} else {
					return $cache_result;
				}
			} catch ( Analytify_Google_Service_Exception $e ) {
				$logger = analytify_get_logger();
				$logger->warning( $e->getMessage(), array( 'source' => 'analytify_fetch_data' ) );

				set_transient( 'analytify_quota_exception', $e->getMessage(), HOUR_IN_SECONDS );

				// Show error message only for logged in users.
				if ( current_user_can( 'manage_options' ) ) {
					$error_code = $e->getErrors();
					if ( $error_code[0]['reason'] == 'userRateLimitExceeded' ) {
					echo $this->show_error_box( 'API error: User Rate Limit Exceeded <a href="https://analytify.io/user-rate-limit-exceeded-guide" target="_blank" class="error_help">help?</a>' );
					} elseif( $error_code[0]['reason'] == 'dailyLimitExceeded' ) {
						echo $this->show_error_box( 'API error: Daily Limit Exceeded <a href="https://analytify.io/daily-limit-exceeded" target="_blank" class="error_help">help?</a>' );
					} else{
					echo $this->show_error_box( $e->getMessage() );
					}
				}
			} catch ( Analytify_Google_Auth_Exception $e ) {
				$logger = analytify_get_logger();
				$logger->warning( $e->getMessage(), array( 'source' => 'analytify_fetch_data' ) );

				// Show error message only for logged in users.
				if ( current_user_can( 'manage_options' ) ) {

					echo sprintf( esc_html__( '%1$s Oops, Try to %3$s Reset %4$s Authentication. %2$s %7$s %2$s %5$s Don\'t worry, This error message is only visible to Administrators. %6$s %2$s', 'wp-analytify' ), '<br /><br />', '<br />', '<a href=' . esc_url( admin_url( 'admin.php?page=analytify-settings&tab=authentication' ) ) . ' title="Reset">', '</a>', '<i>', '</i>', esc_html( $e->getMessage() ) );
				}
			} catch ( Analytify_Google_IO_Exception $e ) {
				$logger = analytify_get_logger();
				$logger->warning( $e->getMessage(), array( 'source' => 'analytify_fetch_data' ) );

				// Show error message only for logged in users.
				if ( current_user_can( 'manage_options' ) ) {

					echo sprintf( esc_html__( '%1$s Oops! %2$s %5$s %2$s %3$s Don\'t worry, This error message is only visible to Administrators. %4$s %2$s', 'wp-analytify' ), '<br /><br />', '<br />', '<i>', '</i>', esc_html( $e->getMessage() ) );
				}
			}
		}

		/**
		 * This function grabs the data from Google Analytics For dashboard.
		 *
		 * @param string $profile    Google Analytic Profile Id.
		 * @param string $metrics    Metrics.
		 * @param string $start_date Start date of stats.
		 * @param string $end_date   End date of stats.
		 * @param string $dimensions Dimensions.
		 * @param string $sort       Sort.
		 * @param string $filter     Filter.
		 * @param string $limit      How many stats to show.
		 * 
		 * @return array Return array of stats
		 */
		public function analytify_get_analytics( $profile, $metrics, $start_date, $end_date, $dimensions = false, $sort = false, $filter = false, $limit = false ) {

			if ( $this->is_reporting_in_ga4 ) {
				return null;
			}
			try {
				$this->service = new Analytify_Google_Service_Analytics( $this->client );
				$params = array();

				if ( $dimensions ) {
					$params['dimensions'] = $dimensions;
				}
				if ( $sort ) {
					$params['sort'] = $sort;
				}
				if ( $filter ) {
					$params['filters'] = $filter;
				}
				if ( $limit ) {
					$params['max-results'] = $limit;
				}

				if ( 'single' == $profile ) {
					$profile_id = $this->settings->get_option( 'profile_for_posts', 'wp-analytify-profile' );
				} else {
					$profile_id = $this->settings->get_option( 'profile_for_dashboard', 'wp-analytify-profile' );
				}

				if ( ! $profile_id ) {
					return false;
				}

				return $this->service->data_ga->get( 'ga:' . $profile_id, $start_date, $end_date, $metrics, $params );
			} catch ( Analytify_Google_Service_Exception $e ) {
				// Show error message only for logged in users.
				// Show error message only for logged in users.
				if ( current_user_can( 'manage_options' ) ) {
					echo sprintf( esc_html__( '%1$s Oops, Something went wrong. %2$s %5$s %2$s %3$s Don\'t worry, This error message is only visible to Administrators. %4$s %2$s', 'wp-analytify' ), '<br /><br />', '<br />', '<i>', '</i>', esc_textarea( $e->getMessage() ) );
				}
			} catch ( Analytify_Google_Auth_Exception $e ) {
				// Show error message only for logged in users.
				if ( current_user_can( 'manage_options' ) ) {
					echo sprintf( esc_html__( '%1$s Oops, Try to %3$s Reset %4$s Authentication. %2$s %7$s %2$s %5$s Don\'t worry, This error message is only visible to Administrators. %6$s %2$s', 'wp-analytify' ), '<br /><br />', '<br />', '<a href=' . esc_url( admin_url( 'admin.php?page=analytify-settings&tab=authentication' ) ) . ' title="Reset">', '</a>', '<i>', '</i>', esc_textarea( $e->getMessage() ) );
				}
			} catch ( Analytify_Google_IO_Exception $e ) {
				// Show error message only for logged in users.
				if ( current_user_can( 'manage_options' ) ) {
					echo sprintf( esc_html__( '%1$s Oops! %2$s %5$s %2$s %3$s Don\'t worry, This error message is only visible to Administrators. %4$s %2$s', 'wp-analytify' ), '<br /><br />', '<br />', '<i>', '</i>', esc_html( $e->getMessage() ) );
				}
			}
		}

		/**
		 * Echo value to be returned in ajax response.
		 *
		 * @param boolean $return
		 * 
		 * @return void
		 */
		public function end_ajax( $return = false ) {

			$return = apply_filters( 'wpanalytify_before_response', $return );
			
			echo ( false === $return ) ? '' : $return;
			exit;
		}

		/**
		 * Check ajax referer facade.
		 *
		 * @param string $action
		 * 
		 * @return void
		 */
		public function check_ajax_referer( $action ) {

			$result = check_ajax_referer( $action, 'nonce', false );

			if ( false === $result ) {
				$return = array( 'wpanalytify_error' => 1, 'body' => sprintf( __( 'Invalid nonce for: %s', 'wp-analytify' ), $action ) );
				$this->end_ajax( json_encode( $return ) );
			}

			$cap = ( is_multisite() ) ? 'manage_network_options' : 'export';
			$cap = apply_filters( 'wpanalytify_ajax_cap', $cap );

			if ( ! current_user_can( $cap ) ) {
				$return = array( 'wpanalytify_error' => 1, 'body' => sprintf( __( 'Access denied for: %s', 'wp-analytify' ), $action ) );
				$this->end_ajax( json_encode( $return ) );
			}
		}

		/**
		* Returns the function name that called the function using this function.
		*
		* @return string
		*/
		public function get_caller_function() {
			list( , , $caller ) = debug_backtrace( false );

			if ( ! empty( $caller['function'] ) ) {
				$caller = $caller['function'];
			} else {
				$caller = '';
			}

			return $caller;
		}

		/**
		 * Set $this->state_data from $_POST, potentially un-slashed and sanitized.
		 *
		 * @param array  $key_rules An optional associative array of expected keys and their sanitization rule(s).
		 * @param string $context   The method that is specifying the sanitization rules. Defaults to calling method.
		 *
		 * @since 2.0
		 * @return array
		 */
		public function set_post_data( $key_rules = array(), $context = '' ) {

			if ( defined( 'DOING_WPANALYTIFY_TESTS' ) ) {
				$this->state_data = $_POST;
			} elseif ( is_null( $this->state_data ) ) {
				$this->state_data = WPANALYTIFY_Utils::safe_wp_unslash( $_POST );
			} else {
				return $this->state_data;
			}

			// From this point on we're handling data originating from $_POST, so original $key_rules apply.
			global $wpanalytify_key_rules;

			if ( empty( $key_rules ) && ! empty( $wpanalytify_key_rules ) ) {
				$key_rules = $wpanalytify_key_rules;
			}

			// Sanitize the new state data.
			if ( ! empty( $key_rules ) ) {
				$wpanalytify_key_rules = $key_rules;

				$context          = empty( $context ) ? $this->get_caller_function() : trim( $context );
				$this->state_data = WPANALYTIFY_Sanitize::sanitize_data( $this->state_data, $key_rules, $context );

				if ( false === $this->state_data ) {
					exit;
				}
			}

			return $this->state_data;
		}

		/**
		 * Create no records markup.
		 *
		 * @return void
		 */
		public function no_records() {
			?>

			<div class="analytify-stats-error-msg">
				<div class="wpb-error-box">
					<span class="blk">
						<span class="line"></span>
						<span class="dot"></span>
					</span>
					<span class="information-txt"><?php esc_html_e( 'No Activity During This Period.', 'wp-analytify' ); ?></span>
				</div>
			</div>

			<?php
		}

		/**
		 * Get Exception value.
		 *
		 * @since 2.1.22
		 */
		public function get_exception() {
			return $this->exception;
		}

		/**
		 * Set Exception value.
		 *
		 * @since 2.1.22
		 */
		public function set_exception( $exception ) {
			$this->exception = $exception;
		}

		/**
		 * Get ga4 Exception value.
		 * 
		 * @since 5.0.0
		 */
		public function get_ga4_exception(){
			return $this->ga4_exception;
		}

		/**
		 * Set Exception value.
		 *
		 * @since 5.0.0
		 */
		public function set_ga4_exception( $exception ) {
			$this->ga4_exception = $exception;
		}
		/**
		 * Fetch data from Google Analytics for dashboard.
		 *
		 * @param string $metrics
		 * @param string $start_date
		 * @param string $end_date
		 * @param boolean $dimensions
		 * @param boolean $sort
		 * @param boolean $filter
		 * @param boolean $limit
		 * @param string $name
		 * 
		 * @return void
		 */
		public function pa_get_analytics_dashboard_via_rest( $metrics, $start_date, $end_date, $dimensions = false, $sort = false, $filter = false, $limit = false, $name = '' ) {

			if ( $this->is_reporting_in_ga4 ) {
				return null;
			}

			try {
				$params = array();

				if ( $dimensions ) {
					$params['dimensions'] = $dimensions;
				}
				if ( $sort ) {
					$params['sort'] = $sort;
				}
				if ( $filter ) {
					$params['filters'] = $filter;
				}
				if ( $limit ) {
					$params['max-results'] = $limit;
				}

				$profile_id = $this->settings->get_option( 'profile_for_dashboard', 'wp-analytify-profile' );

				if ( ! $profile_id ) {
					return false;
				}

				$is_custom_api = $this->settings->get_option( 'user_advanced_keys', 'wp-analytify-advanced' );
				$cache_result = get_transient( md5( $name . $profile_id . $start_date . $end_date . $filter ) );

				if ( 'on' !== $is_custom_api ) {
					// If exception, return if the cache result else return the error.
					if ( $exception = get_transient( 'analytify_quota_exception' ) ) {
						if ( $cache_result ) {
							return $cache_result;
						}
						// return array( 'api_error' => $this->show_error_box( $exception ) );
					}
				}

				// If custom keys set. Fetch fresh result always.
				if ( 'on' === $is_custom_api || $cache_result === false ) {
					$result = $this->service->data_ga->get( 'ga:' . $profile_id, $start_date, $end_date, $metrics, $params );
					
					set_transient( md5( $name . $profile_id . $start_date . $end_date . $filter ) , $result, $this->get_cache_time() );
					
					return $result;
				} else {
					return $cache_result;
				}
			} catch ( Analytify_Google_Service_Exception $e ) {
				set_transient( 'analytify_quota_exception', $e->getMessage(), HOUR_IN_SECONDS );

				$logger = analytify_get_logger();
				$logger->warning( $e->getMessage(), array( 'source' => 'analytify_fetch_data' ) );

				// Show error message only for logged in users.
				if ( current_user_can( 'manage_options' ) ) {
					$error_code = $e->getErrors();
					$error = "<div class=\"analytify-stats-error-msg\">
					<div class=\"wpb-error-box\">
					<span class=\"blk\">
					<span class=\"line\"></span>
					<span class=\"dot\"></span>
					</span>
					<span class=\"information-txt\">";
					
					if ( $error_code[0]['reason'] == 'userRateLimitExceeded'  ) {
						$error .= 'API error: User Rate Limit Exceeded <a href="https://analytify.io/user-rate-limit-exceeded-guide" target="_blank" class="error_help">help</a>';
					} elseif ( $error_code[0]['reason'] == 'dailyLimitExceeded' ) {
						$error .= 'API error: Daily Limit Exceeded <a href="https://analytify.io/daily-limit-exceeded" target="_blank" class="error_help">help?</a>';
					} else {
						$error .= $e->getMessage();
					}

					$error .= "</span>
					</div>
					</div>";

					return array( 'api_error' => $error ) ;
				}
			} catch ( Analytify_Google_Auth_Exception $e ) {
				$logger = analytify_get_logger();
				$logger->warning( $e->getMessage(), array( 'source' => 'analytify_fetch_data' ) );
				
				// Show error message only for logged in users.
				if ( current_user_can( 'manage_options' ) ) {
					$error = sprintf( esc_html__( '%1$s Oops, Try to %3$s Reset %4$s Authentication. %2$s %7$s %2$s %5$s Don\'t worry, This error message is only visible to Administrators. %6$s %2$s', 'wp-analytify' ), '<br /><br />', '<br />', '<a href=' . esc_url( admin_url( 'admin.php?page=analytify-settings&tab=authentication' ) ) . ' title="Reset">', '</a>', '<i>', '</i>', esc_html( $e->getMessage() ) );
					
					return array( 'api_error' => $error ) ;
				}
			} catch ( Analytify_Google_IO_Exception $e ) {
				$logger = analytify_get_logger();
				$logger->warning( $e->getMessage(), array( 'source' => 'analytify_fetch_data' ) );
				
				// Show error message only for logged in users.
				if ( current_user_can( 'manage_options' ) ) {
					$error = sprintf( esc_html__( '%1$s Oops! %2$s %5$s %2$s %3$s Don\'t worry, This error message is only visible to Administrators. %4$s %2$s', 'wp-analytify' ), '<br /><br />', '<br />', '<i>', '</i>', esc_html( $e->getMessage() ) );
					return array( 'api_error' => $error ) ;
				}
			}
		}

		/**
		 * Generate the Error box.
		 *
		 * @since 2.1.23
		 */
		protected function show_error_box( $message ) {
			$error = '<div class="analytify-stats-error-msg">
				<div class="wpb-error-box">
					<span class="blk">
						<span class="line"></span>
						<span class="dot"></span>
					</span>
					<span class="information-txt">'
					. $message .
					'</span>
				</div>
			</div>';

			return $error;
		}

		/**
		 * If error, return cache result else return error.
		 *
		 * @since 2.1.23
		 */
		public function tackle_exception ( $exception, $cache_result ) {

			if ( $cache_result ) {
				return $cache_result;
			}

			echo $this->show_error_box( $exception );
		}

		/**
		 * Set Cache time for Stats.
		 *
		 * @version 5.0.4
		 * @since 2.2.1
		 */
		public function set_cache_time() {
			$this->cache_timeout = $this->settings->get_option( 'delete_dashboard_cache','wp-analytify-dashboard','off' ) === 'on' ? apply_filters( 'analytify_stats_cache_time', 60 * 60 * 10 ) : apply_filters( 'analytify_stats_cache_time', 60 * 60 * 24 );
		}

		/**
		 * Get Cache time for Stats.
		 *
		 * @version 5.0.4
		 *
		 * @since 2.2.1
		 */
		public function get_cache_time() {
			return $this->cache_timeout;
		}

		/**
		 * Check the active/deactive state of addon/moudle.
		 * 
		 * @param string $slug Slug of addon/moudle 
		 * @return string $addon_state: active or deactive
		 */
		public function analytify_module_state( $slug ) {

			$WP_ANALYTIFY = $GLOBALS['WP_ANALYTIFY'];
			$addon_state = '';

			$pro_inner = [
				'detail-realtime',
				'detail-demographic',
				'search-terms'
			];
			$pro_addon = [
				'wp-analytify-woocommerce',
				'wp-analytify-goals',
				'wp-analytify-authors',
				'wp-analytify-edd',
				'wp-analytify-forms',
				'wp-analytify-campaigns'
			];
			$pro_features = [
				'custom-dimensions',
				'events-tracking'
			];

			if ( in_array( $slug, $pro_features ) ) {
				$analytify_modules = get_option( 'wp_analytify_modules' );

				if ( 'active' === $analytify_modules[$slug]['status'] ) {
					$addon_state = 'active';
				}

				$addon_state = 'deactive';
			} elseif ( in_array( $slug, $pro_addon ) || in_array( $slug, $pro_inner ) ) {
				if ( in_array( $slug, $pro_inner ) ) {
					$slug = 'wp-analytify-pro';
				}

				if ( $WP_ANALYTIFY->addon_is_active( $slug ) ) {
					$addon_state = 'active';
				}

				$addon_state = 'deactive';
			}

			return $addon_state;
		}

		/**
		 * Check if external addon is active.
		 * 
		 * @param string $slug Slug of addon 
		 * 
		 * @return bool $addon_active
		 */
		public function addon_is_active( $slug ) {

			$addon_active = false;

			switch ( $slug ) {
				case 'wp-analytify':
					if ( class_exists( 'Analytify_General' ) ) {
						$addon_active = true;
					}
					break;

				case 'wp-analytify-goals':
					if ( class_exists( 'WP_Analytify_Goals' ) ) {
						$addon_active = true;
					}
					break;
				
				case 'wp-analytify-woocommerce':
					if ( class_exists( 'WP_Analytify_Woocommerce' ) ) {
						$addon_active = true;
					}
					break;

				case 'wp-analytify-campaigns':
					if ( class_exists( 'ANALYTIFY_PRO_CAMPAIGNS' ) ) {
						$addon_active = true;
					}
					break;

				case 'wp-analytify-authors':
					if ( class_exists( 'Analytify_Authors' ) ) {
						$addon_active = true;
					}
					break;

				case 'wp-analytify-edd':
					if ( class_exists( 'WP_Analytify_Edd' ) ) {
						$addon_active = true;
					}
					break;

				case 'wp-analytify-forms':
					if ( class_exists( 'Analytify_Forms' ) ) {
						$addon_active = true;
					}
					break;

				case 'wp-analytify-pro':
					if ( class_exists( 'WP_Analytify_Pro_Base' ) ) {
						$addon_active = true;
					}
					break;

				default:
					$addon_active = false;
					break;
			}

			return $addon_active;
		}

		/**
		 * Create dashboard navigation anchors.
		 * 
		 * @param array $nav_item Single navigation item data array.
		 * 
		 * @return mixed $anchor
		 */
		private function navigation_anchors( array $nav_item ) {
			
			$current_screen = get_current_screen()->base;
			$current_addon_name = '';

			// Check if child dashboard page for addon/module.
			if ( isset( $_GET['addon'] ) ) {
				$current_addon_name = $_GET['addon'];
			} elseif ( isset( $_GET['show'] ) ) {
				$current_addon_name = $_GET['show'];
			}

			if ( 'pro_feature' === $nav_item['module_type'] ) {
				// Module availbe in pro version as switchable feature.

				$nav_link = $this->addon_is_active( 'wp-analytify-pro' ) && 'active' === $this->modules[ $nav_item['addon_slug'] ]['status'] ? admin_url( 'admin.php?page=' . $nav_item['page_slug'] ) : admin_url( 'admin.php?page=analytify-promo&addon=' . $nav_item['addon_slug'] );
				$active_tab = ( 'analytify_page_' . $nav_item['page_slug'] === $current_screen || $nav_item['addon_slug'] === $current_addon_name ) ? 'nav-tab-active' : '';
			} elseif ( 'pro_inner' === $nav_item['module_type'] ) {
				// Module build in pro version.

				$nav_link = $this->addon_is_active( 'wp-analytify-pro' ) ? admin_url( 'admin.php?page=' . $nav_item['page_slug'] .'&show=' . $nav_item['addon_slug'] ) : admin_url( 'admin.php?page=analytify-promo&addon=' . $nav_item['addon_slug'] );
				$active_tab = ( 'analytify_page_' . $nav_item['page_slug'] === $current_screen || $nav_item['addon_slug'] === $current_addon_name ) ? 'nav-tab-active' : '';
			} elseif ( 'pro_addon' === $nav_item['module_type'] ) {
				// Not inner module, rather a seperate plugin.

				$nav_link = $this->addon_is_active( $nav_item['addon_slug'] ) ? admin_url( 'admin.php?page=' . $nav_item['page_slug'] ) : admin_url( 'admin.php?page=analytify-promo&addon=' . $nav_item['addon_slug'] );
				$active_tab = ( 'analytify_page_' . $nav_item['page_slug'] === $current_screen || $nav_item['addon_slug'] === $current_addon_name ) ? 'nav-tab-active' : '';
			} elseif ( 'free' === $nav_item['module_type'] ) {
				// Free version main dashboard page.
				
				$nav_link = admin_url( 'admin.php?page='. $nav_item['page_slug'] );
				$active_tab = ( 'toplevel_page_' . $nav_item['page_slug'] === $current_screen && empty( $current_addon_name ) ) ? 'nav-tab-active' : '';
			}

			$anchor = '<a href="' . esc_url( $nav_link ) . '" class="analytify_nav_tab ' . $active_tab. '">' . $nav_item['name'];
			$anchor .= (isset($nav_item['sub_name']) AND !empty($nav_item['sub_name'])) ? '<span>'.$nav_item['sub_name'].'</span>' : '';
			$anchor .= '</a>';

			return $anchor;
		}

		/**
		 * Generate dashboard navigation markup.
		 * 
		 * @param array $nav_items Navigation items data array.
		 */
		private function navigation_markup( array $nav_items ) {
			if ( is_array( $nav_items ) && 0 < count( $nav_items ) ) {
				echo '<div class="analytify_nav_tab_wrapper nav-tab-wrapper">';
				echo $this->generate_submenu_markup( $nav_items, 'analytify_nav_tab_wrapper', 'analytify_nav_tab_parent' );
				echo '</div>';
			}
		}

		/**
		 * Create HTML markup for navigation on dashboard.
		 * 
		 * @param array $nav_items Navigation items data array.
		 * @param string $wrapper_classes Class attribute for navigation wrapper.
		 * @param string $list_item_classes Class attribute for list item.
		 * 
		 * @return mixed $markup
		 */
		private function generate_submenu_markup( array $nav_items, $wrapper_classes = false, $list_item_classes = false ) {

			// Hide tabs filter.
			$hide_tabs = apply_filters( 'analytify_hide_dashboard_tabs', array() );
			
			// Wrapper
			$markup = '<ul';
			$markup .= $wrapper_classes ? ' class="'.$wrapper_classes.'"' : '';
			$markup .= '>';

			// Loop over all the menu items
			foreach ( $nav_items as $items ) {

				// Exclude hidden tabs from dashboard as in filter.
				if ( $hide_tabs && in_array( $items['name'], $hide_tabs ) ) {
					continue;
				}

				$markup .= '<li';
				$markup .= $list_item_classes ? ' class="'.$list_item_classes.'"' : '';
				$markup .= '>';

				// generate anchor
				$markup .= $this->navigation_anchors( $items );
				
				// check if the menu has children, then call itself to generate the child menu
				if ( isset( $items['children'] ) && is_array( $items['children'] ) ) {
					$markup .= $this->generate_submenu_markup( $items['children'] );
				}

				$markup .= '</li>';
			}

			// End wrapper
			$markup .= '</ul>';

			return $markup;
		}

		/**
		 * Register dashboard navigation menu.
		 * 
		 */
		public function dashboard_navigation() {

			$nav_items = array(

				array(
					'name'			=> 'Audience',
					'sub_name'		=> 'Overview',
					'page_slug'		=> 'analytify-dashboard',
					'addon_slug'	=> 'wp-analytify',
					'module_type'	=> 'free',
				),

				array(
					'name'			=> 'Conversions',
					'sub_name'		=> 'All Events',
					'page_slug'		=> 'analytify-forms',
					'addon_slug'	=> 'wp-analytify-forms',
					'module_type'	=> 'pro_addon',
					'children' 		=> array(
						array(
							'name'			=> 'Forms Tracking',
							'sub_name'		=> 'View Forms Analytics',
							'page_slug'		=> 'analytify-forms',
							'addon_slug'	=> 'wp-analytify-forms',
							'module_type'	=> 'pro_addon',
						),
						array(
							'name'			=> 'Events Tracking',
							'sub_name'		=> 'Affiliates, clicks and links tracking',
							'page_slug'		=> 'analytify-events',
							'addon_slug'	=> 'events-tracking',
							'module_type'	=> 'pro_feature',
						)
					)
				),

				array(
					'name'			=> 'Acquisition',
					'sub_name'		=> 'Goals, Campaigns',
					'page_slug'		=> 'analytify-campaigns',
					'addon_slug'	=> 'wp-analytify-campaigns',
					'module_type'	=> 'pro_addon',
					'children'		=> array(
						array(
							'name'			=> 'Campaigns',
							'sub_name'		=> 'UTM Overview',
							'page_slug'		=> 'analytify-campaigns',
							'addon_slug'	=> 'wp-analytify-campaigns',
							'module_type'	=> 'pro_addon',
						),
						array(
							'name'			=> 'Goals',
							'sub_name'		=> 'Overview',
							'page_slug'		=> 'analytify-goals',
							'addon_slug'	=> 'wp-analytify-goals',
							'module_type'	=> 'pro_addon',
						)
					)
				),

				array(
					'name'			=> 'Monetization',
					'sub_name'		=> 'Overview',
					'page_slug'		=> 'analytify-woocommerce',
					'addon_slug'	=> 'wp-analytify-woocommerce',
					'module_type'	=> 'pro_addon',
					'clickable'		=> true,
					'children' 		=> array(
						array(
							'name'			=> 'WooCommerce',
							'sub_name'		=> 'eCommerce Stats',
							'page_slug'		=> 'analytify-woocommerce',
							'addon_slug'	=> 'wp-analytify-woocommerce',
							'module_type'	=> 'pro_addon',
						),
						array(
							'name'			=> 'EDD',
							'sub_name'		=> 'Checkout behavior',
							'page_slug'		=> 'edd-dashboard',
							'addon_slug'	=> 'wp-analytify-edd',
							'module_type'	=> 'pro_addon',
						)
					)
				),

				array(
					'name'			=> 'Engagement',
					'sub_name'		=> 'Authors, Dimensions',
					'page_slug'		=> 'analytify-authors',
					'addon_slug'	=> 'wp-analytify-authors',
					'module_type'	=> 'pro_addon',
					'children'		=> array(
						array(
							'name'			=> 'Authors',
							'sub_name'		=> 'Authors Content Overview',
							'page_slug'		=> 'analytify-authors',
							'addon_slug'	=> 'wp-analytify-authors',
							'module_type'	=> 'pro_addon',
						),
						array(
							'name'			=> 'Demographics',
							'sub_name'		=> 'Age & Gender Overview',
							'page_slug'		=> 'analytify-dashboard',
							'addon_slug'	=> 'detail-demographic',
							'module_type'	=> 'pro_inner',
						),
						array(
							'name'			=> 'Search Terms',
							'sub_name'		=> 'On Site Searches',
							'page_slug'		=> 'analytify-dashboard',
							'addon_slug'	=> 'search-terms',
							'module_type'	=> 'pro_inner',
						),
						array(
							'name'			=> 'Dimensions',
							'sub_name'		=> 'Custom Dimensions',
							'page_slug'		=> 'analytify-dimensions',
							'addon_slug'	=> 'custom-dimensions',
							'module_type'	=> 'pro_feature',
						)
					)
				),

				array(
					'name'			=> 'Real-Time',
					'sub_name'		=> 'Live Stats',
					'page_slug'		=> 'analytify-dashboard',
					'addon_slug'	=> 'detail-realtime',
					'module_type'	=> 'pro_inner',
				)
			);

			$this->navigation_markup( $nav_items );
		}
	}
}