<?php
/**
 * Order details Summary
 *
 * This template displays a summary of partial payments
 *
 * @package Webtomizer\WCDP\Templates
 * @version 2.5.0
 */


if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


?> <p> <?php esc_html_e( 'Partial payments summary', 'shopengine-pro' ) ?>

<table class="woocommerce-table  woocommerce_deposits_parent_order_summary">

    <thead>
    <tr>

        <th><?php esc_html_e( 'Title', 'shopengine-pro' ); ?> </th>
        <th><?php esc_html_e( 'Payment ID', 'shopengine-pro' ); ?> </th>
        <th><?php esc_html_e( 'Status', 'shopengine-pro' ); ?> </th>
        <th><?php esc_html_e( 'Amount', 'shopengine-pro' ); ?> </th>
        <th><?php esc_html_e( 'Action', 'shopengine-pro' ); ?> </th>

    </tr>

    </thead>

    <tbody>

	<?php
	$sl = 1;
	foreach ( $orders as $order ){
	?>
    <tr>
        <td><?php foreach ( $order->get_fees() as $fee ) {
				echo esc_html($fee['name']);
			} ?></td>
        <td><?php echo esc_html($order->get_id()) ?></td>
        <td><?php echo esc_html($order->get_status()) ?></td>
        <td><?php shopengine_pro_content_render(wc_price( $order->get_total(), ['currency' => $order->get_currency()] )) ?></td>
        <td><?php if ( $order->get_status() == 'pending' ) {
				?>
                <a title="<?php esc_html_e('Order Details', 'shopengine-pro')?>" href="<?php echo esc_url( $order->get_checkout_payment_url() ); ?>"
                   class="due-payment-button button pay"><?php esc_html_e( 'Pay Due Payment', 'shopengine-pro' ); ?></a>
				<?php
			} ?></td>

		<?php } ?>
    </tr>
    </tbody>

    <tfoot>


    </tfoot>
</table>
