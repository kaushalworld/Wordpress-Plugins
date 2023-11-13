<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div class="wpanalytify analytify-dashboard-nav">
	<div class="wpb_plugin_wraper">
		<div class="wpb_plugin_header_wraper">
			<div class="graph"></div>
			<div class="wpb_plugin_header">
				<div class="wpb_plugin_header_title"></div>
				<div class="wpb_plugin_header_info">
					<a href="https://analytify.io/changelog/" target="_blank" class="btn"><?php echo esc_html__( 'View Changelog', 'wp-analytify-pro' ); ?></a>
				</div>
				<div class="wpb_plugin_header_logo">
					<img src="<?php echo ANALYTIFY_PLUGIN_URL . 'assets/img/logo.svg'?>" alt="Analytify">
				</div>
			</div>
		</div>

		<div class="analytify-dashboard-body-container">
			<div class="wpb_plugin_body_wraper">
				<div class="wpb_plugin_body">
					<div class="wpa-tab-wrapper">
						<?php echo $wp_analytify->dashboard_navigation(); ?>
					</div>

					<div class="wpb_plugin_tabs_content analytify-dashboard-content">
						<div class="analytify_wraper">
							<div class="analytify_main_title_section">
								<div class="analytify_dashboard_title">
									<h1 class="analytify_pull_left analytify_main_title"><?php _e( 'Events Tracking Dashboard', 'wp-analytify-pro' ); ?></h1>
									<?php
									if ( ! WP_ANALYTIFY_FUNCTIONS::wpa_check_profile_selection('Analytify') && $wp_analytify->pa_check_roles( $is_access_level ) && $access_token && method_exists( 'WPANALYTIFY_Utils', 'dashboard_subtitle_section' ) ) {
										WPANALYTIFY_Utils::dashboard_subtitle_section();
									}
									?>
								</div>
								<div class="analytify_main_setting_bar">
									<div class="analytify_pull_right analytify_setting">
										<div class="analytify_select_date">
											<?php
											if ( ! WP_ANALYTIFY_FUNCTIONS::wpa_check_profile_selection('Analytify') && $wp_analytify->pa_check_roles( $is_access_level ) && $access_token && method_exists( 'WPANALYTIFY_Utils', 'date_form' ) ) {
												WPANALYTIFY_Utils::date_form( $start_date, $end_date );
											}
											?>
										</div>
									</div>
								</div>
							</div>

							<?php
							$categories = array(
								'external'      => array(
									'title'    => __( 'External Links', 'wp-analytify-pro' ),
									'csv-type' => __( 'external-links', 'wp-analytify-pro' ),
								),
								'outbound-link' => array(
									'title'    => __( 'Affiliate Links', 'wp-analytify-pro' ),
									'csv-type' => __( 'affiliate-links', 'wp-analytify-pro' ),
								),
								'download'      => array(
									'title'    => __( 'Download Links', 'wp-analytify-pro' ),
									'csv-type' => __( 'download-links', 'wp-analytify-pro' ),
								),
								'tel'           => array(
									'title'    => __( 'Tel Links', 'wp-analytify-pro' ),
									'csv-type' => __( 'tel-links', 'wp-analytify-pro' ),
								),
								'mail'          => array(
									'title'    => __( 'Mail Links', 'wp-analytify-pro' ),
									'csv-type' => __( 'mail-links', 'wp-analytify-pro' ),
								),
							);

							$first = true;
							foreach ( $categories as $key => $category ) {
								?>
								<div class="analytify_<?php echo $category['csv-type']; ?> analytify_status_box_wraper"<?php if ( $first ) { ?> data-endpoint-pro="events-tracking"<?php } ?>>
									<div class="analytify_status_header analytify_header_adj">
										<h3>
											<?php echo $category['title']; ?>
											<a href="#" class="analytify-export-data analytify_tooltip" data-stats-type="<?php echo $category['csv-type']; ?>">
												<span class="analytify_tooltiptext"><?php echo sprintf( __( 'Export %s', 'wp-analytify-pro' ), $category['title'] ); ?></span>
											</a>
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
								<?php
								$first = false;
							}
							?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
