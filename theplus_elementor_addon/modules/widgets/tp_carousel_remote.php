<?php 
/*
Widget Name: Carousel Remote
Description: Carousel/Switcher remote button.
Author: Theplus
Author URI: https://posimyth.com
*/
namespace TheplusAddons\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Utils;
use Elementor\Core\Schemes\Color;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Core\Schemes\Typography;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Image_Size;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly


class ThePlus_Carousel_Remote extends Widget_Base {

	public $TpDoc = THEPLUS_TPDOC;
		
	public function get_name() {
		return 'tp-carousel-remote';
	}

    public function get_title() {
        return esc_html__('Carousel Remote', 'theplus');
    }

    public function get_icon() {
        return 'fa fa-bluetooth-b theplus_backend_icon';
    }

	public function get_custom_help_url() {
		$DocUrl = $this->TpDoc . "carousel-remote";

		return esc_url($DocUrl);
	}

    public function get_categories() {
        return array('plus-creatives');
    }

    protected function register_controls() {
		
		$this->start_controls_section(
			'content_section',
			[
				'label' => esc_html__( 'Content', 'theplus' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);
		$this->add_control(
			'carousel_unique_id',
			[
				'label' => wp_kses_post( "Unique Connection ID <a class='tp-docs-link' href='" . esc_url($this->TpDoc) . "carousel-remote-elementor-widget-settings-overview/' target='_blank' rel='noopener noreferrer'> <i class='eicon-help-o'></i> </a>", 'theplus' ),
				'type' => Controls_Manager::TEXT,
				'default' => '',
				'description' => esc_html__('Enter the value of ID of carousel/Switcher, which you want to remotely connect with this.','theplus'),
			]
		);
		$this->add_control(
			'remote_type',
			[
				'label' => esc_html__( 'Remote Type', 'theplus' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'carousel',
				'options' => [
					'carousel'  => esc_html__( 'Carousel', 'theplus' ),
					'switcher' => esc_html__( 'Switcher', 'theplus' ),					
				],
				'separator' => 'before',
			]
		);
		$this->end_controls_section();
		$this->start_controls_section(
			'Nxt_Pre_section',
			[
				'label' => esc_html__( 'Prev/Next', 'theplus' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);
		$this->add_control(
			'nxtprvbtn',[
				'label' => esc_html__( 'Next/Prev', 'theplus' ),
				'type'    =>  Controls_Manager::SWITCHER,
				'default' => 'yes',
				'label_on' => esc_html__( 'Show', 'theplus' ),
				'label_off' => esc_html__( 'Hide', 'theplus' ),	
			]
		);
		$this->add_control(
			'nav_next_slide',
			[
				'label' => esc_html__( 'Button 1 Text', 'theplus' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'Next', 'theplus' ),
				'dynamic' => [
					'active'   => true,
				],
				'condition' => [
					'nxtprvbtn' => 'yes',
				],
			]
		);
		$this->add_control(
			'nav_prev_slide',
			[
				'label' => esc_html__( 'Button 2 Text', 'theplus' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'Prev', 'theplus' ),
				'dynamic' => [
					'active'   => true,
				],
				'condition' => [
					'nxtprvbtn' => 'yes',
				],
			]
		);
		$this->add_responsive_control(
			'content_align',
			[
				'label' => esc_html__( 'Alignment', 'theplus' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => esc_html__( 'Left', 'theplus' ),
						'icon' => 'eicon-text-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'theplus' ),
						'icon' => 'eicon-text-align-center',
					],
					'right' => [
						'title' => esc_html__( 'Right', 'theplus' ),
						'icon' => 'eicon-text-align-right',
					],
				],
				'condition' => [
					'nxtprvbtn' => 'yes',
				],
				'default' => 'left',
				'prefix_class' => 'text-%s',
			]
		);
		$this->add_control(
			'nav_icon_style',
			[
				'label'   => esc_html__( 'Icon Style', 'theplus' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'style-1',
				'options' => [
					'none'  => esc_html__( 'None', 'theplus' ),
					'style-1'  => esc_html__( 'Style 1', 'theplus' ),
					'custom' => esc_html__( 'Custom', 'theplus' ),
				],
				'condition' => [
					'nxtprvbtn' => 'yes',
				],
			]
		);
		$this->add_control(
			'nav_prev_icon',
			[
				'label' => esc_html__( 'Custom Icon 1', 'theplus' ),
				'type' => Controls_Manager::MEDIA,
				'default' => [
					'url' => '',
				],
				'dynamic' => [
					'active'   => true,
				],
				'condition' => [
					'nxtprvbtn' => 'yes',
					'nav_icon_style' => 'custom',
				],
			]
		);
		$this->add_control(
			'nav_next_icon',
			[
				'label' => esc_html__( 'Custom Icon 2', 'theplus' ),
				'type' => Controls_Manager::MEDIA,
				'default' => [
					'url' => '',
				],
				'dynamic' => [
					'active'   => true,
				],
				'condition' => [
					'nxtprvbtn' => 'yes',
					'nav_icon_style' => 'custom',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name' => 'nav_icon_thumbnail',
				'default' => 'full',
				'separator' => 'none',
				'separator' => 'before',
				'condition' => [
					'nxtprvbtn' => 'yes',
					'nav_icon_style' => 'custom',
				],
			]
		);
		$this->end_controls_section();
		/*Dots Start*/
		$this->start_controls_section(
            'section_dot',
            [
                'label' => esc_html__('Dots', 'theplus'),
                'tab' => Controls_Manager::TAB_CONTENT,
				'condition' => [
					'remote_type' => 'carousel',
				],
            ]
        );
		$this->add_control(
			'dotList',
			[
				'label' => esc_html__( 'Dots', 'theplus' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Enable', 'theplus' ),
				'label_off' => esc_html__( 'Disable', 'theplus' ),
				'default' => 'no',
			]
		);
		$repeater = new \Elementor\Repeater();
		$repeater->add_control(
			'label',
			[
				'label' => esc_html__( 'Label', 'theplus' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'Label', 'theplus' ),
				'dynamic' => ['active'   => true,],
			]
		);
		$repeater->add_control(
			'iconFonts',
			[
				'label' => esc_html__( 'Select Icon', 'theplus' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'font_awesome',
				'options' => [
					'none'  => esc_html__( 'None', 'theplus' ),
					'font_awesome' => esc_html__( 'Font Awesome', 'theplus' ),
					'image' => esc_html__( 'Image', 'theplus' ),
				],				
			]
		);
		$repeater->add_control(
			'iconName',
			[
				'label' => esc_html__( 'Icon Library', 'theplus' ),
				'type' => Controls_Manager::ICONS,
				'default' => [
					'value' => 'fas fa-plus',
					'library' => 'solid',
				],
				'condition' => [
					'iconFonts' => 'font_awesome',
				],
			]
		);
		$repeater->add_control(
			'iconImage',
			[
				'label' => esc_html__( 'Use Image As icon', 'theplus' ),
				'type' => Controls_Manager::MEDIA,
				'default' => [
					'url' => '',
				],
				'media_type' => 'image',
				'dynamic' => ['active'   => true,],
				'condition' => [
					'iconFonts' => 'image',
				],
			]
		);
		$repeater->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name' => 'iconimageSize',
				'default' => 'full',
				'separator' => 'none',
				'separator' => 'after',
				'condition' => [
					'iconFonts' => 'image',
				],
			]
		);
		$repeater->start_controls_tabs( 'tabs_dot' );
		$repeater->start_controls_tab(
			'tab_dot_normal',
			[
				'label' => esc_html__( 'Normal', 'theplus' ),
				'condition' => [
					'iconFonts!' => 'none',
				],
			]
		);
		$repeater->add_control(
			'doticonColor',
			[
				'label' => esc_html__( 'Color', 'theplus' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'render_type' => 'ui',
				'selectors' => [
					'{{WRAPPER}} .theplus-carousel-remote .tp-carodots-item{{CURRENT_ITEM}}' => 'color: {{VALUE}}',
				],
				'condition' => [
					'iconFonts!' => 'none',
				],
			]
		);
		$repeater->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'dotBgtype',
				'label' => esc_html__( 'Background', 'theplus' ),
				'types' => [ 'classic', 'gradient'],
				'render_type' => 'ui',
				'selector' => '{{WRAPPER}} .theplus-carousel-remote .tp-carodots-item{{CURRENT_ITEM}}',
				'condition' => [
					'iconFonts!' => 'none',
				],
			]
		);
		$repeater->end_controls_tab();
		$repeater->start_controls_tab(
			'tab_dot_active',
			[
				'label' => esc_html__( 'Active', 'theplus' ),
				'condition' => [
					'iconFonts!' => 'none',
				],
			]
		);
		$repeater->add_control(
			'acticonColor',
			[
				'label' => esc_html__( 'Color', 'theplus' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'render_type' => 'ui',
				'selectors' => [
					'{{WRAPPER}} .theplus-carousel-remote .tp-carodots-item{{CURRENT_ITEM}}.active' => 'color: {{VALUE}}',
				],
				'condition' => [
					'iconFonts!' => 'none',
				],
			]
		);
		$repeater->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'actdotBgtype',
				'label' => esc_html__( 'Background', 'theplus' ),
				'types' => [ 'classic', 'gradient'],
				'render_type' => 'ui',
				'selector' => '{{WRAPPER}} .theplus-carousel-remote .tp-carodots-item{{CURRENT_ITEM}}.active',
				'condition' => [
					'iconFonts!' => 'none',
				],
			]
		);
		$repeater->end_controls_tab();
		$repeater->end_controls_tabs();
		$this->add_control(
			'dots_coll',
			[
				'label' => '',
				'type' => Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'label' => esc_html__( 'Dot 1', 'theplus' ),
						'iconName' => 'fas fa-plus',
					],
					[
						'label' => esc_html__( 'Dot 2', 'theplus' ),
						'iconName' => 'fas fa-plus',
					],
					[
						'label' => esc_html__( 'Dot 3', 'theplus' ),
						'iconName' => 'fas fa-plus',
					],
				],
				'title_field' => '{{{ label }}}',
				'condition' => [
					'dotList' => 'yes',
				],
			]
		);
		$this->add_control(
			'dotLayout',
			[
				'label' => esc_html__( 'Layout', 'theplus' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'horizontal',
				'options' => [
					'horizontal'  => esc_html__( 'Horizontal', 'theplus' ),
					'vertical'  => esc_html__( 'Vertical', 'theplus' ),
				],
				'condition' => [
					'dotList' => 'yes',
				],
			]
		);
		$this->add_control(
			'dotstyle',
			[
				'label' => esc_html__( 'Active Dot Style', 'theplus' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'style-1',
				'options' => [
					'style-1'  => esc_html__( 'Style 1', 'theplus' ),
					'style-2'  => esc_html__( 'Style 2', 'theplus' ),
				],
				'condition' => [
					'dotList' => 'yes',
				],
			]
		);
		$this->add_control(
			'AniDuration',
			[
				'label' => esc_html__( 'Duration (milliseconds)', 'theplus' ),
				'type' => Controls_Manager::NUMBER,
				'min' => 1,
				'max' => 10000,
				'step' => 100,
				'selectors' => [
					'{{WRAPPER}} .tp-carousel-dots .style-1.active .active-border .border' => 'animation-duration: {{VALUE}}ms',
				],
				'condition' => [
					'dotList' => 'yes',
					'dotstyle' => 'style-1',
				],
			]
		);
		$this->add_control(
			'AborderColor',
			[
				'label' => esc_html__( 'Border Color', 'theplus' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#000000',
				'condition' => [
					'dotList' => 'yes',
					'dotstyle' => 'style-1',
				],
			]
		);
		$this->add_control(
			'tooltipDir',
			[
				'label' => esc_html__( 'Tooltip Direction', 'theplus' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'top',
				'options' => [
					'top'  => esc_html__( 'Top', 'theplus' ),
					'bottom'  => esc_html__( 'Bottom', 'theplus' ),
				],
				'condition' => [
					'dotList' => 'yes',
					'dotLayout' => 'horizontal',
					'dotstyle' => 'style-2',
				],
			]
		);
		$this->add_control(
			'vtooltipDir',
			[
				'label' => esc_html__( 'Tooltip Direction', 'theplus' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'left',
				'options' => [
					'left'  => esc_html__( 'Left', 'theplus' ),
					'right'  => esc_html__( 'Right', 'theplus' ),
				],
				'condition' => [
					'dotList' => 'yes',
					'dotLayout' => 'vertical',
					'dotstyle' => 'style-2',
				],
			]
		);
		$this->end_controls_section();	
		/*Dots End*/
		/*Prev/Next style start*/
		$this->start_controls_section(
            'section_PrevNext_styling',
            [
                'label' => esc_html__('Prev/Next', 'theplus'),
                'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'nxtprvbtn' => 'yes',
				],
            ]
        );
        $this->add_control(
			'section_Icon_styling',
			[
				'label' => esc_html__( 'Icon', 'theplus' ),
				'type' => Controls_Manager::HEADING,
				'condition' => [
					'nxtprvbtn' => 'yes',
					'nav_icon_style!' => 'none',
				],
			]
		);
		$this->add_responsive_control(
            'icon_size',
            [
                'type' => Controls_Manager::SLIDER,
				'label' => esc_html__('Icon Size', 'theplus'),
				'size_units' => ['px'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 200,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 14,
				],
				'render_type' => 'ui',
				'selectors' => [
					'{{WRAPPER}} .theplus-carousel-remote .slider-nav-next-prev a.custom-nav-remote > span.nav-icon' => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .theplus-carousel-remote .slider-nav-next-prev a.custom-nav-remote > span.nav-icon img' => 'max-width: {{SIZE}}{{UNIT}};',
				],
            ]
        );
		$this->add_responsive_control(
            'icon_space',
            [
                'type' => Controls_Manager::SLIDER,
				'label' => esc_html__('Icon Space', 'theplus'),
				'size_units' => ['px'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 40,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 5,
				],
				'render_type' => 'ui',
				'selectors' => [
					'{{WRAPPER}} .theplus-carousel-remote .slider-nav-next-prev a.custom-nav-remote.nav-prev-slide > span.nav-icon' => 'margin-right: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .theplus-carousel-remote .slider-nav-next-prev a.custom-nav-remote.nav-next-slide > span.nav-icon' => 'margin-left: {{SIZE}}{{UNIT}};',					
				],
            ]
        );
		$this->start_controls_tabs( 'tabs_icon_style' );
		$this->start_controls_tab(
			'tab_icon_normal',
			[
				'label' => esc_html__( 'Normal', 'theplus' ),
			]
		);
		$this->add_control(
			'icon_color',
			[
				'label' => esc_html__( 'Color', 'theplus' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .theplus-carousel-remote .slider-nav-next-prev a.custom-nav-remote > span.nav-icon' => 'color: {{VALUE}};',
				],
			]
		);
		$this->end_controls_tab();
		$this->start_controls_tab(
			'tab_icon_hover',
			[
				'label' => esc_html__( 'Hover/Active', 'theplus' ),
			]
		);
		$this->add_control(
			'icon_hover_color',
			[
				'label' => esc_html__( 'Color', 'theplus' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .theplus-carousel-remote .slider-nav-next-prev .custom-nav-remote:hover > span.nav-icon,{{WRAPPER}} .theplus-carousel-remote.remote-switcher .slider-nav-next-prev .custom-nav-remote.active  > span.nav-icon' => 'color: {{VALUE}};',
				],
			]
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->add_control(
			'section_styling',
			[
				'label' => esc_html__( 'Button Style', 'theplus' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					'nxtprvbtn' => 'yes',
				],
			]
		);
		$this->add_responsive_control(
			'button_between_space',
			[
				'label' => esc_html__( 'Gap/Space', 'theplus' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 200,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 5,
				],
				'selectors' => [
					'{{WRAPPER}} .theplus-carousel-remote .slider-nav-next-prev a.custom-nav-remote.nav-prev-slide' => 'margin-right: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .theplus-carousel-remote .slider-nav-next-prev a.custom-nav-remote.nav-next-slide' => 'margin-left: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->add_responsive_control(
			'nav_inner_padding',
			[
				'label' => esc_html__( 'Padding', 'theplus' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em' ],
				'default' =>[
					'top' => '10',
					'right' => '20',
					'bottom' => '10',
					'left' => '20',
				],
				'selectors' => [
					'{{WRAPPER}} .theplus-carousel-remote .slider-nav-next-prev .custom-nav-remote' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'content_typography',
                'label' => esc_html__('Typography', 'theplus'),
				'scheme'   => Typography::TYPOGRAPHY_3,
                'selector' => '{{WRAPPER}} .theplus-carousel-remote .slider-nav-next-prev .custom-nav-remote',
            ]
        );
		$this->start_controls_tabs( 'tabs_nav_style' );
		$this->start_controls_tab(
			'tab_nav_normal',
			[
				'label' => esc_html__( 'Normal', 'theplus' ),
			]
		);
		$this->add_control(
			'nav_color',
			[
				'label' => esc_html__( 'Text Color', 'theplus' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .theplus-carousel-remote .slider-nav-next-prev .custom-nav-remote' => 'color: {{VALUE}};',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'      => 'box_background',
				'types'     => [ 'classic', 'gradient' ],
				'selector'  => '{{WRAPPER}} .theplus-carousel-remote .slider-nav-next-prev .custom-nav-remote',
				
			]
		);
		$this->end_controls_tab();
		$this->start_controls_tab(
			'tab_nav_hover',
			[
				'label' => esc_html__( 'Hover/Active', 'theplus' ),
			]
		);
		$this->add_control(
			'nav_hover_color',
			[
				'label' => esc_html__( 'Text Color', 'theplus' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .theplus-carousel-remote .slider-nav-next-prev .custom-nav-remote:hover,{{WRAPPER}} .theplus-carousel-remote.remote-switcher .slider-nav-next-prev .custom-nav-remote.active' => 'color: {{VALUE}};',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'      => 'box_hover_background',
				'types'     => [ 'classic', 'gradient' ],
				'selector'  => '{{WRAPPER}} .theplus-carousel-remote .slider-nav-next-prev .custom-nav-remote:hover,{{WRAPPER}} .theplus-carousel-remote.remote-switcher .slider-nav-next-prev .custom-nav-remote.active',
			]
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->add_control(
			'box_border',
			[
				'label' => esc_html__( 'Box Border', 'theplus' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'theplus' ),
				'label_off' => esc_html__( 'Hide', 'theplus' ),
				'default' => 'no',
			]
		);
		$this->add_control(
			'button_border_style',
			[
				'label'   => esc_html__( 'Border Style', 'theplus' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'solid',
				'options' => [
					'none'   => esc_html__( 'None', 'theplus' ),
					'solid'  => esc_html__( 'Solid', 'theplus' ),
					'dotted' => esc_html__( 'Dotted', 'theplus' ),
					'dashed' => esc_html__( 'Dashed', 'theplus' ),
					'groove' => esc_html__( 'Groove', 'theplus' ),
				],
				'selectors'  => [
					'{{WRAPPER}} .theplus-carousel-remote .slider-nav-next-prev .custom-nav-remote' => 'border-style: {{VALUE}};',
				],
				'condition' => [
					'box_border' => 'yes',
				],
			]
		);
		$this->start_controls_tabs( 'tabs_border_style' );
		$this->start_controls_tab(
			'tab_border_normal',
			[
				'label' => esc_html__( 'Normal', 'theplus' ),
			]
		);
		$this->add_control(
			'box_border_color',
			[
				'label' => esc_html__( 'Border Color', 'theplus' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#252525',
				'selectors'  => [
					'{{WRAPPER}} .theplus-carousel-remote .slider-nav-next-prev .custom-nav-remote' => 'border-color: {{VALUE}};',
				],
				'condition' => [
					'box_border' => 'yes',
				],
			]
		);
		$this->add_responsive_control(
			'box_border_width',
			[
				'label' => esc_html__( 'Border Width', 'theplus' ),
				'type'  => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'default' => [
					'top'    => 1,
					'right'  => 1,
					'bottom' => 1,
					'left'   => 1,
				],
				'selectors'  => [
					'{{WRAPPER}} .theplus-carousel-remote .slider-nav-next-prev .custom-nav-remote' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [
					'box_border' => 'yes',
				],
			]
		);
		$this->add_responsive_control(
			'border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'theplus' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .theplus-carousel-remote .slider-nav-next-prev .custom-nav-remote' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'box_shadow',
				'selector' => '{{WRAPPER}} .theplus-carousel-remote .slider-nav-next-prev .custom-nav-remote',
			]
		);
		$this->end_controls_tab();
		$this->start_controls_tab(
			'tab_border_hover',
			[
				'label' => esc_html__( 'Hover/Active', 'theplus' ),
			]
		);
		$this->add_control(
			'box_border_hover_color',
			[
				'label' => esc_html__( 'Border Color', 'theplus' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#252525',
				'selectors'  => [
					'{{WRAPPER}} .theplus-carousel-remote .slider-nav-next-prev .custom-nav-remote:hover,{{WRAPPER}} .theplus-carousel-remote.remote-switcher .slider-nav-next-prev .custom-nav-remote.active' => 'border-color: {{VALUE}};',
				],
				'condition' => [
					'box_border' => 'yes',
				],
			]
		);
		$this->add_responsive_control(
			'border_hover_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'theplus' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .theplus-carousel-remote .slider-nav-next-prev .custom-nav-remote:hover,{{WRAPPER}} .theplus-carousel-remote.remote-switcher .slider-nav-next-prev .custom-nav-remote.active' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'box_hover_shadow',
				'selector' => '{{WRAPPER}} .theplus-carousel-remote .slider-nav-next-prev .custom-nav-remote:hover,{{WRAPPER}} .theplus-carousel-remote.remote-switcher .slider-nav-next-prev .custom-nav-remote.active',
			]
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();	
		$this->end_controls_section();	
		/*Prev/Next style End*/	
		/*General style start*/
		$this->start_controls_section(
            'section_general_styling',
            [
                'label' => esc_html__('Dots', 'theplus'),
                'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'remote_type' => 'carousel',
				],
            ]
        );
        $this->add_control(
			'section_dots_styling',
			[
				'label' => esc_html__( 'Dots', 'theplus' ),
				'type' => Controls_Manager::HEADING,
				'condition' => [
					'dotList' => 'yes',
				],
			]
		);
		$this->add_responsive_control(
            'dotsSize',
            [
                'type' => Controls_Manager::SLIDER,
				'label' => esc_html__('Size', 'theplus'),
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 100,
						'step' => 1,
					],
				],
				'render_type' => 'ui',
				'selectors' => [
					'{{WRAPPER}} .tp-carousel-dots .tp-carodots-item' => 'width: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}}',
				],
            ]
        );
		$this->add_responsive_control(
            'dotsGap',
            [
                'type' => Controls_Manager::SLIDER,
				'label' => esc_html__('Gap', 'theplus'),
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 100,
						'step' => 1,
					],
				],
				'render_type' => 'ui',
				'selectors' => [
					'{{WRAPPER}} .tp-carousel-dots.dot-vertical .tp-carodots-item' => 'margin-bottom: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .tp-carousel-dots.dot-horizontal .tp-carodots-item' => 'margin-right: {{SIZE}}{{UNIT}};',
				],
            ]
        );
		$this->add_responsive_control(
            'dotsIconSize',
            [
                'type' => Controls_Manager::SLIDER,
				'label' => esc_html__('Icon Size', 'theplus'),
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 300,
						'step' => 1,
					],
				],
				'render_type' => 'ui',
				'selectors' => [
					'{{WRAPPER}} .tp-carodots-item .tp-dots i' => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .tp-carousel-dots .tp-carodots-item >div>svg:first-child' => 'width: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}};',
				],
            ]
        );
		$this->add_responsive_control(
            'dotsImageSize',
            [
                'type' => Controls_Manager::SLIDER,
				'label' => esc_html__('Image Size', 'theplus'),
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 300,
						'step' => 1,
					],
				],
				'render_type' => 'ui',
				'separator' => 'after',
				'selectors' => [
					'{{WRAPPER}} .tp-carodots-item .tp-dots img' => 'width: {{SIZE}}{{UNIT}};',
				],
            ]
        );
		$this->start_controls_tabs( 'tabs_dotsb_style' );
		$this->start_controls_tab(
			'tab_dotsb_normal',
			[
				'label' => esc_html__( 'Normal', 'theplus' ),
			]
		);
		$this->add_responsive_control(
            'dotsbr',
            [
                'type' => Controls_Manager::SLIDER,
				'label' => esc_html__('Border Radius', 'theplus'),
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 50,
						'step' => 1,
					],
				],
				'render_type' => 'ui',
				'selectors' => [
					'{{WRAPPER}} .tp-carousel-dots .tp-carodots-item' => 'border-radius: {{SIZE}}{{UNIT}};',
				],
            ]
        );
		$this->end_controls_tab();
		$this->start_controls_tab(
			'tab_dotsb_hover',
			[
				'label' => esc_html__( 'Active', 'theplus' ),
			]
		);
		$this->add_responsive_control(
            'dotsbra',
            [
                'type' => Controls_Manager::SLIDER,
				'label' => esc_html__('Border Radius', 'theplus'),
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 50,
						'step' => 1,
					],
				],
				'render_type' => 'ui',
				'selectors' => [
					'{{WRAPPER}} .tp-carousel-dots .tp-carodots-item.active' => 'border-radius: {{SIZE}}{{UNIT}};',
				],
            ]
        );
		$this->end_controls_tab();
		$this->end_controls_tabs();	
		$this->add_control(
			'section_tooltip_styling',
			[
				'label' => esc_html__( 'Tooltip Style', 'theplus' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					'dotList' => 'yes',
					'dotstyle' => 'style-2',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'tttypography',
				'selector' => '{{WRAPPER}} .tp-carodots-item .tooltip-txt',
				'condition' => [
					'dotList' => 'yes',
					'dotstyle' => 'style-2',
				],
			]
		);
		$this->add_control(
			'ttcolor',
			[
				'label' => esc_html__( 'Color', 'theplus' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .tp-carodots-item .tooltip-txt' => 'color: {{VALUE}};',
				],
				'condition' => [
					'dotList' => 'yes',
					'dotstyle' => 'style-2',
				],
			]
		);
		$this->add_control(
			'ttbgcolor',
			[
				'label' => esc_html__( 'Background Color', 'theplus' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .tp-carodots-item .tooltip-txt' => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .tp-carodots-item .tooltip-txt:after' => 'border-right-color: {{VALUE}};',
				],
				'condition' => [
					'dotList' => 'yes',
					'dotstyle' => 'style-2',
				],
			]
		);
		$this->add_responsive_control(
            'ttwidth',
            [
                'type' => Controls_Manager::SLIDER,
				'label' => esc_html__('Width', 'theplus'),
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 300,
						'step' => 1,
					],
				],
				'render_type' => 'ui',
				'selectors' => [
					'{{WRAPPER}} .tp-carodots-item .tooltip-txt' => 'width: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'dotList' => 'yes',
					'dotstyle' => 'style-2',
				],
            ]
        );
		$this->add_responsive_control(
            'ttoffset',
            [
                'type' => Controls_Manager::SLIDER,
				'label' => esc_html__('Offset', 'theplus'),
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => -250,
						'max' => 250,
						'step' => 1,
					],
				],
				'render_type' => 'ui',
				'selectors' => [
					'{{WRAPPER}} .tp-carousel-dots .style-2 .tooltip-top .tooltip-txt' => 'top: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'dotList' => 'yes',
					'dotstyle' => 'style-2',
				],
            ]
        );
		$this->end_controls_section();
		/*General Style end*/
		/*Pagination Start*/
		$this->start_controls_section(
            'section_pagination_style',
            [
                'label' => esc_html__('Paginate', 'theplus'),
                'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'remote_type' => 'carousel',
				],
            ]
        );
		$this->add_control(
			'showpagi',
			[
				'label' => esc_html__( 'Pagination', 'theplus' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Enable', 'theplus' ),
				'label_off' => esc_html__( 'Disable', 'theplus' ),
				'default' => '',
			]
		);
		$this->add_control(
			'sliderInd',
			[
				'label' => esc_html__( 'Total Slides', 'theplus' ),
				'type' => Controls_Manager::SELECT,
				'default' => '3',
				'options' => [
					'1'  => esc_html__( '1', 'theplus' ),
					'2'  => esc_html__( '2', 'theplus' ),
					'3'  => esc_html__( '3', 'theplus' ),
					'4'  => esc_html__( '4', 'theplus' ),
					'5'  => esc_html__( '5', 'theplus' ),
					'6'  => esc_html__( '6', 'theplus' ),
					'7'  => esc_html__( '7', 'theplus' ),
					'8'  => esc_html__( '8', 'theplus' ),
					'9'  => esc_html__( '9', 'theplus' ),
					'10'  => esc_html__( '10', 'theplus' ),
					'11'  => esc_html__( '11', 'theplus' ),
					'12'  => esc_html__( '12', 'theplus' ),
					'13'  => esc_html__( '13', 'theplus' ),
					'14'  => esc_html__( '14', 'theplus' ),
					'15'  => esc_html__( '15', 'theplus' ),
				],
				'condition' => [
					'showpagi' => 'yes',
				],
			]
		);
		$this->start_controls_tabs( 'tabs_pagination' );
		$this->start_controls_tab(
			'tab_pagination_total',
			[
				'label' => esc_html__( 'Total', 'theplus' ),
				'condition' => [
					'showpagi' => 'yes',
				],
			]
		);
		$this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'noTypo',
                'label' => esc_html__('Typography', 'theplus'),
				'scheme'   => Typography::TYPOGRAPHY_3,
                'selector' => '{{WRAPPER}} .theplus-carousel-remote .carousel-pagination li.pagination-list-in.total,
				{{WRAPPER}} .theplus-carousel-remote .carousel-pagination li.pagination-list-in.separator',
				'condition' => [
					'showpagi' => 'yes',
				],
            ]
        );
		$this->add_control(
			'noColor',
			[
				'label' => esc_html__( 'Color', 'theplus' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'render_type' => 'ui',
				'selectors' => [
					'{{WRAPPER}} .theplus-carousel-remote .carousel-pagination li.pagination-list-in.total,
				{{WRAPPER}} .theplus-carousel-remote .carousel-pagination li.pagination-list-in.separator' => 'color: {{VALUE}}',
				],
				'condition' => [
					'showpagi' => 'yes',
				],
			]
		);
		$this->end_controls_tab();
		$this->start_controls_tab(
			'tab_pagination_active',
			[
				'label' => esc_html__( 'Active', 'theplus' ),
				'condition' => [
					'showpagi' => 'yes',
				],
			]
		);
		$this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'ActnoTypo',
                'label' => esc_html__('Typography', 'theplus'),
				'scheme'   => Typography::TYPOGRAPHY_3,
                'selector' => '{{WRAPPER}} .theplus-carousel-remote .carousel-pagination li.pagination-list-in.active',
				'condition' => [
					'showpagi' => 'yes',
				],
            ]
        );
		$this->add_control(
			'ActnoColor',
			[
				'label' => esc_html__( 'Color', 'theplus' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'render_type' => 'ui',
				'selectors' => [
					'{{WRAPPER}} .theplus-carousel-remote .carousel-pagination li.pagination-list-in.active' => 'color: {{VALUE}}',
				],
				'condition' => [
					'showpagi' => 'yes',
				],
			]
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->add_control(
			'sepColor',
			[
				'label' => esc_html__( 'Seprator Color', 'theplus' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'render_type' => 'ui',
				'selectors' => [
					'{{WRAPPER}} .theplus-carousel-remote .carousel-pagination li.pagination-list-in.separator' => 'color: {{VALUE}}',
				],
				'condition' => [
					'showpagi' => 'yes',
				],
			]
		);
		$this->end_controls_section();	
		/*Pagination End*/
		/*Adv tab*/
		$this->start_controls_section(
            'section_plus_extra_adv',
            [
                'label' => esc_html__('Plus Extras', 'theplus'),
                'tab' => Controls_Manager::TAB_ADVANCED,
            ]
        );
		$this->end_controls_section();
		/*Adv tab*/
		
		/*--On Scroll View Animation ---*/
		include THEPLUS_PATH. 'modules/widgets/theplus-widget-animation.php';
		include THEPLUS_PATH. 'modules/widgets/theplus-needhelp.php';
	}
	
	 protected function render() {

        $settings = $this->get_settings_for_display();
		$remote_type = $settings["remote_type"];
		
			/*--On Scroll View Animation ---*/
				include THEPLUS_PATH. 'modules/widgets/theplus-widget-animation-attr.php';

			/*--Plus Extra ---*/
				$PlusExtra_Class = "";
				include THEPLUS_PATH. 'modules/widgets/theplus-widgets-extra.php';
			/*--Plus Extra ---*/

			$nav_next =$nav_prev = '';
			$carousel_unique_id=$settings["carousel_unique_id"];
			$nav_next_slide = $settings['nav_next_slide'];
			$nav_prev_slide = $settings['nav_prev_slide'];
			
			$nav_next_text=$nav_prev_text ='';
			if($nav_next_slide!=''){
				$nav_next_text ='<span>'.esc_html($nav_next_slide).'</span>';
			}
			if($nav_prev_slide!=''){
				$nav_prev_text ='<span>'.esc_html($nav_prev_slide).'</span>';
			}
			
			if($settings["nav_icon_style"]=='none'){
				$nav_prev = $nav_prev_text;
				$nav_next = $nav_next_text;
			}else if($settings["nav_icon_style"]=='style-1'){
				$nav_prev = '<span class="nav-icon"><i class="fa fa-angle-left" aria-hidden="true"></i></span>'.$nav_prev_text;
				$nav_next = $nav_next_text.'<span class="nav-icon"><i class="fa fa-angle-right" aria-hidden="true"></i></span>';
			}else if($settings["nav_icon_style"]=='custom'){
				$nav_prev_icon=$nav_next_icon='';
				if(!empty($settings["nav_prev_icon"]["url"])){
					$nav_prev_iconid=$settings["nav_prev_icon"]["id"];				
					$nav_prev_icon= tp_get_image_rander( $nav_prev_iconid,$settings['nav_icon_thumbnail_size']);
				}				
				
				if(!empty($settings["nav_next_icon"]["url"])){
					$nav_next_iconid=$settings["nav_next_icon"]["id"];				
					$nav_next_icon= tp_get_image_rander( $nav_next_iconid,$settings['nav_icon_thumbnail_size']);
				}
				
				$nav_prev = '<span class="nav-icon">'.$nav_prev_icon.'</span>'.$nav_prev_text;
				$nav_next = $nav_next_text.'<span class="nav-icon">'.$nav_next_icon.'</span>';
			}
			
			$active_class='';
			if($remote_type=='switcher'){
				$active_class="active";
			}
			
			$uid=uniqid("remote");
			$da=$daid='';
			if(!empty($settings['dotList']) && $settings['dotList']=='yes'){
				$da='data-connection="tpca_'.esc_attr($carousel_unique_id).'" data-tab-id="tptab_'.esc_attr($carousel_unique_id).'" data-extra-conn="tpex-'.esc_attr($carousel_unique_id).'"';
				$daid='id="tptab_'.esc_attr($carousel_unique_id).'"';
			}
			$carousel_remote ='<div '.$daid.' class="theplus-carousel-remote remote-'.esc_attr($remote_type).' '.$animated_class.' '.esc_attr($uid).'" data-id="'.esc_attr($uid).'" data-remote="'.esc_attr($remote_type).'"  '.$da.' '.$animation_attr.'>';
			
				if(empty($settings['nxtprvbtn']) && $settings['nxtprvbtn'] != 'yes'){
					$carousel_remote .='';
				}else{
					$carousel_remote .='<div class="slider-nav-next-prev">';
					$cnavll = function_exists('tp_has_lazyload') ? tp_bg_lazyLoad($settings['box_background_image'],$settings['box_hover_background_image']) : '';
					$carousel_remote .='<a href="#" class="custom-nav-remote '.$cnavll.' nav-prev-slide '.esc_attr($active_class).'" data-id="tpca_'.esc_attr($carousel_unique_id).'" data-nav="'.esc_attr("prev","theplus").'">'.$nav_prev.'</a>';
					$carousel_remote .='<a href="#" class="custom-nav-remote '.$cnavll.' nav-next-slide" data-id="tpca_'.esc_attr($carousel_unique_id).'" data-nav="'.esc_attr("next","theplus").'">'.$nav_next.'</a>';					
					$carousel_remote .='</div>';
				}
				
				if(!empty($settings['dotList']) && $settings['dotList']=='yes'){
					if(!empty($settings["dots_coll"])) {
						$index=0;	
						$carousel_remote .='<div class="tp-carousel-dots dot-'.$settings['dotLayout'].'">';
						foreach($settings["dots_coll"] as $index => $item) {
							$ps_count = $index;
							$ttpos='';
							if(!empty($settings['dotLayout']) && $settings['dotLayout']=='horizontal'){
								$ttpos = $settings['tooltipDir'];
							}else if(!empty($settings['dotLayout']) && $settings['dotLayout']=='vertical'){
								$ttpos = $settings['vtooltipDir'];
							}
								$ia ='inactive';
								if($index==0){
									$ia ='active';
								}
								$carodots_ll = function_exists('tp_has_lazyload') ? tp_bg_lazyLoad($item['dotBgtype_image'],$item['actdotBgtype_image']) : '';
								$carousel_remote .='<div class="tp-carodots-item elementor-repeater-item-'.esc_attr($item['_id']).' '.esc_attr($settings['dotstyle']).' '.esc_attr($ia).' '.$carodots_ll.'" data-tab="'.esc_attr($ps_count).'">';
									$carousel_remote .='<div class="tp-dots tooltip-'.esc_attr($ttpos).'">';
										$icons='';
										if($item['iconFonts'] && $item['iconFonts']=='font_awesome' && !empty($item['iconName'])){
											ob_start();
											\Elementor\Icons_Manager::render_icon( $item['iconName'], [ 'aria-hidden' => 'true' ]);
											$faicon = ob_get_contents();
											ob_end_clean();
											
											$icons = $faicon;											
										}else if($item['iconFonts'] && $item['iconFonts']=='image' && !empty($item['iconImage'])){
											$iconImage=$item['iconImage']['id'];
											$icons = tp_get_image_rander( $iconImage,$item['iconimageSize_size']);
										}											
										$carousel_remote .=$icons;
										
										if(!empty($item['label'])){
											$carousel_remote .='<span class="tooltip-txt">'.esc_html($item['label']).'</span>';
											$carousel_remote .='<svg height="32" data-v-d3e9c2e8="" width="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg" svg-inline="" role="presentation" focusable="false" tabindex="-1" class="active-border">
											 <path data-v-d3e9c2e8="" d="M14.7974701,0 C16.6202545,0 19.3544312,0 23,0 C26.8659932,0 30,3.13400675 30,7 L30,23 C30,26.8659932 26.8659932,30 23,30 L7,30 C3.13400675,30 0,26.8659932 0,23 L0,7 C0,3.13400675 3.13400675,0 7,0 L14.7602345,0" transform="translate(1.000000, 1.000000)" fill="none" stroke="'.esc_attr($settings["AborderColor"]).'" stroke-width="2" class="border"></path>
											</svg>';
										}
									$carousel_remote .='</div>';
								$carousel_remote .='</div>';							
						}			
						$carousel_remote .='</div>';
					}					
				}
				
				if(!empty($settings['showpagi']) && $settings['showpagi']=='yes'){
					$carousel_remote .='<div class="carousel-pagination">';
							$carousel_remote .='<ul class="pagination-list">';
								$carousel_remote .='<li class="pagination-list-in active"> 01 </li>';
								$carousel_remote .='<li class="pagination-list-in separator"> / </li>';
								$carousel_remote .='<li class="pagination-list-in total"> 0'.esc_html($settings['sliderInd']).' </li>';
							$carousel_remote .='</ul>';
					$carousel_remote .='</div>';
				}
				
			$carousel_remote .='</div>';
			
		echo $before_content.$carousel_remote.$after_content;
	}
	
    protected function content_template() {
	
    }
}