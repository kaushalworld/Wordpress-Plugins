(function ($) {
    "use strict";

    var editMode = false;
    
// Blob maker script starts

var exclusiveBlob = function( $scope, $ ) {	

    var exadBlobWrapper = $scope.find( '.exad-blob-maker' ).eq(0);
    var exadBlobShape = $scope.find( '.exad-blob-maker .exad-blob-shape' );

    exadBlobShape.each(function(i) {
        var id = $(this).attr('id');
        var translateXfrom = $(this).data('translate_x_from');
        var translateXto = $(this).data('translate_x_to');
        var translateYfrom = $(this).data('translate_y_from');
        var translateYto = $(this).data('translate_y_to');
        var rotateX = $(this).data('rotate_x');
        var rotateY = $(this).data('rotate_y');
        var rotateZ = $(this).data('rotate_z');
        var scaleX = $(this).data('scale_x');
        var scaleY = $(this).data('scale_y');
        var scaleZ = $(this).data('scale_z');
        var translateXduration = $(this).data('translate_x_duration');
        var translateYduration = $(this).data('translate_y_duration');
        var rotateXduration = $(this).data('rotate_x_duration');
        var rotateYduration = $(this).data('rotate_y_duration');
        var rotateZduration = $(this).data('rotate_z_duration');
        var scaleXduration = $(this).data('scale_x_duration');
        var scaleYduration = $(this).data('scale_y_duration');
        var scaleZduration = $(this).data('scale_z_duration');
        anime({
            targets: '#'+id,
            translateX: {
                value: [ translateXfrom, translateXto ],
                duration: translateXduration
            },
            translateY: {
                value: [ translateYfrom, translateYto ],
                duration: translateYduration
            },
            rotateX: {
                value: rotateX,
                duration: rotateXduration
            },
            rotateY: {
                value: rotateY,
                duration: rotateYduration
            },
            rotateZ: {
                value: rotateZ,
                duration: rotateZduration
            },
            scaleX: {
                value: scaleX,
                duration: scaleXduration
            },
            scaleY: {
                value: scaleY,
                duration: scaleYduration
            },
            scaleZ: {
                value: scaleZ,
                duration: scaleZduration
            },
            direction: 'alternate',
            loop: true,
            easing: 'linear'
        });
    });
}

// Blob maker script starts


// chart script starts

var exclusiveChart = function( $scope, $ ) {	

	var exadChartWrapper = $scope.find( '.exad-chart-wrapper' ).eq(0),
	exadChartType        = exadChartWrapper.data( 'type' ),
	exadChartLabels      = exadChartWrapper.data( 'labels' ),
	exadChartsettings    = exadChartWrapper.data('settings'),
	
	exadChart            = $scope.find( '.exad-chart-widget' ).eq( 0 ),
	exadChartId          = exadChart.attr( 'id' ),
	ctx                  = document.getElementById( exadChartId ).getContext( '2d' ),
	myChart              = new Chart( ctx, exadChartsettings );	
}

// chart script ends


var exclusiveContentSwitcher = function ( $scope, $ ) {

    var main_switch = $scope.find( '.exad-content-switcher-toggle-switch' );
    var main_switch_span = main_switch.find( '.exad-content-switcher-toggle-switch-slider' );

    var content_1 = $scope.find('.exad-content-switcher-primary-wrap');
    var content_2 = $scope.find('.exad-content-switcher-secondary-wrap');

    if( main_switch_span.is( ':checked' ) ) {
        content_1.hide();
        content_2.show();
    } else {
        content_1.show();
        content_2.hide();
    }

    main_switch_span.on('click', function(e){
        content_1.toggle();
        content_2.toggle();
    });
};

//cookie consent script starts

var widgetCookieConsent = function( $scope, $ ) {

    var $cookieConsent = $scope.find('.exad-cookie-consent'),
        $settings      = $cookieConsent.data('settings');
    
    if ( ! $cookieConsent.length || elementorFrontend.isEditMode() ) {
        return;
    }

    window.cookieconsent.initialise($settings);

};
//cookie consent script ends

// counter up script starts

var exclusiveCounterUp = function( $scope, $ ) {
	var counterUp   = $scope.find( '.exad-counter' ).eq( 0 ),
	exadCounterTime = counterUp.data( 'counter-speed' );

    counterUp.counterUp({
        delay: 10,
        time: exadCounterTime
    } );		
}

// counter up script ends

// Thumb Preview script starts

var exclusiveDemoPreviewer = function( $scope, $ ) {
    $( window ).load( function() {

        function debounce( fn, threshold ) {
            var timeout;
            threshold = threshold || 100;
            return function debounced() {
            clearTimeout( timeout );
            var args = arguments;
            var _this = this;
            function delayed() {
                fn.apply( _this, args );
            }
            timeout = setTimeout( delayed, threshold );
            };
        }

        // flatten object by concatting values
        function concatValues( obj ) {
            var value = '';
            for ( var prop in obj ) {
            value += obj[ prop ];
            }
            return value;
        }

        if ( $.isFunction( $.fn.isotope ) ) {
            var exadThumbPreview       = $scope.find( '.exad-demo-previewer-element' ).eq( 0 ),
            currentPreviewId         = '#' + exadThumbPreview.attr( 'id' ),
            $container             = $scope.find( currentPreviewId ).eq( 0 );
            
            var previewMainWrapper = $scope.find( '.exad-demo-previewer-items' ).eq( 0 ),
            previewItem            = '#' + previewMainWrapper.attr( 'id' );

            var qsRegex;
            var buttonFilter;
            var buttonFilters = {};

            // init Isotope
            var $grid = $container.isotope({
                itemSelector: '.exad-demo-previewer-element .exad-demo-previewer-item',
                layoutMode: 'fitRows',
                filter: function() {
                    var $this = $(this);
                    var searchResult = qsRegex ? $(this).text().match( qsRegex ) : true;
                    var buttonResult = buttonFilter ? $(this).is( buttonFilter ) : true;
                    return searchResult && buttonResult;
                }
            });

            $( previewItem + ' .exad-demo-previewer-menu button' ).click( function() {

                var $this = $(this);
                var $buttonGroup = $this.parents('.exad-demo-previewer-menu');
                var filterGroup = $buttonGroup.attr('data-filter-group');
                buttonFilters[ filterGroup ] = $this.attr('data-filter');
                buttonFilter = concatValues( buttonFilters );
                $grid.isotope();
            });

            var menuItem = $scope.find( $( previewItem + ' .exad-demo-previewer-menu' ) );
            menuItem.each( function( i, buttonGroup ) {
                var $buttonGroup = $( buttonGroup );
                $buttonGroup.on( 'click', 'button', function() {
                $buttonGroup.find('.current').removeClass('current');
                $( this ).addClass('current');
                });
            });

            var searchPreview = $scope.find('#exad-demo-previewer-search-input');
            var $quicksearch = searchPreview.keyup( debounce( function() {
                qsRegex = new RegExp( $quicksearch.val(), 'gi' );
                $grid.isotope();
            }) );

            var filterWrapper = $scope.find(".exad-demo-previewer-dropdown-filter-wrapper");
            var defalutFilter = $scope.find(".exad-demo-previewer-dropdown-filter-default");
            var selectFilterList = $scope.find(".exad-demo-previewer-dropdown-filter-select li");
            var defaultFilterList = $scope.find(".exad-demo-previewer-dropdown-filter-default li");

            defalutFilter.on( 'click', function(){
                filterWrapper.toggleClass("active");
            });
            
            selectFilterList.click(function(){
                var currentele = $(this).html();
                defaultFilterList.html(currentele);
                filterWrapper.removeClass("active");
            });

			//****************************
			// Isotope Load more button
			//****************************
			var loadButton = exadThumbPreview.data('button');

			if( loadButton === 'yes' ){

				var numberCount = exadThumbPreview.data('number_item');
				var buttonText = exadThumbPreview.data('button_text');

				var initShow = numberCount;
				var counter = initShow;
				var iso = $container.data('isotope');

				loadMore(initShow);

				$container.after('<div class="exad-demo-previewer-load-more-wrapper"><a href="#" id="exad-demo-previewer-load-more-button">'+ buttonText +'</a></div>');

				var buttonClass = $scope.find('#exad-demo-previewer-load-more-button');

				function loadMore(toShow) {
					$container.find(".hidden").removeClass("hidden");

					var hiddenElems = iso.filteredItems.slice(toShow, iso.filteredItems.length).map(function(item) {
						return item.element;
					});
                    
					$(hiddenElems).addClass('hidden');
					$container.isotope('layout');

					if (hiddenElems.length == 0) {
						jQuery(buttonClass).hide();
					} else {
						jQuery(buttonClass).show();
					};

				}

				buttonClass.click(function(e) {
					e.preventDefault();
					if ($('.filter-item').data('clicked')) {
						counter = initShow;
						$('.filter-item').data('clicked', false);
					} else {
						counter = counter;
					};

					counter = counter + initShow;

					loadMore(counter);
				});

				$(".filter-item").click(function() {
					$(this).data('clicked', true);

					loadMore(initShow);
				});
			}
        }
    } );
}

// Gradiant Animation JS Start 

var BackgroundColorChange = function($scope, $) {

    var isBackgroundColorChange = $scope.hasClass( 'exad-background-color-change-yes' );
    
    if( isBackgroundColorChange ) {

        var idSection = $scope.data('id');
        var content = $( '<canvas class="exad-background-animation-canvas" id="canvas-image-' + idSection + '"></canvas>' )
        var canvasClass = $scope.prepend( content );
        var id = canvasClass.find(".exad-background-animation-canvas").attr("id");

        var bgAnimClasses = $scope.attr("class");
        var bgAnimClassesArray = bgAnimClasses.split( ' ' );

        var bgAnimClassesValue = bgAnimClassesArray.filter(function (elem) {
            return elem.startsWith('exad-color-') == true;
        });
        
        bgAnimClassesValue.sort();

        var granimInstance = new Granim({
            element: '#' +id,
            direction: 'left-right',
            isPausedWhenNotInView: true,
            states : {
                "default-state": {
                    gradients: [
                        [ bgAnimClassesValue[0].substr(12), bgAnimClassesValue[1].substr(12) ],
                        [ bgAnimClassesValue[2].substr(12), bgAnimClassesValue[3].substr(12) ],
                        [ bgAnimClassesValue[4].substr(12), bgAnimClassesValue[5].substr(12) ],
                    ]
                }
            }
        });
    }
};

jQuery(window).on('elementor/frontend/init', function () {
    elementorFrontend.hooks.addAction( 'frontend/element_ready/section', BackgroundColorChange );
});

// Gradiant Animation JS Ends 

// Gravity Form script starts

var ExadGravityForm = function( $scope, $ ) {
    var gravityFrom   = $scope.find( '.exad-gravity-form' ).eq( 0 );
    
    gravityFrom.each(function(){
        var field = $(this).find('select');
        field.parent().addClass('exad-gform-select');
    });
}

// Gravity Form script ends

/**
 * Sticky Header JS
 * 
 */

function exadHeaderScroll() {
    var regularHeader = $('#exad-masthead');
    var $wpAdminBar = $( '#wpadminbar' );
    var $mobileAdminBar;

    if ($wpAdminBar.length) {
        var $wpAdminBarHeight = $wpAdminBar.height();
    } else {
        var $wpAdminBarHeight = 0;
    }

    if (window.matchMedia("(max-width: 600px)").matches) {
        $mobileAdminBar = 0;
    } else {
        $mobileAdminBar = $wpAdminBarHeight;
    }

    if ( regularHeader.length )  {

        if ( regularHeader.hasClass("exad-sticky-header") ) {
            regularHeader.css({
                "position": "-webkit-sticky",
                "position": "sticky",
                "top": 0 + $mobileAdminBar,
            });
        }
    }

}

$(window).on('scroll resize load', function () {
    exadHeaderScroll();
});


// Image carousel starts

var exclusiveImageCarousel = function ($scope, $) {
    var imageCarouselWrapper = $scope.find(".exad-image-carousel-slider").eq(0),
        slidesToShow = imageCarouselWrapper.data("slides_to_show"),
        carouselColumnTablet = imageCarouselWrapper.data( 'slides_to_show_tablet' ),
        carouselColumnMobile = imageCarouselWrapper.data( 'slides_to_show_mobile' ),
        slidesToScroll = imageCarouselWrapper.data("slides_to_scroll"),
        carouselNav = imageCarouselWrapper.data("carousel_nav"),
        oriantation = imageCarouselWrapper.data("oriantation"),
        infiniteLoop = undefined !== imageCarouselWrapper.data("infinite_loop") ? imageCarouselWrapper.data("infinite_loop") : false,
        autoplay = undefined !== imageCarouselWrapper.data("autoplay") ? imageCarouselWrapper.data("autoplay") : false,
        autoplaySpeed = undefined !== imageCarouselWrapper.data("autoplayspeed") ? imageCarouselWrapper.data("autoplayspeed") : false,
        centerMode = undefined !== imageCarouselWrapper.data("center_mode") ? imageCarouselWrapper.data("center_mode") : false,
        centerPadding = undefined !== imageCarouselWrapper.data("center_padding") ? imageCarouselWrapper.data("center_padding") : false,
        slideFade = undefined !== imageCarouselWrapper.data("fade") ? imageCarouselWrapper.data("fade") : false,
        dotType = imageCarouselWrapper.data("dot_type"),
        prevArrow = $scope.find('.exad-image-carousel-prev'),
        nextArrow = $scope.find('.exad-image-carousel-next');

    var arrows, dots;
    if ("both" === carouselNav) {
        arrows = true;
        dots = true;
    } else if ("arrows" === carouselNav) {
        arrows = true;
        dots = false;
    } else if ("dots" === carouselNav) {
        arrows = false;
        dots = true;
    } else if ("none" === carouselNav) {
        arrows = false;
        dots = false;
    }
    
    var vertical, verticalSwiping;
    if ( "vertical" === oriantation ) {
        vertical = true;
        verticalSwiping = true;
    } else if ( "horizontal" === oriantation ) {
        vertical = false;
        verticalSwiping = false;
    }

    imageCarouselWrapper.slick({
        infinite: infiniteLoop,
        slidesToShow: slidesToShow,
        slidesToScroll: slidesToScroll,
        autoplay: autoplay,
        autoplaySpeed: autoplaySpeed,
        arrows: arrows,
        dots: dots,
        centerMode: centerMode,
        centerPadding: centerPadding+'px',
        fade: slideFade,
        vertical: vertical,
        verticalSwiping: verticalSwiping,
        prevArrow: prevArrow,
        nextArrow: nextArrow,
        customPaging: function ( slider, i ) {
            if(  'image' === dotType ){
                var image = $( slider.$slides[i] ).data( 'image' );
                return '<a><img src="' + image + '"></a>';
            }
            return;
        },
        responsive: [
            {
                breakpoint: 769,
                settings: {
                    slidesToShow: carouselColumnTablet,
                    slidesToScroll: 1,
                    dots: false,
                    centerPadding: 0,
                }
            },
            {
                breakpoint: 480,
                settings: {
                    slidesToShow: carouselColumnMobile,
                    slidesToScroll: 1,
                    dots: false,
                    centerPadding: 0,
                }
            }
          ]
    });
};

// Image carousel ends
// image hotspot script starts

var exclusiveImageHotspot = function ( $scope, $ ) {
	var hotspotWrapper = $scope.find( '.exad-hotspot' ).eq(0),
    hotspotItem        = hotspotWrapper.find( '.exad-hotspot-dot' );
    var hotspotTotalItem        = hotspotWrapper.find( '.exad-hotspot-item' );
    var style        = hotspotWrapper.data( 'style' );
    var tooltipOn        = hotspotWrapper.data( 'tooltip_on' );

    // hostpot script
    hotspotItem.each( function() {
        var leftPos = $(this).data( 'left' );
        var topPos = $(this).data( 'top' );
        $(this).css({ 'left' : leftPos, 'top' : topPos });
    } );

    if( 'tooltip-on-click' === tooltipOn ){
        if( style === 'default' ){
            hotspotItem.click(function() {
                var $parent = $(this).parent();
                $parent.toggleClass('exad-hotspot-open-default-tooltip');
                $('.exad-hotspot-item.exad-hotspot-open-default-tooltip').not($parent).removeClass('exad-hotspot-open-default-tooltip');
            });
        }
        if( style === 'style-1' ){
            hotspotItem.click(function() {
                var $parent = $(this).parent();
                $parent.toggleClass('exad-hotspot-open-tooltip');
                $('.exad-hotspot-item.exad-hotspot-open-tooltip').not($parent).removeClass('exad-hotspot-open-tooltip');
            });
        }
        if( style === 'style-2' ){
            hotspotItem.click(function() {
                var $parent = $(this).parent();
                $parent.toggleClass('exad-hotspot-open-style-2-tooltip');
                $('.exad-hotspot-item.exad-hotspot-open-style-2-tooltip').not($parent).removeClass('exad-hotspot-open-style-2-tooltip');
            });
        }
    }
}

// image hotspot script ends

// instagram carousel script starts

var exclusiveInstagramCarousel   = function( $scope, $ ) {

    var $instagramGalleryId = $scope.find('.exad-instagram-feed-item').eq(0),
        $id = $instagramGalleryId.attr('id');
        
    $('#'+$id).each(function(){
        var target = $(this).data('target');
        var token = $(this).data('access_token');
        var limit = $(this).data('limit');
        var template = $(this).data('template');
        var userFeed = new Instafeed({
            target: target,
            limit: limit,
            accessToken: token,
            template: template
        });
        userFeed.run();
    });
    
}

// instagram carousel script ends


var exadLottieAnimation = function ( $scope, $ ) {
    var lottieWrapper = $scope.find( '.exad-lottie-animation' ).eq(0);

    var lottieSource = lottieWrapper.data("lottie-source");
    var lottieRenderer = lottieWrapper.data("lottie-renderer");
    var lottieLoop = lottieWrapper.data("lottie-loop");
    var lottieSpeed = lottieWrapper.data("lottie-speed");
    var lottieType = lottieWrapper.data("lottie-trigger");
    var lottiePath;
    var autoplay;

    function bindToScroll() {
        var scrollPercentRounded;  
        $(window).scroll(function() {
            var scrollPercent = 100 * $(window).scrollTop() / ($(document).height() - $(window).height());
            scrollPercentRounded = Math.round(scrollPercent);
            init.goToAndStop( (scrollPercentRounded / 100) * 4000);
        });
    }

    function elementInViewport(elem) {
        var documentViewTop = $(window).scrollTop();
        var documentViewBottom = documentViewTop + $(window).height();
    
        var elementTop = $(elem).offset().top;
        var elementBottom = elementTop;
    
        return ((elementBottom <= documentViewBottom) && (elementTop >= documentViewTop));
    }

    function viewportScroll() {
        $(window).scroll(function() {
            if ( elementInViewport( lottieWrapper ) ){
                init.play('exad-lottie');
            } else {
                init.stop('exad-lottie');
            }
        });

    }

    if ( lottieSource == 'exad_lottie_media_file' ) {
      lottiePath = lottieWrapper.data("lottie-source-json");;
    } else if ( lottieSource == 'exad_lottie_external_url' ) {
      lottiePath = lottieWrapper.data("external-source-url");
    }
    
    if ( lottieType === 'autoplay' ) {
      autoplay = true;
    } else if ( 'on_scroll' == lottieType || 'on_viewport' == lottieType ) {
      autoplay = false;
    }

    var animData = {
        container: lottieWrapper[0],
        renderer: lottieRenderer,
        loop: lottieLoop,
        autoplay: autoplay,
        path: lottiePath,
        name: 'exad-lottie'
    };
    
    var init = bodymovin.loadAnimation(animData);

    if ( 'on_hover' == lottieType ) {
        lottieWrapper.on("mouseenter", function(){
            init.goToAndPlay(0);
        });
    } else if ( 'on_click' == lottieType ) {
        lottieWrapper.on("click", function(){
            init.goToAndPlay(0);
        });
    } else if ('on_scroll' == lottieType) {
        bindToScroll();
    } else if ('on_viewport' == lottieType ) {
        viewportScroll();
    }

    init.setSpeed( lottieSpeed );

}


window.exadMailchimpSubscribe = function( formId, apiKey, listId, buttonText, successMsg, errorMsg, loadingText ) {
	$( '#'+formId ).on('submit', function(e) {
		e.preventDefault();
		var self = $(this);

		self.find( '.exad-mailchimp-subscribe-btn span.exad-mailchimp-subscribe-btn-text' ).html( loadingText );
		$.ajax({
			url: exad_frontend_ajax_object.ajaxurl,
			type: 'POST',
			data: {
				action: 'exad_mailchimp_subscriber',
				fields: self.serialize(),
				apiKey: apiKey,
				listId: listId
			},
			success: function( param ) {
				if( 'error' !== param ) {
					self.find( '.exad-mailchimp-form-container' ).after( '<div class="exad-mailchimp-success-message"><p>'+successMsg+'</p></div>' );
					self.find( 'input[type=text], input[type=email], textarea' ).val('');
					self.find( '.exad-mailchimp-subscribe-btn span.exad-mailchimp-subscribe-btn-text' ).html( buttonText );
				} else {
					self.find( '.exad-mailchimp-form-container' ).after( '<div class="exad-mailchimp-error-message"><p>'+errorMsg+'</p></div>' );
					self.find( '.exad-mailchimp-subscribe-btn span.exad-mailchimp-subscribe-btn-text' ).html( buttonText );
				}
			}
		} );
	})
}


var exadMailChimp = function($scope, $) {
	var mailChimp = $scope.find( '.exad-mailchimp-container' ).eq(0),
	mailchimpID   = undefined !== mailChimp.data( 'mailchimp-id' ) ? mailChimp.data( 'mailchimp-id' ) : '',
	apiKey        = undefined !== mailChimp.data( 'api-key' ) ? mailChimp.data( 'api-key' ) : '',
	listID        = undefined !== mailChimp.data( 'list-id' ) ? mailChimp.data( 'list-id' ) : '',
	buttonText    = undefined !== mailChimp.data( 'button-text' ) ? mailChimp.data( 'button-text' ) : '',
	successText   = undefined !== mailChimp.data( 'success-text' ) ? mailChimp.data( 'success-text' ) : '',
	errorText     = undefined !== mailChimp.data( 'error-text' ) ? mailChimp.data( 'error-text' ) : '',
	loadingText   = undefined !== mailChimp.data( 'loading-text' ) ? mailChimp.data( 'loading-text' ) : '';

	exadMailchimpSubscribe(
		'exad-mailchimp-form-' + mailchimpID + '',
		apiKey,
		listID,
		buttonText,
		successText,
		errorText,
		loadingText
	);
}
// Mega menu js start

var MegaMenu = function( $scope, $ ) {	

    var exadMegaMenu = $scope.find( '.exad-mega-menu' ).eq(0);
    var id = $scope.data('id');
    var menuwrapper = $scope.find( '.exad-mega-menu-wrapper' );
    var menuList = $scope.find( '.exad-mega-menu-wrapper ul.exad-mega-menu-list' );
    var oriantation = exadMegaMenu.data( 'mega-menu-oriantation' );

    exadMegaMenu.find( '.exad-sub-menu' ).each( function() {
        
        var parent = $( this ).closest( '.menu-item' );

        $scope.find( parent ).addClass( 'parent-has-child' );
        $scope.find( parent ).removeClass( 'parent-has-no-child' );
    });

    if( 'horizontal' == oriantation ){
        
        $( '.elementor-element-' + id + ' .exad-mega-menu-list > li.menu-item' ).each( function() {
            var $this = $( this );
            var dropdown_width = $this.data('dropdown_width');
    
            if ( 'section' == dropdown_width ){
    
                var closeset_section = $( '.elementor-element-' + id).closest('.elementor-section');
                var sec_width = closeset_section.outerWidth();
    
                var sec_pos = closeset_section.offset().left - $this.offset().left;	
                $this.find('ul.exad-sub-menu').css('left', sec_pos + 'px' );
    
                $this.find('ul.exad-sub-menu').css('width', sec_width + 'px' );
            } else if ( 'container' == dropdown_width ){
    
                var closeset_container = $( '.elementor-element-' + id).closest('.elementor-container');
                var cont_width = closeset_container.outerWidth();
    
                var cont_pos = closeset_container.offset().left - $this.offset().left;
                $this.find('ul.exad-sub-menu').css('left', cont_pos + 'px' );
    
                $this.find('ul.exad-sub-menu').css('width', cont_width + 'px' );
            } else if( 'column' == dropdown_width ){
                var closeset_column = $( '.elementor-element-' + id).closest('.elementor-column');
                var col_width = closeset_column.outerWidth();
    
                var col_pos = closeset_column.offset().left - $this.offset().left;
                $this.find('ul.exad-sub-menu').css('left', col_pos + 'px' );
    
                $this.find('ul.exad-sub-menu').css('width', col_width + 'px' );
            }
        });
    } else{
        $( '.elementor-element-' + id + ' .exad-mega-menu-list > li.menu-item' ).each( function() {
            var $this = $( this );
            var ver_dropdown_width = $this.data('vertical_dropdown_width');
            
            if( 'vertical-container' == ver_dropdown_width ){

                var closeset_container = $( '.elementor-element-' + id).closest('.elementor-container');
                var container_width = closeset_container.outerWidth();
                var ver_width = $scope.find('.exad-mega-menu.exad-mega-menu-oriantation-vertical').outerWidth();
                var tolal_width = container_width - ver_width;
                $this.find('ul.exad-sub-menu').css('width', tolal_width + 'px' );

            }
        });
    }

    if ( $.isFunction( $.fn.slicknav ) ) {  
        menuList.slicknav({
            appendTo : menuwrapper,
            label: '',
            'afterOpen': function(){
                var navClass = $scope.find('.exad-mega-menu-wrapper .slicknav_menu .slicknav_nav');
                var id = $scope.data('id');
                var navSection = $( '.elementor-element-' + id).closest('.elementor-section');
                var navSectionWidth = navSection.outerWidth();
                navClass.css('width', navSectionWidth + 'px' );
            }
        });
    }
}

// Mega menu js end
// Nav Menu script starts
var exclusiveNavMenu = function( $scope, $ ) {
  
	var navMenuWrapper = $scope.find( '.exad-nav-menu-wrapper' ).eq(0);
	var navMenu = $scope.find( '.exad-nav-menu' ).eq(0);
	if ( $.isFunction( $.fn.slicknav ) ) {    
		navMenu.slicknav({
			prependTo: navMenuWrapper,
			parentTag: 'liner',
			allowParentLinks: true,
			duplicate: true,
			label: '',
			closedSymbol: '<span class="eicon-chevron-right"></span>',
			openedSymbol: '<span class="dashicons dashicons-arrow-down-alt2"></span>',
			'afterOpen': function(){
				var navClass = $scope.find('.exad-nav-menu-wrapper > .slicknav_menu > .slicknav_nav');
				var buttonClass = $scope.find('.exad-nav-menu-wrapper > .slicknav_menu > .slicknav_btn ');
				var buttonRight = ($(window).width() - (buttonClass.offset().left + buttonClass.outerWidth()));
				var id = $scope.data('id');
				var navSection = $( '.elementor-element-' + id).closest('.elementor-section');
				var navSectionWidth = navSection.outerWidth();
				navClass.css('width', navSectionWidth + 'px' );
				navClass.css('right', '-' + buttonRight + 'px' );
			}
		} );
	}

}
// Nav Menu script ends
// news ticker PRO script starts

var exclusiveNewsTickerPRO = function( $scope, $ ) {

    var exad_news_ticker = $scope.find( '.exad-news-ticker' );

    if ( $.isFunction( $.fn.breakingNews ) ) {  
        exad_news_ticker.each( function() {
            var t            = $(this),
            auto             = t.data( 'autoplay' ) ? !0 : !1,
            animationEffect  = t.data( 'animation' ) ? t.data( 'animation' ) : '',                                   
            fixedPosition      = t.data( 'fixed_position' ) ? t.data( 'fixed_position' ) : '',                                   
            pauseOnHover     = t.data( 'pause_on_hover' ) ? t.data( 'pause_on_hover' ) : '',                                   
            animationSpeed   = t.data( 'animation_speed' ) ? t.data( 'animation_speed' ) : '',                                   
            autoplayInterval = t.data( 'autoplay_interval' ) ? t.data( 'autoplay_interval' ) : '',                                   
            height           = t.data( 'ticker_height' ) ? t.data( 'ticker_height' ) : '',                                   
            direction        = t.data( 'direction' ) ? t.data( 'direction' ) : ''; 

            $(this).breakingNews( {
                position: fixedPosition,
                play: auto,
                direction: direction,
                scrollSpeed: animationSpeed,
                stopOnHover: pauseOnHover,
                effect: animationEffect,
                delayTimer: autoplayInterval,                    
                height: height,
                fontSize: 'default',
                themeColor: 'default',
                background: 'default'             
            } );    
        } );
    }
}

// news ticker PRO script ends

// OffCanvas PRO script starts

var exclusiveOffCanvas = function( $scope, $ ) {

    function offCanvasActive(offCanvas){
        var appearAnimation = offCanvas.find('.exad-offcanvas-content-inner').data('appear_animation');
        var position = offCanvas.find('.exad-offcanvas-content-inner').data('position');
        var width = offCanvas.find('.exad-offcanvas-content-inner').width();
        var height = offCanvas.find('.exad-offcanvas-content-inner').height();

        offCanvas.find(".exad-offcanvas-content-inner").addClass("offcanvas-active");
        offCanvas.find(".exad-offcanvas-overlay").addClass("offcanvas-active");
        if ( 'push' == appearAnimation ){
            if( 'offcanvas-left' == position ){
                $("body").addClass("offcanvas-active").css({
                    'margin-left' : width + 'px',
                });
            }
            if( 'offcanvas-right' == position ){
                $("body").addClass("offcanvas-active").css({
                    'margin-right' : width + 'px',
                });
            }
            if( 'offcanvas-top' == position ){
                $("body").addClass("offcanvas-active").css({
                    'margin-top' : height + 'px',
                });
            }
            if( 'offcanvas-top' == position ){
                $("body").addClass("offcanvas-active").css({
                    'margin-bottom' : height + 'px',
                });
            }
        }
    }

    function offCanvasRemove(offCanvas){

        var appearAnimation = offCanvas.find('.exad-offcanvas-content-inner').data('appear_animation');
        var position = offCanvas.find('.exad-offcanvas-content-inner').data('position');
        var width = offCanvas.find('.exad-offcanvas-content-inner').width();
        var height = offCanvas.find('.exad-offcanvas-content-inner').height();

        offCanvas.find(".exad-offcanvas-content-inner").removeClass("offcanvas-active");
        offCanvas.find(".exad-offcanvas-overlay").removeClass("offcanvas-active");
        if ( 'push' == appearAnimation ){
            if( 'offcanvas-left' == position ){
                $("body").removeClass("offcanvas-active").css({
                    'margin-left' : 0 + 'px',
                });
            }
            if( 'offcanvas-right' == position ){
                $("body").removeClass("offcanvas-active").css({
                    'margin-right' : 0 + 'px',
                });
            }
            if( 'offcanvas-top' == position ){
                $("body").removeClass("offcanvas-active").css({
                    'margin-top' : 0 + 'px',
                });
            }
            if( 'offcanvas-top' == position ){
                $("body").removeClass("offcanvas-active").css({
                    'margin-bottom' : 0 + 'px',
                });
            }
        }
    }

    var exadOffCanvasWrapper = $scope.find( '[data-offcanvas]' ).eq(0);

    exadOffCanvasWrapper.each( function( index ){

        var offCanvas = $(this);

        offCanvas.find( '.exad-offcanvas-open-button' ).click(function(e){
            e.preventDefault();
            offCanvasActive(offCanvas);
        });
    
        offCanvas.find( '.exad-offcanvas-close-button' ).on("click", function(e){
            e.preventDefault();
            offCanvasRemove(offCanvas);
        });

        var overlayClick = offCanvas.data('overlay_click');
        if ( 'yes' === overlayClick ){
            offCanvas.find( '.exad-offcanvas-overlay' ).on("click", function(){
                offCanvasRemove(offCanvas);
            });
        }

        $( document).on( 'keyup', function(e) {
            if ( e.keyCode == 27 ){
                var escKeypress = offCanvas.data('esc_keypress');

                if( 'yes' === escKeypress ) {
                    offCanvasRemove(offCanvas);
                }		
            }
        });

        $( document ).ready( function( e ) {

            var customClass = offCanvas.data( 'custom_class' );

            // Custom Class click event
            if( 'undefined' != typeof customClass && '' != customClass ) {
                var custom_class_selectors = customClass.split( ',' );
                if( custom_class_selectors.length > 0 ) {
                    for( var i = 0; i < custom_class_selectors.length; i++ ) {
                        if( 'undefined' != typeof custom_class_selectors[i] && '' != custom_class_selectors[i] ) {
                            $( '.' + custom_class_selectors[i] ).css( "cursor", "pointer" );
                            $( document ).on( 'click', '.' + custom_class_selectors[i], function(e) {
                                e.preventDefault();
                                offCanvasActive(offCanvas);
                            } );
                        }
                    }
                }
            }

		} );
    });
}

// OffCanvas PRO script ends

// post carousel script starts

var exclusivePostCarousel = function( $scope, $ ) {
    var carouselWrapper         = $scope.find( '.exad-post-carousel' ).eq(0),
    carouselNav                 = carouselWrapper.data( 'carousel-nav' ),
    carouselColumn              = carouselWrapper.data( 'carousel-column' ),
    carouselColumnTablet        = carouselWrapper.data( 'carousel-column-tablet' ),
    carouselColumnMobile        = carouselWrapper.data( 'carousel-column-mobile' ),
    slidesToScroll              = carouselWrapper.data( 'slidestoscroll' ),
    transitionSpeed             = carouselWrapper.data( 'carousel-speed' ),
    direction                   = carouselWrapper.data( 'direction' ),
    autoplaySpeed               = undefined !== carouselWrapper.data( 'autoplayspeed' ) ? carouselWrapper.data( 'autoplayspeed' ) : 3000,
    loop                        = undefined !== carouselWrapper.data( 'loop' )  ? carouselWrapper.data( 'loop' ) : false,
    autoPlay                    = undefined !== carouselWrapper.data( 'autoplay' ) ? carouselWrapper.data( 'autoplay' ) : false,
    pauseOnHover                = undefined !== carouselWrapper.data( 'pauseonhover' ) ? carouselWrapper.data( 'pauseonhover' ) : false;

    var arrows, dots;
    if ( 'both' === carouselNav ) {
        arrows = true;
        dots   = true;
    } else if ( 'arrows' === carouselNav ) {
        arrows = true;
        dots   = false;
    } else if ( 'dots' === carouselNav ) {
        arrows = false;
        dots   = true;
    } else {
        arrows = false;
        dots   = false;
    }
    
    carouselWrapper.slick( {
        slidesToShow: carouselColumn,
        slidesToScroll: slidesToScroll,
        arrows: arrows,
        dots: dots,
        autoplay: autoPlay,
        autoplaySpeed: autoplaySpeed,
        pauseOnHover: pauseOnHover,
        speed: transitionSpeed,
        infinite: loop,
        rtl: direction,
        prevArrow: '<div class="exad-carousel-nav-prev"><i class="eicon-chevron-left"></i></div>',
        nextArrow: '<div class="exad-carousel-nav-next"><i class="eicon-chevron-right"></i></div>',
        rows: 0,
        responsive: [
            {
                breakpoint: 1024,
                settings: {
                    slidesToShow: carouselColumnTablet,
                }
            },
            {
                breakpoint: 576,
                settings: {
                    slidesToShow: carouselColumnMobile,
                }
            }
        ]
    } );
}

// post carousel script ends

// post slider js starts heres

var exclusivePostSlider = function($scope, $) {
    var exadSliderControls = $scope.find( '.exad-slider' ).eq(0),
    sliderNav              = exadSliderControls.data( 'slider-nav' ),
    direction              = exadSliderControls.data( 'direction' ),
    transitionSpeed        = exadSliderControls.data( 'slider-speed' ),
    autoPlay               = undefined !== exadSliderControls.data( 'autoplay' ) ? exadSliderControls.data( 'autoplay' ) : false,
    pauseOnHover           = undefined !== exadSliderControls.data( 'pauseonhover' ) ? exadSliderControls.data( 'pauseonhover' ) : false,
    enableFade             = undefined !== exadSliderControls.data( 'enable-fade' ) ? exadSliderControls.data( 'enable-fade' ) : false,
    vertically             = undefined !== exadSliderControls.data( 'slide-vertically' ) ? exadSliderControls.data( 'slide-vertically' ) : false,
    centermode             = undefined !== exadSliderControls.data( 'centermode' ) ? exadSliderControls.data( 'centermode' ) : false,
    loop                   = undefined !== exadSliderControls.data( 'loop' ) ? exadSliderControls.data( 'loop' ) : false,
    autoplaySpeed          = undefined !== exadSliderControls.data( 'autoplayspeed' ) ? exadSliderControls.data( 'autoplayspeed' ) : '',
    dotsType               = undefined !== exadSliderControls.data( 'dots-type' ) ? exadSliderControls.data( 'dots-type' ) : '',
    centerModePadding      = undefined !== exadSliderControls.data( 'centermode-padding' ) ? exadSliderControls.data( 'centermode-padding' ) : '';
    
    var arrows, dots, verticalSwipe;
    if ( 'both' === sliderNav ) {
        arrows = true;
        dots   = true;
    } else if ( 'arrows' === sliderNav ) {
        arrows = true;
        dots   = false;
    } else if ( 'dots' === sliderNav ) {
        arrows = false;
        dots   = true;
    } else {
        arrows = false;
        dots   = false;
    }

    if( true === vertically ) {
        verticalSwipe = true;
    } else {
        verticalSwipe = false;
    }

    exadSliderControls.slick( {
        slidesToShow: 1,
        arrows: arrows,
        dots: dots,
        autoplay: autoPlay,
        fade: enableFade,
        centerMode: centermode,
        centerPadding: centerModePadding,
        vertical: vertically,
        verticalSwiping: verticalSwipe,
        pauseOnHover: pauseOnHover,
        infinite: loop,
        rtl: direction,
        autoplaySpeed: autoplaySpeed,
        speed: transitionSpeed,
        customPaging: function ( slider, i ) {
            if( dotsType == 'dot-image' ){
                var image = $( slider.$slides[i] ).data( 'image' );
                return '<a><img src="' + image + '"></a>';
            }
            return;
        },
        responsive: [
            {
              breakpoint: 991,
              settings: {
                centerPadding: 0,
              }
            },
        ]
    } );
 
    exadSliderControls.slickAnimation();
}
// post slider js starts ends

// product cross-sells script starts
var exclusiveProductCrossSellCarousel = function( $scope, $ ) {

    var upsell_product_JsVars = {
        prev_html: '<a href="#" class="product-prev"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-left"><polyline points="15 18 9 12 15 6"></polyline></svg></a>',
        next_html: '<a href="#" class="product-next"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg></a>',
        dots_html: '<div class="exad-dots-container"><div class="exad-swiper-pagination swiper-pagination"></div></div>',
    };

    var sw_selector = $scope.hasClass("exad-product-cross-sell-carousel-layout");
    var wrapper = $scope.find(".cross-sells");
    var thumb_item = wrapper.find("ul");

    if ( sw_selector ) {
        var settings = $('.elementor-widget-exad-product-cross-sell').data('carousel');
        thumb_item.wrap("<div class='cross-sell-pro-swiper swiper-container'></div>");
        thumb_item.addClass("swiper-wrapper");
        thumb_item.find("li").addClass("swiper-slide");
        $(upsell_product_JsVars.dots_html).insertAfter('.cross-sell-pro-swiper');

        if ( settings.navigation ) {
            $(upsell_product_JsVars.next_html).insertAfter('.cross-sell-pro-swiper');
            $(upsell_product_JsVars.prev_html).insertAfter('.cross-sell-pro-swiper');
        }

        var crossSellSwiper = new Swiper(".cross-sell-pro-swiper", settings);

    }
}
// product upsell script ends

var exadPromoBoxCountdownTimer = function ( $scope, $ ) {
    var countdownTimerWrapper = $scope.find( '[data-countdown]' ).eq(0);

    var parentClass = $scope.find('.exad-promo-box-wrapper');
    var position = parentClass.data('position');
    var parentHeight = parentClass.outerHeight();

    if( position === 'top' ){
        var margin = $("body.exclusive-addons-elementor").css("margin-top",  parentHeight + "px");
    }

    if ( 'undefined' !== typeof countdownTimerWrapper && null !== countdownTimerWrapper ) {
        var $this   = countdownTimerWrapper,
        finalDate   = $this.data( 'countdown' ),
        day         = $this.data( 'day' ),
        hours       = $this.data( 'hours' ),
        minutes     = $this.data( 'minutes' ),
        seconds     = $this.data( 'seconds' ),
        expiredText = $this.data( 'expired-text' );

        if ( $.isFunction( $.fn.countdown ) ) {
            $this.countdown( finalDate, function ( event ) {
                $( this ).html( event.strftime(' ' +
                    '<div class="exad-countdown-container"><div class="exad-countdown-timer-wrapper"><span class="exad-countdown-count">%-D </span><span class="exad-countdown-title">' + day + '</span></div></div>' +
                    '<div class="exad-countdown-container"><div class="exad-countdown-timer-wrapper"><span class="exad-countdown-count">%H </span><span class="exad-countdown-title">' + hours + '</span></div></div>' +
                    '<div class="exad-countdown-container"><div class="exad-countdown-timer-wrapper"><span class="exad-countdown-count">%M </span><span class="exad-countdown-title">' + minutes + '</span></div></div>' +
                    '<div class="exad-countdown-container"><div class="exad-countdown-timer-wrapper"><span class="exad-countdown-count">%S </span><span class="exad-countdown-title">' + seconds + '</span></div></div>'));
            } ).on( 'finish.countdown', function (event) {
                $(this).html( '<p class="message">'+ expiredText +'</p>' );
            } );
        }
    }
}

var exadPromoBoxAlert = function( $scope, $ ) {
    var getPromoBox = $scope.find( '.exad-promo-box-container' ).eq(0),
    currentPromoID            = '#' + getPromoBox.attr('id'),
    exadPromoID               = $scope.find( currentPromoID ).eq(0);

    var alertClose = $scope.find( exadPromoID ).eq(0);
    alertClose.each( function( index ){
        var alert = $(this);
        alert.find( '.exad-promo-box-dismiss-icon' ).click( function( e ){
            e.preventDefault();
            alert.fadeOut( 500 );
            $("body.exclusive-addons-elementor").css("margin-top",  "0px");
            $("body.exclusive-addons-elementor").css("transition",  "0.5s");
        } );
    } );

    $(window).load(function() {
        var viewportWidth = $(window).width();
        if ( viewportWidth < 768 ) {
            $( '.exad-promo-position-top' ).addClass( 'exad-responsive-promo-box' );
            $( '.exad-promo-position-bottom' ).addClass( 'exad-responsive-promo-box' );
        }
    } );
}
// Search Form script starts

var exclusiveSearchForm = function( $scope, $ ) {

    $scope.find( ".exad-search-form-input" ).focus( function(){
        $scope.find( ".exad-search-button-wrapper" ).addClass( "exad-input-focus" );
    } );

    $scope.find( ".exad-search-form-input" ).blur( function() {
        $scope.find( ".exad-search-button-wrapper" ).removeClass( "exad-input-focus" );
    } );        
}
// Search Form script ends

// Parallax Effect Script Start
var ExadParallaxEffect = function($scope, $) {

    var isParallaxEffect = $scope.hasClass("exad-parallax-effect-yes");
    var parallaxType = $scope.data("parallax_type")
    var elementId = $scope.data("id");

    $(".exad-parallax-scene").each(function () {
        try {
            var elem = $(this).next(".exad-parallax-effect-yes")[0];
            $(this).prependTo(elem);
        } catch (e) {
            
        }
    });

    if ( isParallaxEffect ) {

        if ( elementorFrontend.isEditMode() ) {
            var list;
            var data = {};
            var self = {};
            if (!window.elementor.hasOwnProperty("elements")) {
                return false;
            }
            if (!(list = window.elementor.elements).models) {
                return false;
            }
            $.each(list.models, function(values, settings) {
                if (elementId == settings.id) {
                    data = settings.attributes.settings.attributes;
                    
                } else {
                    if (settings.id == $scope.closest(".elementor-top-section").data("id")) {
                    $.each(settings.attributes.elements.models, function(values, objects) {
                        $.each(objects.attributes.elements.models, function(values, media) {
                        data = media.attributes.settings.attributes;
                        });
                    });
                    }
                    
                }
            });
            self.id = elementId;
            self.switch = data.exad_enable_section_parallax_effect;
            self.parallax_type = data.exad_parallax_effect_type;
            self.data_bg_image = data.exad_parallax_effect_background_image.url;
            
            if (0 !== self.length) {
                self = self;
            }

        } else {
            
            if ( 'multi-image' == parallaxType ) {
                $( "#exad-parallax-scene-" + elementId ).each(function() {
                    var id = $(this).attr('id');
                    var scene = document.getElementById(id);
                    new Parallax( scene, {
                        relativeInput: true,
                        hoverOnly: true,
                        pointerEvents: true
                    });
                });
            }
        }

        if (!elementorFrontend.isEditMode() || !self) {
            return false;
        }

        if ( 'yes' == self.switch ) {
            if ( 'background' == self.parallax_type ) {
                $( "#exad-parallax-scene-" + self.id ).each(function() {
                    $(this).parallax({imageSrc: self.data_bg_image });
                }); 
            } else if ( 'multi-image' == self.parallax_type ) {
                $( "#exad-parallax-scene-" + self.id ).each(function() {
                    
                    var id = $(this).attr('id');
                    var scene = document.getElementById(id);
                    new Parallax( scene, {
                        relativeInput: true,
                        hoverOnly: true,
                        pointerEvents: true
                    });
                });
            }
        }
    }

};
// Parallax Effect Script End



var SectionParticles = function($element, $) {
    var elementId = $element.data("id");

    var polygon = {"particles":{"number":{"value":80,"density":{"enable":true,"value_area":800}},"color":{"value":"#ffffff"},"shape":{"type":"circle","stroke":{"width":0,"color":"#000000"},"polygon":{"nb_sides":5},"image":{"src":"img\/github.svg","width":100,"height":100}},"opacity":{"value":0.5,"random":false,"anim":{"enable":false,"speed":1,"opacity_min":0.1,"sync":false}},"size":{"value":3,"random":true,"anim":{"enable":false,"speed":40,"size_min":0.1,"sync":false}},"line_linked":{"enable":true,"distance":150,"color":"#ffffff","opacity":0.4,"width":1},"move":{"enable":true,"speed":6,"direction":"none","random":false,"straight":false,"out_mode":"out","bounce":false,"attract":{"enable":false,"rotateX":600,"rotateY":1200}}},"interactivity":{"detect_on":"canvas","events":{"onhover":{"enable":true,"mode":"repulse"},"onclick":{"enable":true,"mode":"push"},"resize":true},"modes":{"grab":{"distance":400,"line_linked":{"opacity":1}},"bubble":{"distance":400,"size":40,"duration":2,"opacity":8,"speed":3},"repulse":{"distance":200,"duration":0.4},"push":{"particles_nb":4},"remove":{"particles_nb":2}}},"retina_detect":true}
    var nasa = {"particles":{"number":{"value":160,"density":{"enable":true,"value_area":800}},"color":{"value":"#ffffff"},"shape":{"type":"circle","stroke":{"width":0,"color":"#000000"},"polygon":{"nb_sides":5},"image":{"src":"img\/github.svg","width":100,"height":100}},"opacity":{"value":1,"random":true,"anim":{"enable":true,"speed":1,"opacity_min":0,"sync":false}},"size":{"value":3,"random":true,"anim":{"enable":false,"speed":4,"size_min":0.3,"sync":false}},"line_linked":{"enable":false,"distance":150,"color":"#ffffff","opacity":0.4,"width":1},"move":{"enable":true,"speed":1,"direction":"none","random":true,"straight":false,"out_mode":"out","bounce":false,"attract":{"enable":false,"rotateX":600,"rotateY":600}}},"interactivity":{"detect_on":"canvas","events":{"onhover":{"enable":true,"mode":"bubble"},"onclick":{"enable":true,"mode":"repulse"},"resize":true},"modes":{"grab":{"distance":400,"line_linked":{"opacity":1}},"bubble":{"distance":250,"size":0,"duration":2,"opacity":0,"speed":3},"repulse":{"distance":400,"duration":0.4},"push":{"particles_nb":4},"remove":{"particles_nb":2}}},"retina_detect":true}
    var bubble = {"particles":{"number":{"value":6,"density":{"enable":true,"value_area":800}},"color":{"value":"#1b1e34"},"shape":{"type":"polygon","stroke":{"width":0,"color":"#000"},"polygon":{"nb_sides":6},"image":{"src":"img\/github.svg","width":100,"height":100}},"opacity":{"value":0.3,"random":true,"anim":{"enable":false,"speed":1,"opacity_min":0.1,"sync":false}},"size":{"value":50,"random":false,"anim":{"enable":true,"speed":10,"size_min":40,"sync":false}},"line_linked":{"enable":false,"distance":200,"color":"#ffffff","opacity":1,"width":2},"move":{"enable":true,"speed":8,"direction":"none","random":false,"straight":false,"out_mode":"out","bounce":false,"attract":{"enable":false,"rotateX":600,"rotateY":1200}}},"interactivity":{"detect_on":"canvas","events":{"onhover":{"enable":false,"mode":"grab"},"onclick":{"enable":false,"mode":"push"},"resize":true},"modes":{"grab":{"distance":400,"line_linked":{"opacity":1}},"bubble":{"distance":400,"size":40,"duration":2,"opacity":8,"speed":3},"repulse":{"distance":200,"duration":0.4},"push":{"particles_nb":4},"remove":{"particles_nb":2}}},"retina_detect":true}
    var snow = {"particles":{"number":{"value":400,"density":{"enable":true,"value_area":800}},"color":{"value":"#fff"},"shape":{"type":"circle","stroke":{"width":0,"color":"#000000"},"polygon":{"nb_sides":5},"image":{"src":"img\/github.svg","width":100,"height":100}},"opacity":{"value":0.5,"random":true,"anim":{"enable":false,"speed":1,"opacity_min":0.1,"sync":false}},"size":{"value":10,"random":true,"anim":{"enable":false,"speed":40,"size_min":0.1,"sync":false}},"line_linked":{"enable":false,"distance":500,"color":"#ffffff","opacity":0.4,"width":2},"move":{"enable":true,"speed":6,"direction":"bottom","random":false,"straight":false,"out_mode":"out","bounce":false,"attract":{"enable":false,"rotateX":600,"rotateY":1200}}},"interactivity":{"detect_on":"canvas","events":{"onhover":{"enable":true,"mode":"bubble"},"onclick":{"enable":true,"mode":"repulse"},"resize":true},"modes":{"grab":{"distance":400,"line_linked":{"opacity":0.5}},"bubble":{"distance":400,"size":4,"duration":0.3,"opacity":1,"speed":3},"repulse":{"distance":200,"duration":0.4},"push":{"particles_nb":4},"remove":{"particles_nb":2}}},"retina_detect":true}
    var nyan_cat = {"particles":{"number":{"value":100,"density":{"enable":false,"value_area":800}},"color":{"value":"#ffffff"},"shape":{"type":"star","stroke":{"width":0,"color":"#000000"},"polygon":{"nb_sides":5},"image":{"src":"http:\/\/wiki.lexisnexis.com\/academic\/images\/f\/fb\/Itunes_podcast_icon_300.jpg","width":100,"height":100}},"opacity":{"value":0.5,"random":false,"anim":{"enable":false,"speed":1,"opacity_min":0.1,"sync":false}},"size":{"value":4,"random":true,"anim":{"enable":false,"speed":40,"size_min":0.1,"sync":false}},"line_linked":{"enable":false,"distance":150,"color":"#ffffff","opacity":0.4,"width":1},"move":{"enable":true,"speed":14,"direction":"left","random":false,"straight":true,"out_mode":"out","bounce":false,"attract":{"enable":false,"rotateX":600,"rotateY":1200}}},"interactivity":{"detect_on":"canvas","events":{"onhover":{"enable":false,"mode":"grab"},"onclick":{"enable":true,"mode":"repulse"},"resize":true},"modes":{"grab":{"distance":200,"line_linked":{"opacity":1}},"bubble":{"distance":400,"size":40,"duration":2,"opacity":8,"speed":3},"repulse":{"distance":200,"duration":0.4},"push":{"particles_nb":4},"remove":{"particles_nb":2}}},"retina_detect":true}
    
    var particleThemeName = $element.data("exad-preset-theme");
    var particleCustomStyle = $element.data("exad-custom-style");
    var particleThemeSource = $element.data("exad-ptheme-source");
    var particleColor = $element.data('exad-particle-color');
    var particleNumber = $element.data('exad-particle-number');
    var linkLineColor = $element.data('exad-line-link-color');
    var linkLineDistance = $element.data('exad-line-link-distance');
    var particleSize = $element.data('exad-particle-size');
    var moveDirection = $element.data('exad-particle-move-direction');
    var moveSpeed = $element.data('exad-particle-move-speed');
    var interactivityEnableHover = $element.data('exad-particle-interactivity-enable-hover');
    var interactivityEnableClick = $element.data('exad-particle-interactivity-enable-click');
    var interactivityHoverMode = $element.data('exad-particle-interactivity-hover-mode');
    var interactivityClickMode = $element.data('exad-particle-interactivity-click-mode');


        if ("custom" != particleThemeSource || "" != particleThemeSource) {
            
        if ( $element.addClass("exad-particles-section"), elementorFrontend.isEditMode() ) {
            var list;
            var data = {};
            var self = {};
            if (!window.elementor.hasOwnProperty("elements")) {
                return false;
            }
            if (!(list = window.elementor.elements).models) {
                return false;
            }
            $.each(list.models, function(values, settings) {
                if (elementId == settings.id) {
                    data = settings.attributes.settings.attributes;
                    
                } else {
                    if (settings.id == $element.closest(".elementor-top-section").data("id")) {
                    $.each(settings.attributes.elements.models, function(values, objects) {
                        $.each(objects.attributes.elements.models, function(values, media) {
                        data = media.attributes.settings.attributes;
                        });
                    });
                    }
                    
                }
            });
            self.switch = data.exad_particle_switch;
            self.themeSource = data.exad_particle_theme_from;
            self.color = data.exad_particle_color;
            self.number = data.exad_particle_number;
            self.line_linked = data.exad_particle_line_link_color;
            self.line_linked_distance = data.exad_particle_line_link_distance;
            self.size = data.exad_particle_size;
            self.move_direction = data.exad_particle_move_direction;
            self.move_speed = data.exad_particle_moving_speed;
            self.interactivity_enable_hover = data.exad_particle_interactivity_enable_hover;
            self.interactivity_enable_click = data.exad_particle_interactivity_enable_click;
            self.interactivity_hover_mode = data.exad_particle_interactivity_hover_mode;
            self.interactivity_click_mode = data.exad_particle_interactivity_click_mode;
            
            if ("presets" == self.themeSource) {
                self.selected_theme = data.exad_particle_preset_themes;
                
            }
            if ("custom" == self.themeSource && "" !== data.exad_particles_custom_style) {
                self.selected_theme = data.exad_particles_custom_style;
            }
            if (0 !== self.length) {
                self = self;
            }
        } else {
            $(".exad-section-particles-" + elementId).each(function() {
                particleThemeSource = $(this).data("exad-theme-source");

                polygon.particles.color.value = nasa.particles.color.value = bubble.particles.color.value = snow.particles.color.value = nyan_cat.particles.color.value = particleColor;
                polygon.particles.number.value = nasa.particles.number.value = bubble.particles.number.value = snow.particles.number.value = nyan_cat.particles.number.value = particleNumber;
                polygon.particles.line_linked.color = nasa.particles.line_linked.color = bubble.particles.line_linked.color = snow.particles.line_linked.color = nyan_cat.particles.line_linked.color = linkLineColor;
                polygon.particles.line_linked.distance = nasa.particles.line_linked.distance = bubble.particles.line_linked.distance = snow.particles.line_linked.distance = nyan_cat.particles.line_linked.distance = linkLineDistance;
                polygon.particles.size.value = nasa.particles.size.value = bubble.particles.size.value = snow.particles.size.value = nyan_cat.particles.size.value = particleSize;
                polygon.particles.move.direction = nasa.particles.move.direction = bubble.particles.move.direction = snow.particles.move.direction = nyan_cat.particles.move.direction = moveDirection;
                polygon.particles.move.speed = nasa.particles.move.speed = bubble.particles.move.speed = snow.particles.move.speed = nyan_cat.particles.move.speed = moveSpeed;
                polygon.interactivity.events.onhover.enable = nasa.interactivity.events.onhover.enable = bubble.interactivity.events.onhover.enable = snow.interactivity.events.onhover.enable = nyan_cat.interactivity.events.onhover.enable = interactivityEnableHover;
                polygon.interactivity.events.onclick.enable = nasa.interactivity.events.onclick.enable = bubble.interactivity.events.onclick.enable = snow.interactivity.events.onclick.enable = nyan_cat.interactivity.events.onclick.enable = interactivityEnableClick;
                polygon.interactivity.events.onhover.mode = nasa.interactivity.events.onhover.mode = bubble.interactivity.events.onhover.mode = snow.interactivity.events.onhover.mode = nyan_cat.interactivity.events.onhover.mode = interactivityHoverMode;
                polygon.interactivity.events.onclick.mode = nasa.interactivity.events.onclick.mode = bubble.interactivity.events.onclick.mode = snow.interactivity.events.onclick.mode = nyan_cat.interactivity.events.onclick.mode = interactivityClickMode;
                
                var themes = "presets" == particleThemeSource ? particleThemeName : "" != particleCustomStyle ? particleCustomStyle : void 0;
                var particleParentId = $(this).attr("id");
                if (null == particleParentId) {
                    $(this).attr("id", "exad-section-particles-" + elementId);
                    particleParentId = $(this).attr("id");
                }
                
                particlesJS(particleParentId, eval(themes));
            });
        }
        if (!elementorFrontend.isEditMode() || !self) {
            return false;
        }
        if ( "yes" == self.switch ) {
            if ( ("presets" === self.themeSource || "custom" === self.themeSource && "" !== self.selected_theme) && "undefined" != typeof particlesJS && $.isFunction(particlesJS) ) {
                $element.attr("id", "exad-section-particles-" + elementId);
                polygon.particles.color.value = nasa.particles.color.value = bubble.particles.color.value = snow.particles.color.value = nyan_cat.particles.color.value = self.color;
                polygon.particles.number.value = nasa.particles.number.value = bubble.particles.number.value = snow.particles.number.value = nyan_cat.particles.number.value = self.number;
                polygon.particles.line_linked.color = nasa.particles.line_linked.color = bubble.particles.line_linked.color = snow.particles.line_linked.color = nyan_cat.particles.line_linked.color = self.line_linked;
                polygon.particles.line_linked.distance = nasa.particles.line_linked.distance = bubble.particles.line_linked.distance = snow.particles.line_linked.distance = nyan_cat.particles.line_linked.distance = self.line_linked_distance;
                polygon.particles.size.value = nasa.particles.size.value = bubble.particles.size.value = snow.particles.size.value = nyan_cat.particles.size.value = self.size;
                polygon.particles.move.direction = nasa.particles.move.direction = bubble.particles.move.direction = snow.particles.move.direction = nyan_cat.particles.move.direction = self.move_direction;
                polygon.particles.move.speed = nasa.particles.move.speed = bubble.particles.move.speed = snow.particles.move.speed = nyan_cat.particles.move.speed = self.move_speed;
                polygon.interactivity.events.onhover.enable = nasa.interactivity.events.onhover.enable = bubble.interactivity.events.onhover.enable = snow.interactivity.events.onhover.enable = nyan_cat.interactivity.events.onhover.enable = self.interactivity_enable_hover;
                polygon.interactivity.events.onclick.enable = nasa.interactivity.events.onclick.enable = bubble.interactivity.events.onclick.enable = snow.interactivity.events.onclick.enable = nyan_cat.interactivity.events.onclick.enable = self.interactivity_enable_click;
                polygon.interactivity.events.onhover.mode = nasa.interactivity.events.onhover.mode = bubble.interactivity.events.onhover.mode = snow.interactivity.events.onhover.mode = nyan_cat.interactivity.events.onhover.mode = self.interactivity_hover_mode;
                polygon.interactivity.events.onclick.mode = nasa.interactivity.events.onclick.mode = bubble.interactivity.events.onclick.mode = snow.interactivity.events.onclick.mode = nyan_cat.interactivity.events.onclick.mode = self.interactivity_click_mode;
                
                particlesJS("exad-section-particles-" + elementId, eval(self.selected_theme));
                $element.children("canvas.particles-js-canvas-el").css({
                    position : "absolute",
                    top : 0
                });
            }
        } else {
            $element.removeClass("exad-particles-section");
        }
    }
};

/* Section Particles End here */


// Woo cart Js Start for single product

var exclusiveProductCart = function( $scope, $ ) {
    var exadCartWrapper = $scope.find( '.exad-product-add-to-cart' );

    var inputClass = $scope.find( '.exad-product-add-to-cart .cart .quantity input.qty' );

    $( '<button class="exad-quantity-minus-btn"></button>' ).insertBefore( inputClass );
    $( '<button class="exad-quantity-plus-btn"></button>' ).insertAfter( inputClass );

    var minusButton = $scope.find( '.exad-quantity-minus-btn' );
    var plusButton = $scope.find( '.exad-quantity-plus-btn' );

    minusButton.click(function (e) { 
        e.preventDefault();
        this.parentNode.querySelector('input[type=number]').stepDown();
    });
    plusButton.click(function (e) { 
        e.preventDefault();
        this.parentNode.querySelector('input[type=number]').stepUp();
    });
}

// Woo cart Js Start for single product End
// single product page script starts

var exclusiveProductThumbCarousel = function( $scope, $ ) {

    var thumb_product_JsVars = {
        prev_html: '<a href="#" class="thumb-prev"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-left"><polyline points="15 18 9 12 15 6"></polyline></svg></a>',
        next_html: '<a href="#" class="thumb-next"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg></a>',
        v_prev_html: '<a href="#" class="thumb-prev"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-down"><polyline points="6 9 12 15 18 9"></polyline></svg></a>',
        v_next_html: '<a href="#" class="thumb-next"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-up"><polyline points="18 15 12 9 6 15"></polyline></svg></a>',
    };

    var sw_selector = $scope.hasClass("exad-product-thumb-view-carousel");
    if ( sw_selector ) {
        var settings = $('.exad-product-image').data('carousel_type');
        var g = $scope.find(".woocommerce-product-gallery");
        var control_thumbs = g.find(".flex-control-thumbs");
     
        $('.woocommerce-product-gallery__trigger, .flex-viewport').wrapAll('<div class="all-img-content"></div>');
        control_thumbs.wrap("<div class='thumbnail-carousel-container'><div class='gallery-thumb-swiper swiper-container'></div></div>");
        control_thumbs.addClass("swiper-wrapper");
        control_thumbs.find("li").addClass("swiper-slide");


        if ( true == settings.arrows ) {
            if ( settings.direction == "vertical" ) {
                $(thumb_product_JsVars.v_prev_html).insertAfter('.gallery-thumb-swiper');
                $(thumb_product_JsVars.v_next_html).insertAfter('.gallery-thumb-swiper');
            }else {
                $(thumb_product_JsVars.prev_html).insertAfter('.gallery-thumb-swiper');
                $(thumb_product_JsVars.next_html).insertAfter('.gallery-thumb-swiper');
            }
        }
        var thumbSwiper = new Swiper(".gallery-thumb-swiper", settings);
    }

}

// single product page script end
// product related script start 
var exclusiveProductRelatedCarousel = function( $scope, $ ) {

    var related_product_JsVars = {
        prev_html: '<a href="#" class="product-prev"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-left"><polyline points="15 18 9 12 15 6"></polyline></svg></a>',
        next_html: '<a href="#" class="product-next"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg></a>',
        dots_html: '<div class="exad-dots-container"><div class="exad-swiper-pagination swiper-pagination"></div></div>',
    };

    
    var sw_selector = $scope.hasClass("exad-product-carousel-layout");
    var wrapper = $scope.find("section.related");
    var thumb_item = wrapper.find("ul.products");


    if ( sw_selector ) {
        var settings = $('.exad-product-related').data('carousel');
        thumb_item.wrap("<div class='related-pro-swiper swiper-container'></div>");
        thumb_item.addClass("swiper-wrapper");
        thumb_item.find("li.product").addClass("swiper-slide");
        $(related_product_JsVars.dots_html).insertAfter('.related-pro-swiper');

        if ( settings.navigation ) {
            $(related_product_JsVars.next_html).insertAfter('.related-pro-swiper');
            $(related_product_JsVars.prev_html).insertAfter('.related-pro-swiper');
        }

        var relatedSwiper = new Swiper(".related-pro-swiper", settings);

    }
}
// product related script ends
// product upsell script starts
var exclusiveProductUpsellCarousel = function( $scope, $ ) {

    var upsell_product_JsVars = {
        prev_html: '<a href="#" class="product-prev"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-left"><polyline points="15 18 9 12 15 6"></polyline></svg></a>',
        next_html: '<a href="#" class="product-next"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg></a>',
        dots_html: '<div class="exad-dots-container"><div class="exad-swiper-pagination swiper-pagination"></div></div>',
    };

    var sw_selector = $scope.hasClass("exad-product-upsell-carousel-layout");
    var wrapper = $scope.find("section.upsells");
    var thumb_item = wrapper.find("ul.products");    

    if ( sw_selector ) {
        var settings = $('.exad-product-upsell').data('carousel');
        thumb_item.wrap("<div class='upsell-pro-swiper swiper-container'></div>");
        thumb_item.addClass("swiper-wrapper");
        thumb_item.find("li.product").addClass("swiper-slide");
        $(upsell_product_JsVars.dots_html).insertAfter('.upsell-pro-swiper');

        if ( settings.navigation ) {
            $(upsell_product_JsVars.next_html).insertAfter('.upsell-pro-swiper');
            $(upsell_product_JsVars.prev_html).insertAfter('.upsell-pro-swiper');
        }

        var upsellSwiper = new Swiper(".upsell-pro-swiper", settings);

    }
}
// product upsell script ends

// slider js starts heres

var exclusiveSlider = function($scope, $) {
    var exadSliderControls = $scope.find( '.exad-slider' ).eq(0),
    sliderNav              = exadSliderControls.data( 'slider-nav' ),
    direction              = exadSliderControls.data( 'direction' ),
    transitionSpeed        = exadSliderControls.data( 'slider-speed' ),
    autoPlay               = undefined !== exadSliderControls.data( 'autoplay' ) ? exadSliderControls.data( 'autoplay' ) : false,
    pauseOnHover           = undefined !== exadSliderControls.data( 'pauseonhover' ) ? exadSliderControls.data( 'pauseonhover' ) : false,
    enableFade             = undefined !== exadSliderControls.data( 'enable-fade' ) ? exadSliderControls.data( 'enable-fade' ) : false,
    vertically             = undefined !== exadSliderControls.data( 'slide-vertically' ) ? exadSliderControls.data( 'slide-vertically' ) : false,
    centermode             = undefined !== exadSliderControls.data( 'centermode' ) ? exadSliderControls.data( 'centermode' ) : false,
    loop                   = undefined !== exadSliderControls.data( 'loop' ) ? exadSliderControls.data( 'loop' ) : false,
    autoplaySpeed          = undefined !== exadSliderControls.data( 'autoplayspeed' ) ? exadSliderControls.data( 'autoplayspeed' ) : '',
    dotsType               = undefined !== exadSliderControls.data( 'dots-type' ) ? exadSliderControls.data( 'dots-type' ) : '',
    centerModePadding      = undefined !== exadSliderControls.data( 'centermode-padding' ) ? exadSliderControls.data( 'centermode-padding' ) : '';
    
    var arrows, dots, verticalSwipe;
    if ( 'both' === sliderNav ) {
        arrows = true;
        dots   = true;
    } else if ( 'arrows' === sliderNav ) {
        arrows = true;
        dots   = false;
    } else if ( 'dots' === sliderNav ) {
        arrows = false;
        dots   = true;
    } else {
        arrows = false;
        dots   = false;
    }

    if( true === vertically ) {
    	verticalSwipe = true;
    } else {
    	verticalSwipe = false;
    }

    exadSliderControls.slick( {
        slidesToShow: 1,
        arrows: arrows,
        dots: dots,
        autoplay: autoPlay,
        fade: enableFade,
        centerMode: centermode,
  		centerPadding: centerModePadding,
        vertical: vertically,
        verticalSwiping: verticalSwipe,
        pauseOnHover: pauseOnHover,
        infinite: loop,
        rtl: direction,
        autoplaySpeed: autoplaySpeed,
        speed: transitionSpeed,
        customPaging: function ( slider, i ) {
            if(  'dot-image' === dotsType ){
                var image = $( slider.$slides[i] ).data( 'image' );
                return '<a><img src="' + image + '"></a>';
            }
            return;
        },
        responsive: [
            {
              breakpoint: 991,
              settings: {
                centerPadding: 0,
              }
            },
          ]
    } );

    exadSliderControls.slickAnimation();
}
// slider js starts ends


var exclusiveSourceCode = function ( $scope ) {
    var sourceCodeItem  = $scope.find( '.exad-source-code' ),
    copyBtn             = $scope.find( '.exad-copy-button' ),
    languageType        = sourceCodeItem.data( 'lng-type' ),
    sourceCode          = sourceCodeItem.find( 'code.language-' + languageType ),
    afterCopiedBtnText  = sourceCodeItem.data( 'after-copied-btn-text' );

    copyBtn.on( 'click', function () {
        var $temp = $( '<textarea>' );
        $(this).append( $temp );
        $temp.val( sourceCode.text() ).select();
        document.execCommand( 'copy' );
        $temp.remove();

        if( afterCopiedBtnText.length ) {
            $(this).text( afterCopiedBtnText );
        }
    } );

    if ( languageType !== undefined && sourceCode !== undefined ) {
        Prism.highlightElement( sourceCode.get(0) );
    }
}
// table script starts

var exclusiveTable = function( $scope, $ ) {
	var exadGetTableContainer = $scope.find( '.exad-table-container' ).eq(0),
	searchText                = ( exadGetTableContainer.data( 'search-text' ) !== undefined ) ? exadGetTableContainer.data( 'search-text' ) : '',
	searchPlaceholder         = ( exadGetTableContainer.data( 'search-placeholder' ) !== undefined ) ? exadGetTableContainer.data( 'search-placeholder' ) : '',
	notFoundText              = ( exadGetTableContainer.data( 'not-found-text' ) !== undefined ) ? exadGetTableContainer.data( 'not-found-text' ) : '',
	previousText              = ( exadGetTableContainer.data( 'previous-text' ) !== undefined ) ? exadGetTableContainer.data( 'previous-text' ) : '',
	nextText                  = ( exadGetTableContainer.data( 'next-text' ) !== undefined ) ? exadGetTableContainer.data( 'next-text' ) : '',
	verticalHeight            = ( exadGetTableContainer.data( 'vertical-height' ) !== undefined ) ? exadGetTableContainer.data( 'vertical-height' ) : '',
	sorting                   = ( exadGetTableContainer.data( 'sorting' ) !== undefined ) ? exadGetTableContainer.data( 'sorting' ) : false,
	infoText                  = ( exadGetTableContainer.data( 'enable-info' ) !== undefined ) ? 'Showing _START_ to _END_ of _TOTAL_ entries' : '',
	searching                 = ( exadGetTableContainer.data( 'searching' ) !== undefined ) ? exadGetTableContainer.data( 'searching' ) : false,
	pagination                = ( exadGetTableContainer.data( 'pagination' ) !== undefined ) ? exadGetTableContainer.data( 'pagination' ) : false,
	exadGetTable              = $scope.find( '.exad-main-table' ).eq(0),
	currentTableId            = '#' + exadGetTable.attr('id'),
	exadTableID               = $scope.find( currentTableId ).eq(0);
	if( sorting ){
	    exadTableID.DataTable({
		    paging: pagination,
		    aLengthMenu: [ [5, 10, 25, 40, -1], [5, 10, 25, 40, 'All'] ],
		    searching: searching,
			scrollY: verticalHeight,
		 	language: {
				search: searchText,
				zeroRecords: notFoundText,
				searchPlaceholder: searchPlaceholder,
				lengthMenu: 'show _MENU_ entries',
				info: infoText,
				infoEmpty: 'No records available',
				emptyTable: 'No data available',
				infoFiltered: '(filtered from _MAX_ total records)'
		  	},
			oLanguage: {
	      		oPaginate: {
	        		sPrevious: previousText,
	        		sNext: nextText
	      		}
	    	}
		    // scrollY: 400
		} );	
	}
	
	var table_responsive = exadGetTableContainer.data( 'exad_custom_responsive' );

	if ( table_responsive == true ) {
		var $th = exadGetTableContainer.find(".exad-main-table").find("th");
        var $tbody = exadGetTableContainer.find(".exad-main-table").find("tbody");

		$tbody.find("tr").each(function (i,  item)  {
			$(item).find("td .exad-td-content-wrapper").each(function (index,  item){
				if ($th.eq(index).length == 0){
					$(this).prepend('<div class="exad-th-mobile-screen">' + "</div>");
				} else {
					$(this).prepend('<div class="exad-th-mobile-screen">' + $th.eq(index).html() + "</div>");
				}
			});
		});
	}
}

// table script ends

// team carousel script starts

var exclusiveTeamCarousel     = function ( $scope, $ ) {
    var teamCarouselWrapper   = $scope.find( '.exad-team-carousel-wrapper' ).eq(0),
    carouselNav               = teamCarouselWrapper.data( 'carousel-nav' ),
    slidesToShow              = teamCarouselWrapper.data( 'slidestoshow'),
    carouselColumnTablet      = teamCarouselWrapper.data( 'slidestoshow-tablet' ),
    carouselColumnMobile      = teamCarouselWrapper.data( 'slidestoshow-mobile' ),
    slidesToScroll            = teamCarouselWrapper.data( 'slidestoscroll'),
    transitionSpeed           = teamCarouselWrapper.data( 'speed'),
    direction                 = teamCarouselWrapper.data( 'direction' ),
    autoplaySpeed             = undefined !== teamCarouselWrapper.data( 'autoplayspeed') ? teamCarouselWrapper.data( 'autoplayspeed' ) : 3000,
    loop                      = undefined !== teamCarouselWrapper.data( 'loop') ? teamCarouselWrapper.data( 'loop' ) : false,
    autoPlay                  = undefined !== teamCarouselWrapper.data( 'autoplay') ? teamCarouselWrapper.data( 'autoplay' ) : false,
    pauseOnHover              = undefined !== teamCarouselWrapper.data( 'pauseonhover') ? teamCarouselWrapper.data( 'pauseonhover' ) : false;

    var arrows, dots;
    if ( 'both' === carouselNav ) {
        arrows = true;
        dots   = true;
    } else if ( 'arrows' === carouselNav ) {
        arrows = true;
        dots   = false;
    } else if ( 'dots' === carouselNav ) {
        arrows = false;
        dots   = true;
    } else {
        arrows = false;
        dots   = false;
    }

    teamCarouselWrapper.slick({
        infinite: loop,
        slidesToShow : slidesToShow,
        slidesToScroll: slidesToScroll,
        autoplay: autoPlay,
        autoplaySpeed: autoplaySpeed,
        speed: transitionSpeed,
        pauseOnHover: pauseOnHover,
        dots: dots,
        arrows: arrows,
        rtl: direction,
        prevArrow: '<div class="exad-carousel-nav-prev"><i class="eicon-chevron-left"></i></div>',
        nextArrow: '<div class="exad-carousel-nav-next"><i class="eicon-chevron-right"></i></div>',
        rows: 0,
        responsive: [
            {
                breakpoint: 1024,
                settings: {
                    slidesToShow: carouselColumnTablet,
                }
            },
            {
                breakpoint: 576,
                settings: {
                    slidesToShow: carouselColumnMobile,
                }
            }
        ]
    } );
}

// team carousel script ends
// testimonial carousel starts

var exclusiveTestimonialCarousel   = function ( $scope, $ ) {
    var testimonialCarouselWrapper = $scope.find( '.exad-testimonial-carousel-wrapper' ).eq(0),
    carouselNav                    = testimonialCarouselWrapper.data( 'carousel-nav' ),
    slidesToShow                   = testimonialCarouselWrapper.data( 'slidestoshow' ),
    carouselColumnTablet           = testimonialCarouselWrapper.data( 'slidestoshow-tablet' ),
    carouselColumnMobile           = testimonialCarouselWrapper.data( 'slidestoshow-mobile' ),
    slidesToScroll                 = testimonialCarouselWrapper.data( 'slidestoscroll' ),
    transitionSpeed                = testimonialCarouselWrapper.data( 'speed' ),
    direction                      = testimonialCarouselWrapper.data( 'direction' ),
    autoplaySpeed                  = undefined !== testimonialCarouselWrapper.data( 'autoplayspeed' ) ? testimonialCarouselWrapper.data( 'autoplayspeed' ) : 3000,
    loop                           = undefined !== testimonialCarouselWrapper.data( 'loop' ) ? testimonialCarouselWrapper.data( 'loop' ) : false,
    autoPlay                       = undefined !== testimonialCarouselWrapper.data( 'autoplay' ) ? testimonialCarouselWrapper.data( 'autoplay' ) : false,
    pauseOnHover                   = undefined !== testimonialCarouselWrapper.data( 'pauseonhover' ) ? testimonialCarouselWrapper.data( 'pauseonhover' ) : false;
    
    var arrows, dots;
	if ( 'both' === carouselNav ) {
        arrows = true;
        dots   = true;
    } else if ( 'arrows' === carouselNav ) {
        arrows = true;
        dots   = false;
    } else if ( 'nav-dots' === carouselNav ) {
        arrows = false;
        dots   = true;
    } else if ( 'none' === carouselNav ) {
        arrows = false;
        dots   = false;
    }

    testimonialCarouselWrapper.slick({
        infinite: loop,
        slidesToShow: slidesToShow,
        slidesToScroll: slidesToScroll,
        autoplay: autoPlay,
        autoplaySpeed: autoplaySpeed,
        speed: transitionSpeed,
        pauseOnHover: pauseOnHover,
        rtl: direction,
        centerPadding: '0',
        dots: dots,
        arrows: arrows,
        prevArrow: '<div class="exad-carousel-nav-prev"><i class="eicon-chevron-left"></i></div>',
        nextArrow: '<div class="exad-carousel-nav-next"><i class="eicon-chevron-right"></i></div>',
        responsive: [
            {
                breakpoint: 1024,
                settings: {
                    slidesToShow: carouselColumnTablet,
                }
            },
            {
                breakpoint: 576,
                settings: {
                    slidesToShow: carouselColumnMobile,
                }
            }
        ]
    } );	
}

// testimonial carousel ends

// woo add to cart script starts

var exadWooAddToCart     = function( $scope, $ ) {
    var exadAddCart = $scope.find( '.exad-woo-mini-cart' ).eq(0);

    var cartVisibility = exadAddCart.data('visibility');

    var cartWrapper = exadAddCart.find( '.exad-woo-mini-cart-wrapper' );
    var cartIcon = exadAddCart.find( '.exad-woo-mini-cart-wrapper .exad-woo-cart-icon' );
    var cartBag = exadAddCart.find( '.exad-woo-mini-cart-wrapper .exad-woo-cart-bag' );
    var cartOverlay = exadAddCart.find( '.exad-woo-mini-cart-wrapper .exad-woo-cart-bag-fly-out-overlay' );

    if( 'hover' === cartVisibility ){
        $( cartWrapper ).hover( function()  {
            cartWrapper.addClass('hover-active');
        }, function() {
            cartWrapper.removeClass('hover-active');
        });
    }else if( 'click' === cartVisibility ){
        $(cartWrapper).on("click", function(e){
            cartWrapper.toggleClass('click-active');
        });
    } else if( 'fly-out' === cartVisibility ){
        var closeIcon = cartBag.find( '.exad-woo-cart-bag-fly-out-close-icon' );

        closeIcon.on("click", function(e){
            cartBag.removeClass('fly-out-active');
            cartOverlay.removeClass('fly-out-active');
        });
        $(cartIcon).on("click", function(e){
            cartBag.addClass('fly-out-active');
            cartOverlay.addClass('fly-out-active');
        });
        $(cartOverlay).on("click", function(e){
            cartBag.removeClass('fly-out-active');
            cartOverlay.removeClass('fly-out-active');
        });
    }
    
    
}

// woo add to cart script ends

// Woo cart Js Start 

var exadWooCart = function( $scope, $ ) {
    var exadCartWrapper = $scope.find( '.exad-woo-cart' );

    var inputClass = $scope.find( '.exad-woo-cart .woocommerce-cart-form__contents tbody tr td.product-quantity .quantity input.qty' );

    // $( '<button class="exad-quantity-minus-btn"></button>' ).insertBefore( inputClass );
    // $( '<button class="exad-quantity-plus-btn"></button>' ).insertAfter( inputClass );

    var minusButton = $scope.find( '.exad-quantity-minus-btn' );
    var plusButton = $scope.find( '.exad-quantity-plus-btn' );

    minusButton.click(function (e) { 
        e.preventDefault();
        this.parentNode.querySelector('input[type=number]').stepDown();
        $("[name='update_cart']").removeAttr("disabled");
    });
    plusButton.click(function (e) { 
        e.preventDefault();
        this.parentNode.querySelector('input[type=number]').stepUp();
        $("[name='update_cart']").removeAttr("disabled");
    });

    //carousel
    var crossSell_product_JsVars = {
        prev_html: '<a href="#" class="product-prev"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-left"><polyline points="15 18 9 12 15 6"></polyline></svg></a>',
        next_html: '<a href="#" class="product-next"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg></a>',
        dots_html: '<div class="exad-dots-container"><div class="exad-swiper-pagination swiper-pagination"></div></div>',
    };

    var cross_selector = $scope.hasClass("exad-cart-cross-sell-carousel-layout");
    var wrapper = exadCartWrapper.find(".cross-sells");
    var thumb_item = wrapper.find("ul.products");

    if ( cross_selector ) {
        var settings = $('.elementor-widget-exad-woo-cart').data('carousel');
        thumb_item.wrap("<div class='cross-sell-pro-swiper swiper-container'></div>");
        thumb_item.addClass("swiper-wrapper");
        thumb_item.find("li").addClass("swiper-slide");
        $(crossSell_product_JsVars.dots_html).insertAfter('.cross-sell-pro-swiper');

        if ( settings.navigation ) {
            $(crossSell_product_JsVars.next_html).insertAfter('.cross-sell-pro-swiper');
            $(crossSell_product_JsVars.prev_html).insertAfter('.cross-sell-pro-swiper');
        }

        var CrosssellSwiper = new Swiper(".cross-sell-pro-swiper", settings);

    }
}

// Woo cart Js End

// woo category script starts

var exclusiveProductCat     = function( $scope, $ ) {
    var exadcarouselWrapper = $scope.find( '.exad-woo-product-cat-slider' ).eq(0),
    carouselNav             = exadcarouselWrapper.data( 'carousel-nav' ),
    carouselColumn          = exadcarouselWrapper.data( 'carousel-column' ),
    slidesToScroll          = exadcarouselWrapper.data( 'slidestoscroll' ),
    transitionSpeed         = exadcarouselWrapper.data( 'carousel-speed' ),
    direction               = exadcarouselWrapper.data( 'direction' ),
    autoplaySpeed           = undefined !== exadcarouselWrapper.data( 'autoplayspeed' ) ? exadcarouselWrapper.data( 'autoplayspeed' ) : 3000,
    loop                    = undefined !== exadcarouselWrapper.data( 'loop' )  ? exadcarouselWrapper.data( 'loop' ) : false,
    autoPlay                = undefined !== exadcarouselWrapper.data( 'autoplay' ) ? exadcarouselWrapper.data( 'autoplay' ) : false,
    pauseOnHover            = undefined !== exadcarouselWrapper.data( 'pauseonhover' ) ? exadcarouselWrapper.data( 'pauseonhover' ) : false;

    var arrows, dots;
    if ( 'both' === carouselNav ) {
        arrows = true;
        dots   = true;
    } else if ( 'arrows' === carouselNav ) {
        arrows = true;
        dots   = false;
    } else if ( 'dots' === carouselNav ) {
        arrows = false;
        dots   = true;
    } else {
        arrows = false;
        dots   = false;
    }
    
    exadcarouselWrapper.slick( {
        slidesToShow: carouselColumn,
        slidesToScroll: slidesToScroll,
        arrows: arrows,
        dots: dots,
        autoplay: autoPlay,
        autoplaySpeed: autoplaySpeed,
        pauseOnHover: pauseOnHover,
        speed: transitionSpeed,
        infinite: loop,
        rtl: direction,
        prevArrow: '<div class="exad-carousel-nav-prev"><i class="eicon-chevron-left"></i></div>',
        nextArrow: '<div class="exad-carousel-nav-next"><i class="eicon-chevron-right"></i></div>',
        rows: 0,
        responsive: [
            {
                breakpoint: 1024,
                settings: {
                slidesToShow: 2
                }
            },
            {
                breakpoint: 576,
                settings: {
                slidesToShow: 1
                }
            }
        ]
    } );
}

// woo category script ends
// Woo Product Carousel
var exclusiveProductCarousel = function( $scope, $ ) {

    var $slider = $scope.find( '.exad-product-carousel-wrapper' ).eq(0);
    var slidesPerView = $slider.data( 'slidesperview' );
    var prevArrow = $slider.find('.exad-carousel-nav-prev');
    var nextArrow = $slider.find('.exad-carousel-nav-next');
    var pagination = $slider.find('.exad-swiper-pagination');
    var type = $slider.data('type');
    var spaceBetween = $slider.data('spacebetween');
    var loop = $slider.data('loop');
    var slidesPerColumn = $slider.data('slidespercolumn');
    var autoplay = $slider.data('autoplay');
    var delay = $slider.data('delay');
    var speed = $slider.data('speed');
    var autoHeight = $slider.data('autoheight');
    var centeredSlides = $slider.data('centeredslides');
    var grabCursor = $slider.data('grabcursor');
    var observer = $slider.data('observer');
        
    if ( ! $slider.length ) {
      return;
    }
  
    var $sliderContainer = $slider.find('.exad-product-carousel-wrapper-container');

    var $breakpoint_settings 		 = $slider.data('breakpoint_settings');
  
    var swiper = new Swiper( $sliderContainer, {
      slidesPerView: slidesPerView,
      spaceBetween: spaceBetween,
      slidesPerColumn: slidesPerColumn,
      autoHeight: autoHeight,
      speed: speed,
      centeredSlides: centeredSlides,
      grabCursor: grabCursor,
      grabCursor: observer,
      autoplay: {
        delay: delay
      },
      loop: loop,
      breakpoints: $breakpoint_settings,
      navigation: {
        nextEl: nextArrow,
        prevEl: prevArrow,
      },
      pagination: {
        el: pagination,
        clickable :true,
        type: type,
      },
    });
    if( !autoplay ){
      swiper.autoplay.stop();
    }
  
  };
// woo products js starts

// var ExadWooProducts = function( $scope, $ ) {
//     var $exad_woo_products_init = $scope.find( '.exad-product-image-slider' );

//     $exad_woo_products_init.slick({
//         slidesToShow: 1,
//         autoplay: false,
//         dots: false,
//         arrows: false
//     } );
// }

// woo products js starts

var exclusiveWooProduct = function( $scope, $ ) {
    var exadPostgridWrapped = $scope.find( '.main-product-wrapper' );

    var exadPostArticle = exadPostgridWrapped.find('.exad-woo-product-item');
    var exadPostWrapper = exadPostgridWrapped.find('.exad-woo-products');
    // Match Height
    // exadPostArticle.matchHeight({
    //     byRow: 0
    // });

    var btn = exadPostgridWrapped.find('.exad-woo-product-paginate-btn');
    var btnText = btn.text();

    var page = 2;
    
    $(btn).on("click", function(e){
        e.preventDefault();
        $.ajax({
			url: exad_ajax_object.ajax_url,
			type: 'POST',
			data: {
				action: 'ajax_product_pagination',
                paged : page,
                product_categories: $(this).data('product-categories'),
                order_by: $(this).data('order-by'),
            	order: $(this).data('order'),
                per_page: $(this).data('per-page'),
                in_ids: $(this).data('in-ids'),
                not_in_ids: $(this).data('not-in-ids'),
                image_size: $(this).data('image-size'),
                only_post_has_image: $(this).data('only-post-has-image'),
                show_category: $(this).data('show_category'),
                show_star_rating: $(this).data('show-star-rating'),
                sell_in_percentage_tag_enable: $(this).data('sell-in-percentage-tag-enable'),
                sale_tag_enable: $(this).data('sale-tag-enable'),
                sold_out_tag_enable: $(this).data('sold-out-tag-enable'),
                data_featured_tag_enable: $(this).data('featured-tag-enable'),
                featured_tag_text: $(this).data('featured-tag-text'),
                excerpt: $(this).data('excerpt'),
                excerpt_length: $(this).data('excerpt-length'),
                offset_value: $(this).data('offset-value'),
            },
            beforeSend : function ( xhr ) {
				btn.text('Loading...');
			},
            success: function( html ) {
                if( html.length > 0 ){
                    btn.text(btnText);
                    exadPostWrapper.append( html );
                    page++;
                    setTimeout(function(){
                        // var newExadPostArticle = exadPostgridWrapped.find('.exad-single-woo-product-wrapper');
                        // newExadPostArticle.matchHeight({
                        //     byRow: 0
                        // });
                    }, 10);
                } else {
					btn.remove();
				}
            },
		});
    });
}

// woo products js ends

$(window).on('elementor/frontend/init', function () {
    if( elementorFrontend.isEditMode() ) {
        editMode = true;
    }
    
    elementorFrontend.hooks.addAction( 'frontend/element_ready/exad-chart.default', exclusiveChart );
    elementorFrontend.hooks.addAction( 'frontend/element_ready/exad-cookie-consent.default', widgetCookieConsent );
    elementorFrontend.hooks.addAction( 'frontend/element_ready/exad-counter.default', exclusiveCounterUp );
    elementorFrontend.hooks.addAction( 'frontend/element_ready/exad-image-hotspot.default', exclusiveImageHotspot );
    elementorFrontend.hooks.addAction( 'frontend/element_ready/exad-instagram-feed.default', exclusiveInstagramCarousel );
    elementorFrontend.hooks.addAction( 'frontend/element_ready/exad-news-ticker-pro.default', exclusiveNewsTickerPRO );
    elementorFrontend.hooks.addAction( 'frontend/element_ready/exad-post-carousel.default', exclusivePostCarousel );
    elementorFrontend.hooks.addAction( 'frontend/element_ready/exad-exclusive-slider.default', exclusiveSlider );
    elementorFrontend.hooks.addAction( 'frontend/element_ready/exad-post-slider.default', exclusivePostSlider );
    elementorFrontend.hooks.addAction( 'frontend/element_ready/exad-table.default', exclusiveTable );
    elementorFrontend.hooks.addAction( 'frontend/element_ready/exad-team-carousel.default', exclusiveTeamCarousel );
    elementorFrontend.hooks.addAction( 'frontend/element_ready/exad-testimonial-carousel.default', exclusiveTestimonialCarousel );
    elementorFrontend.hooks.addAction( 'frontend/element_ready/exad-source-code.default', exclusiveSourceCode );
    elementorFrontend.hooks.addAction( 'frontend/element_ready/exad-woo-category.default', exclusiveProductCat );
    elementorFrontend.hooks.addAction( 'frontend/element_ready/exad-mailchimp.default', exadMailChimp );
    elementorFrontend.hooks.addAction( 'frontend/element_ready/exad-promo-box.default', exadMailChimp );
    elementorFrontend.hooks.addAction( 'frontend/element_ready/exad-promo-box.default', exadPromoBoxCountdownTimer );
    elementorFrontend.hooks.addAction( 'frontend/element_ready/exad-promo-box.default', exadPromoBoxAlert );
    elementorFrontend.hooks.addAction( 'frontend/element_ready/exad-content-switcher.default', exclusiveContentSwitcher );
    elementorFrontend.hooks.addAction( 'frontend/element_ready/exad-offcanvas.default', exclusiveOffCanvas );
    elementorFrontend.hooks.addAction( 'frontend/element_ready/exad-image-carousel.default', exclusiveImageCarousel );
    elementorFrontend.hooks.addAction( 'frontend/element_ready/exad-demo-previewer.default', exclusiveDemoPreviewer );
    elementorFrontend.hooks.addAction( 'frontend/element_ready/exad-gravity-form.default', ExadGravityForm );
    elementorFrontend.hooks.addAction( 'frontend/element_ready/exad-blob-maker.default', exclusiveBlob );
    elementorFrontend.hooks.addAction( 'frontend/element_ready/exad-navigation-menu.default', exclusiveNavMenu );
    elementorFrontend.hooks.addAction( 'frontend/element_ready/exad-search-form.default', exclusiveSearchForm );
    elementorFrontend.hooks.addAction( 'frontend/element_ready/exad-mega-menu.default', MegaMenu );
    elementorFrontend.hooks.addAction( 'frontend/element_ready/exad-woo-add-to-cart.default', exadWooAddToCart );
    elementorFrontend.hooks.addAction( 'frontend/element_ready/exad-lottie-animation.default', exadLottieAnimation );
    elementorFrontend.hooks.addAction( 'frontend/element_ready/exad-woo-cart.default', exadWooCart );
    elementorFrontend.hooks.addAction( 'frontend/element_ready/section', SectionParticles);
    elementorFrontend.hooks.addAction( 'frontend/element_ready/section', ExadParallaxEffect);
    elementorFrontend.hooks.addAction( 'frontend/element_ready/exad-woo-product-carousel.default', exclusiveProductCarousel);
    elementorFrontend.hooks.addAction( 'frontend/element_ready/exad-woo-products.default', exclusiveWooProduct);
    elementorFrontend.hooks.addAction( 'frontend/element_ready/exad-product-image.default', exclusiveProductThumbCarousel);
    elementorFrontend.hooks.addAction( 'frontend/element_ready/product-add-to-cart.default', exclusiveProductCart);
    elementorFrontend.hooks.addAction( 'frontend/element_ready/exad-product-related.default', exclusiveProductRelatedCarousel);
    elementorFrontend.hooks.addAction( 'frontend/element_ready/exad-product-upsell.default', exclusiveProductUpsellCarousel);
    elementorFrontend.hooks.addAction( 'frontend/element_ready/exad-product-cross-sell.default', exclusiveProductCrossSellCarousel);
    
} );

}(jQuery));