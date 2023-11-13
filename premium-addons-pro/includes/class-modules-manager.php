<?php
/**
 * PAPRO Manager.
 */

namespace PremiumAddonsPro\Includes;

use PremiumAddonsPro\Base\Module_Base;
use Elementor\Utils;
use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Image_Size;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Class Manager.
 */
final class Manager {

	/**
	 * Modules
	 *
	 * @var modules
	 */
	private $modules = array();

	/**
	 * Require Files.
	 *
	 * @since 1.6.1
	 * @access public
	 *
	 * @return void
	 */
	public function require_files() {
		require PREMIUM_PRO_ADDONS_PATH . 'base/module-base.php';
	}

	/**
	 * Register Modules.
	 *
	 * @since 1.6.1
	 * @access public
	 *
	 * @return void
	 */
	public function register_modules() {

		$modules = array(
			'premium-section-parallax',
			'premium-section-particles',
			'premium-section-gradient',
			'premium-section-kenburns',
			'premium-section-lottie',
			'premium-section-blob',
			'premium-global-cursor',
			'premium-global-badge',
			'premium-global-mscroll',
		);

		foreach ( $modules as $module_name ) {
			$class_name = str_replace( '-', ' ', $module_name );

			$class_name = str_replace( ' ', '', ucwords( $class_name ) );

			$class_name = 'PremiumAddonsPro\\Modules\\' . $class_name . '\Module';

			if ( $class_name::is_active() ) {
				$this->modules[ $module_name ] = $class_name::instance();
			}
		}

	}

	/**
	 * Run Modules Extender
	 *
	 * Extendes the free modules with extra options
	 *
	 * @since 2.6.0
	 * @access public
	 */
	public function run_modules_extender() {

		add_filter( 'papro_activated', '__return_true' );

		add_action( 'pa_floating_opacity_controls', array( $this, 'add_opacity_controls' ) );
		add_action( 'pa_floating_bg_controls', array( $this, 'add_bg_controls' ) );

		add_action( 'pa_floating_blur_controls', array( $this, 'add_blur_controls' ) );
		add_action( 'pa_floating_contrast_controls', array( $this, 'add_contrast_controls' ) );
		add_action( 'pa_floating_gs_controls', array( $this, 'add_gs_controls' ) );
		add_action( 'pa_floating_hue_controls', array( $this, 'add_hue_controls' ) );
		add_action( 'pa_floating_brightness_controls', array( $this, 'add_brightness_controls' ) );
		add_action( 'pa_floating_saturation_controls', array( $this, 'add_saturation_controls' ) );

		add_action( 'pa_custom_menu_controls', array( $this, 'add_custom_menu_controls' ), 10, 2 );

		// Extend Display Conditions Module.
		add_filter( 'pa_display_conditions', array( $this, 'extend_display_conditions_options' ) );
		add_filter( 'pa_display_conditions_keys', array( $this, 'extend_display_conditions_keys' ) );
		add_filter( 'pa_pro_display_conditions', array( $this, 'extend_pro_display_conditions' ) );

		// Extend Woo Product Listings Skins.
		add_filter( 'pa_pro_label', array( $this, 'extend_woo_skins' ) );

		// Extend Mega Menu - Random Badges.
		add_action( 'pa_rn_badges_controls', array( $this, 'add_random_badges_controls' ), 10, 2 );
		add_filter( 'pa_get_random_badges_settings', array( $this, 'get_random_badges_settings' ), 10 );

		// Extend Google Maps - Advanced Marker.
		add_action( 'pa_maps_marker_controls', array( $this, 'add_maps_marker_controls' ) );

		// Extend Terms Cloud widget controls.
		add_filter( 'pa_tcloud_layouts', array( $this, 'pa_tcloud_layouts' ) );
		add_action( 'pa_tcloud_shape_controls', array( $this, 'add_tcloud_shape_controls' ) );
		add_action( 'pa_tcloud_sphere_controls', array( $this, 'add_tcloud_sphere_controls' ) );

		// Extend Recent Posts Notification widget controls.
		add_filter( 'pa_notification_options', array( $this, 'pa_notification_options' ) );
		add_action( 'pa_notification_cats_controls', array( $this, 'add_notification_cats_controls' ) );

		// Extend World Clock widget controls.
		add_filter( 'pa_clock_options', array( $this, 'pa_clock_options' ) );

		// Extend News Ticker widget controls.
		add_filter( 'pa_ticker_options', array( $this, 'pa_ticker_options' ) );
		add_action( 'pa_ticker_stock_query', array( $this, 'add_ticker_stock_query' ) );
		add_action( 'pa_ticker_stock_controls', array( $this, 'add_ticker_stock_controls' ) );
		add_action( 'pa_ticker_stock_style', array( $this, 'add_ticker_stock_style' ) );

		// Extend Weather widget controls.
		add_filter( 'pa_weather_options', array( $this, 'pa_weather_options' ) );
		add_action( 'pa_weather_source_controls', array( $this, 'add_weather_source_controls' ) );
		add_action( 'pa_weather_daily_forecast_controls', array( $this, 'add_weather_dailyf_controls' ) );
		add_action( 'pa_weather_custom_icons_controls', array( $this, 'add_weather_custom_icons_controls' ) );

	}

	/**
	 * Get random badges settings.
	 *
	 * @since 2.8.10
	 * @access public
	 *
	 * @param array $settings widget settings.
	 *
	 * @return array $badges_settings settings.
	 */
	public function get_random_badges_settings( $settings ) {

		$badges = $settings['rn_badges'];

		$badges_settings = array();

		foreach ( $badges as $index => $badge ) {

			$options = array(
				'id'       => $badge['_id'],
				'text'     => $badge['rn_badge_text'],
				'max'      => $badge['rn_badge_max'],
				'selector' => $badge['rn_badge_target'],
			);

			array_push( $badges_settings, $options );
		}

		return $badges_settings;

	}

	/**
	 * Add Random Badges Controls
	 *
	 * @since 2.8.10
	 * @access public
	 *
	 * @param object $element elementor element.
	 */
	public function add_random_badges_controls( $element ) {

		$element->add_control(
			'rn_badge_enabled',
			array(
				'label'       => __( 'Enable Random Badges', 'premium-addons-pro' ),
				'type'        => Controls_Manager::SWITCHER,
				'description' => __( 'This option allows you to add badges that appear randomly on your menu items', 'premium-addons-pro' ),
			)
		);

		$badges = new Repeater();

		$badges->add_control(
			'rn_badge_text',
			array(
				'label'   => __( 'Text', 'premium-addons-pro' ),
				'type'    => Controls_Manager::TEXT,
				'default' => __( 'New', 'premium-addons-pro' ),
				'dynamic' => array(
					'active' => true,
				),
			)
		);

		$badges->add_control(
			'rn_badge_target',
			array(
				'label'   => __( 'CSS Selector', 'premium-addons-pro' ),
				'type'    => Controls_Manager::TEXT,
				'dynamic' => array(
					'active' => true,
				),
			)
		);

		$badges->add_control(
			'rn_badge_max',
			array(
				'label'       => __( 'Max Number to Apply This Badge', 'premium-addons-pro' ),
				'type'        => Controls_Manager::NUMBER,
				'description' => __( 'Set a maximum number that this badge should show.', 'premium-addons-pro' ),
				'default'     => 3,

			)
		);

		$badges->add_control(
			'rn_badge_color',
			array(
				'label'     => __( 'Text Color', 'premium-addons-pro' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} {{CURRENT_ITEM}}' => 'color: {{VALUE}} !important;',
				),
			)
		);

