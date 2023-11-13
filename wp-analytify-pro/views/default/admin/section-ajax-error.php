<?php

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$ga_dashboard_link = is_callable( array('WPANALYTIFY_Utils', 'get_all_stats_link') ) ? WPANALYTIFY_Utils::get_all_stats_link( $report_url, 'ajax-error', false ) : '';
if ( ! $ga_dashboard_link || '' === $ga_dashboard_link ) {
	$ga_attr = 'https://analytics.google.com/analytics/web/#/report/content-event-events/' . $report_url . $report_date_range . '&explorer-segmentExplorer.segmentId=analytics.eventLabel&_r.drilldown=analytics.eventCategory:Ajax%20Error&explorer-table.plotKeys=%5B%5D/';
} else {
	$ga_attr = 'href="javascript: return false;" data-ga-dashboard-pro-link=' . $ga_dashboard_link;
}
?>

<div class="analytify_general_status analytify_status_box_wraper analytify_section_ajax_error_stats" data-endpoint-pro="ajax-error" data-target=".analytify_section_ajax_error_stats">
	<div class="analytify_status_header analytify_header_adj">
		<h3>
			<?php _e( 'Top Ajax Errors', 'wp-analytify-pro' ); ?>
			<a <?php echo $ga_attr; ?> target="_blank" class="analytify_tooltip"><span class="analytify_tooltiptext"><?php _e( 'View All Ajax Errors', 'wp-analytify' ); ?></span><span aria-hidden="true" class="dashicons dashicons-external"></span></a>
		</h3>
		<span class="analytify_top_page_detials analytify_tp_btn">
			<a href="#" class="analytify-export-data analytify_tooltip" data-stats-type="top-ajax">
				<span class="analytify_tooltiptext"><?php _e( 'Export Top Ajax Errors', 'wp-analytify-pro' ); ?></span>
			</a>
			<img src="<?php echo admin_url( 'images/spinner.gif' ); ?>" class='analytify-export-loader' style="display:none">
		</span>
	</div>
	<div class="analytify_status_body">
		<div class="stats-wrapper"></div>
	</div>
	<div class="analytify_stats_loading">
		<table class="analytify_data_tables">
			<thead>
				<tr>
					<th class="analytify_num_row"><p class="skt-loading light-gray"></p></th>
					<th class="analytify_txt_left"><p class="skt-loading light-gray"></p></th>
					<th class="analytify_value_row"><p class="skt-loading light-gray"></p></th>
				</tr>
			</thead>
			<tbody>
				<?php for ( $i = 0; $i < 5; $i++ ) { ?>
				<tr>
					<td class="analytify_txt_center"><p class="skt-loading"></p></td>
					<td><p class="skt-loading"></p></td>
					<td class="analytify_txt_center"><p class="skt-loading"></p></td>
				</tr>
				<?php } ?>
			</tbody>
		</table>
	</div>
</div>
