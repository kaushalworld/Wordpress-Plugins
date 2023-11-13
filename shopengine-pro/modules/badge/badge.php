<?php

namespace ShopEngine_Pro\Modules\Badge;

use ShopEngine\Compatibility\Conflicts\Theme_Hooks;
use ShopEngine\Core\Register\Module_List;
use ShopEngine_Pro\Traits\Singleton;
use ShopEngine_Pro\Util\Helper;

class Badge
{
    use Singleton;

    public $badge_module_settings;

    public function init()
    {
        new Route;

        $this->badge_module_settings = Module_List::instance()->get_settings('badge');

        add_filter('woocommerce_format_sale_price', [$this, 'format_price_badge'], 9999, 3);

        add_action('wp_enqueue_scripts', [$this, 'enqueue']);

        add_action('admin_enqueue_scripts', [$this, 'admin_enqueue']);

        add_action('shopengine/templates/elementor/content/before', [$this, 'theme_conflicts_in_widget']);

        /**
         * Showing badges on single page and archive page
         *
         */
        add_action('woocommerce_product_thumbnails', [$this, 'show_product_badges'], 1000);
        add_action('woocommerce_before_shop_loop_item_title', [$this, 'show_product_badges']);
        //add_action('woocommerce_before_shop_loop_item_title', [$this, 'show_shop_sale_flash']);

        if (is_admin()) {
            (new Product_Tab())->init();
        }
    }

    public function enqueue()
    {
        wp_enqueue_style('se-mod-badge-frn', \ShopEngine_Pro::module_url() . 'badge/assets/css/badge.css', [], \ShopEngine_Pro::version());

        $badge_width_for_single_product = !empty($this->badge_module_settings["badge_width_for_single_product"]["value"]) ? $this->badge_module_settings["badge_width_for_single_product"]["value"]."px": '70px';
        $badge_width_for_loop_product = !empty($this->badge_module_settings["badge_width_for_loop_product"]["value"]) ? $this->badge_module_settings["badge_width_for_loop_product"]["value"]."px" : '35px';
        $badge_gap_for_single_product = !empty($this->badge_module_settings["badge_gap_for_single_product"]["value"]) ? $this->badge_module_settings["badge_gap_for_single_product"]["value"]."px": '0px';
        $badge_gap_for_loop_product = !empty($this->badge_module_settings["badge_gap_for_loop_product"]["value"]) ? $this->badge_module_settings["badge_gap_for_loop_product"]["value"]."px": '0px';

        $custom_css = "
        :root {
			--badge-width-for-single-product: $badge_width_for_single_product;
			--badge-width-for-loop-product: $badge_width_for_loop_product;
			--badge-gap-for-single-product: $badge_gap_for_single_product;
			--badge-gap-for-loop-product: $badge_gap_for_loop_product;
		}
        ";
        wp_add_inline_style( 'se-mod-badge-frn', $custom_css);
    }

    public function admin_enqueue()
    {
        wp_enqueue_style('se-mod-badge-adm', \ShopEngine_Pro::module_url() . 'badge/assets/css/adm-styles.css', [], \ShopEngine_Pro::version());

        wp_enqueue_script('se-mod-badge-adm', \ShopEngine_Pro::module_url() . 'badge/assets/js/adm-script.js', ['jquery'], \ShopEngine_Pro::version());

        wp_localize_script(
            'se-mod-badge-adm',
            'badgeConfObj',
            [
                'i18n'  => [
                    'title' => esc_html__('Choose an image', 'shopengine-pro'),
                    'b_txt' => esc_html__('Use image', 'shopengine-pro')
                ],
                'dummy' => Helper::get_dummy(),
                'multi' => false
            ]
        );
    }

    public function get_product_badges($product_id)
    {
        $settings                  = $this->badge_module_settings['badges']['value'];
        $category_terms            = get_the_terms($product_id, 'product_cat');
        $product_individual_badge  = get_post_meta($product_id, 'shopengine_product_badge', true);
        $applied_badges            = [];
        $applied_badges_final_list = [];

        foreach ($settings as $badge_item) {
            // products assign by checking
            if ($badge_item['assign_by'] === 'products') {

                if (in_array($product_id, $badge_item['product_list'])) {
                    $applied_badges_final_list = $this->get_badge($applied_badges_final_list, $badge_item);
                    array_push($applied_badges, $badge_item['_uid']);
                }

            } else {
                // category assign by checking
                $category_match = $this->check_category_assign_by($category_terms, $badge_item);
                if ($category_match) {
                    $applied_badges_final_list = $this->get_badge($applied_badges_final_list, $badge_item);
                    array_push($applied_badges, $badge_item['_uid']);
                }
            }
        }

        // individual badge come form product settings page
        if (!empty($product_individual_badge) && !in_array($product_individual_badge, $applied_badges)) {
            $key = array_search($product_individual_badge, array_column($settings, '_uid'));
            if (is_numeric($key)) {
                $applied_badges_final_list = $this->get_badge($applied_badges_final_list, $settings[$key]);
            }
        }

        return $applied_badges_final_list;
    }

