<div class="modal fade" id="wpraFeedbackForm" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <form>
                    <div class="feedback-ratings">
                        <div class="rating-item" data-label="like" title="Like">
                            <i class="qas qa-thumbs-up"></i>
                        </div>
                        <div class="rating-item" data-label="dislike" title="Dislike">
                            <i class="qas qa-thumbs-down"></i>
                        </div>
                    </div>
                    <div class="form-group">
                        <textarea class="form-control" id="feedback-message" style="height: 100px;"
                                  placeholder="<?php _e( 'Tell us what\'s going on', '' ); ?>"></textarea>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" id="feedback-email" placeholder="<?php _e( 'Email (optional)', 'wpreactions' ); ?>">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-dismiss="modal"><?php _e( 'Cancel', 'wpreactions' ); ?></button>
                <button type="button" class="btn btn-primary wpra-submit-feedback"><?php _e( 'Leave feedback', 'wpreactions' ); ?></button>
            </div>
        </div>
    </div>
</div>