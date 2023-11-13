<?php

namespace Elementor;

$uid = uniqid();
/**
 * 
 * Check attribute list is available or not 
 * 
 */
if (
	isset($settings['shopengine_attributes_list']) &&
	is_array($settings['shopengine_attributes_list'])
) :

	// check if the collapse enabled
	$collapse	   = false;

	if ($settings['shopengine_filter_view_mode'] === 'collapse') {
		$collapse	   = true;
	}

	/**
	 * 
	 * Loop through the attribute list
	 * assign every attribute property into $attribute variable 
	 */

	$taxonomies =  wc_get_attribute_taxonomies();

	foreach ($settings['shopengine_attributes_list'] as $attribute) :

		if (isset($taxonomies["id:" . $attribute['shopengine_attribute']]->attribute_type) && $taxonomies["id:" . $attribute['shopengine_attribute']]->attribute_type == 'select') :

			$taxonomy	= wc_attribute_taxonomy_name($taxonomies["id:" . $attribute['shopengine_attribute']]->attribute_name);
			$variations = get_terms($taxonomy, 'hide_empty=0');
			/**
			 * 
			 * if variations is not empty show filter markup
			 */

			if (!empty($variations) && empty($variations->errors)) :

				$collapse_expand = '';
				//phpcs:ignore WordPress.Security.NonceVerification
				if (isset($_GET['shopengine_filter_attribute_' . $taxonomy]) || $settings['shopengine_filter_attribute_expand_collapse'] === 'yes') {
					$collapse_expand = 'open';
				}
?>

				<div class="shopengine-filter-single <?php echo esc_attr($collapse ? 'shopengine-collapse' : '') ?>">
					<div class="shopengine-filter <?php echo esc_attr($collapse_expand) ?>">
						<?php
						/**
						 * 
						 * show filter title
						 * 
						 */
						if (isset($attribute['shopengine_attribute_title'])) :
						?>
							<h3 class="shopengine-product-filter-title">
								<?php
								echo esc_html($attribute['shopengine_attribute_title']);
								if ($collapse) echo '<i class="eicon-chevron-right shopengine-collapse-icon"></i>';
								?>

							</h3>
						<?php
						endif; // end of filter title 
						?>
					</div>

					
					<?php

					if ($collapse) echo '<div class="shopengine-collapse-body ' . esc_attr($collapse_expand) . '">';

					/**
					 * 
					 * loop through attribute list item
					 * 
					 */
					?>
					
					<?php
					foreach ($variations as $variation) :
						$prefix 					= 'shopengine_filter_attribute'; // this prefix refers to submited url property / form name
						$id							= 'xs-filter-attribute-' . $uid . '-' . $variation->slug;
						$name						=  $prefix . '_' . $variation->taxonomy;
						$selector_after_page_load	= $name . '-' . $variation->slug;
					?>
						<div class="filter-input-group">
							<input class="shopengine-filter-attribute <?php echo esc_attr($selector_after_page_load) ?>" name="<?php echo esc_attr($name) ?>" type="checkbox" id="<?php echo esc_attr($id) ?>" data-height="<?php echo esc_attr($height); ?>" data-scroll="<?php echo esc_attr($is_scroll); ?>" value="<?php echo esc_attr($variation->slug); ?>" />
							<label class="shopengine-filter-attribute-label" for="<?php echo esc_attr($id) ?>">
								<?php if ($settings['shopengine_filter_attribute_styles']) {
									$deafult = 'shopengine-checkbox-icon';
									$style2 = 'shopengine-style-icon';
									$class = $settings['shopengine_filter_attribute_styles'] === 'style_2' ? $style2 : $deafult;
								} ?>
								<span class="<?php echo esc_attr($class); ?>">
									<span>
										<?php
										if ($settings['shopengine_filter_attribute_styles'] === 'style_2') {
											Icons_Manager::render_icon($settings['shpengine_cirlce_icon'], ['aria-hidden' => 'true']);
										} else {
											Icons_Manager::render_icon($settings['shopengine_check_icon'], ['aria-hidden' => 'true']);
										}
										?>
									</span>
								</span>
								<?php echo esc_html($variation->name); ?>
							</label>
						</div>
					<?php
					endforeach;
					if ($collapse) echo '</div>'; // end of collapse body container
					?>

					<form action="" method="get" class="shopengine-filter" id="shopengine_attribute_form">
						<input type="hidden" name="<?php echo esc_attr($prefix) ?>" class="shopengine-filter-attribute-value">
					</form>

				</div>
<?php
			endif;
		endif;
	endforeach;
endif;
?>