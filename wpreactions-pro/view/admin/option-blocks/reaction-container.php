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
            <span><?php _e('Reaction Container Styling', 'wpreactions'); ?></span>
            <?php Utils::tooltip('reaction-container'); ?>
        </h4>
        <span><?php _e('Change color options for labels and text', 'wpreactions'); ?></span>
    </div>
    <div class="row mb-3">
        <div class="col-md-4">
            <?php
            FieldManager\Select::create()
                ->setId('reaction_border_radius')
                ->setLabel(__('Border Radius', 'wpreactions'))
                ->setValues(Utils::pixels(0))
                ->setValue($options['reaction_border_radius'])
                ->render();
            ?>
        </div>
        <div class="col-md-4">
            <?php
            FieldManager\Range::create()
                ->setId('reaction_border_width')
                ->setLabel(__('Border Width', 'wpreactions'))
                ->setMax(200)
                ->setValue($options['reaction_border_width'])
                ->setFactoryValue($defaults['reaction_border_width'])
                ->render();
            ?>
        </div>
        <div class="col-md-4">
            <?php
            FieldManager\Select::create()
                ->setId('reaction_border_style')
                ->setLabel(__('Border Style', 'wpreactions'))
                ->setValues([
                    'dotted' => 'dotted',
                    'dashed' => 'dashed',
                    'solid'  => 'solid',
                    'double' => 'double',
                    'groove' => 'groove',
                    'ridge'  => 'ridge',
                    'none'   => 'none',
                ])
                ->setValue($options['reaction_border_style'])
                ->render();
            ?>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-4">
            <?php
            FieldManager\Color::create()
                ->setId('reaction_bg_color')
                ->setLabel(__('Background Color', 'wpreactions'))
                ->setStates([
                    'hover'  => $options['reaction_bg_color_hover'],
                    'active' => $options['reaction_bg_color_active'],
                ])
                ->setValue($options['reaction_bg_color'])
                ->render();
            ?>
        </div>
        <div class="col-md-4">
            <?php
            FieldManager\Color::create()
                ->setId('reaction_border_color')
                ->setLabel(__('Border Color', 'wpreactions'))
                ->setStates([
                    'hover'  => $options['reaction_border_color_hover'],
                    'active' => $options['reaction_border_color_active'],
                ])
                ->setValue($options['reaction_border_color'])
                ->render();
            ?>
        </div>
    </div>
</div>