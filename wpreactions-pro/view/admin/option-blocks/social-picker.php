<?php

use WPRA\Config;
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
            <span><?php _e('Social Share Buttons', 'wpreactions'); ?></span>
            <?php Utils::tooltip('social-picker'); ?>
        </h4>
        <span><?php _e('Turn on to make buttons active. Use custom text in the label fields.', 'wpreactions'); ?></span>
    </div>
    <div class="social-picker">
        <?php foreach ($options['social_platforms'] as $platform => $status) { ?>
            <div class="social-picker-item">
                <?php
                FieldManager\Switcher
                    ::create()
                    ->setId("social_platforms-$platform")
                    ->addClasses('wpe-switch-small')
                    ->setValue($options['social_platforms'][$platform])
                    ->render();
                ?>
                <div class="social-picker-item-img" style="background-color: <?php echo Config::$social_platforms[$platform]['color']; ?>40;">
					<span class="d-inline-block" style="background-color: <?php echo Config::$social_platforms[$platform]['color']; ?>">
                        <img src="<?php echo Utils::getAsset("images/social/$platform.svg"); ?>" alt="">
					</span>
                </div>
                <?php
                FieldManager\Text
                    ::create()
                    ->setId("social_labels-$platform")
                    ->setValue($options['social_labels'][$platform])
                    ->render();
                ?>
            </div>
        <?php } ?>
    </div>
</div>
