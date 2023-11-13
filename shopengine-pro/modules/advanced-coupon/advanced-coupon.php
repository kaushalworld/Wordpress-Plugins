<?php

namespace ShopEngine_Pro\Modules\Advanced_Coupon;

use ShopEngine_Pro\Traits\Singleton;

class Advanced_Coupon
{
    use Singleton;

    const COUNTRY_KEY       = 'shopengine_coupon_country';
    const STATE_KEY         = 'shopengine_coupon_country_state';
    const PAYMENT_METHOD    = 'shopengine_coupon_payment_method';

    public function init()
    {
        new Route;
        if (is_admin()) {
            Backend::instance()->init();
        } else {
            new Frontend;
        }
        $this->register_taxonomy();
    }

    public function register_taxonomy()
    {
        $labels = [
            'name'              => _x('Coupon Identifier', 'taxonomy general name', 'shopengine-pro'),
            'singular_name'     => _x('Coupon Identifier', 'taxonomy singular name', 'shopengine-pro'),
            'search_items'      => __('Search Coupon Identifiers', 'shopengine-pro'),
            'all_items'         => __('All Coupon Identifiers', 'shopengine-pro'),
            'parent_item'       => null,
            'parent_item_colon' => null,
            'edit_item'         => __('Edit Coupon Identifier', 'shopengine-pro'),
            'update_item'       => __('Update Coupon Identifier', 'shopengine-pro'),
            'add_new_item'      => __('Add New Coupon Identifier', 'shopengine-pro'),
            'new_item_name'     => __('New Coupon Identifier', 'shopengine-pro'),
            'menu_name'         => __('Coupon Category', 'shopengine-pro')
        ];

        $args = [
            'labels'             => $labels,
            'description'        => __('Bulk Coupon', 'shopengine-pro'),
            'hierarchical'       => false,
            'public'             => false,
            'publicly_queryable' => false,
            'show_ui'            => true,
            'show_in_menu'       => false,
            'show_in_nav_menus'  => false,
            'show_tagcloud'      => false,
            'show_in_quick_edit' => false,
            'show_admin_column'  => true,
            'show_in_rest'       => false,
            'meta_box_cb'        => false
        ];
        register_taxonomy('shopengine_coupon_identifier', ['shop_coupon'], $args);
    }

    /**
     * @return mixed
     */
    public static function get_countries_with_states()
    {
        $countries_obj = new \WC_Countries();
        return $countries_obj->__get('states');
    }
}
