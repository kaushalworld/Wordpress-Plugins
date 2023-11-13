<?php

namespace WPRA\FieldManager;

use WPRA\Helpers\Utils;

class Checkbox extends Field implements RenderField {
    public $checkboxes = [];

    public static function create() {
        return new self();
    }

    public function addCheckbox($id, $value, $label, $checked = 'true', $tooltip = false, $disabled = false, $lottieAfter = false, $elemAfter = false) {
        $this->checkboxes[] = [
            'id'          => $id,
            'value'       => $value,
            'label'       => $label,
            'checked'     => $checked,
            'lottieAfter' => $lottieAfter,
            'elemAfter'   => $elemAfter,
            'tooltip'     => $tooltip,
            'disabled'    => $disabled,
        ];
        return $this;
    }

    public function render() {
        foreach ($this->checkboxes as $checkbox) {
            if ($checkbox['value'] == $checkbox['checked']) {
                $is_checked = 'checked';
            } else {
                $is_checked = '';
            }
            if ($checkbox['disabled']) {
                $is_disabled = 'disabled';
            } else {
                $is_disabled = '';
            }
            echo "<div class='$this->classes'>";
            echo "<div class='rectangle-checkbox'>";
            echo "<input type='checkbox' name='$this->name' id='{$checkbox["id"]}' value='{$checkbox["value"]}' class='$this->elem_classes' $is_checked $is_disabled>";
            echo "<label for='{$checkbox["id"]}'><span>{$checkbox["label"]}</span></label>";
            if ($checkbox['elemAfter']) {
                echo $checkbox['elemAfter'];
            }
            if ($checkbox['tooltip']) {
                Utils::tooltip($checkbox['tooltip']);
            }
            echo "</div>";
            echo "</div>";
        }
    }
}
