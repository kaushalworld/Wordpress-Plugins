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
    $collapse       = true;
}
/**
 * 
 * Check weather the collapse expand enable or not 
 * 
 */
//phpcs:disable WordPress.Security.NonceVerification
if (!empty($_GET)) {

    foreach ($_GET as $key => $value) {
        if (strpos($key, 'shopengine_filter_color') !== false) {
            $collapse_expand = 'open';
            break;
        }
    }
}
//phpcs:enable 
if ($settings['shopengine_filter_color_expand_collapse'] === 'yes') {
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
        if (isset($settings['shopengine_filter_color_title'])) :
        ?>
            <div class="shopengine-filter <?php echo esc_attr($collapse_expand) ?>">
                <h3 class="shopengine-product-filter-title">
                    <?php
                    echo esc_html($settings['shopengine_filter_color_title']);
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
        
        foreach ($color_options as $option) : ?>
            <div class="filter-input-group">
                <input class="shopengine-filter-colors shopengine_filter_color_<?php echo esc_attr($option->taxonomy); ?>-<?php echo esc_attr($option->slug); ?>" name="shopengine_filter_color_<?php echo esc_attr($option->taxonomy); ?>" type="checkbox" id="xs-filter-color-<?php echo esc_attr($uid . '-' . $option->term_id); ?>" value="<?php echo esc_attr($option->slug); ?>" data-taxo="<?php echo esc_attr($option->taxonomy); ?>" />

                <label class="shopengine-filter-color-label" for="xs-filter-color-<?php echo esc_attr($uid . '-' . $option->term_id); ?>">
                    <?php if ($settings['shopengine_filter_color_styles']) {
                        $deafult = 'shopengine-checkbox-icon';
                        $style2 = 'shopengine-style-icon';
                        $class = $settings['shopengine_filter_color_styles'] === 'style_2' ? $style2 : $deafult;
                    } ?>
                    <span class="<?php echo esc_attr($class); ?>">
                        <span>
                            <?php
                            if ($settings['shopengine_filter_color_styles'] === 'style_2') {
                                Icons_Manager::render_icon($settings['shpengine_cirlce_icon'], ['aria-hidden' => 'true']);
                            } else {
                                Icons_Manager::render_icon($settings['shopengine_check_icon'], ['aria-hidden' => 'true']);
                            }
                            ?>
                        </span>
                    </span>
                    <?php if ($settings['shopengine_filter_color_dot_status'] === 'yes') : ?>
                        <span class="color-filter-dot" style="background: <?php echo strpos($option->color, '#') === 0 ? "" : "#"; ?><?php echo esc_attr($option->color); ?>"></span>
                    <?php endif; ?>
                    <?php echo esc_html($option->name); ?>
                </label>
            </div>
        <?php
        endforeach;
        if ($collapse) echo '</div>'; // end of collapse body container
        ?>
    </div>

    <form action="" method="get" class="shopengine-filter" id="shopengine_color_form">
        <input type="hidden" name="shopengine_filter_color" class="shopengine-filter-colors-value">
    </form>
</div>