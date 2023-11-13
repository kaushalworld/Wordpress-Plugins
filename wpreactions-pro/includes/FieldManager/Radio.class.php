<?php

namespace WPRA\FieldManager;

use WPRA\Helpers\Utils;

class Radio extends Field implements RenderField {
    public $radios = [];
    public $checked = true;
    public $label_type = 'text';

    public static function create() {
        return new self();
    }

    public function setChecked($checked) {
        $this->checked = $checked;
        return $this;
    }

    public function setLabelType($label_type) {
        $this->label_type = $label_type;
        return $this;
    }

    public function addRadio(RadioItem $radioItem) {
        $this->radios[] = $radioItem;
        return $this;
    }

    public function addRadios($radios) {
        $this->radios = $radios;
        return $this;
    }

    function render() {
        $is_disabled = $this->disabled ? 'disabled' : '';

        /** @var RadioItem $radio */
        foreach ($this->radios as $radio) {
            $is_checked = $this->checked == $radio->getValue() ? 'checked' : '';
            $label      = $this->label_type == 'image' ? "<img src='{$radio->getLabel()}' alt=''>" : $radio->getLabel();

            echo "<div class='circle-radio $this->classes {$radio->getClasses()}' {$this->getDataAttrs()}>";
            echo "<input type='radio' name='$this->name' id='{$radio->getId()}' value='{$radio->getValue()}' class='$this->elem_classes' $is_checked $is_disabled>";
            echo "<label for='{$radio->getId()}'><span>$label</span></label>";
            if ($radio->elemAfter != '') echo $radio->elemAfter;
            if (!empty($radio->tooltip)) Utils::tooltip($radio->tooltip);
            echo "</div>";
        }
    }
}
