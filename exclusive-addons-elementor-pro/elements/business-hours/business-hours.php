<?php
namespace ExclusiveAddons\Elements;

if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.

use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Border;
use \Elementor\Repeater;
use \Elementor\Group_Control_Box_Shadow;
use \Elementor\Group_Control_Typography;
use \Elementor\Group_Control_Background;
use \Elementor\Widget_Base;
use \Elementor\Utils;
use \ExclusiveAddons\Elementor\Helper;

class Business_Hours extends Widget_Base {
	
	public function get_name() {
		return 'exad-business-hours';
    }
    
	public function get_title() {
		return esc_html__( 'Business Hours', 'exclusive-addons-elementor-pro' );
    }
    
	public function get_icon() {
		return 'exad exad-logo exad-business-hours';
    }
    
	public function get_categories() {
		return [ 'exclusive-addons-elementor' ];
    }

    public function get_keywords() {
		return [ 'exclusive', 'business', 'schedule', 'hours', 'time', 'clock' ];
	}
    
    protected function register_controls() {

		$this->start_controls_section(
			'exad_business_hours_settings',
			[
				'label' => esc_html__( 'Business Hours', 'exclusive-addons-elementor-pro' )
			]
        );

        $this->add_control(
			'exad_business_hours_heading', [
				'label'       => esc_html__( 'Heading', 'exclusive-addons-elementor-pro' ),
				'type'        => Controls_Manager::TEXT,
				'label_block' => true,
				'default'     => esc_html__( 'Business Hours', 'exclusive-addons-elementor-pro' )
			]
		);	

		$this->add_control(
            'exad_business_hours_heading_tag',
            [
                'label'   => __('Heading HTML Tag', 'exclusive-addons-elementor-pro'),
                'type'    => Controls_Manager::SELECT,
                'options' => Helper::exad_title_tags(),
                'default' => 'h2',
            ]
		);

		$this->add_control(
            'exad_business_hours_items_section',
            [
				'label'     => esc_html__( 'Items', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before'
            ]
        );	

        $repeater = new Repeater();

        $repeater->start_controls_tabs('exad_business_hours_tabs');

        $repeater->start_controls_tab('exad_business_hours_content_tab', ['label' => __('Content', 'exclusive-addons-elementor-pro')]);

		$repeater->add_control(
			'exad_business_hours_day',
			[
				'label'       => esc_html__( 'Day', 'exclusive-addons-elementor-pro' ),
				'type'        => Controls_Manager::TEXT,
				'label_block' => true,
				'default'     => esc_html__( 'Monday', 'exclusive-addons-elementor-pro' )
			]
		);

        $repeater->add_control(
			'exad_business_hours_time',
			[
				'label'       => esc_html__( 'Time', 'exclusive-addons-elementor-pro' ),
				'type'        => Controls_Manager::TEXT,
				'label_block' => true,
				'default'     => esc_html__( '9:00 AM - 6:00 PM', 'exclusive-addons-elementor-pro' )
			]
		);

		$repeater->end_controls_tab();

		$repeater->start_controls_tab('exad_business_hours_style_tab', ['label' => __('Style', 'exclusive-addons-elementor-pro')]);

		$repeater->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'exad_business_hours_each_item_bg_color',
				'selector' => '{{WRAPPER}} .exad-businesshours-container-inner {{CURRENT_ITEM}}.business-date'
			]
		);

        $repeater->add_control(
		    'exad_business_hours_each_item_day_color',
		    [
		        'label'     => __( 'Day Color', 'exclusive-addons-elementor-pro' ),
		        'type'      => Controls_Manager::COLOR,
		        'selectors' => [
		            '{{WRAPPER}} {{CURRENT_ITEM}}.business-date .single-business-date' => 'color: {{VALUE}};'
		        ]
		    ]
		);

        $repeater->add_control(
		    'exad_business_hours_each_item_time_color',
		    [
		        'label'     => __( 'Time Color', 'exclusive-addons-elementor-pro' ),
		        'type'      => Controls_Manager::COLOR,
		        'selectors' => [
		            '{{WRAPPER}} {{CURRENT_ITEM}}.business-date .single-business-time' => 'color: {{VALUE}};'
		        ]
		    ]
		);

        $repeater->end_controls_tab();

        $repeater->end_controls_tabs();

