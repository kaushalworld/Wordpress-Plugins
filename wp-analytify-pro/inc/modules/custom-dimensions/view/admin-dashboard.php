<?php
/**
 * Analytify Dashboard file.
 *
 * @package WP_Analytify
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

$num_of_dimensions_set = count( (array) $wp_analytify->settings->get_option( 'analytiy_custom_dimensions', 'wp-analytify-custom-dimensions' ) );

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
								<h1 class="analytify_pull_left analytify_main_title"><?php esc_html_e( 'Dimensions Dashboard', 'wp-analytify-pro' ); ?></h1>

								<?php
								$_analytify_profile = get_option( 'wp-analytify-profile' );
								if ( $wp_analytify->pa_check_roles( $is_access_level ) ) {
									if ( $access_token && method_exists( 'WPANALYTIFY_Utils', 'dashboard_subtitle_section' ) ) {
										WPANALYTIFY_Utils::dashboard_subtitle_section();
									}
								}
								?>

							</div>

							<?php if ( method_exists( 'WPANALYTIFY_Utils', 'date_form' ) ) { ?>
								<div class="analytify_main_setting_bar">
									<div class="analytify_pull_right analytify_setting">
										<div class="analytify_select_date">
											<?php WPANALYTIFY_Utils::date_form( $start_date, $end_date ); ?>
										</div>
									</div>
								</div>
							<?php } ?>

						</div>

						<div data-endpoint-pro="custom-dimensions">
							<div class="analytify_status_body"><div class="stats-wrapper"></div></div>

							<div class="analytify_stats_loading">

								<?php

								if ( $num_of_dimensions_set < 1 ) {
									$num_of_dimensions_set = 2;
								}

								for ( $count = 1; $count <= $num_of_dimensions_set; $count++ ) {

									if ( $count % 2 != 0 ) {
										?><div class="analytify_column"><?php
									}
									?>

									<div class="analytify_half <?php echo ( $count % 2 == 0 ) ? 'analytify_right_flow' : 'analytify_left_flow'; ?>">
										<div class="analytify_general_status analytify_status_box_wraper">

											<div class="analytify_status_header analytify_header_adj">
												<h3><p class="skt-loading light-gray"></p></h3>
											</div>
											<div class="analytify_dimension_pageviews_stats_boxes_wraper">
												<table class="analytify_data_tables">
													<tbody>
														<?php for ( $i = 0; $i < 5; $i++ ) { ?>
														<tr>
															<td><p class="skt-loading"></p></td>
															<td class="analytify_txt_center analytify_value_row"><p class="skt-loading"></p></td>
														</tr>
														<?php } ?>
													</tbody>
												</table>
											</div>

										</div>
									</div>

									<?php
									if ( $count % 2 == 0 ) {
										?></div><?php
									}
								}
								if ( $num_of_dimensions_set % 2 == 0 ) {
									?></div><?php
								}
								?>
							</div>

						</div>

					</div>
				</div>
			</div>
		</div>
	</div>
</div>
