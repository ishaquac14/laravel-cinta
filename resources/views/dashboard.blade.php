<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script>

    <div class="container my-5">
        <h1>Dashboard</h1>
        <div class="row">
            <div class="col-md-6">
                <div class="card mb-3">
                    <div class="card-header">
                        Pie Chart
                    </div>
                    <div class="card-body">
                        <div id="pie_chart"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card mb-3">
                    <div class="card-header">
                        Line Chart
                    </div>
                    <div class="card-body">
                        <div id="line_chart"></div>
                    </div>
                </div>
            </div>
        </div>


        <div class="card mb-3">
            <div class="card-header">
                Column Chart
            </div>
            <div class="card-body">
                <div id="column_chart"></div>
            </div>
        </div>

    </div>
    <script>
        Highcharts.chart('column_chart', {
            chart: {
                type: 'column'
            },
            title: {
                text: 'Sum of Product Grouped by Year Chart',
            },
            xAxis: {
                categories: <?= json_encode($column['categories']) ?>,
                title: {
                    text: null
                },
                gridLineWidth: 1,
                lineWidth: 0
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Sales',
                },
                labels: {
                    overflow: 'justify'
                },
                gridLineWidth: 0
            },
            plotOptions: {
                bar: {
                    borderRadius: '50%',
                    dataLabels: {
                        enabled: true
                    },
                    groupPadding: 0.1
                }
            },
            legend: {
                layout: 'vertical',
                align: 'right',
                verticalAlign: 'top',
                x: -40,
                y: 80,
                floating: true,
                borderWidth: 1,
                backgroundColor: Highcharts.defaultOptions.legend.backgroundColor || '#FFFFFF',
                shadow: true
            },
            credits: {
                enabled: false
            },
            series: <?= json_encode($column['series']) ?>
        });
    </script>
    <script>
        Highcharts.chart('line_chart', {

            title: {
                text: 'Sum of Sales Chart',
            },
            yAxis: {
                title: {
                    text: 'Sales'
                }
            },

            xAxis: {
                categories: <?= json_encode($line['categories']) ?>
            },

            legend: {
                layout: 'vertical',
                align: 'right',
                verticalAlign: 'middle'
            },

            plotOptions: {
                series: {
                    label: {
                        connectorAllowed: false
                    },
                }
            },

            series: [{
                name: 'Sales',
                data: <?= json_encode($line['data']) ?>
            }],

            responsive: {
                rules: [{
                    condition: {
                        maxWidth: 500
                    },
                    chartOptions: {
                        legend: {
                            layout: 'horizontal',
                            align: 'center',
                            verticalAlign: 'bottom'
                        }
                    }
                }]
            }

        });
    </script>
    <script>
        Highcharts.chart('pie_chart', {
            chart: {
                type: 'pie'
            },
            title: {
                text: 'Product Count by Category Chart'
            },
            plotOptions: {
                series: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: [{
                        enabled: true,
                        distance: 20
                    }, {
                        enabled: true,
                        distance: -40,
                        format: '{point.percentage:.1f}%',
                        style: {
                            fontSize: '1.2em',
                            textOutline: 'none',
                            opacity: 0.7
                        },
                        filter: {
                            operator: '>',
                            property: 'percentage',
                            value: 10
                        }
                    }]
                }
            },
            series: [{
                name: 'Total',
                colorByPoint: true,
                data: <?= json_encode($pie) ?>
            }]
        });
    </script>
</body>

</html>