		$badges->add_control(
			'rn_badge_bg',
			array(
				'label'     => __( 'Backgroud Color', 'premium-addons-pro' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} {{CURRENT_ITEM}}' => 'background: {{VALUE}} !important;',
				),
			)
		);

		$element->add_control(
			'rn_badges',
			array(
				'label'         => __( 'Badges', 'premium-addons-pro' ),
				'type'          => Controls_Manager::REPEATER,
				'show_label'    => true,
				'fields'        => $badges->get_controls(),
				'title_field'   => '{{{ rn_badge_text }}}',
				'separator'     => 'after',
				'prevent_empty' => false,
				'condition'     => array(
					'rn_badge_enabled' => 'yes',
				),
			)
		);
	}

	/**
	 * Add Custom Menu Controls
	 * Adds repeater controls for mega menu widget.
	 *
	 * @access public
	 * @since 2.7.6
	 *
	 * @param object $elem elementor element.
	 * @param object $repeater repeater element.
	 */
	public function add_custom_menu_controls( $elem, $repeater ) {

		$elem->add_control(
			'menu_items',
			array(
				'label'       => __( 'Menu Items', 'premium-addons-pro' ),
				'type'        => Controls_Manager::REPEATER,
				'show_label'  => true,
				'fields'      => $repeater->get_controls(),
				'default'     => array(
					array(
						'item_type' => 'menu',
						'text'      => __( 'Menu Item 1', 'premium-addons-pro' ),
					),
					array(
						'item_type' => 'submenu',
						'text'      => __( 'Sub Menu', 'premium-addons-pro' ),
					),
					array(
						'item_type' => 'menu',
						'text'      => __( 'Menu Item 2', 'premium-addons-pro' ),
					),
					array(
						'item_type' => 'submenu',
						'text'      => __( 'Sub Menu', 'premium-addons-pro' ),
					),
				),
				'title_field' => '{{{ text }}}',
				'separator'   => 'before',
				'condition'   => array(
					'menu_type' => 'custom',
				),
			)
		);

	}

	/**
	 * Extend woo skins.
	 * Removes the ( PRO ) label from woo skins' title.
	 *
	 * @access public
	 * @since 2.6.6
	 *
	 * @param string $skin skin title.
	 *
	 * @return string
	 */
	public function extend_woo_skins( $skin ) {
		return str_replace( ' (Pro)', '', $skin );
	}

	/**
	 * Extend Terms Cloud layouts.
	 *
	 * @access public
	 * @since 2.6.6
	 *
	 * @return array $layouts widget layouts.
	 */
	public function pa_tcloud_layouts() {

		$options = array(
			'layouts'          => array(
				'default' => __( 'Default', 'premium-addons-pro' ),
				'ribbon'  => __( 'Label', 'premium-addons-pro' ),
				'shape'   => __( 'Shape', 'premium-addons-pro' ),
				'sphere'  => __( 'Sphere', 'premium-addons-pro' ),
			),
			'order_condition'  => '',
			'source_condition' => array(),
		);

		return $options;
	}

	/**
	 * Add Terms Cloud Shape Controls
	 *
	 * @since 2.6.0
	 * @access public
	 *
	 * @param object $elem elementor element.
	 */
	public function add_tcloud_shape_controls( $elem ) {

		$elem->add_control(
			'shape',
			array(
				'label'              => __( 'Shape', 'premium-addons-pro' ),
				'type'               => Controls_Manager::SELECT,
				'label_block'        => true,
				'options'            => array(
					'circle'           => __( 'Circle', 'premium-addons-pro' ),
					'square'           => __( 'Square', 'premium-addons-pro' ),
					'diamond'          => __( 'Diamond', 'premium-addons-pro' ),
					'triangle'         => __( 'Triangle', 'premium-addons-pro' ),
					'triangle-forward' => __( 'Triangle Forward', 'premium-addons-pro' ),
					'cardioid'         => __( 'Cardioid', 'premium-addons-pro' ),
					'pentagon'         => __( 'Pentagon', 'premium-addons-pro' ),
					'star'             => __( 'Star', 'premium-addons-pro' ),
				),
				'default'            => 'circle',
				'separator'          => 'before',
				'frontend_available' => true,
				'condition'          => array(
					'words_order' => 'shape',
				),
			)
		);

		$elem->add_responsive_control(
			'width',
			array(
				'label'       => __( 'Width (PX)', 'premium-addons-pro' ),
				'type'        => Controls_Manager::SLIDER,
				'range'       => array(
					'px' => array(
						'min' => 1,
						'max' => 1000,
					),
				),
				'render_type' => 'template',
				'selectors'   => array(
					'{{WRAPPER}} .premium-tcloud-canvas' => 'width: {{SIZE}}px; --pa-tcloud-width: {{SIZE}}',
				),
				'condition'   => array(
					'words_order!' => array( 'default', 'ribbon' ),
				),
			)
		);

		$elem->add_responsive_control(
			'height',
			array(
				'label'       => __( 'Height (PX)', 'premium-addons-pro' ),
				'type'        => Controls_Manager::SLIDER,
				'range'       => array(
					'px' => array(
						'min' => 1,
						'max' => 1000,
					),
				),
				'render_type' => 'template',
				'selectors'   => array(
					'{{WRAPPER}} .premium-tcloud-canvas' => 'height: {{SIZE}}px; --pa-tcloud-height: {{SIZE}}',
				),
				'condition'   => array(
					'words_order!' => array( 'default', 'ribbon' ),
				),
			)
		);

		$elem->add_control(
			'grid_size',
			array(
				'label'              => __( 'Words Spacing', 'premium-addons-pro' ),
				'type'               => Controls_Manager::SLIDER,
				'range'              => array(
					'px' => array(
						'min' => 0,
						'max' => 30,
					),
				),
				'default'            => array(
					'size' => 8,
				),
				'frontend_available' => true,
				'condition'          => array(
					'words_order' => 'shape',
				),
			)
		);

		$elem->add_control(
			'weight_scale',
			array(
				'label'              => __( 'Scale', 'premium-addons-pro' ),
				'type'               => Controls_Manager::NUMBER,
				'default'            => 5,
				'frontend_available' => true,
				'condition'          => array(
					'words_order' => 'shape',
				),
			)
		);

		$elem->add_control(
			'rotation_select',
			array(
				'label'              => __( 'Rotation', 'premium-addons-pro' ),
				'type'               => Controls_Manager::SELECT,
				'options'            => array(
					'default'    => __( 'Default', 'premium-addons-pro' ),
					'horizontal' => __( 'Horizontal', 'premium-addons-pro' ),
					'vertical'   => __( 'Vertical', 'premium-addons-pro' ),
					'hv'         => __( 'Horizontal and Vertical', 'premium-addons-pro' ),
					'random'     => __( 'Random', 'premium-addons-pro' ),
					'custom'     => __( 'Custom', 'premium-addons-pro' ),
				),
				'default'            => 'default',
				'frontend_available' => true,
				'condition'          => array(
					'words_order' => 'shape',
				),
			)
		);

		$elem->add_control(
			'rotation',
			array(
				'label'              => __( 'Rotation Ratio', 'premium-addons-pro' ),
				'type'               => Controls_Manager::SLIDER,
				'description'        => __( 'The ratio between rotated words to horizontal words.', 'premium-addons-pro' ),
				'range'              => array(
					'px' => array(
						'min'  => 0,
						'max'  => 1,
						'step' => 0.1,
					),
				),
				'default'            => array(
					'size' => 0.3,
				),
				'frontend_available' => true,
				'condition'          => array(
					'rotation_select' => 'custom',
					'words_order'     => 'shape',
				),
			)
		);

		$elem->add_control(
			'degrees',
			array(
				'label'              => __( 'Rotation Degrees', 'premium-addons-pro' ),
				'type'               => Controls_Manager::SLIDER,
				'range'              => array(
					'px' => array(
						'min' => -180,
						'max' => 180,
					),
				),
				'frontend_available' => true,
				'condition'          => array(
					'rotation_select' => 'custom',
					'words_order'     => 'shape',
				),
			)
		);

		$elem->add_control(
			'font_family',
			array(
				'label'              => __( 'Font Family', 'premium-addons-pro' ),
				'type'               => Controls_Manager::FONT,
				'frontend_available' => true,
				'render_type'        => 'template',
				'selectors'          => array(
					'{{WRAPPER}} .font-loader' => 'font-family: "{{VALUE}}", Sans-serif',
				),
				'condition'          => array(
					'words_order!' => array( 'default', 'ribbon' ),
				),
			)
		);

		$elem->add_control(
			'font_weight',
			array(
				'label'              => __( 'Font Weight', 'premium-addons-pro' ),
				'type'               => Controls_Manager::SELECT,
				'frontend_available' => true,
				'render_type'        => 'template',
				'options'            => array(
					'100'    => '100 ' . esc_html_x( '(Thin)', 'Typography Control', 'premium-addons-pro' ),
					'200'    => '200 ' . esc_html_x( '(Extra Light)', 'Typography Control', 'premium-addons-pro' ),
					'300'    => '300 ' . esc_html_x( '(Light)', 'Typography Control', 'premium-addons-pro' ),
					'400'    => '400 ' . esc_html_x( '(Normal)', 'Typography Control', 'premium-addons-pro' ),
					'500'    => '500 ' . esc_html_x( '(Medium)', 'Typography Control', 'premium-addons-pro' ),
					'600'    => '600 ' . esc_html_x( '(Semi Bold)', 'Typography Control', 'premium-addons-pro' ),
					'700'    => '700 ' . esc_html_x( '(Bold)', 'Typography Control', 'premium-addons-pro' ),
					'800'    => '800 ' . esc_html_x( '(Extra Bold)', 'Typography Control', 'premium-addons-pro' ),
					'900'    => '900 ' . esc_html_x( '(Black)', 'Typography Control', 'premium-addons-pro' ),
					''       => esc_html_x( 'Default', 'Typography Control', 'premium-addons-pro' ),
					'normal' => esc_html_x( 'Normal', 'Typography Control', 'premium-addons-pro' ),
					'bold'   => esc_html_x( 'Bold', 'Typography Control', 'premium-addons-pro' ),
				),
				'condition'          => array(
					'words_order!' => array( 'default', 'ribbon' ),
				),
			)
		);

		$elem->add_control(
			'text_transform',
			array(
				'label'       => __( 'Text Transform', 'premium-addons-pro' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					''           => __( 'Default', 'premium-addons-pro' ),
					'uppercase'  => __( 'Uppercase', 'premium-addons-pro' ),
					'lowercase'  => __( 'Lowercase', 'premium-addons-pro' ),
					'capitalize' => __( 'Capitalize', 'premium-addons-pro' ),
				),
				'render_type' => 'template',
				'condition'   => array(
					'words_order!' => array( 'default', 'ribbon' ),
				),
			)
		);

		$elem->add_control(
			'text_height',
			array(
				'label'              => __( 'Text Height', 'premium-addons-pro' ),
				'type'               => Controls_Manager::NUMBER,
				'frontend_available' => true,
				'condition'          => array(
					'words_order'    => 'sphere',
					'sphere_weight!' => 'yes',
				),
			)
		);

		$elem->add_control(
			'sphere_weight',
			array(
				'label'              => __( 'Scale Font Size', 'premium-addons-pro' ),
				'type'               => Controls_Manager::SWITCHER,
				'description'        => __( 'This option is used to increase the font size of each term based on the number of posts in it.', 'premium-addons-pro' ),
				'frontend_available' => true,
				'condition'          => array(
					'words_order' => 'sphere',
				),
			)
		);

		$elem->add_control(
			'weight_min',
			array(
				'label'              => __( 'Minimum Font Size (px)', 'premium-addons-pro' ),
				'type'               => Controls_Manager::SLIDER,
				'default'            => array(
					'unit' => 'px',
					'size' => 10,
				),
				'frontend_available' => true,
				'condition'          => array(
					'words_order'   => 'sphere',
					'sphere_weight' => 'yes',
				),
			)
		);

		$elem->add_control(
			'weight_max',
			array(
				'label'              => __( 'Maximum Font Size (px)', 'premium-addons-pro' ),
				'type'               => Controls_Manager::SLIDER,
				'default'            => array(
					'unit' => 'px',
					'size' => 20,
				),
				'frontend_available' => true,
				'condition'          => array(
					'words_order'   => 'sphere',
					'sphere_weight' => 'yes',
				),
			)
		);

		$elem->add_control(
			'wheel_zoom',
			array(
				'label'              => __( 'Mouse Wheel Zoom', 'premium-addons-pro' ),
				'type'               => Controls_Manager::SWITCHER,
				'frontend_available' => true,
				'condition'          => array(
					'words_order' => 'sphere',
				),
			)
		);

		$elem->add_control(
			'reverse',
			array(
				'label'              => __( 'Reverse', 'premium-addons-pro' ),
				'type'               => Controls_Manager::SWITCHER,
				'frontend_available' => true,
				'condition'          => array(
					'words_order'   => 'sphere',
					'drag_control!' => 'yes',
				),
			)
		);

		$elem->add_control(
			'drag_control',
			array(
				'label'              => __( 'Drag Control', 'premium-addons-pro' ),
				'type'               => Controls_Manager::SWITCHER,
				'frontend_available' => true,
				'condition'          => array(
					'words_order' => 'sphere',
				),
			)
		);

		$elem->add_control(
			'stop_onDrag',
			array(
				'label'              => __( 'Stop Animation After Drag', 'premium-addons-pro' ),
				'type'               => Controls_Manager::SWITCHER,
				'default'            => 'yes',
				'frontend_available' => true,
				'condition'          => array(
					'words_order'  => 'sphere',
					'drag_control' => 'yes',
				),
			)
		);

		$elem->add_control(
			'start_xspeed',
			array(
				'label'              => __( 'Start Horizontal Rotate Speed', 'premium-addons-pro' ),
				'type'               => Controls_Manager::SLIDER,
				'description'        => __( 'Use this option to control the initial horizontal rotation of the sphere.', 'premium-addons-pro' ),
				'default'            => array(
					'unit' => 'px',
					'size' => 0,
				),
				'range'              => array(
					'px' => array(
						'min'  => -5,
						'max'  => 5,
						'step' => 0.1,
					),
				),
				'frontend_available' => true,
				'condition'          => array(
					'words_order' => 'sphere',
				),
			)
		);

		$elem->add_control(
			'start_yspeed',
			array(
				'label'              => __( 'Start Vertical Rotate Speed', 'premium-addons-pro' ),
				'type'               => Controls_Manager::SLIDER,
				'description'        => __( 'Use this option to control the initial vertical rotation of the sphere.', 'premium-addons-pro' ),
				'default'            => array(
					'unit' => 'px',
					'size' => 0,
				),
				'range'              => array(
					'px' => array(
						'min'  => -5,
						'max'  => 5,
						'step' => 0.1,
					),
				),
				'frontend_available' => true,
				'condition'          => array(
					'words_order' => 'sphere',
				),
			)
		);

		$elem->add_control(
			'interval',
			array(
				'label'              => __( 'Time between Rendering Words (sec)', 'premium-addons-pro' ),
				'type'               => Controls_Manager::SLIDER,
				'description'        => __( 'Use this option to set the time before rendering the next word.', 'premium-addons-pro' ),
				'default'            => array(
					'unit' => 'px',
					'size' => 0,
				),
				'range'              => array(
					'px' => array(
						'min'  => 0,
						'max'  => 1,
						'step' => 0.1,
					),
				),
				'frontend_available' => true,
				'condition'          => array(
					'words_order' => 'shape',
				),
			)
		);

	}

	/**
	 * Add Terms Cloud Sphere Controls
	 *
	 * @since 2.6.0
	 * @access public
	 *
	 * @param object $elem elementor element.
	 */
	public function add_tcloud_sphere_controls( $elem ) {

		$elem->add_control(
			'colors_target',
			array(
				'label'              => __( 'Apply Colors On', 'premium-addons-for-elementor' ),
				'type'               => Controls_Manager::SELECT,
				'options'            => array(
					'text'       => __( 'Text', 'premium-addons-for-elementor' ),
					'background' => __( 'Background', 'premium-addons-for-elementor' ),
				),
				'default'            => 'text',
				'frontend_available' => true,
				'condition'          => array(
					'words_order' => 'sphere',
				),
			)
		);

		$elem->add_control(
			'sphere_term_color',
			array(
				'label'       => __( 'Text Color', 'premium-addons-for-elementor' ),
				'type'        => Controls_Manager::COLOR,
				'selectors'   => array(
					'{{WRAPPER}} .premium-tcloud-term-link' => 'color: {{VALUE}}',
				),
				'render_type' => 'template',
				'condition'   => array(
					'words_order'   => 'sphere',
					'colors_target' => 'background',
				),
			)
		);

		$elem->add_control(
			'sphere_term_padding',
			array(
				'label'              => __( 'Padding (px)', 'premium-addons-for-elementor' ),
				'type'               => Controls_Manager::SLIDER,
				'range'              => array(
					'px' => array(
						'min' => 0,
						'max' => 30,
					),
				),
				'default'            => array(
					'size' => 20,
				),
				'frontend_available' => true,
				'condition'          => array(
					'words_order'   => 'sphere',
					'colors_target' => 'background',
				),
			)
		);

		$elem->add_control(
			'sphere_term_radius',
			array(
				'label'              => __( 'Radius (px)', 'premium-addons-for-elementor' ),
				'type'               => Controls_Manager::SLIDER,
				'range'              => array(
					'px' => array(
						'min' => 0,
						'max' => 30,
					),
				),
				'default'            => array(
					'size' => 5,
				),
				'frontend_available' => true,
				'condition'          => array(
					'words_order'   => 'sphere',
					'colors_target' => 'background',
				),
			)
		);

	}

	/**
	 * Extend Recent Posts Notification Options.
	 *
	 * @access public
	 * @since 2.6.6
	 *
	 * @return array $layouts widget layouts.
	 */
	public function pa_notification_options() {

		$options = array(
			'skins'            => array(
				'classic' => __( 'Classic', 'premium-addons-pro' ),
				'modern'  => __( 'Modern', 'premium-addons-pro' ),
				'cards'   => __( 'Cards', 'premium-addons-pro' ),
				'banner'  => __( 'Banner', 'premium-addons-pro' ),
			),
			'skin_condition'   => '',
			'source_condition' => array(),
		);

		return $options;
	}

	/**
	 * Add Recent Notification Categories Controls
	 *
	 * @since 2.6.0
	 * @access public
	 *
	 * @param object $elem elementor element.
	 */
	public function add_notification_cats_controls( $elem ) {

		$elem->start_controls_section(
			'post_categories_style_section',
			array(
				'label'     => __( 'Categories', 'premium-addons-for-elementor' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => array(
					'premium_blog_skin'            => 'banner',
					'premium_blog_categories_meta' => 'yes',
				),
			)
		);

		$elem->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'category_typography',
				'selector' => '{{WRAPPER}} .premium-blog-cats-container a',
			)
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'category_color',
			array(
				'label'     => __( 'Color', 'premium-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} {{CURRENT_ITEM}}' => 'color: {{VALUE}}',
				),
			)
		);

		$repeater->add_control(
			'category_hover_color',
			array(
				'label'     => __( 'Hover Color', 'premium-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} {{CURRENT_ITEM}}:hover' => 'color: {{VALUE}}',
				),
			)
		);

		$repeater->add_control(
			'category_background_color',
			array(
				'label'     => __( 'Background Color', 'premium-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} {{CURRENT_ITEM}}' => 'background-color: {{VALUE}}',
				),
			)
		);

		$repeater->add_control(
			'category_hover_background_color',
			array(
				'label'     => __( 'Hover Background Color', 'premium-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} {{CURRENT_ITEM}}:hover' => 'background-color: {{VALUE}}',
				),
			)
		);

		$repeater->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'     => 'category_border',
				'selector' => '{{WRAPPER}} {{CURRENT_ITEM}}',
			)
		);

		$repeater->add_control(
			'category_border_radius',
			array(
				'label'      => __( 'Border Radius', 'premium-addons-for-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} {{CURRENT_ITEM}}' => 'border-radius: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$elem->add_control(
			'categories_repeater',
			array(
				'label'       => __( 'Categories', 'premium-addons-for-elementor' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'default'     => array(
					array(
						'category_background_color' => '',
					),
				),
				'render_type' => 'ui',
				'condition'   => array(
					'premium_blog_skin'            => 'banner',
					'premium_blog_categories_meta' => 'yes',
				),
			)
		);

		$elem->add_responsive_control(
			'categories_margin',
			array(
				'label'      => __( 'Margin', 'premium-addons-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .premium-blog-cats-container a' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$elem->add_responsive_control(
			'categories_padding',
			array(
				'label'      => __( 'Padding', 'premium-addons-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .premium-blog-cats-container a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$elem->end_controls_section();

	}

	/**
	 * Extend World Clock Options.
	 *
	 * @access public
	 * @since 2.6.6
	 *
	 * @return array $layouts widget layouts.
	 */
	public function pa_clock_options() {

		$options = array(
			'skins'          => array(
				'digital' => array(
					'label'   => __( 'Digital', 'premium-addons-pro' ),
					'options' => array(
						'skin-2' => __( 'Layout 1', 'premium-addons-pro' ),
						'skin-3' => __( 'Layout 2', 'premium-addons-pro' ),
						'skin-4' => __( 'Layout 3', 'premium-addons-pro' ),
					),
				),
				'analog'  => array(
					'label'   => __( 'Analog', 'premium-addons-pro' ),
					'options' => array(
						'skin-1' => __( 'Style 1', 'premium-addons-pro' ),
						'skin-5' => __( 'Style 2', 'premium-addons-pro' ),
						'skin-6' => __( 'Style 3', 'premium-addons-pro' ),
						'skin-7' => __( 'Style 4', 'premium-addons-pro' ),
					),
				),
			),
			'skin_condition' => '',
		);

		return $options;
	}

	/**
	 * Extend News Ticker Options.
	 *
	 * @access public
	 * @since 2.6.6
	 *
	 * @return array $layouts widget layouts.
	 */
	public function pa_ticker_options() {

		$options = array(
			'layouts'          => array(
				'layout-1' => __( 'Layout 1', 'premium-addons-for-elementor' ),
				'layout-2' => __( 'Layout 2', 'premium-addons-for-elementor' ),
				'layout-3' => __( 'Layout 3', 'premium-addons-for-elementor' ),
				'layout-4' => __( 'Layout 4', 'premium-addons-for-elementor' ),
			),
			'layout_condition' => array(),
		);

		return $options;
	}

	/**
	 * Add Ticker Stock Query
	 *
	 * @since 2.6.0
	 * @access public
	 *
	 * @param object $elem elementor element.
	 */
	public function add_ticker_stock_query( $elem ) {

		$elem->add_control(
			'req_function',
			array(
				'label'     => __( 'Type', 'premium-addons-for-elementor' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => array(
					'CURRENCY_EXCHANGE_RATE' => __( 'Currencies', 'premium-addons-for-elementor' ),
					'GLOBAL_QUOTE'           => __( 'Equities', 'premium-addons-for-elementor' ),
				),
				'default'   => 'GLOBAL_QUOTE',
				'condition' => array(
					'post_type_filter' => 'stock',
				),
			)
		);

		$elem->add_control(
			'currency_ex_notice',
			array(
				'type'            => Controls_Manager::RAW_HTML,
				'raw'             => __( 'Returns the realtime exchange rate for any pair of digital currency (e.g., Bitcoin) or physical currency (e.g., USD). <b>Cryptocurrecies must start with "/", e.g (/BTC)', 'premium-addons-for-elementor' ),
				'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
				'condition'       => array(
					'post_type_filter' => 'stock',
					'req_function'     => 'CURRENCY_EXCHANGE_RATE',
				),
			)
		);

		$elem->add_control(
			'equity_notice',
			array(
				'type'            => Controls_Manager::RAW_HTML,
				'raw'             => __( 'Returns the stock price details for a token/symbol of your choice.', 'premium-addons-for-elementor' ),
				'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
				'condition'       => array(
					'post_type_filter' => 'stock',
					'req_function'     => 'GLOBAL_QUOTE',
				),
			)
		);

		$elem->add_control(
			'api_key',
			array(
				'label'       => __( 'API Key', 'premium-addons-for-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'label_block' => true,
				'description' => 'Get your Alpha Vintage <b>Free API Key</b> from <a href="https://www.alphavantage.co/support/#api-key" target="_blank">here</a>',
				'condition'   => array(
					'post_type_filter' => 'stock',
				),
			)
		);

		$elem->add_control(
			'symbol',
			array(
				'label'       => __( 'Symbol', 'premium-addons-for-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'description' => __( 'Enter the stock tokens/symbols you want to query up to 5 symbols separated by ",". Example: AAPL,MSFT,INTC', 'premium-addons-for-elementor' ),
				'label_block' => true,
				'default'     => 'AAPL,MSFT,INTC',
				'condition'   => array(
					'post_type_filter' => 'stock',
					'req_function'     => 'GLOBAL_QUOTE',
				),
			)
		);

		$elem->add_control(
			'from_currency',
			array(
				'label'       => __( 'Exchange From', 'premium-addons-for-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'description' => __( 'Enter the currency you want exchange from up to 5 symbols separated by ",". Example: USD,EUR,GBP', 'premium-addons-for-elementor' ),
				'label_block' => true,
				'default'     => 'USD,EUR,GBP',
				'condition'   => array(
					'post_type_filter' => 'stock',
					'req_function'     => 'CURRENCY_EXCHANGE_RATE',
				),
			)
		);

		$elem->add_control(
			'to_currency',
			array(
				'label'       => __( 'Exchange To', 'premium-addons-for-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => 'EUR,JPY,CAD',
				'description' => __( 'Enter the currencies you want to exchange to separated by ",". Example: EUR,JPY,CAD', 'premium-addons-for-elementor' ),
				'label_block' => true,
				'condition'   => array(
					'post_type_filter' => 'stock',
					'req_function'     => 'CURRENCY_EXCHANGE_RATE',
				),
			)
		);

		$elem->add_control(
			'curr_change',
			array(
				'label'       => __( 'Show Change Details', 'premium-addons-for-elementor' ),
				'type'        => Controls_Manager::SWITCHER,
				'description' => __( 'Display the change details depending on the previously cached data.', 'premium-addons-for-elementor' ),
				// 'render_type'  => 'template',
				'condition'   => array(
					'post_type_filter' => 'stock',
					'req_function'     => 'CURRENCY_EXCHANGE_RATE',
				),
			)
		);

		$elem->add_control(
			'reload',
			array(
				'label'     => __( 'Reload Data Once Every', 'premium-addons-for-elementor' ),
				'type'      => Controls_Manager::SELECT,
				'separator' => 'before',
				'options'   => array(
					1  => __( 'Hour', 'premium-addons-for-elementor' ),
					3  => __( '3 Hours', 'premium-addons-for-elementor' ),
					6  => __( '6 Hours', 'premium-addons-for-elementor' ),
					12 => __( '12 Hours', 'premium-addons-for-elementor' ),
					24 => __( 'Day', 'premium-addons-for-elementor' ),
				),
				'default'   => 3,
				'condition' => array(
					'post_type_filter' => 'stock',
				),
			)
		);

		$elem->add_control(
			'gold_api_key',
			array(
				'label'       => __( 'API Key', 'premium-addons-for-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'label_block' => true,
				'description' => 'Get your <b>Free Gold API Key</b> from <a href="https://www.goldapi.io" target="_blank">here</a>',
				'condition'   => array(
					'post_type_filter' => 'gold',
				),
			)
		);

		$elem->add_control(
			'currencies',
			array(
				'label'       => __( 'Currencies', 'premium-addons-for-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'description' => __( 'Enter the Currencies symbols you want to query up to 5 symbols separated by ",". Example: USD,EUR,JPY, You can check the available currencies <a href="https://www.goldapi.io/dashboard" target="_blank">here -> Currency Code.</a>', 'premium-addons-for-elementor' ),
				'label_block' => true,
				'default'     => 'USD,EUR,JPY',
				'condition'   => array(
					'post_type_filter' => 'gold',
				),
			)
		);

		$elem->add_control(
			'gold_reload',
			array(
				'label'     => __( 'Reload Data Once Every', 'premium-addons-for-elementor' ),
				'type'      => Controls_Manager::SELECT,
				'separator' => 'before',
				'options'   => array(
					12 => __( '12 Hours', 'premium-addons-for-elementor' ),
					24 => __( 'Day', 'premium-addons-for-elementor' ),
				),
				'default'   => 24,
				'condition' => array(
					'post_type_filter' => 'gold',
				),
			)
		);

	}

	/**
	 * Add Ticker Stock Controls
	 *
	 * @since 2.6.0
	 * @access public
	 *
	 * @param object $elem elementor element.
	 */
	public function add_ticker_stock_controls( $elem ) {
		$common_cond = array(
			'relation' => 'or',
			'terms'    => array(
				array(
					'name'  => 'post_type_filter',
					'value' => 'gold',
				),
				array(
					'terms' => array(
						array(
							'name'  => 'post_type_filter',
							'value' => 'stock',
						),
						array(
							'relation' => 'or',
							'terms'    => array(
								array(
									'name'  => 'req_function',
									'value' => 'GLOBAL_QUOTE',
								),
								array(
									'terms' => array(
										array(
											'name'  => 'req_function',
											'value' => 'CURRENCY_EXCHANGE_RATE',
										),
										array(
											'name'  => 'curr_change',
											'value' => 'yes',
										),
									),
								),
							),
						),
					),
				),
			),
		);

		$elem->start_controls_section(
			'pa_ticker_Stock_section',
			array(
				'label'     => __( 'Stock Options', 'premium-addons-for-elementor' ),
				'condition' => array(
					'post_type_filter' => array( 'stock', 'gold' ),
				),
			)
		);

		$elem->add_control(
			'show_symbol_icon',
			array(
				'label'     => __( 'Show Symbol Icon', 'premium-addons-for-elementor' ),
				'type'      => Controls_Manager::SWITCHER,
				'condition' => array(
					'post_type_filter' => 'stock',
				),
			)
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'symbol_name',
			array(
				'label'       => __( 'Symbol', 'premium-addons-for-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'description' => __( 'Use this to add the currency/company symbol that the image below will be linked to. For example, USD or AAPL.', 'premium-addons-for-elementor' ),
				'label_block' => true,
			)
		);

		$repeater->add_control(
			'symbol_img',
			array(
				'label' => __( 'Symbol Image', 'premium-addons-for-elementor' ),
				'type'  => Controls_Manager::MEDIA,
			)
		);

		$elem->add_control(
			'symbol_icons_repeater',
			array(
				'label'       => __( 'Custom Symbols Icons', 'premium-addons-for-elementor' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'title_field' => '{{{ symbol_name }}}',
				'condition'   => array(
					'post_type_filter' => 'stock',
					'show_symbol_icon' => 'yes',
				),
			)
		);

		$elem->add_responsive_control(
			'symbol_icon_size',
			array(
				'label'     => __( 'Icon Size (px)', 'premium-addons-for-elementor' ),
				'type'      => Controls_Manager::SLIDER,
				'default'   => array(
					'size' => 30,
				),
				'selectors' => array(
					'{{WRAPPER}} .premium-post-ticker__symbol-icon'  => 'width: {{SIZE}}px',
				),
				'condition' => array(
					'post_type_filter' => 'stock',
					'show_symbol_icon' => 'yes',
				),
			)
		);

		$elem->add_control(
			'symbol_names_sw',
			array(
				'label'     => __( 'Show Symbols Names', 'premium-addons-for-elementor' ),
				'type'      => Controls_Manager::SWITCHER,
				'condition' => array(
					'req_function'     => 'GLOBAL_QUOTE',
					'post_type_filter' => 'stock',
				),
			)
		);

		$elem->add_control(
			'symbol_name',
			array(
				'label'       => __( 'Symbols Names', 'premium-addons-for-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'description' => __( 'Enter the stock tokens\' names you want to display corresponding to the above symbols and separated by ",". Example: Apple Inc,Microsoft Corp,Intel Corporation', 'premium-addons-for-elementor' ),
				'label_block' => true,
				'default'     => 'Apple Inc,Microsoft Corp,Intel Corporation',
				'condition'   => array(
					'req_function'     => 'GLOBAL_QUOTE',
					'symbol_names_sw'  => 'yes',
					'post_type_filter' => 'stock',
				),
			)
		);

		$elem->add_control(
			'show_symbol',
			array(
				'label'     => __( 'Show Symbol', 'premium-addons-for-elementor' ),
				'type'      => Controls_Manager::SWITCHER,
				'default'   => 'yes',
				'condition' => array(
					'req_function'     => 'GLOBAL_QUOTE',
					'post_type_filter' => 'stock',
				),
			)
		);

		$elem->add_control(
			'show_price',
			array(
				'label'   => __( 'Show Price', 'premium-addons-for-elementor' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			)
		);

		$elem->add_control(
			'show_change',
			array(
				'label'      => __( 'Show Change', 'premium-addons-for-elementor' ),
				'type'       => Controls_Manager::SWITCHER,
				'default'    => 'yes',
				'conditions' => $common_cond,
			)
		);

		$elem->add_control(
			'show_change_per',
			array(
				'label'      => __( 'Show Change Percent', 'premium-addons-for-elementor' ),
				'type'       => Controls_Manager::SWITCHER,
				'default'    => 'yes',
				'conditions' => $common_cond,
			)
		);

		$elem->add_control(
			'change_indicator',
			array(
				'label'      => __( 'Change Indicator', 'premium-addons-for-elementor' ),
				'type'       => Controls_Manager::SELECT,
				'options'    => array(
					'sign'  => __( '+/- Sign', 'premium-addons-for-elementor' ),
					'arrow' => __( 'Arrow', 'premium-addons-for-elementor' ),
				),
				'default'    => 'arrow',
				'conditions' => $common_cond,
			)
		);

		$elem->add_control(
			'arrow_style',
			array(
				'label'      => __( 'Arrow Style', 'premium-addons-for-elementor' ),
				'type'       => Controls_Manager::SELECT,
				'options'    => array(
					'fas fa-caret'          => __( 'Style 1', 'premium-addons-for-elementor' ),
					'fas fa-long-arrow-alt' => __( 'Style 2', 'premium-addons-for-elementor' ),
					'fas fa-arrow'          => __( 'Style 3', 'premium-addons-for-elementor' ),
					'fas fa-chevron'        => __( 'Style 4', 'premium-addons-for-elementor' ),
				),
				'default'    => 'fas fa-long-arrow-alt',
				'conditions' => array(
					'terms' => array(
						array(
							'name'  => 'change_indicator',
							'value' => 'arrow',
						),
						$common_cond,
					),
				),
			)
		);

		$elem->add_control(
			'decimal_places',
			array(
				'label'   => __( 'Decimal Places', 'premium-addons-for-elementor' ),
				'type'    => Controls_Manager::NUMBER,
				'min'     => 0,
				'default' => 2,
			)
		);

		$elem->add_responsive_control(
			'stock_ele_min_width',
			array(
				'label'       => __( 'Minimum Width (px)', 'premium-addons-for-elementor' ),
				'description' => __( 'Use this option to add equal spacing to the element data.', 'premium-addons-for-elementor' ),
				'type'        => Controls_Manager::SLIDER,
				'size_units'  => array( 'px' ),
				'range'       => array(
					'px' => array(
						'min' => 0,
						'max' => 500,
					),
				),
				'selectors'   => array(
					'{{WRAPPER}} .premium-post-ticker__post-wrapper span'  => 'min-width: {{SIZE}}px',
				),
				'condition'   => array(
					'layout' => 'layout-4',
				),
			)
		);

		$elem->end_controls_section();

	}

	/**
	 * Add Ticker Stock Style
	 *
	 * @since 2.6.0
	 * @access public
	 *
	 * @param object $elem elementor element.
	 */
	public function add_ticker_stock_style( $elem ) {

		$stock_gold_cond = array(
			'terms' => array(
				array(
					'name'  => 'post_type_filter',
					'value' => 'stock',
				),
				array(
					'relation' => 'or',
					'terms'    => array(
						array(
							'name'  => 'req_function',
							'value' => 'CURRENCY_EXCHANGE_RATE',
						),
						array(
							'terms' => array(
								array(
									'name'  => 'req_function',
									'value' => 'GLOBAL_QUOTE',
								),
								array(
									'name'  => 'show_symbol',
									'value' => 'yes',
								),
							),
						),
					),
				),
			),
		);

		$stock_gold_cond = array(
			'terms' => array(
				array(
					'name'  => 'post_type_filter',
					'value' => 'stock',
				),
				array(
					'relation' => 'or',
					'terms'    => array(
						array(
							'name'  => 'req_function',
							'value' => 'CURRENCY_EXCHANGE_RATE',
						),
						array(
							'terms' => array(
								array(
									'name'  => 'req_function',
									'value' => 'GLOBAL_QUOTE',
								),
								array(
									'name'  => 'show_symbol',
									'value' => 'yes',
								),
							),
						),
					),
				),
			),
		);

		$elem->add_control(
			'pa_stock_name_heading',
			array(
				'label'     => __( 'Name', 'premium-addons-for-elementor' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => array(
					'post_type_filter' => 'stock',
					'req_function'     => 'GLOBAL_QUOTE',
					'symbol_names_sw'  => 'yes',
				),
			)
		);

		$elem->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'      => 'pa_symbol_name_typo',
				'selector'  => '{{WRAPPER}} .premium-post-ticker__symbol-name',
				'condition' => array(
					'post_type_filter' => 'stock',
					'req_function'     => 'GLOBAL_QUOTE',
					'symbol_names_sw'  => 'yes',
				),
			)
		);

		$elem->add_control(
			'pa_symbol_name_color',
			array(
				'label'     => __( 'Color', 'premium-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .premium-post-ticker__symbol-name'  => 'color: {{VALUE}};',
				),
				'separator' => 'after',
				'condition' => array(
					'symbol_names_sw'  => 'yes',
					'post_type_filter' => 'stock',
					'req_function'     => 'GLOBAL_QUOTE',
				),
			)
		);

		$elem->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'      => 'symbol_icon_shadow',
				'label'     => __( 'Symbol Icon Shadow', 'premium-addons-for-elementor' ),
				'selector'  => '{{WRAPPER}} .premium-post-ticker__symbol-icon',
				'condition' => array(
					'post_type_filter' => 'stock',
					'show_symbol_icon' => 'yes',
				),
			)
		);

		$elem->add_responsive_control(
			'symbol_icon_margin',
			array(
				'label'      => __( 'Symbol Icon Margin', 'premium-addons-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px' ),
				'selectors'  => array(
					'{{WRAPPER}} .premium-post-ticker__symbol-icon' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'condition'  => array(
					'post_type_filter' => 'stock',
					'show_symbol_icon' => 'yes',
				),
			)
		);

		$elem->add_control(
			'pa_symbol_heading',
			array(
				'label'     => __( 'Symbol', 'premium-addons-for-elementor' ),
				'type'      => Controls_Manager::HEADING,
				'condition' => array(
					'post_type_filter' => array( 'stock', 'gold' ),
				),
			)
		);

		$elem->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'       => 'pa_symbol_typo',
				'selector'   => '{{WRAPPER}} .premium-post-ticker__symbol',
				'conditions' => array(
					'relation' => 'or',
					'terms'    => array(
						array(
							'name'  => 'post_type_filter',
							'value' => 'gold',
						),
						$stock_gold_cond,
					),
				),
			)
		);

		$elem->add_control(
			'pa_symbol_color',
			array(
				'label'      => __( 'Color', 'premium-addons-for-elementor' ),
				'type'       => Controls_Manager::COLOR,
				'selectors'  => array(
					'{{WRAPPER}} .premium-post-ticker__symbol'  => 'color: {{VALUE}};',
				),
				'conditions' => array(
					'relation' => 'or',
					'terms'    => array(
						array(
							'name'  => 'post_type_filter',
							'value' => 'gold',
						),
						$stock_gold_cond,
					),
				),
			)
		);

		$elem->add_responsive_control(
			'pa_symbol_margin',
			array(
				'label'      => __( 'Margin', 'premium-addons-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', 'custom' ),
				'selectors'  => array(
					'{{WRAPPER}} .premium-post-ticker__symbol' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'conditions' => array(
					'relation' => 'or',
					'terms'    => array(
						array(
							'name'  => 'post_type_filter',
							'value' => 'gold',
						),
						$stock_gold_cond,
					),
				),
			)
		);

		$elem->add_control(
			'pa_price_details_heading',
			array(
				'label'     => __( 'Price Details', 'premium-addons-for-elementor' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => array(
					'post_type_filter' => array( 'stock', 'gold' ),
				),
			)
		);

		$elem->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'      => 'pa_price_details_typo',
				'selector'  => '{{WRAPPER}} .premium-post-ticker__change-wrapper > *, {{WRAPPER}} .premium-post-ticker__price.exhange-rate',
				'condition' => array(
					'post_type_filter' => array( 'stock', 'gold' ),
				),
			)
		);

		$elem->add_control(
			'pa_price_details_color',
			array(
				'label'     => __( 'Color', 'premium-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .premium-post-ticker__change-wrapper > *, {{WRAPPER}} .premium-post-ticker__price.exhange-rate'  => 'color: {{VALUE}};',
				),
				'condition' => array(
					'post_type_filter' => array( 'stock', 'gold' ),
				),
			)
		);

		$elem->add_control(
			'pa_neg_change_color',
			array(
				'label'     => __( 'Negative Change Color', 'premium-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .premium-post-ticker__change-wrapper .down'  => 'color: {{VALUE}};',
				),
				'condition' => array(
					'post_type_filter' => array( 'stock', 'gold' ),
				),
			)
		);

		$elem->add_control(
			'pa_pos_change_color',
			array(
				'label'     => __( 'Positive Change Color', 'premium-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .premium-post-ticker__change-wrapper .up'  => 'color: {{VALUE}};',
				),
				'condition' => array(
					'post_type_filter' => array( 'stock', 'gold' ),
				),
			)
		);

		$elem->add_responsive_control(
			'price_details_spacing',
			array(
				'label'      => __( 'Spacing', 'premium-addons-for-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array(
					'px' => array(
						'min' => 0,
						'max' => 500,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .premium-post-ticker__change-wrapper'  => 'column-gap: {{SIZE}}px;',
				),
				'condition'  => array(
					'post_type_filter' => array( 'stock', 'gold' ),
				),
			)
		);

		$elem->add_responsive_control(
			'price_icon_size',
			array(
				'label'      => __( 'Icon Size', 'premium-addons-for-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array(
					'px' => array(
						'min' => 0,
						'max' => 500,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .premium-post-ticker__change-wrapper i'  => 'font-size: {{SIZE}}px;',
				),
				'condition'  => array(
					'change_indicator' => 'arrow',
					'post_type_filter' => array( 'stock', 'gold' ),
				),
			)
		);

		$elem->add_responsive_control(
			'pa_price_icon_margin',
			array(
				'label'      => __( 'Icon Margin', 'premium-addons-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px' ),
				'selectors'  => array(
					'{{WRAPPER}} .premium-post-ticker__change-wrapper i' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'condition'  => array(
					'change_indicator' => 'arrow',
					'post_type_filter' => array( 'stock', 'gold' ),
				),
			)
		);

		$elem->add_responsive_control(
			'pa_price_details_margin',
			array(
				'label'      => __( 'Margin', 'premium-addons-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', 'custom' ),
				'selectors'  => array(
					'{{WRAPPER}} .premium-post-ticker__change-wrapper, {{WRAPPER}} .premium-post-ticker__price.exhange-rate' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'condition'  => array(
					'post_type_filter' => array( 'stock', 'gold' ),
				),
			)
		);

	}

	/**
	 * Extend Weather Options.
	 *
	 * @access public
	 * @since 2.6.6
	 *
	 * @return array $options widget options.
	 */
	public function pa_weather_options() {

		$options = array(
			'source'                 => array(
				'name'   => __( 'City Name', 'premium-addons-for-elementor' ),
				'coords' => __( 'City Coordinates', 'premium-addons-for-elementor' ),
			),
			'layouts'                => array(
				'layout-1' => __( 'Layout 1', 'premium-addons-for-elementor' ),
				'layout-2' => __( 'Layout 2', 'premium-addons-for-elementor' ),
				'layout-3' => __( 'Layout 3', 'premium-addons-for-elementor' ),
			),
			'source_condition'       => array(),
			'dailyf_condition'       => array(),
			'custom_icons_condition' => array(),
		);

		return $options;
	}

	/**
	 * Add Weather Source Controls
	 *
	 * @since 2.6.0
	 * @access public
	 *
	 * @param object $elem elementor element.
	 */
	public function add_weather_source_controls( $elem ) {

		$elem->add_control(
			'lat_coord',
			array(
				'label'       => __( 'Latitude', 'premium-addons-for-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => array( 'active' => true ),
				'label_block' => true,
				'condition'   => array(
					'location_type'        => 'custom',
					'custom_location_type' => 'coords',
				),
			)
		);

		$elem->add_control(
			'long_coord',
			array(
				'label'       => __( 'Longitude', 'premium-addons-for-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => array( 'active' => true ),
				'label_block' => true,
				'condition'   => array(
					'location_type'        => 'custom',
					'custom_location_type' => 'coords',
				),
			)
		);

	}

	/**
	 * Add Weather Daily Forecast Controls
	 *
	 * @since 2.6.0
	 * @access public
	 *
	 * @param object $elem elementor element.
	 */
	public function add_weather_dailyf_controls( $elem ) {

		$elem->add_control(
			'forecast_layouts',
			array(
				'label'        => __( 'Choose Style', 'premium-addons-for-elementor' ),
				'type'         => Controls_Manager::SELECT,
				'prefix_class' => 'premium-daily-forecast__',
				'render_type'  => 'template',
				'label_block'  => true,
				'options'      => array(
					'style-1' => __( 'Style 1', 'premium-addons-for-elementor' ),
					'style-2' => __( 'Style 2', 'premium-addons-for-elementor' ),
					'style-3' => __( 'Style 3', 'premium-addons-for-elementor' ),
					'style-4' => __( 'Style 4', 'premium-addons-for-elementor' ),
				),
				'default'      => 'style-1',
				'conditions'   => array(
					'terms' => array(
						array(
							'name'  => 'enable_forecast',
							'value' => 'yes',
						),
						array(
							'relation' => 'or',
							'terms'    => array(
								array(
									'name'     => 'forecast_tabs',
									'operator' => '!==',
									'value'    => 'yes',
								),
								array(
									'terms' => array(
										array(
											'name'  => 'forecast_tabs',
											'value' => 'yes',
										),
										array(
											'name'     => 'forecast_days',
											'operator' => 'in',
											'value'    => array( '1', '6', '7', '8' ),
										),
									),
								),
							),
						),
					),
				),
			)
		);

		$elem->add_control(
			'show_forecast_icon',
			array(
				'label'     => __( 'Weather state Icon', 'premium-addons-for-elementor' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_on'  => __( 'Show', 'premium-addons-for-elementor' ),
				'label_off' => __( 'Hide', 'premium-addons-for-elementor' ),
				'default'   => 'yes',
				'condition' => array(
					'enable_forecast' => 'yes',
					'forecast_tabs!'  => 'yes',
				),
			)
		);

		$elem->add_control(
			'forecast_days',
			array(
				'label'       => __( 'Number Of Days', 'premium-addons-for-elementor' ),
				'type'        => Controls_Manager::SELECT,
				'render_type' => 'template',
				'label_block' => true,
				'options'     => array(
					'1' => __( '1 Day', 'premium-addons-for-elementor' ),
					'2' => __( '2 Days', 'premium-addons-for-elementor' ),
					'3' => __( '3 Days', 'premium-addons-for-elementor' ),
					'4' => __( '4 Days', 'premium-addons-for-elementor' ),
					'5' => __( '5 Days', 'premium-addons-for-elementor' ),
					'6' => __( '6 Days', 'premium-addons-for-elementor' ),
					'7' => __( '7 Days', 'premium-addons-for-elementor' ),
					'8' => __( '8 Days', 'premium-addons-for-elementor' ),
				),
				'default'     => 5,
				'condition'   => array(
					'enable_forecast' => 'yes',
				),
			)
		);

		$elem->add_responsive_control(
			'forecast_alignment',
			array(
				'label'        => __( 'Block Alignment', 'premium-addons-for-elementor' ),
				'type'         => Controls_Manager::CHOOSE,
				'prefix_class' => 'premium-weather-',
				'options'      => array(
					'flex-start'    => array(
						'title' => __( 'Left', 'premium-addons-for-elementor' ),
						'icon'  => 'eicon-h-align-left',
					),
					'center'        => array(
						'title' => __( 'Center', 'premium-addons-for-elementor' ),
						'icon'  => 'eicon-h-align-center',
					),
					'flex-end'      => array(
						'title' => __( 'Right', 'premium-addons-for-elementor' ),
						'icon'  => 'eicon-h-align-right',
					),
					'space-between' => array(
						'title' => __( 'Strech', 'premium-addons-for-elementor' ),
						'icon'  => 'eicon-h-align-stretch',
					),
				),
				'default'      => 'space-between',
				'toggle'       => false,
				'selectors'    => array(
					'{{WRAPPER}} .premium-weather__forecast, {{WRAPPER}} .premium-weather__tabs-headers' => 'justify-content: {{VALUE}}',
				),
				'conditions'   => array(
					'terms' => array(
						array(
							'name'  => 'enable_forecast',
							'value' => 'yes',
						),
						array(
							'relation' => 'or',
							'terms'    => array(
								array(
									'name'  => 'forecast_tabs',
									'value' => 'yes',
								),
								array(
									'terms' => array(
										array(
											'name'     => 'forecast_tabs',
											'operator' => '!==',
											'value'    => 'yes',
										),
										array(
											'name'     => 'forecast_layouts',
											'operator' => '!==',
											'value'    => 'style-4',
										),
									),
								),
							),
						),
					),
				),
			)
		);

		$elem->add_responsive_control(
			'forecast_item_gap',
			array(
				'label'      => __( 'Spacing', 'premium-addons-for-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', 'em', '%' ),
				'range'      => array(
					'px' => array(
						'min' => 0,
						'max' => 1000,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .premium-weather__forecast-item-data'  => 'gap: {{SIZE}}{{UNIT}}',
				),
				'condition'  => array(
					'enable_forecast'  => 'yes',
					'forecast_layouts' => 'style-4',
				),
			)
		);

		$elem->add_control(
			'height',
			array(
				'label'       => __( 'Height', 'premium-addons-for-elementor' ),
				'type'        => Controls_Manager::SLIDER,
				'render_type' => 'template',
				'size_units'  => array( 'px' ),
				'selectors'   => array(
					'{{WRAPPER}} .premium-weather__forecast'  => 'height: {{SIZE}}px; overflow-y: auto;',
				),
				'range'       => array(
					'px' => array(
						'min' => 0,
						'max' => 1000,
					),
				),
				'condition'   => array(
					'enable_forecast'  => 'yes',
					'forecast_layouts' => 'style-4',
				),
			)
		);

		$elem->add_responsive_control(
			'weather_ele_min_width',
			array(
				'label'      => __( 'Element Minimum Width', 'premium-addons-for-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'selectors'  => array(
					'{{WRAPPER}}:not(.premium-forecast-tabs-yes) .premium-weather__forecast-item-data > *:not(.premium-weather__icon-wrapper)'  => 'min-width: {{SIZE}}px;',
					'{{WRAPPER}}.premium-forecast-tabs-yes .premium-weather__hourly-item > *,
					{{WRAPPER}}.premium-forecast-tabs-yes .premium-weather__weather-indicators > *'  => 'min-width: {{SIZE}}px;',
				),
				'range'      => array(
					'px' => array(
						'min' => 0,
						'max' => 1000,
					),
				),
				'conditions' => array(
					'relation' => 'or',
					'terms'    => array(
						array(
							'terms' => array(
								array(
									'name'  => 'enable_forecast',
									'value' => 'yes',
								),
								array(
									'name'  => 'forecast_layouts',
									'value' => 'style-4',
								),
							),
						),
						array(
							'terms' => array(
								array(
									'name'  => 'enable_forecast',
									'value' => 'yes',
								),
								array(
									'name'  => 'forecast_tabs',
									'value' => 'yes',
								),
							),
						),
					),
				),
			)
		);

		$elem->add_control(
			'forecast_tabs',
			array(
				'label'        => __( 'Activate Tabs', 'premium-addons-for-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'description'  => __( 'Display 5 days weather forecast data with 3-hour step', 'premium-addons-for-elementor' ),
				'render_type'  => 'template',
				'prefix_class' => 'premium-forecast-tabs-',
				'separator'    => 'before',
				'condition'    => array(
					'enable_forecast' => 'yes',
					'forecast_days!'  => array( '1', '6', '7', '8' ),
				),
			)
		);

		$elem->add_control(
			'forecast_dates',
			array(
				'label'          => __( 'Date', 'premium-addons-for-elementor' ),
				'description'    => __( 'Use this to display specific dates', 'premium-addons-for-elementor' ),
				'type'           => Controls_Manager::DATE_TIME,
				'picker_options' => array(
					'format'     => 'y-m-d',
					'enableTime' => false,
					'mode'       => 'multiple',
				),
				'dynamic'        => array(
					'active' => true,
				),
				'condition'      => array(
					'enable_forecast' => 'yes',
					'forecast_days!'  => array( '1', '6', '7', '8' ),
					'forecast_tabs'   => 'yes',
				),
			)
		);

		$elem->add_control(
			'date_format',
			array(
				'label'       => __( 'Date Format', 'premium-addons-for-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'label_block' => true,
				'description' => __( 'Know more abour date format from ', 'premium-addons-for-elementor' ) . '<a href="https://wordpress.org/documentation/article/customize-date-and-time-format/" target="_blank">here</a>',
				'default'     => 'F j',
				'condition'   => array(
					'enable_forecast' => 'yes',
					'forecast_days!'  => array( '1', '6', '7', '8' ),
					'forecast_tabs'   => 'yes',
				),
			)
		);

		$elem->add_control(
			'tabs_weather_data',
			array(
				'label'       => __( 'Weather Data', 'premium-addons-for-elementor' ),
				'type'        => Controls_Manager::SELECT2,
				'label_block' => true,
				'options'     => array(
					'temp'       => __( 'Temperature', 'premium-addons-for-elementor' ),
					'desc'       => __( 'Description', 'premium-addons-for-elementor' ),
					'desc_icon'  => __( 'Weather Icon', 'premium-addons-for-elementor' ),
					'wind'       => __( 'Wind Speed', 'premium-addons-for-elementor' ),
					'pressure'   => __( 'Pressure', 'premium-addons-for-elementor' ),
					'humidity'   => __( 'Humidity', 'premium-addons-for-elementor' ),
					'wind_dir'   => __( 'Wind Direction', 'premium-addons-for-elementor' ),
					'feels_like' => __( 'Feels Like', 'premium-addons-for-elementor' ),
				),
				'default'     => array( 'desc_icon', 'temp', 'pressure', 'humidity', 'wind' ),
				'multiple'    => true,
				'condition'   => array(
					'enable_forecast' => 'yes',
					'forecast_days!'  => array( '1', '6', '7', '8' ),
					'forecast_tabs'   => 'yes',
				),
			)
		);

		$elem->add_control(
			'tabs_hourly_max',
			array(
				'label'       => __( 'Max Number of Hours', 'premium-addons-for-elementor' ),
				'type'        => Controls_Manager::NUMBER,
				'description' => __( 'Set a maximum number of hours to display up to 8 hours/day', 'premium-addons-for-elementor' ),
				'default'     => 8,
				'max'         => 8,
				'min'         => 1,
				'condition'   => array(
					'enable_forecast' => 'yes',
					'forecast_days!'  => array( '1', '6', '7', '8' ),
					'forecast_tabs'   => 'yes',
				),
			)
		);

		$elem->add_control(
			'date_notice',
			array(
				'label'       => __( 'Expire Message', 'premium-addons-for-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'label_block' => true,
				'description' => __( 'A message to show when no forecast data available for a chosen day.', 'premium-addons-for-elementor' ),
				'default'     => 'No Data Available',
				'condition'   => array(
					'enable_forecast' => 'yes',
					'forecast_days!'  => array( '1', '6', '7', '8' ),
					'forecast_tabs'   => 'yes',
					'forecast_dates!' => '',
				),
			)
		);

		$elem->add_control(
			'forecast_carousel_sw',
			array(
				'label'        => __( 'Activate Carousel', 'premium-addons-for-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'render_type'  => 'template',
				'prefix_class' => 'premium-forecast-carousel-',
				'separator'    => 'before',
				'condition'    => array(
					'enable_forecast'   => 'yes',
					'forecast_tabs!'    => 'yes',
					'forecast_layouts!' => 'style-4',
				),
			)
		);

		$elem->add_responsive_control(
			'daily_slides_to_show',
			array(
				'label'     => __( 'Slides To Show', 'premium-addons-for-elementor' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 4,
				'max'       => 8,
				'min'       => 1,
				'condition' => array(
					'enable_forecast'      => 'yes',
					'forecast_tabs!'       => 'yes',
					'forecast_layouts!'    => 'style-4',
					'forecast_carousel_sw' => 'yes',
				),
			)
		);

		$elem->add_control(
			'show_daily_arrows_on_hover',
			array(
				'label'        => __( 'Show Arrows On Hover', 'premium-addons-for-elementor' ),
				'prefix_class' => 'premium-daily-hidden-arrows-',
				'type'         => Controls_Manager::SWITCHER,
				'default'      => 'yes',
				'condition'    => array(
					'enable_forecast'      => 'yes',
					'forecast_tabs!'       => 'yes',
					'forecast_layouts!'    => 'style-4',
					'forecast_carousel_sw' => 'yes',
				),
			)
		);

	}

	/**
	 * Add Weather Custom Icons Controls
	 *
	 * @since 2.6.0
	 * @access public
	 *
	 * @param object $elem elementor element.
	 */
	public function add_weather_custom_icons_controls( $elem ) {

		$elem->add_control(
			'icons_source',
			array(
				'label'     => __( 'Icons Type', 'premium-addons-for-elementor' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => array(
					'default' => __( 'Lottie Icons', 'premium-addons-for-elementor' ),
					'custom'  => __( 'Upload Your Own', 'premium-addons-for-elementor' ),
				),
				'default'   => 'default',
				'condition' => array(
					'enable_custom_icon' => 'yes',
				),
			)
		);

		$elem->add_control(
			'lottie_type',
			array(
				'label'       => __( 'Type', 'premium-addons-for-elementor' ),
				'type'        => Controls_Manager::SELECT,
				'render_type' => 'template',
				'options'     => array(
					'filled'   => __( 'Filled', 'premium-addons-for-elementor' ),
					'outlined' => __( 'Outlined', 'premium-addons-for-elementor' ),
				),
				'default'     => 'filled',
				'condition'   => array(
					'enable_custom_icon' => 'yes',
					'icons_source'       => 'default',
				),
			)
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'weather_desc',
			array(
				'label'   => __( 'Weather Condition', 'premium-addons-for-elementor' ),
				'type'    => Controls_Manager::SELECT,
				'options' => array(
					'Clear Sky'        => __( 'Clear Sky', 'premium-addons-for-elementor' ),
					'Few Clouds'       => __( 'Few Clouds', 'premium-addons-for-elementor' ),
					'Scattered Clouds' => __( 'Scattered Clouds', 'premium-addons-for-elementor' ),
					'Broken Clouds'    => __( 'Broken Clouds', 'premium-addons-for-elementor' ),
					'Shower Rain'      => __( 'Shower Rain', 'premium-addons-for-elementor' ),
					'Rain'             => __( 'Rain', 'premium-addons-for-elementor' ),
					'Thunderstorm'     => __( 'Thunderstorm', 'premium-addons-for-elementor' ),
					'Snow'             => __( 'Snow', 'premium-addons-for-elementor' ),
					'Mist'             => __( 'Mist', 'premium-addons-for-elementor' ),
				),
				'default' => 'Clear Sky',
			)
		);

		$repeater->add_control(
			'pa_icon_type',
			array(
				'label'       => __( 'Icon Type', 'premium-addons-for-elementor' ),
				'type'        => Controls_Manager::SELECT,
				'render_type' => 'template',
				'options'     => array(
					'icon'   => __( 'Icon', 'premium-addons-for-elementor' ),
					'image'  => __( 'Image', 'premium-addons-for-elementor' ),
					'lottie' => __( 'Lottie', 'premium-addons-for-elementor' ),
				),
				'default'     => 'icon',
			)
		);

		$repeater->add_control(
			'pa_custom_icon',
			array(
				'label'     => __( 'Day Icon', 'premium-addons-for-elementor' ),
				'type'      => Controls_Manager::ICONS,
				'default'   => array(
					'value'   => 'fas fa-cloud',
					'library' => 'solid',
				),
				'skin'      => 'inline',
				'condition' => array(
					'pa_icon_type' => 'icon',
				),
			)
		);

		$repeater->add_control(
			'pa_custom_icon_night',
			array(
				'label'     => __( 'Night Icon', 'premium-addons-for-elementor' ),
				'type'      => Controls_Manager::ICONS,
				'default'   => array(
					'value'   => 'fas fa-cloud',
					'library' => 'solid',
				),
				'skin'      => 'inline',
				'condition' => array(
					'pa_icon_type' => 'icon',
					'weather_desc' => array( 'Clear Sky', 'Few Clouds', 'Rain' ),
				),
			)
		);

		$repeater->add_control(
			'pa_weather_img',
			array(
				'label'     => __( 'Day Image', 'premium-addons-for-elementor' ),
				'type'      => Controls_Manager::MEDIA,
				'condition' => array(
					'pa_icon_type' => 'image',
				),
			)
		);

		$repeater->add_control(
			'pa_weather_img_night',
			array(
				'label'     => __( 'Night Image', 'premium-addons-for-elementor' ),
				'type'      => Controls_Manager::MEDIA,
				'condition' => array(
					'pa_icon_type' => 'image',
					'weather_desc' => array( 'Clear Sky', 'Few Clouds', 'Rain' ),
				),
			)
		);

		$repeater->add_group_control(
			Group_Control_Image_Size::get_type(),
			array(
				'name'      => 'image',
				'default'   => 'thumbnail',
				'condition' => array(
					'pa_icon_type' => 'image',
				),
			)
		);

		$repeater->add_control(
			'pa_lottie_url',
			array(
				'label'       => __( 'Day Icon JSON URL', 'premium-addons-for-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'description' => 'Get JSON code URL from <a href="https://lottiefiles.com/" target="_blank">here</a>',
				'label_block' => true,
				'condition'   => array(
					'pa_icon_type' => 'lottie',
				),
			)
		);

		$repeater->add_control(
			'pa_lottie_url_night',
			array(
				'label'       => __( 'Night Icon JSON URL', 'premium-addons-for-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'description' => 'Leave empty to use the same icon for both day and night time.',
				'label_block' => true,
				'condition'   => array(
					'pa_icon_type' => 'lottie',
					'weather_desc' => array( 'Clear Sky', 'Few Clouds', 'Rain' ),
				),
			)
		);

		$repeater->add_control(
			'pa_lottie_loop',
			array(
				'label'        => __( 'Loop', 'premium-addons-for-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'return_value' => 'true',
				'default'      => 'true',
				'condition'    => array(
					'pa_icon_type' => 'lottie',
				),
			)
		);

		$repeater->add_control(
			'pa_lottie_reverse',
			array(
				'label'        => __( 'Reverse', 'premium-addons-for-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'return_value' => 'true',
				'condition'    => array(
					'pa_icon_type' => 'lottie',
				),
			)
		);

		$icons = $repeater->get_controls();

		$elem->add_control(
			'custom_icons',
			array(
				'label'       => esc_html__( 'Icons List', 'premium-addons-for-elementor' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $icons,
				'title_field' => '{{{ weather_desc }}}',
				'condition'   => array(
					'enable_custom_icon' => 'yes',
					'icons_source'       => 'custom',
				),
			)
		);

	}

	/**
	 * Run Modules Extender
	 *
	 * Extendes the free modules with extra options
	 *
	 * @since 2.6.0
	 * @access public
	 *
	 * @param array $data conditions data.
	 */
	public function extend_display_conditions_options( $data ) {

		$conditions = $data;

		$conditions['urlparams']['label'] = __( 'URL', 'premium-addons-pro' );
		$conditions['misc']['label']      = __( 'Misc', 'premium-addons-pro' );

		if ( class_exists( 'woocommerce' ) ) {
			$conditions['woocommerce']['label'] = __( 'WooCommerce', 'premium-addons-pro' );
		}

		if ( class_exists( 'ACF' ) ) {
			$conditions['acf']['label'] = __( 'ACF', 'premium-addons-pro' );
		}

		$data = $conditions;

		return $data;

	}

	/**
	 * Extend Display Conditions Keys
	 *
	 * Extends display conditions modules keys used to register controls
	 *
	 * @since 2.6.0
	 * @access public
	 *
	 * @param array $keys conditions keys.
	 */
	public function extend_display_conditions_keys( $keys ) {

		$keys = array_merge(
			array(
				'url_string',
				'url_referer',
				'shortcode',
			),
			$keys
		);

		if ( class_exists( 'ACF' ) ) {

			$keys = array_merge(
				array(
					'acf_text',
					'acf_boolean',
					'acf_choice',
				),
				$keys
			);

		}

		if ( class_exists( 'woocommerce' ) ) {

			$keys = array_merge(
				array(
					'woo_cat_page',
					'woo_product_cat',
					'woo_product_price',
					'woo_product_stock',
					'woo_orders',
					'woo_category',
					'woo_last_purchase',
					'woo_total_price',
					'woo_cart_products',
				),
				$keys
			);

		}

		return $keys;
	}

	/**
	 * Changes the conditions for display conditions options
	 *
	 * @since 2.6.0
	 * @access public
	 *
	 * @param array $conditions controls conditions.
	 */
	public function extend_pro_display_conditions( $conditions ) {

		$options_conditions = array( '' );

		return $options_conditions;

	}

	/**
	 * Add Opacity Controls
	 *
	 * Extends Floating Effects Opacity controls.
	 *
	 * @since 2.6.0
	 * @access public
	 *
	 * @param object $elem elementor element.
	 */
	public function add_opacity_controls( $elem ) {

		$elem->add_control(
			'premium_fe_opacity',
			array(
				'label'     => __( 'Value', 'premium-addons-pro' ),
				'type'      => Controls_Manager::SLIDER,
				'default'   => array(
					'sizes' => array(
						'from' => 0,
						'to'   => 50,
					),
					'unit'  => '%',
				),
				'labels'    => array(
					__( 'From', 'premium-addons-pro' ),
					__( 'To', 'premium-addons-pro' ),
				),
				'scales'    => 1,
				'handles'   => 'range',
				'condition' => array(
					'premium_fe_switcher'         => 'yes',
					'premium_fe_opacity_switcher' => 'yes',
				),
			)
		);

		$elem->add_control(
			'premium_fe_opacity_duration',
			array(
				'label'     => __( 'Duration', 'premium-addons-pro' ) . ' (ms)',
				'type'      => Controls_Manager::SLIDER,
				'range'     => array(
					'px' => array(
						'min'  => 0,
						'max'  => 10000,
						'step' => 100,
					),
				),
				'default'   => array(
					'unit' => 'px',
					'size' => 1000,
				),
				'condition' => array(
					'premium_fe_switcher'         => 'yes',
					'premium_fe_opacity_switcher' => 'yes',
				),
			)
		);

		$elem->add_control(
			'premium_fe_opacity_delay',
			array(
				'label'     => __( 'Delay', 'premium-addons-pro' ) . ' (ms)',
				'type'      => Controls_Manager::SLIDER,
				'range'     => array(
					'px' => array(
						'min'  => 0,
						'max'  => 10000,
						'step' => 100,
					),
				),
				'condition' => array(
					'premium_fe_switcher'         => 'yes',
					'premium_fe_opacity_switcher' => 'yes',
				),

			)
		);

	}

	/**
	 * Add Background Controls
	 *
	 * Extends Floating Effects Background controls.
	 *
	 * @since 2.6.0
	 * @access public
	 *
	 * @param object $elem elementor element.
	 */
	public function add_bg_controls( $elem ) {

		$elem->add_control(
			'premium_fe_bg_color_from',
			array(
				'label'     => __( 'From', 'premium-addons-pro' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => array(
					'default' => Global_Colors::COLOR_PRIMARY,
				),
				'condition' => array(
					'premium_fe_switcher'          => 'yes',
					'premium_fe_bg_color_switcher' => 'yes',
				),
			)
		);

		$elem->add_control(
			'premium_fe_bg_color_to',
			array(
				'label'     => __( 'To', 'premium-addons-pro' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => array(
					'default' => Global_Colors::COLOR_PRIMARY,
				),
				'condition' => array(
					'premium_fe_switcher'          => 'yes',
					'premium_fe_bg_color_switcher' => 'yes',
				),
			)
		);

		$elem->add_control(
			'premium_fe_bg_color_duration',
			array(
				'label'     => __( 'Duration', 'premium-addons-pro' ) . ' (ms)',
				'type'      => Controls_Manager::SLIDER,
				'range'     => array(
					'px' => array(
						'min'  => 0,
						'max'  => 10000,
						'step' => 100,
					),
				),
				'default'   => array(
					'unit' => 'px',
					'size' => 1000,
				),
				'condition' => array(
					'premium_fe_switcher'          => 'yes',
					'premium_fe_bg_color_switcher' => 'yes',
				),
			)
		);

		$elem->add_control(
			'premium_fe_bg_color_delay',
			array(
				'label'     => __( 'Delay', 'premium-addons-pro' ) . ' (ms)',
				'type'      => Controls_Manager::SLIDER,
				'range'     => array(
					'px' => array(
						'min'  => 0,
						'max'  => 10000,
						'step' => 100,
					),
				),
				'condition' => array(
					'premium_fe_switcher'          => 'yes',
					'premium_fe_bg_color_switcher' => 'yes',
				),

			)
		);

	}

	/**
	 * Add Blur Controls
	 *
	 * Extends Floating Effects Blur controls.
	 *
	 * @since 2.6.0
	 * @access public
	 *
	 * @param object $elem elementor element.
	 */
	public function add_blur_controls( $elem ) {

		$elem->add_control(
			'premium_fe_blur_val',
			array(
				'label'     => __( 'Value', 'premium-addons-pro' ),
				'type'      => Controls_Manager::SLIDER,
				'default'   => array(
					'sizes' => array(
						'from' => 0,
						'to'   => 1,
					),
					'unit'  => 'px',
				),
				'range'     => array(
					'px' => array(
						'min'  => 0,
						'max'  => 3,
						'step' => 0.1,
					),
				),
				'labels'    => array(
					__( 'From', 'premium-addons-pro' ),
					__( 'To', 'premium-addons-pro' ),
				),
				'scales'    => 1,
				'handles'   => 'range',
				'condition' => array(
					'premium_fe_switcher'      => 'yes',
					'premium_fe_blur_switcher' => 'yes',
				),
			)
		);

		$elem->add_control(
			'premium_fe_blur_duration',
			array(
				'label'     => __( 'Duration', 'premium-addons-pro' ) . ' (ms)',
				'type'      => Controls_Manager::SLIDER,
				'range'     => array(
					'px' => array(
						'min'  => 0,
						'max'  => 10000,
						'step' => 100,
					),
				),
				'default'   => array(
					'unit' => 'px',
					'size' => 1000,
				),
				'condition' => array(
					'premium_fe_switcher'      => 'yes',
					'premium_fe_blur_switcher' => 'yes',
				),
			)
		);

		$elem->add_control(
			'premium_fe_blur_delay',
			array(
				'label'     => __( 'Delay', 'premium-addons-pro' ) . ' (ms)',
				'type'      => Controls_Manager::SLIDER,
				'range'     => array(
					'px' => array(
						'min'  => 0,
						'max'  => 10000,
						'step' => 100,
					),
				),
				'condition' => array(
					'premium_fe_switcher'      => 'yes',
					'premium_fe_blur_switcher' => 'yes',
				),

			)
		);

	}

	/**
	 * Add Contrast Controls
	 *
	 * Extends Floating Effects Contrast controls.
	 *
	 * @since 2.6.0
	 * @access public
	 *
	 * @param object $elem elementor element.
	 */
	public function add_contrast_controls( $elem ) {

		$elem->add_control(
			'premium_fe_contrast_val',
			array(
				'label'     => __( 'Value', 'premium-addons-pro' ),
				'type'      => Controls_Manager::SLIDER,
				'default'   => array(
					'sizes' => array(
						'from' => 0,
						'to'   => 50,
					),
					'unit'  => '%',
				),
				'range'     => array(
					'%' => array(
						'min'  => 0,
						'max'  => 200,
						'step' => 10,
					),
				),
				'labels'    => array(
					__( 'From', 'premium-addons-pro' ),
					__( 'To', 'premium-addons-pro' ),
				),
				'scales'    => 1,
				'handles'   => 'range',
				'condition' => array(
					'premium_fe_switcher'          => 'yes',
					'premium_fe_contrast_switcher' => 'yes',
				),
			)
		);

		$elem->add_control(
			'premium_fe_contrast_duration',
			array(
				'label'     => __( 'Duration', 'premium-addons-pro' ) . ' (ms)',
				'type'      => Controls_Manager::SLIDER,
				'range'     => array(
					'px' => array(
						'min'  => 0,
						'max'  => 10000,
						'step' => 100,
					),
				),
				'default'   => array(
					'unit' => 'px',
					'size' => 1000,
				),
				'condition' => array(
					'premium_fe_switcher'          => 'yes',
					'premium_fe_contrast_switcher' => 'yes',
				),
			)
		);

		$elem->add_control(
			'premium_fe_contrast_delay',
			array(
				'label'     => __( 'Delay', 'premium-addons-pro' ) . ' (ms)',
				'type'      => Controls_Manager::SLIDER,
				'range'     => array(
					'px' => array(
						'min'  => 0,
						'max'  => 10000,
						'step' => 100,
					),
				),
				'condition' => array(
					'premium_fe_switcher'          => 'yes',
					'premium_fe_contrast_switcher' => 'yes',
				),

			)
		);

	}

	/**
	 * Add Grayscale Controls
	 *
	 * Extends Floating Effects Grayscale controls.
	 *
	 * @since 2.6.0
	 * @access public
	 *
	 * @param object $elem elementor element.
	 */
	public function add_gs_controls( $elem ) {

		$elem->add_control(
			'premium_fe_gScale_val',
			array(
				'label'     => __( 'Value', 'premium-addons-pro' ),
				'type'      => Controls_Manager::SLIDER,
				'default'   => array(
					'sizes' => array(
						'from' => 0,
						'to'   => 50,
					),
					'unit'  => '%',
				),
				'labels'    => array(
					__( 'From', 'premium-addons-pro' ),
					__( 'To', 'premium-addons-pro' ),
				),
				'scales'    => 1,
				'handles'   => 'range',
				'condition' => array(
					'premium_fe_switcher'        => 'yes',
					'premium_fe_gScale_switcher' => 'yes',
				),
			)
		);

		$elem->add_control(
			'premium_fe_gScale_duration',
			array(
				'label'     => __( 'Duration', 'premium-addons-pro' ) . ' (ms)',
				'type'      => Controls_Manager::SLIDER,
				'range'     => array(
					'px' => array(
						'min'  => 0,
						'max'  => 10000,
						'step' => 100,
					),
				),
				'default'   => array(
					'unit' => 'px',
					'size' => 1000,
				),
				'condition' => array(
					'premium_fe_switcher'        => 'yes',
					'premium_fe_gScale_switcher' => 'yes',
				),
			)
		);

		$elem->add_control(
			'premium_fe_gScale_delay',
			array(
				'label'     => __( 'Delay', 'premium-addons-pro' ) . ' (ms)',
				'type'      => Controls_Manager::SLIDER,
				'range'     => array(
					'px' => array(
						'min'  => 0,
						'max'  => 10000,
						'step' => 100,
					),
				),
				'condition' => array(
					'premium_fe_switcher'        => 'yes',
					'premium_fe_gScale_switcher' => 'yes',
				),

			)
		);

	}

	/**
	 * Add Hue Controls
	 *
	 * Extends Floating Effects Hue controls.
	 *
	 * @since 2.6.0
	 * @access public
	 *
	 * @param object $elem elementor element.
	 */
	public function add_hue_controls( $elem ) {

		$elem->add_control(
			'premium_fe_hue_val',
			array(
				'label'     => __( 'Value', 'premium-addons-pro' ),
				'type'      => Controls_Manager::SLIDER,
				'default'   => array(
					'sizes' => array(
						'from' => 0,
						'to'   => 90,
					),
					'unit'  => 'deg',
				),
				'range'     => array(
					'deg' => array(
						'min'  => 0,
						'max'  => 360,
						'step' => 10,
					),
				),
				'labels'    => array(
					__( 'From', 'premium-addons-pro' ),
					__( 'To', 'premium-addons-pro' ),
				),
				'scales'    => 1,
				'handles'   => 'range',
				'condition' => array(
					'premium_fe_switcher'     => 'yes',
					'premium_fe_hue_switcher' => 'yes',
				),
			)
		);

		$elem->add_control(
			'premium_fe_hue_duration',
			array(
				'label'     => __( 'Duration', 'premium-addons-pro' ) . ' (ms)',
				'type'      => Controls_Manager::SLIDER,
				'range'     => array(
					'px' => array(
						'min'  => 0,
						'max'  => 10000,
						'step' => 100,
					),
				),
				'default'   => array(
					'unit' => 'px',
					'size' => 1000,
				),
				'condition' => array(
					'premium_fe_switcher'     => 'yes',
					'premium_fe_hue_switcher' => 'yes',
				),
			)
		);

		$elem->add_control(
			'premium_fe_hue_delay',
			array(
				'label'     => __( 'Delay', 'premium-addons-pro' ) . ' (ms)',
				'type'      => Controls_Manager::SLIDER,
				'range'     => array(
					'px' => array(
						'min'  => 0,
						'max'  => 10000,
						'step' => 100,
					),
				),
				'condition' => array(
					'premium_fe_switcher'     => 'yes',
					'premium_fe_hue_switcher' => 'yes',
				),

			)
		);

	}

	/**
	 * Add Brightness Controls
	 *
	 * Extends Floating Effects Brightness controls.
	 *
	 * @since 2.6.0
	 * @access public
	 *
	 * @param object $elem elementor element.
	 */
	public function add_brightness_controls( $elem ) {

		$elem->add_control(
			'premium_fe_brightness_val',
			array(
				'label'     => __( 'Value', 'premium-addons-pro' ),
				'type'      => Controls_Manager::SLIDER,
				'default'   => array(
					'sizes' => array(
						'from' => 0,
						'to'   => 50,
					),
					'unit'  => '%',
				),
				'range'     => array(
					'%' => array(
						'min'  => 0,
						'max'  => 200,
						'step' => 10,
					),
				),
				'labels'    => array(
					__( 'From', 'premium-addons-pro' ),
					__( 'To', 'premium-addons-pro' ),
				),
				'scales'    => 1,
				'handles'   => 'range',
				'condition' => array(
					'premium_fe_switcher'            => 'yes',
					'premium_fe_brightness_switcher' => 'yes',
				),
			)
		);

		$elem->add_control(
			'premium_fe_brightness_duration',
			array(
				'label'     => __( 'Duration', 'premium-addons-pro' ) . ' (ms)',
				'type'      => Controls_Manager::SLIDER,
				'range'     => array(
					'px' => array(
						'min'  => 0,
						'max'  => 10000,
						'step' => 100,
					),
				),
				'default'   => array(
					'unit' => 'px',
					'size' => 1000,
				),
				'condition' => array(
					'premium_fe_switcher'            => 'yes',
					'premium_fe_brightness_switcher' => 'yes',
				),
			)
		);

		$elem->add_control(
			'premium_fe_brightness_delay',
			array(
				'label'     => __( 'Delay', 'premium-addons-pro' ) . ' (ms)',
				'type'      => Controls_Manager::SLIDER,
				'range'     => array(
					'px' => array(
						'min'  => 0,
						'max'  => 10000,
						'step' => 100,
					),
				),
				'condition' => array(
					'premium_fe_switcher'            => 'yes',
					'premium_fe_brightness_switcher' => 'yes',
				),

			)
		);

	}

	/**
	 * Add Saturation Controls
	 *
	 * Extends Floating Effects Saturation controls.
	 *
	 * @since 2.6.0
	 * @access public
	 *
	 * @param object $elem elementor element.
	 */
	public function add_saturation_controls( $elem ) {

		$elem->add_control(
			'premium_fe_saturate_val',
			array(
				'label'     => __( 'Value', 'premium-addons-pro' ),
				'type'      => Controls_Manager::SLIDER,
				'default'   => array(
					'sizes' => array(
						'from' => 0,
						'to'   => 50,
					),
					'unit'  => '%',
				),
				'range'     => array(
					'%' => array(
						'min'  => 0,
						'max'  => 200,
						'step' => 10,
					),
				),
				'labels'    => array(
					__( 'From', 'premium-addons-pro' ),
					__( 'To', 'premium-addons-pro' ),
				),
				'scales'    => 1,
				'handles'   => 'range',
				'condition' => array(
					'premium_fe_switcher'          => 'yes',
					'premium_fe_saturate_switcher' => 'yes',
				),
			)
		);

		$elem->add_control(
			'premium_fe_saturate_duration',
			array(
				'label'     => __( 'Duration', 'premium-addons-pro' ) . ' (ms)',
				'type'      => Controls_Manager::SLIDER,
				'range'     => array(
					'px' => array(
						'min'  => 0,
						'max'  => 10000,
						'step' => 100,
					),
				),
				'default'   => array(
					'unit' => 'px',
					'size' => 1000,
				),
				'condition' => array(
					'premium_fe_switcher'          => 'yes',
					'premium_fe_saturate_switcher' => 'yes',
				),
			)
		);

		$elem->add_control(
			'premium_fe_saturate_delay',
			array(
				'label'     => __( 'Delay', 'premium-addons-pro' ) . ' (ms)',
				'type'      => Controls_Manager::SLIDER,
				'range'     => array(
					'px' => array(
						'min'  => 0,
						'max'  => 10000,
						'step' => 100,
					),
				),
				'condition' => array(
					'premium_fe_switcher'          => 'yes',
					'premium_fe_saturate_switcher' => 'yes',
				),

			)
		);

	}

	/**
	 * Add Maps Marker Controls
	 *
	 * @since 2.8.20
	 * @access public
	 *
	 * @param object $element elementor element.
	 */
	public function add_maps_marker_controls( $element ) {

		$element->add_control(
			'marker_skin',
			array(
				'label'     => __( 'Skin', 'premium-addons-pro' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => array(
					'skin1' => __( 'Google Default', 'premium-addons-pro' ),
					'skin3' => __( 'Inline Skin', 'premium-addons-pro' ),
					'skin2' => __( 'Block Skin', 'premium-addons-pro' ),
				),
				'default'   => 'skin1',
				'condition' => array(
					'advanced_view' => 'yes',
				),
			)
		);

		$element->add_control(
			'pin_img',
			array(
				'label'     => __( 'Image', 'premium-addons-pro' ),
				'type'      => Controls_Manager::MEDIA,
				'default'   => array(
					'url' => Utils::get_placeholder_image_src(),
				),
				'condition' => array(
					'advanced_view' => 'yes',
				),
			)
		);

		$element->add_control(
			'pin_address',
			array(
				'label'       => __( 'Address', 'premium-addons-pro' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => '20 W 34th St., New York, NY, USA',
				'condition'   => array(
					'advanced_view' => 'yes',
				),
			)
		);

		$element->add_control(
			'pin_website',
			array(
				'label'       => __( 'Website', 'premium-addons-pro' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => 'www.premiumaddons.com',
				'condition'   => array(
					'advanced_view' => 'yes',
				),
			)
		);

		$element->add_control(
			'pin_phone',
			array(
				'label'       => __( 'Phone Number', 'premium-addons-pro' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => '+12127363100',
				'condition'   => array(
					'advanced_view' => 'yes',
				),
			)
		);

		$element->add_control(
			'pin_hours',
			array(
				'label'       => __( 'Working Hours', 'premium-addons-pro' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => '10AM-10PM',
				'condition'   => array(
					'advanced_view' => 'yes',
				),
			)
		);

	}


	/**
	 * Class Constructor
	 */
	public function __construct() {

		$this->require_files();
		$this->register_modules();

		$this->run_modules_extender();

	}

}
