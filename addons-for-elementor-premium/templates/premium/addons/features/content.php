<?php
/**
 * Content - Features Template
 *
 * This template can be overridden by copying it to mytheme/addons-for-elementor/premium/addons/features/content.php
 *
 */

use Elementor\Utils;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

$has_link = false;

if (!empty($feature['feature_link']['url'])) {

    $has_link = true;

    $link_key = 'link_' . $index;

    $url = $feature['feature_link'];

    $widget_instance->add_render_attribute($link_key, 'title', $feature['feature_title']);

    $widget_instance->add_render_attribute($link_key, 'href', $url['url']);

    if (!empty($url['is_external'])) {
        $widget_instance->add_render_attribute($link_key, 'target', '_blank');
    }

    if (!empty($url['nofollow'])) {
        $widget_instance->add_render_attribute($link_key, 'rel', 'nofollow');
    }
}

?>

<div class="lae-feature lae-image-text-toggle <?php echo esc_attr($feature['class']); ?>">

    <?php list($animate_class, $animation_attr) = lae_get_animation_atts($feature['image_animation']); ?>

    <div class="lae-feature-image lae-image-content <?php echo $animate_class; ?>" <?php echo $animation_attr; ?>>

        <?php if (!empty($feature['feature_image'])): ?>

            <?php

            $image_html = lae_get_image_html($feature['feature_image'], 'thumbnail_size', $settings);

            if ($has_link)
                $image_html = '<a class="lae-image-link" ' . $widget_instance->get_render_attribute_string($link_key) . '>' . $image_html . '</a>';

            echo $image_html;

            ?>

        <?php endif; ?>

    </div><!-- .lae-feature-image -->

    <?php list($animate_class, $animation_attr) = lae_get_animation_atts($feature['text_animation']); ?>

    <div class="lae-feature-text lae-text-content <?php echo $animate_class; ?>" <?php echo $animation_attr; ?>>

        <div class="lae-subtitle"><?php echo esc_html($feature['feature_subtitle']); ?></div>

        <?php

        $title_html = '<' . lae_validate_html_tag($settings['title_tag']) . ' class="lae-title">' . esc_html($feature['feature_title']) . '</' . lae_validate_html_tag($settings['title_tag']) . '>';

        if ($has_link)
            $title_html = '<a class="lae-title-link" ' . $widget_instance->get_render_attribute_string($link_key) . '>' . $title_html . '</a>';

        echo $title_html;

        ?>

        <div class="lae-feature-details"><?php echo $widget_instance->parse_text_editor($feature['feature_text']); ?></div>

    </div><!-- .lae-feature-text -->

</div><!-- .lae-feature -->
