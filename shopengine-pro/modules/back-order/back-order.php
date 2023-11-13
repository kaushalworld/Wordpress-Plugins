<?php

namespace ShopEngine_Pro\Modules\Back_Order;

use ShopEngine\Traits\Singleton;
use ShopEngine_Pro\Modules\Back_Order\Common\Item_Meta_Format;

class Back_Order {

	use Singleton;

	protected $global_settings = [
		'backorder' => [
			'backorder_availability_max_limit' => 5,  // 0< unlimited ; 0>= :D
			'backorder_availability_date'      => '2021-09-11',  // '' = soon,; 0>= :D
		],
	];

	protected $field_names = [
		'variation_max_limit' => '_backorder_variation_max_limit',
		'variation_avl_date'  => '_backorder_variation_avl_date',
	];

	public function init() {

		$sett = \ShopEngine\Core\Register\Module_List::instance()->get_settings('back-order');

		$this->global_settings['backorder']['backorder_availability_max_limit'] = isset($sett['backorder_availability_max_limit']['value']) ? intval($sett['backorder_availability_max_limit']['value']) : 0;
		$this->global_settings['backorder']['backorder_availability_date']      = empty($sett['backorder_availability_date']['value']) ? ''
			: date('Y-m-d', strtotime($sett['backorder_availability_date']['value']));


		add_action('wp_enqueue_scripts', [$this, 'enqueue']);
		add_action('admin_enqueue_scripts', [$this, 'admin_enqueue']);

		/**
		 * Add fields in inventory for simple product
		 */
		add_action('woocommerce_product_options_stock_status', [$this, 'add_stock_option_for_backorder']);
		add_action('woocommerce_process_product_meta', [$this, 'save_custom_backorder_fields'], 10, 2);

		/**
		 * Add fields in variation inventory for variable product
		 */
		//add_action('woocommerce_variation_options_inventory', [$this, 'variation_settings_fields'], 10, 3);
		add_action('woocommerce_product_after_variable_attributes', [$this, 'variation_settings_fields'], 10, 3);
		add_action('woocommerce_save_product_variation', [$this, 'save_variation_settings_fields'], 10, 2);
		add_filter('woocommerce_available_variation', [$this, 'load_variation_settings_fields']);

		/**
		 * Showing extra column in the orders table
		 */
		add_filter('manage_edit-shop_order_columns', [$this, 'add_column_in_order_listing_page'], 10, 1);
		add_action('manage_shop_order_posts_custom_column', [$this, 'set_column_val_in_order_listing_page'], 10, 1);


		/**
		 * Backorder user notice
		 */
		add_filter('woocommerce_get_availability_text', [$this, 'change_backorder_user_notice'], 10, 2);


		/**
		 * Check backorder item in the cart
		 *
		 */
		add_action('woocommerce_check_cart_items', [$this, 'check_for_backorder_items']);


		/**
		 * Add meta to order item
		 *
		 */
		add_action('woocommerce_checkout_create_order_line_item', [$this, 'add_item_meta'], 99, 4);


		/**
		 * Add to cart validation
		 *
		 * woocommerce_add_to_cart_validation
		 */
		add_filter('woocommerce_add_to_cart_validation', [$this, 'validate_backorder_before_adding_into_cart'], 10, 5);

		/**
		 * Backorder message
		 */
		//add_filter( 'woocommerce_cart_item_backorder_notification', 'custom_cart_item_backorder_notification', 10, 2 );
		//add_filter( 'woocommerce_cart_item_product_id', 'filter_woocommerce_cart_item_product_id', 10, 3 );
		//https://stackoverflow.com/questions/67502909/replace-backorder-notification-with-number-of-backorders-for-each-cart-item-on-w


		// common functionality
		(new Item_Meta_Format())->init();
	}

	private function notice_for_can_buy($can_buy, $product) {

		if($can_buy <= 0) {

			$msg = esc_html__('Sorry, "%s" has reached its max back-order limit.', 'shopengine-pro');

			wc_add_notice(
				sprintf('<strong>' . $msg . '</strong>', $product->get_title()),
				'error'
			);

		} else {

			$msg = esc_html__('"%s" is on back-order, you can add maximum %d in your cart', 'shopengine-pro');

			wc_add_notice(
				sprintf('<strong>' . $msg . '</strong>', $product->get_title(), intval($can_buy)),
				'error'
			);
		}
	}

