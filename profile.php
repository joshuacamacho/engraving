<?php
	require_once("connect.php");
	if(isset($_SESSION['userid']) && !empty($_SESSION['userid'])){
		echo "all good userid = ".$_SESSION['userid'];
	}else{
		 die("No login");
	}
	$userid=$_SESSION['userid'];
	include("header.php");
	//show user info
	echo "<div class='profilecontainer'>";
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
		echo "<h3>Email<h3><h1>".$row['email']."</h1>";
	}

	//show orders
	echo "<table><tr>";
  echo "<td>Order ID</td>";
	echo "<td>Item Name</td>";
	echo "<td>Description</td>";
	echo "<td>Quantitiy</td>";
	echo "<td>Order Total</td>";
	echo "<td>Date Placed</td>";
	echo "<td>Status</td>";
	$result = $link->query("SELECT * FROM orders WHERE userid=$userid");
	while($row=mysqli_fetch_array($result)){
		echo "<tr>";
		echo "<td>".$row['orderid']."</td>";
		//give item description
		$item=$row['itemid'];
		$status=$row['status'];
		$orderid=$row['orderid'];
		$result2 = $link->query("SELECT * FROM items WHERE itemid=$item");
		while($row2 = mysqli_fetch_assoc($result2)){
			echo "<td>".$row2['name']."</td>";
			echo "<td>".$row2['description']."</td>";
			//order quantity + price
			echo "<td>".$row['quantity']."</td>";//qt
			echo "<td>$".sprintf('%01.2f', ($row['quantity']*$row2['price']) )."</td>";//price
		}
		//order date
		echo "<td>";
		echo $row['timeordered'];
		echo "</td>";

		echo "<td>".$row['status']."</td>";
		echo "</tr>";
	}
		echo "</table>";

	echo "</div>";



?>