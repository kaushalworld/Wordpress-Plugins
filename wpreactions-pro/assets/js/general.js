setTimeout(function () {
    jQuery('.overlay-message').html('We are almost done...');
}, 3000);

setTimeout(function () {
    jQuery('.overlay-message').html('Finalizing...');
}, 6000);

jQuery(document).ready(function ($) {
    $(document).on('click', '.wpra-notice.is-dismissible', function () {
        const id = $(this).data('id');

        $.post(wpreactions_general.ajaxurl, {
            action: 'wpra_handle_admin_requests',
            sub_action: 'dismiss_notice',
            id: id,
        });
    });
});
