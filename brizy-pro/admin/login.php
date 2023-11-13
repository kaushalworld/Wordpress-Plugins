<?php

class BrizyPro_Admin_Login {
    const AJAX_REGISTER_ACTION = 'editor_signup';

    const AJAX_LOGIN_ACTION = 'editor_login';

    const AJAX_LOSTPASSWORD_ACTION = 'editor_lostpassword';

    public function __construct() {
	    add_action( 'wp_ajax_' . self::AJAX_REGISTER_ACTION,            [ $this, 'signup' ] );
	    add_action( 'wp_ajax_nopriv_' . self::AJAX_REGISTER_ACTION,     [ $this, 'signup' ] );
        add_action( 'wp_ajax_' . self::AJAX_LOGIN_ACTION,               [ $this, 'login' ] );
        add_action( 'wp_ajax_nopriv_' . self::AJAX_LOGIN_ACTION,        [ $this, 'login' ] );
        add_action( 'wp_ajax_' . self::AJAX_LOSTPASSWORD_ACTION,        [ $this, 'lostpassword' ] );
        add_action( 'wp_ajax_nopriv_' . self::AJAX_LOSTPASSWORD_ACTION, [ $this, 'lostpassword' ] );
        add_action( 'wp_loaded',                                        [ $this, 'logout' ] );
    }

    public function signup() {

        if ( empty( $_REQUEST['hash'] ) || ! wp_verify_nonce( $_REQUEST['hash'], 'brizy-login' ) ) {
            wp_send_json( [ 'errors' => [ __( 'Something went wrong. Please refresh the page and try again.', 'brizy-pro' ) ] ] );
        }

	    $login = isset( $_POST['user_login'] ) && is_string( $_POST['user_login'] ) ? wp_unslash( $_POST['user_login'] ) : '';
	    $email = isset( $_POST['user_email'] ) && is_string( $_POST['user_email'] ) ? wp_unslash( $_POST['user_email'] ) : '';

	    if ( is_multisite() ) {

		    // The value can be 'all', 'none', 'blog', or 'user'.
		    if ( 'user' !== apply_filters( 'wpmu_active_signup', get_site_option( 'registration', 'none' ) ) ) {
			    wp_send_json( [ 'errors' => [ __( 'The current registration type is not supported. Please change it in network settings(Allow new registrations).', 'brizy-pro' ) ] ] );
		    }

			$result = wpmu_validate_user_signup( $login, $email );
		    $login  = $result['user_name'];
		    $email  = $result['user_email'];

			if ( is_wp_error( $result['errors'] ) ) {
				wp_send_json( [ 'errors' => $result['errors']->get_error_messages() ] );
			}

		    wpmu_signup_user( $login, $email, apply_filters( 'add_signup_meta', [] ) );

		    do_action( 'signup_finished' );

		    wp_send_json( [ 'success' => esc_html__( 'Registration complete. Please check your email, then visit the login page.', 'brizy-pro' ) ] );
	    }

	    if ( ! get_option( 'users_can_register' ) ) {
		    wp_send_json( [ 'errors' => [ __( 'Registration on this site has been disabled.', 'brizy-pro' ) ] ] );
	    }

	    $errors = register_new_user( $login, $email );

	    if ( is_wp_error( $errors ) ) {
		    wp_send_json( [ 'errors' => $errors->get_error_messages() ] );
	    } else {
		    wp_send_json( [ 'success' => esc_html__( 'Registration complete. Please check your email, then visit the login page.', 'brizy-pro' ) ] );
	    }
    }

	public function login() {

        if ( empty( $_REQUEST['hash'] ) || ! wp_verify_nonce( $_REQUEST['hash'], 'brizy-login' ) ) {
            wp_send_json( [ 'errors' => [ __( 'Something went wrong. Please refresh the page and try again.', 'brizy-pro' ) ] ] );
        }

        $user = wp_signon();

        if ( is_wp_error( $user ) ) {
            wp_send_json( [ 'errors' => $user->get_error_messages() ] );
        } else {
            wp_send_json( [ 'success' => esc_html__( 'You Have Successfully Logged in!', 'brizy-pro' ) ] );
        }
    }

    public function logout() {

        if ( empty( $_REQUEST['isEditorLogout'] ) ) {
            return;
        }

        if ( empty( $_REQUEST['_wpnonce'] ) || ! wp_verify_nonce( $_REQUEST['_wpnonce'], 'log-out' ) ) {
            wp_nonce_ays( 'log-out' );
            die();
        }

        $user = wp_get_current_user();

        wp_logout();

        if ( ! empty( $_REQUEST['redirect_to'] ) ) {
            $redirect_to           = $_REQUEST['redirect_to'];
            $requested_redirect_to = $redirect_to;
        } else {
            $redirect_to = add_query_arg(
                array(
                    'loggedout' => 'true',
                    'wp_lang'   => get_user_locale( $user ),
                ),
                wp_login_url()
            );

            $requested_redirect_to = '';
        }

        /**
         * Filters the log out redirect URL.
         *
         * @since 4.2.0
         *
         * @param string  $redirect_to           The redirect destination URL.
         * @param string  $requested_redirect_to The requested redirect destination URL passed as a parameter.
         * @param WP_User $user                  The WP_User object for the user that's logging out.
         */
        $redirect_to = apply_filters( 'logout_redirect', $redirect_to, $requested_redirect_to, $user );

        wp_safe_redirect( $redirect_to );
        exit;
    }

    public function lostpassword() {

        if ( empty( $_REQUEST['hash'] ) || ! wp_verify_nonce( $_REQUEST['hash'], 'brizy-login' ) ) {
            wp_send_json( [ 'errors' => [ __( 'Something went wrong. Please refresh the page and try again.', 'brizy-pro' ) ] ] );
        }

        // $_POST['user_login']
        $errors = retrieve_password();

        if ( is_wp_error( $errors ) ) {
            wp_send_json( [ 'errors' => $errors->get_error_messages() ] );
        } else {
            wp_send_json( [ 'success' => esc_html__( 'The password reset link has been sent successfully on your email.', 'brizy-pro' ) ] );
        }
    }
}