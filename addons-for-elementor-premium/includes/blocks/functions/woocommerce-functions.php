<?php

add_action('wp_ajax_lae_product_quick_view', 'lae_product_quick_view_callback');
add_action('wp_ajax_nopriv_lae_product_quick_view', 'lae_product_quick_view_callback');

add_action('wp_ajax_lae_add_cart_single_product', 'lae_add_cart_single_product_callback');
add_action('wp_ajax_nopriv_lae_add_cart_single_product', 'lae_add_cart_single_product_callback');


function lae_product_quick_view_callback() {

    if (!isset($_REQUEST['product_id'])) {
        die();
    }

    $product_id = intval($_REQUEST['product_id']);

    // wp_query for the product.
    wp('p=' . $product_id . '&post_type=product');

    ob_start();

    while (have_posts()) : the_post(); ?>

        <div id="lae-qv-content" class="woocommerce single-product">
            <div id="product-<?php the_ID(); ?>" <?php post_class('product'); ?>>
                <?php woocommerce_show_product_sale_flash(); ?>
                <?php lae_quick_view_thumbnail(); ?>
                <div class="summary entry-summary">
                    <div class="summary-content">
                        <?php lae_woo_quick_view_product_content(); ?>
                    </div>
                </div>
            </div>
        </div>

    <?php
    endwhile;

    $output = ob_get_clean();

    echo apply_filters('lae_product_quick_view', $output);

    die();
}

function lae_woo_quick_view_product_content() {

    ob_start();

    woocommerce_template_single_title();

    woocommerce_template_single_rating();

    woocommerce_template_single_price();

    woocommerce_template_single_excerpt();

    // Quantity & Add to cart button
    woocommerce_template_single_add_to_cart();

    woocommerce_template_single_meta();

    $output = ob_get_clean();

    echo apply_filters('lae_product_quick_view_content', $output);

}

function lae_quick_view_thumbnail() {

    global $post, $product, $woocommerce;

    ob_start();

    ?>

    <div class="lae-qv-images images">
        <ul class="lae-qv-slides">
            <?php
            if (has_post_thumbnail()) {
                $attachment_ids = $product->get_gallery_image_ids();
                $props = wc_get_product_attachment_props(get_post_thumbnail_id(), $post);
                $image = get_the_post_thumbnail(
                    $post->ID, 'shop_single', array(
                        'title' => $props['title'],
                        'alt' => $props['alt'],
                    )
                );
                echo
                sprintf(
                    '<li class="%s">%s</li>',
                    'woocommerce-product-gallery__image',
                    $image
                );

                if ($attachment_ids) {
                    $loop = 0;

                    foreach ($attachment_ids as $attachment_id) {

                        $props = wc_get_product_attachment_props($attachment_id, $post);

                        if (!$props['url']) {
                            continue;
                        }

                        echo
                        sprintf(
                            '<li class="%s">%s</li>',
                            'woocommerce-product-gallery__image',
                            wp_get_attachment_image($attachment_id, 'shop_single', 0, $props)
                        );

                        $loop++;
                    }
                }
            }
            else {
                echo sprintf('<li><img src="%s" alt="%s" /></li>', wc_placeholder_img_src(), __('Placeholder', 'livemesh-el-addons'));
            } ?>
        </ul>
    </div>

    <?php

    $output = ob_get_clean();

    echo apply_filters('lae_quick_view_image', $output);
}

function lae_add_cart_single_product_callback() {

    $product_id = sanitize_text_field($_REQUEST['product_id']);
    $variation_id = sanitize_text_field($_REQUEST['variation_id']);
    $variation = $_REQUEST['variation'];
    $quantity = sanitize_text_field($_REQUEST['quantity']);

    if ($variation_id) {
        WC()->cart->add_to_cart($product_id, $quantity, $variation_id, $variation);
    }
    else {
        WC()->cart->add_to_cart($product_id, $quantity);
    }
    die();

}
