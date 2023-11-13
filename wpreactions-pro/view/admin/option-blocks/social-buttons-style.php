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
            <span><?php _e('Button Design', 'wpreactions'); ?></span>
            <?php Utils::tooltip('social-button-style'); ?>
        </h4>
    </div>
    <div class="row align-items-end">
        <div class="col-md-3">
            <?php
            FieldManager\Select::create()
                ->setId('social-border_radius')
                ->setLabel(__('Border Radius', 'wpreactions'))
                ->setValues(Utils::pixels(0))
                ->setValue($options['social']['border_radius'])
                ->render();
            ?>
        </div>
        <div class="col-md-9">
            <?php
            FieldManager\Radio::create()
                ->setName('social-button_type')
                ->addRadios(
                    [
                        FieldManager\RadioItem::create()
                            ->setId('solid')
                            ->setValue('solid')
                            ->setLabel(__('Solid Buttons', 'wpreactions')),
                        FieldManager\RadioItem::create()
                            ->setId('bordered')
                            ->setValue('bordered')
                            ->setLabel(__('Button with Border Only', 'wpreactions')),
                    ]
                )
                ->setChecked($options['social']['button_type'])
                ->addClasses('form-group-inline mb-2')
                ->render();
            ?>
        </div>
    </div>
    <div class="row mt-4">
        <div class="col-md-6">
            <?php
            FieldManager\Checkbox::create()
                ->addCheckbox(
                    'social_style_buttons',
                    $options['social_style_buttons'],
                    __('Check to override standard social media colors', 'wpreactions')
                )
                ->addClasses('form-group')
                ->render();
            ?>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-md-3">
            <?php
            FieldManager\Color
                ::create()
                ->setId('social-border_color')
                ->setLabel(__('Border Color', 'wpreactions'))
                ->setValue($options['social']['border_color'])
                ->setFactoryValue($defaults['social']['border_color'])
                ->setDisabled($options['social_style_buttons'] == 'false')
                ->render();
            ?>
        </div>
        <div class="col-md-3">
            <?php
            FieldManager\Color
                ::create()
                ->setId('social-bg_color')
                ->setLabel(__('Background Color', 'wpreactions'))
                ->setValue($options['social']['bg_color'])
                ->setFactoryValue($defaults['social']['bg_color'])
                ->setDisabled($options['social_style_buttons'] == 'false')
                ->render();
            ?>
        </div>
        <div class="col-md-3">
            <?php
            FieldManager\Color
                ::create()
                ->setId('social-text_color')
                ->setLabel(__('Button Text Color', 'wpreactions'))
                ->setValue($options['social']['text_color'])
                ->setFactoryValue($defaults['social']['text_color'])
                ->setDisabled($options['social_style_buttons'] == 'false')
                ->render();
            ?>
        </div>

    </div>
</div>
