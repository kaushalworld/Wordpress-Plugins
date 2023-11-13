<?php

namespace LivemeshAddons\Blocks\Headers;

class LAE_Block_Header_Youtube extends LAE_Block_Header {

    function get_block_header_class() {

        return 'lae-block-header-youtube';

    }

    public function get_block_header() {

        $output = '';

        $channel_id = $this->get_setting('youtube_channel');

        if (!empty($channel_id) && ($this->get_setting('display_channel_header') == 'yes')) :

            $youtube_client = $this->get_social_api_client();

            $channel_info = $youtube_client->get_channel_info();

            if (isset($channel_info->items[0]) && !empty($channel_info->items[0])) :

                $logo = $channel_info->items[0]->snippet->thumbnails->default->url;
                $banner = $channel_info->items[0]->brandingSettings->image->bannerTabletHdImageUrl;
                $title = $channel_info->items[0]->snippet->title;
                $caption = $channel_info->items[0]->snippet->description;
                $viewCount = $channel_info->items[0]->statistics->viewCount;
                $videoCount = $channel_info->items[0]->statistics->videoCount;

                ob_start();

                ?>
                <div class="lae-block-header lae-youtube-channel-header">

                    <div class="lae-youtube-channel-banner">
                        <img src="<?php echo esc_url($banner); ?>" alt="">
                    </div>

                    <div class="lae-youtube-channel-data">

                        <div class="lae-youtube-channel-data-inner">

                            <div class="lae-youtube-channel-details">

                                <a class="lae-youtube-channel-logo"
                                   href="<?php echo esc_url('https://www.youtube.com/channel/' . $channel_id . '/'); ?>"
                                   target="_blank">

                                    <img src="<?php echo esc_url($logo); ?>" alt="">

                                </a>

                                <div class="lae-youtube-channel-info">

                                    <a class="lae-youtube-channel-title" href="<?php echo esc_url('https://www.youtube.com/channel/' . $channel_id . '/'); ?>"
                                       target="_blank"><?php echo esc_html($title); ?></a>

                                    <div class="lae-youtube-channel-stats">

                                        <span><?php echo esc_html(lae_shorten_number_format($videoCount)) . ' ' . __('videos', 'livemesh-el-addons'); ?></span>

                                        <span><?php echo esc_html(lae_shorten_number_format($viewCount)) . ' ' . __('views', 'livemesh-el-addons'); ?></span>

                                    </div>

                                </div>

                                <div class="lae-youtube-subscribe">

                                    <div class="g-ytsubscribe"
                                         data-channelid="<?php echo esc_attr($channel_id); ?>"
                                         data-layout="default"
                                         data-count="default"></div>

                                </div>

                            </div>

                            <p class="lae-youtube-channel-desc"><?php echo esc_html($caption); ?></p>

                        </div>

                    </div>

                </div>

                <?php

                $output = ob_get_clean();

            endif;

        endif;

        return apply_filters('lae_youtube_block_header_output', $output, $this);
    }
}