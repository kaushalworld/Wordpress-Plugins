( function ( $ ) {

    /* -------------------------------------- START Twitter Block Implementation ----------------- */

    function LAE_Twitter_Grid() {

        LAE_Block.apply(this, arguments);

    }

    // inherit LAE_Block
    LAE_Twitter_Grid.prototype = Object.create(LAE_Grid.prototype);

    LAE_Twitter_Grid.prototype.constructor = LAE_Twitter_Grid;

    LAE_Twitter_Grid.prototype._doAjaxBlockProcessResponse = function (cacheHit, response, userAction) {

        var self = this;

        //read the server response
        var responseObj = $.parseJSON(response); //get the data object

        if (this.blockId !== responseObj.blockId)
            return; // not mine

        self.maxId = responseObj.maxId;

        var $blockElem = $('#' + this.blockId); // we know the response is for this grid

        if ('load_more' === userAction) {

            var $blockElementInner = $blockElem.find('.lae-block-inner');

            var $response = $('<div></div>').html(responseObj.data);

            $response.imagesLoaded(function () {

                if (cacheHit == false)
                    $blockElem.removeClass('lae-fetching');

                var $new_items = $response.children('.lae-block-column');

                if ($new_items.length)
                    $blockElementInner.isotope('insert', $new_items);
            });

        }

        $blockElem.attr('data-current', self.currentPage);

        $blockElem.attr('data-max-id', self.maxId);

        if (self.maxId == null) {
            // No more tweets to be fetched
            $blockElem.find('.lae-pagination a.lae-load-more').addClass('lae-disabled');
        } else {
            $blockElem.find('.lae-pagination a.lae-load-more').removeClass('lae-disabled');
        }

    };


    LAE_Twitter_Grid.prototype.initLightbox = function ($blockElem) {

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

                var title = $(this).data('author-name') || '';

                var username = $(this).data('author-username') || '';

                var authorLink = $(this).data('author-link') || '';

                var postLink = $(this).data('tweet-link') || '';

                var excerpt = $(this).data('tweet-text') || '';

                caption += '<div class="lae-tweet-fancybox-caption">';

                caption += '<a class="lae-twitter-user" href="' + authorLink + '" title="' + title + '">';

                caption += '<span class="lae-author-name">' + title + '</span>';

                caption += '<span class="lae-author-username">' + username + '</span>';

                caption += '<a/>';

                if (excerpt !== '') {
                    caption += '<div class="lae-tweet-text">' + excerpt + '</div>';
                }

                caption += '<div/>';

                return caption;
            }
        });

    };

    LAE_Twitter_Grid.prototype.handleLoadMore = function ($target) {

        if (this.is_ajax_running === true)
            return;

        var userAction = 'load_more';

        this.currentPage++;

        this.doAjaxBlockRequest(userAction);

    };

    var laeTwitterGrids = Object.create(laeGrids);

    laeTwitterGrids.getBlockObjById = function (blockId) {

        var blockIndex = this._getBlockIndex(blockId);

        if (blockIndex !== -1)
            return laeBlockObjColl[blockIndex];

        var blockObj = new LAE_Twitter_Grid(blockId);

        laeBlockObjColl.push(blockObj); // add to the array for instant retrieval later

        return blockObj;

    };

    /* -------------------------------------- END Gallery Block Implementation ----------------- */

    var WidgetLAETwitterGridHandler = function ( $scope, $ ) {

        var $blockElem = $scope.find( '.lae-block' );

        var rtl = $blockElem.attr( 'dir' ) === 'rtl';

        if ($blockElem.find( '.lae-module' ).length === 0) {
            return; // no items to display or load and hence don't continue
        }

        var currentBlockObj = laeTwitterGrids.getBlockObjById( $blockElem.data( 'block-uid' ) );

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


        /*---------------- Load More Button --------------------- */

        $scope.find( '.lae-pagination a.lae-load-more' ).on( 'click', function ( e ) {

            e.preventDefault();

            currentBlockObj.handleLoadMore( $( this ) );

        } );

        /* ---------------------- Init Lightbox ---------------------- */

        currentBlockObj.initLightbox( $blockElem );

    };

    // Make sure you run this code under Elementor..
    $( window ).on( 'elementor/frontend/init', function () {

        elementorFrontend.hooks.addAction( 'frontend/element_ready/lae-twitter-grid.default', WidgetLAETwitterGridHandler );

    } );

} )( jQuery );