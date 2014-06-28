<?php
date_default_timezone_set("UTC");
error_reporting(E_ALL);
$start=microtime(true);

require_once __DIR__.'/Galahad/MailChimp/Synchronizer/Array.php';
require_once __DIR__.'/MailChimp/MCAPI.class.php';
require_once __DIR__.'/../database.php';

function footer(){
	global $start;
	print "\n\nTimestamp: ".date('Y-m-d H:i:s').", Script: ".basename($_SERVER['PHP_SELF']).", Time used: ".(microtime(true)-$start)." sec. , Memory used: ".memory_usage()."\n"; 
}
function memory_usage() { 
    $mem_usage = memory_get_usage(true); 
    if ($mem_usage < 1024) return $mem_usage." bytes"; 
	elseif ($mem_usage < 1048576) return round($mem_usage/1024,2)."k"; 
	else return round($mem_usage/1048576,2)."MB"; 
} 

$apiKey = '424440093e007a16e61ee84278ae988c-us5';
$list = '40bea8f52b'; 	// Quantimodo list ID

$users=get_mysql_rows("select email as EMAIL, firstname as FNAME, lastname as LNAME from Guest order by id;");
print "Sync ".count($users)." users to Quantimodo MailChimp list\n";
$Synchronizer = new Galahad_MailChimp_Synchronizer_Array($apiKey, $users);
$Synchronizer->sync($list);
print "Done! \n";

footer();
?>