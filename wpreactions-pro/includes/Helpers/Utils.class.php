<?php

namespace WPRA\Helpers;

class Utils {

    static function renderTemplate($name, $data = [], $once = false, $plugin_path = WPRA_PLUGIN_PATH) {
        $data = array_merge($data, ['layout' => Utils::get_query_var('layout')]);
        $file = $plugin_path . $name . '.php';

        if (!file_exists($file)) {
            return;
        }

        if ($once) {
            require_once($file);
        } else {
            require($file);
        }
    }

    static function getTemplate($name, $data = [], $once = false, $plugin_path = WPRA_PLUGIN_PATH) {
        ob_start();
        self::renderTemplate($name, $data, $once, $plugin_path);

        return ob_get_clean();
    }

    static function renderTemplateIf($condition, $name, $data = [], $once = false, $plugin_path = WPRA_PLUGIN_PATH) {
        if ($condition) {
            self::renderTemplate($name, $data, $once, $plugin_path);
        }
    }

    static function getSocialIcon($name, $color, $override) {
        $file = WPRA_PLUGIN_PATH . 'view/admin/social-icons/' . $name . '.php';
        if (file_exists($file)) {
            require($file);
        }
    }

    static function getAsset($name, $path = WPRA_PLUGIN_URL) {
        $v = '?v=' . WPRA_VERSION;

        return $path . 'assets/' . $name . $v;
    }

    static function pixels($start, $step = 1, $stop = 60) {
        $sizes = [];
        for ($i = $start; $i <= $stop; $i += $step) {
            $sizes[$i . 'px'] = $i . 'px';
        }

        return $sizes;
    }

    static function isPage($page) {
        return isset($_GET['page']) && strpos($_GET['page'], $page) !== false;
    }

    static function check_query_var($name, $value) {
        if (isset($_GET[$name]) and $_GET[$name] == $value) {
            return true;
        }

        return false;
    }

    static function has_query_var($name) {
        return isset($_GET[$name]);
    }

    static function get_query_var($name, $default = '') {
        if (isset($_GET[$name])) {
            return $_GET[$name];
        }

        return $default;
    }

    static function getAdminPage($page, $params = [], $hash = '') {
        $pages = [
            'dashboard'      => 'wpra-dashboard',
            'global'         => 'wpra-global-options',
            'shortcode'      => 'wpra-shortcode-generator',
            'shortcode-edit' => 'wpra-my-shortcodes',
            'settings'       => 'wpra-settings',
            'analytics'      => 'wpra-analytics',
            'tools'          => 'wpra-tools',
        ];

        if (empty($params)) {
            return self::admin_url('admin.php?page=' . $pages[$page] . $hash);
        }

        $string_params = '';
        foreach ($params as $name => $val) {
            $string_params .= '&' . $name . '=' . $val;
        }

        return self::admin_url('admin.php?page=' . $pages[$page] . $string_params . $hash);
    }

    static function isWpraAdmin() {
        $screen = get_current_screen();

        return strpos($screen->id, 'wpra') !== false;
    }

    static function is_disabled($condition) {
        if ($condition) {
            echo ' disabled ';
        } else {
            echo '';
        }
    }

    static function tooltip($name, $plugin_path = WPRA_PLUGIN_PATH) {
        if (!file_exists($plugin_path . "view/admin/tooltips/$name.php")) return;
        $text = self::getTemplate("view/admin/tooltips/$name", [], true, $plugin_path);
        $text = str_replace('{ADMIN_URL}', Utils::admin_url('admin.php'), $text); ?>
        <div class="wpra-tooltip wpra-tooltip__<?php echo $name; ?>">
            <span class="wpra-tooltip-icon" style="background-image: url('<?php echo Utils::getAsset('images/tooltip_icon.svg'); ?>')"></span>
            <div class="wpra-tooltip-content-wrap">
                <div class="wpra-tooltip-content">
                    <?php echo apply_filters('wpreactions/tooltip/content', $text, $name); ?>
                </div>
            </div>
        </div>
        <?php
    }

    static function linkToDoc($doc, $topic = '') {
        $link = "https://helpdesk.wpreactions.com/?doc=$doc";
        !empty($topic) && $link .= "&topic=$topic";
        echo $link;
    }

    static function guide($title, $name, $plugin_path = WPRA_PLUGIN_PATH) {
        if (!file_exists($plugin_path . "view/admin/guides/$name.php")) return;
        $text = self::getTemplate("view/admin/guides/$name", [], true, $plugin_path);
        $text = str_replace('{ADMIN_URL}', Utils::admin_url('admin.php'), $text); ?>
        <div class="wpra-guide-box" id="wpra-<?php echo $name; ?>">
            <div class="wpra-guide-box-header">
                <i class="dashicons dashicons-flag"></i>
                <span><?php echo $title; ?></span>
            </div>
            <div class="wpra-guide-box-content">
                <?php echo $text; ?>
                <div class="wpra-guide-box-nav">
                    <span class="wpra-guide-box-dismiss">Dismiss</span>
                    <div>
                        <span class="wpra-guide-box-prev">< Prev</span>
                        <span class="wpra-guide-box-next">Next ></span>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }

