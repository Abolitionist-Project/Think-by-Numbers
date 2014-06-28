<?php
// set the default timezone to use.
date_default_timezone_set("UTC");
error_reporting(E_ALL);
$start=microtime(true);

include "/mnt/quantimodo/www/scripts/database.php";	// Database function

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

function last_sync_date ($var_id,$data_owner){
		// Get the last imported date or 1970/1/1 if none
		$query="select max(start_time_utc) as _date from qm_qs_data where variable=$var_id and data_owner=$data_owner;";
		$rows=get_mysql_rows($query);
		if (empty($rows[0]['_date'])) return '1970-01-01';
		else return $rows[0]['_date'];
}


// Arguments are : Connector & User_id
if (empty($argv[2])) $data_owner=2;	// just for the test data owner id=2 means Mike google account !
else $data_owner=(int)$argv[2];
print "User_id=$data_owner\n";

$connectors = array (

	'Fitbit' => array (
		'Facet_FitbitWeight' => array(
			'queries' => array(
				array (
					'query'  => "select date as _date_field, avg(bmi), avg(fat), avg(weight) from Facet_FitbitWeight where guestId=$data_owner and date>'?' group by 1 order by 1;",
					'fields' => array( 
						'avg(bmi)' => 3548,
						'avg(fat)' => 3549,
						'avg(weight)' => 3550
					)
				),
			)
		),
		'Facet_FitbitSleep' => array(
			'queries' => array(
				array (
					'query'  => "select date as _date_field, sum(minutesAsleep) from Facet_FitbitSleep where guestId=$data_owner and date>'?' group by 1 order by 1;",
					'fields' => array( 'sum(minutesAsleep)' => 3551 )
				),
			)
		),
		'Facet_FitbitActivity' => array(
			'queries' => array(
				array (
					'query'  => "select date as _date_field, avg(activeScore), sum(caloriesOut), sum(steps), sum(totalDistance) from Facet_FitbitActivity where guestId=$data_owner and date>'?' group by 1 order by 1;",
					'fields' => array( 
						'avg(activeScore)' => 3552,
						'sum(caloriesOut)' => 3553,
						'sum(steps)' => 3554,
						'sum(totalDistance)' => 3555
					)
				),
			)
		),
	),
	
	'Google_Calendar' => array (
		'Facet_CalendarEventEntry' => array( 
			'queries' => array(
				array (
					'query'  => "select start as _date_field, start, end as _time_len from Facet_CalendarEventEntry where guestId=$data_owner and start>UNIX_TIMESTAMP('?')*1000 order by 1;",
					'fields' => array( 'start' => '3556')
				),
			)

			// 'fields' => array (
				// 'end' => '3557'
			// ),
			// 'date_field' => 'start'
		), 
	),

	'Google_Lattitude' => array (
		'Facet_GoogleLatitudeLocation' => array( 
			'queries' => array(
				array (
					'query'  => "select start as _date_field, latitude, longitude from Facet_GoogleLatitudeLocation where guestId=$data_owner and start>UNIX_TIMESTAMP('?')*1000 order by 1;",
					'fields' => array( 
						'latitude'  => '3558',
						'longitude' => '3559' 
					)
				),
			)

			// 'fields' => array (
				// 'latitude'  => '3558',
				// 'longitude' => '3559' 
			// ),
			// 'date_field' => 'start'
		), 
	),
	
	'Bodymedia' => array(
		'Facet_BodymediaSleep' => array(
			'queries' => array(
				array (
					'query'  => "select date as _date_field, sum(totalSleeping) from Facet_BodymediaSleep where guestId=$data_owner and date>'?' group by 1 order by 1;",
					'fields' => array( 'sum(totalSleeping)' => 655150)
				),
			)
		),
		'Facet_BodymediaSteps' => array(
			'queries' => array(
				array (
					'query'  => "select date as _date_field, sum(totalSteps) from Facet_BodymediaSteps where guestId=$data_owner and date>'?' group by 1 order by 1;",
					'fields' => array( 'sum(totalSteps)' => 655151)
				),
			)
		),
		'Facet_BodymediaBurn' => array(
			'queries' => array(
				array (
					'query'  => "select date as _date_field, sum(totalCalories) from Facet_BodymediaBurn where guestId=$data_owner and date>'?' group by 1 order by 1;",
					'fields' => array( 'sum(totalCalories)' => 655152)
				),
			)
		)
	),	
	
	'Lumosity' => array(
		'Facet_Lumosity' => array(
			'queries' => array(
				array (
					'query'  => "select lumosity_id as _date_field, avg(score) from Facet_Lumosity where guestId=$data_owner and type=1 and lumosity_id>UNIX_TIMESTAMP('?')*1000 group by 1 order by 1;",
					'fields' => array( 'avg(score)' => 1733708)
				),
				array (
					'query'  => "select lumosity_id as _date_field, avg(score) from Facet_Lumosity where guestId=$data_owner and type=2 and lumosity_id>UNIX_TIMESTAMP('?')*1000 group by 1 order by 1;",
					'fields' => array( 'avg(score)' => 1733709)
				),
				array (
					'query'  => "select lumosity_id as _date_field, avg(score) from Facet_Lumosity where guestId=$data_owner and type=3 and lumosity_id>UNIX_TIMESTAMP('?')*1000 group by 1 order by 1;",
					'fields' => array( 'avg(score)' => 1733710)
				),
				array (
					'query'  => "select lumosity_id as _date_field, avg(score) from Facet_Lumosity where guestId=$data_owner and type=4 and lumosity_id>UNIX_TIMESTAMP('?')*1000 group by 1 order by 1;",
					'fields' => array( 'avg(score)' => 1733711)
				),
				array (
					'query'  => "select lumosity_id as _date_field, avg(score) from Facet_Lumosity where guestId=$data_owner and type=5 and lumosity_id>UNIX_TIMESTAMP('?')*1000 group by 1 order by 1;",
					'fields' => array( 'avg(score)' => 1733712)
				),
				array (
					'query'  => "select lumosity_id as _date_field, avg(score) from Facet_Lumosity where guestId=$data_owner and type=6 and lumosity_id>UNIX_TIMESTAMP('?')*1000 group by 1 order by 1;",
					'fields' => array( 'avg(score)' => 1733713)
				)
			)
		)
		// public static final int BPI = 1;			=>	1733708
		// public static final int SPEED = 2;			=>	1733709 
		// public static final int MEMORY = 3;			=>	1733710 
		// public static final int ATTENTION = 4;		=>	1733711
		// public static final int FLEXIBILITY = 5;	=>	1733712
		// public static final int PROBLEMSOLVING = 6;	=>	1733713
	),
	
	'Moodscope' => array(
		'Facet_Moodscope' => array(
			'queries' => array(
				array (
					'query'  => "select moodscope_id as _date_field, avg(score) from Facet_Moodscope where guestId=$data_owner and type=7 and moodscope_id>UNIX_TIMESTAMP('?')*1000 group by 1 order by 1;",
					'fields' => array( 'avg(score)' => 1733718)
				)
			)
		)
	),
	
	'myFitnessPal' => array (
		'Facet_MyFitnessPal' => array( 
			'queries' => array(
				array (
					'query'  => "select start as _date_field, caloriesBurned,calories,calcium,iron,vitaminA,vitaminC,carbs,fat,fiber,protein,monounsaturatedFat,polyunsaturatedFat,saturatedFat,sugar,transFat,cholesterol,potassium,sodium,exerciseMins,weight from Facet_MyFitnessPal where guestId=$data_owner and start>UNIX_TIMESTAMP('?')*1000 order by 1;",
					'fields' => array( 
						'caloriesBurned'  => '1733733',
						'calories' => '1733734', 
						'calcium' => '1733735', 
						'iron' => '1733736', 
						'vitaminA' => '1733737', 
						'vitaminC' => '1733738', 
						'carbs' => '1733739', 
						'fat' => '1733740', 
						'fiber' => '1733741', 
						'protein' => '1733742', 
						'monounsaturatedFat' => '1733743', 
						'polyunsaturatedFat' => '1733744', 
						'saturatedFat' => '1733745', 
						'sugar' => '1733746', 
						'transFat' => '1733747', 
						'cholesterol' => '1733748', 
						'potassium' => '1733749', 
						'sodium' => '1733750', 
						'exerciseMins' => '1733751', 
						'weight' => '1733752' 
					)
				)
			)
		)
	),
	
	'Withings' => array (
		'Facet_WithingsBpmMeasure' => array( 
			'queries' => array(
				array (
					'query'  => "select start as _date_field, heartPulse,diastolic,systolic from Facet_WithingsBpmMeasure where guestId=$data_owner and start>UNIX_TIMESTAMP('?')*1000 order by 1;",
					'fields' => array( 
						'heartPulse' 	=> '1733755', 
						'diastolic' 	=> '1733756', 
						'systolic' 		=> '1733757' 
					)
				)
			)
		),
		'Facet_WithingsBodyScaleMeasure' => array( 
			'queries' => array(
				array (
					'query'  => "select measureTime as _date_field, fatFreeMass,fatMassWeight,fatRatio,height,weight from Facet_WithingsBodyScaleMeasure where guestId=$data_owner and measureTime>UNIX_TIMESTAMP('?')*1000 order by 1;",
					'fields' => array( 
						'fatFreeMass' 	=> '1733762', 
						'fatMassWeight' => '1733763', 
						'fatRatio' 		=> '1733764',
						'height' 		=> '1733765',
						'weight' 		=> '1733766' 
					)
				)
			)
		)
	),

	'Github' => array (
		'Facet_GithubPush' => array( 
			'queries' => array(
				array (
					'query'  => "select start as _date_field, 1 from Facet_GithubPush where guestId=$data_owner and start>UNIX_TIMESTAMP('?')*1000 order by 1;",
					'fields' => array( 
						'1' 	=> '1733770', 
					)
				)
			)
		)
	),

	
);

