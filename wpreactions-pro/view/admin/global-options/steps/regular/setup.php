<?php

use WPRA\Helpers\OptionBlock;

OptionBlock::render('animation-state');
OptionBlock::render('call-to-action');
?>
    <div class="row half-divide">
        <?php
        OptionBlock::render('background');
        OptionBlock::render('border');
        ?>
    </div>
<?php
OptionBlock::render('live-counts');
OptionBlock::render('random-fake-counts');
OptionBlock::render('flying-text');
OptionBlock::render('post-types');
OptionBlock::render('placement');