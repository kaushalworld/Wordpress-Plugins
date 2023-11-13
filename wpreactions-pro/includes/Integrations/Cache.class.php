<?php
/** @noinspection PhpFullyQualifiedNameUsageInspection */

namespace WPRA\Integrations;

class Cache {

	public function __construct() {
		add_action( 'wpreactions/user/react', [ $this, 'clear' ] );
		add_action( 'wpreactions/user/socialShare', [ $this, 'clear' ] );
	}

	static function init() {
		new self();
	}

	function clear( $data ) {
		$post_id = $data['bind_id'];

		if ( function_exists( 'wpfc_clear_post_cache_by_id' ) ) {
			// WP Fastest Cache
			wpfc_clear_post_cache_by_id( $post_id );
		} else if ( class_exists( '\LiteSpeed\Core' ) ) {
			// WP LiteSpeed Cache
			do_action( 'litespeed_purge_post', $post_id );
		} else if ( function_exists( 'rocket_clean_post' ) ) {
			// WP Rocket
			rocket_clean_post( $post_id );
		} else if ( function_exists( 'wpsc_delete_post_cache' ) ) {
			// WP Super Cache
			wpsc_delete_post_cache( $post_id );
		} else if ( function_exists( 'w3tc_flush_post' ) ) {
			// W3 Total Cache
			w3tc_flush_post( $post_id );
		} else if ( class_exists( '\WPO_Page_Cache' ) ) {
			// WP-Optimize
			\WPO_Page_Cache::delete_single_post_cache( $post_id );
		} else if ( class_exists( '\autoptimizeCache' ) ) {
			// Autoptimize
			\autoptimizeCache::clearall();
		} else if ( class_exists( '\SiteGround_Optimizer\Supercacher\Supercacher' ) ) {
			// SiteGround Optimizer
			global $siteground_optimizer_helper;
			if ( isset( $siteground_optimizer_helper->supercacher ) ) {
				$siteground_optimizer_helper->supercacher->purge_post_cache( $post_id );
			}
		}
	}
}