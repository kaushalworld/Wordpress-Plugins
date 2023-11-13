<?php


namespace ShopEngine_Pro\Modules\Partial_Payment\Common;


use ShopEngine_Pro\Modules\Partial_Payment\Settings\Partial_Payment_Data;

class Common_Functionality {


	/**
	 * instance of Partial_Payment_Data() object;
	 * @var
	 */
	private $data;

	/**
	 * Partial_Payment_Cart constructor.
	 *
	 * @param Partial_Payment_Data $data
	 */
	public function __construct( Partial_Payment_Data $data ) {
		$this->data = $data;
	}


	public function init() {

		add_filter( 'woocommerce_order_item_get_formatted_meta_data', [ $this, 're_format_order_item_meta' ], 10, 4 );
	}

	public function re_format_order_item_meta( $formatted_meta, $item ) {
		$key_for_amount = null ; 
		$key_for_amount_type = null ; 
		$type = '' ;

		foreach ( $formatted_meta as $key => $meta ) {
			if ( $meta->key == 'shopengine_pp_status' ) {
				$meta->display_key = "<span class='shopengine-partial-payment-product-badge'> Partial Payment </span>";
			}
 
			if ( $meta->key == 'shopengine_pp_amount_type' ) {
			 	$type = ( strip_tags( trim( $meta->display_value ) ) == 'percent_amount' ? "%" : '' );
				$key_for_amount_type =  $key ;
			}

			
			if ( $meta->key == 'shopengine_pp_amount' ) {
				$key_for_amount = $key;
			}
		}

		if( $key_for_amount ) {
			$meta  = $formatted_meta[$key_for_amount] ; 
			$meta->display_key = "Amount";
			$meta->display_value =  strip_tags( trim( $meta->display_value ) ).$type ;
		}

		unset( $formatted_meta[ $key_for_amount_type ] ) ;

		return $formatted_meta;
	}
}