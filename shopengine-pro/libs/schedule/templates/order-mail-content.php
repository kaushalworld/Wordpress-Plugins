<?php

$parent_order =  wc_get_order($order->get_parent_id());
$payment_url = $order->get_checkout_payment_url();

echo sprintf(__('<p> Dear %s,<br>For order number <b>%s</b> at our store, you have completed the first installation of the payment. Please pay for the second installment. To pay the due, please visit this link.</p>', 'shopengine-pro'),
esc_html($parent_order->get_billing_first_name()),
esc_html($order->get_parent_id()));

?>

<h3><a title="<?php esc_attr_e('Pay For Installment', 'shopengine-pro') ?>" href='<?php echo esc_url($payment_url) ?>'> Pay now</a> </h3>

<h4> <?php esc_html_e("Order Summery", 'shopengine-pro') ?></h4>
<table class='table'>
    <thead>
        <tr>
            <th><?php esc_html_e("Product Name", 'shopengine-pro') ?></th>
            <th><?php esc_html_e("Quantity", 'shopengine-pro') ?></th>
            <th><?php esc_html_e("Total", 'shopengine-pro') ?></th>
        </tr>
    </thead>
    <tbody>

        <?php

        foreach ($parent_order->get_items() as $item) {
            $sub_total = wc_price($item->get_subtotal());
            echo "<tr>";
            shopengine_pro_content_render("<td>" . $item->get_name() . "</td>");
            shopengine_pro_content_render("<td>" . $item->get_quantity() . "</td>");
            shopengine_pro_content_render("<td>" . $sub_total . "</td>");
            echo "</tr>";
        }

        ?>
    </tbody>
    <tfoot>
        <tr>
            <td colspan='2'><?php esc_html_e("Total", 'shopengine-pro') ?></td>
            <td><?php shopengine_pro_content_render(wc_price($parent_order->get_subtotal())) ?></td>
        </tr>
        <tr>
            <td colspan='2'><?php esc_html_e("Paid", 'shopengine-pro') ?></td>
            <td><?php shopengine_pro_content_render(wc_price($parent_order->get_meta('partial_payment_paid_amount'))) ?></td>
        </tr>
        <tr>
            <td colspan='2'><?php esc_html_e("Due", 'shopengine-pro') ?></td>
            <td><?php shopengine_pro_content_render(wc_price($parent_order->get_meta('partial_payment_due_amount'))) ?></td>
        </tr>
    </tfoot>
</table>

<h3 style="text-align:right">
    <a title="<?php esc_attr_e('Payment', 'shopengine-pro') ?>" href='<?php echo esc_url($payment_url); ?>'>
        <?php esc_html_e("Pay now", 'shopengine-pro') ?>
    </a>
</h3>