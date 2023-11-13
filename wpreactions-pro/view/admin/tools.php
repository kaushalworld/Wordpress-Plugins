<?php

use WPRA\Helpers\Utils;
use WPRA\FieldManager;

?>
<div class="wpreactions-admin-wrap wpra-settings">
    <?php
    Utils::renderTemplate('view/admin/components/loading-overlay');
    Utils::renderTemplate(
        'view/admin/components/top-bar',
        [
            "section_title" => "TOOLS",
            "logo"          => Utils::getAsset('images/wpj_logo.png'),
            "screen"        => "tools",
        ]
    );
    Utils::renderTemplate('view/admin/components/banner-big');
    ?>
    <div class="option-wrap">
        <div class="option-header mb-3">
            <h4>
                <span><?php _e('Reset user counts', 'wpreactions'); ?></span>
                <?php Utils::tooltip('advanced-reset-reaction-counts'); ?>
            </h4>
            <span><?php _e('You can reset all reaction counts to ‘0’ for Global Activation and/or Shortcode', 'wpreactions'); ?></span>
        </div>
        <div class="rectangle-checkbox mb-3">
            <input type="checkbox" id="reset_reactions_global">
            <label for="reset_reactions_global"><?php _e('Reset Global Activation Counts', 'wpreactions'); ?></label>
        </div>
        <div class="rectangle-checkbox mb-3">
            <input type="checkbox" id="reset_reactions_shortcodes">
            <label for="reset_reactions_shortcodes"><?php _e('Reset Shortcode Counts', 'wpreactions'); ?></label>
        </div>
        <button class="btn btn-secondary mr-2" id="reset-reaction-counts"><i class="qa qa-redo-alt mr-2"></i>Reset counts</button>
    </div>
    <div class="option-wrap">
        <div class="option-header">
            <h4>
                <span><?php _e('Generate Random Counts', 'wpreactions'); ?></span>
                <?php Utils::tooltip('tools-generate-random-fake-counts'); ?>
            </h4>
            <span><?php _e('Choose where you would like fake random counts applied to', 'wpreactions'); ?></span>
        </div>
        <div>
            <?php
            $post_types_chk = FieldManager\Checkbox::create();
            $post_types_chk->setName('generate-fake-post-types');
            foreach (Utils::getPostTypes() as $post_type) {
                $post_types_chk->addCheckbox("generate_fake_counts-$post_type", $post_type, $post_type);
            }
            $post_types_chk->addClasses('mb-3')->render();
            ?>
        </div>
        <button type="button" class="btn btn-secondary generate-fake-rand-counts" data-type="reactions">
            <i class="qa qa-smile mr-2"></i><?php _e('Generate random reaction counts', 'wpreactions'); ?></button>
        <button type="button" class="btn btn-secondary generate-fake-rand-counts" data-type="social">
            <i class="qa qa-share mr-2"></i><?php _e('Generate random social share counts', 'wpreactions'); ?></button>
    </div>
</div>
