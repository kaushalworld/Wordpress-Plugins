<?php

use WPRA\Helpers\Utils;
use WPRA\Helpers\OptionBlock;

OptionBlock::render('your-emojis-set');
OptionBlock::render('animation-state');
OptionBlock::render('call-to-action');
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
OptionBlock::render('social-picker');
OptionBlock::render('share-counter');
OptionBlock::render('social-buttons-style');
OptionBlock::render('social-buttons-behavior');
OptionBlock::render('alignment');