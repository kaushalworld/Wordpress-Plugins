<?php

defined('ABSPATH') || exit;

\ShopEngine\Widgets\Widget_Helper::instance()->wc_template_filter();

$order = wc_get_order($order_id); // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited

if(!$order) {
	return;
}

$show_customer_details = is_user_logged_in() && $order->get_user_id() === get_current_user_id();


if($show_customer_details) {
	?>
    <div class="shopengine-thankyou-address-details">
		<?php
		wc_get_template('order/order-details-customer.php', ['order' => $order]);
		?>
    </div>
	<?php
}
