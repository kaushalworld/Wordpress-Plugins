<?php

class BrizyPro_Admin_License
{
    const LICENSE_META_KEY = 'brizy-license-key';

    private static $licenseData;

    /**
     * @return BrizyPro_Admin_License
     */
    public static function _init()
    {
        static $instance;

        return $instance ? $instance : $instance = new self();
    }

	/**
	 * @throws Exception
	 */
    private function __construct()
    {
        $isWlAdminOut = get_transient( BrizyPro_Admin_WhiteLabel::WL_SESSION_KEY ) != 1;

	    if ( ! BrizyPro_Admin_WhiteLabel::_init()->getEnabled() || BrizyPro_Admin_WhiteLabel::_init()->showLicenseTab() || ! $isWlAdminOut ) {
		    add_action( 'brizy_settings_tabs',       [ $this, 'addLicenseTab' ], 10, 2 );
		    add_action( 'brizy_settings_render_tab', [ $this, 'renderLicenseTab' ], 10, 2 );
        }

	    add_action( 'admin_init',                        [ $this, 'handleSubmit' ] );
	    add_action( 'brizy_network_settings_tabs',       [ $this, 'addLicenseTab' ], 10, 2 );
	    add_action( 'brizy_network_settings_render_tab', [ $this, 'renderLicenseTab' ], 10, 2 );
	    add_action( 'network_admin_notices',             [ $this, 'apiResponseNotice' ] );
	    add_action( 'network_admin_notices',             [ $this, 'changeLicenseNetworkNotice' ] );
	    add_action( 'admin_notices',                     [ $this, 'noLicenseNotice' ] );
	    add_action( 'admin_notices',                     [ $this, 'networkActivateNotice' ] );
	    add_action( 'admin_notices',                     [ $this, 'apiResponseNotice' ] );
    }

	public function getCurrentLicense()
	{
		return [ 'key' => '**********' ];
		if ( is_array( self::$licenseData ) ) {
            return self::$licenseData;
		}

		if ( is_multisite() && ! is_main_site() ) {
			if ( $license = Brizy_Editor_Project::get()->getMetaValue( self::LICENSE_META_KEY ) ) {
				self::$licenseData = $license;
				return self::$licenseData;
			}
		}

		$this->switchBlog( true );

		try {
			self::$licenseData = Brizy_Editor_Project::get()->getMetaValue( self::LICENSE_META_KEY );
		} catch (Exception $e) {
			self::$licenseData = [];
		}

		$this->switchBlog( false );

		return self::$licenseData;
	}

    public function handleSubmit() {

	    if ( empty( $_POST ) || ! isset( $_REQUEST['tab'] ) || $_REQUEST['tab'] != 'license' ) {
		    return;
	    }

	    if ( ! isset( $_POST['_wpnonce'] ) || ! wp_verify_nonce( $_POST['_wpnonce'], 'validate-license' ) ) {
		    return;
	    }

        $activate = $_REQUEST['license_form_action'] == 'activate';

	    if ( is_network_admin() && $activate ) {
		    Brizy_Admin_Flash::instance()->add_error( esc_html__( 'Brizy Pro does not support multisite license anymore.', 'brizy-pro' ) );
		    return;
	    }

        try {
            if ( $activate ) {
	            Brizy_Admin_Flash::instance()->add_success( $this->activate( [ 'key' => $_POST['key'] ] ) );
            } else {
                $this->deactivate();
	            Brizy_Admin_Flash::instance()->add_success( esc_html__( 'License was successfully deactivated!', 'brizy-pro' ) );
            }

        } catch ( Exception $e ) {
	        Brizy_Admin_Flash::instance()->add_error( $e->getMessage() );
        }
    }

	public function renderLicenseTab( $content = '', $tab = '' ) {
		if ( 'license' !== $tab ) {
			return $content;
		}

		$licenseData = is_multisite() && ! is_network_admin() ? Brizy_Editor_Project::get()->getMetaValue( self::LICENSE_META_KEY ) : $this->getCurrentLicense();

		if ( is_null( $licenseData ) ) {
			$licenseData = [];
		}

		// prepare license
		$key = isset( $licenseData['key'] ) ? $licenseData['key'] : null;
		if ( $key ) {
			$l   = strlen( $key );
			$t   = str_repeat( '*', $l - 6 );
			$key = substr( $key, 0, 3 ) . $t . substr( $key, $l - 3, 3 );
		}

		$context = [
			'nonce'               => wp_nonce_field( 'validate-license', '_wpnonce', true, false ),
			'action'              => $this->getTabUrl(),
			'submit_label'        => $key ? esc_html__( 'Deactivate', 'brizy-pro' ) : __( 'Activate', 'brizy-pro' ),
			'license_form_action' => $key ? 'deactivate' : 'activate',
			'license'             => $key
		];

        return Brizy_Editor_View::get( BRIZY_PRO_PLUGIN_PATH . '/admin/views/license', $context );
	}

