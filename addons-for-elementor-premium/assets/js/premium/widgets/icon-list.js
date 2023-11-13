( function ( $ ) {


    var WidgetLAEIconListHandler = function ( $scope, $ ) {

        $scope.find( '.lae-icon-list-item' ).powerTip( {

            placement: 'n' // north-east tooltip position

        } );

    };

    // Make sure you run this code under Elementor..
    $( window ).on( 'elementor/frontend/init', function () {

        elementorFrontend.hooks.addAction( 'frontend/element_ready/lae-icon-list.default', WidgetLAEIconListHandler );

    } );

} )( jQuery );