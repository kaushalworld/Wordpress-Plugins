<?php
/**
 * Slide - Flex Slider Template
 *
 * This template can be overridden by copying it to mytheme/addons-for-elementor/premium/addons/image-slider/flex-slider/slide.php
 *
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

$thumbnail_attr = '';

?>

<?php if (!empty($slide['slide_image']) && wp_attachment_is_image($slide['slide_image']['id'])) : ?>

    <?php

    if ('yes' == $settings['thumbnail_nav']):

        $thumbnail_src = wp_get_attachment_image_src($slide['slide_image']['id'], 'medium');

        if ($thumbnail_src)
            $thumbnail_attr = 'data-thumb="' . $thumbnail_src[0] . '"';

    endif;

    ?>

    <li <?php echo $thumbnail_attr; ?> class="lae-slide">

        <?php $image_html = lae_get_image_html($slide['slide_image'], 'thumbnail_size', $settings); ?>

        <?php if (!empty($slide['slide_url']) && !empty($slide['slide_url']['url'])) : ?>

            <a href="<?php echo esc_url($slide['slide_url']['url']); ?>"
               title="<?php echo esc_html($slide['heading']); ?>"><?php echo $image_html; ?> </a>

        <?php else: ?>

            <?php echo $image_html; ?>

        <?php endif; ?>

        <?php if (!empty($slide['heading'])): ?>

            <?php $args['slide'] = $slide; ?>

            <?php lae_get_template_part("premium/addons/image-slider/captions/{$settings['caption_style']}", $args); ?>

        <?php endif; ?>

    </li>

<?php endif; ?>