<head>
	
	<script src="../js/table.js" ></script>	
	<link rel="stylesheet" type="text/css" media="screen" href="../css/table/table.css" />
	
	<style>
		pre {font-family:verdana; font-size:12;}
		body {font-family:verdana; font-size:12;}
		button {padding:0; margin:0;}
		form {padding:0; margin:0;}
	</style>
</head>
<body>
	<h2>Quantimodo Laboratory - development section</h2>
<?php
error_reporting(E_ALL);
$start=microtime(true);

function footer(){
	global $start;
	print "<div style='clear:both;'><footer><br><br><hr>Timestamp: ".date('Y-m-d H:i:s').", Script: ".basename($_SERVER['PHP_SELF']).", Time used: ".(microtime(true)-$start)." sec. , Memory used: ".memory_usage()."</footer></div>"; 
}

// Log in Crome console if you need to debug
function console_log($var,$title=null){
    print "<script>\n";
    if ($title!=null) print "console.log('$title');\n";
    $output    =    explode("\n", print_r($var, true)); 
    foreach ($output as $line) print "console.log('$line');\n";
    print "</script>\n";
}


// error handler function
function myErrorHandler($errno, $errstr, $errfile, $errline)
{
    if (!(error_reporting() & $errno)) {
        // This error code is not included in error_reporting
        return;
    }

    switch ($errno) {
    case E_USER_ERROR:
        echo "<b>My ERROR</b> [$errno] $errstr<br />\n";
        echo "  Fatal error on line $errline in file $errfile";
        echo ", PHP " . PHP_VERSION . " (" . PHP_OS . ")<br />\n";
        echo "Aborting...<br />\n";
        exit(1);
        break;

    case E_USER_WARNING:
        echo "<b>My WARNING</b> [$errno] $errstr<br />\n";
        break;

    case E_USER_NOTICE:
        echo "<b>My NOTICE</b> [$errno] $errstr<br />\n";
        break;

    default:
        echo "Unknown error type: [$errno] $errstr<br />\n";
        break;
    }

    /* Don't execute PHP internal error handler */
    return true;
}

function memory_usage() { 
    $mem_usage = memory_get_usage(true); 
    if ($mem_usage < 1024) return $mem_usage." bytes"; 
	elseif ($mem_usage < 1048576) return round($mem_usage/1024,2)."k"; 
	else return round($mem_usage/1048576,2)."MB"; 
} 

function cleanall() {
    foreach ($_POST as $key => $val) {
        $_POST[$key] = stripslashes(strip_tags(htmlspecialchars($val, ENT_QUOTES)));
        $$key = stripslashes(strip_tags(htmlspecialchars($val, ENT_QUOTES)));
    }
    foreach ($_GET as $key => $val) {
        $_GET[$key] = stripslashes(strip_tags(htmlspecialchars($val, ENT_QUOTES)));
        $$key = stripslashes(strip_tags(htmlspecialchars($val, ENT_QUOTES)));
    }
}

function array_to_table($arr,$head_row='',$caption='',$rows_num=100){ 
	print "<table class='example table-autosort table-autofilter table-stripeclass:alternate table-autostripe table-rowshade-alternate' border='3' style='font-family:verdana;font-size:12;'><caption><b>$caption</b></caption>";
	
	// print table header rows
	$ths=explode(",",$head_row);
	// print_r($ths); 
	print "<thead><tr>";
	foreach ($ths as $th) print "<th class='table-filterable table-sortable:numeric table-sortable' style='text-align: center;'>".$th."</th>";
	print "</tr></thead>";
	$i=1;
	// print table data rows
	foreach ($arr as $row) {
		print "<tr>"; //<td>$i</td>";
		foreach ($row as $field) print "<td style='text-align: center;'>".$field."</td>";
		print "</tr>";
		$i++;
		if ($i>$rows_num) {
			print "</table><strong>Skipping the rest ".(count($arr)-$rows_num)." table rows!</strong>";
			break;
		}
	}
	if ($i<=$rows_num) print"</table>";
}

function array_to_table_keys($arr,$head_row='',$caption='',$rows_num=50){
	print "<table border='3' style='font-family:verdana;font-size:12;'><caption><b>$caption</b></caption>";
	
	// print table header rows
	$ths=explode(",",$head_row);
	// print_r($ths); 
	print "<tr><th>No.</th>";
	foreach ($ths as $th) print "<th style='text-align: center;'>".$th."</th>";
	print "</tr>";
	$i=1;
	// print table data rows
	foreach ($arr as $key=>$value) {
		print "<tr><td>$i</td>";
		print "<td style='text-align: center;'>".$key."</td><td style='text-align: center;'>".$value."</td>";
		print "</tr>";
		$i++;
		if ($i>$rows_num) {
			print "<tr><td style='text-align: center;' colspan='100'><strong>Skipping the rest ".(count($arr)-$rows_num)." rows!</strong></td></tr>";
			break;
		}
	}
	print"</table>";
}

