<?php

$onsale = [
	'on_sale' => esc_html__('On Sale', 'shopengine-pro'),
	'regular_price' => esc_html__('Regular Price', 'shopengine-pro')
];

$name		= 'shopengine_filter_onsale';
$collapse	= false;

if ($settings['shopengine_filter_view_mode'] === 'collapse') {
	$collapse	= true;
}

$collapse_expand	= '';
//phpcs:ignore WordPress.Security.NonceVerification
if (isset($_GET[$name]) || $settings['shopengine_filter_onsale_expand_collapse'] === 'yes') {
	$collapse_expand	= 'open';
}
?>

<div class="shopengine-filter-single <?php echo esc_attr($collapse ? 'shopengine-collapse' : '') ?>">
	<div class="shopengine-filter <?php echo esc_attr($collapse_expand) ?>">
		<?php if (isset($settings['shopengine_filter_onsale_title'])) : ?>
			<h3 class="shopengine-product-filter-title">
				<?php
				echo esc_html($settings['shopengine_filter_onsale_title']);
				echo $collapse ? '<i class="eicon-chevron-right shopengine-collapse-icon"></i>' : '';
				?>
			</h3>
		<?php endif; ?>
	</div>

	<?php echo $collapse ? '<div class="shopengine-collapse-body ' . esc_attr($collapse_expand) . '">' : ''; ?>

	<?php foreach ($onsale as $key => $value) : ?>
		<?php
		$id		= 'xs-filter-onsale-' . $key;
		?>
		<div class="filter-input-group">
			<input class="shopengine-filter-onsale <?php echo esc_attr($name . '-' . $key) ?>" name="<?php echo esc_attr($name) ?>" type="checkbox" id="<?php echo esc_attr($id) ?>" value="<?php echo esc_attr($key); ?>" />
			<label class="shopengine-filter-onsale-label" for="<?php echo esc_attr($id) ?>">
				<?php if ($settings['shopengine_filter_onsale_styles']) {
					$deafult = 'shopengine-checkbox-icon';
					$style2 = 'shopengine-style-icon';
					$class = $settings['shopengine_filter_onsale_styles'] === 'style_2' ? $style2 : $deafult;
				} ?>
				<span class="<?php echo esc_attr($class); ?>">
					<span>
						<?php
						if ($settings['shopengine_filter_onsale_styles'] === 'style_2') {
							\Elementor\Icons_Manager::render_icon($settings['shpengine_cirlce_icon'], ['aria-hidden' => 'true']);
						} else {
							\Elementor\Icons_Manager::render_icon($settings['shopengine_check_icon'], ['aria-hidden' => 'true']);
						}
						?>
					</span>
				</span>
				<?php echo esc_html($value); ?>
			</label>
		</div>
	<?php endforeach; ?>

	<?php echo $collapse ? '</div>' : ''; ?>

	<form action="" method="get" class="shopengine-filter" id="shopengine_onsale_form">
		<input type="hidden" name="<?php echo esc_attr($name) ?>" class="shopengine-filter-onsale-value">
	</form>

</div>