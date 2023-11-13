<?php

namespace WPRA;

use WPRA\Helpers\NoticeContext;
use WPRA\Helpers\Notices;
use WPRA\Helpers\Utils;

class Addon {
	private $active_addons;
	private $enabled_addons;
	const pk_active_option = 'pk_active_addons'; // lm validated
	const pk_enabled_option = 'pk_enabled_addons'; // wp activated

	public function __construct() {
		$this->active_addons  = get_option( self::pk_active_option, [] );
		$this->enabled_addons = get_option( self::pk_enabled_option, [] );
	}

	static function instance() {
		return new self();
	}

	function is_allowed( $slug ) {
		return in_array( $slug, $this->getActive() );
	}

	function getActive() {
		return $this->active_addons;
	}

	function getEnabled() {
		return $this->enabled_addons;
	}

	static function getVersion($slug) {
		switch($slug) {
			case 'my-reactions-uploader':
				return defined('WPRA_MRU_VERSION') ? WPRA_MRU_VERSION : 0;
			default:
				return 0;
		}
	}

	function activateSome( $slugs ) {
		foreach ( $slugs as $slug ) {
			$this->activate( $slug );
		}
	}

	function activate( $slug ) {
		// if is not valid deactivate addon
		if ( ! $this->validate( $slug ) ) {
			$this->deactivate( $slug );

			return false;
		}

		$active_addons   = $this->getActive();
		$active_addons[] = $slug;
		update_option( self::pk_active_option, array_unique( $active_addons ) );

		return true;
	}

	function deactivate( $slug ) {
		$addons = $this->getActive();
		if ( empty( $addons ) ) return;

		$addons = array_filter( $addons, function ( $addon ) use ( $slug ) {
			return $addon != $slug;
		} );

		update_option( self::pk_active_option, $addons );
	}

	function enable( $slug ) {
		$enabled   = $this->getEnabled();
		$enabled[] = $slug;
		update_option( self::pk_enabled_option, array_unique( $enabled ) );
	}

	function disable( $slug ) {
		$addons = $this->getEnabled();
		if ( empty( $addons ) ) return;

		$addons = array_filter( $addons, function ( $addon ) use ( $slug ) {
			return $addon != $slug;
		} );

		update_option( self::pk_enabled_option, $addons );
	}

	function kill( $slug ) {
		$this->disable( $slug );
		$this->deactivate( $slug );
		if ( ! function_exists( 'deactivate_plugins' ) ) {
			require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
		}
		deactivate_plugins( "$slug/$slug.php" );
	}

	function onUninstall( $slug ) {
		$this->disable( $slug );
		$this->deactivate( $slug );
		$this->notify( $slug, 'remove' );
	}

	// validate addon and add proper error notices
	function validate( $slug ) {

		$api = $this->notify( $slug, 'add' );

		if ( is_wp_error( $api ) ) {
			Notices::add( 'addon_activation', 'error', NoticeContext::ALL, [
				'message' => __( 'Error occurred trying addon activation. Try again some time later!', 'wpreactions' ),
			] );

			return false;
		}

		if ( $api['response']['code'] != 200 ) {
			$body = json_decode( $api['body'], true );

			Notices::add( 'addon_activation', 'error', NoticeContext::ALL, [
				'message' => __( $body['error']['message'], 'wpreactions' ),
			] );

			return false;
		}

		return true;
	}

	function notify( $slug, $action, $ssl_verify = true ) {

		$license_data = array_merge(
			App::instance()->license()->get_stored_info(),
			[
				'addon_slug' => 'my-reactions-uploader',
				'action'     => $action,
			]
		);

		$resp = wp_remote_post( Config::LICENSE_NOTIFY_ADDON_USAGE,
			[
				'method'    => 'POST',
				'headers'   => [ 'Content-Type' => 'application/json; charset=utf-8' ],
				'body'      => json_encode( $license_data ),
				'sslverify' => $ssl_verify,
			]
		);

		// if there is any issue with ssl verification, send request without verification
		if ( $ssl_verify && Utils::sslIssueDetected( $resp ) ) {
			return $this->notify( $slug, $action, false );
		}

		return $resp;
	}
}