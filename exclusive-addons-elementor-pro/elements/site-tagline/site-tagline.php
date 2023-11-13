<?php
namespace ExclusiveAddons\Elements;

if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.

use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Typography;
use \Elementor\Icons_Manager;
use \Elementor\Widget_Base;
use \Elementor\Group_Control_Text_Shadow;

class Site_Tagline extends Widget_Base {

	public function get_name() {
		return 'exad-site-tagline';
	}

	public function get_title() {
		return esc_html__( 'Site Tagline', 'exclusive-addons-elementor-pro' );
	}

	public function get_icon() {
		return 'exad exad-logo exad-site-tagline';
	}

   	public function get_categories() {
		return [ 'exclusive-addons-elementor' ];
	}

	public function get_keywords() {
		return [ 'site', 'title', 'name' ];
	}

	protected function register_controls() {

  		$this->start_controls_section(
			'site_tagline_section',
			[
				'label' => __( 'Site Tagline', 'exclusive-addons-elementor-pro' )
			]
		);

		$this->add_control(
			'before_tagline',
			[
				'label'       => esc_html__( 'Before Title', 'exclusive-addons-elementor-pro' ),
				'type'        => Controls_Manager::TEXT
			]
        );

		$this->add_control(
			'after_tagline',
			[
				'label'       => esc_html__( 'After Title', 'exclusive-addons-elementor-pro' ),
				'type'        => Controls_Manager::TEXT
			]
        );

        $this->add_control(
			'enable_icon',
			[
				'label'        => __( 'Icon', 'exclusive-addons-elementor-pro' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'Show', 'exclusive-addons-elementor-pro' ),
				'label_off'    => __( 'Hide', 'exclusive-addons-elementor-pro' ),
				'return_value' => 'yes',
				'default'      => 'no'
			]
		);

		$this->add_control(
            'icon',
            [
                'label'       => __( 'Icon', 'exclusive-addons-elementor-pro' ),
				'type'        => Controls_Manager::ICONS,
				'default'     => [
                    'value'   => 'fas fa-home',
                    'library' => 'fa-solid'
                ],
				'condition'   => [
					'enable_icon' => 'yes'
				]
            ]
		);

		$this->add_control(
			'link_type',
			[
				'label'   => __( 'Link Type', 'exclusive-addons-elementor-pro' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'default',
				'options' => [
					'default' => __( 'Default', 'exclusive-addons-elementor-pro' ),
					'custom'  => __( 'Custom', 'exclusive-addons-elementor-pro' )
				]
			]
		);

		$this->add_control(
			'custom_link',
			[
				'label'       => __( 'URL', 'exclusive-addons-elementor-pro' ),
				'type'        => Controls_Manager::URL,
				'placeholder' => __( 'https://your-link.com', 'exclusive-addons-elementor-pro' ),
				'label_block' => true,
				'condition'   => [
					'link_type' => 'custom'
				]
			]
		);

		$this->add_control(
			'tag',
			[
				'label'    => __( 'HTML Tag', 'exclusive-addons-elementor-pro' ),
				'type'     => Controls_Manager::SELECT,
				'default'  => 'span',
				'options'  => [
					'h3'   => 'H3',
					'h4'   => 'H4',
					'h5'   => 'H5',
					'h6'   => 'H6',
					'div'  => 'div',
					'span' => 'span',
					'p'    => 'p'
				]
			]
		);

		$this->end_controls_section();

        $this->start_controls_section(
            'site_tagline_style',
            [
				'label' => esc_html__( 'Title', 'exclusive-addons-elementor-pro' ),
				'tab'   => Controls_Manager::TAB_STYLE
            ]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'tagline_typography',
				'selector' => '{{WRAPPER}} .exad-site-tagline'
			]
		);

		$this->add_control(
			'tagline_color',
			[
				'label'     => esc_html__( 'Color', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .exad-site-tagline' => 'color: {{VALUE}};'
				]
			]
		);

		$this->add_responsive_control(
			'tagline_margin',
			[
				'label'      => __( 'Margin', 'exclusive-addons-elementor-pro' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .exad-site-tagline-wrapper' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
			]
		);

		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name'     => 'tagline_text_shadow',
				'selector' => '{{WRAPPER}} .exad-site-tagline'
			]
		);

