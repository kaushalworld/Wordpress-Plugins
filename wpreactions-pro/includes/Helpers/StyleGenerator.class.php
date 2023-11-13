<?php

namespace WPRA\Helpers;

class StyleGenerator {

    private $style_id;
    private $parent_selector;
    private $style_items = [];

    public function __construct($style_id) {
        $this->style_id = $style_id;
    }

    function addStyle($selector, $style) {
        if (array_key_exists($selector, $this->style_items)) {
            $this->style_items[$selector] = array_merge($this->style_items[$selector], $style);
            return;
        }
        $this->style_items[$selector] = $style;
    }

    function setParentSelector($selector) {
        $this->parent_selector = $selector;
    }

    function output() {
        echo '<style id="' . $this->style_id . '">';

        foreach ($this->style_items as $selector => $style) {
            echo "$this->parent_selector $selector {";
            foreach ($style as $param => $value) {
                if (empty($param) || empty($value)) continue;
                echo "$param: $value;";
            }
            echo "} ";
        }

        echo '</style>';
    }
}