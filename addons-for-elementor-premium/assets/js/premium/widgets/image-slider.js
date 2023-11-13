( function ( $ ) {


    var WidgetLAEImageSliderHandler = function ( $scope, $ ) {

        var slider_elem = $scope.find( '.lae-image-slider' ).eq( 0 );

        var rtl = slider_elem.attr( 'dir' ) === 'rtl';

        var slider_type = slider_elem.data( 'slider-type' );

        var settings = slider_elem.data( 'settings' );

        var animation = settings['slide_animation'] || "slide";

        var direction = settings['direction'] || "horizontal";

        var slideshow_speed = parseInt( settings['slideshow_speed'] ) || 5000;

        var animation_speed = parseInt( settings['animation_speed'] ) || 600;

        var pause_on_action = settings['pause_on_action'];

        var pause_on_hover = settings['pause_on_hover'];

        var direction_nav = settings['direction_nav'];

        var control_nav = settings['control_nav'];

        var slideshow = settings['slideshow'];

        var thumbnail_nav = settings['thumbnail_nav'];

        var randomize = settings['randomize'];

        var loop = settings['loop'];

        if (slider_type == 'flex') {

            var carousel_id, slider_id;

            var $parent_slider = slider_elem.find( '.lae-flexslider' );

            if (thumbnail_nav) {

                control_nav = false; // disable control nav if thumbnail slider is desired
                randomize = false; // thumbnail slider does not work right when randomize is enabled

                carousel_id = $parent_slider.attr( 'data-carousel' );
                slider_id = $parent_slider.attr( 'id' );

                jQuery( '#' + carousel_id ).flexslider( {
                    selector: ".lae-slides > .lae-slide",
                    namespace: "lae-flex-",
                    animation: "slide",
                    controlNav: false,
                    animationLoop: true,
                    slideshow: false,
                    itemWidth: 120,
                    itemMargin: 5,
                    rtl: rtl,
                    asNavFor: ( '#' + slider_id )
                } );
            }

            $parent_slider.flexslider( {
                selector: ".lae-slides > .lae-slide",
                animation: animation,
                direction: direction,
                slideshowSpeed: slideshow_speed,
                animationSpeed: animation_speed,
                namespace: "lae-flex-",
                pauseOnAction: pause_on_action,
                pauseOnHover: pause_on_hover,
                controlNav: control_nav,
                directionNav: direction_nav,
                prevText: "Previous<span></span>",
                nextText: "Next<span></span>",
                smoothHeight: false,
                animationLoop: loop,
                slideshow: slideshow,
                easing: "swing",
                randomize: randomize,
                animationLoop: loop,
                rtl: rtl,
                sync: ( carousel_id ? '#' + carousel_id : '' )
            } );
        } else if (slider_type == 'nivo') {

            // http://docs.dev7studios.com/article/13-nivo-slider-settings

            slider_elem.find( '.nivoSlider' ).nivoSlider( {
                effect: 'random',                 // Specify sets like: 'fold,fade,sliceDown'
                slices: 15,                       // For slice animations
                boxCols: 8,                       // For box animations
                boxRows: 4,                       // For box animations
                animSpeed: animation_speed,       // Slide transition speed
                pauseTime: slideshow_speed,       // How long each slide will show
                startSlide: 0,                    // Set starting Slide (0 index)
                directionNav: direction_nav,      // Next & Prev navigation
                controlNav: control_nav,          // 1,2,3... navigation
                controlNavThumbs: thumbnail_nav,  // Use thumbnails for Control Nav
                pauseOnHover: pause_on_hover,     // Stop animation while hovering
                manualAdvance: !slideshow,        // Force manual transitions
                prevText: 'Prev',                 // Prev directionNav text
                nextText: 'Next',                 // Next directionNav text
                randomStart: false,           // Start on a random slide
                beforeChange: function () {
                },       // Triggers before a slide transition
                afterChange: function () {
                },        // Triggers after a slide transition
                slideshowEnd: function () {
                },       // Triggers after all slides have been shown
                lastSlide: function () {
                },          // Triggers when last slide is shown
                afterLoad: function () {
                }           // Triggers when slider has loaded
            } );
        } else if (slider_type == 'slick') {

            slider_elem.find( '.lae-slickslider' ).slick( {
                autoplay: slideshow, // Should the slider move by itself or only be triggered manually?
                speed: animation_speed, // How fast (in milliseconds) Slick Slider should animate between slides.
                autoplaySpeed: slideshow_speed, // If autoplay is set to true, how many milliseconds should pass between moving the slides?
                dots: control_nav, // Do you want to generate an automatic clickable navigation for each slide in your slider?
                arrows: direction_nav, // Do you want to add left/right arrows to your slider?
                fade: ( animation == "fade" ), // How should Slick Slider animate each slide?
                adaptiveHeight: false, // Should Slick Slider animate the height of the container to match the current slide's height?
                pauseOnHover: pause_on_hover, // Pause Autoplay on Hover
                slidesPerRow: 1, // With grid mode intialized via the rows option, this sets how many slides are in each grid row. dver
                slidesToShow: 1, // # of slides to show
                slidesToScroll: 1, // # of slides to scroll
                vertical: ( direction == "vertical" ), // Vertical slide mode
                infinite: loop, // Infinite loop sliding
                rtl: rtl,
                useTransform: true // Use CSS3 transforms

            } );
        } else if (slider_type == 'responsive') {

            // http://responsiveslides.com/

            slider_elem.find( '.rslides' ).responsiveSlides( {
                auto: slideshow,             // Boolean: Animate automatically, true or false
                speed: animation_speed,            // Integer: Speed of the transition, in milliseconds
                timeout: slideshow_speed,          // Integer: Time between slide transitions, in milliseconds
                pager: control_nav,           // Boolean: Show pager, true or false
                nav: direction_nav,             // Boolean: Show navigation, true or false
                random: randomize,          // Boolean: Randomize the order of the slides, true or false
                pause: pause_on_hover,           // Boolean: Pause on hover, true or false
                pauseControls: false,    // Boolean: Pause when hovering controls, true or false
                prevText: "Previous",   // String: Text for the "previous" button
                nextText: "Next",       // String: Text for the "next" button
                maxwidth: "",           // Integer: Max-width of the slideshow, in pixels
                navContainer: "",       // Selector: Where controls should be appended to, default is after the 'ul'
                manualControls: "",     // Selector: Declare custom pager navigation
                namespace: "rslides",   // String: Change the default namespace used
                before: function () {
                },   // Function: Before callback
                after: function () {
                }     // Function: After callback
            } );
        }

    };

    // Make sure you run this code under Elementor..
    $( window ).on( 'elementor/frontend/init', function () {


        elementorFrontend.hooks.addAction( 'frontend/element_ready/lae-image-slider.default', WidgetLAEImageSliderHandler );


    } );

} )( jQuery );