    static function formatCount($count, $is_percentage = 'false', $total = 0) {
        if ($is_percentage == 'true') {
            $percentage = $total == 0 ? 0 : $count * 100 / $total;

            return round($percentage, 0) . '%';
        }
        $format = $count;
        if ($count >= 1000000) {
            $format = round(($count / 1000000), 1) . 'M';
        } else if ($count >= 1000) {
            $format = round(($count / 1000), 1) . 'K';
        }

        return $format;
    }

    static function echoIf($condition, $if_true, $if_false = '') {
        if (in_array($condition, [true, 1, '1', 'true', 'yes'])) {
            echo $if_true;
        } else {
            echo $if_false;
        }
    }

    static function renderIf($condition, $if_true, $if_false = '') {
        self::echoIf($condition, $if_true, $if_false);
    }

    static function flexAlign($align) {
        $flex_aligns = [
            'left'   => 'flex-start',
            'right'  => 'flex-end',
            'center' => 'center',
        ];

        return $flex_aligns[$align];
    }

    static function sanitize_string($string) {
        return str_replace(["\r", "\n", "\r\n"], '', $string);
    }

    static function buildInlineStyle($atts) {
        $style = '';
        foreach ($atts as $att => $val) {
            $style .= $att . ':' . $val . ';';
        }

        return $style;
    }

    static function buildDataAttrs($atts) {
        $data = '';
        foreach ($atts as $att => $val) {
            $data .= 'data-' . $att . '="' . $val . '" ';
        }

        return $data;
    }

    static function sslIssueDetected($resp) {
        return is_wp_error($resp) && preg_match("/(certficate|ssl|curl)/i", $resp->get_error_message('http_request_failed'));
    }

    static function removeArrayElement($arr, $val) {
        return array_diff($arr, [$val]);
    }

    static function zeroArray($count) {
        return array_fill(0, $count, 0);
    }

    static function printArr($arr) {
        echo '<pre style="padding-left: 300px;">';
        print_r($arr);
        echo '</pre>';
    }

    static function errorLog($log, $prefix = 'ERROR') {
        error_log($prefix . ': ' . serialize($log));
    }

    static function hex2rgba($color, $opacity) {
        return 'rgba(' . hexdec(substr($color, -6, -4))
            . ',' . hexdec(substr($color, -4, -2))
            . ',' . hexdec(substr($color, -2))
            . ',' . $opacity . ')';
    }

    static function explodeTree($array, $delimiter = '_') {
        if (!is_array($array)) {
            return false;
        }
        $splitRE   = '/' . preg_quote($delimiter, '/') . '/';
        $returnArr = [];
        foreach ($array as $key => $val) {
            // Get parent parts and the current leaf
            $parts    = preg_split($splitRE, $key, -1, PREG_SPLIT_NO_EMPTY);
            $leafPart = array_pop($parts);

            // Build parent structure
            // Might be slow for really deep and large structures
            $parentArr = &$returnArr;
            foreach ($parts as $part) {
                if (!isset($parentArr[$part])) {
                    $parentArr[$part] = [];
                } else if (!is_array($parentArr[$part])) {
                    $parentArr[$part] = [];
                }
                $parentArr = &$parentArr[$part];
            }

            // Add the final part to the structure
            if (empty($parentArr[$leafPart])) {
                $parentArr[$leafPart] = $val;
            }
        }

        return $returnArr;
    }

    static function randomFromRange($range_str) {
        $range = explode('-', $range_str);

        return mt_rand($range[0], $range[1]);
    }

    static function admin_url($path) {
        return WPRA_SITE_URL . '/wp-admin/' . $path;
    }

    static function getPostTypes($exclude = []) {
        $post_types = get_post_types(
            [
                'show_ui' => true,
                'public'  => true,
            ]
        );

        return empty($exclude) ? $post_types : array_diff($post_types, $exclude);
    }

    static function get_post_meta($post_id, $key, $default = '') {
        $val = get_post_meta($post_id, $key, true);

        return empty($val) ? $default : $val;
    }

    static function nullString($str) {
        return $str == 'null' ? null : $str;
    }

    static function get_post_type($post_id) {
        if (!Utils::is_num($post_id)) return null;

        $post = get_post($post_id);
        if (empty($post)) return null;

        return $post->post_type;
    }

    static function is_num($value) {
        if (is_float($value) || is_int($value)) {
            return true;
        }

        if (is_numeric($value) && strpos($value, 'e') === false) {
            return true;
        }

        return false;
    }

    static function slug_to_basename($slug) {
        return "$slug/$slug.php";
    }
}