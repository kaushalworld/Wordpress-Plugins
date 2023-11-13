<?php

use WPRA\Helpers\Utils;
use WPRA\FieldManager;

$options = [];
if (isset($data)) {
    extract($data);
}
?>
<div class="option-wrap">
    <div class="row align-items-center">
        <div class="col-md-12">
            <div class="option-header">
                <h4>
                    <span><?php _e('Button Behavior', 'wpreactions'); ?></span>
                    <?php Utils::tooltip('social-buttons-behavior'); ?>
                </h4>
                <span><?php _e('Choose how you want your users to engage with your social media buttons', 'wpreactions'); ?></span>
            </div>
            <?php
            FieldManager\Radio::create()
                ->setName('enable_share_buttons')
                ->addRadios(
                    [
                        FieldManager\RadioItem::create()
                            ->setId('onclick')
                            ->setValue('onclick')
                            ->setLabel(__('Button Reveal', 'wpreactions')),
                        FieldManager\RadioItem::create()
                            ->setId('always')
                            ->setValue('always')
                            ->setLabel(__('Show Buttons Always', 'wpreactions')),
                        FieldManager\RadioItem::create()
                            ->setId('share_false')
                            ->setValue('false')
                            ->setLabel(__('Hide and Disable Buttons', 'wpreactions'))
                            ->setTooltip('social-share-behavior-disable'),
                    ]
                )
                ->setChecked($options['enable_share_buttons'])
                ->addClasses('form-group-inline')
                ->render();
            ?>
        </div>
    </div>
</div>
