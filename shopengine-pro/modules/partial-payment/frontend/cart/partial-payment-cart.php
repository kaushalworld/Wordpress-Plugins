<?php

namespace ShopEngine_Pro\Modules\Partial_Payment\Frontend\Cart;

use ShopEngine_Pro\Modules\Partial_Payment\Settings\Partial_Payment_Data;

defined( 'ABSPATH' ) || exit;

class Partial_Payment_Cart {

	/**
	 * instance of Partial_Payment_Data() object;
	 * @var
	 */
	private $data;


	private $exist_in_cart_message;

	/**
	 * Partial_Payment_Cart constructor.
	 *
	 */
	public function __construct() {
		$this->data = Partial_Payment_Data::instance();
	}


	public function init() {

		add_action( 'woocommerce_after_add_to_cart_button', [ $this, 'add_partial_payment_content' ], 0, 3 );

		add_filter( 'woocommerce_add_cart_item_data', [ $this, 'add_partial_payment_to_cart' ], 10, 3 );

		add_filter( 'woocommerce_cart_item_price', [ $this, 'change_cart_item_price_content' ], 10, 3 );

		add_filter( 'woocommerce_cart_item_subtotal', [ $this, 'update_cart_item_subtotal' ], 10, 3 );

		add_action( 'woocommerce_cart_totals_after_order_total', [ $this, 'add_html_to_cart_summery_table' ] );

		add_action( 'woocommerce_loop_add_to_cart_link', [ $this, 'add_cart_button_text_change2' ], 30, 3 );
		add_action( 'woocommerce_product_add_to_cart_text', [ $this, 'add_cart_button_text_change' ], 30, 2 );

		add_filter( 'woocommerce_cart_item_name', [ $this, 'woocommerce_cart_item_name' ], 10, 4 );
	}

	public function woocommerce_cart_item_name( $name, $cart_item, $cart_item_key ) {

		if ( isset( $cart_item['cart_partial_payment_status'] ) && $this->data->check_partial_payment_status( $cart_item['product_id'] ) ) {

			$content = "<span class='shopengine-partial-payment-product-badge'>". esc_html__( "Partial Payment", 'shopengine-pro' )."</span>";

			return $name . $content;

		}

		return $name ;
	}

	public function add_cart_button_text_change( $text, $product ) {

		$this->data->product_id = $product->get_id();

		if ( $this->data->check_partial_payment_status( $product->get_id() ) ) {
			return  esc_html( $this->data->settings['partial_payment_label'] );
		}

		return $text;
	}

	public function add_cart_button_text_change2($link, $product, $args) {

		$this->data->product_id = $product->get_id();

		if ( $this->data->check_partial_payment_status( $product->get_id() ) ) {
			return str_replace(
				[ 'href="?add-to-cart=' . $product->get_id() . '"', 'add_to_cart_button', 'ajax_add_to_cart' ],
				[ 'href="' . get_permalink($product->get_id())  . '"', '', '' ],
				$link );
		}

		return $link ;
	}

	//phpcs:disable WordPress.Security.NonceVerification 
    public function get_partial_payment_deposit_amount(){
		if(isset($_POST['variation_id'])){
        	$variant_id =  sanitize_text_field(wp_unslash($_POST['variation_id'])) ?? null ;
		}
	    $this->data->set_variant_product( $variant_id ) ;

	   return wc_price( $this->data->get_partial_amount())  ;
    }
	//phpcs:enable 
	/**
	 * add partial payment data to cart summery table
	 */
	public function add_html_to_cart_summery_table() {
		$this->data->set_partial_subtotal();

		if ( $this->data->subtotal_second_payment > 0 ) {
			$due = WC()->cart->get_total( 'f' ) - $this->data->subtotal_first_payment;
			?>

            <tr class="order-topay">
                <th> <?php echo esc_html( $this->data->settings['first_installment_label'] ) ?> </th>
                <td>  <?php shopengine_pro_content_render(wc_price( $this->data->subtotal_first_payment)); ?>  </td>
            </tr>
            <tr class="order-duepay">
                <th> <?php echo  esc_html( $this->data->settings['second_installment_label'] ); ?></th>
                <td> <?php shopengine_pro_content_render(wc_price( $due )); ?> </td>
            </tr>
            <tr class="order-topay">
                <th> <?php echo  esc_html( $this->data->settings['to_pay_label'] )?> </th>
                <td>  <?php shopengine_pro_content_render(wc_price( $this->data->subtotal_first_payment )); ?>  </td>
            </tr>
			<?php
		}
	}

	/**
	 * add partial payment subtotal/due/to pay in  checkout and order review page
	 *
	 * @param $subtotal
	 * @param $cart_item
	 * @param $cart_item_key
	 *
	 * @return string
	 */
	public function update_cart_item_subtotal( $subtotal, $cart_item, $cart_item_key ) {

		if ( isset( $cart_item['cart_partial_payment_status'] ) && $this->data->check_partial_payment_status( $cart_item['product_id'] ) ) {


			$variant_id = isset( $cart_item['variation_id'] ) && $cart_item['variation_id'] > 0 ? $cart_item['variation_id'] : null;
			$product_id = $variant_id ? $variant_id : $cart_item['product_id'];

			if ( $variant_id ) {
				$this->data->set_variant_product( $variant_id );
			} else {
				$this->data->set_product( $product_id );
			}


			$partial_subtotal = $this->data->get_partial_amount() * $cart_item['quantity'];

			return wc_price( $partial_subtotal );
		}

		return $subtotal;
	}

