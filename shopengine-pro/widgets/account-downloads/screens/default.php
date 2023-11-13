<?php defined('ABSPATH') || exit;

\ShopEngine\Widgets\Widget_Helper::instance()->wc_template_filter();
?>
<div class="shopengine-account-downloads">
	<?php

	if(get_post_type() == \ShopEngine\Core\Template_Cpt::TYPE) {

		WC()->customer = new WC_Customer(get_current_user_id(), true);
	}

	woocommerce_account_downloads(); ?>
</div>
