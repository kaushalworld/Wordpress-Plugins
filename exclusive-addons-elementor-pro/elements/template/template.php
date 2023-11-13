<?php
namespace ExclusiveAddons\Elements;

if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.

use \Elementor\Controls_Manager;
use \Elementor\Utils;
use \Elementor\Widget_Base;
use \Elementor\Plugin;

class Template extends Widget_Base {
	
	public function get_name() {
		return 'exad-template';
	}

	public function get_title() {
		return esc_html__( 'Template', 'exclusive-addons-elementor-pro' );
	}

	public function get_icon() {
		return 'exad-logo eicon-post-content';
	}

	public function get_categories() {
		return [ 'exclusive-addons-elementor' ];
	}

	public function get_keywords() {
        return [ 'exclusive', 'template', 'page', 'post' ];
    }

	protected function register_controls() {
		
		/**
		* Team Member Content Section
		*/
		$this->start_controls_section(
			'exad_template_content',
			[
				'label' => esc_html__( 'Content', 'exclusive-addons-elementor-pro' )
			]
		);

        $this->add_control(
            'exad_template_content_save_template',
            [
                'label'     => __( 'Select Template', 'exclusive-addons-elementor-pro' ),
                'type'      => Controls_Manager::SELECT,
				'label_block' => true,
                'options'   => $this->get_saved_template( ['page', 'section'] ),
                'default'   => '-1',
            ]
        );

		$this->end_controls_section();

		
	}

    /**
	 *  Get Saved Widgets
	 *
	 *  @param string $type Type.
	 *  @since 0.0.1
	 *  @return string
	 */
	public function get_saved_template( $type = 'page' ) {

		$saved_widgets = $this->get_template( $type );
		$options[-1]   = __( 'Select', 'exclusive-addons-elementor-pro' );
		if ( count( $saved_widgets ) ) :
			foreach ( $saved_widgets as $saved_row ) :
				$options[ $saved_row['id'] ] = $saved_row['name']. ' ( Template )';
			endforeach;
		else :
			$options['no_template'] = __( 'No section template is added.', 'exclusive-addons-elementor-pro' );
		endif;
		return $options;
	}

	/**
	 *  Get Templates based on category
	 *
	 *  @param string $type Type.
	 *  @since 0.0.1
	 *  @return string
	 */
	public function get_template( $type = 'page' ) {
		$posts = get_posts(
			array(
				'post_type'        => 'elementor_library',
				'orderby'          => 'title',
				'order'            => 'ASC',
				'posts_per_page'   => '-1',
				'tax_query'        => array(
					array(
						'taxonomy' => 'elementor_library_type',
						'field'    => 'slug',
						'terms'    => $type
					)
				)
			)
		);

		$templates = array();

		foreach ( $posts as $post ) :
			$templates[] = array(
				'id'   => $post->ID,
				'name' => $post->post_title
			);
		endforeach;
        
		return $templates;
	}

	protected function render() {

        $settings = $this->get_settings_for_display();

        echo Plugin::$instance->frontend->get_builder_content_for_display( wp_kses_post( $settings['exad_template_content_save_template'] ) );

	}
}