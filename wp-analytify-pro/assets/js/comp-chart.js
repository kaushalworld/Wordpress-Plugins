function runCode($) {
  $(".compare-stats-report .analytify_stats_loading").css("display", "block");
  $(".compare-stats-report")
    .children()
    .not(".analytify_stats_loading")
    .remove();

  const URL = analytify_stats_pro.url + "compare-stats" + "/";
  const __start_date = $("#analytify_date_start").val();
  const __end_date = $("#analytify_date_end").val();
  $.ajax({
    url: URL,
    data: {
      sd: __start_date,
      ed: __end_date,
    },
    beforeSend: function (xhr) {
      xhr.setRequestHeader("X-WP-Nonce", analytify_stats_pro.nonce);
    },
  })
    .fail(function (data) {
      var _html =
        '<table class="analytify_data_tables analytify_no_header_table"><tbody><tr><td class="analytify_td_error_msg"><div class="analytify-stats-error-msg"><div class="wpb-error-box"><span class="blk"><span class="line"></span><span class="dot"></span></span><span class="information-txt">Something Unexpected Occurred.</span></div></div></td></tr></tbody></table>';
      $(".compare-stats-report")
        .html(_html)
        .parent()
        .removeClass("stats_loading");
    })
    .done(function (data) {
      $(".compare-stats-report .analytify_stats_loading").css(
        "display",
        "none"
      );
      $(".compare-stats-report").append(data.body);
      wp_analytify_paginated();
      try {
        is_three_month = data.stats_data.is_three_month;

        require.config({
          paths: {
            echarts: "js/dist/",
          },
        });

        require([
          "echarts",
          "echarts/chart/bar",
          "echarts/chart/line",
        ], function (ec) {
          // Initialize after dom ready.
          var years_graph_by_visitors = ec.init(
            document.getElementById("analytify_years_graph_by_visitors")
          );
          var months_graph_by_visitors = ec.init(
            document.getElementById("analytify_months_graph_by_visitors")
          );
          var years_graph_by_view = ec.init(
            document.getElementById("analytify_years_graph_by_view")
          );
          var months_graph_by_view = ec.init(
            document.getElementById("analytify_months_graph_by_view")
          );

          var years_graph_by_visitors_option = {
            tooltip: {
              position: function (p) {
                if (
                  $("#analytify_years_graph_by_visitors").width() - p[0] <=
                  200
                ) {
                  return [p[0] - 170, p[1]];
                }
              },
              formatter: function (params, ticket, callback) {
                var year_name = "";
                var seriesName = params.seriesName + "<br />";

                if (params.seriesIndex == "0") {
                  if (is_three_month == "1") {
                    var s_date = moment(params.name, "D-MMM-YYYY", true).format(
                        "MMM DD"
                      ),
                      year_name = moment(s_date, "MMM DD", true)
                        .add(-1, "years")
                        .format("D-MMM-YYYY");
                  } else {
                    var s_date = moment(params.name, "MMM-YYYY", true).format(
                        "MMM YYYY"
                      ),
                      year_name = moment(s_date, "MMM YYYY", true)
                        .add(-1, "years")
                        .format("MMM-YYYY");
                  }
                } else {
                  year_name = params.name;
                }
                return seriesName + year_name + " : " + params.value;
              },
              show: true,
            },
            color: [
              data.stats_data.graph_colors.visitors_last_year,
              data.stats_data.graph_colors.visitors_this_year,
            ],
            legend: {
              data: [
                data.stats_data.visitors_last_year_legend,
                data.stats_data.visitors_this_year_legend,
              ],
              orient: "horizontal",
            },
            toolbox: {
              show: true,
              color: ["#444444", "#444444", "#444444", "#444444"],
              feature: {
                magicType: {
                  show: true,
                  type: ["line", "bar"],
                  title: {
                    line: "Line",
                    bar: "Bar",
                  },
                },
                restore: { show: true, title: "Restore" },
                saveAsImage: { show: true, title: "Save As Image" },
              },
            },
            xAxis: [
              {
                type: "category",
                boundaryGap: false,
                data: data.stats_data.month_data,
              },
            ],
            yAxis: [
              {
                type: "value",
              },
            ],
            series: [
              {
                name: data.stats_data.visitors_last_year_legend,
                type: "line",
                smooth: true,
                itemStyle: {
                  normal: {
                    areaStyle: {
                      type: "default",
                    },
                  },
                },
                data: data.stats_data.previous_year_users_data,
              },
              {
                name: data.stats_data.visitors_this_year_legend,
                type: "line",
                smooth: true,
                itemStyle: {
                  normal: {
                    areaStyle: {
                      type: "default",
                    },
                  },
                },
                data: data.stats_data.this_year_users_data,
              },
            ],
          };
          var months_graph_by_visitors_option = {
            tooltip: {
              position: function (p) {
                if (
                  $("#analytify_months_graph_by_visitors").width() - p[0] <=
                  200
                ) {
                  return [p[0] - 170, p[1]];
                }
              },
              formatter: function (params, ticket, callback) {
                var month_name = "";
                if (params.seriesIndex == "0") {
                  var s_date = moment(params.name, "D-MMM", true).format(
                      "MMM DD"
                    ),
                    month_name = moment(s_date, "MMM DD", true)
                      .add(-1, "months")
                      .format("D-MMM");
                } else {
                  month_name = params.name;
                }
                return (
                  params.seriesName +
                  "<br />" +
                  month_name +
                  " : " +
                  params.value
                );
              },
              show: true,
            },
            color: [
              data.stats_data.graph_colors.visitors_last_month,
              data.stats_data.graph_colors.visitors_this_month,
            ],
            legend: {
              data: [
                data.stats_data.visitors_last_month_legend,
                data.stats_data.visitors_this_month_legend,
              ],
              orient: "horizontal",
            },
            toolbox: {
              show: true,
              color: ["#444444", "#444444", "#444444", "#444444"],
              feature: {
                magicType: {
                  show: true,
                  type: ["line", "bar"],
                  title: {
                    line: "Line",
                    bar: "Bar",
                  },
                },
                restore: { show: true, title: "Restore" },
                saveAsImage: { show: true, title: "Save As Image" },
              },
            },
            xAxis: [
              {
                type: "category",
                boundaryGap: false,
                data: data.stats_data.date_data,
              },
            ],
            yAxis: [
              {
                type: "value",
              },
            ],
            series: [
              {
                name: data.stats_data.visitors_last_month_legend,
                type: "line",
                smooth: true,
                itemStyle: {
                  normal: {
                    areaStyle: {
                      type: "default",
                    },
                  },
                },
                data: data.stats_data.previous_month_users_data,
              },
              {
                name: data.stats_data.visitors_this_month_legend,
                type: "line",
                smooth: true,
                itemStyle: {
                  normal: {
                    areaStyle: {
                      type: "default",
                    },
                  },
                },
                data: data.stats_data.this_month_users_data,
              },
            ],
          };

          var years_graph_by_view_option = {
            tooltip: {
              position: function (p) {
                if ($("#analytify_years_graph_by_view").width() - p[0] <= 200) {
                  return [p[0] - 170, p[1]];
                }
              },
              formatter: function (params, ticket, callback) {
                var year_name = "";
                var seriesName = params.seriesName + "<br />";
                // if ( is_three_month == '1' ) {
                //     seriesName = 'Views <br />';
                // }
                if (params.seriesIndex == "0") {
                  if (is_three_month == "1") {
                    var s_date = moment(params.name, "D-MMM-YYYY", true).format(
                        "MMM DD"
                      ),
                      year_name = moment(s_date, "MMM DD", true)
                        .add(-1, "years")
                        .format("D-MMM-YYYY");
                  } else {
                    var s_date = moment(params.name, "MMM-YYYY", true).format(
                        "MMM YYYY"
                      ),
                      year_name = moment(s_date, "MMM YYYY", true)
                        .add(-1, "years")
                        .format("MMM-YYYY");
                  }
                } else {
                  year_name = params.name;
                }
                return seriesName + year_name + " : " + params.value;
              },
              show: true,
            },
            color: [
              data.stats_data.graph_colors.views_last_year,
              data.stats_data.graph_colors.views_this_year,
            ],
            legend: {
              data: [
                data.stats_data.views_last_year_legend,
                data.stats_data.views_this_year_legend,
              ],
              orient: "horizontal",
            },
            toolbox: {
              show: true,
              color: ["#444444", "#444444", "#444444", "#444444"],
              feature: {
                magicType: {
                  show: true,
                  type: ["line", "bar"],
                  title: {
                    line: "Line",
                    bar: "Bar",
                  },
                },
                restore: { show: true, title: "Restore" },
                saveAsImage: { show: true, title: "Save As Image" },
              },
            },
            xAxis: [
              {
                type: "category",
                boundaryGap: false,
                data: data.stats_data.month_data,
              },
            ],
            yAxis: [
              {
                type: "value",
              },
            ],
            series: [
              {
                name: data.stats_data.views_last_year_legend,
                type: "line",
                smooth: true,
                itemStyle: {
                  normal: {
                    areaStyle: {
                      type: "default",
                    },
                  },
                },
                data: data.stats_data.previous_year_views_data,
              },
              {
                name: data.stats_data.views_this_year_legend,
                type: "line",
                smooth: true,
                itemStyle: {
                  normal: {
                    areaStyle: {
                      type: "default",
                    },
                  },
                },
                data: data.stats_data.this_year_views_data,
              },
            ],
          };

          var months_graph_by_view_option = {
            tooltip: {
              position: function (p) {
                if (
                  $("#analytify_months_graph_by_visitors").width() - p[0] <=
                  200
                ) {
                  return [p[0] - 170, p[1]];
                }
              },
              formatter: function (params, ticket, callback) {
                var month_name = "";
                if (params.seriesIndex == "0") {
                  var s_date = moment(params.name, "D-MMM", true).format(
                      "MMM DD"
                    ),
                    month_name = moment(s_date, "MMM DD", true)
                      .add(-1, "months")
                      .format("D-MMM");
                } else {
                  month_name = params.name;
                }
                return (
                  params.seriesName +
                  "<br />" +
                  month_name +
                  " : " +
                  params.value
                );
              },
              show: true,
            },
            color: [
              data.stats_data.graph_colors.views_last_month,
              data.stats_data.graph_colors.views_this_month,
            ],
            legend: {
              data: [
                data.stats_data.views_last_month_legend,
                data.stats_data.views_this_month_legend,
              ],
              orient: "horizontal",
            },
            toolbox: {
              show: true,
              color: ["#444444", "#444444", "#444444", "#444444"],
              feature: {
                magicType: {
                  show: true,
                  type: ["line", "bar"],
                  title: {
                    line: "Line",
                    bar: "Bar",
                  },
                },
                restore: { show: true, title: "Restore" },
                saveAsImage: { show: true, title: "Save As Image" },
              },
            },
            xAxis: [
              {
                type: "category",
                boundaryGap: false,
                data: data.stats_data.date_data,
              },
            ],
            yAxis: [
              {
                type: "value",
              },
            ],
            series: [
              {
                name: data.stats_data.views_last_month_legend,
                type: "line",
                smooth: true,
                itemStyle: {
                  normal: {
                    areaStyle: {
                      type: "default",
                    },
                  },
                },
                data: data.stats_data.previous_month_views_data,
              },
              {
                name: data.stats_data.views_this_month_legend,
                type: "line",
                smooth: true,
                itemStyle: {
                  normal: {
                    areaStyle: {
                      type: "default",
                    },
                  },
                },
                data: data.stats_data.this_month_views_data,
              },
            ],
          };

          // Load data into the ECharts instance.
          years_graph_by_visitors.setOption(years_graph_by_visitors_option);
          months_graph_by_visitors.setOption(months_graph_by_visitors_option);
          years_graph_by_view.setOption(years_graph_by_view_option);
          months_graph_by_view.setOption(months_graph_by_view_option);

          window.onresize = function () {
            try {
              years_graph_by_visitors.resize();
              months_graph_by_visitors.resize();
              years_graph_by_view.resize();
              months_graph_by_view.resize();
            } catch (err) {
              console.log(err);
            }
          };
        });
      } catch (err) {
        console.log(err);
      }
    });
}

// Call function on page load.
jQuery(document).ready(function ($) {
  runCode($);

  document.addEventListener("analytify_form_date_submitted", function (e) {
    e.preventDefault();
    if (analytify_stats_pro.load_via_ajax) {
      runCode($);
    }
  });
});
