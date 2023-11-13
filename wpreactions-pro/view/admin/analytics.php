<?php

use WPRA\Helpers\Utils;
use WPRA\FieldManager;
use WPRA\Shortcode;

?>
<div class="wpreactions-admin-wrap wpra-analytics">
    <?php
    Utils::renderTemplate('view/admin/components/loading-overlay');
    Utils::renderTemplate(
        'view/admin/components/top-bar',
        [
            "section_title" => "ANALYTICS",
            "logo"          => Utils::getAsset('images/wpj_logo.png'),
            "screen"        => "analytics",
        ]
    );
    Utils::renderTemplate('view/admin/components/banner-big');
    ?>
    <div class="d-flex justify-content-between align-items-center mt-3">
        <ul class="nav nav-pills" id="wpra-analytics-tabs" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" data-toggle="pill" href="#wpra-reactions-analytics">
                    <i class="qar qa-smile"></i>
                    <span>Emoji Reaction Data</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="pill" href="#wpra-social-platforms-analytics">
                    <i class="qa qa-share-alt"></i>
                    <span>Social Sharing Data</span>
                </a>
            </li>
        </ul>
        <?php
        FieldManager\Select
            ::create()
            ->setId('analytics_type')
            ->setName('analytics_type')
            ->setValue(false)
            ->setValues([
                'global'    => 'Global activation data',
                'shortcode' => 'Shortcode data',
            ])
            ->addClasses('ml-3')
            ->addElemClasses('select-boxed')
            ->render();
        ?>
    </div>
    <div class="option-wrap mb-0 analytics-type-shortcode" style="display: none;">
        <div class="option-header">
            <h4>
                <span><?php _e('Choose Shortcode', 'wpreactions'); ?></span>
                <?php Utils::tooltip('analytics-choose-shortcode'); ?>
            </h4>
            <span><?php _e('Choose your Shortcode from the dropdown to load its analytics data', 'wpreactions'); ?></span>
        </div>
        <?php
        FieldManager\SearchInput
            ::create()
            ->setId('analytics_sgc_id')
            ->setValues(Shortcode::getIdNamePairs())
            ->setPlaceholder(__('Select shortcode', 'wpreactions'))
            ->render();
        ?>
    </div>
    <div class="tab-content" id="wpra-analytics-tabContent">
        <div class="tab-pane show active" id="wpra-reactions-analytics">
            <?php Utils::renderTemplate('view/admin/analytics/tabs/reactions'); ?>
        </div>
        <div class="tab-pane" id="wpra-social-platforms-analytics">
            <?php Utils::renderTemplate('view/admin/analytics/tabs/social-platforms'); ?>
        </div>
    </div>
</div>