	public function validate_backorder_before_adding_into_cart($passed, $pid, $qty, $variation_id = '', $variations = '') {

		$product = wc_get_product($pid);

		if ( !$product ) {
		    return $passed ;
        }

		$stock   = $product->get_stock_quantity();

		if($product->is_type('simple') && $product->is_on_backorder($qty)) {

			if($product->managing_stock()) {
				$max = $this->get_max_limit($pid, '_backorder_max_limit');

				$can_buy   = $max + $stock;
				$available = $can_buy - $qty;

				if($available < 0) {

					$this->notice_for_can_buy($can_buy, $product);

					//$passed = false;

					return false;
				}

				//$passed = true;

				return true;
			}

			// not managing but on backorder, no quantity is defined
			// example cap

			$old_ordered_quantity = 0;
			$res                  = $this->get_orders_by_product_id($pid, true);

			if(!empty($res)) {
				$res3 = $this->get_backorder_qty_from_metas_by_orders($res, true, 'shopengine_backordered_qty');

				$old_ordered_quantity = empty($res3) ? 0 : intval($res3[0]);
			}

			$max     = $this->get_max_limit($pid, '_backorder_max_limit');
			$can_buy = $max - $old_ordered_quantity;
			$new_qty = $old_ordered_quantity + $qty;

			$available = $max - $new_qty;

			if($available < 0) {

				$this->notice_for_can_buy($can_buy, $product);

				//$passed = false;

				return false;
			}

			//$passed = true;

			return true;
		}

		/**
		 * Checking for variable product
		 *
		 * Just for learning
		 *
		 * $product->is_type('variable')
		 * $product->get_type()
		 *
		 */
		if($product->is_type('variable')) {

			$v_product = wc_get_product($variation_id);

			if ( !$v_product ) {
				return $passed ;
			}

			/**
			 * If parent is managing the stock...
			 *
			 */
			if($product->managing_stock()) {

				if($v_product->managing_stock() === true) {

					/**
					 * Parent: managing, child: managing
					 *
					 * We will check if child is on backorder...
					 *
					 *  $v_product->managing_stock() -> parent
					 *  $v_product->managing_stock() -> true
					 */

					$stock = $v_product->get_stock_quantity();

					if($v_product->is_on_backorder($qty)) {

						$max = $this->get_max_limit($variation_id, $this->field_names['variation_max_limit']);

						$can_buy   = $max + $stock;
						$available = $can_buy - $qty;

						if($available < 0) {

							$this->notice_for_can_buy($can_buy, $product);

							return false;
						}

						return true;
					}

					return true;
				}

				/**
				 * Parent: managing, child: not managing
				 */

				$stock = $product->get_stock_quantity();

				if($product->is_on_backorder($qty)) {

					$max = $this->get_max_limit($pid, '_backorder_max_limit');

					$can_buy   = $max + $stock;
					$available = $can_buy - $qty;

					if($available < 0) {

						$this->notice_for_can_buy($can_buy, $product);

						//$passed = false;

						return false;
					}

					//$passed = true;

					return true;
				}

				//else

				return true;

			} elseif($v_product->managing_stock()) {

				/**
				 * Parent: not managing, child: managing
				 *
				 * As child is managing we will get the stock qty
				 */

				$stock = $v_product->get_stock_quantity();

				if($v_product->is_on_backorder($qty)) {

					$max = $this->get_max_limit($variation_id, $this->field_names['variation_max_limit']);

					$can_buy   = $max + $stock;
					$available = $can_buy - $qty;

					if($available < 0) {

						$this->notice_for_can_buy($can_buy, $product);

						//$passed = false;

						return false;
					}

					//$passed = true;

					return true;
				}

				return true;

			}


			/**
			 * Parent: not managing, child: not managing
			 *
			 * Child is on backorder....................
			 */

			if($v_product->is_on_backorder($qty)) {

				$old_ordered_qty = 0;
				$results_order   = $this->get_orders_by_variation_id($variation_id, true);

				if(!empty($results_order)) {

					$results_qty     = $this->get_backorder_qty_from_metas_by_orders($results_order, true, 'shopengine_backordered_qty');
					$old_ordered_qty = empty($results_qty) ? 0 : intval($results_qty[0]);
				}

				$max     = $this->get_max_limit($variation_id, $this->field_names['variation_max_limit']);
				$can_buy = $max - $old_ordered_qty;
				$new_qty = $old_ordered_qty + $qty;

				$available = $max - $new_qty;

				if($available < 0) {

					$this->notice_for_can_buy($can_buy, $product);

					return false;
				}

				return true;
			}

			return true;
		}


		return $passed;
	}


