<?php
/**
 * Content - Gallery Carousel Template
 *
 * This template can be overridden by copying it to mytheme/addons-for-elementor/premium/addons/gallery-carousel/content.php
 *
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}


$style = '';
if (!empty($item['item_tags'])) {

    $terms = explode(',', $item['item_tags']);

    foreach ($terms as $term) {
        $style .= ' term-' . $term;
    }
}

$item_type = $item['item_type'];

$item_class = ' lae-' . $item_type . '-type';

?>

<div class="lae-gallery-carousel-item <?php echo $style . $item_class; ?>">

    <div class="lae-project-image">

        <?php

        $image_html = lae_get_image_html($item['item_image'], 'thumbnail_size', $settings);

        if ($item_type == 'image' && !empty($item['item_link']['url'])):

            $image_html = '<a href="' . esc_url($item['item_link']['url']) . '" title="' . esc_html($item['item_label']) . '">' . $image_html . '</a>';

        endif;

        echo $image_html;

        ?>

        <?php lae_get_template_part("premium/addons/gallery-carousel/entry-info/content", $args); ?>

    </div><!-- .lae-project-image -->

</div><!-- .lae-gallery-carousel-item -->