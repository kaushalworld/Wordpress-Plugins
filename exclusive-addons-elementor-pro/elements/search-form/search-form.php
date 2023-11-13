<?php
namespace ExclusiveAddons\Elements;

if ( ! defined( 'ABSPATH' ) ) exit;

use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Background;
use \Elementor\Group_Control_Box_Shadow;
use \Elementor\Group_Control_Typography;
use \Elementor\Utils;
use \Elementor\Widget_Base;
use \Elementor\Group_Control_Border;

class Search_Form extends Widget_Base {
	
	public function get_name() {
		return 'exad-search-form';
	}

	public function get_title() {
		return __( 'Search Form', 'exclusive-addons-elementor-pro' );
	}

	public function get_icon() {
		return 'exad exad-logo exad-search-form';
	}

	public function get_categories() {
		return [ 'exclusive-addons-elementor' ];
	}

	public function get_keywords() {
		return [ 'search', 'form' ];
	}

	protected function register_controls() {
		
		$this->start_controls_section(
			'section_general_fields',
			[
				'label' => __( 'Search Box', 'exclusive-addons-elementor-pro' ),
			]
		);

		$this->add_control(
			'enable_icon',
			[
				'label'        => __( 'Enable Icon', 'exclusive-addons-elementor-pro' ),
				'type'         => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default'      => 'yes'
			]
		);

		$this->add_control(
			'placeholder',
			[
				'label'       => __( 'Placeholder', 'exclusive-addons-elementor-pro' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => __( 'Search', 'exclusive-addons-elementor-pro' ) . '...'
			]
		);

		$this->add_control(
			'search_button',
			[
				'label'     => __( 'Button', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before'
			]
		);

		$this->add_control(
			'button_type',
			[
				'label'   => __( 'Type', 'exclusive-addons-elementor-pro' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'icon',
				'options' => [
					'icon' => __( 'Icon', 'exclusive-addons-elementor-pro' ),
					'text' => __( 'Text', 'exclusive-addons-elementor-pro' )
				]
			]
		);

		$this->add_control(
			'button_text',
			[
				'label'     => __( 'Text', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => __( 'Search', 'exclusive-addons-elementor-pro' ),
				'condition' => [
					'button_type' => 'text'
				]
			]
		);

		$this->add_control(
			'button_icon',
			[
				'label'   => __( 'Icon', 'exclusive-addons-elementor-pro' ),
				'type'    => Controls_Manager::CHOOSE,
				'default' => 'eicon-search',
				'options' => [
					'eicon-search'    => [
						'title' => __( 'Search', 'exclusive-addons-elementor-pro' ),
						'icon'  => 'eicon-search'
					],
					'eicon-arrow-right'     => [
						'title' => __( 'Arrow', 'exclusive-addons-elementor-pro' ),
						'icon'  => 'eicon-arrow-right'
					]
				],
				'condition'       => [
					'button_type' => 'icon'
				]
			]
		);

		$this->add_responsive_control(
			'size',
			[
				'label'       => __( 'Size', 'exclusive-addons-elementor-pro' ),
				'type'        => Controls_Manager::SLIDER,
				'default'     => [
					'size'    => 50
				],
				'selectors'   => [
					'{{WRAPPER}} .exad-search-form-container' => 'min-height: {{SIZE}}{{UNIT}}',
					'{{WRAPPER}} .exad-search-submit'      => 'min-width: {{SIZE}}{{UNIT}}',
					'{{WRAPPER}} .exad-search-form-input' => 'padding-left: calc({{SIZE}}{{UNIT}} / 5); padding-right: calc({{SIZE}}{{UNIT}} / 5)'
				]
			]
		);

		$this->end_controls_section();

		/**
		 * Register Search Style Controls.
		 *
		 * @since 1.5.0
		 * @access protected
		 */
		$this->start_controls_section(
			'section_input_style',
			[
				'label' => __( 'Input', 'exclusive-addons-elementor-pro' ),
				'tab'   => Controls_Manager::TAB_STYLE
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'input_typography',
				'selector' => '{{WRAPPER}} input[type="search"].exad-search-form-input'
			]
        );
        
        $this->add_responsive_control(
			'exad_search_input_padding',
			[
				'label' => __( 'Padding', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .exad-search-form-input' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
        );

		$this->start_controls_tabs( 'tabs_input_colors' );

		$this->start_controls_tab(
			'input_normal',
			[
				'label'       => __( 'Normal', 'exclusive-addons-elementor-pro' ),
			]
		);

		$this->add_control(
			'input_text_color',
			[
				'label'       => __( 'Text Color', 'exclusive-addons-elementor-pro' ),
				'type'        => Controls_Manager::COLOR,
				'selectors'   => [
					'{{WRAPPER}} .exad-search-form-input' => 'color: {{VALUE}}'
				]
			]
		);

		$this->add_control(
			'input_placeholder_color',
			[
				'label'       => __( 'Placeholder Color', 'exclusive-addons-elementor-pro' ),
				'type'        => Controls_Manager::COLOR,
				'selectors'   => [
					'{{WRAPPER}} .exad-search-form-input::placeholder' => 'color: {{VALUE}}'
				],
				'default'     => '#cccccc'
			]
		);

		$this->add_control(
			'input_background_color',
			[
				'label'       => __( 'Background Color', 'exclusive-addons-elementor-pro' ),
				'type'        => Controls_Manager::COLOR,
				'default'     => '#ededed',
				'selectors'   => [
					'{{WRAPPER}} .exad-search-form-input' => 'background-color: {{VALUE}}'
				]
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'        => 'input_box_shadow',
				'selector'    => '{{WRAPPER}} .exad-search-form-container, {{WRAPPER}} input.exad-search-form-input'
			]
		);

		$this->add_control(
			'border_style',
			[
				'label'       => __( 'Border Style', 'exclusive-addons-elementor-pro' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => 'none',
				'label_block' => false,
				'options'     => [
					'none'    => __( 'None', 'exclusive-addons-elementor-pro' ),
					'solid'   => __( 'Solid', 'exclusive-addons-elementor-pro' ),
					'double'  => __( 'Double', 'exclusive-addons-elementor-pro' ),
					'dotted'  => __( 'Dotted', 'exclusive-addons-elementor-pro' ),
					'dashed'  => __( 'Dashed', 'exclusive-addons-elementor-pro' )
				],
				'selectors'   => [
					'{{WRAPPER}} .exad-search-form-container' => 'border-style: {{VALUE}};'
				]
			]
		);

		$this->add_control(
			'border_color',
			[
				'label'       => __( 'Border Color', 'exclusive-addons-elementor-pro' ),
				'type'        => Controls_Manager::COLOR,
				'condition'   => [
					'border_style!' => 'none'
				],
				'default'     => '',
				'selectors'   => [
					'{{WRAPPER}} .exad-search-form-container' => 'border-color: {{VALUE}};'
				]
			]
		);

		$this->add_responsive_control(
			'border_width',
			[
				'label'       => __( 'Border Width', 'exclusive-addons-elementor-pro' ),
				'type'        => Controls_Manager::DIMENSIONS,
				'size_units'  => [ 'px' ],
				'default'     => [
					'top'     => '1',
					'bottom'  => '1',
					'left'    => '1',
					'right'   => '1',
					'unit'    => 'px'
				],
				'condition'   => [
					'border_style!' => 'none'
				],
				'selectors'   => [
					'{{WRAPPER}} .exad-search-form-container' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
		);

		$this->add_responsive_control(
			'border_radius',
			[
				'label'       => __( 'Border Radius', 'exclusive-addons-elementor-pro' ),
				'type'        => Controls_Manager::SLIDER,
				'range'       => [
					'px'      => [
						'min' => 0,
						'max' => 200
					]
				],
				'selectors'   => [
					'{{WRAPPER}} .exad-search-form-container' => 'border-radius: {{SIZE}}{{UNIT}}'
				],
				'separator'   => 'before'
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'input_focus',
			[
				'label'       => __( 'Focus', 'exclusive-addons-elementor-pro' )
			]
		);

		$this->add_control(
			'input_text_color_focus',
			[
				'label'       => __( 'Text Color', 'exclusive-addons-elementor-pro' ),
				'type'        => Controls_Manager::COLOR,
				'selectors'   => [
					'{{WRAPPER}} .exad-input-focus .exad-search-form-input:focus, {{WRAPPER}} .exad-search-button-wrapper input[type=search]:focus' => 'color: {{VALUE}}'
				]
			]
		);

		$this->add_control(
			'input_placeholder_color_focus',
			[
				'label'     => __( 'Placeholder Color', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .exad-search-form-input:focus::placeholder' => 'color: {{VALUE}}'
				]
			]
		);

		$this->add_control(
			'input_background_color_focus',
			[
				'label'       => __( 'Background Color', 'exclusive-addons-elementor-pro' ),
				'type'        => Controls_Manager::COLOR,
				'selectors'   => [
					'{{WRAPPER}} .exad-input-focus .exad-search-form-input:focus, {{WRAPPER}} .exad-search-form-input:focus' => 'background-color: {{VALUE}}'
				]
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'           => 'input_box_shadow_focus',
				'selector'       =>
				'{{WRAPPER}} .exad-search-button-wrapper.exad-input-focus .exad-search-form-container,
				 {{WRAPPER}} .exad-search-button-wrapper.exad-input-focus input.exad-search-form-input'
			]
		);

		$this->add_control(
			'input_border_color_focus',
			[
				'label'       => __( 'Border Color', 'exclusive-addons-elementor-pro' ),
				'type'        => Controls_Manager::COLOR,
				'selectors'   => [
					'{{WRAPPER}} .exad-input-focus .exad-search-form-container,
					 {{WRAPPER}} .exad-input-focus .exad-search-icon-toggle .exad-search-form-input' => 'border-color: {{VALUE}}'
				]
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		$this->start_controls_section(
			'button_style',
			[
				'label'      => __( 'Button', 'exclusive-addons-elementor-pro' ),
				'tab'        => Controls_Manager::TAB_STYLE
			]
		);

		$this->add_responsive_control(
			'icon_size',
			[
				'label'       => __( 'Icon Size', 'exclusive-addons-elementor-pro' ),
				'type'        => Controls_Manager::SLIDER,
				'range'       => [
					'px'      => [
						'min' => 0,
						'max' => 100
					]
				],
				'default'     => [
					'size'    => '16',
					'unit'    => 'px'
				],
				'selectors'   => [
					'{{WRAPPER}} .exad-search-submit i' => 'font-size: {{SIZE}}{{UNIT}}'
				],
				'condition'   => [
					'button_type' => 'icon'
				]
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'button_typography',
				'selector'  => '{{WRAPPER}} .exad-search-form-container.button-type-text .exad-search-submit',
				'condition' => [
					'button_type' => 'text'
				]
			]
		);

		$this->add_responsive_control(
			'button_width',
			[
				'label'        => __( 'Width', 'exclusive-addons-elementor-pro' ),
				'type'         => Controls_Manager::SLIDER,
				'range'        => [
					'px'       => [
						'max'  => 500,
						'step' => 5
					]
				],
				'selectors'    => [
					'{{WRAPPER}} .exad-search-form-container .exad-search-submit' => 'width: {{SIZE}}{{UNIT}}',
					'{{WRAPPER}} .exad-close-icon-yes button#clear_with_button' => 'right: {{SIZE}}{{UNIT}}'
				]
			]
		);

		$this->start_controls_tabs( 'button_style_tabs' );

		$this->start_controls_tab(
			'button_normal',
			[
				'label' => __( 'Normal', 'exclusive-addons-elementor-pro' )
			]
		);

		$this->add_control(
			'button_color',
			[
				'label'     => __( 'Color', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} button.exad-search-submit' => 'color: {{VALUE}}'
				]
			]
		);

		$this->add_control(
			'button_background_color',
			[
				'label'     => __( 'Background Color', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#818a91',
				'selectors' => [
					'{{WRAPPER}} .exad-search-submit' => 'background-color: {{VALUE}}'
				]
			]
        );
        
        $this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'exad_search_button_border',
				'label' => __( 'Border', 'exclusive-addons-elementor-pro' ),
				'selector' => '{{WRAPPER}} .exad-search-submit',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'button_hover',
			[
				'label' => __( 'Hover', 'exclusive-addons-elementor-pro' )
			]
		);

		$this->add_control(
			'button_color_hover',
			[
				'label'     => __( 'Text Color', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .exad-search-submit:hover' => 'color: {{VALUE}}'
				]
			]
		);

		$this->add_control(
			'button_background_color_hover',
			[
				'label'     => __( 'Background Color', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .exad-search-submit:hover' => 'background-color: {{VALUE}}'
				]
			]
        );
        
        $this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'exad_search_button_border_hover',
				'label' => __( 'Border', 'exclusive-addons-elementor-pro' ),
				'selector' => '{{WRAPPER}} .exad-search-submit:hover',
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

	}

	protected function render() {
		$settings = $this->get_settings_for_display();

		$this->add_render_attribute(
			'input', [
				'placeholder' => $settings['placeholder'],
				'class' => 'exad-search-form-input',
				'type' => 'search',
				'name' => 's',
				'title' => __( 'Search', 'exclusive-addons-elementor-pro' ),
				'value' => get_search_query()
			]
		);

		$this->add_render_attribute(
			'wrapper',
			[
				'class' => 'exad-search-form-container button-type-'.esc_attr( $settings['button_type'] ),
				'role'  => 'tablist'
			]
		);

		$this->add_render_attribute( 'form', 'class', 'exad-search-button-wrapper' );

		$this->add_render_attribute(
			'form', [
				'class' => 'exad-search-type-text',
				'role' => 'search',
				'action' => get_home_url(),
				'method' => 'get'
			]
		);
    	?>

    	<form <?php echo $this->get_render_attribute_string( 'form' ); ?>>
			<div <?php echo wp_kses_post( $this->get_render_attribute_string( 'wrapper' ) ); ?>>
				<input <?php echo $this->get_render_attribute_string( 'input' ); ?>>
					<button class="exad-search-submit" type="submit">
						<?php if ( 'icon' === $settings['button_type'] ) : ?>
							<i class="<?php echo esc_attr( $settings['button_icon'] );?>" aria-hidden="true"></i>
						<?php elseif ( ! empty( $settings['button_text'] ) ) : ?>
							<?php echo esc_html( $settings['button_text'] ); ?>
						<?php endif; ?>
					</button>
			</div>
		</form>

    	<?php    
	}

}
