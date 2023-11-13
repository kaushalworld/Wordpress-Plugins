<?php
namespace ExclusiveAddons\Pro\Elementor;

use ExclusiveAddons\Elements\LoginRegister;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Class Login.
 */
class LoginClass {

	public static function init() {
		add_action( 'init', [ __CLASS__, 'exad_login_submission' ] );
	}

	/**
	 * Attempt to login user when login form is submitted.
	 *
	 * @since  1.21.0
	 * @access public
	 */
	public static function exad_login_submission() {

		if ( isset( $_POST['exad-login-nonce'] ) && wp_verify_nonce( $_POST['exad-login-nonce'], 'exad-login' ) ) {
			if ( isset( $_POST['exad-login-submit'] ) ) {

				if ( ! session_id() && ! headers_sent() ) {
					session_start();
				}

				$data = $_POST;
				
				$username   = ! empty( $data['log'] ) ? $data['log'] : '';
				$password   = ! empty( $data['pwd'] ) ? $data['pwd'] : '';
				$rememberme = ! empty( $data['rememberme'] ) ? $data['rememberme'] : '';
				
				$user_data = wp_signon(
					array(
						'user_login'    => $username,
						'user_password' => $password,
						'remember'      => ( 'forever' === $rememberme ) ? true : false,
					)
				);
				
				if ( is_wp_error( $user_data ) ) {

					if ( isset( $user_data->errors['invalid_email'][0] ) ) {

						$_SESSION['exad_error'] = 'invalid_email';

					} elseif ( isset( $user_data->errors['invalid_username'][0] ) ) {

						$_SESSION['exad_error'] = 'invalid_username';

					} elseif ( isset( $user_data->errors['incorrect_password'][0] ) ) {

						$_SESSION['exad_error'] = 'incorrect_password';
					}
				} else {
					wp_set_current_user( $user_data->ID, $username );
					do_action( 'wp_login', $user_data->user_login, $user_data );
					if ( isset( $data['redirect_to'] ) && '' !== $data['redirect_to'] ) {
						wp_safe_redirect( $data['redirect_to'] );
						exit();
					}
				}
			}
		}
	}

}
LoginClass::init();
