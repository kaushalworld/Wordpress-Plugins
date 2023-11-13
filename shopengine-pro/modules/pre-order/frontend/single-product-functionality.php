<?php

namespace ShopEngine_Pro\Modules\Pre_Order\Frontend;

use ShopEngine_Pro\Modules\Pre_Order\Settings\Pre_Order_Settings;

defined( 'ABSPATH' ) || exit;

class Single_Product_Functionality {

	/**
	 * Pre_Order_Settings object
	 */
	private $settings;

	private $pre_order_closed = false ;

	public function __construct() {
		$this->settings = Pre_Order_Settings::instance();
	}


	public function init() {

			add_action( 'woocommerce_is_purchasable', [ $this, 'hide_add_to_cart_function' ], 1, 2 );
			add_action( 'woocommerce_product_single_add_to_cart_text', [ $this, 'add_cart_button_text_change' ], 30, 2 );
			add_action( 'woocommerce_product_add_to_cart_text', [ $this, 'add_cart_button_text_change' ], 30, 2 );
	//		add_action( 'woocommerce_get_price_html', [ $this, 'add_pre_order_price_under_price_text' ], 15, 2 );

	     	add_action( 'woocommerce_get_price_html', [ $this, 'add_pre_order_data_with_short_desc' ], 50, 2 );
			add_action( 'wp_enqueue_scripts', [$this, 'pre_order_styles'] );
	}

	public function get_pre_order_content(){

		check_ajax_referer('wp_rest');

		if(isset($_POST['variation_id'])){
			$variant_id = sanitize_text_field(wp_unslash($_POST['variation_id']));
			$this->settings->set_product( $variant_id, true );
		}
		// $price  =  wc_price( $this->settings->product->get_regular_price() );

		if($this->settings->product->get_stock_status() != 'pre_order'){
			wp_send_json( [
				"content" => '' ,
				"status" =>  'true',
				"add_cart_text" => apply_filters('shopengine_add_to_cart_text', esc_html__("Add to cart", 'shopengine-pro'))
			]) ;
		}

		if ( $this->settings->pre_order_is_closed() ) {
			$this->pre_order_closed = true;
		}


		$html = '' ;


		if( $this->pre_order_closed ) {
			$html  .= '<h3 class="pre-order-closed-message" >'.$this->settings->pre_order_closed_label.'</h3>';
		}else{
			$html  .= $this->process_pre_order_data( $html );
		}

		return [
			"content" => $html ,
			"status" => $this->pre_order_closed ? 'false' : 'true',
			"add_cart_text" =>  !$this->pre_order_closed  ? esc_html__("Pre-Order", 'shopengine-pro') : esc_html__("Add to cart", 'shopengine-pro')
		] ;
	}

	public function pre_order_styles() {
		$custom_css = '';

		// Pre-Order Message Background.
		$custom_css .= '.shopengine-pre-order-singlepage-data p.message {
			background-color: '. $this->settings->pre_order_primary_color .';
			border-radius: '. $this->settings->pre_order_radius .'px;
		}';

