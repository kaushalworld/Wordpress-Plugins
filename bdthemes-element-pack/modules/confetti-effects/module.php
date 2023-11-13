<?php

namespace ElementPack\Modules\ConfettiEffects;

use Elementor\Controls_Manager;
use ElementPack\Base\Element_Pack_Module_Base;

if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly

class Module extends Element_Pack_Module_Base {

    public function __construct() {
        parent::__construct();
        $this->add_actions();
    }

    public function get_name() {
        return 'bdt-confetti-effects';
    }

    public function register_section($element) {
        $element->start_controls_section(
            'section_element_pack_confetti_controls',
            [
                'tab'   => Controls_Manager::TAB_ADVANCED,
                'label' => BDTEP_CP . esc_html__('Confetti Effects', 'bdthemes-element-pack') . BDTEP_NC,
            ]
        );
        $element->end_controls_section();
    }


    public function register_controls($widget, $args) {

        $widget->add_control(
            'ep_widget_cf_confetti',
            [
                'label'              => esc_html__('Use Confetti Effects?', 'bdthemes-element-pack'),
                'type'               => Controls_Manager::SWITCHER,
                'render_type'        => 'template',
                'default'            => '',
                'return_value'       => 'yes',
                'frontend_available' => true,
            ]
        );

        $widget->add_control(
            'ep_widget_cf_type',
            [
                'label'   => esc_html__('Confetti Type', 'bdthemes-element-pack'),
                'type'    => Controls_Manager::SELECT,
                'options' => [
                    'basic'        => esc_html__('Basic', 'bdthemes-element-pack'),
                    'random'       => esc_html__('Random Direction', 'bdthemes-element-pack'),
                    'fireworks'    => esc_html__('Fireworks', 'bdthemes-element-pack'),
                    'snow'         => esc_html__('Snow', 'bdthemes-element-pack'),
                    'school-pride' => esc_html__('School Pride', 'bdthemes-element-pack'),
                ],
                'default'            => 'basic',
                'render_type'        => 'template',
                'frontend_available' => true,
                'condition'          => [
                    'ep_widget_cf_confetti' => 'yes'
                ],
            ]
        );

        $widget->add_control(
            'ep_widget_cf_fireworks_duration',
            [
                'label' => esc_html__('Animation End Time (ms)', 'bdthemes-element-pack'),
                'type'  => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 1000,
                        'max' => 10000,
                    ],
                ],
                'frontend_available' => true,
                'condition'          => [
                    'ep_widget_cf_confetti' => 'yes',
                    'ep_widget_cf_type'     => ['fireworks', 'snow', 'school-pride'],
                ],
            ]
        );

        $widget->add_control(
            'ep_widget_cf_anim_infinite',
            [
                'label'              => esc_html__('Infinite End Time', 'bdthemes-element-pack') . BDTEP_NC,
                'description'        => esc_html__('The result will be shown in Preview.', 'bdthemes-element-pack'),
                'type'               => Controls_Manager::SWITCHER,
                'return_value'       => 'yes',
                'frontend_available' => true,
                'condition'          => [
                    'ep_widget_cf_confetti' => 'yes',
                    'ep_widget_cf_type'     => ['snow'],
                ],
            ]
        );

        $widget->add_control(
            'ep_widget_cf_particle_count',
            [
                'label'       => esc_html__('Particle Count', 'bdthemes-element-pack'),
                'description' => esc_html__('The number of confetti to launch. More is always fun... but be cool, there\'s a lot of math involved. (default: 50)', 'bdthemes-element-pack'),
                'type'        => Controls_Manager::SLIDER,
                'range'       => [
                    'px' => [
                        'min' => 1,
                        'max' => 1000,
                    ],
                ],
                'render_type'        => 'none',
                'frontend_available' => true,
                'condition'          => [
                    'ep_widget_cf_confetti' => 'yes'
                ],
            ]
        );

        $widget->add_control(
            'ep_widget_cf_start_velocity',
            [
                'label'       => esc_html__('Start Velocity', 'bdthemes-element-pack'),
                'description' => esc_html__('How fast the confetti will start going, in pixels. (default: 45)', 'bdthemes-element-pack'),
                'type'        => Controls_Manager::SLIDER,
                'range'       => [
                    'px' => [
                        'min' => 10,
                        'max' => 100,
                    ],
                ],
                'render_type'        => 'none',
                'frontend_available' => true,
                'condition'          => [
                    'ep_widget_cf_confetti' => 'yes'
                ],
            ]
        );

        $widget->add_control(
            'ep_widget_cf_spread',
            [
                'label'       => esc_html__('Spread', 'bdthemes-element-pack'),
                'description' => esc_html__('How far off center the confetti can go, in degrees. 45 means the confetti will launch at the defined angle plus or minus 22.5 degrees.', 'bdthemes-element-pack'),
                'type'        => Controls_Manager::SLIDER,
                'range'       => [
                    'px' => [
                        'min' => 0,
                        'max' => 360,
                    ],
                ],
                'render_type'        => 'none',
                'frontend_available' => true,
                'condition'          => [
                    'ep_widget_cf_confetti' => 'yes'
                ],
            ]
        );

        $widget->add_control(
            'ep_widget_cf_angle',
            [
                'label'       => esc_html__('Angle', 'bdthemes-element-pack'),
                'description' => esc_html__('The angle in which to launch the confetti, in degrees. 90 is straight up', 'bdthemes-element-pack'),
                'type'        => Controls_Manager::SLIDER,
                'range'       => [
                    'px' => [
                        'min' => 0,
                        'max' => 360,
                    ],
                ],
                'render_type'        => 'none',
                'frontend_available' => true,
                'condition'          => [
                    'ep_widget_cf_confetti' => 'yes',
                    'ep_widget_cf_type'     => ['random', 'school-pride'],
                ],
            ]
        );

        $widget->add_control(
            'ep_widget_cf_colors',
            [
                'label'              => esc_html__('Colors', 'bdthemes-element-pack'),
                'type'               => Controls_Manager::TEXTAREA,
                'description'        => 'Input your colors. example: red, #bada55, #ffffff (Colors must be not empty.)',
                'default'            => '#D30C5C, #0EBCDC, #EAED41, #ED5A78, #DF33DF',
                'render_type'        => 'none',
                'frontend_available' => true,
                'condition'          => [
                    'ep_widget_cf_confetti' => 'yes'
                ],
            ]
        );

        $widget->add_control(
            'ep_widget_cf_shapes',
            [
                'label'              => esc_html__('Shapes', 'bdthemes-element-pack'),
                'type'               => Controls_Manager::TEXTAREA,
                'description'        => 'The possible values are square and circle. The default is to use both shapes in an even mix. You can even change the mix by providing a value such as (circle, circle, square) to use two third circles and one third squares.',
                'render_type'        => 'none',
                'frontend_available' => true,
                'condition'          => [
                    'ep_widget_cf_confetti' => 'yes'
                ],
            ]
        );

        $widget->add_control(
            'ep_widget_cf_origin',
            [
                'label'     => esc_html__('Origin', 'bdthemes-element-pack'),
                'type'      => Controls_Manager::POPOVER_TOGGLE,
                'condition' => [
                    'ep_widget_cf_confetti' => 'yes',
                ],
                'return_value' => 'yes',
                //'render_type'        => 'none',
                'frontend_available' => true,
            ]
        );

        $widget->start_popover();

        $widget->add_control(
            'ep_widget_cf_origin_x',
            [
                'label' => esc_html__('X', 'bdthemes-element-pack'),
                'type'  => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min'  => 0,
                        'max'  => 1,
                        'step' => .1
                    ],
                ],
                'frontend_available' => true,
                'condition'          => [
                    'ep_widget_cf_confetti' => 'yes',
                    'ep_widget_cf_origin'   => 'yes',
                ],
            ]
        );

        $widget->add_control(
            'ep_widget_cf_origin_y',
            [
                'label' => esc_html__('Y', 'bdthemes-element-pack'),
                'type'  => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min'  => 0,
                        'max'  => 1,
                        'step' => .1
                    ],
                ],
                'frontend_available' => true,
                'condition'          => [
                    'ep_widget_cf_confetti' => 'yes',
                    'ep_widget_cf_origin'   => 'yes',
                ],
            ]
        );

        $widget->end_popover();

        $widget->add_control(
            'ep_widget_cf_trigger_type',
            [
                'label'   => esc_html__('Trigger Action', 'bdthemes-element-pack'),
                'type'    => Controls_Manager::SELECT,
                'options' => [
                    'load'         => esc_html__('On Load', 'bdthemes-element-pack'),
                    'onview'       => esc_html__('On View', 'bdthemes-element-pack'),
                    'click'        => esc_html__('On Click', 'bdthemes-element-pack'),
                    'mouseenter'   => esc_html__('On Hover', 'bdthemes-element-pack'),
                    'delay'        => esc_html__('Delay', 'bdthemes-element-pack'),
                    'ajax-success' => esc_html__('Ajax Success', 'bdthemes-element-pack'),
                ],
                'default'            => 'load',
                'render_type'        => 'template',
                'frontend_available' => true,
                'condition'          => [
                    'ep_widget_cf_confetti' => 'yes',
                ],
            ]
        );

        $widget->add_control(
            'ep_widget_cf_trigger_selector',
            [
                'label'       => esc_html__('Trigger Selector', 'bdthemes-element-pack'),
                'type'        => Controls_Manager::TEXT,
                'description' => esc_html__('Place your selector. example:- #test-id, .test-class', 'bdthemes-element-pack'),
                'dynamic'     => [
                    'active' => true,
                ],
                'render_type'        => 'template',
                'frontend_available' => true,
                'condition'          => [
                    'ep_widget_cf_confetti'     => 'yes',
                    'ep_widget_cf_trigger_type' => ['click', 'mouseenter'],
                ],
            ]
        );

        $widget->add_control(
            'ep_widget_cf_trigger_delay',
            [
                'label'   => esc_html__('Delay Time (ms)', 'bdthemes-element-pack'),
                'type'    => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 3000,
                ],
                'range'              => [
                    'px' => [
                        'min' => 1000,
                        'max' => 10000,
                    ],
                ],
                'frontend_available' => true,
                'condition'          => [
                    'ep_widget_cf_confetti'     => 'yes',
                    'ep_widget_cf_trigger_type' => 'delay',
                ],
            ]
        );

        $widget->add_control(
            'ep_widget_cf_z_index',
            [
                'label'              => esc_html__('Z-index', 'bdthemes-element-pack') . BDTEP_NC,
                'type'               => Controls_Manager::NUMBER,
                'render_type'        => 'template',
                'frontend_available' => true,
                'condition'          => [
                    'ep_widget_cf_confetti' => 'yes'
                ],
            ]
        );
    }

    public function enqueue_scripts() {
        wp_enqueue_script('confetti', BDTEP_ASSETS_URL . 'vendor/js/confetti.browser.min.js', [], 'v5.10.0', true);
    }
    public function should_script_enqueue($widget) {
        if ('yes' === $widget->get_settings_for_display('ep_widget_cf_confetti')) {
            $this->enqueue_scripts();
            wp_enqueue_script('ep-confetti-effects');
        }
    }

    protected function add_actions() {

        add_action('elementor/element/common/_section_style/after_section_end', [$this, 'register_section']);
        add_action('elementor/element/common/section_element_pack_confetti_controls/before_section_end', [$this, 'register_controls'], 10, 2);

        // Add section for settings
        add_action('elementor/element/section/section_advanced/after_section_end', [$this, 'register_section']);
        add_action('elementor/element/section/section_element_pack_confetti_controls/before_section_end', [$this, 'register_controls'], 10, 2);

        add_action('elementor/element/container/section_layout/after_section_end', [$this, 'register_section']);
        add_action('elementor/element/container/section_element_pack_confetti_controls/before_section_end', [$this, 'register_controls'], 10, 2);
        add_action('elementor/frontend/container/before_render', [$this, 'should_script_enqueue'], 10, 1);


        // render scripts
        add_action('elementor/frontend/section/before_render', [$this, 'should_script_enqueue'], 10, 1);
        add_action('elementor/frontend/widget/before_render', [$this, 'should_script_enqueue'], 10, 1);
        add_action('elementor/preview/enqueue_scripts', [$this, 'enqueue_scripts']);
    }
}
