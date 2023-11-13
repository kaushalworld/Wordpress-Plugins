<?php
if ( ! WPRA\App::instance()->license()->is_allowed() ): ?>
    <div class="row wpra-banner">
        <div class="col-md-12">
            <div class="option-wrap p-3 text-center">
                <h2 class="font-weight-bold"><?php _e( 'Start Engaging your Users Today!', 'wpreactions' ); ?></h2>
                <p><?php _e( 'The #1 Wordpress Animated Emoji Reaction Plugin with Social Sharing', 'wpreactions' ); ?></p>
                <h3><?php _e( '14 Days Money Back Guarantee!', 'wpreactions' ); ?></h3>
                <a href="https://wpreactions.com/pricing" target="_blank" class="btn btn-lg btn-primary"><?php _e( '$39 Buy Now', 'wpreactions' ); ?></a>
            </div>
        </div>
    </div>
<?php endif; ?>