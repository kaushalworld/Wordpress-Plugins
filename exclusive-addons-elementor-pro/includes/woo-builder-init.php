<?php
namespace ExclusiveAddons\Pro\Includes\WooBuilder;

if ( ! defined( 'ABSPATH' ) ) exit;


/**
 * Handles logic for the site Header / Footer.
 *
 * @package Exclusive Addons
 * @since 2.1.0
 */

/**
 * Woo_Builder_Init
 */
class Woo_Builder_Init {
	/**
	 * Settings tab constant.
	 */
	const SETTINGS_TAB = 'woo_template_manager';

	/**
	 * Holds an array of posts.
	 *
	 * @var array $templates
	 * @since 2.1.0
	 */
	private static $templates = array();

	/**
	 * Instance of Elemenntor Frontend class.
	 *
	 * @var \Elementor\Frontend()
	 * @since 2.1.0
	 */
	private static $elementor_instance;

	public static $exad_woo_elementor_template = array();

	public static $woo_ele_template = array();

	/**
	 * Holds the post ID for header.
	 *
	 * @var int $single_product
	 * @since 2.1.0
	 */
	public static $single_product;

	/**
	 * Holds the post ID for footer.
	 *
	 * @var int $archive_product
	 * @since 2.1.0
	 */
	public static $archive_product;

	public static $templates_path;

	/**
	 * The woo ele template ID static return
	 *
	 * @var null
	 */
	public static $exad_woo_template_id = array();

	/**
	 * Initialize hooks.
	 *
	 * @since 2.1.0
	 * @return void
	 */
	public static function init() {

		if ( ! did_action( 'elementor/loaded' ) ) {
			return;
		}

		self::$templates_path = EXAD_PRO_PATH . 'templates/';

		self::$elementor_instance = \Elementor\Plugin::instance();

		self::init_hooks();
	}

	public static function init_hooks() {

		// In Editor Woocommerce frontend hooks before the Editor init.
		add_action( 'admin_action_elementor',  __CLASS__ . '::register_wc_hooks', 9 );
		add_action( 'after_setup_theme', __CLASS__ . '::after_setup_theme' );

		if ( 'yes' === get_option( 'exad_enable_single_product_page' ) ) {
			add_filter( 'wc_get_template_part', __CLASS__ . '::get_product_page_template', 99, 3 );
			add_filter( 'template_include', __CLASS__ . '::single_product_ele_template' , 102 );
			
			add_action( 'exad_woocommerce_product_content', __CLASS__ . '::get_product_content_elementor', 5 );
			add_action( 'exad_woocommerce_product_content', __CLASS__ . '::get_default_product_data', 10 );

			// Add meta boxes.
			add_action( 'add_meta_boxes',  __CLASS__ . '::add_metabox' );
			// Save Meta boxes.
			add_action( 'save_post', __CLASS__ . '::save_metabox' , 10, 2 );
		}
		
		//thank you page
		
		if ( 'yes' === get_option( 'exad_enable_thank_you_page' ) ) {
			add_filter( 'wc_get_template', __CLASS__ . '::get_thank_you_page_template', 99, 3 );
			add_action( 'exad_woocommerce_thankyou_content', __CLASS__ . '::get_thankyou_content_elementor', 5 );
			add_filter( 'template_include', __CLASS__ . '::thankyou_ele_template' , 102 );
		}

		//Custom shop page
	
		if ( 'yes' === get_option( 'exad_enable_shop_page' ) ) {
			add_action( 'template_redirect', __CLASS__ . '::product_archive_template', 999 );
			add_filter('template_include', __CLASS__ . '::redirect_product_archive_template' , 999 );
			add_action( 'exad_woocommerce_archive_product_content', __CLASS__ . '::archive_product_page_content' );
		}

	}

	
	/**
	 * WooCommerce hook.
	 *
	 * @since 1.3.3
	 * @access public
	 */
	public static function register_wc_hooks() {
		wc()->frontend_includes();
	}

