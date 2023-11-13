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
            <span><?php _e('Flying Animation Effect', 'wpreactions'); ?></span>
            <?php Utils::tooltip('flying-text'); ?>
        </h4>
        <span><?php _e('Choose the effect that you would like to occur after an emoji is clicked on', 'wpreactions'); ?></span>
    </div>
    <div class="row mb-3">
        <div class="col-md-12">
            <?php
            FieldManager\Radio::create()
                ->setName('flying-type')
                ->addRadios(
                    [
                        FieldManager\RadioItem
                            ::create()
                            ->setId('flying_disabled')
                            ->setValue('false')
                            ->setLabel(__('Disable effect', 'wpreactions')),
                        FieldManager\RadioItem
                            ::create()
                            ->setId('flying_count')
                            ->setValue('count')
                            ->setLabel(__('Show flying reaction count', 'wpreactions')),
                        FieldManager\RadioItem
                            ::create()
                            ->setId('flying_label')
                            ->setValue('label')
                            ->setLabel(__('Show flying reaction text', 'wpreactions'))
                            ->setTooltip('option-flying-label'),
                    ]
                )
                ->setChecked($options['flying']['type'])
                ->addClasses('form-group')
                ->render();
            ?>
        </div>
    </div>
    <div class="row mb-4 emoji-depended-block" data-option_name="flying-labels">
        <?php
        foreach ($options['flying']['labels'] as $emoji_id => $label) {
            FieldManager\Text::create()
                ->setValue($label)
                ->setId('flying-labels-' . $emoji_id)
                ->setData(['emoji_id' => $emoji_id])
                ->addClasses('col flying-labels-item')
                ->setElemBefore('<div class="icon-input-label"></div>')
                ->render();
        } ?>
    </div>
    <div class="option-header">
        <h4>
            <span><?php _e('Effect styling', 'wpreactions'); ?></span>
            <?php Utils::tooltip('flying-text-styling'); ?>
        </h4>
        <span><?php _e('Use the styling features to personalize your animated effect', 'wpreactions'); ?></span>
    </div>
    <div class="row">
        <div class="col-md-4">
            <?php
            FieldManager\Color
                ::create()
                ->setId('flying-text_color')
                ->setValue($options['flying']['text_color'])
                ->setFactoryValue($defaults['flying']['text_color'])
                ->setLabel(__('Text color', 'wpreactions'))
                ->render();
            ?>
        </div>
        <div class="col-md-4">
            <?php
            FieldManager\Select::create()
                ->setId('flying-font_weight')
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
                ->setValue($options['flying']['font_weight'])
                ->render();
            ?>
        </div>
        <div class="col-md-4">
            <?php
            FieldManager\Range::create()
                ->setId('flying-font_size')
                ->setLabel(__('Font size', 'wpreactions'))
                ->setMin(0)
                ->setMax(200)
                ->setUnit('px')
                ->setValue($options['flying']['font_size'])
                ->setFactoryValue($defaults['flying']['font_size'])
                ->render();
            ?>
        </div>
    </div>
</div>
