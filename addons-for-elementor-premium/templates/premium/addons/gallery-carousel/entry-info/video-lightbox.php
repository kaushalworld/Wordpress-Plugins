<?php
/**
 * Content - Gallery Carousel Video Lightbox Template
 *
 * This template can be overridden by copying it to mytheme/addons-for-elementor/premium/addons/gallery-carousel/entry-info/video-lightbox.php
 *
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

$item_type = $item['item_type'];
?>

<?php if ($item_type == 'youtube' || $item_type == 'vimeo') : ?>

    <?php $video_url = $item['video_link']; ?>

    <?php if (!empty($video_url)) : ?>

        <a class="lae-video-lightbox" data-fancybox="<?php echo $settings['gallery_class']; ?>"
           href="<?php echo $video_url; ?>" title="<?php echo esc_html($item['item_label']); ?>"
           data-description="<?php echo wp_kses_post($item['item_description']); ?>">

            <i class="lae-icon-video-play"></i>

        </a>

    <?php endif; ?>

<?php elseif ($item_type == 'html5video' && !empty($item['mp4_video_link'])) : ?>

    <?php $video_id = 'lae-video-' . $item['item_image']['id']; // will use thumbnail id as id for video for now ?>

    <a class="lae-video-lightbox" data-fancybox="<?php echo $settings['gallery_class']; ?>"
       href="#<?php echo $video_id; ?>" title="<?php echo esc_html($item['item_label']); ?>"
       data-description="<?php echo wp_kses_post($item['item_description']); ?>">

        <i class="lae-icon-video-play"></i>

    </a>

    <div id="<?php echo $video_id; ?>" class="lae-fancybox-video" style="display:none;">

        <video poster="<?php echo $item['item_image']['url']; ?>"
               src="<?php echo $item['mp4_video_link']; ?>" preload="metadata" controls
               controlsList="nodownload">

            <source type="video/mp4" src="<?php echo $item['mp4_video_link']; ?>">

            <source type="video/webm" src="<?php echo $item['webm_video_link']; ?>">

        </video>

    </div>

<?php endif; ?>