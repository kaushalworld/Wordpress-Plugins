<?php

namespace WPRA;

use WPRA\Database\Query;
use WPRA\Helpers\Utils;

class Shortcode {

    static function register() {
        add_shortcode('wpreactions', [__CLASS__, 'handle']);
    }

    static function build($atts = []) {
        global $post;

        if (isset($atts['sgc_id'])) {
            if (!Utils::is_num($atts['sgc_id'])) {
                return '<p style="color: red;">' . __('ERROR: Invalid Shortcode ID provided. Please check and correct.', 'wpreactions') . '</p>';
            }
            $sgc = self::getSgcDataBy('id', $atts["sgc_id"], ['options', 'bind_id']);
            if (empty($sgc)) {
                return '<p style="color: red;">' . __('ERROR: Provided Shortcode ID not found. Please check and correct.', 'wpreactions') . '</p>';
            }
            $params            = $sgc->options;
            $params['sgc_id']  = $atts['sgc_id'];
            $params['bind_id'] = empty($atts['bind_id']) ? $sgc->bind_id : $atts['bind_id'];

            if (isset($atts['bind_to_post']) && $atts['bind_to_post'] == 'yes') {
                $params['bind_id']              = $post->ID;
                $params['start_counts']         = [];
                $params['social']['fake_count'] = 0;
            }

            if (isset($atts['bind_to_post']) && $atts['bind_to_post'] == 'no' && empty($params['bind_id'])) {
                return '<p style="color: red;">' . __('Please provide unique bind_id parameter. It can not be empty!', 'wpreactions') . '</p>';
            }

            $params['print_style'] = isset($atts['print_style']) ? $atts['print_style'] : 'false';

            return self::output($params);
        }

        // Assume all options provided along with bind_id
        if (isset($atts['bind_id'])) {
            return self::output($atts);
        }

        // if no sgc_id or bind_id provided then show global activation emojis
        $params            = Config::$active_layout_opts;
        $params['bind_id'] = $post->ID;

        return self::output($params);
    }

    private static function output($params) {
        $defaults = [
            'bind_id'      => 0,
            'sgc_id'       => 0,
            'start_counts' => [],
            'print_style'  => 'false',
        ];

        $params = array_merge($defaults, $params);
        $params = apply_filters('wpreactions/output/params', $params);

        if ($params['print_style'] == 'true') {
            Enqueue::printStyle("sgc-{$params['sgc_id']}", ".wpra-plugin-container[data-sgc_id=\"{$params['sgc_id']}\"]", $params);
        }

        $out = Utils::getTemplate("view/front/layouts/render", ['params' => $params]);
        $out = Utils::sanitize_string($out);

        return apply_filters('wpreactions/output', $out, $params);
    }

    static function handle($atts = []) {

        if (!App::instance()->license()->is_allowed()) {
            return (current_user_can('administrator') && get_option('wpra_dismiss_lk_alert') != 'yes')
                ? Utils::getTemplate('view/front/no-license-alert')
                : '';
        }

        return self::build($atts);
    } // end of shortcode handler

    static function listShortcodes($input, $is_nav = false) {
        $shortcodes = $is_nav ? self::navigateShortcodes($input) : self::searchShortcode($input);

        if (empty($shortcodes)) {
            $not_found_message = Utils::is_num($input)
                ? __('You have no any shortcode. Go to Shortcode Generator and make!', 'wpreactions')
                : __('Sorry! No shortcode found for <strong>' . $input . '</strong>', 'wpreactions');

            return '<p class="p-3">' . $not_found_message . '</p>';
        }

        return Helpers\Utils::getTemplate('view/admin/my-shortcodes/table', ['shortcodes' => $shortcodes]);
    }

    static function searchShortcode($needle = '', $fields = [], $type = OBJECT) {
        $query = Query\Select
            ::create()
            ->table(Config::$tbl_shortcodes)
            ->fields($fields)
            ->output($type);

        if (Utils::is_num($needle)) {
            $query->where(['id' => $needle]);
        } else if (!empty($needle)) {
            $query->where(['name' => ['like', "%$needle%"]]);
        }

        $shortcodes = $query->run()->result();

        return is_null($shortcodes) ? [] : $shortcodes;
    }

    static function getIdNamePairs() {
        $shortcodes = [];
        foreach (Shortcode::searchShortcode('', ['id', 'name']) as $shortcode) {
            $name                       = empty($shortcode->name) ? __('Unnamed shortcode', 'wpreactions') : "$shortcode->name";
            $shortcodes[$shortcode->id] = $shortcode->id . ' - ' . $name;
        }

        return $shortcodes;
    }

