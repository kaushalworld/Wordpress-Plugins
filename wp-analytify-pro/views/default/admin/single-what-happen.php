<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) { exit; }

// View of Page Entrance/Exit Statistics
function analytify_single_what_happen( $wp_analytify, $stats ) {

  ob_start();
  ?>

  <table class="analytify_data_tables analytify_page_stats_table">
    <thead>
      <tr>
        <th class="analytify_txt_center analytify_compair_value_row"><?php esc_html_e( 'Entrance', 'wp-analytify' ); ?></th>
        <th class="analytify_txt_center analytify_compair_value_row"><?php esc_html_e( 'Exits', 'wp-analytify' ); ?></th>
        <th class="analytify_txt_center analytify_compair_row"><?php esc_html_e( 'Entrance% Exits%', 'wp-analytify' ); ?></th>
      </tr>
    </thead>
    <tbody>

	<?php
	$url          = $stats['rows'][0][1];
	$top_entrance = $stats['rows'][0][2];
	$rows = $stats['rows'][0];

	if ( $rows > 0 ) {
        $i = 0;

	$dashboard_profile_ID = $GLOBALS['WP_ANALYTIFY']->settings->get_option( 'profile_for_dashboard', 'wp-analytify-profile' );
	$site_url             = WP_ANALYTIFY_FUNCTIONS::search_profile_info( $dashboard_profile_ID, 'websiteUrl' );

        foreach ( $rows as $row ) {
          $i++;
          ?>
          <tr>
            <td class="analytify_txt_center analytify_w_300 analytify_l_f"><?php echo WPANALYTIFY_Utils::pretty_numbers( $row['entrances'] ); ?></td>
            <td class="analytify_txt_center analytify_w_300 analytify_l_f"><?php echo WPANALYTIFY_Utils::pretty_numbers( $row['exits'] ); ?></td>
            <td class="analytify_txt_center analytify_w_300 analytify_l_f">

              <div class="analytify_enter_exit_bars analytify_enter">
                <?php echo round( $row['entranceRate'], 2 ) . '<span class="analytify_persantage_sign">%</span>'; ?>
                <span class="analytify_bar_graph"><span style="width: <?php echo round( $row['entranceRate'], 2 ); ?>%"></span></span>
              </div>
              <div class="analytify_enter_exit_bars">
                <?php echo round( $row['exitRate'], 2 ) . '<span class="analytify_persantage_sign">%</span>'; ?>
                <span class="analytify_bar_graph"><span style="width: <?php echo round( $row['exitRate'], 2 ); ?>%"></span></span>
              </div>


            </td>
          </tr>
        <?php } ?>

      <?php } else { ?>
        <tr>
          <td class='analytify_td_error_msg' colspan="4" >
            <?php echo $wp_analytify->no_records(); ?>
          </td>
        </tr>
      <?php	} ?>

    </tbody>
  </table>

  <?php

  $body = ob_get_clean();

  return json_encode(
    array(
      'message' => sprintf( esc_html__( 'Did you know that %1$s people landed directly to your site at %2$s?', 'wp-analytify' ), WPANALYTIFY_Utils::pretty_numbers( $top_entrance ), $url ),
      'body'    => $body,
    )
  );

}
