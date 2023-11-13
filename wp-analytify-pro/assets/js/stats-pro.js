'use strict';

/**
 * This file handles all the ajax requests for the core dashboard.
 * This also includes generating and charts and populating the data into a view.
 * 
 */

jQuery(document).ready(function ($) {

	// wrapper for keeping realtime historical data.
	const RealTimeHistoricalData = [];

	let realtime_chart;

	/**
	 * Handles the ajax request for the dashboard stats.
	 *
	 * @param {string} endpoint The API endpoint.
	 * @param {object} data     The data to send in the request.
	 * 
	 * @returns {object}
	 */
	const fetch_stats = async (endpoint, data = {}) => {

		// start/end dates and date differ.
		if ($('#analytify_date_start').length) {
			data.sd = $('#analytify_date_start').val();
		}
		if ($('#analytify_date_end').length) {
			data.ed = $('#analytify_date_end').val();
		}
		if ($('#analytify_date_diff').length) {
			data.d_diff = $('#analytify_date_diff').val();
		}

		// convert data to url params.
		const params = new URLSearchParams();
		for (const key in data) {
			params.append(key, data[key]);
		}

		const URL = `${analytify_stats_pro.url + endpoint + '/' + analytify_stats_pro.delimiter}${params.toString()}`;

		let request = await fetch(URL, {
			method: "GET",
			headers: {
				"X-WP-Nonce": analytify_stats_pro.nonce,
			},
		});

		return request.json();
	}

	/**
	 * Sets the target element to 'loading' state.
	 * Also clear the element's contents.
	 * 
	 * @param {element} target The target element.
	 */
	const prepare_section = (target) => {
		target.find('.analytify_stats_loading').show();
		target.find('.analytify_status_body .stats-wrapper').html('');
		target.find('.analytify_status_footer').remove();
		target.find('.empty-on-loading').html('');
	}

	/**
	 * Element should not be loading.
	 * 
	 * @param {element} target The target element.
	 */
	const should_not_be_loading = (target) => {
		target.find('.analytify_stats_loading').hide();
	}

	/**
	 * Sets the content for the element.
	 * Removes the 'loading' state.
	 * 
	 * @param {element} target     The target element.
	 * @param {string}  markup     The markup to be set (should be HTML).
	 * @param {string}  footer     The footer markup to be set.
	 * @param {boolean} pagination Whether to show the pagination or not.
	 */
	const set_section = (target, markup, footer = false, pagination = false) => {
		should_not_be_loading(target);
		target.find('.analytify_status_body .stats-wrapper').html(markup);

		if (footer || pagination) {
			let footer_markup = `<div class="analytify_status_footer">
				${footer ? `<span class="analytify_info_stats">${footer}</span>` : ''}
				${pagination ? `<div class="wp_analytify_pagination"></div>` : ''}
			</div>`;
			target.find('.analytify_status_body').after(footer_markup);
		}
	}

	/**
	 * Generates the empty stats message.
	 * 
	 * @param {element} target       The target element.
	 * @param {string}  message      The message to be shown.
	 * @param {object}  table_header The table header, if the message needs to be shown in a table.
	 * @param {string}  table_class  The table class.
	 */
	const stats_message = (target = false, message = false, table_header = false, table_class = '') => {
		let markup = `<div class="analytify-stats-error-msg">
			<div class="wpb-error-box">
				<span class="blk"><span class="line"></span><span class="dot"></span></span>
				<span class="information-txt">${message ? message : analytify_stats_pro.no_stats_message}</span>
			</div>
		</div>`;

		if (table_header) {
			// If the error message is to be shown in a table.
			let thead = '';
			for (const td_key in table_header) {
				const td = table_header[td_key];
				if (td.label) {
					thead += `<th class="${td.th_class ? td.th_class : ``}">${td.label}</th>`;
				}
			}

			markup = `<table class="${table_class}">${'' !== thead ? `<thead><tr>${thead}</tr></thead>` : ''}<tbody><tr><td class="analytify_td_error_msg" colspan="${Object.keys(table_header).length}">${markup}</td></tr></tbody></table>`;
		}

		if (!target) {
			return markup;
		}
		set_section(target, markup, false, false);
	}

	/**
	 * Generates the red message box.
	 * 
	 * @param {element} target       The target element.
	 * @param {string}  message      The message to be shown.
	 * @param {object}  table_header The table header, if the message needs to be shown in a table.
	 * @param {string}  table_class  The table class.
	 */
	const red_stats_message = (target = false, message = false, table_header = false, table_class = '') => {
		let markup = `<div class="analytify-email-promo-contianer">
			<div class="analytify-email-premium-overlay">
				<div class="analytify-email-premium-popup">
					${message.title ? `<h3 class="analytify-promo-popup-heading" style="text-align:left;">${message.title}</h3>` : ``}
					${message.content ? message.content : ``}
				</div>
			</div>
		</div>`;

		if (table_header) {
			// If the error message is to be shown in a table.
			let thead = '';
			for (const td_key in table_header) {
				const td = table_header[td_key];
				if (td.label) {
					thead += `<th class="${td.th_class ? td.th_class : ``}">${td.label}</th>`;
				}
			}

			markup = `<table class="${table_class}">${'' !== thead ? `<thead><tr>${thead}</tr></thead>` : ''}<tbody><tr><td class="analytify_td_error_msg" colspan="${Object.keys(table_header).length}">${markup}</td></tr></tbody></table>`;
		}

		if (!target) {
			return markup;
		}
		set_section(target, markup, false, false);
	}

	/**
	 * Generates table from object.
	 * {headers} is to generate <thead> tag and content.
	 * {stats} is to generate <tbody> tag and content.
	 * 
	 * @param {object} headers       The headers.
	 * @param {object} stats         The stats to be shown.
	 * @param {string} table_classes Table classes
	 * @param {string} attr          Table attributes
	 * @returns {string}
	 */
	const generate_stats_table = (headers, stats, table_classes = false, attr = '') => {

		let markup = ``;

		markup += `<table class="${table_classes}" ${attr}>`;

		let thead = '';
		for (const td_key in headers) {
			const td = headers[td_key];
			if (td.label) {
				thead += `<th class="${td.th_class ? td.th_class : ``}">${td.label}</th>`;
			}
		}
		if ('' !== thead) {
			markup += `<thead><tr>${thead}</tr></thead>`;
		}

		markup += `<tbody>`;

		let i = 1;
		for (const row_id in stats) {
			const row = stats[row_id];
			markup += `<tr>`;
			for (const td_key in row) {

				let __label = '';

				if (row[td_key] === null && headers[td_key].type && 'counter' === headers[td_key].type) {
					__label = i;
				} else if (row[td_key].label) {
					__label = row[td_key].label;
				} else if (row[td_key].value) {
					__label = row[td_key].value;
				} else {
					__label = row[td_key];
				}

				let __class = '';
				if (row[td_key] && row[td_key].class) {
					__class = row[td_key].class;
				} else if (headers[td_key] && headers[td_key].td_class) {
					__class = headers[td_key].td_class;
				}

				markup += `<td class="${__class}">${__label}</td>`;
			}
			markup += `</tr>`;
			i++;
		}
		markup += `</tbody>`;

		markup += `</table>`;

		return markup;

	}

	/**
	 * Returns the compare start and end date based on given start and end date.
	 * 
	 * @param {string} __start_date Start date.
	 * @param {string} __end_date   End date.
	 * @param {bool}   formatted    If true, returns formatted date to be used in the GA's dashboard url.
	 * @returns {object}
	 */
	const calc_compare_date = (__start_date, __end_date, formatted = true) => {

		const append_zero = (__num) => {
			return (__num < 10) ? '0' + __num : __num;
		}

		const compare_date = {};

		const start_date = new Date(__start_date);
		const end_date = new Date(__end_date);

		let diff_in_days = end_date.getTime() - start_date.getTime();
		if (diff_in_days === 0) {
			diff_in_days = 1 * 24 * 60 * 60 * 1000;
		}

		const compare_date_start = new Date(start_date.getTime() - diff_in_days);
		const compare_date_end = new Date(end_date.getTime() - diff_in_days);

		compare_date.start = compare_date_start.getFullYear() + '-' + append_zero(compare_date_start.getMonth() + 1) + '-' + append_zero(compare_date_start.getDate());
		compare_date.end = compare_date_end.getFullYear() + '-' + append_zero(compare_date_end.getMonth() + 1) + '-' + append_zero(compare_date_end.getDate());

		if (!formatted) {
			return compare_date;
		}

		return `%26_u.date00%3D${__start_date.replaceAll('-', '')}%26_u.date01%3D${__end_date.replaceAll('-', '')}%26_u.date10%3D${compare_date.start.replaceAll('-', '')}%26_u.date11%3D${compare_date.end.replaceAll('-', '')}`;
	}

	/**
	 * Builds the GA dashboard link for sections.
	 * Attaches the data parameter dynamically.
	 */
	const build_ga_dashboard_link = () => {
		const __start_date = $('#analytify_date_start').val();
		const __end_date = $('#analytify_date_end').val();

		const date_parameter = calc_compare_date(__start_date, __end_date, true);

		$('[data-ga-dashboard-pro-link]').each(function (index, __element) {
			const link = $(__element).attr('data-ga-dashboard-link') + date_parameter;
			$(__element).attr('href', link);
		});
	}

	/**
	 * Generates a table with wrapper for a single custom dimension.
	 *
	 * @param {object} data             The data to be displayed in the table.
	 * @param {string} left_right_class The class to be applied to the left/right table.
	 * @returns {string}
	 */
	const custom_dimension_table_wrapper = (data, left_right_class) => {
		return `<div class="analytify_half ${left_right_class}">
			<div class="analytify_general_status analytify_status_box_wraper">
				${data.title || data.title_stats ?
				`<div class="analytify_status_header analytify_header_adj">${data.title ? `<h3>${data.title}</h3>` : ``}${data.title_stats ? `<div class="analytify_status_header_value">${data.title_stats}</div>` : ``}</div>` : ``
			}
				<div class="analytify_dimension_pageviews_stats_boxes_wraper">
					${Object.keys(data.stats).length > 0 ? generate_stats_table(data.headers, data.stats, 'analytify_data_tables') : stats_message(false, false, false)}
				</div>
			</div>
		</div>`;
	}

	/**
	* Fetches the data and build the template for all endpoints.
	* 
	*/
	const build_sections = () => {

		// To trigger same-height js script.
		$(window).trigger('resize');

		$('[data-endpoint-pro]').each(function (index, __element) {
			const element = $(__element);
			const type = element.attr('data-endpoint-pro');

			prepare_section(element);

			if ('events-tracking' === type) {
				// Data is returned by the same api call for these section.
				prepare_section($('.analytify_affiliate-links'));
				prepare_section($('.analytify_download-links'));
				prepare_section($('.analytify_tel-links'));
				prepare_section($('.analytify_mail-links'));
			}

			fetch_stats(type).then((response) => {

				if (response.success) {

					switch (type) {
						case 'ajax-error':
						case '404-error':
						case 'js-error':
							{
								let table_classes;

								switch (type) {
									default:
										table_classes = 'analytify_data_tables';
										break;
								}

								if (Object.keys(response.stats).length > 0) {
									const markup = generate_stats_table(response.headers, response.stats, table_classes);
									set_section(element, markup, response.footer, response.pagination);
									if (element.find('.title-total-wrapper').length && response.title_stats) {
										element.find('.title-total-wrapper').html(response.title_stats);
									}
								} else {
									stats_message(element, false, response.headers, table_classes);
								}
							}
							break;

						case 'events-tracking':
							{
								const table_classes = 'analytify_data_tables';
								const categories = {
									'external': {
										'class': 'analytify_external-links',
									},
									'download': {
										'class': 'analytify_download-links',
									},
									'tel': {
										'class': 'analytify_tel-links',
									},
									'outbound': {
										'class': 'analytify_affiliate-links',
									},
									'mail': {
										'class': 'analytify_mail-links',
									}
								};

								for (const category in categories) {
									if (response[category]) {
										const element = $(`.${categories[category].class}`);
										if (response[category].stats?.length > 0) {
											const markup = generate_stats_table(response[category].headers, response[category].stats, table_classes);
											set_section(element, markup, '', true);
										} else {
											stats_message(element, false, response[category].headers, table_classes);
										}
									}
								}
							}
							break;

						case 'custom-dimensions':
							if (Object.keys(response.sections).length) {
								let counter = 1;
								let markup = '';
								let table_wrapper_class = '';
								for (const section in response.sections) {
									table_wrapper_class = counter % 2 === 0 ? 'analytify_right_flow' : 'analytify_left_flow';
									markup += `
										${table_wrapper_class === 'analytify_left_flow' ? `<div class="analytify_column">` : ``}
										${custom_dimension_table_wrapper(response.sections[section], table_wrapper_class)}
										${table_wrapper_class === 'analytify_right_flow' ? `</div>` : ``}
									`;
									counter++;
								}
								if (table_wrapper_class === 'analytify_right_flow') {
									markup += `</div>`;
								}
								set_section(element, markup, false, false);
							} else {
								if (response.error_message) {
									stats_message(element, response.error_message, false);
								} else {
									stats_message(element, analytify_stats_pro.error_message, false);
								}
							}
							break;

						case 'search-terms':
						case 'demographics':
							if (Object.keys(response.stats).length > 0) {
								const markup = generate_stats_table(response.headers, response.stats, 'analytify_data_tables');
								set_section(element, markup, response.footer, response.pagination);
							} else {
								stats_message(element, false, response.headers, 'analytify_data_tables');
							}
							break;

						default:
							break;
					}

					build_ga_dashboard_link();
					wp_analytify_paginated();
					$(window).trigger('resize');

				} else if (response.error_message) {
					should_not_be_loading(element);
					stats_message(element, response.error_message, response.headers);
				} else if (response.error_box) {
					should_not_be_loading(element);
					red_stats_message(element, response.error_box, response.headers);
				} else {
					should_not_be_loading(element);
					stats_message(element, analytify_stats_pro.error_message, response.headers);

					if ('events-tracking' === type) {
						// Data is returned by the same api call for these section.
						should_not_be_loading($('.analytify_affiliate-links'));
						should_not_be_loading($('.analytify_download-links'));
						should_not_be_loading($('.analytify_tel-links'));
						should_not_be_loading($('.analytify_mail-links'));

						stats_message($('.analytify_affiliate-links'), analytify_stats_pro.error_message, false);
						stats_message($('.analytify_download-links'), analytify_stats_pro.error_message, false);
						stats_message($('.analytify_tel-links'), analytify_stats_pro.error_message, false);
						stats_message($('.analytify_mail-links'), analytify_stats_pro.error_message, false);
					}
				}

			}).catch(function (error) {
				console.log(error);
			});

		});
	}

	build_sections();

	// Call of submission of date form.
	document.addEventListener('analytify_form_date_submitted', function (e) {
		if (analytify_stats_pro.load_via_ajax) {
			e.preventDefault();
			build_sections();
			build_ga_dashboard_link();
		}
	});

	/**
	 * Generates the realtime chart.
	 *
	 */
	const generate_realtime_chart = () => {
		require.config({
			paths: { echarts: analytify_stats_pro.dist_js_url }
		});

		require(
			['echarts', 'echarts/chart/bar', 'echarts/chart/line'],
			function (ec) {
				realtime_chart = ec.init(document.getElementById('analytify_real_time_visitors'));

				const time_data = [];
				for (let i = 600; i > -1; i = i - 30) {
					time_data.push(i + 's');
				}

				const options = {
					tooltip: { show: true },
					color: [analytify_stats_pro.realtime_chart_color],
					toolbox: {
						show: false,
						color: ["#444444", "#444444", "#444444", "#444444"],
						feature: {
							magicType: { show: true, type: ['line', 'bar'] },
							saveAsImage: { show: true }
						}
					},
					xAxis: [{
						type: 'category',
						boundaryGap: false,
						data: time_data
					}],
					yAxis: [{ type: 'value' }],
					series: [{
						"name": analytify_stats_pro.realtime_chart_label,
						"type": "line",
						smooth: true,
						itemStyle: {
							normal: {
								areaStyle: {
									type: 'default'
								}
							}
						},
						"data": RealTimeHistoricalData
					}]
				};
				realtime_chart.setOption(options);
			}
		);
	}

	/**
	 * Adds realtime historical data.
	 *
	 * @param {int} visitor Number of visitors.
	 */
	const add_realtime_history_data = (visitor) => {
		RealTimeHistoricalData.push(visitor);
		RealTimeHistoricalData.reverse();
		RealTimeHistoricalData.length = 21;
		RealTimeHistoricalData.reverse();
	}

	/**
	 * Fetches data for realtime dashboard and builds the three sections.
	 *
	 */
	const build_realtime_sections = () => {

		fetch_stats('real-time', { type: 'all' }).then((response) => {

			$('.realtime-chart-wrapper .stats_loading').removeClass('stats_loading');
			$('.realtime-table-wrapper .analytify_stats_loading').hide();

			// Set the counter section.
			if (response.counter) {
				for (const counter_key in response.counter) {
					$(`#pa-${counter_key}`).html(response.counter[counter_key]);
				}
			}

			// Push the visitor data to the historical data and update the chart.
			add_realtime_history_data(response.counter.online);
			realtime_chart.setOption({
				series: [{
					data: RealTimeHistoricalData
				}]
			});

			// Generate the pages table.
			const markup = (Object.keys(response.stats).length > 0) ? generate_stats_table(response.headers, response.stats, 'pa-pg analytify_data_tables') : stats_message(false, analytify_stats_pro.no_realtime_message, response.headers, 'pa-pg analytify_data_tables');

			$('.realtime-table-wrapper .analytify_top_pages_boxes_wraper').html(markup);

		}).catch(function (error) {
			console.log(error);
		});
	}

	// Realtime stats call.
	if (analytify_stats_pro.realtime_dashboard) {

		// push zeros as place holder.
		for (let index = 0; index <= 20; index++) {
			RealTimeHistoricalData.push(0);
		}

		generate_realtime_chart();
		build_realtime_sections();

		setInterval(() => {
			build_realtime_sections();
		}, 30000);

		$('#refresh-realtime-stats').on('click', function (e) {
			e.preventDefault();

			$(this).hide();
			setTimeout(() => {
				$('#refresh-realtime-stats').show();
			}, 5000);

			$('.realtime-table-wrapper .analytify_top_pages_boxes_wraper').html('');
			$('.realtime-table-wrapper .analytify_stats_loading').show();
			build_realtime_sections();
		});
	}

});
