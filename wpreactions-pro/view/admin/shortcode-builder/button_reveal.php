<?php

use WPRA\Helpers\Utils;
use WPRA\Helpers\OptionBlock;

OptionBlock::render('your-emojis-set');
OptionBlock::render('animation-state');
OptionBlock::render('live-counts');
OptionBlock::render('fake-counts');
OptionBlock::render('flying-text');
?>
    <div class="row half-divide">
        <?php
        OptionBlock::render('background');
        OptionBlock::render('border');
        ?>
    </div>
<?php
Utils::renderTemplate(
    'view/admin/components/option-heading',
    [
        'heading'    => __('Create your Button', 'wpreactions'),
        'subheading' => __('Set up your call to action messages and design the perfect button.', 'wpreactions'),
        'tooltip'    => __('heading-button-reveal-opts', 'wpreactions'),
    ]
);
?>
    <div class="row half-divide">
        <?php
        OptionBlock::render('reveal-button-text');
        OptionBlock::render('reveal-share-button-text');
        ?>
    </div>
<?php OptionBlock::render('reveal-button-icon-style'); ?>
    <div class="row half-divide">
        <?php
        OptionBlock::render('reveal-button-padding');
        OptionBlock::render('align-emoji-ontop');
        ?>
    </div>
<?php
OptionBlock::render('reveal-button-style');
Utils::renderTemplate(
    'view/admin/components/option-heading',
    [
        'heading'    => 'Social Sharing Options',
        'subheading' => 'Enable social sharing features for your button',
        'tooltip'    => 'heading-social-media-opts',
    ]
);

OptionBlock::render('social-popup');
OptionBlock::render('social-picker');
OptionBlock::render('alignment');