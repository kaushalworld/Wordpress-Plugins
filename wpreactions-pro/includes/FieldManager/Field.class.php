<?php

namespace WPRA\FieldManager;

abstract class Field {
    protected $name;
    protected $id;
    protected $label;
    protected $value;
    protected $classes;
    protected $disabled;
    protected $elemAfter;
    protected $elemBefore;
    protected $tooltip;
    protected $data;
    protected $elem_classes;
    protected $factory_value;

    public function addClasses($classes) {
        $this->classes = $classes;
        return $this;
    }

    public function addElemClasses($classes) {
        $this->elem_classes = $classes;
        return $this;
    }

    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    public function setLabel($label) {
        $this->label = $label;
        return $this;
    }

    public function setName($name) {
        $this->name = $name;
        return $this;
    }

    public function setValue($value) {
        $this->value = $value;
        return $this;
    }

    public function setFactoryValue($value) {
        $this->factory_value = $value;
        return $this;
    }

    public function setDisabled($disabled) {
        $this->disabled = $disabled;
        return $this;
    }

    public function getClasses() {
        return $this->classes;
    }

    public function getId() {
        return $this->id;
    }

    public function getLabel() {
        return $this->label;
    }

    public function getName() {
        return $this->name;
    }

    public function getValue() {
        return $this->value;
    }

    public function getDisabled() {
        return $this->disabled;
    }

    public function setTooltip($tooltip) {
        $this->tooltip = $tooltip;
        return $this;
    }

    public function setElemAfter($elemAfter) {
        $this->elemAfter = $elemAfter;
        return $this;
    }

    public function setElemBefore($elemBefore) {
        $this->elemBefore = $elemBefore;
        return $this;
    }

    public function getDataAttrs() {
        $data_attrs = '';
        if ($this->data != '') {
            foreach ($this->data as $data_key => $data_val) {
                $data_attrs .= 'data-' . $data_key . '="' . $data_val . '" ';
            }
        }

        return $data_attrs;
    }

    public function setData(array $data) {
        $this->data = $data;
        return $this;
    }
}