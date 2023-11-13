<?php

namespace WPRA;

use WPRA\Database\BaseQuery;
use WPRA\Helpers\Notices;
use WPRA\Helpers\Utils;
use WPRA\Database\Query;

class Migrations {

    public function __construct() {
        add_action('plugins_loaded', [$this, 'update']);
        add_action('wpra_update_post_type', [$this, 'update_post_types']);
    }

    static function handle() {
        new self();
    }

    function update() {
        $curr_plugin_version = get_option('wpra_version', 1000);

        if (WPRA_VERSION == $curr_plugin_version) {
            return;
        }

        $handlers = array_filter(get_class_methods($this), function ($item) {
            return strpos($item, 'version_') === 0;
        });

        foreach ($handlers as $handler) {
            $version = str_replace(['version_', '_'], ['', '.'], $handler);
            if (version_compare($version, $curr_plugin_version, '>')) {
                call_user_func([$this, $handler]);
            }
        }

        // always run when new version updated, don't remove this
        if (version_compare(WPRA_VERSION, $curr_plugin_version, '>')) {
            Notices::remove('check_update');
        }

        update_option('wpra_version', WPRA_VERSION);
    }

    function version_2_6_0() {

        // adapt global options
        $old_global_options = json_decode(get_option('wpra_options'), true);
        update_option('wpra_layout', $old_global_options['behavior']);
        update_option('wpra_global_activation', $old_global_options['activation']);
        unset($old_global_options['behavior']);
        unset($old_global_options['activation']);
        unset($old_global_options['reveal_button']['border_width']);

        foreach (Config::$layouts as $layout => $config) {
            if (!get_option("wpra_options_$layout")) {
                $new_global_options = $config['defaults'];

                if ($layout == 'bimber') {
                    Config::updateLayoutOptions($layout, $new_global_options);
                    continue;
                }

                foreach ($old_global_options as $old_key => $old_global_option) {
                    if (isset($new_global_options[$old_key])) {

                        if ($old_key == 'flying') {
                            $new_global_options['flying']['labels'] = [];
                            $i                                      = 1;
                            foreach ($old_global_options['emojis'] as $emoji_id) {
                                $new_global_options['flying']['labels'][$emoji_id] = $old_global_option['labels']["reaction$i"];
                                $i++;
                            }
                            continue;
                        }

                        $new_global_options[$old_key] = $old_global_option;
                    }
                }

                if ($layout != 'button_reveal') {
                    $new_global_options['social'] = array_merge($new_global_options['social'], [
                        "counter"        => "true",
                        "counter_size"   => "30px",
                        "counter_weight" => 700,
                        "counter_color"  => "#000000",
                    ]);
                }

                Config::updateLayoutOptions($layout, $new_global_options);
            }
        }

        delete_option('wpra_options');

        // find all metas and update to reflect new data model
        $metas = App::$db->get_results("select post_id, meta_value from " . App::$db->prefix . "postmeta where meta_key = '_wpra_start_counts'");
        foreach ($metas as $meta) {
            if (empty($meta->meta_value)) {
                continue;
            }
            $fake_counts = maybe_unserialize($meta->meta_value);
            if (!empty($fake_counts)) {
                $new_data = [];
                foreach ($old_global_options['emojis'] as $r => $emoji_id) {
                    $new_data[$emoji_id] = isset($fake_counts[$r]) ? $fake_counts[$r] : 0;
                }
                update_post_meta($meta->post_id, '_wpra_start_counts', $new_data);
            }
        }

        // find all shortcodes and adapt for new data model
        $shortcodes = App::$db->get_results("select id, options from " . Config::$tbl_shortcodes);
        foreach ($shortcodes as $shortcode) {
            $old_sgc           = json_decode($shortcode->options, true);
            $new_sgc           = $old_sgc;
            $new_sgc['emojis'] = array_values($old_sgc['emojis']);

            if ($old_sgc['behavior'] == 'regular') {
                $new_sgc['social'] = array_merge($old_sgc['social'], [
                    "counter"        => "true",
                    "counter_size"   => "30px",
                    "counter_weight" => 700,
                    "counter_color"  => "#000000",
                ]);
            }

            if (isset($old_sgc['behavior'])) {
                $new_sgc['layout'] = $old_sgc['behavior'];
                unset($new_sgc['behavior']);
            }

            $new_sgc['start_counts']     = [];
            $new_sgc['flying']['labels'] = [];
            $i                           = 1;
            foreach ($new_sgc['emojis'] as $emoji_id) {
                $new_sgc['flying']['labels'][$emoji_id] = isset($old_sgc['flying']['labels']["reaction{$i}"]) ? $old_sgc['flying']['labels']["reaction{$i}"] : '';
                $old_start_counts                       = explode(',', $old_sgc['start_counts']);
                $new_sgc['start_counts'][$emoji_id]     = intval($old_start_counts[$i - 1]);
                $i++;
            }

            $new_sgc['count_percentage'] = isset($old_sgc['count_percentage']) ? $old_sgc['count_percentage'] : 'false';

            App::$db->update(
                Config::$tbl_shortcodes,
                ['options' => json_encode($new_sgc)],
                ['id' => $shortcode->id]
            );
        }
    }

