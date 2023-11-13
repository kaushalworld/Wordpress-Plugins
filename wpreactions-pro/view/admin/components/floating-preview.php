<?php
use WPRA\Helpers\Utils;
$source = 'global';
isset($data) && extract($data);
?>
<div class="floating-preview">
	<div class="floating-preview-button" data-source="<?php echo $source; ?>">
		<img src="<?php echo Utils::getAsset( 'images/eye.png' ); ?>">
	</div>
	<div class="floating-preview-holder">
		<div class="floating-preview-loading">
			<div class="wpra-spinner"></div>
			<p class="mt-2 fs-15px"><?php _e( 'Generating preview...', 'wpreactions' ); ?></p>
		</div>
		<span class="floating-preview-close">&times;</span>
		<div class="floating-preview-result"></div>
	</div>
</div>