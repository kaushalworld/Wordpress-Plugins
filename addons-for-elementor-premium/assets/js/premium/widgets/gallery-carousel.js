( function ( $ ) {
    
    
    var WidgetLAECarouselHandler = function ( $scope, $ ) {

        var helper = new LAE_Carousel_Helper( $scope, '.lae-gallery-carousel' );

        helper.init();

    };

    var WidgetLAEGalleryCarouselHandler = function ( $scope, $ ) {

        /* ----------------- Lightbox Support ------------------ */

        $scope.fancybox( {
            selector: '.lae-gallery-carousel-item:not(.slick-cloned) a.lae-lightbox-item:not(.elementor-clickable),.lae-gallery-carousel-item:not(.slick-cloned) a.lae-video-lightbox', // the selector for gallery item
            loop: true,
            buttons: [
                "zoom",
                "share",
                "slideShow",
                "fullScreen",
                //"download",
                "thumbs",
                "close"
            ],
            thumbs: {
                autoStart: false, // Display thumbnails on opening
                hideOnClose: true, // Hide thumbnail grid when closing animation starts
                axis: "x" // Vertical (y) or horizontal (x) scrolling
            },
            caption: function ( instance, item ) {

                var caption = $( this ).attr( 'title' ) || '';

                var description = $( this ).data( 'description' ) || '';

                if (description !== '') {
                    caption += '<div class="lae-fancybox-description">' + description + '</div>';
                }

                return caption;
            }
        } );

    };

    // Make sure you run this code under Elementor..
    $( window ).on( 'elementor/frontend/init', function () {

        elementorFrontend.hooks.addAction( 'frontend/element_ready/lae-gallery-carousel.default', WidgetLAECarouselHandler );

        elementorFrontend.hooks.addAction( 'frontend/element_ready/lae-gallery-carousel.default', WidgetLAEGalleryCarouselHandler );


    } );

} )( jQuery );