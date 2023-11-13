<?php

namespace WPRA\Database;

use WPRA\Helpers\Utils;

abstract class BaseQuery {
    protected $table;
    protected $where;
    protected $sql;
    protected $success = false;
    protected $affected_rows = 0;

    abstract function build();

    function run() {
        $this->build();

        return QueryRunner::create($this)->run();
    }

    function isSuccess() {
        return $this->success;
    }

    function setSuccess($success) {
        $this->success = $success;
    }

    function setAffectedRows($affected_rows) {
        $this->affected_rows = $affected_rows;
    }

    public function getAffectedRows() {
        return $this->affected_rows;
    }

    function table($table) {
        $this->table = $table;

        return $this;
    }

    function where($fields, $logic = 'and') {
        if (is_string($fields)) {
            $this->where = $fields;

            return $this;
        }

        $where       = '';
        $first_field = true;
        foreach ($fields as $field => $params) {
            if (is_array($params)) {
                $operand = $params[0];
                $value   = $params[1];

                if (count($params) == 3) {
                    $logic   = $params[0];
                    $operand = $params[1];
                    $value   = $params[2];
                }

                $value = is_array($value)
                    ? self::parenthesis_list($value)
                    : self::quote_value($value);
            } else {
                $operand = '=';
                $value   = self::quote_value($params);
            }

            $check = "$field $operand $value ";
            if (!$first_field) {
                $check = "$logic $check";
            }

            $where       .= $check;
            $first_field = false;
        }

        $this->where = trim($where);

        return $this;
    }

    function getSql() {
        return $this->sql;
    }

    static function parenthesis_list($values) {
        $result = array_map(function ($value) {
            return self::quote_value($value);
        }, $values);

        return '(' . implode(',', $result) . ')';
    }

    static function field_list($fields) {
        if (is_string($fields)) return $fields;

        return empty($fields) ? '*' : implode(',', $fields);
    }

    static function quote_value($value) {
        if (Utils::is_num($value)) {
            return $value;
        }

        if (is_null($value)) {
            return 'null';
        }

        return "'$value'";
    }

    static function isColumnExist($wpdb, $tbl, $col_name) {
        $col_uid = $wpdb->query("SHOW COLUMNS FROM $tbl LIKE '$col_name'");

        return !empty($col_uid);
    }
}