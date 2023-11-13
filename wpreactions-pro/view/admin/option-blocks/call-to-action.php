<?php

use WPRA\Helpers\Utils;
use WPRA\FieldManager;

$options = [];
$layout  = '';
if (isset($data)) {
    extract($data);
}
?>
<div class="option-wrap">
    <div class="row">
        <div class="col-md-12">
            <div class="option-header">
                <h4>
                    <span><?php _e('Call to Action'); ?></span>
                    <?php Utils::tooltip('call-to-action'); ?>
                </h4>
                <span><?php _e('Write a message located above your emojis.', 'wpreactions'); ?></span>
            </div>
            <?php
            FieldManager\Radio
                ::create()
                ->setName('show_title')
                ->addRadios(
                    [
                        FieldManager\RadioItem
                            ::create()
                            ->setId('title_true')
                            ->setValue('true')
                            ->setLabel(__('Show CTA', 'wpreactions')),
                        FieldManager\RadioItem
                            ::create()
                            ->setId('title_false')
                            ->setValue('false')
                            ->setLabel(__('Hide CTA', 'wpreactions')),
                    ]
                )
                ->setChecked($options['show_title'])
                ->addClasses('form-group-inline mb-3')
                ->render();
            ?>
        </div>
    </div>
    <div class="row">
        <div class="form-group col-md-12">
            <?php
            FieldManager\Text
                ::create()
                ->setId('title_text')
                ->setValue($options['title_text'])
                ->render();
            ?>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <?php
                FieldManager\Range
                    ::create()
                    ->setId('title_size')
                    ->setLabel(__('Font Size', 'wpreactions'))
                    ->setMax(200)
                    ->setValue($options['title_size'])
                    ->setFactoryValue($defaults['title_size'])
                    ->render();
                ?>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <?php
                FieldManager\Select
                    ::create()
                    ->setId('title_weight')
                    ->setLabel(__('Font Weight', 'wpreactions'))
                    ->setValues([
                        '100' => '100',
                        '200' => '200',
                        '300' => '300',
                        '400' => '400',
                        '500' => '500',
                        '600' => '600',
                        '700' => '700',
                    ])
                    ->setValue($options['title_weight'])
                    ->render();
                ?>
            </div>
        </div>
        <div class="col-md-4">
            <?php
            FieldManager\Color
                ::create()
                ->setId('title_color')
                ->setLabel(__('Color', 'wpreactions'))
                ->setValue($options['title_color'])
                ->setFactoryValue($defaults['title_color'])
                ->render();
            ?>
        </div>
    </div>
    <?php if ($layout == 'bimber'): ?>
        <div class="row mt-4 mb-3">
            <div class="col-md-12">
                <?php
                FieldManager\Checkbox
                    ::create()
                    ->addCheckbox(
                        'title_border',
                        $options['title_border'],
                        __('Enable separator under call to action', 'wpreactions')
                    )
                    ->render();
                ?>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <?php
                FieldManager\Color
                    ::create()
                    ->setId('title_border_color')
                    ->setValue($options['title_border_color'])
                    ->setLabel(__('Color', 'wpreactions'))
                    ->setFactoryValue($defaults['title_border_color'])
                    ->render();
                ?>
            </div>
            <div class="col">
                <?php
                FieldManager\Range
                    ::create()
                    ->setId('title_border_size')
                    ->setLabel(__('Height', 'wpreactions'))
                    ->setMax(20)
                    ->setValue($options['title_border_size'])
                    ->setFactoryValue($defaults['title_border_size'])
                    ->render();
                ?>
            </div>
            <div class="col">
                <?php
                FieldManager\Select
                    ::create()
                    ->setId('title_border_style')
                    ->setLabel(__('Style', 'wpreactions'))
                    ->setValues([
                        'dotted' => 'dotted',
                        'dashed' => 'dashed',
                        'solid'  => 'solid',
                        'double' => 'double',
                        'groove' => 'groove',
                        'ridge'  => 'ridge',
                        'none'   => 'none',
                    ])
                    ->setValue($options['title_border_style'])
                    ->addClasses('form-group')
                    ->render();
                ?>
            </div>
        </div>
    <?php endif; ?>
</div>
