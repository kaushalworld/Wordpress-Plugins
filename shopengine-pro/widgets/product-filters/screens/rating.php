<?php

namespace Elementor;

// check if the collapse enabled
$collapse	   = false;
$collapse_expand = '';

if ($settings['shopengine_filter_view_mode'] === 'collapse') {
	$collapse	   = true;
}
//phpcs:ignore WordPress.Security.NonceVerification
if ($settings['shopengine_filter_rating_expand_collapse'] === 'yes' || isset($_GET['rating_filter'])) {
	$collapse_expand = 'open';
}
?>

<div class="shopengine-filter-single <?php echo esc_attr($collapse ? 'shopengine-collapse' : '') ?>">
	<form action="" method="get" class="shopengine-filter shopengine-filter-rating">

		<?php
		/**
		 * 
		 * show filter title
		 * 
		 */
		if (isset($settings['shopengine_filter_rating_title'])) :
		?>
			<div class="shopengine-filter <?php echo esc_attr($collapse_expand) ?>">
				<h3 class="shopengine-product-filter-title">
					<?php
					echo esc_html($settings['shopengine_filter_rating_title']);
					if ($collapse) echo '<i class="eicon-chevron-right shopengine-collapse-icon"></i>';
					?>
				</h3>
			</div>
		<?php
		endif; // end of filter title 
		if ($collapse) echo '<div class="shopengine-collapse-body ' . esc_attr($collapse_expand) . '">';
		?>

		<div class="shopengine-filter-rating__labels">
			<?php

			$style2 = 'shopengine-style-icon';
			$class = $settings['shopengine_filter_rating_styles'] === 'style_2' ? $style2 : "";

			/**
			 * 
			 * loop through list item
			 * 
			 */
			for ($i = 5; $i >= 1; $i--) :
			?>
				<button title="<?php esc_html_e('Rating', 'shopengine-pro')?>" class="rating-label-triger <?php echo esc_attr($class); ?> shopengine-rating-name-<?php echo esc_attr($i) ?>" data-target="rating_filter_input" for="rating_filter" data-rating="<?php echo esc_attr($i) ?>">

					<span class="shopengine-filter-rating__labels--mark">
						<span>
							<?php

							if ($settings['shopengine_filter_rating_styles'] === 'style_2') {
								Icons_Manager::render_icon($settings['shpengine_cirlce_icon'], ['aria-hidden' => 'true']);
							} else {
								Icons_Manager::render_icon($settings['shopengine_check_icon'], ['aria-hidden' => 'true']);
							}

							?>
						</span>
					</span>
					<div class="shopengine-filter-rating__labels__stars">

						<div class="shopengine-filter-rating__labels-star inactive">
							<?php for ($star = 1; $star <= 5; $star++) :
								Icons_Manager::render_icon($settings['shopengine_star_rating'], ['aria-hidden' => 'true']);
							endfor; ?>
						</div>

						<div class="shopengine-filter-rating__labels-star active">
							<?php for ($star = 1; $star <= $i; $star++) :
								Icons_Manager::render_icon($settings['shopengine_star_rating'], ['aria-hidden' => 'true']);
							endfor; ?>
						</div>

					</div>
				</button>
			<?php endfor; ?>
		</div>

		<?php
		if ($collapse) echo '</div>'; // end of collapse body container
		?>

		<div class="shopengine-filter-price-fields">
			<input type="hidden" id="rating_filter_input" name="rating_filter" />
		</div>
	</form>
</div>