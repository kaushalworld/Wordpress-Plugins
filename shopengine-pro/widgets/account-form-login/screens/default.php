<?php
/**
 * This template will overwrite the WooCommerce file: woocommerce/templates/myaccount/form-login.php.
 */



// show email sent message
// phpcs:ignore WordPress.Security.NonceVerification.Recommended 
 if(isset($_GET['reset-link-sent']) &&  $_GET['reset-link-sent'] ==  true){ 
	wc_add_notice( __("We have sent a mail to you with password reset link. Please check your email.", 'shopengine-pro'), 'success' );
}

if(WC()->session) {
	wc_print_notices();
}

if ( is_lost_password_page() ) { 
    // phpcs:ignore WordPress.Security.NonceVerification.Recommended 
	$password_reset_form = isset( $_GET['show-reset-form'] ) && $_GET['show-reset-form'] == true; 

	if ( $password_reset_form ) {
		include 'password-reset-form.php';
	} else {
		include 'password-reset-mail-form.php';
	}
} else {
	?>
<div class="shopengine-account-form-login">

    <form class="woocommerce-form woocommerce-form-login login" method="post">

		<?php do_action('woocommerce_login_form_start'); ?>

        <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
            <label for="username"><?php esc_html_e('Username or email address', 'shopengine-pro'); ?>&nbsp;<span
                        class="required">*</span></label>
            <input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="username"
                   id="username" autocomplete="username"
                   value="<?php echo (!empty($_POST['username'])) ? esc_attr(wp_unslash($_POST['username'])) : ''; ?>"/><?php // @codingStandardsIgnoreLine ?>
        </p>

        <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
            <label for="password"><?php esc_html_e('Password', 'shopengine-pro'); ?>&nbsp;<span
                        class="required">*</span></label>
            <input class="woocommerce-Input woocommerce-Input--text input-text" type="password" name="password"
                   id="password" autocomplete="current-password"/>
        </p>

		<?php do_action('woocommerce_login_form'); ?>

        <p class="form-row">
            <label class="woocommerce-form__label woocommerce-form__label-for-checkbox woocommerce-form-login__rememberme">
                <input class="woocommerce-form__input woocommerce-form__input-checkbox" name="rememberme"
                       type="checkbox" id="rememberme" value="forever"/>
                <span><?php esc_html_e('Remember me', 'shopengine-pro'); ?></span>
            </label>
			<?php wp_nonce_field('woocommerce-login', 'woocommerce-login-nonce'); ?>
            <button type="submit" class="woocommerce-button button woocommerce-form-login__submit" name="login"
                    value="<?php esc_attr_e('Log in', 'shopengine-pro'); ?>"><?php esc_html_e('Log in', 'shopengine-pro'); ?></button>
        </p>

        <p class="woocommerce-LostPassword lost_password">
            <a title="<?php esc_html_e('Lost Password', 'shopengine-pro')?>" href="<?php echo esc_url(wp_lostpassword_url()); ?>"><?php esc_html_e('Lost your password?', 'shopengine-pro'); ?></a>
        </p>

		<?php do_action('woocommerce_login_form_end'); ?>

    </form>

</div>
<?php

}