	public function addLicenseTab( $tabs = '', $selected_tab = '' ) {
		$tabs[] = [
			'id'          => 'license',
			'label'       => __( 'License', 'brizy-pro' ),
			'is_selected' => $selected_tab == 'license',
			'href'        => $this->getTabUrl(),
		];

		return $tabs;
	}

	private function getTabUrl() {

		if ( is_network_admin() ) {
			return network_admin_url( 'admin.php?page=' . Brizy_Admin_NetworkSettings::menu_slug(), false ) . '&tab=license';
		} else {
			return menu_page_url(
				       is_network_admin() ? Brizy_Admin_NetworkSettings::menu_slug() : Brizy_Admin_Settings::menu_slug(),
				       false
			       ) . '&tab=license';
		}

	}

	public function noLicenseNotice() {

		$license = $this->getCurrentLicense();

		if ( ! empty( $license['key'] ) ) {
			return;
		}

		?>
		<div class="notice notice-info is-dismissible">
            <h3><?php printf( esc_html__( 'Welcome to %s!', 'brizy-pro' ), BrizyPro_Admin_WhiteLabel::_init()->gettext_domain( 'Brizy Pro', 'Brizy Pro' ) ) ?></h3>
            <p>
				<?php esc_html_e( 'Please activate your license to get feature updates, premium support and unlimited access to the template library.', 'brizy-pro' ) ?>
            </p>
            <a style="margin-bottom:10px" href="<?php echo esc_url( apply_filters('brizy_upgrade_to_pro_url', Brizy_Config::UPGRADE_TO_PRO_URL) ) ?>" class="button button-primary button-large"><?php esc_html_e( 'Activate', 'brizy-pro' ) ?></a>
		</div>
		<?php
	}

	/**
	 * @param $args
	 *
	 * @return string
	 * @throws Exception
	 */
	public function activate( $args ) {

        if ( empty( $args['key'] ) ) {
            throw new Exception( esc_html__( 'Please provide a license key.', 'brizy-pro' ) );
        }

		$response = $this->request( $args, BrizyPro_Config::ACTIVATE_LICENSE );

        if ( $response['code'] != 'ok' ) {
	        throw new Exception( $response['message'] );
        }

		$licenseData        = BrizyPro_Config::getLicenseActivationData();
        $licenseData['key'] = $args['key'];

		BrizyPro_Admin_Updater::_init()->delete_transients();

		Brizy_Editor_Project::get()->setMetaValue( self::LICENSE_META_KEY, $licenseData );
		Brizy_Editor_Project::get()->saveStorage();

        self::$licenseData = null;

		return esc_html__( 'License successfully activated.', 'brizy-pro' );
    }

	/**
	 * @param $args
	 *
     * @return string
	 * @throws Exception
	 */
	public function deactivate( $args = [] ) {

		if ( empty( $args['key'] ) ) {
			$license = $this->getCurrentLicense();

			if ( empty( $license['key'] ) ) {
				throw new Exception( esc_html__( 'No license was found in your installation', 'brizy-pro' ) );
			}

			$args['key'] = $license['key'];
		}

		// No reason to check by response key 'code', we do not know all of them: ok, no_activation_found, no_reactivation_allowed, license_not_found, etc.
		$response = $this->request( $args, BrizyPro_Config::DEACTIVATE_LICENSE );

        if ( is_network_admin() ) {
	        $this->switchBlog( true );
        }

		BrizyPro_Admin_Updater::_init()->delete_transients();

		try {

			Brizy_Editor_Project::get()->removeMetaValue( self::LICENSE_META_KEY );
			Brizy_Editor_Project::get()->saveStorage();

		} catch (Exception $e) {
			if ( is_network_admin() ) {
				$this->switchBlog( false );
			}
			throw $e;
		}

        self::$licenseData = null;

		if ( is_network_admin() ) {
			$this->switchBlog( false );
		}

		return $response['message'];
	}

    private function switchBlog( $switch ) {

	    if ( ! is_multisite() ) {
		   return;
	    }

        if ( $switch ) {
	        switch_to_blog( get_main_site_id() );
        } else {
	        restore_current_blog();
        }

	    Brizy_Editor_Project::cleanClassCache();
    }

