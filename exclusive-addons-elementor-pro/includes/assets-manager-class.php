<?php
namespace ExclusiveAddons\ProElementor;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use \ExclusiveAddons\Pro\Elementor\ProHelper;
use \ExclusiveAddons\Pro\Elementor\Addons_Manager;

class Assets_Manager {

	/**
	 * Initialize
	 */
	public static function init() {
        // Register dependency Scripts
        add_action( 'elementor/frontend/after_register_scripts', [ __CLASS__, 'pro_register_dependency_scripts' ], 20 );
        if ( Addons_Manager::$is_pro_activated_feature['cross-site-copy-paste'] ) {
            add_action( 'elementor/editor/after_enqueue_scripts', array( __CLASS__, 'enqueue_cross_site_cp_scripts' ), 15, 0 );
        }
        // Load Main script
        add_action( 'wp_enqueue_scripts', [ __CLASS__, 'pro_enqueue_scripts' ] );
    }

    /**
	 * Load required js on before enqueue widget JS.
	 *
	 * @since 1.24.0
	 */
	public static function enqueue_cross_site_cp_scripts() {

		wp_enqueue_script( 'exad-cross-site-cp-library', EXAD_PRO_ASSETS_URL . 'js/exad-cross-site-cp-library.min.js', [], EXAD_PRO_PLUGIN_VERSION, true );
		wp_enqueue_script( 'exad-cross-site-cp', EXAD_PRO_ASSETS_URL . 'js/exad-cross-site-cp.min.js', [ 'jquery', 'elementor-editor', 'exad-cross-site-cp-library' ], EXAD_PRO_PLUGIN_VERSION, true );

		wp_localize_script(
			'exad-cross-site-cp',
			'exad_cross_site',
			array(
				'ajaxURL'           => admin_url( 'admin-ajax.php' ),
				'cscp_nonce'             => wp_create_nonce( 'exad_process_import' ),
				'exad_widget_not_found'  => __( 'The plugin you are trying to paste the widget from is not available on this site.', 'exclusive-addons-elementor-pro' ),
				'exad_copy'          => __( 'Exclusive Copy', 'exclusive-addons-elementor-pro' ),
				'exad_paste'         => __( 'Exclusive Paste', 'exclusive-addons-elementor-pro' ),
				'exad_cross_site_api'  => 'https://fahim100.github.io/exad-cscp/index.html',
			)
		);

	}

