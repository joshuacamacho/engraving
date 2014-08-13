<?php
	require_once("connect.php");
	if(isset($_SESSION['userid'])){
		unset($_SESSION['userid']);
	}
	header("Location: ./");
?>