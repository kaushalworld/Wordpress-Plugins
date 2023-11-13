<?php

namespace ShopEngine_Pro\Hooks;

defined('ABSPATH') || exit;


class Register_Modules {

	public function __construct() {
		add_filter('shopengine/modules/list', [$this, 'get_list'], 1);
		add_filter( 'shopengine/module/comparison_fields_for_table', [ $this, 'comparison_table_fields' ], 10, 1 );
		add_action( 'shopengine/module/comparison_settings', [ $this, 'comparison_settings' ], 10 );
	}

	public function get_list($list) {
		return array_merge($list, [
			'badge'           => [
				'slug'       => 'badge',
				'title'      => esc_html__('Badges', 'shopengine-pro'),
				'package'    => 'pro',
				'status'	 => 'inactive',
				'base_class' => '\ShopEngine_Pro\Modules\Badge\Badge',
				'settings'   => [
					'alignment' => [
						'value' => 'horizontal',
						'field_settings' => [
							'type' => 'select',
							'label' => __('Badge Alignment', 'shopengine-pro'),
							'options' => [
								'horizontal' => __('Horizontal', 'shopengine-pro'),
								'vertically' => __('Vertically', 'shopengine-pro'),
							]
						]
					],
					'badge_width_for_single_product' => [
						'value' => '70',
						'field_settings' => [
							'type' => 'range-slider',
							'min' => '30',
							'max' => '100',
							'slider_length' => '80',
							'label' => __('Badge Width For Single Product (px)', 'shopengine-pro'),
						]
					],
					'badge_width_for_loop_product' => [
						'value' => '35',
						'field_settings' => [
							'type' => 'range-slider',
							'min' => '0',
							'max' => '100',
							'slider_length' => '80',
							'label' => __('Badge Width For Loop Products (px)', 'shopengine-pro'),
						]
					],
					'badge_gap_for_single_product' => [
						'value' => '',
						'field_settings' => [
							'type' => 'range-slider',
							'min' => '0',
							'max' => '30',
							'slider_length' => '80',
							'label' => __('Badge Gap For Single Product (px)', 'shopengine-pro'),
						]
					],
					'badge_gap_for_loop_product' => [
						'value' => '',
						'field_settings' => [
							'type' => 'range-slider',
							'min' => '0',
							'max' => '20',
							'slider_length' => '80',
							'label' => __('Badge Gap For Loop Product (px)', 'shopengine-pro'),
						]
					],
					'badges' => [
						'value' => [
							[
								'badge_type'          => 'attachment',
								'badge_attachment_id' => '',
								'badge_text'          => '',
								'badge_text_color'    => '#ffffff',
								'badge_text_background_color' => '#ff0000',
								'badge_text_font_size' => '12px',
								'badge_text_border_radius' => '6px',
								'badge_text_padding' => '0 0 0 0',
								'position' => '',
								'assign_by' => 'products',
								'product_list' => [],
								'category_list' => [],
							]
						],
						'field_settings' => [
							'type'	 	=> 'repeater',
							'label'		=>  __('Badge List', 'shopengine-pro'),
							'repeater_title' => 'title',
							'button_title' => __('Create New Badge', 'shopengine-pro'),
							'fields'	=> [
								'title' => [
									'value'	=> '',
									'field_settings' => [
										'type' 	=> 'text',
										'label'	=> __('Title', 'shopengine-pro')
									]
								],
								'badge_type' => [
									'value' => 'attachment',
									'field_settings' => [
										'type' => 'select',
										'label' => __('Badge Type', 'shopengine-pro'),
										'options' => [
											'attachment' => __('Attachment', 'shopengine-pro'),
											'text' => __('Text', 'shopengine-pro'),
										]
									]
								],
								'badge_attachment_id' => [
									'value'	=> '',
									'field_settings' => [
										'type' 	=> 'gallary-image',
										'label'	=> __('Badge', 'shopengine-pro')
									],
									'condition' => [
										'badge_type' => 'attachment'
									]
								],
								'badge_text' => [
									'translate_able' => true,
									'value'	=> '',
									'field_settings' => [
										'type' 	=> 'text',
										'label'	=> __('Badge Text', 'shopengine-pro')
									],
									'condition' => [
										'badge_type' => 'text'
									]
								],
								'badge_text_color' => [
									'value'	=> '#ffffff',
									'field_settings' => [
										'type' 	=> 'color-picker',
										'label'	=> __('Badge Text Color', 'shopengine-pro')
									],
									'condition' => [
										'badge_type' => 'text'
									]
								],
								'badge_text_background_color' => [
									'value'	=> '#ff0000',
									'field_settings' => [
										'type' 	=> 'color-picker',
										'label'	=> __('Badge Text Background Color', 'shopengine-pro')
									],
									'condition' => [
										'badge_type' => 'text'
									]
								],
								'badge_text_font_size' => [
									'value'	=> '12px',
									'field_settings' => [
										'type' 	=> 'range-slider',
										'min'	=> '0',
										'max'	=> '30',
										'slider_length' => '80',
										'label'	=> __('Badge Text Font Size (px)', 'shopengine-pro')
									],
									'condition' => [
										'badge_type' => 'text'
									]
								],

								'badge_text_border_radius' => [
									'value'	=> '6px',
									'field_settings' => [
										'type' 	=> 'range-slider',
										'min'	=> '0',
										'max'	=> '20',
										'slider_length' => '80',
										'label'	=> __('Badge Text Border Radius (px)', 'shopengine-pro')
									],
									'condition' => [
										'badge_type' => 'text'
									]
								],
								'badge_text_padding' => [
									'value'				=> '0 0 0 0',
									'field_settings'	=> [
										'type'  => 'text',
										'help_text' => esc_html__('Please Give 4 value like this 1px 5px 0px 10px .1st value for top 2nd value for right 3rd value for bottom and 4th value for left', 'shopengine-pro'),
										'label' => esc_html__('Padding', 'shopengine-pro'),
									],
									'condition' => [
										'badge_type' => 'text'
									]
								],
								'position' => [
									'value' => '',
									'field_settings' => [
										'type' => 'select',
										'label' => __('Position', 'shopengine-pro'),
										'options' => [
											'top_right' => __('Top Right', 'shopengine-pro'),
											'top_left' => __('Top Left', 'shopengine-pro'),
											'bottom_right' => __('Bottom Right', 'shopengine-pro'),
											'bottom_left' => __('Bottom Left', 'shopengine-pro'),
										]
									]
								],
								'assign_by' => [
									'value' => 'products',
									'field_settings' => [
										'type' => 'select',
										'label' => __('Assign By', 'shopengine-pro'),
										'options' => [
											'products' => __('Products', 'shopengine-pro'),
											'categories' => __('Categories', 'shopengine-pro'),
										]
									]
								],
								'product_list' => [
									'value'       => [],
									'field_settings' => [
										'type'        => 'multi-select',
										'label'       => esc_html__('Applicable Products', 'shopengine-pro'),
										'load'        => 'ajax',
										'ajax_method' => 'get',  // post, patch, ...
										'ajax_search' => true,
										'api_end'     => get_rest_url('', 'shopengine-builder/v1/badge/products'),
										'arguments'   => [],
										'options'     => [],
									],
									'condition' => [
										'assign_by' => 'products'
									]
								],
								'category_list' => [
									'value'       => [],
									'field_settings' => [
										'type'        => 'multi-select',
										'label'       => esc_html__('Applicable Categories', 'shopengine-pro'),
										'load'        => 'ajax',
										'ajax_method' => 'get',  // post, patch, ...
										'ajax_search' => true,
										'api_end'     => get_rest_url('', 'shopengine-builder/v1/badge/categories'),
										'arguments'   => [],
										'options'     => [],
									],
									'condition' => [
										'assign_by' => 'categories'
									]
								],
							]
						]
					]
				],
			],
			'quick-checkout'  => [
				'slug'       => 'quick-checkout',
				'title'      => esc_html__('Quick Checkout', 'shopengine-pro'),
				'package'    => 'pro',
				'base_class' => '\ShopEngine_Pro\Modules\Quick_Checkout\Quick_Checkout',
				'settings'   => [
					'button_label'	=> [
						'translate_able' => true,
						'value' => '',
						'field_settings' => [
							'type'  => 'text',
							'label' => esc_html__('Button Label', "shopengine-pro"),
						]
					],
					'direct_checkout_status' => [
						'value' => 'no',
						'field_settings' => [
							'type'  => 'switch',
							'label' => esc_html__( 'Enable Direct Checkout On Catalog Pages', 'shopengine-pro' ),
						]
					],
				],
			],
			'partial-payment' => [
				'slug'       => 'partial-payment',
				'title'      => esc_html__( 'Partial Payment', 'shopengine-pro' ),
				'package'    => 'pro',
				'base_class' => '\ShopEngine_Pro\Modules\Partial_Payment\Partial_Payment',
				'settings'   => [
					'partial_payment_amount_type' => [
						'value'          => 'percent_amount',
						'field_settings' => [
							'type'      => 'select',
							'label'     => esc_html__( 'Amount Type', "shopengine-pro" ),
							'help_text' => esc_html__('Select either fixed amount or percentage of partial payment', 'shopengine-pro'),
							'options'   => [
								'percent_amount' => 'Percentage',
								'fixed_amount'   => 'Fixed Amount',
							],
						]
					],
					'partial_payment_amount'      => [
						'value'          => 80,
						'field_settings' => [
							'type'      => 'number',
							'help_text' => 'Select the partial payment amount as per your amount type',
							'label'     => esc_html__( 'Amount', "shopengine-pro" ),
						]
					],
					'avoid_payment_methods'       => [
						'value'          => [ "cod" ],
						'field_settings' => [
							'type'        => 'multi-select',
							'label'       => esc_html__( 'Hide Payment Method/s in Checkout', "shopengine-pro" ),
							'load'        => 'ajax',
							'ajax_method' => 'get',
							'api_end'     => get_rest_url( '',
							                               'shopengine-builder/v1/partial-payment/payment_methods' ),
							'arguments'   => [],
							'options'     => [],
							'help_text'   =>  esc_html__('Payment method selection will be hidden on the first checkout, but for the second installment, all payment methods will appear', 'shopengine-pro'),
						]
					],
					'day_after_installment_reminder'       => [
						'value'          => "5",
						'field_settings' => [
							'type'  => 'number',
							'label' => esc_html__( 'Send Mail After Order Date in Day/s', "shopengine-pro" ),
							'help_text'   =>  esc_html__('Set day/s when ShopEngine send mail after order created for Partial Payment second installment', 'shopengine-pro'),

						]
					],
					'partial_payment_label'       => [
						'translate_able' => true,
						'value'          => "Partial Payment",
						'field_settings' => [
							'type'  => 'text',
							'label' => esc_html__( 'Partial Payment Label', "shopengine-pro" ),
						]
					],
					'full_payment_label'          => [
						'translate_able' => true,
						'value'          => "Full Payment",
						'field_settings' => [
							'type'  => 'text',
							'label' => esc_html__( 'Full Payment Label', "shopengine-pro" ),
						]
					],
					'first_installment_label'     => [
						'translate_able' => true,
						'value'          => "First Installment",
						'field_settings' => [
							'type'  => 'text',
							'label' => esc_html__( 'First Installment Label', "shopengine-pro" ),
						]
					],
					'second_installment_label'    => [
						'translate_able' => true,
						'value'          => "Second Installment",
						'field_settings' => [
							'type'  => 'text',
							'label' => esc_html__( 'Second Installment Label', "shopengine-pro" ),
						]
					],
					'to_pay_label'                => [
						'translate_able' => true,
						'value'          => "To Pay",
						'field_settings' => [
							'type'  => 'text',
							'label' => esc_html__( 'To Pay Label for Checkout Page', "shopengine-pro" ),
						]
					],
				],
			],
			'pre-order' => [
				'slug'       => 'pre-order',
				'title'      => esc_html__( 'Pre-Order', 'shopengine-pro' ),
				'package'    => 'pro',
				'base_class' => '\ShopEngine_Pro\Modules\Pre_Order\Pre_Order',
				'settings'   => [
					'pre_order_label'            => [
						'translate_able' => true,
						'value'       => "Pre-Order",
						'field_settings' => [
							'type'        => 'text',
							'placeholder' => 'Pre-Order Label',
							'label'       => esc_html__( 'Pre-Order Label', 'shopengine-pro' ),
						]
					],
					'pre_order_closed_label'     => [
						'translate_able' => true,
						'value'       => "Pre-Order Closed",
						'field_settings' => [
							'type'        => 'text',
							'placeholder' => 'Pre-Order Closed',
							'label'       => esc_html__( 'Pre-Order Closed Label', 'shopengine-pro' ),
						]
					],
					'pre_order_countdown_status' => [
						'value' => 'yes',
						'field_settings' => [
							'type'  => 'switch',
							'label' => esc_html__( 'Pre-Order Countdown', 'shopengine-pro' ),
						]
					],
					'pre_order_countdown_label'  => [
						'translate_able' => true,
						'value' => 'Pre-Order Countdown',
						'field_settings' => [
							'type'  => 'text',
							'label' => esc_html__( 'Pre-Order Countdown Label', 'shopengine-pro' ),
						]
					],

					'pre_order_primary_color' => [
						'value'				=> '#101010',
						'field_settings'	=> [
							'type'  => 'color-picker',
							'label' => 'Set Primary Color',
						]
					],

					'pre_order_radius' => [
						'value' => 4,
						'field_settings' => [
							'type'  => 'number',
							'label' => 'Set Border Radius (PX)',
						]
					],
				],
			],
			'back-order'       => [
				'slug'       => 'backorder',
				'title'      => esc_html__('Back-Order', 'shopengine-pro'),
				'package'    => 'pro',
				'base_class' => '\ShopEngine_Pro\Modules\Back_Order\Back_Order',
				'settings'   => [
					'backorder_availability_max_limit'    => [
						'value' => 0,
						'field_settings' => [
							'type'  => 'number',
							'placeholder' => '-1 : unlimited ; 0<= whatever you want ...',
							'label' => esc_html__('Maximum backorder limit', 'shopengine-pro'),
						]
					],

					'backorder_availability_date' => [
						'value'  => date('YYYY-MM-DD'),
						'field_settings' => [
							'type'   => 'date',
							'format' => 'YYYY-MM-DD',
							'label'  => esc_html__('Backordered Product Available date', 'shopengine-pro'),
						]
					],
				],
			],
			'sales-notification' => [
				'slug'       => 'sales-notification',
				'title'      => esc_html__( 'Sales Notification', 'shopengine-pro' ),
				'package'    => 'pro',
				'status'	 => 'inactive',
				'base_class' => '\ShopEngine_Pro\Modules\Sales_Notification\Sales_Notification',
				'settings'   => [
					'show_thumbnail' => [
						'value'   => 'user',
						'field_settings' => [
							'type'    => 'select',
							'label'   => esc_html__( 'Show Thumbnail Of', "shopengine-pro" ),
							'options' => [
								'user'    => 'User Avatar',
								'product' => 'Product Image',
							],
						]
					],
					'hide_last_name' => [
						'value' => 'yes',
						'field_settings' => [
							'type'  => 'switch',
							'label' => esc_html__('Hide last name', 'shopengine-pro'),
						]
					],
					'product_limit'  => [
						'value' => 10,
						'field_settings' => [
							'type'  => 'number',
							'label' => esc_html__( 'Product Limit', "shopengine-pro" ),
						]
					],

					'cookie_expire_in_days' => [
						'value' => 1,
						'field_settings' => [
							'type'  => 'number',
							'label' => esc_html__( 'Show Notification again after user cancel (Day)', "shopengine-pro" ),
						]
					],

					'notification_delay' => [
						'value' => 4000,
						'field_settings' => [
							'type'  => 'number',
							'label' => esc_html__( 'Show Notification on every __ milliseconds', "shopengine-pro" ),
							'help_text' => esc_html__( 'Using this input field your can set notification delay/interval time', 'shopengine-pro' )
						]
					],
					'notification_interval_in_ms' => [
						'value' => 7000,
						'field_settings' => [
							'type'  => 'number',
							'label' => esc_html__( 'Keep notification on screen for __ milliseconds', "shopengine-pro" ),
							'help_text' => esc_html__( 'You can keep a single notification visible on screen based on this input value.', 'shopengine-pro' )
						]
					],



					'radius' => [
						'value' => 60,
						'field_settings' => [
							'type'  => 'number',
							'label' => 'Set Rounded Corners (px)',
						]
					],

					'color' => [
						'value' => '#4f4f4fff', // this value property supports 6 (#RRGGBB) and 8 (#RRGGBBAA) digits hex value
						'field_settings' => [
							'type'  => 'color-picker',
							'label' => 'Set Primary Color',
						]
					],
				],
			],
			'currency-switcher' => [
				'slug'		=> 'currency-switcher',
				'title'		=> esc_html__('Currency Switcher', 'shopengine-pro' ),
				'package'	=> 'pro',
				'status'	 => 'inactive',
				'base_class'=> '\ShopEngine_Pro\Modules\Currency_Switcher\Currency_Switcher',
				'settings'   => [
					'currency_auto_update' => [
						'value' => 'yes',
						'field_settings' => [
							'type'  => 'switch',
							'label' => esc_html__('Currency auto update', 'shopengine-pro'),
						]
					],
					'currency_auto_update_time' => [
						'value' => 24,
						'field_settings' => [
							'type'  => 'number',
							'label' => esc_html__('Currency auto update time (hourly)', 'shopengine-pro'),
						]
					],
					'symbol_show_dropdown' => [
						'value' => 'yes',
						'field_settings' => [
							'type'  => 'switch',
							'label' => esc_html__('Show Currency Symbol on Dropdown', 'shopengine-pro'),
						]
					],
					'default_api_service_provider' => [
						'value'       => 'fixer',
						'field_settings' => [
							'type'        => 'select',
							'label'       => esc_html__('Currency default rate provider', 'shopengine-pro'),
							'load'        => 'ajax',
							'ajax_method' => 'get',
							'api_end'     => get_rest_url('', 'shopengine-builder/v1/shopengine_currency/currency_providers'),
							'arguments'   => [],
							'options'     => [],
						]
					],
					'currency_freaks_api_credential' => [
						'value' => '',
						'field_settings' => [
							'type'  => 'text',
							'label' => esc_html__('Currency freaks API credential', 'shopengine-pro'),
						],
						'condition' => [
							'default_api_service_provider' => 'currency_freaks'
						]
					],
					'fixer_api_credential' => [
						'value' => '',
						'field_settings' => [
							'type'  => 'text',
							'label' => esc_html__('Fixer API credential', 'shopengine-pro'),
						],
						'condition' => [
							'default_api_service_provider' => 'fixer'
						]
					],
					'default_currency' => [
						'value'       => '',
						'field_settings' => [
							'type'        => 'select',
							'label'       => esc_html__('Default currency', 'shopengine-pro'),
							'load'        => 'ajax',
							'ajax_method' => 'get',
							'api_end'     => get_rest_url('', 'shopengine-builder/v1/shopengine_currency/setting_currencies'),
							'arguments'   => [],
							'options'     => [],
						]
					],
					'currencies' => [
						'value' => [
							[
								'name' 	=> 'United States Dollar',
								'code' 	=> 'USD',
								'rate' 	=> 1,
								'symbol'	=> '$',
								'position'	=> 'left',
								'decimal'	=> 2,
								'payment_gateways' => [],
								'enable'	=> 'yes'
							]
						],
						'field_settings' => [
							'type'	 	=> 'repeater',
							'label'		=>  esc_html__('Currency List', 'shopengine-pro'),
							'repeater_title' => 'name',
							'fields'	=> [
								'enable' => [
									'value' => 'yes',
									'field_settings' => [
										'type'  => 'switch',
										'label' => esc_html__('Currency Active', 'shopengine-pro'),
									]
								],
								'name' => [
									'translate_able' => true,
									'value'	=> '',
									'field_settings' => [
										'type' 	=> 'text',
										'label'	=> esc_html__('Currency Name', 'shopengine-pro')
									]
								],
								'code' => [
									'value'	=> '',
									'field_settings' => [
										'type' 	=> 'text',
										'label'	=> esc_html__('Currency Code', 'shopengine-pro')
									]
								],
								'rate' => [
									'value'	=> '',
									'field_settings' => [
										'type' 	=> 'number',
										'label'	=> esc_html__('Currency Rate (1 USD = ?)', 'shopengine-pro')
									]
								],
								'symbol' => [
									'value'	=> '',
									'field_settings' => [
										'type' 	=> 'text',
										'label'	=> esc_html__('Currency Symbol', 'shopengine-pro')
									]
								],
								'position' => [
									'value'       	=> '',
									'field_settings' => [
										'type'  		=> 'select',
										'label'       	=> esc_html__('Currency Symbol Position', 'shopengine-pro'),
										'options'     	=> [
											'left'			=> esc_html__('Left', 'shopengine-pro'),
											'right'			=> esc_html__('Right', 'shopengine-pro'),
											'left_space'	=> esc_html__('Left Space', 'shopengine-pro'),
											'right_space'	=> esc_html__('Right Space', 'shopengine-pro'),
										],
									]
								],
								'decimal' => [
									'value'	=> '',
									'field_settings' => [
										'type' 	=> 'select',
										'label'	=> esc_html__('Currency Decimal', 'shopengine-pro'),
										'options' => [
											0,1,2,3,4,5,6,7,8,9,10
										]
									]
								],
								'payment_gateways' => [
									'value'       => [],
									'field_settings' => [
										'type'        => 'multi-select',
										'label'       => esc_html__('Disable Payment Gateways for this currency', 'shopengine-pro'),
										'load'        => 'ajax',
										'ajax_method' => 'get',
										'api_end'     => get_rest_url('', 'shopengine-builder/v1/shopengine_currency/available_payment_gateways'),
										'arguments'   => [],
										'options'     => [],
									]
								],
							],
						]
					]
				],
			],
			'flash-sale-countdown' => [
				'slug'       => 'flash-sale-countdown',
				'title'      => esc_html__('Flash Sale Countdown', 'shopengine-pro'),
				'package'    => 'pro',
				'base_class' => '\ShopEngine_Pro\Modules\Flash_Sale\Flash_Sale_Countdown',
				'settings'   => [
					'override_woocommerce_sale' => [
						'value' => 'yes',
						'field_settings' => [
							'type'  => 'switch',
							'label' => esc_html__('Override WooCommerce sale price', 'shopengine-pro'),
						]
					],
					'flash_sale' => [
						'value'  => [
							[
								'campaign_title'	=> 'Black Friday',
								'start_date'		=> '2021-09-01',
								'end_date'			=> '2022-09-01',
								'category_list'		=> [],
								'product_list'		=> [],
								'discount_amount'	=> 10,
								'discount_type'		=> 'percent',
								'user_roles'		=> [],
							],
						],
						'field_settings' => [
							'type'   => 'repeater',
							'label'	 => esc_html__('Sale Events', 'shopengine-pro'),
							'repeater_title' => 'campaign_title',
							'fields' => [
								'campaign_title' => [
									'value'	=> '',
									'field_settings' => [
										'type'	=> 'text',
										'help_text' => 'Show Flash Sale Countdown on Sale Campaigns/Events',
										'label'	=> esc_html__('Campaign Title', 'shopengine-pro'),
									]
								],
								'start_date' => [
									'value'  => '', // default value
									'field_settings' => [
										'type'   => 'date',
										'format' => 'YYYY-MM-DD', // use any formats supported by moment.js https://momentjs.com/
										'label'  => esc_html__('Countdown Start Date', 'shopengine-pro'), // field title`
									]
								],
								'end_date' => [
									'value'  => '', // default value
									'field_settings' => [
										'type'   => 'date',
										'format' => 'YYYY-MM-DD', // use any formats supported by moment.js https://momentjs.com/
										'label'  => esc_html__('Countdown End Date', 'shopengine-pro'), // field title
									]
								],
								'category_list' => [
									'value'       => [],
									'field_settings' => [
										'type'        => 'multi-select',
										'label'       => esc_html__('Applicable Categories', 'shopengine-pro'),
										'load'        => 'ajax',
										'ajax_method' => 'get',  // post, patch, ...
										'ajax_search' => true,
										'api_end'     => get_rest_url('', 'shopengine-builder/v1/flash-sale/categories'),
										'arguments'   => [],
										'options'     => [],
									]
								],
								'product_list' => [
									'value'       => [],
									'field_settings' => [
										'type'        => 'multi-select',
										'label'       => esc_html__('Products List', 'shopengine-pro'),
										'load'        => 'ajax',
										'ajax_method' => 'get',  // post, patch, ...
										'ajax_search' => true,
										'api_end'     => get_rest_url('', 'shopengine-builder/v1/flash-sale/products'),
										'arguments'   => [],
										'options'     => []
									]
								],
								'discount_amount' => [
									'value'	=> '',
									'field_settings' => [
										'type'	=> 'number',
										'label'	=> esc_html__('Discount Amount', 'shopengine-pro'),
									]
								],
								'discount_type' => [
									'value'       => '',
									'field_settings' => [
										'type'        => 'select',
										'label'       => esc_html__('Discount type', 'shopengine-pro'),
										'options'     => [
											'fixed' => esc_html__('Fixed', 'shopengine-pro'),
											'percent' => esc_html__('Percent', 'shopengine-pro')
										],
									]
								],
								'user_roles' => [
									'value'       => [],
									'field_settings' => [
										'type'        => 'multi-select',
										'label'       => esc_html__('Allow users (optional)', 'shopengine-pro'),
										'load'        => 'ajax',
										'ajax_method' => 'get',  // post, patch, ...
										'api_end'     => get_rest_url('', 'shopengine-builder/v1/flash-sale/user_roles'),
										'arguments'   => [],
										'options'     => [],
									]
								]
							],
						]
					],
				],
			],
			'checkout-additional-field' => [
				'slug'       => 'checkout-additional-field',
				'title'      => esc_html__('Checkout Additional Field', 'shopengine-pro'),
				'package'    => 'pro',
				'base_class' => '\ShopEngine_Pro\Modules\Checkout_Additional_Field\Checkout_Additional_Field',
				'settings'   => [
					'billing' => [
						'value'  => [],
						'field_settings' => [
							'type'   => 'repeater',
							'label'	 => esc_html__('Billing form input field list', 'shopengine-pro'),
							'repeater_title' => 'label',
							'fields' => [
								'label' => [
									'translate_able' => true,
									'value'	=> '',
									'field_settings' => [
										'type'	=> 'text',
										'label'	=> esc_html__('Label', 'shopengine-pro'),
									]
								],
								'type' => [
									'value'			=> '',
									'field_settings' 	=> [
										'type'        	=> 'select',
										'label'       	=> esc_html__('Type', 'shopengine-pro'),
										'arguments'   	=> [],
										'options'   => [
                                            'text'     => esc_html__('Text', 'shopengine-pro'),
                                            'number'   => esc_html__('Number', 'shopengine-pro'),
                                            'email'    => esc_html__('Email', 'shopengine-pro'),
                                            'textarea' => esc_html__('Textarea', 'shopengine-pro'),
                                            'date'     => esc_html__('Date', 'shopengine-pro'),
                                            'tel'      => esc_html__('Tel', 'shopengine-pro'),
                                            'time'     => esc_html__('Time', 'shopengine-pro'),
                                            'url'      => esc_html__('Url', 'shopengine-pro'),
                                            'checkbox' => esc_html__('Checkbox', 'shopengine-pro'),
                                            'radio'    => esc_html__('Radio', 'shopengine-pro'),
											'select'    => esc_html__('Select', 'shopengine-pro')
                                        ]
									]
								],
								'name' => [
									'value'	=> '',
									'field_settings' => [
										'type'	=> 'text',
										'label'	=> esc_html__('Name (unique key)', 'shopengine-pro'),
									]
								],
								'placeholder' => [
									'translate_able' => true,
									'value'	=> '',
									'field_settings' => [
										'type'	=> 'text',
										'label'	=> esc_html__('Placeholder', 'shopengine-pro'),
									]
								],
								'select_options' => [
									'value'	=> '',
									'field_settings' => [
										'type'	=> 'textarea',
										'label'	=> esc_html__('Select Options (Only for select type)', 'shopengine-pro'),
										'help_text'   => esc_html__("Format: option_name :: Option Value. Put each option in separate line.", 'shopengine-pro')
									],
									'condition' => [
										'type' => 'select'
									]
								],
								'options' => [
									'value'	=> '',
									'field_settings' => [
										'type'	=> 'text',
										'label'	=> esc_html__('Options (Only for radio type)', 'shopengine-pro'),
										'help_text'   => esc_html__("Options format demo: 0=Yes,1=No", 'shopengine-pro')
									],
									'condition' => [
										'type' => 'radio'
									]
								],
								'required' => [
									'value'			=> '',
									'field_settings' 	=> [
										'type'        	=> 'select',
										'label'       	=> esc_html__('Required', 'shopengine-pro'),
										'arguments'   	=> [],
										'options'     	=> [
											'1'	=> esc_html__('Yes', 'shopengine-pro'),
											'0' => esc_html__('No', 'shopengine-pro'),
										],
									]
								],
								'position' => [
									'value'			=> '',
									'field_settings' 	=> [
										'type'        	=> 'select',
										'label'       	=> esc_html__('Position (After)', 'shopengine-pro'),
										'load'        	=> 'ajax',
										'ajax_method' 	=> 'get',
										'api_end'     	=> admin_url('admin-ajax.php?action=checkout_billing_fields'),
										'arguments'   	=> [],
										'options'     	=> [],
									]
								],
								'custom_css_class' => [
									'value'				=> '',
									'field_settings' => [
										'type'    => 'text',
										'label'   => esc_html__('Custom css class', "shopengine-pro"),
									]
								]
							],
						]
					],
					'shipping' => [
						'value'  => [],
						'field_settings' => [
							'type'   => 'repeater',
							'label'	 => esc_html__('Shipping form input field  list', 'shopengine-pro'),
							'repeater_title' => 'label',
							'fields' => [
								'label' => [
									'translate_able' => true,
									'value'	=> '',
									'field_settings' => [
										'type'	=> 'text',
										'label'	=> esc_html__('Label', 'shopengine-pro'),
									]
								],
								'type' => [
									'value'			=> '',
									'field_settings' 	=> [
										'type'        	=> 'select',
										'label'       	=> esc_html__('Type', 'shopengine-pro'),
										'arguments'   	=> [],
										'options'     	=> [
											'text'	=> esc_html__('Text', 'shopengine-pro'),
											'number'=> esc_html__('Number', 'shopengine-pro'),
											'email'	=> esc_html__('Email', 'shopengine-pro'),
											'textarea'	=> esc_html__('Textarea', 'shopengine-pro'),
											'date'	=> esc_html__('Date', 'shopengine-pro'),
											'tel'	=> esc_html__('Tel', 'shopengine-pro'),
											'time'  => esc_html__('Time', 'shopengine-pro'),
											'url'	=> esc_html__('Url', 'shopengine-pro'),
											'checkbox' => esc_html__('Checkbox', 'shopengine-pro'),
											'radio'    => esc_html__('Radio', 'shopengine-pro'),
											'select'    => esc_html__('Select', 'shopengine-pro')
										],
									]
								],
								'name' => [
									'value'	=> '',
									'field_settings' => [
										'type'	=> 'text',
										'label'	=> esc_html__('Name (unique key)', 'shopengine-pro'),
									]
								],
								'placeholder' => [
									'translate_able' => true,
									'value'	=> '',
									'field_settings' => [
										'type'	=> 'text',
										'label'	=> esc_html__('Placeholder', 'shopengine-pro'),
									]
								],
								'select_options' => [
									'value'	=> '',
									'field_settings' => [
										'type'	=> 'textarea',
										'label'	=> esc_html__('Select Options (Only for select type)', 'shopengine-pro'),
										'help_text'   => esc_html__("Format: option_name :: Option Value. Put each option in separate line.", 'shopengine-pro')
									
									],
									'condition' => [
										'type' => 'select'
									]
								],
								'options' => [
									'value'	=> '',
									'field_settings' => [
										'type'	=> 'text',
										'label'	=> esc_html__('Options (Only for radio type)', 'shopengine-pro'),
										'help_text'   => esc_html__("Options format demo: 0=Yes,1=No", 'shopengine-pro')
									],
									'condition' => [
										'type' => 'radio'
									]
								],
								'required' => [
									'value'			=> '',
									'field_settings' 	=> [
										'type'        	=> 'select',
										'label'       	=> esc_html__('Required', 'shopengine-pro'),
										'arguments'   	=> [],
										'options'     	=> [
											'1'	=> esc_html__('Yes', 'shopengine-pro'),
											'0' => esc_html__('No', 'shopengine-pro'),
										],
									]
								],
								'position' => [
									'value'			=> '',
									'field_settings' 	=> [
										'type'        	=> 'select',
										'label'       	=> esc_html__('Position (After)', 'shopengine-pro'),
										'load'        	=> 'ajax',
										'ajax_method' 	=> 'get',
										'api_end'     	=> admin_url('admin-ajax.php?action=checkout_shipping_fields'),
										'arguments'   	=> [],
										'options'     	=> [],
									]
								],
								'custom_css_class' => [
									'value'				=> '',
									'field_settings' => [
										'type'    => 'text',
										'label'   => esc_html__('Custom css class', "shopengine-pro"),
									]
								]
							],
						]
					],
					'additional' => [
						'value'  => [],
						'field_settings' => [
							'type'   => 'repeater',
							'label'	 => esc_html__('Additional form input field list', 'shopengine-pro'),
							'repeater_title' => 'label',
							'fields' => [
								'label' => [
									'translate_able' => true,
									'value'	=> '',
									'field_settings' => [
										'type'	=> 'text',
										'label'	=> esc_html__('Label', 'shopengine-pro'),
									]
								],
								'type' => [
									'value'			=> '',
									'field_settings' 	=> [
										'type'        	=> 'select',
										'label'       	=> esc_html__('Type', 'shopengine-pro'),
										'arguments'   	=> [],
										'options'     	=> [
											'text'	=> esc_html__('Text', 'shopengine-pro'),
											'number'=> esc_html__('Number', 'shopengine-pro'),
											'email'	=> esc_html__('Email', 'shopengine-pro'),
											'textarea'	=> esc_html__('Textarea', 'shopengine-pro'),
											'date'	=> esc_html__('Date', 'shopengine-pro'),
											'tel'	=> esc_html__('Tel', 'shopengine-pro'),
											'time'  => esc_html__('Time', 'shopengine-pro'),
											'url'	=> esc_html__('Url', 'shopengine-pro'),
											'checkbox' => esc_html__('Checkbox', 'shopengine-pro'),
											'radio'    => esc_html__('Radio', 'shopengine-pro'),
											'select'    => esc_html__('Select', 'shopengine-pro')
										],
									]
								],
								'name' => [
									'value'	=> '',
									'field_settings' => [
										'type'	=> 'text',
										'label'	=> esc_html__('Name (unique key)', 'shopengine-pro'),
									]
								],
								'placeholder' => [
									'translate_able' => true,
									'value'	=> '',
									'field_settings' => [
										'type'	=> 'text',
										'label'	=> esc_html__('Placeholder', 'shopengine-pro'),
									]
								],
								'select_options' => [
									'value'	=> '',
									'field_settings' => [
										'type'	=> 'textarea',
										'label'	=> esc_html__('Select Options (Only for select type)', 'shopengine-pro'),
										'help_text'   => esc_html__("Format: option_name :: Option Value. Put each option in separate line.", 'shopengine-pro')
									],
									'condition' => [
										'type' => 'select'
									]
								],
								'options' => [
									'value'	=> '',
									'field_settings' => [
										'type'	=> 'text',
										'label'	=> esc_html__('Options (Only for radio type)', 'shopengine-pro'),
										'help_text'   => esc_html__("Options format demo: 0=Yes,1=No", 'shopengine-pro')
									],
									'condition' => [
										'type' => 'radio'
									]
								],
								'required' => [
									'value'			=> '',
									'field_settings' 	=> [
										'type'        	=> 'select',
										'label'       	=> esc_html__('Required', 'shopengine-pro'),
										'arguments'   	=> [],
										'options'     	=> [
											'1'	=> esc_html__('Yes', 'shopengine-pro'),
											'0' => esc_html__('No', 'shopengine-pro'),
										],
									]
								],
								'position' => [
									'value'				=> '',
									'field_settings' 	=> [
										'type'        	=> 'select',
										'label'       	=> esc_html__('Position (Before)', 'shopengine-pro'),
										'arguments'   	=> [],
										'options'     	=> [
											'order_comments' => esc_html__('Order notes', 'shopengine-pro')
										],
									]
								],
								'custom_css_class' => [
									'value'				=> '',
									'field_settings' => [
										'type'    => 'text',
										'label'   => esc_html__('Custom css class', "shopengine-pro"),
									]
								],
							],
						]
					]
				],
			],
			'product-size-charts'           => [
				'slug'       => 'product-size-charts',
				'title'      => esc_html__('Product Size Charts', 'shopengine-pro'),
				'package'    => 'pro',
				'base_class' => '\ShopEngine_Pro\Modules\Product_Size_Charts\Product_Size_Charts',
				'settings'   => [
					'charts' => [
						'value' => [],
						'field_settings' => [
							'type'	 	=> 'repeater',
							'label'		=>  esc_html__('Product Size Chart', 'shopengine-pro'),
							'repeater_title' => 'title',
							'fields'	=> [
								'title' => [
									'value'	=> '',
									'field_settings' => [
										'type' 	=> 'text',
										'label'	=> esc_html__('Chart Title', 'shopengine-pro')
									]
								],
								'attachment_id' => [
									'value'	=> '',
									'field_settings' => [
										'type' 	=> 'gallary-image',
										'label'	=> esc_html__('Chart Image', 'shopengine-pro')
									]
								],
								'category_id' => [
									'value'       => '',
									'field_settings' => [
										'type'        => 'select',
										'label'       => esc_html__('Applicable Category', 'shopengine-pro'),
										'load'        => 'ajax',
										'ajax_method' => 'get',
										'ajax_search' => true,
										'api_end'     => get_rest_url('', 'shopengine-builder/v1/product-size-charts/categories'),
										'arguments'   => [],
										'options'     => [],
									]
								],
							],
						]
					]
				],
			],
			'sticky-fly-cart' => [
				'slug'       => 'sticky-fly-cart',
				'title'      => esc_html__('Sticky Fly Cart', 'shopengine-pro'),
				'package'    => 'pro',
				'status'	 => 'inactive',
				'base_class' => 'ShopEngine_Pro\Modules\Sticky_Fly_Cart\Sticky_Fly_Cart',
				'settings'   => [
					'enable_flying_animation' => [
						'value' => 'yes',
						'field_settings' => [
							'type'  => 'switch',
							'label' => esc_html__('Enable Flying Animation', 'shopengine-pro'),
						]
					],
					'single_page_ajax_add_to_cart' => [
						'value' => 'no',
						'field_settings' => [
							'type'  => 'switch',
							'label' => esc_html__('Enable Ajax Add To Cart On Single Page', 'shopengine-pro'),
						]
					],
					'exclude_pages' => [
						'value'       => [],
						'field_settings' => [
							'type'        => 'multi-select',
							'label'       => esc_html__('Exclude Pages', 'shopengine-pro'),
							'load'        => 'ajax',
							'ajax_search' => true,
							'ajax_method' => 'get',
							'api_end'     => get_rest_url('', 'shopengine-builder/v1/fly-cart/pages'),
							'arguments'   => [],
							'options'     => [],
							// 'options'     => wp_list_pluck(get_pages(), 'post_title', 'ID'),
						]
					],
					'drawer_form' => [
						'value'   => 'right',
						'field_settings' => [
							'type'    => 'select',
							'label'   => esc_html__('Drawer From', 'shopengine-pro'),
							'options' => [
								'left'	=> esc_html__('Left', 'shopengine-pro'),
								'right'	=> esc_html__('Right', 'shopengine-pro'),
							],
						]
					],
					'sticky_button' => [
						'value' => [
							[
								'name'				=> esc_html__('Sticky Button', 'shopengine-pro'),
								'size'				=> '60px',
								'icon_size'			=> '25px',
								'color'				=> '#101010',
								'bg'				=> '#ffffff',
								'pos_top'			=> 'auto',
								'pos_right'			=> '12px',
								'pos_bottom'		=> '12px',
								'pos_left'			=> 'auto',
							]
						],
						'field_settings' => [
							'type'	 	=> 'repeater',
							'label'		=>  ' ',
							'repeater_title' 	=> 'name',
							'hide_add_button'	=> true,
							'hide_close_button'	=> true,
							'fields'	=> [
								'size' => [
									'value'				=> '60px',
									'field_settings'	=> [
										'type'  => 'text',
										'label' => esc_html__('Size', 'shopengine-pro'),
									]
								],
								'icon_size' => [
									'value'				=> '25px',
									'field_settings'	=> [
										'type'  => 'text',
										'label' => esc_html__('Icon Size', 'shopengine-pro'),
									]
								],
								'color' => [
									'value'				=> '#101010',
									'field_settings'	=> [
										'type'  => 'color-picker',
										'label' => esc_html__('Color', 'shopengine-pro'),
									]
								],
								'bg' => [
									'value'				=> '#ffffff',
									'field_settings'	=> [
										'type'  => 'color-picker',
										'label' => esc_html__('Background Color', 'shopengine-pro'),
									]
								],
								'pos_top' => [
									'value'				=> 'auto',
									'field_settings'	=> [
										'type'  => 'text',
										'label' => esc_html__('Top Position', 'shopengine-pro'),
									]
								],
								'pos_right' => [
									'value'				=> '12px',
									'field_settings'	=> [
										'type'  => 'text',
										'label' => esc_html__('Right Position', 'shopengine-pro'),
									]
								],
								'pos_bottom' => [
									'value'				=> '12px',
									'field_settings'	=> [
										'type'  => 'text',
										'label' => esc_html__('Bottom Position', 'shopengine-pro'),
									]
								],
								'pos_left' => [
									'value'				=> 'auto',
									'field_settings'	=> [
										'type'  => 'text',
										'label' => esc_html__('Left Position', 'shopengine-pro'),
									]
								],
							],
						]
					],
					'sticky_button_counter' => [
						'value' => [
							[
								'name'				=> esc_html__('Sticky Button Counter', 'shopengine-pro'),
								'size'				=> '32px',
								'font_size'			=> '16px',
								'color'				=> '#FFFFFF',
								'bg'				=> '#FF3F00',
								'pos_top'			=> '-15px',
								'pos_right'			=> 'auto',
								'pos_bottom'		=> 'auto',
								'pos_left'			=> '-15px',
							]
						],
						'field_settings' => [
							'type'	 	=> 'repeater',
							'label'		=>  ' ',
							'repeater_title' 	=> 'name',
							'hide_add_button'	=> true,
							'hide_close_button'	=> true,
							'fields'	=> [
								'size' => [
									'value'				=> '32px',
									'field_settings'	=> [
										'type'  => 'text',
										'label' => esc_html__('Size', 'shopengine-pro'),
									]
								],
								'font_size' => [
									'value'				=> '16px',
									'field_settings'	=> [
										'type'  => 'text',
										'label' => esc_html__('Icon Size', 'shopengine-pro'),
									]
								],
								'color' => [
									'value'				=> '#FFFFFF',
									'field_settings'	=> [
										'type'  => 'color-picker',
										'label' => esc_html__('Color', 'shopengine-pro'),
									]
								],
								'bg' => [
									'value'				=> '#FF3F00',
									'field_settings'	=> [
										'type'  => 'color-picker',
										'label' => esc_html__('Background Color', 'shopengine-pro'),
									]
								],
								'pos_top' => [
									'value'				=> '15px',
									'field_settings'	=> [
										'type'  => 'text',
										'label' => esc_html__('Top Position', 'shopengine-pro'),
									]
								],
								'pos_right' => [
									'value'				=> 'auto',
									'field_settings'	=> [
										'type'  => 'text',
										'label' => esc_html__('Right Position', 'shopengine-pro'),
									]
								],
								'pos_bottom' => [
									'value'				=> 'auto',
									'field_settings'	=> [
										'type'  => 'text',
										'label' => esc_html__('Bottom Position', 'shopengine-pro'),
									]
								],
								'pos_left' => [
									'value'				=> '15px',
									'field_settings'	=> [
										'type'  => 'text',
										'label' => esc_html__('Left Position', 'shopengine-pro'),
									]
								],
							],
						]
					],
					'cart_body' => [
						'value' => [
							[
								'name'				=> esc_html__('Cart Body', 'shopengine-pro'),
								'color'				=> '#101010',
								'link_hover_color'	=> '#312b2b',
								'bg'				=> '#ffffff',
								'padding'			=> '15px',
								'width'				=> '350px',
							]
						],
						'field_settings' => [
							'type'	 	=> 'repeater',
							'label'		=>  ' ',
							'repeater_title' 	=> 'name',
							'hide_add_button'	=> true,
							'hide_close_button'	=> true,
							'fields'	=> [
								'color' => [
									'value'				=> '#101010',
									'field_settings'	=> [
										'type'  => 'color-picker',
										'label' => esc_html__('Color', 'shopengine-pro'),
									]
								],
								'link_hover_color' => [
									'value'				=> '#312b2b',
									'field_settings'	=> [
										'type'  => 'color-picker',
										'label' => esc_html__('Link Hover Color', 'shopengine-pro'),
									]
								],
								'bg' => [
									'value'				=> '#ffffff',
									'field_settings'	=> [
										'type'  => 'color-picker',
										'label' => esc_html__('Background Color', 'shopengine-pro'),
									]
								],
								'padding' => [
									'value'				=> '15px',
									'field_settings'	=> [
										'type'  => 'text',
										'label' => esc_html__('Padding', 'shopengine-pro'),
									]
								],
								'width' => [
									'value'				=> '350px',
									'field_settings'	=> [
										'type'  => 'text',
										'label' => esc_html__('Width', 'shopengine-pro'),
									]
								],
							],
						]
					],
					'cart_header' => [
						'value' => [
							[
								'name'		=> esc_html__('Cart Header', 'shopengine-pro'),
								'padding'	=> '0 0 10px 0',
							]
						],
						'field_settings' => [
							'type'	 	=> 'repeater',
							'label'		=>  ' ',
							'repeater_title' 	=> 'name',
							'hide_add_button'	=> true,
							'hide_close_button'	=> true,
							'fields'	=> [
								'padding' => [
									'value'				=> '0 0 10px 0',
									'field_settings'	=> [
										'type'  => 'text',
										'label' => esc_html__('Padding', 'shopengine-pro'),
									]
								],
							],
						]
					],
					'cart_items' => [
						'value' => [
							[
								'name'			=> esc_html__('Cart Items', 'shopengine-pro'),
								'padding'		=> '15px 10px 15px 0',
								'border_bottom'	=> '1px solid #e6ebee',
								'font_size'		=> '15px',
							]
						],
						'field_settings' => [
							'type'	 	=> 'repeater',
							'label'		=>  ' ',
							'repeater_title' 	=> 'name',
							'hide_add_button'	=> true,
							'hide_close_button'	=> true,
							'fields'	=> [
								'padding' => [
									'value'				=> '15px 10px 15px 0',
									'field_settings'	=> [
										'type'  => 'text',
										'label' => esc_html__('Padding', 'shopengine-pro'),
									]
								],
								'border_bottom' => [
									'value'				=> '1px solid #e6ebee',
									'field_settings'	=> [
										'type'  => 'text',
										'label' => esc_html__('Border Bottom', 'shopengine-pro'),
									]
								],
								'font_size' => [
									'value'				=> '15px',
									'field_settings'	=> [
										'type'  => 'text',
										'label' => esc_html__('Font Size', 'shopengine-pro'),
									]
								],
							],
						]
					],
					'cart_subtotal' => [
						'value' => [
							[
								'name'			=> esc_html__('Cart Subtotal', 'shopengine-pro'),
								'padding'		=> '15px 0',
							]
						],
						'field_settings' => [
							'type'	 	=> 'repeater',
							'label'		=>  ' ',
							'repeater_title' 	=> 'name',
							'hide_add_button'	=> true,
							'hide_close_button'	=> true,
							'fields'	=> [
								'padding' => [
									'value'				=> '15px 0',
									'field_settings'	=> [
										'type'  => 'text',
										'label' => esc_html__('Padding', 'shopengine-pro'),
									]
								],
							],
						]
					],
					'cart_buttons' => [
						'value' => [
							[
								'name'			=> esc_html__('Cart Buttons', 'shopengine-pro'),
								'wrap_padding'	=> '15px',
								'padding'		=> '12px 10px 12px 10px',
								'color'			=> '#ffffff',
								'bg'			=> '#101010',
								'hover_bg'		=> '#312b2b',
							]
						],
						'field_settings' => [
							'type'	 	=> 'repeater',
							'label'		=>  ' ',
							'repeater_title' 	=> 'name',
							'hide_add_button'	=> true,
							'hide_close_button'	=> true,
							'fields'	=> [
								'wrap_padding' => [
									'value'				=> '15px',
									'field_settings'	=> [
										'type'  => 'text',
										'label' => esc_html__('Wrap Padding', 'shopengine-pro'),
									]
								],
								'padding' => [
									'value'				=> '12px 10px 12px 10px',
									'field_settings'	=> [
										'type'  => 'text',
										'label' => esc_html__('Button Padding', 'shopengine-pro'),
									]
								],
								'color' => [
									'value'				=> '#ffffff',
									'field_settings'	=> [
										'type'  => 'color-picker',
										'label' => esc_html__('Color', 'shopengine-pro'),
									]
								],
								'bg' => [
									'value'				=> '#101010',
									'field_settings'	=> [
										'type'  => 'color-picker',
										'label' => esc_html__('Background Color', 'shopengine-pro'),
									]
								],
								'hover_bg' => [
									'value'				=> '#312b2b',
									'field_settings'	=> [
										'type'  => 'color-picker',
										'label' => esc_html__('Hover Background Color', 'shopengine-pro'),
									]
								],
							],
						]
					],
				]
			],
			'vacation'           => [
				'slug'       => 'vacation',
				'title'      => esc_html__('Vacation', 'shopengine-pro'),
				'package'    => 'pro',
				'status'	 => 'inactive',
				'base_class' => '\ShopEngine_Pro\Modules\Vacation\Vacation',
				'help_text' => esc_html__('After enabling the Vacation module, you have to select the time zone country-wise manually from the "Settings" tab. Please avoid Manual Offsets', 'shopengine-pro'),
				'settings'   => [
					'regular_off_days' => [
						'value'          => [],
						'field_settings' => [
							'type'        => 'multi-select',
							'label'       => esc_html__('Regular Off Days', 'shopengine-pro'),
							'options'     => [
								'sun' => esc_html__('Sun', 'shopengine-pro'),
								'mon' => esc_html__('Mon', 'shopengine-pro'),
								'tue' => esc_html__('Tue', 'shopengine-pro'),
								'wed' => esc_html__('Wed', 'shopengine-pro'),
								'thu' => esc_html__('Thu', 'shopengine-pro'),
								'fri' => esc_html__('Fri', 'shopengine-pro'),
								'sat' => esc_html__('Sat', 'shopengine-pro')
							],
						]
					],
					'enable_regular_off_days_time'     => [
						'value'          => 'no',
						'field_settings' => [
							'type'  => 'switch',
							'label' => esc_html__( 'Enable Regular Off Days Time', 'shopengine-pro' ),
						]
					],
					'start_time' => [
						'value' => '',
						'field_settings' => [
							'type'  => 'time',
							'format'=> 'h:mm:ss a',
							'label' => esc_html__('Start Time', "shopengine-pro"),
						],
						'condition' => [
							'enable_regular_off_days_time' => 'yes'
						]
					],
					'end_time' => [
						'value' => '',
						'field_settings' => [
							'type'  => 'time',
							'format' => 'h:mm:ss a',
							'label' => esc_html__('End Time', "shopengine-pro"),
						],
						'condition' => [
							'enable_regular_off_days_time' => 'yes'
						]
					],
					'vacation_days' => [
						'value' => [],
						'field_settings' => [
							'type'	 	=> 'repeater',
							'label'		=>  esc_html__('Off Days', 'shopengine-pro'),
							'repeater_title' => 'title',
							'fields'	=> [
								'title' => [
									'value' => '',
									'field_settings' => [
										'type' => 'text',
										'label' => esc_html__( 'Title', 'shopengine-pro' ),
									]
								],
								'start_and_end_date' => [
									'value' => [
										'2020-01-01',
										'2021-01-01'
									],
									'field_settings' => [
										'type'	=> 'range-date',
										'format' => 'YYYY-MM-DD',
										'label'	=> esc_html__('Start And End Date', 'shopengine-pro'),
									]
								]
							],
						],
					],
				]
			],
			'multistep-checkout' => [
				'slug'       => 'multistep-checkout',
				'title'      => esc_html__('Multistep Checkout', 'shopengine-pro'),
				'base_class' => 'ShopEngine_Pro\Modules\Multistep_Checkout\Multistep_Checkout',
				'package'    => 'pro',
				'status'	 => 'inactive',
				'settings'	 => []
			],
			'advanced-coupon' => [
				'slug'       => 'advanced-coupon',
				'title'      => esc_html__('Advanced Coupon', 'shopengine-pro'),
				'base_class' => 'ShopEngine_Pro\Modules\Advanced_Coupon\Advanced_Coupon',
				'package'    => 'pro',
				'status'	 => 'inactive',
				'settings'	 => []
			],
			'cross-sell-popup' => [
				'slug'       => 'cross-sell-popup',
				'title'      => esc_html__('Cross Sell Popup', 'shopengine-pro'),
				'base_class' => 'ShopEngine_Pro\Modules\Cross_Sell_Popup\Cross_Sell_Popup',
				'package'    => 'pro',
				'status'	 => 'inactive',
				'settings'	 => []
			],
			'avatar' => [
				'slug'       => 'avatar',
				'title'      => esc_html__('Avatar', 'shopengine-pro'),
				'package'    => 'pro',
				'status'	 => 'inactive',
				'base_class' => '\ShopEngine_Pro\Modules\Avatar\Avatar',
				'settings'	 => [
					'max_size' => [
						'value' => 500,
						'field_settings' => [
							'type'  => 'number',
							'label' => esc_html__('Avatar max size (KB)', 'shopengine-pro'),
						]
					]
				]
			]
		]);
	}

