jQuery(function ($) {

    function WpReactionsAnalytics(data) {
        this.data = data;
        this.chart_data = {
            emotional_data: [],
            reactions_counts: [],
            reactions_line: [],
            social_share_line: [],
            social_counts: []
        }
        this.charts = {
            gauges: [],
            reactions_column: null,
            reactions_line: null,
            social_share_line: null,
            social_column: null,
        }
        this.chart_options = {
            gauge: {
                id: '',
                value: 0,
                min: 0,
                max: 100,
                symbol: '%',
                title: '',
                label: '',
                pointer: true,
                pointerOptions: {
                    color: '#ff0000',
                },
                levelColors: ["#4b9bf1"],
                gaugeWidthScale: 0.6,
                startAnimationType: 'bounce',
                titleFontColor: '#4999ed',
                titleFontFamily: 'Open Sans',
                decimals: 1,
                hideValue: true,
            },
            reactions_column: {
                chart: {
                    height: 450,
                    type: 'bar',
                    toolbar: {
                        show: false
                    },
                    dropShadow: {
                        enabled: true,
                        top: 0,
                        left: 5,
                        bottom: 5,
                        right: 0,
                        blur: 5,
                        color: '#45404a2e',
                        opacity: 0.35
                    },
                },
                plotOptions: {
                    bar: {
                        dataLabels: {
                            position: 'top', // top, center, bottom
                        },
                        horizontal: false,
                        columnWidth: '40px',
                    }
                },
                dataLabels: {
                    enabled: true,
                    formatter: function (val) {
                        return val;
                    },
                    offsetY: -20,
                    style: {
                        fontSize: '12px',
                        colors: ["#304758"]
                    }
                },
                colors: ["#4796ea"],
                series: [{
                    name: 'Reaction count',
                    data: data.reactions_counts,
                }],
                xaxis: {
                    type: 'category',
                    position: 'bottom',
                    labels: {
                        show: true,
                        offsetY: 0,
                    },
                    axisBorder: {
                        show: true,
                    },
                    crosshairs: {
                        fill: {
                            type: 'gradient',
                            gradient: {
                                colorFrom: '#D8E3F0',
                                colorTo: '#BED1E6',
                                stops: [0, 100],
                                opacityFrom: 0.4,
                                opacityTo: 0.5,
                            }
                        }
                    },
                    tooltip: {
                        enabled: false,
                        offsetY: -35,
                    },
                },
                yaxis: {
                    axisBorder: {
                        show: true,
                    },
                    axisTicks: {
                        show: true,
                    },
                    labels: {
                        show: true,
                        formatter: function (val) {
                            return val.toFixed(2);
                        }
                    },
                    forceNiceScale: true,
                },
                fill: {
                    gradient: {
                        enabled: false,
                        shade: 'light',
                        type: "horizontal",
                        shadeIntensity: 0.25,
                        gradientToColors: undefined,
                        inverseColors: true,
                        opacityFrom: 1,
                        opacityTo: 1,
                        stops: [50, 0, 100, 100]
                    },
                },
                grid: {
                    borderColor: '#ddd',
                    strokeDashArray: 7,
                    xaxis: {
                        lines: {
                            show: true
                        }
                    }
                },
                responsive: [{
                    breakpoint: 1400,
                    options: {
                        chart: {
                            height: 350,
                        },
                    },
                }],
            },
            reactions_line: {
                chart: {
                    height: 450,
                    type: 'line',
                    dropShadow: {
                        enabled: true,
                        top: 10,
                        left: 0,
                        bottom: 0,
                        right: 0,
                        blur: 2,
                        color: '#45404a2e',
                        opacity: 0.35
                    },
                    toolbar: {
                        show: false
                    },
                    zoom: {
                        enabled: false,
                    },
                },
                stroke: {
                    width: 2,
                    curve: 'smooth'
                },
                series: [{
                    name: 'Reactions',
                    data: data.reactions_line,
                }],
                xaxis: {
                    type: 'datetime',
                    axisBorder: {
                        show: true,
                    },
                    axisTicks: {
                        show: true,
                        color: '#bec7e0',
                    },
                    tooltip: {
                        enabled: false
                    },
                },
                tooltip: {
                    x: {
                        show: true,
                        format: 'dd MMM',
                    },
                },
                fill: {
                    type: 'gradient',
                    gradient: {
                        shade: 'dark',
                        gradientToColors: ["#506ee4"],
                        shadeIntensity: 1,
                        type: 'horizontal',
                        opacityFrom: 1,
                        opacityTo: 1,
                        stops: [0, 100, 100, 100]
                    },
                },
                yaxis: {
                    axisBorder: {
                        show: true,
                    },
                    title: {
                        text: 'Reactions History',
                    },
                    labels: {
                        show: true,
                        formatter: function (val) {
                            return val.toFixed(2);
                        }
                    },
                },
                grid: {
                    borderColor: '#ddd',
                    strokeDashArray: 7,
                    xaxis: {
                        lines: {
                            show: true
                        }
                    }
                },
                responsive: [{
                    breakpoint: 1400,
                    options: {
                        chart: {
                            height: 350,
                        },
                    },
                }],
            },
            social_share_line: {
                chart: {
                    height: 450,
                    type: 'line',
                    dropShadow: {
                        enabled: true,
                        top: 10,
                        left: 0,
                        bottom: 0,
                        right: 0,
                        blur: 2,
                        color: '#45404a2e',
                        opacity: 0.35
                    },
                    toolbar: {
                        show: false
                    },
                    zoom: {
                        enabled: false,
                    },
                },
                stroke: {
                    width: 2,
                    curve: 'smooth'
                },
                series: [{
                    name: 'Shares',
                    data: data.social_share_line,
                }],
                xaxis: {
                    type: 'datetime',
                    axisBorder: {
                        show: true,
                    },
                    axisTicks: {
                        show: true,
                        color: '#bec7e0',
                    },
                    tooltip: {
                        enabled: false
                    },
                },
                tooltip: {
                    x: {
                        show: true,
                        format: 'dd MMM',
                    },
                },
                fill: {
                    type: 'gradient',
                    gradient: {
                        shade: 'dark',
                        gradientToColors: ["#506ee4"],
                        shadeIntensity: 1,
                        type: 'horizontal',
                        opacityFrom: 1,
                        opacityTo: 1,
                        stops: [0, 100, 100, 100]
                    },
                },
                yaxis: {
                    axisBorder: {
                        show: true,
                    },
                    title: {
                        text: 'Social Shares History',
                    },
                    labels: {
                        show: true,
                        formatter: function (val) {
                            return val.toFixed(2);
                        }
                    },
                },
                grid: {
                    borderColor: '#ddd',
                    strokeDashArray: 7,
                    xaxis: {
                        lines: {
                            show: true
                        }
                    }
                },
                responsive: [{
                    breakpoint: 1400,
                    options: {
                        chart: {
                            height: 350,
                        },
                    },
                }],
            },
            social_column: {
                chart: {
                    height: 450,
                    type: 'bar',
                    toolbar: {
                        show: false
                    },
                    dropShadow: {
                        enabled: true,
                        top: 0,
                        left: 5,
                        bottom: 5,
                        right: 0,
                        blur: 5,
                        color: '#45404a2e',
                        opacity: 0.35
                    },
                },
                plotOptions: {
                    bar: {
                        dataLabels: {
                            position: 'top', // top, center, bottom
                        },
                        horizontal: false,
                        columnWidth: '40px',
                    }
                },
                dataLabels: {
                    enabled: true,
                    formatter: function (val) {
                        return val;
                    },
                    offsetY: -20,
                    style: {
                        fontSize: '12px',
                        colors: ["#304758"]
                    }
                },
                colors: ["#4796ea"],
                series: [{
                    name: 'Social count',
                    data: data.social_counts,
                }],
                xaxis: {
                    type: 'category',
                    position: 'bottom',
                    labels: {
                        show: true,
                        offsetY: 0,
                    },
                    axisBorder: {
                        show: true,
                    },
                    crosshairs: {
                        fill: {
                            type: 'gradient',
                            gradient: {
                                colorFrom: '#D8E3F0',
                                colorTo: '#BED1E6',
                                stops: [0, 100],
                                opacityFrom: 0.4,
                                opacityTo: 0.5,
                            }
                        }
                    },
                    tooltip: {
                        enabled: false,
                        offsetY: -35,
                    },
                },
                yaxis: {
                    axisBorder: {
                        show: true,
                    },
                    axisTicks: {
                        show: true,
                    },
                    labels: {
                        show: true,
                        formatter: function (val) {
                            return val.toFixed(2);
                        }
                    },
                    forceNiceScale: true,
                },
                fill: {
                    gradient: {
                        enabled: false,
                        shade: 'light',
                        type: "horizontal",
                        shadeIntensity: 0.25,
                        gradientToColors: undefined,
                        inverseColors: true,
                        opacityFrom: 1,
                        opacityTo: 1,
                        stops: [50, 0, 100, 100]
                    },
                },
                grid: {
                    borderColor: '#ddd',
                    strokeDashArray: 7,
                    xaxis: {
                        lines: {
                            show: true
                        }
                    }
                },
                responsive: [{
                    breakpoint: 1400,
                    options: {
                        chart: {
                            height: 350,
                        },
                    },
                }],
            },
        }
        this.rendered_tabs = [];
        this.init();
    }

    WpReactionsAnalytics.prototype.init = function () {
        this.register_events();

        $('.interval-custom-range').daterangepicker({
            drops: "up",
            opens: "left",
            maxDate: moment().format('MM/DD/YYYY'),
        });

        if (this.rendered_tabs.length == 0) {
            this.render_tab_data();
        }
    }

    WpReactionsAnalytics.prototype.update_emotional_data = function () {
        let self = this;
        self.charts.gauges = [];
        $('.emotional-data-container').each(function () {
            let emoji_id = $(this).data('emoji_id');
            let label = $(this).data('label');
            let value = $(this).data('value');
            self.chart_options.gauge.id = 'emotional-data-graph-emoji-' + emoji_id;
            self.chart_options.gauge.title = label;
            self.chart_options.gauge.value = value;
            self.chart_options.gauge.label = value + '%';
            self.charts.gauges.push(new JustGage(self.chart_options.gauge));
        });
    }

    WpReactionsAnalytics.prototype.get_chart_data = function (chart_type, interval, $chart, success = null) {
        let self = this;
        const source = $('#analytics_type').val();
        const sgc_id = $('#analytics_sgc_id').val() ? $('#analytics_sgc_id').val() : 0;

        $.ajax({
            url: self.data.ajaxurl,
            dataType: 'JSON',
            type: 'post',
            data: {
                action: 'wpra_handle_admin_requests',
                sub_action: 'get_chart_data',
                chart_type: chart_type,
                interval: interval,
                sgc_id: sgc_id,
                source: source
            },
            beforeSend: function () {
                $chart.append('<div class="wpra-analytics-loading"><span class="wpra-spinner"></span></div>');
            },
            success: function (data) {
                if (success) {
                    success(data);
                    return;
                }
                self.charts[chart_type].updateSeries([{
                    name: self.chart_options[chart_type].series[0].name,
                    data: data
                }]);
            },
            complete: function () {
                $chart.find('.wpra-analytics-loading').remove();
            }
        });
    }

    WpReactionsAnalytics.prototype.analytics_table_register_navs = function ($table) {
        let self = this;
        let $table_parent = $table.parents('[data-wpra-table]');
        let $navs = $table.next();
        let total_page_count = $table.data('total_page_count');

        $navs.find('.table-nav-next').on('click', function () {
            let page = $table_parent.data('page') ? $table_parent.data('page') : 1;
            if (page == total_page_count) return;
            self.analytics_table_navigate(page + 1, $table_parent);
            $table_parent.data('page', page + 1);
        });

        $navs.find('.table-nav-prev').on('click', function () {
            let page = $table_parent.data('page') ? $table_parent.data('page') - 1 : 0;
            if (page == 0) return;
            self.analytics_table_navigate(page, $table_parent);
            $table_parent.data('page', page);
        });

        $navs.find('.table-nav-first').on('click', function () {
            let page = $table_parent.data('page') ? $table_parent.data('page') : 1;
            if (page == 1) return;
            self.analytics_table_navigate(1, $table_parent);
            $table_parent.data('page', 1);
        });

        $navs.find('.table-nav-last').on('click', function () {
            let page = $table_parent.data('page') ? $table_parent.data('page') : 1;
            if (page == total_page_count) return;
            self.analytics_table_navigate(total_page_count, $table_parent);
            $table_parent.data('page', total_page_count);
        });
    }

    WpReactionsAnalytics.prototype.analytics_table_navigate = function (page, $table_wrap) {
        let self = this;
        const source = $('#analytics_type').val();
        const sgc_id = $('#analytics_sgc_id').val() ? $('#analytics_sgc_id').val() : 0;

        $.ajax({
            url: self.data.ajaxurl,
            dataType: 'text',
            type: 'post',
            data: {
                action: 'wpra_handle_admin_requests',
                sub_action: 'analytics_table_navigate',
                page: page,
                table: $table_wrap.data('table'),
                source: source,
                sgc_id: sgc_id
            },
            beforeSend: function () {
                $table_wrap.append('<div class="wpra-analytics-loading"><span class="wpra-spinner"></span></div>');
            },
            success: function (response) {
                $table_wrap.html(response);
                $table_wrap.find('.wpra-analytics-table-navs-total-curr').text(page);
                self.analytics_table_register_navs($table_wrap.find('table'));
            },
            complete: function () {
                $table_wrap.find('.wpra-analytics-loading').remove();
            }
        });
    }

    WpReactionsAnalytics.prototype.render_emotional_data = function ($tab) {
        let self = this;
        const source = $('#analytics_type').val();
        const sgc_id = $('#analytics_sgc_id').val() ? $('#analytics_sgc_id').val() : 0;
        if ($tab.attr('id') != 'wpra-reactions-analytics') return;

        $.ajax({
            url: self.data.ajaxurl,
            dataType: 'text',
            type: 'post',
            data: {
                action: 'wpra_handle_admin_requests',
                sub_action: 'render_emotional_data',
                sgc_id: sgc_id,
                source: source
            },
            beforeSend: function () {
                $('.emotional-data').append('<div class="wpra-analytics-loading"><span class="wpra-spinner"></span></div>');
            },
            success: function (response) {
                $('.emotional-data').html(response);
                self.update_emotional_data();
                $(window).trigger('wpra.analytics.emotional_data_loaded')
            }
        });
    }

    WpReactionsAnalytics.prototype.render_social_data = function ($tab) {
        let self = this;
        const source = $('#analytics_type').val();
        const sgc_id = $('#analytics_sgc_id').val() ? $('#analytics_sgc_id').val() : 0;
        if ($tab.attr('id') != 'wpra-social-platforms-analytics') return;

        $.ajax({
            url: self.data.ajaxurl,
            dataType: 'text',
            type: 'post',
            data: {
                action: 'wpra_handle_admin_requests',
                sub_action: 'render_social_data',
                sgc_id: sgc_id,
                source: source
            },
            beforeSend: function () {
                $('.wpra-analytics-social').append('<div class="wpra-analytics-loading"><span class="wpra-spinner"></span></div>');
            },
            success: function (response) {
                $('.wpra-analytics-social').html(response);
            }
        });
    }

    WpReactionsAnalytics.prototype.render_tables_data = function ($tab) {
        let self = this;
        $tab.find('[data-wpra-table]').each(function () {
            self.analytics_table_navigate(1, $(this));
        });
    }

    WpReactionsAnalytics.prototype.update_all_charts = function ($tab) {
        let self = this;

        $tab.find('[data-wpra-chart]').each(function () {
            const $chart = $(this);
            const rendered = $chart.data('rendered');
            const chart_type = $chart.data('chart_type');
            const chart = $chart.get(0);
            let onSuccess = rendered
                ? function (data) {
                    self.charts[chart_type].updateSeries([{
                        name: self.chart_options[chart_type].series[0].name,
                        data: data
                    }]);
                }
                : function (data) {
                    self.chart_options[chart_type].series[0].data = data;
                    self.charts[chart_type] = new ApexCharts(chart, self.chart_options[chart_type]);
                    self.charts[chart_type].render();
                    $chart.data('rendered', true);
                };

            self.get_chart_data(chart_type, 'last_30_days', $chart, onSuccess);
        });
    }

    WpReactionsAnalytics.prototype.render_tab_data = function () {
        let $tab = $('.tab-pane.active');
        this.update_all_charts($tab);
        this.render_emotional_data($tab);
        this.render_social_data($tab);
        this.render_tables_data($tab);
        this.rendered_tabs.push($tab.attr('id'));
    }

    WpReactionsAnalytics.prototype.register_events = function () {
        let self = this;

        $(document).click(function () {
            $('.wpra-interval-chooser').removeClass('active');
        });

        $('.wpra-interval-chooser-toggle').click(function (e) {
            e.stopPropagation();
            let $ic = $(this).parent();
            $ic.toggleClass('active');
        });

        $('.interval-options > span').click(function (e) {
            e.stopPropagation();

            let $ic = $(this).parents('.wpra-interval-chooser');
            let interval = $(this).data('interval');
            if (interval == 'custom_range') return;

            let chart_type = $ic.data('chart_type');
            let chosen_text = $(this).text();
            $ic.find('.wpra-interval-chooser-current').text(chosen_text);
            $ic.removeClass('active');

            self.get_chart_data(chart_type, interval, $ic.parent().next());
        });

        $('.interval-custom-range').on('show.daterangepicker', function (ev, picker) {
            picker.container.on('click', function (e) {
                e.stopPropagation();
            });
        });

        $('.interval-custom-range').on('apply.daterangepicker', function (ev, picker) {
            let interval_text = picker.startDate.format('MMM D, YYYY') + ' - ' + picker.endDate.format('MMM D, YYYY');
            let interval = picker.startDate.format('YYYY-MM-DD') + '|' + picker.endDate.format('YYYY-MM-DD');

            let $ic = $(ev.target).parents('.wpra-interval-chooser');
            let chart_type = $ic.data('chart_type');
            $ic.find('.wpra-interval-chooser-current').text(interval_text);
            $ic.removeClass('active');
            self.get_chart_data(chart_type, interval, $ic.parent().next());
        });

        $('#analytics_type').change(function () {
            if ($(this).val() == 'shortcode') {
                if (!$('#analytics_sgc_id').val()) {
                    WpReactionsUtils.showMessage(self.data.messages.no_any_shortcode, 'error');
                    $(this).val('global');
                    return;
                }
                $('.analytics-type-shortcode').show();
            } else {
                $('.analytics-type-shortcode').hide();
            }
            self.rendered_tabs = [];
            self.render_tab_data();
        });

        $('#analytics_sgc_id').on('searchable.change', function () {
            self.rendered_tabs = [];
            self.render_tab_data();
        });

        $('[data-toggle="pill"]').on('shown.bs.tab', function (e) {
            const tab_id = $(e.target).attr('href').replace('#', '');
            if (self.rendered_tabs.indexOf(tab_id) == -1) {
                self.render_tab_data();
            }
        });
    }

    new WpReactionsAnalytics(wpra_analytics);
});