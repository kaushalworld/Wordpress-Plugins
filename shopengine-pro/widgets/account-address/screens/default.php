<?php

global $wp;

\ShopEngine\Widgets\Widget_Helper::instance()->wc_template_filter();

$screen = isset($wp->query_vars['edit-address']) ? $wp->query_vars['edit-address'] : '';

if(get_post_type() == \ShopEngine\Core\Template_Cpt::TYPE) {

	$screen = $edit_screen;
}

$has_form = ($screen === '') ? '' : ' shopengine-account-address-form';

?>
	<div class="shopengine-account-address <?php echo esc_attr( $screen . $has_form ); ?>">
		<?php woocommerce_account_edit_address($screen); ?>
	</div>
<?php

