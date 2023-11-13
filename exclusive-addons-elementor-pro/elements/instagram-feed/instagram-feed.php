<?php
namespace ExclusiveAddons\Elements;

if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.

use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Border;
use \Elementor\Group_Control_Typography;
use \Elementor\Group_Control_Image_Size;
use \Elementor\Group_Control_Box_Shadow;
use \Elementor\Group_Control_Background;
use \Elementor\Widget_Base;
use \Elementor\Utils;

class Instagram_Feed extends Widget_Base {
    
    public function get_name() {
        return 'exad-instagram-feed';
    }

    public function get_title() {
        return __( 'Instagram Feed', 'exclusive-addons-elementor-pro' );
    }

    public function get_icon() {
        return 'exad exad-logo exad-instagram-feed';
    }

    public function get_categories() {
        return [ 'exclusive-addons-elementor' ];
    }

    public function get_keywords() {
        return [ 'social', 'sharing', 'slider', 'carousel', 'gallery' ];
    }
  
    public function get_script_depends() {
        return [ 'exad-slick', 'exad-insta-feed' ];
    }

    protected function register_controls() {

        $exad_primary_color = get_option( 'exad_primary_color_option', '#7a56ff' );

        /**
         * Instagram Feed Generel Option
         */
        $this->start_controls_section(
            'exad_instagram_feed_content_section',
            [
                'label' => __('Content', 'exclusive-addons-elementor-pro')
            ]
        );

        // instagram access token
        $this->add_control(
            'exad_instagram_feed_access_token',
            [   
                'label'         => __( 'Access Token', 'exclusive-addons-elementor-pro' ),
                'type'          => Controls_Manager::TEXT,
                'label_block' => true,
            ]
        );    

        $this->add_control(
			'exad_instagram_feed_access_token_important_note',
			[
				'label' => __( 'Important Note', 'exclusive-addons-elementor-pro' ),
				'show_label' => false,
				'type' => Controls_Manager::RAW_HTML,
				'raw' => '<a href="https://developers.facebook.com/docs/instagram-basic-display-api/getting-started" target="_blank">Get Access Token</a>',
				'content_classes' => 'your-class',
			]
		);

        $this->end_controls_section();

        /**
         * Instagram Feed Settings Option
         */
        $this->start_controls_section(
            'exad_instagram_feed_Setting_section',
            [
                'label' => __('Settings', 'exclusive-addons-elementor-pro')
            ]
        );

        // number of instagram photos to show
        $this->add_control(
            'exad_instagram_feed_photos_number',
            [
                'label'         => __('Number of Photos', 'exclusive-addons-elementor-pro' ),
                'type'          => Controls_Manager::NUMBER,
                'description'   => __('Enter the number of instagram photos. Default: 9', 'exclusive-addons-elementor-pro'),
                'min'           => 1,
                'step'          => 1,
                'default'       => 9            
            ]
        );

        $this->add_responsive_control(
			'exad_instagram_feed_column_number',
			[
				'label' => __( 'Number of Column', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'exad-col-1'  => __( 'Column 1', 'exclusive-addons-elementor-pro' ),
					'exad-col-2'  => __( 'Column 2', 'exclusive-addons-elementor-pro' ),
					'exad-col-3'  => __( 'Column 3', 'exclusive-addons-elementor-pro' ),
					'exad-col-4'  => __( 'Column 4', 'exclusive-addons-elementor-pro' ),
					'exad-col-5'  => __( 'Column 5', 'exclusive-addons-elementor-pro' ),
					'exad-col-6'  => __( 'Column 6', 'exclusive-addons-elementor-pro' ),
				],
				'desktop_default' => 'exad-col-3',
				'tablet_default' => 'exad-col-2',
				'mobile_default' => 'exad-col-1',
				'selectors_dictionary' => [
					'exad-col-1' => 'grid-template-columns: repeat(1, 1fr);',
					'exad-col-2' => 'grid-template-columns: repeat(2, 1fr);',
					'exad-col-3' => 'grid-template-columns: repeat(3, 1fr);',
					'exad-col-4' => 'grid-template-columns: repeat(4, 1fr);',
					'exad-col-5' => 'grid-template-columns: repeat(5, 1fr);',
					'exad-col-6' => 'grid-template-columns: repeat(6, 1fr);',
				],
				'selectors' => [
					'{{WRAPPER}} .exad-instagram-feed-item' => '{{VALUE}};'
				]
			]
        );
        
        $this->add_control(
			'exad_instagram_feed_enable_caption',
			[
				'label' => __( 'Show Caption', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'exclusive-addons-elementor-pro' ),
				'label_off' => __( 'Hide', 'exclusive-addons-elementor-pro' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
        );
        
        $this->add_control(
			'exad_instagram_feed_enable_user_information',
			[
				'label' => __( 'Show User Information', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'exclusive-addons-elementor-pro' ),
				'label_off' => __( 'Hide', 'exclusive-addons-elementor-pro' ),
				'return_value' => 'yes',
                'default' => 'yes',
                'separator' => 'before'
			]
        );

        $this->add_control(
			'exad_instagram_feed_user_information_position',
			[
				'label' => __( 'User Information Position', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'user-info-bottom',
				'options' => [
					'user-info-top'  => __( 'Top', 'exclusive-addons-elementor-pro' ),
					'user-info-bottom'  => __( 'Bottom', 'exclusive-addons-elementor-pro' ),
                ],
                'condition' => [
                    'exad_instagram_feed_enable_user_information' => 'yes',
                ]
			]
        );

        $this->add_control(
			'exad_instagram_feed_enable_user_name',
			[
				'label' => __( 'Show User Name', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'exclusive-addons-elementor-pro' ),
				'label_off' => __( 'Hide', 'exclusive-addons-elementor-pro' ),
				'return_value' => 'yes',
                'default' => 'yes',
                'condition' => [
                    'exad_instagram_feed_enable_user_information' => 'yes',
                ]
			]
        );
        
        $this->add_control(
			'exad_instagram_feed_user_name',
			[
				'label' => __( 'User Name', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::TEXT,
                'default' => __( 'Exclusive Addons', 'exclusive-addons-elementor-pro' ),
                'condition' => [
                    'exad_instagram_feed_enable_user_information' => 'yes',
                    'exad_instagram_feed_enable_user_name' => 'yes'
                ]
			]
        );

        $this->add_control(
			'exad_instagram_feed_enable_user_profile_image',
			[
				'label' => __( 'Show User Profile Image', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'exclusive-addons-elementor-pro' ),
				'label_off' => __( 'Hide', 'exclusive-addons-elementor-pro' ),
				'return_value' => 'yes',
                'default' => 'yes',
                'condition' => [
                    'exad_instagram_feed_enable_user_information' => 'yes',
                ]
			]
        );
        
        $this->add_control(
			'exad_instagram_feed_user_profile_image',
			[
				'label' => __( 'User Profile Image', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::MEDIA,
				'default' => [
					'url'   => Utils::get_placeholder_image_src()
                ],
				'dynamic' => [
					'active' => true,
				],
                'condition' => [
                    'exad_instagram_feed_enable_user_information' => 'yes',
                    'exad_instagram_feed_enable_user_profile_image' => 'yes'
                ]
			]
        );

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name'      => 'instagram_image_size',
                'default'   => 'thumbnail',
				'condition' => [
                    'exad_instagram_feed_enable_user_information' => 'yes',
                    'exad_instagram_feed_enable_user_profile_image' => 'yes'
                ]
			]
		);
        
        $this->add_control(
			'exad_instagram_feed_enable_instagram_icon',
			[
				'label' => __( 'Show Instagram Icon', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'exclusive-addons-elementor-pro' ),
				'label_off' => __( 'Hide', 'exclusive-addons-elementor-pro' ),
				'return_value' => 'yes',
                'default' => 'yes',
                'condition' => [
                    'exad_instagram_feed_enable_user_information' => 'yes',
                ]
			]
        );

        $this->end_controls_section();

        /**
         * Instagram Feed Style Option
         */
        $this->start_controls_section(
            'exad_instagram_feed_style_section',
            [
                'label' => __('Container', 'exclusive-addons-elementor-pro'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'exad_instagram_feed_container_background',
				'label' => __( 'Background', 'exclusive-addons-elementor-pro' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .exad-instagram-feed',
			]
		);
        
        $this->add_responsive_control(
			'exad_instagram_feed_container_padding',
			[
				'label' => __( 'Padding', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'default' => [
                    'top' => '0',
                    'right' => '0',
                    'bottom' => '0',
                    'left' => '0',
                    'unit' => 'px',
                    'isLinked' => true,
                ],
				'selectors' => [
					'{{WRAPPER}} .exad-instagram-feed' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
        );

        $this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'exad_instagram_feed_container_border',
				'label' => __( 'Border', 'exclusive-addons-elementor-pro' ),
				'selector' => '{{WRAPPER}} .exad-instagram-feed',
			]
		);
        
        $this->add_responsive_control(
			'exad_instagram_feed_container_border_radius',
			[
				'label' => __( 'Border Radius', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'default' => [
                    'top' => '0',
                    'right' => '0',
                    'bottom' => '0',
                    'left' => '0',
                    'unit' => 'px',
                    'isLinked' => true,
                ],
				'selectors' => [
					'{{WRAPPER}} .exad-instagram-feed' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
        );
        
        $this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'exad_instagram_feed_container_shadow',
				'label' => __( 'Box Shadow', 'exclusive-addons-elementor-pro' ),
				'selector' => '{{WRAPPER}} .exad-instagram-feed',
			]
		);

        $this->end_controls_section();

        /**
         * Instagram Feed Item Option
         */
        $this->start_controls_section(
            'exad_instagram_feed_item_section',
            [
                'label' => __('Item', 'exclusive-addons-elementor-pro'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
			'exad_instagram_feed_item_gap',
			[
				'label' => __( 'Item Gap', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 50,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 20,
				],
				'selectors' => [
					'{{WRAPPER}} .exad-instagram-feed-item' => 'grid-gap: {{SIZE}}{{UNIT}};',
				],
			]
        );

        $this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'exad_instagram_feed_item_background',
				'label' => __( 'Background', 'exclusive-addons-elementor-pro' ),
				'types' => [ 'classic', 'gradient' ],
				'fields_options'  => [
					'background'  => [
						'default' => 'classic'
					],
					'color'       => [
						'default' => '#fff',
					]
				],
				'selector' => '{{WRAPPER}} .exad-instagram-feed-wrapper',
			]
		);
        
        $this->add_responsive_control(
			'exad_instagram_feed_item_padding',
			[
				'label' => __( 'Padding', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'default' => [
                    'top' => '0',
                    'right' => '0',
                    'bottom' => '0',
                    'left' => '0',
                    'unit' => 'px',
                    'isLinked' => true,
                ],
				'selectors' => [
					'{{WRAPPER}} .exad-instagram-feed-wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
        );

        $this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'exad_instagram_feed_item_border',
				'label' => __( 'Border', 'exclusive-addons-elementor-pro' ),
				'selector' => '{{WRAPPER}} .exad-instagram-feed-wrapper',
			]
		);
        
        $this->add_responsive_control(
			'exad_instagram_feed_item_border_radius',
			[
				'label' => __( 'Border Radius', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'default' => [
                    'top' => '0',
                    'right' => '0',
                    'bottom' => '0',
                    'left' => '0',
                    'unit' => 'px',
                    'isLinked' => true,
                ],
				'selectors' => [
					'{{WRAPPER}} .exad-instagram-feed-wrapper' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
        );
        
        $this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'exad_instagram_feed_item_shadow',
				'label' => __( 'Box Shadow', 'exclusive-addons-elementor-pro' ),
				'selector' => '{{WRAPPER}} .exad-instagram-feed-wrapper',
			]
		);

        $this->end_controls_section();

        /**
         * Instagram Feed Image Option
         */
        $this->start_controls_section(
            'exad_instagram_feed_image_section',
            [
                'label' => __('Image', 'exclusive-addons-elementor-pro'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
			'exad_instagram_feed_image_height',
			[
				'label' => __( 'Image Height', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 500,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 340,
				],
				'selectors' => [
					'{{WRAPPER}} .exad-instagram-feed-wrapper .exad-instagram-feed-thumb' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
        );

        $this->add_control(
			'exad_instagram_feed_image_animation',
			[
				'label' => __( 'Image Hover Animation', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'image-default',
				'options' => [
					'image-default'  => __( 'Default', 'exclusive-addons-elementor-pro' ),
					'image-zoom-in'  => __( 'Zoom In', 'exclusive-addons-elementor-pro' ),
					'image-zoom-out'  => __( 'Zoom Out', 'exclusive-addons-elementor-pro' ),
                ]
			]
        );

        $this->add_control(
			'exad_instagram_feed_enable_overlay',
			[
				'label' => __( 'Background Overlay', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'exclusive-addons-elementor-pro' ),
				'label_off' => __( 'Hide', 'exclusive-addons-elementor-pro' ),
				'return_value' => 'yes',
				'default' => 'no',
			]
        );
        
        $this->add_control(
			'exad_instagram_feed_image_overlay_color',
			[
				'label' => __( 'Overlay Color', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .exad-instagram-feed-item .exad-instagram-feed-wrapper a.exad-instagram-feed-thumb::before' => 'background: {{VALUE}}',
                ],
                'condition' => [
                    'exad_instagram_feed_enable_overlay' => 'yes'
                ]
			]
		);

        $this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'exad_instagram_feed_item_image_border',
				'label' => __( 'Border', 'exclusive-addons-elementor-pro' ),
				'selector' => '{{WRAPPER}} .exad-instagram-feed-item .exad-instagram-feed-wrapper a.exad-instagram-feed-thumb',
			]
		);
        
        $this->add_responsive_control(
			'exad_instagram_feed_item_image_border_radius',
			[
				'label' => __( 'Border Radius', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'default' => [
                    'top' => '5',
                    'right' => '5',
                    'bottom' => '5',
                    'left' => '5',
                    'unit' => 'px',
                    'isLinked' => true,
                ],
				'selectors' => [
					'{{WRAPPER}} .exad-instagram-feed-item .exad-instagram-feed-wrapper a.exad-instagram-feed-thumb' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .exad-instagram-feed-item .exad-instagram-feed-wrapper a.exad-instagram-feed-thumb::before' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
        );

        $this->end_controls_section();

        /**
         * Instagram Feed Caption Option
         */
        $this->start_controls_section(
            'exad_instagram_feed_caption_section',
            [
                'label' => __('Caption', 'exclusive-addons-elementor-pro'),
                'tab'   => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'exad_instagram_feed_enable_caption' => 'yes'
                ]
            ]
        );

        $this->add_control(
			'exad_instagram_feed_caption_alignment',
			[
				'label' => __( 'Alignment', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => __( 'Left', 'exclusive-addons-elementor-pro' ),
						'icon' => 'fa fa-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'exclusive-addons-elementor-pro' ),
						'icon' => 'fa fa-align-center',
					],
					'right' => [
						'title' => __( 'Right', 'exclusive-addons-elementor-pro' ),
						'icon' => 'fa fa-align-right',
					],
                ],
                'selectors' => [
					'{{WRAPPER}} .exad-instagram-feed-item .exad-instagram-feed-wrapper .exad-instagram-feed-caption' => 'text-align: {{VALUE}}',
                ],
				'default' => 'left',
                'toggle' => true,
                'condition' => [
                    'exad_instagram_feed_caption_position!' => 'over-image'
                ]
			]
		);

        $this->add_control(
			'exad_instagram_feed_caption_position',
			[
				'label' => __( 'Caption Position', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'top-of-image',
				'options' => [
					'top-of-image'  => __( 'Top of Image', 'exclusive-addons-elementor-pro' ),
					'bottom-of-image'  => __( 'Bottom of Image', 'exclusive-addons-elementor-pro' ),
					'over-image'  => __( 'Over Image', 'exclusive-addons-elementor-pro' ),
				],
			]
        );

        $this->add_control(
			'exad_instagram_feed_show_caption_on_hover',
			[
				'label' => __( 'Show Caption on Hover', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'exclusive-addons-elementor-pro' ),
				'label_off' => __( 'Hide', 'exclusive-addons-elementor-pro' ),
				'return_value' => 'yes',
				'default' => 'no',
			]
        );

        $this->add_control(
			'exad_instagram_feed_caption_animation',
			[
				'label' => __( 'Caption Hover Animation', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'animate-default',
				'options' => [
					'animate-default'  => __( 'Default', 'exclusive-addons-elementor-pro' ),
					'animate-slide-with-image'  => __( 'Slide with Image', 'exclusive-addons-elementor-pro' ),
					'animate-slide'  => __( 'Slide', 'exclusive-addons-elementor-pro' ),
                ],
                'condition' => [
                    'exad_instagram_feed_show_caption_on_hover' => 'yes'
                ]
			]
        );

        $this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'exad_instagram_feed_caption_background',
				'label' => __( 'Background', 'exclusive-addons-elementor-pro' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .exad-instagram-feed-caption',
			]
		);

        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'exad_instagram_feed_caption_typography',
				'label' => __( 'Typography', 'exclusive-addons-elementor-pro' ),
				'selector' => '{{WRAPPER}} .exad-instagram-feed-item .exad-instagram-feed-wrapper .exad-instagram-feed-caption',
			]
        );
        
        $this->add_control(
			'exad_instagram_feed_caption_text_color',
			[
				'label' => __( 'Text Color', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .exad-instagram-feed-item .exad-instagram-feed-wrapper .exad-instagram-feed-caption' => 'color: {{VALUE}}',
                ]
			]
		);

        $this->add_responsive_control(
			'exad_instagram_feed_caption_margin',
			[
				'label' => __( 'Margin', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'default' => [
                    'top' => '0',
                    'right' => '0',
                    'bottom' => '0',
                    'left' => '0',
                    'unit' => 'px',
                    'isLinked' => true,
                ],
				'selectors' => [
					'{{WRAPPER}} .exad-instagram-feed-item .exad-instagram-feed-wrapper .exad-instagram-feed-caption' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
        );

        $this->add_responsive_control(
			'exad_instagram_feed_caption_padding',
			[
				'label' => __( 'padding', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'default' => [
                    'top' => '10',
                    'right' => '0',
                    'bottom' => '10',
                    'left' => '10',
                    'unit' => 'px',
                    'isLinked' => true,
                ],
				'selectors' => [
					'{{WRAPPER}} .exad-instagram-feed-item .exad-instagram-feed-wrapper .exad-instagram-feed-caption' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
        );

        $this->end_controls_section();

        /**
         * Instagram Feed User Information Option
         */
        $this->start_controls_section(
            'exad_instagram_feed_user_section',
            [
                'label' => __('User Information', 'exclusive-addons-elementor-pro'),
                'tab'   => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'exad_instagram_feed_enable_user_information' => 'yes'
                ]
            ]
        );

        $this->add_responsive_control(
			'exad_instagram_feed_user_padding',
			[
				'label' => __( 'padding', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'default' => [
                    'top' => '10',
                    'right' => '10',
                    'bottom' => '10',
                    'left' => '10',
                    'unit' => 'px',
                    'isLinked' => true,
                ],
				'selectors' => [
					'{{WRAPPER}} .exad-instagram-feed-item .exad-instagram-feed-wrapper .exad-instagram-feed-user-info' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
        );

        $this->add_responsive_control(
			'exad_instagram_feed_user_margin',
			[
				'label' => __( 'Margin', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'default' => [
                    'top' => '',
                    'right' => '',
                    'bottom' => '',
                    'left' => '',
                    'unit' => 'px',
                    'isLinked' => true,
                ],
				'selectors' => [
					'{{WRAPPER}} .exad-instagram-feed-item .exad-instagram-feed-wrapper .exad-instagram-feed-user-info' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
        );

        $this->add_control(
			'exad_instagram_feed_user_profile_image_heading',
			[
				'label' => __( 'Profile Image', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
        );
        
        $this->add_responsive_control(
			'exad_instagram_feed_user_profile_image_height',
			[
				'label' => __( 'Image Height', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 200,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 70,
				],
				'selectors' => [
					'{{WRAPPER}} .exad-instagram-feed-wrapper .exad-instagram-user-profile-image' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
        );

        $this->add_responsive_control(
			'exad_instagram_feed_user_profile_image_width',
			[
				'label' => __( 'Image Width', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 200,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 70,
				],
				'selectors' => [
					'{{WRAPPER}} .exad-instagram-feed-wrapper .exad-instagram-user-profile-image' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
        );

        $this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'exad_instagram_feed_user_profile_image_border',
				'label' => __( 'Border', 'exclusive-addons-elementor-pro' ),
				'selector' => '{{WRAPPER}} .exad-instagram-feed-wrapper .exad-instagram-user-profile-image',
			]
        );
        
        $this->add_responsive_control(
			'exad_instagram_feed_user_profile_image_radius',
			[
				'label' => __( 'Border Radius', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'default' => [
                    'top' => '100',
                    'right' => '100',
                    'bottom' => '100',
                    'left' => '100',
                    'unit' => 'px',
                    'isLinked' => true,
                ],
				'selectors' => [
					'{{WRAPPER}} .exad-instagram-feed-wrapper .exad-instagram-user-profile-image' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
        );

        $this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'exad_instagram_feed_user_profile_image_shadow',
				'label' => __( 'Box Shadow', 'exclusive-addons-elementor-pro' ),
				'selector' => '{{WRAPPER}} .exad-instagram-feed-wrapper .exad-instagram-user-profile-image',
			]
        );
        
        $this->add_control(
			'exad_instagram_feed_user_name_heading',
			[
				'label' => __( 'User Name', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
        );

        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'exad_instagram_feed_user_name_typography',
				'label' => __( 'Typography', 'exclusive-addons-elementor-pro' ),
				'selector' => '{{WRAPPER}} .exad-instagram-feed-wrapper .exad-instagram-user-profile-name',
			]
        );

        $this->add_responsive_control(
			'exad_instagram_feed_user_name_margin',
			[
				'label' => __( 'Margin', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'default' => [
                    'top' => '0',
                    'right' => '0',
                    'bottom' => '0',
                    'left' => '20',
                    'unit' => 'px',
                    'isLinked' => true,
                ],
				'selectors' => [
					'{{WRAPPER}} .exad-instagram-feed-wrapper .exad-instagram-user-profile-name' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
        );

        $this->start_controls_tabs( 'exad_instagram_feed_user_name_tabs' );

			// normal state rating
            $this->start_controls_tab( 'exad_instagram_feed_user_name_normal', [ 'label' => esc_html__( 'Normal', 'exclusive-addons-elementor-pro' ) ] );
            
                $this->add_control(
                    'exad_instagram_feed_user_name_normal_text_color',
                    [
                        'label' => __( 'Text Color', 'exclusive-addons-elementor-pro' ),
						'type' => Controls_Manager::COLOR,
						'default' => '#000000',
                        'selectors' => [
                            '{{WRAPPER}} .exad-instagram-feed-wrapper .exad-instagram-user-profile-name' => 'color: {{VALUE}}',
                        ]
                    ]
                );

			$this->end_controls_tab();

			// hover state rating
            $this->start_controls_tab( 'exad_instagram_feed_user_name_hover', [ 'label' => esc_html__( 'Hover', 'exclusive-addons-elementor-pro' ) ] );
            
                $this->add_control(
                    'exad_instagram_feed_user_name_hover_text_color',
                    [
                        'label' => __( 'Text Color', 'exclusive-addons-elementor-pro' ),
						'type' => Controls_Manager::COLOR,
						'default' => $exad_primary_color,
                        'selectors' => [
                            '{{WRAPPER}} .exad-instagram-feed-wrapper .exad-instagram-user-profile:hover .exad-instagram-user-profile-name' => 'color: {{VALUE}}',
                        ]
                    ]
                );

			$this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_control(
			'exad_instagram_feed_instagram_icon',
			[
				'label' => __( 'Instagram Icon', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
        );

        $this->add_responsive_control(
			'exad_instagram_feed_instagram_icon_size',
			[
				'label' => __( 'Instagram Icon Size', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 50,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 20,
				],
				'selectors' => [
					'{{WRAPPER}} .exad-instagram-feed-icon' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
        );

        $this->add_control(
			'exad_instagram_feed_instagram_icon_color',
			[
				'label' => __( 'Icon Color', 'exclusive-addons-elementor-pro' ),
                'type' => Controls_Manager::COLOR,
                'default' => '#e4405f',
				'selectors' => [
					'{{WRAPPER}} .exad-instagram-feed-icon' => 'color: {{VALUE}}',
                ]
			]
		);

        $this->end_controls_section();
    
    }

    protected function render() {
        $settings                  = $this->get_settings_for_display();
        $this->add_render_attribute( 'exad_instagram_feed_item', [
            'class' => [ 
                'exad-instagram-feed-item',
                $settings['exad_instagram_feed_column_number'],
                $settings['exad_instagram_feed_caption_position']
            ]
        ]);
        if('yes' === $settings['exad_instagram_feed_show_caption_on_hover']){
            $this->add_render_attribute( 'exad_instagram_feed_item', [
                'class' => [ 
                    'exad-insta-feed-show-caption-'.$settings['exad_instagram_feed_show_caption_on_hover'],
                    $settings['exad_instagram_feed_caption_animation']
                ]
            ]);
        }
        ?>
        <div class="exad-instagram-feed">
            <div <?php echo $this->get_render_attribute_string( 'exad_instagram_feed_item' ); ?>
                id='exad-instagram-feed-<?php echo( $this->get_id() ) ?>'
                data-access_token='<?php echo esc_attr( $settings['exad_instagram_feed_access_token'] ); ?>'
                data-target='exad-instagram-feed-<?php echo( $this->get_id() ) ?>'
                data-limit='<?php echo $settings['exad_instagram_feed_photos_number'] ?>'
                data-template='
                <div class="exad-instagram-feed-wrapper">
                    <?php if( 'yes' === $settings['exad_instagram_feed_enable_user_information'] ) { ?>
                        <?php if( 'user-info-top' === $settings['exad_instagram_feed_user_information_position'] ) { ?>
                            <div class="exad-instagram-feed-user-info">
                                <a href="{{link}}" target="_blank" class="exad-instagram-user-profile">
                                    <?php if( 'yes' === $settings['exad_instagram_feed_enable_user_profile_image'] ) { ?>
                                        <div class="exad-instagram-user-profile-image">
											<?php echo Group_Control_Image_Size::get_attachment_image_html( $settings, 'instagram_image_size', 'exad_instagram_feed_user_profile_image' ); ?>
                                        </div>
                                    <?php } ?>
                                    <?php if( 'yes' === $settings['exad_instagram_feed_enable_user_name'] ) { ?>
                                        <p class="exad-instagram-user-profile-name"><?php echo esc_html($settings['exad_instagram_feed_user_name']); ?></p>
                                    <?php } ?>
                                </a>
                                <?php if( 'yes' === $settings['exad_instagram_feed_enable_instagram_icon'] ) { ?>
                                    <span class="exad-instagram-feed-icon"><i class="fa fa-instagram"></i></span>
                                <?php } ?>
                            </div>
                        <?php } ?>
                    <?php } ?>
                    <?php if( 'top-of-image' === $settings['exad_instagram_feed_caption_position'] || 'over-image' === $settings['exad_instagram_feed_caption_position'] ) { ?>
                        <?php if( 'yes' === $settings['exad_instagram_feed_enable_caption'] ) { ?>
                            <p class="exad-instagram-feed-caption">{{caption}}</p>
                        <?php } ?>
                    <?php } ?>
                    <a class="exad-instagram-feed-thumb <?php echo $settings['exad_instagram_feed_image_animation'] ?>" href="{{link}}" target="_blank">
                        <img src="{{image}}" alt="{{caption}}"/>
                    </a>
                    <?php if( 'bottom-of-image' === $settings['exad_instagram_feed_caption_position']) { ?>
                        <?php if( 'yes' === $settings['exad_instagram_feed_enable_caption'] ) { ?>
                            <p class="exad-instagram-feed-caption">{{caption}}</p>
                        <?php } ?>
                    <?php } ?>
                    <?php if( 'yes' === $settings['exad_instagram_feed_enable_user_information'] ) { ?>
                        <?php if( 'user-info-bottom' === $settings['exad_instagram_feed_user_information_position'] ) { ?>
                            <div class="exad-instagram-feed-user-info">
                                <a href="{{link}}" target="_blank" class="exad-instagram-user-profile">
                                    <?php if( 'yes' === $settings['exad_instagram_feed_enable_user_profile_image'] ) { ?>
                                        <div class="exad-instagram-user-profile-image">
											<?php echo Group_Control_Image_Size::get_attachment_image_html( $settings, 'instagram_image_size', 'exad_instagram_feed_user_profile_image' ); ?>
                                        </div>
                                    <?php } ?>
                                    <?php if( 'yes' === $settings['exad_instagram_feed_enable_user_name'] ) { ?>
                                        <p class="exad-instagram-user-profile-name"><?php echo esc_html($settings['exad_instagram_feed_user_name']); ?></p>
                                    <?php } ?>
                                </a>
                                <?php if( 'yes' === $settings['exad_instagram_feed_enable_instagram_icon'] ) { ?>
                                    <span class="exad-instagram-feed-icon"><i class="fa fa-instagram"></i></span>
                                <?php } ?>
                            </div>
                        <?php } ?>
                    <?php } ?>
                </div>'
            >
            </div>
        </div>

        <?php
    }
}
