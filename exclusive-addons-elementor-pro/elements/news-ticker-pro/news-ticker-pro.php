<?php
namespace ExclusiveAddons\Elements;

if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.

use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Border;
use \Elementor\Group_Control_Box_Shadow;
use \Elementor\Group_Control_Background;
use \Elementor\Group_Control_Typography;
use \ExclusiveAddons\Pro\Elementor\ProHelper;
use \Elementor\Repeater;
use \Elementor\Icons_Manager;
use \Elementor\Widget_Base;

class News_Ticker_Pro extends Widget_Base {

    public function get_name() {
        return 'exad-news-ticker-pro';
    }

    public function get_title() {
        return __( 'News Ticker PRO', 'exclusive-addons-elementor-pro' );
    }

    public function get_icon() {
        return 'exad exad-logo exad-news-ticker';
    }

    public function get_categories() {
        return [ 'exclusive-addons-elementor' ];
    }

    public function get_keywords() {
        return [ 'news', 'ticker', 'bar', 'horizontal', 'post items', 'scrolling' ];
    }
    
    public function get_script_depends() {
        return [ 'exad-news-ticker' ];
    }

    protected function register_controls() {

        $this->start_controls_section(
            'exad_news_ticker_all_items',
            [
                'label' => __( 'Items', 'exclusive-addons-elementor-pro' )
            ]
        );

        $this->add_control(
            'exad_news_ticker_label',
            [   
                'label'         => __( 'Label', 'exclusive-addons-elementor-pro' ),
                'type'          => Controls_Manager::TEXT,
                'default'       => __( 'Today\'s Hot News', 'exclusive-addons-elementor-pro' )
            ]
        ); 

        $this->add_control(
            'exad_news_ticker_post_types',
            [
                'label'    => __( 'Post Type', 'exclusive-addons-elementor-pro' ),
                'type'     => Controls_Manager::SELECT,
                'default'  => 'post',
                'options'  => ProHelper::exad_get_all_post_type_options()
            ]
        );

        $this->add_control(
            'exad_news_ticker_order_by',
            [
                'type'    => Controls_Manager::SELECT,
                'label'   => __( 'Order by', 'exclusive-addons-elementor-pro' ),
                'default' => 'date',
                'options' => [
                    'none'          => __( 'No order', 'exclusive-addons-elementor-pro' ),
                    'ID'            => __( 'Post ID', 'exclusive-addons-elementor-pro' ),
                    'author'        => __( 'Author', 'exclusive-addons-elementor-pro' ),
                    'title'         => __( 'Title', 'exclusive-addons-elementor-pro' ),
                    'date'          => __( 'Published date', 'exclusive-addons-elementor-pro' ),
                    'modified'      => __( 'Modified date', 'exclusive-addons-elementor-pro' ),
                    'parent'        => __( 'By parent', 'exclusive-addons-elementor-pro' ),
                    'rand'          => __( 'Random order', 'exclusive-addons-elementor-pro' ),
                    'comment_count' => __( 'Comment count', 'exclusive-addons-elementor-pro' ),
                    'menu_order'    => __( 'Menu order', 'exclusive-addons-elementor-pro' ),
                    'post__in'      => __( 'By include order', 'exclusive-addons-elementor-pro' )
                ]
            ]
        );

        $this->add_control(
            'exad_news_ticker_order',
            [
                'type'          => Controls_Manager::SELECT,
                'label'         => __( 'Order', 'exclusive-addons-elementor-pro' ),
                'default'       => 'DESC',
                'options'       => [
                    'ASC'       => __( 'Ascending', 'exclusive-addons-elementor-pro' ),
                    'DESC'      => __( 'Descending', 'exclusive-addons-elementor-pro' )
                ]
            ]
        );

        $this->add_control(
            'exad_news_ticker_number_of_items_to_show',
            [
                'label'         => __('Number of items to show', 'exclusive-addons-elementor-pro'),
                'type'          => Controls_Manager::NUMBER,
                'default'       => 15
            ]
        );  

        $this->add_control(
            'exad_news_ticker_include_specific_items_by_ids',
            [
                'label'         => __( 'Include', 'exclusive-addons-elementor-pro' ),
                'description'   => __('Provide a comma separated list of Post IDs to display spacific post.', 'exclusive-addons-elementor-pro' ),
                'type'          => Controls_Manager::TEXT,
                'label_block'   => true
            ]
        );

        $this->add_control(
            'exad_news_ticker_exclude_specific_items_by_ids',
            [   
                'label'         => __( 'Exclude', 'exclusive-addons-elementor-pro' ),
                'type'          => Controls_Manager::TEXT,
                'description'   => __('Provide a comma separated list of Post IDs to exclude specific post.', 'exclusive-addons-elementor-pro' ),
                'label_block'   => true
            ]
        );

        $news_ticker_repeater = new Repeater();
        
        $news_ticker_repeater->add_control(
            'exad_news_ticker_title',
            [
                'label'   => __( 'Content', 'exclusive-addons-elementor-pro' ),
                'type'    => Controls_Manager::TEXTAREA,
                'default' => __( 'News item description', 'exclusive-addons-elementor-pro' )
            ]
        );

        $news_ticker_repeater->add_control(
            'exad_news_ticker_link',
            [
                'label'           => __( 'Link', 'exclusive-addons-elementor-pro' ),
                'type'            => Controls_Manager::URL,
                'label_block'     => true,
                'default'         => [
                    'url'         => '#',
                    'is_external' => ''
                ],
                'show_external'   => true
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'exad_news_ticker_settings',
            [
                'label' => __( 'Settings', 'exclusive-addons-elementor-pro' )
            ]
        ); 

        $this->add_control(
            'exad_news_ticker_animation_direction',
            [
                'label'     => __( 'Direction', 'exclusive-addons-elementor-pro' ),
                'type'      => Controls_Manager::SELECT,
                'default'   => 'ltr',
                'options'   => [
                    'ltr'   => __( 'Left to Right', 'exclusive-addons-elementor-pro' ),
                    'rtl'   => __( 'Right to Left', 'exclusive-addons-elementor-pro' )
                ],
                'description'   => __('If you enable Right-to-left(RTL) in your website than by default it will be working in RTL and this option won\'t work.', 'exclusive-addons-elementor-pro')

            ]
        ); 

        $this->add_control(
            'exad_news_ticker_set_fixed_position',
            [
                'type'        => Controls_Manager::SELECT,
                'label'       => __( 'Set Position', 'exclusive-addons-elementor-pro' ),
                'default'     => 'none',
                'description' => __('Stick the news ticker to the top or bottom of the page.', 'exclusive-addons-elementor-pro'),
                'options'     => [
                    'none'         => __( 'None', 'exclusive-addons-elementor-pro' ),
                    'fixed-top'    => __( 'Fixed Top', 'exclusive-addons-elementor-pro' ),
                    'fixed-bottom' => __( 'Fixed Bottom', 'exclusive-addons-elementor-pro' )
				]
            ]
        );

        $this->add_control(
            'exad_news_ticker_animation_type',
            [
                'label'     => __( 'Animation Type', 'exclusive-addons-elementor-pro' ),
                'type'      => Controls_Manager::SELECT,
                'default'   => 'scroll',
                'options'   => [
                    'scroll'      => __( 'Scroll', 'exclusive-addons-elementor-pro' ),
                    'slide'       => __( 'Slide', 'exclusive-addons-elementor-pro' ),
                    'fade'        => __( 'Fade', 'exclusive-addons-elementor-pro' ),
                    'slide-up'    => __( 'Slide Up', 'exclusive-addons-elementor-pro' ),
                    'slide-down'  => __( 'Slide Down', 'exclusive-addons-elementor-pro' ),
                    'slide-left'  => __( 'Slide Left', 'exclusive-addons-elementor-pro' ),
                    'slide-right' => __( 'Slide Right', 'exclusive-addons-elementor-pro' ),
                    'typography'  => __( 'Typography', 'exclusive-addons-elementor-pro' )
                ]               
            ]
        );  

        $this->add_control(
            'exad_news_ticker_autoplay_interval',
            [   
                'label'         => __( 'Autoplay Interval', 'exclusive-addons-elementor-pro' ),
                'type'          => Controls_Manager::NUMBER,
                'default'       => '4000',
                'condition'     => [
                    '.exad_news_ticker_animation_type!' => 'scroll'
                ]              
            ]
        ); 

        $this->add_control(
            'exad_news_ticker_animation_speed',
            [   
                'label'         => __( 'Animation Speed', 'exclusive-addons-elementor-pro' ),
                'type'          => Controls_Manager::NUMBER,
                'default'       => '2',
                'condition'     => [
                    '.exad_news_ticker_animation_type' => 'scroll'
                ]                
            ]
        ); 

        $this->add_responsive_control(
            'exad_news_ticker_height',
            [   
                'label'         => __( 'Height', 'exclusive-addons-elementor-pro' ),
                'type'          => Controls_Manager::SLIDER,
                'default'       => [
                    'size'      => 70
                ],
                'range'         => [
                    'px'        => [
                        'min'   => 20,
                        'max'   => 100
                    ]
                ]
            ]
        ); 

        $this->add_control(
            'exad_news_ticker_autoplay',
            [
                'type'         => Controls_Manager::SWITCHER,
                'label'        => __( 'Autoplay', 'exclusive-addons-elementor-pro' ),
                'label_on'     => __( 'On', 'exclusive-addons-elementor-pro' ),
                'label_off'    => __( 'Off', 'exclusive-addons-elementor-pro' ),
                'default'      => 'yes',
                'return_value' => 'yes'
            ]
        );        

        $this->add_control(
            'exad_news_ticker_pause_on_hover',
            [
                'type'         => Controls_Manager::SWITCHER,
                'label'        => __( 'Pause On Hover', 'exclusive-addons-elementor-pro' ),
                'label_on'     => __( 'On', 'exclusive-addons-elementor-pro' ),
                'label_off'    => __( 'Off', 'exclusive-addons-elementor-pro' ),
                'default'      => 'yes',
                'return_value' => 'yes',
                'condition'    => [
                    '.exad_news_ticker_autoplay' => 'yes'
                ]                
            ]
        );

        $this->add_control(
            'exad_news_ticker_show_label',
            [
                'type'         => Controls_Manager::SWITCHER,
                'label'        => __( 'Enable Label', 'exclusive-addons-elementor-pro' ),
                'label_on'     => __( 'On', 'exclusive-addons-elementor-pro' ),
                'label_off'    => __( 'Off', 'exclusive-addons-elementor-pro' ),
                'default'      => 'yes',
                'return_value' => 'yes'
            ]
        );

        $this->add_control(
            'exad_news_ticker_show_label_arrow',
            [
                'type'         => Controls_Manager::SWITCHER,
                'label'        => __( 'Enable Label Arrow', 'exclusive-addons-elementor-pro' ),
                'label_on'     => __( 'On', 'exclusive-addons-elementor-pro' ),
                'label_off'    => __( 'Off', 'exclusive-addons-elementor-pro' ),
                'default'      => 'no',
                'return_value' => 'yes',
                'condition'    => [
                    'exad_news_ticker_show_label' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'exad_news_ticker_show_label_icon',
            [
                'type'         => Controls_Manager::SWITCHER,
                'label'        => __( 'Enable Label Icon', 'exclusive-addons-elementor-pro' ),
                'label_on'     => __( 'On', 'exclusive-addons-elementor-pro' ),
                'label_off'    => __( 'Off', 'exclusive-addons-elementor-pro' ),
                'default'      => 'no',
                'return_value' => 'yes',
                'condition'    => [
                    'exad_news_ticker_show_label' => 'yes'
                ]
            ]
        ); 

        $this->add_control(
            'exad_news_ticker_show_controls',
            [
                'type'         => Controls_Manager::SWITCHER,
                'label'        => __( 'Controls', 'exclusive-addons-elementor-pro' ),
                'label_on'     => __( 'On', 'exclusive-addons-elementor-pro' ),
                'label_off'    => __( 'Off', 'exclusive-addons-elementor-pro' ),
                'default'      => 'yes',
                'return_value' => 'yes'
            ]
        );  

        $this->add_control(
            'exad_news_ticker_show_pause_control',
            [
                'type'         => Controls_Manager::SWITCHER,
                'label'        => __( 'Play/Pause Control', 'exclusive-addons-elementor-pro' ),
                'label_on'     => __( 'On', 'exclusive-addons-elementor-pro' ),
                'label_off'    => __( 'Off', 'exclusive-addons-elementor-pro' ),
                'default'      => 'yes',
                'return_value' => 'yes',
                'condition'    => [
                    'exad_news_ticker_show_controls' => 'yes'
                ]
            ]
        );         

        $this->add_control(
            'exad_news_ticker_label_icon',
            [
                'label'       => __( 'Label Icon', 'exclusive-addons-elementor-pro' ),
                'type'        => Controls_Manager::ICONS,
                'default'     => [
                    'value'   => 'fas fa-home',
                    'library' => 'fa-solid'
                ],
                'condition'   => [
                    'exad_news_ticker_show_label'      => 'yes',
                    'exad_news_ticker_show_label_icon' => 'yes'
                ]
            ]
        ); 

        $this->end_controls_section();

        $this->start_controls_section(
            'exad_news_ticker_container_style',
            [
                'label'         => __( 'Container', 'exclusive-addons-elementor-pro' ),
                'tab'           => Controls_Manager::TAB_STYLE                    
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'      => 'exad_news_ticker_container_bg_color',
                'types'     => [ 'classic', 'gradient' ],
                'selector'  => '{{WRAPPER}} .exad-news-ticker'            
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'           => 'exad_news_ticker_container_border',
                'selector'       => '{{WRAPPER}} .exad-news-ticker',
                'fields_options' => [
                    'border'      => [
                        'default' => 'solid'
                    ],
                    'width'       => [
                        'default' => [
                            'top'    => '1',
                            'right'  => '1',
                            'bottom' => '1',
                            'left'   => '1'
                        ]
                    ],
                    'color'       => [
                        'default' => '#DADCEA'
                    ]
                ]
            ]
        );

        $this->add_responsive_control(
            'exad_news_ticker_container_border_radius',
            [
                'label'      => __( 'Border Radius', 'exclusive-addons-elementor-pro' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px'],
                'selectors'  => [
                    '{{WRAPPER}} .exad-news-ticker'=> 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'exad_news_ticker_container_box_shadow',
                'selector' => '{{WRAPPER}} .exad-news-ticker'
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'exad_news_ticker_label_style',
            [
                'label'     => __( 'Label', 'exclusive-addons-elementor-pro' ),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [
                    '.exad_news_ticker_show_label' => 'yes'
                ]             
            ]
        ); 

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'exad_news_ticker_label_typography',
                'selector' => '{{WRAPPER}} .exad-news-ticker .exad-bn-label'
            ]
        );

        $this->add_control(
            'exad_news_ticker_label_color',
            [
                'label'     => __( 'Text Color', 'exclusive-addons-elementor-pro' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#000000',
                'selectors' => [
                    '{{WRAPPER}} .exad-news-ticker .exad-bn-label' => 'color: {{VALUE}};'
                ]              
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'      => 'exad_news_ticker_label_bg_color',
                'types'     => [ 'classic', 'gradient' ],
                'selector'  => '{{WRAPPER}} .exad-news-ticker .exad-bn-label, {{WRAPPER}} .exad-news-ticker .exad-bn-label.yes-small:after'            
            ]
        );

        $this->add_responsive_control(
            'exad_news_ticker_label_padding',
            [
                'label'         => __( 'Padding(Left & Right)', 'exclusive-addons-elementor-pro' ),
                'type'          => Controls_Manager::SLIDER,
                'size_units'    => [ 'px' ],
                'default'       => [
                    'size'      => 15
                ],
                'selectors'     => [
                    '{{WRAPPER}} .exad-news-ticker .exad-bn-label' => 'padding: 0 {{SIZE}}{{UNIT}};'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'           => 'exad_news_ticker_label_border',
                'selector'       => '{{WRAPPER}} .exad-news-ticker .exad-bn-label',
                'fields_options' => [
                    'border'      => [
                        'default' => 'solid'
                    ],
                    'width'       => [
                        'default' => [
                            'top'    => '0',
                            'right'  => '1',
                            'bottom' => '0',
                            'left'   => '0'
                        ]
                    ],
                    'color'       => [
                        'default' => '#DADCEA'
                    ]
                ]
            ]
        );

        $this->add_responsive_control(
            'exad_news_ticker_label_border_radius',
            [
                'label'      => __( 'Border Radius', 'exclusive-addons-elementor-pro' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px'],
                'selectors'  => [
                    '{{WRAPPER}} .exad-news-ticker .exad-bn-label'=> 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->add_control(
            'exad_news_ticker_label_icon_style',
            [
                'label'     => __( 'Label Icon', 'exclusive-addons-elementor-pro' ),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
                'condition' => [
                    'exad_news_ticker_show_label_icon'    => 'yes',
                    'exad_news_ticker_label_icon[value]!' => ''
                ]
            ]
        );

        $this->add_responsive_control(
            'exad_news_ticker_label_icon_size',
            [
                'label'        => __( 'Size', 'exclusive-addons-elementor-pro' ),
                'type'         => Controls_Manager::SLIDER,
                'range'        => [
                    'px'       => [
                        'min'  => 10,
                        'max'  => 50,
                        'step' => 2
                    ]
                ],
                'selectors'    => [
                    '{{WRAPPER}} .exad-news-ticker-icon i' => 'font-size: {{SIZE}}px;'
                ],
                'condition'    => [
                    'exad_news_ticker_show_label_icon'    => 'yes',
                    'exad_news_ticker_label_icon[value]!' => ''
                ]
            ]
        );

        $this->add_control(
            'exad_news_ticker_label_icon_color',
            [
                'label'     => __( 'Color', 'exclusive-addons-elementor-pro' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .exad-news-ticker-icon i' => 'color: {{VALUE}};'
                ],
                'condition' => [
                    'exad_news_ticker_show_label_icon'    => 'yes',
                    'exad_news_ticker_label_icon[value]!' => ''
                ]            
            ]
        );

        $this->add_responsive_control(
            'exad_news_ticker_label_icon_padding',
            [
                'label'        => __('Padding', 'exclusive-addons-elementor-pro'),
                'type'         => Controls_Manager::DIMENSIONS,
                'size_units'   => ['px', '%'],
                'default'      => [
                    'top'      => '0',
                    'bottom'   => '0',
                    'left'     => '0',
                    'right'    => '10',
                    'isLinked' => false
                ],
                'selectors'    => [
                    '{{WRAPPER}} .exad-news-ticker-icon i' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
                'condition'    => [
                    'exad_news_ticker_show_label_icon'    => 'yes',
                    'exad_news_ticker_label_icon[value]!' => ''
                ]
            ]
        ); 

        $this->end_controls_section();

        $this->start_controls_section(
            'exad_news_ticker_items_style',
            [
                'label' => __( 'Items', 'exclusive-addons-elementor-pro' ),
                'tab'   => Controls_Manager::TAB_STYLE                    
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'exad_news_ticker_typography',
                'selector' => '{{WRAPPER}} .exad-news-ticker ul li, {{WRAPPER}} .exad-news-ticker ul li a'
            ]
        );

        $this->add_control(
            'exad_news_ticker_color',
            [
                'label'     => __( 'Text Color', 'exclusive-addons-elementor-pro' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#333333',
                'selectors' => [
                    '{{WRAPPER}} .exad-news-ticker li, {{WRAPPER}} .exad-news-ticker li a' => 'color: {{VALUE}};'
                ]                
            ]
        );

        $this->add_control(
            'exad_news_ticker_hover_color',
            [
                'label'     => __( 'Hover Color', 'exclusive-addons-elementor-pro' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#3878ff',
                'selectors' => [
                    '{{WRAPPER}} .exad-news-ticker li:hover, {{WRAPPER}} .exad-news-ticker li:hover a' => 'color: {{VALUE}};'
                ]                
            ]
        );

        $this->add_control(
            'exad_news_ticker_bg_color',
            [
                'label'     => __( 'Background Color', 'exclusive-addons-elementor-pro' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .exad-news-ticker' => 'background-color: {{VALUE}};'
                ]               
            ]
        );

        $this->add_responsive_control(
            'exad_news_ticker_each_item_padding',
            [
                'label'      => __( 'Padding Each Item(Left & Right)', 'exclusive-addons-elementor-pro' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'default'    => [
                    'size'   => 15
                ],
                'selectors'  => [
                    '{{WRAPPER}} .exad-news-ticker .exad-nt-news ul li' => 'padding: 0 {{SIZE}}{{UNIT}};'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'exad_news_ticker_items_border',
                'selector' => '{{WRAPPER}} .exad-news-ticker .exad-nt-news'
            ]
        );

        $this->add_responsive_control(
            'exad_news_ticker_items_border_radius',
            [
                'label'      => __( 'Border Radius', 'exclusive-addons-elementor-pro' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px'],
                'selectors'  => [
                    '{{WRAPPER}} .exad-news-ticker .exad-nt-news'=> 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'exad_news_ticker_control_style',
            [
                'label'     => __( 'Controls', 'exclusive-addons-elementor-pro' ),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [
                    '.exad_news_ticker_show_controls' => 'yes'
                ]             
            ]
        );

        $this->add_responsive_control(
			'exad_news_ticker_control_spacing',
			[
                'label'       => __( 'Spacing (Left & Right)', 'exclusive-addons-elementor-pro' ),
                'type'        => Controls_Manager::SLIDER,
                'size_units'  => [ 'px' ],
                'range'       => [
					'px'      => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default'     => [
					'unit'    => 'px',
					'size'    => 20,
				],
				'selectors'   => [
					'{{WRAPPER}} .exad-news-ticker .exad-nt-controls' => 'padding: 0 {{SIZE}}{{UNIT}} 0;',
				],
			]
		);

        $this->add_control(
            'exad_news_ticker_control_box_style',
            [
                'label' => __( 'Control Box', 'exclusive-addons-elementor-pro' ),
                'type'  => Controls_Manager::HEADING
            ]
        );

        $this->add_control(
            'exad_news_ticker_control_bg_color',
            [
                'label'     => __( 'Background Color', 'exclusive-addons-elementor-pro' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .exad-news-ticker .exad-nt-controls' => 'background-color: {{VALUE}};'
                ]               
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'exad_news_ticker_controls_box_border',
                'selector' => '{{WRAPPER}} .exad-news-ticker .exad-nt-controls'
            ]
        );

        $this->add_responsive_control(
            'exad_news_ticker_controls_box_border_radius',
            [
                'label'      => __( 'Border Radius', 'exclusive-addons-elementor-pro' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px'],
                'selectors'  => [
                    '{{WRAPPER}} .exad-news-ticker .exad-nt-controls' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->add_control(
            'exad_news_ticker_control_box_item_style',
            [
                'label'     => __( 'Control Items', 'exclusive-addons-elementor-pro' ),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before'
            ]
        );

        $this->add_responsive_control(
            'exad_news_ticker_controls_size',
            [
                'label'      => __( 'Size', 'exclusive-addons-elementor-pro' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'default'    => [
                    'size'   => 30
                ],
                'selectors'  => [
                    '{{WRAPPER}} .exad-news-ticker .exad-nt-controls button' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};'
                ]
            ]
        );

        $this->add_responsive_control(
			'exad_news_ticker_control_item_spacing',
			[
                'label'       => __( 'Control Item Spacing', 'exclusive-addons-elementor-pro' ),
                'type'        => Controls_Manager::SLIDER,
                'size_units'  => [ 'px' ],
                'range'       => [
					'px'      => [
						'min' => 0,
						'max' => 50,
					],
				],
				'default'     => [
					'unit'    => 'px',
					'size'    => 10
				],
				'selectors'   => [
					'{{WRAPPER}} .exad-news-ticker .exad-nt-controls button:not(:last-child)' => 'margin-right: {{SIZE}}{{UNIT}};'
				]
			]
		);

        $this->start_controls_tabs( 'exad_news_ticker_controls_tabs' );

            # Normal State Tab
            $this->start_controls_tab( 'exad_news_ticker_controls_normal', [ 'label' => __( 'Normal', 'exclusive-addons-elementor-pro' ) ] );
                $this->add_control(
                    'exad_news_ticker_controls_color',
                    [
                        'label'     => __( 'Icon Color', 'exclusive-addons-elementor-pro' ),
                        'type'      => Controls_Manager::COLOR,
                        'default'   => '#999999',
                        'selectors' => [
                            '{{WRAPPER}} .exad-news-ticker .exad-nt-controls button .bn-arrow::before, {{WRAPPER}} .exad-news-ticker .exad-nt-controls button .bn-arrow::after' => 'border-color: {{VALUE}};',
                            '{{WRAPPER}} .exad-news-ticker .exad-nt-controls button .bn-pause::before, {{WRAPPER}} .exad-news-ticker .exad-nt-controls button .bn-pause::after' => 'background-color: {{VALUE}};'
                        ]
                    ]
                );

                $this->add_control(
                    'exad_news_ticker_controls_bg_color',
                    [
                        'label'     => __( 'Background Color', 'exclusive-addons-elementor-pro' ),
                        'type'      => Controls_Manager::COLOR,
                        'default'   => 'rgba(0,0,0,0)',
                        'selectors' => [
                            '{{WRAPPER}} .exad-news-ticker .exad-nt-controls button' => 'background-color: {{VALUE}};'
                        ]
                    ]
                );
                
                $this->add_group_control(
                    Group_Control_Border::get_type(),
                    [
                        'name'     => 'exad_news_ticker_control_items_border',
                        'selector' => '{{WRAPPER}} .exad-news-ticker .exad-nt-controls button'
                    ]
                );

                $this->add_responsive_control(
                    'exad_news_ticker_control_items_border_radius',
                    [
                        'label'      => __( 'Border Radius', 'exclusive-addons-elementor-pro' ),
                        'type'       => Controls_Manager::DIMENSIONS,
                        'size_units' => [ 'px'],
                        'selectors'  => [
                            '{{WRAPPER}} .exad-news-ticker .exad-nt-controls button'=> 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                        ]
                    ]
                );


            $this->end_controls_tab();

            #Hover State Tab
            $this->start_controls_tab( 'exad_news_ticker_controls_hover', [ 'label' => __( 'Hover', 'exclusive-addons-elementor-pro' ) ] );
                $this->add_control(
                    'exad_news_ticker_controls_hover_color',
                    [
                        'label'     => __( 'Icon Color', 'exclusive-addons-elementor-pro' ),
                        'type'      => Controls_Manager::COLOR,
                        'default'   => '#999999',
                        'selectors' => [
                            '{{WRAPPER}} .exad-news-ticker .exad-nt-controls button:hover .bn-arrow::before, {{WRAPPER}} .exad-news-ticker .exad-nt-controls button:hover .bn-arrow::after' => 'border-color: {{VALUE}};',
                            '{{WRAPPER}} .exad-news-ticker .exad-nt-controls button:hover .bn-pause::before, {{WRAPPER}} .exad-news-ticker .exad-nt-controls button:hover .bn-pause::after' => 'background-color: {{VALUE}};'
                        ]
                    ]
                );

                $this->add_control(
                    'exad_news_ticker_controls_bg_hover_color',
                    [
                        'label'     => __( 'Background Color', 'exclusive-addons-elementor-pro' ),
                        'type'      => Controls_Manager::COLOR,
                        'default'   => 'rgba(0,0,0,0)',
                        'selectors' => [
                            '{{WRAPPER}} .exad-news-ticker .exad-nt-controls button:hover' => 'background-color: {{VALUE}};'
                        ]
                    ]
                );

                $this->add_group_control(
                    Group_Control_Border::get_type(),
                    [
                        'name'     => 'exad_news_ticker_control_items_hover_border',
                        'selector' => '{{WRAPPER}} .exad-news-ticker .exad-nt-controls button:hover'
                    ]
                );

                $this->add_responsive_control(
                    'exad_news_ticker_control_items_hover_border_radius',
                    [
                        'label'      => __( 'Border Radius', 'exclusive-addons-elementor-pro' ),
                        'type'       => Controls_Manager::DIMENSIONS,
                        'size_units' => [ 'px'],
                        'selectors'  => [
                            '{{WRAPPER}} .exad-news-ticker .exad-nt-controls button:hover'=> 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                        ]
                    ]
                );

            $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();

    }

    protected function render() {
        $settings             = $this->get_settings_for_display();
        $post_type            = $settings['exad_news_ticker_post_types'];
        $orderby              = $settings['exad_news_ticker_order_by'];
        $order                = $settings['exad_news_ticker_order'];
        $items_number         = $settings['exad_news_ticker_number_of_items_to_show'];
        $include_items_by_ids = $settings['exad_news_ticker_include_specific_items_by_ids'] ? explode( ',', $settings['exad_news_ticker_include_specific_items_by_ids'] ) : null;
        $exclude_items_by_ids = $settings['exad_news_ticker_exclude_specific_items_by_ids'] ? explode( ',', $settings['exad_news_ticker_exclude_specific_items_by_ids'] ) : null;  
        
        $label                = $settings['exad_news_ticker_label'];
        $show_label           = $settings['exad_news_ticker_show_label'];
        $direction            = $settings['exad_news_ticker_animation_direction'];
        $ticker_height        = $settings['exad_news_ticker_height']['size'];
        $autoplay             = $settings['exad_news_ticker_autoplay'];
        $fixed_position       = $settings['exad_news_ticker_set_fixed_position'];
        $animation_type       = $settings['exad_news_ticker_animation_type'];
        
        $arrow                = 'yes'    === $settings['exad_news_ticker_show_label_arrow'] ? ' yes-small' : ' no';
        $pause_on_hover       = 'yes'    === $autoplay ? $settings['exad_news_ticker_pause_on_hover'] : '';
        $animation_speed      = 'scroll' === $animation_type ? $settings['exad_news_ticker_animation_speed'] : '';
        $autoplay_interval    = 'scroll' !== $animation_type ? $settings['exad_news_ticker_autoplay_interval'] : '';

        $args = array(
            'post_type'          => $post_type,
            'post_status'        => 'publish',
            'orderby'            => $orderby,
            'order'              => $order,
            'exad_news_ticker_number_of_items_to_show'     => $items_number,
            'post__in'           => $include_items_by_ids,
            'post__not_in'       => $exclude_items_by_ids
        );

        $this->add_render_attribute( 'exad-news-ticker-wrapper', 'class', 'exad-news-ticker' );

        $this->add_render_attribute( 
            'exad-news-ticker-wrapper', 
            [ 
                'data-autoplay'          => esc_attr( 'yes' === $autoplay ? 'true' : 'false' ),
                'data-fixed_position'      => esc_attr( $fixed_position ),
                'data-pause_on_hover'    => esc_attr( 'yes' === $pause_on_hover ? 'true' : 'false' ),
                'data-direction'         => 'rtl' === $direction || is_rtl() ? 'rtl' : 'ltr',
                'data-autoplay_interval' => esc_attr( $autoplay_interval ),
                'data-animation_speed'   => esc_attr( $animation_speed ),
                'data-ticker_height'     => esc_attr( $ticker_height ),
                'data-animation'         => esc_attr( $animation_type )
            ]
        );
        
        $this->add_inline_editing_attributes( 'exad_news_ticker_label', 'none' );
        $wp_query = new \WP_Query( $args );
        if ( $wp_query->have_posts() ) : ?>
            <div <?php echo $this->get_render_attribute_string( 'exad-news-ticker-wrapper' ); ?>>

                <?php do_action( 'exad_news_ticker_wrapper_pro_before' ); ?>

                <?php if( 'yes' === $show_label ): ?>
                    <div class="exad-bn-label <?php echo esc_attr( $arrow ); ?>">
                        <div class="exad-nt-label">
                            <?php if( 'yes' === $settings['exad_news_ticker_show_label_icon'] && ! empty( $settings['exad_news_ticker_label_icon'] ) ){ ?>
                                <span class="exad-news-ticker-icon">
                                    <?php Icons_Manager::render_icon( $settings['exad_news_ticker_label_icon'], [ 'aria-hidden' => 'true' ] ); ?>
                                </span>                                
                            <?php }
                            
                            if( ! empty( $label ) ) { ?>
                                <span <?php echo $this->get_render_attribute_string( 'exad_news_ticker_label' ); ?>><?php echo wp_kses_post( $label ); ?></span>
                            <?php } ?>
                        </div>
                    </div>
                <?php endif; ?>

                <div class="exad-nt-news">
                    <ul>
                        <?php while ( $wp_query->have_posts() ) : $wp_query->the_post(); ?>
                            <li><a href="<?php echo esc_url( get_the_permalink() ); ?>" target="_blank"><span><?php echo wp_kses_post( get_the_title() ); ?></span></a></li>
                        <?php endwhile; ?>
                    </ul>
                </div>

                <?php if ( 'yes' === $settings['exad_news_ticker_show_controls'] ) : ?>
                    <div class="exad-nt-controls">
                        <button><span class="bn-arrow bn-prev"></span></button>
                        <?php if( 'yes' === $settings['exad_news_ticker_show_pause_control'] ) : ?>
                            <button><span class="bn-action"></span></button>
                        <?php endif; ?>
                        <button><span class="bn-arrow bn-next"></span></button>
                    </div>
                <?php endif;

                do_action( 'exad_news_ticker_wrapper_pro_after' ); ?>
                
            </div>
        <?php else :
            _e( 'There is no '.esc_attr( $post_type ).' items to show. Please add some post.', 'exclusive-addons-elementor-pro' );
        endif;
    }

}
