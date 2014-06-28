// Quantimodo.com API. Requires JQuery.
Quantimodo = function() {
	var GET = function (baseURL, allowedParams, params, successHandler) {
		var urlParams = [];
		for (var key in params) {
			if (jQuery.inArray(key, allowedParams) == -1) { throw 'invalid parameter; allowed parameters: ' + allowedParams.toString(); }
			urlParams.push(encodeURIComponent(key) + '=' + encodeURIComponent(params[key]));
		}
		jQuery.ajax({type: 'GET', url: ('/api/' + ((urlParams.length == 0) ? baseURL : baseURL + '?' + urlParams.join('&'))), contentType: 'application/json', success: successHandler});
	};

	var POST = function (baseURL, requiredFields, items, successHandler) {
		for (var i = 0; i < items.length; i++) {
			var item = items[i];
			for (var j = 0; j < requiredFields.length; j++) { if (!(requiredFields[j] in item)) { throw 'missing required field in POST data; required fields: ' + requiredFields.toString(); } }
		}
		jQuery.ajax({type: 'POST', url: '/api/' + baseURL, contentType: 'application/json', data: JSON.stringify(items), dataType: 'json', success: successHandler});
	};

	return {
		getMeasurements: function(params, f) { GET('measurements', ['variableName', 'startTime', 'endTime'], params, f); },
		postMeasurements: function(measurements, f) { POST('measurements', ['source', 'variable', 'combination-operation', 'timestamp', 'value', 'unit'], measurements, f); },
		
		getMeasurementSources: function(params, f) { GET('measurement-sources', [], params, f); },
		postMeasurementSources: function(measurements, f) { POST('measurement-sources', ['name'], measurements, f); },
		
		getUnits: function(params, f) { GET('units', ['unitName', 'abbreviatedUnitName', 'categoryName'], params, f); },
		postUnits: function(measurements, f) { POST('units', ['name', 'abbreviated-name', 'category', 'conversion-steps'], measurements, f); },
		
		getUnitCategories: function(params, f) { GET('unit-categories', [], params, f); },
		postUnitCategories: function(measurements, f) { POST('unit-categories', ['name'], measurements, f); },
		
		getVariables: function(params, f) { GET('variables', ['categoryName'], params, f); },
		postVariables: function(measurements, f) { POST('variables', ['name', 'category', 'unit', 'combination-operation'], measurements, f); },
		
		getVariableCategories: function(params, f) { GET('variable-categories', [], params, f); },
		postVariableCategories: function(measurements, f) { POST('variable-categories', ['name'], measurements, f); },
		
		getVariableUserSettings: function(params, f) { GET('variable-user-settings', ['variableName'], params, f); },
		postVariableUserSettings: function(measurements, f) { POST('variable-user-settings', ['variable', 'unit'], measurements, f); }
	};
}();

