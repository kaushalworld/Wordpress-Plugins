<?php
/**
 * Entry point for the plugin. Checks if Elementor is installed and activated and loads it's own files and actions.
 */
namespace ExclusiveAddons\Pro\Includes;

use ExclusiveAddons\Pro\Includes\HeaderFooter\Target_Rules_Fields;

/**
 * Class Header_Footer
 */
class Header_Footer {

	/**
	 * Current theme template
	 *
	 * @var String
	 */
	public $template;

	/**
	 * Instance of Elemenntor Frontend class.
	 *
	 * @var \Elementor\Frontend()
	 */
	private static $elementor_instance;

	/**
	 * Instance of Admin
	 *
	 * @var Header_Footer
	 */
	private static $_instance = null;

	/**
	 * Instance of Header_Footer
	 *
	 * @return Header_Footer Instance of Header_Footer
	 */
	public static function instance() {
		if ( ! isset( self::$_instance ) ) :
			self::$_instance = new self();
		endif;

		return self::$_instance;
	}
	/**
	 * Constructor
	 */
	function __construct() {
		$this->template = get_template();

		if ( defined( 'ELEMENTOR_VERSION' ) && is_callable( 'Elementor\Plugin::instance' ) ) :
			self::$elementor_instance = \Elementor\Plugin::instance();

			$this->includes();

			if ( 'genesis' == $this->template ) :
				require_once EXAD_PRO_PATH . 'includes/header-footer/themes/genesis/class-exad-hf-genesis-compat.php';
			elseif ( 'astra' == $this->template ) :
				require_once EXAD_PRO_PATH . 'includes/header-footer/themes/astra/class-exad-hf-astra-compat.php';
			elseif ( 'generatepress' == $this->template ) :
				require_once EXAD_PRO_PATH . 'includes/header-footer/themes/generatepress/class-exad-hf-generatepress-compat.php';
			elseif ( 'oceanwp' == $this->template ) :
				require_once EXAD_PRO_PATH . 'includes/header-footer/themes/oceanwp/class-exad-hf-oceanwp-compat.php';
			elseif ( 'storefront' == $this->template ) :
				require_once EXAD_PRO_PATH . 'includes/header-footer/themes/storefront/class-exad-hf-storefront-compat.php';
			elseif ( 'hello-elementor' == $this->template ) :
				require_once EXAD_PRO_PATH . 'includes/header-footer/themes/hello-elementor/class-exad-hf-hello-elementor-compat.php';
			else :
				add_action( 'init', [ $this, 'setup_unsupported_theme' ] );
			endif;

			// Scripts and styles.
			add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_scripts' ] );

			add_action( 'admin_enqueue_scripts', [ $this, 'enqueue_admin_scripts' ] );

			add_filter( 'body_class', [ $this, 'body_class' ] );
			add_action( 'switch_theme', [ $this, 'reset_unsupported_theme_notice' ] );

			add_shortcode( 'exad_hf_template', [ $this, 'render_template' ] );

		endif;
	}

	/**
	 * Reset the Unsupported theme nnotice after a theme is switched.
	 *
	 * @return void
	 */
	public function reset_unsupported_theme_notice() {
		delete_user_meta( get_current_user_id(), 'unsupported-theme' );
	}

	/**
	 * Loads the globally required files for the plugin.
	 */
	public function includes() {

		// Load WPML & Polylang Compatibility if WPML is installed and activated.
		if ( defined( 'ICL_SITEPRESS_VERSION' ) || defined( 'POLYLANG_BASENAME' ) ) {
			require_once EXAD_PRO_PATH . 'includes/multilang-compatibility/class-multilang-compatibility.php';
		}

		require_once EXAD_PRO_PATH . 'includes/header-footer/class-exad-hf-admin.php';

		require_once EXAD_PRO_PATH . 'includes/header-footer/exad-hf-functions.php';

		// Load Target rules.
		require_once EXAD_PRO_PATH . 'includes/header-footer/class-exad-hf-target-rules-fields.php';
		// Setup upgrade routines.
		require_once EXAD_PRO_PATH . 'includes/header-footer/class-exad-hf-update.php';
	}

	/**
	 * Enqueue styles and scripts.
	 */
	public function enqueue_scripts() {
		wp_enqueue_style( 'exad-hf-style', EXAD_PRO_URL . 'assets/css/exad-header-footer.css', [], EXAD_PRO_PLUGIN_VERSION );

		if ( class_exists( '\Elementor\Plugin' ) ) :
			$elementor = \Elementor\Plugin::instance();
			$elementor->frontend->enqueue_styles();
		endif;

		if ( class_exists( '\ElementorPro\Plugin' ) ) :
			$elementor_pro = \ElementorPro\Plugin::instance();
			$elementor_pro->enqueue_styles();
		endif;

		if ( exad_header_enabled() ) :
			if ( class_exists( '\Elementor\Core\Files\CSS\Post' ) ) :
				$css_file = new \Elementor\Core\Files\CSS\Post( get_exad_header_id() );
			elseif ( class_exists( '\Elementor\Post_CSS_File' ) ) :
				$css_file = new \Elementor\Post_CSS_File( get_exad_header_id() );
			endif;

			$css_file->enqueue();
		endif;

		if ( exad_footer_enabled() ) :
			if ( class_exists( '\Elementor\Core\Files\CSS\Post' ) ) :
				$css_file = new \Elementor\Core\Files\CSS\Post( get_exad_footer_id() );
			elseif ( class_exists( '\Elementor\Post_CSS_File' ) ) :
				$css_file = new \Elementor\Post_CSS_File( get_exad_footer_id() );
			endif;

			$css_file->enqueue();
		endif;
	}

