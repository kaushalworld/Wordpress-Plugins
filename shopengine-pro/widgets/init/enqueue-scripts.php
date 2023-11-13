<?php
namespace ShopEngine_Pro\Widgets\Init;

defined( 'ABSPATH' ) || exit;

class Enqueue_Scripts{

    public function __construct() {

        add_action( 'wp_enqueue_scripts', [$this, 'frontend_js']);
        add_action( 'wp_enqueue_scripts', [$this, 'frontend_css'], 99 );

        add_action( 'elementor/frontend/before_enqueue_scripts', [$this, 'elementor_js'] );
    }

    public function elementor_js() {
        wp_enqueue_script( 'shopengine-pro-elementor', \ShopEngine_Pro::widget_url() . 'init/assets/js/elementor.js',array( 'jquery', 'elementor-frontend' ), \ShopEngine_Pro::version(), true );
    }

    public function frontend_js() {
        if(is_admin()){
            return;
        }
        // your normal frontend js goes here
    }
    public function frontend_css() {
        if(!is_admin()){
            wp_enqueue_style( 'shopengine-widget-frontend-pro', \ShopEngine_Pro::widget_url() . 'init/assets/css/widget-styles-pro.css', ['shopengine-widget-frontend'], \ShopEngine_Pro::version() );
        };
    }
}
