<?php

namespace ShopEngine_Pro\Modules\Checkout_Additional_Field;

use Shopengine\Core\Register\Module_List;
use ShopEngine_Pro\Modules\Checkout_Additional_Field\Base\Backend;
use ShopEngine_Pro\Modules\Checkout_Additional_Field\Base\Frontend;
use ShopEngine_Pro\Traits\Singleton;

class Checkout_Additional_Field {

    use Singleton;

    private $settings;
    private $billing_input_fields;
    private $shipping_input_fields;

    public function init() {

        $this->settings = Module_List::instance()->get_settings('checkout-additional-field');
        if (is_admin()) {
            Backend::instance()->init($this->settings);
        } else {
            Frontend::instance()->init($this->settings);
        }
        $view = true;
        if (is_admin()) {
            //phpcs:ignore WordPress.Security.NonceVerification
            if (empty($_POST['wc_order_action'])) {
                $view = false;
            }
        }
        if ($view === true) {
            add_filter('woocommerce_order_get_formatted_shipping_address', [$this, 'show_shipping_address'], 10, 3);
            add_filter('woocommerce_order_get_formatted_billing_address', [$this, 'show_billing_address'], 10, 3);
        }
        add_action('woocommerce_email_order_meta', [$this, 'email_order_meta']);
    }

    public function email_order_meta($order) {
        $values = [];
        $fields = get_post_meta($order->get_id(), '_shopengine_additional__fields', true);
        if(!empty($fields)) {
            $fields = unserialize($fields);
            foreach ($fields as $field) {
                $name = Checkout_Additional_Field::make_useable_input_name($field['name']);
                $value = get_post_meta($order->get_id(), $name, true);
                $values[] = $field['label'] . ': ' . $value;
            }

            if (count($values) > 0) {
                echo '<div class="inspire_checkout_fields_additional_information">';
                echo '<h3>' . esc_html__('Additional Information', 'shopengine-pro') . '</h3>';
                echo wp_kses( '<p>' . implode('<br />', $values) . '</p>', \ShopEngine_Pro\Util\Helper::get_kses_array());
                echo '</div>';
            }
        }
    }

    public function show_billing_address($address, $raw_address, $order) {
        return $this->address($raw_address, 'billing', $order);
    }

    public function show_shipping_address($address, $raw_address, $order) {
        return $this->address($raw_address, 'shipping', $order);
    }

    public function address($raw_address, $type, $order) {
        $order_id = $order->get_id();
        $fields_store = $type . '_input_fields';
        $this->{$fields_store} = unserialize(get_post_meta($order_id, '_shopengine_additional_' . $type . '_fields', true));
        $updated_address = '';
        foreach ($raw_address as $key => $value) {
            if ($key !== 'email' && $key !== 'phone') {
                if (!empty($value)) {
                    if ($key === 'country') {
                        $updated_address .= WC()->countries->countries[$value] . '<br>';
                    } else {
                        $updated_address .= $value . '<br>';
                    }
                }
            }
            $fields = $this->form_field_exists($key, $fields_store, $order_id);
            if (!empty($fields)) {
                foreach ($fields as $field) {
                    $updated_address .= $field . '<br>';
                }
            }
        }

        if (!empty($this->{$fields_store})) {
            foreach ($this->{$fields_store} as $k => $value) {
                $name = Checkout_Additional_Field::make_useable_input_name($value['name']);
                $updated_address .= get_post_meta($order_id, $name, true);
            }
        }

        return $updated_address;
    }

    public function form_field_exists($key, $fields_store, $order_id) {
        $arg = [];
        if(is_array($this->{$fields_store})) {
            foreach ($this->{$fields_store} as $k => $value) {
                if ($value['position'] === 'billing_' . $key) {
                    $name = Checkout_Additional_Field::make_useable_input_name($value['name']);
                    $arg[] = get_post_meta($order_id, $name, true);
                    unset($this->{$fields_store}[$k]);
                }
            }
        }
        return $arg;
    }

    public static function make_useable_input_name($name) {
        $name = str_replace(" ", "_", $name);
        return '_shopengine_' . $name;
    }

    public static function save_field_keys($settings, $order_id) {
        $billing_fields = $settings['billing']['value'];
        $shipping_fields = $settings['shipping']['value'];
        $additional_fields = $settings['additional']['value'];
        update_post_meta($order_id, '_shopengine_additional_billing_fields', serialize($billing_fields));
        update_post_meta($order_id, '_shopengine_additional_shipping_fields', serialize($shipping_fields));
        update_post_meta($order_id, '_shopengine_additional__fields', serialize($additional_fields));
    }
}
