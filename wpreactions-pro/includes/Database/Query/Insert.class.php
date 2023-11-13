<?php

namespace WPRA\Database\Query;

use WPRA\Database\BaseQuery;

class Insert extends BaseQuery {
    private $values;
    private $fields;
    private $insert_id = 0;
    private $type = 'single';

    static function create() {
        return new self();
    }

    function setInsertId($insert_id) {
        $this->insert_id = $insert_id;
    }

    public function getInsertId() {
        return $this->insert_id;
    }

    function multi() {
        $this->type = 'multi';

        return $this;
    }

    function values($values) {
        $this->values = $values;

        return $this;
    }

    function fields($fields) {
        $this->fields = $fields;

        return $this;
    }

    function build() {
        $values = '';
        if ($this->type == 'single') {

            if (empty($this->fields)) {
                $this->fields = array_keys($this->values);
                $this->values = array_values($this->values);
            }

            $values .= self::parenthesis_list($this->values);
        } else if ($this->type == 'multi') {
            foreach ($this->values as $value) {
                $this->sql .= self::parenthesis_list($value) . ',';
            }

            $values = rtrim($this->sql, ',');
        }

        $fields    = self::field_list($this->fields);
        $this->sql = sprintf("insert into %s (%s) values %s", $this->table, $fields, $values);

        return $this;
    }
}