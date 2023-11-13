<?php
use WPRA\Helpers\Utils;

$table = $options = [];
if (isset($data)) {
	extract($data);
}

if ( empty( $table['rows'] ) ):
    echo '<p class="text-center text-muted m-0"><i class="qa qa-database mr-2"></i>No social share data available</p>';
else: ?>
    <table class="table wpra-analytics-table" data-total_page_count="<?php echo $table['page_count']; ?>" data-table="social">
        <thead>
        <tr>
            <th scope="col">Type</th>
            <th scope="col">Title</th>
			<?php foreach ( $options['social_labels'] as $platform => $label ): ?>
                <th scope="col" class="text-center">
                    <img class="table-icon" src="<?php echo WPRA\Helpers\Utils::getAsset( 'images/social-color/' . $platform . '.svg' ); ?>" alt="">
                </th>
			<?php endforeach; ?>
            <th scope="col" class="text-right">Total</th>
        </tr>
        </thead>
        <tbody>
		    <?php foreach ($table['rows'] as $row):
			    $link = get_the_permalink($row['bind_id']);
			    $title = get_the_title($row['bind_id']);
			    $type = get_post_type($row['bind_id']); ?>
                <tr>
                    <td class="text-capitalize"><?php echo $type; ?></td>
                    <td><a target="_blank" href="<?php echo $link; ?>"><?php echo $title; ?></a></td>
				    <?php $total = 0;
				    foreach ($options['social_labels'] as $platform => $label) {
					    $total += $row[$platform]; ?>
                        <td class="text-center"><?php echo $row[$platform]; ?></td>
				    <?php } ?>
                    <td class="text-right"><?php echo $total;?></td>
                </tr>
		    <?php endforeach; ?>
        </tbody>
    </table>
<?php Utils::renderTemplate('view/admin/analytics/parts/table-nav', [ 'page_count' => $table['page_count']]);
endif;