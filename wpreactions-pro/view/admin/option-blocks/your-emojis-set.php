<?php
use WPRA\Helpers\Utils;
use WPRA\Config;
?>
<div class="option-wrap">
	<div class="emojis-set-top-bar">
		<div class="sgc-go-back">
			<i class="qa qa-arrow-left mr-2"></i> <?php _e('Emoji Picker', 'wpreactions'); ?>
		</div>
		<?php Utils::tooltip('your-emojis-set'); ?>
	</div>
	<h2 class="emojis-set-title"><?php _e('Your emojis are set!', 'wpreactions'); ?></h2>
	<div class="row emojis-set-items">
		<?php for($i=1; $i <= Config::MAX_EMOJIS ; $i++): ?>
            <div class="col emojis-set-item">
                <div class="emojis-set-item-holder"></div>
            </div>
        <?php endfor; ?>
	</div>
</div>
