/**
 * Start remote arrows widget script
 */

;
(function ($, elementor) {
    'use strict';
    var widgetRemoteArrows = function ($scope, $) {
        var $remoteArrows = $scope.find('.bdt-remote-arrows'),
            $settings = $remoteArrows.data('settings'),
            editMode = Boolean(elementorFrontend.isEditMode());

        if (!$remoteArrows.length) {
            return;
        }

        if (!$settings.remoteId) {
            // return;
            // try to auto detect
            var $parentSection = $scope.closest('.elementor-section');

            $settings['remoteId'] = $parentSection;
        }

        if ($($settings.remoteId).find('.swiper-carousel').length <= 0) {
            if (editMode == true) {
                $($settings.id + '-notice').removeClass('bdt-hidden');
            }
            return;
        }

        $($settings.id + '-notice').addClass('bdt-hidden');

        $(document).ready(function () {
            setTimeout(() => {
                // const swiperInstance = $($settings.remoteId + '  .swiper-carousel')[0].swiper;
                const swiperInstance = $($settings.remoteId).find('.swiper-carousel')[0].swiper;

                $($settings.id).find('.bdt-prev').on("click", function () {
                    swiperInstance.slidePrev();
                });

                $($settings.id).find('.bdt-next').on("click", function () {
                    swiperInstance.slideNext();
                });

            }, 3000);

        });

    };

    jQuery(window).on('elementor/frontend/init', function () {
        elementorFrontend.hooks.addAction('frontend/element_ready/bdt-remote-arrows.default', widgetRemoteArrows);
    });

}(jQuery, window.elementorFrontend));

/**
 * End remote arrows widget script
 */