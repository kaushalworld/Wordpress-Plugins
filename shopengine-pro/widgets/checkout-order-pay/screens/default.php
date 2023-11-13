<?php

defined( 'ABSPATH' ) || exit;

global $wp;
// phpcs:ignore WordPress.Security.NonceVerification.Recommended
if ( get_post_type() == \ShopEngine\Core\Template_Cpt::TYPE || isset($_GET['shopengine_template_id'])) {
	include_once __DIR__ . '/editor-demo.php';
} elseif ( !empty( $wp->query_vars['order-pay'] ) ) {
    echo "<div class='shopengine-checkout-order-pay'>";
	WC_Shortcode_Checkout::output( [] );
	echo "</div>";
}