function get_mysql_rows($query,$host="localhost") {
    $rows=array();
    $mylink = mysql_connect($host, "quantimodo", "PDNZCF7bv7CDX5D6") or die("Could not connect to server!\n");
    mysql_select_db("quantimodo", $mylink) or die("Could not select database");
	// $query=mysql_real_escape_string($query,$mylink);
	$result = mysql_query($query,$mylink) or print "Query failed:`$query` =>". mysql_error()."\n";
    if (is_bool($result)) {
        mysql_close($mylink);
        return $result;
    }
    while ($row=mysql_fetch_assoc($result)) $rows[]=$row;
    mysql_free_result($result);
    mysql_close($mylink);
    return $rows;
}

// set_error_handler("myErrorHandler");

$qrys = array (
	'general_info' => 'SELECT qm_variable_categories.name, qm_applications.name as App_name, IFNULL(qm_variables.name,"--") as Var_name,
					count(qm_qs_data.id) as Values_count, qm_variables.data_owner,qm_variables.id as Var_id
					from qm_applications
					left join qm_variables on (qm_applications.id=qm_variables.source_application)
					left join qm_qs_data on (qm_qs_data.variable=qm_variables.id)
					join qm_variable_categories on (qm_variable_categories.id=qm_variables.variable_category)
					group by 1,2,3,5,6 order by 1;',
					
	'get_input_vars'	=> 'SELECT qm_variable_categories.name as Var_category, qm_applications.name as App_name, qm_variables.name as Var_name, qm_variables.id as Var_id
					from qm_applications
					join qm_variables on (qm_applications.id=qm_variables.source_application)
					join qm_variable_categories on (qm_variable_categories.id=qm_variables.variable_category)
					where qm_variables.input_variable<>0 and qm_variables.data_owner in (0,2)
					order by 1,2,3;',
	
	'get_output_vars'	=> 'SELECT qm_variable_categories.name as Var_category, qm_applications.name as App_name, qm_variables.name as Var_name, qm_variables.id as Var_id
					from qm_applications
					join qm_variables on (qm_applications.id=qm_variables.source_application)
					join qm_variable_categories on (qm_variable_categories.id=qm_variables.variable_category)
					where qm_variables.input_variable<>1 and qm_variables.data_owner in (0,2)
					order by 1,2,3;',
					
	'get_measurements'	=> 'select start_time_utc, value from qm_qs_data where data_owner=2 and variable in (?) order by start_time_utc LIMIT 40000;',

	'get_measurements_union' => 'select start_time_utc, value*?:1 as value from qm_qs_data
					where qm_qs_data.data_owner=2 and variable=?:2',
	
	'var_info'	=> 'select qm_variable_categories.name as Category,qm_applications.name as App_name, qm_variables.name as Var_name, qm_units.name as Unit_name, qm_units.use_average as  summable_variable, keep_zeroes, qm_variables.id from qm_variables
						join qm_applications on (qm_variables.source_application=qm_applications.id)
						join qm_units on (qm_units.id=qm_variables.unit_used)
						join qm_variable_categories on (qm_variable_categories.id=qm_variables.variable_category)
						where qm_variables.id=?;',
						
	'var_groups' => 'select qm_variable_groups.name as grp_name, qm_variable_categories.name as Cat_name, qm_applications.name as App_name, qm_variables.name as Var_name, qm_units.name as Unit_name, qu.name as Grp_unit_name,  qm_variables.input_variable, qm_units.use_average as summable_variable, keep_zeroes, qm_variables.id
					from qm_variable_groups 
						join qm_variable_groupings on (qm_variable_groupings.group_id=qm_variable_groups.id)
						join qm_variables on (qm_variables.id=qm_variable_groupings.variable_id)
						join qm_applications on (qm_applications.id=qm_variables.source_application)
						join qm_units on (qm_units.id=qm_variables.unit_used)
						join qm_units qu on (qu.id=qm_variable_groups.unit_id)
						join qm_variable_categories on (qm_variable_categories.id=qm_variables.variable_category)
						order by 1;',

	'grp_info' => 'select qm_variable_groups.name as Var_name, qm_variable_groups.unit_id as grp_unit, qm_units.si_units_per_this_unit as Var_units_per , qu.si_units_per_this_unit as Grp_units_per, qu.name Unit_name , qm_variable_categories.name as Cat_name, qm_applications.name as App_name,  qm_variables.name as member_var_name, qm_units.name as Var_unit_name, qm_variables.input_variable, qm_units.use_average as summable_variable, keep_zeroes, qm_variables.id, qm_variable_groups.id grp_id
					  from qm_variable_groups 
						join qm_variable_groupings on (qm_variable_groupings.group_id=qm_variable_groups.id)
						join qm_variables on (qm_variables.id=qm_variable_groupings.variable_id)
						join qm_applications on (qm_applications.id=qm_variables.source_application)
						join qm_units on (qm_units.id=qm_variables.unit_used)
						join qm_units qu on (qu.id=qm_variable_groups.unit_id)
						join qm_variable_categories on (qm_variable_categories.id=qm_variables.variable_category)
						where qm_variable_groups.id=?;',
						
	'get_input_groups' => 'select id, name from qm_variable_groups where input_group<>0 order by name;',
	
	'get_output_groups' => 'select id, name from qm_variable_groups where input_group<>1 order by name;',
	
	
);

