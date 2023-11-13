<?php

namespace ShopEngine_Pro\Modules\Partial_Payment\Admin;

use ShopEngine\Traits\Singleton;
use ShopEngine_Pro;
use ShopEngine_Pro\Modules\Partial_Payment\Settings\Partial_Payment_Data;

defined( 'ABSPATH' ) || exit;

class Partial_Payment_Admin extends Partial_Payment_Data {
	use Singleton;

	public function init() {

		$this->currency = get_woocommerce_currency_symbol();

		// admin hook
		add_action( 'admin_enqueue_scripts', [ $this, 'add_admin_enqueue' ] );
		add_filter( 'woocommerce_product_data_tabs', [ $this, 'partial_payment_tab' ] );
		add_action( 'woocommerce_product_data_panels', [ $this, 'partial_payment_data_panel' ], 100 );
		add_action( 'woocommerce_process_product_meta', [ $this, 'save_partial_payment_product_meta' ] );
		add_action( 'woocommerce_admin_order_totals_after_total', [ $this, 'admin_order_totals_after_total' ] );
		add_action( 'add_meta_boxes', [ $this, 'partial_payments_metabox' ], 31 );

		/**
		 * Showing extra column in the orders table
		 */
		add_filter( 'manage_edit-shop_order_columns', [ $this, 'add_column_in_order_listing_page' ], 10, 1 );
		add_action( 'manage_shop_order_posts_custom_column', [ $this, 'set_order_type_column_value' ], 10, 2 );

		add_action( 'woocommerce_admin_stock_html', [$this,'change_stock_html'], 10, 2 );
	}



	function change_stock_html($stock_html, \WC_Product $product ){
		if ( $product->get_meta( 'shopengine_product_pp_status' ) === 'yes' ) {
			$stock_html .= '<mark class="onbackorder">&#160;'. esc_html__('& Partial Payment', 'shopengine-pro') .'</mark>';
		}

		return $stock_html;
	}


	function partial_payments_metabox() {
		global $post;
		if ( is_null( $post ) ) {
			return;
		}
		$order = wc_get_order( $post->ID );

		if ( $order && $order->get_meta( 'order_partial_payment_status' ) == 'yes' ) {

			$parent_order = $order->get_meta( 'order_partial_payment_parent_order' );

			if ( $order->get_type() == 'pp_installment' ) {
				add_meta_box( 'shopengine_partial_payments_sub',
					esc_html__( 'Main Order', 'shopengine-pro' ),
					array( $this, 'original_order_metabox' ),
					'pp_installment',
					'side',
					'high'
				);

			} else {

				if ( $parent_order == 'yes' ) {
					add_meta_box( 'shopengine_partial_payments',
						esc_html__( 'Partial Payments', 'shopengine-pro' ),
						array( $this, 'partial_payments_summary' ),
						'shop_order',
						'normal',
						'high' );
				}

			}
		}
	}


	function partial_payments_summary() {

		global $post;

		$orders = wc_get_orders( [
			'parent'  => $post->ID,
			'type'    => 'pp_installment',
			'orderby' => 'ID',
			'order'   => 'ASC',
		] );

		$parent_order_id = $post->ID;

		include( PP_TEMPLATE_PATH . 'admin/partial-payments-summery.php' );
	}


	function original_order_metabox() {
		global $post;
		$order = wc_get_order( $post->ID );
		if ( ! $order ) {
			return;
		}

		$parent = wc_get_order( $order->get_parent_id() );

		if ( ! $parent ) {
			return;
		}

		?>
        <p><?php echo sprintf( esc_html__( 'This is a sub-order of %s', 'shopengine-pro' ), esc_html($parent->get_order_number()) ); ?>
        </p>
        <a title="<?php esc_html_e('Edit Order', 'shopengine-pro')?>" class="button btn" href="
                  <?php echo esc_url( $parent->get_edit_order_url() ); ?> "> <?php esc_html_e( 'View', 'shopengine-pro' ); ?> </a>

		<?php
	}


	public function admin_order_totals_after_total( $order_id ) {
		$order = wc_get_order( $order_id );
		if ( $order->get_meta( 'order_partial_payment_status' ) == 'yes' && $order->get_meta( 'order_partial_payment_parent_order' ) == 'yes' ) {

			?>

            <tr>
                <td class="label">
					<?php esc_html_e( 'First Installment', 'shopengine-pro' ); ?>:
                </td>
                <td width="1%"></td>
                <td class="total paid"><?php shopengine_pro_content_render(wc_price( $order->get_meta( 'partial_payment_first_installment' ), array( 'currency' => $order->get_currency() ))); ?></td>

            </tr>

            <tr class="wcdp-remaining">
                <td class="label"><?php esc_html_e( 'Second Installment', 'shopengine-pro' ); ?>:</td>
                <td width="1%"></td>
                <td class="total remaining"><?php shopengine_pro_content_render(wc_price( $order->get_meta( 'partial_payment_second_installment' ), array( 'currency' => $order->get_currency() ))); ?></td>
            </tr>

            <tr class="wcdp-remaining">
                <td class="label"><?php esc_html_e( 'Due', 'shopengine-pro' ); ?>:</td>
                <td width="1%"></td>
                <td class="total remaining"><?php shopengine_pro_content_render(wc_price( $order->get_meta( 'partial_payment_due_amount' ), array( 'currency' => $order->get_currency() ))); ?></td>
            </tr>

			<?php

		}

		return;
	}


