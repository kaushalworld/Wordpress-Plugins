<?php
namespace ExclusiveAddons\Elements;

if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.

use \Elementor\Controls_Manager;
use \Elementor\Repeater;
use \Elementor\Group_Control_Box_Shadow;
use \Elementor\Group_Control_Image_Size;
use \Elementor\Control_Media;
use \Elementor\Icons_Manager;
use \Elementor\Group_Control_Typography;
use \Elementor\Utils;
use \Elementor\Widget_Base;
use \Elementor\Group_Control_Border;

class Image_Hotspot extends Widget_Base {

    public function get_name() {
        return 'exad-image-hotspot';
    }

    public function get_title() {
        return __('Image Hotspot', 'exclusive-addons-elementor-pro');
    }

    public function get_categories() {
        return ['exclusive-addons-elementor'];
    }

    public function get_icon() {
        return 'exad exad-logo exad-image-hotspot';
    }

    public function get_keywords() {
        return [ 'tooltip', 'spot' ];
    }

    protected function register_controls() {

        $this->start_controls_section(
            'section_hotspots',
            [
                'label' => __('Hotspots', 'exclusive-addons-elementor-pro')
            ]
        );

        $this->add_control(
            'exad_hotspot_style',
            [
                'label'    => __('Style', 'exclusive-addons-elementor-pro'),
                'type'     => Controls_Manager::SELECT,
                'default'  => 'default',
                'options'  => [
                    'default' => __('Default', 'exclusive-addons-elementor-pro'),
                    'style-1' => __('Style 1', 'exclusive-addons-elementor-pro'),
                    'style-2' => __('Style 2', 'exclusive-addons-elementor-pro')
                ]
            ]
        );

        $repeater = new Repeater();

        $repeater->start_controls_tabs( 'hot_spots_tabs' );

        $repeater->start_controls_tab('tab_tooltip', ['label' => __('Content', 'exclusive-addons-elementor-pro')]);

        $repeater->add_control(
            'exad_tooltip',
            [
                'label'        => __('Enable', 'exclusive-addons-elementor-pro'),
                'type'         => Controls_Manager::SWITCHER,
                'default'      => 'yes',
                'label_on'     => __('On', 'exclusive-addons-elementor-pro'),
                'label_off'    => __('Off', 'exclusive-addons-elementor-pro'),
                'return_value' => 'yes'
            ]
        );

        $repeater->add_control(
            'exad_tooltip_content_image',
            [
                'label'   => __('Image', 'exclusive-addons-elementor-pro'),
                'type'    => Controls_Manager::MEDIA,
                'default' => [
                    'url' => Utils::get_placeholder_image_src()
                ],
                'dynamic' => [
					'active' => true,
				]
            ]
        );

        $repeater->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
                'name'    => 'exad_tooltip_content_image_size',
                'default' => 'full',
                'condition' => [
                    'exad_tooltip_content_image[url]!' => ''
                ]
            ]
        );

        $repeater->add_control(
            'exad_tooltip_content_heading',
            [
                'label'     => __('Tooltip Heading', 'exclusive-addons-elementor-pro'),
                'type'      => Controls_Manager::TEXT,
                'default'   => __('Tooltip Content', 'exclusive-addons-elementor-pro'),
                'condition' => [
                    'exad_tooltip' => 'yes'
                ]
            ]
        );

        $repeater->add_control(
            'exad_tooltip_content_subheading',
            [
                'label'     => __('Tooltip Subheading', 'exclusive-addons-elementor-pro'),
                'type'      => Controls_Manager::TEXTAREA,
                'condition' => [
                    'exad_tooltip' => 'yes'
                ]
            ]
        );

        $repeater->add_control(
            'exad_tooltip_content_button',
            [
                'label'     => __('Tooltip Button Text', 'exclusive-addons-elementor-pro'),
                'type'      => Controls_Manager::TEXT,
                'condition' => [
                    'exad_tooltip' => 'yes'
                ]
            ]
        );

        $repeater->add_control(
			'exad_tooltip_content_button_url',
			[
				'label' => __( 'Tooltip Button URL', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::URL,
				'placeholder' => __( 'https://your-link.com', 'exclusive-addons-elementor-pro' ),
				'show_external' => true,
				'default' => [
					'url' => '',
					'is_external' => true,
					'nofollow' => true,
				],
			]
		);

        $repeater->end_controls_tab();

        $repeater->start_controls_tab( 'tab_position', [ 'label' => __( 'Position', 'exclusive-addons-elementor-pro' ) ] );

        $repeater->add_responsive_control(
            'exad_tooltip_left_position',
            [
                'label'          => __('Left Position(%)', 'exclusive-addons-elementor-pro'),
                'type'           => Controls_Manager::SLIDER,
                'size_units'     => [ '%' ],
                'range'          => [
                    'px'         => [
                        'min'    => 0,
                        'max'    => 100,
                        'step'   => 1
                    ]
                ],
                'default'        => [
                    'unit'       => '%',
                    'size'       => '50'
                ],
                'tablet_default' => [
                    'unit'       => '%'
                ],
                'mobile_default' => [
                    'unit'       => '%'
                ],
                'selectors'      => [
                    '{{WRAPPER}} .exad-hotspot-item{{CURRENT_ITEM}} .exad-hotspot-dot' => 'left: {{SIZE}}%;'
                ]
            ]
        );

        $repeater->add_responsive_control(
            'exad_toolip_top_position',
            [
                'label'          => __('Top Position(%)', 'exclusive-addons-elementor-pro'),
                'type'           => Controls_Manager::SLIDER,
                'size_units'     => [ '%' ],
                'range'          => [
                    'px'         => [
                        'min'    => 0,
                        'max'    => 100,
                        'step'   => 1
                    ]
                ],
                'default'        => [
                    'unit'       => '%',
                    'size'       => '50'
                ],
                'tablet_default' => [
                    'unit'       => '%'
                ],
                'mobile_default' => [
                    'unit'       => '%'
                ],
                'selectors'      => [
                    '{{WRAPPER}} .exad-hotspot-item{{CURRENT_ITEM}} .exad-hotspot-dot' => 'top: {{SIZE}}%;'
                ]
            ]
        );

        $repeater->add_control(
            'exad_toolip_z_index',
            [
                'label'          => __('Custom Z Index', 'exclusive-addons-elementor-pro'),
                'type'           => Controls_Manager::SLIDER,
                'size_units'     => [ 'px' ],
                'range'          => [
                    'px'         => [
                        'min'    => 0,
                        'max'    => 1000,
                        'step'   => 1
                    ]
                ],
                'selectors'      => [
                    '{{WRAPPER}} .exad-hotspot-item{{CURRENT_ITEM}} .exad-hotspot-dot' => 'z-index: {{SIZE}};'
                ]
            ]
        );

        $repeater->end_controls_tab();

        $repeater->start_controls_tab( 'tab_content', [ 'label' => __( 'Type', 'exclusive-addons-elementor-pro' ) ] );

        $repeater->add_control(
            'exad_hotspot_type',
            [
                'label'    => __('Type', 'exclusive-addons-elementor-pro'),
                'type'     => Controls_Manager::SELECT,
                'default'  => 'icon',
                'options'  => [
                    'icon' => __('Icon', 'exclusive-addons-elementor-pro'),
                    'text' => __('Text', 'exclusive-addons-elementor-pro')
                ]
            ]
        );

        $repeater->add_control(
            'exad_hotspot_icon',
            [
                'label'       => __('Icon', 'exclusive-addons-elementor-pro'),
                'type'        => Controls_Manager::ICONS,
                'default'     => [
                    'value'   => 'fas fa-plus',
                    'library' => 'fa-solid'
                ],
                'condition'   => [
                    'exad_hotspot_type' => 'icon'
                ]
            ]
        );

        $repeater->add_control(
            'exad_hotspot_text',
            [
                'label'       => __('Text', 'exclusive-addons-elementor-pro'),
                'type'        => Controls_Manager::TEXT,
                'label_block' => true,
                'default'     => __('Hi', 'exclusive-addons-elementor-pro'),
                'condition'   => [
                    'exad_hotspot_type' => 'text'
                ]
            ]
        );

        $repeater->end_controls_tab();

        $repeater->start_controls_tab( 'style_content', [ 'label' => __( 'Style', 'exclusive-addons-elementor-pro' ) ] );

        $repeater->add_control(
			'exad_hotspot_custom_style',
			[
				'label' => __( 'Custom Style?', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'exclusive-addons-elementor-pro' ),
				'label_off' => __( 'Hide', 'exclusive-addons-elementor-pro' ),
				'return_value' => 'yes',
				'default' => 'no',
			]
        );
        
        $repeater->add_control(
		    'exad_hotspot_custom_style_hotspot_background',
		    [
		        'label'     => __( 'Hotspot Background Color', 'exclusive-addons-elementor-pro' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .exad-hotspot-item{{CURRENT_ITEM}} .exad-hotspot-dot .exad-hotspot-dot-icon' => 'background: {{VALUE}};',
                    '{{WRAPPER}} .exad-hotspot.exad-hotspot-glow-animation .exad-hotspot-item{{CURRENT_ITEM}} .exad-hotspot-dot::before' => 'background: {{VALUE}}',
                    '{{WRAPPER}} .exad-hotspot.exad-hotspot-glowing-border .exad-hotspot-item{{CURRENT_ITEM}} .exad-hotspot-dot-icon::before' => 'border: .5px solid {{VALUE}}',
                    '{{WRAPPER}} .exad-hotspot.exad-hotspot-glowing-border .exad-hotspot-item{{CURRENT_ITEM}} .exad-hotspot-dot-icon::after'  => 'border: 1px solid {{VALUE}}'
		        ],
                'condition' => [
                    'exad_hotspot_custom_style' => 'yes'
                ]
		    ]
        );
        $repeater->add_control(
		    'exad_hotspot_custom_style_hotspot_color',
		    [
		        'label'     => __( 'Hotspot Icon/Text Color', 'exclusive-addons-elementor-pro' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
		            '{{WRAPPER}} .exad-hotspot-item{{CURRENT_ITEM}} .exad-hotspot-dot .exad-hotspot-dot-icon i' => 'color: {{VALUE}};',
		            '{{WRAPPER}} .exad-hotspot-item{{CURRENT_ITEM}} .exad-hotspot-dot .exad-hotspot-dot-icon span' => 'color: {{VALUE}};',
		            '{{WRAPPER}} .exad-hotspot-item{{CURRENT_ITEM}} .exad-hotspot-dot .exad-hotspot-dot-icon svg path' => 'fill: {{VALUE}};'
		        ],
                'condition' => [
                    'exad_hotspot_custom_style' => 'yes'
                ]
		    ]
        );

        $repeater->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'exad_hotspot_custom_style_hotspot_border',
				'label' => __( 'Border', 'exclusive-addons-elementor-pro' ),
                'selector' => '{{WRAPPER}} .exad-hotspot-item{{CURRENT_ITEM}} .exad-hotspot-dot .exad-hotspot-dot-icon',
                'condition' => [
                    'exad_hotspot_custom_style' => 'yes'
                ]
			]
        );
        
        $repeater->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
                'name'     => 'exad_hotspot_custom_style_hotspot_box_shadow',
                'selector' => '{{WRAPPER}} .exad-hotspot-item{{CURRENT_ITEM}} .exad-hotspot-dot .exad-hotspot-dot-icon',
                'condition' => [
                    'exad_hotspot_custom_style' => 'yes'
                ]
			]
        );
        
        $repeater->end_controls_tab();

        $repeater->end_controls_tabs();

        $this->add_control(
            'exad_hotspots',
            [
                'label'       => '',
                'type'        => Controls_Manager::REPEATER,
                'fields'      => $repeater->get_controls(),
                'default'     => [
                    [
                        'exad_tooltip_content_heading'       => __('Tooltip #1', 'exclusive-addons-elementor-pro'),
                        'exad_hotspot_icon'          =>[
                            'value'                  => 'far fa-dot-circle',
                            'library'                => 'fa-regular'
                        ],
                        'exad_tooltip_left_position' => [
                            'unit'                   => '%',
                            'size'                   => '40'
                        ],
                        'exad_toolip_top_position'   => [
                            'unit'                   => '%',
                            'size'                   => '50'
                        ]
                    ],
                    [
                        'exad_tooltip_content_heading'       => __('Tooltip #2', 'exclusive-addons-elementor-pro'),
                        'exad_hotspot_icon'          =>[
                            'value'                  => 'fas fa-crown',
                            'library'                => 'fa-solid'
                        ],
                        'exad_tooltip_left_position' => [
                            'unit'                   => '%',
                            'size'                   => '60'
                        ],
                        'exad_toolip_top_position'   => [
                            'unit'                   => '%',
                            'size'                   => '50'
                        ]
                    ]
                ],
                'title_field' => '{{{ exad_tooltip_content_heading }}}'
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'exad_hotspot_background_content',
            [
                'label' => __('Background', 'exclusive-addons-elementor-pro')
            ]
        );

        $this->add_control(
			'exad_hotspot_background_type',
			[
				'label' => __( 'Background Type', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'image',
				'options' => [
					'image'  => __( 'Image', 'exclusive-addons-elementor-pro' ),
					'colored' => __( 'Colored', 'exclusive-addons-elementor-pro' ),
				],
			]
		);

        $this->add_control(
            'exad_hotspot_image',
            [
                'label'   => __('Image', 'exclusive-addons-elementor-pro'),
                'type'    => Controls_Manager::MEDIA,
                'default' => [
                    'url' => Utils::get_placeholder_image_src()
                ],
                'dynamic' => [
					'active' => true,
				],
                'condition' => [
                    'exad_hotspot_background_type' => 'image'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
                'name'    => 'exad_hotspot_image_size',
                'default' => 'full',
                'condition' => [
                    'exad_hotspot_background_type' => 'image'
                ]
            ]
        );

        $this->end_controls_section();

        /**
         * Style Tab: Settings
         */

        $this->start_controls_section(
            'exad_hotspot_settings',
            [
                'label' => __('Settings', 'exclusive-addons-elementor-pro')
            ]
        );

        $this->add_control(
            'exad_tooltip_indicator',
            [
                'label'        => __('Enable Tooltip Indicator', 'exclusive-addons-elementor-pro'),
                'type'         => Controls_Manager::SWITCHER,
                'default'      => 'yes',
                'label_on'     => __('On', 'exclusive-addons-elementor-pro'),
                'label_off'    => __('Off', 'exclusive-addons-elementor-pro'),
                'return_value' => 'yes',
                'condition'    => [
                    'exad_hotspot_style!' => 'style-1'
                ]
            ]
        );

        $this->add_control(
            'exad_hotspot_tooltip_on',
            [
                'label'    => __('Show Hotspot Tooltip On', 'exclusive-addons-elementor-pro'),
                'type'     => Controls_Manager::SELECT,
                'default'  => 'tooltip-on-hover',
                'options'  => [
                    'tooltip-on-hover' => __('Hover', 'exclusive-addons-elementor-pro'),
                    'tooltip-on-click' => __('Click', 'exclusive-addons-elementor-pro'),
                ]
            ]
        );

        $this->end_controls_section();

        /*-----------------------------------------------------------------------------------*/
        /*	STYLE TAB
        /*-----------------------------------------------------------------------------------*/
        /**
         * Style Tab: Image
         */
        $this->start_controls_section(
            'exad_image_hotspot_image_style',
            [
                'label' => __('Image/Colored Background', 'exclusive-addons-elementor-pro'),
                'tab'   => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_control(
            'exad_image_hotspot_background_Color',
            [
                'label'     => __('Background Color', 'exclusive-addons-elementor-pro'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#222222',
                'selectors' => [
                    '{{WRAPPER}} .exad-hotspot .exad-hotspot-image' => 'background: {{VALUE}}'
                ],
                'condition' => [
                    'exad_hotspot_background_type' => 'colored'
                ]
            ]
        );

        $this->add_control(
            'exad_image_hotspot_image_overlay',
            [
                'label'        => __('Overlay', 'exclusive-addons-elementor-pro'),
                'type'         => Controls_Manager::SWITCHER,
                'default'      => 'no',
                'label_on'     => __('On', 'exclusive-addons-elementor-pro'),
                'label_off'    => __('Off', 'exclusive-addons-elementor-pro'),
                'return_value' => 'yes',
                'condition' => [
                    'exad_hotspot_background_type' => 'image'
                ]
            ]
        );

        $this->add_control(
            'exad_image_hotspot_image_overlay_color',
            [
                'label'     => __('Image Overlay Color', 'exclusive-addons-elementor-pro'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .exad-hotspot .exad-hotspot-image::before' => 'background: {{VALUE}}'
                ],
                'condition' => [
                    'exad_image_hotspot_image_overlay' => 'yes',
                    'exad_hotspot_background_type' => 'image'
                ]
            ]
        );

        $this->add_responsive_control(
            'exad_image_hotspot_image_height',
            [
                'label'        => __('Image Height/Background Height', 'exclusive-addons-elementor-pro'),
                'type'         => Controls_Manager::SLIDER,
                'range'        => [
                    'px'       => [
                        'min'  => 0,
                        'max'  => 1500,
                    ]
                ],
                'default'      => [
                    'size'     => '500'
                ],
                'size_units'   => ['px'],
                'selectors'    => [
                    '{{WRAPPER}} .exad-hotspot .exad-hotspot-image' => 'height: {{SIZE}}{{UNIT}};'
                ]
            ]
        );

        $this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'exad_image_hotspot_image_border',
				'label' => __( 'Border', 'exclusive-addons-elementor-pro' ),
				'selector' => '{{WRAPPER}} .exad-hotspot .exad-hotspot-image',
			]
		);

        $this->add_responsive_control(
			'exad_image_hotspot_image_border_radius',
			[
				'label'      => __( 'Border Radius', 'exclusive-addons-elementor-pro' ),
				'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'default'    => [
                    'top'    => '0',
                    'right'  => '0',
                    'bottom' => '0',
                    'left'   => '0',
                    'unit'   => 'px'
                ],
				'selectors'  => [
					'{{WRAPPER}} .exad-hotspot .exad-hotspot-image' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
        );

        $this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
                'name'     => 'exad_image_hotspot_image_shadow',
                'selector' => '{{WRAPPER}} .exad-hotspot .exad-hotspot-image'
			]
        );

        $this->end_controls_section();

        /*-----------------------------------------------------------------------------------*/
        /*	STYLE TAB
        /*-----------------------------------------------------------------------------------*/
        /**
         * Style Tab: Hotspot
         */
        $this->start_controls_section(
            'section_hotspots_style',
            [
                'label' => __('Hotspot', 'exclusive-addons-elementor-pro'),
                'tab'   => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_responsive_control(
            'hotspot_icon_size',
            [
                'label'        => __('Size', 'exclusive-addons-elementor-pro'),
                'type'         => Controls_Manager::SLIDER,
                'default'      => [
                    'size'     => '14'
                ],
                'range'        => [
                    'px'       => [
                        'min'  => 6,
                        'max'  => 40,
                        'step' => 1
                    ]
                ],
                'size_units'   => ['px'],
                'selectors'    => [
                    '{{WRAPPER}} .exad-hotspot-item .exad-hotspot-dot .exad-hotspot-dot-icon i,
                    {{WRAPPER}} .exad-hotspot-item .exad-hotspot-dot .exad-hotspot-dot-icon span' => 'font-size: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .exad-hotspot-item .exad-hotspot-dot .exad-hotspot-dot-icon svg' => 'height: {{SIZE}}px; width: {{SIZE}}px;'
                ]
            ]
        );

        $this->add_responsive_control(
            'exad_hotspot_height',
            [
                'label'          => __('Height', 'exclusive-addons-elementor-pro'),
                'type'           => Controls_Manager::SLIDER,
                'size_units'     => [ 'px' ],
                'range'          => [
					'px'         => [
						'min'    => 0,
						'max'    => 500
					]
				],
				'default'        => [
					'unit'       => 'px',
					'size'       => 50
				],
                'mobile_default' => [
                    'unit'       => 'px',
                    'size'       => 40
                ],
                'selectors'      => [
                    '{{WRAPPER}} .exad-hotspot .exad-hotspot-item .exad-hotspot-dot-icon' => 'height: {{SIZE}}{{UNIT}}'
                ]
            ]
        );

        $this->add_responsive_control(
            'exad_hotspot_width',
            [
                'label'          => __('Width', 'exclusive-addons-elementor-pro'),
                'type'           => Controls_Manager::SLIDER,
                'size_units'     => [ 'px' ],
                'range'          => [
					'px'         => [
						'min'    => 0,
						'max'    => 500
					]
				],
				'default'        => [
					'unit'       => 'px',
					'size'       => 50
				],
                'mobile_default' => [
                    'unit'       => 'px',
                    'size'       => 40
                ],
                'selectors'      => [
                    '{{WRAPPER}} .exad-hotspot .exad-hotspot-item .exad-hotspot-dot-icon' => 'width: {{SIZE}}{{UNIT}};'
                ]
            ]
        );

        $this->add_control(
            'exad_hotspot_color_normal',
            [
                'label'     => __('Color', 'exclusive-addons-elementor-pro'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#FFF',
                'selectors' => [
                    '{{WRAPPER}} .exad-hotspot .exad-hotspot-item .exad-hotspot-dot-icon i, 
                    {{WRAPPER}} .exad-hotspot .exad-hotspot-item .exad-hotspot-dot-icon span' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .exad-hotspot .exad-hotspot-item .exad-hotspot-dot-icon svg path' => 'fill: {{VALUE}}'
                ]
            ]
        );

        $this->add_control(
            'exad_hotspot_bg_color_normal',
            [
                'label'     => __('Background Color', 'exclusive-addons-elementor-pro'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#7a56ff',
                'selectors' => [
                    '{{WRAPPER}} .exad-hotspot .exad-hotspot-dot-icon'                                     => 'background: {{VALUE}}',
                    '{{WRAPPER}} .exad-hotspot.exad-hotspot-glow-animation .exad-hotspot-item .exad-hotspot-dot::before' => 'background: {{VALUE}}',
                    '{{WRAPPER}} .exad-hotspot.exad-hotspot-glowing-border .exad-hotspot-dot-icon::before' => 'border: .5px solid {{VALUE}}',
                    '{{WRAPPER}} .exad-hotspot.exad-hotspot-glowing-border .exad-hotspot-dot-icon::after'  => 'border: 1px solid {{VALUE}}',
                    '{{WRAPPER}} .exad-hotspot.exad-hotspot-slack-animation .exad-hotspot-item .exad-hotspot-dot::before'  => 'border: 4px solid {{VALUE}}'
                ]
            ]
        );

        $this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'exad_hotspot_border_normal',
				'label' => __( 'Border', 'exclusive-addons-elementor-pro' ),
				'selector' => '{{WRAPPER}} .exad-hotspot .exad-hotspot-item .exad-hotspot-dot-icon',
			]
		);

        $this->add_responsive_control(
			'exad_hotspot_border_radius',
			[
				'label'      => __( 'Border Radius', 'exclusive-addons-elementor-pro' ),
				'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'separator'  => 'before',
                'default'    => [
                    'top'    => '50',
                    'right'  => '50',
                    'bottom' => '50',
                    'left'   => '50',
                    'unit'   => '%'
                ],
				'selectors'  => [
					'{{WRAPPER}} .exad-hotspot .exad-hotspot-item .exad-hotspot-dot-icon' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .exad-hotspot.exad-hotspot-glow-animation .exad-hotspot-item .exad-hotspot-dot::before' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .exad-hotspot.exad-hotspot-glowing-border .exad-hotspot-dot-icon::before' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .exad-hotspot.exad-hotspot-glowing-border .exad-hotspot-dot-icon::after' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .exad-hotspot.exad-hotspot-slack-animation .exad-hotspot-item .exad-hotspot-dot::before' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .exad-hotspot.exad-hotspot-egg-animation .exad-hotspot-item .exad-hotspot-dot::before' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
        );

        $this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
                'name'     => 'exad_hotspot_box_shadow',
                'selector' => '{{WRAPPER}} .exad-hotspot .exad-hotspot-item .exad-hotspot-dot-icon'
			]
        );

        $this->add_control(
			'exad_hotspot_animation_type',
			[
                'label'   => __( 'Animation Type', 'exclusive-addons-elementor-pro' ),
                'type'    => Controls_Manager::SELECT,
                'default' => 'none',
                'options' => [
                    'none'                          => 'None',
                    'exad-hotspot-moving-animation' => 'Moving Animation',
                    'exad-hotspot-glow-animation'   => 'Glowing Animation',
                    'exad-hotspot-glowing-border'   => 'Glowing Border',
                    'exad-hotspot-hover-scale'      => 'Hover Scale',
                    'exad-hotspot-slack-animation'  => 'Slack Animation',
                    'exad-hotspot-egg-animation'    => 'Egg Animation',
                ]
			]
        );

        $this->add_responsive_control(
            'icon_padding',
            [
                'label'      => __('Padding', 'exclusive-addons-elementor-pro'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .exad-hotspot .exad-hotspot-dot-icon' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->end_controls_section();

        /**
         * Style Tab: Tooltip
         */
        $this->start_controls_section(
            'section_tooltips_style',
            [
                'label' => __('Tooltip', 'exclusive-addons-elementor-pro'),
                'tab'   => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_responsive_control(
			'exad_hotspot_tooltips_content_padding',
			[
				'label'      => __( 'Padding', 'exclusive-addons-elementor-pro' ),
				'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'default'    => [
                    'top'    => '10',
                    'right'  => '10',
                    'bottom' => '10',
                    'left'   => '10',
                    'unit'   => 'px'
                ],
				'selectors'  => [
					'{{WRAPPER}} .exad-hotspot .exad-hotspot-item .exad-hotspot-tooltip .exad-hotspot-tooltip-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
        );

        $this->add_control(
            'exad_hotspot_tooltip_bg_color',
            [
                'label'     => __('Background Color', 'exclusive-addons-elementor-pro'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .exad-hotspot-item .exad-hotspot-dot .exad-hotspot-tooltip .exad-hotspot-tooltip-content'         => 'background: {{VALUE}}',
                    '{{WRAPPER}} .exad-hotspot-item .exad-hotspot-dot .exad-hotspot-tooltip::before' => 'border-color: {{VALUE}} transparent transparent transparent;',
                    '{{WRAPPER}} .exad-hotspot.style-2.exad-hotspot-tooltip-indicator-yes .exad-hotspot-item .exad-hotspot-tooltip::before' => 'border-color: transparent {{VALUE}} transparent transparent;'
                ]
            ]
        );

        $this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'exad_hotspot_tooltip_border',
				'label' => __( 'Border', 'exclusive-addons-elementor-pro' ),
				'selector' => '{{WRAPPER}} .exad-hotspot-item .exad-hotspot-tooltip .exad-hotspot-tooltip-content',
			]
		);

        $this->add_responsive_control(
			'exad_hotspot_tooltip_border_radius',
			[
				'label'      => __( 'Border Radius', 'exclusive-addons-elementor-pro' ),
				'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'default'    => [
                    'top'    => '0',
                    'right'  => '0',
                    'bottom' => '0',
                    'left'   => '0',
                    'unit'   => 'px'
                ],
				'selectors'  => [
					'{{WRAPPER}} .exad-hotspot-item .exad-hotspot-tooltip .exad-hotspot-tooltip-content' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
        );

        $this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
                'name'     => 'exad_hotspot_tooltip_shadow',
                'selector' => '{{WRAPPER}} .exad-hotspot-item .exad-hotspot-tooltip .exad-hotspot-tooltip-content'
			]
        );

        $this->add_responsive_control(
            'exad_hotspot_tooltip_text_distance',
            [
                'label'          => __('Distance', 'exclusive-addons-elementor-pro'),
                'type'           => Controls_Manager::SLIDER,
                'size_units'     => [ 'px' ],
                'range'          => [
					'px'         => [
						'min'    => 0,
						'max'    => 400
					]
				],
				'default'        => [
					'unit'       => 'px',
					'size'       => 65
				],
                'mobile_default' => [
                    'size'       => '47'
                ],
                'selectors'      => [
                    '{{WRAPPER}} .exad-hotspot-tooltip' => 'bottom: {{SIZE}}{{UNIT}}',
                    '{{WRAPPER}} .exad-hotspot.style-2 .exad-hotspot-item .exad-hotspot-tooltip' => 'left: {{SIZE}}{{UNIT}}'
                ]
            ]
        );

        $this->add_responsive_control(
            'exad_tooltip_width',
            [
                'label'        => __('Width', 'exclusive-addons-elementor-pro'),
                'type'         => Controls_Manager::SLIDER,
                'range'        => [
                    'px'       => [
                        'min'  => 50,
                        'max'  => 500,
                        'step' => 1
                    ]
                ],
                'size_units'   => ['px'],
                'selectors'    => [
                    '{{WRAPPER}} .exad-hotspot-item .exad-hotspot-dot .exad-hotspot-tooltip .exad-hotspot-tooltip-content' => 'width: {{SIZE}}{{UNIT}}'
                ]
            ]
        );

        $this->end_controls_section();

        /**
         * Style Tab: Tooltip Content
         */
        $this->start_controls_section(
            'exad_hotspot_tooltips_content_style',
            [
                'label' => __('Tooltip Content', 'exclusive-addons-elementor-pro'),
                'tab'   => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_control(
			'exad_hotspot_tooltips_content_align',
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
				'default' => 'center',
                'toggle' => true,
                'selectors' => [
                    '{{WRAPPER}} .exad-hotspot-item .exad-hotspot-tooltip .exad-hotspot-tooltip-content' => 'text-align: {{VALUE}}'
                ]
			]
		);

        $this->add_control(
			'exad_hotspot_tooltips_content_heading',
			[
				'label' => __( 'Heading', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::HEADING,
			]
        );
        
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'exad_hotspot_tooltips_content_heading_typography',
                'selector' => '{{WRAPPER}} .exad-hotspot-item .exad-hotspot-tooltip .exad-hotspot-tooltip-content .exad-hotspot-tooltip-content-heading'
            ]
        );

        $this->add_control(
            'exad_hotspot_tooltips_content_heading_color',
            [
                'label'     => __('Text Color', 'exclusive-addons-elementor-pro'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#222222',
                'selectors' => [
                    '{{WRAPPER}} .exad-hotspot-item .exad-hotspot-tooltip .exad-hotspot-tooltip-content .exad-hotspot-tooltip-content-heading' => 'color: {{VALUE}}'
                ]
            ]
        );

        $this->add_responsive_control(
			'exad_hotspot_tooltips_content_heading_margin',
			[
				'label'      => __( 'Margin', 'exclusive-addons-elementor-pro' ),
				'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'default'    => [
                    'top'    => '0',
                    'right'  => '0',
                    'bottom' => '10',
                    'left'   => '0',
                    'unit'   => 'px'
                ],
				'selectors'  => [
					'{{WRAPPER}} .exad-hotspot-item .exad-hotspot-tooltip .exad-hotspot-tooltip-content .exad-hotspot-tooltip-content-heading' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
        );

        $this->add_control(
			'exad_hotspot_tooltips_content_sub_heading',
			[
				'label' => __( 'Sub Heading', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
        );
        
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'exad_hotspot_tooltips_content_sub_heading_typography',
                'selector' => '{{WRAPPER}} .exad-hotspot-item .exad-hotspot-tooltip .exad-hotspot-tooltip-content .exad-hotspot-tooltip-content-subheading'
            ]
        );

        $this->add_control(
            'exad_hotspot_tooltips_content_sub_heading_color',
            [
                'label'     => __('Text Color', 'exclusive-addons-elementor-pro'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#222222',
                'selectors' => [
                    '{{WRAPPER}} .exad-hotspot-item .exad-hotspot-tooltip .exad-hotspot-tooltip-content .exad-hotspot-tooltip-content-subheading' => 'color: {{VALUE}}'
                ]
            ]
        );

        $this->add_responsive_control(
			'exad_hotspot_tooltips_content_sub_heading_margin',
			[
				'label'      => __( 'Margin', 'exclusive-addons-elementor-pro' ),
				'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'default'    => [
                    'top'    => '0',
                    'right'  => '0',
                    'bottom' => '10',
                    'left'   => '0',
                    'unit'   => 'px'
                ],
				'selectors'  => [
					'{{WRAPPER}} .exad-hotspot-item .exad-hotspot-tooltip .exad-hotspot-tooltip-content .exad-hotspot-tooltip-content-subheading' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
        );

        $this->add_control(
			'exad_hotspot_tooltips_content_button_heading',
			[
				'label' => __( 'Button', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
        );

        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'exad_hotspot_tooltips_content_button_typography',
				'label' => __( 'Typography', 'exclusive-addons-elementor-pro' ),
				'selector' => '{{WRAPPER}} .exad-hotspot-item .exad-hotspot-tooltip .exad-hotspot-tooltip-content .exad-hotspot-tooltip-content-button',
			]
        );

        $this->add_responsive_control(
            'exad_hotspot_tooltips_content_button_padding',
            [
                'label'      => __( 'Padding', 'exclusive-addons-elementor-pro' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'default'    => [
                    'top'      => '10',
                    'right'    => '20',
                    'bottom'   => '10',
                    'left'     => '20',
                    'unit'     => 'px',
                    'isLinked' => false,
                ],
                'selectors'  => [
                    '{{WRAPPER}} .exad-hotspot-tooltip-content .exad-hotspot-tooltip-content-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'exad_hotspot_tooltips_content_button_radius',
            [
                'label'      => __( 'Border Radius', 'exclusive-addons-elementor-pro' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'default'    => [
                    'top'      => '0',
                    'right'    => '0',
                    'bottom'   => '0',
                    'left'     => '0',
                    'unit'     => 'px',
                    'isLinked' => true,
                ],
                'selectors'  => [
                    '{{WRAPPER}} .exad-hotspot-tooltip-content .exad-hotspot-tooltip-content-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs('exad_hotspot_tooltips_content_button_tabs');

            // Normal item
            $this->start_controls_tab('exad_hotspot_tooltips_content_button_normal', ['label' => esc_html__('Normal', 'exclusive-addons-elementor-pro')]);

                $this->add_control(
                    'exad_hotspot_tooltips_content_button_normal_background',
                    [
                        'label'     => esc_html__('Backgroun Color', 'exclusive-addons-elementor-pro'),
                        'type'      => Controls_Manager::COLOR,
                        'default'   => '#000000',
                        'selectors' => [
                            '{{WRAPPER}} .exad-hotspot-tooltip-content .exad-hotspot-tooltip-content-button' => 'Background: {{VALUE}};'
                        ]
                    ]
                );

                $this->add_control(
                    'exad_hotspot_tooltips_content_button_normal_color',
                    [
                        'label'     => esc_html__('Text Color', 'exclusive-addons-elementor-pro'),
                        'type'      => Controls_Manager::COLOR,
                        'default'   => '#ffffff',
                        'selectors' => [
                            '{{WRAPPER}} .exad-hotspot-tooltip-content .exad-hotspot-tooltip-content-button' => 'color: {{VALUE}};'
                        ]
                    ]
                );

                $this->add_group_control(
                    Group_Control_Border::get_type(),
                    [
                        'name' => 'exad_hotspot_tooltips_content_button_normal_border',
                        'label' => __( 'Border', 'exclusive-addons-elementor-pro' ),
                        'selector' => '{{WRAPPER}} .exad-hotspot-tooltip-content .exad-hotspot-tooltip-content-button',
                    ]
                );

                $this->add_group_control(
                    Group_Control_Box_Shadow::get_type(),
                    [
                        'name' => 'exad_hotspot_tooltips_content_button_box_shadow',
                        'label' => __( 'Box Shadow', 'exclusive-addons-elementor-pro' ),
                        'selector' => '{{WRAPPER}} .exad-hotspot-tooltip-content .exad-hotspot-tooltip-content-button',
                    ]
                );

            $this->end_controls_tab();

            // Hover item
            $this->start_controls_tab('exad_hotspot_tooltips_content_button_hover', ['label' => esc_html__('Hover', 'exclusive-addons-elementor-pro')]);

                $this->add_control(
                    'exad_hotspot_tooltips_content_button_hover_background',
                    [
                        'label'     => esc_html__('Backgroun Color', 'exclusive-addons-elementor-pro'),
                        'type'      => Controls_Manager::COLOR,
                        'default'   => '#ffffff',
                        'selectors' => [
                            '{{WRAPPER}} .exad-hotspot-tooltip-content .exad-hotspot-tooltip-content-button:hover' => 'Background: {{VALUE}};'
                        ]
                    ]
                );

                $this->add_control(
                    'exad_hotspot_tooltips_content_button_hover_color',
                    [
                        'label'     => esc_html__('Text Color', 'exclusive-addons-elementor-pro'),
                        'type'      => Controls_Manager::COLOR,
                        'default'   => '#000000',
                        'selectors' => [
                            '{{WRAPPER}} .exad-hotspot-tooltip-content .exad-hotspot-tooltip-content-button:hover' => 'color: {{VALUE}};'
                        ]
                    ]
                );

                $this->add_group_control(
                    Group_Control_Border::get_type(),
                    [
                        'name' => 'exad_hotspot_tooltips_content_button_hover_border',
                        'label' => __( 'Border', 'exclusive-addons-elementor-pro' ),
                        'selector' => '{{WRAPPER}} .exad-hotspot-tooltip-content .exad-hotspot-tooltip-content-button:hover',
                    ]
                );

                $this->add_group_control(
                    Group_Control_Box_Shadow::get_type(),
                    [
                        'name' => 'exad_hotspot_tooltips_content_button_hover_box_shadow',
                        'label' => __( 'Box Shadow', 'exclusive-addons-elementor-pro' ),
                        'selector' => '{{WRAPPER}} .exad-hotspot-tooltip-content .exad-hotspot-tooltip-content-button:hover',
                    ]
                );
                
            $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_control(
			'exad_hotspot_tooltips_content_image_heading',
			[
				'label' => __( 'Image', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::HEADING,
			]
        );

        $this->add_responsive_control(
            'exad_hotspot_tooltips_content_image_height',
            [
                'label'          => __('Image Height', 'exclusive-addons-elementor-pro'),
                'type'           => Controls_Manager::SLIDER,
                'size_units'     => [ 'px' ],
                'range'          => [
					'px'         => [
						'min'    => 0,
						'max'    => 300
					]
				],
				'default'        => [
					'unit'       => 'px',
					'size'       => 150
				],
                'selectors'      => [
                    '{{WRAPPER}} .exad-hotspot .exad-hotspot-item .exad-hotspot-tooltip-content .exad-hotspot-tooltip-content-image' => 'height: {{SIZE}}{{UNIT}};'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'exad_hotspot_tooltips_content_image_border',
                'label' => __( 'Border', 'exclusive-addons-elementor-pro' ),
                'selector' => '{{WRAPPER}} .exad-hotspot .exad-hotspot-item .exad-hotspot-tooltip-content .exad-hotspot-tooltip-content-image',
            ]
        );

        $this->add_responsive_control(
            'exad_hotspot_tooltips_content_image_radius',
            [
                'label'      => __( 'Border Radius', 'exclusive-addons-elementor-pro' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'default'    => [
                    'top'      => '0',
                    'right'    => '0',
                    'bottom'   => '0',
                    'left'     => '0',
                    'unit'     => 'px',
                    'isLinked' => true,
                ],
                'selectors'  => [
                    '{{WRAPPER}} .exad-hotspot .exad-hotspot-item .exad-hotspot-tooltip-content .exad-hotspot-tooltip-content-image' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'exad_hotspot_tooltips_content_image_shadow',
                'label' => __( 'Box Shadow', 'exclusive-addons-elementor-pro' ),
                'selector' => '{{WRAPPER}} .exad-hotspot .exad-hotspot-item .exad-hotspot-tooltip-content .exad-hotspot-tooltip-content-image',
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings          = $this->get_settings();

        $this->add_render_attribute( 'exad_hotspot_classes', [
			'class'              => ['exad-hotspot', esc_attr( $settings['exad_hotspot_animation_type'] ), $settings['exad_hotspot_style'], $settings['exad_hotspot_tooltip_on'], 'exad-hotspot-tooltip-indicator-'.$settings['exad_tooltip_indicator'] ],
			'data-style'              => $settings['exad_hotspot_style'],
			'data-tooltip_on'              => $settings['exad_hotspot_tooltip_on'],
		] );

        $this->add_render_attribute( 'exad_hotspot_dot', 'class', 'exad-hotspot-dot' );
        ?>
        <div <?php echo $this->get_render_attribute_string( 'exad_hotspot_classes' ); ?>>
            <?php if( 'image' === $settings['exad_hotspot_background_type'] ) { ?>
                <div class="exad-hotspot-image">
                    <?php if ( ! empty( $settings['exad_hotspot_image']['url'] ) ) : ?>
                        <?php echo Group_Control_Image_Size::get_attachment_image_html( $settings, 'exad_hotspot_image_size', 'exad_hotspot_image' ); ?>
                   <?php endif; ?>
                </div>
            <?php }
            if( 'colored' === $settings['exad_hotspot_background_type'] ) { ?>
                <div class="exad-hotspot-image">
                </div>
            <?php }
            
            if( is_array( $settings['exad_hotspots'] ) ):
                foreach( $settings['exad_hotspots'] as $index => $item ) :

                    $hotspot_text = $this->get_repeater_setting_key( 'exad_hotspot_text', 'exad_hotspots', $index );
                    $this->add_inline_editing_attributes( $hotspot_text, 'none' );

                    $tooltip_content = $this->get_repeater_setting_key( 'exad_tooltip_content', 'exad_hotspots', $index );
                    $this->add_inline_editing_attributes( $tooltip_content, 'basic' );

                    $target = $item['exad_tooltip_content_button_url']['is_external'] ? ' target="_blank"' : '';
		            $nofollow = $item['exad_tooltip_content_button_url']['nofollow'] ? ' rel="nofollow"' : '';
                    ?>
                    <div class="exad-hotspot-item elementor-repeater-item-<?php echo esc_attr( $item['_id'] ); ?>">
                        <div <?php echo $this->get_render_attribute_string( 'exad_hotspot_dot' ); ?>>
                            <?php if ( 'icon' === $item['exad_hotspot_type'] ) { ?>
                                <div class="exad-hotspot-dot-icon">
                                    <?php if( ! empty( $item['exad_hotspot_icon']['value'] ) ){
                                        Icons_Manager::render_icon( $item['exad_hotspot_icon'], [ 'aria-hidden' => 'true' ] );
                                    }; ?>
                                </div>
                            <?php }
                            if ( 'text' === $item['exad_hotspot_type'] ) { ?>
                                <div class="exad-hotspot-dot-icon">
                                    <?php if( ! empty( $item['exad_hotspot_text'] ) ){ ?>
                                        <span <?php echo $this->get_render_attribute_string( $hotspot_text ); ?>><?php echo esc_html( $item['exad_hotspot_text'] ); ?></span>
                                    <?php }; ?>
                                </div>
                            <?php }
                            if ( 'yes' === $item['exad_tooltip'] ) { ?>
                                <div class="exad-hotspot-tooltip">
                                    <div class="exad-hotspot-tooltip-content"<?php echo $this->get_render_attribute_string( $tooltip_content ); ?>>
                                        <?php if ( ! empty( $item['exad_tooltip_content_image']['url'] ) ) : ?>
                                            <div class="exad-hotspot-tooltip-content-image">
                                                <?php echo Group_Control_Image_Size::get_attachment_image_html( $item, 'exad_tooltip_content_image_size', 'exad_tooltip_content_image'); ?>
                                            </div>
                                        <?php endif;
                                        if( ! empty( $item['exad_tooltip_content_heading'] ) ){ ?>
                                            <h6 class="exad-hotspot-tooltip-content-heading"><?php echo esc_html( $item['exad_tooltip_content_heading'] ); ?></h6>
                                        <?php }
                                        if( ! empty( $item['exad_tooltip_content_subheading'] ) ){ ?>
                                            <p class="exad-hotspot-tooltip-content-subheading"><?php echo esc_html( $item['exad_tooltip_content_subheading'] ); ?></p>
                                        <?php }
                                        if( ! empty( $item['exad_tooltip_content_button'] ) ){ ?>
                                            <a href="<?php echo esc_url( $item['exad_tooltip_content_button_url']['url'] ); ?>" <?php echo esc_attr( $target ); ?> <?php echo esc_attr( $nofollow ); ?> class="exad-hotspot-tooltip-content-button"><?php echo esc_html( $item['exad_tooltip_content_button'] ); ?></a>
                                        <?php }; ?>
                                    </div>
                                </div>
                            <?php }; ?>
                        </div>
                    </div>
                <?php endforeach;
            endif; ?>
        </div>
    <?php
    }

}
