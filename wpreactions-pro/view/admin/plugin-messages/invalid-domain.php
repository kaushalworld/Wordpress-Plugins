<br>
<span style="color:#d63638;font-size:14px;margin: 15px 0 0 0;display: inline-block;">
    <span class="dashicons dashicons-warning" style="margin-right: 3px;"></span>
    <span><?php echo sprintf(
            __( "<strong>%s</strong> domain is not activated with current license. Please contact %s if this was done in error.", 'wpreactions' ),
            WPRA\App::instance()->license()->get_site_domain(),
            '<a style="text-decoration: none;" target="_blank" href="https://support.wpreactions.com/">' .__('customer support', 'wpreactions'). '</a>'
        ); ?>
    </span>
</span>
