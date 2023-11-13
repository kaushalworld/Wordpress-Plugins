<?php
use WPRA\Helpers\Utils;
?>
<div class="option-wrap">
    <div class="analytics-block-header">
        <h4><?php _e( 'Reactions Accumulated', 'wpreactions' ); ?></h4>
    </div>
    <div class="emotional-data"></div>
</div>
<div class="row half-divide">
    <div class="option-wrap">
        <div class="analytics-block-header">
            <h4><?php _e( 'Reaction Conversions' ); ?></h4>
            <?php Utils::renderTemplate( 'view/admin/analytics/parts/interval-chooser', [ 'chart_type' => 'reactions_line' ] ); ?>
        </div>
        <div id="wpra-reactions-line-chart" data-wpra-chart data-chart_type="reactions_line"></div>
    </div>
    <div class="option-wrap">
        <div class="analytics-block-header">
            <h4><?php _e( 'Reaction Counts Cumulative' ); ?></h4>
			<?php Utils::renderTemplate( 'view/admin/analytics/parts/interval-chooser', [ 'chart_type' => 'reactions_column' ] ); ?>
        </div>
        <div id="wpra-reactions-column-chart" data-wpra-chart data-chart_type="reactions_column"></div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="option-wrap">
            <div class="analytics-block-header">
                <h4><?php _e( 'Reaction Counts by user', 'wpreactions' ); ?></h4>
            </div>
            <div class="wpra-analytics-table-wrap" data-wpra-table data-table="reactions-user"></div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="option-wrap">
            <div class="analytics-block-header">
                <h4><?php _e( 'Reaction Counts by page and post', 'wpreactions' ); ?></h4>
            </div>
            <div class="wpra-analytics-table-wrap" data-wpra-table data-table="reactions"></div>
        </div>
    </div>
</div>