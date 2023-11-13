<?php

namespace WPRA;

use WPRA\Helpers\Utils;
use WPRA\Helpers\StyleGenerator;

class Enqueue {

    private $front_assets = [];
    private $admin_assets = [];
    private $hooks = [
        'toplevel_page_wpra-dashboard',
        'wp-reactions_page_wpra-global-options',
        'wp-reactions_page_wpra-shortcode-generator',
        'wp-reactions_page_wpra-my-shortcodes',
        'wp-reactions_page_wpra-analytics',
        'wp-reactions_page_wpra-settings',
        'wp-reactions_page_wpra-tools',
    ];

    static function init() {
        return new self();
    }

    public function __construct() {
        $this->flushAdminAssets();
        $this->flushFrontAssets();
        $this->loadStyles();
        $this->loadLayoutChooserStyles();
        $this->fixCollisions();
    }

    function fixCollisions() {
        // remove bootstrap.js from other themes or plugins in order to avoid collision
        add_action('admin_print_scripts', function () {
            global $wp_scripts;
            $screen = get_current_screen();
            if (!is_null($screen) && in_array($screen->base, $this->hooks)) {
                foreach ($wp_scripts->queue as $handle) {
                    $this->deregisterScript($handle);
                }
                foreach ($wp_scripts->registered as $script) {
                    $this->deregisterScript($script->handle);
                }
            }
        }, 999);
    }

    function loadStyles() {
        add_action('wp_head', function () {
            global $post;

            // if not a post object, do nothing
            if (!is_a($post, 'WP_Post')) return;

            // there is any shortcode in content
            if ($shortcodes = Shortcode::extract($post)) {

                foreach ($shortcodes as $shortcode) {
                    $sgc_id = Shortcode::toSgcId($shortcode);
                    // no id matches
                    if (empty($sgc_id)) return;

                    $params = Shortcode::getSgcDataBy('id', $sgc_id, ['options']);
                    // no sgc data found with id
                    if (empty($params)) return;

                    self::printStyle("sgc-$sgc_id", ".wpra-plugin-container[data-sgc_id=\"$sgc_id\"]", $params);
                } // endforeach

            } // endif

            // shortcode bound to the post type
            $bound_sgc = Shortcode::getSgcDataBy('post_type', $post->post_type, ['id', 'front_render', 'options']);
            if (!is_null($bound_sgc) && $bound_sgc->front_render) {
                self::printStyle("sgc-$bound_sgc->id", ".wpra-plugin-container[data-sgc_id=\"$bound_sgc->id\"]", $bound_sgc->options);
            }

            // global activation
            if (in_array($post->post_type, Config::$active_layout_opts['post_types_deploy_auto'])) {
                self::printStyle("global", '.wpra-plugin-container[data-source="global"]', Config::$active_layout_opts);
            }
        }); // end function
    }

    function loadLayoutChooserStyles() {
        add_action('admin_head', function () {
            $is_global      = Utils::isPage('global');
            $is_sgc         = Utils::isPage('shortcode');
            $is_edit_layout = Utils::has_query_var('layout');

            if (!$is_edit_layout && ($is_global || $is_sgc)) {
                foreach (Config::$layouts as $layout => $layout_data) {
                    $options = array_merge(
                        $is_global ? Config::getLayoutOptions($layout) : $layout_data['defaults'],
                        ['source' => 'layout_chooser', 'bind_id' => 'preview_' . $layout,]
                    );

                    Enqueue::printStyle("layout-chooser-$layout", ".wpra-plugin-container[data-layout=\"$layout\"]", $options);
                }
            }
        });
    }

