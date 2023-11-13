'use strict';

/**
 * Handles tracking for all events.
 * 
 */

// Wrapping the code in an anonymous function to avoid conflicts.
( function () {

	// Holds previous hash.
	let prevHash = window.location.hash;

	const eventsTrackingMode = analytify_events_tracking.tracking_mode;
	const GAMode = analytify_events_tracking.ga_mode;

	function trim_link_string(x) {
		return x.replace(/^\s+|\s+$/gm, '');
	}

	/**
	 * Returns the type of link tracking.
	 *
	 * @param {object} el The element to track.
	 * @returns 
	 */
	function get_tracking_type( el ) {

		// Default tracking type.
		let type = 'unknown';

		const link = el.href;
		const hostname = el.hostname;
		const protocol = el.protocol;
		const pathname = el.pathname;

		const download_extension = analytify_events_tracking.download_extension;
		const current_domain = analytify_events_tracking.root_domain;

		const affiliate_links = typeof analytify_events_tracking.affiliate_link !== 'undefined' ? analytify_events_tracking.affiliate_link : {};

		let index, len;

		if ( link.match(/^javascript\:/i) ) {
			// if its a JS link, it's internal
			type = 'internal';
		} else if ( trim_link_string(protocol) == 'tel' || trim_link_string(protocol) == 'tel:' ) {
			// Track telephone event.
			type = 'tel';
		} else if ( trim_link_string(protocol) == 'mailto' || trim_link_string(protocol) == 'mailto:' ) {
			// Track mail event.
			type = 'mailto';
		} else if ( hostname.length > 0 && current_domain.length > 0 && ! hostname.endsWith( current_domain ) ) {
			// Track external links.
			type = 'external';
		} else if ( Object.keys(affiliate_links).length > 0 && pathname.length > 0 ) {
			for ( const affiliate_link_index in affiliate_links ) {
				const affiliate_link = affiliate_links[affiliate_link_index];
				if ( affiliate_link.path && pathname.endsWith( affiliate_link.path ) ) {
					type = 'outbound';
					break;
				}
			}
		}

		// Track download files.
		if ( type === 'unknown' && download_extension.length > 0 ) {
			let regExp = '';
			try {
				regExp = new RegExp(".*\\.(" + download_extension + ")(\\?.*)?$");
			} catch (e) {
				console.log( 'Analytify Event Error: Invalid RegExp' );
			}

			if ( typeof regExp != 'undefined' && el.href.match( regExp ) ) {
				type = 'download';
			}
		}

		if ( type === 'unknown' ) {
			type = 'internal';
		}

		return type;
	}

	/**
	 * Sends the event call.
	 * 
	 * @param {string} category Event category.
	 * @param {string} action   Event action.
	 * @param {string} label    Event label.
	 */
	function send_event_call(category, action, label) {
		if ('gtag' === eventsTrackingMode) {

			if ( GAMode === 'ga4' ) {
				gtag('event', 'analytify_event_tracking', {
					'wpa_link_action': action,
					'wpa_category': category,
					'wpa_link_label': label,
				});
			} else {
				gtag('event', action, {
					'event_category': category,
					'event_label': label,
				});
			}
		} else {
			ga('send', 'event', category, action, label);
		}
	}

	/**
	 * Tracks events.
	 * 
	 * @param {object} event Event object.
	 * @returns 
	 */
	function track_event( event ) {

		if ( analytify_events_tracking.is_track_user != '1' ) {
			return;
		}

		event = event || window.event;

		let target = event.target || event.srcElement;

		// If link is not define. Get the parent link.
		while (target && (typeof target.tagName == 'undefined' || target.tagName.toLowerCase() != 'a' || !target.href)) {
			target = target.parentNode;
		}

		// if its links
		if ( target && target.href ) {

			let action = '';
			let label = '';

			const tracking_type = get_tracking_type( target );

			switch ( tracking_type ) {
				case 'outbound':
					action = target.getAttribute('data-vars-ga-action') || target.href;
					label = target.getAttribute('data-vars-ga-label') || target.title || target.innerText || target.href;
					send_event_call( 'outbound-link', action, label );
					break;

				case 'download':
					action = target.getAttribute('data-vars-ga-action') || target.href;
					label = target.getAttribute('data-vars-ga-label') || target.title || target.innerText || target.href;
					send_event_call( 'download', action, label );
					break;

				case 'tel':
					action = target.getAttribute('data-vars-ga-action') || target.href;
					label = target.getAttribute('data-vars-ga-label') || target.title || target.innerText || target.href;
					send_event_call( 'tel', action, label );
					break;

				case 'external':
					action = target.getAttribute('data-vars-ga-action') || target.href;
					label = target.getAttribute('data-vars-ga-label') || target.title || target.innerText || target.href;
					send_event_call( 'external', action, label );
					break;

				case 'mailto':
					action = target.getAttribute('data-vars-ga-action') || target.href;
					label = target.getAttribute('data-vars-ga-label') || target.title || target.innerText || target.href;
					send_event_call( 'mail', action, label );
					break;

				default:
					break;
			}
		}
	}

	/**
	 * Tracks hash change.
	 */
	function track_hash() {

		// If hash tracking is enabled.
		if ( analytify_events_tracking.anchor_tracking == 'on' && prevHash != window.location.hash ) {
			if ('gtag' === eventsTrackingMode) {
				gtag('config', trackingCode, { 'page_path': location.pathname + location.search + location.hash });
			} else {
				ga('set', 'page', location.pathname + location.search + location.hash);
				ga('send', 'pageview');
			}
		}
	}
	
	// When hash changes.
	window.addEventListener( 'hashchange', track_hash, false );

	// On Click.
	window.addEventListener( "load", function () {
		document.body.addEventListener( "click", track_event, false );
	}, false);

})();