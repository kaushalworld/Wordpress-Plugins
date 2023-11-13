<?php

namespace Elementor;

$uid = uniqid();

// check if the collapse enabled
$collapse       = false;
$collapse_expand = '';


/**
 * 
 * Check weather the collapse enabled or not 
 * 
 */
if ($settings['shopengine_filter_view_mode'] === 'collapse') {
    $collapse = true;
}
//phpcs:disable WordPress.Security.NonceVerification
//No nonce found
if (!empty($_GET)) {
    foreach ($_GET as $key => $value) {
        if (strpos($key, 'shopengine_filter_label') !== false) {
            $collapse_expand = 'open';
            break;
        }
    }
}
//phpcs:enable 
/**
 * 
 * Check weather the collapse expand enable or not 
 * 
 */
if ($settings['shopengine_filter_label_expand_collapse'] === 'yes') {
    $collapse_expand = 'open';
}

?>

<div class="shopengine-filter-single <?php echo esc_attr($collapse ? 'shopengine-collapse' : '') ?>">
    <div class="shopengine-filter">

        <?php
        /**
         * 
         * show filter title
         * 
         */
        if (isset($settings['shopengine_filter_label_title'])) :
        ?>
            <div class="shopengine-filter <?php echo esc_attr($collapse_expand) ?>">
                <h3 class="shopengine-product-filter-title">
                    <?php
                    echo esc_html($settings['shopengine_filter_label_title']);
                    if ($collapse) echo '<i class="eicon-chevron-right shopengine-collapse-icon"></i>';
                    ?>
                </h3>
            </div>

        <?php

        endif;  // end of filter title 

        if ($collapse) echo '<div class="shopengine-collapse-body ' . esc_attr($collapse_expand) . '">';

        /**
         * 
         * loop through attribute list item
         * 
         */
        foreach ($label_options as $option) : ?>
            <div class="filter-input-group">
                <input class="shopengine-filter-label shopengine_filter_label_<?php echo esc_attr($option->taxonomy); ?>-<?php echo esc_attr($option->slug); ?>" name="shopengine_filter_label_<?php echo esc_attr($option->taxonomy); ?>" type="checkbox" id="xs-filter-label-<?php echo esc_attr($uid . '-' . $option->term_id); ?>" value="<?php echo esc_attr($option->slug); ?>" data-taxo="<?php echo esc_attr($option->taxonomy); ?>" />

                <label class="shopengine-filter-label-label" for="xs-filter-label-<?php echo esc_attr($uid . '-' . $option->term_id); ?>">
                    <?php if ($settings['shopengine_filter_label_styles']) {
                        $deafult = 'shopengine-checkbox-icon';
                        $style2 = 'shopengine-style-icon';
                        $class = $settings['shopengine_filter_label_styles'] === 'style_2' ? $style2 : $deafult;
                    } ?>
                    <span class="<?php echo esc_attr($class); ?>">
                        <span>
                            <?php
                            if ($settings['shopengine_filter_label_styles'] === 'style_2') {
                                Icons_Manager::render_icon($settings['shpengine_cirlce_icon'], ['aria-hidden' => 'true']);
                            } else {
                                Icons_Manager::render_icon($settings['shopengine_check_icon'], ['aria-hidden' => 'true']);
                            }
                            ?>
                        </span>
                    </span>
                    <?php echo esc_html($option->label ? $option->label : $option->name); ?>
                </label>
            </div>
        <?php
        endforeach;
        if ($collapse) echo '</div>'; // end of collapse body container
        ?>
    </div>

    <form action="" method="get" class="shopengine-filter" id="shopengine_label_form">
        <input type="hidden" name="shopengine_filter_label" class="shopengine-filter-label-value">
    </form>
</div>