		$this->add_responsive_control(
			'alignment',
			[
				'label'         => esc_html__( 'Alignment', 'exclusive-addons-elementor-pro' ),
				'type'          => Controls_Manager::CHOOSE,
				'label_block'   => true,
				'toggle'        => false,
				'default' 	     => 'flex-start',
				'options'        => [
					'flex-start' => [
						'title'  => esc_html__( 'Left', 'exclusive-addons-elementor-pro' ),
						'icon'   => 'eicon-text-align-left'
					],
					'center'     => [
						'title'  => esc_html__( 'Center', 'exclusive-addons-elementor-pro' ),
						'icon'   => 'eicon-text-align-center'
					],
					'flex-end'   => [
						'title'  => esc_html__( 'Right', 'exclusive-addons-elementor-pro' ),
						'icon'   => 'eicon-text-align-right'
					]
				],
				'selectors'     => [
					'{{WRAPPER}} .exad-site-link' => 'justify-content: {{VALUE}};'
				]
			]
		);	

		$this->end_controls_section();

        $this->start_controls_section(
            'site_tagline_icon_style',
            [
				'label'     => esc_html__( 'Icon', 'exclusive-addons-elementor-pro' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'enable_icon' => 'yes',
					'icon[value]!' => ''
				]
            ]
		);	

        $this->add_responsive_control(
			'icon_size',
			[
				'label'       => __( 'Size', 'exclusive-addons-elementor-pro' ),
				'type'        => Controls_Manager::SLIDER,
				'size_units'  => [ 'px' ],
				'range'       => [
					'px'      => [
						'min' => 0,
						'max' => 100
					]
				],
				'default'     => [
					'unit'    => 'px',
					'size'    => 30
				],
				'selectors' => [
                    '{{WRAPPER}} .exad-site-tagline-icon i' => 'font-size: {{SIZE}}{{UNIT}};'
				]
			]
        );

		$this->add_control(
			'icon_color',
			[
				'label'     => esc_html__( 'Color', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .exad-site-tagline-icon i' => 'color: {{VALUE}};'
				]
			]
		);

		$this->add_responsive_control(
			'icon_spaching',
			[
				'label'       => esc_html__( 'Icon Spacing', 'exclusive-addons-elementor-pro' ),
				'type'        => Controls_Manager::SLIDER,
				'range'       => [
					'px'      => [
						'max' => 50
					]
				],
				'default'     => [
					'unit'    => 'px',
					'size'    => 10
				],
				'selectors'   => [
					'{{WRAPPER}} .exad-site-tagline-icon i' => 'margin-right: {{SIZE}}px'
				]
			]
	  	);

		$this->end_controls_section();
	}

	protected function render() {

		$settings = $this->get_settings_for_display();
		$this->add_render_attribute( 'link', 'class', 'exad-site-link' );
		?>
		<div class="exad-site-tagline-wrapper">
			<?php if ( 'custom' === $settings['link_type'] ) :
				if( $settings['custom_link']['url'] ) :
		            $this->add_render_attribute( 'link', 'href', esc_url( $settings['custom_link']['url'] ) );
			        if( $settings['custom_link']['is_external'] ) :
			            $this->add_render_attribute( 'link', 'target', '_blank' );
			        endif;
			        if( $settings['custom_link']['nofollow'] ) :
			            $this->add_render_attribute( 'link', 'rel', 'nofollow' );
			        endif;
		        endif;
				?>
		        <a <?php echo $this->get_render_attribute_string( 'link' ); ?>>
			<?php	
		    else :
				$this->add_render_attribute( 'link', 'href', esc_url( get_home_url() ) ); ?>
				<a <?php echo $this->get_render_attribute_string( 'link' ); ?>>
			<?php endif; ?>	
			
			<?php if ( ! empty( $settings['icon']['value'] ) ) : ?>
	          	<span class="exad-site-tagline-icon">
	    			<?php Icons_Manager::render_icon( $settings['icon'], [ 'aria-hidden' => 'true' ] ); ?>
	          	</span>
			<?php endif; ?>	
			<<?php echo esc_html( $settings['tag'] ); ?> class="exad-site-tagline">
				<?php if ( ! empty( $settings['before_tagline'] ) ) : ?>
	    			<?php echo wp_kses_post( $settings['before_tagline'] ); ?>
				<?php endif; ?>	

				<?php echo wp_kses_post( get_bloginfo( 'description' ) ); ?>

				<?php if ( ! empty( $settings['after_tagline'] ) ) : ?>
	    			<?php echo wp_kses_post( $settings['after_tagline'] ); ?>
				<?php endif; ?>	
			</<?php echo esc_html( $settings['tag'] ); ?>>
			</a>
		</div>
		<?php
	}
}
