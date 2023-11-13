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
            <span><?php _e('Background Border Styling', 'wpreactions'); ?></span>
            <?php Utils::tooltip('border'); ?>
        </h4>
    </div>
    <div class="row align-items-end">
        <div class="col-md-6">
            <?php
            FieldManager\Range::create()
                ->setId('border_radius')
                ->setLabel(__('Border Radius', 'wpreactions'))
                ->setMax(200)
                ->setValue($options['border_radius'])
                ->setFactoryValue($defaults['border_radius'])
                ->addClasses('form-group mb-3')
                ->render();
            ?>
        </div>
        <div class="col-md-6">
            <?php
            FieldManager\Range::create()
                ->setId('border_width')
                ->setLabel(__('Border Width', 'wpreactions'))
                ->setMax(100)
                ->setValue($options['border_width'])
                ->setFactoryValue($defaults['border_width'])
                ->addClasses('form-group mb-3')
                ->render();
            ?>
        </div>
        <div class="col-md-6">
            <?php
            FieldManager\Color
                ::create()
                ->setId('border_color')
                ->setLabel(__('Border Color', 'wpreactions'))
                ->setValue($options['border_color'])
                ->setFactoryValue($defaults['border_color'])
                ->addClasses('form-group mb-md-0 mb-3')
                ->render();
            ?>
        </div>
        <div class="col-md-6">
            <?php
            FieldManager\Select::create()
                ->setId('border_style')
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
                ->setValue($options['border_style'])
                ->addClasses('form-group')
                ->render();
            ?>
        </div>
    </div>
</div>
