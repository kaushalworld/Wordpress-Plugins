<?php

defined('ABSPATH') || exit;

\ShopEngine\Widgets\Widget_Helper::instance()->wc_template_filter();

?>
<div class="shopengine">
	<div class="shopengine-account-dashboard">
		<?php
			if(\Elementor\Plugin::$instance->editor->is_edit_mode() || is_preview()) {
				woocommerce_account_content();
			} else {
				wc_print_notices(); woocommerce_account_content();
			}
		  ?>
	</div>
</div>