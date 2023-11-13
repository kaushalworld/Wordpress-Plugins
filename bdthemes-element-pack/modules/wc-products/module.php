<?php

namespace ElementPack\Modules\WcProducts;

use ElementPack\Base\Element_Pack_Module_Base;

if (!defined('ABSPATH')) exit; // Exit if accessed directly

class Module extends Element_Pack_Module_Base {

    public function __construct() {

        parent::__construct();

        if (!empty($_REQUEST['action']) && 'elementor' === $_REQUEST['action'] && is_admin()) {
            add_action('init', [$this, 'register_wc_hooks'], 5);
        }

        add_action('elementor/editor/before_enqueue_scripts', [$this, 'maybe_init_cart']);

        /**
         * Modal data
         */
        add_action('wp_ajax_nopriv_element_pack_wc_product_quick_view_content', array(
            $this,
            'element_pack_wc_product_quick_view_content'
        ));
        add_action('wp_ajax_element_pack_wc_product_quick_view_content', array(
            $this,
            'element_pack_wc_product_quick_view_content'
        ));

        add_action('element_pack_wc_product_quick_view_data', 'woocommerce_template_single_title');
        add_action('element_pack_wc_product_quick_view_data', 'woocommerce_template_single_rating');
        add_action('element_pack_wc_product_quick_view_data', 'woocommerce_template_single_price');
        add_action('element_pack_wc_product_quick_view_data', 'woocommerce_template_single_excerpt');
        add_action('element_pack_wc_product_quick_view_data', 'woocommerce_template_single_add_to_cart');
        add_action('element_pack_wc_product_quick_view_data', 'woocommerce_template_single_meta');

        add_action('element_pack_wc_product_quick_view_product_sale_flash', 'woocommerce_show_product_sale_flash');
        add_action('element_pack_woocommerce_show_product_images', array(
            $this,
            'element_pack_woocommerce_show_product_images'
        ));
    }

    public function get_name() {
        return 'wc-products';
    }

    public function get_widgets() {

        $widgets = ['WC_Products'];

        return $widgets;
    }

    public function add_products_post_class_filter() {
        add_filter('post_class', [$this, 'add_product_post_class']);
    }

    public function remove_products_post_class_filter() {
        remove_filter('post_class', [$this, 'add_product_post_class']);
    }

    public function register_wc_hooks() {
        wc()->frontend_includes();
    }

    public function maybe_init_cart() {
        $has_cart = is_a(WC()->cart, 'WC_Cart');

        if (!$has_cart) {
            $session_class = apply_filters('woocommerce_session_handler', 'WC_Session_Handler');
            WC()->session  = new $session_class();
            WC()->session->init();
            WC()->cart     = new \WC_Cart();
            WC()->customer = new \WC_Customer(get_current_user_id(), true);
        }
    }

    public function element_pack_wc_product_quick_view_content() {

        global $woocommerce;

        check_ajax_referer('ajax-ep-wc-product-nonce', 'security');

        wp_enqueue_script('wc-add-to-cart-variation');

        if ('POST' == $_SERVER['REQUEST_METHOD']) {
            $product_id = intval($_POST['product_id']);

            wp('p=' . $product_id . '&post_type=product');
            ob_start();
?>
            <div class="bdt-product-quick-view bdt-modal-container bdt-woocommerce-single-product-modal-wrapper" bdt-modal>
                <div class="bdt-modal-dialog bdt-modal-body">
                    <button class="bdt-modal-close-default" type="button" bdt-close></button>
                    <?php while (have_posts()) : the_post(); ?>
                        <div class="product">
                            <div id="product-<?php the_ID(); ?>" <?php post_class('product'); ?>>
                                <div class="bdt-flex-middle" bdt-grid>
                                    <div class="bdt-width-3-5">
                                        <?php do_action('element_pack_woocommerce_show_product_images'); ?>
                                    </div>
                                    <div class="bdt-width-2-5">
                                        <?php do_action('element_pack_wc_product_quick_view_product_sale_flash'); ?>
                                        <div class="ep-summary scrollable">
                                            <div class="ep-summary-content">
                                                <?php do_action('element_pack_wc_product_quick_view_data'); ?>
                                            </div>
                                        </div>
                                        <div class="scrollbar_bg"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
            </div>
        <?php
            $output = trim(ob_get_contents());
            ob_end_clean();

            echo wp_json_encode(array('data' => $output), 200);
        }
        exit;
    }

    public function element_pack_woocommerce_show_product_images() {

        global $post, $product;

        ?>
        <div class="ep-images">
            <?php

            if (has_post_thumbnail()) {
                $attachment_count = count($product->get_gallery_image_ids());
                $gallery          = $attachment_count > 0 ? '[product-gallery]' : '';
                $props            = wc_get_product_attachment_props(get_post_thumbnail_id(), $post);
                $image            = get_the_post_thumbnail($post->ID, apply_filters('single_product_large_thumbnail_size', 'shop_single'), array(
                    'title' => $props['title'],
                    'alt'   => $props['alt'],
                ));
                echo apply_filters('woocommerce_single_product_image_html', sprintf('<a href="%s" itemprop="image" class="woocommerce-main-image zoom" title="%s" data-rel="prettyPhoto' . $gallery . '">%s</a>', $props['url'], $props['caption'], $image), $post->ID);
            } else {
                echo apply_filters('woocommerce_single_product_image_html', sprintf('<img src="%s" alt="%s" />', wc_placeholder_img_src(), __('Placeholder', 'woocommerce')), $post->ID);
            }

            $attachment_ids = $product->get_gallery_image_ids();

            if ($attachment_ids) :
                $loop = 0;
                $columns    = apply_filters('woocommerce_product_thumbnails_columns', 3);
            ?>
                <div class="thumbnails <?php echo 'columns-' . $columns; ?>">
                    <?php
                    foreach ($attachment_ids as $attachment_id) {
                        $classes = array('thumbnail');
                        if ($loop === 0 || $loop % $columns === 0) {
                            $classes[] = 'first';
                        }
                        if (($loop + 1) % $columns === 0) {
                            $classes[] = 'last';
                        }
                        $image_link = wp_get_attachment_url($attachment_id);
                        if (!$image_link) {
                            continue;
                        }
                        $image_title   = esc_attr(get_the_title($attachment_id));
                        $image_caption = esc_attr(get_post_field('post_excerpt', $attachment_id));
                        $image         = wp_get_attachment_image($attachment_id, apply_filters('single_product_small_thumbnail_size', 'shop_thumbnail'), 0, $attr = array(
                            'title' => $image_title,
                            'alt'   => $image_title
                        ));
                        $image_class   = esc_attr(implode(' ', $classes));
                        echo apply_filters('woocommerce_single_product_image_thumbnail_html', sprintf('<a href="%s" class="%s" title="%s" >%s</a>', $image_link, $image_class, $image_caption, $image), $attachment_id, $post->ID, $image_class);
                        $loop++;
                    }
                    ?>
                </div>
            <?php endif; ?>
        </div>
<?php
    }
}
