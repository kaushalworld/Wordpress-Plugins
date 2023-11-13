<?php

use WPRA\App;
use WPRA\Config;
use WPRA\Helpers\Utils;

$post_id = 0;
if (isset($data)) {
	extract($data);
}
?>
<h2 class="wpra-inside-metabox-header"><span><?php _e( 'Social sharing statistic for this page', 'wpreactions' ); ?></span></h2>
<div class="pos-relative">
	<?php Utils::guide( __( 'Social Sharing Stats', 'wpreactions' ), 'post-social-stats' ); ?>
	<div class="wpra-share-counts-stats">
		<?php
		$platforms_data = App::getSocialSharePerPlatform( $post_id );
		$total_clicks   = array_sum( $platforms_data );
		foreach ( Config::$social_platforms as $platform => $conf ):
			$platform_count = isset( $platforms_data[ $platform ] ) ? $platforms_data[ $platform ] : 0;
			$perc_click = $total_clicks == 0 ? 0 : round( $platform_count * 100 / $total_clicks, 1 ); ?>
			<div class="wpra-share-counts-stats-item">
				<p><?php echo $platform_count; ?></p>
				<span class="wpra-share-counts-stats-item-count"><?php echo $platform; ?></span>
				<span class="wpra-share-counts-stats-item-label"><?php echo $perc_click; ?>%</span>
			</div>
		<?php endforeach; ?>
	</div>
</div>
