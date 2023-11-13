<?php
/**
 * 
 * Plugin Main Class
 * 
 * @package Exclusive Addons
 */

namespace ExclusiveAddons\Pro\Elementor;
use \ExclusiveAddons\Pro\Elementor\ProHelper;
use \ExclusiveAddons\ProElementor\Exad_WPML_Element_Compatibility;

use \Elementor\Plugin;

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Exclusive Addons for Elementor Class
 *
 * The main class that initiates and runs the plugin.
 *
 * @since 1.0.0
 */
final class Base {

    /**
     * Instance
     *
     * @since 1.0.0
     *
     * @access private
     * @static
     *
     * @var Base The single instance of the class.
     */
    private static $_instance = null;

    public $template_id = 0;

    /**
     * Instance
     *
     * Ensures only one instance of the class is loaded or can be loaded.
     *
     * @since 1.0.0
     *
     * @access public
     * @static
     *
     * @return Base An instance of the class.
     */
    public static function instance() {

        if ( is_null( self::$_instance ) ) {
            self::$_instance = new self();
        }
        return self::$_instance;

    }

    /**
     * Constructor
     *
     * @since 1.0.0
     *
     * @access public
     */
    public function __construct() {
        $this->includes();
        $this->register_hooks();
        $this->plugin_licensing();
        $this->exad_wpml_compatiblity()->init();
    }


    /**
     * 
     * Register necessary Hooks
     * 
     */
    public function register_hooks() {

        // Pro Activated
        add_filter( 'exad/pro_activated', '__return_true' );
        if ( is_admin() ) {
            // Plugin Settings URL
            add_filter( 'plugin_action_links_'.EXAD_PRO_PBNAME, [ $this, 'pro_plugin_settings_action' ] );
        }
        add_action( 'init', [ $this, 'i18n' ] );

        // Registering Elementor Widget Category for woo single
        if ( class_exists( 'woocommerce' ) ) {

            // Elementor Preview Action
            if ( ! empty( $_REQUEST['action'] ) && 'elementor' === $_REQUEST['action'] && is_admin() ) {
                add_action( 'admin_action_elementor', [ $this, 'wc_fontend_includes' ], 5 );
            } 
        }

         // ajax load more hook for product
         add_action( 'wp_ajax_ajax_product_pagination', [ __CLASS__, 'exad_ajax_product_pagination' ] );
         add_action( 'wp_ajax_nopriv_ajax_product_pagination', [ __CLASS__, 'exad_ajax_product_pagination' ] );

    }
        

    /**
     * 
     * Including necessary assets
     * @since 1.0.2
     */
    public function includes() {

        include_once EXAD_PRO_PATH . 'includes/plugin-licensing.php';
        include_once EXAD_PRO_PATH . 'includes/menu-walker-class.php';
        include_once EXAD_PRO_PATH . 'includes/helper-class.php';
        include_once EXAD_PRO_PATH . 'includes/login-class.php';
        include_once EXAD_PRO_PATH . 'includes/addons-manager-class.php';
        include_once EXAD_PRO_PATH . 'includes/assets-manager-class.php';
        include_once EXAD_PRO_PATH . 'includes/mailchimp-api.php';
        // include icon picker support for taxonomy 
        include_once EXAD_PRO_PATH . 'includes/taxonomy-iconpicker.php';
        include_once EXAD_PRO_PATH . 'includes/woo-add-cart-helper.php';
        include_once EXAD_PRO_PATH . 'includes/woo-helpers.php';

        include_once EXAD_PRO_PATH . 'includes/multilang-compatibility/class-elements-wpml-compatibility.php';

        if ( class_exists( 'woocommerce' ) ) {
            // woo single product widget
            include_once EXAD_PRO_PATH . 'includes/woo-builder-admin-settings.php';
            include_once EXAD_PRO_PATH . 'includes/woo-builder-init.php';
            include_once EXAD_PRO_PATH . 'includes/woo-preview-data.php';
            include_once EXAD_PRO_PATH . 'includes/woo-preview-init.php';
            include_once EXAD_PRO_PATH . 'includes/woo-quickview.php';
        }
    }

    /**
     * Plugin Licensing
     *
     * @since v1.0.0
     */
    public function plugin_licensing() {
        if (is_admin()) {
            // Setup the settings page and validation
            $licensing = new Exad_Licensing(
                EXAD_SL_ITEM_SLUG,
                EXAD_SL_ITEM_NAME,
                'exclusive-addons-elementor'
            );
        }
    }
    
        
    /**
     * Plugin Localization
     * 
     */
    public function i18n() {
        // Load Plugin textdomain
        load_plugin_textdomain( 'exclusive-addons-elementor-pro' );
    }


