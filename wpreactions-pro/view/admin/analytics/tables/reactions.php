<?php

use WPRA\Emojis;
use WPRA\Helpers\Utils;

$table = $options = [];
if ( isset( $data ) ) {
	extract( $data );
}

if ( empty( $table['rows'] ) ):
	echo '<p class="text-center text-muted m-0"><i class="qa qa-database mr-2"></i>No reactions data available</p>';
else: ?>
    <table class="table wpra-analytics-table" data-total_page_count="<?php echo $table['page_count']; ?>" data-table="reactions">
        <thead>
        <tr>
            <th scope="col">Type</th>
            <th scope="col">Title</th>
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
                $link = get_the_permalink( $row['bind_id'] );
                $title = get_the_title( $row['bind_id'] );
                $type = get_post_type( $row['bind_id'] ); ?>
                <tr>
                    <td class="text-capitalize"><?php echo $type; ?></td>
                    <td><a target="_blank" href="<?php echo $link; ?>"><?php echo $title; ?></a></td>
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