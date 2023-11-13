<?php

namespace WPRA\FieldManager;

class Text extends Field implements RenderField {
    public $type = 'text';
    private $placeholder = '';

    public static function create() {
        return new self();
    }

    public function setType($type) {
        $this->type = $type;
        return $this;
    }

    public function setPlaceholder($placeholder) {
        $this->placeholder = $placeholder;
        return $this;
    }

    function render() {
        $type        = $this->type;
        $is_disabled = $this->disabled ? 'disabled="disabled"' : '';
        $out         = '';
        if ($this->type != 'hidden' and $this->label != '') {
            $out .= "<label for='$this->id'>$this->label</label>";
        }
        if (!empty($this->elemBefore)) $out .= $this->elemBefore;
        $out .= "<input type='$type' name='$this->id' id='$this->id' placeholder='$this->placeholder' class='form-control $this->elem_classes' {$this->getDataAttrs()} value='$this->value' $is_disabled>";
        if (!empty($this->elemAfter)) $out .= $this->elemAfter;
        echo "<div class='$this->classes'>$out</div>";
    }
}
