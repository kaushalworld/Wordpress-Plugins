<?php

use WPRA\App;
use WPRA\Emojis;
use WPRA\Helpers\Utils;
use WPRA\FieldManager;

$options      = [];
$post_id      = 0;
$emoji_format = '';

if (isset($data)) {
    extract($data);
}

$fake_counts = App::getFakeCounts($post_id);
?>

<h2 class="wpra-inside-metabox-header"><span><?php _e('Reactions Fake Counts', 'wpreactions'); ?></span></h2>
<div style="position: relative;">
    <p style="text-align: center;font-size: 1rem;"><?php _e('Set user counts to any number.', 'wpreactions'); ?></p>
    <?php Utils::guide(__('Fake Reaction Counts', 'wpreactions'), 'post-fake-counts'); ?>
</div>
<div class="wpra-fake-counts">
    <?php foreach ($options['emojis'] as $emoji_id):
        $value = 0;
        if (isset($fake_counts[$emoji_id])):
            $value = $fake_counts[$emoji_id];
        // for sgc there is no random_fake_counts, so it will not try to generate
        elseif (isset($options['random_fake_counts']) && $options['random_fake_counts'] == 'true'):
            $value = Utils::randomFromRange($options['random_fake_counts_range'][$emoji_id]);
        endif;
        FieldManager\Text
            ::create()
            ->setType('number')
            ->setId('wpra_count_' . $emoji_id)
            ->setValue($value)
            ->setElemAfter('<img src="' . Emojis::getUrl($emoji_id, $emoji_format) . '">')
            ->addClasses('pos-relative num-input-wo-arrows')
            ->render();
        ?>
    <?php endforeach; ?>
</div>
