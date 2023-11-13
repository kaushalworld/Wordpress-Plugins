<?php

namespace WPRA\Database;

use WPRA\App;
use WPRA\Database\Query;

class QueryRunner {
    private $query;

    public function __construct($query) {
        $this->query = $query;
    }

    static function create($query) {
        return new self($query);
    }

    function run() {

        $result = false;

        if ($this->query instanceof Query\Select) {
            $type   = $this->query->getType();
            $output = $this->query->getOutput();
            $sql    = $this->query->getSql();

            if ($type == 'all') {
                $result = App::$db->get_results($sql, $output);
            }
            if ($type == 'one') {
                $result = App::$db->get_var($sql);
            }
            if ($type == 'row') {
                $result = App::$db->get_row($sql, $output);
            }
            if ($type == 'col') {
                $result = App::$db->get_col($sql);
            }

            $this->query->setResult($result);
        }

        if ($this->query instanceof Query\Insert) {
            $result = App::$db->query($this->query->getSql());
            $this->query->setInsertId(App::$db->insert_id);
        }

        if ($this->query instanceof Query\Delete) {
            $result = App::$db->query($this->query->getSql());
        }

        if ($this->query instanceof Query\Update) {
            $result = App::$db->query($this->query->getSql());
        }

        $this->query->setAffectedRows(App::$db->rows_affected);
        $this->query->setSuccess($result !== false);

        return $this->query;
    }
}