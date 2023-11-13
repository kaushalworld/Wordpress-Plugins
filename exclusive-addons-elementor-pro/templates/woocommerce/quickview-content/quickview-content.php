<?php
/**
 * The template for displaying product content in the quickview-product.php template
 *
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product;
// $post_thumbnail_id = $product->get_image_id();
// $attachment_ids = $product->get_gallery_image_ids();

$attachment_ids = $product->get_gallery_image_ids() ? $product->get_gallery_image_ids() : array();
if ( $product->get_image_id() ){
    $attachment_ids = array( 'exad_quick_thumbnail_id' => $product->get_image_id() ) + $attachment_ids;
}

// Placeholder image set
if( empty( $attachment_ids ) ){
    $attachment_ids = array( 'exad_quick_thumbnail_id' => get_option( 'woocommerce_placeholder_image', 0 ) );
}

?>
<div <?php wc_product_class(); ?>>

    <div class="exad-row-wrapper woocommerce">
        <div class="exad-col exad-col-2">
            <div class="exad-quick-view-img-wrapper product">
                <div class="exad-qwick-view-image exad-product-thumb-view-default">
                    <div class="exad-product-image">
                        <?php 

                        // add_action( 'exad_woo_single_product_image', 'woocommerce_show_product_images', 20 );
                        //do_action( 'exad_woo_single_product_image' );
                            wc_get_template( 'single-product/product-image.php' );
                            // On render widget from Editor - trigger the init manually.
                            if ( wp_doing_ajax() ) {
                                ?>
                                <script>
                                    jQuery( '.woocommerce-product-gallery' ).each( function() {
                                        jQuery( this ).wc_product_gallery();
                                    } );
                                </script>
                                <?php
                            }

                        //   if ( $attachment_ids ) {
                        //     $i = 0;
                        //     foreach ( $attachment_ids as $attachment_id ) {
                        //         $i++;

                        //         $html = wc_get_gallery_image_html( $attachment_id, true );

                        //         if( $i == 1 ){
                        //             echo '<div class="exad-quickview-first-image">'.apply_filters( 'woocommerce_single_product_image_thumbnail_html', $html, $attachment_id ).'</div>';
                        //         }else{
                        //             echo '<div class="exad-quick-view-thumbnails">'.apply_filters( 'woocommerce_single_product_image_thumbnail_html', $html, $attachment_id ).'</div>';
                        //         }

                        //     }
                        // }
                    
                        ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="exad-col exad-col-2">
            <div class="qwick-view-content">
                <?php do_action( 'exad_quickview_before_summary' ); ?>
                <div class="content-exadquickview entry-summary">
                    <?php
                        add_action( 'exad_quickview_content', 'woocommerce_template_single_title', 5 );
                        add_action( 'exad_quickview_content', 'woocommerce_template_single_rating', 10 );
                        add_action( 'exad_quickview_content', 'woocommerce_template_single_price', 10 );
                        add_action( 'exad_quickview_content', 'woocommerce_template_single_excerpt', 20 );
                        add_action( 'exad_quickview_content', 'woocommerce_template_single_add_to_cart', 30 );
                        add_action( 'exad_quickview_content', 'woocommerce_template_single_meta', 40 );
                        add_action( 'exad_quickview_content', 'woocommerce_template_single_sharing', 50 );
                       

                        // Render Content
                        do_action( 'exad_quickview_content' );
                    ?>
                </div><!-- .summary -->
                <?php do_action( 'exad_quickview_after_summary' ); ?>
            </div>
        </div>
    </div>
</div>	
