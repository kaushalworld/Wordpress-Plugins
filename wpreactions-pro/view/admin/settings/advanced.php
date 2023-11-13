<?php

use WPRA\Config;
use WPRA\Helpers\Utils;
use WPRA\FieldManager;

if (isset($data)) {
    extract($data);
}

$download_log_url = Utils::admin_url('admin-ajax.php?action=wpra_handle_admin_requests&sub_action=download_logs');
?>
<div class="row">
    <div class="col-md-12">
        <div class="option-wrap">
            <div class="option-header mb-3">
                <h4>
                    <span><?php _e('Uninstallation data handling', 'wpreactions'); ?></span>
                    <?php Utils::tooltip('purge-on-uninstallation'); ?>
                </h4>
                <span><?php _e('Purge all plugin data after uninstalling the plugin', 'wpreactions'); ?></span>
            </div>
            <?php
            FieldManager\Checkbox
                ::create()
                ->addCheckbox(
                    'purge_on_uninstallation',
                    Config::$settings['purge_on_uninstallation'],
                    __('Purge plugin data on uninstallation', 'wpreactions'),
                    1
                )
                ->addClasses('form-group')
                ->render();
            ?>
        </div>        
        <div class="option-wrap">
            <div class="option-header mb-3">
                <h4>
                    <span><?php _e('Logging', 'wpreactions'); ?></span>
                    <?php Utils::tooltip('logging-control'); ?>
                </h4>
                <span><?php _e('Control logging level of plugin', 'wpreactions'); ?></span>
            </div>
            <?php
            FieldManager\Select
                ::create()
                ->setId('log_level')
                ->setName('log_level')
                ->setValue(Config::$settings['log_level'])
                ->setValues(['Disabled', 'Error', 'Warn', 'Info', 'Debug'])
                ->addClasses('w-25')
                ->render();
            ?>
            <div class="mt-3">
                <a class="btn btn-secondary w-25" href="<?php echo  $download_log_url; ?>" target="_blank"><i class="qa qa-download mr-2"></i>Download Logs</a>
            </div>
        </div>
    </div>
</div>