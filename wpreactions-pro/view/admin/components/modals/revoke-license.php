<div class="modal fade" id="revokeModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="modal-icon-content">
                    <i class="qas qa-exclamation-triangle"></i>
                    <div>
                        <p><?php _e( 'This action will deactivate your license on this website. Once it is done, you can proceed to use your license key on a different site.', 'wpreactions' ); ?></p>
                        <p class="mb-0">
                            <a target="_blank" href="<?php WPRA\Helpers\Utils::linkToDoc('wpreactions', 'revoke-license'); ?>">
                                <span><?php _e( 'Learn more', 'wpreactions' ); ?></span>
                                <i class="qa qa-external-link-alt fs-13px"></i>
                            </a>
                        </p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-dismiss="modal"><?php _e( 'Cancel', 'wpreactions' ); ?></button>
                <button id="revoke" type="button" class="license-key-action btn btn-primary"><?php _e( 'I am sure', 'wpreactions' ); ?></button>
            </div>
        </div>
    </div>
</div>