    static function printStyle($style_id, $selector, $params) {
        $style_generator = new StyleGenerator("wpreactions-style-$style_id");
        $style_generator->setParentSelector($selector);

        if ($params['layout'] == 'button_reveal') {
            $params['show_title']           = 'false';
            $params['title_color']          = $params['title_size'] = $params['title_weight'] = $params['title_text'] = '';
            $params['social_style_buttons'] = $params['enable_share_buttons'] = 'false';

            $style_generator->addStyle('button.wpra-reveal-toggle', [
                'border-style'     => 'solid',
                'color'            => $params['reveal_button']['text_color'],
                'font-size'        => $params['reveal_button']['font_size'],
                'font-weight'      => $params['reveal_button']['font_weight'],
                'background-color' => $params['reveal_button']['bgcolor'],
                'border-color'     => $params['reveal_button']['border_color'],
                'border-radius'    => $params['reveal_button']['border_radius'],
                'padding-top'      => $params['reveal_button']['padding_top'],
                'padding-bottom'   => $params['reveal_button']['padding_bottom'],
                'padding-left'     => $params['reveal_button']['padding_left'],
                'padding-right'    => $params['reveal_button']['padding_right'],
            ]);

            $style_generator->addStyle('button.wpra-reveal-toggle:hover', [
                'background-color' => $params['reveal_button']['hover_bgcolor'],
                "border-color"     => $params['reveal_button']['hover_border_color'],
                "color"            => $params['reveal_button']['hover_text_color'],
            ]);

            $style_generator->addStyle('.wpra-reveal-toggle:hover i', [
                "color" => $params['reveal_button']['icon_hover_color'],
            ]);

            $icon_margin = ($params['reveal_button']['icon_active'] == 'true' && $params['reveal_button']['icon_position'] == 'left')
                ? "0 {$params['reveal_button']['icon_space']} 0 0"
                : "0 0 0 {$params['reveal_button']['icon_space']}";

            $style_generator->addStyle('.wpra-reveal-toggle > span > i', [
                'font-size' => $params['reveal_button']['icon_size'],
                'color'     => $params['reveal_button']['icon_color'],
                'margin'    => $icon_margin,
            ]);

            $style_generator->addStyle('.wpra-reactions-wrap', [
                'justify-content' => $params['reveal_button']['ontop_align'],
            ]);
        }

        if ($params['layout'] == 'bimber') {
            $params['border_color']     = '';
            $params['border_width']     = '';
            $params['border_radius']    = '';
            $params['border_style']     = '';
            $params['bgcolor_trans']    = '';
            $params['bgcolor']          = '';
            $params['count_color']      = '';
            $params['count_text_color'] = '';

            $style_generator->addStyle('.wpra-call-to-action', [
                'border-bottom'       => '1px solid #eee',
                'padding-bottom'      => '35px',
                'border-bottom-width' => $params['title_border'] == 'true' ? $params['title_border_size'] : 0,
                'border-bottom-style' => $params['title_border_style'],
                'border-bottom-color' => $params['title_border_color'],
            ]);

            $style_generator->addStyle('.wpra-reaction-label', [
                'background-color' => $params['label_bg_color'],
                'color'            => $params['label_text_color'],
                "font-size"        => $params['label_text_size'],
                "font-weight"      => $params['label_text_weight'],
            ]);

            $style_generator->addStyle('.wpra-reaction.active .wpra-reaction-label', [
                'background-color' => $params['label_bg_color_hover'],
                'color'            => $params['label_text_color_hover'],
            ]);

            $style_generator->addStyle('.wpra-reaction:hover .wpra-reaction-label', [
                "background-color" => $params['label_bg_color_hover'],
                "color"            => $params['label_text_color_hover'],
            ]);

            $style_generator->addStyle('.wpra-reaction-track', [
                'background-color' => $params['bar_background_color'],
            ]);

            $style_generator->addStyle('.wpra-reaction-track-val', [
                'color'       => $params['bar_count_color'],
                'font-size'   => $params['bar_count_size'],
                'font-weight' => $params['bar_count_weight'],
            ]);

            $style_generator->addStyle('.wpra-reaction-track-bar', [
                'background-color' => $params['bar_progress_color'],
            ]);
        }

        if ($params['layout'] == 'disqus' || $params['layout'] == 'jane') {
            $params['border_color']  = '';
            $params['border_width']  = '';
            $params['border_radius'] = '';
            $params['border_style']  = '';
            $params['bgcolor_trans'] = '';
            $params['bgcolor']       = '';
            $params['count_color']   = '';

            $style_generator->addStyle('.wpra-reaction .wpra-reaction-wrap', [
                'border-width'     => $params['reaction_border_width'],
                'border-radius'    => $params['reaction_border_radius'],
                'border-style'     => $params['reaction_border_style'],
                'border-color'     => $params['reaction_border_color'],
                'background-color' => $params['reaction_bg_color'],
            ]);

            $style_generator->addStyle('.wpra-reaction:hover .wpra-reaction-wrap', [
                'background-color' => $params['reaction_bg_color_hover'],
                'border-color'     => $params['reaction_border_color_hover'],
            ]);

            $style_generator->addStyle('.wpra-reaction.active .wpra-reaction-wrap', [
                'border-color'     => $params['reaction_border_color_active'],
                'background-color' => $params['reaction_bg_color_active'],
            ]);

            $style_generator->addStyle('.wpra-reaction .wpra-reaction-label', [
                'color'       => $params['label_text_color'],
                'font-size'   => $params['label_text_size'],
                'font-weight' => $params['label_text_weight'],
            ]);

            $style_generator->addStyle('.wpra-reaction:hover .wpra-reaction-label', [
                'color' => $params['label_text_color_hover'],
            ]);

            $style_generator->addStyle('.wpra-reaction.active .wpra-reaction-label', [
                'color' => $params['label_text_color_active'],
            ]);

            $style_generator->addStyle('.wpra-reaction:hover .count-num', [
                'color' => $params['count_text_color_hover'],
            ]);

            $style_generator->addStyle('.wpra-reaction.active .count-num', [
                'color' => $params['count_text_color_active'],
            ]);

            $style_generator->addStyle('.count-num', [
                'color'       => $params['count_text_color'],
                'font-weight' => $params['count_weight'],
                'font-size'   => $params['count_size'],
                'display'     => $params['show_count'] == 'true' ? 'block' : 'none',
            ]);

            if ($params['layout'] == 'disqus') {
                $style_generator->addStyle('.wpra-total-counts', [
                    'color'       => $params['total_counts_color'],
                    'font-weight' => $params['total_counts_weight'],
                    'font-size'   => $params['total_counts_size'],
                ]);
            }
        }

        if ($params['layout'] == 'regular' || $params['layout'] == 'button_reveal') {

            $style_generator->addStyle('.arrow-badge', [
                'background-color' => $params['count_color'],
                'top'              => $params['count_pos_top'],
                'min-width'        => $params['count_width'],
                'height'           => $params['count_height'],
                'border-radius'    => $params['count_border_radius'],
            ]);

            $style_generator->addStyle('.arrow-badge > .tail', [
                'border-top-color' => $params['count_color'],
            ]);

            $style_generator->addStyle('.arrow-badge > .count-num', [
                'color'       => $params['count_text_color'],
                'font-size'   => $params['count_text_size'],
                'font-weight' => $params['count_text_weight'],
            ]);
        }

        $style_generator->addStyle('', [
            'justify-content' => Utils::flexAlign($params['align']),
        ]);

        $style_generator->addStyle('.wpra-call-to-action', [
            'color'       => $params['title_color'],
            'font-size'   => $params['title_size'],
            'font-weight' => $params['title_weight'],
            'display'     => $params['show_title'] == 'false' ? 'none' : 'block',
        ]);

        $style_generator->addStyle('.wpra-reactions', [
            'border-color'  => $params['border_color'],
            'border-width'  => $params['border_width'],
            'border-radius' => $params['border_radius'],
            'border-style'  => $params['border_style'],
            'background'    => $params['bgcolor_trans'] == 'true' ? 'transparent' : $params['bgcolor'],
        ]);

        $style_generator->addStyle('.wpra-flying', [
            'color'       => $params['flying']['text_color'],
            'font-size'   => $params['flying']['font_size'],
            'font-weight' => $params['flying']['font_weight'],
        ]);

        $style_generator->addStyle('.wpra-reaction-animation-holder', [
            'width'   => $params['adjust']['animated']['size'],
            'height'  => $params['adjust']['animated']['size'],
            'margin'  => $params['adjust']['animated']['margin'],
            'padding' => $params['adjust']['animated']['padding'],
        ]);

        $style_generator->addStyle('.wpra-reaction-static-holder', [
            'width'   => $params['adjust']['static']['size'],
            'height'  => $params['adjust']['static']['size'],
            'margin'  => $params['adjust']['static']['margin'],
            'padding' => $params['adjust']['static']['padding'],
        ]);

        if ($params['layout'] != 'button_reveal') {
            if ($params['social_style_buttons'] == 'true') {
                $style_generator->addStyle('.custom-buttons .share-btn', [
                    'border-radius'    => $params['social']['border_radius'],
                    'background-color' => $params['social']['bg_color'],
                    'border-color'     => $params['social']['border_color'],
                    'color'            => $params['social']['text_color'],
                ]);
            }

            $style_generator->addStyle('.wpra-share-expandable-more', [
                'border-radius' => $params['social']['border_radius'],
            ]);

            $style_generator->addStyle('.wpra-share-expandable-counts', [
                'font-size'   => $params['social']['counter_size'],
                'font-weight' => $params['social']['counter_weight'],
                'color'       => $params['social']['counter_color'],
            ]);

            $style_generator->addStyle('.share-btn', [
                'border-radius' => $params['social']['border_radius'],
            ]);
        }

        $style_generator->output();
    }

