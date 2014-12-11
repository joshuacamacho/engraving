<?php
	require_once("connect.php");
	if(!(isset($_SESSION['userid']) ) ){
		header("Location: ./");
	}

	include("header.php");
	echo "<div id='content'>";
	$userid=$_SESSION['userid'];
	$query="SELECT * FROM cart WHERE userid='".$userid."'";
	$result=$link->query($query);
	if(isset($_POST['placeorder'])&& $_POST['placeorder']=='true'){
		//if the order has been submitted
		while($row=mysqli_fetch_array($result)){
			$query="SELECT * FROM items where itemid='".$row['itemid']."'";
			$itemresult=$link->query($query);
			$iteminfo=mysqli_fetch_array($itemresult);
			$itemid=$row['itemid'];
			$quantity=$row['quantity'];
			$date= date("Y-m-d H:i:s");
			$text=$row['text'];
			$totalprice=$row['quantity']*$iteminfo['price'];
			$orderquery="INSERT INTO orders (userid,itemid,quantity,timeordered,status,text,totalprice) VALUES ('".$userid."','".$itemid."','".$quantity."','".$date."','Ordered','".$text."','".$totalprice."')";
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
				echo "<h2>".$itemrow['name']."</h2>";
				echo "<img src='images/".$itemrow['pictureurl']."'>";
				echo "<h3>" .$itemrow['description']. "</h3>";
				echo "<div class='otext'>".$row['text']."</div>";
				echo " Quantity: ".$row['quantity']." ";
				echo "Price $".sprintf('%01.2f', ($itemrow['price']*$row['quantity']));
				echo "</div>";
				//calculate grand total
				$grandtotal+=$itemrow['price']*$row['quantity'];
			}
			
			echo "<hr />";
			
			}
			echo "Grandtotal $".sprintf('%01.2f', $grandtotal);
			echo "<form action='' method='POST'>
						<input type='submit' value='Place Order'>
						<input type='hidden' name='placeorder' value='true'>
						</form>
						";
		}

		echo "</div>";
		include("footer.php");
?>