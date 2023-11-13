<?php
/**
 * This template will overwrite the WooCommerce file: woocommerce/order/order-details.php.
 */

defined( 'ABSPATH' ) || exit;

$order = wc_get_order($order_id); // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited

if(!$order_id) {
	return;
}
?>

<div class="shopengine-thankyou-thankyou">

	<?php if($order->has_status('failed')) : ?>

        <h3>
			<?php echo esc_html__('ORDER', 'shopengine-pro') ?> #<?php echo esc_html($order->get_order_number()); ?>
        </h3>
        <p>
			<?php esc_html_e('Unfortunately your order cannot be processed as the originating bank/merchant has declined your transaction. Please attempt your purchase again.', 'shopengine-pro'); ?>
        </p>

	<?php else : ?>

        <h3>
			<?php echo esc_html__('ORDER', 'shopengine-pro') ?> #<?php echo esc_html($order->get_order_number()); ?>
        </h3>
        <p>
			<?php echo apply_filters('woocommerce_thankyou_order_received_text', esc_html__('Thank you. Your order has been received.', 'shopengine-pro'), $order); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped?>
        </p>

	<?php endif; ?>

</div>