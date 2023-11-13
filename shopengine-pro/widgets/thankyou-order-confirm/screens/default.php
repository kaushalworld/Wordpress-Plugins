<?php
/**
 * This template will overwrite the WooCommerce file: woocommerce/checkout/order-receipt.php.
 */

defined('ABSPATH') || exit;

$order = wc_get_order($order_id); // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited

if(!$order) {
	return;
}

$show_customer_details = is_user_logged_in() && $order->get_user_id() === get_current_user_id();


if($show_customer_details) {

	$inf = $order->get_order_item_totals();

	?>
    <div class="shopengine-thankyou-order-confirm">

        <table class="table table-bordered">
            <thead>
            <tr>
                <th colspan="2"><?php echo esc_html__('Order Confirmation', 'shopengine-pro'); ?></th>
            </tr>
            </thead>
            <tbody>
            <tr class="order-number">
                <td><?php echo esc_html__('Order number', 'shopengine-pro'); ?></td>
                <td>
                    <a title="<?php esc_html_e('Order Details', 'shopengine-pro')?>" href="<?php echo esc_url($order->get_view_order_url()) ?>">#<?php echo esc_html($order->get_order_number()) ?></a>
                </td>
            </tr>
            <tr class="order-date">
                <td><?php echo esc_html__('Order Date', 'shopengine-pro'); ?></td>
                <td><?php echo esc_html(wc_format_datetime($order->get_date_created())) ?></td>
            </tr>
            <tr class="order-status">
                <td><?php echo esc_html__('Order status', 'shopengine-pro'); ?></td>
                <td><?php echo esc_html(wc_get_order_status_name($order->get_status())) ?></td>
            </tr>

			<?php if(!empty($inf['payment_method'])) : ?>
                <tr class="order-method">
                    <td><?php echo esc_html($inf['payment_method']['label']); ?></td>
                    <td><?php echo esc_html($inf['payment_method']['value']); ?></td>
                </tr> <?php
			endif;

			if(!empty($inf['order_total'])) : ?>
                <tr class="order-total">
                    <td><?php echo esc_html($inf['order_total']['label']); ?></td>
                    <td><?php echo wp_kses_post($inf['order_total']['value']); ?></td>
                </tr> <?php
			endif; ?>

            </tbody>
        </table>

    </div>
	<?php

	do_action('woocommerce_receipt_' . $order->get_payment_method(), $order->get_id());
}
