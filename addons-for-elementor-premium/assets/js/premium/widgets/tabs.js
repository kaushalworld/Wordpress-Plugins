( function ( $ ) {


    var LAE_Tabs_Mgr = {

        init: function () {

            var self = this;

            if ($('.lae-tabs').length === 0) return; // no tabs here

            /* Triggered when someone pastes a URL with #tab-link into browser address bar and there is a browser refresh. */
            self.initHash();

            /* Triggered when an internal link is clicked which points to a tab - eg. a primary menu item which links to a tab */
            self.initAnchor();

            /*
            Triggered when someone pastes a URL with #tab-link into browser address bar and there is NO browser refresh.
            Only the hash part of the URL changed and hence browser window was not refreshed.
            */
            $(window).on("hashchange.lae.tabs", function () {
                self.initHash();
            });

        },

        initAnchor: function () {

            var self = this;

            $('a[href*="#"]').not('.lae-tab-label').click(function (event) {

                var hash = $(this).attr('href').split('#').pop();

                if ('' !== hash) {

                    var $element = $('#' + hash);

                    if ($element.length > 0) {

                        if ($element.hasClass('lae-tab-pane')) {

                            // Do not allow the anchor to navigate to the tab - we will smooth scroll to the same
                            event.preventDefault();

                            self.displayTab($element);
                        }
                    }
                }

            });

        },

        initHash: function () {

            var self = this;

            var hash = window.location.hash.replace('#', '').split('/').shift();

            if ('' !== hash) {

                var $element = $('#' + hash);

                if ($element.length > 0) {

                    if ($element.hasClass('lae-tab-pane')) {

                        setTimeout(function () {

                            self.displayTab($element);

                        }, 100);
                    }
                }
            }

        },

        displayTab: function ($tabPane) {

            var index, offset, speed, $tabs, $mobileMenu;

            offset = .2;

            speed = 300;

            $tabs = $tabPane.closest('.lae-tabs');

            $mobileMenu = $tabs.find('.lae-tab-mobile-menu');

            // opens the mobile menu
            $mobileMenu.trigger('click');

            index = $tabs.find('.lae-tab-pane').index($tabPane);

            var $tabNav = $tabs.find('.lae-tab-nav > .lae-tab').eq(index);

            // closes the mobile menu after selecting the required tab
            $tabNav.trigger('click');

            $("html, body").animate({
                scrollTop: Math.round($tabs.offset().top - $(window).height() * offset)
            }, speed);
        }

    };

    /* ------------------------------- Tabs ------------------------------------------- */

    /* Credit for tab styles - http://tympanus.net/codrops/2014/09/02/tab-styles-inspiration/ */

    var LAE_Tabs = function ( $scope ) {

        this.tabs = $scope.find( '.lae-tabs' ).eq( 0 );

        this._init();
    };

    LAE_Tabs.prototype = {

        tabs: null,
        tabNavs: null,
        items: null,

        _init: function () {

            // tabs elems
            this.tabNavs = this.tabs.find( '.lae-tab' );

            // content items
            this.items = this.tabs.find( '.lae-tab-pane' );

            // show first tab item
            this._show( 0 );

            // init events
            this._initEvents();

            // make the tab responsive
            this._makeResponsive();

        },

        _show: function ( index ) {

            // Clear out existing tab
            this.tabNavs.removeClass( 'lae-active' );
            this.items.removeClass( 'lae-active' );

            this.tabNavs.eq( index ).addClass( 'lae-active' );
            this.items.eq( index ).addClass( 'lae-active' );

            this._triggerResize();

        },

        _initEvents: function ( $panel ) {

            var self = this;

            this.tabNavs.click( function ( event ) {

                event.preventDefault();

                var $anchor = jQuery( this ).children( 'a' ).eq( 0 );

                var target = $anchor.attr( 'href' ).split( '#' ).pop();

                self._show( self.tabNavs.index( jQuery( this ) ) );

                history.pushState ? history.pushState( null, null, "#" + target ) : window.location.hash = "#" + target;

            } );
        },

        _makeResponsive: function () {

            var self = this;

            /* Trigger mobile layout based on an user chosen browser window resolution */
            var mediaQuery = window.matchMedia( '(max-width: ' + self.tabs.data( 'mobile-width' ) + 'px)' );
            if (mediaQuery.matches) {
                self.tabs.addClass( 'lae-mobile-layout' );
            }
            mediaQuery.addListener( function ( mediaQuery ) {
                if (mediaQuery.matches)
                    self.tabs.addClass( 'lae-mobile-layout' );
                else
                    self.tabs.removeClass( 'lae-mobile-layout' );
            } );

            /* Close/open the mobile menu when a tab is clicked and when menu button is clicked */
            this.tabNavs.click( function ( event ) {
                event.preventDefault();
                self.tabs.toggleClass( 'lae-mobile-open' );
            } );

            this.tabs.find( '.lae-tab-mobile-menu' ).click( function ( event ) {
                event.preventDefault();
                self.tabs.toggleClass( 'lae-mobile-open' );
            } );
        },

        _triggerResize: function () {

            if (typeof ( Event ) === 'function') {
                // modern browsers
                window.dispatchEvent( new Event( 'resize' ) );
            } else {
                // for IE and other old browsers
                // causes deprecation warning on modern browsers
                var evt = window.document.createEvent( 'UIEvents' );
                evt.initUIEvent( 'resize', true, false, window, 0 );
                window.dispatchEvent( evt );
            }
        }
    };


    var WidgetLAETabsHandler = function ( $scope, $ ) {

        new LAE_Tabs( $scope );

    };

    // Make sure you run this code under Elementor..
    $( window ).on( 'elementor/frontend/init', function () {


        elementorFrontend.hooks.addAction( 'frontend/element_ready/lae-tabs.default', WidgetLAETabsHandler );


    } );

    LAE_Tabs_Mgr.init();

} )( jQuery );