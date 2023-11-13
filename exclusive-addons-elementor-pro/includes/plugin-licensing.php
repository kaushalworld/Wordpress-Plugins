<?php
namespace ExclusiveAddons\Pro\Elementor;

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Licensing input and validation
 */
class Exad_Licensing {

	/**
	 * Plugin Slug
	 */
	public $plugin_slug;

	/**
	 *
	 * Plugin Name
	 */
	public $plugin_name;

	/**
	 *
	 * Plugin Text Domain
	 */
	public $text_domain;

	/**
	 * Initializes the license manager client.
	 */
	public function __construct( $plugin_slug, $plugin_name, $text_domain ) {
		$this->plugin_slug         = $plugin_slug;
		$this->text_domain         = $text_domain;
		$this->plugin_name         = $plugin_name;

		$this->register_hooks();
	}


	/**
	 * Adds actions required for class functionality
	 */
	public function register_hooks() {
		if ( is_admin() ) {
			add_action( 'admin_init', array( $this, 'register_license_settings' ) );
			add_action( 'admin_init', array( $this, 'activate_license' ) );
			add_action( 'admin_init', array( $this, 'deactivate_license' ) );
			add_action( 'admin_notices', array( $this, 'license_notices' ) );
            add_action( 'exad/add_admin_license_page', array( $this, 'render_license_dashboard' ) );
		}
	}

	/**
	 * @return string   The slug id of the licenses settings page.
	 */
	protected function settings_page_slug() {
		return 'exad-settings';
	}

	/**
	 * Creates the settings fields needed for the license settings menu.
	 */
	public function register_license_settings() {
		register_setting( $this->settings_page_slug(), $this->plugin_slug . '-license-key', 'sanitize_license' );
	}

	/**
	* Admin notices for errors and license activation
	*
	*/
	public function license_notices() {
		return;
		$status = $this->get_license_status();
		if( ! isset( $_POST[ $this->plugin_slug . '_license_activate' ] ) ) {
			$license_data = $this->get_license_data();
		}

		if( isset( $_POST[ $this->plugin_slug . '_license_deactivate' ] ) ) {
			delete_transient( $this->plugin_slug . '-license_data' );
		}

		if( isset( $license_data->license ) ) {
			$status = $license_data->license;
		}

		if( $status === 'http_error' ) {
			return;
		}

		if ( ( $status === false || $status !== 'valid' ) && $status !== 'expired' ) {
			$msg = __( 'Please %1$sactivate your license%2$s key to get premium support and automatic update from your WordPress dashboard for %3$s.', $this->text_domain );
			$msg = sprintf( $msg, '<a href="' . admin_url( 'admin.php?page=' . $this->settings_page_slug() ) . '">', '</a>',	'<strong>' . $this->plugin_name . '</strong>' );
			?>
			<div class="notice notice-error">
				<p><?php echo $msg; ?></p>
			</div>
		<?php
		}
		if ( $status === 'expired' ) {
			$msg = __( 'Your license has been expired. Please %1$srenew your license%2$s to get premium support and automatic update from your WordPress dashboard %3$s.',	$this->text_domain );
			$msg = sprintf( $msg, '<a href="https://exclusiveaddons.com/">', '</a>', '<strong>' . $this->plugin_name . '</strong>' );
			?>
			<div class="notice notice-error">
				<p><?php echo $msg; ?></p>
			</div>
		<?php
		}
		if ( ( isset( $_GET['sl_activation'] ) || isset( $_GET['sl_deactivation'] ) ) && ! empty( $_GET['message'] ) ) {
			$target = isset( $_GET['sl_activation'] ) ? $_GET['sl_activation'] : null;
			$target = is_null( $target ) ? ( isset( $_GET['sl_deactivation'] ) ? $_GET['sl_deactivation'] : null ) : null;
			switch( $target ) {
				case 'false':
					$message = urldecode( $_GET['message'] );
					?>
					<div class="error">
						<p><?php echo $message; ?></p>
					</div>
					<?php
					break;
				case 'true':
				default:
					break;

			}
		}
	}


