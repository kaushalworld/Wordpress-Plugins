<?php

$type = $message = '';

isset( $data ) && extract( $data );
?>
<div class="notice-<?php echo $type; ?> notice wpra-notice is-dismissible" data-id="addon_activation">
	<span><strong>WP Reactions Pro:</strong> <?php echo $message; ?></span>
</div>