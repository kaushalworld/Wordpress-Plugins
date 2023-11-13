<?php

namespace ShopEngine_Pro\Modules\Advanced_Coupon;

use ShopEngine_Pro\Traits\Singleton;

class Frontend
{
    use Singleton;

    /**
     * @var mixed
     */
    public $first_coupon_id;

    public function __construct()
    {
        add_action('woocommerce_applied_coupon', [$this, 'coupon_validation']);

        add_action('woocommerce_before_checkout_process', [$this, 'before_checkout_process']);

        add_action('woocommerce_checkout_update_order_review', [$this, 'before_checkout_process']);

        add_filter('woocommerce_available_payment_gateways', [$this, 'payment_gateways']);
    }

    /**
     * @param $coupon
     */
    public function coupon_validation($coupon)
    {
        $woocommerce      = WC();
        $shipping_address = $woocommerce->customer->get_shipping();
        $wc_coupon        = new \WC_Coupon($coupon);
        $country          = get_post_meta($wc_coupon->get_id(), Advanced_Coupon::COUNTRY_KEY, true);

        /**
         * Check coupon allowed shipping address
         */
        if (!empty($country)) {

            $states = get_post_meta($wc_coupon->get_id(), Advanced_Coupon::STATE_KEY, true);
            $states = json_decode($states);

            if ($shipping_address['country'] != $country) {

                WC()->cart->remove_coupon($coupon);
                wc_clear_notices();
                wc_add_notice($this->get_coupon_error_message($coupon, $country, $states), 'error');

            } else {
                if (!empty($states)) {
                    if (!in_array($shipping_address['state'], $states)) {
                        WC()->cart->remove_coupon($coupon);
                        wc_clear_notices();
                        wc_add_notice($this->get_coupon_error_message($coupon, $country, $states), 'error');
                    }
                }
            }
        }
    }

    public function before_checkout_process()
    {
        $woocommerce      = WC();
        $shipping_address = $woocommerce->customer->get_shipping();
        //phpcs:disable WordPress.Security.NonceVerification
        if (isset($_POST['s_state'])) {
            $shipping_address['state'] = sanitize_text_field(wp_unslash($_POST['s_state']));
        }
        //phpcs:enable
        foreach ($woocommerce->cart->applied_coupons as $coupon) {
            $wc_coupon = new \WC_Coupon($coupon);
            $country   = get_post_meta($wc_coupon->get_id(), Advanced_Coupon::COUNTRY_KEY, true);

            if (!empty($country)) {

                $states = get_post_meta($wc_coupon->get_id(), Advanced_Coupon::STATE_KEY, true);
                $states = json_decode($states);

                if ($shipping_address['country'] != $country) {

                    WC()->cart->remove_coupon($coupon);
                    wc_clear_notices();
                    wc_add_notice($this->get_coupon_error_message($coupon, $country, $states), 'error');

                } else {
                    if (!empty($states)) {
                        if (!in_array($shipping_address['state'], $states)) {
                            WC()->cart->remove_coupon($coupon);
                            wc_clear_notices();
                            wc_add_notice($this->get_coupon_error_message($coupon, $country, $states), 'error');
                        }
                    }
                }
            }
        }
    }

    /**
     * @param $gateways
     * @return mixed
     */
    public function payment_gateways( $gateways )
    {
        global $woocommerce;
        if ( !empty( $woocommerce->cart->applied_coupons ) ) {
            foreach ( $woocommerce->cart->applied_coupons as $coupon ) {
                $wc_coupon                 = new \WC_Coupon( $coupon );
                $disabled_payment_gateways = get_post_meta( $wc_coupon->get_id(), Advanced_Coupon::PAYMENT_METHOD, true );

                if ( !empty( $disabled_payment_gateways ) ) {
                    foreach ( json_decode( $disabled_payment_gateways ) as $gateway ) {
                        if ( isset( $gateways[$gateway] ) ) {
                            unset( $gateways[$gateway] );
                        }
                    }
                }
            }
        }

        return $gateways;
    }

    /**
     * @param $coupon
     * @param $country
     * @param $states
     * @return mixed
     */
    public function get_coupon_error_message($coupon, $country, $states)
    {
        $countries_obj  = new \WC_Countries();
        $countries      = $countries_obj->__get('countries');
        $country_states = Advanced_Coupon::get_countries_with_states();
        $states         = array_combine($states, $states);

        if (isset($country_states[$country])) {
            $states_name = array_intersect_key($country_states[$country], $states);
        } else {
            $states_name = [];
        }

        $message = esc_html__('You can use the ', 'shopengine-pro') . '<b>' . $coupon . '</b>' . esc_html__(' coupon only for ', 'shopengine-pro');

        if (!empty($states_name)) {
            $message .= implode(', ', $states_name) . esc_html__(' states in ', 'shopengine-pro');
        }

        $message .= $countries[$country] . esc_html__(' (Shipping Address).', 'shopengine-pro');

        return $message;
    }
}