	public function add_admin_enqueue() {
		wp_enqueue_style( 'admin-partial-payment-module-css', ShopEngine_Pro::module_url() . 'partial-payment/assets/css/admin-partial-payment.css', [], ShopEngine_Pro::version() );

		wp_enqueue_script( 'partial-payment-admin-js', ShopEngine_Pro::module_url() . 'partial-payment/assets/js/admin-partial-payment.js', [
			'jquery',
		] );
	}


	public function partial_payment_tab( $tabs ) {
		$tabs['partial_payment'] = array(
			'label'    => 'Partial Payment',
			'target'   => 'shopengine_partial_payment_data',
			'priority' => 10,
		);

		return $tabs;
	}

	public function partial_payment_data_panel() {
		global $post;

		$this->product_id = $post->ID
		?>
        <div id="shopengine_partial_payment_data" class="panel woocommerce_options_panel">
            <div class="options_group shopengine-partial-payent-tab-content care_instruction">
				<?php
                $status_value = $this->get_status_value() ;
				$wrapper_class = $status_value == 'yes' ? "" : "se-hidden";
				woocommerce_wp_checkbox( [
					'id'          => 'shopengine_product_pp_status',
					'label'       => esc_html__( 'Partial Payment', 'shopengine-pro' ),
					'value'       => $status_value,
					'description' => esc_html__( 'Enable Partial Payment', 'shopengine-pro' ),
				] );

				woocommerce_wp_select( [
					'id'      => 'shopengine_product_pp_amount_type',
					'label'   => esc_html__( 'Partial Amount Type', 'shopengine-pro' ),
					'options' => [
						'fixed_amount'   => "Fixed",
						'percent_amount' => "Percentage",
					],
					'value'   => $this->get_amount_type_value(),
					'wrapper_class' => $wrapper_class . ' se-hidden-field',
				] );

				woocommerce_wp_text_input( [
					'id'          => 'shopengine_product_pp_amount',
					'label'       => esc_html__( 'Partial Payment Amount', 'shopengine-pro' ),
					'placeholder' => esc_html__( 'Amount', 'shopengine-pro' ),
					'value'       => $this->get_partial_amount_value(),
					'wrapper_class' => $wrapper_class . ' se-hidden-field',
				] );

				?>
                <p> <?php echo esc_html__('Note: Need to disable guest checkout from Woocommerce Settings for Partial Payment', 'shopengine-pro') ?></p>
            </div>
        </div>
		<?php
	}


	public function save_partial_payment_product_meta( $post_id ) {

		$post_ids = [$post_id];

		if(isset($_POST['product-type']) && sanitize_text_field(wp_unslash($_POST['product-type'])) == "grouped"){
			
			$grouped_products_prev = get_post_meta($post_id, '_children', true);
			
			if($grouped_products_prev){

				foreach($grouped_products_prev as $post_id){

					$this->delete_partial_post_meta($post_id);
				}
			}
			
			if(isset($_POST['grouped_products'])){
				$post_ids =  array_merge($post_ids, map_deep( wp_unslash( $_POST['grouped_products'] ), 'sanitize_text_field' ));
			}
		
		}

		if (
			isset( $_POST['shopengine_product_pp_status'] ) && sanitize_text_field( wp_unslash($_POST['shopengine_product_pp_status']) )
			&& isset( $_POST['shopengine_product_pp_amount_type'] ) && sanitize_text_field( wp_unslash($_POST['shopengine_product_pp_amount_type']))
			&& isset( $_POST['shopengine_product_pp_amount'] ) && (float) sanitize_text_field(wp_unslash($_POST['shopengine_product_pp_amount']))
			&& isset( $_POST['woocommerce_meta_nonce'] ) 
			&& wp_verify_nonce( sanitize_key( $_POST['woocommerce_meta_nonce'] ), 'woocommerce_save_data' )
		) {

			foreach($post_ids as $post_id){

				update_post_meta(
					$post_id,
					'shopengine_product_pp_status',
					sanitize_text_field(wp_unslash($_POST['shopengine_product_pp_status']))
				);
	
				update_post_meta(
					$post_id,
					'shopengine_product_pp_amount_type',
					sanitize_text_field(wp_unslash($_POST['shopengine_product_pp_amount_type']))
				);
	
				update_post_meta(
					$post_id,
					'shopengine_product_pp_amount',
					(float) $_POST['shopengine_product_pp_amount']
				);
			}
			
		} else {

			foreach($post_ids as $post_id){

				$this->delete_partial_post_meta($post_id);
			}

			return false;
		}
	}

	/**
	 * delete post meta
	 * 
	 * @param int
	 * 
	 * @return void
	 */
	public function delete_partial_post_meta($post_id){

		delete_post_meta( $post_id, 'shopengine_product_pp_status' );
		delete_post_meta( $post_id, 'shopengine_product_pp_amount_type' );
		delete_post_meta( $post_id, 'shopengine_product_pp_amount' );
	}

	public function add_column_in_order_listing_page( $columns ) {

		if ( ! isset( $columns['order_page_order_type'] ) ) {

			$order_total = $columns['order_total'];
			$wc_actions  = $columns['wc_actions'];
			unset( $columns['order_total'], $columns['wc_actions'] );

			$columns['order_page_order_type'] = esc_html__( 'Order Type', 'shopengine-pro' );
			$columns['order_total']           = $order_total;
			$columns['wc_actions']            = $wc_actions;

		}

		return $columns;
	}

	public function set_order_type_column_value( $column ) {

		global $the_order;

		if ( $column == 'order_page_order_type' && $the_order->get_meta( 'order_partial_payment_status' ) == 'yes' ) {
			echo "<span class='shopengine-partial-payment-product-badge' >". esc_html__( "Partial Payment", "shopengine-pro" )."</span>";
		}
	}
}
