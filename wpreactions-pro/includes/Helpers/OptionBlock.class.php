<?php

namespace WPRA\Helpers;

use WPRA\Config;
use WPRA\Shortcode;

class OptionBlock {

    private static function getBlockOptions($layout) {

        if (Utils::isPage('global')) {
            $options = Config::getLayoutOptions($layout);
        } else if (Utils::check_query_var('sgc_action', 'edit')) {
            $sgc_id  = Utils::get_query_var('id');
            $options = Shortcode::getSgcDataBy('id', $sgc_id, ['options']);
        } else {
            $options = Config::getLayoutDefaults($layout);
        }

        return $options;
    }

    static function render($name, $data = [], $path = WPRA_PLUGIN_PATH) {
        $layout = Utils::get_query_var('layout');

        Utils::renderTemplate(
            "view/admin/option-blocks/$name",
            array_merge($data, [
                'options'  => self::getBlockOptions($layout),
                'defaults' => Config::getLayoutDefaults($layout),
                'layout'   => $layout,
            ]),
            false,
            $path
        );
    }
}