    function version_2_6_10() {
        if (!get_option("wpra_options_disqus")) {
            Config::updateLayoutOptions('disqus', Config::getLayoutDefaults('disqus'));
        }
    }

    function version_2_6_20() {
        if (!get_option("wpra_options_jane")) {
            Config::updateLayoutOptions('jane', Config::getLayoutDefaults('jane'));
        }
    }

    function version_2_6_30() {
        foreach (Config::getLayoutNames() as $layout) {
            $layout_options                                = Config::getLayoutOptions($layout);
            $layout_options['random_fake_counts']          = 'false';
            $layout_options['social']['random_fake']       = 'false';
            $layout_options['social']['random_fake_range'] = '0-0';
            foreach ($layout_options['emojis'] as $emoji_id) {
                $layout_options['random_fake_counts_range'][$emoji_id] = '0-0';
            }
            Config::updateLayoutOptions($layout, $layout_options);
        }
    }

    function version_2_6_40() {
        App::$db->query("ALTER TABLE " . Config::$tbl_reacted_users . " ADD sgc_id bigint(20) NOT NULL DEFAULT 0");
        App::$db->query("ALTER TABLE " . Config::$tbl_social_stats . " ADD sgc_id bigint(20) NOT NULL DEFAULT 0");
    }

    function version_2_6_42() {
        foreach (Config::$layouts as $layout => $config) {
            $current = json_decode(get_option("wpra_options_$layout"), true);
            if (isset($current['name'])) {
                Config::updateLayoutOptions($layout, $config['defaults']);
            }
        }
    }

    function version_2_6_50() {
        App::$db->query("ALTER TABLE " . Config::$tbl_shortcodes . " DROP used_post_ids");
        App::$db->query("ALTER TABLE " . Config::$tbl_shortcodes . " ADD post_type varchar(100) AFTER bind_id");
        App::$db->update(
            Config::$tbl_shortcodes,
            ['post_type' => 'product'],
            ['id' => Config::$settings['woo_shortcode_id']]
        );
    }

    function version_2_6_80() {
        $post_types = Config::$settings['post_types'];
        foreach (Config::getLayoutNames() as $layout) {
            $options                             = Config::getLayoutOptions($layout);
            $options['post_types_deploy_auto']   = $post_types;
            $options['post_types_deploy_manual'] = [];
            Config::updateLayoutOptions($layout, $options);
        }
    }

    function version_2_6_81() {
        App::$db->query("ALTER TABLE " . Config::$tbl_shortcodes . " ADD front_render boolean NOT NULL DEFAULT true AFTER post_type");
    }