	/**
	 *
	 * Sanitize Product License Key
	 */
	public function sanitize_license( $new ) {
		$old = get_option( $this->plugin_slug . '-license-key' );
		if ( $old && $old != $new ) {
			delete_option( $this->plugin_slug . '-license-status' ); // new license has been entered, so must reactivate
		}
		return $new;
	}


	/**
	 * Renders the settings page for entering license information.
	 */
	public function render_license_dashboard() {
		return;
		$license_key 	= $this->get_license_key();
		$title 			= sprintf( __( '%s License', $this->text_domain ), $this->plugin_name );
		$status = $this->get_license_status();
		?>
		<div class="exad-license-wrapper">
			<form method="post" action="options.php" id="exad-license-form">

				<?php settings_fields( $this->settings_page_slug() ); ?>

					<div class="exad-license-header">
						<div class="exad-license-header-support">
							<div class="exad-license-header-support-icon">
								<svg width="32" height="37" viewBox="0 0 32 37" xmlns="http://www.w3.org/2000/svg">
									<path d="M14.847 34.616h3.242v-1.199h-3.242v1.199zM2.322 23.259v-6.427c0-1.475.738-2.223 2.191-2.223h.81V25.48h-.81c-1.453 0-2.19-.747-2.19-2.222zm24.356-8.602h.809c1.453 0 2.19.748 2.19 2.22l-.033 6.402c0 1.475-.737 2.223-2.19 2.223h-.776V14.657zm1.946-2.274C28.397 5.516 22.821 0 16 0 9.179 0 3.603 5.516 3.376 12.383 1.252 12.827 0 14.468 0 16.853v6.426c0 3.406 2.45 4.614 4.547 4.614H6.5c.65 0 1.179-.536 1.179-1.195V13.46c0-.66-.529-1.195-1.179-1.195h-.763C6.001 6.753 10.503 2.35 16 2.35s9.999 4.403 10.263 9.916H25.5c-.65 0-1.179.536-1.179 1.195v13.216c0 .66.529 1.196 1.179 1.196h.743c-.195 2.393-.998 3.294-1.603 3.767-.873.683-2.148 1.042-4.21 1.177-.042-.999-.856-1.798-1.85-1.798h-4.237c-1.021 0-1.852.843-1.852 1.88v2.222c0 1.036.83 1.879 1.852 1.879h4.25c.992 0 1.804-.795 1.85-1.79 3.838-.229 7.781-1.174 8.168-7.452 2.131-.44 3.389-2.083 3.389-4.472v-6.427c0-2.389-1.253-4.033-3.376-4.476z" fill="#FFF" fill-rule="evenodd"/>
								</svg>
							</div>
							<div class="exad-license-header-support-content">
								<h3><?php _e( __( 'Premium Support', $this->text_domain) ); ?></h3>
								<p><?php _e( __( 'You can contribute to make Exclusive Addons better reporting bugs, creating issues, pull requests at Github.', $this->text_domain) ); ?></p>
							</div>
						</div>
						<div class="exad-license-header-update">
							<div class="exad-license-header-update-icon">
								<svg width="37" height="37" viewBox="0 0 37 37" xmlns="http://www.w3.org/2000/svg">
									<path d="M18.5 0a18.38 18.38 0 0113.082 5.418A18.38 18.38 0 0137 18.5a18.38 18.38 0 01-5.418 13.082A18.38 18.38 0 0118.5 37a18.38 18.38 0 01-13.082-5.418A18.38 18.38 0 010 18.5 18.38 18.38 0 015.418 5.418 18.38 18.38 0 0118.5 0zm0 2.168A16.225 16.225 0 006.952 6.952 16.225 16.225 0 002.168 18.5c0 4.363 1.699 8.464 4.784 11.548A16.225 16.225 0 0018.5 34.832c4.363 0 8.464-1.699 11.548-4.784A16.225 16.225 0 0034.832 18.5c0-4.362-1.699-8.464-4.784-11.548A16.225 16.225 0 0018.5 2.168zm9.293 9.316l5.263 2.344-.882 1.98-1.795-.8a12.405 12.405 0 01-3.126 12.245 12.267 12.267 0 01-7.097 3.515 12.458 12.458 0 01-7.632-1.424l1.048-1.898a10.286 10.286 0 006.296 1.173 10.117 10.117 0 005.852-2.899 10.233 10.233 0 002.59-10.065l-.88 1.974-1.98-.882 2.343-5.263zm-10.95-5.252a12.47 12.47 0 017.633 1.424l-1.047 1.898a10.287 10.287 0 00-6.297-1.173 10.117 10.117 0 00-5.852 2.899 10.233 10.233 0 00-2.59 10.065l.88-1.974 1.98.882-2.343 5.263-5.263-2.343.882-1.981 1.795.8A12.406 12.406 0 019.747 9.746a12.268 12.268 0 017.097-3.515z" fill="#FFF" fill-rule="evenodd"/>
								</svg>
							</div>
							<div class="exad-license-header-update-content">
								<h3><?php _e( __( 'Automatic Update', $this->text_domain) ); ?></h3>
								<p><?php _e( __( 'You can contribute to make Exclusive Addons better reporting bugs, creating issues, pull requests at Github.', $this->text_domain) ); ?></p>
							</div>
						</div>
					</div>

      				<div class="exad-license-container">
						<div class="exad-license-input">
							<div class="exad-license-icon">
								<?php if( $status == false && $status !== 'valid' ) { ?>
									<!-- Status not valid -->
									<svg width="16" height="21" viewBox="0 0 16 21" xmlns="http://www.w3.org/2000/svg">
										<path d="M8 .2a4.803 4.803 0 014.795 4.586L12.8 5v4H14a2 2 0 012 2v8a2 2 0 01-2 2H2a2 2 0 01-2-2v-8a2 2 0 012-2h1.199L3.2 5A4.8 4.8 0 018 .2zm0 1.6a3.2 3.2 0 00-3.195 3.018L4.8 5l-.001 4H11.2V5c0-1.765-1.435-3.2-3.2-3.2z" fill="#F45276" fill-rule="nonzero"/>
									</svg>
								<?php } ?>
								<?php if( $status !== false && $status == 'valid' ) { ?>
									<!-- Status valid icon -->
									<svg width="16" height="21" viewBox="0 0 16 21" xmlns="http://www.w3.org/2000/svg">
										<path d="M8 .2a4.803 4.803 0 014.795 4.586L12.8 5v4H14a2 2 0 012 2v8a2 2 0 01-2 2H2a2 2 0 01-2-2v-8a2 2 0 012-2h9.2V5a3.2 3.2 0 00-6.4 0 .8.8 0 11-1.6 0A4.8 4.8 0 018 .2z" fill="#46D39A" fill-rule="evenodd"/>
									</svg>
								<?php } ?>

							</div>
							<input <?php echo ( $status !== false && $status == 'valid' ) ? 'disabled' : ''; ?> id="<?php echo $this->plugin_slug; ?>-license-key" name="<?php echo $this->plugin_slug; ?>-license-key" type="text" class="regular-text" value="<?php echo esc_attr( $this->get_hidden_license_key() ); ?>" placeholder="Place Your Lisence Key Here & Click Activate Buttton" />
						</div>

						<div class="exad-license-buttons">
							<?php wp_nonce_field( $this->plugin_slug . '_license_nonce', $this->plugin_slug . '_license_nonce' ); ?>

							<?php if( $status !== false && $status == 'valid' ) { ?>
								<input type="hidden" name="action" value="exad_pro_deactivate_license"/>
								<input type="hidden" name="<?php echo $this->plugin_slug; ?>_license_deactivate" />
								<?php submit_button( __( 'Deactivate', $this->text_domain ), 'exad-license-deactivation-btn', 'submit', false, array( 'class' => 'button button-primary' ) ); ?>
							<?php } else { ?>
								<input type="hidden" name="<?php echo $this->plugin_slug; ?>_license_activate" />
								<?php submit_button( __( 'Activate', $this->text_domain ), 'exad-license-activation-btn', 'submit', false, array( 'class' => 'button button-primary' ) ); ?>
							<?php } ?>
						</div>
					</div>
			</form>
		</div>
	<?php
	}

