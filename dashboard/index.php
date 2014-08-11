<?php
	session_start();
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
				<li <?php if(isset($_GET['mode'])&& $_GET['mode']=='users')echo "class='bgblue'";?> ><a href="../dashboard/?mode=users">Users</a></li>
				<li <?php if(isset($_GET['mode'])&& $_GET['mode']=='catalog')echo "class='bgblue'";?> ><a href="../dashboard/?mode=catalog">Catalog</a></li>
			</ul>
		</div>

		<div id="dashmiddle">
			<?php
				if(isset($_GET['mode'])){
					if($_GET['mode']=='users' ){
						require_once('../connect.php');
						$query1="SELECT * FROM users";
						$result = $link->query($query1);

						echo "<h1>Userlist</h1>";
						
						while($row = mysqli_fetch_array($result)){
							echo "<a href='./?mode=users&id="
							.$row['userid']."'><div";
							if(isset($_GET['id'])&& $row['userid']==$_GET['id'])echo " class='borderleft'";
							echo ">".$row['firstname']." ".$row['lastname'];
							echo"</div></a>";
						}
						
					}
				}
			?>
		</div>

		<div id="dashright">
			<?php
				if(isset($_GET['mode']) && $_GET['mode']=='users' && isset($_GET['id']) ){
						
							
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
									$result2 = $link->query("SELECT * FROM items WHERE itemid=$item");
									while($row2 = mysqli_fetch_assoc($result2)){
										echo "<td>".$row2['description']."</td>";
										//order quantity + price
										echo "<td>".$row['quantity']."</td>";//qt
										echo "<td>$".sprintf('%01.2f', ($row['quantity']*$row2['price']) )."</td>";//price
									}
									//order date
									echo "<td>";
									echo $row['timeordered'];
									echo "</td>";

									//order status update form
									$updatevalues=[
									"Ordered",
									"Processed",
									"Shipped"
									];
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
							}
						
					
			?>
		</div>

	</div>
</body>

</html>