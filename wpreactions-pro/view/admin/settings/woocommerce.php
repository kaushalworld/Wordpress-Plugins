<?php

use WPRA\Config;
use WPRA\FieldManager;
use WPRA\Helpers\Utils;
use WPRA\Shortcode;

if (isset($data)) {
    extract($data);
}
?>
<div class="option-wrap">
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="option-header mb-3">
                <h4>
                    <span><?php _e('WooCommerce Integration', 'wpreactions'); ?></span>
                </h4>
            </div>
            <?php
            FieldManager\Checkbox
                ::create()
                ->addCheckbox(
                    'woo_integration',
                    Config::$settings['woo_integration'],
                    __('Activate Woo Reactions on your product pages', 'wpreactions'),
                    1
                )
                ->addClasses('form-group')
                ->render();
            ?>
        </div>
    </div>
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="option-header mb-3">
                <h4>
                    <span><?php _e('Choose your emoji location', 'wpreactions'); ?></span>
                    <?php Utils::tooltip('woo-location-note'); ?>
                </h4>
                <span><?php _e('Select the location where you would like your Reactions to appear on your product page.', 'wpreactions'); ?></span>
            </div>
            <?php
            $elemAfter = '<div class="woo-location-zoom"><img class="radio-image" src="%s" title="%s"><i class="qa qa-search-plus"></i></div>';
            FieldManager\Radio
                ::create()
                ->setName('woo_location')
                ->addRadios(
                    [
                        FieldManager\RadioItem
                            ::create()
                            ->setId('woocommerce_after_single_product')
                            ->setValue('woocommerce_after_single_product')
                            ->setElemAfter(sprintf($elemAfter, Utils::getAsset('images/woo-bottom.png'), __('At the bottom of product'))),
                        FieldManager\RadioItem
                            ::create()
                            ->setId('woocommerce_before_add_to_cart_button')
                            ->setValue('woocommerce_before_add_to_cart_button')
                            ->setElemAfter(sprintf($elemAfter, Utils::getAsset('images/woo-before-add-cart.png'), __('Before add to cart button'))),
                        FieldManager\RadioItem
                            ::create()
                            ->setId('woocommerce_share')
                            ->setValue('woocommerce_share')
                            ->setElemAfter(sprintf($elemAfter, Utils::getAsset('images/woo-share.png'), __('After product meta'))),
                        FieldManager\RadioItem
                            ::create()
                            ->setId('woocommerce_before_add_to_cart_form')
                            ->setValue('woocommerce_before_add_to_cart_form')
                            ->setElemAfter(sprintf($elemAfter, Utils::getAsset('images/woo-before-form.png'), __('Before add to cart form'))),
                        FieldManager\RadioItem
                            ::create()
                            ->setId('woocommerce_after_add_to_cart_form')
                            ->setValue('woocommerce_after_add_to_cart_form')
                            ->setElemAfter(sprintf($elemAfter, Utils::getAsset('images/woo-after-form.png'), __('After add to cart form'))),
                        FieldManager\RadioItem
                            ::create()
                            ->setId('woocommerce_use_custom_hook')
                            ->setValue('woocommerce_use_custom_hook')
                            ->setLabel(__('Use a custom hook', 'wpreactions'))
                            ->setTooltip('woo-custom-hook')
                            ->addClasses('d-block mt-4'),
                    ]
                )
                ->setChecked(Config::$settings['woo_location'])
                ->addClasses('form-group-inline mr-4 radio-image-label')
                ->render();
            ?>
        </div>
        <div class="col-md-6">
            <div class="mt-3">
                <?php
                FieldManager\Text::create()
                    ->setId('woo_custom_product_hook')
                    ->setValue(Config::$settings['woo_custom_product_hook'])
                    ->setLabel(__('Enter custom hook name', 'wpreactions'))
                    ->render();
                ?>
            </div>
        </div>
    </div>
    <div class="row align-items-end">
        <div class="col-md-6">
            <div class="option-header mb-3">
                <h4>
                    <span><?php _e('Choose your Shortcode', 'wpreactions'); ?></span>
                    <?php Utils::tooltip('woo-choose-shortcode'); ?>
                </h4>
                <span><?php _e('Select your Shortcode from the dropdown. To make changes to your choice, click edit.', 'wpreactions'); ?></span>
            </div>
            <?php
            $shortcodes = Shortcode::getIdNamePairs();
            if (empty($shortcodes)): ?>
                <p class="alert alert-info fs-15px">You have no any shortcode. Go to Shortcode Generator and make!</p>
            <?php endif;
            FieldManager\SearchInput
                ::create()
                ->setId('woo_shortcode_id')
                ->setValues(empty($shortcodes) ? ['0' => __('Select shortcode')] : $shortcodes)
                ->setValue(Config::$settings['woo_shortcode_id'])
                ->setPlaceholder(__('Select shortcode', 'wpreactions'))
                ->setDisabled(empty($shortcodes))
                ->render();
            ?>
        </div>
        <div class="col-md-3">
            <?php
            if (!empty(Config::$settings['woo_shortcode_id'])): ?>
                <button class="btn btn-primary ml-2 woo-sgc-edit" data-sgc_id="<?php echo Config::$settings['woo_shortcode_id']; ?>">
                    <?php _e('Edit Woo Shortcode', 'wpreactions'); ?>
                </button>
            <?php endif; ?>
        </div>
    </div>
</div>
