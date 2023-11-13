<?php
/**
 * Class: Premium_Divider
 * Name: Divider
 * Slug: premium-divider
 */

namespace PremiumAddonsPro\Widgets;

// PremiumAddonsPro Classes.
use PremiumAddonsPro\Includes\PAPRO_Helper;

// Elementor Classes.
use Elementor\Widget_Base;
use Elementor\Icons_Manager;
use Elementor\Controls_Manager;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Image_Size;

// PremiumAddons Classes.
use PremiumAddons\Admin\Includes\Admin_Helper;
use PremiumAddons\Includes\Helper_Functions;
use PremiumAddons\Includes\Premium_Template_Tags;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Premium_Divider
 */
class Premium_Divider extends Widget_Base {

	/**
	 * Check Icon Draw Option.
	 *
	 * @since 2.8.4
	 * @access public
	 */
	public function check_icon_draw() {

		if ( version_compare( PREMIUM_ADDONS_VERSION, '4.9.26', '<' ) ) {
			return false;
		}

		$is_enabled = Admin_Helper::check_svg_draw( 'premium-divider' );
		return $is_enabled;
	}

	/**
	 * Template Instance
	 *
	 * @var template_instance
	 */
	protected $template_instance;

	/**
	 * Get Elementor Helper Instance.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function getTemplateInstance() {
		return $this->template_instance = Premium_Template_Tags::getInstance();
	}

	/**
	 * Retrieve Widget Name.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function get_name() {
		return 'premium-divider';
	}

	/**
	 * Retrieve Widget Title.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function get_title() {
		return __( 'Divider', 'premium-addons-pro' );
	}

	/**
	 * Retrieve Widget Icon.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string widget icon.
	 */
	public function get_icon() {
		return 'pa-pro-separator';
	}

	/**
	 * Retrieve Widget Categories.
	 *
	 * @since 1.5.1
	 * @access public
	 *
	 * @return array Widget categories.
	 */
	public function get_categories() {
		return array( 'premium-elements' );
	}

	/**
	 * Retrieve Widget Keywords.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget keywords.
	 */
	public function get_keywords() {
		return array( 'pa', 'premium', 'lottie', 'separator' );
	}

	/**
	 * Retrieve Widget Dependent CSS.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return array CSS style handles.
	 */
	public function get_style_depends() {
		return array(
			'premium-pro',
		);
	}

	/**
	 * Retrieve Widget Dependent JS.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return array JS script handles.
	 */
	public function get_script_depends() {

		$draw_scripts = $this->check_icon_draw() ? array(
			'pa-fontawesome-all',
			'pa-tweenmax',
			'pa-motionpath',
		) : array();

		return array_merge(
			$draw_scripts,
			array(
				'lottie-js',
				'premium-pro',
			)
		);
	}

	/**
	 * Retrieve Widget Support URL.
	 *
	 * @access public
	 *
	 * @return string support URL.
	 */
	public function get_custom_help_url() {
		return 'https://premiumaddons.com/support/';
	}

