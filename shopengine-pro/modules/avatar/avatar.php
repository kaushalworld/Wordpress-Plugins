<?php

namespace ShopEngine_Pro\Modules\Avatar;

use ShopEngine\Core\Register\Model;
use ShopEngine_Pro\Traits\Singleton;

class Avatar
{
    use Singleton;
    /**
     * @var mixed
     */
    public $settings = [];

    public function init()
    {
        $this->settings = Model::source('settings')->get_option('modules');

        add_action('wp_ajax_shopengine_avatar', [$this, 'ajax_save_avatar']);

        add_filter('get_avatar', [$this, 'get_avatar'], 999999, 6);

        if (is_admin()) {
            add_action('current_screen', function ($screen) {
                if ($screen->id == 'user-edit' || $screen->id == 'profile') {
                    add_filter('user_profile_picture_description', [$this, 'user_profile_picture']);
                    add_action('admin_enqueue_scripts', [$this, 'admin_scripts']);
                }
            });

            add_action('profile_update', [$this, 'save_form_profile_settings']);
        }
    }

    public function user_profile_picture()
    {
        include_once __DIR__ . '/admin-view.php';
    }

    public function admin_scripts()
    {
        wp_enqueue_style('shopengine-avatar-admin-css', \ShopEngine_Pro::module_url() . 'avatar/assets/css/admin.css', );
        wp_enqueue_script(
            'shopengine-avatar-admin-js',
            \ShopEngine_Pro::module_url() . 'avatar/assets/js/admin.js',
            ['jquery']
        );
    }

    /**
     * @param $avatar
     * @param $id_or_email
     * @param $size
     * @param $default
     * @param $alt
     * @param array $args
     * @return mixed
     */
    public function get_avatar($avatar, $id_or_email, $size, $default, $alt, $args = [])
    {
        $id_or_email_type = gettype($id_or_email);

        if (!($id_or_email_type === 'string' || $id_or_email_type === 'integer')) {
            return $avatar;
        }

        if (empty($args)) {
            $args['size']       = (int) $size;
            $args['height']     = $args['size'];
            $args['width']      = $args['size'];
            $args['alt']        = $alt;
            $args['extra_attr'] = '';
        }

        if (is_email($id_or_email)) {
            $user    = get_user_by('email', $id_or_email);
            $user_id = $user->ID;
        } else {
            $user_id = $id_or_email;
        }

        $custom_avatar = get_user_meta($user_id, 'shopengine_avatar_id', true);

        if (!$custom_avatar) {
            return $avatar;
        }

        $src = wp_get_attachment_image_src($custom_avatar, $size);

        if (empty($src[0])) {
            return $avatar;
        }

        $class = ['avatar', 'avatar-' . (int) $args['size'], 'photo'];

        $avatar = sprintf(
            "<img alt='%s' src='%s' class='%s' height='%d' width='%d' %s/>",
            esc_attr($args['alt']),
            esc_url($src[0]),
            esc_attr(join(' ', $class)),
            (int) $args['height'],
            (int) $args['width'],
            $args['extra_attr']
        );

        return $avatar;
    }

    /**
     * @param $user_id
     */
    public function save_form_profile_settings($user_id)
    {
        if (empty($_POST['shopengine-nonce']) || !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['shopengine-nonce'])), 'shopengine-avatar') || empty($_FILES['shopengine_avatar_image'])) {
            return;
        }
        $this->save_avatar($user_id);
        return;
    }

    /**
     * @param $user_id
     */
    public function ajax_save_avatar()
    {
        $redirect_url = !empty($_SERVER['HTTP_REFERER']) ? sanitize_text_field(wp_unslash($_SERVER['HTTP_REFERER'])) : get_site_url();
        if (empty($_POST['shopengine-nonce']) || !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['shopengine-nonce'])), 'shopengine-avatar') || empty($_FILES['shopengine_avatar_image'])) {
            wp_safe_redirect($redirect_url);
            exit;
        }
        $this->save_avatar(get_current_user_id());
        wp_safe_redirect($redirect_url);
        exit;
    }

    /**
     * @param $user_id
     * @param $redirect_url
     */
    public function save_avatar($user_id)
    {
        $limit_size = (isset($this->settings['avatar']['settings']['max_size']['value']) ? intval($this->settings['avatar']['settings']['max_size']['value']) : 500) * 1024;

        if (empty($_FILES['shopengine_avatar_image']['size']) || intval($_FILES['shopengine_avatar_image']['size']) > $limit_size) {
            return;
        }

        if (!function_exists('media_handle_upload')) {
            require_once ABSPATH . 'wp-admin/includes/media.php';
        }

        if (!function_exists('wp_handle_upload')) {
            require_once ABSPATH . 'wp-admin/includes/file.php';
        }

        if (!function_exists('wp_generate_attachment_metadata')) {
            require_once ABSPATH . 'wp-admin/includes/image.php';
        }

        $allowed_file_types = [
            'jpg'  => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'png'  => 'image/png'
        ];

        $overrides = [
            'test_form' => false,
            'mimes'     => $allowed_file_types
        ];

        $avatar_id = media_handle_upload('shopengine_avatar_image', 0, [], $overrides);

        if (is_wp_error($avatar_id)) {
            return;
        }

        $old_avatar_id = get_user_meta($user_id, 'shopengine_avatar_id', true);

        wp_delete_attachment($old_avatar_id, true);

        update_user_meta($user_id, 'shopengine_avatar_id', $avatar_id);
    }
}
