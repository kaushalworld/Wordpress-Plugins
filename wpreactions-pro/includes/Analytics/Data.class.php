<?php

namespace WPRA\Analytics;

use DateTime;
use wpdb;
use WPRA\Database\Query;
use WPRA\FieldManager\Select;

abstract class Data {
    const TABLE_COUNT = 10;

    /**
     * @return wpdb;
     */
    private static function wpdb() {
        return $GLOBALS['wpdb'];
    }

    private static function get_empty_interval_data($interval, $data) {
        if (strpos($interval, 'month')) {
            return self::get_empty_month_data($interval, $data);
        }
        if (strpos($interval, 'year')) {
            return self::get_empty_year_data($interval, $data);
        }
        if (strpos($interval, 'week')) {
            return self::get_empty_week_data($interval, $data);
        } else {
            return self::get_empty_data($interval, $data);
        }
    }

    private static function get_empty_year_data($interval, $data) {
        $result = [];

        $data_points = array_column($data, 'count', 'date');
        $d           = new DateTime('now');
        $year        = $d->format('Y');
        $month       = $d->format('n');

        for ($m = 1; $m <= $month; $m++) {
            $m        = $m < 10 ? '0' . $m : $m;
            $count    = isset($data_points["$year/$m"]) ? intval($data_points["$year/$m"]) : 0;
            $result[] = ["{$year}/{$m} GMT", $count];
        }

        return $result;
    }

    private static function get_empty_month_data($interval, $data) {
        $result = [];

        $data_points = array_column($data, 'count', 'date');

        $d = new DateTime('now');
        $d = $interval == Interval::LAST_MONTH
            ? $d->modify('-1 month')
            : $d;

        $year  = $d->format('Y');
        $month = $d->format('m');

        $days = $interval == Interval::LAST_MONTH
            ? $d->format('t')
            : $d->format('j');

        for ($day = 1; $day <= $days; $day++) {
            $day      = $day < 10 ? '0' . $day : $day;
            $count    = isset($data_points["$year/$month/$day"]) ? intval($data_points["$year/$month/$day"]) : 0;
            $result[] = ["{$year}/{$month}/{$day} GMT", $count];
        }

        return $result;
    }

    private static function get_empty_week_data($interval, $data) {
        $result = [];

        $data_points = array_column($data, 'count', 'date');

        $d    = new DateTime('now');
        $days = $interval == Interval::LAST_WEEK ? 7 : $d->format('N');

        $d = $interval == Interval::LAST_WEEK
            ? $d->modify('last sunday -7 days')
            : $d->modify('last sunday');

        for ($i = 1; $i <= $days; $i++) {
            $d->modify("+1 day");
            $day   = $d->format('d');
            $month = $d->format('m');
            $year  = $d->format('Y');

            $count    = isset($data_points["$year/$month/$day"]) ? intval($data_points["$year/$month/$day"]) : 0;
            $result[] = ["{$year}/{$month}/{$day} GMT", $count];
        }

        return $result;
    }

    private static function get_empty_data($interval, $data) {
        $result      = [];
        $data_points = array_column($data, 'count', 'date');

        if ($interval == Interval::LAST_30_DAYS) {
            $end_date  = new DateTime('now');
            $star_date = (new DateTime('now'))->modify('-30 days');
        } else {
            $date_range = explode('|', $interval);
            $star_date  = new DateTime($date_range[0]);
            $end_date   = new DateTime($date_range[1]);
        }

        $days = abs($star_date->diff($end_date)->format('%R%a')) + 1;

        for ($i = 1; $i <= $days; $i++) {
            $modified = $i == 1 ? $star_date : $star_date->modify('+1 day');
            $day      = $modified->format('d');
            $month    = $modified->format('m');
            $year     = $modified->format('Y');
            $count    = isset($data_points["$year/$month/$day"]) ? intval($data_points["$year/$month/$day"]) : 0;
            $result[] = ["{$year}/{$month}/{$day} GMT", $count];
        }

        return $result;
    }

