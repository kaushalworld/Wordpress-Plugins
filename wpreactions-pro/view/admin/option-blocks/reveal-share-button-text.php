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
            <span><?php _e('Social Share Call to Action', 'wpreactions'); ?></span>
            <?php Utils::tooltip('reveal-share-button-text'); ?>
        </h4>
        <span><?php _e('Create a message for your audience to share', 'wpreactions'); ?></span>
    </div>
    <?php
    FieldManager\Text::create()
        ->setId('reveal_button-text_clicked')
        ->setValue($options['reveal_button']['text_clicked'])
        ->setLabel(__('Enter a call to action message asking your user to share', 'wpreactions'))
        ->addClasses('form-group')
        ->render();

    FieldManager\Checkbox::create()
        ->addCheckbox('reveal_button-icon_clicked_active', $options['reveal_button']['icon_clicked_active'], __('Add icon', 'wpreactions'))
        ->addClasses('from-group')
        ->render();

    FieldManager\IconSearch::create()
        ->setId('reveal_button-icon_clicked')
        ->setValue($options['reveal_button']['icon_clicked'])
        ->setPlaceholder(__('Type to search icons...', 'wpreactions'))
        ->render();
    ?>
</div>
