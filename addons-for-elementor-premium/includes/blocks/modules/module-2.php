<?php

namespace LivemeshAddons\Modules;

class LAE_Module_2 extends LAE_Module {

    function render() {

        $source = $this->source;

        ob_start();
        ?>

        <div class="lae-module-2 lae-small-thumb <?php echo $this->get_module_classes(); ?>">

            <div class="lae-entry-details">

                <?php echo $source->get_title(); ?>

                <div class="lae-module-meta">

                    <?php echo $source->get_author();?>

                    <?php echo $source->get_date();?>

                    <?php echo $source->get_comments();?>

                </div>

            </div>

        </div>

        <?php $output = ob_get_clean();

        return apply_filters('lae_block_module_2', $output, $source);
    }
}