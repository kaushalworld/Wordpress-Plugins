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
            <span><?php _e('Progress Bars', 'wpreactions'); ?></span>
            <?php Utils::tooltip('progress-bars'); ?>
        </h4>
        <span><?php _e('Customize your design', 'wpreactions'); ?></span>
    </div>
    <div class="row mb-3 align-items-center">
        <div class="col-md-12">
            <?php
            FieldManager\Checkbox::create()
                ->addCheckbox(
                    'count_percentage',
                    $options['count_percentage'],
                    __('Enable user counts to show percentage instead of numeric', 'wpreactions'),
                    'true',
                    'count-percentage'
                )
                ->render();
            ?>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-4">
            <?php
            FieldManager\Color
                ::create()
                ->setId('bar_background_color')
                ->setValue($options['bar_background_color'])
                ->setFactoryValue($defaults['bar_background_color'])
                ->setLabel(__('Background Color', 'wpreactions'))
                ->render();
            ?>
        </div>
        <div class="col-md-4">
            <?php
            FieldManager\Color
                ::create()
                ->setId('bar_progress_color')
                ->setValue($options['bar_progress_color'])
                ->setFactoryValue($defaults['bar_progress_color'])
                ->setLabel(__('Progress Bar Color', 'wpreactions'))
                ->render();
            ?>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <?php
            FieldManager\Color
                ::create()
                ->setId('bar_count_color')
                ->setValue($options['bar_count_color'])
                ->setFactoryValue($defaults['bar_count_color'])
                ->setLabel(__('Number Color', 'wpreactions'))
                ->render();
            ?>
        </div>
        <div class="col">
            <?php
            FieldManager\Range::create()
                ->setId('bar_count_size')
                ->setLabel(__('Number Font Size', 'wpreactions'))
                ->setMax(200)
                ->setValue($options['bar_count_size'])
                ->setFactoryValue($defaults['bar_count_size'])
                ->render();
            ?>
        </div>
        <div class="col">
            <?php
            FieldManager\Select::create()
                ->setId('bar_count_weight')
                ->setLabel(__('Number Font Weight', 'wpreactions'))
                ->setValues([
                    '100' => '100',
                    '200' => '200',
                    '300' => '300',
                    '400' => '400',
                    '500' => '500',
                    '600' => '600',
                    '700' => '700',
                ])
                ->setValue($options['bar_count_weight'])
                ->render();
            ?>
        </div>
    </div>
</div>
