<?php
namespace ExclusiveAddons\Elements;

if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.

use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Typography;
use \Elementor\Widget_Base;
use \Elementor\Group_Control_Box_Shadow;
use \Elementor\Group_Control_Border;
use \Elementor\Group_Control_Background;
use \Elementor\Group_Control_Css_Filter; 

class Site_Logo extends Widget_Base {

	public function get_name() {
		return 'exad-site-logo';
	}

	public function get_title() {
		return esc_html__( 'Site Logo', 'exclusive-addons-elementor-pro' );
	}

	public function get_icon() {
		return 'exad exad-logo exad-site-title';
	}

   	public function get_categories() {
		return [ 'exclusive-addons-elementor' ];
	}

	public function get_keywords() { 
		return [ 'site', 'title', 'logo', 'image', 'name' ];
	}

	protected function register_controls() {

		if ( !has_custom_logo() ) {
		    $this->start_controls_section(
			    'exad_site_logo_panel_notice',
			    [
				    'label' => __('Notice!', 'exclusive-addons-elementor-pro'),
			    ]
		    );

		    $this->add_control(
			    'exad_site_logo_panel_notice_text',
			    [
				    'type'            => Controls_Manager::RAW_HTML,
				    'raw'             => sprintf( __( 'Please go to the <a href="%s" target="_blank">Customizer</a> and Site Identity to manage your site logo.', 'exclusive-addons-elementor-pro' ), admin_url( 'customize.php' ) ),
				    'content_classes' => 'exad-panel-notice',
			    ]
		    );

            $this->end_controls_section();
            
		    return;
        }

		
		$this->start_controls_section(
			'exad_site_logo_style',
            [
				'label' => esc_html__( 'Style', 'exclusive-addons-elementor-pro' ),
				'tab'   => Controls_Manager::TAB_STYLE
			]
		);

		$this->add_responsive_control(
			'exad_site_logo_width',
			[
				'label' => __( 'Width', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
						'step' => 5,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default' => [
					'unit' => '%',
					'size' => 100,
				],
				'selectors' => [
					'{{WRAPPER}} .exad-site-logo img' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'exad_site_logo_max_width',
			[
				'label' => __( 'Max Width', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
						'step' => 5,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default' => [
					'unit' => '%',
					'size' => 100,
				],
				'selectors' => [
					'{{WRAPPER}} .exad-site-logo img' => 'max-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'exad_site_logo_alignment',
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
				'selectors_dictionary' => [
					'left' => 'display: flex; justify-content: flex-start;',
					'center' => 'display: flex; justify-content: center;',
					'right' => 'display: flex; justify-content: flex-end;',
				],
				'default' => 'center',
				'selectors' => [
					'{{WRAPPER}} .exad-site-logo .custom-logo-link' => '{{VALUE}};'
				]
			]
		);

		$this->add_responsive_control(
			'exad_site_logo_height',
			[
				'label' => __( 'Height', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 200,
						'step' => 1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .exad-site-logo img' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'exad_site_logo_object_fit',
			[
				'label' => __( 'Object Fit', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'default',
				'options' => [
					'default'  => __( 'Default', 'exclusive-addons-elementor-pro' ),
					'cover' => __( 'Cover', 'exclusive-addons-elementor-pro' ),
					'contain' => __( 'Contain', 'exclusive-addons-elementor-pro' ),
					'fill' => __( 'Fill', 'exclusive-addons-elementor-pro' ),
				],
				'selectors' => [
					'{{WRAPPER}} .exad-site-logo img' => 'object-fit: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'exad_site_logo_padding',
			[
				'label' => __( 'Padding', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .exad-site-logo img' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'exad_site_logo_border_radius',
			[
				'label' => __( 'Border Radius', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .exad-site-logo img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs('exad_site_logo_tabs');

            // Normal item
            $this->start_controls_tab('exad_site_logo_normal', ['label' => esc_html__('Normal', 'exclusive-addons-elementor-pro')]);

				$this->add_group_control(
					Group_Control_Background::get_type(),
					[
						'name' => 'exad_site_logo_background',
						'label' => __( 'Background', 'exclusive-addons-elementor-pro' ),
						'types' => [ 'classic', 'gradient' ],
						'selector' => '{{WRAPPER}} .exad-site-logo img',
					]
				);

				$this->add_group_control(
					Group_Control_Border::get_type(),
					[
						'name' => 'exad_site_logo_border',
						'label' => __( 'Border', 'exclusive-addons-elementor-pro' ),
						'selector' => '{{WRAPPER}} .exad-site-logo img',
					]
				);
		
				$this->add_group_control(
					Group_Control_Box_Shadow::get_type(),
					[
						'name' => 'exad_site_logo_box_shadow',
						'label' => __( 'Box Shadow', 'exclusive-addons-elementor-pro' ),
						'selector' => '{{WRAPPER}} .exad-site-logo img',
					]
				);

				$this->add_group_control(
					Group_Control_Css_Filter::get_type(),
					[
						'name' => 'exad_site_logo_css_filter',
						'selector' => '{{WRAPPER}} .exad-site-logo img',
					]
				);

            $this->end_controls_tab();

            // Hover item
            $this->start_controls_tab('exad_site_logo_hover', ['label' => esc_html__('Hover', 'exclusive-addons-elementor-pro')]);

				$this->add_group_control(
					Group_Control_Background::get_type(),
					[
						'name' => 'exad_site_logo_background_hover',
						'label' => __( 'Background', 'exclusive-addons-elementor-pro' ),
						'types' => [ 'classic', 'gradient' ],
						'selector' => '{{WRAPPER}} .exad-site-logo img:hover',
					]
				);

				$this->add_group_control(
					Group_Control_Border::get_type(),
					[
						'name' => 'exad_site_logo_border_hover',
						'label' => __( 'Border', 'exclusive-addons-elementor-pro' ),
						'selector' => '{{WRAPPER}} .exad-site-logo img:hover',
					]
				);
		
				$this->add_group_control(
					Group_Control_Box_Shadow::get_type(),
					[
						'name' => 'exad_site_logo_box_shadow_hover',
						'label' => __( 'Box Shadow', 'exclusive-addons-elementor-pro' ),
						'selector' => '{{WRAPPER}} .exad-site-logo img:hover',
					]
				);
				$this->add_group_control(
					Group_Control_Css_Filter::get_type(),
					[
						'name' => 'exad_site_logo_css_filter_hover',
						'selector' => '{{WRAPPER}} .exad-site-logo img:hover',
					]
				);
                
            $this->end_controls_tab();

        $this->end_controls_tabs();
			
		$this->end_controls_section();
	}

	protected function render() {

		$settings = $this->get_settings_for_display();
        ?>
			<div class="exad-site-logo">
				<?php if ( function_exists( 'the_custom_logo' ) && has_custom_logo() ) {
					the_custom_logo();
				} else {
					_e( 'Please Select a Site Logo From Customizer', 'exclusive-addons-elementor-pro' ); ?>
				<?php } ?>
			</div>
        <?php
	}
}
