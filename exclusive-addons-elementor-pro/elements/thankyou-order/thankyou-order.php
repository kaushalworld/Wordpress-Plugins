<?php
namespace ExclusiveAddons\Elements;

if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.

use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Border;
use \Elementor\Group_Control_Box_Shadow;
use \Elementor\Group_Control_Typography;
use \Elementor\Widget_Base;
use \Elementor\Group_Control_Background;
use \ExclusiveAddons\Pro\Elementor\ProHelper;

class Woo_Thank_you_order extends Widget_Base {

	public function get_name() {
		return 'exad-thank-you-order';
	}

	public function get_title() {
		return __( 'Thank You Order', 'exclusive-addons-elementor-pro' );
	}

	public function get_icon() {
		return 'exad exad-logo exad-woo-products';
	}

	public function get_categories() {
		return [ 'exclusive-addons-elementor' ];
	}

	public function get_keywords() {
	    return [ 'thank you', 'order', 'thank you order' ];
	}

    protected function register_controls() {

        $exad_primary_color   = get_option( 'exad_primary_color_option', '#7a56ff' );

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

        $this->start_controls_section(
            'order_thankyou_content',
            [
                'label' => __( 'Thank you order', 'exclusive-addons-elementor-pro' ),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );
            
            $this->add_control(
                'order_thankyou_message',
                [
                    'label'     => __( 'Thank you message', 'exclusive-addons-elementor-pro' ),
                    'type'      => Controls_Manager::TEXTAREA,
                    'default' => __( 'Thank you. Your order has been received.', 'exclusive-addons-elementor-pro' ),
                ]
            );

			$this->add_control(
				'thankyou_order_table_order_heading',
				array(
					'label'       => __( 'Order Heading', 'exclusive-addons-elementor-pro' ),
					'type'        => Controls_Manager::TEXT,
					'default'     => __( 'Order number:', 'exclusive-addons-elementor-pro' ),
					'placeholder' => __( 'Type order number heading here', 'exclusive-addons-elementor-pro' ),
				)
			);
	
			$this->add_control(
				'thankyou_order_table_date_heading',
				array(
					'label'       => __( 'Date Heading', 'exclusive-addons-elementor-pro' ),
					'type'        => Controls_Manager::TEXT,
					'default'     => __( 'Date:', 'exclusive-addons-elementor-pro' ),
					'placeholder' => __( 'Type date heading here', 'exclusive-addons-elementor-pro' ),
				)
			);
	
			$this->add_control(
				'thankyou_order_table_email_heading',
				array(
					'label'       => __( 'Email Heading', 'exclusive-addons-elementor-pro' ),
					'type'        => Controls_Manager::TEXT,
					'default'     => __( 'Email:', 'exclusive-addons-elementor-pro' ),
					'placeholder' => __( 'Type email heading here', 'exclusive-addons-elementor-pro' ),
				)
			);
	
			$this->add_control(
				'thankyou_order_table_total_heading',
				array(
					'label'       => __( 'Total Heading', 'exclusive-addons-elementor-pro' ),
					'type'        => Controls_Manager::TEXT,
					'default'     => __( 'Total:', 'exclusive-addons-elementor-pro' ),
					'placeholder' => __( 'Type total heading here', 'exclusive-addons-elementor-pro' ),
				)
			);
	
			$this->add_control(
				'thankyou_order_table_payment_method_heading',
				array(
					'label'       => __( 'Payment Heading', 'exclusive-addons-elementor-pro' ),
					'type'        => Controls_Manager::TEXT,
					'default'     => __( 'Payment method:', 'exclusive-addons-elementor-pro' ),
					'placeholder' => __( 'Type payment heading here', 'exclusive-addons-elementor-pro' ),
				)
			);

        $this->end_controls_section();


		/**
         * Style Section
         */

		/*
		*SECTION product Title Styling Section
		*/
		$this->start_controls_section(
            'exad_thank_you_order_thankyou_title_style',
            [
                'label'     => __( 'Thank you message', 'exclusive-addons-elementor-pro' ),
                'tab'       => Controls_Manager::TAB_STYLE
            ]
        );

		$this->add_responsive_control(
            'exad_thank_you_order_thankyou_title_alignment',
            [
                'label'         => __( 'Alignment', 'exclusive-addons-elementor-pro' ),
                'type'          => Controls_Manager::CHOOSE,
                'default'       => 'left',
                'toggle'        => false,
                'options'       => [
                    'left' => [
                        'title'  => __( 'Left', 'exclusive-addons-elementor-pro' ),
                        'icon'   => 'eicon-h-align-left'
                    ],
                    'center'     => [
                        'title'  => __( 'Center', 'exclusive-addons-elementor-pro' ),
                        'icon'   => 'eicon-h-align-center'
                    ],
                    'right'   => [
                        'title'  => __( 'Right', 'exclusive-addons-elementor-pro' ),
                        'icon'   => 'eicon-h-align-right'
                    ]
                ],
                'selectors'     => [
                    '{{WRAPPER}} .exad-exad-thank-you-order .woocommerce-thankyou-order-received' => 'text-align: {{VALUE}};'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'exad_thank_you_order_thankyou_title_typography',
                'selector' => '{{WRAPPER}} .exad-exad-thank-you-order .woocommerce-thankyou-order-received'
            ]
        );

        $this->add_control(
            'exad_thank_you_order_thankyou_title_title_color',
            [
                'label'     => __( 'Color', 'exclusive-addons-elementor-pro' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#000000',
                'selectors' => [
                    '{{WRAPPER}} .exad-exad-thank-you-order .woocommerce-thankyou-order-received' => 'color: {{VALUE}};'
                ]
            ]
        );

   		$this->add_control(
            'exad_thank_you_order_thankyou_title_bg_color',
            [
                'label'     => __( 'Background Color', 'exclusive-addons-elementor-pro' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .exad-exad-thank-you-order .woocommerce-thankyou-order-received' => 'background: {{VALUE}};'
                ]
            ]
        );

		$this->add_responsive_control(
            'exad_thank_you_order_thankyou_title_padding',
            [
                'label'         => __( 'Padding', 'exclusive-addons-elementor-pro' ),
                'type'          => Controls_Manager::DIMENSIONS,            
                'size_units'    => [ 'px', 'em', '%' ],
                'selectors'     => [
                        '{{WRAPPER}} .exad-exad-thank-you-order .woocommerce-thankyou-order-received' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->add_responsive_control(
            'exad_thank_you_order_thankyou_title_margin',
            [
                'label'         => __( 'Margin', 'exclusive-addons-elementor-pro' ),
                'type'          => Controls_Manager::DIMENSIONS,            
                'size_units'    => [ 'px', 'em', '%' ],
                'selectors'     => [
                        '{{WRAPPER}} .exad-exad-thank-you-order .woocommerce-thankyou-order-received' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

		$this->add_responsive_control(
			'exad_thank_you_order_thankyou_title_radius',
			[
				'label'      => __( 'Border Radius', 'exclusive-addons-elementor-pro' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'default'    => [
					'top'    => '0',
					'right'  => '0',
					'bottom' => '0',
					'left'   => '0',
					'unit'   => 'px'
				],
				'selectors'  => [
					'{{WRAPPER}} .exad-exad-thank-you-order .woocommerce-thankyou-order-received' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'exad_thank_you_order_thankyou_title_border',
				'selector' => '{{WRAPPER}} .exad-exad-thank-you-order .woocommerce-thankyou-order-received'
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'exad_thank_you_order_thankyou_title_box_shadow',
				'selector' => '{{WRAPPER}} .exad-exad-thank-you-order .woocommerce-thankyou-order-received'
			]
		);

        $this->end_controls_section();

        /*
		* product container Styling Section
		*/
        $this->start_controls_section(
            'exad_thank_you_order_container_style_section',
            [
                'label' => __( 'Container', 'exclusive-addons-elementor-pro' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
		);

		$this->add_responsive_control(
            'exad_thank_you_order_container_alignment',
            [
                'label'         => __( 'Alignment', 'exclusive-addons-elementor-pro' ),
                'type'          => Controls_Manager::CHOOSE,
                'default'       => 'left',
                'toggle'        => false,
                'options'       => [
                    'left' => [
                        'title'  => __( 'Left', 'exclusive-addons-elementor-pro' ),
                        'icon'   => 'eicon-h-align-left'
                    ],
                    'center'     => [
                        'title'  => __( 'Center', 'exclusive-addons-elementor-pro' ),
                        'icon'   => 'eicon-h-align-center'
                    ],
                    'right'   => [
                        'title'  => __( 'Right', 'exclusive-addons-elementor-pro' ),
                        'icon'   => 'eicon-h-align-right'
                    ]
                ],
                'selectors'     => [
                    '{{WRAPPER}} .exad-exad-thank-you-order .woocommerce-order-overview' => 'text-align: {{VALUE}};'
                ]
            ]
        );

        $this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'exad_thank_you_order_container_background',
				'types'    => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .exad-exad-thank-you-order .woocommerce-order-overview'
			]
		);

		$this->add_responsive_control(
			'exad_thank_you_order_container_padding',
			[
				'label'         => __( 'Padding', 'exclusive-addons-elementor-pro' ),
				'type'          => Controls_Manager::DIMENSIONS,
				'size_units'    => [ 'px', '%' ],
				'default'       => [
					'top'       => '0',
					'right'     => '0',
					'bottom'    => '0',
					'left'      => '0',
					'unit'      => 'px',
                    'isLinked'  => false
				],
				'selectors'     => [
					'{{WRAPPER}} .exad-exad-thank-you-order .woocommerce-order-overview' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
		);

		$this->add_responsive_control(
			'exad_thank_you_order_container_margin',
			[
				'label'        => __( 'Margin', 'exclusive-addons-elementor-pro' ),
				'type'         => Controls_Manager::DIMENSIONS,
				'size_units'   => [ 'px', '%' ],
				'default'      => [
					'top'      => '0',
					'right'    => '0',
					'bottom'   => '0',
					'left'     => '0',
					'unit'     => 'px',
					'isLinked' => false
				],
				'selectors'    => [
					'{{WRAPPER}} .exad-exad-thank-you-order .woocommerce-order-overview' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
        );

        $this->add_responsive_control(
			'exad_thank_you_order_container_radius',
			[
				'label'      => __( 'Border Radius', 'exclusive-addons-elementor-pro' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'default'    => [
					'top'    => '0',
					'right'  => '0',
					'bottom' => '0',
					'left'   => '0',
					'unit'   => 'px'
				],
				'selectors'  => [
					'{{WRAPPER}} .exad-exad-thank-you-order .woocommerce-order-overview' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'exad_thank_you_order_container_border',
				'selector' => '{{WRAPPER}} .exad-exad-thank-you-order .woocommerce-order-overview'
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'exad_thank_you_order_container_box_shadow',
				'selector' => '{{WRAPPER}} .exad-exad-thank-you-order .woocommerce-order-overview'
			]
		);

        $this->end_controls_section();

		  // Order Thankyou Label
		  $this->start_controls_section(
            'exad_order_thankyou_label_style',
            array(
                'label' => __( 'Order Label', 'exclusive-addons-elementor-pro' ),
                'tab' => Controls_Manager::TAB_STYLE,
            )
        );
            $this->add_control(
                'exad_order_thankyou_label_color',
                [
                    'label' => __( 'Color', 'exclusive-addons-elementor-pro' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} ul.order_details li' => 'color: {{VALUE}}',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                array(
                    'name'      => 'exad_order_thankyou_label_typography',
                    'label'     => __( 'Typography', 'exclusive-addons-elementor-pro' ),
                    'selector'  => '{{WRAPPER}} ul.order_details li',
                )
            );

            $this->add_responsive_control(
                'exad_order_thankyou_label_align',
                [
                    'label'        => __( 'Alignment', 'exclusive-addons-elementor-pro' ),
                    'type'         => Controls_Manager::CHOOSE,
                    'options'      => [
                        'left'   => [
                            'title' => __( 'Left', 'exclusive-addons-elementor-pro' ),
                            'icon'  => 'eicon-h-align-left',
                        ],
                        'center' => [
                            'title' => __( 'Center', 'exclusive-addons-elementor-pro' ),
                            'icon'  => 'eicon-h-align-center',
                        ],
                        'right'  => [
                            'title' => __( 'Right', 'exclusive-addons-elementor-pro' ),
                            'icon'  => 'eicon-h-align-right',
                        ],
                        'justify' => [
                            'title' => __( 'Justified', 'exclusive-addons-elementor-pro' ),
                            'icon' => 'eicon-h-align-stretch',
                        ],
                    ],
                    'default'      => 'left',
                    'selectors' => [
                        '{{WRAPPER}} ul.order_details li' => 'text-align: {{VALUE}}',
                    ],
                ]
            );

        $this->end_controls_section();

        // Order Thankyou Details
        $this->start_controls_section(
            'exad_order_thankyou_details_style',
            array(
                'label' => __( 'Order Details', 'exclusive-addons-elementor-pro' ),
                'tab' => Controls_Manager::TAB_STYLE,
            )
        );
            $this->add_control(
                'exad_order_thankyou_details_color',
                [
                    'label' => __( 'Color', 'exclusive-addons-elementor-pro' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} ul.order_details li strong' => 'color: {{VALUE}}',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                array(
                    'name'      => 'exad_order_thankyou_details_typography',
                    'label'     => __( 'Typography', 'exclusive-addons-elementor-pro' ),
                    'selector'  => '{{WRAPPER}} ul.order_details li strong',
                )
            );

            $this->add_responsive_control(
                'exad_order_thankyou_details_align',
                [
                    'label'        => __( 'Alignment', 'exclusive-addons-elementor-pro' ),
                    'type'         => Controls_Manager::CHOOSE,
                    'options'      => [
                        'left'   => [
                            'title' => __( 'Left', 'exclusive-addons-elementor-pro' ),
                            'icon'  => 'eicon-h-align-left',
                        ],
                        'center' => [
                            'title' => __( 'Center', 'exclusive-addons-elementor-pro' ),
                            'icon'  => 'eicon-h-align-center',
                        ],
                        'right'  => [
                            'title' => __( 'Right', 'exclusive-addons-elementor-pro' ),
                            'icon'  => 'eicon-h-align-right',
                        ],
                        'justify' => [
                            'title' => __( 'Justified', 'exclusive-addons-elementor-pro' ),
                            'icon' => 'eicon-h-align-stretch',
                        ],
                    ],
                    'default'      => 'left',
                    'selectors' => [
                        '{{WRAPPER}} ul.order_details li strong' => 'text-align: {{VALUE}}',
                    ],
                ]
            );

			$this->add_responsive_control(
				'exad_order_thankyou_details_top_spacer',
				[
					'label'   => __('Top Space', 'exclusive-addons-elementor-pro'),
					'type'    => Controls_Manager::SLIDER,
					'range'   => [
						'px'  => [
							'max' => 30
						]
					],
					'selectors' => [
						'{{WRAPPER}} ul.order_details li strong' => 'margin-top: {{SIZE}}px;'
					]
				]
			);
	
        $this->end_controls_section();

    }

    protected function render() {
        if( ! class_exists('woocommerce') ) {
            return;
        }

        $settings = $this->get_settings_for_display();
        ?>

        <div class="exad-exad-thank-you-order">

            <?php do_action( 'exad_woo_builder_widget_product_stock_before_render' ); ?>

                <?php 
                    global $wp;
                    $order_thankyou_message = $settings['order_thankyou_message'];
                    
                    if( isset($wp->query_vars['order-received']) ){
                        $received_order_id = $wp->query_vars['order-received'];
                    }else{
                        $received_order_id = ProHelper::exad_product_get_last_order_id();
                    }
                    $order = wc_get_order( $received_order_id );
            
                    ?>
                    
                    <?php if ( $order ) : ?>
            
                        <?php if ( $order->has_status( 'failed' ) ) : ?>
                    
                            <p class="woocommerce-notice woocommerce-notice--error woocommerce-thankyou-order-failed"><?php esc_html_e( 'Unfortunately your order cannot be processed as the originating bank/merchant has declined your transaction. Please attempt your purchase again.', 'exclusive-addons-elementor-pro' ); ?></p>
                    
                            <p class="woocommerce-notice woocommerce-notice--error woocommerce-thankyou-order-failed-actions">
                                <a href="<?php echo esc_url( $order->get_checkout_payment_url() ); ?>" class="button pay"><?php esc_html_e( 'Pay', 'exclusive-addons-elementor-pro' ) ?></a>
                                <?php if ( is_user_logged_in() ) : ?>
                                    <a href="<?php echo esc_url( wc_get_page_permalink( 'myaccount' ) ); ?>" class="button pay"><?php esc_html_e( 'My account', 'exclusive-addons-elementor-pro' ); ?></a>
                                <?php endif; ?>
                            </p>
                    
                        <?php else : ?>
                    
                            <p class="woocommerce-notice woocommerce-notice--success woocommerce-thankyou-order-received"><?php echo apply_filters( 'woocommerce_thankyou_order_received_text', $order_thankyou_message, $order ); ?></p>
                    
                            <ul class="woocommerce-order-overview woocommerce-thankyou-order-details order_details">
                    
								<li class="woocommerce-order-overview__order order">
									<?php echo ! empty( $settings['thankyou_order_table_order_heading'] ) ? esc_html__( $settings['thankyou_order_table_order_heading'], 'exclusive-addons-elementor-pro' ) : esc_html__( 'Order number:', 'exclusive-addons-elementor-pro' ); ?>
									<strong><?php echo $order->get_order_number(); ?></strong>
								</li>

								<li class="woocommerce-order-overview__date date">
									<?php echo ! empty( $settings['thankyou_order_table_date_heading'] ) ? esc_html__( $settings['thankyou_order_table_date_heading'], 'exclusive-addons-elementor-pro' ) : esc_html__( 'Date:', 'exclusive-addons-elementor-pro' ); ?>
									<strong><?php echo wc_format_datetime( $order->get_date_created() ); ?></strong>
								</li>

								<?php if ( is_user_logged_in() && $order->get_user_id() === get_current_user_id() && $order->get_billing_email() ) : ?>
									<li class="woocommerce-order-overview__email email">
										<?php echo ! empty( $settings['thankyou_order_table_email_heading'] ) ? esc_html__( $settings['thankyou_order_table_email_heading'], 'exclusive-addons-elementor-pro' ) : esc_html__( 'Email:', 'exclusive-addons-elementor-pro' ); ?>
										<strong><?php echo $order->get_billing_email(); ?></strong>
									</li>
								<?php endif; ?>

								<li class="woocommerce-order-overview__total total">
									<?php echo ! empty( $settings['thankyou_order_table_total_heading'] ) ? esc_html__( $settings['thankyou_order_table_total_heading'], 'exclusive-addons-elementor-pro' ) : esc_html__( 'Total:', 'exclusive-addons-elementor-pro' ); ?>
									<strong><?php echo $order->get_formatted_order_total(); ?></strong>
								</li>

								<?php if ( $order->get_payment_method_title() ) : ?>
									<li class="woocommerce-order-overview__payment-method method">
										<?php echo ! empty( $settings['thankyou_order_table_payment_method_heading'] ) ? esc_html__( $settings['thankyou_order_table_payment_method_heading'], 'exclusive-addons-elementor-pro' ) : esc_html__( 'Payment method:', 'exclusive-addons-elementor-pro' ); ?>
										<strong><?php echo wp_kses_post( $order->get_payment_method_title() ); ?></strong>
									</li>
								<?php endif; ?>
                    
                            </ul>
                    
                        <?php endif; ?>
                    
                        <?php do_action( 'woocommerce_thankyou_' . $order->get_payment_method(), $order->get_id() ); ?>
                    
                    <?php else : ?>
                    
                        <p class="woocommerce-notice woocommerce-notice--success woocommerce-thankyou-order-received"><?php echo apply_filters( 'woocommerce_thankyou_order_received_text', $order_thankyou_message, null ); ?></p>
                    
                    <?php endif; ?>

            <?php do_action( 'exad_woo_builder_widget_product_stock_after_render' ); ?>

        </div>

        <?php
    }
}