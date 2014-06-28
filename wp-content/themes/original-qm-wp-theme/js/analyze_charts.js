var AnalyzeChart = function() {
	var scatterPlotChart, timeLineChart;
	
	var lineChartData = [
		0.8446, 0.8445, 0.8444, 0.8451,0.8418, 0.8264,0.8258, 0.8232,0.8233, 0.8258,
		0.8355, 0.8354, 0.8403, 0.8403,0.8406, 0.8403,0.8396, 0.8418,0.8409, 0.8384,
		0.8401, 0.8402, 0.8381, 0.8351,0.8314, 0.8273,0.8213, 0.8207,0.8207, 0.8215,
		0.8242, 0.8273, 0.8301, 0.8346,0.8312, 0.8312,0.8312, 0.8306,0.8327, 0.8282,
		0.7798, 0.7777, 0.7822, 0.7785, 0.7744, 0.7743, 0.7726, 0.7766, 0.7806, 0.785,
		0.7799, 0.78, 0.7801, 0.7765, 0.7785, 0.7811, 0.782, 0.7835, 0.7845, 0.7844,
		0.7648, 0.7648, 0.7641, 0.7614, 0.757, 0.7587, 0.7588, 0.762, 0.762, 0.7617,
		0.7631, 0.7615, 0.76, 0.7613, 0.7627, 0.7627, 0.7608, 0.7583, 0.7575, 0.7562,
		0.7378, 0.7366, 0.74, 0.7411, 0.7406, 0.7405, 0.7414, 0.7431, 0.7431, 0.7438,
		0.6965, 0.6956, 0.6956, 0.695, 0.6948, 0.6928, 0.6887, 0.6824, 0.6794, 0.6794,
		0.6896, 0.6896, 0.6882, 0.6879, 0.6862, 0.6852, 0.6823, 0.6813, 0.6813, 0.6822,
		0.6507, 0.651, 0.6489, 0.6424, 0.6406, 0.6382, 0.6382, 0.6341, 0.6344, 0.6378,
		0.6333, 0.633, 0.6371, 0.6403, 0.6396, 0.6364, 0.6356, 0.6356, 0.6368, 0.6357,
		0.6416, 0.6442, 0.6431, 0.6431, 0.6435, 0.644, 0.6473, 0.6469, 0.6386, 0.6356,
		0.645, 0.6441, 0.6414, 0.6409, 0.6409, 0.6428, 0.6431, 0.6418, 0.6371, 0.6349,
		0.631, 0.6312, 0.6312, 0.6304, 0.6294, 0.6348, 0.6378, 0.6368, 0.6368, 0.6368,
		0.7731, 0.7779, 0.7844, 0.7866, 0.7864, 0.7788, 0.7875, 0.7971, 0.8004, 0.7857,
		0.7745, 0.771, 0.775, 0.7791, 0.7882, 0.7882, 0.7899, 0.7905, 0.7889, 0.7879,
		0.714, 0.7119, 0.7129, 0.7129, 0.7049, 0.7095
	];
	
	var scatterPlotOptions = {
		chart: {
			renderTo: 'graph-scatterplot',
			type: 'scatter',
			zoomType: 'xy',
			backgroundColor: null
		},
		credits: {
			text: '',
			href: ''
		},
		exporting: {
			enabled: false
		},
		title: { text: "" },
		xAxis: {
			title: { enabled: true },
			startOnTick: true,
			endOnTick: true,
			showLastLabel: true
		},
		yAxis: { title: {} },
		tooltip: {
			/*
			 * not works (why?)
			 * http://api.highcharts.com/highcharts#tooltip.valueDecimals
			 */
			valueDecimals: 2
		},
		legend: {
			layout: 'vertical',
			align: 'left',
			verticalAlign: 'top',
			x: -50,
			y: -50,
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
			color: 'rgba(223, 83, 83, .5)'
		} ]
	};
	
	var timeLineOptions = {
		chart: {
			renderTo: 'graph-timeline',
			type: 'spline',
			zoomType: 'x',
			backgroundColor: null
		},
		credits: {
			text: '',
			href: ''
		},
		exporting: {
			enabled: false
		},
		title: { text:"" },
		xAxis: {
			type: 'datetime',
			startOnTick: true,
			endOnTick: true,
			showLastLabel: true
		},
		yAxis: [{
			title: {},
			endOnTick: true,
			startOnTick: true
		}, {
			opposite: true,
			title: {},
			endOnTick: true,
			startOnTick: true
		} ],
		legend: {
			layout: 'vertical',
			align: 'left',
			verticalAlign: 'top',
			floating: true,
			x: 55,
			y: 0,
			borderWidth: 2
		},
		series: [{
			name: 'Aname'
		}, {
			name: 'Bname',
			yAxis: 1
		} ]
	};
	
	var drawScatterPlot = function() {
		scatterPlotOptions.series[0].name = "Series name";
		scatterPlotOptions.series[0].data = lineChartData;
		scatterPlotOptions.xAxis.title.text = "Input variable name";
		scatterPlotOptions.yAxis.title.text = "Output variable name";
		scatterPlotOptions.tooltip.formatter = function() {
			return '' + this.x + ' ' + "Input unit name" + ', ' + this.y + ' ' + "Output unit name";
		};
		scatterPlotChart = new Highcharts.Chart(scatterPlotOptions);
	}
	
	var drawTimeLineChart = function(xValues, yValues) {
		var timeShiftedValue = null;
		
		if (timeShiftedValue === null) {
			timeLineOptions.series[0].name = "Variable name" + ", " + "Variable unit"
			timeLineOptions.series[0].data = lineChartData;
			//timeLineOptions.series[1].name = fullOutputVariableInfo.name + ", " + fullOutputVariableInfo.unitDto.name;
			//timeLineOptions.series[1].data = yValues;
	
			timeLineOptions.yAxis[0].title.text = "Variable name"
			timeLineOptions.yAxis[1].title.text = "Variable name"
			timeLineChart = new Highcharts.Chart(timeLineOptions);
		} else {
			for ( var i = 0; i < timeLineChart.series[0].data.length; i++) {
				timeLineChart.series[0].data[i].update([ xValues[i][0], xValues[i][1] ], false);
			}
			for ( var i = 0; i < timeLineChart.series[1].data.length; i++) {
				timeLineChart.series[1].data[i].update([ yValues[i][0], yValues[i][1] ], false);
			}
	
			timeLineChart.redraw();
		}
	}
	
	/* Fritsch-Carlson monotone cubic spline interpolation
	   Usage example:
		var f = createInterpolant([0, 1, 2, 3], [0, 1, 4, 9]);
		var message = '';
		for (var x = 0; x <= 3; x += 0.5) {
			var xSquared = f(x);
			message += x + ' squared is about ' + xSquared + '\n';
		}
		alert(message);
	*/
	var createInterpolant = function(xs, ys) {
		var i, length = xs.length;
		
		// Deal with length issues
		if (length != ys.length) { throw 'Need an equal count of xs and ys.'; }
		if (length === 0) { return function(x) { return 0; }; }
		if (length === 1) {
			// Impl: Precomputing the result prevents problems if ys is mutated later and allows garbage collection of ys
			// Impl: Unary plus properly converts values to numbers
			var result = +ys[0];
			return function(x) { return result; };
		}
		
		// Rearrange xs and ys so that xs is sorted
		var indexes = [];
		for (i = 0; i < length; i++) { indexes.push(i); }
		indexes.sort(function(a, b) { return xs[a] < xs[b] ? -1 : 1; });
		var oldXs = xs, oldYs = ys;
		// Impl: Creating new arrays also prevents problems if the input arrays are mutated later
		xs = []; ys = [];
		// Impl: Unary plus properly converts values to numbers
		for (i = 0; i < length; i++) { xs.push(+oldXs[indexes[i]]); ys.push(+oldYs[indexes[i]]); }
		
		// Get consecutive differences and slopes
		var dys = [], dxs = [], ms = [];
		for (i = 0; i < length - 1; i++) {
			var dx = xs[i + 1] - xs[i], dy = ys[i + 1] - ys[i];
			dxs.push(dx); dys.push(dy); ms.push(dy/dx);
		}
		
		// Get degree-1 coefficients
		var c1s = [ms[0]];
		for (i = 0; i < dxs.length - 1; i++) {
			var m = ms[i], mNext = ms[i + 1];
			if (m*mNext <= 0) {
				c1s.push(0);
			} else {
				var dx = dxs[i], dxNext = dxs[i + 1], common = dx + dxNext;
				c1s.push(3*common/((common + dxNext)/m + (common + dx)/mNext));
			}
		}
		c1s.push(ms[ms.length - 1]);
		
		// Get degree-2 and degree-3 coefficients
		var c2s = [], c3s = [];
		for (i = 0; i < c1s.length - 1; i++) {
			var c1 = c1s[i], m = ms[i], invDx = 1/dxs[i], common = c1 + c1s[i + 1] - m - m;
			c2s.push((m - c1 - common)*invDx); c3s.push(common*invDx*invDx);
		}
		
		// Return interpolant function
		return function(x) {
			// The rightmost point in the dataset should give an exact result
			var i = xs.length - 1;
			if (x == xs[i]) { return ys[i]; }
			
			// Search for the interval x is in, returning the corresponding y if x is one of the original xs
			var low = 0, mid, high = c3s.length - 1;
			while (low <= high) {
				mid = Math.floor(0.5*(low + high));
				var xHere = xs[mid];
				if (xHere < x) { low = mid + 1; }
				else if (xHere > x) { high = mid - 1; }
				else { return ys[mid]; }
			}
			i = Math.max(0, high);
			
			// Interpolate
			var diff = x - xs[i], diffSq = diff*diff;
			return ys[i] + c1s[i]*diff + c2s[i]*diffSq + c3s[i]*diff*diffSq;
		};
	};
	
	// Converts data into equally spaced (horizontally) points.
	var resolution = 100;
	var prepDataForGraphing = function(data) {
		var i;
		var xs = [];
		var ys = [];
		for (i = 0; i < data.length; i++) {
			var datum = data[i];
			xs.push(datum.timestamp);
			ys.push(datum.value);
		}
		var f = createInterpolant(xs, ys);
		
		xs = []; ys = [];
		var time = AnalyzePage.getStartTime();
		var endTime = AnalyzePage.getEndTime();
		var timeStep = (AnalyzePage.getEndTime() - time)/(resolution - 1);
		for (i = 0; i < resolution; i++) {
			xs.push(time);
			ys.push(f(time));
			time += timeStep;
		}
		
		return { xs: xs, ys: ys };
	}
	
	return {
		setInputData: function(variableName, data) {
			prepDataForGraphing(data);
			return;
			lineChartData = data;
			drawScatterPlot();
			drawTimelineChart(1, 2);
		},
		setOutputData: function(variableName, data) {
			prepDataForGraphing(data);
			return;
			lineChartData = data;
			drawScatterPlot();
			drawTimelineChart(1, 2);
		}
	};
}();