$grouping_options = array ("Monthly","Weekly","Daily","Hourly","Minutely");
$grouping_time_shift = array (
	"Monthly"	=>	30*24*3600*1000,
	"Weekly"	=>	 7*24*3600*1000,
	"Daily"		=>	   24*3600*1000,
	"Hourly"	=>	      3600*1000,
	"Minutely"	=>			60*1000
);

cleanall();

if (!empty($_POST['margins_check'])) {	// Check the statistical margins of the values
	print "<h2>Lets check the margins</h2>";
	$vars=get_mysql_rows(str_replace("?", (int)$_POST['margins_check'], $qrys['get_measurements']));
	$var_info=get_mysql_rows(str_replace("?", (int)$_POST['margins_check'], $qrys['var_info']));
	print "<PRE>Variable parameters:\n".print_r($var_info[0],true)."</PRE>";
	if (count($vars)<5) {
		print "There is no enough measurements to perform this analysis! The number of the values is: ".count($vars);
		footer();
		exit;
	}
	$sum=0;$min=10000;$max=-1000;
	foreach ($vars as $row) {
		$vars_values[] = $row['value'];
		$sum += $row['value'];
		if ($min>$row['value']) $min=$row['value'];
		if ($max<$row['value']) $max=$row['value'];
	}
	$average = $sum/count($vars);
	print "<p>Number of measurements: <b>".count($vars)."</b>, Sum=><b>$sum</b> , min=><b>$min</b> , max=><b>$max</b> , Average=><b>$average</b></p>";
	include_once ("/mnt/quantimodo/www/scripts/statistics.class.php");
	$stats = new Statistics($vars_values);	// Inicialize the class
    $stats->q = $stats->Find_Q();
    $stats->max = $stats->Find_Max();
    $stats->min = $stats->Find_Min();
    $stats->fx = $stats->Calculate_FX();
    $stats->mean = $stats->Find_Mean();
    $stats->median = $stats->Find_Median();
    $stats->mode = $stats->Find_Mode();
    $stats->range = $stats->Find_Range();
    $stats->iqr = $stats->Find_IQR();
    $stats->pv = $stats->Find_V('p');
    $stats->sv = $stats->Find_V('s');
    $stats->psd = $stats->Find_SD('p');
    $stats->ssd = $stats->Find_SD('s');
    $stats->XminA = $stats->Calculate_XminAvg(false);
    $stats->XminAsqr = $stats->Calculate_XminAvg(true);
    $stats->rf = $stats->Calculate_RF();
    $stats->rfp = $stats->Calculate_RFP();
    $stats->cf = $stats->Calculate_CF();

    echo "<pre>".print_r($stats,true)."</pre>";
	$top=$stats->median+$stats->mean;
	// $low=abs($stats->mean-$stats->median);
	$low=$stats->mean-$stats->median;
	if ($low<0 and $stats->min>0) $low=0;	// Put artificial lower margin
	print "<p>Conservative strategy: Top suggestion: <b>$top</b> , Low suggestion: <b>$low</b></p>";
	// prepare the graph
	$timeline_X_str='[';
	foreach ($vars as $var) $timeline_X_str .= "[".(strtotime($var['start_time_utc'])*1000).",{$var['value']}],";
	$timeline_X_str = rtrim($timeline_X_str,',').']';
?>	
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
	<script src="http://code.highcharts.com/highcharts.js"></script>
	<script > <?php include_once "/mnt/quantimodo/www/scripts/hchart_theme.js";?> </script>
<?php
	include "/mnt/quantimodo/www/scripts/hchart_margins.php";	// Chart drawing
	print $hchart;

	$top=$stats->median+$stats->psd*2;
	$low=$stats->median-$stats->psd*2;
	if ($low<0 and $stats->min>0) $low=0;	// Put artificial lower margin
	print "<p>Agressive strategy: Top suggestion: <b>$top</b> , Low suggestion: <b>$low</b></p>";
	include "/mnt/quantimodo/www/scripts/hchart_margins.php";	// Chart drawing
	print $hchart;

	footer(); exit;
}
// print "<PRE>".print_r($grouping_time_shift,true)."</PRE>"; exit;
if (!empty($_POST['get_info'])) {

// print "<p style='float: right;'><button onclick='window.close()'>Close this tab</button></p>";
// print "<PRE>".print_r($_POST,true)."</PRE>";

// Check for all_correlations
if (!empty($_POST['time_shift'])) {
	print "We are sorry to inform you that Time shifting is not yet discovered!<br>Feel free to check again tomorrow! :)";
	exit;
}

$link_form='
<form action="tony.php" method="post" target="_blank"> 
	<input type="submit" value=1:? name="get_info" />
	<input value=2:? name="3:?" style="display: none;" />
	<input value=4:? name="5:?" style="display: none;" />
</form>';

// Y var
if ($_POST['group_Y']) {	// Y is group
	if (!is_numeric($_POST['group_Y']) ) die ("The data for Y group is incorrect!");

	$rows=get_mysql_rows(str_replace("?", (int)$_POST['group_Y'], $qrys['grp_info']));
	// console_log($rows,"grp_info");
	$union_query='';	// Initialize the union query string
	if (count($rows)>0) foreach ($rows as $row) 
		$union_query .= str_replace("?:1",$row['Var_units_per']/$row['Grp_units_per'], str_replace("?:2", $row['id'], $qrys['get_measurements_union']))."\nUNION ALL\n";
	else die ("Group Y is empty, there are not even one member in it!");
	$union_query = rtrim($union_query,"\nUNION ALL\n")."\norder by start_time_utc LIMIT 40000;";
	// print "<PRE>".print_r($union_query,true)."</PRE>";  
	$y_var_info[0]=$rows[0];	// Inherit all the parameters
	$y_var_info[0]['App_name']='Grouped vars';	// various applications
	$y_vars=get_mysql_rows($union_query);
	$link_form=str_replace('2:?',$y_var_info[0]['grp_id'], $link_form);		// place the group Y number
	$link_form=str_replace('3:?','group_Y', $link_form);						// indicate group_Y
	
} else {	// Y is single variable
	if (!is_numeric($_POST['variable_Y'])) die ("The data for Y variable is incorrect!");
	// Get vars data
	$y_vars=get_mysql_rows(str_replace("?", (int)$_POST['variable_Y'], $qrys['get_measurements']));
	// Get vars info
	$y_var_info=get_mysql_rows(str_replace("?", (int)$_POST['variable_Y'], $qrys['var_info']));
	$link_form=str_replace('2:?',$y_var_info[0]['id'], $link_form);		// place the group Y number
	$link_form=str_replace('3:?','variable_Y', $link_form);						// indicate group_Y

}

include_once "/mnt/quantimodo/www/scripts/variables_grouping.php";	// Grouping functions
include_once "/mnt/quantimodo/www/scripts/Pearson_correlation.php"; // Pearson functions

// Check for all_correlations
if (!empty($_POST['all_correlations'])) {
	// Apply fixed 'Weekly' grouping 
	$grouping='Weekly';
	print "<h2>Lets see all the possible $grouping correlations under the sun!<br></h2>";
	print "<PRE>Output state parameters:\n".print_r($y_var_info[0],true)."</PRE>";
	array_to_table($y_vars,"Time,Value","Variable Y, rows => ".count($y_vars),5);
	
	// Clear zeroes if needed
	if ($y_var_info[0]['keep_zeroes'] == 0) {
		$tmp=array_filter($y_vars,"zerocheck");
		print "<p>Count of Y-elements before&after the zero trim: ".count($y_vars)."->".count($tmp)." , The number of trimmed elements is ".(count($y_vars)-count($tmp))."</p>";
		$y_vars=$tmp;
		unset($tmp);
	}
	
	if ($y_var_info[0]['summable_variable'] == 1) $y_vars_grp=avg_and_group($y_vars,$grouping);
	else $y_vars_grp=sum_and_group($y_vars,$grouping);
	reset($y_vars_grp); 	$start_date = key($y_vars_grp);
	end($y_vars_grp); 		$end_date = key($y_vars_grp);
	print "<p>Number of elements after grouping: <strong>".count($y_vars_grp)."</strong>, Starting date:<strong> $start_date</strong>, Ending date: <strong>$end_date</strong></p><hr>";

	$all_correlations=array();	$i=0;	// to keep the data about all correlations


	// Get the list of all possible input group behaviours
	$in_groups=get_mysql_rows($qrys['get_input_groups']);
	foreach ($in_groups as $in_group){
		// print "Input group => <strong>{$in_group['name']}</strong><br />";
		$rows_grp=get_mysql_rows(str_replace("?", $in_group['id'], $qrys['grp_info']));
		// print "<PRE>Input groups:\n".print_r($rows_grp,true)."</PRE>";
		// $var_str='';	// prepare the list of vars in the group
		$union_query='';	// Initialize the union query string
		if (count($rows_grp)>0) foreach ($rows_grp as $row) 
			// $var_str .= $row['id'].',';
			$union_query .= str_replace("?:1",$row['Var_units_per']/$row['Grp_units_per'], str_replace("?:2", $row['id'], $qrys['get_measurements_union']))."\nUNION ALL\n";
		// if (count($rows_grp)>0) foreach ($rows_grp as $row) $var_str .= $row['id'].',';
		else die ("Group X is empty, there are not even one member in it!");
		$union_query = rtrim($union_query,"\nUNION ALL\n")."\norder by start_time_utc LIMIT 40000;";
		$x_var_info[0]=$rows_grp[0];	// Inherit all the parameters
		$x_var_info[0]['App_name']='X_group';	// various applications
		
		// Check if the input group is same as output and skip the calculations if this is the case
		if (isset($y_var_info[0]['grp_id']) and $y_var_info[0]['grp_id']==$x_var_info[0]['grp_id']) continue;
		
		// $var_str = rtrim($var_str,",");
		// $x_vars=get_mysql_rows(str_replace("?", $var_str, $qrys['get_measurements']));
		$x_vars=get_mysql_rows($union_query);
		
		if ($x_var_info[0]['keep_zeroes'] == 0) {
			$tmp=array_filter($x_vars,"zerocheck");
			// print "<p>Count of X-elements before&after the zero trim: ".count($x_vars)."->".count($tmp)." The number of trimmed elements is ".(count($x_vars)-count($tmp))."</p>";
			$x_vars=$tmp;
			unset($tmp);
		}
		if ($x_var_info[0]['summable_variable'] == 1) $x_vars_grp=avg_and_group($x_vars,$grouping);
		else $x_vars_grp=sum_and_group($x_vars,$grouping);
		reset($x_vars_grp); 	$start_date = key($x_vars_grp);
		end($x_vars_grp); 		$end_date = key($x_vars_grp);
		// print "<p>Number of elements after grouping: <strong>".count($x_vars_grp)."</strong>, Starting date:<strong> $start_date</strong>, Ending date: <strong>$end_date</strong></p>";

		// Combine both the X & Y arrays
		$xy_vars=array_key_intersect($x_vars_grp,$y_vars_grp);   
		if (count($xy_vars)>3) {
			reset($xy_vars);	$start_date = $xy_vars[key($xy_vars)][0];
			end($xy_vars);		$end_date = $xy_vars[key($xy_vars)][0];
		} else continue;
		// {
			// $start_date = '---';
			// $end_date = '---';
		// }
		// print "<p>Number of elements after intersection: <strong>".count($xy_vars)."</strong>, Starting date:<strong> $start_date</strong>, Ending date: <strong>$end_date</strong></p>";
		$tmp_str=str_replace('1:?',"{$in_group['name']}&nbsp;(grp)", $link_form);		// place the var name
		$tmp_str=str_replace('4:?',$x_var_info[0]['grp_id'], $tmp_str);					// place the group X number
		$tmp_str=str_replace('5:?','group_X', $tmp_str);								// indicate group_X
		$all_correlations[$i]['Input']= $tmp_str;
		$all_correlations[$i]['Count']=count($xy_vars);
		// $all_correlations[$i]['Start']=$start_date;
		// $all_correlations[$i]['End']=$end_date;

		// Find the Pearson correlation!
		$pearson_correlation = Correlation($xy_vars);
		// print "<p>Pearson correlation coefficient: ".round($pearson_correlation*100,2)."% or $pearson_correlation, The significance is: **<strong>".stat_signific($pearson_correlation)."</strong>**</p><hr>";
		$all_correlations[$i]['PCC']=$pearson_correlation;
		// $all_correlations[$i]['PCC_word']=stat_signific($pearson_correlation);
		$all_correlations[$i]['PCC_percentage']=round($pearson_correlation*100,2).'%';
		$i++;
	}
	
	// Get the list of all possible input group variables
	$in_vars=get_mysql_rows($qrys['get_input_vars']);
	foreach ($in_vars as $in_var){
		// print "Input variable => <strong>{$in_var['Var_name']}</strong><br />";
		// print "<PRE>Input groups:\n".print_r($rows_grp,true)."</PRE>";
		$x_var_info=get_mysql_rows(str_replace("?", $in_var['Var_id'], $qrys['var_info']));
		// Check if the input group is same as output and skip the calculations if this is the case
		if (isset($y_var_info[0]['id']) and $y_var_info[0]['id']==$x_var_info[0]['id']) continue;

		
		$x_vars=get_mysql_rows(str_replace("?", $in_var['Var_id'], $qrys['get_measurements']));
		
		if ($x_var_info[0]['keep_zeroes'] == 0) {
			$tmp=array_filter($x_vars,"zerocheck");
			// print "<p>Count of X-elements before&after the zero trim: ".count($x_vars)."->".count($tmp)." The number of trimmed elements is ".(count($x_vars)-count($tmp))."</p>";
			$x_vars=$tmp;
			unset($tmp);
		}
		if ($x_var_info[0]['summable_variable'] == 1) $x_vars_grp=avg_and_group($x_vars,$grouping);
		else $x_vars_grp=sum_and_group($x_vars,$grouping);
		reset($x_vars_grp); 	$start_date = key($x_vars_grp);
		end($x_vars_grp); 		$end_date = key($x_vars_grp);
		// print "<p>Number of elements after grouping: <strong>".count($x_vars_grp)."</strong>, Starting date:<strong> $start_date</strong>, Ending date: <strong>$end_date</strong></p>";

		// Combine both the X & Y arrays
		$xy_vars=array_key_intersect($x_vars_grp,$y_vars_grp);   
		if (count($xy_vars)>3) {
			reset($xy_vars);	$start_date = $xy_vars[key($xy_vars)][0];
			end($xy_vars);		$end_date = $xy_vars[key($xy_vars)][0];
		} else continue;
		
		// print "<p>Number of elements after intersection: <strong>".count($xy_vars)."</strong>, Starting date:<strong> $start_date</strong>, Ending date: <strong>$end_date</strong></p>";
		$tmp_str=str_replace('1:?',$in_var['Var_name'], $link_form);		// place the var name
		$tmp_str=str_replace('4:?',$x_var_info[0]['id'], $tmp_str);			// place the var X number
		$tmp_str=str_replace('5:?','variable_X', $tmp_str);					// indicate variable_X
		$all_correlations[$i]['Input']= $tmp_str;

		// $all_correlations[$i]['Input']=$in_var['Var_name'];
		$all_correlations[$i]['Count']=count($xy_vars);
		// $all_correlations[$i]['Start']=$start_date;
		// $all_correlations[$i]['End']=$end_date;


		// Find the Pearson correlation!
		$pearson_correlation = Correlation($xy_vars);
		// print "<p>Pearson correlation coefficient: ".round($pearson_correlation*100,2)."% or $pearson_correlation, The significance is: **<strong>".stat_signific($pearson_correlation)."</strong>**</p><hr>";
		$all_correlations[$i]['PCC']=$pearson_correlation;
		// $all_correlations[$i]['PCC_word']=stat_signific($pearson_correlation);
		$all_correlations[$i]['PCC_percentage']=round($pearson_correlation*100,2).'%';
		$i++;
	}
	array_to_table($all_correlations,"Input,Number of data points,PCC,PCC_%","All_corellations in one place",1000);

//	<script > <?php include_once "/mnt/quantimodo/www/scripts/jqgrid.js"; > </script>
//	<table id="all_PCC_table"></table>
	footer(); exit;
}	// End of all_correlations

// X var
if ($_POST['group_X']) {
	if (!is_numeric($_POST['group_X']) ) die ("The data for X group is incorrect!");
	
	// $var_str='';	// prepare the list of vars in the group
	$rows=get_mysql_rows(str_replace("?", (int)$_POST['group_X'], $qrys['grp_info']));
	$union_query='';	// Initialize the union query string
	if (count($rows)>0) foreach ($rows as $row) {
		// $var_str .= $row['id'].',';
		$union_query .= str_replace("?:1",$row['Var_units_per']/$row['Grp_units_per'], str_replace("?:2", $row['id'], $qrys['get_measurements_union']))."\nUNION ALL\n";
	} else die ("Group X is empty, there are not even one member in it!");
	$union_query = rtrim($union_query,"\nUNION ALL\n")."\norder by start_time_utc LIMIT 40000;";
	$x_var_info[0]=$rows[0];	// Inherit all the parameters
	$x_var_info[0]['App_name']='Grouped vars';	// various applications
	// $var_str = rtrim($var_str,",");
	// $x_vars=get_mysql_rows(str_replace("?", $var_str, $qrys['get_measurements']));
	$x_vars=get_mysql_rows($union_query);

} else {
	if (!is_numeric($_POST['variable_X']) ) die ("The data for X variable is incorrect!");
	// Get X var data
	$x_vars=get_mysql_rows(str_replace("?", (int)$_POST['variable_X'], $qrys['get_measurements']));
	// Get X var info
	$x_var_info=get_mysql_rows(str_replace("?", (int)$_POST['variable_X'], $qrys['var_info']));
}



// print "<PRE>".print_r($x_vars,true)."</PRE>";
// print "<PRE>".print_r($y_vars,true)."</PRE>";

print "<div style='float:left; margin-right:15px;'>"; 
print "<PRE>".print_r($x_var_info[0],true)."</PRE>";
array_to_table($x_vars,"Time,Value","Variable X, rows => ".count($x_vars),50);
// print "<PRE>".print_r($x_vars[0],true)."</PRE>";
print "</div>"; 

print "<PRE> \n".print_r($y_var_info[0],true)."</PRE>";
array_to_table($y_vars,"Time,Value","Variable Y, rows => ".count($y_vars),50);
?>	
<div style='clear:both'></div>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script src="http://code.highcharts.com/highcharts.js"></script>
<script > <?php include_once "/mnt/quantimodo/www/scripts/hchart_theme.js";?> </script>

<?php
	// Remove the zeroes if we dont need them based on 'keep_zeroes' parameter
	if ($x_var_info[0]['keep_zeroes'] == 0) {
		$tmp=array_filter($x_vars,"zerocheck");
		print "<p>Count of X-elements before&after the zero trim: ".count($x_vars)."->".count($tmp)." The number of trimmed elements is ".(count($x_vars)-count($tmp))."</p>";
		$x_vars=$tmp;
		unset($tmp);
	}
	if ($y_var_info[0]['keep_zeroes'] == 0) {
		$tmp=array_filter($y_vars,"zerocheck");
		print "<p>Count of Y-elements before&after the zero trim: ".count($y_vars)."->".count($tmp)." , The number of trimmed elements is ".(count($y_vars)-count($tmp))."</p>";
		$y_vars=$tmp;
		unset($tmp);
	}
		
	foreach ($grouping_options as $grouping){
		// Apply SUM or AVG grouping based on the 'summable_variable' parameter for the variable
		if ($x_var_info[0]['summable_variable'] == 1) $x_vars_grp=avg_and_group($x_vars,$grouping);
		else $x_vars_grp=sum_and_group($x_vars,$grouping);
		if ($y_var_info[0]['summable_variable'] == 1) $y_vars_grp=avg_and_group($y_vars,$grouping);
		else $y_vars_grp=sum_and_group($y_vars,$grouping);
		
		// Find Max values for the variables after the grouping
		if (count($x_vars_grp)>0) $x_var_max=max($x_vars_grp);
		else $x_var_max=0;
		if (count($y_vars_grp)>0) $y_var_max=max($y_vars_grp);
		else $y_var_max=0;
		
		print "<hr><h4>Grouping => $grouping<h4><div style='float:left; margin-right:15px;'>"; 
		array_to_table_keys($x_vars_grp,"Time,Value","X var");
		print "<br>Max value: $x_var_max";
		print "</div><div style='float:left; margin-right:15px;'>";
		array_to_table_keys($y_vars_grp,"Time,Value","Y var");
		print "<br>Max value: $y_var_max";
		print "</div>";
		
		// Combine both the X & Y arrays
		$xy_vars=array_key_intersect($x_vars_grp,$y_vars_grp);   
		// print "<PRE>".var_dump($xy_vars)."<PRE>";
		array_to_table($xy_vars,"Time, X, Y","XY pairs",50);
		print "<div style='clear:both'></div>";

		// Find the Pearson correlation!
		$pearson_correlation = Correlation($xy_vars);
		print "<p id='PCC-$grouping'>Pearson correlation coefficient: ".round($pearson_correlation*100,2)."% or $pearson_correlation, The significance is: ***".stat_signific($pearson_correlation)."***</p>";
		// prepare the scater-plot data in hchart format
		$scatter_str='[';
		foreach ($xy_vars as $row) $scatter_str .= "[{$row[1]},{$row[2]}],";
		$scatter_str = rtrim($scatter_str,",")."]";

		// prepare the timeline data in hchart format
		// $timeline_X_str='[[10000,10],[20000,20],[30000,30],[40000,40],[50000,50]]';
		$timeline_X_str='[';
		foreach ($x_vars_grp as $key=>$value) $timeline_X_str .= "[".(strtotime(str_replace('-Week-','W',$key))*1000).",{$value}],";	// Replace -Week- with W for proper conversion
		$timeline_X_str = rtrim($timeline_X_str,',').']';
		// $timeline_Y_str='[[100000,100],[200000,200],[300000,300],[400000,400],[500000,500]]';
		$timeline_Y_str='[';
		foreach ($y_vars_grp as $key=>$value) $timeline_Y_str .= "[".(strtotime(str_replace('-Week-','W',$key))*1000).",{$value}],";
		$timeline_Y_str = rtrim($timeline_Y_str,',').']';
		
		
		include "/mnt/quantimodo/www/scripts/hchart.php";	// Chart drawing
		print $hchart;
	}
footer(); exit;
}

