<?php
/**
 * Content - Gallery Carousel Item Title Template
 *
 * This template can be overridden by copying it to mytheme/addons-for-elementor/premium/addons/gallery-carousel/entry-info/item-title.php
 *
 */

use Elementor\Utils;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

$item_type = $item['item_type'];

?>

<?php if ($settings['display_item_title'] == 'yes'): ?>

    <<?php echo lae_validate_html_tag($settings['title_tag']); ?> class="lae-entry-title">

        <?php if ($item_type == 'image' && !empty($item['item_link']['url'])): ?>

            <?php $target = $item['item_link']['is_external'] ? 'target="_blank"' : ''; ?>

            <a href="<?php echo esc_url($item['item_link']['url']); ?>"
               title="<?php echo esc_html($item['item_label']); ?>" <?php echo $target; ?>><?php echo esc_html($item['item_label']); ?></a>

        <?php else: ?>

            <?php echo esc_html($item['item_label']); ?>

        <?php endif; ?>

    </<?php echo lae_validate_html_tag($settings['title_tag']); ?>>

<?php endif; ?>