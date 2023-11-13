<?php

use WPRA\App;
use WPRA\Helpers\Utils;
use WPRA\FieldManager;

$license_info = App::instance()->license()->get_stored_info();
?>
<div class="wpreactions-admin-wrap wpra-dashboard">
    <?php
    Utils::renderTemplate(
        'view/admin/components/top-bar',
        [
            "section_title" => "DASHBOARD",
            "logo"          => Utils::getAsset('images/wpj_logo.png'),
            "screen"        => "dashboard",
        ]
    );

    $activate_class = "";
    $revoke_class   = "d-none";
    if (App::instance()->license()->is_allowed()) :
        echo "<div class=\"alert alert-success mt-3\">WP Reactions Pro " . WPRA_VERSION . '&nbsp;' . __('is activated', 'wpreactions') . "</div>";
        $activate_class = "d-none";
        $revoke_class   = "d-inline-block";
    else :
        echo "<div class=\"alert alert-dark mt-3\">WP Reactions Pro " . WPRA_VERSION . '&nbsp;' . __('is not activated', 'wpreactions') . "</div>";
    endif;
    if (App::currentUserCan('edit_wpreactions')) : ?>
        <div class="row mt-3">
            <div class="col-md-12">
                <div class="option-wrap">
                    <div class="row align-items-end">
                        <div class="col-md-4">
                            <?php
                            (new FieldManager\Text())
                                ->setLabel(__('Your E-mail', 'wpreactions'))
                                ->setId('license_email')
                                ->setValue($license_info['email'])
                                ->setDisabled(App::instance()->license()->is_allowed())
                                ->render();
                            ?>
                        </div>
                        <div class="col-md-4">
                            <label for="license_key"><?php _e('License Key', 'wpreactions'); ?></label>
                            <input type="text" id="license_key" placeholder="License key" class="form-control" autocomplete="off" <?php Utils::echoIf(App::instance()->license()->is_allowed(), 'disabled'); ?> value="<?php echo $license_info['license_key']; ?>"/>
                        </div>
                        <div class="col-md-4">
                            <button id="activate" class="license-key-action btn btn-secondary w-100 <?php echo $activate_class; ?>">
                                <i class="qa qa-key mr-2"></i><?php _e('Activate plugin', 'wpreactions'); ?>
                            </button>
                            <button id="revoke-license" class="btn btn-danger w-100 <?php echo $revoke_class; ?>">
                                <i class="qa qa-times mr-2"></i><?php _e('Revoke license from domain', 'wpreactions'); ?>
                            </button>
                        </div>
                    </div>
                    <div id="activation-result" class="text-danger mb-0 mt-3"></div>
                </div>
            </div>
        </div>
    <?php endif; ?>
    <div class="wpra-folder">
        <div class="wpra-folder-item wpra-white-box">
            <a class="wpra-folder-title" href="<?php echo Utils::getAdminPage('global'); ?>">
                <i class="qa qa-globe"></i>
                <h3><?php _e('Global Activation', 'wpreactions'); ?></h3>
            </a>
            <div class="wpra-folder-desc">
                <?php _e('Deploy your emojis on pages and posts with one-click-activation. Customize your reactions on your blog posts, pages and all post types.', 'wpreactions'); ?>
            </div>
            <div class="wpra-folder-link">
                <a href="<?php Utils::linkToDoc('wpreactions', 'global-activation'); ?>" target="_blank" title="Click to get more info">
                    <span class="wpra-tooltip-icon" style="background-image: url('<?php echo Utils::getAsset('images/tooltip_icon.svg'); ?>')"></span>
                </a>
            </div>
        </div>
        <div class="wpra-folder-item wpra-white-box">
            <a class="wpra-folder-title" href="<?php echo Utils::getAdminPage('shortcode');; ?>">
                <span class="wpra-icon wpra-icon-sh" style="height: 30px;width: 40px;"></span>
                <h3 class="ml-0"><?php _e('Shortcode Generator', 'wpreactions'); ?></h3>
            </a>
            <div class="wpra-folder-desc">
                <?php _e('Make shortcode and paste your reactions under images, videos and anywhere you want to engage users and get a reaction.', 'wpreactions'); ?>
            </div>
            <div class="wpra-folder-link">
                <a href="<?php Utils::linkToDoc('wpreactions', 'shortcode-generator'); ?>" target="_blank" title="Click to get more info">
                    <span class="wpra-tooltip-icon" style="background-image: url('<?php echo Utils::getAsset('images/tooltip_icon.svg'); ?>')"></span>
                </a>
            </div>
        </div>
        <div class="wpra-folder-item wpra-white-box">
            <a class="wpra-folder-title" href="<?php echo Utils::getAdminPage('settings', [], '#wpra-woocommerce-content'); ?>">
                <span class="wpra-icon wpra-icon-woo" style="height: 30px;width: 40px;"></span>
                <h3><?php _e('Woo Reactions', 'wpreactions'); ?></h3>
            </a>
            <div class="wpra-folder-desc">
                <?php _e('Manage the locations for Woo Reactions and place your emoji reactions on product pages so your customers can react to your products.', 'wpreactions'); ?>
            </div>
            <div class="wpra-folder-link">
                <a href="<?php Utils::linkToDoc('wpreactions', 'woo-commerce-integration'); ?>" target="_blank" title="Click to get more info">
                    <span class="wpra-tooltip-icon" style="background-image: url('<?php echo Utils::getAsset('images/tooltip_icon.svg'); ?>')"></span>
                </a>
            </div>
        </div>
        <div class="wpra-folder-item wpra-white-box">
            <a class="wpra-folder-title" href="<?php echo Utils::getAdminPage('analytics'); ?>">
                <i class="qas qa-chart-bar"></i>
                <h3><?php _e('Analytics', 'wpreactions'); ?></h3>
            </a>
            <div class="wpra-folder-desc">
                <?php _e('Monitor how your users are reacting to your content. Collect emotional data and social shares to better understand your users.', 'wpreactions'); ?>
            </div>
            <div class="wpra-folder-link">
                <a href="<?php Utils::linkToDoc('wpreactions', 'analytics'); ?>" target="_blank" title="Click to get more info">
                    <span class="wpra-tooltip-icon" style="background-image: url('<?php echo Utils::getAsset('images/tooltip_icon.svg'); ?>')"></span>
                </a>
            </div>
        </div>
        <div class="wpra-folder-item wpra-white-box">
            <a class="wpra-folder-title" href="<?php echo Utils::getAdminPage('settings'); ?>">
                <i class="qa qa-cog"></i>
                <h3><?php _e('Settings', 'wpreactions'); ?></h3>
            </a>
            <div class="wpra-folder-desc">
                <?php _e('Manage post types that are included in your theme and choose what pages you would like your emojis to show.', 'wpreactions'); ?>
            </div>
            <div class="wpra-folder-link">
                <a href="<?php Utils::linkToDoc('wpreactions', 'settings'); ?>" target="_blank" title="Click to get more info">
                    <span class="wpra-tooltip-icon" style="background-image: url('<?php echo Utils::getAsset('images/tooltip_icon.svg'); ?>')"></span>
                </a>
            </div>
        </div>
        <div class="wpra-folder-item wpra-white-box">
            <a class="wpra-folder-title" href="<?php echo Utils::getAdminPage('shortcode-edit'); ?>">
                <i class="qa qa-list"></i>
                <h3><?php _e('My Shortcodes', 'wpreactions'); ?></h3>
            </a>
            <div class="wpra-folder-desc">
                <?php _e('Easily manage and edit all of your shortcodes in one place with the shortcode editor admin panel.', 'wpreactions'); ?>
            </div>
            <div class="wpra-folder-link">
                <a href="<?php Utils::linkToDoc('wpreactions', 'my-shortcodes'); ?>" target="_blank" title="Click to get more info">
                    <span class="wpra-tooltip-icon" style="background-image: url('<?php echo Utils::getAsset('images/tooltip_icon.svg'); ?>')"></span>
                </a>
            </div>
        </div>
    </div>
    <?php Utils::renderTemplate('view/admin/components/banner-big'); ?>
</div>