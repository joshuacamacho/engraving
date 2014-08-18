<?php
	require_once("connect.php");
	if(!(isset($_SESSION['userid']))){
		header("Location: index.php");
	}
	include("header.php");
	echo "<div class='cartcontainer'>";
	$userid=$_SESSION['userid'];

		if( isset($_POST['itemid']) && isset($_POST['quantity']) ){
			$itemid=htmlentities(mysqli_real_escape_string($link,$_POST['itemid']));
			$quantity=htmlentities(mysqli_real_escape_string($link,$_POST['quantity']));
			$query="INSERT INTO cart (itemid,quantity,userid) VALUES ('".$itemid."','".$quantity."','".$userid."')";
			$result=$link->query($query);
			echo "Item added to cart";
		}
		if( isset($_POST['cartid'])) {
			$cartid=$_POST['cartid'];
			$query="DELETE FROM cart WHERE cartid='".$cartid."'";
			$result=$link->query($query);
		}
		$grandtotal=0;
		$query="SELECT * FROM cart WHERE userid='".$userid."'";
		$result=$link->query($query);
		while($row=mysqli_fetch_array($result)){
			$itemid=$row['itemid'];
			$itemquery="SELECT * FROM items WHERE itemid='".$itemid."'";
			$itemresult=$link->query($itemquery);
			while($itemrow=mysqli_fetch_array($itemresult)){
				echo "<div class='shoppingcartitem'>";
				echo "<p>".$itemrow['name']."</p>";
				echo "<img src='img/".$itemrow['pictureurl']."' width='60px'>";
				echo $itemrow['description'];
				echo "Quantity: ".$row['quantity']." ";
				echo "Total Cost= ".$itemrow['price']*$row['quantity'];
				$grandtotal+=$itemrow['price']*$row['quantity'];
				echo "</div>";
			}
			$cartid=$row['cartid'];
			echo "<form action='cart.php' method='post'>
							<input type='hidden' name='cartid' value='".$cartid."'>
							<input type='submit' value='Delete Item'>
							</form>
						";

		}
		$result=$link->query("SELECT COUNT(cartid) FROM cart WHERE userid='".$userid."'");
		$row=mysqli_fetch_row($result);
		if($row[0]==0){
			echo "Your shopping cart is empty.";
		}else{
			echo "Grandtotal = ".$grandtotal;
			echo "<h2><a href='checkout.php'>Proceed to checkout</a></h2>";
			echo "</div>";
		}
?>