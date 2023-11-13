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
            <span><?php _e('Overall Counts', 'wpreactions'); ?></span>
            <?php Utils::tooltip('disqus-total-counts'); ?>
        </h4>
        <span><?php _e('Show your overall response totals and make label', 'wpreactions'); ?></span>
    </div>
    <div class="row">
        <div class="col-md-12 mb-3">
            <?php
            FieldManager\Checkbox::create()
                ->addCheckbox('show_total_counts', $options['show_total_counts'], __('Enable/Disable', 'wpreactions'))
                ->render();
            ?>
        </div>
        <div class="col-md-12 mb-3">
            <?php
            FieldManager\Text::create()
                ->setId('total_counts_label')
                ->setLabel(__('Total counts label', 'wpreactions'))
                ->setValue($options['total_counts_label'])
                ->render();
            ?>
        </div>
        <div class="col">
            <?php
            FieldManager\Range::create()
                ->setId('total_counts_size')
                ->setLabel(__('Font Size', 'wpreactions'))
                ->setMax(200)
                ->setValue($options['total_counts_size'])
                ->setFactoryValue($defaults['total_counts_size'])
                ->render();
            ?>
        </div>
        <div class="col">
            <?php
            FieldManager\Select::create()
                ->setId('total_counts_weight')
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
                ->setValue($options['total_counts_weight'])
                ->render();
            ?>
        </div>
        <div class="col">
            <?php
            FieldManager\Color
                ::create()
                ->setId('total_counts_color')
                ->setValue($options['total_counts_color'])
                ->setFactoryValue($defaults['total_counts_color'])
                ->setLabel(__('Color', 'wpreactions'))
                ->render();
            ?>
        </div>
    </div>
</div>