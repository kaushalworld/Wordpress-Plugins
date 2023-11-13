<?php

namespace WPRA\Integrations;

use WPRA\Shortcode;
use WPRA\Config;
use WPRA\Enqueue;

class Woo {

    public static function init() {
        return new self();
    }

    public function __construct() {
        add_action('init', [$this, 'registerHooks'], 90);
    }

    public function registerHooks() {
        $sgc_id = Config::$settings['woo_shortcode_id'];

        if (Config::$settings['woo_integration'] and $sgc_id > 0) {
            $hook = Config::$settings['woo_location'] == 'woocommerce_use_custom_hook'
                ? Config::$settings['woo_custom_product_hook']
                : Config::$settings['woo_location'];

            add_action('wp_head', function () use ($sgc_id) {
                global $post;
                if ($post->post_type != 'product') return;
                $options = Shortcode::getSgcDataBy('id', $sgc_id, ['options']);
                Enqueue::printStyle("sgc-$sgc_id", ".wpra-plugin-container[data-sgc_id=\"$sgc_id\"]", $options);
            });

            add_action($hook, function () use ($sgc_id) {
                global $post;
                $is_on = get_post_meta($post->ID, '_wpra_show_emojis', 'true');
                if ($is_on == 'false') return;
                echo do_shortcode("[wpreactions sgc_id='$sgc_id' bind_to_post='yes']");
            });
        }
    }
}