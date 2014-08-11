<?php
	require_once("connect.php");
	if(isset($_SESSION['userid']) && !empty($_SESSION['userid'])){
		echo "all good userid = ".$_SESSION['userid'];
	}else{
		 die("No login");
	}
	
?>