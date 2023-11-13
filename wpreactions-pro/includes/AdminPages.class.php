<?php
namespace WPRA;
use WPRA\Helpers\Utils;

class AdminPages {

	public function __construct() {
		add_action( 'admin_menu', [$this, 'add_admin_menu'] );
	}

	public static function init() {
		return new self();
	}

	function add_admin_menu() {

        $icon_file = WPRA_PLUGIN_PATH . 'assets/images/admin_menu_icon.svg';
        $handle = fopen($icon_file, "r");
        $icon_svg = fread($handle, filesize($icon_file));
        fclose($handle);

        $icon_encoded = base64_encode($icon_svg);

		add_menu_page(
			'WP Reactions - Dashboard',
			'WP Reactions',
			'access_wpreactions',
			'wpra-dashboard',
			[$this, 'dashboard_page_html'],
            'data:image/svg+xml;base64,' . $icon_encoded
		);

		add_submenu_page(
			'wpra-dashboard',
			'WP Reactions - Dashboard',
			'Dashboard',
			'access_wpreactions',
			'wpra-dashboard',
			[$this, 'dashboard_page_html']
		);

		add_submenu_page(
			'wpra-dashboard',
			'WP Reactions - Global Options',
			'Global Activation',
			'access_wpreactions',
			'wpra-global-options',
			[$this, 'options_page_html']
		);

		add_submenu_page(
			'wpra-dashboard',
			'WP Reactions - Shortcode Generator',
			'Shortcode Generator',
			'access_wpreactions',
			'wpra-shortcode-generator',
			[$this, 'shortcode_builder_html']
		);

        add_submenu_page(
            'wpra-dashboard',
            'WP Reactions - My Shortcodes',
            'My Shortcodes',
            'access_wpreactions',
            'wpra-my-shortcodes',
            [$this, 'my_shortcodes_html']
        );

		add_submenu_page(
			'wpra-dashboard',
			'WP Reactions - Analytics',
			'Analytics',
			'access_wpreactions',
			'wpra-analytics',
			[$this, 'analytics_html']
		);

        add_submenu_page(
            'wpra-dashboard',
            'WP Reactions - Settings',
            'Settings',
            'access_wpreactions',
            'wpra-settings',
            [$this, 'settings_html']
        );

		add_submenu_page(
			'wpra-dashboard',
			'WP Reactions - Tools',
			'Tools',
			'access_wpreactions',
			'wpra-tools',
			[$this, 'tools_html']
		);
	}

	function options_page_html() {
		if ( ! current_user_can( 'access_wpreactions' ) ) {
			return;
		}
		Utils::renderTemplate('view/admin/global-options');
	}

	function shortcode_builder_html() {
		if ( ! current_user_can( 'access_wpreactions' ) ) {
			return;
		}
		Utils::renderTemplate('view/admin/shortcode-builder');
	}

    function my_shortcodes_html() {
        if ( ! current_user_can( 'access_wpreactions' ) ) {
            return;
        }
        Utils::renderTemplate('view/admin/my-shortcodes');
    }

    function settings_html() {
        if ( ! current_user_can( 'access_wpreactions' ) ) {
            return;
        }
        Utils::renderTemplate('view/admin/settings');
    }

	function analytics_html() {
		if ( ! current_user_can( 'access_wpreactions' ) ) {
			return;
		}
		Utils::renderTemplate('view/admin/analytics');
	}

	function tools_html() {
		if ( ! current_user_can( 'access_wpreactions' ) ) {
			return;
		}
		Utils::renderTemplate('view/admin/tools');
	}

	function dashboard_page_html() {
		if ( ! current_user_can( 'access_wpreactions' ) ) {
			return;
		}
		Utils::renderTemplate('view/admin/dashboard');
	}
} // end of class