    static function navigateShortcodes($page = 1, $count = Config::MY_SHORTCODES_PAGE_LIMIT) {
        $start = ($page - 1) * $count;

        $query = Query\Select
            ::create()
            ->table(Config::$tbl_shortcodes)
            ->orderby('id')
            ->order('DESC');

        $count > 0 && $query->limit($start, $count);

        $shortcodes = $query->run()->result();

        return is_null($shortcodes) ? [] : $shortcodes;
    }

    static function cloneShortcode($sgc_id) {
        $sgc = Query\Select
            ::create()
            ->table(Config::$tbl_shortcodes)
            ->fields('name, options')
            ->where(['id' => $sgc_id])
            ->row()
            ->run()
            ->result();

        if (!empty($sgc)) {
            $name = strlen($sgc->name) < 90 ? $sgc->name . ' - Copy' : $sgc->name;
            $res  = App::$db->insert(
                Config::$tbl_shortcodes,
                [
                    'bind_id' => uniqid(),
                    'options' => $sgc->options,
                    'name'    => $name,
                ]
            );

            do_action('wpreactions/shortcode/clone', $res);

            return $res !== false;
        }

        return false;
    }

    static function deleteShortcode($sgc_id) {
        $bind_id = self::getSgcDataBy('id', $sgc_id, ['bind_id']);

        $res = App::$db->delete(
            Config::$tbl_shortcodes,
            ['id' => $sgc_id]
        );

        if ($res !== false) {
            Analytics\Controller::deleteStats(false, false, $sgc_id);
            Config::updateSetting('woo_shortcode_id', 0);
        }

        do_action('wpreactions/shortcode/delete', $bind_id, $sgc_id, $res);

        return $res !== false;
    }

    static function saveShortcodeData($options, $id, $name, $post_type, $front_render) {

        $data = [
            'options'      => json_encode($options),
            'name'         => $name,
            'post_type'    => $post_type,
            'front_render' => $front_render,
        ];

        // if this post type is already bound to any post sgc, reset them
        if (!is_null($post_type)) {
            App::$db->update(Config::$tbl_shortcodes, ['post_type' => null], ['post_type' => $post_type]);
        }

        if ($id == 0) {
            $data['bind_id'] = uniqid();
            $res             = App::$db->insert(Config::$tbl_shortcodes, $data);
            $id              = $res ? App::$db->insert_id : 0;
        } else {
            App::$db->update(Config::$tbl_shortcodes, $data, ['id' => $id]);
        }

        // if sgc was used for woo before and now user change it to anything else
        if ($id == Config::$settings['woo_shortcode_id'] && $post_type != 'product') {
            Config::updateSetting('woo_shortcode_id', 0);
        }

        // if user wants to the sgc as woo then update settings accordingly
        if ($post_type == 'product') {
            Config::updateSetting('woo_shortcode_id', $id);
        }

        do_action('wpreactions/shortcode/save', $data);

        return $id;
    }

    static function updateShortcodePostType($id, $post_type) {
        App::$db->update(Config::$tbl_shortcodes, ['post_type' => null], ['post_type' => $post_type]);
        App::$db->update(Config::$tbl_shortcodes, ['post_type' => $post_type], ['id' => $id]);
    }

    static function getSgcDataBy($by, $value, $fields = []) {
        $sgc = Query\Select
            ::create()
            ->table(Config::$tbl_shortcodes)
            ->fields($fields)
            ->where([$by => $value])
            ->row()
            ->run()
            ->result();

        if (isset($sgc->options)) {
            $sgc->options = json_decode($sgc->options, true);
        }

        if (!is_null($sgc) && count($fields) == 1) {
            return $sgc->{$fields[0]};
        }

        return $sgc;
    }

    static function getBindPostTypes() {
        return Query\Select
            ::create()
            ->table(Config::$tbl_shortcodes)
            ->fields('distinct post_type')
            ->col()
            ->run()
            ->result();
    }

    static function getCount() {
        $count = Query\Select
            ::create()
            ->table(Config::$tbl_shortcodes)
            ->fields('count(*)')
            ->one()
            ->run()
            ->result();

        return empty($count) ? 0 : $count;
    }

    static function getAll($fields = '*') {
        return Query\Select
            ::create()
            ->table(Config::$tbl_shortcodes)
            ->fields($fields)
            ->run()
            ->result();
    }

    static function extract($post) {
        preg_match_all('/\[wpreactions sgc_id="\d+".*]/', $post->post_content, $matches);

        return array_unique($matches[0]);
    }

    static function toSgcId($shortcode) {
        preg_match('/\d+/', $shortcode, $sgc_id_matches);
        return $sgc_id_matches ? intval($sgc_id_matches[0]) : 0;
    }
} // end of class