<?php
use WPRA\App;
use WPRA\Helpers\Utils;

global $wpdb;
$options = [];
$post_id = 0;
if ( isset( $data ) ) {
	extract( $data );
}
?>

<h2 class="wpra-inside-metabox-header"><span><?php _e( 'Emoji reaction statistics for this page', 'wpreactions' ); ?></span></h2>
<div class="pos-relative">
	<?php Utils::guide( __( 'Emoji Reaction Stats', 'wpreactions' ), 'post-reaction-stats' ); ?>
    <div class="wpra-stats-wrap">
		<?php
		$stats = App::getReactionCountsPerEmoji( $post_id, $options['emojis'] );
		$total      = array_sum( $stats );
		foreach ( $options['emojis'] as $emoji_id ):
			$count = isset( $stats[ $emoji_id ] ) ? $stats[ $emoji_id ] : 0;
			$percentage = $total == 0 ? 0 : round( $count * 100 / $total, 1 ); ?>
            <div class="stat-single-emoji">
                <p class="stat-count"><?php echo $count; ?></p>
                <span class="stat-label"><?php echo $options['flying']['labels'][ $emoji_id ]; ?></span>
                <span class="stat-percentage"><?php echo $percentage; ?>%</span>
            </div>
		<?php endforeach; ?>
    </div>
</div>
