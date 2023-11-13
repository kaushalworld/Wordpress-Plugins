<?php

namespace LivemeshAddons\Modules;

class LAE_Module {

    public $source;

    function __construct($source) {

        $this->source = $source;
    }

    function get_module_classes() {

        return apply_filters('lae_block_module_classes', 'lae-module', $this);

    }

}