    /**
    * Enqueue Plugin Styles and Scripts
    *
    */
    public static function pro_register_dependency_scripts() {

        if ( Addons_Manager::$is_pro_activated_feature['chart'] ) {
            // chart js
            wp_register_script( 'exad-chart', EXAD_PRO_ASSETS_URL . 'js/vendor/Chart.min.js', array( 'jquery' ), EXAD_PRO_PLUGIN_VERSION, true );
        }

        if ( Addons_Manager::$is_pro_activated_feature['cookie-consent'] ) {
            // cookie consent js
            wp_register_script( 'exad-cookie-consent', EXAD_PRO_ASSETS_URL . 'js/vendor/cookie-consent.min.js', array( 'jquery' ), EXAD_PRO_PLUGIN_VERSION, true );
        }

        if ( Addons_Manager::$is_pro_activated_feature['counter'] ) {
            // Conterup js and Waypoint combined
            wp_register_script( 'exad-counter', EXAD_PRO_ASSETS_URL . 'js/vendor/counterup-waypoint.min.js', array( 'jquery' ), EXAD_PRO_PLUGIN_VERSION, true );
        }

        if ( Addons_Manager::$is_pro_activated_feature['campaign'] ) {
            // jQuery Countdown Js
            wp_register_script( 'exad-countdown', EXAD_ASSETS_URL . 'vendor/js/jquery.countdown.min.js', array( 'jquery' ), EXAD_PRO_PLUGIN_VERSION, true );
        }

        if ( Addons_Manager::$is_pro_activated_feature['slider'] || Addons_Manager::$is_pro_activated_feature['post-slider'] ) {
            // slick slider slick animation
            wp_register_script( 'exad-slick-animation', EXAD_PRO_ASSETS_URL . 'js/vendor/slick-animation.min.js', array( 'jquery' ), EXAD_PRO_PLUGIN_VERSION, true );
            wp_register_script( 'exad-slick', EXAD_ASSETS_URL . 'vendor/js/slick.min.js', array( 'jquery' ), EXAD_PLUGIN_VERSION, true );
        }

        if ( Addons_Manager::$is_pro_activated_feature['image-carousel'] || Addons_Manager::$is_pro_activated_feature['instagram-feed'] || Addons_Manager::$is_pro_activated_feature['post-carousel'] || Addons_Manager::$is_pro_activated_feature['team-carousel'] || Addons_Manager::$is_pro_activated_feature['testimonial-carousel'] || Addons_Manager::$is_pro_activated_feature['woo-category'] || Addons_Manager::$is_pro_activated_feature['woo-products'] ) {
            wp_register_script( 'exad-slick', EXAD_ASSETS_URL . 'vendor/js/slick.min.js', array( 'jquery' ), EXAD_PLUGIN_VERSION, true );
        }

        if ( Addons_Manager::$is_pro_activated_feature['source-code'] ) {
            // prism js for source code
            wp_register_script( 'exad-prism', EXAD_PRO_ASSETS_URL . 'js/vendor/prism.min.js', array( 'jquery' ), EXAD_PRO_PLUGIN_VERSION, true );
        }

        if ( Addons_Manager::$is_pro_activated_feature['table'] ) {
            // table
            wp_register_script( 'exad-table-script', EXAD_PRO_ASSETS_URL . 'js/vendor/jquery.dataTables.min.js', array( 'jquery' ), EXAD_PRO_PLUGIN_VERSION, true );
        }

        if ( Addons_Manager::$is_pro_activated_feature['lottie-animation'] ) {
            wp_register_script( 'exad-lottie', EXAD_PRO_ASSETS_URL . 'js/vendor/lottie.min.js', array( 'jquery' ), EXAD_PRO_PLUGIN_VERSION, true );
        }

        if ( Addons_Manager::$is_pro_activated_feature['demo-previewer'] ) {
            // Demo Preview
            wp_register_script( 'exad-isotope-pro', EXAD_PRO_ASSETS_URL . 'js/vendor/isotop.min.js', array( 'jquery' ), EXAD_PRO_PLUGIN_VERSION, true );
            wp_register_script( 'exad-simple-load-more', EXAD_PRO_ASSETS_URL . 'js/vendor/simpleLoadMore.js', array( 'jquery' ), EXAD_PRO_PLUGIN_VERSION, true );
        }

        if ( Addons_Manager::$is_pro_activated_feature['instagram-feed'] ) {
            // Instafeed
            wp_register_script( 'exad-insta-feed', EXAD_PRO_ASSETS_URL . 'js/vendor/insta-feed.min.js', array( 'jquery' ), EXAD_PRO_PLUGIN_VERSION, true );
        }

        if ( Addons_Manager::$is_pro_activated_feature['floating-animation'] ) {
            // Floating Animation
            wp_register_script( 'exad-blob', EXAD_PRO_ASSETS_URL . 'js/vendor/anime.min.js', array( 'jquery' ), EXAD_PRO_PLUGIN_VERSION, true );
        }

        if ( Addons_Manager::$is_pro_activated_feature['navigation-menu'] ) {
            // navigation Menu
            wp_register_script( 'exad-slicknav', EXAD_PRO_ASSETS_URL . 'js/vendor/jquery.slicknav.min.js', array( 'jquery' ), EXAD_PRO_PLUGIN_VERSION, true );
        }

        if ( Addons_Manager::$is_pro_activated_feature['gravity-form'] ) {
            if ( class_exists( 'GFCommon' ) ) {
                foreach ( ProHelper::exad_get_gravity_forms() as $form_id => $form_title ) {
                    if ( $form_id && $form_id != '0' ) {
                        gravity_form_enqueue_scripts( $form_id );
                    }
                }
            }
        }

        if ( Addons_Manager::$is_pro_activated_feature['gradient-animation'] ) {
            wp_enqueue_script( 'exad-granim', EXAD_PRO_ASSETS_URL . 'js/vendor/granim.min.js', array( 'jquery' ), EXAD_PRO_PLUGIN_VERSION, true );
        }

        if ( Addons_Manager::$is_pro_activated_feature['section-parallax'] ) {
            // Parallax JS
            wp_enqueue_script( 'exad-parallax', EXAD_PRO_ASSETS_URL . 'js/vendor/parallax.min.js', array( 'jquery' ), EXAD_PRO_PLUGIN_VERSION, true );
        }
        if ( Addons_Manager::$is_pro_activated_feature['section-particles'] ) {    
            // Particles JS
            wp_enqueue_script( 'exad-particles', EXAD_PRO_ASSETS_URL . 'js/vendor/particles.min.js', array( 'jquery' ), EXAD_PRO_PLUGIN_VERSION, true );
        }
    }

    /**
     * Front end main script
     * 
     */
    public static function pro_enqueue_scripts() {
        // Main Plugin Styles
        wp_enqueue_style( 'exad-pro-main-style', EXAD_PRO_ASSETS_URL . 'css/exad-pro-styles.min.css' );
        if( is_rtl() ) {
            // Main Plugin RTL Styles
            wp_enqueue_style( 'exad-pro-rtl-style', EXAD_PRO_ASSETS_URL . 'css/exad-pro-rtl-styles.min.css' );            
        }
        // WOO quickview Scripts
        wp_enqueue_script( 'quickview-content-script', EXAD_PRO_ASSETS_URL . 'js/quickview-content.js', array( 'jquery', 'exad-main-script' ), EXAD_PRO_PLUGIN_VERSION, true );
        // Main Plugin Scripts
        wp_enqueue_script( 'exad-pro-main-script', EXAD_PRO_ASSETS_URL . 'js/exad-pro-scripts.min.js', array( 'jquery', 'exad-main-script' ), EXAD_PRO_PLUGIN_VERSION, true );

        wp_localize_script( 'exad-pro-main-script', 'exad_frontend_ajax_object',
            array( 
                'ajaxurl' => admin_url( 'admin-ajax.php' )
            ) 
        );

    }

}

Assets_Manager::init();
