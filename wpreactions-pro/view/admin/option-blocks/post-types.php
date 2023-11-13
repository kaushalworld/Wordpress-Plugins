<?php

use WPRA\Helpers\Utils;
use WPRA\FieldManager;

$options = [];
if (isset($data)) {
    extract($data);
}

// do not show product in custom posts list, it is controlled by woo integration
$post_types = Utils::getPostTypes(['product']);
?>

<div class="option-wrap">
    <div class="option-header">
        <h4>
            <span><?php _e('Post types', 'wpreactions'); ?></span>
            <?php Utils::tooltip('post-types'); ?>
        </h4>
        <span><?php _e('Choose the post types that you would like your emoji reactions to be shown.', 'wpreactions'); ?></span>
    </div>
    <div>
        <p class="d-inline-block"><?php _e('Manual deployment:', 'wpreactions'); ?></p>
        <?php Utils::tooltip('post-types-deploy-manual'); ?>
    </div>
    <div>
        <?php
        $checkbox = FieldManager\Checkbox::create();
        $checkbox->setName('post_types_deploy_manual');
        foreach ($post_types as $post_type) {
            $checked = in_array($post_type, $options['post_types_deploy_manual']) ? $post_type : '';
            $checkbox->addCheckbox('post_types_deploy_manual_' . $post_type, $post_type, $post_type, $checked);
        }
        $checkbox->addClasses('d-inline-block mr-3')->render();
        ?>
    </div>
    <div class="mt-4">
        <p class="d-inline-block"><?php _e('Auto deployment:', 'wpreactions'); ?></p>
        <?php Utils::tooltip('post-types-deploy-auto'); ?>
    </div>
    <div>
        <?php
        $checkbox = FieldManager\Checkbox::create();
        $checkbox->setName('post_types_deploy_auto');
        foreach ($post_types as $post_type) {
            $checked = in_array($post_type, $options['post_types_deploy_auto']) ? $post_type : '';
            $checkbox->addCheckbox('post_types_deploy_auto_' . $post_type, $post_type, $post_type, $checked);
        }
        $checkbox->addClasses('d-inline-block mr-3')->render();
        ?>
    </div>
</div>