	public function comparison_table_fields( $fields ) {
		return array_merge( $fields,
			[] );
	}

	public function comparison_settings( $fields ) {
		return array_merge( $fields,
			[
				'attribute_fields' => [
					'value'          => [],
					'field_settings' => [
						'type'        => 'multi-select',
						'label'       => esc_html__( 'Select Attributes to Show', 'shopengine-pro' ),
						'load'        => 'ajax',
						'ajax_method' => 'get',
						'api_end'     => get_rest_url( '', 'shopengine-builder/v1/comparison/attributes' ),
						'arguments'   => [],
						'options'     => [],
					]
				],
				'custom_meta_fields' => [
					'value'          => [],
					'field_settings' => [
						'type'        => 'multi-select',
						'label'       => esc_html__( 'Select Custom Meta', 'shopengine-pro' ),
						'load'        => 'ajax',
						'ajax_method' => 'get',
						'api_end'     => get_rest_url( '', 'shopengine-builder/v1/comparison/custom_meta' ),
						'arguments'   => [],
						'options'     => [],
						'help_text'   => esc_html__("Custom Meta to Show in Comparison Table", 'shopengine-pro' )
					]
				],
				'share_button'     => [
					'value'          => [],
					'field_settings' => [
						'type'  => 'multi-select',
						'label' => esc_html__( 'Comparison Share Button', 'shopengine-pro' ),
						'options'     => [
							'facebook' => 'Facebook',
							'twitter' => 'Twitter',
							'copy_url' => 'Copy URL',
						],
					]
				],
				'show_bottom_bar'     => [
					'value'          => 'yes',
					'field_settings' => [
						'type'  => 'switch',
						'label' => esc_html__( 'Show Compare Button/Bar on Bottom', 'shopengine-pro' ),
					]
				],
			] );
	}
}
