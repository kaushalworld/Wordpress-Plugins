<div class="wrap">
    <h1>
        <?php _e( 'White Label', 'brizy-pro' ); ?>
    </h1>

    <h2 class="nav-tab-wrapper">
        <a href="#" class="nav-tab nav-tab-active"><?php _e( 'General', 'brizy-pro' ); ?></a>
    </h2>
    <div class="white-label-form">
	    <?php if ( $message ): ?>
            <div class="notice notice-error is-dismissible">
                <p><?php echo $message; ?></p>
                <button type="button" class="notice-dismiss">
                    <span class="screen-reader-text">
                        <?php _e( 'Dismiss this notice.', 'brizy-pro' ); ?>
                    </span>
                </button>
            </div>
	    <?php endif; ?>

        <form action="<?php echo $action; ?>" method="post">
            <table class="form-table">
	            <?php foreach( $defaultData as $key => $defaultValue ): ?>
		            <?php if ( $defaultValue->getType() == 'text' ): ?>
                        <tr class="user-display-name-wrap">
                            <th>
                                <label for="<?php echo $key; ?>-value"><?php echo $defaultValue->getLabel(); ?></label>
                            </th>
                            <td>
                                <input id="<?php echo $key; ?>-value" type="text" name="values[<?php echo $key; ?>][value]" value="<?php echo $data[ $key ]->getValue(); ?>">
                                <input id="<?php echo $key; ?>-type" type="hidden" name="values[<?php echo $key; ?>][type]" value="<?php echo $data[ $key ]->getType(); ?>">
                            </td>
                        </tr>
		            <?php endif; ?>

		            <?php if ( $defaultValue->getType() == 'textarea' ): ?>
                        <tr class="user-display-name-wrap">
                            <th>
                                <label for="<?php echo $key; ?>-value"><?php echo $defaultValue->getLabel(); ?></label>
                            </th>
                            <td>
                                <textarea name="values[<?php echo $key; ?>][value]" rows="3" cols="24"><?php echo $data[ $key ]->getValue(); ?></textarea>
                                <input id="<?php echo $key; ?>-type" type="hidden" name="values[<?php echo $key; ?>][type]" value="<?php echo $data[ $key ]->getType(); ?>">
                            </td>
                        </tr>
		            <?php endif; ?>

		            <?php if ( $defaultValue->getType() == 'checkbox' ): ?>
                        <tr class="user-display-name-wrap">
                            <th>
                                <label for="<?php echo $key; ?>-value"><?php echo $defaultValue->getLabel(); ?></label>
                            </th>
                            <td>
                                <input id="<?php echo $key; ?>-value" type="checkbox" name="values[<?php echo $key; ?>][value]"<?php echo ($data[ $key ]->getValue() ? ' checked' : ''); ?>>
                                <input id="<?php echo $key; ?>-type" type="hidden" name="values[<?php echo $key; ?>][type]" value="<?php echo $data[ $key ]->getType(); ?>">
                            </td>
                        </tr>
		            <?php endif; ?>

		            <?php if ( $defaultValue->getType() == 'file' ): ?>
                        <tr class="user-display-name-wrap">
                            <th>
                                <label for="<?php echo $key; ?>-value"><?php echo $defaultValue->getLabel(); ?></label>
                            </th>
                            <td>
                                <input id="<?php echo $key; ?>-value" type="text" name="values[<?php echo $key; ?>][value]" value="<?php echo $data[ $key ]->getValue(); ?>">
                                <input id="<?php echo $key; ?>-type" type="hidden" name="values[<?php echo $key; ?>][type]" value="<?php echo $data[ $key ]->getType(); ?>">
                                <input type="button" data-key="<?php echo $key; ?>" value="<?php _e( 'Change', 'brizy-pro' ); ?>" class="button button-default" onclick="openMediaLibrary(event)"/>
                            </td>
                        </tr>
		            <?php endif; ?>
	            <?php endforeach; ?>
            </table>

            <p class="submit">
                <input type="submit" name="brizy-wl-submit" id="submit" class="button button-primary" value="<?php echo $submit_label; ?>">

                <a name="brizy-wl-reset" href="<?php echo $resetAction; ?>" onclick="return confirm('<?php _e( 'Are you sure you want to reset to the default values?', 'brizy-pro' ); ?>')" class="button button-default">
	                <?php _e( 'Reset', 'brizy-pro' ); ?>
                </a>
            </p>
        </form>

        <p style="font-style: italic">
	        <?php _e( 'These options are visible only in your current session.<br>Logout to make them disappear from the sidebar.', 'brizy-pro' ); ?>
        </p>
    </div>

    <script>
        function openMediaLibrary(event) {
            event.preventDefault();

            var target = jQuery(event.target);
            // Create a new media frame
            var frame = wp.media({
                title: 'Select or Upload Media',
                button: {
                    text: 'Use this media'
                },
                multiple: false  // Set to true to allow multiple files to be selected
            });

            // When an image is selected in the media frame...
            frame.on('select', function () {

                var key = target.data('key');

                // Get media attachment details from the frame state
                var attachment = frame.state().get('selection').first().toJSON(),
                    url = attachment.url;

                if ( ! url.includes( '.svg' ) ) {
                	alert('The file should be .svg');
	                frame.open();
                	return;
                }

                jQuery('#' + key + '-value').val(attachment.url);
            });

            // Finally, open the modal on click
            frame.open();
        };
    </script>
</div>