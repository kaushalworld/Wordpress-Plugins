<?php

use WPRA\Helpers\Utils;

?>

<div class="row">
    <div class="col-md-12">
        <div class="option-wrap pb-0">
            <div class="analytics-block-header mb-0">
                <h4><?php _e( 'Social Share Clicks Accumulated', 'wpreactions' ); ?></h4>
            </div>
        </div>
        <div class="wpra-analytics-social"></div>
    </div>
</div>

<div class="row half-divide">
    <div class="option-wrap">
        <div class="analytics-block-header">
            <h4><?php _e( 'Social Share Clicks Historical' ); ?></h4>
	        <?php Utils::renderTemplate( 'view/admin/analytics/parts/interval-chooser', [ 'chart_type' => 'social_share_line' ] ); ?>
        </div>
        <div id="wpra-social-line-chart" class="position-relative" data-wpra-chart data-chart_type="social_share_line"></div>
    </div>
    <div class="option-wrap">
        <div class="analytics-block-header">
            <h4><?php _e( 'Social Share Clicks Cumulative' ); ?></h4>
	        <?php Utils::renderTemplate( 'view/admin/analytics/parts/interval-chooser', [ 'chart_type' => 'social_column' ] ); ?>
        </div>
        <div id="wpra-social-column-chart" class="position-relative" data-wpra-chart data-chart_type="social_column"></div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="option-wrap">
            <div class="analytics-block-header">
                <h4><?php _e( 'Social Share Clicks by user' ); ?></h4>
            </div>
            <div class="wpra-analytics-table-wrap" data-wpra-table data-table="social-user"></div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="option-wrap">
            <div class="analytics-block-header">
                <h4><?php _e( 'Social Share Clicks by page and post' ); ?></h4>
            </div>
            <div class="wpra-analytics-table-wrap" data-wpra-table data-table="social"></div>
        </div>
    </div>
</div>