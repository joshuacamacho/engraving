<?php
	session_start();
	$username = "engraving";
	$password = "engraving7777";
	$hostname = "209.129.8.4"; 
	$db = "engraving";

	$link = mysqli_connect($hostname,$username,$password,$db) or die("Error " . mysqli_error($link)); 
	//echo "Connection to DB complete";
	


	function printorders($userid,$link){
		//pagination
		$query="SELECT COUNT(orderid) FROM orders WHERE userid='".$userid."'";
		$addon='';
		if(isset($_POST['searchorder'])){
		  $search=htmlentities(mysqli_real_escape_string($link,$_POST['searchname']));
		  $search=explode(" ", $search);
		  //echo "<pre>".print_r($search)."</pre>";
		  if(count($search)==1){
		    $addon.=" WHERE firstname='".$search[0]."' OR lastname='".$search[0]."'";
		    
		  }else if(count($search==2)){
		    $addon.=" WHERE firstname='".$search[0]."'";
		    $addon.="AND lastname='".$search[1]."'";
		  }
		  $query.=$addon;
		  //echo $query;
		}
		$result=$link->query($query);
		$row=mysqli_fetch_row($result);
		//total row count
		$rows=$row[0];
		//the number of results displayed per page
		$page_rows = 10;
		// this is the page number of our last page
		$last=ceil($rows/$page_rows);
		// makes sure last cannot be less than one
		if($last<1) $last= 1;
		// establish $pagenum
		$pagenum = 1;
		// get pagenum from URL vars if it is present, else its = 1
		if(isset($_GET['orderpn'])){
			$pagenum = preg_replace('#[^0-9]#','',$_GET['orderpn']);
		}
		// this makes sure pagenum isnt below 1 or more than our $last page
		if($pagenum<1){
			$pagenum = 1;
		}else if ($pagenum > $last){
			$pagenum = $last;
		}
		$limit = 'LIMIT ' .($pagenum - 1) * $page_rows .',' .$page_rows;

		

		$querya="SELECT * FROM orders WHERE userid='".$userid."' ".$addon." $limit";
		$result = $link->query($querya);

		$paginationCtrls = '';
		// if there is more than one page of results
		if($last != 1){
			if( $pagenum > 1 ){
				$previous = $pagenum - 1;
				if(onDashboard())
					$paginationCtrls.="<a href='./?mode=users&pn=".$_GET['pn']."&id=".$_GET['id']."&orderpn=".$previous."'><div><</div></a>";
				else
					$paginationCtrls.="<a href='./profile.php?orderpn=".$previous."'><div><</div></a>";
				for($i = $pagenum - 3; $i < $pagenum; $i++){
					if($i > 0){
						if(onDashboard())
							$paginationCtrls.="<a href='./?mode=users&pn=".$_GET['pn']."&id=".$_GET['id']."&orderpn=".$i."'><div>".$i."</div></a>";
						else
							$paginationCtrls.="<a href='./profile.php?orderpn=".$i."'><div>".$i."</div></a>";
					}
				}
			}
		}
		$paginationCtrls .= '<div><span>'.$pagenum.'</span></div>';
		// Render clickable number links that should appear on the right of the target page number
		for($i = $pagenum+1; $i <= $last; $i++){
			if(onDashboard())
				$paginationCtrls .= '<a href="./?mode=users&pn='.$_GET['pn'].'&id='.$_GET['id'].'&orderpn='.$i.'"><div>'.$i.'</div></a>';
			else
				$paginationCtrls .= '<a href="./profile.php?orderpn='.$i.'"><div>'.$i.'</div></a>';
			if($i >= $pagenum+3){
				break;
			}
		}
		// This does the same as above, only checking if we are on the last page, and then generating the "Next"
	    if ($pagenum != $last) {
	        $next = $pagenum + 1;
	        if(onDashboard())
	        	$paginationCtrls .= '<a href="./?mode=users&pn='.$_GET['pn'].'&id='.$_GET['id'].'&orderpn='.$next.'"><div>></div></a>';
	        else
	        	$paginationCtrls .= '<a href="./profile.php?orderpn='.$next.'"><div>></div></a>';
	    }


		if(onDashboard()){
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
					echo "<td>Joined</td><td>".$row['datejoined']."</td></table>";
					echo "<h2>Orders</h2>";
				}




		}
			//show orders

		echo "<div class='pagination'>".$paginationCtrls."</div>";
		echo "<table class='ordertable'><tr>";
	  echo "<td>Order ID</td>";
	  echo "<td>Order Page</td>";
		echo "<td>Item Name</td>";
		
		echo "<td>Enscription Text</td>";
		echo "<td>Quantitiy</td>";
		echo "<td>Order Total</td>";
		echo "<td>Date Placed</td>";
		echo "<td>Status</td>";
		if(onDashboard())echo "<td> </td>";


		if(onDashboard()){
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

		}



		$result = $link->query("SELECT * FROM orders WHERE userid=$userid ORDER BY timeordered DESC $limit");
		while($row=mysqli_fetch_array($result)){
			$item=$row['itemid'];
			$status=$row['status'];
			$orderid=$row['orderid'];
			echo "<div class='ordertext".$row['orderid']." ordertext'>".$row['text']."<p>Click to Close</p></div>";
			if(onDashboard() && $orderidupdate==$orderid) echo "<tr class='updated'><td colspan='9'> Updated Order &darr; </td></tr>";
			echo "<tr>";
			echo "<td>".$row['orderid']."</td>";
			if(onDashboard())echo "<td><a href='../orderpage?order=".$orderid."'>Order Page</a></td>";
			else echo "<td><a href='../orderpage?order=".$orderid."'>Order Page</a></td>";
			//give item description
			
			$result2 = $link->query("SELECT * FROM items WHERE itemid=$item");
			while($row2 = mysqli_fetch_assoc($result2)){
				echo "<td>".$row2['name']."</td>";
				
				echo "<td><a class='order".$row['orderid']." showorder'>Click to See</a></td>";
				
				//order quantity + price
				echo "<td>".$row['quantity']."</td>";//qt
				echo "<td>$".sprintf('%01.2f', ($row['quantity']*$row2['price']) )."</td>";//price
			}//end second while loop
			//order date
			echo "<td>";
			echo $row['timeordered'];
			echo "</td>";

	if(onDashboard()){
		$updatevalues=array(
				"Ordered",
				"Processed",
				"Shipped"
				);
				$pagenum=$_GET['pn'];
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
			}else{

				echo "<td>".$row['status']."</td>";
				echo "</tr>";
			}
		}//end first while loop
			echo "</table>";
			if(onDashboard())
				echo "</div>";
	}//end printorders function


	function loggedin(){
		$in=false;
		if(isset($_SESSION['userid']) && !empty($_SESSION['userid'])){
			$in=true;
		}
		return $in;
	}

	function isAdmin(){
		$admin=false;
		if(isset($_SESSION['userid']) && $_SESSION['userid']==1){
			$admin=true;
		}
		return $admin;
	}

	function onDashboard(){
		$dash=false;
		if (preg_match("/dashboard/", $_SERVER['REQUEST_URI'])) {
			$dash=true;
		}
		return $dash;
	}

	function displayUsers($link){
		//if search has been used
		//pagination
		$query="SELECT COUNT(userid) FROM users";
		$addon='';
		if(isset($_POST['searchname'])){
		  $search=htmlentities(mysqli_real_escape_string($link,$_POST['searchname']));
		  $search=explode(" ", $search);
		  //echo "<pre>".print_r($search)."</pre>";
		  if(count($search)==1){
		    $addon.=" WHERE firstname='".$search[0]."' OR lastname='".$search[0]."' OR email='".$search[0]."' OR userid='".$search[0]."'";
		    
		  }else if(count($search==2)){
		    $addon.=" WHERE firstname='".$search[0]."'";
		    $addon.="AND lastname='".$search[1]."'";
		  }
		  $query.=$addon;
		  //echo $query;
		}
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

		

		$querya="SELECT * FROM users".$addon." $limit";
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
		echo "<form action='./?mode=users' method='POST'>
						<input type='text' name='searchname'>
						<input id='submit' type='submit' value='Search'>
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
	}

	function displayCatalog($link){
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
?>