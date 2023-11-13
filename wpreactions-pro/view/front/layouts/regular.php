<?php

use WPRA\Helpers\Utils;
use WPRA\Integrations\WPML;

$params       = $start_counts = [];
$data_atts    = $social_platforms = $already = '';
$total_counts = 0;

isset($data) && extract($data);

$wrap_classes = [];
if ($params['layout'] == 'regular') {
    $wrap_classes[] = 'wpra-plugin-container';
    $wrap_classes[] = 'wpra-regular';
}

$shadow_classes = [
    'false'  => '',
    'true'   => 'wpra-shadow-light',
    'light'  => 'wpra-shadow-light',
    'medium' => 'wpra-shadow-medium',
    'hard'   => 'wpra-shadow-hard',
    'dark'   => 'wpra-shadow-dark',
];

$reactions_classes = [
    $params['animation'] == 'true' ? 'wpra-animated-emojis' : 'wpra-static-emojis',
    $shadow_classes[$params['shadow']],
    'wpra-reactions-count-' . count($params['emojis']),
];

$title_text = WPML::getTranslation($params['sgc_id'], 'title_text', $params['title_text']);
?>
<div class="wpra-reactions-wrap <?php echo implode(' ', $wrap_classes); ?>" <?php Utils::echoIf($params['layout'] == 'regular', $data_atts); ?>>
    <div class="wpra-reactions-container">
        <div class="wpra-call-to-action"><?php echo $title_text; ?></div>
        <div class="wpra-reactions <?php echo implode(' ', $reactions_classes); ?>">
            <?php
            foreach ($params['emojis'] as $emoji_id):
                $emoji_count = isset($start_counts[$emoji_id]) ? $start_counts[$emoji_id] : 0;
                $flying_text = $params['flying']['type'] == 'count' ? '' : WPML::getTranslation($params['sgc_id'], "flying_labels_$emoji_id", $params['flying']['labels'][$emoji_id]);
                $start_counts_fmt = Utils::formatCount($emoji_count, $params['count_percentage'], $total_counts);
                $reaction_classes = $already == $emoji_id ? ["emoji-$emoji_id", 'active'] : ["emoji-$emoji_id"];
                $reaction_attrs = Utils::buildDataAttrs(['count' => $emoji_count, 'emoji_id' => $emoji_id]);
                ?>
                <div class="<?php echo implode(' ', $reaction_classes); ?> wpra-reaction" <?php echo $reaction_attrs; ?>>
                    <div class="wpra-flying"><?php echo $flying_text; ?></div>
                    <?php if ($params['show_count'] == 'true'): ?>
                        <div class="arrow-badge <?php Utils::echoIf($emoji_count == 0, 'hide-count'); ?>">
                            <span class="tail"></span>
                            <span class="count-num"><?php echo $start_counts_fmt; ?></span>
                        </div>
                    <?php endif;
                    Utils::renderTemplate(
                        'view/front/layouts/parts/single-emoji',
                        [
                            'animation'    => $params['animation'],
                            'emoji_id'     => $emoji_id,
                            'emoji_format' => $params['emoji_format'],
                            'is_lottie'    => $params['is_lottie'],
                        ]
                    ); ?>
                </div>
            <?php endforeach; ?>
        </div>
        <?php echo $social_platforms; ?>
    </div> <!-- end of reactions container -->
</div> <!-- end of reactions wrap -->