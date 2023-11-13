<?php

use WPRA\FieldManager;
use WPRA\Helpers\Utils;

$options = [];
if (isset($data)) {
    extract($data);
}
?>
<div class="option-wrap reveal-button-icon-style">
    <div class="option-header">
        <h4>
            <span><?php _e('Button Icon Styling', 'wpreactions'); ?></span>
            <?php Utils::tooltip('reveal-button-icon-style'); ?>
        </h4>
        <span><?php _e('Choose your color options and positioning', 'wpreactions'); ?></span>
    </div>
    <div class="row mb-3">
        <div class="col-md-12">
            <?php
            FieldManager\Radio
                ::create()
                ->setName('reveal_button-icon_position')
                ->addRadios(
                    [
                        FieldManager\RadioItem
                            ::create()
                            ->setId('icon_left')
                            ->setValue('left')
                            ->setLabel(__('Before text', 'wpreactions')),
                        FieldManager\RadioItem
                            ::create()
                            ->setId('icon_right')
                            ->setValue('right')
                            ->setLabel(__('After text', 'wpreactions')),
                    ]
                )
                ->setChecked($options['reveal_button']['icon_position'])
                ->addClasses('form-group-inline')
                ->render();
            ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3">
            <?php
            FieldManager\Color
                ::create()
                ->setId('reveal_button-icon_color')
                ->setLabel(__('Icon color', 'wpreactions'))
                ->setValue($options['reveal_button']['icon_color'])
                ->setFactoryValue($defaults['reveal_button']['icon_color'])
                ->render();
            ?>
        </div>
        <div class="col-md-3">
            <?php
            FieldManager\Color
                ::create()
                ->setId('reveal_button-icon_hover_color')
                ->setLabel(__('Icon hover color', 'wpreactions'))
                ->setValue($options['reveal_button']['icon_hover_color'])
                ->setFactoryValue($defaults['reveal_button']['icon_hover_color'])
                ->render();
            ?>
        </div>
        <div class="col-md-3">
            <?php
            FieldManager\Range::create()
                ->setId('reveal_button-icon_size')
                ->setLabel(__('Icon size', 'wpreactions'))
                ->setMax(200)
                ->setValue($options['reveal_button']['icon_size'])
                ->setFactoryValue($defaults['reveal_button']['icon_size'])
                ->render();
            ?>
        </div>
        <div class="col-md-3">
            <?php
            FieldManager\Range::create()
                ->setId('reveal_button-icon_space')
                ->setLabel(__('Icon spacing', 'wpreactions'))
                ->setMax(100)
                ->setValue($options['reveal_button']['icon_space'])
                ->setFactoryValue($defaults['reveal_button']['icon_space'])
                ->render();
            ?>
        </div>
    </div>
</div>