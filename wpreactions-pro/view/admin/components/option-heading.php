<?php
use WPRA\Helpers\Utils;
$id = $heading = $subheading = $tooltip = '';
$plugin_path = WPRA_PLUGIN_PATH;
$align = 'center';
isset($data) && extract($data);
$id_attr = empty($id) ? '' : 'id="option-heading-' . $id .'"';
?>

<div <?php echo $id_attr; ?> class="wpra-option-heading heading-<?php echo $align; ?>">
	<h4>
        <span><?php echo $heading; ?></span>
		<?php !empty($tooltip) && Utils::tooltip( $tooltip, $plugin_path ); ?>
    </h4>
    <span><?php echo $subheading; ?></span>
</div>