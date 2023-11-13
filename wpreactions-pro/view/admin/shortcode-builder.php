<?php

use WPRA\Helpers\Utils;
use WPRA\Helpers\OptionBlock;
use WPRA\FieldManager;
use WPRA\Shortcode;

$layout = '';
if (isset($data)) {
    extract($data);
}

$sgc_btn             = __('Generate Shortcode', 'wpreactions');
$shortcode_content   = $shortcode_name = '';
$shortcode_post_type = '-1';
$sgc_id              = Utils::get_query_var('id');
$front_render        = true;

if (Utils::check_query_var('sgc_action', 'edit')) {
    $sgc_btn             = __('Save Shortcode', 'wpreactions');
    $shortcode_content   = htmlspecialchars('[wpreactions sgc_id="' . $sgc_id . '"]');
    $sgc                 = Shortcode::getSgcDataBy('id', $sgc_id, ['post_type', 'name', 'front_render']);
    $shortcode_name      = $sgc->name;
    $front_render        = $sgc->front_render;
    $shortcode_post_type = $sgc->post_type;
    $shortcode_content   = is_null($shortcode_post_type)
        ? '[wpreactions sgc_id="' . $sgc_id . '"]'
        : '[wpreactions sgc_id="' . $sgc_id . '" bind_to_post="yes"]';
}
?>

<div class="wpreactions-admin-wrap wpra-shortcode-builder">
    <?php
    Utils::renderTemplate('view/admin/components/loading-overlay');
    Utils::renderTemplate(
        'view/admin/components/floating-preview',
        ['source' => 'shortcode']
    );
    Utils::renderTemplate(
        'view/admin/components/top-bar',
        [
            "section_title" => "SHORTCODE GENERATOR",
            "screen"        => "shortcode",
        ]
    );
    ?>
    <!-- Behaviour chooser -->
    <?php if (empty($layout)): ?>
        <div id="shortcode-layout-chooser" class="mt-3">
            <?php
            Utils::renderTemplate(
                'view/admin/components/option-heading',
                [
                    'heading'    => __('Reactions Shortcode', 'wpreactions'),
                    'subheading' => __('Choose a layout and go to the next step', 'wpreactions'),
                    'align'      => 'left',
                ]
            );
            OptionBlock::render("layout-chooser");
            ?>
            <button class="btn btn-primary btn-lg scg_goto_groups w-100">
                <i class="qa qa-chevron-right mr-2"></i>
                <?php _e('Choose your emojis', 'wpreactions'); ?>
            </button>
        </div>
    <?php else: ?>
        <div class="shortcode-builder-emoji-groups mt-3">
            <?php OptionBlock::render('emoji-picker'); ?>
            <button class="btn btn-primary btn-lg w-100 start-sgc">
                <i class="qa qa-chevron-right mr-2"></i>
                <?php _e('Start generating shortcode', 'wpreactions'); ?>
            </button>
        </div>
    <?php endif; ?>

    <!-- builder option blocks -->
    <div class="shortcode-builder-options mt-3" style="display: none">
        <?php
        Utils::renderTemplate('view/admin/components/banner-big');
        Utils::renderTemplateIf(!empty($layout), "view/admin/shortcode-builder/$layout");
        ?>
        <div class="option-wrap">
            <div class="row mb-3">
                <div class="col-md-12">
                    <div class="mb-3">
                        <?php
                        FieldManager\Select
                            ::create()
                            ->setId('shortcode_post_type')
                            ->setLabel('Bind to post type')
                            ->setValues(Utils::getPostTypes())
                            ->setDefault('null', __('Choose post type...', 'wpreactions'))
                            ->setValue($shortcode_post_type)
                            ->addElemClasses('wpra-no-save')
                            ->render();
                        ?>
                    </div>
                    <div class="mb-3">
                        <?php
                        FieldManager\Checkbox
                            ::create()
                            ->addCheckbox(
                                'shortcode_front_render',
                                $front_render,
                                __('Automatically render shortcode for the bound post type', 'wpreactions'),
                                true,
                                'shortcode-front-render'
                            )
                            ->addElemClasses('wpra-no-save')
                            ->render();
                        ?>
                    </div>
                    <div class="mb-3">
                        <?php
                        FieldManager\Text
                            ::create()
                            ->setId('shortcode-name')
                            ->setValue($shortcode_name)
                            ->setLabel(__('Name your shortcode', 'wpreactions'))
                            ->addElemClasses('wpra-no-save')
                            ->render();
                        ?>
                    </div>
                    <button id="save-shortcode" class="btn btn-primary w-100"><?php echo $sgc_btn; ?></button>
                    <p class="shortcode-ready text-center fw-700 mt-3 mb-0" style="display: none">
                        <?php _e('YOUR SHORTCODE IS READY! COPY AND PASTE ANYWHERE YOU WANT TO GET A REACTION!', 'wpreactions') ?>
                    </p>
                </div>
            </div>
            <div class="row mb-1">
                <div class="col-md-12">
                    <div class="shortcode-result-holder">
                        <span id="copied"><?php _e('Copied to Clipboard', 'wpreactions'); ?></span>
                        <input type="text" class="form-control wpra-no-save" id="shortcode-result"
                               value="<?php echo htmlspecialchars($shortcode_content); ?>"
                               placeholder="<?php _e('Your shortcode will appear here', 'wpreactions'); ?>" readonly>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <a href="<?php echo Utils::admin_url('admin.php?page=wpra-shortcode-generator'); ?>" class="btn btn-secondary-border btn-lg w-100">
                                <?php _e('Exit Shortcode Generator', 'wpreactions'); ?>
                            </a>
                        </div>
                        <div class="col-md-6">
                            <button id="reset-shortcode" class="btn btn-secondary btn-lg w-100">
                                <i class="qas qa-redo-alt mr-2"></i>
                                <?php _e('Reset and make more!', 'wpreactions'); ?>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php Utils::renderTemplate('view/admin/components/banner-big'); ?>
    </div>
</div>

