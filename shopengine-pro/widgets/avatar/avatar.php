<?php

namespace Elementor;

use ShopEngine\Widgets\Products;

defined('ABSPATH') || exit;

class ShopEngine_Avatar extends \ShopEngine\Base\Widget
{
    public function config()
    {
        return new ShopEngine_Avatar_Config();
    }

    protected function register_controls()
    {
        $this->start_controls_section(
            'shopengine_avatar_content_section',
            [
                'label' => __('Content', 'shopengine-pro'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'shopengine_avatar_upload_icon',
            [
                'label' => esc_html__('Upload Icon', 'shopengine-pro'),
                'type' => \Elementor\Controls_Manager::ICONS,
                'default' => [
                    'value' => 'fas fa-upload',
                    'library' => 'solid',
                ],
            ]
        );

        $this->add_control(
            'shopengine_avatar_save_btn_text',
            [
                'label' => esc_html__('Save Button Text', 'shopengine-pro'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Save', 'shopengine-pro'),
                'label_block' => true,
            ]
        );

        $this->add_control(
            'shopengine_avatar_is_overlay',
            [
                'label' => esc_html__('Show Image Overlay', 'shopengine-pro'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'shopengine-pro'),
                'label_off' => esc_html__('Hide', 'shopengine-pro'),
                'return_value' => 'yes',
                'default' => '',
                'prefix_class' => 'shopengine_avatar_is_overlay-',
                'selectors' => [
                    '{{WRAPPER}} .shopengine-widget .shopengine-avatar-container .shopengine-avatar .shopengine-avatar__thumbnail--btn' => 'visibility:hidden;opacity:0;transition:opacity 0.5s ease-in-out;',
                ],
            ]
        );

        $this->add_control(
            'shopengine_avatar_image_cancel_button_icon',
            [
                'label' => esc_html__('Close Icon', 'shopengine-pro'),
                'type' => \Elementor\Controls_Manager::ICONS,
                'default' => [
                    'value' => 'fas fa-times',
                    'library' => 'solid',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'shopengine_avatar_wrapper_style_section',
            [
                'label' => __('Wrapper', 'shopengine-pro'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'shopengine_avatar_content_alignmnet',
            [
                'label' => esc_html__('Alignment', 'shopengine-pro'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'flext-start' => [
                        'title' => esc_html__('Left', 'shopengine-pro'),
                        'icon' => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__('Center', 'shopengine-pro'),
                        'icon' => 'eicon-text-align-center',
                    ],
                    'flex-end' => [
                        'title' => esc_html__('Right', 'shopengine-pro'),
                        'icon' => 'eicon-text-align-right',
                    ],
                    'space-between' => [
                        'title' => esc_html__('Justify', 'shopengine-pro'),
                        'icon' => ' eicon-justify-space-between-h',
                    ],
                    'space-around' => [
                        'title' => esc_html__('Space Around', 'shopengine-pro'),
                        'icon' => 'eicon-justify-space-around-h',
                    ],
                    'space-evenly' => [
                        'title' => esc_html__('Space Evenly', 'shopengine-pro'),
                        'icon' => 'eicon-justify-space-evenly-h',
                    ],
                ],
                'default' => '',
                'toggle' => true,
                'selectors' => [
                    '{{WRAPPER}} .shopengine-widget .shopengine-avatar-container .shopengine-avatar' => 'justify-content: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'shopengine_avatar_content_gap',
            [
                'label' => esc_html__('Content Gap', 'shopengine-pro'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1,
                    ],
                ],
                'default' => [],
                'selectors' => [
                    '{{WRAPPER}} .shopengine-widget .shopengine-avatar-container .shopengine-avatar' => 'gap: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'shopengine_avatar_image_style_section',
            [
                'label' => __('Image', 'shopengine-pro'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'shopengine_avatar_image_width',
            [
                'label' => esc_html__('Image Width', 'shopengine-pro'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 250,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'default' => [],
                'selectors' => [
                    '{{WRAPPER}} .shopengine-widget .shopengine-avatar-container .shopengine-avatar .shopengine-avatar__thumbnail' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
        $this->start_controls_section(
            'shopengine_avatar_content_style_section',
            [
                'label' => __('Content Style', 'shopengine-pro'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'shopengine_avatar_right_content_gap',
            [
                'label' => esc_html__('Content Gap', 'shopengine-pro'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1,
                    ],
                ],
                'default' => [],
                'selectors' => [
                    '{{WRAPPER}} .shopengine-widget .shopengine-avatar-container .shopengine-avatar .shopengine-avatar__info' => 'gap: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'shopengine_avatar_content_name_heading',
            [
                'label' => esc_html__('Name', 'shopengine-pro'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'shopengine_avatar_content_name_color',
            [
                'label' => esc_html__('Name Color', 'shopengine-pro'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .shopengine-widget .shopengine-avatar-container .shopengine-avatar .shopengine-avatar__info--name' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'shopengine_avatar_content_name_typography',
                'selector' => '{{WRAPPER}} .shopengine-widget .shopengine-avatar-container .shopengine-avatar .shopengine-avatar__info--name',
            ]
        );
        $this->add_control(
            'shopengine_avatar_content_email_heading',
            [
                'label' => esc_html__('Email', 'shopengine-pro'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'shopengine_avatar_content_email_color',
            [
                'label' => esc_html__('Email Color', 'shopengine-pro'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .shopengine-widget .shopengine-avatar-container .shopengine-avatar .shopengine-avatar__info--email' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'shopengine_avatar_content_email_typography',
                'label'    => esc_html__('Typography', 'shopengine-pro'),
                'selector' => '{{WRAPPER}} .shopengine-widget .shopengine-avatar-container .shopengine-avatar .shopengine-avatar__info--email',
                'exclude'  => ['letter_spacing', 'text_decoration', 'text_transform'],

                'fields_options' => [
                    'typography'  => [
                        'default' => 'custom',
                    ],
                    'font_weight' => [
                        'default' => '600',
                    ],
                    'font_size'   => [
                        'label'      => esc_html__('Font Size (px)', 'shopengine-pro'),
                        'size_units' => ['px']
                    ],
                    'line_height' => [
                        'label'      => esc_html__('Line-Height (px)', 'shopengine-pro'),
                        'size_units' => ['px']
                    ],
                ],
            ]
        );
        $this->add_control(
            'shopengine_avatar_content_save_btn_heading',
            [
                'label' => esc_html__('Save Button', 'shopengine-pro'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'shopengine_avatar_content_save_btn_text_color',
            [
                'label' => esc_html__('Text Color', 'shopengine-pro'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .shopengine-widget .shopengine-avatar-container .shopengine-avatar .shopengine-avatar__info--btn' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'shopengine_avatar_content_save_btn_text_color_hover',
            [
                'label' => esc_html__('Text Hover Color', 'shopengine-pro'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .shopengine-widget .shopengine-avatar-container .shopengine-avatar .shopengine-avatar__info--btn:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'shopengine_avatar_content_save_btn_bg',
            [
                'label' => esc_html__('Background Color', 'shopengine-pro'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'separator' => 'before',
                'selectors' => [
                    '{{WRAPPER}} .shopengine-widget .shopengine-avatar-container .shopengine-avatar .shopengine-avatar__info--btn' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'shopengine_avatar_content_save_btn_bg_hover',
            [
                'label' => esc_html__('Hover Background Color', 'shopengine-pro'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .shopengine-widget .shopengine-avatar-container .shopengine-avatar .shopengine-avatar__info--btn:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'shopengine_avatar_content_save_btn_padding',
            [
                'label' => esc_html__('Padding', 'shopengine-pro'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px'],
                'selectors' => [
                    '{{WRAPPER}} .shopengine-widget .shopengine-avatar-container .shopengine-avatar .shopengine-avatar__info--btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '.rtl {{WRAPPER}} .shopengine-widget .shopengine-avatar-container .shopengine-avatar .shopengine-avatar__info--btn' => 'padding: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'shopengine_avatar_content_save_btn_border-radius',
            [
                'label' => esc_html__('Border Radius', 'shopengine-pro'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .shopengine-widget .shopengine-avatar-container .shopengine-avatar .shopengine-avatar__info--btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '.rtl {{WRAPPER}} .shopengine-widget .shopengine-avatar-container .shopengine-avatar .shopengine-avatar__info--btn' => 'border-radius: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'shopengine_avatar_content_save_btn_text_typography',
                'selector' => '{{WRAPPER}} .shopengine-widget .shopengine-avatar-container .shopengine-avatar .shopengine-avatar__info--btn',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'shopengine_avatar_upload_btn_style_section',
            [
                'label' => __('Upload Button', 'shopengine-pro'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'shopengine_avatar_upload_btn_icon_width',
            [
                'label' => esc_html__('Icon Width', 'shopengine-pro'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1,
                    ],
                ],
                'default' => [],
                'selectors' => [
                    '{{WRAPPER}} .shopengine-widget .shopengine-avatar-container .shopengine-avatar .shopengine-avatar__thumbnail--btn :is(i, svg, path)' => 'width: {{SIZE}}{{UNIT}};font-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'shopengine_avatar_upload_btn_icon_color',
            [
                'label' => esc_html__('Icon Color', 'shopengine-pro'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .shopengine-widget .shopengine-avatar-container .shopengine-avatar .shopengine-avatar__thumbnail--btn' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'shopengine_avatar_upload_btn_background_color',
            [
                'label' => esc_html__('Background Color', 'shopengine-pro'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .shopengine-widget .shopengine-avatar-container .shopengine-avatar .shopengine-avatar__thumbnail--btn' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'shopengine_avatar_upload_btn_border_radius',
            [
                'label' => esc_html__('Border Radius', 'shopengine-pro'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .shopengine-widget .shopengine-avatar-container .shopengine-avatar .shopengine-avatar__thumbnail--btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '.rtl {{WRAPPER}} .shopengine-widget .shopengine-avatar-container .shopengine-avatar .shopengine-avatar__thumbnail--btn' => 'border-radius: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'shopengine_avatar_upload_btn_padding',
            [
                'label' => esc_html__('Padding(px)', 'shopengine-pro'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px'],
                'selectors' => [
                    '{{WRAPPER}} .shopengine-widget .shopengine-avatar-container .shopengine-avatar .shopengine-avatar__thumbnail--btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '.rtl {{WRAPPER}} .shopengine-widget .shopengine-avatar-container .shopengine-avatar .shopengine-avatar__thumbnail--btn' => 'padding: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'shopengine_avatar_upload_btn_horizontal_position',
            [
                'label' => esc_html__('Horizontal Position(%)', 'shopengine-pro'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['%'],
                'range' => [
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1,
                    ],
                ],
                'default' => [],
                'selectors' => [
                    '{{WRAPPER}} .shopengine-widget .shopengine-avatar-container .shopengine-avatar .shopengine-avatar__thumbnail--btn' => 'bottom: {{SIZE}}{{UNIT}}',
                ],
            ]
        );
        $this->add_control(
            'shopengine_avatar_upload_btn_vertical_position',
            [
                'label' => esc_html__('Vertical Position(%)', 'shopengine-pro'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['%'],
                'range' => [
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1,
                    ],
                ],
                'default' => [],
                'selectors' => [
                    '{{WRAPPER}} .shopengine-widget .shopengine-avatar-container .shopengine-avatar .shopengine-avatar__thumbnail--btn' => 'left: {{SIZE}}{{UNIT}}',
                ],
            ]
        );

        $this->end_controls_section();
        $this->start_controls_section(
            'shopengine_avatar_close_btn_style_section',
            [
                'label' => __('Close Button', 'shopengine-pro'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'shopengine_avatar_close_btn_icon_color',
            [
                'label' => esc_html__('Icon Color', 'shopengine-pro'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .shopengine-widget .shopengine-avatar-container .shopengine-avatar .shopengine-avatar__thumbnail .shopengine-avatar__thumbnail--overlay-close' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'shopengine_avatar_close_btn_bg_color',
            [
                'label' => esc_html__('Background Color', 'shopengine-pro'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .shopengine-widget .shopengine-avatar-container .shopengine-avatar .shopengine-avatar__thumbnail .shopengine-avatar__thumbnail--overlay-close' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'shopengine_avatar_close_btn_size',
            [
                'label' => esc_html__('Icon Box Size', 'shopengine-pro'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .shopengine-widget .shopengine-avatar-container .shopengine-avatar .shopengine-avatar__thumbnail .shopengine-avatar__thumbnail--overlay-close' => 'width: {{SIZE}}{{UNIT}};height:{{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'shopengine_avatar_close_btn_icon_size',
            [
                'label' => esc_html__('Icon Size', 'shopengine-pro'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .shopengine-widget .shopengine-avatar-container .shopengine-avatar .shopengine-avatar__thumbnail .shopengine-avatar__thumbnail--overlay-close :is(i,svg)' => 'width: {{SIZE}}{{UNIT}};font-size:{{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'shopengine_avatar_close_btn_padding',
            [
                'label' => esc_html__('Padding', 'shopengine-pro'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px'],
                'selectors' => [
                    '{{WRAPPER}} .shopengine-widget .shopengine-avatar-container .shopengine-avatar .shopengine-avatar__thumbnail .shopengine-avatar__thumbnail--overlay-close :is(i,svg)' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '.rtl {{WRAPPER}} .shopengine-widget .shopengine-avatar-container .shopengine-avatar .shopengine-avatar__thumbnail .shopengine-avatar__thumbnail--overlay-close :is(i,svg)' => 'padding: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'shopengine_avatar_close_btn_border_radius',
            [
                'label' => esc_html__('Border Radius', 'shopengine-pro'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .shopengine-widget .shopengine-avatar-container .shopengine-avatar .shopengine-avatar__thumbnail .shopengine-avatar__thumbnail--overlay-close' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '.rtl {{WRAPPER}} .shopengine-widget .shopengine-avatar-container .shopengine-avatar .shopengine-avatar__thumbnail .shopengine-avatar__thumbnail--overlay-close' => 'border-radius: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
                ],
            ]
        );


        $this->end_controls_section();
    }

    protected function screen()
    {
        $settings = $this->get_settings_for_display();

        $tpl = Products::instance()->get_widget_template($this->get_name(), 'default', \ShopEngine_Pro::widget_dir());

        include $tpl;
    }
}
