<?php
	
	//Instantiate Variables For Connection
	$mysql_host = "localhost";
    $mysql_database = "shoutout_cms";
    $mysql_user = "root";
    $mysql_password = "";

	//Instantiate Connection Towards Database
	mysql_connect($mysql_host, $mysql_user, $mysql_password) or die("Unable To Connect");\
	mysql_select_db($mysql_database) or die("Could not select database.");

?>