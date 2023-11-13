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
            <span><?php _e('Emoji Background Styling', 'wpreactions'); ?></span>
            <?php Utils::tooltip('background'); ?>
        </h4>
    </div>
    <div class="row align-items-end">
        <div class="col-md-12">
            <?php
            FieldManager\Radio
                ::create()
                ->setName('bgcolor_trans')
                ->addRadios(
                    [
                        FieldManager\RadioItem
                            ::create()
                            ->setId('bgcolor_trans_true')
                            ->setValue('true')
                            ->setLabel(__('Transparent Background', 'wpreactions')),
                        FieldManager\RadioItem
                            ::create()
                            ->setId('bgcolor_trans_false')
                            ->setValue('false')
                            ->setLabel(__('Background with Color', 'wpreactions')),
                    ]
                )
                ->setChecked($options['bgcolor_trans'])
                ->addClasses('form-group')
                ->render();
            ?>
        </div>
        <div class="col-md-6 mt-3">
            <?php
            FieldManager\Color
                ::create()
                ->setId('bgcolor')
                ->setLabel(__('Background Color Picker', 'wpreactions'))
                ->setValue($options['bgcolor'])
                ->setFactoryValue($defaults['bgcolor'])
                ->addClasses('mb-3 m-md-0')
                ->render();
            ?>
        </div>
        <div class="col-md-6">
            <?php
            FieldManager\Select::create()
                ->setId('shadow')
                ->setValues([
                    'false'  => 'No shadow',
                    'light'  => 'Light',
                    'medium' => 'Medium',
                    'hard'   => 'Hard',
                    'dark'   => 'Dark',
                ])
                ->setValue($options['shadow'])
                ->setLabel(__('Shadow', 'wpreactions'))
                ->render();
            ?>
        </div>
    </div>
</div>
