<?php

namespace LivemeshAddons\Modules;

class LAE_Module_4 extends LAE_Module {

    function render() {

        $source = $this->source;

        ob_start();
        ?>

        <div class="lae-module-4 lae-small-thumb <?php echo $this->get_module_classes(); ?>">

            <?php echo $source->get_thumbnail('medium'); ?>

            <div class="lae-entry-details">

                <?php echo $source->get_title(); ?>

                <div class="lae-module-meta">

                    <?php echo $source->get_date(); ?>

                </div>

            </div>

        </div>

        <?php $output = ob_get_clean();

        return apply_filters('lae_block_module_4', $output, $source);
    }
}