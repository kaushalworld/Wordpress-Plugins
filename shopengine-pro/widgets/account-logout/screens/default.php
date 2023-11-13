<?php
/**
 * This template will overwrite the WooCommerce file: woocommerce/myaccount/navigation.php.
 */

if(!is_user_logged_in() && get_post_type() != \ShopEngine\Core\Template_Cpt::TYPE) {
    return '<div class="shopengine-editor-alert shopengine-editor-alert-warning">' . esc_html__('You need to logged in first', 'shopengine-pro') . '</div>';
}

    $settings = $this->get_settings_for_display();

?>
<div class="shopengine-account-logout">
    <a title="<?php esc_html_e('Logout', 'shopengine-pro')?>" href="<?php echo esc_url(wc_logout_url(wc_get_page_permalink('myaccount'))); ?>">
        <?php \Elementor\Icons_Manager::render_icon( $settings['shopengine_acc_logout_content_icon'], [ 'aria-hidden' => 'true' ] ); ?>
        <span> <?php echo esc_html($settings['shopengine_acc_logout_content_title']); ?> </span>
    </a>
</div>