foreach ($connectors as $connector=>$conn_value) {
	// if ($connector == 'Google_Calendar' || $connector == '' ) continue;
	print "\nConnector: $connector\n";
	foreach ($conn_value as $table=>$table_data){
		print "\n\tTable: $table\n";
		foreach ($table_data['queries'] as $query_data) {
				// print_r($query_data['fields'][key($query_data['fields'])]);exit;
				$var_id=$query_data['fields'][key($query_data['fields'])];
				$start_date=last_sync_date($var_id,$data_owner);
				$query=str_replace('?',$start_date,$query_data['query']);
				// print "\tQuery: $query => Fields & vars: ".print_r($query_data['fields'],true);
				print "Last sync date => $start_date\n";
				if (empty($query_data['fields']['_time_len'])) $query_ins="insert into qm_qs_data (data_owner, variable, value, start_time_utc) values ";
				else $query_ins="insert into qm_qs_data (data_owner, variable, value, start_time_utc,duration_in_seconds ) values ";

				$rows=get_mysql_rows($query);
				if (count($rows)>0) {
					print "Rows received => ".count($rows)."\n"; 
					// print "First record dump: ".print_r($rows[0],true)."\n";
					// print "INS Query: $query_ins\n";
					foreach ($rows as $row) { 
						if (ctype_digit($row['_date_field'])) // convert the timestamp to string
							$row['_date_field'] = date('Y-m-d H:i:s',(int)$row['_date_field']>1577858400?(int)($row['_date_field']/1000):$row['_date_field']); // if timestamp is bigger than 2020 assume microtime and remove the miliseconds
						$query_data_str='';		// Initialize the data string
						foreach ($query_data['fields'] as $field=>$var) 
						//foreach ($table_fields['fields'] as $field=>$var) 
							if (!empty($row['_time_len'])) //	We have duration_in_seconds defined for this var, so add to the data!
								$query_data_str .= "($data_owner,$var,".$row[$field].",'".$row['_date_field']."',".(int)$row['_time_len']."),\n";
							else 
								$query_data_str .= "($data_owner,$var,".$row[$field].",'".$row['_date_field']."'),\n";
						
						$query_data_str[strlen($query_data_str)-2] = " ";
						$query_data_str = $query_data_str.' ON DUPLICATE KEY UPDATE value=VALUES(value);';
						// print "$query_ins\n$query_data_str\n String length => ".strlen($query_data_str)."\n"; // debug print
						// Finally execute the insert statement
						insert_data_mysql($query_ins.$query_data_str);
					}
				} else print "No new records to be imported!\n\n";
			}
	}
}
	
footer();	
exit;
?>