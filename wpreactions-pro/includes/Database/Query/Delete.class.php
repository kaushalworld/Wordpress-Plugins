<?php

namespace WPRA\Database\Query;

use WPRA\Database\BaseQuery;

class Delete extends BaseQuery {

    static function create() {
        return new self();
    }

    function build() {
        $this->sql = sprintf("delete from %s", $this->table);

        if (!empty($this->where)) {
            $this->sql = sprintf($this->sql . ' where %s', $this->where);
        }

        return $this;
    }
}