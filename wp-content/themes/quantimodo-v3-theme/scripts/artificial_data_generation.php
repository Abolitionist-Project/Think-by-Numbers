<?php
date_default_timezone_set("UTC");
error_reporting(E_ALL);
$start=microtime(true);

// Arguments are : Connector & User_id
if (empty($argv[2])) $data_owner=7;	// just for the test data owner id=7 means Tony !
else $data_owner=(int)$argv[2];
$start_date='2013-02-27'; $end_date='2013-04-27'; 
$data_type='GoodDayJournal';
print "Data type => $data_type, User_id=$data_owner, Start date => $start_date, End date => $end_date\n";


function memory_usage() { 
    $mem_usage = memory_get_usage(true); 
    if ($mem_usage < 1024) return $mem_usage." bytes"; 
	elseif ($mem_usage < 1048576) return round($mem_usage/1024,2)."k"; 
	else return round($mem_usage/1048576,2)."MB"; 
} 
function footer(){
	global $start;
	print "\n\nTimestamp: ".date('Y-m-d H:i:s').", Script: ".basename($_SERVER['PHP_SELF']).", Time used: ".(microtime(true)-$start)." sec. , Memory used: ".memory_usage()."\n"; 
}

include "/mnt/quantimodo/www/scripts/database.php";	// Database function

$connectors = array (

	// 'Fitbit' => array (
		// 'Facet_FitbitWeight' => array(
			// 'fields' => array (
				// 'bmi' => array ( 'var'=>'3548','low'=>10,'high'=>50),
				// 'fat' => array ( 'var'=>'3549','low'=>15,'high'=>35),
				// 'weight' => array ( 'var'=>'3550','low'=>50,'high'=>100)
			// ),
		// ),
		// 'Facet_FitbitSleep' => array(
			// 'fields' => array (
				// 'minutesAsleep' => array ( 'var'=>'3551','low'=>200,'high'=>500)
			// ),
		// ),
		// 'Facet_FitbitActivity' => array(
			// 'fields' => array (
				// 'activeScore' => array ( 'var'=>'3552','low'=>10,'high'=>50), 
				// 'caloriesOut' => array ( 'var'=>'3553','low'=>100,'high'=>500),
				// 'steps' => array ( 'var'=>'3554','low'=>100,'high'=>10000),
				// 'totalDistance' => array ( 'var'=>'3555','low'=>1,'high'=>10)
			// ),
		// ),
	// ),
	
	'GoodDayJournal' => array (
			'mood' => array ( 'var'=>'1135','low'=>3,'high'=>4),
	),
);


foreach ($connectors[$data_type] as $var=>$param){
	// Generate the vars
	print "\nVariable: $var => (QM var) {$param['var']}, low=>{$param['low']}, high=>{$param['high']}, example=>".rand($param['low'],$param['high'])."\n";
	$current=$start_date;
	$query_ins="insert into qm_qs_data (data_owner, variable, value, start_time_utc) values\n";
	$query_data='';		// Initialize the data string

	while (strtotime($current)<=strtotime($end_date)) {
		// print "$current => ".rand($param['low'],$param['high'])."\n";
		$query_data .= "($data_owner,{$param['var']},".rand($param['low'],$param['high']).",'$current'),\n";

		// print "Time => ".time()." Current $current =>".strtotime($current).", End_date=>".strtotime($end_date)."\n";
		$current = date('Y-m-d',strtotime($current)+24*3600);
		// print "Time => ".time()." Current $current =>".strtotime($current).", End_date=>".strtotime($end_date)."\n";
		// exit;
	} 
	$query_data[strlen($query_data)-2] = " ";
	$query_data = $query_data.'ON DUPLICATE KEY UPDATE value=VALUES(value);';
	// print $query_ins.$query_data;
	print "Just inserted ".insert_data_mysql($query_ins.$query_data)." rows\n";
}

footer();
?>