	/**
     *  WooCommerce Support
     * @return [void]
     */
    public static function after_setup_theme() {
        if ( ! current_theme_supports('woocommerce') ) {
           
			add_theme_support( 'woocommerce' );
			add_theme_support( 'wc-product-gallery-zoom' );
			add_theme_support( 'wc-product-gallery-lightbox' );
			add_theme_support( 'wc-product-gallery-slider' );
		
        }
    }

	//Custom shop page start

	public static function product_archive_template() {
		$termobj = get_queried_object();
		$templatestatus = false;
		if ( is_shop() || ( is_tax('product_cat') && is_product_category() ) || ( is_tax('product_tag') && is_product_tag() ) ||( isset( $termobj->taxonomy ) && is_tax( $termobj->taxonomy ) && array_key_exists( $termobj->taxonomy, $get_all_taxonomies ) ) ) {
			global $post;
			if ( ! isset( self::$exad_woo_elementor_template[ $post->ID ] ) ) {
				$product_default = get_option( 'exad_wc_shop_id' );
				if ( ! empty( $product_default ) && 'default' !== $product_default ) {
					$templatestatus                               = true;
					self::$exad_woo_elementor_template[ $post->ID ] = true;
				}
			} else {
				$templatestatus = self::$exad_woo_elementor_template[ $post->ID ];
			}
		}
		return apply_filters( 'product_archive_template', $templatestatus );
	}

	public static function redirect_product_archive_template( $template ) {
		//$template_id = get_option( 'exad_wc_shop_id' );
		$template_id = self::product_archive_template();
		$templatefile   = array();
        $templatefile[] = 'woocommerce/archive-product/archive-product.php';
		
		if( is_post_type_archive( 'product' ) || is_page( wc_get_page_id( 'shop' ) ) || is_product_taxonomy() ){
			if( $template_id != '0' ){
				$template = locate_template( $templatefile );
				if ( ! $template || ( ! empty( $status_options['template_debug_mode'] ) && current_user_can( 'manage_options' ) ) ){
					$template = self::$templates_path . 'woocommerce/archive-product/archive-product.php';
					
				}
				// Get the template slug for the elementor template we are using.
				$template_slug = get_page_template_slug( $template_id );
				if ( 'elementor_header_footer' === $template_slug ) {
					$template = self::$templates_path . 'woocommerce/archive-product/archive-product-fullwidth.php';
				} elseif ( 'elementor_canvas' === $template_slug ) {
					$template = self::$templates_path . 'woocommerce/archive-product/archive-product-canvas.php';
				}
			}
		}

		return $template;
	}

	public static function archive_product_page_content( $post ) {
		$template_id = get_option( 'exad_wc_shop_id' );

		if ( self::product_archive_template() ) {
			
			echo self::$elementor_instance->frontend->get_builder_content_for_display( $template_id );
		} else {
			the_content();
		}
	}

	//Custom shop page end 

	//thank you page start
	public static function get_thank_you_page_template( $template, $template_name, $templates_path ) {
		$template_id = get_option( 'exad_wc_thank_you_id' );

		if ( $template_id != '0' && 'checkout/thankyou.php' === $template_name ) {
			$template = self::$templates_path . 'woocommerce/checkout/thankyou.php';
		}

		return $template;
	}

	/**
	 * Elementor Preview Content Data.
	 *
	 * @since 1.2.0
	 */

	public static function get_thankyou_content_elementor( $post ) {
		$template_id = get_option( 'exad_wc_thank_you_id' );
		if ( self::woo_custom_thankyou_template() ) {
			
			echo self::$elementor_instance->frontend->get_builder_content_for_display( $template_id );
		} else {
			the_content();
		}
	}

	/**
	 * Get Order ID to Thank You Page.
	 *
	 * @since 1.2.0
	 */

