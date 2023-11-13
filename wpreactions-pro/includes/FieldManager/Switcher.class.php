<?php

namespace WPRA\FieldManager;

class Switcher extends Field implements RenderField {
    private $pair;

    public static function create() {
        return new self();
    }

    public function setPair($pair) {
        $this->pair = $pair;
        return $this;
    }

    function render() {
        $checked = ($this->value === 'true' || $this->value === true) ? 'checked' : '';
        $pair    = empty($this->pair) ? '' : 'data-pair="' . $this->pair . '"';
        echo "<div class='wpe-switch-wrap $this->classes'>";

        if ($this->name != '') {
            echo "<input type='hidden' name='$this->name' value='false'>";
        }

        if ($this->label != '') {
            echo "<p class='wpe-switch-title'>$this->label</p>";
        }

        $disabled = $this->disabled ? 'disabled' : '';

        echo '<label class="wpe-switch">';
        echo "<input id='$this->id' name='$this->name' type='checkbox' class='wpe-switch-input' $checked $disabled value='true' $pair>";
        echo '<span class="wpe-switch-label" data-on="On" data-off="Off"></span>';
        echo '<span class="wpe-switch-handle"></span>';
        echo '</label></div>';
    }
}
