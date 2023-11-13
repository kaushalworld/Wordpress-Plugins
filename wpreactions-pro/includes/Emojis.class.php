<?php

namespace WPRA;

use WPRA\Database\Query;

class Emojis {

    static function get($type, $format = 'svg/json', $limit = 0) {
        $query = Query\Select
            ::create()
            ->table(Config::$tbl_emojis)
            ->where(['type' => $type, 'format' => $format]);

        $limit > 0 && $query->limit(0, $limit);

        return $query->run()->result();
    }

    static function getCount($type) {
        return Query\Select
            ::create()
            ->table(Config::$tbl_emojis)
            ->fields('count(*)')
            ->where(['type' => $type])
            ->one()
            ->run()
            ->result();
    }

    static function add($name, $format) {
        $query = Query\Insert
            ::create()
            ->table(Config::$tbl_emojis)
            ->fields('name, type, format')
            ->values([$name, 'custom', $format])
            ->run();

        return $query->getInsertId();
    }

    static function delete($id) {
        $format = self::getData([$id], ['format']);
        $upload = wp_upload_dir();
        $path   = $upload['basedir'] . '/wpreactions/emojis/';

        foreach (explode('/', $format) as $ext) {
            unlink($path . $ext . '/' . $id . '.' . $ext);
        }

        Analytics\Controller::deleteStats($id, false, false);

        return Query\Delete
            ::create()
            ->table(Config::$tbl_emojis)
            ->where(['id' => $id])
            ->run();
    }

    static function getData($emojis, $fields = []) {

        $res = Query\Select
            ::create()
            ->table(Config::$tbl_emojis)
            ->where(['id' => ['in', $emojis]])
            ->output(ARRAY_A)
            ->row()
            ->run()
            ->result();

        return count($fields) == 1 ? $res[$fields[0]] : $res;
    }

    static function getUrl($id, $format = 'svg/json', $part = 1) {
        $v      = '?v=' . WPRA_VERSION;
        $format = self::getExtension($format, $part);
        $type   = self::getType($id);

        return self::getBaseUrl($type) . $format . "/" . $id . "." . $format . $v;
    }

    static function getBaseUrl($type) {
        $url = WPRA_PLUGIN_URL . 'assets/emojis/';

        if ($type == 'custom') {
            $upload = wp_upload_dir();
            $url    = $upload['baseurl'] . '/wpreactions/emojis/';
        }

        return $url;
    }

    static function getType($id) {
        return $id > Config::MAX_EMOJI_ID ? 'custom' : 'builtin';
    }

    static function getExtension($format, $part = 1) {
        $slash = strpos($format, '/');
        if ($slash === false) return $format;

        return $part === 1
            ? substr($format, 0, $slash)
            : substr($format, $slash + 1, strlen($format));
    }
}