<?php

namespace WPRA\Database\Query;

use WPRA\Database\BaseQuery;

class Update extends BaseQuery {
    private $sets;

    static function create() {
        return new self();
    }

    function sets($sets) {
        $this->sets = $sets;

        return $this;
    }

    function build() {
        $this->sql = sprintf("update %s set", $this->table);

        foreach ($this->sets as $field => $value) {
            $value     = self::quote_value($value);
            $this->sql .= " $field = $value,";
        }

        $this->sql = rtrim($this->sql, ',');

        if (!empty($this->where)) {
            $this->sql = sprintf($this->sql . ' where %s', $this->where);
        }

        return $this;
    }
}