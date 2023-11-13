<?php

namespace ShopEngine_Pro\Modules\Advanced_Coupon;

use ShopEngine_Pro\Traits\Singleton;
use WC_Meta_Box_Coupon_Data;

class Backend
{
    use Singleton;

    /**
     * @var mixed
     */
    public $first_coupon_id;

    /**
     * @return mixed
     */
    public function init()
    {
        add_action('current_screen', function ($screen) {
            
            if ($screen->post_type === 'shop_coupon') {
                add_action('woocommerce_update_coupon', [$this, 'save_data']);
                add_action('woocommerce_coupon_options_usage_restriction', [$this, 'setting_inputs']);
                add_action('admin_enqueue_scripts', [$this, 'admin_scripts']);
                add_action('restrict_manage_posts', [$this, 'filter'], 10, 2);
                add_action('woocommerce_coupon_options_save', [$this, 'coupon_options_save'], 99999, 2);
                add_filter('manage_shop_coupon_posts_custom_column', [$this, 'coupon_table_custom_column'], 100, 2);
                add_filter('manage_shop_coupon_posts_columns', [$this, 'coupon_table_custom_column_content'], 100);

                if($screen->action === 'add') {
                    add_action("add_meta_boxes", function () {
                        add_meta_box('shopengine-coupon-data', esc_html__('ShopEngine Bulk Coupon', 'shopengine-pro'), [$this, 'coupon_meta_box'], 'shop_coupon', 'normal', 'high');
                    });
                }
            }
        });   
    }

