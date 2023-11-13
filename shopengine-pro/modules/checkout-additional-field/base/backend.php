<?php

namespace ShopEngine_Pro\Modules\Checkout_Additional_Field\Base;

use ShopEngine_Pro\Modules\Checkout_Additional_Field\Checkout_Additional_Field;
use ShopEngine_Pro\Traits\Singleton;

class Backend {

    use Singleton;

	private $settings;

    public function init($settings) {
		$this->settings = $settings;
		add_action('wp_ajax_checkout_billing_fields', [$this, 'get_checkout_billing_fields']);
		add_action('wp_ajax_checkout_shipping_fields', [$this, 'get_checkout_shipping_fields']);
        add_action('woocommerce_process_shop_order_meta', [$this, 'additional_field_data_save_backend']);
        add_action('woocommerce_admin_order_data_after_billing_address', [$this, 'admin_billing_order_details']);
        add_action('woocommerce_admin_order_data_after_shipping_address', [$this, 'admin_shipping_order_details']);
        add_action('woocommerce_admin_order_data_after_order_details', [$this, 'admin_additional_order_details']);
    }

    public function get_checkout_billing_fields() {
        $this->get_checkout_fields('billing');
    }
    
    public function get_checkout_shipping_fields() {
        $this->get_checkout_fields('shipping');
    }

	public function get_checkout_fields($type) {
        $fields = WC()->checkout->get_checkout_fields();
        $fields_list = [];

        foreach ($fields[$type] as $key => $value) {
            $fields_list[$key] = $value['label'];
        }

        $response = [
            'status'  => 'success',
            'result'  => $fields_list,
            'message' => esc_html__('checkout fields fetched', 'shopengine-pro'),
        ];
        header('Content-type: application/json');
        echo json_encode($response);
        exit;
    }

	public function additional_field_data_save_backend($order_id) {

        if (isset($_REQUEST['post_type']) && $_REQUEST['post_type'] === 'shop_order' && isset($_REQUEST['meta-box-order-nonce']) && wp_verify_nonce(sanitize_text_field(wp_unslash($_REQUEST['meta-box-order-nonce'])),'meta-box-order')) {
			Checkout_Additional_Field::save_field_keys($this->settings, $order_id);

        }
        foreach ($_POST as $key => $value) {
            if (strpos($key, 'shopengine') !== false) {
                update_post_meta($order_id, $key, $value);
            }
        }
    }

	public function admin_billing_order_details($order) {
        $this->order_details($order, 'billing');
    }

    public function admin_shipping_order_details($order) {
        $this->order_details($order, 'shipping');
    }

    public function admin_additional_order_details($order) {
        $this->order_details($order, '');
    }

    private function order_details($order, $type) {
        //phpcs:ignore WordPress.Security.NonceVerification
        if (isset($_GET['post_type']) && $_GET['post_type'] === 'shop_order') {
            $fields = isset($this->settings[$type]['value']) ? $this->settings[$type]['value'] : '';
            $order_id = 0;
        } else {
            $order_id = $order->get_id();
            $fields = get_post_meta($order_id, '_shopengine_additional_' . $type . '_fields', true);
            $fields = unserialize($fields);
        }
        if (!empty($fields)):
        ?>
        <br class="clear" />
        <?php if ($type === 'billing'): ?>
		    <h4><?php esc_attr_e('Additional billing fields created from the shopengine', 'shopengine-pro')?><a title="<?php esc_html_e('Edit Billing Address', 'shopengine-pro')?>" href="#" class="edit_address"></a></h4>
        <?php else: ?>
		<h4><?php esc_attr_e('Additional shipping fields created from the shopengine', 'shopengine-pro')?><a title="<?php esc_html_e('Edit Shipping Address', 'shopengine-pro')?>" href="#" class="edit_address"></a></h4>
        <?php endif;?>
		<div class="address">
	    <?php
            foreach ($fields as $value) {
                $name = Checkout_Additional_Field::make_useable_input_name($value['name']);
                echo wp_kses( "<p><strong>{$value['label']}</strong>" . get_post_meta($order_id, $name, true) . "</p>", \ShopEngine\Utils\Helper::get_kses_array());
            }
        ?>
		</div>
		<div class="edit_address">
        <?php
            foreach ($fields as $value) {
                $name = Checkout_Additional_Field::make_useable_input_name($value['name']);
                $args = [
                    'id'            => $name,
                    'label'         => $value['label'],
                    'value'         => get_post_meta($order_id, $name, true),
                    'placeholder'   => $value['placeholder'],
                    'wrapper_class' => 'form-field-wide',
                    'type'          => $value['type']
                ];

                if($value['type'] === 'checkbox') {
                    $args['style'] = 'width:0';
                }

                switch ($value['type']) {
                case 'textarea':
                    woocommerce_wp_textarea_input($args);
                    break;
                case 'radio':
                    $options = [];
                    $opt = explode(',', $value['options']);

                    if(is_array($opt)) {
                        foreach($opt as $option) {
                            $val = explode('=', $option);
                            if(is_array($val) && isset($val[1])) {
                                $options[$val[0]] = $val[1];
                            }
                        }
                    }
                    $args['options'] = $options;
                    
                    woocommerce_wp_radio($args);
                    break;

                case 'select':
                    $options = [];
                    $opt = explode(',', preg_replace("/((\r?\n)|(\r\n?))/", ',',$value['select_options']));

                    if(is_array($opt)) {
                        foreach($opt as $option) {
                            if (strstr( $option, '::' ) ) {
                                $val = explode('::', $option);
                                if (is_array($val) && isset($val[1])) {
                                    $options[trim($val[0])] = trim($val[1]);
                                }
                            } else {
                                $options[trim($option)] = $option;
                            }
                        }
                    }
                    $args['select_options'] = $options;

                    woocommerce_wp_select($args);
                break;
                default:
                    woocommerce_wp_text_input($args);
                    break;
                }
            }
        ?>
        </div>
	    <?php
endif;
    }
}