	/**
	 * Gets the current license status
	 *
	 * @return bool|string   The product license key, or false if not set
	 */
	public function get_license_status() {
		$status = get_option( $this->plugin_slug . '-license-status' );
		if ( ! $status ) {
			return false;
		}
		return trim( $status );
	}

	/**
	 * Gets the currently set license key
	 *
	 * @return bool|string   The product license key, or false if not set
	 */
	public function get_license_key() {
		$license = trim( get_option( $this->plugin_slug . '-license-key' ) );
		if ( ! $license ) {
			return false;
		}
		return $license;
	}


	/**
	 * Updates the license key option
	 *
	 * @return bool|string   The product license key, or false if not set
	 */
	public function set_license_key( $license_key ) {
		return update_option( $this->plugin_slug . '-license-key', $license_key );
	}

	/**
	 * Display the hidden license Keys
	 *
	 */
	private function get_hidden_license_key() {
		$input_string = $this->get_license_key();

		$start = 3;
		$length = mb_strlen( $input_string ) - $start - 3;

		$mask_string = preg_replace( '/\S/', '*', $input_string );
		$mask_string = mb_substr( $mask_string, $start, $length );
		$input_string = substr_replace( $input_string, $mask_string, $start, $length );

		return $input_string;
	}

	/**
	 * @param array $body_args
	 *
	 * @return \stdClass|\WP_Error
	 */
	private function remote_post( $body_args = [] ) {
		$api_params = wp_parse_args(
			$body_args,
			[
				'item_id' => urlencode( EXAD_SL_ITEM_ID ),
				'url'     => home_url(),
			]
		);

		$response = wp_remote_post( EXAD_SL_STORE_URL, [
			'sslverify' => true,
			'timeout' => 40,
			'body' => $api_params,
		] );

		if ( is_wp_error( $response ) ) {
			return $response;
		}

		$response_code = wp_remote_retrieve_response_code( $response );
		if ( 200 !== (int) $response_code ) {
			return new \WP_Error( $response_code, __( 'HTTP Error', 'exclusive-addons-elementor-pro' ) );
		}

		$data = json_decode( wp_remote_retrieve_body( $response ) );
		if ( empty( $data ) || ! is_object( $data ) ) {
			return new \WP_Error( 'no_json', __( 'An error occurred, please try again', 'exclusive-addons-elementor-pro' ) );
		}

		return $data;
	}

