<?php

use WPRA\Helpers\Utils;
use WPRA\FieldManager;

$options = [];
if (isset($data)) {
    extract($data);
}
?>
<div class="option-wrap">
    <div class="option-header">
        <h4>
            <span><?php _e('Social Popup Overlay', 'wpreactions'); ?></span>
            <?php Utils::tooltip('social-popup'); ?>
        </h4>
        <span><?php _e('When enabled your users will be able to share your post within the same button after clicking on a reaction', 'wpreactions'); ?></span>
    </div>
    <?php
    FieldManager\Radio
        ::create()
        ->setName('reveal_button-popup')
        ->addRadios(
            [
                FieldManager\RadioItem
                    ::create()
                    ->setId('popup_share_false')
                    ->setValue('true')
                    ->setLabel(__('Enable Social Sharing', 'wpreactions')),
                FieldManager\RadioItem
                    ::create()
                    ->setId('popup_share_true')
                    ->setValue('false')
                    ->setLabel(__('Disable Social Sharing', 'wpreactions')),
            ]
        )
        ->setChecked($options['reveal_button']['popup'])
        ->addClasses('form-group-inline mb-3')
        ->render();

    FieldManager\Text
        ::create()
        ->setId('reveal_button-popup_header')
        ->setLabel(__('Personalize the share message located in your popup', 'wpreactions'))
        ->setValue($options['reveal_button']['popup_header'])
        ->render();
    ?>
</div>
