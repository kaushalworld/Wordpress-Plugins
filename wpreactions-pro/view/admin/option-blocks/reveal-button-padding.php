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
            <span><?php _e('Button Padding', 'wpreactions'); ?></span>
            <?php Utils::tooltip('reveal-button-padding'); ?>
        </h4>
        <span><?php _e('Adjust the inner padding to resize your button', 'wpreactions'); ?></span>
    </div>
    <div class="row mb-3">
        <div class="col-md-6">
            <?php
            FieldManager\Range::create()
                ->setId('reveal_button-padding_top')
                ->setLabel(__('Top', 'wpreactions'))
                ->setMax(200)
                ->setValue($options['reveal_button']['padding_top'])
                ->setFactoryValue($defaults['reveal_button']['padding_top'])
                ->render();
            ?>
        </div>
        <div class="col-md-6">
            <?php
            FieldManager\Range::create()
                ->setId('reveal_button-padding_right')
                ->setLabel(__('Right', 'wpreactions'))
                ->setMax(200)
                ->setValue($options['reveal_button']['padding_right'])
                ->setFactoryValue($defaults['reveal_button']['padding_right'])
                ->render();
            ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <?php
            FieldManager\Range::create()
                ->setId('reveal_button-padding_bottom')
                ->setLabel(__('Bottom', 'wpreactions'))
                ->setMax(200)
                ->setValue($options['reveal_button']['padding_bottom'])
                ->setFactoryValue($defaults['reveal_button']['padding_bottom'])
                ->render();
            ?>
        </div>
        <div class="col-md-6">
            <?php
            FieldManager\Range::create()
                ->setId('reveal_button-padding_left')
                ->setLabel(__('Left', 'wpreactions'))
                ->setMax(200)
                ->setValue($options['reveal_button']['padding_left'])
                ->setFactoryValue($defaults['reveal_button']['padding_left'])
                ->render();
            ?>
        </div>
    </div>
</div>