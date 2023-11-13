<?php


namespace ShopEngine_Pro\Libs\Schedule;


use ShopEngine\Core\Register\Module_List;
use WC_Order;

class Partial_Payment_Schedule {

	public function __construct() {
		Scheduler::add( 'shopengine-partial-payment-reminder-main', [ $this, 'send_main' ] );
	}

	public function send_main() {
		$settings = Module_List::instance()->get_active_settings( 'partial-payment' );

		if ( empty( $settings ) ) {
			Scheduler::delete( 'shopengine-partial-payment-reminder-main' );
			return false;
		}

		$day = $settings['day_after_installment_reminder']['value'] ?? 5;

		$orders = wc_get_orders(
			[
				'type'   => 'pp_installment',
				'status' => [ 'wc-on-hold', 'wc-pending' ]
			]
		);

		foreach ( $orders as $order ) {
			$schedule_date = date( "Y-m-d", strtotime( "+$day days", strtotime( $order->get_date_created() ) ) );
		 	if ( $schedule_date == date( 'Y-m-d' ) ) {
				$this->send_mail( $order );
		 	}
		}
	}


	protected function send_mail( WC_Order $order ) {
		$mailer = WC()->mailer();

		$recipient = $order->get_billing_email();
		$subject   = __( "Reminder for second installment payment", 'shopengine-pro' );

		$content = $this->get_order_mail_content( $order );

		$template_content = $this->get_html_template( $content, $subject );

		$mailer->send( $recipient, $subject, $template_content );
	}

	public function get_order_mail_content( $order ) {
		ob_start();

		include 'templates/order-mail-content.php';

		$content = ob_get_contents();
		ob_end_clean();

		return $content;
	}

	public function get_html_template( $content, $title ) {
		ob_start();

		include 'templates/email-template.php';

		$content = ob_get_contents();
		ob_end_clean();

		return $content;
	}

}