<?php
	$link = mysql_connect('localhost', 'yuanzhe', 'Aa2267892227');
	if (!$link) {
		die('Not connected : ' . mysql_error());
		}
	$db_selected = mysql_select_db('data', $link);
	if (!$db_selected) {
		die ('Can\'t use foo : ' . mysql_error());
		}
?>