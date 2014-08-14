<?php
	include("header.php");
	require_once("connect.php");
	echo "<div class='catalogcontainer'>";
	//get is set, display only one item
	if(isset($_GET['itemid'])&& !empty($_GET['itemid'])){
		$itemid=mysqli_real_escape_string($link,$_GET['itemid']);
		$query="SELECT name,description,pictureurl,price,stocklevel FROM items WHERE itemid='".$itemid."'";
		$result=$link->query($query);
		while($row=mysqli_fetch_array($result)){
			echo "<h3>".$row['name']."</h3>
						<img src='img/".$row['pictureurl']."'>
						<p>".$row['description']."</p>
						<p>$".$row['price']." per unit</p>";
			if(isset($_SESSION['userid']) && ($row['stocklevel']=='In Stock')){
				echo "Stock Level: ".$row['stocklevel']."					
							<form action='cart.php' method='post'>
							Quantity<select>
								<option>10</option>
								<option>20</option>
								<option>3000</option>
								</select>
								<input type='submit' value='Add to cart'>
							</form>
				";
			}else if(isset($_SESSION['userid']) && $row['stocklevel']=='Sold Out'){
				echo "This item is currently out of stock.";
			}else if(isset($_SESSION['userid']) && $row['stocklevel']=='No longer sold'){
				echo "This item is no longer sold";
			}
	}
	}else{//no get set display full catalog
		$query="SELECT * FROM items";
		$result=$link->query($query);
		while($row=mysqli_fetch_array($result)){
			if($row['stocklevel']!='No longer sold'){
				echo "<div class='itemcontainer'>
							<a href='catalog.php?itemid=".$row['itemid']."'>
							<img src='img/".$row['pictureurl']."' width='150px'></a>
							<h3>Item Name</h3>
							<h1>".$row['name']."</h1>
							<h5>".$row['description']."
							<h5>".$row['price']."</h5>
				";
			}	
		}
	}
	echo "</div>";
?>