<div class="emotional-data-wrap">
	<?php
	$options = $emotional_data = [];
	isset( $data ) && extract( $data );

	$rdc_with = 100 / sizeof( $options['emojis'] );
	$format   = WPRA\Emojis::getData( $options['emojis'], [ 'format' ] );

	foreach ( $options['emojis'] as $index => $emoji_id ): ?>
        <div class="emotional-data-container" style="width: <?php echo $rdc_with . '%'; ?>"
             data-emoji_id="<?php echo $emoji_id; ?>"
             data-label="<?php echo $options['flying']['labels'][ $emoji_id ]; ?>"
             data-value="<?php echo $emotional_data[ $index ]; ?>">
            <div class="emotional-data-emoji" data-emoji_id="<?php echo $emoji_id; ?>" data-format="<?php echo $format; ?>"></div>
            <div id="emotional-data-graph-emoji-<?php echo $emoji_id; ?>" class="emotional-data-graph"></div>
        </div>
	<?php endforeach; ?>
</div>