    function version_2_6_83() {
        $charset_collate = App::$db->get_charset_collate();

        $sql = "CREATE TABLE " . Config::$tbl_emojis . " (
    		id int NOT NULL AUTO_INCREMENT,
    		name varchar(500),
    		type enum('builtin', 'custom') NOT NULL,
    		format varchar(10) NOT NULL,
    		PRIMARY KEY  (id)
		) $charset_collate";

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);

        if (Emojis::getCount('builtin') == Config::MAX_EMOJI_ID) return;

        Query\Insert
            ::create()
            ->table(Config::$tbl_emojis)
            ->fields('name, type, format')
            ->multi()
            ->values(
                array_map(function ($name) {
                    return [$name, 'builtin', 'svg/json'];
                }, Config::$builtin_emojis)
            )
            ->run();
    }

    function version_3_0_00() {
        Notices::clearAll();

        if (BaseQuery::isColumnExist(App::$db, Config::$tbl_reacted_users, 'reacted_to')) {
            App::$db->query('ALTER TABLE ' . Config::$tbl_reacted_users . ' DROP reacted_to');
        }
        if (!BaseQuery::isColumnExist(App::$db, Config::$tbl_reacted_users, 'post_type')) {
            App::$db->query('ALTER TABLE ' . Config::$tbl_reacted_users . ' ADD post_type varchar(100) AFTER bind_id');
        }
        if (!BaseQuery::isColumnExist(App::$db, Config::$tbl_social_stats, 'post_type')) {
            App::$db->query('ALTER TABLE ' . Config::$tbl_social_stats . ' ADD post_type varchar(100) AFTER bind_id');
        }

        wp_schedule_single_event(time() + MINUTE_IN_SECONDS, 'wpra_update_post_type');
    }

    function version_3_0_15() {
        foreach (Config::$layouts as $layout => $config) {
            $options           = Config::getLayoutOptions($layout);
            $defaults          = $config['defaults'];
            $options['adjust'] = $defaults['adjust'];

            if ($layout == 'jane' || $layout == 'disqus') {
                $options['reaction_border_color_hover']  = $defaults['reaction_border_color_hover'];
                $options['reaction_border_color_active'] = $defaults['reaction_border_color_active'];
                $options['reaction_bg_color']            = $defaults['reaction_bg_color'];
                $options['reaction_bg_color_hover']      = $defaults['reaction_bg_color_hover'];
                $options['reaction_bg_color_active']     = $defaults['reaction_bg_color_active'];
                $options['label_text_color_hover']       = $defaults['label_text_color_hover'];
                $options['label_text_color_active']      = $defaults['label_text_color_active'];
                $options['count_text_color_hover']       = $defaults['count_text_color_hover'];
                $options['count_text_color_active']      = $defaults['count_text_color_active'];

                unset($options['reaction_color_active']);
            }

            if ($layout == 'regular' || $layout == 'button_reveal') {
                $options['count_pos_top']       = $defaults['count_pos_top'];
                $options['count_text_size']     = $defaults['count_text_size'];
                $options['count_text_weight']   = $defaults['count_text_weight'];
                $options['count_width']         = $defaults['count_width'];
                $options['count_height']        = $defaults['count_height'];
                $options['count_border_radius'] = $defaults['count_border_radius'];
            }

            Config::updateLayoutOptions($layout, $options);
        }

        $shortcodes = App::$db->get_results("select id, options from " . Config::$tbl_shortcodes);

        foreach ($shortcodes as $shortcode) {
            $sgc           = json_decode($shortcode->options, true);
            $sgc_defaults  = Config::getLayoutDefaults($sgc['layout']);
            $sgc['adjust'] = $sgc_defaults['adjust'];

            if ($sgc['layout'] == 'jane' || $sgc['layout'] == 'disqus') {
                $sgc['reaction_border_color_hover']  = $sgc_defaults['reaction_border_color_hover'];
                $sgc['reaction_border_color_active'] = $sgc_defaults['reaction_border_color_active'];
                $sgc['reaction_bg_color']            = $sgc_defaults['reaction_bg_color'];
                $sgc['reaction_bg_color_hover']      = $sgc_defaults['reaction_bg_color_hover'];
                $sgc['reaction_bg_color_active']     = $sgc_defaults['reaction_bg_color_active'];
                $sgc['label_text_color_hover']       = $sgc_defaults['label_text_color_hover'];
                $sgc['label_text_color_active']      = $sgc_defaults['label_text_color_active'];
                $sgc['count_text_color_hover']       = $sgc_defaults['count_text_color_hover'];
                $sgc['count_text_color_active']      = $sgc_defaults['count_text_color_active'];

                unset($sgc['reaction_color_active']);
            }

            if ($sgc['layout'] == 'regular' || $sgc['layout'] == 'button_reveal') {
                $sgc['count_pos_top']       = $sgc_defaults['count_pos_top'];
                $sgc['count_text_size']     = $sgc_defaults['count_text_size'];
                $sgc['count_text_weight']   = $sgc_defaults['count_text_weight'];
                $sgc['count_width']         = $sgc_defaults['count_width'];
                $sgc['count_height']        = $sgc_defaults['count_height'];
                $sgc['count_border_radius'] = $sgc_defaults['count_border_radius'];
            }

            App::$db->update(
                Config::$tbl_shortcodes,
                ['options' => json_encode($sgc)],
                ['id' => $shortcode->id]
            );
        }
    }

    function version_3_0_26() {
        $charset_collate = App::$db->get_charset_collate();

        $sql = "CREATE TABLE " . Config::$tbl_logs . " (
            id int NOT NULL AUTO_INCREMENT,
            source varchar(500),
            level tinyint (1),
            created TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
            log text NULL,
            PRIMARY KEY  (id)
        ) $charset_collate";

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);

        Config::updateSetting('log_level', 0);
    }

    function version_3_0_27() {
        App::$db->query('delete from '. Config::$tbl_logs);
    }

    function version_3_0_28() {
        if (!wp_next_scheduled('wpra_clear_logs')) {
            wp_schedule_event(time(), 'weekly', 'wpra_clear_logs');
        }
    }

    // tries to update post type in database in async way
    // version_3_0_00
    function update_post_types() {
        $reacts = App::$db->get_col("SELECT bind_id FROM " . Config::$tbl_reacted_users);
        $social = App::$db->get_col("SELECT bind_id FROM " . Config::$tbl_social_stats);

        foreach ($reacts as $bind_id) {
            $post_type = Utils::is_num($bind_id) ? Utils::get_post_type($bind_id) : null;

            Query\Update
                ::create()
                ->table(Config::$tbl_reacted_users)
                ->sets(['post_type' => $post_type])
                ->where(['bind_id' => $bind_id])
                ->run();
        }

        foreach ($social as $bind_id) {
            $post_type = Utils::is_num($bind_id) ? Utils::get_post_type($bind_id) : null;

            Query\Update
                ::create()
                ->table(Config::$tbl_social_stats)
                ->sets(['post_type' => $post_type])
                ->where(['bind_id' => $bind_id])
                ->run();
        }
    }
}
