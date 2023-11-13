<?php if ($the_query->have_posts()) : ?>

	<div class="shopengine-crosssell-popup">
		<a title="<?php esc_html_e('Close Modal', 'shopengine-pro')?>" href="#close-modal" rel="modal:close" class="se-close-modal ">
			<svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 17 17" fill="none">
				<path d="M16 1L1 16" stroke="#575C65" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
				<path d="M1 1L16 16" stroke="#575C65" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
			</svg>
		</a>
		<div class="se-modal-inner">
			<div class="se-crosssell-popup-header">
				<div class="se-crosssell-popup-message">
					<h3> 
						<span class="se-crosssell-popup-icon">
							<i aria-hidden="true" class="fas fa-check-circle"></i>
						</span>
						<span>
							<?php echo esc_html(get_the_title( $product_id )); ?>
						</span>
						<?php echo esc_html__('has been added to your shopping cart.','shopengine-pro')?>
					</h3>
				</div>
				<div class="se-crosssell-popup-action-btns">
					<a title="<?php esc_html_e('Cart Page', 'shopengine-pro')?>" href="<?php echo esc_url(wc_get_cart_url()) ?>" class="shopping-cart-btn"><?php esc_html_e('View Shopping Cart','shopengine-pro')?></a>
					<a title="<?php esc_html_e('Continue Shopping', 'shopengine-pro')?>" href="<?php echo esc_url(get_permalink( wc_get_page_id( 'shop' )))?>" class="Continue-shopping-btn"><?php esc_html_e('Continue Shopping', 'shopengine-pro')?></a>
				</div>
			</div>
			<hr>
			<div class="se-crosssell-popup-items">
				<h3 class="shopengine-add-to-cart-popup-title"><?php echo esc_html__('Buyers who bought this item also bought:','shopengine-pro')?></h3>
				<div class="se-crosssell-popup-item-container">
					<?php while ($the_query->have_posts()) : $the_query->the_post();
						$product  = wc_get_product(get_the_ID()); ?>
						<div class="se-crosssell-popup-single-item">
							<div class="se-crosssell-popup-img">
								<a title="<?php esc_attr_e('Product Thumbnail', 'shopengine-pro')?>" href="<?php echo esc_url($product->get_permalink()); ?>"><?php shopengine_pro_content_render($product->get_image()); ?></a>
							</div>
							<div class="se-crosssell-popup-item-description">
								<h6 class="se-crosssell-popup-item-category"><?php shopengine_pro_content_render(wc_get_product_category_list($product->get_id())); ?></h6>
								<h5 class="se-crosssell-popup-item-title"><a href="<?php echo esc_url($product->get_permalink()); ?>"><?php echo esc_html($product->get_title()); ?></a></h5>
								<div class="se-crosssell-popup-item-rating">
									<?php printf('<div class="star-rating"><span style="width:%1$s%2$s">.</span></div>', esc_html(($product->get_average_rating() / 5) * 100), '%'); ?>
									<div class="se-crosssell-popup-item-rating-number">(<?php echo esc_html($product->get_rating_count()); ?>)</div>
								</div>
								<h5 class="se-crosssell-popup-item-price">
									<?php if ( $price_html = $product->get_price_html() ) : ?>
										<span class="price"><?php shopengine_pro_content_render($price_html); ?></span>
									<?php endif; ?>
								</h5>
							</div>
						</div>
					<?php endwhile;
					wp_reset_postdata(); ?>
				</div>
			</div>
		</div>
	</div>
<?php endif;?>
