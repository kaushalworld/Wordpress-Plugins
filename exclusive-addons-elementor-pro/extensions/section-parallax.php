<?php

namespace ExclusiveAddons\Elementor\Extensions;

use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Utils;

class Section_Parallax {

    public static function init() {
		add_action( 'elementor/frontend/section/before_render', array( __CLASS__, 'before_render' ) );
        add_action( 'elementor/element/section/section_layout/after_section_end', array( __CLASS__,'register_controls' ),10 );
        add_action( 'elementor/element/print_template', [ __CLASS__, '_print_template'],10,2);
		add_action( 'elementor/section/print_template', [ __CLASS__, '_print_template'],10,2);
		add_action( 'elementor/column/print_template', [ __CLASS__, '_print_template'],10,2);
	}

    public static function register_controls( $section ) {

        $section->start_controls_section(
            'exad_parallax_effect_section',
            [
                'label' => 'Exclusive Parallax Effect <i class="exad-extention-logo exad exad-logo"></i>',
                'tab'   => Controls_Manager::TAB_LAYOUT
            ]
        );
        
        $section->add_control(
            'exad_enable_section_parallax_effect',
            [
				'label'        => __( 'Enable', 'exclusive-addons-elementor-pro' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => 'no',
                'return_value' => 'yes',
                'render_type'  => 'template',
				'label_on'     => __( 'Enable', 'exclusive-addons-elementor-pro' ),
                'label_off'    => __( 'Disable', 'exclusive-addons-elementor-pro' ),
                'prefix_class' => 'exad-parallax-effect-',
            ]
        );

        $section->add_control('exad_parallax_update',
            [
                'label' => '<div class="elementor-update-preview" style="display: block;"><div class="elementor-update-preview-button-wrapper" style="display:block;"><button class="elementor-update-preview-button elementor-button elementor-button-success" style="background: #d30c5c; margin: 0 auto; display:block;">Apply Changes</button></div><div class="elementor-update-preview-title" style="display:block;text-align:center;margin-top: 10px;">'. __( 'Hit the button to apply changes if it hasn\'t already.', 'exclusive-addons-elementor-pro' ) .'</div></div>',
                'type' => Controls_Manager::RAW_HTML
            ]
        );

        $section->add_control(
            'exad_parallax_effect_type',
            [
                'label'        => __( 'Parallax Type', 'exclusive-addons-elementor-pro' ),
                'type'         => Controls_Manager::SELECT,
                'default'      => 'background',
                'options'      => [
                    'background'  => __( 'Background', 'exclusive-addons-elementor-pro' ),
                    'multi-image' => __( 'Multiple Image', 'exclusive-addons-elementor-pro' ),
                ],
                'prefix_class' => 'exad-parallax-effect-type-',
                'condition'    => [
                    'exad_enable_section_parallax_effect' => 'yes',
                ],
            ]
        );
        
        $section->add_control(
			'exad_parallax_effect_background_image',
			[
				'label' => __( 'Background Image', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::MEDIA,
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
                ],
                'dynamic' => [
					'active' => true,
				],
                'condition' => [
                    'exad_enable_section_parallax_effect' => 'yes',
                    'exad_parallax_effect_type' => 'background'
                ]
			]
        );
        
        $section->add_control(
			'exad_parallax_effect_background_speed',
			[
                'label'   => __( 'Scroll Speed', 'exclusive-addons-elementor-pro' ),
                'type'    => Controls_Manager::NUMBER,
                'min'     => 0,
                'max'     => 1,
                'step'    => 0.1,
                'default' => .5,
                'condition' => [
                    'exad_enable_section_parallax_effect' => 'yes',
                    'exad_parallax_effect_type' => 'background'
                ]
			]
        );

        $section->add_control(
			'exad_parallax_effect_z_index',
			[
                'label'   => __( 'Z Index', 'exclusive-addons-elementor-pro' ),
                'type'    => Controls_Manager::NUMBER,
                'min'     => -1000,
                'max'     => 1000,
                'step'    => 1,
                'default' => 0,
                'selectors' => [
					'{{WRAPPER}} .exad-parallax-scene' => 'z-index: {{VALUE}}',
				],
                'condition' => [
                    'exad_enable_section_parallax_effect' => 'yes'
                ]
			]
        );
        
        $repeater = new Repeater();

		$repeater->add_control(
            'exad_parallax_effect_multi_image_title', 
            [
				'label' => __( 'Parallax Title', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Parallax Item' , 'exclusive-addons-elementor-pro' ),
				'label_block' => true,
			]
        );
        
        $repeater->add_control(
			'exad_parallax_effect_multi_image_image',
			[
				'label' => __( 'Parallax Image', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::MEDIA,
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
                ],
                'dynamic' => [
					'active' => true,
				]
			]
        );

        $repeater->add_control(
			'exad_parallax_effect_multi_image_depth',
			[
                'label'   => __( 'Image Depth', 'exclusive-addons-elementor-pro' ),
                'type'    => Controls_Manager::NUMBER,
                'default' => 0.1,
                'min'     => 0,
                'max'     => 1,
                'step'    => 0.1,
			]
        );

        $repeater->add_control(
			'exad_parallax_effect_multi_image_bgp_x',
			[
                'label'   => __( 'Image X Position', 'exclusive-addons-elementor-pro' ),
                'type'    => Controls_Manager::NUMBER,
                'min'     => 0,
                'max'     => 100,
                'default' => 50,
			]
        );

        $repeater->add_control(
			'exad_parallax_effect_multi_image_bgp_y',
			[
                'label'   => __( 'Image Y Position', 'exclusive-addons-elementor-pro' ),
                'type'    => Controls_Manager::NUMBER,
                'min'     => 0,
                'max'     => 100,
                'default' => 50,
			]
        );

        $repeater->add_control(
			'exad_parallax_effect_multi_image_bg_size',
			[
                'label'   => __( 'Image Size', 'exclusive-addons-elementor-pro' ),
                'type'    => Controls_Manager::SELECT,
                'default' => 'auto',
                'options' => [
                    'auto'    => __( 'Auto', 'exclusive-addons-elementor-pro' ),
                    'cover'   => __( 'Cover', 'exclusive-addons-elementor-pro' ),
                    'contain' => __( 'Contain', 'exclusive-addons-elementor-pro' ),
                    'custom' => __( 'Custom', 'exclusive-addons-elementor-pro' ),
                ],
			]
        );

        $repeater->add_responsive_control(
			'exad_parallax_effect_multi_image_bg_size_custom',
			[
                'label'   => __( 'Image Custom Size', 'exclusive-addons-elementor-pro' ),
                'type'    => Controls_Manager::NUMBER,
                'min'     => 0,
                'max'     => 1000,
                'default' => 50,
                'condition' => [
                    'exad_parallax_effect_multi_image_bg_size' => 'custom'
                ]
			]
        );

		$section->add_control(
			'exad_parallax_effect_parallax_item',
			[
				'label' => __( 'Parallax Item', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
                'title_field' => '{{{ exad_parallax_effect_multi_image_title }}}',
                'condition' => [
                    'exad_parallax_effect_type' => 'multi-image',
                    'exad_enable_section_parallax_effect' => 'yes',
                ]
			]
        );

        $section->end_controls_section();

	}

    public static function before_render( $section ) {
        $settings = $section->get_settings();
        $parallax_elements = $section->get_settings('exad_parallax_effect_parallax_item');
        $id = $section->get_id();
              
        if( 'yes' === $settings['exad_enable_section_parallax_effect'] ) {
            $section->add_render_attribute('_wrapper' , 'data-parallax_type' , $settings['exad_parallax_effect_type'] );
        
		    $id = $section->get_id();
            $section->add_render_attribute('scene', 'class', 'exad-parallax-scene' );
            $section->add_render_attribute('scene', 'id', 'exad-parallax-scene-'.$id );
            ?>

            <?php
            if( 'background'=== $settings['exad_parallax_effect_type'] ) {
                $section->add_render_attribute('scene', 'data-parallax', 'scroll' );
                $section->add_render_attribute('scene', 'data-z-index', '0' );
                $section->add_render_attribute('scene', 'data-image-src', $settings['exad_parallax_effect_background_image']['url'] );
                $section->add_render_attribute('scene', 'data-speed', $settings['exad_parallax_effect_background_speed'] );
                $section->add_render_attribute('scene', 'data-parallax-id', 'exad-parallax-'.$id );
            ?>
                <div <?php echo $section->get_render_attribute_string( 'scene' ); ?>>
                </div>
            <?php       
            } else if( 'multi-image'=== $settings['exad_parallax_effect_type'] ) { ?>
                <div <?php echo $section->get_render_attribute_string( 'scene' ); ?>>
                    <?php foreach ( $parallax_elements as $index => $item ) : ?>
                
                        <?php  $image_src = wp_get_attachment_image_src( $item['exad_parallax_effect_multi_image_image']['id'], 'full' );

                        if ($item['exad_parallax_effect_multi_image_bgp_x']) {
                            $section->add_render_attribute( 'item', 'style', 'background-position-x: ' . $item['exad_parallax_effect_multi_image_bgp_x'] . '%;' );
                        }
                        if ($item['exad_parallax_effect_multi_image_bgp_y']) {
                            $section->add_render_attribute( 'item', 'style', 'background-position-y: ' . $item['exad_parallax_effect_multi_image_bgp_y'] . '%;' );
                        }
                        
                        if( $item['exad_parallax_effect_multi_image_bg_size'] === 'custom' ){
                            $section->add_render_attribute( 'item', 'style', 'background-size: ' . $item['exad_parallax_effect_multi_image_bg_size_custom'] . 'px;' );
                        } else{
                            $section->add_render_attribute( 'item', 'style', 'background-size: ' . $item['exad_parallax_effect_multi_image_bg_size'] . ';' );
                        }

                        if ( isset( $image_src[0] ) ) {
                            $section->add_render_attribute( 'item', 'style', 'background-image: url(' . esc_url($image_src[0]) .');' );
                        }
                        ?>
                        
                        <div data-depth="<?php echo $item['exad_parallax_effect_multi_image_depth']; ?>" class="exad-scene-item" <?php echo $section->get_render_attribute_string( 'item' ); ?>></div>
                        
                    <?php endforeach; ?>
                        
                </div>
            <?php            
            }
        }
    }

    public static function _print_template( $template, $widget ) {
		?>
		<?php
		if ( $widget->get_name() != 'section' && $widget->get_name() != 'column' ) {
			return $template;
		}
		$old_template = $template;
		ob_start();
		?>

        <# if ( 'yes' == settings.exad_enable_section_parallax_effect ) {
            view.addRenderAttribute('_wrapper', 'data-parallax_type', settings.exad_parallax_effect_type );

            view.addRenderAttribute('scene', 'class', 'exad-parallax-scene' );
            view.addRenderAttribute('scene', 'id', 'exad-parallax-scene-' + view.getID() );

                if ( 'background' === settings.exad_parallax_effect_type ) {
                    view.addRenderAttribute('scene', 'data-parallax-id', 'exad-parallax-' + view.getID() );
                    view.addRenderAttribute('scene', 'data-parallax', 'scroll' );
                    
                    view.addRenderAttribute('scene', 'data-z-index', '0' );
                    view.addRenderAttribute('scene', 'data-speed', settings.exad_parallax_effect_background_speed );
                #>
                <div {{{ view.getRenderAttributeString( 'scene' ) }}}>
                </div>

                <#    
                } else if( 'multi-image' === settings.exad_parallax_effect_type ) { #>
                    <div {{{ view.getRenderAttributeString( 'scene' ) }}}>
                <#    
                    _.each( settings.exad_parallax_effect_parallax_item, function( item, index ) {
                        if ( item.exad_parallax_effect_multi_image_bgp_x ) {
                            view.addRenderAttribute( 'item', 'style', 'background-position-x: '+item.exad_parallax_effect_multi_image_bgp_x+'%;' );
                        }
                        view.addRenderAttribute( 'item', 'style', 'background-position-y: '+item.exad_parallax_effect_multi_image_bgp_y+'%;' );
                        
                        if ( item.exad_parallax_effect_multi_image_bg_size ) {
                            view.addRenderAttribute( 'item', 'style', 'background-image: url('+item.exad_parallax_effect_multi_image_image.url+');' );
                        }

                        if( item.exad_parallax_effect_multi_image_bg_size === 'custom' ){
                            view.addRenderAttribute( 'item', 'style', 'background-size: ' +item.exad_parallax_effect_multi_image_bg_size_custom+'px;' );
                        } else{
                            view.addRenderAttribute( 'item', 'style', 'background-size: ' +item.exad_parallax_effect_multi_image_bg_size+';' );
                        }
                        
                    #>
                        
                    <div data-depth="{{{ item.exad_parallax_effect_multi_image_depth }}}" class="exad-scene-item" {{{ view.getRenderAttributeString( 'item' ) }}}></div>
                        
                    <# }); #>  
                    </div>   
                <# } #>   
            <# } #>    
            
		<?php
		$slider_content = ob_get_contents();
		ob_end_clean();
		$template = $slider_content . $old_template;
		return $template;
	}

}

Section_Parallax::init();



