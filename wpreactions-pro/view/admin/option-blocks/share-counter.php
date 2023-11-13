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
            <span><?php _e('Share Counter', 'wpreactions'); ?></span>
            <?php Utils::tooltip('share-counter'); ?>
        </h4>
        <span><?php _e('Show users how many shares you have', 'wpreactions'); ?></span>
    </div>
    <div class="row mb-3">
        <div class="col-md-12">
            <?php
            FieldManager\Checkbox
                ::create()
                ->addCheckbox(
                    'social-counter',
                    $options['social']['counter'],
                    __('Enable/Disable', 'wpreactions'),
                    'true',
                    'share-counter'
                )
                ->render();
            ?>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <?php
            FieldManager\Range
                ::create()
                ->setId('social-counter_size')
                ->setLabel(__('Font size', 'wpreactions'))
                ->setMax(200)
                ->setValue($options['social']['counter_size'])
                ->setFactoryValue($defaults['social']['counter_size'])
                ->render();
            ?>
        </div>
        <div class="col">
            <?php
            FieldManager\Select
                ::create()
                ->setId('social-counter_weight')
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
                ->setValue($options['social']['counter_weight'])
                ->render();
            ?>
        </div>
        <div class="col">
            <?php
            FieldManager\Color
                ::create()
                ->setId('social-counter_color')
                ->setLabel(__('Color', 'wpreactions'))
                ->setValue($options['social']['counter_color'])
                ->setFactoryValue($defaults['social']['counter_color'])
                ->render();
            ?>
        </div>
    </div>
    <?php if (Utils::isPage('global-options')): ?>
        <div class="row mt-3">
            <div class="col-md-12">
                <?php
                FieldManager\Checkbox
                    ::create()
                    ->addCheckbox(
                        'social-random_fake',
                        $options['social']['random_fake'],
                        __('Enable/Disable fake share click generation on post creation', 'wpreactions'),
                        'true',
                        'random-fake-social'
                    )
                    ->render();
                ?>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col">
                <?php
                FieldManager\Text
                    ::create()
                    ->setId('social-random_fake_range')
                    ->setLabel(__('Fake count range', 'wpreactions'))
                    ->setValue($options['social']['random_fake_range'])
                    ->addClasses('validate-range')
                    ->render();
                ?>
            </div>
        </div>
    <?php endif; ?>
    <?php if (Utils::isPage('shortcode-generator')):
        $social_fake_count = isset($options['social']['fake_count']) ? $options['social']['fake_count'] : 0; ?>
        <div class="row mt-3">
            <div class="col">
                <?php
                FieldManager\Text
                    ::create()
                    ->setId('social-fake_count')
                    ->setLabel(__('Fake total count', 'wpreactions'))
                    ->setValue($social_fake_count)
                    ->render();
                ?>
            </div>
        </div>
    <?php endif; ?>
</div>