    function deregisterScript($handle) {
        if ($handle == 'wpra-bootstrap' || strpos($handle, 'bootstrap') === false) return;
        wp_dequeue_script($handle);
        wp_deregister_script($handle);
    }

    function registerAdminScripts() {
        $layout = Utils::get_query_var('layout');

        wp_enqueue_script('jquery-ui-draggable');
        wp_enqueue_script('jquery-ui-droppable');

        // add plugin styles
        $this->addAdminAsset('style', 'wpra-bootstrap', 'vendor/bootstrap/css/bootstrap.css', $this->hooks);
        $this->addAdminAsset('style', 'wpra-apex', 'vendor/apexcharts/apexcharts.css', $this->hooks);
        $this->addAdminAsset('style', 'wpra-admin', 'css/dist/admin.min.css', $this->hooks);
        $this->addAdminAsset('style', 'wpra-fontawesome', 'vendor/fontawesome/css/all.min.css', $this->hooks);
        $this->addAdminAsset('style', 'wpra-daterangepicker', 'vendor/daterangepicker/daterangepicker.css', ['wp-reactions_page_wpra-analytics']);
        $this->addAdminAsset('style', 'wpra-front', 'css/dist/front.min.css', $this->hooks);
        $this->addAdminAsset('style', 'wpra-common', 'css/dist/common.min.css');
        $this->addAdminAsset('style', 'wpra-post', 'css/dist/post.css');
        $this->addAdminAsset('style', 'wpra-minicolor', 'vendor/minicolor/jquery.minicolors.css', $this->hooks);
        $this->addAdminAsset('font', 'wpra-fonts', 'https://fonts.googleapis.com/css?family=Open+Sans:300,400,500,600,700', $this->hooks);

        // add plugin scripts
        $this->addAdminAsset('script', 'wpra-bootstrap', 'vendor/bootstrap/js/wpra.bootstrap.min.js', $this->hooks, ['jquery']);
        $this->addAdminAsset('script', 'wpra-apex', 'vendor/apexcharts/apexcharts.min.js', ['wp-reactions_page_wpra-analytics']);
        $this->addAdminAsset('script', 'wpra-raphael', 'vendor/justgage/raphael-2.1.4.min.js', ['wp-reactions_page_wpra-analytics']);
        $this->addAdminAsset(
            'script',
            'wpra-moment',
            'vendor/daterangepicker/moment.min.js',
            ['wp-reactions_page_wpra-analytics'],
            ['jquery']
        );
        $this->addAdminAsset(
            'script',
            'wpra-daterangepicker',
            'vendor/daterangepicker/daterangepicker.js',
            ['wp-reactions_page_wpra-analytics'],
            ['jquery', 'wpra-moment']
        );

        $this->addAdminAsset('script', 'wpra-utils', 'js/utils.js', $this->hooks, ['jquery']);
        $this->addAdminAsset('script', 'wpra-general', 'js/general.js', [], ['jquery'], $this->get_script_vars('general'));
        $this->addAdminAsset(
            'script',
            'wpra-analytics',
            'js/analytics.js',
            ['wp-reactions_page_wpra-analytics'],
            ['jquery', 'wpra-admin', 'wpra-general'],
            $this->get_script_vars('analytics')
        );
        $this->addAdminAsset('script', 'wpra-justgage', 'vendor/justgage/justgage.js', ['wp-reactions_page_wpra-analytics']);
        $this->addAdminAsset('script', 'wpra-lottie', 'vendor/lottie/lottie.min.js', $this->hooks, ['jquery']);
        $this->addAdminAsset('script', 'wpra-minicolor', 'vendor/minicolor/jquery.minicolors.min.js', $this->hooks, ['jquery']);
        $this->addAdminAsset('script', 'wpra-front', 'js/front.js', $this->hooks, ['jquery', 'wpra-lottie']);
        $this->addAdminAsset('script', 'jquery.ui.touch-punch', 'vendor/jquery.ui.touch-punch.min.js', $this->hooks);
        $this->addAdminAsset('script', 'wpra-post', 'js/post.js', ['post-new.php', 'post.php']);
        $this->addAdminAsset(
            'script',
            'wpra-admin',
            'js/admin.js',
            $this->hooks,
            ['jquery', 'wpra-lottie', 'wpra-front', 'wpra-utils', 'jquery-ui-sortable', 'wpra-bootstrap', 'wpra-general', 'wpra-minicolor'],
            $this->get_script_vars('admin', [
                'min_emojis' => Config::getLayoutValue($layout, 'min_emojis'),
                'max_emojis' => Config::getLayoutValue($layout, 'max_emojis'),
            ])
        );
    }

