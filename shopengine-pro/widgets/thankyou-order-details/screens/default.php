<?php
/**
 * This template will overwrite the WooCommerce file: woocommerce/order/order-details.php.
 */

defined( 'ABSPATH' ) || exit;



defined('ABSPATH') || exit;

$order = wc_get_order($order_id); // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited

if(!$order) {
	return;
}

$order_items = $order->get_items(apply_filters('woocommerce_purchase_order_item_types', 'line_item'));
$show_purchase_note = $order->has_status(apply_filters('woocommerce_purchase_note_order_statuses', array('completed', 'processing')));
$downloads = $order->get_downloadable_items();
$show_downloads = $order->has_downloadable_item() && $order->is_download_permitted();

if($show_downloads) {
	wc_get_template(
		'order/order-downloads.php',
		array(
			'downloads'  => $downloads,
			'show_title' => true,
		)
	);
}

?>
        <div class="shopengine-thankyou-order-details">
            <section class="woocommerce-order-details">
                <?php do_action('woocommerce_order_details_before_order_table', $order); ?>

                <h2 class="woocommerce-order-details__title"><?php esc_html_e('Order details', 'shopengine-pro'); ?></h2>

                <table class="woocommerce-table woocommerce-table--order-details shop_table order_details">

                    <thead>
                    <tr>
                        <th class="woocommerce-table__product-name product-name"><?php esc_html_e('Product', 'shopengine-pro'); ?></th>
                        <th class="woocommerce-table__product-table product-total"><?php esc_html_e('Total', 'shopengine-pro'); ?></th>
                    </tr>
                    </thead>

                    <tbody>
                    <?php
                    do_action('woocommerce_order_details_before_order_table_items', $order);

                    foreach($order_items as $item_id => $item) {
                        $product = $item->get_product();

                        wc_get_template(
                            'order/order-details-item.php',
                            array(
                                'order'              => $order,
                                'item_id'            => $item_id,
                                'item'               => $item,
                                'show_purchase_note' => $show_purchase_note,
                                'purchase_note'      => $product ? $product->get_purchase_note() : '',
                                'product'            => $product,
                            )
                        );
                    }

                    do_action('woocommerce_order_details_after_order_table_items', $order);
                    ?>
                    </tbody>

                    <tfoot>
                    <?php
                    foreach($order->get_order_item_totals() as $key => $total) {
                        ?>
                        <tr>
                            <th scope="row"><?php echo esc_html($total['label']); ?></th>
                            <td><?php echo ('payment_method' === $key) ? esc_html($total['value']) : wp_kses_post($total['value']); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></td>
                        </tr>
                        <?php
                    }
                    $notes = [];
                    if($order->get_customer_note()) :
                        $notes['order_comments'] = [
                            'label' => esc_html__('Note:', 'shopengine-pro'),
                            'value' => wp_kses_post(nl2br(wptexturize($order->get_customer_note())))
                        ];
                    endif;
                    $notes = apply_filters('shopengine_order_notes', $notes, $order);

                    foreach($notes as $note) : ?>
                        <tr>
                            <th><?php echo esc_html($note['label']); ?></th>
                            <td><?php echo esc_html($note['value']); ?></td>
                        </tr>
                    <?php endforeach; ?>

                    </tfoot>
                </table>

                <?php do_action('woocommerce_order_details_after_order_table', $order); ?>
            </section>
        </div>

<?php
/**
 * Action hook fired after the order details.
 *
 * @since 4.4.0
 * @param WC_Order $order Order data.
 */
do_action('woocommerce_after_order_details', $order);
