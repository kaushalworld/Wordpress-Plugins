<?php

namespace LivemeshAddons\Modules\Source;

use Elementor\Plugin;
use Elementor\Utils;

class LAE_Posts_Source extends LAE_Source {

    public $post;

    public $post_ID;

    public $product;

    function __construct($post, $settings) {

        parent::__construct($settings);

        $this->post = $post;

        $this->post_ID = $post->ID;

        if (class_exists('WooCommerce') && $post->post_type == 'product')
            $this->product = wc_get_product($post->ID);
    }

    function get_item_template_output() {

        $template_id = $this->settings['item_template'];

        if ($template_id)

            $output = $this->get_item_template_content($template_id, $this->settings);
        else
            $output = lae_template_error(__('Choose a custom skin template for the grid item', 'livemesh-el-addons'));

        return $output;
    }

    function get_item_template_content($template_id, $settings) {

        /* Initialize the theme builder templates - Requires elementor pro plugin */
        if (!is_plugin_active('elementor-pro/elementor-pro.php')) {
            $error = lae_template_error(__('Custom skin requires Elementor Pro but the plugin is not installed/active', 'livemesh-el-addons'));

            return $error;
        }

        $query_vars = array('p' => $this->post_ID, 'post_type' => get_post_type($this->post_ID));

        Plugin::instance()->db->switch_to_query( $query_vars);

        /* Fetch the custom skin content from Elementor */
        $output = lae_get_template_content($template_id, $settings);

        Plugin::instance()->db->restore_current_query();

        return $output;

    }

    function get_thumbnail($size = 'default') {

        $output = '';

        if ($thumbnail_exists = has_post_thumbnail($this->post_ID)):

            $output .= '<div class="lae-module-thumb">';

            $output .= $this->get_media($size);

            $output .= '</div><!-- .lae-module-thumb -->';

        endif;

        return apply_filters('lae_post_item_thumbnail', $output, $size, $this);
    }

    function get_media($size = 'default') {

        $output = '';
        $disable_lazy_load = true;

        // Enable lazy load for posts block module
        if (preg_match('/^block_\d+$/', $this->settings['block_type'], $matches))
            $disable_lazy_load = false;

        if ($size !== 'default') {

            $image_attrs = array('class' => 'lae-image');

            if ($disable_lazy_load) {
                $image_attrs = array(
                    'class' => 'lae-image ' . lae_disable_lazy_load_classes(),
                    'data-no-lazy' => 1,
                    'loading' => 'eager'
                );
            }

            $thumbnail_html = get_the_post_thumbnail($this->post_ID, $size, $image_attrs);
        }
        else {

            $image_setting = ['id' => get_post_thumbnail_id($this->post_ID)];

            $thumbnail_html = lae_get_image_html($image_setting, 'thumbnail_size', $this->settings, $disable_lazy_load);
        }

        // Check for additional images of a woocommerce product
        $thumbnail_html = $thumbnail_html . $this->get_product_image();

        if ($this->settings['image_linkable']):

            $target = $this->settings['post_link_new_window'] ? ' target="_blank"' : '';

            $output .= '<a class="lae-post-link" href="' . get_the_permalink($this->post_ID) . '"' . $target . '>' . $thumbnail_html . '</a>';

        else:

            $output .= $thumbnail_html;

        endif;

        return apply_filters('lae_post_item_media', $output, $size, $this);
    }

    function get_lightbox() {

        $output = '';

        if ($this->settings['enable_lightbox']) :

            $featured_image_id = get_post_thumbnail_id($this->post_ID);

            $featured_image_src = wp_get_attachment_image_src($featured_image_id, 'full');

            if ($featured_image_src) {

                $featured_image_src = $featured_image_src[0];

                $thumbnail_src = wp_get_attachment_image_src($featured_image_id);

                $thumbnail_src = $thumbnail_src[0];

                $output .= '<a class="lae-lightbox-item lae-click-icon" data-elementor-open-lightbox="no" data-fancybox="' . esc_attr($this->settings['block_class']) . '" data-thumb="' . $thumbnail_src . '" data-post-link="' . esc_url(get_the_permalink($this->post_ID)) . '" data-post-excerpt="' . esc_html($this->get_excerpt_for_lightbox()) . '" href="' . $featured_image_src . '" title="' . get_the_title($this->post_ID) . '"><i class="lae-icon-full-screen"></i></a>';

            }

        endif;

        return apply_filters('lae_post_item_lightbox_html', $output, $this);
    }

