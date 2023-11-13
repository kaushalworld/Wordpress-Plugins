<?php

use WPRA\Helpers\OptionBlock;

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
OptionBlock::render('post-types');
OptionBlock::render('placement');