<?php
namespace ExclusiveAddons\Elements;

if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.

use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Border;
use \Elementor\Repeater;
use \Elementor\Group_Control_Box_Shadow;
use \Elementor\Group_Control_Image_Size;
use \Elementor\Group_Control_Background;
use \Elementor\Group_Control_Typography;
use \Elementor\Utils;
use \Elementor\Widget_Base;
use \ExclusiveAddons\Elementor\Image_Mask_SVG_Control;
use \ExclusiveAddons\Elementor\Helper;


class Team_Carousel extends Widget_Base {

    public function get_name() {
        return 'exad-team-carousel';
    }

    public function get_title() {
        return esc_html__( 'Team Carousel', 'exclusive-addons-elementor-pro' );
    }

    public function get_icon() {
        return 'exad exad-logo exad-team-carousel';
    }

    public function get_categories() {
        return [ 'exclusive-addons-elementor' ];
    }

    public function get_keywords() {
        return [ 'employee', 'staff' ];
    }

    public function get_script_depends() {
        return [ 'exad-slick', 'imagesloaded' ];
    }

    protected function register_controls() {
        $exad_primary_color   = get_option( 'exad_primary_color_option', '#7a56ff' );

        $this->start_controls_section(
            'exad_team_carousel_content',
            [
                'label' => esc_html__( 'Team Members', 'exclusive-addons-elementor-pro' )
            ]
        );

        $this->add_control(
            'exad_team_carousel_name_tag',
            [
                'label'   => __('Name HTML Tag', 'exclusive-addons-elementor-pro'),
                'type'    => Controls_Manager::SELECT,
                'options' => Helper::exad_title_tags(),
                'default' => 'h3',
            ]
		);

        $team_repeater = new Repeater();

        /*
        * Team Member Image
        */
        $team_repeater->add_control(
            'exad_team_carousel_image',
            [
                'label'   => __( 'Image', 'exclusive-addons-elementor-pro' ),
                'type'    => Controls_Manager::MEDIA,
                'default' => [
                    'url' => Utils::get_placeholder_image_src()
                ],
                'dynamic' => [
					'active' => true,
				]
            ]
        );

        $team_repeater->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
                'name'      => 'thumbnail',
                'default'   => 'full',
                'condition' => [
                    'exad_team_carousel_image[url]!' => ''
                ]
            ]
        );

        $team_repeater->add_control(
			'exad_team_carousel_enable_image_mask',
			[
				'label' => __( 'Enable Image Mask', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'exclusive-addons-elementor-pro' ),
				'label_off' => __( 'Hide', 'exclusive-addons-elementor-pro' ),
				'return_value' => 'yes',
				'default' => 'no',
			]
		);

		$team_repeater->add_control(
			'exad_team_carousel_mask_shape_mask_shape',
			[
				'label'                => __( 'Mask Shape', 'exclusive-addons-elementor-pro' ),
				'type'                 => Image_Mask_SVG_Control::SVGSELECTOR,
				'options'              => Helper::exad_masking_shape_list( 'list' ),
				'default'              => 'shape-1',
				'toggle'               => false,
				'label_block'          => true,
                'selectors_dictionary' => Helper::exad_masking_shape_list( 'url' ),
				'selectors'            => [
                    '{{WRAPPER}} {{CURRENT_ITEM}} .exad-team-member .exad-team-member-thumb img' => '-webkit-mask-image: url({{VALUE}}); mask-image: url({{VALUE}});'
				],
				'condition' 		   => [
					'exad_team_carousel_enable_image_mask' => 'yes'
				]
			]
		);
		
		$team_repeater->add_control(
			'exad_team_carousel_mask_shape_position',
			[
				'label'       => __( 'Position', 'exclusive-addons-elementor-pro' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => 'center',
				'label_block' => true,
				'options'     => [
					'top'     => __( 'Top', 'exclusive-addons-elementor-pro' ),
					'center'  => __( 'Center', 'exclusive-addons-elementor-pro' ),
					'left'    => __( 'Left', 'exclusive-addons-elementor-pro' ),
					'right'   => __( 'Right', 'exclusive-addons-elementor-pro' ),
					'bottom'  => __( 'Bottom', 'exclusive-addons-elementor-pro' ),
					'custom'  => __( 'Custom', 'exclusive-addons-elementor-pro' )
                ],
                'selectors'   => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .exad-team-member .exad-team-member-thumb img' => '-webkit-mask-position: {{VALUE}};'
				],
				'condition' 		   => [
					'exad_team_carousel_enable_image_mask' => 'yes'
				]
			]
		);
		
		$team_repeater->add_control(
			'exad_team_carousel_mask_shape_position_x_offset',
			[
				'label'       => __( 'X Offset', 'exclusive-addons-elementor-pro' ),
				'type'        => Controls_Manager::SLIDER,
				'size_units'  => [ 'px', '%' ],
				'range'       => [
					'px'      => [
						'min' => 0,
						'max' => 500
					],
					'%'       => [
						'min' => 0,
						'max' => 100
					]
				],
				'selectors'   => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .exad-team-member .exad-team-member-thumb img' => '-webkit-mask-position-y: {{SIZE}}{{UNIT}};'
                ],
                'condition'   => [
					'exad_team_carousel_enable_image_mask' => 'yes',
                    'exad_team_carousel_mask_shape_position' => 'custom'
				]
			]
		);

		$team_repeater->add_control(
			'exad_team_carousel_mask_shape_position_y_offset',
			[
				'label'       => __( 'Y Offset', 'exclusive-addons-elementor-pro' ),
				'type'        => Controls_Manager::SLIDER,
				'size_units'  => [ 'px', '%' ],
				'range'       => [
					'px'      => [
						'min' => 0,
						'max' => 500
					],
					'%'       => [
						'min' => 0,
						'max' => 100
					]
				],
				'selectors'   => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .exad-team-member .exad-team-member-thumb img' => '-webkit-mask-position-x: {{SIZE}}{{UNIT}};'
                ],
                'condition'   => [
					'exad_team_carousel_enable_image_mask' => 'yes',
                    'exad_team_carousel_mask_shape_position' => 'custom'
				]
			]
		);
        
        $team_repeater->add_control(
			'exad_team_carousel_mask_shape_size',
			[
				'label'       => __( 'Size', 'exclusive-addons-elementor-pro' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => 'auto',
				'label_block' => true,
				'options'     => [
					'auto'    => __( 'Auto', 'exclusive-addons-elementor-pro' ),
					'contain' => __( 'Contain', 'exclusive-addons-elementor-pro' ),
					'cover'   => __( 'Cover', 'exclusive-addons-elementor-pro' ),
					'custom'  => __( 'Custom', 'exclusive-addons-elementor-pro' )
                ],
                'selectors'   => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .exad-team-member .exad-team-member-thumb img' => '-webkit-mask-size: {{VALUE}};'
				],
				'condition' 		   => [
					'exad_team_carousel_enable_image_mask' => 'yes'
				]
			]
        );

        $team_repeater->add_control(
			'exad_team_carousel_mask_shape_custome_size',
			[
				'label'       => __( 'Mask Size', 'exclusive-addons-elementor-pro' ),
				'type'        => Controls_Manager::SLIDER,
				'size_units'  => [ 'px', '%' ],
				'range'       => [
					'px'      => [
						'min' => 0,
						'max' => 600
					],
					'%'       => [
						'min' => 0,
						'max' => 100
					]
				],
				'selectors'   => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .exad-team-member .exad-team-member-thumb img' => '-webkit-mask-size: {{SIZE}}{{UNIT}};'
                ],
                'condition'   => [
					'exad_team_carousel_enable_image_mask' => 'yes',
                    'exad_team_carousel_mask_shape_size' => 'custom'
				]
			]
		);

        $team_repeater->add_control(
			'exad_team_carousel_mask_shape_repeat',
			[
				'label'         => __( 'Repeat', 'exclusive-addons-elementor-pro' ),
				'type'          => Controls_Manager::SELECT,
				'default'       => 'no-repeat',
				'label_block'   => true,
				'options'       => [
					'no-repeat' => __( 'No repeat', 'exclusive-addons-elementor-pro' ),
					'repeat'    => __( 'Repeat', 'exclusive-addons-elementor-pro' )
                ],
                'selectors'     => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .exad-team-member .exad-team-member-thumb img' => '-webkit-mask-repeat: {{VALUE}};'
				],
				'condition' 	=> [
					'exad_team_carousel_enable_image_mask' => 'yes'
				]
			]
		);

        $team_repeater->add_control(
            'exad_team_carousel_name',
            [
                'label'       => esc_html__( 'Name', 'exclusive-addons-elementor-pro' ),
                'type'        => Controls_Manager::TEXT,
                'label_block' => true,
                'default'     => esc_html__( 'John Doe', 'exclusive-addons-elementor-pro' )
            ]
        );
        
        $team_repeater->add_control(
            'exad_team_carousel_designation',
            [
                'label'       => esc_html__( 'Designation', 'exclusive-addons-elementor-pro' ),
                'type'        => Controls_Manager::TEXT,
                'label_block' => true,
                'default'     => esc_html__( 'Designation', 'exclusive-addons-elementor-pro' )
            ]
        );
        
        $team_repeater->add_control(
            'exad_team_carousel_description',
            [
                'label'   => esc_html__( 'Description', 'exclusive-addons-elementor-pro' ),
                'type'    => Controls_Manager::TEXTAREA,
                'default' => esc_html__( 'Add team member details here. Lorem Ipsum is simply dummy text.', 'exclusive-addons-elementor-pro' )
            ]
        );

        $team_repeater->add_control(
            'exad_team_carousel_cta_btn',
            [
                'label'        => __( 'Call To Action', 'exclusive-addons-elementor-pro' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => __( 'ON', 'exclusive-addons-elementor-pro' ),
                'label_off'    => __( 'OFF', 'exclusive-addons-elementor-pro' ),
                'return_value' => 'yes',
                'default'      => 'no'
            ]
        );

        $team_repeater->add_control(
            'exad_team_carousel_cta_btn_text',
            [
                'label'       => esc_html__( 'Text', 'exclusive-addons-elementor-pro' ),
                'type'        => Controls_Manager::TEXT,
                'label_block' => true,
                'default'     => esc_html__( 'Read More', 'exclusive-addons-elementor-pro' ),
                'dynamic' => [
					'active' => true,
				],
                'condition'   => [
                    'exad_team_carousel_cta_btn' => 'yes'
                ]
            ]
        );

        $team_repeater->add_control(
            'exad_team_carousel_cta_btn_link',
            [
                'label'           => esc_html__( 'Link', 'exclusive-addons-elementor-pro' ),
                'type'            => Controls_Manager::URL,
                'label_block'     => true,
                'default'         => [
                    'url'         => '#',
                    'is_external' => ''
                ],
                'dynamic' => [
					'active' => true,
				],
                'show_external'   => true,
                'condition'       => [
                    'exad_team_carousel_cta_btn' => 'yes'
                ]
            ]
        );

        $team_repeater->add_control(
            'exad_team_carousel_enable_social_profiles',
            [
                'label'        => esc_html__( 'Display Social Profiles?', 'exclusive-addons-elementor-pro' ),
                'type'         => Controls_Manager::SWITCHER,
                'default'      => 'yes',
                'return_value' => 'yes',
                'separator'    => 'before'
            ]
        );

        $team_repeater->add_control(
            'exad_team_carousel_facebook_link',
            [
                'label'           => __( 'Facebook URL', 'exclusive-addons-elementor-pro' ),
                'type'            => Controls_Manager::URL,
                'placeholder'     => __( 'https://your-link.com', 'exclusive-addons-elementor-pro' ),
                'label_block'     => true,
                'default'         => [
                    'url'         => '#',
                    'is_external' => true
                ],
                'condition'       => [
                    'exad_team_carousel_enable_social_profiles!' => ''
                ]
            ]
        );

        $team_repeater->add_control(
            'exad_team_carousel_twitter_link',
            [
                'label'           => __( 'Twitter URL', 'exclusive-addons-elementor-pro' ),
                'type'            => Controls_Manager::URL,
                'placeholder'     => __( 'https://your-link.com', 'exclusive-addons-elementor-pro' ),
                'label_block'     => true,
                'default'         => [
                    'url'         => '#',
                    'is_external' => true
                ],
                'condition'       => [
                    'exad_team_carousel_enable_social_profiles!' => ''
                ]
            ]
        );

        $team_repeater->add_control(
            'exad_team_carousel_instagram_link',
            [
                'label'           => __( 'Instagram URL', 'exclusive-addons-elementor-pro' ),
                'type'            => Controls_Manager::URL,
                'placeholder'     => __( 'https://your-link.com', 'exclusive-addons-elementor-pro' ),
                'label_block'     => true,
                'default'         => [
                    'url'         => '#',
                    'is_external' => true
                ],
                'condition'       => [
                    'exad_team_carousel_enable_social_profiles!' => ''
                ]
            ]
        );

        $team_repeater->add_control(
            'exad_team_carousel_linkedin_link',
            [
                'label'           => __( 'Linkedin URL', 'exclusive-addons-elementor-pro' ),
                'type'            => Controls_Manager::URL,
                'placeholder'     => __( 'https://your-link.com', 'exclusive-addons-elementor-pro' ),
                'label_block'     => true,
                'default'         => [
                    'url'         => '#',
                    'is_external' => true
                ],
                'condition'       => [
                    'exad_team_carousel_enable_social_profiles!' => ''
                ]
            ]
        );

        $team_repeater->add_control(
            'exad_team_carousel_dribbble_link',
            [
                'label'           => __( 'Dribbble URL', 'exclusive-addons-elementor-pro' ),
                'type'            => Controls_Manager::URL,
                'placeholder'     => __( 'https://your-link.com', 'exclusive-addons-elementor-pro' ),
                'label_block'     => true,
                'default'         => [
                    'url'         => '',
                    'is_external' => true,
                ],
                'condition'       => [
                    'exad_team_carousel_enable_social_profiles!' => ''
                ]
            ]
        );

        $team_repeater->add_control(
			'exad_team_carousel_custom_style',
			[
				'label' => __( 'Custom Style?', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'exclusive-addons-elementor-pro' ),
				'label_off' => __( 'Hide', 'exclusive-addons-elementor-pro' ),
				'return_value' => 'yes',
				'default' => 'no',
			]
        );

        $team_repeater->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'exad_team_carousel_custom_background',
				'label' => __( 'Background', 'exclusive-addons-elementor-pro' ),
				'types' => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}} {{CURRENT_ITEM}} .exad-team-member',
                'condition'       => [
                    'exad_team_carousel_custom_style' => 'yes'
                ]
			]
        );
        
        $team_repeater->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'exad_team_carousel_custom_border',
				'label' => __( 'Border', 'exclusive-addons-elementor-pro' ),
				'types' => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}} {{CURRENT_ITEM}} .exad-team-member',
                'condition'       => [
                    'exad_team_carousel_custom_style' => 'yes'
                ]
			]
		);

        $this->add_control(
            'exad_team_carousel_repeater',
            [
                'type'        => Controls_Manager::REPEATER,
                'fields'      => $team_repeater->get_controls(),
                'title_field' => '{{{ exad_team_carousel_name }}}',
                'default'     => [
                    [ 'exad_team_carousel_name' => __( 'Paul Gillian', 'exclusive-addons-elementor-pro' ) ],
                    [ 'exad_team_carousel_name' => __( 'David Fontaine', 'exclusive-addons-elementor-pro' ) ],
                    [ 'exad_team_carousel_name' => __( 'Charles Jensen', 'exclusive-addons-elementor-pro' ) ],
                    [ 'exad_team_carousel_name' => __( 'Francis Miller', 'exclusive-addons-elementor-pro' ) ]
                ]
            ]
        );

        $this->end_controls_section();

        /**
         * carousel settings section
         */

        $this->start_controls_section(
            'exad_team_carousel_settings',
            [
                'label' => esc_html__( 'Carousel Settings', 'exclusive-addons-elementor-pro' )
            ]
        );

        $this->add_control(
            'exad_team_carousel_nav',
            [
                'label'      => esc_html__( 'Navigation Style', 'exclusive-addons-elementor-pro' ),
                'type'       => Controls_Manager::SELECT,
                'default'    => 'arrows',
                'options'    => [
                    'arrows' => esc_html__( 'Arrows', 'exclusive-addons-elementor-pro' ),
                    'dots'   => esc_html__( 'Dots', 'exclusive-addons-elementor-pro' ),
                    'both'   => esc_html__( 'Arrows and Dots', 'exclusive-addons-elementor-pro' ),
                    'none'   => esc_html__( 'None', 'exclusive-addons-elementor-pro' )
                ]
            ]
        );

        $slides_per_view = range( 1, 6 );
        $slides_per_view = array_combine( $slides_per_view, $slides_per_view );

        $this->add_responsive_control(
            'exad_team_carousel_per_view',
            [
                'type'    => Controls_Manager::SELECT,
                'label'   => esc_html__( 'Columns', 'exclusive-addons-elementor-pro' ),
                'options' => $slides_per_view,
                'default' => '3',
                'tablet_default' => '2',
				'mobile_default' => '1',
            ]
        );

        $this->add_control(
            'exad_team_carousel_slides_to_scroll',
            [
                'type'    => Controls_Manager::SELECT,
                'label'   => esc_html__( 'Items to Scroll', 'exclusive-addons-elementor-pro' ),
                'options' => $slides_per_view,
                'default' => '1'
            ]
        );

        $this->add_control(
            'exad_team_carousel_transition_duration',
            [
                'label'     => esc_html__( 'Transition Duration', 'exclusive-addons-elementor-pro' ),
                'type'      => Controls_Manager::NUMBER,
                'default'   => 1000
            ]
        );

        $this->add_control(
            'exad_team_carousel_autoplay',
            [
                'label'     => esc_html__( 'Autoplay', 'exclusive-addons-elementor-pro' ),
                'type'      => Controls_Manager::SWITCHER,
                'default'   => 'no'
            ]
        );

        $this->add_control(
            'exad_team_carousel_autoplay_speed',
            [
                'label'     => esc_html__( 'Autoplay Speed', 'exclusive-addons-elementor-pro' ),
                'type'      => Controls_Manager::NUMBER,
                'default'   => 5000,
                'condition' => [
                    'exad_team_carousel_autoplay' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'exad_team_carousel_loop',
            [
                'label'   => esc_html__( 'Infinite Loop', 'exclusive-addons-elementor-pro' ),
                'type'    => Controls_Manager::SWITCHER,
                'default' => 'yes'
            ]
        );

        $this->add_control(
            'exad_team_carousel_pause',
            [
                'label'     => esc_html__( 'Pause on Hover', 'exclusive-addons-elementor-pro' ),
                'type'      => Controls_Manager::SWITCHER,
                'default'   => 'yes',
                'condition' => [
                    'exad_team_carousel_autoplay' => 'yes'
                ]
            ]
        );

        $this->end_controls_section();

        /*
        * Team Members Styling Section
        */
        $this->start_controls_section(
            'exad_team_carousel_style',
            [
                'label' => esc_html__( 'Container', 'exclusive-addons-elementor-pro' ),
                'tab'   => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'     => 'exad_team_carousel_bg',
                'types'    => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}} .exad-team-member'
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'exad_team_carousel_border',
                'selector' => '{{WRAPPER}} .exad-team-member'
            ]
        );
        
        $this->add_responsive_control(
            'exad_team_carousel_radius',
            [
                'label'      => __( 'Border radius', 'exclusive-addons-elementor-pro' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'separator'  => 'after',
                'selectors'  => [
                    '{{WRAPPER}} .exad-team-member' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->add_responsive_control(
            'exad_team_carousel_padding',
            [
                'label'      => __( 'Padding', 'exclusive-addons-elementor-pro' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors'  => [
                    '{{WRAPPER}} .exad-team-member' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->add_responsive_control(
            'exad_team_carousel_margin',
            [
                'label'        => __( 'Margin', 'exclusive-addons-elementor-pro' ),
                'type'         => Controls_Manager::DIMENSIONS,
                'size_units'   => [ 'px', '%', 'em' ],
                'default'      => [
                    'top'      => '0',
                    'right'    => '10',
                    'bottom'   => '0',
                    'left'     => '10',
                    'isLinked' => false
                ],
                'selectors'    => [
                    '{{WRAPPER}} .exad-team-member' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'exad_team_carousel_box_shadow',
                'selector' => '{{WRAPPER}} .exad-team-member'
            ]
        );

        $this->end_controls_section();

        /**
         * For Image style
         */

        $this->start_controls_section(
            'exad_team_carousel_thumbnail_style',
            [
                'label' => esc_html__( 'Image', 'exclusive-addons-elementor-pro' ),
                'tab'   => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_control(
            'exad_team_carousel_content_image_position',
            [
                'label'         => esc_html__( 'Image Position', 'exclusive-addons-elementor-pro' ),
                'type'          => Controls_Manager::CHOOSE,
                'toggle'        => false,
                'default'       => 'exad-position-top',
                'options'       => [
                    'exad-position-left'  => [
                        'title' => esc_html__( 'Left', 'exclusive-addons-elementor-pro' ),
                        'icon'  => 'eicon-arrow-left'
                    ],
                    'exad-position-top'   => [
                        'title' => esc_html__( 'Top', 'exclusive-addons-elementor-pro' ),
                        'icon'  => 'eicon-arrow-up'
                    ],
                    'exad-position-right' => [
                        'title' => esc_html__( 'Right', 'exclusive-addons-elementor-pro' ),
                        'icon'  => 'eicon-arrow-right'
                    ]
                ]
            ]
        );

        $this->add_control(
            'exad_team_carousel_thumbnail_box',
            [
                'label'        => __( 'Image Box', 'exclusive-addons-elementor-pro' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => __( 'Show', 'exclusive-addons-elementor-pro' ),
                'label_off'    => __( 'Hide', 'exclusive-addons-elementor-pro' ),
                'return_value' => 'yes',
                'default'      => 'no'
            ]
        );

        $this->add_responsive_control(
            'exad_team_carousel_thumbnail_box_height',
            [
                'label'      => __( 'Height', 'exclusive-addons-elementor-pro' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%' ],
                'default'    => [
                    'unit'   => 'px',
                    'size'   => 100
                ],
                'range'        => [
                    'px'       => [
                        'min'  => 50,
                        'max'  => 500,
                        'step' => 5
                    ],
                    '%'        => [
                        'min'  => 1,
                        'max'  => 100,
                        'step' => 2
                    ]
                ],
                'selectors'  => [
                    '{{WRAPPER}} .exad-team-member-thumb'=> 'height: {{SIZE}}{{UNIT}};'
                ],
                'condition'  => [
                    'exad_team_carousel_thumbnail_box' => 'yes'
                ]
            ]
        );

        $this->add_responsive_control(
            'exad_team_carousel_thumbnail_box_width',
            [
                'label'      => __( 'Width', 'exclusive-addons-elementor-pro' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%' ],
                'default'    => [
                    'unit'   => 'px',
                    'size'   => 100
                ],
                'range'        => [
                    'px'       => [
                        'min'  => 50,
                        'max'  => 500,
                        'step' => 5
                    ],
                    '%'        => [
                        'min'  => 1,
                        'max'  => 100,
                        'step' => 2
                    ]
                ],
                'selectors'  => [
                    '{{WRAPPER}} .exad-team-member-thumb'=> 'width: {{SIZE}}{{UNIT}};'
                ],
                'condition'  => [
                    'exad_team_carousel_thumbnail_box' => 'yes'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'      => 'exad_team_carousel_thumbnail_box_border',
                'selector'  => '{{WRAPPER}} .exad-team-member-thumb',
                'condition' => [
                    'exad_team_carousel_thumbnail_box' => 'yes'
                ]
            ]
        );
        
        $this->add_responsive_control(
            'exad_team_carousel_thumbnail_box_radius',
            [
                'label'      => __( 'Border radius', 'exclusive-addons-elementor-pro' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'separator'  => 'after',
                'selectors'  => [
                    '{{WRAPPER}} .exad-team-member-thumb'     => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .exad-team-member-thumb img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->add_responsive_control(
            'exad_team_carousel_thumbnail_box_margin_top',
            [
                'label'      => __( 'Top Spacing', 'exclusive-addons-elementor-pro' ),
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
                        'step' => 5
                    ],
                    '%'        => [
                        'min'  => -50,
                        'max'  => 50,
                        'step' => 2
                    ]
                ],
                'selectors'  => [
                    '{{WRAPPER}} .exad-team-member-thumb' => 'margin-top: {{SIZE}}{{UNIT}};'
                ],
                'condition'  => [
                    'exad_team_carousel_thumbnail_box' => 'yes'
                ]
            ]
        );

        $this->add_responsive_control(
            'exad_team_carousel_thumbnail_box_margin_bottom',
            [
                'label'      => __( 'Bottom Spacing', 'exclusive-addons-elementor-pro' ),
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
                        'step' => 5
                    ],
                    '%'        => [
                        'min'  => -50,
                        'max'  => 50,
                        'step' => 2
                    ]
                ],
                'selectors'  => [
                    '{{WRAPPER}} .exad-team-member-thumb' => 'margin-bottom: {{SIZE}}{{UNIT}};'
                ],
                'condition'  => [
                    'exad_team_carousel_thumbnail_box' => 'yes'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'      => 'exad_team_carousel_thumbnail_box_shadow',
                'selector'  => '{{WRAPPER}} .exad-team-member-thumb',
                'condition' => [
                    'exad_team_carousel_thumbnail_box' => 'yes'
                ]
            ]
        );

        $this->end_controls_section();

        /*
        * Team Members Content Style
        */
        $this->start_controls_section(
            'exad_team_carousel_content_style',
            [
                'label' => esc_html__( 'Content', 'exclusive-addons-elementor-pro' ),
                'tab'   => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_control(
            'exad_team_carousel_content_alignment',
            [
                'label'   => __( 'Alignment', 'exclusive-addons-elementor-pro' ),
                'type'    => Controls_Manager::CHOOSE,
                'toggle'  => false,
                'default' => 'exad-team-carousel-center',
                'options' => [
                    'exad-team-carousel-left'       => [
                        'title' => __( 'Left', 'exclusive-addons-elementor-pro' ),
                        'icon'  => 'eicon-text-align-left'
                    ],
                    'exad-team-carousel-center'     => [
                        'title' => __( 'Center', 'exclusive-addons-elementor-pro' ),
                        'icon'  => 'eicon-text-align-center'
                    ],
                    'exad-team-carousel-right'  => [
                        'title' => __( 'Right', 'exclusive-addons-elementor-pro' ),
                        'icon'  => 'eicon-text-align-right'
                    ]
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'     => 'exad_team_carousel_content_background',
                'types'    => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}} .exad-team-member-content'
            ]
        );

        $this->add_responsive_control(
            'exad_team_carousel_content_padding',
            [
                'label'      => __( 'Padding', 'exclusive-addons-elementor-pro' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'default'    => [
                    'top'    => '30',
                    'right'  => '30',
                    'bottom' => '30',
                    'left'   => '30'
                ],
                'selectors'  => [
                    '{{WRAPPER}} .exad-team-member-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->add_responsive_control(
            'exad_team_carousel_content_margin',
            [
                'label'      => __( 'Margin', 'exclusive-addons-elementor-pro' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'default'    => [
                    'top'    => '0',
                    'right'  => '0',
                    'bottom' => '0',
                    'left'   => '0'
                ],
                'selectors'  => [
                    '{{WRAPPER}} .exad-team-member-content' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->add_responsive_control(
            'exad_team_carousel_content_radius',
            [
                'label'      => __( 'Border radius', 'exclusive-addons-elementor-pro' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors'  => [
                    '{{WRAPPER}} .exad-team-member-content' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'exad_team_carousel_content_box_shadow',
                'selector' => '{{WRAPPER}} .exad-team-member-content'
            ]
        );
        
        $this->end_controls_section();

        /**
         * Name style
         */

        $this->start_controls_section(
            'exad_team_carousel_name_style',
            [
                'label' => __('Name', 'exclusive-addons-elementor-pro'),
                'tab'   => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_control(
            'exad_team_carousel_name_color',
            [
                'label'     => __('Color', 'exclusive-addons-elementor-pro'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#000',
                'selectors' => [
                    '{{WRAPPER}} .exad-team-member-name' => 'color: {{VALUE}};'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'exad_team_carousel_name_typography',
                'selector' => '{{WRAPPER}} .exad-team-member-name'
            ]
        );
        
        $this->add_responsive_control(
            'exad_team_carousel_name_margin',
            [
                'label'        => __( 'Margin', 'exclusive-addons-elementor-pro' ),
                'type'         => Controls_Manager::DIMENSIONS,
                'size_units'   => [ 'px', '%', 'em' ],
                'default'      => [
                    'top'      => '0',
                    'right'    => '0',
                    'bottom'   => '20',
                    'left'     => '0',
                    'isLinked' => false
                ],
                'selectors'    => [
                    '{{WRAPPER}} .exad-team-member-name' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->end_controls_section();
        
        /**
         * Designation style
         */

        $this->start_controls_section(
            'exad_team_carousel_designation_style',
            [
                'label' => __('Designation', 'exclusive-addons-elementor-pro'),
                'tab'   => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_control(
            'exad_team_carousel_designation_color',
            [
                'label'     => __('Color', 'exclusive-addons-elementor-pro'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#8a8d91',
                'selectors' => [
                    '{{WRAPPER}} .exad-team-member-designation' => 'color: {{VALUE}};'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'exad_team_carousel_designation_typography',
                'selector' => '{{WRAPPER}} .exad-team-member-designation'
            ]
        );
        
        $this->add_responsive_control(
            'exad_team_carousel_designation_margin',
            [
                'label'        => __( 'Margin', 'exclusive-addons-elementor-pro' ),
                'type'         => Controls_Manager::DIMENSIONS,
                'size_units'   => [ 'px', '%', 'em' ],
                'default'      => [
                    'top'      => '0',
                    'right'    => '0',
                    'bottom'   => '20',
                    'left'     => '0',
                    'isLinked' => false
                ],
                'selectors'    => [
                    '{{WRAPPER}} .exad-team-member-designation' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ]
            ]
        );

        $this->end_controls_section();
        
        /**
         * Description style
         */

        $this->start_controls_section(
            'exad_team_carousel_description_style',
            [
                'label' => __('Description', 'exclusive-addons-elementor-pro'),
                'tab'   => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_control(
            'exad_team_carousel_description_color',
            [
                'label'     => __('Color', 'exclusive-addons-elementor-pro'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#8a8d91',
                'selectors' => [
                    '{{WRAPPER}} .exad-team-member-about' => 'color: {{VALUE}};'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'exad_team_carousel_description_typography',
                'selector' => '{{WRAPPER}} .exad-team-member-about'
            ]
        );
        
        $this->add_responsive_control(
            'exad_team_carousel_description_margin',
            [
                'label'        => __( 'Margin', 'exclusive-addons-elementor-pro' ),
                'type'         => Controls_Manager::DIMENSIONS,
                'size_units'   => [ 'px', '%', 'em' ],
                'default'      => [
                    'top'      => '0',
                    'right'    => '0',
                    'bottom'   => '20',
                    'left'     => '0',
                    'isLinked' => false
                ],
                'selectors'    => [
                    '{{WRAPPER}} .exad-team-member-about' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->end_controls_section();

        /**
         * Call to action Style
         */
        $this->start_controls_section(
            'exad_team_carousel_cta_btn_style',
            [
                'label' => __('Call To Action', 'exclusive-addons-elementor-pro'),
                'tab'   => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'exad_team_carousel_cta_btn_typography',
                'selector' => '{{WRAPPER}} .exad-team-member-cta'
            ]
        );
        
        $this->add_responsive_control(
            'exad_team_carousel_cta_btn_margin',
            [
                'label'        => __( 'Margin', 'exclusive-addons-elementor-pro' ),
                'type'         => Controls_Manager::DIMENSIONS,
                'size_units'   => [ 'px', '%', 'em' ],
                'default'      => [
                    'top'      => '0',
                    'right'    => '0',
                    'bottom'   => '20',
                    'left'     => '0',
                    'isLinked' => false
                ],
                'selectors'    => [
                    '{{WRAPPER}} .exad-team-member-cta' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->add_responsive_control(
            'exad_team_carousel_cta_btn_padding',
            [
                'label'        => __( 'Padding', 'exclusive-addons-elementor-pro' ),
                'type'         => Controls_Manager::DIMENSIONS,
                'size_units'   => [ 'px', '%', 'em' ],
                'default'      => [
                    'top'      => '15',
                    'right'    => '30',
                    'bottom'   => '15',
                    'left'     => '30',
                    'isLinked' => false
                ],
                'selectors'    => [
                    '{{WRAPPER}} .exad-team-member-cta' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->add_responsive_control(
            'exad_team_carousel_cta_btn_radius',
            [
                'label'      => __( 'Border Radius', 'exclusive-addons-elementor-pro' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'default'    => [
                    'top'    => '0',
                    'right'  => '0',
                    'bottom' => '0',
                    'left'   => '0'
                ],
                'selectors'  => [
                    '{{WRAPPER}} .exad-team-member-cta' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->start_controls_tabs( 'exad_team_member_cta_btn_tabs' );

            $this->start_controls_tab( 'exad_team_member_cta_btn_tab_normal', [ 'label' => esc_html__( 'Normal', 'exclusive-addons-elementor-pro' ) ] );

                $this->add_control(
                    'exad_team_carousel_cta_btn_text_color_normal',
                    [
                        'label'     => esc_html__( 'Text Color', 'exclusive-addons-elementor-pro' ),
                        'type'      => Controls_Manager::COLOR,
                        'default'   => '#222222',
                        'selectors' => [
                            '{{WRAPPER}} .exad-team-member-cta' => 'color: {{VALUE}};'
                        ]
                    ]
                );

                $this->add_control(
                    'exad_team_carousel_cta_btn_background_normal',
                    [
                        'label'     => esc_html__( 'Background Color', 'exclusive-addons-elementor-pro' ),
                        'type'      => Controls_Manager::COLOR,
                        'default'   => '#d6d6d6',
                        'selectors' => [
                            '{{WRAPPER}} .exad-team-member-cta' => 'background-color: {{VALUE}};'
                        ]
                    ]
                );

                $this->add_group_control(
                    Group_Control_Border::get_type(),
                    [
                        'name'     => 'exad_team_carousel_cta_btn_border_normal',
                        'selector' => '{{WRAPPER}} .exad-team-member-cta'
                    ]
                );
        
            $this->end_controls_tab();

            $this->start_controls_tab( 'exad_team_member_cta_btn_tab_hover', [ 'label' => esc_html__( 'Hover', 'exclusive-addons-elementor-pro' ) ] );

                $this->add_control(
                    'exad_team_carousel_cta_btn_text_color_hover',
                    [
                        'label'     => esc_html__( 'Text Color', 'exclusive-addons-elementor-pro' ),
                        'type'      => Controls_Manager::COLOR,
                        'default'   => '#d6d6d6',
                        'selectors' => [
                            '{{WRAPPER}} .exad-team-member-cta:hover' => 'color: {{VALUE}};'
                        ]
                    ]
                );

                $this->add_control(
                    'exad_team_carousel_cta_btn_background_hover',
                    [
                        'label'     => esc_html__( 'Background Color', 'exclusive-addons-elementor-pro' ),
                        'type'      => Controls_Manager::COLOR,
                        'default'   => '#222222',
                        'selectors' => [
                            '{{WRAPPER}} .exad-team-member-cta:hover' => 'background-color: {{VALUE}};'
                        ]
                    ]
                );

                $this->add_group_control(
                    Group_Control_Border::get_type(),
                    [
                        'name'     => 'exad_team_carousel_cta_btn_border_hover',
                        'selector' => '{{WRAPPER}} .exad-team-member-cta:hover'
                    ]
                );

            $this->end_controls_tab();
        
        $this->end_controls_tabs();

        $this->end_controls_section();

        /**
         * Social icons style
         */

        $this->start_controls_section(
            'exad_team_carousel_social_section',
            [
                'label' => __('Social Icons', 'exclusive-addons-elementor-pro'),
                'tab'   => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_responsive_control(
            'exad_team_carousel_social_icon_size',
            [
                'label'        => __( 'Icon Size', 'exclusive-addons-elementor-pro' ),
                'type'         => Controls_Manager::SLIDER,
                'size_units'   => [ 'px' ],
                'range'        => [
                    'px'       => [
                        'min'  => 0,
                        'max'  => 50,
                        'step' => 1
                    ]
                ],
                'default'      => [
                    'unit'     => 'px',
                    'size'     => 14
                ],
                'selectors'    => [
                    '{{WRAPPER}} .exad-team-member-social li a i' => 'font-size: {{SIZE}}{{UNIT}};'
                ]
            ]
        );

        $this->add_responsive_control(
            'exad_team_carousel_social_item_spacing',
            [
                'label'        => __( 'Spacing Between item', 'exclusive-addons-elementor-pro' ),
                'type'         => Controls_Manager::SLIDER,
                'size_units'   => [ 'px' ],
                'range'        => [
                    'px'       => [
                        'min'  => 0,
                        'max'  => 50,
                        'step' => 1
                    ]
                ],
                'default'      => [
                    'unit'     => 'px',
                    'size'     => 5
                ],
                'selectors'    => [
                    '{{WRAPPER}} .exad-team-member-social li:not(:last-child)' => 'margin-right: {{SIZE}}{{UNIT}};'
                ]
            ]
        );

        $this->add_responsive_control(
            'exad_team_carousel_social_box_radius',
            [
                'label'      => __( 'Border radius', 'exclusive-addons-elementor-pro' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors'  => [
                    '{{WRAPPER}} .exad-team-member-social li a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->add_responsive_control(
            'exad_team_carousel_social_padding',
            [
                'label'      => __( 'Padding', 'exclusive-addons-elementor-pro' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'separator'  => 'after',
                'default'    => [
                    'top'    => '15',
                    'right'  => '15',
                    'bottom' => '15',
                    'left'   => '15'
                ],
                'selectors'  => [
                    '{{WRAPPER}} .exad-team-member-social li a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->start_controls_tabs( 'exad_team_carousel_social_icons_style_tabs' );

            $this->start_controls_tab( 'exad_team_carousel_social_icon_tab', [ 'label' => esc_html__( 'Normal', 'exclusive-addons-elementor-pro' ) ] );

                $this->add_control(
                    'exad_team_carousel_social_bg_color_normal',
                    [
                        'label'     => esc_html__( 'Background Color', 'exclusive-addons-elementor-pro' ),
                        'type'      => Controls_Manager::COLOR,
                        'default'   => '#ffffff',
                        'selectors' => [
                            '{{WRAPPER}} .exad-team-member-social li a' => 'background-color: {{VALUE}};'
                        ]
                    ]
                );

                $this->add_control(
                    'exad_team_carousel_social_icon_color_normal',
                    [
                        'label'     => esc_html__( 'Icon Color', 'exclusive-addons-elementor-pro' ),
                        'type'      => Controls_Manager::COLOR,
                        'default'   => '#a4a7aa',
                        'selectors' => [
                            '{{WRAPPER}} .exad-team-member-social li a i' => 'color: {{VALUE}};'
                        ]
                    ]
                );

                $this->add_group_control(
                    Group_Control_Border::get_type(),
                    [
                        'name'     => 'exad_team_carousel_social_border_normal',
                        'selector' => '{{WRAPPER}} .exad-team-member-social li a'
                    ]
                );

                $this->add_group_control(
                    Group_Control_Box_Shadow::get_type(),
                    [
                        'name'     => 'exad_team_carousel_social_shadow_normal',
                        'label'    => __( 'Box Shadow', 'exclusive-addons-elementor-pro' ),
                        'selector' => '{{WRAPPER}} .exad-team-member-social li a',
                    ]
                );
        
            $this->end_controls_tab();

            $this->start_controls_tab( 'exad_team_carousel_social_icon_hover', [ 'label' => esc_html__( 'Hover', 'exclusive-addons-elementor-pro' ) ] );

                $this->add_control(
                    'exad_team_carousel_social_bg_color_hover',
                    [
                        'label'     => esc_html__( 'Background Color', 'exclusive-addons-elementor-pro' ),
                        'type'      => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .exad-team-member-social li a:hover' => 'background-color: {{VALUE}};'
                        ],
                    ]
                );

                $this->add_control(
                    'exad_team_carousel_social_icon_color_hover',
                    [
                        'label'     => esc_html__( 'Icon Color', 'exclusive-addons-elementor-pro' ),
                        'type'      => Controls_Manager::COLOR,
                        'default'   => '#8a8d91',
                        'selectors' => [
                            '{{WRAPPER}} .exad-team-member-social li a:hover i' => 'color: {{VALUE}};'
                        ]
                    ]
                );

                $this->add_group_control(
                    Group_Control_Border::get_type(),
                    [
                        'name'     => 'exad_team_carousel_social_border_hover',
                        'selector' => '{{WRAPPER}} .exad-team-member-social li a:hover'
                    ]
                );

                $this->add_group_control(
                    Group_Control_Box_Shadow::get_type(),
                    [
                        'name'     => 'exad_team_carousel_social_shadow_hover',
                        'label'    => __( 'Box Shadow', 'exclusive-addons-elementor-pro' ),
                        'selector' => '{{WRAPPER}} .exad-team-member-social li a:hover',
                    ]
                );

            $this->end_controls_tab();
        
        $this->end_controls_tabs();

        $this->end_controls_section();

        $this->start_controls_section(
            'exad_team_carousel_nav_arrow',
            [
                'label'     => esc_html__( 'Arrows', 'exclusive-addons-elementor-pro' ),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'exad_team_carousel_nav' => ['arrows', 'both'],
                ],
            ]
        );

        $this->add_responsive_control(
            'exad_team_carousel_nav_arrow_box_size',
            [
                'label'      => __( 'Box Size', 'exclusive-addons-elementor-pro' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range'      => [
                    'px' => [
                        'min' => 0,
                        'max' => 200,
                    ],
                ],
                'default'    => [
                    'unit' => 'px',
                    'size' => 50,
                ],
                'selectors'  => [
                    '{{WRAPPER}} .exad-team-carousel-wrapper .exad-carousel-nav-prev' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .exad-team-carousel-wrapper .exad-carousel-nav-next' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'exad_team_carousel_nav_arrow_icon_size',
            [
                'label'      => __( 'Icon Size', 'exclusive-addons-elementor-pro' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range'      => [
                    'px' => [
                        'min' => 0,
                        'max' => 50,
                    ],
                ],
                'default'    => [
                    'unit' => 'px',
                    'size' => 16,
                ],
                'selectors'  => [
                    '{{WRAPPER}} .exad-team-carousel-wrapper .exad-carousel-nav-prev i' => 'font-size: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .exad-team-carousel-wrapper .exad-carousel-nav-next i' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        
        $this->add_control(
            'exad_team_carousel_prev_arrow_position',
            [
                'label'        => __( 'Previous Arrow Position', 'exclusive-addons-elementor-pro' ),
                'type'         => Controls_Manager::POPOVER_TOGGLE,
                'label_off'    => __( 'Default', 'exclusive-addons-elementor-pro' ),
                'label_on'     => __( 'Custom', 'exclusive-addons-elementor-pro' ),
                'return_value' => 'yes',
                'default'      => 'yes',
            ]
        );
        
        $this->start_popover();

            $this->add_responsive_control(
                'exad_team_carousel_prev_arrow_position_x_offset',
                [
                    'label'      => __( 'X Offset', 'exclusive-addons-elementor-pro' ),
                    'type'       => Controls_Manager::SLIDER,
                    'size_units' => ['px', '%'],
                    'range'      => [
                        'px' => [
                            'min' => -4000,
                            'max' => 4000,
                        ],
                        '%'  => [
                            'min' => -100,
                            'max' => 100,
                        ],
                    ],
                    'default'    => [
                        'unit' => 'px',
                        'size' => 30,
                    ],
                    'selectors'  => [
                        '{{WRAPPER}} .exad-team-carousel-wrapper .exad-carousel-nav-prev' => 'left: {{SIZE}}{{UNIT}};',
                    ],
                ]
            );

            $this->add_responsive_control(
                'exad_team_carousel_prev_arrow_position_y_offset',
                [
                    'label'      => __( 'Y Offset', 'exclusive-addons-elementor-pro' ),
                    'type'       => Controls_Manager::SLIDER,
                    'size_units' => ['px', '%'],
                    'range'      => [
                        'px' => [
                            'min' => -4000,
                            'max' => 4000,
                        ],
                        '%'  => [
                            'min' => -100,
                            'max' => 100,
                        ],
                    ],
                    'default'    => [
                        'unit' => '%',
                        'size' => 50,
                    ],
                    'selectors'  => [
                        '{{WRAPPER}} .exad-team-carousel-wrapper .exad-carousel-nav-prev' => 'top: {{SIZE}}{{UNIT}};',
                    ],
                ]
            );

        $this->end_popover();

        $this->add_control(
            'exad_team_carousel_next_arrow_position',
            [
                'label'        => __( 'Next Arrow Position', 'exclusive-addons-elementor-pro' ),
                'type'         => Controls_Manager::POPOVER_TOGGLE,
                'label_off'    => __( 'Default', 'exclusive-addons-elementor-pro' ),
                'label_on'     => __( 'Custom', 'exclusive-addons-elementor-pro' ),
                'return_value' => 'yes',
                'default'      => 'yes',
            ]
        );
        
        $this->start_popover();

            $this->add_responsive_control(
                'exad_team_carousel_next_arrow_position_x_offset',
                [
                    'label'      => __( 'X Offset', 'exclusive-addons-elementor-pro' ),
                    'type'       => Controls_Manager::SLIDER,
                    'size_units' => ['px', '%'],
                    'range'      => [
                        'px' => [
                            'min' => -4000,
                            'max' => 4000,
                        ],
                        '%'  => [
                            'min' => -100,
                            'max' => 100,
                        ],
                    ],
                    'default'    => [
                        'unit' => 'px',
                        'size' => 30,
                    ],
                    'selectors'  => [
                        '{{WRAPPER}} .exad-team-carousel-wrapper .exad-carousel-nav-next' => 'right: {{SIZE}}{{UNIT}};',
                    ],
                ]
            );

            $this->add_responsive_control(
                'exad_team_carousel_next_arrow_position_y_offset',
                [
                    'label'      => __( 'Y Offset', 'exclusive-addons-elementor-pro' ),
                    'type'       => Controls_Manager::SLIDER,
                    'size_units' => ['px', '%'],
                    'range'      => [
                        'px' => [
                            'min' => -4000,
                            'max' => 4000,
                        ],
                        '%'  => [
                            'min' => -100,
                            'max' => 100,
                        ],
                    ],
                    'default'    => [
                        'unit' => '%',
                        'size' => 50,
                    ],
                    'selectors'  => [
                        '{{WRAPPER}} .exad-team-carousel-wrapper .exad-carousel-nav-next' => 'top: {{SIZE}}{{UNIT}};',
                    ],
                ]
            );

        $this->end_popover();

        $this->add_responsive_control(
            'exad_team_carousel_nav_arrow_radius',
            [
                'label'      => __( 'Border radius', 'exclusive-addons-elementor-pro' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'default'    => [
                    'top'      => '0',
                    'right'    => '0',
                    'bottom'   => '0',
                    'left'     => '0',
                    'unit'     => 'px',
                    'isLinked' => true,
                ],
                'selectors'  => [
                    '{{WRAPPER}} .exad-team-carousel-wrapper .exad-carousel-nav-prev' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .exad-team-carousel-wrapper .exad-carousel-nav-next' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs( 'exad_team_carousel_nav_arrow_tabs' );

			// normal state rating
			$this->start_controls_tab( 'exad_team_carousel_nav_arrow_normal', [ 'label' => esc_html__( 'Normal', 'exclusive-addons-elementor-pro' ) ] );

                $this->add_control(
                    'exad_team_carousel_arrow_normal_background',
                    [
                        'label'     => __( 'Background Color', 'exclusive-addons-elementor-pro' ),
                        'type'      => Controls_Manager::COLOR,
                        'default'   => '#ffffff',
                        'selectors' => [
                            '{{WRAPPER}} .exad-team-carousel-wrapper .exad-carousel-nav-prev' => 'background: {{VALUE}}',
                            '{{WRAPPER}} .exad-team-carousel-wrapper .exad-carousel-nav-next' => 'background: {{VALUE}}',
                        ],
                    ]
                );

                $this->add_control(
                    'exad_team_carousel_arrow_normal_color',
                    [
                        'label'     => __( 'Icon Color', 'exclusive-addons-elementor-pro' ),
                        'type'      => Controls_Manager::COLOR,
                        'default'   => $exad_primary_color,
                        'selectors' => [
                            '{{WRAPPER}} .exad-team-carousel-wrapper .exad-carousel-nav-prev i' => 'color: {{VALUE}};',
                            '{{WRAPPER}} .exad-team-carousel-wrapper .exad-carousel-nav-next i' => 'color: {{VALUE}};',
                        ],
                    ]
                );

                $this->add_group_control(
                    Group_Control_Border::get_type(),
                    [
                        'name'     => 'exad_team_carousel_arrow_normal_border',
                        'label'    => __( 'Border', 'exclusive-addons-elementor-pro' ),
                        'selector' => '{{WRAPPER}} .exad-team-carousel-wrapper .exad-carousel-nav-prev, {{WRAPPER}} .exad-team-carousel-wrapper .exad-carousel-nav-next',
                    ]
                );

                $this->add_group_control(
                    Group_Control_Box_Shadow::get_type(),
                    [
                        'name'     => 'exad_team_carousel_arrow_normal_shadow',
                        'label'    => __( 'Box Shadow', 'exclusive-addons-elementor-pro' ),
                        'selector' => '{{WRAPPER}} .exad-team-carousel-wrapper .exad-carousel-nav-prev, {{WRAPPER}} .exad-team-carousel-wrapper .exad-carousel-nav-next',
                    ]
                );

			$this->end_controls_tab();

			// hover state rating
			$this->start_controls_tab( 'exad_team_carousel_nav_arrow_hover', [ 'label' => esc_html__( 'Hover', 'exclusive-addons-elementor-pro' ) ] );

                $this->add_control(
                    'exad_team_carousel_arrow_hover_background',
                    [
                        'label'     => __( 'Background Color', 'exclusive-addons-elementor-pro' ),
                        'type'      => Controls_Manager::COLOR,
                        'default'   => $exad_primary_color,
                        'selectors' => [
                            '{{WRAPPER}} .exad-team-carousel-wrapper .exad-carousel-nav-prev:hover' => 'background: {{VALUE}}',
                            '{{WRAPPER}} .exad-team-carousel-wrapper .exad-carousel-nav-next:hover' => 'background: {{VALUE}}',
                        ],
                    ]
                );

                $this->add_control(
                    'exad_team_carousel_arrow_hover_color',
                    [
                        'label'     => __( 'Icon Color', 'exclusive-addons-elementor-pro' ),
                        'type'      => Controls_Manager::COLOR,
                        'default'   => '#ffffff',
                        'selectors' => [
                            '{{WRAPPER}} .exad-team-carousel-wrapper .exad-carousel-nav-prev:hover i' => 'color: {{VALUE}}',
                            '{{WRAPPER}} .exad-team-carousel-wrapper .exad-carousel-nav-next:hover i' => 'color: {{VALUE}}',
                        ],
                    ]
                );

                $this->add_group_control(
                    Group_Control_Border::get_type(),
                    [
                        'name'     => 'exad_team_carousel_arrow_hover_border',
                        'label'    => __( 'Border', 'exclusive-addons-elementor-pro' ),
                        'selector' => '{{WRAPPER}} .exad-team-carousel-wrapper .exad-carousel-nav-prev:hover, {{WRAPPER}} .exad-team-carousel-wrapper .exad-carousel-nav-next:hover',
                    ]
                );

                $this->add_group_control(
                    Group_Control_Box_Shadow::get_type(),
                    [
                        'name'     => 'exad_team_carousel_arrow_hover_shadow',
                        'label'    => __( 'Box Shadow', 'exclusive-addons-elementor-pro' ),
                        'selector' => '{{WRAPPER}} .exad-team-carousel-wrapper .exad-carousel-nav-prev:hover, {{WRAPPER}} .exad-team-carousel-wrapper .exad-carousel-nav-next:hover',
                    ]
                );

			$this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();

        $this->start_controls_section(
            'exad_team_carousel_nav_dot',
            [
                'label'     => esc_html__( 'Dots', 'exclusive-addons-elementor-pro' ),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'exad_team_carousel_nav' => ['dots', 'both'],
                ],
            ]
        );

        $this->add_control(
            'exad_team_carousel_nav_dot_alignment',
            [
                'label'   => __( 'Alignment', 'exclusive-addons-elementor-pro' ),
                'type'    => Controls_Manager::CHOOSE,
                'options' => [
                    'exad-team-carousel-dots-left'   => [
                        'title' => __( 'Left', 'exclusive-addons-elementor-pro' ),
                        'icon'  => 'fa fa-align-left',
                    ],
                    'exad-team-carousel-dots-center' => [
                        'title' => __( 'Center', 'exclusive-addons-elementor-pro' ),
                        'icon'  => 'fa fa-align-center',
                    ],
                    'exad-team-carousel-dots-right'  => [
                        'title' => __( 'Right', 'exclusive-addons-elementor-pro' ),
                        'icon'  => 'fa fa-align-right',
                    ],
                ],
                'default' => 'exad-team-carousel-dots-center',
            ]
        );

        $this->add_responsive_control(
            'exad_team_carousel_dots_top_spacing',
            [
                'label'      => __( 'Top Spacing', 'exclusive-addons-elementor-pro' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range'      => [
                    'px' => [
                        'min' => -1000,
                        'max' => 1000,
                    ],
                ],
                'default'    => [
                    'unit' => 'px',
                    'size' => 0,
                ],
                'selectors'  => [
                    '{{WRAPPER}} .exad-team-carousel-wrapper .slick-dots' => 'margin-top: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'exad_team_carousel_nav_dot_radius',
            [
                'label'      => __( 'Border Radius', 'exclusive-addons-elementor-pro' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'default'    => [
                    'top'      => '0',
                    'right'    => '0',
                    'bottom'   => '0',
                    'left'     => '0',
                    'unit'     => 'px',
                    'isLinked' => true,
                ],
                'selectors'  => [
                    '{{WRAPPER}} .exad-team-carousel-wrapper .slick-dots li button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs( 'exad_team_carousel_nav_dots_tabs' );

			// normal state rating
            $this->start_controls_tab( 'exad_team_carousel_nav_dots_normal', [ 'label' => esc_html__( 'Normal', 'exclusive-addons-elementor-pro' ) ] );
            
                $this->add_responsive_control(
                    'exad_team_carousel_dots_normal_width',
                    [
                        'label'      => __( 'Width', 'exclusive-addons-elementor-pro' ),
                        'type'       => Controls_Manager::SLIDER,
                        'size_units' => ['px'],
                        'range'      => [
                            'px' => [
                                'min' => 0,
                                'max' => 100,
                            ],
                        ],
                        'default'    => [
                            'unit' => 'px',
                            'size' => 10,
                        ],
                        'selectors'  => [
                            '{{WRAPPER}} .exad-team-carousel-wrapper .slick-dots li button' => 'width: {{SIZE}}{{UNIT}};',
                        ],
                    ]
                );

                $this->add_responsive_control(
                    'exad_team_carousel_dots_normal_height',
                    [
                        'label'      => __( 'Height', 'exclusive-addons-elementor-pro' ),
                        'type'       => Controls_Manager::SLIDER,
                        'size_units' => ['px'],
                        'range'      => [
                            'px' => [
                                'min' => 0,
                                'max' => 100,
                            ],
                        ],
                        'default'    => [
                            'unit' => 'px',
                            'size' => 10,
                        ],
                        'selectors'  => [
                            '{{WRAPPER}} .exad-team-carousel-wrapper .slick-dots li button' => 'height: {{SIZE}}{{UNIT}};',
                        ],
                    ]
                );

                $this->add_control(
                    'exad_team_carousel_dots_normal_background',
                    [
                        'label'     => __( 'Background Color', 'exclusive-addons-elementor-pro' ),
                        'type'      => Controls_Manager::COLOR,
                        'default'   => '#e5e5e5',
                        'selectors' => [
                            '{{WRAPPER}} .exad-team-carousel-wrapper .slick-dots li button' => 'background: {{VALUE}};',
                        ],
                    ]
                );

                $this->add_group_control(
                    Group_Control_Border::get_type(),
                    [
                        'name'     => 'exad_team_carousel_dots_normal_border',
                        'label'    => __( 'Border', 'exclusive-addons-elementor-pro' ),
                        'selector' => '{{WRAPPER}} .exad-team-carousel-wrapper .slick-dots li button',
                    ]
                );

			$this->end_controls_tab();

			// hover state rating
            $this->start_controls_tab( 'exad_team_carousel_nav_dots_hover', [ 'label' => esc_html__( 'Hover/active', 'exclusive-addons-elementor-pro' ) ] );
            
                $this->add_responsive_control(
                    'exad_team_carousel_dots_active_width',
                    [
                        'label'      => __( 'Width', 'exclusive-addons-elementor-pro' ),
                        'type'       => Controls_Manager::SLIDER,
                        'size_units' => ['px', '%'],
                        'range'      => [
                            'px' => [
                                'min' => 0,
                                'max' => 100,
                            ],
                        ],
                        'default'    => [
                            'unit' => 'px',
                            'size' => 10,
                        ],
                        'selectors'  => [
                            '{{WRAPPER}} .exad-team-carousel-wrapper .slick-dots li.slick-active button' => 'width: {{SIZE}}{{UNIT}};',
                        ],
                    ]
                );

                $this->add_responsive_control(
                    'exad_team_carousel_dots_active_height',
                    [
                        'label'      => __( 'Height', 'exclusive-addons-elementor-pro' ),
                        'type'       => Controls_Manager::SLIDER,
                        'size_units' => ['px', '%'],
                        'range'      => [
                            'px' => [
                                'min' => 0,
                                'max' => 100,
                            ],
                        ],
                        'default'    => [
                            'unit' => 'px',
                            'size' => 10,
                        ],
                        'selectors'  => [
                            '{{WRAPPER}} .exad-team-carousel-wrapper .slick-dots li.slick-active button' => 'height: {{SIZE}}{{UNIT}};',
                        ],
                    ]
                );

                $this->add_control(
                    'exad_team_carousel_dots_active_background',
                    [
                        'label'     => __( 'Background Color', 'exclusive-addons-elementor-pro' ),
                        'type'      => Controls_Manager::COLOR,
                        'default'   => $exad_primary_color,
                        'selectors' => [
                            '{{WRAPPER}} .exad-team-carousel-wrapper .slick-dots li.slick-active button' => 'background: {{VALUE}};',
                            '{{WRAPPER}} .exad-team-carousel-wrapper .slick-dots li button:hover'        => 'background: {{VALUE}};',
                        ],
                    ]
                );

                $this->add_group_control(
                    Group_Control_Border::get_type(),
                    [
                        'name'     => 'exad_team_carousel_dots_active_border',
                        'label'    => __( 'Border', 'exclusive-addons-elementor-pro' ),
                        'selector' => '{{WRAPPER}} .exad-team-carousel-wrapper .slick-dots li.slick-active button, {{WRAPPER}} .exad-team-carousel-wrapper .slick-dots li button:hover',
                    ]
                );

			$this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();

        $this->start_controls_section(
			'exad_section_team_carousel_animating_mask',
			[
				'label' 	=> esc_html__( 'Animating Mask', 'exclusive-addons-elementor-pro' ),
				'tab'   	=> Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'exad_team_carousel_animating_mask_switcher',
			[
				'label' 		=> __( 'Enable Animating Mask', 'exclusive-addons-elementor-pro' ),
				'type' 			=> Controls_Manager::SWITCHER,
				'label_on' 		=> __( 'ON', 'exclusive-addons-elementor-pro' ),
				'label_off' 	=> __( 'OFF', 'exclusive-addons-elementor-pro' ),
				'return_value' 	=> 'yes',
				'default' 		=> 'no',
			]
		);

		$this->add_control(
			'exad_team_carousel_animating_mask_style',
			[
				'label'        => __( 'Animating Mask Style', 'exclusive-addons-elementor-pro' ),
				'type'         => Controls_Manager::SELECT,
				'default'      => 'style_1',
				'options'      => [
					'style_1'  => __( 'Style 1', 'exclusive-addons-elementor-pro' ),
					'style_2'  => __( 'Style 2', 'exclusive-addons-elementor-pro' ),
					'style_3'  => __( 'Style 3', 'exclusive-addons-elementor-pro' ),
				],
				'condition'		=> [
					'exad_team_carousel_animating_mask_switcher' => 'yes'
				]
			]
		);

		$this->end_controls_section();

    }

    protected function render() {
        $settings  = $this->get_settings_for_display();
        $direction = is_rtl() ? 'true' : 'false';

        $this->add_render_attribute( 
            'exad-team-carousel', 
            [ 
                'class'                  => [ 'exad-team-carousel-wrapper exad-team-item exad-carousel-item', esc_attr( $settings['exad_team_carousel_nav_dot_alignment'] ) ],
                'data-slidestoshow'      => intval( esc_attr( $settings['exad_team_carousel_per_view'] ) ),
                'data-slidestoshow-tablet'   => intval( esc_attr( isset( $settings['exad_team_carousel_per_view_tablet'] ) ) ? (int)$settings['exad_team_carousel_per_view_tablet'] : 2  ),
				'data-slidestoshow-mobile'   => intval( esc_attr( isset( $settings['exad_team_carousel_per_view_mobile'] ) ) ? (int)$settings['exad_team_carousel_per_view_mobile'] : 1),
                'data-slidestoscroll'    => intval( esc_attr( $settings['exad_team_carousel_slides_to_scroll'] ) ),
                'data-carousel-nav'      => esc_attr( $settings['exad_team_carousel_nav'] ),
                'data-speed'             => esc_attr( $settings['exad_team_carousel_transition_duration'] ),
                'data-direction'         => esc_attr( $direction )
            ]
        );

        if ( 'yes' === $settings['exad_team_carousel_autoplay'] ) {
            $this->add_render_attribute( 'exad-team-carousel', 'data-autoplay', 'true' );
            $this->add_render_attribute( 'exad-team-carousel', 'data-autoplayspeed', intval( esc_attr( $settings['exad_team_carousel_autoplay_speed'] ) ) );
        }
        
        if ( 'yes' === $settings['exad_team_carousel_pause'] ) {
            $this->add_render_attribute( 'exad-team-carousel', 'data-pauseonhover', 'true' );
        }

        if ( 'yes' === $settings['exad_team_carousel_loop'] ) {
            $this->add_render_attribute( 'exad-team-carousel', 'data-loop', 'true' );
        }

        $this->add_render_attribute( 'exad_team_member_item', [
            'class' => [ 
                'exad-team-member', 
                esc_attr( $settings['exad_team_carousel_content_image_position'] ),
                esc_attr( $settings['exad_team_carousel_content_alignment'] )
            ]
        ]);
        
        if ( is_array( $settings['exad_team_carousel_repeater'] ) ) : ?>
            <div <?php echo $this->get_render_attribute_string( 'exad-team-carousel' );?>>
                <?php foreach ( $settings['exad_team_carousel_repeater'] as $key => $member ) : 

                    $each_team_member = 'each_member_' . $key;
					$this->add_render_attribute( $each_team_member, 'class', [
						'exad-team-carousel-inner',
						'elementor-repeater-item-'.esc_attr( $member['_id'] )
					] );

                    $member_name_key = $this->get_repeater_setting_key( 'exad_team_carousel_name', 'exad_team_carousel_repeater', $key );
					$this->add_render_attribute( $member_name_key, 'class', 'exad-team-member-name' );
					$this->add_inline_editing_attributes( $member_name_key, 'none' );

                    $member_designation_key = $this->get_repeater_setting_key( 'exad_team_carousel_designation', 'exad_team_carousel_repeater', $key );
					$this->add_render_attribute( $member_designation_key, 'class', 'exad-team-member-designation' );
					$this->add_inline_editing_attributes( $member_designation_key, 'none' );

                    $member_description_key = $this->get_repeater_setting_key( 'exad_team_carousel_description', 'exad_team_carousel_repeater', $key );
					$this->add_render_attribute( $member_description_key, 'class', 'exad-team-member-about' );
					$this->add_inline_editing_attributes( $member_description_key, 'basic' );
                    ?>
                    <div <?php echo $this->get_render_attribute_string( $each_team_member );?>>
                        <div <?php echo $this->get_render_attribute_string( 'exad_team_member_item' ); ?>>

                            <div class="exad-team-member-thumb <?php echo ( 'yes' === $settings['exad_team_carousel_animating_mask_switcher'] ) ? esc_attr( $settings['exad_team_carousel_animating_mask_style'] ) : ''; ?>">
                                <?php echo Group_Control_Image_Size::get_attachment_image_html( $member, 'thumbnail', 'exad_team_carousel_image'); ?>
                            </div>

                            <div class="exad-team-member-content">
                                <?php if ( ! empty( $member['exad_team_carousel_name'] ) ) : ?>
                                    <<?php echo Utils::validate_html_tag( $settings['exad_team_carousel_name_tag'] ); ?> <?php echo $this->get_render_attribute_string( $member_name_key ); ?>>
                                        <?php echo esc_html( $member['exad_team_carousel_name'] ); ?>
                                    </<?php echo Utils::validate_html_tag( $settings['exad_team_carousel_name_tag'] ); ?>>
                                <?php endif;

                                if ( ! empty( $member['exad_team_carousel_designation'] ) ) : ?>
                                    <span <?php echo $this->get_render_attribute_string( $member_designation_key ); ?>><?php echo esc_html( $member['exad_team_carousel_designation'] ); ?></span>
                                <?php endif;

                                if ( ! empty( $member['exad_team_carousel_description'] ) ) : ?>
                                        <div <?php echo $this->get_render_attribute_string( $member_description_key ); ?>><?Php echo wp_kses_post( $member['exad_team_carousel_description'] ); ?></div>
                                <?php endif;

                                if ( 'yes' === $member['exad_team_carousel_cta_btn'] && ! empty( $member['exad_team_carousel_cta_btn'] ) ) :
                                    $cta_link  = 'link_' . $key;
                                    $this->add_render_attribute( $cta_link, 'class', 'exad-team-member-cta' );
                                    if( $member['exad_team_carousel_cta_btn_link']['url'] ) {
                                        $this->add_render_attribute( $cta_link, 'href', esc_url( $member['exad_team_carousel_cta_btn_link']['url'] ) );
                                        if( $member['exad_team_carousel_cta_btn_link']['is_external'] ) {
                                            $this->add_render_attribute( $cta_link, 'target', '_blank' );
                                        }
                                        if( $member['exad_team_carousel_cta_btn_link']['nofollow'] ) {
                                            $this->add_render_attribute( $cta_link, 'rel', 'nofollow' );
                                        }
                                    } ?>
                                    <a <?php echo $this->get_render_attribute_string( $cta_link );?> >
                                        <?php echo esc_html( $member['exad_team_carousel_cta_btn_text'] ); ?>
                                    </a>
                                <?php endif;?>

                                <?php if ( 'yes' === $member['exad_team_carousel_enable_social_profiles'] ) : ?>
                                    <ul class="list-inline exad-team-member-social">
                                        
                                        <?php if ( ! empty( $member['exad_team_carousel_facebook_link']['url'] ) ) :   
                                            $target = $member['exad_team_carousel_facebook_link']['is_external'] ? ' target="_blank"' : '';
                                            $nofollow = $member['exad_team_carousel_facebook_link']['nofollow'] ? ' rel="nofollow"' : '' ; ?>
                                            <li>
                                                <a href="<?php echo esc_url( $member['exad_team_carousel_facebook_link']['url'] ); ?>" <?php echo $target;?> <?php echo $nofollow; ?>>
                                                    <i class="fa fa-facebook"></i>
                                                </a>
                                            </li>
                                        <?php endif; ?>

                                        <?php if ( ! empty( $member['exad_team_carousel_twitter_link']['url'] ) ) :
                                            $target = $member['exad_team_carousel_twitter_link']['is_external'] ? ' target="_blank"' : '';
                                            $nofollow = $member['exad_team_carousel_twitter_link']['nofollow'] ? ' rel="nofollow"' : '' ; ?>
                                            <li>
                                                <a href="<?php echo esc_url( $member['exad_team_carousel_twitter_link']['url'] ); ?>" <?php echo $target;?> <?php echo $nofollow; ?>>
                                                    <i class="fa fa-twitter"></i>
                                                </a>
                                            </li>
                                        <?php endif;

                                        if ( ! empty( $member['exad_team_carousel_instagram_link']['url'] ) ) : 
                                            $target = $member['exad_team_carousel_instagram_link']['is_external'] ? ' target="_blank"' : '' ;
                                            $nofollow = $member['exad_team_carousel_instagram_link']['nofollow'] ? ' rel="nofollow"' : '' ; ?>
                                            <li>
                                                <a href="<?php echo esc_url( $member['exad_team_carousel_instagram_link']['url'] ); ?>" <?php echo $target;?> <?php echo $nofollow; ?>>
                                                    <i class="fa fa-instagram"></i>
                                                </a>
                                            </li>
                                        <?php endif;?>

                                        <?php if ( ! empty( $member['exad_team_carousel_linkedin_link']['url'] ) ) :
                                            $target = $member['exad_team_carousel_linkedin_link']['is_external'] ? ' target="_blank"' : '' ;
                                            $nofollow = $member['exad_team_carousel_linkedin_link']['nofollow'] ? ' rel="nofollow"' : '' ; ?>
                                            <li>
                                                <a href="<?php echo esc_url( $member['exad_team_carousel_linkedin_link']['url'] ); ?>" <?php echo $target;?> <?php echo $nofollow; ?>>
                                                    <i class="fa fa-linkedin"></i>
                                                </a>
                                            </li>
                                        <?php endif;

                                        if ( ! empty( $member['exad_team_carousel_dribbble_link']['url'] ) ) :
                                            $target = $member['exad_team_carousel_dribbble_link']['is_external'] ? ' target="_blank"' : '' ;
                                            $nofollow = $member['exad_team_carousel_dribbble_link']['nofollow'] ? ' rel="nofollow"' : '' ; ?>
                                            <li>
                                                <a href="<?php echo esc_url( $member['exad_team_carousel_dribbble_link']['url'] ); ?>" <?php echo $target; ?> <?php echo $nofollow; ?>>
                                                    <i class="fa fa-dribbble"></i>
                                                </a>
                                            </li>
                                        <?php endif;?>
                                    </ul>
                                <?php endif;?>
                            </div>
                        </div>
                    </div>
                <?php endforeach;?>
            </div>
        <?php endif;
    }

    /**
     * Render team carousel widget output in the editor.
     *
     * Written as a Backbone JavaScript template and used to generate the live preview.
     *
     * @since 1.0.0
     * @access protected
     */
    protected function content_template() {
    ?>
        <#
            var direction = elementorCommon.config.isRTL ? 'true' : 'false';

            view.addRenderAttribute( 
                'exad-team-carousel', 
                {
                    'class' : ['exad-team-carousel-wrapper exad-team-item exad-carousel-item', settings.exad_team_carousel_nav_dot_alignment ],
                    'data-slidestoshow' : settings.exad_team_carousel_per_view,
                    'data-carousel-nav' : settings.exad_team_carousel_nav,
                    'data-slidestoscroll' : settings.exad_team_carousel_slides_to_scroll,
                    'data-speed': settings.exad_team_carousel_transition_duration,
                    'data-direction': direction
                }
            );

            if ( 'yes' === settings.exad_team_carousel_autoplay ) {
                view.addRenderAttribute( 'exad-team-carousel', 'data-autoplay', 'true' );
                view.addRenderAttribute( 'exad-team-carousel', 'data-autoplayspeed', settings.exad_team_carousel_autoplay_speed );
            }
            
            if ( 'yes' === settings.exad_team_carousel_pause ) {
                view.addRenderAttribute( 'exad-team-carousel', 'data-pauseonhover', 'true' );
            }

            if ( 'yes' === settings.exad_team_carousel_loop ) {
                view.addRenderAttribute( 'exad-team-carousel', 'data-loop', 'true' );
            }

            view.addRenderAttribute( 'exad_team_carousel_inner', 'class', 'exad-team-carousel-inner' );

            view.addRenderAttribute( 'exad_team_member_item', {
                'class': [ 
                    'exad-team-member', 
                    settings.exad_team_carousel_content_image_position,
                    settings.exad_team_carousel_content_alignment
                ]
            } );

        #>
        <# if ( settings.exad_team_carousel_repeater.length ) { #>
            <div {{{ view.getRenderAttributeString( 'exad-team-carousel' ) }}} >

                <# _.each( settings.exad_team_carousel_repeater, function( member, index ) { 
					var eachTeamMember = 'each_member_' + index;
                    view.addRenderAttribute( eachTeamMember, {
                        'class': [ 
                            'exad-team-carousel-inner', 
                            'elementor-repeater-item-' + member._id 
                        ]
                    } );

                    var memberNameKey = view.getRepeaterSettingKey( 'exad_team_carousel_name', 'exad_team_carousel_repeater', index );
                    view.addRenderAttribute( memberNameKey, 'class', 'exad-team-member-name' );
                    view.addInlineEditingAttributes( memberNameKey, 'none' );

                    var memberDesignationKey = view.getRepeaterSettingKey( 'exad_team_carousel_designation', 'exad_team_carousel_repeater', index );
                    view.addRenderAttribute( memberDesignationKey, 'class', 'exad-team-member-designation' );
                    view.addInlineEditingAttributes( memberDesignationKey, 'none' );

                    var memberDescriptionKey = view.getRepeaterSettingKey( 'exad_team_carousel_description', 'exad_team_carousel_repeater', index );
                    view.addRenderAttribute( memberDescriptionKey, 'class', 'exad-team-member-about' );
                    view.addInlineEditingAttributes( memberDescriptionKey, 'basic' );
                #>
                	<div {{{ view.getRenderAttributeString( eachTeamMember ) }}}>

                        <div {{{ view.getRenderAttributeString( 'exad_team_member_item' ) }}}>
                            <# if ( member.exad_team_carousel_image.url ) {
                                var image = {
                                    id: member.exad_team_carousel_image.id,
                                    url: member.exad_team_carousel_image.url,
                                    size: member.thumbnail_size,
                                    dimension: member.thumbnail_custom_dimension,
                                    model: view.getEditModel()
                                };

                                var nameHTMLTag = elementor.helpers.validateHTMLTag( settings.exad_team_carousel_name_tag );

                                var image_url = elementor.imagesManager.getImageUrl( image );

                                if ( image_url ) { #>
                                    <# if( 'yes' === settings.exad_team_carousel_animating_mask_switcher ) { #>
                                        <div class="exad-team-member-thumb {{ settings.exad_team_carousel_animating_mask_style }}">
                                            <img src="{{ image_url }}" class="circled" alt="{{ member.exad_team_carousel_name }}">
                                        </div>
                                    <# } else { #>
                                        <div class="exad-team-member-thumb">
                                            <img src="{{ image_url }}" class="circled" alt="{{ member.exad_team_carousel_name }}">
                                        </div>
                                    <# } #>
                                <# } 
                            } #>
                            <div class="exad-team-member-content">
                                <# if ( '' !== member.exad_team_carousel_name ) { #>
                                    <{{{ nameHTMLTag }}} {{{ view.getRenderAttributeString( memberNameKey ) }}}>{{{ member.exad_team_carousel_name }}}</{{{nameHTMLTag}}}>
                                <# } #>
                                <# if ( '' !== member.exad_team_carousel_designation ) { #>
                                    <span {{{ view.getRenderAttributeString( memberDesignationKey ) }}}>{{{ member.exad_team_carousel_designation }}}</span>
                                <# } #>
                                <# if ( '' !== member.exad_team_carousel_description ) { #>
                                    <div {{{ view.getRenderAttributeString( memberDescriptionKey ) }}}>{{{ member.exad_team_carousel_description }}}</div>
                                <# } #>

				                <# if ( 'yes' === member.exad_team_carousel_cta_btn ) {
				                    var ctaLink  = 'link_' + index;
				                    view.addRenderAttribute( ctaLink, 'class', 'exad-team-member-cta' );

				                    if( member.exad_team_carousel_cta_btn_link.url ) {
				                        view.addRenderAttribute( ctaLink, 'href', member.exad_team_carousel_cta_btn_link.url );
				                        if( member.exad_team_carousel_cta_btn_link.is_external ) {
				                            view.addRenderAttribute( ctaLink, 'target', '_blank' );
				                        }
				                        if( member.exad_team_carousel_cta_btn_link.nofollow ) {
				                            view.addRenderAttribute( ctaLink, 'rel', 'nofollow' );
				                        }
				                    }
				                #>
				                	<a {{{ view.getRenderAttributeString( ctaLink ) }}}>
				                        {{{ member.exad_team_carousel_cta_btn_text }}}
				                    </a>
				                <# } #>

                                <# if ( 'yes' === member.exad_team_carousel_enable_social_profiles ) { #>
                                    <ul class="list-inline exad-team-member-social">                                        
                                        <# if ( '' !== member.exad_team_carousel_facebook_link.url ) { 
                                            var fbTarget = member.exad_team_carousel_facebook_link.is_external ? ' target="_blank"' : '';
                                            var fbFollow = member.exad_team_carousel_facebook_link.nofollow ? ' rel="nofollow"' : '';
                                        #>
                                            <li>
                                                <a href="{{{ member.exad_team_carousel_facebook_link.url }}}" {{{ fbTarget }}} {{{ fbFollow }}}>
                                                    <i class="fa fa-facebook"></i>
                                                </a>
                                            </li>
                                        <# } #>

                                        <# if ( '' !== member.exad_team_carousel_twitter_link.url ) { 
                                            var twTarget = member.exad_team_carousel_twitter_link.is_external ? ' target="_blank"' : '';
                                            var twFollow = member.exad_team_carousel_twitter_link.nofollow ? ' rel="nofollow"' : '';
                                        #>
                                            <li>
                                                <a href="{{{ member.exad_team_carousel_twitter_link.url }}}" {{{ twTarget }}} {{{ twFollow }}}>
                                                    <i class="fa fa-twitter"></i>
                                                </a>
                                            </li>
                                        <# } #>

                                        <# if ( '' !== member.exad_team_carousel_instagram_link.url ) { 
                                            var instaTarget = member.exad_team_carousel_instagram_link.is_external ? ' target="_blank"' : '';
                                            var instaFollow = member.exad_team_carousel_instagram_link.nofollow ? ' rel="nofollow"' : '';
                                        #>
                                            <li>
                                                <a href="{{{ member.exad_team_carousel_instagram_link.url }}}" {{{ instaTarget }}} {{{ instaFollow }}}>
                                                    <i class="fa fa-instagram"></i>
                                                </a>
                                            </li>
                                        <# } #>

                                        <# if ( '' !== member.exad_team_carousel_linkedin_link.url ) { 
                                            var linkedInTarget = member.exad_team_carousel_linkedin_link.is_external ? ' target="_blank"' : '';
                                            var linkedInFollow = member.exad_team_carousel_linkedin_link.nofollow ? ' rel="nofollow"' : '';
                                        #>
                                            <li>
                                                <a href="{{{ member.exad_team_carousel_linkedin_link.url }}}" {{{ linkedInTarget }}} {{{ linkedInFollow }}}>
                                                    <i class="fa fa-linkedin"></i>
                                                </a>
                                            </li>
                                        <# } #>
                                        
                                        <# if ( '' !== member.exad_team_carousel_dribbble_link.url ) { 
                                            var dribbbleTarget = member.exad_team_carousel_dribbble_link.is_external ? ' target="_blank"' : '';
                                            var dribbbleFollow = member.exad_team_carousel_dribbble_link.nofollow ? ' rel="nofollow"' : '';
                                        #>
                                            <li>
                                                <a href="{{{ member.exad_team_carousel_dribbble_link.url }}}" {{{ dribbbleTarget }}} {{{ dribbbleFollow }}}>
                                                    <i class="fa fa-dribbble"></i>
                                                </a>
                                            </li>
                                        <# } #>
                                    </ul>
                                <# } #>
                            </div>
                        </div>
                    </div>
                <# } ); #>
            </div>
        <# } #>
    <?php   
    }

}