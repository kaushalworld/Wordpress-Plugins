<?php
/**
 * Style 2 - Image Slider Caption Template
 *
 * This template can be overridden by copying it to mytheme/addons-for-elementor/premium/addons/image-slider/captions/style2.php
 *
 */

use Elementor\Utils;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

?>
<div class="lae-caption">

    <?php echo empty($slide['subheading']) ? '' : '<div class="lae-subheading">' . htmlspecialchars_decode($slide['subheading']) . '</div>'; ?>

    <?php if (!empty($slide['heading'])): ?>

        <?php if (!empty($slide['slide_url']) && !empty($slide['slide_url']['url'])) : ?>

            <<?php echo lae_validate_html_tag($settings['heading_tag']); ?> class="lae-heading">
                <a href="<?php echo esc_url($slide['slide_url']['url']); ?>"
                   title="<?php echo $slide['heading']; ?>"><?php echo $slide['heading']; ?></a>
            </<?php echo lae_validate_html_tag($settings['heading_tag']); ?>>

        <?php else : ?>

            <<?php echo lae_validate_html_tag($settings['heading_tag']); ?> class="lae-heading"><?php echo $slide['heading']; ?></<?php echo lae_validate_html_tag($settings['heading_tag']); ?>>

        <?php endif; ?>

    <?php endif; ?>

</div>