        $this->add_control(
			'exad_business_hours_repeater',
			[
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'default'     => [
					[
						'exad_business_hours_day'  => esc_html__( 'Monday', 'exclusive-addons-elementor-pro' ),
						'exad_business_hours_time' => esc_html__( '09:00 AM - 6:00 PM', 'exclusive-addons-elementor-pro' )
					],
					[
						'exad_business_hours_day'  => esc_html__( 'Tuesday', 'exclusive-addons-elementor-pro' ),
						'exad_business_hours_time' => esc_html__( '09:00 AM - 6:00 PM', 'exclusive-addons-elementor-pro' )
					],
					[
						'exad_business_hours_day'  => esc_html__( 'Wednesday', 'exclusive-addons-elementor-pro' ),
						'exad_business_hours_time' => esc_html__( '09:00 AM - 6:00 PM', 'exclusive-addons-elementor-pro' )
					],
					[
						'exad_business_hours_day'  => esc_html__( 'Thursday', 'exclusive-addons-elementor-pro' ),
						'exad_business_hours_time' => esc_html__( '09:00 AM - 6:00 PM', 'exclusive-addons-elementor-pro' )
					],
					[
						'exad_business_hours_day'  => esc_html__( 'Friday', 'exclusive-addons-elementor-pro' ),
						'exad_business_hours_time' => esc_html__( '09:00 AM - 6:00 PM', 'exclusive-addons-elementor-pro' )
					],
					[
						'exad_business_hours_day'  => esc_html__( 'Saturday', 'exclusive-addons-elementor-pro' ),
						'exad_business_hours_time' => esc_html__( '09:00 AM - 6:00 PM', 'exclusive-addons-elementor-pro' )
					],
					[
						'exad_business_hours_day'                  => esc_html__( 'Sunday', 'exclusive-addons-elementor-pro' ),
						'exad_business_hours_time'                 => esc_html__( 'Closed', 'exclusive-addons-elementor-pro' ),
						'exad_business_hours_each_item_time_color' => '#7a56ff'
					]
				],
				'title_field' => '{{{ exad_business_hours_day }}}'
			]
		);

		$this->end_controls_section();
		
		$this->start_controls_section(
			'exad_business_hours_container_style',
			[
				'label' => esc_html__( 'Container', 'exclusive-addons-elementor-pro' ),
				'tab'   => Controls_Manager::TAB_STYLE
			]
		);

