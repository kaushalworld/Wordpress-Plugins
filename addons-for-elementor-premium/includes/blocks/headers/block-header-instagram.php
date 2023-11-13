<?php

namespace LivemeshAddons\Blocks\Headers;

class LAE_Block_Header_Instagram extends LAE_Block_Header {

    function get_block_header_class() {

        return 'lae-block-header-instagram';

    }

    public function get_block_header() {

        $output = '';

        $user_names = $this->get_setting('instagram_usernames');

        $display_header = $this->get_setting('display_header');

        if ($display_header && !empty($user_names)) :

            $instagram_client = $this->get_social_api_client();

            $user = $instagram_client->get_user_info();

            if (!empty($user)) :

                $id          = isset( $user->id ) ? $user->id : null;
                $username    = isset( $user->username ) ? $user->username : '';
                $fullname    = isset( $user->full_name ) ? $user->full_name : '';
                $url         = isset( $user->username ) ? 'https://www.instagram.com/'.$user->username.'/' : null;
                $avatar      = isset( $user->profile_pic_url ) ? $user->profile_pic_url : null;
                $bio         = isset( $user->biography ) ? $user->biography : null;
                $followed_by = isset( $user->edge_followed_by ) ? $user->edge_followed_by->count : null;
                $follows     = isset( $user->edge_follow ) ? $user->edge_follow->count : null;
                $website     = isset( $user->external_url ) ? $user->external_url : null;
                $media       = isset( $user->edge_owner_to_timeline_media->count ) ? $user->edge_owner_to_timeline_media->count : null;

                ob_start();

                ?>
                <div class="lae-block-header lae-instagram-user-header">

                    <div class="lae-instagram-user-data">

                        <div class="lae-instagram-user-data-inner">

                            <div class="lae-instagram-user-details">

                                <a class="lae-instagram-user-logo" href="<?php echo esc_url($url); ?>" target="_blank">
                                    <img src="<?php echo esc_url($avatar); ?>" alt="">
                                </a>

                                <div class="lae-instagram-user-info">

                                    <a class="lae-instagram-username" href="<?php echo esc_url($url); ?>"
                                       target="_blank"><?php echo esc_html('@' . $username); ?></a>

                                    <a class="lae-instagram-user-title" href="<?php echo esc_url($url); ?>"
                                       target="_blank"><?php echo esc_html($fullname); ?></a>
                                    <a class="lae-instagram-user-website" href="<?php echo esc_url($website); ?>"
                                       target="_blank"><i class="lae-icon-link"></i></a>

                                    <div class="lae-instagram-user-stats">

                                        <span><?php echo esc_html(lae_shorten_number_format($media)); ?>&nbsp;<?php echo __('Posts', 'livemesh-el-addons'); ?></span>

                                        <span><?php echo esc_html(lae_shorten_number_format($followed_by)); ?>&nbsp;<?php echo __('Followers', 'livemesh-el-addons'); ?></span>

                                        <span><?php echo esc_html(lae_shorten_number_format($follows)); ?>&nbsp;<?php echo __('Following', 'livemesh-el-addons'); ?></span>

                                    </div>

                                </div>

                            </div>

                            <p class="lae-instagram-user-desc"><?php echo nl2br($bio); ?></p>

                        </div>

                    </div>

                </div>

                <?php

                $output = ob_get_clean();

            endif;

        endif;

        return apply_filters('lae_instagram_block_header_output', $output, $this);
    }
}