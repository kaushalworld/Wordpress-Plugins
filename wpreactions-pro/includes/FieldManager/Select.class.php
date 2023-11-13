<?php

namespace WPRA\FieldManager;

class Select extends Field implements RenderField {
    public $values = [];

    public static function create() {
        return new self();
    }

    public function setValues($values) {
        $this->values = $values;
        return $this;
    }

    public function setDefault($value, $label) {
        $this->values = array_merge([$value => $label], $this->values);
        return $this;
    }

    public function render() {
        $is_disabled = '';
        if ($this->disabled) {
            $is_disabled = 'disabled';
        }
        echo "<div class='$this->classes'>";
        if ($this->label != '') {
            echo "<label for='$this->id'>$this->label</label>";
        }
        echo "<select name='$this->id' id='$this->id' class='wpra-custom-select form-control $this->elem_classes' $is_disabled>";
        foreach ($this->values as $key => $value) {
            if ($this->value == $key) {
                $is_selected = 'selected';
            } else {
                $is_selected = '';
            }
            echo "<option value='$key' $is_selected>$value</option>";
        }
        echo "</select></div>";
    }
}
