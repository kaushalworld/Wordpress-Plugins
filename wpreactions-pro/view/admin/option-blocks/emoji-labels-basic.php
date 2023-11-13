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
            <span><?php _e('Name Your Reactions', 'wpreactions'); ?></span>
            <?php Utils::tooltip('emoji-labels'); ?>
        </h4>
        <span><?php _e('Type in your own reaction label', 'wpreactions'); ?></span>
    </div>
    <div class="row mb-4 emoji-depended-block" data-option_name="flying-labels">
        <?php foreach ($options['flying']['labels'] as $emoji_id => $label) {
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
            <span><?php _e('Label Styling', 'wpreactions'); ?></span>
            <?php Utils::tooltip('emoji-labels'); ?>
        </h4>
        <span><?php _e('Change color options for labels and text', 'wpreactions'); ?></span>
    </div>
    <div class="row">
        <div class="col">
            <?php
            FieldManager\Color::create()
                ->setId('label_text_color')
                ->setValue($options['label_text_color'])
                ->setStates([
                    'hover'  => $options['label_text_color_hover'],
                    'active' => $options['label_text_color_active'],
                ])
                ->setLabel(__('Text Color', 'wpreactions'))
                ->render();
            ?>
        </div>
        <div class="col">
            <?php
            FieldManager\Range::create()
                ->setId('label_text_size')
                ->setLabel(__('Font Size', 'wpreactions'))
                ->setMax(200)
                ->setValue($options['label_text_size'])
                ->setFactoryValue($defaults['label_text_size'])
                ->render();
            ?>
        </div>
        <div class="col">
            <?php
            FieldManager\Select::create()
                ->setId('label_text_weight')
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
                ->setValue($options['label_text_weight'])
                ->render();
            ?>
        </div>
    </div>
</div>
