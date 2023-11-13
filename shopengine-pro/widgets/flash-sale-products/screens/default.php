<?php

$module_list = \ShopEngine\Core\Register\Module_List::instance();
if($module_list->get_list()['flash-sale-countdown']['status'] === 'active'):
   $module_settings = $module_list->get_settings('flash-sale-countdown');
   $campaigns = \ShopEngine_Pro\Modules\Flash_Sale\Flash_Sale_Countdown::flash_sale_campaign($module_settings);

if (!empty($campaigns[$settings['flash_sale']])) :
   $flash_sale = $campaigns[$settings['flash_sale']];
   $products = $flash_sale['product_list'];

   $args = array(
         'post_type' => 'product',
         'status'    => 'publish',
         // 'meta_query' => array(
         //    array(
         //       'key'     => '_sale_price_dates_to',
         //       'value' => '',
         //       'compare' => '!='
         //    ),
         // ),
         'post__in'       => empty($products) ? [''] : $products,
         'posts_per_page' => isset($settings['products_per_page']) ? $settings['products_per_page'] : 4,
         'order'          => isset($settings['product_order']) ? $settings['product_order'] : 'DESC',
         'orderby'        => isset($settings['product_orderby']) ? $settings['product_orderby'] : 'date',
   );

   $query = new WP_Query($args);
   $post_type = get_post_type();
?>

