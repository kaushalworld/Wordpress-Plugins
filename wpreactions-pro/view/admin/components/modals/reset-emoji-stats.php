<div class="modal fade" id="resetEmojiStats" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="reset-emojis-drag-drop">
                    <p><?php _e( 'It looks like you have changed some emojis. If you want to keep these statistics and merge them to another reaction, simply drag and drop to the desired emoji. To discard these stats, click the reset button.', 'wpreactions' ); ?></p>
                    <p class="mb-0">
                        <a target="_blank" href="<?php WPRA\Helpers\Utils::linkToDoc( 'wpreactions', 'merge-analytics' ); ?>">
                            <span><?php _e( 'Learn more', 'wpreactions' ); ?></span>
                            <i class="qa qa-external-link-alt fs-13px"></i>
                        </a>
                    </p>
                    <p class="reset-emojis-box"><?php _e( 'Removed emojis', 'wpreactions' ); ?></p>
                    <div class="reset-emojis-source reset-emojis-holder"></div>
                    <p class="reset-emojis-box"><?php _e( 'Current emojis', 'wpreactions' ); ?></p>
                    <div class="reset-emojis-target reset-emojis-holder"></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-dismiss="modal"><?php _e( 'Cancel', 'wpreactions' ); ?></button>
                <button type="button" class="take-action-before-save reset-emoji-stats btn btn-secondary" data-action="reset"><?php _e( 'Reset', 'wpreactions' ); ?></button>
                <button type="button" class="take-action-before-save keep-emoji-stats btn btn-primary" data-action="keep" disabled><?php _e( 'Merge', 'wpreactions' ); ?></button>
            </div>
        </div>
    </div>
</div>