<?php

namespace WPRA\Helpers;

use WPRA\Database\Query;
use WPRA\Config;

class Logger {

    private const LEVELS = [
        'error' => 1,
        'warn' => 2,
        'info' => 3,
        'debug' => 4,
    ];

    static function debug($source, $log, $php_error_log = false) {
        self::add(self::LEVELS['debug'], $source, $log, $php_error_log);
    }

    static function info($source, $log, $php_error_log = false) {
        self::add(self::LEVELS['info'], $source, $log, $php_error_log);
    }

    static function warn($source, $log, $php_error_log = false) {
        self::add(self::LEVELS['warn'], $source, $log, $php_error_log);
    }

    static function error($source, $log, $php_error_log = false) {
        self::add(self::LEVELS['error'], $source, $log, $php_error_log);
    }

    private static function add($level, $source, $log, $php_error_log = false) {

        if ($level > Config::$settings['log_level']) return;

        if (is_array($log) || is_object($log)) {
            $log = base64_encode(serialize($log));
        }

        Query\Insert
            ::create()
            ->table(Config::$tbl_logs)
            ->fields('source, level, log')
            ->values([$source, $level, esc_sql($log)])
            ->run();

        if ($php_error_log) {
            error_log($log);
        }
    }

    static function generate_csv() {
        $logs = Query\Select
            ::create()
            ->table(Config::$tbl_logs)
            ->orderby('created')
            ->output(ARRAY_A)
            ->run()
            ->result();

        $fp = fopen('php://output', 'w');

        fputcsv($fp, ['ID', 'Source', 'Level', 'Created', 'Log base64 encoded']);

        foreach ($logs as $log) {
            fputcsv($fp, $log);
        }
            
        fclose($fp);
    }

    static function clear_logs() {
        Query\Delete
            ::create()
            ->table(Config::$tbl_logs)
            ->where(['created' => ['<', date('Y-m-d H:i:s', time() - WEEK_IN_SECONDS)]])
            ->run();
    }
}