    function registerFrontScripts() {
        $this->addFrontAsset('style', 'wpra-front', 'css/dist/front.min.css');
        $this->addFrontAsset('style', 'wpra-fontawesome', 'vendor/fontawesome/css/all.min.css');
        $this->addFrontAsset('script', 'wpra-lottie', 'vendor/lottie/lottie.min.js');
        $this->addFrontAsset('script', 'wpra-front', 'js/front.js', ['jquery', 'wpra-lottie'], $this->get_script_vars('front'));
    }

    private function get_script_vars($type, $params = []) {
        $vars = [];

        switch ($type) {
            case 'analytics':
                $vars = [
                    'object' => 'wpra_analytics',
                    'vars'   => [
                        'ajaxurl'  => Utils::admin_url('admin-ajax.php'),
                        'messages' => [
                            'no_any_shortcode' => __('You have no any shortcode created!', 'wpreactions'),
                        ],
                    ],
                ];
                break;
            case 'admin':
                $vars = [
                    'object' => 'wpreactions',
                    'vars'   => [
                        'ajaxurl'                  => Utils::admin_url('admin-ajax.php'),
                        'messages'                 => [
                            'options_updating'      => __('Updating options...', 'wpreactions'),
                            'getting_preview'       => __('Getting preview...', 'wpreactions'),
                            'resetting_options'     => __('Resetting to factory settings...', 'wpreactions'),
                            'reset_confirm'         => __('Are you sure you want to reset to our factory settings?', 'wpreactions'),
                            'global_prev_step'      => __('Prev', 'wpreactions'),
                            'global_next_step'      => __('Next', 'wpreactions'),
                            'global_go_back'        => __('Go Back', 'wpreactions'),
                            'global_start_over'     => __('Start Over', 'wpreactions'),
                            'max_shortcode_chars'   => __('Please use maximum 100 characters for shortcode name', 'wpreactions'),
                            'sure_leave_sgc'        => __('Are your sure you want to leave the shortcode generator?', 'wpreactions'),
                            'sure_leave_global'     => __('Are you sure you want to leave without saving your work?', 'wpreactions'),
                            'fill_all_fields'       => __('Please fill all fields', 'wpreactions'),
                            'max_emojis_alert'      => __('You have reached maximum allowed emojis for the layout', 'wpreactions'),
                            'sure_delete_shortcode' => __('Are you sure you want to permanently delete this Shortcode?', 'wpreactions'),
                            'layout_minimal_emojis' => sprintf(__('This layout requires at least %d emojis', 'wpreactions'), $params['min_emojis']),
                            'has_an_empty_label'    => __('Please go to "SETUP" tab and set all labels for emojis', 'wpreactions'),
                            'wrong_range_input'     => __('Please enter valid range like 100-500', 'wpreactions'),
                            'no_shortcode_name'     => __('Please give a name to your shortcode', 'wpreactions'),
                            'woo_no_shortcode'      => __('You must choose shortcode', 'wpreactions'),
                            'woo_empty_hook'        => __('Custom hook name can not be empty', 'wpreactions'),
                            'sgc_btn_created'       => __('Save Shortcode', 'wpreactions'),
                        ],
                        'current_options'          => Config::$active_layout_opts,
                        'social_platforms'         => Config::$social_platforms,
                        'global_lp'                => Utils::getAdminPage('global'),
                        'emojis_base_url'          => [
                            'builtin' => Emojis::getBaseUrl('builtin'),
                            'custom'  => Emojis::getBaseUrl('custom'),
                        ],
                        'version'                  => WPRA_VERSION,
                        'user_reaction_limitation' => Config::$settings['user_reaction_limitation'],
                        'max_emojis'               => $params['max_emojis'],
                        'min_emojis'               => $params['min_emojis'],
                        'fontawesome_api'          => Config::$fontawesome_api,
                    ],
                ];
                break;
            case 'general':
                $vars = [
                    'object' => 'wpreactions_general',
                    'vars'   => [
                        'ajaxurl'           => Utils::admin_url('admin-ajax.php'),
                        'force_updates_url' => get_site_url(null, '/wp-admin/update-core.php?force-check=1'),
                    ],
                ];
                break;
            case 'front':
                $vars = [
                    'object' => 'wpreactions',
                    'vars'   => [
                        'ajaxurl'                  => Utils::admin_url('admin-ajax.php'),
                        'emojis_base_url'          => [
                            'builtin' => Emojis::getBaseUrl('builtin'),
                            'custom'  => Emojis::getBaseUrl('custom'),
                        ],
                        'social_platforms'         => Config::$social_platforms,
                        'version'                  => WPRA_VERSION,
                        'user_reaction_limitation' => Config::$settings['user_reaction_limitation'],
                    ],
                ];
                break;
        }

        return $vars;
    }

