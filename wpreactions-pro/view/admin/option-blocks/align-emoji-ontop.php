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
            <span><?php _e('Emoji Reveal', 'wpreactions'); ?></span>
            <?php Utils::tooltip('align-emoji-ontop'); ?>
        </h4>
        <span><?php _e('Choose which side you want your emojis to appear from', 'wpreactions'); ?></span>
    </div>
    <?php
    FieldManager\Radio::create()
        ->setName('reveal_button-ontop_align')
        ->addRadios(
            [
                FieldManager\RadioItem::create()
                    ->setId('ontop_left')
                    ->setValue('left')
                    ->setLabel(__('Left', 'wpreactions')),
                FieldManager\RadioItem::create()
                    ->setId('ontop_center')
                    ->setValue('center')
                    ->setLabel(__('Center', 'wpreactions')),
                FieldManager\RadioItem::create()
                    ->setId('ontop_right')
                    ->setValue('right')
                    ->setLabel(__('Right', 'wpreactions')),
            ]
        )
        ->setChecked($options['reveal_button']['ontop_align'])
        ->addClasses('form-group-inline')
        ->render();
    ?>
</div>