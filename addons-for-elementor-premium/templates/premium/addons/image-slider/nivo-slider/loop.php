<?php
/**
 * Loop - Nivo Slider Template
 *
 * This template can be overridden by copying it to mytheme/addons-for-elementor/premium/addons/image-slider/nivo-slider/loop.php
 *
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

$nivo_captions = array();

?>

<div class="nivoSlider">

    <?php foreach ($settings['image_slides'] as $slide): ?>

        <?php $caption_index = uniqid('lae-nivo-caption-'); ?>

        <?php if (!empty($slide['slide_image']) && wp_attachment_is_image($slide['slide_image']['id'])) : ?>

            <?php

            $thumbnail_src = wp_get_attachment_image_src($slide['slide_image']['id'], 'medium');

            if ($thumbnail_src)
                $thumbnail_src = $thumbnail_src[0];

            ?>

            <?php if (!empty($slide['slide_url']) && !empty($slide['slide_url']['url'])) : ?>

                <a href="<?php echo esc_url($slide['slide_url']['url']); ?>"
                   title="<?php echo $slide['slide_name']; ?>">

                    <?php echo wp_get_attachment_image($slide['slide_image']['id'], 'full', false, array('class' => 'lae-image full', 'data-thumb' => $thumbnail_src, 'alt' => $slide['heading'], 'title' => ('#' . $caption_index))); ?>

                </a>

            <?php else : ?>

                <?php echo wp_get_attachment_image($slide['slide_image']['id'], 'full', false, array('class' => 'lae-image full', 'data-thumb' => $thumbnail_src, 'alt' => $slide['heading'], 'title' => ('#' . $caption_index))); ?>

            <?php endif; ?>

            <?php if (!empty($slide['heading'])): ?>

                <?php if (!empty($slide['slide_url']) && !empty($slide['slide_url']['url'])) : ?>

                    <?php $nivo_captions[] = '<div id="' . $caption_index . '" class="nivo-html-caption">' . '<div class="lae-subheading">' . htmlspecialchars_decode($slide['subheading']) . '</div>' . '<h3 class="lae-heading">' . '<a href="' . esc_url($slide['slide_url']['url']) . '" title="' . $slide['heading'] . '">' . $slide['heading'] . '</a></h3>' . '</div>'; ?>

                <?php else : ?>

                    <?php $nivo_captions[] = '<div id="' . $caption_index . '" class="nivo-html-caption">' . '<div class="lae-subheading">' . htmlspecialchars_decode($slide['subheading']) . '</div>' . '<h3 class="lae-heading">' . $slide['heading'] . '</h3>' . '</div>'; ?>

                <?php endif; ?>

            <?php endif; ?>

            <?php $nivo_captions[] = '<div id="' . $caption_index . '" class="nivo-html-caption">' . '<div class="lae-subheading">' . htmlspecialchars_decode($slide['subheading']) . '</div>' . '<h3 class="lae-heading">' . $slide['heading'] . '</h3>' . '</div>'; ?>

        <?php endif; ?>

    <?php endforeach; ?>

</div>

<div class="lae-caption nivo-html-caption">

    <?php foreach ($nivo_captions as $nivo_caption): ?>

        <?php echo $nivo_caption . "\n"; ?>

    <?php endforeach; ?>

</div>