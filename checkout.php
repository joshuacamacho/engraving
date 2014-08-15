<?php
	require_once("connect.php");
	if(!(isset($_SESSION['userid']) ) ){
		header("Location: ./");
	}

	include("header.php");
	echo "<div class='checkoutcontainer'>";
	$userid=$_SESSION['userid'];
	$query="SELECT * FROM cart WHERE userid='".$userid."'";
	$result=$link->query($query);
	if(isset($_POST['placeorder'])&& $_POST['placeorder']=='true'){
		//if the order has been submitted
		while($row=mysqli_fetch_array($result)){
			$itemid=$row['itemid'];
			$quantity=$row['quantity'];
			$date= date("Y-m-d H:i:s");
			$orderquery="INSERT INTO orders (userid,itemid,quantity,timeordered,status) VALUES ('".$userid."','".$itemid."','".$quantity."','".$date."','Ordered')";
			$orderresult=$link->query($orderquery);
			if(!$orderresult){
				die(mysql_error());
			}
			
		}
		echo "order complete";
		$deleteresult=$link->query("DELETE FROM cart WHERE userid='".$userid."'");
	}else{
		//before submitting order
		$grandtotal=0;
		//display shopping cart contents
		
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
				echo "</div>";
				//calculate grand total
				$grandtotal+=$itemrow['price']*$row['quantity'];
			}
			
			
			
			}
			echo "Grandtotal ".$grandtotal;
			echo "<form action='' method='POST'>
						<input type='submit' value='Place Order'>
						<input type='hidden' name='placeorder' value='true'>
						</form>
						";
		}

		echo "</div>";
?>