	/**
	 * @return array
	 * @throws Exception
	 */
	public function request( $args, $url ) {

		$defaults = [
			'key'             => '',
			'version'         => BRIZY_PRO_VERSION,
			'slug'            => basename( BRIZY_PRO_PLUGIN_BASE, '.php' ),
			'request[domain]' => home_url()
		];

		$defaults = wp_parse_args( BrizyPro_Config::getLicenseActivationData(), $defaults );
		$args     = wp_parse_args( $args, $defaults );

        if ( empty( $args['key'] ) ) {
	        throw new Exception( esc_html__( 'Please provide license key.', 'brizy-pro' ) );
        }

		$response = wp_remote_post( $url, [
			'timeout' => 60,
			'body'    => $args
		] );

		if ( is_wp_error( $response ) ) {
			throw new Exception( $response->get_error_message() );
		}

		$responseCode = wp_remote_retrieve_response_code( $response );
		if ( 200 !== (int) $responseCode ) {
			throw new Exception( sprintf( esc_html__( 'The remote server response code is %s.', 'brizy-pro' ), $responseCode ) );
		}

		$data = json_decode( wp_remote_retrieve_body( $response ), true );
		if ( empty( $data ) || ! is_array( $data ) ) {
            if ( $jsonLastError = json_last_error() ) {
	            throw new Exception( sprintf( esc_html__( 'An error occurred on json decode response. The json last error is: %s', 'brizy-pro' ), $jsonLastError ) );
            } else {
	            throw new Exception( esc_html__( 'Empty body was returned by the remote server.', 'brizy-pro' ) );
            }
		}

        if ( empty( $data['code'] ) ) {
	        throw new Exception( esc_html__( 'The response of the remote server has an unexpected format', 'brizy-pro' ) );
        }

		return $data;
	}

	public function apiResponseNotice() {

        if ( ! is_main_site() && ! is_network_admin() ) {
            return;
        }

		// If no license skip this, an admin notice of no license will throw noLicenseNotice
		if ( ! $this->getCurrentLicense() ) {
			return;
		}

		$lastCheck = BrizyPro_Admin_Updater::_init()->get_cached_version_info();

		if ( ! is_wp_error( $lastCheck ) && ! empty( $lastCheck['error']['message'] ) ) {
			printf(
				'<div class="%1$s"><p>%2$s: %3$s</p></div>',
				'notice notice-error',
				BrizyPro_Admin_WhiteLabel::_init()->gettext_domain( 'Brizy Pro', 'Brizy Pro' ),
				$lastCheck['error']['message']
			);
		}
	}

    public function changeLicenseNetworkNotice() {

        //delete_user_meta(get_current_user_id(), 'wl-disable-notice');
	    if ( ! is_network_admin() || get_user_meta( get_current_user_id(), 'wl-disable-notice', true ) ) {
		    return;
	    }

	    if ( ! empty( $_GET['wl-disable-notice'] ) && wp_verify_nonce( $_GET['wl-disable-notice'], 'brizy-disable-license-notice' ) ) {
		    add_user_meta( get_current_user_id(), 'wl-disable-notice', true );
		    return;
	    }

	    $disableUrl = add_query_arg( [ 'wl-disable-notice' => wp_create_nonce( 'brizy-disable-license-notice' ) ], network_admin_url() );

	    printf(
		    '<div class="%1$s"><p>%2$s: %3$s</p><a href="' . $disableUrl . '"><button type="button" class="notice-dismiss"></button></a></div>',
		    'notice notice-error is-dismissible',
		    BrizyPro_Admin_WhiteLabel::_init()->gettext_domain( 'Brizy Pro', 'Brizy Pro' ),
		    'New license updates. <a href="https://support.brizy.io/hc/en-us/articles/15941335839121-How-are-the-white-label-options-working-in-a-WordPress-multisite-network" target="_blank">More details.</a>'
	    );
	}

    public function networkActivateNotice() {

        if ( ! is_multisite() || is_plugin_active_for_network( BRIZY_PRO_PLUGIN_BASE ) ) {
            return;
        }

        printf(
            '<div class="%1$s"><p>%2$s: %3$s</p></div>',
            'notice notice-error',
            BrizyPro_Admin_WhiteLabel::_init()->gettext_domain( 'Brizy Pro', 'Brizy Pro' ),
            __( 'On a multisite installation the plugin must be network activated!', 'brizy-pro' )
        );
    }

	public function isValidLicense()
    {
    	return true;
		$license = $this->getCurrentLicense();

	    if ( empty( $license['key'] ) ) {
		    return false;
	    }

	    $lastCheck = BrizyPro_Admin_Updater::_init()->get_cached_version_info();

	    if ( ! is_wp_error( $lastCheck ) && ! empty( $lastCheck['error']['message'] ) ) {
		    return false;
	    }

        return true;
    }
}
