<?php

$shopengine_title_word_limit = !empty($settings['shopengine_title_word_limit']) ? intval($settings['shopengine_title_word_limit']) : 10;
$shopengine_product_limit = !empty($settings['shopengine_product_limit']) ? intval($settings['shopengine_product_limit']) : 8;


global $wpdb;

$sql = "SELECT products.*, MAX(order_product.date_created) as last_order_date FROM {$wpdb->prefix}wc_order_product_lookup AS order_product
	INNER JOIN {$wpdb->prefix}posts AS orders ON (orders.ID = order_product.order_id AND orders.post_status IN('wc-processing', 'wc-completed'))
	INNER JOIN {$wpdb->prefix}posts AS products ON (products.ID = order_product.product_id AND products.post_status = 'publish')
	GROUP BY order_product.product_id";

if (!empty($settings['shopengine_last_day']) && $settings['shopengine_last_day'] !== 'life_time') {

    $days = $d = date('Y-m-d', strtotime('-' . intval($settings['shopengine_last_day']) . ' days', time()));
    $sql .= $wpdb->prepare(" HAVING MAX(order_product.date_created) > %s",$days);
}

$sql .= $wpdb->prepare(" ORDER BY SUM(order_product.product_qty) DESC LIMIT %d", $shopengine_product_limit);

$results = $wpdb->get_results($sql); //phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared
/**
 * 
 * 
 * @var $default_content 
 * This array contains the content type for product 
 * 
 */ 
$default_content = [
    'image'     => 0,
    'category'  => 0,
    'title'     => 0,
    'rating'    => 0,
    'price'     => 0,
    // 'description' => 0,
    'buttons'     => 0,
];

if( empty($settings['shopengine_is_cats']) ) {
    unset($default_content['category']);
}

if( empty($settings['shopengine_is_rating']) ) {
    unset($default_content['rating']);
}

if (is_array($results)):
    global $product;
    $copy_product = $product;

    ?>
        <div class="shopengine-best-selling-product view-<?php echo esc_attr($settings['shopengine_content_layout']) ?>" data-mode="<?php echo esc_attr($settings['shopengine_content_layout']) ?>">
        <?php 
            foreach ($results as $result):
                $product    = wc_get_product( $result->ID );
                ?>
                    <div class='shopengine-single-product-item'>
                        <?php
                            foreach($default_content as $key => $value){
                                $function   = '_product_' . $key;               
                                \ShopEngine\Utils\Helper::$function($settings, $product);
                            }
                        ?>
                    </div>
                <?php 
            endforeach;
        ?>
        </div>
    <?php 
    
    $product = $copy_product;
endif;