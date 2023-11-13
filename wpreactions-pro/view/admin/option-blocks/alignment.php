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
            <span><?php _e('Shortcode Alignment', 'wpreactions'); ?></span>
            <?php Utils::tooltip('alignment'); ?>
        </h4>
        <span><?php _e('Set your emoji reactions to align with your content.', 'wpreactions'); ?></span>
    </div>
    <?php
    FieldManager\Radio::create()
        ->setName('align')
        ->addRadios(
            [
                FieldManager\RadioItem
                    ::create()
                    ->setId('align_left')
                    ->setValue('left')
                    ->setLabel(__('Left-Aligned', 'wpreactions')),
                FieldManager\RadioItem
                    ::create()
                    ->setId('align_center')
                    ->setValue('center')
                    ->setLabel(__('Center-Aligned', 'wpreactions')),
                FieldManager\RadioItem
                    ::create()
                    ->setId('align_right')
                    ->setValue('right')
                    ->setLabel(__('Right-Aligned', 'wpreactions')),
            ]
        )
        ->setChecked($options['align'])
        ->addClasses('form-group-inline')
        ->render();
    ?>
</div>
