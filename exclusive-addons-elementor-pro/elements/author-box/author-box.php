<?php
namespace ExclusiveAddons\Elements;

if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.

use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Background;
use \Elementor\Group_Control_Border;
use \Elementor\Group_Control_Box_Shadow;
use \Elementor\Group_Control_Image_Size;
use \Elementor\Group_Control_Typography;
use \Elementor\Repeater;
use \Elementor\Icons_Manager;
use \Elementor\Widget_Base;
use \Elementor\Utils;
use \ExclusiveAddons\Elementor\Helper;

class Author_Box extends Widget_Base {

    public function get_name() {
        return 'exad-author-box';
    }

    public function get_title() {
        return __( 'Author Box', 'exclusive-addons-elementor-pro' );
    }

    public function get_icon() {
        return 'exad exad-logo exad-author-box';
    }

    public function get_keywords() {
        return [ 'author', 'box', 'author box' ];
    }

    public function get_categories() {
        return [ 'exclusive-addons-elementor' ];
    }

    protected function register_controls() {
        $exad_primary_color = get_option( 'exad_primary_color_option', '#7a56ff' );

        $this->start_controls_section(
            'exad_author_box_content',
            [
                'label' => esc_html__( 'Content', 'exclusive-addons-elementor-pro' ),
            ]
		);

		$this->add_control(
			'exad_author_before_login_message',
			[
				'label' => __( 'Not Logged in Message', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Login to your account', 'exclusive-addons-elementor-pro' ),
			]
		);
		
		$this->add_control(
			'exad_author_type',
			[
				'label' => __( 'Author Type', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'wp-default',
				'options' => [
					'wp-default'  => __( 'Wordpress Default', 'exclusive-addons-elementor-pro' ),
					'custom' => __( 'Custom', 'exclusive-addons-elementor-pro' ),
				],
			]
		);

		$this->add_control(
			'exad_author_custom_thumb',
			[
				'label' => __( 'Author Image', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::MEDIA,
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
				'dynamic' => [
					'active' => true,
				],
				'condition' => [
					'exad_author_type' => 'custom'
				]
			]
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name' => 'exad_author_custom_thumb_size',
				'exclude' => [ 'custom' ],
				'include' => [],
				'default' => 'large',
				'condition' => [
					'exad_author_type' => 'custom'
				]
			]
		);

		$this->add_control(
			'exad_author_custom_name',
			[
				'label' => __( 'Author Name', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'John Doe', 'exclusive-addons-elementor-pro' ),
				'condition' => [
					'exad_author_type' => 'custom'
				]
			]
		);

		$this->add_control(
            'exad_author_custom_name_tag',
            [
                'label'   => __('Name HTML Tag', 'exclusive-addons-elementor'),
                'type'    => Controls_Manager::SELECT,
                'options' => Helper::exad_title_tags(),
                'default' => 'h3',
            ]
		);

		$this->add_control(
			'exad_author_custom_name_url',
			[
				'label' => __( 'Author Url', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::URL,
				'placeholder' => __( 'https://your-link.com', 'exclusive-addons-elementor-pro' ),
				'show_external' => true,
				'default' => [
					'url' => '',
					'is_external' => true,
					'nofollow' => true,
				],
				'condition' => [
					'exad_author_type' => 'custom'
				]
			]
		);

		$this->add_control(
			'exad_author_custom_description',
			[
				'label' => __( 'Author Description', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::TEXTAREA,
				'default' => __( 'Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia,', 'exclusive-addons-elementor-pro' ),
				'condition' => [
					'exad_author_type' => 'custom'
				]
			]
		);

		$this->add_control(
			'exad_author_box_enable_email',
			[
				'label'   => esc_html__( 'Enable Email', 'exclusive-addons-elementor-pro' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'no'
			]
		);

		$this->add_control(
			'exad_author_custom_email_url',
			[
				'label' => __( 'Email Url', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::URL,
				'placeholder' => __( 'https://your-link.com', 'exclusive-addons-elementor-pro' ),
				'show_external' => true,
				'default' => [
					'url' => 'info@example.com',
				],
				'condition' => [
					'exad_author_type' => 'custom',
					'exad_author_box_enable_email' => 'yes',
				]
			]
		);

		$this->add_control(
			'exad_author_box_enable_website',
			[
				'label'   => esc_html__( 'Enable Website', 'exclusive-addons-elementor-pro' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'no'
			]
		);
		
		$this->add_control(
			'exad_author_box_display_name',
			[
				'label'   => esc_html__( 'Enable Display Name', 'exclusive-addons-elementor-pro' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'no',
				'condition' => [
					'exad_author_type' => 'wp-default'
				]
			]
		);
		
		$this->add_control(
			'exad_author_custom_website_url',
			[
				'label' => __( 'website Url', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::URL,
				'placeholder' => __( 'https://your-link.com', 'exclusive-addons-elementor-pro' ),
				'show_external' => true,
				'default' => [
					'url' => '#',
					'is_external' => true,
					'nofollow' => true,
				],
				'condition' => [
					'exad_author_type' => 'custom',
					'exad_author_box_enable_website' => 'yes',
				]
			]
		);

        $this->add_control(
			'exad_author_box_enable_social_profiles',
			[
				'label'   => esc_html__( 'Display Social Profiles?', 'exclusive-addons-elementor-pro' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'no'
			]
        );
        
        $repeater = new Repeater();

		$repeater->add_control(
			'exad_author_box_social_icon',
			[
				'label'            => __( 'Icon', 'exclusive-addons-elementor-pro' ),
				'type'             => Controls_Manager::ICONS,
				'label_block'      => true,
				'default'          => [
					'value'        => 'fab fa-wordpress',
					'library'      => 'fa-brands'
				],
				'recommended'      => [
					'fa-brands'    => [
						'android',
						'apple',
						'behance',
						'bitbucket',
						'codepen',
						'delicious',
						'deviantart',
						'digg',
						'dribbble',
						'facebook',
						'flickr',
						'foursquare',
						'free-code-camp',
						'github',
						'gitlab',
						'globe',
						'google-plus',
						'houzz',
						'instagram',
						'jsfiddle',
						'linkedin',
						'medium',
						'meetup',
						'mixcloud',
						'odnoklassniki',
						'pinterest',
						'product-hunt',
						'reddit',
						'shopping-cart',
						'skype',
						'slideshare',
						'snapchat',
						'soundcloud',
						'spotify',
						'stack-overflow',
						'steam',
						'stumbleupon',
						'telegram',
						'thumb-tack',
						'tripadvisor',
						'tumblr',
						'twitch',
						'twitter',
						'viber',
						'vimeo',
						'vk',
						'weibo',
						'weixin',
						'whatsapp',
						'wordpress',
						'xing',
						'yelp',
						'youtube',
						'500px'
					],
					'fa-solid' => [
						'envelope',
						'link',
						'rss'
					]
				]
			]
		);

		$repeater->add_control(
			'exad_author_box_social_link',
			[
				'label'       => __( 'Link', 'exclusive-addons-elementor-pro' ),
				'type'        => Controls_Manager::URL,
				'label_block' => true,
				'default'     => [
					'url'         => '#',
					'is_external' => 'true'
				],
				'dynamic'     => [
					'active'  => true
				],
				'placeholder' => __( 'https://your-link.com', 'exclusive-addons-elementor-pro' )
			]
		);

		$this->add_control(
			'exad_author_box_social_profile',
			[
				'label'       => __( 'Social Icons', 'exclusive-addons-elementor-pro' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'condition'   => [
					'exad_author_box_enable_social_profiles!' => ''
				],
				'default'     => [
					[
						'exad_author_box_social_icon' => [
							'value'   => 'fab fa-facebook-f',
							'library' => 'fa-brands'
						]
					],
					[
						'exad_author_box_social_icon' => [
							'value'   => 'fab fa-twitter',
							'library' => 'fa-brands'
						]
					],
					[
						'exad_author_box_social_icon' => [
							'value'   => 'fab fa-linkedin-in',
							'library' => 'fa-brands'
						],
					],
					[
						'exad_author_box_social_icon' => [
							'value'   => 'fab fa-google-plus-g',
							'library' => 'fa-brands',
						]
					]
				],
				'title_field' => '{{{ elementor.helpers.getSocialNetworkNameFromIcon( exad_author_box_social_icon, false, true, false, true ) }}}',
				'condition' => [
					'exad_author_box_enable_social_profiles' => 'yes'
				]
			]
		);
        
        $this->end_controls_section();

        /**
         * Container Style
         */

        $this->start_controls_section(
            'exad_author_box_container_style',
            [
                'label' => esc_html__( 'Container', 'exclusive-addons-elementor-pro' ),
                'tab'   => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_control(
			'exad_author_box_container_layout',
			[
				'label' => __( 'Layout', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'exad_author_left' => [
						'title' => __( 'Left', 'exclusive-addons-elementor-pro' ),
						'icon' => 'eicon-h-align-left',
					],
					'exad_author_top' => [
						'title' => __( 'Top', 'exclusive-addons-elementor-pro' ),
						'icon' => 'eicon-v-align-top',
					],
					'exad_author_right' => [
						'title' => __( 'Right', 'exclusive-addons-elementor-pro' ),
						'icon' => 'eicon-h-align-right',
					],
				],
				'default' => 'exad_author_left',
				'toggle' => true,
			]
		);

		$this->add_control(
			'exad_author_box_container_alignment',
			[
				'label' => __( 'Alignment', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => __( 'Left', 'exclusive-addons-elementor-pro' ),
						'icon' => 'eicon-text-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'exclusive-addons-elementor-pro' ),
						'icon' => 'eicon-text-align-center',
					],
					'right' => [
						'title' => __( 'Right', 'exclusive-addons-elementor-pro' ),
						'icon' => 'eicon-text-align-right',
					],
				],
				'default' => 'center',
				'toggle' => true,
				'condition' => [
					'exad_author_box_container_layout' => 'exad_author_top'
				]
			]
		);

        $this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'exad_author_box_container_background',
                'selector' => '{{WRAPPER}} .exad-author-box',
                'fields_options'  => [
					'background'  => [
						'default' => 'classic'
					],
					'color'       => [
						'default' => $exad_primary_color
					]
				]
			]
        );
        
        $this->add_responsive_control(
            'exad_author_box_container_padding',
            [
				'label'      => __('Padding', 'exclusive-addons-elementor-pro'),
				'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'default'    => [
                    'top' => '30',
                    'right' => '30',
                    'bottom' => '30',
                    'left' => '30',
                    'unit' => 'px',
                    'isLinked' => true,
                ],
				'selectors'  => [
                    '{{WRAPPER}} .exad-author-box' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->add_group_control(
        	Group_Control_Border::get_type(),
            [
				'name'     => 'exad_author_box_container_border',
				'selector' => '{{WRAPPER}} .exad-author-box'
            ]
        );

        $this->add_responsive_control(
            'exad_author_box_container_border_radius',
            [
				'label'      => __('Border Radius', 'exclusive-addons-elementor-pro'),
				'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'default'    => [
                    'top' => '10',
                    'right' => '10',
                    'bottom' => '10',
                    'left' => '10',
                    'unit' => 'px',
                    'isLinked' => true,
                ],
				'selectors'  => [
                    '{{WRAPPER}} .exad-author-box' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'exad_author_box_container_box_shadow',
				'selector' => '{{WRAPPER}} .exad-author-box'
			]
		);

        $this->end_controls_section();

        /**
         * Image Style
         */

        $this->start_controls_section(
            'exad_author_box_image_style',
            [
                'label' => esc_html__( 'Image', 'exclusive-addons-elementor-pro' ),
                'tab'   => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_responsive_control(
			'exad_author_box_image_size',
			[
				'label' => __( 'Image Size', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 500,
						'step' => 1,
                    ]
				],
				'default' => [
					'unit' => 'px',
					'size' => 100,
				],
				'selectors' => [
					'{{WRAPPER}} .exad-author-box.exad_author_top .exad-author-box-wrapper .exad-author-box-thumb' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .exad-author-box.exad_author_left .exad-author-box-wrapper .exad-author-box-thumb' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .exad-author-box.exad_author_left .exad-author-box-wrapper .exad-author-box-content' => 'width: calc( 100% - {{SIZE}}{{UNIT}} );',
                    '{{WRAPPER}} .exad-author-box.exad_author_right .exad-author-box-wrapper .exad-author-box-thumb' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .exad-author-box.exad_author_right .exad-author-box-wrapper .exad-author-box-content' => 'width: calc( 100% - {{SIZE}}{{UNIT}} );',
				],
			]
        );
        
        $this->add_group_control(
        	Group_Control_Border::get_type(),
            [
				'name'     => 'exad_author_box_image_border',
				'selector' => '{{WRAPPER}} .exad-author-box-wrapper .exad-author-box-thumb'
            ]
        );

        $this->add_responsive_control(
            'exad_author_box_image_border_radius',
            [
				'label'      => __('Border Radius', 'exclusive-addons-elementor-pro'),
				'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'default'    => [
                    'top' => '50',
                    'right' => '50',
                    'bottom' => '50',
                    'left' => '50',
                    'unit' => 'px',
                    'isLinked' => true,
                ],
				'selectors'  => [
                    '{{WRAPPER}} .exad-author-box-wrapper .exad-author-box-thumb' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'exad_author_box_image_box_shadow',
				'selector' => '{{WRAPPER}} .exad-author-box-wrapper .exad-author-box-thumb'
			]
		);

        $this->end_controls_section();

        /**
         * Content Style
         */

        $this->start_controls_section(
            'exad_author_box_content_style',
            [
                'label' => esc_html__( 'Content', 'exclusive-addons-elementor-pro' ),
                'tab'   => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_responsive_control(
			'exad_author_box_content_left_spacing',
			[
				'label' => __( 'Left Spacing', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
                    ]
				],
				'default' => [
					'unit' => 'px',
					'size' => 30,
				],
				'separator' => 'after',
				'selectors' => [
					'{{WRAPPER}} .exad-author-box.exad_author_left .exad-author-box-wrapper .exad-author-box-content' => 'padding-left: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'exad_author_box_container_layout' => 'exad_author_left'
                ]
			]
        );

        $this->add_responsive_control(
			'exad_author_box_content_right_spacing',
			[
				'label' => __( 'Right Spacing', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
                    ]
				],
				'default' => [
					'unit' => 'px',
					'size' => 30,
				],
				'selectors' => [
					'{{WRAPPER}} .exad-author-box.exad_author_right .exad-author-box-wrapper .exad-author-box-content' => 'padding-right: {{SIZE}}{{UNIT}};',
				],
				'separator' => 'after',
                'condition' => [
                    'exad_author_box_container_layout' => 'exad_author_right'
                ]
			]
        );

        $this->add_control(
			'exad_author_box_content_name_heading',
			[
				'label' => __( 'Author Name', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::HEADING,
			]
        );
        
        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'exad_author_box_content_name_typography',
				'label' => __( 'Typography', 'exclusive-addons-elementor-pro' ),
				'selector' => '{{WRAPPER}} .exad-author-box-wrapper .exad-author-box-content .exad-author-name',
			]
        );
        
        $this->add_responsive_control(
            'exad_author_box_content_name_margin',
            [
				'label'      => __('Margin', 'exclusive-addons-elementor-pro'),
				'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'default'    => [
                    'top' => '0',
                    'right' => '0',
                    'bottom' => '10',
                    'left' => '0',
                    'unit' => 'px',
                    'isLinked' => true,
                ],
				'selectors'  => [
                    '{{WRAPPER}} .exad-author-box-wrapper .exad-author-box-content .exad-author-name' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
		);
		
		$this->start_controls_tabs( 'exad_author_box_content_name_tabs' );

			$this->start_controls_tab( 'exad_author_box_content_name_normal', [ 'label' => esc_html__( 'Normal', 'exclusive-addons-elementor-pro' ) ] );

				$this->add_control(
					'exad_author_box_content_name_color',
					[
						'label' => __( 'Text Color', 'exclusive-addons-elementor-pro' ),
						'type' => Controls_Manager::COLOR,
						'default' => '#ffffff',
						'selectors' => [
							'{{WRAPPER}} .exad-author-box-wrapper .exad-author-box-content .exad-author-name' => 'color: {{VALUE}}',
						],
					]
				);
		
			$this->end_controls_tab();

			$this->start_controls_tab( 'exad_author_box_content_name_hover', [ 'label' => esc_html__( 'Hover', 'exclusive-addons-elementor-pro' ) ] );

				$this->add_control(
					'exad_author_box_content_name_color_hover',
					[
						'label' => __( 'Text Color', 'exclusive-addons-elementor-pro' ),
						'type' => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .exad-author-box-wrapper .exad-author-box-content .exad-author-name:hover' => 'color: {{VALUE}}',
						],
					]
				);

			$this->end_controls_tab();
		
		$this->end_controls_tabs();

        $this->add_control(
			'exad_author_box_content_description_heading',
			[
				'label' => __( 'Author Description', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
        );
        
        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'exad_author_box_content_description_typography',
				'label' => __( 'Typography', 'exclusive-addons-elementor-pro' ),
				'selector' => '{{WRAPPER}} .exad-author-box-wrapper .exad-author-box-content .exad-author-description',
			]
        );
        
        $this->add_control(
			'exad_author_box_content_description_color',
			[
				'label' => __( 'Text Color', 'exclusive-addons-elementor-pro' ),
                'type' => Controls_Manager::COLOR,
                'default' => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .exad-author-box-wrapper .exad-author-box-content .exad-author-description' => 'color: {{VALUE}}',
				],
			]
        );
        
        $this->add_responsive_control(
            'exad_author_box_content_description_margin',
            [
				'label'      => __('Margin', 'exclusive-addons-elementor-pro'),
				'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'default'    => [
                    'top' => '0',
                    'right' => '0',
                    'bottom' => '10',
                    'left' => '0',
                    'unit' => 'px',
                    'isLinked' => true,
                ],
				'selectors'  => [
                    '{{WRAPPER}} .exad-author-box-wrapper .exad-author-box-content .exad-author-description' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

		$this->end_controls_section();
		
		/**
         * Email Style
         */

        $this->start_controls_section(
            'exad_author_box_email_style',
            [
                'label' => esc_html__( 'Email', 'exclusive-addons-elementor-pro' ),
                'tab'   => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'exad_author_box_enable_email' => 'yes'
                ]
            ]
		);

		$this->add_responsive_control(
            'exad_author_box_email_margin',
            [
				'label'      => __('Margin', 'exclusive-addons-elementor-pro'),
				'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'default'    => [
                    'top' => '0',
                    'right' => '0',
                    'bottom' => '10',
                    'left' => '0',
                    'unit' => 'px',
                    'isLinked' => true,
                ],
				'selectors'  => [
                    '{{WRAPPER}} .exad-author-box-wrapper .exad-author-box-content .exad-author-email' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

		$this->add_control(
			'exad_author_box_email_text_heading',
			[
				'label' => __( 'Email Text', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'exad_author_box_email_text_typography',
				'label' => __( 'Typography', 'exclusive-addons-elementor-pro' ),
				'selector' => '{{WRAPPER}} .exad-author-box-wrapper .exad-author-box-content .exad-author-email-text',
			]
        );
        
        $this->add_control(
			'exad_author_box_email_text_color',
			[
				'label' => __( 'Text Color', 'exclusive-addons-elementor-pro' ),
                'type' => Controls_Manager::COLOR,
                'default' => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .exad-author-box-wrapper .exad-author-box-content .exad-author-email-text' => 'color: {{VALUE}}',
				],
			]
        );
        
        $this->add_responsive_control(
			'exad_author_box_email_text_right_spacing',
			[
				'label' => __( 'Right Spacing', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
                    ]
				],
				'default' => [
					'unit' => 'px',
					'size' => 3,
				],
				'selectors' => [
					'{{WRAPPER}} .exad-author-box-wrapper .exad-author-box-content .exad-author-email-text' => 'margin-right: {{SIZE}}{{UNIT}};',
                ],
			]
		);
		
		$this->add_control(
			'exad_author_box_email_address_heading',
			[
				'label' => __( 'Email Address', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'exad_author_box_email_address_typography',
				'label' => __( 'Typography', 'exclusive-addons-elementor-pro' ),
				'selector' => '{{WRAPPER}} .exad-author-box-wrapper .exad-author-box-content .exad-author-email-address',
			]
		);
		
		$this->start_controls_tabs( 'exad_author_box_email_address_tabs' );

			$this->start_controls_tab( 'exad_author_box_email_address_normal', [ 'label' => esc_html__( 'Normal', 'exclusive-addons-elementor-pro' ) ] );

				$this->add_control(
					'exad_author_box_email_address_color',
					[
						'label' => __( 'Address Color', 'exclusive-addons-elementor-pro' ),
						'type' => Controls_Manager::COLOR,
						'default' => '#ffffff',
						'selectors' => [
							'{{WRAPPER}} .exad-author-box-wrapper .exad-author-box-content .exad-author-email-address' => 'color: {{VALUE}}',
						],
					]
				);
		
			$this->end_controls_tab();

			$this->start_controls_tab( 'exad_author_box_email_address_hover', [ 'label' => esc_html__( 'Hover', 'exclusive-addons-elementor-pro' ) ] );

				$this->add_control(
					'exad_author_box_email_address_color_hover',
					[
						'label' => __( 'Address Color', 'exclusive-addons-elementor-pro' ),
						'type' => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .exad-author-box-wrapper .exad-author-box-content .exad-author-email-address:hover' => 'color: {{VALUE}}',
						],
					]
				);

			$this->end_controls_tab();
		
		$this->end_controls_tabs();
		
		$this->end_controls_section();

		/**
         * Website Style
         */

        $this->start_controls_section(
            'exad_author_box_website_style',
            [
                'label' => esc_html__( 'Website', 'exclusive-addons-elementor-pro' ),
                'tab'   => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'exad_author_box_enable_website' => 'yes'
                ]
            ]
		);

		$this->add_responsive_control(
            'exad_author_box_website_margin',
            [
				'label'      => __('Margin', 'exclusive-addons-elementor-pro'),
				'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'default'    => [
                    'top' => '0',
                    'right' => '0',
                    'bottom' => '10',
                    'left' => '0',
                    'unit' => 'px',
                    'isLinked' => true,
                ],
				'selectors'  => [
                    '{{WRAPPER}} .exad-author-box-wrapper .exad-author-box-content .exad-author-website' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

		$this->add_control(
			'exad_author_box_website_text_heading',
			[
				'label' => __( 'Website Text', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'exad_author_box_email_website_typography',
				'label' => __( 'Typography', 'exclusive-addons-elementor-pro' ),
				'selector' => '{{WRAPPER}} .exad-author-box-wrapper .exad-author-box-content .exad-author-website-text',
			]
        );
        
        $this->add_control(
			'exad_author_box_website_text_color',
			[
				'label' => __( 'Text Color', 'exclusive-addons-elementor-pro' ),
                'type' => Controls_Manager::COLOR,
                'default' => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .exad-author-box-wrapper .exad-author-box-content .exad-author-website-text' => 'color: {{VALUE}}',
				],
			]
        );
        
        $this->add_control(
			'exad_author_box_website_text_right_spacing',
			[
				'label' => __( 'Right Spacing', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
                    ]
				],
				'default' => [
					'unit' => 'px',
					'size' => 3,
				],
				'selectors' => [
					'{{WRAPPER}} .exad-author-box-wrapper .exad-author-box-content .exad-author-website-text' => 'margin-right: {{SIZE}}{{UNIT}};',
                ],
			]
		);
		
		$this->add_control(
			'exad_author_box_website_address_heading',
			[
				'label' => __( 'Website Address', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'exad_author_box_website_address_typography',
				'label' => __( 'Typography', 'exclusive-addons-elementor-pro' ),
				'selector' => '{{WRAPPER}} .exad-author-box-wrapper .exad-author-box-content .exad-author-website-address',
			]
		);
		
		$this->start_controls_tabs( 'exad_author_box_website_address_tabs' );

			$this->start_controls_tab( 'exad_author_box_website_address_normal', [ 'label' => esc_html__( 'Normal', 'exclusive-addons-elementor-pro' ) ] );

				$this->add_control(
					'exad_author_box_website_address_color',
					[
						'label' => __( 'Address Color', 'exclusive-addons-elementor-pro' ),
						'type' => Controls_Manager::COLOR,
						'default' => '#ffffff',
						'selectors' => [
							'{{WRAPPER}} .exad-author-box-wrapper .exad-author-box-content .exad-author-website-address' => 'color: {{VALUE}}',
						],
					]
				);
		
			$this->end_controls_tab();

			$this->start_controls_tab( 'exad_author_box_website_address_hover', [ 'label' => esc_html__( 'Hover', 'exclusive-addons-elementor-pro' ) ] );

				$this->add_control(
					'exad_author_box_website_address_color_hover',
					[
						'label' => __( 'Address Color', 'exclusive-addons-elementor-pro' ),
						'type' => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .exad-author-box-wrapper .exad-author-box-content .exad-author-website-address:hover' => 'color: {{VALUE}}',
						],
					]
				);

			$this->end_controls_tab();
		
		$this->end_controls_tabs();
		
		$this->end_controls_section();

        /**
         * Social Profile Style
         */

        $this->start_controls_section(
            'exad_author_box_social_style',
            [
                'label' => esc_html__( 'Social Profile', 'exclusive-addons-elementor-pro' ),
                'tab'   => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'exad_author_box_enable_social_profiles' => 'yes'
                ]
            ]
        );

        $this->add_responsive_control(
			'exad_author_box_social_icon_box_size',
			[
				'label'        => __( 'Icon Box Size', 'exclusive-addons-elementor-pro' ),
				'type'         => Controls_Manager::SLIDER,
				'size_units'   => [ 'px' ],
				'range'        => [
					'px'       => [
						'min'  => 0,
						'max'  => 100,
						'step' => 1
					]
				],
				'default'      => [
					'unit'     => 'px',
					'size'     => 30
				],
				'selectors'    => [
					'{{WRAPPER}} .exad-author-box .exad-author-social li a' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};'
				]
			]
		);

        $this->add_responsive_control(
			'exad_author_box_social_icon_size',
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
					'{{WRAPPER}} .exad-author-box .exad-author-social li a i' => 'font-size: {{SIZE}}{{UNIT}};'
				]
			]
        );

        $this->add_responsive_control(
			'exad_author_box_social_icon_spacing',
			[
				'label'        => __( 'Spacing', 'exclusive-addons-elementor-pro' ),
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
					'{{WRAPPER}} .exad-author-box .exad-author-social li:not(:last-child) a' => 'margin-right: {{SIZE}}{{UNIT}};'
				]
			]
        );

        $this->add_responsive_control(
            'exad_author_box_social_icon_border_radius',
            [
				'label'      => __('Border Radius', 'exclusive-addons-elementor-pro'),
				'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'default'    => [
                    'top' => '30',
                    'right' => '30',
                    'bottom' => '30',
                    'left' => '30',
                    'unit' => 'px',
                    'isLinked' => true,
                ],
				'selectors'  => [
                    '{{WRAPPER}} .exad-author-box .exad-author-social li a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );
        
        $this->start_controls_tabs( 'exad_author_box_social_icon_tabs' );

			$this->start_controls_tab( 'exad_author_box_social_icon_normal', [ 'label' => esc_html__( 'Normal', 'exclusive-addons-elementor-pro' ) ] );

				$this->add_control(
					'exad_author_box_social_icon_normal_color',
					[
						'label'     => esc_html__( 'Icon Color', 'exclusive-addons-elementor-pro' ),
						'type'      => Controls_Manager::COLOR,
						'default'   => '#a4a7aa',
						'selectors' => [
							'{{WRAPPER}} .exad-author-box .exad-author-social li a i' => 'color: {{VALUE}};'
						]
					]
				);

				$this->add_control(
					'exad_author_box_social_icon_normal_background',
					[
						'label'     => esc_html__( 'Background Color', 'exclusive-addons-elementor-pro' ),
						'type'      => Controls_Manager::COLOR,
						'default'   => '#e5e5e5',
						'selectors' => [
							'{{WRAPPER}} .exad-author-box .exad-author-social li a' => 'background-color: {{VALUE}};'
						]
					]
				);

				$this->add_group_control(
					Group_Control_Border::get_type(),
					[
						'name'     => 'exad_author_box_social_icon_normal_border',
						'selector' => '{{WRAPPER}} .exad-author-box .exad-author-social li a'
					]
                );
                
                $this->add_group_control(
                    Group_Control_Box_Shadow::get_type(),
                    [
                        'name'     => 'exad_author_box_social_icon_normal_shadow',
                        'selector' => '{{WRAPPER}} .exad-author-box .exad-author-social li a'
                    ]
                );
		
			$this->end_controls_tab();

			$this->start_controls_tab( 'exad_team_members_social_icon_hover', [ 'label' => esc_html__( 'Hover', 'exclusive-addons-elementor-pro' ) ] );

                $this->add_control(
                    'exad_author_box_social_icon_hover_color',
                    [
                        'label'     => esc_html__( 'Icon Color', 'exclusive-addons-elementor-pro' ),
                        'type'      => Controls_Manager::COLOR,
                        'default'   => '#a4a7aa',
                        'selectors' => [
                            '{{WRAPPER}} .exad-author-box .exad-author-social li a:hover i' => 'color: {{VALUE}};'
                        ]
                    ]
                );

                $this->add_control(
                    'exad_author_box_social_icon_hover_background',
                    [
                        'label'     => esc_html__( 'Background Color', 'exclusive-addons-elementor-pro' ),
                        'type'      => Controls_Manager::COLOR,
                        'default'   => '',
                        'selectors' => [
                            '{{WRAPPER}} .exad-author-box .exad-author-social li a:hover' => 'background-color: {{VALUE}};'
                        ]
                    ]
                );

                $this->add_group_control(
                    Group_Control_Border::get_type(),
                    [
                        'name'     => 'exad_author_box_social_icon_hover_border',
                        'selector' => '{{WRAPPER}} .exad-author-box .exad-author-social li a:hover'
                    ]
                );

                $this->add_group_control(
                    Group_Control_Box_Shadow::get_type(),
                    [
                        'name'     => 'exad_author_box_social_icon_hover_shadow',
                        'selector' => '{{WRAPPER}} .exad-author-box .exad-author-social li a:hover'
                    ]
                );

			$this->end_controls_tab();
		
		$this->end_controls_tabs();

		$this->end_controls_section();

		/**
         * Login Message Style
         */

        $this->start_controls_section(
            'exad_author_box_login_message_style',
            [
                'label' => esc_html__( 'Before Login Message Style', 'exclusive-addons-elementor-pro' ),
                'tab'   => Controls_Manager::TAB_STYLE
            ]
        );

		$this->add_control(
			'exad_author_box_login_message_alignment',
			[
				'label' => __( 'Alignment', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => __( 'Left', 'exclusive-addons-elementor-pro' ),
						'icon' => 'eicon-h-align-left',
					],
					'center' => [
						'title' => __( 'Top', 'exclusive-addons-elementor-pro' ),
						'icon' => 'eicon-h-align-center',
					],
					'right' => [
						'title' => __( 'Right', 'exclusive-addons-elementor-pro' ),
						'icon' => 'eicon-h-align-right',
					],
				],
				'default' => 'left',
				'selectors' => [
					'{{WRAPPER}} .exad-author-login' => 'text-align: {{VALUE}};'
				]
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'exad_author_box_login_message_typography',
				'label' => __( 'Typography', 'exclusive-addons-elementor-pro' ),
				'selector' => '{{WRAPPER}} .exad-author-login',
			]
        );

		$this->add_control(
			'exad_author_box_login_message_text_color',
			[
				'label'     => esc_html__( 'Text Color', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .exad-author-login' => 'color: {{VALUE}};'
				]
			]
		);

		$this->add_control(
			'exad_author_box_login_message_text_color_hover',
			[
				'label'     => esc_html__( 'Hover Text Color', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .exad-author-login:hover' => 'color: {{VALUE}};'
				]
			]
		);

		$this->end_controls_section();

    }

    public function render() {
		$settings = $this->get_settings_for_display();

		$current_user = wp_get_current_user();

        $author_name = $current_user->user_login;
        $author_display_name = $current_user->display_name;
        $author_description = $current_user->user_description;
        $author_email = $current_user->user_email;
		$author_url = $current_user->user_url;

		if( $settings['exad_author_type'] != 'custom' ){
			if ( !is_user_logged_in() ){
				echo '<a class="exad-author-login" href="/wp-login.php" rel="home">'. esc_html( ($settings['exad_author_before_login_message']) ) .'</a>';
				return;
			}
		}
		
		$target = empty( $settings['exad_author_custom_name_url']['is_external']) ? ' target="_blank"' : '';
		$nofollow = empty( $settings['exad_author_custom_name_url']['nofollow'] ) ? ' rel="nofollow"' : '';

		$web_target = empty( $settings['exad_author_custom_name_url']['is_external'] ) ? ' target="_blank"' : '';
		$web_nofollow = empty( $settings['exad_author_custom_website_url']['nofollow'] ) ? ' rel="nofollow"' : '';

        ?>
		<div class="exad-author-box <?php echo esc_attr( $settings['exad_author_box_container_layout'] ); ?> <?php echo esc_attr( $settings['exad_author_box_container_alignment'] ); ?>">
			<div class="exad-author-box-wrapper">
				<div class="exad-author-box-thumb">
					<?php if( 'wp-default' === $settings['exad_author_type'] ){ ?>
						<?php echo get_avatar( get_current_user_id('user_login'), 500 ) ?>
					<?php } ?>
					<?php if( 'custom' === $settings['exad_author_type'] ){ ?>
						<?php echo Group_Control_Image_Size::get_attachment_image_html( $settings, 'exad_author_custom_thumb_size', 'exad_author_custom_thumb' ); ?>
					<?php } ?>
				</div>
				<div class="exad-author-box-content">
					<?php if( 'wp-default' === $settings['exad_author_type'] ){ ?>
						<<?php echo Utils::validate_html_tag( $settings['exad_author_custom_name_tag'] ); ?>>
							<?php if( 'yes' === $settings['exad_author_box_display_name'] ){ ?>
								<a class="exad-author-name" href="<?php echo esc_url( get_author_posts_url( get_current_user_id('user_login') ) ); ?>">
									<?php echo esc_html( $author_display_name ); ?>
								</a>
							<?php } else { ?>
								<a class="exad-author-name" href="<?php echo esc_url( get_author_posts_url( get_current_user_id('user_login') ) ); ?>">
									<?php echo esc_html( $author_name ); ?>
								</a>
							<?php } ?>
						</<?php echo Utils::validate_html_tag( $settings['exad_author_custom_name_tag'] ); ?>>
						<p class="exad-author-description"><?php echo esc_html( $author_description ); ?></p>
						<?php if( 'yes' === $settings['exad_author_box_enable_email'] ){ ?>
							<div class="exad-author-email">
								<span class="exad-author-email-text"><?php echo __( 'Email: ', 'exclusive-addons-elementor-pro' ); ?> </span><a href="mailto:<?php echo esc_url( $author_email ); ?>" class="exad-author-email-address"><?php echo esc_html( $author_email ); ?></a>
							</div>
						<?php } ?>
						<?php if( 'yes' === $settings['exad_author_box_enable_website'] ){ ?>
							<div class="exad-author-website">
								<span class="exad-author-website-text"><?php echo __( 'Website: ', 'exclusive-addons-elementor-pro' ); ?> </span><a href="<?php echo esc_url( $author_url ); ?>" class="exad-author-website-address"><?php echo esc_html( $author_url ); ?></a>
							</div>
						<?php } ?>
					<?php } ?>
					<?php if( $settings['exad_author_type'] === 'custom' ){ ?>
						<<?php echo Utils::validate_html_tag( $settings['exad_author_custom_name_tag'] ); ?>>
							<a class="exad-author-name" href="<?php echo esc_url( $settings['exad_author_custom_name_url']['url'] ); ?>" <?php echo $target; ?> <?php echo $nofollow; ?>>
								<?php echo Helper::exad_wp_kses( $settings['exad_author_custom_name'] ); ?>
							</a>
						</<?php echo Utils::validate_html_tag( $settings['exad_author_custom_name_tag'] ); ?>>
						<p class="exad-author-description"><?php echo Helper::exad_wp_kses( $settings['exad_author_custom_description'] ); ?></p>
						<?php if( 'yes' === $settings['exad_author_box_enable_email'] ){ ?>
							<div class="exad-author-email">
								<span class="exad-author-email-text"><?php echo __( 'Email: ', 'exclusive-addons-elementor-pro' ); ?> </span><a href="mailto:<?php echo esc_url( $settings['exad_author_custom_email_url']['url'] ); ?>" class="exad-author-email-address"><?php echo esc_url( $settings['exad_author_custom_email_url']['url'] ); ?></a>
							</div>
						<?php } ?>
						<?php if( 'yes' === $settings['exad_author_box_enable_website'] ){ ?>
							<div class="exad-author-website">
								<span class="exad-author-website-text"><?php echo __( 'Website: ', 'exclusive-addons-elementor-pro' ); ?> </span><a href="<?php echo esc_url( $settings['exad_author_custom_website_url']['url'] ); ?> <?php echo $web_target; ?> <?php echo $web_nofollow; ?>" class="exad-author-website-address"><?php echo esc_url( $settings['exad_author_custom_website_url']['url'] ); ?></a>
							</div>
						<?php } ?>
					<?php } ?>
					<?php if ( 'yes' === $settings['exad_author_box_enable_social_profiles'] ) { ?>
						<ul class="exad-author-social">
							<?php foreach ( $settings['exad_author_box_social_profile'] as $index => $item ) {
								$social   = '';
								$link_key = 'exad_author_box_social_link_' . $index;
								

								if ( 'svg' !== $item['exad_author_box_social_icon']['library'] ) {
									$social = explode( ' ', $item['exad_author_box_social_icon']['value'], 2 );
									if ( empty( $social[1] ) ) {
										$social = '';
									} else {
										$social = str_replace( 'fa-', '', $social[1] );
									}
								}
								if ( 'svg' === $item['exad_author_box_social_icon']['library'] ) {
									$social = '';
								}

								if( $item['exad_author_box_social_link']['url'] ) {
									$this->add_render_attribute( $link_key, 'href', esc_url( $item['exad_author_box_social_link']['url'] ) );
									if( $item['exad_author_box_social_link']['is_external'] ) {
										$this->add_render_attribute( $link_key, 'target', '_blank' );
									}
									if( $item['exad_author_box_social_link']['nofollow'] ) {
										$this->add_render_attribute( $link_key, 'rel', 'nofollow' );
									}
								}

								$this->add_render_attribute( $link_key, 'class', [
									'exad-author-social-icon',
									'elementor-repeater-item-' . $item['_id'],
								] );

								?>

								<li>
									<a <?php echo $this->get_render_attribute_string( $link_key ); ?>>
										<?php Icons_Manager::render_icon( $item['exad_author_box_social_icon'], [ 'aria-hidden' => 'true' ] ); ?>
									</a>
								</li>
							<?php } ?>
						</ul>
					<?php } ?>
				</div>
			</div>
        </div>
        <?php
    }
}