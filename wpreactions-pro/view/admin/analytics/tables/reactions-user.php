<?php

use WPRA\Helpers\Utils;
use WPRA\Emojis;

$table = $options = [];
if ( isset( $data ) ) {
	extract( $data );
}

if ( empty( $table['rows'] ) ):
	echo '<p class="text-center text-muted m-0"><i class="qa qa-database mr-2"></i>No reactions data available</p>';
else: ?>
    <table class="table wpra-analytics-table" data-total_page_count="<?php echo $table['page_count']; ?>" data-table="reactions-user">
        <thead>
        <tr>
            <th scope="col">ID</th>
            <th scope="col">User</th>
			<?php foreach ( $options['emojis'] as $emoji ): ?>
                <th scope="col" class="text-center">
                    <img class="table-icon" src="<?php echo Emojis::getUrl( $emoji, 'svg' ); ?> >" alt="">
                </th>
			<?php endforeach; ?>
            <th class="text-right" scope="col">Total</th>
        </tr>
        </thead>
        <tbody>
		<?php foreach ( $table['rows'] as $row ):
			if ( $row['user_id'] == 0 ) {
				$user_edit_link = "<span>Anonymous</span>";
			} else {
				$user           = get_user_by( 'id', $row['user_id'] );
				$display_name   = $user instanceof \WP_User ? $user->first_name  . ' ' . $user->last_name : 'N/A';
				$user_edit_link = "<span>$display_name</span>";
			} ?>
            <tr>
                <td class="text-capitalize"><?php echo $row['user_id']; ?></td>
                <td><?php echo $user_edit_link; ?></td>
				<?php $total = 0;
				foreach ( $options['emojis'] as $emoji_id ) {
					$total += $row[ $emoji_id ];
					echo '<td class="text-center">' . $row[ $emoji_id ] . '</td>';
				} ?>
                <td class="text-right"><?php echo $total; ?></td>
            </tr>
		<?php endforeach; ?>
        </tbody>
    </table>
<?php Utils::renderTemplate('view/admin/analytics/parts/table-nav', [ 'page_count' => $table['page_count']]);
endif;