<?php

use WPRA\Helpers\Utils;
use WPRA\FieldManager;

$options = [];
if (isset($data)) {
    extract($data);
}
?>
<div class="option-wrap">
    <div id="opt_block_animation_state">
        <div class="option-header">
            <h4>
                <span><?php _e('Emoji Animation', 'wpreactions'); ?></span>
                <?php Utils::tooltip('animation-state'); ?>
            </h4>
        </div>
        <div class="row mb-4">
            <div class="col-md-12">
                <?php
                FieldManager\Radio::create()
                    ->setName('animation')
                    ->addRadios(
                        [
                            FieldManager\RadioItem
                                ::create()
                                ->setId('animation_true')
                                ->setValue('true')
                                ->setLabel(__('Animated', 'wpreactions')),
                            FieldManager\RadioItem
                                ::create()
                                ->setId('animation_hover')
                                ->setValue('on_hover')
                                ->setLabel(__('Animate single emoji on hover', 'wpreactions')),
                            FieldManager\RadioItem
                                ::create()
                                ->setId('animation_hover_all')
                                ->setValue('on_hover_all')
                                ->setLabel(__('Animate all on hover', 'wpreactions')),
                            FieldManager\RadioItem
                                ::create()
                                ->setId('animation_false')
                                ->setValue('false')
                                ->setLabel(__('Static', 'wpreactions')),
                        ]
                    )
                    ->setChecked($options['animation'])
                    ->addClasses('form-group-inline')
                    ->render();
                ?>
            </div>
        </div>
    </div>
    <div class="option-header">
        <h4>
            <span><?php _e('Sizing Options', 'wpreactions'); ?></span>
            <?php Utils::tooltip('emoji-size'); ?>
        </h4>
        <span><?php _e('Adjust the sizing and position of your emojis', 'wpreactions'); ?></span>
    </div>
    <div class="option-emoji-adjust option-emoji-adjust-static">
        <p><?php _e('Static Emojis', 'wpreactions'); ?></p>
        <div class="row">
            <div class="col-md-4">
                <?php
                FieldManager\Range::create()
                    ->setId('adjust-static-size')
                    ->setLabel(__('Size', 'wpreactions'))
                    ->setMin(20)
                    ->setMax(200)
                    ->setValue($options['adjust']['static']['size'])
                    ->setFactoryValue($defaults['adjust']['static']['size'])
                    ->render();
                ?>
            </div>
            <div class="col-md-4">
                <?php
                FieldManager\Range::create()
                    ->setId('adjust-static-margin')
                    ->setLabel(__('Margin', 'wpreactions'))
                    ->setMin(-100)
                    ->setMax(100)
                    ->setValue($options['adjust']['static']['margin'])
                    ->setFactoryValue($defaults['adjust']['static']['margin'])
                    ->render();
                ?>
            </div>
            <div class="col-md-4">
                <?php
                FieldManager\Range::create()
                    ->setId('adjust-static-padding')
                    ->setLabel(__('Padding', 'wpreactions'))
                    ->setMin(0)
                    ->setMax(200)
                    ->setValue($options['adjust']['static']['padding'])
                    ->setFactoryValue($defaults['adjust']['static']['padding'])
                    ->render();
                ?>
            </div>
        </div>
    </div>
    <div class="option-emoji-adjust option-emoji-adjust-animated">
        <p><?php _e('Animated Emojis', 'wpreactions'); ?></p>
        <div class="row">
            <div class="col-md-4">
                <?php
                FieldManager\Range::create()
                    ->setId('adjust-animated-size')
                    ->setLabel(__('Size', 'wpreactions'))
                    ->setMin(20)
                    ->setMax(200)
                    ->setValue($options['adjust']['animated']['size'])
                    ->setFactoryValue($defaults['adjust']['animated']['size'])
                    ->render();
                ?>
            </div>
            <div class="col-md-4">
                <?php
                FieldManager\Range::create()
                    ->setId('adjust-animated-margin')
                    ->setLabel(__('Margin', 'wpreactions'))
                    ->setMin(-100)
                    ->setMax(100)
                    ->setValue($options['adjust']['animated']['margin'])
                    ->setFactoryValue($defaults['adjust']['animated']['margin'])
                    ->render();
                ?>
            </div>
            <div class="col-md-4">
                <?php
                FieldManager\Range::create()
                    ->setId('adjust-animated-padding')
                    ->setLabel(__('Padding', 'wpreactions'))
                    ->setMax(200)
                    ->setUnit('px')
                    ->setValue($options['adjust']['animated']['padding'])
                    ->setFactoryValue($defaults['adjust']['animated']['padding'])
                    ->render();
                ?>
            </div>
        </div>
    </div>
</div>