    function get_media_title() {

        $output = '';

        if ($this->settings['display_title_on_thumbnail']) :

            $target = $this->settings['post_link_new_window'] ? ' target="_blank"' : '';

            $output = '<' . lae_validate_html_tag($this->settings['title_tag']) . ' class="lae-post-title">';

            $output .= '<a href="' . get_permalink($this->post_ID) . '" title="' . get_the_title($this->post_ID) . '" rel="bookmark"' . $target . '>' . get_the_title($this->post_ID) . '</a>';

            $output .= '</' . lae_validate_html_tag($this->settings['title_tag']). '>';

        endif;

        return apply_filters('lae_post_item_media_title', $output, $this);

    }

    function get_media_taxonomy() {

        $output = '';

        if ($this->settings['display_taxonomy_on_thumbnail']) :

            if (empty($taxonomies))
                $taxonomies = $this->settings['taxonomies'];

            foreach ($taxonomies as $taxonomy) {

                $output .= $this->get_taxonomy_info($taxonomy);

            }

        endif;

        return apply_filters('lae_post_item_media_taxonomy', $output, $this);

    }

    function get_media_overlay() {

        $output = '<div class="lae-module-image-overlay"></div>';

        return apply_filters('lae_post_item_media_overlay', $output, $this);

    }

    function get_title() {

        $output = '';

        if ($this->settings['display_title']) :

            $target = $this->settings['post_link_new_window'] ? ' target="_blank"' : '';

            $output = '<' . lae_validate_html_tag($this->settings['entry_title_tag']) . ' class="entry-title">';

            $output .= '<a href="' . get_permalink($this->post_ID) . '" title="' . get_the_title($this->post_ID) . '" rel="bookmark"' . $target . '>' . get_the_title($this->post_ID) . '</a>';

            $output .= '</' . lae_validate_html_tag($this->settings['entry_title_tag']) . '>';

        endif;

        return apply_filters('lae_post_item_entry_title', $output, $this);

    }

    function get_excerpt() {

        $output = '';

        if ($this->settings['display_summary']) :

            $excerpt_count = $this->settings['excerpt_length'];

            $output = '<div class="entry-summary">';

            if (empty($this->post->post_excerpt))
                $excerpt = $this->post->post_content;
            else
                $excerpt = $this->post->post_excerpt;

            if ($this->settings['rich_text_excerpt'])
                $output .= do_shortcode(force_balance_tags(html_entity_decode(wp_trim_words(htmlentities($excerpt), $excerpt_count, '…'))));
            else
                $output .= wp_trim_words(wp_strip_all_tags(strip_shortcodes($excerpt)), $excerpt_count, '…');

            $output .= '</div><!-- .entry-summary -->';

        endif;

        return apply_filters('lae_post_item_excerpt', $output, $this);

    }

    function get_excerpt_for_lightbox() {

        $output = '';

        if ($this->settings['display_excerpt_lightbox']) :

            // Trim the excerpt only if you are displaying content since lightbox has lots of room for displaying excerpt
            if (empty($this->post->post_excerpt)) {

                $excerpt_count = $this->settings['excerpt_length'];

                $excerpt = $this->post->post_content;

                $excerpt = wp_trim_words(wp_strip_all_tags(strip_shortcodes($excerpt)), $excerpt_count, '…');
            }
            else {
                $excerpt = $this->post->post_excerpt;
            }

            $output .= do_shortcode($excerpt);

        endif;

        return apply_filters('lae_post_item_excerpt_for_lightbox', $output, $this);

    }

    function get_read_more_link() {

        $output = '';

        if ($this->settings['display_read_more']) {

            $read_more_text = $this->settings['read_more_text'];

            $output .= '<div class="lae-read-more">';

            $output .= '<a href="' . get_the_permalink($this->post_ID) . '">' . $read_more_text . '</a>';

            $output .= '</div>';

        }

        return apply_filters('lae_post_item_read_more_link', $output, $this);

    }

    function get_read_more_button() {

        $output = '';

        if ($this->settings['display_read_more']) {

            $read_more_text = $this->settings['read_more_text'];

            $output .= '<div class="lae-read-more">';

            $output .= '<a class="lae-button" href="' . get_the_permalink($this->post_ID) . '">' . $read_more_text . '</a>';

            $output .= '</div>';

        }

        return apply_filters('lae_post_item_read_more_button', $output, $this);

    }

