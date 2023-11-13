<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

ob_start();

/*
 * View of Visitors and Views Comparison Statistics
 */

function fetch_visitors_views_comparison( $wp_analytify, $this_month_stats, $previous_month_stats, $this_year_stats, $previous_year_stats, $is_three_month, $this_month_start_date, $this_month_end_date, $previous_month_start_date, $previous_month_end_date, $this_year_start_date, $this_year_end_data, $previous_year_start_date, $previous_year_end_date ) {
	$code                      = '';
	$this_month_users_data     = array();
	$previous_month_users_data = array();
	$date_data                 = array();

	$this_year_users_data     = array();
	$previous_year_users_data = array();
	$month_data               = array();

	$this_month_views_data     = array();
	$previous_month_views_data = array();

	$this_year_views_data     = array();
	$previous_year_views_data = array();

	$this_month_total_users     = isset( $this_month_stats['aggregations']['totalUsers'] ) ? $this_month_stats['aggregations']['totalUsers'] : 0;
	$this_month_total_views     = isset( $this_month_stats['aggregations']['screenPageViews'] ) ? $this_month_stats['aggregations']['screenPageViews'] : 0;
	$previous_month_total_users = isset( $previous_month_stats['aggregations']['totalUsers'] ) ? $previous_month_stats['aggregations']['totalUsers'] : 0;
	$previous_month_total_views = isset( $previous_month_stats['aggregations']['screenPageViews'] ) ? $previous_month_stats['aggregations']['screenPageViews'] : 0;

	$this_year_total_users     = isset( $this_year_stats['aggregations']['totalUsers'] ) ? $this_year_stats['aggregations']['totalUsers'] : 0;
	$this_year_total_views     = isset( $this_year_stats['aggregations']['screenPageViews'] ) ? $this_year_stats['aggregations']['screenPageViews'] : 0;
	$previous_year_total_users = isset( $previous_year_stats['aggregations']['totalUsers'] ) ? $previous_year_stats['aggregations']['totalUsers'] : 0;
	$previous_year_total_views = isset( $previous_year_stats['aggregations']['screenPageViews'] ) ? $previous_year_stats['aggregations']['screenPageViews'] : 0;

	$graph_colors = apply_filters(
		'analytify_compare_graph_colors',
		array(
			'visitors_this_year'  => '#03a1f8',
			'visitors_last_year'  => '#00c852',
			'visitors_this_month' => '#03a1f8',
			'visitors_last_month' => '#00c852',
			'views_this_year'     => '#03a1f8',
			'views_last_year'     => '#00c852',
			'views_this_month'    => '#03a1f8',
			'views_last_month'    => '#00c852',
		)
	);

	if ( ! empty( $this_month_stats['rows'] ) ) {
		foreach ( $this_month_stats['rows'] as  $value ) {
			$this_month_users_data[] = $value['totalUsers'];
			$this_month_views_data[] = $value['screenPageViews'];
			$date_data[]             = date( 'j-M', strtotime( $value['date'] ) );
		}
	}

	if ( ! empty( $previous_month_stats['rows'] ) ) {
		foreach ( $previous_month_stats['rows'] as $value ) {
			$previous_month_users_data[] = $value['totalUsers'];
			$previous_month_views_data[] = $value['screenPageViews'];
		}
	}

	if ( ! empty( $this_year_stats['rows'] ) ) {
		foreach ( $this_year_stats['rows'] as  $value ) {
			$this_year_users_data[] = $value['totalUsers'];
			$this_year_views_data[] = $value['screenPageViews'];

			if ( $is_three_month ) {
				$month_data[] = date( 'j-M-Y', strtotime( $value['date'] ) );
			} else {
				$month_data[] = date( 'M-Y', strtotime( $value['date'] . '01' ) );
			}
		}
	}

	if ( ! empty( $previous_year_stats['rows'] ) ) {
		foreach ( $previous_year_stats['rows'] as  $value ) {
			$previous_year_users_data[] = $value['totalUsers'];
			$previous_year_views_data[] = $value['screenPageViews'];
		}
	}
	$view_data = false;
	if ( $view_data ) {
		$visitors_this_year_legend = date( 'F d, Y', strtotime( $this_year_start_date ) ) . ' to ' . date( 'F d, Y', strtotime( $this_year_end_data ) );
		$visitors_last_year_legend = date( 'F d, Y', strtotime( $previous_year_start_date ) ) . ' to ' . date( 'F d, Y', strtotime( $previous_year_end_date ) );

		$visitors_this_month_legend = date( 'F d, Y', strtotime( $this_month_start_date ) ) . ' to ' . date( 'F d, Y', strtotime( $this_month_end_date ) );
		$visitors_last_month_legend = date( 'F d, Y', strtotime( $previous_month_start_date ) ) . ' to ' . date( 'F d, Y', strtotime( $previous_month_end_date ) );

		$views_this_year_legend = date( 'F d, Y', strtotime( $this_year_start_date ) ) . ' to ' . date( 'F d, Y', strtotime( $this_year_end_data ) );
		$views_last_year_legend = date( 'F d, Y', strtotime( $previous_year_start_date ) ) . ' to ' . date( 'F d, Y', strtotime( $previous_year_end_date ) );

		$views_this_month_legend = date( 'F d, Y', strtotime( $this_month_start_date ) ) . ' to ' . date( 'F d, Y', strtotime( $this_month_end_date ) );
		$views_last_month_legend = date( 'F d, Y', strtotime( $previous_month_start_date ) ) . ' to ' . date( 'F d, Y', strtotime( $previous_month_end_date ) );
	} else {
		$visitors_this_year_legend  = 'Visitors this year';
		$visitors_last_year_legend  = 'Visitors last year';
		$visitors_this_month_legend = 'Visitors this month';
		$visitors_last_month_legend = 'Visitors last month';

		$views_this_year_legend  = 'Views this year';
		$views_last_year_legend  = 'Views last year';
		$views_this_month_legend = 'Views this month';
		$views_last_month_legend = 'Views last month';
	}
	?>

  <div class="analytify_general_status analytify_status_box_wraper">
	  <ul class="analytify_status_tab_header">
		  <li class="analytify_active_stats analytify_visitors" data-tab="analytify_visitors"><span><?php esc_html_e( 'Visitors', 'wp-analytify-pro' ); ?></span></li>
		  <li data-tab="analytify_views" class="analytify_views"><span><?php esc_html_e( 'Views', 'wp-analytify-pro' ); ?></span></li>
	  </ul>
	  <div class="analytify_status_body">
		  <div id="analytify_visitors" class="analytify_panels_data analytify_active_panel">
			  <div class="analytify_stats_setting_bar">
				  <div class="analytify_pull_right">
					  <div class="analytify_select_month analytify_stats_setting">
						  <button data-graphType="analytify_months_graph_by_visitors"><?php esc_html_e( 'Months', 'wp-analytify-pro' ); ?></button>
					  </div>
					  <div class="analytify_select_year analytify_stats_setting analytify_disabled">
						  <button data-graphType="analytify_years_graph_by_visitors"><?php esc_html_e( 'Years', 'wp-analytify-pro' ); ?></button>
					  </div>
				  </div>
				  <div class="analytify_pull_left total_month_users">
                      <span class="analytify_previous_value"><?php echo WPANALYTIFY_Utils::pretty_numbers( $previous_month_total_users ); ?></span>
					  <span class="analytify_compare_value">vs</span>
					  <span class="analytify_current_value"><?php echo WPANALYTIFY_Utils::pretty_numbers( $this_month_total_users ); ?></span>
				  </div>
				  <div class="analytify_pull_left total_year_users" style="display: none;">
					  <span class="analytify_previous_value"><?php echo WPANALYTIFY_Utils::pretty_numbers( $previous_year_total_users ); ?></span>
					  <span class="analytify_compare_value">vs</span>
					  <span class="analytify_current_value"><?php echo WPANALYTIFY_Utils::pretty_numbers( $this_year_total_users ); ?></span>
				  </div>
			  </div>
			  <div class="analytify_txt_center analytify_graph_wraper analytify_years_graph_by_visitors">
				  <div id="analytify_years_graph_by_visitors" style="height:400px"></div>
			  </div>
			  <div class="analytify_txt_center analytify_graph_wraper analytify_months_graph_by_visitors analytify_active_graph">
				  <div id="analytify_months_graph_by_visitors" style="height:400px"></div>
			  </div>
		  </div>
		  <div id="analytify_views" class="analytify_panels_data">
			  <div class="analytify_stats_setting_bar">
				  <div class="analytify_pull_right">
					  <div class="analytify_select_month analytify_stats_setting">
						  <button data-graphType="analytify_months_graph_by_view"><?php esc_html_e( 'Months', 'wp-analytify-pro' ); ?></button>
					  </div>
					  <div class="analytify_select_year analytify_stats_setting analytify_disabled">
						  <button data-graphType="analytify_years_graph_by_view"><?php esc_html_e( 'Years', 'wp-analytify-pro' ); ?></button>
					  </div>
				  </div>
				  <div class="analytify_pull_left total_month_views">
					  <span class="analytify_previous_value"><?php echo WPANALYTIFY_Utils::pretty_numbers( $previous_month_total_views ); ?></span>
                      <span class="analytify_compare_value">vs</span>
					  <span class="analytify_current_value"><?php echo WPANALYTIFY_Utils::pretty_numbers( $this_month_total_views ); ?></span>
				  </div>
				  <div class="analytify_pull_left total_year_views" style="display: none;">
					  <span class="analytify_previous_value"><?php echo WPANALYTIFY_Utils::pretty_numbers( $previous_year_total_views ); ?></span>
                      <span class="analytify_compare_value">vs</span>
					  <span class="analytify_current_value"><?php echo WPANALYTIFY_Utils::pretty_numbers( $this_year_total_views ); ?></span>
				  </div>
			  </div>
			  <div class="analytify_txt_center analytify_graph_wraper analytify_years_graph_by_view">
				  <div id="analytify_years_graph_by_view" style="height:400px"></div>
			  </div>
			  <div class="analytify_txt_center analytify_graph_wraper analytify_months_graph_by_view analytify_active_graph">
				  <div id="analytify_months_graph_by_view" style="height:400px"></div>
			  </div>
		  </div>
	  </div>
	  <div class="analytify_status_footer">
		  <span class="analytify_info_stats"><?php esc_html_e( 'Detailed Visitors and Views breakdown in months and years', 'wp-analytify-pro' ); ?></span>
	  </div>
  </div>
	<?php

	wp_send_json(
		array(
			'body'       => ob_get_clean(),
			'stats_data' => array(
				'is_three_month'             => $is_three_month,
				'graph_colors'               => $graph_colors,
				'visitors_this_year_legend'  => $visitors_this_year_legend,
				'visitors_last_year_legend'  => $visitors_last_year_legend,
				'month_data'                 => $month_data,
				'this_year_users_data'       => $this_year_users_data,
				'previous_year_users_data'   => $previous_year_users_data,
				'date_data'                  => $date_data,
				'visitors_last_month_legend' => $visitors_last_month_legend,
				'previous_month_users_data'  => $previous_month_users_data,
				'visitors_this_month_legend' => $visitors_this_month_legend,
				'views_last_year_legend'     => $views_last_year_legend,
				'previous_year_views_data'   => $previous_year_views_data,
				'this_month_views_data'      => $this_month_views_data,
				'views_this_month_legend'    => $views_this_month_legend,
				'previous_month_views_data'  => $previous_month_views_data,
				'views_last_month_legend'    => $views_last_month_legend,
				'this_month_users_data'      => $this_month_users_data,
				'this_year_views_data'       => $this_year_views_data,
				'views_this_year_legend'     => $views_this_year_legend,
			),
		)
	);
}
