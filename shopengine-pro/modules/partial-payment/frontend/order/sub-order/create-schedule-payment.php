<?php


namespace ShopEngine_Pro\Modules\Partial_Payment\Frontend\Order\Sub_Order;


use WC_Data_Exception;
use WC_Order_Item_Fee;

class Create_Schedule_Payment {


	public $order;
	public $order_id;
	private $parent_order_id;
	private $total;
	private $item_name;

	public function __construct( $parent_order_id, $total, $item_name ) {
		$this->parent_order_id = $parent_order_id;
		$this->total           = $total;
		$this->item_name       = $item_name;
	}

	/**
	 * @throws WC_Data_Exception
	 */
	public function create( $meta = [], $add_payment_method = false ) {

		$this->order = new Schedule_Payment();

		$this->order->set_customer_id( get_current_user_id() );
		$item = new WC_Order_Item_Fee();

		$item->set_name( $this->item_name );
		$item->set_props(
			array(
				'total' => $this->total
			)
		);

		$this->order->add_item( $item );

		$this->order->set_parent_id( $this->parent_order_id );
		$this->order->set_currency( get_woocommerce_currency() );

		if ( $add_payment_method ) {
			$this->order->set_payment_method( $add_payment_method );
		}

		$this->order->set_total( $this->total );
		foreach ( $meta as $item ) {
			$this->order->update_meta_data( $item['key'], $item['value'] );
		}

		$this->order_id = $this->order->save();

		return $this->order_id;
	}

}