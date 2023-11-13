<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div class="analytify_general_status analytify_status_box_wraper" data-endpoint-pro="demographics">
	<div class="analytify_status_header">
		<h3>
			<?php esc_html_e( 'Demographic Stats', 'wp-analytify-pro' ); ?>
			<a href="#" class="analytify-export-data analytify_tooltip" data-stats-type="demographics"><span class="analytify_tooltiptext"><?php esc_html_e( 'Export Stats', 'wp-analytify-pro' ); ?></span></a>
		</h3>
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
				<th class="analytify_txt_left"><p class="skt-loading light-gray"></p></th>
				<th class="analytify_value_row"><p class="skt-loading light-gray"></p></th>
				</tr>
			</thead>
			<tbody>
				<?php for ( $i = 0; $i < 5; $i++ ) { ?>
				<tr>
					<td class="analytify_txt_center"><p class="skt-loading"></p></td>
					<td><p class="skt-loading"></p></td>
					<td><p class="skt-loading"></p></td>
					<td class="analytify_txt_center"><p class="skt-loading"></p></td>
				</tr>
				<?php } ?>
			</tbody>
		</table>
	</div>
</div>
