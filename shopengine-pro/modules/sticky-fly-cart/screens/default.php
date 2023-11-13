<?php defined( 'ABSPATH' ) || exit;

extract($settings);

// cart data
$wc_cart			= (WC()->cart != '') ? WC()->cart : false;
$cart_total			= $wc_cart ? $wc_cart->get_cart_total() : 0;
$cart_items_count	= $wc_cart ? $wc_cart->get_cart_contents_count() : 0;

// fly cart settings
$icon				= !empty($cart_icon['value']) ? $cart_icon['value'] : 'fas fa-shopping-cart';
$drawer_form		= !empty($drawer_form['value']) ? $drawer_form['value'] : 'right';
$flying_animation	= !empty($enable_flying_animation['value']) ?$enable_flying_animation['value'] : 'yes';  
$single_fly_cart    = !empty($single_page_ajax_add_to_cart['value']) ? $single_page_ajax_add_to_cart ['value'] : 'no';  
?>

<div class="shopengine-sticky-fly-cart" data-fly="<?php echo esc_attr($flying_animation); ?>" data-single-ajax="<?php echo esc_attr($single_fly_cart); ?>" data-cart-total-api="<?php echo esc_url(admin_url('admin-ajax.php?action=shopengine_cart_total')); ?>">
	<div class="shopengine-sticky-fly-cart--inner">
		<div class="shopengine-sticky-fly-cart--fixed-cart">
			<div class="shopengine-fixed-cart--inner">
				<span class="shopengine-fixed-cart--icon"><i class="shopengine-icon shopengine-icon-shopping_cart_5"></i></span>
				<span class="shopengine-fixed-cart--count"><?php echo esc_html($cart_items_count); ?></span>
			</div>
		</div>

		<div class="shopengine-sticky-fly-cart--container offcanvas-<?php echo esc_attr($drawer_form); ?>">
			<div class="mini-cart-header">
				<ul>
					<li>
						<span class="shopengine-cart-count">
							<?php printf(esc_html(_n('%s Item', '%s Items', $cart_items_count, 'shopengine-pro')), esc_html(number_format_i18n($cart_items_count))); ?>
						</span>
					</li>
					<li>
						<a title="<?php esc_html_e('Cart Item', 'shopengine-pro')?>" href="<?php echo esc_url(wc_get_cart_url()); ?>">
							<?php esc_html_e('View Cart', 'shopengine-pro');?>
						</a>
					</li>
				</ul>
			</div>
			<div class="shopengine-sticky-fly-cart--mini-cart-content widget_shopping_cart_content">
				<?php woocommerce_mini_cart(); ?>
			</div>
		</div>

		<div class="shopengine-sticky-fly-cart--backdrop"></div>
	</div>
</div>