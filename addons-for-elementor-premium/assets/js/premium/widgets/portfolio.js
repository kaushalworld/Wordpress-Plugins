( function ( $ ) {


    var laeGrids = Object.create(laeBlocks);

    laeGrids.getBlockObjById = function (blockId) {

        var blockIndex = this._getBlockIndex(blockId);

        if (blockIndex !== -1)
            return laeBlockObjColl[blockIndex];

        var blockObj = new LAE_Grid(blockId);

        laeBlockObjColl.push(blockObj); // add to the array for instant retrieval later

        return blockObj;

    };

    var WidgetLAEPortfolioHandler = function ( $scope, $ ) {

        var $blockElem = $scope.find( '.lae-block' );

        var rtl = $blockElem.attr( 'dir' ) === 'rtl';

        if ($blockElem.find( '.lae-module' ).length !== 0) {

            /* Enable isotope only for built-in grid and not for custom elementor grid */

            var currentBlockObj = laeGrids.getBlockObjById( $blockElem.data( 'block-uid' ) );

            /* ----------- Init Isotope on Grid  -------------- */

            var layoutMode = currentBlockObj.settings['layout_mode'];

            // layout Isotope after all images have loaded
            var $blockElemInner = $blockElem.find( '.lae-block-inner' );

            $blockElemInner.isotope( {
                itemSelector: '.lae-block-column',
                layoutMode: layoutMode,
                originLeft: !rtl,
                transitionDuration: '0.8s',
            } );

            // layout Isotope after each image loads
            $blockElemInner.imagesLoaded().progress( function () {
                $blockElemInner.isotope( 'layout' );
            } );

        } else if ($blockElem.find( '[data-elementor-type="livemesh_grid"]' ) !== 0) {
            /* Treat like the posts block grid for custom grid skin using elementor grid */
            var currentBlockObj = laeBlocks.getBlockObjById( $blockElem.data( 'block-uid' ) );
        } else {
            return; // no items to display or load and hence don't continue
        }

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

        currentBlockObj.initLightbox( $blockElem );

    };

    // Make sure you run this code under Elementor..
    $( window ).on( 'elementor/frontend/init', function () {

        elementorFrontend.hooks.addAction( 'frontend/element_ready/lae-portfolio.default', WidgetLAEPortfolioHandler );

    } );

} )( jQuery );