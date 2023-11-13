<?php
namespace ExclusiveAddons\Elements;

if ( ! defined( 'ABSPATH' ) ) exit;

use Elementor\Controls_Manager;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Group_Control_Css_Filter;
use Elementor\Group_Control_Typography;
use \Elementor\Widget_Base;

class Lottie_Animation extends Widget_Base {

    public function get_name() {
        return 'exad-lottie-animation';
    }

    public function get_title() {
        return esc_html__( 'Lottie Animation', 'exclusive-addons-elementor-pro' );
    }

    public function get_icon() {
        return 'exad exad-logo exad-lottie';
    }

    public function get_categories() {
        return [ 'exclusive-addons-elementor' ];
    }

    public function get_script_depends() {
        return [ 'exad-lottie' ];
    }

    protected function register_controls() {
        $exad_primary_color = get_option( 'exad_primary_color_option', '#7a56ff' );

        $this->start_controls_section( 'exad_lottie_options', [
			'label' => __( 'Lottie Animation', 'exclusive-addons-elementor-pro' ),
		] );

		$this->add_control(
			'exad_lottie_source',
			[
				'label' => __( 'Source', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'exad_lottie_media_file',
				'options' => [
					'exad_lottie_media_file' => __( 'Media File', 'exclusive-addons-elementor-pro' ),
					'exad_lottie_external_url' => __( 'External URL', 'exclusive-addons-elementor-pro' ),
				]
			]
		);

		$this->add_control(
			'exad_lottie_source_external_url',
			[
				'label' => __( 'External URL', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::URL,
				'condition' => [
					'exad_lottie_source' => 'exad_lottie_external_url',
				],
				'dynamic' => [
					'active' => true,
				],
				'placeholder' => __( 'Enter your URL', 'exclusive-addons-elementor-pro' ),
				'default' => [
					'url' => EXAD_PRO_ASSETS_URL . 'exclusive-lottie.json'
				]
			]
		);

		$this->add_control(
			'exad_lottie_source_json',
			[
				'label' => __( 'Upload JSON File', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::MEDIA,
				'media_type' => 'application/json',
				'default' => [
					'url' => EXAD_PRO_ASSETS_URL . 'exclusive-lottie.json'
				],
				'dynamic' => [
					'active' => true,
				],
				'condition' => [
					'exad_lottie_source' => 'exad_lottie_media_file',
				],
			]
        );
        
        $this->add_responsive_control(
			'exad_lottie_align',
			[
				'label' => __( 'Alignment', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left'    => [
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
				'prefix_class' => 'elementor%s-align-',
				'default' => 'center',
			]
		);

		$this->add_control(
			'exad_lottie_caption',
			[
				'label' => __( 'Caption', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::TEXT,
				//'render_type' => 'none',
				'dynamic' => [
					'active' => true,
				],
			]
		);

		$this->add_control(
			'exad_lottie_link_to',
			[
				'label' => __( 'Link', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::SELECT,
				'render_type' => 'none',
				'default' => 'none',
				'options' => [
					'none' => __( 'None', 'exclusive-addons-elementor-pro' ),
					'custom' => __( 'Custom URL', 'exclusive-addons-elementor-pro' ),
				]
			]
		);

		$this->add_control(
			'exad_lottie_custom_link',
			[
				'label' => __( 'Link', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::URL,
				'render_type' => 'none',
				'placeholder' => __( 'Enter your URL', 'exclusive-addons-elementor-pro' ),
				'condition' => [
					'exad_lottie_link_to' => 'custom',
				],
				'dynamic' => [
					'active' => true,
				],
				'default' => [
					'url' => '',
				],
				'show_label' => false,
			]
		);

        $this->end_controls_section();

        $this->start_controls_section( 'exad_lottie_settings', [
			'label' => __( 'Settings', 'exclusive-addons-elementor-pro' ),
		] );

		$this->add_control(
			'exad_lottie_trigger',
			[
				'label' => __( 'Trigger', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'autoplay',
				'options' => [
					'autoplay' => __( 'Autoplay', 'exclusive-addons-elementor-pro' ),
					'on_viewport' => __( 'Viewport', 'exclusive-addons-elementor-pro' ),
					'on_click' => __( 'On Click', 'exclusive-addons-elementor-pro' ),
					'on_hover' => __( 'On Hover', 'exclusive-addons-elementor-pro' ),
					'on_scroll' => __( 'Scroll', 'exclusive-addons-elementor-pro' )
				],
				
			]
		);

		$this->add_control(
			'exad_lottie_loop',
			[
				'label' => __( 'Loop', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::SWITCHER,
				'condition' => [
					'exad_lottie_trigger!' => 'on_scroll',
				]
			]
		);

		$this->add_control(
			'exad_lottie_play_speed',
			[
				'label' => __( 'Play Speed', 'exclusive-addons-elementor-pro' ) . ' (x)',
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'unit' => 'px',
					'size' => 1,
				],
				'range' => [
					'px' => [
						'min' => 0.1,
						'max' => 10,
						'step' => 0.1,
					],
				],
				'size_units' => [ 'px' ],
				'dynamic' => [
					'active' => true,
				],
				
			]
		);

		$this->add_control(
			'exad_lottie_renderer',
			[
				'label' => __( 'Renderer', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'svg',
				'options' => [
					'svg' => __( 'SVG', 'exclusive-addons-elementor-pro' ),
					'canvas' => __( 'Canvas', 'exclusive-addons-elementor-pro' ),
				],
				'separator' => 'before',
				
			]
		);

		// Settings.
		$this->end_controls_section();

		$this->start_controls_section(
			'exad_lottie_style',
			[
				'label' => __( 'Lottie', 'exclusive-addons-elementor-pro' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'exad_lottie_width',
			[
				'label' => __( 'Width', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'unit' => '%',
				],
				'tablet_default' => [
					'unit' => '%',
				],
				'mobile_default' => [
					'unit' => '%',
				],
				'size_units' => [ '%', 'px', 'vw' ],
				'range' => [
					'%' => [
						'min' => 1,
						'max' => 100,
					],
					'px' => [
						'min' => 1,
						'max' => 1000,
					],
					'vw' => [
						'min' => 1,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .exad-lottie-container' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'separator_panel_style',
			[
				'type' => Controls_Manager::DIVIDER,
				'style' => 'thick',
			]
		);

		$this->start_controls_tabs( 'image_effects' );

			$this->start_controls_tab( 'normal',
				[
					'label' => __( 'Normal', 'exclusive-addons-elementor-pro' ),
				]
			);

			$this->add_control(
				'opacity',
				[
					'label' => __( 'Opacity', 'exclusive-addons-elementor-pro' ),
					'type' => Controls_Manager::SLIDER,
					'range' => [
						'px' => [
							'max' => 1,
							'min' => 0.10,
							'step' => 0.01,
						],
					],
					'selectors' => [
						'{{WRAPPER}} .exad-lottie-animation' => 'opacity: {{SIZE}};',
					],
				]
			);

			$this->add_group_control(
				Group_Control_Css_Filter::get_type(),
				[
					'name' => 'css_filters',
					'selector' => '{{WRAPPER}} .exad-lottie-animation',
				]
			);

			// Normal.
			$this->end_controls_tab();

			$this->start_controls_tab( 'hover',
				[
					'label' => __( 'Hover', 'exclusive-addons-elementor-pro' ),
				]
			);

			$this->add_control(
				'opacity_hover',
				[
					'label' => __( 'Opacity', 'exclusive-addons-elementor-pro' ),
					'type' => Controls_Manager::SLIDER,
					'range' => [
						'px' => [
							'max' => 1,
							'min' => 0.10,
							'step' => 0.01,
						],
					],
					'selectors' => [
						'{{WRAPPER}} .exad-lottie-animation:hover' => 'opacity: {{SIZE}};',
					],
				]
			);

			$this->add_group_control(
				Group_Control_Css_Filter::get_type(),
				[
					'name' => 'css_filters_hover',
					'selector' => '{{WRAPPER}} .exad-lottie-animation:hover',
				]
			);

			$this->add_control(
				'background_hover_transition',
				[
					'label' => __( 'Transition Duration', 'exclusive-addons-elementor-pro' ),
					'type' => Controls_Manager::SLIDER,
					'range' => [
						'px' => [
							'max' => 3,
							'step' => 0.1,
						],
					],
					'selectors' => [
						'{{WRAPPER}} .exad-lottie-animation:hover' => 'transition: {{SIZE}}s',
					],
				]
			);

			// Hover.
			$this->end_controls_tab();

		// Image effects.
		$this->end_controls_tabs();
		
		$this->add_responsive_control(
			'transform_rotate',
			[
				'label' => __( 'Rotate', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 360,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .exad-lottie-animation' => 'transform: rotate({{SIZE}}deg); -ms-transform: rotate({{SIZE}}deg);'
				],
			]
		);

		// lottie style.
		$this->end_controls_section();

		$this->start_controls_section(
			'exad_lottie_section_style_caption',
			[
				'label' => __( 'Caption', 'exclusive-addons-elementor-pro' ),
				'tab'   => Controls_Manager::TAB_STYLE
			]
		);

		$this->add_control(
			'exad_lottie_caption_position',
			[
				'label' => __( 'Position', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'bottom',
				'options' => [
					'top' => __( 'Top', 'exclusive-addons-elementor-pro' ),
					'bottom' => __( 'Bottom', 'exclusive-addons-elementor-pro' ),
				]
			]
		);

		$this->add_control(
			'exad_lottie_caption_align',
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
				'selectors' => [
					'{{WRAPPER}} .exad-lottie-caption' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'exad_lottie_text_color',
			[
				'label' => __( 'Text Color', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::COLOR,
				'default' => $exad_primary_color,
				'selectors' => [
					'{{WRAPPER}} .exad-lottie-caption' => 'color: {{VALUE}};',
				],
				'global' => [
					'default' => Global_Colors::COLOR_TEXT,
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'exad_lottie_caption_typography',
				'selector' => '{{WRAPPER}} .exad-lottie-caption',
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_TEXT,
				],
			]
		);

		$this->add_responsive_control(
			'exad_lottie_caption_space',
			[
				'label' => __( 'Spacing', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .exad-lottie-caption' => 'margin-top: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

    }

	protected function render() {
		$settings = $this->get_settings_for_display();

		$this->add_render_attribute( 
            'exad-lottie-animation', 
            [ 
				'id' => 'exad-lottie-init-'.$this->get_id(),
				'class' => "exad-lottie-animation",
				'data-lottie-source' => esc_attr( $settings['exad_lottie_source'] ),
				'data-lottie-renderer' => esc_attr( $settings['exad_lottie_renderer'] ),
				'data-lottie-trigger' => esc_attr( $settings['exad_lottie_trigger'] )
            ]
		);

		if ( isset( $settings['exad_lottie_play_speed'] ) ) {
			$this->add_render_attribute( 'exad-lottie-animation', 'data-lottie-speed', esc_attr( $settings['exad_lottie_play_speed']['size'] ) );
		} 

		if ( $settings['exad_lottie_loop'] === 'yes' ) {
			$this->add_render_attribute( 'exad-lottie-animation', 'data-lottie-loop', 'true' );
		} else {
			$this->add_render_attribute( 'exad-lottie-animation', 'data-lottie-loop', 'false' );
		}
		
		if ( $settings['exad_lottie_source'] === 'exad_lottie_media_file' ) {
			$this->add_render_attribute( 'exad-lottie-animation', 'data-lottie-source-json', esc_url( $settings['exad_lottie_source_json']['url'] ) );
		} elseif( $settings['exad_lottie_source'] === 'exad_lottie_external_url' ) {	
			$this->add_render_attribute( 'exad-lottie-animation', 'data-external-source-url', esc_url( $settings['exad_lottie_source_external_url']['url'] ) );
		}
		
		$lottie_caption = $settings['exad_lottie_caption'] ? '<p class="exad-lottie-caption"> ' . $settings['exad_lottie_caption'] . '</p>' : '';
		$lottie_container = '<div class="exad-lottie-container"> ' . ( $settings["exad_lottie_caption_position"] == "top" ? $lottie_caption : '' )  . ' <div ' . $this->get_render_attribute_string( "exad-lottie-animation" ) . '></div>' . ( $settings["exad_lottie_caption_position"] == "bottom" ? $lottie_caption : '' ) . '</div>';

		if ( ! empty( $settings['exad_lottie_custom_link']['url'] ) && 'custom' === $settings['exad_lottie_link_to'] ) {
			$this->add_link_attributes( 'url', $settings['exad_lottie_custom_link'] );
			$lottie_container = sprintf( '<a class="exad-lottie-container-link" %1$s>%2$s</a>', $this->get_render_attribute_string( 'url' ), $lottie_container );
        }
		echo $lottie_container;
	}
	
	protected function content_template() {
	?>

	<#
		view.addRenderAttribute( 
            'exad-lottie-animation', 
            {
				'id' : 'exad-lottie-init-' + view.getID(),
				'class' : 'exad-lottie-animation',
				'data-lottie-source' : settings.exad_lottie_source,
				'data-lottie-renderer' : settings.exad_lottie_renderer,
				'data-lottie-trigger' : settings.exad_lottie_trigger
			}
		);

		if ( settings.exad_lottie_play_speed !== '' ) {
			view.addRenderAttribute( 'exad-lottie-animation', 'data-lottie-speed', settings.exad_lottie_play_speed.size );
		} 

		if ( settings.exad_lottie_loop === 'yes' ) {
			view.addRenderAttribute( 'exad-lottie-animation', 'data-lottie-loop', 'true' );
		} else {
			view.addRenderAttribute( 'exad-lottie-animation', 'data-lottie-loop', 'false' );
		}
		
		if ( settings.exad_lottie_source === 'exad_lottie_media_file' ) {
			view.addRenderAttribute( 'exad-lottie-animation', 'data-lottie-source-json', settings.exad_lottie_source_json.url );
		} else if ( settings.exad_lottie_source === 'exad_lottie_external_url' ) {	
			view.addRenderAttribute( 'exad-lottie-animation', 'data-external-source-url', settings.exad_lottie_source_external_url.url );
		}

		var lottie_caption = settings.exad_lottie_caption ? '<p class="exad-lottie-caption">' + settings.exad_lottie_caption + '</p>' : '';
		var lottie_container = '<div class="exad-lottie-container">' + ( settings.exad_lottie_caption_position == "top" ? lottie_caption : "" )  + '<div ' + view.getRenderAttributeString( "exad-lottie-animation" ) + '></div>' + ( settings.exad_lottie_caption_position == "bottom" ? lottie_caption : "" ) + '</div>';

		if ( settings.exad_lottie_custom_link.url && 'custom' === settings.exad_lottie_link_to ) {
			lottie_container = '<a class="exad-lottie-container-link" href="' + settings.exad_lottie_custom_link.url + '">' + lottie_container + '</a>';
		}

		print( lottie_container );

	#>

	<?php	
	}

}