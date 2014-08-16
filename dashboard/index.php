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
	<script src="../js/jquery-1.11.1.min.js"></script>
<script src="../js/site.js"></script>
<link rel="stylesheet" type="text/css" href="../css/style.css">
<title>Dashboard Home</title>
</head>

<body>
	<div class="dashboard">

		<div id="dashleft">
			<h1><a href="../dashboard">Dashboard</a></h1>
				<a href="../dashboard/?mode=users"><div <?php if(isset($_GET['mode'])&& $_GET['mode']=='users')echo "class='bgblue'";?> >Customers</div></a>
				<a href="../dashboard/?mode=catalog"><div <?php if(isset($_GET['mode'])&& $_GET['mode']=='catalog')echo "class='bgblue'";?> >Catalog</div></a>
				<a href="../logout.php"><div>Logout</div></a>
		</div>

		<div id="dashmiddle">
			<?php
			
				if(isset($_GET['mode'])){
					if($_GET['mode']=='users' ){
						
						//pagination
						$query="SELECT COUNT(userid) FROM users";
						$result=$link->query($query);
						$row=mysqli_fetch_row($result);
						//total row count
						$rows=$row[0];
						//the number of results displayed per page
						$page_rows = 20;
						// this is the page number of our last page
						$last=ceil($rows/$page_rows);
						// makes sure last cannot be less than one
						if($last<1) $last= 1;
						// establish $pagenum
						$pagenum = 1;
						// get pagenum from URL vars if it is present, else its = 1
						if(isset($_GET['pn'])){
							$pagenum = preg_replace('#[^0-9]#','',$_GET['pn']);
						}
						// this makes sure pagenum isnt below 1 or more than our $last page
						if($pagenum<1){
							$pagenum = 1;
						}else if ($pagenum > $last){
							$pagenum = $last;
						}
						$limit = 'LIMIT ' .($pagenum - 1) * $page_rows .',' .$page_rows;

						

						$querya="SELECT * FROM users $limit";
						$result = $link->query($querya);

						$paginationCtrls = '';
						// if there is more than one page of results
						if($last != 1){
							if( $pagenum > 1 ){
								$previous = $pagenum - 1;
								$paginationCtrls.="<a href='./?mode=users&pn=".$previous."'><div><</div></a>";
								for($i = $pagenum - 3; $i < $pagenum; $i++){
									if($i > 0){
										$paginationCtrls.="<a href='./?mode=users&pn=".$i."'><div>".$i."</div></a>";
									}
								}
							}
						}
						$paginationCtrls .= '<div><span>'.$pagenum.'</span></div>';
						// Render clickable number links that should appear on the right of the target page number
						for($i = $pagenum+1; $i <= $last; $i++){
							$paginationCtrls .= '<a href="./?mode=users&pn='.$i.'"><div>'.$i.'</div></a>';
							if($i >= $pagenum+3){
								break;
							}
						}
						// This does the same as above, only checking if we are on the last page, and then generating the "Next"
					    if ($pagenum != $last) {
					        $next = $pagenum + 1;
					        $paginationCtrls .= '<a href="./?mode=users&pn='.$next.'"><div>></div></a>';
					    }


						echo "<h1><span>Customers</span></h1>";
						echo "<form action='' method='POST'>
										<input type='text' name='searchname'>
										<input type='submit' value='Search'>
									</form>
									";
						echo "<div class='pagination'>".$paginationCtrls."</div>";
						echo "<div class='middlelist'>";
						while( $row = mysqli_fetch_array($result) ){
							
							echo "<a href='./?mode=users&pn=".$pagenum."&id="
							.$row['userid']."'><div";
							if(isset($_GET['id'])&& $row['userid']==$_GET['id'])echo " class='borderleft'";
							echo ">".$row['firstname']." ".$row['lastname'];
							echo"</div></a>";
							
						}
						echo "</div>";
					}else	if($_GET['mode']=='catalog'){
							$query="SELECT * FROM items";
							$result=$link->query($query);

							echo "<h1><a href='./?mode=catalog&add=new'>Add New</a></h1>";
							echo "<div class='middlelist'>";
							while($row=mysqli_fetch_array($result)){
								echo "<a href='.?mode=catalog&id=".$row['itemid']."'><div";
								if(isset($_GET['id'])&& $row['itemid']==$_GET['id'])echo " class='borderleft'";
								echo ">".$row['name'];
								echo "</div></a>";
							}
							echo "</div>";
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
					echo "<div class='rightlist'>";							
					echo "<h1>";
					echo $row['firstname']." ".$row['lastname'];
					echo "</h1>";
					echo "<table><tr>";
					echo "<td>Email</td><td>".$row['email']."</td> </tr><tr>";
					echo "<td>Joined</td><td>".$row['datejoined']."</td>";
				}

					echo "</table>";
					echo "<h2>Orders</h2>";
					echo "<table>";
					echo "<tr>";
					echo "<td>Order ID</td>";
					echo "<td>Item Name</td>";
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
						$item=$row['itemid'];
						$status=$row['status'];
						$orderid=$row['orderid'];

						if($orderidupdate==$orderid) echo "<tr class='updated'><td colspan='7'> Updated Order &darr; </td></tr>";
						echo "<tr>";
						echo "<td>".$row['orderid']."</td>";
						//give item description
						
						$resultb = $link->query("SELECT * FROM items WHERE itemid='".$item."'");
						
						while($rowb = mysqli_fetch_assoc($resultb)){
							echo "<td><a target='blank' href='../catalog.php?itemid=".$item."'>".$rowb['name']."</a></td>";
							
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
						echo "<td><form method='post' action='./?mode=users&pn=".$pagenum."&id=".$id."'><select name='status'>";
						echo "<option selected='selected' value='".$status."'>".$status."</option>";
						foreach($updatevalues as $val){
							echo "<option value='".$val."'>".$val."</option>";
						}
						echo "</select><input type='hidden' name='orderid' value='".$orderid."'</td>";
						echo "<td><input type='submit' value='Update'>";
						
						echo "</td>";
						echo "</form>";
						echo "</tr>";
						
					}

					echo "</table>";
					echo "</div>";
					
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

						
							}//end name/description/price update

							//for changing stock level POST
							if(isset($_POST['stocklevel'])){
								$itemid=mysqli_real_escape_string($link,$_GET['id']);
								$level=$_POST['stocklevel'];
								$query="UPDATE items SET stocklevel='".$level."' WHERE itemid='".$itemid."'";
								$result=$link->query($query);
							}

						echo "<h3>Catalog Item</h3>";
						$itemid=mysqli_real_escape_string($link,$_GET['id']);
						$query="SELECT name,description,price,pictureurl,stocklevel FROM items WHERE itemid='".$itemid."'";
						$result=$link->query($query);
						while($row=mysqli_fetch_array($result)){
							echo "<h1>".$row['name']."</h1>";
							echo "<h3>Picture</h3><img src='../img/".$row['pictureurl']."'>";
							echo "<h3>Description</h3><h1>".$row['description']."</h1>";
							echo "<h3>Price</h3><h1>$".sprintf('%01.2f', $row['price'])."</h1>";

						
						echo "<form action='./?mode=catalog&id=".$itemid."' method='post'>
									<label>Item Name</label>
									<input type='text' name='name'>
									<label>Item Description</label>
									<textarea name='description'></textarea>
									<label>Item Price</label>
									<input type='text' name='price'>
									<input type='submit'>
									</form>";

						echo "<h3>Stock Level</h3>
									<form action='./?mode=catalog&id=".$itemid."' method='post'>
									<select name='stocklevel'>
									<option value='".
									$row['stocklevel']."'>".$row['stocklevel']."</option>
									<option value='In Stock'>In Stock</option>
									<option value='Sold Out'>Sold Out</option>
									<option value='No longer sold'>No longer sold</option>
									</select>
									<input type='submit' value='Update'>";
						if(isset($_POST['stocklevel'])) echo "UPDATED";
						echo "
									</form>
									<ul>
									<li>In Stock - Shows in catalog and allows users to order</li>
									<li>Sold Out - Shows in catalog but users cannot order</li>
									<li>No longer sold - Does not show in catalog and users cannot order</li>
								</ul>
						";
					}

				}else if(isset($_GET['mode']) && $_GET['mode']=='catalog' && isset($_GET['add'])){
					//add new item to catalog if add new item form was used

					if(isset($_POST['itemname']) 
						&& !empty($_POST['itemname']) 
						&& isset($_POST['itemdescription'])
						&& !empty($_POST['itemdescription'])
						&& isset($_POST['itemprice'])
						&& !empty($_POST['itemprice'])
						){
						$name=mysql_real_escape_string(htmlentities($_POST['itemname']));
						$description=mysql_real_escape_string(htmlentities($_POST['itemdescription']));
						$price=mysql_real_escape_string(htmlentities($_POST['itemprice']));
						$query="INSERT INTO items (name,description,price) VALUES ('".$name."','".$description."','".$price."')";
						$result=$link->query($query);

						
						

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
						echo "</form>
						";
					}
				}//end catalog add mode
						
					
			?>
		</div>

	</div>
</body>

</html>