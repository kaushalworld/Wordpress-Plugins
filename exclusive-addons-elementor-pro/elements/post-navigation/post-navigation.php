<?php
namespace ExclusiveAddons\Elements;

if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.

use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Border;
use \Elementor\Group_Control_Typography;
use \Elementor\Widget_Base;
use \Elementor\Group_Control_Background;
use \Elementor\Group_Control_Box_Shadow;

class Post_Navigation extends Widget_Base {

    public function get_name() {
        return 'exad-post-navigation';
    }

    public function get_title() {
        return esc_html__( 'Post Navigation', 'exclusive-addons-elementor-pro' );
    }

    public function get_icon() {
        return 'exad exad-logo exad-post-navigation';
    }

    public function get_categories() {
        return [ 'exclusive-addons-elementor' ];
    }

    public function get_keywords() {
        return [ 'post', 'navigation', 'next', 'previous', 'links' ];
    }

    protected function register_controls() {
        $exad_primary_color   = get_option( 'exad_primary_color_option', '#7a56ff' );

        $this->start_controls_section(
            'exad_post_navigation_section',
            [
                'label' => __( 'Post Navigation', 'exclusive-addons-elementor-pro' )
            ]
        );

        $this->add_control(
            'exad_post_nav_enable_label',
            [
                'label'     => __( 'Label', 'exclusive-addons-elementor-pro' ),
                'type'      => Controls_Manager::SWITCHER,
                'label_on'  => __( 'Enable', 'exclusive-addons-elementor-pro' ),
                'label_off' => __( 'Disable', 'exclusive-addons-elementor-pro' ),
                'default'   => 'no'
            ]
        );

        $this->add_control(
            'exad_post_nav_prev_label',
            [
                'label'     => __( 'Previous Label', 'exclusive-addons-elementor-pro' ),
                'type'      => Controls_Manager::TEXT,
                'default'   => __( 'Previous', 'exclusive-addons-elementor-pro' ),
                'condition' => [
                    'exad_post_nav_enable_label' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'exad_post_nav_next_label',
            [
                'label'     => __( 'Next Label', 'exclusive-addons-elementor-pro' ),
                'type'      => Controls_Manager::TEXT,
                'default'   => __( 'Next', 'exclusive-addons-elementor-pro' ),
                'condition' => [
                    'exad_post_nav_enable_label' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'exad_post_nav_enable_title',
            [
                'label'     => __( 'Post Title', 'exclusive-addons-elementor-pro' ),
                'type'      => Controls_Manager::SWITCHER,
                'label_on'  => __( 'Enable', 'exclusive-addons-elementor-pro' ),
                'label_off' => __( 'Disable', 'exclusive-addons-elementor-pro' ),
                'default'   => 'yes'
            ]
        );

        $this->add_control(
            'exad_post_nav_enable_arrow',
            [
                'label'     => __( 'Arrows', 'exclusive-addons-elementor-pro' ),
                'type'      => Controls_Manager::SWITCHER,
                'label_on'  => __( 'Enable', 'exclusive-addons-elementor-pro' ),
                'label_off' => __( 'Disable', 'exclusive-addons-elementor-pro' ),
                'default'   => 'yes'
            ]
        );

        $this->add_control(
            'exad_post_nav_prev_icon',
            [
                'label'       => __( 'Previous Icon', 'exclusive-addons-elementor-pro' ),
                'type'        => Controls_Manager::ICONS,
                'default'     => [
                    'value'   => 'fas fa-arrow-left',
                    'library' => 'fa-solid'
                ],
                'condition'   => [
                    'exad_post_nav_enable_arrow' => 'yes'
                ]
            ]
        ); 

        $this->add_control(
            'exad_post_nav_next_icon',
            [
                'label'       => __( 'Next Icon', 'exclusive-addons-elementor-pro' ),
                'type'        => Controls_Manager::ICONS,
                'default'     => [
                    'value'   => 'fas fa-arrow-right',
                    'library' => 'fa-solid'
                ],
                'condition'   => [
                    'exad_post_nav_enable_arrow' => 'yes'
                ]
            ]
        ); 

        $this->add_control(
            'exad_post_nav_stay_current_cat',
            [
                'label'     => __( 'Stay in Current Category', 'exclusive-addons-elementor-pro' ),
                'type'      => Controls_Manager::SWITCHER,
                'label_on'  => __( 'True', 'exclusive-addons-elementor-pro' ),
                'label_off' => __( 'False', 'exclusive-addons-elementor-pro' ),
                'default'   => 'no'
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'exad_post_navigation_each_item_style',
            [
                'label'     => __( 'Item', 'exclusive-addons-elementor-pro' ),
                'tab'       => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_responsive_control(
            'exad_post_nav_prev_item_margin',
            [
                'label'        => esc_html__( 'Margin', 'exclusive-addons-elementor-pro' ),
                'type'         => Controls_Manager::DIMENSIONS,            
                'size_units'   => [ 'px', 'em', '%' ],
                'default'      => [
                    'top'      => '',
                    'right'    => '',
                    'bottom'   => '',
                    'left'     => '',
                    'isLinked' => true
                ],
                'selectors'    => [
                    '{{WRAPPER}} .exad-post-nav-each-item' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'      => 'exad_post_nav_item_border',
                'selector'  => '{{WRAPPER}} .exad-post-nav-previous, {{WRAPPER}} .exad-post-nav-next'
            ]
        );

        $this->add_responsive_control(
            'exad_post_nav_item_border_radius',
            [
                'label'        => esc_html__( 'Border Radius', 'exclusive-addons-elementor-pro' ),
                'type'         => Controls_Manager::DIMENSIONS,            
                'size_units'   => [ 'px', 'em', '%' ],
                'default'      => [
                    'top'      => '30',
                    'right'    => '30',
                    'bottom'   => '30',
                    'left'     => '30'
                ],
                'selectors'    => [
                    '{{WRAPPER}} .exad-post-nav-previous' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .exad-post-nav-next' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .exad-post-nav-previous::before' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .exad-post-nav-next::before' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'exad_post_nav_item_shadow',
				'label' => __( 'Box Shadow', 'exclusive-addons-elementor-pro' ),
				'selector' => '{{WRAPPER}} .exad-post-nav-previous, {{WRAPPER}} .exad-post-nav-next',
			]
        );
        
        $this->add_control(
			'exad_post_nav_item_feature_image',
			[
				'label' => __( 'Show Featured Image', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'exclusive-addons-elementor-pro' ),
				'label_off' => __( 'Hide', 'exclusive-addons-elementor-pro' ),
				'return_value' => 'yes',
                'default' => 'no',
                'separator' => 'before',
			]
		);

        $this->start_controls_tabs( 'exad_post_nav_item_style_tabs' );

            $this->start_controls_tab( 'exad_post_nav_prev_item', [ 'label' => esc_html__( 'Previous', 'exclusive-addons-elementor-pro' ) ] );

                $this->add_responsive_control(
                    'exad_post_nav_prev_item_padding',
                    [
                        'label'        => esc_html__( 'Padding', 'exclusive-addons-elementor-pro' ),
                        'type'         => Controls_Manager::DIMENSIONS,            
                        'size_units'   => [ 'px', 'em', '%' ],
                        'default'      => [
                            'top'      => '10',
                            'right'    => '20',
                            'bottom'   => '10',
                            'left'     => '20',
                            'isLinked' => false
                        ],
                        'selectors'    => [
                            '{{WRAPPER}} .exad-post-nav-previous' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                        ]
                    ]
                );

                $this->add_group_control(
                    Group_Control_Background::get_type(),
                    [
                        'name' => 'exad_post_nav_item_bg_prev',
                        'label' => __( 'Background', 'exclusive-addons-elementor-pro' ),
                        'types' => [ 'classic', 'gradient' ],
                        'selector' => '{{WRAPPER}} .exad-post-nav-previous',
                        'fields_options'  => [
                            'background'  => [
                                'default' => 'classic'
                            ],
                            'color'       => [
                                'default' => $exad_primary_color
                            ]
                        ],
                        'condition' => [
                            'exad_post_nav_item_feature_image!' => 'yes'
                        ]
                    ]
                );

                $this->add_control(
                    'exad_post_nav_item_bg_overlay_prev',
                    [
                        'label'     => __( 'Overlay Color', 'exclusive-addons-elementor-pro' ),
                        'type'      => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .exad-post-nav-previous::before' => 'background: {{VALUE}};'
                        ],
                    ]
                );

            $this->end_controls_tab();

            $this->start_controls_tab( 'exad_post_nav_next_item', [ 'label' => esc_html__( 'Next', 'exclusive-addons-elementor-pro' ) ] );

                $this->add_responsive_control(
                    'exad_post_nav_next_item_padding',
                    [
                        'label'        => esc_html__( 'Padding', 'exclusive-addons-elementor-pro' ),
                        'type'         => Controls_Manager::DIMENSIONS,            
                        'size_units'   => [ 'px', 'em', '%' ],
                        'default'      => [
                            'top'      => '10',
                            'right'    => '20',
                            'bottom'   => '10',
                            'left'     => '20',
                            'isLinked' => false
                        ],
                        'selectors'    => [
                            '{{WRAPPER}} .exad-post-nav-next' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                        ]
                    ]
                );

                $this->add_group_control(
                    Group_Control_Background::get_type(),
                    [
                        'name' => 'exad_post_nav_item_bg_next',
                        'label' => __( 'Background', 'exclusive-addons-elementor-pro' ),
                        'types' => [ 'classic', 'gradient' ],
                        'selector' => '{{WRAPPER}} .exad-post-nav-next',
                        'fields_options'  => [
                            'background'  => [
                                'default' => 'classic'
                            ],
                            'color'       => [
                                'default' => $exad_primary_color
                            ]
                        ],
                        'condition' => [
                            'exad_post_nav_item_feature_image!' => 'yes'
                        ]
                    ]
                );

                $this->add_control(
                    'exad_post_nav_item_bg_overlay_next',
                    [
                        'label'     => __( 'Overlay Color', 'exclusive-addons-elementor-pro' ),
                        'type'      => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .exad-post-nav-next::before' => 'background: {{VALUE}};'
                        ],
                    ]
                );

            $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();

        $this->start_controls_section(
            'exad_post_navigation_label_style',
            [
                'label'     => __( 'Label', 'exclusive-addons-elementor-pro' ),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'exad_post_nav_enable_label' => 'yes'
                ]
            ]
        );
        
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'exad_post_navigation_label_typography',
                'selector' => '{{WRAPPER}} .exad-post-nav-prev-label, {{WRAPPER}} .exad-post-nav-next-label'
            ]
        );

        $this->start_controls_tabs( 'exad_post_nav_label_style_tabs' );

            // normal state tab
            $this->start_controls_tab( 'exad_post_nav_label_normal', [ 'label' => esc_html__( 'Normal', 'exclusive-addons-elementor-pro' ) ] );

            $this->add_control(
                'exad_post_nav_label_normal_color',
                [
                    'label'     => esc_html__( 'Text Color', 'exclusive-addons-elementor-pro' ),
                    'type'      => Controls_Manager::COLOR,
                    'default'   => '#ffffff',
                    'selectors' => [
                        '{{WRAPPER}} .exad-post-nav-prev-label' => 'color: {{VALUE}};',
                        '{{WRAPPER}} .exad-post-nav-next-label' => 'color: {{VALUE}};'
                    ]
                ]
            );

            $this->end_controls_tab();

            // hover state tab
            $this->start_controls_tab( 'exad_post_nav_label_hover', [ 'label' => esc_html__( 'Hover', 'exclusive-addons-elementor-pro' ) ] );

            $this->add_control(
                'exad_post_nav_label_hover_color',
                [
                    'label'     => esc_html__( 'Text Color', 'exclusive-addons-elementor-pro' ),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .exad-post-nav-prev-label:hover' => 'color: {{VALUE}};',
                        '{{WRAPPER}} .exad-post-nav-next-label:hover' => 'color: {{VALUE}};'
                    ]
                ]
            );

            $this->end_controls_tab();

            $this->end_controls_tabs();

        $this->end_controls_section();

        $this->start_controls_section(
            'exad_post_navigation_title_style',
            [
                'label'     => __( 'Title', 'exclusive-addons-elementor-pro' ),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'exad_post_nav_enable_title' => 'yes'
                ]
            ]
        );
        
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'exad_post_navigation_title_typography',
                'selector' => '{{WRAPPER}} .exad-post-nav-prev-title, {{WRAPPER}} .exad-post-nav-next-title'
            ]
        );

        $this->start_controls_tabs( 'exad_post_nav_title_style_tabs' );

            // normal state tab
            $this->start_controls_tab( 'exad_post_nav_title_normal', [ 'label' => esc_html__( 'Normal', 'exclusive-addons-elementor-pro' ) ] );

            $this->add_control(
                'exad_post_nav_title_normal_color',
                [
                    'label'     => esc_html__( 'Text Color', 'exclusive-addons-elementor-pro' ),
                    'type'      => Controls_Manager::COLOR,
                    'default'   => '#ffffff',
                    'selectors' => [
                        '{{WRAPPER}} .exad-post-nav-prev-title' => 'color: {{VALUE}};',
                        '{{WRAPPER}} .exad-post-nav-next-title' => 'color: {{VALUE}};'
                    ]
                ]
            );

            $this->end_controls_tab();

            // hover state tab
            $this->start_controls_tab( 'exad_post_nav_title_hover', [ 'label' => esc_html__( 'Hover', 'exclusive-addons-elementor-pro' ) ] );

            $this->add_control(
                'exad_post_nav_title_hover_color',
                [
                    'label'     => esc_html__( 'Text Color', 'exclusive-addons-elementor-pro' ),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .exad-post-nav-prev-title:hover' => 'color: {{VALUE}};',
                        '{{WRAPPER}} .exad-post-nav-next-title:hover' => 'color: {{VALUE}};'
                    ]
                ]
            );

