<?php 
$starRating   = $settings['exad_woo_product_show_star_rating'];

?>

<div <?php post_class( 'exad-woo-product-item exad-col' ); ?>>
<?php do_action( 'exad_before_each_product_item' ); ?>
    <div class="exad-single-woo-product-wrapper">
    <?php if( has_post_thumbnail() ) : ?>
        <div class="exad-single-woo-product-image">
        <?php
      global $product, $post;
      $average = $product->get_average_rating();
      $out_of_stock = false;
      if (!$product->is_in_stock() && !is_product()) {
          $out_of_stock = true;
      }
      ?>
     <ul class="exad-woo-product-content-badge">
     <?php
         /* Sale label */
         if ($product->is_on_sale() && !$out_of_stock) {

             $percentage = '';

             if ($product->get_type() == 'variable') {

                 $available_variations = $product->get_variation_prices();
                 $max_percentage = 0;

                 foreach ($available_variations['regular_price'] as $key => $regular_price) {
                     $sale_price = $available_variations['sale_price'][$key];

                     if ($sale_price < $regular_price) {
                         $percentage = round((($regular_price - $sale_price) / $regular_price) * 100);

                         if ($percentage > $max_percentage) {
                             $max_percentage = $percentage;
                         }
                     }
                 }

             $percentage = $max_percentage;
             } elseif ($product->get_type() == 'simple' || $product->get_type() == 'external') {
                 $percentage = round((($product->get_regular_price() - $product->get_sale_price()) / $product->get_regular_price()) * 100);
             }

             if ( $percentage && ( 'yes' == $settings['exad_woo_product_sell_in_percentage_tag_enable'] )) { 
                 echo '<li class="onsale percent">'.$percentage.'%'.'</li>';
             } else if( $percentage && ( 'yes' != $settings['exad_woo_product_sell_in_percentage_tag_enable'] ) ) {
                 if('yes' == $settings['exad_woo_product_sale_tag_enable']){
                     echo '<li class="onsale">'.apply_filters('exad_product_offer_tag_filter', __('Sale', 'exclusive-addons-elementor-pro') ).'</li>';
                 }
             }

         }

         //Hot label
         if ($product->is_featured() && !$out_of_stock && ( 'yes' == $settings['exad_woo_product_featured_tag_enable'] )) {
             echo '<li class="featured">'.esc_html($settings['exad_woo_product_featured_tag_text']).'</li>';
         }

         // Out of stock
         if ($out_of_stock && ( 'yes' == $settings['exad_woo_product_sold_out_tag_enable'] )) {
             echo '<li class="out-of-stock">'.apply_filters('exad_product_sold_out_filter', __('Sold out', 'exclusive-addons-elementor-pro') ).'</li>';
         }
     ?>
     </ul>
 <?php    
            the_post_thumbnail( $settings['image_size_size'] ); ?>
            <div class="exad-single-woo-product-hover-items">
                <?php woocommerce_template_loop_add_to_cart(); ?>
            </div>
            <?php 
            if( ! empty( $attachment_ids[0] ) && 'yes' == $settings['exad_woo_product_show_gallery_image_on_hover'] ) : ?>
                <span class="exad-product-hover-image">
                    <?php echo wp_get_attachment_image( $attachment_ids[0], $settings['image_size_size'] ); ?>
                </span>
            <?php endif; ?>
        </div>
        <?php endif; ?>

        <div class="exad-single-woo-product-content">
        <?php
            do_action( 'exad_before_each_product_content' );
            if( 'yes' == $settings['exad_woo_product_show_category'] ) :
                $terms = get_the_terms( $product->get_id(), 'product_cat' );
                if ( ! empty( $terms ) ) : ?>
                    <a class="exad-product-cat" href="<?php echo esc_url( get_category_link( $terms[0]->term_id ) ); ?>"><?php echo esc_html( $terms[0]->name ); ?></a>
                <?php endif;                               
            endif; 
            ?>
            <a href="<?php echo get_permalink(); ?>">
                <h3 class="exad-woo-product-content-name"><?php echo get_the_title(); ?></h3>
            </a>
            <?php
              $product  = wc_get_product( get_the_ID() );
              ?>
            <span class="exad-woo-product-content-price">
            <?php
                $price = $product->get_price_html();
                if ( ! empty( $price ) ) {
                    echo wp_kses(
                        $price, array(
                            'span' => array(
                                'class' => array()
                            ),
                            'del'  => array()
                        )
                    );
                }
            ?>
            </span>
            <?php 
            if( 'yes' == $starRating ) : ?>                           
                <ul class="exad-woo-product-content-rating">
                    <div class="exad-woo-product-star-rating" title="<?php echo sprintf(__( 'Rated %s out of 5', 'exclusive-addons-elementor-pro' ), $average); ?>">
                        <span style="width:<?php echo ( ( $average / 5 ) * 100 ); ?>%"><strong itemprop="ratingValue" class="rating"><?php echo $average; ?></strong> <?php _e( 'out of 5', 'exclusive-addons-elementor-pro' ); ?></span>
                    </div>
                </ul>
            <?php    
            endif;

            if( 'yes' == $settings['exad_woo_show_product_excerpt'] ) :
                $excerptLength = $settings['exad_woo_product_excerpt_length'] ? $settings['exad_woo_product_excerpt_length'] : 10; ?>
                    <p class="exad-woo-product-content-description"><?php echo wp_trim_words( wp_kses_post( get_the_excerpt() ), esc_html( $excerptLength ) ); ?></p>
            
            <?php
            endif;

            woocommerce_template_loop_add_to_cart();
            do_action('exad_after_each_product_content');
            ?>

        </div>
    </div>
    <?php do_action('exad_after_each_product_item'); ?>
</div>
<?php

?>