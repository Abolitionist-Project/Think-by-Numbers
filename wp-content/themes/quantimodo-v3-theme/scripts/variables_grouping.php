<?php 

function date_grouping($date,$grouping_option){
	switch ($grouping_option) {
		case "Yearly":		return date('Y-01',strtotime($date));
			break;
		case "Monthly":		return date('Y-m',strtotime($date));
			break;
		case "Weekly":		
			list($year,$day,$week)=explode('-',date('Y-d-W',strtotime($date)));
			if ($week==01 and $day>24) return ($year+1)."-Week-01";		// End of the year correction
			elseif ($week>51 and $day<7) return ($year-1)."-Week-$week";		// End of the year correction
			else return "$year-Week-$week";
			break;
		case "Daily":		return date('Y-m-d',strtotime($date));
			break;
		case "Hourly":		return date('Y-m-d H:00:00',strtotime($date));
			break;
		case "Minutely":	return date('Y-m-d H:i:00',strtotime($date));
			break;
		default: 	return "Invalid grouping option: $grouping_option";
	}
}
// date_grouping Tests
// print date_grouping("2013-1-1 1:1:1","Yearly")."\n";
// print date_grouping("2014-1-1 1:1:1","Yearly")."\n";
// print date_grouping("2015-1-1 1:1:1","Yearly")."\n";
// print date_grouping("2015-2-1 1:1:1","Monthly")."\n";
// print date_grouping("2015-3-1 1:1:1","Monthly")."\n";
// print date_grouping("2015-4-1 1:1:1","Monthly")."\n";
// print date_grouping("2015-4-2 1:1:1","Daily")."\n";
// print date_grouping("2015-4-3 1:1:1","Daily")."\n";
// print date_grouping("2015-4-4 1:1:1","Daily")."\n";
// print date_grouping("2015-4-4 4:1:1","Hourly")."\n";
// print date_grouping("2015-4-4 5:1:1","Hourly")."\n";
// print date_grouping("2015-4-4 23:1:1","Hourly")."\n";
// print date_grouping("2012-1-1","Weekly")."\n";
// print date_grouping("2012-01-02","Weekly")."\n";
// print date_grouping("2012-12-31 00:00:00","Weekly")."\n";
// print date_grouping("2012-6-31 00:00:00","Weekly")."\n";


function sum_and_group($arr,$grouping_option) {
	$result=array();
	foreach ($arr as $row) {
		$date=date_grouping($row['start_time_utc'],$grouping_option);
		if (empty($result[$date])) $result[$date]=0;
		$result[$date] += $row['value'];
	}
	return $result;
}

function avg_and_group($arr,$grouping_option) {
	$res=array();
	foreach ($arr as $row) {
		$date=date_grouping($row['start_time_utc'],$grouping_option);
		$res[$date][] = $row['value'];
	}
	$result=array();
	foreach ($res as $key=>$value) $result[$key] = array_sum($value) / count($value);
	return $result;
}

// $test = array (
	// array ('start_time_utc'=>'2013-1-1 1:1:1', 'value'=>1),
	// array ('start_time_utc'=>'2013-1-1 2:1:1', 'value'=>2),
	// array ('start_time_utc'=>'2013-1-2 1:1:1', 'value'=>3),
	// array ('start_time_utc'=>'2013-2-1 1:1:1', 'value'=>4),
// );

// print_r(sum_and_group($test,'Monthly'));
// print_r(avg_and_group($test,'Monthly'));


// This is for the gauge in the correlation scatterplot:
// .8 to 1.0   or  -.8 to -1.0 (very strong relationship)
// .6 to .8 (strong relationship)
// .4 to .6 (moderate relationship)
// .2 to .4 (weak relationship)
// .0 to .2 (weak or no relationship

// zerocheck
function zerocheck($p) { return $p['value'] != 0; }

// Combine the X & Y vars
function array_key_intersect(&$x, &$y) {
	$result= array();
	foreach ($x as $key=>$value1)
		if (array_key_exists ($key , $y))
			$result[] = array ($key,$value1,$y[$key]);
	return $result;
 }

?>