	public static function woo_custom_thankyou_template() {
		$templatestatus = false;
		if ( is_checkout() ) {
			global $post;
			if ( ! isset( self::$exad_woo_elementor_template[ $post->ID ] ) ) {
				$thank_you_default = get_option( 'exad_wc_thank_you_id' );
				if ( ! empty( $thank_you_default ) && 'default' !== $thank_you_default ) {
					$templatestatus                               = true;
					self::$exad_woo_elementor_template[ $post->ID ] = true;
				}
			} else {
				$templatestatus = self::$exad_woo_elementor_template[ $post->ID ];
			}
		}
		return apply_filters( 'woo_custom_thankyou_template', $templatestatus );
	}

	/**
	 * Changes template if elementor take over
	 *
	 * @param string $template path to template.
	 */
	public static function thankyou_ele_template( $template ) {
		$template_id = get_option( 'exad_wc_thank_you_id' );
		if ( is_embed() ) {
			return $template;
		}

		if ( is_checkout() ) {
			// Check if this is an elementor template.
			remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );
			// Get the template slug for the elementor template we are using.
			$template_slug = get_page_template_slug( $template_id );
			if ( 'elementor_header_footer' === $template_slug ) {
				$template = self::$templates_path . 'woocommerce/checkout/thank-you-fullwidth.php';
			} elseif ( 'elementor_canvas' === $template_slug ) {
				$template = self::$templates_path . 'woocommerce/checkout/thank-you-elementor-canvas.php';
			}
			
		}
		return $template;
	}

	//thank you page end 

	/**
	 * Get option for the plugin settings
	 */
	public static function get_default_single_setting() {
		$value = null;
		// Get all stored values.
		$stored = get_option( 'exad_wc_single_product_id', null );
		// Check if value exists in stored values array.
		if ( ! empty( $stored ) ) {
			$value = $stored;
		}

		return apply_filters( 'get_default_single_setting', $value );
	}

	//single Product Page Settigs Start

	//meta box settings for single product page start
	/*
    * Elementor Templates List
    * return array
    */
    public static function get_woo_single_saved_template_id() {
        $templates = '';
        if( class_exists('\Elementor\Plugin') ){
            $templates = self::$elementor_instance->templates_manager->get_source( 'local' )->get_items();
        }
        $types = array();
        if ( empty( $templates ) ) {
            $template_lists = [ '0' => __( 'Do not Saved Templates.', 'exclusive-addons-elementor-pro' ) ];
        } else {
            $template_lists = [ 
								'0' 		=> __( 'Select Template', 'exclusive-addons-elementor-pro' ),
								'default' 	=> __( 'Default', 'exclusive-addons-elementor-pro' )
		 					];
            foreach ( $templates as $template ) {
                $template_lists[ $template['template_id'] ] = $template['title'] . ' (' . $template['type'] . ')';
            }
        }
        return $template_lists;
    }

	/**
	 * Adds the meta box.
	 */
	public static function add_metabox() {
		add_meta_box(
			'exad-woo-single-product-template-meta',
			__( 'Product Template', 'exclusive-addons-elementor-pro' ),
			[
				__CLASS__ , 'render_metabox_for_single_product' 
			],
			'product',
			'side',
			'default'
		);
	}

	/**
	 * Renders the meta box.
	 *
	 * @param object $post the post object.
	 */
	public static function render_metabox_for_single_product( $post ) {
		// Add nonce for security and authentication.
		wp_nonce_field( 'exad_woo_single_nonce_action', 'exad_woo_single_nonce' );
		$output  = '<div class="kt_meta_boxes">';
		$output .= '<div class="kt_meta_box" style="padding: 10px 0 0; border-bottom:1px solid #e9e9e9;">';
		$output .= '<div>';
		$output .= '<label for="exad_woo_single_product_template" style="font-weight: 600;">' . esc_html__( 'Assign Product Template', 'exclusive-addons-elementor-pro' ) . '</label>';
		$output .= '</div>';
		$output .= '<div>';

		$option_values = self::get_woo_single_saved_template_id();
		
		$select_value  = get_post_meta( $post->ID, 'exad_woo_single_product_template', true );

		$output .= '<select name="exad_woo_single_product_template">';
		foreach ( $option_values as $key => $value ) {
			if ( $key == $select_value ) {
				$output .= '<option value="' . esc_attr( $key ) . '" selected>' . esc_attr( $value ) . '</option>';
			} else {
				$output .= '<option value="' . esc_attr( $key ) . '">' . esc_attr( $value ) . '</option>';
			}
		}
		$output .= '</select>';
		$output .= '</div>';
		$output .= '<div class="clearfixit" style="padding: 5px 0; clear:both;"></div>';
		$output .= '</div>';
		$output .= '</div>';
		
		echo $output;
	}

	//meta box settings for single product page end

	/**
	 * Returns single product Post ID.
	 *
	 * @since 1.2.0
	 * @return mixed
	 */
	public static function woo_custom_product_template() {
		$templatestatus = false;
		if ( is_product() ) {
			global $post;
			if ( ! isset( self::$exad_woo_elementor_template[ $post->ID ] ) ) {
				$single_product_default = self::get_default_single_setting();
				$custom_template        = get_post_meta( $post->ID, 'exad_woo_single_product_template', true );
				if ( ( isset( $custom_template ) && ! empty( $custom_template ) && 'default' !== $custom_template ) || ( ! empty( $single_product_default ) && isset( $single_product_default ) && 'default' !== $custom_template ) ) {
					$templatestatus                               = true;
					self::$exad_woo_elementor_template[ $post->ID ] = true;
				} else {
					self::$exad_woo_elementor_template[ $post->ID ] = false;
				}
			} else {
				$templatestatus = self::$exad_woo_elementor_template[ $post->ID ];
			}
		}
		return apply_filters( 'woo_custom_product_template', $templatestatus );
	}

	
	/**
	 * Checks if Woo Ele Builder using a template or the products editor
	 */
	public static function exad_woo_ele_product_template_enabled() {
		$status = false;
		if ( is_product() ) {
			global $post;
			if ( ! isset( self::$woo_ele_template[ $post->ID ] ) ) {
				$single_product_default = self::get_default_single_setting();
				$custom_template        = get_post_meta( $post->ID, 'exad_woo_single_product_template', true );
				if ( isset( $custom_template ) && ! empty( $custom_template ) && 'default' !== $custom_template && 'elementor' !== $custom_template ) {
					$status                              = true;
					self::$woo_ele_template[ $post->ID ] = true;
				} elseif ( isset( $custom_template ) && ! empty( $custom_template ) && 'elementor' === $custom_template ) {
					$status                              = false;
					self::$woo_ele_template[ $post->ID ] = false;
				} elseif ( ! empty( $single_product_default ) && 'default' !== $single_product_default ) {
					$status                              = true;
					self::$woo_ele_template[ $post->ID ] = true;
				}
			} else {
				$status = self::$woo_ele_template[ $post->ID ];
			}
		}
		return apply_filters( 'exad_woo_ele_product_template_enabled', $status );
	}

	public static function get_product_page_template( $template, $slug, $name ) {
		if ( 'content' === $slug && 'single-product' === $name ) {
			if ( self::woo_custom_product_template() ) {
				$template = self::$templates_path . 'woocommerce/single/single-product.php';
			}
		}
		return $template;
	}

	/**
	 * Gets the template id for the builder
	 */
	public static function get_exad_woo_ele_product_builder_id() {
		global $post;
		if ( ! isset( self::$exad_woo_template_id[ $post->ID ] ) ) {
			$template = get_post_meta( $post->ID, 'exad_woo_single_product_template', true );
			if ( isset( $template ) && ! empty( $template ) && 'default' !== $template && 'elementor' !== $template ) {
				$template_id = $template;
			} elseif ( isset( $template ) && ! empty( $template ) && 'default' !== $template && 'elementor' === $template ) {
				$template_id = $post->ID;
			} else {
				$template_id = self::get_default_single_setting();
			}
			self::$exad_woo_template_id[ $post->ID ] = $template_id;
		} else {
			$template_id = self::$exad_woo_template_id[ $post->ID ];
		}

		return apply_filters( 'get_exad_woo_ele_product_builder_id', $template_id );
	}

	/**
	 * Changes template if elementor take over
	 *
	 * @param string $template path to template.
	 */
	public static function single_product_ele_template( $template ) {
		
		if ( is_embed() ) {
			return $template;
		}

		if ( is_singular( 'product' ) ) {
			// Check if this is an elementor template.
			if ( self::woo_custom_product_template() ) {
				remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );
				// Get the template slug for the elementor template we are using.
				$template_slug = get_page_template_slug( self::get_exad_woo_ele_product_builder_id() );
				if ( 'elementor_header_footer' === $template_slug ) {
					$template = self::$templates_path . 'woocommerce/single/single-product-fullwidth.php';
				} elseif ( 'elementor_canvas' === $template_slug ) {
					$template = self::$templates_path . 'woocommerce/single/product-elementor-canvas.php';
				}
			}
		
		}
		return $template;
	}

	/**
	 * Get single product Data to Elementor Preview.
	 *
	 * @since 1.2.0
	 */

	public static function get_product_content_elementor( $post ) {
		if ( self::exad_woo_ele_product_template_enabled() ) {
			$template_id = self::get_exad_woo_ele_product_builder_id();

			echo self::$elementor_instance->frontend->get_builder_content_for_display( $template_id );
		} else {
			the_content();
		}
		
	}

	// product data
	/**
	 * generate single product Data.
	 *
	 * @since 1.2.0
	 */

	public static function get_default_product_data() {
		WC()->structured_data->generate_product_data();
	}

	/**
	 * Get templates.
	 *
	 * Get all pages and Elementor templates.
	 *
	 * @since 2.1.0
	 */
	public static function get_templates() {
		if ( ! empty( self::$templates ) ) {
			return self::$templates;
		}

		$args = array(
			'post_type'              => 'elementor_library',
			'post_status'            => 'publish',
			'orderby'                => 'title',
			'order'                  => 'ASC',
			'posts_per_page'         => '-1',
			'update_post_meta_cache' => false,
			'update_post_term_cache' => false,
		);

		$args['tax_query'] = array(
			array(
				'taxonomy' => 'elementor_library_type',
				'field'    => 'slug',
				'terms'    => array(
					'section',
					'widget',
					'page',
					'header',
					'footer',
				),
			),
		);

		$templates = get_posts( $args );

		self::$templates = array(
			'templates' => $templates,
		);

		return self::$templates;
	}

	/**
	 * Handles saving the meta box.
	 *
	 * @param int     $post_id Post ID.
	 * @param WP_Post $post    Post object.
	 * @return null
	 */
	public static function save_metabox( $post_id, $post ) {
		// Add nonce for security and authentication.
		$nonce_name   = isset( $_POST['exad_woo_single_nonce'] ) ? wp_unslash( $_POST['exad_woo_single_nonce'] ) : '';
		$nonce_action = 'exad_woo_single_nonce_action';

		// Check if nonce is set.
		if ( ! isset( $nonce_name ) ) {
			return;
		}

		// Check if nonce is valid.
		if ( ! wp_verify_nonce( $nonce_name, $nonce_action ) ) {
			return;
		}

		// Check if user has permissions to save data.
		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}

		// Check if not an autosave.
		if ( wp_is_post_autosave( $post_id ) ) {
			return;
		}

		// Check if not a revision.
		if ( wp_is_post_revision( $post_id ) ) {
			return;
		}
		if ( isset( $_POST['exad_woo_single_product_template'] ) ) {
			$exad_woo_single_product_template = sanitize_text_field( wp_unslash( $_POST['exad_woo_single_product_template'] ) );
			update_post_meta( $post_id, 'exad_woo_single_product_template', $exad_woo_single_product_template );
		}
	}

	//single Product Page Settigs End

}

// Initialize the class.
Woo_Builder_Init::init();