	public function activate_license(){
		if( ! isset( $_POST[ $this->plugin_slug . '_license_activate' ] ) ) {
			return;
		}

		if( ! check_admin_referer( $this->plugin_slug . '_license_nonce', $this->plugin_slug . '_license_nonce' ) ) {
			return;
		}

		$license = $_POST[ $this->plugin_slug . '-license-key' ];

		$api_params = array(
			'edd_action' => 'activate_license',
			'license'    => $license,
		);

		$license_data = $this->remote_post( $api_params );


		if( is_wp_error( $license_data ) ) {
			$message = $license_data->get_error_message();
		}

		if ( isset( $license_data->success ) && false === boolval( $license_data->success ) ) {

			switch( $license_data->error ) {

				case 'expired' :

					$message = sprintf(
						__( 'Your license key expired on %s.' ),
						date_i18n( get_option( 'date_format' ), strtotime( $license_data->expires, current_time( 'timestamp' ) ) )
					);
					break;

				case 'revoked' :

					$message = __( 'Your license key has been disabled.' );
					break;

				case 'missing' :

					$message = __( 'Invalid license.' );
					break;

				case 'invalid' :
				case 'site_inactive' :

					$message = __( 'Your license is not active for this URL.' );
					break;

				case 'item_name_mismatch' :

					$message = sprintf( __( 'This appears to be an invalid license key for %s.' ), EXAD_SL_ITEM_NAME );
					break;

				case 'no_activations_left':

					$message = __( 'Your license key has reached its activation limit.' );
					break;

				default :

					$message = __( 'An error occurred, please try again.' );
					break;
			}

		}


		if ( ! empty( $message ) ) {
			$base_url = admin_url( 'admin.php?page=' . $this->settings_page_slug() );
			$redirect = add_query_arg( array( 'sl_activation' => 'false', 'message' => urlencode( $message ) ), $base_url );
			wp_redirect( $redirect );
			exit();
		}

		$this->set_license_key( $license );
		$this->set_license_data( $license_data );
		$this->set_license_status( $license_data->license );
		wp_redirect( admin_url( 'admin.php?page=' . $this->settings_page_slug() ) );
		exit();

	}

