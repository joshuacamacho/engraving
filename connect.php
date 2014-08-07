<?php
	$username = "engraving";
	$password = "engraving7777";
	$hostname = "209.129.8.4"; 

	//connection to the database
	$dbhandle = mysql_connect($hostname, $username, $password) 
	 or die("Unable to connect to MySQL");
	//echo "Connected to MySQL<br>";

	//select a database to work with
	$selected = mysql_select_db("engraving",$dbhandle) 
	  or die("Could not select db");
	//echo "Connected to DB";
?>