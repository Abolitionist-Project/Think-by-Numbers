<?php
$hchart = <<<EOD

<div id='chart_$grouping' style='margin: 20px;'></div>
<div id='chart_timeline_$grouping' style='margin: 20px;'></div>

<script>
\$(function () {

    var chart;
    \$(document).ready(function() {
		time_shift_step = {$grouping_time_shift[$grouping]};
        chart = new Highcharts.Chart({
            chart: {
                renderTo: 'chart_$grouping',
                type: 'scatter',
                zoomType: 'xy',
				// events: {
					// load: function() {
						// this.renderer.button('Shift time', 70, 10, 28, 28)
						// .on('click', function() {
							// var axis = chart.yAxis[0];
							// axis.max = 25;
							// axis.isDirty = true;
							// chart.redraw();
						// }).add();
					// }
				// }
            },
			credits: {
				text: '(c) 2013 quantimodo.com',
				href: 'http://quantimodo.com'
			},
            title: {
				text: 'Scatter plot correlation ({$x_var_info[0]['App_name']}->{$x_var_info[0]['Var_name']}) Vs. ({$y_var_info[0]['App_name']}->{$y_var_info[0]['Var_name']})'
            },
            subtitle: {
				text: 'Original idea by Mike Sinn (c)2011-2013'
            },
            xAxis: {
                title: {
                    enabled: true,
                    text: '{$x_var_info[0]['Var_name']}'
                },
                startOnTick: true,
                endOnTick: true,
                showLastLabel: true
            },
            yAxis: {
                title: {
                    text: '{$y_var_info[0]['Var_name']}'
                }
            },
            tooltip: {
                formatter: function() {
                        return ''+
                        this.x +' {$x_var_info[0]['Unit_name']}, '+ this.y +' {$y_var_info[0]['Unit_name']}';
                }
            },
            legend: {
                layout: 'vertical',
                align: 'left',
                verticalAlign: 'top',
                x: 100,
                y: 70,
                floating: true,
                backgroundColor: '#FFFFFF',
                borderWidth: 1
            },
            plotOptions: {
                scatter: {
                    marker: {
                        radius: 5,
                        states: {
                            hover: {
                                enabled: true,
                                lineColor: 'rgb(100,100,100)'
                            }
                        }
                    },
                    states: {
                        hover: {
                            marker: {
                                enabled: false
                            }
                        }
                    }
                }
            },
            series: [{
				name: '$grouping correlation',
                color: 'rgba(223, 83, 83, .5)',
                data: $scatter_str
            }]
        });
    });
});

\$(function () {
    var chart;
    \$(document).ready(function() {
		var shift=0;
        chart = new Highcharts.Chart({
            chart: {
				renderTo: 'chart_timeline_$grouping',
                type: 'spline',
                zoomType: 'x',
				events: {
					load: function() {
						this.renderer.button('Shift time >>', 60, 10, 28, 28)
						.on('click', function() {
							for(i=0; i<chart.series[1].data.length; i++){
								chart.series[1].data[i].update([chart.series[1].data[i].x + {$grouping_time_shift[$grouping]}, chart.series[1].data[i].y], false);
							};
							shift++;
							if (shift != 0) chart.series[1].update({name: '{$y_var_info[0]['Var_name']} ' + shift + ' (shifted)'});
							else chart.series[1].update({name: '{$y_var_info[0]['Var_name']}'});
							chart.redraw();
						}).add();
						this.renderer.button('Shift time <<', 180, 10, 28, 28)
						.on('click', function() {
							for(i=0; i<chart.series[1].data.length; i++){
								chart.series[1].data[i].update([chart.series[1].data[i].x - {$grouping_time_shift[$grouping]}, chart.series[1].data[i].y], false);
							};
							shift--;
							if (shift != 0) chart.series[1].update({name: '{$y_var_info[0]['Var_name']} ' + shift + ' (shifted)'});
							else chart.series[1].update({name: '{$y_var_info[0]['Var_name']}'});
							chart.redraw();
						}).add();
					}
				}
            },
            title: {
				text: '{$x_var_info[0]['Var_name']} from {$x_var_info[0]['App_name']}  &  {$y_var_info[0]['Var_name']} from {$y_var_info[0]['App_name']}'
            },
			credits: {
				text: '(c) 2013 quantimodo.com',
				href: 'http://quantimodo.com'
			},
            xAxis: {
				type: 'datetime',
                startOnTick: true,
                endOnTick: true,
                showLastLabel: true
            },
            yAxis:[ {
				title: { text: '{$x_var_info[0]['Var_name']}' },
				max: $x_var_max ,
				endOnTick: true,
				startOnTick: true
            },{
                opposite: true,
				title: { text: '{$y_var_info[0]['Var_name']}' },
				max: $y_var_max,
				endOnTick: true,
				startOnTick: true
			}],
            legend: {
				layout: 'vertical',
				align: 'left',
				verticalAlign: 'top',
				floating: true,
				x: 65,
				y: 35,
				borderWidth: 1
            },
            series: [{
				name: '{$x_var_info[0]['Var_name']}',
                data: $timeline_X_str
            },{
				name: '{$y_var_info[0]['Var_name']}',
				data: $timeline_Y_str ,
				yAxis: 1
			}]
        });
    });
});


</script>

EOD;

?>