		// Pre-Order Countdown Background.
		$custom_css .= '.shopengine-pre-order-singlepage-data .countdown-container > .countdown-box > div span {
			background-color: '. $this->settings->pre_order_primary_color .';
			border-radius: '. $this->settings->pre_order_radius .'px;
		}';

		// Pre-Order Remaining Items.
		$custom_css .= '.elementor .elementor-element.elementor-widget .shopengine-widget .pre-order-remaining-item {
			color: '. $this->settings->pre_order_primary_color .';
		}';

		// Pre-Order Price.
		$custom_css .= '.shopengine-widget .pre-order-price {
			color: '. $this->settings->pre_order_primary_color .';
		}';

		wp_add_inline_style( 'pre-order-module-css', $custom_css );
	}

	public function hide_add_to_cart_function($status, $product) {

			$this->settings->product_id = $product->get_id();

			if ( $product->get_stock_status() !== 'pre_order' ) {
				return true;
			}

			if ( $this->settings->get_status() == 'yes' && $this->settings->pre_order_is_closed() ) {

			return false;

			}

		return true;
	}


	public function add_pre_order_price_under_price_text( $price, $product ) {
		global $post;

		if ( !$post ) {
			return $price;
		}

		if( !$product ){
			return $price;
		}

		$this->settings->product_id = $product->get_id();

		if ( $product->get_stock_status() !== 'pre_order' ) {
			return $price;
		}

		if ( $this->settings->get_status() != 'yes') {

			return $price;
		}

		if ( $this->settings->pre_order_is_closed() ) {

			return $price;
		}

		if($product->get_sale_price() >= $product->get_regular_price() ){
			return $price;
		}

		$html =  '';

		if ( $this->settings->get_price() ) {
			$html .= '<span class="pre-order-price"> '. esc_html__( 'Pre-Order Price:', 'shopengine-pro' ).' <b>'.get_woocommerce_currency_symbol(). $this->settings->get_price().'</b></span>';
		}

		$price = wc_price( $product->get_regular_price() );

		return $price .   $html;
	}

	/**
	 * add preorder data before price
	 *
	 * @throws \Exception
	 */
	public function add_pre_order_data_with_short_desc( $price, $product ){


		if ( !  is_product() ) return $price;

		if ( ! $product )  return $price;

		$this->settings->product_id = $product->get_id();


		if ( $product->get_stock_status() !== 'pre_order' ) {
			return $price;
		}

		if( $product->get_parent_id() ){
			return $price;
		}

		if( ( $product->get_stock_status() !== 'pre_order' ) && $this->settings->get_status() !== 'yes' ) return $price ;

		if ( $this->settings->pre_order_is_closed() ) {
			$this->pre_order_closed = true;
		}


		$html = '' ;

		if($this->pre_order_closed) {
			$html  .= '<h3 class="pre-order-closed-message" >'.$this->settings->pre_order_closed_label.'</h3>';
		 }else{

		    $html  = $this->process_pre_order_data( $html );
		}

	  return $html."<p class='price'>" .$price ."</p>";
	}

	public function add_cart_button_text_change($text, $product) {
		global $post;

		if ( !$post ) {
			return $text;
		}

		$this->settings->product_id = $post->ID;

		if ( $this->settings->get_status() === 'yes' && ! $this->settings->pre_order_is_closed() ) {
			return $this->settings->pre_order_label;
		}

		return $text;
	}


	public function available_message( string $html, $product_message, $available_date_formatted ): string {
		$html            .= '<div class="shopengine-pre-order-singlepage-data"><p class="message">';
		$explode_message = explode( '[available_date]', $product_message );
		$last_index      = count( $explode_message ) - 1;
		foreach ( $explode_message as $k => $message ) {

			if ( $k == 0 ) {
				$html .= '<span>' . $message . '</span>' . $available_date_formatted;
			} else if ( $last_index !== $k ) {
				$html .= $message . $available_date_formatted;
			} else if ( $last_index === $k ) {
				$html .= $message;
			}
		}
		$html .= '</p></div>';

		return $html;
	}


	public function countdown( $available_date, string $html ): string {

		$html .= '<div class="shopengine-pre-order-singlepage-data"> ';

		$available_date = date( "Y-m-d H:i:s", strtotime( $available_date . ' 23:59:59' ) );

		$currentDate = new \DateTime( date( 'Y-m-d H:i:s', current_time( 'timestamp' ) ) );

		$difference = $currentDate->diff( new \DateTime( $available_date ) );
		/* $difference->d is not counting when selects 1 month++ */ 
		$html .= '<div class="countdown-container"><b>' . $this->settings->pre_order_countdown_label . '</b>
			<div class="countdown-box">
			  <div class="days"> 
			  <span> ' . $difference->days . '</span> <br> '.esc_html__('Day/s', 'shopengine-pro').' 
			  </div>

			  <div class="hour"> 
			  <span> ' . $difference->h . '</span> <br> '.esc_html__('Hour/s', 'shopengine-pro').'
			  </div>

			  <div class="munite"> 
			  <span> ' . $difference->i . '</span> <br> '.esc_html__('Minute/s', 'shopengine-pro').'
			  </div>

			';

		$html .= '</div></div></div>';

		return $html;
	}


	public function process_pre_order_data( string $html ): string {
		$product_message          = $this->settings->get_product_message();
		$available_date           = $this->settings->get_available_date();
		$available_date_formatted = date( 'd M Y', strtotime( $available_date ) );

		if ( $product_message ) {
			$html  = $this->available_message( $html, $product_message, $available_date_formatted );
		}

		if ( $this->settings->pre_order_countdown_status == 'yes' ) {

			$html   = $this->countdown( $available_date, $html );
		}

		if(!$this->settings->product){
			$this->settings->set_product(  $this->settings->product_id ) 	;
		}


		$variation_id =  null ;
		$product_id =  $this->settings->product_id ;

		if( $this->settings->product->get_parent_id() ){
			// variant product id

			$variation_id =   $this->settings->product_id;
			$product_id =   $this->settings->product->get_parent_id();

		}

		$remaining_items =  $this->settings->get_remaining_items($product_id, $variation_id);

		if ( $remaining_items ) {
			$html  .= '<p class="pre-order-remaining-item">'.esc_html__('Remaining Item/s:', 'shopengine-pro').' <b>' . $remaining_items . '</b></p>';
		}


		return $html;
	}
}