<div class="shopengine-widget">
<div class="shopengine-deal-products-widget">
   <div class="deal-products-container">
      <?php

         if($query->have_posts()): while($query->have_posts()): $query->the_post();

         $id         = get_the_ID();
         $title      = wp_trim_words( get_the_title(),  $settings['title_word_limit'] , '...' );
         $image_id   = get_post_thumbnail_id($id);
         $product    = wc_get_product( $id );
         $price      = wc_price( $product->get_price() );
         $reg_price  = wc_price( $product->get_regular_price() );
         $stock_qty  = $product->get_stock_quantity();
         $total_sell = $product->get_total_sales();
         $available  = $stock_qty - $total_sell;
        
         if ( $product->is_type( 'variable' ) ) {
            $variation_price_min      = wc_price( $product->get_variation_price('min') );
            $variation_price_max      = wc_price( $product->get_variation_price('max') );
         }
         if( intval( $product->get_regular_price()) !== 0 ) {
            $offPercentage = intval($product->get_price()) / intval( $product->get_regular_price()) * 100;
         }

         $sales_price_from = !empty($flash_sale['start_date']) ? $flash_sale['start_date'] : '';
         $sales_price_to   = !empty($flash_sale['end_date']) ? $flash_sale['end_date'] : '';
         $current_time     = strtotime(date('Y-m-d H:i:s')); // get the current time
         // when woo commerce date form value not found it will take the date when the post was created
         if( !isset( $sales_price_from ) || empty( $sales_price_from ) ){
            $sales_price_from = strtotime(get_the_date());
         }
         // data for countdown clock
         $deal_data = [
            'start_time'   => date('Y-m-d H:i:s', strtotime($sales_price_from)),
            'end_time'     => date('Y-m-d H:i:s', strtotime($sales_price_to.' 24:00:00')),
            'show_days'    => ( $settings['shopengine_show_countdown_clock_days'] === 'yes' ) ? 'yes' : 'no' ,
         ];


         // options for sell and available section
         $progress_data = [
            'bg_line_clr'     => (isset($settings['shopengine_product_stock_bg_line_clr'])) ? $settings['shopengine_product_stock_bg_line_clr'] : '#F2F2F2',
            'bg_line_height'  => (isset($settings['shopengine_product_stock_bg_line_height']['size'])) ? $settings['shopengine_product_stock_bg_line_height']['size'] : 2,
            'bg_line_cap'     => (isset($settings['shopengine_product_stock_line_cap'])) ? $settings['shopengine_product_stock_line_cap'] : 'round', // "butt|round|square"

            'prog_line_clr'   => (isset($settings['shopengine_product_stock_prog_line_clr'])) ? $settings['shopengine_product_stock_prog_line_clr'] : '#F03D3F',
            'prog_line_height'=> (isset($settings['shopengine_product_stock_prog_line_height']['size'])) ? $settings['shopengine_product_stock_prog_line_height']['size'] : 4,
            'prog_line_cap'   => (isset($settings['shopengine_product_stock_line_cap'])) ? $settings['shopengine_product_stock_line_cap'] : 'round',

            'stock_qty'       => $stock_qty,
            'total_sell'      => $total_sell
         ];

      ?>

      <div class="deal-products" data-deal-data='<?php echo json_encode($deal_data) ?>'>

         <div class="deal-products__top">
            <!-- product image -->
            <?php echo wp_get_attachment_image($image_id, "", false, ['class' => 'deal-products__top--img']); ?>

            <!-- offer show in percentage -->
            <?php if($settings['shopengine_show_percentage_badge'] === 'yes' && (intval( $product->get_regular_price()) !== 0) || isset($variation_price_min)): ?>
               <?php if($flash_sale['discount_type'] === 'percent'):?>
               <span class="shopengine-offer-badge">-<?php echo esc_html($flash_sale['discount_amount']) ?>%</span>
               <?php else:?>
               <span class="shopengine-offer-badge">-<?php echo wp_kses(apply_filters('flash_sale_fixed_discount_amount', $flash_sale['discount_amount']), \ShopEngine_Pro\Util\Helper::get_kses_array()); ?><?php echo wp_kses(get_woocommerce_currency_symbol(), \ShopEngine_Pro\Util\Helper::get_kses_array());?></span>
               <?php endif;?>
            <?php endif; ?>

             <!-- sale badge -->
            <?php if($settings['shopengine_is_sale_badge'] === 'yes' ): ?>
               <span class="shopengine-sale-badge"> <?php echo esc_html($settings['shopengine_sale_badge_text']); ?> </span>
            <?php endif; ?>

            <!-- countdown clock -->
            <?php if( $settings['shopengine_show_countdown_clock'] === 'yes' ): ?>
            <div class="shopengine-countdown-clock">

               <?php if( $settings['shopengine_show_countdown_clock_days'] === 'yes' ): ?>
                  <span class="se-clock-item">
                     <span class="clock-days"></span>
                     <span class="clock-days-label"><?php echo esc_html__('Days', 'shopengine-pro') ?></span>
                  </span>
               <?php endif; ?>

                <span class="se-clock-item">
                  <span class="clock-hou"></span>
                  <span class="clock-hou-label"><?php echo esc_html__('Hours', 'shopengine-pro') ?></span>
                </span>

                <span class="se-clock-item">
                  <span class="clock-min"></span>
                  <span class="clock-min-label"><?php echo esc_html__('Min', 'shopengine-pro') ?></span>
                </span>

                <span class="se-clock-item">
                  <span class="clock-sec"></span>
                  <span class="clock-sec-label"><?php echo esc_html__('Sec', 'shopengine-pro') ?></span>
                </span>
            </div>

            <?php endif; ?>

         </div>

         <!-- product description -->
         <div class="deal-products__desc">
            <h4 class="deal-products__desc--name">  <a title="<?php esc_html_e('Dealing Product', 'shopengine-pro')?>" href="<?php the_permalink() ?>"> <?php echo esc_html($title) ?> </a>  </h4>
         </div>

         <?php if ( $product->is_type( 'variable' ) ) { ?>
              <div class="deal-products__prices">
               <ins><span class="woocommerce-Price-amount amount"><?php echo wp_kses($variation_price_min. ' - '.$variation_price_max, \ShopEngine\Utils\Helper::get_kses_array()); ?> </span></ins>
             </div>
         <?php }else{ ?>

             <!-- product description -->
         <div class="deal-products__prices">
               <ins><span class="woocommerce-Price-amount amount"><?php echo wp_kses($price, \ShopEngine\Utils\Helper::get_kses_array()); ?> </span></ins>

               <?php if( !empty( $price )  ) : ?>
                  <del>
                     <span class="woocommerce-Price-amount amount">
                        <?php echo  wp_kses($reg_price,\ShopEngine\Utils\Helper::get_kses_array()) ?>
                     </span>
                  </del>
               <?php endif; ?>

         </div>
         <?php } ?>

         <?php if( ! is_null($stock_qty) ) : ?>
         <!-- stock and sold line chart -->
         <div class="deal-products__grap">
            <canvas class="deal-products__grap--line" height="<?php echo esc_attr($progress_data['prog_line_height'] + 2) ?>" data-settings='<?php echo json_encode($progress_data) ?>'></canvas>
            <div class="deal-products__grap__sells">
               <div class="deal-products__grap--available">
                   <span><?php echo esc_html__('Available:', 'shopengine-pro') ?></span>
                   <span class="avl_num"><?php echo esc_html( $available ) ?></span>
               </div>
               <div class="deal-products__grap--sold">
                  <span><?php echo esc_html__( 'Sold:', 'shopengine-pro') ?></span>
                   <span class="sld_num"><?php echo esc_html( $total_sell ) ?></span>
               </div>
            </div>
         </div>
         <?php endif; ?>

      </div>

      <?php

      endwhile;
   else: 
      echo esc_html__('No deal product available', 'shopengine-pro');
   endif; wp_reset_postdata(); ?>
   </div>
</div>
</div>
<?php
elseif(\Elementor\Plugin::$instance->editor->is_edit_mode() || is_preview()):
   echo esc_html__('No deal products available', 'shopengine-pro');
endif;
elseif(\Elementor\Plugin::$instance->editor->is_edit_mode() || is_preview()):
	echo esc_html__('Please active shopengine flash sale module', 'shopengine-pro');
endif;
