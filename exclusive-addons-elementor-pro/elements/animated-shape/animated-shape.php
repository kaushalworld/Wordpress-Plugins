<?php
namespace ExclusiveAddons\Elements;

if ( ! defined( 'ABSPATH' ) ) exit;

use \Elementor\Controls_Manager;
use \Elementor\Widget_Base;
use \Elementor\Group_Control_Image_Size;
use \Elementor\Utils;

class Animated_Shape extends Widget_Base {
	
	public function get_name() {
		return 'exad-animated-shape';
	}

	public function get_title() {
		return esc_html__( 'Animated Shape', 'exclusive-addons-elementor-pro' );
	}

	public function get_icon() {
		return 'exad exad-logo exad-animated-shape';
	}

	public function get_categories() {
		return [ 'exclusive-addons-elementor' ];
	}

	public function get_keywords() {
        return [ 'animated shape', 'shape', 'animated' ];
	}
	
	public function get_script_depends() {
        return [ 'exad-scroll-script', 'exad-animation-script', 'exad-tweenmax-script', 'exad-indicator-script' ];
    }

	protected function register_controls() {
		
		/**
		* animated shape Content Section
		*/
		$this->start_controls_section(
			'exad_animated_shape_content',
			[
				'label' => esc_html__( 'Content', 'exclusive-addons-elementor-pro' )
			]
		);

		$this->add_control(
	        'exad_animated_shape_image',
	        [
				'label'     => esc_html__( 'Image', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::MEDIA,
				'default'   => [
	                'url'   => Utils::get_placeholder_image_src()
	            ],
				'dynamic' => [
					'active' => true,
				]
	        ]
	    );

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name'      => 'animated_shape_thumbnail',
				'default'   => 'medium_large'
			]
		);

		$this->end_controls_section();

		/**
		* animated shape style section
		*/
		$this->start_controls_section(
			'exad_animated_shape_style',
			[
				'label' => esc_html__( 'Style', 'exclusive-addons-elementor-pro' ),
				'tab'   => Controls_Manager::TAB_STYLE
			]
		);
		
		$this->add_control(
			'exad_animation_style',
			[
				'label' => __( 'Animation Style', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'style_1',
				'options' => [
					'style_1'  => __( 'Style 1', 'exclusive-addons-elementor-pro' ),
					'style_2' => __( 'Style 2', 'exclusive-addons-elementor-pro' ),
					'style_3' => __( 'Style 3', 'exclusive-addons-elementor-pro' ),
					'style_4' => __( 'Style 4', 'exclusive-addons-elementor-pro' ),
					'style_5' => __( 'Style 5', 'exclusive-addons-elementor-pro' ),
					'style_6' => __( 'Style 6', 'exclusive-addons-elementor-pro' ),
					'style_7' => __( 'Style 7', 'exclusive-addons-elementor-pro' ),
					'style_8' => __( 'Style 8', 'exclusive-addons-elementor-pro' ),
				],
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
        
    ?>
	<div class="exad-animated-shape">
		<div class="exad-animated-shape-image <?php echo $settings['exad_animation_style']; ?>">
			<?php echo Group_Control_Image_Size::get_attachment_image_html( $settings, 'animated_shape_thumbnail', 'exad_animated_shape_image' ); ?>
		</div>
	</div>
	<?php    
	}

}