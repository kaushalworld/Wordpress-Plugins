<?php

namespace ShopEngine_Pro\Modules\Pre_Order\Admin;

use ShopEngine\Modules\Swatches\Swatches;
use ShopEngine_Pro;
use ShopEngine_Pro\Modules\Pre_Order\Settings\Helper;
use ShopEngine_Pro\Modules\Pre_Order\Settings\Pre_Order_Settings;
use WC_Product;

defined( 'ABSPATH' ) || exit;

class Pre_Order_Admin_Fields {

	/**
	 * Pre_Order_Settings object
	 */
	private $settings;

	public function __construct( Pre_Order_Settings $settings ) {
		$this->settings = $settings;
		$this->init();
	}


	public function init() {


 		add_action('woocommerce_product_options_stock_status', [$this, 'partial_payment_data_panel' ]);


		/**
         * variant product hooks
         */
		add_action('woocommerce_product_after_variable_attributes', [$this, 'partial_payment_data_panels_for_variant'], 10, 100);
	}




	public function partial_payment_data_panels_for_variant($loop, $variation_data, $variation) {
		$this->settings->product_id = $variation->ID;

		$this->partial_payment_fields($loop, $variation_data, $variation);
    }


	public function partial_payment_data_panel() {
		global $post;
		$this->settings->product_id = $post->ID;
	   $this->partial_payment_fields();
	}



	public function partial_payment_fields($loop = null, $variation_data = null, $variation = null) {

		?>
        <div id="shopengine_pre_order_tab<?php echo esc_attr($loop); ?>"  data-index="<?php echo esc_attr($loop); ?>" >
            <div class="options_group shopengine-pre-order-tab-content care_instruction <?php  echo ( $loop !== null ? ' variable-product' : '' ) ?>" >

				<?php
                $loop_status = !( $loop === null );
                $this->settings->set_product( $this->settings->product_id, ( $variation ? true : false ) ) ;

				$status_value  = $this->settings->product->get_stock_status();
				$wrapper_class = $status_value == 'pre_order' ? "" : "se-hidden";

				woocommerce_wp_text_input( [
					'id'            => 'shopengine_pre_order_max_order'.$loop,
					'name'            => 'shopengine_pre_order_max_order' .($loop_status ? '['.$loop.']' : '' ),
					'data_type'     => "decimal",
					'label'         => esc_html__( 'Allow Maximum Order', 'shopengine-pro' ),
					'placeholder'   => "Allow Maximum Order ",
					'value'         => $this->settings->get_max_order(),
					'wrapper_class' => $wrapper_class . ' se-hidden-field',
					'custom_attributes' => [
						"data-required" => "required"
					]
				] );

				Helper::wc_date_picker_field( [
					'id'            => 'shopengine_pre_order_available_date'.$loop,
					'name'            => 'shopengine_pre_order_available_date' .($loop_status ? '['.$loop.']' : '' ),
					'label'         => esc_html__( 'Available On', 'shopengine-pro' ),
					'value'         => $this->settings->get_available_date(),
					'wrapper_class' => $wrapper_class . ' se-hidden-field',
					'custom_attributes' => [
						"data-required" => "required"
					]
				] );

				woocommerce_wp_text_input( [
					'id'            => 'shopengine_pre_order_price'.$loop,
					'name'            => 'shopengine_pre_order_price' .($loop_status ? '['.$loop.']' : '' ),
					'data_type'     => "decimal",
					'label'         => esc_html__( 'Pre-Order Price', 'shopengine-pro' ),
					'placeholder'   => "Pre-Order Price",
					'value'         => $this->settings->get_price(),
					'wrapper_class' => $wrapper_class . ' se-hidden-field',
				] );


				woocommerce_wp_text_input( [
					'id'            => 'shopengine_pre_order_product_message'.$loop,
					'name'            => 'shopengine_pre_order_product_message' .($loop_status ? '['.$loop.']' : '' ),
					'label'         => esc_html__( 'Pre-Order Product Message', 'shopengine-pro' ),
					'placeholder'   => "Pre-Order Product Message",
					'value'         => $this->settings->get_product_message(),
					'wrapper_class' => $wrapper_class . ' se-hidden-field',
				] );

				woocommerce_wp_checkbox( [
					'id'          => 'shopengine_pre_order_auto_convert'.$loop,
					'name'        => 'shopengine_pre_order_auto_convert' .($loop_status ? '['.$loop.']' : '' ),
					'label'       => esc_html__( 'Auto Convert to Standard Product After Available Date', 'shopengine-pro' ),
					'value'       => get_post_meta( $this->settings->product_id , 'shopengine_pre_order_auto_convert', true ) ?? "no",
					'description' => esc_html__( 'Enable', 'shopengine-pro' ),
					'wrapper_class' => $wrapper_class . ' se-hidden-field',
				] );


				?>
            </div>
        </div>
		<?php
	}


}
