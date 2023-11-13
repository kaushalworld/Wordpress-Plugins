<?php

namespace LivemeshAddons\Modules;

class LAE_Module_26 extends LAE_Module {

    function render() {

        $source = $this->source;

        ob_start();
        ?>

        <article class="lae-module-26 <?php echo $this->get_module_classes(); ?> <?php echo join(' ', get_post_class('', $source->post_ID)); ?>">

            <?php echo $source->get_item_template_output(); ?>

        </article><!-- .hentry -->

        <?php $output = ob_get_clean();

        return apply_filters('lae_block_module_26', $output, $source);
    }
}