    /**
     * 
     * Add Plugin Action link for settings page
     */
    public function pro_plugin_settings_action( $links ) {
        $settings_link = sprintf( '<a href="admin.php?page=exad-settings">' . __( 'Settings', 'exclusive-addons-elementor-pro' ) . '</a>' );
        array_push( $links, $settings_link );
        return $links;
    }

    /**
     * 
     * Load WPML compatibility instance
     */
	public function exad_wpml_compatiblity() {
		return Exad_WPML_Element_Compatibility::get_instance();
	}

    /**
    * [wc_fontend_includes] Load WC Files in Editor Mode
    * @return [void]
    */
    public function wc_fontend_includes() {
        \WC()->frontend_includes();
        if ( is_null( \WC()->cart ) ) {
            global $woocommerce;
            $session_class = apply_filters( 'woocommerce_session_handler', 'WC_Session_Handler' );
            $woocommerce->session = new $session_class();
            $woocommerce->session->init();

            $woocommerce->cart     = new \WC_Cart();
            $woocommerce->customer = new \WC_Customer( get_current_user_id(), true );
        }
    }

    // Ajax Load More For Post Grid
    public static function exad_ajax_product_pagination() {
       
        $paged = $_POST['paged'];

        $settings = [];
        $settings['exad_woo_product_categories'] = $_POST['product_categories'];
        $settings['exad_woo_order_by'] = $_POST['order_by'];
        $settings['exad_woo_order'] = $_POST['order'];
        $settings['product_per_page'] = $_POST['per_page'];
        $settings['product_in_ids'] = $_POST['in_ids'];
        $settings['product_not_in_ids'] = $_POST['not_in_ids'];
        $settings['image_size_size'] = $_POST['image_size'];
        $settings['only_post_has_image'] = $_POST['only_post_has_image'];
        $settings['exad_woo_product_show_category'] = $_POST['show_category'];
        $settings['exad_woo_product_show_star_rating'] = $_POST['show_star_rating'];
        $settings['exad_woo_product_sell_in_percentage_tag_enable'] = $_POST['sell_in_percentage_tag_enable'];
        $settings['exad_woo_product_sale_tag_enable'] = $_POST['sale_tag_enable'];
        $settings['exad_woo_product_sold_out_tag_enable'] = $_POST['sold_out_tag_enable'];
        $settings['exad_woo_product_featured_tag_enable'] = $_POST['data_featured_tag_enable'];
        $settings['exad_woo_product_featured_tag_text'] = $_POST['featured_tag_text'];
        $settings['exad_woo_show_product_excerpt'] = $_POST['excerpt'];
        $settings['exad_woo_product_excerpt_length'] = $_POST['excerpt_length'];
     
        $cat_array = explode(" ", $_POST['product_categories'] );
        $exclude_array = explode(" ", $_POST['not_in_ids'] );
        $offset_value = $_POST['offset_value'];
        
        $post_args = array(
            'post_type'        => 'product',
            'posts_per_page'   => $_POST['per_page'],
            'post_status'      => 'publish',
            'orderby'          => $_POST['order_by'],
            'order'            => $_POST['order'],
            'suppress_filters' => false,
            'post__in'         => $_POST['in_ids'],
            'post__not_in'     => $exclude_array,
            'offset'           => (int)$_POST['offset_value'] + ( ( (int)$paged - 1 ) * (int)$_POST['per_page'] ),
        );

        // show only post has feature image
        if( $settings['only_post_has_image'] == 'yes' ){
            $post_args['meta_query'][] = array( 'key' => '_thumbnail_id');
        }

         // display products in category.
         if ( ! empty( $settings['exad_woo_product_categories'] ) ) {
            $post_args['tax_query'] = array(
                array(
                    'taxonomy' => 'product_cat',
                    'field'    => 'term_id',
                    'terms'    => $cat_array
                )
            );
        }

        $posts = new \WP_Query( $post_args );

        $result = '';
        
        while( $posts->have_posts() ) : $posts->the_post(); 
            ob_start();

            include EXAD_PRO_PATH . 'templates/woocommerce/template-parts/woo-product.php';
            $result .= ob_get_contents();
            ob_end_clean();

        endwhile;
        wp_reset_postdata();

        wp_send_json($result);
        wp_die();
    }


}