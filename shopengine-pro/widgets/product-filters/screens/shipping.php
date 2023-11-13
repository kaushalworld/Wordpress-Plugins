<?php

$shipping_classes = get_terms(['taxonomy' => 'product_shipping_class', 'hide_empty' => false]);

if (!empty($shipping_classes) && is_array($shipping_classes)) :

	$uid		= uniqid();
	$prefix		= 'shopengine_filter_shipping';
	$collapse	= false;

	if ($settings['shopengine_filter_view_mode'] === 'collapse') {
		$collapse	= true;
	}

	$collapse_expand	= '';
	//phpcs:ignore WordPress.Security.NonceVerification
	if (isset($_GET['shopengine_filter_shipping_product_shipping_class']) || $settings['shopengine_filter_shipping_expand_collapse'] === 'yes') {
		$collapse_expand	= 'open';
	}
?>

	<div class="shopengine-filter-single <?php echo esc_attr($collapse ? 'shopengine-collapse' : '') ?>">
		<div class="shopengine-filter <?php echo esc_attr($collapse_expand) ?>">
			<?php if (isset($settings['shopengine_filter_shipping_title'])) : ?>
				<h3 class="shopengine-product-filter-title">
					<?php
					echo esc_html($settings['shopengine_filter_shipping_title']);
					echo $collapse ? '<i class="eicon-chevron-right shopengine-collapse-icon"></i>' : '';
					?>
				</h3>
			<?php endif; ?>
		</div>

		<?php echo $collapse ? '<div class="shopengine-collapse-body ' . esc_attr($collapse_expand) . '">' : ''; ?>

		<?php foreach ($shipping_classes as $shipping_class) : ?>
			<?php
			$id							= 'xs-filter-shipping-' . $uid . '-' . $shipping_class->slug;
			$name						=  $prefix . '_' . $shipping_class->taxonomy;
			$selector_after_page_load	= $prefix . '_' . $shipping_class->taxonomy . '-' . $shipping_class->slug;
			?>
			<div class="filter-input-group">
				<input class="shopengine-filter-shipping <?php echo esc_attr($selector_after_page_load) ?>" name="<?php echo esc_attr($name) ?>" type="checkbox" id="<?php echo esc_attr($id) ?>" value="<?php echo esc_attr($shipping_class->slug); ?>" />
				<label class="shopengine-filter-shipping-label" for="<?php echo esc_attr($id) ?>">
					<?php if ($settings['shopengine_filter_shipping_styles']) {
						$deafult = 'shopengine-checkbox-icon';
						$style2 = 'shopengine-style-icon';
						$class = $settings['shopengine_filter_shipping_styles'] === 'style_2' ? $style2 : $deafult;
					} ?>
					<span class="<?php echo esc_attr($class); ?>">
						<span>
							<?php
							if ($settings['shopengine_filter_shipping_styles'] === 'style_2') {
								\Elementor\Icons_Manager::render_icon($settings['shpengine_cirlce_icon'], ['aria-hidden' => 'true']);
							} else {
								\Elementor\Icons_Manager::render_icon($settings['shopengine_check_icon'], ['aria-hidden' => 'true']);
							}
							?>
						</span>
					</span>
					<?php echo esc_html($shipping_class->name); ?>
				</label>
			</div>
		<?php endforeach; ?>

		<?php echo $collapse ? '</div>' : ''; ?>

		<form action="" method="get" class="shopengine-filter" id="shopengine_shipping_form">
			<input type="hidden" name="<?php echo esc_attr($prefix) ?>" class="shopengine-filter-shipping-value">
		</form>

	</div>

<?php endif; ?>