<?php

use WPRA\Config;
use WPRA\Helpers\Utils;
use WPRA\Helpers\OptionBlock;

$options = [];
$layout  = '';
isset($data) && extract($data);

?>

<div class="wpreactions-admin-wrap <?php Utils::echoIf(!empty($layout), "wpra-layout-$layout"); ?> wpra-global-options">
    <?php
    Utils::renderTemplate('view/admin/components/floating-preview');
    Utils::renderTemplate('view/admin/components/loading-overlay');
    Utils::renderTemplate(
        'view/admin/components/top-bar',
        [
            "section_title" => "GLOBAL ACTIVATION",
            "logo"          => Utils::getAsset('images/wpj_logo.png'),
        ]
    );

    if (empty($layout)): ?>
        <div id="global-layout-chooser" class="mt-3">
            <div class="global-heading-reset d-flex">
                <?php Utils::renderTemplate(
                    'view/admin/components/option-heading',
                    [
                        'heading'    => 'Global Activation',
                        'subheading' => 'Turn on to activate your reactions on all pages and posts.',
                        'align'      => 'left',
                        'tooltip'    => 'heading-global-layout-chooser',
                    ]
                ); ?>
                <div class="reset-button-holder wpra-white-box">
                    <span id="resetGlobalOptionsToggle">
                        <i class="qa qa-redo"></i>
                        <span>Reset</span>
                    </span>
                    <?php Utils::tooltip('reset-button'); ?>
                </div>
            </div>
            <?php OptionBlock::render("layout-chooser"); ?>
            <button id="customize" class="btn btn-secondary btn-lg w-100" <?php Utils::is_disabled(!Config::isGlobalActivated()); ?>>
                <i class="qa qa-paint-brush mr-2"></i>
                <?php _e('Customize active layout', 'wpreactions'); ?>
            </button>
        </div>
    <?php else:
        Utils::renderTemplate('view/admin/components/banner-big');
        Utils::renderTemplate('view/admin/global-options/steps');
        Utils::renderTemplate('view/admin/global-options/step-control');
    endif; ?>

</div>