	public function variation_settings_fields($loop, $variation_data, $variation) {

	 	echo sprintf('<div id="options_group_variation%s">',esc_attr($loop));

		/**
		 * Value : 0>= global; 0< given quantity ;
		 * Global value :  0> unlimited ; 0<= :D
		 */
		woocommerce_wp_text_input(
			[
				'id'            => $this->field_names['variation_max_limit'] . $loop,
				'name'          => $this->field_names['variation_max_limit'] . "[$loop]",
				'label'         => esc_html__('Max backorder limit', 'shopengine-pro'),
				'placeholder'   => 'Blank/Less than 0 : global; 0< given quantity ;',
				'value'         => get_post_meta($variation->ID, $this->field_names['variation_max_limit'], true),
				'desc_tip'      => 'true',
				'description'   => esc_html__('Maximum number of back-order allowed', 'shopengine-pro'),
				'wrapper_class' => 'form-row form-row-first',
			]
		);

		$this->woo_wp_date_picker_input(
			[
				'id'            => $this->field_names['variation_avl_date'] . $loop,
				'name'          => $this->field_names['variation_avl_date'] . "[$loop]",
				'label'         => esc_html__('Available date', 'shopengine-pro'),
				'placeholder'   => 'Product availability date',
				'value'         => get_post_meta($variation->ID, $this->field_names['variation_avl_date'], true),
				'desc_tip'      => 'true',
				'description'   => esc_html__('When the product will be available for shipment', 'shopengine-pro'),
				'wrapper_class' => 'form-row form-row-last',
			]
		);

		echo '</div>';
	}

	public function save_variation_settings_fields($variation_id, $loop) {
		check_ajax_referer('save-variations','security');
		$dt = empty($_POST[$this->field_names['variation_avl_date']][$loop]) ? '' :
			date('Y-m-d', strtotime(sanitize_text_field(wp_unslash($_POST[$this->field_names['variation_avl_date']][$loop]))));

		/*
		 * Blank : use global
		 * Negative( 0>): unlimited
		 * Positive (0<=) : :D
		 */
		if(isset($_POST[$this->field_names['variation_max_limit']][$loop])){
			$max = strlen(sanitize_text_field(wp_unslash($_POST[$this->field_names['variation_max_limit']][$loop]))) <= 0 ? '' : intval(sanitize_text_field(wp_unslash($_POST[$this->field_names['variation_max_limit']][$loop])));
		}
		update_post_meta($variation_id, $this->field_names['variation_max_limit'], $max);
		update_post_meta($variation_id, $this->field_names['variation_avl_date'], $dt);
	}

	public function load_variation_settings_fields($variation) {

		$variation[$this->field_names['variation_max_limit']] = get_post_meta($variation['variation_id'], $this->field_names['variation_max_limit'], true);
		$variation[$this->field_names['variation_avl_date']]  = get_post_meta($variation['variation_id'], $this->field_names['variation_avl_date'], true);

		return $variation;
	}


	public function add_item_meta($item, $cart_item_key, $values, $order) {

		$item_obj = $values['data'];

		if($item_obj->is_on_backorder($values['quantity'])) {
			$item->add_meta_data('shopengine_is_backordered', 'yes', true);
			$item->add_meta_data('shopengine_backordered_qty', intval($values['quantity']), true);
		}
	}

	private function can_be_bought($quantity) {

		return true;
	}

