<?php

namespace WPRA\Database\Query;

use WPRA\Database\BaseQuery;

class Select extends BaseQuery {
    private $fields = '*';
    private $order;
    private $orderby;
    private $limit;
    private $groupby;
    private $type = 'all';
    private $output = OBJECT;
    private $result;

    static function create() {
        return new self();
    }

    function setResult($result) {
        $this->result = $result;
    }

    function result() {
        return $this->result;
    }

    function fields($fields) {
        $this->fields = $fields;

        return $this;
    }

    function orderby($orderby) {
        $this->orderby = $orderby;

        return $this;
    }

    function order($order) {
        $this->order = $order;

        return $this;
    }

    function limit($from, $to) {
        $this->limit = $from . ',' . $to;;

        return $this;
    }

    function groupby($groupby) {
        $this->groupby = $groupby;

        return $this;
    }

    function one() {
        $this->type = 'one';

        return $this;
    }

    function row() {
        $this->type = 'row';

        return $this;
    }

    function col() {
        $this->type = 'col';

        return $this;
    }

    function output($output) {
        $this->output = $output;

        return $this;
    }

    function getType() {
        return $this->type;
    }

    function getOutput() {
        return $this->output;
    }

    function build() {
        $fields    = self::field_list($this->fields);
        $this->sql = "select $fields from $this->table";

        if (!empty($this->where))
            $this->sql = sprintf($this->sql . ' where %s', $this->where);

        if (!empty($this->groupby))
            $this->sql = sprintf($this->sql . ' group by %s', $this->groupby);

        if (!empty($this->orderby))
            $this->sql = sprintf($this->sql . ' order by %s', $this->orderby);

        if (!empty($this->order))
            $this->sql = sprintf($this->sql . ' %s', $this->order);

        if (!empty($this->limit))
            $this->sql = sprintf($this->sql . ' limit %s', $this->limit);

        $this->sql = str_replace('#', '%', $this->sql);

        return $this;
    }
}