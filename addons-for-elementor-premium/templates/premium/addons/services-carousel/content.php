<?php
/**
 * Content - Services Carousel Template
 *
 * This template can be overridden by copying it to mytheme/addons-for-elementor/premium/addons/services-carousel/content.php
 *
 */

use Elementor\Utils;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

$has_link = false;

if (!empty($service['service_link']['url'])) {

    $has_link = true;

    $link_key = 'link_' . $index;

    $url = $service['service_link'];

    $widget_instance->add_render_attribute($link_key, 'title', $service['service_title']);

    $widget_instance->add_render_attribute($link_key, 'href', $url['url']);

    if (!empty($url['is_external'])) {
        $widget_instance->add_render_attribute($link_key, 'target', '_blank');
    }

    if (!empty($url['nofollow'])) {
        $widget_instance->add_render_attribute($link_key, 'rel', 'nofollow');
    }
}
?>
<div class="lae-services-carousel-item">

    <div class="lae-service">

        <?php if (!empty($service['service_image'])): ?>

            <div class="lae-image-wrapper">

                <?php $image_html = lae_get_image_html($service['service_image'], 'thumbnail_size', $settings); ?>

                <?php if ($has_link) : ?>

                    <a class="lae-image-link" <?php echo $widget_instance->get_render_attribute_string($link_key); ?>><?php echo $image_html; ?></a>

                <?php else: ?>

                    <?php echo $image_html; ?>

                <?php endif; ?>

            </div>

        <?php endif; ?>

        <div class="lae-service-text">

            <div class="lae-subtitle"><?php echo esc_html($service['service_subtitle']); ?></div>

            <?php

            $title_html = '<' . lae_validate_html_tag($settings['title_tag']) . ' class="lae-title">' . esc_html($service['service_title']) . '</' . lae_validate_html_tag($settings['title_tag']) . '>';

            if ($has_link)
                $title_html = '<a class="lae-title-link" ' . $widget_instance->get_render_attribute_string($link_key) . '>' . $title_html . '</a>';

            echo $title_html;

            ?>

            <div class="lae-service-excerpt"><?php echo do_shortcode(wp_kses_post($service['service_excerpt'])); ?></div>

            <a class="lae-read-more"
               href="<?php echo esc_url($service['button_url']['url']); ?>" <?php echo(($service['button_url']['is_external']) ? 'target="_blank"' : ''); ?>><?php echo $service['button_text']; ?></a>

        </div><!-- .lae-service-text -->

    </div><!-- .lae-service -->

</div><!--.lae-services-carousel-item -->