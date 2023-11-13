<?php

namespace WPRA;

use WPRA\Database\BaseQuery;
use WPRA\Database\Query;

class Activation {

    public function __construct() {
        // reset alert after disable/enable of plugin
        add_option('wpra_dismiss_lk_alert', 'no');
        add_option('wpra_version', WPRA_VERSION);

        if (!get_option('wpra_layout')) {
            add_option('wpra_layout', 'regular');
        }

        if (!get_option('wpra_global_activation')) {
            add_option('wpra_global_activation', 'false');
        }

        // create options for each layout in wp_options
        foreach (Config::$layouts as $layout => $config) {
            if (!get_option("wpra_options_$layout")) {
                Config::updateLayoutOptions($layout, $config['defaults']);
            }
        }

        if (!get_option('wpra_settings')) {
            add_option('wpra_settings', json_encode(Config::$default_settings));
        }

        $this->create_databases();
        $this->insert_builtin_emojis();
        $this->add_caps();
        // register all crons
        App::instance()->cron()->registerAll();
    }

    function create_databases() {
        $db_ver = get_option('wpra_db_version', 0);

        if (version_compare(WPRA_DB_VERSION, $db_ver, '<=')) return;

        $sql = [];

        $charset_collate = App::$db->get_charset_collate();

        $sql[] = "CREATE TABLE " . Config::$tbl_reacted_users . " (
                id bigint NOT NULL AUTO_INCREMENT,
                bind_id varchar(100) NOT NULL,
            	post_type varchar(100),
                react_id varchar(100) NOT NULL,
                reacted_date datetime NOT NULL,
                source varchar(50) NOT NULL,
                emoji_id smallint NOT NULL,
                user_id bigint NOT NULL,
                sgc_id bigint NOT NULL,
                PRIMARY KEY  (id)
        ) $charset_collate;";

        $sql[] = "CREATE TABLE " . Config::$tbl_shortcodes . " (
                id bigint NOT NULL AUTO_INCREMENT,
                name varchar(100),
                bind_id varchar(100) NOT NULL,
                post_type varchar(100),
                front_render boolean NOT NULL DEFAULT true,
                options text,
                PRIMARY KEY  (id)
        ) $charset_collate;";

        $sql[] = "CREATE TABLE " . Config::$tbl_social_stats . " (
                id bigint NOT NULL AUTO_INCREMENT,
                bind_id varchar(100) NOT NULL,
                post_type varchar(100),
                platform varchar(50) NOT NULL,
                click_date datetime NOT NULL,
                source varchar(50) NOT NULL,
                user_id bigint NOT NULL,
                sgc_id bigint NOT NULL,
                PRIMARY KEY  (id)
        ) $charset_collate;";

        $sql[] = "CREATE TABLE " . Config::$tbl_emojis . " (
				id int NOT NULL AUTO_INCREMENT,
				name varchar(500),
				type enum('builtin', 'custom') NOT NULL,
				format varchar(10) NOT NULL,
				PRIMARY KEY  (id)
		) $charset_collate";

        $sql[] = "CREATE TABLE " . Config::$tbl_logs . " (
                id int NOT NULL AUTO_INCREMENT,
                source varchar(500),
                level tinyint (1),
                created TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
                log text NULL,
                PRIMARY KEY  (id)
        ) $charset_collate";

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

        foreach ($sql as $db_sql) {
            dbDelta($db_sql);
        }

        // if user come from lite plugin then add new columns
        // when lite version is updated add proper columns and remove this block
        if (get_option('wpra_lite_version') !== false) {
            if (!BaseQuery::isColumnExist(App::$db, Config::$tbl_reacted_users, 'source')) {
                App::$db->query("ALTER TABLE " . Config::$tbl_reacted_users . " ADD source varchar(50) NOT NULL DEFAULT ''");
            }
            if (!BaseQuery::isColumnExist(App::$db, Config::$tbl_reacted_users, 'emoji_id')) {
                App::$db->query("ALTER TABLE " . Config::$tbl_reacted_users . " ADD emoji_id smallint NOT NULL DEFAULT 0");
            }
            if (!BaseQuery::isColumnExist(App::$db, Config::$tbl_reacted_users, 'user_id')) {
                App::$db->query("ALTER TABLE " . Config::$tbl_reacted_users . " ADD user_id bigint(20) NOT NULL DEFAULT 0");
            }
        }

        update_option('wpra_db_version', WPRA_DB_VERSION);
    }

    function add_caps() {
        $role = get_role('administrator');
        if ($role !== null) {
            $role->add_cap('access_wpreactions');
            $role->add_cap('edit_wpreactions');
        }
    }

    function insert_builtin_emojis() {
        if (Emojis::getCount('builtin') >= Config::MAX_EMOJI_ID) return;

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

    static function start() {
        return new self();
    }
}
