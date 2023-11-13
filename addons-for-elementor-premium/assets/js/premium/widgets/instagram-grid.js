( function ( $ ) {


    /* -------------------------------------- START Instagram Block Implementation ----------------- */

    function LAE_Instagram_Grid() {

        LAE_Block.apply(this, arguments);

    }

    // inherit LAE_Block
    LAE_Instagram_Grid.prototype = Object.create(LAE_Grid.prototype);

    LAE_Instagram_Grid.prototype.constructor = LAE_Instagram_Grid;

    LAE_Instagram_Grid.prototype.initLightbox = function ($blockElem) {

        if ($().fancybox === undefined) {
            return;
        }

        /* ----------------- Lightbox Support ------------------ */

        var lightboxSelector = '.lae-block' + '.' + this.settings['block_class'] + ' ' + 'a.lae-lightbox-item:not(.elementor-clickable)';
        lightboxSelector += ',' + '.lae-block' + '.' + this.settings['block_class'] + ' ' + 'a.lae-video-lightbox:not(.elementor-clickable)';

        $blockElem.fancybox({
            selector: lightboxSelector, // the selector for portfolio item
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
            caption: function (instance, item) {

                var caption = '';

                var authorName = $(this).data('author-username');

                var authorLink = $(this).data('author-link') || '';

                var readMore = $(this).data('read-more-text');

                var postLink = $(this).data('post-link') || '';

                var excerpt = $(this).data('post-text') || '';

                caption += '<div class="lae-fancybox-caption">';

                caption += '<a class="lae-fancybox-post-author" href="' + authorLink + '" title="' + authorName + '">' + authorName + '</a>';

                if (excerpt !== '') {
                    caption += '<div class="lae-fancybox-description">' + excerpt + '</div>';
                }

                if (readMore !== '') {
                    caption += '<a class="lae-fancybox-read-more" href="' + postLink + '" title="' + readMore + '">' + readMore + '</a>';
                }

                caption += '<div/>';

                return caption;
            }
        });

    };


    var laeInstagramGrids = Object.create(laeBlocks);

    laeInstagramGrids.getBlockObjById = function (blockId) {

        var blockIndex = this._getBlockIndex(blockId);

        if (blockIndex !== -1)
            return laeBlockObjColl[blockIndex];

        var blockObj = new LAE_Instagram_Grid(blockId);

        laeBlockObjColl.push(blockObj); // add to the array for instant retrieval later

        return blockObj;

    };

    /* -------------------------------------- END Instagram Grid Implementation ----------------- */


    var WidgetLAEInstagramGridHandler = function ( $scope, $ ) {

        var $blockElem = $scope.find( '.lae-block' );

        var rtl = $blockElem.attr( 'dir' ) === 'rtl';

        if ($blockElem.find( '.lae-module' ).length === 0) {
            return; // no items to display or load and hence don't continue
        }

        var currentBlockObj = laeInstagramGrids.getBlockObjById( $blockElem.data( 'block-uid' ) );

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

        $blockElemInner.imagesLoaded( function () {
            $blockElemInner.isotope( 'layout' );
        } );

        // Relayout on inline full screen video and back
        $( document ).on( 'webkitfullscreenchange mozfullscreenchange fullscreenchange', function ( e ) {
            $blockElemInner.isotope( 'layout' );
        } );


        /* ---------------------- Init Lightbox ---------------------- */

        currentBlockObj.initLightbox( $blockElem );

    };

    // Make sure you run this code under Elementor..
    $( window ).on( 'elementor/frontend/init', function () {

        elementorFrontend.hooks.addAction( 'frontend/element_ready/lae-instagram-grid.default', WidgetLAEInstagramGridHandler );

    } );

} )( jQuery );