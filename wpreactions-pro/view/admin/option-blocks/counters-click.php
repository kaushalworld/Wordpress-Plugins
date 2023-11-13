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
            <span><?php _e('Response Counter', 'wpreactions'); ?></span>
            <?php Utils::tooltip('disqus-counter'); ?>
        </h4>
        <span><?php _e('Customize how you want your user counts to be shown', 'wpreactions'); ?></span>
    </div>
    <div class="row mb-3">
        <div class="col-md-12 mb-4">
            <?php
            FieldManager\Radio::create()
                ->setName('show_count')
                ->addRadios(
                    [
                        FieldManager\RadioItem
                            ::create()
                            ->setId('show_count_true')
                            ->setValue('true')
                            ->setLabel(__('Show counts active always', 'wpreactions')),
                        FieldManager\RadioItem
                            ::create()
                            ->setId('show_count_onclick')
                            ->setValue('onclick')
                            ->setLabel(__('Reveal counts on click', 'wpreactions')),
                        FieldManager\RadioItem
                            ::create()
                            ->setId('show_count_false')
                            ->setValue('false')
                            ->setLabel(__('Disable counts', 'wpreactions')),
                    ]
                )
                ->setChecked($options['show_count'])
                ->addClasses('form-group-inline')
                ->render();
            ?>
        </div>
        <div class="col-md-12">
            <?php
            FieldManager\Checkbox::create()
                ->addCheckbox(
                    'count_percentage',
                    $options['count_percentage'],
                    __('Enable user counts to show percentage instead of numeric.', 'wpreactions'),
                    'true',
                    'count-percentage'
                )
                ->render();
            ?>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <?php
            FieldManager\Range::create()
                ->setId('count_size')
                ->setLabel(__('Font Size', 'wpreactions'))
                ->setMax(200)
                ->setValue($options['count_size'])
                ->setFactoryValue($defaults['count_size'])
                ->render();
            ?>
        </div>
        <div class="col">
            <?php
            FieldManager\Select::create()
                ->setId('count_weight')
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
                ->setValue($options['count_weight'])
                ->render();
            ?>
        </div>
        <div class="col">
            <?php
            FieldManager\Color::create()
                ->setId('count_text_color')
                ->setStates([
                    'hover'  => $options['count_text_color_hover'],
                    'active' => $options['count_text_color_active'],
                ])
                ->setValue($options['count_text_color'])
                ->setLabel(__('Color', 'wpreactions'))
                ->render();
            ?>
        </div>
    </div>
</div>
