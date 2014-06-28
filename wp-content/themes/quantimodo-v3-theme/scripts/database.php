<?php
define('DB_HOST','localhost');
define('DB_USER','quantimodo');
define('DB_PASS','PDNZCF7bv7CDX5D6');
define('DB_DATABASE','quantimodo');

function get_mysql_rows($query) {
    $rows=array();
    $mylink = mysql_connect(DB_HOST, DB_USER, DB_PASS) or die("Could not connect to server!\n");
    mysql_select_db(DB_DATABASE, $mylink) or die("Could not select database");
	// $query=mysql_real_escape_string($query,$mylink);
	$result = mysql_query($query,$mylink) or die ("Query failed:`$query` =>". mysql_error()."\n");
    if (is_bool($result)) {
        mysql_close($mylink);
        return $result;
    }
    while ($row=mysql_fetch_assoc($result)) $rows[]=$row;
    mysql_free_result($result);
    mysql_close($mylink);
    return $rows;
}

function insert_data_mysql ($query) {
    $mylink = mysql_connect(DB_HOST, DB_USER, DB_PASS) or die("Could not connect to server!\n");
    mysql_select_db(DB_DATABASE, $mylink) or die("Could not select database");
	if (mysql_query($query,$mylink)) $i=mysql_affected_rows();
	else print "Query failed:`$query` =>". mysql_error()."\n";
    mysql_close($mylink);
	return $i;
}


?>