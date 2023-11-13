<?php

use WPRA\FieldManager;
use WPRA\Helpers\Utils;

$options = [];
if (isset($data)) {
    extract($data);
}
?>
<div class="option-wrap">
    <div class="option-header">
        <h4>
            <span><?php _e('Button Design', 'wpreactions'); ?></span>
            <?php Utils::tooltip('reveal-button-style'); ?>
        </h4>
        <span><?php _e('Choose your styling options to customize your button.', 'wpreactions'); ?></span>
    </div>
    <div class="row">
        <div class="col-md-4">
            <div class="form-group mb-3">
                <?php
                FieldManager\Color::create()
                    ->setId('reveal_button-text_color')
                    ->setValue($options['reveal_button']['text_color'])
                    ->setFactoryValue($defaults['reveal_button']['text_color'])
                    ->setLabel(__('Text color', 'wpreactions'))
                    ->render();
                ?>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group mb-3">
                <?php
                FieldManager\Range::create()
                    ->setId('reveal_button-font_size')
                    ->setLabel(__('Font size', 'wpreactions'))
                    ->setMax(200)
                    ->setValue($options['reveal_button']['font_size'])
                    ->setFactoryValue($defaults['reveal_button']['font_size'])
                    ->render();
                ?>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group mb-3">
                <?php
                FieldManager\Select::create()
                    ->setId('reveal_button-font_weight')
                    ->setLabel(__('Font weight', 'wpreactions'))
                    ->setValues([
                        '100' => '100',
                        '200' => '200',
                        '300' => '300',
                        '400' => '400',
                        '500' => '500',
                        '600' => '600',
                        '700' => '700',
                    ])
                    ->setValue($options['reveal_button']['font_weight'])
                    ->render();
                ?>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group mb-3">
                <?php
                FieldManager\Color
                    ::create()
                    ->setId('reveal_button-bgcolor')
                    ->setLabel(__('Background color', 'wpreactions'))
                    ->setValue($options['reveal_button']['bgcolor'])
                    ->setFactoryValue($defaults['reveal_button']['bgcolor'])
                    ->render();
                ?>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group mb-3">
                <?php
                FieldManager\Color
                    ::create()
                    ->setId('reveal_button-border_color')
                    ->setLabel(__('Border color', 'wpreactions'))
                    ->setValue($options['reveal_button']['border_color'])
                    ->setFactoryValue($defaults['reveal_button']['border_color'])
                    ->render();
                ?>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group mb-3">
                <?php
                FieldManager\Range::create()
                    ->setId('reveal_button-border_radius')
                    ->setLabel(__('Border radius', 'wpreactions'))
                    ->setMax(200)
                    ->setValue($options['reveal_button']['border_radius'])
                    ->setFactoryValue($defaults['reveal_button']['border_radius'])
                    ->render();
                ?>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group mb-md-0 mb-3">
                <?php
                FieldManager\Color
                    ::create()
                    ->setId('reveal_button-hover_bgcolor')
                    ->setLabel(__('Hover Background color', 'wpreactions'))
                    ->setValue($options['reveal_button']['hover_bgcolor'])
                    ->setFactoryValue($defaults['reveal_button']['hover_bgcolor'])
                    ->render();
                ?>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group mb-md-0 mb-3">
                <?php
                FieldManager\Color
                    ::create()
                    ->setId('reveal_button-hover_text_color')
                    ->setLabel(__('Hover text color', 'wpreactions'))
                    ->setValue($options['reveal_button']['hover_text_color'])
                    ->setFactoryValue($defaults['reveal_button']['hover_text_color'])
                    ->render();
                ?>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <?php
                FieldManager\Color
                    ::create()
                    ->setId('reveal_button-hover_border_color')
                    ->setLabel(__('Hover Border color', 'wpreactions'))
                    ->setValue($options['reveal_button']['hover_border_color'])
                    ->setFactoryValue($defaults['reveal_button']['hover_border_color'])
                    ->render();
                ?>
            </div>
        </div>
    </div>
</div>
