<?php

namespace ExclusiveAddons\Elementor;

use Elementor\Controls_Manager;

class Woo_Mini_cart_helper {

    public static function init() {
        add_filter( 'woocommerce_add_to_cart_fragments', array( __CLASS__, 'exad_cart_count_total_fragments'), 10, 1 );
	}

    public static function exad_cart_count_total_fragments( $fragments ) {

        $fragments['.exad-cart-items-count-number'] = '<span class="exad-cart-items-count-number">' . WC()->cart->get_cart_contents_count() .'</span>';
        $fragments['.exad-cart-items-heading-text'] = '<span class="exad-cart-items-heading-text">' . WC()->cart->get_cart_contents_count() .'</span>';
        $fragments['.exad-cart-items-count-price'] = '<span class="exad-cart-items-count-price">' . WC()->cart->get_cart_total() .'</span>';

        return $fragments;
    }


}

Woo_Mini_cart_helper::init();
