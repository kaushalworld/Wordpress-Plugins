<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div class="analytify_real_time_stats analytify_status_box_wraper">
	<div class="analytify_visitors_online analytify_real_time_stats_boxes">
		<div class="analytify_number" id="pa-online">0</div>
		<div class="analytify_label"><?php esc_html_e( 'Visitors online', 'wp-analytify-pro' ); ?></div>
	</div>
	<?php if ( method_exists( 'WPANALYTIFY_Utils', 'get_ga_mode' ) && 'ga4' === WPANALYTIFY_Utils::get_ga_mode() ) { ?>
	<div class="analytify_referral analytify_real_time_stats_boxes">
		<div class="analytify_number" id="pa-desktop">0</div>
		<div class="analytify_label"><?php esc_html_e( 'Desktop Visitors', 'wp-analytify-pro' ); ?></div>
	</div>
	<div class="analytify_referral analytify_real_time_stats_boxes">
		<div class="analytify_number" id="pa-tablet">0</div>
		<div class="analytify_label"><?php esc_html_e( 'Tablet Visitors', 'wp-analytify-pro' ); ?></div>
	</div>
	<div class="analytify_referral analytify_real_time_stats_boxes">
		<div class="analytify_number" id="pa-mobile">0</div>
		<div class="analytify_label"><?php esc_html_e( 'Mobile Visitors', 'wp-analytify-pro' ); ?></div>
	</div>
	<?php } else { ?>
	<div class="analytify_referral analytify_real_time_stats_boxes">
		<div class="analytify_number" id="pa-referral">0</div>
		<div class="analytify_label"><?php esc_html_e( 'Referral', 'wp-analytify-pro' ); ?></div>
	</div>
	<div class="analytify_organic analytify_real_time_stats_boxes">
		<div class="analytify_number" id="pa-organic">0</div>
		<div class="analytify_label"><?php esc_html_e( 'Organic', 'wp-analytify-pro' ); ?></div>
	</div>
	<div class="analytify_social analytify_real_time_stats_boxes">
		<div class="analytify_number" id="pa-social">0</div>
		<div class="analytify_label"><?php esc_html_e( 'Social', 'wp-analytify-pro' ); ?></div>
	</div>
	<div class="analytify_direct analytify_real_time_stats_boxes">
		<div class="analytify_number" id="pa-direct">0</div>
		<div class="analytify_label"><?php esc_html_e( 'Direct', 'wp-analytify-pro' ); ?></div>
	</div>
	<div class="analytify_new analytify_real_time_stats_boxes">
		<div class="analytify_number" id="pa-new">0</div>
		<div class="analytify_label"><?php esc_html_e( 'New', 'wp-analytify-pro' ); ?></div>
	</div>
	<div class="analytify_returning analytify_real_time_stats_boxes">
		<div class="analytify_number" id="pa-returning">0</div>
		<div class="analytify_label"><?php esc_html_e( 'Returning', 'wp-analytify-pro' ); ?></div>
	</div>
	<?php } ?>
</div>

<div class="analytify_general_status analytify_status_box_wraper realtime-chart-wrapper">
	<div class="analytify_status_header">
		<h3><?php esc_html_e( 'RealTime Stats', 'wp-analytify-pro' ); ?></h3>
		<div class="analytify_top_page_detials analytify_tp_btn">
			<a id='refresh-realtime-stats'  class="analytify_tooltip" href="#"> 
			<span class="analytify_tooltiptext"><?php esc_html_e( 'Refresh Stats', 'wp-analytify-pro' ); ?></span>
		</a>
		</div>
	</div>
	<div class="analytify_status_body stats_loading">
		<div id="analytify_real_time_visitors" style="height:400px"></div>
	</div>
</div>

<div class="analytify_general_status analytify_status_box_wraper realtime-table-wrapper">
	<div class="analytify_status_header">
		<h3><?php esc_html_e( 'Top active posts and pages', 'wp-analytify-pro' ); ?></h3>
	</div>
	<div class="analytify_status_body">
		<div class="analytify_top_pages_boxes_wraper"></div>
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
	<div class="analytify_status_footer">
		<span class="analytify_info_stats"><?php esc_html_e( 'Top active pages and posts users are currently at.', 'wp-analytify-pro' ); ?></span>
	</div>
</div>
