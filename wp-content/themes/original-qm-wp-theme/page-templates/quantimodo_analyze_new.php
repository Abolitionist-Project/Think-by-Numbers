<?php
/**
 *	Template Name: New Analyze Template
 *	Description: Page based on original PHP website
 */
	get_header();
	
	wp_enqueue_style("analyze", get_template_directory_uri()."/css/analyze_style.css");
	wp_enqueue_style("jquery-ui-flick", get_template_directory_uri()."/css/jquery-ui-flick.css");

	wp_enqueue_script("jquery");
	wp_enqueue_script("jquery-ui-core");
	wp_enqueue_script("jquery-ui-datepicker");
	wp_enqueue_script("jquery-ui-button");
	wp_enqueue_script("highcharts", get_template_directory_uri()."/js/libs/highcharts.js", "jquery");
	wp_enqueue_script("qm-sdk", get_template_directory_uri()."/js/quantimodo-api.js", "jquery");
	wp_enqueue_script("analyze-charts", get_template_directory_uri()."/js/analyze_charts.js", array("highcharts", "qm-sdk"));
	wp_enqueue_script("analyze", get_template_directory_uri()."/js/analyze.js", array("analyze-charts", "jquery-ui-datepicker", "jquery-ui-button"));
?>

<section id="section-configure">
	<div class="accordion-header" id="accordion-date-header">
		Date Range
	</div>
	<div class="accordion-content" id="accordion-date-content">
		<div id="accordion-content-datepickers">
			<input type="text" id="datepicker-start" />
			<input type="text" id="datepicker-end" />
		</div>
		<div id="accordion-content-rangepickers">
			<input type="radio" value="daily" id="radio1" name="radio" /><label for="radio1">Daily</label>
			<input type="radio" value="weekly" id="radio2" name="radio" checked="checked" /><label for="radio2">Weekly</label>
			<input type="radio" value="monthly" id="radio3" name="radio" /><label for="radio3">Monthly</label>
		  </div>
	</div>
	
	<div class="accordion-header" id="accordion-input-header">
		Select Input Behavior
	</div>
	<div class="accordion-content" id="accordion-input-content">
		Category<br>
		<select id="selectInputCategory">
			<option value="1">Medications</option>
			<option value="2">Activities</option>
		</select>
		
		<br>Variable<br>
		<select id="selectInputVariable">
			<option value="1">A variable</option>
			<option value="2">Other variable</option>
			<option value="3">More variables</option>
			<option value="4">Go here</option>
		</select>
	</div>
	
	<div class="accordion-header" id="accordion-output-header">
		Select Output State
	</div>
	<div class="accordion-content" id="accordion-output-content">
		Category<br>
		<select id="selectOutputCategory">
			<option value="1">Medications</option>
			<option value="2">Activities</option>
		</select>
		
		<br>Variable<br>
		<select id="selectOutputVariable">
			<option value = "1">A variable</option>
			<option value = "2">Other variable</option>
			<option value = "3">More variables</option>
			<option value = "4">Go here</option>
		</select>
	</div>		
</section>

<section id="section-analyze" style="padding: 1% 1% 1% 1%;">
		<div style="width: 100%;">
			<div class="graph-header">
				Correlation Scatterplot
			</div>
			<div class="graph-content">
				<div style="width: 100%; height: 300px;" id="graph-scatterplot">
				</div>
			</div>
		</div>		
	
		<div style="width: 100; padding-top: 1%;">
			<div class="graph-header">
				Timeline
			</div>
			<div class="graph-content">
				<div style="width: 100%; height: 300px;" id="graph-timeline">
				</div>
			</div>
		</div>
</section>

<?php
 get_footer();
?>
