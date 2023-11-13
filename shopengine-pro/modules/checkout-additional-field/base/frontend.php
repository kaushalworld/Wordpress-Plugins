<?php

namespace ShopEngine_Pro\Modules\Checkout_Additional_Field\Base;

use ShopEngine_Pro\Modules\Checkout_Additional_Field\Checkout_Additional_Field;
use ShopEngine_Pro\Traits\Singleton;

class Frontend {

    use Singleton;

    private $settings;

    public function init($settings) {
        $this->settings = $settings;
        add_filter('woocommerce_billing_fields', [$this, 'billing_field_show_checkout_page'], 20);
        add_filter('woocommerce_shipping_fields', [$this, 'shipping_field_show_checkout_page']);
        add_action('woocommerce_checkout_update_order_meta', [$this, 'additional_field_data_save_frontend']);
        add_filter('woocommerce_checkout_fields', [$this, 'additional_field_show_checkout_field']);
        add_filter('shopengine_order_notes', [$this, 'order_note_show_checkout_page'], 10, 2);
    }

    public function order_note_show_checkout_page($notes, $order) {
        $order_id = $order->get_id();
        $fields = get_post_meta($order_id, '_shopengine_additional__fields', true);
        if(empty($fields)) {
            return $notes;
        }
        $fields = unserialize($fields);
        $updated_field = [];
        foreach ($fields as $key => $value) {
            if(!empty($value['position'])) {
                $name = Checkout_Additional_Field::make_useable_input_name($value['name']);
                $updated_field[$name] = [
                    'label' => $value['label'],
                    'value' => get_post_meta($order_id, $name, true)
                ];
                unset($fields[$key]);
            }
        }
        if(!empty($notes)) {
            $updated_field['order_comments'] = $notes['order_comments'];
        }
        foreach ($fields as $key => $value) {
            $name = Checkout_Additional_Field::make_useable_input_name($value['name']);
            $updated_field[$name] = [
                'label' => $value['label'],
                'value' => get_post_meta($order_id, $name, true)
            ];
        }
        
        return $updated_field;
    }

    public function additional_field_show_checkout_field($additional_fields) {

        $updated_field = [];
        $additional = $this->settings['additional']['value'];
        foreach ($additional as $key => $value) {
            if(!empty($value['position'])) {
                $name = Checkout_Additional_Field::make_useable_input_name($value['name']);
                $value = $this->explode_radio_input($value);
                $updated_field[$name] = $value;
                $updated_field[$name]['class'][] = $value['custom_css_class'];
                unset($additional[$key]);
            }
        }
        $updated_field['order_comments'] = $additional_fields['order']['order_comments'];
        foreach ($additional as $key => $value) {
            $name = Checkout_Additional_Field::make_useable_input_name($value['name']);
            $value = $this->explode_radio_input($value);
            $updated_field[$name] = $value;
            $updated_field[$name]['class'][] = $value['custom_css_class'];
        }
        $additional_fields['order'] = $updated_field;
        return $additional_fields;
    }

    public function additional_field_data_save_frontend($order_id) {
        if(isset($_REQUEST['woocommerce-process-checkout-nonce']) && wp_verify_nonce( sanitize_text_field(wp_unslash($_REQUEST['woocommerce-process-checkout-nonce'])), 'woocommerce-process_checkout' )){
            Checkout_Additional_Field::save_field_keys($this->settings, $order_id);
            foreach ($_POST as $key => $value) {
                if (strpos($key, 'shopengine') !== false) {
                    update_post_meta($order_id, $key, $value);
                }
            }
        }
    }

    public function additional_field($additional_field) {
        return $this->input_fields($additional_field, 'additional_field');
    }

    public function billing_field_show_checkout_page($billing_fields) {
        return $this->input_fields($billing_fields, 'billing');
    }

    public function shipping_field_show_checkout_page($shipping_fields) {
        return $this->input_fields($shipping_fields, 'shipping');
    }

    private function input_fields($fields, $form_type) {

        foreach ($this->settings[$form_type]['value'] as $value) {
            if (isset($value['position']) && isset($fields[$value['position']]['priority'])) {
                $priority = $fields[$value['position']]['priority'];
                $value['priority'] = $priority + 1;
            }
            if(!empty($value['label'])) {
                $value['label'] = shopengine_pro_translator('checkout-additional-field__'.$form_type.'__label__'.$value['_uid'], $value['label']);
            }

            if(!empty($value['placeholder'])) {
                $value['placeholder'] = shopengine_pro_translator('checkout-additional-field__'.$form_type.'__placeholder__'.$value['_uid'], $value['placeholder']);
            }
            
            $value = $this->explode_radio_input($value);

            $name = Checkout_Additional_Field::make_useable_input_name($value['name']);
            $fields[$name] = $value;
            $fields[$name]['class'][] = 'shopengine-checkout-additional-'.$value['type'].' '.$value['custom_css_class'];
        }
        return $fields;
    }

    private function explode_radio_input($value)
    {
        if ($value['type'] === 'radio') {
            $options = [];
            $opt     = explode(',', $value['options']);
            if (is_array($opt)) {
                foreach ($opt as $option) {
                    $val = explode('=', $option);
                    if (is_array($val) && isset($val[1])) {
                        $options[$val[0]] = $val[1];
                    }
                }
                $value['options'] = $options;
            }
        } else if ($value['type'] === 'select') {
            $options = [];
            $opt     = explode(',', preg_replace("/((\r?\n)|(\r\n?))/", ',',$value['select_options']));
            if (is_array($opt)) {
                foreach ($opt as $option) {
                    if (strstr( $option, '::' ) ) {
                        $val = explode('::', $option);
                        if (is_array($val) && isset($val[1])) {
                            $options[trim($val[0])] = trim($val[1]);
                        }
                    } else {
                        $options[trim($option)] = $option;
                    }
                }
                $value['options'] = $options;
            }
        }
        
        return $value;
    }
}