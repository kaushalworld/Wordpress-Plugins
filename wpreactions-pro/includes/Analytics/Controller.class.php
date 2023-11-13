<?php

namespace WPRA\Analytics;

use WPRA\App;
use WPRA\Config;
use WPRA\Database\Query;
use WPRA\Helpers\Utils;
use WPRA\Shortcode;
use wpdb;

class Controller {

    private $options;
    private $source;
    private $bind_id;
    private $sgc_id;

    public static function getFor($source, $sgc_id = 0) {
        $instance          = new self();
        $instance->source  = $source;
        $instance->options = Config::$active_layout_opts;
        if ($source == 'shortcode') {
            $sgc_data          = Shortcode::getSgcDataBy('id', $sgc_id, ['options', 'bind_id']);
            $instance->options = $sgc_data->options;
            $instance->bind_id = $sgc_data->bind_id;
            $instance->sgc_id  = $sgc_id;
        }

        return $instance;
    }

    /**
     * @return wpdb;
     */
    private static function wpdb() {
        return $GLOBALS['wpdb'];
    }

    function reactions_counts($interval) {
        $result = [];

        $data = Data::get_count_based(
            $this->source,
            $this->sgc_id,
            $this->bind_id,
            $interval,
            Config::$tbl_reacted_users,
            'reacted_date',
            'emoji_id',
            $this->options['picked_emojis']
        );

        $data = array_column($data, 'count', 'base');

        foreach ($this->options['emojis'] as $emoji_id) {
            $result[] = [
                'x' => $this->options['flying']['labels'][$emoji_id],
                'y' => intval(isset($data[$emoji_id]) ? $data[$emoji_id] : 0),
            ];
        }

        return $result;
    }

    function social_counts($interval) {
        $result = [];

        $data = Data::get_count_based(
            $this->source,
            $this->sgc_id,
            $this->bind_id,
            $interval,
            Config::$tbl_social_stats,
            'click_date',
            'platform'
        );

        $data = array_column($data, 'count', 'base');

        foreach ($this->options['social_labels'] as $platform => $label) {
            $result[] = [
                'x' => $label,
                'y' => intval(isset($data[$platform]) ? $data[$platform] : 0),
            ];
        }

        return $result;
    }

    function emotional_data() {
        $data = Data::get_count_based(
            $this->source,
            $this->sgc_id,
            $this->bind_id,
            Interval::ALL_TIME,
            Config::$tbl_reacted_users,
            'reacted_date',
            'emoji_id',
            $this->options['picked_emojis']
        );

        $data  = array_column($data, 'count', 'base');
        $total = array_sum($data);

        if ($total == 0) {
            return Utils::zeroArray(sizeof($this->options['emojis']));
        }

        $result = [];

        foreach ($this->options['emojis'] as $emoji_id) {
            $count    = isset($data[$emoji_id]) ? $data[$emoji_id] : 0;
            $result[] = round($count * 100 / $total, 2);
        }

        return $result;
    }

    function get_emotional_data_view() {
        return Utils::getTemplate(
            'view/admin/analytics/emotional-data',
            [
                'options'        => $this->options,
                'emotional_data' => $this->emotional_data(),
            ]
        );
    }

    function get_social_data_view() {
        $data = Data::get_count_based(
            $this->source,
            $this->sgc_id,
            $this->bind_id,
            Interval::ALL_TIME,
            Config::$tbl_social_stats,
            'click_date',
            'platform'
        );

        $social_data = array_column($data, 'count', 'base');

        return Utils::getTemplate(
            'view/admin/analytics/social-share-platforms',
            [
                'social_data' => $social_data,
                'options'     => $this->options,
            ]
        );
    }

    function reactions_line($interval) {
        return Data::get_date_based(
            $this->source,
            $this->sgc_id,
            $this->bind_id,
            $interval,
            Config::$tbl_reacted_users,
            'reacted_date',
            'emoji_id',
            $this->options['picked_emojis']
        );
    }

    function social_share_line($interval) {
        return Data::get_date_based(
            $this->source,
            $this->sgc_id,
            $this->bind_id,
            $interval,
            Config::$tbl_social_stats,
            'click_date',
            'platform'
        );
    }

    function navigate_reactions_table($page = 1) {
        $fields = "bind_id";
        foreach ($this->options['emojis'] as $emoji_id) {
            if ($emoji_id == -1) {
                continue;
            }
            $fields .= ",count(case when emoji_id = '$emoji_id' then emoji_id end) as '$emoji_id'";
        }

        return Data::get_table_data(
            [
                'source'     => $this->source,
                'sgc_id'     => $this->sgc_id,
                'bind_id'    => $this->bind_id,
                'table'      => Config::$tbl_reacted_users,
                'fields'     => $fields,
                'base'       => 'bind_id',
                'filter_by'  => 'emoji_id',
                'filter_val' => $this->options['picked_emojis'],
                'page'       => $page,
            ]
        );
    }