	/**
	 * Updates the license status option
	 *
	 */
	public function set_license_status( $license_status ) {
		return update_option( $this->plugin_slug . '-license-status', $license_status );
	}


	/**
	 *
	 * Set the license Data
	 */
	public function set_license_data( $license_data, $expiration = null ) {
		if ( null === $expiration ) {
			$expiration = 12 * HOUR_IN_SECONDS;
		}
		set_transient( $this->plugin_slug . '-license_data', $license_data, $expiration );
	}

	/**
	 * Retrive the License Data
	 *
	 */
	public function get_license_data( $force_request = false ) {
		$license_data = get_transient( $this->plugin_slug . '-license_data' );

		if ( false === $license_data || $force_request ) {

			$license = $this->get_license_key();

			if( empty( $license ) ) {
				return false;
			}

			$body_args = [
				'edd_action' => 'check_license',
				'license' => $this->get_license_key(),
			];

			$license_data = $this->remote_post( $body_args );

			if ( is_wp_error( $license_data ) ) {
				$license_data = new \stdClass();
				$license_data->license = 'valid';
				$license_data->payment_id = 0;
				$license_data->license_limit = 0;
				$license_data->site_count = 0;
				$license_data->activations_left = 0;
				$this->set_license_data( $license_data, 30 * MINUTE_IN_SECONDS );
				$this->set_license_status( $license_data->license );
			} else {
				$this->set_license_data( $license_data );
				$this->set_license_status( $license_data->license );
			}
		}

		return $license_data;
	}


	/**
	 * Deactivate the License
	 *
	 */
	public function deactivate_license(){
		if( ! isset( $_POST[ $this->plugin_slug . '_license_deactivate' ] ) ) {
			return;
		}
		if( ! check_admin_referer( $this->plugin_slug . '_license_nonce', $this->plugin_slug . '_license_nonce' ) ) {
			return;
		}

		$license = $this->get_license_key();

		$api_params = array(
			'edd_action' => 'deactivate_license',
			'license'    => $license,
		);

		$license_data = $this->remote_post( $api_params );

		error_log( json_encode( $license_data ) );

		if( is_wp_error( $license_data ) ) {
			$message = $license_data->get_error_message();
		}

		if( ! empty( $message ) ) {
			$base_url = admin_url( 'admin.php?page=' . $this->settings_page_slug() );
			$redirect = add_query_arg( array( 'sl_activation' => 'false', 'message' => urlencode( $message ) ), $base_url );
			wp_redirect( $redirect );
			exit();
		}

		if( $license_data->license != 'deactivated' ) {
			$message = __( 'An error occurred, please try again', 'exclusive-addons-elementor-pro' );
			$base_url = admin_url( 'admin.php?page=' . $this->settings_page_slug() );
			$redirect = add_query_arg( array( 'sl_deactivation' => 'false', 'message' => urlencode( $message ) ), $base_url );
			wp_redirect( $redirect );
			exit();
		}

		if( $license_data->license == 'deactivated' ) {
			delete_option( $this->plugin_slug . '-license-status' );
			delete_option( $this->plugin_slug . '-license-key' );
		}

		wp_redirect( admin_url( 'admin.php?page=' . $this->settings_page_slug() ) );
		exit();
	}

}
