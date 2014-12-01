<?php
	require_once('../connect.php');
	require_once("../core.php");
	if(isAdmin()){
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

		<div id="dashmiddle" <?php if(isset($_GET['mode']))echo "class='middleset'"?>>
			<?php
				
				if(isset($_GET['mode'])){
					if($_GET['mode']=='users' ){
						displayUsers($link);
					}else	if($_GET['mode']=='catalog'){

						displayCatalog($link);
					}
			}
					
				
				
			?>

		</div>

		<div id="dashright">
			<?php
				//user mode right side
			
				if( isset($_GET['mode']) && $_GET['mode']=='users' && isset($_GET['id']) ){
						$userid=$_GET['id'];
						printorders($userid,$link);
					
					
								//catalog item manangement
				}else if(isset($_GET['mode']) && $_GET['mode']=='catalog' && isset($_GET['id']) ){

						$itemid=htmlentities(mysqli_real_escape_string($link,$_GET['id']));
						
					//for deleting items
					if(isset($_POST['deleteditem'])){
						$query="UPDATE items SET deleted='1' WHERE itemid='".$itemid."'";
						$delete=$link->query($query);
						echo "<script>window.location.replace('./?mode=catalog');</script>";
					}
						
					//for updating item picture

					if(isset($_POST['picturename']) && !empty($_POST['picturename'])){
						
						$url=htmlentities(mysqli_real_escape_string($link,$_POST['picturename']));
						
						    $query="UPDATE items SET pictureurl='".$url."' WHERE itemid='".$itemid."'";
							$result=$link->query($query);
								
						

					}


					//for updating item details
						if( (isset($_POST['name']) || isset($_POST['description']) || isset($_POST['price']))
							&& ( (!empty($_POST['name'])) || (!empty($_POST['description'])) || (!empty($_POST['price'])))
						  ){
							if(isset($_POST['name']) && (!empty($_POST['name']))) {
								$name=htmlentities(mysqli_real_escape_string($link,$_POST['name']));
							}
							if(isset($_POST['description']) &&(!empty($_POST['description']))){
								$description=htmlentities(mysqli_real_escape_string($link,$_POST['description']));
							} 
							if(isset($_POST['price']) &&(!empty($_POST['price']))){
								$price=htmlentities(mysqli_real_escape_string($link,$_POST['price']));
							}
							$query="UPDATE items SET ";
							if(isset($name)) $query.="name='".$name."'";
							if(isset($name) && isset($description)) $query.=",";
							if(isset($description)) $query.="description='".$description."'";
							if( (isset($price) && isset($description)) || (isset($price)&& isset($name))  ) $query.=",";
							if(isset($price)) $query.="price='".$price."'";
							

							$query.=" WHERE itemid='".$itemid."'";

								
				
							 
							$update = $link->query($query);

						
							}//end name/description/price update

							//for changing stock level POST
							if(isset($_POST['stocklevel'])){
								$itemid=htmlentities(mysqli_real_escape_string($link,$_GET['id']));
								$level=$_POST['stocklevel'];
								$query="UPDATE items SET stocklevel='".$level."', stocklevel='No longer sold' WHERE itemid='".$itemid."'";
								$result=$link->query($query);
							}

						echo "<h3>Catalog Item</h3>";
						$itemid=htmlentities(mysqli_real_escape_string($link,$_GET['id']));
						$query="SELECT name,description,price,pictureurl,stocklevel FROM items WHERE itemid='".$itemid."'";
						$result=$link->query($query);
						while($row=mysqli_fetch_array($result)){
							echo "<h1>".$row['name']."</h1>";
							echo "<div class='catalogitemcontainer'><div><img src='../images/".$row['pictureurl']."'>";
							echo "<form action='./?mode=catalog&id=".$itemid."' method='post'>
							
							<input name='picturename' type='text' value='".$row['pictureurl']."'>
							<input type='submit' value='Update Picture Name'></form></div>";



							echo "<div><form action='./?mode=catalog&id=".$itemid."' method='post'>
										<h2>Item Name</h2><input type='text' name='name' value='".$row['name']."'>
										<h2>Description</h2><textarea name='description'>".$row['description']."</textarea>";
							echo "<h2>Price</h2>$<input type='text' name='price' value='".sprintf('%01.2f', $row['price'])."'>
										<input type='submit' value='Update Item'></form>
										</div></div>
										
									";

						
						

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
						
						echo "
							<form action='./?mode=catalog&id=".$itemid."' method='post'>
								<input type='checkbox' name='deleteditem' value='true'>Deletes cannot be undone. To delete item check this box and submit.
								<input type='submit' value='Delete Item'>
								
							</form>				
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
						& isset($_POST['picturename'])
						&& !empty($_POST['picturename'])
						){

						

						$pictureurl=mysqli_real_escape_string($link,htmlentities($_POST['picturename']));
						$name=mysqli_real_escape_string($link,htmlentities($_POST['itemname']));
						$description=mysqli_real_escape_string($link,htmlentities($_POST['itemdescription']));
						$price=mysqli_real_escape_string($link,htmlentities($_POST['itemprice']));
						$query="INSERT INTO items (name,description,price,pictureurl) VALUES ('".$name."','".$description."','".$price."','".$pictureurl."')";
						$result=$link->query($query);

					echo "<script>
						window.location.replace('./?mode=catalog');
						
						</script>";
						

					}else{
						echo "<h3>ADD NEW CATALOG ITEM</h3>";
						echo "<form enctype='multipart/form-data' action='./?mode=catalog&add=new' method='post'>";
						echo "<h2>Item Name</h2>
									<input type='text' name='itemname'>
									<h2>Description</h2>
									<textarea name='itemdescription'></textarea>
									<h2>Price</h2>
									<input type='text' name='itemprice'>
									<h2>Picture Name</h2>
									";
						echo '<input name="picturename" type="text" /><br />';
					 	echo "<input type='submit'>";
						echo "</form>";
					}
				}//end catalog add mode
						
					
			?>
		</div>

	</div>
</body>

</html>
