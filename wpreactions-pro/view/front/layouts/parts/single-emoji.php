<?php

use WPRA\Emojis;

$animation    = 'false';
$emoji_id     = 0;
$emoji_format = '';
$is_lottie    = false;

isset($data) && extract($data);
?>

<div class="wpra-reaction-emoji">
    <?php
    do_action('wpreactions/beforeSingleEmoji', $data);
    if ($animation == 'true'): ?>
        <?php if ($is_lottie): ?>
            <div class="wpra-reaction-emoji-holder wpra-reaction-animation-holder" data-emoji_id="<?php echo $emoji_id; ?>"></div>
        <?php else: ?>
            <div class="wpra-reaction-emoji-holder wpra-reaction-animation-holder">
                <img src="<?php echo Emojis::getUrl($emoji_id, $emoji_format, 2); ?>" alt="">
            </div>
        <?php endif; ?>
    <?php elseif ($animation == 'on_hover' || $animation == 'on_hover_all'): ?>
        <div class="wpra-reaction-emoji-holder wpra-reaction-animation-holder" data-emoji_id="<?php echo $emoji_id; ?>" style="display: none;"></div>
        <div class="wpra-reaction-emoji-holder wpra-reaction-static-holder">
            <img src="<?php echo Emojis::getUrl($emoji_id, $emoji_format); ?>" alt="">
        </div>
    <?php elseif ($animation == 'false'): ?>
        <div class="wpra-reaction-emoji-holder wpra-reaction-static-holder">
            <img src="<?php echo Emojis::getUrl($emoji_id, $emoji_format); ?>" alt="">
        </div>
    <?php endif;
    do_action('wpreactions/afterSingleEmoji', $data);
    ?>
</div>