    public function check_category_assign_by($category_terms, $badge)
    {
        foreach ($category_terms as $category_term) {
            $category_match = in_array($category_term->term_id, $badge['category_list']);
            if ($category_match) {
                return true;
            }
        }
        return false;
    }

    public function get_badge($applied_badges_final_list, $badge)
    {

        if (!empty($badge['position'])) {
            $applied_badges_final_list[$badge['position']][] = $badge;
        } else {
            $applied_badges_final_list['top_right'][] = $badge;
        }
        return $applied_badges_final_list;
    }

    public function format_price_badge($price, $regular_price, $sale_price)
    {
        $currency_symbol = get_woocommerce_currency_symbol();
        $regular_price   = str_replace([',', $currency_symbol], ['', ''], wp_strip_all_tags($regular_price));
        $sale_price      = str_replace([',', $currency_symbol], ['', ''], wp_strip_all_tags($sale_price));

        if ($regular_price > 0) {
            $pct = ($regular_price - $sale_price) * 100 / $regular_price;
        } else {
            $pct = 0;
        }

        $pct = \Automattic\WooCommerce\Utilities\NumberUtil::round($pct, apply_filters('shopengine_pro_discount_precision', 1));

        $price = '<del>' . (is_numeric($regular_price) ? wc_price($regular_price) : $regular_price) . '</del> ' .
        '<ins>' . (is_numeric($sale_price) ? wc_price($sale_price) : $sale_price) . '</ins>' . (is_admin() ? '<br>' : '') .
        '&nbsp;<span class="shopengine-badge shopengine-discount-badge">' . $pct . '% ' . esc_html__('OFF', 'shopengine-pro') . '</span>';

        return $price;
    }

    public function theme_conflicts_in_widget($template_type)
    {
        if (in_array($template_type, ['shop', 'archive'])) {

            Theme_Hooks::instance()->theme_conflicts__shop_and_archive_for_badge_module();
        }
    }

    public function inline_css($badges)
    {
        
        $parent = ".shopengine-element-".$badges['_uid']."";
        $border_radius = !empty($badges['badge_text_border_radius']) ? $badges['badge_text_border_radius'] : "";
        $background    = !empty($badges['badge_text_background_color']) ? $badges['badge_text_background_color'] : "";
        $color         = !empty($badges['badge_text_color']) ? $badges['badge_text_color'] : "";
        $font_size     = !empty($badges['badge_text_font_size']) ? $badges['badge_text_font_size'] : "";
        $padding       = !empty($badges['badge_text_padding']) ?  $badges['badge_text_padding'] : "0 0 0 0";
        $css    = "
            ".esc_attr($parent)." .shopengine-special-badge-type-text{
                color : ".esc_attr($color).";
                font-size: ".esc_attr($font_size)."px;
                background-color: ".esc_attr($background).";
                border-radius: ".esc_attr($border_radius)."px;
                padding: ".esc_attr($padding)."; 
            }
        ";
        $repeater_css = "<style>". $css ."</style>";

        return $repeater_css;
    }

    public function show_markup($badge, $settings)
    {
        $badge_type = !empty($badge['badge_type']) ? $badge['badge_type'] : 'attachment';
        ?>
        <div class="shopengine-element-<?php echo esc_attr($badge[ '_uid']); ?>">
            <div class="shopengine-special-badge-type-<?php echo esc_attr($badge_type); ?>">
                <?php if($badge_type === "text"): ?>
                <?php
                    $badge_text = !empty($badge['badge_text']) ? shopengine_pro_translator('badge__badges__badge_text__'.$badge['_uid'], $badge['badge_text']) : "";    
                ?>
                    <span class="shopengine-special-badge-text"><?php echo esc_html($badge_text); ?></span>
                <?php else: ?>
                <img alt="<?php esc_attr_e('Badge','shopengine-pro'); ?>" class="shopengine-special-badge-image" src="<?php echo esc_url($badge['badge_attachment_id']); ?>" />
                <?php endif; ?>
            </div>
        </div>
    <?php
    }

    public function show_product_badges()
    {
        global $product;

        $product_badges = $this->get_product_badges($product->get_id());
        
        $positions = array_keys($product_badges);
        $settings = $this->badge_module_settings['alignment']['value'];
        foreach($positions as $position) {
            echo '<div class="shopengine-special-badge shopengine-special-badge-position-'.esc_attr($position).' shopengine-special-badge-position-'.esc_attr($settings).'">' ;
                foreach($product_badges[$position] as $badge){
                     shopengine_pro_content_render($this->inline_css($badge));
                    $this->show_markup($badge,$settings);
                }
            echo '</div>';

        }
    }
}
