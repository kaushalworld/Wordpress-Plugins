( function ( $ ) {


    /* ----------------- Accordion ------------------ */

    var LAE_Accordion = function ( $scope ) {

        this.accordion = $scope.find( '.lae-accordion' ).eq( 0 );
        // toggle elems
        this.panels = this.accordion.find( '.lae-panel' );

        if (this.accordion.data( 'toggle' ) == true)
            this.toggle = true;

        if (this.accordion.data( 'expanded' ) == true)
            this.expanded = true;

        // init events
        this._init();
    };

    LAE_Accordion.prototype = {

        accordion: null,
        panels: null,
        toggle: false,
        expanded: false,
        current: null,

        _init: function () {

            var self = this;

            if (this.expanded && this.toggle) {

                // Display all panels
                this.panels.each( function () {

                    var $panel = jQuery( this );

                    self._show( $panel );

                } );
            }

            this.panels.find( '.lae-panel-title' ).click( function ( event ) {

                event.preventDefault();

                var $panel = jQuery( this ).parent();

                // Do not disturb existing location URL if you are going to close an accordion panel that is currently open
                if (!$panel.hasClass( 'lae-active' )) {

                    var target = $panel.attr( "id" );

                    history.pushState ? history.pushState( null, null, "#" + target ) : window.location.hash = "#" + target;

                } else {
                    var target = $panel.attr( "id" );

                    if (window.location.hash == '#' + target)
                        history.pushState ? history.pushState( null, null, '#' ) : window.location.hash = "#";
                }

                self._show( $panel );
            } );
        },

        _show: function ( $panel ) {

            if (this.toggle) {
                if ($panel.hasClass( 'lae-active' )) {
                    this._close( $panel );
                } else {
                    this._open( $panel );
                }
            } else {
                // if the $panel is already open, close it else open it after closing existing one
                if ($panel.hasClass( 'lae-active' )) {
                    this._close( $panel );
                    this.current = null;
                } else {
                    this._close( this.current );
                    this._open( $panel );
                    this.current = $panel;
                }
            }

        },

        _open: function ( $panel ) {

            if ($panel !== null) {
                $panel.children( '.lae-panel-content' ).slideDown( 300 );
                $panel.addClass( 'lae-active' );
            }

        },

        _close: function ( $panel ) {

            if ($panel !== null) {
                $panel.children( '.lae-panel-content' ).slideUp( 300 );
                $panel.removeClass( 'lae-active' );
            }

        },
    };

    var WidgetLAEAccordionHandler = function ( $scope, $ ) {

        new LAE_Accordion( $scope );

    };

    var LAE_Accordion_Mgr = {

        init: function () {

            var self = this;

            /* Triggered when someone pastes a URL with #accordion-link into browser address bar and there is a browser refresh. */
            self.initHash();

            /* Triggered when an internal link is clicked which points to a accordion - eg. a primary menu item which links to an accordion */
            self.initAnchor();

            /*
            Triggered when someone pastes a URL with #accordion-link into browser address bar and there is NO browser refresh.
            Only the hash part of the URL changed and hence browser window was not refreshed.
            */
            jQuery( window ).on( "hashchange.lae.accordion", function () {
                self.initHash();
            } );

        },

        initAnchor: function () {

            var self = this;

            jQuery( 'a[href*="#"]' ).click( function ( event ) {

                var hash = jQuery( this ).attr( 'href' ).split( '#' ).pop();

                if ('' !== hash) {

                    var $element = jQuery( '#' + hash );

                    if ($element.length > 0) {

                        if ($element.hasClass( 'lae-panel' )) {

                            // Do not allow the anchor to navigate to the tab - we will smooth scroll to the same
                            event.preventDefault();

                            self.displayPanel( $element );
                        }
                    }
                }

            } );

        },

        initHash: function () {

            var self = this;

            var hash, $element;

            hash = window.location.hash.replace( '#', '' ).split( '/' ).shift();

            if ('' !== hash) {

                $element = jQuery( '#' + hash );

                if ($element.length > 0) {

                    if ($element.hasClass( 'lae-panel' )) {

                        setTimeout( function () {

                            self.displayPanel( $element );

                        }, 100 );
                    }
                }
            }

        },

        displayPanel: function ( $panel ) {

            var self = this;

            var offset, speed;

            offset = .2;

            speed = 300;

            // Only trigger click if the panel is not already open. Do not close the same if already open
            if (!$panel.hasClass( 'lae-active' )) {

                var $panelLabel = $panel.find( '.lae-panel-title' ).eq( 0 );

                $panelLabel.trigger( 'click' );

            }

            // Delay the scrolling to enable click action to be complete ensuring all elements are in place
            setTimeout( function () {

                jQuery( "html, body" ).animate( {
                    scrollTop: $panel.offset().top - jQuery( window ).height() * offset
                }, speed );

            }, 300 );

        }

    };

    // Make sure you run this code under Elementor..
    $( window ).on( 'elementor/frontend/init', function () {


        elementorFrontend.hooks.addAction( 'frontend/element_ready/lae-accordion.default', WidgetLAEAccordionHandler );


    } );

    LAE_Accordion_Mgr.init();

} )( jQuery );