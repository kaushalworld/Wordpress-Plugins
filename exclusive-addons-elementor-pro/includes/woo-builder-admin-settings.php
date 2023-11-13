<?php
namespace ExclusiveAddons\Pro\Includes\WooBuilder;

if ( ! defined( 'ABSPATH' ) ) exit;

use \ExclusiveAddons\Pro\Elementor\Helper;


class Woo_Builder_Admin_Settings {

    /* Bootstraps the class and hooks required actions & filters.
     *
     */
    public static function init() {
        add_filter( 'woocommerce_settings_tabs_array', __CLASS__ . '::add_settings_tab', 50 );
        add_action( 'woocommerce_settings_tabs_settings_tab_demo', __CLASS__ . '::settings_tab' );
        add_action( 'woocommerce_update_options_settings_tab_demo', __CLASS__ . '::update_settings' );
    }
    
    
    /* Add a new settings tab to the WooCommerce settings tabs array.
     *
     * @param array $settings_tabs Array of WooCommerce setting tabs & their labels, excluding the Subscription tab.
     * @return array $settings_tabs Array of WooCommerce setting tabs & their labels, including the Subscription tab.
     */
    public static function add_settings_tab( $settings_tabs ) {
        $settings_tabs['settings_tab_demo'] = __( 'Exclusive Woo Builder', 'exclusive-addons-elementor-pro' );
        return $settings_tabs;
    }


    /* Uses the WooCommerce admin fields API to output settings via the @see woocommerce_admin_fields() function.
     *
     * @uses woocommerce_admin_fields()
     * @uses self::get_settings()
     */
    public static function settings_tab() {
        woocommerce_admin_fields( self::get_settings() );
    }


    /* Uses the WooCommerce options API to save settings via the @see woocommerce_update_options() function.
     *
     * @uses woocommerce_update_options()
     * @uses self::get_settings()
     */
    public static function update_settings() {
        woocommerce_update_options( self::get_settings() );
    }

    /*
    * Elementor Templates List
    * return array
    */
    public static function get_woo_saved_template() {
        $templates = '';
        if( class_exists('\Elementor\Plugin') ){
            $templates = \Elementor\Plugin::instance()->templates_manager->get_source( 'local' )->get_items();
        }
        $types = array();
        if ( empty( $templates ) ) {
            $template_lists = [ '0' => __( 'Do not Saved Templates.', 'exclusive-addons-elementor-pro' ) ];
        } else {
            $template_lists = [ '0' => __( 'Select Template', 'exclusive-addons-elementor-pro' ) ];
            foreach ( $templates as $template ) {
                $template_lists[ $template['template_id'] ] = $template['title'] . ' (' . $template['type'] . ')';
            }
        }
        return $template_lists;
    }


    /* Get all the settings for this plugin for @see woocommerce_admin_fields() function.
     *
     * @return array Array of settings for @see woocommerce_admin_fields() function.
     */
    public static function get_settings() {

        $settings = array(

            'exad_section_title' => array(
				'name'     => __( 'Exad Woo Builder', 'exclusive-addons-elementor-pro' ),
				'type'     => 'title',
                'desc'     => __( 'Buid Woocommerce Template in Elementor', 'exclusive-addons-elementor-pro' ),
				'id'       => 'exad_woo_builder_title'
			),
            'exad_section_shop_title' => array(
				'name'     => __( 'Shop Page', 'exclusive-addons-elementor-pro' ),
				'type'     => 'title',
				'id'       => 'exad_woo_shop_title'
			),
            'exad-settings-enable_shop' => array(
				'name'      => __( 'Enable Product Shop Page', 'exclusive-addons-elementor-pro' ),
				'desc'      => __( 'Enable custom shop page', 'exclusive-addons-elementor-pro' ),
				'id'        => 'exad_enable_shop_page',
				'default'   => '',
				'type'      => 'checkbox',
			),
            'exad-settings-shop' => array(
                'name'    => __('Product Shop Page', 'exclusive-addons-elementor-pro' ),
                'desc'    => __( 'You can select a custom template for the product Shop page layout', 'exclusive-addons-elementor-pro' ),
                'type'    => 'select',
                'default' => '0',
                'class'   => 'wc-enhanced-select',
                'options' => self::get_woo_saved_template(),
                'id' => 'exad_wc_shop_id'
            ),  
            'exad-settings-shop-end' => array(
                'type' => 'sectionend',
                'id'   => 'exad_section_shop_end',
            ),
            'exad_section_single_title' => array(
				'name'     => __( 'Single Product Page', 'exclusive-addons-elementor-pro' ),
				'type'     => 'title',
				'id'       => 'exad_woo_single_title'
			),   
            'exad-settings-enable-single-page' => array(
				'name'      => __( 'Enable Single Product Page', 'exclusive-addons-elementor-pro' ),
				'desc'      => __( 'Enable Single Product Page', 'exclusive-addons-elementor-pro' ),
				'id'        => 'exad_enable_single_product_page',
				'default'   => '',
				'type'      => 'checkbox',
			),
            'settings-title' => array(
                'name'    => __('Single Product Page', 'exclusive-addons-elementor-pro' ),
                'desc'    => __( 'You can select a custom template for the product details page layout', 'exclusive-addons-elementor-pro' ),
                'type'    => 'select',
                'default' => '0',
                'class'   => 'wc-enhanced-select',
                'options' => self::get_woo_saved_template(),
                'id' => 'exad_wc_single_product_id'
            ),  
            'exad-settings-single-end' => array(
                'type' => 'sectionend',
                'id'   => 'exad_section_single_end',
            ),
            'exad_section_thank_you_title' => array(
				'name'     => __( 'Thank You Page', 'exclusive-addons-elementor-pro' ),
				'type'     => 'title',
				'id'       => 'exad_woo_thank_you_title'
			),
            'exad-settings-enable-thank-you-page' => array(
				'name'      => __( 'Enable Thank You Page', 'exclusive-addons-elementor-pro' ),
				'desc'      => __( 'Enable Thank You Page', 'exclusive-addons-elementor-pro' ),
				'id'        => 'exad_enable_thank_you_page',
				'default'   => '',
				'type'      => 'checkbox',
			),
            'settings-thank-you' => array(
                'name'    => __('Thank You Page', 'exclusive-addons-elementor-pro' ),
                'desc'    => __( 'You can select a custom template for the Thank You page layout', 'exclusive-addons-elementor-pro' ),
                'type'    => 'select',
                'default' => '0',
                'class'   => 'wc-enhanced-select',
                'options' => self::get_woo_saved_template(),
                'id' => 'exad_wc_thank_you_id'
            ),
            'exad_section_end' => array(
				'type' => 'sectionend',
				'id'   => 'exad_woo_builder_section_end'
			),
            
        );

        return apply_filters( 'wc_settings_tab_demo_settings', $settings );
    }

}

Woo_Builder_Admin_Settings::init();