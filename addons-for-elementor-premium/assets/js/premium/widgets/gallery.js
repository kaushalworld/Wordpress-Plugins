( function ( $ ) {


    /* -------------------------------------- START Gallery Block Implementation ----------------- */

    function LAE_Gallery() {

        LAE_Block.apply(this, arguments);

    }

    // inherit LAE_Block
    LAE_Gallery.prototype = Object.create(LAE_Grid.prototype);

    LAE_Gallery.prototype.constructor = LAE_Gallery;

    LAE_Gallery.prototype._getFilteredItems = function () {

        var self = this;

        var filteredItems = [];

        // if this is filtered results
        if (self.filterTerm.length) {

            filteredItems = self.items.filter(function (item) {

                if (item['item_tags'].length) {

                    var terms = item['item_tags'].split(',');

                    terms = terms.map(function (str) {
                        return str.trim().replace(/\s+/g, '-');
                    });

                    return (terms.indexOf(self.filterTerm) !== -1);
                }
                return false;
            });

        } else {
            filteredItems = self.items;
        }

        return filteredItems;
    };

    LAE_Gallery.prototype._getMaxPages = function () {

        var self = this;

        var filteredItems = self._getFilteredItems();

        var itemsPerPage = self.settings['items_per_page'];

        return Math.ceil(filteredItems.length / itemsPerPage);

    };

    LAE_Gallery.prototype._getRemainingItems = function () {

        var self = this;

        var filteredItems = self._getFilteredItems();

        var itemsPerPage = self.settings['items_per_page'];

        var remainingItems = filteredItems.length - (self.currentPage * itemsPerPage);

        return Math.max(0, remainingItems);

    };

    LAE_Gallery.prototype._getItemsToDisplay = function () {

        var self = this;

        var displayItems = self._getFilteredItems();

        var itemsPerPage = self.settings['items_per_page'];

        var start = itemsPerPage * (self.currentPage - 1);

        var end = start + itemsPerPage;

        // send only the relevant items
        displayItems = displayItems.slice(start, end);

        return displayItems;

    };

    LAE_Gallery.prototype._doAjaxBlockProcessResponse = function (cacheHit, response, userAction) {

        var self = this;

        //read the server response
        var responseObj = $.parseJSON(response); //get the data object

        if (this.blockId !== responseObj.blockId)
            return; // not mine

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

        } else {

            var $blockElementInner = $blockElem.find('.lae-block-inner');

            var $existing_items = $blockElementInner.children('.lae-block-column');

            var $response = $('<div></div>').html(responseObj.data);

            $response.imagesLoaded(function () {

                if (cacheHit == false)
                    $blockElem.removeClass('lae-fetching');

                $blockElementInner.isotope('remove', $existing_items);

                var $new_items = $response.children('.lae-block-column');

                if ($new_items.length)
                    $blockElementInner.isotope('insert', $new_items);
            });

        }

        var maxPages = self._getMaxPages();

        $blockElem.attr('data-current', self.currentPage);

        $blockElem.attr('data-maxpages', maxPages);


        $blockElem.find('.lae-pagination .lae-page-nav.lae-current-page').removeClass('lae-current-page');

        $blockElem.find('.lae-page-nav[data-page="' + parseInt(self.currentPage) + '"]').addClass('lae-current-page');

        $blockElem.find('.lae-page-nav[data-page="next"]').removeClass('lae-disabled');
        $blockElem.find('.lae-page-nav[data-page="prev"]').removeClass('lae-disabled');

        //hide or show prev
        if (self.currentPage === 1) {
            $blockElem.find('.lae-page-nav[data-page="prev"]').addClass('lae-disabled');
        }

        //hide or show next
        if (self.currentPage >= maxPages) {
            $blockElem.find('.lae-page-nav[data-page="next"]').addClass('lae-disabled');
        }

        // If the query is being filtered by a specific taxonomy term - the All option is not chosen
        if (responseObj.filterTerm.length) {

            if (maxPages == 1) {
                // Hide everything if no pagination is required
                $blockElem.find('.lae-page-nav').hide();
            } else {

                // hide all pages which are irrelevant in filtered results
                $blockElem.find('.lae-page-nav').each(function () {

                    var page = $(this).attr('data-page'); // can return next and prev too

                    if (page.match('prev|next')) {
                        $(this).show(); // could have been hidden with earlier filter if maxPages == 1
                    } else if (parseInt(page) > maxPages) {
                        $(this).hide();
                    } else {
                        $(this).show(); // display the same if hidden due to previous filter
                    }
                });
            }
        } else {
            // display all navigation if it was hidden before during filtering
            $blockElem.find('.lae-page-nav').show();
        }

        // Reorganize the pagination if there are too many pages to display navigation for
        this._processNumberedPagination();

        var remainingPosts = parseInt(self._getRemainingItems());

        // Set remaining posts to be loaded and hide the button if we just loaded the last page
        if (self.settings['show_remaining'] && remainingPosts !== 0) {
            $blockElem.find('.lae-pagination a.lae-load-more span').text(remainingPosts);
        }

        if (remainingPosts === 0) {
            $blockElem.find('.lae-pagination a.lae-load-more').addClass('lae-disabled');
        } else {
            $blockElem.find('.lae-pagination a.lae-load-more').removeClass('lae-disabled');
        }

    };


    LAE_Gallery.prototype.initLightbox = function ($blockElem) {

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
            thumbs: {
                autoStart: false, // Display thumbnails on opening
                hideOnClose: true, // Hide thumbnail grid when closing animation starts
                axis: "x" // Vertical (y) or horizontal (x) scrolling
            },
            caption: function (instance, item) {

                var caption = $(this).attr('title') || '';

                var description = $(this).data('description') || '';

                if (description !== '') {
                    caption += '<div class="lae-fancybox-description">' + description + '</div>';
                }

                return caption;
            }
        });

    };

    var laeGalleries = Object.create(laeBlocks);

    laeGalleries.getBlockObjById = function (blockId) {

        var blockIndex = this._getBlockIndex(blockId);

        if (blockIndex !== -1)
            return laeBlockObjColl[blockIndex];

        var blockObj = new LAE_Gallery(blockId);

        laeBlockObjColl.push(blockObj); // add to the array for instant retrieval later

        return blockObj;

    };

    /* -------------------------------------- END Gallery Block Implementation ----------------- */


    var WidgetLAEGalleryHandler = function ( $scope, $ ) {

        var $blockElem = $scope.find( '.lae-block' );

        var rtl = $blockElem.attr( 'dir' ) === 'rtl';

        if ($blockElem.find( '.lae-module' ).length === 0) {
            return; // no items to display or load and hence don't continue
        }

        var currentBlockObj = laeGalleries.getBlockObjById( $blockElem.data( 'block-uid' ) );

        /* ----------- Init Isotope on Grid  -------------- */

        var layoutMode = currentBlockObj.settings['layout_mode'];

        // layout Isotope after all images have loaded
        var $blockElemInner = $blockElem.find( '.lae-block-inner' );

        $blockElemInner.isotope( {
            itemSelector: '.lae-block-column',
            layoutMode: layoutMode,
            originLeft: !rtl,
            transitionDuration: '0.8s',
            masonry: {
                columnWidth: '.lae-grid-sizer'
            }
        } );

        $blockElemInner.imagesLoaded( function () {
            $blockElemInner.isotope( 'layout' );
        } );

        // Relayout on inline full screen video and back
        $( document ).on( 'webkitfullscreenchange mozfullscreenchange fullscreenchange', function ( e ) {
            $blockElemInner.isotope( 'layout' );
        } );

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


        elementorFrontend.hooks.addAction( 'frontend/element_ready/lae-gallery.default', WidgetLAEGalleryHandler );


    } );

} )( jQuery );