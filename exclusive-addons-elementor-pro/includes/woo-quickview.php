<?php
namespace ExclusiveAddons\Pro\Includes\WooBuilder;

if ( ! defined( 'ABSPATH' ) ) exit;

use \Elementor\Plugin;
use Elementor\Element_Base;
use Elementor\Controls_Manager;
use ExclusiveAddons\Elements\Woo_Products;

/**
* Woo_Quickview_Data
*/
class Woo_Quickview_Data {

    /**
     * [$instance]
     * @var null
     */
    private static $instance   = null;

    /**
     * [$product_id]
     * @var null
     */
    private static $product_id = null;

    /**
     * [instance] Initializes a singleton instance
     * @return [Assets_Management]
     */
    public static function instance() {
        if ( is_null( self::$instance ) ) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * [__construct] Class Constructor
     */
    public function __construct(){
        add_action( 'init', [ $this, 'init'] );
        //add_action( 'elementor/element/exad-woo-products/exad_woo_product_quick_view_content_section_style/before_section_end', [ $this, 'quickview_control_fields' ], 10, 2 );
       // add_action( 'elementor/widget/before_render_content', [ $this, 'exad_quick_view_render' ] );
        // Ajax For Quickview Product
        add_action( 'wp_ajax_exad_quickview', [ __CLASS__, 'wc_quickview' ] );
        add_action( 'wp_ajax_nopriv_exad_quickview', [ __CLASS__, 'wc_quickview' ] );

        add_action( 'wp_footer', [ $this, 'quick_view_html'] );
        add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_scripts' ] );

    }

    /**
     * Adding QuickView fields
     * @param \Elementor\Widget_Base $QuickView
     * @param array                  $args
     */
    public function quickview_control_fields( $element, $args ) {

        $element->add_control( 'exad_woo_product_quickview_type',
            [
            'label' => __( 'QuickView Layout', 'exclusive-addons-elementor-pro' ),
            'type' => Controls_Manager::SELECT,
            'default' => 'none',
            'options'     => [
                'none'              => __( 'None', 'exclusive-addons-elementor-pro' ),
                'default-template'  => __( 'Defualt Template', 'exclusive-addons-elementor-pro' ),
                'custom-template'   => __( 'Elementor Template', 'exclusive-addons-elementor-pro' ),
            ],
            ]
        );

        $element->add_control(
            'exad_woo_product_quickview_type_elementor_template',
            [
                'label'     => __( 'Select Template', 'exclusive-addons-elementor-pro' ),
                'type'      => Controls_Manager::SELECT,
				'label_block' => true,
                'options'   => $this->get_saved_template( ['page', 'section'] ),
                'default'   => '-1',
               
            ]
        );
    }

    
    /**
	 *  Get Saved Widgets
	 *
	 *  @param string $type Type.
	 *  @since 0.0.1
	 *  @return string
	 */
	public function get_saved_template( $type = 'page' ) {

		$saved_widgets = $this->get_template( $type );
		$options[-1]   = __( 'Select', 'exclusive-addons-elementor-pro' );
		if ( count( $saved_widgets ) ) :
			foreach ( $saved_widgets as $saved_row ) :
				$options[ $saved_row['id'] ] = $saved_row['name']. ' ( Template )';
			endforeach;
		else :
			$options['no_template'] = __( 'No section template is added.', 'exclusive-addons-elementor-pro' );
		endif;
		return $options;
	}

    	/**
	 *  Get Templates based on category
	 *
	 *  @param string $type Type.
	 *  @since 0.0.1
	 *  @return string
	 */
	public function get_template( $type = 'page' ) {
		$posts = get_posts(
			array(
				'post_type'        => 'elementor_library',
				'orderby'          => 'title',
				'order'            => 'ASC',
				'posts_per_page'   => '-1',
				'tax_query'        => array(
					array(
						'taxonomy' => 'elementor_library_type',
						'field'    => 'slug',
						'terms'    => $type
					)
				)
			)
		);

		$templates = array();

		foreach ( $posts as $post ) :
			$templates[] = array(
				'id'   => $post->ID,
				'name' => $post->post_title
			);
		endforeach;
        
		return $templates;
	}

    /**
     * [init] Initialize Function
     * @return [void]
     */
    public function init(){
        add_filter( 'body_class', [ $this, 'body_class' ] );
        add_filter( 'post_class', [ $this, 'post_class' ] );
    }

    /**
     * [body_class] Body Classes
     * @param  [type] $classes String
     * @return [void] 
     */
    public function body_class( $classes ){
        $post_type = get_post_type();
        if( $post_type == 'elementor_library' ){
            $classes[] = 'woocommerce';
            $classes[] = 'woocommerce-page';
            $classes[] = 'exad-woocommerce-builder';
            $classes[] = 'single-product';
        }
        return $classes;
    }

    /**
     * [post_class] Post Classes
     * @param  [type] $classes String
     * @return [void]
     */
    public function post_class( $classes ){
        $post_type = get_post_type();
        if( $post_type == 'elementor_library' ){
            $classes[] = 'product';
        }
        return $classes;
    }

    // Open Quick view Ajax Callback
    public static function wc_quickview( ) {
        
        if ( isset( $_POST['id'] ) && (int) $_POST['id'] ) {
            global $post, $product, $woocommerce;
            $id      = ( int ) $_POST['id'];
            $post    = get_post( $id );
            $product = get_product( $id );
           
            if ( $product ) {

                include EXAD_PRO_PATH . 'templates/woocommerce/quickview-content/quickview-content.php';
                
            }
        }
        wp_die();

    }

    // Quick View Markup
    public function quick_view_html(){
        echo '<div class="woocommerce" id="exad-viewmodal"><div class="exad-modal-quickview-dialog product"><div class="exad-modal-quickview-contentt"><button type="button" class="exad-close-btn"><span class="eicon-editor-close"></span></button><div class="exad-modal-quickview-body"></div></div></div></div>';
    }

   // Quick View Markup
   public function exad_quick_view_render( $element ){
    if( 'exad-woo-products' === $element->get_name() ) {
        // Get the settings
        $settings = $element->get_settings(); 
        if($settings['exad_woo_product_quickview_type'] == 'custom-template') {
            $element->add_render_attribute( 'exad_woo_product_grid_wrapper', 'data-quickview-tmp-id', $settings['exad_woo_product_quickview_type_elementor_template'] );
        } else {
            $element->add_render_attribute( 'exad_woo_product_grid_wrapper', 'data-quickview-tmp-id', -1 );
        }

    }
   }

   public function enqueue_scripts() {
    // In preview mode it's not a real Product page - enqueue manually.

        global $product;

        if ( is_singular( 'product' ) ) {
            $product = wc_get_product();
        }

        if ( current_theme_supports( 'wc-product-gallery-zoom' ) ) {
            wp_enqueue_script( 'zoom' );
        }
        if ( current_theme_supports( 'wc-product-gallery-slider' ) ) {
            wp_enqueue_script( 'flexslider' );
        }
        if ( current_theme_supports( 'wc-product-gallery-lightbox' ) ) {
            wp_enqueue_script( 'photoswipe-ui-default' );
            wp_enqueue_style( 'photoswipe-default-skin' );
            add_action( 'wp_footer', 'woocommerce_photoswipe' );
        }
        wp_enqueue_script( 'wc-single-product' );

        wp_enqueue_style( 'photoswipe' );
        wp_enqueue_style( 'photoswipe-default-skin' );
        wp_enqueue_style( 'photoswipe-default-skin' );
        wp_enqueue_style( 'woocommerce_prettyPhoto_css' );

    }
    
}
Woo_Quickview_Data::instance();