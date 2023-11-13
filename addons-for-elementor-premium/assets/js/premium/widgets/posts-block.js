( function ( $ ) {

    var WidgetLAEPostsBlockHandler = function ( $scope, $ ) {

        var $blockElem = $scope.find( '.lae-block' );

        if ($blockElem.find( '.lae-module' ).length === 0) {
            return; // no items to display or load and hence don't continue
        }

        var $blockElemInner = $blockElem.find( '.lae-block-inner' );

        var currentBlockObj = laeBlocks.getBlockObjById( $blockElem.data( 'block-uid' ) );

        /* ----------- Reorganize Filters when device width changes -------------- */

        /* https://stackoverflow.com/questions/24460808/efficient-way-of-using-window-resize-or-other-method-to-fire-jquery-functions */
        var laeResizeTimeout;

        $( window ).resize( function () {

            if (!!laeResizeTimeout) {
                clearTimeout( laeResizeTimeout );
            }

            laeResizeTimeout = setTimeout( function () {

                currentBlockObj.organizeFilters();

            }, 200 );
        } );

        /* -------------- Taxonomy Filter --------------- */

        $scope.find( '.lae-taxonomy-filter .lae-filter-item a, .lae-block-filter .lae-block-filter-item a' ).on( 'click', function ( e ) {

            e.preventDefault();

            currentBlockObj.handleFilterAction( $( this ) );

            return false;
        } );

        var pagination = currentBlockObj.settings['pagination'];

        /* ------------------- Pagination ---------------------- */

        $scope.find( '.lae-pagination a.lae-page-nav' ).on( 'click', function ( e ) {

            e.preventDefault();

            currentBlockObj.handlePageNavigation( $( this ) );

        } );

        /*---------------- Load More Button --------------------- */

        $scope.find( '.lae-pagination a.lae-load-more' ).on( 'click', function ( e ) {

            e.preventDefault();

            currentBlockObj.handleLoadMore( $( this ) );

        } );

        /*---------------- Load On Scroll --------------------- */


        if (pagination == 'infinite_scroll') {

            var helper = new LAE_Grid_Helper( $scope );

            helper.setupInfiniteScroll();

        }

        /* ---------------------- Init Lightbox ---------------------- */

        currentBlockObj.initLightbox( $scope );

    };

    // Make sure you run this code under Elementor..
    $( window ).on( 'elementor/frontend/init', function () {

        elementorFrontend.hooks.addAction( 'frontend/element_ready/lae-posts-block.default', WidgetLAEPostsBlockHandler );

    } );

} )( jQuery );