    static function get_date_based($source, $sgc_id, $bind_id, $interval, $table_name, $date_field, $base_field, $values = '') {

        $query = Query\Select::create();
        $query->table($table_name)->orderBy('date');
        $where = [];

        if (!empty($values)) {
            $where[] = "$base_field in ($values)";
        }

        switch ($interval) {
            case Interval::THIS_YEAR:
                $query->fields("DATE_FORMAT($date_field, '#Y/#m') as date, count(*) as count");
                $query->groupBy("DATE_FORMAT($date_field, '#Y/#m')");
                $where[] = "YEAR($date_field) = YEAR(CURDATE())";
                break;
            case Interval::THIS_MONTH:
                $query->fields("DATE_FORMAT($date_field, '#Y/#m/#d') as date, count(*) as count");
                $query->groupBy("DATE_FORMAT($date_field, '#Y/#m/#d')");
                $where[] = "YEAR($date_field) = YEAR(CURDATE()) and MONTH($date_field) = MONTH(CURDATE())";
                break;
            case Interval::LAST_MONTH:
                $query->fields("DATE_FORMAT($date_field, '#Y/#m/#d') as date, count(*) as count");
                $query->groupBy("DATE_FORMAT($date_field, '#Y/#m/#d')");
                $where[] = "YEAR($date_field) = YEAR(CURDATE()) and MONTH($date_field) = MONTH(CURDATE()) - 1";
                break;
            case Interval::LAST_30_DAYS:
                $query->fields("DATE_FORMAT($date_field, '#Y/#m/#d') as date, count(*) as count");
                $query->groupBy("DATE_FORMAT($date_field, '#Y/#m/#d')");
                $where[] = "DATE_FORMAT($date_field, '#Y/#m/#d') BETWEEN CURDATE() - INTERVAL 30 DAY AND CURDATE()";
                break;
            case Interval::THIS_WEEK:
                $query->fields("DATE_FORMAT($date_field, '#Y/#m/#d') as date, count(*) as count");
                $query->where("WEEK($date_field) = WEEK(CURDATE())");
                $query->groupBy("DATE_FORMAT($date_field, '#Y/#m/#d')");
                break;
            case Interval::LAST_WEEK:
                $query->fields("DATE_FORMAT($date_field, '#Y/#m/#d') as date, count(*) as count");
                $query->groupBy("DATE_FORMAT($date_field, '#Y/#m/#d')");
                $where[] = "date_format($date_field, '#Y-#m-#d') between subdate(curdate(), WEEKDAY(curdate()) + 7) and subdate(curdate(), WEEKDAY(curdate()) + 1)";
                break;
            default: // custom interval
                $date_range = explode('|', $interval);
                $start_date = $date_range[0];
                $end_date   = $date_range[1];

                $query->fields("DATE_FORMAT($date_field, '#Y/#m/#d') as date, count(*) as count");
                $where[] = "date_format($date_field, '#Y-#m-#d') between DATE_FORMAT('$start_date', '#Y-#m-#d') and DATE_FORMAT('$end_date', '#Y-#m-#d')";
                $query->groupBy("DATE_FORMAT($date_field, '#Y/#m/#d')");
                break;
        }

        $where[] = "source = '$source'";
        if (!empty($sgc_id)) {
            $where[] = "(bind_id = '$bind_id' or sgc_id = '$sgc_id')";
        }

        $query->where(implode(' and ', $where));
        $query->output(ARRAY_A);
        $data = $query->run()->result();

        return self::get_empty_interval_data($interval, $data);
    }

    static function get_count_based($source, $sgc_id, $bind_id, $interval, $table_name, $date_field, $base_field, $values = '') {

        $query = Query\Select::create();
        $query->table($table_name)
            ->orderBy($base_field)
            ->fields("$base_field as base, count(*) as count")
            ->groupBy($base_field);

        $where = [];

        if (!empty($values)) {
            $where[] = "$base_field in ($values)";
        }

        switch ($interval) {
            case Interval::THIS_YEAR:
                $where[] = "YEAR($date_field) = YEAR(CURDATE())";
                break;
            case Interval::THIS_MONTH:
                $where[] = "YEAR($date_field) = YEAR(CURDATE()) and MONTH($date_field) = MONTH(CURDATE())";
                break;
            case Interval::LAST_MONTH:
                $where[] = "YEAR($date_field) = YEAR(CURDATE()) and MONTH($date_field) = MONTH(CURDATE()) - 1";
                break;
            case Interval::LAST_30_DAYS:
                $where[] = "DATE_FORMAT($date_field, '#Y-#m-#d') BETWEEN CURDATE() - INTERVAL 30 DAY AND CURDATE()";
                break;
            case Interval::THIS_WEEK:
                $where[] = "WEEK($date_field) = WEEK(CURDATE())";
                break;
            case Interval::LAST_WEEK:
                $where[] = "date_format($date_field, '#Y-#m-#d') between subdate(curdate(), WEEKDAY(curdate()) + 7) and subdate(curdate(), WEEKDAY(curdate()) + 1)";
                break;
            case Interval::ALL_TIME:
                break;
            default: // custom interval
                $date_range = explode('|', $interval);
                $start_date = $date_range[0];
                $end_date   = $date_range[1];
                $where[]    = "date_format($date_field, '#Y-#m-#d') between DATE_FORMAT('$start_date', '#Y-#m-#d') and DATE_FORMAT('$end_date', '#Y-#m-#d')";
                break;
        }

        $where[] = "source = '$source'";
        if (!empty($sgc_id)) {
            $where[] = "(bind_id = '$bind_id' or sgc_id = '$sgc_id')";
        }

        $query->where(implode(' and ', $where));

        return $query->run()->result();
    }

    static function get_table_data($data) {
        $defs = [
            'source'     => '',
            'sgc_id'     => 0,
            'bind_id'    => '',
            'table'      => '',
            'fields'     => '',
            'base'       => '',
            'page'       => 1,
            'filter_by'  => '',
            'filter_val' => '',
        ];

        $args = array_merge($defs, $data);

        $where = [];
        if (!empty($args['filter_val'])) {
            $where[] = "{$args['filter_by']} in ({$args['filter_val']})";
        }

        $where[] = "source = '{$args['source']}'";
        if (!empty($args['sgc_id'])) {
            $where[] = "(bind_id = '{$args['bind_id']}' or sgc_id = '{$args['sgc_id']}')";
        }

        $where_st = implode(' and  ', $where);

        $rows = Query\Select
            ::create()
            ->table($args['table'])
            ->fields($args['fields'])
            ->where($where_st)
            ->groupBy($args['base'])
            ->orderBy($args['base'])
            ->limit(self::TABLE_COUNT * ($args['page'] - 1), self::TABLE_COUNT)
            ->output(ARRAY_A)
            ->run()
            ->result();

        $total = Query\Select
            ::create()
            ->table($args['table'])
            ->fields("count(DISTINCT {$args['base']})")
            ->where($where_st)
            ->one()
            ->run()
            ->result();

        $page_last  = $total % self::TABLE_COUNT > 0 ? 1 : 0;
        $page_count = intval($total / self::TABLE_COUNT) + $page_last;

        return [
            'rows'       => $rows,
            'page_count' => $page_count,
        ];
    }
}