	public function get_max_backorder_quantity($product_id) {

		$max = get_post_meta($product_id, '_backorder_max_limit', true);

		$unlimited = 999999;

		if($max === '') {

			$g_max = $this->global_settings['backorder']['backorder_availability_max_limit'];

			if(empty($g_max)) {
				return 0;
			}

			if($g_max < 0) {
				return $unlimited;
			}

			return intval($g_max);
		}

		if($max < 0) {

			return $unlimited;
		}

		return intval($max);
	}

	public function get_backorder_available_date($product_id) {

		return $this->get_backorder_avl_date($product_id, '_backorder_available_date');
	}

	public function get_backorder_variation_available_date($product_id) {

		return $this->get_backorder_avl_date($product_id, $this->field_names['variation_avl_date']);
	}

	public function get_backorder_avl_date($product_id, $meta_field) {

		$date = get_post_meta($product_id, $meta_field, true);

		if(empty($date)) {

			$date = $this->global_settings['backorder']['backorder_availability_date'];
		}

		$format = 'M d, Y';

		return empty($date) ? esc_html__('soon', 'shopengine-pro') : date($format, strtotime($date));
	}

	public function check_for_backorder_items() {

		if(is_cart() || is_checkout()) {

			foreach(WC()->cart->get_cart() as $cart_item) {

				$item_obj = $cart_item['data'];

				$max_allowed_in_backorder = $this->get_max_backorder_quantity($item_obj->get_id());

				if($item_obj->is_on_backorder($cart_item['quantity'])) {

					$current_quantity = $item_obj->get_stock_quantity();

					$new_stock = $current_quantity - $cart_item['quantity'];
					$available = $max_allowed_in_backorder + $new_stock;
					$can_buy   = $max_allowed_in_backorder + $current_quantity;

					if($available < 0) {

						if($can_buy > 0) {

							$msg = esc_html__('"%s" is on backorder, you can add maximum %d in your cart', 'shopengine-pro');

							wc_add_notice(
								sprintf('<strong>' . $msg . '</strong>', $item_obj->get_title(), intval($can_buy)),
								'error'
							);

						} else {
							$msg = esc_html__('Sorry, "%s" is out of stock, please remove it from your cart.', 'shopengine-pro');

							// todo - we should update the product status as out of stock from here too.

							wc_add_notice(
								sprintf('<strong>' . $msg . '</strong>', $item_obj->get_title(), intval($can_buy)),
								'error'
							);
						}
					}

					break;
				}
			}
		}
	}

	public function add_column_in_order_listing_page($columns) {

		$tot = $columns['order_total'];
		$act = $columns['wc_actions'];

		unset($columns['order_total'], $columns['wc_actions']);

		$columns['order_page_order_type'] = esc_html__('Order type', 'shopengine-pro');

		$columns['order_total'] = $tot;
		$columns['wc_actions']  = $act;

		return $columns;
	}

	public function set_column_val_in_order_listing_page($column) {

		global $the_order;

		if($column == 'order_page_order_type') {

			$items = $the_order->get_items();

			$is_backordered = false;
			$items_count    = 0;
			$items_total    = count($items);
			$msg            = '';

			foreach($items as $item) {

				if($item->get_meta('shopengine_is_backordered', true) === 'yes') {

					$is_backordered = true;
					$qty            = $item->get_meta('shopengine_backordered_qty', true);
					$items_count    += $qty;
					$msg            .= '<br> ' . $qty . 'X ' . $item->get_name();

					/**
					 * For learning purpose only, delete later
					 *
					 * $item->get_quantity()
					 * $item->get_name()
					 * $the_order->get_item_count()
					 *
					 */
				} elseif($item['Backordered']) {
					// pre module data.... need rigorous testing for this condition
					$is_backordered = true;
					$items_count    += $item['Backordered'];
					$msg            .= '<br> -> ' . $item['Backordered'] . ' of "' . $item->get_name() . '"';
				}
			}

			if($is_backordered) {
				echo sprintf('<strong class="shopengine-partial-payment-product-badge">%s</strong>', esc_html__('On Back-Order', 'shopengine-pro') );
				echo wp_kses($msg, \ShopEngine_Pro\Util\Helper::get_kses_array());
			}
		}
	}

