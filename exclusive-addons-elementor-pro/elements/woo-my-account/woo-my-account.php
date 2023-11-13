<?php
namespace ExclusiveAddons\Elements;

if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.

use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Image_Size;
use \Elementor\Icons_Manager;
use \Elementor\Group_Control_Border;
use \Elementor\Group_Control_Box_Shadow;
use \Elementor\Group_Control_Typography;
use \Elementor\Widget_Base;
use \Elementor\Group_Control_Background;

class WC_My_Account extends Widget_Base {

	public function get_name() {
		return 'exad-woo-my-account';
	}

	public function get_title() {
		return esc_html__( 'Woo My Account', 'exclusive-addons-elementor-pro' );
	}

	public function get_icon() {
		return 'exad-logo eicon-my-account';
	}

	public function get_categories() {
		return [ 'exclusive-addons-elementor' ];
	}

    public function get_keywords() {
        return [ 'woo product account', 'my account', 'account', 'woo my Account' ];
    }

	public function get_script_depends() {
		return [ '' ];
	}

	public function register_controls() {
        $admin_link = admin_url( 'admin.php?page=exad-settings' );
        $exad_primary_color = get_option( 'exad_primary_color_option', '#7a56ff' );

        if( ! class_exists( 'woocommerce' ) ) {
		    $this->start_controls_section(
			    'exad_panel_notice',
			    [
				    'label' => __('Notice!', 'exclusive-addons-elementor-pro'),
			    ]
		    );

		    $this->add_control(
			    'exad_panel_notice_text',
			    [
				    'type'            => Controls_Manager::RAW_HTML,
				    'raw'             => __('<strong>WooCommerce</strong> is not installed/activated on your site. Please install and activate <a href="plugin-install.php?s=wpcf7&tab=search&type=term" target="_blank">WooCommerce</a> first.',
					    'exclusive-addons-elementor-pro'),
				    'content_classes' => 'exad-panel-notice',
			    ]
		    );

            $this->end_controls_section();
            return;
        }

        /**
  		*  Content Tab Preview 
  		*/
        $this->start_controls_section(
            'exad_woo_my_account_content_section',
            [
                'label' => esc_html__( 'Preview', 'exclusive-addons-elementor-pro' ),
            ]
        );

		$this->add_control(
			'exad_woo_my_account_content_select_preview',
			array(
				'label'   => __( 'Select For Preview', 'exclusive-addons-elementor-pro' ),
				'type'    => Controls_Manager::SELECT,
				'default' => '',
				'options' => [
                    ''              => esc_html__('Dashboard', 'exclusive-addons-elementor-pro' ),
                    'orders'        => esc_html__('Orders', 'exclusive-addons-elementor-pro' ),
                    'downloads'     => esc_html__('Downloads', 'exclusive-addons-elementor-pro' ),
                    'edit-address'  => esc_html__('Addresses', 'exclusive-addons-elementor-pro' ),
                    'edit-account'  => esc_html__('Account Details', 'exclusive-addons-elementor-pro' )
                ]
			)
		);

        $this->add_control(
            'exad_woo_my_account_content_update',
            [
                'label' => '<div class="elementor-update-preview" style="display: block;"><div class="elementor-update-preview-button-wrapper" style="display:block;"><button class="elementor-update-preview-button elementor-button elementor-button-success" style="background: #d30c5c; margin: 0 auto; display:block;">Apply Changes</button></div><div class="elementor-update-preview-title" style="display:block;text-align:center;margin-top: 10px;">'. __( 'Hit the button to apply changes if it hasn\'t already.', 'exclusive-addons-elementor-pro' ) .'</div></div>',
                'type' => Controls_Manager::RAW_HTML,
                'separator'  => 'after',
            ]
        );

        $this->end_controls_section();

        /**
         * -------------------------------------------
         * Tab content Woo MyAccount Navigation
         * -------------------------------------------
         */
        $this->start_controls_section(
            'exad_woo_my_account_content_section_navigation',
            [
                'label' => esc_html__( 'Navigation', 'exclusive-addons-elementor-pro' ),
            ]
        );

        $this->add_control(
			'exad_woo_my_account_navigation_alignment',
			[
				'label'   => __( 'Alignment', 'exclusive-addons-elementor-pro' ),
				'type'    => Controls_Manager::CHOOSE,
				'toggle'  => false,
				'default' => 'exad-navigation-align-left',
				'options' => [
					'exad-navigation-align-left'   => [
						'title' => __( 'Left', 'exclusive-addons-elementor-pro' ),
						'icon'  => 'eicon-arrow-left'
					],
					'exad-navigation-align-top' => [
						'title' => __( 'Top', 'exclusive-addons-elementor-pro' ),
						'icon'  => 'eicon-arrow-up'
					],
					'exad-navigation-align-right'  => [
						'title' => __( 'Right', 'exclusive-addons-elementor-pro' ),
						'icon'  => 'eicon-arrow-right'
					]
				]
			]
        );

		$this->add_control(
			'exad_woo_my_account_navigation_alignment_top_position',
			[
				'label'   => __( 'Alignment', 'exclusive-addons-elementor-pro' ),
				'type'    => Controls_Manager::CHOOSE,
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
				'default'   => 'center',
                'condition' => [
                    'exad_woo_my_account_navigation_alignment' => 'exad-navigation-align-top'
                ],
				'selectors' => [
					'{{WRAPPER}} .exad-my-account-content-wrapper.exad-navigation-align-top .woocommerce-MyAccount-navigation ul' => 'justify-content: {{VALUE}};',
					'{{WRAPPER}} .exad-my-account-content-wrapper.exad-navigation-align-top .woocommerce-MyAccount-navigation ul .exad-user-info .exad-user-wrapper' => 'align-items: {{VALUE}};'
				]
			]
		);

        $this->add_control(
			'exad_woo_my_account_navigation_show_user_info',
			[
				'label'         => esc_html__( 'Show User Info?', 'exclusive-addons-elementor-pro' ),
				'type'          => Controls_Manager::SWITCHER,
                'label_on'      => __( 'Yes', 'exclusive-addons-elementor-pro' ),
				'label_off'     => __( 'No', 'exclusive-addons-elementor-pro' ),
                'return_value'  => 'yes',
				'default'       => 'yes',
                'condition'     => [
                    // 'exad_woo_my_account_navigation_alignment' => ['exad-navigation-align-left', 'exad-navigation-align-right']
                ],
               
			]
		);

        $this->add_control(
			'exad_woo_my_account_navigation_show_dashboard',
			[
				'label'         => esc_html__( 'Show Dashboard?', 'exclusive-addons-elementor-pro' ),
				'type'          => Controls_Manager::SWITCHER,
                'label_on'      => __( 'Yes', 'exclusive-addons-elementor-pro' ),
				'label_off'     => __( 'No', 'exclusive-addons-elementor-pro' ),
                'return_value'  => 'yes',
				'default'       => 'yes',
               
			]
		);

        $this->add_control(
			'exad_woo_my_account_navigation_show_dashboard_text',
			[
				'label'      => esc_html__( 'Dashboard Text', 'exclusive-addons-elementor-pro' ),
				'type'       => Controls_Manager::TEXT,
				'default'    => esc_html__( 'Dashboard', 'exclusive-addons-elementor-pro' ),
                'separator'  => 'after',
                'condition'  => [
					'exad_woo_my_account_navigation_show_dashboard' => 'yes'
				]
			]
		);

         $this->add_control(
			'exad_woo_my_account_navigation_show_orders',
			[
				'label'         => esc_html__( 'Show Orders?', 'exclusive-addons-elementor-pro' ),
				'type'          => Controls_Manager::SWITCHER,
                'label_on'      => __( 'Yes', 'exclusive-addons-elementor-pro' ),
				'label_off'     => __( 'No', 'exclusive-addons-elementor-pro' ),
                'return_value'  => 'yes',
				'default'       => 'yes',
			]
		);

        $this->add_control(
			'exad_woo_my_account_navigation_show_orders_text',
			[
				'label'     => esc_html__( 'Orders Text', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__( 'Orders', 'exclusive-addons-elementor-pro' ),
                'separator' => 'after',
                'condition' => [
					'exad_woo_my_account_navigation_show_orders' => 'yes'
				]
			]
		);
        
        $this->add_control(
			'exad_woo_my_account_navigation_show_downloads',
			[
				'label'         => esc_html__( 'Show Downloads?', 'exclusive-addons-elementor-pro' ),
				'type'          => Controls_Manager::SWITCHER,
                'label_on'      => __( 'Yes', 'exclusive-addons-elementor-pro' ),
				'label_off'     => __( 'No', 'exclusive-addons-elementor-pro' ),
                'return_value'  => 'yes',
				'default'       => 'yes',
			]
		);

        $this->add_control(
			'exad_woo_my_account_navigation_show_downloads_text',
			[
				'label'     => esc_html__( 'Downloads Text', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__( 'Downloads', 'exclusive-addons-elementor-pro' ),
                'separator' => 'after',
                'condition' => [
					'exad_woo_my_account_navigation_show_downloads' => 'yes'
				]
			]
		);

        $this->add_control(
			'exad_woo_my_account_navigation_show_addresses',
			[
				'label'         => esc_html__( 'Show Addresses?', 'exclusive-addons-elementor-pro' ),
				'type'          => Controls_Manager::SWITCHER,
                'label_on'      => __( 'Yes', 'exclusive-addons-elementor-pro' ),
				'label_off'     => __( 'No', 'exclusive-addons-elementor-pro' ),
                'return_value'  => 'yes',
				'default'       => 'yes',
			]
		);

        $this->add_control(
			'exad_woo_my_account_navigation_show_addresses_text',
			[
				'label'     => esc_html__( 'Addresses Text', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__( 'Addresses', 'exclusive-addons-elementor-pro' ),
                'separator' => 'after',
                'condition' => [
					'exad_woo_my_account_navigation_show_addresses' => 'yes'
				]
			]
		);

        $this->add_control(
			'exad_woo_my_account_navigation_show_account_details',
			[
				'label'         => esc_html__( 'Show Account Details?', 'exclusive-addons-elementor-pro' ),
				'type'          => Controls_Manager::SWITCHER,
                'label_on'      => __( 'Yes', 'exclusive-addons-elementor-pro' ),
				'label_off'     => __( 'No', 'exclusive-addons-elementor-pro' ),
                'return_value'  => 'yes',
				'default'       => 'yes',
			]
		);

        $this->add_control(
			'exad_woo_my_account_navigation_show_account_details_text',
			[
				'label'     => esc_html__( 'Account Details Text', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__( 'Account Details', 'exclusive-addons-elementor-pro' ),
                'separator' => 'after',
                'condition' => [
					'exad_woo_my_account_navigation_show_account_details' => 'yes'
				]
			]
		);

        $this->add_control(
			'exad_woo_my_account_navigation_show_logout_link',
			[
				'label'         => esc_html__( 'Show Logout Link?', 'exclusive-addons-elementor-pro' ),
				'type'          => Controls_Manager::SWITCHER,
                'label_on'      => __( 'Yes', 'exclusive-addons-elementor-pro' ),
				'label_off'     => __( 'No', 'exclusive-addons-elementor-pro' ),
                'return_value'  => 'yes',
				'default'       => 'yes',
			]
		);

        $this->add_control(
			'exad_woo_my_account_navigation_show_logout_link_text',
			[
				'label'     => esc_html__( 'Logout Link Text', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__( 'Logout Link', 'exclusive-addons-elementor-pro' ),
                'separator' => 'after',
                'condition' => [
					'exad_woo_my_account_navigation_show_logout_link' => 'yes'
				]
			]
		);

        $this->end_controls_section();

        /**
         * -------------------------------------------
         * Tab Style Woo MyAccount Userinfo
         * -------------------------------------------
         */
        $this->start_controls_section(
            'exad_section_woo_my_account_navigation_user_info_style_settings',
            [
                'label'     => esc_html__('User Info', 'exclusive-addons-elementor-pro'),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'exad_woo_my_account_navigation_show_user_info' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'exad_woo_my_account_navigation_user_info_container_style',
            [
                'label'     => esc_html__('User Container', 'exclusive-addons-elementor-pro'),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before'
            ]
        );

		$this->add_responsive_control(
			'exad_woo_my_account_navigation_user_info_margin_bottom',
			[
				'label'       => __( 'Bottom Spacing', 'exclusive-addons-elementor-pro' ),
				'type'        => Controls_Manager::SLIDER,
				'size_units'  => [ 'px' ],
				'range'       => [
					'px'      => [
						'min' => -50,
						'max' => 100
					],
				],
				'default'     => [
					'unit'    => 'px',
					'size'    => 20
				],
				'selectors'   => [
					'{{WRAPPER}} .exad-my-account-wrapper .woocommerce-MyAccount-navigation ul li.exad-user-info:first-child'=> 'margin-bottom: {{SIZE}}{{UNIT}};'
				],
				'condition'   => [
					'exad_woo_my_account_navigation_show_user_info' => 'yes'
				]
			]
		);

        $this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'exad_woo_my_account_navigation_user_info_container_background',
				'types'    => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .exad-my-account-wrapper .woocommerce-MyAccount-navigation .exad-user-info'
			]
		);

        $this->add_responsive_control(
			'eexad_woo_my_account_navigation_user_info_container_margin',
			[
				'label'      => __( 'Margin', 'exclusive-addons-elementor-pro' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .exad-my-account-wrapper .woocommerce-MyAccount-navigation .exad-user-info' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
		);

        $this->add_responsive_control(
			'exad_woo_my_account_navigation_user_info_container_padding',
			[
				'label'      => __( 'Padding', 'exclusive-addons-elementor-pro' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .exad-my-account-wrapper .woocommerce-MyAccount-navigation .exad-user-info' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
		);

        $this->add_responsive_control(
			'exad_woo_my_account_navigation_user_info_container_radius',
			[
				'label'      => __( 'Border radius', 'exclusive-addons-elementor-pro' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .exad-my-account-wrapper .woocommerce-MyAccount-navigation .exad-user-info' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
		);

        $this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'            => 'exad_woo_my_account_navigation_user_info_container_border',
				'selector'        => '{{WRAPPER}} .exad-my-account-wrapper .woocommerce-MyAccount-navigation .exad-user-info'
			]
		);

        $this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'exad_woo_my_account_navigation_user_info_container_box_shadow',
				'selector' => '{{WRAPPER}} .exad-my-account-wrapper .woocommerce-MyAccount-navigation .exad-user-info'
			]
		);

        $this->add_control(
            'exad_woo_my_account_navigation_user_info_image_style',
            [
                'label'     => esc_html__('Image', 'exclusive-addons-elementor-pro'),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before'
            ]
        );

		$this->add_responsive_control(
			'eexad_woo_my_account_navigation_user_info_image_height',
			[
				'label'       => __( 'Height', 'exclusive-addons-elementor-pro' ),
				'type'        => Controls_Manager::SLIDER,
				'size_units'  => [ 'px' ],
				'range'       => [
					'px'      => [
						'min' => 0,
						'max' => 500
					]
				],
				'default'     => [
					'unit'    => 'px',
					'size'    => 80
				],
				'selectors'   => [
					'{{WRAPPER}} .exad-my-account-wrapper .woocommerce-MyAccount-navigation .exad-user-info .exad-user-thumb'=> 'height: {{SIZE}}{{UNIT}};'
				],
				'condition'   => [
					'exad_woo_my_account_navigation_show_user_info' => 'yes'
				]
			]
		);

		$this->add_responsive_control(
			'exad_woo_my_account_navigation_user_info_image_width',
			[
				'label'       => __( 'Width', 'exclusive-addons-elementor-pro' ),
				'type'        => Controls_Manager::SLIDER,
				'separator'   => 'after',
				'size_units'  => [ 'px' ],
				'range'       => [
					'px'      => [
						'min' => 0,
						'max' => 500
					]
				],
				'default'     => [
					'unit'    => 'px',
					'size'    => 80
				],
				'selectors'   => [
					'{{WRAPPER}} .exad-my-account-wrapper .woocommerce-MyAccount-navigation .exad-user-info .exad-user-thumb'=> 'width: {{SIZE}}{{UNIT}};',
				],
				'condition'   => [
					'exad_woo_my_account_navigation_show_user_info' => 'yes'
				]
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'      => 'exad_woo_my_account_navigation_user_info_image_border',
				'selector'  => '{{WRAPPER}} .exad-my-account-wrapper .woocommerce-MyAccount-navigation .exad-user-info .exad-user-thumb',
				'condition' => [
					'exad_woo_my_account_navigation_show_user_info' => 'yes'
				]
			]
		);

		$this->add_responsive_control(
			'exad_woo_my_account_navigation_user_info_image_radius',
			[
				'label'      => __( 'Border radius', 'exclusive-addons-elementor-pro' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'default'    => [
					'top'    => '50',
					'right'  => '50',
					'bottom' => '50',
					'left'   => '50',
					'unit'   => '%'
				],
				'selectors'  => [
					'{{WRAPPER}} .exad-my-account-wrapper .woocommerce-MyAccount-navigation .exad-user-info .exad-user-thumb'     => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .exad-my-account-wrapper .woocommerce-MyAccount-navigation .exad-user-info .exad-user-thumb img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'exad_woo_my_account_navigation_user_info_image_shadow',
				'selector' => '{{WRAPPER}} .exad-my-account-wrapper .woocommerce-MyAccount-navigation .exad-user-info .exad-user-thumb'
			]
		);

        $this->add_control(
            'exad_woo_my_account_navigation_user_info_style',
            [
                'label'     => esc_html__('Name', 'exclusive-addons-elementor-pro'),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before'
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'exad_woo_my_account_navigation_user_info_typography',
                'selector' => ' {{WRAPPER}} .exad-my-account-wrapper .woocommerce-MyAccount-navigation .exad-user-info .exad-user-name h4',
                'fields_options'     => [
                    'text_transform' => [
                        'default'    => 'capitalize'
                    ]
                ]
            ]
        );

        $this->add_control(
            'exad_woo_my_account_navigation_user_info_color_style',
            [
                'label'     => esc_html__('Name Color', 'exclusive-addons-elementor-pro'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#444444',
                'selectors' => [
                    '{{WRAPPER}} .exad-my-account-wrapper .woocommerce-MyAccount-navigation .exad-user-info .exad-user-name h4' => 'color: {{VALUE}};'
                ]
            ]
        );

        $this->add_responsive_control(
			'exad_woo_my_account_navigation_user_info_name_margin_bottom',
			[
				'label'       => __( 'Left Spacing', 'exclusive-addons-elementor-pro' ),
				'type'        => Controls_Manager::SLIDER,
				'size_units'  => [ 'px' ],
				'range'       => [
					'px'      => [
						'min' => -50,
						'max' => 100
					],
				],
                'default' => [
					'size' => 12,
					'unit' => 'px',
				],
				'selectors'   => [
					'{{WRAPPER}} .exad-my-account-wrapper .woocommerce-MyAccount-navigation .exad-user-info .exad-user-name'=> 'margin-left: {{SIZE}}{{UNIT}};'
				],
				'condition'   => [
					'exad_woo_my_account_navigation_show_user_info' => 'yes',
                    'exad_woo_my_account_navigation_alignment!' => 'exad-navigation-align-top'
				]
			]
		);

        $this->add_responsive_control(
			'exad_woo_my_account_navigation_user_info_name_margin_top',
			[
				'label'       => __( 'Top Spacing', 'exclusive-addons-elementor-pro' ),
				'type'        => Controls_Manager::SLIDER,
				'size_units'  => [ 'px' ],
				'range'       => [
					'px'      => [
						'min' => 0,
						'max' => 100
					],
				],
                'default' => [
					'size' => 12,
					'unit' => 'px',
				],
				'selectors'   => [
					'{{WRAPPER}} .exad-my-account-wrapper .woocommerce-MyAccount-navigation .exad-user-info .exad-user-name'=> 'margin-top: {{SIZE}}{{UNIT}};'
				],
				'condition'   => [
					'exad_woo_my_account_navigation_show_user_info' => 'yes',
                    'exad_woo_my_account_navigation_alignment' => 'exad-navigation-align-top'
				]
			]
		);

        $this->end_controls_section();

        /**
         * -------------------------------------------
         * Tab Style Woo MyAccount Navigation
         * -------------------------------------------
         */
        $this->start_controls_section(
            'exad_section_woo_my_account_navigation_control_style_settings',
            [
                'label' => esc_html__('Navigation', 'exclusive-addons-elementor-pro'),
                'tab'   => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_control(
            'exad_woo_my_account_navigation_control_item_container_style',
            [
                'label'     => esc_html__('MyAccount Navigation', 'exclusive-addons-elementor-pro'),
                'type'      => Controls_Manager::HEADING
            ]
        );

        $this->add_responsive_control(
			'exad_woo_my_account_navigation_width',
			[
				'label'       => __( 'Navigation Width', 'exclusive-addons-elementor-pro' ),
				'type'        => Controls_Manager::SLIDER,
				'size_units'  => [ '%', 'px' ],
				'range'       => [
					'px'      => [
						'min' => 10,
						'max' => 48
					],
				],
                'devices' => [ 'desktop', 'tablet', 'mobile' ],
				'desktop_default' => [
					'size' => 30,
					'unit' => '%',
				],
                'tablet_default' => [
					'size' => 30,
					'unit' => '%',
				],
				'mobile_default' => [
					'size' => 100,
					'unit' => '%',
				],
                'condition' => [
                    'exad_woo_my_account_navigation_alignment' => ['exad-navigation-align-left', 'exad-navigation-align-right']
                ],
				'selectors'   => [
					'{{WRAPPER}} .exad-my-account-content-wrapper .woocommerce .woocommerce-MyAccount-navigation' => ' width: {{SIZE}}{{UNIT}};',
					'.theme-kadence .exad-my-account-content-wrapper .woocommerce .account-navigation-wrap' => ' width: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .exad-my-account-content-wrapper .woocommerce .woocommerce-MyAccount-content' => ' width: calc( 100% - {{SIZE}}{{UNIT}} );',
                ],
			]
		);

        $this->add_responsive_control(
            'exad_woo_my_account_navigation_control_container_padding',
            [
                'label'        => esc_html__('Padding', 'exclusive-addons-elementor-pro'),
                'type'         => Controls_Manager::DIMENSIONS,
                'size_units'   => ['px', 'em', '%'],
                'default'      => [
                    'top'      => '30',
                    'right'    => '20',
                    'bottom'   => '30',
                    'left'     => '20',
                    'unit'     => 'px',
                    'isLinked' => false
                ],
                'selectors'    => [
                    '{{WRAPPER}} .exad-my-account-wrapper .woocommerce-MyAccount-navigation' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '.theme-kadence .exad-my-account-content-wrapper .woocommerce .account-navigation-wrap' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',

                ]
            ]
        );

        $this->add_responsive_control(
            'exad_woo_my_account_navigation_control_container_margin',
            [
                'label'        => esc_html__('Margin', 'exclusive-addons-elementor-pro'),
                'type'         => Controls_Manager::DIMENSIONS,
                'size_units'   => ['px', 'em', '%'],
                'default'      => [
                    'top'      => '0',
                    'right'    => '0',
                    'bottom'   => '0',
                    'left'     => '0',
                    'unit'     => 'px',
                    'isLinked' => false
                ],
                'selectors'    => [
                    '{{WRAPPER}} .exad-my-account-wrapper .woocommerce-MyAccount-navigation' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '.theme-kadence .exad-my-account-content-wrapper .woocommerce .account-navigation-wrap' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ]
            ]
        );

        $this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'      => 'exad_woo_my_account_navigation_control_container_background',
				'label'     => __( 'Background', 'exclusive-addons-elementor-pro' ),
				'types'     => [ 'classic', 'gradient' ],
				'selector'  => '{{WRAPPER}} .exad-my-account-wrapper .woocommerce-MyAccount-navigation, .theme-kadence .exad-my-account-content-wrapper .woocommerce .account-navigation-wrap',
			]
		);

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'exad_woo_my_account_navigation_control_container_border',
                'selector' => '{{WRAPPER}} .exad-my-account-wrapper .woocommerce-MyAccount-navigation, .theme-kadence .exad-my-account-content-wrapper .woocommerce .account-navigation-wrap',
            ]
        );

        $this->add_responsive_control(
            'exad_woo_my_account_navigation_control_container_border_radius',
            [
                'label'      => esc_html__('Border Radius', 'exclusive-addons-elementor-pro'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'default'    => [
                    'top'    => 0,
                    'right'  => 0,
                    'bottom' => 0,
                    'left'   => 0,
                    'unit'   => 'px'
                ],
                'selectors'  => [
                    '{{WRAPPER}} .exad-my-account-wrapper .woocommerce-MyAccount-navigation' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '.theme-kadence .exad-my-account-content-wrapper .woocommerce .account-navigation-wrap' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'                   => 'exad_woo_my_account_navigation_control_shadow',
                'selector'               => '{{WRAPPER}} .exad-my-account-wrapper .woocommerce-MyAccount-navigation, .theme-kadence .exad-my-account-content-wrapper .woocommerce .account-navigation-wrap',
                'fields_options'         => [
                    'box_shadow_type'    => [ 
                        'default'        =>'yes' 
                    ],
                    'box_shadow'         => [
                        'default'        => [
                            'horizontal' => 0,
                            'vertical'   => 10,
                            'blur'       => 33,
                            'spread'     => 0,
                            'color'      => 'rgba(51, 77, 128, 0.1)'
                        ]
                    ]
                ]
            ]
        );

        $this->add_control(
            'exad_woo_my_account_control_item_style',
            [
                'label'     => esc_html__('Control Items', 'exclusive-addons-elementor-pro'),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before'
            ]
        );

        $this->add_responsive_control(
            'exad_woo_my_account_item_control_item_alignment',
            [
                'label'         => esc_html__('Item Alignment', 'exclusive-addons-elementor-pro'),
                'type'          => Controls_Manager::CHOOSE,
                'toggle'        => false,
                'label_block'   => true,
                'default'       => 'left',
                'options'       => [
                    'left'      => [
                        'title' => esc_html__('Left', 'exclusive-addons-elementor-pro'),
                        'icon'  => 'eicon-text-align-left'
                    ],
                    'center'    => [
                        'title' => esc_html__('Center', 'exclusive-addons-elementor-pro'),
                        'icon'  => 'eicon-text-align-center'
                    ],
                    'right'     => [
                        'title' => esc_html__('Right', 'exclusive-addons-elementor-pro'),
                        'icon'  => 'eicon-text-align-right'
                    ],
					'justify' => [
						'title' => __( 'Justified', 'exclusive-addons-elementor-pro' ),
						'icon'  => 'eicon-text-align-justify',
                    ],
                ],
                'selectors_dictionary' => [
                    'left'      => 'text-align: left;',
					'center'    => 'text-align: center;',
					'right'     => 'text-align: right;',
                    'justify'   => 'display: block; width: 100%; justify-content: center; text-align: center;',
                ],
                'selectors'     => [
                    '{{WRAPPER}} .exad-my-account-wrapper .woocommerce-MyAccount-navigation ul li a, {{WRAPPER}} .exad-my-account-wrapper .woocommerce-MyAccount-navigation ul li' => '{{VALUE}};'
                ]
            ]
        );

        $this->add_responsive_control(
            'exad_woo_my_account_control_item_padding',
            [
                'label'      => esc_html__('Padding', 'exclusive-addons-elementor-pro'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'default'    => [
                    'top'    => 5,
                    'right'  => 10,
                    'bottom' => 5,
                    'left'   => 5,
                    'unit'   => 'px'
                ],
                'selectors'  => [
                    '{{WRAPPER}} .exad-my-account-wrapper .woocommerce-MyAccount-navigation li > a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->add_responsive_control(
			'exad_woo_my_account_control_item_spacing',
			[
				'label'       => __( 'Between Items Spacing', 'exclusive-addons-elementor-pro' ),
				'type'        => Controls_Manager::SLIDER,
				'size_units'  => [ 'px' ],
				'range'       => [
					'px'      => [
						'min' => 0,
						'max' => 100
					],
				],
                'default'    => [
                    'unit'   => 'px',
                    'size'   => 10
                ],
                'condition' => [
                    'exad_woo_my_account_navigation_alignment' => ['exad-navigation-align-left', 'exad-navigation-align-right']
                ],
				'selectors'   => [
					'{{WRAPPER}} .exad-my-account-content-wrapper.exad-navigation-align-left .woocommerce-MyAccount-navigation li:not(:last-child)' => 'margin-bottom: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .exad-my-account-content-wrapper.exad-navigation-align-right .woocommerce-MyAccount-navigation li:not(:last-child)' => 'margin-bottom: {{SIZE}}{{UNIT}};'
                ],
			]
		);

        $this->add_responsive_control(
			'exad_woo_my_account_control_item_spacing_top',
			[
				'label'       => __( 'Between Items Spacing', 'exclusive-addons-elementor-pro' ),
				'type'        => Controls_Manager::SLIDER,
				'size_units'  => [ 'px' ],
				'range'       => [
					'px'      => [
						'min' => 0,
						'max' => 100
					],
				],
                'default'    => [
                    'unit'   => 'px',
                    'size'   => 10
                ],
                'condition' => [
                    'exad_woo_my_account_navigation_alignment' => 'exad-navigation-align-top'
                ],
				'selectors'   => [
					'{{WRAPPER}} .exad-my-account-content-wrapper.exad-navigation-align-top .woocommerce-MyAccount-navigation ul li:not(:last-child)' => 'margin-right: {{SIZE}}{{UNIT}};'
                ],
			]
		);

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'exad_woo_my_account_control_typography',
                'selector' => '{{WRAPPER}} .exad-my-account-wrapper .woocommerce-MyAccount-navigation li > a',
                'fields_options'     => [
                    'text_transform' => [
                        'default'    => 'capitalize'
                    ]
                ]
            ]
        );

        // Tabs
        $this->start_controls_tabs('exad_woo_my_account_control_tabs');

        // Normal State Tab
        $this->start_controls_tab('exad_woo_my_account_control_normal', ['label' => esc_html__('Normal', 'exclusive-addons-elementor-pro')]);

        $this->add_control(
            'exad_woo_my_account_control_normal_text_color',
            [
                'label'     => esc_html__('Text Color', 'exclusive-addons-elementor-pro'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#444444',
                'selectors' => [
                    '{{WRAPPER}} .exad-my-account-wrapper .woocommerce-MyAccount-navigation li > a' => 'color: {{VALUE}};'
                ]
            ]
        );

        $this->add_control(
            'exad_woo_my_account_control_normal_bg_color',
            [
                'label'     => esc_html__('Background Color', 'exclusive-addons-elementor-pro'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .exad-my-account-wrapper .woocommerce-MyAccount-navigation ul li a' => 'background: {{VALUE}};'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'                 => 'exad_woo_my_account_control_normal_border',
                'fields_options'       => [
                    'border'           => [
                        'default'      => 'solid'
                    ],
                    'width'            => [
                        'default'      => [
                            'top'      => '0',
                            'right'    => '0',
                            'bottom'   => '2',
                            'left'     => '0',
                            'isLinked' => false
                        ]
                    ],
                    'color'            => [
                        'default'      => 'rgba(255,255,255,0)'
                    ]
                ],
                'selector'             => '{{WRAPPER}} .exad-my-account-wrapper .woocommerce-MyAccount-navigation ul li a'
            ]
        );

        $this->add_responsive_control(
            'exad_woo_my_account_control_normal_border_radius',
            [
                'label'   => esc_html__('Border Radius', 'exclusive-addons-elementor-pro'),
                'type'    => Controls_Manager::SLIDER,
                'range'   => [
                    'px'  => [
                        'max' => 30
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .exad-my-account-wrapper .woocommerce-MyAccount-navigation ul li a' => 'border-radius: {{SIZE}}px;'
                ]
            ]
        );

        $this->end_controls_tab();

        // Hover State Tab
        $this->start_controls_tab('exad_woo_my_account_control_btn_hover', ['label' => esc_html__('Hover', 'exclusive-addons-elementor-pro')]);

        $this->add_control(
            'exad_woo_my_account_control_hover_text_color',
            [
                'label'     => esc_html__('Text Color', 'exclusive-addons-elementor-pro'),
                'type'      => Controls_Manager::COLOR,
                'default'   => $exad_primary_color,
                'selectors' => [
                    '{{WRAPPER}} .exad-my-account-wrapper .woocommerce-MyAccount-navigation li > a:hover' => 'color: {{VALUE}};'
                ]
            ]
        );

        $this->add_control(
            'exad_woo_my_account_control_hover_bg_color',
            [
                'label'     => esc_html__('Background Color', 'exclusive-addons-elementor-pro'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .exad-my-account-wrapper .woocommerce-MyAccount-navigation ul li a:hover' => 'background: {{VALUE}};'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'exad_woo_my_account_control_hover_border',
                'selector' => '{{WRAPPER}} .exad-my-account-wrapper .woocommerce-MyAccount-navigation ul li a:hover'
            ]
        );

        $this->add_responsive_control(
            'exad_woo_my_account_control_hover_border_radius',
            [
                'label'       => esc_html__('Border Radius', 'exclusive-addons-elementor-pro'),
                'type'        => Controls_Manager::SLIDER,
                'range'       => [
                    'px'      => [
                        'max' => 30
                    ]
                ],
                'selectors'   => [
                    '{{WRAPPER}} .exad-my-account-wrapper .woocommerce-MyAccount-navigation ul li a:hover' => 'border-radius: {{SIZE}}px;'
                ]
            ]
        );

        $this->end_controls_tab();

        // Active State Tab
        $this->start_controls_tab('exad_woo_my_account_control_btn_active', ['label' => esc_html__('Active', 'exclusive-addons-elementor-pro')]);

        $this->add_control(
            'exad_woo_my_account_control_active_text_color',
            [
                'label'     => esc_html__('Text Color', 'exclusive-addons-elementor-pro'),
                'type'      => Controls_Manager::COLOR,
                'default'   => $exad_primary_color,
                'selectors' => [
                    '{{WRAPPER}} .exad-my-account-wrapper .woocommerce-MyAccount-navigation ul li.is-active a' => 'color: {{VALUE}};'
                ]
            ]
        );

        $this->add_control(
            'exad_woo_my_account_control_active_bg_color',
            [
                'label'     => esc_html__('Background Color', 'exclusive-addons-elementor-pro'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .exad-my-account-wrapper .woocommerce-MyAccount-navigation ul li.is-active a' => 'background: {{VALUE}};'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'                 => 'exad_woo_my_account_control_active_border',
                'fields_options'       => [
                    'border'           => [
                        'default'      => 'solid'
                    ],
                    'width'            => [
                        'default'      => [
                            'top'      => '0',
                            'right'    => '0',
                            'bottom'   => '2',
                            'left'     => '0',
                            'isLinked' => false
                        ]
                    ],
                    'color'            => [
                        'default'      => $exad_primary_color
                    ]
                ],
                'selector'             => '{{WRAPPER}} .exad-my-account-wrapper .woocommerce-MyAccount-navigation ul li.is-active a'
            ]
        );

        $this->add_responsive_control(
            'exad_woo_my_account_control_active_border_radius',
            [
                'label'       => esc_html__('Border Radius', 'exclusive-addons-elementor-pro'),
                'type'        => Controls_Manager::SLIDER,
                'range'       => [
                    'px'      => [
                        'max' => 30
                    ]
                ],
                'selectors'   => [
                    '{{WRAPPER}} .exad-my-account-wrapper .woocommerce-MyAccount-navigation ul li.is-active a' => 'border-radius: {{SIZE}}px;'
                ]
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();

        /**
         * -------------------------------------------
         * Tab Style Woo MyAccount Navigation
         * -------------------------------------------
         */
        $this->start_controls_section(
            'exad_section_woo_my_account_content_area_style_settings',
            [
                'label' => esc_html__('Content Area', 'exclusive-addons-elementor-pro'),
                'tab'   => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_control(
            'exad_woo_my_account_content_container_heading_style',
            [
                'label'     => esc_html__('Container', 'exclusive-addons-elementor-pro'),
                'type'      => Controls_Manager::HEADING
            ]
        );

        $this->add_responsive_control(
			'exad_woo_my_account_content_container_spacing',
			[
				'label'       => __( 'Left & Right Spacing', 'exclusive-addons-elementor-pro' ),
				'type'        => Controls_Manager::SLIDER,
				'size_units'  => [ 'px' ],
				'range'       => [
					'px'      => [
						'min' => 0,
						'max' => 100
					],
				],
                'default'    => [
                    'unit'   => 'px',
                    'size'   => 10
                ],
                'tablet_default' => [
					'size' => 0,
					'unit' => '%',
				],
                'mobile_default' => [
					'size' => 0,
					'unit' => 'px',
				],
                'condition' => [
                    'exad_woo_my_account_navigation_alignment!' => 'exad-navigation-align-top'
                ],
				'selectors'   => [
					'{{WRAPPER}} .exad-my-account-content-wrapper.exad-navigation-align-left .woocommerce-MyAccount-content' => 'margin-left: {{SIZE}}{{UNIT}}; width: calc( ( 100% - {{exad_woo_my_account_navigation_width.size}}{{exad_woo_my_account_navigation_width.unit}} ) - {{SIZE}}{{UNIT}} );',
					'{{WRAPPER}} .exad-my-account-content-wrapper.exad-navigation-align-right .woocommerce-MyAccount-content' => 'margin-right: {{SIZE}}{{UNIT}}; width: calc( ( 100% - {{exad_woo_my_account_navigation_width.size}}{{exad_woo_my_account_navigation_width.unit}} ) - {{SIZE}}{{UNIT}} );',
                ],
			]
		);
        
        $this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'exad_woo_my_account_content_container_background',
				'types'    => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .exad-my-account-wrapper .woocommerce .woocommerce-MyAccount-content'
			]
		);

        $this->add_responsive_control(
			'exad_woo_my_account_content_container_margin',
			[
				'label'      => __( 'Margin', 'exclusive-addons-elementor-pro' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .exad-my-account-wrapper .woocommerce .woocommerce-MyAccount-content' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
		);

        $this->add_responsive_control(
			'exad_woo_my_account_content_container_padding',
			[
				'label'      => __( 'Padding', 'exclusive-addons-elementor-pro' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
                'default'      => [
                    'top'      => '10',
                    'right'    => '10',
                    'bottom'   => '10',
                    'left'     => '10',
                    'unit'     => 'px',
                    'isLinked' => true
                ],
				'selectors'  => [
					'{{WRAPPER}} .exad-my-account-wrapper .woocommerce .woocommerce-MyAccount-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
		);

        $this->add_responsive_control(
			'exad_woo_my_account_content_container_radius',
			[
				'label'      => __( 'Border radius', 'exclusive-addons-elementor-pro' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'separator'  => 'after',
				'selectors'  => [
					'{{WRAPPER}} .exad-my-account-wrapper .woocommerce .woocommerce-MyAccount-content' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
		);

        $this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'            => 'exad_woo_my_account_content_container_border',
				'selector'        => '{{WRAPPER}} .exad-my-account-wrapper .woocommerce .woocommerce-MyAccount-content'
			]
		);

        $this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'exad_woo_my_account_content_container_box_shadow',
				'selector' => '{{WRAPPER}} .exad-my-account-wrapper .woocommerce .woocommerce-MyAccount-content'
			]
		);

        $this->end_controls_section();

        /**
         * -------------------------------------------
         * Tab Style Table Style
         * -------------------------------------------
         */ 
        $this->start_controls_section(
            'exad_section_woo_my_account_tables_style',
            [
                'label' => esc_html__('Tables', 'exclusive-addons-elementor-pro'),
                'tab'   => Controls_Manager::TAB_STYLE
            ]
        );
        
        $this->add_control(
            'exad_woo_my_account_table_style',
            [
                'label'     => esc_html__('Table', 'exclusive-addons-elementor-pro'),
                'type'      => Controls_Manager::HEADING
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'exad_woo_my_account_table_typography',
                'selector' => ' {{WRAPPER}} .exad-my-account-wrapper .woocommerce table thead th, {{WRAPPER}} .exad-my-account-wrapper .woocommerce table tbody td, {{WRAPPER}} .exad-my-account-wrapper .woocommerce table tfoot td',
                'fields_options'     => [
                    'text_transform' => [
                        'default'    => 'capitalize'
                    ]
                ]
            ]
        );

        $this->add_control(
			'exad_woo_my_account_table_row_vertical_alignment',
			[
				'label'   => __( 'Vertical Alignment', 'exclusive-addons-elementor-pro' ),
				'type'    => Controls_Manager::CHOOSE,
				'options' => [
					'top' => [
						'title'  => __( 'Top', 'exclusive-addons-elementor-pro' ),
						'icon'   => 'eicon-v-align-top'
					],
					'middle'     => [
						'title'  => __( 'Middle', 'exclusive-addons-elementor-pro' ),
						'icon'   => 'eicon-v-align-middle'
					],
					'bottom'   => [
						'title'  => __( 'Bottom', 'exclusive-addons-elementor-pro' ),
						'icon'   => 'eicon-v-align-bottom'
					]
				],
				'default' => 'middle',
				'selectors' => [
					'{{WRAPPER}} .exad-my-account-wrapper .woocommerce table tbody tr td, {{WRAPPER}} .exad-my-account-wrapper .woocommerce table thead tr th' => 'vertical-align: {{VALUE}};'
				]
			]
		);

        $this->add_control(
			'exad_woo_my_account_table_row_horizontal_alignment',
			[
				'label'   => __( 'Horizontal Alignment', 'exclusive-addons-elementor-pro' ),
				'type'    => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title'  => __( 'Left', 'exclusive-addons-elementor-pro' ),
						'icon'   => 'eicon-text-align-left'
					],
					'center'     => [
						'title'  => __( 'Center', 'exclusive-addons-elementor-pro' ),
						'icon'   => 'eicon-text-align-center'
					],
					'right'   => [
						'title'  => __( 'Right', 'exclusive-addons-elementor-pro' ),
						'icon'   => 'eicon-text-align-right'
					]
				],
				'default' => 'center',
				'selectors' => [
					'{{WRAPPER}} .exad-my-account-wrapper .woocommerce table tbody tr td, {{WRAPPER}} .exad-my-account-wrapper .woocommerce table thead tr th' => 'text-align: {{VALUE}};'
				]
			]
		);

        $this->add_responsive_control(
            'exad_woo_my_account_table_padding',
            [
                'label'      => esc_html__('Padding', 'exclusive-addons-elementor-pro'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'default'    => [
                    'top'    => 10,
                    'right'  => 10,
                    'bottom' => 10,
                    'left'   => 10,
                    'unit'   => 'px'
                ],
                'selectors'  => [
                    '{{WRAPPER}} .exad-my-account-wrapper .woocommerce table' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->add_control(
            'exad_woo_my_account_table_bg_color',
            [
                'label'     => esc_html__('Background Color', 'exclusive-addons-elementor-pro'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .exad-my-account-wrapper .woocommerce table' => 'background: {{VALUE}};'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'                 => 'exad_woo_my_account_table_border',
                'fields_options'       => [
                    'border'           => [
                        'default'      => 'solid'
                    ],
                    'color'            => [
                        'default'      => 'rgba(255,255,255,0)'
                    ]
                ],
                'selector'             => '{{WRAPPER}} .exad-my-account-wrapper .woocommerce table'
            ]
        );

        $this->add_control(
            'exad_woo_my_account_table_border_radius',
            [
                'label'   => esc_html__('Border Radius', 'exclusive-addons-elementor-pro'),
                'type'    => Controls_Manager::SLIDER,
                'range'   => [
                    'px'  => [
                        'max' => 30
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .exad-my-account-wrapper .woocommerce table' => 'border-radius: {{SIZE}}px;'
                ]
            ]
        );

        $this->add_control(
            'exad_woo_my_account_table_header_style',
            [
                'label'     => esc_html__('Header', 'exclusive-addons-elementor-pro'),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'exad_woo_my_account_table_header_typography',
                'selector' => '{{WRAPPER}} .exad-my-account-wrapper .woocommerce table thead th',
                'fields_options'     => [
                    'text_transform' => [
                        'default'    => 'capitalize'
                    ]
                ]
            ]
        );

        $this->add_control(
            'exad_woo_my_account_table_header_color',
            [
                'label'     => esc_html__('Header Color', 'exclusive-addons-elementor-pro'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#444444',
                'selectors' => [
                    '{{WRAPPER}} .exad-my-account-wrapper .woocommerce table thead th' => 'color: {{VALUE}};'
                ]
            ]
        );

        $this->add_control(
            'exad_woo_my_account_table_header_bg_color',
            [
                'label'     => esc_html__('Header Background Color', 'exclusive-addons-elementor-pro'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .exad-my-account-wrapper .woocommerce table thead th'      => 'background: {{VALUE}};'
                ]
            ]
        );

        $this->add_responsive_control(
            'exad_woo_my_account_table_header_padding',
            [
                'label'      => esc_html__('Padding', 'exclusive-addons-elementor-pro'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .exad-my-account-wrapper .woocommerce table thead th' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'exad_woo_my_account_table_header_border',
                'selector' => '{{WRAPPER}} .exad-my-account-wrapper .woocommerce table thead th'
            ]
        );

        $this->add_control(
            'exad_woo_my_account_table_row_style',
            [
                'label'     => esc_html__('Table Rows', 'exclusive-addons-elementor-pro'),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'exad_woo_my_account_table_row_color',
            [
                'label'     => esc_html__('Row Color', 'exclusive-addons-elementor-pro'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#444444',
                'selectors' => [
                    '{{WRAPPER}} .exad-my-account-wrapper .woocommerce table tbody tr td' => 'color: {{VALUE}};'
                ]
            ]
        );

        $this->add_control(
            'exad_woo_my_account_table_row_bg_color',
            [
                'label'     => esc_html__('Row Background Color', 'exclusive-addons-elementor-pro'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .exad-my-account-wrapper .woocommerce table tbody tr td'      => 'background: {{VALUE}};'
                ]
            ]
        );

        $this->add_control(
            'exad_woo_my_account_table_even_row_color',
            [
                'label'     => esc_html__('Even Color', 'exclusive-addons-elementor-pro'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#444444',
                'selectors' => [
                    '{{WRAPPER}} .exad-my-account-wrapper .woocommerce table tbody tr:nth-child(even) td' => 'color: {{VALUE}};'
                ]
            ]
        );

        $this->add_control(
            'exad_woo_my_account_table_even_row_bg_color',
            [
                'label'     => esc_html__('Even Background Color', 'exclusive-addons-elementor-pro'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .exad-my-account-wrapper .woocommerce table tbody tr:nth-child(even) td'      => 'background: {{VALUE}};'
                ]
            ]
        );

        $this->add_control(
            'exad_woo_my_account_table_cell_style',
            [
                'label'     => esc_html__('Table Cell', 'exclusive-addons-elementor-pro'),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_responsive_control(
            'exad_woo_my_account_table_cell_padding',
            [
                'label'      => esc_html__('Padding', 'exclusive-addons-elementor-pro'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .exad-my-account-wrapper .woocommerce table tbody tr td' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'                 => 'exad_woo_my_account_table_cell_border',
                'fields_options'       => [
                    'border'           => [
                        'default'      => 'solid'
                    ],
                    'color'            => [
                        'default'      => '#ccc'
                    ]
                ],
                'selector'             => '{{WRAPPER}} .exad-my-account-wrapper .woocommerce table tbody tr td'
            ]
        );

        $this->add_control(
            'exad_woo_my_account_table_footer_style',
            [
                'label'     => esc_html__('Table Footer', 'exclusive-addons-elementor-pro'),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'exad_woo_my_account_table_footer_typography',
                'selector' => '{{WRAPPER}} .exad-my-account-wrapper .woocommerce table tfoot td',
                'fields_options'     => [
                    'text_transform' => [
                        'default'    => 'capitalize'
                    ]
                ]
            ]
        );

        $this->add_control(
            'exad_woo_my_account_table_footer_color',
            [
                'label'     => esc_html__('Footer Color', 'exclusive-addons-elementor-pro'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#444444',
                'selectors' => [
                    '{{WRAPPER}} .exad-my-account-wrapper .woocommerce table tfoot td' => 'color: {{VALUE}};'
                ]
            ]
        );

        $this->add_control(
            'exad_woo_my_account_table_footer_bg_color',
            [
                'label'     => esc_html__('Footer Background Color', 'exclusive-addons-elementor-pro'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .exad-my-account-wrapper .woocommerce table tfoot td'      => 'background: {{VALUE}};'
                ]
            ]
        );

        $this->add_responsive_control(
            'exad_woo_my_account_table_footer_padding',
            [
                'label'      => esc_html__('Padding', 'exclusive-addons-elementor-pro'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .exad-my-account-wrapper .woocommerce table tfoot td' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'exad_woo_my_account_table_footer_border',
                'selector' => '{{WRAPPER}} .exad-my-account-wrapper .woocommerce table tfoot td'
            ]
        );

        $this->add_control(
            'exad_woo_my_account_table_btn_style',
            [
                'label'     => esc_html__('Table Button', 'exclusive-addons-elementor-pro'),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );
       
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'exad_woo_my_account_table_btn_typography',
                'selector' => '{{WRAPPER}} .exad-my-account-wrapper .woocommerce table tbody tr td a.button',
                'fields_options'     => [
                    'text_transform' => [
                        'default'    => 'capitalize'
                    ]
                ]
            ]
        );

        $this->add_responsive_control(
            'exad_woo_my_account_table_btn_padding',
            [
                'label'      => esc_html__('Padding', 'exclusive-addons-elementor-pro'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .exad-my-account-wrapper .woocommerce table tbody tr td a.button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->add_responsive_control(
			'exad_woo_my_account_table_btn_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'exclusive-addons-elementor-pro' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px'],
				'selectors'  => [
					'{{WRAPPER}} .exad-my-account-wrapper .woocommerce table tbody tr td a.button'=> 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
		);

        $this->start_controls_tabs( 'exad_woo_my_account_table_btn_tabs' );

		$this->start_controls_tab( 'normal', [ 'label' => esc_html__( 'Normal', 'exclusive-addons-elementor-pro' ) ] );

		$this->add_control(
			'exad_woo_my_account_table_btn_text_color',
			[
				'label'		=> esc_html__( 'Text Color', 'exclusive-addons-elementor-pro' ),
				'type'		=> Controls_Manager::COLOR,
				'default'	=> $exad_primary_color,
				'selectors'	=> [
					'{{WRAPPER}} .exad-my-account-wrapper .woocommerce table tbody tr td a.button'  => 'color: {{VALUE}};'
				]
			]
		);

        $this->add_control(
            'exad_woo_my_account_table_btn_background',
            [
                'label'     => esc_html__('Background Color', 'exclusive-addons-elementor-pro'),
                'type'      => Controls_Manager::COLOR,
                'default'	=> '#f7f7f7',
                'selectors' => [
                    '{{WRAPPER}} .exad-my-account-wrapper .woocommerce table tbody tr td a.button'      => 'background: {{VALUE}};'
                ]
            ]
        );

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'            => 'exad_woo_my_account_table_btn_border',
				'fields_options'  => [
                    'border' 	  => [
                        'default' => 'solid'
                    ],
                    'width'  	  => [
                        'default' 	 => [
                            'top'    => '1',
                            'right'  => '1',
                            'bottom' => '1',
                            'left'   => '1'
                        ]
                    ],
                    'color' 	  => [
                        'default' => $exad_primary_color
                    ]
                ],
				'selector'        => '{{WRAPPER}} .exad-my-account-wrapper .woocommerce table tbody tr td a.button'
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'exad_woo_my_account_table_btn_shadow',
				'selector' => '{{WRAPPER}} .exad-my-account-wrapper .woocommerce table tbody tr td a.button'
			]
		);

		$this->end_controls_tab();
		
		$this->start_controls_tab( 'exad_woo_my_account_table_btn_hover', [ 'label' => esc_html__( 'Hover', 'exclusive-addons-elementor-pro' ) ] );

		$this->add_control(
			'exad_woo_my_account_table_btn_hover_text_color',
			[
				'label'     => esc_html__( 'Text Color', 'exclusive-addons-elementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => $exad_primary_color,
				'selectors' => [
					'{{WRAPPER}} .exad-my-account-wrapper .woocommerce table tbody tr td a.button:hover' => 'color: {{VALUE}};'
				]
			]
		);

        $this->add_control(
            'exad_woo_my_account_table_btn_hover_background',
            [
                'label'     => esc_html__('Background Color', 'exclusive-addons-elementor-pro'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .exad-my-account-wrapper .woocommerce table tbody tr td a.button:hover'      => 'background: {{VALUE}};'
                ]
            ]
        );

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'            => 'exad_woo_my_account_table_btn_border_hover',
				'selector'        => '{{WRAPPER}} .exad-my-account-wrapper .woocommerce table tbody tr td a.button:hover'
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'exad_woo_my_account_table_btn_box_shadow_hover',
				'selector' => '{{WRAPPER}} .exad-my-account-wrapper .woocommerce table tbody tr td a.button:hover'
			]
		);
		
		$this->end_controls_tab();
		
		$this->end_controls_tabs();	

        $this->end_controls_section();

         /**
         * -------------------------------------------
         * Tab Style Form Style
         * -------------------------------------------
         */ 
        $this->start_controls_section(
            'exad_section_woo_my_account_form_style',
            [
                'label' => esc_html__('Form', 'exclusive-addons-elementor-pro'),
                'tab'   => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_control(
            'exad_woo_my_account_form_container_style',
            [
                'label' => esc_html__('Form Container', 'exclusive-addons-elementor-pro'),
                'type'  => Controls_Manager::HEADING
            ]
        );

        $this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'exad_woo_my_account_form_container_background',
				'types'    => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .exad-my-account-wrapper .woocommerce .woocommerce-MyAccount-content form, {{WRAPPER}}  .exad-my-account-wrapper .woocommerce .u-columns'
			]
		);

        $this->add_responsive_control(
			'exad_woo_my_account_form_container_margin',
			[
				'label'      => __( 'Margin', 'exclusive-addons-elementor-pro' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'default'    => [
					'top'    => '10',
					'right'  => '10',
					'bottom' => '10',
					'left'   => '10'
				],
				'selectors'  => [
					'{{WRAPPER}} .exad-my-account-wrapper .woocommerce .woocommerce-MyAccount-content form, {{WRAPPER}}  .exad-my-account-wrapper .woocommerce .u-columns' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
		);

        $this->add_responsive_control(
			'exad_woo_my_account_form_container_padding',
			[
				'label'      => __( 'Padding', 'exclusive-addons-elementor-pro' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'default'    => [
					'top'    => '20',
					'right'  => '20',
					'bottom' => '20',
					'left'   => '20'
				],
				'selectors'  => [
					'{{WRAPPER}} .exad-my-account-wrapper .woocommerce .woocommerce-MyAccount-content form, {{WRAPPER}}  .exad-my-account-wrapper .woocommerce .u-columns' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
		);

        $this->add_responsive_control(
			'exad_woo_my_account_form_container_radius',
			[
				'label'      => __( 'Border radius', 'exclusive-addons-elementor-pro' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'separator'  => 'after',
				'default'    => [
					'top'    => '10',
					'right'  => '10',
					'bottom' => '10',
					'left'   => '10'
				],
				'selectors'  => [
					'{{WRAPPER}} .exad-my-account-wrapper .woocommerce .woocommerce-MyAccount-content form, {{WRAPPER}}  .exad-my-account-wrapper .woocommerce .u-columns' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
		);

        $this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'            => 'exad_woo_my_account_form_container_border',
				'fields_options'  => [
                    'border'      => [
                        'default' => 'solid'
                    ],
                    'width'          => [
                        'default'    => [
							'top'    => '1',
							'right'  => '1',
							'bottom' => '1',
							'left'   => '1'
                        ]
                    ],
                    'color'       => [
                        'default' => '#e3e3e3'
                    ]
				],
				'selector'        => '{{WRAPPER}} .exad-my-account-wrapper .woocommerce .woocommerce-MyAccount-content form, {{WRAPPER}}  .exad-my-account-wrapper .woocommerce .u-columns'
			]
		);

        $this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'exad_woo_my_account_form_container_box_shadow',
				'selector' => '{{WRAPPER}} .exad-my-account-wrapper .woocommerce .woocommerce-MyAccount-content form, {{WRAPPER}}  .exad-my-account-wrapper .woocommerce .u-columns'
			]
		);

        $this->add_control(
            'exad_woo_my_account_form_heading_style',
            [
                'label'     => esc_html__('Headings', 'exclusive-addons-elementor-pro'),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );
        
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'exad_woo_my_account_form_heading_typography',
                'selector' => ' {{WRAPPER}} .exad-my-account-wrapper .woocommerce h2, {{WRAPPER}} .exad-my-account-wrapper .woocommerce h3',
                'fields_options'     => [
                    'text_transform' => [
                        'default'    => 'capitalize'
                    ]
                ]
            ]
        );

        $this->add_control(
            'exad_woo_my_account_form_heading_color',
            [
                'label'     => esc_html__('Heading Color', 'exclusive-addons-elementor-pro'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#444444',
                'selectors' => [
                    '{{WRAPPER}} .exad-my-account-wrapper .woocommerce h2, {{WRAPPER}} .exad-my-account-wrapper .woocommerce h3' => 'color: {{VALUE}};'
                ]
            ]
        );

        $this->add_control(
			'exad_woo_my_account_form_heading_alignment',
			[
				'label'   => __( 'Alignment', 'exclusive-addons-elementor-pro' ),
				'type'    => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title'  => __( 'Left', 'exclusive-addons-elementor-pro' ),
						'icon'   => 'eicon-text-align-left'
					],
					'center'     => [
						'title'  => __( 'Center', 'exclusive-addons-elementor-pro' ),
						'icon'   => 'eicon-text-align-center'
					],
					'right'   => [
						'title'  => __( 'Right', 'exclusive-addons-elementor-pro' ),
						'icon'   => 'eicon-text-align-right'
					]
				],
				'default' => 'left',
				'selectors' => [
					'{{WRAPPER}} .exad-my-account-wrapper .woocommerce h2, {{WRAPPER}} .exad-my-account-wrapper .woocommerce h3' => 'text-align: {{VALUE}};'
				]
			]
		);

        $this->add_responsive_control(
            'exad_woo_my_account_form_heading_margin',
            [
                'label'        => esc_html__('Margin', 'exclusive-addons-elementor-pro'),
                'type'         => Controls_Manager::DIMENSIONS,
                'size_units'   => ['px', 'em', '%'],
                'default'      => [
                    'top'      => '0',
                    'right'    => '0',
                    'bottom'   => '30',
                    'left'     => '0',
                    'unit'     => 'px',
                    'isLinked' => false
                ],
                'selectors'    => [
                    '{{WRAPPER}} .exad-my-account-wrapper .woocommerce h2, {{WRAPPER}} .exad-my-account-wrapper .woocommerce h3' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->add_control(
            'exad_woo_my_account_form_label_style',
            [
                'label'     => esc_html__('Label', 'exclusive-addons-elementor-pro'),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'exad_woo_my_account_form_label_typography',
                'selector' => ' {{WRAPPER}} .exad-my-account-wrapper .woocommerce form .form-row label, {{WRAPPER}} .exad-my-account-wrapper .woocommerce form fieldset legend,
                {{WRAPPER}} .exad-my-account-wrapper .woocommerce form span em',
                'fields_options'     => [
                    'text_transform' => [
                        'default'    => 'capitalize'
                    ]
                ]
            ]
        );

        $this->add_control(
            'exad_woo_my_account_form_label_color',
            [
                'label'     => esc_html__('Label Color', 'exclusive-addons-elementor-pro'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#444444',
                'selectors' => [
                    '{{WRAPPER}} .exad-my-account-wrapper .woocommerce form .form-row label, {{WRAPPER}} .exad-my-account-wrapper .woocommerce form fieldset legend,
                    {{WRAPPER}} .exad-my-account-wrapper .woocommerce form span em' => 'color: {{VALUE}};'
                ]
            ]
        );

        $this->add_responsive_control(
            'exad_woo_my_account_form_label_bottom_spacing',
            [
                'label'        => esc_html__( 'Label Bottom Spacing', 'exclusive-addons-elementor-pro' ),
                'type'         => Controls_Manager::SLIDER,
                'range'        => [
                    'px'       => [
                        'min'  => 0,
                        'max'  => 100,
                        'step' => 1
                    ]
                ],
                'selectors'    => [
                    '{{WRAPPER}} .exad-my-account-wrapper .woocommerce form .form-row label' => 'margin-bottom: {{SIZE}}px;'
                ]
            ]
        );

        $this->add_control(
            'exad_woo_my_account_form_input_style',
            [
                'label'     => esc_html__('Input', 'exclusive-addons-elementor-pro'),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'exad_woo_my_account_form_input_field_typography',
                'selector' => '{{WRAPPER}} .exad-my-account-wrapper .woocommerce form .form-row input[type="text"],
                        {{WRAPPER}} .exad-my-account-wrapper .woocommerce form .form-row input[type="email"],
                        {{WRAPPER}} .exad-my-account-wrapper .woocommerce form .form-row input[type="url"],
                        {{WRAPPER}} .exad-my-account-wrapper .woocommerce form .form-row input[type="password"],
                        {{WRAPPER}} .exad-my-account-wrapper .woocommerce form .form-row input[type="search"],
                        {{WRAPPER}} .exad-my-account-wrapper .woocommerce form .form-row input[type="number"],
                        {{WRAPPER}} .exad-my-account-wrapper .woocommerce form .form-row input[type="tel"],
                        {{WRAPPER}} .exad-my-account-wrapper .woocommerce form .form-row input[type="range"],
                        {{WRAPPER}} .exad-my-account-wrapper .woocommerce form .form-row input[type="date"],
                        {{WRAPPER}} .exad-my-account-wrapper .woocommerce form .form-row input[type="month"],
                        {{WRAPPER}} .exad-my-account-wrapper .woocommerce form .form-row input[type="week"],
                        {{WRAPPER}} .exad-my-account-wrapper .woocommerce form .form-row input[type="time"],
                        {{WRAPPER}} .exad-my-account-wrapper .woocommerce form .form-row input[type="datetime"],
                        {{WRAPPER}} .exad-my-account-wrapper .woocommerce form .form-row input[type="datetime-local"],
                        {{WRAPPER}} .exad-my-account-wrapper .woocommerce form .form-row input[type="color"],
                        {{WRAPPER}} .exad-my-account-wrapper .woocommerce form .form-row .select2-selection__placeholder,
                        {{WRAPPER}} .exad-my-account-wrapper .woocommerce form .form-row textarea'
            ]
        );
        
        $this->add_control(
            'exad_woo_my_account_form_input_field_text_color',
            [
                'label'     => __( 'Text Color', 'exclusive-addons-elementor-pro' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .exad-my-account-wrapper .woocommerce form .form-row input, {{WRAPPER}} .exad-my-account-wrapper .woocommerce form .form-row textarea, {{WRAPPER}} .exad-my-account-wrapper .woocommerce form .form-row .select2-selection__placeholder' => 'color: {{VALUE}}'
                ]
            ]
        );

        $this->add_control(
            'exad_woo_my_account_form_input_field_placeholder_color',
            [
                'label'     => __( 'Placeholder Text Color', 'exclusive-addons-elementor-pro' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .exad-my-account-wrapper .woocommerce form .form-row input[type="text"]::placeholder,
                        {{WRAPPER}} .exad-my-account-wrapper .woocommerce form .form-row input[type="email"]::placeholder,
                        {{WRAPPER}} .exad-my-account-wrapper .woocommerce form .form-row input[type="url"]::placeholder,
                        {{WRAPPER}} .exad-my-account-wrapper .woocommerce form .form-row input[type="password"]::placeholder,
                        {{WRAPPER}} .exad-my-account-wrapper .woocommerce form .form-row input[type="search"]::placeholder,
                        {{WRAPPER}} .exad-my-account-wrapper .woocommerce form .form-row input[type="number"]::placeholder,
                        {{WRAPPER}} .exad-my-account-wrapper .woocommerce form .form-row input[type="tel"]::placeholder,
                        {{WRAPPER}} .exad-my-account-wrapper .woocommerce form .form-row input[type="range"]::placeholder,
                        {{WRAPPER}} .exad-my-account-wrapper .woocommerce form .form-row input[type="date"]::placeholder,
                        {{WRAPPER}} .exad-my-account-wrapper .woocommerce form .form-row input[type="month"]::placeholder,
                        {{WRAPPER}} .exad-my-account-wrapper .woocommerce form .form-row input[type="week"]::placeholder,
                        {{WRAPPER}} .exad-my-account-wrapper .woocommerce form .form-row input[type="time"]::placeholder,
                        {{WRAPPER}} .exad-my-account-wrapper .woocommerce form .form-row input[type="datetime"]::placeholder,
                        {{WRAPPER}} .exad-my-account-wrapper .woocommerce form .form-row input[type="datetime-local"]::placeholder,
                        {{WRAPPER}} .exad-my-account-wrapper .woocommerce form .form-row input[type="color"]::placeholder,
                        {{WRAPPER}} .exad-my-account-wrapper .woocommerce form .form-row select,
                        {{WRAPPER}} .exad-my-account-wrapper .woocommerce form .form-row textarea::placeholder' => 'color: {{VALUE}};'
                ]
            ]
        );
  
        $this->add_control(
            'exad_woo_my_account_form_input_field_bg',
            [
                'label'     => __( 'Background Color', 'exclusive-addons-elementor-pro' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .exad-my-account-wrapper .woocommerce form .form-row input, {{WRAPPER}} .exad-my-account-wrapper .woocommerce form .form-row textarea, {{WRAPPER}} .exad-my-account-wrapper .woocommerce form .form-row select, {{WRAPPER}} .exad-my-account-wrapper .woocommerce form .form-row .select2-selection--single' => 'background-color: {{VALUE}}'
                ]
            ]
        );

        $this->add_responsive_control(
            'exad_woo_my_account_form_input_field_margin',
            [
                'label'      => __( 'Margin', 'exclusive-addons-elementor-pro' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} .exad-my-account-wrapper .woocommerce form .form-row input:not([type=checkbox]), {{WRAPPER}} .exad-my-account-wrapper .woocommerce form .form-row textarea, {{WRAPPER}} .exad-my-account-wrapper .woocommerce form .form-row .select2-container, {{WRAPPER}} .exad-my-account-wrapper .woocommerce form .form-row .select2-container .select2-selection--single, {{WRAPPER}} .exad-my-account-wrapper .woocommerce form .form-row select' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
                'default'    => [
                    'top'    => 10,
                    'right'  => 0,
                    'bottom' => 0,
                    'left'   => 0,
                    'unit'   => 'px'
                ]
            ]
        );

        $this->add_responsive_control(
			'exad_woo_my_account_form_input_field_padding',
			[
                'label'      => __( 'Padding', 'exclusive-addons-elementor-pro' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'default'    => [
                    'unit'   => 'px',
					'size'   => 15
                ],
				'selectors'  => [
					'{{WRAPPER}} .exad-my-account-wrapper .woocommerce form .form-row input:not([type=checkbox]), {{WRAPPER}} .exad-my-account-wrapper .woocommerce form .form-row textarea, {{WRAPPER}} .exad-my-account-wrapper .woocommerce form .form-row .select2-selection__rendered, {{WRAPPER}} .exad-my-account-wrapper .woocommerce form .form-row .select2-container .select2-selection--single, {{WRAPPER}} .exad-my-account-wrapper .woocommerce form .form-row select' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
        );

        $this->add_responsive_control(
            'exad_woo_my_account_form_input_field_height',
            [
                'label'        => esc_html__( 'Input Field Height', 'exclusive-addons-elementor-pro' ),
                'type'         => Controls_Manager::SLIDER,
                'range'        => [
                    'px'       => [
                        'min'  => 0,
                        'max'  => 150,
                        'step' => 1
                    ]
                ],
                'default'      => [
                    'unit'     => 'px',
                    'size'     => 40
                ],
                'selectors'    => [
                    '{{WRAPPER}} .exad-my-account-wrapper .woocommerce form .form-row input[type="text"],
                    {{WRAPPER}} .exad-my-account-wrapper .woocommerce form .form-row input[type="email"],
                    {{WRAPPER}} .exad-my-account-wrapper .woocommerce form .form-row input[type="url"],
                    {{WRAPPER}} .exad-my-account-wrapper .woocommerce form .form-row input[type="password"],
                    {{WRAPPER}} .exad-my-account-wrapper .woocommerce form .form-row input[type="search"],
                    {{WRAPPER}} .exad-my-account-wrapper .woocommerce form .form-row input[type="number"],
                    {{WRAPPER}} .exad-my-account-wrapper .woocommerce form .form-row input[type="tel"],
                    {{WRAPPER}} .exad-my-account-wrapper .woocommerce form .form-row input[type="range"],
                    {{WRAPPER}} .exad-my-account-wrapper .woocommerce form .form-row input[type="date"],
                    {{WRAPPER}} .exad-my-account-wrapper .woocommerce form .form-row input[type="month"],
                    {{WRAPPER}} .exad-my-account-wrapper .woocommerce form .form-row input[type="week"],
                    {{WRAPPER}} .exad-my-account-wrapper .woocommerce form .form-row input[type="time"],
                    {{WRAPPER}} .exad-my-account-wrapper .woocommerce form .form-row input[type="datetime"],
                    {{WRAPPER}} .exad-my-account-wrapper .woocommerce form .form-row input[type="datetime-local"],
                    {{WRAPPER}} .exad-my-account-wrapper .woocommerce form .form-row input[type="color"],
                    {{WRAPPER}} .exad-my-account-wrapper .woocommerce form .form-row input:not([type=checkbox]),
                    {{WRAPPER}} .exad-my-account-wrapper .woocommerce form .form-row .select2-container .select2-selection--single,
                    {{WRAPPER}} .exad-my-account-wrapper .woocommerce form .form-row select' => 'height: {{SIZE}}px;'
                ]
            ]
        );

        $this->add_responsive_control(
            'exad_woo_my_account_form_input_field_width',
            [
                'label'         => __( 'Field Width', 'exclusive-addons-elementor-pro' ),
                'type'          => Controls_Manager::SLIDER,
                'range'         => [
                    'px'        => [
                        'min'   => 0,
                        'max'   => 1200,
                        'step'  => 1
                    ]
                ],
                'size_units'    => [ 'px', 'em', '%' ],
                'default'       => [
                    'unit'      => '%',
					'size'      => 100
                ],
                'selectors'     => [
                    '{{WRAPPER}} .exad-my-account-wrapper .woocommerce form .form-row input:not([type=checkbox]), {{WRAPPER}} .exad-my-account-wrapper .woocommerce form .form-row textarea, {{WRAPPER}} .exad-my-account-wrapper .woocommerce form .form-row select' => 'width: {{SIZE}}{{UNIT}}'
                ]
            ]
        );

        $this->add_responsive_control(
            'exad_woo_my_account_form_input_field_bottom_spacing',
            [
                'label'        => esc_html__( 'Field Bottom Spacing', 'exclusive-addons-elementor-pro' ),
                'type'         => Controls_Manager::SLIDER,
                'range'        => [
                    'px'       => [
                        'min'  => 0,
                        'max'  => 100,
                        'step' => 1
                    ]
                ],
                'selectors'    => [
                    '{{WRAPPER}} .exad-my-account-wrapper .woocommerce form .form-row' => 'margin-bottom: {{SIZE}}px;'
                ]
            ]
        );

        $this->add_group_control(
			Group_Control_Border::get_type(),
			[
                'name'        => 'exad_woo_my_account_form_input_field_border',
                'selector'    => '{{WRAPPER}} .exad-my-account-wrapper .woocommerce form .form-row input:not([type=checkbox]), {{WRAPPER}} .exad-my-account-wrapper .woocommerce form .form-row textarea, {{WRAPPER}} .exad-my-account-wrapper .woocommerce form .form-row select, {{WRAPPER}} .exad-my-account-wrapper .woocommerce form .form-row .select2-container .select2-selection--single'
			]
		);

		$this->add_responsive_control(
			'exad_woo_my_account_form_input_field_radius',
			[
                'label'      => __( 'Border Radius', 'exclusive-addons-elementor-pro' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors'  => [
					'{{WRAPPER}} .exad-my-account-wrapper .woocommerce form .form-row input:not([type=checkbox]), {{WRAPPER}} .exad-my-account-wrapper .woocommerce form .form-row textarea, {{WRAPPER}} .exad-my-account-wrapper .woocommerce form .form-row select, {{WRAPPER}} .exad-my-account-wrapper .woocommerce form .form-row .select2-container .select2-selection--single' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
        );

        $this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'exad_woo_my_account_form_input_field_box_shadow',
				'selector' => '{{WRAPPER}} .exad-my-account-wrapper .woocommerce form .form-row input:not([type=checkbox]), {{WRAPPER}} .exad-my-account-wrapper .woocommerce form .form-row textarea, {{WRAPPER}} .exad-my-account-wrapper .woocommerce form .form-row select, {{WRAPPER}} .exad-my-account-wrapper .woocommerce form .form-row .select2-container .select2-selection--single'
			]
		);

        $this->add_control(
            'exad_woo_my_account_form_btn_style',
            [
                'label'     => esc_html__('Form Button', 'exclusive-addons-elementor-pro'),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_responsive_control(
			'exad_woo_my_account_form_btn_alignment',
			[
				'label' => __( 'Alignment', 'exclusive-addons-elementor-pro' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left'   => [
						'title' => __( 'Left', 'exclusive-addons-elementor-pro' ),
						'icon'  => 'eicon-text-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'exclusive-addons-elementor-pro' ),
						'icon'  => 'eicon-text-align-center',
					],
					'right' => [
						'title' => __( 'Right', 'exclusive-addons-elementor-pro' ),
						'icon'  => 'eicon-text-align-right',
					],
					'justify' => [
						'title' => __( 'Justified', 'exclusive-addons-elementor-pro' ),
						'icon'  => 'eicon-text-align-justify',
					],
				],
                'desktop_default' => 'left',
				'tablet_default'  => 'center',
				'mobile_default'  => 'center',
				'selectors_dictionary' => [
					'left'      => 'display: flex; margin-right: auto;',
					'center'    => 'display: flex; margin-left: auto; margin-right: auto;',
					'right'     => 'display: flex; margin-left: auto;',
					'justify'   => 'width: 100%; justify-content: center;',
				],
				'selectors'     => [
                    '{{WRAPPER}} .exad-my-account-wrapper .woocommerce form button[type=submit]' => '{{VALUE}};'
                ]
			]
		);

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'exad_woo_my_account_form_btn_typography',
                'label'    => __( 'Button Typography', 'exclusive-addons-elementor-pro' ),
                'selector' => '{{WRAPPER}} .exad-my-account-wrapper .woocommerce form button[type=submit]'
            ]
        );

        $this->add_responsive_control(
            'exad_woo_my_account_form_btn_border_radius',
            [
                'label'      => __( 'Border Radius', 'exclusive-addons-elementor-pro' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} .exad-my-account-wrapper .woocommerce form button[type=submit]' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
                'default'    => [
                    'top'    => 0,
                    'right'  => 0,
                    'bottom' => 0,
                    'left'   => 0,
                    'unit'   => 'px'
                ]
            ]
        );

        $this->add_responsive_control(
            'exad_woo_my_account_form_btn_padding',
            [
                'label'      => __( 'Padding', 'exclusive-addons-elementor-pro' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} .exad-my-account-wrapper .woocommerce form button[type=submit]' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
                'default'      => [
                    'top'      => 15,
                    'right'    => 25,
                    'bottom'   => 15,
                    'left'     => 25,
                    'unit'     => 'px',
                    'isLinked' => false
                ]
            ]
        );

        $this->add_responsive_control(
            'exad_woo_my_account_form_btn_spacing',
            [
                'label'         => __( 'Top Spacing', 'exclusive-addons-elementor-pro' ),
                'type'          => Controls_Manager::SLIDER,
                'range'         => [
                    'px'        => [
                        'min'   => 0,
                        'max'   => 100,
                        'step'  => 1
                    ]
                ],
                'size_units'    => [ 'px' ],
                'default'       => [
                    'unit'      => 'px',
					'size'      => 10
                ],
                'selectors'     => [
                    '{{WRAPPER}} .exad-my-account-wrapper .woocommerce form button[type=submit]' => 'margin-top: {{SIZE}}{{UNIT}};'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'           => 'exad_woo_my_account_form_btn_shadow',
                'selector'       => '{{WRAPPER}} .exad-my-account-wrapper .woocommerce form button[type=submit]',
                'fields_options' => [
                    'box_shadow_type' => [ 
                        'default'     =>'yes' 
                    ],
                    'box_shadow'  => [
                        'default' => [
                            'horizontal' => 0,
                            'vertical'   => 13,
                            'blur'       => 33,
                            'spread'     => 0,
                            'color'      => 'rgba(51, 77, 128, 0.2)'
                        ]
                    ]
                ]
            ]
        );

        $this->start_controls_tabs( 'exad_woo_my_account_form_btn_tabs_style' );

        $this->start_controls_tab(
            'exad_woo_my_account_form_btn_tab_normal',
            [
                'label' => __( 'Normal', 'exclusive-addons-elementor-pro' )
            ]
        );

        $this->add_control(
            'exad_woo_my_account_form_btn_text_color_normal',
            [
                'label'     => __( 'Text Color', 'exclusive-addons-elementor-pro' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .exad-my-account-wrapper .woocommerce form button[type=submit]' => 'color: {{VALUE}}'
                ]
            ]
        );

        $this->add_control(
            'exad_woo_my_account_form_btn_bg_color_normal',
            [
                'label'     => __( 'Background Color', 'exclusive-addons-elementor-pro' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => $exad_primary_color,
                'selectors' => [
                    '{{WRAPPER}} .exad-my-account-wrapper .woocommerce form button[type=submit]' => 'background-color: {{VALUE}}'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'               => 'exad_woo_my_account_form_btn_border',
                'fields_options'     => [
                    'border'         => [
                        'default'    => 'solid'
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
                ],
                'selector'           => '{{WRAPPER}} .exad-my-account-wrapper .woocommerce form button[type=submit]'
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'           => 'exad_woo_my_account_form_btn_box_shadow_normal',
                'label'          => __( 'Box Shadow', 'exclusive-addons-elementor-pro' ),
                'selector'       => '{{WRAPPER}} .exad-my-account-wrapper .woocommerce form button[type=submit]',
                'fields_options' => [
                    'box_shadow_type' => [ 
                        'default'     =>'yes' 
                    ],
                    'box_shadow'  => [
                        'default' => [
                            'horizontal' => 0,
                            'vertical'   => 13,
                            'blur'       => 33,
                            'spread'     => 0,
                            'color'      => 'rgba(51, 77, 128, 0.2)'
                        ]
                    ]
                ]
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'exad_woo_my_account_form_btn_tab_hover',
            [
                'label'  => __( 'Hover', 'exclusive-addons-elementor-pro' )
            ]
        );

        $this->add_control(
            'exad_woo_my_account_form_btn_text_color_hover',
            [
                'label'     => __( 'Text Color', 'exclusive-addons-elementor-pro' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => $exad_primary_color,
                'selectors' => [
                    '{{WRAPPER}} .exad-my-account-wrapper .woocommerce form button[type=submit]:hover' => 'color: {{VALUE}}'
                ]
            ]
        );

        $this->add_control(
            'exad_woo_my_account_form_btn_bg_color_hover',
            [
                'label'     => __( 'Background Color', 'exclusive-addons-elementor-pro' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .exad-my-account-wrapper .woocommerce form button[type=submit]:hover' => 'background-color: {{VALUE}}'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'exad_woo_my_account_form_btn_border_hover',
                'selector' => '{{WRAPPER}} .exad-my-account-wrapper .woocommerce form button[type=submit]:hover'
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'      => 'exad_woo_my_account_form_btn_box_shadow_hover',
                'label'     => __( 'Box Shadow', 'exclusive-addons-elementor-pro' ),
                'selector'  => '{{WRAPPER}} .exad-my-account-wrapper .woocommerce form button[type=submit]:hover'
            ]
        );
        
        $this->end_controls_tab();
        
        $this->end_controls_tabs();

        $this->end_controls_section();

         /**
         * -------------------------------------------
         * Tab Style Notices
         * -------------------------------------------
         */ 

        $this->start_controls_section(
            'exad_section_woo_my_account_notice_style_settings',
            [
                'label' => esc_html__('General \ Notices', 'exclusive-addons-elementor-pro'),
                'tab'   => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_control(
            'exad_woo_my_account_notice_general_heading_style',
            [
                'label'     => esc_html__('General Notice', 'exclusive-addons-elementor-pro'),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before'
            ]
        );

        $this->add_control(
            'exad_woo_my_account_notice_general_btn_heading_style',
            [
                'label'     => esc_html__('General Button', 'exclusive-addons-elementor-pro'),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before'
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'exad_woo_my_account_notice_general_btn_typography',
                'label'    => __( 'Button Typography', 'exclusive-addons-elementor-pro' ),
                'selector' => '{{WRAPPER}} .exad-my-account-wrapper .woocommerce a.button'
            ]
        );

        $this->add_responsive_control(
            'exad_woo_my_account_notice_general_btn_border_radius',
            [
                'label'      => __( 'Border Radius', 'exclusive-addons-elementor-pro' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} .exad-my-account-wrapper .woocommerce a.button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->add_responsive_control(
            'exad_woo_my_account_notice_general_btn_padding',
            [
                'label'      => __( 'Padding', 'exclusive-addons-elementor-pro' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} .exad-my-account-wrapper .woocommerce a.button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'           => 'exad_woo_my_account_notice_general_btn_shadow',
                'selector'       => '{{WRAPPER}} .exad-my-account-wrapper .woocommerce a.button',
                'fields_options' => [
                    'box_shadow_type' => [ 
                        'default'     =>'yes' 
                    ],
                    'box_shadow'  => [
                        'default' => [
                            'horizontal' => 0,
                            'vertical'   => 13,
                            'blur'       => 33,
                            'spread'     => 0,
                            'color'      => 'rgba(51, 77, 128, 0.2)'
                        ]
                    ]
                ]
            ]
        );

        $this->start_controls_tabs( 'exad_woo_my_account_notice_general_btn_tabs_style' );

        $this->start_controls_tab(
            'exad_woo_my_account_notice_general_btn_tab_normal',
            [
                'label' => __( 'Normal', 'exclusive-addons-elementor-pro' )
            ]
        );

        $this->add_control(
            'exad_woo_my_account_notice_general_btn_text_color_normal',
            [
                'label'     => __( 'Text Color', 'exclusive-addons-elementor-pro' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .exad-my-account-wrapper .woocommerce a.button' => 'color: {{VALUE}}'
                ]
            ]
        );

        $this->add_control(
            'exad_woo_my_account_notice_general_btn_bg_color_normal',
            [
                'label'     => __( 'Background Color', 'exclusive-addons-elementor-pro' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => $exad_primary_color,
                'selectors' => [
                    '{{WRAPPER}} .exad-my-account-wrapper .woocommerce a.button' => 'background-color: {{VALUE}}'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'               => 'exad_woo_my_account_notice_general_btn_border',
                'fields_options'     => [
                    'border'         => [
                        'default'    => 'solid'
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
                ],
                'selector'           => '{{WRAPPER}} .exad-my-account-wrapper .woocommerce a.button'
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'           => 'exad_woo_my_account_notice_general_btn_box_shadow_normal',
                'label'          => __( 'Box Shadow', 'exclusive-addons-elementor-pro' ),
                'selector'       => '{{WRAPPER}} .exad-my-account-wrapper .woocommerce a.button',
                'fields_options' => [
                    'box_shadow_type' => [ 
                        'default'     =>'yes' 
                    ],
                    'box_shadow'  => [
                        'default' => [
                            'horizontal' => 0,
                            'vertical'   => 13,
                            'blur'       => 33,
                            'spread'     => 0,
                            'color'      => 'rgba(51, 77, 128, 0.2)'
                        ]
                    ]
                ]
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'exad_woo_my_account_notice_general_btn_tab_hover',
            [
                'label'  => __( 'Hover', 'exclusive-addons-elementor-pro' )
            ]
        );

        $this->add_control(
            'exad_woo_my_account_notice_general_btn_text_color_hover',
            [
                'label'     => __( 'Text Color', 'exclusive-addons-elementor-pro' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => $exad_primary_color,
                'selectors' => [
                    '{{WRAPPER}} .exad-my-account-wrapper .woocommerce a.button:hover' => 'color: {{VALUE}}'
                ]
            ]
        );

        $this->add_control(
            'exad_woo_my_account_notice_general_btn_bg_color_hover',
            [
                'label'     => __( 'Background Color', 'exclusive-addons-elementor-pro' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .exad-my-account-wrapper .woocommerce a.button:hover' => 'background-color: {{VALUE}}'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'exad_woo_my_account_notice_general_btn_border_hover',
                'selector' => '{{WRAPPER}} .exad-my-account-wrapper .woocommerce a.button:hover'
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'      => 'exad_woo_my_account_notice_general_btn_box_shadow_hover',
                'label'     => __( 'Box Shadow', 'exclusive-addons-elementor-pro' ),
                'selector'  => '{{WRAPPER}} .exad-my-account-wrapper .woocommerce a.button:hover'
            ]
        );
        
        $this->end_controls_tab();
        
        $this->end_controls_tabs();

        $this->add_control(
            'exad_woo_my_account_notice_heading_style',
            [
                'label'     => esc_html__('Notice \ Error', 'exclusive-addons-elementor-pro'),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before'
            ]
        );


        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'exad_woo_my_account_notice_error_typography',
                'label'    => __( 'Error Typography', 'exclusive-addons-elementor-pro' ),
                'selector' => ' {{WRAPPER}} .exad-my-account-wrapper .woocommerce .woocommerce-error',
                'fields_options'     => [
                    'text_transform' => [
                        'default'    => 'capitalize'
                    ]
                ]
            ]
        );

        $this->add_control(
            'exad_woo_my_account_notice_error_color_style',
            [
                'label'     => esc_html__('Message Color', 'exclusive-addons-elementor-pro'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#444444',
                'selectors' => [
                    '{{WRAPPER}} .exad-my-account-wrapper .woocommerce .woocommerce-error' => 'color: {{VALUE}};'
                ]
            ]
        );

        $this->add_control(
            'exad_woo_my_account_notice_error_link_color_style',
            [
                'label'     => esc_html__('Icon Color', 'exclusive-addons-elementor-pro'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#444444',
                'selectors' => [
                    '{{WRAPPER}} .exad-my-account-wrapper .woocommerce .woocommerce-error:before' => 'color: {{VALUE}};'
                ]
            ]
        );

        $this->add_control(
            'exad_woo_my_account_notice_error_container_background',
            [
                'label'     => esc_html__('Background Color', 'exclusive-addons-elementor-pro'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .exad-my-account-wrapper .woocommerce .woocommerce-error' => 'background: {{VALUE}};'
                ]
            ]
        );

        $this->add_control(
            'exad_woo_my_account_notice_error_container_border_top_color',
            [
                'label'     => esc_html__('Border Color', 'exclusive-addons-elementor-pro'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .exad-my-account-wrapper .woocommerce .woocommerce-error' => 'border-top-color: {{VALUE}};'
                ]
            ]
        );

        $this->add_responsive_control(
			'exad_woo_my_account_notice_error_container_margin',
			[
				'label'      => __( 'Margin', 'exclusive-addons-elementor-pro' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .exad-my-account-wrapper .woocommerce .woocommerce-error' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
		);

        $this->add_responsive_control(
			'exad_woo_my_account_notice_error_container_padding',
			[
				'label'      => __( 'Padding', 'exclusive-addons-elementor-pro' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .exad-my-account-wrapper .woocommerce .woocommerce-error' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
		);

        $this->add_responsive_control(
			'exad_woo_my_account_notice_error_container_radius',
			[
				'label'      => __( 'Border radius', 'exclusive-addons-elementor-pro' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'separator'  => 'after',
				'selectors'  => [
					'{{WRAPPER}} .exad-my-account-wrapper .woocommerce .woocommerce-error' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
		);

        $this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'            => 'exad_woo_my_account_notice_error_container_border',
				'fields_options'  => [
                    'border'      => [
                        'default' => 'none'
                    ],
                    'width'          => [
                        'default'    => [
							'top'    => '1',
							'right'  => '1',
							'bottom' => '1',
							'left'   => '1'
                        ]
                    ],
                    'color'       => [
                        'default' => '#e3e3e3'
                    ]
				],
				'selector'        => '{{WRAPPER}} .exad-my-account-wrapper .woocommerce .woocommerce-error'
			]
		);

        $this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'exad_woo_my_account_notice_error_container_box_shadow',
				'selector' => '{{WRAPPER}} .exad-my-account-wrapper .woocommerce .woocommerce-error'
			]
		);



        $this->add_control(
            'exad_woo_my_account_notice_message_heading_style',
            [
                'label'     => esc_html__('Message', 'exclusive-addons-elementor-pro'),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before'
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'exad_woo_my_account_notice_message_typography',
                'label'    => __( 'Message Typography', 'exclusive-addons-elementor-pro' ),
                'selector' => '{{WRAPPER}} .exad-my-account-wrapper .woocommerce .woocommerce-Message, {{WRAPPER}} .exad-my-account-wrapper .woocommerce form p, {{WRAPPER}} .exad-my-account-wrapper .woocommerce .woocommerce-MyAccount-content p',
                'fields_options'     => [
                    'text_transform' => [
                        'default'    => 'capitalize'
                    ]
                ]
            ]
        );

        $this->add_control(
            'exad__woo_my_account_notice_message_color_style',
            [
                'label'     => esc_html__('Message Color', 'exclusive-addons-elementor-pro'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#444444',
                'selectors' => [
                    '{{WRAPPER}} .exad-my-account-wrapper .woocommerce .woocommerce-Message, {{WRAPPER}} .exad-my-account-wrapper .woocommerce form p' => 'color: {{VALUE}};'
                ]
            ]
        );

        $this->add_control(
            'exad__woo_my_account_notice_message_link_color_style',
            [
                'label'     => esc_html__('Icon / Link Color', 'exclusive-addons-elementor-pro'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#444444',
                'selectors' => [
                    '{{WRAPPER}} .exad-my-account-wrapper .woocommerce .woocommerce-Message::before, {{WRAPPER}} .exad-my-account-wrapper .woocommerce form p a' => 'color: {{VALUE}};'
                ]
            ]
        );

        $this->add_control(
            'exad_woo_my_account_notice_message_container_background',
            [
                'label'     => esc_html__('Background Color', 'exclusive-addons-elementor-pro'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .exad-my-account-wrapper .woocommerce .woocommerce-Message' => 'background: {{VALUE}};'
                ]
            ]
        );

        $this->add_control(
            'exad_woo_my_account_notice_message_container_border_top_color',
            [
                'label'     => esc_html__('Border Color', 'exclusive-addons-elementor-pro'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .exad-my-account-wrapper .woocommerce .woocommerce-Message' => 'border-top-color: {{VALUE}};'
                ]
            ]
        );

        $this->add_responsive_control(
			'exad_woo_my_account_notice_message_container_margin',
			[
				'label'      => __( 'Margin', 'exclusive-addons-elementor-pro' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .exad-my-account-wrapper .woocommerce .woocommerce-Message' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
		);

        $this->add_responsive_control(
			'exad_woo_my_account_notice_message_container_padding',
			[
				'label'      => __( 'Padding', 'exclusive-addons-elementor-pro' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .exad-my-account-wrapper .woocommerce .woocommerce-Message' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
		);

        $this->add_responsive_control(
			'exad_woo_my_account_notice_message_container_radius',
			[
				'label'      => __( 'Border radius', 'exclusive-addons-elementor-pro' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'separator'  => 'after',
				'selectors'  => [
					'{{WRAPPER}} .exad-my-account-wrapper .woocommerce .woocommerce-Message' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
		);

        $this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'            => 'exad_woo_my_account_notice_message_container_border',
				'fields_options'  => [
                    'border'      => [
                        'default' => 'none'
                    ],
                    'width'          => [
                        'default'    => [
							'top'    => '1',
							'right'  => '1',
							'bottom' => '1',
							'left'   => '1'
                        ]
                    ],
                    'color'       => [
                        'default' => '#e3e3e3'
                    ]
				],
				'selector'        => '{{WRAPPER}} .exad-my-account-wrapper .woocommerce .woocommerce-Message'
			]
		);

        $this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'exad_woo_my_account_notice_message_container_box_shadow',
				'selector' => '{{WRAPPER}} .exad-my-account-wrapper .woocommerce .woocommerce-Message'
			]
		);

        $this->end_controls_section();

    }

    /**
	 * Customize Navigation.
	 *
	 * Fired by 'woocommerce_account_menu_items' filter.
     * 
	 * @param array $menu_links An array of Navigation key menu_links.
	 *
	 * @return array An array of Navigation key menu_links.
	 */
    public function customize_my_account_navigation( $menu_links ) {

		$settings = $this->get_settings();

        if (! empty( $settings['exad_woo_my_account_navigation_show_dashboard_text'] )){
            $menu_links['dashboard'] = $settings['exad_woo_my_account_navigation_show_dashboard_text'];
        } 
        if (! empty( $settings['exad_woo_my_account_navigation_show_orders_text'] )){
            $menu_links['orders'] = $settings['exad_woo_my_account_navigation_show_orders_text'];
        } 
        if (! empty( $settings['exad_woo_my_account_navigation_show_downloads_text'] )){
            $menu_links['downloads'] = $settings['exad_woo_my_account_navigation_show_downloads_text'];
        } 
        if (! empty( $settings['exad_woo_my_account_navigation_show_addresses_text'] )){
            $menu_links['edit-address'] = $settings['exad_woo_my_account_navigation_show_addresses_text'];
        } 
        if (! empty( $settings['exad_woo_my_account_navigation_show_account_details_text'] )){
            $menu_links['edit-account'] = $settings['exad_woo_my_account_navigation_show_account_details_text'];
        } 
        if (! empty( $settings['exad_woo_my_account_navigation_show_logout_link_text'] )){
            $menu_links['customer-logout'] = $settings['exad_woo_my_account_navigation_show_logout_link_text'];
        }
		if ( 'yes' !== $settings['exad_woo_my_account_navigation_show_dashboard'] ) {
			unset( $menu_links['dashboard'] ); // Remove Dashboard tab
		}
		if ( 'yes' !== $settings['exad_woo_my_account_navigation_show_orders'] ) {
			unset( $menu_links['orders'] ); // Remove Orders tab
		}
		if ( 'yes' !== $settings['exad_woo_my_account_navigation_show_downloads'] ) {
			unset( $menu_links['downloads'] ); // Remove Downloads tab
		}
		if ( 'yes' !== $settings['exad_woo_my_account_navigation_show_addresses'] ) {
			unset( $menu_links['edit-address'] ); // Removed Addresses tab
		}
		if ( 'yes' !== $settings['exad_woo_my_account_navigation_show_account_details'] ) {
			unset( $menu_links['edit-account'] ); // Remove Account details tab
		}
		if ( 'yes' !== $settings['exad_woo_my_account_navigation_show_logout_link'] ) {
			unset( $menu_links['customer-logout'] ); // Remove Logout Link
		}

		return $menu_links;

	}

    private function get_shortcode() {
      
        $shortcode   = [];
		$shortcode = sprintf( '[%s %s]', 'woocommerce_my_account', $this->get_render_attribute_string( 'shortcode' ) );

		return $shortcode;
	}

    protected function render() {
        if( ! class_exists('woocommerce') ) {
	        return;
        }

        $settings = $this->get_settings_for_display();
        $this->add_render_attribute( 
            'exad-woo-my-account-wrapper', 
            [ 
                'class' => [ 'exad-my-account-wrapper' ]
            ]
        );
        ?>
        <?php do_action( 'exad_woo_before_my_account_wrapper' ); ?>
        
            <div <?php echo wp_kses_post( $this->get_render_attribute_string( 'exad-woo-my-account-wrapper' ) ); ?>>

            <?php do_action( 'exad_woo_before_my_account_content_wrapper', $settings ); ?>

                <div class="exad-my-account-content-wrapper <?php echo esc_attr( $settings['exad_woo_my_account_navigation_alignment'] );?>">
                    <?php if ( 'yes' == $settings['exad_woo_my_account_navigation_show_user_info' ] && is_user_logged_in() ) {  ?>
                        <?php add_action('woocommerce_account_menu_items', 'exad_get_userinfo', 10, 2 ); ?>
                    <?php } ;?>
                    <?php
                        if ( \Elementor\Plugin::instance()->editor->is_edit_mode() && ! empty( $settings['exad_woo_my_account_content_select_preview'] )) {
                            global $wp;
                            $wp->query_vars[ $settings['exad_woo_my_account_content_select_preview'] ] = 1;
                        }?>
                    <?php
                    add_filter( 'woocommerce_account_menu_items', [ $this, 'customize_my_account_navigation' ] ); 
                    echo do_shortcode( '[woocommerce_my_account]' );
                    
                    remove_filter( 'woocommerce_account_menu_items', [ $this, 'customize_my_account_navigation' ] );
                    ?>
                </div>
            <?php do_action( 'exad_woo_after_my_account_content_wrapper', $settings ); ?>

            </div>

        <?php do_action( 'exad_woo_after_my_account_wrapper' ); ?>
    
        <?php
  
    }

    public function render_plain_content() {
		echo $this->get_shortcode();
	}

}