$margins_form='<form action="tony.php" method="post" target="_blank"> <input type="submit" value=? name="margins_check"> </form>';
$rows=get_mysql_rows($qrys['general_info']);
foreach ($rows as $key=>$row) $rows[$key]['Var_id'] = str_replace("?",$row['Var_id'],$margins_form);?>
<button onclick="if (document.getElementById('big_table').style.display=='block') document.getElementById('big_table').style.display='none'; else document.getElementById('big_table').style.display='block';">Show/hide the variables details table</button>
<div id="big_table" style="display: none">
<?php array_to_table($rows,"Category,Application name,Variable name,Count of measurements,Owner,Var_id","General QM database population info",1000); ?>
</div>

<?php
$input_vars=get_mysql_rows($qrys['get_input_vars']);
$output_vars=get_mysql_rows($qrys['get_output_vars']);
$var_groups=get_mysql_rows($qrys['var_groups']);
$var_input_groups=get_mysql_rows($qrys['get_input_groups']);
$var_output_groups=get_mysql_rows($qrys['get_output_groups']);
?>
<hr><br /><br />
<form action="tony.php" method="post" target="_blank" style="background-color:GreenYellow; width:700px">
<p style="text-align:center; padding-top:15px;">Simple form to graph the variables</p>
<p>
  Start Date: <input type="date" name="start_date" value="1999-12-31" >
  End Date: <input type="date" name="end_date" value="<?php echo date('Y-m-d', strtotime(date('Y/m/d'))); ?>" >
  &nbsp&nbsp Granularity: 
	<select name="Granularity">
		<option>Minutely</option>
		<option>Hourly</option>
		<option selected>Daily</option>
		<option>Monthly</option>
	</select>
