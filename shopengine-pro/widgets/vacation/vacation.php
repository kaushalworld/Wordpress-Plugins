<?php

namespace Elementor;

use ShopEngine\Widgets\Products;
use ShopEngine_Pro; 
defined('ABSPATH') || exit;


class ShopEngine_Vacation extends \ShopEngine\Base\Widget
{

	public function config() {
		return new ShopEngine_Vacation_Config();
	}


	protected function register_controls() {

		/*
			------------------------------
			General settings
			------------------------------
		*/

		$this->start_controls_section(
			'shopengine_vacation_general',
			[
				'label' => esc_html__('General', 'shopengine-pro'),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

        $this->add_control(
			'shopengine_vacation_title',
			[
				'label'       => esc_html__('Title', 'shopengine-pro'),
				'type'        => Controls_Manager::TEXT,
				'default'     => 'Holiday Notice',
				'label_block' => true,
			]
		);

        $this->add_control(
			'shopengine_vacation_message',
			[
				'label'       => esc_html__('Vacation Message', 'shopengine-pro'),
				'type'        => Controls_Manager::TEXTAREA,
				'default'     => 'Dear customer, Today is our national holiday. We stop delivering product on our national holiday. Please stay with us. Thank you',
				'label_block' => true,
			]
            );

        $this->add_control(
			'shopengine_vacation_holiday_title',
			[
				'label'       => esc_html__('Holiday Title', 'shopengine-pro'),
				'type'        => Controls_Manager::TEXT,
				'default'     => 'Our Regular Holidays',
				'label_block' => true,
			]
		);  

        $this->add_control(
			'shopengine_vacation_emergency_title',
			[
				'label'       => esc_html__('Emergency Title', 'shopengine-pro'),
				'type'        => Controls_Manager::TEXT,
				'default'     => 'For Emergency:',
				'label_block' => true,
			]
		);

        $this->add_control(
			'shopengine_vacation_mail',
			[
				'label'       => esc_html__('Emergency Mail', 'shopengine-pro'),
				'type'        => Controls_Manager::TEXT,
				'default'     => 'example@gmail.com',
				'label_block' => true,
			]
		);

        $this->add_control(
			'shopengine_show_vacation_holiday',
			[
				'label'        => esc_html__('Show Holidays', 'shopengine-pro'),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__('Yes', 'shopengine-pro'),
				'label_off'    => esc_html__('No', 'shopengine-pro'),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->end_controls_section();

        /*
			------------------------------
			Style settings
			------------------------------
		*/

        $this->start_controls_section(
			'shopengine_vacation_content_section',
			array(
				'label' => esc_html__('Content', 'shopengine-pro'),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

        $this->add_control(
			'shopengine_vacation_content_bg',
			[
				'label'     => esc_html__('Background', 'shopengine-pro'),
				'type'      => Controls_Manager::COLOR,
				'alpha'		=> false,
				'default'   => '#FDEFF4',
				'selectors' => [
					'{{WRAPPER}} .shopengine-vacation-module-container' => 'background: {{VALUE}};',
				]
			]
		);

        $this->add_control(
			'shopengine_vacation_content_padding',
			[
				'label'      => esc_html__('Padding (px)', 'shopengine-pro'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px'],
				'default'    => [
					'top'      => '30',
					'right'    => '40',
					'bottom'   => '30',
					'left'     => '40',
					'unit'     => 'px',
					'isLinked' => false,
				],
				'selectors'  => [
					'{{WRAPPER}} .shopengine-vacation-module-container' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.rtl {{WRAPPER}} .shopengine-vacation-module-container' => 'padding: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				],
			]
		);

        $this->end_controls_section();

        //Title Section
        $this->start_controls_section(
			'shopengine_vacation_holiday_title_section',
			array(
				'label' => esc_html__('Title', 'shopengine-pro'),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);
        
        $this->add_control(
			'shopengine_vacation_holiday_title_color',
			[
				'label'     => esc_html__('Color', 'shopengine-pro'),
				'type'      => Controls_Manager::COLOR,
				'alpha'		=> false,
				'default'   => '#323131',
				'selectors' => [
					'{{WRAPPER}} .shopengine-vacation-module-container .shopengine-vacation-module-header h1' => 'color: {{VALUE}};',
				]
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'           => 'shopengine_vacation_holiday_title_typography',
				'label'          => esc_html__('Typography', 'shopengine-pro'),
				'selector'       => '{{WRAPPER}} .shopengine-vacation-module-container .shopengine-vacation-module-header h1',
				'exclude'        => ['font_family', 'text_decoration', 'font_style'],
				'fields_options' => [
					'typography'     => [
						'default' => 'custom',
					],
					'font_size'      => [
						'label'      => esc_html__('Font Size (px)', 'shopengine-pro'),
						'size_units' => ['px'],
						'default'    => [
							'size' => '20',
							'unit' => 'px'
						]
					],
					'font_weight'    => [
						'default' => '700',
					],
					'text_transform' => [
						'default' => 'capitalize',
					],
					'letter_spacing' => [
						'default' => [
							'size' => '0',
						]
					],
					'word_spacing' => [
						'default' => [
							'size' => '',
						]
					],
				],
			]
		);

        $this->add_control(
			'shopengine_vacation_margin_bottom',
			[
				'label'      => esc_html__('Space Bottom', 'shopengine-pro'),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range'      => [
					'px' => [
						'min'  => 0,
						'max'  => 40,
						'step' => 1,
					],
				],
                'default'    => [
					'unit' => 'px',
					'size' => 15,
				],
				'selectors'  => [
					'{{WRAPPER}} .shopengine-vacation-module-container .shopengine-vacation-module-header h1' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				]
			]
		);

        //Icon Separator
        $this->add_control(
			'shopengine_vacation_icon_seperator',
			[
				'label' => esc_html__( 'Icon', 'shopengine-pro' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

        $this->add_control(
			'shopengine_vacation_icon_color',
			[
				'label'     => esc_html__('Color', 'shopengine-pro'),
				'type'      => Controls_Manager::COLOR,
				'alpha'		=> false,
				'default'   => '#FF5C8D'
			]
		);

        $this->end_controls_section();

        //Message Section
        $this->start_controls_section(
			'shopengine_vacation_holiday_message_section',
			array(
				'label' => esc_html__('Message', 'shopengine-pro'),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);
        
        $this->add_control(
			'shopengine_vacation_message_color',
			[
				'label'     => esc_html__('Color', 'shopengine-pro'),
				'type'      => Controls_Manager::COLOR,
				'alpha'		=> false,
				'default'   => '#292929',
				'selectors' => [
					'{{WRAPPER}} .shopengine-vacation-module-container p' => 'color: {{VALUE}};',
				]
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'           => 'shopengine_vacation_message_typography',
				'label'          => esc_html__('Typography', 'shopengine-pro'),
				'selector'       => '{{WRAPPER}} .shopengine-vacation-module-container p',
				'exclude'        => ['font_family', 'text_decoration', 'font_style', 'text_transform'],
				'fields_options' => [
					'typography'     => [
						'default' => 'custom',
					],
					'font_size'      => [
						'label'      => esc_html__('Font Size (px)', 'shopengine-pro'),
						'size_units' => ['px'],
						'default'    => [
							'size' => '14',
							'unit' => 'px'
						]
					],
					'font_weight'    => [
						'default' => '400',
					],
					'line_height'    => [
						'size_units' => ['px'],
						'default' => [
							'size' => '18',
							'unit' => 'px'
						]
					],
					'letter_spacing' => [
						'default' => [
							'size' => '0',
						]
					],
                    'word_spacing' => [
						'default' => [
							'size' => '',
						]
					],
				],
			]
		);

        $this->end_controls_section();

        // Holidays & Emergency mail Section
        $this->start_controls_section(
			'shopengine_vacation_holidays__section',
			array(
				'label' => esc_html__('Holidays & Emergency mail', 'shopengine-pro'),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);
        
        $this->add_control(
			'shopengine_mail_title_color',
			[
				'label'     => esc_html__('Title Color', 'shopengine-pro'),
				'type'      => Controls_Manager::COLOR,
				'alpha'		=> false,
				'default'   => '#292929',
				'selectors' => [
					'{{WRAPPER}} .shopengine-vacation-module-container .shopengine-vacation-module-footer h6' => 'color: {{VALUE}};',
				]
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'           => 'shopengine_mail_title_typography',
				'label'          => esc_html__('Title Typography', 'shopengine-pro'),
				'selector'       => '{{WRAPPER}} .shopengine-vacation-module-container .shopengine-vacation-module-footer h6',
				'exclude'        => ['font_family', 'text_decoration', 'font_style', 'line_height'],
				'fields_options' => [
					'typography'     => [
						'default' => 'custom',
					],
					'font_size'      => [
						'label'      => esc_html__('Font Size (px)', 'shopengine-pro'),
						'size_units' => ['px'],
						'default'    => [
							'size' => '14',
							'unit' => 'px'
						]
					],
					'font_weight'    => [
						'default' => '500',
					],
					'text_transform' => [
						'default' => 'capitalize',
					],
					'letter_spacing' => [
						'default' => [
							'size' => '0',
						]
					],
					'word_spacing' => [
						'default' => [
							'size' => '0',
						]
					],
				],
			]
		);

        // vacation button seperator
        $this->add_control(
			'shopengine_vacation_button_seperator',
			[
				'label' => esc_html__( 'Button', 'shopengine-pro' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

        $this->add_control(
			'shopengine_vacation_button_color',
			[
				'label'     => esc_html__('Color', 'shopengine-pro'),
				'type'      => Controls_Manager::COLOR,
				'alpha'		=> false,
				'default'   => '#F1F1F2',
				'selectors' => [
					'{{WRAPPER}} .shopengine-vacation-module-container .shopengine-vacation-module-footer .vacation-holidays button' => 'color: {{VALUE}} !important;',
				]
			]
		);
        $this->add_control(
			'shopengine_vacation_button_bg',
			[
				'label'     => esc_html__('Background', 'shopengine-pro'),
				'type'      => Controls_Manager::COLOR,
				'alpha'		=> false,
				'default'   => '#FF5C8D',
				'selectors' => [
					'{{WRAPPER}} .shopengine-vacation-module-container .shopengine-vacation-module-footer .vacation-holidays button' => 'background-color: {{VALUE}} !important;',
				]
			]
		);

        $this->add_control(
			'shopengine_vacation_button_padding',
			[
				'label'      => esc_html__('Padding (px)', 'shopengine-pro'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px'],
				'default'    => [
					'top'      => '6',
					'right'    => '15',
					'bottom'   => '6',
					'left'     => '15',
					'unit'     => 'px',
					'isLinked' => false,
				],
				'selectors'  => [
					'{{WRAPPER}} .shopengine-vacation-module-container .shopengine-vacation-module-footer .vacation-holidays button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.rtl {{WRAPPER}} .shopengine-vacation-module-container .shopengine-vacation-module-footer .vacation-holidays button' => 'padding: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				],
			]
		);

        // vacation mail seperator
        $this->add_control(
			'shopengine_vacation_mail_seperator',
			[
				'label' => esc_html__( 'Emergency Mail', 'shopengine-pro' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

        $this->add_control(
			'shopengine_vacation_mail_color',
			[
				'label'     => esc_html__('Color', 'shopengine-pro'),
				'type'      => Controls_Manager::COLOR,
				'alpha'		=> false,
				'default'   => '#292929',
				'selectors' => [
					'{{WRAPPER}} .shopengine-vacation-module-container .shopengine-vacation-module-footer .vacation-emergency p a' => 'color: {{VALUE}};',
				]
			]
		);
        $this->add_control(
			'shopengine_vacation_mail_hover',
			[
				'label'     => esc_html__('Hover Color', 'shopengine-pro'),
				'type'      => Controls_Manager::COLOR,
				'alpha'		=> false,
				'default'   => '#FF5C8D',
				'selectors' => [
					'{{WRAPPER}} .shopengine-vacation-module-container .shopengine-vacation-module-footer .vacation-emergency p a:hover' => 'color: {{VALUE}};',
				]
			]
		);
        $this->end_controls_section();
	}


	protected function screen() {

		$settings = $this->get_settings_for_display();
		$tpl      = Products::instance()->get_widget_template($this->get_name(), 'default', \ShopEngine_Pro::widget_dir());
		$vacation = ShopEngine_Pro\Modules\Vacation\Vacation::instance();
		$vacation_icon_color = isset($settings['shopengine_vacation_icon_color']) ? $settings['shopengine_vacation_icon_color'] : "#FF5C8D";

		if ($vacation->module_status):
			if ($vacation->vacation_status):
				$vacation_days = $vacation->settings['regular_off_days']['value'];
				include_once $tpl;
			elseif (get_post_type() == \ShopEngine\Core\Template_Cpt::TYPE): // if vacation is not active, but we are on elementor editor, show the widget
				$vacation_days = ['sun', 'mon', 'tue', 'wed', 'thu', 'fri', 'sat'];
				include_once $tpl;
			endif;
		elseif (get_post_type() == \ShopEngine\Core\Template_Cpt::TYPE):
			esc_html_e('Please active shopengine vacation module', 'shopengine-pro');
		endif;
	}
}