    function navigate_reactions_user_table($page = 1) {
        $fields = "user_id";
        foreach ($this->options['emojis'] as $emoji_id) {
            if ($emoji_id == -1) {
                continue;
            }
            $fields .= ",count(case when emoji_id = '$emoji_id' then emoji_id end) as '$emoji_id'";
        }

        return Data::get_table_data(
            [
                'source'     => $this->source,
                'sgc_id'     => $this->sgc_id,
                'bind_id'    => $this->bind_id,
                'table'      => Config::$tbl_reacted_users,
                'fields'     => $fields,
                'base'       => 'user_id',
                'filter_by'  => 'emoji_id',
                'filter_val' => $this->options['picked_emojis'],
                'page'       => $page,
            ]
        );
    }

    function navigate_social_table($page = 1) {
        $fields = "bind_id";
        foreach ($this->options['social_labels'] as $platform => $label) {
            $fields .= ",count(case when platform = '$platform' then platform end) as $platform";
        }

        return Data::get_table_data(
            [
                'source'  => $this->source,
                'sgc_id'  => $this->sgc_id,
                'bind_id' => $this->bind_id,
                'table'   => Config::$tbl_social_stats,
                'fields'  => $fields,
                'base'    => 'bind_id',
                'page'    => $page,
            ]
        );
    }

    function navigate_social_user_table($page = 1) {
        $fields = "user_id";
        foreach ($this->options['social_labels'] as $platform => $label) {
            $fields .= ",count(case when platform = '$platform' then platform end) as $platform";
        }

        return Data::get_table_data(
            [
                'source'  => $this->source,
                'sgc_id'  => $this->sgc_id,
                'bind_id' => $this->bind_id,
                'table'   => Config::$tbl_social_stats,
                'fields'  => $fields,
                'base'    => 'user_id',
                'page'    => $page,
            ]
        );
    }

    function get_reactions_table($page) {
        $table = $this->navigate_reactions_table($page);
        if (self::is_standalone_sgc($table)) {
            return sprintf('<p class="text-center color-grey m-0"><strong>"Shortcode ID %s"</strong> is standalone and have no post/page reactions data</p>', $this->sgc_id);
        }

        return Utils::getTemplate(
            'view/admin/analytics/tables/reactions',
            [
                'table'   => $table,
                'options' => $this->options,
            ]
        );
    }

    function get_social_table($page) {
        $table = $this->navigate_social_table($page);
        if (self::is_standalone_sgc($table)) {
            return sprintf('<p class="text-center color-grey m-0"><strong>"Shortcode ID %s"</strong> is standalone and have no post/page social data</p>', $this->sgc_id);
        }

        return Utils::getTemplate(
            'view/admin/analytics/tables/social',
            [
                'table'   => $table,
                'options' => $this->options,
            ]
        );
    }

    function get_reactions_user_table($page) {
        $table = $this->navigate_reactions_user_table($page);

        return Utils::getTemplate(
            'view/admin/analytics/tables/reactions-user',
            [
                'table'   => $table,
                'options' => $this->options,
            ]
        );
    }

    function get_social_user_table($page) {
        $table = $this->navigate_social_user_table($page);

        return Utils::getTemplate(
            'view/admin/analytics/tables/social-user',
            [
                'table'   => $table,
                'options' => $this->options,
            ]
        );
    }

    private static function is_standalone_sgc($table) {
        return count($table['rows']) == 1 && !Utils::is_num($table['rows'][0]['bind_id']);
    }

    static function deleteStats($emoji_id, $bind_id, $sgc_id) {
        $query_reactions = Query\Delete
            ::create()
            ->table(Config::$tbl_reacted_users);

        $query_social = Query\Delete
            ::create()
            ->table(Config::$tbl_reacted_users);

        if ($emoji_id !== false) {
            $query_reactions->where(['emoji_id' => $emoji_id]);
        }

        if ($bind_id !== false) {
            $query_reactions->where(['bind_id' => $bind_id]);
            $query_social->where(['bind_id' => $bind_id]);
        }

        if ($sgc_id !== false) {
            $query_reactions->where(['sgc_id' => $sgc_id]);
            $query_social->where(['sgc_id' => $sgc_id]);
        }

        $query_reactions->run();
        $query_social->run();
    }

    static function sync($options) {
        // emoji has been removed and user chosen too reset its data to zero
        if (isset($options['action']) && $options['action'] == 'reset'):
            Query\Delete
                ::create()
                ->table(Config::$tbl_reacted_users)
                ->where([
                    'source'   => 'global',
                    'emoji_id' => ['and', 'in', $options['removed_emojis']],
                ])
                ->run();
        endif;

        // handles user data migration
        if (isset($options['action']) && $options['action'] == 'keep'):
            foreach ($options['user_migration'] as $migration):
                Query\Update
                    ::create()
                    ->table(Config::$tbl_reacted_users)
                    ->sets(['emoji_id' => $migration['to']])
                    ->where([
                        'source'   => 'global',
                        'emoji_id' => ['and', 'in', $migration['from']],
                    ])
                    ->run();
            endforeach;
        endif;
    }
}