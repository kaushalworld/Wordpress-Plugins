const scrollTrackingMode = analytifyScroll.tracking_mode;
const isTrackingModeGA4  = analytifyScroll.ga4_tracking;

(function ($) {

	(function (factory) {
		if (typeof define === 'function' && define.amd) {
			// AMD
			define(['jquery'], factory);
		} else if (typeof module === 'object' && module.exports) {
			// CommonJS
			module.exports = factory(require('jquery'));
		} else {
			// Browser globals
			factory(jQuery);
		}
	}(function ($) {

		"use strict";

		let defaults = {
			percentage: true
		};

		let $window = $(window),
			cache = [],
			scrollEventBound = false,
			lastPixelDepth = 0;

		$.scrollDepth = function (options) {

			let startTime = +new Date();

			options = $.extend({}, defaults, options);

			function sendEvent( page_link, percentage, scrollDistance, timing ) {
				if ( 'gtag' === scrollTrackingMode ) {
					if ( isTrackingModeGA4 ) {
						gtag('event', 'scroll_depth', {
							'wpa_category': 'Analytify Scroll Depth',
							'wpa_percentage': percentage,
							'non_interaction': true
						});
					} else {
						gtag('event', percentage, {
							'event_category': 'Analytify Scroll Depth',
							'event_label': page_link,
							'value': 1,
							'non_interaction': true
						});
					}
			
					if ( arguments.length > 3 ) {
						gtag('event', 'timing_complete', {
							'event_category': 'Analytify Scroll Depth',
							'event_label': page_link,
							'value': timing,
							'non_interaction': true
						});
					}
				} else {
					let fieldsArray = {
						hitType: 'event',
						eventCategory: 'Analytify Scroll Depth',
						eventAction: percentage,
						eventLabel: page_link,
						eventValue: 1,
						nonInteraction: 1
					};
			
					if ( 'function' === typeof ga ) {
						ga('send', fieldsArray);
					}
			
					if ( arguments.length > 3 ) {
						fieldsArray = {
							hitType: 'timing',
							timingCategory: 'Analytify Scroll Depth',
							timingVar: percentage,
							timingValue: timing,
							timingLabel: page_link,
							nonInteraction: 1
						};
			
						if ( 'function' === typeof ga ) {
							ga('send', fieldsArray);
						}
					}
				}
			}

			function calculateMarks(docHeight) {
				return {
					'25': parseInt(docHeight * 0.25, 10),
					'50': parseInt(docHeight * 0.50, 10),
					'75': parseInt(docHeight * 0.75, 10),
					/* Cushion to trigger 100% event in iOS */
					'100': docHeight - 5
				};
			}

			function checkMarks(marks, scrollDistance, timing) {
				// analytifyScroll.title

				/* Check each active mark */
				$.each(marks, function (key, val) {
					if ($.inArray(key, cache) === -1 && scrollDistance >= val) {
						sendEvent(analytifyScroll.permalink, key, scrollDistance, timing);
						cache.push(key);
					}
				});
			}

			function rounded(scrollDistance) {
				/* Returns String */
				return (Math.floor(scrollDistance / 250) * 250).toString();
			}

			function init() {
				bindScrollDepth();
			}


			/* Reset Scroll Depth with the originally initialized options */
			$.scrollDepth.reset = function () {
				cache = [];
				lastPixelDepth = 0;
				$window.off('scroll.scrollDepth');
				bindScrollDepth();
			};

			/* Add DOM elements to be tracked */
			$.scrollDepth.addElements = function (elems) {

				if (typeof elems == "undefined" || !$.isArray(elems)) {
					return;
				}

				$.merge(options.elements, elems);

				/* If scroll event has been unbound from window, rebind */
				if (!scrollEventBound) {
					bindScrollDepth();
				}

			};

			/* Remove DOM elements currently tracked */
			$.scrollDepth.removeElements = function (elems) {

				if (typeof elems == "undefined" || !$.isArray(elems)) {
					return;
				}

				$.each(elems, function (index, elem) {

					let inElementsArray = $.inArray(elem, options.elements);
					let inCacheArray = $.inArray(elem, cache);

					if (inElementsArray != -1) {
						options.elements.splice(inElementsArray, 1);
					}

					if (inCacheArray != -1) {
						cache.splice(inCacheArray, 1);
					}

				});

			};

			function throttle(func, wait) {
				let context, args, result;
				let timeout = null;
				let previous = 0;
				let later = function () {
					previous = new Date;
					timeout = null;
					// console.log(result);
					result = func.apply(context, args);

				};
				return function () {
					let now = new Date;
					if (!previous) previous = now;
					let remaining = wait - (now - previous);
					context = this;
					args = arguments;
					if (remaining <= 0) {
						clearTimeout(timeout);
						timeout = null;
						previous = now;
						result = func.apply(context, args);
					} else if (!timeout) {
						timeout = setTimeout(later, remaining);
					}
					return result;
				};
			}

			/*
			* Scroll Event
			*/

			function bindScrollDepth() {

				scrollEventBound = true;

				$window.on('scroll.scrollDepth', throttle(function () {
					/*
					* We calculate document and window height on each scroll event to
					* account for dynamic DOM changes.
					*/

					let docHeight = $(document).height(),
						winHeight = window.innerHeight ? window.innerHeight : $window.height(),
						scrollDistance = $window.scrollTop() + winHeight,

						/* Recalculate percentage marks */
						marks = calculateMarks(docHeight),

						/* Timing */
						timing = +new Date - startTime;

					checkMarks(marks, scrollDistance, timing);
				}, 500));

			}

			init();
		};

		/* UMD export */
		return $.scrollDepth;

	}));

	$.scrollDepth();

})(jQuery)
