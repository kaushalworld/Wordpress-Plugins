<?php

use WPRA\Helpers\Utils;
use WPRA\FieldManager;
use WPRA\Shortcode;
use WPRA\Config;

$options = [];
$layout  = '';
if (isset($data)) {
    extract($data);
}

$start_counts = isset($options['start_counts'])
    ? $options['start_counts']
    : array_fill_keys(Config::getLayoutDefaults($layout)['emojis'], 0);

$sgc_id        = Utils::get_query_var('id');
$sgc_post_type = Shortcode::getSgcDataBy('id', $sgc_id, ['post_type']);
?>
<div class="option-wrap">
    <?php if (Utils::isPage('shortcode-generator') && !is_null($sgc_post_type)) : ?>
        <div class="wpra-option-block-disabled"><?php _e("This shortcode is used for post type: $sgc_post_type<br>You can have fake counts from post edit screen.", 'wpreactions'); ?></div>
    <?php endif; ?>
    <div class="option-header">
        <h4>
            <span><?php _e('User Reaction Counts', 'wpreactions'); ?></span>
            <?php Utils::tooltip('fake-counts'); ?>
        </h4>
        <span><?php _e('Preset your counts to any number. If left blank, counts will start at "0".', 'wpreactions'); ?></span>
    </div>
    <div class="row mt-3 fake-counts emoji-depended-block" data-option_name="start_counts" data-def_val="0">
        <?php foreach ($start_counts as $emoji_id => $count) {
            FieldManager\Text
                ::create()
                ->setType('number')
                ->setId('start_counts-' . $emoji_id)
                ->setData(['emoji_id' => $emoji_id])
                ->setValue($count)
                ->addClasses('col fake-counts-item')
                ->setElemBefore('<div class="icon-input-label"></div>')
                ->render();
        } ?>
    </div>
</div>