<?php

use WPRA\FieldManager;
use WPRA\Helpers\Utils;

$value = 'false';
if (isset($data)) {
    extract($data);
}
?>
<button type="button" class="wpra-restart-guides">
    <span class="dashicons dashicons-flag"></span> <?php _e('Show Tips', 'wpreactions'); ?>
</button>
<div class="wpra-activate-emojis-wrap">
    <?php
    Utils::guide(__('Activate / Deactivate Reactions', 'wpreactions'), 'post-activate-emoji');
    FieldManager\Switcher
        ::create()
        ->setId('wpra_show_emojis')
        ->setName('wpra_show_emojis')
        ->setLabel(__('Turn emoji reactions on/off for this page', 'wpreactions'))
        ->setValue($value)
        ->addClasses('wpe-switch-small title-inline m-3')
        ->render();
    ?>
</div>
