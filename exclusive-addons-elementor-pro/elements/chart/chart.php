<?php
namespace ExclusiveAddons\Elements;

if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.

use \Elementor\Controls_Manager;
use \Elementor\Widget_Base;
use \Elementor\REPEATER;


class Chart extends Widget_Base {

    public function get_name() {
        return 'exad-chart';
    }

    public function get_title() {
        return esc_html__( 'Chart', 'exclusive-addons-elementor-pro' );
    }

    public function get_icon() {
        return 'exad exad-logo exad-chart';
    }

    public function get_categories() {
        return [ 'exclusive-addons-elementor' ];
    }

    public function get_keywords() {
        return [ 'exclusive', 'chart', 'statistics', 'diagram', 'analysis' ];
    }

    public function get_script_depends() {
        return [ 'exad-chart' ];
    }

    protected function register_controls() {
        $exad_primary_color   = get_option( 'exad_primary_color_option', '#7a56ff' );

        $this->start_controls_section(
            'exad_chart_settings',
            [
                'label' => esc_html__( 'Settings', 'exclusive-addons-elementor-pro' )
            ]
        );

        $this->add_control(
            'exad_chart_type',
            [
                'label'             => esc_html__( 'Type', 'exclusive-addons-elementor-pro' ),
                'type'              => Controls_Manager::SELECT,
                'default'           => 'bar',
                'options'           => [
                    'bar'           => __( 'Vertical Bar (Vertical)', 'exclusive-addons-elementor-pro' ),
                    'horizontalBar' => __( 'Horozontal Bar (Horozontal)', 'exclusive-addons-elementor-pro' ),
                    'line'          => __( 'Line', 'exclusive-addons-elementor-pro' ),
                    'radar'         => __( 'Radar', 'exclusive-addons-elementor-pro' ),
                    'pie'           => __( 'Pie', 'exclusive-addons-elementor-pro' )
                ]
            ]
        );

        $this->add_control(
            'exad_chart_enable_grid_lines',
            [
                'label'   => __( 'Enable Grid Lines', 'exclusive-addons-elementor-pro' ),
                'type'    => Controls_Manager::SWITCHER,
                'default' => 'yes'
            ]
        );

        $this->add_control(
            'exad_chart_enable_labels',
            [
                'label'   => esc_html__( 'Enable Labels', 'exclusive-addons-elementor-pro' ),
                'type'    => Controls_Manager::SWITCHER,
                'default' => 'yes'
            ]
        );

        $this->add_control(
            'exad_chart_enable_legend',
            [
                'label'   => esc_html__( 'Enable Legends', 'exclusive-addons-elementor-pro' ),
                'type'    => Controls_Manager::SWITCHER,
                'default' => 'yes'
            ]
        );

        $this->add_control(
            'exad_chart_enable_tooltip',
            [
                'label'   => esc_html__( 'Enable Tooltip', 'exclusive-addons-elementor-pro' ),
                'type'    => Controls_Manager::SWITCHER,
                'default' => 'yes'
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'exad_chart_heading',
            [
                'label' => esc_html__( 'Labels', 'exclusive-addons-elementor-pro' )
            ]
        );

        $chart_label_repeater = new Repeater();

        $chart_label_repeater->add_control(
            'exad_chart_label_name', 
            [
                'label'       => esc_html__( 'Label Name', 'exclusive-addons-elementor-pro' ),
                'default'     => 2000,
                'type'        => Controls_Manager::TEXT,
                'label_block' => true
            ]
        );

        $this->add_control(
            'exad_chart_labels',
            [
                'type'    => Controls_Manager::REPEATER,
                'fields' 	=> $chart_label_repeater->get_controls(),
                'default' => [
                    [ 'exad_chart_label_name' => '2016' ],
                    [ 'exad_chart_label_name' => '2017' ],
                    [ 'exad_chart_label_name' => '2018' ],
                    [ 'exad_chart_label_name' => '2019' ],
                    [ 'exad_chart_label_name' => '2020' ]
                ],
                'title_field' => '{{exad_chart_label_name}}'
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'exad_datasets_content',
            [
                'label'     => __( 'Datasets', 'exclusive-addons-elementor-pro' ),
                'condition' => [
                    'exad_chart_type!' => [ 'pie' ]
                ]
            ]
        );

        $chart_repeater = new Repeater();

        $chart_repeater->add_control(
            'label', 
            [
                'label'       => __( 'Label', 'exclusive-addons-elementor-pro' ),
                'type'        => Controls_Manager::TEXT,
                'default'     => __( 'Dataset Label', 'exclusive-addons-elementor-pro' ),
                'label_block' => true
            ]
        );

        $chart_repeater->add_control(
            'data', 
            [
                'label'       => __( 'Data', 'exclusive-addons-elementor-pro' ),
                'label_block' => true,
                'type'        => Controls_Manager::TEXT,
                'default'     => __( '2; 4; 8; 16; 32', 'exclusive-addons-elementor-pro' ),
                'description' => __( 'Enter data values by semicolon separated(;). Example: 2; 4; 8; 16; 32 etc', 'exclusive-addons-elementor-pro' )
            ]
        );

        $chart_repeater->add_control(
            'advanced_bg_color', 
            [
                'label'       => __( 'Advanced Background Color', 'exclusive-addons-elementor-pro' ),
                'type'        => Controls_Manager::SWITCHER,
                'default'     => 'no'
            ]
        );

        $chart_repeater->add_control(
            'bg_color', 
            [
                'label'       => __( 'Background Color', 'exclusive-addons-elementor-pro' ),
                'label_block' => true,
                'default'     => 'rgba(122,86,255,0.5)',
                'type'        => Controls_Manager::COLOR,
                'condition'   => [
                    'advanced_bg_color!' => 'yes'
                ]
            ]
        );

        $chart_repeater->add_control(
            'exad_chart_individual_bg_colors', 
            [
                'type'        => Controls_Manager::TEXT,
                'label'       => __( 'Background Colors', 'exclusive-addons-elementor-pro' ),
                'label_block' => true,
                'description' => __( 'Write multiple color values by semicolon separated(;). Example: #000000; #ffffff; #cccccc; etc<br><strong>N.B: it will not work for line, radar charts</strong>', 'exclusive-addons-elementor-pro' ),
                'condition'   => [
                    'advanced_bg_color' => 'yes'
                ]
            ]
        );

        $chart_repeater->add_control(
            'advanced_border_color', 
            [
                'label'       => __( 'Advanced Border Color', 'exclusive-addons-elementor-pro' ),
                'separator'   => 'before',
                'type'        => Controls_Manager::SWITCHER,
                'default'     => 'no'
            ]
        );

        $chart_repeater->add_control(
            'border_color', 
            [
                'label'       => __( 'Border Color', 'exclusive-addons-elementor-pro' ),
                'label_block' => true,
                'type'        => Controls_Manager::COLOR,
                'condition'   => [
                    'advanced_border_color!' => 'yes'
                ]
            ]
        );

        $chart_repeater->add_control(
            'border_colors', 
            [
                'type'        => Controls_Manager::TEXT,
                'label'       => __( 'Border Colors', 'exclusive-addons-elementor-pro' ),
                'label_block' => true,
                'description' => __( 'Write multiple color values by semicolon separated(;). Example: #000000; #ffffff; #cccccc; etc<br><strong>N.B: it will not work for line, radar charts</strong>', 'exclusive-addons-elementor-pro' ),
                'condition'   => [
                    'advanced_border_color' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'exad_chart_datasets',
            [
                'type'    => Controls_Manager::REPEATER,
                'fields' 	=> $chart_repeater->get_controls(),
                'default' => [
                    [
                        'label'     => __( 'Dataset Label #1', 'exclusive-addons-elementor-pro' ),
                        'data'      => __( '2; 4; 6; 8; 10', 'exclusive-addons-elementor-pro' ),
                        'bg_color'  => 'rgba(122,86,255,0.5)',
                        'exad_chart_individual_bg_colors' => 'rgba(122,86,255,0.5); rgba(0,216,216,0.50); rgba(205,0,234,0.50); rgba(142,36,170,0.5); rgba(63,81,181,0.5)'
                    ],
                    [
                        'label'     => __( 'Dataset Label #2', 'exclusive-addons-elementor-pro' ),
                        'data'      => __( '4; 8; 12; 16; 20', 'exclusive-addons-elementor-pro' ),
                        'bg_color'  => 'rgba(0,216,216,0.50)',
                        'exad_chart_individual_bg_colors' => 'rgba(63,81,181,0.5); rgba(142,36,170,0.5); rgba(205,0,234,0.50); rgba(0,216,216,0.50); rgba(122,86,255,0.5)'
                    ],
                    [
                        'label'     => __( 'Dataset Label #3', 'exclusive-addons-elementor-pro' ),
                        'data'      => __( '23; 18; 13; 8; 3', 'exclusive-addons-elementor-pro' ),
                        'bg_color'  => 'rgba(142,36,170,0.5)',
                        'exad_chart_individual_bg_colors' => 'rgba(122,86,255,0.5); rgba(0,216,216,0.50); rgba(205,0,234,0.50); rgba(142,36,170,0.5); rgba(63,81,181,0.5)'
                    ],
                    [
                        'label'     => __( 'Dataset Label #4', 'exclusive-addons-elementor-pro' ),
                        'data'      => __( '10; 15; 20; 5; 10', 'exclusive-addons-elementor-pro' ),
                        'bg_color'  => 'rgba(205,0,234,0.50)',
                        'exad_chart_individual_bg_colors' => 'rgba(63,81,181,0.5); rgba(142,36,170,0.5); rgba(205,0,234,0.50); rgba(0,216,216,0.50); rgba(122,86,255,0.5)'
                    ],
                    [
                        'label'     => __( 'Dataset Label #5', 'exclusive-addons-elementor-pro' ),
                        'data'      => __( '5; 15; 25; 10; 20', 'exclusive-addons-elementor-pro' ),
                        'bg_color'  => 'rgba(63,81,181,0.5)',
                        'exad_chart_individual_bg_colors' => 'rgba(122,86,255,0.5); rgba(0,216,216,0.50); rgba(205,0,234,0.50); rgba(142,36,170,0.5); rgba(63,81,181,0.5)'
                    ]
                ],
                'title_field' => '{{{ label }}}'
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'exad_data_chart_for_and_pie',
            [
                'label'     => __( 'Datasets', 'exclusive-addons-elementor-pro' ),
                'condition' => [
                    'exad_chart_type' => ['pie']
                ]
            ]
        );

        $this->add_control(
            'single_label',
            [
                'label'       => __( 'Label', 'exclusive-addons-elementor-pro' ),
                'type'        => Controls_Manager::TEXT,
                'dynamic'     => [ 'active' => true ],
                'default'     => __( 'Polar Dataset Label', 'exclusive-addons-elementor-pro' ),
                'label_block' => true
            ]
        );

        $this->add_control(
            'single_datasets',
            [
                'label'       => __( 'Data', 'exclusive-addons-elementor-pro' ),
                'label_block' => true,
                'dynamic'     => [ 'active' => true ],
                'type'        => Controls_Manager::TEXT,
                'default'     => '5; 10; 15; 20; 30',
                'description' => __( 'Enter data values by semicolon separated(;). Example: 10; 20; 30; 40; 50 etc', 'exclusive-addons-elementor-pro' )
            ]
        );

        $this->add_control(
            'single_bg_colors',
            [
                'type'        => Controls_Manager::TEXT,
                'label'       => __( 'Background Colors', 'exclusive-addons-elementor-pro' ),
                'label_block' => true,
                'default'     => 'rgba(122,86,255,0.5); rgba(0,216,216,0.50); rgba(205,0,234,0.50); rgba(142,36,170,0.5); rgba(63,81,181,0.5)',
                'description' => __( 'Write multiple color values by semicolon separated(;). Example: #000000; #ffffff; #cccccc; etc<br><strong>N.B: it will not work for line, radar charts</strong>', 'exclusive-addons-elementor-pro' )
            ]
        );

        $this->add_control(
            'single_border_colors',
            [
                'type'        => Controls_Manager::TEXT,
                'label'       => __( 'Border Colors', 'exclusive-addons-elementor-pro' ),
                'label_block' => true,
                'description' => __( 'Write multiple color values by semicolon separated(;). Example: #000000; #ffffff; #cccccc; etc<br><strong>N.B: it will not work for line, radar charts</strong>', 'exclusive-addons-elementor-pro' )
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'exad_chart_style_section',
            [
                'label' => esc_html__( 'Style', 'exclusive-addons-elementor-pro' ),
                'tab'   => Controls_Manager::TAB_STYLE
            ]
        );


        $this->add_responsive_control(
            'exad_chart_legend_align',
            [
                'label'         => esc_html__( 'Alignment', 'exclusive-addons-elementor-pro' ),
                'type'          => Controls_Manager::CHOOSE,
                'options'       => [
                    'left'      => [
                        'title' => esc_html__( 'Left', 'exclusive-addons-elementor-pro' ),
                        'icon'  => 'eicon-arrow-left'
                    ],
                    'top'       => [
                        'title' => esc_html__( 'Top', 'exclusive-addons-elementor-pro' ),
                        'icon'  => 'eicon-arrow-up'
                    ],
                    'bottom'    => [
                        'title' => esc_html__( 'Bottom', 'exclusive-addons-elementor-pro' ),
                        'icon'  => 'eicon-arrow-down'
                    ],
                    'right'     => [
                        'title' => esc_html__( 'Right', 'exclusive-addons-elementor-pro' ),
                        'icon'  => 'eicon-arrow-right'
                    ],
                ],
                'condition'     => [
                    'exad_chart_enable_legend' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'exad_chart_border_width',
            [
                'label'    => esc_html__( 'Border Width', 'exclusive-addons-elementor-pro' ),
                'type'     => Controls_Manager::SLIDER,
                'default'  => [
                    'size' => 0
                ]
            ]
        );

        $this->add_control(
            'exad_chart_grid_color',
            [
                'label'     => esc_html__( 'Grid Color', 'exclusive-addons-elementor-pro' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => 'rgba(0,0,0,0.05)',
                'condition' => [
                    'exad_chart_enable_grid_lines' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'exad_chart_tooltip_background_color',
            [
                'label'     => esc_html__( 'Tooltip Background Color', 'exclusive-addons-elementor-pro' ),
                'type'      => Controls_Manager::COLOR,
                'condition' => [
                    'exad_chart_enable_tooltip' => 'yes'
                ]
            ]
        );

        $this->end_controls_section();
    }

    protected function render( ) { 
        $settings          = $this->get_settings_for_display();
        $labels            = array_column( $settings['exad_chart_labels'], 'exad_chart_label_name' );
        $exad_all_datasets = $exad_chart_datasets = $exad_chart_settings_options = [];

        if ( 'pie' === $settings['exad_chart_type'] ) :
            $single_data = array_map( 'intval', explode( ';', $settings['single_datasets'] ) );

            $exad_all_datasets[] = [ 'data' => $single_data, 'backgroundColor' => explode( ';', $settings['single_bg_colors'] ) ];

            if ( $settings['single_border_colors'] ) :
                $exad_all_datasets[] = [ 'data' => $single_data, 'borderColor' => explode( ';', $settings['single_border_colors'] ) ];
            endif;
            $exad_all_datasets[] = [ 'data' => $single_data, 'borderWidth' => $settings['exad_chart_border_width']['size'] ];

        else :
            foreach ( $settings['exad_chart_datasets'] as $dataset ) :

                $exad_chart_datasets['label'] = $dataset['label'];
                $exad_chart_datasets['data']  =  array_map( 'intval', explode(';', $dataset['data'] ) );                

                if ( 'yes' === $dataset['advanced_bg_color'] && '' !== $dataset['exad_chart_individual_bg_colors'] ) :
                    $exad_chart_datasets['backgroundColor'] = explode( '; ', $dataset['exad_chart_individual_bg_colors'] );
                else :
                    $exad_chart_datasets['backgroundColor'] = $dataset['bg_color'];
                endif;

                if ( 'yes' === $dataset['advanced_border_color'] && '' !== $dataset['border_colors'] ) :
                    $exad_chart_datasets['borderColor'] = explode( ';', $dataset['border_colors'] );
                else :
                    $exad_chart_datasets['borderColor'] = $dataset['border_color'];
                endif;

                $exad_chart_datasets['borderWidth'] = $settings['exad_chart_border_width']['size'];             
                $exad_all_datasets[] = $exad_chart_datasets;

            endforeach;
        endif;

        if ( $settings['exad_chart_enable_tooltip'] ) :
            if ( $settings['exad_chart_tooltip_background_color'] ) :
                $exad_chart_settings_options['tooltips']  = [ 
                    'backgroundColor' => $settings['exad_chart_tooltip_background_color'],
                ];
            endif;
        else :
            $exad_chart_settings_options['tooltips'] = [ 'enabled' => false ];
        endif;

        if ( $settings['exad_chart_enable_legend'] ) :
            if ( $settings['exad_chart_legend_align'] ) :
                $exad_chart_settings_options['legend'] = [ 'position' => $settings['exad_chart_legend_align'] ];
            endif;
        else :
            $exad_chart_settings_options['legend'] = [ 'display' => false ];
        endif;

        if ( 'pie' !== $settings['exad_chart_type'] ) :
            if ( $settings['exad_chart_enable_grid_lines'] ) :
                $exad_chart_settings_options['scales'] = [
                    'yAxes' => [
                        [
                            'ticks' => [
                                'display' => ( $settings['exad_chart_enable_labels'] ) ? true : false
                        ],
                            'gridLines' => [
                                'drawBorder' => false,
                                'color' => $settings['exad_chart_grid_color']
                            ]
                        ]
                    ],
                    'xAxes' => [
                        [
                            'ticks' => [
                                'display' => ( $settings['exad_chart_enable_labels'] ) ? true : false
                            ],
                            'gridLines' => [
                                'drawBorder' => false,
                                'color' => $settings['exad_chart_grid_color']
                            ]
                        ]
                    ]
                ];
            else :
                $exad_chart_settings_options['scales'] = [
                    'yAxes' => [
                        [
                            'ticks' => [
                                'display' => ( $settings['exad_chart_enable_labels'] ) ? true : false
                            ],
                            'gridLines' => [
                                'display' => false
                            ]
                        ]
                    ],
                    'xAxes' => [
                        [
                            'ticks' => [
                                'display' => ( $settings['exad_chart_enable_labels'] ) ? true : false
                            ],
                            'gridLines' => [
                                'display' => false
                            ]
                        ]
                    ]
                ];
            endif;
        endif;

        $this->add_render_attribute( 
            'exad_chart_wrapper', 
            [ 
                'class'                => 'exad-chart-wrapper',
                'data-settings'        => [
                    wp_json_encode( array_filter( [
                        'type'         => $settings['exad_chart_type'],
                        'data'         => [
                            'labels'   => $labels,
                            'datasets' => $exad_all_datasets
                        ],
                        'options'      => $exad_chart_settings_options
                    ] ) )                           
                ]
            ]
        );

        $this->add_render_attribute( 
            'exad_chart_canvas', 
            [ 
				'class' => 'exad-chart-widget',
				'id'    => 'exad-chart-' . $this->get_id()
            ]
        );
        ?>

        <div <?php echo $this->get_render_attribute_string( 'exad_chart_wrapper' ); ?>>
            <canvas <?php echo $this->get_render_attribute_string( 'exad_chart_canvas' ); ?>></canvas>
        </div>
        
    <?php
    }
}