	/**
	 * add partial payment data under item price in cart page
	 *
	 * @param $price
	 * @param $cart_item
	 * @param $cart_item_key
	 *
	 * @return string
	 */
	public function change_cart_item_price_content( $price, $cart_item, $cart_item_key ) {
		$content = '';


		$product_id =  $cart_item['product_id'] ;

		if (  isset( $cart_item['cart_partial_payment_status']) &&  $this->data->check_partial_payment_status( $product_id ) ) {


			$variant_id = isset( $cart_item['variation_id'] ) && $cart_item['variation_id'] > 0 ? $cart_item['variation_id'] : null;


			if($variant_id) {
				$this->data->set_variant_product( $variant_id );
			}else{
				$this->data->set_product( $product_id );
			}

            $firstPayment = $this->data->get_partial_amount() * $cart_item['quantity'];

            $secondPayment = ( $this->data->product->get_price() * $cart_item['quantity'] ) - $firstPayment;

            $content = '<div class="shopengine-first-deposit">' . esc_html($this->data->settings['first_installment_label']). ' : ' . wc_price( $firstPayment ) . '</div> 
                         <div class="shopengine-second-payment">' . esc_html($this->data->settings['second_installment_label']). ' : ' . wc_price( $secondPayment ) . ' </div>';

		}

		return $price . $content;
	}

	/**
	 * add partial payment data to cart
	 *
	 * @param $cart_item_data
	 * @param $product_id
	 * @param $variation_id
	 *
	 * @return bool
	 */
	// phpcs:disable WordPress.Security.NonceVerification
	public function add_partial_payment_to_cart( $cart_item_data, $product_id, $variation_id ) {

		if ( ! $this->data->check_partial_payment_status( $product_id ) ) {
			return $cart_item_data;
		}

		$validate =   $this->validate_duplicate_item( $product_id, $variation_id) ;

		if( $validate > 0 ){
			throw new \Exception( $this->exist_in_cart_message );
		}
		
		if ( ! isset( $_REQUEST['shopengine_product_pp_status'] ) ) {
			return $cart_item_data;
		}


		if ( $_REQUEST['shopengine_product_pp_status'] === 'yes' ) {

			$cart_item_data['cart_partial_payment_status']     =  true;

		}

		return $cart_item_data;
	}
	


	private function validate_duplicate_item( $product_id, $variation_id ){

		$existing = 0 ;

		foreach ( WC()->cart->get_cart() as $key => $cart_item ) {

				if( ($cart_item['product_id'] == $product_id) && ($cart_item['variation_id'] == $variation_id) ){

					/**
					 * if not in cart as Partial Payment
					 */
				    if( ! isset( $cart_item['cart_partial_payment_status'] ) &&  ( isset( $_REQUEST['shopengine_product_pp_status'] ) && $_REQUEST['shopengine_product_pp_status'] == 'yes') ){
				        $this->exist_in_cart_message  = esc_html__("Item already exist in cart as full payment", 'shopengine-pro');
					    $existing +=  1 ;
				    }

					/**
					 * if already in cart as Partial Payment
					 */
					if(  isset( $cart_item['cart_partial_payment_status'] ) && ( !isset( $_REQUEST['shopengine_product_pp_status'] ) || (  isset( $_REQUEST['shopengine_product_pp_status'] ) && $_REQUEST['shopengine_product_pp_status'] == 'no' )) ){
						$this->exist_in_cart_message  = esc_html__( "Item already exist in cart as partial payment", 'shopengine-pro');
						$existing +=  1 ;
					}

				}
		}

		return $existing;
	}
	// phpcs:enable
	/**
	 * add partial payment htl for single product
	 */
	public function add_partial_payment_content() {
		global $post;

		$this->data->product_id          = $post->ID;
		$partial_payment_status = get_post_meta( $this->data->product_id, 'shopengine_product_pp_status', true );
		if (  $partial_payment_status === 'yes' ) {
			$this->partial_content();
		}
	}

	/**
	 * partial payment htl for single product
	 */
	public function partial_content( $product_set = true ) {
		global $post;

		if($product_set) $this->data->set_product( $post->ID );

		?>
        <div class="shopengine-partial-payment-container">
            <div class="shopengine-partial-payment-amount">
                <?php echo esc_html( $this->data->settings['first_installment_label'] ).':&nbsp;' ?>
				<b id="partial_payment_deposit_amount"> <?php
				shopengine_pro_content_render(wc_price($this->data->get_partial_amount()));
				?></b>
            </div>
            <div class="shopengine-partial-payment-fields">
                <div class="shopengine-custom-checkbox">
                    <label class="custom-control-label"
                           for="shopengine-pay-deposit">
                        <input type="radio" id="shopengine-pay-deposit" name="shopengine_product_pp_status" value="yes">
	                    <?php echo esc_html( $this->data->settings['partial_payment_label'] ).':&nbsp;' ?></label>
                </div>

                <div class="shopengine-custom-checkbox">
                    <label class="custom-control-label"
                           for="shopengine-full-deposit">
                        <input type="radio" id="shopengine-full-deposit" checked name="shopengine_product_pp_status" value="no">
	                    <?php echo esc_html( $this->data->settings['full_payment_label'] ).':&nbsp;' ?></label>
                </div>
            </div>
        </div>
		<?php
	}

}
