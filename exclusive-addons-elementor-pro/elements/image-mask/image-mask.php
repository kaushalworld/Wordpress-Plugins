<?php
namespace ExclusiveAddons\Elements;

if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.

use \Elementor\Controls_Manager;
use \Elementor\Control_Media;
use \Elementor\Group_Control_Image_Size;
use \Elementor\Utils;
use \Elementor\Widget_Base;
use \ExclusiveAddons\Elementor\Image_Mask_SVG_Control;
use \ExclusiveAddons\Pro\Elementor\ProHelper;

class Image_Mask extends Widget_Base {

    public function get_name() {
        return 'exad-image-mask';
    }

    public function get_title() {
        return esc_html__( 'Image Mask', 'exclusive-addons-elementor-pro' );
    }

    public function get_icon() {
        return 'exad exad-logo exad-image-mask';
    }

    public function get_categories() {
        return [ 'exclusive-addons-elementor' ];
    }

    protected function register_controls() {

        $this->start_controls_section(
            'exad_image_mask_content',
            [
                'label' => __( 'Content', 'exclusive-addons-elementor-pro' )
            ]
        );

        $this->add_control(
	        'exad_image_mask_content_image',
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
				'name'    => 'exad_image_mask_figure_size',
				'default' => 'full',
				'condition' => [
                    'exad_image_mask_content_image[url]!' => ''
                ]
            ]
        );

        $this->add_control(
			'exad_image_mask_shape_mask_type',
			[
				'label'         => __( 'Mask Shape', 'exclusive-addons-elementor-pro' ),
				'type'          => Controls_Manager::CHOOSE,
				'default'       => 'shape',
				'toggle'        => false,
				'options'       => [
                    'shape'     => [
						'title' => __( 'Shape', 'exclusive-addons-elementor-pro' ),
						'icon'  => 'eicon-info-circle'
					],
					'image'     => [
						'title' => __( 'Image', 'exclusive-addons-elementor-pro' ),
						'icon'  => 'eicon-image-bold'
					]
				]
			]
        );

        $this->add_control(
			'exad_image_mask_shape_mask_shape',
			[
				'label'                => __( 'Mask Shape', 'exclusive-addons-elementor-pro' ),
				'type'                 => Image_Mask_SVG_Control::SVGSELECTOR,
				'options'              => ProHelper::exad_masking_shape_list( 'list' ),
				'default'              => 'shape-1',
				'toggle'               => false,
				'label_block'          => true,
                'selectors_dictionary' => ProHelper::exad_masking_shape_list( 'url' ),
				'selectors'            => [
                    '{{WRAPPER}} .exad-image-mask-figure' => '-webkit-mask-image: url({{VALUE}}); mask-image: url({{VALUE}});'
                ],
                'condition'            => [
                    'exad_image_mask_shape_mask_type' => 'shape'
                ]
			]
        );
        
        $this->add_control(
            'exad_image_mask_shape_mask',
            [
                'label'     => __( 'Shape', 'exclusive-addons-elementor-pro' ),
                'type'      => Controls_Manager::MEDIA,
                'selectors' => [
					'{{WRAPPER}} .exad-image-mask-figure' => '-webkit-mask-image: url({{URL}});'
                ],
				'dynamic' => [
					'active' => true,
				],
                'condition' => [
                    'exad_image_mask_shape_mask_type' => 'image'
                ]
            ]
        );

