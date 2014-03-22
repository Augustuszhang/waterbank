<?php
	date_default_timezone_set('America/New_York');
	$today = date('Y-m-d');
	$tomorrow_timestamp = mktime(0,0,0,date("m"),date("d")+1,date("Y"));
	$tomorrow  = date("Y-m-d", $tomorrow_timestamp);
	$deadLine = date("H");
?>