AnalyzePage = function() {
	/* Initialize left menubar */
	var initAccordion = function() {
		jQuery('#accordion-date-header').click(function() { jQuery('#accordion-date-content').slideToggle("medium"); });
		jQuery('#accordion-input-header').click(function() { jQuery('#accordion-input-content').slideToggle("medium"); });
		jQuery('#accordion-output-header').click(function() { jQuery('#accordion-output-content').slideToggle("medium"); });
		
		setTimeout(function() { jQuery('#accordion-date-content').slideDown(300); }, 500);
		setTimeout(function() {	jQuery('#accordion-input-content').slideDown(500); }, 750);
		setTimeout(function() {	jQuery('#accordion-output-content').slideDown(700); }, 1000);
	};
	
	var dateRangeStart;
	var dateRangeEnd;
	/* Initialize date range selectors */
	var initDateRangeSelector = function() {
		dateRangeEnd = new Date();    // Date for the "To" textbox
		dateRangeStart = new Date();  // Date for the "From" textbox
		var fromMaxDate = new Date();
		fromMaxDate.setDate(dateRangeEnd.getDate() - 1); // Max date for the "From" datepicker, which is one day before today
		
		dateRangeStart.setDate(dateRangeStart.getDate() - 7);
		jQuery("#datepicker-start").val(jQuery.datepicker.formatDate("'From' MM d',' yy", dateRangeStart));
		jQuery("#datepicker-start").datepicker({
			dateFormat: "'From' MM d',' yy",
			defaultDate: dateRangeStart,
			maxDate: fromMaxDate,
			changeMonth: true,
			changeYear: true,
			beforeShow: function(textbox, instance) {   
				// Set the calendar right below the textbox
				instance.dpDiv.css({
					marginTop: '61px',
					marginLeft:  '-1px'
				});
			},
			onSelect: function(dateText, inst) {
				dateRangeStart = jQuery("#datepicker-start").datepicker("getDate");
	
				// If the start date is equal or greater than enddate, decrease it
				if(dateRangeStart >= dateRangeEnd) {
					dateRangeEnd.setDate(dateRangeStart.getDate() + 1);
					jQuery("#datepicker-end").val(jQuery.datepicker.formatDate("'To' MM d',' yy", dateRangeEnd));
					jQuery("#datepicker-end").datepicker( "option", "defaultDate", dateRangeStart);
					bothDatesUpdated();
				}
				else {
					startDateUpdated();
				}
			}
		});
		
		jQuery("#datepicker-end").val(jQuery.datepicker.formatDate("'To' MM d',' yy", dateRangeEnd));
		jQuery("#datepicker-end").datepicker({
			dateFormat: "'To' MM d',' yy",
			defaultDate: dateRangeEnd,
			maxDate: dateRangeEnd,
			changeMonth: true,
			changeYear: true,
			beforeShow: function(textbox, instance) {   
				instance.dpDiv.css(
				{
					marginTop: '112px',
					marginLeft:  '-1px'
				});
			},
			onSelect: function(dateText, inst) {
				dateRangeEnd = jQuery("#datepicker-end").datepicker("getDate");
				
				// If the start date is equal or greater than enddate, decrease it
				if(dateRangeStart >= dateRangeEnd) {
					dateRangeStart.setDate(dateRangeEnd.getDate() - 1);
					jQuery("#datepicker-start").val(jQuery.datepicker.formatDate("'From' MM d',' yy", dateRangeStart));
					jQuery("#datepicker-start").datepicker( "option", "defaultDate", dateRangeStart);
					bothDatesUpdated();
				}
				else {
					endDateUpdated();
				}
			}
		});
		
		jQuery("#accordion-content-rangepickers").buttonset();
		jQuery("#accordion-content-rangepickers .ui-button").each(function() { jQuery(this).css({ width: '86px' }); });
		
		// Clicking on a predefined sets the startdate to the enddate minus the specified range
		jQuery("#accordion-content-rangepickers :radio").click(function(e) {
			var value = jQuery(this).attr("value");
			if (value == "daily") {
				dateRangeStart.setYear(dateRangeEnd.getYear() + 1900);
				dateRangeStart.setMonth(dateRangeEnd.getMonth());
				dateRangeStart.setDate(dateRangeEnd.getDate() - 1);
			}
			else if (value == "weekly") {
				dateRangeStart.setYear(dateRangeEnd.getYear() + 1900);
				dateRangeStart.setMonth(dateRangeEnd.getMonth());
				dateRangeStart.setDate(dateRangeEnd.getDate() - 7);
			}
			else if (value == "monthly") {
				dateRangeStart.setYear(dateRangeEnd.getYear() + 1900);
				dateRangeStart.setMonth(dateRangeEnd.getMonth() - 1);
				dateRangeStart.setDate(dateRangeEnd.getDate());
			}
			jQuery("#datepicker-start").val(jQuery.datepicker.formatDate("'From' MM d',' yy", dateRangeStart));
			jQuery("#datepicker-start").datepicker( "option", "defaultDate", dateRangeStart);
			
			startDateUpdated();
		});
	};
	
	var quantimodoVariables = {};
	
	var initVariableSelectors = function() {
		refreshVariables();
		jQuery('#selectInputCategory').click(inputCategoryUpdated);
		jQuery('#selectOutputCategory').click(outputCategoryUpdated);
		jQuery('#selectInputVariable').click(inputVariableUpdated);
		jQuery('#selectOutputVariable').click(outputVariableUpdated);
	};
	
	var refreshVariables = function(variables) {
		Quantimodo.getVariables({}, function(variables) {
			jQuery.each(variables, function(_, variable) {
				if (quantimodoVariables[variable.category] === undefined) {
					quantimodoVariables[variable.category] = [];
				}
				quantimodoVariables[variable.category].push(variable.name);
			});
			jQuery.each(Object.keys(quantimodoVariables), function(_, category) {
				quantimodoVariables[category] = quantimodoVariables[category].sort();
			});
			
			categoryListUpdated();
			inputCategoryUpdated();
			outputCategoryUpdated();
		});
	};
	
	var refreshInputData = function() {
		var variableName = AnalyzePage.getInputVariable();
		Quantimodo.getMeasurements({
			'variableName': variableName,
			'startTime': AnalyzePage.getStartTime(),
			'endTime': AnalyzePage.getEndTime()
		}, function(measurements) { AnalyzeChart.setInputData(variableName, measurements); });
	};
	
	var refreshOutputData = function() {
		var variableName = AnalyzePage.getOutputVariable();
		Quantimodo.getMeasurements({
			'variableName': variableName,
			'startTime': AnalyzePage.getStartTime(),
			'endTime': AnalyzePage.getEndTime()
		}, function(measurements) { AnalyzeChart.setOutputData(variableName, measurements); });
	};
	
	var lastStartTime = null;
	var startDateUpdated = function() {
		var newStartTime = AnalyzePage.getStartTime();
		if (newStartTime !== lastStartTime) {
			refreshInputData();
			refreshOutputData();
			lastStartTime = newStartTime;
		}
	};
	
	var lastEndTime = null;
	var endDateUpdated = function() {
		var newEndTime = AnalyzePage.getEndTime();
		if (newEndTime !== lastEndTime) {
			refreshInputData();
			refreshOutputData();
			lastEndTime = newEndTime;
		}
	};
	
	var bothDatesUpdated = function() {
		var newStartTime = AnalyzePage.getStartTime();
		var newEndTime = AnalyzePage.getEndTime();
		if ((newStartTime !== lastStartTime) || (newEndTime !== lastEndTime)) {
			refreshInputData();
			refreshOutputData();
			lastStartTime = newStartTime;
			lastEndTime = newEndTime;
		}
	};
	
	var categoryListUpdated = function() {
		jQuery('#selectInputCategory').empty();
		jQuery('#selectOutputCategory').empty();
		jQuery.each(Object.keys(quantimodoVariables).sort(), function(_, category) {
			jQuery('#selectInputCategory').append(jQuery('<option/>').attr('value', category).text(category));
			jQuery('#selectOutputCategory').append(jQuery('<option/>').attr('value', category).text(category));
		});
	};
	
	var lastInputCategory = null;
	var inputCategoryUpdated = function() {
		var newInputCategory = AnalyzePage.getInputCategory();
		if (newInputCategory !== lastInputCategory) {
			jQuery('#selectInputVariable').empty();
			jQuery.each(quantimodoVariables[newInputCategory], function(_, variable) {
				jQuery('#selectInputVariable').append(jQuery('<option/>').attr('value', variable).text(variable));
			});
			lastInputCategory = newInputCategory;
			inputVariableUpdated();
		}
	};
	
	var lastInputVariable = null;
	var inputVariableUpdated = function() {
		var newInputVariable = AnalyzePage.getInputVariable();
		if (newInputVariable !== lastInputVariable) {
			refreshInputData();
			lastInputVariable = newInputVariable;
		}
	};
	
	var lastOutputCategory = null;
	var outputCategoryUpdated = function() {
		var newOutputCategory = AnalyzePage.getOutputCategory();
		if (newOutputCategory !== lastOutputCategory) {
			jQuery('#selectOutputVariable').empty();
			jQuery.each(quantimodoVariables[newOutputCategory], function(_, variable) {
				jQuery('#selectOutputVariable').append(jQuery('<option/>').attr('value', variable).text(variable));
			});
			lastOutputCategory = newOutputCategory;
			outputVariableUpdated();
		}
	};
	
	var lastOutputVariable = null;
	var outputVariableUpdated = function() {
		var newOutputVariable = AnalyzePage.getOutputVariable();
		if (newOutputVariable !== lastOutputVariable) {
			refreshOutputData();
			lastOutputVariable = newOutputVariable;
		}
	};
	
	return {
		getStartTime:      function() { return Math.floor(dateRangeStart.getTime() / 1000); },
		getEndTime:        function() { return Math.floor(dateRangeEnd.getTime() / 1000); },
		getInputCategory:  function() { return jQuery('#selectInputCategory :selected').text(); },
		getOutputCategory: function() { return jQuery('#selectOutputCategory :selected').text(); },
		getInputVariable:  function() { return jQuery('#selectInputVariable :selected').text(); },
		getOutputVariable: function() { return jQuery('#selectOutputVariable :selected').text(); },
		
		init: function() {
			initAccordion();
			initDateRangeSelector();
			initVariableSelectors();
		}
	};
}();

jQuery(AnalyzePage.init);
