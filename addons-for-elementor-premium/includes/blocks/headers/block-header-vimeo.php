<?php

namespace LivemeshAddons\Blocks\Headers;

class LAE_Block_Header_Vimeo extends LAE_Block_Header {

    function get_block_header_class() {

        return 'lae-block-header-vimeo';

    }

    public function get_block_header() {

        $output = '';

        $user_id = $this->get_setting('vimeo_user');

        if (!empty($user_id) && ($this->get_setting('display_user_info_header') == 'yes')) :

            $vimeo_client = $this->get_social_api_client();

            $user = $vimeo_client->get_user_info($user_id);

            if (!empty($user)) :

                $name = (isset($user->name)) ? $user->name : null;
                $link = (isset($user->link)) ? $user->link : null;
                $caption = (isset($user->bio)) ? $user->bio : null;
                $location = (isset($user->location)) ? $user->location : null;
                $website = (isset($user->websites[0]->link)) ? $user->websites[0]->link : null;
                $logo = (isset($user->pictures->sizes[3]->link)) ? $user->pictures->sizes[3]->link : null;
                $likes = (isset($user->metadata->connections->likes->total)) ? $user->metadata->connections->likes->total : null;
                $video_count = (isset($user->metadata->connections->videos->total)) ? $user->metadata->connections->videos->total : null;
                $followers = (isset($user->metadata->connections->followers->total)) ? $user->metadata->connections->followers->total : null;
                $following = (isset($user->metadata->connections->following->total)) ? $user->metadata->connections->following->total : null;

                ob_start();

                ?>
                <div class="lae-block-header lae-vimeo-channel-header">


                    <div class="lae-vimeo-channel-data">

                        <div class="lae-vimeo-channel-data-inner">

                            <div class="lae-vimeo-channel-details">

                                <a class="lae-vimeo-channel-logo" href="<?php echo esc_url($link); ?>" target="_blank">
                                    <img src="<?php echo esc_url($logo); ?>" alt="">
                                </a>

                                <div class="lae-vimeo-channel-info">

                                    <a class="lae-vimeo-channel-title" href="<?php echo esc_url($link); ?>"
                                       target="_blank"><?php echo esc_html($name); ?></a>
                                    <a class="lae-vimeo-channel-website" href="<?php echo esc_url($website); ?>"
                                       target="_blank"><i class="lae-icon-link"></i></a>

                                    <div class="lae-vimeo-channel-location"><?php echo esc_html($location); ?></div>

                                    <div class="lae-vimeo-channel-stats">

                                        <span><?php echo esc_html(lae_shorten_number_format($video_count)); ?>&nbsp;<?php echo __('Videos', 'livemesh-el-addons'); ?></span>

                                        <span><?php echo esc_html(lae_shorten_number_format($likes)); ?>&nbsp;<?php echo __('Likes', 'livemesh-el-addons'); ?></span>

                                        <span><?php echo esc_html(lae_shorten_number_format($followers)); ?>&nbsp;<?php echo __('Followers', 'livemesh-el-addons'); ?></span>

                                        <span><?php echo esc_html(lae_shorten_number_format($following)); ?>&nbsp;<?php echo __('Following', 'livemesh-el-addons'); ?></span>

                                    </div>

                                </div>

                            </div>

                            <p class="lae-vimeo-channel-desc"><?php echo esc_html($caption); ?></p>

                        </div>

                    </div>

                </div>

                <?php

                $output = ob_get_clean();

            endif;

        endif;

        return apply_filters('lae_vimeo_block_header_output', $output, $this);
    }
}