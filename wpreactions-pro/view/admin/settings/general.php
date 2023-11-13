<?php

use WPRA\FieldManager;
use WPRA\Helpers\Utils;
use WPRA\Config;

if (isset($data)) {
    extract($data);
}
?>

<div class="row">
    <div class="col-md-12">
        <div class="option-wrap">
            <div class="option-header mb-3">
                <h4>
                    <span><?php _e('Reaction limitation per users', 'wpreactions'); ?></span>
                    <?php Utils::tooltip('user-reaction-limitation'); ?>
                </h4>
                <span><?php _e('Allow users to react certain post or page multiple times', 'wpreactions'); ?></span>
            </div>
            <?php
            FieldManager\Checkbox
                ::create()
                ->addCheckbox(
                    'user_reaction_limitation',
                    Config::$settings['user_reaction_limitation'],
                    __('Limit users to react only once', 'wpreactions'),
                    1
                )
                ->addClasses('form-group')
                ->render();
            ?>
        </div>
    </div>
</div>