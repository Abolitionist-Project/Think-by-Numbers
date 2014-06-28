<?php
$hchart = <<<EOD

<div id='chart_timeline_$top' style='margin: 20px;'></div>

<script>
\$(function () {
    var chart;
    \$(document).ready(function() {
		var shift=0;
        chart = new Highcharts.Chart({
            chart: {
				renderTo: 'chart_timeline_$top',
                type: 'spline',
                zoomType: 'xy',
            },
			legend: {
                layout: 'vertical',
                align: 'left',
                verticalAlign: 'top',
                x: 80,
                y: 0,
                floating: true,
                // backgroundColor: '#FFFFFF',
                borderWidth: 1
            },
            title: {
				text: '{$var_info[0]['Var_name']}'
            },
			credits: {
				text: 'Quantimodo statistics',
				href: 'http://quantimodo.com'
			},
            xAxis: {
				type: 'datetime',
                startOnTick: true,
                endOnTick: true,
                showLastLabel: true
            },
            yAxis:[ {
				title: { text: '{$var_info[0]['Var_name']}' },
				endOnTick: false,
				startOnTick: false,
				// min: 0,
                minorGridLineWidth: 0,
                gridLineWidth: 0,
                alternateGridColor: null,
                plotBands: [{ 
                    from: $min,
                    to: $low,
                    color: 'rgba(255, 0, 0, .6)',
                    label: {
						text: 'Too low values ',
                        style: {
                            color: 'white'
                        }
                    }
                },
				{ 
                    from: $top,
                    to: $max,
                    color: 'rgba(255, 0, 0, .6)',
                    label: {
						text: 'Too high values ',
                        style: {
                            color: 'white'
                        }
                    }
                }]
            }],
            series: [{
				name: '{$var_info[0]['Var_name']}',
                data: $timeline_X_str
            }]
        });
    });
});


</script>

EOD;

?>