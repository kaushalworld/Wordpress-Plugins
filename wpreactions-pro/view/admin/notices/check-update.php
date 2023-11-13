<div class="wpra-update-notice notice-warning notice wpra-notice is-dismissible" data-id="check_update">
	<?php if ( isset( $_GET['force-check'] ) ): ?>
        <div>
            <span class="dashicons dashicons-info"></span>
            <span>Find <strong>WP Reactions Pro</strong> in list of plugins below to update it.</span>
        </div>
	<?php else: ?>
        <div>
            <span><strong>WP Reactions Pro:</strong> New version is available.</span>
            <span>To update plugin</span>
            <a href="<?php echo WPRA\Helpers\Utils::admin_url( "update-core.php?force-check=1" ); ?>" class="wpra-update-notice-check">click here.</a>
        </div>
	<?php endif; ?>
</div>