    public function coupon_options_save($coupon_id, $coupon)
    {
        if(!isset($_POST['_wpnonce']) || !isset($_POST['post_ID']) || !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['_wpnonce'])),'update-post_'.sanitize_text_field(wp_unslash($_POST['post_ID'])))){
			return;
		}
        if (empty($_POST['shopengine_bulk_coupon_status']) || $_POST['shopengine_bulk_coupon_status'] != 'yes') {
            return;
        }
        if (!$this->first_coupon_id) {
            $this->first_coupon_id = $coupon_id;
            $this->create_bulk_coupon();
            $coupon->delete(true);
            wp_safe_redirect(admin_url('edit.php?post_type=shop_coupon'));
            exit();
        }
    }

    public function coupon_table_custom_column($column_name, $post_id) {
        if ($column_name == 'shopengine_coupon_identifier') {
            $term_list = get_the_terms($post_id, 'shopengine_coupon_identifier');
            if (!empty($term_list[0])) {
                echo esc_html($term_list[0]->name);
            }
        }
    }

    public function coupon_table_custom_column_content($columns) {
        $column = ['shopengine_coupon_identifier' => esc_html__('Identifier', 'shopengine-pro')];
        array_splice($columns, 3, 0, $column);
        return $columns;
    }

    public function filter($post_type)
    {
        if('shop_coupon' !== $post_type) {
            return;
        }

        $taxonomy_slug = 'shopengine_coupon_identifier';
        $selected      = '';
        // phpcs:disable WordPress.Security.NonceVerification
        if (isset($_GET[$taxonomy_slug])) {
            $selected = sanitize_text_field(wp_unslash($_GET[$taxonomy_slug]));
        }
        // phpcs:enable
        wp_dropdown_categories([
            'show_option_all' => "Show All Identifier",
            'taxonomy'        => $taxonomy_slug,
            'name'            => $taxonomy_slug,
            'orderby'         => 'name',
            'selected'        => $selected,
            'hierarchical'    => false,
            'show_count'      => true,
            'hide_empty'      => false,
            'value_field'     => 'slug'
        ]);
        ?>
        <button class="button shopengine-export-coupon" type="button"> <?php esc_html_e('Export', 'shopengine-pro'); ?>  </button>
        <a title="<?php esc_attr_e('Coupon Identifiers', 'shopengine-pro')?>" class="button-primary" href="<?php echo esc_url(admin_url('edit-tags.php?taxonomy=shopengine_coupon_identifier&post_type=shop_coupon'))?>"><?php esc_html_e('Coupon Identifiers', 'shopengine-pro')?></a>
        <?php
    }

    public function create_bulk_coupon()
    {   if(isset($_POST['shopengine_number_of_digit']) 
        && isset($_POST['shopengine_coupon_prefix']) 
        && isset($_POST['shopengine_coupon_suffix']) 
        && isset($_POST['shopengine_coupon_length']) 
        && isset($_POST['excerpt']) 
        && isset($_POST['shopengine_coupon_identifier']) 
        && isset($_POST['_wpnonce'])
        && isset($_POST['post_ID'])
        && wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['_wpnonce'])),'update-post_'.sanitize_text_field(wp_unslash($_POST['post_ID'])))
        ){
        $new_coupon = [
            'post_content' => '',
            'post_status'  => 'publish',
            'post_author'  => get_current_user_id(),
            'post_type'    => 'shop_coupon',
            'post_excerpt' => sanitize_text_field(wp_unslash($_POST['excerpt']))
        ];
  
        $number_of_coupon     = (int) $_POST['shopengine_number_of_digit'];
        $prefix_suffix_length = strlen(sanitize_text_field(wp_unslash($_POST['shopengine_coupon_prefix']))) + strlen(sanitize_text_field(wp_unslash($_POST['shopengine_coupon_suffix'])));
        $coupon_length        = (int) $_POST['shopengine_coupon_length'] - $prefix_suffix_length;

        for ($i = 0; $i < $number_of_coupon; $i++) {
            $new_coupon['post_title'] = sanitize_text_field(wp_unslash($_POST['shopengine_coupon_prefix'])) . $this->generate_coupon_name($coupon_length) . sanitize_text_field(wp_unslash($_POST['shopengine_coupon_suffix']));
            $id                       = wp_insert_post($new_coupon, true);
            $post                     = get_post($id);

            WC_Meta_Box_Coupon_Data::save($id, $post);
            wp_set_object_terms($id, sanitize_text_field(wp_unslash($_POST['shopengine_coupon_identifier'])), 'shopengine_coupon_identifier');
        }
    }
    }

    /**
     * @param $coupon_id
     */
    public function save_data($coupon_id)
    {
        if(!isset($_POST['_wpnonce']) || !isset($_POST['post_ID']) || !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['_wpnonce'])),'update-post_'.sanitize_text_field(wp_unslash($_POST['post_ID'])))){
			return;
		}
        if (!empty($_POST[Advanced_Coupon::COUNTRY_KEY])) {
            update_post_meta($coupon_id, Advanced_Coupon::COUNTRY_KEY, sanitize_text_field(wp_unslash($_POST[Advanced_Coupon::COUNTRY_KEY])));

            if (!empty($_POST[Advanced_Coupon::STATE_KEY])) {
                update_post_meta($coupon_id, Advanced_Coupon::STATE_KEY, json_encode(sanitize_text_field(wp_unslash($_POST[Advanced_Coupon::STATE_KEY]))));
            } else {
                update_post_meta($coupon_id, Advanced_Coupon::STATE_KEY, json_encode([]));
            }
        }

        if (!empty($_POST[Advanced_Coupon::PAYMENT_METHOD])) {

            $payment_methods = map_deep( wp_unslash( $_POST[Advanced_Coupon::PAYMENT_METHOD] ), 'sanitize_text_field' );

            update_post_meta($coupon_id, Advanced_Coupon::PAYMENT_METHOD, json_encode($payment_methods));
        }
    }

    
	/**
     * @param $coupon_id
     */
    public function setting_inputs($coupon_id)
    {
        $selected_country          = get_post_meta($coupon_id, Advanced_Coupon::COUNTRY_KEY, true);
        $selected_state            = get_post_meta($coupon_id, Advanced_Coupon::STATE_KEY, true);
        $countries_obj             = new \WC_Countries();
        $countries                 = $countries_obj->__get('countries');
        $selected_payment_gateways = get_post_meta($coupon_id, Advanced_Coupon::PAYMENT_METHOD, true);

        ?>
        <div class="options_group">
            <p class="form-field">
            <label id="<?php echo esc_attr(Advanced_Coupon::COUNTRY_KEY)?>"><?php echo esc_html__('Allowed - Country (optional)', 'shopengine-pro')?></label>
            <select class="shopengine_coupon_country" style="width:50%" name="<?php echo esc_attr(Advanced_Coupon::COUNTRY_KEY)?>" id="<?php echo esc_attr(Advanced_Coupon::COUNTRY_KEY)?>" data-selected="<?php echo esc_attr($selected_country)?>">
                <?php foreach($countries as $key => $country):?>
                <option value="<?php echo esc_attr($key)?>" <?php selected($selected_country, $key)?>><?php echo esc_html($country)?></option>
                <?php endforeach;?>
            </select>
            </p>
        </div>
        <div class="options_group">
            <p class="form-field">
            <label id="<?php echo esc_attr(Advanced_Coupon::STATE_KEY)?>"><?php echo esc_html__('Allowed - State (optional)', 'shopengine-pro')?></label>
            <select class="shopengine_coupon_country_state" style="width:50%" name="<?php echo esc_attr(Advanced_Coupon::STATE_KEY)?>[]" id="<?php echo esc_attr(Advanced_Coupon::STATE_KEY)?>" data-selected='<?php echo esc_attr($selected_state)?>'></select>
            </p>
        </div>
        <div class="options_group">
            <p class="form-field">
            <label id="<?php echo esc_attr(Advanced_Coupon::PAYMENT_METHOD)?>"><?php esc_html_e('Disable payment methods (optional)', 'shopengine-pro')?></label>
            <select class="<?php echo esc_attr(Advanced_Coupon::PAYMENT_METHOD)?>" style="width:50%" name="<?php echo esc_attr(Advanced_Coupon::PAYMENT_METHOD)?>[]" id="<?php echo esc_attr(Advanced_Coupon::PAYMENT_METHOD)?>" data-selected='<?php echo esc_attr($selected_payment_gateways)?>'></select>
            </p>
        </div>
        <?php
    }

	public static function coupon_meta_box()
    {
        woocommerce_wp_checkbox(
            [
                'id'    => 'shopengine_bulk_coupon_status',
                'type'  => 'checkbox',
                'class' => 'shopengine_bulk_coupon_status',
                'label' => __('Enable Bulk Coupon', 'shopengine-pro')
            ]
        );
        
        ?>
         <div style="display:none" class="shopengine_bulk_coupon">
        <?php
        
        woocommerce_wp_text_input(
            [
                'id'                => 'shopengine_number_of_digit',
                'label'             => esc_html__('Number of Coupon', 'shopengine-pro'),
                'type'              => 'number',
                'style'             => 'width: 250px;',
            ]
        );
        woocommerce_wp_text_input(
            [
                'id'                => 'shopengine_coupon_length',
                'label'             => esc_html__('Coupon length', 'shopengine-pro'),
                'type'              => 'number',
                'style'             => 'width: 250px;',
                'value'             => 10
            ]
        );
        woocommerce_wp_text_input(
            [
                'id'                => 'shopengine_coupon_prefix',
                'label'             => esc_html__('Prefix', 'shopengine-pro'),
                'style'             => 'width: 250px;float:left;',
                'description'       => esc_html__('Text/characters to be added before each coupon name', 'shopengine-pro'),
                'desc_tip'          => true
            ]
        );
        woocommerce_wp_text_input(
            [
                'id'                => 'shopengine_coupon_suffix',
                'label'             => esc_html__('Suffix', 'shopengine-pro'),
                'style'             => 'width: 250px;float:left;',
                'description'       => esc_html__('Text/characters to be added after each coupon name', 'shopengine-pro'),
                'desc_tip'          => true
            ]
        );
        woocommerce_wp_text_input(
            [
                'id'                => 'shopengine_coupon_identifier',
                'label'             => esc_html__('Coupons Identifier Name', 'shopengine-pro'),
                'style'             => 'width: 250px;'
            ]
        );
        ?>
         </div>
        <?php
    }

    public function admin_scripts()
    {
        wp_enqueue_style('shopengine-pro-advanced-coupon', \ShopEngine_Pro::module_url() . 'advanced-coupon/assets/css/style.css');
        wp_enqueue_script(
            'shopengine-advanced-coupon',
            \ShopEngine_Pro::module_url() . 'advanced-coupon/assets/js/script.js',
            ['jquery']
        );
        $methods = [];
        foreach(\WC_Payment_Gateways::instance()->get_available_payment_gateways() as $cod => $method) {
            $methods[] = ['id' => $cod, 'text' => $method->title]; 
        }
        wp_localize_script('shopengine-advanced-coupon', 'shopengine_advanced_coupon', [
            'country'           => json_encode(Advanced_Coupon::get_countries_with_states()),
            'export_api'        => get_rest_url('', 'shopengine-builder/v1/advanced-coupon/export'),
            'payment_methods'   => json_encode($methods)
        ]);
    }

    /**
     * @param $length
     */
    public function generate_coupon_name($length = 8)
    {
        return substr(sha1(rand()), 0, $length);
    }
}
