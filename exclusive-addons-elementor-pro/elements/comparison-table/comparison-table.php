<?php
namespace ExclusiveAddons\Elements;

if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.

use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Border;
use \Elementor\Group_Control_Box_Shadow;
use \Elementor\Group_Control_Typography;
use \Elementor\Widget_Base;
use \Elementor\REPEATER;

class Comparison_Table extends Widget_Base {

	public function get_name() {
		return 'exad-comparison-table';
	}

	public function get_title() {
		return __( 'Comparison Table', 'exclusive-addons-elementor-pro' );
	}

	public function get_icon() {
		return 'exad exad-logo exad-comparison-table';
	}

	public function get_keywords() {
        return [ 'exclusive', 'comparison', 'table', 'compare' ];
    }

	public function get_categories() {
		return ['exclusive-addons-elementor'];
	}

	protected function register_controls() {
		$exad_primary_color = get_option( 'exad_primary_color_option', '#7a56ff' );

		$this->start_controls_section(
			'exad_table_heading',
			[
				'label' => __( 'Heading', 'exclusive-addons-elementor-pro' )
			]
		);

		$ct_heading_repeater = new Repeater();

		$ct_heading_repeater->add_control(
            'exad_table_heading_col', 
            [
				'label'       => __( 'Heading Name', 'exclusive-addons-elementor-pro' ),
				'default'     => 'Heading',
				'type'        => Controls_Manager::TEXT,
				'label_block' => false
			]
		);
		
		$ct_heading_repeater->add_control(
            'exad_table_heading_currency_symbol', 
            [
				'label'       => __( 'Currency Symbol', 'exclusive-addons-elementor-pro' ),
				'default'     => __( '$', 'exclusive-addons-elementor-pro' ),
				'placeholder' => __( '$', 'exclusive-addons-elementor-pro' ),
				'type'        => Controls_Manager::TEXT,
				'label_block' => false
			]
		);
		
		$ct_heading_repeater->add_control(
            'exad_table_heading_current_price', 
            [
				'label'       => __( 'Price', 'exclusive-addons-elementor-pro' ),
				'default'     => __( '19.49', 'exclusive-addons-elementor-pro' ),
				'type'        => Controls_Manager::TEXT,
				'label_block' => false
			]
		);
		
		$ct_heading_repeater->add_control(
            'exad_table_heading_discount_price_enabled', 
            [
				'label'        => __( 'Discount Price', 'exclusive-addons-elementor-pro' ),
				'label_on'     => __( 'Enable', 'exclusive-addons-elementor-pro' ),
				'label_off'    => __( 'Disable', 'exclusive-addons-elementor-pro' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => 'no',
				'return_value' => 'yes'
			]
		);
		
		$ct_heading_repeater->add_control(
            'exad_table_heading_regular_price', 
            [
				'label'       => __( 'Regular Price', 'exclusive-addons-elementor-pro' ),
				'type'        => Controls_Manager::TEXT,
				'label_block' => false,
				'condition'   => [
					'exad_table_heading_discount_price_enabled' => 'yes'
				]
			]
		);
		
		$ct_heading_repeater->add_control(
            'exad_table_heading_duration', 
            [
				'label'       => __( 'Duration', 'exclusive-addons-elementor-pro' ),
				'default'     => __( '/year', 'exclusive-addons-elementor-pro' ),
				'type'        => Controls_Manager::TEXT,
				'label_block' => false
			]
		);
		
		$ct_heading_repeater->add_control(
            'exad_table_heading_ribbon_enabled', 
            [
				'label'        => __( 'Ribbon', 'exclusive-addons-elementor-pro' ),
				'label_on'     => __( 'Enable', 'exclusive-addons-elementor-pro' ),
				'label_off'    => __( 'Disable', 'exclusive-addons-elementor-pro' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => 'no',
				'return_value' => 'yes'
			]
		);
		
		$ct_heading_repeater->add_control(
            'exad_table_heading_ribbon_text', 
            [
				'name'        => 'exad_table_heading_ribbon_text',
				'label'       => __( 'Ribbon Text', 'exclusive-addons-elementor-pro' ),
				'default'     => __( 'Popular', 'exclusive-addons-elementor-pro' ),
				'type'        => Controls_Manager::TEXT,
				'label_block' => false,
				'condition'   => [
					'exad_table_heading_ribbon_enabled' => 'yes'
				]
			]
		);
		
		$ct_heading_repeater->add_control(
            'exad_table_ribbon_position', 
            [
				'label'       => __( 'Ribbon Position', 'exclusive-addons-elementor-pro' ),
				'type'        => Controls_Manager::CHOOSE,
				'default'     => 'top',
				'label_block' => false,
				'options'     => [
					'left'      => [
						'title' => __( 'Left', 'exclusive-addons-elementor-pro' ),
						'icon'  => 'eicon-h-align-left'
					],
					'top'       => [
						'title' => __( 'Top', 'exclusive-addons-elementor-pro' ),
						'icon'  => 'eicon-v-align-top'
					],
					'right'     => [
						'title' => __( 'Right', 'exclusive-addons-elementor-pro' ),
						'icon'  => 'eicon-h-align-right'
					]
				],
				'condition'   => [
					'exad_table_heading_ribbon_enabled' => 'yes'
				]
			]
		);
		
		$ct_heading_repeater->add_control(
            'exad_table_heading_col_span', 
            [
				'label'   => __( 'Col Span', 'exclusive-addons-elementor-pro' ),
				'default' => '',
				'type'    => Controls_Manager::NUMBER,
				'default' => 1,
				'min'     => 1
			]
		);
		
		$ct_heading_repeater->add_control(
            'exad_table_heading_custom_style_enabled', 
            [
				'label'        => __( 'Custom Style?', 'exclusive-addons-elementor-pro' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => 'no',
				'return_value' => 'true'
			]
		);
		
		$ct_heading_repeater->add_control(
            'exad_table_heading_custom_style_alignment', 
            [
				'label'         => __( 'Text Alignment', 'exclusive-addons-elementor-pro' ),
				'type'          => Controls_Manager::CHOOSE,
				'default'       => 'center',
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
				'condition' => [
					'exad_table_heading_custom_style_enabled' => 'true'
				]
			]
		);
		
		$ct_heading_repeater->add_control(
            'exad_table_heading_custom_style_color', 
            [
				'label'     => __( 'Color', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => [
					'exad_table_heading_custom_style_enabled' => 'true'
				]
			]
		);
		
		$ct_heading_repeater->add_control(
            'exad_table_heading_custom_style_bg_color', 
            [
				'label'     => __( 'Background Color', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => [
					'exad_table_heading_custom_style_enabled' => 'true'
				]
			]
		);
		
		$ct_heading_repeater->add_control(
            'exad_table_heading_custom_style_border_style', 
            [
				'label'   => __( 'Border Style', 'exclusive-addons-elementor-pro' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'none',
				'options' => [
					'none'   => __( 'None', 'exclusive-addons-elementor-pro' ),
					'solid'  => __( 'Solid', 'exclusive-addons-elementor-pro' ),
					'dashed' => __( 'Dashed', 'exclusive-addons-elementor-pro' ),
					'dotted' => __( 'Dotted', 'exclusive-addons-elementor-pro' ),
					'double' => __( 'Double', 'exclusive-addons-elementor-pro' )
				],
				'condition' => [
					'exad_table_heading_custom_style_enabled' => 'true'
				]
			]
		);
		
		$ct_heading_repeater->add_control(
            'exad_table_heading_custom_style_border_width', 
            [
				'label'      => __( 'Border Width', 'exclusive-addons-elementor-pro' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'condition'  => [
					'exad_table_heading_custom_style_enabled'       => 'true',
					'exad_table_heading_custom_style_border_style!' => 'none'
				]
			]
		);
		
		$ct_heading_repeater->add_control(
            'exad_table_heading_custom_style_border_color', 
            [
				'label'     => __( 'Boeder Color', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => [
					'exad_table_heading_custom_style_enabled'       => 'true',
					'exad_table_heading_custom_style_border_style!' => 'none'
				]
			]
        );

		$this->add_control(
			'exad_table_heading_columns',
			[
				'type'    => Controls_Manager::REPEATER,
				'fields' 	=> $ct_heading_repeater->get_controls(),
				'default' => [
					[ 'exad_table_heading_col' => 'Table Heading 1' ],
					[ 'exad_table_heading_col' => 'Table Heading 2' ],
					[ 'exad_table_heading_col' => 'Table Heading 3' ],
					[ 'exad_table_heading_col' => 'Table Heading 4' ]
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
				'label' => __( 'Body', 'exclusive-addons-elementor-pro' )
			]
		);

		$ct_body_repeater = new Repeater();

		$ct_body_repeater->add_control(
            'exad_table_body_row_type', 
            [
				'label'       => __( 'Row Type', 'exclusive-addons-elementor-pro' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => 'row',
				'label_block' => false,
				'options'     => [
					'row' => __( 'Row', 'exclusive-addons-elementor-pro' ),
					'col' => __( 'Column', 'exclusive-addons-elementor-pro' )
				]
			]
		);
		
		$ct_body_repeater->add_control(
            'exad_table_body_row_colspan', 
            [
				'label'       => __( 'Col Span', 'exclusive-addons-elementor-pro' ),
				'type'        => Controls_Manager::NUMBER,
				'description' => __( 'Default: 1 (optional).', 'exclusive-addons-elementor-pro' ),
				'default'     => 1,
				'min'         => 1,
				'condition'   => [
					'exad_table_body_row_type' => 'col'
				]
			]
		);
		
		$ct_body_repeater->add_control(
            'exad_table_body_row_rowspan', 
            [
				'name'        => 'exad_table_body_row_rowspan',
				'label'       => __( 'Row Span', 'exclusive-addons-elementor-pro' ),
				'type'        => Controls_Manager::NUMBER,
				'description' => __( 'Default: 1 (optional).', 'exclusive-addons-elementor-pro' ),
				'default'     => 1,
				'min'         => 1,
				'condition'   => [
					'exad_table_body_row_type' => 'col'
				]
			]
		);
		
		$ct_body_repeater->add_control(
            'exad_table_body_content_type', 
            [
				'label'     => __( 'Content', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::CHOOSE,
				'default'   => 'text',
				'options'   => [
					'yes'       => [
						'title' => __( 'Yes', 'exclusive-addons-elementor-pro' ),
						'icon'  => 'eicon-check'
					],
					'no'        => [
						'title' => __( 'No', 'exclusive-addons-elementor-pro' ),
						'icon'  => 'eicon-close'
					],
					'text'      => [
						'title' => __( 'Text', 'exclusive-addons-elementor-pro' ),
						'icon'  => 'eicon-text-area'
					],
					'button'    => [
						'title' => __( 'Button', 'exclusive-addons-elementor-pro' ),
						'icon'  => 'eicon-button'
					]
				],
				'condition' => [
					'exad_table_body_row_type' => 'col'
				]
			]
		);
		
		$ct_body_repeater->add_control(
            'exad_table_body_text', 
            [
				'label'     => __( 'Text', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::TEXTAREA,
				'default'   => __( 'Type your text...', 'exclusive-addons-elementor-pro' ),
				'condition' => [
					'exad_table_body_content_type' => 'text',
					'exad_table_body_row_type'     => 'col'
				]
			]
		);
		
		$ct_body_repeater->add_control(
            'exad_table_body_tooltip_enabled', 
            [
				'label'        => __( 'Tooltip', 'exclusive-addons-elementor-pro' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => 'no',
				'return_value' => 'yes',
				'condition'    => [
					'exad_table_body_row_type'     => 'col',
					'exad_table_body_content_type' => 'text'
				]
			]
		);
		
		$ct_body_repeater->add_control(
            'exad_table_body_tooltip_text', 
            [
				'name'      => 'exad_table_body_tooltip_text',
				'label'     => __( 'Tooltip Text', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::TEXTAREA,
				'default'   => __( 'Tooltip', 'exclusive-addons-elementor-pro' ),
				'condition' => [
					'exad_table_body_content_type'    => 'text',
					'exad_table_body_row_type'        => 'col',
					'exad_table_body_tooltip_enabled' => 'yes'
				]
			]
		);
		
		$ct_body_repeater->add_control(
            'exad_table_body_button_text', 
            [
				'label'     => __( 'Button Text', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => __( 'Buy Now', 'exclusive-addons-elementor-pro' ),
				'condition' => [
					'exad_table_body_content_type' => 'button',
					'exad_table_body_row_type'     => 'col'
				]
			]
		);
		
		$ct_body_repeater->add_control(
            'exad_table_body_button_link', 
            [
				'label'     => __( 'Button Link', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::URL,
				'condition' => [
					'exad_table_body_content_type' => 'button',
					'exad_table_body_row_type'     => 'col'
				]
			]
		);
		
		$ct_body_repeater->add_control(
            'exad_table_body_row_id_class', 
            [
				'label'       => __( 'CSS ID', 'exclusive-addons-elementor-pro' ),
				'type'        => Controls_Manager::TEXT,
				'label_block' => false,
				'condition'   => [
					'exad_table_body_row_type' => 'col'
				]
			]
		);
		
		$ct_body_repeater->add_control(
            'exad_table_body_custom_style_enabled', 
            [
				'label'        => __( 'Custom Style?', 'exclusive-addons-elementor-pro' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => 'no',
				'return_value' => 'true',
				'condition'    => [
					'exad_table_body_row_type' => 'col'
				]
			]
		);
		
		$ct_body_repeater->add_control(
            'exad_table_body_custom_style_alignment', 
            [
				'label'   => __( 'Text Alignment', 'exclusive-addons-elementor-pro' ),
				'type'    => Controls_Manager::CHOOSE,
				'default' => 'center',
				'options' => [
					'flex-start' => [
						'title'  => __( 'Left', 'exclusive-addons-elementor-pro' ),
						'icon'   => 'eicon-text-align-left'
					],
					'center'     => [
						'title'  => __( 'Center', 'exclusive-addons-elementor-pro' ),
						'icon'   => 'eicon-text-align-center'
					],
					'flex-end'   => [
						'title'  => __( 'Right', 'exclusive-addons-elementor-pro' ),
						'icon'   => 'eicon-text-align-right'
					]
				],
				'condition'      => [
					'exad_table_body_custom_style_enabled' => 'true',
					'exad_table_body_row_type'             => 'col'
				]
			]
		);
		
		$ct_body_repeater->add_control(
            'exad_table_body_custom_style_color', 
            [
				'label'     => __( 'Color', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => [
					'exad_table_body_custom_style_enabled' => 'true',
					'exad_table_body_row_type'             => 'col'
				]
			]
		);
		
		$ct_body_repeater->add_control(
            'exad_table_body_custom_style_bg_color', 
            [
				'label'     => __( 'Background Color', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => [
					'exad_table_body_custom_style_enabled' => 'true',
					'exad_table_body_row_type'             => 'col'
				]
			]
		);
		
		$ct_body_repeater->add_control(
            'exad_table_body_custom_style_border_style', 
            [
				'label'   => __( 'Border Style', 'exclusive-addons-elementor-pro' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'none',
				'options' => [
					'none'   => __( 'None', 'exclusive-addons-elementor-pro' ),
					'solid'  => __( 'Solid', 'exclusive-addons-elementor-pro' ),
					'dashed' => __( 'Dashed', 'exclusive-addons-elementor-pro' ),
					'dotted' => __( 'Dotted', 'exclusive-addons-elementor-pro' ),
					'double' => __( 'Double', 'exclusive-addons-elementor-pro' )
				],
				'condition' => [
					'exad_table_body_custom_style_enabled' => 'true',
					'exad_table_body_row_type'             => 'col'
				]
			]
		);
		
		$ct_body_repeater->add_control(
            'exad_table_body_custom_style_border_width', 
            [
				'label'      => __( 'Border Width', 'exclusive-addons-elementor-pro' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'condition'  => [
					'exad_table_body_custom_style_enabled'       => 'true',
					'exad_table_body_row_type'                   => 'col',
					'exad_table_body_custom_style_border_style!' => 'none'
				]
			]
		);
		
		$ct_body_repeater->add_control(
            'exad_table_body_custom_style_border_color', 
            [
				'label'     => __( 'Boeder Color', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => [
					'exad_table_body_custom_style_enabled'       => 'true',
					'exad_table_body_row_type'                   => 'col',
					'exad_table_body_custom_style_border_style!' => 'none'
				]
			]
        );

		$this->add_control(
			'exad_table_body_rows',
			[
				'type' => Controls_Manager::REPEATER,
				'fields' 	=> $ct_body_repeater->get_controls(),
				'seperator' => 'before',
				'default' => [
					[ 'exad_table_body_row_type' => 'row' ],
					[ 'exad_table_body_row_type' => 'col' ],
					[ 'exad_table_body_row_type' => 'col' ],
					[ 'exad_table_body_row_type' => 'col' ],
					[ 'exad_table_body_row_type' => 'col' ]
				],
				'title_field' => '{{exad_table_body_row_type}}::{{exad_table_body_text}}'
			]
		);

		$this->end_controls_section();

		/**
		 * Exad Table Container
		 */

		$this->start_controls_section(
			'exad_table_container',
			[
				'label' => __( 'Container', 'exclusive-addons-elementor-pro' ),
				'tab'   => Controls_Manager::TAB_STYLE
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'exad_table_container_border',
				'selector' => '{{WRAPPER}} .exad-table-container'
			]
		);

		$this->add_responsive_control(
			'exad_table_container_border_radius',
			[
				'label' => __( 'Border Radius', 'exclusive-addons-elementor-pro' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 30
					]
				],
				'selectors' => [
					'{{WRAPPER}} .exad-table-container' => 'border-radius: {{SIZE}}px {{SIZE}}px {{SIZE}}px {{SIZE}}px; border-collapse: collapse;'
				],
				'description' => __( '<b>If you apply Border Radius then Table Border won\'t work.</b>', 'exclusive-addons-elementor-pro' )
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'exad_table_container_border_box_shadow',
				'selector' => '{{WRAPPER}} .exad-table-container'
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'exad_table_heading_style_tab',
			[
				'label' => __( 'Heading', 'exclusive-addons-elementor-pro' ),
				'tab'   => Controls_Manager::TAB_STYLE
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'exad_table_heading_typography',
				'selector' => '{{WRAPPER}} .exad-table-container tr.table-heading th span.exad-table-heading'
			]
		);

		$this->add_responsive_control(
			'exad_table_heading_alignment',
			[
				'label'   => __( 'Text Alignment', 'exclusive-addons-elementor-pro' ),
				'type'    => Controls_Manager::CHOOSE,
				'default' => 'center',
				'options' => [
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
					'{{WRAPPER}} .exad-table-container tr.table-heading th' => 'text-align: {{VALUE}};'
				]
			]
		);

		$this->add_responsive_control(
			'exad_table_heading_padding',
			[
				'label'      => __( 'Padding', 'exclusive-addons-elementor-pro' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em'],
				'default'    => [
					'top'    => '15',
					'right'  => '15',
					'bottom' => '15',
					'left'   => '15'
				],
				'selectors' => [
					'{{WRAPPER}} .exad-table-container tr.table-heading th' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
		);

		$this->add_responsive_control(
			'exad_table_heading_border_radius',
			[
				'label' => __( 'Header Top & left Border Radius', 'exclusive-addons-elementor-pro' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px'      => [
						'max' => 40
					]
				],
				'selectors' => [
					'{{WRAPPER}} .exad-table-container tr.table-heading th:first-child' => 'border-radius: {{SIZE}}px 0px 0px 0px;',
					'{{WRAPPER}} .exad-table-container tr.table-heading th:last-child'  => 'border-radius: 0px {{SIZE}}px 0px 0px;'
				]
			]
		);

		$this->start_controls_tabs( 'exad_table_heading_normal_hover_tab' );

		$this->start_controls_tab( 'exad_table_heading_normal', ['label' => __( 'Normal', 'exclusive-addons-elementor-pro' ) ] );

		$this->add_control(
			'exad_table_heading_color',
			[
				'label'     => __( 'Color', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .exad-table-container tr.table-heading th' => 'color: {{VALUE}};'
				]
			]
		);

		$this->add_control(
			'exad_table_heading_bg_color',
			[
				'label'     => __( 'Background Color', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => $exad_primary_color,
				'selectors' => [
					'{{WRAPPER}} .exad-table-container tr.table-heading th' => 'background-color: {{VALUE}};'
				]
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'            => 'exad_table_heading_border',
				'selector'        => '{{WRAPPER}} .exad-table-container tr.table-heading th',
				'fields_options'  => [
					'border'      => [
						'default' => 'solid'
					],
					'width'       => [
						'default'    => [
							'top'    => '1',
							'right'  => '1',
							'bottom' => '1',
							'left'   => '1'
						]
					],
					'color' => [
						'default' => $exad_primary_color
					]
				]
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab( 'exad_table_heading_hover', ['label' => __( 'Hover', 'exclusive-addons-elementor-pro' )]);

		$this->add_control(
			'exad_table_heading_hover_color',
			[
				'label'     => __( 'Color', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .exad-table-container tr.table-heading th:hover' => 'color: {{VALUE}};'
				]
			]
		);

		$this->add_control(
			'exad_table_heading_hover_bg_color',
			[
				'label'     => __( 'Background Color', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .exad-table-container tr.table-heading th:hover' => 'background-color: {{VALUE}};'
				]
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'exad_table_heading_hover_border',
				'selector' => '{{WRAPPER}} .exad-table-container tr.table-heading th:hover'
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		$this->start_controls_section(
			'exad_table_pricing_style_tab',
			[
				'label' => __( 'Pricing & Duration', 'exclusive-addons-elementor-pro' ),
				'tab'   => Controls_Manager::TAB_STYLE
			]
		);

		$this->add_responsive_control(
			'exad_table_pricing_padding',
			[
				'label'      => __( 'Padding', 'exclusive-addons-elementor-pro' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'default'    => [
					'top'    => '20',
					'right'  => '0',
					'bottom' => '0',
					'left'   => '0'
				],
				'selectors'  => [
					'{{WRAPPER}} .exad-heading-pricing-wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
		);

		$this->add_control(
			'exad_table_regular_pricing_style',
			[
				'label'     => __( 'Regular Price', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before'
			]
		);
		$this->add_control(
			'exad_table_regular_pricing_color',
			[
				'label'     => __( 'Color', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .exad-heading-regular-price' => 'color: {{VALUE}};'
				]
			]
		);
		$this->add_control(
			'exad_table_regular_pricing_line_through_color',
			[
				'label'     => __( 'Discount Line Color', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .exad-heading-regular-price' => 'text-decoration-color: {{VALUE}};'
				]
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'exad_table_regular_pricing_typography',
				'selector' => '{{WRAPPER}} .exad-heading-regular-price'
			]
		);

		$this->add_responsive_control(
			'exad_table_regular_pricing_right_spacing',
			[
				'label'      => __( 'Right Spacing', 'exclusive-addons-elementor-pro' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px'     => [
						'min'  => 0,
						'max'  => 100,
						'step' => 1
					]
				],
				'selectors'  => [
					'{{WRAPPER}} .exad-heading-regular-price' => 'margin-right: {{SIZE}}{{UNIT}};'
				]
			]
		);

		$this->add_control(
			'exad_table_currency_style',
			[
				'label'     => __( 'Currency( Price )', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before'
			]
		);
		$this->add_control(
			'exad_table_currency_color',
			[
				'label'     => __( 'Color', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .exad-heading-pricing-currency' => 'color: {{VALUE}};'
				]
			]
		);

		$this->add_responsive_control(
			'exad_table_currency_size',
			[
				'label'      => __( 'Size', 'exclusive-addons-elementor-pro' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px'     => [
						'min'  => 0,
						'max'  => 100,
						'step' => 1
					]
				],
				'selectors'  => [
					'{{WRAPPER}} .exad-heading-pricing-currency' => 'font-size: {{SIZE}}{{UNIT}};'
				]
			]
		);

		$this->add_control(
			'exad_table_current_price_style',
			[
				'label'     => __( 'Price', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before'
			]
		);

		$this->add_control(
			'exad_table_current_price_color',
			[
				'label'     => __( 'Color', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .exad-heading-current-price' => 'color: {{VALUE}};'
				]
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'exad_table_current_price_typography',
				'selector' => '{{WRAPPER}} .exad-heading-current-price'
			]
		);

		$this->add_control(
			'exad_table_current_price_fractional_style',
			[
				'label'     => __( 'Fractional( Price )', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before'
			]
		);

		$this->add_control(
			'exad_table_current_price_fractional_text_color',
			[
				'label'     => __( 'Color', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .exad-heading-current-fractional-price' => 'color: {{VALUE}};'
				]
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'exad_table_current_price_fractional_typography',
				'selector' => '{{WRAPPER}} .exad-heading-current-fractional-price'
			]
		);
		
		$this->add_control(
			'exad_table_duration_style',
			[
				'label'     => __( 'Duration', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before'
			]
		);

		$this->add_control(
			'exad_table_duration_color',
			[
				'label'     => __( 'Color', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .exad-heading-pricing-duration' => 'color: {{VALUE}};'
				]
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'exad_table_duration_typography',
				'selector' => '{{WRAPPER}} .exad-heading-pricing-duration'
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'exad_table_body_style_tab',
			[
				'label' => __( 'Body', 'exclusive-addons-elementor-pro' ),
				'tab' => Controls_Manager::TAB_STYLE
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'exad_table_body_typography',
				'selector' => '{{WRAPPER}} .exad-table-container tbody td'
			]
		);

		$this->add_responsive_control(
			'exad_table_body_alignment',
			[
				'label'   => __( 'Text Alignment', 'exclusive-addons-elementor-pro' ),
				'type'    => Controls_Manager::CHOOSE,
				'default' => 'center',
				'options' => [
					'flex-start' => [
						'title'  => __( 'Left', 'exclusive-addons-elementor-pro' ),
						'icon'   => 'eicon-text-align-left'
					],
					'center'     => [
						'title'  => __( 'Center', 'exclusive-addons-elementor-pro' ),
						'icon'   => 'eicon-text-align-center'
					],
					'flex-end'   => [
						'title'  => __( 'Right', 'exclusive-addons-elementor-pro' ),
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
				],
				'description' => __( 'Won\'t work where tooltip is enabled', 'exclusive-addons-elementor-pro' )
			]
		);

		$this->add_responsive_control(
			'exad_table_body_padding',
			[
				'label'      => __( 'Padding', 'exclusive-addons-elementor-pro' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em'],
				'default'    => [
					'top'    => '15',
					'right'  => '15',
					'bottom' => '15',
					'left'   => '15'
				],
				'selectors' => [
					'{{WRAPPER}} .exad-table-container tbody td' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'            => 'exad_table_body_border',
				'fields_options'  => [
					'border'      => [
						'default' => 'solid',
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
				'selector' => '{{WRAPPER}} .exad-table-container tbody td'
			]
		);

		$this->add_responsive_control(
			'exad_table_body_border_radius',
			[
				'label' => __( 'Last Row Border Radius', 'exclusive-addons-elementor-pro' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px'      => [
						'max' => 40
					]
				],
				'selectors'   => [
					'{{WRAPPER}} .exad-table-container tr:last-child td:first-of-type' => 'border-radius: 0px 0px 0px {{SIZE}}px;',
					'{{WRAPPER}} .exad-table-container tr:last-child td:last-of-type' => 'border-radius: 0px 0px {{SIZE}}px 0px;'
				]
			]
		);

		$this->start_controls_tabs( 'exad_table_body_normal_hover_tab' );

		$this->start_controls_tab( 'exad_table_body_normal', ['label' => __( 'Normal', 'exclusive-addons-elementor-pro' )]);

		$this->add_control(
			'exad_table_body_odd_row_style_heading',
			[
				'label' => __( 'Odd Row', 'exclusive-addons-elementor-pro' ),
				'type'  => Controls_Manager::HEADING
			]
		);

		$this->add_control(
			'exad_table_body_odd_row_color',
			[
				'label'     => __( 'Color', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .exad-table-container tbody > tr:nth-child(2n+1) td' => 'color: {{VALUE}};'
				]
			]
		);

		$this->add_control(
			'exad_table_body_odd_row_bg_color',
			[
				'label'     => __( 'Background Color', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .exad-table-container tbody > tr:nth-child(2n+1) td' => 'background-color: {{VALUE}};'
				]
			]
		);

		$this->add_control(
			'exad_table_body_even_row_style_heading',
			[
				'label' => __( 'Even Row', 'exclusive-addons-elementor-pro' ),
				'type'  => Controls_Manager::HEADING
			]
		);

		$this->add_control(
			'exad_table_body_even_row_color',
			[
				'label'     => __( 'Color', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .exad-table-container tbody > tr:nth-child(2n) td' => 'color: {{VALUE}};'
				]
			]
		);

		$this->add_control(
			'exad_table_body_even_row_bg_color',
			[
				'label'     => __( 'Background Color', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .exad-table-container tbody > tr:nth-child(2n) td' => 'background-color: {{VALUE}};'
				]
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab( 'exad_table_body_hover', [ 'label' => __( 'Hover', 'exclusive-addons-elementor-pro' ) ] );

		$this->add_control(
			'exad_table_body_odd_row_hover_style_heading',
			[
				'label' => __( 'Odd Row', 'exclusive-addons-elementor-pro' ),
				'type'  => Controls_Manager::HEADING
			]
		);

		$this->add_control(
			'exad_table_body_odd_row_hover_color',
			[
				'label'     => __( 'Color', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .exad-table-container tbody > tr:nth-child(2n+1) td:hover' => 'color: {{VALUE}};'
				]
			]
		);

		$this->add_control(
			'exad_table_body_odd_row_hover_bg_color',
			[
				'label'     => __( 'Background Color', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .exad-table-container tbody > tr:nth-child(2n+1) td:hover' => 'background-color: {{VALUE}};'
				]
			]
		);

		$this->add_control(
			'exad_table_body_even_row_hover_style_heading',
			[
				'label' => __( 'Even Row', 'exclusive-addons-elementor-pro' ),
				'type'  => Controls_Manager::HEADING
			]
		);

		$this->add_control(
			'exad_table_body_even_row_hover_color',
			[
				'label'     => __( 'Color', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .exad-table-container tbody > tr:nth-child(2n) td:hover' => 'color: {{VALUE}};'
				]
			]
		);

		$this->add_control(
			'exad_table_body_even_row_hover_bg_color',
			[
				'label'     => __( 'Background Color', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .exad-table-container tbody > tr:nth-child(2n) td:hover' => 'background-color: {{VALUE}};'
				]
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_control(
			'exad_table_body_yes_no_icon_style',
			[
				'label' => __( 'Yes/No Icon', 'exclusive-addons-elementor-pro' ),
				'type'  => Controls_Manager::HEADING
			]
		);

		$this->start_controls_tabs( 'exad_table_body_yes_no_style_tabs' );

		$this->start_controls_tab( 'exad_table_body_yes_style', [ 'label' => __( 'Yes', 'exclusive-addons-elementor-pro' ) ] );

		$this->add_control(
			'exad_table_body_yes_color',
			[
				'label'     => __( 'Color', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .eicon-check.exad-table-content-icon' => 'color: {{VALUE}};'
				]
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab( 'exad_table_body_no_style', ['label' => __( 'No', 'exclusive-addons-elementor-pro' )]);

		$this->add_control(
			'exad_table_body_no_color',
			[
				'label'     => __( 'Color', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .eicon-close.exad-table-content-icon' => 'color: {{VALUE}};'
				]
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		$this->start_controls_section(
			'exad_table_tooltip_style',
			[
				'label' => __( 'Tooltip', 'exclusive-addons-elementor-pro' ),
				'tab'   => Controls_Manager::TAB_STYLE
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'exad_table_tooltip_typography',
				'selector' => '{{WRAPPER}} .exad-tooltip-text'
			]
		);

		$this->add_responsive_control(
			'exad_table_tooltip_width',
			[
				'label'    => __( 'Width', 'exclusive-addons-elementor-pro' ),
				'type'     => Controls_Manager::SLIDER,
				'default'  => [
					'size' => 120
				],
				'range'       => [
					'px'      => [
						'max' => 500
					]
				],
				'selectors' => [
					'{{WRAPPER}} .exad-tooltip-text' => 'min-width: {{SIZE}}px; left: calc( 50% - {{SIZE}}px/2 );'
				]
			]
		);

		$this->add_responsive_control(
			'exad_table_tooltip_padding',
			[
				'label'      => __( 'Padding', 'exclusive-addons-elementor-pro' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .exad-tooltip-text' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
		);

		$this->add_responsive_control(
			'exad_table_tooltip_border_radius',
			[
				'label'      => __( 'Border Radius', 'exclusive-addons-elementor-pro' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%', 'em'],
				'selectors'  => [
					'{{WRAPPER}} .exad-tooltip-text' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				],
			]
		);

		$this->start_controls_tabs( 'exad_table_tooltip_icon_text_style' );

		$this->start_controls_tab( 'exad_table_tooltip_icon_style', ['label' => __( 'Icon', 'exclusive-addons-elementor-pro' )]);

		$this->add_control(
			'exad_table_tooltip_icon_color',
			[
				'label'     => __( 'Color', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .exad-td-tooltip .eicon-info-circle' => 'color: {{VALUE}};'
				]
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab( 'exad_table_tooltip_text_style', ['label' => __( 'Text', 'exclusive-addons-elementor-pro' )]);

		$this->add_control(
			'exad_table_tooltip_text_color',
			[
				'label'     => __( 'Color', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .exad-tooltip-text' => 'color: {{VALUE}};'
				]
			]
		);

		$this->add_control(
			'exad_table_tooltip_text_bg_color',
			[
				'label'     => __( 'Background Color', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#000000',
				'selectors' => [
					'{{WRAPPER}} .exad-tooltip-text' => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .exad-tooltip-text::before' => 'border-top-color: {{VALUE}};'
				]
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		$this->start_controls_section(
			'exad_table_ribbon_style',
			[
				'label' => __( 'Ribbon', 'exclusive-addons-elementor-pro' ),
				'tab' => Controls_Manager::TAB_STYLE
			]
		);

		$this->add_responsive_control(
			'exad_table_ribbon_distance',
			[
				'label'     => __( 'Distance( Except Top Position )', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px'      => [
						'min' => 0,
						'max' => 100
					]
				],
				'selectors' => [
					'{{WRAPPER}} .exad-table-ribbon-content.exad-table-ribbon-left .exad-table-ribbon-wrapper, {{WRAPPER}} .exad-table-ribbon-content.exad-table-ribbon-right .exad-table-ribbon-wrapper' => 'margin-top: {{SIZE}}{{UNIT}};'
				]
			]
		);

		$this->add_control(
			'exad_table_ribbon_text_color',
			[
				'label'     => __( 'Color', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .exad-table-ribbon-content span' => 'color: {{VALUE}};'
				],
			]
		);
		$this->add_control(
			'exad_table_ribbon_background_color',
			[
				'label'     => __( 'Background Color', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .exad-table-ribbon-content span' => 'background-color: {{VALUE}};'
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'exad_table_ribbon_typography',
				'selector' => '{{WRAPPER}} .exad-table-ribbon-content span'
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'exad_table_ribbon_ribbon_border',
				'selector' => '{{WRAPPER}} .exad-table-ribbon-content span, {{WRAPPER}} .eae-ct-ribbons-yes .eae-ct-ribbons-wrapper-top'
			]
		);
		$this->add_responsive_control(
			'ribbon_text_padding',
			[
				'label'      => __( 'Padding', 'exclusive-addons-elementor-pro' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .exad-table-ribbon-content span' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
		);

		$this->add_responsive_control(
			'exad_table_ribbon_text_radius',
			[
				'label'      => __( 'Border Radius', 'exclusive-addons-elementor-pro' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%', 'em'],
				'selectors'  => [
					'{{WRAPPER}} .exad-table-ribbon-content span' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'exad_table_button_style',
			[
				'label' => __( 'Button', 'exclusive-addons-elementor-pro' ),
				'tab'   => Controls_Manager::TAB_STYLE
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'exad_table_button_typography',
				'selector' => '{{WRAPPER}} .exad-table-content-button'
			]
		);

		$this->add_responsive_control(
			'exad_table_button_border_radius',
			[
				'label'      => __( 'Border Radius', 'exclusive-addons-elementor-pro' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%', 'em'],
				'selectors'  => [
					'{{WRAPPER}} .exad-table-content-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
		);

		$this->add_responsive_control(
			'exad_table_button_padding',
			[
				'label'      => __( 'Padding', 'exclusive-addons-elementor-pro' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%', 'em'],
				'default'    => [
					'top'      => '8',
					'right'    => '15',
					'bottom'   => '8',
					'left'     => '15',
					'isLinked' => false
				],
				'selectors' => [
					'{{WRAPPER}} .exad-table-content-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
		);

		$this->start_controls_tabs( 'exad_table_button_tabs' );

		// Normal State Tab
		$this->start_controls_tab( 'exad_table_button_normal', [ 'label' => __( 'Normal', 'exclusive-addons-elementor-pro' ) ] );

		$this->add_control(
			'exad_table_button_normal_text_color',
			[
				'label'     => __( 'Text Color', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => $exad_primary_color,
				'selectors' => [
					'{{WRAPPER}} .exad-table-content-button' => 'color: {{VALUE}};'
				]
			]
		);

		$this->add_control(
			'exad_table_button_normal_bg_color',
			[
				'label'     => __( 'Background Color', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .exad-table-content-button' => 'background-color: {{VALUE}};'
				]
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'               => 'exad_table_button_normal_border',
				'fields_options'     => [
					'border'         => [
						'default'    => 'solid'
					],
					'width'          => [
						'default'    => [
							'top'    => '2',
							'right'  => '2',
							'bottom' => '2',
							'left'   => '2'
						]
					],
					'color' => [
						'default' => $exad_primary_color
					]
				],
				'selector' => '{{WRAPPER}} .exad-table-content-button'
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'exad_table_button_box_shadow',
				'selector' => '{{WRAPPER}} .exad-table-content-button'
			]
		);

		$this->end_controls_tab();

		// Hover State Tab
		$this->start_controls_tab( 'exad_table_button_hover', [ 'label' => __( 'Hover', 'exclusive-addons-elementor-pro' ) ] );

		$this->add_control(
			'exad_table_button_hover_text_color',
			[
				'label'     => __( 'Text Color', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .exad-table-content-button:hover' => 'color: {{VALUE}};'
				]
			]
		);

		$this->add_control(
			'exad_table_button_hover_bg_color',
			[
				'label'     => __( 'Background Color', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .exad-table-content-button:hover' => 'background-color: {{VALUE}};'
				]
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'exad_table_button_hover_border',
				'selector' => '{{WRAPPER}} .exad-table-content-button:hover'
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'exad_table_button_box_shadow_hover',
				'selector' => '{{WRAPPER}} .exad-table-content-button:hover'
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

	}

	protected function render() {

		$settings = $this->get_settings();

		$table_tr = $table_td = [];

		foreach ( $settings['exad_table_body_rows'] as $content_row ):

			$row_id = uniqid();

			if ( 'row' == $content_row['exad_table_body_row_type'] ):
				$table_tr[] = [
					'id' => $row_id,
					'type' => $content_row['exad_table_body_row_type']
				];
			endif;

			if ( 'col' == $content_row['exad_table_body_row_type'] ):
				$target             = $content_row['exad_table_body_button_link']['is_external'] ? 'target="_blank"' : '';
				$nofollow           = $content_row['exad_table_body_button_link']['nofollow'] ? 'rel="nofollow"' : '';
				$url                = $content_row['exad_table_body_button_link']['url'] ? 'href="' . esc_url( $content_row['exad_table_body_button_link']['url'] ) . '"' : '';
				$exad_table_tr_keys = array_keys( $table_tr );
				$last_key           = end( $exad_table_tr_keys );
				$table_td[]         = [
					'row_id'                    => $table_tr[$last_key]['id'],
					'type'                      => $content_row['exad_table_body_row_type'],
					'body_col_content_type'     => $content_row['exad_table_body_content_type'],
					'text'                      => $content_row['exad_table_body_text'],
					'tooltip-enable'            => $content_row['exad_table_body_tooltip_enabled'],
					'tooltip-text'              => $content_row['exad_table_body_tooltip_text'],
					'button_text'               => $content_row['exad_table_body_button_text'],
					'link_url'                  => $url,
					'link_target'               => $target,
					'nofollow'                  => $nofollow,
					'colspan'                   => $content_row['exad_table_body_row_colspan'],
					'rowspan'                   => $content_row['exad_table_body_row_rowspan'],
					'tr_id'                     => $content_row['exad_table_body_row_id_class'],
					'custom_style_enable'       => $content_row['exad_table_body_custom_style_enabled'],
					'custom_style_alignment'    => $content_row['exad_table_body_custom_style_alignment'],
					'custom_style_color'        => $content_row['exad_table_body_custom_style_color'],
					'custom_style_bg_color'     => $content_row['exad_table_body_custom_style_bg_color'],
					'custom_style_border_style' => $content_row['exad_table_body_custom_style_border_style'],
					'custom_style_border_width' => array( $content_row['exad_table_body_custom_style_border_width'] ),
					'custom_style_border_color' => $content_row['exad_table_body_custom_style_border_color']
				];

			endif;
		endforeach;

		// count total number of table heading
		$table_th_count = count( $settings['exad_table_heading_columns'] );

		$this->add_render_attribute( 'exad_table_container', [
			'class'          => 'exad-table-container',
			'table-table_id' => esc_attr( $this->get_id() )
		] );

		$this->add_render_attribute( 'exad_main_table', [
			'id'    => 'exad-table-id-'.$this->get_id(),
			'class' => 'exad-main-table'
		] );

		$this->add_render_attribute( 'td_content', [
			'class' => 'exad-td-content'
		] );
		?>

		<div <?php echo $this->get_render_attribute_string( 'exad_table_container' ); ?>>
			<table <?php echo $this->get_render_attribute_string( 'exad_main_table' ); ?>>
				<thead>
					<tr class="table-heading">
					<?php
						$i = 0;
						foreach ( $settings['exad_table_heading_columns'] as $heading_title ) :
							if ( $heading_title['exad_table_heading_col_span'] > 1 ) :
								$this->add_render_attribute( 'th_class' . $i,
									[
										'colspan' => $heading_title['exad_table_heading_col_span']
									]
								);
							endif;

							$th_custom_style = '';
							if ( 'true' == $heading_title['exad_table_heading_custom_style_enabled'] ) :
								$th_color                           = $heading_title['exad_table_heading_custom_style_color'];
								$th_bg_color                        = $heading_title['exad_table_heading_custom_style_bg_color'];
								$th_alignment                       = $heading_title['exad_table_heading_custom_style_alignment'];
								$th_border_style                    = $heading_title['exad_table_heading_custom_style_border_style'];
								$th_border_width                    = array( $heading_title['exad_table_heading_custom_style_border_width'] );
								$th_border_color                    = $heading_title['exad_table_heading_custom_style_border_color'];
								$th_custom_style                    = 'style="';
								$th_color ? $th_custom_style        .= 'color: ' . esc_attr( $th_color ) . ';' : '';
								$th_bg_color ? $th_custom_style     .= 'background-color: ' . esc_attr( $th_bg_color ) . ';' : '';
								$th_border_style ? $th_custom_style .= 'border-style: ' . esc_attr( $th_border_style ) . ';' : '';
								$th_border_width ? $th_custom_style .= 'border-width: ' . $th_border_width[0]["top"] . $th_border_width[0]["unit"] .' '. $th_border_width[0]["right"].$th_border_width[0]["unit"].' '. $th_border_width[0]["bottom"].$th_border_width[0]["unit"].' '.$th_border_width[0]["left"].$th_border_width[0]["unit"]. ';' : '';
								$th_border_color ? $th_custom_style .= 'border-color: ' . esc_attr( $th_border_color ) . ';' : '';
								$th_alignment ? $th_custom_style    .= 'text-align: ' . esc_attr( $th_alignment ) . ';' : '';
								$th_custom_style                    .= '"';
							endif;
							?>

							<th <?php echo $this->get_render_attribute_string( 'th_class' . $i) . ' ' . $th_custom_style; ?>>
							<?php
								if ( 'yes' === $heading_title['exad_table_heading_ribbon_enabled'] && ! empty( $heading_title['exad_table_heading_ribbon_text'] ) ): ?>
									<div class="exad-table-ribbon-content exad-table-ribbon-<?php echo esc_attr( $heading_title['exad_table_ribbon_position'] ); ?>">
										<span class="exad-table-ribbon-wrapper">
											<?php echo esc_html( $heading_title['exad_table_heading_ribbon_text'] ); ?>
										</span>
									</div>
								<?php 	
								endif;
							?>	
							<span class="exad-table-heading"><?php echo esc_html( $heading_title['exad_table_heading_col'] ); ?></span>
							<?php
								$current_price     = explode( '.', $heading_title['exad_table_heading_current_price'] );
								$currency_symbol   = $heading_title['exad_table_heading_currency_symbol'];
								$duration          = $heading_title['exad_table_heading_duration'];
								$fractional_digits = $regular_price = '';
								if ( 'yes' === $heading_title['exad_table_heading_discount_price_enabled'] ) :
									$regular_price = $heading_title['exad_table_heading_regular_price'];
								endif;

								if ( $current_price || $fractional_digits || $currency_symbol || $regular_price || $duration ) : ?>
									<div class="exad-heading-pricing-wrapper">
									<?php
										if ( count( $current_price ) > 1 ) :
											$fractional_digits = $current_price[1];
										endif;

										if ( $regular_price ) : ?>
											<span class="exad-heading-regular-price"><?php echo esc_html( $currency_symbol ) . esc_html( $regular_price ); ?></span>
										<?php endif; ?>
										<span class="exad-heading-pricing-currency"><?php echo esc_html( $currency_symbol ); ?></span>
										<span class="exad-heading-current-price"><?php echo esc_html( $current_price[0] ); ?></span>
										<span class="exad-heading-current-fractional-price"><?php echo esc_html( $fractional_digits ); ?></span>
									</div>
									<span class="exad-heading-pricing-duration"><?php echo esc_html( $duration ); ?></span>
								<?php endif; ?>
							</th>
							<?php 
							$i++;
						endforeach;
						?>
					</tr>
				</thead>
				<tbody>
				<?php		
					for ( $i = 0; $i < count( $table_tr ); $i++ ) :
						echo '<tr>';
							for ( $j = 0; $j < count( $table_td ); $j++ ) :
								if ( $table_tr[$i]['id'] == $table_td[$j]['row_id'] ) :
									if ( $table_td[$j]['tr_id'] ) :
										$this->add_render_attribute( 'table_inside_td' . $i . $j,
											[
												'id' => $table_td[$j]['tr_id'],
											]
										);
									endif;
									if ( $table_td[$j]['colspan'] > 1 ) :
										$this->add_render_attribute( 'table_inside_td' . $i . $j,
											[
												'colspan' => $table_td[$j]['colspan'],
											]
										);
									endif;
									if ( $table_td[$j]['rowspan'] > 1 ) :
										$this->add_render_attribute( 'table_inside_td' . $i . $j,
											[
												'rowspan' => $table_td[$j]['rowspan'],
											]
										);
									endif;
									$td_custom_style = $td_custom_alignment = '';
									if ( 'true' == $table_td[$j]['custom_style_enable'] ) :
										$td_color        = $table_td[$j]['custom_style_color'];
										$td_bg_color     = $table_td[$j]['custom_style_bg_color'];
										$td_border_style = $table_td[$j]['custom_style_border_style'];
										$td_border_width = $table_td[$j]['custom_style_border_width'];
										$td_border_color = $table_td[$j]['custom_style_border_color'];
										$td_alignment    = $table_td[$j]['custom_style_alignment'];
										$top             = $td_border_width[0]["top"].$td_border_width[0]["unit"].' ';
										$right           = $td_border_width[0]["right"].$td_border_width[0]["unit"].' ';
										$bottom          = $td_border_width[0]["bottom"].$td_border_width[0]["unit"].' ';
										$left            = $td_border_width[0]["left"].$td_border_width[0]["unit"].' ';
										if ($td_color || $td_bg_color || $td_border_style || $td_border_width || $td_border_color) :
											$td_custom_style                    = 'style="';
											$td_color ? $td_custom_style        .= 'color: ' . esc_attr( $td_color ) . ';' : '';
											$td_bg_color ? $td_custom_style     .= 'background-color: ' . esc_attr( $td_bg_color ) . ';' : '';
											$td_border_style ? $td_custom_style .= 'border-style: ' . esc_attr( $td_border_style ) . ';' : '';
											$td_border_width ? $td_custom_style .= 'border-width: ' . $top . $right . $bottom . $left . ';' : '';
											$td_border_color ? $td_custom_style .= 'border-color: ' . esc_attr( $td_border_color ) . ';' : '';
											$td_custom_style                    .= '"';
										endif;
										$td_alignment ? $td_custom_alignment = 'style="justify-content: ' . esc_attr( $td_alignment ) . ';"' : '';
									endif;
									?>

									<td <?php echo $this->get_render_attribute_string( 'table_inside_td' . $i . $j) . ' ' . $td_custom_style; ?>>
										<div class="exad-td-content" <?php echo $td_custom_alignment; ?>>
										<?php
											if ( 'text' === $table_td[$j]['body_col_content_type'] && ! empty( $table_td[$j]['text'] ) ):
												echo wp_kses_post( $table_td[$j]['text'] );
												if ( 'yes' === $table_td[$j]['tooltip-enable'] ) : ?>
													<div class="exad-td-tooltip">
														<i class="eicon-info-circle"></i>
														<span class="exad-tooltip-text"><?php echo esc_html( $table_td[$j]['tooltip-text'] ); ?></span>
													</div>
												<?php 	
												endif;
											endif;

											if ( 'yes' === $table_td[$j]['body_col_content_type'] ) : ?>
												<i class="eicon-check exad-table-content-icon"></i>
											<?php endif; ?>

											<?php if ( 'no' === $table_td[$j]['body_col_content_type'] ) : ?> 
												<i class="eicon-close exad-table-content-icon"></i>
											<?php endif; ?>
											<?php 	
											if ( 'button' === $table_td[$j]['body_col_content_type'] && ! empty( $table_td[$j]['button_text'] ) ) : ?>
												<a <?php echo $table_td[$j]['link_url'] . ' ' . $table_td[$j]['link_target'] . $table_td[$j]['nofollow']; ?> class="exad-table-content-button"><?php echo esc_html( $table_td[$j]['button_text'] ); ?></a>
											<?php endif; ?>
										</div>
									</td>
								<?php 	
								endif;
							endfor; ?>
						</tr>
					<?php endfor; ?>
				</tbody>
			</table>
		</div>
	<?php 	
	}
}