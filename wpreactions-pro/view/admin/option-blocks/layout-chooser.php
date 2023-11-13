<?php

use WPRA\Helpers\Utils;
use WPRA\Shortcode;
use WPRA\FieldManager;
use WPRA\Config;
use WPRA\Enqueue;

$options = [];
if (isset($data)) {
    extract($data);
}

$is_global = Utils::isPage('global');

if ($is_global) {
    $selector = 'switch';
    $screen   = 'global';
} else {
    $selector = 'radio';
    $screen   = 'shortcode';
}

?>
<div class="wpra-layouts">
    <?php foreach (Config::$layouts as $layout => $layout_data):
        $options = array_merge(
            $is_global ? Config::getLayoutOptions($layout) : Config::getLayoutDefaults($layout),
            ['source' => 'layout_chooser', 'bind_id' => 'preview_' . $layout,]
        );

        ?>
        <div class="row">
            <div class="col-md-12">
                <div class="option-wrap">
                    <div class="wpra-layout-chooser">
                        <?php
                        if ($selector == 'radio') {
                            FieldManager\Radio
                                ::create()
                                ->setName($screen . '_layout')
                                ->addRadio(
                                    FieldManager\RadioItem
                                        ::create()
                                        ->setId($layout)
                                        ->setValue($layout == 'bimber')
                                        ->setLabel($layout_data['name'])
                                )
                                ->addClasses('m-0')
                                ->render();
                        }

                        if ($selector == 'switch') {
                            echo '<label>' . $layout_data['name'] . '</label>';
                        }

                        Utils::tooltip("layout-chooser-$screen-$layout");

                        if ($is_global): ?>
                            <a href="<?php echo Utils::getAdminPage('global', ['layout' => $layout]); ?>"
                               class="btn btn-secondary-border ml-auto mr-3"><?php _e('Customize', 'wpreactions'); ?>
                            </a>
                            <span class="v-divider"></span>
                        <?php endif;

                        if ($selector == 'switch') {
                            FieldManager\Switcher
                                ::create()
                                ->setId($layout)
                                ->setName($screen . '_layout')
                                ->setValue(Config::isGlobalActivated() && Config::$active_layout == $layout)
                                ->addClasses('ml-3')
                                ->render();
                        } ?>
                    </div>
                    <div class="wpra-layout-chooser-preview">
                        <?php
                        echo Shortcode::build($options); ?>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>