	/**
	 * Register Divider controls.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function register_controls() { // phpcs:ignore PSR2.Methods.MethodDeclaration.Underscore

		$draw_icon = $this->check_icon_draw();

		$this->start_controls_section(
			'separator_section',
			array(
				'label' => __( 'Separator', 'premium-addons-pro' ),
			)
		);

		$this->add_control(
			'content_lines_Number',
			array(
				'label'       => __( 'Number of Lines', 'premium-addons-pro' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'separators_one_span'   => __( 'One', 'premium-addons-pro' ),
					'separators_two_span'   => __( 'Two', 'premium-addons-pro' ),
					'separators_three_span' => __( 'Three', 'premium-addons-pro' ),
					'separators_four_span'  => __( 'Four', 'premium-addons-pro' ),
					'separators_five_span'  => __( 'Five', 'premium-addons-pro' ),
				),
				'default'     => 'separators_one_span',
				'label_block' => true,
			)
		);

		$this->add_control(
			'left_and_right_separator_type',
			array(
				'label'   => __( 'Style', 'premium-addons-pro' ),
				'type'    => Controls_Manager::SELECT,
				'options' => array(
					'solid'     => __( 'Solid', 'premium-addons-pro' ),
					'double'    => __( 'Double', 'premium-addons-pro' ),
					'dotted'    => __( 'Dotted', 'premium-addons-pro' ),
					'dashed'    => __( 'Dashed', 'premium-addons-pro' ),
					'groove'    => __( 'Groove', 'premium-addons-pro' ),
					'shadow'    => __( 'Shadow', 'premium-addons-pro' ),
					'gradient'  => __( 'Gradient', 'premium-addons-pro' ),
					'curvedbot' => __( 'Curved Bottom', 'premium-addons-pro' ),
					'curvedtop' => __( 'Curved Top', 'premium-addons-pro' ),
					'custom'    => __( 'Custom', 'premium-addons-pro' ),
				),
				'default' => 'solid',
			)
		);

		$this->add_control(
			'left_separator_image',
			array(
				'label'       => __( 'Left Line Image', 'premium-addons-pro' ),
				'type'        => Controls_Manager::MEDIA,
				'dynamic'     => array( 'active' => true ),
				'condition'   => array(
					'left_and_right_separator_type' => 'custom',
				),
				'label_block' => true,
			)
		);

		$this->add_control(
			'right_separator_image',
			array(
				'label'       => __( 'Right Line Image', 'premium-addons-pro' ),
				'type'        => Controls_Manager::MEDIA,
				'dynamic'     => array( 'active' => true ),
				'condition'   => array(
					'left_and_right_separator_type' => 'custom',
				),
				'label_block' => true,
			)
		);

		$this->add_responsive_control(
			'content_and_separator_size',
			array(
				'label'       => __( 'Container Width', 'premium-addons-pro' ),
				'type'        => Controls_Manager::SLIDER,
				'size_units'  => array( 'px', 'em', '%', 'custom' ),
				'range'       => array(
					'px' => array(
						'min' => 0,
						'max' => 400,
					),
					'em' => array(
						'min' => 0,
						'max' => 30,
					),
				),
				'label_block' => true,
				'selectors'   => array(
					'{{WRAPPER}} .premium-separator-inner' => 'width: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'content_link_switcher',
			array(
				'label'       => __( 'Link', 'premium-addons-pro' ),
				'type'        => Controls_Manager::SWITCHER,
				'description' => __( 'Add a custom link or select an existing page link', 'premium-addons-pro' ),
			)
		);

		$this->add_control(
			'content_link_type',
			array(
				'label'       => __( 'Link/URL', 'premium-addons-pro' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'url'  => __( 'URL', 'premium-addons-pro' ),
					'link' => __( 'Existing Page', 'premium-addons-pro' ),
				),
				'default'     => 'url',
				'label_block' => true,
				'condition'   => array(
					'content_link_switcher' => 'yes',
				),
			)
		);

		$this->add_control(
			'content_existing_page',
			array(
				'label'       => __( 'Existing Page', 'premium-addons-pro' ),
				'type'        => Controls_Manager::SELECT2,
				'options'     => $this->getTemplateInstance()->get_all_posts(),
				'condition'   => array(
					'content_link_switcher' => 'yes',
					'content_link_type'     => 'link',
				),
				'multiple'    => false,
				'label_block' => true,
			)
		);

		$this->add_control(
			'content_url',
			array(
				'label'       => __( 'URL', 'premium-addons-pro' ),
				'type'        => Controls_Manager::URL,
				'dynamic'     => array( 'active' => true ),
				'placeholder' => 'https://premiumaddons.com/',
				'condition'   => array(
					'content_link_switcher' => 'yes',
					'content_link_type'     => 'url',
				),
				'label_block' => true,
			)
		);

		$this->add_responsive_control(
			'content_alignment',
			array(
				'label'     => __( 'Alignment', 'premium-addons-pro' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => array(
					'left'   => array(
						'title' => __( 'Left', 'premium-addons-pro' ),
						'icon'  => 'eicon-text-align-left',
					),
					'center' => array(
						'title' => __( 'Center', 'premium-addons-pro' ),
						'icon'  => 'eicon-text-align-center',
					),
					'right'  => array(
						'title' => __( 'Right', 'premium-addons-pro' ),
						'icon'  => 'eicon-text-align-right',
					),
				),
				'default'   => 'center',
				'selectors' => array(
					'{{WRAPPER}} .premium-separator-wrapper-separator-divider' => 'text-align: {{VALUE}}',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'content_section',
			array(
				'label' => __( 'Divider Type', 'premium-addons-pro' ),
			)
		);

		$this->add_control(
			'hide_icon',
			array(
				'label'     => __( 'Show/Hide Icon', 'premium-addons-pro' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'table-cell',
				'options'   => array(
					'table-cell' => __( 'Show', 'premium-addons-pro' ),
					'none'       => __( 'Hide', 'premium-addons-pro' ),
				),
				'selectors' => array(
					'{{WRAPPER}} .premium-separator-icon-container' => 'display: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'content_inside_separator',
			array(
				'label'       => __( 'Type', 'premium-addons-pro' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'font_awesome_icon' => __( 'Icon', 'premium-addons-pro' ),
					'custom_image'      => __( 'Image', 'premium-addons-pro' ),
					'text'              => __( 'Text', 'premium-addons-pro' ),
					'animation'         => __( 'Lottie Animation', 'premium-addons-pro' ),
					'svg'               => __( 'SVG Code', 'premium-addons-pro' ),
				),
				'default'     => 'font_awesome_icon',
				'label_block' => true,
				'condition'   => array(
					'hide_icon' => 'table-cell',
				),
			)
		);

		$this->add_control(
			'content_font_awesome_icon_updated',
			array(
				'label'            => __( 'Icon', 'premium-addons-pro' ),
				'type'             => Controls_Manager::ICONS,
				'fa4compatibility' => 'content_font_awesome_icon',
				'default'          => array(
					'value'   => 'fas fa-heart',
					'library' => 'fa-solid',
				),
				'condition'        => array(
					'hide_icon'                => 'table-cell',
					'content_inside_separator' => 'font_awesome_icon',
				),
			)
		);

		$this->add_control(
			'content_image',
			array(
				'label'       => __( 'Choose Image', 'premium-addons-pro' ),
				'type'        => Controls_Manager::MEDIA,
				'dynamic'     => array( 'active' => true ),
				'condition'   => array(
					'hide_icon'                => 'table-cell',
					'content_inside_separator' => 'custom_image',
				),
				'label_block' => true,
			)
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			array(
				'name'      => 'thumbnail',
				'default'   => 'thumbnail',
				'condition' => array(
					'hide_icon'                => 'table-cell',
					'content_inside_separator' => 'custom_image',
				),
			)
		);

		$this->add_control(
			'content_text',
			array(
				'label'       => __( 'Text', 'premium-addons-pro' ),
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => array( 'active' => true ),
				'default'     => __( 'Separator', 'premium-addons-pro' ),
				'condition'   => array(
					'hide_icon'                => 'table-cell',
					'content_inside_separator' => 'text',
				),
				'label_block' => true,
			)
		);

		$this->add_control(
			'content_text_tag',
			array(
				'label'       => __( 'HTML Tag', 'premium-addons-pro' ),
				'description' => __( 'Select a Heading tag for the Separator Text. Headings are defined with H1 to H6 tags', 'premium-addons-pro' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => 'h3',
				'options'     => array(
					'h1' => 'H1',
					'h2' => 'H2',
					'h3' => 'H3',
					'h4' => 'H4',
					'h5' => 'H5',
					'h6' => 'H6',
				),
				'condition'   => array(
					'hide_icon'                => 'table-cell',
					'content_inside_separator' => 'text',
				),
				'label_block' => true,
			)
		);

		$this->add_control(
			'custom_svg',
			array(
				'label'       => __( 'SVG Code', 'premium-addons-pro' ),
				'type'        => Controls_Manager::TEXTAREA,
				'description' => 'You can use these sites to create SVGs: <a href="https://danmarshall.github.io/google-font-to-svg-path/" target="_blank">Google Fonts</a> and <a href="https://boxy-svg.com/" target="_blank">Boxy SVG</a>',
				'condition'   => array(
					'hide_icon'                => 'table-cell',
					'content_inside_separator' => 'svg',
				),
			)
		);

		$this->add_control(
			'lottie_url',
			array(
				'label'       => __( 'Animation JSON URL', 'premium-addons-pro' ),
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => array( 'active' => true ),
				'description' => 'Get JSON code URL from <a href="https://lottiefiles.com/" target="_blank">here</a>',
				'label_block' => true,
				'condition'   => array(
					'hide_icon'                => 'table-cell',
					'content_inside_separator' => 'animation',
				),
			)
		);

		$this->add_control(
			'draw_svg',
			array(
				'label'     => __( 'Draw Icon', 'premium-addons-pro' ),
				'type'      => Controls_Manager::SWITCHER,
				'classes'   => $draw_icon ? '' : 'editor-pa-control-disabled',
				'condition' => array(
					'hide_icon'                => 'table-cell',
					'content_inside_separator' => array( 'font_awesome_icon', 'svg' ),
					'content_font_awesome_icon_updated[library]!' => 'svg',
				),
			)
		);

		$animation_conds = array(
			'terms' => array(
				array(
					'name'  => 'hide_icon',
					'value' => 'table-cell',
				),
				array(
					'relation' => 'or',
					'terms'    => array(
						array(
							'name'  => 'content_inside_separator',
							'value' => 'animation',
						),
						array(
							'terms' => array(
								array(
									'relation' => 'or',
									'terms'    => array(
										array(
											'name'  => 'content_inside_separator',
											'value' => 'font_awesome_icon',
										),
										array(
											'name'  => 'content_inside_separator',
											'value' => 'svg',
										),
									),
								),
								array(
									'name'  => 'draw_svg',
									'value' => 'yes',
								),
							),
						),
					),
				),
			),
		);

		if ( $draw_icon ) {
			$this->add_control(
				'path_width',
				array(
					'label'     => __( 'Path Thickness', 'premium-addons-pro' ),
					'type'      => Controls_Manager::SLIDER,
					'range'     => array(
						'px' => array(
							'min'  => 0,
							'max'  => 50,
							'step' => 0.1,
						),
					),
					'condition' => array(
						'hide_icon'                => 'table-cell',
						'content_inside_separator' => array( 'font_awesome_icon', 'svg' ),
					),
					'selectors' => array(
						'{{WRAPPER}} .premium-separator-icon-container svg *' => 'stroke-width: {{SIZE}}',
					),
				)
			);

			$this->add_control(
				'svg_sync',
				array(
					'label'     => __( 'Draw All Paths Together', 'premium-addons-pro' ),
					'type'      => Controls_Manager::SWITCHER,
					'condition' => array(
						'hide_icon'                => 'table-cell',
						'content_inside_separator' => array( 'font_awesome_icon', 'svg' ),
						'draw_svg'                 => 'yes',
					),
				)
			);

			$this->add_control(
				'frames',
				array(
					'label'       => __( 'Speed', 'premium-addons-pro' ),
					'type'        => Controls_Manager::NUMBER,
					'description' => __( 'Larger value means longer animation duration.', 'premium-addons-pro' ),
					'default'     => 5,
					'min'         => 1,
					'max'         => 100,
					'condition'   => array(
						'hide_icon'                => 'table-cell',
						'content_inside_separator' => array( 'font_awesome_icon', 'svg' ),
						'draw_svg'                 => 'yes',
					),
				)
			);
		} elseif ( method_exists( 'PremiumAddons\Includes\Helper_Functions', 'get_draw_svg_notice' ) ) {

			Helper_Functions::get_draw_svg_notice(
				$this,
				'divider',
				array(
					'hide_icon'                => 'table-cell',
					'content_inside_separator' => array( 'font_awesome_icon', 'svg' ),
					'content_font_awesome_icon_updated[library]!' => 'svg',
				)
			);
		}

		$this->add_control(
			'lottie_loop',
			array(
				'label'        => __( 'Loop', 'premium-addons-pro' ),
				'type'         => Controls_Manager::SWITCHER,
				'return_value' => 'true',
				'default'      => 'true',
				'conditions'   => $animation_conds,
			)
		);

		$this->add_control(
			'lottie_reverse',
			array(
				'label'        => __( 'Reverse', 'premium-addons-pro' ),
				'type'         => Controls_Manager::SWITCHER,
				'return_value' => 'true',
				'conditions'   => $animation_conds,
			)
		);

		if ( $draw_icon ) {
			$this->add_control(
				'start_point',
				array(
					'label'       => __( 'Start Point (%)', 'premium-addons-pro' ),
					'type'        => Controls_Manager::SLIDER,
					'description' => __( 'Set the point that the SVG should start from.', 'premium-addons-pro' ),
					'default'     => array(
						'unit' => '%',
						'size' => 0,
					),
					'condition'   => array(
						'hide_icon'                => 'table-cell',
						'content_inside_separator' => array( 'font_awesome_icon', 'svg' ),
						'draw_svg'                 => 'yes',
						'lottie_reverse!'          => 'true',
					),
				)
			);

			$this->add_control(
				'end_point',
				array(
					'label'       => __( 'End Point (%)', 'premium-addons-pro' ),
					'type'        => Controls_Manager::SLIDER,
					'description' => __( 'Set the point that the SVG should end at.', 'premium-addons-pro' ),
					'default'     => array(
						'size' => 0,
						'unit' => '%',
					),
					'condition'   => array(
						'hide_icon'                => 'table-cell',
						'content_inside_separator' => array( 'font_awesome_icon', 'svg' ),
						'draw_svg'                 => 'yes',
						'lottie_reverse'           => 'true',
					),

				)
			);

			$this->add_control(
				'svg_yoyo',
				array(
					'label'     => __( 'Yoyo Effect', 'premium-addons-pro' ),
					'type'      => Controls_Manager::SWITCHER,
					'condition' => array(
						'hide_icon'                => 'table-cell',
						'content_inside_separator' => array( 'font_awesome_icon', 'svg' ),
						'draw_svg'                 => 'yes',
					),
				)
			);

		}

		$this->add_control(
			'lottie_hover',
			array(
				'label'        => __( 'Only Play on Hover', 'premium-addons-pro' ),
				'type'         => Controls_Manager::SWITCHER,
				'return_value' => 'true',
				'conditions'   => $animation_conds,
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'separator_style_section',
			array(
				'label' => __( 'Separator', 'premium-addons-pro' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->start_controls_tabs( 'separator_style_tabs' );

		$this->start_controls_tab(
			'separator_content_tab',
			array(
				'label'     => __( 'Content', 'premium-addons-pro' ),
				'condition' => array(
					'hide_icon' => 'table-cell',
				),
			)
		);

		$this->add_responsive_control(
			'content_size',
			array(
				'label'       => __( 'Size', 'premium-addons-pro' ),
				'type'        => Controls_Manager::SLIDER,
				'size_units'  => array( 'px', 'em', '%' ),
				'range'       => array(
					'em' => array(
						'min' => 0,
						'max' => 25,
					),
				),
				'condition'   => array(
					'hide_icon'                => 'table-cell',
					'content_inside_separator' => array( 'font_awesome_icon', 'animation' ),
				),
				'label_block' => true,
				'selectors'   => array(
					'{{WRAPPER}} .premium-separator-icon-wrap i' => 'font-size: {{SIZE}}{{UNIT}}; line-height: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .premium-separator-icon-wrap svg'  => 'width: {{SIZE}}{{UNIT}} !important; height: {{SIZE}}{{UNIT}} !important',
				),
			)
		);

		$this->add_responsive_control(
			'svg_icon_width',
			array(
				'label'      => __( 'Width', 'premium-addons-pro' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', 'em', '%' ),
				'range'      => array(
					'px' => array(
						'min' => 1,
						'max' => 600,
					),
					'em' => array(
						'min' => 1,
						'max' => 30,
					),
				),
				'default'    => array(
					'size' => 100,
					'unit' => 'px',
				),
				'condition'  => array(
					'hide_icon'                => 'table-cell',
					'content_inside_separator' => 'svg',
				),
				'selectors'  => array(
					'{{WRAPPER}} .premium-separator-icon-container svg' => 'width: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'svg_icon_height',
			array(
				'label'      => __( 'Height', 'premium-addons-pro' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', 'em' ),
				'range'      => array(
					'px' => array(
						'min' => 1,
						'max' => 300,
					),
					'em' => array(
						'min' => 1,
						'max' => 30,
					),
				),
				'condition'  => array(
					'hide_icon'                => 'table-cell',
					'content_inside_separator' => 'svg',
				),
				'selectors'  => array(
					'{{WRAPPER}} .premium-separator-icon-container svg' => 'height: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'separator_content_color',
			array(
				'label'     => __( 'Color', 'premium-addons-pro' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => array(
					'default' => Global_Colors::COLOR_PRIMARY,
				),
				'condition' => array(
					'hide_icon'                 => 'table-cell',
					'content_inside_separator!' => array( 'custom_image', 'animation' ),
				),
				'selectors' => array(
					'{{WRAPPER}} .premium-separator-icon-wrap i, {{WRAPPER}} .premium-separator-text-icon .premium-separator-icon-text' => 'color: {{VALUE}};',
					'{{WRAPPER}} .premium-drawable-icon *, {{WRAPPER}} .premium-separator-icon-container svg:not([class*="premium-"])' => 'fill: {{VALUE}};',
				),
			)
		);

		if ( $draw_icon ) {
			$this->add_control(
				'stroke_color',
				array(
					'label'     => __( 'Stroke Color', 'premium-addons-pro' ),
					'type'      => Controls_Manager::COLOR,
					'global'    => array(
						'default' => Global_Colors::COLOR_ACCENT,
					),
					'condition' => array(
						'hide_icon'                => 'table-cell',
						'content_inside_separator' => array( 'font_awesome_icon', 'svg' ),
					),
					'selectors' => array(
						'{{WRAPPER}} .premium-drawable-icon *, {{WRAPPER}} svg:not([class*="premium-"])' => 'stroke: {{VALUE}};',
					),
				)
			);
		}

		$this->add_control(
			'svg_color',
			array(
				'label'     => __( 'After Draw Fill Color', 'premium-addons-pro' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => false,
				'separator' => 'after',
				'condition' => array(
					'hide_icon'                => 'table-cell',
					'content_inside_separator' => array( 'font_awesome_icon', 'svg' ),
					'draw_svg'                 => 'yes',
				),
			)
		);

		$this->add_control(
			'separator_content_hover_color',
			array(
				'label'     => __( 'Hover Color', 'premium-addons-pro' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => array(
					'default' => Global_Colors::COLOR_PRIMARY,
				),
				'condition' => array(
					'hide_icon'                => 'table-cell',
					'content_inside_separator' => array( 'font_awesome_icon', 'text' ),
				),
				'selectors' => array(
					'{{WRAPPER}} .premium-separator-container:hover .premium-separator-icon i, {{WRAPPER}} .premium-separator-container:hover .premium-separator-icon-text' => 'color: {{VALUE}};',
					'{{WRAPPER}} .premium-separator-container:hover .premium-drawable-icon *, {{WRAPPER}} .premium-separator-container:hover svg:not([class*="premium-"])' => 'fill: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'      => 'separator_typhography',
				'condition' => array(
					'hide_icon'                => 'table-cell',
					'content_inside_separator' => 'text',
				),
				'selector'  => '{{WRAPPER}} .premium-separator-icon-text',
			)
		);

		$this->add_control(
			'separator_content_background',
			array(
				'label'     => __( 'Background', 'premium-addons-pro' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => array(
					'hide_icon' => 'table-cell',
				),
				'selectors' => array(
					'{{WRAPPER}} .premium-separator-icon-wrap *' => 'background: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'      => 'separator_content_border',
				'condition' => array(
					'hide_icon' => 'table-cell',
				),
				'selector'  => '{{WRAPPER}} .premium-separator-icon-wrap *',
			)
		);

		$this->add_control(
			'separator_content_border_radius',
			array(
				'label'      => __( 'Border Radius', 'premium-addons-pro' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', 'em', '%' ),
				'condition'  => array(
					'hide_icon' => 'table-cell',
				),
				'selectors'  => array(
					'{{WRAPPER}} .premium-separator-icon-wrap *' => 'border-radius: {{SIZE}}{{UNIT}};',
				),
				'condition'  => array(
					'separator_adv_radius!' => 'yes',
				),
			)
		);

		$this->add_control(
			'separator_adv_radius',
			array(
				'label'       => __( 'Advanced Border Radius', 'premium-addons-pro' ),
				'type'        => Controls_Manager::SWITCHER,
				'description' => __( 'Apply custom radius values. Get the radius value from ', 'premium-addons-pro' ) . '<a href="https://9elements.github.io/fancy-border-radius/" target="_blank">here</a>',
			)
		);

		$this->add_control(
			'separator_adv_radius_value',
			array(
				'label'     => __( 'Border Radius', 'premium-addons-pro' ),
				'type'      => Controls_Manager::TEXT,
				'dynamic'   => array( 'active' => true ),
				'selectors' => array(
					'{{WRAPPER}} .premium-separator-icon-wrap *' => 'border-radius: {{VALUE}};',
				),
				'condition' => array(
					'separator_adv_radius' => 'yes',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'      => 'separator_content_box_shadow',
				'condition' => array(
					'hide_icon' => 'table-cell',
				),
				'selector'  => '{{WRAPPER}} .premium-separator-icon-wrap *',
			)
		);

		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			array(
				'name'      => 'separator_content_text_shadow',
				'condition' => array(
					'hide_icon' => 'table-cell',
				),
				'selector'  => '{{WRAPPER}} .premium-separator-icon-wrap *',
			)
		);

		$this->add_responsive_control(
			'separator_content_margin',
			array(
				'label'      => __( 'Margin', 'premium-addons-pro' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'condition'  => array(
					'hide_icon' => 'table-cell',
				),
				'selectors'  => array(
					'{{WRAPPER}} .premium-separator-icon-wrap' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'separator_content_padding',
			array(
				'label'      => __( 'Padding', 'premium-addons-pro' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'condition'  => array(
					'hide_icon' => 'table-cell',
				),
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .premium-separator-icon-wrap *' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'separator_lines_tab',
			array(
				'label' => __( 'Separator', 'premium-addons-pro' ),
			)
		);

		$this->add_responsive_control(
			'left_separator_width',
			array(
				'label'       => __( 'Left Width (%)', 'premium-addons-pro' ),
				'type'        => Controls_Manager::SLIDER,
				'label_block' => true,
				'selectors'   => array(
					'{{WRAPPER}} .premium-separator-divider-left' => 'width: {{SIZE}}%;',
				),
			)
		);

		$this->add_responsive_control(
			'right_separator_width',
			array(
				'label'       => __( 'Right Width (%)', 'premium-addons-pro' ),
				'type'        => Controls_Manager::SLIDER,
				'label_block' => true,
				'selectors'   => array(
					'{{WRAPPER}} .premium-separator-divider-right' => 'width: {{SIZE}}%;',
				),
			)
		);

		$this->add_responsive_control(
			'left_and_right_separator_height',
			array(
				'label'       => __( 'Height', 'premium-addons-pro' ),
				'type'        => Controls_Manager::SLIDER,
				'size_units'  => array( 'px', 'em' ),
				'label_block' => true,
				'condition'   => array(
					'left_and_right_separator_type!' => array( 'curved' ),
				),
				'selectors'   => array(
					'{{WRAPPER}} .premium-separator-divider-left hr,{{WRAPPER}} .premium-separator-divider-right hr' => 'border-top-width: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .premium-separator-curvedtop .premium-separator-left-side hr, {{WRAPPER}} .premium-separator-curvedtop .premium-separator-right-side hr' => 'border-bottom-width: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .premium-separator-shadow .premium-separator-left-side hr, {{WRAPPER}} .premium-separator-shadow .premium-separator-right-side hr, {{WRAPPER}} .premium-separator-gradient .premium-separator-left-side hr, {{WRAPPER}} .premium-separator-gradient .premium-separator-right-side hr' => 'height: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_responsive_control(
			'left_and_right_separator_top_space',
			array(
				'label'      => __( 'Space Between Lines', 'premium-addons-pro' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .premium-separator-divider-left hr,{{WRAPPER}} .premium-separator-divider-right hr' => 'margin-top: {{SIZE}}{{UNIT}}; margin-bottom: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'left_separator_heading',
			array(
				'label' => __( 'Left', 'premium-addons-pro' ),
				'type'  => Controls_Manager::HEADING,
			)
		);

		$this->add_control(
			'left_separator_color',
			array(
				'label'     => __( 'Color', 'premium-addons-pro' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => array(
					'left_and_right_separator_type!' => array( 'custom', 'gradient' ),
				),
				'selectors' => array(
					'{{WRAPPER}} .premium-separator-divider-left hr' => 'border-top-color: {{VALUE}};',
					'{{WRAPPER}} .premium-separator-curvedtop .premium-separator-left-side hr' => 'border-bottom-color: {{VALUE}}',
					'{{WRAPPER}} .premium-separator-shadow .premium-separator-left-side hr' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_responsive_control(
			'left_separator_slices',
			array(
				'label'       => __( 'Number of Slices', 'premium-addons-pro' ),
				'type'        => Controls_Manager::SLIDER,
				'range'       => array(
					'px' => array(
						'min' => 0,
						'max' => 1000,
					),
				),
				'label_block' => true,
				'condition'   => array(
					'left_and_right_separator_type' => array( 'custom' ),
				),
				'selectors'   => array(
					'{{WRAPPER}} .premium-separator-custom .premium-separator-left-side hr' => 'border-image-slice: {{SIZE}} !important;',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'      => 'left_shadow',
				'label'     => __( 'Shadow', 'premium-addons-pro' ),
				'condition' => array(
					'left_and_right_separator_type' => array( 'shadow' ),
				),
				'selector'  => '{{WRAPPER}} .premium-separator-shadow .premium-separator-left-side hr',
			)
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'      => 'left_background',
				'types'     => array( 'gradient' ),
				'condition' => array(
					'left_and_right_separator_type' => array( 'gradient' ),
				),
				'selector'  => '{{WRAPPER}} .premium-separator-gradient .premium-separator-left-side hr',
			)
		);

		$this->add_control(
			'right_separator_heading',
			array(
				'label' => __( 'Right', 'premium-addons-pro' ),
				'type'  => Controls_Manager::HEADING,
			)
		);

		$this->add_control(
			'right_separator_color',
			array(
				'label'     => __( 'Color', 'premium-addons-pro' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => array(
					'left_and_right_separator_type!' => array( 'custom', 'gradient' ),
				),
				'selectors' => array(
					'{{WRAPPER}} .premium-separator-divider-right hr' => 'border-top-color: {{VALUE}};',
					'{{WRAPPER}} .premium-separator-curvedtop .premium-separator-right-side hr' => 'border-bottom-color: {{VALUE}}',
					'{{WRAPPER}} .premium-separator-shadow .premium-separator-right-side hr' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_responsive_control(
			'right_separator_slices',
			array(
				'label'       => __( 'Number of Slices', 'premium-addons-pro' ),
				'type'        => Controls_Manager::SLIDER,
				'range'       => array(
					'px' => array(
						'min' => 0,
						'max' => 1000,
					),
				),
				'label_block' => true,
				'condition'   => array(
					'left_and_right_separator_type' => array( 'custom' ),
				),
				'selectors'   => array(
					'{{WRAPPER}} .premium-separator-custom .premium-separator-right-side hr' => 'border-image-slice: {{SIZE}} !important;',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'      => 'right_shadow',
				'label'     => __( 'Gradient', 'premium-addons-pro' ),
				'condition' => array(
					'left_and_right_separator_type' => array( 'shadow' ),
				),
				'selector'  => '{{WRAPPER}} .premium-separator-shadow .premium-separator-right-side hr',
			)
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'      => 'right_background',
				'types'     => array( 'gradient' ),
				'condition' => array(
					'left_and_right_separator_type' => array( 'gradient' ),
				),
				'selector'  => '{{WRAPPER}} .premium-separator-gradient .premium-separator-right-side hr',
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		$this->start_controls_section(
			'container_style',
			array(
				'label' => __( 'Container', 'premium-addons-pro' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'     => 'container_background',
				'types'    => array( 'classic', 'gradient' ),
				'selector' => '{{WRAPPER}} .premium-separator-container',
			)
		);

		$this->add_responsive_control(
			'container_margin',
			array(
				'label'      => __( 'Margin', 'premium-addons-pro' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .premium-separator-container' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'container_padding',
			array(
				'label'      => __( 'Padding', 'premium-addons-pro' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .premium-separator-container' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();

	}

	/**
	 * Render Divider widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function render() {

		$settings = $this->get_settings_for_display();

		$icon_type = $settings['content_inside_separator'];

		$this->add_inline_editing_attributes( 'content_text', 'basic' );

		$this->add_render_attribute( 'content_text', 'class', 'premium-separator-icon-text' );

		$this->add_render_attribute( 'left_sep', 'class', array( 'premium-separator-divider-left', 'premium-separator-left-side' ) );

		$this->add_render_attribute( 'right_sep', 'class', array( 'premium-separator-divider-right', 'premium-separator-right-side' ) );

		if ( 'custom' === $settings['left_and_right_separator_type'] ) {
			$this->add_render_attribute( 'left_sep', 'data-background', $settings['left_separator_image']['url'] );
		}

		if ( 'custom' === $settings['left_and_right_separator_type'] ) {
			$this->add_render_attribute( 'right_sep', 'data-background', $settings['right_separator_image']['url'] );
		}

		$separator_link_type = $settings['content_link_type'];

		if ( 'url' === $separator_link_type ) {

			$this->add_link_attributes( 'link', $settings['content_url'] );

		} elseif ( 'link' === $separator_link_type ) {

			$this->add_render_attribute( 'link', 'href', get_permalink( $settings['content_existing_page'] ) );

		}

		$this->add_render_attribute( 'link', 'class', 'premium-separator-item-link' );

		if ( 'font_awesome_icon' === $icon_type || 'svg' === $icon_type ) {

			$this->add_render_attribute( 'icon', 'class', 'premium-drawable-icon' );

			if ( 'font_awesome_icon' === $icon_type ) {

				if ( ! empty( $settings['content_font_awesome_icon'] ) ) {
					$this->add_render_attribute(
						'icon',
						array(
							'class'       => $settings['content_font_awesome_icon'],
							'aria-hidden' => 'true',
						)
					);

				}

				$migrated = isset( $settings['__fa4_migrated']['content_font_awesome_icon_updated'] );
				$is_new   = empty( $settings['content_font_awesome_icon'] ) && Icons_Manager::is_migration_allowed();

			}

			if ( 'yes' === $settings['draw_svg'] ) {

				$this->add_render_attribute(
					'container',
					'class',
					array(
						'elementor-invisible',
						'premium-drawer-hover',
					)
				);

				if ( 'font_awesome_icon' === $icon_type ) {

					$this->add_render_attribute( 'icon', 'class', $settings['content_font_awesome_icon_updated']['value'] );

				}

				$this->add_render_attribute(
					'icon',
					array(
						'class'            => 'premium-svg-drawer',
						'data-svg-reverse' => $settings['lottie_reverse'],
						'data-svg-loop'    => $settings['lottie_loop'],
						'data-svg-sync'    => $settings['svg_sync'],
						'data-svg-hover'   => $settings['lottie_hover'],
						'data-svg-fill'    => $settings['svg_color'],
						'data-svg-frames'  => $settings['frames'],
						'data-svg-yoyo'    => $settings['svg_yoyo'],
						'data-svg-point'   => $settings['lottie_reverse'] ? $settings['end_point']['size'] : $settings['start_point']['size'],
					)
				);

			} else {

				$this->add_render_attribute( 'icon', 'class', 'premium-svg-nodraw' );

			}
		} elseif ( 'animation' === $icon_type ) {

			$this->add_render_attribute(
				'separator_lottie',
				array(
					'class'               => array(
						'premium-separator-icon-wrap',
						'premium-lottie-animation',
					),
					'data-lottie-url'     => $settings['lottie_url'],
					'data-lottie-loop'    => $settings['lottie_loop'],
					'data-lottie-reverse' => $settings['lottie_reverse'],
					'data-lottie-hover'   => $settings['lottie_hover'],
				)
			);

		}

		$this->add_render_attribute(
			'container',
			array(
				'class'         => array(
					'premium-separator-container',
					'premium-separator-' . $settings['left_and_right_separator_type'],
				),
				'data-settings' => $settings['left_and_right_separator_type'],

			)
		);

		$text_tag = PAPRO_Helper::validate_html_tag( $settings['content_text_tag'] );

		?>

		<div <?php echo wp_kses_post( $this->get_render_attribute_string( 'container' ) ); ?>>
			<div class="premium-separator-wrapper">
				<div class="premium-separator-wrapper-separator">
					<div class="premium-separator-wrapper-separator-divider">
						<div class="premium-separator-inner">
							<?php if ( 'yes' === $settings['content_link_switcher'] ) : ?>
								<a <?php echo wp_kses_post( $this->get_render_attribute_string( 'link' ) ); ?>>
							<?php endif; ?>

								<div class="premium-separator-content-wrapper">
									<div <?php echo wp_kses_post( $this->get_render_attribute_string( 'left_sep' ) ); ?>>
										<?php
										if ( 'separators_one_span' === $settings['content_lines_Number'] ) {
											echo '<hr>';
										} elseif ( 'separators_two_span' === $settings['content_lines_Number'] ) {
											echo '<hr><hr>';
										} elseif ( 'separators_three_span' === $settings['content_lines_Number'] ) {
											echo '<hr><hr><hr>';
										} elseif ( 'separators_four_span' === $settings['content_lines_Number'] ) {
											echo '<hr><hr><hr><hr>';
										} elseif ( 'separators_five_span' === $settings['content_lines_Number'] ) {
											echo '<hr><hr><hr><hr><hr>';
										}
										?>
									</div>
									<div class="premium-separator-icon-container">
										<?php if ( 'font_awesome_icon' === $icon_type ) : ?>
											<div class="premium-separator-icon-wrap premium-separator-icon">
												<?php
												if ( ( $is_new || $migrated ) && 'yes' !== $settings['draw_svg'] ) :
													Icons_Manager::render_icon(
														$settings['content_font_awesome_icon_updated'],
														array(
															'class'       => array( 'premium-svg-nodraw', 'premium-drawable-icon' ),
															'aria-hidden' => 'true',
														)
													);
												else :
													?>
													<i <?php echo wp_kses_post( $this->get_render_attribute_string( 'icon' ) ); ?>></i>
												<?php endif; ?>
											</div>
										<?php elseif ( 'svg' === $icon_type ) : ?>
											<div <?php echo wp_kses_post( $this->get_render_attribute_string( 'icon' ) ); ?>>
												<?php $this->print_unescaped_setting( 'custom_svg' ); ?>
											</div>
										<?php elseif ( 'custom_image' === $icon_type ) : ?>
											<div class="premium-separator-icon-wrap premium-separator-img-icon">
											<?php
												$image_src = $settings['content_image'];

												$image_src_size = Group_Control_Image_Size::get_attachment_image_src( $image_src['id'], 'thumbnail', $settings );

											if ( empty( $image_src_size ) ) {
												$image_src_size = $image_src['url'];
											} else {
												$image_src_size = $image_src_size;
											}

											?>
												<img src="<?php echo esc_url( $image_src_size ); ?>">
											</div>
										<?php elseif ( 'text' === $icon_type ) : ?>

											<div class="premium-separator-icon-wrap premium-separator-text-icon">
												<<?php echo wp_kses_post( $text_tag . ' ' . $this->get_render_attribute_string( 'content_text' ) ); ?>>
													<?php echo wp_kses_post( $settings['content_text'] ); ?>
												</<?php echo wp_kses_post( $text_tag ); ?>>

											</div>
										<?php else : ?>
											<div <?php echo wp_kses_post( $this->get_render_attribute_string( 'separator_lottie' ) ); ?>></div>
										<?php endif; ?>
									</div>
									<div <?php echo wp_kses_post( $this->get_render_attribute_string( 'right_sep' ) ); ?>>
										<?php
										if ( 'separators_one_span' === $settings['content_lines_Number'] ) {
											echo '<hr>';
										} elseif ( 'separators_two_span' === $settings['content_lines_Number'] ) {
											echo '<hr><hr>';
										} elseif ( 'separators_three_span' === $settings['content_lines_Number'] ) {
											echo '<hr><hr><hr>';
										} elseif ( 'separators_four_span' === $settings['content_lines_Number'] ) {
											echo '<hr><hr><hr><hr>';
										} elseif ( 'separators_five_span' === $settings['content_lines_Number'] ) {
											echo '<hr><hr><hr><hr><hr>';
										}
										?>
									</div>
								</div>

							<?php if ( 'yes' === $settings['content_link_switcher'] ) : ?>
								</a>
							<?php endif; ?>

							</div>

						</div>

				</div>

				<div class="premium-clearfix"></div>

			</div>

		</div>

		<?php

	}

	/**
	 * Render Divider widget output in the editor.
	 *
	 * Written as a Backbone JavaScript template and used to generate the live preview.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function content_template() {
		?>
		<#

			var separatorType = settings.left_and_right_separator_type,
				textTag = elementor.helpers.validateHTMLTag( settings.content_text_tag ),
				iconType = settings.content_inside_separator;

			view.addInlineEditingAttributes('content_text', 'basic');

			view.addRenderAttribute( 'content_text', 'class', 'premium-separator-icon-text' );

			view.addRenderAttribute('left_sep', 'class', ['premium-separator-divider-left', 'premium-separator-left-side'] );

			view.addRenderAttribute('right_sep', 'class', ['premium-separator-divider-right', 'premium-separator-right-side'] );

			view.addRenderAttribute('container', 'class', [ 'premium-separator-container', 'premium-separator-' + separatorType ] );

			view.addRenderAttribute('container', 'data-settings', separatorType );

			if( 'custom' === separatorType ) {
				view.addRenderAttribute('left_sep', 'data-background', settings.left_separator_image.url );
			}

			if( 'custom' === separatorType ) {
				view.addRenderAttribute('right_sep', 'data-background', settings.right_separator_image.url );
			}

			var separatorLinkType = settings.content_link_type;

			if ( 'url' == separatorLinkType ) {

				linkUrl = settings.content_url.url;

			} else if ( 'link' == separatorLinkType  ) {

				linkUrl = settings.content_existing_page;

			}

			if( 'font_awesome_icon' === iconType || 'svg' === iconType ) {

				view.addRenderAttribute( 'icon', 'class', 'premium-drawable-icon' );

				if( 'font_awesome_icon' === iconType ) {

					var iconHTML = 'yes' !== settings.draw_svg ? elementor.helpers.renderIcon( view, settings.content_font_awesome_icon_updated, { 'class': [ 'premium-svg-nodraw', 'premium-drawable-icon' ], 'aria-hidden': true }, 'i' , 'object' ) : false,
						migrated = elementor.helpers.isIconMigrated( settings, 'content_font_awesome_icon_updated' );

				}

				if ( 'yes' === settings.draw_svg ) {

					view.addRenderAttribute( 'container', 'class', 'premium-drawer-hover' );

					if ( 'font_awesome_icon' === iconType ) {

						view.addRenderAttribute( 'icon', 'class', settings.content_font_awesome_icon_updated.value );

					}

					view.addRenderAttribute(
						'icon',
						{
							'class'            : 'premium-svg-drawer',
							'data-svg-reverse' : settings.lottie_reverse,
							'data-svg-loop'    : settings.lottie_loop,
							'data-svg-sync'    : settings.svg_sync,
							'data-svg-hover'   : settings.lottie_hover,
							'data-svg-fill'    : settings.svg_color,
							'data-svg-frames'  : settings.frames,
							'data-svg-yoyo'    : settings.svg_yoyo,
							'data-svg-point'   : settings.lottie_reverse ? settings.end_point.size : settings.start_point.size,
						}
					);

				} else {
					view.addRenderAttribute( 'icon', 'class', 'premium-svg-nodraw' );
				}

			} else if( 'animation' === iconType ) {

				view.addRenderAttribute( 'separator_lottie', {
					'class': [
						'premium-separator-icon-wrap',
						'premium-lottie-animation'
					],
					'data-lottie-url': settings.lottie_url,
					'data-lottie-loop': settings.lottie_loop,
					'data-lottie-reverse': settings.lottie_reverse,
					'data-lottie-hover': settings.lottie_hover
				});

			}

		#>

		<div {{{ view.getRenderAttributeString('container') }}}>
			<div class="premium-separator-wrapper">
				<div class="premium-separator-wrapper-separator">
					<div class="premium-separator-wrapper-separator-divider">
						<div class="premium-separator-inner">
							<# if ( 'yes' == settings.content_link_switcher ) { #>
								<a class="premium-separator-item-link" href="{{ linkUrl }}">
							<# } #>
							<div class="premium-separator-content-wrapper">
								<div {{{ view.getRenderAttributeString('left_sep') }}}>
									<# if( 'separators_one_span' === settings.content_lines_Number ) { #>
										<hr>
									<# } else if( 'separators_two_span' === settings.content_lines_Number ) { #>
										<hr><hr>
									<# } else if( 'separators_three_span' === settings.content_lines_Number ) { #>
										<hr><hr><hr>
									<# } else if( 'separators_four_span' === settings.content_lines_Number ) { #>
										<hr><hr><hr><hr>
									<# } else if( 'separators_five_span' === settings.content_lines_Number ) { #>
										<hr><hr><hr><hr><hr>
									<# } #>
								</div>
								<div class="premium-separator-icon-container">
									<# if( 'font_awesome_icon' == iconType ) { #>
										<div class="premium-separator-icon-wrap premium-separator-icon">
											<# if ( iconHTML && iconHTML.rendered && ( ! settings.content_font_awesome_icon || migrated ) ) { #>
												{{{ iconHTML.value }}}
											<# } else { #>
												<i {{{ view.getRenderAttributeString( 'icon' ) }}}></i>
											<# } #>
										</div>
									<# } else if( 'svg' === iconType ) { #>
										<div {{{ view.getRenderAttributeString('icon') }}}>
											{{{ settings.custom_svg }}}
										</div>
									<# } else if( 'custom_image' === iconType ) { #>
										<div class="premium-separator-icon-wrap premium-separator-img-icon">
											<#

											var image = {
													id: settings.content_image.id,
													url: settings.content_image.url,
													size: settings.thumbnail_size,
													dimension: settings.thumbnail_custom_dimension,
													model: view.getEditModel()
												};

											var image_url = elementor.imagesManager.getImageUrl( image );

											#>
											<img src="{{ image_url }}">
										</div>
									<# } else if( 'text' === iconType ) { #>

										<div class="premium-separator-icon-wrap premium-separator-text-icon">
											<{{{textTag}}} {{{ view.getRenderAttributeString('content_text') }}}>{{{settings.content_text}}}</{{{textTag}}}>

										</div>
									<# } else { #>
										<div {{{ view.getRenderAttributeString('separator_lottie') }}}></div>
									<# } #>
								</div>
								<div {{{ view.getRenderAttributeString('right_sep') }}}>
									<# if( 'separators_one_span' === settings.content_lines_Number ) { #>
										<hr>
									<# } else if( 'separators_two_span' === settings.content_lines_Number ) { #>
										<hr><hr>
									<# } else if( 'separators_three_span' === settings.content_lines_Number ) { #>
										<hr><hr><hr>
									<# } else if( 'separators_four_span' === settings.content_lines_Number ) { #>
										<hr><hr><hr><hr>
									<# } else if( 'separators_five_span' === settings.content_lines_Number ) { #>
										<hr><hr><hr><hr><hr>
									<# } #>
								</div>
							</div>
							<# if( 'yes' === settings.content_link_switcher ) { #>
								</a>
							<# } #>
						</div>
					</div>
				</div>
			</div>
		</div>

		<?php
	}
}
