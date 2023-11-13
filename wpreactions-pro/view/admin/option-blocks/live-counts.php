<?php

use WPRA\Helpers\Utils;
use WPRA\FieldManager;
use WPRA\Config;

$options = [];
if (isset($data)) {
    extract($data);
}

$tooltip_content = Utils::isPage('global') ? 'live-counts-global' : 'live-counts-sgc';
?>

<div class="option-wrap">
    <div class="option-header">
        <h4>
            <span><?php _e('Badges', 'wpreactions'); ?></span>
            <?php Utils::tooltip($tooltip_content); ?>
        </h4>
        <span><?php _e('Enable user reaction counts and manage your badges', 'wpreactions'); ?></span>
    </div>
    <div class="row align-items-center">
        <div class="col-md-12">
            <?php
            FieldManager\Checkbox::create()
                ->addCheckbox(
                    'show_count',
                    $options['show_count'],
                    __('Enable/Disable', 'wpreactions')
                )
                ->render();

            FieldManager\Checkbox::create()
                ->addCheckbox(
                    'count_percentage',
                    $options['count_percentage'],
                    __('Enable user counts to show percentage instead of numeric.', 'wpreactions'),
                    'true',
                    'count-percentage'
                )
                ->addClasses('mt-3')
                ->render();
            ?>
            <div class="row mt-3">
                <div class="col-md-3">
                    <?php
                    FieldManager\Color
                        ::create()
                        ->setId('count_color')
                        ->setValue($options['count_color'])
                        ->setFactoryValue($defaults['count_color'])
                        ->setLabel(__('Color', 'wpreactions'))
                        ->render();
                    ?>
                </div>
                <div class="col-md-3">
                    <?php
                    FieldManager\Color
                        ::create()
                        ->setId('count_text_color')
                        ->setValue($options['count_text_color'])
                        ->setFactoryValue($defaults['count_text_color'])
                        ->setLabel(__('Number Color', 'wpreactions'))
                        ->render();
                    ?>
                </div>
                <div class="col-md-3">
                    <?php
                    FieldManager\Range
                        ::create()
                        ->setId('count_text_size')
                        ->setLabel(__('Font Size', 'wpreactions'))
                        ->setMin(0)
                        ->setMax(100)
                        ->setValue($options['count_text_size'])
                        ->setFactoryValue($options['count_text_size'])
                        ->render();
                    ?>
                </div>
                <div class="col-md-3">
                    <?php
                    FieldManager\Select::create()
                        ->setId('count_text_weight')
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
                        ->setValue($options['count_text_weight'])
                        ->render();
                    ?>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-md-3">
                    <?php
                    FieldManager\Range
                        ::create()
                        ->setId('count_pos_top')
                        ->setLabel(__('Vertical Position', 'wpreactions'))
                        ->setMin(-50)
                        ->setMax(50)
                        ->setValue($options['count_pos_top'])
                        ->setFactoryValue($defaults['count_pos_top'])
                        ->render();
                    ?>
                </div>
                <div class="col-md-3">
                    <?php
                    FieldManager\Range
                        ::create()
                        ->setId('count_width')
                        ->setLabel(__('Width', 'wpreactions'))
                        ->setMin(10)
                        ->setMax(100)
                        ->setValue($options['count_width'])
                        ->setFactoryValue($defaults['count_width'])
                        ->render();
                    ?>
                </div>
                <div class="col-md-3">
                    <?php
                    FieldManager\Range
                        ::create()
                        ->setId('count_height')
                        ->setLabel(__('Height', 'wpreactions'))
                        ->setMin(10)
                        ->setMax(100)
                        ->setValue($options['count_height'])
                        ->setFactoryValue($defaults['count_height'])
                        ->render();
                    ?>
                </div>
                <div class="col-md-3">
                    <?php
                    FieldManager\Range
                        ::create()
                        ->setId('count_border_radius')
                        ->setLabel(__('Border Radius', 'wpreactions'))
                        ->setMin(0)
                        ->setMax(100)
                        ->setValue($options['count_border_radius'])
                        ->setFactoryValue($defaults['count_border_radius'])
                        ->render();
                    ?>
                </div>

            </div>
        </div>
    </div>
</div>
