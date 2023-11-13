<div class="shopengine-product-size-chart-body">
	<?php if( $shopengine_product_size_type === 'modal' ): ?>
	<button class="shopengine-product-size-chart-button"><?php echo esc_html($shopengine_product_size_charts_button_text); ?></button>
	<div class="shopengine-product-size-chart" data-model="yes">
		<div class="shopengine-product-size-chart-contant">
			<img src="<?php echo esc_url($chart)?>" alt="<?php esc_attr_e('Size Chart','shopengine-pro'); ?>">
		</div>
	</div>
	<?php elseif( $shopengine_product_size_type === 'normal' ): ?>
		<h2 class="shopengine-product-size-chart-heading"><?php echo esc_html( $shopengine_product_size_charts_title_text ); ?></h2>
		<div class="shopengine-product-size-chart-img">
			<img src="<?php echo esc_url($chart)?>" alt="<?php esc_attr_e('Size Chart','shopengine-pro'); ?>"/>
		</div>
	<?php endif; ?>
</div>