    function get_taxonomy_info($taxonomy) {

        $output = '';

        $terms = get_the_terms($this->post_ID, $taxonomy);

        if (!empty($terms) && !is_wp_error($terms)) {

            $output .= '<span class="lae-terms">';

            $term_count = 0;

            foreach ($terms as $term) {

                if ($term_count != 0)
                    $output .= ', ';

                $output .= '<a href="' . get_term_link($term->slug, $taxonomy) . '">' . $term->name . '</a>';

                $term_count = $term_count + 1;
            }
            $output .= '</span>';
        }


        return apply_filters('lae_post_item_taxonomy_info', $output, $this);
    }

    function get_taxonomies_info($taxonomies = null) {

        $output = '';

        if ($this->settings['display_taxonomy']) :

            if (empty($taxonomies))
                $taxonomies = $this->settings['taxonomies'];

            foreach ($taxonomies as $taxonomy) {

                $output .= $this->get_taxonomy_info($taxonomy);

            }

        endif;

        return apply_filters('lae_post_item_taxonomies_info', $output, $this);
    }

    function get_author() {

        $output = '';

        if ($this->settings['display_author']) :

            $output .= '<span class="author vcard">' . esc_html__('By ', 'livemesh-el-addons') . '<a class="url fn n" href="' . get_author_posts_url($this->post->post_author) . '" title="' . esc_attr(get_the_author_meta('display_name', $this->post->post_author)) . '">' . esc_html(get_the_author_meta('display_name', $this->post->post_author)) . '</a></span>';

        endif;

        return apply_filters('lae_post_item_author', $output, $this);
    }

    function get_date($format = null) {

        $output = '';

        if ($this->settings['display_post_date']) :

            if (empty($format))
                $format = get_option('date_format');

            $output .= '<span class="published"><abbr title="' . get_the_time(esc_html__('l, F, Y, g:i a', 'livemesh-el-addons'), $this->post_ID) . '">' . get_the_time($format, $this->post_ID) . '</abbr></span>';

        endif;

        return apply_filters('lae_post_item_post_date', $output, $this);
    }

    function get_comments() {

        $output = '';

        if ($this->settings['display_comments']) :

            $output .= $this->entry_comments_link($this->post_ID);

        endif;

        return apply_filters('lae_post_item_entry_comments', $output, $this);

    }

    function entry_comments_link($id, $args = array()) {

        $comments_link = '';
        $num_of_comments = doubleval(get_comments_number($id));

        $defaults = array('zero' => __('No Comments', 'livemesh-el-addons'), 'one' => __('%1$s Comment', 'livemesh-el-addons'), 'more' => __('%1$s Comments', 'livemesh-el-addons'), 'css_class' => 'lae-comments', 'none' => '', 'before' => '', 'after' => '');

        /* Merge the input arguments and the defaults. */
        $args = wp_parse_args($args, $defaults);

        $comments_link .= '<span class="' . esc_attr($args['css_class']) . '">';

        if (0 == $num_of_comments && !comments_open($id) && !pings_open($id)) {
            if ($args['none'])
                $comments_link .= sprintf($args['none'], number_format_i18n($num_of_comments));
        }
        elseif (0 == $num_of_comments)
            $comments_link .= '<a href="' . get_permalink($id) . '#respond" title="' . sprintf(esc_attr__('Comment on %1$s', 'livemesh-el-addons'), the_title_attribute(array('echo' => false, 'post' => $id))) . '">' . sprintf($args['zero'], number_format_i18n($num_of_comments)) . '</a>';
        elseif (1 == $num_of_comments)
            $comments_link .= '<a href="' . get_comments_link($id) . '" title="' . sprintf(esc_attr__('Comment on %1$s', 'livemesh-el-addons'), the_title_attribute(array('echo' => false, 'post' => $id))) . '">' . sprintf($args['one'], number_format_i18n($num_of_comments)) . '</a>';
        elseif (1 < $num_of_comments)
            $comments_link .= '<a href="' . get_comments_link($id) . '" title="' . sprintf(esc_attr__('Comment on %1$s', 'livemesh-el-addons'), the_title_attribute(array('echo' => false, 'post' => $id))) . '">' . sprintf($args['more'], number_format_i18n($num_of_comments)) . '</a>';

        $comments_link .= '</span>';

        $comments_link = $args['before'] . $comments_link . $args['after'];

        return apply_filters('lae_post_item_comments_link', $comments_link, $this);
    }