        $this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'exad_business_hours_container_background_color',
				'selector' => '{{WRAPPER}} .exad-businesshours-container'
			]
		);

        $this->add_responsive_control(
            'exad_business_hours_container_padding',
            [
				'label'      => __('Padding', 'exclusive-addons-elementor-pro'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors'  => [
                    '{{WRAPPER}} .exad-businesshours-container' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->add_responsive_control(
            'exad_business_hours_container_margin',
            [
				'label'        => __('Margin', 'exclusive-addons-elementor-pro'),
				'type'         => Controls_Manager::DIMENSIONS,
				'size_units'   => ['px', '%'],
                'selectors'    => [
                    '{{WRAPPER}} .exad-businesshours-container' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->add_group_control(
        	Group_Control_Border::get_type(),
            [
				'name'     => 'exad_business_hours_container_border',
				'selector' => '{{WRAPPER}} .exad-businesshours-container'
            ]
        );

        $this->add_responsive_control(
			'exad_business_hours_container_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'exclusive-addons-elementor-pro' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .exad-businesshours-container'=> 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
		);

        $this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'exad_business_hours_container_box_shadow',
				'selector' => '{{WRAPPER}} .exad-businesshours-container'
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'exad_business_hours_items_style',
			[
				'label' => esc_html__( 'Items', 'exclusive-addons-elementor-pro' ),
				'tab'   => Controls_Manager::TAB_STYLE
			]
		);

        $this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'exad_business_hours_background_color',
				'selector' => '{{WRAPPER}} .business-date'
			]
		);

		$this->add_control(
			'exad_business_hours_background_switcher',
			[
				'label'        => esc_html__( 'Striped Backgrund Effect', 'exclusive-addons-elementor-pro' ),
				'type'         => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default'      => 'yes'
			]
		);

		$this->start_controls_tabs( 
			'exad_business_hours_odd_even_tabs',
			[
				'condition' => [
					'exad_business_hours_background_switcher' => 'yes'
				]
			]
		);

        $this->start_controls_tab( 'exad_business_hours_odd_tab', ['label' => __( 'Odd Item', 'exclusive-addons-elementor-pro' ) ] );

	        $this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name'            => 'exad_business_hours_odd_bg',
					'selector'        => '{{WRAPPER}} .business-date:nth-child(odd)',
					'fields_options'  => [
						'background'  => [
							'default' => 'classic'
						],
						'color'       => [
							'default' => 'rgba(235,238,245,0.5)'
						]
					]
				]
			);

        $this->end_controls_tab();

        $this->start_controls_tab( 'exad_business_hours_even_tab', ['label' => __( 'Even Item', 'exclusive-addons-elementor-pro' ) ] );

	        $this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name'            => 'exad_business_hours_even_bg',
					'selector'        => '{{WRAPPER}} .business-date:nth-child(even)',
					'fields_options'  => [
						'background'  => [
							'default' => 'classic'
						],
						'color'       => [
							'default' => '#ffffff'
						]
					]
				]
			);

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_control(
			'exad_business_hours_odd_tab_separator_hr',
			[
				'type'      => Controls_Manager::DIVIDER,
				'condition' => [
					'exad_business_hours_background_switcher' => 'yes'
				]
			]
		);

		$this->add_responsive_control(
			'exad_section_business_hours_item_padding',
			[
				'label'      => esc_html__( 'Padding', 'exclusive-addons-elementor-pro'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'default'    => [ 
					'top'    => 8, 
					'right'  => 8, 
					'bottom' => 8, 
					'left'   => 8
				],
				'selectors'  => [
					'{{WRAPPER}} .business-date' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
		);

		$this->add_responsive_control(
            'exad_business_hours_item_margin',
            [
				'label'        => __('Margin', 'exclusive-addons-elementor-pro'),
				'type'         => Controls_Manager::DIMENSIONS,
				'size_units'   => ['px', '%'],
                'selectors'    => [
                    '{{WRAPPER}} .business-date' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );
		
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'      => 'exad_business_hours_item_border',
				'selector'  => '{{WRAPPER}} .business-date'
			]
		);

		$this->add_responsive_control(
			'exad_business_hours_item_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'exclusive-addons-elementor-pro' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .business-date'=> 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'exad_business_hours_item_box_shadow',
				'selector' => '{{WRAPPER}} .business-date'
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'exad_business_hours_heading_style',
			[
				'label'     => esc_html__( 'Heading', 'exclusive-addons-elementor-pro' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'exad_business_hours_heading!' => ''
				]
			]
		);

		$this->add_control(
			'exad_business_hours_heading_color',
			[
				'label'     => esc_html__( 'Color', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#000000',
				'selectors' => [
					'{{WRAPPER}} .exad-business-hours-heading' => 'color: {{VALUE}};'
				]
			]
		);

		$this->add_control(
			'exad_business_hours_heading_bg_color',
			[
				'label'     => esc_html__( 'Background Color', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .exad-business-hours-heading' => 'background-color: {{VALUE}};'
				]
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'exad_business_hours_heading_typography',
				'selector' => '{{WRAPPER}} .exad-business-hours-heading'
			]
		);

		$this->add_responsive_control(
			'exad_business_hours_heading_alignment',
			[
				'label'         => esc_html__( 'Alignment', 'exclusive-addons-elementor-pro' ),
				'type'          => Controls_Manager::CHOOSE,
				'label_block'   => true,
				'toggle'        => false,
				'options'       => [
					'left'      => [
						'title' => esc_html__( 'Left', 'exclusive-addons-elementor-pro' ),
						'icon'  => 'eicon-text-align-left'
					],
					'center'    => [
						'title' => esc_html__( 'Center', 'exclusive-addons-elementor-pro' ),
						'icon'  => 'eicon-text-align-center'
					],
					'right'     => [
						'title' => esc_html__( 'Right', 'exclusive-addons-elementor-pro' ),
						'icon'  => 'eicon-text-align-right'
					],
					'justify' 	=> [
						'title' => esc_html__( 'Justified', 'exclusive-addons-elementor-pro' ),
						'icon' 	=> 'eicon-text-align-justify'
					]
				],
				'default'       => 'center',
				'selectors'     => [
					'{{WRAPPER}} .exad-business-hours-heading' => 'text-align: {{VALUE}};'
				]
			]
		);

		$this->add_responsive_control(
            'exad_business_hours_heading_padding',
            [
				'label'      => __('Padding', 'exclusive-addons-elementor-pro'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors'  => [
                    '{{WRAPPER}} .exad-business-hours-heading' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->add_responsive_control(
            'exad_business_hours_heading_margin',
            [
				'label'        => __('Margin', 'exclusive-addons-elementor-pro'),
				'type'         => Controls_Manager::DIMENSIONS,
				'size_units'   => ['px', '%'],
				'default'      => [
					'top'      => '0',
					'right'    => '0',
					'bottom'   => '20',
					'left'     => '0',
					'isLinked' => false
				],
                'selectors'    => [
                    '{{WRAPPER}} .exad-business-hours-heading' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'exad_business_hours_heading_border',
				'selector' => '{{WRAPPER}} .exad-business-hours-heading'
			]
		);

        $this->add_responsive_control(
			'exad_business_hours_heading_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'exclusive-addons-elementor-pro' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .exad-business-hours-heading'=> 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
		);

        $this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'exad_business_hours_heading_box_shadow',
				'selector' => '{{WRAPPER}} .exad-business-hours-heading'
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'exad_section_business_day_style',
			[
				'label' => esc_html__( 'Day', 'exclusive-addons-elementor-pro' ),
				'tab'   => Controls_Manager::TAB_STYLE
			]
		);

		$this->add_control(
			'exad_day_color',
			[
				'label'     => esc_html__( 'Color', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#000000',
				'selectors' => [
					'{{WRAPPER}} .single-business-date' => 'color: {{VALUE}};'
				]
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'exad_business_day_typography',
				'selector' => '{{WRAPPER}} .single-business-date'
			]
		);

		$day_align = is_rtl() ? 'right' : 'left';

        $this->add_responsive_control(
			'exad_business_day_alignment',
			[
				'label'         => esc_html__( 'Alignment', 'exclusive-addons-elementor-pro' ),
				'type'          => Controls_Manager::CHOOSE,
				'label_block'   => true,
				'toggle'        => false,
				'options'       => [
					'left'      => [
						'title' => esc_html__( 'Left', 'exclusive-addons-elementor-pro' ),
						'icon'  => 'eicon-text-align-left'
					],
					'center'    => [
						'title' => esc_html__( 'Center', 'exclusive-addons-elementor-pro' ),
						'icon'  => 'eicon-text-align-center'
					],
					'right'     => [
						'title' => esc_html__( 'Right', 'exclusive-addons-elementor-pro' ),
						'icon'  => 'eicon-text-align-right'
					]
				],
				'default'       => $day_align,
				'selectors'     => [
					'{{WRAPPER}} .business-date span.single-business-date' => 'text-align: {{VALUE}};'
				]
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'exad_section_business_time_style',
			[
				'label' => esc_html__( 'Time', 'exclusive-addons-elementor-pro' ),
				'tab'   => Controls_Manager::TAB_STYLE
			]
		);

		$this->add_control(
			'exad_time_color',
			[
				'label'     => esc_html__( 'Color', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#000000',
				'selectors' => [
					'{{WRAPPER}} .single-business-time' => 'color: {{VALUE}};'
				]
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'exad_business_time_typography',
				'selector' => '{{WRAPPER}} .single-business-time'
			]
		);

		$time_align = is_rtl() ? 'left' : 'right';

		$this->add_responsive_control(
			'exad_business_time_alignment',
			[
				'label'         => esc_html__( 'Alignment', 'exclusive-addons-elementor-pro' ),
				'type'          => Controls_Manager::CHOOSE,
				'label_block'   => true,
				'toggle'        => false,
				'options'       => [
					'left'      => [
						'title' => esc_html__( 'Left', 'exclusive-addons-elementor-pro' ),
						'icon'  => 'eicon-text-align-left'
					],
					'center'    => [
						'title' => esc_html__( 'Center', 'exclusive-addons-elementor-pro' ),
						'icon'  => 'eicon-text-align-center'
					],
					'right'     => [
						'title' => esc_html__( 'Right', 'exclusive-addons-elementor-pro' ),
						'icon'  => 'eicon-text-align-right'
					]
				],
				'default'       => $time_align,
				'selectors'     => [
					'{{WRAPPER}} .business-date span.single-business-time' => 'text-align: {{VALUE}};'
				]
			]
		);

		$this->end_controls_section();
    }

    public function render() {
		$settings = $this->get_settings_for_display();
		$heading  = $settings['exad_business_hours_heading'];
		$this->add_render_attribute( 'business_hours', 'class', 'exad-businesshours-container' );

		$this->add_render_attribute( 'exad_business_hours_heading', 'class', 'exad-business-hours-heading');
		$this->add_inline_editing_attributes( 'exad_business_hours_heading', 'basic' );
		?>

		<div <?php echo $this->get_render_attribute_string( 'business_hours' ); ?>>
		<?php
			$heading ? printf( '<' . Utils::validate_html_tag( $settings['exad_business_hours_heading_tag'] ) . ' ' . $this->get_render_attribute_string( 'exad_business_hours_heading' ) . '>%s</'. Utils::validate_html_tag( $settings['exad_business_hours_heading_tag'] ).'>', wp_kses_post( $heading ) ) : '';
			if ( is_array( $settings['exad_business_hours_repeater'] ) ) :
			?>	
				<div class="exad-businesshours-container-inner">
				<?php
					foreach ( $settings['exad_business_hours_repeater'] as $index => $item ) :	

	                    $each_business_date = 'link_' . $index;
						$this->add_render_attribute( $each_business_date, 'class', [
							'business-date',
							'elementor-repeater-item-'.esc_attr( $item['_id'] )
						] );

						$day_text_key = $this->get_repeater_setting_key( 'exad_business_hours_day', 'exad_business_hours_repeater', $index );
						$this->add_render_attribute( $day_text_key, 'class', 'single-business-date' );
						$this->add_inline_editing_attributes( $day_text_key, 'basic' );

						$time_text_key = $this->get_repeater_setting_key( 'exad_business_hours_time', 'exad_business_hours_repeater', $index );
						$this->add_render_attribute( $time_text_key, 'class', 'single-business-time' );
						$this->add_inline_editing_attributes( $time_text_key, 'basic' );
						?>

						<div <?php echo $this->get_render_attribute_string( $each_business_date ); ?>>
							<span <?php echo $this->get_render_attribute_string( $day_text_key ); ?>><?php echo wp_kses_post( $item['exad_business_hours_day'] ); ?></span>
							<span <?php echo $this->get_render_attribute_string( $time_text_key ); ?>><?php echo wp_kses_post( $item['exad_business_hours_time'] ); ?></span>
						</div>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>
		</div>
	<?php	
    }

    /**
     * Render business hours widget output in the editor.
     *
     * Written as a Backbone JavaScript template and used to generate the live preview.
     *
     * @since 1.0.0
     * @access protected
     */
    protected function content_template() {
        ?>
        <#
            view.addRenderAttribute( 'businessHours', 'class', 'exad-businesshours-container' );
            
            view.addRenderAttribute( 'exad_business_hours_heading', 'class', 'exad-business-hours-heading' );
            view.addInlineEditingAttributes( 'exad_business_hours_heading', 'basic' );
			var businessHeadingHTMLTag = elementor.helpers.validateHTMLTag( settings.exad_business_hours_heading_tag );
        #>
            <div {{{ view.getRenderAttributeString( 'businessHours' ) }}}>
            	<# if ( settings.exad_business_hours_heading ) { #>
	            	<{{{ businessHeadingHTMLTag }}} {{{ view.getRenderAttributeString( 'exad_business_hours_heading' ) }}}>
	                	{{{ settings.exad_business_hours_heading }}}
	                </{{{ businessHeadingHTMLTag }}}>
                <# } #>

                <# if ( settings.exad_business_hours_repeater.length ) { #>
	                <div class="exad-businesshours-container-inner">
	                    <# _.each( settings.exad_business_hours_repeater, function( item, index ) {
	                        var dayTextKey = view.getRepeaterSettingKey( 'exad_business_hours_day', 'exad_business_hours_repeater', index );
	                        view.addRenderAttribute( dayTextKey, 'class', 'single-business-date' );
	                        view.addInlineEditingAttributes( dayTextKey, 'basic' );

	                        var timeTextKey = view.getRepeaterSettingKey( 'exad_business_hours_time', 'exad_business_hours_repeater', index );
	                        view.addRenderAttribute( timeTextKey, 'class', 'single-business-time' );
	                        view.addInlineEditingAttributes( timeTextKey, 'basic' ); 

	                        var eachBusinessDate = 'link_' + index;
	                        view.addRenderAttribute( eachBusinessDate, {
								'class': [ 
									'business-date', 
									'elementor-repeater-item-' + item._id 
								]
							} );
	                    #>
		                    <div {{{ view.getRenderAttributeString( eachBusinessDate ) }}}>
		                        <span {{{ view.getRenderAttributeString( dayTextKey ) }}}>{{{ item.exad_business_hours_day }}}</span>
		                        <span {{{ view.getRenderAttributeString( timeTextKey ) }}}>{{{ item.exad_business_hours_time }}}</span>
		                    </div>
	                    <# } ); #>
	                </div>
                <# } #>
            </div>

        <?php
    }

  
}