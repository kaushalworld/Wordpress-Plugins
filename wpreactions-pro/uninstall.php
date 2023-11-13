<?php
// if uninstall.php is not called by WordPress, die
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	die;
}

$wpra_settings = json_decode( get_option( 'wpra_settings' ), true );
if ( $wpra_settings['purge_on_uninstallation'] == 1 ) {
	global $wpdb;

	// drop database tables
	$wpdb->query( "drop table if exists {$wpdb->prefix}wpreactions_reacted_users" );
	$wpdb->query( "drop table if exists {$wpdb->prefix}wpreactions_shortcodes" );
	$wpdb->query( "drop table if exists {$wpdb->prefix}wpreactions_social_stats" );
	$wpdb->query( "drop table if exists {$wpdb->prefix}wpreactions_emojis" );

	// delete options
	delete_option( 'wpra_options' );
	delete_option( 'wpra_settings' );
	delete_option( 'wpra_dismiss_lk_alert' );
	delete_option( 'wpra_version' );
	delete_option( 'wpra_db_version' );
	delete_option( 'wpra_options_regular' );
	delete_option( 'wpra_options_button_reveal' );
	delete_option( 'wpra_options_bimber' );
	delete_option( 'wpra_options_disqus' );
	delete_option( 'wpra_options_jane' );
	delete_option( 'wpra_layout' );
	delete_option( 'wpra_global_activation' );
	delete_option( 'pk_license_email' );
	delete_option( 'pk_license_key' );
	delete_option( 'pk_license_last_checked' );
	delete_option( 'pk_license_checked' );
	delete_option( 'pk_active_addons' );
	delete_option( 'pk_enabled_addons' );

	// delete post metas
	delete_post_meta_by_key('_wpra_start_counts');
	delete_post_meta_by_key('_wpra_show_emojis');

	// remove updates checker cron
	wp_clear_scheduled_hook( 'wpra_check_updates' );
	wp_clear_scheduled_hook( 'wpra_clear_logs' );

	//remove caps
	$role = get_role( 'administrator' );
	if ( $role !== null ) {
		$role->remove_cap( 'access_wpreactions' );
		$role->remove_cap( 'edit_wpreactions' );
	}
}
