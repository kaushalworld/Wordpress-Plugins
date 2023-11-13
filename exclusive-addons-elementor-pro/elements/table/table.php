<?php
namespace ExclusiveAddons\Elements;

if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.

use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Border;
use \Elementor\Group_Control_Image_Size;
use \Elementor\Group_Control_Typography;
use \Elementor\Group_Control_Box_Shadow;
use \Elementor\Group_Control_Background;
use \Elementor\Icons_Manager;
use \Elementor\Utils;
use \Elementor\Widget_Base;
use \Elementor\Repeater;


class Table extends Widget_Base {

    public function get_name() {
        return 'exad-table';
    }

    public function get_title() {
        return esc_html__( 'Table', 'exclusive-addons-elementor-pro' );
    }

    public function get_icon() {
        return 'exad exad-logo exad-table';
    }

    public function get_categories() {
        return [ 'exclusive-addons-elementor' ];
	}
	
	public function get_keywords() {
	    return [ 'data', 'advanced', 'list' ];
	}

    public function get_script_depends() {
        return [ 'exad-table-script' ];
    }

	protected function register_controls() {
		$exad_primary_color   = get_option( 'exad_primary_color_option', '#7a56ff' );

  		$this->start_controls_section(
  			'exad_table_heading',
  			[
  				'label' => esc_html__( 'Heading', 'exclusive-addons-elementor-pro' )
  			]
		);
		  
		$table_heading_repeater = new Repeater();

		$table_heading_repeater->add_control(
            'exad_table_heading_col', 
            [
				'label'       => esc_html__( 'Heading Name', 'exclusive-addons-elementor-pro' ),
				'default'     => 'Heading',
				'type'        => Controls_Manager::TEXT,
				'label_block' => false
			]
		);

		$table_heading_repeater->add_control(
            'exad_table_heading_col_span', 
            [
				'label'       => esc_html__( 'Col Span', 'exclusive-addons-elementor-pro' ),
				'default'     => '',
				'type'        => Controls_Manager::NUMBER,
				'default' 	  => 1,
				'min'     	  => 1,
				'label_block' => true
			]
		);

		$table_heading_repeater->add_control(
            'exad_table_heading_icon_image_enabled', 
            [
				'label'        => esc_html__( 'Icon/Image?', 'exclusive-addons-elementor-pro' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'Show', 'exclusive-addons-elementor-pro' ),
				'label_off'    => __( 'Hide', 'exclusive-addons-elementor-pro' ),
				'default'      => 'no',
				'return_value' => 'true'
			]
		);

		$table_heading_repeater->add_control(
            'exad_table_heading_icon_type', 
            [
				'label'   => esc_html__( 'Heading Icon Type', 'exclusive-addons-elementor-pro' ),
				'type'    => Controls_Manager::CHOOSE,
				'options' => [
					'icon'        => [
						'title'   => esc_html__( 'Icon', 'exclusive-addons-elementor-pro' ),
						'icon'    => 'eicon-info-circle'
					],
					'image'       => [
						'title'   => esc_html__( 'Image', 'exclusive-addons-elementor-pro' ),
						'icon'    => 'eicon-image-bold'
					]
				],
				'default'   => 'icon',
				'condition' => [
					'exad_table_heading_icon_image_enabled' => 'true'
				]
			]
		);

		$table_heading_repeater->add_control(
            'exad_table_heading_icon', 
            [
				'label'     => esc_html__( 'Icon', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::ICONS,
				'condition' => [
					'exad_table_heading_icon_image_enabled' => 'true',
					'exad_table_heading_icon_type'          => 'icon'
				]
			]
		);

		$table_heading_repeater->add_control(
            'exad_table_heading_img', 
            [
				'label'     => esc_html__( 'Image', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::MEDIA,
				'default'   => [
					'url'   => Utils::get_placeholder_image_src()
				],
				'dynamic' => [
					'active' => true,
				],
				'condition' => [
					'exad_table_heading_icon_image_enabled' => 'true',
					'exad_table_heading_icon_type'          => 'image'
				]
			]
		);

		$table_heading_repeater->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name'    => 'image_size',
				'label'   => esc_html__( 'Image Size', 'exclusive-addons-elementor-pro' ),
				'default' => 'thumbnail',
				'condition' => [
					'exad_table_heading_icon_image_enabled' => 'true',
					'exad_table_heading_icon_type'          => 'image'
				]
			]
		);

		$table_heading_repeater->add_control(
            'exad_table_heading_custom_style_enabled', 
            [
				'label'        => esc_html__( 'Custom Style?', 'exclusive-addons-elementor-pro' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => 'no',
				'return_value' => 'true'
			]
		);

		$table_heading_repeater->add_control(
            'exad_table_heading_custom_style_alignment', 
            [
				'label'         => esc_html__( 'Text Alignment', 'exclusive-addons-elementor-pro' ),
				'type'          => Controls_Manager::CHOOSE,
				'options'       => [
					'left'      => [
						'title' => __( 'Left', 'exclusive-addons-elementor-pro' ),
						'icon'  => 'eicon-text-align-left'
					],
					'center'    => [
						'title' => __( 'center', 'exclusive-addons-elementor-pro' ),
						'icon'  => 'eicon-text-align-center'
					],
					'right'     => [
						'title' => __( 'Right', 'exclusive-addons-elementor-pro' ),
						'icon'  => 'eicon-text-align-right'
					]
				],
				'condition'     => [
					'exad_table_heading_custom_style_enabled' => 'true'
				]
			]
		);

		$table_heading_repeater->add_control(
            'exad_table_heading_custom_style_color', 
            [
				'name'         => 'exad_table_heading_custom_style_color',
				'label'        => esc_html__( 'Color', 'exclusive-addons-elementor-pro' ),
				'type'         => Controls_Manager::COLOR,
				'condition'    => [
					'exad_table_heading_custom_style_enabled' => 'true'
				]
			]
		);

		$table_heading_repeater->add_control(
            'exad_table_heading_custom_style_bg_color', 
            [
				'label'        => esc_html__( 'Background Color', 'exclusive-addons-elementor-pro' ),
				'type'         => Controls_Manager::COLOR,
				'condition'    => [
					'exad_table_heading_custom_style_enabled' => 'true'
				]
			]
		);

		$table_heading_repeater->add_control(
            'exad_table_heading_custom_style_border_style', 
            [
				'label' => __( 'Border Style', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'none',
				'options' => [
					'none' => __( 'None', 'exclusive-addons-elementor-pro' ),
					'solid'  => __( 'Solid', 'exclusive-addons-elementor-pro' ),
					'dashed' => __( 'Dashed', 'exclusive-addons-elementor-pro' ),
					'dotted' => __( 'Dotted', 'exclusive-addons-elementor-pro' ),
					'double' => __( 'Double', 'exclusive-addons-elementor-pro' ),
				],
				'condition' => [
					'exad_table_heading_custom_style_enabled' => 'true',
				]
			]
		);

		$table_heading_repeater->add_control(
            'exad_table_heading_custom_style_border_width', 
            [
				'label' => __( 'Border Width', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'condition' => [
					'exad_table_heading_custom_style_enabled' => 'true',
					'exad_table_heading_custom_style_border_style!' => 'none'
				]
			]
		);

		$table_heading_repeater->add_control(
            'exad_table_heading_custom_style_border_color', 
            [
				'label' => __( 'Boeder Color', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::COLOR,
				'condition' => [
					'exad_table_heading_custom_style_enabled' => 'true',
					'exad_table_heading_custom_style_border_style!' => 'none'
				]
			]
		);

  		$this->add_control(
			'exad_table_heading_columns',
			[
				'type'    => Controls_Manager::REPEATER,
				'fields' 	=> $table_heading_repeater->get_controls(),
				'default' => [
					[ 'exad_table_heading_col' => __( 'Table Heading 1', 'exclusive-addons-elementor-pro' ) ],
					[ 'exad_table_heading_col' => __( 'Table Heading 2', 'exclusive-addons-elementor-pro' ) ],
					[ 'exad_table_heading_col' => __( 'Table Heading 3', 'exclusive-addons-elementor-pro' ) ],
					[ 'exad_table_heading_col' => __('Table Heading 4', 'exclusive-addons-elementor-pro' ) ]
				],
				'title_field' => '{{exad_table_heading_col}}'
			]
		);

  		$this->end_controls_section();


  		/**
  		 * Exad Table Body
  		 */
  		$this->start_controls_section(
  			'exad_table_body',
  			[
  				'label' => esc_html__( 'Body', 'exclusive-addons-elementor-pro' )
  			]
		);
		  
		$table_body_repeater = new Repeater();

		$table_body_repeater->add_control(
            'exad_table_body_row_type', 
            [
				'label'       => esc_html__( 'Row Type', 'exclusive-addons-elementor-pro' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => 'row',
				'label_block' => false,
				'options'     => [
					'row'     => esc_html__( 'Row', 'exclusive-addons-elementor-pro' ),
					'col'     => esc_html__( 'Column', 'exclusive-addons-elementor-pro' )
				]
			]
		);

		$table_body_repeater->add_control(
            'exad_table_body_row_colspan', 
            [
				'label'			=> esc_html__( 'Col Span', 'exclusive-addons-elementor-pro' ),
				'type'			=> Controls_Manager::NUMBER,
				'description'	=> esc_html__( 'Default: 1 (optional).', 'exclusive-addons-elementor-pro' ),
				'default' 		=> 1,
				'min'     		=> 1,
				'label_block'	=> true,
				'condition' 	=> [
					'exad_table_body_row_type' => 'col'
				]
			]
		);

		$table_body_repeater->add_control(
            'exad_table_body_row_rowspan', 
            [
				'label'			=> esc_html__( 'Row Span', 'exclusive-addons-elementor-pro' ),
				'type'			=> Controls_Manager::NUMBER,
				'description'	=> esc_html__( 'Default: 1 (optional).', 'exclusive-addons-elementor-pro' ),
				'default' 		=> 1,
				'min'     		=> 1,
				'label_block'	=> true,
				'condition' 	=> [
					'exad_table_body_row_type' => 'col'
				]
			]
		);

		$table_body_repeater->add_control(
            'exad_table_body_row_content', 
            [
				'label'       => esc_html__( 'Column Text', 'exclusive-addons-elementor-pro' ),
				'type'        => Controls_Manager::TEXTAREA,
				'label_block' => true,
				'default'     => esc_html__( 'Table Content', 'exclusive-addons-elementor-pro' ),
				'condition'   => [
					'exad_table_body_row_type' => 'col'
				]
			]
		);

		$table_body_repeater->add_control(
            'exad_table_body_icon_image_enabled', 
            [
				'label'        => esc_html__( 'Icon/Image?', 'exclusive-addons-elementor-pro' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'Show', 'exclusive-addons-elementor-pro' ),
				'label_off'    => __( 'Hide', 'exclusive-addons-elementor-pro' ),
				'default'      => 'no',
				'return_value' => 'true',
				'condition'    => [
					'exad_table_body_row_type' => 'col'
				]
			]
		);

		$table_body_repeater->add_control(
            'exad_table_body_icon_image_type', 
            [
				'label'     => esc_html__( 'Heading Icon Type', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => [
					'icon'        => [
						'title'   => esc_html__( 'Icon', 'exclusive-addons-elementor-pro' ),
						'icon'    => 'eicon-info-circle'
					],
					'image'       => [
						'title'   => esc_html__( 'Image', 'exclusive-addons-elementor-pro' ),
						'icon'    => 'eicon-image-bold'
					]
				],
				'default'   => 'icon',
				'condition' => [
					'exad_table_body_icon_image_enabled' => 'true'
				]
			]
		);

		$table_body_repeater->add_control(
            'exad_table_body_icon', 
            [
				'label'     => esc_html__( 'Icon', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::ICONS,
				'condition' => [
					'exad_table_body_icon_image_enabled' => 'true',
					'exad_table_body_icon_image_type'    => 'icon',
					'exad_table_body_row_type'           => 'col'
				]
			]
		);

		$table_body_repeater->add_control(
            'exad_table_body_img', 
            [
				'label'     => esc_html__( 'Image', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::MEDIA,
				'default'   => [
					'url'   => Utils::get_placeholder_image_src()
				],
				'dynamic' => [
					'active' => true,
				],
				'condition' => [
					'exad_table_body_icon_image_enabled' => 'true',
					'exad_table_body_icon_image_type'    => 'image',
					'exad_table_body_row_type'           => 'col'
				]
			]
		);

		$table_body_repeater->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name'    => 'body_image_size',
				'label'   => esc_html__( 'Image Size', 'exclusive-addons-elementor-pro' ),
				'default' => 'thumbnail',
				'condition' => [
					'exad_table_body_icon_image_enabled' => 'true',
					'exad_table_body_icon_image_type'    => 'image',
					'exad_table_body_row_type'           => 'col'
				]
			]
		);

		$table_body_repeater->add_control(
            'exad_table_body_row_title_link', 
            [
				'name'            => 'exad_table_body_row_title_link',
				'label'           => esc_html__( 'Link', 'exclusive-addons-elementor-pro' ),
				'type'            => Controls_Manager::URL,
				'label_block'     => true,
				'separator'       => 'before',
				'show_external'   => true,
				'default'         => [
					'url'         => '',
					'is_external' => ''
				 ],
				 'condition'       => [
					'exad_table_body_row_type' => 'col'
				]
			]
		);

		$table_body_repeater->add_control(
            'exad_table_body_row_id_class', 
            [
				'label'			=> esc_html__( 'CSS ID', 'exclusive-addons-elementor-pro' ),
				'type'			=> Controls_Manager::TEXT,
				'label_block'	=> false,
				'condition' 	=> [
					'exad_table_body_row_type' => 'col'
				]
			]
		);

		$table_body_repeater->add_control(
            'exad_table_body_custom_style_enabled', 
            [
				'label'        => esc_html__( 'Custom Style?', 'exclusive-addons-elementor-pro' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => 'no',
				'return_value' => 'true',
				'condition'    => [
					'exad_table_body_row_type' => 'col'
				]
			]
		);

		$table_body_repeater->add_control(
            'exad_table_body_custom_style_alignment', 
            [
				'label'          => esc_html__( 'Text Alignment', 'exclusive-addons-elementor-pro' ),
				'type'           => Controls_Manager::CHOOSE,
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
				'condition'      => [
					'exad_table_body_custom_style_enabled' => 'true',
					'exad_table_body_row_type'             => 'col'
				]
			]
		);

		$table_body_repeater->add_control(
            'exad_table_body_custom_style_color', 
            [
				'label'     => esc_html__( 'Color', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => [
					'exad_table_body_custom_style_enabled' => 'true',
					'exad_table_body_row_type'             => 'col'
				]
			]
		);

		$table_body_repeater->add_control(
            'exad_table_body_custom_style_bg_color', 
            [
				'label'     => esc_html__( 'Background Color', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => [
					'exad_table_body_custom_style_enabled' => 'true',
					'exad_table_body_row_type'             => 'col'
				]
			]
		);

		$table_body_repeater->add_control(
            'exad_table_body_custom_style_border_style', 
            [
				'label' => __( 'Border Style', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'none',
				'options' => [
					'none' => __( 'None', 'exclusive-addons-elementor-pro' ),
					'solid'  => __( 'Solid', 'exclusive-addons-elementor-pro' ),
					'dashed' => __( 'Dashed', 'exclusive-addons-elementor-pro' ),
					'dotted' => __( 'Dotted', 'exclusive-addons-elementor-pro' ),
					'double' => __( 'Double', 'exclusive-addons-elementor-pro' ),
				],
				'condition' => [
					'exad_table_body_custom_style_enabled' => 'true',
					'exad_table_body_row_type'             => 'col'
				]
			]
		);

		$table_body_repeater->add_control(
            'exad_table_body_custom_style_border_width', 
            [
				'label' => __( 'Border Width', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'condition' => [
					'exad_table_body_custom_style_enabled' => 'true',
					'exad_table_body_row_type'             => 'col',
					'exad_table_body_custom_style_border_style!' => 'none'
				]
			]
		);

		$table_body_repeater->add_control(
            'exad_table_body_custom_style_border_color', 
            [
				'label' => __( 'Boeder Color', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::COLOR,
				'condition' => [
					'exad_table_body_custom_style_enabled' => 'true',
					'exad_table_body_row_type'             => 'col',
					'exad_table_body_custom_style_border_style!' => 'none'
				]
			]
		);

  		$this->add_control(
			'exad_table_body_rows',
			[
				'type'      => Controls_Manager::REPEATER,
				'fields' 	=> $table_body_repeater->get_controls(),
				'seperator' => 'before',
				'default'   => [
					[ 'exad_table_body_row_type' => __( 'row', 'exclusive-addons-elementor-pro' ) ],
					[ 'exad_table_body_row_type' => __( 'col', 'exclusive-addons-elementor-pro' ) ],
					[ 'exad_table_body_row_type' => __( 'col', 'exclusive-addons-elementor-pro' ) ],
					[ 'exad_table_body_row_type' => __( 'col', 'exclusive-addons-elementor-pro' ) ],
					[ 'exad_table_body_row_type' => __( 'col', 'exclusive-addons-elementor-pro' ) ]
				],
				'title_field' => '{{exad_table_body_row_type}}::{{exad_table_body_row_content}}'
			]
		);

  		$this->end_controls_section();

		/**
  		 * Exad Table Settings
  		 */
		$this->start_controls_section(
            'exad_table_settings_tab',
            [
				'label' => esc_html__( 'Settings', 'exclusive-addons-elementor-pro' ),
				'tab'   => Controls_Manager::TAB_SETTINGS                    
            ]
        );

		$this->add_control(
			'exad_table_enable_sorting',
			[
				'label'        => __( 'Enable Sorting.', 'exclusive-addons-elementor-pro' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'On', 'exclusive-addons-elementor-pro' ),
				'label_off'    => __( 'Off', 'exclusive-addons-elementor-pro' ),
				'return_value' => 'yes',
				'default'      => 'no'
			]
		);

		$this->add_control(
			'exad_table_enable_pagination_and_shorting',
			[
				'label'        => __( 'Enable Pagination & Sorting.', 'exclusive-addons-elementor-pro' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'On', 'exclusive-addons-elementor-pro' ),
				'label_off'    => __( 'Off', 'exclusive-addons-elementor-pro' ),
				'return_value' => 'yes',
				'default'      => 'no',
				'condition'	   => [
					'exad_table_enable_sorting' => 'yes'
				]
			]
		);

		$this->add_control(
			'exad_table_enable_searching',
			[
				'label'        => __( 'Enable Search.', 'exclusive-addons-elementor-pro' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'On', 'exclusive-addons-elementor-pro' ),
				'label_off'    => __( 'Off', 'exclusive-addons-elementor-pro' ),
				'return_value' => 'yes',
				'default'      => 'no',
				'condition'	   => [
					'exad_table_enable_sorting' => 'yes'
				]
			]
		);

		$this->add_control(
			'exad_table_enable_info',
			[
				'label'        => __( 'Enable Information', 'exclusive-addons-elementor-pro' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'On', 'exclusive-addons-elementor-pro' ),
				'label_off'    => __( 'Off', 'exclusive-addons-elementor-pro' ),
				'return_value' => 'yes',
				'default'      => 'no',
				'description'  => __( 'This shows the information at the bottom left side of the table', 'exclusive-addons-elementor-pro' ),
				'condition'	   => [
					'exad_table_enable_sorting' => 'yes'
				]
			]
		);

		$this->add_control(
			'exad_table_enable_vertical_scroll',
			[
				'label'        => __( 'Enable scrollY', 'exclusive-addons-elementor-pro' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'On', 'exclusive-addons-elementor-pro' ),
				'label_off'    => __( 'Off', 'exclusive-addons-elementor-pro' ),
				'return_value' => 'yes',
				'default'      => 'no',
				'description'  => __( 'Enable Scrolling In The Vertical direction.', 'exclusive-addons-elementor-pro' ),
				'condition'	   => [
					'exad_table_enable_sorting' => 'yes'
				]
			]
		);

		$this->add_responsive_control(
			'exad_table_vertical_height',
			[
				'label' 		=> __( 'Vertical Height', 'exclusive-addons-elementor-pro' ),
				'type'  		=> Controls_Manager::SLIDER,
				'range' 		=> [
					'px' 		=> [
						'min' 	=> 0,
						'max'	=> 1500
					]
				],
				'devices'       => [ 'desktop', 'tablet', 'mobile' ],
				'condition'	    => [
					'exad_table_enable_sorting'         => 'yes',
					'exad_table_enable_vertical_scroll' => 'yes'
				]
			]
		);

		$this->add_control(
			'exad_table_searching_text',
			[
				'label'        => __( 'Search Text.', 'exclusive-addons-elementor-pro' ),
				'type'         => Controls_Manager::TEXT,
				'default'      => __( 'Search: ', 'exclusive-addons-elementor-pro' ),
				'condition'	   => [
					'exad_table_enable_sorting'   => 'yes',
					'exad_table_enable_searching' => 'yes'
				]
			]
		);

		$this->add_control(
			'exad_table_searching_placeholder_text',
			[
				'label'        => __( 'Placeholder Text for Search', 'exclusive-addons-elementor-pro' ),
				'type'         => Controls_Manager::TEXT,
				'default'      => __( 'filter records', 'exclusive-addons-elementor-pro' ),
				'condition'	   => [
					'exad_table_enable_sorting'   => 'yes',
					'exad_table_enable_searching' => 'yes'
				]
			]
		);

		$this->add_control(
			'exad_table_text_for_no_data',
			[
				'label'        => __( 'Text For Not Found', 'exclusive-addons-elementor-pro' ),
				'type'         => Controls_Manager::TEXT,
				'default'      => __( 'No Data Found', 'exclusive-addons-elementor-pro' ),
				'description'  => __( 'This text will show if your search doesn\'t match with the table data.', 'exclusive-addons-elementor-pro' ),
				'condition'	   => [
					'exad_table_enable_sorting'   => 'yes',
					'exad_table_enable_searching' => 'yes'
				]
			]
		);

		$this->add_control(
			'exad_table_text_for_previous',
			[
				'label'        => __( 'Text For Previous', 'exclusive-addons-elementor-pro' ),
				'type'         => Controls_Manager::TEXT,
				'default'      => __( 'Previous', 'exclusive-addons-elementor-pro' ),
				'condition'	   => [
					'exad_table_enable_sorting'                 => 'yes',
					'exad_table_enable_pagination_and_shorting' => 'yes'
				]
			]
		);

		$this->add_control(
			'exad_table_text_for_next',
			[
				'label'        => __( 'Text For Next', 'exclusive-addons-elementor-pro' ),
				'type'         => Controls_Manager::TEXT,
				'default'      => __( 'Next', 'exclusive-addons-elementor-pro' ),
				'condition'	   => [
					'exad_table_enable_sorting'                 => 'yes',
					'exad_table_enable_pagination_and_shorting' => 'yes'
				]
			]
		);

		$this->add_control(
			'exad_table_enable_responsive',
			[
				'label'        => __( 'Enable Responsive', 'exclusive-addons-elementor-pro' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'On', 'exclusive-addons-elementor-pro' ),
				'label_off'    => __( 'Off', 'exclusive-addons-elementor-pro' ),
				'return_value' => 'yes',
				'default'      => 'no',
			]
		);

  		$this->end_controls_section();
		/**
  		 * Exad Table Container
  		 */

  		$this->start_controls_section(
  			'exad_table_container',
  			[
  				'label' => esc_html__( 'Container', 'exclusive-addons-elementor-pro' ),
  				'tab'   => Controls_Manager::TAB_STYLE
  			]
  		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'exad_table_container_background',
				'label' => __( 'Background', 'exclusive-addons-elementor-pro' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .exad-table-container table',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'exad_table_container_border',
				'selector' => '{{WRAPPER}} .exad-table-container table'
			]
		);

		$this->add_responsive_control(
			'exad_table_container_border_radius',
			[
				'label'       => esc_html__( 'Border Radius', 'exclusive-addons-elementor-pro' ),
				'type'        => Controls_Manager::SLIDER,
				'range'       => [
					'px' 	  => [
						'max' => 30
					]
				],
				'selectors'   => [
					'{{WRAPPER}} .exad-table-container table' => 'border-radius: {{SIZE}}px {{SIZE}}px {{SIZE}}px {{SIZE}}px; overflow: hidden;'
				],
				'description' => __( '<b>If you apply Border Radius then Table Border won\'t work.</b>', 'exclusive-addons-elementor-pro' )
			]
		);

  		$this->end_controls_section();

		$this->start_controls_section(
			'exad_table_heading_style_tab',
			[
				'label' => esc_html__( 'Heading', 'exclusive-addons-elementor-pro' ),
				'tab'   => Controls_Manager::TAB_STYLE
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'exad_table_heading_typography',
				'selector' => '{{WRAPPER}} .exad-table-container thead tr.table-heading th'
			]
		);

		$this->add_responsive_control(
			'exad_table_heading_alignment',
			[
				'label'         => esc_html__( 'Text Alignment', 'exclusive-addons-elementor-pro' ),
				'type'          => Controls_Manager::CHOOSE,
				'default' 	    => 'left',
				'options'       => [
                    'left'      => [
                        'title' => __( 'Left', 'exclusive-addons-elementor-pro' ),
                        'icon'  => 'eicon-text-align-left'
                    ],
                    'center'    => [
                        'title' => __( 'center', 'exclusive-addons-elementor-pro' ),
                        'icon'  => 'eicon-text-align-center'
                    ],
                    'right'     => [
                        'title' => __( 'Right', 'exclusive-addons-elementor-pro' ),
                        'icon'  => 'eicon-text-align-right'
                    ]
                ],
                'selectors'     => [
                    '{{WRAPPER}} .exad-table-container thead tr.table-heading th' => 'text-align: {{VALUE}};'
                ]
			]
		);

		$this->add_responsive_control(
			'exad_table_heading_padding',
			[
				'label'      => esc_html__( 'Padding', 'exclusive-addons-elementor-pro' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em' ],
				'default'    => [
					'top'    => '15',
					'right'  => '15',
					'bottom' => '15',
					'left'   => '15'
				],
				'selectors'  => [
					'{{WRAPPER}} .exad-table-container thead tr.table-heading th' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
		);

		$this->add_responsive_control(
			'exad_table_heading_border_radius',
			[
				'label'       => esc_html__( 'Border Radius', 'exclusive-addons-elementor-pro' ),
				'type'        => Controls_Manager::SLIDER,
				'range'       => [
					'px' 	  => [
						'max' => 40
					]
				],
				'selectors'   => [
					'{{WRAPPER}} .exad-table-container thead tr.table-heading th:first-child' => 'border-radius: {{SIZE}}px 0px 0px 0px;',
					'{{WRAPPER}} .exad-table-container thead tr.table-heading th:last-child' => 'border-radius: 0px {{SIZE}}px 0px 0px;'
				]
			]
		);

		$this->start_controls_tabs('exad_table_heading_normal_hover_tab');

			$this->start_controls_tab( 'exad_table_heading_normal', [ 'label' => esc_html__( 'Normal', 'exclusive-addons-elementor-pro' ) ] );

				$this->add_control(
					'exad_table_heading_color',
					[
						'label'     => esc_html__( 'Color', 'exclusive-addons-elementor-pro' ),
						'type'      => Controls_Manager::COLOR,
						'default'   => '#ffffff',
						'selectors' => [
							'{{WRAPPER}} .exad-table-container thead tr.table-heading th' => 'color: {{VALUE}};'
						]
					]
				);

				$this->add_control(
					'exad_table_heading_bg_color',
					[
						'label'     => esc_html__( 'Background Color', 'exclusive-addons-elementor-pro' ),
						'type'      => Controls_Manager::COLOR,
						'default'   => $exad_primary_color,
						'selectors' => [
							'{{WRAPPER}} .exad-table-container thead tr.table-heading th' => 'background-color: {{VALUE}};'
						]
					]
				);
				
				$this->add_group_control(
					Group_Control_Border::get_type(),
					[
						'name'               => 'exad_table_heading_border',
						'selector'           => '{{WRAPPER}} .exad-table-container thead tr.table-heading th',
						'fields_options'     => [
							'border'         => [
		                        'default' 	 => 'solid'
		                    ],
		                    'width'          => [
		                        'default'    => [
		                            'top'    => '1',
		                            'right'  => '1',
		                            'bottom' => '1',
		                            'left'   => '1'
		                        ]
		                    ],
		                    'color'          => [
		                        'default'    => $exad_primary_color
		                    ]
	                    ]
					]
				);

			$this->end_controls_tab();
			
			$this->start_controls_tab( 'exad_table_heading_hover', [ 'label' => esc_html__( 'Hover', 'exclusive-addons-elementor-pro' ) ] );

				$this->add_control(
					'exad_table_heading_hover_color',
					[
						'label'     => esc_html__( 'Color', 'exclusive-addons-elementor-pro' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .exad-table-container thead tr.table-heading th:hover' => 'color: {{VALUE}};'
						]
					]
				);

				$this->add_control(
					'exad_table_heading_hover_bg_color',
					[
						'label'     => esc_html__( 'Background Color', 'exclusive-addons-elementor-pro' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .exad-table-container thead tr.table-heading th:hover' => 'background-color: {{VALUE}};'
						]
					]
				);

				$this->add_group_control(
					Group_Control_Border::get_type(),
					[
						'name'     => 'exad_table_heading_hover_border',
						'selector' => '{{WRAPPER}} .exad-table-container thead tr.table-heading th:hover'
					]
				);

			$this->end_controls_tab();

			$this->end_controls_tabs();
		

			$this->add_control(
				'exad_table_heading_icon_image_style',
				[
					'label'     => esc_html__( 'Icon/Image', 'exclusive-addons-elementor-pro' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before'
				]
			);

		$this->start_controls_tabs('exad_table_heading_icon_image_style_tab');

			$this->start_controls_tab( 'exad_table_heading_icon_style', [ 'label' => esc_html__( 'Icon', 'exclusive-addons-elementor-pro' ) ] );

			$this->add_control(
				'exad_table_heading_icon_size',
				[
					'label'     => esc_html__( 'Size', 'exclusive-addons-elementor-pro' ),
					'type'      => Controls_Manager::NUMBER,
					'default'   => '14',
					'selectors' => [
						'{{WRAPPER}} .exad-main-table i.exad-table-heading-icon' => 'font-size: {{VALUE}}px;'
					]
				]
			);

			$this->add_responsive_control(
				'exad_table_heading_icon_padding',
				[
					'label'      => esc_html__( 'Padding', 'exclusive-addons-elementor-pro' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', 'em' ],
					'selectors'  => [
						'{{WRAPPER}} .exad-main-table i.exad-table-heading-icon' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
					]
				]
			);

	        $this->add_responsive_control(
	            'exad_table_heading_icon_margin_right',
	            [
	                'label'         => esc_html__('Right Spacing', 'exclusive-addons-elementor-pro'),
	                'type'          => Controls_Manager::SLIDER,
	                'default'       => [
	                    'size'      => 15
	                ],
	                'range'         => [
	                    'px'        => [
	                        'min'   => 0,
	                        'max'   => 100
	                    ]
	                ],
	                'selectors'     => [
	                    '{{WRAPPER}} .exad-main-table i.exad-table-heading-icon' => 'margin-right: {{SIZE}}{{UNIT}};'
	                ]                
	            ]
	        );     

			$this->end_controls_tab();

			$this->start_controls_tab( 'exad_table_heading_image_style', [ 'label' => esc_html__( 'Image', 'exclusive-addons-elementor-pro' ) ] );

	        $this->add_responsive_control(
	            'exad_table_heading_image_margin_bottom',
	            [
	                'label'         => esc_html__('Bottom Spacing', 'exclusive-addons-elementor-pro'),
	                'type'          => Controls_Manager::SLIDER,
	                'default'       => [
	                    'size'      => 20
	                ],
	                'range'         => [
	                    'px'        => [
	                        'min'   => 0,
	                        'max'   => 100
	                    ]
	                ],
	                'selectors'     => [
	                    '{{WRAPPER}} .exad-main-table tr.table-heading img' => 'margin-bottom: {{SIZE}}{{UNIT}};'
	                ]                
	            ]
	        );     

			$this->add_responsive_control(
				'exad_table_heading_image_padding',
				[
					'label'      => esc_html__( 'Padding', 'exclusive-addons-elementor-pro' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', 'em' ],
					'selectors'  => [
						'{{WRAPPER}} .exad-main-table tr.table-heading img' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
					]
				]
			);

			$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name'     => 'exad_table_heading_image_border',
					'selector' => '{{WRAPPER}} .exad-main-table tr.table-heading img'
				]
			);

			$this->add_responsive_control(
				'exad_table_heading_image_border_radius',
				[
					'label'      => __( 'Border Radius', 'exclusive-addons-elementor-pro' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%', 'em' ],
					'selectors'  => [
						'{{WRAPPER}} .exad-main-table tr.table-heading img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
					]
				]
			);

			$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		$this->start_controls_section(
			'exad_table_body_style_tab',
			[
				'label' => esc_html__( 'Body', 'exclusive-addons-elementor-pro' ),
				'tab'   => Controls_Manager::TAB_STYLE
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'exad_table_body_typography',
				'selector' => '{{WRAPPER}} .exad-table-container tbody td'
			]
		);

		$this->add_responsive_control(
			'exad_table_body_alignment',
			[
				'label'          => esc_html__( 'Text Alignment', 'exclusive-addons-elementor-pro' ),
				'type'           => Controls_Manager::CHOOSE,
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
				'selectors_dictionary' => [
					'flex-start' => 'justify-content: flex-start; text-align: left;',
					'center' => 'justify-content: center; text-align: center;',
					'flex-end' => 'justify-content: flex-end; text-align: right;',
				],
				'selectors' => [
					'{{WRAPPER}} .exad-table-container tbody td .exad-td-content' => '{{VALUE}};'
				]
			]
		);

		$this->add_responsive_control(
			'exad_table_body_padding',
			[
				'label'      => esc_html__( 'Padding', 'exclusive-addons-elementor-pro' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em' ],
				'default'    => [
					'top'    => '15',
					'right'  => '15',
					'bottom' => '15',
					'left'   => '15'
				],
				'selectors'  => [
					'{{WRAPPER}} .exad-table-container tbody td' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'               => 'exad_table_body_border',
					'fields_options' => [
					'border'         => [
                        'default' 	 => 'solid'
                    ],
                    'width'          => [
                        'default'    => [
                            'top'    => '1',
                            'right'  => '1',
                            'bottom' => '1',
                            'left'   => '1'
                        ]
                    ],
                    'color'          => [
                        'default'    => '#cccccc'
                    ]
                ],
				'selector'           => '{{WRAPPER}} .exad-table-container tbody td'
			]
		);

		$this->start_controls_tabs('exad_table_body_normal_hover_tab');

			$this->start_controls_tab( 'exad_table_body_normal', [ 'label' => esc_html__( 'Normal', 'exclusive-addons-elementor-pro' ) ] );

				$this->add_control(
					'exad_table_body_odd_row_style_heading',
					[
						'label' => esc_html__( 'Odd Row', 'exclusive-addons-elementor-pro' ),
						'type'  => Controls_Manager::HEADING
					]
				);

				$this->add_control(
					'exad_table_body_odd_row_color',
					[
						'label'     => esc_html__( 'Color', 'exclusive-addons-elementor-pro' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .exad-table-container tbody > tr:nth-child(2n+1) td' => 'color: {{VALUE}};'
						]
					]
				);

				$this->add_control(
					'exad_table_body_odd_row_bg_color',
					[
						'label'     => esc_html__( 'Background Color', 'exclusive-addons-elementor-pro' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .exad-table-container tbody > tr:nth-child(2n+1) td' => 'background-color: {{VALUE}};'
						]
					]
				);
				
				$this->add_control(
					'exad_table_body_even_row_style_heading',
					[
						'label' => esc_html__( 'Even Row', 'exclusive-addons-elementor-pro' ),
						'type'  => Controls_Manager::HEADING
					]
				);

				$this->add_control(
					'exad_table_body_even_row_color',
					[
						'label'     => esc_html__( 'Color', 'exclusive-addons-elementor-pro' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .exad-table-container tbody > tr:nth-child(2n) td' => 'color: {{VALUE}};'
						]
					]
				);

				$this->add_control(
					'exad_table_body_even_row_bg_color',
					[
						'label'     => esc_html__( 'Background Color', 'exclusive-addons-elementor-pro' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .exad-table-container tbody > tr:nth-child(2n) td' => 'background-color: {{VALUE}};'
						]
					]
				);

			$this->end_controls_tab();
			
			$this->start_controls_tab( 'exad_table_body_hover', [ 'label' => esc_html__( 'Hover', 'exclusive-addons-elementor-pro' ) ] );

				$this->add_control(
					'exad_table_body_odd_row_hover_style_heading',
					[
						'label' => esc_html__( 'Odd Row', 'exclusive-addons-elementor-pro' ),
						'type'  => Controls_Manager::HEADING
					]
				);

				$this->add_control(
					'exad_table_body_odd_row_hover_color',
					[
						'label'     => esc_html__( 'Color', 'exclusive-addons-elementor-pro' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .exad-table-container tbody > tr:nth-child(2n+1) td:hover' => 'color: {{VALUE}};'
						]
					]
				);

				$this->add_control(
					'exad_table_body_odd_row_hover_bg_color',
					[
						'label'     => esc_html__( 'Background Color', 'exclusive-addons-elementor-pro' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .exad-table-container tbody > tr:nth-child(2n+1) td:hover' => 'background-color: {{VALUE}};'
						]
					]
				);
				
				$this->add_control(
					'exad_table_body_even_row_hover_style_heading',
					[
						'label' => esc_html__( 'Even Row', 'exclusive-addons-elementor-pro' ),
						'type'  => Controls_Manager::HEADING
					]
				);

				$this->add_control(
					'exad_table_body_even_row_hover_color',
					[
						'label'     => esc_html__( 'Color', 'exclusive-addons-elementor-pro' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .exad-table-container tbody > tr:nth-child(2n) td:hover' => 'color: {{VALUE}};'
						]
					]
				);

				$this->add_control(
					'exad_table_body_even_row_hover_bg_color',
					[
						'label'     => esc_html__( 'Background Color', 'exclusive-addons-elementor-pro' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .exad-table-container tbody > tr:nth-child(2n) td:hover' => 'background-color: {{VALUE}};'
						]
					]
				);

			$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_control(
			'exad_table_body_icon_image_style',
			[
				'label'     => esc_html__( 'Icon/Image', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before'
			]
		);

		$this->start_controls_tabs('exad_table_body_icon_image_style_tab');

			$this->start_controls_tab( 'exad_table_body_icon_style', [ 'label' => esc_html__( 'Icon', 'exclusive-addons-elementor-pro' ) ] );

			$this->add_control(
				'exad_table_body_icon_size',
				[
					'label'     => esc_html__( 'Size', 'exclusive-addons-elementor-pro' ),
					'type'      => Controls_Manager::NUMBER,
					'default'   => '14',
					'selectors' => [
						'{{WRAPPER}} .exad-td-content i' => 'font-size: {{VALUE}}px;'
					]
				]
			);

			$this->add_responsive_control(
				'exad_table_body_icon_padding',
				[
					'label'      => esc_html__( 'Padding', 'exclusive-addons-elementor-pro' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', 'em' ],
					'selectors'  => [
						'{{WRAPPER}} .exad-td-content i' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
					]
				]
			);

			$this->add_responsive_control(
	            'exad_table_body_icon_margin_right',
	            [
	                'label'         => esc_html__('Right Spacing', 'exclusive-addons-elementor-pro'),
	                'type'          => Controls_Manager::SLIDER,
	                'default'       => [
	                    'size'      => 15
	                ],
	                'range'         => [
	                    'px'        => [
	                        'min'   => 0,
	                        'max'   => 100
	                    ]
	                ],
	                'selectors'     => [
	                    '{{WRAPPER}} .exad-td-content i' => 'margin-right: {{SIZE}}{{UNIT}};'
	                ]                
	            ]
	        ); 

			$this->end_controls_tab();

			$this->start_controls_tab( 'exad_table_body_image_style', [ 'label' => esc_html__( 'Image', 'exclusive-addons-elementor-pro' ) ] );

			$this->add_control(
				'exad_table_body_image_size',
				[
					'label'     => esc_html__( 'Size', 'exclusive-addons-elementor-pro' ),
					'type'      => Controls_Manager::NUMBER,
					'default'   => '60',
					'selectors' => [
						'{{WRAPPER}} .exad-td-content img' => 'width: {{VALUE}}px; height: {{VALUE}}px;',
					]
				]
			);

			$this->add_responsive_control(
				'exad_table_body_image_padding',
				[
					'label'      => esc_html__( 'Padding', 'exclusive-addons-elementor-pro' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', 'em' ],
					'selectors'  => [
						'{{WRAPPER}} .exad-td-content img' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
					]
				]
			);

			$this->add_responsive_control(
	            'exad_table_body_image_margin_right',
	            [
	                'label'         => esc_html__('Right Spacing', 'exclusive-addons-elementor-pro'),
	                'type'          => Controls_Manager::SLIDER,
	                'default'       => [
	                    'size'      => 20
	                ],
	                'range'         => [
	                    'px'        => [
	                        'min'   => 0,
	                        'max'   => 100
	                    ]
	                ],
	                'selectors'     => [
	                    '{{WRAPPER}} .exad-td-content img' => 'margin-right: {{SIZE}}{{UNIT}};'
	                ]                
	            ]
	        );

			$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name'     => 'exad_table_body_image_border',
					'selector' => '{{WRAPPER}} .exad-td-content img'
				]
			);

			$this->add_responsive_control(
				'exad_table_body_image_border_radius',
				[
					'label'      => __( 'Border Radius', 'exclusive-addons-elementor-pro' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%', 'em' ],
					'selectors'  => [
						'{{WRAPPER}} .exad-td-content img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
					]
				]
			);

			$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_control(
			'exad_table_body_link_normal_hover_style',
			[
				'label'     => esc_html__( 'Link', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before'
			]
		);

		$this->start_controls_tabs('exad_table_body_link_normal_hover_tab');

			$this->start_controls_tab( 'exad_table_body_link_normal', [ 'label' => esc_html__( 'Normal', 'exclusive-addons-elementor-pro' ) ] );

			$this->add_control(
				'exad_table_body_link_color',
				[
					'label'     => esc_html__( 'Color', 'exclusive-addons-elementor-pro' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .exad-table-container tbody .exad-td-content a' => 'color: {{VALUE}};'
					]
				]
			);

			$this->end_controls_tab();

			$this->start_controls_tab( 'exad_table_body_link_hover', [ 'label' => esc_html__( 'Hover', 'exclusive-addons-elementor-pro' ) ] );

			$this->add_control(
				'exad_table_body_link_hover_color',
				[
					'label'     => esc_html__( 'Color', 'exclusive-addons-elementor-pro' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .exad-table-container tbody .exad-td-content:hover a' => 'color: {{VALUE}};'
					]
				]
			);

			$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		$this->start_controls_section(
			'exad_table_search_style_tab',
			[
				'label' => esc_html__( 'Search', 'exclusive-addons-elementor-pro' ),
				'tab'   => Controls_Manager::TAB_STYLE
			]
		);

		$this->add_control(
			'exad_table_search_filter_text_heading',
			[
				'label' => __( 'Search Text', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'exad_table_search_filter_text_typography',
				'label' => __( 'Typography', 'exclusive-addons-elementor-pro' ),
				'selector' => '{{WRAPPER}} .exad-table-container .dataTables_wrapper .dataTables_filter label',
			]
		);

		$this->add_control(
			'exad_table_search_filter_search_color',
			[
				'label'     => esc_html__( 'Text Color', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#000000',
				'selectors' => [
					'{{WRAPPER}} .exad-table-container .dataTables_wrapper .dataTables_filter label' => 'color: {{VALUE}};'
				]
			]
		);

		$this->add_control(
			'exad_table_search_filter_input_heading',
			[
				'label' => __( 'Input Field', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'exad_table_search_filter_padding',
			[
				'label' => __( 'Padding', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'default' => [
					'top' => '10',
					'right' => '10',
					'bottom' => '10',
					'left' => '10',
					'unit' => 'px',
					'isLinked' => true,
				],
				'selectors' => [
					'{{WRAPPER}} .exad-table-container .dataTables_wrapper .dataTables_filter input' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'exad_table_search_filter_background',
			[
				'label'     => esc_html__( 'Background Color', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#f4f4f4',
				'selectors' => [
					'{{WRAPPER}} .exad-table-container .dataTables_wrapper .dataTables_filter input' => 'background: {{VALUE}};'
				]
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'exad_table_search_filter_typography',
				'label' => __( 'Typography', 'exclusive-addons-elementor-pro' ),
				'selector' => '{{WRAPPER}} .exad-table-container .dataTables_wrapper .dataTables_filter input',
			]
		);

		$this->add_control(
			'exad_table_search_filter_text_color',
			[
				'label'     => esc_html__( 'Text Color', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#000000',
				'selectors' => [
					'{{WRAPPER}} .exad-table-container .dataTables_wrapper .dataTables_filter input' => 'color: {{VALUE}};'
				]
			]
		);

		$this->add_control(
			'exad_table_search_filter_placeholder_text_color',
			[
				'label'     => esc_html__( 'Placeholder Text Color', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#000000',
				'selectors' => [
					'{{WRAPPER}} .exad-table-container .dataTables_wrapper .dataTables_filter input::placeholder' => 'color: {{VALUE}};',
					'{{WRAPPER}} .exad-table-container .dataTables_wrapper .dataTables_filter input:-ms-input-placeholder' => 'color: {{VALUE}};',
					'{{WRAPPER}} .exad-table-container .dataTables_wrapper .dataTables_filter input::-ms-input-placeholder' => 'color: {{VALUE}};'
				]
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'exad_table_search_filter_border',
				'label' => __( 'Border', 'exclusive-addons-elementor-pro' ),
				'selector' => '{{WRAPPER}} .exad-table-container .dataTables_wrapper .dataTables_filter input',
			]
		);

		$this->add_responsive_control(
			'exad_table_search_filter_radius',
			[
				'label' => __( 'Border Radius', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'default' => [
					'top' => '0',
					'right' => '0',
					'bottom' => '0',
					'left' => '0',
					'unit' => 'px',
					'isLinked' => true,
				],
				'selectors' => [
					'{{WRAPPER}} .exad-table-container .dataTables_wrapper .dataTables_filter input' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'exad_table_search_filter_box_shadow',
				'label' => __( 'Box Shadow', 'exclusive-addons-elementor-pro' ),
				'selector' => '{{WRAPPER}} .exad-table-container .dataTables_wrapper .dataTables_filter input',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'exad_table_pagination_style_tab',
			[
				'label' => esc_html__( 'Pagination', 'exclusive-addons-elementor-pro' ),
				'tab'   => Controls_Manager::TAB_STYLE
			]
		);

		$this->add_responsive_control(
			'exad_table_pagination_padding',
			[
				'label' => __( 'Padding', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'default' => [
					'top' => '10',
					'right' => '20',
					'bottom' => '10',
					'left' => '20',
					'unit' => 'px',
					'isLinked' => true,
				],
				'selectors' => [
					'{{WRAPPER}} .exad-table-container .dataTables_wrapper .dataTables_paginate .paginate_button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'exad_table_pagination_radius',
			[
				'label' => __( 'Bordar Radius', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'default' => [
					'top' => '0',
					'right' => '0',
					'bottom' => '0',
					'left' => '0',
					'unit' => 'px',
					'isLinked' => true,
				],
				'selectors' => [
					'{{WRAPPER}} .exad-table-container .dataTables_wrapper .dataTables_paginate .paginate_button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'exad_table_pagination_typography',
				'label' => __( 'Typography', 'exclusive-addons-elementor-pro' ),
				'selector' => '{{WRAPPER}} .exad-table-container .dataTables_wrapper .dataTables_paginate .paginate_button',
			]
		);

		$this->add_responsive_control(
			'exad_table_pagination_button_spacing',
			[
				'label' => __( 'Button Spacing', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 50,
					]
				],
				'default' => [
					'unit' => 'px',
					'size' => 5,
				],
				'selectors' => [
					'{{WRAPPER}} .exad-table-container .dataTables_wrapper .dataTables_paginate .paginate_button' => 'margin-left: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs( 'exad_table_pagination_tabs' );
            // normal state tab
			$this->start_controls_tab( 'exad_table_pagination_normal', [ 'label' => esc_html__( 'Normal', 'exclusive-addons-elementor-pro' ) ] );

				$this->add_control(
					'exad_table_pagination_normal_prev_next_heading',
					[
						'label' => __( 'Previous/Next', 'exclusive-addons-elementor-pro' ),
						'type' => Controls_Manager::HEADING,
					]
				);

				$this->add_control(
					'exad_table_pagination_normal_prev_next_bg_color',
					[
						'label'     => esc_html__( 'Previous/Next Background Color', 'exclusive-addons-elementor-pro' ),
						'type'      => Controls_Manager::COLOR,
						'default'   => '#ffffff',
						'selectors' => [
							'{{WRAPPER}} .exad-table-container .dataTables_wrapper .dataTables_paginate .paginate_button.previous' => 'background: {{VALUE}};',
							'{{WRAPPER}} .exad-table-container .dataTables_wrapper .dataTables_paginate .paginate_button.next' => 'background: {{VALUE}};'
						]
					]
				);

				$this->add_control(
					'exad_table_pagination_normal_prev_next_text_color',
					[
						'label'     => esc_html__( 'Previous/Next Text Color', 'exclusive-addons-elementor-pro' ),
						'type'      => Controls_Manager::COLOR,
						'default'   => '#000000',
						'selectors' => [
							'{{WRAPPER}} .exad-table-container .dataTables_wrapper .dataTables_paginate .paginate_button.previous' => 'color: {{VALUE}};',
							'{{WRAPPER}} .exad-table-container .dataTables_wrapper .dataTables_paginate .paginate_button.next' => 'color: {{VALUE}};'
						]
					]
				);

				$this->add_group_control(
					Group_Control_Border::get_type(),
					[
						'name' => 'exad_table_pagination_normal_prev_next_border',
						'label' => __( 'Border', 'exclusive-addons-elementor-pro' ),
						'selector' => '{{WRAPPER}} .exad-table-container .dataTables_wrapper .dataTables_paginate .paginate_button.previous, {{WRAPPER}} .exad-table-container .dataTables_wrapper .dataTables_paginate .paginate_button.next',
					]
				);

				$this->add_group_control(
					Group_Control_Box_Shadow::get_type(),
					[
						'name' => 'exad_table_pagination_normal_prev_next_shadow',
						'label' => __( 'Box Shadow', 'exclusive-addons-elementor-pro' ),
						'selector' => '{{WRAPPER}} .exad-table-container .dataTables_wrapper .dataTables_paginate .paginate_button.previous, {{WRAPPER}} .exad-table-container .dataTables_wrapper .dataTables_paginate .paginate_button.next',
					]
				);

				$this->add_control(
					'exad_table_pagination_normal_number_heading',
					[
						'label' => __( 'Number', 'exclusive-addons-elementor-pro' ),
						'type' => Controls_Manager::HEADING,
						'separator' => 'before',
					]
				);
				
				$this->add_control(
					'exad_table_pagination_normal_number_bg_color',
					[
						'label'     => esc_html__( 'Number Background Color', 'exclusive-addons-elementor-pro' ),
						'type'      => Controls_Manager::COLOR,
						'default'   => $exad_primary_color,
						'selectors' => [
							'{{WRAPPER}} .exad-table-container .dataTables_wrapper .dataTables_paginate .paginate_button' => 'background: {{VALUE}};'
						]
					]
				);

				$this->add_control(
					'exad_table_pagination_normal_number_text_color',
					[
						'label'     => esc_html__( 'Number Text Color', 'exclusive-addons-elementor-pro' ),
						'type'      => Controls_Manager::COLOR,
						'default'   => '#ffffff',
						'selectors' => [
							'{{WRAPPER}} .exad-table-container .dataTables_wrapper .dataTables_paginate .paginate_button' => 'color: {{VALUE}};'
						]
					]
				);

				$this->add_group_control(
					Group_Control_Border::get_type(),
					[
						'name' => 'exad_table_pagination_normal_number_border',
						'label' => __( 'Border', 'exclusive-addons-elementor-pro' ),
						'selector' => '{{WRAPPER}} .exad-table-container .dataTables_wrapper .dataTables_paginate .paginate_button',
					]
				);

				$this->add_group_control(
					Group_Control_Box_Shadow::get_type(),
					[
						'name' => 'exad_table_pagination_normal_number_shadow',
						'label' => __( 'Box Shadow', 'exclusive-addons-elementor-pro' ),
						'selector' => '{{WRAPPER}} .exad-table-container .dataTables_wrapper .dataTables_paginate .paginate_button',
					]
				);

            $this->end_controls_tab();

            // hover state tab
			$this->start_controls_tab( 'exad_table_pagination_hover', [ 'label' => esc_html__( 'Hover', 'exclusive-addons-elementor-pro' ) ] );

				$this->add_control(
					'exad_table_pagination_hover_prev_next_heading',
					[
						'label' => __( 'Previous/Next', 'exclusive-addons-elementor-pro' ),
						'type' => Controls_Manager::HEADING,
						'separator' => 'before',
					]
				);

				$this->add_control(
					'exad_table_pagination_hover_prev_next_bg_color',
					[
						'label'     => esc_html__( 'Previous/Next Background Color', 'exclusive-addons-elementor-pro' ),
						'type'      => Controls_Manager::COLOR,
						'default'   => '#ffffff',
						'selectors' => [
							'{{WRAPPER}} .exad-table-container .dataTables_wrapper .dataTables_paginate .paginate_button.previous:hover' => 'background: {{VALUE}};',
							'{{WRAPPER}} .exad-table-container .dataTables_wrapper .dataTables_paginate .paginate_button.next:hover' => 'background: {{VALUE}};'
						]
					]
				);

				$this->add_control(
					'exad_table_pagination_hover_prev_next_text_color',
					[
						'label'     => esc_html__( 'Previous/Next Text Color', 'exclusive-addons-elementor-pro' ),
						'type'      => Controls_Manager::COLOR,
						'default'   => '#000000',
						'selectors' => [
							'{{WRAPPER}} .exad-table-container .dataTables_wrapper .dataTables_paginate .paginate_button.previous:hover' => 'color: {{VALUE}};',
							'{{WRAPPER}} .exad-table-container .dataTables_wrapper .dataTables_paginate .paginate_button.next:hover' => 'color: {{VALUE}};'
						]
					]
				);

				$this->add_group_control(
					Group_Control_Border::get_type(),
					[
						'name' => 'exad_table_pagination_hover_prev_next_border',
						'label' => __( 'Border', 'exclusive-addons-elementor-pro' ),
						'selector' => '{{WRAPPER}} .exad-table-container .dataTables_wrapper .dataTables_paginate .paginate_button.previous:hover, {{WRAPPER}} .exad-table-container .dataTables_wrapper .dataTables_paginate .paginate_button.next:hover',
					]
				);

				$this->add_group_control(
					Group_Control_Box_Shadow::get_type(),
					[
						'name' => 'exad_table_pagination_hover_prev_next_shadow',
						'label' => __( 'Box Shadow', 'exclusive-addons-elementor-pro' ),
						'selector' => '{{WRAPPER}} .exad-table-container .dataTables_wrapper .dataTables_paginate .paginate_button.previous:hover, {{WRAPPER}} .exad-table-container .dataTables_wrapper .dataTables_paginate .paginate_button.next:hover',
					]
				);

				$this->add_control(
					'exad_table_pagination_hover_number_heading',
					[
						'label' => __( 'Number', 'exclusive-addons-elementor-pro' ),
						'type' => Controls_Manager::HEADING,
						'separator' => 'before',
					]
				);
				
				$this->add_control(
					'exad_table_pagination_hover_number_bg_color',
					[
						'label'     => esc_html__( 'Number Background Color', 'exclusive-addons-elementor-pro' ),
						'type'      => Controls_Manager::COLOR,
						'default'   => '#ffffff',
						'selectors' => [
							'{{WRAPPER}} .exad-table-container .dataTables_wrapper .dataTables_paginate .paginate_button:hover' => 'background: {{VALUE}};'
						]
					]
				);

				$this->add_control(
					'exad_table_pagination_hover_number_text_color',
					[
						'label'     => esc_html__( 'Number Text Color', 'exclusive-addons-elementor-pro' ),
						'type'      => Controls_Manager::COLOR,
						'default'   => $exad_primary_color,
						'selectors' => [
							'{{WRAPPER}} .exad-table-container .dataTables_wrapper .dataTables_paginate .paginate_button:hover' => 'color: {{VALUE}};'
						]
					]
				);

				$this->add_group_control(
					Group_Control_Border::get_type(),
					[
						'name' => 'exad_table_pagination_hover_number_border',
						'label' => __( 'Border', 'exclusive-addons-elementor-pro' ),
						'selector' => '{{WRAPPER}} .exad-table-container .dataTables_wrapper .dataTables_paginate .paginate_button:hover',
					]
				);

				$this->add_group_control(
					Group_Control_Box_Shadow::get_type(),
					[
						'name' => 'exad_table_pagination_hover_number_shadow',
						'label' => __( 'Box Shadow', 'exclusive-addons-elementor-pro' ),
						'selector' => '{{WRAPPER}} .exad-table-container .dataTables_wrapper .dataTables_paginate .paginate_button:hover',
					]
				);

			$this->end_controls_tab();
			
            // active state tab
			$this->start_controls_tab( 'exad_table_pagination_active', [ 'label' => esc_html__( 'Active', 'exclusive-addons-elementor-pro' ) ] );

				$this->add_control(
					'exad_table_pagination_active_number_bg_color',
					[
						'label'     => esc_html__( 'Background Color', 'exclusive-addons-elementor-pro' ),
						'type'      => Controls_Manager::COLOR,
						'default'   => $exad_primary_color,
						'selectors' => [
							'{{WRAPPER}} .exad-table-container .dataTables_wrapper .dataTables_paginate .paginate_button.current' => 'background: {{VALUE}};'
						]
					]
				);

				$this->add_control(
					'exad_table_pagination_active_text_color',
					[
						'label'     => esc_html__( 'Text Color', 'exclusive-addons-elementor-pro' ),
						'type'      => Controls_Manager::COLOR,
						'default'   => '#ffffff',
						'selectors' => [
							'{{WRAPPER}} .exad-table-container .dataTables_wrapper .dataTables_paginate .paginate_button.current' => 'color: {{VALUE}};',
						]
					]
				);

				$this->add_group_control(
					Group_Control_Border::get_type(),
					[
						'name' => 'exad_table_pagination_active_number_border',
						'label' => __( 'Border', 'exclusive-addons-elementor-pro' ),
						'selector' => '{{WRAPPER}} .exad-table-container .dataTables_wrapper .dataTables_paginate .paginate_button.current',
					]
				);

				$this->add_group_control(
					Group_Control_Box_Shadow::get_type(),
					[
						'name' => 'exad_table_pagination_active_number_shadow',
						'label' => __( 'Box Shadow', 'exclusive-addons-elementor-pro' ),
						'selector' => '{{WRAPPER}} .exad-table-container .dataTables_wrapper .dataTables_paginate .paginate_button.current',
					]
				);

			$this->end_controls_tab();
			
            // disable state tab
			$this->start_controls_tab( 'exad_table_pagination_disable', [ 'label' => esc_html__( 'Disable', 'exclusive-addons-elementor-pro' ) ] );

				$this->add_control(
					'exad_table_pagination_disable_number_bg_color',
					[
						'label'     => esc_html__( 'Background Color', 'exclusive-addons-elementor-pro' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .exad-table-container .dataTables_wrapper .dataTables_paginate .paginate_button.disabled' => 'background: {{VALUE}};'
						]
					]
				);

				$this->add_control(
					'exad_table_pagination_disable_text_color',
					[
						'label'     => esc_html__( 'Text Color', 'exclusive-addons-elementor-pro' ),
						'type'      => Controls_Manager::COLOR,
						'default'   => '#848484',
						'selectors' => [
							'{{WRAPPER}} .exad-table-container .dataTables_wrapper .dataTables_paginate .paginate_button.disabled' => 'color: {{VALUE}};',
						]
					]
				);

				$this->add_group_control(
					Group_Control_Border::get_type(),
					[
						'name' => 'exad_table_pagination_disable_number_border',
						'label' => __( 'Border', 'exclusive-addons-elementor-pro' ),
						'selector' => '{{WRAPPER}} .exad-table-container .dataTables_wrapper .dataTables_paginate .paginate_button.disabled',
					]
				);

				$this->add_group_control(
					Group_Control_Box_Shadow::get_type(),
					[
						'name' => 'exad_table_pagination_disable_number_shadow',
						'label' => __( 'Box Shadow', 'exclusive-addons-elementor-pro' ),
						'selector' => '{{WRAPPER}} .exad-table-container .dataTables_wrapper .dataTables_paginate .paginate_button.disabled',
					]
				);

            $this->end_controls_tab();

        $this->end_controls_tabs();

		$this->end_controls_section();

		$this->start_controls_section(
			'exad_table_information_style_tab',
			[
				'label' => esc_html__( 'Information', 'exclusive-addons-elementor-pro' ),
				'tab'   => Controls_Manager::TAB_STYLE
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'exad_table_info_typography',
				'label' => __( 'Typography', 'exclusive-addons-elementor-pro' ),
				'selector' => '{{WRAPPER}} .exad-table-container .dataTables_wrapper .dataTables_info',
			]
		);

		$this->add_control(
			'exad_table_info_text_color',
			[
				'label'     => esc_html__( 'Text Color', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#000000',
				'selectors' => [
					'{{WRAPPER}} .exad-table-container .dataTables_wrapper .dataTables_info' => 'color: {{VALUE}};',
				]
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'exad_table_length_style_tab',
			[
				'label' => esc_html__( 'Table Length', 'exclusive-addons-elementor-pro' ),
				'tab'   => Controls_Manager::TAB_STYLE
			]
		);

		$this->add_responsive_control(
			'exad_table_length_padding',
			[
				'label' => __( 'Padding', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'default' => [
					'top' => '10',
					'right' => '10',
					'bottom' => '10',
					'left' => '10',
					'unit' => 'px',
					'isLinked' => true,
				],
				'selectors' => [
					'{{WRAPPER}} .exad-table-container .dataTables_wrapper .dataTables_length select' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'exad_table_length_typography',
				'label' => __( 'Typography', 'exclusive-addons-elementor-pro' ),
				'selector' => '{{WRAPPER}} .exad-table-container .dataTables_wrapper .dataTables_length',
			]
		);

		$this->add_control(
			'exad_table_length_color',
			[
				'label'     => esc_html__( 'Text Color', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#000000',
				'selectors' => [
					'{{WRAPPER}} .exad-table-container .dataTables_wrapper .dataTables_length' => 'color: {{VALUE}};',
					'{{WRAPPER}} .exad-table-container .dataTables_wrapper .dataTables_length select' => 'color: {{VALUE}};',
				]
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'exad_table_length_border',
				'selector' => '{{WRAPPER}} .exad-table-container .dataTables_wrapper .dataTables_length select'
			]
		);

		$this->add_responsive_control(
			'exad_table_length_border_radius',
			[
				'label'      => __( 'Border Radius', 'exclusive-addons-elementor-pro' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .exad-table-container .dataTables_wrapper .dataTables_length select' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'exad_table_responsive_control_tab',
			[
				'label' => esc_html__( 'Responsive Control', 'exclusive-addons-elementor-pro' ),
				'tab'   => Controls_Manager::TAB_STYLE,
				'condition' => [
					'exad_table_enable_responsive' => 'yes'
				]
			]
		);

		$this->add_responsive_control(
			'exad_table_responsive_heading_padding',
			[
				'label'      => esc_html__( 'Heading Padding', 'exclusive-addons-elementor-pro' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .exad-custom-responsive-control .exad-th-mobile-screen' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
		);

		$this->add_control(
            'exad_table_responsive_heading_background', 
            [
				'label'        => esc_html__( 'Heading Background Color', 'exclusive-addons-elementor-pro' ),
				'type'         => Controls_Manager::COLOR,
				'selectors'  => [
					'{{WRAPPER}} .exad-custom-responsive-control .exad-th-mobile-screen' => 'background: {{Value}};'
				]
			]
		);

		$this->add_control(
            'exad_table_responsive_heading_text_color', 
            [
				'label'        => esc_html__( 'Heading Text Color', 'exclusive-addons-elementor-pro' ),
				'type'         => Controls_Manager::COLOR,
				'selectors'  => [
					'{{WRAPPER}} .exad-custom-responsive-control .exad-th-mobile-screen' => 'color: {{VALUE}};'
				]
			]
		);

		$this->add_responsive_control(
			'exad_table_responsive_content_padding',
			[
				'label'      => esc_html__( 'Content Padding', 'exclusive-addons-elementor-pro' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .exad-custom-responsive-control .exad-td-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
		);

		$this->add_control(
            'exad_table_responsive_content_background', 
            [
				'label'        => esc_html__( 'Heading Background Color', 'exclusive-addons-elementor-pro' ),
				'type'         => Controls_Manager::COLOR,
				'selectors'  => [
					'{{WRAPPER}} .exad-custom-responsive-control .exad-td-content' => 'background: {{Value}};'
				]
			]
		);

		$this->add_control(
            'exad_table_responsive_content_text_color', 
            [
				'label'        => esc_html__( 'Heading Text Color', 'exclusive-addons-elementor-pro' ),
				'type'         => Controls_Manager::COLOR,
				'selectors'  => [
					'{{WRAPPER}} .exad-custom-responsive-control .exad-td-content' => 'color: {{VALUE}};'
				]
			]
		);

		$this->end_controls_section();

	}


	protected function render( ) {

   		$settings = $this->get_settings_for_display();

	  	$table_tr = $table_td = [];

	  	foreach( $settings['exad_table_body_rows'] as $content_row ) :

	  		$row_id = uniqid();

	  		if( 'row' == $content_row['exad_table_body_row_type'] ) :
	  			$table_tr[] = [
					'id'   => $row_id,
					'type' => $content_row['exad_table_body_row_type']
	  			];
	  		endif;

	  		if(  'col' == $content_row['exad_table_body_row_type'] ) :
				$target   = $content_row['exad_table_body_row_title_link']['is_external'] ? 'target="_blank"' : '';
				$nofollow = $content_row['exad_table_body_row_title_link']['nofollow'] ? 'rel="nofollow"' : '';

				
				$exad_table_tr_keys = array_keys( $table_tr );
				$last_key           = end( $exad_table_tr_keys );				  
				$tbody_content      = $content_row['exad_table_body_row_content'];

	  			$table_td[] = [
					'row_id'                 => $table_tr[$last_key]['id'],
					'type'                   => $content_row['exad_table_body_row_type'],
					'icon_image_enable'      => $content_row['exad_table_body_icon_image_enabled'],
					'icon_image_type'        => $content_row['exad_table_body_icon_image_type'],
					'icon'                   => $content_row['exad_table_body_icon'],
					'image_id'               => $content_row['exad_table_body_img'],
					'image'                  => ( isset( $content_row['exad_table_body_img']['id'] ) || isset( $content_row['exad_table_body_img']['url'] ) ) ? $content_row['exad_table_body_img']['url'] : '',
					'image_size'             => $content_row['body_image_size_size'],
					'title'                  => $tbody_content,
					'link_url'               => $content_row['exad_table_body_row_title_link']['url'],
					'link_target'            => $target,
					'nofollow'               => $nofollow,
					'colspan'                => $content_row['exad_table_body_row_colspan'],
					'rowspan'                => $content_row['exad_table_body_row_rowspan'],
					'tr_id'                  => $content_row['exad_table_body_row_id_class'],
					'custom_style_enable'    => $content_row['exad_table_body_custom_style_enabled'],
					'custom_style_alignment' => $content_row['exad_table_body_custom_style_alignment'],
					'custom_style_color'     => $content_row['exad_table_body_custom_style_color'],
					'custom_style_bg_color'  => $content_row['exad_table_body_custom_style_bg_color'],
					'custom_style_border_style'  => $content_row['exad_table_body_custom_style_border_style'],
					'custom_style_border_width'  => array( $content_row['exad_table_body_custom_style_border_width'] ),
					'custom_style_border_color'  => $content_row['exad_table_body_custom_style_border_color']
	  			];

	  		endif;
		endforeach;

		// count total number of table heading
		$table_th_count = count($settings['exad_table_heading_columns']);

		$this->add_render_attribute('exad_table_container', [
			'class'                  => 'exad-table-container',
			'table-table_id'          => esc_attr($this->get_id()),
		]);

		if( 'yes' == $settings['exad_table_enable_responsive'] ){
			$this->add_render_attribute('exad_table_container', [
				'class' => 'exad-custom-responsive-control',
				'data-exad_custom_responsive' => true
			]);
		}

		$this->add_render_attribute('exad_main_table', [
			'id'    => "exad-table-id-{$this->get_id()}",
			'class'	=> 'exad-main-table dt-responsive'
		]);

		$this->add_render_attribute( 'td_content', [
			'class'	=> 'exad-td-content'
		]);

        if (  'yes' == $settings['exad_table_enable_sorting'] ) {
            $this->add_render_attribute( 'exad_table_container', 'data-sorting', true);
            if( 'yes' == $settings['exad_table_enable_info'] ){
	        	$this->add_render_attribute( 'exad_table_container', 'data-enable-info', true );

            }
            if( 'yes' == $settings['exad_table_enable_pagination_and_shorting'] ){
            	$this->add_render_attribute( 'exad_table_container', 'data-pagination', true);
    	        $this->add_render_attribute( 'exad_table_container', 'data-previous-text', esc_html($settings['exad_table_text_for_previous']) );
    	        $this->add_render_attribute( 'exad_table_container', 'data-next-text', esc_html($settings['exad_table_text_for_next']) );
            }
            if( 'yes' == $settings['exad_table_enable_searching'] ){
            	$this->add_render_attribute( 'exad_table_container', 'data-searching', true);
    	        $this->add_render_attribute( 'exad_table_container', 'data-search-text', esc_html($settings['exad_table_searching_text']) );
    	        $this->add_render_attribute( 'exad_table_container', 'data-search-placeholder', esc_html($settings['exad_table_searching_placeholder_text']) );
    	        $this->add_render_attribute( 'exad_table_container', 'data-not-found-text', esc_html($settings['exad_table_text_for_no_data']) );
            }
            if( 'yes' == $settings['exad_table_enable_vertical_scroll'] ){
		        $this->add_render_attribute(
		            'exad_table_container', [
		                'class'                    => "enable-scrolly",
		                'data-vertical-height'     => esc_html( $settings['exad_table_vertical_height']['size'] )
		            ]
		        );
            }
        }
		?>
		<div <?php echo $this->get_render_attribute_string('exad_table_container'); ?>>
			<table <?php echo $this->get_render_attribute_string('exad_main_table'); ?>>
			    <thead>
			        <tr class="table-heading">
			        	<?php $i = 0;
						foreach( $settings['exad_table_heading_columns'] as $heading_title ) :
							if($heading_title['exad_table_heading_col_span'] > 1){
								$this->add_render_attribute('th_class'.$i,
									[
										'colspan'	=> $heading_title['exad_table_heading_col_span']
									]									
								);
							}

							$th_custom_style = '';
							if( 'true' == $heading_title['exad_table_heading_custom_style_enabled']){
								$th_color        = $heading_title['exad_table_heading_custom_style_color'];
								$th_bg_color     = $heading_title['exad_table_heading_custom_style_bg_color'];
								$th_alignment    = $heading_title['exad_table_heading_custom_style_alignment'];
								$th_border_style = $heading_title['exad_table_heading_custom_style_border_style'];
								$th_border_width = array( $heading_title['exad_table_heading_custom_style_border_width'] );
								$th_border_color = $heading_title['exad_table_heading_custom_style_border_color'];
								$th_custom_style = 'style="';
								$th_color ? $th_custom_style     .= 'color: '.esc_attr($th_color).';' : '';
								$th_bg_color ? $th_custom_style  .= 'background-color: '.esc_attr($th_bg_color).';' : '';
								$th_border_style ? $th_custom_style .= 'border-style: ' . esc_attr($th_border_style) . ';' : '';
								$th_border_width ? $th_custom_style .= 'border-width: ' . $th_border_width[0]["top"] . $th_border_width[0]["unit"] .' '. $th_border_width[0]["right"].$th_border_width[0]["unit"].' '. $th_border_width[0]["bottom"].$th_border_width[0]["unit"].' '.$th_border_width[0]["left"].$th_border_width[0]["unit"]. ';' : '';
								$th_border_color ? $th_custom_style .= 'border-color: ' . esc_attr($th_border_color) . ';' : '';
								$th_alignment ? $th_custom_style .= 'text-align: '.esc_attr($th_alignment).';' : '';
								$th_custom_style                 .= '"';
							} ?>

		            		<th <?php echo $this->get_render_attribute_string('th_class'.$i); ?> <?php echo $th_custom_style; ?>>
								<?php if( 'true' == $heading_title['exad_table_heading_icon_image_enabled'] ) : 
									if ( ! empty( $heading_title['exad_table_heading_icon']['value']) && ( 'icon' == $heading_title['exad_table_heading_icon_type'] ) ) : ?>
										<i class="<?php echo $heading_title['exad_table_heading_icon']['value']; ?> exad-table-heading-icon"></i>
									<?php endif;
				            	endif; 
								if( 'true' == $heading_title['exad_table_heading_icon_image_enabled'] ) :
									if( 'image' == $heading_title['exad_table_heading_icon_type'] && ! empty($heading_title['exad_table_heading_img']['url']) ) :
										$this->add_render_attribute('exad_table_th_img'.$i, [
											'src'	=> esc_url( $heading_title['exad_table_heading_img']['url'] ),
											'class'	=> 'exad-table-th-img'
										]); ?>
										<?php echo Group_Control_Image_Size::get_attachment_image_html( $heading_title, 'image_size', 'exad_table_heading_img' ); ?>
									<?php endif;
								endif;
								echo esc_html( $heading_title['exad_table_heading_col'] ); ?>
							</th>
							<?php $i++;
			        	endforeach; ?>
			        </tr>
			    </thead>

			  	<tbody>
					<?php for( $i = 0; $i < count( $table_tr ); $i++ ) : ?>
						<tr class="exad-table-row">
							<?php for( $j = 0; $j < count( $table_td ); $j++ ) :
								if( $table_tr[$i]['id'] == $table_td[$j]['row_id'] ) :
									if($table_td[$j]['tr_id']){
										$this->add_render_attribute('table_inside_td'.$i.$j,
											[
												'id'   => $table_td[$j]['tr_id']
											]
										);
									}
									if($table_td[$j]['colspan'] > 1){
										$this->add_render_attribute('table_inside_td'.$i.$j,
											[
												'colspan'	=> $table_td[$j]['colspan']
											]									
										);
									}
									if($table_td[$j]['rowspan'] > 1){
										$this->add_render_attribute('table_inside_td'.$i.$j,
											[
												'rowspan'	=> $table_td[$j]['rowspan']
											]									
										);
									}
									$td_custom_style = $td_custom_alignment = '';
									if( 'true' == $table_td[$j]['custom_style_enable']){
										$td_color        = $table_td[$j]['custom_style_color'];
										$td_bg_color     = $table_td[$j]['custom_style_bg_color'];
										$td_alignment    = $table_td[$j]['custom_style_alignment'];
										$td_border_style = $table_td[$j]['custom_style_border_style'];
										$td_border_width = $table_td[$j]['custom_style_border_width'];
										$td_border_color = $table_td[$j]['custom_style_border_color'];
										$top = $td_border_width[0]["top"].$td_border_width[0]["unit"].' ';
										$right = $td_border_width[0]["right"].$td_border_width[0]["unit"].' ';
										$bottom = $td_border_width[0]["bottom"].$td_border_width[0]["unit"].' ';
										$left = $td_border_width[0]["left"].$td_border_width[0]["unit"].' ';
										if($td_color || $td_bg_color || $td_border_style || $td_border_width || $td_border_color){
											$td_custom_style = 'style="';
											$td_color ? $td_custom_style     .= 'color: '.esc_attr($td_color).';' : '';
											$td_bg_color ? $td_custom_style  .= 'background-color: '.esc_attr($td_bg_color).';' : '';
											$td_border_style ? $td_custom_style .= 'border-style: ' . esc_attr($td_border_style) . ';' : '';
											$td_border_width ? $td_custom_style .= 'border-width: ' . $top . $right . $bottom . $left . ';' : '';
											$td_border_color ? $td_custom_style .= 'border-color: ' . esc_attr($td_border_color) . ';' : '';
											$td_custom_style                 .= '"';
										}
										$td_alignment ? $td_custom_alignment = 'style="justify-content: '.esc_attr($td_alignment).';"' : '';
									} ?>
									
									<td <?php echo $this->get_render_attribute_string('table_inside_td'.$i.$j); ?> <?php echo $td_custom_style; ?>>
										<div class="exad-td-content-wrapper">
											<div class="exad-td-content" <?php echo $td_custom_alignment; ?>>
												<?php if( 'true' == $table_td[$j]['icon_image_enable'] && 'icon' == $table_td[$j]['icon_image_type'] && ! empty( $table_td[$j]['icon']['value'] ) ) : ?>
													<i class="<?php echo $table_td[$j]['icon']['value']; ?> exad-table-content-icon"></i>
												<?php endif;
												if( 'true' == $table_td[$j]['icon_image_enable'] && 'image' == $table_td[$j]['icon_image_type'] ) :
													$this->add_render_attribute('exad_table_td_img', [
														'class'	=> 'exad-table-td-img'
													]); ?>
													<?php echo wp_get_attachment_image($table_td[$j]['image_id']['id'], $table_td[$j]['image_size'] ); ?>
												<?php endif;

												if( $table_td[$j]['link_url'] ): ?>
													<a href="<?php echo esc_url( $table_td[$j]['link_url'] ); ?>" <?php echo $table_td[$j]['link_target']; ?> <?php echo $table_td[$j]['nofollow']; ?>>
														<?php echo wp_kses_post($table_td[$j]['title']); ?>
													</a>
												<?php else:
													echo wp_kses_post($table_td[$j]['title']);
												endif; ?>
											</div>
										</div>
									</td>
								<?php endif; ?>
							<?php endfor; ?>
						</tr>
			        <?php endfor; ?>
			    </tbody>
			</table>
		</div>
		<?php
	}
}