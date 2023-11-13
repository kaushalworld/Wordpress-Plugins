<?php
/**
 * Loop End - Posts Slider Template
 *
 * This template can be overridden by copying it to mytheme/addons-for-elementor/addons/posts-slider/loop-end.php
 *
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}
?>

    </div><!-- .lae-posts-slider -->

    <?php if (lae_fs()->can_use_premium_code__premium_only()) : ?>
        <?php
        if ($settings['thumbnail_nav'] == 'yes')
            lae_get_template_part("premium/addons/posts-slider/thumbnail-nav", $args);

        ?>
    <?php endif; ?>

</div><!-- .lae-posts-slider-wrap -->