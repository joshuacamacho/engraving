<?php
	require_once("connect.php");
	if(!(isset($_SESSION['userid']))){
		header("Location: index.php");
	}
	include("header.php");
	echo "<div id='content'><div id='content_left'>";
	$userid=$_SESSION['userid'];

		if( isset($_POST['itemid']) && isset($_POST['quantity']) &&isset($_POST['engravetext'])){
			$itemid=htmlentities(mysqli_real_escape_string($link,$_POST['itemid']));
			$quantity=htmlentities(mysqli_real_escape_string($link,$_POST['quantity']));
			$text=$_POST['engravetext'];
			echo $text;
			$query="INSERT INTO cart (itemid,quantity,userid,text) VALUES ('".$itemid."','".$quantity."','".$userid."','".$text."')";
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
				echo "<h2>".$itemrow['name']."</h2>";
				echo "<img src='images/".$itemrow['pictureurl']."' width='60px'>";
				echo "<h3>" .$itemrow['description']. "</h3>";
				echo "<div class='otext'>".$row['text']."</div>";
				echo "Quantity: ".$row['quantity']." ";
				echo "Total Cost= $".sprintf('%01.2f', ($itemrow['price']*$row['quantity']));
				$grandtotal+=$itemrow['price']*$row['quantity'];
				
			}
			$cartid=$row['cartid'];
			echo "<form action='cart.php' method='post'>
							<input type='hidden' name='cartid' value='".$cartid."'>
							<input type='submit' value='Delete Item'>
							</form>
						";
			echo "</div>";
			echo "<hr />";
		}
		$result=$link->query("SELECT COUNT(cartid) FROM cart WHERE userid='".$userid."'");
		$row=mysqli_fetch_row($result);
		if($row[0]==0){
			echo "Your shopping cart is empty.";
			echo "</div></div>";
		}else{
			echo "Grandtotal = $".sprintf('%01.2f', $grandtotal);
			echo "<h3><a href='checkout.php'>Proceed to checkout</a></h3>";
			echo "</div></div>";
		}
		include("footer.php");
?>