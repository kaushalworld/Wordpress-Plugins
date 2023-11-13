<?php
namespace ExclusiveAddons\Elements;

if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.

use \Elementor\Controls_Manager;
use \Elementor\Control_Media;
use \Elementor\Group_Control_Background;
use \Elementor\Group_Control_Border;
use \Elementor\Group_Control_Box_Shadow;
use \Elementor\Group_Control_Image_Size;
use \Elementor\Group_Control_Typography;
use \Elementor\Icons_Manager;
use \Elementor\Widget_Base;
use \Elementor\Utils;
use \ExclusiveAddons\Pro\Elementor\ProHelper;

class Campaign extends Widget_Base {

    public function get_name() {
        return 'exad-promo-box';
    }

    public function get_title() {
        return __( 'Campaign', 'exclusive-addons-elementor-pro' );
    }

    public function get_icon() {
        return 'exad exad-logo exad-campaign';
    }

    public function get_categories() {
        return [ 'exclusive-addons-elementor' ];
    }

    public function get_script_depends() {
        return [ 'exad-countdown' ];
    }

    protected function register_controls() {
        $exad_primary_color = get_option( 'exad_primary_color_option', '#7a56ff' );
        $admin_link         = admin_url( 'admin.php?page=exad-settings' );
        $api_link           = 'https://rudrastyh.com/mailchimp-api/subscription.html#api';

        $this->start_controls_section(
            'exad_promo_box_settings',
            [
                'label' => __( 'Settings', 'exclusive-addons-elementor-pro' )
            ]
        );

        $this->add_control(
            'exad_promo_box_enable_image',
            [
                'label'        => __( 'Enable Image', 'exclusive-addons-elementor-pro' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => __( 'On', 'exclusive-addons-elementor-pro' ),
                'label_off'    => __( 'Off', 'exclusive-addons-elementor-pro' ),
                'return_value' => 'yes',
                'default'      => 'yes'
            ]
        );

        $this->add_control(
            'exad_promo_box_enable_content',
            [
                'label'        => __( 'Enable Content', 'exclusive-addons-elementor-pro' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => __( 'On', 'exclusive-addons-elementor-pro' ),
                'label_off'    => __( 'Off', 'exclusive-addons-elementor-pro' ),
                'return_value' => 'yes',
                'default'      => 'yes'
            ]
        );

        $this->add_control(
            'exad_promo_box_enable_countdown',
            [
                'label'        => __( 'Enable CountDown', 'exclusive-addons-elementor-pro' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => __( 'On', 'exclusive-addons-elementor-pro' ),
                'label_off'    => __( 'Off', 'exclusive-addons-elementor-pro' ),
                'return_value' => 'yes',
                'default'      => 'yes'
            ]
        );

        $this->add_control(
            'exad_promo_box_enable_mailchimp',
            [
                'label'        => __( 'Enable MailChimp', 'exclusive-addons-elementor-pro' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => __( 'On', 'exclusive-addons-elementor-pro' ),
                'label_off'    => __( 'Off', 'exclusive-addons-elementor-pro' ),
                'return_value' => 'yes',
                'default'      => 'yes'
            ]
        );

        $this->add_control(
            'exad_promo_box_enable_button',
            [
                'label'        => __( 'Enable Promo Button', 'exclusive-addons-elementor-pro' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => __( 'On', 'exclusive-addons-elementor-pro' ),
                'label_off'    => __( 'Off', 'exclusive-addons-elementor-pro' ),
                'return_value' => 'yes',
                'default'      => 'yes',
                'condition'    => [
                    'exad_promo_box_enable_mailchimp!' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'exad_promo_box_enable_close_button',
            [
                'label'        => __( 'Enable Close Icon', 'exclusive-addons-elementor-pro' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => __( 'On', 'exclusive-addons-elementor-pro' ),
                'label_off'    => __( 'Off', 'exclusive-addons-elementor-pro' ),
                'return_value' => 'yes',
                'default'      => 'no'
            ]
        );

        $this->add_control(
            'exad_promo_box_content_type',
            [
                'label'          => __( 'Type', 'exclusive-addons-elementor-pro' ),
                'type'           => Controls_Manager::SELECT,
                'default'        => 'horizontal',
                'options'        => [
                    'horizontal' => __( 'Horozontal', 'exclusive-addons-elementor-pro' ),
                    'vertical'   => __( 'Vertical', 'exclusive-addons-elementor-pro' )
                ]
            ]
        );

        $this->add_control(
            'exad_promo_box_set_fixed_position',
            [
                'type'        => Controls_Manager::SELECT,
                'label'       => esc_html__( 'Set Position', 'exclusive-addons-elementor-pro' ),
                'default'     => 'none',
                'options'     => [
                    'none'    => __( 'None', 'exclusive-addons-elementor-pro' ),
                    'top'     => __( 'Fixed Top', 'exclusive-addons-elementor-pro' ),
                    'bottom'  => __( 'Fixed Bottom', 'exclusive-addons-elementor-pro' )
                ],
                'description' => esc_html__( 'Stick the promo box to the top or bottom of the page.', 'exclusive-addons-elementor-pro' ),
                'condition' => [
                    'exad_promo_box_content_type' => 'horizontal'
                ]
            ]
        );

        $this->add_control(
            'exad_promo_box_vertical_position',
            [
                'type'    => Controls_Manager::SELECT,
                'label'   => esc_html__( 'Set Position', 'exclusive-addons-elementor-pro' ),
                'default' => 'none',
                'options' => [
                    'none'         => __( 'None', 'exclusive-addons-elementor-pro' ),
                    'top-left'     => __( 'Fixed Top Left', 'exclusive-addons-elementor-pro' ),
                    'top-right'    => __( 'Fixed Top Right', 'exclusive-addons-elementor-pro' ),
                    'bottom-left'  => __( 'Fixed Bottom Left', 'exclusive-addons-elementor-pro' ),
                    'bottom-right' => __( 'Fixed Bottom Right', 'exclusive-addons-elementor-pro' ),
                    'left-center' => __( 'Fixed Left Center', 'exclusive-addons-elementor-pro' ),
                    'right-center' => __( 'Fixed Right Center', 'exclusive-addons-elementor-pro' ),
                ],
                'condition' => [
                    'exad_promo_box_content_type' => 'vertical'
                ]
            ]
        );
        
        $this->end_controls_section();

        $this->start_controls_section(
            'exad_promo_box_image_settings',
            [
                'label'     => __( 'Image', 'exclusive-addons-elementor-pro' ),
                'condition' => [
                    'exad_promo_box_enable_image' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'exad_promo_box_image',
            [
                'type'        => Controls_Manager::MEDIA,
                'default'     => [
                    'url'     => Utils::get_placeholder_image_src()
                ],
                'dynamic' => [
					'active' => true,
				]
            ]
        );

        $this->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
                'name'      => 'thumbnail',
                'default'   => 'thumbnail',
                'condition' => [
                    'exad_promo_box_image[url]!' => ''
                ]
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'exad_promo_box_content_settings',
            [
                'label'     => __( 'Content', 'exclusive-addons-elementor-pro' ),
                'condition' => [
                    'exad_promo_box_enable_content' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'exad_promo_box_content_heading',
            [
                'label'       => __( 'Heading', 'exclusive-addons-elementor-pro' ),
                'type'        => Controls_Manager::TEXTAREA,
                'default'     => __( 'DON\'T MISS OUT.', 'exclusive-addons-elementor-pro' )
            ]
        );

        $this->add_control(
            'exad_promo_box_content_details',
            [
                'label'       => __( 'Details', 'exclusive-addons-elementor-pro' ),
                'type'        => Controls_Manager::TEXTAREA,
                'default'     => __( 'Tickets are on sale for a limited time.', 'exclusive-addons-elementor-pro' )
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'exad_promo_box_countdown_settings',
            [
                'label'     => __( 'Count Down', 'exclusive-addons-elementor-pro' ),
                'condition' => [
                    'exad_promo_box_enable_countdown' => 'yes'
                ]
            ]
        );
        
        $this->add_control(
            'exad_promo_box_countdown_time',
            [
                'label'       => __( 'Count Down Date', 'exclusive-addons-elementor-pro' ),
                'type'        => Controls_Manager::DATE_TIME,
                'default'     => date("Y/m/d", strtotime("+ 1 week")),
                'description' => __( 'Set the date and time here', 'exclusive-addons-elementor-pro' )
            ]
        );

        $this->add_control(
            'exad_promo_box_countdown_expired_text',
            [
                'label'       => __( 'Count Down Expired Title', 'exclusive-addons-elementor-pro' ),
                'type'        => Controls_Manager::TEXT,
                'label_block' => true,
                'default'     => __( 'Hurray! This is the event day.', 'exclusive-addons-elementor-pro' ),
                'description' => __( 'This text will show when the CountDown will over.', 'exclusive-addons-elementor-pro' )
            ]
        );

        $this->add_control(
            'exad_promo_box_countdown_divider_enable',
            [
                'label'        => __( 'Enable Divider', 'exclusive-addons-elementor-pro' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => __( 'On', 'exclusive-addons-elementor-pro' ),
                'label_off'    => __( 'Off', 'exclusive-addons-elementor-pro' ),
                'return_value' => 'yes',
                'default'      => 'no'
            ]
        );

        $this->add_control(
            'exad_promo_box_countdown_title_enable',
            [
                'label'        => __( 'Enable Label', 'exclusive-addons-elementor-pro' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => __( 'On', 'exclusive-addons-elementor-pro' ),
                'label_off'    => __( 'Off', 'exclusive-addons-elementor-pro' ),
                'return_value' => 'yes',
                'default'      => 'yes'
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'exad_promo_box_mailchimp_settings',
            [
                'label'     => __( 'Subscription Form', 'exclusive-addons-elementor-pro' ),
                'condition' => [
                    'exad_promo_box_enable_mailchimp' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'exad_promo_box_mailchimp_items',
            [
                'label'       => __( 'Mailchimp List', 'exclusive-addons-elementor-pro' ),
                'type'        => Controls_Manager::SELECT,
                'label_block' => false,
                'options'     => ProHelper::exad_mailchimp_list_items(),
                'description' => sprintf( __( 'To display MailChimp without an issue, you need to configure MailChimp API key. Please configure API key from the "API Keys" tab <a href="%s" target="_blank" rel="noopener">here</a>. This <a href="%s" target="_blank" rel="noopener">article</a> will help you to find out your API.', 'exclusive-addons-elementor-pro' ), esc_url( $admin_link ), esc_url( $api_link ) )
            ]
        );

        $this->add_control(
            'exad_promo_box_mailchimp_enable_label',
            [
                'label'        => __( 'Enable Label', 'exclusive-addons-elementor-pro' ),
                'type'         => Controls_Manager::SWITCHER,
                'default'      => 'no',
                'return_value' => 'yes'
            ]
        );

        $this->add_control(
            'exad_promo_box_mailchimp_button_text',
            [
                'label'       => __( 'Button Text', 'exclusive-addons-elementor-pro' ),
                'type'        => Controls_Manager::TEXT,
                'label_block' => false,
                'default'     => __( 'Subscribe', 'exclusive-addons-elementor-pro' )
            ]
        );

        $this->add_control(
            'exad_promo_box_mailchimp_loading_text',
            [
                'label'       => __( 'Loading Text', 'exclusive-addons-elementor-pro' ),
                'type'        => Controls_Manager::TEXT,
                'label_block' => false,
                'default'     => __( 'Submitting...', 'exclusive-addons-elementor-pro' )
            ]
        );

        $this->add_control(
            'exad_promo_box_mailchimp_success_text',
            [
                'label'       => __( 'Success Text', 'exclusive-addons-elementor-pro' ),
                'type'        => Controls_Manager::TEXTAREA,
                'label_block' => true,
                'default'     => __( 'You have subscribed successfully...', 'exclusive-addons-elementor-pro' )
            ]
        );

        $this->add_control(
            'exad_promo_box_mailchimp_error_text',
            [
                'label'       => __( 'Error Text', 'exclusive-addons-elementor-pro' ),
                'type'        => Controls_Manager::TEXTAREA,
                'label_block' => true,
                'default'     => __( 'Something goes wrong, please try again later.', 'exclusive-addons-elementor-pro' )
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'exad_promo_box_button_settings',
            [
                'label'     => __( 'Button', 'exclusive-addons-elementor-pro' ),
                'condition' => [
                    'exad_promo_box_enable_mailchimp!' => 'yes',
                    'exad_promo_box_enable_button'     => 'yes'
                ]
            ]
        );

        $this->add_control(
            'exad_promo_box_button_text',
            [
                'label'       => __( 'Text', 'exclusive-addons-elementor-pro' ),
                'type'        => Controls_Manager::TEXT,
                'label_block' => true,
                'default'     => __( 'Our Exclusive Offer', 'exclusive-addons-elementor-pro' )
            ]
        );

        $this->add_control(
            'exad_promo_box_button_link',
            [
                'label'       => __( 'URL', 'exclusive-addons-elementor-pro' ),
                'type'        => Controls_Manager::URL,
                'placeholder' => __( 'https://your-link.com', 'exclusive-addons-elementor-pro' ),
                'label_block' => true,
                'default'     => [
                    'url'         => '#',
                    'is_external' => true
                ]
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'exad_promo_box_responsive_settings',
            [
                'label'     => __( 'Responsive', 'exclusive-addons-elementor-pro' ),
                'condition' => [
                    'exad_promo_box_set_fixed_position!' => 'none'
                ]
            ]
        );

        $this->add_control(
            'exad_promo_box_responsive_icon',
            [
                'label'       => __( 'Toggle Icon', 'exclusive-addons-elementor-pro' ),
                'type'        => Controls_Manager::ICONS,
                'default'     => [
                    'value'   => 'fas fa-check',
                    'library' => 'fa-solid'
                ]
            ]
        ); 

        $this->end_controls_section();

        $this->start_controls_section(
            'exad_promo_box_container_style',
            [
                'label'     => __( 'Container', 'exclusive-addons-elementor-pro' ),
                'tab'       => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_responsive_control(
            'exad_promo_box_container_width',
            [
                'label'       => __( 'Container Width', 'exclusive-addons-elementor-pro' ),
                'type'        => Controls_Manager::SLIDER,
                'size_units'  => [ 'px' ],
                'range'       => [
                    'px'      => [
                        'min' => 0,
                        'max' => 3000
                    ]
                ],
                'selectors'   => [
                    '{{WRAPPER}} .exad-promo-box-wrapper.exad-promo-align-type-vertical.exad-promo-position-bottom-right' => 'width: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .exad-promo-box-wrapper.exad-promo-align-type-vertical.exad-promo-position-bottom-left' => 'width: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .exad-promo-box-wrapper.exad-promo-align-type-vertical.exad-promo-position-top-right' => 'width: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .exad-promo-box-wrapper.exad-promo-align-type-vertical.exad-promo-position-top-left' => 'width: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .exad-promo-box-wrapper.exad-promo-align-type-vertical.exad-promo-position-left-center' => 'width: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .exad-promo-box-wrapper.exad-promo-align-type-vertical.exad-promo-position-right-center' => 'width: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .exad-promo-box-wrapper.exad-promo-position-bottom .exad-promo-box-container.exad-promo-content-type-horizontal' => 'max-width: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .exad-promo-box-wrapper.exad-promo-position-top .exad-promo-box-container.exad-promo-content-type-horizontal' => 'max-width: {{SIZE}}{{UNIT}};'
                ]
            ]
        );

        $this->add_responsive_control(
            'exad_promo_box_container_padding',
            [
                'label'      => esc_html__( 'Padding', 'exclusive-addons-elementor-pro' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'default'    => [
                    'top'    => '0',
                    'right'  => '0',
                    'bottom' => '0',
                    'left'   => '0',
                    'unit'   => 'px'
                ],
                'selectors'  => [
                    '{{WRAPPER}} .exad-promo-box-wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->add_responsive_control(
            'exad_promo_box_container_margin',
            [
                'label'      => esc_html__( 'Margin', 'exclusive-addons-elementor-pro' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'default'    => [
                    'top'    => '0',
                    'right'  => '0',
                    'bottom' => '0',
                    'left'   => '0',
                    'unit'   => 'px'
                ],
                'selectors'  => [
                    '{{WRAPPER}} .exad-promo-box-wrapper' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'     => 'exad_promo_box_container_background',
                'types'    => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}} .exad-promo-box-wrapper'
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'exad_promo_box_container_border',
                'selector' => '{{WRAPPER}} .exad-promo-box-wrapper'
            ]
        );

        $this->add_responsive_control(
            'exad_promo_box_container_border_radius',
            [
                'label'      => esc_html__( 'Border Radius', 'exclusive-addons-elementor-pro' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'default'    => [
                    'top'    => '0',
                    'right'  => '0',
                    'bottom' => '0',
                    'left'   => '0',
                    'unit'   => 'px'
                ],
                'selectors'  => [
                    '{{WRAPPER}} .exad-promo-box-wrapper' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->add_control(
            'exad_promo_box_vertical_container_alignment',
            [
                'label'          => __( 'Alignment', 'exclusive-addons-elementor-pro' ),
                'type'           => Controls_Manager::CHOOSE,
                'label_block'    => true,
                'toggle'         => false,
                'default'        => 'initial',
                'options'        => [
                    'initial'    => [
                        'title'  => __( 'Default', 'exclusive-addons-elementor-pro' ),
                        'icon'   => 'eicon-ban'
                    ],
                    'flex-start' => [
                        'title'  => __( 'Left', 'exclusive-addons-elementor-pro' ),
                        'icon'   => 'eicon-text-align-left'
                    ],
                    'center'     => [
                        'title'  => __( 'Center', 'exclusive-addons-elementor-pro' ),
                        'icon'   => 'eicon-text-align-center'
                    ],
                    'flex-end'   => [
                        'title'  => __( 'Right', 'exclusive-addons-elementor-pro' ),
                        'icon'   => 'eicon-text-align-right'
                    ]
                ],
                'condition'      => [
                    'exad_promo_box_content_type' => 'vertical'
                ]
            ]
        );

        $this->add_responsive_control(
            'exad_promo_box_horizontal_type_each_item_spacing',
            [
                'label'        => __( 'Spacing( between items )', 'exclusive-addons-elementor-pro' ),
                'type'         => Controls_Manager::SLIDER,
                'range'        => [
                    'px'       => [
                        'min'  => 0,
                        'max'  => 80,
                        'step' => 1
                    ]
                ],
                'default'      => [
                    'unit'     => 'px',
                    'size'     => 20
                ],
                'size_units'   => [ 'px', 'em', '%' ],
                'selectors'    => [
                    '{{WRAPPER}} .exad-promo-box-container.exad-promo-content-type-horizontal .exad-promo-box-item:not(:last-child)' => 'margin-right: {{SIZE}}{{UNIT}};'
                ],
                'condition'    => [
                    'exad_promo_box_content_type' => 'horizontal'
                ]
            ]
        );

        $this->add_control(
			'exad_promo_box_container_zindex',
			[
				'label' => __( 'Z-Index', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::NUMBER,
				'min' => -1000,
				'max' => 100000,
                'step' => 1,
                'default' => 11,
                'selectors' => [
                    '{{WRAPPER}} .exad-promo-box-wrapper.exad-promo-position-top' => 'z-index: {{VALUE}}',
                    '{{WRAPPER}} .exad-promo-box-wrapper.exad-promo-position-bottom' => 'z-index: {{VALUE}}',
                    '{{WRAPPER}} .exad-promo-box-wrapper.exad-promo-align-type-vertical.exad-promo-position-top-left' => 'z-index: {{VALUE}}',
                    '{{WRAPPER}} .exad-promo-box-wrapper.exad-promo-align-type-vertical.exad-promo-position-top-right' => 'z-index: {{VALUE}}',
                    '{{WRAPPER}} .exad-promo-box-wrapper.exad-promo-align-type-vertical.exad-promo-position-bottom-left' => 'z-index: {{VALUE}}',
                    '{{WRAPPER}} .exad-promo-box-wrapper.exad-promo-align-type-vertical.exad-promo-position-bottom-right' => 'z-index: {{VALUE}}',
                    '{{WRAPPER}} .exad-promo-box-wrapper.exad-promo-align-type-vertical.exad-promo-position-left-center' => 'z-index: {{VALUE}}',
                    '{{WRAPPER}} .exad-promo-box-wrapper.exad-promo-align-type-vertical.exad-promo-position-right-center' => 'z-index: {{VALUE}}',
                ]
			]
        );
        
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'exad_promo_box_container_shadow',
                'selector' => '{{WRAPPER}} .exad-promo-box-wrapper'
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'exad_promo_box_image_style',
            [
                'label'     => __( 'Image', 'exclusive-addons-elementor-pro' ),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'exad_promo_box_image[url]!'  => '',
                    'exad_promo_box_enable_image' => 'yes'
                ]
            ]
        );

        $this->add_responsive_control(
            'exad_promo_box_image_height',
            [
                'label'       => __( 'Height', 'exclusive-addons-elementor-pro' ),
                'type'        => Controls_Manager::SLIDER,
                'size_units'  => [ 'px' ],
                'range'       => [
                    'px'      => [
                        'min' => 0,
                        'max' => 300
                    ]
                ],
                'selectors'   => [
                    '{{WRAPPER}} .exad-promo-logo' => 'height: {{SIZE}}{{UNIT}};'
                ]
            ]
        );

        $this->add_responsive_control(
            'exad_promo_box_image_width',
            [
                'label'       => __( 'Width', 'exclusive-addons-elementor-pro' ),
                'type'        => Controls_Manager::SLIDER,
                'size_units'  => [ 'px' ],
                'range'       => [
                    'px'      => [
                        'min' => 0,
                        'max' => 300
                    ]
                ],
                'selectors'   => [
                    '{{WRAPPER}} .exad-promo-logo' => 'width: {{SIZE}}{{UNIT}};'
                ]
            ]
        );

        $this->add_responsive_control(
            'exad_promo_box_image_padding',
            [
                'label'      => __( 'Padding', 'exclusive-addons-elementor-pro' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'default'    => [
                    'top'    => '0',
                    'right'  => '0',
                    'bottom' => '0',
                    'left'   => '0',
                    'unit'   => 'px'
                ],
                'selectors'  => [
                    '{{WRAPPER}} .exad-promo-logo' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );        

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'exad_promo_box_image_border',
                'selector' => '{{WRAPPER}} .exad-promo-logo'
            ]
        );

        $this->add_responsive_control(
            'exad_promo_box_image_radius',
            [
                'label'      => esc_html__( 'Border Radius', 'exclusive-addons-elementor-pro' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'default'    => [
                    'top'    => '0',
                    'right'  => '0',
                    'bottom' => '0',
                    'left'   => '0',
                    'unit'   => 'px'
                ],
                'selectors'  => [
                    '{{WRAPPER}} .exad-promo-logo' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'exad_promo_box_image_shadow',
                'selector' => '{{WRAPPER}} .exad-promo-logo'
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'exad_promo_box_content_style',
            [
                'label'     => __( 'Content', 'exclusive-addons-elementor-pro' ),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'exad_promo_box_enable_content' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'exad_promo_box_content_heading_style',
            [
                'label'     => __( 'Heading', 'exclusive-addons-elementor-pro' ),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before'
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'exad_promo_box_content_heading_typography',
                'selector' => '{{WRAPPER}} .exad-promo-box-wrapper .exad-promo-content-container h3'
            ]
        );

        $this->add_control(
            'exad_promo_box_content_heading_color',
            [
                'label'     => __( 'Color', 'exclusive-addons-elementor-pro' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#000000',
                'selectors' => [
                    '{{WRAPPER}} .exad-promo-box-wrapper .exad-promo-content-container h3' => 'color: {{VALUE}};'
                ]
            ]
        );

        $this->add_responsive_control(
            'exad_promo_box_content_heading_margin',
            [
                'label'      => __( 'Margin', 'exclusive-addons-elementor-pro' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],                
                'selectors'  => [
                    '{{WRAPPER}} .exad-promo-box-wrapper .exad-promo-content-container h3' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->add_control(
            'exad_promo_box_content_details_style',
            [
                'label'     => __( 'Details', 'exclusive-addons-elementor-pro' ),
                'type'      => Controls_Manager::HEADING
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'exad_promo_box_content_details_typography',
                'selector' => '{{WRAPPER}} .exad-promo-box-wrapper .exad-promo-content-container p'
            ]
        );

        $this->add_control(
            'exad_promo_box_content_details_color',
            [
                'label'     => __( 'Color', 'exclusive-addons-elementor-pro' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#000000',
                'selectors' => [
                    '{{WRAPPER}} .exad-promo-box-wrapper .exad-promo-content-container p' => 'color: {{VALUE}};'
                ]
            ]
        );

        $this->add_responsive_control(
            'exad_promo_box_content_details_margin',
            [
                'label'      => __( 'Margin', 'exclusive-addons-elementor-pro' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],                
                'selectors'  => [
                    '{{WRAPPER}} .exad-promo-box-wrapper .exad-promo-content-container p' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'exad_promo_box_countdown_style',
            [
                'label'     => __( 'Count Down', 'exclusive-addons-elementor-pro' ),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'exad_promo_box_enable_countdown' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'exad_promo_box_countdown_item_field_style',
            [
                'label'     => __( 'Item', 'exclusive-addons-elementor-pro' ),
                'type'      => Controls_Manager::HEADING
            ]
        );

        $this->add_responsive_control(
            'exad_promo_box_countdown_each_item_spacing',
            [
                'label'        => __( 'Spacing( between items )', 'exclusive-addons-elementor-pro' ),
                'type'         => Controls_Manager::SLIDER,
                'range'        => [
                    'px'       => [
                        'min'  => 0,
                        'max'  => 80,
                        'step' => 1
                    ]
                ],
                'default'      => [
                    'unit'     => 'px',
                    'size'     => 20
                ],
                'size_units'   => [ 'px', 'em', '%' ],
                'selectors'    => [
                    '{{WRAPPER}} .exad-countdown .exad-countdown-container:not(:last-child)' => 'margin-right: {{SIZE}}{{UNIT}};'
                ]
            ]
        );

        $this->add_responsive_control(
            'exad_promo_box_countdown_item_padding',
            [
                'label'      => esc_html__( 'Padding', 'exclusive-addons-elementor-pro' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'selectors'  => [
                    '{{WRAPPER}} .exad-countdown .exad-countdown-container' => 'padding: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;'
                ]
            ]
        );

        $this->add_responsive_control(
            'exad_promo_box_countdown_item_margin',
            [
                'label'      => esc_html__( 'Margin', 'exclusive-addons-elementor-pro' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'selectors'  => [
                    '{{WRAPPER}} .exad-countdown .exad-countdown-container' => 'margin: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'     => 'exad_promo_box_countdown_item_background',
                'types'    => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}} .exad-countdown .exad-countdown-container'
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'exad_promo_box_countdown_item_box_shadow',
                'selector' => '{{WRAPPER}} .exad-countdown .exad-countdown-container'
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'exad_promo_box_countdown_item_box_border',
                'selector' => '{{WRAPPER}} .exad-countdown .exad-countdown-container'
            ]
        );

        $this->add_responsive_control(
            'exad_promo_box_countdown_item_border_radius',
            [
                'label'      => esc_html__( 'Border Radius', 'exclusive-addons-elementor-pro' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'selectors'  => [
                    '{{WRAPPER}} .exad-countdown .exad-countdown-container' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;'
                ]
            ]
        );

        $this->add_control(
            'exad_promo_box_countdown_counter_field_style',
            [
                'label'     => __( 'Digits', 'exclusive-addons-elementor-pro' ),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before'
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'exad_promo_box_countdown_counter_typography',
                'selector' => '{{WRAPPER}} .exad-countdown-count'
            ]
        );

        $this->add_control(
            'exad_promo_box_countdown_counter_color',
            [
                'label'     => __( 'Text Color', 'exclusive-addons-elementor-pro' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#000000',
                'selectors' => [
                    '{{WRAPPER}} .exad-countdown-count' => 'color: {{VALUE}};'
                ]
            ]
        );

        $this->add_responsive_control(
            'exad_promo_box_countdown_counter_margin',
            [
                'label'      => __( 'Margin', 'exclusive-addons-elementor-pro' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],                
                'selectors'  => [
                    '{{WRAPPER}} .exad-countdown-count' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->add_control(
            'exad_promo_box_countdown_title_field_style',
            [
                'label'     => __( 'Label', 'exclusive-addons-elementor-pro' ),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before'
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
                [
                    'name'     => 'exad_promo_box_countdown_title_typography',
                    'selector' => '{{WRAPPER}} .exad-countdown-title'
                ]
        );

        $this->add_control(
            'exad_promo_box_countdown_title_color',
            [
                'label'     => __( 'Text Color', 'exclusive-addons-elementor-pro' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#000000',
                'selectors' => [
                    '{{WRAPPER}} .exad-countdown-title' => 'color: {{VALUE}};'
                ]
            ]
        );

        $this->add_responsive_control(
            'exad_promo_box_countdown_title_margin',
            [
                'label'      => __( 'Margin', 'exclusive-addons-elementor-pro' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],                
                'selectors'  => [
                    '{{WRAPPER}} .exad-countdown-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->add_control(
            'exad_promo_box_countdown_divider_style',
            [
                'label'     => __( 'Divider', 'exclusive-addons-elementor-pro' ),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
                'condition' => [
                    'exad_promo_box_countdown_divider_enable' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'exad_promo_box_countdown_divider_color',
            [
                'label'     => __( 'Divider Color', 'exclusive-addons-elementor-pro' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#000000',
                'selectors' => [
                    '{{WRAPPER}} .exad-countdown.exad-countdown-divider .exad-countdown-container::after' => 'color: {{VALUE}};'
                ],
                'condition' => [
                    'exad_promo_box_countdown_divider_enable' => 'yes'
                ]
            ]
        );

        $this->add_responsive_control(
            'exad_promo_box_countdown_divider_size',
            [
                'label'        => __( 'Size', 'exclusive-addons-elementor-pro' ),
                'type'         => Controls_Manager::SLIDER,
                'size_units'   => [ 'px', '%' ],
                'range'        => [
                    'px'       => [
                        'min'  => 30,
                        'max'  => 100,
                        'step' => 5
                    ],
                    '%'        => [
                        'min'  => 0,
                        'max'  => 100
                    ]
                ],
                'default'      => [
                    'unit'     => 'px',
                    'size'     => 30
                ],
                'selectors'    => [
                    '{{WRAPPER}} .exad-countdown.exad-countdown-divider .exad-countdown-container::after' => 'font-size: {{SIZE}}{{UNIT}};'
                ],
                'condition'    => [
                    'exad_promo_box_countdown_divider_enable' => 'yes'
                ]
            ]
        );

        $this->add_responsive_control(
            'exad_promo_box_countdown_divider_position_right',
            [
                'label'        => __( 'Offset-X', 'exclusive-addons-elementor-pro' ),
                'type'         => Controls_Manager::SLIDER,
                'size_units'   => [ 'px', '%' ],
                'range'        => [
                    '%'        => [
                        'min'  => -100,
                        'max'  => 100,
                        'step' => 1
                    ],
                    'px'       => [
                        'min'  => -100,
                        'max'  => 100,
                        'step' => 1
                    ]
                ],
                'default'      => [
                    'unit'     => 'px',
                    'size'     => -15
                ],
                'selectors'    => [
                    '{{WRAPPER}} .exad-countdown.exad-countdown-divider .exad-countdown-container::after' => 'right: {{SIZE}}{{UNIT}};'
                ],
                'condition'    => [
                    'exad_promo_box_countdown_divider_enable' => 'yes'
                ]
            ]
        );

        $this->add_responsive_control(
            'exad_promo_box_countdown_divider_position_left',
            [
                'label'        => __( 'Offset-Y', 'exclusive-addons-elementor-pro' ),
                'type'         => Controls_Manager::SLIDER,
                'size_units'   => [ 'px', '%' ],
                'range'        => [
                    '%'        => [
                        'min'  => -100,
                        'max'  => 100,
                        'step' => 1
                    ],
                    'px'       => [
                        'min'  => -200,
                        'max'  => 200,
                        'step' => 1
                    ]
                ],
                'default'      => [
                    'unit'     => '%',
                    'size'     => -30
                ],
                'selectors'    => [
                    '{{WRAPPER}} .exad-countdown.exad-countdown-divider .exad-countdown-container::after' => 'top: {{SIZE}}{{UNIT}};'
                ],
                'condition'    => [
                    'exad_promo_box_countdown_divider_enable' => 'yes'
                ]
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'exad_promo_box_mailchimp_form_style',
            [
                'label'     => __( 'Subscription Form', 'exclusive-addons-elementor-pro' ),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'exad_promo_box_enable_mailchimp' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'exad_promo_box_mailchimp_email_field_style',
            [
                'label'     => __( 'Email Form', 'exclusive-addons-elementor-pro' ),
                'type'      => Controls_Manager::HEADING
            ]
        );

        $this->add_responsive_control(
            'exad_promo_box_mailchimp_email_field_width',
            [
                'label'        => __( 'Width', 'exclusive-addons-elementor-pro' ),
                'type'         => Controls_Manager::SLIDER,
                'range'        => [
                    'px'       => [
                        'min'  => 0,
                        'max'  => 500,
                        'step' => 1
                    ]
                ],
                'size_units'   => [ 'px' ],
                'selectors'    => [
                    '{{WRAPPER}} .exad-mailchimp-container .exad-mailchimp-input-field' => 'width: {{SIZE}}{{UNIT}};'
                ]
            ]
        );

        $this->add_responsive_control(
            'exad_promo_box_mailchimp_email_field_height',
            [
                'label'        => __( 'Height', 'exclusive-addons-elementor-pro' ),
                'type'         => Controls_Manager::SLIDER,
                'range'        => [
                    'px'       => [
                        'min'  => 0,
                        'max'  => 100,
                        'step' => 1
                    ]
                ],
                'default'      => [
                    'unit'     => 'px',
                    'size'     => 36
                ],
                'size_units'   => [ 'px' ],
                'selectors'    => [
                    '{{WRAPPER}} .exad-mailchimp-container .exad-mailchimp-input-field' => 'height: {{SIZE}}{{UNIT}};'
                ]
            ]
        );

        $this->add_control(
            'exad_promo_box_mailchimp_email_bg_color',
            [
                'label'     => __( 'Background Color', 'exclusive-addons-elementor-pro' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#F4F4F4',
                'selectors' => [
                    '{{WRAPPER}} .exad-mailchimp-container .exad-mailchimp-input-field' => 'background-color: {{VALUE}};'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'exad_promo_box_mailchimp_email_typography',
                'selector' => '{{WRAPPER}} .exad-mailchimp-container .exad-mailchimp-input-field'
            ]
        );

        $this->add_control(
            'exad_promo_box_mailchimp_email_text_color',
            [
                'label'     => __( 'Text Color', 'exclusive-addons-elementor-pro' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .exad-mailchimp-container .exad-mailchimp-input-field' => 'color: {{VALUE}};'
                ]
            ]
        );

        $this->add_control(
            'exad_promo_box_mailchimp_email_placeholder_text_color',
            [
                'label'     => __( 'Placeholder Text Color', 'exclusive-addons-elementor-pro' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#A5A5A5',
                'selectors' => [
                    '{{WRAPPER}} .exad-mailchimp-container .exad-mailchimp-input-field::placeholder' => 'color: {{VALUE}};'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'exad_promo_box_mailchimp_email_field_border',
                'selector' => '{{WRAPPER}} .exad-mailchimp-container .exad-mailchimp-input-field'
            ]
        );

        $this->add_responsive_control(
            'exad_promo_box_mailchimp_email_padding',
            [
                'label'        => __('Padding', 'exclusive-addons-elementor-pro'),
                'type'         => Controls_Manager::DIMENSIONS,
                'size_units'   => ['px', '%'],
                'default'      => [
                    'top'      => 10,
                    'right'    => 15,
                    'bottom'   => 10,
                    'left'     => 15,
                    'unit'     => 'px',
                    'isLinked' => false
                ],
                'selectors'    => [
                    '{{WRAPPER}} .exad-mailchimp-container .exad-mailchimp-input-field' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->add_responsive_control(
            'exad_promo_box_mailchimp_email_spacing',
            [
                'label'        => __( 'Spacing', 'exclusive-addons-elementor-pro' ),
                'type'         => Controls_Manager::SLIDER,
                'range'        => [
                    'px'       => [
                        'min'  => 0,
                        'max'  => 200,
                        'step' => 1
                    ]
                ],
                'default'      => [
                    'unit'     => 'px',
                    'size'     => 15
                ],
                'size_units'   => [ 'px', 'em', '%' ],
                'selectors'    => [
                    '{{WRAPPER}} .exad-mailchimp-container.exad-mailchimp-type-horizontal .exad-mailchimp-item:not(:last-child)' => 'margin-right: {{SIZE}}{{UNIT}};'
                ]
            ]
        );

        $this->add_responsive_control(
            'exad_promo_box_mailchimp_email_border_radius',
            [
                'label'      => __('Border Radius', 'exclusive-addons-elementor-pro'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'default'    => [
                    'top'    => 0,
                    'right'  => 0,
                    'bottom' => 0,
                    'left'   => 0,
                    'unit'   => 'px'
                ],
                'selectors'  => [
                    '{{WRAPPER}} .exad-mailchimp-container .exad-mailchimp-input-field' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'exad_promo_box_mailchimp_email_shadow',
                'selector' => '{{WRAPPER}} .exad-mailchimp-container .exad-mailchimp-input-field'
            ]
        );   

        $this->add_control(
            'exad_promo_box_mailchimp_button_style',
            [
                'label'     => __( 'Submit Button', 'exclusive-addons-elementor-pro' ),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before'
            ]
        );

        $this->add_responsive_control(
            'exad_promo_box_mailchimp_form_submit_btn_width',
            [
                'label'       => __( 'Button Width', 'exclusive-addons-elementor-pro' ),
                'type'        => Controls_Manager::SLIDER,
                'size_units'  => [ 'px', 'em', '%' ],
                'range'       => [
                    'px'      => [
                        'min' => 10,
                        'max' => 1500
                    ],
                    'em'      => [
                        'min' => 1,
                        'max' => 80
                    ]
                ],
                'selectors'   => [
                    '{{WRAPPER}} button.exad-mailchimp-subscribe-btn' => 'width: {{SIZE}}{{UNIT}};'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'exad_promo_box_mailchimp_form_submit_btn_typography',
                'selector' => '{{WRAPPER}} button.exad-mailchimp-subscribe-btn'
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'exad_promo_box_mailchimp_form_submit_btn_box_shadow',
                'selector' => '{{WRAPPER}} button.exad-mailchimp-subscribe-btn'
            ]
        );      

        $this->add_responsive_control(
            'exad_promo_box_mailchimp_form_submit_btn_margin',
            [
                'label'      => __( 'Margin', 'exclusive-addons-elementor-pro' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} button.exad-mailchimp-subscribe-btn' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );  
        
        $this->add_responsive_control(
            'exad_promo_box_mailchimp_form_submit_btn_padding',
            [
                'label'        => __( 'Padding', 'exclusive-addons-elementor-pro' ),
                'type'         => Controls_Manager::DIMENSIONS,
                'size_units'   => [ 'px', 'em', '%' ],
                'default'      => [
                    'top'      => '7',
                    'right'    => '20',
                    'bottom'   => '7',
                    'left'     => '20',
                    'unit'     => 'px',
                    'isLinked' => false
                ],
                'selectors'    => [
                    '{{WRAPPER}} button.exad-mailchimp-subscribe-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );      
        
        $this->start_controls_tabs( 'exad_promo_box_mailchimp_form_submit_button_tabs' );

        $this->start_controls_tab( 'exad_promo_box_mailchimp_form_submit_button_normal', [ 'label' => __( 'Normal', 'exclusive-addons-elementor-pro' ) ] );

        $this->add_control(
            'exad_promo_box_mailchimp_form_submit_btn_text_color',
            [
                'label'     => __( 'Text Color', 'exclusive-addons-elementor-pro' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} button.exad-mailchimp-subscribe-btn' => 'color: {{VALUE}};'
                ]
            ]
        );

        $this->add_control(
            'exad_promo_box_mailchimp_form_submit_btn_background_color',
            [
                'label'     => __( 'Background Color', 'exclusive-addons-elementor-pro' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#7a56ff',
                'selectors' => [
                    '{{WRAPPER}} button.exad-mailchimp-subscribe-btn' => 'background-color: {{VALUE}};'
                ]
            ]
        );
        
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'               => 'exad_promo_box_mailchimp_form_submit_btn_border',
                'fields_options'     => [
                    'border'         => [
                        'default'    => 'solid'
                    ],
                    'width'          => [
                        'default'    => [
                            'top'    => '1',
                            'right'  => '1',
                            'bottom' => '1',
                            'left'   => '1'
                        ]
                    ],
                    'color'          => [
                        'default'    => '#7a56ff'
                    ]
                ],
                'selector'           => '{{WRAPPER}} button.exad-mailchimp-subscribe-btn'
            ]
        );

        $this->add_responsive_control(
            'exad_promo_box_mailchimp_form_submit_btn_border_radius',
            [
                'label'        => __('Border Radius', 'exclusive-addons-elementor-pro'),
                'type'         => Controls_Manager::DIMENSIONS,
                'size_units'   => ['px', '%'],
                'default'      => [
                    'top'      => '0',
                    'right'    => '0',
                    'bottom'   => '0',
                    'left'     => '0',
                    'isLinked' => false
                ],
                'selectors'    => [
                    '{{WRAPPER}} button.exad-mailchimp-subscribe-btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );
        
        $this->end_controls_tab();

        $this->start_controls_tab( 'exad_promo_box_mailchimp_form_submit_button_hover', [ 'label' => __( 'Hover', 'exclusive-addons-elementor-pro' ) ] );

        $this->add_control(
            'exad_promo_box_mailchimp_form_submit_btn_hover_text_color',
            [
                'label'     => __( 'Text Color', 'exclusive-addons-elementor-pro' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#7a56ff',
                'selectors' => [
                    '{{WRAPPER}} button.exad-mailchimp-subscribe-btn:hover' => 'color: {{VALUE}};'
                ]
            ]
        );

        $this->add_control(
            'exad_promo_box_mailchimp_form_submit_btn_hover_background_color',
            [
                'label'     => __( 'Background Color', 'exclusive-addons-elementor-pro' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} button.exad-mailchimp-subscribe-btn:hover' => 'background-color: {{VALUE}};'
                ]
            ]
        );

        $this->add_control(
            'exad_promo_box_mailchimp_form_submit_btn_hover_border_color',
            [
                'label'     => __( 'Border Color', 'exclusive-addons-elementor-pro' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} button.exad-mailchimp-subscribe-btn:hover' => 'border-color: {{VALUE}};'
                ]
            ]
        );
        
        $this->end_controls_tab();
        
        $this->end_controls_tabs();
        
        $this->end_controls_section();

        $this->start_controls_section(
            'exad_promo_box_button_style',
            [
                'label'     => __( 'Button', 'exclusive-addons-elementor-pro' ),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'exad_promo_box_enable_mailchimp!' => 'yes',
                    'exad_promo_box_enable_button'     => 'yes'
                ]
            ]
        );

        $this->add_responsive_control(
            'exad_promo_box_button_width',
            [
                'label'       => __( 'Button Width', 'exclusive-addons-elementor-pro' ),
                'type'        => Controls_Manager::SLIDER,
                'size_units'  => [ 'px', 'em', '%' ],
                'range'       => [
                    'px'      => [
                        'min' => 10,
                        'max' => 1500
                    ],
                    'em'      => [
                        'min' => 1,
                        'max' => 80
                    ]
                ],
                'selectors'   => [
                    '{{WRAPPER}} .exad-promo-box-container a.exad-promo-button-link' => 'width: {{SIZE}}{{UNIT}};'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'exad_promo_box_button_typography',
                'selector' => '{{WRAPPER}} a.exad-promo-button-link'
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'exad_promo_box_button_box_shadow',
                'selector' => '{{WRAPPER}} a.exad-promo-button-link'
            ]
        );      

        $this->add_responsive_control(
            'exad_promo_box_button_margin',
            [
                'label'      => __( 'Margin', 'exclusive-addons-elementor-pro' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} a.exad-promo-button-link' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );  
        
        $this->add_responsive_control(
            'exad_promo_box_button_padding',
            [
                'label'        => __( 'Padding', 'exclusive-addons-elementor-pro' ),
                'type'         => Controls_Manager::DIMENSIONS,
                'size_units'   => [ 'px', 'em', '%' ],
                'default'      => [
                    'top'      => '7',
                    'right'    => '20',
                    'bottom'   => '7',
                    'left'     => '20',
                    'unit'     => 'px',
                    'isLinked' => false
                ],
                'selectors'    => [
                    '{{WRAPPER}} a.exad-promo-button-link' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );      
        
        $this->start_controls_tabs( 'exad_promo_box_button_tabs' );

        $this->start_controls_tab( 'exad_promo_box_button_normal', [ 'label' => __( 'Normal', 'exclusive-addons-elementor-pro' ) ] );

        $this->add_control(
            'exad_promo_box_button_text_color',
            [
                'label'     => __( 'Text Color', 'exclusive-addons-elementor-pro' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} a.exad-promo-button-link' => 'color: {{VALUE}};'
                ]
            ]
        );

        $this->add_control(
            'exad_promo_box_button_background_color',
            [
                'label'     => __( 'Background Color', 'exclusive-addons-elementor-pro' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#7a56ff',
                'selectors' => [
                    '{{WRAPPER}} a.exad-promo-button-link' => 'background-color: {{VALUE}};'
                ]
            ]
        );
        
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'               => 'exad_promo_box_button_border',
                'fields_options'     => [
                    'border'         => [
                        'default'    => 'solid'
                    ],
                    'width'          => [
                        'default'    => [
                            'top'    => '1',
                            'right'  => '1',
                            'bottom' => '1',
                            'left'   => '1'
                        ]
                    ],
                    'color'          => [
                        'default'    => '#7a56ff'
                    ]
                ],
                'selector'           => '{{WRAPPER}} a.exad-promo-button-link'
            ]
        );

        $this->add_responsive_control(
            'exad_promo_box_button_border_radius',
            [
                'label'        => __('Border Radius', 'exclusive-addons-elementor-pro'),
                'type'         => Controls_Manager::DIMENSIONS,
                'size_units'   => ['px', '%'],
                'default'      => [
                    'top'      => '0',
                    'right'    => '0',
                    'bottom'   => '0',
                    'left'     => '0',
                    'isLinked' => false
                ],
                'selectors'    => [
                    '{{WRAPPER}} a.exad-promo-button-link' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );
        
        $this->end_controls_tab();

        $this->start_controls_tab( 'exad_promo_box_button_hover', [ 'label' => __( 'Hover', 'exclusive-addons-elementor-pro' ) ] );

        $this->add_control(
            'exad_promo_box_button_hover_text_color',
            [
                'label'     => __( 'Text Color', 'exclusive-addons-elementor-pro' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#7a56ff',
                'selectors' => [
                    '{{WRAPPER}} a.exad-promo-button-link:hover' => 'color: {{VALUE}};'
                ]
            ]
        );

        $this->add_control(
            'exad_promo_box_button_hover_background_color',
            [
                'label'     => __( 'Background Color', 'exclusive-addons-elementor-pro' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} a.exad-promo-button-link:hover' => 'background-color: {{VALUE}};'
                ]
            ]
        );

        $this->add_control(
            'exad_promo_box_button_hover_border_color',
            [
                'label'     => __( 'Border Color', 'exclusive-addons-elementor-pro' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} a.exad-promo-button-link:hover' => 'border-color: {{VALUE}};'
                ]
            ]
        );
        
        $this->end_controls_tab();
        
        $this->end_controls_tabs();
        
        $this->end_controls_section();

        $this->start_controls_section(
            'exad_promo_box_close_icon_style',
            [
                'label'     => esc_html__( 'Close Icon', 'exclusive-addons-elementor-pro' ),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'exad_promo_box_enable_close_button' => 'yes'
                ]
            ]
        );

        $this->add_responsive_control(
            'exad_promo_box_close_icon_size',
            [
                'label'        => esc_html__( 'Size', 'exclusive-addons-elementor-pro' ),
                'type'         => Controls_Manager::SLIDER,
                'range'        => [
                    'px'       => [
                        'min'  => 0,
                        'max'  => 60,
                    ]
                ],
                'default'      => [
                    'unit'     => 'px',
                    'size'     => 16
                ],
                'selectors'    => [
                    '{{WRAPPER}} .exad-promo-box-container .exad-promo-box-dismiss-icon svg' => 'width: {{SIZE}}px; height: {{SIZE}}px;'
                ]
            ]
        );

        $this->add_control(
            'exad_promo_box_close_icon_color',
            [
                'label'     => esc_html__( 'Color', 'exclusive-addons-elementor-pro' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#A1A5B5',
                'selectors' => [
                  '{{WRAPPER}} .exad-promo-box-container .exad-promo-box-dismiss-icon svg path' => 'fill: {{VALUE}};'
                ]
            ]
        );

        $dismiss_icon_spacing = is_rtl() ? 'left: {{SIZE}}{{UNIT}};' : 'right: {{SIZE}}{{UNIT}};';

        $this->add_responsive_control(
            'exad_promo_box_close_icon_pos_right',
            [
                'label'      => esc_html__( 'Offset-X', 'exclusive-addons-elementor-pro' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%' ],
                'default'    => [
                    'unit'   => 'px',
                    'size'   => 0
                ],
                'range'        => [
                    'px'       => [
                        'min'  => -300,
                        'max'  => 300,
                        'step' => 1
                    ],
                    '%'        => [
                        'min'  => -100,
                        'max'  => 100,
                        'step' => 1
                    ]
                ],
                'selectors'  => [
                    '{{WRAPPER}} .exad-promo-box-container .exad-promo-box-dismiss-icon' => $dismiss_icon_spacing
                ]
            ]
        );

        $this->add_responsive_control(
          'exad_promo_box_close_icon_pos_top',
            [
                'label'      => esc_html__( 'Offset-Y', 'exclusive-addons-elementor-pro' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%' ],
                'default'    => [
                    'unit'   => 'px',
                    'size'   => 7
                ],
                'range'        => [
                    'px'       => [
                        'min'  => 0,
                        'max'  => 100,
                        'step' => 1
                    ],
                    '%'        => [
                        'min'  => -100,
                        'max'  => 100,
                        'step' => 1
                    ]
                ],
                'selectors'  => [
                    '{{WRAPPER}} .exad-promo-box-container .exad-promo-box-dismiss-icon' => 'top: {{SIZE}}{{UNIT}};'
                ]
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'exad_promo_box_responsive_style_settings',
            [
                'label'     => __( 'Responsive', 'exclusive-addons-elementor-pro' ),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'exad_promo_box_set_fixed_position!' => 'none'
                ]
            ]
        );

        $this->add_control(
            'exad_promo_box_visible_part_style',
            [
                'label'     => __( 'Visible Part', 'exclusive-addons-elementor-pro' ),
                'type'      => Controls_Manager::HEADING
            ]
        );

        $this->add_control(
            'exad_promo_box_visible_part_color',
            [
                'label'     => __( 'Color', 'exclusive-addons-elementor-pro' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#000000',
                'selectors' => [
                    '{{WRAPPER}} .exad-promo-box-wrapper.exad-responsive-promo-box .exad-promo-content-container.exad-promo-responsive-heading h3' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .exad-promo-box-wrapper.exad-responsive-promo-box .exad-promo-content-container.exad-promo-responsive-heading p' => 'color: {{VALUE}};'
                ]
            ]
        );

        $this->add_control(
            'exad_promo_box_visible_part_bg_color',
            [
                'label'     => __( 'Background Color', 'exclusive-addons-elementor-pro' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .exad-promo-box-wrapper.exad-responsive-promo-box' => 'background-color: {{VALUE}};'
                ]
            ]
        );

        $this->add_control(
            'exad_promo_box_visible_part_opening_icon_color',
            [
                'label'     => __( 'Toggle( Opening ) Icon Color', 'exclusive-addons-elementor-pro' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#000000',
                'selectors' => [
                    '{{WRAPPER}} .exad-promo-responive-open-icon i' => 'color: {{VALUE}};'
                ]
            ]
        );

        $this->add_responsive_control(
            'exad_promo_box_visible_part_opening_icon_size',
            [
                'label'        => __( 'Toggle( Opening ) Icon Size', 'exclusive-addons-elementor-pro' ),
                'type'         => Controls_Manager::SLIDER,
                'range'        => [
                    'px'       => [
                        'min'  => 0,
                        'max'  => 50,
                        'step' => 1
                    ]
                ],
                'default'      => [
                    'unit'     => 'px',
                    'size'     => 20
                ],
                'size_units'   => [ 'px' ],
                'selectors'    => [
                    '{{WRAPPER}} .exad-promo-responive-open-icon i' => 'font-size: {{SIZE}}{{UNIT}};'
                ]
            ]
        );

        $this->add_control(
            'exad_promo_box_sliding_part_style',
            [
                'label'     => __( 'Sliding Part', 'exclusive-addons-elementor-pro' ),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before'
            ]
        );

        $this->add_control(
            'exad_promo_box_sliding_part_color',
            [
                'label'     => __( 'Color', 'exclusive-addons-elementor-pro' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#000000',
                'selectors' => [ 
                    '{{WRAPPER}} .exad-promo-box-wrapper.exad-responsive-promo-box .exad-promo-content-container h3' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .exad-promo-box-wrapper.exad-responsive-promo-box .exad-promo-content-container p' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .exad-promo-box-wrapper.exad-responsive-promo-box .exad-countdown-count'         => 'color: {{VALUE}};',
                    '{{WRAPPER}} .exad-promo-box-wrapper.exad-responsive-promo-box .exad-countdown-title'         => 'color: {{VALUE}};',
                    '{{WRAPPER}} .exad-promo-box-wrapper.exad-responsive-promo-box .exad-countdown.exad-countdown-divider .exad-countdown-container::after'  => 'color: {{VALUE}};'
                ]
            ]
        );

        $this->add_control(
            'exad_promo_box_sliding_part_bg_color',
            [
                'label'     => __( 'Background Color', 'exclusive-addons-elementor-pro' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .exad-promo-box-wrapper.exad-responsive-promo-box .exad-promo-box-container' => 'background-color: {{VALUE}};'
                ]
            ]
        );

        $this->add_control(
            'exad_promo_box_sliding_part_closing_icon_color',
            [
                'label'     => __( 'Toggle( Closing ) Icon Color', 'exclusive-addons-elementor-pro' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#000000',
                'selectors' => [
                    '{{WRAPPER}} .exad-promo-responive-close-icon i' => 'color: {{VALUE}};'
                ]
            ]
        );

        $this->add_responsive_control(
            'exad_promo_box_sliding_part_closing_icon_size',
            [
                'label'        => __( 'Toggle( Closing ) Icon Size', 'exclusive-addons-elementor-pro' ),
                'type'         => Controls_Manager::SLIDER,
                'range'        => [
                    'px'       => [
                        'min'  => 0,
                        'max'  => 50,
                        'step' => 1
                    ]
                ],
                'default'      => [
                    'unit'     => 'px',
                    'size'     => 20
                ],
                'size_units'   => [ 'px' ],
                'selectors'    => [
                    '{{WRAPPER}} .exad-promo-responive-close-icon i' => 'font-size: {{SIZE}}{{UNIT}};'
                ]
            ]
        );

        $this->end_controls_section();

    }

    protected function render() {
        $settings                   = $this->get_settings_for_display();
        $api_key                    = get_option('exad_save_mailchimp_api');
        $countdown_title_visibility = 'yes';

        if( 'yes' !== $settings['exad_promo_box_countdown_title_enable'] ) :
            $countdown_title_visibility = 'no';
        endif;

        $this->add_render_attribute(
            'exad_promo_box_wrapper',
            [
                'class' => [
                    'exad-promo-box-wrapper',
                    'exad-promo-align-type-'.esc_attr( $settings['exad_promo_box_content_type'] ),
                ],
            ]
        );

        if( 'horizontal' === $settings['exad_promo_box_content_type'] ){
            $this->add_render_attribute(
                'exad_promo_box_wrapper',
                [
                    'class' => [
                        'exad-promo-position-'.esc_attr( $settings['exad_promo_box_set_fixed_position'] )
                    ],
                    'data-position' => $settings['exad_promo_box_set_fixed_position']
                ]
            );
        } else {
            $this->add_render_attribute(
                'exad_promo_box_wrapper',
                [
                    'class' => [
                        'exad-promo-position-'.esc_attr( $settings['exad_promo_box_vertical_position'] ),
                        'exad-promo-allignment-'.$settings['exad_promo_box_vertical_container_alignment']
                    ],
                ]
            );
        }

        $this->add_render_attribute(
            'exad_promo_box_container',
            [
                'class' => [
                    'exad-promo-box-container',
                    'exad-promo-content-type-'.esc_attr( $settings['exad_promo_box_content_type'] )
                ],
                'id'    => 'exad-promo-box-id-'.$this->get_id()
            ]
        );

        if( 'yes' === $settings['exad_promo_box_enable_countdown'] ) :
            $this->add_render_attribute(
                'exad_promo_box_countdown_timer_container',
                [
                    'class'             => 'exad-countdown exad-countdown-title-visibility-'.esc_attr( $countdown_title_visibility ),
                    'data-day'          => esc_attr__( 'Days', 'exclusive-addons-elementor-pro' ),
                    'data-minutes'      => esc_attr__( 'Minutes', 'exclusive-addons-elementor-pro' ),
                    'data-hours'        => esc_attr__( 'Hours', 'exclusive-addons-elementor-pro' ),
                    'data-seconds'      => esc_attr__( 'Seconds', 'exclusive-addons-elementor-pro' ),
                    'data-countdown'    => esc_attr( $settings['exad_promo_box_countdown_time'] ),
                    'data-expired-text' => esc_attr( $settings['exad_promo_box_countdown_expired_text'] )
                ]
            );

            if ( 'yes' === $settings['exad_promo_box_countdown_divider_enable'] ) :
                $this->add_render_attribute( 'exad_promo_box_countdown_timer_container', 'class', 'exad-countdown-divider' );
            endif;
        endif;


        if( 'yes' === $settings['exad_promo_box_enable_mailchimp'] ) :
            $this->add_render_attribute(
                'exad_promo_box_mailchimp_container',
                [
                    'class'             => 'exad-mailchimp-container exad-mailchimp-type-'.esc_attr( $settings['exad_promo_box_content_type'] ).' exad-promo-box-item',
                    'data-mailchimp-id' => esc_attr( $this->get_id() ),
                    'data-api-key'      => esc_attr( $api_key ),
                    'data-list-id'      => esc_attr( $settings['exad_promo_box_mailchimp_items'] ),
                    'data-button-text'  => esc_attr( $settings['exad_promo_box_mailchimp_button_text'] ),
                    'data-success-text' => esc_attr( $settings['exad_promo_box_mailchimp_success_text'] ),
                    'data-error-text'   => esc_attr( $settings['exad_promo_box_mailchimp_error_text'] ),
                    'data-loading-text' => esc_attr( $settings['exad_promo_box_mailchimp_loading_text'] )
                ]
            );
        endif; ?>

        <div <?php echo $this->get_render_attribute_string( 'exad_promo_box_wrapper' ); ?>>
            <?php if( 'top' === $settings['exad_promo_box_set_fixed_position'] || 'bottom' === $settings['exad_promo_box_set_fixed_position'] ) :
                if( 'yes' === $settings['exad_promo_box_enable_content'] ) :   
                    if( ! empty( $settings['exad_promo_box_content_details'] ) || ! empty( $settings['exad_promo_box_content_heading'] ) ) : ?>
                        <div class="exad-promo-content-container exad-promo-box-item exad-promo-responsive-heading">
                            <?php 
                            $settings['exad_promo_box_content_heading'] ? printf( '<h3>%s</h3>', wp_kses_post( $settings['exad_promo_box_content_heading'] ) ) : '';
                            $settings['exad_promo_box_content_details'] ? printf( '<p>%s</p>', wp_kses_post( $settings['exad_promo_box_content_details'] ) ) : '';
                            ?>
                        </div>  
                    <?php endif;            
                endif; ?> 
                    <input type="checkbox" id="exad-promo-responsive-menu">
                    <?php if( ! empty( $settings['exad_promo_box_responsive_icon'] ) ) : ?>
                        <label for="exad-promo-responsive-menu" class="show-menu-btn exad-promo-responive-open-icon">
                            <?php Icons_Manager::render_icon( $settings['exad_promo_box_responsive_icon'], [ 'aria-hidden' => 'true' ] ); ?>
                        </label>
                    <?php endif;
            endif; ?>

            <div <?php echo $this->get_render_attribute_string( 'exad_promo_box_container' ); ?>>
                <?php if( 'yes' === $settings['exad_promo_box_enable_image'] && ! empty( $settings['exad_promo_box_image']['url'] ) ) : ?>
                    <div class="exad-promo-logo exad-promo-box-item">
                        <?php echo Group_Control_Image_Size::get_attachment_image_html( $settings, 'thumbnail', 'exad_promo_box_image' ); ?>
                    </div>
                <?php endif;

                if( 'yes' === $settings['exad_promo_box_enable_content'] ) :
                    if( ! empty( $settings['exad_promo_box_content_details'] ) || ! empty( $settings['exad_promo_box_content_heading'] ) ) : ?>
                        <div class="exad-promo-content-container exad-promo-box-item exad-promo-content-inside-wrapper exad-promo-inner-content">
                            <?php 
                            $settings['exad_promo_box_content_heading'] ? printf( '<h3>%s</h3>', wp_kses_post( $settings['exad_promo_box_content_heading'] ) ) : '';
                            $settings['exad_promo_box_content_details'] ? printf( '<p>%s</p>', wp_kses_post( $settings['exad_promo_box_content_details'] ) ) : '';
                            ?>
                        </div>
                    <?php endif;
                endif; ?>

                <?php if( 'yes' === $settings['exad_promo_box_enable_countdown'] ) : ?>
                    <div class="exad-countdown-content-container exad-promo-box-item">
                        <div <?php echo $this->get_render_attribute_string( 'exad_promo_box_countdown_timer_container' ); ?>></div>
                    </div>
                <?php endif;

                if( 'yes' === $settings['exad_promo_box_enable_mailchimp'] ) :
                    if( ! empty( $api_key ) ) : ?>
                            <div <?php echo $this->get_render_attribute_string( 'exad_promo_box_mailchimp_container' ); ?>>
                                <form id="exad-mailchimp-form-<?php echo esc_attr( $this->get_id() ); ?>" method="POST">
                                    <div class="exad-mailchimp-form-container">
                                        <div class="exad-mailchimp-item exad-mailchimp-email">
                                            <?php if( 'yes' === $settings['exad_promo_box_mailchimp_enable_label'] ) : ?>
                                                <label for="Email"><?php echo esc_html( apply_filters( 'exad_promobox_email_label', __( 'Email', 'exclusive-addons-elementor-pro' ) ) ); ?></label>
                                            <?php endif; ?>
                                            <input type="email" name="exad_mailchimp_email" class="exad-mailchimp-input-field" placeholder="<?php echo esc_attr( apply_filters( 'exad_promobox_email_placeholder', __( 'Email', 'exclusive-addons-elementor-pro' ) ) ); ?>" required="required">
                                        </div>

                                        <div class="exad-mailchimp-item exad-mailchimp-submit-btn">
                                            <button class="exad-mailchimp-subscribe-btn">
                                                <span><?php echo esc_html( $settings['exad_promo_box_mailchimp_button_text'] ); ?></span>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                    <?php else : ?>
                        <p class="exad-mailchimp-error-msg"><?php echo esc_html( 'Please insert your API key first.', 'exclusive-addons-elementor-pro' ); ?></p>
                    <?php endif;     
                endif;   

                if( 'yes' === $settings['exad_promo_box_enable_button'] && 'yes' !== $settings['exad_promo_box_enable_mailchimp'] && ! empty( $settings['exad_promo_box_button_text'] ) ) :
                    $this->add_render_attribute( 'exad_promo_box_button_link', 'class', 'exad-promo-button-link' );
                    if( $settings['exad_promo_box_button_link']['url'] ) {
                        $this->add_render_attribute( 'exad_promo_box_button_link', 'href', esc_url( $settings['exad_promo_box_button_link']['url'] ) );
                        if( $settings['exad_promo_box_button_link']['is_external'] ) {
                            $this->add_render_attribute( 'exad_promo_box_button_link', 'target', '_blank' );
                        }
                        if( $settings['exad_promo_box_button_link']['nofollow'] ) {
                            $this->add_render_attribute( 'exad_promo_box_button_link', 'rel', 'nofollow' );
                        }
                    } ?>
                    <div class="exad-promo-button exad-promo-box-item">
                        <a <?php echo $this->get_render_attribute_string( 'exad_promo_box_button_link' ); ?>>
                            <span><?php echo esc_html( $settings['exad_promo_box_button_text'] ); ?></span>
                        </a>
                    </div>
                <?php endif;   

                if( 'yes' === $settings['exad_promo_box_enable_close_button'] ) : ?>
                    <div class="exad-promo-box-dismiss-icon">
                        <svg viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M2.343 15.071L.929 13.656 6.586 8 .929 2.343 2.343.929 8 6.585 13.657.929l1.414 1.414L9.414 8l5.657 5.656-1.414 1.415L8 9.414l-5.657 5.657z" />
                        </svg>
                    </div>
                <?php endif;

                if( 'top' === $settings['exad_promo_box_set_fixed_position'] || 'bottom' === $settings['exad_promo_box_set_fixed_position'] ) : ?>
                    <label for="exad-promo-responsive-menu" class="hide-menu-btn exad-promo-responive-close-icon">
                        <i class="fas fa-times"></i>
                    </label>
                <?php endif; ?>
            </div>
        </div>
    <?php
    }
}