    function entry_comments_number($id, $args = array()) {
        $comments_text = '';
        $number = get_comments_number($id);
        $defaults = array('zero' => __('No Comments', 'livemesh-el-addons'), 'one' => __('%1$s Comment', 'livemesh-el-addons'), 'more' => __('%1$s Comments', 'livemesh-el-addons'), 'css_class' => 'lae-comments', 'none' => '', 'before' => '', 'after' => '');

        /* Merge the input arguments and the defaults. */
        $args = wp_parse_args($args, $defaults);

        $comments_text .= '<span class="' . esc_attr($args['css_class']) . '">';

        if (0 == $number && !comments_open($id) && !pings_open($id)) {
            if ($args['none'])
                $comments_text .= sprintf($args['none'], number_format_i18n($number));
        }
        elseif ($number == 0)
            $comments_text .= sprintf($args['zero'], number_format_i18n($number));
        elseif ($number == 1)
            $comments_text .= sprintf($args['one'], number_format_i18n($number));
        elseif ($number > 1)
            $comments_text .= sprintf($args['more'], number_format_i18n($number));

        $comments_text .= '</span>';

        if ($comments_text)
            $comments_text = $args['before'] . $comments_text . $args['after'];

        return apply_filters('lae_post_item_comments_number', $comments_text, $this);
    }

    function get_product_price() {

        $output = '';

        if ($this->product) {

            $price = $this->product->get_price();
            $price = ($price > 0) ? wc_price($price) : null;

            $output .= '<div class="lae-item-price">';
            $output .= $price;
            $output .= '</div>';

        }

        return apply_filters('lae_product_price', $output, $this);

    }

    function get_product_full_price() {

        $output = '';

        if ($this->settings['display_product_price']) :

            if ($this->product) {


                $price = $this->product->get_price_html();

                $output .= '<div class="lae-item-price">';
                $output .= $price;
                $output .= '</div>';

            }

        endif;

        return apply_filters('lae_product_full_price', $output, $this);

    }

    function get_product_regular_price() {

        $output = '';

        if ($this->product) {


            $price = $this->product->get_regular_price();
            $price = ($price > 0) ? wc_price($price) : null;

            $output .= '<div class="lae-item-price">';
            $output .= $price;
            $output .= '</div>';

        }

        return apply_filters('lae_product_regular_price', $output, $this);

    }

    function get_product_sale_price() {

        $output = '';

        if ($this->product) {


            $price = $this->product->get_sale_price();
            $price = ($price > 0) ? wc_price($price) : null;

            $output .= '<div class="lae-item-price">';
            $output .= $price;
            $output .= '</div>';

        }

        return apply_filters('lae_product_sale_price', $output, $this);

    }

    function get_product_rating() {

        $output = '';

        if ($this->settings['display_product_rating']) :

            if ($this->product) {


                $rating = $this->product->get_average_rating();
                $rating = wc_get_rating_html($rating);
                $rating = preg_replace('#(<span.*?>).*?(</span>)#', '$1$2', $rating);

                $output .= '<div class="lae-item-rating">';
                $output .= $rating;
                $output .= '</div>';

            }

        endif;

        return apply_filters('lae_product_rating', $output, $this);

    }

    function get_product_text_rating() {

        $output = '';

        if ($this->product) {


            $rating = $this->product->get_average_rating();

            if ($rating > 0) {
                $output .= '<div class="lae-item-text-rating" title="' . sprintf(__('Rated %s out of 5', 'woocommerce'), $rating) . '">';
                $output .= '<strong class="rating">' . $rating . '</strong> ' . __('out of 5', 'woocommerce');
                $output .= '</div>';
            }

        }

        return apply_filters('lae_product_text_rating', $output, $this);

    }


    function get_product_on_sale() {

        $output = '';

        if ($this->product) {

            if ($this->product->is_on_sale()) {

                $output .= '<div class="lae-item-on-sale">';
                $output .= apply_filters('woocommerce_sale_flash', '<span class="onsale">' . __('Sale!', 'woocommerce') . '</span>', $this->post, $this->product);
                $output .= '</div>';
            }

        }

        return apply_filters('lae_product_on_sale', $output, $this);

    }