	public function add_stock_option_for_backorder() {

		global $thepostid;

		$product = new \WC_Product($thepostid);
		$cls     = $product->get_stock_status() !== 'onbackorder' ? 'shopengine-dno' : '';

		echo '<div id="_backorder_option_grp_parent" class="options_group ' . esc_attr($cls) . '">';

		woocommerce_wp_text_input(
			[
				'id'          => '_backorder_max_limit',
				'label'       => esc_html__('Max back-order limit', 'shopengine-pro'),
				'placeholder' => 'Blank/Less than 0 : global; 0 < given quantity',
				'desc_tip'    => 'true',
				'description' => esc_html__('Maximum number of back-order allowed', 'shopengine-pro'),
			]
		);

		$this->woo_wp_date_picker_input(
			[
				'id'          => '_backorder_available_date',
				'label'       => esc_html__('Available date', 'shopengine-pro'),
				'placeholder' => 'Product availability date',
				'desc_tip'    => 'true',
				'description' => esc_html__('When the product will be available for shipment', 'shopengine-pro'),
			]
		);

		echo '</div>';
	}

	public function save_custom_backorder_fields($product_id, $post) {

		$dt = empty(sanitize_text_field(wp_unslash($_POST['_backorder_available_date']))) ? '' : date('Y-m-d', strtotime(sanitize_text_field(wp_unslash($_POST['_backorder_available_date']))));

		/*
		 * Blank : use global
		 * Negative( 0>): unlimited
		 * Positive (0<=) : :D
		 */
		if(isset($_POST['_backorder_max_limit']) &&
			isset($_POST['_wpnonce']) &&
			isset($_POST['post_ID']) && 
			wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['_wpnonce'])),'update-post_'.sanitize_text_field(wp_unslash($_POST['post_ID'])))){
			$max = strlen(trim(sanitize_text_field(wp_unslash($_POST['_backorder_max_limit'])))) <= 0 ? '' : intval(sanitize_text_field(wp_unslash($_POST['_backorder_max_limit'])));
		}

		update_post_meta($product_id, '_backorder_max_limit', $max);
		update_post_meta($product_id, '_backorder_available_date', $dt);
	}

	public function has_reached_max_limit_variation($pid, $current_stock) {

		return $this->has_reached_max($pid, $current_stock, $this->field_names['variation_max_limit']);
	}

	public function has_reached_max_limit($pid, $current_stock) {

		return $this->has_reached_max($pid, $current_stock, '_backorder_max_limit');
	}

	public function has_reached_max($pid, $current_stock, $meta_field) {

		/**
		 * Value : 0>= global; 0< given quantity ;
		 * Global value :  0> unlimited ; 0<= :D
		 *
		 */
		$limit = get_post_meta($pid, $meta_field, true);
		$limit = intval($limit);

		if($limit <= 0) {

			//global limit is in effect

			$limit = $this->global_settings['backorder']['backorder_availability_max_limit'];

			if($limit < 0) {
				return false;
			}

			// $current_stock = 1 ; $limit = 0; = 1
			// $current_stock = 0 ; $limit = 0; = 0
			// $current_stock = -1 ; $limit = 0; = -1
			// $current_stock = -6 ; $limit = 0; = -6
			$new_stock = $current_stock + $limit;

			return $new_stock <= 0;

		}

		// $current_stock = 1 ; $limit = 4; = 5
		// $current_stock = -3 ; $limit = 4; = 1
		// $current_stock = -4 ; $limit = 4; = 0
		// $current_stock = -6 ; $limit = 4; = -2
		$new_stock = $current_stock + $limit;

		return $new_stock <= 0;
	}

	public function get_max_limit($pid, $meta_field) {

		/**
		 * Value : 0>= global; 0< given quantity ;
		 * Global value :  0> unlimited ; 0<= :D
		 *
		 */
		$limit = get_post_meta($pid, $meta_field, true);
		$limit = intval($limit);

		if($limit <= 0) {

			//global limit is in effect
			$unlimited = 999999;
			$limit     = $this->global_settings['backorder']['backorder_availability_max_limit'];

			return $limit < 0 ? $unlimited : $limit;
		}

		return $limit;
	}


	public function change_backorder_user_notice($text, $product) {

		$pid = $product->get_id();
		$qty = $product->get_stock_quantity();

		if($product->is_type('variation')) {

			if($product->managing_stock() === true) {

				/**
				 * Parent: managing/not managing, variation: managing, stock: on backorder, qty: int
				 *
				 */

				if($product->is_on_backorder(1)) {

					if($this->has_reached_max_limit_variation($pid, $qty)) {

						$text = esc_html__('Out of stock.', 'shopengine-pro');

						//change the stock status.
						//$new_stock = wc_update_product_stock($pid, $qty, 'set', false);
						//wc_delete_product_transients($pid);

					} else {

						$dt = $this->get_backorder_variation_available_date($product->get_id());

						$text = esc_html__('On Back-Order Only, Will be Available On: ', 'shopengine-pro') . $dt;
					}
				}

			} elseif($product->managing_stock() === 'parent') {

				/**
				 * Parent: managing, variation: not managing, stock: on backorder, qty: int
				 *
				 */

				if($product->is_on_backorder(1)) {

					if($this->has_reached_max_limit($product->get_parent_id(), $qty)) {

						$text = esc_html__('Out of stock.', 'shopengine-pro');

						//change the stock status.
						//$new_stock = wc_update_product_stock($pid, $qty, 'set', false);
						//wc_delete_product_transients($pid);

					} else {

						$dt = $this->get_backorder_available_date($product->get_parent_id());

						$text = esc_html__('On Back-Order Only, Will be Available On: ', 'shopengine-pro') . $dt;
					}
				}

			} else {

				/**
				 * Parent: not managing, variation: not managing, stock: on backorder, qty: null
				 */
				if($product->is_on_backorder(1)) {

					$dt = $this->get_backorder_variation_available_date($product->get_id());

					$text = esc_html__('On Back-Order Only, Will be Available On: ', 'shopengine-pro') . $dt;
				}
			}

		} else {

			// simple product and so on...

			if($product->is_on_backorder(1)) {

				$dt = $this->get_backorder_available_date($product->get_id());

				$text = esc_html__('On Back-Order Only, Will be Available On: ', 'shopengine-pro') . $dt;
			}
		}

		// parent: false -> child false :: false
		// parent: true  -> child false :: true
		// parent: false -> child true :: true
		// parent: true  -> child true :: true

		return $text;
	}

	public function enqueue() {
		wp_enqueue_style('shopengine-backorder', \ShopEngine_Pro::module_url() . 'back-order/assets/css/back-order.css');
		wp_enqueue_script('shopengine-backorder', \ShopEngine_Pro::module_url() . 'back-order/assets/js/back-order.js', ['jquery']);
	}

	public function admin_enqueue() {
		wp_enqueue_style('shopengine-backorder-admin', \ShopEngine_Pro::module_url() . 'back-order/assets/css/back-order-admin.css');
		wp_enqueue_script('shopengine-backorder-admin', \ShopEngine_Pro::module_url() . 'back-order/assets/js/back-order-admin.js', ['jquery']);

		wp_localize_script('shopengine-backorder-admin', 'shopEngineBackorder', [
			'resturl'    => get_rest_url(),
			'rest_nonce' => wp_create_nonce('wp_rest'),
		]);
	}

	private function woo_wp_date_picker_input($field) {

		global $thepostid;

		$field['type']          = 'date';
		$field['name']          = isset($field['name']) ? $field['name'] : $field['id'];
		$field['wrapper_class'] = isset($field['wrapper_class']) ? $field['wrapper_class'] : '';
		$field['class']         = isset($field['class']) ? $field['class'] : 'short';
		$field['style']         = isset($field['style']) ? $field['style'] : '';
		$field['value']         = isset($field['value']) ? $field['value'] : get_post_meta($thepostid, $field['id'], true);


		echo '<p class="form-field ' . esc_attr($field['id']) . '_field ' . esc_attr($field['wrapper_class']) . '">
		
		<label for="' . esc_attr($field['id']) . '">' . wp_kses_post($field['label']) . '</label>'; ?>

        <input type="date"
               name="<?php echo esc_attr($field['name']) ?>"
               id="<?php echo esc_attr($field['id']) ?>"
               value="<?php echo esc_attr($field['value']) ?>"
               class="<?php echo esc_attr($field['class']) ?>"
               style="<?php echo esc_attr($field['style']) ?>"
               data-date="<?php echo esc_attr($field['value']) ?>"/>

		<?php

		if(!empty($field['description']) && false !== $field['desc_tip']) {
			echo wp_kses_post(wc_help_tip($field['description']));
		}

		if(!empty($field['description']) && false === $field['desc_tip']) {
			echo '<span class="description">' . wp_kses_post($field['description']) . '</span>';
		}

		echo '</p>';
	}


	/**
	 * Get All orders IDs for a given product ID.
	 * Copied from https://stackoverflow.com/questions/45848249/woocommerce-get-all-orders-for-a-product
	 *
	 * $statuses = array( 'wc-completed', 'wc-processing', 'wc-on-hold' );
	 *
	 * @param integer $product_id (required)
	 * @param array $order_status (optional) Default is 'wc-completed'
	 *
	 * @return array
	 */
	function get_orders_ids_by_product_id($product_id, $order_status = ['wc-completed']) {
		global $wpdb;

		$results = $wpdb->get_col($wpdb->prepare("
        SELECT order_items.order_id
        FROM {$wpdb->prefix}woocommerce_order_items as order_items
        LEFT JOIN {$wpdb->prefix}woocommerce_order_itemmeta as order_item_meta ON order_items.order_item_id = order_item_meta.order_item_id
        LEFT JOIN {$wpdb->posts} AS posts ON order_items.order_id = posts.ID
        WHERE posts.post_type = 'shop_order'
        AND posts.post_status IN ( ".implode(', ', array_fill(0, count($order_status), '%s'))." )
        AND order_items.order_item_type = 'line_item'
        AND order_item_meta.meta_key = '_product_id'
        AND order_item_meta.meta_value = %d
    ",array_merge($order_status,array($product_id))));

		return $results;
	}

	function get_orders_by_product_id($product_id, $exclude = false, $exclude_status = ['wc-completed']) {
		global $wpdb;

		if($exclude === true) {

			$results = $wpdb->get_col($wpdb->prepare("SELECT order_items.order_id
        FROM {$wpdb->prefix}woocommerce_order_items as order_items
        LEFT JOIN {$wpdb->prefix}woocommerce_order_itemmeta as order_item_meta ON order_items.order_item_id = order_item_meta.order_item_id
        LEFT JOIN {$wpdb->posts} AS posts ON order_items.order_id = posts.ID
        WHERE posts.post_type = 'shop_order'
        AND posts.post_status NOT IN ( ".implode(', ', array_fill(0, count($exclude_status), '%s'))." )
        AND order_items.order_item_type = 'line_item'
        AND order_item_meta.meta_key = '_product_id'
        AND order_item_meta.meta_value = %d",array_merge($exclude_status,array($product_id))));

		} else {

			$results = $wpdb->get_col($wpdb->prepare("SELECT order_items.order_id
        FROM {$wpdb->prefix}woocommerce_order_items as order_items
        LEFT JOIN {$wpdb->prefix}woocommerce_order_itemmeta as order_item_meta ON order_items.order_item_id = order_item_meta.order_item_id
        LEFT JOIN {$wpdb->posts} AS posts ON order_items.order_id = posts.ID
        WHERE posts.post_type = 'shop_order'
        AND posts.post_status IN ( ".implode(', ', array_fill(0, count($exclude_status), '%s'))." )
        AND order_items.order_item_type = 'line_item'
        AND order_item_meta.meta_key = '_product_id'
        AND order_item_meta.meta_value = %d",array_merge($exclude_status,array($product_id))));
		}

		return $results;
	}

	function get_orders_by_variation_id($variation_id, $exclude = false, $exclude_status = ['wc-completed']) {

		global $wpdb;

		if($exclude === true) {

			$results = $wpdb->get_col($wpdb->prepare("SELECT order_items.order_id
        FROM {$wpdb->prefix}woocommerce_order_items as order_items
        LEFT JOIN {$wpdb->prefix}woocommerce_order_itemmeta as order_item_meta ON order_items.order_item_id = order_item_meta.order_item_id
        LEFT JOIN {$wpdb->posts} AS posts ON order_items.order_id = posts.ID
        WHERE posts.post_type = 'shop_order'
        AND posts.post_status NOT IN ( ".implode(', ', array_fill(0, count($exclude_status), '%s'))."  )
        AND order_items.order_item_type = 'line_item'
        AND order_item_meta.meta_key = '_variation_id'
        AND order_item_meta.meta_value = %d",array_merge($exclude_status,array($variation_id))));

		} else {

			$results = $wpdb->get_col($wpdb->prepare("SELECT order_items.order_id
        FROM {$wpdb->prefix}woocommerce_order_items as order_items
        LEFT JOIN {$wpdb->prefix}woocommerce_order_itemmeta as order_item_meta ON order_items.order_item_id = order_item_meta.order_item_id
        LEFT JOIN {$wpdb->posts} AS posts ON order_items.order_id = posts.ID
        WHERE posts.post_type = 'shop_order'
        AND posts.post_status IN ( ".implode(', ', array_fill(0, count($exclude_status), '%s'))."  )
        AND order_items.order_item_type = 'line_item'
        AND order_item_meta.meta_key = '_variation_id'
        AND order_item_meta.meta_value = %d",array_merge($exclude_status,array($variation_id))));
		}

		return $results;
	}

	function get_order_item_metas_by_orders($order_ids = [], $with_like = false, $like_val = '') {

		global $wpdb;

		$results = $wpdb->get_results($wpdb->prepare("
		SELECT ord_item_meta.*, ord_item.order_id 
		FROM {$wpdb->prefix}woocommerce_order_itemmeta AS ord_item_meta 
		LEFT JOIN {$wpdb->prefix}woocommerce_order_items AS ord_item ON ord_item.order_item_id = ord_item_meta.order_item_id 
		WHERE ord_item.order_id IN(".implode(', ', array_fill(0, count($order_ids), '%s')).") 
		",$order_ids));

		if($with_like === true) {

			$results = $wpdb->get_results($wpdb->prepare("
			SELECT ord_item_meta.*, ord_item.order_id 
			FROM {$wpdb->prefix}woocommerce_order_itemmeta AS ord_item_meta 
			LEFT JOIN {$wpdb->prefix}woocommerce_order_items AS ord_item ON ord_item.order_item_id = ord_item_meta.order_item_id 
			WHERE ord_item.order_id IN(".implode(', ', array_fill(0, count($order_ids), '%s')).") 
			AND ord_item_meta.meta_key LIKE %s
			",array_merge($order_ids,array($like_val))));

		}

		return $results;
	}

	function get_backorder_qty_from_metas_by_orders($order_ids = [], $with_like = false, $like_val = '_qty') {

		global $wpdb;

		$results = $wpdb->get_col($wpdb->prepare("
		SELECT SUM(ord_item_meta.meta_value) as total 
		FROM {$wpdb->prefix}woocommerce_order_itemmeta AS ord_item_meta 
		LEFT JOIN {$wpdb->prefix}woocommerce_order_items AS ord_item ON ord_item.order_item_id = ord_item_meta.order_item_id 
		WHERE ord_item.order_id IN(".implode(', ', array_fill(0, count($order_ids), '%s')).") 
		",$order_ids));

		if($with_like === true) {

			$results = $wpdb->get_col($wpdb->prepare("
			SELECT SUM(ord_item_meta.meta_value) as total 
			FROM {$wpdb->prefix}woocommerce_order_itemmeta AS ord_item_meta 
			LEFT JOIN {$wpdb->prefix}woocommerce_order_items AS ord_item ON ord_item.order_item_id = ord_item_meta.order_item_id 
			WHERE ord_item.order_id IN(".implode(', ', array_fill(0, count($order_ids), '%s')).") 
			AND ord_item_meta.meta_key LIKE %s
			",array_merge($order_ids,array($like_val))));
		}

		return $results;

		//$ret = $wpdb->get_col($qry);
		//return $ret;
	}
}

