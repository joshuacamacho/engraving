<?php
	require_once('../connect.php');
	
	if(isset($_SESSION['userid']) && $_SESSION['userid']==1){
		//echo "all good";
		//all good
	}else{
		header("Location: ../admin.php");
	}
	
?>

<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" type="text/css" href="../css/style.css">
<title>Dashboard Home</title>
</head>

<body>
	<div class="dashboard">

		<div id="dashleft">
			<h1><a href="../dashboard">Dashboard</a></h1>
			<ul>
				<li <?php if(isset($_GET['mode'])&& $_GET['mode']=='users')echo "class='bgblue'";?> ><a href="../dashboard/?mode=users">Customers</a></li>
				<li <?php if(isset($_GET['mode'])&& $_GET['mode']=='catalog')echo "class='bgblue'";?> ><a href="../dashboard/?mode=catalog">Catalog</a></li>
			</ul>
		</div>

		<div id="dashmiddle">
			<?php
			
				if(isset($_GET['mode'])){
					if($_GET['mode']=='users' ){
						
						$querya="SELECT * FROM users";
						$result = $link->query($querya);

						echo "<h1>Customers</h1>";
						
						while( $row = mysqli_fetch_array($result) ){
							
							echo "<a href='./?mode=users&id="
							.$row['userid']."'><div";
							if(isset($_GET['id'])&& $row['userid']==$_GET['id'])echo " class='borderleft'";
							echo ">".$row['firstname']." ".$row['lastname'];
							echo"</div></a>";
							
						}
					}else	if($_GET['mode']=='catalog'){
							$query="SELECT * FROM items";
							$result=$link->query($query);

							echo "<h1><a href='./?mode=catalog&add=new'>Add New</a></h1>";
							while($row=mysqli_fetch_array($result)){
								echo "<a href='.?mode=catalog&id=".$row['itemid']."'><div";
								if(isset($_GET['id'])&& $row['itemid']==$_GET['id'])echo " class='borderleft'";
								echo ">".$row['name'];
								echo "</div></a>";
							}
							
						}
			    

						
			}
					
				
				
			?>

		</div>

		<div id="dashright">
			<?php
				//user mode right side
			
				if( isset($_GET['mode']) && $_GET['mode']=='users' && isset($_GET['id']) ){
						
				
				$orderidupdate="";
				require_once('../connect.php');
				$id=mysqli_real_escape_string($link,$_GET['id']);
				//get basic user data
				$result = $link->query("SELECT * FROM users WHERE userid=$id");
				while($row = mysqli_fetch_array($result)){
					echo "<h3>Customer</h3>";							
					echo "<h1>";
					echo $row['firstname']." ".$row['lastname'];
					echo "</h1>";
					echo "<table><tr>";
					echo "<td>Email</td><td>".$row['email']."</td> </tr><tr>";
					echo "<td>Date Joined</td><td>".$row['datejoined']."</td>";
				}

					echo "</table>";
					echo "<h2>Orders</h2>";
					echo "<table>";
					echo "<tr>";
					echo "<td>Order ID</td>";
					echo "<td>Item Name</td>";
					echo "<td>Description</td>";
					echo "<td>Quantitiy</td>";
					echo "<td>Order Total</td>";
					echo "<td>Date Placed</td>";
					echo "<td>Status</td>";
				

				//for updating order status
					if(isset($_POST['status'])){
						
						$statusupdate=$_POST['status'];
						$orderidupdate=$_POST['orderid'];

						$query="UPDATE orders SET status='".$statusupdate."' WHERE orderid=$orderidupdate";
						$update = $link->query($query);

						if (!$update) {
						    $message  = 'Invalid query: ' . mysql_error() . "\n";
						    $message .= 'Whole query: ' . $query;
						    die($message);
						  }

						  
						  //print_r($_POST['status']);
						//echo "<h1>WORKED". print_r($statusupdate)."</h1>";
					}

					//get orders
					$result = $link->query("SELECT * FROM orders WHERE userid=$id");
					while($row = mysqli_fetch_array($result)){

						echo "<tr>";
						echo "<td>".$row['orderid']."</td>";
						//give item description
						$item=$row['itemid'];
						$status=$row['status'];
						$orderid=$row['orderid'];
						$resultb = $link->query("SELECT * FROM items WHERE itemid='".$item."'");
						
						while($rowb = mysqli_fetch_assoc($resultb)){
							echo "<td>".$rowb['name']."</td>";
							echo "<td>".$rowb['description']."</td>";
							//order quantity + price
							echo "<td>".$row['quantity']."</td>";//qt
							echo "<td>$".sprintf('%01.2f', ($row['quantity']*$rowb['price']) )."</td>";//price
						}

						//order date
						echo "<td>";
						echo $row['timeordered'];
						echo "</td>";

						//order status update form
						$updatevalues=array(
						"Ordered",
						"Processed",
						"Shipped"
						);
						echo "<td><form method='post' action='./?mode=users&id=".$id."'><select name='status'>";
						echo "<option selected='selected' value='".$status."'>".$status."</option>";
						foreach($updatevalues as $val){
							echo "<option value='".$val."'>".$val."</option>";
						}
						echo "</select><input type='hidden' name='orderid' value='".$orderid."'</td>";
						echo "<td><input type='submit' value='Update'>";
						if($orderidupdate==$orderid) echo " UPDATED!";
						echo "</td>";
						echo "</form>";
						echo "</tr>";
						
					}

					echo "</ul>";
					
								//catalog item manangement
				}else if(isset($_GET['mode']) && $_GET['mode']=='catalog' && isset($_GET['id']) ){

						$itemid=mysqli_real_escape_string($link,$_GET['id']);
					//for updating item details
						if( (isset($_POST['name']) || isset($_POST['description']) || isset($_POST['price']))
							&& ( (!empty($_POST['name'])) || (!empty($_POST['description'])) || (!empty($_POST['price'])))
						  ){
							if(isset($_POST['name']) && (!empty($_POST['name']))) {
								$name=mysqli_real_escape_string($link,$_POST['name']);
							}
							if(isset($_POST['description']) &&(!empty($_POST['description']))){
								$description=mysqli_real_escape_string($link,$_POST['description']);
							} 
							if(isset($_POST['price']) &&(!empty($_POST['price']))){
								$price=mysqli_real_escape_string($link,$_POST['price']);
							}
							$query="UPDATE items SET ";
							if(isset($name)) $query.="name='".$name."'";
							if(isset($name) && isset($description)) $query.=",";
							if(isset($description)) $query.="description='".$description."'";
							if( (isset($price) && isset($description)) || (isset($price)&& isset($name))  ) $query.=",";
							if(isset($price)) $query.="price='".$price."'";
							

							$query.=" WHERE itemid='".$itemid."'";

								echo $query;
				
							 
							$update = $link->query($query);

							if (!$update) {
							    $message  = 'Invalid query: ' . mysql_error() . "\n";
							    $message .= 'Whole query: ' . $query;
							    die($message);
							  }
							  //print_r($_POST['status']);
							//echo "<h1>WORKED". print_r($statusupdate)."</h1>";
						
							}


						echo "<h3>Catalog Item</h3>";
						$itemid=$_GET['id'];
						$query="SELECT name,description,price FROM items WHERE itemid='".$itemid."'";
						$result=$link->query($query);
						while($row=mysqli_fetch_array($result)){
							echo "<h1>".$row['name']."</h1>";
							echo "<h3>Description</h3><h1>".$row['description']."</h1>";
							echo "<h3>Price</h3><h1>$".sprintf('%01.2f', $row['price'])."</h1>";

						}
						echo "<form action='./?mode=catalog&id=".$itemid."' method='post'>
									<label>Item Name</label>
									<input type='text' name='name'>
									<label>Item Description</label>
									<textarea name='description'></textarea>
									<label>Item Price</label>
									<input type='text' name='price'>
									<input type='submit'>
									</form>";
				}else if(isset($_GET['mode']) && $_GET['mode']=='catalog' && isset($_GET['add'])){


					if(isset($_POST['itemname']) 
						&& !empty($_POST['itemname']) 
						&& isset($_POST['itemdescription'])
						&& !empty($_POST['itemdescription'])
						&& isset($_POST['itemprice'])
						&& !empty($_POST['itemprice'])
						){
						$name=mysql_real_escape_string($_POST['itemname']);
						$description=mysql_real_escape_string($_POST['itemdescription']);
						$price=mysql_real_escape_string($_POST['itemprice']);
						$query="INSERT INTO items (name,description,price) VALUES ('".$name."','".$description."','".$price."')";
						$result=$link->query($query);

						if (!$result) {
							    $message  = 'Invalid query: ' . mysql_error() . "\n";
							    $message .= 'Whole query: ' . $query;
							    die($message);
							  }
						

					}else{
						echo "<h3>ADD NEW CATALOG ITEM</h3>";
						echo "<form action='./?mode=catalog&add=new' method='post'>";
						echo "<h1>Item Name</h1>
									<input type=text name='itemname'>
									<h1>Description</h1>
									<textarea name='itemdescription'></textarea>
									<h1>Price</h1>
									<input type='text' name='itemprice'>
									<input type='submit'>";
						echo "</form>";
					}
				}//end catalog add mode
						
					
			?>
		</div>

	</div>
</body>

</html>