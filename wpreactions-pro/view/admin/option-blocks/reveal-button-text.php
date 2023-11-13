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
            <span><?php _e('Primary Call to Action', 'wpreactions'); ?></span>
            <?php Utils::tooltip('reveal-button-text'); ?>
        </h4>
        <span><?php _e('Create a message for your button.', 'wpreactions'); ?></span>
    </div>
    <?php
    FieldManager\Text::create()
        ->setId('reveal_button-text')
        ->setValue($options['reveal_button']['text'])
        ->setLabel(__('Personalize your call to action', 'wpreactions'))
        ->addClasses('form-group')
        ->render();

    FieldManager\Checkbox::create()
        ->addCheckbox('reveal_button-icon_active', $options['reveal_button']['icon_active'], __('Add icon', 'wpreactions'))
        ->addClasses('from-group')
        ->render();

    FieldManager\IconSearch::create()
        ->setId('reveal_button-icon')
        ->setValue($options['reveal_button']['icon'])
        ->setPlaceholder(__('Type to search icons...', 'wpreactions'))
        ->render();
    ?>
</div>