        $this->add_control(
			'exad_image_mask_shape_position',
			[
				'label'       => __( 'Position', 'exclusive-addons-elementor-pro' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => 'center',
				'label_block' => true,
				'options'     => [
					'top'     => __( 'Top', 'exclusive-addons-elementor-pro' ),
					'center'  => __( 'Center', 'exclusive-addons-elementor-pro' ),
					'left'    => __( 'Left', 'exclusive-addons-elementor-pro' ),
					'right'   => __( 'Right', 'exclusive-addons-elementor-pro' ),
					'bottom'  => __( 'Bottom', 'exclusive-addons-elementor-pro' ),
					'custom'  => __( 'Custom', 'exclusive-addons-elementor-pro' )
                ],
                'selectors'   => [
					'{{WRAPPER}} .exad-image-mask-figure' => '-webkit-mask-position: {{VALUE}};'
				]
			]
		);
		
		$this->add_control(
			'exad_image_mask_shape_position_x_offset',
			[
				'label'       => __( 'X Offset', 'exclusive-addons-elementor-pro' ),
				'type'        => Controls_Manager::SLIDER,
				'size_units'  => [ 'px', '%' ],
				'range'       => [
					'px'      => [
						'min' => 0,
						'max' => 500
					],
					'%'       => [
						'min' => 0,
						'max' => 100
					]
				],
				'selectors'   => [
					'{{WRAPPER}} .exad-image-mask-figure' => '-webkit-mask-position-y: {{SIZE}}{{UNIT}};'
                ],
                'condition'   => [
                    'exad_image_mask_shape_position' => 'custom'
                ]
			]
		);

		$this->add_control(
			'exad_image_mask_shape_position_y_offset',
			[
				'label'       => __( 'Y Offset', 'exclusive-addons-elementor-pro' ),
				'type'        => Controls_Manager::SLIDER,
				'size_units'  => [ 'px', '%' ],
				'range'       => [
					'px'      => [
						'min' => 0,
						'max' => 500
					],
					'%'       => [
						'min' => 0,
						'max' => 100
					]
				],
				'selectors'   => [
					'{{WRAPPER}} .exad-image-mask-figure' => '-webkit-mask-position-x: {{SIZE}}{{UNIT}};'
                ],
                'condition'   => [
                    'exad_image_mask_shape_position' => 'custom'
                ]
			]
		);
        
        $this->add_control(
			'exad_image_mask_shape_size',
			[
				'label'       => __( 'Size', 'exclusive-addons-elementor-pro' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => 'auto',
				'label_block' => true,
				'options'     => [
					'auto'    => __( 'Auto', 'exclusive-addons-elementor-pro' ),
					'contain' => __( 'Contain', 'exclusive-addons-elementor-pro' ),
					'cover'   => __( 'Cover', 'exclusive-addons-elementor-pro' ),
					'custom'  => __( 'Custom', 'exclusive-addons-elementor-pro' )
                ],
                'selectors'   => [
					'{{WRAPPER}} .exad-image-mask-figure' => '-webkit-mask-size: {{VALUE}};'
				]
			]
        );

        $this->add_control(
			'exad_image_mask_shape_custome_size',
			[
				'label'       => __( 'Mask Size', 'exclusive-addons-elementor-pro' ),
				'type'        => Controls_Manager::SLIDER,
				'size_units'  => [ 'px', '%' ],
				'range'       => [
					'px'      => [
						'min' => 0,
						'max' => 600
					],
					'%'       => [
						'min' => 0,
						'max' => 100
					]
				],
				'selectors'   => [
					'{{WRAPPER}} .exad-image-mask-figure' => '-webkit-mask-size: {{SIZE}}{{UNIT}};'
                ],
                'condition'   => [
                    'exad_image_mask_shape_size' => 'custom'
                ]
			]
		);

        $this->add_control(
			'exad_image_mask_shape_repeat',
			[
				'label'         => __( 'Repeat', 'exclusive-addons-elementor-pro' ),
				'type'          => Controls_Manager::SELECT,
				'default'       => 'no-repeat',
				'label_block'   => true,
				'options'       => [
					'no-repeat' => __( 'No repeat', 'exclusive-addons-elementor-pro' ),
					'repeat'    => __( 'Repeat', 'exclusive-addons-elementor-pro' )
                ],
                'selectors'     => [
					'{{WRAPPER}} .exad-image-mask-figure' => '-webkit-mask-repeat: {{VALUE}};'
				]
			]
		);

		$this->add_control(
			'exad_image_mask_shape_flip',
			[
				'label'         => __( 'Shape Flip', 'exclusive-addons-elementor-pro' ),
				'type'          => Controls_Manager::SELECT,
				'default'       => 'none',
				'options'       => [
					'none' => __( 'None', 'exclusive-addons-elementor-pro' ),
					'vertical' => __( 'Vartical', 'exclusive-addons-elementor-pro' ),
					'horizontal'    => __( 'Horizontal', 'exclusive-addons-elementor-pro' )
                ],
			]
		);

        $this->end_controls_section();
    }

    protected function render() {
		$settings = $this->get_settings_for_display();
		?>

        <div class="exad-image-mask-figure exad-image-mask-flip-shape-<?php echo $settings['exad_image_mask_shape_flip']; ?>">
			<?php if ( ! empty( $settings['exad_image_mask_content_image']['url'] ) ) : ?>
				<?php echo Group_Control_Image_Size::get_attachment_image_html( $settings, 'exad_image_mask_figure_size', 'exad_image_mask_content_image' ); ?>
			<?php endif; ?>
        </div>

	<?php	
	}
}