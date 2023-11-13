<div class="shopengine-filter-single">
	<form
		action="" method="get"
		class="shopengine-filter shopengine-filter-price"
		data-default-range="<?php echo wp_json_encode( $default_range ); ?>" data-exchange-rate="<?php echo esc_attr(apply_filters('shopengine_currency_exchange_rate', 0));?>">
		<?php if ( isset( $settings['shopengine_filter_price_title'] ) ) : ?>
			<h3 class="shopengine-product-filter-title">
				<?php echo esc_html($settings['shopengine_filter_price_title']) ?>
			</h3>
		<?php endif; ?>

		<div class="shopengine-filter-price-slider"></div>

		<!-- <input class="shopengine-filter-price-slider" type="range" min="0" max="10" step="1" hidden /> -->
		
		<?php /*
		<div class="shopengine-filter-price-slider">
			<div class="ui-slider-range" style="left: 0%; width: 100%;"></div>

			<span tabindex="0" class="ui-slider-handle" style="left: 0%;"></span>
			<span tabindex="0" class="ui-slider-handle" style="left: 100%;"></span>
		</div>
		*/ ?>

		<div class="shopengine-filter-price-fields">
			<input type="number" name="min_price" />
			<input type="number" name="max_price" />
		</div>

		<div class="shopengine-filter-price-btns">
				<p class="shopengine-filter-price-result" data-sign="<?php echo esc_attr(get_woocommerce_currency_symbol()); ?>">
					<?php
						$format = apply_filters('shopengine_product_filter_currency_symbol_format', '%1$s%2$s'); 
						echo sprintf($format,wp_kses(get_woocommerce_currency_symbol(), \ShopEngine_Pro\Util\Helper::get_kses_array()) , esc_html($default_range[0]))  .' - '. sprintf($format, wp_kses(get_woocommerce_currency_symbol(), \ShopEngine_Pro\Util\Helper::get_kses_array()) , esc_html($default_range[0]), esc_html($default_range[1]));
					?>
				</p>
				<button type="button" class="shopengine-filter-price-reset"><?php echo esc_html__( 'Reset', 'shopengine-pro' ); ?></button>
		</div>
	</form>
</div>