</p>
<p><fieldset><legend>Normal variables:</legend>
	Input variable:
	<select name="variable_X">
		<?php foreach ($input_vars as $option) print "<option value='".$option['Var_id']."'>".$option['Var_category']." => ".$option['App_name']." => ".$option['Var_name']."</option>";?>
	</select>
	<br />Output state:&nbsp&nbsp
	<select name="variable_Y">
		<?php foreach ($output_vars as $option) print "<option value='".$option['Var_id']."'>".$option['Var_category']." => ".$option['App_name']." => ".$option['Var_name']."</option>";?>
	</select>
  </fieldset>
  <br /><br />
  <fieldset>
	<legend>Variables grouping:</legend>
	Input group:&nbsp&nbsp
	<select name="group_X">
		<option value="0" selected> --- </option>
		<?php foreach ($var_input_groups as $option) print "<option value='{$option['id']}'>{$option['name']}</option>";?>
	</select>
	<br />Output group:
	<select name="group_Y">
		<option value="0" selected> --- </option>
		<?php foreach ($var_output_groups as $option) print "<option value='{$option['id']}'>{$option['name']}</option>";?>
	</select>
  </fieldset>
  <br />
  <fieldset>
	<legend>Extras:</legend>
	<input type="checkbox" name="all_correlations" value="1">Give me all possible correlations! I want to know everything under the sun!<br />
<!---	<input type="checkbox" name="time_shift" value="1">I want to see the time shift! I want to travel in time!<br /> --->
  </fieldset>
</p>

<p style="text-align: center;  padding-bottom:15px;">
  <input type="submit" value="Be nice and give me the info!" name="get_info">
</p>
</form>

<hr><br />

<p>The following groups of variables are available:</p>

<?php 
array_to_table($var_groups,"Group, Category,Application,Variable,Var. Unit,Grp. Unit,Input,Averagable,Zeroes,Var_id","Groups of variables");
footer(); 

//print '<PRE>'.print_r($var_input_groups,true).'</PRE>';
//print '<PRE>'.print_r($var_output_groups,true).'</PRE>';
?>