            $this->end_controls_tab();

            $this->end_controls_tabs();

        $this->end_controls_section();

        $this->start_controls_section(
            'exad_post_navigation_arrow_style',
            [
                'label'     => __( 'Arrow', 'exclusive-addons-elementor-pro' ),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'exad_post_nav_enable_arrow' => 'yes'
                ]
            ]
        );
        
        $this->add_responsive_control(
            'exad_post_navigation_arrow_size',
            [
                'label'       => __( 'Size', 'exclusive-addons-elementor-pro' ),
                'type'        => Controls_Manager::SLIDER,
                'size_units'  => [ 'px'],
                'default'     => [
                    'size'    => 13,
                    'unit'    => 'px'
                ],
                'range'       => [
                    'px'      => [
                        'min' => 0,
                        'max' => 100
                    ]
                ],
                'selectors'   => [
                    '{{WRAPPER}} .exad-post-nav-prev-arrow i' => 'font-size: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .exad-post-nav-next-arrow i' => 'font-size: {{SIZE}}{{UNIT}};'
                ]
            ]
        );
        
        $this->add_responsive_control(
            'exad_post_navigation_arrow_spacing',
            [
                'label'       => __( 'Spacing', 'exclusive-addons-elementor-pro' ),
                'type'        => Controls_Manager::SLIDER,
                'size_units'  => [ 'px', '%' ],
                'default'     => [
                    'size'    => 10,
                    'unit'    => 'px'
                ],
                'range'       => [
                    'px'      => [
                        'min' => 0,
                        'max' => 100
                    ]
                ],
                'selectors'   => [
                    '{{WRAPPER}} .exad-post-nav-prev-arrow' => 'margin-right: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .exad-post-nav-next-arrow' => 'margin-left: {{SIZE}}{{UNIT}};'
                ]
            ]
        );

        $this->start_controls_tabs( 'exad_post_nav_arrow_style_tabs' );

            // normal state tab
            $this->start_controls_tab( 'exad_post_nav_arrow_normal', [ 'label' => esc_html__( 'Normal', 'exclusive-addons-elementor-pro' ) ] );

            $this->add_control(
                'exad_post_nav_arrow_normal_color',
                [
                    'label'     => esc_html__( 'Text Color', 'exclusive-addons-elementor-pro' ),
                    'type'      => Controls_Manager::COLOR,
                    'default'   => '#ffffff',
                    'selectors' => [
                        '{{WRAPPER}} .exad-post-nav-prev-arrow' => 'color: {{VALUE}};',
                        '{{WRAPPER}} .exad-post-nav-next-arrow' => 'color: {{VALUE}};'
                    ]
                ]
            );

            $this->end_controls_tab();

            // hover state tab
            $this->start_controls_tab( 'exad_post_nav_arrow_hover', [ 'label' => esc_html__( 'Hover', 'exclusive-addons-elementor-pro' ) ] );

            $this->add_control(
                'exad_post_nav_arrow_hover_color',
                [
                    'label'     => esc_html__( 'Text Color', 'exclusive-addons-elementor-pro' ),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .exad-post-nav-prev-arrow:hover' => 'color: {{VALUE}};',
                        '{{WRAPPER}} .exad-post-nav-next-arrow:hover' => 'color: {{VALUE}};'
                    ]
                ]
            );

            $this->end_controls_tab();

            $this->end_controls_tabs();

        $this->end_controls_section();
    }

    protected function render() {
        $settings        = $this->get_settings_for_display();  
        $prev_icon_class = $settings['exad_post_nav_prev_icon'];
        $next_icon_class = $settings['exad_post_nav_next_icon'];
        $prevPost        = get_previous_post();
        $nextPost        = get_next_post();
        if( $prevPost != "" ){
            $prevThumbUrl    = get_the_post_thumbnail_url( $prevPost->ID );
        }
        if( $nextPost != "" ){
            $nextThumbUrl    = get_the_post_thumbnail_url( $nextPost->ID );
        }
        $prev_label = $next_label = $prev_title = $next_title = $prev_arrow = $next_arrow = $prev_bg_url = $next_bg_url = '';

        if( $settings['exad_post_nav_stay_current_cat'] === 'yes' ){
            $stay_current_cat = true;
        }else {
            $stay_current_cat = '';
        }

        if ( 'yes' === $settings['exad_post_nav_enable_label'] ) :
            $prev_label = '<span class="exad-post-nav-prev-label">' . esc_html( $settings['exad_post_nav_prev_label'] ) . '</span>';
            $next_label = '<span class="exad-post-nav-next-label">' . esc_html( $settings['exad_post_nav_next_label'] ) . '</span>';
        endif;

        if ( 'yes' === $settings['exad_post_nav_enable_arrow'] ) :
            $prev_arrow = '<span class="exad-post-nav-prev-arrow"><i class="' . esc_attr( $prev_icon_class['value'] ) . '" aria-hidden="true"></i></span>';
            $next_arrow = '<span class="exad-post-nav-next-arrow"><i class="' . esc_attr( $next_icon_class['value'] ) . '" aria-hidden="true"></i></span>';
        endif;

        if ( 'yes' === $settings['exad_post_nav_enable_title'] ) :
            $prev_title = '<span class="exad-post-nav-prev-title">%title</span>';
            $next_title = '<span class="exad-post-nav-next-title">%title</span>';
        endif;

        ?>   
        <div class="exad-post-navigation-wrapper">
            <div class="exad-post-nav-each-item">
                <div class="exad-post-nav-previous"<?php echo wp_kses_post( $prev_bg_url );?> <?php if( 'yes' === $settings['exad_post_nav_item_feature_image'] ) { ?> style="background-image: url( <?php echo $prevThumbUrl; ?> ); background-size: cover; background-repeat: no-repeat;" <?php } ?>>
                    <?php previous_post_link( '%link', wp_kses_post( $prev_arrow ) . '<span class="exad-post-nav-prev-link">' . wp_kses_post( $prev_label ) . wp_kses_post( $prev_title ) . '</span>' , $stay_current_cat ); ?>
                </div>
            </div>
            <?php if( $nextPost != "" ) { ?>
                <div class="exad-post-nav-each-item">
                    <div class="exad-post-nav-next"<?php echo wp_kses_post( $next_bg_url );?> <?php if( 'yes' === $settings['exad_post_nav_item_feature_image'] ) { ?> style="background-image: url( <?php echo $nextThumbUrl; ?> ); background-size: cover; background-repeat: no-repeat;" <?php } ?>>
                        <?php next_post_link( '%link', '<span class="exad-post-nav-next-link">' . wp_kses_post( $next_label ) . wp_kses_post( $next_title ) . '</span>' . wp_kses_post( $next_arrow ), $stay_current_cat ); ?>
                    </div>
                </div>
            <?php } ?>
        </div>
        <?php
    }
}
