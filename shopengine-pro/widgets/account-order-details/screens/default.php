<?php

global $wp;

\ShopEngine\Widgets\Widget_Helper::instance()->wc_template_filter();

if(!empty($wp->query_vars['view-order'])) {
	$order_id = $wp->query_vars['view-order'];

} elseif(get_post_type() == \ShopEngine\Core\Template_Cpt::TYPE) {

	$order_id = \ShopEngine\Widgets\Products::instance()->get_a_orders_from_my_account();
	if($order_id == 0) {
		?>
        <div class="shopengine shopengine-editor-alert shopengine-editor-alert-warning">
			<?php echo esc_html__('No order found.', 'shopengine-pro'); ?>
        </div>
		<?php
		return;
	}
}
?>
<div class="shopengine-account-order-details">
	<?php do_action( 'woocommerce_view_order', $order_id ); ?>
</div>
<?php