	/**
	 * Load admin styles on header footer elementor edit screen.
	 */
	public function enqueue_admin_scripts() {
		global $pagenow;
		$screen = get_current_screen();

		if ( ( 'exad-elementor-hf' == $screen->id && ( 'post.php' == $pagenow || 'post-new.php' == $pagenow ) ) || ( 'edit.php' == $pagenow && 'edit-exad-elementor-hf' == $screen->id ) ) :
			wp_enqueue_style( 'exad-hf-admin-style', EXAD_PRO_URL . 'admin/assets/header-footer/css/exad-hf-admin.css', [], EXAD_PRO_PLUGIN_VERSION );
			wp_enqueue_script( 'exad-hf-admin-script', EXAD_PRO_URL . 'admin/assets/header-footer/js/exad-hf-admin.js', [], EXAD_PRO_PLUGIN_VERSION );
		endif;
	}

	/**
	 * Adds classes to the body tag conditionally.
	 *
	 * @param  Array $classes array with class names for the body tag.
	 *
	 * @return Array          array with class names for the body tag.
	 */
	public function body_class( $classes ) {
		if ( exad_header_enabled() ) :
			$classes[] = 'exad-hf-header';
		endif;

		if ( exad_footer_enabled() ) :
			$classes[] = 'exad-hf-footer';
		endif;

		$classes[] = 'exad-hf-template-' . $this->template;
		$classes[] = 'exad-hf-stylesheet-' . get_stylesheet();

		return $classes;
	}

	/**
	 * Display Unsupported theme notice if the current theme does add support for 'exclusive-addons-elementor-pro'
	 *
	 */
	public function setup_unsupported_theme() {
		if ( ! current_theme_supports( 'exclusive-addons-elementor-pro' ) ) :
			require_once EXAD_PRO_PATH . 'includes/header-footer/themes/default/class-exad-default-compat.php';
		endif;
	}

	/**
	 * Prints the Header content.
	 */
	public static function get_header_content() {
		echo self::$elementor_instance->frontend->get_builder_content_for_display( get_exad_header_id() );
	}

	/**
	 * Prints the Footer content.
	 */
	public static function get_footer_content() {
		echo "<div class='footer-width-fixer'>";
			echo self::$elementor_instance->frontend->get_builder_content_for_display( get_exad_footer_id() );
		echo '</div>';
	}

	/**
	 * Get option for the plugin settings
	 *
	 * @param  mixed $setting Option name.
	 * @param  mixed $default Default value to be received if the option value is not stored in the option.
	 *
	 * @return mixed.
	 */
	public static function get_settings( $setting = '', $default = '' ) {
		if ( 'type_header' == $setting || 'type_footer' == $setting ) :
			$templates = self::get_template_id( $setting );

			$template = ! is_array( $templates ) ? $templates : $templates[0];

			$template = apply_filters( "exad_hf_get_settings_{$setting}", $template );

			return $template;
		endif;
	}

	/**
	 * Get header or footer template id based on the meta query.
	 *
	 * @param  String $type Type of the template header/footer.
	 *
	 * @return Mixed       Returns the header or footer template id if found, else returns string ''.
	 */
	public static function get_template_id( $type ) {
		$option = [
			'location'  => 'exad_hf_target_include_locations',
			'exclusion' => 'exad_hf_target_exclude_locations'
		];

		$exad_hf_templates = Target_Rules_Fields::get_instance()->get_posts_by_conditions( 'exad-elementor-hf', $option );

		foreach ( $exad_hf_templates as $template ) :
			if ( get_post_meta( absint( $template['id'] ), 'ehf_template_type', true ) === $type ) :
				return $template['id'];
			endif;
		endforeach;

		return '';
	}

	/**
	 * Callback to shortcode.
	 *
	 * @param array $atts attributes for shortcode.
	 */
	public function render_template( $atts ) {
		$atts = shortcode_atts(
			[
				'id' => '',
			],
			$atts,
			'exad_hf_template'
		);

		$id = ! empty( $atts['id'] ) ? apply_filters( 'exad_hf_render_template_id', intval( $atts['id'] ) ) : '';

		if ( empty( $id ) ) :
			return '';
		endif;

		if ( class_exists( '\Elementor\Core\Files\CSS\Post' ) ) :
			$css_file = new \Elementor\Core\Files\CSS\Post( $id );
		elseif ( class_exists( '\Elementor\Post_CSS_File' ) ) :
			// Load elementor styles.
			$css_file = new \Elementor\Post_CSS_File( $id );
		endif;
		$css_file->enqueue();

		return self::$elementor_instance->frontend->get_builder_content_for_display( $id );
	}

}