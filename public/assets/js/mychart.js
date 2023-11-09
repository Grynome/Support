$(function () {
    'use strict';


    var colors = {
        primary: "#6571ff",
        secondary: "#7987a1",
        success: "#05a34a",
        info: "#66d1d1",
        warning: "#fbbc06",
        danger: "#ff3366",
        light: "#e9ecef",
        dark: "#060c17",
        muted: "#7987a1",
        gridBorder: "rgba(77, 138, 240, .15)",
        bodyColor: "#000",
        cardBg: "#fff"
    }

    var fontFamily = "'Roboto', Helvetica, sans-serif"
    if ($('#monthlySalesChart').length) {
        var options = {
            chart: {
                type: 'bar',
                height: '318',
                parentHeightOffset: 0,
                foreColor: colors.bodyColor,
                background: colors.cardBg,
                toolbar: {
                    show: false
                },
            },
            theme: {
                mode: 'light'
            },
            tooltip: {
                theme: 'light'
            },
            colors: [colors.primary],
            fill: {
                opacity: .9
            },
            grid: {
                padding: {
                    bottom: -4
                },
                borderColor: colors.gridBorder,
                xaxis: {
                    lines: {
                        show: true
                    }
                }
            },
            series: [{
                data: []
            }],
            xaxis: {
                categories: [],
                axisBorder: {
                    color: colors.gridBorder,
                },
                axisTicks: {
                    color: colors.gridBorder,
                },
            },
            yaxis: {
                title: {
                    text: 'Number of Ticket per Month',
                    style: {
                        size: 9,
                        color: colors.muted
                    }
                },
            },
            legend: {
                show: true,
                position: "top",
                horizontalAlign: 'center',
                fontFamily: fontFamily,
                itemMargin: {
                    horizontal: 8,
                    vertical: 0
                },
            },
            stroke: {
                width: 0
            },
            dataLabels: {
                enabled: true,
                style: {
                    fontSize: '10px',
                    fontFamily: fontFamily,
                },
                offsetY: -27
            },
            plotOptions: {
                bar: {
                    columnWidth: "50%",
                    borderRadius: 4,
                    dataLabels: {
                        position: 'top',
                        orientation: 'vertical',
                    }
                },
            },
        }

        var apexBarChart = new ApexCharts(document.querySelector("#monthlySalesChart"), options);
        $.ajax({
            url: mtTicketUrl,
            method: 'GET',
            success: function (data) {
                apexBarChart.updateSeries([{
                    name: data.series[0].name,
                    data: data.series[0].data
                }]);
                apexBarChart.updateOptions({
                    xaxis: {
                        type: data.xaxis[0].type,
                        categories: data.xaxis[0].categories
                    }
                });
            }
        });
        apexBarChart.render();
    }

    // End Montly TIcket
    if ($('#dashboardDate').length) {
        flatpickr("#dashboardDate", {
            wrap: true
        });
    }

    // Group Bar Chart
    // Grouped Bar Chart
    if ($('#weeklyTicket').length) {
        new Chart($('#weeklyTicket'), {
            type: 'bar',
            data: chartData,
            options: {
                plugins: {
                    legend: {
                        display: true,
                        labels: {
                            color: colors.bodyColor,
                            font: {
                                size: '13px',
                                family: fontFamily
                            }
                        }
                    },
                },
                scales: {
                    x: {
                        display: true,
                        grid: {
                            display: true,
                            color: colors.gridBorder,
                            borderColor: colors.gridBorder,
                        },
                        ticks: {
                            color: colors.bodyColor,
                            font: {
                                size: 12
                            }
                        }
                    },
                    y: {
                        grid: {
                            display: true,
                            color: colors.gridBorder,
                            borderColor: colors.gridBorder,
                        },
                        ticks: {
                            color: colors.bodyColor,
                            font: {
                                size: 12
                            }
                        }
                    }
                }
            }
        });
    }
    
    // Polar Area Chart
    if ($('#chartjsPolarArea').length) {
        new Chart($('#chartjsPolarArea'), {
            type: 'polarArea',
            data: {
                labels: ["Entry", "Open", "Close"],
                datasets: [{
                    label: "Population (millions)",
                    backgroundColor: [colors.primary, colors.warning, colors.success],
                    borderColor: colors.cardBg,
                    data: [valEntryTicket, 10, valClosedTicket]
                }]
            },
            options: {
                aspectRatio: 2,
                scales: {
                    r: {
                        angleLines: {
                            display: true,
                            color: colors.gridBorder,
                        },
                        grid: {
                            color: colors.gridBorder
                        },
                        ticks: {
                            backdropColor: colors.cardBg,
                            color: colors.bodyColor,
                            font: {
                                size: 11,
                                family: fontFamily
                            }
                        },
                        pointLabels: {
                            color: colors.bodyColor,
                            font: {
                                color: colors.bodyColor,
                                family: fontFamily,
                                size: '13px'
                            }
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: true,
                        labels: {
                            color: colors.bodyColor,
                            font: {
                                size: '13px',
                                family: fontFamily
                            }
                        }
                    },
                },
            }
        });
    }
});
