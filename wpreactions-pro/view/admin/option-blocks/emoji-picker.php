<?php

use WPRA\Helpers\Utils;
use WPRA\Emojis;
use WPRA\Config;

$options = [];
$layout  = '';
if ( isset( $data ) ) {
	extract( $data );
}

// get current active emojis props to detect format and type
$emoji_data  = Emojis::getData( $options['emojis'] );
$picker_atts = Utils::buildDataAttrs( [
	'base_url' => Emojis::getBaseUrl( 'builtin' ),
	'type'     => 'builtin',
	'format'   => 'svg/json',
	'pair'     => 'true',
] );


Utils::renderTemplate( 'view/admin/components/option-heading',
	[
		'id'         => 'emoji-picker',
		'heading'    => __( 'Emoji Picker', 'wpreactions' ),
		'subheading' => sprintf(
			__( 'Choose %s emojis for this layout. To use our default selections, click "start" or go to next step. To choose your own, click on the "reset" button and start selecting your emojis.', 'wpreactions' ),
			Config::getLayoutValue( $layout, 'max_emojis' )
		),
		'align'      => 'left',
		'tooltip'    => 'emoji-picker',
	]
);

do_action( 'wpreactions/OptionBlock/EmojiPicker/AfterHeading' );
?>
<input type="hidden" class="wpra-no-save" id="picker-type" value="<?php echo $emoji_data['type']; ?>">
<input type="hidden" class="wpra-no-save" id="picker-format" value="<?php echo $emoji_data['format']; ?>">

<button class="reset-emoji-picker btn btn-primary floating-button" type="button">
    <i class="qas qa-redo-alt mr-2"></i> <?php _e( 'Reset', 'wpreactions' ); ?>
</button>
<?php if ( Utils::isPage( 'shortcode' ) ): ?>
    <button class="start-sgc btn btn-primary floating-button" type="button" style="bottom: 80px">
        <i class="qas qa-play-circle mr-2"></i> <?php _e( 'Start', 'wpreactions' ); ?>
    </button>
<?php endif; ?>

<!-- Builtin Emoji Picker -->
<div class="option-wrap emoji-picker" <?php echo $picker_atts; ?>>
    <div class="emoji-picker-grid">
		<?php foreach ( Emojis::get( 'builtin' ) as $emoji ):
			$picker_atts = [
				'emoji_id' => $emoji->id,
				'format'   => $emoji->format,
				'title'    => $emoji->name,
			];
			$active_class = in_array( $emoji->id, $options['emojis'] ) ? 'active' : ''; ?>
            <div class="emoji-pick <?php echo $active_class; ?>" <?php echo Utils::buildDataAttrs( $picker_atts ); ?>>
                <div class="emoji-pick-animated-holder" style="display: none"></div>
                <div class="emoji-pick-static-holder" data-bglazy="<?php echo Emojis::getUrl( $emoji->id, 'svg' ); ?>"></div>
            </div>
		<?php endforeach; ?>
    </div>
</div>

<?php do_action( 'wpreactions/OptionBlock/EmojiPicker/Custom' ); ?>

<div class="option-wrap">
    <div class="drag-and-drop">
        <span><i class="qas qa-arrows-alt mr-2"></i><?php _e( 'DRAG & DROP TO ARRANGE', 'wpreactions' ); ?></span>
        <button class="btn btn-light reset-emoji-picker fs-14px" type="button">
            <i class="qas qa-redo-alt mr-1 fs-12px"></i> <?php _e( 'Reset', 'wpreactions' ); ?>
        </button>
    </div>
    <div class="picker-empty">
        <span class="color-black-400">
            <i class="qas qa-info-circle mr-2"></i><?php _e( 'Choose the emojis for your layout', 'wpreactions' ); ?>
        </span>
    </div>
    <div class="picked-emojis">
		<?php foreach ( $options['emojis'] as $name => $id ): ?>
            <div class="picked-emoji" data-emoji_id="<?php echo $id; ?>">
                <div class="picked-emoji-holder"></div>
            </div>
		<?php endforeach; ?>
    </div>
</div>
