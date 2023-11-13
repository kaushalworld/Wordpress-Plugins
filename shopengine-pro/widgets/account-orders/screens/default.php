<?php defined('ABSPATH') || exit;

\ShopEngine\Widgets\Widget_Helper::instance()->wc_template_filter();

global $wp;

$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

?>

<div class="shopengine-account-orders">
	<?php woocommerce_account_orders($paged); ?>
</div>
