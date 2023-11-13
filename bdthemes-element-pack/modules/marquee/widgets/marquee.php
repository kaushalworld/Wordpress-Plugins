<?php

namespace ElementPack\Modules\Marquee\Widgets;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Repeater;
use Elementor\Group_Control_Image_Size;
use ElementPack\Base\Module_Base;

if (!defined('ABSPATH')) {
    exit;
}

// Exit if accessed directly

class Marquee extends Module_Base {

    public function get_name() {
        return 'bdt-marquee';
    }

    public function get_title() {
        return BDTEP . esc_html__('Marquee', 'bdthemes-element-pack');
    }

    public function get_icon() {
        return 'bdt-wi-marquee';
    }

    public function get_categories() {
        return ['element-pack'];
    }

    public function get_keywords() {
        return ['marquee', 'marquee text', 'marquee-list', 'news', 'ticker'];
    }

    public function get_style_depends() {

        if ($this->ep_is_edit_mode()) {
            return ['ep-styles'];
        } else {
            return ['ep-marquee'];
        }
    }

    public function get_script_depends() {

        if ($this->ep_is_edit_mode()) {
            return ['gsap', 'ep-scripts'];
        } else {
            return ['gsap', 'ep-marquee'];
        }
    }

    public function get_custom_help_url() {
        return 'https://youtu.be/x6vpXQt6__k';
    }

    protected function register_controls() {
        $this->register_controls_settings();
        $this->register_controls_layout_text();
        $this->register_controls_layout_images();
        $this->register_controls_style_text();
        $this->register_controls_style_images();
    }

