<?php

use WPRA\Helpers\Utils;
use WPRA\Config;
use WPRA\Shortcode;

$sgc_count = Shortcode::getCount();
$sgc_pages = ceil($sgc_count / Config::MY_SHORTCODES_PAGE_LIMIT);
?>

<div class="wpreactions-admin-wrap wpra-my-shortcodes">
    <?php
    Utils::renderTemplate('view/admin/components/floating-preview');
    Utils::renderTemplate('view/admin/components/loading-overlay');
    Utils::renderTemplate(
        'view/admin/components/top-bar',
        [
            "section_title" => "MY SHORTCODES",
            "logo"          => Utils::getAsset('images/wpj_logo.png'),
        ]
    );
    Utils::renderTemplate('view/admin/components/banner-big');
    ?>
    <div class="wpra-option-heading d-flex justify-content-between align-items-center heading-left mt-3">
        <div class="">
            <h4>
                <span><?php _e('My Shortcodes', 'wpreactions'); ?></span>
            </h4>
            <span><?php _e('Make changes to your shortcode and more', 'wpreactions'); ?></span>
        </div>
        <div>
            <a href="<?php echo Utils::getAdminPage('shortcode'); ?>" class="btn btn-secondary mr-3">
                <i class="qa qa-plus-circle mr-2"></i>Add New</a>
            <input type="text" id="search-shortcodes" placeholder="<?php _e('Search shortcodes', 'wpreactions'); ?>">
        </div>
    </div>

    <div class="option-wrap p-0">
        <div class="my-shortcodes-table-holder">
            <?php echo Shortcode::listShortcodes(1, true); ?>
        </div>
    </div>
    <?php if ($sgc_pages > 0): ?>
        <div class="my-shortcodes-table-navs">
            <span>Page <span class="my-sgc-current-page">1</span> of <span class="my-sgc-max-page"><?php echo $sgc_pages; ?></span></span>
            <span class="my-shortcodes-table-actions">
            <span class="shortcode-nav-start">
                <i class="qa qa-angle-double-left"></i>
            </span>
            <span class="shortcode-nav-prev">
                <i class="qa qa-angle-left"></i>
            </span>
            <span class="shortcode-nav-next">
                <i class="qa qa-angle-right"></i>
            </span>
            <span class="shortcode-nav-end">
                <i class="qa qa-angle-double-right"></i>
            </span>
        </span>
            <span class="text-right">
            <span class="my-sgc-count"><?php echo $sgc_count; ?></span> items</span>
        </div>
    <?php endif; ?>
</div>
