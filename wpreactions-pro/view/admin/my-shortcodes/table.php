<?php

use WPRA\Helpers\Utils;

$shortcodes = [];
isset( $data ) && extract( $data );
?>

<table class="my-shortcodes-table table">
    <thead>
	<?php Utils::renderTemplate( 'view/admin/my-shortcodes/table-header' ); ?>
    </thead>
    <tbody>
	<?php foreach ( $shortcodes as $shortcode ):
		Utils::renderTemplate( 'view/admin/my-shortcodes/table-body', [ 'shortcode' => $shortcode ] );
	endforeach; ?>
    </tbody>
</table>