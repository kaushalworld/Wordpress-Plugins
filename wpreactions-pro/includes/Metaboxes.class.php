<?php

namespace WPRA;

use WPRA\Helpers\Utils;

class Metaboxes {

    public function __construct() {
        add_action('add_meta_boxes', [$this, 'add']);
        add_action('save_post', [$this, 'save_metaboxdata'], 10, 2);
    }

    static function render() {
        return new self();
    }

    function add($post_type) {
        // merge global and shortcode post types
        $post_types = array_merge(Config::getGlobalDeployments(true), Shortcode::getBindPostTypes());

        // product post type and integration is not enabled
        if ($post_type == 'product' && Config::$settings['woo_integration'] == 0) {
            return;
        }

        // post type is not in list of activated ones
        if (!in_array($post_type, $post_types)) {
            return;
        }

        add_meta_box(
            'wpra_options',
            __('WP Reactions', 'wpreactions'),
            [$this, 'view'],
            $post_type
        );
    }

    function view($post) {
        $sgc_options = Shortcode::getSgcDataBy('post_type', $post->post_type, ['options']);
        if (is_null($sgc_options) && !Config::isGlobalActivated()):
            echo '<p>';
            _e('Please activate plugin globally in WP Reactions > Global Activation to see page/post related options', 'wpreactions');
            echo '</p>';

            return;
        endif;

        $options            = $sgc_options;
        $post_allow_default = 'true';

        if (is_null($options)) {
            $options            = Config::$active_layout_opts;
            $deploys            = Config::getGlobalDeployments();
            $post_allow_default = in_array($post->post_type, $deploys['manual']) ? 'false' : 'true';
        }

        $post_allow   = Utils::get_post_meta($post->ID, '_wpra_show_emojis', $post_allow_default);
        $emoji_format = Emojis::getData($options['emojis'], ['format']);

        Utils::renderTemplate('view/admin/metaboxes/parts/activate', [
            'value' => $post_allow
        ]);

        Utils::renderTemplate('view/admin/metaboxes/parts/fake-reaction-counts', [
            'options'      => $options,
            'post_id'      => $post->ID,
            'emoji_format' => $emoji_format,
        ]);

        Utils::renderTemplate('view/admin/metaboxes/parts/reaction-stats', [
            'options' => $options,
            'post_id' => $post->ID
        ]);

        Utils::renderTemplate('view/admin/metaboxes/parts/fake-social-total-count', [
            'options' => $options,
            'post_id' => $post->ID
        ]);

        Utils::renderTemplate('view/admin/metaboxes/parts/social-stats', [
            'post_id' => $post->ID
        ]);
    } // end of view function

    function save_metaboxdata($post_id, $post) {
        if (array_key_exists('wpra_show_emojis', $_POST)) {
            $sgc_options = Shortcode::getSgcDataBy('post_type', $post->post_type, ['options']);
            $options     = is_null($sgc_options) ? Config::$active_layout_opts : $sgc_options;

            update_post_meta($post_id, '_wpra_show_emojis', $_POST['wpra_show_emojis']);

            $counts = [];

            foreach ($options['emojis'] as $emoji_id) {
                $counts[$emoji_id] = array_key_exists('wpra_count_' . $emoji_id, $_POST) ? $_POST['wpra_count_' . $emoji_id] : 0;
            }

            update_post_meta($post_id, '_wpra_start_counts', $counts);

            if (array_key_exists('wpra_fake_share_counts', $_POST)) {
                update_post_meta($post_id, '_wpra_fake_share_count', $_POST['wpra_fake_share_counts']);
            }
        }
    }
}