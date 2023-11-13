<?php
class Analytify_Pro_Blocks {

	private static $obj;

	/**
	 * Private constructor for singliton class.
	 * 
	 */
	private final function __construct() {

		$this->enqueue_scripts();
		$this->filters();
	}

	/**
	 * Create instance for class.
	 * 
	 */
	public static function get_instance() {

		if ( ! isset( self::$obj ) ) { 
			self::$obj = new Analytify_Pro_Blocks(); 
		} 
			
		return self::$obj; 
	} 

	/**
	 * Enqueue wp scripts.
	 * 
	 */
	private function enqueue_scripts() {

		add_action( 'enqueue_block_editor_assets', array( $this, 'enqueue_block_editor_assets_cb' ) );
	}

	/**
	 * Add Analytify's block category.
	 * 
	 */
	private function filters() {

		add_filter( 'block_categories_all', function ( $categories, $post ) {
			return array_merge(
				$categories,
				array(
					array(
						'slug' => 'analytify-pro-blocks',
						'title' => __( 'Analytify', 'wp-analytify-pro' ),
						'icon'	=> plugins_url( 'assets/css/analytify-shortcode-button.svg', dirname( __FILE__ ) )
					),
				)
			);
		}, 10, 2 );
	}  

	/**
	 * Add transpiled blocks scripts.
	 * 
	 */
	function enqueue_block_editor_assets_cb($screen) {
		
		global $current_screen;

		$allowed_posts_types = $GLOBALS['WP_ANALYTIFY']->settings->get_option( 'show_analytics_post_types_back_end', 'wp-analytify-admin', array() );

		// Prevent on post types that are not allowed.
		if ( ! in_array( $current_screen->post_type, $allowed_posts_types ) ) {
			return;
		}

		wp_enqueue_script(
			'analytify-blocks-editor',
			plugins_url( 'assets/js/blocks.js', dirname( __FILE__ ) ),
			array( 'wp-i18n', 'wp-element', 'wp-blocks', 'wp-components', 'wp-editor', 'wp-edit-post' ),
			ANALYTIFY_PRO_VERSION
		);

		wp_localize_script( 'analytify-blocks-editor', 'analytify_blocks_editor', array(
			'reporting_mod' => method_exists( 'WPANALYTIFY_Utils', 'get_ga_mode' ) && 'ga4' === WPANALYTIFY_Utils::get_ga_mode() ? 'ga4' : 'ga3',
		) );

		wp_enqueue_style(
			'analytify-blocks-editor',
			plugins_url( 'assets/css/blocks.css', dirname( __FILE__ ) ),
			null,
			ANALYTIFY_PRO_VERSION
		);
	}

}

// Create Analytify_Pro_Blocks Instance.
Analytify_Pro_Blocks::get_instance();