<?php

use WPRA\FieldManager;
use WPRA\Helpers\Utils;

$options = [];
if (isset($data)) {
    extract($data);
}
?>

<div class="option-wrap">
    <div class="option-header">
        <h4>
            <span><?php _e('Generate Random Counts', 'wpreactions'); ?></span>
            <?php Utils::tooltip('random-fake-counts'); ?>
        </h4>
        <span><?php _e('Set a range of counts you would like to see distributed on all new pages and posts to get your share counters started.', 'wpreactions'); ?></span>
    </div>
    <div class="row mb-3">
        <div class="col-md-12">
            <?php
            FieldManager\Checkbox::create()
                ->addCheckbox(
                    'random_fake_counts',
                    $options['random_fake_counts'],
                    __('Enable / Disable', 'wpreactions')
                )
                ->render();
            ?>
        </div>
    </div>
    <div class="row emoji-depended-block" data-option_name="random_fake_counts_range" data-def_val="0-0">
        <?php foreach ($options['random_fake_counts_range'] as $emoji_id => $range) {
            FieldManager\Text::create()
                ->setType('text')
                ->setId('random_fake_counts_range-' . $emoji_id)
                ->setData(['emoji_id' => $emoji_id])
                ->setValue($range)
                ->addClasses('col random-fake-count-range-item validate-range')
                ->setElemBefore('<div class="icon-input-label"></div>')
                ->render();
        } ?>
    </div>
</div>
