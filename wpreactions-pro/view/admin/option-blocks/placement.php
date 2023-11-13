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
        <h4 class="mb-3">
            <span><?php _e('On-Page Placement Options', 'wpreactions'); ?></span>
            <?php Utils::tooltip('placement'); ?>
        </h4>
    </div>
    <p class="m-0 mb-3"><?php _e('Display:', 'wpreactions'); ?></p>
    <?php
    FieldManager\Radio::create()
        ->setName('content_position')
        ->addRadios(
            [
                FieldManager\RadioItem
                    ::create()
                    ->setId('before_content')
                    ->setValue('before')
                    ->setLabel(__('Before content', 'wpreactions')),
                FieldManager\RadioItem
                    ::create()
                    ->setId('after_content')
                    ->setValue('after')
                    ->setLabel(__('After content', 'wpreactions')),
                FieldManager\RadioItem
                    ::create()
                    ->setId('both_content')
                    ->setValue('both')
                    ->setLabel(__('Before & After content', 'wpreactions')),
            ]
        )
        ->setChecked($options['content_position'])
        ->addClasses('form-group-inline')
        ->render();
    ?>
    <p class="mt-3"><?php _e('Align:', 'wpreactions'); ?></p>
    <?php
    FieldManager\Radio::create()
        ->setName('align')
        ->addRadios(
            [
                FieldManager\RadioItem
                    ::create()
                    ->setId('align_left')
                    ->setValue('left')
                    ->setLabel(__('Left', 'wpreactions')),
                FieldManager\RadioItem
                    ::create()
                    ->setId('align_center')
                    ->setValue('center')
                    ->setLabel(__('Center', 'wpreactions')),
                FieldManager\RadioItem
                    ::create()
                    ->setId('align_right')
                    ->setValue('right')
                    ->setLabel(__('Right', 'wpreactions')),
            ]
        )
        ->setChecked($options['align'])
        ->addClasses('form-group-inline')
        ->render();
    ?>
</div>