    function addFrontAsset($type, $handle, $url, $deps = [], $locals = [], $footer = false) {
        $this->front_assets[] = [
            'type'   => $type,
            'handle' => $handle,
            'url'    => $url,
            'deps'   => $deps,
            'footer' => $footer,
            'locals' => $locals,
        ];
    }

    function addAdminAsset($type, $handle, $url, $hooks = [], $deps = [], $locals = [], $footer = false) {
        $this->admin_assets[] = [
            'type'   => $type,
            'handle' => $handle,
            'url'    => $url,
            'deps'   => $deps,
            'footer' => $footer,
            'hooks'  => $hooks,
            'locals' => $locals,
        ];
    }

    function flushFrontAssets() {
        add_action('wp_enqueue_scripts', function () {

            $this->registerFrontScripts();

            if (!empty($this->front_assets)) {
                foreach ($this->front_assets as $asset) {
                    $url = Utils::getAsset($asset['url']);
                    if ($asset['type'] == 'style') {
                        wp_enqueue_style($asset['handle'], $url);
                    } else if ($asset['type'] == 'script') {
                        wp_enqueue_script($asset['handle'], $url, $asset['deps'], '', $asset['footer']);
                    } else if ($asset['type'] == 'font') {
                        wp_enqueue_style($asset['handle'], $asset['url']);
                    }

                    if (!empty($asset['locals'])) {
                        wp_localize_script($asset['handle'], $asset['locals']['object'], $asset['locals']['vars']);
                    }
                }
            }
        });
    }

    function flushAdminAssets() {
        add_action('admin_enqueue_scripts', function ($hook) {

            $this->registerAdminScripts();

            if (!empty($this->admin_assets)) {
                foreach ($this->admin_assets as $asset) {
                    $url = Utils::getAsset($asset['url']);

                    if (isset($asset['hooks']) and (empty($asset['hooks']) or in_array($hook, $asset['hooks']))) {
                        if ($asset['type'] == 'style') {
                            wp_enqueue_style($asset['handle'], $url);
                        } else if ($asset['type'] == 'script') {
                            wp_enqueue_script($asset['handle'], $url, $asset['deps'], '', $asset['footer']);
                        } else if ($asset['type'] == 'font') {
                            wp_enqueue_style($asset['handle'], $asset['url']);
                        }
                    }

                    if (!empty($asset['locals'])) {
                        wp_localize_script($asset['handle'], $asset['locals']['object'], $asset['locals']['vars']);
                    }
                }
            }
        });
    }
} // end of class definition