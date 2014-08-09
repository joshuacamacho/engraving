<?php
	$username = "engraving";
	$password = "engraving7777";
	$hostname = "209.129.8.4"; 
	$db = "engraving";

	$link = mysqli_connect($hostname,$username,$password,$db) or die("Error " . mysqli_error($link)); 
	//echo "Connection to DB complete";
	
?>