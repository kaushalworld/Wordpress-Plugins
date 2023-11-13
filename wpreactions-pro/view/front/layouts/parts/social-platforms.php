<?php

use WPRA\App;
use WPRA\Config;
use WPRA\Helpers\Utils;

$params = [];

if (isset($data)) {
    extract($data);
}

$social_wrap_class = '';
$social_icon_color = '#ffffff';

if ($params['layout'] != 'button_reveal' && $params['social_style_buttons'] == 'true') {
    $social_wrap_class = 'custom-buttons';
    $social_icon_color = $params['social']['text_color'];
}

$wrap_inline = '';
if ($params['layout'] != 'button_reveal') {
    if ($params['social_style_buttons'] == 'false') {
        $social_wrap_class .= ' wpra-share-buttons-' . $params['social']['button_type'];
    }

    if ($params['enable_share_buttons'] == 'onclick') {
        $wrap_inline = 'display: none;';
    }
}

$share_url = Utils::is_num($params['bind_id']) ? rawurlencode(get_permalink($params['bind_id'])) : '';
$platforms = [];

foreach ($params['social_platforms'] as $platform => $status):
    if ($status == 'true'):
        $label = empty($params['social_labels'][$platform])
            ? Config::$social_platforms[$platform]['label']
            : $params['social_labels'][$platform];

        if ($params['social']['button_type'] == 'bordered' && $params['social_style_buttons'] == 'false') {
            $social_icon_color = Config::$social_platforms[$platform]['color'];
        }
        ob_start(); ?>
        <a class="share-btn share-btn-<?php echo $platform; ?>"
           data-platform="<?php echo $platform; ?>">
            <span class="share-btn-icon"><?php Utils::getSocialIcon($platform, $social_icon_color, $params['social_style_buttons']); ?></span>
            <span class="share-btn-text"><?php echo esc_html($label); ?></span>
        </a>
        <?php
        $platforms[] = ob_get_clean();
    endif;
endforeach;
$active_count = sizeof($platforms);
$total_count  = App::getTotalShareCounts($params['bind_id'], isset($params['social']['fake_count']) ? $params['social']['fake_count'] : 0);

$data_attrs = Utils::buildDataAttrs([
    'share_url' => $share_url,
    'bind_id'   => $params['bind_id'],
    'source'    => $params['source'],
    'sgc_id'    => $params['sgc_id'],
    'secure'    => wp_create_nonce('wpra-share-action'),
]);

if ($params['layout'] == 'button_reveal'): ?>
    <div class="wpra-share-wrap wpra-share-buttons <?php echo $social_wrap_class; ?>"
         style="<?php echo $wrap_inline; ?>" <?php echo $data_attrs; ?>>
        <?php foreach ($platforms as $platform):
            echo $platform;
        endforeach; ?>
    </div>
<?php else:
    $init_count = min($active_count, 5) ?>
    <div class="wpra-share-wrap wpra-share-expandable"
         style="<?php Utils::echoIf($params['enable_share_buttons'] == 'onclick', 'display:none;'); ?>" <?php echo $data_attrs; ?>>
        <?php if ($params['social']['counter'] == 'true'): ?>
            <div class="wpra-share-expandable-counts">
                <span><?php echo $total_count; ?></span>
                <span><?php _e('Shares', 'wpreactions'); ?></span>
            </div>
        <?php endif; ?>
        <div class="wpra-share-buttons <?php echo $social_wrap_class; ?>">
            <?php for ($i = 0; $i < $init_count; $i++):
                echo $platforms[$i];
            endfor;
            if ($active_count > 5): ?>
                <div class="wpra-share-expandable-popup">
                    <div class="wpra-share-popup-overlay"></div>
                    <div class="wpra-share-popup">
                        <span class="wpra-share-popup-close">&times;</span>
                        <h3>Share this post!</h3>
                        <div class="wpra-share-buttons">
                            <?php foreach ($platforms as $index => $platform):
                                echo $platform;
                            endforeach; ?>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
        <?php if ($active_count > 5): ?>
            <div class="wpra-share-expandable-more">
                <i class="qa qa-share" title="More platforms"></i>
            </div>
        <?php endif; ?>
    </div>
<?php endif; ?>