    function get_product_add_to_cart_url() {

        $output = '';

        if ($this->product) {

            $cart_url = $this->product->add_to_cart_url();

            $cart_text = __('Add to Cart', 'livemesh-el-addons');

            $target = '_self';

            if ($cart_url) {
                $output .= '<a class="lae-item-add-to-cart-url" href="' . esc_url($cart_url) . '" target ="' . esc_attr($target) . '">"';

                $output .= esc_html($cart_text);

                $output .= '</a>';
            }

        }

        return apply_filters('lae_product_add_to_cart_url', $output, $this);

    }


    function get_wc_product_cart_button() {

        $cart = '';

        if ($this->product) {

            $product = $this->product;

            $quantity = $product->get_stock_quantity();

            $ajax_add_to_cart = $product->supports('ajax_add_to_cart') ? ' ajax_add_to_cart' : '';

            ob_start();

            $cart_button = apply_filters('woocommerce_loop_add_to_cart_link',
                sprintf('<a href="%s" rel="nofollow" data-product_id="%s" data-product_sku="%s" data-quantity="%s" class="button %s product_type_%s">%s</a>',
                    esc_url($product->add_to_cart_url()),
                    esc_attr($product->get_id()),
                    esc_attr($product->get_sku()),
                    esc_attr(isset($quantity) ? $quantity : 1),
                    $product->is_purchasable() && $product->is_in_stock() ? 'add_to_cart_button' . $ajax_add_to_cart : '',
                    esc_attr($product->get_type()),
                    esc_html($product->add_to_cart_text())
                ),
                $product);

            $content = ob_get_contents();
            ob_end_clean();

            // in case the filter echo if modified by a theme
            $cart = ($cart_button) ? $cart_button : $content;

        }

        return apply_filters('lae_wc_product_cart_button', $cart, $this);

    }

    function get_product_cart_button() {

        $output = '';

        if ($this->settings['display_add_to_cart_button']) :

            $cart_button = $this->get_wc_product_cart_button();

            /*if ($this->settings['cart_icon']) {
                $icon_simple = '<i class="lae-icon-shop-bag"></i>';
                $icon_variable = '<i class="lae-icon-settings"></i>';
                $cart_icon = (strpos($cart_button, 'product_type_simple') !== false) ? $icon_simple : $icon_variable;
                $cart_button = preg_replace('#(<a.*?>).*?(</a>)#', '$1' . $cart_icon . '$2', $cart_button);
            }*/

            if ($this->settings['post_link_new_window'])
                $cart_button = preg_replace('/(<a\b[^><]*)>/i', '$1 target="_blank">', $cart_button);

            $output = '<div class="lae-item-cart-button">';

            $output .= $cart_button;

            $output .= '</div>';

        endif;

        return apply_filters('lae_product_cart_button', $output, $this);

    }

    function get_product_wishlist() {

        $output = '';

        if ($this->settings['display_wish_list_button']) :

            if ($this->product) {

                global $yith_wcwl;

                if ($yith_wcwl) {
                    $output = do_shortcode('[yith_wcwl_add_to_wishlist product_id="' . $this->post_ID . '"]');
                    $output = preg_replace('#<div class="clear">(.*?)</div>#', '', $output);
                }

            }

        endif;

        return apply_filters('lae_product_wishlist', $output, $this);

    }

    function get_product_image() {

        $output = '';

        if ($this->product) {

            $product_image = get_post_meta($this->post_ID, '_product_image_gallery', true);
            $product_image = ($product_image) ? explode(',', $product_image) : null;

            if (isset($product_image[0]) && !empty($product_image[0])) {

                $image_setting = ['id' => $product_image[0], 'class' => 'lae-alternate-image'];

                $output = lae_get_image_html($image_setting, 'thumbnail_size', $this->settings, true);
            }

        }

        return apply_filters('lae_product_image', $output, $this);

    }

    function get_product_quick_view() {

        $output = '';

        if ($this->settings['display_product_quick_view']) :

            if ($this->product) {
                $output .= '<a href="#" id="product_id_' . $this->post_ID . '" class="lae-quick-view" data-product_id="' . $this->post_ID . '"><i class="fa fa-eye"></i>' . esc_html__('Quick View', 'livemesh-el-addons') . '</a>';
            }

        endif;

        return apply_filters('lae_product_quick_view', $output, $this);
    }

}