    protected function register_controls_settings() {
        $this->start_controls_section(
            'section_controls_marquee',
            [
                'label' => __('Marquee', 'bdthemes-element-pack'),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );
        $this->add_control(
            'marquee_type',
            [
                'label'      => __('Marquee Type', 'bdthemes-element-pack'),
                'type'       => Controls_Manager::SELECT,
                'options'    => [
                    'text' => __('Text', 'bdthemes-element-pack'),
                    'image'  => __('Image', 'bdthemes-element-pack'),
                ],
                'default'    => 'text',
                'frontend_available' => true,
                'render_type'        => 'template',
            ]
        );
        $this->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
                'name'         => 'thumbnail',
                'label'        => esc_html__('Image Size', 'bdthemes-element-pack'),
                'exclude'      => ['custom'],
                'default'      => 'medium',
                'condition' => [
                    'marquee_type' => 'image'
                ]
            ]
        );
        $this->add_control(
            'marquee_speed',
            [
                'label'              => __('Scroll Time (s)', 'bdthemes-elemeet-pack'),
                'type'               => Controls_Manager::NUMBER,
                'min'                => 0,
                'max'                => 1000,
                'step'               => 1,
                'default'            => 20,
                'frontend_available' => true,
                'render_type'        => true,
            ]
        );
        $this->add_control(
            'marquee_direction',
            [
                'label'              => __('Direction', 'bdthemes-element-pack'),
                'type'               => Controls_Manager::CHOOSE,
                'options'            => [
                    'left'  => [
                        'title' => __('Left', 'bdthemes-element-pack'),
                        'icon'  => 'eicon-h-align-left',
                    ],
                    'right' => [
                        'title' => __('Right', 'bdthemes-element-pack'),
                        'icon'  => 'eicon-h-align-right',
                    ],
                ],
                'default'            => 'left',
                'frontend_available' => true,
                'render_type'        => 'none',
                'toggle'             => false,
            ]
        );
        $this->add_control(
            'marquee_pause_on_hover',
            [
                'label'         => __('Pause on Hover', 'bdthemes-element-pack'),
                'type'          => Controls_Manager::SWITCHER,
                'label_on'      => __('Yes', 'bdthemes-element-pack'),
                'label_off'     => __('No', 'bdthemes-element-pack'),
                'return_value'  => 'yes',
                'frontend_available' => true,
            ]
        );
        $this->end_controls_section();
    }
    protected function register_controls_layout_text() {
        $this->start_controls_section(
            'section_layout_text',
            [
                'label' => __('List Marquee', 'bdthemes-element-pack'),
                'condition' => [
                    'marquee_type' => 'text'
                ]
            ]
        );
        $repeater = new Repeater();
        $repeater->add_control(
            'marquee_content',
            [
                'label'       => __('Content', 'bdthemes-element-pack'),
                'label_block' => true,
                'type'        => Controls_Manager::TEXT,
            ]
        );
        $repeater->add_control(
            'marquee_color',
            [
                'label'     => __('Color', 'bdthemes-element-pack-pro'),
                'type'      => Controls_Manager::COLOR,
                'render_type' => 'template'
            ]
        );
        $this->add_control(
            'marquee_type_text',
            [
                'label'              => __('Maruqee Lists', 'bdthemes-element-pack'),
                'type'               => Controls_Manager::REPEATER,
                'fields'             => $repeater->get_controls(),
                'title_field'        => '{{{ marquee_content }}}',
                'frontend_available' => true,
                'render_type'        => 'none',
                'prevent_empty'      => false,
                'default' => [
                    [
                        'marquee_content' => esc_html__("Element Pack", 'bdthemes-element-pack')
                    ],
                    [
                        'marquee_content' => esc_html__("Prime Slider ", 'bdthemes-element-pack')
                    ],
                    [
                        'marquee_content' => esc_html__("Ultimate Post Kit", 'bdthemes-element-pack')
                    ],
                    [
                        'marquee_content' => esc_html__("Ultimate Store Kit", 'bdthemes-element-pack')
                    ],
                    [
                        'marquee_content' => esc_html__("Pixel Gallery", 'bdthemes-element-pack')
                    ],
                ]
            ]
        );

        $this->end_controls_section();
    }
    protected function register_controls_layout_images() {
        $this->start_controls_section(
            'section_layout_image',
            [
                'label' => __('Marquee Images', 'bdthemes-element-pack'),
                'condition' => [
                    'marquee_type' => 'image'
                ]
            ]
        );
        $repeater = new Repeater();
        $repeater->add_control(
            'marquee_image',
            [
                'label'     => __('Image', 'bdthemes-element-pack'),
                'type'      => Controls_Manager::MEDIA,
            ]
        );
        $this->add_control(
            'marquee_type_images',
            [
                'label'              => __('Maruqee Images', 'bdthemes-element-pack'),
                'type'               => Controls_Manager::REPEATER,
                'fields'             => $repeater->get_controls(),
                'prevent_empty'      => false,
                'default' => [
                    [
                        'marquee_image' => [
                            'url' => BDTEP_ASSETS_URL . 'images/gallery/item-1.svg'

                        ]
                    ],
                    [
                        'marquee_image' => [
                            'url' => BDTEP_ASSETS_URL . 'images/gallery/item-2.svg'
                        ]
                    ],
                    [
                        'marquee_image' => [
                            'url' => BDTEP_ASSETS_URL . 'images/gallery/item-3.svg'
                        ]
                    ],

                ]
            ]
        );
        $this->end_controls_section();
    }

    protected function register_controls_style_text() {
        $this->start_controls_section(
            'section_style_title',
            [
                'label' => __('Title', 'bdthemes-element-pack'),
                'tab'   => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'marquee_type' => 'text'
                ]
            ]
        );
        $this->add_control(
            'marquee_title_color',
            [
                'label'     => __('Color', 'bdthemes-element-pack'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .bdt-marquee .marquee-content' => 'color: {{VALUE}}',
                ],
                'condition' => [
                    'marquee_type' => 'text'
                ]
            ]
        );
        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'     => 'marquee_title_background',
                'label'    => __('Background', 'bdthemes-element-pack'),
                'types'    => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .bdt-marquee .marquee-content',
                'condition' => [
                    'marquee_type' => 'text'
                ]
            ]
        );
        $this->add_responsive_control(
            'marquee_title_padding',
            [
                'label'      => __('Padding', 'bdthemes-element-pack'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors'  => [
                    '{{WRAPPER}} .bdt-marquee .marquee-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition' => [
                    'marquee_type' => 'text'
                ]
            ]
        );
        $this->add_responsive_control(
            'marquee_title_margin',
            [
                'label'      => __('Margin', 'bdthemes-element-pack'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors'  => [
                    '{{WRAPPER}} .bdt-marquee .marquee-content' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition' => [
                    'marquee_type' => 'text'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'marquee_title_border',
                'label'    => __('Border', 'bdthemes-element-pack'),
                'selector' => '{{WRAPPER}} .bdt-marquee .marquee-content',
                'condition' => [
                    'marquee_type' => 'text'
                ]
            ]
        );
        $this->add_responsive_control(
            'marquee_title_radius',
            [
                'label'      => __('Border Radius', 'bdthemes-element-pack'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors'  => [
                    '{{WRAPPER}} .bdt-marquee .marquee-content' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition' => [
                    'marquee_type' => 'text'
                ]
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'marquee_title_typogrphy',
                'label'    => __('Typography', 'bdthmes-element-pack'),
                'selector' => '{{WRAPPER}} .bdt-marquee .marquee-content',
                'condition' => [
                    'marquee_type' => 'text'
                ]
            ]
        );

        $this->end_controls_section();
    }
    protected function register_controls_style_images() {
        $this->start_controls_section(
            'section_style_controls_image',
            [
                'label' => __('Images', 'bdthemes-element-pack'),
                'tab'   => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'marquee_type' => 'image'
                ]
            ]
        );
        $this->add_responsive_control(
            'marquee_image_width',
            [
                'label'         => __('Image Width', 'bdthemes-element-pack'),
                'description'   => __('Set image width in pixel. Default is 250px', 'bdthemes-element-pack'),
                'type'          => Controls_Manager::SLIDER,
                'size_units'    => ['px', 'vw', '%'],
                'range'         => [
                    'px'        => [
                        'min'   => 50,
                        'max'   => 450,
                        'step'  => 1,
                    ]
                ],
                'render_type'   => 'template',
                'selectors' => [
                    '{{WRAPPER}} .bdt-marquee.marquee-type-image .marquee-content-image img' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'marquee_image_height',
            [
                'label'         => __('Image Height', 'bdthemes-element-pack'),
                'description'   => __('Set image size in pixel. Default is 250px', 'bdthemes-element-pack'),
                'type'          => Controls_Manager::SLIDER,
                'size_units'    => ['px', 'vh', '%'],
                'range'         => [
                    'px'        => [
                        'min'   => 50,
                        'max'   => 450,
                        'step'  => 1,
                    ]
                ],
                // 'render_type'   => 'template',
                'selectors' => [
                    '{{WRAPPER}} .bdt-marquee.marquee-type-image .marquee-content-image img' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'marquee_image_padding',
            [
                'label'                 => __('Padding', 'bdthemes-element-pack'),
                'type'                  => Controls_Manager::DIMENSIONS,
                'size_units'            => ['px', '%', 'em'],
                'selectors'             => [
                    '{{WRAPPER}} .bdt-marquee .marquee-content-image img'    => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'marquee_image_margin',
            [
                'label'                 => __('Margin', 'bdthemes-element-pack'),
                'type'                  => Controls_Manager::DIMENSIONS,
                'size_units'            => ['px', '%', 'em'],
                'selectors'             => [
                    '{{WRAPPER}} .bdt-marquee .marquee-content-image img'    => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'      => 'marquee_image_background',
                'label'     => __('Background', 'bdthemes-element-pack'),
                'types'     => ['classic', 'gradient'],
                'selector'  => '{{WRAPPER}} .bdt-marquee .marquee-content-image img',
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'      => 'marquee_image_border',
                'label'     => __('Border', 'bdthemes-element-pack'),
                'selector'  => '{{WRAPPER}} .bdt-marquee .marquee-content-image img',
            ]
        );
        $this->add_responsive_control(
            'marquee_image_radius',
            [
                'label'                 => __('Border Radius', 'bdthemes-element-pack'),
                'type'                  => Controls_Manager::DIMENSIONS,
                'size_units'            => ['px', '%', 'em'],
                'selectors'             => [
                    '{{WRAPPER}} .bdt-marquee .marquee-content-image img'    => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->end_controls_section();
    }


    public function render_thumbnail($item) {
        $settings = $this->get_settings_for_display();
        $thumb_url = Group_Control_Image_Size::get_attachment_image_src($item['id'], 'thumbnail', $settings);
        echo '<div class="marquee-content-image">';
        if (!$thumb_url) {
            printf('<img src="%1$s">', $item['url']);
        } else {
            print(wp_get_attachment_image($item['id'], $settings['thumbnail_size']));
        }
        echo '</div>';
    }
    public function render() {
        $settings = $this->get_settings_for_display();
        $contentText    = $settings['marquee_type_text'];
        $contentImages    = $settings['marquee_type_images'];

        $this->add_render_attribute('bdt-marquee', [
            'id'    => 'bdt-marque-' . $this->get_id() . '',
            'class' => ['bdt-marquee', 'marquee-type-' . $settings['marquee_type'] . ''],
        ], null, true); ?>


        <div <?php $this->print_render_attribute_string('bdt-marquee'); ?>>
            <div class="marquee-rolling-wrapper">
                <div class="marquee-rolling">
                    <?php if ($settings['marquee_type'] === 'text') : ?>
                        <?php if ($contentText) :
                            foreach ($contentText as $key => $list) : ?>
                                <div class="marquee-content">
                                    <span class="marquee-title" style="color:<?php echo $list['marquee_color']; ?>"><?php echo $list['marquee_content']; ?></span>
                                </div>
                        <?php endforeach;
                        endif; ?>
                    <?php endif; ?>

                    <?php if ($settings['marquee_type'] === 'image') : ?>
                        <?php if ($contentImages) :
                            foreach ($contentImages as $key => $image) :
                                $this->render_thumbnail($image['marquee_image']);
                        ?>
                        <?php endforeach;
                        endif; ?>
                    <?php endif; ?>

                </div>
            </div>
        </div>

<?php
    }
}
