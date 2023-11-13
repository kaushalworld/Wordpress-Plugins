<?php
namespace ExclusiveAddons\Elements;

if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.

use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Typography;
use \Elementor\Icons_Manager;
use \Elementor\Widget_Base;
use \Elementor\Group_Control_Text_Shadow;

class Page_Title extends Widget_Base {

	public function get_name() {
		return 'exad-page-title';
	}

	public function get_title() {
		return esc_html__( 'Page Title', 'exclusive-addons-elementor-pro' );
	}

	public function get_icon() {
		return 'exad exad-logo exad-page-title';
	}

   	public function get_categories() {
		return [ 'exclusive-addons-elementor' ];
	}

	public function get_keywords() {
		return [ 'page', 'title' ];
	}

	protected function register_controls() {

  		$this->start_controls_section(
			'page_title_section',
			[
				'label' => __( 'Page Title', 'exclusive-addons-elementor-pro' )
			]
		);

		$this->add_control(
			'page_title_notice',
			[
				'type'            => Controls_Manager::RAW_HTML,
				'raw'             => sprintf( __( '<b>Note:</b> Archive page title will be visible on frontend.', 'exclusive-addons-elementor-pro' ) ),
				'content_classes' => 'elementor-panel-alert elementor-panel-alert-warning'
			]
		);

		$this->add_control(
			'before_title',
			[
				'label'       => esc_html__( 'Before Title', 'exclusive-addons-elementor-pro' ),
				'type'        => Controls_Manager::TEXT
			]
        );

		$this->add_control(
			'after_title',
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
			'custom_link',
			[
				'label'       => __( 'URL', 'exclusive-addons-elementor-pro' ),
				'type'        => Controls_Manager::URL,
				'placeholder' => __( 'https://your-link.com', 'exclusive-addons-elementor-pro' ),
				'label_block' => true
			]
		);

		$this->add_control(
			'tag',
			[
				'label'    => __( 'HTML Tag', 'exclusive-addons-elementor-pro' ),
				'type'     => Controls_Manager::SELECT,
				'default'  => 'h2',
				'options'  => [
					'h1'   => 'H1',
					'h2'   => 'H2',
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
            'page_title_style',
            [
				'label' => esc_html__( 'Title', 'exclusive-addons-elementor-pro' ),
				'tab'   => Controls_Manager::TAB_STYLE
            ]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'title_typography',
				'selector' => '{{WRAPPER}} .exad-page-title'
			]
		);

		$this->add_control(
			'title_color',
			[
				'label'     => esc_html__( 'Color', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .exad-page-title' => 'color: {{VALUE}};'
				]
			]
		);

		$this->add_responsive_control(
			'title_margin',
			[
				'label'      => __( 'Margin', 'exclusive-addons-elementor-pro' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .exad-page-title-wrapper' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
			]
		);

		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name'     => 'title_text_shadow',
				'selector' => '{{WRAPPER}} .exad-page-title'
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
					'{{WRAPPER}} .exad-page-link' => 'justify-content: {{VALUE}};'
				]
			]
		);	

		$this->end_controls_section();

        $this->start_controls_section(
            'page_title_icon_style',
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
                    '{{WRAPPER}} .exad-page-title-icon i' => 'font-size: {{SIZE}}{{UNIT}};'
				]
			]
        );

		$this->add_control(
			'icon_color',
			[
				'label'     => esc_html__( 'Color', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .exad-page-title-icon i' => 'color: {{VALUE}};'
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
					'{{WRAPPER}} .exad-page-title-icon i' => 'margin-right: {{SIZE}}px'
				]
			]
	  	);

		$this->end_controls_section();
	}

	protected function render() {

		$settings = $this->get_settings_for_display();
		$this->add_render_attribute( 'link', 'class', 'exad-page-link' );
		?>
		<div class="exad-page-title-wrapper">
			<?php 
				if( $settings['custom_link']['url'] ) :
		            $this->add_render_attribute( 'link', 'href', esc_url( $settings['custom_link']['url'] ) );
			        if( $settings['custom_link']['is_external'] ) :
			            $this->add_render_attribute( 'link', 'target', '_blank' );
			        endif;
			        if( $settings['custom_link']['nofollow'] ) :
			            $this->add_render_attribute( 'link', 'rel', 'nofollow' );
			        endif;
		        endif;
		        echo '<a '.$this->get_render_attribute_string( 'link' ).'>';
			?>
			
			<?php if ( ! empty( $settings['icon']['value'] ) ) : ?>
	          	<span class="exad-page-title-icon">
	    			<?php Icons_Manager::render_icon( $settings['icon'], [ 'aria-hidden' => 'true' ] ); ?>
	          	</span>
			<?php endif; ?>

			<<?php echo esc_html( $settings['tag'] ); ?> class="exad-page-title">
				<?php if ( ! empty( $settings['before_title'] ) ) : ?>
	    			<?php echo wp_kses_post( $settings['before_title'] ); ?>
				<?php endif; ?>	

				<?php 
					if ( is_archive() || is_home() ) :
						echo wp_kses_post( get_the_archive_title() );
					else :
						echo wp_kses_post( get_the_title() );
					endif;
				?>

				<?php if ( ! empty( $settings['after_title'] ) ) : ?>
	    			<?php echo wp_kses_post( $settings['after_title'] ); ?>
				<?php endif; ?>
			</<?php echo esc_html( $settings['tag'] ); ?>>
			
			<?php  if( $settings['custom_link']['url'] ) : ?>
				</a>
			<?php endif; ?>	
		</div>
		<?php
	}
}