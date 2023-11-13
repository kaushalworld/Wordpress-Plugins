<?php
use WPRA\App;
use WPRA\Helpers\Utils;

$options = [];
$post_id = 0;
if (isset($data)) {
	extract($data);
}
// if button_reveal supports total social counts, then remove this check
if ( $options['layout'] != 'button_reveal' ): ?>
	<h2 class="wpra-inside-metabox-header"><span><?php _e( 'Social Sharing Fake Counts', 'wpreactions' ); ?></span></h2>
	<div class="wpra-fake-share-counts-wrap">
		<?php
		Utils::guide( __( 'Fake Share Counts', 'wpreactions' ), 'post-fake-share-counts' );
		$default_fake_count = ( isset( $options['social']['random_fake'] ) && $options['social']['random_fake'] == 'true' )
			? Utils::randomFromRange( $options['social']['random_fake_range'] ) : 0;
		$fake_share_count = App::getFakeShareCounts( $post_id, $default_fake_count);
		?>
		<label for="wpra_fake_share_counts"><?php _e( 'Set the total social share count to any number', 'wpreactions' ); ?></label>
		<input type="number" min="0" name="wpra_fake_share_counts" id="wpra_fake_share_counts" value="<?php echo $fake_share_count; ?>">
	</div>
<?php endif; ?>