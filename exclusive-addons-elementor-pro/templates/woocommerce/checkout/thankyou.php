<?php 
/**
 * Thankyou page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/thankyou.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.7.0
 */

defined( 'ABSPATH' ) || exit;
global $post;

?>

<div class="woocommerce-order">
    <div id="product-<?php the_ID(); ?>" <?php post_class(); ?>>
	    <div class="exad-woo-template-builder thank-you-template">

        <?php
			/**
			 * Hook for product builder.
			 * exad_woocommerce_thankyou_content
			 *
			 * @hooked get_thankyou_content_elementor() - 5.
			 */
			do_action( 'exad_woocommerce_thankyou_content');
		?>

        </div>
    </div>
</div>
