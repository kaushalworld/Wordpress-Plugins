<?php

namespace LivemeshAddons\Modules;

class LAE_Module_6 extends LAE_Module {

    function render() {

        $source = $this->source;

        ob_start();
        ?>

        <div class="lae-module-6 <?php echo $this->get_module_classes(); ?>">

            <div class="lae-module-image">

                <?php echo $source->get_media(); ?>

                <?php echo $source->get_lightbox(); ?>

            </div>

            <div class="lae-entry-details">

                <?php echo $source->get_title();?>

                <div class="lae-module-meta">

                    <?php echo $source->get_author();?>

                    <?php echo $source->get_date();?>

                    <?php echo $source->get_comments();?>

                    <?php echo $source->get_taxonomies_info(); ?>

                </div>

                <div class="lae-excerpt">

                    <?php echo $source->get_excerpt();?>

                </div>

            </div>

        </div>

        <?php $output = ob_get_clean();

        return apply_filters('lae_block_module_6', $output, $source);
    }
}