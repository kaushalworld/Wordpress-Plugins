<?php

namespace Elementor;

use ShopEngine\Widgets\Products;

?>
<div class="shopengine-product-filters">
	<?php if ($settings['shopengine_filter_toggle_button'] === 'yes') : ?>
		<div class="shopengine-filter-group">
			<div class="shopengine-filter-group-toggle-wrapper">
				<!-- Filter button trigger -->
				<button type="button" class="shopengine-btn shopengine-filter-group-toggle" data-target="#shopengine-filter-group-content" id="shopengine-filter-group-toggle">
					<?php if ($settings['shopengine_filter_toggler_icon_status']) : ?>
						<!-- Left Icon -->
						<?php if ($settings['shopengine_filter_toggler_icon_position'] == 'left') :
							Icons_Manager::render_icon($settings['shopengine_filter_toggler_icon'], ['aria-hidden' => 'true']);
						endif; ?>

						<?php echo esc_html($settings['shopengine_filter_toggle_button_toggler']) ?>

						<!-- Right Icon -->
						<?php if ($settings['shopengine_filter_toggler_icon_position'] == 'right') :
							Icons_Manager::render_icon($settings['shopengine_filter_toggler_icon'], ['aria-hidden' => 'true']);
						endif; ?>
					<?php else :
						echo esc_html($settings['shopengine_filter_toggle_button_toggler']);
					endif; ?>
				</button>
			</div>
			<div id="shopengine-filter-group-content" class="shopengine-filter-group-content-wrapper">
				<?php 
				if($settings['shopengine_filter_offcanvas_overlay'] === 'yes') {
					echo '<div class="shopengine-filter-overlay"></div>';
				}
				?>
				<div class="shopengine-filter-group-content">
				<?php endif; ?>

				<!-- FILTERS START -->
				<div class="shopengine-product-filters-wrapper" data-filter-price="<?php echo esc_attr($settings['shopengine_filter_toggle_price'], 'shopengine-pro'); ?>" data-filter-rating="<?php echo esc_attr($settings['shopengine_filter_toggle_rating'], 'shopengine-pro'); ?>" data-filter-color="<?php echo esc_attr($settings['shopengine_filter_toggle_color'], 'shopengine-pro'); ?>" data-filter-category="<?php echo esc_attr($settings['shopengine_filter_toggle_category'], 'shopengine-pro'); ?>" data-filter-attribute="<?php echo esc_attr($settings['shopengine_enable_attribute'], 'shopengine-pro'); ?>" data-filter-label="<?php echo esc_attr($settings['shopengine_enable_label'], 'shopengine-pro'); ?>" data-filter-image="<?php echo esc_attr($settings['shopengine_enable_image'], 'shopengine-pro'); ?>" data-filter-shipping="<?php echo esc_attr($settings['shopengine_enable_shipping'], 'shopengine-pro'); ?>" data-filter-stock="<?php echo esc_attr($settings['shopengine_enable_stock'], 'shopengine-pro'); ?>" data-filter-onsale="<?php echo esc_attr($settings['shopengine_enable_onsale'], 'shopengine-pro'); ?>" data-filter-view-mode="<?php echo esc_attr($settings['shopengine_filter_view_mode'], 'shopengine-pro'); ?>">
					<?php
					if ('yes' === $settings['shopengine_filter_toggle_price']) {
						$tplPrice = Products::instance()->get_widget_template($this->get_name(), 'price', \ShopEngine_Pro::widget_dir());

						include $tplPrice;
					}

					if ('yes' === $settings['shopengine_filter_toggle_rating']) {
						$tplRating = Products::instance()->get_widget_template($this->get_name(), 'rating', \ShopEngine_Pro::widget_dir());

						include $tplRating;
					}

					if ('yes' === $settings['shopengine_filter_toggle_color']) {

						$color_options = Products::instance()->get_all_color_terms();

						if (!empty($color_options)) {

							$tplColor = Products::instance()->get_widget_template($this->get_name(), 'color', \ShopEngine_Pro::widget_dir());

							include $tplColor;
						}
					}

					if ('yes' === $settings['shopengine_filter_toggle_category']) {

						$orderby = isset($settings['shopengine_filter_category_orderby']) ? $settings['shopengine_filter_category_orderby'] : 'name';
						$hierarchical = isset($settings['shopengine_filter_category_hierarchical']) ? $settings['shopengine_filter_category_hierarchical'] : true;
						$show_parent_only = isset($settings['shopengine_filter_category_show_parent_only']) ? $settings['shopengine_filter_category_show_parent_only'] : '';
						$hide_empty = isset($settings['shopengine_filter_category_hide_empty']) ? $settings['shopengine_filter_category_hide_empty'] : false;

						$args = [
							'hide_empty'	=> $hide_empty,
						];

						if ($hierarchical || $show_parent_only) {
							$args['hierarchical'] = $hierarchical;
							$args['parent'] = 0;
						}

						if ('order' === $orderby) {
							$args['orderby'] = 'meta_value_num';
							$args['meta_key'] = 'order';
						} else {
							$args['orderby'] = 'name';
							$args['order'] = 'ASC';
						}

						$product_categories = get_terms('product_cat', $args);

						$tplCategory = Products::instance()->get_widget_template($this->get_name(), 'category', \ShopEngine_Pro::widget_dir());

						include $tplCategory;
					}

					if ('yes' === $settings['shopengine_enable_image']) {

						$image_options = Products::instance()->get_all_image_terms();

						if (!empty($image_options)) {

							$tplImage = Products::instance()->get_widget_template($this->get_name(), 'image', \ShopEngine_Pro::widget_dir());

							include $tplImage;
						}
					}

					if ('yes' === $settings['shopengine_enable_label']) {

						$label_options = Products::instance()->get_all_label_terms();

						if (!empty($label_options)) {

							$tplLabel = Products::instance()->get_widget_template($this->get_name(), 'label', \ShopEngine_Pro::widget_dir());

							include $tplLabel;
						}
					}

					if (isset($settings['shopengine_enable_attribute']) && $settings['shopengine_enable_attribute'] === 'yes') {

						$tplAttribute = Products::instance()->get_widget_template($this->get_name(), 'attribute', \ShopEngine_Pro::widget_dir());

						include $tplAttribute;
					}

					if (isset($settings['shopengine_enable_shipping']) && $settings['shopengine_enable_shipping'] === 'yes') {

						$tplShipping = Products::instance()->get_widget_template($this->get_name(), 'shipping', \ShopEngine_Pro::widget_dir());

						include $tplShipping;
					}

					if (isset($settings['shopengine_enable_stock']) && $settings['shopengine_enable_stock'] === 'yes') {

						$tplStock = Products::instance()->get_widget_template($this->get_name(), 'stock', \ShopEngine_Pro::widget_dir());

						include $tplStock;
					}

					if (isset($settings['shopengine_enable_onsale']) && $settings['shopengine_enable_onsale'] === 'yes') {

						$tplOnSale = Products::instance()->get_widget_template($this->get_name(), 'onsale', \ShopEngine_Pro::widget_dir());

						include $tplOnSale;
					}

					?>
				</div>
				<!-- FILTERS END -->

				<?php if ($settings['shopengine_filter_toggle_button'] === 'yes') : ?>
				</div>
			</div>
		</div>
	<?php endif; ?>
</div>