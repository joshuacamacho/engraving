<?php
	require_once("connect.php");
	if(isset($_SESSION['userid']) && !empty($_SESSION['userid'])){
		
	}else{
		 header("Location: ./");
	}
	$userid=$_SESSION['userid'];
	include("header.php");
	//show user info
	echo "<div id='content' class='profilecontainer'>";
	echo "<h3>Name</h3>";
	$query="SELECT firstname,lastname,email FROM users WHERE userid='".$userid."'";
	$result=$link->query($query);
	/*if (!$result) {
    $message  = 'Invalid query: ' . mysql_error() . "\n";
    $message .= 'Whole query: ' . $query;
    die($message);
		}*/
	while($row=mysqli_fetch_array($result)){
		echo "<h1>".$row['firstname']." ".$row['lastname']."</h1>";
		echo "<h3>Email</h3><h1>".$row['email']."</h1>";
	}

	//show orders
	printorders($userid,$link);

	echo "</div>";
	include("footer.php");


?>